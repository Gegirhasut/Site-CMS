<?php
require_once('classes/Controllers/BaseController.php');

class Main_c extends BaseController
{	
	function post() {
	    $postHelper = $this->_loadPostHelper();
		$operation = $postHelper->GetFromPost('operation');
		$x = $postHelper->GetFromPost('x');
		$y = $postHelper->GetFromPost('y');
		$x2 = $postHelper->GetFromPost('x2');
		$y2 = $postHelper->GetFromPost('y2');
		$path = $postHelper->GetFromPost('path');
		$dest_w = $postHelper->GetFromPost('dest_w');
		$dest_h = $postHelper->GetFromPost('dest_h');
		$imgSmallPath = $postHelper->GetFromPost('imgSmallPath');
		$uploadPath = $postHelper->GetFromPost('uploadPath');
		
		require_once('helpers/SimpleImage.php');
		$simpleImage = new SimpleImage();
		$simpleImage->load($path);
		$simpleImage->crop($x, $y, $x2, $y2, $dest_w, $dest_h);
		$new_path = str_replace($uploadPath, $imgSmallPath, $path);
		$simpleImage->save($new_path);
		
		if (isset($_POST['delete']) && $_POST['delete'] == 1) {
		  unlink($path);
		}
		
		require_once('helpers/json.php');
		echo $new_path;
		exit();
	}

	function display($uniquePageValue = 'user_pic')
	{
	}
}