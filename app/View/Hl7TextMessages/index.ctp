<script type="text/javascript">
  //var timeout = setTimeout("location.reload(true);",60000);
</script>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
<script>
    var encrypted = CryptoJS.AES.encrypt("First Message", "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad");

    //alert(encrypted); // {"ct":"tZ4MsEnfbcDOwqau68aOrQ==","iv":"8a8c8fd8fe33743d3638737ea4a00698","s":"ba06373c8f57179c"}

    var decrypted = CryptoJS.AES.decrypt(encrypted, "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad");
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
#open_message{
display:none;
}
#reply_message_text{
display:none;
}
#forward_message_text{
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
	<h3><?php echo __('Inbox') ?></h3>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"Laboratories","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span>
</div>
<div align="center" id='temp-busy-indicator' style="display: none;">
&nbsp;
<?php echo $this->Html->image('indicator.gif', array()); ?>
</div>
 
<ul class="interIcons"> 

	<!-- <li> <?php echo  $this->Html->link($this->Html->image('/img/icons/compose inner.png', array('alt' => 'Compose')),array("controller" => "Hl7TextMessages", "action" => "compose",$u_id,'plugin' => false), array('escape' => false,'label'=>'Compose')); ?></li> -->
	<!-- <li> <?php echo  $this->Html->link($this->Html->image('/img/icons/outbox inner.png', array('alt' => 'Outbox')),array("controller" => "Hl7TextMessages", "action" => "outbox",'plugin' => false), array('escape' => false,'label'=>'Outbox')); ?></li>
	<li> <?php echo  $this->Html->link($this->Html->image('/img/icons/laboratory.png', array('alt' => 'Result')),array("controller" => "laboratories", "action" => "hlseven",'plugin' => false), array('escape' => false,'label'=>'Result')); ?></li> -->
	<!--laboratory.png <li> <?php echo  $this->Html->link($this->Html->image('/img/icons/change password inner 1.png', array('alt' => 'Change Password')),array("controller" => "messages", "action" => "changepassword",'plugin' => false), array('escape' => false,'label'=>'Change Password')); ?></li>-->
	 
</ul> 
 
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
<tr class="row_title">
	<td class="table_cell"><strong><?php echo __('Patient Id') ?> </strong></td>
   <td class="table_cell"><strong><?php echo __('Message') ?> </strong></td>
   <td class="table_cell"><strong><?php echo __('Doctor Name') ?> </strong></td>
   <td class="table_cell"><strong><?php echo __('Time') ?> </strong></td>
