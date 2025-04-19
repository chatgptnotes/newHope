<?php echo $this->Html->script(array('aes.js','jquery.blockUI'));?>
<script>
    var encrypted = CryptoJS.AES.encrypt("First Message", "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad");
    var decrypted = CryptoJS.AES.decrypt(encrypted, "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad");
</script>
<?php  echo $this->Html->script('fckeditor/fckeditor');  ?>

<style>
.is_read {
	font-weight: bold;
	font-size: 14px;
}
.col{
		background-color:#ffffff;
	}
.ho:hover{
		background-color:#ffe;
		cursor: pointer;
	}

#forward_message_text {
	display: none;
}

#open_message {
	display: none;
}

.class_td {
	font-size: 13px;
	font-weight: bold;
	/*background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;*/
	/*border-bottom: 1px solid #3E474A;*/
	color: #000;
	float: left;
}

.class_td1 {
	eight: bold;
	width: 53px;
	float: left;
}

.class_td2 {
	color: #000;
	font-size: 14px;
	font-weight: bold;
	width: 53px;
	float: left;
}


.table_format { /*border: 1px solid #3E474A;*/
	padding: 0px;
}

.email_format {
	border: 1px solid #d7d7d7;
}

.patient_infodiv {
	
}

.row_gray {
	background-color: #eee !important;
	border-bottom: 1px solid #e5e5e5 !important;
	padding: 0px !important;
}

.table_format a {
	padding: 0px !important;
}

.row_format {
	font-size: 12px;
	padding: 5px 0 !important;
}


/**
 * for left element1
 */
.table_first{
 	margin: -25px;
 	margin-bottom: -20px;
 	
}

.td_second{
	border-left-style:solid; 
	padding-left: 25px; 
	
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}
/* EOCode */

</style>

<div id="message_error" align="center"></div>


<div class="inner_title">
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Inbox'); ?>
	</h3>
</div>

<table width="100%"  cellspacing='0' cellpadding='0' style="margin-bottom: 20px;" >
	<tr>
		<td valign="top" width="5%" >	
			<div class="mailbox_div">
			
				<?php echo $this->element('mailbox_index');?>
			</div>
		</td>
		<td class="td_second" valign="top">
			<div id="inbox">
			
			</div>	

	<!-- View Message Start -->
