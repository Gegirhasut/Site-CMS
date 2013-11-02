<?php
require_once('classes/Controllers/admin/BaseAdminObject.php');

class Main_c extends BaseAdminSecurity
{
	public function post() {
		
		if (!empty($_FILES)) {
			$tmpFile = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['name'];
			$filePath = "excel/" . $fileName;
			
			if (file_exists($filePath)) {
				$this->assign('removed', 1);
				unlink ($filePath);
			}
			
			if (move_uploaded_file ($tmpFile, $filePath)) {
				
				$this->assign('uploaded', 1);
			} else {
				
				$this->assign('error', 'ÐŸÑ€Ð¾Ð±Ð»ÐµÐ¼Ð° Ð¿Ñ€Ð¸ Ð·Ð°Ð³Ñ€ÑƒÐ·ÐºÐµ Ñ„Ð°Ð¹Ð»Ð°');
			}
		} else {
			
			$this->assign('error', 'Ð¤Ð°Ð¹Ð» Ð½Ðµ Ð±Ñ‹Ð» Ð·Ð°Ð³Ñ€ÑƒÐ¶ÐµÐ½');
		}
		
	}

	function display($uniquePageValue = 'rassilka')
	{
		$adminModel = $this->_getModelByName('AdminBase');
		$this->_defaultPage = "admin/admin-price.tpl";
		
		$lastFile = $this->GetLastFile('excel', null, array('_pics', 'zip', '_articuly'));
		$lastZipFile = 'excel/' . $lastFile . ".zip";
		if (!file_exists($lastZipFile)) {
			$zip = new ZipArchive();
			if ($zip->open($lastZipFile, ZIPARCHIVE::CREATE)!==TRUE) {
				exit("Íåâîçìîæíî îòêðûòü $lastZipFile\n");
			}
			$zip->addFile('excel/' . $lastFile);
			$zip->close();
		}
		$lastFileClients = $this->GetLastFile('excel', '_pics', 'zip');

		$lastZipFileClients = 'excel/' . $lastFileClients . ".zip";
		if (!file_exists($lastZipFileClients)) {
			$zip = new ZipArchive();
			if ($zip->open($lastZipFileClients, ZIPARCHIVE::CREATE)!==TRUE) {
				exit("Íåâîçìîæíî îòêðûòü $lastZipFileClients\n");
			}
			$zip->addFile('excel/' . $lastFileClients);
			$zip->close();
		}
		
		if ($lastFile != null) {
			$this->assign("lastFile", $lastFile);
		}
		
		if ($lastFileClients != null) {
			$this->assign("lastFileClients", $lastFileClients);
		}
		
		$this->caching = false;
		
		parent::display($uniquePageValue);
	}
  
    protected $_idIndex = 4;
    
    protected $_object = null;
    
    protected $_tableName = null;
}