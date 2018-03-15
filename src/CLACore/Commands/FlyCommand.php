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

class FlyCommand extends BaseCommand{

    private $plugin;

    public function __construct(Loader $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin, "fly", "Survival mode flight", "/fly", ["fly"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if(!$sender->hasPermission("clacore.command.fly")){
            $nopermission = $this->plugin->langcfg->get("no.permission");
            $sender->sendMessage("$nopermission");
            return false;
        }

        if((!isset($args[0]) && !$sender instanceof Player) || count($args) > 1){
            $sender->sendMessage("Usage: /fly");
            return false;
        }

        $flightmodeon = $this->plugin->langcfg->get("flightmode.on");
        $flightmodeoff = $this->plugin->langcfg->get("flightmode.off");

        if(!$sender->getAllowFlight()){
            $sender->setFlying(true);
            $sender->setAllowFlight(true);
            $sender->sendMessage($flightmodeon);
        }else{
            $sender->setFlying(false);
            $sender->setAllowFlight(false);
            $sender->sendMessage($flightmodeoff);
        }
        return true;
    }
}