<?php

namespace CLACore\Events;

use CLACore\Loader;
use pocketmine\event\Listener;

abstract class EventListener implements Listener {

    public function __construct(Loader $plugin) {
    }
}