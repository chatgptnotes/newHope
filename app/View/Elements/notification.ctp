
<style>
 /* 
	LEVEL ONE
*/
ul.dropdown                         { position: relative; width: 100%; }
ul.dropdown li                      { font-weight: bold; float: left; width: 100%; background: #ccc; position: relative; }
ul.dropdown a:hover		            { color: #000; }
ul.dropdown li a                    { display: block; padding: 20px 8px; color: #222; position: relative; z-index: 2000; }
ul.dropdown li a:hover,
ul.dropdown li a.hover              { background: #F3D673; position: relative; }


/* 
	LEVEL TWO
*/
ul.dropdown   						{   height:400px;position: absolute; top: 0; left: 0;  z-index: 1000;   overflow:scroll; 
    border-radius: 2px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.7);
    color: #FFFFFF;
    padding:0 0 0 20px;
    margin:0px;
    background:none repeat-x scroll 0 0 #FFFFFF;
    
}
ul.dropdown li 					{ font-weight: normal; background: #f6f6f6; color: #000; border-bottom: 1px solid #ccc; }
ul.dropdown li a					{ display: block; background: #eee !important; } 
ul.dropdown li a:hover			{ display: block; background: #F3D673 !important; }  
 </style>

<?php 
	//echo $this->Html->script(array(/*'jquery-1.5.1.min.js',*/'scrollPaging'));  
?>
 <!-- Notificatin_html start here -->

<ul class="notification_div" id="notification_div">
	<?php echo $this->Html->image('icons/notification_icon.jpg', array('width'=>'20','height'=>'20','class'=>'pateintpic','title'=>'Notification')); 
	$count = 0 ;
	$replace = array(
			'/\s/' => '_',
			'/[^0-9a-z        A-Z_\.]/' => '',
			'/_+/' => '_',
			'/(^_)|(_$)/' => '',
	);
	 
	$sentItems = $ccdaItems['sentItems'] ; 
	$receivedItems = $ccdaItems['receivedItems'] ;
	$preparedArray = array() ;
	foreach($receivedItems as $key=>$value){
		$splitted = explode("_",$key) ;
		unset($splitted[0]);
		$key = implode("_",$splitted);
		$preparedArray[$key] = $value;
	}
	$notificationHtml .= '<ul  style="list-style-type: none;" ><li>
	<ul class="dropdown"  id="mailNotify">' ;
	foreach($sentItems as $message){
		$sentTime  =$this->DateFormat->dateDiff($message['TransmittedCcda']['created_on'],date('Y-m-d H:i:s'));  
		$replacedFileName  = preg_replace(array_keys($replace), $replace, $message['TransmittedCcda']['file_name']) ;
		if(!empty($preparedArray[$replacedFileName]) ||  $sentTime->days  == "0") continue ; //check if xml is in incorparted_ccda list
		if($message['TransmittedCcda']['notify']=='no'){
			$count++ ;
			$notifyIds[] = $message['TransmittedCcda']['id'];
		} 
		
		$notificationHtml .= "<li>OverDue - ".$message['TransmittedCcda']['to']."<br>" ;
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
	
	$notificationHtml .= '</ul></li></ul>'; 
	
	if($count > 0 ){
	?> 
	<input id="notify-ids" value="<?php echo implode(',',$notifyIds) ;?>" type="hidden">
	<input id="notify-msg-ids" value="<?php echo implode(',',$notifyMsgIds) ;?>" type="hidden">
	<div class="noti_red_part" id="noti_red_part"> 
		<?php echo $count ; ?>
	</div><a><?php  } ?></a>
	<div class="notification_template"  style="display:none;" id="notification_template">
		<div class="notificationarrow_div">
			<?php  echo $this->Html->image('icons/notification_arrow.png');?>
		</div> 
		<?php echo $notificationHtml ;  ?>
	</div>
</ul> 

<!-- Notificatin_html close here -->
<script>
$(document).ready(function() {
	//  $ = jQuery.noConflict(true);
	  
	  var offset = 2;
	  totalRecordCount  = "<?php echo ($receivedMails['mailCount']>$ccdaItems['ccdaCount'])?$receivedMails['mailCount']:$ccdaItems['ccdaCount']; ?>" ;
	  $("#mailNotify").scrollPaging({
		  url : '<?php echo $this->Html->url(array('controller'=>'app','action'=>'loadNotificationMessage','admin'=>false))?>', //required
		  totalRecordCount : totalRecordCount,//required
		  divToScroll:"#mailNotify",
		  offset :offset, //required
		  data :'key=value',//you can pass extra params here
		  beforeSend : function(){
		  var loader = '<li id="scrollLoader">loading please wait ....</li>'; 
		 	 $('#mailNotify').append(loader);
		  },
		  success : function(result) { //required
			  $('#scrollLoader').remove(); 
			  $('#mailNotify').append(result);
		  }
	  });
	 
	  $("#notification_div").click(function(){
		 ids = $("#notify-ids").val();
		 msgIds  = $("#notify-msg-ids").val();
		 $("#noti_red_part").hide();
		 if(ids != '' && typeof ids != 'undefined'){ 
		 	$.ajax({
		      	url: "<?php echo $this->Html->url(array("controller" => 'ccda', "action" => "updateNotify", "admin" => false)); ?>",
		      	context: document.body, 
		      	data:"ids="+ids,  
		      	type:'POST',      
				success: function(data){ 
		     		 
				}
		    });
		 }
		 if(msgIds != '' && typeof ids != 'undefined'){ 
		 	$.ajax({
		      	url: "<?php echo $this->Html->url(array("controller" => 'Messages', "action" => "updateNotify", "admin" => false)); ?>",
		      	context: document.body, 
		      	data:"ids="+msgIds,  
		      	type:'POST',      
				success: function(data){ 
		     		 
				}
		    });
		 }
	});
});
</script>