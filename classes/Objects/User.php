<?php

class User {
    public $table = "cr_users";

    public $identity = 'u_id';

    public $fields = array(
        'u_id' => array('type' => 'text','nolist' => 1),
        'name' => array('type' => 'text', 'title' => 'Имя'),
        'email' => array('type' => 'text', 'title' => 'Email'),
        'phone' => array('type' => 'text', 'title' => 'Телефон', 'filter' => 1),
    );
}