
<?php echo $this->Html->script(array('inline_msg' )); ?>
<?php //echo $this->Html->script(array('validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en'));?>
<?php //echo $this->Html->css(array('validationEngine.jquery.css'));?>

<style>
#navc,#navc ul {
	padding: 5px 0 5px 0;
	margin: 0;
	list-style: none;
	font: 15px verdana, sans-serif;
	border-color: #000;
	border-width: 1px 2px 2px 1px;
	background: #374043;
	position: relative;
	z-index: 200;
}

.date_class {
	float: left;
	padding: 5px 20px 0 0;
}

.tddate img {
	float: inherit;
}

#navc {
	height: 35px;
	padding: 0;
	width: 350px;
	margin-left: -7px;
}

#navc li {
	float: left;
}

#navc li li {
	float: none;
	background: #fff;
}

#treatment .tdLabel {
	padding: 0px !important;
}

.accordionCust div.section {
	padding: 0px !important;
}

* html #navc li li {
	float: left;
}

.tddate img {
	float: inherit;
}

#navc li a {
	display: block;
	float: left;
	color: #fff;
	margin: 0 25px 0 10px;
	height: 35px;
	line-height: 12px;
	text-decoration: none;
	white-space: nowrap;
	font-size: 14px;
}

#navc li li a {
	height: 20px;
	line-height: 20px;
	float: none;
}

#navc ul {
	position: absolute;
	left: -9999px;
	top: -9999px;
}

* html #navc ul {
	width: 1px;
}

#navc li:hover li:hover>ul {
	left: -15px;
	margin-left: 100%;
	top: -1px;
}

#navc li:hover>ul ul {
	position: absolute;
	left: -9999px;
	top: -9999px;
	width: auto;
}

#navc li:hover>a {
	color: #fff;
}

.patientHub .patientInfo .content {
	float: left;
	padding: 0 0 0 20px !important;
}

.patient_info .ui-widget-content {
	background: none;
}

#swap_investigation {
	color: #FFFFFF;
}

#provisional_dignosis {
	width: 1000px;
}

#swap_investigation_ekg {
	color: #FFFFFF;
}

.showTr {
	display: block;
}

.hideTr {
	display: none;
}
</style>

<?php 
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('slides.min.jquery.js?ver=1.1.9',
		'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
echo $this->Html->Script('ui.datetimepicker.3.js');
echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js','stuHover.js','jquery.selection.js'));
echo $this->Html->css(array('jquery.autocomplete.css','skeleton.css'));
?>
<script type="text/javascript">

$(document).ready(function(){

	jQuery("#diagnosisfrm").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});
	$('#submit')
	.click(
	function() { 
	//alert("hello");
	var validatePerson = jQuery("#diagnosisfrm").validationEngine('validate');
	//alert(validatePerson);
	if (validatePerson) {$(this).css('display', 'none');}
	//return false;
	});
	});

jQuery(document).ready(function() {

var height, /*height_in_meter,*/ weight, bmi, message;
jQuery.fn.checkBMI = function(){
// on load set bmi
height = jQuery("#height").val();
weight = jQuery("#weight").val();
//height_in_meter = height/ 39.370;
//bmi = weight/(height_in_meter * height_in_meter);
//weight_in_pound = weight / 2.2;
//alert(height);
//alert(height_in_meter);
//alert(weight);
//alert(weight_in_pound); 
bmi1 = weight / (height * height)*703;
bmi = bmi1.toFixed(2);
//alert(bmi.toFixed(2)); 

if(height==0){
	
}
else{
	if(isNaN(height) || isNaN(weight))
		 jQuery("#bmi").val("");
		else
		 jQuery("#bmi").val(bmi);	
}
/*
Underweight: Less than 18.5
Normal: 18.6 to 23
Overweight:  23.1 to 30
Obese : More than 30
*/	
if(bmi < 18.5) {
document.getElementById('id1').value='Underweight' ;
message = "Underweight";
} else if(bmi > 18.5 && bmi<=23) {
document.getElementById('id1').value='Normal' ;
message = "Normal";
} else if(bmi >= 23.1 && bmi<=30) {
document.getElementById('id1').value='Overweight' ;
message = "Overweight";
} else if(bmi >= 30) {
document.getElementById('id1').value='Obese' ;
message = "Obese";
}
jQuery("#bmiStatus").html(message);
 };
jQuery("#bmi").checkBMI();

jQuery('#height, #weight').change(function() {
jQuery("#bmi").checkBMI();
});
 
});
</script>

<?php

if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}?>
		</td>
	</tr>
</table>
<?php } ?>

<div class="inner_title">
	<div style="float: left">
		<h3>
			<table>
				<tr>
					<td><?php
					if($patient['Patient']['is_emergency'] == 1){
       						 echo __('Emergency Room Assessment');
     					}else{
     							echo __('Initial Assessment');
     					} ?>
					</td>
					<td>
						<table>
							<tr>
								<td valign="middle" class="tdLabel"><?php 
								if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$photo) && !empty($photo)){
									 echo $this->Html->image("/uploads/patient_images/thumbnail/".$photo, array('width'=>'50','height'=>'50','class'=>'pateintpic'));
								}else{
									 echo $this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'patientpic'));
								}?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</h3>

	</div>
	<div style="text-align: right;">
		<?php
		echo $this->element('patient_information');
		echo $this->Form->create('Diagnosis',array('id'=>'diagnosisfrm','url'=>array('action'=>'add',$patient_id),
				'inputDefaults' => array( 'label' => false, 	'div' => false, 'error'=>false )));
		echo $this->Form->hidden('Diagnosis.patient_id',array('value'=>$patient_id,'id'=>'patient_id'));
		echo $this->Form->hidden('location_id',array('value'=>$this->Session->read('locationid')));
		echo $this->Form->input('PatientPastHistory.id', array('type'=>'hidden','value'=>$this->data['PatientPastHistory']['id']));
		echo $this->Form->input('PatientPersonalHistory.id', array('type'=>'hidden','value'=>$this->data['PatientPersonalHistory']['id']));
		echo $this->Form->input('PatientFamilyHistory.id', array('type'=>'hidden','value'=>$this->data['PatientFamilyHistory']['id']));
		echo $this->Form->hidden('Diagnosis.flag',array('id'=>'flag','value'=>$flag));

		/*debug($flag);
			$backBtnUrl =  array('controller'=>'PatientsTrackReports','action'=>'sbar',$patient_id);
		echo $this->Html->link(__('Back to Clinical Summry'),$backBtnUrl,array('class'=>'blueBtn','div'=>false));*/

		?>
		<div style="float: left;">
			<span class="blueBtn"><?php echo $this->Html->link(__('Expand All', true),'javascript:void(0)',array('onClick'=>'expandCollapseAll("expandBtn")'),array('escape' => false,'div'=>false,'id'=>'expandBtn'));?>
			</span>
		</div>
		<div style="float: right;">
			<span class="blueBtn"><?php	echo $this->Html->link(__('Collapse All', true),'javascript:void(0)',array('onClick'=>'expandCollapseAll("collapseBtn")'),array('escape' => false,'div'=>false,'id'=>'collapseBtn'));?>
			</span>
		</div>
		<?php 
		/*
		 echo $this->Form->submit(__('Expand All'), array('class'=>'blueBtn','id'=>'expandBtn','div'=>false));
		//echo $this->Form->submit(__('collapse All'), array('class'=>'blueBtn','id'=>'collapseBtn','div'=>false));
		/*	if(isset($this->data['Diagnosis']['id'])){

					if($patient['Patient']['admission_type'] == "IPD"){
						echo $this->Html->link(__('Print Page 1'),'#',
								array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_first_page',$this->data['Diagnosis']['patient_id']))."', '_blank',
										'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');  return false;"));

		echo $this->Html->link(__('Print Page 2'),'#',
									     			array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_second_page',$this->data['Diagnosis']['patient_id']))."', '_blank',
								           			'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');  return false;"));
		}else{
	   	  				 				echo $this->Html->link(__('Print'),'#',
								     			array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_opd_assessment',$this->data['Diagnosis']['patient_id']))."', '_blank',
								           		'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');  return false;"));
		}

		}else{
	   	  				 			if($patient['Patient']['admission_type'] == "IPD"){
		   	  				 			echo $this->Html->link(__('Print Page 1'),'#',
									     			array('escape' => false,'class'=>'blueBtn','onclick'=>"diagnosisMsg(); return false;"));

		echo $this->Html->link(__('Print Page 2'),'#',
									     			array('escape' => false,'class'=>'blueBtn','onclick'=>"diagnosisMsg();  return false;"));
		}else{
	   	  				 				echo $this->Html->link(__('Print'),'#',
								     			array('escape' => false,'class'=>'blueBtn','onclick'=>"diagnosisMsg();  return false;"));
		}
		}

		echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','id'=>'id2','div'=>false));*/
		//if($this->Session->check('returnPage')){
   						  			//if($this->Session->read('returnPage')=='assessment'){
   						  				//$cancelBtnUrl =  array('controller'=>'patients','action'=>'search','?'=>array('type'=>'IPD','mod'=>'assessment'));
   						  			//}
   						  		//}else{
   						  		//	$cancelBtnUrl =  array('controller'=>'patients','action'=>'patient_information',$patient['Patient']['id']);
   						  		//}
   						  		//echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false));
   						  		?>
	</div>
</div>
<p class="ht5"></p>

<!-- 
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	align="center">
	<tr class="row_title">
		<td class=" "><?php
		/* echo    $this->Form->radio('',array('Immediate'),array('type'=>'radio','id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false));
		 echo    $this->Form->radio('',array('Delayed'),array('type'=>'radio','id' => 'delayed', 'label'=> false, 'div' => false, 'error' => false));
		echo    $this->Form->radio('',array('Expectant'),array('type'=>'radio','id' => 'expectant', 'label'=> false, 'div' => false, 'error' => false));
		echo    $this->Form->radio('',array('Minimal'),array('type'=>'radio','id' => 'minimal', 'label'=> false, 'div' => false, 'error' => false));
		echo    $this->Form->radio('',array('Dead'),array('type'=>'radio','id' => 'dead', 'label'=> false, 'div' => false, 'error' => false));
		*/?>
		</td>
		<td align="right">
			
		</td>
	</tr>
</table>

 -->

<?php

if($patient['Patient']['admission_type'] == "OPD") $display = 'none';
else $display = 'block';
?>
<!-- two column table end here -->
<div>
	<?php //$capture_date = $this->DateFormat->formatDate2Local($this->data[PatientPersonalHistory][capture_date],Configure::read('date_format'),true);?>
	<?php //echo $this->Form->input('capture_date', array('type'=>'text','id' =>'capture_date','readonly'=>'readonly','value'=>$capture_date,'class'=>'textBoxExpnd','style'=>'width:150px')); ?>

	<table>
		<tr>
			<td><?php $d= date('m/d/y H:i:s');
	 	$capture_date = $this->DateFormat->formatDate2Local($this->data[PatientPersonalHistory][capture_date],Configure::read('date_format'),true);
	 	if($this->data[PatientPersonalHistory][capture_date]==""){
			echo $this->Form->input('capture_date', array('type'=>'text','id' =>'capture_date','readonly'=>'readonly','value'=>$d,'class'=>'textBoxExpnd','style'=>'width:150px'));
   		}else{
    		echo $this->Form->input('capture_date', array('type'=>'text','id' =>'capture_date','readonly'=>'readonly','value'=>$capture_date,'class'=>'textBoxExpnd','style'=>'width:150px'));
    	}?>
			</td>
		</tr>
	</table>
</div>


<!--------------------------------Diabetes reminder end--------------------------------------- -->
<!-- Complaints table start here -->


<div id="accordionCust" class="accordionCust">
	<!-----------------------not Required
	<h3 style="display: &amp;amp;">
		<a href="#">Allergies</a>
	</h3>
	<div class="section" style="display: &amp;amp;">
		<table class="tdLabel" border="0" width="100%">
			
			<tr>
				<td><input type="checkbox" name="data[Diagnosis][is_allergy]"
				<?php
				if(isset($drugallergy_data)){if($drugallergy_data["0"]["DrugAllergy"]["active"]=='Active'){echo
					"checked";}}else {echo "";}?>
					value="1" id="noknown"
					onclick="javascript:hideallergy(this.checked);">No known allergies
					for this patient.</td>
			</tr>
			<tr>
			
			
			<tr>
				<td>&nbsp;</td>
			</tr>
			<td valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Drug Allergies</td>
			<td align="right" style="padding-right: 20px"><span
				style="text-align: right; float: right; cursor: pointer;"
				id="displayDrugAllergy"> <?php echo $this->Html->image('icons/plus-icon.png'); ?>
			</span>
			</td>
			</tr>
			<tr>
				<td width="100%" align="center" id="displayDrugAllergyId"
					style="display: &amp;amp;" colspan="2">
					
					<table width="60%" align="center" cellpadding="0" cellspacing="1"
						border="0" class="tabularForm ">

						<tr>
							<th colspan="2"><?php echo __('Add Drug Allergy',true); ?>
							</th>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Drug',true); ?>
							</td>
							<td><?php echo $this->Form->input('DrugAllergy.fromdrug',array('legend'=>false,'label'=>false,'class' => 'validate[required] drugText','id' => 'drugval','value'=>$drugallergy_data["0"]["DrugAllergy"]["from1"],'autocomplete'=>"on"));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Severity',true); ?>
							</td>
							<td><?php

							echo $this->Form->radio('DrugAllergy.severity', array('Very Mild'=>'Very Mild','Mild'=>'Mild','Moderate'=>'Moderate','Severe'=>'Severe'),
// array('legend' => false, 'value' => false,'checked'=> ($foo == "Very Mild") ? FALSE : TRUE,),
array('value'=>('Very Mild'),'legend'=>false,'label'=>false,'id' => 'drugallergies','checked'=> ($foo == "Very Mild") ? FALSE : TRUE));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Active',true); ?>
							</td>
							<td valign="middle"><input type="checkbox"
								name="data[DrugAllergy][active]"
								<?php
								if(isset($drugallergy_data)){if($drugallergy_data["0"]["DrugAllergy"]["active"]=='Active'){echo
								"checked";}}else {echo "checked";}?>
								value="Active" id="active">
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Location',true); ?>
							</td>
							<td><?php 

echo $this->Form->input('DrugAllergy.allergylocation', array('empty'=>__('Please Select'),'label'=>false,'options'=>$allergylocationlist,'id' => 'allergylocation','value'=>(isset($drugallergy_data["0"]["DrugAllergy"]["allergylocation"])?$drugallergy_data["0"]["DrugAllergy"]["allergylocation"]:"")));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Reaction',true); ?>
							</td>
							<td><?php
							$selected = explode(",",$drugallergy_data["0"]["DrugAllergy"]["reaction"]);
echo $this->Form->input('DrugAllergy.reaction', array('empty'=>__('Please Select'),'label'=>false,'options'=>$allergyreactionlist,'class' => 'validate[optional,custom[mandatory-select]]','id' => 'reaction','selected' => $selected,'multiple'=>true,'style'=>'width:300px'));?>
								<br />(Please hold CTRL key to select multiple value)</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Start Date',true); ?>
							</td>
							<td><?php echo $this->Form->input('DrugAllergy.startdate',array('value' => date("d/m/Y"),'legend'=>false,'label'=>false,'id' => 'startdate','value'=>$drugallergy_data["0"]["DrugAllergy"]["startdate"]));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Onset',true); ?>
							</td>
							<td><?php echo $this->Form->radio('DrugAllergy.onsets', array('Unknown'=>'Unknown','Adulthood'=>'Adulthood','Childhood'=>'Childhood'),array('value'=>(isset($this->data['PatientAllergy']['drugallergies'])?$this->data['PatientAllergy']['drugallergies']:0),'legend'=>false,'label'=>false,'id' => 'onsets','value'=>(isset($drugallergy_data["0"]["DrugAllergy"]["onsets"])?$drugallergy_data["0"]["DrugAllergy"]["onsets"]:"")));?>&nbsp;&nbsp;<?php 
							echo $this->Form->input('DrugAllergy.onsets_date',array('value' => date("d/m/Y"),'legend'=>false,'label'=>false,'id' => 'onsets_date','value'=>$drugallergy_data["0"]["DrugAllergy"]["onsets_date"]));
							?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Comments',true); ?>
							</td>
							<td><?php echo $this->Form->input('DrugAllergy.comments',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'reaction2','value'=>$drugallergy_data["0"]["DrugAllergy"]["comments"]));?>
							</td>
						</tr>
						<tr>
							<td colspan=2 align="right"><?php echo $this->Html->link(__('Cancel'),"javascript:void(0)",array('id'=>'closedrugallergy','class'=>'grayBtn close-template-form')); ?>
								<?php echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'drugsubmit','class'=>'blueBtn','onclick'=>'javascript:save_allergy("drug");')); ?>
								<?php //echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','div'=>false, 'id' => 'submit_drug_allergy')); ?>
							</td>
						</tr>
					</table> 
				</td>
			</tr>
			<?php

			 if(count($drugallergy_all) > 0) {?>
			<tr>
				<td colspan="2">
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%">
						<tr class="row_title">
							<td class="table_cell" width="80%"><strong>Allergies</strong>
							</td>
							<td class="table_cell" width="20%">Start<strong></strong>



							</td>
							<td class="table_cell" width="20%">Action<strong></strong>



							</td>

						</tr>

						<?php 
						$toggle =0;
						foreach($drugallergy_all as $drugall){

							      if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       ?>
						<td class="row_format" width="80%"><?php echo $drugall['DrugAllergy']['from1']; ?>
							<br />
							<p>
								<span style="color: red"> <?php echo $drugall['DrugAllergy']['severity']; ?>
									allergy
								</span> resulting in <strong> <?php echo $drugall['DrugAllergy']['reaction']; ?>
								</strong> (
								<?php echo $drugall['DrugAllergy']['allergylocation']; ?>
								)
								<?php echo $drugall['DrugAllergy']['active']; ?>
							</p>
						</td>
						<td class="row_format" width="20%"><?php echo $drugall['DrugAllergy']['startdate']; ?>
						</td>
						<td class="row_format" width="20%"><span
							style="text-align: right; float: right; cursor: pointer;"> <?php echo $this->Html->image('icons/edit-icon.png',array("title" => "Edit","alt" => "Edit","url" => array('controller' => 'diagnoses', 'action' => 'add',$patient_id,$drugall['DrugAllergy']['id'],'drug'), "style" => "cursor:pointer;")); ?>
								<?php echo $this->Html->image('icons/delete-icon.png',array("title" => "Delete","onclick"=>"javascript:if(confirm('Are you sure to delete?')){return true;}else {return false;}","alt" => "Delete","url" => array('controller' => 'diagnoses', 'action' => 'delete_drug_allergy',$patient_id,$drugall['DrugAllergy']['id'],'drug'),"style" => "cursor:pointer;" )); ?>
						</span>
						</td>


						</tr>
						<?php } 
						//$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
						?>


					</table>
				</td>
			</tr>
			<?php }else {?>
			<tr>
				<td style="padding-left: 30px; font-weight: normal">There are no
					recorded allergies for this patient at this time.</td>
			</tr>
			<?php }?>

		</table>
		<br />


		<table class="tdLabel" style="text-align: left;" border="0"
			width="100%">
			
			<tr>
				<td valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Food Allergies</td>
				<td align="right" style="padding-right: 20px"><span
					style="text-align: right; float: right; cursor: pointer;"
					id="displayFoodAllergy"> <?php echo $this->Html->image('icons/plus-icon.png'); ?>
				</span>
				</td>
			</tr>
			<tr>
				<td width="100%" align="center" id="displayFoodAllergyId"
					style="display: &amp;amp;" colspan="2">
					
					<table width="60%" align="center" cellpadding="0" cellspacing="1"
						border="0" class="tabularForm ">

						<tr>
							<th colspan="2"><?php echo __('Add Food Allergy',true); ?>
							</th>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Food',true); ?>
							</td>
							<td><?php echo $this->Form->input('DrugAllergy.fromfood',array('legend'=>false,'label'=>false,'class' => 'foodText','id' => 'foodval','value'=>$foodallergy_data["0"]["DrugAllergy"]["from1"],'autocomplete'=>"off"));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Severity',true); ?>
							</td>
							<td><?php echo $this->Form->radio('DrugAllergy.severityfood', array('Very Mild'=>'Very Mild','Mild'=>'Mild','Moderate'=>'Moderate','Severe'=>'Severe'), array('value'=>('Very Mild'),'legend'=>false,'label'=>false,'id' => 'severityfood','checked'=> ($foo == "Very Mild") ? FALSE : TRUE,));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Active',true); ?>
							</td>
							<td valign="middle"><input type="checkbox"
								name="data[DrugAllergy][activefood]"
								<?php
								if(isset($foodallergy_data)){if($foodallergy_data["0"]["DrugAllergy"]["active1"]=='Active1'){echo
								"checked";}}else {echo "checked";}?>
								value="Active1" id="active1">
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Location',true); ?>
							</td>
							<td><?php 
echo $this->Form->input('DrugAllergy.allergylocationfood', array('empty'=>__('Please Select'),'label'=>false,'options'=>$allergylocationlist,'id' => 'allergylocationfood','value'=>(isset($foodallergy_data["0"]["DrugAllergy"]["allergylocation"])?$foodallergy_data["0"]["DrugAllergy"]["allergylocation"]:"")));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Reaction',true); ?>
							</td>
							<td><?php  $selected_food = explode(",",$foodallergy_data["0"]["DrugAllergy"]["reaction"]);
echo $this->Form->input('DrugAllergy.foodreaction', array('empty'=>__('Please Select'),'label'=>false,'options'=>$allergyreactionlist,'class' => 'validate[optional,custom[mandatory-select]]','id' => 'reaction','selected' => $selected_food,'multiple'=>true,'style'=>'width:300px'));?>
								<br />(Please hold CTRL key to select multiple value)</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Start Date',true); ?>
							</td>
							<td><?php echo $this->Form->input('DrugAllergy.startdatefood',array('value' => date("d/m/Y"),'legend'=>false,'label'=>false,'id' => 'startdatefood','value'=>$foodallergy_data["0"]["DrugAllergy"]["startdate"]));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Onset',true); ?>
							</td>
							<td><?php echo $this->Form->radio('DrugAllergy.onsetsfood', array('Unknown'=>'Unknown','Adulthood'=>'Adulthood','Childhood'=>'Childhood'),array('value'=>(isset($this->data['PatientAllergy']['drugallergies'])?$this->data['PatientAllergy']['drugallergies']:0),'legend'=>false,'label'=>false,'id' => 'onsetsfood','value'=>(isset($foodallergy_data["0"]["DrugAllergy"]["onsets"])?$foodallergy_data["0"]["DrugAllergy"]["onsets"]:"")));?>&nbsp;&nbsp;<?php 
							echo $this->Form->input('DrugAllergy.onsets_date_food',array('value' => date("d/m/Y"),'legend'=>false,'label'=>false,'id' => 'onsets_date_food','value'=>$foodallergy_data["0"]["DrugAllergy"]["onsets_date"]));
							?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Comments',true); ?>
							</td>
							<td><?php echo $this->Form->input('DrugAllergy.commentsfood',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'commentsfood','value'=>$foodallergy_data["0"]["DrugAllergy"]["comments"]));?>
							</td>
						</tr>
						<tr>
							<td colspan=2 align="right"><?php echo $this->Html->link(__('Cancel'),"javascript:void(0)",array('id'=>'closefoodallergy','class'=>'grayBtn close-template-form')); ?>
								<?php echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'foodsubmit','class'=>'blueBtn','onclick'=>'javascript:save_allergy("food");')); ?>
								<?php //echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','div'=>false, 'id' => 'submit_drug_allergy')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php

			 if(count($foodallergy_all) > 0) {?>
			<tr>
				<td colspan="2">
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%">
						<tr class="row_title">
							<td class="table_cell" width="80%"><strong>Allergies</strong>
							</td>
							<td class="table_cell" width="20%">Start<strong></strong>



							</td>
							<td class="table_cell" width="20%">Action<strong></strong>



							</td>

						</tr>

						<?php 
						$toggle =0;
						foreach($foodallergy_all as $drugall){

							      if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       ?>
						<td class="row_format" width="80%"><?php echo $drugall['DrugAllergy']['from1']; ?>
							<br />
							<p>
								<span style="color: red"> <?php echo $drugall['DrugAllergy']['severity']; ?>
									allergy
								</span> resulting in <strong> <?php echo $drugall['DrugAllergy']['reaction']; ?>
								</strong> (
								<?php echo $drugall['DrugAllergy']['allergylocation']; ?>
								)
								<?php echo $drugall['DrugAllergy']['active']; ?>
							</p>
						</td>
						<td class="row_format" width="20%"><?php echo $drugall['DrugAllergy']['startdate']; ?>
						</td>
						<td class="row_format" width="20%"><span
							style="text-align: right; float: right; cursor: pointer;"> <?php echo $this->Html->image('icons/edit-icon.png',array("title" => "Edit","alt" => "Edit","url" => array('controller' => 'diagnoses', 'action' => 'add',$patient_id,$drugall['DrugAllergy']['id'],'food'), "style" => "cursor:pointer;")); ?>
								<?php echo $this->Html->image('icons/delete-icon.png',array("title" => "Delete","onclick"=>"javascript:if(confirm('Are you sure to delete?')){return true;}else {return false;}","alt" => "Delete","url" => array('controller' => 'diagnoses', 'action' => 'delete_drug_allergy',$patient_id,$drugall['DrugAllergy']['id'],'food'),"style" => "cursor:pointer;" )); ?>
						</span>
						</td>


						</tr>
						<?php } 
						//$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
						?>

					</table>
				</td>
			</tr>
			<?php }else {?>
			<tr>
				<td style="padding-left: 30px; font-weight: normal">There are no
					recorded allergies for this patient at this time.</td>
			</tr>
			<?php }?>

		</table>
		<br />

		

		<table class="tdLabel" style="text-align: left;" border="0"
			width="100%">
			
			<tr>
				<td valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Environment Allergies</td>
				<td align="right" style="padding-right: 20px"><span
					style="text-align: right; float: right; cursor: pointer;"
					id="displayEnvAllergy"> <?php echo $this->Html->image('icons/plus-icon.png'); ?>
				</span>
				</td>
			</tr>
			<tr>
				<td width="100%" align="center" id="displayEnvAllergyId"
					style="display: &amp;amp;" colspan="2">
					
					<table width="60%" align="center" cellpadding="0" cellspacing="1"
						border="0" class="tabularForm ">

						<tr>
							<th colspan="2"><?php echo __('Add Environment Allergy',true); ?>
							</th>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Environment',true); ?>
							</td>
							<td><?php echo $this->Form->input('DrugAllergy.fromenv',array('legend'=>false,'label'=>false,'class' => 'envText','id' => 'envval','value'=>$envallergy_data["0"]["DrugAllergy"]["from1"],'autocomplete'=>"off"));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Severity',true); ?>
							</td>
							<td><?php echo $this->Form->radio('DrugAllergy.severityenv', array('Very Mild'=>'Very Mild','Mild'=>'Mild','Moderate'=>'Moderate','Severe'=>'Severe'),array('value'=>('Very Mild'),'legend'=>false,'label'=>false,'id' => 'severityenv'));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Active',true); ?>
							</td>
							<td valign="middle"><input type="checkbox"
								name="data[DrugAllergy][activeenv]"
								<?php
								if(isset($envallergy_data)){if($envallergy_data["0"]["DrugAllergy"]["active2"]=='Active'){echo
								"checked";}}else {echo "checked";}?>
								value="Active2" id="active2">
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Location',true); ?>
							</td>
							<td><?php 
