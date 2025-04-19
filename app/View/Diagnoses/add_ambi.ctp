<?php echo $this->Html->script(array('inline_msg','jquery.blockUI')); ?>
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

#navc	{
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

* html #navc li li {
	float: left;
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

</style>
 
<?php 
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
		'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
echo $this->Html->Script('ui.datetimepicker.3.js');
echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js','stuHover.js','jquery.selection.js'));
echo $this->Html->css(array('jquery.autocomplete.css','skeleton.css'));
?>
<script type="text/javascript">
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
		     		}
		     		?>
		</td>
	</tr>
</table>
<?php } 

echo $this->Form->create('Diagnosis',array('id'=>'diagnosisfrm','url'=>array('action'=>'add_ambi',$patient_id),
		'inputDefaults' => array(
											        'label' => false,
											        'div' => false,
											        'error'=>false )));

?>
<div class="inner_title">
	<div style="float: left">
		<h3>
			<?php
			if($patient['Patient']['is_emergency'] == 1){
        echo __('Emergency Room Assessment');
     }else{
     	echo __('Initial Assessment');
     } ?>
		</h3>
	</div>
	<div style="text-align: right;">
		<?php
		if(isset($this->data['Diagnosis']['id'])){
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

	   	  				 		echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false,'id'=>'id2'));
	   	  				 		if($this->Session->check('returnPage')){
   						  			if($this->Session->read('returnPage')=='assessment'){
   						  				$cancelBtnUrl =  array('controller'=>'patients','action'=>'search','?'=>array('type'=>'IPD','mod'=>'assessment'));
   						  			}
   						  		}else{
   						  			$cancelBtnUrl =  array('controller'=>'patients','action'=>'patient_information',$patient['Patient']['id']);
   						  		}
   						  		echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false));
   						  		?>
	</div>
</div>
<p class="ht5"></p>
<?php 

		echo $this->Form->hidden('patient_id',array('value'=>$patient['Patient']['id']));
		echo $this->Form->hidden('location_id',array('value'=>$this->Session->read('locationid')));
		//history data
		echo $this->Form->input('PatientPastHistory.id', array('type'=>'hidden'));
		echo $this->Form->input('PatientPersonalHistory.id', array('type'=>'hidden'));
		echo $this->Form->input('PatientFamilyHistory.id', array('type'=>'hidden'));
		echo $this->Form->input('PatientAllergy.id', array('type'=>'hidden'));
		echo $this->Form->hidden('drug_allergy_id', array('value'=>$allergy_id));
		?>
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
echo $this->element('patient_information');
if($patient['Patient']['admission_type'] == "OPD") $display = 'none';
else $display = 'block';
?>
<!-- two column table end here -->
<div>&nbsp;</div>


<!--------------------------------Diabetes reminder end--------------------------------------- -->
<!-- Complaints table start here -->


