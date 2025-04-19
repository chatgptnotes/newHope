<?php 
if(empty($patientHealthPlanID))
	$patientHealthPlanIDfreq=0;
else
	$patientHealthPlanIDfreq=$patientHealthPlanID;
?>

<style>

.message{
	
	font-size: 15px;
}

.rowClass td{
	 background: none repeat scroll 0 0 #ffcccc!important;
}

#patient-info-box{
 	display: none;
    position: absolute;
    right: 0;
    left:992px;
    top: 34px;
    z-index: 29;
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #000000;
    border-radius: 3px;
    box-shadow: 0 0 3px 2px #000;
    margin-top: -1px;
    padding: 6px;
    width: 400px;
    font-size:13px;
    list-style-type: none;
    
}
 .row_format th{
 	 background: #d2ebf2 none repeat scroll 0 0 !important;
    border-bottom: 1px solid #3e474a;
    color: #31859c !important;
    font-size: 12px;
    padding: 3px;
    text-align: center;
 }
 .row_format td{
 	padding: 1px;
 }
  
.row_format tr:nth-child(even) {background: #CCC}
.row_format tr:nth-child(odd) {background: #e7e7e7} 
</style> 

<?php  $pat = $this->element('print_patient_info'); $getBasicData = $patient; ?>
<div class="Row inner_title" style="float: left; width: 100%; clear:both">
		<div style="font-size: 20px; font-family: verdana; color: darkolivegreen;float: left" >			 
			<?php echo $getBasicData['Patient']['lookup_name']." - ".$getBasicData['Patient']['patient_id'] ;?>
			<?php echo '&nbsp;'.$this->Html->image('icons/user_info.png',array('id'=>'userInfo', 'style'=>'float:none; height: 30px; margin-bottom: 5px; width: 30px;')); ?>
			<ul style="display: none;" id="patient-info-box">
			   <li style="float: right"><?php  
						if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$this->Session->read('person_photo')) && ($this->Session->check('person_photo'))){
							echo $this->Html->image("/uploads/patient_images/thumbnail/".$this->Session->read('person_photo'), array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>$title));
						}else{
							echo $this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>$title));
						}				
					?>
				</li>
				<li>Name : <?php echo $getBasicData['Patient']['lookup_name'];?></li>
				<li>Gender/Age : <?php echo ucfirst($getBasicData['Person']['sex']).'/'.$getBasicData['Patient']['age'] ;?></li>  
				<li>MRN : <?php echo $getBasicData['Patient']['admission_id'] ;?></li>
				<li>PatientId : <?php echo $getBasicData['Patient']['patient_id'] ;?></li>
				<li>Admission Date : <?php echo $this->DateFormat->formatDate2Local($getBasicData['Patient']['form_received_on'],Configure::read('date_format'),true);?></li>
				<li>Tariff : <?php echo $getBasicData['TariffStandard']['name'];?></li>
				<?php
				 if($patient['Patient']['admission_type']=='IPD') {?>
					<li>Ward/Bed : <?php echo $wardInfo['Ward']['name']."/".$wardInfo['Room']['bed_prefix']." ".$wardInfo['Bed']['bedno'];?></li>
				<?php }?>
				<li>Primary Care Provider : <?php echo $getBasicData['User']['first_name']." ".$getBasicData['User']['last_name'] ;?></li>
				<li>Mobile No. : <?php echo $getBasicData['Person']['mobile'] ;?></li>
			</ul>
		</div>
	
	<span style="float: right;padding-top: 26px">
	<h3 style="font-size:13px; float: left; padding:5px;">
	<?php echo "Search Patient : "; ?>
	</h3>
	<h3 style="font-size:13px; float: left;">
	<?php echo $this->Form->input('admision_id',array('type'=>'text','id'=>'addmissionId','label'=>false,'div'=>false,'style'=>'float:left','class'=>'textBoxExpnd'));?>
	</h3>
	<h3 style="font-size:13px; float: right;">
		<?php echo $this->Html->link('Add Services','javascript:void(0);',array('class'=>'addServices blueBtn','id'=>'addServices','escape' => false,'label'=>false,'div'=>false));?>
		<?php echo $this->Html->link('Add Combo',array('controller'=>'SmartPhrases','action'=>'index','?'=>array('nursePriscription'=>$patientId),'admin'=>true),array('class'=>'addcombo blueBtn','id'=>'addcombo','escape' => false,'label'=>false,'div'=>false));?>
	</h3>  
	</span>
</div>

<!-- <div>&nbsp;</div>
<div width="50% !important">
<?php //echo $this->element('print_patient_info');?>
</div> -->

<p class="ht5"></p> 

