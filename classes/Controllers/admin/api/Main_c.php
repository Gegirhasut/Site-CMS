<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class Main_c extends BaseAdminSecurity
{
    public function display($uniquePageValue = 'api') {
        $class = $this->loadClass(Router::getUrlPart(3));

        $adminModel = $this->_getModelByName('AdminBase');

        if(DEBUG) {
            define('STOP_DEBUG', true);
        }

        $adminModel = $adminModel->select($class->table);

        $condition = "";
        foreach ($_GET as $key => $value) {
            $condition .= "$key like '%$value%'";
        }

        if (!empty($condition)) {
            $adminModel->where($condition);
        }

        $objects = $adminModel->fetchAll();

        require_once('helpers/json.php');
        echo arrayToJson(array('objects' => $objects));
    }
}