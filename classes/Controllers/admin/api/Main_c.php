<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class Main_c extends BaseAdminSecurity
{
    public function display($uniquePageValue = 'api') {
        $class_name = Router::getUrlPart(3);
        require_once("classes/Objects/$class_name.php");
        $class_description = new ReflectionClass($class_name);

        $table = $class_description->getProperty('table')->getValue();

        $adminModel = $this->_getModelByName('AdminBase');

        if(DEBUG) {
            define('STOP_DEBUG', true);
        }

        $adminModel = $adminModel->select($table);

        $condition = "";
        foreach ($_GET as $key => $value) {
            $condition .= "$key like '%$value%'";
        }

        if (!empty($condition)) {
            $adminModel->where($condition);
        }

        $objects = $adminModel->execute();

        require_once('helpers/json.php');
        echo arrayToJson(array('objects' => $objects));
    }
}