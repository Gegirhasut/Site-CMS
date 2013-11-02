<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function assignOrder ($o_id, $hash = null) {
		$o_id = (int) $o_id;
		
		require_once('classes/Objects/OrderProduct.php');
		require_once('classes/Objects/Product.php');
		require_once('classes/Objects/Order.php');
		
		$order_product = new OrderProduct();
		$product = new Product();
		$order = new Order();

        if ($hash == -1) {
            $order = $this->_adminModel->get(
                $order->_tableName,
                "o_id = '$o_id'");
        } else {
            $order = $this->_adminModel->get(
                $order->_tableName,
                "o_id = '$o_id' and number = '$hash'");
        }

        if (empty($order)) {
            header('Location: /');
            exit;
        }

  	    $opt = false;
    	if ($order[0]['opt'] == 1) {
    		$opt = true;
    	}

		$products = $this->_adminModel->get(
  	    	$order_product->_tableName,
  		    "left join {$product->_tableName} on {$product->_tableName}.r_id = {$order_product->_tableName}.p_id
  		    where {$order_product->_tableName}.o_id = $o_id",
  	        false
  	    );
  	    
  	    $totalPrice = 0;
		$totalCount = 0;
		
		foreach ($products as &$p) {
			if ($opt) {
				$p['price'] = $p['opt_price'];
			}
			
			$pPrice = $p['price'] * $p['count'];
			$p['totalPrice'] = $pPrice;
			$totalPrice += $pPrice;
			$totalCount += $p['count'];
		}

  	    if (!empty($order)) {
  	    	$this->assign('order', $order[0]);
  	    	$this->assign('totalCount', $totalCount);
  	    	$this->assign('products', $products);
  	    	$this->assign('totalPrice', $totalPrice);
  	    	
  	    	if ($order[0]['discount_percent'] != 0) {
  	    		$this->assign('discount', $order[0]['discount']);
  	    		$this->assign('discount_percent', $order[0]['discount_percent']);
  	    		$totalPrice = round($totalPrice / 100 * (100 - $order[0]['discount_percent']), 2);
  	    		$this->assign('totalDiscountPrice', $totalPrice);
  	    	}	
  	    }
	}
	
	function display($uniquePageValue = 'order')
	{
		$order = Router::getUrlPart(2);
		
		if (empty($order)) {
			header('location: /checkout_success/');
			exit;
		}
		
		if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'checkout') !== false) {
			$this->assign('clean_cart', 1);
		}

        if ($order > 60) {
            $postHelper = $this->_loadPostHelper();
            $hash = $postHelper->GetFromGet('hash');
        } else {
            $hash = -1;
        }

		$this->assignOrder($order, $hash);
		
		$this->caching = false;
		
		$this->assign('content_page', 'order');
		
		parent::display($uniquePageValue);
	}
}