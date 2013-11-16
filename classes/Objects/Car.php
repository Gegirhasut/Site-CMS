<?php

class Car {
    public $table = "cr_cars";

    public $identity = 'car_id';

    public $images = array(
        'small_path' => 'images/small',
        'upload' => 'images/upload',
        'w' => 218,
        'h' => 204,
        'field' => 'photos',
    );

    public $fields = array(
        'car_id' => array('type' => 'text', 'nolist' => 1),
        'source' => array('type' => 'text', 'title' => 'Источник'),
        'source_id' => array('type' => 'text', 'title' => 'ID'),
        'probeg' => array('type' => 'number', 'title' => 'Пробег', 'check' => 'empty', 'filter' => 1),
        'city' => array(
            'type' => 'select',
            'source' => 'City',
            'title' => 'Город',
            'show_field' => 'city_name',
            'identity' => 'city_id',
            'autocomplete' => 1,
            'filter' => 1
        ),
        'u_id' => array (
            'type' => 'select',
            'source' => 'User',
            'title' => 'Юзер',
            'show_field' => 'phone',
            'identity' => 'u_id',
            'autocomplete' => 1,
            'filter' => 1
        ),
        'car_model_id' => array(
            'type' => 'select',
            'source' => 'CarModel',
            'title' => 'Модель',
            'show_field' => 'car_model',
            'identity' => 'car_model_id',
            'autocomplete' => 1,
            'filter' => 1
        ),
        'kpp_id' => array(
            'type' => 'select',
            'source' => 'KPP',
            'title' => 'КПП',
            'show_field' => 'kpp',
            'identity' => 'kpp_id',
            'filter' => 1
        ),
        'color' => array(
            'type' => 'select',
            'source' => 'Color',
            'title' => 'Цвет',
            'show_field' => 'color',
            'identity' => 'color_id',
            'autocomplete' => 1,
            'filter' => 1
        ),
        'kpp_count' => array ('type' => 'text', 'title' => 'kppcnt'),
        'full_car_name' => array('type' => 'text', 'title' => 'Полное название', 'nolist' => 1),
        'year' => array('type' => 'number', 'title' => 'year', 'filter' => 1, 'size' => 4),
        'price' => array('type' => 'number', 'title' => 'price', 'filter' => 1, 'size' => 10),
        'torg' => array ('type' => 'checkbox', 'title' => 'Торг'),
        'kuzov' => array('type' => 'text', 'title' => 'kuzov'),
        'engine' => array('type' => 'text', 'title' => 'engine'),
        'power' => array('type' => 'text', 'title' => 'power'),
        //'kpp' => array('type' => 'text', 'title' => 'kpp'),
        'privod' => array('type' => 'text', 'title' => 'privod'),
        'info' => array ('type' => 'word', 'title' => 'Информация', 'nolist' => 1),
        'photos' => array (
            'type' => 'images',
            'source' => 'CarPhoto',
            'join_field' => 'car_id',
            'title' => 'Фотографии'
        )

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