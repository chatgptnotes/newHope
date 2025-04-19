<?php  echo $this->Html->script('fckeditor/fckeditor');

echo $this->Html->script(array('aes.js','jquery.blockUI'));?>

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
		<?php echo __('Outbox') ?>
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
			<div id="outbox_messages">
			
			</div>

<!-- View Message Start -->
<div id="open_message" style="clear:both;padding-top:10px;">
	<div class="email_format" style="padding:10px;">
		<table>
			<tr>
				<td>
					<a href="#" onclick="back()">Back</a>
				</td>
				<td>
					<a href="#" onclick="forwardInbox()"><?php echo  __('Forward'); ?> </a>  
					<?php 
						echo $this->Form->hidden('messageForwardID',array('id'=>'messageForwardID')) ;
						echo $this->Form->hidden('isPatientForwardID',array('id'=>'isPatientForwardID')) ;
					?>
				</td>
			</tr>
		</table>
		
		<table border="0" width="100%" cellpadding="0" cellspacing="0">  
			<tr>
				<td width="10%" height="40px" align="right" style="font-size: 14px; padding-right:10px;">
					<font style=" color:#61BEB3;"><?php echo  __('To'); ?>:</font>
				</td>
				<td>
					<div id="messageTo" style="font-size:12px"></div>
				</td>
			</tr>
	
			<tr>
				<td width="10%" height="40px" align="right" style="font-size: 14px; padding-right:10px;">
					<span id="isSubject" style="display: none; color:#61BEB3;"><?php echo  __('Subject'); ?></span>
					<span id="isAmmendment" style="display: none; color:#61BEB3;"> <?php echo  __('Ammendment'); ?>
					</span>:
				</td>
				<td height="32px"><div id="messageSubject" style="font-size:12px"></div></td>
			</tr>

			<!--<tr>
				<td width="10%" height="40px" align="right" style="font-size: 14px; padding-right:10px; ">
					<?php //echo  __('From'); ?>:
				</td>
				<td><div id="messageFrom" style="font-size:12px"></div></td>
			</tr> -->
			
			<tr>
				<td width="10%" height="40px" align="right" style="font-size: 14px; padding-right:10px;">
				<font style=" color:#61BEB3;"><?php echo  __('Message'); ?>:</font>
				</td>
				<td><div id="messageBody" style="font-size:12px"></div></td>
			</tr>
			
			<!--  <tr>
				<td width="10%" height="40px" align="right" style="font-size: 14px; padding-right:10px;">
					<font style=" color:#61BEB3;"><?php echo  __('Reference Patient'); ?>:</font>
				</td>
				<td><div id="referencePatient" style="font-size:12px"></div></td>
			</tr>-->
		</table>

	</div>
</div>

<!-- View Message End -->


<!-- Forward Message Start -->

<div id="forward_message_text" class="table_format">
	<div class="email_format">
		<table>
			<tr>
				<td class="class_td"><span id="isSubject" style="display: none"><?php echo  __('Subject'); ?>
				</span><span id="isAmmendment" style="display: none"> <?php echo  __('Ammendment'); ?>
				</span>:</td>
				<td><div id="messageSubject"></div></td>

				<td><span class="class_td" style="float: left"><?php echo  __('To'); ?>:
				</span> <?php echo $this->Form->input('to_forward', array('multiple' => 'multiple','class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','div'=>false,'style'=>'width:150px; float:left;height:70px;','options'=>array(),'empty'=>__('Please select'), 'id'=>'SelectRight','label' => false));
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
		<table>
			<tr>
				<td><?php echo $this->Form->textarea('message_forward', array('class' => '','id' => 'message_forward','rows'=>'15','cols'=>'100', "style"=>"width:700px")); ?>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td><?php echo $this->Form->hidden('is_ammendment',array('value'=>'0','id' => 'is_reply_ammendment'));?>
					<input class="blueBtn" type=hidden value="<?php echo $to_type ?>"
					name="to_type" id="to_type"> <input class="blueBtn" type=button
					value="Send" name="Send" id="sendForward"> <input class="blueBtn"
					type=button value="Close" name="close_forward" id="closeForward"></td>
			</tr>
		</table>
	</div>
