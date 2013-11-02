<?php
require_once('classes/Controllers/BaseController.php');

function cmp($a, $b)
{
    return strcmp ($a['name'], $b['name']);
}

class BaseAppController extends BaseController
{
    protected $_adminModel;
    protected $_countOnPage = 20;
    protected $_pages;
    protected $_title = 'Арктида | интернет магазин развивающих игрушек | Новосибирск';
    protected $_description = 'Арктида - Волшебный материк игрушек. Интернет магазин развивающих игрушек в Новосибирске.';
    protected $_keywords = 'арктида, интернет-магазин, развивающие игрушки, новосибирск';
    
    function __construct() {
      if (isset($_SESSION['user']) && $_SESSION['user']['state'] == 1) {
      	$this->assign('opt_user', 1);
      }
      $this->_adminModel = $this->_getModelByName('AdminBase');
    }
    
	function assignBanners() {
    	require_once('classes/Objects/Banner.php');
    	
    	$banner = new Banner();
    	$banners = $this->_adminModel->get($banner->_tableName);
    	
    	$this->assign('banners', $banners);
    }
    
	function assignPartners() {
    	require_once('classes/Objects/Partner.php');
    	
    	$partner = new Partner();
    	$partners = $this->_adminModel->get($partner->_tableName, "order by sort", false);
    	
    	$this->assign('partners', $partners);
    }
    
	function assignProduct($url) {
    	require_once('classes/Objects/Product.php');
    	require_once('classes/Objects/Category.php');
    	
    	$product = new Product();
    	$category = new Category();
    	$products = $this->_adminModel->get(
    		$product->_tableName,
    		"LEFT JOIN {$category->_tableName} ON {$category->_tableName}.cat_id = {$product->_tableName}.cat_id
    		 LEFT JOIN {$category->_tableName} as p_cat ON {$category->_tableName}.parent_id = p_cat.cat_id
    		 WHERE {$product->_tableName}.url = '$url'", false,
    		"{$product->_tableName}.r_id, {$product->_tableName}.date_way, {$product->_tableName}.ostatok, {$product->_tableName}.code, {$product->_tableName}.name,
    		 {$product->_tableName}.price, {$product->_tableName}.opt_price,
    		 {$product->_tableName}.img, {$product->_tableName}.img1, {$product->_tableName}.img2, {$product->_tableName}.img3,
    		 {$product->_tableName}.description, {$product->_tableName}.visible,
    		 {$category->_tableName}.url as cat_url, {$category->_tableName}.name as cat_name,
    		 p_cat.url as p_cat_url"
    	);

    	if (!empty($products)) {
    		$this->_title = $products[0]['name'] . " | Код {$products[0]['code']}";
            $this->_description = $products[0]['name'] . ", код {$products[0]['code']}, цена - {$products[0]['price']} рублей";
            $this->_keywords = $products[0]['name'] . ", {$products[0]['code']}";
    		
    		$this->assign('product', $products[0]);
    	} else {
		header('Location: /');
		exit;
	}
    }
    
	function assignNew($url) {
    	require_once('classes/Objects/News.php');
    	
    	$new = new News();
    	$news = $this->_adminModel->get($new->_tableName, "url = '$url'");
    	
    	if (!empty($news)) {
			$this->_title = $news[0]['title'] . " | {$news[0]['date']} | Арктида Новости";
            $this->_description = $news[0]['title'] . " - новость компании Арктида от {$news[0]['date']}";
            $this->_keywords = $news[0]['title'];
                	
    		$this->setNewShortDate($news[0]);
    		$this->assign('new', $news[0]);
    	}
    }
    
    function assignPages($start, $countPages, $pageName) {
    	$this->assign('count_pages', $countPages);
    	$this->assign('current_page', $start);
    	$this->assign('pageName', $pageName);
    	
    	if ($start < $countPages) {
    		$this->assign('next_page', $start + 1);
    	}
    	
    	if ($start > 1) {
    		$this->assign('prev_page', $start - 1);
    	}
    }
    
	function assignAkcia($url) {
    	require_once('classes/Objects/Akcia.php');
    	
    	$akcia = new Akcia();
    	$akcii = $this->_adminModel->get($akcia->_tableName, "url = '$url'");
    	
    	if (!empty($akcii)) {
    		$this->_title = $akcii[0]['title'] . " | {$akcii[0]['date']} | Арктида Акции";
            $this->_description = $akcii[0]['title'] . " - акция компании Арктида от {$akcii[0]['date']}";
            $this->_keywords = $akcii[0]['title'];
            
    		$this->setNewShortDate($akcii[0]);
    		$this->assign('akcia', $akcii[0]);
    	}
    }
    
