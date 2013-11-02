<?php
require_once('classes/Controllers/admin/BaseAdminObjects.php');

class Main_c extends BaseAdminObjects
{
    public function __construct() {
        $this->loadClassFromUrl();
    }
}