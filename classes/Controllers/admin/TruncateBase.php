<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class TruncateBase extends BaseAdminSecurity
{
    public function __construct() {
      parent::__construct();
    
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
    
    function post() {
        $postHelper = $this->_loadPostHelper();
        
        $table = $postHelper->GetFromPost('table');
        $adminModel = $this->_getModelByName('AdminBase');
        
        $adminModel->truncate($table);
        
        $this->clear_all_cache();
        $this->assign('post', 1);
    }    
    
	function display($uniquePageValue = 'admin')
	{
	    $adminModel = $this->_getModelByName('AdminBase');
	    
	    $this->assign('table', $this->_tableName);
	  
		$this->_defaultPage = "admin/truncate-object.tpl";

		$this->caching = false;
		parent::display($uniquePageValue);
	}
}