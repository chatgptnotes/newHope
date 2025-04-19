<div class="inner_title">
 <h3><?php echo __('Edit Enterprise Rate', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#hospitalratefrm").validationEngine();
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
<form name="hospitalratefrm" id="hospitalratefrm" action="<?php echo $this->Html->url(array("action" => "edit_hospital_rate", 'superadmin' => true)); ?>" method="post" >
<?php echo $this->Form->input('HospitalRate.id', array('type' => 'hidden')); ?>
   <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	  <td class="form_lables">
	   <?php echo __('Enterprise',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('HospitalRate.facility_id', array('class' => 'validate[required,custom[mandatory-select]]','id' => 'facility_id', 'label'=> false, 'div' => false, 'error' => false, 'options' => $facilities, 'empty' => 'Select Enterprise'));
	   ?>
	  </td>
	 </tr>
     <tr>
	  <td class="form_lables">
	   <?php echo __('IPD Rate',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('HospitalRate.ipd_rate', array('class' => 'validate[required,custom[onlyNumber]]','id' => 'ipd_rate', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
	 <tr>
	  <td class="form_lables">
	   <?php echo __('OPD Rate',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('HospitalRate.opd_rate', array('class' => 'validate[required,custom[onlyNumber]]','id' => 'opd_rate', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
	 <tr>
	  <td class="form_lables">
	   <?php echo __('Emergency Rate',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('HospitalRate.emergency_rate', array('class' => 'validate[required,custom[onlyNumber]]','id' => 'emergency_rate', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
 	  <tr>
	<td colspan="2" align="center">
	 <input type="submit" value="Submit" class="blueBtn">
	 <?php echo $this->Html->link(__('Cancel', true),array('action' => 'hospital_rate', 'superadmin' => true), array('escape' => false,'class'=>'grayBtn')); ?>
	 
	</td>
	</tr>
	</table>
</form>