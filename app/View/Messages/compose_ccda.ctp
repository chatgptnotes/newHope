<?php
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
	echo $this->Html->script(array('jquery.fancybox-1.3.4'));
	echo $this->Html->script('fckeditor/fckeditor');
	//echo $this->Html->script('ckeditor/ckeditor');
	  //echo $this->Html->script(array('aes.js'));   


?>
<style>
.mover {
	width: 20px;
}

.movel {
	width: 20px;
}

.select {
	width: 150px;
}

.tbl {
	border: 1px solid #3E474A;
	padding-bottom: 5px;
}

.t1 label {
	color: #E7EEEF;
	font-size: 13px;
	margin-right: 10px;
	padding-top: 7px;
	text-align: right;
	width: 97px;
}

.radio {
	margin-right: -300px;
}

.lblcls {
	float: inherit;
}

.btn {
	margin-right: 30px;
}

.hasDatepicker {
	/* width: 250px; */
}

.td_line{
	margin-top: -25px;
	margin-bottom: -31px;
}

.td_second{
	border-left-style:solid; 
	padding-left: 20px; 
	border-left-color: -moz-buttondefault;
	
}
.form-data{
    background-color: transparent;
    border: 1px solid;
    height: 25px;
    font-size: 14px;
}
.box{
	 width: 97%;
	
}
.drop{
	width: 20%;
}

</style>

