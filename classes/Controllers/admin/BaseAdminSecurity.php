<?php
require_once('classes/Controllers/admin/BaseAdminStructure.php');

class BaseAdminSecurity extends BaseAdminStructure
{
  protected $_login = "admin";
  protected $_pass = "demo";
  
  public function auth() {
    $login = "";
    $pass = "";
    $operation = "";
    
    if (isset($_POST['operation'])) {
      $operation = $_POST['operation'];
    }
    
    if (isset($_POST['login'])) {
      $login = $_POST['login'];
    }
    
    if (isset($_POST['password'])) {
      $pass = $_POST['password'];
    }
    
    if ($operation == "auth" && $login == $this->_login && $pass == $this->_pass) {
      return true;
    }
    
    return false;
  }
  
  public function showAuthPage() {
    $this->_defaultPage = "admin/auth.tpl";
    $uniquePageValue = "admin-auth";
    parent::display($uniquePageValue);
    exit();
  }
  
  public function __construct() {
    if  (isset($_SESSION['admin_auth'])) {
      if (isset($_POST['operation']) && $_POST['operation'] == "logout") {
        unset($_SESSION['admin_auth']);
        header("location: /admin/");
        exit();
      }
    } else {
      if ($this->auth()) {
        $_SESSION['admin_auth'] = 1;
        return;
      }
      $this->showAuthPage();
	}
  }
}