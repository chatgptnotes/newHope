<?php
echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js','validationEngine.jquery','jquery.ui.timepicker','jquery.validationEngine2','/js/languages/jquery.validationEngine-en'));
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery-ui-1.8.16.custom.css','jquery.ui.all.css','internal_style.css','validationEngine.jquery.css','jquery.ui.timepicker.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4','jquery.blockUI','ui.datetimepicker.3.js'));?>
<style>
.timeCalender{
	border-radius: 25px;
    height: 20px;
    text-align: center;
    width: 50px !important;
}
</style>
<script>

var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
</script>
<div id="lab-investigation" style= "display:'<?php echo $display ;?>'"> 
	<div class="clr ht5"></div>
	<table width="99%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm">
		<tr>
			<td width="30%" valign="top">
				<table width="99%" cellpadding="0" cellspacing="1" border="0"
					class="tabularForm">

					<tr>
						<td valign="top">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>

									<td ><?php 
									echo $this->Html->image('/img/favourite-icon.png');
									echo $this->Form->input('test_name',array('class'=>'textBoxExpnd','escape'=>false,'multiple'=>false,
	                                 'label'=>false,'div'=>false,'id'=>'test_name','autocomplete'=>false,'placeHolder'=>'Lab Search','style'=>'width:286px;'));
	                                 ?>
									</td>

									<td width="">
									</td>

									<td width="">
									</td>
								</tr>
							</table>
						</td>

					</tr>

				</table> 
				</td></tr><tr><td>
				<div style="float:right;margin-right:100px;" id="">
				<input type="button" id="addMoreLab" value="Add More Order">
				<span id="showRemove" style="display:none">
				<input type="button" id="removeMoreLab" value="Remove Order">
				</span>
				 </div>
				<!-- billing activity form end here -->
				<?php echo $this->Form->create('LaboratoryToken',array('controller'=>'LaboratoryToken','action'=>'addLab','id'=>'labfrm','type'=>'post'));?>
				<div id="referenceLabDiv">
				<table border="0" class="" cellpadding="0" cellspacing="3"
					width="100%" style="text-align: left; color: #fff;display:none" id="lab0">
					<tr>
						<td width="40%" id="boxSpace" class="tdLabel">Universal Service
							Identifier: <font color="red">*</font>
						</td>
						<td width="60%" ><?php  echo $this->Form->input('data[][LaboratoryToken][testname]',array('id'=>'testname0','class'=>'validate[required,custom[search-&-select]] textBoxExpnd','div'=>false,'label'=>false,'readonly'=>'readonly'));
						echo $this->Form->hidden('data[][LaboratoryToken][curdate]',array('id'=>'curdate'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][lab_id]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testcode0'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder[sct_concept_id]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sctCode'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][sct_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sctDesc'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][isIMO]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'isIMO'));

						echo $this->Form->hidden('data[][LaboratoryTestOrder][cpt_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cptCode'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][lonic_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'LonicCode'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][lonic_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'LonicDesc'));

						echo $this->Form->hidden('data[][LaboratoryTestOrder][cpt_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cptDesc'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][icd9_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd9Code'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][icd9_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd9Desc'));

						echo $this->Form->hidden('data[][LaboratoryTestOrder][icd10pcs_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd10pcsCode'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][icd10pcs_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd10pcsDesc'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][hcpcs_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'hcpcsCode'));

						echo $this->Form->hidden('data[][LaboratoryTestOrder][hcpcs_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'hcpcsDesc'));





						echo $this->Form->hidden('data[][LaboratoryTestOrder][patient_id]', array('value'=>$patient_id));
						echo $this->Form->hidden('data[][LaboratoryToken][id]',array('id'=>'token_id','div'=>false,'label'=>false));
						echo $this->Form->hidden('data[][LaboratoryToken][testOrder_id]',array('type'=>'text','id'=>'testOrder_id','div'=>false,'label'=>false));
						if($flagSbar=='sbar')
						echo $this->Form->hidden('data[][LaboratoryToken][sbar]',array('id'=>'sbar','value'=>$flagSbar));
			?>
						</td>
					</tr>
<!-- 
					<tr>
						<td   id="boxSpace" class="tdLabel">Specimen:
						</td>
						<td>
						
						<?php  
							
						//echo $this->Form->input('data[][LaboratoryToken]specimen_type_id',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_type,'id'=>'specimen_type_id','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
					-->
					<tr>
						<td   id="specimen_type_name" class="tdLabel">Specimen Type:
						</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][specimen_type_option]',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>'','id'=>'specimen_type_option','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
					<tr>
						<!--<td>Status:</td>
			<td><?php //echo $this->Form->input('data[][LaboratoryToken]status', array('readonly'=>'readonly','style'=>'width:160px','options'=>array("Entered"=>__('Entered'),'Approved'=>__('Approved'),'Ordered'=>__('Ordered')),'id'=>'status','label' => false)); ?>
			</td>-->

						<td    class="tdLabel">Date of Order: <font color="red">*</font> 
						</td>
						<?php $curentTime= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?>
						<td   style="width: 163px; float: left;"><?php echo $this->Form->input('data[][LaboratoryTestOrder][start_date]',array('id'=>'lab_start','class'=>'textBoxExpnd start_cal','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>$curentTime,'label'=>false )); 
						//echo $this->Form->input('data[][LaboratoryToken]collected_date',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'collected_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false,'value'=>date('m/d/y H:i:s') )); ?>
						</td>
					</tr>
					
				<!-- 	<tr>
						<td  class="tdLabel">Sample:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][sample]', array('class'=>'textBoxExpnd','readonly'=>'readonly','options'=>array("Office"=>__('Office'),' PSC'=>__(' PSC')),'label' => false,'id' => 'sample')); ?>
						</td>
					</tr> -->

				<!--  	<tr>
						<td   class="tdLabel">Start date: <!--  <font color="red">*</font>
						</td>
						<td  ><?php //echo $this->Form->input('data[][LaboratoryTestOrder]start_date',array('id'=>'lab_start','class'=>'textBoxExpnd start_cal','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
						</td>
					</tr> -->
						<!--  <tr>

						<td  class="tdLabel">End date/time: <!--  <font color="red">*</font>
						</td>

						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][end_date]',array('class'=>'textBoxExpnd','id'=>'end_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
						</td>
					</tr> -->
					<tr>
						<td   id="boxSpace" class="tdLabel">Specimen Action
							Code:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][specimen_action_id]',array('class'=>'textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_action,'id'=>'specimen_action_id','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
				  	<tr>
						<td    class="tdLabel">Accession ID:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][ac_id]',
								array('readonly'=>'readonly','class'=>'textBoxExpnd','type'=>'text','id'=>'ac_id','div'=>false,'label'=>false,'value'=>$accesionId));  ?>

						</td> 

					</tr>
					<tr>
						<td  class="tdLabel">Specimen Condition:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][specimen_condition_id]',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>$spec_cond,'id'=>'specimen_condition_id','div'=>false,'label'=>false));  ?>

						</td>

					</tr>
					<tr>
						<td  class="tdLabel">Priority:</td>
						<td  ><?php $Priority=array('Stat'=>'Stat','Daily'=>'Daily','Tommorrow'=>'Tommorrow','Today'=>'Today');
						 echo $this->Form->input('data[][LaboratoryToken][priority]',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>$Priority,'id'=>'priority','div'=>false,'label'=>false));  ?>

						
						<div id= "showTime"style="padding-left: 43px; padding-bottom: 5px;display:none;">
						<span>At</span>
				<input type="text" id="timepicker_start" class="timeCalender" readonly="readonly"
					name="data[][LaboratoryToken][starthours]" >
				</div></td>

					</tr>
					<tr>
						<td  class="tdLabel">Frequency:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][frequency]',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>Configure::read('frequency'),'id'=>'','div'=>false,'label'=>false));  ?>

						</td>
						

					</tr>
					

					<tr>
						<td  class="tdLabel">Condition Original
							Text:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][cond_org_txt]', array('class'=>'textBoxExpnd','type'=>'text','label' => false,'id' => 'cond_org_txt')); ?>
						</td>
					</tr>
					<tr>
						<td   id="boxSpace" class="tdLabel">Alternate Specimen Type:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][alt_spec]',array('class'=>'textBoxExpnd','type'=>'text','id'=>'alt_spec','div'=>false,'label'=>false));  ?>
						</td>
					</tr>

					<tr>
						<td   id="boxSpace" class="tdLabel">Specimen Reject Reason:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][specimen_rejection_id]', array('class'=>'textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_rej,'label' => false,'id' => 'spec_rej')); ?>
						</td>
					</tr>

					<tr>
						<td   id="boxSpace" class="tdLabel">Reject Reason
							Original Text:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][rej_reason_txt]', array('class'=>'textBoxExpnd','type'=>'text','label' => false,'id' => 'rej_reason_txt')); ?>
						</td>
					</tr>
					<!--  <tr>
						<td   id="boxSpace" class="tdLabel">No of written Lab
							orders:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryTestOrder][lab_order]', array('class'=>'textBoxExpnd','type'=>text,'div'=>false,'label'=>false,'id' => 'lab_order')); ?>
						</td>
					</tr> -->


					<tr>
						<td width="19%" id="boxSpace" class="tdLabel">Alternate Specimen
							Condition:</td>
						<td width="20%"><?php  echo $this->Form->input('data[][LaboratoryToken][alt_spec_cond]',array('class'=>'textBoxExpnd','type'=>'text','id'=>'alt_spec_cond','div'=>false,'label'=>false));  ?>
							<?php echo $this->Form->hidden('data[][LaboratoryToken][patient_id]',array('label'=>false,'type'=>'text','value'=>$patientId));?>
						</td>
					</tr>
					
					<!-- 
		<tr>
			<td>Bill Type:</td>
			<td><?php //echo $this->Form->input('data[][LaboratoryToken]bill_type', array('id'=>'bill_type','style'=>'width:165px','options'=>array("None"=>__('None'),'Patient'=>__('Patient'),'Client'=>__('Client'),'Third Party'=>__('Third Party')),'label' => false)); 
			?>
			</td>
			<td>Account No:</td>
			<td><?php  //echo $this->Form->input('data[][LaboratoryToken]account_no',array('id'=>'account_no','class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false));  ?>
			</td>
			
		</tr>
		 -->
					<!-- <tr>
						<td width="19%" id="boxSpace" class="tdLabel"><?php echo __("Send To Laboratory");?>:</td>
						<td width="31%"><?php echo $this->Form->input('data[][LaboratoryTestOrder][service_provider_id]', array('class'=>'textBoxExpnd','empty'=>'Please Select','id'=>'service_provider_id','options'=>$serviceProviders,'label' => false)); ?>
						</td>
					</tr> -->

					<tr>

						<td width="19%" id="boxSpace" class="tdLabel">Specimen Collection
							Date:</td>
						<td width="19%"><?php echo $this->Form->input('data[][LaboratoryTestOrder][lab_order_date]', array('class'=>'textBoxExpnd','id' => 'lab_order_date','type'=>'text','label'=>false )); ?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td width="19%" id="boxSpace" class="tdLabel">Clinical Information <span style="font-size:11px;font-style:italic">(Comments or Special Instructions)</span></td>
						<td width="19%"><?php echo $this->Form->input('data[][LaboratoryToken][relevant_clinical_info]', array('class'=>'textBoxExpnd','id' => 'relevant_clinical_info','type'=>'text','label'=>false )); ?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td width="19%" id="boxSpace" class="tdLabel">Ordering Provider</td>
						<td width="19%"><?php 
						
						//if($this->Session->read('role')=='Primary Care Provider'){
							$getDocName=$dName; // From Appointment	
						//}		
						//debug($getDocName);			
						echo $this->Form->input('data[][LaboratoryToken][primary_care_pro]', array('class'=>'textBoxExpnd','id' => 'primary_care_pro','type'=>'text','label'=>false,'value'=>$getDocName )); ?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>

					<!-- 
		<tr>
			<td>Number of written Laboratory orders:</td>
			<td><?php //echo $this->Form->input('data[][LaboratoryTestOrder]lab_order', array('type'=>text,'div'=>false,'label'=>false,'id' => 'lab_order'  )); ?>
			</td>

			<td>Date of order:</td>
			<td><?php //echo $this->Form->input('data[][LaboratoryTestOrder]lab_order_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id' => 'lab_order_date','type'=>'text','label'=>false )); ?>
			</td>
		</tr>
		 -->
					




				</table>
		</div>
		<?php 
				echo $this->Form->hidden('[testname0]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testname0'));
				echo $this->Form->hidden('[testcode0]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testcode0'));
				?>
				<div id="labMainDiv">
				
				
				
				<table border="0" class="" cellpadding="0" cellspacing="3"
					width="100%" style="text-align: left; color: #fff;" id="lab1">
					<tr>
						<td width="40%" id="boxSpace" class="tdLabel">Universal Service
							Identifier: <font color="red">*</font>
						</td>
						<td width="60%" ><?php  echo $this->Form->input('data[][LaboratoryToken][testname]',array('id'=>'testname1','class'=>'validate[required,custom[search-&-select]] textBoxExpnd','div'=>false,'label'=>false,'readonly'=>'readonly'));
						echo $this->Form->hidden('data[][LaboratoryToken][curdate]',array('id'=>'curdate'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][lab_id]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testcode1'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder[sct_concept_id]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sctCode'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][sct_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sctDesc'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][isIMO]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'isIMO'));

						echo $this->Form->hidden('data[][LaboratoryTestOrder][cpt_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cptCode'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][lonic_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'LonicCode'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][lonic_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'LonicDesc'));

						echo $this->Form->hidden('data[][LaboratoryTestOrder][cpt_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cptDesc'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][icd9_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd9Code'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][icd9_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd9Desc'));

						echo $this->Form->hidden('data[][LaboratoryTestOrder][icd10pcs_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd10pcsCode'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][icd10pcs_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd10pcsDesc'));
						echo $this->Form->hidden('data[][LaboratoryTestOrder][hcpcs_code]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'hcpcsCode'));

						echo $this->Form->hidden('data[][LaboratoryTestOrder][hcpcs_desc]',array('type'=>'text','div'=>false,'label'=>false,'id'=>'hcpcsDesc'));





						echo $this->Form->hidden('data[][LaboratoryTestOrder][patient_id]', array('value'=>$patient_id));
						echo $this->Form->hidden('data[][LaboratoryToken][id]',array('id'=>'token_id','div'=>false,'label'=>false));
						echo $this->Form->hidden('data[][LaboratoryToken][testOrder_id]',array('type'=>'text','id'=>'testOrder_id','div'=>false,'label'=>false));
						if($flagSbar=='sbar')
						echo $this->Form->hidden('data[][LaboratoryToken][sbar]',array('id'=>'sbar','value'=>$flagSbar));
			?>
						</td>
					</tr>
<!-- 
					<tr>
						<td   id="boxSpace" class="tdLabel">Specimen:
						</td>
						<td>
						
						<?php  
							
						//echo $this->Form->input('data[][LaboratoryToken]specimen_type_id',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_type,'id'=>'specimen_type_id','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
					-->
					<tr>
						<td   id="specimen_type_name" class="tdLabel">Specimen Type:
						</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][specimen_type_option]',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>'','id'=>'specimen_type_option','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
					<tr>
						<!--<td>Status:</td>
			<td><?php //echo $this->Form->input('data[][LaboratoryToken]status', array('readonly'=>'readonly','style'=>'width:160px','options'=>array("Entered"=>__('Entered'),'Approved'=>__('Approved'),'Ordered'=>__('Ordered')),'id'=>'status','label' => false)); ?>
			</td>-->

						<td    class="tdLabel">Date of Order: <font color="red">*</font> 
						</td>
						<?php $curentTime= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?>
						<td   style="width: 163px; float: left;"><?php echo $this->Form->input('data[][LaboratoryTestOrder][start_date]',array('id'=>'lab_start','class'=>'textBoxExpnd start_cal','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>$curentTime,'label'=>false )); 
						//echo $this->Form->input('data[][LaboratoryToken]collected_date',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'collected_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false,'value'=>date('m/d/y H:i:s') )); ?>
						</td>
					</tr>
					
				<!-- 	<tr>
						<td  class="tdLabel">Sample:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][sample]', array('class'=>'textBoxExpnd','readonly'=>'readonly','options'=>array("Office"=>__('Office'),' PSC'=>__(' PSC')),'label' => false,'id' => 'sample')); ?>
						</td>
					</tr> -->

				<!--  	<tr>
						<td   class="tdLabel">Start date: <!--  <font color="red">*</font>
						</td>
						<td  ><?php //echo $this->Form->input('data[][LaboratoryTestOrder]start_date',array('id'=>'lab_start','class'=>'textBoxExpnd start_cal','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
						</td>
					</tr> -->
						<!--  <tr>

						<td  class="tdLabel">End date/time: <!--  <font color="red">*</font>
						</td>

						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][end_date]',array('class'=>'textBoxExpnd','id'=>'end_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
						</td>
					</tr> -->
					<tr>
						<td   id="boxSpace" class="tdLabel">Specimen Action
							Code:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][specimen_action_id]',array('class'=>'textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_action,'id'=>'specimen_action_id','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
				  	<tr>
						<td    class="tdLabel">Accession ID:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][ac_id]',
								array('readonly'=>'readonly','class'=>'textBoxExpnd','type'=>'text','id'=>'ac_id','div'=>false,'label'=>false,'value'=>$accesionId));  ?>

						</td> 

					</tr>
					<tr>
						<td  class="tdLabel">Specimen Condition:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][specimen_condition_id]',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>$spec_cond,'id'=>'specimen_condition_id','div'=>false,'label'=>false));  ?>

						</td>

					</tr>
					<tr>
						<td  class="tdLabel">Priority:</td>
						<td  ><?php $Priority=array('Stat'=>'Stat','Daily'=>'Daily','Tommorrow'=>'Tommorrow','Today'=>'Today');
						 echo $this->Form->input('data[][LaboratoryToken][priority]',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>$Priority,'id'=>'priority','div'=>false,'label'=>false));  ?>

						
						<div id= "showTime"style="padding-left: 43px; padding-bottom: 5px;display:none;">
						<span>At</span>
				<input type="text" id="timepicker_start" class="timeCalender" readonly="readonly"
					name="data[][LaboratoryToken][starthours]" >
				</div></td>

					</tr>
					<tr>
						<td  class="tdLabel">Frequency:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][frequency]',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>Configure::read('frequency'),'id'=>'','div'=>false,'label'=>false));  ?>

						</td>
						

					</tr>
					

					<tr>
						<td  class="tdLabel">Condition Original
							Text:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][cond_org_txt]', array('class'=>'textBoxExpnd','type'=>'text','label' => false,'id' => 'cond_org_txt')); ?>
						</td>
					</tr>
					<tr>
						<td   id="boxSpace" class="tdLabel">Alternate Specimen Type:</td>
						<td  ><?php  echo $this->Form->input('data[][LaboratoryToken][alt_spec]',array('class'=>'textBoxExpnd','type'=>'text','id'=>'alt_spec','div'=>false,'label'=>false));  ?>
						</td>
					</tr>

					<tr>
						<td   id="boxSpace" class="tdLabel">Specimen Reject Reason:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][specimen_rejection_id]', array('class'=>'textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_rej,'label' => false,'id' => 'spec_rej')); ?>
						</td>
					</tr>

					<tr>
						<td   id="boxSpace" class="tdLabel">Reject Reason
							Original Text:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryToken][rej_reason_txt]', array('class'=>'textBoxExpnd','type'=>'text','label' => false,'id' => 'rej_reason_txt')); ?>
						</td>
					</tr>
					<!--  <tr>
						<td   id="boxSpace" class="tdLabel">No of written Lab
							orders:</td>
						<td  ><?php echo $this->Form->input('data[][LaboratoryTestOrder][lab_order]', array('class'=>'textBoxExpnd','type'=>text,'div'=>false,'label'=>false,'id' => 'lab_order')); ?>
						</td>
					</tr> -->


					<tr>
						<td width="19%" id="boxSpace" class="tdLabel">Alternate Specimen
							Condition:</td>
						<td width="20%"><?php  echo $this->Form->input('data[][LaboratoryToken][alt_spec_cond]',array('class'=>'textBoxExpnd','type'=>'text','id'=>'alt_spec_cond','div'=>false,'label'=>false));  ?>
							<?php echo $this->Form->hidden('data[][LaboratoryToken][patient_id]',array('label'=>false,'type'=>'text','value'=>$patientId));?>
						</td>
					</tr>
					
					<!-- 
		<tr>
			<td>Bill Type:</td>
			<td><?php //echo $this->Form->input('data[][LaboratoryToken]bill_type', array('id'=>'bill_type','style'=>'width:165px','options'=>array("None"=>__('None'),'Patient'=>__('Patient'),'Client'=>__('Client'),'Third Party'=>__('Third Party')),'label' => false)); 
			?>
			</td>
			<td>Account No:</td>
			<td><?php  //echo $this->Form->input('data[][LaboratoryToken]account_no',array('id'=>'account_no','class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false));  ?>
			</td>
			
		</tr>
		 -->
					<!-- <tr>
						<td width="19%" id="boxSpace" class="tdLabel"><?php echo __("Send To Laboratory");?>:</td>
						<td width="31%"><?php echo $this->Form->input('data[][LaboratoryTestOrder][service_provider_id]', array('class'=>'textBoxExpnd','empty'=>'Please Select','id'=>'service_provider_id','options'=>$serviceProviders,'label' => false)); ?>
						</td>
					</tr> -->

					<tr>

						<td width="19%" id="boxSpace" class="tdLabel">Specimen Collection
							Date:</td>
						<td width="19%"><?php echo $this->Form->input('data[][LaboratoryTestOrder][lab_order_date]', array('class'=>'textBoxExpnd','id' => 'lab_order_date','type'=>'text','label'=>false )); ?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td width="19%" id="boxSpace" class="tdLabel">Clinical Information <span style="font-size:11px;font-style:italic">(Comments or Special Instructions)</span></td>
						<td width="19%"><?php echo $this->Form->input('data[][LaboratoryToken][relevant_clinical_info]', array('class'=>'textBoxExpnd','id' => 'relevant_clinical_info','type'=>'text','label'=>false )); ?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td width="19%" id="boxSpace" class="tdLabel">Ordering Provider</td>
						<td width="19%"><?php 
						
						//if($this->Session->read('role')=='Primary Care Provider'){
							$getDocName=$dName; // From Appointment	
						//}		
						//debug($getDocName);			
						echo $this->Form->input('data[][LaboratoryToken][primary_care_pro]', array('class'=>'textBoxExpnd','id' => 'primary_care_pro','type'=>'text','label'=>false,'value'=>$getDocName )); ?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>

					<!-- 
		<tr>
			<td>Number of written Laboratory orders:</td>
			<td><?php //echo $this->Form->input('data[][LaboratoryTestOrder]lab_order', array('type'=>text,'div'=>false,'label'=>false,'id' => 'lab_order'  )); ?>
			</td>

			<td>Date of order:</td>
			<td><?php //echo $this->Form->input('data[][LaboratoryTestOrder]lab_order_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id' => 'lab_order_date','type'=>'text','label'=>false )); ?>
			</td>
		</tr>
		 -->
					<tr>
					<td  align='right' valign='bottom' colspan='2'>
					<?php if($flagSbar != 'sbar' ){
						if($noteId=='null')
						echo $this->Html->link(__('Cancel'),array("controller"=>'notes',"action"=>'soapNote',$patientId),array('id'=>'labsubmit1','class'=>'blueBtn'));
						else 
							echo $this->Html->link(__('Cancel'),array("controller"=>'notes',"action"=>'soapNote',$patientId,$noteId),array('id'=>'labsubmit1','class'=>'blueBtn'));} ?> 
						
					<?php  echo $this->Form->submit(__('Submit'),array('id'=>'labsubmit','class'=>'blueBtn','onclick'=>"javascript:save_lab();return false;",'div'=>false)); ?></td>

					</tr>




				</table>
				
				</div>
				<?php echo $this->Form->end();?>
			</td>
					</tr>
				</table>
	<!-- PRocudure search ends -->
