<?php $this->layout = "advance";?>
<style>
label{
padding-top:0;
text-align:left;
width:100%;
}</style>
<?php echo $this->Html->script(array('permission')); ?>
<?php $splitDate = explode(' ',$patient['Patient']['form_received_on']);?>
<script>
var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
var explode = admissionDate.split('-');

$(document).ready(function(){ 
	addCalenderOnDynamicField(); //default calender field
});

function addCalenderOnDynamicField(){
	$(".ConsultantDate, .ServiceDate").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',				 
		dateFormat:'dd/mm/yy HH:II:SS',
		minDate : new Date(explode[0],explode[1] - 1,explode[2]), 
	}); 
}

 function checkApplyInADay(tarrifListID,standardId,tmp,apply_in_a_day){
	var count = 0;
	 if($.trim(apply_in_a_day)!="" && parseInt(apply_in_a_day)>0){
	  	if(parseInt(apply_in_a_day)>3)
	  		apply_in_a_day =3;
	  	var arr = new Array("morning"+tmp,"evening"+tmp,"night"+tmp);
		if($("#morning"+tmp).attr("checked")==true)
			count = count+1;
		if($("#evening"+tmp).attr("checked")==true)
			count = count+1;
		if($("#night"+tmp).attr("checked")==true)
			count = count+1;		
  		if(parseInt(apply_in_a_day) == count){
  			if($("#morning"+tmp).attr("checked")!=true)
  				$("#morning"+tmp).attr("disabled","disabled")
  			if($("#evening"+tmp).attr("checked")!=true)
  				$("#evening"+tmp).attr("disabled","disabled")
  			if($("#night"+tmp).attr("checked")!=true)
  				$("#night"+tmp).attr("disabled","disabled")
 		}else if(count < parseInt(apply_in_a_day)){
			if($("#morning"+tmp).attr("checked")!=true)
  				$("#morning"+tmp).removeAttr("disabled", "disabled");
  			if($("#evening"+tmp).attr("checked")!=true)
  				$("#evening"+tmp).removeAttr("disabled", "disabled");
  			if($("#night"+tmp).attr("checked")!=true)
  				$("#night"+tmp).removeAttr("disabled", "disabled");
		}			
   }
 }

 function defaultNoOfTimes(id,tariffListId){
		currentCount = Number($('#noOfTimes' + tariffListId).val()) ;		
		if($('#' + id).is(":checked")){			
			$('#noOfTimes' + tariffListId).val(currentCount+1);
		}else{
			if(currentCount > 0) 
				$('#noOfTimes' + tariffListId).val(currentCount-1);
			else
				$('#noOfTimes' + tariffListId).val('');
		}
	 }	
</script>


<div class="inner_title">
<h3>&nbsp; <?php echo __('Generate Invoice', true); ?></h3>
<span></span></div>

<div class="patient_info"><?php echo $this->element('patient_information');?>
</div>
<!-- 
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="patientHub">
                   		<tbody><tr>
                        	<th>Patient Information</th>
                        </tr>
                        <tr>
                        	<td>
                   				<table width="100%" cellspacing="0" cellpadding="0" border="0">
								
                   					<tbody><tr>
									 											
									 	<?php if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$photo) && !empty($photo)){ ?>
                                    	<td width="111" valign="top"><?php echo $this->Html->image("/uploads/patient_images/thumbnail/".$photo, array('width'=>'100')); ?></td>
										<?php }else {
											if($patient['Patient']['sex'] == 'male'){ ?>
											<td width="111" valign="top"><?php echo $this->Html->image("/img/icons/male-thumb.gif"); ?></td>
										<?php } else {  ?>
											<td width="111" valign="top"><?php echo $this->Html->image("/img/icons/female-thumb.gif"); ?></td>
										<?php } } ?> 
										 

                                      	<td width="15">&nbsp;</td>
                                        <td width="230" valign="top">
                                        	<p class="name"><?php echo $patient['Patient']['lookup_name'];?></p>
                                            <p class="address"></p>
                                      	</td>
                                        <td width="20">&nbsp;</td>
                                        <td valign="middle">
                                        	<table width="100%" cellspacing="1" cellpadding="0" border="0" class="patientInfo">
                   								<tbody><tr class="darkRow">
                                                	<td width="270" style="min-width: 270px;">
                                                    	<div class="heading"><strong><?php echo __('Patient ID');?></strong></div>
                                                        <div class="content"><?php echo $patient['Patient']['patient_id'];?></div>
                                                    </td>
                                                    <td width="270" style="min-width: 270px;">
														<div class="heading"><strong><?php echo __('Registration ID');?></strong></div>
                                                        <div class="content"><?php echo $patient['Patient']['admission_id'];?></div>                                                    	
                                                    </td>
                                                </tr>
                                                <tr class="lightRow">
                                                	<td>
                                                    	<div class="heading"><strong><?php echo __('Sex');?></strong></div>
                                                        <div class="content"><?php echo ucfirst($patient['Patient']['sex']);?></div>
                                                    </td>
                                                    <td>
                                                    	<div class="heading"><strong><?php echo __('Registration Date');?></strong></div>
                                                    	<?php $last_split_date_time = explode(" ",$patient['Patient']['form_received_on']);
	            										//pr($last_split_date_time);exit;	
                                                    	?>
                                                        <div class="content"><?php echo  $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></div>
                                                    </td>
                                                </tr>
                                                <tr class="darkRow">
                                                	<td>
                                                    	<div class="heading"><strong><?php echo __('Age');?></strong></div>
                                                        <div class="content"><?php echo $patient['Patient']['age'];?></div>
                                                    </td>
                                                    <td>
                                                    	<div class="heading"><strong><?php echo __('Patient Category');?></strong></div>
                                                        <div class="content"><?php echo $corporateEmp;?></div>
                                                    </td>
                                                </tr>
																						 <tr class="lightRow">
                                                	<td>
                                                    	<div class="heading"><strong><?php echo __('Address');?></strong></div>
                                                        <div class="content"><?php echo $address;?></div>
                                                    </td>
                                                    <td>
                                                    	<div class="heading"><strong>&nbsp;</strong></div>
                                                        <div class="content">&nbsp;</div>
                                                    </td>
                                                </tr>
												 

                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                   </tbody></table>
                   -->

