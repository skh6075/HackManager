<?php


namespace skh6075\HackManager\listener\handleAttack;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\Player;

use skh6075\HackManager\HackManager;
use skh6075\HackManager\listener\EventHandler;

class DistanceDamageEvent extends EventHandler{

    /**
     * @return int
     */
    public static function getEventId (): int{
        return 0000003;
    }
    
    public function handleEntityDamage (EntityDamageEvent $event): void{
        if ($event instanceof EntityDamageByEntityEvent) {
            if ($event->getCause () === EntityDamageEvent::CAUSE_PROJECTILE) {
                return;
            }
            if (!($damager = $event->getDamager ()) instanceof Player) {
                return;
            }
            $target = $event->getEntity ();
            $distance = 5.5;
            if ($target->distance ($damager) > $distance) {
                $event->setCancelled (true);
                $damager->sendMessage ("" . HackManager::getInstance ()->getLang ()->format ("distance-attack-warn"));
            }
        }
    }
}