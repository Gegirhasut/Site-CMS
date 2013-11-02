<?php
require_once('classes/Controllers/admin/BaseAdminObject.php');

class Main_c extends BaseAdminObject
{
    public function __construct() {
        $class_name = Router::getUrlPart(3);
        require_once("classes/Objects/$class_name.php");
        $class_description = new ReflectionClass($class_name);
        $class = $class_description->newInstance();
        
        $this->_object = $class->_object;
        $this->_tableName = $class->_tableName;
    }
  
    protected $_idIndex = 4;
    
    protected $_object = null;
    
    protected $_tableName = null;
}