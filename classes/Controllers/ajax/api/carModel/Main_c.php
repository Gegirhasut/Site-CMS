<?php
require_once('classes/Controllers/admin/BaseAdminStructure.php');

class Main_c extends BaseAdminStructure
{
    public function display($uniquePageValue = 'api') {
        $class = $this->loadClass('CarModel');

        $adminModel = $this->_getModelByName('AdminBase');

        /**
         * AdminBase_m
         */
        $adminModel = $adminModel->select($class->table)
            ->where("car_model like '" . Router::getUrlPart(4) . "%'");

        $objects = $adminModel->fetchAll();

        require_once('helpers/json.php');
        echo arrayToJson(array('objects' => $objects));
        exit;
    }
}