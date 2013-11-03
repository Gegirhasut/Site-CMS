<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class BaseAdminObject extends BaseAdminSecurity
{
    /**
     * @var AdminBase_m
     */
    protected $_adminModel;

    public function __construct() {
        $this->class = $this->loadClass(Router::getUrlPart(3), true);
    }

    function post() {
        $operation = $this->_loadPostHelper()->GetFromPost('operation');

        $this->ParsePost($this->class->fields);

        $this->_adminModel = $this->_getModelByName('AdminBase');
        
        if ($operation == 'update') {
        	$this->_adminModel->update($this->class);
        }
        
        if ($operation == 'add') {
          if (isset($this->class->fields['list_key'])) {
          	$values = $this->class->fields[$this->class->fields['list_key']]['value'];
          	$values = explode("\r\n", $values);
          	foreach ($values as $value) {
          		if (!empty($value)) {
                    $this->class->fields[$this->class->fields['list_key']]['value'] = $value;
                    $this->_adminModel->insert($this->class);
          		}
          	}
          } else {
          	$this->_adminModel->insert($this->class);
          }
        }
        
        $this->caching = true;
        
        $this->clear_all_cache();
        $this->assign('post', 1);
    }

    protected function assignSelectFields($class, $object) {
        foreach ($this->class->fields as &$field) {
            if ($field['type'] == 'select') {
                if (!isset($field['autocomplete'])) {
                    if (isset($field['source'])) {
                        $source_class = $this->loadClass($field['source']);

                        if (isset($source_class->table)) {
                            $select = $this->_adminModel
                                ->select($source_class->table)
                                ->fetchAll();
                        } else {
                            $select = $source_class->values;
                        }
                    } else {
                        $select = $field['values'];
                    }
                    $field['values'] = $select;
                } elseif (!empty($object)) {
                    $source_class = $this->loadClass($field['source']);
                    $select = $this->_adminModel
                        ->select($source_class->table, "{$field['show_field']}")
                        ->where("{$field['identity']} = {$object[0][$field['identity']]}")
                        ->fetchAll();

                    $field['values'] = $select[0][$field['show_field']];
                }
            }
        }
    }
    
	function display($uniquePageValue = 'admin-object')
	{
        $class = $this->loadClass(Router::getUrlPart(3));

        $this->_adminModel = $this->_getModelByName('AdminBase');
		
		$filter = "";
		$id = Router::getUrlPart(4);
        $object = null;

        if ($id == null) {
          $this->_defaultPage = "admin/add/object.tpl";
        } else {
          $this->_defaultPage = "admin/update/object.tpl";
          $object = $this->_adminModel
              ->select($this->class->table)
              ->where("{$this->class->identity} = $id")
              ->fetchAll();
        }

		$this->assignSelectFields($class, $object);

        //print_r($this->fields);echo "<br>";
        //print_r($object[0]);echo "<br>";

        /*$select = Router::getParams('select');
        if ($select != null) {
            $this->assign('select', $select);
        }*/
        $this->assign('fields', $this->class->fields);
        $this->assign('object', empty($object) ? null : $object[0]);
        $this->assign('identity', $this->class->identity);
		
		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
}