<!-- two column table end here -->
<table style="margin-bottom: 30px;" width="100%" align="right"
	cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><?php  
		echo $this->Html->link(__('Interim Payment'),array('action' => 'advancePayment',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn','id'=>'advancePayment','style'=>'margin-left:0px;'));
		?> <?php
		//Comment by pankaj
		// if($patient['Patient']['admission_type']!='OPD'){
		echo $this->Html->link(__('Finalization of Invoice'),array('action' => 'dischargeBill',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn','id'=>'dischargeBill','style'=>'margin-left:0px;'));
		// }
		?> <?php
		if($patient['Patient']['is_discharge']==1){
		    if($patient['Patient']['admission_type'] == "OPD") {
			 echo $this->Html->link(__('Revoke'),array('action' => 'revokeDischarge',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn','id'=>'revokeDischarge','style'=>'margin-left:0px;'));
			} else {
			 echo $this->Html->link(__('Revoke Discharge'),array('action' => 'revokeDischarge',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn','id'=>'revokeDischarge','style'=>'margin-left:0px;'));
			}
		}
		?></td>
	</tr>
</table>
<br />
<!-- date section start here -->
		<?php
		//if($patient['Patient']['admission_type']!='OPD' && $patient['Patient']['is_discharge']!=1){
		if($patient['Patient']['is_discharge']!=1){
			?>
<table width="100%" align="right" cellpadding="0" cellspacing="0"
	border="0">
	<tr>
		<!-- <td width="22">
		<input type="radio" id="servicesSectionBtn" name="billtype" value="Services" checked="checked" autocomplete="off" />
		</td>
		<td width="65" class="tdLabel2">Services</td> -->
		
		<td width="85">
	      <label>
	         <input type="radio" name="billtype" value="Services"  id="servicesSectionBtn" checked="checked" autocomplete="off" />
	         Services
	     </label>
        </td>
		
		<td width="171">
	      <label>
	         <input type="radio" name="billtype" value="Consultant"  id="consultantSectionBtn" autocomplete="off" />
	        <?php if($patient['Patient']['admission_type']=='OPD'){?>
			Consultation for OPD
			<?php }else{?>
			Consultant Visit
			<?php }?>
	     </label>
        </td>
		 
		<!-- <td width="22">
		<input type="radio" id="consultantSectionBtn" name="billtype" value="Consultant" autocomplete="off" />
		</td>
			<?php //if($patient['Patient']['admission_type']=='OPD'){?>
		<td width="140" class="tdLabel2">Consultation for OPD</td>
		<?php //}//else{?>
		<td width="110" class="tdLabel2">Consultant Visit</td>
		<?php //}?> -->
	
		
		<td width="95">
	      <label>
	         <input type="radio" name="billtype" id="pharmacy-sectionBtn" value="Pharmacy" autocomplete="off" />
	         Pharmacy
	     </label>
        </td>
		
		<!-- <td width="25">
		<input type="radio" name="billtype" id="pharmacy-sectionBtn" value="Pharmacy" autocomplete="off" />
		</td>
		<td width="80" class="tdLabel2">Pharmacy</td> -->

		<td width="95">
	      <label>
	         <input type="radio" name="billtype" id="pathologySectionBtn" value="Pathology" autocomplete="off" />
	         Laboratory
	     </label>
        </td>
        
		<!-- <td width="22">
		<input type="radio" name="billtype" id="pathologySectionBtn" value="Pathology" autocomplete="off" />
		</td>
		<td width="75" class="tdLabel2">Laboratory</td> -->
		
		
		<td width="144">
	      <label>
	         <input type="radio" name="billtype" id="radiologySectionBtn" value="Radiology" autocomplete="off" />
	        Other Radiology
	     </label>
        </td>
        
		<!-- <td width="22">
		<input type="radio" name="billtype" id="radiologySectionBtn" value="Radiology" autocomplete="off" />
		</td>
		<td width="100" class="tdLabel2">Other Radiology</td> -->
		
		<td width="58">
	      <label>
	         <input type="radio" name="billtype" id="Mri-sectionBtn" value="Mri" autocomplete="off" />
	     	 MRI
	     </label>
        </td>
		
		<!-- <td width="25">
		<input type="radio" name="billtype" id="Mri-sectionBtn" value="Mri" autocomplete="off" />
		</td>
		<td width="30" class="tdLabel2">MRI</td> -->
		
		<td width="49">
	      <label>
	         <input type="radio" name="billtype" id="Ct-sectionBtn" value="Ct" autocomplete="off" />
	     	 CT
	     </label>
        </td>
        
		<!-- <td width="25">
		<input type="radio" name="billtype" id="Ct-sectionBtn" value="Ct" autocomplete="off" />
		</td>
		<td width="30" class="tdLabel2">CT</td> -->
		
		<td width="79">
	      <label>
	         <input type="radio" name="billtype" id="implant-sectionBtn" value="Implant" autocomplete="off" />
	     	Implant
	     </label>
        </td>
		
		<!-- <td width="25">
		<input type="radio" name="billtype" id="implant-sectionBtn" value="Implant" autocomplete="off" />
		</td>
		<td width="50" class="tdLabel2">Implant</td> -->
		
		<td width="129">
	      <label>
	         <input type="radio" name="billtype" id="otherServicesSectionBtn" value="Pharmacy" autocomplete="off" />
	     	Other Services
	     </label>
        </td>

		<!--  <td width="25">
		<input type="radio" name="billtype"id="otherServicesSectionBtn" value="Pharmacy" autocomplete="off" />
		</td>
		<td width="120" class="tdLabel2">Other Services</td>-->

		<td>&nbsp;</td>
		<td class="tdLabel"><!-- Date --></td>
		<td width="140"><?php //echo date('d/m/Y')?></td>
		<td width="25" align="right"></td>
	</tr>
</table>
		<?php }?>
<!-- date section end here -->
		<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'consultantBilling','type' => 'file','id'=>'ConsultantBilling','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
		)
		));
		echo $this->Form->hidden('ConsultantBilling.patient_id',array('value'=>$patient['Patient']['id']));
		?>
	
	
	<!-- BOF Consultant Section -->
<table id="consultantSection" width="100%" style="display: none">
	<tr>
		<td></td>
	</tr>
	<tr>
		<td>
		<table width="100%" style="margin-top: 70px;" cellpadding="0"
			cellspacing="1" border="0" class="tabularForm" align="center" id="consulTantGrid">
			<tr>
				<th width="230"><?php echo __('Date');?></th>
				<th width="250"><?php echo __('Type');?></th>
				<th width="250" style=""><?php echo __('Name');?></th>
				<th width="250" style=""><?php echo __('Service Group/Sub Group');?></th>
				<th width="250" style=""><?php echo __('Service');?></th>
				<th width="250" style=""><?php echo __('Hospital Cost');?></th>
				<th width="80"><?php echo __('Amount');?></th>
				<th width="80"><?php echo __('Action');?></th>
			</tr>
			<?php $totalAmount=0;
			foreach($consultantBillingData as $consultantData){ 
				?>
			<tr>
				<td valign="middle"><?php //echo $consultantData['ConsultantBilling']['date'] ;
				if(!empty($consultantData['ConsultantBilling']['date']))
				echo $this->DateFormat->formatDate2Local($consultantData['ConsultantBilling']['date'],Configure::read('date_format'),true);
				?></td>
				<td valign="middle"><?php 
				$totalAmount = $consultantData['ConsultantBilling']['amount'] + $totalAmount;
				if($consultantData['ConsultantBilling']['category_id']==0){
					echo 'External Consultant';
				}else if($consultantData['ConsultantBilling']['category_id'] ==1){
					echo 'Treating Consultant';
				}
				?></td>
				<td valign="middle" style="text-align: left;"><?php
				if($consultantData['ConsultantBilling']['category_id'] == 0){
					echo $allConsultantsList[$consultantData['ConsultantBilling']['consultant_id']];
				}else if($consultantData['ConsultantBilling']['category_id'] == 1){
					echo $allDoctorsList[$consultantData['ConsultantBilling']['doctor_id']];
				}
				?></td>


				<td valign="middle"><?php echo $consultantData['ServiceCategory']['name']."/".$consultantData['ServiceSubCategory']['name'];?>
				</td>
				<td valign="middle"><?php echo $consultantData['TariffList']['name'];?>
				</td>
				<td valign="middle" style="text-align: center;">---</td> 

				<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($consultantData['ConsultantBilling']['amount']);?>
				</td>
				<td valign="middle" style="text-align: center;"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteConsultantCharges', $consultantData['ConsultantBilling']['id'],$consultantData['ConsultantBilling']['patient_id']), array('escape' => false),__('Are you sure?', true));?>
				</td>
			</tr>
			<?php }
			?>
				
			<tr id="row1">
				<td valign="top" width="260">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php echo $this->Form->input('', array('type'=>'text','id' => 'ConsultantDate1','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd ConsultantDate',
					'style'=>'width:117px;','readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ConsultantBilling][date][]')); ?>
				</td>
			
				<td valign="top">
					<?php echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd category_id','div' => false,'label' => false,'empty'=>__('Please select'),'options'=>array('External Consultant','Treating Consultant'),
					'id' => 'category_id1','style'=>'width:152px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][category_id][]',"onchange"=>"categoryChange(this)")) ?>
				</td> 
				<td valign="top" style="text-align: left;">
					<?php echo $this->Form->input('ConsultantBilling.doctor_id', array('class' =>
					 'validate[required,custom[mandatory-select]] textBoxExpnd doctor_id','div' => false,'label' => false,'empty'=>__('Please Select'),
					 'options'=>array(''),'id' => 'doctor_id1','style'=>'width:152px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][doctor_id][]',
					 "onchange"=>"doctor_id(this)")); ?>
				</td> 
				<td valign="top" style="text-align: left;">
					<select
						onchange="getListOfSubGroup(this);"
						name="data[ConsultantBilling][service_category_id][]"
						id="service-group-id1" style="width:167px;" class="textBoxExpnd service-group-id"  fieldNo="1">
						<option value="">Select Service Group</option>
						<?php
	
						foreach($service_group as $key =>$value){
							?>
						<option value="<?php echo $value['ServiceCategory']['id'];?>"><?php echo $value['ServiceCategory']['name'];?></option>
					<?php } ?>
					</select>
					<br />
					<select id="service-sub-group1" name="data[ConsultantBilling][service_sub_category_id][]" style="width:167px;" 
						fieldNo="1" class="textBoxExpnd service-sub-group"	onchange="serviceSubGroup(this)" >
					</select>
				</td>
				<td valign="top" style="text-align: left;">
					<?php  echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd consultant_service_id',
								'div' => false,'label' => false,'empty'=>__('Please Select'),'options'=>array(''),'id' => 'consultant_service_id1',
								'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][consultant_service_id][]' ,
								"onchange"=>"consultant_service_id(this)"));
					?> 
				</td>
				<td valign="top" style="text-align: center;">
					<?php  echo $this->Form->input('', array('class' => 'textBoxExpnd','type'=>'select','options'=>array('private'=>'Private','cghs'=>'CGHS','other'=>'Other'),
								'div' => false,'label' => false,'empty'=>__('Please Select'),'id' => 'hospital_cost',
								'style'=>'width:130px;','name'=>'data[ConsultantBilling][hospital_cost][]' ,  ));
					?>
					<div id="hospital_cost_area" style="padding-top:5px;">
						<span id="private" style="display:none"></span>
						<span id="cghs" style="display:none"></span>
						<span id="other" style="display:none"></span>
					</div>
				</td> 
				<td valign="top" style="text-align: center;"><?php echo $this->Form->input('amount',array('class' => 'validate[required,custom[onlyNumber]] amount textBoxExpnd','legend'=>false,'label'=>false,'id' => 'amount1','style'=>'width:80px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][amount][]')); 
				?></td>
				<td valign="top" style="text-align:center;">  </td>  
			</tr>

			<tr id="ampoutRow">
				<td colspan="6" valign="middle" align="right"><?php echo __('Total Amount');?></td>
				<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmount);?>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center">
			<tr>
				 <td width="50%"><input name="" type="button" value="Add More Visits" class="blueBtn addMore" tabindex="17" onclick="addConsultantVisitElement();"/> &nbsp;&nbsp;<input name="removeVisit" type="button" value="Remove" class="blueBtn" tabindex="17" onclick="removeConsultantVisitElement();" id="removeVisit" style="visibility:hidden"/></td>
                           
				<td width="50%" align="right"><input class="blueBtn" type="submit"
					value="Save" id="saveConsultantBill"> <?php echo $this->Html->link(__('Cancel'),'#', array('id'=>'consultantCancel','escape' => false,'class'=>'blueBtn'));?>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>
				<?php echo $this->Form->end(); ?>
				
				
				
				
				
				
				
				
				
				
				
