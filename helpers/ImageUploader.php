<?php
class ImageUploader
{
	public function UploadImageFromPost($dir, $name)
	{
		$from = $_FILES['uploadedfile']['tmp_name'];
		//$file_parts = pathinfo($_FILES['uploadedfile']['name']);
		$to = "images/" . $dir . "/" . $name . ".png";
		
		if (move_uploaded_file($from, $to)) {
			echo "The file " . basename($_FILES['uploadedfile']['name']) . " has been uploaded";
		} else {
			echo "There was an error uploading the file, please try again!";
			return false;
		}
		
		return true;
	}
	
	public function UploadImageFromPost3($dir, $name)
	{
		$from = $_FILES['fileToUpload']['tmp_name'];
		$extension = $this->getExtension(basename($_FILES['fileToUpload']['name']));
		$to = "$dir/$name.$extension";
		
		if (move_uploaded_file($from, $to)) {
			require_once("helpers/SimpleImage.php");
			$image = new SimpleImage();
			$image->load($to);
			$result = array();
			$result['fileName'] = "$name.$extension";
			$result['path'] = $to;
			$result['w'] = $image->getWidth();
			$result['h'] = $image->getHeight();
			return $result;
		} else {
			return false;
		}
	}
	
	function getExtension($filename)
	{
		return end(explode(".", $filename));
	}
	
	public function UploadImageFromPost2($dir)
	{
		if (empty($_FILES['uploadedfile']['name'])) {
			return null;
		}
		
		$name = time() . "." . $this->getExtension(basename($_FILES['uploadedfile']['name']));
		$nameS = time() . "_s." . $this->getExtension(basename($_FILES['uploadedfile']['name']));
		$from = $_FILES['uploadedfile']['tmp_name'];
		$to = "images/" . $dir . "/" . $name;
		$toS = "images/" . $dir . "/" . $nameS;
		
		if (move_uploaded_file($from, $to)) {
			 require_once("helpers/SimpleImage.php");
			 $image = new SimpleImage();
			 $image->load($to);
			 $image->resizeToWidth(200);
			 $image->save($toS);
			//echo "The file " . basename($_FILES['uploadedfile']['name']) . " has been uploaded";
		} else {
			//echo "There was an error uploading the file, please try again!";
			return false;
		}
		
		return $nameS;
	}
}
