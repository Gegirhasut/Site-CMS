<?php
require_once('classes/Controllers/admin/BaseAdminSecurity.php');

class Main_c extends BaseAdminSecurity
{
    public function display($uniquePageValue = 'api') {
        $class = $this->loadClass(Router::getUrlPart(3));

        /**
         * AdminBase_m
         */
        $adminModel = $this->_getModelByName('AdminBase');

        if (isset($_GET['order'])) {
            $ids = explode(',', $_GET['order']);
            $sortField = $class->sort;
            $sortOrder = 1;
            foreach ($ids as $id) {
                $query = "UPDATE {$class->table} SET $sortField = $sortOrder WHERE {$class->identity} = $id";
                $sortOrder++;
                $adminModel->executeQuery($query);
            }

        }

        exit;


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