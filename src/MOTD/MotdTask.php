<?php

namespace MOTD;

use pocketmine\scheduler\PluginTask;

class MotdTask extends PluginTask {

    public function __construct(Main $plugin){
        parent::__construct($plugin);
    }

    public function onRun($currentTick){
        $this->getOwner()->updateMotd();
    }
}