<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
<script>
    //var encrypted = CryptoJS.AES.encrypt("First Message", "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad");

    //alert(encrypted); // {"ct":"tZ4MsEnfbcDOwqau68aOrQ==","iv":"8a8c8fd8fe33743d3638737ea4a00698","s":"ba06373c8f57179c"}

    //var decrypted = CryptoJS.AES.decrypt(encrypted, "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad");
//alert(decrypted);
    //alert(decrypted.toString(CryptoJS.enc.Utf8)); // Message
</script>
<?php  echo $this->Html->script('fckeditor/fckeditor');  ?>
 <?php //echo $javascript->link('fckeditor'); ?> 
<style>
.is_read{
font-weight: bold;
font-size: 12px;
}
#forward_message_text{
display:none;
}
#open_message{
display:none;
}
.class_td{
font-size:12px;
font-weight:bold;
background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
border-bottom: 1px solid #3E474A;
color: #FFFFFF;
}

.class_td1{background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
   border-bottom: 1px solid #3E474A;
   color: #FFFFFF; font-size:12px;font-weight:bold;
}
.class_td2{background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
   border-bottom: 1px solid #3E474A;
   color: #FFFFFF; font-size:12px;font-weight:bold;
}
.table_format{
border: 1px solid #3E474A;}
.email_format{border: 1px solid #3E474A;}


</style>
<div id="message_error" align="center">
	
</div>
<div class="inner_title" style="margin-bottom:25px;">
	<h3><?php echo __('Outbox') ?></h3>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"Laboratories","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span>
</div>
<div align="center" id='temp-busy-indicator' style="display: none;">
&nbsp;
<?php echo $this->Html->image('indicator.gif', array()); ?>
</div>
<ul class="interIcons">
 <!-- <li> <?php echo  $this->Html->link($this->Html->image('/img/icons/compose inner.png', array('alt' => 'Compose')),array("controller" => "messages", "action" => "compose", 'plugin' => false), array('escape' => false,'label'=>'Compose')); ?></li> -->
	<!-- <li> <?php echo  $this->Html->link($this->Html->image('/img/icons/inbox inner.png', array('alt' => 'Inbox')),array("controller" => "Hl7TextMessages", "action" => "index", 'plugin' => false), array('escape' => false,'label'=>'Inbox')); ?></li> 
	<li> <?php echo  $this->Html->link($this->Html->image('/img/icons/laboratory.png', array('alt' => 'Result')),array("controller" => "laboratories", "action" => "hlseven",'plugin' => false), array('escape' => false,'label'=>'Result')); ?></li>-->
	<li> <?php //echo $this->Html->link('Compose',array("controller" => "messages", "action" => "compose", "admin" => false,'plugin' => false), array('escape' => false)); ?></li>
	<li> <?php //echo $this->Html->link('Inbox',array("controller" => "messages", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?></li>
</ul>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
<tr class="row_title">
<td class="table_cell"><strong><?php echo __('Patient Id') ?> </strong></td>
   <td class="table_cell"><strong><?php echo __('Message') ?> </strong></td>
   <td class="table_cell"><strong><?php echo __('Message Type') ?> </strong></td>
   <td class="table_cell"><strong><?php echo __('Receipient Name') ?> </strong></td>
   <td class="table_cell"><strong><?php echo __('Patient Name') ?> </strong></td>
   <td class="table_cell"><strong><?php echo __('Time') ?> </strong></td>
</tr>
<?php
$toggle =0;
if(count($messages) > 0) {
	foreach($messages as $message){//echo '<pre>';print_r($message);exit;
if($toggle == 0) {
	echo "<tr class='row_gray'>";
	$toggle = 1;
}else{
	echo "<tr>";
	$toggle = 0;
}
$messageId = $message['Hl7Message']['id'];
$isPatient = $message['Hl7Message']['is_patient'];
//$isRead = $message['Hl7Message']['is_read'];
$message['Hl7Message']['message'] = str_replace(" ", "+", $message['Hl7Message']['message']);	
//$message['Hl7Message']['subject'] = str_replace(" ", "+", $message['Hl7Message']['subject']);	
	
if($message['Hl7Message']['is_read'] == 0){
?>				
<td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['Hl7Message']['patient_id']; ?></a></td>
   <td class="row_format is_read" id="subject_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php 
   echo substr($message['Hl7Message']['message'], 0, 40);
   //echo $message['Hl7Message']['message']; ?></a> </td>
   <td class="row_format is_read" id="subject_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['Hl7Message']['message_from']; ?></a> </td>
   <td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['Hl7Message']['message_to']; ?></a></td>
   <td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['Hl7Message']['patient_name']; ?></a></td>
   <td class="row_format is_read" id="time_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo 
                   	  	  	$this->DateFormat->formatDate2Local($message['Hl7Message']['create_time'],'mm/dd/yyyy',true); ?></a></td>
<?php }else{ ?>
<td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['Hl7Message']['patient_id']; ?></a></td>
   <td class="row_format is_read" id="subject_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php 
   echo substr($message['Hl7Message']['message'], 0, 40);
   //echo $message['Hl7Message']['message']; ?></a> </td>
   <td class="row_format is_read" id="subject_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['Hl7Message']['message_from']; ?></a> </td>
   <td class="row_format is_read" id="time_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo 
                   	  	  	$this->DateFormat->formatDate2Local($message['Hl7Message']['create_time'],'mm/dd/yyyy',true); ?></a></td>
  
   </tr>
   
<?php 
}
} 
}
?>	
<tr>
<TD colspan="8" align="center">
<!-- Shows the page numbers -->
<?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
<!-- Shows the next and previous links -->
<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
<!-- prints X of Y, where X is current page and Y is number of pages -->
<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
 </TD>
</tr>							 	
</table>





<!-- View Message Start -->
<div id="open_message" class="table_format" width="60%">
<div class="email_format">
<table><tr><td></td></tr></table>
<!-- 
<table ><tr><td class="class_td"><?php echo  __('Subject'); ?>:</td><td><div id="messageSubject"></div></td></tr></table>
<table><tr><td class="class_td1"><?php echo  __('From'); ?>:</td><td><div id="messageFrom"></div></td></tr></table>
<table><tr><td class="class_td2"><?php echo  __('To'); ?>:</td><td><div id="messageTo"></div></td></tr></table>
 -->
<table><tr><td><div id="messageBody" nowrap="nowrap"></div></td></tr></table>
</div>
</div>

<!-- View Message End -->


<!-- Forward Message Start -->

<div id="forward_message_text" class="table_format">
<div class="email_format">
<!-- <table><tr><td><span class="class_td"><?php echo  __('To'); ?>: </span><span id="to_forward"></span></td></tr></table> -->
<table><tr><td><span class="class_td" style="float:left"><?php echo  __('To'); ?>: </span>
<?php echo $this->Form->input('to_forward', array('multiple' => 'multiple','class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','div'=>false,'style'=>'width:150px; float:left;','options'=>array(),'empty'=>__('Please select'), 'id'=>'SelectRight','label' => false));
 ?>
<td valign="middle" class="tdLabel" id="boxSpace">
			 <input id="MoveRight" type="button" value=" >> " />
			</td>
			<td valign="middle" class="tdLabel" id="boxSpace">
			 <input id="MoveLeft" type="button" value=" << " />
			</td>
			<td>
<?php echo $this->Form->input('to_forward_new', array('multiple' => 'multiple','class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','div'=>false,'style'=>'width:150px; float:left;','options'=>array(), 'id'=>'SelectLeft','label' => false));
 ?>			
</td></tr></table>
<table><tr><td><span class="class_td"><?php echo  __('Subject'); ?>: </span>FW: <span id="subject_forward"></span></td></tr></table>
<table><tr><td>
<?php echo $this->Form->textarea('message_forward', array('class' => '','id' => 'message_forward','rows'=>'15','cols'=>'100', "style"=>"width:700px")); ?>
</td></tr></table>
<table><tr><td>
<?php echo $this->Form->hidden('is_ammendment',array('value'=>'0','id' => 'is_reply_ammendment'));?>
<input class="blueBtn" type=hidden value="<?php echo $to_type ?>" name="to_type" id="to_type">
<input class="blueBtn" type=button value="Send" name="Send" id="sendForward">
<input class="blueBtn" type=button value="Close" name="close_forward" id="closeForward"></td></tr></table>
</div>
</div>
<?php     ?>
<!-- Forward Message End -->
<?php //echo '<pre>';print_r(explode("app/", $_SERVER['SCRIPT_NAME']));exit;?>
<?php $root_name = explode("app/", $_SERVER['SCRIPT_NAME']);//print_r($_SERVER['SERVER_NAME']);exit;?>
<script>
var getMessageUrl = "<?php echo $this->Html->url(array("controller" => "Hl7TextMessages", "action" => "openOutboxMessage","admin" => false)); ?>";
var getforwardOutboxUrl = "<?php echo $this->Html->url(array("controller" => "messages", "action" => "forwardOutbox","admin" => false)); ?>";
var getUserUrl = "<?php echo $this->Html->url(array("controller" => "messages", "action" => "getUsers","admin" => false)); ?>";
var lastMessageId;
var replyToId='';
var replyFromId='';
var replyFromName = '';
var replyToName = '';
var replyAmmendment = '0';
var to_type = '';
var server_path="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$root_name[0].'js/fckeditor/' ?>";
var hashKey = "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad";

function openMessage(messageId,isPatient){
	lastMessageId=messageId;
	$('#open_message').hide();
	$('#reply_message_text').hide();
	$('#forward_message_text').hide();
	$.ajax({
		type: 'POST',
		url: getMessageUrl,
		data: 'messageId='+messageId + '&isPatient='+isPatient,
		dataType: 'html',
		success: function(message){
			message = JSON && JSON.parse(message) || $.parseJSON(message);
			//alert(message.Outbox.from);
			/*$('#messageSubject').html(message.Outbox.subject);
			$('#messageFrom').html(message.Outbox.from_name);
			$('#messageTo').html(message.Outbox.to_name);
			$('#messageBody').html(message.Outbox.message);
			*/
			//var sub = CryptoJS.AES.decrypt(message.Outbox.subject, hashKey);
			

			
			$('#messageSubject').html(message.Hl7Message.subject);
			$('#messageFrom').html(message.Hl7Message.from_name);
			$('#messageTo').html(message.Hl7Message.to_name);
			$('#messageBody').html(message.Hl7Message.message);
			
				
			$('#from_'+messageId).removeClass('is_read');
			$('#subject_'+messageId).removeClass('is_read');
			$('#message_'+messageId).removeClass('is_read');
			$('#time_'+messageId).removeClass('is_read');
			$('#open_message').show();
			
		},
		error: function(message){
			alert('Unable to open message');
		} 
	});
}

function forwardInbox(){
	var originalForwardMessage = '<p>';
	originalForwardMessage += 'From: ' + $('#messageFrom').html() + '</p><p>';
	originalForwardMessage += 'To: ' + $('#messageTo').html() + '</p><p>';
	originalForwardMessage += 'Subject: ' + $('#messageSubject').html() + '</p><p>';
	originalForwardMessage += 'Message: ' + $('#messageBody').html() + '</p>';
	originalForwardMessage=originalForwardMessage.replace("<br>","");
	
	originalForwardMessage += 'Action: ' + $('#callPatient').html() + '</p><p>';
	originalForwardMessage += 'Action: ' + $('#collectBalance').html() + '</p><p>';
	originalForwardMessage += 'Action: ' + $('#createPortalLogin').html() + '</p><p>';
	originalForwardMessage += 'Due In Days: ' + $('#dueInDays').html() + '</p><p>';
	originalForwardMessage += 'Reference Patient: ' + $('#referencePatient').html() + '</p><p>';
	
	if(typeof(FCKeditorAPI !== undefined)){
		var Editor2 = FCKeditorAPI.GetInstance('message_forward');
	    Editor2.SetHTML(originalForwardMessage);
	}
	
	$.ajax({
		type: 'POST',
		url: getUserUrl,
		data: 'to_type=' + $('#to_type').val(),
		dataType: 'html',
		success: function(data){
			var options = createDropDown(data);
			$('#SelectRight').html(options);
			$('#open_message').hide();
			$('#forward_message_text').show();
			//$('#to_forward').html($('#messageFrom').html());
			$('#subject_forward').html($('#messageSubject').html());
			//$('#message_forward').val(originalForwardMessage);
			$('#message_forward:enabled:visible:first').focus();
		},
		error: function(message){
		//
		} 
	});
}

function createDropDown(data){
 	var options = '';
 	data = JSON && JSON.parse(data) || $.parseJSON(data);
	$.each(data, function(index, name) {
		//index = index.replace('"',''); alert(index);
	    options += '<option value=' + index + '>' + name + '</option>';
	  });
	return options;
}

	$(document).ready(function(){
		
		var oFCKeditor1 = new FCKeditor('message_forward') ;
		oFCKeditor1.BasePath = server_path ;
		oFCKeditor1.Height = "300" ; 
		oFCKeditor1.Width = "900";
		oFCKeditor1.ReplaceTextarea() ;
		
		$(document).ajaxStart(function () {
		    $("#temp-busy-indicator").show();
		});

		$(document).ajaxComplete(function () {
		    $("#temp-busy-indicator").hide();
		});
		
		$("#sendForward").click(function() {
			var Editor1 = FCKeditorAPI.GetInstance('message_forward');
		    var for_message = Editor1.GetHTML();
		    
		    for_message = for_message.replace(/^\s+|\s+$/g,'');
		    
		    //var for_subject = CryptoJS.AES.encrypt($('#messageSubject').html(), hashKey);
			var for_message = CryptoJS.AES.encrypt(for_message, hashKey);
			for_message = for_message.toString();
		    Editor1.SetHTML(for_message);
		    
			$.ajax({
				type: 'POST',
				url: getforwardOutboxUrl,
				data: 'to='+$('#SelectLeft').val()  + '&from='+replyToId + '&message='+ for_message + '&subject='+ $('#messageSubject').html()
							+ '&to_name=' + replyToName + '&from_name=' + replyFromName + '&is_ammendment=' + replyAmmendment,
				dataType: 'html',
				success: function(message){
					$('#message_error').html("Message sent succssfully");
					$('#open_message').hide();
					$('#forward_message_text').hide();
				},
				error: function(message){
					$('#message_error').html("Unable to send message");
				} 
			});
		});
		
	$("#closeForward").click(function() {
		$('#open_message').hide();
		$('#forward_message_text').hide();
	});
});
	$(function() {
	    $("#MoveRight,#MoveLeft").click(function(event) {
	    	
	        var id = $(event.target).attr("id");//MoveRight
	        var selectFrom = id == "MoveRight" ? "#SelectRight" : "#SelectLeft";//#selectLeft
	        var moveTo = id == "MoveRight" ? "#SelectLeft" : "#SelectRight";//#selectRight
	    
	        var selectedItems = $(selectFrom + " :selected").toArray();//empty
	        //var selectedItems="pankaj";
	       
	        $(moveTo).append(selectedItems);
	        selectedItems.remove;
	    });
	});
</script>