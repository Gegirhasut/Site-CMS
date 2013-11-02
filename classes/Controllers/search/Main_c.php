<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'search')
	{
		require_once('classes/Objects/Product.php');
		$product = new Product();
			
		$postHelper = $this->_loadPostHelper();
		$search_text = $postHelper->GetFromGet('text');
		$code = $postHelper->GetFromGet('code');
		
		if (!empty($code)) {
			$code = (int) $search_text;
			$this->assign('code_on', 1);
			$this->assign('content_page', 'search');
			
			$this->_adminModel = $this->_getModelByName('AdminBase');
			$products = $this->_adminModel->get($product->_tableName, "code = $code");
			if (!empty($products)) {
				header('Location: /products/' . $products[0]['url'] . '?text=' . $search_text);
				exit;
			}
		} else {
			$products = $this->_adminModel->get($product->_tableName, "MATCH (code, name, description) AGAINST('*$search_text*' IN BOOLEAN MODE)");
		}
		
		$this->assign('content_page', 'search');
		$this->assign('search', true);
		$this->assign('search_text', $search_text);
		$this->assign('results', $products);
		
		parent::display($uniquePageValue);
	}
}