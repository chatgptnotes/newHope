<?php echo $this->Html->script(array('ui.datetimepicker.3.js','inline_msg','jquery.fancybox-1.3.4'));
	  echo $this->Html->script('jquery.autocomplete');?>
<?php echo $this->Html->css(array('jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));?>


<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?>
  </td>
 </tr>
</table>
<?php } ?>
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PsychologyHistoryFrm").validationEngine();
	});
	
</script>

<div class="inner_title"  >
	<h3><?php echo __('Psychiatric Evaluation'); ?></h3>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"patients","action"=>"patient_information",$patient['Patient']['id']),array('escape'=>false,'class'=>'blueBtn','title'=>'Back')); ?></span>
	
</div>

<?php echo $this->element('patient_information');//print_patient_header ?>
<?php echo $this->Form->create('PsychologyHistory',array('url'=>array('controller'=>'patientForms','action'=>'psychologyHistory',$patient_id),'type' => 'file','id'=>'PsychologyHistoryFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('id');
echo $this->Form->hidden('patient_id',array('value'=>$patient_id));
echo $this->Form->hidden('PatientPersonalHistory.id',array('value'=>$diagnosis_id));
echo $this->Form->hidden('PatientSmoking.id',array('value'=>$diagnosis_id));
			?>
			
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" style="padding-top: 5px;" align="center">
	 
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Medicaid Number'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.medicaid_number', array('class' => 'textBoxExpnd','id' => 'medicaid_number')); 
		?>
		</td>
		<td width="25%" class="tdLabel" id="boxSpace"><?php echo __('Date of Assessment'); ?></td>
		<td width="25%"> <?php 
        echo $this->Form->input('PsychologyHistory.date_of_assessment', array('type'=>'text', 'id' => 'date_of_assessment', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>
		</td>
	</tr>
	<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="100%" colspan="4">
	<strong><?php echo __('Facility Information'); ?></strong>
	</td>	
	</tr>	

<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Name'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('facility_name', array('value'=>$this->Session->read('facility'),'type'=>'text','class' => 'textBoxExpnd')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Contact Person'); ?> </td>
		<?php $contact_person = $this->Session->read('initial_name').' '.$this->Session->read('first_name').' '.$this->Session->read('last_name'); ?>
		<td width="25%"><?php echo $this->Form->input('contact_person', array('value'=>$contact_person,'class' => 'textBoxExpnd','type'=>'text')); ?>
		</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('TPI'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('tpi', array('class' => 'textBoxExpnd','type'=>'text')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('NPI'); ?> </td>
		<td width="25%"><?php echo $this->Form->input('npi', array('class' => 'textBoxExpnd','type'=>'text')); ?>
		</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Taxonomy'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('taxonomy', array('class' => 'textBoxExpnd','type'=>'text')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Benifit Code'); ?> </td>
		<td width="25%"><?php echo $this->Form->input('benifit_code', array('class' => 'textBoxExpnd','type'=>'text')); ?>
		</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" style="border-bottom: solid 1px #3E474A; ">
	<?php echo __('Address'); ?>
	</td>
		<td width="25%" style="border-bottom: solid 1px #3E474A; "><?php echo $this->Form->input('facility_address', array('class' => 'textBoxExpnd','type'=>'textarea','rows'=>'2','cols'=>'5')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%" style="border-bottom: solid 1px #3E474A; "> </td>
		<td width="25%" style="border-bottom: solid 1px #3E474A; ">
		</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Commitment Type (if applicable)'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.commitment_type', array('class' => 'textBoxExpnd','type'=>'text','id' => 'commitment_type')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Effective Date'); ?> </td>
		<td width="25%"><?php 
        echo $this->Form->input('PsychologyHistory.effective_date', array('type'=>'text', 'id' => 'effective_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>
		</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Country'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.country', array('class' => 'textBoxExpnd','type'=>'text','id' => 'country')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Judge'); ?> </td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.judge', array('class' => 'textBoxExpnd','type'=>'text','id' => 'judge')); ?>
		</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Referral Source'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.referral_source', array('type'=>'checkbox','id' => 'referral_source')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Admitting MD'); ?> </td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.admitting_md', array('type'=>'checkbox','id' => 'admitting_md')); ?>
		</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('MH Professional'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.mh_professional', array('type'=>'checkbox','id' => 'mh_professional')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Other(List)'); ?> </td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.other_chckclick1', array('type'=>'checkbox','id' => 'other_chckclick1')); ?>
		</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Current Living Arrangements'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.living_arrangemnt', array('type'=>'checkbox','id' => 'living_arrangemnt')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('With Parent(s)'); ?> </td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.with_parents', array('type'=>'checkbox','id' => 'with_parents')); ?>
		</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Group/Foster Home'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.grp_home', array('type'=>'checkbox','id' => 'grp_home')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Other(List)'); ?> </td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.other_chckclick2', array('type'=>'checkbox','id' => 'other_chckclick2')); ?>
		</td>
	</tr>
	
	<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="100%" colspan="2">
	<strong><?php echo __('IIA. Primary Symptom Described in "Specific Observable Behavior" that require Acute Hospital Care (Include: Precipitating events leading to admission)'); ?></strong>
	</td>	
	<td class="tdLabel" id="boxSpace" width="100%" colspan="2">
	<strong><?php echo __('IIB. Other Relevant Clinical Information,including Inability to Benefit From Less Restrictive Setting(Attach AdditionalPages or Documents,as necessary)'); ?></strong>
	</td>	
	</tr>
	
	<tr>
		<td colspan="2" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('PsychologyHistory.primary_symptom', array('type'=>'textarea' ,'id' => 'primary_symptom','rows'=>'2','style'=>'width:95%;')); ?> 
		</td>
		
		<td colspan="2" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('PsychologyHistory.clinical_info', array('type'=>'textarea' ,'id' => 'clinical_info','rows'=>'2','style'=>'width:95%;')); ?> 
		</td>
	</tr>	
	
	<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="100%" colspan="4">
	<strong><?php echo __('IIC.Psychiatric Medications (Include Total Daily Doses)'); ?></strong>
	</td>	
	<!-- <td class="tdLabel" id="boxSpace" width="50%" colspan="2">
	<strong><?php //echo __('IID.Present and Past Drug/Alcohol Usage'); ?></strong>
	</td>	 -->
	</tr>
	
	<tr>
		<td colspan="4" class="tdLabel" id="boxSpace" width="100%">
		<!--BOF medicine  -->
		<table style="text-align: left;" width="100%">
			<?php  /* debug($interactionData);exit; */ ?>
			<tr>
				<td width="100%">
					<div id='showInteractions' style='display: none; color: red'></div>
				</td>
			</tr>
			<tr>
				<td width="100%" valign="top" style="padding: 2px;" >
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<!-- row 1 -->
						<tr>
							<td width="100%" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0"	id='DrugGroup'>
									<tr>
										<td width="20%" height="20" align="left" valign="top">Drug
											Name</td>
										<td width="5%" height="20" align="left" valign="top">Dose</td>
										<td width="5%" height="20" align="left" valign="top">Form</td>
										<td width="5%" height="20" align="left" valign="top">Route</td>
										<td width="5%" align="left" valign="top">Frequency</td>
										<td width="5%" align="left" valign="top">Days</td>
										<td width="5%" align="left" valign="top">Qty</td>
										<td width="5%" align="left" valign="top">Refills</td>
										<td width="5%" align="left" valign="top"
											style="padding-left: 20px">PRN</td>
										<td width="5%" align="left" valign="top"
											style="padding-left: 20px">DAW</td>
										<td width="10%" align="center" valign="top">Special
											Instruction</td>
										<td width="5%" align="center" valign="top">Is Active</td>
										<td></td>
									</tr>

									<?php  
 									$currentresult = $psychologyHistoryData['NewCropPrescription'];    
									if(isset($currentresult) && !empty($currentresult)){
			               				$count  = count($currentresult) ;
			               			}else{
			               				$count  = 3 ;

			               			} 
			               			for($i=0;$i<$count;){

										$drug_name_val= isset($currentresult[$i]['drug_name'])?$currentresult[$i]['drug_name']:'' ;
										$drug_id_val= isset($currentresult[$i]['drug_id'])?$currentresult[$i]['drug_id']:'' ;
										$dose_val= isset($currentresult[$i]['dose'])?$currentresult[$i]['dose']:'' ;
										$strength_val= isset($currentresult[$i]['strength'])?$currentresult[$i]['strength']:'' ;
										$route_val= isset($currentresult[$i]['route'])?$currentresult[$i]['route']:'' ;
										$frequency_val= isset($currentresult[$i]['frequency'])?$currentresult[$i]['frequency']:'' ;
										$day_val= isset($currentresult[$i]['day'])?$currentresult[$i]['day']:'' ;
										$quantity_val= isset($currentresult[$i]['quantity'])?$currentresult[$i]['quantity']:'' ;
										$refills_val= isset($currentresult[$i]['refills'])?$currentresult[$i]['refills']:'' ;
										$prn_val= isset($currentresult[$i]['prn'])?$currentresult[$i]['prn']:'' ;
										$daw_val= isset($currentresult[$i]['daw'])?$currentresult[$i]['daw']:'' ;
										$special_instruction_val= isset($currentresult[$i]['special_instruction'])?$currentresult[$i]['special_instruction']:'' ;
										$isactive_val= isset($currentresult[$i]['archive'])?$currentresult[$i]['archive']:'' ;
										if($isactive_val=='N'){
										$isactive_val='1';
											}
											else{
										$isactive_val='0';
											}
//EOF timer
?>
									<tr id="DrugGroup<?php echo $i;?>">
										<td align="left" valign="top"><?php// echo $i;?> <?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText' ,'id'=>"drugText_$i",'name'=> 'NewCropPrescription[drug_name][]','value'=>$drug_name_val,'autocomplete'=>'off','counter'=>$i,'style'=>'width:250px'));?>
										</td>
										<?php echo $this->Form->hidden('drugId',array('id'=>"drug_$i" ,'name'=>'NewCropPrescription[drug_id][]','value'=>$drug_id_val));?>
										<td align="left" valign="top"><?php echo $this->Form->input('', array( 'empty'=>'Select','options'=>$dose,'style'=>'width:80px','class' => '','id'=>"dose_type$i",'name' => 'NewCropPrescription[dose][]','value'=>$dose_val)); ?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>$strenght,'style'=>'width:120px','class' => '','id'=>"strength$i",'name' => 'NewCropPrescription[strength][]','value'=>$strength_val));?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array( 'empty'=>'Select','options'=>$route,'style'=>'width:120px','class' => '','id'=>"route_administration$i",'name' => 'NewCropPrescription[route][]','value'=>$route_val));?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('frequency'),'empty'=>'Select','style'=>'width:120px','class' => '','id'=>"frequency$i",'name' => 'NewCropPrescription[frequency][]','value'=>$frequency_val)); ?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','id'=>"day$i",'name' => 'NewCropPrescription[day][]','value'=>$day_val)); ?>
										</td>
										<td align="left" valign="top"><?php	echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','id'=>"quantity$i",'name' => 'NewCropPrescription[quantity][]','value'=>$quantity_val)); ?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('refills'),'empty'=>'Select','style'=>'width:80px','class' => '','id'=>"refills$i",'name' => 'NewCropPrescription[refills][]','value'=>$refills_val));  ?>
										</td>
										<td align="center" valign="top"><?php $options = array(''=>'Select','0'=>'No','1'=>'Yes');
										echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:80px','class' => '','id'=>"prn$i",'name' => 'NewCropPrescription[prn][]','value'=>$prn_val));?>
										</td>
										<td align="center" valign="top"><?php echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:80px','class' => '','id'=>"daw$i",'name' => 'NewCropPrescription[daw][]','value'=>$daw_val));?>
										</td>
										<td align="center" valign="top"><?php echo $this->Form->textarea('', array('size'=>2,'type'=>'text','class' => '','id'=>"special_instruction$i",'name' => 'NewCropPrescription[special_instruction][]','value'=>$special_instruction_val));?>
										</td>
										<td align="center" valign="top"><?php $options_active = array(''=>'Select','0'=>'No','1'=>'Yes');
										echo $this->Form->input('', array( 'options'=>$options_active,'style'=>'width:60px','class' => '','id'=>"isactive$i",'name' => 'NewCropPrescription[is_active][]','selected'=>$isactive_val));?></td>
										<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('<?php echo "DrugGroup$i" ?>');"><?php echo $this->Html->image('/img/cross.png');?></a></td>
									
									</tr>
									<?php
									$i++ ;
			               			}
			               			?>

								</table>
							</td>
						</tr>
						<!-- row 3 end -->
						<tr>
							<td align="right"><input type="button" id="addButton" value="Add">
								 <?php //  if($count > 0){?>
							 		<!--  <input type="button" id="removeButton" value="Remove"> -->
							 	 <?php // }else{ ?>
							 		 <!-- <input type="button" id="removeButton" value="Remove" style="display: none;">-->
								 <?php // } ?>
							 </td>
						</tr>

					</table>
				</td>
			</tr>
		</table>
		<!--EOF medicine -->
		</td>
		</tr>	


