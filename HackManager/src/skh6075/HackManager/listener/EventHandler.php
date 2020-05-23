<?php


namespace skh6075\HackManager\listener;

use pocketmine\event\Listener;

use skh6075\HackManager\HackManager;

use skh6075\HackManager\listener\handleJoin\ToolBoxJoinEvent;
use skh6075\HackManager\listener\handleJoin\BlockLauncherJoinEvent;
use skh6075\HackManager\listener\handleJoin\ShadowSkinJoinEvent;
use skh6075\HackManager\listener\handleMove\SpeedMoveEvent;

use skh6075\HackManager\listener\handleAttack\DistanceDamageEvent;

abstract class EventHandler implements Listener{

    /** @var array */
    private static $events = [];
    
    
    /**
     * @param HackManager $plugin
     */
    public static function init (): void{
        self::$events [ToolBoxJoinEvent::getEventId ()] = new ToolBoxJoinEvent ();
        self::$events [BlockLauncherJoinEvent::getEventId ()] = new BlockLauncherJoinEvent ();
        self::$events [DistanceDamageEvent::getEventId ()] = new DistanceDamageEvent ();
        self::$events [ShadowSkinJoinEvent::getEventId ()] = new ShadowSkinJoinEvent ();
        self::$events [SpeedMoveEvent::getEventId ()] = new SpeedMoveEvent ();
        
        array_map (function (int $eventId): void{
            if (($event = EventHandler::getIdByEvent ($eventId)) instanceof EventHandler) {
                HackManager::getInstance ()->getServer ()->getPluginManager ()->registerEvents ($event, HackManager::getInstance ());
            }
        }, array_keys (self::$events));
    }
    
    /**
     * @param int $id
     */
    public static function getIdByEvent (int $id): ?EventHandler{
        return self::$events [$id] ?? null;
    }
    
    abstract public static function getEventId (): int;
}