<!--  pathology section start-->
<div id="pathologySection"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">

<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php 
		echo $this->Html->link(__('Request Test'),array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('return'=>'invoice')), array('escape' => false,'class'=>'blueBtn'));
		?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table class="tabularForm" style="position: relative; width: 100%"
	cellspacing="1">
	<tbody>
	<?php if(!empty($lab)){?>
		<tr class="row_title">
			<th class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<?php

		//BOF laboratory
		$i=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
		$lCost = 0 ;
		//debug($lab);
		foreach($lab as $labKey=>$labCost){
			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
			$lCost += $labCost['TariffAmount'][$hosType] ;
			?>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $labCost['Laboratory']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$labCost['LaboratoryTestOrder']['create_time']);
			echo $this->DateFormat->formatDate2Local($labCost['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top"><?php echo $labCost['ServiceProvider']['name'];?></td>
			<td align="right" valign="top"><?php echo $this->Number->currency($labCost['TariffAmount'][$hosType]);?></td>
			<td align="center" valign="top"><?php 
				if($labCost['LaboratoryResult']['confirm_result'] != 1){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
					array('action' => 'deleteLabTest', $labCost['LaboratoryTestOrder']['id'],$labCost['LaboratoryTestOrder']['patient_id']),
					 array('escape' => false),__('Are you sure?', true));
				}
				?></td>
		</tr>
		<?php
		//}
		}
		if($lCost>0){
			?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->format($lCost); ?></h3></div></div>
			 --> Total</td>
			<td align="right"><?php echo $this->Number->currency($lCost); ?></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}?>
		<?php }else{?>
		<tr>
			<td align="center" colspan="4">No Record in Laboratory for <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
		<?php }?>
	</tbody>
