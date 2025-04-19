<!-- <select id="doctorlisting" name="data[Patient][consultant_id]" class="textBoxExpnd">
 <option value="">Select Doctor</option>
 <?php 

 foreach($doctorlist as $doctorlistval) {
	if($consultantId['Patient']['consultant_id']==$doctorlistval['Consultant']['id']) $selected  = 'selected ' ;
	else $selected = '' ;
 	?>
  <option <?php echo $selected ;?> value="<?php echo $doctorlistval['Consultant']['id'] ?>"><?php echo $doctorlistval['Consultant']['full_name']; ?></option>
 <?php } ?>
</select> -->
<?php 
 echo  $this->Form->input('Patient.consultant_id',array('options'=>$doctorlist, 'multiple'=>true,'id' => 'doctorlisting','empty'=>'Please Select','label'=> false,'class'=>'validate[required,custom[mandatory-select]]'));
 echo $this->Form->input('Patient.registrar_id', array('type' => 'hidden', 'value' => '', 'label'=> false, 'div' => false, 'error' => false));
?>