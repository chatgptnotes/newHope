
<?php
// The message
$message = "Line 1\r\nLine 2\r\nLine 3";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");

// Send
if(mail('salimkhan123@gmail.com', 'My Subject', $message)) {
  echo "Mail sent";
} else {
  echo "Mail not sent";
}
?>
