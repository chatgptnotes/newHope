<div class="inner_title">
 <h3><?php echo __('Edit Patient Document Master', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#patientdocumentmasterfrm").validationEngine();
	});
	
</script>

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
<form name="patientdocumentmasterfrm" id="patientdocumentmasterfrm" action="<?php echo $this->Html->url(array("action" => "edit_patient_document_master")); ?>" method="post" >
        <?php 
              echo $this->Form->input('PatientDocumentMaster.id', array('type' => 'hidden')); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	  <tr>
	  <td class="form_lables" align="right">
	   <?php echo __('Document Type',true); ?><font color="red">*</font></td>
	   <td>
	   <?php echo $this->Form->input('PatientDocumentMaster.document_type', array('class' => 'validate[required,custom[name]]','id' => 'optdocumenttype', 'label'=> false, 'div' => false, 'error' => false));
	   ?></td></tr>
	
        <tr>
	  	<td class="form_lables" align="right">
           <?php echo __('Description',true); ?>
	   	<font color="red">*</font></td>
		<td>
        <?php 
        echo $this->Form->input('PatientDocumentMaster.description', array('class' => 'validate[required,custom[customname]]', 'id' => 'optdescirption', 'label'=> false, 'div' => false, 'error' => false));
        ?></td></tr>
   
        <tr>
		<td colspan="2" align="center">
	 	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'patient_document_master'), array('escape' => false,'class'=>'grayBtn')); ?>
	 	<input type="submit" value="Submit" class="blueBtn">
		</td>
		</tr>
		</table>
		</form>