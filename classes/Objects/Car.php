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
        'car_model_id' => array(
            'type' => 'select',
            'source' => 'CarModel',
            'title' => 'Модель',
            'show_field' => 'car_model',
            'identity' => 'car_model_id',
            'autocomplete' => 1,
            'filter' => 1
        ),
        'car_submodel_id' => array(
            'type' => 'select',
            'source' => 'CarSubmodel',
            'title' => 'М',
            'show_field' => 'car_submodel',
            'identity' => 'car_submodel_id',
            'autocomplete' => 1,
            'filter' => 1
        ),
        'year' => array('type' => 'number', 'title' => 'year', 'filter' => 1, 'size' => 4),
        'price' => array('type' => 'number', 'title' => 'price', 'filter' => 1, 'size' => 10),
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

        'kpp_id' => array(
            'type' => 'select',
            'source' => 'KPP',
            'title' => 'КПП',
            'show_field' => 'kpp',
            'identity' => 'kpp_id',
            'filter' => 1
        ),
        'kpp_count' => array ('type' => 'text', 'title' => 'kppcnt'),
        'color' => array(
            'type' => 'select',
            'source' => 'Color',
            'title' => 'Цвет',
            'show_field' => 'color',
            'identity' => 'color_id',
            'autocomplete' => 1,
            'filter' => 1
        ),
        'full_car_name' => array('type' => 'text', 'title' => 'Полное название', 'nolist' => 1),
        'engineShort' => array('type' => 'text', 'title' => 'engine'),
        'carburation' => array('type' => 'text', 'title' => 'carb'),
        'power' => array('type' => 'text', 'title' => 'power'),
        'powerType' => array(
            'type' => 'select',
            'source' => 'PowerType',
            'title' => 'PT',
            'show_field' => 'pt',
            'identity' => 'id'
        ),
        'saloon' => array(
            'type' => 'select',
            'source' => 'Saloon',
            'title' => 'Saloon',
            'show_field' => 'saloon',
            'identity' => 'id',
            'filter' => 1
        ),
        'info' => array ('type' => 'word', 'title' => 'Информация', 'nolist' => 1),
        'photos' => array (
            'type' => 'images',
            'source' => 'CarPhoto',
            'join_field' => 'car_id',
            'title' => 'Фотографии',
            'preview' => 'preview_photo'
        ),
        'preview_photo' => array ('type' => 'preview', 'nolist' => 1),
        'privod' => array('type' => 'text', 'title' => 'privod'),
        'torg' => array ('type' => 'checkbox', 'title' => 'Торг'),
        'source' => array('type' => 'text', 'title' => 'Источник'),
        'source_id' => array('type' => 'text', 'title' => 'ID'),
    );
}