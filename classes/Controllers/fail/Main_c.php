<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function display($uniquePageValue = 'checkout_fail')
	{
		$this->assign('content_page', 'checkout_fail');
		$this->assign('clean_cart', 1);
		
		if (isset($_GET['MNT_TRANSACTION_ID'])) {
			$this->assign('order_id', (int) $_GET['MNT_TRANSACTION_ID']);
		}
		
		parent::display($uniquePageValue);
	}
}