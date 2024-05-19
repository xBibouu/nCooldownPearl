<?php

namespace xBibouCooldownPearl;

use pocketmine\plugin\PluginBase;
use xBibouCooldownPearl\Listeners\PearlListeners;

class Main extends PluginBase{

    public static Main $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new PearlListeners(),$this);
        $this->saveDefaultConfig();
    }
    public static function getInstance(): Main
    {
        return self::$instance;
    }
}