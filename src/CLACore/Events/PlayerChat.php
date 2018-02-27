<?php

declare(strict_types=1);

namespace CLACore\Events;

use CLACore\Commands\StaffChat;
use CLACore\Loader;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat as C;

class PlayerChat implements Listener {

    private $plugin;

    public function __construct(Loader $plugin){
        $this->plugin = $plugin;
    }

    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        $msg = $event->getMessage();
        if (in_array($player->getName(), $this->plugin->staffchat)){
            $event->setCancelled(true);
            foreach ($this->plugin->getServer()->getOnlinePlayers() as $players){
                if ($players->hasPermission("clacore.command.staffchat")){
                    $players->sendMessage(C::RED.$player->getName().C::DARK_GRAY." -> ".C::YELLOW.$msg);
                }
            }
        }
    }
}