<?php
echo $this->Form->create('Note',array('onkeypress'=>"return event.keyCode != 13;",'id'=>'patientnotesfrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));
echo $this->Form->hidden('patientId',array('id'=>'patientId','value'=>$patientId,'autocomplete'=>"off"));
echo $this->Form->hidden('uid',array('id'=>'uid','value'=>$Uid,'autocomplete'=>"off"));
echo $this->Form->hidden('noteId',array('id'=>'noteId','value'=>$noteId,'autocomplete'=>"off"));

if($flag=='notPresent'){?>
<div align="center">
	<font color="red"><?php echo __('Drug is not present in our database, so select alternate drug.', true); ?></font>
	<?php echo $this->Form->button(__('Change Drug'), array('id'=>'changeMed','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' )); ?>
	<?php //echo $this->Form->input('NewCropPrescription.newMed', array('options'=>$temp,'empty'=>'Select alternate medication','class' => 'textBoxExpnd','id' => 'newMed','label'=> false,'style'=>'display:none'));?>
</div>
<div align="center">
	<?php echo $this->Form->input('NewCropPrescription.newMed', array('options'=>$temp,'empty'=>'Select alternate drug','class' => '','id' => 'newMed','label'=> false,'style'=>'display:none; width:250px'));?>
</div>
<?php }?>
<table width="100%" align="center">
	<tr>
		<td width="60%" valign="top"> 
		
<table class="loading" align="left" style="text-align: left; padding: 0px !important;" width="100%">
	<tr>
		<td width="" valign="top" align="left" colspan="4">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm">
				<!-- row 1 -->
				<tr>
					<td width="100%" valign="top" align="left" colspan="6">
						<table width="100%" border="0" cellspacing="1" cellpadding="0"
							id='DrugGroup' style="padding: 0px !important;margin-top: 10px;" class="tabularForm">
							<tr style='border: none;'>
								<td width="100%" colspan='15' style="border: none; display:none;">
									<div class="message" id='successMsg'
										style='display: none; color: green; text-align: center'>
										<!-- Show  sevirity  -->
									</div>
								</td>
							</tr>

							<!-- ALL DEVELOPER ITS INTERACTION DO NOT COMMENT OR DELETE -->
							<tr style='border: none !important;' id="tr0">
								<td width="100%" colspan='15'>
									<div id='showsevirity' style='display: none; color: #cc3333; border: none;'>
										<!-- Show  sevirity  -->
									</div>
								</td>
							</tr>

							<tr style='border: none !important;' id="tr1">
								<td width="100%" colspan='15'>
									<div id='interactionData' style='display: none; color: #cc3333 border: none;'>
										<!-- interaction Data  -->
									</div>
								</td>
							</tr>
							<!-- 
							<tr style='border: none !important;' id="tr2">
								<td width="50%" colspan='2'>
									<div id='overRide' style='display: none; border: none;'>
										<?php
											//	echo $this->Form->input(__('Override Instructions'),array('name'=>'override_inst[]','class'=>'','id'=>'overText','type'=>'text'));?>
									</div>
								</td>
								<td width="50%" colspan='15'>
									<div id='overRideButton' style='display: none; border: none;'>
										<?php $isOverride='1';
											//	echo $this->Form->submit(__('Override Instructions'),array('id'=>'oversubmit','class'=>'blueBtn','onclick'=>"javascript:save_med(".$isOverride.");return false;",'div'=>false,'label'=>false));?>
									</div>
								</td>
							</tr> -->
							<?php if($this->Session->read('website.instance')=='hope'){?>					
								<tr><td>Select Phrase</td>
								<td  colspan="13"><?php echo $this->Form->input('phrase_id',array('type'=>'text','id'=>'phrase','autocomplete'=>'off'));
												//echo $this->Form->input('phrase_id',array('id'=>'phrase','options'=>$phrase_array,'empty'=>'Selct Phrase','label'=>false))?></td></tr>
							<?php }?>
							<tr>
								<td  height="20" align="left" valign="top" style="padding-right: 3px;" class="tdLabel">Drug Name<font color="red">*</font></td>
								<td  align="left" valign="top" class="tdLabel">Qty<font color="red">*</font></td>
 								<?php $instance = strtolower($this->Session->read('website.instance')); 
	 								if($instance == "vadodara" || $instance == "hope"){
	 							?>
								<td  align="left" valign="top" class="tdLabel"><?php echo __("Stock"); ?></td>
								<?php if($instance == "Hope"){?>
								<td  align="left" valign="top" class="tdLabel"><?php echo __("Sale Price"); ?></td>
								<?php }else{?>
								<td  align="left" valign="top" class="tdLabel"><?php echo __("MRP"); ?></td>
								<?php }?>
								<td  align="left" valign="top" class="tdLabel"><?php echo __("Amount"); ?></td>
 								<?php } ?>
								<!-- <td  height="20" align="center" valign="top" class="tdLabel" style="text-align: center;">Strength</td>
								<td  height="20" align="left" valign="top" class="tdLabel" style="">Dosage</td>
								<td  align="left" valign="top" class="tdLabel">Dose Form</td>
								<td  height="20" align="left" valign="top" class="tdLabel">Route</td>
								<td  align="left" valign="top" class="tdLabel">Frequency</td>
								<td  align="left" valign="top" class="tdLabel">Days</td> -->
								<!-- <td  align="center" valign="top" class="tdLabel">As Needed (p.r.n)</td>
								<td  align="center" valign="top" class="tdLabel">Dispense As Written</td> -->
								<!-- <td  align="left" valign="top" class="tdLabel" style="">First Dose Date/Time</td>
								<td  align="left" 	valign="top" class="tdLabel" style="">Stop Date/Time</td> -->
								<?php if($instance == "hope"){?>
								<td  align="left" 	valign="top" class="tdLabel" style="">#</td>
								<?php }?>
								<!-- <td  align="center" valign="top" class="tdLabel">Active</td> -->
								<?php if(!empty($getMedicationRecordsXml['NewCropPrescription'])){?>
								<td  align="center" valign="top" class="tdLabel" >Action</td>
								<?php }?>
								
							</tr>
							<?php
							if(isset($getMedicationRecords) && !empty($getMedicationRecords)){
							}else{
								/* debug($this->data); */

			               				$count  = count($getMedicationRecordsXml['NewCropPrescription']) ;
			               				//debug()
			               				if($count==0){
											$count++;
											
										}
			               				 	/*debug($getMedicationRecordsXml); */
			               			for($k=0;$k<$count;$k++){ ?>
			               			
							<tr id="DrugGroup<?php echo $k;?>">
							<td align="left" valign="top" style="padding-right: 3px" ">
								<?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText validate[required,custom[mandatory-enter]] textBoxExpnd','onpaste'=>"return false" ,
										'id'=>"drugText_$k",'name'=> 'drugText[]','value'=>stripslashes($getMedicationRecordsXml['NewCropPrescription'][$k]['description']),
										'autocomplete'=>'off','counter'=>$k,'style'=>'width:95%!important;','label'=>false)); 
								echo $this->Form->hidden("",array('class'=>'allHiddenId','id'=>"drug_$k",'class'=>'validate[required,custom[mandatory-enter]]','name'=>'drug_id[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['drug_id']));
								?>
								<span id="drugType_<?php echo $k?>"></span>&nbsp;<span id="formularylinkId_<?php echo $k?>"></span>
							</td>
							
  
							<td align="left" valign="top" style="padding-right: 3px" ">
								<?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off',
										'class' => "validate[required,custom[mandatory-enter]] textBoxExpnd quantity quantity_$k",
										'id'=>"quantity$k",'style'=>'margin:0px;background:#fff!important;width:95%!important;',
										'name' => 'quantity[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['quantity'],
										'label'=>false)); ?>
 
							</td>
							
 							<?php  $instance = strtolower($this->Session->read('website.instance')); 
 								if($instance == "vadodara" || $instance == "hope"){ ?>
							<td align="left" valign="top" style="padding-right: 3px" ">
								<?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off',
											'readonly'=>'readonly','class' => "drugStock_$k textBoxExpnd",'id'=>"drugStock$k",
											'style'=>'margin:0px;background:#fff!important;width:95%!important;',
											'name' => 'drugStock[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['drugStock'],'label'=>false)); ?>
							</td>
							
 
							<td align="left" valign="top" style="padding-right: 3px" ">
								<?php echo $this->Form->input('', array('size'=>2,'type'=>'text','readonly'=>'readonly',
										'autocomplete'=>'off','class' => "textBoxExpnd salePrice_$k",'id'=>"salePrice$k",
										'style'=>'margin:0px;background:#fff!important;width:95%!important;',
										'name' => 'salePrice[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['salePrice'],
										'label'=>false)); ?>
							</td>
							
							<td align="left" valign="top" style="padding-right: 3px">
								<?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off',
										'readonly'=>'readonly','class' => "amount_$k amount textBoxExpnd",'id'=>"amount$k",
										'style'=>'margin:0px;background:#fff!important;width:95%!important;','name' => 'amount[]',
										'value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['amount']?round($getMedicationRecordsXml['NewCropPrescription'][$k]['amount']):0,'label'=>false)); ?>
							</td>
							<?php } ?>
							
							
							<!-- <td align="left" valign="top" style="padding-right: 3px">
							<?php echo $this->Form->input('', array('size'=>2,'type'=>'text',
									'style'=>'margin:0px;width:50px; background:#fff !important;','class' => 'dose_val',
									'id'=>"dose_type$k",'name' => 'dose_type[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['dose'],'label'=>false)); 
							echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),'style'=>'margin: 0 0 0 0px;width:56px;','class' => '','id'=>"Dfrom$k",'name' => 'DosageForm[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['doseForm'],'label'=>false));?>
							</td>

							<td align="left" valign="top" style="padding-right: 3px" >
							<?php echo $this->Form->input('', array('size'=>2,'type'=>'text','style'=>'margin:0px;','class' => 'dosage_Value','id'=>"dosage_value$i",'name' => 'dosageValue[]','value'=>$data['NewCropPrescription']['dosageValue'],'style'=>'width:50px!important;background-color:#fff !important;','label'=>false)); ?>
							</td>

							<td align="left" valign="top" style="padding-right: 3px">
							<?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('roop'),'style'=>'width:67px;margin: 0 0 0 0px;','class' => 'validate[,custom[mandatory-select]]','id'=>"strength$k",'name' => 'strength[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['strength'],'label'=>false)); ?>
							</td>

							<td align="left" valign="top" style="padding-right: 3px">
							<?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('route_administration'),'style'=>'width:67px;margin: 0 0 0 0px;','class' => 'validate[,custom[mandatory-select]] ','id'=>"route_administration$k",'name' => 'route_administration[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['route_administration'],'label'=>false)); ?>
							</td>
							
							<td align="left" valign="top" style="padding-right: 3px">
							<?php echo $this->Form->input('', array( 'options'=>Configure :: read('frequency'),'empty'=>'Select','style'=>'width:80px','class' => 'frequency_value','id'=>'frequency_'.$k,'name' => 'frequency[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['frequency'],'label'=>false,'style'=>'width:71px!important;'));  ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px">
							<?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => 'day','autocomplete'=>'off','id'=>"day$k",'style'=>'margin:0px;background:#fff!important;width:40px!important;','name' => 'day[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['days'],'label'=>false)); ?>
							</td> -->

							
					
							<!--  <td align="center" valign="top" style="" width="7%"><?php $options = array('1'=>'Yes','0'=>'No');
										echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"prn$k",'name' => 'prn[]','value'=>$data['NewCropPrescription']['prn'],'label'=>false,'style'=>'margin:0px;width:53px;'));?>
							</td>

							<td align="center" valign="top" style="" width="7%"><?php echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"daw$k",'name' => 'daw[]','value'=>$data['NewCropPrescription']['daw'],'label'=>false,'style'=>'margin:0px;width:53px;'));?>
							</td>-->

							<!-- <td align="center" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date1 textBoxExpnd','name'=> 'start_date[]','value'=>$data['NewCropPrescription']['start_date'], 'id' =>"start_date".$k ,'counter'=>$count,'label'=>false )); ?>
							</td>

							<td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','size'=>16,'class'=>'my_end_date1 textBoxExpnd','name'=> 'end_date[]','value'=>$data['NewCropPrescription']['end_date'],'id' => "end_date".$k,'counter'=>$count,'label'=>false)); ?>
							</td> -->
							
							
							<!-- 
							<td align="center" valign="top" style="" width="7%"><?php //$options_active = array('1'=>'Yes','0'=>'No');
										//echo $this->Form->input('', array( 'options'=>$options_active,'class' => '','id'=>"isactive$k",'name' => 'isactive[]','value'=>$data['NewCropPrescription']['isactive'],'label'=>false,'style'=>'margin:0px;width:52px;'));?>
							</td> -->
							<?php if(!empty($getMedicationRecordsXml['NewCropPrescription'])){?>
							<td align="center" valign="top" style="" ><?php $options_avd = array('0'=>'No','1'=>'Yes'); 
										echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_history','id'=>"pMH$k"));?>
							</td>
							<?php }?>
							<td><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'deleteRow','id'=>"rowDelete_$k",'onclick'=>"deleteRow($k)"));?>
							</td> 
							</tr>
							<?php }?>
							
						<?php }?>
						</table>
						
					</td>
				</tr>
				
				<!-- row 3 end -->
				<?php  if(empty($getMedicationRecords)){?>
				  <?php  $instance = strtolower($this->Session->read('website.instance')); 
 								if($instance == "vadodara" || $instance == "hope"){ ?>
				  <tr  class="total">
					<td align="left" style="padding-left: 20px" colspan='6'>
						Total Amount : <span id="totalAmount"><?php echo $total;?></span>
					</td>
				 </tr>
				<?php } ?>
				
				
				  <tr>
					
					<td align="left" style="padding-left: 20px" colspan='6'>
						<input type="button" id="addButton" value="Add Row"> <?php if($count > 1){?>
						<input type="button" id="removeButton" value="Remove"> <?php }else{ ?> 
						<input type="button" id="removeButton" value="Remove"  style="display: none;"> <?php } ?></td>
				</tr>
				<?php }?>
				
				<tr>
					<!--  <td class="tdLabel"><?php 
					 echo $this->Form->input('no_medication', array('type'=>'checkbox','id'=>'namecheck',
										'checked'=>$checked,'disabled'=>false,'label'=> false, 'div' => false, 'error' => false));?>
						<?php echo __("No Medications Currently Prescribed");?></td>-->
					<td align='left'><?php /*if(empty($getMedicationRecords)){ echo $this->Html->link('Frequently Prescribed Medication',
									'javascript:void(0)',array('onclick'=>'frequentMedication('.$Uid.','.$patientHealthPlanIDfreq.');'));}*/?>	
					</td>
					<td align='right'>
					<?php if(!empty($encPatientId)){
						if($ajaxHold!='Yes'){
						//echo $this->Html->link(__('Back'), array('controller'=>'Notes','action' => 'soapNote',$encPatientId,$noteId,'appt'=>$this->params->query['appt']), array('class'=>'blueBtn','style'=>'float:right;text-align:center;'));
					
					}}else{?>
					<?php if($ajaxHold!='Yes'){ //echo $this->Html->link(__('Back'), array('controller'=>'Notes','action' => 'soapNote',$patientId,$noteId,'appt'=>$this->params->query['appt']), array('class'=>'blueBtn','style'=>'float:right;text-align:center;'));
					}}?>
					<?php //if($nurseFlag){ ?>
					<?php //echo $this->Form->submit(__('Save Medication'),array('id'=>'labsubmit','class'=>'blueBtn','onclick'=>"javascript:saveRdirect();return false;",'style'=>'float:right; width:150px; margin: 0 10px 0 0;')); 
						//}else{
						echo $this->Form->submit(__('Save Medication'),array('id'=>'labsubmit','class'=>'blueBtn','onclick'=>"javascript:save_med();return false;",'style'=>'float:right; width:150px; margin: 0 10px 0 0;'));
						echo $this->Form->button(__('Reset'),array('id'=>'reload','class'=>'grayBtn','onclick'=>"window.location.reload();return false;",'style'=>'float:right;'));
				//	}
					?>
					</td>
					

				</tr>
                <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			</table>
			
			
		</td>
	</tr>
