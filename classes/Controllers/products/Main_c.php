<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'new')
	{
		$new_url = Router::getUrlPart(2);
		if (!empty($new_url)) {
			$this->assignProduct($new_url);
			$this->assignAkcii(1, 8, false);
			$this->assignNews(1, 8, false);
		} else {
			header ('Location: /');
			exit;
		}
		
		$postHelper = $this->_loadPostHelper();
		$search_text = $postHelper->GetFromGet('text');
		if (!empty($search_text)) {
			$this->assign('search_text', $search_text);
			$this->assign('code_on', 1);
		}
		
		$this->assign('content_page', 'product');
		
		parent::display($uniquePageValue);
	}
}