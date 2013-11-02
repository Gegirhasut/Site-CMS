<?php
require_once('classes/Controllers/BaseAppController.php');

class BaseObject extends BaseAppController
{
	protected $_idIndex = 2;
	protected $_field = "id";
	protected $_loadedObject = null;
	
	function post() {
    }
    
    function loadObject($id) {
      $filter = "{$this->_field} = '$id'";
      $this->_loadedObject = $this->_adminModel->get($this->_object->_tableName, $filter);
    }
    
	function display($uniquePageValue = 'object')
	{
		if ($this->_object == null) {
			echo "define _object!";
			exit();
		}
		
		$filter = "";
		$id = Router::getUrlPart($this->_idIndex);
		$uniquePageValue .= '_' . $id;
		
		if ($this->assignValues('app/product-details.tpl', $uniquePageValue)) {
          $this->loadObject($id);
          
  		  $this->assignProductPaths($this->_object);

          $this->assign('object', empty($this->_loadedObject) ? null : $this->_loadedObject[0]);
		}
		
		parent::display($uniquePageValue);
	}
}