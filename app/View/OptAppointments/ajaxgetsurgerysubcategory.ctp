<label>
<span name="surgersubcat" >
<?php echo __('Surgery Subcategory'); ?><font color="red"> *</font>:
</span>
<?php echo $this->Form->input(null,array('name' => 'surgery_subcategory_id', 'id'=> 'surgery_subcategory_id', 'empty'=>__('Select Surgery Subcategory'),'options'=> $surgerysubcategories, 'label' => false, 'div' => false , 'default' => $surgerysubcategoryid['OptAppointment']['surgery_subcategory_id'], 'class'=> 'required safe'));?>
</label>