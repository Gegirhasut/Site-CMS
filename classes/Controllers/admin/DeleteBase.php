<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class DeleteBase extends BaseAdminSecurity
{
    public function __construct() {
      parent::__construct();
      $this->loadClassFromUrl();
    }

    function post() {
        $postHelper = $this->_loadPostHelper();
        
        $id = $postHelper->GetFromPost('id');
        $field = $postHelper->GetFromPost('field');
        $table = $postHelper->GetFromPost('table');
        
        $adminModel = $this->_getModelByName('AdminBase');
        
        $adminModel
            ->delete($table)
            ->where("$field = $id")
            ->execute();
        
        /*$img = $postHelper->GetFromPost('img');
        if ($img != null) {
          $small_path = $postHelper->GetFromPost('small_path');
          $upload = $postHelper->GetFromPost('upload');
          @unlink($small_path . "/" . $img);
          @unlink($upload . "/" . $img);
        }*/
        
        $this->clear_all_cache();
        $this->assign('post', 1);
    }    
    
	function display($uniquePageValue = 'admin')
	{
	    $id = Router::getUrlPart(4);
	    
	    /*if (isset($this->img)) {
	      $adminModel = $this->_getModelByName('AdminBase');
	      $object = $adminModel->get($this->table, $this->identity . "=" . $id);
	      $img = array();	      
	      $img['img'] = $object[0][$this->_object['img']['field']];
	      $img['small_path'] = $this->_object['img']['small_path'];
	      $img['upload'] = $this->_object['img']['upload'];
	      $this->assign('img', $img);
	    }*/
	    
	    $this->assign('field', $this->identity);
	    $this->assign('id', $id);
	    $this->assign('table', $this->table);
	  
		$this->_defaultPage = "admin/delete/object.tpl";

		$this->caching = false;
		parent::display($uniquePageValue);
	}
}