</table>
</td>
<td width="1%" valign="top"></td>  
<?php 
/** check if medication ids given by nurse -mrunal **/ 
if($nurseFlag){
	echo $this->Form->input('by_nurse',array('name'=>'by_nurse','type'=>'hidden','value'=>1));
	
}
/** EOD **/
echo $this->Form->end(); ?>
<!-- 

<table class="loading" style="text-align: left; padding: 0px !important;margin: 11px auto 0; " width="99%">

</table> -->

<!-- DIV FOR PREVIOUS PRESCRIPTION  - -YASHWANT- -  -->
<td width="39%" valign="top"> 
<table class="tabularForm" style="text-align: center; padding: 0px !important;" width="100%">
	<tr>
		<td><strong><?php echo ('Previously Prescribed Medications');?></strong></td>
	</tr>
	<tr>
		<td>
		<table >
			<tr>
			<?php $defaultDate=$getPreviousMedication[0]['NewCropPrescription']['drm_date'];
			foreach($getPreviousMedication as $getPreviousMedication){ ?>
			<td>
			<?php $previousDate=$this->DateFormat->formatDate2Local($getPreviousMedication['NewCropPrescription']['drm_date'],Configure::read('date_format'),false);
				  echo $this->Html->link($previousDate,'javascript:void(0);',array('class'=>'previousPrescriptionDate','id'=>'previousPrescriptionDate_'.$getPreviousMedication['NewCropPrescription']['drm_date'],
					'escape' => false,'label'=>false,'div'=>false));?>
			</td>
			<?php }?>
			</tr>
		</table>
		</td>
	</tr> 
</table>  

<div id="previousPriscriptionDiv">&nbsp;</div>
</td>
	</tr>
