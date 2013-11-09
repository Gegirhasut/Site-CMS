<?php
require_once('classes/Controllers/BaseController.php');

class BaseAdminStructure extends BaseController
{
    protected $_pages = array (
      'Разделы сайта' => array('url' => '/admin/list/Section/'),
      'Машины' => array('url' => '/admin/list/Car/'),
      'Юзеры' => array('url' => '/admin/list/User/'),
      'Посмотреть сайт' => array('url' => '/', 'blank' => 1)
    );
    
    function display($uniquePageValue)
	{
		$this->assign('pages', $this->_pages);
		$adminPagesMenu = $this->fetch('admin/admin-pages.tpl');
		$this->assign('menu', $adminPagesMenu);
		
		parent::display($uniquePageValue);
	}
}