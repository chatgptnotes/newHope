<?php
	
	echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));
	echo $this->Html->script('jquery.autocomplete');
  	echo $this->Html->css('jquery.autocomplete.css');
?>

<style>
label{
float:none;
}
</style>
<?php
#echo '<pre>';print_r($PatientFormData);exit;

?>

<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<h3> &nbsp; <?php echo __($patientFormType, true); ?></h3>
</div>

<?php echo $this->Form->create('PatientForm',array('action' => 'searchPatientForm', 'id'=>'searchfrm','inputDefaults' => array(
		'label' => false,
	'div' => false,
	'error' => false 
	))); ?>  
    <table class="consent_form">
    <tr>
    <td> Patient ID:</td>
    <td> 
 <?php echo $this->Form->input('patient_id_search', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','type' => 'text' ,'id' => 'patient_id_search', 'label'=> false,'div' => false, 'error' => false)); ?>   
    </td>
    </tr>
  <tr><td>
  <?php echo $this->Form->hidden('patientFormId',array('value'=>$patientFormId)); ?>
  </td>  
    <td>
    <div class="btns">
    <input class="blueBtn" type="submit" value="Search">
 </div>        </td></tr>
   </table>         
  
 
 <?php echo $this->Form->end(); ?>  
<?php

function buildFormRadio($i, $radioData){
		$options = array();
		foreach($radioData as $data ){
			$options[$data['name']] = $data['name'];
		}
		return $options;
	}

	function buildFormCheckbox($i, $checkboxData){
		$options = array();
		foreach($checkboxData as $data ){
			$options[$data['name']] = $data['name'];
		}
		
		return $options;
	}
?>

<form name="incidentfrm" id="incidentfrm" action="<?php echo $this->Html->url(array("controller" => "patient_forms", "action" => "patientFormSave")); ?>" method="post" onSubmit="return Validate(this);" >

<table>
<tr>
    <td align="left"> Patient ID:</td>
    <td align="left"> 
 <?php echo $this->Form->input('patient_id', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','type' => 'text' ,'id' => 'patient_id', 'label'=> false,'div' => false, 'error' => false)); ?>   
    </td>
    </tr>

</table>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">

<?php
	
$i=0;
foreach($PatientFormData as $formData){ $i++; ?>

<tr><td align="left">
<?php	
	echo $formData['FormQuestion']['name'];?>
	</td</tr>
	<?php
	if($formData['FormQuestion']['type'] == 'radio'){
	?>
	
	<tr><td align="left">
	<?php
		$options = buildFormRadio($formData['FormQuestion']['id'], $formData['FormAnswer']);	
		echo $this->Form->radio('incedent'.$formData['FormQuestion']['id'],$options,array('legend' => false));
	}else if($formData['FormQuestion']['type'] == 'checkbox'){ ?>
	<tr><td align="left">
	<?php 
	$options = buildFormCheckbox($formData['FormQuestion']['id'], $formData['FormAnswer']);
	//echo $this->Form->checkbox($formData['FormQuestion']['id'], $options);
	echo $this->Form->input('type', array('name' => 'incident'.$formData['FormQuestion']['id'] ,'label' => false ,'type' => 'select', 'multiple' => 'checkbox',
	'options' => $options
         ));
	}else if($formData['FormQuestion']['type'] == 'textbox'){ ?>
	<tr><td align="left">
	<?php 
		echo $this->Form->text('incedent'.$formData['FormQuestion']['id']);
	}else if($formData['FormQuestion']['type'] == 'textarea'){ ?>
	<tr><td align="left">
	<?php 
		echo $this->Form->textarea('incedent'.$formData['FormQuestion']['id']);
	}
?>
</td></tr>
		
<?php } ?>
<tr><td><?php 
echo $this->Form->hidden('patient_form_id',array('value'=>$patientFormId));
#echo $this->Form->hidden('patientFormId',array('value'=>$patientFormType));

?></td></tr>
<tr><td><input type="submit" value="Submit" class="blueBtn"></td></tr>


 </table>
</form>
<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#searchfrm").validationEngine();
			jQuery("#incidentfrm").validationEngine();	
			
		$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
		$("#patient_id_search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
		});
		
	
</script>
