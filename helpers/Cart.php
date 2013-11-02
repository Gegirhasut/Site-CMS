<?php
require_once('classes/Objects/Product.php');

class Cart {
	protected $_field = null;
	protected $_object = null;
	protected $_loadedObject = null;
	protected $_adminModel = null;
	protected $_cartSize = 50;
	protected $_maxCartSize = 50;
	
	function getObject() {
		return $this->_object; 
	}
	
	function getLoadedObject() {
		return $this->_loadedObject; 
	}
	
	function __construct($adminModel) {
		$this->_object = new Product();
		$this->_field = $this->_object->_object['identity'];
		$this->_adminModel = $adminModel;
	}
	
	function loadProduct($id) {
	  $fields = "{$this->_object->_tableName}.r_id, {$this->_object->_tableName}.price, {$this->_object->_tableName}.opt_price";
	  
	  $this->_loadedObject = $this->_adminModel->get(
	    $this->_object->_tableName,
    	       "where {$this->_field} = $id",
    	       false,
               $fields
	  );
	}
	
	function getCart() {
		if (isset($_COOKIE['cartsCount'])) {
			$cartsCount = $_COOKIE['cartsCount'];
			
			$resultArray = array();
			for ($i = 0; $i < $cartsCount; $i++) {
			    $cookie_cart = base64_decode($_COOKIE['cart_' . $i]);
			    $cookie_cart = str_replace("\\\"", "\"", $cookie_cart);
			    $cartPart = unserialize($cookie_cart);
			    
			    foreach ($cartPart as $key => $product)  {
			    	$resultArray[$key] = $product;
			    }
			    
			}
			
			return $resultArray;
		}
		
	  	return null;
	}
	
	function getIds($cart) {
	    $ids = null;
	    foreach ($cart as $key => $product) {
	      $ids .= ($ids == null) ? $key : ", $key";
	    }
	    
	    return $ids;
	}
	
	function loadProducts() {
	  $totalPrice = 0;
	  $cart = $this->getCart();
	  
	  if ($cart != null) {
	    $ids = $this->getIds($cart);
  	    $fields = "{$this->_object->_tableName}.r_id,
  	    {$this->_object->_tableName}.cat_id,
        {$this->_object->_tableName}.name,
        {$this->_object->_tableName}.code,
  	    {$this->_object->_tableName}.price,
  	    {$this->_object->_tableName}.opt_price";
  	   
  	    $this->_loadedObject = $this->_adminModel->get(
  	    $this->_object->_tableName,
  		       "where {$this->_field} in ($ids)",
  	           false,
  	           $fields
  	    );
	  }
	  
	  $idsArray = array();
	  if (isset($ids)) {
		  foreach (split(', ', $ids) as $id) {
		  	$idsArray[$id] = 0;
		  }
	  }
	  
	  if ($this->_loadedObject != null) {
		  foreach ($this->_loadedObject as &$object) {
		    $id = $object[$this->_object->_object['identity']];
		    $object['count'] = $cart[$id]['c'];
		    
		    $idsArray[$id] = 1;
		    
		    if (isset($_SESSION['user']) && $_SESSION['user']['state'] == 1) {
		    	$object['totalPrice'] = $object['count'] * $object['opt_price'];
		    } else {
		    	$object['totalPrice'] = $object['count'] * $object['price'];
		    }
		    
		    $totalPrice += $object['totalPrice'];
		  }
	  }

	  if (empty($idsArray)) {
		  foreach ($idsArray as $key => $value) {
		  	if ($value == 0) {
		  		$this->updateCart($key, 0);
		  	}
		  }
	  }
	  
	  return $totalPrice;
	}
	
