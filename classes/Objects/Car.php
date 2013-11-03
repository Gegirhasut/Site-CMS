<?php
require_once 'Object.php';

class Car extends Object {
    public static $table = "cr_cars";

    public static $identity = 'car_id';

    public static $fields = array(
        'car_id' => array('type' => 'text', 'nolist' => 1),
        'probeg' => array('type' => 'number', 'title' => 'Пробег', 'check' => 'empty', 'filter' => 1),
        'city' => array(
            'type' => 'select',
            'source' => 'City',
            'title' => 'Город',
            'show_field' => 'city',
            'identity' => 'id',
            'filter' => 1
        ),
        'u_id' => array (
            'type' => 'select',
            'source' => 'User',
            'title' => 'Юзер',
            'show_field' => 'name',
            'identity' => 'u_id',
            'filter' => 1
        ),

        'year' => array('type' => 'text', 'title' => 'year'),
        'price' => array('type' => 'text', 'title' => 'price'),
        'kuzov' => array('type' => 'text', 'title' => 'kuzov'),
        'engine' => array('type' => 'text', 'title' => 'engine'),
        'power' => array('type' => 'text', 'title' => 'power'),
        'kpp' => array('type' => 'text', 'title' => 'kpp'),
        'privod' => array('type' => 'text', 'title' => 'privod'),
        'color' => array('type' => 'text', 'title' => 'color'),

        /*'info' => array (
            'type' => 'subtable',
            'table' => 'cr_cars_info',
            'join' => 'car_id',
            'identity' => 'i_id'
        ),*/

        /*'year' => array(
            'type' => 'select',
            'range' => true,
            'title' => 'Год',
            'values' => array (
                'from' => 1991,
                'to' => 2013
            ),
        ),
        'price' => array('type' => 'text', 'title' => 'Цена', 'check' => 'empty'),
        'torg' => array('type' => 'checkbox', 'title' => 'Торг', 'check' => 'empty'),*/
        /*'kuzov' => array(
            'type' => 'select',
            'title' => 'Город',
            'values' => array(
                0 => array('kuzov' => 0, 'field' => 'Cabriolet'),
                1 => array('kuzov' => 1, 'field' => 'Cupe'),
                2 => array('kuzov' => 2, 'field' => 'Microbus'),
                3 => array('kuzov' => 3, 'field' => 'Miniven')
            ),
            'show_field' => 'field',
            'select_identity' => 'kuzov'
        ),
        'engine' => array('type' => 'text', 'title' => 'Engine (l.s.)', 'check' => 'empty'),
        'power' => array('type' => 'text', 'title' => 'Power', 'check' => 'empty'),
        'kpp' => array(
            'type' => 'select',
            'title' => 'КПП',
            'values' => array(
                0 => array('kpp' => 0, 'field' => 'Auto'),
                1 => array('kpp' => 1, 'field' => 'Manual'),
            ),
            'show_field' => 'field',
            'select_identity' => 'kpp'
        ),
        'privod' => array(
            'type' => 'select',
            'title' => 'Привод',
            'values' => array(
                0 => array('privod' => 0, 'field' => 'Передний'),
                1 => array('privod' => 1, 'field' => 'Задний'),
                2 => array('privod' => 2, 'field' => '4WD'),
            ),
            'show_field' => 'field',
            'select_identity' => 'privod'
        ),
        'color' => array(
            'type' => 'select',
            'title' => 'Привод',
            'values' => array(
                0 => array('color' => 0, 'field' => 'Белый'),
                1 => array('color' => 1, 'field' => 'Черный'),
                2 => array('color' => 2, 'field' => 'Красный'),
            ),
            'show_field' => 'field',
            'select_identity' => 'color'
        )*/
    );
}