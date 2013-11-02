<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'new')
	{
		$new_url = Router::getUrlPart(2);
		if (!empty($new_url)) {
			$this->assignNew($new_url);
			$this->assignAkcii(1, 8, false);
		} else {
			header ('Location: /');
			exit;
		}
		
		$this->assign('content_page', 'new');
		
		parent::display($uniquePageValue);
	}
}