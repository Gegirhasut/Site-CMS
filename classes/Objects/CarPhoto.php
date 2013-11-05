<?php
/**
 * Created by JetBrains PhpStorm.
 * User: максим
 * Date: 05.11.13
 * Time: 21:01
 */

class CarPhoto {
    public $table = "cr_cars_photos";

    public $identity = 'ph_id';

    public $fields = array(
        'ph_id' => array('type' => 'text', 'nolist' => 1),
        'car_id' => array('type' => 'text', 'title' => 'car_id'),
        'path' => array('type' => 'text', 'title' => 'path')
    );
}
