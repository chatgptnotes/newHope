<label>
  <span><?php echo __('Subcategory'); ?></span>
 	<?php echo $this->Form->input(null,array('name' => 'surgery_subcategory_id', 'id'=> 'surgery_subcategory_id', 'empty'=>__('Select Surgery Subcategory'),'options'=> $surgerysubcategories, 'label' => false, 'div' => false));?>
</label>



