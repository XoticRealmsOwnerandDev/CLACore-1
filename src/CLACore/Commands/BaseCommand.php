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
use pocketmine\command\{
    Command, CommandSender, PluginIdentifiableCommand
};
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\plugin\Plugin;

class BaseCommand extends Command implements PluginIdentifiableCommand{

    private $plugin;

    public function __construct(Loader $plugin, $name, $description, $usageMessage, $aliases){
        $this->plugin = $plugin;
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function getPlugin() : Plugin{
        return $this->plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if(!$this->plugin->isEnabled()){
            return false;
        }

        if(!$this->testPermission($sender)){
            return false;
        }

        $success = $this->plugin->onCommand($sender, $this, $commandLabel, $args);
        if(!$success and $this->usageMessage !== ""){
            throw new InvalidCommandSyntaxException();
        }
        return $success;
    }
}