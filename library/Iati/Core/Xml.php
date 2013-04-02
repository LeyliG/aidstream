<?php
/**
 * Class to Generate iati xml.
 *
 * @author bhabishyat <bhabishyat@gmail.com>
 */
class Iati_Core_Xml
{
    const SCHEMA_VERSION = 1.01;

    protected $xml;
    protected $xmlPath;
    protected $childrenIds;


    /**
     * Set XmlPath 
     */
    public function __construct()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);       
        $this->xmlPath = $config->public_folder.$config->xml_folder;
        
    }
    
    public function setChildrenIds($childrenIds){
        $this->childrenIds= $childrenIds;
    }
    
    public function generateXml($name , $ids = array())
    {   
        $this->setChildrenIds($ids);
        if($name == "Activity")
        {
            $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><iati-activities></iati-activities>');
        }
        else
        {
            $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><'.strtolower($name).'s></'.strtolower($name).'s>');
        }
        $this->xml->addAttribute('generated-datetime',gmdate('c'));
        $this->xml->addAttribute('version',self::SCHEMA_VERSION);
        
        if(!empty($this->childrenIds)){
            foreach($this->childrenIds as $childId){
                $childElementClass = "Iati_Aidstream_Element_".ucfirst($name);
                $childElement = new $childElementClass();
                $childElement->getXml($childId , false ,  $this->xml);
            }
        }
        return $this->xml->asXML();
    }
    
    /**
     * Write generate xml data to file 
     * @param string $name,organisation
     * @param array $ids,organisation ids
     * @param string $publisherId,publisher id
     * @return string ,file name
     */
    public function generateFile($name , $ids = array(), $publisherId)
    {  
        $fileName = $publisherId."-org.xml"; 
        $fp = fopen($this->xmlPath.$fileName,'w');
        fwrite($fp,$this->generateXml($name , $ids));
        fclose($fp);
        
        return $fileName;
    }       
}