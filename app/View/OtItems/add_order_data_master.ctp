<div class="inner_title">
 <h3><?php echo __('Add Order Data Master', true); ?></h3>
 
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#orderdatamasterfrm").validationEngine();
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
<form name="orderdatamasterfrm" id="orderdatamasterfrm" action="<?php echo $this->Html->url(array("action" => "add_order_data_master")); ?>" method="post" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
     <tr>
	  <td class="table_cell" align="right"><?php echo __('Order Category',true); ?><font color="red">*</font>
						</td>
						<td><?php
						echo $this->Form->input('OrderCategory.order_category_id',array('empty'=>'Please Select','style'=>'width:165px','readonly'=>'readonly',
											'options'=>$data,'selected'=>$getDataOrderCategory['OrderCategory']['order_category_id'],'id'=>'order_category_id','div'=>false,'label'=>false));?>
						</td>
			
	
	  
	 </tr>
	 
 	 <tr>
	  <td class="form_lables" align="right">
           <?php echo __('Name',true); ?>
	   <font color="red">*</font>
	   </td>
	  <td>
        <?php 
        echo $this->Form->input('OrderDataMaster.name', array('class' => 'validate[required,custom[customname]]', 'id' => 'name', 'label'=> false, 'div' => false,'autocomplete'=>"off" ,'error' => false));
        ?>
        </td>
        
	    </tr>
	
	<tr>
	  <td class="form_lables" align="right">
           <?php echo __('Description',true); ?>
	   <font color="red">*</font>
	   </td>
	  <td>
        <?php 
        echo $this->Form->textarea('OrderDataMaster.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	    </tr>
	
	  <tr>
		<td class="form_lables" align="right">
			<?php echo __('Is Active',true); ?>
		</td>
		<td>
         <?php 
          	echo $this->Form->input('OrderDataMaster.is_active', array('options' => array( 'Yes','No'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
         ?>
        </td>
	</tr>
	
        <tr>
	  <td colspan="2" align="center">
	  <?php echo $this->Html->link(__('Cancel', true),array('action' => 'order_data_master'), array('escape' => false,'class'=>'grayBtn')); ?>
	  <input type="submit" value="Submit" class="blueBtn">
	  </td>
	  </tr>
	  </table>
     </form>