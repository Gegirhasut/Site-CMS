<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'akcii')
	{
		$page_new = Router::getUrlPart(2);
		
		if (!empty($page_new)) {
			if ($page_new <= 0) {
				$page_new = 1;
			}
		} else {
			$page_new = 1;
		}
		
		$this->assignAkcii($page_new, 8);
		
		$this->assign('content_page', 'akcii');
		
		parent::display($uniquePageValue, false);
	}
}