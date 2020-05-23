<?php


namespace skh6075\HackManager\listener\handleMove;

use pocketmine\event\player\PlayerMoveEvent;

use skh6075\HackManager\HackManager;
use skh6075\HackManager\listener\EventHandler;

use pocketmine\math\Vector3;

class SpeedMoveEvent extends EventHandler{

    /** @var array */
    protected static $walkPoint = [];
    
    

    /**
     * @return int
     */
    public static function getEventId (): int{
        return 0000005;
    }
    
    /**
     * Refer To " https://github.com/AntiCheatPE/AntiCheatPE/blob/master/src/AntiCheatPE/EventListener.php "
     */
    public function handlePlayerMove (PlayerMoveEvent $event): void{
        $player = $event->getPlayer ();
        $name = strtolower ($player->getName ());
        $from = $event->getFrom ();
        $to = $event->getTo ();
        
        if ($player->isOp () or $player->getGamemode () !== 0 or $player->hasEffect (Effect::SPEED)) {
            return;
        }
        if (!isset (self::$walkPoint [$name])) {
            self::$walkPoint [$name] = 0;
        }
        
        if (($dection = self::XZDistance ($from, $to)) > 1.4) {
            ++ self::$walkPoint [$name];
        } else if ($dection > 3) {
            isset (self::$walkPoint [$name]) ? self::$walkPoint [$name] = 2 : self::$walkPoint [$name] += 2;
        } else if ($dection > 0) {
            self::$walkPoint [$name] -= 1;
        }
        
        if (isset (self::$walkPoint [$name]) and self::$walkPoint [$name] >= 7) {
            $player->kick ("" . HackManager::getInstance ()->getLang ()->format ("fast-speed-walk"));
            unset (self::$walkPoint [$name]);
        }
    }
    
    /**
     * @param Vector3 $vec1
     * @param Vector3 $vec2
     * @return float
     */
    public static function XZDistance (Vector3 $vec1, Vector3 $vec2): float{
        return floatval (($vec1->x - $vec2->x) ** 2 + ($vec1->z - $vec2->z) ** 2);
    }
}