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
use pocketmine\Player;

class StaffChatCommand extends BaseCommand{

    private $plugin;

    public function __construct(Loader $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin, "staffchat", "Chat with Staff members", "/staffchat", ["sc"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if($sender instanceof Player){
            if($sender->hasPermission("clacore.command.staffchat")){
                if(!in_array($sender->getName(), $this->plugin->staffchat)){
                    $this->plugin->staffchat[] = $sender->getName();
                    $enabled = $this->plugin->langcfg->get("staffchat.enabled");
                    $sender->sendMessage("$enabled");
                }else{
                    unset($this->plugin->staffchat[array_search($sender->getName(), $this->plugin->staffchat)]);
                    $disabled = $this->plugin->langcfg->get("staffchat.disabled");
                    $sender->sendMessage("$disabled");
                }
            }
        }
        return true;
    }
}