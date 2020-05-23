<?php


namespace skh6075\HackManager\listener\handleJoin;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerChangeSkinEvent;

use skh6075\HackManager\HackManager;
use skh6075\HackManager\utils\SkinImaginData;
use skh6075\HackManager\listener\EventHandler;

class ShadowSkinJoinEvent extends EventHandler{


    /**
     * @return int
     */
    public static function getEventId (): int{
        return 0000004;
    }
    
    public function handlePlayerJoin (PlayerJoinEvent $event): void{
        $player = $event->getPlayer ();
        
        $skinArray = [
            base64_encode ($player->getSkin ()->getSkinId ()),
            base64_encode ($player->getSkin ()->getSkinData ()),
            base64_encode ($player->getSkin ()->getGeometryName ()),
            base64_encode ($player->getSkin ()->getGeometryData ())
        ];
        
        if (
            in_array ($skinArray [0], SkinImaginData::SKIN_ID_LIST)
            and in_array ($skinArray [1], SkinImaginData::SKIN_DATA_LIST)
            and in_array ($skinArray [2], SkinImaginData::SKIN_GEOMERTY_NAME)
            and in_array ($skinArray [3], SkinImaginData::SKIN_GEOMERTY_DATA)
        ) {
            $player->kick ("" . HackManager::getInstance ()->getLang ()->format ("dont-shadow-skin-joined"));
        }
    }
    
    public function handlePlayerChangeSkin (PlayerChangeSkinEvent $event): void{
        $player = $event->getPlayer ();
        $newSkin = $event->getNewSkin ();
        
        $skinArray = [
            base64_encode ($newSkin->getSkinId ()),
            base64_encode ($newSkin->getSkinData ()),
            base64_encode ($newSkin->getGeometryName ()),
            base64_encode ($newSkin->getGeometryData ())
        ];
        
        if (
            in_array ($skinArray [0], SkinImaginData::SKIN_ID_LIST)
            and in_array ($skinArray [1], SkinImaginData::SKIN_DATA_LIST)
            and in_array ($skinArray [2], SkinImaginData::SKIN_GEOMERTY_NAME)
            and in_array ($skinArray [3], SkinImaginData::SKIN_GEOMERTY_DATA)
        ) {
            $player->kick ("" . HackManager::getInstance ()->getLang ()->format ("dont-shadow-skin-changed"));
        }
    }
}