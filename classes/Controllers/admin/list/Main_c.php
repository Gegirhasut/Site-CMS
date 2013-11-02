<?php
require_once('classes/Controllers/admin/BaseAdminObjects.php');

class Main_c extends BaseAdminObjects
{
    public function __construct() {
        $class_name = Router::getUrlPart(3);
        require_once("classes/Objects/$class_name.php");
        $class_description = new ReflectionClass($class_name);

        // Necessary for Delete and Update operations in admin
        $this->assign('class', $class_name);

        $this->class = $class_description;
    }
}