</table>
<!-- EOF DIV  - -YASHWANT- - -->


<div id="formularyData"></div>
<script >
var instance = "<?php echo strtolower($this->Session->read('website.instance')); ?>";
$(document).ready(function(){//render default latest dated medication  --yashwant
	defaultDate='<?php echo $defaultDate;?>';
	if(defaultDate==''){
		var today = new Date(); 
		defaultDate=today.format('Y-m-d');
	}
	patientID='<?php echo $patientId;?>';
	previouslyPrescribedMed(patientID,defaultDate);
});

var currentDateForAddMore='';
var splitCurrentDateForAddMore='';
		//$('.drugText').on('focus',function() {
		$(document).on('focus', '.drugText', function() { // Important
					var currentId=	$(this).attr('id').split("_"); // Important
					var attrId = this.id;
					var t = $(this);
					var counter = $(this).attr("counter");
				
				$(this).autocomplete({
					 source: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "newPharmacyComplete","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,
					 
					 select: function( event, ui ) {
						selectedId = t.attr('id');
						/* Code By Mrunal - to restrict multiple selction of single item  */
						var currentField = $("#"+selectedId);
						var idDrug = ui.item.drug_id; 				//Pharmacy item ID
						var drugName = ui.item.value;				//Pharmacy DRUG name
						var itemid = ui.item.id;
	                	var exist = false;
	                	
	                	// Code to clear all the values as Drug is removed from the text box - By Mrunal
	                	$('#drugText_'+counter).keyup(function(){
		                
			               if($.trim(this.value.length) < $.trim(drugName.length)){

		                		$("#drugText_"+counter).focus("");
			       				$("#drug_"+counter).val("");
			       				$("#quantity"+counter).val("");
			       				$('#drugStock'+counter).val("");
			       				$('#salePrice'+counter).val("");
			       				$('#amount'+counter).val("");
			       				$('#dose_type'+counter).val("");
			       				$('#dosage_value'+counter).val("");
			       				$('#strength'+counter).val("");
			       				$('#route_administration'+counter).val("");
			       				$('#frequency_'+counter).val("");
			       				$('#day'+counter).val("");
			       				$('#start_date'+counter).val("");
			       				$('#end_date'+counter).val("");
			       				return false;
		            		}
		            		
		            	});
		            	// END of CODE
	                	
		              		$('#quantity'+currentId[1]).focus();
		                	$('#drug_'+currentId[1]).val(ui.item.drug_id);
							$('#drugStock'+currentId[1]).val(ui.item.stock);
							$('#salePrice'+currentId[1]).val(ui.item.mrp);	

					},
					 messages: {
					        noResults: '',
					        results: function() {}
					 }
				});
				/*$(this)
					.autocomplete(
																														
						"<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','null','name',"admin" => false,"plugin"=>false)); ?>",
						{
							width : 250,
							selectFirst : true,
							valueSelected:true,
							minLength: 1,
							delay: 1000,
							isOrderSet:true,
							showNoId:true,
							/*loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'drugStock')
							+','+$(this).attr('id').replace("drugText_",'strength')+','+$(this).attr('id').replace("drugText_",'route_administration'),
							*/


							/*loadId : $(this).attr('id')+','
									+$(this).attr('id').replace("Text_",'_')+','
									+$(this).attr('id').replace("drugText_",'drugStock')+','
									+$(this).attr('id').replace("drugText_",'salePrice')+','
									+$(this).attr('id').replace("drugText_",'dose_type')+','
									+$(this).attr('id').replace("drugText_",'strength')+','
									+$(this).attr('id').replace("drugText_",'route_administration'),
														
							onItemSelect:function(event, ui) { 
								
							}
							
						});*/

				});//EOF autocomplete
				//add n remove drud inputs
				var counter = '<?php echo $count; ?>';
				var calenderAry = new Array();
				 $("#addButton").click(
							function() { 
								//$("#patientnotesfrm").validationEngine('detach');  
								var newCostDiv = $(document.createElement('tr'))
								     .attr("id", 'DrugGroup' + counter);
								var str_option_value='<?php echo $str;?>';							
								var route_option_value='<?php echo $str_route;?>';
								var dose_option_value='<?php echo $str_dose;?>';
								var roopNameConfig='<?php echo $roopName;?>';
								var freqConfig='<?php echo $frequency_var;?>'; 
								var dose_option ='<select style="background: #fff !important;width: 100px !important;" id="dose_type'+counter+'" class="validate[required,custom[mandatory-select]] dose_val" name="dose_type[]"><option value="">Select</option>'+dose_option_value;
								var dosage_form = '<select style="margin: 0 0 0 0px; width:56px", id="Dfrom'+counter+'" class="dosageform" name="DosageForm[]"><option value="">Select</option>'+str_option_value;
								var route_option = '<select style="width:67px;margin: 0 0 0 0px;" id="route_administration'+counter+'" class="" name="route_administration[]"><option value="">Select</option>'+route_option_value;
								var frequency_option = '<select style="width:67px;margin: 0 0 0 0px;" id="frequency_'+counter+'" class="frequency_value" name="frequency[]"><option value="">Select</option>'+freqConfig;
								//var frequency_option = '<select  style="width:67px;margin: 0 0 0 0px;", id="frequency_'+counter+'" class="frequency_value validate[required,custom[mandatory-select]]  " name="frequency[]"><option value="">Select</option><option value="1">As directed</option><option value="2">Daily</option><option value="4">In the morning, before noon</option><option value="5">Twice a day</option><option value="6">Thrice a day</option><option value="7">Four times a day</option><option value="29">Every 2 hours</option><option value="28">Every 3 hours</option><option value="8">Every 4 hours</option><option value="9">Every 6 hours</option><option value="10">Every 8 hours</option><option value="11">Every 12 hours</option><option value="26">Every 48 hours</option><option value="23">Every 72 hours</option><option value="24">Every 4-6 hours</option><option value="13">Every 2 hours with assistance</option><option value="14">Every 1 week</option><option value="15">Every 2 weeks</option><option value="16">Every 3 weeks</option><option value="25">Every 1 hour with assistance</option><option value="12">Every Other Day</option><option value="27">2 Times Weekly</option><option value="20">3 Times Weekly</option><option value="22">Once a Month</option><option value="18">Nightly</option><option value="19">Every night at bedtime</option><option value="35">Fasting</option><option value="31">Stat</option><option value="32">Now</option><option value="34">ONCE A DAY BEFORE BREAKFAST</option><option value="35">ONCE A DAY AFTER BREAKFAST</option><option value="36">TWICE A DAY BEFORE MEALS</option><option value="37">TWICE A DAY AFTER MEALS</option><option value="38">FORTNIGHTLY</option><option value="39">ALTERNATE DAY</option></select>';
								var refills_option = '<select style="width:67px;margin: 0 0 0 0px;" id="strength'+counter+'" class="frequency" name="strength[]"><option value="">Select</option>'+roopNameConfig;
								var strength_option = '<select style="width:79px;" id="strength'+counter+'" class="" name="strength[]"><option value="">Select</option>'+str_option_value;
				
								/*var prn_option = '<select style="width:auto;" id="prn'+counter+'" class="" name="prn[]"><option value="1">Yes</option><option value="0">No</option></select>';
								var daw_option = '<select style="width:auto;" id="daw'+counter+'" class="" name="daw[]"><option value="1">Yes</option><option value="0">No</option></select>';*/
								var active_option = '<select style="width:auto;" id="isactive'+counter+'" class="" name="isactive[]"><option value="1">Yes</option><option value="0">No</option></select>';
								<?php if(!empty($getMedicationRecordsXml['NewCropPrescription'])){?>
								var is_adv = '<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_history','id'=>"pMH$count"));?>';
								<?php }else{?>
									var is_adv=" ";
								<?php }?>
								var is_delete = '<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'deleteRow','id'=>"rowDelete_$count",'onclick'=>"deleteRow($count)"));?>';
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
					timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 67px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
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
					var newHTml = "";
						newHTml += '<td valign="top"><input  type="text" style="width:95%!important;" value="" id="drugText_' + counter + '"  class="drugText  textBoxExpnd validate[required,custom[mandatory-enter]]" onpaste="return false" name="drugText[]" autocomplete="off" counter='+counter+'>'+
										'<input  type="hidden" class="allHiddenId" id="drug_' + counter + '"  name="drug_id[]" > <span id="drugType_' + counter + '"></span>&nbsp;<span id="formularylinkId_' + counter + '"></span></td>'

 
							+ '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'"  autocomplete="off" class="textBoxExpnd validate[required,custom[mandatory-enter]] quantity quantity_'+counter+'" name="quantity[]" autocomplete="off" style="background:#fff !important;width:95%!important;"></td>';
						if(instance == "vadodara" || instance == "hope") { 
							newHTml += '<td valign="top"><input size="2" type="text" value="" id="drugStock'+counter+'" readonly="readonly" class="textBoxExpnd drugStock_'+counter+'" name="drugStock[]" style="background:#fff !important;width:95%!important;"></td>'
							+ '<td valign="top"><input size="2" type="text" value="" id="salePrice'+counter+'" readonly="readonly" class="textBoxExpnd salePrice_'+counter+'" name="salePrice[]" style="background:#fff !important;width:95%!important;"></td>'
							+ '<td valign="top"><input size="2" type="text" value="0" id="amount'+counter+'" readonly="readonly" class="textBoxExpnd amount_'+counter+' amount" name="amount[]" style="background:#fff !important;width:95%!important;"></td>';
						}
										
					newHTml += /*'<td valign="top" ><input size="2" type="text" value="" id="dose_type'+counter+'"  name="dose_type[]" "autocomplete"="off" style="background:#fff !important;margin:0px;width:50px;">'+dosage_form+'</td>'
							+ '</td><td valign="top">'  
							+ '<input size="2" type="text" value="" id="dosage_value'+counter+'" class="dosage_Value" name="dosageValue[]" "autocomplete"="off" style="margin:0px;width:50px !important;background-color:#fff !important;">'
							+ '</td><td valign="top">'
							+ refills_option
							+ '</td>'
							
							+ '<td valign="top">'
							+ route_option
							+ '</td>'
							+ '<td valign="top">'
							+ frequency_option
							+ '</td>'
							+ '<td valign="top" ><input size="2" type="text" value="" id="day'+counter+'" class="day" name="day[]" "autocomplete"="off" style="background:#fff !important;width:40px!important;"></td>'*/
							
							/*+ '<td valign="top" align="center">'
							+ prn_option
							+ '</td>'
							+ '<td valign="top" align="center">'
							+ daw_option
							+ '</td>'*/
							/*+ '<td valign="top" align="center"><input  type="text" value="" id="start_date' + counter + '"  class="my_start_date'+ counter +' textBoxExpnd" name="start_date[]"  size="16" counter='+counter+'></td>'
							+ '<td valign="top" align="center"><input  type="text" value="" id="end_date' + counter + '"  class="my_end_date'+ counter +' textBoxExpnd" name="end_date[]"  size="16" counter='+counter+'></td>'*/
							/*+ '<td valign="top" align="center">'
							+ active_option
							+'</td>'*/
							/*+*/'<td> <a href="javascript:void(0);" id="rowDelete_'+counter+'" onclick="deleteRow('+counter+');"> <?php echo $this->Html->image("icons/cross.png",array("alt"=>"Delete", "title"=>"Delete")); ?></a>'
							+'</td>'
							;

					//newCostDiv.append(newHTml);
					//newCostDiv.appendTo("#DrugGroup");
					//$("#patientnotesfrm").validationEngine('attach'); 			 			 
					newCostDiv.append(newHTml);		 
					newCostDiv.appendTo("#DrugGroup");
					//$("#patientnotesfrm").validationEngine('attach'); 		 			 
					/*var endDate = $("#start_date"+counter).val();
						spltEndDate = endDate.split(' ');
						spltEndDate[0] = spltEndDate[0].split('/');
						spltEndDate[0][1]--;
						spltEndDate = spltEndDate[0]+','+spltEndDate[1];
						var dateStr = '';
						 	$("#start_date"+counter).datepicker({
								showOn : 'both',
								changeYear : true,
								changeMonth : true,
								yearRange : '1950',
								buttonText: "Calendar",
								buttonImageOnly : true,
								dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
								//minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
								onSelect : function(selDate) {
									spltDateSplitted = selDate.split(' ');
									var splitDate = spltDateSplitted[0].split("/");
									  splitDate[1]--;
									  dateStr = splitDate+' '+spltDateSplitted[1];
									  
								//	  $("#end_date"+counter).datepicker("destroy");

								   
									  $("#end_date"+counter).datepicker({
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',
											dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
											showOn : 'both',
											buttonText: false ,
											//minDate: new Date(dateStr),
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											buttonText: "Calendar",
											onSelect : function() {
												if($("#start_date"+counter).val() == '') $(this).val('');
											}
										});
								}
							});*/

						  /*$("#end_date"+counter).datepicker({
								changeMonth : true,
								changeYear : true,
								yearRange : '1950',
								dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
								showOn : 'both',
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
								buttonImageOnly : true,
								buttonText: "Calendar",
								minDate: new Date(),
								onSelect : function() {
									if($("#start_date"+counter).val() == '') $(this).val('');
								}
							});*/
					$("#drugText_"+counter).focus();		
					counter++;
					if (counter > 1)
						$('#removeButton').show('slow');
					$(document).scrollTop($(document).height());  
				});

					
					$(document).ready(function(){
						/*var endDate = $("#start_date0").val();
						spltEndDate = endDate.split(' ');
						spltEndDate[0] = spltEndDate[0].split('/');
					//	spltEndDate[0][1]--;
						spltEndDate = spltEndDate[0]+','+spltEndDate[1];
						 	$("#start_date0").datepicker({
								showOn : 'both',
								changeYear : true,
								changeMonth : true,
								yearRange : '1950',
								buttonText: "Calendar",
								buttonImageOnly : true,
								dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
								//minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
								onSelect : function(selDate) {
									spltDateSplitted = selDate.split(' ');
									var splitDate = spltDateSplitted[0].split("/");
									//  splitDate[1]--;
									  var dateStr = splitDate+' '+spltDateSplitted[1];
									//tt(dateStr);
									$("#end_date0").datepicker("option", "minDate", new Date(splitDate[2], splitDate[0], splitDate[1], 0, 0, 0, 0));
								}
							});

						  function tt(dateStr){
							// $('#end_date0').removeClass('hasDatepicker');
							 $("#end_date0").datepicker("destroy");
							 // $._clearDate(); 
							  $("#end_date0").datepicker({
									changeMonth : true,
									changeYear : true,
									yearRange : '1950',
									dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
									showOn : 'both',
									buttonText: false ,
									//minDate: 
									buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly : true,
									buttonText: "Calendar",
									onSelect : function() {
										if($("#start_date0").val() == '') $(this).val('');
									}
								});
							  
						  }
						    
							
						 	$("#end_date0").datepicker({
								changeMonth : true,
								changeYear : true,
								yearRange : '1950',
								dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
								showOn : 'both',
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
								buttonImageOnly : true,
								buttonText: "Calendar",
								//minDate: new Date(),
								onSelect : function() {
									if($("#start_date0").val() == '') $(this).val('');
								}
							});*/
						
					});
					
					$("#removeButton").click(function() {
						/*if(counter==3){
						  alert("No more textbox to remove");
						  return false;
						}  */
						counter--;

						
						$("#DrugGroup"+counter).remove();
						if (counter == 1)
							$('#removeButton').hide('slow');
						
						var sum = 0;
						$(".amount").each(function(){
							sum += parseFloat(this.value); 
						}); 
						$("#totalAmount").html(sum.toFixed());
					});

				 $('.DrugGroup_history').on('click',function (){
			    	if(confirm("Do you really want to delete this record?")){
				    
				        var trId = $(this).attr('id').replace("pMH","DrugGroup");
				        $('#' + trId).remove();
				    	counter--;			 
				    	if(counter == 1) $('#removeButton').hide('slow');
				    }else{
						return false;
				    }

			    	if('<?php echo $getMedicationRecords[0][NewCropPrescription][id];?>'!=''){
		    		currentId = '<?php echo $getMedicationRecords[0][NewCropPrescription][id];?>';
			    	}else{
			    		currentId='null';
				    }

			    	if('<?php echo $getMedicationRecords[0][NewCropPrescription][drug_id];?>'!=''){
			    		drugId = '<?php echo $getMedicationRecords[0][NewCropPrescription][drug_id];?>';
			    	}else{
			    		drugId='null';
				    }
		    		
		    		is_deleted='1';

		    		//alert(currentId);alert(drugId);alert(is_deleted);return false;
    				//if(document.getElementById('namecheck').checked){
    					$.ajax({
    						  type : "POST",
    						  url: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addMedication",$patientId,"admin" => false)); ?>"+"/"+drugId+"/"+currentId+"/"+is_deleted,
    						  context: document.body,	
    						//  data : "value="+value,
    						  beforeSend:function(){
    							  loading('loading','class');
    						  }, 	  		  
    						  success: function(data){
    							  window.location.href="<?php echo $this->Html->url(array("controller"=>'Notes',"action" => "soapNote",$patientId,$noteId));?>"+"/"+null+"?msg=saved",
    								//$('#flashMessage', parent.document).html("Medication Deleted Successfully.");
    								//$('#flashMessage', parent.document).show();
    							  onCompleteRequest('loading','class')();
    						  }
    					});			
    				//}			
	    		 });

