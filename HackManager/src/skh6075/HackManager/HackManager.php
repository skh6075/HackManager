<?php



namespace skh6075\HackManager;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use skh6075\HackManager\lang\PluginLang;
use skh6075\HackManager\listener\EventHandler;
use skh6075\HackManager\task\FlyCheckTask;
class HackManager extends PluginBase
{

    /** @var HackManager */
    private static $instance = null;
    
    /** @var PluginLang */
    private $lang = null;
    
    
    public static function getInstance (): ?HackManager{
        return self::$instance;
    }
    
    public function onLoad (): void{
        if (self::$instance === null) {
            self::$instance = $this;
        }
        
        array_map (function (string $resource): void{
            $this->saveResource ($resource, true);
        }, [ "kor.yml", "eng.yml" ]);
        
        $this->lang = new PluginLang ($this, ($lang = (new Config (\pocketmine\DATA . "server.properties", Config::PROPERTIES))->get ("language")));
        $this->getLogger ()->info ($this->getLang ()->format ("setting-plugin-language", [
            "%lang%" => $lang
        ]));
        $this->getScheduler ()->scheduleRepeatingTask (new FlyCheckTask (), 25);
    }
    
    public function onEnable (): void{
        EventHandler::init ();
    }
    
    /**
     * @return PluginLang
     */
    public function getLang (): PluginLang{
        return $this->lang;
    }
    
}