<?php

class CarModel {
    public $table = "cr_car_models";

    public $identity = 'car_model_id';

    public $fields = array(
        'car_model_id' => array('type' => 'text','nolist' => 1),
        'car_model' => array('type' => 'text', 'title' => 'Название')
    );

}