</tr>
<?php
$toggle =0;
if(count($messages) > 0) {
	foreach($messages as $message){
if($toggle == 0) {
	echo "<tr class='row_gray'>";
	$toggle = 1;
}else{
	echo "<tr>";
	$toggle = 0;
}
$messageId = $message['AmbulatoryResult']['id'];

$isPatient = $message['AmbulatoryResult']['is_patient'];
//$isRead = $message['AmbulatoryResult']['is_read'];
$message['AmbulatoryResult']['message'] = str_replace(" ", "+", $message['AmbulatoryResult']['message']);	
//$message['AmbulatoryResult']['subject'] = str_replace(" ", "+", $message['AmbulatoryResult']['subject']);	
if($message['AmbulatoryResult']['is_read'] == 0){?>
<td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['AmbulatoryResult']['uid']; ?></a></td>
   <td class="row_format is_read" id="subject_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php 
   echo substr($message['AmbulatoryResult']['message'], 0, 40);
   //echo $message['AmbulatoryResult']['message']; ?></a> </td>
   <td class="row_format is_read" id="subject_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['AmbulatoryResult']['from']; ?></a> </td>
   <td class="row_format is_read" id="time_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo 
                   	  	  	$this->DateFormat->formatDate2Local($message['AmbulatoryResult']['create_time'],'mm/dd/yyyy',true); ?></a></td>
<?php }else{ ?>

<td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['AmbulatoryResult']['uid']; ?></a></td>
   <td class="row_format is_read" id="subject_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php 
   echo substr($message['AmbulatoryResult']['message'], 0, 40);
   //echo $message['AmbulatoryResult']['message']; ?></a> </td>
   <td class="row_format is_read" id="subject_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo $message['AmbulatoryResult']['from']; ?></a> </td>
   <td class="row_format is_read" id="time_<?php echo $messageId;?>"><a href="#" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')"><?php echo 
                   	  	  	$this->DateFormat->formatDate2Local($message['AmbulatoryResult']['create_time'],'mm/dd/yyyy',true); ?></a></td>
  
   </tr>
   
<?php 
}
} 
}else{
//echo __('No Records Found');	
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
<!-- <table ><tr><td class="class_td"><?php echo  __('Subject'); ?>:</td><td><div id="messageSubject"></div></td></tr></table>
<table><tr><td class="class_td1"><?php echo  __('From'); ?>:</td><td><div id="messageFrom"></div></td></tr></table>
<table><tr><td class="class_td2"><?php echo  __('To'); ?>:</td><td><div id="messageTo"></div></td></tr></table>
 -->
<table><tr><td><div id="messageBody" nowrap="nowrap"></div></td></tr></table>
</div>
</div>
<!-- View Message End -->


<!-- Reply Message Start -->

<div id="reply_message_text" class="table_format">
<div class="email_format">
<table><tr><td><span class="class_td"><?php echo  __('To'); ?>: </span><span id="to"></span></td></tr></table>
<table><tr><td><span class="class_td"><?php echo  __('Subject'); ?>: </span><span id="subject"></span></td><td><span id="show_medics_ammend" style="display:none"><?php echo $this->Form->radio('ammendment_status', array('is_accepted'=>'Accept','is_denied'=>'Deny'), array(
    'legend' => false
)); ?></span></td></tr></table>

<table  id="show_reason" style="display:none;"><tr><td><span class="class_td"><?php echo  __('Reason'); ?>: </span><?php echo $this->Form->input('reason', array('type'=>'text','id' => 'reason','label'=>false,'div'=>false)); ?></td></tr></table>

<table width="100%"><tr><td>
<?php echo $this->Form->textarea('reply_message', array('class' => '','id' => 'reply_message','rows'=>'15','cols'=>'100', "style"=>"width:700px")); 
		//echo $this->Fck->fckeditor(array('AmbulatoryResult','reply_message'), $this->Html->base,'','100%','400'); 
?>
</td></tr></table>
<table><tr><td>
<?php echo $this->Form->hidden('is_ammendment',array('value'=>'0','id' => 'is_reply_ammendment'));?>
<input class="blueBtn" type=button value="Send" name="Send" id="sendReply">
<input class="blueBtn" type=button value="Close" name="close_reply" id="closeReply"></td></tr></table>
</div>
</div>

<!-- Reply Message End -->


<!-- Forward Message Start -->

<div id="forward_message_text" class="table_format">
<div class="email_format">
<!--  <table><tr><td><span class="class_td"><?php echo  __('To'); ?>: </span><span ></span></td></tr></table>-->
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
<table width="100%"><tr><td>
<?php echo $this->Form->textarea('message_forward', array('class' => '','id' => 'message_forward','rows'=>'15','cols'=>'100', "style"=>"width:700px")); 
		//echo $this->Fck->fckeditor(array('AmbulatoryResult','message_forward'), $this->Html->base,'','100%','400'); 
?>
</td></tr></table>
<table><tr><td>
<input class="blueBtn" type=hidden value="<?php echo $to_type ?>" name="to_type" id="to_type">
<input class="blueBtn" type=button value="Send" name="Send" id="sendForward">
<input class="blueBtn" type=button value="Close" name="close_forward" id="closeForward"></td></tr></table>
</div>
</div>

<!-- Forward Message End -->
<?php $root_name = explode("app/", $_SERVER['SCRIPT_NAME']);?>
<script>
var getMessageUrl = "<?php echo $this->Html->url(array("controller" => "Hl7TextMessages", "action" => "openMessage","admin" => false)); ?>";
var getreplyInboxUrl = "<?php echo $this->Html->url(array("controller" => "messages", "action" => "replyInbox","admin" => false)); ?>";
var getforwardInboxUrl = "<?php echo $this->Html->url(array("controller" => "messages", "action" => "forwardInbox","admin" => false)); ?>";
var getUserUrl = "<?php echo $this->Html->url(array("controller" => "messages", "action" => "getUsers","admin" => false)); ?>";
var hashKey = "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad";
var lastMessageId;
var replyToId='';
var replyFromId='';
var replyFromName = '';
var replyToName = '';
var replyAmmendment = '0';
var to_type = '';
var server_path="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$root_name[0].'js/fckeditor/' ?>";
var is_patient='';
function openMessage(messageId,isPatient){
	lastMessageId=messageId;
	is_patient=isPatient;
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
			//alert(message.Inbox.from);
			//var sub = CryptoJS.AES.decrypt(message.Inbox.subject, hashKey);
			//var mess = CryptoJS.AES.decrypt(message.AmbulatoryResult.message, hashKey);
			
			$('#messageSubject').html(message.AmbulatoryResult.subject);
			$('#messageFrom').html(message.AmbulatoryResult.from_name);
			$('#messageTo').html(message.AmbulatoryResult.to_name);
			$('#messageBody').html(message.AmbulatoryResult.message);
			
			
			
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

function replyInbox(){
	var originalReplyMessage = '<p>';
	originalReplyMessage += 'From: ' + $('#messageFrom').html() + '</p><p>';
	originalReplyMessage += 'To: ' + $('#messageTo').html() + '</p><p>';
	originalReplyMessage += 'Subject: ' + $('#messageSubject').html() + '</p><p>';
	originalReplyMessage += 'Message: ' + $('#messageBody').html() + '</p><p>';
	
	originalReplyMessage += 'Action: ' + $('#callPatient').html() + '</p><p>';
	originalReplyMessage += 'Action: ' + $('#collectBalance').html() + '</p><p>';
	originalReplyMessage += 'Action: ' + $('#createPortalLogin').html() + '</p><p>';
	originalReplyMessage += 'Due In Days: ' + $('#dueInDays').html() + '</p><p>';
	originalReplyMessage += 'Reference Patient: ' + $('#referencePatient').html() + '</p><p>';
	//show_medics_ammend
	
	if(is_patient == ''){
		$('#show_medics_ammend').show();
	}
	originalReplyMessage=originalReplyMessage.replace("<br>",""); 
	$('#open_message').hide();
	$('#reply_message_text').show();
	$('#to').html($('#messageFrom').html());
	$('#subject').html($('#messageSubject').html());
	$('#is_reply_ammendment').val(replyAmmendment);
	
	//$('#reply_message').val(originalReplyMessage);
	var Editor1 = FCKeditorAPI.GetInstance('reply_message');
    Editor1.SetHTML(originalReplyMessage);
    $('#reply_message:enabled:visible:first').focus();
	
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
	
	var Editor2 = FCKeditorAPI.GetInstance('message_forward');
    Editor2.SetHTML(originalForwardMessage);
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
	
	var oFCKeditor = new FCKeditor( 'reply_message' ) ;
	oFCKeditor.BasePath = server_path;
	oFCKeditor.Height = "300" ; 
	oFCKeditor.Width = "900";
	oFCKeditor.ReplaceTextarea() ;
	
	var oFCKeditor1 = new FCKeditor( 'message_forward' ) ;
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
	
	
	$("#sendReply").click(function() {
		var Editor1 = FCKeditorAPI.GetInstance('reply_message');
	    var rep_message = Editor1.GetHTML();
	    rep_message = rep_message.replace(/^\s+|\s+$/g,'');
	    //var rep_subject = CryptoJS.AES.encrypt($('#messageSubject').html(), hashKey);
		var rep_message = CryptoJS.AES.encrypt(rep_message, hashKey);
		rep_message = rep_message.toString();
	    Editor1.SetHTML(rep_message);
	    //$('#message_enc').val(mess);//$("input[name=data[ammendment_status]]"
	    //alert($("input[name='data[ammendment_status]']:checked").val());
	    
		$.ajax({
			type: 'POST',
			url: getreplyInboxUrl,
			data: 'to='+replyFromId + '&from='+replyToId + '&message='+ rep_message + '&subject='+ $('#messageSubject').html()//reason
						+ '&to_name=' + replyToName + '&from_name=' + replyFromName + '&is_ammendment=' + replyAmmendment + '&ammendment_status=' + $("input[name='data[ammendment_status]']:checked").val()
						 + '&reason=' + $("#reason").val(),
			dataType: 'html',
			success: function(message){
				$('#message_error').html("Message sent succssfully");
				$('#open_message').hide();
				$('#reply_message_text').hide();
			},
			error: function(message){
				$('#message_error').html("Unable to send message");
			} 
		});
	});
	
	$("#sendForward").click(function() {
		var Editor1 = FCKeditorAPI.GetInstance('message_forward');
	    var for_message = Editor1.GetHTML();
	    
	    for_message = for_message.replace(/^\s+|\s+$/g,'');
	    
	    //var rep_subject = CryptoJS.AES.encrypt($('#subject_forward').html(), hashKey);
		var for_message = CryptoJS.AES.encrypt(for_message, hashKey);
		for_message = for_message.toString();
	    Editor1.SetHTML(for_message);
	    
		$.ajax({
			type: 'POST',
			url: getforwardInboxUrl,
			data: 'to='+$('#SelectLeft').val() + '&from='+replyToId + '&message='+ for_message + '&subject='+ $('#subject_forward').html()
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
	
	$("#closeReply").click(function() {
		$('#open_message').hide();
		$('#reply_message_text').hide();
	});

	$("#AmmendmentStatusIsDenied").click(function() {
		$('#show_reason').show();
	});

	$("#AmmendmentStatusIsAccepted").click(function() {
		$('#show_reason').hide();
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