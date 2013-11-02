<?php
require_once('classes/Controllers/BaseAppController.php');
require_once('helpers/Cart.php');

class Main_c extends BaseAppController
{
	protected $_cart;
	
	function __construct() {
		parent::__construct();
		$this->_cart = new Cart($this->_adminModel);
	}
	
	function post()
	{
	}
	
	function loadCartProducts() {
	    $totalPrice = $this->_cart->loadProducts();
	    $this->assign('products', $this->_cart->getLoadedObject());
	    $this->assign('totalPrice', $totalPrice);
	}
	
	function display($uniquePageValue = 'cart')
	{ 
		$operation = $this->_loadPostHelper()->GetFromGet('operation');
		if ($operation == 'add') {
			$count = (int) $this->_loadPostHelper()->GetFromGet('count');
			if ($count == null) {
				$count = 1;
			}
		    $id = $this->_loadPostHelper()->GetFromGet('id');
			$this->_cart->addProductToCart($id, $count);
		}
		
		if ($operation == 'get') {
		  $result = $this->_cart->getCartInfo();
		  $this->_cart->showResult($result);
		}
		
		if ($operation == 'all') {
		  $ids = $this->_cart->getCart();
		  $idsArray = array();
		  foreach ($ids as $key => $value) {
		  	$idsArray[] = array ('id' => $key, 'count' => $value['c']);
		  }
		  $this->_cart->showResult($idsArray);
		}
		
		if ($operation == 'clean') {
			$this->_cart->clean();
		}
		
		if ($operation == 'update') {
		  $id = $this->_loadPostHelper()->GetFromGet('id');
		  $count = $this->_loadPostHelper()->GetFromGet('count');
		  $result = $this->_cart->updateCart($id, $count);
		  $this->_cart->showResult($result);
		}
		
        $this->loadCartProducts();
		// $this->assignValues('app/show-cart.tpl', $uniquePageValue);
		// $this->assignProductPaths($this->_cart->getObject());
		
        $this->assign('content_page', 'cart');
		
		parent::display($uniquePageValue);
	}
}