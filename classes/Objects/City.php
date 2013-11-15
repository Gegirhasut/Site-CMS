<?php

class City {
    public $table = "cr_cities";

    public $identity = 'city_id';

    public $fields = array(
        'city_id' => array('type' => 'text','nolist' => 1),
        'name' => array('type' => 'text', 'title' => 'Название')
    );
}

/*
 *
class City {
    public $fields = array(
        'id' => array ('type' => 'text', 'title' => 'id'),
        'city' => array ('type' => 'text', 'title' => 'Город')
    );

    public $values = array (
        1 => array ('id' => 1, 'city' => 'Nikosia'),
        2 => array ('id' => 2, 'city' => 'Ayanapa'),
        3 => array ('id' => 3, 'city' => 'Limassol'),
        4 => array ('id' => 4, 'city' => 'Larnaka'),
    );
}

 */