echo $this->Form->input('DrugAllergy.allergylocationenv', array('empty'=>__('Please Select'),'label'=>false,'options'=>$allergylocationlist,'id' => 'allergylocationenv','value'=>(isset($envallergy_data["0"]["DrugAllergy"]["allergylocation"])?$envallergy_data["0"]["DrugAllergy"]["allergylocation"]:"")));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Reaction',true); ?>
							</td>
							<td><?php  $selected_env = explode(",",$envallergy_data["0"]["DrugAllergy"]["reaction"]);
echo $this->Form->input('DrugAllergy.reactionenv', array('empty'=>__('Please Select'),'label'=>false,'options'=>$allergyreactionlist,'class' => 'validate[optional,custom[mandatory-select]]','id' => 'reactionenv','selected' => $selected_env,'multiple'=>true,'style'=>'width:300px'));?>
								<br />(Please hold CTRL key to select multiple value)</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Start Date',true); ?>
							</td>
							<td><?php echo $this->Form->input('DrugAllergy.startdateenv',array('value' => date("d/m/Y"),'legend'=>false,'label'=>false,'id' => 'startdateenv','value'=>$envallergy_data["0"]["DrugAllergy"]["startdate"]));?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Onset',true); ?>
							</td>
							<td><?php echo $this->Form->radio('DrugAllergy.onsetsenv', array('Unknown'=>'Unknown','Adulthood'=>'Adulthood','Childhood'=>'Childhood'),array('value'=>(isset($this->data['PatientAllergy']['drugallergies'])?$this->data['PatientAllergy']['drugallergies']:0),'legend'=>false,'label'=>false,'id' => 'onsetsenv','value'=>(isset($envallergy_data["0"]["DrugAllergy"]["onsets"])?$envallergy_data["0"]["DrugAllergy"]["onsets"]:"")));?>&nbsp;&nbsp;<?php 
							echo $this->Form->input('DrugAllergy.onsets_date_env',array('value' => date("d/m/Y"),'legend'=>false,'label'=>false,'id' => 'onsets_date_env','value'=>$envallergy_data["0"]["DrugAllergy"]["onsets_date"]));
							?>
							</td>
						</tr>
						<tr>
							<td valign="middle"><?php echo __('Comments',true); ?>
							</td>
							<td><?php echo $this->Form->input('DrugAllergy.commentsenv',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'commentsenv','value'=>$envallergy_data["0"]["DrugAllergy"]["comments"]));?>
							</td>
						</tr>
						<tr>
							<td colspan=2 align="right"><?php echo $this->Html->link(__('Cancel'),"javascript:void(0)",array('id'=>'closeenvallergy','class'=>'grayBtn close-template-form')); ?>
								<?php echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'envsubmit','class'=>'blueBtn','onclick'=>'javascript:save_allergy("env");')); ?>
								<?php //echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','div'=>false, 'id' => 'submit_drug_allergy')); ?>
							</td>
						</tr>
					</table> 
				</td>
			</tr>
			<?php

			 if(count($envallergy_all) > 0) {?>
			<tr>
				<td colspan="2">
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%">
						<tr class="row_title">
							<td class="table_cell" width="80%"><strong>Allergies</strong>
							</td>
							<td class="table_cell" width="20%">Start<strong></strong>



							</td>
							<td class="table_cell" width="20%">Action<strong></strong>



							</td>

						</tr>

						<?php 
						$toggle =0;
						foreach($envallergy_all as $drugall){

							      if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       ?>
						<td class="row_format" width="80%"><?php echo $drugall['DrugAllergy']['from1']; ?>
							<br />
							<p>
								<span style="color: red"> <?php echo $drugall['DrugAllergy']['severity']; ?>
									allergy
								</span> resulting in <strong> <?php echo $drugall['DrugAllergy']['reaction']; ?>
								</strong> (
								<?php echo $drugall['DrugAllergy']['allergylocation']; ?>
								)
								<?php echo $drugall['DrugAllergy']['active']; ?>
							</p>
						</td>
						<td class="row_format" width="20%"><?php echo $drugall['DrugAllergy']['startdate']; ?>
						</td>
						<td class="row_format" width="20%"><span
							style="text-align: right; float: right; cursor: pointer;"> <?php echo $this->Html->image('icons/edit-icon.png',array("title" => "Edit","alt" => "Edit","url" => array('controller' => 'diagnoses', 'action' => 'add',$patient_id,$drugall['DrugAllergy']['id'],'env'), "style" => "cursor:pointer;")); ?>
								<?php echo $this->Html->image('icons/delete-icon.png',array("title" => "Delete","onclick"=>"javascript:if(confirm('Are you sure to delete?')){return true;}else {return false;}","alt" => "Delete","url" => array('controller' => 'diagnoses', 'action' => 'delete_drug_allergy',$patient_id,$drugall['DrugAllergy']['id'],'env'),"style" => "cursor:pointer;" )); ?>
						</span>
						</td>


						</tr>
						<?php } 
						//$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
						?>

					</table>
				</td>
			</tr>
			<?php }else {?>
			<tr>
				<td style="padding-left: 30px; font-weight: normal">There are no
					recorded allergies for this patient at this time.</td>
			</tr>
			<?php }?>

		</table>
		<br />

	</div>
