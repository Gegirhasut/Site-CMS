<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class Main_c extends BaseAdminSecurity
{
    function post() {
    }    
    
	function display($uniquePageValue = 'admin')
	{
	    
		$this->_defaultPage = "admin/admin.tpl";
		$this->assign('pages', $this->_pages);
		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
}