<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="100%" colspan="4">
	<strong><?php echo __('IID.Present and Past Drug/Alcohol Usage'); ?></strong>
	</td>	
</tr>


	<tr>
		<td colspan="4" class="tdLabel" id="boxSpace" width="100%">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
		<tr>
				
				<td colspan="4" style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						class="tabularForm">
						<?php if($patient['Patient']['age']>=18){?>
						<tr>
							<td valign="top" width="120" colspan='5' style="color: fuchsia;"'>Have you screened for tobbaco use?</td>
						</tr>
						<?php }?>
						<tr>

							<td valign="top" width="12%">Smoking</td>
							<td valign="top" width="13%"><?php 
							if($this->data['PatientPersonalHistory']['smoking']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				//debug($this->data['PatientPersonalHistory']['smoking']);
                        				$smokingPersonalVal = isset($this->data['PatientPersonalHistory']['smoking'])?$this->data['PatientPersonalHistory']['smoking']:2 ;
                        				echo $this->Form->radio('PatientPersonalHistory.smoking', array('No','Yes'),array('value'=>$smokingPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal1','id' => 'smoking'));
                        				 
                        				?></td>
							<td valign="top" ><?php 	
							echo $this->Form->input('PatientPersonalHistory.smoking_desc',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'smoking_desc'));
									 ?>
							</td>

							<td valign="top"  width="25%" style="border-right: solid 1px #3E474A; "><?php 
							echo $this->Form->input('PatientSmoking.patient_id',array('type'=>'hidden','value'=>$patient_id,'legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince '.$class,'id' => ''));

										echo $this->Form->input('PatientSmoking.smoking_fre',array('type'=>'hidden','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince ','id' => ''));

										echo $this->Form->input('SmokingStatusOncs.description',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => '','value'=>$smokingOptions[$this->data['PatientSmoking']['current_smoking_fre']]));//echo'to';

										echo $this->Form->input('PatientSmoking.current_smoking_fre',array('type'=>'hidden','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince ','id' => ''));
										echo $this->Form->input('SmokingStatusOncs1.description',array('type'=>'text','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince '.$class,'id' => '','value'=>$smokingOptions[$this->data['PatientSmoking']['smoking_fre']]));
										echo $this->Form->input('PatientSmoking.smoking_fre2',array('type'=>'hidden','legend'=>false,'label'=>false,
										'class' => 'textBoxExpnd removeSince ','id' => 'smoking_fre_id'));
				                        			 ?></td>
							<td valign="top"  width="25%" ><?php 	

							echo $this->Form->input('PatientPersonalHistory.smoking_fre',array('type' => 'select', 'id' => 'smoking_fre', 'class' => 'removeSince textBoxExpnd', 'empty' => 'Please Select', 'options'=> $smokingOptions, 'label'=> false, 'div'=> false));
							?><span><label id="smoking_info"
									style="cursor: pointer; text-decoration: underline; display: none;"><?php echo __('Fill information');?>
								</label> </span>
							</td>
						</tr>
						<tr>
							<td valign="top">Alcohol</td>
							<td valign="top"><?php
							if($this->data['PatientPersonalHistory']['alcohol']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$alcoholPersonalVal = isset($this->data['PatientPersonalHistory']['alcohol'])?$this->data['PatientPersonalHistory']['alcohol']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.alcohol', array('No','Yes'),array('value'=>$alcoholPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal','id' => 'alcohol'));
			                        			 ?>
							</td>
							<td valign="top"><?php 
							echo $this->Form->input('PatientPersonalHistory.alcohol_desc',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'alcohol_desc'));
				                        			 ?>
							</td>
							<td valign="top" style="border-right: solid 1px #3E474A; "><?php 
							echo $this->Form->input('PatientPersonalHistory.alcohol_fre',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'alcohol_fre_id'));?>


							</td>


							<td valign="top"><?php 	


							$alcoholoption = array(
												'0 bottle per day (non-alcoholic or less than 100 in lifetime)' => '0 bottle per day (non-alcoholic or less than 100 in lifetime)',
												'0 bottle per day (previous alcoholic)' => '0 bottle per day (previous alcoholic)',
												'Few (1-3) bottle per day' => 'Few (1-3) bottle per day',
												'Upto 1 bottle per day' => 'Upto 1 bottle per day',
												'1-2 bottle per day' => '1-2 bottle per day',
												'2 or more bottle per day' => '2 or more bottle per day',
												'Current status unknown' => 'Current status unknown',

										);
										echo $this->Form->input('PatientPersonalHistory.alcohol_fre',array('type' => 'select', 'id' => 'alcohol_fre', 'class' => 'removeSince textBoxExpnd', 'empty' => 'Please Select', 'options'=> $alcoholoption, 'label'=> false, 'div'=> false));
										?><span><label id="alcohol_fill"
									style="cursor: pointer; text-decoration: underline; display: none;"><?php echo __('Fill information');?>
								</label> </span>
							</td>
						</tr>
						<tr>
							<td valign="top">Substance Use</td>
							<td valign="top"><?php 
							if($this->data['PatientPersonalHistory']['drugs']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$drugsPersonalVal = isset($this->data['PatientPersonalHistory']['drugs'])?$this->data['PatientPersonalHistory']['drugs']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.drugs', array('No','Yes'),array('value'=>$drugsPersonalVal,'legend'=>false,'label'=>false,
			                        			 	'class' => 'personal','id' => 'drug'));
			                        			 	?>
							</td>
							<td valign="top"><?php 
							echo $this->Form->input('PatientPersonalHistory.drugs_desc',array('type'=>'text','legend'=>false,'label'=>false,
			                        			 		'class' => 'textBoxExpnd removeSince '.$class,'id' => 'drug_desc'));
			                        				?>
							</td>
							<td valign="top" style="border-right: solid 1px #3E474A; "><?php 
							echo $this->Form->input('PatientPersonalHistory.drugs_fre',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'drug_fre'));
							?>
							</td>
							<td>&nbsp;</td>
						</tr>

						
						
						<tr>
							<td valign="top" style="border-bottom: solid 1px #3E474A; ">Retired</td>
							<td valign="top" style="border-bottom: solid 1px #3E474A; "><?php 
							if($this->data['PatientPersonalHistory']['retired']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				echo $this->Form->radio('PatientPersonalHistory.retired', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient[0]['PatientPersonalHistory']['retired'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
							<td valign="top" style="border-bottom: solid 1px #3E474A; "></td>
							<td valign="top" style="border-bottom: solid 1px #3E474A;border-right: solid 1px #3E474A;"></td>
							<td style="border-bottom: solid 1px #3E474A; "></td>
						</tr>

						<tr>
							<td valign="top">Caffeine Usage</td>
							<td valign="top"><?php 
							if($this->data['PatientPersonalHistory']['tobacco']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$tobaccoPersonalVal = isset($this->data['PatientPersonalHistory']['tobacco'])?$this->data['PatientPersonalHistory']['tobacco']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.tobacco', array('No','Yes'),array('value'=>$tobaccoPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal','id' => 'tobacco'));
			                        			 ?>
							</td>
							<td valign="top"><?php	
							echo $this->Form->input('PatientPersonalHistory.tobacco_desc',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'tobacco_desc'));
							?>
							</td>
							<td valign="top" style="border-right: solid 1px #3E474A; "><?php	
							echo $this->Form->input('PatientPersonalHistory.tobacco_fre',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'tobacco_fre'));
							?>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td valign="top">Diet</td>
							<td valign="top" colspan="3"><?php 
							if($this->data['PatientPersonalHistory']['diet']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$dietPersonalVal = isset($this->data['PatientPersonalHistory']['diet'])?$this->data['PatientPersonalHistory']['diet']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.diet', array('Veg','Non-Veg'),array('value'=>$dietPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal','id' => 'diet'));
			                        			 ?>
							</td>

							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
				<td width="30">&nbsp;</td>
			</tr>
		</table>
		</td>
		</tr>

