<?php
require_once('classes/Controllers/BaseAppController.php');
require_once('classes/Objects/Car.php');
require_once('classes/Objects/CarModel.php');
require_once('classes/Objects/CarPhoto.php');
require_once('classes/Objects/City.php');
require_once('classes/Objects/Color.php');
require_once('classes/Objects/KPP.php');
require_once('classes/Objects/User.php');

class Main_c extends BaseAppController
{
    public $car;

    protected function getCar () {
        $car_id = Router::getUrlPart(3);
        $this->car = new Car();
        $carModel = new CarModel();
        $city = new City();
        $color = new Color();
        $kpp = new KPP();
        $user = new User();
        $carPhoto = new CarPhoto();

        $cars = $this->_adminModel->select($this->car->table)
            ->join("{$carModel->table} ON {$carModel->table}.car_model_id = {$this->car->table}.car_model_id")
            ->join("{$city->table} ON {$city->table}.city_id = {$this->car->table}.city")
            ->join("{$color->table} ON {$color->table}.color_id = {$this->car->table}.color")
            ->join("{$kpp->table} ON {$kpp->table}.kpp_id = {$this->car->table}.kpp_id")
            ->join("{$user->table} ON {$user->table}.u_id = {$this->car->table}.u_id")
            ->where('car_id = ' . $car_id)
            ->fetchAll();

        foreach ($cars as &$c) {
            $model = mb_strtolower($c['car_model']);
            $full_car_name = mb_strtolower($c['full_car_name']);
            $c['full_car_name'] = trim(str_replace($model, '', $full_car_name));
            $c['insert_date'] = mb_substr($c['insert_date'], 0, 10);
            if (empty($c['preview_photo'])) {
                $c['preview_photo'] = 'no_photo.png';
            }
            if (!empty($c['kpp_count'])) {
                $c['kpp'] = $c['kpp'] . ' ' . $c['kpp_count'];
            }
            $c['carsPhotos'] = $this->_adminModel->select($carPhoto->table, "path")
                ->where('car_id = ' . (int) ($c['car_id']))
                ->fetchAll();

            $this->_title = "{$c['car_model']} {$c['full_car_name']} buy in {$c['city_name']}, id {$c['car_id']}";
            $this->_description = "Buy {$c['car_model']} {$c['full_car_name']} in {$c['city_name']}, price is {$c['price']} Euro";
            $this->_keywords = "{$c['car_model']}, {$c['full_car_name']}, {$c['car_model']} in {$c['city_name']}, buy {$c['car_model']}";
        }

        return $cars[0];
    }

	function display($uniquePageValue = 'main')
	{
        $this->assign('car', $this->getCar());
        $this->assign('content_page', 'car');
        $this->assign('small_path', $this->car->images['small_path']);
        $this->assign('big_path', $this->car->images['upload']);

		parent::display($uniquePageValue);
	}
}