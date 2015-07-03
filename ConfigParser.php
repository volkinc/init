<?php
/**
 * Implements the logic of parsing the ini file.
 * Working with the namespaces like [LIVE:TES]
 */
class ConfigParser{
    protected $fileName;
    protected $section;
    protected $configurationArray = array();
    protected $namespaces = array();
    /**
     * Gets the object of the child node by name
     * in order to follow the call construction like:
     * $config->front_end->host
     * 
     * @param string $nodeName
     * @return ConfigNode | null
     */
    public function __get($nodeName = ""){
        $name = strtolower(trim($nodeName));
        if(!empty($name)){
            foreach($this->namespaces as $namespase){
                
                $tempObj = $namespase->getRootNode()->getChildNodeWithName($name);
                if(is_object($tempObj)){
                    return $tempObj;
                }
            }
        }
        return null;
    }
    /**
     * Construct the ConfigParser object
     * @param string $fileName
     * @param string $section
     */
    public function __construct($fileName, $section = "LIVE"){
        $this->fileName = $fileName;
        $this->section = strtolower($section);
        $this->init();
    }
    /**
     * Create namespaces 
     */
    private function init(){
        
        $this->configurationArray = parse_ini_file($this->fileName, true);

        foreach($this->configurationArray as $namespace => $properties){
            $tempNamespace =  new ConfigNamespace($namespace);
            if(!empty($this->section) && stripos($tempNamespace->getName(), $this->section) === false){
                continue;
            }
            if($tempNamespace->getExtends()){
                $namespace = new ConfigNamespace($tempNamespace->getExtends());
                $namespace->setProperty( $this->configurationArray[$tempNamespace->getExtends()]);
                $tempNamespace->merge($namespace);
            }
            $tempNamespace->setProperty($properties);
            $this->namespaces[$tempNamespace->getName()] = $tempNamespace;
        }
    }
    /**
     * Gets the namespace object
     * @param  string $namespaceName
     * @return ConfigNamespace|null
     */
    public function getNamespace($namespaceName = ""){
        $namespaceName = strtolower(trim($namespaceName));
        if(empty($namespaceName))
            return null;
        
        foreach($this->namespaces as $namespace){
            if($namespace->getName() == $namespaceName){
                return $namespace;
            }
        }
        return null;
    }
}