</div>
</td>
</tr>
</table>

<?php $root_name = explode("app/", $_SERVER['SCRIPT_NAME']);//print_r($_SERVER['SERVER_NAME']);exit;?>


<script>
var getMessageUrl = "<?php echo $this->Html->url(array("controller" => "messages", "action" => "openOutboxMessage","admin" => false)); ?>";
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

function back(){
	//$("html, body").animate({ scrollBottom: $(document).height() }, "slow");
	$("#outbox_messages").show();
	$('#open_message').hide();
}

function openMessage(messageId,isPatient){
	lastMessageId=messageId;
	$('#open_message').hide();
	$('#reply_message_text').hide();
	$('#forward_message_text').hide();
	$('#messageForwardID').val(messageId);
	$('#isPatientForwardID').val(isPatient);
	$.ajax({
		type: 'POST',
		url: getMessageUrl,
		data: 'messageId='+messageId + '&isPatient='+isPatient,
		dataType: 'html',
		success: function(message){
			message = JSON && JSON.parse(message) || $.parseJSON(message);
			var mess = CryptoJS.AES.decrypt(message.Outbox.message, hashKey);
			if(message.Outbox.is_ammendment == '1'){
				$('#isAmmendment').show();
				$('#isSubject').hide();
			}else{
				$('#isSubject').show();
				$('#isAmmendment').hide();
			}
			
			$('#messageSubject').html(message.Outbox.subject);
			$('#messageFrom').html(message.Outbox.from_name);
			$('#messageTo').html(message.Outbox.to_name);
			$('#messageBody').html(mess.toString(CryptoJS.enc.Utf8));
			
			if(message.Outbox.call_patient == true){
				$('#callPatient').html('Call Patient');
			}
			if(message.Outbox.collect_balance == true){
				$('#collectBalance').html('Collect Balance');
			}
			if(message.Outbox.create_portal_login == true){
				$('#createPortalLogin').html('Create Portal Login');
			}
			$('#dueInDays').html(message.Outbox.due_in_days);
			$('#referencePatient').html(message.Outbox.reference_patient);
			
			$('#from_'+messageId).removeClass('is_read');
			$('#subject_'+messageId).removeClass('is_read');
			$('#message_'+messageId).removeClass('is_read');
			$('#time_'+messageId).removeClass('is_read');
			$("#outbox_messages").hide();
			$('#open_message').show();
			replyToId = message.Outbox.to;
			replyFromId = message.Outbox.from;
			replyFromName = message.Outbox.from_name;
			replyToName = message.Outbox.to_name;
			replyAmmendment = message.Outbox.is_ammendment;
			//$("html, body").animate({ scrollTop: $(document).height() }, "slow");
			  return false;
		},
		error: function(message){
			alert('Unable to open message');
		} 
	});
}

function forwardInbox(){ 
	 
	messageId= $("#messageForwardID").val();
	isPatient= $("#isPatientForwardID").val();
	
	window.location.href = "<?php echo $this->Html->url(array('action'=>'compose_new','?'=>array('action'=>'outbox_forward'))) ; ?>"+"&messageID="+messageId+"&isPatient="+isPatient  ;

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
		
		/*$(document).ajaxStart(function () {
		    $("#temp-busy-indicator").show();
		});

		$(document).ajaxComplete(function () {
		    $("#temp-busy-indicator").hide();
		});*/
		
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

	function change(the_element) {
		if(the_element.parentNode.parentNode.style.backgroundColor != '#FFFFCC') {
			the_element.parentNode.parentNode.style.backgroundColor = '#FFFFCC';
		} else {
			the_element.parentNode.parentNode.style.backgroundColor = '#ffe';
		}
	}

	$(document).ready(function(){ 

		$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'Messages','action'=>'ajax_outbox'));?>',
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success:function(data){
				$("#outbox_messages").html(data).fadeIn('slow');
				$('#busy-indicator').hide();
				//$("#inbox_messages").html(data);
			}
		});
	});

	
</script>
