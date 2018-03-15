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

namespace CLACore;

use CLACore\Events\PlayerChat;
use CLACore\Commands\CommandManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\{
    Config, TextFormat
};

class Loader extends PluginBase{

    public $prefix = "
      _____ _               _____
     / ____| |        /\   / ____|
    | |    | |       /  \ | |     ___  _ __ ___
    | |    | |      / /\ \| |    / _ \| '__/ _ \
    | |____| |____ / ____ \ |____ (_) | | |  __/
     \_____|______/_/    \_\_____\___/|_|  \___|
     ";

    private static $instance;

    public $language;
    public $cfg;
    public $langcfg;
    public $languagename;
    public $loggerservername;
    public $loggerlanguage;

    public $staffchat = array();

    public static function getInstance() : Loader{
        return self::$instance;
    }

    public function onEnable() : void{
        $this->registerConfig();
        $this->registerManager();
        $this->registerEvents();

        self::$instance = $this;

        $this->loggerservername = TextFormat::YELLOW . "\n" . "MOTD: " . TextFormat::AQUA . $this->getServer()->getNetwork()->getName();
        $this->loggerlanguage = TextFormat::YELLOW . "\n" . "Language: " . TextFormat::AQUA . $this->languagename;
        $this->getLogger()->info(TextFormat::GREEN . "Loaded" . TextFormat::AQUA . $this->prefix . $this->loggerservername . $this->loggerlanguage);
    }

    private function registerConfig() : void{
        @mkdir($this->getDataFolder());

        $this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        $this->language = $this->cfg->get("language");
        $this->saveResource("lang/{$this->language}.yml");
        $this->langcfg = new Config($this->getDataFolder() . "lang/{$this->language}.yml", Config::YAML);
        $this->languagename = $this->langcfg->get("language.name");
    }

    public function registerManager() : CommandManager{
        $cmdmngr = new CommandManager($this);
        return $cmdmngr;
    }

    private function registerEvents() : void{
        $plmngr = $this->getServer()->getPluginManager();
        $plmngr->registerEvents(new PlayerChat($this), $this);
    }

    public function onDisable() : void{
        $this->getLogger()->info(TextFormat::RED . "Disabled" . TextFormat::AQUA . $this->prefix . $this->loggerservername . $this->loggerlanguage);
    }
}