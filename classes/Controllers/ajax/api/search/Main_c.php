<?php
require_once('classes/Controllers/admin/BaseAdminStructure.php');

class Main_c extends BaseAdminStructure
{
    public function display($uniquePageValue = 'search') {
        if (isset($_SESSION['filters'])) {
            $filters = $_SESSION['filters'];
        } else {
            $filters = array();
        }

        $filters['year_min'] = (int) $_GET['year_min'];
        if ($filters['year_min'] == 0) {
            $filters['year_min'] = '';
        }
        $filters['year_max'] = (int) $_GET['year_max'];
        if ($filters['year_max'] == 0) {
            $filters['year_max'] = '';
        }

        $filters['price_min'] = (int) $_GET['price_min'];
        if ($filters['price_min'] == 0) {
            $filters['price_min'] = '';
        }
        $filters['price_max'] = (int) $_GET['price_max'];
        if ($filters['price_max'] == 0) {
            $filters['price_max'] = '';
        }

        $filters['mileage_max'] = (int) $_GET['mileage_max'];
        if ($filters['mileage_max'] == 0) {
            $filters['mileage_max'] = '';
        }

        $filters['ec_max'] = (double) $_GET['ec_max'];
        if ($filters['ec_max'] == 0) {
            $filters['ec_max'] = '';
        }

        $filters['car_model_id'] = (int) $_GET['car_model_id'];
        if ($filters['car_model_id'] == 0) {
            $filters['car_model_id'] = '';
        }

        $filters['orderByPrice'] = (int) $_GET['orderByPrice'];
        $filters['orderByDate'] = (int) $_GET['orderByDate'];
        if ($filters['orderByPrice'] == 0 && $filters['orderByDate'] == 0) {
            $filters['orderByDate'] = 2;
        }
        $filters['type'] = (int) $_GET['type'];

        $postHelper = $this->_loadPostHelper();
        $filters['model'] = $postHelper->GetFromGet('model');

        $_SESSION['filters'] = $filters;
        //print_r($_SESSION['filters']);

        exit;
    }
}