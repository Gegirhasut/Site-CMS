<?php
require_once('classes/Controllers/BaseAppController.php');
require_once('classes/Objects/Section.php');

class Main_c extends BaseAppController
{
    function assignData($sectionUrl, $filter = null)
    {
      $className = ucfirst($sectionUrl);
      $data = null;
      
      if (file_exists("classes/Objects/$className.php")) {
          require_once("classes/Objects/$className.php");
          $object = new $sectionUrl();
          if ($filter == null) {
            $data = $this->_adminModel->get($object->_tableName);
            $this->assign('section_data', "app/list-$sectionUrl.tpl");
          } else {
            $data = $this->_adminModel->get($object->_tableName, "url = '{$filter}'");
            $this->assign('section_data', "app/show-$sectionUrl.tpl");
          }
          $this->assign('fields', $object->_object);
      }
      
      if ($data != null) {
          $this->assign('data', $data);
      }
    }
  
	function display($uniquePageValue = 'sections')
	{ 
	    $sectionUrl = Router::getUrlPart(2);
	    
	    $filter = Router::getUrlPart(3);
	    
	    $uniquePageValue = "1_setion_" . $sectionUrl . "_" . $filter;
	  
		$this->caching = false;

		if (!parent::is_cached($this->_defaultPage, $uniquePageValue)) {
		    $categories = $this->assignCategories();
		    $news = $this->assignNews();
		    $sections = $this->assignSections();
		    
		    $section = new Section();
		    
		    $sectionContent = $this->_adminModel->get($section->_tableName, "url = '$sectionUrl'");
		    
		    $this->assign('sectionUrl', $sectionUrl);
		    $this->assign('section', $sectionContent[0]);
		    
		    $this->assignData($sectionUrl, $filter);
		    
		    $this->setTemplatePath('app/section.tpl');
		}
				
		parent::display($uniquePageValue);
	}
}