</table>
</div>
<!--  pathology section end-->
















<!--  radiology section start-->
<div id="radiologySection"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">

<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php 
		echo $this->Html->link(__('Request Test'),array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('dept'=>'radiology','return'=>'invoice')), array('escape' => false,'class'=>'blueBtn'));
		?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table class="tabularForm" style="position: relative; width: 100%"
	cellspacing="1">
	<tbody>
	<?php if(!empty($rad)){?>
		<tr class="row_title">
			<th class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<?php

		//BOF laboratory
		$i=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
		$rCost = 0 ;
		foreach($rad as $radKey=>$radCost){
			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
			$rCost += $radCost['TariffAmount'][$hosType] ;
			?>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $radCost['Radiology']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$radCost['RadiologyTestOrder']['radiology_order_date']);
			echo $this->DateFormat->formatDate2Local($radCost['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top"><?php echo $radCost['ServiceProvider']['name'];?></td>
			<td align="right" valign="top"><?php echo $this->Number->currency($radCost['TariffAmount'][$hosType]);?></td>
			<td align="center" valign="top"><?php 
				if($radCost['RadiologyResult']['confirm_result'] != 1){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
					array('action' => 'deleteRadTest', $radCost['RadiologyTestOrder']['id'],$radCost['RadiologyTestOrder']['patient_id']), 
					array('escape' => false),__('Are you sure?', true));
				}?>
			</td>
		</tr>
		<?php
		//}
		}
		if($rCost>0){
			?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->currency($rCost); ?></h3></div></div>
			 --> Total</td>
			<td align="right"><?php echo $this->Number->currency($rCost); ?></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}?>
		<?php }else{?>
		<tr>
			<td align="center" colspan="4">No Record in Radiology for <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
		<?php }?>
	</tbody>
</table>
</div>
<!--  radiology section end-->











<!--MRI Section starts here-->
<div id="MriSection"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">


<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php 
		echo $this->Html->link(__('Request Test'),array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('dept'=>'mri','return'=>'invoice')), array('escape' => false,'class'=>'blueBtn'));
		?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table class="tabularForm" style="position: relative; width: 100%"
	cellspacing="1">
	<tbody>
	<?php if(!empty($mri)){?>
		<tr class="row_title">
			<th class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<?php

		//BOF laboratory
		$i=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
		$mCost = 0 ;
		foreach($mri as $mriKey=>$mriCost){
			
			$mCost = $mCost + $mriCost['TariffAmount'][$hosType] ;
			?>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $mriCost['Radiology']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$mriCost['RadiologyTestOrder']['radiology_order_date']);
			echo $this->DateFormat->formatDate2Local($mriCost['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top"><?php echo $mriCost['ServiceProvider']['name'];?></td>
			<td align="right" valign="top"><?php echo $this->Number->currency($mriCost['TariffAmount'][$hosType]);?></td>
			<td align="center" valign="top"><?php 
				if($mriCost['RadiologyResult']['confirm_result'] != 1){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
					array('action' => 'deleteTest', $mriCost['RadiologyTestOrder']['id'],$mriCost['RadiologyTestOrder']['patient_id'],"mri"), 
					array('escape' => false),__('Are you sure?', true));
				}?>
			</td>
		</tr>
		<?php
		//}
		}
		if($mCost>0){
			?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->currency($mCost); ?></h3></div></div>
			 --> Total</td>
			<td align="right"><?php echo $this->Number->currency($mCost); ?></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}?>
		<?php }else{?>
		<tr>
			<td align="center" colspan="4">No Record in MRI for <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
		<?php }?>
	</tbody>
</table>
</div>
<!--Mri Section Ends here-->






<!--CT Section starts here-->
<div id="CTSection"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">

<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php 
		echo $this->Html->link(__('Request Test'),array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('dept'=>'ct','return'=>'invoice')), array('escape' => false,'class'=>'blueBtn'));
		?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table class="tabularForm" style="position: relative; width: 100%"
	cellspacing="1">
	<?php if(!empty($ct)){?>
	<thead>
		<tr class="row_title">
			<th class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
	</thead>	
	<?php
		$i=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
		$cCost = 0 ;
		foreach($ct as $mriKey=>$ctCost){
			$cCost += $ctCost['TariffAmount'][$hosType] ;
	?>
	<tbody>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $ctCost['Radiology']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$ctCost['RadiologyTestOrder']['radiology_order_date']);
			echo $this->DateFormat->formatDate2Local($ctCost['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top"><?php echo $ctCost['ServiceProvider']['name'];?></td>
			<td align="right" valign="top"><?php echo $this->Number->currency($ctCost['TariffAmount'][$hosType]);?></td>
			<td align="center" valign="top">
			<?php 
				if($ctCost['RadiologyResult']['confirm_result'] != 1){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
					array('action' => 'deleteTest', $ctCost['RadiologyTestOrder']['id'],$ctCost['RadiologyTestOrder']['patient_id'],"ct"), 
					array('escape' => false),__('Are you sure?', true));
				}?>
			</td>
		</tr>
		<?php }?>
	</tbody>
	<?php if($cCost>0){ ?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->currency($cCost); ?></h3></div></div>
			 --> Total</td>
			<td align="right"><?php echo $this->Number->currency($cCost); ?></td>
			<td>&nbsp;</td>
		</tr>
	<?php }} else {?>
	<tr>
			<td align="center" colspan="4">No Record in CT for <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
	<?php }?>
</table>
</div>
<!--CT Section Ends here-->








<!--Implant Section starts here-->
<div id="ImplantSection"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">
<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php 
		echo $this->Html->link(__('Request Test'),array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('dept'=>'implant','return'=>'invoice')), array('escape' => false,'class'=>'blueBtn'));
		?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table class="tabularForm" style="position: relative; width: 100%"
	cellspacing="1">
	<tbody>
	<?php if(!empty($implant)){?>
		<tr class="row_title">
			<th class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<?php

		//BOF laboratory
		$i=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
		$impCost = 0 ;
		foreach($implant as $radKey=>$implantCost){
			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
			$impCost += $implantCost['TariffAmount'][$hosType] ;
			?>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $implantCost['Radiology']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$implantCost['RadiologyTestOrder']['radiology_order_date']);
			echo $this->DateFormat->formatDate2Local($implantCost['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top"><?php echo $implantCost['ServiceProvider']['name'];?></td>
			<td align="right" valign="top"><?php echo $this->Number->currency($implantCost['TariffAmount'][$hosType]);?></td>
			<td align="center" valign="top"><?php 
				if($implantCost['RadiologyResult']['confirm_result'] != 1){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
					array('action' => 'deleteTest', $implantCost['RadiologyTestOrder']['id'],$implantCost['RadiologyTestOrder']['patient_id'],"implant"), 
					array('escape' => false),__('Are you sure?', true));
				}?>
			</td>
		</tr>
		<?php
		//}
		}
		if($impCost>0){
			?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->currency($impCost); ?></h3></div></div>
			Total</td>
			<td align="right"><?php echo $this->Number->currency($impCost); ?></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}?>
		<?php }else{?>
		<tr>
			<td align="center" colspan="4">No Record in Radiology for <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
		<?php }?>
	</tbody>
