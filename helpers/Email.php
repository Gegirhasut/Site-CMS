<?php
class Email
{
	public $_body;
	 
	public function LoadTemplate($name)
	{
		$this->_body = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/helpers/email_templates/$name.html");
	}
	
	public function SetValue($name, $value)
	{
		$this->_body = str_replace("[$name]", $value, $this->_body);		
	}
	
	public function Send($to, $subject, $reply = null, $copy = true)
	{
		//echo "[$to]";
		if ($reply == null) {
			$reply = "irina@arktida-opt.ru";
		}
		
		$this->fixBody();
		
		$subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
		
		if ($_SERVER['SERVER_NAME'] == 'localhost') {
			return;
			echo $this->_body;
			exit;
		}
		/*echo "[$to],<br>[[$subject]]<br>" . $this->_body;
		exit;*/
		
		mail($to, $subject, $this->_body, $this->_getHeaders($reply));
		if (strpos($to, "max077@mail.ru") === false && $copy) {
			mail("max077@mail.ru", "[Ушло клиенту] " . $subject, $this->_body, $this->_getHeaders($reply));
		}
	}
	
	public function SendWithAttachments($to, $subject, $files, $reply = null, $copy = true) {
		$reply = "info@arktida-opt.ru";
		
		$uid = md5(time());
		
		$this->fixBody();
		
		if ($_SERVER['SERVER_NAME'] == 'localhost') {
			echo $this->_body;
			exit;
		}
	    
	    $header = "From: =?utf-8?b?" . base64_encode('Арктида ') . "?= <" . $reply . ">\r\n";
	    $header .= "Reply-To: ".$reply."\r\n";
	    $header .= "MIME-Version: 1.0\r\n";
	    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	    $header .= "This is a multi-part message in MIME format.\r\n";
	    $header .= "--".$uid."\r\n";
	    $header .= "Content-type:text/html; charset=utf-8\r\n";
	    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	    $header .= $this->_body."\r\n\r\n";
	    $header .= "--".$uid."\r\n";
	    
	    foreach ($files as $file) {
	    	$file_size = filesize($file);
		    $handle = fopen($file, "r");
		    $content = fread($handle, $file_size);
		    fclose($handle);
		    $content = chunk_split(base64_encode($content));
		    
		    $filename = $file;
		    
		    $pos = strpos($filename, '/');
			if ($pos !== false) {
				$filename = substr($filename, $pos + 1);
			}
	    	
		    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
		    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n";
		    $header .= "Content-Transfer-Encoding: base64\r\n\r\n";
		    $header .= $content."\r\n\r\n";
		    $header .= "--".$uid."\r\n";
	    }
	    
	    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
	    
		mail($to, $subject, '', $header);
	}
	
	function mail_utf8($to, $subject = '(No subject)', $message = '', $header = '') {
  		$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
  		mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $header);
	}
	
	public function SendToSupport($subject, $reply = null)
	{
		$this->Send("max077@mail.ru", $subject, $reply);
	}
	
	private function fixBody()
	{
		$this->_body = str_replace(", !", "!", $this->_body);
		$this->_body = str_replace("\\r\\n", "<br/>", $this->_body);
	}
	
	private function _getHeaders($reply)
	{
		$headers = "From: =?utf-8?b?" . base64_encode('Арктида ') . "?= <" . $reply . ">\r\n" .
    			   "Reply-To: $reply\r\n" .
		   		   'Content-type: text/html; charset=utf-8' . "\r\n".
    	           'X-Mailer: PHP/' . phpversion();
			
		return $headers;
	}
}