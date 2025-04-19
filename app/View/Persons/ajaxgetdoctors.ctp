<!-- <select multiple="multiple" id="doctorlisting" name="data[Person][consultant_id]" class="" >
 <option value="">Select Doctor</option>
 
 <?php foreach($doctorlist as $doctorlistval) { ?>
  <option value="<?php echo $doctorlistval['Consultant']['id'] ?>"><?php echo $doctorlistval['Consultant']['full_name']; ?></option>
 <?php } ?>
</select> -->
<?php
 echo  $this->Form->input('Person.consultant_id',array('options'=>$doctorlist, 'multiple'=>true,'id' => 'doctorlisting','empty'=>'Please Select','label'=> false,'class'=>'validate[required,custom[mandatory-select]]')); 
 echo $this->Form->input('Person.registrar_id', array('type' => 'hidden', 'value' => '', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
?>