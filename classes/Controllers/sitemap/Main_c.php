<?php
require_once('classes/Controllers/BaseAppController.php');
require_once('classes/Objects/Category.php');

class Main_c extends BaseAppController
{
    function display($uniquePageValue = 'sitemap')
    {
        header('Content-type: text/xml');
    
    	echo '<?xml version="1.0" encoding="UTF-8"?>';
    	echo '<urlset xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    	
    	echo "<url>";
    	echo "<loc>http://arktida-opt.ru</loc>";
    	echo "<changefreq>weekly</changefreq>";
    	echo "</url>";
    	
    	require_once('classes/Objects/Section.php');
        $section = new Section();
    
        $sections = $this->_adminModel->get($section->_tableName, "", false, "url");
    	foreach($sections as $c) {
    		echo "<url>";
    		echo "<loc>http://arktida-opt.ru/{$c['url']}</loc>";
    		echo "<changefreq>monthly</changefreq>";
    		echo "</url>";
    	}
    	
	    require_once('classes/Objects/Category.php');
	    require_once('classes/Objects/Product.php');
        $category = new Category();
        $product = new Product();
    
    	$categories = $this->_adminModel->get(
        	$category->_tableName,
        	"parent_id is NULL",
        	true,
        	"cat_id, url"
        );
        
        foreach ($categories as $c) {
        	$subCategories = $this->_adminModel->get(
	        	$category->_tableName,
	        	"parent_id = {$c['cat_id']}",
	        	true,
	        	"cat_id, url"
        	);
        	if (empty($subCategories)) {
        		$url = "http://arktida-opt.ru/{$c['url']}";
        		echo "<url>";
	    		echo "<loc>$url</loc>";
	    		echo "<changefreq>weekly</changefreq>";
	    		echo "</url>";
	    		
	    		$products = $this->_adminModel->get($product->_tableName, 'cat_id = ' . $c['cat_id'], true, 'url');
	    		foreach ($products as $p) {
	    			$url = "http://arktida-opt.ru/products/{$p['url']}";
	        		echo "<url>";
		    		echo "<loc>$url</loc>";
		    		echo "<changefreq>weekly</changefreq>";
		    		echo "</url>";
	    		}
        	} else {
        		foreach ($subCategories as $sc) {
        			$url = "http://arktida-opt.ru/{$c['url']}/{$sc['url']}";
        			echo "<url>";
		    		echo "<loc>$url</loc>";
		    		echo "<changefreq>weekly</changefreq>";
		    		echo "</url>";
		    		
		    		$products = $this->_adminModel->get($product->_tableName, 'cat_id = ' . $sc['cat_id'], true, 'url');
	        		foreach ($products as $p) {
		    			$url = "http://arktida-opt.ru/products/{$p['url']}";
		        		echo "<url>";
			    		echo "<loc>$url</loc>";
			    		echo "<changefreq>weekly</changefreq>";
			    		echo "</url>";
		    		}
        		}
        	}
        }
    	
    	echo '</urlset>';
    }
}