<script>
/*var hashKey = "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad";
var encrypted = CryptoJS.AES.encrypt("Pawan", hashKey);//alert(encrypted);
*/
</script>
<?php echo $this->Form->create('XmlNote',array('url'=>array('controller'=>'messages','action'=>'composeCcda',$patient_id,'?'=>array('referred_to'=>$this->params->query['referred_to'],'returnUrl'=>$this->params->query['returnUrl'])),'type' => 'file','id'=>'composefrm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));

 ?>
 
<div class="inner_title" style="margin-bottom: 25px; ">
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Compose Consult'); ?>
	</h3>
</div>
 
<table width="100%"  cellspacing='0' cellpadding='0' class="td_line" style="margin-bottom: -20px;"> 
	<tr>
		<td valign="top" width="5%" class="mailbox_div" >
 
			<div class="mailbox_div">
				<?php echo $this->element('mailbox_index');?>
			</div>
			
		</td>
		<td class="td_second">
<!-- 			<div class="mailbox_div"> -->
				<?php //echo $this->element('referral_icon');?>
<!-- 			</div> -->
			<div class="">
			
<!-- 				<h3> -->
					<?php //echo __('Compose CCDA Message', true); ?>
<!-- 				</h3> -->
				<?php if(strtolower($role) != 'patient'){?>
				<span><?php //  echo $this->Html->link(__('Back to list'),array('action'=>'patientList'),array('escape'=>false,'class'=>'blueBtn')); ?>
				</span>
				<?php }else {?>
				<span><?php // echo $this->Html->link(__('Back to list'),array('action'=>'ccdaMessage'),array('escape'=>false,'class'=>'blueBtn')); ?>
				</span>
				<?php }?>
			</div>
			
		
			
 			
<table cellpadding="0" cellspacing="0" width="100%" class="formFull" style="margin-top:25px;">
	<tr>
		<td valign="middle" style="background-color: #404040; color:#ffffff;">
			<div style="padding-left:10px; padding-bottom: 3px;"><strong>Compose Consult</strong></div>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%" height="40px" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;"><?php echo __('Physician Name') ?></font>
						<font color="red">* </font>
						<font style=" color:#61BEB3;">:</font>
					</td>
					 
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
					<?php echo $this->Form->input('physician_name', array('type'=>'text','class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]',
							'value'=>$this->params->query['referred_to'], 'id'=>'query_refered_to' ,'style'=>'width:250px'));?>  
				
					</td>
				</tr>
 			<tr>
					<td width="15%" height="40px" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;"><?php echo __('Direct Email') ?></font>
						<font color="red">* </font>
						<font style=" color:#61BEB3;">:</font>
					</td>
					<?php 
					foreach( $emailAddress as $emails){
							$emailSend[]=$emails['User']['email'];
						  }
						  $emailSendTo=implode(',',$emailSend);
						  if(!empty($transmittedData['TransmittedCcda']['to'])){
						  	$emailSendTo  = $transmittedData['TransmittedCcda']['to'] ;
						  }
					?>
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
						<?php 
							echo $this->Form->input('to', array('class' => 'textBoxExpnd validate[required,custom[email]]','value'=>$emailSendTo, 'id'=>'to' ,'style'=>'width:250px'));
							echo $this->Form->hidden('noteId', array('value'=>$noteId,'name'=>'noteId'));
						?>
					</td>
				</tr>
				
				<tr>
					<td width="15%" height="40px" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;"><?php echo __('Referral To') ?> :</font>
					</td>
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
						<?php $referal_to= array('Specialist'=>'Specialist','Hospital'=>'Hospital','Caregiver'=>'Caregiver');
							echo $this->Form->input('referral_to', array('style'=>'width:150px; float:left;','options'=>$referal_to, 'id'=>'referal','class' => 'validate[required,custom[mandatory-select]] form-data drop')); ?>
					</td>
				</tr>
				
				
				<tr>
					<td width="15%" height="40px" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;"><?php echo __('Subject') ?></font>
						<font color="red">* </font>
						<font style=" color:#61BEB3;">:</font>
					</td>
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
						<table width="100%">
							<tr>
								<td>
									<?php echo $this->Form->input('subject', array('type'=>'text','style'=>'width:250px','value'=>$subjectVal,'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'subject')); ?>
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" name="order_referral" id="order_ref"/>Order to Referral/Consult
								</td>
							</tr>
						</table>
					</td>
				</tr> 
				<tr>
					<td colspan="2" height="40px" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<table width="100%">
							<tr>
								<td width="15%" height="40px" align="right"  >
									<font style=" color:#61BEB3;"><?php echo __('Name') ?> :</font>
								</td>
								<td style="padding-left: 10px;">
									<?php echo $patient_name; ?>
								</td>
						 
								<td width="15%" height="40px" align="right"  >
									<font style=" color:#61BEB3;"><?php echo __('Sex') ?> :</font>
								</td>
								<td style="padding-left: 10px;  ">
									<?php echo $patient_sex; ?>
								</td>
						 
								<td width="15%" height="40px" align="right"  >
									<font style=" color:#61BEB3;"><?php echo __('Age') ?> :</font>
								</td>
								<td  >
									<?php if( $patient_age  > '1'){
											$years='Years';
										  }else{
											$years='Year';
										  }
										echo $patient_age;
									?>
								</td>						
							</tr>
							<tr>
								<td width="15%" height="40px" align="right" style="font-size: 14px; ">
									<font style=" color:#61BEB3;"><?php echo __('Type') ?></font> <font color="red">*</font> <font style=" color:#61BEB3;">:</font>
								</td>
								<td style="padding-left: 10px; ">
									<?php echo $this->Form->hidden('patient_id',array('value'=>$patient_id,'id' => 'patient_id')); 
										if($this->params->query['type']=='reminder'){
											$typeVal = 'scnp' ; //set not CCDA type
											$subjectVal = 'Reminder to send Summary of care ' ;
											$dataFile = 'This is a reminder to send the summary of care for the patient named <b>'.$patient_name.'</b> who was referred by our clinic on ';
											$dataFile .= $this->DateFormat->formatDate2Local($transmittedData['TransmittedCcda']['created_on'],Configure::read('date_format'),false);
										} 	
										echo $this->Form->input('type', array('style'=>'width:265px; float:left;','options'=>array("ccda"=>"Summary of care",'other'=>'Other Mode(FAX)',
										'scnp'=>'Summary of care not provided'),'value'=>$typeVal, 'id'=>'type', 'class' => 'form-data drop')); ?>
								</td> 
								<td width="15%" height="40px" align="right" style="font-size: 14px; ">
									<font style=" color:#61BEB3;"><?php echo __('Date') ?></font>
										<font color="red">*</font>
										<font style=" color:#61BEB3;"> :</font>
								</td>
								<td style="padding-left: 10px; ">
								<?php echo $this->Form->hidden('patient_id',array('value'=>$patient_id,'id' => 'patient_id')); 
								echo $this->Form->input('referral_date', array('id'=>'referral_date' ,'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','readonly'=>'readonly')); ?>
								</td>  
							<?php if($this->params->query['type'] != 'reminder'){ ?> 
								<td width="15%" height="40px" align="right" style="font-size: 14px; ">
									<font style=" color:#61BEB3;"><?php echo __('Attached Ccda ') ?>:</font>
								</td>
								<td style="padding-left: 10px;  ">
									<?php echo $xml.'<br/>'; echo $simpleLetter; ?>
								</td> 
							<?php } ?>
							</tr>
						</table>
					</td> 
			 </tr> 	 
				<tr>
					<td width="15%" height="40px" align="right" valign="top" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;"><?php echo __('Message ') ?>:</font>
					</td>
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
						<?php echo $this->Form->textarea('message', array('class' => 'ckeditor','id' => 'message','rows'=>'10','cols'=>'10','value'=>$dataFile)); ?>
						 <?php echo $this->Form->hidden("",array('name'=>"message_enc",'id'=>'message_enc','class'=>'blueBtn')); ?>
						 <!--  <input class="blueBtn" type=hidden value="" name="message_enc" id="message_enc">-->
					</td>
				</tr> 
				<tr>
					<td><?php 
							//referral sent from soap note- send referral- referral_to_specialist- id---Pooja
							echo $this->Form->input('referralId', array('type'=>'hidden','class' => 'textBoxExpnd','value'=>$this->params->query['referralId'], 'id'=>'query_refered_Id'));
							?> </td>
					<td class="btn" valign="center" style="padding-left: 10px">
						<?php echo $this->Form->hidden('is_patient',array('value'=>0,'id' => 'is_patient'));?>
						<input class="blueBtn" type=submit value="Send" name="Send" id="submit">
						<?php
						 // cancel button commented by gulshan
						/* if($this->params->query['returnUrl']=='compose'){
			
							echo $this->Html->link('Cancel',array('controller'=>'notes','action'=>'soapNote',$patient_id,$noteId),array('escape'=>false ,'class'=>'blueBtn')); 
						}else if($this->params->query['returnUrl']=='patientList'){
			
							echo $this->Html->link('Cancel',array('controller'=>'messages','action'=>'patientList'),array('escape'=>false ,'class'=>'blueBtn')); 
						}else{
			
							echo $this->Html->link('Cancel',array('controller'=>'messages','action'=>'ccdaMessage',$patient_id),array('escape'=>false ,'class'=>'blueBtn'));
						} */
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>






		</td>
	</tr>
</table>


<?php echo $this->Form->end();?>
<?php $root_name = explode("app/", $_SERVER['SCRIPT_NAME']);?>

<script>
var server_path="<?php echo FULL_BASE_URL."/".$root_name[0].'js/fckeditor/' ?>";

function loadFckEditor(HtmlData){

	/*var mess = CryptoJS.AES.encrypt(CKEDITOR.instances.message.getData(), hashKey);
	mess = mess.toString();
    $('#message_enc').val(mess);
    CKEDITOR.instances.message.setdata(HtmlData);*/

	var Editor2 = FCKeditorAPI.GetInstance('message');
	Editor2.SetHTML(HtmlData);
    $('#message_enc').val(HtmlData);
}

$(document).ready(function(){
	oFCKeditor = new FCKeditor('message') ;
	oFCKeditor.BasePath = server_path;
	oFCKeditor.Height = "300" ; 
	oFCKeditor.Width = "700";
	oFCKeditor.ReplaceTextarea() ; 

 	
	$("#type").change(function(){
		selecetedVal = $(this).val();
		if(selecetedVal=='scnp'){
			$("#submit").val("Submit");
		}else{
			$("#submit").val("Send");
		}
	}); 

	// binds form submission and fields to the validation engine
		$("#composefrm").validationEngine();
		$( "#to" ).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "ccdaAddress","admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				
			 },
			 messages: {
			        noResults: '',
			        results: function() {},
			 }
		});
		

		$("#referral_date")
		.datepicker(
				{
					showOn : "button",
					buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly : true,
					changeMonth : true,
					changeYear : true,
					yearRange : '-73:+0',
					//maxDate : new Date(),
					dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
					onSelect:function(){$(this).focus();}
				});
	});
	

$('#order_ref').click(function(){
	if(document.getElementById('order_ref').checked){
		$.fancybox({
			'width' : '85%',
			'height' : '85%',
			'autoScale' : true,
			'hideOnOverlayClick':false,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Recipients" , "action" => "referral_preview_action",'null',$patient_id)); ?>"+"/"+$("#to").val(),
		
	    });
	}
	else if(document.getElementById('order_ref').checked==false){

		/*var mess = CryptoJS.AES.encrypt(CKEDITOR.instances.message.getData(), hashKey);
		mess = mess.toString();
	    $('#message_enc').val(mess);	
	    CKEDITOR.instances.message.setdata('AHAGYAJNAGHJKGHGHGJJKHGFFFTUIKIJKJHGFRERETRTYYUYUHGGHGHFTRUI=+');*/
	    
		var Editor2 = FCKeditorAPI.GetInstance('message');
		Editor2.SetHTML('');
	    $('#message_enc').val('');
		
	}
});
</script>