--------------------------------------------------Allergies Accordion Removed-->


	<h3>
		<a href="#"> <?php echo __('Chief Complaint');?>
		</a>
	</h3>
	<div class="section dragbox-content" id="complaints">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator' style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-complaints"></div>
				</td>

				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->input('complaints', array('class' => 'textBoxExpnd','id' => 'complaints_desc','style'=>'width:98%','rows'=>18)); ?>
								<a href="javascript:void(0);" onclick="callDragon('complaints')"
								style="text-align: left;"><font color="#000">Use speech
										recognition</font> </a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<h3 style="display: &amp;amp;">
		<a href="#">Significant tests done/Laboratory reports</a>
	</h3>
	<div class="section dragbox-content" id="lab-reports"
		style="display: &amp;amp;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator' style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-lab-reports"></div>
				</td>

				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('lab_report', array('class' => 'textBoxExpnd','id' => 'lab-reports_desc','style'=>'width:98%','rows'=>21)); ?>
								<a href="javascript:void(0);" onclick="callDragon('lab_report')"
								style="text-align: left;"><font color="#000">Use speech
										recognition</font> </a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<h3 style="display: &amp;amp;" id="treatment-link">
		<a href="#">Current Treatment</a>
	</h3>
	<div class="section dragbox-content" id="treatment">
		<div align="center" id='temp-busy-indicator-treatment'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<!--BOF medicine  -->
		<table class="tdLabel" style="text-align: left;" width="100%">
			<?php  /* debug($interactionData);exit; */ ?>
			<tr>
				<td width="100%" colspan='14'>
					<div id='showInteractions' style='display: none; color: red'></div>
				</td>
			</tr>
			<tr>
				<td width="100%" valign="top" align="left" style="padding: 2px;"
					colspan="4">
					<table width="100%" border="0" cellspacing="0" cellpadding="0"
						class="tabularForm">
						<!-- row 1 -->
						<tr>
							<td width="100%" valign="top" align="left" colspan="6">
								<table width="100%" border="0" cellspacing="1" cellpadding="0"
									id='DrugGroup' class="tabularForm">
									<tr>
										<td width="20%" height="20" align="left" valign="top">Drug
											Name</td>
										<td width="5%" height="20" align="left" valign="top">Dosage #</td>
										<td width="5%" height="20" align="left" valign="top">Dosage
											Form</td>
										<td width="5%" height="20" align="left" valign="top">Route</td>
										<td width="5%" align="left" valign="top">Frequency</td>
										<td width="5%" align="left" valign="top">Strength</td>
										<td width="5%" align="left" valign="top">Days</td>
										<td width="5%" align="left" valign="top">Qty</td>
										<td width="5%" align="center" valign="top">Refills</td>
										<td width="5%" align="center" valign="top">PRN</td>
										<td width="5%" align="center" valign="top">DAW</td>
										<td width="10%" align="center" valign="top">Special
											Instruction</td>
										<td width="5%" align="center" valign="top">Is Active</td>
									</tr>

									<?php  

									if(isset($currentresult) && !empty($currentresult)){

                                     $count  = count($currentresult) ;
                                     if($count<=5)
                                     	$count  = 5 ;
			               			}else{
			               				$count  = 5 ;

			               			}
			               			for($i=0;$i<$count;){

										$drug_name_val= isset($currentresult[$i]['NewCropPrescription']['drug_name'])?$currentresult[$i]['NewCropPrescription']['description']:'' ;
										$drug_id_val= isset($currentresult[$i]['NewCropPrescription']['drug_id'])?$currentresult[$i]['NewCropPrescription']['drug_id']:'' ;
										$dose_val= isset($currentresult[$i]['NewCropPrescription']['dose'])?$currentresult[$i]['NewCropPrescription']['dose']:'' ;
										$strength_val= isset($currentresult[$i]['NewCropPrescription']['strength'])?$currentresult[$i]['NewCropPrescription']['strength']:'' ;
										$route_val= isset($currentresult[$i]['NewCropPrescription']['route'])?$currentresult[$i]['NewCropPrescription']['route']:'' ;
										$frequency_val= isset($currentresult[$i]['NewCropPrescription']['frequency'])?$currentresult[$i]['NewCropPrescription']['frequency']:'' ;
										$day_val= isset($currentresult[$i]['NewCropPrescription']['day'])?$currentresult[$i]['NewCropPrescription']['day']:'' ;
										$quantity_val= isset($currentresult[$i]['NewCropPrescription']['quantity'])?$currentresult[$i]['NewCropPrescription']['quantity']:'' ;
										$refills_val= isset($currentresult[$i]['NewCropPrescription']['refills'])?$currentresult[$i]['NewCropPrescription']['refills']:'' ;
										$prn_val= isset($currentresult[$i]['NewCropPrescription']['prn'])?$currentresult[$i]['NewCropPrescription']['prn']:'' ;
										$daw_val= isset($currentresult[$i]['NewCropPrescription']['daw'])?$currentresult[$i]['NewCropPrescription']['daw']:'' ;
										$special_instruction_val= isset($currentresult[$i]['NewCropPrescription']['special_instruction'])?$currentresult[$i]['NewCropPrescription']['special_instruction']:'' ;
										$isactive_val= isset($currentresult[$i]['NewCropPrescription']['archive'])?$currentresult[$i]['NewCropPrescription']['archive']:'' ;
										$prescription_guid= isset($currentresult[$i]['NewCropPrescription']['PrescriptionGuid'])?$currentresult[$i]['NewCropPrescription']['PrescriptionGuid']:'' ;

										$dosage_form= isset($currentresult[$i]['NewCropPrescription']['DosageForm'])?$currentresult[$i]['NewCropPrescription']['DosageForm']:'' ;
										//if($isactive_val=='N'){

										if($isactive_val=='N')
										{
											$isactive_val='1';
										}
										else if($isactive_val=='Y')
										{
											$isactive_val='0';
										}
										else
											$isactive_val='1';
											
										?>
									<tr id="DrugGroup<?php echo $i;?>">
										<td align="left"><?php// echo $i;?> <?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText' ,'id'=>"drugText_$i",'name'=> 'NewCropPrescription[drug_name][]','value'=>$drug_name_val,'autocomplete'=>'off','counter'=>$i,'style'=>'width:250px'));?>
										</td>
										<?php echo $this->Form->hidden('drugId',array('id'=>"drug_$i" ,'name'=>'NewCropPrescription[drug_id][]','value'=>$drug_id_val));
										echo $this->Form->hidden('drugId',array('id'=>"prescriptionguid_$i" ,'name'=>'NewCropPrescription[PrescriptionGuid][]','value'=>$prescription_guid));
										?>
										<td align="left"><?php echo $this->Form->input('', array( 'empty'=>'Select','options'=>Configure :: read('dose_type'),'style'=>'width:80px','class' => '','id'=>"dose_type$i",'name' => 'NewCropPrescription[dose][]','value'=>$dose_val)); ?>
										</td>
										<td align="left"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('strength'),'empty'=>'Select','class' => '','id'=>"frequency$i",'name' => 'NewCropPrescription[DosageForm][]','value'=>$dosage_form)); ?>
										</td>

										<td align="left"><?php echo $this->Form->input('', array( 'empty'=>'Select','options'=>$route,'style'=>'width:80px','class' => '','id'=>"route_administration$i",'name' => 'NewCropPrescription[route][]','value'=>$route_val));?>
										</td>
										<td align="left"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('frequency'),'empty'=>'Select','class' => '','id'=>"frequency$i",'name' => 'NewCropPrescription[frequency][]','value'=>$frequency_val)); ?>
										</td>
										<td align="left"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>$strenght,'style'=>'width:93px','class' => '','id'=>"strength$i",'name' => 'NewCropPrescription[strength][]','value'=>$strength_val));?>
										</td>
										<td align="left"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','autocomplete'=>'off','id'=>"day$i",'name' => 'NewCropPrescription[day][]','value'=>$day_val)); ?>
										</td>
										<td align="left"><?php	echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','id'=>"quantity$i",'autocomplete'=>'off','name' => 'NewCropPrescription[quantity][]','value'=>$quantity_val)); ?>
										</td>
										<td align="left"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('refills'),'empty'=>'Select','style'=>'width:80px','class' => '','id'=>"refills$i",'name' => 'NewCropPrescription[refills][]','value'=>$refills_val));  ?>
										</td>
										<td align="center"><?php $options = array('0'=>'No','1'=>'Yes');
										echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:auto','class' => '','id'=>"prn$i",'name' => 'NewCropPrescription[prn][]','value'=>$prn_val));?>
										</td>
										<td align="center"><?php $option1= array('1'=>'Yes','0'=>'No');
										echo $this->Form->input('', array( 'options'=>$option1,'style'=>'width:auto','class' => '','id'=>"daw$i",'name' => 'NewCropPrescription[daw][]','value'=>$daw_val));?>
										</td>
										<td align="center"><?php echo $this->Form->textarea('', array('size'=>2,'style'=>'width:180px','type'=>'text','class' => '','id'=>"special_instruction$i",'name' => 'NewCropPrescription[special_instruction][]','value'=>$special_instruction_val));?>
										</td>
										<td align="center"><?php $options_active = array('1'=>'Yes','0'=>'No');
										echo $this->Form->input('', array( 'options'=>$options_active,'style'=>'width:70px','class' => '','id'=>"isactive$i",'name' => 'NewCropPrescription[is_active][]','value'=>$isactive_val));



										?>
									
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
							<td align="right" colspan="5"><input type="button" id="addButton"
								value="Add"> <?php if($count > 0){?> <input type="button"
								id="removeButton" value="Remove"> <?php }else{ ?> <input
								type="button" id="removeButton" value="Remove"
								style="display: none;"> <?php } ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!--EOF medicine -->
	</div>
	<!-- BOF-othertreatments----@mahalaxmi -->
	<h3 style="display: &amp;amp;" id="Othertreatment-link">
		<a href="#">Other Treatment</a>
	</h3>
	<div class="section dragbox-content" id="other_treatments">
		<div align="center" id='temp-busy-indicator-other_treatments'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<table class="tdLabel" style="text-align: left;" width="100%">
			<?php  /* debug($interactionData);exit; */ ?>
			<tr>
				<td width="100%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0"
						class="tabularForm" align="center">
						<tr>
							<td class="tdLabel" id="boxSpace" width="12%"><?php echo __('Chemotherapy');?>
							</td>
							<td width="12%"><?php echo $this->Form->input('OtherTreatment.patient_id',array('type'=>'hidden','id'=>'chemotherapy_patient_id','value'=>$getOtherTreatment['0']['OtherTreatment']['patient_id']));?>
								<?php echo $this->Form->radio('OtherTreatment.chemotherapy', array('0'=>'No','1'=>'Yes'),array('value'=>$getOtherTreatment['0']['OtherTreatment']['chemotherapy'],'legend'=>false,'label'=>false,'class' => 'chemotherapy','id'=>'chemotherapy','checked'=>$getOtherTreatment['0']['OtherTreatment']['chemotherapy']));
								?></td>
							<?php 	if(!empty($getOtherTreatment['0']['OtherTreatment']['chemotherapy'])){
								$displayChemotherapyValue='block';
							}else{
											$displayChemotherapyValue='none';
										}?>

							<td class="tdLabel" id="boxSpace" width="12%">
								<div class="showChemotherapy1Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('Drug');?>
									</span>
								</div>
							</td>
							<td width="12%">
								<div id="showChemotherapy1" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo $this->Form->input('OtherTreatment.chemotherapy_drug_name',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'chemotherapy_drug_name','value'=>$getOtherTreatment['0']['OtherTreatment']['chemotherapy_drug_name']));?>
									</span>
								</div>
							</td>
							<td width="12%" class="tdLabel" id="boxSpace">
								<div class="showChemotherapy2Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('First Round Date');?>
									</span>
								</div>
							</td>
							<td width="12%">
								<div id="showChemotherapy2" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['first_round_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['first_round_date'],Configure::read('date_format'));
									echo $this->Form->input('OtherTreatment.first_round_date',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  first_round_date ','id' => 'first_round_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['first_round_date']));
									?>
									</span>
								</div>
							</td>
							<td width="12%" class="tdLabel" id="boxSpace">
								<div class="showChemotherapy3Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('Last Round Date');?>
									</span>
								</div>
							</td>
							<td width="12%">
								<div id="showChemotherapy3" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['last_round_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['last_round_date'],Configure::read('date_format'));
							echo $this->Form->input('OtherTreatment.last_round_date',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  end_date ','id' => 'last_round_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['last_round_date']));	?>
									</span>
								</div>
							</td>
							<td colspan="8"></td>
						</tr>

						<tr>
							<td class="tdLabel " id="boxSpace"><?php echo __('Radiation Therapy');?>
							</td>
							<td><?php	echo $this->Form->radio('OtherTreatment.radiation_therapy', array('0'=>'No','1'=>'Yes'),array('value'=>$getOtherTreatment['0']['OtherTreatment']['chemotherapy'],'legend'=>false,'label'=>false,'class' => 'radiation_therapy','id'=>'radiation_therapy','checked'=>$getOtherTreatment['0']['OtherTreatment']['radiation_therapy']));
							?>
							</td>
							<?php	if(!empty($getOtherTreatment['0']['OtherTreatment']['radiation_therapy'])){
								$displayRadiationTherapyValue='block';
							}else{
											$displayRadiationTherapyValue='none';
										}?>

							<td class="tdLabel " id="boxSpace">
								<div class="showRadiation1Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('Previous Treatment');?>
									</span>
								</div>
							</td>
							<td>
								<div id="showRadiation1" style="display:<?php echo $displayRadiationTherapyValue ?>;">
									<span> <?php echo $this->Form->input('OtherTreatment.radiation_previous_treatment',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'radiation_previous_treatment','value'=>$getOtherTreatment['0']['OtherTreatment']['radiation_previous_treatment']));?>
									</span>
								</div>
							</td>
							<td class="tdLabel " id="boxSpace">
								<div class="showRadiation2Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <strong><?php echo __('Treatment center');?> </strong><br />
										<?php echo __('Date Start');?>
									</span>
								</div>
							</td>
							<td>
								<div id="showRadiation2" style="display:<?php echo $displayRadiationTherapyValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['radiation_start_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['radiation_start_date'],Configure::read('date_format'));
									echo $this->Form->input('OtherTreatment.radiation_start_date',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  radiation_start_date ','id' => 'radiation_start_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['radiation_start_date']));
									?>
									</span>
								</div>
							</td>
							<td class="tdLabel " id="boxSpace">
								<div class="showRadiation3Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('Date Finish');?>
									</span>
								</div>
							</td>
							<td>
								<div id="showRadiation3" style="display:<?php echo $displayRadiationTherapyValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['radiation_finish_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['radiation_finish_date'],Configure::read('date_format'));
						echo $this->Form->input('OtherTreatment.radiation_finish_date',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  radiation_finish_date ','id' => 'radiation_finish_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['radiation_finish_date']));?>
									</span>
								</div>
							</td>
							<td colspan="8"></td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace" colspan="3"><?php echo __('Will patient receive chemotherapy concurrently with the radiation');?>
							</td>
							<td><?php echo $this->Form->radio('OtherTreatment.receive_chemotherapy_concurrently', array('0'=>'No','1'=>'Yes'),array('value'=>$getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_concurrently'],'legend'=>false,'label'=>false,'class' => 'receive_chemotherapy_concurrentlyCls','id'=>'receive_chemotherapy_concurrently','checked'=>$getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_concurrently']));
							if(!empty($getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_concurrently'])){
											$displayOtherTreatmentValue='block';
										}else{
											$displayOtherTreatmentValue='none';
										}?>
							</td>

							<td class="tdLabel " id="boxSpace">
								<div class="showReceiveChemotherapyLbl" style="display:<?php echo $displayOtherTreatmentValue ?>;">
									<span><?php echo __('Start Date');?> </span>
								</div>
							</td>
							<td>
								<div id="showReceiveChemotherapy" style="display:<?php echo $displayOtherTreatmentValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_date'],Configure::read('date_format'));
									echo $this->Form->input('OtherTreatment.receive_chemotherapy_date',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'receive_chemotherapy_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_date'],'class' => 'textBoxExpnd  receive_chemotherapy_dateCls'));

									?>
									</span>
								</div>
							</td>
							<td colspan="9"></td>

						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Karnofsky Score');?>
							</td>
							<td><?php echo $this->Form->input('OtherTreatment.karnofsky_score', array('options'=>Configure::read('karnofsky_score'),'class' => 'textBoxExpnd','id' => 'karnofsky_score','value'=>$getOtherTreatment['0']['OtherTreatment']['karnofsky_score'])); 
							?>
							</td>
							<td colspan="14"></td>

						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!-- EOF-othertreatments----@mahalaxmi -->
	</div>
	<h3 style="display: &amp;amp;">
		<a href="#">Significant History</a>
	</h3>
	<div id="significant_history" style="display:<?php echo $display ;?>" class="section dragbox-content">

		<?php echo $this->Form->hidden('Diagnosis.id',array('value'=>$this->request->data['Diagnosis']['id'])); ?>

		<table class="tdLabel" style="text-align: left;">

			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"><b>Past Medical History</b></td>
				<td colspan="4" style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						class="tabularForm">
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="1" cellpadding="0"
									class="tabularForm">
									<tr>
										<td valign="top" width="24%" align="center" class="tdLabel"
											id="boxSpace" style="border-left: solid 1px #3E474A;"><b><?php echo __('Problem');?>
										</b></td>
										<td valign="top" width="24%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Status');?> </b>
										</td>
										<td valign="top" width="24%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Duration(in years)');?> </b>
										</td>
										<td valign="top" width="24%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Significant Injuries');?> </b>
										</td>
										<td></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0"
									class="tabularForm" id='DrugGroup_history' class="tdLabel">
									<?php  

									if(isset($pastHistory) && !empty($pastHistory))
									{
										$count_history  = count($pastHistory);
									}else
									{
										$count_history  = 3 ;
									}
									for($i=0;$i<$count_history;)
									{
										$illness_val= isset($pastHistory[$i][PastMedicalHistory][illness])?$pastHistory[$i][PastMedicalHistory][illness]:'' ;
										$status_val= isset($pastHistory[$i][PastMedicalHistory][status])?$pastHistory[$i][PastMedicalHistory][status]:'' ;
										$duration_val= isset($pastHistory[$i][PastMedicalHistory][duration])?$pastHistory[$i][PastMedicalHistory][duration]:'' ;
										$comment_val= isset($pastHistory[$i][PastMedicalHistory][comment])?$pastHistory[$i][PastMedicalHistory][comment]:'' ;


										?>

									<tr id="DrugGroup_history<?php echo $i;?>">

										<td width="24%" valign="top" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'problemAutocomplete textBoxExpnd','id' =>"illness$i",'value'=>$illness_val,'name'=>'PastMedicalHistory[illness][]',style=>'width:270px','counter_history'=>$i)); ?>
										</td>
										<td width="24%" align="left"><?php $options = array(''=>'Please Select','Chronic'=>'Chronic','Existing'=>'Existing','New_on_set'=>'New On Set','Recovered'=>'Recovered','Acute'=>'Acute','Inactive'=>'Inactive');
										echo $this->Form->input('', array('options'=>$options,'class' => '','id'=>"status$i",'name' =>'PastMedicalHistory[status][]',style=>'width:285px','value'=>$status_val)); ?>
										</td>
										<td width="24%" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' =>"duration$i",'value'=>$duration_val,'name'=>'PastMedicalHistory[duration][]',style=>'width:270px','counter_history'=>$i,'autocomplete'=>"off")); ?>
										</td>
										<td width="24%" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => ' textBoxExpnd','id' =>"comment$i",'value'=>$comment_val,'name'=>'PastMedicalHistory[comment][]',style=>'width:270px','counter_history'=>$i,'autocomplete'=>"off")); ?>
										</td>
										<td><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_history','id'=>"pMH$i"));?>
										</td>

									</tr>
									<?php
									$i++ ;
									}
									?>

								</table>
							</td>
						</tr>

						<tr>
							<td align="right" colspan="4"><input type="button"
								id="addButton_history" value="Add"> <?php if($count_history > 0)
								{?> <!-- <input type="button" id="removeButton_history"
								value="Remove"> --> <?php }
								else{ ?> <input type="button" id="removeButton_history"
								value="Remove" style="display: none;"> <?php } ?>
							</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td class="tdLabel" id="boxSpace" valign="top" width="12%"
											align="left"><span
											title="Tuberculin Skin Test - Purified Protein Derivative">Last
												PPD</span>:</td>
										<td class="tdLabel" id="boxSpace"><?php /*
							if($this->data['PastMedicalRecord']['last_PPD']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				$lastPPDVal = isset($this->data['PastMedicalRecord']['last_PPD'])?$this->data['PastMedicalRecord']['last_PPD']:2 ;*/
                        				//echo $this->Form->radio('hx_abnormal_pap', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_abnormal_pap'],'legend'=>false,'label'=>false));
                        		echo $this->Form->radio('PastMedicalRecord.last_PPD', array('0'=>'No','1'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['last_PPD'],'legend'=>false,'label'=>false,'class' => 'personalPPD','id'=>'last_PPD','checked'=>$getpatient['0']['PastMedicalRecord']['last_PPD']));
                        		 
                        		?> <?php if(!empty($getpatient['0']['PastMedicalRecord']['last_PPD'])){
                        			$displayValue='block';
                        		}else{
											$displayValue='none';
										}?>
										</td>
										<td>
											<div id="showPPD" style="display:<?php echo $displayValue ?>;">
												<span> <?php $getpatient['0']['PastMedicalRecord']['last_PPD_yes']=$this->DateFormat->formatDate2Local($getpatient['0']['PastMedicalRecord']['last_PPD_yes'],Configure::read('date_format'));
												echo $this->Form->input('PastMedicalRecord.last_PPD_yes',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  last_PPD_yes ','id' => 'last_PPD_yes','readonly'=>'readonly','value'=>$getpatient['0']['PastMedicalRecord']['last_PPD_yes']));
												/// removeSince '.$class
												?>
												</span>
											</div>
										</td>

										<td class="tdLabel" id="boxSpace" valign="top" width="12%"
											align="left"><?php echo __('Preventive Care : '); ?>
										</td>

										<td valign="top" width="38%" align="left"><?php  echo $this->Form->input('preventive_care', array('class' =>'validate[custom[onlyLetterSp]] textBoxExpnd','id' =>'preventive_care','value'=>$getpatient[0][PastMedicalRecord][preventive_care],'style'=>'width:270px','autocomplete'=>"off")); ?>
										</td>

									</tr>
								</table>
							</td>
						</tr>

					</table>
				</td>
			</tr>



			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"><b>Past Surgical History</b>
				</td>
				<td style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						class="tabularForm" class="tdLabel">
						<tr>
							<td colspan="7">
								<table width="100%" border="0" cellspacing="0" cellpadding="0"
									class="tabularForm" class="tdLabel">
									<tr>
										<td height="20px" align="center" valign="top" width="17%"><b>Surgical/Hospitalization</b>
										</td>
										<td height="20px" align="center" valign="top" width="17%"><b>Provider</b>
										</td>
										<td height="20px" align="center" valign="top" width="17%"><b>Age</b>
										</td>
										<td height="20px" align="center" valign="top" width="17%"><b>Date</b>
										</td>
										<td height="20px" align="center" valign="top" width="17%"
											style="padding-left: 15px"><b>Comment</b></td>
										<td width="4%"></td>
									</tr>
								</table>
							</td>
						</tr>
						<?php //debug($procedureHistory);exit;
                           echo $this->Form->hidden('ProcedureHistory.id',array('value'=>$procedureHistory['ProcedureHistory']['id']));?>
						<tr>
							<td colspan="7">
								<table width="100%" border="0" cellspacing="0" cellpadding="0"
									class="tabularForm " id='DrugGroup_procedure' class="tdLabel">
									<?php

									if(isset($procedureHistory) && !empty($procedureHistory))
									{
										$count_procedure  = count($procedureHistory);
									}else
									{
										$count_procedure  = 3 ;
									}
									for($i=0;$i<$count_procedure;$i++)
									{
										$procedure_name = !empty($procedureHistory[$i]['TariffList']['name'])?$procedureHistory[$i]['TariffList']['name']:$procedureHistory[$i]['ProcedureHistory']['procedure_name'] ;
										$provider_name = !empty($procedureHistory[$i]['DoctorProfile']['doctor_name'])?$procedureHistory[$i]['DoctorProfile']['doctor_name']:$procedureHistory[$i]['ProcedureHistory']['provider_name'] ;
										$procedure_val = !empty($procedureHistory[$i]['TariffList']['id'])?$procedureHistory[$i]['TariffList']['id']:'' ;
										$provider_val = !empty($procedureHistory[$i]['DoctorProfile']['id'])?$procedureHistory[$i]['DoctorProfile']['id']:'' ;
										$procedureHistory[$i]['ProcedureHistory']['procedure_date'] = $this->DateFormat->formatDate2Local($procedureHistory[$i]['ProcedureHistory']['procedure_date'],Configure::read('date_format'),true);
										$age_value_val = isset($procedureHistory[$i]['ProcedureHistory']['age_value'])?$procedureHistory[$i]['ProcedureHistory']['age_value']:'' ;
										$age_unit_val = isset($procedureHistory[$i]['ProcedureHistory']['age_unit'])?$procedureHistory[$i]['ProcedureHistory']['age_unit']:'' ;
										$procedure_date_val = isset($procedureHistory[$i]['ProcedureHistory']['procedure_date'])?$procedureHistory[$i]['ProcedureHistory']['procedure_date']:'' ;
										$comment_val = isset($procedureHistory[$i]['ProcedureHistory']['comment'])?$procedureHistory[$i]['ProcedureHistory']['comment']:'' ;

										?>

									<tr id="DrugGroup_procedure<?php echo $i;?>">

										<td width="17%" height="20px" align="left" valign="top"><?php  echo $this->Form->input("ProcedureHistory.procedure", array('type'=>'text' ,'class' => "textBoxExpnd procedure 'validate[required,custom[onlyLetterSp]]",'id'=>"procedureDisplay_$i",'title' =>$procedure_name,'alt' => $procedure_name,'value'=>$procedure_name,'name'=>'ProcedureHistory[procedure_name][]',style=>'width:90%','counter_procedure'=>$i)); ?>
										</td>
										<?php echo $this->Form->hidden("ProcedureHistory.procedure", array('name'=>'ProcedureHistory[procedure][]','type'=>'text','id'=>"procedure_$i",'counter_procedure'=>$i,'value'=>$procedure_val)); ?>

										<td width="17%" height="20px" align="left" valign="top"><?php echo $this->Form->input("ProcedureHistory.provider_name", array('type'=>'text','class' =>'textBoxExpnd providercls','name'=>'ProcedureHistory[provider_name][]','id' => "providerDisplay_$i",'value'=>$provider_name,'style'=>'width:90%','counter_procedure'=>$i)); ?>
											<?php echo $this->Form->hidden("ProcedureHistory.provider.$i", array('name'=>'ProcedureHistory[provider][]','type'=>'text','id'=>"provider_$i",'counter_procedure'=>$i,'value'=>$provider_val)); ?>
										</td>

										<td width="17%" height="20px" align="right" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','MaxLength'=>'3','id'=>"age_value$i",'value'=>$age_value_val,'name'=>'ProcedureHistory[age_value][]','style'=>'width:29%','counter_procedure'=>$i,'autocomplete'=>"off")); ?>
											<?php  $options = array(''=>'Please Select','Days'=>'Days','Months'=>'Months','Years'=>'Years');
										echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:auto','class' => '','id'=>"age_unit$i",'name' => 'ProcedureHistory[age_unit][]','value'=>$age_unit_val)); ?>
										</td>


										<td width="17%" height="20px" align="left" valign="top"
											style="padding: 0 0 0 60px;"><?php  echo $this->Form->input('', array('type'=>'text','id'=>"procedure_date$i",'class'=>"procedure_date textBoxExpnd ",'name'=>'ProcedureHistory[procedure_date][]','value'=>$procedure_date_val,'readonly'=>'readonly','counter_procedure'=>$i,'autocomplete'=>"off")); ?>
										</td>


										<td width="17%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"comment$i",'value'=>$comment_val,'name'=>'ProcedureHistory[comment][]','style'=>'width:90%','counter_procedure'=>$i,'autocomplete'=>"off")); ?>
										</td>
										<td width="4%"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_procedure','id'=>"surgery$i"));?>
										</td>
									</tr>
									<?php

									}
									?>
								</table>
							</td>
						</tr>

						<tr>
							<td align="right" colspan="7"><input type="button"
								id="addButton_procedure" value="Add"> <?php if($count_procedure > 0)
								{?> <!-- <input type="button" id="removeButton_procedure"
								value="Remove"> --> <?php }
								else{ ?> <input type="button" id="removeButton_procedure"
								value="Remove" style="display: none;"> <?php } ?>
							</td>
						</tr>

					</table>

				</td>
			</tr>

			<?php if(!empty($pastMedication)){?>
			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"><b>Past Medication</b></td>
				<td colspan="4" style="" width="100%">
					<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm"> -->
					<!-- row 1 --> <!-- <tr>
							<td width="100%" valign="top" align="left" colspan="6"> -->
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						id='DrugGroup' class="tabularForm">
						<tr>
							<td width="20%" height="20" align="left" valign="top">Drug Name</td>
							<td width="5%" height="20" align="left" valign="top">Dose</td>
							<td width="5%" height="20" align="left" valign="top">Strength</td>
							<td width="5%" height="20" align="left" valign="top">Route</td>
							<td width="5%" align="left" valign="top">Frequency</td>
							<td width="5%" align="left" valign="top">Dosage Form</td>
							<td width="5%" align="left" valign="top">Days</td>
							<td width="5%" align="left" valign="top">Qty</td>
							<td width="5%" align="center" valign="top">Refills</td>
							<td width="5%" align="center" valign="top">PRN</td>
							<td width="5%" align="center" valign="top">DAW</td>
							<td width="10%" align="center" valign="top">Special Instruction</td>
							<td width="5%" align="center" valign="top">Is Active</td>
						</tr>

						<?php  

						if(isset($pastMedication) && !empty($pastMedication)){
                                     	$count  = count($pastMedication) ;
			               			}
			               			for($i=0;$i<$count;){

										$drug_name_val= isset($pastMedication[$i]['NewCropPrescription']['drug_name'])?$pastMedication[$i]['NewCropPrescription']['description']:'' ;
										$drug_id_val= isset($pastMedication[$i]['NewCropPrescription']['drug_id'])?$pastMedication[$i]['NewCropPrescription']['drug_id']:'' ;
										$dose_val= isset($pastMedication[$i]['NewCropPrescription']['dose'])?$pastMedication[$i]['NewCropPrescription']['dose']:'' ;
										$strength_val= isset($pastMedication[$i]['NewCropPrescription']['strength'])?$pastMedication[$i]['NewCropPrescription']['strength']:'' ;
										$route_val= isset($pastMedication[$i]['NewCropPrescription']['route'])?$pastMedication[$i]['NewCropPrescription']['route']:'' ;
										$frequency_val= isset($pastMedication[$i]['NewCropPrescription']['frequency'])?$pastMedication[$i]['NewCropPrescription']['frequency']:'' ;
										$day_val= isset($pastMedication[$i]['NewCropPrescription']['day'])?$pastMedication[$i]['NewCropPrescription']['day']:'' ;
										$quantity_val= isset($pastMedication[$i]['NewCropPrescription']['quantity'])?$pastMedication[$i]['NewCropPrescription']['quantity']:'' ;
										$refills_val= isset($pastMedication[$i]['NewCropPrescription']['refills'])?$pastMedication[$i]['NewCropPrescription']['refills']:'' ;
										$prn_val= isset($pastMedication[$i]['NewCropPrescription']['prn'])?$pastMedication[$i]['NewCropPrescription']['prn']:'' ;
										$daw_val= isset($pastMedication[$i]['NewCropPrescription']['daw'])?$pastMedication[$i]['NewCropPrescription']['daw']:'' ;
										$special_instruction_val= isset($pastMedication[$i]['NewCropPrescription']['special_instruction'])?$pastMedication[$i]['NewCropPrescription']['special_instruction']:'' ;
										$isactive_val= isset($pastMedication[$i]['NewCropPrescription']['archive'])?$pastMedication[$i]['NewCropPrescription']['archive']:'' ;
										$prescription_guid= isset($pastMedication[$i]['NewCropPrescription']['PrescriptionGuid'])?$pastMedication[$i]['NewCropPrescription']['PrescriptionGuid']:'' ;

										$dosage_form= isset($pastMedication[$i]['NewCropPrescription']['DosageForm'])?$pastMedication[$i]['NewCropPrescription']['DosageForm']:'' ;
										//if($isactive_val=='N'){

										if($isactive_val=='N')
										{
											$isactive_val='Yes';
										}
										else if($isactive_val=='Y')
										{
											$isactive_val='No';
										}
										else
											$isactive_val='Yes';
											
										?>
						<tr id="DrugGroup<?php echo $i;?>">
							<td align="left"><?php echo ($drug_name_val);?></td>
							<td align="left"><?php echo ($dose_val);?></td>
							<td align="left"><?php echo ($strength_val);?></td>
							<td align="left"><?php echo ($route_val);?></td>

							<td align="left"><?php echo ($frequency_val);?></td>
							<td align="left"><?php echo ($dosage_form);?></td>
							<td align="left"><?php echo ($day_val);?></td>
							<td align="left"><?php echo ($quantity_val);?></td>

							<td align="left"><?php echo ($refills_val);?></td>
							<td align="left"><?php echo ($prn_val);?></td>
							<td align="left"><?php echo ($daw_val);?></td>
							<td align="left"><?php echo ($special_instruction_val);?></td>

							<td align="left"><?php echo ($isactive_val);?></td>

						</tr>
						<?php
						$i++ ;
			               			}
			               			?>

					</table> <!-- </td>
						</tr> --> <!-- row 3 end --> <!--</table>-->
				</td>
			</tr>
			<?php }?>




			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"><b>Social History</b></td>
				<td colspan="4" style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						class="tabularForm">
						<?php if($patient['Patient']['age']>=18){?>
						<tr>
							<td valign="top" width="120" colspan='5' style="color: fuchsia;"'>Have
								you screened for tobbaco use?</td>
						</tr>
						<?php }?>

						<tr>
							<td valign="top" class="tdLabel" id="boxSpace">Marital Status</td>

							<td valign="top" class="tdLabel" id="boxSpace"><?php  
							//$maritail_status = array("A"=>"Separated","B"=>"Unmarried","C"=>"Common law","D"=>"Divorced","E"=>"Legally Separated","G"=>"Living together","I"=>"Interlocutory","M"=>"Married","N"=>"Annulled","O"=>"Other","P"=>"Domestic partner","R"=>"Registered domestic partner","S"=>"Single","T"=>"Unreported","U"=>"Widowed","W"=>"Unknown");

							//	debug($getdataPatient['Person']['maritail_status']);
							echo $this->Form->input('maritail_status', array('value'=>$getmaritailStatusData,'class' => 'textBoxExpnd','id' => 'maritail_status','autocomplete'=>"off",'readonly'=>'readonly')); ?>
							</td>

							</td>
							<td valign="top">Ethnicity</td>

							<td valign="top"><?php echo $this->Form->input('ethnicity', array('empty'=>__('Please Select'),'id' => 'ethnicity',
							'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','value'=>$getEthnicityData,'autocomplete'=>"off",'readonly'=>'readonly'));  ?>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>

							<td valign="top" width=21% class="tdLabel" id="boxSpace">Smoking/Tobacco</td>
							<td valign="top" width=15% class="tdLabel" id="boxSpace"><?php 
							if($this->data['PatientPersonalHistory']['smoking']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				//debug($this->data['PatientPersonalHistory']['smoking']);
                        				$smokingPersonalVal = isset($this->data['PatientPersonalHistory']['smoking'])?$this->data['PatientPersonalHistory']['smoking']:2 ;
                        				echo $this->Form->radio('PatientPersonalHistory.smoking', array('No','Yes'),array('value'=>$smokingPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal1','id' => 'smoking'));
                        				 
                        				?></td>
							<td valign="top" width=16%><?php 	
							echo $this->Form->input('PatientPersonalHistory.smoking_desc',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'smoking_desc'));
									 ?>
							</td>

							<td valign="top" width=17%><?php 
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
							<td valign="top" width=17%><?php 	

							echo $this->Form->input('PatientPersonalHistory.smoking_fre',array('type' => 'select', 'id' => 'smoking_fre', 'class' => 'removeSince', 'empty' => 'Please Select', 'options'=> $smokingOptions, 'label'=> false, 'div'=> false, 'style' => 'width:55%'));
							?><span><label id="smoking_info"
									style="cursor: pointer; text-decoration: underline; display: none;"><?php echo __('Fill information');?>
								</label> </span>
							</td>
						</tr>
						<tr>
							<td valign="top" class="tdLabel" id="boxSpace">Alcohol/ETOH</td>
							<td valign="top" class="tdLabel" id="boxSpace"><?php
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
							<td valign="top"><?php 
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
										echo $this->Form->input('PatientPersonalHistory.alcohol_fre',array('type' => 'select', 'id' => 'alcohol_fre', 'class' => 'removeSince', 'empty' => 'Please Select', 'options'=> $alcoholoption, 'label'=> false, 'div'=> false, 'style' => 'width:55%'));
										?><span><label id="alcohol_fill"
									style="cursor: pointer; text-decoration: underline; display: none;"><?php echo __('Fill information');?>
								</label> </span>
							</td>
						</tr>
						<tr>
							<td valign="top" class="tdLabel" id="boxSpace">Substance Use/Drug</td>
							<td valign="top" class="tdLabel" id="boxSpace"><?php 
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
							<td valign="top"><?php 
							echo $this->Form->input('PatientPersonalHistory.drugs_fre',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'drug_fre'));
							?>
							</td>
							<td>&nbsp;</td>
						</tr>

						<tr>
							<td valign="top" class="tdLabel" id="boxSpace">Retired</td>
							<td valign="top" class="tdLabel" id="boxSpace"><?php 
							if($this->data['PatientPersonalHistory']['retired']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				echo $this->Form->radio('PatientPersonalHistory.retired', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient[0]['PatientPersonalHistory']['retired'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
							<td valign="top"></td>
							<td valign="top"></td>
							<td>&nbsp;</td>
						</tr>

						<tr>
							<td valign="top" class="tdLabel" id="boxSpace">Caffeine Usage</td>
							<td valign="top" class="tdLabel" id="boxSpace"><?php 
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
							<td valign="top"><?php	
							echo $this->Form->input('PatientPersonalHistory.tobacco_fre',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'tobacco_fre'));
							?>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td valign="top" class="tdLabel" id="boxSpace">Diet/Nutrition</td>
							<td valign="top" class="tdLabel" id="boxSpace"><?php 
							if($this->data['PatientPersonalHistory']['diet']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$dietPersonalVal = isset($this->data['PatientPersonalHistory']['diet'])?$this->data['PatientPersonalHistory']['diet']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.diet', array('Veg','Non-Veg'),array('value'=>$dietPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal','id' => 'diet'));
			                        			 ?>
							</td>

							<td><?php echo __('Recent weight loss/gain');?> <?php	
							echo $this->Form->input('PatientPersonalHistory.diet_exp',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd ','id' => 'diet_exp','autocomplete'=>"off"));
							?></td>
							<td colspan="2"></td>

						</tr>
						<tr>
							<td valign="top" class="tdLabel" id="boxSpace">Work</td>
							<td valign="top" colspan="3" class="tdLabel" id="boxSpace"><?php 
							if($this->data['PatientPersonalHistory']['work']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$workPersonalVal = isset($this->data['PatientPersonalHistory']['work'])?$this->data['PatientPersonalHistory']['work']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.work', array('Chemical','Sound','Injuries','Stress'),array('value'=>$workPersonalVal,'legend'=>false,'label'=>false,'id' => 'work'));
			                        			 ?>
							</td>

							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="tdLabel " id="boxSpace">Military Services</td>
							<td class="tdLabel" id="boxSpace"><?php
							echo $this->Form->radio('PatientPersonalHistory.military_services', array('0'=>'No','1'=>'Yes'),array('value'=>$this->data['PatientPersonalHistory']['military_services'],'legend'=>false,'label'=>false,'class'=>'military_services','id'=>'military_services','checked'=>$this->data['PatientPersonalHistory']['military_services']));
							if(!empty($this->data['PatientPersonalHistory']['military_services'])){
											$displaySerValue='block';
										}else{
											$displaySerValue='none';

										} ?></td>
							<td>
								<div id="showMilitaryServices" style="display:<?php echo $displaySerValue ?>;">
									<?php echo __('Where');?>
									<span> <?php echo $this->Form->input('PatientPersonalHistory.militaryservices_yes',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'militaryservices_yes','value'=>$this->data['PatientPersonalHistory']['militaryservices_yes'],'autocomplete'=>"off"));	
									?>
									</span>
								</div>
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class="tdLabel " id="boxSpace">Exercise</td>
							<td class="tdLabel" id="boxSpace"><?php
							echo $this->Form->radio('PatientPersonalHistory.exercise', array('0'=>'No','1'=>'Yes'),array('value'=>$this->data['PatientPersonalHistory']['exercise'],'legend'=>false,'label'=>false,'class'=>'exercise','id'=>'exercise','checked'=>$this->data['PatientPersonalHistory']['exercise']));
							if(!empty($this->data['PatientPersonalHistory']['exercise'])){
											$displayexerciseValue='block';
										}else{
											$displayexerciseValue='none';
										}?>
							</td>

							<td>
								<div id="showExercise1" style="display:<?php echo $displayexerciseValue ?>;">
									<?php echo __('Type');?>
									<?php echo $this->Form->input('PatientPersonalHistory.exercise_type',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'exercise_type','value'=>$this->data['PatientPersonalHistory']['exercise_type'],'autocomplete'=>"off"));	
									?>
									<div id="showExercise1" style="display: $displayexerciseValue;">
							
							</td>

							<td><div id="showExercise2" style="display:<?php echo $displayexerciseValue ?>;">
									<?php echo __('Frequency');?>
									<?php echo $this->Form->input('PatientPersonalHistory.exercise_frequency',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'exercise_frequency','value'=>$this->data['PatientPersonalHistory']['exercise_frequency'],'autocomplete'=>"off"));	
									?>
								</div>
							</td>
							<td>
								<div id="showExercise3" style="display:<?php echo $displayexerciseValue ?>;">
									<?php echo __('Duration');?>
									<?php echo $this->Form->input('PatientPersonalHistory.exercise_duration',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'exercise_duration','value'=>$this->data['PatientPersonalHistory']['exercise_duration'],'autocomplete'=>"off"));	
									?>
								</div>
							</td>

						</tr>
						<tr>
							<td valign="top" class="tdLabel" id="boxSpace">Suicidal Thoughts</td>
							<td valign="top" colspan="3" class="tdLabel" id="boxSpace"><?php 
							if($this->data['PatientPersonalHistory']['suicidal_thoughts']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$suicidalPersonalVal = isset($this->data['PatientPersonalHistory']['suicidal_thoughts'])?$this->data['PatientPersonalHistory']['suicidal_thoughts']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.suicidal_thoughts', array('0'=>'No','1'=>'Yes'),array('value'=>$suicidalPersonalVal,'legend'=>false,'label'=>false,'id' => 'suicidal_thoughts'));
			                        			 ?>
							</td>

							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
				<td width="30">&nbsp;</td>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">&nbsp;</td>
				<td width="" valign="top">&nbsp;</td>
			</tr>



			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"><b>Family History</b></td>
				<td colspan="4" style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						class="tabularForm">
						<tr>
							<td width="22%" class="tdLabel" id="boxSpace" align="center"><b>Relation</b>
							</td>
							<td width="22%" class="tdLabel" id="boxSpace" align="center"><b>Problem</b>
							</td>
							<td width="22%" class="tdLabel" id="boxSpace" align="center"><b>Status</b>
							</td>
							<td width="22%" class="tdLabel" id="boxSpace" align="center"><b>Significant
									Injuries</b></td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Father'); ?>
							</td>
							<td><a href="javascript:icdwin1('father')"> <?php  echo $this->Form->input('problemf', array('class' =>'textBoxExpnd','id' =>'father','style'=>'width:270px','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemf])); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statusf',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusf],'style'=>'width:270px','id' => 'Statusfather')); ?>
							</td>
							<td><?php echo $this->Form->input('commentsf', array('class' => 'textBoxExpnd','style'=>'width:270px','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsf],'autocomplete'=>"off")); ?>
							</td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Mother'); ?>
							</td>
							<td><a href="javascript:icdwin1('mother')"><?php  echo $this->Form->input('problemm', array('style'=>'width:270px','class' =>'textBoxExpnd','id' =>'mother','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemm])); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statusm',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'style'=>'width:270px','value'=>$getpatientfamilyhistory[0][FamilyHistory][statusm],'id' => 'Statusmother')); ?>
							</td>
							<td><?php echo $this->Form->input('commentsm', array('class' => ' textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsm],'style'=>'width:270px','autocomplete'=>"off")); ?>
							</td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Brother'); ?>
							</td>
							<td><a href="javascript:icdwin1('brother')"><?php  echo $this->Form->input('problemb', array('class' =>'textBoxExpnd','id' =>'brother','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemb],'style'=>'width:270px')); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statusb',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusb],'style'=>'width:270px','id' => 'Statusbrother')); ?>
							</td>
							<td><?php echo $this->Form->input('commentsb', array('class' => 'textBoxExpnd','id' => 'Comments','style'=>'width:270px','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsb],'autocomplete'=>"off")); ?>
							</td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Sister'); ?>
							</td>
							<td><a href="javascript:icdwin1('sister')"><?php  echo $this->Form->input('problems', array('class' =>'textBoxExpnd','style'=>'width:270px','id' =>'sister','value'=>$getpatientfamilyhistory[0][FamilyHistory][problems])); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statuss',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statuss],'style'=>'width:270px','id' => 'Statussister')); ?>
							</td>
							<td><?php echo $this->Form->input('commentss', array('class' => 'textBoxExpnd','style'=>'width:270px','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentss],'autocomplete'=>"off")); ?>
							</td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Son'); ?>
							</td>
							<td><a href="javascript:icdwin1('son')"> <?php  echo $this->Form->input('problemson', array('style'=>'width:270px','class' =>'textBoxExpnd','id' =>'son','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemson],'')); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statusson',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusson],'id' => 'Statusson','style'=>'width:270px')); ?>
							</td>
							<td><?php echo $this->Form->input('commentsson', array('style'=>'width:270px','class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsson],'autocomplete'=>"off")); ?>
							</td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Daughter'); ?>
							</td>
							<td><a href="javascript:icdwin1('daughter')"> <?php  echo $this->Form->input('problemd', array('style'=>'width:270px','class' =>'textBoxExpnd','id' =>'daughter','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemd],'')); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statusd',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusd],'id' => 'Statusdaughter','style'=>'width:270px')); ?>
							</td>
							<td><?php echo $this->Form->input('commentsd', array('style'=>'width:270px','class' =>'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsd],'autocomplete'=>"off")); ?>
							</td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Other Relatives'); ?>
							</td>
							<td colspan="3"><?php echo $this->Form->input('other_relatives',array('options'=>array(""=>__('Please Select'),"Uncle"=>__('Uncle'),'Aunt'=>__('Aunt'),'Grandmother'=>__('Grandmother'),'Grandfather'=>__('Grandfather')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][other_relatives],'id' => 'other_relatives','style'=>'width:270px')); ?>
							</td>
						</tr>
						<?php $unHideRelation = '';?>
						<?php if(empty($getpatientfamilyhistory[0][FamilyHistory][problemuncle])){
							$unHideRelation='showUncle';
							  }?>
						<tr id="showUncle" class="<?php echo $showUncle1 ?>">
							<td class="tdLabel" id="boxSpace"><?php echo __('Uncle'); ?>
							</td>
							<td><a href="javascript:icdwin1('uncle')"><?php  echo $this->Form->input('problemuncle', array('style'=>'width:270px','class' =>'textBoxExpnd','id' =>'uncle','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemuncle],'','div'=>false)); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statusuncle',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusuncle],'id' => 'statusuncle','style'=>'width:270px','div'=>false)); ?>
							</td>
							<td><?php echo $this->Form->input('commentsuncle', array('style'=>'width:270px','class' =>'textBoxExpnd','id' => 'commentsuncle','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsuncle],'div'=>false)); ?>
							</td>
						</tr>
						<?php if(empty($getpatientfamilyhistory[0][FamilyHistory][problemaunt])){
							$unHideRelation .= ($unHideRelation) ? ',showAunt' : 'showAunt';
							  }?>
						<tr id="showAunt" class="<?php echo $showAunt1 ?>">
							<td class="tdLabel" id="boxSpace"><?php echo __('Aunt'); ?>
							</td>
							<td><a href="javascript:icdwin1('aunt')"> <?php  echo $this->Form->input('problemaunt', array('style'=>'width:270px','class' =>'textBoxExpnd','id' =>'aunt','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemaunt],'')); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statusaunt',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusaunt],'id' => 'statusaunt','style'=>'width:270px')); ?>
							</td>
							<td><?php echo $this->Form->input('commentsaunt', array('style'=>'width:270px','class' =>'textBoxExpnd','id' => 'commentsaunt','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsaunt])); ?>
							</td>
						</tr>
						<?php if(empty($getpatientfamilyhistory[0][FamilyHistory][problemgrandmother])){
							$unHideRelation .= ($unHideRelation) ? ',showGrandmother' : 'showGrandmother';
							  }?>
						<tr id="showGrandmother" class="<?php echo $showgrandmother1 ?>">
							<td class="tdLabel" id="boxSpace"><?php echo __('Grandmother'); ?>
							</td>
							<td><a href="javascript:icdwin1('grandmother')"> <?php  echo $this->Form->input('problemgrandmother', array('style'=>'width:270px','class' =>'textBoxExpnd','id' =>'grandmother','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemgrandmother],'')); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statusgrandmother',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusgrandmother],'id' => 'statusgrandmother','style'=>'width:270px')); ?>
							</td>
							<td><?php echo $this->Form->input('commentsgrandmother', array('style'=>'width:270px','class' =>'textBoxExpnd','id' => 'commentsgrandmother','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsgrandmother])); ?>
							</td>
						</tr>
						<?php if(empty($getpatientfamilyhistory[0][FamilyHistory][problemgrandfather])){
							$unHideRelation .= ($unHideRelation) ? ',showGrandfather' : 'showGrandfather';
							  }?>
						<tr id="showGrandfather" class="<?php echo $showgrandfather1 ?>">
							<td class="tdLabel" id="boxSpace"><?php echo __('Grandfather'); ?>
							</td>
							<td><a href="javascript:icdwin1('grandfather')"> <?php  echo $this->Form->input('problemgrandfather', array('style'=>'width:270px','class' =>'textBoxExpnd','id' =>'grandfather','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemgrandfather],'')); ?>
							</a>
							</td>
							<td><?php echo $this->Form->input('statusgrandfather',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusgrandfather],'id' => 'statusgrandfather','style'=>'width:270px')); ?>
							</td>
							<td><?php echo $this->Form->input('commentsgrandfather', array('style'=>'width:270px','class' =>'textBoxExpnd','id' => 'commentsgrandfather','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsgrandfather])); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<?php 
		 if(strtolower($sex)=='female')
		 {
		 	 
		 	?>

			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"><b>Obstetric History</b></td>
				<td style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						class="tabularForm">
						<tr>
							<td width="24%" class="tdLabel" id="boxSpace"><?php echo __('Age Onset of Menses:'); ?>
							</td>
							<td width="75%"><?php echo $this->Form->input('age_menses', array('class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]','id' =>'age_menses','value'=>$getpatient[0][PastMedicalRecord][age_menses],'style'=>'width:270px','autocomplete'=>"off")); ?><font>&nbsp;Years</font>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Length of Periods: '); ?>
							</td>
							<td><?php echo $this->Form->input('length_period', array('class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]','id' =>'length_period','value'=>$getpatient[0][PastMedicalRecord][length_period],'style'=>'width:270px','autocomplete'=>"off")); ?><font>&nbsp;Days</font>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Number of days between Periods: '); ?>
							</td>
							<td><?php echo $this->Form->input('days_betwn_period', array('class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]','id' =>'days_betwn_period','value'=>$getpatient[0][PastMedicalRecord][days_betwn_period],'style'=>'width:270px','autocomplete'=>"off")); ?><font>&nbsp;Days</font>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Any recent changes in Periods: '); ?>
							</td>
							<td><?php  $option_Periods = array(''=>'Please Select','Yes'=>'Yes','No'=>'Not Currently');
							echo $this->Form->input('Diagnosis.recent_change_period', array( 'options'=>$option_Periods,'style'=>'width:270px','class' => '','id'=>"recent_change_period",'value'=>$getpatient[0][PastMedicalRecord][recent_change_period])); ?>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Age at Menopause: '); ?>
							</td>
							<td><?php echo $this->Form->input('age_menopause', array('class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]','id' =>'age_menopause','value'=>$getpatient[0][PastMedicalRecord][age_menopause],'style'=>'width:270px','autocomplete'=>"off")); ?>
								<font>&nbsp;Years</font>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"></td>
				<td width="100%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"><b>Number of Pregnancies:</b></td>
			</tr>

			<tr>
				<td width="19%" valign="top" id="boxSpace"
					style="padding-top: 10px;"></td>
				<td style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						class="tabularForm" class="tdLabel">
						<tr>
							<td colspan="7">
								<table width="100%" border="0" cellspacing="1" cellpadding="0"
									class="tabularForm" class="tdLabel">
									<tr>
										<td width="5%" height="20px" align="center" valign="top"><b>Sr.
												No.</b></td>
										<td width="14%" height="20px" align="center" valign="top"><b>Date
												of Birth</b></td>
										<td width="14%" height="20px" align="center" valign="top"><b>Weight
												(in lbs)</b></td>
										<td width="13%" height="20px" align="center" valign="top"><b>Baby's
												Gender</b></td>
										<td width="14%" height="20px" align="center" valign="top"><b>Weeks
												Pregnant</b></td>
										<td width="14%" height="20px" align="center" valign="top"><b>Type
												of Delivery</b></td>
										<td width="14%" height="20px" align="center" valign="top"><b>Complications</b>
										</td>
										<td width="4%" height="20px" align="center" valign="top"></td>

									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="7">
								<table width="100%" border="0" cellspacing="1" cellpadding="0"
									class="tabularForm" id='DrugGroup_nw' class="tdLabel">
									<?php  
									if(isset($pregnancyData) && !empty($pregnancyData))
									{
										$count_nw  = count($pregnancyData);
									}else
									{
										$count_nw  = 3 ;
									}
									for($i=0;$i<$count_nw;)
									{
										$pregnancyData[$i]['PregnancyCount']['date_birth'] = $this->DateFormat->formatDate2Local($pregnancyData[$i]['PregnancyCount']['date_birth'],Configure::read('date_format'),true);

										$counts_val = isset($pregnancyData[$i]['PregnancyCount']['counts'])?$pregnancyData[$i]['PregnancyCount']['counts']:'' ;
										$date_birth_val = isset($pregnancyData[$i]['PregnancyCount']['date_birth'])?$pregnancyData[$i]['PregnancyCount']['date_birth']:'' ;
										$weight_val = isset($pregnancyData[$i]['PregnancyCount']['weight'])?$pregnancyData[$i]['PregnancyCount']['weight']:'' ;
										$baby_gender_val = isset($pregnancyData[$i]['PregnancyCount']['baby_gender'])?$pregnancyData[$i]['PregnancyCount']['baby_gender']:'' ;
										$week_pregnant_val = isset($pregnancyData[$i]['PregnancyCount']['week_pregnant'])?$pregnancyData[$i]['PregnancyCount']['week_pregnant']:'' ;
										$type_delivery_val = isset($pregnancyData[$i]['PregnancyCount']['type_delivery'])?$pregnancyData[$i]['PregnancyCount']['type_delivery']:'' ;
										$complication_val = isset($pregnancyData[$i]['PregnancyCount']['complication'])?$pregnancyData[$i]['PregnancyCount']['complication']:'' ;
										?>
									<tr id="DrugGroup_nw<?php echo $i;?>">

										<td width="5%" height="20px" align="left" valign="top"><?php echo $i+1?>
										</td>

										<td width="14%" height="20px" align="left" valign="top"
											class="tddate"><?php echo $this->Form->input('', array('type'=>'text','id' => "date_birth$i",'class'=>'date_birth','name'=>'pregnancy[date_birth][]','value'=>$date_birth_val,'style'=>'width:130px','counter_nw'=>$i, 'readonly' => 'readonly','autocomplete'=>"off")); ?>
										</td>

										<td width="14%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id'=>"weight$i",'value'=>$weight_val,'name'=>'pregnancy[weight][]',style=>'width:146px','counter_nw'=>$i,'autocomplete'=>"off")); ?>
										</td>

										<td width="13%" height="20px" align="left" valign="top"><?php  $options = array(''=>'Please Select','M'=>'Male','F'=>'Female');
										echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:148px','class' => '','id'=>"baby_gender$i",'name' => 'pregnancy[baby_gender][]','value'=>$baby_gender_val)); ?>
										</td>

										<td width="14%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id'=>"week_pregnant$i",'value'=>$week_pregnant_val,'name'=>'pregnancy[week_pregnant][]','style'=>'width:146px','counter_nw'=>$i,'autocomplete'=>"off")); ?>
										</td>

										<td width="14%" height="20px" align="left" valign="top"><?php  $delivery_options = array(''=>'Please Select','Vaginal Delivery-Episiotomy'=>'Vaginal Delivery-Episiotomy','Vaginal Delivery-Induced labor'=>'Vaginal Delivery-Induced labor','Vaginal Delivery -Forceps delivery'=>'Vaginal Delivery -Forceps delivery','Vaginal Delivery-Vacuum extraction'=>'Vaginal Delivery-Vacuum extraction','Cesarean section'=>'Cesarean section');
										echo $this->Form->input('', array('options'=>$delivery_options ,'class' =>'textBoxExpnd','id'=>"type_delivery$i",'value'=>$type_delivery_val,'name'=>'pregnancy[type_delivery][]','style'=>'width:148px','counter_nw'=>$i)); ?>
										</td>

										<td width="14%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"complication$i",'value'=>$complication_val,'name'=>'pregnancy[complication][]','style'=>'width:145px','counter_nw'=>$i,'autocomplete'=>"off")); ?>
										</td>
										<td width="4%"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_nw','id'=>"pregnancy$i"));?>
										</td>
									</tr>
									<?php
									$i++ ;
									}
									?>
								</table>
							</td>
						</tr>

						<tr>
							<td align="right" colspan="7"
								style="border-bottom: solid 1px #3E474A;"><input type="button"
								id="addButton_nw" value="Add"> <?php if($count_nw > 0)
								{?> <!-- <input type="button" id="removeButton_nw" value="Remove">  -->
								<?php }
								else{ ?> <input type="button" id="removeButton_nw"
								value="Remove" style="display: none;"> <?php } ?></td>
						</tr>

						<tr>
							<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Abortions, Still Births, Miscarriages: '); ?>
							</td>
							<td width="60%" colspan="6"><?php  echo $this->Form->input('abortions_miscarriage', array('class' =>'validate[optional,custom[onlyLetterSp]] textBoxExpnd','id' =>'abortions_miscarriage','value'=>$getpatient[0][PastMedicalRecord][abortions_miscarriage],'style'=>'width:250px','autocomplete'=>"off")); ?>
							</td>
						</tr>

					</table>

				</td>
			</tr>



			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"><b>Gynecology History</b></td>
				<td style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						class="tabularForm" class="tabularForm" id='DrugGroup'
						class="tdLabel">
						<tr>
							<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Present Symptoms:'); ?>
							</td>
							<td width="40%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['present_symptom']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('present_symptom', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['present_symptom'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
							<td width="40%"></td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Past Infections: '); ?>
							</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['past_infection']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('past_infection', array('None'=>'None','Chlamydia'=>'Chlamydia','Syphilis'=>'Syphilis','PID'=>'PID','Gonorrhea'=>'Gonorrhea','Other STD'=>'Other STD'),array('value'=>$getpatient[0]['PastMedicalRecord']['past_infection'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
							<td></td>
						</tr>

						<tr>
							<td class="tdLabel " id="boxSpace"><span
								title="Papanicolaou smear">Last PAP</span>:</td>
							<td class="tdLabel" id="boxSpace"><?php
							/*if($this->data['PastMedicalRecord']['hx_abnormal_pap']==1){
							 $class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				$pastMedicalRecordVal = isset($this->data['PastMedicalRecord']['hx_abnormal_pap'])?$this->data['PastMedicalRecord']['hx_abnormal_pap']:2 ;
                        				*///echo $this->Form->radio('hx_abnormal_pap', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_abnormal_pap'],'legend'=>false,'label'=>false));

	echo $this->Form->radio('PastMedicalRecord.hx_abnormal_pap', array('0'=>'None','1'=>'Yes'),array('value'=>$getpatient['0']['PastMedicalRecord']['hx_abnormal_pap'],'legend'=>false,'class'=>'personalPAP','label'=>false,'id'=>'hx_abnormal_pap','checked'=>$getpatient['0']['PastMedicalRecord']['hx_abnormal_pap']));

	if(!empty($getpatient['0']['PastMedicalRecord']['hx_abnormal_pap'])){
                        					$displayPAPValue='block';
                        				}else{
											$displayPAPValue='none';
										}?></td>
							<td>
								<div id="showPAP" style="display:<?php echo $displayPAPValue ?>;">
									<span> <?php 
									$getpatient['0']['PastMedicalRecord']['hx_abnormal_pap_yes']=$this->DateFormat->formatDate2Local($getpatient['0']['PastMedicalRecord']['hx_abnormal_pap_yes'],Configure::read('date_format'));
									echo $this->Form->input('PastMedicalRecord.hx_abnormal_pap_yes',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  hxabnormalpap_yes ','id' => 'hxabnormalpap_yes','readonly'=>'readonly','value'=>$getpatient['0']['PastMedicalRecord']['hx_abnormal_pap_yes'],'autocomplete'=>"off"));
									/// removeSince '.$class
									?>
									</span>
								</div>
							</td>
						</tr>
						<tr>
							<td class="tdLabel " id="boxSpace">Last Mammography</td>
							<td class="tdLabel" id="boxSpace"><?php
							/*if($this->data['PastMedicalRecord']['last_mammography']==1){
							 $class1 = '';
                        				}else{
                        					$class1  ='hidden';
                        				}
                        				$lastMammographyVal = isset($this->data['PastMedicalRecord']['last_mammography'])?$this->data['PastMedicalRecord']['last_mammography']:2 ;
                        				//echo $this->Form->radio('hx_abnormal_pap', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_abnormal_pap'],'legend'=>false,'label'=>false));
                        				*/
										echo $this->Form->radio('PastMedicalRecord.last_mammography', array('0'=>'None','1'=>'Yes'),array('value'=>$getpatient['0']['PastMedicalRecord']['last_mammography'],'legend'=>false,'label'=>false,'class' => 'personalMammography','id'=>'last_mammography','checked'=>$getpatient['0']['PastMedicalRecord']['last_mammography']));
										if(!empty($getpatient['0']['PastMedicalRecord']['last_mammography'])){
											$displaymammographyValue='block';
										}else{
											$displaymammographyValue='none';
										}?>
							</td>
							<td>
								<div id="showMammography" style="display:<?php echo $displaymammographyValue ?>;">
									<span> <?php $getpatient['0']['PastMedicalRecord']['last_mammography_yes']=$this->DateFormat->formatDate2Local($getpatient['0']['PastMedicalRecord']['last_mammography_yes'],Configure::read('date_format'));
									echo $this->Form->input('PastMedicalRecord.last_mammography_yes',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  last_mammography_yes ','id' => 'last_mammography_yes','readonly'=>'readonly','value'=>$getpatient['0']['PastMedicalRecord']['last_mammography_yes'],'autocomplete'=>"off"));
									/// removeSince '.$class
									?>
									</span>
								</div>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('History of cervical biopsy: '); ?>
							</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hx_cervical_bx']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hx_cervical_bx', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_cervical_bx'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
							<td></td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('History of fertility drugs: '); ?>
							</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hx_fertility_drug']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hx_fertility_drug', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_fertility_drug'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
							<td></td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace">History of <span
								title="Hormone Replacement Therapy "> HRT </span> use:
							</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hx_hrt_use']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hx_hrt_use', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_hrt_use'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
							<td></td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('History of irregular menses: '); ?>
							</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hx_irregular_menses']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hx_irregular_menses', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_irregular_menses'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
							<td></td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><span
								title="Last Menstrual Period "> L.M.P. </span>:</td>
							<?php $getpatient[0]['PastMedicalRecord']['lmp'] = $this->DateFormat->formatDate2Local($getpatient[0]['PastMedicalRecord']['lmp'],Configure::read('date_format'),true); ?>
							<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('lmp', array('type'=>'text','id' =>'lmp','readonly'=>'readonly','class'=>'textBoxExpnd','value'=>$getpatient[0]['PastMedicalRecord']['lmp'],'style'=>'width:120px','autocomplete'=>"off")); ?>
							</td>
							<td></td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace">Symptoms since <span
								title="Last Menstrual Period "> L.M.P. </span>:
							</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['symptom_lmp']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				echo $this->Form->radio('symptom_lmp', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['symptom_lmp'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"></td>
				<td width="100%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"><b>Sexual Activity:</b></td>
			</tr>

			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;"></td>
				<td style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0"
						class="tabularForm" id='DrugGroup' class="tdLabel">
						<tr>
							<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Are you sexually active?'); ?>
							</td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['sexually_active']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('sexually_active', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['sexually_active'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>


						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Do you use birth control?'); ?>
							</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['birth_controll']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('birth_controll', array('No'=>'No','Yes'=>'Yes','Condoms'=>'Condoms'),array('value'=>$getpatient[0]['PastMedicalRecord']['birth_controll'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Do you do regular Breast self-exam?'); ?>
							</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['breast_self_exam']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('breast_self_exam', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['breast_self_exam'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('New Partners? '); ?>
							</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['new_partner']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('new_partner', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['new_partner'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Partner Notification '); ?>
							</td>

							<td class="tdLabel" id="boxSpace"><?php 

							if($getpatient[0]['PastMedicalRecord']['partner_notification'] == 1){
								echo $this->Form->checkbox('partner_notification', array('checked' => 'checked'));
							}else{
								echo $this->Form->checkbox('partner_notification');
							}


							//echo $this->Form->checkbox('partner_notification',array('name'=>'1'));?>


							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><span
								title="Human Immunodeficiency Virus"> HIV </span> Education
								Given:</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hiv_education']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hiv_education', array('No'=>'No','Referred'=>'Referred'),array('value'=>$getpatient[0]['PastMedicalRecord']['hiv_education'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>


						<tr>
							<td class="tdLabel" id="boxSpace"><span title="Papanicolaou"> PAP
							</span>/<span title="Sexually Transmitted Diseases"> STD </span>
								Education Given:</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['pap_education']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('pap_education', array('No'=>'No','Referred'=>'Referred'),array('value'=>$getpatient[0]['PastMedicalRecord']['pap_education'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace"><span title="Gynecology"> GYN </span>
								Referral:</td>
							<td class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['gyn_referral']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('gyn_referral', array('No'=>'No','Referred'=>'Referred'),array('value'=>$getpatient[0]['PastMedicalRecord']['gyn_referral'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>

					</table>
				</td>

			</tr>

			<?php 
		 }
		 ?>







		</table>
	</div>







	<!--	 EOF current treatment  -->
	<!-- BOF physical examination  
	<h3>
		<a href="#">Physical Examination</a>
	</h3>
	<div class="section" id="examine">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<!--BOF templates for examination  
			<tr>
				<!--<td width="27%" valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">Vital Signs:</td>				 		
				 		->
				<td width="100%" align="left" valign="top" colspan="2">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td valign="top" width="10%">Vital Signs:</td>
							<td valign="top" width="15%">Temp: <?php	
							echo $this->Form->input('TEMP',array('legend'=>false,'class' => 'validate[optional,custom[onlyNumber]]','label'=>false ,'id' => 'TEMP','size'=>2));
							?> &#8457;
							</td>
							<td valign="top" width="15%">P.R: <?php	
							echo $this->Form->input('PR',array('legend'=>false,'label'=>false,'class' => 'validate[optional,custom[integer]]','id' => 'PR','size'=>2));
							?>/Min
							</td>
							<td valign="top" width="15%">R.R: <?php	
							echo $this->Form->input('RR',array('legend'=>false,'label'=>false,'class' => 'validate[optional,custom[integer]]','id' => 'RR','size'=>2));
							?>/Min
							</td>
							<td valign="top" width="20%">BP: <?php	
							echo $this->Form->input('BP',array('class' => 'validate[optional,custom[bp]]','legend'=>false,'label'=>false ,'id' => 'BP','size'=>8));
							?>mm/hg
							</td>
							<td valign="top" width="25%">SPO<sub>2</sub>: <?php	
							echo $this->Form->input('spo2',array('legend'=>false,'label'=>false ,'class' => 'validate[optional,custom[onlyNumber]]','id' => 'spo2','size'=>8));
							?>% in Room Air
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="27%" align="left" valign="top">
					<div id="templateArea-examine"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td><?php echo $this->Form->input('general_examine', array('class' => 'textBoxExpnd','id' => 'general_examine',
									'style'=>'width:100%','rows'=>15)); ?>
									<a href="javascript:void(0);" onclick="callDragon('general_examine')" style="text-align:left;"><font color="#000">Use speech recognition</font> </a>
							</td>
							<td height="25" valign="middle" class="tdLabel1" id="boxSpace"><?php //echo __('ICD Code') ;?>
							</td>
							<td align="left" valign="top"><?php
							//echo $this->Html->link($this->Html->image('icons/search_icon.png'),'#',array('escape'=>false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'icd'))."', '_blank',
							//	           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=800,left=200,top=200');  return false;"));
							?></td>
							<td width="30" align="left">&nbsp;</td>
						</tr>








					</table>
				</td>
			</tr>
			<tr>
				<td width="27%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Rectal Examination:</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td valign="top"><?php	
							echo $this->Form->input('rectal_examine',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'rectal_examine'));
							?>
							</td>
							<td valign="top"><?php	
							echo $this->Form->radio('rectal_option',array('Declined','Not Declined'),array('legend'=>false,'label'=>false,'class' => '','id' => 'rectal_option'));
							?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php if(strtolower($patient['Patient']['sex'])=='female') { ?>
			<tr>
				<td width="27%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Examination of breasts:</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td valign="top"><?php	
							echo $this->Form->input('breast_examine',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'breast_examine'));
							?>
							</td>
							<td valign="top"><?php	
							echo $this->Form->radio('breast_option',array('Declined','Not Declined'),array('legend'=>false,'label'=>false,'class' => '','id' => 'breast_option'));
							?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php } //EOF female cond ?>
			<tr>
				<td width="27%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Pelvic Examination/External Genitalia:</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td valign="top"><?php	
							echo $this->Form->input('pelvic_examine',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'pelvic_examine'));
							?>
							</td>
							<td valign="top"><?php	
							echo $this->Form->radio('pelvic_option',array('Declined','Not Declined'),array('legend'=>false,'label'=>false,'class' => '','id' => 'pelvic_option'));
							?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<!--  height/ weight  ->
			<tr>
				<td width="27%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Height:</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td valign="top"><?php	
							echo $this->Form->input('height',array('legend'=>false,'label'=>false,'class' => 'validate[optional,custom[onlyNumber]]', 'style' => 'width:50px','id' => 'height'));
							?> (Inch.)</td>
							<td valign="top">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="27%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Weight:</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td valign="top"><?php	
							echo $this->Form->input('weight',array('legend'=>false,'label'=>false,'class' => 'validate[optional,custom[onlyNumber]]', 'style' => 'width:50px', 'id' => 'weight'));
							?> (Lbs.)</td>
							<td valign="top">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="27%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">BMI:</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td valign="top"><?php	
							echo $this->Form->input('bmi',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd', 'style' => 'width:50px', 'id' => 'bmi', 'readonly' => 'readonly'));
							?> <span id="bmiStatus"></span>
							</td>
							<td valign="top"><?php	
							echo $this->Form->input('bmi_status',array('type'=>'hidden','legend'=>false,'label'=>false,'class' => 'textBoxExpnd', 'style' => 'width:50px', 'id' => 'id1', 'readonly' => 'readonly'));
							?> <span id="bmiStatus"></span>
							</td>
							<td valign="top">&nbsp;</td>
							<td valign="top"><a href="#" id="pres">Show BMI Growth Chart</a>
								<?php echo $this->Html->link(__(''),'#',array('escape'=>false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'bmi_chart',$patient['Patient']['id']))."', '_blank',
											'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=800,left=200,top=200');  return false;"));?>

							</td>
						</tr>
					</table>
				</td>
			</tr>

			<!--<tr>

				 <td width="27%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Disability:</td>
				<td width="70%" align="left" valign="top">

					<table width="100%" border="0" cellspacing="0" cellpadding="0"
						id="disabilityAdd_0">
						<tr>
							<td valign="top"><?php	
							echo $this->Form->input('disability',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'rectal_examine'));
							?>
							</td>
							<td valign="top" class="tdLabel" id="boxSpace">Date :</td>
							<td valign="top"><?php echo $this->Form->input('effective_date', array('style'=>'width:80px;','type'=>'text','class' => 'effective_date')); ?>

								<!--   </td>
					<td valign="top"><?php // echo $this->Form->radio(__('status_option'), array('active'=>'Active','inactive'=>'Inactive'),array('value'=>('Active'),'legend'=>false,'name'=>'disease_status','label'=>false,'id' => 'status_option'));?>
							</td> 
							
							<td><?php echo $this->Form->radio('status_option', array('Active'=>'Active','Inactive'=>'Inactive'), array('legend'=>false,'label'=>false,'id' => 'status_option' ? FALSE : TRUE,));?>
							</td>
							<td><input class="blueBtn" type="button" value="Add"
								id="labResultButton">&nbsp;<input class="blueBtn" type="button"
								value="Remove" id="RemoveLabResultButton">
							</td>
						</tr>
						</tr>
					</table>


				</td> 
			</tr>->
			<!--  height/ weight  ->
		</table>
	</div> -->
	<!-- EOF physical examination -->
	<!-- 	<h3>
		<a href="#">Diagnosis</a>
	</h3>
	<div class="section" id="diagnosis">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Provisional Diagnosis:</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top"><?php	
							echo $this->Form->textarea('provisional_diagnosis',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'provisional_dignosis','rows'=>'2','width'=>'100%'));
							?>
							</td>

						</tr>
					</table>
				</td>
			</tr>
			<tr>

				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator' style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-diagnosis"></div>
				</td>

				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('final_diagnosis', array('class' => 'textBoxExpnd','id' =>'final_diagnosis','style'=>'width:98%','rows'=>22)); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="27%" align="left" valign="top"></td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left" valign="top"><a href="javascript:icdwin()"> <?php //echo $this->Html->image('icons/search_icon.png',array('title'=>'Search ICD Code')) ?>
							</a>
							</td>

							<td align="left" valign="top"><a href="javascript:snowmed()"> <?php echo $this->Html->image('icons/search_icon.png',array('title'=>'Search ICD Code')) ?>
							</a>
							</td>
							<td width="30" align="left">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" class="tempHead"><?php 
							echo $this->Form->input('ICD_code',array('type'=>'hidden','id'=>'icd_ids','value'=>$this->data['Diagnosis']['ICD_code']));
							
							if(empty($this->data['Diagnosis']['ICD_code'])){
			              	  				$displayICD ="none";
			              	  			}else{
			              	  				$displayICD ="block";
			              	  			}
			              	  			?>
								<div id="icdSlc" style="display:<?php echo $displayICD; ?>;">
									<?php   $icd_ids=explode('|',$this->data['Diagnosis']['ICD_code']);  
									//debug($icd_ids);
									if($noOfIds==1){
										unset($icd_ids);
									}else{
										$noOfIds =count($icd_ids);
									}//debug($icd_ids);
									echo $this->Form->input('ICD_code_count',array('type'=>'hidden','id'=>'icd_ids_count','value'=>$noOfIds));
									if(is_array($icd_ids)){
										for($k=0;$k<$noOfIds;){
											if(!empty($icd_ids[$k]['icd']['id'])){
			              	  					$id = $icd_ids[$k]['icd']['id'] ;
			              	  					echo "<p id="."icd_".$id." style='padding:0px 10px;'>";
			              	  					
			              	  					echo $this->Html->image('/img/icons/cross.png',array("align"=>"right","id"=>"ers_$id","onclick"=>"javascript:remove_icd('$icd_ids[$k]', '$id');","title"=>"Remove"
			              	  			                                ,"style"=>"cursor: pointer;","alt"=>"Remove","class"=>"icd_eraser"));
			              	  			        echo $icd_ids[$k];
												echo "</p>";
		              	  					}$k++ ;
										}
									}?>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td>&nbsp;</td>
			</tr>

		</table>
	</div>  -->
	<?php if($display=='none'){ ?>
	<!--  <h3>
		<a href="#">Investigation</a>
	</h3>
	
	<div class="section" id="investigation">
		<div id="templateArea-investigation"></div>
	</div>-->
	<?php }		 
	if($patient['Patient']['admission_type']=='IPD'){
     			$planCareText  = "Plan of care during Hospitalization";
     			$surgeryText = 'Surgery if any done during Hospitalization';
     		}else{
     			$planCareText  = "Plan of care";
     			$surgeryText = 'Procedure if any';
     		}
     		?>
	<!-- EOF final diagnosis and ICD Code -->
	<!--<h3>
		<a href="#"> <?php echo $surgeryText ;?>
		</a>
	</h3>
	<div class="section" id="surgery">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator' style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-surgery"></div>
				</td>

				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td><?php echo $this->Form->input('surgery', array('class' => 'textBoxExpnd','id' => 'surgery_desc',
									'style'=>'width:100%','rows'=>18)); ?>
									<a href="javascript:void(0);" onclick="callDragon('surgery')" style="text-align:left;"><font color="#000">Use speech recognition</font> </a>
							</td>
							<td height="25" valign="middle" class="tdLabel1" id="boxSpace"><?php //echo __('ICD Code') ;?>
							</td>
							<td align="left" valign="top"><?php
							//echo $this->Html->link($this->Html->image('icons/search_icon.png'),'#',array('escape'=>false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'icd'))."', '_blank',
							//	           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=800,left=200,top=200');  return false;"));
							?>
							</td>
							<td width="30" align="left">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div> -->
	<!-- BOF register notes -->
	<!--	<h3 style="display: &amp;amp;">
		<a href="#">Registrar Notes</a>
	</h3>
	<div class="section" style="display: &amp;amp;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Registrar Notes</td>
				<td width="80%" valign="top" align="left" style="padding: 8px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td valign="top"><?php echo 'S/B :' ?><?php

							echo $this->Form->input('register_sb', array('options'=>$doctors,'empty'=>'Please select','id' => 'register_sb')); ?>

							</td>
							<td><?php echo("Date/Time :")?></td>
							<td><?php echo $this->Form->input('register_on', array('type'=>'text','id' => 'register_on','class'=>'textBoxExpnd','style'=>'width:120px')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">&nbsp;</td>
				<td width="80%" valign="top" align="left" style="padding: 8px;"><?php echo $this->Form->textarea('register_note', array('class' => 'textBoxExpnd','id' => 'advice','style'=>'width:98%','row'=>3)); ?>
				</td>
			</tr>
		</table>
	</div> -->
	<!-- EOF register notes -->
	<!-- BOF consultants opinion -->
	<!--	<h3>
		<a href="#">Consultants Opinion</a>
	</h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Consultants Opinion</td>
				<td width="80%" valign="top" align="left" style="padding: 8px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						
						<tr>
							<td><?php echo __('S/B :'); ?></td>
							<td  align="top"> <?php //echo $this->Form->input('consultant_sb', array('empty'=>'Please select','options'=>$registrar,'id' => 'consultant_sb','style'=>'width:500px')); 
							echo $this->Form->input('doctor_id_txt', array('style'=>'width:460px; float:left;','id'=>'doctor_id_txt','value'=>$registrar[$this->data['Diagnosis']['consultant_sb']]));
							//actual field to enter in db
							echo $this->Form->hidden('consultant_sb', array('type'=>'text','id'=>'consultant_sb'));
							?>
							</td>
							<td><?php echo("Date/Time :")?></td>
							<td valign="top"><?php echo $this->Form->input('consultant_on', array('type'=>'text','id' => 'consultant_on','class'=>'textBoxExpnd','style'=>'width:120px')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">&nbsp;</td>
				<td width="80%" valign="top" align="left" style="padding: 8px;"><?php echo $this->Form->textarea('consultant_note', array('class' => 'textBoxExpnd','id' => 'consultant_note','style'=>'width:98%','row'=>3)); ?>
				</td>
			</tr>
		</table>
	</div> -->
	<!-- EOF consultants opinion -->
	<!-- BOF plan care -->

	<!--	<h3>
		<a href="#"> <?php echo $planCareText ; ?>
		</a>
	</h3>
	<div class="section" id="care_plan">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator' style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-care_plan"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->input('plancare_desc', array('class' => 'textBoxExpnd','id' => 'plancare_desc','rows'=>15,'style'=>'width:98%')); ?><br/>
							<a href="javascript:void(0);" onclick="callDragon('plancare')" style="text-align:left;"><font color="white">Use speech recognition</font> </a>
							</td>
							
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div> -->
	<!-- EOD plan care -->
	<!-- removed by gaurav -->
	<!-- BOF Investigation -->
	<!-- <h3 style="display: &amp;amp;" id="invi">
		<a href="#">Investigationzzz</a>
	</h3>
	<div class="section" id="investigation">
		<div id="templateArea-investigation"></div>
	</div> -->
	<!-- EOF gaurav -->
	<!--  <h3 style="display: &amp;amp;">
		<a href="#">Investigation Dashboard</a>
	</h3>
	<div class="section" id="investigationDashboard">
		<div id="templateArea-investigationDashboard"></div>
	</div>-->

	<!--	<h3 style="display: &amp;amp;">
		<a href="#">Manual Lab Order</a>
	</h3>
	<div class="section" id="ManualLAb">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td>Number of written Laboratory orders:</td>
				<td><?php echo $this->Form->input('LaboratoryManualEntry.lab_count', array('type'=>text,'div'=>false,'label'=>false,'id' => 'lab_order','class' => 'validate[required,custom[name],custom[onlyNumber]] textBoxExpnd' )); ?>
				</td>
				<td>Date of order:</td>
				<td><?php echo $this->Form->input('LaboratoryManualEntry.date', array('class' => 'textBoxExpnd orderlabdate','style'=>'width:120px','type'=>'text','label'=>false )); ?>
				</td>
			</tr>
		</table>
		<!--	<div id="templateArea-ManualLAb"></div> ->
	</div> -->

	<!--	<h3 style="display: &amp;amp;">
		<a href="#">Manual Radiology Order</a>
	</h3>
	<div class="section" id="ManualLAb">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td>Number of written Radiology orders:</td>
				<td><?php echo $this->Form->input('RadiologyManualEntry.rad_count', array('type'=>text,'div'=>false,'label'=>false,'class' => 'lab_order','class' => 'validate[required,custom[name],custom[onlyNumber]] textBoxExpnd'  )); ?>
				</td>
				<td>Date of order:</td>
				<td><?php echo $this->Form->input('RadiologyManualEntry.date', array('class' => 'textBoxExpnd orderlabdate','style'=>'width:120px','type'=>'text','label'=>false )); ?>
				</td>
			</tr>
		</table>
		<!--	<div id="templateArea-ManualLAb"></div> ->
	</div> -->


	<?php //if($patient['Patient']['admission_type'] == "OPD"){?>
	<h3 style="display: &amp;amp;">
		<a href="#">Vitals</a>
	</h3>
	<div id="vitals" style="display:<?php echo $display ;?>" class="section dragbox-content">
		<div class="header" id="header" style="color: #fff;">
			<div class="design" id="design">
				<div style="padding-left: 20px; width: 98%; margin-bottom: 10px;"
					class="tdLabel">
					<b>Temperature:</b>
				</div>
				<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px">
					<?php echo $this->Form->hidden('BmiResult.id',array('value'=>$result1['BmiResult']['id']));?>
					<table width="100%">
						<tr>
							<td class="tdLabel"><?php echo __('Enter the degree');
							echo $this->Form->input('BmiResult.temperature',array('type'=>'text','id'=>"temperature",'class' => 'validate[optional,custom[onlyNumber]]','value'=>$result1['BmiResult'][temperature],'size'=>"12px",'label'=>false,'autocomplete'=>"off"));
							if(empty($result1['BmiResult']['myoption'])){
								echo $this->Form->radio('BmiResult.myoption',array('F'=>'Fahrenheit','C'=>'Celsius'),array('default' =>'F','class'=>"degree",'id'=>'type_tempreture','legend'=>false,'label'=>false));
							}else{
								echo $this->Form->radio('BmiResult.myoption',array('F'=>'Fahrenheit','C'=>'Celsius'),array('value'=>$result1['BmiResult']['myoption'],'class'=>"degree",'id'=>'type_tempreture','legend'=>false,'label'=>false));
							}
							?>&nbsp; &nbsp;<?php echo $this->Form->input('BmiResult.equal_value',array('type'=>'text','id'=>"equal_value",'size'=>"12",'readonly'=>'readonly','value'=>$result1['BmiResult'][equal_value], 'div'=>false,'autocomplete'=>"off"));?>
							</td>
							<td colspan="5" class="tdLabel"><?php echo $this->Form->radio('BmiResult.temp_source', 
									array('axillary'=>'Axillary','central'=>'Central','oral'=>'Oral','rectal'=>'Rectal','tympanic'=>'Tympanic','temporal'=>'Temporal'),
									array('value'=>$result1['BmiResult'][temp_source],'legend'=>false,'label'=>false));?>
							</td>
					
					</table>
				</div>
				<div class="section_1"
					style="float: left; width: 100%; border-bottom: 1px solid #4C5E64;">
					<div style="padding-left: 20px; float: left; width: 528px;"
						class="tdLabel">
						<h2 style="color: #000; font-size: 13px;">Heart Rate:</h2>
						<table>
							<tr>
								<br />
								<td><?php echo $this->Form->input('BmiBpResult.pulse_text', 
									array('name'=>'data[BmiBpResult][0][pulse_text]','type'=>'text','class' => 'validate[optional,custom[onlyNumberSp]]','label'=>false,'div'=>false,'id'=>'pulse_supin','value'=>$result1['BmiBpResult'][0][pulse_text],'size'=>"12",'autocomplete'=>"off"));?>
								</td>
								<td><?php $supin_options = array('Radial'=>'Radial','Bigeminy'=>'Bigeminy','Femoral'=>'Femoral','Frequent_premature_beat'=>'Frequent premature beat','Irregular'=>'Irregular','Irregularly_irregular'=>'Irregularly irregular','Occassional_premature_beat'=>'Occassional premature beat','Oral'=>'Oral','Pedal'=>'Pedal','Regular'=>'Regular','Trigeminy'=>'Trigeminy');
							echo $this->Form->input('BmiBpResult.pulse_volume', array('name'=>'data[BmiBpResult][0][pulse_volume]','options'=>$supin_options ,'class' =>'textBoxExpnd','id'=>"pulse_supin_volume",'value'=>$result1['BmiBpResult'][0][pulse_volume])); ?>
								</td>
							</tr>

							<tr>
								<td><?php echo $this->Form->input('BmiBpResult.pulse_text', array('name'=>'data[BmiBpResult][1][pulse_text]','type'=>'text','class' => 'validate[optional,custom[onlyNumberSp]]','label'=>false,'div'=>false,'id'=>'pulse_sitting','value'=>$result1['BmiBpResult'][1][pulse_text],'size'=>"12",'autocomplete'=>"off"));?>
								</td>
								<td><?php $sitting_options = array('Radial'=>'Radial','Bigeminy'=>'Bigeminy','Femoral'=>'Femoral','Frequent_premature_beat'=>'Frequent premature beat','Irregular'=>'Irregular','Irregularly_irregular'=>'Irregularly irregular','Occassional_premature_beat'=>'Occassional premature beat','Oral'=>'Oral','Pedal'=>'Pedal','Regular'=>'Regular','Trigeminy'=>'Trigeminy');
							echo $this->Form->input('BmiBpResult.pulse_volume', array('name'=>'data[BmiBpResult][1][pulse_volume]','options'=>$sitting_options ,'class' =>'textBoxExpnd','id'=>"pulse_sitting_volume",'value'=>$result1['BmiBpResult'][1][pulse_volume])); ?>
								</td>
							</tr>

							<tr>
								<td><?php echo $this->Form->input('BmiBpResult.pulse_text',array('name'=>'data[BmiBpResult][2][pulse_text]','type'=>'text','class' => 'validate[optional,custom[onlyNumberSp]]','id'=>"pulse_standing",'value'=>$result1['BmiBpResult'][2][pulse_text], 'label'=>false,'div'=>false,'size'=>"12",'autocomplete'=>"off"));?>
								</td>
								<td><?php $standing_options = array('Radial'=>'Radial','Bigeminy'=>'Bigeminy','Femoral'=>'Femoral','Frequent_premature_beat'=>'Frequent premature beat','Irregular'=>'Irregular','Irregularly_irregular'=>'Irregularly irregular','Occassional_premature_beat'=>'Occassional premature beat','Oral'=>'Oral','Pedal'=>'Pedal','Regular'=>'Regular','Trigeminy'=>'Trigeminy');
							echo $this->Form->input('BmiBpResult.pulse_volume', array('name'=>'data[BmiBpResult][2][pulse_volume]','options'=>$standing_options ,'class' =>'textBoxExpnd','id'=>"pulse_standing_volume",'value'=>$result1['BmiBpResult'][2][pulse_volume])); ?>
								</td>
							</tr>
						</table>
					</div>

					<div class="blood_presure tdLabel">
						<h2 style="color: #000; font-size: 13px;">Blood Pressure:</h2>
						<table>
							<tr>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][systolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_11",'value'=>$result1['BmiBpResult'][0][systolic],'style'=>"width:40px",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
								</td>&nbsp;
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_12",'value'=>$result1['BmiBpResult'][0][diastolic],'style'=>"width:40px;",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
								</td>&nbsp;
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic1]','options'=>Configure :: read('position'),'value'=>$result1['BmiBpResult'][0][diastolic1], 'id'=>'position','label'=>false,));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic2]','empty'=>'Please select','options'=>Configure :: read('site1'),'value'=>$result1['BmiBpResult'][0][diastolic2],'id' => 'site1','label'=>false,));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic3]','options'=>Configure :: read('site2'),'value'=>$result1['BmiBpResult'][0][diastolic3],'id' => 'site2','label'=>false,));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic4]','options'=>Configure :: read('site3'),'style'=>"width:130px;",'value'=>$result1['BmiBpResult'][0][diastolic4],'id' => 'site2','label'=>false,));?>
								</td>
							</tr>

							<tr>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][systolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_21",'value'=>$result1['BmiBpResult'][1][systolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_22",'value'=>$result1['BmiBpResult'][1][diastolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic1]','options'=>Configure :: read('position'),'value'=>$result1['BmiBpResult'][1][diastolic1],'id'=>'position','selected'=>$strength,'label'=>false,));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic2]','empty'=>'Please select','options'=>Configure :: read('site1'),'value'=>$result1['BmiBpResult'][1][diastolic2], 'id'=>'site1','label'=>false,));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic3]','options'=>Configure :: read('site2'),'value'=>$result1['BmiBpResult'][1][diastolic3],'id'=>'site2','label'=>false,));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic4]','options'=>Configure :: read('site3'), 'style'=>"width:130px;",'value'=>$result1['BmiBpResult'][1][diastolic4],'id' => 'site2','label'=>false,));?>
								</td>
							</tr>


							<tr>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][systolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_31",'value'=>$result1['BmiBpResult'][2][systolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_32",'value'=>$result1['BmiBpResult'][2][diastolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic1]','options'=>Configure :: read('position'),'value'=>$result1['BmiBpResult'][2]['diastolic1'],'id'=>'position','selected'=>$strength,'label'=>false,));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic2]','empty'=>'Please select','options'=>Configure :: read('site1'),'value'=>$result1['BmiBpResult'][2][diastolic2], 'id'=>'site1','label'=>false,));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic3]','options'=>Configure :: read('site2'),'value'=>$result1['BmiBpResult'][2][diastolic3], 'id'=>'site2','label'=>false,));?>
								</td>
								<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic4]','options'=>Configure :: read('site3'), 'style'=>"width:130px;",'value'=>$result1['BmiBpResult'][2][diastolic4],'id' => 'site2','label'=>false,));?>
								</td>
							</tr>


						</table>
					</div>
				</div>


				<!--<div style="padding-left: 20px; border-bottom: 1px solid #4C5E64;" class="tdLabel">
					<br /> <b>Blood Pressure:</b><br />
					<table>
						<tr>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][systolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_11",'value'=>$result1['BmiBpResult'][0][systolic],'style'=>"width:40px",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
							</td>&nbsp;
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_12",'value'=>$result1['BmiBpResult'][0][diastolic],'style'=>"width:40px;",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
							</td>&nbsp;
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic1]','options'=>Configure :: read('position'),'value'=>$result1['BmiBpResult'][0][diastolic1], 'id'=>'position','label'=>false,));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic2]','empty'=>'Please select','options'=>Configure :: read('site1'),'value'=>$result1['BmiBpResult'][0][diastolic2],'id' => 'site1','label'=>false,));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic3]','options'=>Configure :: read('site2'),'value'=>$result1['BmiBpResult'][0][diastolic3],'id' => 'site2','label'=>false,));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic4]','options'=>Configure :: read('site3'),'style'=>"width:130px;",'value'=>$result1['BmiBpResult'][0][diastolic4],'id' => 'site2','label'=>false,));?>
							</td>
						</tr>

						<tr>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][systolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_21",'value'=>$result1['BmiBpResult'][1][systolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_22",'value'=>$result1['BmiBpResult'][1][diastolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic1]','options'=>Configure :: read('position'),'value'=>$result1['BmiBpResult'][1][diastolic1],'id'=>'position','selected'=>$strength,'label'=>false,));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic2]','empty'=>'Please select','options'=>Configure :: read('site1'),'value'=>$result1['BmiBpResult'][1][diastolic2], 'id'=>'site1','label'=>false,));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic3]','options'=>Configure :: read('site2'),'value'=>$result1['BmiBpResult'][1][diastolic3],'id'=>'site2','label'=>false,));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic4]','options'=>Configure :: read('site3'), 'style'=>"width:130px;",'value'=>$result1['BmiBpResult'][1][diastolic4],'id' => 'site2','label'=>false,));?>
							</td>
						</tr>


						<tr>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][systolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_31",'value'=>$result1['BmiBpResult'][2][systolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','id'=>"bp_32",'value'=>$result1['BmiBpResult'][2][diastolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic1]','options'=>Configure :: read('position'),'value'=>$result1['BmiBpResult'][2]['diastolic1'],'id'=>'position','selected'=>$strength,'label'=>false,));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic2]','empty'=>'Please select','options'=>Configure :: read('site1'),'value'=>$result1['BmiBpResult'][2][diastolic2], 'id'=>'site1','label'=>false,));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic3]','options'=>Configure :: read('site2'),'value'=>$result1['BmiBpResult'][2][diastolic3], 'id'=>'site2','label'=>false,));?>
							</td>
							<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic4]','options'=>Configure :: read('site3'), 'style'=>"width:130px;",'value'=>$result1['BmiBpResult'][2][diastolic4],'id' => 'site2','label'=>false,));?>
							</td>
						</tr>


					</table>
					<br />
				</div>-->
				<!-- bof bmi code -->
				<div class="section_2"
					style="width: 100%; float: left; border-bottom: 1px solid #4C5E64;">
					<div style="width: 610px; padding-left: 20px; float: left;"
						class="tdLabel">
						<h2 style="font-size: 13px;">Weight:</h2>
						<?php echo $this->Form->input('BmiResult.weight',array('type'=>'text','size'=>"9",'id'=>"weights",'value'=>$result1['BmiResult'][weight], 'label'=>false,'div'=>false,'class'=>"bmi validate[optional,custom[onlyNumber]]",'autocomplete'=>"off"));
						if(empty($result1['BmiResult'][weight_volume])){
							echo $this->Form->radio('BmiResult.weight_volume',array('Lbs'=>'Lbs','Kg'=>'Kg'),array('default' =>'Lbs','class'=>"Weight bmi",'id'=>'type_weight','legend'=>false,'label'=>false ));
						}else{
							echo $this->Form->radio('BmiResult.weight_volume',array('Lbs'=>'Lbs','Kg'=>'Kg'),array('value'=>$result1['BmiResult'][weight_volume],'class'=>"Weight bmi",'id'=>'type_weight','legend'=>false,'label'=>false ));
						}?>
						&nbsp; &nbsp;
						<?php echo $this->Form->input('BmiResult.weight_result',array('type'=>'text','readonly'=>'readonly','id'=>"weight_result",'value'=>$result1['BmiResult'][weight_result],'size'=>"12",'label'=>false,'class'=>"bmi",'autocomplete'=>"off"));?>

						<br /> <br /> <b>Height:</b>
						<?php echo $this->Form->input('BmiResult.height',array('type'=>'text','id'=>"height1",'size'=>"9",'value'=>$result1['BmiResult'][height], 'autocomplete'=>"off",'label'=>false,'div'=>false,'class'=>"bmi validate[optional,custom[onlyNumber]]"));
						if(empty($result1['BmiResult'][height_volume])){
							echo $this->Form->radio('BmiResult.height_volume',array('Inches'=>'Inches','Cm'=>'Cm','Feet'=>'Feet'),array('default'=>'Feet',
								'class'=>"Height bmi",'id'=>'type_height','legend'=>false,'label'=>false,'name'=>'BmiResult[height_volume]'));
						}else{
							echo $this->Form->radio('BmiResult.height_volume',array('Inches'=>'Inches','Cm'=>'Cm','Feet'=>'Feet'),array('value'=>$result1['BmiResult'][height_volume],
								'class'=>"Height bmi",'id'=>'type_height','legend'=>false,'label'=>false,'name'=>'BmiResult[height_volume]'));
						}?>

						&nbsp; &nbsp;
						<?php if($result1['BmiResult']['height_volume'] == 'Feet' || $result1['BmiResult']['height_volume']==''){
							$feetResultDisplay = "" ;
						}else{
							$feetResultDisplay = "display:none" ;
						}
						echo "<span id='feet_inch'  style = ".$feetResultDisplay.">";
						echo $this->Form->input('BmiResult.feet_result',array('type'=>'text','id'=>"feet_result",
								'value'=>$result1['BmiResult'][feet_result],'size'=>"12",'label'=>false,
								'class'=>"bmi validate[optional,custom[onlyNumber]]",'autocomplete'=>"off"));?>
						<?php echo __('inches');?>
						<?php  echo"</span>"?>
						&nbsp;&nbsp;
						<?php
						echo $this->Form->input('BmiResult.height_result',array('type'=>'text','readonly'=>'readonly','id'=>'height_result','value'=>$result1['BmiResult'][height_result],'size'=>"12",'label'=>false,'class'=>"bmi",'autocomplete'=>"off"));?>
						<br /> <br />


						<?php echo __('Your BMI:')?>
						<?php echo $this->Form->input('BmiResult.bmi',array('type'=>"text",'readonly'=>'readonly','id'=>'bmis', 'value'=>$result1['BmiResult'][bmi],'size'=>"10", 'label'=>false,'div'=>false,'class'=>"bmi"));?>

						<?php echo __('Kg/m.sq.');?>
						&nbsp;&nbsp;
						<?php //echo $this->Form->button('Show BMI',array('type'=>"button",'value'=>"Show BMI",'class'=>"blueBtn",'id'=>'showBmi','label'=>false,'div'=>false ));?>
						<?php echo $this->Html->link('Reset','#',array(  'class'=>"blueBtn",'id'=>'reset-bmi'  ));?>

						<br /> <br /> <span id="bmiStatus"></span>
						<?php //debug($patient);//----Pooja
						if($patient['Patient']['age'] >=0 && $patient['Patient']['age']<=3)
						{ ?>

						<span><?php 
						if(strToLower($patient['Person']['sex'])=='female')
						{
							echo $this->Html->link(__('Length for Age'),array('controller'=>'Persons','action'=>'bmi_infants_lenghtforage_female',$patient['Person']['id']),
	   																    array('escape' => false,'class'=>'blueBtn'));
						}
						else{
									echo $this->Html->link(__('Length for Age Chart'),array('controller'=>'Persons','action'=>'bmi_infants_lengthforage_male',$patient['Person']['id']),
													array('escape' => false,'class'=>'blueBtn'));
	   							}
	   							?> </span> <span><?php
	   							if(strToLower($patient['Person']['sex'])=='female')
	   							{
	   								echo $this->Html->link(__('Weight for Age'),array('controller'=>'Persons','action'=>'bmi_infants_weightforage',$patient['Person']['id']),
							   																    array('escape' => false,'class'=>'blueBtn'));
	   							}
	   							else {
												echo $this->Html->link(__('Weight for Age'),array('controller'=>'Persons','action'=>'bmi_infants_weightforage_male',$patient['Person']['id']),
							   							array('escape' => false,'class'=>'blueBtn'));
	   										  }
	   										  ?> </span> <span><?php
	   										  if(strToLower($patient['Person']['sex'])=='female')
	   										  {
	   										  	echo $this->Html->link(__('Weight for Length'),array('controller'=>'Persons','action'=>'bmi_infants_weightforlength_female',$patient['Person']['id']),
	   																    array('escape' => false,'class'=>'blueBtn'));
	   										  }
	   										  else {
											echo $this->Html->link(__('Weight for Length'),array('controller'=>'Persons','action'=>'bmi_infants_weightforlength_male',$patient['Person']['id']),
	   										array('escape' => false,'class'=>'blueBtn'));
	   																}
	   																?> </span>

						<?php	}
						elseif($patient['Patient']['age'] >=2 && $patient['Patient']['age']<=20)
							{ ?>
						<span><?php 
						if(strToLower($patient['Person']['sex'])=='female')
						{
							echo $this->Html->link(__('BMI Chart'),array('controller'=>'Persons','action'=>'bmi_chart_female',$patient['Person']['id']),
											    array('escape' => false,'class'=>'blueBtn'));
						}
						else{
									echo $this->Html->link(__('Bmi chart'),array('controller'=>'Persons','action'=>'bmi_chart_male',$patient['Person']['id']),
									array('escape' => false,'class'=>'blueBtn'));
								}
								?> </span> <span><?php  if(strToLower($patient['Person']['sex'])=='female')
								{
									echo $this->Html->link(__('Stature for Age'),array('controller'=>'Persons','action'=>'bmi_statureforage_female',$patient['Person']['id']),
											    array('escape' => false,'class'=>'blueBtn'));
								}
								else{
									echo $this->Html->link(__('Stature for Age'),array('controller'=>'Persons','action'=>'bmi_statureforage_male',$patient['Person']['id']),
									array('escape' => false,'class'=>'blueBtn'));
								}
								?> </span> <span><?php
								if(strToLower($patient['Person']['sex'])=='female')
								{
									echo $this->Html->link(__('Weight for Age'),array('controller'=>'Persons','action'=>'bmi_weightforage_female',$patient['Person']['id']),
												    array('escape' => false,'class'=>'blueBtn'));
								}
								else {
										echo $this->Html->link(__('Weight for Age'),array('controller'=>'Persons','action'=>'bmi_weightforage_male',$patient['Person']['id']),
											array('escape' => false,'class'=>'blueBtn'));
								}
								?> </span>

						<?php }?>
						<br /> <br />

						<!-- eof bmi code -->
						<!--bof height code -->
					</div>

					<div class="comment_comment" style="float: left;">
						<table valign="top">
							<tr>
								<td class="tdLabel"><b> <?php echo __('Comment : ',true); ?>
								</b></td>
								<td><?php  echo $this->Form->input('BmiResult.comment',array('type'=>'text','size'=>"36px",'value'=>$result1['BmiResult'][comment],'autocomplete'=>"off"));?>
								</td>
							</tr>

							<br />
							<tr>
								<td class="tdLabel"><b><?php echo __('Chief Complaint :',true);  ?>
								</b></td>
								<td><?php  echo $this->Form->input('BmiResult.chief_complaint',array('type'=>'textarea','value'=>$result1['BmiResult'][chief_complaint], 'size'=>"41px",'rows'=>'5','style'=>"padding-left:10px; width:271px; margin-top:10px;"));?>
								</td>
							</tr>
						</table>

					</div>
				</div>
				<div>
					<div class="design1" id="design1"
						style="width: 100%; float: left; border-bottom: 1px solid #4C5E64;">
						<div style="float: left; padding-left: 20px; width: 350px;"
							class="tdLabel">
							<br /> <b>Respiration:</b>

							<?php echo $this->Form->input('BmiResult.respiration',array('type'=>'text','size'=>"10",'value'=>$result1['BmiResult'][respiration],'class' => 'validate[optional,custom[onlyNumber]]', 'label'=>false,'div'=>false,'id'=>"respiration",'size'=>"12",'autocomplete'=>"off"));?>
							<?php echo $this->Form->input('BmiResult.respiration_volume', array('options'=>array("1"=>"Unlabored","2"=>"Labored"), 'value'=>$result1['BmiResult'][respiration_volume],'label'=>false,'div'=>false),(array('style'=>"width:150px;")));?>
							<br /> <br />
						</div>
						<div style="float: left; padding-left: 20px; width: 334px;"
							class="tdLabel">
							<br /> <b>SPO</b><sub>2</sub>:

							<?php echo $this->Form->input('BmiResult.spo',array('type'=>'text','size'=>"10",'value'=>$result1['BmiResult'][spo],'class' => '', 'label'=>false,'div'=>false,'id'=>"spo",'size'=>"12",'autocomplete'=>"off"));?>
							<?php $optionSPO=array('1.0 L/Min Oxygen'=>'1.0 L/Min Oxygen',
									'2.0 L/Min Oxygen'=>'2.0 L/Min Oxygen',
									'3.0 L/Min Oxygen'=>'3.0 L/Min Oxygen',
									'4.0 L/Min Oxygen'=>'4.0 L/Min Oxygen',
									'5.0 L/Min Oxygen'=>'5.0 L/Min Oxygen',
									'6.0 L/Min Oxygen'=>'6.0 L/Min Oxygen',
									'7.0 L/Min Oxygen'=>'7.0 L/Min Oxygen',
									'8.0 L/Min Oxygen'=>'8.0 L/Min Oxygen',
									'9.0 L/Min Oxygen'=>'9.0 L/Min Oxygen',
									'10.0 L/Min Oxygen'=>'10.0 L/Min Oxygen',
									'11.0 L/Min Oxygen'=>'11.0 L/Min Oxygen',
									'12.0 L/Min Oxygen'=>'12.0 L/Min Oxygen',
									'13.0 L/Min Oxygen'=>'13.0 L/Min Oxygen',
									'14.0 L/Min Oxygen'=>'14.0 L/Min Oxygen',
									'15.0 L/Min Oxygen'=>'15.0 L/Min Oxygen',
						)?>

							<?php echo $this->Form->input('BmiResult.sposelect',array('empty'=>__('Please Select'),'options'=>$optionSPO,'label'=>false ,'id' => 'spo2','value'=>$result1['BmiResult']['sposelect'])); ?>
							<br /> <br />
						</div>
						<div style="float: left; padding-left: 20px" class="tdLabel">
							<br /> <b>Pain</b>:
							<?php $optPain=array('Not recorded'=>'Not recorded',
									'0-No Pain'=>'0-No Pain',
									'1'=>'1',
									'2'=>'2',
									'3'=>'3',
									'4'=>'4',
									'5'=>'5',
									'6'=>'6',
									'7'=>'7',
									'8'=>'8',
									'9'=>'9',
						'10'=>'10',)?>
							<?php echo $this->Form->input('BmiResult.pain',array('options'=>$optPain,'size'=>"10",'value'=>$result1['BmiResult']['pain'],'class' => '', 'label'=>false,'id'=>"spo",'size'=>"12",'autocomplete'=>"off"));?>

							<br /> <br />

						</div>
					</div>
					<div class="design1" id="design1"
						style="width: 100%; float: left; border-bottom: 1px solid #4C5E64;">
						<div style="float: left; padding-left: 20px" class="tdLabel">
							<br /> <b>Location</b>:

							<?php echo $this->Form->input('BmiResult.location',array('type'=>'text','size'=>"10",'value'=>$result1['BmiResult']['location'],'class' => '', 'label'=>false,'div'=>false,'id'=>"spo",'size'=>"12",'autocomplete'=>"off"));?>

							<br /> <br />
						</div>
						<div style="float: left; padding-left: 20px" class="tdLabel">
							<br /> <b>Duration</b>:

							<?php echo $this->Form->input('BmiResult.duration',array('type'=>'text','size'=>"10",'value'=>$result1['BmiResult']['duration'],'class' => '', 'label'=>false,'div'=>false,'id'=>"spo",'size'=>"12",'autocomplete'=>"off"));?>

							<br /> <br />
						</div>
						<div style="float: left; padding-left: 20px" class="tdLabel">
							<br /> <b>Frequency</b>:

							<?php echo $this->Form->input('BmiResult.frequency',array('type'=>'text','size'=>"10",'value'=>$result1['BmiResult']['frequency'],'class' => '', 'label'=>false,'div'=>false,'id'=>"spo",'size'=>"12",'autocomplete'=>"off"));?>

							<br /> <br />
						</div>


						<div style="float: left; padding-left: 20px" class="tdLabel">
							<br />
							<div class="date_class">
								<b>Date:</b>
							</div>
							<?php $d= date('m/d/y H:i:s');?>
							<?php $bmiDate = $this->DateFormat->formatDate2Local($result1['BmiResult']['date'],Configure::read('date_format'),true); ?>
							<?php 
							if($result1['BmiResult']['date']==""){
						?>
							<?php echo $this->Form->input('date', array('type'=>'text','id' =>'date_vital','readonly'=>'readonly','class'=>'textBoxExpnd','value'=>$d,'style'=>'width:150px')); ?>
							<?php 
					    }else{
					    ?>
							<?php echo $this->Form->input('date', array('type'=>'text','id' =>'date_vital','readonly'=>'readonly','class'=>'textBoxExpnd','value'=>$bmiDate,'style'=>'width:150px')); ?>
							<?php }?>
							<br /> <br /> <br />
						</div>
					</div>

					<?php if($this->Session->read('department')=='Pediatric'){?>
					<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px"
						class="tdLabel">
						<br /> <b>Head Circumference:</b>&nbsp;&nbsp;
						<?php echo $this->Form->input('BmiResult.head_circumference',array('type'=>'text','id'=>"head_circumference",'value'=>$result1['BmiResult'][head_circumference],'size'=>"12",'label'=>false,'class'=>"validate[optional,custom[onlyNumber]]",'autocomplete'=>"off"));
						if(empty($result1['BmiResult'][head_circumference_volume])){
								echo $this->Form->radio('BmiResult.head_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('default' =>'Inches','class'=>"cercumference",'id'=>'type_head','legend'=>false,'label'=>false));
							}else{
								echo $this->Form->radio('BmiResult.head_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('value'=>$result1['BmiResult'][head_circumference_volume],'class'=>"cercumference",'id'=>'type_head','legend'=>false,'label'=>false));
							}?>
						&nbsp; &nbsp;
						<?php echo $this->Form->input('BmiResult.head_result',array('type'=>'text','readonly'=>'readonly','id'=>"head_result",'value'=>$result1['BmiResult'][head_result],'size'=>"12",'label'=>false,'autocomplete'=>"off"));?>
						<br /> <br />

						<?php  if($patient['Patient']['age'] >=0 && $patient['Patient']['age']<=3) { ?>
						<span><?php 
						if(strToLower($patient['Person']['sex'])=='female')
						{
							echo $this->Html->link(__('Head Circumference Chart'),array('controller'=>'Persons',"action"=>"bmi_infants_headcircumference_female",$id),
		   										array('escape' => false,'class'=>'blueBtn'));
						}
						else{
		   									echo $this->Html->link(__('Head Circumference Chart'),array('controller'=>'Persons',"action"=>"bmi_infants_headcircumference_male",$id),
		   											array('escape' => false,'class'=>'blueBtn'));
		   								}
		   								?> </span>
						<?php }?>
					</div>
					<?php }?>
					<!-- <div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel">
						<br /> <b> Smoking:</b>
						<?php //echo $this->Form->input('BmiResult.smoking',array('type'=>'text','readonly'=>'readonly','value'=>$smokingOptions[$this->data['PatientSmoking']['current_smoking_fre']],'size'=>"25px",'label'=>false,'autocomplete'=>"off"));?>
						&nbsp; &nbsp;
						<?php
						if($result1['BmiResult']['smoking_councelling'] == 1){
							echo $this->Form->checkbox('BmiResult.smoking_councelling', array('checked' => 'checked'));
						}else{
							echo $this->Form->checkbox('BmiResult.smoking_councelling');
						}
	 					echo ('smoking cessation counseling was given.'); ?>
						<br /> <br />
					</div>  -->

					<!-- <div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel">
						<br /> <b>Waist Circumference:</b>

						<?php echo $this->Form->input('BmiResult.waist_circumference',array('type'=>'text','id'=>"waist_circumference",'value'=>$result1['BmiResult'][waist_circumference],'size'=>"12px",'label'=>false,'class'=>"validate[optional,custom[onlyNumber]]",'autocomplete'=>"off"));
						if(empty($result1['BmiResult'][waist_circumference_volume])){
							echo $this->Form->radio('BmiResult.waist_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('default' =>'Inches','class'=>"waist",'id'=>'type_waist','legend'=>false,'label'=>false));
						}else{
							echo $this->Form->radio('BmiResult.waist_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('value'=>$result1['BmiResult'][waist_circumference_volume],'class'=>"waist",'id'=>'type_waist','legend'=>false,'label'=>false,'autocomplete'=>"off"));
						}?>
						&nbsp; &nbsp;
						<?php echo $this->Form->input('BmiResult.waist_result',array('type'=>'text','readonly'=>'readonly','id'=>"waist_result",'value'=>$result1['BmiResult'][waist_result],'size'=>"12",'label'=>false));?>
						<br /> <br />
					</div> -->

				</div>
			</div>
		</div>
	</div>
	<?php //} ?>

</div>
</div>
<!-- EOF accordion -->
<div class="btns" style="float: left;">
	<?php  $cancelBtnUrl= array('controller'=>'Appointments','action'=>'appointments_management');
	echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('div'=>false,'class'=>'grayBtn')); ?>
</div>
<div class="btns">
	<?php 
 
	echo $this->Form->input('appointmentId',array('type'=>'hidden','value'=>$this->params->query['apptId']));
	echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false,'id'=>'submit_diagno')); ?>
</div>
<?php echo $this->Form->end();

?>
<!-- Right Part Template ends here -->

<script>
var sample;
var global_note_id = "<?php echo $global_note_id;?>";	
var diagnosisSelectedArray = new Array();
function addDiagnosisDetails(){
	var selectedPatientId = parent.$('#Patientsid').val();
	
	if(selectedPatientId != ''){
		
		var currEle = diagnosisSelectedArray.pop();
		if((currEle !='') && (currEle !== undefined)){
			parent.openbox(currEle,selectedPatientId,parent.global_note_id);
		}
	}
	
}

function openbox(icd,note_id,linkId) { 
	var sample;
	 
	icd = icd.split("::");
	var patient_id = '<?php echo $patient_id?>';
	if (patient_id == '') {
		alert("Please select patient");
		return false;
	}
	
	$.fancybox({
				'width' : '40%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':false,
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
						 + '/' + patient_id + '/' + icd , 
				
			}); 

}

function problem(patient_id) {  
	if (patient_id == '') {
		alert("Something went wrong");
		return false;
	} 
	$("#Patientsid").val(patient_id);
	$.fancybox({ 
				'width' : '70%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe', 
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>" + '/' + patient_id,
	});

}

$(document).ready(function(){  	

	$("#smoking_fre").change(function(){ 
		 $("#smoking_fre_id").val($(this).val());
	});
		
	$(document).ajaxStart(function () {
	    $("#temp-busy-indicator1").show();
	});

	$(document).ajaxComplete(function () {
	    $("#temp-busy-indicator1").hide();
	});	
	$( "#accordionCust" ).accordion({
		active : false,
		collapsible: true,
		autoHeight: false,
		clearStyle :true,				
		navigation: true,
		change:function(event,ui){				 
				//BOF template call
			 	var currentEleID = $(ui.newContent).attr("id") ; 	
			 	var replacedID  = "templateArea-"+currentEleID; 	
			  
			 	if(currentEleID=='investigation'){
				 	//redirect to lab request page
				 	//window.location.href = "<?php echo $this->Html->url(array('controller'=>'laboratories','action'=>'lab_order',$patient['Patient']['id'],'?'=>array('return'=>'assessment')));?>";
			 	}	 
			 	if(currentEleID == 'examine' || currentEleID == 'diagnosis' || currentEleID == 'care_plan' || currentEleID== 'complaints' || currentEleID=='lab-reports' || currentEleID=='surgery' || currentEleID=='investigation' || currentEleID=='investigationDashboard' || currentEleID=='ManualLAb'){
					
			 		$("#"+replacedID).html($('#temp-busy-indicator').html());					 		 
				 	if(currentEleID == 'examine'){
				 		$("#templateArea-diagnosis").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-complaints").html('');
						$("#templateArea-surgery").html('');
						$("#templateArea-care_plan").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
					 	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'examine',"admin" => false)); ?>"; 
				 	}else if(currentEleID == 'diagnosis'){
				 		$("#templateArea-examine").html('');
						$("#templateArea-surgery").html('');
						$("#templateArea-care_plan").html(''); 
						$("#templateArea-lab-reports").html('');
						$("#templateArea-complaints").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'diagnosis',"admin" => false)); ?>";
					}else if(currentEleID == 'care_plan'){
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-complaints").html('');
						$("#templateArea-surgery").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'care_plan',"admin" => false)); ?>";
					}else if(currentEleID == 'complaints'){
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-lab-reports").html('');	
						$("#templateArea-care_plan").html(''); 
						$("#templateArea-surgery").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'complaints',"admin" => false)); ?>";
					}else if(currentEleID == 'lab-reports'){
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-complaints").html(''); 								 
						$("#templateArea-surgery").html('');
						$("#templateArea-care_plan").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'lab-reports',"admin" => false)); ?>";
					}else if(currentEleID == 'surgery'){
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-complaints").html(''); 								 
						$("#templateArea-care_plan").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'surgery',"admin" => false)); ?>";
					}else if(currentEleID == 'investigation'){
						
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-complaints").html(''); 								 
						$("#templateArea-care_plan").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-surgery").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'diagnoses', "action" => "investigation",$patient['Patient']['id'], 'source'=>'fromAssessment','type'=>$patient['Patient']['admission_type']) ,array('escape'=>false)); ?>";
					}else if(currentEleID == 'investigationDashboard'){
						
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-complaints").html(''); 								 
						$("#templateArea-care_plan").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-surgery").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'diagnoses', "action" => "investigationdashboard",$patient['Patient']['id'],"admin" => false)); ?>";
					}
						 								 
					 		$.ajax({  
					 			  type: "POST",						 		  	  	    		
								  url: ajaxUrl,
								  data: "updateID="+replacedID,
								  context: document.body,								   					  		  
								  success: function(data){	
									 
								   	 	$("#"+replacedID).html(data);								   		
								   	 	$("#"+replacedID).fadeIn();
								  }
								});
					 	}else{					 			
					 		$("#templateArea-assessment").html('');
					 		$("#templateArea-examine").html('');
					 		$("#templateArea-lab-reports").html('');
					 		$("#templateArea-complaints").html('');
						}					 		 		
					 	//EOF template call
				}
										
			});
 

			
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
											//var doseId = attrId.replace("drugText_",'dose_type');
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

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration", "admin" => false)); ?>",
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

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration1", "admin" => false)); ?>",
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
											/*$("#"+doseId).val(pharmacyIdArray[1]);
											if($("#"+doseId).val() == ''){
												$("#"+doseId).append( new Option(pharmacyIdArray[1],pharmacyIdArray[1]) );
												
												if(pharmacyIdArray[1]!='')
													$("#"+doseId).val(pharmacyIdArray[1]);
												else
													$("#"+doseId).val('Select');
									
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration2", "admin" => false)); ?>",
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
											}*/
											
											
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

			/*	  $("#HxAbnormalPap").click(function(){	
					  alert('jhhhhhhh');
					    $("#showPAP").fadeToggle();
			});*/
					
				$('.personalPAP:radio').click(function(){								
						
						if($(this).val() =='1'){
						$('#showPAP').fadeIn('slow');	
						$('#hxabnormalpap_yes').fadeIn('slow');
						}else{
						$('#showPAP').fadeOut('slow');	
						$('#hxabnormalpap_yes').fadeOut('slow');
						$('#hxabnormalpap_yes').val("");		
						}
					});
			$('.personalMammography:radio').click(function(){		
				if($(this).val() =='1'){
				$('#showMammography').fadeIn('slow');	
				$('#last_mammography_yes').fadeIn('slow');
				
				}else{
				$('#showMammography').fadeOut('slow');	
				$('#last_mammography_yes').fadeOut('slow');		
				$('#last_mammography_yes').val("");	
				}
			});
			$('.personalPPD:radio').click(function(){				
				if($(this).val() =='1'){
				$('#showPPD').fadeIn('slow');	
				$('#last_PPD_yes').fadeIn('slow');
				}else{
				$('#showPPD').fadeOut('slow');	
				$('#last_PPD_yes').fadeOut('slow');
				$('#last_PPD_yes').val("");	
					
				}
			});

			$('.military_services:radio').click(function(){		
				if($(this).val() =='1'){		
				$('#showMilitaryServices').fadeIn('slow');	
				$('#militaryservices').fadeIn('slow');
			
				}else{
				$('#showMilitaryServices').fadeOut('slow');	
				$('#militaryservices').fadeOut('slow');	
				$('#militaryservices_yes').val("");
					
				}
			});
			$('.exercise:radio').click(function(){	
			
				if($(this).val() =='1'){					
				$('#showExercise1').fadeIn('slow');	
				$('#showExercise2').fadeIn('slow');	
				$('#showExercise3').fadeIn('slow');
				$('#exercise_type').fadeIn('slow');	
				$('#exercise_frequency').fadeIn('slow');	
				$('#exercise_duration').fadeIn('slow');		
			}else{				
				$('#showExercise1').fadeOut('slow');	
				$('#showExercise2').fadeOut('slow');	
				$('#showExercise3').fadeOut('slow');	
				$('#exercise_type').fadeOut('slow');	
				$('#exercise_frequency').fadeOut('slow');	
				$('#exercise_duration').fadeOut('slow');
				$('#exercise_type').val("");
				$('#exercise_frequency').val("");
				$('#exercise_duration').val("");	
			}
			});
				$('.chemotherapy:radio').click(function(){	
				
				if($(this).val() =='1'){					
				$('.showChemotherapy1Lbl').show();	
				$('.showChemotherapy2Lbl').show();	
				$('.showChemotherapy3Lbl').show();				
				$('#showChemotherapy1').show();	
				$('#showChemotherapy2').show();	
				$('#showChemotherapy3').show();				
				$('#chemotherapy_drug_name').show();	
				$('#first_round_date').show();	
				$('#last_round_date').show();		
			}else{			
				$('.showChemotherapy1Lbl').hide();	
				$('.showChemotherapy2Lbl').hide();	
				$('.showChemotherapy3Lbl').hide();	
				$('#showChemotherapy1').hide();	
				$('#showChemotherapy2').hide();	
				$('#showChemotherapy3').hide();	
				$('#chemotherapy_drug_name').hide();	
				$('#first_round_date').hide();	
				$('#last_round_date').hide();
				$('#chemotherapy_drug_name').val("");
				$('#first_round_date').val("");
				$('#last_round_date').val("");	
			}
			});
			$('.radiation_therapy:radio').click(function(){	
				
				if($(this).val() =='1'){					
				$('.showRadiation1Lbl').show();	
				$('.showRadiation2Lbl').show();	
				$('.showRadiation3Lbl').show();				
				$('#showRadiation1').show();	
				$('#showRadiation2').show();	
				$('#showRadiation3').show();				
				$('#radiation_previous_treatment').show();	
				$('#radiation_start_date').show();	
				$('#radiation_finish_date').show();		
			}else{			
				$('.showRadiation1Lbl').hide();	
				$('.showRadiation2Lbl').hide();	
				$('.showRadiation3Lbl').hide();	
				$('#showRadiation1').hide();	
				$('#showRadiation2').hide();	
				$('#showRadiation3').hide();	
				$('#radiation_previous_treatment').hide();	
				$('#radiation_finish_date').hide();	
				$('#exercise_duration').hide();
				$('#radiation_previous_treatment').val("");
				$('#radiation_start_date').val("");
				$('#radiation_finish_date').val("");	
			}
			});
			
			$('.receive_chemotherapy_concurrentlyCls:radio').click(function(){	
					
			if($(this).val() =='1'){					
				$('.showReceiveChemotherapyLbl').show();	
				$('#receive_chemotherapy_date').show();	
				$('#showReceiveChemotherapy').show();		
				
			}else{			
				$('.showReceiveChemotherapyLbl').hide();	
				$('#showReceiveChemotherapy').hide();
				$('#receive_chemotherapy_date').hide();	
				$('#receive_chemotherapy_date').val("");	
				}
			});
			
				$('.personal:radio').click(function(){		
													
					 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;			 
					 var lowercase = textName.toLowerCase();
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
				
				$('.first').live('change',function(){	
					currentValue 	= Number($(this).val()) ;
					id 			 	= $(this).attr('id');
					currentCount 	= id.split("_");
					currentFrequency= $('#tabs_frequency_'+currentCount[1]).val();
					hourDiff		= 0 ;					 
					//set timer
       				switch(currentFrequency){       					
       					case "BD":
       						hourDiff = 12 ;
       						break;
       					case "TDS":
       						hourDiff = 6 ;
       						break;
       					case "QID":
       						hourDiff = 4 ;
       						break;       					
       				}			
					
					switch(hourDiff){
						case 12:						 
							$('#second_'+currentCount[1]).val(currentValue+12);
							break;
						case 6:						 
							$('#second_'+currentCount[1]).val(currentValue+6);
							$('#third_'+currentCount[1]).val(currentValue+12);
							break;
						case 4: 
							$('#second_'+currentCount[1]).val(currentValue+4);
							$('#third_'+currentCount[1]).val(currentValue+8);
							$('#forth_'+currentCount[1]).val(currentValue+12);
							break;
						}
				});

				$('#submit_diagno,#id2')
				.click(
						function() { 
							var validateDiagnosisNotes = jQuery("#diagnosisfrm").validationEngine('validate');
							if (validateDiagnosisNotes) {$(this).css('display', 'none');}
						});
				//EOF timer  
		});
   	//script to include datepicker
			$(function() {
				$("#next_visit").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				minDate: new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',		
				onSelect: function ()
			    {			        // The "this" keyword refers to the input (in this case: #someinput)
			        this.focus();
			    }	
			});
			
			$('.icd_eraser').click(function(){
			//	alert($(this).attr('id'));
			});
			
			$("#eraser").click(function(){
				 
				$('#icdSlc').html('');
				$('#icd_ids').val('');
				$("#eraser").hide();
			}); 
			
			$("#eraser").hide();
			 
			//add n remove drud inputs
			 var counter = <?php echo $count?>;
		 
			 $("#addButton")
				.click(
						function() {
							$("#diagnosisfrm").validationEngine('detach'); 
							var newCostDiv = $(document.createElement('tr'))
							     .attr("id", 'DrugGroup' + counter);

							//var start= '<select style="width:80px;" id="start_date'+counter+'" class="" name="start_date[]"><input type="tex">';
							var str_option_value='<?php echo $str;?>';
											var route_option_value='<?php echo $str_route;?>';
											var dose_option_value='<?php echo str_dose;?>';
											var dose_option ='<select style="width:80px;" id="dose_type'+counter+'" class="" name="NewCropPrescription[dose][]"><option value="">Select</option>'+str_option_value;
											var strength_option = '<select style="width:93px;" id="strength'+counter+'" class="frequency" name="NewCropPrescription[strength][]"><option value="">Select</option>'+str_option_value;
											var route_option = '<select style="width:80px;" id="route_administration'+counter+'" class="frequency" name="NewCropPrescription[route][]"><option value="">Select</option>'+route_option_value;
							var frequency_option = '<select  id="frequency_'+counter+'" class="frequency" name="NewCropPrescription[frequency][]"><option value="">Select</option><option value="as directed">as directed</option><option value="Daily">Daily</option><option value="BID">BID</option><option value="TID">TID</option><option value="QID">QID</option><option value="Q1h WA">Q1h WA</option><option value="Q2h WA">Q2h Wa</option><option value="Q4h">Q4h</option><option value="Q2h">Q2h</option><option value="Q3h">Q3h</option><option value="Q4-6h">Q4-6h</option><option value="Q6h">Q6h</option><option value="Q8h">Q8h</option><option value="Q12h">Q12h</option><option value="Q48h">Q48h</option><option value="Q72h">Q72h</option><option value="Nightly">Nightly</option><option value="QHS">QHS</option><option value="in A.M.">in A.M.</option><option value="Every Other Day">Every Other Day</option><option value="2 Times Weekly">2 Times Weekly</option><option value="3 Times Weekly">3 Times Weekly</option><option value="Q1wk">Q1wk</option><option value="Q2wks">Q2wks</option><option value="Q3wks">Q3wks</option><option value="Once a Month">Once a Month</option><option value="Add\'l Sig">Add\'l Sig</option></select>';
							var dosage_form = '<select  id="dosageform_'+counter+'" class="dosageform" name="NewCropPrescription[DosageForm][]"><option value="">Select</option><option value="tablet">tablet</option><option value="Add\'l Sig">Add\'l Sig</option><option value="application">application</option><option value="capsule">capsule</option><option value="drop">drop</option><option value="gm">gm</option><option value="item">item</option><option value="lozenge">lozenge</option><option value="mcg">mcg</option><option value="mg">mg</option><option value="ml">ml</option><option value="mg/mL">mg/mL</option><option value="patch">patch</option><option value="pill">pill</option><option value="puff">puff</option><option value="squirt">squirt</option><option value="suppository">suppository</option><option value="troche">troche</option><option value="unit">unit</option><option value="unit/mL">unit/mL</option><option value="syringe">syringe</option><option value="package">package</option></select>';
							var refills_option = '<select style="width:80px;" id="refills_'+counter+'" class="frequency" name="NewCropPrescription[refills][]"><option value="">Select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
							var prn_option = '<select style="width:auto;" id="prn'+counter+'" class="" name="NewCropPrescription[prn][]"><option value="0">No</option><option value="1">Yes</option></select>';
							var daw_option = '<select style="width:auto;" id="daw'+counter+'" class="" name="NewCropPrescription[daw][]"><option value="1">Yes</option><option value="0">No</option></select>';
							var active_option = '<select style="width:70px;" id="isactive'+counter+'" class="" name="NewCropPrescription[is_active][]"><option value="1">Yes</option><option value="0">No</option></select>';
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
									+ '</td><td valign="top">'
									+ dosage_form
									+ '</td>'
									+ '<td valign="top"><input size="2" type="text" value="" id="day'+counter+'" class="" name="NewCropPrescription[day][]" autocomplete="off"></td>'
									+ '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'" class="" name="NewCropPrescription[quantity][]" autocomplete="off"></td>'
									+ '<td valign="top">'
									+ refills_option
									+ '</td>'
									+ '<td valign="top" align="center">'
									+ prn_option
									+ '</td>'
									+ '<td valign="top" align="center">'
									+ daw_option
									+ '</td>'
									+ '<td valign="top" align="center"><textarea id="special_instruction' + counter + '"  name="NewCropPrescription[special_instruction][]"  size="2" style="width:180px" counter='+counter+'></textarea></td>'
									+ '<td valign="top" align="center">'
									+ active_option
									+ '</td>'
									;

							newCostDiv.append(newHTml);		 
							newCostDiv.appendTo("#DrugGroup");		
							$("#diagnosisfrm").validationEngine('attach'); 			 			 
							counter++;
							if(counter > 0) $('#removeButton').show('slow');
					     });
					 
					     $("#removeButton").click(function () {
								/*if(counter==3){
						          alert("No more textbox to remove");
						          return false;
						        }   	*/		 
								counter--;			 
						 
						        $("#DrugGroup" + counter).remove();
						 		if(counter == 0) $('#removeButton').hide('slow');
						  });
						  //EOF add n remove drug inputs


			    //add1 n remove1 drud inputs
			 var counter_nw = <?php echo $count_nw?>
			
		    $("#addButton_nw").click(function () {			 
				
				$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv_nw = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup_nw' + counter_nw);
				  
				//var route_option = '<select id="mode'+counter1+'" style="width:80px" class="" name="mode[]"><option value="">Select</option><option value="IV">IV</option><option value="IM">IM</option><option value="S/C">S/C</option><option value="P.O">P.O</option><option value="P.R">P.R</option><option value="P/V">P/V</option><option value="R.T">R.T</option><option value="LA">LA</option></select>';
				//var fre_option = '<select id="tabs_frequency_'+counter+'"  class="frequency" name="tabs_frequency[]"><option value="">Select</option><option value="SOS">SOS</option><option value="OD">OD</option><option value="BD">BD</option><option value="TDS">TDS</option><option value="QID">QID</option><option value="HS">HS</option><option value="Twice a week">Twice a week</option><option value="Once a week">Once a week</option><option value="Once fort nightly">Once fort nightly</option><option value="Once a month">Once a month</option><option value="A/D">A/D</option></select>';
				var counts = '<td width="10%" height="20px" align="left" valign="top">'+counter_nw +'</td>';
				var date_birth = '<td width="20%" height="20px" align="left" valign="top"  class="tddate"><input type="text" value="" id="date_birth'+counter_nw+'" class="" style=>"width:120px" name="pregnancy[date_birth][]"></td>';
				var weight = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="weight'+counter_nw+'" class="validate[optional,custom[onlyNumber]]" style=>"width:70px" name="pregnancy[weight][]"></td>';
				var baby_gender = '<select style="width:148px;" id="baby_gender'+counter_nw+'" class="" name="pregnancy[baby_gender][]"><option value="">Please Select</option><option value="M">Male</option><option value="F">Female</option></select>';
				var week_pregnant = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="week_pregnant'+counter_nw+'" class="validate[optional,custom[onlyNumber]]" style=>"width:70px" name="pregnancy[week_pregnant][]"></td>';
				var type_delivery = '<select style="width:148px;" id="type_delivery'+counter_nw+'" class="" name="pregnancy[type_delivery][]"><option value="">Please Select</option><option value="Episiotomy">Vaginal Delivery-Episiotomy</option><option value="Induced_labor">Vaginal Delivery-Induced labor</option><option value="Forceps_delivery">Vaginal Delivery-Forceps delivery</option><option value="Vacuum_extraction">Vaginal Delivery-Vacuum extraction</option><option value="Cesarean">Cesarean section</option></select>';
				var complication = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="complication'+counter_nw+'" class="" style=>"width:100px" name="pregnancy[complication][]"></td>';
				'</tr></table></td>';
				var add = parseInt(counter_nw,10)+1 ;
				var newHTml_nw = '<td> '+ add  +'</td><td class="tddate"><input  type="text" style="width:130px" class="date_birth" name="pregnancy[date_birth][]" value="" id="date_birth' + counter_nw + '"  counter_nw='+counter_nw+', readonly =readonly autocomplete="off"></td><td><input  type="text" style="width:146px" class="validate[optional,custom[onlyNumber]]" name="pregnancy[weight][]" id="weight' + counter_nw + '"  autocomplete="off" counter_nw='+counter_nw+'></td><td>'+baby_gender+'</td><td><input  type="text" style="width:146px" class="validate[optional,custom[onlyNumber]]" name="pregnancy[week_pregnant][]" id="week_pregnant' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+'></td><td>'+type_delivery+'</td><td><input  type="text" style="width:145px" class="" name="pregnancy[complication][]" id="complication' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+'></td><td width="20"><span class="DrugGroup_nw" id=pregnancy'+ counter_nw +'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
				
				newCostDiv_nw.append(newHTml_nw);		 
				newCostDiv_nw.appendTo("#DrugGroup_nw");		
				$("#diagnosisfrm").validationEngine('attach'); 			 			 
				counter_nw++;
				if(counter_nw > 0) $('#removeButton_nw').show('slow');
				 $(".date_birth")
				   	.datepicker({
							showOn : "button",
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							changeMonth : true,
							changeYear : true,
							yearRange: '-100:' + new Date().getFullYear(),
							maxDate : new Date(),
							dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
							onSelect : function() {
								$(this).focus();
												}
											});
		     });
		 
		     $("#removeButton_nw").click(function () {
							 
					counter_nw--;			 
			 
			        $("#DrugGroup_nw" + counter_nw).remove();
			 		if(counter_nw == 0) $('#removeButton_nw').hide('slow');
			  });

		     $('.DrugGroup_nw').live('click',function (){
		         if(confirm("Do you really want to delete this record?")){
		         var pregTrId = $(this).attr('id').replace("pregnancy","DrugGroup_nw");
		     	 $('#' + pregTrId).remove();
		     		counter_nw--;			 
		     	 if(counter_nw == 0) $('#removeButton_nw').hide('slow');
		         }else{
		             return false;
		         }
		       
		         });
			  //EOF add1 n remove1 drug inputs


			  
			 // Add more for past medical record
			 
			 var counter_history = <?php echo $count_history?>
		 
		    $("#addButton_history").click(function () {		 				 
				
				$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv_history = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup_history' + counter_history);

				var illness = '<td width="270px" height="20px" align="left" valign="top"><a href="javascript:icdwin1(\'illness'+counter_history+'\')"><input type="text" value="" id="illness'+counter_history+'" class="" style=>"width:70px" name="PastMedicalHistory[illness][]"></a></td>';
				var status = '<select style="width:285px" id="status'+counter_history+'" class="" name="PastMedicalHistory[status][]"><option value="">Please Select</option><option value="Chronic">Chronic</option><option value="Existing">Existing</option><option value="New_on_set">New On Set</option><option value="Recovered">Recovered</option><option value="Acute">Acute</option><option value="Inactive">Inactive</option></select>';
				var duration = '<td width="270px" height="20px" align="left" valign="top"><input type="text" value="" id="duration'+counter_history+'" class="validate[optional,custom[onlyNumber]]" style=>"width:70px" name="PastMedicalHistory[duration][]"></td>';
				var comment = '<td width="270px" height="20px" align="left" valign="top"><input type="text" value="" id="comment'+counter_history+'" class="" style=>"width:120px" name="PastMedicalHistory[comment][]"></td>';
				'</tr></table></td>';
				
				var newHTml_history = '<td style="border-left: solid 1px #3E474A;"><input class="problemAutocomplete" type="text" style="width:270px" value="" name="PastMedicalHistory[illness][]" id="illness' + counter_history + '" autocomplete="off" counter_history='+counter_history+'></td><td>'+status+'</td><td><input  type="text" style="width:270px" value="" name="PastMedicalHistory[duration][]" class="validate[optional,custom[onlyNumber]] textBoxExpnd" id="duration' + counter_history + '"  autocomplete="off" counter_history='+counter_history+'></td><td><input  type="text" style="width:270px" value="" name="PastMedicalHistory[comment][]" id="comment' + counter_history + '"  autocomplete="off" counter_history='+counter_history+'></td><td width="20"><span class="DrugGroup_history" id=pMH'+counter_history+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
				
				newCostDiv_history.append(newHTml_history);		 
				newCostDiv_history.appendTo("#DrugGroup_history");		
				$("#diagnosisfrm").validationEngine('attach'); 			 			 
				counter_history++;
				if(counter_history > 0) $('#removeButton_history').show('slow');
		     });
		 
		     $("#removeButton_history").click(function () {
							 
					counter_history--;			 
			 
			        $("#DrugGroup_history" + counter_history).remove();
			 		if(counter_history == 0) $('#removeButton_history').hide('slow');
			  });
			 
			 //EOF  Add more for past medical record
			  
			      //add1 n remove1 procedure history
			 counter_procedure = <?php echo $count_procedure ?>
		 
		    $("#addButton_procedure").click(function () {		 				 
				
				//$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv_procedure = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup_procedure' + counter_procedure);
				  
				 	var age_unit = '<select style="width:auto;" id="age_unit'+counter_procedure+'" class="" name="ProcedureHistory[age_unit][]"><option value="">Please Select</option><option value="Days">Days</option><option value="Months">Months</option><option value="Years">Years</option></select>';
				 
				 	var newHTml_procedure = '<td style="border-left: solid 1px #3E474A;" width="17%"><input  type="text" style="width:90%" value="" name="ProcedureHistory[procedure_name][]" id="procedureDisplay_' + counter_procedure + '" class="procedure" autocomplete="off" counter_procedure='+counter_procedure+'><input id="procedure_' + counter_procedure + '" type="hidden" counter_procedure=' + counter_procedure + ' name="ProcedureHistory[procedure][]"></td><td width="17%"><input  type="text" style="width:90%" value="" name="ProcedureHistory[provider_name][]" id="providerDisplay_' + counter_procedure + '" class="providercls" autocomplete="off" counter_procedure='+counter_procedure+'><input  type="hidden" style="width:90%" value="" name="ProcedureHistory[provider][]" id="provider_' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td><td width="17%" valign="top" height="20px" align="right" ><input  type="text" style="width:29%" value="" name="ProcedureHistory[age_value][]" class="validate[optional,custom[onlyNumber]] textBoxExpnd" id="age_value' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'>'+age_unit+'</td><td width="17%" style="padding: 0 0 0 60px;"><input  type="text"  class="procedure_date textBoxExpnd" name="ProcedureHistory[procedure_date][]" value="" autocomplete="off" id="procedure_date' + counter_procedure + '"  counter_procedure='+counter_procedure+'></td><td width="17%"><input  type="text" style="width:90%" value="" name="ProcedureHistory[comment][]" id="comment' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td><td width="4%" ><span class="DrugGroup_procedure" id=surgery'+counter_procedure+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
				
				newCostDiv_procedure.append(newHTml_procedure);		 
				newCostDiv_procedure.appendTo("#DrugGroup_procedure");		
				$("#diagnosisfrm").validationEngine('attach'); 			 			 
				counter_procedure++;
				if(counter_procedure > 0) $('#removeButton_procedure').show('slow');
				 $(".procedure_date").datepicker({
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange: '-100:' + new Date().getFullYear(),
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
						onSelect : function() {
							$(this).focus();
											}
										});
		     });
		 
		     $("#removeButton_procedure").click(function () {
							 
					counter_procedure--;			 
			 
			        $("#DrugGroup_procedure" + counter_procedure).remove();
			 		if(counter_procedure == 0) $('#removeButton_procedure').hide('slow');
			  });

		     $('.DrugGroup_history').live('click',function (){
		    	  if(confirm("Do you really want to delete this record?")){
		        var trId = $(this).attr('id').replace("pMH","DrugGroup_history");
		    	 $('#' + trId).remove();
		    	 counter_history--;			 
		    	 if(counter_history == 0) $('#removeButton_history').hide('slow');
		    	  }else{
			    	 
					return false;
		        	  }
		        });

		     $('.DrugGroup_procedure').live('click',function (){
		         if(confirm("Do you really want to delete this record?")){
		         	var surgTrId = $(this).attr('id').replace("surgery","DrugGroup_procedure");
		         	counter_procedure--;
		 			$('#' + surgTrId).remove();
		      		if(counter_procedure == 0) $('#removeButton_procedure').hide('slow');
		          }else{
		              return false;
		          }
		        
		          });
			  //EOF add1 n remove1 procedure history
			  
			  
			  
			   $(".date_birth")
			   	.datepicker({
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange: '-100:' + new Date().getFullYear(),
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
						onSelect : function() {
							$(this).focus();
											}
										});
				 
			  
			  
		     



			 $(".procedure_date").datepicker({
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange: '-100:' + new Date().getFullYear(),
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
						onSelect : function() {
							$(this).focus();
											}
										});
				
			});
			 
			function remove_icd(val,id){
				//alert(val);alert(id);	 
				 var ids= $('#icd_ids').val(); 
				 var tt = ids.replace(val+'|',''); 
				 $('#icd_ids').val(tt); 
				 $("#icd_"+val).remove();
				 
 			}
			
			//script to include datepicker
			$(function() {
				$( "#register_on" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']) ?>),
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
				});
				
				$("#lmp")
				.datepicker(
						{
							showOn : "button",
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							changeMonth : true,
							changeYear : true,
							yearRange: '-100:' + new Date().getFullYear(),
							maxDate : new Date(),
							dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
							onSelect : function() {
								$(this).focus();
								//foramtEnddate(); //is not defined hence commented
							}

						});

				$("#capture_date")
				.datepicker(
						{
							showOn : "button",
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							changeMonth : true,
							changeYear : true,
							yearRange: '-100:' + new Date().getFullYear(),
							maxDate : new Date(),
							dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
							onSelect : function() {
								$(this).focus();
								//foramtEnddate(); //is not defined hence commented
							}

						});
				
				
				$( "#dob" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']) ?>),
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
				});
				
				$( "#consultant_on" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']) ?>),
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
				});
			});	

			function diagnosisMsg(){
				alert("You have not fill anything!");
				return false;				
			}
	
			
