<?php
require_once('classes/Controllers/BaseController.php');

class Main_c extends BaseController
{	
	function display($uniquePageValue = 'discount')
	{
		$postHelper = $this->_loadPostHelper();
		$discount = $postHelper->getFromGet('check');
		
		require_once('helpers/Discount.php');
		
		echo Discount::checkDiscount($discount, $this->_getModelByName('AdminBase'));
	}
}