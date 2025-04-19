<?php 
  echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete');
  
?>
<div class="inner_title">
 <h3><?php echo __('Add Medical Item', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#medicalItem").validationEngine();
	$("#pharmacy_item").autocomplete("<?php echo $this->Html->url(array("controller" => "ot_items", "action" => "autoSearchPharmacyItem", "admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		onItemSelect:function (data1) { 
			$("#pharmacy_item_id").val(data1.extra[0])
		}
		
	});
	});
</script>

<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php } ?>
<form name="optitemfrm" id="medicalItem" action="<?php echo $this->Html->url(array("action" => "medical_item_add","admin"=>true)); ?>" method="post" >
   <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	  <td class="form_lables">
	   <?php echo __('Item Category',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('MedicalItem.ot_item_category_id', array('class' => 'validate[required,custom[mandatory-select]]','id' => 'optname', 'label'=> false, 'div' => false, 'error' => false, 'options' => $otitemcategories, 'empty' => 'Select Category'));
	   ?>
	  </td>
	 </tr>
     <tr>
	  <td class="form_lables">
	   <?php echo __('Medical Item Name',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('MedicalItem.pharmacy_item', array('class' => 'validate[required,custom[name]]','id' => 'pharmacy_item', 'label'=> false, 'div' => false, 'error' => false));
	   ?><input type="hidden" name="MedicalItem[pharmacy_item_id]" id="pharmacy_item_id" />
	  </td>
	 </tr>
 	 <tr>
	  <td class="form_lables">
           <?php echo __('Description',true); ?>
	   <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('MedicalItem.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'optdescription', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	
	 <tr>
	  <td class="form_lables">
           <?php echo __('In Stock',true); ?>
	   <font color="red">*</font>
	</td>
	<td>
        <?php 
     echo $this->Form->input('MedicalItem.in_stock', array('class' => 'validate[required,custom[onlyNumber]]','id' => 'in_stock', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td colspan="2" align="center">
	 <?php echo $this->Html->link(__('Cancel', true),array('action' => 'medical_item_list',"admin"=>true), array('escape' => false,'class'=>'grayBtn')); ?>
	 <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>