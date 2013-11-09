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

        $subValues = $this->ParsePost($this->class->fields);
        /*print_r($this->class->fields);
        print_r($subValues);
        exit;*/

        $this->_adminModel = $this->_getModelByName('AdminBase');
        
        if ($operation == 'update') {
        	$this->_adminModel->update($this->class);
            $id = $this->class->fields[$this->class->identity]['value'];
        }
        
        if ($operation == 'add') {
          /*if (isset($this->class->fields['list_key'])) {
          	$values = $this->class->fields[$this->class->fields['list_key']]['value'];
          	$values = explode("\r\n", $values);
          	foreach ($values as $value) {
          		if (!empty($value)) {
                    $this->class->fields[$this->class->fields['list_key']]['value'] = $value;
                    $this->_adminModel->insert($this->class);
          		}
          	}
          } else {*/
          	$id = $this->_adminModel->insert($this->class);
          //}
        }

        $this->parseSubValues($subValues, $id);
        $this->parseRemoveImage();
        
        $this->caching = true;
        
        $this->clear_all_cache();
        $this->assign('post', 1);
    }

    protected function parseRemoveImage() {
        $images = $this->_loadPostHelper()->GetFromPostByMask('remove_image_');
        foreach ($images as $image) {
            if (file_exists($image)) {
                unlink($image);
            }
        }
    }

    protected function parseSubValues($subValues, $id) {
        if (!empty($subValues)) {
            foreach ($subValues as $subValue) {
                $values = $this->class->fields[$subValue]['subvalue'];
                $subClass = $this->loadClass($this->class->fields[$subValue]['source']);
                $this->_adminModel
                    ->delete($subClass->table)
                    ->where($this->class->identity . " = $id")
                    ->execute();

                $subClass->fields[$this->class->fields[$subValue]['join_field']]['value'] = $id;

                foreach ($values as $path) {
                    $subClass->fields['path']['value'] = $path;
                    $this->_adminModel->insert($subClass);
                }
            }
        }
    }

    protected function assignSelectFields($object) {
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

    protected function assignImageFields(&$object) {
        if(empty($object))
            return;

        $subClass = $this->loadClass($this->class->fields[$this->class->images['field']]['source']);

        $subValues = $this->_adminModel
            ->select($subClass->table)
            ->where($this->class->identity . " = {$object[0][$this->class->identity]['value']}")
            ->fetchAll();

        $object[0][$this->class->images['field']] = $subValues;
    }
    
	function display($uniquePageValue = 'admin-object')
	{
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

		$this->assignSelectFields($object);

        //print_r($this->fields);echo "<br>";
        //print_r($object[0]);echo "<br>";

        /*$select = Router::getParams('select');
        if ($select != null) {
            $this->assign('select', $select);
        }*/
        if (isset($this->class->images)) {
            $this->assignImageFields($object);
            $this->assign('images', $this->class->images);
        }
        $this->assign('fields', $this->class->fields);
        $this->assign('object', empty($object) ? null : $object[0]);
        $this->assign('identity', $this->class->identity);
		
		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
}