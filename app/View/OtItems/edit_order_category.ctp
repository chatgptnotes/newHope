<div class="inner_title">
 <h3><?php echo __('Edit Order Category', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#ordercategoryfrm").validationEngine();
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
<form name="ordercategoryfrm" id="ordercategoryfrm" action="<?php echo $this->Html->url(array("action" => "edit_order_category")); ?>" method="post" >
        <?php 
              echo $this->Form->input('OrderCategory.id', array('type' => 'hidden')); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	  <tr>
	  <td class="form_lables" align="right">
	   <?php echo __('Order Category',true); ?><font color="red">*</font></td>
	   <td>
	   <?php echo $this->Form->input('OrderCategory.order_category', array('class' => 'validate[required,custom[name]]','id' => 'optcategory', 'label'=> false, 'div' => false, 'error' => false));
	   ?></td></tr>
	   
 	 	<tr>
	  	<td class="form_lables" align="right">
           <?php echo __('Order Alias',true); ?>
	   	<font color="red">*</font></td>
	
		<td>
        <?php 
        echo $this->Form->textarea('OrderCategory.order_alias', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'optalias', 'label'=> false, 'div' => false, 'error' => false));
        ?></td>
  
     	<tr>
	 	<td class="form_lables" align="right">
	 	<?php echo __('Is Active',true); ?>
	 	</td>
	 	<td>
        <?php echo $this->Form->input('OrderCategory.is_active', array('options' => array('1' => 'Yes','0' => 'No'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false, 'selected' => $this->data['OrderCategory']['is_active']));
        ?>
        </td>
	 	</tr>
  
        <tr>
		<td colspan="2" align="center">
	 	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'order_category'), array('escape' => false,'class'=>'grayBtn')); ?>
	 	<input type="submit" value="Submit" class="blueBtn">
		</td>
		</tr>
		</table>
		</form>