<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="100%" colspan="4">
	<strong><?php echo __('IIE. Past Psychiatric Treatment'); ?></strong>
	</td>	
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('1. Number of Previous Inpatient Admissions'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.no_of_addmission', array('class' => 'textBoxExpnd','type'=>'text','id' => 'no_of_addmission')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Dates of Most Recent Inpatient Stay'); ?> </td>
		<td width="25%">
		<table>
		<tr>
		<td width="11%"><?php 
        echo $this->Form->input('PsychologyHistory.inpatient_date1', array('type'=>'text', 'id' => 'inpatient_date1', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?></td>
        <td width="3%">
        <?php echo __('To'); ?>
        </td>
        <td width="11%">
        <?php 
        echo $this->Form->input('PsychologyHistory.inpatient_date2', array('type'=>'text', 'id' => 'inpatient_date2', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>
		</td>
		</tr>
		</table>
		</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" colspan="1">
	<?php echo __('Previous Ambulatory/Outpatient Treatment (Provider or Facility, frequency)-If none,Why'); ?></td>
	<td colspan="3"><?php echo $this->Form->input('PsychologyHistory.ambu_treatmnt', array('type'=>'textarea' ,'id' => 'ambu_treatmnt','rows'=>'2','style'=>'width:96%;')); ?> 
		</td>
	</tr>
	
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" colspan="1"><strong>
	<?php echo __('III. Current Diagnosis(Axis I)'); ?></strong></td>
	
	<td colspan="3">
	<?php echo $this->Form->input('PsychologyHistory.current_diag', array('class' => 'textBoxExpnd','type'=>'text' ,'id' => 'current_diag','style'=>'width:96%;')); ?> 
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" colspan="1"><strong>
	<?php echo __('IV. Additional Diagnosis(Axis I and Axis II)'); ?></strong></td>
	
	<td colspan="3">
	<?php echo $this->Form->input('PsychologyHistory.additional_diag', array('class' => 'textBoxExpnd','type'=>'text' ,'id' => 'additional_diag','style'=>'width:96%;')); ?> 
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" colspan="1"><strong>
	<?php echo __('V. Current Functional Assessment Scores(DSM IV) GAF'); ?></strong></td>
	
	<td colspan="3">
	<?php echo $this->Form->input('PsychologyHistory.functional_assessment', array('class' => 'textBoxExpnd','type'=>'text' ,'id' => 'functional_assessment','style'=>'width:96%;')); ?> 
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" colspan="1"><strong>
	<?php echo __('VI. No. of Hospital Days Requested'); ?></strong></td>
	
	<td width="75%" colspan="3">
	<?php echo $this->Form->input('PsychologyHistory.hosp_day', array('class' => 'textBoxExpnd','type'=>'text' ,'id' => 'hosp_day','style'=>'width:96%;')); ?> 
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" colspan="1"><strong>
	<?php echo __('Projected Discharge Date (required)'); ?></strong></td>
	
<td width="75%" colspan="3">
	 <?php 
        echo $this->Form->input('PsychologyHistory.proj_discharge_date', array('type'=>'text', 'id' => 'proj_discharge_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?></td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" colspan="1"><strong>
	<?php echo __('Aftercare Plan'); ?></strong></td>
	
	<td width="75%" colspan="3">
	<?php echo $this->Form->input('PsychologyHistory.aftercare_plan', array('class' => 'textBoxExpnd','type'=>'text' ,'id' => 'aftercare_plan','style'=>'width:96%;')); ?> 
	</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" colspan="1">
	<?php echo __('Provider or Facility'); ?></td>	
	<td colspan="3">
	<?php echo $this->Form->input('PsychologyHistory.provider_or_facility', array('type'=>'textarea' ,'id' => 'provider_or_facility','rows'=>'2','style'=>'width:96%;')); ?> </td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%" colspan="1">
	<?php echo __('Frequency'); ?></td>	
	<td width="75%" colspan="3">
	<?php echo $this->Form->input('PsychologyHistory.frequency', array('class' => 'textBoxExpnd','type'=>'text' ,'id' => 'frequency','style'=>'width:96%;')); ?> 
	</td>
	</tr>
	
	<tr>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php //echo __('Signature(Attending MD)'); ?>
	</td>
		<td width="25%"><?php //echo $this->Form->input('PsychologyHistory.signature', array('class' => 'textBoxExpnd','type'=>'text','id' => 'signature')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Date'); ?> </td>
		<td width="25%"><?php 
        echo $this->Form->input('PsychologyHistory.last_date', array('type'=>'text', 'id' => 'last_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>
		</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Print Name'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.print_name', array('class' => 'textBoxExpnd','type'=>'text','id' => 'print_name')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Provider Licence Number'); ?> </td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.provider_licence_number', array('class' => 'textBoxExpnd','type'=>'text','id' => 'provider_licence_number')); ?> 
		</td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Provider TPI'); ?>
	</td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.provider_tpi', array('class' => 'textBoxExpnd','type'=>'text','id' => 'provider_tpi')); ?> 
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Provider NPI'); ?> </td>
		<td width="25%"><?php echo $this->Form->input('PsychologyHistory.provider_npi', array('class' => 'textBoxExpnd','type'=>'text','id' => 'provider_npi')); ?> 
		</td>
	</tr>	
	</table>
	
	<div class="btns">
		<?php 	echo $this->Html->link(__('Cancel', true),array("controller"=>"patients",'action' => 'patient_information',$patient['Patient']['id']), array('escape' => false,'class'=>'grayBtn'));
				echo "&nbsp;&nbsp;".$this->Form->submit('Sign',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Sign'));
							?>
		</div>
		<?php echo $this->Form->end(); ?>
<script>

//add n remove drud inputs
var counter = <?php echo $count?>;

function deletRow(i){
    $("#"+i).remove();
	counter--;			 
}
$("#addButton")
	.click(
			function() {
				$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup' + counter);

				//var start= '<select style="width:80px;" id="start_date'+counter+'" class="" name="start_date[]"><input type="tex">';
				var str_option_value='<?php echo $str;?>';
								var route_option_value='<?php echo $str_route;?>';
								var dose_option_value='<?php echo $str_dose;?>';
								var dose_option ='<select style="width:80px;" id="dose_type'+counter+'" class="" name="NewCropPrescription[dose][]"><option value="">Select</option>'+dose_option_value;
								var strength_option = '<select style="width:120px;" id="strength'+counter+'" class="frequency" name="NewCropPrescription[strength][]"><option value="">Select</option>'+str_option_value;
								var route_option = '<select style="width:120px;" id="route_administration'+counter+'" class="frequency" name="NewCropPrescription[route][]"><option value="">Select</option>'+route_option_value;
				var frequency_option = '<select style="width:120px;" id="frequency_'+counter+'" class="frequency" name="NewCropPrescription[frequency][]"><option value="">Select</option><option value="as directed">as directed</option><option value="Daily">Daily</option><option value="BID">BID</option><option value="TID">TID</option><option value="QID">QID</option><option value="Q1h WA">Q1h WA</option><option value="Q2h WA">Q2h Wa</option><option value="Q4h">Q4h</option><option value="Q2h">Q2h</option><option value="Q3h">Q3h</option><option value="Q4-6h">Q4-6h</option><option value="Q6h">Q6h</option><option value="Q8h">Q8h</option><option value="Q12h">Q12h</option><option value="Q48h">Q48h</option><option value="Q72h">Q72h</option><option value="Nightly">Nightly</option><option value="QHS">QHS</option><option value="in A.M.">in A.M.</option><option value="Every Other Day">Every Other Day</option><option value="2 Times Weekly">2 Times Weekly</option><option value="3 Times Weekly">3 Times Weekly</option><option value="Q1wk">Q1wk</option><option value="Q2wks">Q2wks</option><option value="Q3wks">Q3wks</option><option value="Once a Month">Once a Month</option><option value="Add\'l Sig">Add\'l Sig</option></select>';
				var refills_option = '<select style="width:80px;" id="refills_'+counter+'" class="frequency" name="NewCropPrescription[refills][]"><option value="">Select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
				var prn_option = '<select style="width:80px;" id="prn'+counter+'" class="" name="NewCropPrescription[prn][]"><option value="">Select</option><option value="0">No</option><option value="1">Yes</option></select>';
				var daw_option = '<select style="width:80px;" id="daw'+counter+'" class="" name="NewCropPrescription[daw][]"><option value="">Select</option><option value="0">No</option><option value="1">Yes</option></select>';
				var active_option = '<select style="width:60px;" id="isactive'+counter+'" class="" name="NewCropPrescription[is_active][]"><option value="">Please select</option><option value="0">No</option><option value="1">Yes</option></select>';
				//var route_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
				var options = '<option value=""></option>';
				for (var i = 1; i < 25; i++) {
					if (i < 13) {
						str = i + 'am';
					} else {
						str = (i - 12) + 'pm';
					}
					options += '<option value="'+i+'"'+'>'
							+ str + '</option>';
				}

				timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
						+ options
						+ '</select></td> ';
				timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
						+ options
						+ '</select></td> ';
				timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
						+ options
						+ '</select></td> ';
				timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
						+ options
						+ '</select></td> ';
				timer = timerHtml1 + timerHtml2
						+ timerHtml3 + timerHtml4
						+ '</tr></table></td>';
				<?php //echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date','name'=> 'start_date[]', 'id' =>"start_date".$i ,'counter'=>$i )); ?>
				var newHTml = '<td valign="top"><input  type="text" style="width:250px" value="" id="drugText_' + counter + '"  class=" drugText  ac_input" name="NewCropPrescription[drug_name][]" autocomplete="off" counter='+counter+'><input  type="hidden"  id="drug_' + counter + '"  name="NewCropPrescription[drug_id][]" ></td><td valign="top">'
				
						+ dose_option
						+ '</td><td valign="top">'
						+ strength_option
						+ '</td><td valign="top">'
						+ route_option
						+ '</td><td valign="top">'
						+ frequency_option
						+ '</td>'
						+ '<td valign="top"><input size="2" type="text" value="" id="day'+counter+'" class="" name="NewCropPrescription[day][]"></td>'
						+ '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'" class="" name="NewCropPrescription[quantity][]"></td>'
						+ '<td valign="top">'
						+ refills_option
						+ '</td>'
						+ '<td valign="top" align="center">'
						+ prn_option
						+ '</td>'
						+ '<td valign="top" align="center">'
						+ daw_option
						+ '</td>'
						+ '<td valign="top" align="center"><textarea id="special_instruction' + counter + '"  name="NewCropPrescription[special_instruction][]"  size="16" counter='+counter+'></textarea></td>'
						+ '<td valign="top" align="center">'
						+ active_option
						+ '</td>'
						+'<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow(\'DrugGroup'+counter+'\');"><?php echo $this->Html->image('/img/cross.png');?></a></td>'
						;

				newCostDiv.append(newHTml);		 
				newCostDiv.appendTo("#DrugGroup");		
				$("#diagnosisfrm").validationEngine('attach'); 			 			 
				counter++;
				if(counter > 0) $('#removeButton').show('slow');
		     });
		 
		     $("#removeButton").click(function () {
			     alert(this.id);
					/*if(counter==3){
			          alert("No more textbox to remove");
			          return false;
			        }   	*/		 
					counter--;			 
			 
			        $("#DrugGroup" + counter).remove();
			 		if(counter == 0) $('#removeButton').hide('slow');
			  });
			  //EOF add n remove drug inputs
$('.drugText')
	.live(
			'focus',
			function() {
				var currentId=	$(this).attr('id').split("_"); // Important
				var attrId = this.id;
				var counter = $(this).attr(
						"counter");
				if ($(this).val() == "") {
					$("#Pack" + counter).val("");
				}
				$(this)
						.autocomplete(
																															
								"<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','Status=A',"admin" => false,"plugin"=>false)); ?>",
								{
									
									width : 250,
									selectFirst : true,
									valueSelected:true,
									minLength: 3,
									delay: 1000,
									isOrderSet:true,
									showNoId:true,
									loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'dose_type')
									+','+$(this).attr('id').replace("drugText_",'strength')
										+','+$(this).attr('id').replace("drugText_",'route_administration'),
										
									onItemSelect:function(event, ui) {
										//lastSelectedOrderSetItem
										var compositStringArray = lastSelectedOrderSetItem.split("    ");
										if((compositStringArray[1] !== undefined) && (compositStringArray[1] != '')){
											var pharmacyIdArray = compositStringArray[1].split("|");
											var doseId = attrId.replace("drugText_",'dose_type');
											var routeId = attrId.replace("drugText_",'route_administration');
											var strengthId = attrId.replace("drugText_",'strength');
											$("#drug_"+currentId[1]).val(pharmacyIdArray[0]);
											$("#"+strengthId).val(pharmacyIdArray[2]);
											if($("#"+strengthId).val() == ''){
												$("#"+strengthId).append( new Option(pharmacyIdArray[2],pharmacyIdArray[2]) );
												if(pharmacyIdArray[2]!='')
												$("#"+strengthId).val(pharmacyIdArray[2]);
													else
														$("#"+strengthId).val("Select");
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfigueMedication", "admin" => false)); ?>",
													  context: document.body,	
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  	data:{putArea:pharmacyIdArray[2],searchArea:'strength'},		  
													  	success: function(data){
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
											}
											$("#"+routeId).val(pharmacyIdArray[3]);
											if($("#"+routeId).val() == ''){
												$("#"+routeId).append( new Option(pharmacyIdArray[3],pharmacyIdArray[3]) );
												if(pharmacyIdArray[3]!='')
												$("#"+routeId).val(pharmacyIdArray[3]);
													else
														$("#"+routeId).val('Select');
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfigueMedication1", "admin" => false)); ?>",
													  context: document.body,	
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  	data:{putArea:pharmacyIdArray[3],searchArea:'route'},		  
													  	success: function(data){
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
											}
											$("#"+doseId).val(pharmacyIdArray[1]);
											if($("#"+doseId).val() == ''){
												$("#"+doseId).append( new Option(pharmacyIdArray[1],pharmacyIdArray[1]) );
												
												if(pharmacyIdArray[1]!='')
													$("#"+doseId).val(pharmacyIdArray[1]);
												else
													$("#"+doseId).val('Select');
									
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfigueMedication2", "admin" => false)); ?>",
													  context: document.body,	
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  	data:{putArea:pharmacyIdArray[1],searchArea:'dose'},		  
													  	success: function(data){
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
											}
											
											
										}
									}
									
								});
				

			});//EOF autocomplete
			
			
			 $('.foodText').live('focus',function()
					  {   
					  		var counter = $(this).attr("counter");
						    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "getfoodtype","admin" => false,"plugin"=>false)); ?>", {
								width: 250,
								 selectFirst: false,
								 extraParams: {drug:$("#drug"+counter).val() },
						  	});	 
						    
							  
					});//EOF autocomplete
					$('.envText').live('focus',function()
					  {   
					  		var counter = $(this).attr("counter");
						    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "getenvtype","admin" => false,"plugin"=>false)); ?>", {
								width: 250,
								 selectFirst: false,
								 extraParams: {drug:$("#drug"+counter).val() },
						  	});	 
						    
							  
					});//EOF autocomplete
					
					 $('.drugPack').live('focus',function()
					  {   
					  		var counter = $(this).attr("counter");
						    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "getPack","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>", {
								width: 250,
								 selectFirst: false,
								 extraParams: {drug:$("#drug"+counter).val() },
						  	});	 
						    
							  
					});//EOF autocomplete
					$(".drugText").addClass("validate[optional,custom[onlyLetterNumber]]");  
					jQuery("#diagnosisfrm").validationEngine();
					  
					$('.templateText').click(function(){
					  	    //add current text to diagnosis textarea			  	    	  		  
					  		$('#diagnosis').val($('#diagnosis').val()+"\n"+$(this).text());
					  		$('#diagnosis').focus();
					  		$(this).removeAttr("href");
					  		$(this).css('text-decoration','none');
					  		$(this).attr('class','templateadd');
					  		$(this).unbind('click');
					  	 	return false ;
					});
					  
					  
					//new changes for allergies
						$('#Allergies1').click(function(){
							$('#allergy-table').fadeIn('slow');
						});
						$('#Allergies0').click(function(){
							$('#allergy-table').fadeOut('slow');
						});
						
						$('.past:radio').click(function(){
							 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;				 
							 var lowercase = textName.toLowerCase();				 	 
							if($(this).val() =='1'){
								$('#'+lowercase+'_since').fadeIn('slow');
								$('#'+lowercase+'_since').val('Since');
							}else{
								$('#'+lowercase+'_since').fadeOut('slow');
							}
						});
						
						$('.removeSince:input').focus(function(){
							
							if($(this).val() == 'Since' || $(this).val() == 'Frequency'){
								$(this).val('') ;
							}
						});
						
						$('.personal:radio').click(function(){
		                     
							 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;				 
							 var lowercase = textName.toLowerCase();
							//alert($(this).val());
							if($(this).val() =='1'){
								$('#'+lowercase+'_desc').fadeIn('slow');	
								$('#'+lowercase+'_desc').val('Since');			 
								$('#'+lowercase+'_fre').fadeIn('slow');	
								$('#'+lowercase+'_info').fadeIn('slow');
								$('#'+lowercase+'_fill').fadeIn('slow');	
								$('#'+lowercase+'_smoke_fill').fadeIn('slow');
								$('#'+lowercase+'_alco_info').fadeIn('slow');
								//$('#'+lowercase+'_fre').val('Frequency');
								$('#'+lowercase+'_fre option').each(function(key,val) {  
									if ( key == 4 ) {
							            $(this).attr('disabled', true) ;   
							        }else{  
							            $(this).attr('disabled', false) ;
							        }   
						    	});
							}else{
								$('#'+lowercase+'_desc').fadeOut('slow');
								$('#'+lowercase+'_info').fadeOut('slow');
								$('#'+lowercase+'_fill').fadeOut('slow');
								$('#'+lowercase+'_fre').fadeOut('slow');
								$('#'+lowercase+'_smoke_fill').fadeOut('slow');
								$('#'+lowercase+'_alco_info').fadeOut('slow');
								$('#'+lowercase+'_fre_id').fadeOut('slow');
								$('#'+lowercase+'_fre option').each(function(key,val) { 
							        if ( key != 4 ) {
							            $(this).attr('disabled', true) ;   
							        }
							    });
							}
						});
						$('.personal1:radio').click(function(){
		                    
							 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;				 
							 var lowercase = textName.toLowerCase();
							//alert($(this).val());
							if($(this).val() =='1'){
								var currentId='Smoking1';
							 
								inlineMsg(currentId,'Tobbaco use cessation counseling to be done..');
								$('#'+lowercase+'_desc').fadeIn('slow');	
								$('#'+lowercase+'_desc').val('Since');			 
								$('#'+lowercase+'_fre').fadeIn('slow');	
								$('#'+lowercase+'_info').fadeIn('slow');
								$('#'+lowercase+'_fill').fadeIn('slow');	
								$('#'+lowercase+'_smoke_fill').fadeIn('slow');
								$('#'+lowercase+'_alco_info').fadeIn('slow');
								//$('#'+lowercase+'_fre').val('Frequency');
								$('#'+lowercase+'_fre option').each(function(key,val) {
									if ( key == 4 ) {
							            $(this).attr('disabled', true) ;   
							        }else{  
							            $(this).attr('disabled', false) ;
							        }    
							    });
							    
							}else{
								$('#'+lowercase+'_desc').fadeOut('slow');
								$('#'+lowercase+'_info').fadeOut('slow');
								$('#'+lowercase+'_fill').fadeOut('slow');
								$('#'+lowercase+'_fre').fadeIn('slow');
								
								$('#'+lowercase+'_fre option').each(function(key,val) { 
							        if ( key != 4 ) {
							            $(this).attr('disabled', true) ;   
							        }else{
							        	$(this).attr('disabled', false) ;   
							        }
							        
							    });
							    
								$('#'+lowercase+'_smoke_fill').fadeOut('slow');
								$('#'+lowercase+'_alco_info').fadeOut('slow');
								$('#'+lowercase+'_fre_id').fadeOut('slow');
							}
						});
						//EOF new changes for allergies
						//BOF timer
						$('.frequency').live('change',function(){
							
							id 	= $(this).attr('id');
							 
							currentCount 	= id.split("_");
							currentFrequency= $(this).val();
							$('#first_'+currentCount[2]).val('');
							$('#second_'+currentCount[2]).val('');
							$('#third_'+currentCount[2]).val('');
							$('#forth_'+currentCount[2]).val('');
							 
							//set timer
		       				switch(currentFrequency){       					
		       					case "BD":     	
		       						$('#first_'+currentCount[2]).removeAttr('disabled');
		       						$('#second_'+currentCount[2]).removeAttr('disabled');
		       						$('#third_'+currentCount[2]).attr('disabled','disabled');       					 
		       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
		       						break;
		       					case "TDS":
		       						$('#first_'+currentCount[2]).removeAttr('disabled');
		       						$('#second_'+currentCount[2]).removeAttr('disabled');
		       						$('#third_'+currentCount[2]).removeAttr('disabled');       						  						
		       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
		       						break;
		       					case "QID":
		       						$('#first_'+currentCount[2]).removeAttr('disabled');
		       						$('#second_'+currentCount[2]).removeAttr('disabled');
		       						$('#third_'+currentCount[2]).removeAttr('disabled');
		       						$('#forth_'+currentCount[2]).removeAttr('disabled');       						
		       						break;
		       					case "OD":
		       					case "HS":
		       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
		       						$('#second_'+currentCount[2]).attr('disabled','disabled');
		       						$('#third_'+currentCount[2]).attr('disabled','disabled');
		       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
		           					break;
		           				case "Once fort nightly":
		       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
		       						$('#second_'+currentCount[2]).attr('disabled','disabled');
		       						$('#third_'+currentCount[2]).attr('disabled','disabled');
		       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
		           					break;
		           				case "Twice a week":
		       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
		       						$('#second_'+currentCount[2]).attr('disabled','disabled');
		       						$('#third_'+currentCount[2]).attr('disabled','disabled');
		       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
		           					break;
		           				case "Once a week":
		       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
		       						$('#second_'+currentCount[2]).attr('disabled','disabled');
		       						$('#third_'+currentCount[2]).attr('disabled','disabled');
		       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
		           					break;
		           				case "Once a month":
		       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
		       						$('#second_'+currentCount[2]).attr('disabled','disabled');
		       						$('#third_'+currentCount[2]).attr('disabled','disabled');
		       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
		           					break;  
		           				case "A/D":
		       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
		       						$('#second_'+currentCount[2]).attr('disabled','disabled');
		       						$('#third_'+currentCount[2]).attr('disabled','disabled');
		       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
		           					break;      					
		       				}
							
						});	

$(document).ready(function(){
	$("#smoking_fre").change(function(){ 
		 $("#smoking_fre_id").val($(this).val());
	});
		
	$('#medicaid_number').focus();
	
	$("#date_of_assessment,#dob,#doa,#payment_post_date,#effective_date,#inpatient_date1,#inpatient_date2,#proj_discharge_date,#last_date")
	.datepicker(
			{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
			$(this).focus();
			}

		});		
	 });
	 
$('#smoking_info').click(function (){
	
	$.fancybox({
		'width' : '70%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "alcohal_cessation_assesment",$patient['Patient']['id'])); ?>"
});
});
	 $('#alcohol_fill').click(function (){
		$.fancybox({
			'width' : '70%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "alcohal_assesment",$patient['Patient']['id'])); ?>"
	});
});

	 $('#smoking_alco_info').click(function (){
			$.fancybox({
				'width' : '70%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "alcohal_cessation_assesment",$patient['Patient']['id'])); ?>"
		});
		});
			 $('#alcohol_smoke_fill').click(function (){
				$.fancybox({
					'width' : '70%',
					'height' : '100%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "alcohal_assesment",$patient['Patient']['id'])); ?>"
					
			});
		});
	 
</script>
