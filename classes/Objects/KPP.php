<?php
class KPP {
    public $fields = array(
        'id' => array ('type' => 'text', 'title' => 'id'),
        'kpp' => array ('type' => 'text', 'title' => 'Gears')
    );

    public $values = array (
        1 => array ('id' => 1, 'kpp' => 'Auto'),
        2 => array ('id' => 2, 'kpp' => 'Manual'),
    );

    public static $valueToId = array (
        'auto' => 1,
        'automatic' => 1,
        'manual' => 2,
    );
}