</table>
</div>
<!--Implant Section Ends here-->













<!--  pharmacy section start-->
<div id="pharmacy-section"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">


<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php echo $this->Html->link(__('Add'),array("controller" => "pharmacy", "action" => "sales_bill",$patient['Patient']['id'],"inventory" => true,"plugin"=>false), array( 'escape' => false,'class'=>'blueBtn'));?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

		<?php
		if(isset($patient_pharmacy_details)){
			$credit_amount = 0;
			$cash_amount = 0;
			$total = 0;
			?>

<table class="tabularForm" style="position: relative; width: 100%">
	<tbody>
		<tr>
			<th>Sr. No.</th>
			<th>Bill No.</th>
			<th>Bill Date</th>
			<th>Amount</th>
			<th>Payment Mode</th>
		</tr>
	</tbody>
	<?php

	foreach($patient_pharmacy_details as $key =>$value){
			
		?>
	<tr>
		<td><?php echo $key+1;?></td>
		<td><?php echo $value['PharmacySalesBill']['bill_code'];?></td>
		<td><?php //echo $value['PharmacySalesBill']['create_time'];
		echo $this->DateFormat->formatDate2Local($value['PharmacySalesBill']['create_time'],Configure::read('date_format'),true);
		?></td>
		<td><?php //echo $value['PharmacySalesBill']['total'];
		echo $this->Number->currency(ceil($value['PharmacySalesBill']['total']));
		?></td>
		<td><?php echo ucfirst($value['PharmacySalesBill']['payment_mode']);?></td>
	</tr>
	<?php
	$total = $total+(double)$value['PharmacySalesBill']['total'];
	if($value['PharmacySalesBill']['payment_mode'] == "cash")
	$cash_amount =$cash_amount+(double)$value['PharmacySalesBill']['total'];
	}
	?>

</table>
<table style="position: relative; width: 100%">
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right">Total Amount <?php			
		echo $this->Number->currency(ceil($total-$cash_amount));
		 
	 ?></td>
	</tr>

	<?php

	?>
</table>
	<?php }else{?>

<table class="tabularForm" style="position: relative; width: 100%"
	width="100%">
	<tbody>
		<tr>
			<td align="center" colspan="4">No Record In Pharmacy For <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
	</tbody>
</table>
	<?php }?></div>
<!--  pharmacy section end-->










<!-- Other Services Section Starts -->
<div id="otherServicesSection" style="margin-top: 30px; display: none">
<table width="100%" style="margin-top: 70px;" cellpadding="0"
	cellspacing="1" border="0" align="center">
	<tr>
		<td align="right"><input class="blueBtn" type="Button" value="Add"
			id="addOtherServices"></td>
	</tr>
</table>
	
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" align="center" id="viewOtherServices">
	<?php if(!empty($otherServices)){?>
	<tr>
		<th><?php echo __('Date');?></th>
		<th><?php echo __('Service');?></th>
	
		<th><?php echo __('Amount');?></th>
		<th width="50"><?php echo __('Action');?></th>
	</tr>
	<?php
	foreach($otherServices as $otherService){?>
	<tr>
		<td><?php 
		$sDate = explode(" ",$otherService['OtherService']['service_date']);
		echo $this->DateFormat->formatDate2Local($otherService['OtherService']['service_date'],Configure::read('date_format'));
		//echo $otherService['OtherService']['service_date']?></td>
		<td><?php echo $otherService['OtherService']['service_name']?></td>
		<td align="right"><?php echo $this->Number->currency($otherService['OtherService']['service_amount']);?></td>
		<td align="center"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteOtherServices', $otherService['OtherService']['id'],$otherService['OtherService']['patient_id']), array('escape' => false),__('Are you sure?', true));?></td>
	</tr>

	<?php }
	?>
	<?php }else{?>
	<tr>
		<td align="center">No Record in Other Services for <?php echo $patient['Patient']['lookup_name'];?></td>
	</tr>
	<?php }?>
