<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class DeleteBase extends BaseAdminSecurity
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
        
        $id = $postHelper->GetFromPost('id');
        $field = $postHelper->GetFromPost('field');
        $table = $postHelper->GetFromPost('table');
        
        $adminModel = $this->_getModelByName('AdminBase');
        
        $adminModel->delete($table, "where $field = $id");
        
        $img = $postHelper->GetFromPost('img');
        if ($img != null) {
          $small_path = $postHelper->GetFromPost('small_path');
          $upload = $postHelper->GetFromPost('upload');
          @unlink($small_path . "/" . $img);
          @unlink($upload . "/" . $img);
        }
        
        $this->clear_all_cache();
        $this->assign('post', 1);
    }    
    
	function display($uniquePageValue = 'admin')
	{
	    $adminModel = $this->_getModelByName('AdminBase');
	    
	    $id = Router::getUrlPart($this->_idIndex);
	    
	    if (isset($this->_object['img'])) {
	      $object = $adminModel->get($this->_tableName, $this->_object['identity'] . "=" . $id);
	      $img = array();	      
	      $img['img'] = $object[0][$this->_object['img']['field']];
	      $img['small_path'] = $this->_object['img']['small_path'];
	      $img['upload'] = $this->_object['img']['upload'];
	      $this->assign('img', $img);
	    }
	    
	    $this->assign('field', $this->_object['identity']);
	    $this->assign('id', $id);
	    $this->assign('table', $this->_tableName);
	  
		$this->_defaultPage = "admin/delete-object.tpl";

		$this->caching = false;
		parent::display($uniquePageValue);
	}
}