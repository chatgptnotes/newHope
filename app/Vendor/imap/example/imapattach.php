<?php
 
$host = '{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}ccda';
$login = 'pankajw@drmhope.com';
$password = 'hopehospital';
$savedirpath = "attachments";
$type = 'ReadAttachment';
$obj = new $type;
$obj->getdata($host,$login,$password,$savedirpath,$delete_emails=false);

class ReadAttachment
{

	function getdecodevalue($message,$coding) {
		switch($coding) {
			case 0:
			case 1:
				$message = imap_8bit($message);
				break;
			case 2:
				$message = imap_binary($message);
				break;
			case 3:
			case 5:
				$message=imap_base64($message);
				break;
			case 4:
				$message = imap_qprint($message);
				break;
		}
		return $message;
	}

	 
	function getdata($host,$login,$password,$savedirpath,$delete_emails=false) {
		// make sure save path has trailing slash (/)
		//print_r("test");
		$savedirpath = str_replace('\\', '/', $savedirpath);
		if (substr($savedirpath, strlen($savedirpath) - 1) != '/') {
			$savedirpath .= '/';
		}

		$mbox = imap_open ($host, $login, $password) or die("can't connect: " . imap_last_error());
		$message = array();
		$message["attachment"]["type"][0] = "text";
		$message["attachment"]["type"][1] = "multipart";
		$message["attachment"]["type"][2] = "message";
		$message["attachment"]["type"][3] = "application";
		$message["attachment"]["type"][4] = "audio";
		$message["attachment"]["type"][5] = "image";
		$message["attachment"]["type"][6] = "video";
		$message["attachment"]["type"][7] = "other";
		//print_r($message);
		$emails = imap_search($mbox,'ALL');
		print_R($emails);
		foreach($emails as $email_number) {
			$structure = imap_fetchstructure($mbox, 1 , FT_UID);
			$parts = $structure->parts;
			print_R($parts);
			exit;
			$fpos=2;
			for($i = 1; $i < count($parts); $i++) {
				$message["pid"][$i] = ($i);
				$part = $parts[$i];

				if($part->disposition == "ATTACHMENT") {
					$message["type"][$i] = $message["attachment"]["type"][$part->type] . "/" . strtolower($part->subtype);
					$message["subtype"][$i] = strtolower($part->subtype);
					$ext=$part->subtype;
					$params = $part->dparameters;
					$filename=$part->dparameters[0]->value;
						
					$mege="";
					$data="";
					$mege = imap_fetchbody($mbox,$email_number,$fpos);
					$filename="$filename";
					$fp=fopen($savedirpath.$filename,"w");
					$data=$this->getdecodevalue($mege,$part->type);
					//print_r($data);
					fputs($fp,$data);
					fclose($fp);
					$fpos+=1;
				}
			}
				
		}
		// imap_expunge deletes all tagged messages

		imap_close($mbox);
	}
}


?>