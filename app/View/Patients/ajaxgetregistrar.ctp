<?php 
 echo $this->Form->input('Patient.registrar_id', array('options' => $doctorlist, 'empty' => 'Select Doctor', 
 'id' => 'doctorlisting', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd')); 
 echo $this->Form->input('Patient.consultant_id', array('type' => 'hidden', 'value' => '', 'label'=> false, 
 'div' => false, 'error' => false)); 
?>
