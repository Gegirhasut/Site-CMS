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

      $fields = $this->class->getProperty('fields')->getValue();
      $table = $this->class->getProperty('tableName')->getValue();
      $identity = $this->class->getProperty('identity')->getValue();

      $this->_adminModel = $this->_adminModel
          ->select($table);

      foreach ($this->_filters as $field => $value) {
          if (!empty($value)) {
              $this->_adminModel = $this->_adminModel->where("$field = '$value'");
          }
      }

      $objects = $this->_adminModel
          ->limit($start, $offset)
          ->execute();

      //echo "objects:<br>";print_r($objects);exit;
      $this->findSelectFields($fields, $objects);
      //echo "<br>fields:<br>";
      //print_r($fields);

      $this->assign('objects', empty($objects) ? null : $objects);

      $this->assign('fields', $fields);
      $this->assign('identity', $identity);
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
                    // Not exists values, than object stores in database
                    $table = $class->getProperty('tableName')->getValue();

                    $keys = array();

                    foreach ($objects as $obj_key => &$object) {
                        $keys[$object[$key]] = $object[$key];
                    }
                    if (empty($keys))
                        continue;

                    $values = $this->_adminModel
                        ->select($table, "{$value['identity']}, {$value['show_field']}")
                        ->where($value['identity'] . " in (" . implode(',', $keys) . ")")
                        ->execute($value['identity']);

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