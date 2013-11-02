<?php
require_once('classes/Controllers/admin/DeleteBase.php');
require_once('classes/Objects/Category.php');
require_once('classes/Objects/Product.php');

class Main_c extends DeleteBase
{
    function post() {
        $record = new Product();
        $category = new Category();
        
        $postHelper = $this->_loadPostHelper();
      
        $id = $postHelper->GetFromPost('id');
      
        $adminModel = $this->_getModelByName('AdminBase');
        
        $subcategories = $adminModel->get($category->_tableName, "parent_id = $id");
        
        foreach ($subcategories as $sub) {
        	$this->deleteFiles($sub['cat_id'], $small_path, $upload);
        }
        
        $adminModel->delete($record->_tableName, "using {$record->_tableName} join {$category->_tableName} on {$category->_tableName}.cat_id={$record->_tableName}.cat_id where parent_id = $id");
        $adminModel->delete($record->_tableName, "where cat_id = $id");
        $adminModel->delete($category->_tableName, "where parent_id = $id");
      
        parent::post();
    }
}