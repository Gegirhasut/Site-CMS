<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'akcia')
	{
		$new_url = Router::getUrlPart(2);
		if (!empty($new_url)) {
			$this->assignAkcia($new_url);
			$this->assignNews(1, 8, false);
		} else {
			header ('Location: /');
			exit;
		}
		
		$this->assign('content_page', 'akcia');
		
		parent::display($uniquePageValue);
	}
}