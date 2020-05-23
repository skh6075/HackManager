<?php


namespace skh6075\HackManager\lang;

use skh6075\HackManager\HackManager;

class PluginLang{

    /** @var HackManager */
    protected $plugin = null;
    
    /** @var string */
    protected $language = "eng";
    
    /** @var array */
    protected $translate = [];
    
    
    
    public function __construct (HackManager $plugin, string $lang = "eng") {
        $this->plugin = $plugin;
        $this->lang = $lang;
        $this->translate = $this->settingTranslate ();
    }
    
    /**
     * @retrun array
     */
    public function settingTranslate (): array{
        $arr = [];
        
        try {
            yaml_parse (file_get_contents ($this->plugin->getDataFolder () . $this->lang . ".yml"));
        } catch (\Exception $e) {
            file_put_contents ($this->plugin->getDataFolder () . $this->lang . ".yml", yaml_emit ([]));
        } finally {
            $arr = yaml_parse (file_get_contents ($this->plugin->getDataFolder () . $this->lang . ".yml"));
        }
        return $arr;
    }
    
    /**
     * @param string $scheme
     * @param array $format
     * @return array
     */
    public function format (string $scheme = "prefix", array $format = []): string{
        $string = $this->translate ["prefix"];
        $string .= $this->translate [$scheme] ?? "";
        
        foreach ($format as $input => $output) {
            $string = str_replace ($input, $output, $string);
        }
        return $string;
    }
}