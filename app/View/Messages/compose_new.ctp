<?php echo $this->Html->script(array('jquery.tokeninput.js','aes.js')); ?>
<?php echo $this->Html->css(array('token-input.css','token-input-facebook.css')); ?>
<?php echo $this->Html->script('ckeditor/ckeditor'); ?>

<script>
var hashKey = "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad";
var encrypted = CryptoJS.AES.encrypt("Pawan", hashKey);//alert(encrypted);

	jQuery(document).ready(function(){
		jQuery("#composefrm").validationEngine();
	});
</script>

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
.tddate img {
	float: inherit;
}
#MoveRight {
    float: left;
    margin: 20px 10px 0 23px;
}
#moveleft {
    float: left;
    margin: 20px 0 0;
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
.td_second{
	border-left-style:solid; 
	padding-left: 25px; 
	
}
</style>

<div class="inner_title">
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Compose') ?>
	</h3>
</div>



<table width="100%"  cellspacing='0' cellpadding='0'>
	<tr>
		<?php if($this->data){
			//name of patient is set when request send for medication and the msg is forwarded-Pooja
			$patientName=$this->data['Inbox']['from_name'];
		}
		if(empty($type)) { ?>
			<td valign="top" width="5%" >	
				<div class="mailbox_div">
					<?php echo $this->element('mailbox_index');?>
				</div>
			</td>
		<?php }?>
		
		<td class="td_second" valign="top">
<?php 
	$To = array('Medics'=>'Provider','Patient'=>'Patient','Staff'=>'Staff');
	$Type = array('Normal'=>'Normal','Urgent'=>'Urgent');
	$isAmmendment = array('0'=>'Subject','1'=>'Amendment','2'=>'Referral  Summary','3' => 'Reminder', '4' => 'Lab Requisition','5'=> 'Lab Report'); 
?>

