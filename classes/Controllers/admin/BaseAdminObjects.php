<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class BaseAdminObjects extends BaseAdminSecurity
{
    protected $_defaultPage = "admin/list/objects.tpl";
    protected $_page = 1;
    protected $_offset = 15;
    protected $_filters = array ();
    /**
     * @var AdminBase_m
     */
    protected $_adminModel;

    public function __construct() {
        parent::__construct();
        $this->class = $this->loadClass(Router::getUrlPart(3), true);
    }
    
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
        $this->parsePostOnFilters();
    }

    function parsePostOnFilters() {
        $post = $this->_loadPostHelper();

        $this->_filters = $post->GetFromPostByMask('filter_', true);

        $this->assign('filters', $this->_filters);
        $this->assign('post', $_POST);

        $filter = array(
            'post' => $_POST
        );
        $_SESSION['filter_' . $this->class_name] = $filter;
    }

    function assignObjects() {
      $page = isset($_GET['page']) ? $_GET['page'] : $this->_page;
      $offset = isset($_GET['offset']) ? $_GET['offset'] : $this->_offset;

      $this->_adminModel = $this->_adminModel
          ->select($this->class->table, 'SQL_CALC_FOUND_ROWS *');

      $number_operators = array();

      foreach ($this->_filters as $field => $value) {
          if (!empty($value)) {
              if ($this->class->fields[$field]['type'] == 'number') {
                  $operator = $_POST['number_operator_' . $field];
                  $number_operators[$field] = $operator;
                  $this->_adminModel = $this->_adminModel->where("$field $operator $value");
              }
              elseif ($this->class->fields[$field]['type'] == 'text') {
                $this->_adminModel = $this->_adminModel->where("$field LIKE '$value%'");
              } else {
                $this->_adminModel = $this->_adminModel->where("$field = '$value'");
              }
          }
      }

      $objects = $this->_adminModel
          ->limit(($page - 1) * $offset, $offset)
          ->fetchAll();

      $this->calculatePages($page, $offset);

      $this->findSelectFields($this->class->fields, $objects);

      $this->assign('number_operators', $number_operators);
      $this->assign('fields', $this->class->fields);
      $this->assign('identity', $this->class->identity);
      $this->assign('objects', empty($objects) ? null : $objects);
    }

    function calculatePages($page, $offset) {
        $rowsCount = $this->_adminModel->getRowsCount();
        $pages = (int) ($rowsCount / $offset);
        if ($pages * $offset < $rowsCount) {
            $pages++;
        }

        $this->assign('pagesCount', $pages);
        $this->assign('currentPage', $page);
    }

    function findSelectFields(&$fields, &$objects) {
        foreach ($fields as $key => &$value) {
            if ($value['type'] == 'select') {
                $select_class = $this->loadClass($value['source']);

                if (isset($select_class->values))
                {
                    // Exists values, than object doesn't store in database
                    $value['values'] = $select_class->values;
                    foreach ($objects as $obj_key => &$object) {
                        $object[$key] = $value['values'][$object[$key]][$value['show_field']];
                    }
                } else {
                    // Not exists values, than object stores in database
                    $table = $select_class->table;

                    if (isset($value['autocomplete'])) {
                        if (empty($objects))
                            continue;
                        $ids = array();
                        //print_r($objects);exit;
                        foreach ($objects as $obj) {
                            //$ids[$obj[$value['identity']]] = $obj[$value['identity']];
                            $ids[$obj[$key]] = $obj[$key];
                        }

                        $ids = implode(',', $ids);
                        $values = $this->_adminModel
                            ->select($table, "{$value['identity']}, {$value['show_field']}")
                            ->where("{$value['identity']} in ($ids)")
                            ->fetchAll($value['identity']);

                        $value['values'] = $values;

                        foreach ($objects as $obj_key => &$object) {
                            $object[$key] = $value['values'][$object[$key]][$value['show_field']];
                        }
                    } else {
                        $values = $this->_adminModel
                            ->select($table, "{$value['identity']}, {$value['show_field']}")
                            ->fetchAll($value['identity']);

                        $value['values'] = $values;

                        foreach ($objects as $obj_key => &$object) {
                            $object[$key] = $values[$object[$key]][$value['show_field']];
                        }
                    }
                }
            }
        }
    }
    
    function display($uniquePageValue = 'admin-objects')
	{
        if (empty($_POST) && isset($_SESSION['filter_' . $this->class_name])) {
            $_POST = $_SESSION['filter_' . $this->class_name]['post'];
            $this->parsePostOnFilters();
        }

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