<?php 
    $host = "sandbox.e-imo.com";
    $port = "42011";
    $timeout = 15;  //timeout in seconds
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
      or die("Unable to create socket\n");
    //socket_set_nonblock($socket)
     // or die("Unable to set nonblock on socket\n");
    $result=socket_connect($socket, $host, $port);
 if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . 
socket_strerror(socket_last_error($socket)) . "\n";
} else {
    //echo "OK.\n";
}
    $time = time();
 $msg = "search^10|||1^paracetomol^e0695fe74f6466d0^" . "\r\n";
                if (!socket_write($socket, $msg, strlen($msg))) {
                                echo socket_last_error($socket);
                } 
 
                while ($bytes=socket_read($socket, 100000)) {
                                if ($bytes === false) {
                                                echo 
socket_last_error($socket);
                                                break;
                                }
                                if (strpos($bytes, "\r\n") != false) break;
                }
 
                socket_close($socket); 
                $xmlString=$bytes;
               // $tempLocalPath = "imo.xml";
               // file_put_contents($tempLocalPath, $xmlString);
                //$xmldata = simplexml_load_file("imo.xml");
				$xmldata = simplexml_load_string($xmlString);
				$cnt=0;
				foreach($xmldata->item as $item)
{
	$cnt++;
        echo "<p>Item Name: " . $cnt.$item["code"] . "</p>";
        echo "<p>Item Title: " . $item["title"] . "</p>";
        echo "<p>SNOMED_DESCRIPTION: " . $item["SNOMED_DESCRIPTION"] . "</p>";
}


?>

