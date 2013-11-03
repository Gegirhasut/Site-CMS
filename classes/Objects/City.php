<?php
require_once 'Object.php';

class City extends Object {
    public static $fields = array(
        'id' => array ('type' => 'text', 'title' => 'id'),
        'city' => array ('type' => 'text', 'title' => 'Город')
    );

    public static $values = array (
        1 => array ('id' => 1, 'city' => 'Nikosia'),
        2 => array ('id' => 2, 'city' => 'Ayanapa'),
        3 => array ('id' => 3, 'city' => 'Limassol'),
        4 => array ('id' => 4, 'city' => 'Larnaka'),
    );
}