/*$('.allHiddenId').click(function(){
	var currentElementId = $(this).attr('id'); 
	var faultValue = currentElementId.split('_');
	var drug = $('#drug_'+faultValue['1']).val();
	if(drug==""){
		
	}
});*/
				 
function save_med(isOverride){
	var checkExit='0';
	var is_nurse="<?php echo $nurseFlag;?>"; 
	var validateDiagnosis = jQuery("#patientnotesfrm").validationEngine('validate');
	//alert(validateDiagnosis);

	
		jQuery('.allHiddenId').each(function() { 
		    var currentElement = $(this); 
			var value = currentElement.val(); 
		    if(value==''){
		    	 var currentElementId = $(this).attr('id');
				   var faultValue=currentElementId.split('_');
				   var faultNameById=$('#drugText_'+faultValue['1']).val();
				   var drug = $('#drug_'+faultValue['1']).val(); 
				   if(drug==""){
					   alert(drug+':Is not a valid drug please select other.');
				   }	
			   // alert(faultNameById+':Is not a valid drug please select other.');
			    checkExit++;
		    	
		    }
		});
	
	
	if (validateDiagnosis == true) {
		$(this).css('display', 'none');
		$("#labsubmit").hide();
		$('#flashMessage', parent.document).show();
		$('#flashMessage', parent.document).html("Succesfully Prescibed");
		
		defaultDate='<?php echo $defaultDate;?>';
		
		if(defaultDate==''){
			var today = new Date(); 
			defaultDate=today.format('Y-m-d');
		}
		patientID='<?php echo $patientId;?>';
		previouslyPrescribedMed(patientID,defaultDate);
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'Notes','action'=>'addNurseMedication',$patientId,'?'=>array('from'=>'Nurse')))?>";
		
	}else{ 
		
		return false ;
	}
	if(checkExit>0){
		//return false;
	}
	
	if((isOverride!='1')||(isOverride==='undefined')){
		isOverride='0';
	}
	else{
		//var chkConfrim=confirm('Are you sure you want to override?');
		/*if($.trim(chkConfrim)=='false'){
			 $('#successMsg').show();
			 $('#successMsg').html("Please change the medication.");
			 $('#busy-indicator').hide('fast');
			 return false;
		}*/
		//isOverride=isOverride;
	}
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "save_med","admin" => false)); ?>"+"/"+isOverride;
	var ClinicalEffects='';
	$.ajax({
		type : "POST",
		data:$('#patientnotesfrm').serialize(),
		url : ajaxUrl , 
		beforeSend : function() {
			$('#busy-indicator').show('fast');
        	},
		//context : document.body,
		success: function(data){
			var avoidError="<?php echo $nurseFlag;?>"
				if(avoidError==''){
					getSubData();
				}
			$('#alertMsg').show();
			 $('#alertMsg').html('Medications Saved Successfully.');
			 $('#alertMsg').fadeOut(5000);
			 $('#Prescription').hide();
			if((data != '') && (data !== undefined) && (data != 1)){
				data = jQuery.parseJSON(data);
				//console.log(data);
				if(data.DrugDrug != null ){
					$.each(data.DrugDrug,function(index,value){
						ClinicalEffects+=value;
						ClinicalEffects += '</br>';
					});
					//if(data.DrugDrug.SeverityLevel!=null){
						////var ClinicalEffects= data.DrugDrug.rowDta.DrugInteraction.ClinicalEffects;
						$('#showInteractions').show();
						$('#showInteractions').html(ClinicalEffects);
						//getSubData();
						//var SeverityLevel=data.DrugDrug.rowDta.DrugInteraction.SeverityLevel;
						$('#showsevirity').show();
						$('#showsevirity').html(ClinicalEffects);
					//} 
				}else{
					$('#interactionData').html("");
				}
				
				
				var allergy='';
			if(data.Interaction!= null){
				//console.log(data.Interaction.rowDta);
				$.each(data.Interaction,function(index,value){
					//alert(value);
					//return false;
					allergy+=value;
					allergy += '</br>';
				});
			  //  var interactionData=data.Interaction;
			    $('#interactionData').show();
				$('#interactionData').html("ALLERGY INTERACTION:<br/>"+allergy);
			}else{
				$('#interactionData').html("");
			}
				$('#overRide').show();
				$('#overRideButton').show();
				$('#busy-indicator').hide('fast');
				return false;
			
			}else{
				 
				    $('#showsevirity').hide();
					$('#showInteractions').hide();
					$('#overRide').hide();
					$('#overRideButton').hide();
					$('#interactionData').hide();
				    $('#busy-indicator').hide('fast');
				    if('<?php echo $encPatientId?>'!=''){
					//window.location.href='<?php echo $this->Html->url(array("controller"=>'notes',"action" => "soapNote",$encPatientId,$noteId,'?'=>array('msg'=>'saved')));?>'
				    }else{
				    //	window.location.href='<?php echo $this->Html->url(array("controller"=>'notes',"action" => "soapNote",$patientId,$noteId,'?'=>array('msg'=>'saved')));?>'
				    }
							    //$( '#flashMessage', parent.document).html("Medication saved succesfully.");
					$('#flashMessage', parent.document).show();
				    //parent.$.fancybox.close();
				
			}
			},
		
		error: function(message){
		//alert("Connection Error please try after some time.");
		}
		
	});
}
					
	/* Commented by Mrunal */
					
		//$('.frequency_value').on('change',function(){ 
			/*$(document).on('change', '.frequency_value', function() {
			currentId = $(this).attr('id') ;		
	  		splittedVar = currentId.split("_");		 
	  		Id = splittedVar[1];	  	
	  		if($(this).val()=='32'){
				$('#dose_type'+Id).val('2');	
				$('#day'+Id).val('1');
				$('#quantity'+Id).val('1');
				return false;
	  		}else if($('#frequency_'+Id).val()=='31'){ 
				$('#day'+Id).val('1');
	  			freq='1';
				dose=$('#dose_type'+Id).val();			
				if(dose=='')dose='1';
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';			
				qty=(dose)*(freq);
				qtyId=$('#quantity'+Id).val(qty);
				
				$('#dose_type'+Id).val('2'); 
	  		}else if($('#dose_type'+Id).val()=="" || $('#frequency_'+Id).val()==""){
	  			$('#quantity'+Id).val("");
				return false;
			}else{
		  		freq_val = <?php echo json_encode(Configure::read('frequency_value'));?>;
				freq=$(this).val(); 
				dose=$('#dose_type'+Id).val();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freq_val1=freq_val[$.trim(freq)];
				qty=(dose)*(freq_val1);
				qtyId=$('#quantity'+Id).val(qty);
				$('#day'+Id).val("30");
			}
		});*/

		//$('.dose_val').on('change',function(){ 
		/*	$(document).on('change', '.dose_val', function() {
			currentId = $(this).attr('id') ;
			Id = currentId.slice(-1);

			if($('#dose_type'+Id).val()=="" || $('#frequency_'+Id).val()==""){
				$('#quantity'+Id).val("");
				return false;
			}else if($('#frequency_'+Id).val()=='31'){ 
				$('#day'+Id).val('1');
				doseID=$(this).attr('id');
				dose=$('#'+doseID+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freq='1';
				qty=(dose)*(freq); 
				if(qty == 0){ 
					qty = "";
				}
				qtyId=$('.quantity_'+Id).val(qty);
	  		}else if($('#frequency_'+Id).val()=='32'){ 
				$('#day'+Id).val('1');
				doseID=$(this).attr('id');
				dose=$('#'+doseID+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freq='1';
				qty=(dose)*(freq); 
				if(qty == 0){ 
					qty = "";
				}
				qtyId=$('.quantity_'+Id).val(qty);
	  		}else{
				doseID=$(this).attr('id');
				dose=$('#'+doseID+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freq=$('#frequency_'+Id).val();
				freq_val = <?php echo json_encode(Configure::read('frequency_value'));?>;
				freq_val1=freq_val[$.trim(freq)]; 
				qty=(dose)*(freq_val1);
				if(qty == 0){ 
					qty = "";
				}
				qtyId=$('.quantity_'+Id).val(qty);
				$('#day'+Id).val("30");
			}
		});*/