<div id="open_message" style="clear:both; padding-top:10px;">
	<div class="email_format" style="padding:10px;">
		
		<table>
			<tr>
				<td>
					<a href="#" onclick="Reply()"><?php echo  __('Reply'); ?> </a>&nbsp;&nbsp;&nbsp;
				</td>
				
				<td>
					<div>
							<a href="#" onclick="forwardInbox()"><?php echo  __('Forward'); ?>
							<?php 
								echo $this->Form->hidden('messageForwardID',array('id'=>'messageForwardID')) ;
								echo $this->Form->hidden('isPatientForwardID',array('id'=>'isPatientForwardID')) ; 
								echo $this->Form->hidden('is_refill',array('id'=>'is_refill')) ;
							?>
							</a>&nbsp;&nbsp;&nbsp;
					</div>
				</td>
				<td>
					<!--  <a href="#" onclick="Conversation()"><?php echo  __('View Conversation'); 
					echo $this->Form->hidden('conversationID',array('id'=>'conversationID')) ;?> </a>-->
					<?php //echo $this->Html->link(__("View Conversation"),array('controller'=>'Messages','action'=>'conversation'));?>
				</td>
			</tr>
		</table>
		
		<table border="0" width="100%" cellpadding="0" cellspacing="0">  
			<tr>
				<td width="10%" height="40px" align="right" style="font-size: 14px; padding-right:10px;">
					<span id="isSubject" style="display: none">
						<font style=" color:#61BEB3;"><?php echo  __('Subject :'); ?></font>
					</span>
					<span id="isAmmendment" style="display: none">
						<font style=" color:#61BEB3;"><?php echo  __('Ammendment :'); ?></font>
					</span>
				</td>
				<td>
					<div id="messageSubject" style="font-size:12px"></div>
				</td>
			</tr>
	
			<tr>
				<td width="10%" height="40px" align="right" style="font-size: 14px; padding-right:10px;">
					<font style=" color:#61BEB3;"><?php echo  __('From'); ?> :</font>
				</td>
				<td height="32px"><div id="messageFrom" style="font-size:12px"></div></td>
			</tr>

			<tr>
				<td width="10%" height="40px" align="right" style="font-size: 14px; padding-right:10px;" valign="top">
				<font style=" color:#61BEB3;"><?php echo  __('Message'); ?> :</font>
				</td>
				<td><div id="messageBody" style="font-size:12px"></div></td>
			</tr>
			
			<!-- <tr>
				<td width="10%" height="40px" align="right" style="font-size: 14px; padding-right:10px;">
					<?php echo  __('Reference Patient'); ?>:
				</td>
				<td><div id="referencePatient" style="font-size:12px"></div></td>
			</tr> -->
		</table>
		
	<!-- View Message End -->




	<!-- Reply Message Start -->

	<div id="reply_message_text" class="table_format">
		<div class="email_format">
			<table>
				<tr>
					<td><span class="class_td"><?php echo  __('To'); ?>: </span><span
						id="to"></span></td>
				</tr>
			</table>
			<table>
				<tr>
					<td><span class="class_td"><?php echo  __('Subject'); ?>: </span><span
						id="subject"></span></td>
					<td><span id="show_medics_ammend" class="radio_label"
						,style="display: none"><?php echo $this->Form->radio('ammendment_status', array('is_accepted'=>'Accept','is_denied'=>'Deny'), array(
								'legend' => false,'label'=>false,
						)); ?> </span></td>
				</tr>
			</table>

			<table id="show_reason" style="display: none;">
				<tr>
					<td><span class="class_td"><?php echo  __('Reason'); ?>: </span> <?php echo $this->Form->input('reason', array('type'=>'text','id' => 'reason','label'=>false,'div'=>false)); ?>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td><?php echo $this->Form->textarea('reply_message', array('class' => '','id' => 'reply_message','rows'=>'15','cols'=>'100', "style"=>"width:700px")); 
					//echo $this->Fck->fckeditor(array('Inbox','reply_message'), $this->Html->base,'','100%','400');
					?>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><?php echo $this->Form->hidden('is_ammendment',array('value'=>'0','id' => 'is_reply_ammendment'));?>
						<input class="blueBtn" type=button value="Send" name="Send"
						id="sendReply"> <input class="blueBtn" type=button value="Close"
						name="close_reply" id="closeReply"></td>
				</tr>
			</table>
		</div>
	</div>

	<!-- Reply Message End -->


	<!-- Forward Message Start -->

	<div id="forward_message_text" class="table_format">
		<div class="email_format">
			<table>
				<tr>
					<td><span class="class_td" style="float: left"><?php echo  __('To'); ?>:
					</span> <?php echo $this->Form->input('to_forward', array('multiple' => 'multiple','class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','div'=>false,'style'=>'width:150px; float:left;height:70px','options'=>array(),'empty'=>__('Please select'), 'id'=>'SelectRight','label' => false));
					?>
							</td>
						</tr>
					</table>
					<table>
						<tr>
							<td><?php echo $this->Form->hidden('is_ammendment',array('value'=>'0','id' => 'is_reply_ammendment'));?>
								<input class="blueBtn" type=button value="Send" name="Send"
								id="sendReply"> <input class="blueBtn" type=button value="Close"
								name="close_reply" id="closeReply"></td>
						</tr>
					</table>
				</div>
			</div>
		
			<!-- Reply Message End -->
		
		
			<!-- Forward Message Start -->
		
			<div id="forward_message_text" class="table_format" >
				<div class="email_format">
					<!--  <table><tr><td><span class="class_td"><?php echo  __('To'); ?>: </span><span ></span></td></tr></table>-->
					<table>
						<tr>
							<td><span class="class_td" style="float: left"><?php echo  __('To'); ?>:
							</span> <?php echo $this->Form->input('to_forward', array('multiple' => 'multiple','class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','div'=>false,'style'=>'width:150px; float:left;height:70px','options'=>array(),'empty'=>__('Please select'), 'id'=>'SelectRight','label' => false));
							?>
							
							<td valign="middle" class="tdLabel" id="boxSpace"><input
								id="MoveRight" type="button" value=" >> " />
							</td>
							<td valign="middle" class="tdLabel" id="boxSpace"><input
								id="MoveLeft" type="button" value=" << " />
							</td>
							<td><?php echo $this->Form->input('to_forward_new', array('multiple' => 'multiple','class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','div'=>false,'style'=>'width:150px; float:left;height:70px;','options'=>array(), 'id'=>'SelectLeft','label' => false));
							?>
							</td>
						</tr>
					</table>
					<table>
						<tr>
							<td><span class="class_td"><?php echo  __('Subject'); ?>: </span>FW:
								<span id="subject_forward"></span></td>
						</tr>
					</table>
					<table width="100%">
						<tr>
							<td><?php echo $this->Form->textarea('message_forward', array('class' => '','id' => 'message_forward','rows'=>'15','cols'=>'100', "style"=>"width:700px")); 
							//echo $this->Fck->fckeditor(array('Inbox','message_forward'), $this->Html->base,'','100%','400');
							?>
							</td>
						</tr>
					</table>
					<table width="100%">
						<tr>
							<td><input class="blueBtn" type=hidden
								value="<?php echo $to_type ?>" name="to_type" id="to_type"> <input
								class="blueBtn" type=button value="Send" name="Send"
								id="sendForward"> <input class="blueBtn" type=button value="Close"
								name="close_forward" id="closeForward"></td>
								
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
</table>
			<!-- Forward Message End -->
