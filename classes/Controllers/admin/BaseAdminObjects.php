<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class BaseAdminObjects extends BaseAdminSecurity
{
    protected $_defaultPage = "admin/list/objects.tpl";
    protected $_start = 0;
    protected $_offset = 10;
    protected $_filters = array ();
    /**
     * @var AdminBase_m
     */
    protected $_adminModel;
    
/*    function sort($objects, $adminModel) {
        $postHelper = $this->_loadPostHelper();
        $operation = $postHelper->GetFromGet('operation');
        if ($operation == null) {
          return false;
        }
        
        $idValue = $postHelper->GetFromGet('id');
        $idName = $this->_object['identity'];
        
        foreach ($objects as $index => $object) {
          if ($object[$idName] == $idValue) {
            break;
          }
        }
        
        if ($operation == 'up' && $index > 0) {
          $object = $objects[$index];
          $objects[$index] = $objects[$index - 1];
          $objects[$index - 1] = $object;
          $this->saveSort($objects, $adminModel);
          return true;
        }
        
        if ($operation == 'down' && $index < count($objects)) {
          $object = $objects[$index];
          $objects[$index] = $objects[$index + 1];
          $objects[$index + 1] = $object;
          $this->saveSort($objects, $adminModel);
          return true;
        }
        
        return false;
    }
    
    function saveSort($objects, $adminModel) {
        foreach ($objects as $index => &$object) {
          $sort = $index + 1;
          $sql = "update {$this->_tableName} set {$this->_object['sort']} = {$sort} where {$this->_object['identity']} = {$object[$this->_object['identity']]}";
          $adminModel->executeQuery($sql);
        }
    }*/

    function post () {
        $post = $this->_loadPostHelper();
        $this->_filters = $post->GetFromPostByMask('filter_', true);

        $this->assign('filters', $this->_filters);
        $this->assign('post', $_POST);

        /*foreach($_POST as $key => $value) {
            $this->assign('post'$key, $value);
        }*/
    }

    function assignObjects() {
      $start = isset($_GET['start']) ? $_GET['start'] : $this->_start;
      $offset = isset($_GET['offset']) ? $_GET['offset'] : $this->_offset;

      $this->_adminModel = $this->_adminModel
          ->select($this->table);

      $number_operators = array();
      foreach ($this->_filters as $field => $value) {
          if (!empty($value)) {
              if ($this->fields[$field]['type'] == 'number') {
                  $operator = $_POST['number_operator_' . $field];
                  $number_operators[$field] = $operator;
                  $this->_adminModel = $this->_adminModel->where("$field $operator $value");
              }
              elseif ($this->fields[$field]['type'] == 'text') {
                $this->_adminModel = $this->_adminModel->where("$field LIKE '$value%'");
              } else {
                $this->_adminModel = $this->_adminModel->where("$field = '$value'");
              }
          }
      }

      $objects = $this->_adminModel
          ->limit($start, $offset)
          ->fetchAll();

      $this->findSelectFields($this->fields, $objects);

      $this->assign('number_operators', $number_operators);
      $this->assign('fields', $this->fields);
      $this->assign('identity', $this->identity);
      $this->assign('objects', empty($objects) ? null : $objects);
    }

    function findSelectFields(&$fields, &$objects) {
        foreach ($fields as $key => &$value) {
            if ($value['type'] == 'select') {
                require_once("classes/Objects/{$value['source']}.php");
                $class = new ReflectionClass($value['source']);
                try {
                    // Exists values, than object doesn't store in database
                    $value['values'] = $class->getProperty('values')->getValue();
                    foreach ($objects as $obj_key => &$object) {
                        $object[$key] = $value['values'][$object[$key]][$value['show_field']];
                    }
                } catch (Exception $ex) {
                    if (empty($objects)) {
                        return;
                    }
                    // Not exists values, than object stores in database
                    $table = $class->getProperty('table')->getValue();

                    $keys = array();

                    foreach ($objects as $obj_key => &$object) {
                        $keys[$object[$key]] = $object[$key];
                    }

                    if (empty($keys) || isset($value['autocomplete']))
                        continue;

                    $values = $this->_adminModel
                        ->select($table, "{$value['identity']}, {$value['show_field']}")
                        ->where($value['identity'] . " in (" . implode(',', $keys) . ")")
                        ->fetchAll($value['identity']);

                    $value['values'] = $values;

                    foreach ($objects as $obj_key => &$object) {
                        $object[$key] = $values[$object[$key]][$value['show_field']];
                    }
                }
            }
        }
    }
    
    function display($uniquePageValue = 'admin-objects')
	{
        /*
         * AdminBase_m
         */
		$this->_adminModel = $this->_getModelByName('AdminBase');
		
		$this->assignObjects();

		/*if ($this->sort($object, $adminModel)) {
		  $object = $this->loadObjects($adminModel);
		  header("Location: {$_SERVER['REDIRECT_URL']}");
		  exit();
		}*/


		
		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
}