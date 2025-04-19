<label>
  <span><?php echo __('Anesthesia'); ?><font color="red"> *</font></span>
 	<?php echo $this->Form->input(null,array('name' => 'anesthesia_id', 'id'=> 'anesthesia_id', 'empty'=>__('Select Anesthesia'),'options'=> $anesthesia, 'label' => false, 'div' => false, 'class' => 'required safe',"style"=>"width:100%"));?>
</label>



