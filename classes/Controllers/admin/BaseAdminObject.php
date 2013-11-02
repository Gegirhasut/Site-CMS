<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class BaseAdminObject extends BaseAdminSecurity
{
    /**
     * @var AdminBase_m
     */
    protected $_adminModel;

    function post() {
        $operation = $this->_loadPostHelper()->GetFromPost('operation');

        $this->ParsePost($this->fields);

        $this->_adminModel = $this->_getModelByName('AdminBase');
        
        if ($operation == 'update') {
        	$this->_adminModel->update($this);
        }
        
        if ($operation == 'add') {
          if (isset($this->fields['list_key'])) {
          	$values = $this->fields[$this->fields['list_key']]['value'];
          	$values = explode("\r\n", $values);
          	foreach ($values as $value) {
          		if (!empty($value)) {
	          		$this->fields[$this->fields['list_key']]['value'] = $value;
                    $this->_adminModel->insert($this);
          		}
          	}
          } else {
          	$this->_adminModel->insert($this);
          }
        }
        
        $this->caching = true;
        
        $this->clear_all_cache();
        $this->assign('post', 1);
    }

    protected function assignSelectFields() {
        foreach ($this->fields as &$field) {
            if ($field['type'] == 'select') {
                if (!isset($field['autocomplete'])) {
                    if (isset($field['source'])) {
                        $class = $this->loadClass($field['source']);
                        $table = $this->getClassField($class, 'table');

                        $select = $this->_adminModel
                            ->select($table)
                            ->fetchAll();
                    } else {
                        $select = $field['values'];
                    }
                    $field['values'] = $select;
                }
            }
        }
    }
    
	function display($uniquePageValue = 'admin-object')
	{
        $this->_adminModel = $this->_getModelByName('AdminBase');
		
		$filter = "";
		$id = Router::getUrlPart(4);

        if ($id == null) {
          $this->_defaultPage = "admin/add/object.tpl";
        } else {
          $this->_defaultPage = "admin/update/object.tpl";
          $object = $this->_adminModel
              ->select($this->table)
              ->where("{$this->identity} = $id")
              ->fetchAll();
        }
		
		$this->assignSelectFields();

        //print_r($this->fields);echo "<br>";
        //print_r($object[0]);echo "<br>";

        /*$select = Router::getParams('select');
        if ($select != null) {
            $this->assign('select', $select);
        }*/
        $this->assign('fields', $this->fields);
        $this->assign('object', empty($object) ? null : $object[0]);
        $this->assign('identity', $this->identity);
		
		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
}