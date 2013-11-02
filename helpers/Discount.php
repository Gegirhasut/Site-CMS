<?php
class Discount
{
	public static function checkDiscount($discount, $adminModel) {
		if ($discount >= 10000 && $discount <= 10500) {
			require_once('classes/Objects/Card.php');
			$card = new Card();
			
			$cards = $adminModel->get(
				$card->_tableName,
				"discount='$discount'"
			);
			
			if (empty($cards))
				return 5;
			
			return $cards[0]['discount_percent'];
		}
		
		return 0;
	}
	
	public static function checkDiscountPercent($summ) {
		if ($summ >= 2501 && $summ < 3000) {
			return 6;
		}
		
		if ($summ >= 3001 && $summ < 4000) {
			return 7;
		}
		
		if ($summ >= 4001 && $summ < 5000) {
			return 8;
		}
		
		if ($summ >= 5001 && $summ < 6000) {
			return 9;
		}
		
		if ($summ >= 7001 && $summ < 8000) {
			return 10;
		}
		
		if ($summ >= 8001 && $summ < 10000) {
			return 12;
		}
		
		if ($summ >= 10001) {
			return 15;
		}
		
		return 5;
	}
}