<table cellpadding="0" cellspacing="0" width="100%" class="formFull" style="margin-top:25px;">
	<tr>
		<td valign="middle" style="background-color: #404040; color:#ffffff;">
			<div style="padding-left:10px; padding-bottom: 3px;"><strong>Compose</strong></div>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $this->Form->create('Compose',array('id'=>'composefrm','inputDefaults' => array( 'label' => false,
				'div' => false,
				'error' => false,
				'legend'=>false,
				'fieldset'=>false
				)));
				if(strtolower($this->Session->read('role')) != strtolower('patient')){
					echo $this->Form->hidden('is_patient',array('value'=>0,'id' => 'is_patient'));
					echo $this->Form->hidden('to_type',array('value'=>$toType));
					echo $this->Form->hidden('is_refill',array('value'=>$is_refill));
				}else{
					echo $this->Form->hidden('is_patient',array('value'=>1,'id' => 'is_patient'));
					echo $this->Form->hidden('to_type',array('value'=>"Medics"));
					echo $this->Form->hidden('is_refill',array('value'=>$is_refill));
				}
			?>
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			
			<?php if($this->Session->read('role') != 'Patient'){ ?>
				<tr>
					<td width="15%" height="40px" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;">To</font>
						<font color="red">* </font>
						<font style=" color:#61BEB3;">:</font>
					</td>
					
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
				
					<?php if(!empty($is_reply)){
							 echo $this->Form->input('name',array('type'=>'text','div'=>false,'class'=>'form-data drop','value'=>$users['first_name']." ".$users['last_name']));
							 echo $this->Form->hidden('to_new',array('type'=>'text','value'=>$users['id']));
							 echo $this->Form->hidden('to_type',array('type'=>'text'));							
					}else{
							echo $this->Form->input('',array('type'=>'select','options'=>$To,'empty'=>__('Please select'),
									'class'=>'validate[required,custom[mandatory-select]] sending_type form-data drop','name'=>"data[Compose][to_type]"));?>
					</td>
					<?php }?>
				
				</tr>
			<?php }?>
			
			
			<?php if($this->Session->read('role') == 'Patient'){ ?>
				<?php if(!empty($is_reply)){ ?>
				<tr>
					<td width="15%" height="40px" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
					<font style=" color:#61BEB3;">To</font>
					<font color="red">* </font>
					<font style=" color:#61BEB3;">:</font>
					
					</td>
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
					<?php 
						echo $this->Form->input('name',array('type'=>'text','div'=>false,'class'=>'form-data drop','value'=>$users['first_name']." ".$users['last_name']));
						echo $this->Form->hidden('to_new',array('type'=>'text','value'=>$users['id']));
						 
					?>
					</td>
				</tr>
			<?php }}?>
			
			<?php if(empty($is_reply)){?>
				<tr style="border-bottom:1px solid #cfcfcf;" id="recipient">
					<td height="40px" width="15%" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;">Recipient</font>
						<font color="red">* </font>
						<font style=" color:#61BEB3;">:</font>
					</td>
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
						<?php echo $this->Form->input('to_new',array('autocomplete'=>'off','type'=>'text','class'=>'validate[required,custom[mandatory-enter]] form-data box','id'=>'demo-input-facebook-theme'));?>
					</td>
				</tr>
				<?php }?>
				
				
				<tr style="border-bottom:1px solid #cfcfcf;">
					<td height="40px" width="15%" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;">Subject :</font>
						<font color="red">* </font>
					<font style=" color:#61BEB3;">:</font>
					</td>					
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>							
								<td width="18%">
									<?php echo $this->Form->input('is_ammendment',array('type'=>'select','options'=>$isAmmendment,
											'empty'=>'Please Select','id'=>'is_ammendment','class'=>'validate[required,custom[mandatory-select]] form-data'
											,'selected'=>'0'));?>
								</td>
								<td width="1%"></td>	<!--for space-->
								
								<td id="is_subject_show" style="display: none">
								<?php //debug($this->data);
									echo $this->Form->input('subject', array('type'=>'text','class'=>'form-data box validate[required,custom[mandatory-enter]]','id' => 'subject')); 
								?>
								</td>
								<td id="is_ammendment_show" style="display: none">
								<?php 
									echo $this->Form->input('subject_ammendment', array('type'=>'text','style'=>'width:250px','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'subject'));
								?>	
								</td>
								<!-- <tr>
								<td>
									<input type="checkbox" name="order_referral" id="order_ref"/>Attach Patient Information
								</td>
								</tr>-->
								<tr id="ammendmentShow">
								<?php if(!empty($is_reply)){?>
								<td ><span ,style="display: none" class="radio_label" id="show_medics_ammend"><input type="hidden" value="" id="ammendment_status_" name="data[ammendment_status]"><input type="radio" value="is_accepted" id="AmmendmentStatusIsAccepted" name="data[ammendment_status]">Accept<input type="radio" value="is_denied" id="AmmendmentStatusIsDenied" name="data[ammendment_status]">Deny </span></td>
								<?php }?>
								</tr>								
							</tr>
							
						</table>
					</td>
				</tr>
				
				
				
				
				<tr>
					<td width="15%" height="40px" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;">Type</font>
						<font color="red">* </font>
						<font style=" color:#61BEB3;">:</font>
					</td>
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
						<?php echo $this->Form->input('type',array('type'=>'select','options'=>$Type,'id'=>'type','class' => 'validate[required,custom[mandatory-select]] form-data drop'));?>
					</td>
				</tr>
				
				
				<tr>
					<td width="15%" height="40px" valign="top" align="right" style="font-size: 14px; border-bottom:1px solid #cfcfcf;">
						<font style=" color:#61BEB3;">Message</font>
						<font color="red">* </font>
						<font style=" color:#61BEB3;">:</font>
					</td>
					<td style="padding-left: 10px; border-bottom:1px solid #cfcfcf;">
					<?php echo $this->Form->textarea('message', array('class' => 'ckeditor','id' => 'message'));
							  echo $this->Form->hidden("",array('name'=>"message_enc",'id'=>'message_enc','class'=>'blueBtn'));
						?> 
						<?php echo $this->Form->hidden('is_refill',array('value'=>$is_refill)); ?>
					</td>
				</tr>
				
				
				<tr>
					<td>
						
					</td>
					<td class="btn" valign="center" style="padding-left: 10px">
					<?php //echo $this->Form->submit(__("Send"),array('class'=>'blueBtn','div'=>false,'name'=>"Send"));?>
					
					<!--<button type="submit" id="send" value="Send" name="Send"><img src="../Themed/Black/webroot/img/send.png"/></button>-->
					<input class="blueBtn" type=submit id="Send" value="Send" name="Send"/> 
						 
						<?php 
							echo $this->Html->link('Cancel',array('controller'=>'Messages','action'=>'inbox'),array('class'=>'blueBtn'));
						?>
					</td>
				</tr>
			</table>
			<?php echo $this->Form->end();?>
		</td>
	</tr>	
</table>
</td>
</tr>
</table>

<?php if($this->data['Inbox']['is_refill']){?>
<div id="printLetter" style="display: none;">
	<table width="90%" class="row_format" border="0" cellspacing="0"
		cellpadding="0" style="margin-bottom: 10px; margin-left: 17px;">
		<tr class="row_title classTr">
			<td style="border-bottom: none;"><strong><?php echo 'Patient Information'?>
			</strong></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr class='row_gray' style="padding-top: 5px;">
			<td class='myTd' width="20%" style="padding: 10px 5px;"><?php echo ('Patient Name : ');
			echo $demographics['Patient']['lookup_name']; ?>
			</td>
			<td class='myTd' width="20%" style="padding: 10px 5px;"><?php echo ('Patient DOB : ');
			echo $this->DateFormat->formatDate2Local($demographics['Person']['dob'],Configure::read('date_format'),false); ?>
			</td>
			<td class='myTd' width="20%" style="padding: 10px 5px;"><?php echo ('Patient Sex : ');
			echo $demographics['Person']['sex']; ?>
			</td>
			<td class='myTd' width="20%" style="padding: 10px 5px;"><?php echo ('Patient Age : ');
			echo $demographics['Person']['age']; ?>
			</td>
			<td class='myTd' width="20%" style="padding: 10px 5px;"></td>
		</tr>
		<tr class="row_title classTr">
			<td style="border-bottom: none;"><strong><?php echo ('Vital')?> </strong>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr class='row_gray' style="padding-top: 5px;">
			<td class='myTd' width="20%" style="padding: 10px 5px;"><?php echo ('Height:');
			echo $vitals['BmiResult']['height_result']; ?>
			</td>
			<td class='myTd' width="20%" style="padding: 10px 5px;"><?php echo ('Weight:');
			echo $vitals['BmiResult']['weight_result']; ?>
			</td>
			<td class='myTd' width="20%" style="padding: 10px 5px;"><?php echo ('B.M.I.:');
			echo $vitals['BmiResult']['bmi']; ?>
			</td>
			<td class='myTd' width="20%" style="padding: 10px 5px;"><?php echo ('Blood Pressure:');
			/* for bp  */
			if($vitals['BmiBpResult']['systolic2']){
				$BpSystolic = $vitals['BmiBpResult']['systolic2'];
				$BpDiastolic = $vitals['BmiBpResult']['diastolic2'];
					
			}else if(($vitals['BmiBpResult']['systolic1']) && (!$vitals['BmiBpResult']['systolic2'])){
				$BpSystolic = $vitals['BmiBpResult']['systolic1'];
				$BpDiastolic = $vitals['BmiBpResult']['diastolic1'];
			}else{
				$BpSystolic = $vitals['BmiBpResult']['systolic'];
				$BpDiastolic = $vitals['BmiBpResult']['diastolic'];
			}
			echo $BpSystolic.'/'.$BpDiastolic; ?>
			</td>
			<td class='myTd' width="20%" style="padding: 10px 5px;"><?php echo ('Temp:');
			/* for temp  */
			if($vitals['BmiResult']['temperature2']){
				$temperature = $vitals['BmiResult']['temperature2'];
				$myoption = $vitals['BmiResult']['myoption2'];
			}else if(($vitals['BmiResult']['temperature1']) && (!$vitals['BmiResult']['temperature2'])){
				$temperature = $vitals['BmiResult']['temperature1'];
				$myoption = $vitals['BmiResult']['myoption1'];
			}else{
				$temperature = $vitals['BmiResult']['temperature'];
				$myoption = $vitals['BmiResult']['myoption'];
			}
			echo $temperature.' '.$myoption; ?>
			</td>
			</tr>
			
	</table>
	<table width="90%" class="row_format" border="0" cellspacing="0"
		cellpadding="0" style="margin-bottom: 10px; margin-left: 17px;">
		<tr class="row_title classTr" style="padding-top: 5px;">
			<td width="50"><strong><?php echo ('Allergy')?> </strong></td>
			<td width="25"><strong><?php echo ('Status')?> </strong></td>
			<td width="25"><strong><?php echo ('Severity')?> </strong></td>
		</tr>
		</tr>
		<?php $toggle =0;
		if(count($allergy) > 0) {
					      		foreach($allergy as $allergyData){
					       $cnt++;

								    if($toggle == 0) {
									      	echo "<tr class='row_gray' style='padding-top:5px;'>";
									      	$toggle = 1;
								       }else{
									       echo "<tr style='padding-top:5px;'>";
									       $toggle = 0;
								      }
								      ?>
		<td width="50" class='myTd' style="padding: 10px 5px;"><?php echo $allergyData['NewCropAllergies']['name']?>
		</td>


		<td width="25" class='myTd' style="padding: 10px 5px;"><?php echo 'Active';?>
			<?php ?></td>

		<td width="25" class='myTd' style="padding: 10px 5px;"><?php echo $allergyData['NewCropAllergies']['AllergySeverityName']?>
			<?php ?></td>
		<?php } ?>
		<?php } else {?>
		<tr>
			<TD class="classTd" colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
								      }
								      ?>
		</tr>
	</table>
		
	<table width="90%" class="row_format" border="0" cellspacing="0"
		cellpadding="0" style="margin-bottom: 10px; margin-left: 17px;">
		<tr class="row_title classTr" style="padding-top: 5px;">
			<td width="50"><strong><?php echo ('Diagnoses')?> </strong></td>
			<td width="25"><strong><?php echo ('Start')?> </strong></td>
			<td width="25"><strong><?php echo ('Stop')?> </strong></td>
		</tr>
		</tr>
		<?php $toggle =0;
		if(count($diagnosis) > 0) {
					      		foreach($diagnosis as $patients){
					       $cnt++;

								    if($toggle == 0) {
									      	echo "<tr class='row_gray' style='padding-top:5px;'>";
									      	$toggle = 1;
								       }else{
									       echo "<tr style='padding-top:5px;'>";
									       $toggle = 0;
								      }
								      ?>
		<td width="50" class='myTd' style="padding: 10px 5px;"><?php echo $patients['NoteDiagnosis']['diagnoses_name']?>
		</td>


		<td width="25" class='myTd' style="padding: 10px 5px;"><?php echo $this->DateFormat->formatDate2Local($patients['NoteDiagnosis']['start_dt'],Configure::read('date_format'))?>
			<?php ?></td>

		<td width="25" class='myTd' style="padding: 10px 5px;"><?php echo $this->DateFormat->formatDate2Local($patients['NoteDiagnosis']['end_dt'],Configure::read('date_format'))?>
			<?php ?></td>
		<?php } ?>
		<?php } else {?>
		<tr>
			<TD class="classTd" colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
								      }
								      ?>
		</tr>
	</table>

	<table width="90%" class="row_format " border="0" cellspacing="0"
		cellpadding="0" style="margin-bottom: 10px; margin-left: 17px;">
		<tr class="row_title classTr" style='padding-top: 5px;'>
			<td width="50"><strong><?php echo ('Medication')?> </strong></td>
			<td width="25 !important"><strong><?php echo ('Start')?> </strong>
			</td>
			<td width="25"><strong><?php //echo ('Stop')?> </strong></td>
		</tr>
		<?php $toggle =0;
		if(count($medication) > 0) {
					      		foreach($medication as $patients){
					       $cnt++;

								    if($toggle == 0) {
									      	echo "<tr class='row_gray' style='padding-top:5px;'>";
									      	$toggle = 1;
								       }else{
									       echo "<tr style='padding-top:5px;'>";
									       $toggle = 0;
								      }
								      ?>

		<td width="50" class='myTd' style="padding: 10px 5px;"><?php echo $patients['NewCropPrescription']['description']?>
			<?php  ?></td>

		<td width="25" class='myTd' style="padding: 10px 5px;"
			style="padding:10px"><?php echo $this->DateFormat->formatDate2Local($patients['NewCropPrescription']['date_of_prescription'],Configure::read('date_format'))?>
			<?php  ?></td>

		<td width="25" class='myTd'><?php echo $this->DateFormat->formatDate2Local($patients['NewCropPrescription']['end_date'],Configure::read('date_format'))
		?> <?php  ?></td>
		<?php } ?>
		<?php } else {?>
		<tr>
			<TD class="classTd" colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
		}
		?>
		</tr>
	</table>
</div>
<?php }?>






<script>



		$(document).ready(function(){
			//var Editor2 = CKEDITOR.instances.message.getData(); 
		       
			<?php if(!empty($is_refill)) { ?>
			   setTimeout(function(){

				   var Editor2 = CKEDITOR.instances.message.getData() ;
				   seperator ="<p></p><p>---------- Forwarded message ----------</p><P></p>";
				   	CKEDITOR.instances.message.setData(seperator+$("#printLetter").html()+Editor2); 
				   }, 1000);

			   <?php } ?>
		});
		
function encryptData(){
	//$('#subject').val(CryptoJS.AES.encrypt($('#subject').val(), hashKey));
	 
	//var Editor2 = CKeditorAPI.GetInstance('message');
	var mess = CryptoJS.AES.encrypt(CKEDITOR.instances.message.getData(), hashKey);
	mess = mess.toString();
    // Editor2.SetHTML('AHAGYAJNAGHJKGHGHGJJKHGFFFTUIKIJKJHGFRERETRTYYUYUHGGHGHFTRUI=+');
    $('#message_enc').val(mess);	
    CKEDITOR.instances.message.setData('AHAGYAJNAGHJKGHGHGJJKHGFFFTUIKIJKJHGFRERETRTYYUYUHGGHGHFTRUI=+');
}


$('#Send').click(function() {
	var validateMessage = jQuery("#composefrm").validationEngine('validate');
	if(validateMessage){
		encryptData();
		return validateMessage;
	}
});

 

$(function() {


	//set referral HTML directly to messge body  

    
		if($("#is_ammendment").val() == '0'){
       		$("#is_subject_show").show();
       		$("#subject").show();
       	} else if($("#is_ammendment").val() == '1'){
       		$("#is_subject_show").show();
       		$("#subject").show();
       	}else if($("#is_ammendment").val() == "2"){
       		$("#is_subject_show").show();
       		$("#subject").show();
       	}else if($("#is_ammendment").val() == "3"){
       		$("#is_subject_show").show();
       		$("#subject").show();
       	}else if($("#is_ammendment").val() == "4"){
       		$("#is_subject_show").show();
       		$("#subject").show();
       	}else if($("#is_ammendment").val() == "5"){
       		$("#is_subject_show").show();
       		$("#subject").show();
        }
});
    
    $("#is_ammendment").change(function(event) {
    	if($("#is_ammendment").val() == ''){
        	$("#is_subject_show").hide();
    	}else if($("#is_ammendment").val() == '0'){
        	$("#is_subject_show").show();
        	$("#subject").focus();
        }else if($("#is_ammendment").val() == '1'){
        	$("#is_subject_show").show();
        	$("#subject").focus();
        }else if($("#is_ammendment").val() == "2"){
        	$("#is_subject_show").show();
        	$("#subject").focus();
        }else if($("#is_ammendment").val() == "3"){
        	$("#is_subject_show").show();
        	$("#subject").focus();
        }else if($("#is_ammendment").val() == "4"){
        	$("#is_subject_show").show();
        	$("#subject").focus();
        }else if($("#is_ammendment").val() == "5"){
        	$("#is_subject_show").show();
        	$("#subject").focus();
        }
    });



$(function() {
	
	$( "#send_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	});

});


$(function(){
	var userRole = '<?php echo $this->Session->read('role')?>';
	if(userRole != 'Patient'){
		$("#reference_patient").removeClass("validate[required,custom[mandatory-enter]] textBoxExpnd");
	}
});

	$('#is_ammendment').change(function (){
		
			vaccin_name = $('#is_ammendment').text();
			if(vaccin_name=='Please select'){
				$("#is_subject_show").hide();
			}
		  
			public_name = $('#is_subject_showtxt').text();
			
			var e = document.getElementById("is_ammendment");
			var strUser = e.options[e.selectedIndex].text;
	        if(strUser=='Please select'){
				$("#is_subject_show").hide();
			}
	        var vacc_ary = strUser.split("-");
	        public_name = public_name.replace(public_name,vacc_ary[0]); 
	        $('#is_subject_showtxt').html(public_name);	
		});



    
$(document).ready(function(){

	if('<?php echo $is_reply;?>' !='' && $('#is_ammendment').val()=='1'){
		$("#ammendmentShow").show();
	}else{
		$('#AmmendmentStatusIsAccepted').attr('checked', false);
		$('#AmmendmentStatusIsDenied').attr('checked', false);
		$("#ammendmentShow").hide();
	}

	
	$("#is_ammendment").change(function(){
		if($(this).val()=='1'){
			$("#ammendmentShow").show();
		}else{
			$('#AmmendmentStatusIsAccepted').attr('checked', false);
			$('#AmmendmentStatusIsDenied').attr('checked', false);
			$("#ammendmentShow").hide();
		}
	});



	$("#recipient").hide();
	 
	
	if($('#is_patient').val() == 1)		//for patient only (patient can only sends mail to physician)
	{
		var URL = "<?php echo $this->Html->url(array('action'=>"getUsersDetails")); ?>";
		var physician = "Medics";
		$("#demo-input-facebook-theme").tokenInput(URL+'/'+physician,
				{
				     theme:'facebook'
				});
	}

	var URL = "";
	$(".sending_type").change(function(){	
		if($(this).val()!=''){
			$("#recipient").show();
			
		} else {
			$("#recipient").hide();
		}
		
		 $(".token-input-list-facebook").remove();
		 if($(this).val()!=null){
			 URL = "<?php echo $this->Html->url(array('action'=>"getUsersDetails")); ?>"+'/'+$(this).val(); ; 
		 }
			$("#demo-input-facebook-theme").tokenInput(URL,
			{
				 theme:'facebook',
				 tokenFormatter: function (item) {
					 var split=item.name.split('-'); 
					 return "<li><p>" +  split[0] + "</p></li>" },
				 
			});
			
			
	});  
	if($('#is_patient').val() != 1)	{
		$("#recipient").hide();
	}else{
		$("#recipient").show();
	}	
		
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