</table>

	<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveOtherServices','type' => 'file','id'=>'otherServices','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
	)
	));
	?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	align="center" id="viewAddService" style="display: none">
	<tr>
		<td><?php echo __('Date');?></td>
		<td><?php echo $this->Form->input('OtherService.service_date',array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','legend'=>false,'label'=>false,'id' => 'otherServiceDate','readonly'=>'readonly'));?></td>
	</tr>

	<tr>
		<td><?php echo __('Service');?></td>
		<td><?php echo $this->Form->input('OtherService.service_name',array('class' => 'validate[required,custom[mandatory-enter]]','legend'=>false,'label'=>false,'id' => 'serviceName'));?></td>
	</tr>

	<tr>
		<td><?php echo __('Amount');?></td>
		<td><?php echo $this->Form->input('OtherService.service_amount',array('class' => 'validate[required,custom[mandatory-enter]]','legend'=>false,'label'=>false,'id' => 'serviceAmount','style'=>'text-align:right;'));?></td>
	</tr>

	<tr>
		<td>&nbsp;</td>
		<td align="left" style="padding-left: 53px; padding-top: 10px;"><?php echo $this->Form->hidden('OtherService.patient_id',array('value'=>$patient['Patient']['id'],'legend'=>false,'label'=>false,'id' => 'patientId'));?>

		<input class="blueBtn" style="margin: 0px;" type="submit" value="Save"
			id="saveOtherServices"> <input class="blueBtn" style="margin: 0px;"
			type="button" value="Cancel" id="otherServicesCancel"> <?php //echo $this->Html->link(__('Cancel'),'#', array('id'=>'otherServicesCancel','escape' => false,'class'=>'blueBtn'));?>
		</td>
	</tr>
</table>
	<?php echo $this->Form->end();?></div>
<!-- Other Services Section Ends -->







<!--  Service section start-->

	<?php //if($patient['Patient']['admission_type']!='OPD' && $patient['Patient']['is_discharge']!=1){
	if($patient['Patient']['is_discharge']!=1){
		?>
<div
	id="servicesSection" style="margin-top: 30px; display: none">



<table width="" align="right" cellpadding="0" cellspacing="0" border="0">
	<!--  <tr>	
                       	  <td class="tdLabel">Date</td>
                            <td >
                            
                            
                         <?php //echo $this->Form->input('date', array('type'=>'text','id' => 'billDate','class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;','readonly'=>'readonly')); ?>
                        </tr> -->
</table>
<!-- date section end here -->
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="left" width="160"><?php 
		//if($patient['Patient']['admission_type']!='OPD'){
		echo $this->Html->link(__('View Patient Services'),array('action' => 'viewAllPatientServices',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:0px;'));
		//}
		?></td>
	 
		<td align="right">Date:&nbsp;&nbsp;&nbsp;<?php echo $this->Form->input('date', array('value'=>$serviceDate,'type'=>'text','id' => 'billDate','class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;','readonly'=>'readonly')); ?></td>

	</tr>
</table>










<!--  BOF servcices  -->
		<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'servicesBilling',$patient['Patient']['id'],'type' => 'file','id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
		)
		));
		
		/*echo $this->Form->create('billings',array('controller'=>'billings','action'=>'servicesBilling',),
							array('id'=>'servicefrm','label'=>false,'div'=>false));*/
		
		echo $this->Form->hidden('location_id', array('value'=>$this->Session->read('locationid')));
		echo $this->Form->hidden('patient_id', array('id'=>'patient_id','value'=>$patient['Patient']['id']));
		if(isset($corporateId) && $corporateId != '')
		echo $this->Form->hidden('corporate_id', array('value'=>$corporateId));
		else
		echo $this->Form->hidden('corporate_id', array('value'=>''));

		?>

		<table width="100%">
			<tr>
				<td align="right"><?php 
				echo $this->Html->link(__('Cancel'),array('action' => 'patientSearch'), array('escape' => false,'class'=>'blueBtn'))."&nbsp;";
				echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn', 'id' => 'saveServiceBills'));?></td>
			</tr>
		</table>
		
		
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
			class="tabularForm" id="serviceGrid">
			<tr>
				<th width="140"><?php echo __('Date');?></th>
				<!--<th width="250"><?php //echo __('Type');?></th>
				<th width="250" style=""><?php //echo __('Name');?></th>-->
				<!--<th width="250" style=""><?php //echo __('Service Group/Sub Group');?></th>-->
				<th width="150" style=""><?php echo __('Service Group');?></th>
				<th width="150" style=""><?php echo __('Service Sub Group');?></th>
				<th width="150" style=""><?php echo __('Service');?></th>
				<!--<th width="100" style=""><?php echo __('Hospital Cost');?></th> -->
				<th width="100"><?php echo __('Unit Price');?></th>
				<th width="80" style=""><?php echo __('No of times');?>
				<th width="100" style=""><?php echo __('Amount');?>
				<th width="50"><?php echo __('Action');?></th>
			</tr>
			
			<!-- row to display the applied services -->
			<?php //debug($servicesData);?>
			<?php foreach($servicesData as $services){?>
			<tr>
				<td align="center">
					<?php //echo $services['ServiceBill']['date'];
					if(!empty($services['ServiceBill']['date']))
				echo $this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'),true);
				?>
				</td>
				<td>
					<?php echo $services['ServiceCategory']['name'];?>
				</td>
				<td>
					<?php echo $services['ServiceSubCategory']['name'];?>
				</td>
				<td>
					<?php echo $services['TariffList']['name'];?>
				</td>
				<!--<td align="center">
					<?php echo "--";?>
				</td>-->
				<td align="center">
					<?php if(!empty($services['TariffAmount']['non_nabh_charges']))
							{	echo $amount = $services['TariffAmount']['non_nabh_charges']; }
						if(!empty($services['TariffAmount']['non_charges']))
						{	echo $amount = $services['TariffAmount']['non_charges']; }
					?>
				</td>
				<td align="center">
					<?php echo $no_of_time = $services['ServiceBill']['no_of_times'];?>
				</td>
				<td align="right">
					<?php echo ($amount*$no_of_time); unset($amount);?>
				</td>
				<td align="center">
					<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',
													 array('title'=>'Delete','alt'=>'Delete')),
													 array('action' => 'deleteServicesCharges',
													 $services['ServiceBill']['id'],
													 $services['ServiceBill']['patient_id']),
													 array('escape' => false),__('Are you sure?', true));?>
				</td>
				
			</tr>
			<?php }?>
			<!-- row ends -->
			
			<?php //echo $this->Form->create('ServiceBill',array('controller'=>'Billings','action'=>'servicesBilling',$patient['Patient']['id']))?>
			
			<!-- row to add services -->
			<tr id="row1">
				<td align="center" width="140">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php echo $this->Form->input('', array('type'=>'text','id' => 'ServiceDate1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  ServiceDate','style'=>'width:120px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][0][date]')); ?>
				</td>
				 
				<td align="center" width="150px";>
					<select
						onchange="getListOfSubGroupServices(this);"
						name="data[ServiceBill][0][service_id]"
						id="add-service-group-id1" style="width:150px;" class="textBoxExpnd add-service-group-id"  fieldNo="1">
						<option value="">Select Service Group</option>
						<?php
	
						foreach($service_group as $key =>$value){
							?>
						<option value="<?php echo $value['ServiceCategory']['id'];?>"><?php echo $value['ServiceCategory']['name'];?></option>
					<?php } ?>
					</select>
				</td>
				
				<td align="center" width="150";>
					<select id="add-service-sub-group1" name="data[ServiceBill][0][sub_service_id]" style="width:150px;" 
						fieldNo="1" class="textBoxExpnd add-service-sub-group"	onchange="serviceSubGroups(this)" >
					</select>
				</td>
				
				
				<td align="center" width="150">
					<?php  echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd service_id',
								'div' => false,'label' => false,'empty'=>__('Please Select'),'options'=>array(''),'id' => 'service_id1',
								'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ServiceBill][0][tariff_list_id]' ,
								"onchange"=>"service_id(this)"));
					?> 
				</td>
				<!--<td align="center" width="100">
					<?php  echo $this->Form->input('', array('class' => 'textBoxExpnd','type'=>'select','options'=>array('private'=>'Private','cghs'=>'CGHS','other'=>'Other'),
								'div' => false,'label' => false,'empty'=>__('Please Select'),'id' => 'hospital_cost',
								'style'=>'width:100px;','name'=>'data[ServiceBill][0][hospital_cost]' ,  ));
					?>
					<div id="hospital_cost_area" align="center">
						<span id="private" style="display:none"></span>
						<span id="cghs" style="display:none"></span>
						<span id="other" style="display:none"></span>
					</div>
				</td>-->
				
				<td align="center">
				<?php echo $this->Form->input('amount',array('class' => 'validate[required,custom[onlyNumber]] textBoxExpnd service_amount','legend'=>false,'label'=>false,'id' => 'service_amount1','style'=>'width:80px;','fieldNo'=>1,'name'=>'data[ServiceBill][0][amount]')); 
				?>
				</td>
				
				<td align="center">
					<?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd no_of_times','id'=>'no_of_times1','type'=>'text','style'=>'width:80px;','name'=>'data[ServiceBill][0][no_of_times]','label'=>false,'div'=>false));?>
				</td>
				
				<td valign="middle" style="text-align:center;">  </td>
				<td valign="middle" style="text-align:center;"></td>  
			</tr>
			
			<!-- row ends -->
			
			
			<!-- row to display the total amount for services -->
			<!--<tr id="ampoutRow">
				<td colspan="6" valign="middle" align="right"><?php echo __('Total Amount');?></td>
				<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmount);?>
				</td>
				<td>&nbsp;</td>
			</tr> 
			--><!-- row ends -->
	 </table>
		<!-- EOF services -->
		
		
		
		
		
 <div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->
