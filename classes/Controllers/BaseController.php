<?php
require_once('classes/setup.php');
require_once('classes/Math.php');

class BaseController extends MLM_Smarty
{
	protected $_templatePath;
	protected $_defaultPage = 'default.tpl';

    protected function loadClass($class_name, $assign = false) {
        if ($assign) {
            $this->assign('class', $class_name);
            $this->class_name = $class_name;
        }
        require_once("classes/Objects/$class_name.php");
        $class_description = new ReflectionClass($class_name);
        $class = $class_description->newInstance();
        return $class;
    }

	public function GetLastFiles($dir, $withDir = true) {
		$f = scandir($dir);
		$files = array();
		
		foreach ($f as $file){
			if ($file != '.' && $file != '..')
				if ($withDir) {
					$files[] = $dir . '/' . $file;
				} else {
					$files[] = $file;
				}
		}
		
		return $files;
	}
	
	public function GetLastFile($dir, $mask = null, $not_mask = null) {
		if (!is_null($not_mask)) {
			if (!is_array($not_mask)) {
				$not_mask = array($not_mask);
			}
		} else {
			$not_mask = array();
		}

		if (!is_null($mask)) {
			if (!is_array($mask)) {
				$mask = array($mask);
			}
		} else {
			$mask = array();
		}


		$f = scandir($dir);
		
		$lastFile = null;
		$lastFileTime = null;
 
		foreach ($f as $file){
		    if(preg_match('/\.(xls)/', $file)) {

		    	$should_be_break_by_mask = false;
			for ($i = 0; $i < count($mask); $i++) {
			    	if (!is_null($mask[$i]) && strpos($file, $mask[$i]) === false) {
			    		$should_be_break_by_mask = true;
			    	}
			}
			if ($should_be_break_by_mask) continue;

		    	$should_be_break = false;
			for ($i = 0; $i < count($not_mask); $i++) {
			    	if (strpos($file, $not_mask[$i]) !== false) {
			    		$should_be_break = true;
					break;
			    	}
			}
			if ($should_be_break) continue;

		    	$fileStat = stat($dir . '/' . $file);

//		    	echo "check $file {$fileStat['mtime']}<br/>";
		    	
		        if ($lastFile == null) {
		        	$lastFile = $file;
		        	$lastFileTime = $fileStat['mtime'];
		        }
		        if ($fileStat['mtime'] > $lastFileTime) {
		        	$lastFile = $file;
		        	$lastFileTime = $fileStat['mtime'];
		        }
		    }
		}
//		echo "exit: $lastFile<br/><br/>";
		return $lastFile;
	}
	
	public function AssignFilters(&$object, $adminModel) {
	  if (!isset($object['filters'])) {
	    return;
	  }
	  
	  foreach ($object['filters'] as $filter_field => $k) {
	    $field = &$object['fields'][$filter_field];
	    
        $select = $adminModel->get($field['join']);
	    $field['values'] = $select;
	  }
	}
	
