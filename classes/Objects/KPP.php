<?php
class KPP {
    public $table = "cr_car_kpps";

    public $identity = 'kpp_id';

    public $fields = array(
        'kpp_id' => array('type' => 'text','nolist' => 1),
        'kpp' => array('type' => 'text', 'title' => 'КПП')
    );
}