//added by pankaj
			$( "#startdate" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	$( "#onsets_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});


	$( "#startdatefood" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	$( "#onsets_date_food" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});

	$( "#startdateenv" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	$( "#onsets_date_env" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	$(".effective_date" ).live("click",function() {
		
		$(this).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	})
	});
/*
	//jQuery("#drugallergyfrm").validationEngine();

	
         //validation by vikas
         
  <!--// function save_allergy1("env"){
  // var error = "";
  
    //if (env.DrugAllergy.fromenv.length == 0) {
       
       // error = "The required field has not been filled in.\n"
   // } else {
      //  fld.style.background = 'White';
  // }
    //return error;   
//} 
	/*  function validateForm("env")
	  {
	  var x=document.forms["diagnosisfrm"]["DrugAllergy.fromenv"].value;
	  if (x==null || x=="")
	    {
	    alert("First name must be filled out");
	    return false;
	    }
	  }*/
	
	function save_allergy(allergytype){
		//code added by vikas
			//validation on allergy
		  var alrgyenv = $('#envval').val();
		  var alrgyfood = $('#foodval').val();
		  var alrgydrug = $('#drugval').val();
		  
		  if (allergytype =='env' && alrgyenv== "")
		    {
		    alert("Please enter Environment type");
		    return false;
		    }
		  
		
			
		  if (allergytype=='food' && alrgyfood== "")
		    {
		    alert("Please enter food type");
		    return false;
		    }
		  
		  
			
		  if (allergytype=='drug' && alrgydrug== "")
		    {
		    alert("Please enter drug type");
		    
		    }
		  
		//validation on startdate
		  var drugdate = $('#startdate').val();
		  var envdate = $('#startdateenv').val();
		  var fooddate = $('#startdatefood').val();
		 
		  if (allergytype=='drug' && drugdate == "")
		    {
		    alert("Please enter Start Date");
		    
		    return false;
		    }
		  
		  if (allergytype =='env' && envdate == "")
		    {
		    alert("Please enter Start Date");
		    return false;
		    }
		  
		
			
		  if (allergytype=='food' && fooddate== "")
		    {
		    alert("Please enter Start Date");
		    return false;
		    }
		  
		  
		  //validation on checkbox
		/*var activedrug = $('#active').val();
		  
		 if(allergytype=='drug' && activedrug.checked == false)
		 {
				 alert('Please Check the active');
				
			 return false;
			 
			  }*/

			  /* if(document.getElementById('active').checked == false)
					 { 
						 alert('Please Check the active');
					 return false;
					 
					 	if(document.getElementById('active1').checked == false)
				 			{ 
					 			alert('Please Check the active');
								 return false;
				 
						 if(document.getElementById('active2').checked == false)
							 {
								 alert('Please Check the active');
								 return false;
			 				 }
				 		 }
					  }*/
			  
		  
		 
		
		/*	 var check   = 0;
		  if(diagnosisfrm.Active.checked== false)
		 {
			//  alert('Check the active');
		 return false;
		  }*/
		 // var alrgyfood = $('#active1').val();
		  
		  if(allergytype=='drug' && document.getElementById('active').checked == false)
			{ alert
			('Please Check the active');
						 return false;
				 				 }
		  
	if(allergytype=='food' && document.getElementById('active1').checked == false)
		{ alert
		('Please Check the active');
					 return false;
			 				 }
	if(allergytype=='env' && document.getElementById('active2').checked == false)
	{ alert
	('Please Check the active');
				 return false;
		 				 }
	
		  
	//	 if ( ( form.active[0].checked == false )  ) 
						//{
						//alert ( "Please choose your Gender: Male or Female" ); 
						//return false;
					//	}
		 
			
		
		
		 //validation code end here added by vikas
		  
		  
		 

	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "save_allergy",$patient['Patient']['id'],"admin" => false)); ?>";
	   var formData = $('#diagnosisfrm').serialize();
      patientid="<?php echo $patient['Patient']['id']?>";
	  
           $.ajax({
            type: 'POST',
            url: ajaxUrl+"/"+allergytype,
            data: formData,
            dataType: 'html',
            success: function(data){
            	//alert(data);
            	 window.location.href = '<?php echo $this->Html->url('/diagnoses/add/'); ?>'+patientid; 
            },
			error: function(message){
               // alert(message);
            }        });
      
      return false;
	}

	$("#displayDrugAllergy").click(function () { 
        $("#displayDrugAllergyId").show();
		$("#displayFoodAllergyId").hide();
		 $("#displayEnvAllergyId").hide();
    });
	$("#displayFoodAllergy").click(function () {  
        $("#displayFoodAllergyId").show();
		$("#displayDrugAllergyId").hide();
		 $("#displayEnvAllergyId").hide();
    });
	$("#displayEnvAllergy").click(function () {  
        $("#displayEnvAllergyId").show();
		$("#displayDrugAllergyId").hide();
		$("#displayFoodAllergyId").hide();
    });
    $("#closedrugallergy").click(function () { 
       $("#displayDrugAllergyId").hide();
    });
	 $("#closefoodallergy").click(function () { 
       $("#displayFoodAllergyId").hide();
    });
	$("#closeenvallergy").click(function () { 
		$("#displayEnvAllergyId").hide();
    });

	function hideallergy(val1)
	{
		
		
		if(document.getElementById("noknown").checked)
		{
			
			 document.getElementById("displayDrugAllergy").style.display="none";
			 document.getElementById("displayFoodAllergy").style.display="none";
			 document.getElementById("displayEnvAllergy").style.display="none";
		}
		else
		{
			 document.getElementById("displayDrugAllergy").style.display="block";
			 document.getElementById("displayFoodAllergy").style.display="block";
			 document.getElementById("displayEnvAllergy").style.display="block";
		}


	}

	//----fancy box---
	
	function icdwin() {
		
		var patient_id = $('#patient_id').val();  
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$.fancybox({

			'width' : '50%',
			'height' : '120%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "icd")); ?>"
					+ '/' + patient_id
		});

}
	

   
 //----fancy box---
   function snowmed(){ 
		var patient_id = '<?php echo $patient_id;?>';
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$.fancybox({
				'width' : '70%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>"+'/'+patient_id
				});

		}
	   
   $('#pres')
	.click(
			function() {
				//	var patient_id = $('#selectedPatient').val();

				$
						.fancybox({
							'width' : '70%',
							'height' : '90%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'onComplete' : function() {
								$("#allergies").css({
									top : '20px',
									bottom : auto,
									position : absolute
								});
							},
							'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "bmi_chart",$patient['Patient']['id'])); ?>"

						});

					
			});

   function icdwin1(id) {
	    var identify =""; 
		identify = id;
		$.fancybox({
					'width' : '70%',
					'height' : '120%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "familyproblem")); ?>" + "/" + identify,
				});
       }
 	//----fancy box---
   function pres1() {
		
		var patient_id = $('#p_id').val();  
		
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$
				.fancybox({

					'width' : '70%',
					'height' : '75%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "smoking_detail")); ?>"+'/'+ patient_id
				});

		}


 //------ for ccda-----
				$("#from" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});
			
			$("#to" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});

			$("#from_current" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,
				yearRange: '1950',
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
				});
				
				$("#to_current" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,
				yearRange: '1950',
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
				});

				$(".orderlabdate" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					changeTime:true,
					showTime: true,
					yearRange: '1950',
					dateFormat:'<?php echo $this->General->GeneralDate();?>'
					});

		function callDragon(notetype){
		

		$ .fancybox({
			'width' : '50%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "dragon")); ?>"+'/'+ notetype
		});
		 
	}
