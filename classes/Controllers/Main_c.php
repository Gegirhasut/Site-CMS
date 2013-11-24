<?php
require_once('classes/Controllers/BaseAppController.php');
require_once('classes/Objects/Car.php');
require_once('classes/Objects/CarModel.php');
require_once('classes/Objects/CarSubmodel.php');
require_once('classes/Objects/City.php');
require_once('classes/Objects/Color.php');
require_once('classes/Objects/KPP.php');
require_once('classes/Objects/User.php');
require_once('classes/Objects/Saloon.php');

class Main_c extends BaseAppController
{
    public $car;
    protected $_title = 'Cars in Cyprus | Buy and Sell';
    protected $_description = 'Cars in Cyprus | Buy and Sell';
    protected $_keywords = 'Cars in Cyprus | Buy and Sell';

    protected function getCars () {
        if (isset($_SESSION['filters'])) {
            unset($_SESSION['filters']['city_id']);
            unset($_SESSION['filters']['city']);
        }


        $this->car = new Car();
        $carModel = new CarModel();
        $carSubmodel = new CarSubmodel();
        $city = new City();
        $color = new Color();
        $kpp = new KPP();
        $user = new User();
        $saloon = new Saloon();

        $currentPage = 1;
        if (isset ($_GET['page']))
            $currentPage = (int) $_GET['page'];

        $adminModel = $this->_adminModel->select($this->car->table, 'SQL_CALC_FOUND_ROWS *')
            ->join("{$carModel->table} ON {$carModel->table}.car_model_id = {$this->car->table}.car_model_id")
            ->leftJoin("{$carSubmodel->table} ON {$carSubmodel->table}.car_submodel_id = {$this->car->table}.car_submodel_id")
            ->join("{$city->table} ON {$city->table}.city_id = {$this->car->table}.city")
            ->join("{$color->table} ON {$color->table}.color_id = {$this->car->table}.color")
            ->join("{$kpp->table} ON {$kpp->table}.kpp_id = {$this->car->table}.kpp_id")
            ->join("{$user->table} ON {$user->table}.u_id = {$this->car->table}.u_id");

        $filterWhere = $this->assignCarsFilters();
        if(!empty($filterWhere)) {
            $adminModel->where($filterWhere);
        }

        $orderFields = $this->assignCarsOrders($adminModel);

        $cars = $adminModel->orderByNoDirection($orderFields, false)
            ->limit(($currentPage - 1) * $this->_countOnPage, $this->_countOnPage)
            ->fetchAll($this->car->identity);

        $this->assignPager($currentPage);

        $this->filterCarsResult($cars, $saloon);

        return $cars;
    }

	function display($uniquePageValue = 'main')
	{
        $this->assign('cars', $this->getCars());
        $this->assign('small_path', $this->car->images['small_path']);
        $this->assign('big_path', $this->car->images['upload']);
        $this->assign('content_page', 'main');

		parent::display($uniquePageValue);
	}
}