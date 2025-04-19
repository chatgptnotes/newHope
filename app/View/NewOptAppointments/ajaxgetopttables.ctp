<label>  
 <span><?php echo __('OT Table'); ?><font color="red"> *</font>:</span>
 <?php echo $this->Form->input(null,array('name' => 'opt_table_id', 'id'=> 'opt_table_id', 'empty'=>__('Select OT Table'),'options'=> $opttables, 'label' => false, 'class'=> 'required safe'));?>
</label>  