//-------eof ccda code
 
var counter=0;

var labText = '<tr><td width="19%" valign="middle" class="tdLabel" id="rectal_examine">&nbsp;</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">&nbsp;</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">&nbsp;</td></tr>';
var labInput = '<tr><td   valign="middle"  id="rectal_examine"><?php echo $this->Form->input("PersonalHealth.disability_0", array("type"=>"text","label"=>false,"style"=>"width:150px","id" => "disability")); ?></td><td valign="top"  id="rectal_examine">Date :</td><td  valign="middle" class="" id="boxspace"><?php echo $this->Form->input("effective_date_0", array("type"=>"text","label"=>false,"style"=>"width:80px","class" => "effective_date")); ?></td><td   valign="middle"   id="boxspace"><?php echo $this->Form->radio('PersonalHealth.status_option_0', array('Active'=>'Active','Inactive'=>'Inactive'), array('legend'=>false,'label'=>false,'id' => 'status_option' ? FALSE : TRUE,));?></td><td>&nbsp;</td><td>&nbsp;</td></tr>';
var labInput1 = '<tr><td   valign="middle"  id="rectal_examine"><?php echo $this->Form->input("PersonalHealth.disability_0", array("type"=>"text","label"=>false,"style"=>"width:150px","id" => "disability")); ?></td><td valign="top"  id="rectal_examine">Date :</td><td  valign="middle" class="" id="boxspace"><?php echo $this->Form->input("effective_date_0", array("type"=>"text","label"=>false,"style"=>"width:80px","class" => "effective_date")); ?></td><td   valign="middle"   id="boxspace"><?php echo $this->Form->radio('PersonalHealth.status_option_0', array('Active'=>'Active','Inactive'=>'Inactive'), array('legend'=>false,'label'=>false,'id' => 'status_option' ? FALSE : TRUE,));?></td><td>&nbsp;</td><td>&nbsp;</td></tr>';

