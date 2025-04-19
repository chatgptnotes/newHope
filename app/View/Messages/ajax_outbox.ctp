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
<?php echo $this->Form->create('Inbox',array('id'=>'outbox_form'));?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" bgcolor="#F5F5F5" style="float: left;">
	<thead>
		<tr>
			<td height="32px" valign="middle" style="background-color: #404040; color:#ffffff;">
				<div style="padding-left:10px; padding-bottom: 3px;">
					<strong>OutBox</strong>
				</div>
			</td>
		</tr>
	</thead>

	<tbody>
		<?php if(count($messages) > 0) { ?>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<?php foreach($messages as $key=>$message){ ?>
				<?php $messageId = $message['Outbox']['id'];
					  $isPatient = $message['Outbox']['is_patient'];
					  $message['Outbox']['message'] = str_replace(" ", "+", $message['Outbox']['message']);
					  
					  if($message['Outbox']['is_read'] == 0){
					  		$col = "col";	//calling class for white vackground to unread messages
					  	}else{
							$col = "";
						}
				?>
					<tr class="ho <?php echo $col;?>" id="row<?php echo $messageId; ?>" >
						<td style="border-bottom:1px solid #cfcfcf; padding: 5px;" width="3%">
							<?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'class'=>'chk','id'=>'chk_'.$key,'div'=>false/*,'onclick'=>"change(this);"*/,'name'=>"data[messageId][$messageId]")); ?>
						</td>

						<td width="7%" style="border-bottom:1px solid #cfcfcf; padding: 10px 5px;" width="50px" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')">
							<?php echo $message['Outbox']['type']; ?>
						</td>	

						<td width="13%" style="border-bottom:1px solid #cfcfcf; padding: 5px 5px; " width="210px" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')">
							To: <?php echo $message['Outbox']['to_name']; ?>
						</td>

						<td width="40%" style="border-bottom:1px solid #cfcfcf; padding: 5px 5px;" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')">
						<?php echo $message['Outbox']['subject']; ?>
							<font color="#777777"> -
								<?php 
								$dec_message = $this->GibberishAES->dec($message['Outbox']['message'],Configure::read('hashKey'));
									if(strlen($dec_message) > 250) 
										echo strip_tags(substr($dec_message, 0, 250)).'...';
									else
										echo strip_tags($dec_message);
							 	?>
							</font>
							</td>

						<td width="13%" align="right" style="border-bottom:1px solid #cfcfcf; padding: 5px 10px; " width="80px" onclick="openMessage('<?php echo $messageId; ?>','<?php echo $isPatient; ?>')">
						<?php echo $this->DateFormat->formatDate2Local($message['Outbox']['create_time'],Configure::read('date_format'),true); ?>
						</td>
					</tr>
				<?php } ?>
				</table>
			</td>
		</tr>
		
		<tr>
			<td align="center"> 
			
				<?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#outbox_messages',    												
						'complete' => "onCompleteRequest('formFull','class');",
		    		 	'before' => "loading('formFull','class');"), null, array('class' => 'paginator_links'));  ?>
		    	<span class="paginator_links">
		    		<?php  echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
				</span>
				<?php  echo $this->Paginator->next(__('Next »', true), array('update'=>'#outbox_messages',    												
						'complete' => "onCompleteRequest('formFull','class');",
		    		 	'before' => "loading('formFull','class');"), null, array('class' => 'paginator_links'));  
				
					 echo $this->Js->writeBuffer();
				?>
			</td>
		</tr>
		<?php } else { ?>
		<tr>
			<td align="center">
				No messages in Outbox
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php echo $this->Form->end();?>


<script>
	$("#delete_click").click(function()
		{
			var form_value = $("#outbox_form").serialize();

			$.ajax({
				url: '<?php echo $this->Html->url(array('controller'=>'Messages','action'=>'delete_outbox'));?>',
				data: form_value,
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success:function(data){
					$("#outbox_messages").html(data);
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