/* END of Commented */
		/*** This day function Commented  By- Mrunal ***/
		/*	$(document).on('keyup','.day', function() { 
				days=$(this).val();
				currentId = $(this).attr('id') ;
				
				Id = currentId.slice(-1);
				if($(this).val()==""){
					$('.quantity_'+Id).val("");
				}
				dose=$('#dose_type'+Id).val();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freqency=$('#frequency_'+Id+' option:selected').val();
				
				if(freqency=='1' || freqency=='2' || freqency=='4' || freqency=='18' || freqency=='19' || freqency=='35' || freqency=='32'
					|| freqency=='31' || freqency=='34' || freqency=='35' || freqency=='42'|| freqency=='43'|| freqency=='44')freqency='1';
			if(freqency=='5'||freqency=='11' ||freqency=='36'||freqency=='37')freqency='2';
			if(freqency=='6'||freqency=='10')freqency='3';
			if(freqency=='7'||freqency=='9' ||freqency=='24')freqency='4';
			if(freqency=='28'||freqency=='24')freqency='8';
			if(freqency=='26'||freqency=='12'||freqency=='39')freqency='0.5';
			if(freqency=='29')freqency='12';
			if(freqency=='8')freqency='6';
			if(freqency=='23')freqency='0.33';
			if(freqency=='14' || freqency=='40')freqency='0.1429';
			if(freqency=='15' || freqency=='38')freqency='0.0714';
			if(freqency=='16')freqency='0.0476';
			if(freqency=='25')freqency='16';
			if(freqency=='27')freqency='0.2857';
			if(freqency=='20')freqency='0.4856';
			if(freqency=='22')freqency='0.0333';	
			
				qty=dose*freqency*days;
				$('.quantity_'+Id).val(qty);
				return;
			});*/
		/*
		$('#oversubmit').click(function(){
			if($('#overText').val()==''){
				alert('Please Override Text');
				return false;
			}
			});
		*/
		/* audit for the inactive medications Aditya*/
		$('.showLogPopUp').change(function(){
			//newCrop
			var currentIdOfDropDown=$(this).attr('id');
			var currentValue=$('#'+currentIdOfDropDown).val();
			if(currentValue=='0'){
				$('#showlogTextArea').show();
			}
			});

		function selectAlternateDrug(patientId,drugId,healthPlanId,sequenceNo)
		{
			
				$.ajax({

					
			     type: 'POST',
			     url:  "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getAlternateDrugFormulary", "admin" => false)); ?>"+"/"+patientId+"/"+drugId+"/"+healthPlanId+"/"+sequenceNo,
			     dataType: 'html',
			     beforeSend:function(){ 
			    	 $('#busy-indicator').show('fast');; 
			     },
			     success: function(data){		
			    	  data = data.trim();	
			    	  	 
			    	  if(data != ''){
			    		  $("#formularyData").html(data);
			    		  
			    		 
				      }else{
				    	  inlineMsg(id,$('#loading-text').html(),10); 
				    	 
				      }
			    	  $('#busy-indicator').hide('fast');; 
			     },
				 error: function(message){
					  inlineMsg(id,$('#loading-text').html(),5); 	     
					   
			     }        
			});
			
		}
		/*----------------EOF-----------------------*/
		function frequentMedication(patientId,healthPlanId)
		{
				$.ajax({
			     type: 'POST',
			     url:  "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "getFrequentMedication", "admin" => false)); ?>"+"/"+patientId+"/"+healthPlanId,
			     dataType: 'html',
			     beforeSend:function(){ 
			    	 $('#busy-indicator').show('fast');; 
			     },
			     success: function(data){		
			    	  data = data.trim();	
			    	  	 
			    	  if(data != ''){
			    		  $("#formularyData").html(data);
			    		  
			    		 
				      }else{
				    	  inlineMsg(id,$('#loading-text').html(),10); 
				    	 
				      }
			    	  $('#busy-indicator').hide('fast');; 
			     },
				 error: function(message){
					  inlineMsg(id,$('#loading-text').html(),5); 	     
					   
			     }        
			});
			
		}

		/*$('.isadv').live('change',function(){
			if($(this).val()=='1'){
				currentId = $(this).attr('id') ;
				Id = currentId.slice(-1);
				$('#dose_type'+Id).val('2');	
				$('#frequency_'+Id).val('32');
				$('#day'+Id).val('1');
				$('#quantity'+Id).val('1');
			}
		});*/


