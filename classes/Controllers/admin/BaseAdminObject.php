<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class BaseAdminObject extends BaseAdminSecurity
{
    /**
     * @var AdminBase_m
     */
    protected $_adminModel;

    public function __construct() {
        parent::__construct();
        $this->class = $this->loadClass(Router::getUrlPart(3), true);
    }

    protected function executeHooks() {

        if (isset($this->class->hooks['after_insert'])) {
            $hook = $this->class->hooks['after_insert'];
            $this->class->{$hook}($this->_adminModel);
        }
    }

    function post() {
        $operation = $this->_loadPostHelper()->GetFromPost('operation');

        $subValues = $this->ParsePost($this->class->fields);

        $this->_adminModel = $this->_getModelByName('AdminBase');
        
        if ($operation == 'update') {
        	$this->_adminModel->update($this->class);
            $id = $this->class->fields[$this->class->identity]['value'];
            $this->insertManyToMany($id);
        }
        
        if ($operation == 'add') {
          	$id = $this->_adminModel->insert($this->class);
            $this->class->fields[$this->class->identity]['value'] = $id;
            $this->insertManyToMany($id);
        }

        if (isset($this->class->hooks)) {
            $this->executeHooks();
        }

        if (isset($id)) {
            $this->parseSubValues($subValues, $id);
            $this->parseRemoveImage();
        }
        
        $this->caching = true;
        
        $this->clear_all_cache();
        $this->assign('post', 1);
        $this->class = $this->loadClass(Router::getUrlPart(3), true);
    }

    protected function insertManyToMany($id) {
        foreach ($this->class->fields as $data) {
            if ($data['type'] == 'manyToMany') {
                $manyClass = $this->loadClass($data['join']['source']);
                $manyClass->fields[$this->class->identity]['value'] = $id;

                $this->_adminModel
                    ->delete($manyClass->table)
                    ->where($this->class->identity . " = $id")
                    ->execute();

                foreach ($data['values'] as $nabor) {
                    foreach ($nabor as $field => $value) {
                        if(isset($manyClass->fields[$field])) {
                            $manyClass->fields[$field]['value'] = $value;
                        }
                    }
                    $this->_adminModel->insert($manyClass);
                }
            }
        }
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
                if (!isset($this->class->fields[$subValue]['source'])) {
                    continue;
                }
                $values = $this->class->fields[$subValue]['subvalue'];
                if (isset($this->class->fields[$subValue]['subvalue_title'])) {
                    $subvalue_title = $this->class->fields[$subValue]['subvalue_title'];
                }
                if (isset($this->class->fields[$subValue]['subvalue_descr'])) {
                    $subvalue_descr = $this->class->fields[$subValue]['subvalue_descr'];
                }
                if (isset($this->class->fields[$subValue]['subvalue_sort'])) {
                    $subvalue_sort = $this->class->fields[$subValue]['subvalue_sort'];
                }

                $subClass = $this->loadClass($this->class->fields[$subValue]['source']);
                $this->_adminModel
                    ->delete($subClass->table)
                    ->where($this->class->identity . " = $id")
                    ->execute();

                foreach ($subClass->fields as $key => &$field) {
                    if ($key == $this->class->fields[$subValue]['join_field']) {
                        $field['value'] = $id;
                    } elseif ($field['type'] == 'copy') {
                        $field['value'] = $_POST[$key];
                    }
                }

                foreach ($values as $key => $path) {
                    $subClass->fields['path']['value'] = $path;
                    if (isset($subClass->fields['title'])) {
                        $subClass->fields['title']['value'] = $subvalue_title[$key];
                    }
                    if (isset($subClass->fields['sort'])) {
                        $subClass->fields['sort']['value'] = $subvalue_sort[$key];
                    }
                    if (isset($subClass->fields['descr'])) {
                        $subClass->fields['descr']['value'] = str_replace("\r\n", "<br/>", $subvalue_descr[$key]);
                    }

                    $this->_adminModel->insert($subClass);
                }
            }
        }
    }

    protected function assignGeoFields(&$object) {
        $geoFieldName = null;

        foreach ($this->class->fields as $key => $field) {
            if ($field['type'] == 'geo') {
                $geoFieldName = $key;
            }
        }

        if (!is_null($geoFieldName)) {
            $geoField = $this->class->fields[$geoFieldName];
            $this->class->fields[$geoFieldName]['fields']['latitude']['value'] = $object[0][$geoField['fields']['latitude']['name']];
            $this->class->fields[$geoFieldName]['fields']['longitude']['value'] = $object[0][$geoField['fields']['longitude']['name']];
        }
    }

    protected function assignSelectFields($object) {
        foreach ($this->class->fields as $key => &$field) {
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
                        ->where("{$field['identity']} = {$object[0][$key]}")
                        ->fetchAll();

                    if (!empty($select[0])) {
                        $field['values'] = $select[0][$field['show_field']];
                    }
                }
            }
        }
    }

    protected function assignManyToManyFields($object) {
        if(empty($object))
            return;
        foreach ($this->class->fields as &$field) {
            if ($field['type'] == 'manyToMany') {
                $joinClass = $this->loadClass($field['join']['source']);
                $manyClass = $this->loadClass($field['many']['source']);

                $fields = "{$manyClass->table}.{$field['many']['identity']}, {$manyClass->table}.{$field['many']['show_field']}";
                if (isset($field['many']['fields'])) {
                    foreach ($field['many']['fields'] as $f => $v) {
                        $fields .= ",{$manyClass->table}.$f";
                    }
                }
                if (isset($field['join']['fields'])) {
                    foreach ($field['join']['fields'] as $f => $v) {
                        $fields .= ",{$joinClass->table}.$f";
                    }
                }

                $select = $this->_adminModel
                    ->select($joinClass->table, $fields)
                    ->join($manyClass->table . " ON {$manyClass->table}.{$field['many']['identity']} = {$joinClass->table}.{$field['many']['identity']}")
                    ->where("{$this->class->identity} = {$object[0][$this->class->identity]}")
                    ->fetchAll();

                $field['values'] = $select;
            }
        }
    }

    protected function assignImageFields(&$object) {
        if(empty($object))
            return;

        if (!isset($this->class->fields[$this->class->images['field']]['source'])) {
            $preview_field = $this->class->fields[$this->class->images['field']]['preview'];
            $preview = $object[0][$preview_field];
            $subValues[] = array('path' => $preview);
        } else {
            $subClass = $this->loadClass($this->class->fields[$this->class->images['field']]['source']);

            $subValues = $this->_adminModel
                ->select($subClass->table)
                ->where($this->class->identity . " = {$object[0][$this->class->identity]}");

            if (isset($this->class->images['sort'])) {
                $subValues = $subValues->orderBy($this->class->images['sort']);
            }

            $subValues = $subValues->fetchAll();

            foreach ($subValues as &$value) {
                if (isset($value['descr'])) {
                    $value['descr'] = str_replace("<br/>", "\r\n", $value['descr']);
                }
            }
        }

        $object[0][$this->class->images['field']] = $subValues;
    }
    
	function display($uniquePageValue = 'admin-object')
	{
        $this->_adminModel = $this->_getModelByName('AdminBase');
		
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

        $this->assignGeoFields($object);
		$this->assignSelectFields($object);
        $this->assignManyToManyFields($object);

        if (isset($this->class->images)) {
            $this->assignImageFields($object);
            $this->assign('images', $this->class->images);
            if (isset($this->class->fields[$this->class->images['field']]['descr'])) {
                $this->assign('photoDescr', 1);
            }
            if (isset($this->class->fields[$this->class->images['field']]['title'])) {
                $this->assign('photoTitle', 1);
            }
            if (isset($this->class->images['sort'])) {
                $this->assign('sortField', $this->class->images['sort']);
            }
        }

        $this->assign('fields', $this->class->fields);
        $this->assign('object', empty($object) ? null : $object[0]);
        $this->assign('identity', $this->class->identity);

        if(isset($_SESSION['last_upload'])) {
            $this->assign('last_upload', $_SESSION['last_upload']);
        }
		
		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
}