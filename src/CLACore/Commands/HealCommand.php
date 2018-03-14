<?php
/*
 * CLACore, a public core with many features for PocketMine-MP
 * Copyright (C) 2017-2018 CLADevs
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY;  without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
*/
declare(strict_types=1);

namespace CLACore\Commands;

use pocketmine\command\CommandSender;
use pocketmine\event\entity\EntityRegainHealthEvent;
use CLACore\Loader;
use pocketmine\Player;

class HealCommand extends BaseCommand{

    private $plugin;

    public function __construct(Loader $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin, "heal", "Heal someone or yourself", "/heal <player>", ["heal"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if(!$sender->hasPermission("clacore.command.heal")){
            $nopermission = $this->plugin->langcfg->get("no.permission");
            $sender->sendMessage("$nopermission");
            return false;
        }

        if((!isset($args[0]) && !$sender instanceof Player) || count($args) > 1){
            $sender->sendMessage("Usage: /heal <player>");
            return false;
        }

        $player = $sender;
        if(isset($args[0]) && !($player = $this->getPlugin()->getServer()->getPlayer($args[0]))){
            $playernotfound = $this->plugin->langcfg->get("player.not.found");
            $sender->sendMessage("$playernotfound");
            return false;
        }

        if($player->getName() !== $sender->getName() && !$sender->hasPermission("clacore.command.heal.other")){
            $nopermission = $this->plugin->langcfg->get("no.permission");
            $sender->sendMessage("$nopermission");
            return false;
        }

        $playerhealed = $this->plugin->langcfg->get("player.healed");

        $senderhealed = $this->plugin->langcfg->get("sender.healed");
        $senderhealed = str_replace("{player}", $player->getName(), $senderhealed);

        $player->heal(new EntityRegainHealthEvent($player, $player->getMaxHealth() - $player->getHealth(), EntityRegainHealthEvent::CAUSE_CUSTOM));
        $player->sendMessage("$playerhealed");

        if($player !== $sender){
            $sender->sendMessage("$senderhealed");
        }

        return true;
    }
}