	public function CheckObject(&$object, $tableName = null) {
	  foreach ($object['fields'] as $key => &$post_parameter) {
	    if (isset($post_parameter['check'])) {
	      $checks = explode(',', $post_parameter['check']);
	       
	      foreach ($checks as $check) {
	    				switch ($check) {
	    				  case 'password' :
	    				    if (empty($post_parameter['value']) || $post_parameter['value'] == 'NULL') {
	    				      $object['check_error'] = "Задайте пароль!";
	    				      $this->EmptyNulls($object);
	    				      return false;
	    				    }
	    				    break;
	    				  case 'empty' :
	    				    if (empty($post_parameter['value']) || $post_parameter['value'] == 'NULL') {
	    						    $object['check_error'] = "Вы не задали поле '" . $post_parameter['title'] . "'";
	    						    $this->EmptyNulls($object);
	    						    return false;
	    				    }
	    				    break;
	    				  case 'unique':
	    				    if ($post_parameter['value'] != 'NULL' && $tableName != null) {
	    				      $record = $this->_adminModel->get($tableName, " $key = '{$post_parameter['value']}'");
	    				      if (!empty($record)) {
	    				        $object['check_error'] = "Пользователь с {$post_parameter['title']} = {$post_parameter['value']} уже существует!";
	    				        $this->EmptyNulls($object);
	    				        return false;
	    				      }
	    				    }
	    				    break;
	    				  case 'email':
	    				    if (empty($post_parameter['value']) || filter_var($post_parameter['value'], FILTER_VALIDATE_EMAIL) === false) {
	    				      $object['check_error'] = "E-mail задан неверно!";
	    				      $this->EmptyNulls($object);
	    				      return false;
	    				    }
	  						    break;
	    				  case 'url':
	    				    if (empty($post_parameter['value']) || filter_var($post_parameter['value'], FILTER_VALIDATE_URL) === false) {
	    				      $object['check_error'] = "Адресная строка задана не верно!";
	    				      $this->EmptyNulls($object);
	    				      return false;
	    				    }
	    				    break;
	    				}
	      }
	    }
	  }
	
	  return true;
	}
	
	public function EmptyNulls(&$object) {
	  foreach ($object['fields'] as $key => &$post_parameter) {
	    if (isset($post_parameter['value']) && $post_parameter['value'] == 'NULL') {
	      $post_parameter['value'] = '';
	    }
	  }
	}
	
	public function ParsePost(&$fields) {
        $subValues = array();
		$postHelper = $this->_loadPostHelper();
		
		foreach ($fields as $key => &$post_parameter) {
            if ($post_parameter['type'] == 'images') {
                $post_parameter['value'] = $postHelper->GetFromPost($key);
                $images = $postHelper->GetFromPostByMask('images_' . $key . '_');
                $post_parameter['subvalue'] = array();
                $subValues[] = $key;

                if (!empty($images)) {
                    foreach ($images as $image) {
                        $post_parameter['subvalue'][] = $image;
                    }
                }
            } elseif (isset($post_parameter['link']) && !isset($post_parameter['value']) && $postHelper->GetFromPost($key) == null) {
		    } elseif ($post_parameter['type'] == 'checkbox') {
		        $post_parameter['value'] = $postHelper->GetFromPost($key) != null ? 1 : 0;
		    } elseif ($post_parameter['type'] == 'list') {
		        $post_parameter['value'] = $postHelper->GetFromPost($key);
		        $object['list_key'] = $key;
		    } else {
			    $post_parameter['value'] = $postHelper->GetFromPost($key);
			    if ($post_parameter['value'] == null && !isset($post_parameter['identity'])) {
			      if (isset($post_parameter['integer'])) {
			          $post_parameter['value'] = "0";
			      } else {
		              $post_parameter['value'] = "NULL";
			      }
			    }
		    }
		}

        return $subValues;
	}
	
	public function post()
	{
		echo "POST from BaseController. You should define function post in your controller.";
		exit();
	}
	
	public function setTemplatePath($template)
	{
		$this->_templatePath = $template;
	}
	
	function display($uniquePageValue)
	{
		$this->assign('v', 4);
		$this->assign('page', $this->_templatePath);
		parent::display($this->_defaultPage, $uniquePageValue);
	}
	
	protected function _getModel()
	{
		require_once(Router::getModelPath());
		$model = new ReflectionClass(Router::getModelClassName());
		$m = $model->newInstance();
		return $m;
	}

	protected function _getModelByName($modelName)
	{
		require_once(Router::getModelFolder()  . "/" . $modelName . "_m.php");
		$model = new ReflectionClass($modelName . "_m");
		$m = $model->newInstance();
		return $m;
	}
	
	protected function _loadPostHelper()
	{
		require_once('helpers/PostHelper.php');
		return new PostHelper();
	}
	
	protected function _loadImageUploader()
	{
		require_once('helpers/ImageUploader.php');
		return new ImageUploader();
	}
	
	protected function _loadEmail()
	{
		require_once('helpers/Email.php');
		return new Email();
	}
}