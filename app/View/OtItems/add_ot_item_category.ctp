<div class="inner_title">
 <h3><?php echo __('Add Item Category', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#otitemcategoryfrm").validationEngine();
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
<form name="otitemcategoryfrm" id="otitemcategoryfrm" action="<?php echo $this->Html->url(array("action" => "add_ot_item_category")); ?>" method="post" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
     <tr>
	  <td class="form_lables">
	   <?php echo __('Item Category Name',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('OtItemCategory.code_name', array('class' => 'validate[required,custom[name]]','id' => 'otitemcategory', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
	 <tr>
	  <td class="form_lables">
	   <?php echo __('Item Category Alias',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('OtItemCategory.name', array('class' => 'validate[required,custom[name]]','id' => 'otitemcategoryalias', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
 	 <tr>
	  <td class="form_lables">
           <?php echo __('Description',true); ?>
	   <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('OtItemCategory.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'otitemdescription', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td colspan="2" align="center">
	 <?php echo $this->Html->link(__('Cancel', true),array('action' => 'ot_item_category'), array('escape' => false,'class'=>'grayBtn')); ?>
	 <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>