<div
	id="accordionCust" class = "accordionCust">
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
							<td><?php echo $this->Form->input('DrugAllergy.fromdrug',array('legend'=>false,'label'=>false,'class' => 'validate[required] drugText','id' => 'drugval','value'=>$drugallergy_data["0"]["DrugAllergy"]["from1"],'autocomplete'=>"off"));?>
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
		<a href="#"> <?php echo __('Presenting Complaints With Duration');?>
		</a>
	</h3>
	<div class="section" id="complaints">
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
							<a href="javascript:void(0);" onclick="callDragon('complaints')" style="text-align:left;"><font color="white">Use speech recognition</font> </a>
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
	<div class="section" id="lab-reports" style="display: &amp;amp;">
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
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('lab_report', array('class' => 'textBoxExpnd','id' => 'lab-reports_desc','style'=>'width:98%','rows'=>18)); ?>
							<a href="javascript:void(0);" onclick="callDragon('lab_report')" style="text-align:left;"><font color="white">Use speech recognition</font> </a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<h3 style="display: &amp;amp;">
		<a href="#"> <?php echo __('Current Treatment');?>
		</a>
	</h3>
	<div class="section" style="display: &amp;amp;">
		
		<table class="tdLabel" style="text-align: left;" width="100%">
			<tr>

				<td width="100%" valign="top" align="left" style="padding: 8px;"
					colspan="4">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">

					
						<tr>
							<td width="100%" valign="top" align="left" colspan="6">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" id='DrugGroup'>
									<tr>
										<td width="18%" height="20" align="left" valign="top">Name of Medication</td>
										<td width="18%" height="20" align="left" valign="top">Unit</td>
										<td width="6%" align="left" valign="top">Route</td>
										<td width="6%" align="left" valign="top">Dose</td>
										<td width="8%" align="left" valign="top">Quantity</td>
										<td width="8%" align="left" valign="top">No. of Days</td>
										<td width="54%" align="center" valign="top">Timing</td>
									</tr>
									<tr>
										<td width="18%" height="20" align="left" valign="top">&nbsp;</td>
										<td width="6%" align="left" valign="top">&nbsp;</td>
										<td width="6%" align="left" valign="top">&nbsp;</td>
										<td width="8%" align="left" valign="top">&nbsp;</td>
										<td width="8%" align="left" valign="top">&nbsp;</td>
										<td width="8%" align="left" valign="top">&nbsp;</td>
										<td width="54%" align="center" valign="top">
											<table width="100%" border="0" cellspacing="0"
												cellpadding="0" align="center">
												<tr>
													<td width="25%" height="20" align="center" valign="top">I</td>
													<td width="25%" align="center" valign="top">II</td>
													<td width="25%" align="center" valign="top">III</td>
													<td width="25%" align="center" valign="top">IV</td>
												</tr>
											</table>
										</td>
									</tr>
									<?php  
									if(isset($this->data['drug']) && !empty($this->data['drug']))
									{
			               				$count  = count($this->data['drug']) ;
			               			}else
									{
			               				$count  = 3 ;
			               			}
			               			for($i=0;$i<$count;){
			               				$drugValue= isset($this->data['drug'][$i])?$this->data['drug'][$i]:'' ;
			               				$pack= isset($this->data['drug'][$i])?$this->data['pack'][$i]:'' ;
			               				$modeValue= isset($this->data['mode'][$i])?$this->data['mode'][$i]:'' ;
			               				$tabsPerDayValue= isset($this->data['tabs_per_day'][$i])?$this->data['tabs_per_day'][$i]:'' ;
			               				$tabsFrequency = isset($this->data['tabs_frequency'][$i])?$this->data['tabs_frequency'][$i]:'' ;
			               				$quantity = isset($this->data['quantity'][$i])?$this->data['quantity'][$i]:'' ;

			               				$firstValue= isset($this->data['first'][$i])?$this->data['first'][$i]:'' ;
			               				$secondValue= isset($this->data['second'][$i])?$this->data['second'][$i]:'' ;
			               				$thirdValue = isset($this->data['third'][$i])?$this->data['third'][$i]:'' ;
			               				$forthValue = isset($this->data['forth'][$i])?$this->data['forth'][$i]:'' ;

			               				$first  ='disabled';
			               				$second ='disabled';
			               				$third  = 'disabled';
			               				$forth  ='disabled';
			               				$hourDiff =0;
			               				//set timer
			               				switch($tabsFrequency){
			               					case "OD":
			               						$first ='enabled';
			               						break;
			               					case "BD":
			               						$hourDiff =  12;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						break;
			               					case "TDS":
			               						$hourDiff = 6 ;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						$third = 'enabled';
			               						break;
			               					case "QID":
			               						$hourDiff = 4 ;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						$third = 'enabled';
			               						$forth = 'enabled';
			               						break;
			               					case "HS":
			               						$first ='enabled';
			               						break;
			               					case "Twice a week":
			               						$first ='enabled';
			               						break;
			               					case "Once a week":
			               						$first ='enabled';
			               						break;
			               					case "Once fort nightly":
			               						$first ='enabled';
			               						break;
			               					case "Once a month":
			               						$first ='enabled';
			               						break;
			               					case "A/D":
			               						$first ='enabled';
			               						break;
			               				}
			               				//EOF timer

			               				?>
									<tr id="DrugGroup<?php echo $i;?>">
										<td align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text' ,'class' => 'drugText','id'=>"drug$i",'name'=> 'drug[]','value'=>$drugValue,'counter'=>$i)); ?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text' ,'class' => 'drugPack','class' => 'validate[optional,custom[onlyLetterNumber]]','id'=>"Pack$i",'name'=> 'Pack[]','value'=>$pack ,'counter'=>$i,'size'=>5)); ?>
										</td>
										<td align="left" valign="top"><?php  
										$routes_options = array('IV'=>'IV','IM'=>'IM','S/C'=>'S/C','P.O'=>'P.O','P.R'=>'P.R','P/V'=>'P/V','R.T'=>'R.T','LA'=>'LA');
										  		echo $this->Form->input('', array('options'=>$routes_options,'style'=>"width:80px;",'empty'=>'Select','class' => '','id'=>"mode$i",'name' => 'mode[]','value'=>$modeValue)); ?>
										</td>
										<td align="left" valign="top"><?php
										$fre_options = array('SOS'=>'SOS','OD'=>'OD','BD'=>'BD','TDS'=>'TDS','QID'=>'QID','HS'=>'HS','Twice a week' => 'Twice a week', 'Once a week'=>'Once a week', 'Once fort nightly'=>'Once fort nightly', 'Once a month'=>'Once a month', 'A/D'=>'A/D');
										  		echo $this->Form->input('', array('options'=> $fre_options, 'empty'=>'Select','class'=>'frequency','id'=>"tabs_frequency_$i",'name' => 'tabs_frequency[]','value'=>$tabsFrequency)); ?>
										</td>
										<td align="left" valign="top"><?php											  	
										  		echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => 'validate[optional,custom[integer]]','id'=>"quantity$i",'name' => 'quantity[]','value'=>$quantity)); ?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text','size'=>2,'class' => 'validate[optional,custom[integer]]','id'=>"tabs_per_day$i",'name' => 'tabs_per_day[]','value'=>$tabsPerDayValue)); ?>
										</td>
										<td align="left" valign="top"><?php
										$timeArr = array('1'=>'1am','2'=>'2am','3'=>'3am','4'=>'4am','5'=>'5am','6'=>'6am','7'=>'7am','8'=>'8am','9'=>'9am','10'=>'10am','11'=>'11am','12'=>'12am',
			               							 				   '13'=>'1pm','14'=>'2pm','15'=>'3pm','16'=>'4pm','17'=>'5pm','18'=>'6pm','19'=>'7pm','20'=>'8pm','21'=>'9pm','22'=>'10pm','23'=>'11pm','24'=>'12pm' );
			               							  $disabled = 'disabled';
			               							  ?>
											<table width="100%" border="0" cellspacing="0"
												cellpadding="0" align="center">
												<tr>
													<td width="25%" height="20" align="center" valign="top"><?php
													echo $this->Form->input('first_time', array($first,'style'=>'width:60%;','id'=>"first_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'','class' => 'first' , 'label'=> false,
							 					  	   'div' => false,'error' => false,'value'=>$firstValue));
													  ?>
													</td>
													<td width="25%" align="center" valign="top"><?php
													echo $this->Form->input('second_time', array($second,'style'=>'width:60%;','id'=>"second_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'' , 'label'=> false,
							 					  	   'div' => false,'error' => false ,'class'=>'second','value'=>$secondValue));
													  ?>
													</td>
													<td width="25%" align="center" valign="top"><?php
													echo $this->Form->input('third_time', array($third,'style'=>'width:60%;','id'=>"third_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'','class' => 'third' , 'label'=> false,
							 					  	   'div' => false,'error' => false,'value'=>$thirdValue));
													  ?>
													</td>
													<td width="25%" align="center" valign="top"><?php
													echo $this->Form->input('forth_time', array($forth,'style'=>'width:60%;','id'=>"forth_$i",'name' => "drugTime[$i][]",'style'=>'width:80px','options'=>$timeArr,'empty'=>'' , 'label'=> false,
							 					  	   'div' => false,'error' => false ,'class'=>'forth','value'=>$forthValue));
													  ?>
													</td>
												</tr>
											</table>
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
							<td align="right" colspan="5"><input type="button" id="addButton"
								value="Add"> <?php if($count > 0){?> <input type="button"
								id="removeButton" value="Remove"> <?php }else{ ?> <input
								type="button" id="removeButton" value="Remove"
								style="display: none;"> <?php } ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
	</div>
	<h3 style="display: &amp;amp;">
		<a href="#">Significant History</a>
	</h3>
	<div style="display:<?php echo $display ;?>" class="section">
			
			
			<table class="tdLabel" style="text-align: left;">
			<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
					style="padding-top: 10px;">Past Medical History</td>
					<td colspan="4" style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
								<tr>
								<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm"  class="tdLabel">
								<tr>
									<td valign="top" width="24%" align="left"><?php echo __('Illness');?></td>
									<td valign="top" width="20%" align="left" style="padding-left: 30px"><?php echo __('Status');?></td>
									<td valign="top" width="25%" align="left" ><?php echo __('Duration(in years)');?></td>
									<td valign="top" width="25%" align="left" style="padding-left: 10px"><?php echo __('Comments');?></td>
								</tr>
								</table>
								</td>	
								</tr>
								
								<tr>
								<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm" id='DrugGroup_history' class="tdLabel">
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
								
									<td valign="top"  align="left"><a href="javascript:icdwin1('illness<?php echo $i?>')"><?php echo $this->Form->input('', array('type'=>'text','class' => 'textBoxExpnd','id' =>"illness$i",'value'=>$illness_val,'name'=>'PastMedicalHistory[illness][]',style=>'width:230px','counter_history'=>$i)); ?></a></td>
									<td class="tdLabel"  align="left"><?php $options = array(''=>'Please Select','Chronic'=>'Chronic','Existing'=>'Existing','New_on_set'=>'New On Set','Recovered'=>'Recovered','Acute'=>'Acute','Inactive'=>'Inactive');
									echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"status$i",'name' =>'PastMedicalHistory[status][]',style=>'width:150px','value'=>$status_val)); ?></td>
									<td class="tdLabel"  align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'textBoxExpnd','id' =>"duration$i",'value'=>$duration_val,'name'=>'PastMedicalHistory[duration][]',style=>'width:230px','counter_history'=>$i)); ?></td>
									<td class="tdLabel"  align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'textBoxExpnd','id' =>"comment$i",'value'=>$comment_val,'name'=>'PastMedicalHistory[comment][]',style=>'width:230px','counter_history'=>$i)); ?></td>
								</tr>
								<?php
									$i++ ;
			               			}
			               			?>
								
								</table>
								</td>
								</tr>
								
								<tr>
                            	<td align="right" colspan="4"><input type="button" id="addButton_history" value="Add">
									 <?php if($count_history > 0)
                                     {?> 											
                                     <input type="button" id="removeButton_history" value="Remove"> 
                                     <?php }
                                     else{ ?>
                                      <input type="button" id="removeButton_history" value="Remove" style="display: none;"> 
                                      <?php } ?>
								</td>
							</tr>
								<tr>
								<td>
								<table>
								
								<tr>
								<td class="tdLabel" valign="top" width="25%" align="left"  ><?php echo __('Preventive Care : '); ?></td>
								<td class="tdLabel" valign="top" width="75%" align="left"  ><?php  echo $this->Form->input('preventive_care', array('class' =>'textBoxExpnd','id' =>'preventive_care','value'=>$getpatient[0][PastMedicalRecord][preventive_care],'style'=>'width:250px')); ?></td>
								</tr>
								</table>
								</td>
								</tr>
			
								</table>
							</td>
						</tr>
						<tr>
							<td width="19%" valign="top" class="tdLabel" id="boxSpace"
								style="padding-top: 10px;">Family History</td>
							<td colspan="4" style="" width="100%">
								<table width="100%" border="0" cellspacing="1" cellpadding="0"
									class="tabularForm">
									<tr>
										<td>Relation</td>
										<td>Problem</td>
										<td>Status</td>
										<td>Comments</td>
									</tr>
									<tr>
										<td width=20%><?php echo __('Father'); ?>
										</td>
										<td class="tdLabel" id="boxSpace"><a
											href="javascript:icdwin1('father')"> <?php  echo $this->Form->input('problemf', array('class' =>'textBoxExpnd','id' =>'father','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemf])); ?>
										</a>
										</td>
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('statusf',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusf],'id' => 'Statusfather')); ?>
										
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('commentsf', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsf])); ?>
										</td>
									</tr>
									<tr>
										<td width=20%><?php echo __('Mother'); ?>
										</td>
										<td class="tdLabel" id="boxSpace"><a
											href="javascript:icdwin1('mother')"><?php  echo $this->Form->input('problemm', array('class' =>'textBoxExpnd','id' =>'mother','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemm])); ?>
										</a>
										</td>
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('statusm',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusm],'id' => 'Statusmother')); ?>
										
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('commentsm', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsm])); ?>
										</td>
									</tr>
									<tr>
										<td width=20%><?php echo __('Brother'); ?>
										</td>
										<td class="tdLabel" id="boxSpace"><a
											href="javascript:icdwin1('brother')"><?php  echo $this->Form->input('problemb', array('class' =>'textBoxExpnd','id' =>'brother','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemb])); ?>
										</a>
										</td>
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('statusb',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusb],'id' => 'Statusbrother')); ?>
										
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('commentsb', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsb])); ?>
										</td>
									</tr>
									<tr>
										<td width=20%><?php echo __('Sister'); ?>
										</td>
										<td class="tdLabel" id="boxSpace"><a
											href="javascript:icdwin1('sister')"><?php  echo $this->Form->input('problems', array('class' =>'textBoxExpnd','id' =>'sister','value'=>$getpatientfamilyhistory[0][FamilyHistory][problems])); ?>
										</a>
										</td>
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('statuss',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statuss],'id' => 'Statussister')); ?>
										
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('commentss', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentss])); ?>
										</td>
									</tr>
									<tr>
										<td width=20%><?php echo __('Son'); ?>
										</td>
										<td class="tdLabel" id="boxSpace"><a
											href="javascript:icdwin1('son')"> <?php  echo $this->Form->input('problemson', array('class' =>'textBoxExpnd','id' =>'son','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemson],'')); ?>
										</a>
										</td>
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('statusson',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusson],'id' => 'Statusson')); ?>
										
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('commentsson', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsson])); ?>
										</td>
									</tr>
									<tr>
										<td width=20%><?php echo __('Daughter'); ?>
										</td>
										<td class="tdLabel" id="boxSpace"><a
											href="javascript:icdwin1('daughter')"> <?php  echo $this->Form->input('problemd', array('class' =>'textBoxExpnd','id' =>'daughter','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemd],'')); ?>
										</a>
										</td>
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('statusd',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusd],'id' => 'Statusdaughter')); ?>
										
										<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('commentsd', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsd])); ?>
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
            	<td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top: 10px;">Obstetric History</td>
                 <td style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm"  class="tdLabel">
						<tr>
							<td width="25%" class="tdLabel"><?php echo __('Age Onset of Menses:'); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('age_menses', array('class' => 'textBoxExpnd','id' =>'age_menses','value'=>$getpatient[0][PastMedicalRecord][age_menses],'style'=>'width:70px')); ?><font color="#FFFFFF">&nbsp;Years</font>
							</td>
						</tr>
                        
                        <tr>
                        
                        	
							<td width="25%" class="tdLabel"><?php echo __('Length of Periods: '); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('length_period', array('class' => 'textBoxExpnd','id' =>'length_period','value'=>$getpatient[0][PastMedicalRecord][length_period],'style'=>'width:70px')); ?><font color="#FFFFFF">&nbsp;Days</font>
							</td>
						</tr>
                        
                        <tr>
							<td width="25%" class="tdLabel"><?php echo __('Number of days between Periods: '); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('days_betwn_period', array('class' => 'textBoxExpnd','id' =>'days_betwn_period','value'=>$getpatient[0][PastMedicalRecord][days_betwn_period],'style'=>'width:70px')); ?><font color="#FFFFFF">&nbsp;Days</font>
							</td>
						</tr>
                        
                        <tr>
							<td width="25%" class="tdLabel"><?php echo __('Any recent changes in Periods: '); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php  $option_Periods = array(''=>'Please Select','Yes'=>'Yes','No'=>'Not Currently');
								echo $this->Form->input('Diagnosis.recent_change_period', array( 'options'=>$option_Periods,'style'=>'width:150px','class' => '','id'=>"recent_change_period",'value'=>$getpatient[0][PastMedicalRecord][recent_change_period])); ?></td>
                          
						</tr>
                        
                        <tr>
							<td width="25%" class="tdLabel"><?php echo __('Age at Menopause: '); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('age_menopause', array('class' => 'textBoxExpnd','id' =>'age_menopause','value'=>$getpatient[0][PastMedicalRecord][age_menopause],'style'=>'width:70px')); ?><font color="#FFFFFF">&nbsp;Years</font>
							</td>
						</tr>
                     </table>
                 </td>  
            </tr>
            
             <tr>
            <td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top: 10px;"></td>
            <td width="100%" valign="top" class="tdLabel" id="boxSpace" style="padding-top: 10px;"><b>Number of Pregnancies:</b></td>
            </tr>
            
            <tr>
            	<td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top: 10px;"></td>
                <td style="" width="100%">
                	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" class="tdLabel">
                            <tr> 
                            <td colspan="7">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm"  class="tdLabel">
                            <tr>
                                <td width="10%" height="20px" align="left" valign="top">Sr. No.</td>
                                <td width="10%" height="20px" align="left" valign="top">DOB</td>
                                <td width="8%" height="20px" align="left" valign="top">Weight (in lbs)</td>
                                <td width="9%" height="20px" align="left" valign="top">Baby's Gender</td>
                                <td width="9%" height="20px" align="left" valign="top">Weeks Pregnant</td>
                                <td width="10%" height="20px" align="left" valign="top">Type of Delivery</td>
                                <td width="10%" height="20px" align="left" valign="top">Complications</td>
                               </tr>
                             </table>
                            </td>
                            </tr>
                            
                            <tr>
                            <td colspan="7">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm" id='DrugGroup_nw' class="tdLabel">
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
                             
                                <td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"counts$i",'value'=>$counts_val,'name'=>'pregnancy[counts][]',style=>'width:70px','counter_nw'=>$i)); ?></td>
                                
                                <td width="12%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text','id' => "date_birth$i",'class'=>'date_birth','name'=>'pregnancy[date_birth][]','value'=>$date_birth_val,'style'=>'width:130px','counter_nw'=>$i)); ?></td>
                                
                                <td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"weight$i",'value'=>$weight_val,'name'=>'pregnancy[weight][]',style=>'width:70px','counter_nw'=>$i)); ?></td>
                                
                                <td width="10%" height="20px" align="left" valign="top"><?php  $options = array(''=>'Please Select','M'=>'Male','F'=>'Female');
								echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:100px','class' => '','id'=>"baby_gender$i",'name' => 'pregnancy[baby_gender][]','value'=>$baby_gender_val)); ?></td>
                                
                                <td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"week_pregnant$i",'value'=>$week_pregnant_val,'name'=>'pregnancy[week_pregnant][]','style'=>'width:70px','counter_nw'=>$i)); ?></td>
                                
                                <td width="10%" height="20px" align="left" valign="top"><?php  $delivery_options = array(''=>'Please Select','Episiotomy'=>'Vaginal Delivery-Episiotomy','Induced_labor'=>'Vaginal Delivery-Induced labor','Forceps_delivery'=>'Vaginal Delivery -Forceps delivery','Vacuum_extraction'=>'Vaginal Delivery-Vacuum extraction','Cesarean'=>'Cesarean section');
                                echo $this->Form->input('', array('options'=>$delivery_options ,'class' =>'textBoxExpnd','id'=>"type_delivery$i",'value'=>$type_delivery_val,'name'=>'pregnancy[type_delivery][]','style'=>'width:130px','counter_nw'=>$i)); ?></td>
                                
                                <td width="10%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"complication$i",'value'=>$complication_val,'name'=>'pregnancy[complication][]','style'=>'width:100px','counter_nw'=>$i)); ?></td>
                            </tr>
                             <?php
									$i++ ;
			               			}
			               			?>
                            </table>
                            </td>
                            </tr>
                            
                            <tr>
                            	<td align="right" colspan="7"><input type="button" id="addButton_nw" value="Add">
									 <?php if($count_nw > 0)
                                     {?> 											
                                     <input type="button" id="removeButton_nw" value="Remove"> 
                                     <?php }
                                     else{ ?>
                                      <input type="button" id="removeButton_nw" value="Remove" style="display: none;"> 
                                      <?php } ?>
								</td>
							</tr>
                            
                            <tr>
								<td width="25%" class="tdLabel"><?php echo __('Abortions. Still Births. Miscarriages: '); ?></td>
								<td width="60%" colspan="6" class="tdLabel" ><?php  echo $this->Form->input('abortions_miscarriage', array('class' =>'textBoxExpnd','id' =>'abortions_miscarriage','value'=>$getpatient[0][PastMedicalRecord][abortions_miscarriage],'style'=>'width:250px')); ?></td>
							</tr>
                            
                     </table> 
                        
                </td>
            </tr>
            
            
            
            <tr>
            	<td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top: 10px;">Gynecology History</td>
                <td style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" class="tabularForm" id='DrugGroup' class="tdLabel">
						<tr>
							<td width="25%" class="tdLabel"><?php echo __('Present Symptoms:'); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['present_symptom']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				
                        				echo $this->Form->radio('present_symptom', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['present_symptom'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>
                        
                        <tr>
							<td width="25%" class="tdLabel"><?php echo __('Past Infections: '); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['past_infection']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				
                        				echo $this->Form->radio('past_infection', array('None'=>'None','Chlamydia'=>'Chlamydia','Syphilis'=>'Syphilis','PID'=>'PID','Gonorrhea'=>'Gonorrhea','Other STD'=>'Other STD'),array('value'=>$getpatient[0]['PastMedicalRecord']['past_infection'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>
                        
                        <tr>
							<td width="25%" class="tdLabel">History of abnormal <font class="tooltip" title="Papanicolaou smear">PAP smear</font>:</td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hx_abnormal_pap']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				
                        				echo $this->Form->radio('hx_abnormal_pap', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_abnormal_pap'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>
                        
                        <tr>
							<td width="25%" class="tdLabel"><?php echo __('History of cervical biopsy: '); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hx_cervical_bx']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				
                        				echo $this->Form->radio('hx_cervical_bx', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_cervical_bx'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>
                        
                        <tr>
							<td width="25%" class="tdLabel"><?php echo __('History of fertility drugs: '); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hx_fertility_drug']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				
                        				echo $this->Form->radio('hx_fertility_drug', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_fertility_drug'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>
                        
                        <tr>
							<td width="25%" class="tdLabel">History of <font class="tooltip" title="Hormone Replacement Therapy "> HRT </font> use:</td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hx_hrt_use']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				
                        				echo $this->Form->radio('hx_hrt_use', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_hrt_use'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>
                        
                         <tr>
							<td width="25%" class="tdLabel"><?php echo __('History of irregular menses: '); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['hx_irregular_menses']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				
                        				echo $this->Form->radio('hx_irregular_menses', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_irregular_menses'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>
                        
                         <tr>
							<td width="25%" class="tdLabel"><font class="tooltip" title="Last Menstrual Period "> L.M.P. </font>:</td>
							<?php $getpatient[0]['PastMedicalRecord']['lmp'] = $this->DateFormat->formatDate2Local($getpatient[0]['PastMedicalRecord']['lmp'],Configure::read('date_format'),true); ?>
							<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('lmp', array('type'=>'text','id' =>'lmp','class'=>'textBoxExpnd','value'=>$getpatient[0]['PastMedicalRecord']['lmp'],'style'=>'width:120px')); ?>
							</td>
						</tr>
                        
                         <tr>
							<td width="25%" class="tdLabel">Symptoms since <font class="tooltip" title="Last Menstrual Period "> L.M.P. </font>:</td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
							if($this->data['PastMedicalRecord']['symptom_lmp']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				
                        				echo $this->Form->radio('symptom_lmp', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['symptom_lmp'],'legend'=>false,'label'=>false));
                        			 ?>
							</td>
						</tr>
                        
                     </table>
                 </td>  
            </tr>
            
             <tr>
            <td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top: 10px;"></td>
            <td width="100%" valign="top" class="tdLabel" id="boxSpace" style="padding-top: 10px;"><b>Sexual Activity:</b></td>
            </tr>
            <tr>
            	<td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top: 10px;"></td>
            	<td style="" width="100%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" id='DrugGroup' class="tdLabel">
						<tr>
							<td width="25%" class="tdLabel"><?php echo __('Are you sexually active?'); ?></td>
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
							<td width="25%" class="tdLabel"><?php echo __('Do you use birth control?'); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
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
							<td width="25%" class="tdLabel"><?php echo __('Do you do regular Breast self-exam?'); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
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
							<td width="25%" class="tdLabel"><?php echo __('New Partners? '); ?></td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
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
							<td width="25%" class="tdLabel"><?php echo __('Partner Notification '); ?></td>
							
							<td width="60%" class="tdLabel" id="boxSpace"><?php 
                        			 
							if($getpatient[0]['PastMedicalRecord']['partner_notification'] == 1){
								echo $this->Form->checkbox('partner_notification', array('checked' => 'checked'));
							}else{
								echo $this->Form->checkbox('partner_notification');
							}
							
							
							//echo $this->Form->checkbox('partner_notification',array('name'=>'1'));?>
							
							
							</td>
						</tr>
                        
                         <tr>
							<td width="25%" class="tdLabel"><font class="tooltip" title="Human Immunodeficiency Virus"> HIV </font> Education Given:</td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
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
							<td width="25%" class="tdLabel"><font class="tooltip" title="Papanicolaou"> PAP </font>/<font class="tooltip" title="Sexually Transmitted Diseases"> STD </font> Education Given:</td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
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
							<td width="25%" class="tdLabel"><font class="tooltip" title="Gynecology"> GYN </font> Referral:</td>
							<td width="60%" class="tdLabel" id="boxSpace"><?php
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
             
			            
			    	
						<tr>
							<td width="19%" valign="top" class="tdLabel" id="boxSpace"
								style="padding-top: 10px;">Social History</td>
							<td colspan="4" style="" width="100%">
								<table width="100%" border="0" cellspacing="1" cellpadding="0"
									class="tabularForm">
									<?php if($patient['Patient']['age']>=18){?>
									<tr>
									<td valign="top" width="120" colspan='5' style="color:fuchsia;"'>Have you screened for tobbaco use?</td>
									</tr>
									<?php }?>
									<tr>
										<td valign="top" width="120">Smoking</td>
										<td valign="top" width="120"><?php 
										if($this->data['PatientPersonalHistory']['smoking']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$smokingPersonalVal = isset($this->data['PatientPersonalHistory']['smoking'])?$this->data['PatientPersonalHistory']['smoking']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.smoking', array('No','Yes'),array('value'=>$smokingPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal1','id' => 'smoking'));
			                        				
			                        			 ?>
										</td>
										<td valign="top"><?php 	
										echo $this->Form->input('PatientPersonalHistory.smoking_desc',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'smoking_desc'));
									 ?>
										</td>
			
										<td valign="top"><?php 
										echo $this->Form->input('PatientSmoking.patient_id',array('type'=>'hidden','value'=>$patient_id,'legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince '.$class,'id' => ''));
			
										echo $this->Form->input('PatientSmoking.smoking_fre',array('type'=>'hidden','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince ','id' => ''));
			
										echo $this->Form->input('SmokingStatusOncs.description',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => ''));//echo'to';
			
										echo $this->Form->input('PatientSmoking.current_smoking_fre',array('type'=>'hidden','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince ','id' => ''));
										echo $this->Form->input('SmokingStatusOncs1.description',array('type'=>'text','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince '.$class,'id' => ''));
										echo $this->Form->input('PatientSmoking.smoking_fre2',array('type'=>'hidden','legend'=>false,'label'=>false,
										'class' => 'textBoxExpnd removeSince ','id' => 'smoking_fre_id'));
				                        			 ?>
										</td>
										<td valign="top"><?php 	
			
										echo $this->Form->input('PatientPersonalHistory.smoking_fre',array('type' => 'select', 'id' => 'smoking_fre', 'class' => 'removeSince', 'empty' => 'Please Select', 'options'=> $smokingOptions, 'label'=> false, 'div'=> false, 'style' => 'width:150px','onChange'=>'javascript:getSmokingDetails()'));
										?><span><label id="smoking_info" style="cursor: pointer; text-decoration:underline; display:none;"   ><?php echo __('Fill information');?></label></span>
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
			                        				$alcoholPersonalVal = isset($this->data['PatientPersonalHistory']['alcohol'])?$this->data['PatientPersonalHistory']['alcohol']:2;
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
										echo $this->Form->input('PatientPersonalHistory.alcohol_fre',array('type' => 'select', 'id' => 'alcohol_fre', 'class' => 'removeSince', 'empty' => 'Please Select', 'options'=> $alcoholoption, 'label'=> false, 'div'=> false, 'style' => 'width:150px'));
										?><span><label id="alcohol_fill" style="cursor: pointer; text-decoration:underline; display:none;"><?php echo __('Fill information');?></label></span>
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
										<td valign="top"><?php 
										echo $this->Form->input('PatientPersonalHistory.drugs_fre',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'drug_fre'));
										?>
										</td>
										<td>&nbsp;</td>
									</tr>
									
									<tr>
										<td valign="top">Retired</td>
										<td valign="top"><?php 
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
										<td valign="top">Caffiene Usage</td>
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
										<td valign="top"><?php	
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
							<td width="19%" valign="top" class="tdLabel" id="boxSpace"
								style="padding-top: 10px;">&nbsp;</td>
							<td width="" valign="top">&nbsp;</td>
						</tr>
						
				<tr>
            	<td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top: 10px;">Surgical / Hospitalization History</td>
                <td style="" width="100%">
                	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" class="tdLabel">
                            <tr> 
                            <td colspan="7">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm"  class="tdLabel">
                            <tr>
                                <td width="1%" height="20px" align="left" valign="top">Surgical/Hospitalization</td>
                                <td width="6%" height="20px" align="left" valign="top">Provider</td>
                                <td width="10%" height="20px" align="left" valign="top" style="padding-left: 75px">Age</td>
                                <td width="5%" height="20px" align="left" valign="top">Date</td>
                                <td width="9%" height="20px" align="left" valign="top" style="padding-left: 15px">Comment</td>
                               </tr>
                             </table>
                            </td>
                            </tr>
                            
                            <tr>
                            <td colspan="7">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm" id='DrugGroup_procedure' class="tdLabel">
                             <?php  
                            		if(isset($procedureHistory) && !empty($procedureHistory))
									{
			               				$count_procedure  = count($procedureHistory);
			               			}else
									{
			               				$count_procedure  = 3 ;
			               			}
			               			for($i=0;$i<$count_procedure;)	               				
									{ 
										
										$procedureHistory[$i]['ProcedureHistory']['procedure_date'] = $this->DateFormat->formatDate2Local($procedureHistory[$i]['ProcedureHistory']['procedure_date'],Configure::read('date_format'),true);
										$procedure_val = isset($procedureHistory[$i]['ProcedureHistory']['procedure'])?$procedureHistory[$i]['ProcedureHistory']['procedure']:'' ;
										$provider_val = isset($procedureHistory[$i]['ProcedureHistory']['provider'])?$procedureHistory[$i]['ProcedureHistory']['provider']:'' ;
										$age_value_val = isset($procedureHistory[$i]['ProcedureHistory']['age_value'])?$procedureHistory[$i]['ProcedureHistory']['age_value']:'' ;
										$age_unit_val = isset($procedureHistory[$i]['ProcedureHistory']['age_unit'])?$procedureHistory[$i]['ProcedureHistory']['age_unit']:'' ;
										$procedure_date_val = isset($procedureHistory[$i]['ProcedureHistory']['procedure_date'])?$procedureHistory[$i]['ProcedureHistory']['procedure_date']:'' ;
										$comment_val = isset($procedureHistory[$i]['ProcedureHistory']['comment'])?$procedureHistory[$i]['ProcedureHistory']['comment']:'' ;
										 
										
										?>
										                            
                             <tr id="DrugGroup_procedure<?php echo $i;?>">
                             
                                <td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' => "procedure",'id'=>"procedure$i",'value'=>$procedure_val,'name'=>'ProcedureHistory[procedure][]',style=>'width:150px','counter_procedure'=>$i)); ?></td>
                                
                                <td width="12%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text','class' =>'textBoxExpnd provider','id' => "provider$i",'name'=>'ProcedureHistory[provider][]','value'=>$provider_val,'style'=>'width:150px','counter_procedure'=>$i)); ?></td>
                                
                                <td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"age_value$i",'value'=>$age_value_val,'name'=>'ProcedureHistory[age_value][]','style'=>'width:50px','counter_procedure'=>$i)); ?></td>
                                
                                <td width="10%" height="20px" align="left" valign="top"><?php  $options = array(''=>'Please Select','Days'=>'Days','Months'=>'Months','Years'=>'Years');
								echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:120px','class' => '','id'=>"age_unit$i",'name' => 'ProcedureHistory[age_unit][]','value'=>$age_unit_val)); ?></td>
                                
                                <td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text','id'=>"procedure_date$i",'class'=>"procedure_date",'name'=>'ProcedureHistory[procedure_date][]','value'=>$procedure_date_val,'style'=>'width:110px','counter_procedure'=>$i)); ?></td>
                                
                                <td width="10%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"comment$i",'value'=>$comment_val,'name'=>'ProcedureHistory[comment][]','style'=>'width:220px','counter_procedure'=>$i)); ?></td>
                            </tr>
                             <?php
									$i++ ;
			               			}
			               			?>
                            </table>
                            </td>
                            </tr>
                            
                            <tr>
                            	<td align="right" colspan="7"><input type="button" id="addButton_procedure" value="Add">
									 <?php if($count_procedure > 0)
                                     {?> 											
                                     <input type="button" id="removeButton_procedure" value="Remove"> 
                                     <?php }
                                     else{ ?>
                                      <input type="button" id="removeButton_procedure" value="Remove" style="display: none;"> 
                                      <?php } ?>
								</td>
							</tr>
                            
                     </table> 
                        
                </td>
            </tr>
				
		</table>
	</div>
	<!--	 EOF current treatment  -->
	<!-- BOF physical examination -->
	<h3>
		<a href="#">Physical Examination</a>
	</h3>
	<div class="section" id="examine">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<!--BOF templates for examination -->
			<tr>
				<!--<td width="27%" valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">Vital Signs:</td>				 		
				 		-->
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
									<a href="javascript:void(0);" onclick="callDragon('general_examine')" style="text-align:left;"><font color="white">Use speech recognition</font> </a>
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
			<!--  height/ weight  -->
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
			</tr>-->
			<!--  height/ weight  -->
		</table>
	</div>
	<!-- EOF physical examination -->
	<h3>
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
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('final_diagnosis', array('class' => 'textBoxExpnd','id' =>'final_diagnosis','style'=>'width:98%','rows'=>18)); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="27%" align="left" valign="top">ICD Code</td>
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

							echo $this->Form->input('ICD_code',array('type'=>'hidden','id'=>'icd_ids'));


							if(empty($this->data['Diagnosis']['ICD_code'])){
			              	  				$displayICD ="none";
			              	  			}else{
			              	  				$displayICD ="block";
			              	  			}
			              	  			?>
								<div id="icdSlc" style="display: <?php echo $displayICD ;?>">

									<?php               	  			 
									$noOfIds =  count($icd_ids);
									echo $this->Form->input('ICD_code_count',array('type'=>'hidden','id'=>'icd_ids_count','value'=>$noOfIds));

									for($k=0;$k<$noOfIds;){
			              	  					$id = $icd_ids[$k]['icd']['id'] ;
			              	  					echo "<p id="."icd_".$id." style='padding:0px 10px;'>";
			              	  					echo $icd_ids[$k]['icd']['icd_code']."::".$icd_ids[$k]['icd']['description'];
			              	  					echo $this->Html->image('/img/icons/cross.png',array("align"=>"right","id"=>"ers_$id","onclick"=>"javascript:remove_icd(\"".$id."\");","title"=>"Remove"
			              	  			                                ,"style"=>"cursor: pointer;","alt"=>"Remove","class"=>"icd_eraser"));
			              	  			        echo "</p>";
			              	  			        $k++ ;
			              	  				}

			              	  				?>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td>&nbsp;</td>
			</tr>

		</table>
	</div>
	<?php if($display=='none'){ ?>
	<h3>
		<a href="#">Investigation</a>
	</h3>
	<!--
		 	 <div class="section" id="investigation">&nbsp;</div>
		 	  -->
	<div class="section" id="investigation">
		<div id="templateArea-investigation"></div>
	</div>


	<?php }		 
	if($patient['Patient']['admission_type']=='OPD'){
     			$planCareText  = "Plan of care during Hospitalization";
     			$surgeryText = 'Surgical History';
     		}else{
     			$planCareText  = "Plan of care";
     			$surgeryText = 'Procedure if any';
     		}
     		?>

	<!-- EOF final diagnosis and ICD Code -->
	<h3>
		<a href="#"><?php echo $surgeryText ;?> </a>
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
							</td>
							<td height="25" valign="middle" class="tdLabel1" id="boxSpace"><?php //echo __('ICD Code') ;?>
							</td>
							<td align="left" valign="top"><?php
							echo $this->Html->link($this->Html->image('icons/search_icon.png'),'#',array('escape'=>false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'icd'))."', '_blank',
							           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=800,left=200,top=200');  return false;"));
							?>
							</td>
							<td width="30" align="left">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!-- BOF register notes -->
	<h3 style="display: &amp;amp;">
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
	</div>
	<!-- EOF register notes -->
	<!-- BOF consultants opinion -->
	<h3>
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
	</div>
	<!-- EOF consultants opinion -->
	<!-- BOF plan care -->

	<h3>
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
	</div>
	<!-- EOD plan care -->
	<!-- BOF Investigation -->
	<h3 style="display: &amp;amp;" id="invi">
		<a href="#">Investigation</a>
	</h3>
	<div class="section" id="investigation">
		<div id="templateArea-investigation"></div>
	</div>
	<h3 style="display: &amp;amp;">
		<a href="#">Investigation Dashboard</a>
	</h3>
	<div class="section" id="investigationDashboard">
		<div id="templateArea-investigationDashboard"></div>
	</div>
	<h3 style="display: &amp;amp;">
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
		<!--	<div id="templateArea-ManualLAb"></div> -->
	</div>

	<h3 style="display: &amp;amp;">
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
		<!--	<div id="templateArea-ManualLAb"></div> -->
	</div>
</div>
</div>
<!-- EOF accordion -->
<div class="btns">
	<?php echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false,'id'=>'submit_diagno')); ?>
	<?php  echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false)); ?>