</div>
<script>

var specimenCollectionUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getSpecimenOptions","admin" => false)); ?>";
//procedureList
jQuery(document).ready(function(){

	var validateMandatory = jQuery("#labfrm").validationEngine('validate');
			$("#test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labRadAutocomplete","Laboratory",'id',"dhr_order_code","name",'dhr_flag=1',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				valueSelected:true,
				showNoId:true,
				loadId : 'testname0,testcode0',
				onItemSelect:function () {
					$("#testname"+(labCounter)).val($("#testname0").val());
					$("#testcode"+(labCounter)).val($("#testcode0").val());
					$("#testname0").val('');
					$("#testcode0").val('');
					getSpecimenOptions();
				}
			});

// Pawan get Specimen Options
function getSpecimenOptions(){//specimen_type_option//specimen_type_name
	$('#specimen_type_option option[value!=0]').remove();
	$("#specimen_type_name").html('Specimen Type'+':');
	var isOption = false;
	$.ajax({
        type: 'POST',
       	url: specimenCollectionUrl+'/'+$("#testcode").val(),
       	//data: {laboratory_id: $("#testcode").val()},
        dataType: 'html',
        beforeSend : function() {
        	loading('lab-investigation','id');
		},
		success: function(data){ 
			
			data = jQuery.parseJSON(data);
			options = data['0'];
			name  = data['1'];
			//if(name != 'null'){
				//$("#specimen_type_name").html(name+':');
				$.each(options, function (i, item) {
					isOption = true;
					$("#specimen_type_option").append( new Option(item,i) );
					onCompleteRequest('lab-investigation','id');
				});
			//}else{
			//	$("#specimen_type_option").append( new Option('Blood Specimen','') );
			//}
			if(isOption == false){
				$("#specimen_type_option").append( new Option('Blood Specimen','') );
			}
				
			onCompleteRequest('lab-investigation','id');
        },
		error: function(message){
			 alert("Please try again") ;
        }        
});
}
	


/// End (Pawan)


	//BOF procedure search
			$("#procedureSearch").click(function(){
				  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "proceduresearch",$patient_id,"admin" => false)); ?>";

				  var formData = $('#procedureForm').serialize(); 
				   $.ajax({
			            type: 'POST',
			           	url: ajaxUrl,
			            data: formData,
			            dataType: 'html',
			            beforeSend : function() {
			            	loading();
						},
						success: function(data){ 
							$("#procedureList").html(data);
							onCompleteRequest();
			            },
						error: function(message){
							 alert("Please try again") ;
			            }        
			   });
			});
			//EOF procedure search
});
$(".start_cal")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
			onSelect : function() {
				
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
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				
			}

		});
