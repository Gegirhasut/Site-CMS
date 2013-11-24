<?php
require_once('classes/Controllers/BaseController.php');

function cmp($a, $b)
{
    return strcmp ($a['name'], $b['name']);
}

class BaseAppController extends BaseController
{
    /**
     * @var AdminBase_m
     */
    protected $_adminModel;
    protected $_countOnPage = 20;
    protected $_pages;
    protected $_title = 'Cars in Cyprus | Buy and Sell';
    protected $_description = 'Cars in Cyprus | Buy and Sell';
    protected $_keywords = 'Cars in Cyprus | Buy and Sell';
    
    function __construct() {
      $this->_adminModel = $this->_getModelByName('AdminBase');
    }

    protected function filterCarsResult (&$cars, $saloon) {
        foreach ($cars as &$c) {
            $c['car_name'] = $c['car_model'];
            if (!empty($c['car_submodel'])) {
                $c['car_name'] .= ' ' . $c['car_submodel'];
            }

            if ($c['saloon'] != 0) {
                $c['saloon'] = $saloon->values[$c['saloon']]['saloon'];
            } else {
                $c['saloon'] = '';
            }

            $c['insert_date'] = mb_substr($c['insert_date'], 5, 5);
            if (empty($c['preview_photo'])) {
                $c['preview_photo'] = 'no_photo.png';
            }
            if (!empty($c['kpp_count'])) {
                $c['kpp'] = $c['kpp'] . ' ' . $c['kpp_count'];
            }
            $c['phone'] = str_replace(",", "<br>", $c['phone']);
            $c['powerType'] = ($c['powerType'] == 1) ?  'kw' : 'hp';
        }
    }

    protected function assignCarsOrders() {
        if (!isset($_SESSION['filters'])) {
            return 'insert_date DESC';
        }

        $orderByDate = 0;
        $orderByPrice = 0;

        if (!empty($_SESSION['filters']['orderByDate'])) {
            $orderByDate = $_SESSION['filters']['orderByDate'];
        }

        if ($orderByDate != 0) {
            if ($orderByDate == 1) {
                return "insert_date";
            } else {
                return "insert_date DESC";
            }
        }

        if (!empty($_SESSION['filters']['orderByPrice'])) {
            $orderByPrice = $_SESSION['filters']['orderByPrice'];
        }

        if ($orderByPrice != 0) {
            if ($orderByPrice == 1) {
                return "price";
            } else {
                return "price DESC";
            }
        }

        return "insert_date DESC";
    }

    protected function assignCarsFilters() {
        if (!isset($_SESSION['filters'])) {
            return '';
        }
        $filterWhere = "";

        if (!empty($_SESSION['filters']['year_min'])) {
            if (!empty($filterWhere)) {
                $filterWhere .= ' AND ';
            }
            $filterWhere .= "year >= " . $_SESSION['filters']['year_min'];
        }

        if (!empty($_SESSION['filters']['year_max'])) {
            if (!empty($filterWhere)) {
                $filterWhere .= ' AND ';
            }
            $filterWhere .= "year <= " . $_SESSION['filters']['year_max'];
        }

        if (!empty($_SESSION['filters']['price_min'])) {
            if (!empty($filterWhere)) {
                $filterWhere .= ' AND ';
            }
            $filterWhere .= "price >= " . $_SESSION['filters']['price_min'];
        }

        if (!empty($_SESSION['filters']['price_max'])) {
            if (!empty($filterWhere)) {
                $filterWhere .= ' AND ';
            }
            $filterWhere .= "price <= " . $_SESSION['filters']['price_max'];
        }

        if (!empty($_SESSION['filters']['mileage_max'])) {
            if (!empty($filterWhere)) {
                $filterWhere .= ' AND ';
            }
            $filterWhere .= "probeg <= " . $_SESSION['filters']['mileage_max'];
        }

        if (!empty($_SESSION['filters']['ec_max'])) {
            if (!empty($filterWhere)) {
                $filterWhere .= ' AND ';
            }
            $filterWhere .= "engineShort <= " . $_SESSION['filters']['ec_max'];
        }

        if (!empty($_SESSION['filters']['car_model_id'])) {
            if (!empty($filterWhere)) {
                $filterWhere .= ' AND ';
            }
            $filterWhere .= "cr_cars.car_model_id = " . $_SESSION['filters']['car_model_id'];
        }

        if (!empty($_SESSION['filters']['type']) && $_SESSION['filters']['type'] != 0) {
            if (!empty($filterWhere)) {
                $filterWhere .= ' AND ';
            }
            if ($_SESSION['filters']['type'] == 1) {
                $filterWhere .= "cr_cars.saloon != 10";
            } else {
                $filterWhere .= "cr_cars.saloon = 10";
            }
        }

        return $filterWhere;
    }

    function getCities () {
        require_once('classes/Objects/City.php');
        $city = new City();
        $cities = $this->_adminModel->select($city->table)->fetchAll();
        $this->assign('cities', $cities);
    }

	function assignPager($currentPage) {
        if ($currentPage != 1) {
            $this->_title .= " | Page $currentPage";
        }
        $totalRecords = $this->_adminModel->getRowsCount();

        $totalPages = (int) ($totalRecords / $this->_countOnPage);

        if ($totalPages * $this->_countOnPage < $totalRecords) {
            $totalPages++;
        }

        $prev_pages = array ();
        if ($currentPage - 3 > 1) {
            $prev_pages[] = 1;
            $prev_pages[] = '...';
        }
        for ($i = $currentPage - 4; $i < $currentPage; $i++) {
            if ($i > 0) {
                $prev_pages[] = $i;
            }
        }

        $next_pages = array ();
        for ($i = $currentPage + 1; $i < $currentPage + 5; $i++) {
            if ($i <= $totalPages) {
                $next_pages[] = $i;
            }
        }
        if ($i < $totalPages) {
            $next_pages[] = '...';
            $next_pages[] = $totalPages;
        }

        $next_page = $currentPage + 1;
        if ($next_page < $totalPages) {
            $this->assign('next_page', $next_page);
        }

        $prev_page = $currentPage - 1;
        if ($prev_page > 0) {
            $this->assign('prev_page', $prev_page);
        }

        $this->assign('base_url', $_SERVER['REDIRECT_URL']);

        $this->assign('prev_pages', $prev_pages);
        $this->assign('next_pages', $next_pages);
        $this->assign('current_page', $currentPage);
        $this->assign('count_pages', $totalPages);
    }

	function display($uniquePageValue, $showSection = true)
	{
        //unset($_SESSION['filters']);
        if (isset($_SESSION['filters'])) {
            //print_r($_SESSION['filters']);
            $this->assign('filters', $_SESSION['filters']);
        }

        $this->getCities();
		$this->assign('title', $this->_title);
		$this->assign('description', $this->_description);
		$this->assign('keywords', $this->_keywords);

		parent::display($uniquePageValue);
	}
}