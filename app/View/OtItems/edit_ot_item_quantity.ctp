<div class="inner_title">
 <h3><?php echo __('Edit OR Item', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#optitemquantityfrm").validationEngine();
	$("#ot_item_category_id").change(function() { 
        $('#busy-indicator1').show();
        var data = 'ot_item_category_id=' + $('#ot_item_category_id').val() ; 
        // for surgery category name field //
        $.ajax({url: "<?php echo $this->Html->url(array("action" => "getOtItemsList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) {  $('#changeOtItemList').show(); $('#changeOtItemList').html(html);  $('#busy-indicator1').hide();  } });

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
<form name="optitemquantityfrm" id="optitemquantityfrm" action="<?php echo $this->Html->url(array("action" => "edit_ot_item_quantity")); ?>" method="post" >
        <?php 
              echo $this->Form->input('OtItemQuantity.id', array('type' => 'hidden')); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	 <tr>
	<td class="form_lables">
	<?php echo __('OR Item Category',true); ?><font color="red">*</font>
	</td>
	<td>
         <?php 
          echo $this->Form->input('OtItemQuantity.ot_item_category_id', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $itemcatlist, 'empty' => 'Select OT Item', 'id' => 'ot_item_category_id', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	 <tr>
	<td class="form_lables">
	<?php echo __('OR Item',true); ?><font color="red">*</font>
	</td>
	<td id="changeOtItemList">
         <?php 
          echo $this->Form->input('OtItemQuantity.ot_item_id', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $itemlist, 'empty' => 'Select OT Item', 'id' => 'otitem', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
     <tr>
	<td class="form_lables">
	<?php echo __('Quantity',true); ?><font color="red">*</font>
	</td>
	<td>
         <?php 
          echo $this->Form->input('OtItemQuantity.quantity', array('class' => 'validate[required,custom[onlyNumberSp]]', 'id' => 'quantity', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td colspan="2" align="center">
	 <?php echo $this->Html->link(__('Cancel', true),array('action' => 'ot_item_quantities'), array('escape' => false,'class'=>'grayBtn')); ?>
	 <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>