    function setNewShortDate(&$n) {
    	list ($year, $month, $day) = explode ('.', $n['date']);
    	$n['date'] = "$day.$month.$year";
    	$n['short_new'] = strip_tags($n['new']);
    	$n['short_new'] = mb_substr ($n['short_new'], 0, 150, "utf-8") . "...";
    }
    
	function assignNews($start, $limit, $pager = true) {
    	require_once('classes/Objects/News.php');
    	
    	$startRecord = ($start - 1) * $limit;
    	
    	$new = new News();
    	$news = $this->_adminModel->get($new->_tableName, "order by date desc limit $startRecord, $limit", false, 'SQL_CALC_FOUND_ROWS *');
    	
    	foreach ($news as &$n) {
    		$this->setNewShortDate($n);
    	}
    	
    	if ($pager) {
    		$countPages = $this->_adminModel->getRowsCount();
    		$countPages = ceil($countPages / $limit);
    		$this->assignPages($start, $countPages, 'news');
    	}
    	
    	$this->assign('news', $news);
    }
    
    function assignAkcii($start, $limit, $pager = true) {
    	require_once('classes/Objects/Akcia.php');
    	
    	$startRecord = ($start - 1) * $limit;
    	
    	$akcia = new Akcia();
    	$akcii = $this->_adminModel->get($akcia->_tableName, "order by date desc limit $startRecord, $limit", false, 'SQL_CALC_FOUND_ROWS *');
    	
    	foreach ($akcii as &$n) {
    		$this->setNewShortDate($n);
    	}
    	
    	if ($pager) {
	    	$countPages = $this->_adminModel->getRowsCount();
	    	$countPages = ceil($countPages / $limit);
	    	$this->assignPages($start, $countPages, 'akcii');
    	}
    	
    	$this->assign('akcii', $akcii);
    }
    
    function assignSections($url) {
      $url = trim($url, "/");
      if ($url == '') {
      	$url = '/';
      }
      require_once('classes/Objects/Section.php');
      $section = new Section();
    
      $sections = $this->_adminModel->get($section->_tableName, "parent_id is NULL and in_menu = 1 order by sort");
      $sub_sections = $this->_adminModel->get($section->_tableName, "parent_id is not NULL order by parent_id, sort");
    
      $result_array = array();
      $i = 0;
      
      foreach ($sections as &$c) {
      	if ($c['url'] == $url) {
      		$c['selected'] = true;
      	}
        $c['subs'] =  array();
        while ($i < count ($sub_sections) && $sub_sections[$i]['parent_id'] == $c['s_id']) {
          if ($sub_sections[$i]['url'] == $url) {
      		$c['selected'] = true;
      	  }
          $c['subs'][] = $sub_sections[$i++];
        }
        $result_array[] = $c;
      }
      
      $this->assign('top_menu', $result_array);
    }
    
    /*function assignSubCategories($category_url) {
    	require_once('classes/Objects/Category.php');
        $category = new Category();

        $sub_categories = $this->_adminModel->get(
        	$category->_tableName, 
        	"right join {$category->_tableName} as parent_sub on parent_sub.cat_id = {$category->_tableName}.parent_id
        	 where parent_sub.url = '$category_url' order by {$category->_tableName}.name",
        	false,
        	"{$category->_tableName}.name, {$category->_tableName}.url, parent_sub.name as parent_name"
        );
        
        if (!empty($sub_categories)) {
        	$this->assign('title', $sub_categories[0]['parent_name']);
        	$this->assign('categories', $sub_categories);
	        $this->assign('categories_url', $category_url);
        } else {
        	header('Location: /');
        	exit;
        }
    }*/
    
    function assignCategories($category_url = null) {
      require_once('classes/Objects/Category.php');
      $category = new Category();

      $categories = $this->_adminModel->get($category->_tableName, "visible=1 and parent_id is NULL order by cat_id");
      $sub_categories = $this->_adminModel->get($category->_tableName, "visible=1 and parent_id is not NULL order by parent_id, name");
      
      $result_array = array();
      $i = 0;
      foreach ($categories as &$c) {
        if ($c['url'] == $category_url) {
          $c['selected'] = 1;
        }
        $c['subs'] =  array();
        while ($i < count ($sub_categories) && $sub_categories[$i]['parent_id'] == $c['cat_id']) {
          $c['subs'][] = $sub_categories[$i++];
        }
        $result_array[] = $c;
      }
      
      usort($result_array, "cmp");
      
      foreach ($result_array as $key => $a) {
      	if ($a['name'] == 'Торговые марки') {
      		break;
      	}
      }
      
      $result_array2 = array();
      for ($i = 0; $i < 2; $i++) {
      	$result_array2[] = $result_array[$i];
      }
      
      $result_array2[] = $result_array[$key];
      
      for ($i = 2; $i < count($result_array); $i++) {
      	if ($i != $key) {
      		$result_array2[] = $result_array[$i];
      	}
      }
      
      $this->assign('menu', $result_array2);
      return $result_array;
    }
    
