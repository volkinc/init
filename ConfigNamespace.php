<?php
/**
 * Implements the logic of the namespaces in ini file
 */
class ConfigNamespace{
    private $nameSpace;
    private $name = ""; 
    private $extends = "";
    private $rootNode;

    /**
     * Construct the namespace object 
     * @param $namespace
     */
    public function __construct($namespace){
        $this->nameSpace = $namespace;
        $tempArray = explode(':', $namespace);
        if(isset($tempArray[0])){
            $this->name = $tempArray[0];
        }
        if(isset($tempArray[1])){
            $this->extends = $tempArray[1];
        }
      $this->rootNode = new ConfigNode("root");
    }
    /**
     * Sets Property of the node 
     *  array in a format  
     *  
     * "log_folder_path" => "logs/"
     * "api_logs_path => "logs/api/"
     * "mod_logs_path" = "logs/mod/"
    
     * 
     * @param array $properties
     */
    public function setProperty($properties){
        foreach($properties as $key => $val){
            $pathArray = explode(".", $key);
            $this->setNodeValue($this->rootNode, $pathArray, $val);
        }
    }
    /**
     * Sets the value to the current node 
     * OR create new node and set vanue to the new one
     * @param ConfigNamespace $rootNode
     * @param array $pathArray
     * @param string $value
     */
    private function setNodeValue($rootNode, $pathArray, $value){
        $currentNode = $rootNode;
        for($i = 0; $i < count($pathArray); $i++){
            
            $pathElementName = $pathArray[$i];
            if($currentNode->hasChildNodeWithName($pathElementName)){
                //move to the child element
                $currentNode = $currentNode->getChildNodeWithName($pathElementName); 
                //continue;
            }
            else{
                //create node
                $temNode = new ConfigNode($pathElementName);
                $currentNode->addChildNode($temNode);
                $currentNode = $temNode;
            }
            
            if(count($pathArray) == $i+1){
                $currentNode->setValue($value);
            }
        }
    }
    /**
     * Gets the name of the node
     * @return string 
     */
    public function getName(){
        return $this->name;   
    }
    /**
     * Gets namespace to extend from
     * @return string 
     */
    public function getExtends(){
        return $this->extends;    
    }
    /**
     * Gets the root ConfigNode
     * @return ConfigNode
     */
    public function getRootNode(){
        return $this->rootNode;
    }
    /**
     * Merge the root ConfigNode.
     * merge is handy in a case of extended namespace
     * @param ConfigNamespace $namespaceMergeWith
     */
    public function merge(ConfigNamespace $namespaceMergeWith){
      $this->rootNode = $namespaceMergeWith->getRootNode();
      $this->rootNode->setName( $this->getName() );
    }
}
