<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'main')
	{	
		$this->assignNews(1, 8, false);
		$this->assignAkcii(1, 8, false);
		
		$category_url = Router::getUrlPart(1);
		$sub_category_url = Router::getUrlPart(2);
		
		if (isset($_GET['show'])) {
			$_SESSION['show'] = (int) $_GET['show'];
		}
		
		$postHelper = $this->_loadPostHelper();
		
		if (isset($_GET['sort'])) {
			$_SESSION['sort'] = $postHelper->GetFromGet('sort');
			if ($_SESSION['sort'] == 'code') {
				$_SESSION['sort'] = 'code+0';
			}
		}
		
		if (isset($_GET['unsubscribe'])) {
			$this->assign('unsubscribe', 'Вы отписались от рассылки!');
		}
		
		if (isset($_GET['direction'])) {
			$_SESSION['direction'] = $postHelper->GetFromGet('direction') == 1 ? 'asc' : 'desc';
		}
		
		if (((int)$sub_category_url) != 0) {
			$page = (int)$sub_category_url;
			$sub_category_url = null;
		} else {
			$page = (int) Router::getUrlPart(3);
		}
		
		if ($page <= 0) {
			$page = 1;
		}
		
		if ($sub_category_url != null) {
			$this->assignProducts($sub_category_url, $page, "$category_url/");
			$this->assign('content_page', 'products');
		} elseif ($category_url != null) {
			$this->assignProducts($category_url, $page);
			$this->assign('content_page', 'products');
		} else {
			$this->assignNewProducts();
			$this->assign('content_page', 'main');
		}
		
		parent::display($uniquePageValue);
	}
}