    function assignNewProducts() {
    	require_once('classes/Objects/Product.php');
    	$product = new Product();
    	
    	$records = $this->_adminModel->get($product->_tableName, " where visible=1 and img is not null order by {$product->_object['identity']} DESC limit 0, 24", false);
    	$this->assign('new_records', $records);
    	return $records;
    }
    
    function assignProducts($category_url, $page, $pre_category_url = '') {
      $showOnPage = $this->_countOnPage;
      if (isset($_SESSION['show'])) {
      	$showOnPage = $_SESSION['show'];
      }
      
      $this->assign('show', $showOnPage);
      
      $startPage = ($page - 1) * $showOnPage;
      
      require_once('classes/Objects/Product.php');
      require_once('classes/Objects/Category.php');
      $category = new Category();
      $product = new Product();
      
      $fields = "SQL_CALC_FOUND_ROWS {$product->_tableName}.r_id,
                 {$product->_tableName}.cat_id,
                 {$product->_tableName}.name,
                 {$product->_tableName}.url,
                 {$product->_tableName}.price,
                 {$product->_tableName}.opt_price,
                 {$product->_tableName}.visible,
                 {$product->_tableName}.date_way,
                 {$product->_tableName}.code,
                 {$product->_tableName}.img,
                 {$category->_tableName}.parent_id,
                 {$category->_tableName}.url as cat_url,
                 {$category->_tableName}.name as cat_name
      		    ";
                 
      if (isset($_SESSION['sort'])) {
      	$orderBy = " {$_SESSION['sort']} {$_SESSION['direction']}";
      } else {
      	$orderBy = "{$product->_tableName}.code+0";
      }
      
      if ($category_url != null) {
        // Категория
        $records = $this->_adminModel->get(
          $product->_tableName,
          "right join {$category->_tableName} on {$category->_tableName}.cat_id={$product->_tableName}.cat_id
           where {$category->_tableName}.url='$category_url'
           order by $orderBy
           limit $startPage, $showOnPage",
          false,
          $fields
        );
        if (!empty($records)) {
          $this->_title = $records[0]['cat_name'] . ' | Развивающие игрушки | Арктида';
          $this->_description = $records[0]['cat_name'] . ' - развивающие игрушки';
          $this->_keywords = $records[0]['cat_name'] . ', развивающие игрушки';
          
          $this->assign('category_name', $records[0]['cat_name']);
        } else {
          $this->assign('category_name', 'Пустая категория');
          $this->assign('category', 'Пустая категория');
          $this->assign('subcategory', 'Категория не заполнена');
        }
      }
      
      $this->assign('records', $records);
      
      $countPages = $this->_adminModel->getRowsCount();
      
      $countPages = ceil($countPages / $showOnPage);
      
      if ($countPages < $page && $countPages != 0) {
      	$url = $_SERVER['REQUEST_URI'];
      	$url = str_replace("/$page", "/$countPages", $url);
      	header('location: ' . $url);
      	exit;
      }
      
      $this->assignPages($page, $countPages, $pre_category_url . $category_url);
      
      return $records;
    }
    
    function assignSection($url, $showSection) {
      if ($url == '/') {
        return;
      }
      $url = trim($url, "/");
      if ($url == '') {
        $url = '/';
      }
      require_once('classes/Objects/Section.php');
      $section = new Section();
    
      $sections = $this->_adminModel->get($section->_tableName, "url = '$url'");
      
      if (!empty($sections)) {
      	
        $this->_title = $sections[0]['title'];
        $this->_description = $sections[0]['title'];
        $this->_keywords = $sections[0]['title'];
      	
        $this->assign('section', $sections[0]);
        if ($showSection) {
        	$this->assign('content_page', 'section');
        }
      }
    }
    
    function assignValues($template, $uniquePageValue) {
      $this->cache_lifetime = 60 * 60 * 24 * 7;
      $this->setTemplatePath($template);
      
      if (!$this->is_cached($this->_defaultPage, $uniquePageValue)) {
        return true;  
      }
      return false;
    }
    
	function display($uniquePageValue, $showSection = true)
	{   
		$url = '';
		if(Router::getUrlPart(1) != null) {
			$url = Router::getUrlPart(1);
		}
		
		$this->assignCategories($url);
		
		$this->assignSections($_SERVER['REQUEST_URI']);
		$this->assignSection($_SERVER['REQUEST_URI'], $showSection);
		$this->assignBanners();
		
		$this->assign('title', $this->_title);
		$this->assign('description', $this->_description);
		$this->assign('keywords', $this->_keywords);
		
		parent::display($uniquePageValue);
	}
}