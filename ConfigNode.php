<?php
/**
 * Implements the nodeof the ini string chain
 * (mysql.dbname) each word in a phrase separated by a points
 * represented by ConfigNode object
 */
class ConfigNode{
    protected $name ;
    protected $value = "";
    protected $childObjectArray = array();
    /**
     * Construct the ConfigNode object
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value = ""){
        $this->name = strtolower(trim($name));
        if(!empty($value)){
            $this->setValue($value);
        }
    }
    public function __get($name = ""){
        //$name = strtolower(trim($name));
		$name = trim($name);
        
        if(!empty($name)){
            $tempNode = $this->getChildNodeWithName($name);
            if(!is_object($tempNode)){
                return new ConfigNode("");
            }
          return $tempNode;
        }
        return "";
    }
    /**
     * Sets the node name
     * @param string $name
     */
    public function setName($name){
        $this->name = strtolower(trim($name));
    }
     /**
      * Summary of getName
      * @return 
      */
     public function getName(){
        return $this->name;
     }
    /**
     * Sets a value to the node
     * @param string $value
     */
    public function setValue($value){
        //$this->value = strtolower(trim($value));
    	$this->value = trim($value);
    }
    /**
     * Gets the node Value
     * @return string
     */
    public function getValue(){
        return $this->value;
    }
    /**
     * Gets a child node of ConfigNode array
     * @return array 
     */
    function getChildNodeArray(){
        return $this->childObjectArray;
    }
    /**
     * If the child node exist with the name
     * @param string $name
     * @return true|false
     */
    public function hasChildNodeWithName($name){
        $temNode = $this->getChildNodeWithName($name);
        if(is_object($temNode))
            return true;
        return false;
    }
    /**
     * Gets a child node by node name
     * @param string $name
     * @return ConfigNode|null
     */
    public function getChildNodeWithName($name){
        foreach($this->childObjectArray as $childNode){
            $currentNodeName = $childNode->getName();
            $requestedName = strtolower(trim($name));
            if($currentNodeName == $requestedName )
                return $childNode;
        }
        return null;   
    }
    /**
     * Adds a child node to the child node collection 
     * @param ConfigNode $node
     */
    public function addChildNode(ConfigNode $node){
        $this->childObjectArray[] = $node;
    }
    /**
     * Represent the node as a string
     * @return string
     */
    public function __toString(){
     return $this->value;   
    }

}