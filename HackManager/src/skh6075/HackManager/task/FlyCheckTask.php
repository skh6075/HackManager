<?php


namespace skh6075\HackManager\task;

use pocketmine\scheduler\Task;
use pocketmine\Server;

use skh6075\HackManager\HackManager;

class FlyCheckTask extends Task{

    /** @var array */
    protected $fly_hack = [];
    
    
    public function onRun (int $currentTick): void{
        foreach (Server::getInstance ()->getOnlinePlayers () as $player) {
            if ($player->isOp ()) {
                return;
            }
            if ($player->getGamemode () !== 0) {
                return;
            }
            if ($player->isAllowFlight ()) {
                return;
            }
            if (!isset ($this->fly_hack [$player->getName ()])) {
                $this->fly_hack [$player->getName ()] = 0;
            }
            if ($player->level->getBlock ($player->add (0, -1))->getId () === 0) {
                $this->fly_hack [$player->getName ()] ++;
                if ($this->fly_hack [$player->getName ()] >= 7) {
                    unset ($this->fly_hack [$player->getName ()]);
                    $player->kick ("" . HackManager::getInstance ()->getLang ()->format ("dont-server-fly"));
                }
            } else {
                if ($this->fly_hack [$player->getName ()] !== 0) {
                    $this->fly_hack [$player->getName ()] --;
                }
            }
        }
    }
}