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

use CLACore\Loader;
use pocketmine\Player;

class Feed extends BaseCommand {

    private $plugin;

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
        parent::__construct($plugin, "feed", "Feed someone or yourself", "/feed <player>", ["feed"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender->hasPermission("clacore.command.feed")) {
            $nopermission = $this->plugin->langcfg->get("no.permission");
            $sender->sendMessage("$nopermission");
            return true;
        }

        if ((!isset($args[0]) && !$sender instanceof Player) || count($args) > 1) {
            $sender->sendMessage("Usage: /feed <player>");
            return true;
        }

        $player = $sender;
        if (isset($args[0]) && !($player = $this->getPlugin()->getServer()->getPlayer($args[0]))) {
            $playernotfound = $this->plugin->langcfg->get("player.not.found");
            $sender->sendMessage("$playernotfound");
            return true;
        }

        if ($player->getName() !== $sender->getName() && !$sender->hasPermission("clacore.command.feed.other")) {
            $nopermission = $this->plugin->langcfg->get("no.permission");
            $sender->sendMessage("$nopermission");
            return true;
        }

        #player fed
        $playerfed = $this->plugin->langcfg->get("player.fed");

        #sender fed
        $senderfed = $this->plugin->langcfg->get("sender.fed");
        $senderfed = str_replace("{player}", $player->getName(), $senderfed);

        $player->setFood(20);
        $player->sendMessage("$playerfed");

        if ($player !== $sender) {
            $sender->sendMessage("$senderfed");
        }

        return true;
    }
}