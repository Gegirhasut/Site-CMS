<?php
require_once('classes/Controllers/admin/BaseAdminObject.php');

class Main_c extends BaseAdminObject
{
    protected $_object = array(
        'cat_id' => array('type' => 'text', 'identity' => true),
        'name' => array('type' => 'text', 'title' => 'Название'),
        'url' => array('type' => 'link', 'title' => 'Link', 'link' => 'name'),
        'parent_id' => array('type' => 'select', 'title' => 'Верхняя категория', 'join' => 'tb_categories', 'select_identity' => 'cat_id', 'empty' => true, 'filter' => 'parent_id is NULL')
    );
    
    protected $_tableName = "tb_categories";
}