<div>&nbsp;</div>

<table width="100%" cellpadding="0" cellspacing="0" border="0	align="center">
	<tr>
		 <td width="50%"><input name="" type="button" value="Add More Services" class="blueBtn addMore" tabindex="17" onclick="addServiceVisitElement();"/> 
		 &nbsp;&nbsp;<input name="removeVisit" type="button" value="Remove" class="blueBtn" tabindex="17" onclick="removeConsultantVisitElement();" id="removeVisit" style="visibility:hidden"/></td>
	                           
		 <td width="50%" align="right">
		 <?php echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn', 'id' => 'saveServiceBill'))."&nbsp;";
				echo $this->Html->link(__('Cancel'),array('action' => 'patientSearch'), array('escape' => false,'class'=>'blueBtn')); ?>
		 </td>
	</tr>
</table>
 
<?php echo $this->Form->end();// EOF service bill form ?>


</div>
<?php } //EOF discharge conditions?>
<!--  Service section end-->


<style>
#consultantSection {
	display: none;
}
</style>

<script>
 var viewSection="<?php echo $viewSection;?>";
 var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
 var explode = admissionDate.split('-');


	 $('#consultantCancel').click(function() {
		document.getElementById('ConsultantBilling').reset();
		$("#servicesSectionBtn").attr('checked', true);
		$("#consultantSection").hide();
		$("#servicesSection").show();
	 });
	   
	 $('#dischargeBill').click(function() {
		 $("#servicesSectionBtn").attr('checked', true);
		 $("#pharmacy-section").hide();
		 $("#pathologySection").hide();
		 $("#consultantSection").hide();
		 $("#servicesSection").show();
		 $("#otherServicesSection").hide();
      });
	 $('#advancePayment').click(function() {
		 $("#servicesSectionBtn").attr('checked', true);
		 $("#pharmacy-section").hide();
		 $("#pathologySection").hide();
		 $("#consultantSection").hide();
		 $("#servicesSection").show();
		 $("#otherServicesSection").hide();
      });
	 	 $("#servicesSection").show();
         $('#saveConsultantBill').click(function() {
            jQuery("#ConsultantBilling").validationEngine();
         });
         
         $('#saveServiceBill').click(function() {
            jQuery("#servicefrm").validationEngine();
         });

         $('body').click(function() {
           jQuery("#ConsultantBilling").validationEngine('hide');
           jQuery("#servicefrm").validationEngine('hide');
         });
         $('#saveOtherServices').click(function() {
             jQuery("#otherServices").validationEngine();
          });
         
	 
	if(viewSection !=''){
		$("#consultantSection").hide();
		$("#servicesSection").hide();
		$("#servicesSectionBtn").attr('checked', false);
		$("#consultantSectionBtn").attr('checked', false);
		$("#"+viewSection).show();
		$("#"+viewSection+'Btn').attr('checked', true);
		//alert(viewSection);
	}
	
	
	 $(".servicesClick").click(function(){
		var checkboxId = this.id;
		var splitArr = checkboxId.split("_");
		var enableInput = splitArr[0]+'_quantity_'+splitArr[1];
		//alert(enableInput);
		if ($("#"+checkboxId).is(":checked")) {
			 $("#"+enableInput).attr("readonly", false);
			 $("#"+enableInput).val(1);
		}else{
		 	$("#"+enableInput).attr("readonly", 'readonly');
		 	$("#"+enableInput).val('');
		}

     });
	 
	 $("#servicesSectionBtn").click(function(){
		 $("#consultantSection").hide();
		 $("#servicesSection").show();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").hide();
         $("#pathologySection").hide();
         $("#MriSection").hide();
         $("#CTSection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
     });
     
	 $("#consultantSectionBtn").click(function(){
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").show();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").hide();
		 $("#MriSection").hide();
		 $("#CTSection").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
     });
     
	 $("#pathologySectionBtn").click(function(){
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#MriSection").hide();
         $("#pathologySection").show();
		 $("#radiologySection").hide();
		 $("#ImplantSection").hide();
		 $("#CTSection").hide();
		 $("#OtherServicesSection").hide();
		 $("#otherServicesSection").hide();
     });
     
	 $("#radiologySectionBtn").click(function(){
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").hide();
		 $("#MriSection").hide();
         $("#pathologySection").hide();
         $("#CTSection").hide();
         $("#radiologySection").show();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });
 
	 $("#pharmacy-sectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#MriSection").hide();
		 $("#ImplantSection").hide();
		 $("#pharmacy-section").show();
		 $("#CTSection").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });


	 $("#implant-sectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#MriSection").hide();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").show();
		 $("#CTSection").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });
     

	 $("#Mri-sectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").hide();
		 $("#MriSection").show();
		 $("#CTSection").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });

	 $("#Ct-sectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#MriSection").hide();
		 $("#CTSection").show();
         $("#pathologySection").hide();
         $("#ImplantSection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });

	 $("#otherServicesSectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#MriSection").hide();
		 $("#CTSection").hide();
		 $("#ImplantSection").hide();
		 $("#pharmacy-section").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#otherServicesSection").show();
		 //alert('here');
     });	

	 $("#addOtherServices").click(function(){ 
		 $("#viewAddService").show();
		 $("#viewOtherServices").hide();
		 $("#addOtherServices").hide();
	 });

	 $("#otherServicesCancel").click(function(){ 
		 $("#viewAddService").hide();
		 $("#viewOtherServices").show();
		 $("#addOtherServices").show();
	 });
	 
	   
	$(function() {
			$("#billDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
				dateFormat: 'dd/mm/yy',
				maxDate: new Date(),	
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),	
				onSelect: function (theDate)
			    {			        // The "this" keyword refers to the input (in this case: #someinput)
			   		window.location.href = '?serviceDate='+theDate;
			    	 
			    }	
			}); 

			$("#otherServiceDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
				dateFormat: 'dd/mm/yy',	
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),
				maxDate: new Date(),		
			});

			$("#ConsultantDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
				dateFormat: 'dd/mm/yy',	
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),
				maxDate: new Date(),		
			});

			$("#ServiceDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
				dateFormat: 'dd/mm/yy',	
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),
				maxDate: new Date(),		
			});
			

			$("#search_service_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});

			
     	//fnction to display hospital cost 
 		$("#hospital_cost").change(function(){ 
 			/*$("#hospital_cost_area").each(function() {
 			   $(this).hide();
 			});*/
 			 $("#hospital_cost_area").find('span').each(function(){ 
 	 			 	$("#"+$(this).attr('id')).hide();
 			 });
 			$("#"+$(this).val()).show();
 	 	});
 });

 
 function getListOfSubGroup(obj){
 	var currentField = $(obj);
    var fieldno = currentField.attr('fieldNo') ;
 	 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getListOfSubGroup", "admin" => false)); ?>"+"/"+obj.value,
			  context: document.body,				  		  
			  success: function(data){
				  	//alert(data);
			  	data= $.parseJSON(data); 
			  	$("#service-sub-group"+fieldno+" option").remove();
			  	$("#service-sub-group"+fieldno).append( "<option value=''>Select Sub Group</option>" ); 
			  
				$.each(data, function(val, text) { 
				    $("#service-sub-group1").append( "<option value='"+val+"'>"+text+"</option>" );
				});	
			  }
		});
 
 
				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/",
					  context: document.body,				  		  
					  success: function(data){ 
					  	data= $.parseJSON(data);
					  	$("#consultant_service_id"+fieldno+" option").remove();
					  	$("#consultant_service_id"+fieldno).append( "<option value=''>Select Service</option>" );
						$.each(data, function(val, text) {
						    $("#consultant_service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
						});
					  }
				});
 }

