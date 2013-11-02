<?php
class Kurs
{
	public static $kStr = null;
	public static $clear_cache = false;
	
	public static function ReloadKurs()
	{
		$today = getdate();
		$dStr = $today['year'] . "." . $today['mon'] . "." . $today['mday'];
		$path = 'kurses/' . $dStr;
		 
		if (file_exists($path)) {
			self::$kStr = file_get_contents($path);
		} else {
			$kurses = self::get_cbr_ru();
			$pattern = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i"; 
  			preg_match_all($pattern, $kurses, $out, PREG_SET_ORDER);
  			foreach($out as $cur) 
  			{ 
  				if($cur[2] == 826) self::$kStr .= str_replace(",",".",$cur[4]) . ":";
    			if($cur[2] == 840) self::$kStr .= str_replace(",",".",$cur[4]) . ":"; 
    			if($cur[2] == 978) self::$kStr .= str_replace(",",".",$cur[4]) . ":"; 
  			}
  			 
			$handle = fopen($path, "x");
			fwrite($handle, self::$kStr);
			fclose($handle);
			self::$clear_cache = true;
		}
	}
	
	public static function get_cbr_ru() 
    { 
    	// ��������� ����������� ���� 
    	$date = date("d/m/Y"); 
    	//��������� ������ 
    	$link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date"; 
	    // ��������� HTML-�������� 
    	$fd = fopen($link, "r"); 
	    $text=""; 
    	if (!$fd) echo "������������� �������� �� �������"; 
	    else 
    	{ 
	      // ������ ����������� ����� � ���������� $text 
    	  while (!feof ($fd)) $text .= fgets($fd, 4096); 
	    } 
    	// ������� �������� �������� ���������� 
	    fclose ($fd);
    	return $text; 
  	}
}