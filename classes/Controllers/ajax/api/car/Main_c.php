<?php
require_once('classes/Controllers/admin/BaseAdminStructure.php');

class Main_c extends BaseAdminStructure
{
    public function display($uniquePageValue = 'api') {
        $class = $this->loadClass('CarPhoto');

        $adminModel = $this->_getModelByName('AdminBase');

        /**
         * AdminBase_m
         */
        $adminModel = $adminModel->select($class->table, "path")
            ->where('car_id = ' . (int) ($_GET['car_id']));

        $objects = $adminModel->fetchAll();

        require_once('helpers/json.php');
        echo arrayToJson(array('objects' => $objects));
        exit;
    }
}