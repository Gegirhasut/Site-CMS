<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');
require_once('classes/Objects/Category.php');
require_once('classes/Objects/Product.php');

class Main_c extends BaseAdminSecurity
{
    private $_postHelper = null;
    
    function post() {
        
    }
    
    function getCategories($adminModel, $category) {
      $categories = $adminModel->get($category->_tableName, "parent_id is NULL");
      $sub_categories = $adminModel->get($category->_tableName, "parent_id is not NULL order by parent_id");
      
      $result_array = array();
      $i = 0;
      foreach ($categories as $c) {
        $result_array[] = $c;
        while ($i < count ($sub_categories) && $sub_categories[$i]['parent_id'] == $c['cat_id']) {
          $result_array[] = $sub_categories[$i++];
        }
      }
      $this->assign('categories', $result_array);
    }
    
	function display($uniquePageValue = 'admin')
	{   
	    $product = new Product();
	    $category = new Category();
	    
	    $categoryFilter = "";
	    $cat_id = Router::getParams('cat_id');
	    
	    $adminModel = $this->_getModelByName('AdminBase');
	    
	    if ($cat_id != null) {
	        $categoryFilter = "cat_id = $cat_id";
	        $current_category = $adminModel->get($category->_tableName, $categoryFilter);
	        if (!empty($current_category)) { 
		        $products_in_category = $adminModel->get($product->_tableName, $categoryFilter);
		        $adminModel->fixTextareas($product->_object, $products_in_category);
		        $this->assign('products', $products_in_category);
		        $this->assign('current_category', $current_category[0]);
	        }
	    }  
	    
	    $this->assign('fields', $product->_object);
	    
	    $this->getCategories($adminModel, $category);
	    
		$this->_defaultPage = "admin/admin-products.tpl";

		$this->caching = false;		
		parent::display($uniquePageValue);
	}
}