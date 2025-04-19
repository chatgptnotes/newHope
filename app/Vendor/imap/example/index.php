<?php
ini_set("max_execution_time", "300");
error_reporting(E_ALL);
require_once('../src/ImapMailbox.php');
  
// IMAP must be enabled in Google Mail Settings
define('GMAIL_EMAIL', 'direct@direct.drmhope.com');
define('GMAIL_PASSWORD', 'drm2628');
define('ATTACHMENTS_DIR', dirname(__FILE__) . '/attachments');

$mailbox = new ImapMailbox('{imap.mdemail.md:993/imap/ssl}inbox', GMAIL_EMAIL, GMAIL_PASSWORD, ATTACHMENTS_DIR, 'utf-8');
$mails = array();

$stream = $mailbox->getImapStream(); //mailbox resource
// Get some mail
$mailsIds = $mailbox->searchMailBox('ALL');
if(!$mailsIds) {
	die('Mailbox is empty');
}else{
	foreach($mailsIds as $mailKey =>$mailId){ 
		 
		/* $mail = $mailbox->getMail($mailId); 
		print_R($mail);
		$attachement = $mail->getAttachments() ; */
		/*foreach ($attachement as $val){
			print_r($val);
			$filePath = $val->filePath ;
		} */
		  
		
	 	$encrypted = imap_fetchmime($stream, $mailId, "1", FT_UID);
	 	 
		$encrypted   .= imap_fetchbody($stream, $mailId, "1", FT_UID); 
		// Write the needed temporary files
		$infile = "C:\Users\hope\Desktop\ccda\emailimport.txt";
		file_put_contents($infile,$encrypted);
		$outfile = "C:\Users\hope\Desktop\ccda\emailexport.txt";
		
		// The certification stuff
	 	/* $public = file_get_contents("C:/ccda/local/local_cert.pem");
	 	$private = array(file_get_contents("C:/ccda/local/local_key.key"), "hope"); */
		
		
		$public = file_get_contents("D:\mystuff\ccda\drmhope.com\drmhope.com.crt");
		$private = array(file_get_contents("D:\mystuff\ccda\drmhope.com\drmhope.com.key"), "hope");
		
		
		// Ready? Go!
		if(openssl_pkcs7_decrypt($infile,$outfile, $public, $private))
		{
			echo " Decryption successful " ;
			//echo $ss= file_get_contents($outfile) ;
			verify($outfile);
			
			//imap_base64  
			/* $parts = explode("\r", $ss, 2);
			echo $parts[1];  
			echo imap_base64($parts[1]);	 */ 
		}
		else{
			while ($msg = openssl_error_string()) echo $msg . "<br />\n";
			// Decryption failed
			echo "Oh oh! Decryption failed!";
		}
		 
	}
}


function verify($signedData, &$data = null) {
	//@mkdir("tmp");
	$random = rand(5,2);
	$root = "D:\wamp\www\ccda\\" ;

	$file = $root.$random . ".dat";
	
	$pemfile = $root."cert.pem" ;
	$txtfile = $root."textdata.txt";


	chdir("C:\Program Files\GnuWin32\bin\\"); //for openssl commands
	
	
	//echo $output = exec("openssl smime  -verify -in $signedFile -inform DER -noverify -out $file 2>&1");
	//to verify text
	echo "exec output  :". $output = system("openssl smime -verify -in $signedData -noverify -signer  $pemfile -out $txtfile 2>&1");
	// openssl smime -verify -in C:\Users\hope\Desktop\pawan.txt -noverify -signer C:\Users\hope\Desktop\cert.pem -out C:\Users\hope\Desktop\textdata.txt 
	$splitted  = explode("\r\n\r\n",file_get_contents($txtfile ));
	echo count($splitted)-1;
	//echo $splitted[2] ;
	echo imap_base64($splitted[count($splitted)-2]);
	
	$elements = imap_mime_header_decode($text);
	
	
	if ($output == "Verification successful") {
		//	$data = file_get_contents($file);
		$result = true;
	} else {
		echo "Still .... :( " ;
		$result = false;
	}
	//@unlink($signedFile);
	//@unlink($file);
	return $result;
}

 


