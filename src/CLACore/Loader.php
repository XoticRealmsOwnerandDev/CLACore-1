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
use pocketmine\utils\{Config, TextFormat as C};

class Loader extends PluginBase{

	public $prefix = "
   _____ _               _____               
  / ____| |        /\   / ____|              
 | |    | |       /  \ | |     ___  _ __ ___ 
 | |    | |      / /\ \| |    / _ \| '__/ _ \
 | |____| |____ / ____ \ |____ (_) | | |  __/
  \_____|______/_/    \_\_____\___/|_|  \___|";

    public function onEnable(){
    	$this->RegisterConfig();

    	#logger
    	$this->loggerservername = C::YELLOW."\nServer Name: ".C::AQUA.$this->getServer()->getNetwork()->getName();
    	$this->loggerlanguage = C::YELLOW."\nLanguage: ".C::AQUA.$this->languagename;
    	$this->getLogger()->info(C::GREEN."Loaded".C::AQUA.$this->prefix.$this->loggerservername.$this->loggerlanguage);
    }

    public function onDisable(){
    	$this->getLogger()->info(C::RED."Disabled".C::AQUA.$this->prefix.$this->loggerservername.$this->loggerlanguage);
    }

    public function RegisterConfig(){
    	@mkdir($this->getDataFolder());

    	$this->saveResource("config.yml");
    	$this->cfg = new Config($this->getDataFolder()."config.yml", Config::YAML);

    	#Language
    	$this->language = $this->cfg->get("language");
    	$this->saveResource("lang/$this->language.yml");
    	$this->langcfg = new Config($this->getDataFolder()."lang/$this->language.yml", Config::YAML);
    	$this->languagename = $this->langcfg->get("language.name");
    }
}