<?php $root_name = explode("app/", $_SERVER['SCRIPT_NAME']);?>
	
	<script>
var getMessageUrl = "<?php echo $this->Html->url(array("controller" => "messages", "action" => "openMessage","admin" => false)); ?>";
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

function goToTop(){
	$("html, body").animate({ scrollBottom: $(document).height() }, "slow");
}
function openMessage(messageId,isPatient,is_refill){
	lastMessageId=messageId;
	is_patient=isPatient;
	is_refill=is_refill;
	$('#open_message').hide();
	$('#reply_message_text').hide();
	$('#forward_message_text').hide();
	$('#messageForwardID').val(messageId);
	$('#conversationID').val(messageId);
	$('#isPatientForwardID').val(isPatient);
	$('#is_refill').val(is_refill);
	$.ajax({
		type: 'POST',
		url: getMessageUrl,
		data: 'messageId='+messageId + '&isPatient='+isPatient,
		dataType: 'html',
		success: function(message){
			message = JSON && JSON.parse(message) || $.parseJSON(message);
			//alert(message.Inbox.from);
			//var sub = CryptoJS.AES.decrypt(message.Inbox.subject, hashKey);
			var mess = CryptoJS.AES.decrypt(message.Inbox.message, hashKey);
			if(message.Inbox.is_ammendment == '1'){
				$('#isAmmendment').show();
				$('#isSubject').hide();
			}else{
				$('#isSubject').show();
				$('#isAmmendment').hide();
			}
			$('#isSenderID').val(message.Inbox.from_name);
			$('#messageSubject').html(message.Inbox.subject);
			$('#messageFrom').html(message.Inbox.from_name);
			$('#messageTo').html(message.Inbox.to_name);
			$('#messageBody').html(mess.toString(CryptoJS.enc.Utf8));
			
			if(message.Inbox.call_patient == true){
				$('#callPatient').html('Call Patient');
			}
			if(message.Inbox.collect_balance == true){
				$('#collectBalance').html('Collect Balance');
			}
			if(message.Inbox.create_portal_login == true){
				$('#createPortalLogin').html('Create Portal Login');
			}
			$('#dueInDays').html(message.Inbox.due_in_days);
			$('#referencePatient').html(message.Inbox.reference_patient);
			
			$('#from_'+messageId).removeClass('is_read');
			$('#subject_'+messageId).removeClass('is_read');
			$('#message_'+messageId).removeClass('is_read');
			$('#time_'+messageId).removeClass('is_read');
			$("#inbox").hide();
			$('#open_message').show();
			replyToId = message.Inbox.to;
			replyFromId = message.Inbox.from;
			replyFromName = message.Inbox.from_name;
			replyToName = message.Inbox.to_name;
			replyAmmendment = message.Inbox.is_ammendment;
			//$("html, body").animate({ scrollTop: $(document).height() }, "slow");
			  return false;
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

	messageId= $("#messageForwardID").val();
	isPatient= $("#isPatientForwardID").val();
	is_refill= $("#is_refill").val();
	
	window.location.href = "<?php echo $this->Html->url(array('action'=>'compose_new','?'=>array('action'=>'inbox_forward'))) ; ?>"+"&messageID="+messageId+"&isPatient="+isPatient+"&is_refill="+is_refill ;

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
	
	
	/*$(document).ajaxStart(function () {
	    $("#temp-busy-indicator").show();
	});

	$(document).ajaxComplete(function () {
	    $("#temp-busy-indicator").hide();
	});
	*/
	
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


function Reply()
{
	messageId= $("#messageForwardID").val();
	isPatient= $("#isPatientForwardID").val();
	isSenderId = $('#isSenderID').val();//sender name
	is_refill= $("#is_refill").val();	
	
	//pass message_id and sender name
	window.location.href = "<?php echo $this->Html->url(array('action'=>'compose_new','?'=>array('action'=>'reply'))) ; ?>"+"&messageID="+messageId+"&isPatient="+isPatient+"&isSender="+isSenderId+"&is_refill="+is_refill ;
}

function Conversation()
{
	var messageId = $("#conversationID").val();
	window.location.href = "<?php echo $this->Html->url(array('action'=>'conversation'));?>"+"/"+messageId ;
}

$(document).ready(function(){ 

	$.ajax({
		url: '<?php echo $this->Html->url(array('controller'=>'Messages','action'=>'ajax_inbox'));?>',
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success:function(data){
			$("#inbox").html(data).fadeIn('slow');
			$('#busy-indicator').hide();
			//$("#inbox_messages").html(data);
		}
	});
});
	
</script>