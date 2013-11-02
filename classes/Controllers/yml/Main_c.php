<?php
require_once('classes/Controllers/BaseAppController.php');
require_once('classes/Objects/Category.php');
require_once('classes/Objects/Product.php');

class Main_c extends BaseAppController
{
	function encodeText($text) {
	  $trans = str_replace("\"", "&quot;", $text);
	  $trans = str_replace("&", "&amp;", $trans);
	  $trans = str_replace(">", "&gt;", $trans);
	  $trans = str_replace("<", "&lt;", $trans);
	  $trans = str_replace("'", "&apos;", $trans);
	  return $trans;
	}
	
	function companyInfo() {
		$yml = '<name>Арктида</name>';
    	$yml .= '<company>Арктида ОПТ</company>';
    	$yml .='<url>http://arktida-opt.ru</url>';
    	$yml .='<platform>CMS Framework</platform>';
    	$yml .='<version>1.0</version>';
    	$yml .='<agency>Up Money</agency>';
    	$yml .='<email>max077@mail.ru</email>';
    	return $yml;
	}
	
	function currencies() {
		$yml = '<currencies>';
		$yml .= '<currency id="RUR" rate="1"/>';
    	$yml .='</currencies>';
    	return $yml;
	}
	
	function categories() {
		$yml = '<categories>';
		
        $category = new Category();
    
    	$categories = $this->_adminModel->get(
        	$category->_tableName,
        	"parent_id is NULL",
        	true,
        	"cat_id, name"
        );
        
        foreach ($categories as $c) {
        	$yml .= '<category id="' . $c['cat_id'] . '">' . $this->encodeText($c['name']) . '</category>';
        	
        	$subCategories = $this->_adminModel->get(
	        	$category->_tableName,
	        	"parent_id = {$c['cat_id']}",
	        	true,
	        	"cat_id, name"
        	);
        	
        	foreach ($subCategories as $sc) {
        		$yml .= '<category id="' . $sc['cat_id'] . '" parentId="' . $c['cat_id'] . '">' . $this->encodeText($sc['name']) . '</category>';
        	}
        }
		
    	$yml .= '</categories>';
    	return $yml;
	}
	
	function offers() {
		$yml = '<offers>';
		
        $product = new Product();
		$products = $this->_adminModel->get($product->_tableName, 'visible = 1');
		
		foreach ($products as $p) {
			$yml .= '<offer id="' . $p['r_id'] . '" available="true">';
			
				$yml .= '<url>http://arktida-opt.ru/products/' . $p['url'] . '</url>';
				$yml .= '<price>' . $p['price'] . '</price>';
				$yml .= '<currencyId>RUR</currencyId>';
    			$yml .= '<categoryId>' . $p['cat_id'] . '</categoryId>';
    			if (!empty($p['img'])) {
    				$yml .= '<picture>http://arktida-opt.ru/images/upload/' . $p['img'] . '</picture>';
    			}
    			$yml .= '<store>false</store>';
    			$yml .= '<pickup>false</pickup>';
    			$yml .= '<delivery>true</delivery>';
    			$yml .= '<name>' . $this->encodeText($p['name']) . '</name>';
    			if (!empty($p['description'])) {
    				$yml .= '<description>' . $this->encodeText($p['description']) . '</description>';
    			}
    			
			$yml .= '</offer>';
		}
		
    	$yml .= '</offers>';
    	
    	return $yml;
	}
	
    function display($uniquePageValue = 'yml')
    {
        header('Content-type: text/xml');
    
    	$yml = '<?xml version="1.0" encoding="UTF-8"?>';
    	$yml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
    	
    	$yml .= '<yml_catalog date="' . date('Y-m-d h:m', time()) . '">';
    	$yml .= '<shop>';
    	
    	$yml .= $this->companyInfo();
    	$yml .= $this->currencies();
    	$yml .= $this->categories();
    	$yml .= $this->offers();

    	$yml .= '</shop>';
    	$yml .= '</yml_catalog>';
    	
    	echo $yml;
    }
}