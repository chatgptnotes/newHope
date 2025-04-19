<?php 
echo $this->Html->script(array('jquery-1.5.1.min' ,'jquery.validationEngine',
		'/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
 
echo $this->Html->css(array('jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css')); 
 
?>

<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>
<style>
label{ width:59px !important; text-align:left !important;padding: 2px 0 0 10px;}
</style>
</head>
<body>

	<div class="inner_title">
		<h3 style="padding-left: 12px;">
			&nbsp;
			<?php echo __('Make a diagnosis', true);
						?>
		</h3>

	</div>
	<?php 
	if(!empty($errors)) {
	?>

	<?php 
	foreach($errors as $errorsval){
	         echo $errorsval[0];
	         echo "<br />";
	     }

	     ?>

	<?php } ?>
	<?php 
		echo $this->Form->create('make_diagnosis',array('id'=>'make_daignosis'));
		echo $this->Form->hidden('id',array('name'=>'id'));
		echo $this->Form->hidden('favAdd',array('value'=>$strFav));
		echo $this->Form->hidden('icd_id',array('value'=> $icd[0][icds][icd_snomed],'name'=>'icd_id'));
		echo $this->Form->hidden('patient_id',array('value'=> $icd[0][icds][p_id],'name'=>'patient_id'));
		echo $this->Form->hidden('note_id',array('value'=> $icd[0][icds][note_id],'name'=>'note_id'));
		echo $this->Form->hidden('returnUrl',array('value'=> $returnUrl,'name'=>'returnUrl'));
	 ?>
                
                
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="590px">

		<tr class="row_title tdLabel">
			<td class="patientHub" width="500px" cellpadding="5px"
				valign="bottom" colspan='2' style="padding: 5px 0 6px 16px;"><strong> <?php echo __('Patient name :') ?>
					
			</strong> <?php echo $icd[0]['icds']['p_name']; ?> 
			</td>
		</tr>

		<tr class="row_title">
			<td class="row_format" colspan='2' style="padding: 5px 0 0 16px;"><?php echo __('Diagnosis :')."  "; ?>
			<?php 	if(empty($icd[0]['icds']['icd_snomedid']))
						 echo $icd[0]['icds']['icd_snomedid1']."  ";
					else  
						 echo $icd[0]['icds']['icd_snomedid']."  ";?>
			<!-- ------------------------------------------------------------------------------ -->
			<?php 	if(!empty($icd[0]['icds']['icd_description']))
						$decp=$icd[0]['icds']['icd_description'];
					else $decp=$edit_makediagnosis[0]['NoteDiagnosis']['diagnoses_name']; 
						echo $decp;?><br />
				<label id="db_icd_code"></label>
				<?php echo $this->Form->hidden('name',array('type'=>'text', 'value'=>$decp));?>
					<?php echo $this->Form->hidden('NoteDiagnosis.id',array('type'=>'text', 'value'=>$edit_makediagnosis[0]['NoteDiagnosis']['id']));?>
				<?php  echo $this->Form->hidden('snowmedid',array('type'=>'text', 'value'=>$icd[0]['icds']['icd_snomedid']));?>
				<?php  echo $this->Form->hidden('snowmedid1',array('type'=>'text', 'value'=>$icd[0]['icds']['icd_snomedid1']));?>
			</td>
		</tr>
		<tr class="row_title">
			<td class="row_format" colspan='2' style=""><?php echo $this->Form->input(__('Start_date'), array('type'=>'text','id' => 'start_date','name'=>'start_dt','style'=>'width:22%;padding-top:0!important;','readonly'=>'readonly','class'=>'textBoxExpnd','div'=>false,'value'=>$edit_makediagnosis['0']['NoteDiagnosis']['start_dt'] )); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->Form->input(__('End_date '),array('type'=>'text','id' => 'end_date','name'=>'end_dt','class'=>' textBoxExpnd','style'=>'width:22%;','readonly'=>'readonly','div'=>false,'value'=>$edit_makediagnosis['0']['NoteDiagnosis']['end_dt'] )); ?>
			</td>
		</tr>
          <tr><td></td></tr>
		<tr>
			<td class="tdLabel" id="boxSpace" align="left"><?php echo __('Diagnosis Type')?></td>
			<td><?php echo $this->Form->input('diagnosis_type',array('id'=>'diagnosis_type','empty'=>__('Please Select'),'options'=>array('PD'=>'Principal Diagnosis','O'=>'Other'),'label'=>false,'value'=>(isset($edit_makediagnosis["0"]["NoteDiagnosis"]["diagnosis_type"])?$edit_makediagnosis["0"]["NoteDiagnosis"]["diagnosis_type"]:"")));?>
			</td>
		</tr>
		<tr >
			<td class="tdLabel" id="boxSpace" align="left"><?php echo("Status "); ?><font color="red">*</font></td>
			<td class="row_format" ><?php echo $this->Form->radio(__('disease_status'), array('chronic'=>'Chronic','acute'=>'Acute','resolved'=>'Other'),array('value'=>(isset($edit_makediagnosis["0"]["NoteDiagnosis"]["disease_status"])?$edit_makediagnosis["0"]["NoteDiagnosis"]["disease_status"]:"chronic"),'legend'=>false,'name'=>'disease_status','label'=>false,'id' => 'disease_status','class'=>'validate[required,custom[mandatory-select]]'));
			?>
			</td>
		</tr>
		<tr >
			<td class="tdLabel" id="boxSpace" align="left"><?php echo("Terminal "); ?></td>
			<td class="row_format" ><?php echo $this->Form->radio(__('terminal'), array('Yes'=>'Yes','No'=>'No'),array('value'=>(isset($edit_makediagnosis["0"]["NoteDiagnosis"]["terminal"])?$edit_makediagnosis["0"]["NoteDiagnosis"]["terminal"]:""),'legend'=>false,'name'=>'terminal','label'=>false,'id' => 'terminal','class'=>''));
			?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace" align="left"><?php echo __('Comment')?></td>
			<td><?php echo $this->Form->input('Comment',array('type'=>'textarea','rows'=>'2','cols'=>'80','name'=>'comment','value'=>$edit_makediagnosis['0']['NoteDiagnosis']['comment'],'label'=>false,'autocomplete'=>"off"));?>
			</td>
		</tr>
		
		<tr>
			<td class="tdLabel" id="boxSpace" style='width: 50%'>Previous comment <br />on this diagnosis</td>
			<td><?php echo $this->Form->input('Previous',array('type'=>'textarea','rows'=>'2','cols'=>'80','name'=>'prev_comment','value'=>$edit_makediagnosis['0']['NoteDiagnosis']['prev_comment'],'label'=>false,'autocomplete'=>"off"));?>
			</td>
		</tr>
		<tr>
		<td></td>
			<td align="center"><?php
			echo $this->Form->hidden(__('preffered_icd9cm'),array('type'=>'text','id' => 'preffered_icd9cm','name'=>'preffered_icd9cm','value'=>$ICD9cm));
			echo $this->Form->hidden(__('u_id'),array('type'=>'text','id' => 'u_id','name'=>'u_id','value'=>$u_id));
			echo $this->Form->button(__('Close'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'closeForm','type'=>'button' ));
			echo $this->Form->button(__('Cancel'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'makd','type'=>'button','style'=>' margin: 0 10px;'));
			echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'submit'));?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
