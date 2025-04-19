<label>
  <span><?php echo __('Surgery'); ?><font color="red"> *</font>:</span>
 	<?php echo $this->Form->input(null,array('name' => 'surgery_id', 'id'=> 'surgery_id', 'empty'=>__('Select Surgery'),'options'=> $surgery, 
 			'label' => false, 'div' => false, 'class' => 'required safe',"style"=>"width : 190px"));?>
</label>