$("#lab_order_date")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				
			}

		});

function save_lab(Clinical){ 
	/*if($('#specimen_type_id').val()==""){
		alert('Check validations');
		return false;
	}
	if($('#testname').val()==""){
		alert('Check validations');
		return false;
	}*/
	var validateMandatory = jQuery("#labfrm").validationEngine('validate');
	 
	if(validateMandatory == false){ 
		return false;
	}else{ 	
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addLab",
		 		$patientId,$noteId,"admin" => false)); ?>"; 
		 var formData = $('#labfrm').serialize(); 
		   $.ajax({
	            type: 'POST',
	           	url: ajaxUrl,
	            data: formData,
	            dataType: 'html',
	            beforeSend : function() {
					//this is where we append a loading image
	            	$('#busy-indicator').show('fast');
				},
				success: function(data){ 
					if($.trim(data)=='sbar'){
						parent.$.fancybox.close();
						
					}else{
					$('#busy-indicator').hide('fast');
					var noteId='<?php echo $noteId?>';
					if(noteId=='null'){
						noteId=$.trim(data);
					}
					//window.location.href='<?php echo $this->Html->url(array("controller"=>'notes',"action" => "soapNote",$patientId));?>'+'/'+noteId
					}
		            },
				error: function(message){
					$( '#flashMessage', parent.document).html('Please try later.');
					$('#flashMessage', parent.document).show();
					parent.$.fancybox.close();
	            }        });
	      
	      return false;
	}

	 
}
function proceduresearch(source) {
    var identify =""; 
	identify = source;
	$.fancybox({
				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "proceduresearch")); ?>" + "/" + identify,
			});
   } 

