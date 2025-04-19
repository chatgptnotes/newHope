<style>
.highlight {
    background-color: #FFFFCC;
}
</style>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="float: left;">
	<tr>
		<td style="padding-left:10px;" width="100px">
			<?php echo $this->Html->link(__('Back to Inbox'), array('action' => 'inbox'), array('escape' => false,'label'=>false));?>
		</td>
	 <td style="padding-left:10px" width="9%">
	     
			<?php echo $this->Form->input('',array('type'=>'checkbox','id'=>'all','label'=>false,'div'=>false)); ?>
			<?php echo __('Select All');?>
		</td> 

		<td height="32px" style="padding-left:10px;">
			<?php echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','div'=>false,'id'=>'delete_click')); ?>
		</td>
	</tr>
</table>

<?php echo $this->Form->create('Inbox',array('id'=>'inbox_form'));?>
<div id="inbox_messages" style="clear: both">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" bgcolor="#F5F5F5">
		<thead>
			<tr>
				<td height="32px" valign="middle" style="background-color: #404040; color: #ffffff; >
					<div style="padding-left: 10px; padding-bottom: 3px;">
						<strong>Inbox</strong>
					</div>
				</td>
			</tr>
		</thead>

		<tbody>
			<?php if(count($messages) > 0) { ?>
			<tr>
				<td style="padding: 0px;">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="padding-left: 10px; padding-bottom: 3px;"><strong>Action</strong></td>
						<td style="padding-left: 10px; padding-bottom: 3px;"><strong>Type</strong></td>
						<td style="padding-left: 10px; padding-bottom: 3px;"><strong>From</strong></td>
						<td style="padding-left: 10px; padding-bottom: 3px;"><strong>Subject</strong></td>
						<?php if(strtolower($this->Session->read('role'))=='patient'){?>
						<td style="padding-left: 10px; padding-bottom: 3px;"><strong>Amendment Status</strong></td>
						<?php }?>
						<td align="center" style="padding-left: 10px; padding-bottom: 3px;"><strong>Date</strong></td>
					</tr>
						<?php 
								foreach($messages as $key=>$message){
								$messageId = $message['Inbox']['id'];
								$is_refill = $message['Inbox']['is_refill'];
								$isPatient = $message['Inbox']['is_patient'];
								//$message['Inbox']['message'] = str_replace(" ", "+", $message['Inbox']['message']);
								if($message['Inbox']['is_read'] == 0){
									$col = "col"; //calling class for white Background to unread messages
								}else{
									$col = "";
								}
						?>
						<tr class="ho <?php echo $col;?>">
							<td style="border-bottom: 1px solid #cfcfcf; padding: 5px;" width="3%">
								<?php echo $this->Form->input('',array('type'=>'checkbox','class'=>'chk','id'=>'chk_'.$key,'label'=>false,'div'=>false/*,'onclick'=>"change(this);"*/,'name'=>"data[message][$messageId]")); ?>
							</td>

							<td style="border-bottom: 1px solid #cfcfcf; padding: 10px 5px;"
								width="7%" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>','<?php echo $is_refill;?>')">
								<?php echo $message['Inbox']['type']; ?>
							</td>


							<td style="border-bottom: 1px solid #cfcfcf; padding: 10px 5px;"
								id="from_<?php echo $messageId;?>"
								width="13%"
							onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>','<?php echo $is_refill;?>')">
								From: <?php echo $message['Inbox']['from_name']; ?>
							</td>

							<td style="border-bottom: 1px solid #cfcfcf; padding: 10px 5px;" id="subject_<?php echo $messageId;?>"
								width="40%"
								onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>','<?php echo $is_refill;?>')">
								<?php echo $message['Inbox']['subject']; ?>
								<font color="#777777"> -
								<?php 
									$dec_message = $this->GibberishAES->dec($message['Inbox']['message'],Configure::read('hashKey'));
									if(strlen($dec_message) > 200) 
										echo strip_tags(substr($dec_message, 0, 200)).'...';
									else
										echo strip_tags(substr($dec_message, 0, 200)).'...';
								?>
								</font>
							</td>
							<?php if(strtolower($this->Session->read('role'))=='patient'){?>
							<td style="border-bottom: 1px solid #cfcfcf; padding: 10px 5px;" id="from_<?php echo $messageId;?>" width="13%">
							<?php 
								if($message['Inbox']['ammendment_status']=='is_accepted'){
									echo $this->Html->image('icons/tick.png',array('title'=>'Ammendment Status Accepted','alt'=>'Ammendment Status Accepted','escape' => false,'style'=>'float:left;padding: 4px 0 0 17px;'));
								}else if($message['Inbox']['ammendment_status']=='is_denied'){
									echo $this->Html->image('icons/cross.png',array('title'=>'Ammendment Status Denied','alt'=>'Ammendment Status Denied','escape' => false,'style'=>'float:left;padding: 4px 0 0 17px;'));
								}
							?>
							</td>
							<?php }?>
							<td align="right"
								style="border-bottom: 1px solid #cfcfcf; padding-right: 10px;" id="subject_<?php echo $messageId;?>"
								width="13%"
								onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')">
								<?php echo $this->DateFormat->formatDate2LocalForReport($message['Inbox']['create_time'],Configure::read('date_format'),true); ?>
							</td>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>

			<tr>
				<td align="center"> 
				
					<?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#inbox',    												
							'complete' => "onCompleteRequest('formFull','class');",
			    		 	'before' => "loading('formFull','class');"), null, array('class' => 'paginator_links'));  ?>
			    	<span class="paginator_links">
			    		<?php  echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
					</span>
					<?php  echo $this->Paginator->next(__('Next »', true), array('update'=>'#inbox',    												
							'complete' => "onCompleteRequest('formFull','class');",
			    		 	'before' => "loading('formFull','class');"), null, array('class' => 'paginator_links'));  
					
						 echo $this->Js->writeBuffer();
					?>
				</td>
		</tr>
			<?php } else { ?>
			<tr>
				<td align="center">No messages in Inbox</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php echo $this->Form->end();?>


<script>
$("#delete_click").click(function()
{
	var form_value = $("#inbox_form").serialize();

	$.ajax({
		url: '<?php echo $this->Html->url(array('controller'=>'Messages','action'=>'delete_inbox'));?>',
		data: form_value,
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success:function(data){
			$("#inbox").html(data).fadeIn('slow');
			$('#busy-indicator').hide();
		}
	});
});

$('.chk').bind('change click', function () {
    $(this).closest('tr').toggleClass('highlight', this.checked);
}).change();


$(document).ready(function() {
    $('#all').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.chk').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.chk').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
});

/*function change(the_element) {
	if(the_element.parentNode.parentNode.style.backgroundColor != '#FFFFCC') {
		the_element.parentNode.parentNode.style.backgroundColor = '#FFFFCC';
	} else {
		the_element.parentNode.parentNode.style.backgroundColor = '#ffe';
	}
}*/
	
</script>