<?php
require_once('classes/Controllers/admin/BaseAdminObject.php');

class Main_c extends BaseAdminObject
{
    public function __construct() {
        $this->loadClassFromUrl();
    }
}