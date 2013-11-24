<?php

class CarSubmodel {
    public $table = "cr_car_submodels";

    public $identity = 'car_submodel_id';

    public $fields = array(
        'car_submodel_id' => array('type' => 'text','nolist' => 1),
        'car_model_id' => array(
            'type' => 'select',
            'source' => 'CarModel',
            'title' => 'Model',
            'show_field' => 'car_model',
            'identity' => 'car_model_id',
            'autocomplete' => 1,
            'filter' => 1
        ),
        'car_submodel' => array('type' => 'text', 'title' => 'Modification')
    );

}