<?php 
class Iati_WEP_Activity_Elements_Transaction extends Iati_WEP_Activity_Elements_ElementBase
{
    protected $attributes = array('id', 'ref');
    protected $ref;
    protected $id = 0;
    protected $options = array();
    protected $multiple = true;
//    protected $validator = array(protected $hasError = false;
//                                '' 
//                            );
    protected $attributes_html = array(
                    'id' => array(
                    'name' => 'id',
                    'label' => '',
                    'html' => '<input type="hidden" name="%(name)s" value="%(value)s" />',
                    ),
                    'ref' => array(
                    'name' => 'ref',
                    'label' => 'Text',
                    'html' => '<input type="text" name="%(name)s" %(attrs)s value= "%(value)s" />',
                    'attrs' => array('id' => 'id')
                
                ),
    );
    protected $className = 'Transaction';
    
    protected $validators = array();
    protected static $count = 0;
    protected $objectId;
    protected $error = array();
    protected $hasError = false;
    
    

    public function __construct()
    {
        parent :: __construct();
        $this->objectId = self::$count;
        self::$count += 1;
        $this->multiple = true;
    }
    
    public function setAttributes ($data) {
        $this->id = (isset($data['id']))?$data['id']:0; 
        $this->ref = (isset($data['@ref']))?$data['@ref']:$data['ref'];
    }
    
    public function getOptions($attr)
    {
        return $this->options[$attr];
    }
    
    public function getAttributes () {
        return $this->attributes;
    }
    public function getClassName ()
    {
        return $this->className;
    }
    
    public function getValidator()
    {
        return $this->validators;
    }
    
    public function validate(){
        
    }
    
    public function getObjectId()
    {
        return $this->objectId;
    }
    
    public function getCleanedData(){
        $data = array();
        $data['id'] = $this->id;
        $data['ref'] = $this->ref;
        
        return $data;
    }
}