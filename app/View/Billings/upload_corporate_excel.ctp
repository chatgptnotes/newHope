<style>
.billing_table {
	padding-left: 10px;
	margin-left: 10px;
	padding-top: 10px;
	margin-top: 10px;
	padding-right: 10px;
	margin-right: 10px;
	clear: both;
	background: lightgray"
}
</style>
<?php if($isSuccess == 'yes'){ ?>
<script>
	parent.jQuery.fancybox.close();
</script>
<?php }elseif($isSuccess == 'no'){  ?>
<script>
	parent.jQuery.fancybox.close();
</script>
<?php }
echo $this->Form->create('billings',array('type'=>'file','url'=>array('controller'=>'billings','action'=>'uploadCorporateExcel','?'=>array('category'=>$category)),'id'=>'advancePaymentFrm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)));

echo $this->Form->hidden('PatientDocument.patient_id',array('value'=>$patient_id)); 
echo $this->Form->hidden('PatientDocument.flag',array('value'=>$flag));
echo $this->Form->hidden('PatientDocument.tariffStdId',array('value'=>$tariffStdId));?>
<div class="inner_title" style="width: 96%">
	<h3>&nbsp;
		<?php echo __('Upload corporate bill', true); ?>
	</h3>
</div>
<table width="95%" cellspacing="0" cellpadding="0" border="0" class="billing_table" bgcolor="LightGray" >
	<tr>
		<td><strong>Upload Submitted Excel:</strong><font color="red">*</font></td>
		<td ><?php echo $this->Form->input('PatientDocument.file_name',array('type'=>'file','class' => 'validate[required,custom[mandatory-select]] upload_excel','id'=>'upload_excel','label'=>false,'style'=>'width:150px'));?></td>
		
		<td><?php echo $this->Form->submit('Save',array('id'=>'submitUpload','class'=>'blueBtn submitUpload','div'=>false,'label'=>false));?></td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>

<script>
$(submitUpload).click(function(){
	var validatePerson = jQuery("#advancePaymentFrm").validationEngine('validate'); 
 	if(!validatePerson){
	 	return false;
	}else{
		$("#busy-indicator").show();
	}
});
</script>
 