$(function() {
    $("#labResultButton").click(function(event) {//alert('Here');
    	ss= "disabilityAdd_"+counter ;
		counter++;
		
    	var newCostDiv = $(document.createElement('table')).attr("id",'disabilityAdd_'+ counter);
    	labInput = labInput1;
    	
		labInput = labInput.replace("disability_0","disability_"+counter);
		labInput = labInput.replace("disability_0","disability_"+counter); 
		labInput = labInput.replace("effective_date_0","PersonalHealth][effective_date_"+counter);
		labInput = labInput.replace("effective_date_0","PersonalHealth][effective_date_"+counter);
		labInput = labInput.replace("status_option_0","status_option_"+counter);
		labInput = labInput.replace("status_option_0","status_option_"+counter);
		labInput = labInput.replace("status_option_0","status_option_"+counter);
		
		
		
		//newCostDiv.append(labText);
		newCostDiv.append(labInput);
		
		
		
		$(newCostDiv).insertAfter('#'+ss);
		$("#labcount").val(counter);
		
		
		
		
		
    });
});
$(function() { //RemoveLabResultButton
    $("#RemoveLabResultButton").click(function(event) {
    $('#disabilityAdd_'+ (counter-1)).nextAll().remove()
		//$("#labHl7Results").remove('labHl7Results'+ '_' + (counter));
		counter--;
		
    });
    $("#plancare_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});
	$("#general_examine").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});

	$("#complaints_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});
	
	$("#lab-reports_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});
	
	$("#surgery_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});

	$("#final_diagnosis").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});
   
});
$("#date_smoke")
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
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}

		});
