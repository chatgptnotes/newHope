<?php
$headers = 'From: webmaster@example.com';
//	mail('salimkhan123@gmail.com', 'Test email using PHP', 'This is a test email message', $headers, '-salimkhan123@gmail.com');
?>
<?php
	$to = 'salimkhan123@gmail.com';
	$subject = 'Test email using PHP';
	$message = 'This is a test email message';
	$headers = 'From: salimkhan123@gmail.com' . "\r\n" .
           'Reply-To: salimkhan123@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
	$mail = mail($to, $subject, $message, $headers, '-salimkhan123@gmail.com');
	echo $mail;

?>