$('#changeMed').click(function(){
	$('#newMed').show();
	return false;
});

$('#newMed').change(function(){ 
	if($(this).val() !=""){
		valmed=document.getElementById("newMed").options[document.getElementById('newMed').selectedIndex].text;
		$('.medName').val(valmed);
		$('.allHiddenId').val($(this).val());
	}
});


$(".my_end_date1").datepicker({
	changeMonth : true,
	changeYear : true,
	yearRange : '1950',
	dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
	showOn : 'both',
	buttonText: false ,
	//minDate: new Date(dateStr),
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	buttonText: "Calendar",
	onSelect : function() {
		if($("#start_date"+counter).val() == '') $(this).val('');
	}
});
$(".my_start_date1").datepicker({
	changeMonth : true,
	changeYear : true,
	yearRange : '1950',
	dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
	showOn : 'both',
	buttonText: false ,
	//minDate: new Date(dateStr),
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	buttonText: "Calendar",
	onSelect : function() {
		if($("#start_date"+counter).val() == '') $(this).val('');
	}
});

function saveRdirect(){
	var validateDiagnosis = jQuery("#patientnotesfrm").validationEngine('validate');
	if (validateDiagnosis == true) {
		$(this).css('display', 'none');
		if(event.keyCode==13){		//key enter
			e.stopPropagation();return false;
	    }
			    
		$( '#flashMessage', parent.document).html("Succesfully Prescibed");
		$('#flashMessage', parent.document).show();
		//window.location.href = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'doctor_dashboard'))?>";
	}else{
		return false ;
	}
	
}


	//get previous Prescription Date  --yashwant
	$('.previousPrescriptionDate').on('click',function(){
		currentID=$(this).attr('id');
		splitedVar=currentID.split('_');
		date=splitedVar[1];
		//salesId=splitedVar[1];
		patientID='<?php echo $patientId;?>';
		previouslyPrescribedMed(patientID,date);
	});

	function previouslyPrescribedMed(patientID,date){
		//alert(patientID);alert(salesId);
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "nursePrescription","admin" => false)); ?>"+'/'+patientID+'/'+date;
		   	$.ajax({
		     	beforeSend : function() {
		         	//loading("outerDiv","class");
		     		$("#busy-indicator").show();
		       	},
		     type: 'POST',
		     url: ajaxUrl,
		     dataType: 'html',
		     success: function(data){
		     	
		     	$("#busy-indicator").hide();
		     	if(data!=''){
		     		 $('#previousPriscriptionDiv').html(data);
		     	}
		     	//window.location.href = "<?php echo $this->Html->url(array('controller'=>'Notes','action'=>'addNurseMedication',$patientId,'?'=>array('from'=>'Nurse')))?>";
		     	
		     },
			});
	}

	$('#addServices').on('click',function(){
		 window.location.href="<?php echo $this->Html->url(array("controller"=>'Billings',"action" => "addNurseServices",$patientId));?>";
	});

	$(document).on('keyup','.quantity', function(e) { 
		if(instance == "hope" || instance == "vadodara"){ //codition commneted by pankaj w
		var id = $(this).attr('id'); 
		splittedArr = id.split('quantity'); 
		var quantity = parseInt($("#quantity"+splittedArr[1]).val() ? $("#quantity"+splittedArr[1]).val() : 0); 
		if(quantity == 0){
			$("#quantity"+splittedArr[1]).val("");
		}
		var stock = parseInt($("#drugStock"+splittedArr[1]).val() ? $("#drugStock"+splittedArr[1]).val() : 0);
		var salePrice = parseFloat($("#salePrice"+splittedArr[1]).val() ? $("#salePrice"+splittedArr[1]).val() : 0);

		
		if($("#quantity"+splittedArr[1]).val() != ''){
				if(e.keyCode == 13){//key enter
				$("#addButton").trigger('click');
			}
			//$(".drugText").focus();
		} 
		if(/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
		
		/*	if(quantity > stock){
				alert("Quantity Is Greater Than Stock");
				$("#quantity"+splittedArr[1]).val('');
				$("#quantity"+splittedArr[1]).focus();
				return false;
			}else{*/
				var amount = quantity * salePrice;
				if(isNaN(amount)==true)
					amount = 0;
				$("#amount"+splittedArr[1]).val(amount.toFixed());
				var sum = 0;
				$(".amount").each(function(){
					sum += parseFloat(this.value); 
				});
				$("#totalAmount").html(sum.toFixed(2));
			//}
	    }
	});	 

	/*$('.deleteRow').on('click',function (){ alert('hi');
		if(confirm("Do you really want to delete this record?")){
		    
	        var trId = $(this).attr('id').replace("rowDelete_","DrugGroup"); 
	        $('#' + trId).remove();
	    	counter--;			 
	    	//if(counter == 1) $('#removeButton').hide('slow');
	    }else{
			return false;
	    }
	});*/   

	function deleteRow(id){ 
		$("#DrugGroup"+id).remove(); 
		var sum = 0;
		var amnt = $('.amount').val(); 
		$(".amount").each(function(){
			sum += parseFloat(this.value); 
		}); 
		$("#totalAmount").html(sum.toFixed(2));
		
	}

	$(document).on('focus', '#phrase', function() {
		$(this).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "phraseComplete","admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				 pharseName=ui.item.value;
				 var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "phraseMedication","admin" => false)); ?>";
					$.ajax({
				    	beforeSend : function() {
				    		$('#busy-indicator').show('fast');
				    	},
				   	url: ajaxUrl+'/'+pharseName,
				   //	data: "labName="+toSaveArrayLab+"&RadId="+toSaveArrayRad+"&ProcedureId="+toSaveArrayProcedure,
				  	dataType: 'html',
					  	success: function(data){
						 	if(data!=''){
						   		$('#busy-indicator').hide('fast');
						   		$('#DrugGroup').hide();
						   		$('#DrugGroup').html(data);
						   		$('#DrugGroup').show();
						   		custom_total=$('#custom_total').val();
						   		$('#totalAmount').text(custom_total);
						   		//$('#smartName').val($('#template_type').val());
						   		
						  	}	
					 	},
					});					 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	});

	$("#addmissionId").autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","IPD",'is_discharge=0',"admin" => false,"plugin"=>false)); ?>", 
		select: function(event,ui){
			$( "#patientId" ).val(ui.item.id);
			if($( "#addmissionId" ).val() != '')
	    		var url="<?php echo $this->Html->url(array('controller'=>$this->params['controller'],'action'=>$this->params['action']));?>";
	    		window.location.href=url+'/'+$( "#patientId" ).val()+'?from=Nurse';
	    		//$( "#addmissionId" ).trigger( "change" );
	},
	 messages: {
         noResults: '',
         results: function() {},
  }
});

/*js code for patient details box added by Atul*/
 $(document).ready(function(){
	var timer=setInterval(
		    	function () {
	    	    	$('#patient-info-box').hide();
	    }, 10000);
	    $('#userInfo').click(function(){		     
			  var pos = 	$(this).position();		    
			  var cc = $('#patient-info-box');//top: 40px; left: 1215px;
			  cc.css('top',pos.top+38); 
			  cc.css('left',pos.left-342); 
			  cc.css('right',pos.right);
			  cc.show();  
			  clearInterval(timer);  
		});
	    $('#userInfo').mouseout(function(){ 
	    	timer=setInterval(
	    	    	function () {
	        	    	$('#patient-info-box').hide();
	        }, 10000);    	
		});		
	    $("#patient-info-box,#userInfo").click(function(t) {
	        t.stopPropagation();
	    }),$("#userInfo").click(function() {
	        $("#patient-info-box").show();
	    }), $("html").click(function() {
	    	$("#patient-info-box").hide() ;
	    }); 
	        
 });
</script>
