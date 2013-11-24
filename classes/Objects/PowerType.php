<?php
/**
 * Created by JetBrains PhpStorm.
 * User: максим
 * Date: 21.11.13
 * Time: 21:49
 * To change this template use File | Settings | File Templates.
 */

class PowerType {
    public $fields = array(
        'id' => array ('type' => 'text', 'title' => 'id'),
        'pt' => array ('type' => 'text', 'title' => 'PT')
    );

    public $values = array (
        1 => array ('id' => 1, 'pt' => 'KW'),
        2 => array ('id' => 2, 'pt' => 'HP'),
    );
}