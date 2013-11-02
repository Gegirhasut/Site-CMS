<?php
require_once('classes/Controllers/admin/BaseAdminObject.php');

class Main_c extends BaseAdminSecurity
{
	public function post() {
		$postHelper = $this->_loadPostHelper();
		
		if ($postHelper->GetFromPost('uploadfiles')) {
    		$this->uploadFiles();
		} else {
			$operation = $this->_loadPostHelper()->GetFromPost('operation');
	        $this->ParsePost($this->_object);
	        $adminModel = $this->_getModelByName('AdminBase');
		}
	}
    public function __construct() {
        $class_name = Router::getUrlPart(3);
        require_once("classes/Objects/$class_name.php");
        $class_description = new ReflectionClass($class_name);
        $class = $class_description->newInstance();
        
        $this->_object = $class->_object;
    }
    
    function uploadFiles() {
    	if (!empty($_FILES)) {
    		for ($i = 1; $i <= 3; $i++) {
    			if(isset($_FILES['file' . $i])) {
					$tmpFile = $_FILES['file' . $i]['tmp_name'];
					$fileName = $_FILES['file' . $i]['name'];
					$filePath = "rassilka/" . $fileName;
					
					if (file_exists($filePath)) {
						$this->assign('removed', 1);
						unlink ($filePath);
					}
					
					if (move_uploaded_file ($tmpFile, $filePath)) {
						
						$this->assign('uploaded', 1);
					} else {
						$this->assign('error', 'Проблема при загрузке файла');
					}
    			}
    		}
		} else {
			$this->assign('error', 'Файл не был загружен');
		}
    }
    
	function display($uniquePageValue = 'rassilka')
	{
		$rassilkaFolder = 'rassilka';
		
		$postHelper = $this->_loadPostHelper();
		$unlink = $postHelper->getFromGet('unlink');
		if (!empty($unlink) && file_exists($rassilkaFolder . '/' . $unlink)) {
			unlink ($rassilkaFolder . '/' . $unlink);
			header('Location: /admin/add-update/Rassilka/');
			exit;
		}
		
		$adminModel = $this->_getModelByName('AdminBase');
		$this->_defaultPage = "admin/admin-rassilka.tpl";
		
		foreach ($this->_object['fields'] as &$field) {
		  if ($field['type'] == 'select' && empty($field['values'])) {
		    $filter = '';
		    if (isset($field['filter'])) {
		      $filter = $field['filter'];
		    }
		    $select = $adminModel->get($field['join'], $filter);
		    $field['values'] = $select;
		  }
		}
		
		$this->assign('fields', $this->_object);
		
		$object = array();
		foreach ($this->_object['fields'] as $key => $value) {
			if (isset($value['value'])) {
				$object[$key] = $value['value'];
			}
		}
		
		$this->assign('files', $this->GetLastFiles($rassilkaFolder, false));
		
		$this->assign('object', $object);
		
		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
  
    protected $_idIndex = 4;
    
    protected $_object = null;
    
    protected $_tableName = null;
}