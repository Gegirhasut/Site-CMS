<?php
function arrayToJson($array)
{
	$jsonArray = false;
	$json = "";
	foreach ($array as $key => $value) {
		if (!is_int($key)) {
			$json .= '"' . $key . '":';
		} else {
			$jsonArray = true;			
		}
		if (is_array($value)) {
			$json .= arrayToJson($value) . ", ";
		} else {
			$json .= '"' . $value . '",';
		}
	}
	if ($jsonArray) {
		$json = "[" . rtrim($json, ', ') . "]";
	} else {
		$json = "{" . rtrim($json, ', ') . "}";
	}
	return $json;
}
