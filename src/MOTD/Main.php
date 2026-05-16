<?php

namespace MOTD;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;

class Main extends PluginBase {

    private $startTime;

    public function onEnable(){
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();

        $this->startTime = time();

        $this->getServer()->getScheduler()->scheduleRepeatingTask(
            new MotdTask($this),
            20
        );
    }

    public function updateMotd(){
        $this->getServer()->getNetwork()->setName($this->getFormattedMotd());
    }

    public function getFormattedMotd(){
        $config = $this->getConfig();
        $uptime = $this->getUptime();

        $line1 = str_replace("{uptime}", $uptime, $config->get("line1"));
        $line2 = $config->get("line2");

        return $line1 . "\n" . $line2;
    }

    public function getUptime(){
        $seconds = time() - $this->startTime;

        $days = floor($seconds / 86400);
        $seconds %= 86400;

        $hours = floor($seconds / 3600);
        $seconds %= 3600;

        $minutes = floor($seconds / 60);
        $seconds %= 60;

        $result = "";

        if($days > 0) $result .= $days . "d ";
        if($hours > 0) $result .= $hours . "hr ";
        if($minutes > 0) $result .= $minutes . "min ";
        $result .= $seconds . "sec";

        return trim($result);
    }
}