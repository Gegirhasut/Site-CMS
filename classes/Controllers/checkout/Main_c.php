<?php
require_once('classes/Controllers/BaseAppController.php');
require_once('helpers/Email.php');
require_once('helpers/Cart.php');
require_once('classes/Objects/Order.php');
require_once('classes/Objects/Product.php');
require_once('classes/Objects/OrderProduct.php');

class Main_c extends BaseAppController
{
	function post() {
		$order = new Order();
		$postHelper = $this->_loadPostHelper();
		
		$p_ids = $postHelper->GetFromPostByMask('p_');
		
		$this->ParsePost($order->_object);
		
		if ($this->CheckObject($order->_object)) {
			require_once('helpers/Discount.php');
			$discount = $postHelper->getFromPost('discount');
			$discount_percent = Discount::checkDiscount($discount, $this->_adminModel);
			if ($discount_percent != 0) {
				$order->_object['fields']['discount_percent']['value'] = $discount_percent;
				$order->_object['fields']['discount']['value'] = $discount;
			} else {
				unset($order->_object['fields']['discount_percent']);
				unset($order->_object['fields']['discount']);
			}

            $hash = time();
			$order->_object['fields']['number']['value'] = $hash;
			if (isset($_SESSION['user']) && $_SESSION['user']['state'] == 1) {
				$order->_object['fields']['opt']['value'] = 1;
			} else {
				$order->_object['fields']['opt']['value'] = 0;
			}
			$o_id = $this->_adminModel->add($order->_object, $order->_tableName, false);
			
			$order_product = new OrderProduct();
			
			$order_product->_object['fields']['o_id']['value'] = $o_id;
			foreach ($p_ids as $p_id_mask => $count) {
				$p_id = str_replace('p_', '', $p_id_mask);
				$order_product->_object['fields']['p_id']['value'] = $p_id;
				$order_product->_object['fields']['count']['value'] = $count;
				$this->_adminModel->add($order_product->_object, $order_product->_tableName, true);
			}
			
			$this->SendLetters($o_id, $order->_object['fields']['email']['value'], $discount, $discount_percent, $hash);

			header('location: /order/' . $o_id . "?hash=" . $hash);
			exit;
		} else {
			$this->assign('error', $order->_object['check_error']);
		}
		
	}
	
	function RegisterDiscount($discount, $discount_percent, $totalPrice, $client_mail) {
		require_once('classes/Objects/Card.php');
		$card = new Card();
		
		$cards = $this->_adminModel->get(
			$card->_tableName,
			"email='$client_mail'"
		);
		
		$card->_object['fields']['discount']['value'] = $discount;
		$card->_object['fields']['discount_percent']['value'] = $discount_percent;
		$card->_object['fields']['email']['value'] = $client_mail;
		$card->_object['fields']['total_payed']['value'] = $totalPrice;
		
		if (empty($cards)) {
			$this->_adminModel->add($card->_object, $card->_tableName, false);
		} else {
			$card->_object['fields']['total_payed']['value'] += $cards[0]['total_payed'];
			$new_discount = Discount::checkDiscountPercent($card->_object['fields']['total_payed']['value']);
			
			$card->_object['fields']['id']['value'] = $cards[0]['id'];
			$card->_object['fields']['discount_percent']['value'] = $new_discount;
			$this->_adminModel->update($card->_object, $card->_tableName);
		}
	}
	