//for services copied from above
//for services radio option by swapnil 
 function getListOfSubGroupServices(obj){
	 	var currentField = $(obj);
	    var fieldno = currentField.attr('fieldNo') ;
	 	 $.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getListOfSubGroup", "admin" => false)); ?>"+"/"+obj.value,
				  context: document.body,				  		  
				  success: function(data){
					  	//alert(data);
				  	data= $.parseJSON(data); 
				  	$("#add-service-sub-group"+fieldno+" option").remove();
				  	$("#add-service-sub-group"+fieldno).append( "<option value=''>Select Sub Group</option>" ); 
				  
					$.each(data, function(val, text) { 
					    $("#add-service-sub-group"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
					});	
				  }
			});
	 
	 
					$.ajax({
						  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#add-service-group-id'+fieldno).val()+"/",
						  context: document.body,				  		  
						  success: function(data){ 
						  	data= $.parseJSON(data);
						  	$("#service_id"+fieldno+" option").remove();
						  	$("#service_id"+fieldno).append( "<option value=''>Select Service</option>" );
							$.each(data, function(val, text) {
							    $("#service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
							});
						  }
					});
	 }
 
       // var pager = new Pager('serviceGrid', 20); 
        //pager.init(); 
        //pager.showPageNav('pager', 'pageNavPosition'); 
        //pager.showPage(1);
		
	 function categoryChange(obj){ 
		var currentField = $(obj);
    	var fieldno = currentField.attr('fieldNo') ;
		 $("#amount"+fieldno).val('');
		 $("#doctor_id"+fieldno).val('Please Select');
		 $("#charges_type"+fieldno).val('Please Select');
		 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getDoctorList", "admin" => false)); ?>"+"/"+$('#category_id'+fieldno).val(),
			  context: document.body,				  		  
			  success: function(data){//alert(data);
			  	data= $.parseJSON(data);
			  	$("#doctor_id"+fieldno+" option").remove();
			  	$("#doctor_id"+fieldno).append( "<option value=''>Please Select</option>" );
				$.each(data, function(val, text) {
				    $("#doctor_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
				});
				//$('#doctor_id'+fieldno).attr('disabled', '');					  			
			    		
			  }
		});
     }
     function serviceSubGroup(obj){
	 	var currentField = $(obj);
    	var fieldno = currentField.attr('fieldNo') ;
			$("#amount"+fieldno).val(''); 
			
				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/"+$('#service-sub-group'+fieldno).val(),
					  context: document.body,				  		  
					  success: function(data){ 
					  	data= $.parseJSON(data);
					  	$("#consultant_service_id"+fieldno+" option").remove();
					  	$("#consultant_service_id"+fieldno).append( "<option value=''>Select Service</option>" );
						$.each(data, function(val, text) {
						    $("#consultant_service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
						});
					  }
				});
			
		 } 


	 //for services copied fron above
	 
     function serviceSubGroups(obj){
 	 	var currentField = $(obj);
     	var fieldno = currentField.attr('fieldNo') ;
 			$("#amount"+fieldno).val(''); 
 			
 				$.ajax({
 					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#add-service-group-id'+fieldno).val()+"/"+$('#add-service-sub-group'+fieldno).val(),
 					  context: document.body,				  		  
 					  success: function(data){ 
 					  	data= $.parseJSON(data);
 					  	$("#service_id"+fieldno+" option").remove();
 					  	$("#service_id"+fieldno).append( "<option value=''>Select Service</option>" );
 						$.each(data, function(val, text) {
 						    $("#service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
 						});
 					  }
 				});
 			
 		 } 
		 
	//cost of consutatnt
	  function consultant_service_id(obj){
	   var currentField = $(obj);
    	var fieldno = currentField.attr('fieldNo') ;
			$("#amount"+fieldno).val(''); 
				var tariff_standard_id ='<?php echo $patient['Patient']['tariff_standard_id'];?>';
				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantCost", "admin" => false)); ?>"+"/"+$(obj).val()+"/"+tariff_standard_id,
					  context: document.body,				  		  
					  success: function(data){ 
					  	data= $.parseJSON(data);
					  	$("#amount"+fieldno).val(data.tariff_amount);
					  	$("#hospital_cost").val(''); 
					  	$("#hospital_cost_area").find('span').each(function(){ 
		 	 			 	$("#"+$(this).attr('id')).hide();
		 			    });
					  	$("#private").html(data.private);
					  	$("#cghs").html(data.cghs);
					  	$("#other").html(data.other);
					  }
				});
			
		 } 


	//cost for services
	
	  function service_id(obj){
		   var currentField = $(obj);
	    	var fieldno = currentField.attr('fieldNo') ;
				$("#amount"+fieldno).val(''); 
					var tariff_standard_id ='<?php echo $patient['Patient']['tariff_standard_id'];?>';
					$.ajax({
						  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantCost", "admin" => false)); ?>"+"/"+$(obj).val()+"/"+tariff_standard_id,
						  context: document.body,				  		  
						  success: function(data){ 
						  	data= $.parseJSON(data);
						  	//alert(data.tariff_amount);
						  	$("#service_amount"+fieldno).val(data.tariff_amount);
						  	$("#hospital_cost").val(''); 
						  	$("#hospital_cost_area").find('span').each(function(){ 
			 	 			 	$("#"+$(this).attr('id')).hide();
			 			    });
						  	$("#private").html(data.private);
						  	$("#cghs").html(data.cghs);
						  	$("#other").html(data.other);
						  }
					});
				
			 } 
		 
		 
      function doctor_id(obj){
	 	var currentField = $(obj);
    	var fieldno = currentField.attr('fieldNo') ;
    	 $("#amount"+fieldno).val(''); 
    	 $("#charges_type"+fieldno).val('Please Select');
     } 


     
 --></script>
