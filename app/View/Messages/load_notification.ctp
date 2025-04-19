<?php
$sentItems = $ccdaItems['sentItems'] ;
	$receivedItems = $ccdaItems['receivedItems'] ;
	$preparedArray = array() ;
	foreach($receivedItems as $key=>$value){
		$splitted = explode("_",$key) ;
		unset($splitted[0]);
		$key = implode("_",$splitted);
		$preparedArray[$key] = $value;
	}
	
	foreach($sentItems as $key=>$message){
		$sentTime  =$this->DateFormat->dateDiff($message['TransmittedCcda']['created_on'],date('Y-m-d H:i:s'));
		$replacedFileName  = preg_replace(array_keys($replace), $replace, $message['TransmittedCcda']['file_name']) ;
		if(!empty($preparedArray[$replacedFileName]) ||  $sentTime->days  == "0") continue ; //check if xml is in incorparted_ccda list
		if($message['TransmittedCcda']['notify']=='no'){
			$count++ ;
			$notifyIds[] = $message['TransmittedCcda']['id'];
		}

		$notificationHtml .= "<li id=test$key>OverDue - ".$message['TransmittedCcda']['to']."<br>" ;
		$notificationHtml .= $this->Html->link(ucfirst($message['TransmittedCcda']['subject']),
				array('controller'=>'Ccda','action'=>'overdue_summary_care','admin'=>false),array('title'=>$message['TransmittedCcda']['subject']));
		$notificationHtml .= "</li>" ;
			
	}

	foreach($receivedMails['mailData'] as   $mails ){
		if($mails['Inbox']['notify']=='no'){
			$count++ ;
			$notifyMsgIds[] = $mails['Inbox']['id'];
		}
		$notificationHtml .= "<li>You have new message from - ".$mails['Inbox']['from_name']."<br>" ;
		$notificationHtml .= $this->Html->link(ucfirst($mails['Inbox']['subject']),
				array('controller'=>'messages','action'=>'inbox','admin'=>false),array('title'=>$mails['Inbox']['subject']));
		$notificationHtml .= "</li>" ;
	}

	echo $notificationHtml;?>