function loading(){
	  
	 $('#procedureList').block({ 
       message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please wait...</h1>', 
       css: {            
           padding: '5px 0px 5px 18px',
           border: 'none', 
           padding: '15px', 
           backgroundColor: '#000000', 
           '-webkit-border-radius': '10px', 
           '-moz-border-radius': '10px',               
           color: '#fff',
           'text-align':'left' 
       },
       overlayCSS: { backgroundColor: '#000000' } 
   }); 
}

function onCompleteRequest(){
	$('#procedureList').unblock(); 
	return false ;
}
$("#primary_care_pro").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'doctor_id_txt,doctorID',
});
$('#timepicker_start').timepicker({
    showLeadingZero: true,
    onSelect: tpStartSelect,
   // onClose: updateDoctorTime,
    minTime: {
        //hour: <?php echo Configure::read('calendar_start_time') ?>, minute: 0
    },
    maxTime: {
       // hour: parseInt('<?php //echo Configure::read('calendar_end_time') ?>'//)-1, minute: 0
    }
});
function tpStartSelect( time, endTimePickerInst ) {
    $('#timepicker_end').timepicker('option', {
        minTime: {
            hour: endTimePickerInst.hours+1,
            minute: endTimePickerInst.minutes
        }
    });
}
$('#priority').change(function(){
	if($('#priority').val()=='Tommorrow' || $('#priority').val()=='Today')
		$('#showTime').show();
	else
		$('#showTime').hide();
	
});

var labCounter = 1;
$('#addMoreLab').click(function(){
	var html = $( "#referenceLabDiv").html();
	labCounter++;
	html = html.replace("testname0", "testname"+(labCounter));
	html = html.replace("testcode0", "testcode"+(labCounter));
	html = html.replace("lab0", "lab"+(labCounter));
	html = html.replace("display:none", "display:block");
	$("#labMainDiv").prepend(html);
	$("#test_name").val('');
	$("#test_name").focus();
	html = '';
	$("#showRemove").show();
});

$('#removeMoreLab').click(function(){
	var html = $( "#labMainDiv table:eq(0)" ).remove();
	labCounter--;
	if(labCounter < 2){
		$("#showRemove").hide();
	} 
});
		</script>
