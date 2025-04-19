<?php 
 echo $this->Form->input('Person.registrar_id', array('options' => $doctorlist, 'empty' => 'Select Doctor', 'id' => 'doctorlisting', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd')); 
 echo $this->Form->input('Person.consultant_id', array('type' => 'hidden', 'value' => '', 'label'=> false, 'div' => false, 'error' => false)); 
?>
