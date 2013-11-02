<?php
require_once('classes/Controllers/BaseAppController.php');

class Main_c extends BaseAppController
{
	function post () {
		if (isset($_POST['MNT_TRANSACTION_ID'])) {
			$order_id = (int) $_POST['MNT_TRANSACTION_ID'];
			require_once('classes/Objects/Order.php');
			
			$order = new Order();
			
			$orders = $this->_adminModel->get($order->_tableName, "o_id=$order_id and payed = 0");
			
			if (!empty($orders)) {
				$order->_object['fields']['o_id']['value'] = $order_id;
				$order->_object['fields']['payed']['value'] = 1;
				$this->_adminModel->update($order->_object, $order->_tableName);
				
				require_once('helpers/Email.php');
				$mail = new Email();
				$mail->LoadTemplate('new_payed_order');
				
				$mail->SetValue('o_id', $order_id);
				$mail->SetValue('fio', $orders[0]['fio']);
				$mail->SetValue('organisation', $orders[0]['organisation']);
				$mail->SetValue('phone', $orders[0]['phone']);
				$mail->SetValue('email', $orders[0]['email']);
				$mail->SetValue('city', $orders[0]['city']);
				
				$mail->Send($GLOBALS['db_config']['manager'], 'Оплата заказа ' . $order_id);
			}
		}
	}
	
	function display($uniquePageValue = 'pay')
	{
		$this->assign('content_page', 'checkout_pay');
		$this->assign('clean_cart', 1);
		
		parent::display($uniquePageValue);
	}
}