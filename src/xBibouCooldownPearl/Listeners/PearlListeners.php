<?php

namespace xBibouCooldownPearl\Listeners;

use pocketmine\event\Listener;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\entity\projectile\EnderPearl;
use pocketmine\player\Player;
use xBibouCooldownPearl\Main;

class PearlListeners implements Listener
{
    private array $cooldowns = [];
    public function onProjectileLaunch(ProjectileLaunchEvent $event): void
    {
        $projectile = $event->getEntity();
        if ($projectile instanceof EnderPearl) {
            $player = $projectile->getOwningEntity();
            if ($player instanceof Player) {
                $cooldown = Main::getInstance()->getConfig()->get("cooldown");
                $playerName = $player->getName();
                if (!isset($this->cooldowns[$playerName]) || $this->cooldowns[$playerName] <= microtime(true)) {
                    $this->cooldowns[$playerName] = microtime(true) + $cooldown;
                } else {
                    $msg = Main::getInstance()->getConfig()->get("msg");
                    $remainingTime = ceil($this->cooldowns[$playerName] - microtime(true));
                    $player->sendMessage(str_replace("{time}",$remainingTime,$msg));
                    $projectile->kill();
                    $event->cancel();
                }
            }
        }
    }
}