<?php
require_once('classes/Controllers/BaseController.php');

class error404_c extends BaseController
{
	function display($uniquePageValue = '')
	{
		echo "Display error 404!";
	}
}