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

 namespace CLACore;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;

class Loader extends PluginBase{

	public $prefix = "
   _____ _               _____               
  / ____| |        /\   / ____|              
 | |    | |       /  \ | |     ___  _ __ ___ 
 | |    | |      / /\ \| |    / _ \| '__/ _ \
 | |____| |____ / ____ \ |____ (_) | | |  __/
  \_____|______/_/    \_\_____\___/|_|  \___|";

    public function onEnable(){
    	$this->getLogger()->info(C::GREEN."Loaded".C::AQUA.$this->prefix);
    }

    public function onDisable(){
    	$this->getLogger()->info(C::RED."Disabled".C::AQUA.$this->prefix);
    }
}