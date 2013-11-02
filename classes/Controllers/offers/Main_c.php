<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'news')
	{
		$offer = Router::getUrlPart(2);
		
		$this->assignSubCategories($offer);
		
		$this->assign('content_page', 'offers');
		
		parent::display($uniquePageValue);
	}
}