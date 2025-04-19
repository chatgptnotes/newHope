<label>
<span name="surgersubcat" >
<?php echo __('Anesthesia Subcategory'); ?><font color="red"> *</font>:
</span>
<?php echo $this->Form->input(null,array('name' => 'anesthesia_subcategory_id', 'id'=> 'anesthesia_subcategory_id', 'empty'=>__('Select Surgery Subcategory'),'options'=> $surgerysubcategories, 'label' => false, 'div' => false , 'default' => $anesthesiasubcategoryid['OptAppointment']['anesthesia_subcategory_id'], 'class'=> 'required safe'));?>
</label>