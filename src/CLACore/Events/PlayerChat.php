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

namespace CLACore\Events;

use CLACore\Loader;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat as C;

class PlayerChat extends EventListener{

    private $plugin;

    public function __construct(Loader $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }

    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        $msg = $event->getMessage();
        if(in_array($player->getName(), $this->plugin->staffchat)){
            $event->setCancelled(true);
            foreach($this->plugin->getServer()->getOnlinePlayers() as $players){
                if($players->hasPermission("clacore.command.staffchat")){
                    $players->sendMessage(C::RED . "StaffChatCommand" . C::DARK_GRAY . " | " . C::BLUE . $player->getName() . C::GRAY . " -> " . C::YELLOW . $msg);
                }
            }
        }
    }
}