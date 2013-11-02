<?php
class Math {
	public static function round($v)
	{
$v = round($v,2);
if ($v == round($v))
{
	return $v . ".00";
} 
if ($v == round($v,1))
{
	return $v . "0";
} 
return $v;
			}
}