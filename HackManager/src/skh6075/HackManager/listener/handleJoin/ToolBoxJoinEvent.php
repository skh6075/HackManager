<?php


namespace skh6075\HackManager\listener\handleJoin;

use pocketmine\Server;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;

use skh6075\HackManager\HackManager;
use skh6075\HackManager\listener\EventHandler;
use skh6075\HackManager\utils\HackProgram;

class ToolBoxJoinEvent extends EventHandler{


    /**
     * @return int
     */
    public static function getEventId (): int{
        return 0000001;
    }
    
    public function handleDataPacketReceive (DataPacketReceiveEvent $event): void{
        $player = $event->getPlayer ();
        if (($packet = $event->getPacket ()) instanceof LoginPacket) {
            if ($packet->clientId === HackProgram::TOOLBOX) {
                $player->kick (HackManager::getInstance ()->getLang ()->format ("hack-program-joined"));
                Server::getInstance ()->getIPBans ()->addBan ($player->getAddress ());
                Server::getInstance ()->getNameBans ()->addBan (strtolower ($player->getName ()));
            }
        }
    }
}