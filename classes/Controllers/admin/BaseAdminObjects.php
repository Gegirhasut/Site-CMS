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

      if (isset($this->class->group) && isset($_POST[$this->class->group])) {
          $page = 1;
          $offset = 99999;
      } else if (isset($this->class->sort)) {
          $page = 1;
          $offset = 99999;
      }

      if (isset($this->class->sort)) {
          if ((isset($this->class->group) && !empty($_POST[$this->class->group])) || !isset($this->class->group)) {
            $this->_adminModel->orderBy($this->class->sort);
          }
      }

      $objects = $this->_adminModel
          ->limit(($page - 1) * $offset, $offset)
          ->fetchAll();

      $this->calculatePages($page, $offset);

      $this->findSelectFields($this->class->fields, $objects);

      $this->assign('number_operators', $number_operators);

      if (isset($this->class->images)) {
        $this->assign('images', $this->class->images);
      }

      $this->assign('fields', $this->class->fields);
      if (isset($this->class->sort)) {
          if (!isset($this->class->group) || (isset($this->class->group) && !empty($_POST[$this->class->group]))) {
            $this->assign('sort', $this->class->sort);
          }
          if (isset($this->class->group)) {
              $this->assign('group', $this->class->group);
          }
      }
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
                        if ($object[$key] != 0) {
                            $object[$key] = $value['values'][$object[$key]][$value['show_field']];
                        } else {
                            $object[$key] = '';
                        }
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
                            if (isset ($value['values'][$object[$key]])) {
                                $object[$key] = $value['values'][$object[$key]][$value['show_field']];
                            } else {
                                $object[$key] = '-';
                            }
                        }
                    } else {
                        $values = $this->_adminModel
                            ->select($table, "{$value['identity']}, {$value['show_field']}")
                            ->fetchAll($value['identity']);

                        $value['values'] = $values;

                        foreach ($objects as $obj_key => &$object) {
                            if (isset ($object[$key])) {
                                $object[$key] = $values[$object[$key]][$value['show_field']];
                            }
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

		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
}