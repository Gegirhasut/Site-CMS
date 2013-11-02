<?php
class Error
{
	public static function reportBadUrl()
	{
		switch ($GLOBALS['mode']) {
			case 'debug' : echo "No controller " . UrlParser::getControllerPath(); 
						   break;
			case 'production' : echo "Bad url requested";
							    break; 
		}
				
		exit();
	}
}