$("#date_smoke1")
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
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}

		});
$(document).ready(function(){
    $("#doctor_id_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'doctor_id_txt,consultant_sb'
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
				 $('.procedure').live('focus',function()
						  {  //alert($(this).attr('id')+'-----'+$(this).attr('id').replace("Display_","_"));
					 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList","id",'name','service_category_id='.Configure::read('servicecategoryid'),"admin" => false,"plugin"=>false)); ?>", {
							width: 250, 
							showNoId:true,
							delay:2000,
							valueSelected:true,
							selectFirst: true,
							loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
						});
						  });
				 $('.providercls').live('focus',function() { // 
			  		 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile","id",'doctor_name','null',"admin" => false,"plugin"=>false)); ?>", {
						width: 250, 
						showNoId:true,
						delay:2000,
						valueSelected:true,
						selectFirst: true,
						loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
					});
				});
});
</script>

<script>
$("#date_vital").datepicker({
	showOn : "button",
	style : "margin-left:50px",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange : '1950',
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	});


$(document).ready(function(){
	
	$("#diagnosisfrm").validationEngine();
	$('#submit').click(function() { 
		var validatePerson = jQuery("#diagnosisfrm").validationEngine('validate');
		if (validatePerson) {$(this).css('display', 'none');
		return true;}
		else{
		return false;
		}
		});
		
	$('#reset-bmi').click(function(){
		$('.bmi').each(function(){
			if ($(this).attr("type") == "radio") {
				$(this).attr('checked',false);
			} else {
				$(this).val('');
			}
		});
		return false  ;
	}); 
		 
	});  	

  $(window).load(function () {
	if ($('#TypeHeightFeet').is(':checked')) {
		$('#feet_result').show();
	}
  });




