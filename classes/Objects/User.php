<?php

class User {
    public static $table = "cr_users";

    public static $identity = 'u_id';

    public static $fields = array(
        'u_id' => array('type' => 'text','nolist' => 1),
        'name' => array('type' => 'text', 'title' => 'Имя'),
        'email' => array('type' => 'text', 'title' => 'Email'),
        'phone' => array('type' => 'text', 'title' => 'Телефон'),
    );
}