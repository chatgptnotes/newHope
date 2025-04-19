<div class="inner_title">
 <h3><?php echo __('Edit Specific Audit Log', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#auditlogpermfrm").validationEngine();
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
<form name="auditlogpermfrm" id="auditlogpermfrm" action="<?php echo $this->Html->url(array("action" => "edit_audit_log_permission")); ?>" method="post" >
        <?php
              echo $this->Form->input('AuditLogPermission.id', array('type' => 'hidden')); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
        <tr>
	<td class="form_lables">
	<?php echo __('Module',true); ?><font color="red">*</font>
	</td>
	<td>
         <?php 
          echo $this->Form->input('AuditLogPermission.model', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => array('Patient'=> 'Patient', 'Person' => 'Person','Diagnosis' => 'Diagnosis', 'PatientNote' => 'PatientNote', 'RadiologyTestOrder' => 'RadiologyTestOrder', 'LaboratoryTestOrder' => 'LaboratoryTestOrder','Note' => 'Note(Vital Sign)', 'NewCropAllergies' => 'Allergies', 'NewCropPrescription' => 'Prescription', 'ClinicalSupport' => 'ClinicalSupport'), 'empty' => 'Select Module', 'id' => 'module', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	  <td class="form_lables">
	   <?php echo __('Username',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('AuditLogPermission.user_id', array('class' => 'validate[required,custom[mandatory-select]]','id' => 'username', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
	 <tr>
<td class="form_lables" align="center">
<?php echo __('Status'); ?>
</td>
<td>
<?php
echo $this->Form->input('AuditLogPermission.status', array('options' => array('1' => 'Yes', '0' => 'No') , 'id'=>'audit_log_status','label'=> false, 'div' => false, 'error' => false));
?>
</td>
</tr>
        <tr>
	<td colspan="2" align="center">
	  <?php echo $this->Html->link(__('Cancel', true),array('action' => 'audit_log_permission'), array('escape' => false,'class'=>'grayBtn')); ?>
	  <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>