	function saveCart($fullCart, $price, $count) {
		$cart = array();
		$i = 0;
		$cartNum = 0;
		
		foreach ($fullCart as $key => $product) {
			if ($i == $this->_cartSize) {
				$i = 0;
				
				setcookie('cart_' . $cartNum, base64_encode(serialize($cart)), time()+3600*24*30);
				$cart = array();
				$cartNum++;
			}
			$cart[$key] = $product;
			$i++;
		}
		
		setcookie('cart_' . $cartNum, base64_encode(serialize($cart)), time()+3600*24*30);
		
	    setcookie('price', $price, time()+3600*24*30);
	    setcookie('count', $count, time()+3600*24*30);
	    setcookie('cartsCount', $cartNum + 1, time()+3600*24*30);
	}
	
	function clean() {
		setcookie('cart', '', time()-3600);
		setcookie('cartsCount', '', time()-3600);
		setcookie('price', '', time()-3600);
		setcookie('count', '', time()-3600);
		exit();
	}
	
	function addProductToCart($id, $addCount = 1)
	{
		$cart = array();
		
		//setcookie('cart', '', time()-3600); setcookie('price', '', time()-3600); setcookie('count', '', time()-3600); exit();
		
		$cart = $this->getCart();
		if (isset($cart[$id])) {
			$price = $cart[$id]['p'] * $addCount;
			$cart[$id]['c'] += $addCount;
		} else {
			if (count($cart) == $this->_maxCartSize) {
				$result = array();
				$result['count'] = $_COOKIE['count'];
				$result['price'] = $_COOKIE['price'];
				echo arrayToJson($result);
				exit;
			}
		    $this->loadProduct($id);
		    if (isset($_SESSION['user']) && $_SESSION['user']['state'] == 1) {
		    	$price = $this->_loadedObject[0]['opt_price'];
		    } else {
		    	$price = $this->_loadedObject[0]['price'];
		    }
		    
		    $cart[$id] = array('p' => $price, 'c' => $addCount);
		    
		    $price = $price * $addCount;
		}
		
		if (isset($_COOKIE['price'])) {
		  $price += $_COOKIE['price'];
		}
		
		if (isset($_COOKIE['count'])) {
		  $count = $_COOKIE['count'] + $addCount;
		} else {
		  $count = $addCount;
		}

		
		$this->saveCart($cart, $price, $count);
		
		$result = array();
		$result['count'] = $count;
		$result['price'] = $price;
		
		require_once('helpers/json.php');
		echo arrayToJson($result);
		exit();
	}
	
	function getCartInfo($cart = null) {
	  $result = array();
	  $result['count'] = 0;
	  $result['price'] = 0;
	  
	  if (!isset($_COOKIE['cartsCount'])) {
	  	  $this->clean();
	  	  return $result;
	  }
	  
	  if ($cart == null) {
	      $cart = $this->getCart();
	  }
	  
   	  foreach ($cart as $product) {
  		  $result['count'] += $product['c'];
  		  $result['price'] += $product['c'] * $product['p'];
  	  }
	  
	  return $result;
	}
	
	function showResult($result) {
	  require_once('helpers/json.php');
	  echo arrayToJson($result);
	  exit();
	}
	
	function updateCart($id, $count) {
	  $cart = $this->getCart();
	  
	  if (isset($cart[$id])) {
	    $result = $this->getCartInfo($cart);
	    
	    $deltaCount = ($count - $cart[$id]['c']);
	    $deltaPrice = $deltaCount * $cart[$id]['p'];
	    $cart[$id]['c'] = $count;
	    
	    $result['count'] += $deltaCount;
	    $result['price'] += $deltaPrice;
	    
	    if ($cart[$id]['c'] == 0) {
	      unset($cart[$id]);
	      $result['del'] = 1;
	    } else {
	      $result['new_count'] = $cart[$id]['c'];
	      $result['new_price'] = $cart[$id]['c'] * $cart[$id]['p'];
	      $result['delete'] = 0;
	    }
	    
	    $this->saveCart($cart, $result['price'], $result['count']);
	  }
	  
	  return $result;
	}
}