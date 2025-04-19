<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#categoryfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Edit Inventory Category', true); ?></h3>

</div>
<form name="countryfrm" id="countryfrm" action="<?php echo $this->Html->url(array("controller" => "inventory_categories", "action" => "edit", "admin" => true)); ?>" method="post" >

	<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td  align="center">
	<?php echo __('Category Code'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('InventoryCategory.category_code', array('class' => 'validate[required,custom[categorycode]]', 'id' => 'cantegorycode', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="center">
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
         echo $this->Form->input('InventoryCategory.id', array( 'id' => 'countriesid', 'label'=> false, 'div' => false, 'error' => false,'type'=>'hidden'));
        echo $this->Form->input('InventoryCategory.name', array('class' => 'validate[required,custom[categoryname]]', 'id' => 'categoryname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	 
	 
	<tr>
	<td colspan="2" align="center">
	<?php
		echo $this->Html->link(__('Cancel'),
						 					array('action' => 'index'),array('escape' => false,'class'=>'grayBtn'));
	?>
	<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>