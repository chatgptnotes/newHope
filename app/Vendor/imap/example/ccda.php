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

// Get some mail
$mailsIds = $mailbox->searchMailBox('ALL');
if(!$mailsIds) {
	echo  'Mailbox is empty' ;
}

//$mailId = reset($mailsIds);

foreach($mailsIds as $mailId){
	$mail = $mailbox->getMail($mailId); 
	print_R($mail);
	var_dump($mail->getAttachments());
}