function showBmi()
		 { //alert($("input:radio.Weight:checked").val());
		 		var h = $('#height_result').val();
		 		var height = h.slice(0, h.lastIndexOf(" "));

		 		/*if(height==0){
			 		alert('Please enter proper height');
			 		//$('#height1').val("");
			 		 $('#feet_result').val("");
			 		  $('#height_result').val("");
			 		  $('.Height').attr('checked', false);
			 		  $('#bmis').val("");
			 			return false;
		 		}*/
		 		
		 		/*if(($('#height_result').val())=="")
		 		 {
		 		 alert('Please Enter Height.');
		 		 return;
		 		 }*/
		 		if(/*($('#height_result').val())==""||*/($('#weights').val())==""||($('#weight_result').val())=="")
		 		 {
		 		 alert('Please Enter Weight.');
		 		 return;
		 		 }
		 		
		 		if($("input:radio.Height:checked").val()=="Inches"||$("input:radio.Height:checked").val()=="Cm"||$("input:radio.Height:checked").val()=="Feet")
		 		{
		 		
		 		if($("input:radio.Weight:checked").val()=="Kg")
		 		{
		 			var weight = $('#weights').val();
		 		}
		 		if($("input:radio.Weight:checked").val()=='Lbs')
		 		{	
		 			var w = $('#weight_result').val();
		 			var weight = w.slice(0, w.lastIndexOf(" "));
		 		}
		 		height = (height / 100);
		 		weight = weight;
		 		height = (height * height);
		 		//height = (height / 100);
		 		var total = weight / height;
		 		
		 		total=Math.round((total * 100) / 100);

				 if(!isNaN(parseInt(total)) && isFinite(total)){
					$('#bmis').val(total);
				 }
		   
		 		}
		 		else
		 		{
		 			//alert('Please Enter Height.');
		 			 return;
		 			}
		 		
		  }; 


$('.cercumference').click(function ()
{//alert($(this).val());
		//alert($('#head_circumference').val());
		$('#head_result').val($('#head_circumference').val());

		 if(isNaN($('#head_circumference').val())==false){ 
				  if($(this).val()=="Inches")
				  {
				    var val=$('#head_circumference').val();
				    var res=(val/0.3937);
				    res= Math.round(res * 100) / 100;
				    //var result=Math.round(res);
				    $('#head_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#head_circumference').val();
				    var res1=(val*0.3937);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#head_result').val(res1+" Inches");
				  }
		 }
		 else{
			 
			  alert('Please enter valid head cercumference');
			  $('#head_circumference').val("");
			  $('#head_result').val("");
			  $('.cercumference').attr('checked', false);
				return false;
			}
		 
 });  

$('#head_circumference').keyup(function ()
{//alert($('.cercumference').val());
				//alert($('#head_circumference').val());
				$('#head_result').val($('#head_circumference').val());

				 if(isNaN($('#head_circumference').val())==false){ 
				  if($('.cercumference').val()=="Inches")
				  {
				    var val=$('#head_circumference').val();
				    var res=(val/0.3937);
				    res= Math.round(res * 100) / 100;
				    //var result=Math.round(res);
				    $('#head_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#head_circumference').val();
				    var res1=(val*0.3937);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#head_result').val(res1+" Inches");
				  }
				 }
				 else{
					 
				  alert('Please enter valid head cercumference');
				  $('#head_circumference').val("");
				  $('#head_result').val("");
				  $('.cercumference').attr('checked', false);
					return false;
					}
				 
});

$('.waist').click(function ()
	{//alert($(this).val());
			//alert($('#waist_circumference').val());
			$('#waist_result').val($('#waist_circumference').val());
			 if(isNaN($('#waist_circumference').val())==false){  
				  if($(this).val()=="Inches")
				  {
				    var val=$('#waist_circumference').val();
				    var res=(val/0.3937);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#waist_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#waist_circumference').val();
				    var res1=(val*0.3937);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#waist_result').val(res1+" Inches");
				  }
			 }
			 else{
				 
				  alert('Please enter valid waist');
				  $('#waist_circumference').val("");
				  $('#waist_result').val("");
				  $('.waist').attr('checked', false);
					return false;
				}
			 
	 });  


$('#waist_circumference').keyup(function ()
{//alert($('.waist').val());
		//alert($('#waist_circumference').val());
		$('#waist_result').val($('#waist_circumference').val());
		 if(isNaN($('#waist_circumference').val())==false){  
			  if($('.waist').val()=="Inches")
			  {
			    var val=$('#waist_circumference').val();
			    var res=(val/0.3937);
			    res= Math.round(res * 100) / 100;
			   // var result=Math.round(res);
			    $('#waist_result').val(res+" Cm");
			  }
			  else 
			  {
			    var val=$('#waist_circumference').val();
			    var res1=(val*0.3937);
			    res1= Math.round(res1 * 100) / 100;
			    //var result1=Math.round(res);
			    $('#waist_result').val(res1+" Inches");
			  }
		 }
		 else{
			 
			  alert('Please enter valid waist');
			  $('#waist_circumference').val("");
			  $('#waist_result').val("");
			  $('.waist').attr('checked', false);
				return false;
			}
 });


$('.degree').click(function ()
{
	$('#equal_value').val($('#temperature').val());

		 if(($('#temperature').val())=="")
			 {
			 alert('Please Enter Tempreture in Degrees.');
			 return;
			 }
		 if(isNaN($('#temperature').val())==false){
				
		  if($(this).val()=="F")
		  {
			  var val=$('#temperature').val();
			    var tf=(val);
			    var tc=(5/9)*(tf-32);
			    var res=(tc*Math.pow(10,2))/Math.pow(10,2);
			    res= Math.round(res * 100) / 100;
		    	$('#equal_value').val(res+" C");
		  }
		  else 
		  {
			  var val=$('#temperature').val();
			    var tc=(val);
			    var tf=((9/5)*tc)+32;
			    var res1=(tf*Math.pow(10,2))/Math.pow(10,2);
			    res1= Math.round(res1 * 100) / 100;
			    $('#equal_value').val(res1+" F");
		  }
		 }
		 else{
			  alert('Please enter valid temprature');
			  $('#temperature').val("");
			  $('#equal_value').val("");
			  $('.degree').attr('checked', false);
				return false;
			}
});   

$('#temperature').keyup(function ()
	{
		$('#equal_value').val($('#temperature').val());
	 if(($('#temperature').val())=="")
		 {
		 alert('Please Enter Tempreture in Degrees.');
		 return;
		 }
	 if(isNaN($('#temperature').val())==false){
			
	  if($('.degree').val()=="F")
	  {
		  var val=$('#temperature').val();
		    var tf=(val);
		    var tc=(5/9)*(tf-32);
		    var res=(tc*Math.pow(10,2))/Math.pow(10,2);
		    res= Math.round(res * 100) / 100;
	    	$('#equal_value').val(res+" C");
	  }
	  else 
	  {
		  var val=$('#temperature').val();
		    var tc=(val);
		    var tf=((9/5)*tc)+32;
		    var res1=(tf*Math.pow(10,2))/Math.pow(10,2);
		    res1= Math.round(res1 * 100) / 100;
		    $('#equal_value').val(res1+" F");
	  }
	 }
	 else{
		 
		  alert('Please enter valid temprature');
		  $('#temperature').val("");
		  $('#equal_value').val("");
		  $('.degree').attr('checked', false);
			return false;
		}
		  
});

$('.Weight').click(function ()
	{//alert($('.Weight').val());
			 //alert($('#weights').val());
		
			$('#weight_result').val($('#weights').val());

			if(($('#weights').val())=="")
			{
			 alert('Please Enter Weight.');
			 $('.Weight').attr('checked', false);
			 return;
			}	
			
			if(isNaN($('#weights').val())==false){
				  if($(this).val()=="Kg")
				  {
				    var val=$('#weights').val();
				    var res=(val*2.2);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#weight_result').val(res+" Pounds");
				  }
				  else 
				  {
				    var val=$('#weights').val();
				    var res1=(val/2.2);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#weight_result').val(res1+" Kg");
				  }
			}
			else{
				 
				alert('Please enter valid weight');
				  $('#weights').val("");
				  $('#weight_result').val("");
				  $('.Weight').attr('checked', false);
					return false;
			}
			showBmi();
		
	 });  

$('#weights').keyup(function ()
	{//alert($('.Weight').val());
			 //alert($('#weights').val());
		
			$('#weight_result').val($('#weights').val());

			if(($('#weights').val())=="")
			{
			 alert('Please Enter Weight.');
			 //$('.Weight').attr('checked', false);
			 return;
			}	
			
			if(isNaN($('#weights').val())==false){
				  if($('.Weight').val()=="Kg")
				  {
				    var val=$('#weights').val();
				    var res=(val*2.2);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#weight_result').val(res+" Pounds");
				  }
				  else 
				  {
				    var val=$('#weights').val();
				    var res1=(val/2.2);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#weight_result').val(res1+" Kg");
				  }
			}
			else{
				 
				alert('Please enter valid weight');
				  $('#weights').val("");
				  $('#weight_result').val("");
				  $('.Weight').attr('checked', false);
					return false;
			}

			showBmi();
	 });

$('#height1').keyup(function ()
{  
	  checkedRadiod  = $(".Height input[type='radio']:checked").val();
	  $('.Height').each(function(){		  
		  if($(this).attr('checked')==true){ 
		    calHeight($(this).attr('id')) ;
	   	  }
	  });
	  showBmi();
});


$("#feet_result").keyup(function ()		{  
	 checkedRadiod  = $(".Height input[type='radio']:checked").val();
	  $('.Height').each(function(){		  
		  if($(this).attr('checked')==true){ 
		    calHeight($(this).attr('id')) ;
	   	  }
	  }); 
	  showBmi(); 	
});

$('.Height').click(function ()
{  
	 calHeight($(this).attr('id'));
	 showBmi();
}); 

$('#height1').blur(function ()
{  
	 //calHeight($(this).attr('id'));
		    	
});




function calHeight(idStr){	
	if(($('#height1').val())=="")
	{
	 alert('Please Enter Height.');
	// $('.Height').attr('checked', false);
	 $('#height_result').val("");
	 $('#feet_result').val("");
	 return;
	}	 
	if(isNaN($('#height1').val())==false){
			
		 $('#height_result').val($('#height1').val());
		  id = "#"+idStr ;
	}
	else{	 
	  alert('Please enter valid height');
	  $('#height1').val("");
	  $('#feet_result').val("");
	  $('#height_result').val("");
	  //$('.Height').attr('checked', false);
	  $('#bmi').val("");
		return false;
	}
	 
	  if($(id).val()=="Inches")
	  {		   
		  $('#feet_inch').hide();
	      var val=$('#height1').val();
	      var res=(val*2.54);
	      res= Math.round(res * 100) / 100;
	      $('#height_result').val(res+" Cm");
	      return res ;
	  }
	 if($(id).val()=="Cm")
	  {  
		$('#feet_inch').hide();
	    var val=$('#height1').val();
	    var res1=val;
	    res1= Math.round(res1 * 100) / 100;
	    //var result1=Math.round(res);
	    $('#height_result').val(res1+" Cm");
	    return res1 ;
	  }
	 if($(id).val()=="Feet")
	  {
		$('#feet_result')//calculate inches
		
		$('#feet_inch').show();
	    var val=$('#height1').val();
	    var res2=(val/0.032808);
	    res2= Math.round(res2 * 100) / 100;
	    var feetInches = $('#feet_result').val();
	    feetInches= Math.round(feetInches * 100) / 100;
        var feetInchesCalc=(feetInches*2.54);
        feetInchesCalc= Math.round(feetInchesCalc * 100) / 100;
	    //var result1=Math.round(res);
	    $('#height_result').val(+(res2+feetInchesCalc).toFixed(2)+" Cm");
	    return res2 ;
	  }

	  if(idStr=='height'){
		   
		 // checkedRadiod  = $('input[name=data[BmiResult][height]]:checked', '#design1').val() ;
		  checkedRadiod  = $(".Height input[type='radio']:checked").val();
		  $('.Height').each(function(){
			  //var id=$('.Height').attr('id');
			  //calHeight(id);
			  if($(this).attr('checked')==true){
			    calHeight($(this).attr('id')) ;
		   	  }
		  }); 
	  }else if(idStr=='feet_result'){ 
		  feetID = $('input[name=height_volume]:checked', '#diagnosisfrm').attr('id') ; //checked radio button 
		  $("input[name=height_volume]:radio").each(function () {
				if(this.checked) feetID=this.id;
		  });
		  feetCalc= calHeight(feetID);  
		  feetCalc= Math.round(feetCalc * 100) / 100;
	      var feetInches = $('#feet_result').val();
	      var feetInchesCalc=(feetInches*2.54); 
	      feetInchesCalc= Math.round(feetInchesCalc * 100) / 100; 
	      var total = Math.round(feetCalc+feetInchesCalc) ; 
	      $('#height_result').val(total+" Cm"); 
	  }
}



$(document).ready(function(){
	//$('#hxabnormalpap_yes').hide();
	 $('.problemAutocomplete').live('focus',function(){ 
		$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","SnomedMappingMaster","sctName",'null','null','null','null','null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			//minLength: 3
		});
	});
	 
	 $(".last_PPD_yes").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
	 $(".hxabnormalpap_yes").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
		$(".last_mammography_yes").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
		$("#first_round_date,#last_round_date,#radiation_start_date,#radiation_finish_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
		$(".receive_chemotherapy_dateCls").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
		
		$("#other_relatives").change(function(){
			var data= $("#other_relatives option:selected").val();
			if(data=='Uncle'){
				$("#showUncle").fadeToggle(10);		
			}
			if(data=='Aunt'){
				$("#showAunt").fadeToggle(10);		
			}
			if(data=='Grandmother'){
				$("#showGrandmother").fadeToggle(10);		
			}
			if(data=='Grandfather'){
				$("#showGrandfather").fadeToggle(10);		
			}
		});
// calls on ready
var relstr = "<?php echo $unHideRelation ?>";
var unHiderelationArray = relstr.split(',');
var relationArray = [];
var relationArray = ['showUncle','showAunt','showGrandmother','showGrandfather'];
	$.each(unHiderelationArray,function(index,value){
			if ($.inArray( value, relationArray ) !== -1){
				$('#'+value).hide();
			}
		});
});

/*jQuery(document).ready(function(){
	$('#expandBtn').click(function(){ 
				jQuery("#complaints").show();
				jQuery("#lab-reports").show();
				jQuery("#treatment").show();											
				jQuery("#other_treatments").show();
				jQuery("#significant_history").show();
				jQuery("#vitals").show();
			  	var validatePerson = jQuery("#diagnosisfrm").validationEngine('validate');
				if (validatePerson) {$(this).css('display', 'none');
				return false;}
			});


});*/
function expandCollapseAll(id){
	if(id=='collapseBtn'){//dragbox-content
		$(".dragbox-content").css('display','none'); 
		$('#expandBtn').removeClass('active');
		$('#collapseBtn').addClass('active');
	}else{
		$(".dragbox-content").css('display','block');
		$('#expandBtn').addClass('active');
		$('#collapseBtn').removeClass('active');
	}	
}
</script>

