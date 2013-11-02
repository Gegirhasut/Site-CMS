<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'news')
	{
		$this->assignPartners();
		
		$this->assign('content_page', 'partners');
		
		parent::display($uniquePageValue, false);
	}
}