<?php
class Color {
    public $table = "cr_colors";

    public $identity = 'color_id';

    public $fields = array(
        'color_id' => array('type' => 'text','nolist' => 1),
        'color' => array('type' => 'text', 'title' => 'Цвет')
    );
}