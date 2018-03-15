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

use CLACore\Loader;

use pocketmine\command\CommandSender;
use pocketmine\entity\Effect;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class VanishCommand extends BaseCommand{

    private $plugin;

    public function __construct(Loader $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin, "vanish", "Vanish so no one can see you", "/vanish <player>", ["vanish"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if(!$sender->hasPermission("clacore.command.vanish")){
            $nopermission = $this->plugin->langcfg->get("no.permission");
            $sender->sendMessage("$nopermission");
            return false;
        }

        if((!isset($args[0]) && !$sender instanceof Player) || count($args) > 1){
            $sender->sendMessage("Usage: /vanish <player>");
            return false;
        }

        $player = $sender;
        if(isset($args[0]) && !($player = $this->getPlugin()->getServer()->getPlayer($args[0]))){
            $playernotfound = $this->plugin->langcfg->get("player.not.found");
            $sender->sendMessage("$playernotfound");
            return false;
        }

        if($player->getName() !== $sender->getName() && !$sender->hasPermission("clacore.command.vanish.other")){
            $nopermission = $this->plugin->langcfg->get("no.permission");
            $sender->sendMessage("$nopermission");
            return false;
        }

        $playervanished = $this->plugin->langcfg->get("player.vanished");
        $sendervanished = $this->plugin->langcfg->get("sender.vanished");
        $sendervanished = str_replace("{player}", $player->getName(), $sendervanished);

        if(!$player->hasEffect(14)){
            $effect = Effect::getEffect(14);
            $effect->setDuration(100000000);
            $effect->setAmplifier(1);
            $effect->setVisible(false);
            $player->addEffect($effect);
            $player->sendMessage($playervanished);
        }else{
            $effect = Effect::getEffect(14);
            $effect->setDuration(0);
            $effect->setAmplifier(2);
            $effect->setVisible(false);
            $player->addEffect($effect);
            $player->sendMessage(TextFormat::RED . "You have now un vanished");
        }

        if($player !== $sender){
            $player->sendMessage($sendervanished);
        }
        return true;
    }
}