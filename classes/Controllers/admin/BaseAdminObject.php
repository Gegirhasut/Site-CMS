<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class BaseAdminObject extends BaseAdminSecurity
{
    protected $_defaultPage = "admin/admin-update-object.tpl";
    protected $_idIndex = 3;
    
    function post() {
        $operation = $this->_loadPostHelper()->GetFromPost('operation');
        
        $this->ParsePost($this->_object);
        
        $adminModel = $this->_getModelByName('AdminBase');
        
        if ($operation == 'update') {
        	$adminModel->update($this->_object, $this->_tableName);
        }
        
        if ($operation == 'add') {
          if (isset($this->_object['list_key'])) {
          	$values = $this->_object['fields'][$this->_object['list_key']]['value'];
          	$values = explode("\r\n", $values);
          	foreach ($values as $value) {
          		if (!empty($value)) {
	          		$this->_object['fields'][$this->_object['list_key']]['value'] = $value;
	          		$adminModel->add($this->_object, $this->_tableName);
          		}
          	}
          } else {
          	$adminModel->add($this->_object, $this->_tableName);
          }
        }
        
        $this->caching = true;
        
        $this->clear_all_cache();
        $this->assign('post', 1);
    }    
    
	function display($uniquePageValue = 'admin-object')
	{
		$adminModel = $this->_getModelByName('AdminBase');
		
		$filter = "";
		$id = Router::getUrlPart($this->_idIndex);
		$object = null;
		
        if ($id == null) {
          $this->_defaultPage = "admin/admin-add-object.tpl";
        } else {
          $filter = $this->_object['identity'] . "=" . $id;
          $object = $adminModel->get($this->_tableName, $filter);
        }
		
		foreach ($this->_object['fields'] as &$field) {
		  if ($field['type'] == 'select') {
		    $filter = '';
		    if (isset($field['filter'])) {
		      $filter = $field['filter'];
		    }
		  	if (isset($field['join'])) {
		    	$select = $adminModel->get($field['join'], $filter);
		    } else {
		    	$select = $field['values'];
		    }
		    $field['values'] = $select;
		  }
		}
		
		$select = Router::getParams('select');
		if ($select != null) {
		  $this->assign('select', $select);
		}
		
		$this->assign('fields', $this->_object);
		
        $this->assign('object', empty($object) ? null : $object[0]);
		
		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
}