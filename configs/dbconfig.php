<?php
if ($_SERVER['SERVER_NAME'] != 'localhost') {
	$GLOBALS['db_config'] = array (
		'server' => 'localhost',
		'user' => 'user',
		'password' => 'pass',
		'database' => 'db',
		'http_referer' => 'website.ru',
		'manager' => 'cherkashina@arktida-opt.ru'
	);
} else {
    define('DEBUG', 1);

	$GLOBALS['db_config'] = array (
			'server' => 'localhost',
			'user' => 'root',
			'password' => 'qweqwe',
			'database' => 'cypruscars',
			'http_referer' => 'localhost:8090',
		    'manager' => 'max077@mail.ru'
	);
}