	function SendLetters($o_id, $client_mail, $discount, $discount_percent, $hash) {
		$product = new Product();
		$order_product = new OrderProduct();
		
  	    $products = $this->_adminModel->get(
  	    	$order_product->_tableName,
  		    "left join {$product->_tableName} on {$product->_tableName}.r_id = {$order_product->_tableName}.p_id
  		    where {$order_product->_tableName}.o_id = $o_id",
  	        false
  	    );
		
		$orderInfo = "<table>";
		$orderInfo .=
			"<tr>" .
				"<th style='text-align: center;'>Артикул</th>" .
				"<th style='text-align: center;'>Наименование</th>" .
				"<th style='text-align: center;'>Цена</th>" .
				"<th style='text-align: center;'>Количество</th>" .
				"<th style='text-align: center;'>Сумма</th>" .
			"</tr>";
		
		$totalPrice = 0;
		$totalCount = 0;
		
		foreach ($products as $p) {
			$pPrice = $p['price'] * $p['count'];
			$totalPrice += $pPrice;
			$totalCount += $p['count'];
			
			$orderInfo .= 
				"<tr>" .
					"<td style='text-align: center;'>{$p['code']}</td>" .
					"<td style='text-align: center;'><a href='http://arktida-opt.ru/products/{$p['url']}'>{$p['name']}</a></td>" .
					"<td style='text-align: center;'>{$p['price']}</td>" .
					"<td style='text-align: center;'>{$p['count']}</td>" .
					"<td style='text-align: center;'>$pPrice</td>" .
				"</tr>";
		}
		
		$orderInfo .= 
				"<tr>" .
					"<td style='text-align: center;'><b>Итого:</b></td>" .
					"<td style='text-align: center;'></td>" .
					"<td style='text-align: center;'></td>" .
					"<td style='text-align: center;'><b>$totalCount</b></td>" .
					"<td style='text-align: center;'><b>$totalPrice</b></td>" .
				"</tr>";
		
		if ($discount != 0) {
			$totalPrice = round($totalPrice / 100 * (100 - $discount_percent), 2);
			
			$this->RegisterDiscount($discount, $discount_percent, $totalPrice, $client_mail);
			
			$orderInfo .= 
				"<tr>" .
					"<td style='text-align: center;'><b>Итого со скидкой $discount_percent %:</b></td>" .
					"<td style='text-align: center;' colspan='3'></td>" .
					"<td style='text-align: center;'><b>$totalPrice</b></td>" .
				"</tr>";
		}
		
		$orderInfo .= "<tr><td colspan='5'>Ссылка на заказ: <a href='http://arktida-opt.ru/order/$o_id?hash=$hash'>Заказ $o_id</a></td></tr>";
		
		$orderInfo .=  "<tr><td colspan='5'>Ваш заказ принят и находится в обработке, наш менеджер свяжется с вами для подтверждения заказа в ближайшие рабочие часы.</td></tr>";
		
		$orderInfo .= "</table>";
		
		$mail = new Email();
		$mail->LoadTemplate('new_order');
		$mail->SetValue('order_info', $orderInfo);
		$mail->Send($client_mail, 'Ваш заказ');
		
		$postHelper = $this->_loadPostHelper();
		$fio = $postHelper->GetFromPost('fio');
		$firm = $postHelper->GetFromPost('firm');
		$phone = $postHelper->GetFromPost('phone');
		$city = $postHelper->GetFromPost('city');
		
		$clent_info = "<b>Заказчик:</b> $fio<br/>";
		$clent_info .= "<b>Организация:</b> $firm<br/>";
		$clent_info .= "<b>Телефон:</b> $phone<br/>";
		$clent_info .= "<b>Город:</b> $city<br/>";
		$clent_info .= "<b>E-mail:</b> $client_mail<br/>";
		
		if ($discount != 0) {
			$clent_info .= "<b>Скидочная карта:</b> $discount, скидка $discount_percent %<br/>";
		} else {
			$clent_info .= "<b>Скидочная карта:</b> не использовалась<br/>";
		}
		
		if ($client_mail == 'max077@mail.ru') {
			$GLOBALS['db_config']['manager'] = 'max077@mail.ru';
		}
		
		$mail->LoadTemplate('new_order_for_manager');
		$mail->SetValue('client_info', $clent_info);
		$mail->SetValue('order_info', $orderInfo);
		
		$mail->Send($GLOBALS['db_config']['manager'], 'Новый заказ');
	}
	
	function display($uniquePageValue = 'checkout')
	{
		$this->assign('content_page', 'checkout');
		
		parent::display($uniquePageValue);
	}
}