</div>
<?php echo $this->Form->end();

?>

<?php
if(empty($reportMonth)) {
               // echo $this->Form->create('Reports',array('action'=>'hai_reports_chart','type'=>'post', 'id'=> 'showcharfrm', 'style'=> 'float:left;'));
		echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportType', 'value' =>$reportType));
		echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportMonth', 'value' =>$reportMonth));
		echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));
		//echo $this->Form->end();
    }
    ?>
<!-- Right Part Template ends here -->

<script>
$(document).ready(function(){  	

	
		
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
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'diagnoses', "action" => "investigation",$patient['Patient']['id'],"admin" => false)); ?>";
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
 

			
			 $('.drugText').live('focus',function()
			  {   
			  		var counter = $(this).attr("counter");
			  		if($(this).val()==""){
			  			$("#Pack"+counter).val("");
			  		}
				    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>", {
						width: 250,
						 selectFirst: false,
						 
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
				 
					if($(this).val() =='1'){
						$('#'+lowercase+'_desc').fadeIn('slow');	
						$('#'+lowercase+'_desc').val('Since');			 
						$('#'+lowercase+'_fre').fadeIn('slow');	
						$('#'+lowercase+'_fre').val('Frequency');
					}else{
						$('#'+lowercase+'_desc').fadeOut('slow');
						$('#'+lowercase+'_fre').fadeOut('slow');
					}
				});
				$('.personal1:radio').click(function(){
					 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;				 
					 var lowercase = textName.toLowerCase();
				 
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
						$('#'+lowercase+'_fre').val('Frequency');
					}else{
						$('#'+lowercase+'_desc').fadeOut('slow');
						$('#'+lowercase+'_info').fadeOut('slow');
						$('#'+lowercase+'_fill').fadeOut('slow');
						$('#'+lowercase+'_fre').fadeOut('slow');
						$('#'+lowercase+'_smoke_fill').fadeOut('slow');
						$('#'+lowercase+'_alco_info').fadeOut('slow');
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
		 
		    $("#addButton").click(function () {		 				 
				/*if(counter>10){
			            alert("Only 10 textboxes allow");
			            return false;
				}  */
				$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup' + counter);
				  
				var route_option = '<select id="mode'+counter+'" style="width:80px" class="" name="mode[]"><option value="">Select</option><option value="IV">IV</option><option value="IM">IM</option><option value="S/C">S/C</option><option value="P.O">P.O</option><option value="P.R">P.R</option><option value="P/V">P/V</option><option value="R.T">R.T</option><option value="LA">LA</option></select>';
				var fre_option = '<select id="tabs_frequency_'+counter+'"  class="frequency" name="tabs_frequency[]"><option value="">Select</option><option value="SOS">SOS</option><option value="OD">OD</option><option value="BD">BD</option><option value="TDS">TDS</option><option value="QID">QID</option><option value="HS">HS</option><option value="Twice a week">Twice a week</option><option value="Once a week">Once a week</option><option value="Once fort nightly">Once fort nightly</option><option value="Once a month">Once a month</option><option value="A/D">A/D</option></select>';
				var quality_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
				//BOF timer
				var options = '<option value=""></option>';
				for(i=1;i<25;i++){
					if(i<13){
						str = i+'am';
					}
					else {
						str = (i-12)+'pm';
					}						
					options += '<option value="'+i+'"'+'>'+str+'</option>';
				}
				//EOF Timer
								
				//var timer	= '<td><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="disabled" name="drugTime['+counter+'][]">'+options+'</select><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="disabled" name="drugTime['+counter+'][]">'+options+'</select><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="disabled" name="drugTime['+counter+'][]">'+options+'</select></td>';
				timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';								  
				timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';
				timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';
				timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'+options+'</select></td> ';
				timer = timerHtml1+timerHtml2+timerHtml3+timerHtml4+'</tr></table></td>';
				

				var newHTml =    '<td><input  type="text" value="" id="drug' + counter + '" class=" drugText validate[optional,custom[onlyLetterNumber]] ac_input" name="drug[]" autocomplete="off" counter='+counter+'></td><td><input  type="text" value="" id="Pack' + counter + '"   class=" drugPack validate[optional,custom[onlyLetterNumber]] ac_input" name="Pack[]" autocomplete="off" counter='+counter+' size="5"></td><td>'+route_option+'</td><td>'+fre_option+'</td>'+quality_opt+'<td><input type="text" value="" size="2" id="tabs_per_day'+counter+'" class="" name="tabs_per_day[]"></td>'+timer;
				
				           		 			
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
				var counts = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="counts'+counter_nw+'" class="" style=>"width:70px" name="pregnancy[counts][]"></td>';
				var date_birth = '<td width="20%" height="20px" align="left" valign="top"><input type="text" value="" id="date_birth'+counter_nw+'" class="" style=>"width:120px" name="pregnancy[date_birth][]"></td>';
				var weight = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="weight'+counter_nw+'" class="" style=>"width:70px" name="pregnancy[weight][]"></td>';
				var baby_gender = '<select style="width:100px;" id="baby_gender'+counter_nw+'" class="" name="pregnancy[baby_gender][]"><option value="">Please Select</option><option value="M">Male</option><option value="F">Female</option></select>';
				var week_pregnant = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="week_pregnant'+counter_nw+'" class="" style=>"width:70px" name="pregnancy[week_pregnant][]"></td>';
				var type_delivery = '<select style="width:130px;" id="type_delivery'+counter_nw+'" class="" name="pregnancy[type_delivery][]"><option value="">Please Select</option><option value="Episiotomy">Vaginal Delivery-Episiotomy</option><option value="Induced_labor">Vaginal Delivery-Induced labor</option><option value="Forceps_delivery">Vaginal Delivery-Forceps delivery</option><option value="Vacuum_extraction">Vaginal Delivery-Vacuum extraction</option><option value="Cesarean">Cesarean section</option></select>';
				var complication = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="complication'+counter_nw+'" class="" style=>"width:100px" name="pregnancy[complication][]"></td>';
				'</tr></table></td>';
				
				var newHTml_nw = '<td><input  type="text" style="width:70px" value="" name="pregnancy[counts][]" id="counts' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+'></td><td><input  type="text" style="width:130px" class="date_birth" name="pregnancy[date_birth][]" value="" id="date_birth' + counter_nw + '"  counter_nw='+counter_nw+'></td><td><input  type="text" style="width:70px" value="" name="pregnancy[weight][]" id="weight' + counter_nw + '"  autocomplete="off" counter_nw='+counter_nw+'></td><td>'+baby_gender+'</td><td><input  type="text" style="width:70px" value="" name="pregnancy[week_pregnant][]" id="week_pregnant' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+'></td><td>'+type_delivery+'</td><td><input  type="text" style="width:100px" value="" name="pregnancy[complication][]" id="complication' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+'></td>';
				
				newCostDiv_nw.append(newHTml_nw);		 
				newCostDiv_nw.appendTo("#DrugGroup_nw");		
				$("#diagnosisfrm").validationEngine('attach'); 			 			 
				counter_nw++;
				if(counter_nw > 0) $('#removeButton_nw').show('slow');
		     });
		 
		     $("#removeButton_nw").click(function () {
							 
					counter_nw--;			 
			 
			        $("#DrugGroup_nw" + counter_nw).remove();
			 		if(counter_nw == 0) $('#removeButton_nw').hide('slow');
			  });
			  //EOF add1 n remove1 drug inputs


			  
			 // Add more for past medical record
			 
			 var counter_history = <?php echo $count_history?>
		 
		    $("#addButton_history").click(function () {		 				 
				
				$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv_history = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup_history' + counter_history);

				var illness = '<td width="230px" height="20px" align="left" valign="top"><a href="javascript:icdwin1(\'illness'+counter_history+'\')"><input type="text" value="" id="illness'+counter_history+'" class="" style=>"width:70px" name="PastMedicalHistory[illness][]"></a></td>';
				var status = '<select style="width:150px" id="status'+counter_history+'" class="" name="PastMedicalHistory[status][]"><option value="">Please Select</option><option value="Chronic">Chronic</option><option value="Existing">Existing</option><option value="New_on_set">New On Set</option><option value="Recovered">Recovered</option><option value="Acute">Acute</option><option value="Inactive">Inactive</option></select>';
				var duration = '<td width="230px" height="20px" align="left" valign="top"><input type="text" value="" id="duration'+counter_history+'" class="" style=>"width:70px" name="PastMedicalHistory[duration][]"></td>';
				var comment = '<td width="230px" height="20px" align="left" valign="top"><input type="text" value="" id="comment'+counter_history+'" class="" style=>"width:120px" name="PastMedicalHistory[comment][]"></td>';
				'</tr></table></td>';
				
				var newHTml_history = '<td><a href="javascript:icdwin1(\'illness'+counter_history+'\')"><input  type="text" style="width:230px" value="" name="PastMedicalHistory[illness][]" id="illness' + counter_history + '" autocomplete="off" counter_history='+counter_history+'></a></td><td style="padding-left:15px">'+status+'</td><td style="padding-left:15px"><input  type="text" style="width:230px" value="" name="PastMedicalHistory[duration][]" id="duration' + counter_history + '"  autocomplete="off" counter_history='+counter_history+'></td><td style="padding-left:15px"><input  type="text" style="width:230px" value="" name="PastMedicalHistory[comment][]" id="comment' + counter_history + '"  autocomplete="off" counter_history='+counter_history+'></td>';
				
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
			 var counter_procedure = <?php echo $count_procedure?>
		 
		    $("#addButton_procedure").click(function () {		 				 
				
				$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv_procedure = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup_procedure' + counter_procedure);
				  
				var procedure = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="procedure'+counter_procedure+'" class ="procedure" style=>"width:150px" name="ProcedureHistory[procedure][]"></td>';
				var provider = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="provider'+counter_procedure+'" class="provider" style=>"width:150px" name="ProcedureHistory[provider][]"></td>';
				var age_value = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="age_value'+counter_procedure+'" class="" style=>"width:50px" name="ProcedureHistory[age_value][]"></td>';
				var age_unit = '<select style="width:120px;" id="age_unit'+counter_procedure+'" class="" name="ProcedureHistory[age_unit][]"><option value="">Please Select</option><option value="Days">Days</option><option value="Months">Months</option><option value="Years">Years</option></select>';
				var procedure_date = '<td width="20%" height="20px" align="left" valign="top"><input type="text" value="" id="procedure_date'+counter_procedure+'" class="procedure_date" style=>"width:110px" name="ProcedureHistory[procedure_date][]"></td>';
				var comment = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="comment'+counter_procedure+'" class="" style=>"width:220px" name="ProcedureHistory[comment][]"></td>';
				'</tr></table></td>';
				
				var newHTml_procedure = '<td><input  type="text" style="width:150px" value="" name="ProcedureHistory[procedure][]" id="procedure' + counter_procedure + '" class="procedure" autocomplete="off" counter_procedure='+counter_procedure+'></td><td><input  type="text" style="width:150px" value="" name="ProcedureHistory[provider][]" id="provider' + counter_procedure + '" class="provider" autocomplete="off" counter_procedure='+counter_procedure+'></td><td><input  type="text" style="width:50px" value="" name="ProcedureHistory[age_value][]" id="age_value' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td><td>'+age_unit+'</td><td><input  type="text" style="width:110px" class="procedure_date" name="ProcedureHistory[procedure_date][]" value="" id="procedure_date' + counter_procedure + '"  counter_procedure='+counter_procedure+'></td><td><input  type="text" style="width:220px" value="" name="ProcedureHistory[comment][]" id="comment' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td>';
				
				newCostDiv_procedure.append(newHTml_procedure);		 
				newCostDiv_procedure.appendTo("#DrugGroup_procedure");		
				$("#diagnosisfrm").validationEngine('attach'); 			 			 
				counter_procedure++;
				if(counter_procedure > 0) $('#removeButton_procedure').show('slow');
		     });
		 
		     $("#removeButton_procedure").click(function () {
							 
					counter_procedure--;			 
			 
			        $("#DrugGroup_procedure" + counter_procedure).remove();
			 		if(counter_procedure == 0) $('#removeButton_procedure').hide('slow');
			  });
			  //EOF add1 n remove1 procedure history
			  
			  
			  
			  
			  
		     $(".date_birth").live("click",function() {
					
					$(this).datepicker({
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
											}
										});
					});
		



			 $(".procedure_date").live("click",function() {
					
					$(this).datepicker({
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
											}
										});
					});




				});



		
			
			




		   	
			 
			function remove_icd(val){	 
				 
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
							dateFormat:'<?php echo $this->General->GeneralDate();?>',
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
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
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
		    
		    return false;
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
                alert(message);
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
$
		.fancybox({

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
	var identify ="";
	 function icdwin1(id) {
		
			identify = id;
			$
					.fancybox({

						'width' : '70%',
						'height' : '120%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "familyproblem")); ?>" + '/' + identify 
								
					});

		}



   </script>
<script>
 //----fancy box---
   function snowmed() {
		
		var patient_id = $('#patient_id').val();  
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$
				.fancybox({

					'width' : '70%',
					'height' : '120%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>"
							+ '/' + patient_id
				});

		}
   function openbox(icd,note_id) {

		var patient_id = $('#Patientsid').val();
		
		//alert(icd);
		//alert(note_id);
		
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$
				.fancybox({

					'width' : '40%',
					'height' : '80%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
							 + '/' + patient_id + '/' + icd + '/'+note_id 
				});

	}
   </script>
<script>
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
			
			 
			
   function getSmokingDetails(){
	   var smokerid=$('#smoking_fre').val();
		  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "diagnoses", "action" => "getSmokingDetails","admin" => false)); ?>";
	        $.ajax({
	          type: 'POST',
	          url: ajaxUrl+"/"+smokerid,
	          data: '',
	          dataType: 'html',
	          success: function(data){
					//alert(data);	
	        $("#smoking_fre_id").val(data);
			},
				
				error: function(message){
	              alert(message+'hi');
	          }        });
	    
	    return false; 
	}
   </script>
<script>
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
		

		$
		.fancybox({
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

		</script>
<script>
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
		
$(document).ready(function(){
    $("#doctor_id_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'doctor_id_txt,consultant_sb'
		});
	 $('.procedure').live('focus',function()
			  {  
		 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Tariffs", "action" => "getServiceByCategory","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		showNoId:true,
		delay:2000,
		 extraParams: {
			 Surgery: function() { return 'Surgery'; },
		         },
		
		selectFirst: true
	});
			  });

	 $('.provider').live('focus',function()
			  {  
   $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile","user_id",'doctor_name','null','null','null','name',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		valueSelected:true,
      	showNoId:true,
		selectFirst: true
		
		});
	});
});
</script>