</body>

<script>
				 
/*$( "#submit" ).click(function(){	
	   var fromdate = new Date($( '#start_date' ).val());
	      var todate = new Date($( '#end_date' ).val());
	 if(fromdate.getTime() > todate.getTime()) {
alert("End Date should be greater than Start Date");
return false;
}
	 
});*/

				 
$(function(){ 
	var newVar;
	// --  controller's variable to get sucess of insert and update
	 var sucess = '<?php echo $submitSucess; ?>';
	//if(sucess=='close'){
	//	parent.$.fancybox.close();
	//} -->
	if(sucess != ''){
		var lastId = '<?php echo $noteDiagnosisId;?>';
		var newVar  = window.parent.sample;
		newVar = newVar+"|"+lastId; 
		parent.sample = newVar;
		$('#notediagnosis_id',parent.document).val(newVar);		
		alert("Diagnosis Saved");
		parent.addDiagnosisDetails();
		parent.global_note_id = "<?php echo $backupNoteId?>";
		parent.$.fancybox.close();
		}
	});
				 
	jQuery(document)
			.ready(
					function() {

						$("#start_date")
								.datepicker(
										{
											showOn : "button",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',

											dateFormat:'<?php echo $this->General->GeneralDate();?>',
											onSelect : function() {
												$(this).focus();
											}
										});
						$("#end_date")
								.datepicker(
										{
											showOn : "button",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',

											dateFormat:'<?php echo $this->General->GeneralDate();?>',
											onSelect : function() {
												$(this).focus();
											}
										});
					});

	
	
	
	
	jQuery(document).ready(function() {

		$('#makd').click(function() {
			var chk=confirm('Do you wish to cancel diagnosis?');
			if(chk==true){
				parent.addDiagnosisDetails();
				parent.$.fancybox.close();
			}else{
				
			}
		
		});

		 
		
		$('#closeForm').click(function() {
			parent.$.fancybox.close();

		});


	});
	$('#make_daignosis').submit(function(){
		var matchnotfnd="<?php echo $matchnotfnd;?>";
		var matchfnd="<?php echo $matchfnd;?>";
	
		//var diagnosesNameCnt="<?php echo $cnt;?>";
		//if(diagnosesNameCnt!=''){
		if(matchfnd!=''){
		if(confirm("You have selected a diagnosis that is similar to a present diagnosis. Do you want to continue?")){
			return true;
	    }else{
			return false;
	    }
		}
		//}
		var diesesStatus = $("#dxfrm input[type='radio']:checked").val();
		
		if(diesesStatus == 'resolved'){
			$('#end_date').addClass("validate[required,custom[mandatory-date]] textBoxExpnd");
		}else{
			$('#end_date').removeClass("validate[required,custom[mandatory-date]] textBoxExpnd");
		}
		var validationRes = jQuery("#make_daignosis").validationEngine('validate');
		var received = new Date($('#start_date').val()); 
		var completed = new Date($('#end_date').val());
		var error = '';
		if (received.getTime() > completed.getTime())
		{
			error = "End Date Should Be Greater then Start Date";
		}
		if(error !=''){
			alert(error);
			return false ;
		}
		
	});
	$(document).ready(function(){
		if('<?php echo $icd[0]['icds']['icd_snomedid']?>'===undefined ||
		'<?php echo $icd[0]['icds']['icd_description']?>'===undefined ){
			parent.$.fancybox.close();
		}
	jQuery("#make_daignosis").validationEngine({
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
		$('#submit')
		.click(
		function() { 
		var validatePerson = jQuery("#make_daignosis").validationEngine('validate');
		//alert(validatePerson);
		if (validatePerson) {
			//$(this).css('display', 'none');
			}
		//return false;
		});
		});
	
</script>
