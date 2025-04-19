<?php 
//echo $this->Html->script(array('inline_msg'));
$route_admin=Configure :: read('route_administration');
$freq_fullform=Configure :: read('frequency_fullform');
$doseType=Configure :: read('strength');
$roleNurse = $this->Session->read('role');
?>
<div class="inner_title">
				<h3>
				<?php echo __('Verify Order'); ?>
			</h3>
			<span align="right"> <?php //echo $this->Html->link(__('Back', true),array('controller' => 'appointments', 'action' => 'appointments_management'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<?php echo $this->element('patient_information');?>
<?php echo $this->Form->create('VerifyMedicationOrder',array('type' => 'file','id'=>'verifyMedicationOrderFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('VerifyMedicationOrder.patient_id',array('value'=>$patientId,'id'=>'patient_id'));
echo $this->Form->hidden('VerifyMedicationOrder.newcrop_id',array('value'=>$newCropId,'id'=>'newcrop_id'));
echo $this->Form->hidden('VerifyMedicationOrder.id',array('value'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['id'],'id'=>'verify_id'));
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" style="padding-top: 10px;" align="center">	
	<tr>
	<td class="tdLabel" id="boxSpace" width="17%">
	<strong><?php echo __('Patient'); ?></strong></td>
	<td width="17%">
        <?php 
        echo $getMedicationData['Patient']['lookup_name'];
        ?>
	</td >
	<td class="tdLabel" id="boxSpace" width="">
	<strong><?php echo __('Medication Name'); ?></strong></td>
	<td width=""><?php echo $getMedicationData['NewCropPrescription']['description'];
        ?>
    </td>	
	</tr>
	
	<tr>
	<td class="tdLabel" id="boxSpace" width="">
	<strong><?php echo __('Dose'); ?></strong></td>
	<td width="">
        <?php $dose=Configure :: read('dose_type');
        echo $dose[$getMedicationData['NewCropPrescription']['dose']]." ".$doseType[$getMedicationData['NewCropPrescription']['strength']];
        ?>
	</td >
	<td class="tdLabel" id="boxSpace" width="">
	<strong><?php echo __('Route'); ?></strong></td>
	<td width=""><?php 
        echo ucwords($route_admin[$getMedicationData['NewCropPrescription']['route']]);
        ?>
    </td>	
	</tr>
	
	<tr>
	<td class="tdLabel" id="boxSpace" width="">
	<strong><?php echo __('Schedule'); ?></strong></td>
	<td width="">
        <?php 
        echo $freq_fullform[$getMedicationData['NewCropPrescription']['frequency']];
        ?>
	</td >
	<td class="tdLabel" id="boxSpace" width="">
	</td>
	<td width="">
    </td>	
	</tr>
	<tr>
	<td class="tdLabel" id="boxSpace" width="">
	<strong><?php echo __('Verified By'); ?></strong></td>
	<td width="">
      <?php $disabledDropDown=(empty($getVerifyMedicationOrder['VerifyMedicationOrder']['created_by']) && ($roleNurse!='Primary Care Provider') || ($roleNurse=='Nurse'))?'false':'true';
			echo $this->Form->input('VerifyMedicationOrder.created_by', array('id' => 'created_by','label'=>false,'options'=>$nurses,'value'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['created_by'],'disabled'=>$disabledDropDown)); ?>
	</td >
	<td class="tdLabel" id="boxSpace" width="">
	</td>
	<td width="">
    </td>	
	</tr>
	<tr>
	<td>
	</td>
	<td style="padding-bottom: 20px">
	
	<?php if((empty($getVerifyMedicationOrder['VerifyMedicationOrder']['created_by']) && $getVerifyMedicationOrder['VerifyMedicationOrder']['created_by']==$this->Session->read('userid')) || ($roleNurse=='Nurse') || ($roleNurse!='Primary Care Provider')){
		echo "&nbsp;&nbsp;".$this->Html->link('OK',"javascript:void(0)",array('class'=>'blueBtn verifySuccess','div'=>false,'title'=>'Ok','id'=>'verifySuccessid'));
		echo "&nbsp;&nbsp;".$this->Html->link(__('Cancel', true),array("controller" => "appointments", "action" => "appointments_management"), array('escape' => false,'class'=>'blueBtn'));
		echo $this->Form->input('VerifyMedicationOrder.verified_chk', array('type'=>'checkbox','id' => 'verified_chk','class'=>'verified_chkCls','label'=>false,'style'=>'display:none;','checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['verified_chk'])); 
	}?>	
	
	</td>
	<td>
	</td>
	<td style="padding-bottom: 20px"><?php echo "&nbsp;&nbsp;".$this->Html->link('Patient refused',"javascript:void(0)",array('class'=>'blueBtn patientRefused','div'=>false,'title'=>'Patient refused','id'=>'patientRefused'));?>	
	</td>
	</tr>
		
	<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4">
	<strong><?php //echo __('fields populate from the physician order'); ?></strong>
	</td>	
	</tr>	
	<tr>
	<td class="tdLabel" id="boxSpace" width="">
	<?php echo $this->Form->input('VerifyMedicationOrder.medication_crushed', array('type'=>'checkbox','id' => 'medication_crushed','label'=>false,'checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['medication_crushed'])); ?>
	</td>
	<td width="">
      <?php echo __('Medication crushed prior to administration Mixed in'); ?>
      <?php echo $this->Form->input('VerifyMedicationOrder.medication_crushed_txt', array('type'=>'text','id' => 'medication_crushed_txt','label'=>false,'value'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['medication_crushed_txt'])); ?>
	</td >
	<td class="tdLabel" id="boxSpace" width="">
	</td>
	<td width="">
    </td>	
	</tr>
	<tr>
	<td class="tdLabel" id="boxSpace">
	<?php echo $this->Form->input('VerifyMedicationOrder.patient_vomited', array('type'=>'checkbox','id' => 'patient_vomited','label'=>false,'checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['patient_vomited'])); ?>
	</td>
	<td>
     <?php echo __('Patient vomited during or soon after administration'); ?>
	</td >
	<td class="tdLabel" id="boxSpace">
	</td>
	<td>
    </td>	
	</tr>
	<tr>
	<td class="tdLabel" id="boxSpace">
	<?php echo $this->Form->input('VerifyMedicationOrder.snack_given', array('type'=>'checkbox','id' => 'snack_given','label'=>false,'checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['snack_given'])); ?>
	</td>
	<td>
      <?php echo __('Snack given with administration'); ?>
	</td >
	<td class="tdLabel" id="boxSpace">
	</td>
	<td >
    </td>	
	</tr>
	<tr>
	<td class="tdLabel" id="boxSpace">
	<?php echo $this->Form->input('VerifyMedicationOrder.mouth_check_performed', array('type'=>'checkbox','id' => 'mouth_check_performed','label'=>false,'checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['mouth_check_performed'])); ?>
	</td>
	<td >
      <?php echo __('Mouth check performed after administration of medication'); ?>
	</td >
	<td class="tdLabel" id="boxSpace">
	</td>
	<td>
    </td>	
	</tr>
	<tr>
	<td class="tdLabel" id="boxSpace">
	<?php echo $this->Form->input('VerifyMedicationOrder.correct_medication', array('type'=>'checkbox','id' => 'correct_medication','label'=>false,'checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['correct_medication'])); ?>
	</td>
	<td >
      <?php echo __('Correct patient, time, route, dose and medication confirmed prior to administration'); ?>
	</td >
	<td class="tdLabel" id="boxSpace" >
	</td>
	<td >
    </td>	
	</tr>
	<tr>
	<td class="tdLabel" id="boxSpace" >
	<?php echo $this->Form->input('VerifyMedicationOrder.side_effects_prior', array('type'=>'checkbox','id' => 'side_effects_prior','label'=>false,'checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['side_effects_prior'])); ?>
	</td>
	<td >
      <?php echo __('Patient advised of actions and side-effects prior to administration'); ?>
	</td >
	<td class="tdLabel" id="boxSpace" >
	</td>
	<td >
    </td>	
	</tr>
	<tr>
	<td class="tdLabel" id="boxSpace" >
	<?php echo $this->Form->input('VerifyMedicationOrder.allergies_confirmed', array('type'=>'checkbox','id' => 'allergies_confirmed','label'=>false,'checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['allergies_confirmed'])); ?>
	</td>
	<td>
      <?php echo __('Allergies confirmed and medications reviewed prior to administration'); ?>
	</td>
	<td class="tdLabel" id="boxSpace">
	</td>
	<td>
    </td>	
	</tr>
	
	<tr>
	<td class="tdLabel" id="boxSpace" >
	<?php echo $this->Form->input('VerifyMedicationOrder.family_member_bedside', array('type'=>'checkbox','id' => 'allergies_confirmed','label'=>false,'checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['family_member_bedside'])); ?>
	</td>
	<td>
      <?php echo __('Family member at bedside'); ?>
	</td>
	<td class="tdLabel" id="boxSpace">
	</td>
	<td>
    </td>	
	</tr>
	
	<tr>
	<td class="tdLabel" id="boxSpace" >
	<?php echo $this->Form->input('VerifyMedicationOrder.applied_band', array('type'=>'checkbox','id' => 'allergies_confirmed','label'=>false,'checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['applied_band'])); ?>
	</td>
	<td>
      <?php echo __('Applied (band-aid, dressing, cotton ball)'); ?>
	</td>
	<td class="tdLabel" id="boxSpace">
	</td>
	<td>
    </td>	
	</tr>
	
	<?php if(($route_inject_intramuscular=="inject. intramuscular") || ($route_inject_intramuscular=="intravenous")){?>		
	<tr id="showSite">
	<td class="tdLabel" id="boxSpace" ><strong><?php echo __('Site'); ?></strong>
	</td>
	<td><?php echo $this->Form->input('VerifyMedicationOrder.site', array('id' => 'site','label'=>false,'options'=>array('Left deltoid'=>'Left deltoid','Right deltoid'=>'Right deltoid','Left buttock'=>'Left buttock','Right buttock'=>'Right buttock','Left hip'=>'Left hip','RIght hip'=>'RIght hip','Left thigh'=>'Left thigh','Right thigh'=>'Left thigh'),'value'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['site'])); ?>
	</td>
	<td>
	</td>
	<td>
	</td>
	</tr>
	<?php }?>
	<tr>
	<td class="tdLabel" id="boxSpace" ><strong><?php echo __('Patient Tolerated Procedure'); ?></strong>
	</td>
	<td width="35%"><?php $options=array('Well'=>'Well','With difficulty'=>'With Difficulty','Uncooperative'=>'Uncooperative','Other'=>'Other');
		if($getVerifyMedicationOrder['VerifyMedicationOrder']['tolerated_procedure'])
		$checkedExeSignClk='checked';
		   $attributes=array('legend'=>false, 'label'=> false, 'div' => false, 'error' => false,'class'=>'tolerated_procedureCls','checked'=>$checkedExeSignClk);
           echo $this->Form->radio('VerifyMedicationOrder.tolerated_procedure',$options,$attributes);?>
           <?php if($getVerifyMedicationOrder['VerifyMedicationOrder']['tolerated_procedure_other']){
					$displayOtherTreatmentValue='block';
				}else{
					$displayOtherTreatmentValue='none';
				}
echo $this->Form->input('VerifyMedicationOrder.tolerated_procedure_other', array('type'=>'text','id' => 'tolerated_procedure_other','label'=>false,'value'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['tolerated_procedure_other'],'style'=>"display: $displayOtherTreatmentValue;")); ?>
	</td>
	<td>
	</td>
	<td>
	</td>
	</tr>
	<tr>
	<td class="tdLabel" id="boxSpace" ><strong><?php echo __('Additional Staff required due to'); ?></strong>
	</td>
	<td><?php echo $this->Form->input('VerifyMedicationOrder.additional_staff', array('empty'=>'Please Select','id' => 'additional_staff','label'=>false,'options'=>array('Age'=>'Age','Combative'=>'Combative','Confused'=>'Confused','Other'=>'Other'),'value'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['additional_staff'])); ?>
	</td>
	<td>
	</td>
	<td>
	</td>
	</tr>
	
	<tr>
	<td class="tdLabel" id="boxSpace" ><strong><?php  echo $this->Html->link('Reassessment of site and vitals',array('controller'=>'Diagnoses','action'=>'addVital',$patientId,'null',$appId),array('label'=>false,'name'=>'submit','id'=>'addPlanData'));  ?></strong>
	</td>
	<td><?php echo $this->Form->input('VerifyMedicationOrder.site_reassesment', array('type'=>'textarea','rows'=>'3','cols'=>'20', 'class'=>'','counter'=>$count,'label'=>false,'placeholder'=>'Reassessment of site','value'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['site_reassesment'])); ?></td>
	<td>
	</td>
	<td>
	</td>
	</tr>
	</table>
	<div class="btns">
		<?php if((empty($getVerifyMedicationOrder['VerifyMedicationOrder']['created_by']) && $getVerifyMedicationOrder['VerifyMedicationOrder']['created_by']==$this->Session->read('userid')) || ($roleNurse=='Nurse') || ($roleNurse!='Primary Care Provider')){
			echo $this->Form->submit('Save',array('class'=>'blueBtn','div'=>false,'title'=>'Save','id'=>'saveResult'));
		}else{
 			echo $this->Html->link(__('Co-sign'),'javascript:void(0);',array('escape' => false,'title'=>'ePrescribe','class'=>'blueBtn cosign_chkCls','id'=>'cosign_chkBtn')); //,'onclick'=>'javascript:alertmsg();'
			echo $this->Form->input('VerifyMedicationOrder.cosign_chk', array('type'=>'checkbox','id' => 'cosign_chk','class'=>'cosign_chkCls','label'=>false,'style'=>'display:none;','checked'=>$getVerifyMedicationOrder['VerifyMedicationOrder']['cosign_chk'])); 
		}?>	
	</div>
	<?php echo $this->Form->end(); ?>

	<script>
		$(document).ready(function(){
			$('.verifySuccess').click(function (){
				var toggleId = $(this).attr('class');
				var id= $(this).attr('id'); 
				var patientUniqueid=$("#patient_id").val();
				var newcrop_id=$("#newcrop_id").val();
				var verify_id=$("#verify_id").val();
				var created_by=$("#created_by").val();
				var value;
				if(id=='verifySuccessid'){
					$('#verified_chk').attr('checked', true);
			    	value=1;
			    }else{			    	
			    	$('#verified_chk').attr('checked', false);
					value=0;
			    }
				$('.'+toggleId).toggle();
				$.ajax({
					  type : "POST",
					  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "saveVerifiedMedication", "admin" => false)); ?>",
					  context: document.body,
					  beforeSend:function(){
			 			  	// this is where we append a loading image
			 			  	$('#busy-indicator').show('fast');},
					  data:"verify_id="+verify_id+"&newcrop_id="+newcrop_id+"&patient_id="+patientUniqueid+"&value="+value+"&created_by="+created_by,
					 success: function(data){ 						 
						 alert('Verified successfully');
						 $('#busy-indicator').hide('fast');
						  parent.location.reload(true); 
				   }		  			  
				});
			  	 return true;     
			}); 
			
		$('.tolerated_procedureCls:radio').click(function(){	
				if($(this).val() =='Other'){					
					$('#tolerated_procedure_other').show();					
				}else{						
					$('#tolerated_procedure_other').hide();	
					$('#tolerated_procedure_other').val("");	
					}
				});
		});

		$('.cosign_chkCls').click(function (){	
			var toggleId = $(this).attr('class');
			var id= $(this).attr('id');
			var patientUniqueid=$("#patient_id").val();
			var newcrop_id=$("#newcrop_id").val();
			var verify_id=$("#verify_id").val();
			var created_by=$("#created_by").val();
			var value;
			if(id=='cosign_chkBtn'){
				$('#cosign_chk').attr('checked', true);
		    	value=1;
		    }else{			    	
		    	$('#cosign_chk').attr('checked', false);
				value=0;
		    }
			$('.'+toggleId).toggle();
			$.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "saveCosignChk", "admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
		 			  	// this is where we append a loading image
		 			  	$('#busy-indicator').show('fast');},
				  data:"verify_id="+verify_id+"&newcrop_id="+newcrop_id+"&patient_id="+patientUniqueid+"&cosign_chk_sign="+value+"&created_by="+created_by,
				 success: function(data){ 						 
					 alert("Signed succesfully by physician");
					 $('#busy-indicator').hide('fast');
					 window.location.href="<?php echo $this->Html->url(array("controller" => "appointments", "action" => "appointments_management", "admin" => false)); ?>"
					 // parent.location.reload(true); 
			   }		  			  
			});
		  	 return true;    
			
			
		});
		
		$('#saveResult').click(function(){
				var verified_chkvar= "<?php echo $getVerifyMedicationOrderverified_chk;?>"; //$('.verified_chkCls').val(); 
				if(verified_chkvar!='1' || verified_chkvar==null){
					alert("Please Verify Patient to save data");	
					return false;
				}
		});


		
		$('.patientRefused').click(function (){
			var patientId = '<?php echo $patientId; ?>';
			var newCropId = '<?php echo $newCropId; ?>';
			var status=1;

			 $.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "refuseTakeImmunization", "admin" => false)); ?>"+"/"+patientId+"/"+newCropId,
				  context: document.body,
				  data: "refusetotakeimmunization="+status,
				  success: function(data){ 
					 // inlineMsg(currentId,'updated successfully');
					  window.location.href="<?php echo $this->Html->url(array("controller"=>'Appointments',"action" => "appointments_management"));?>"; 				 
				  }
			});	
		});
		</script>