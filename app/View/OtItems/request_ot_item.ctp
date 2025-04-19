<script>
	jQuery(document).ready(function(){
		    
			$('#submit').click(function(){
				checkbox = null;
				 $(':checkbox').each(function(i){
					var getOtItemCheckboxId = 'ot_item_check'+$(this).val();
					var getOtItemQuantityId = 'ot_item_quntity'+$(this).val();
					
			 	  if($("#"+getOtItemCheckboxId).is(':checked') == true) { 
			 		 checkbox = 1;
				    $("#"+getOtItemQuantityId).addClass("validate[required,custom[onlyNumberSp]]");
			 	  } else {
				 	  
				 	 $("#"+getOtItemQuantityId).removeClass("validate[required,custom[onlyNumberSp]]");
			 	  }
			    });
				    
				    if(checkbox == null) {
					    alert("Please check at least one OT Item");
					    return false;
				    }
				    
			  });
			
	// binds form submission and fields to the validation engine
		jQuery("#requestotitem").validationEngine();
		
		
	});
 </script>
<div class="inner_title">
 <h3>Request For OR Item</h3>
</div>
   <!-- form elements start-->
   
	   <div>&nbsp;</div>
	<form name="requestotitem" id="requestotitem" action="<?php echo $this->Html->url(array("controller" => 'ot_items', "action" => "request_ot_item")); ?>" method="post" >

	   <table cellpadding="0" cellspacing="0" border="0" align="center" >
	   <tr>
			<td width="100" class="tdLabel"><?php echo __('OR Room:'); ?><font color="red"> *</font></td>
			<td width="150">
				<?php 
					 echo $this->Form->input('OtItemAllocation.opt_id', array('class' => 'validate[required,custom[mandatory-select]]', 'id' => 'opt_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','options'=>$opts,'div'=>false));?>
			</td>
			<td width="100" class="tdLabel"><?php echo __('OR Table:'); ?></td>
			<td width="150" id="changeOptTableList">
				<?php 
					 echo $this->Form->input('OtItemAllocation.opt_table_id', array('id' => 'opt_table_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select'));?>
			</td>
			<td width="100"  class="tdLabel">&nbsp;</td>
			<td width="190"></td>
	   </tr>
	   <tr>
			<td colspan="4" height="10"></td>
	   </tr>                       
	   </table>
	   <p class="ht5"></p>
	   <table  cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center" id = 'changeCreditTypeList' width="100%">
			<tr>
				<th width="3%"><?php echo __('Select'); ?></th>
				<th width="30%"><?php echo __('OR Item'); ?></th>
				<th width="15%"><?php echo __('Total Stock'); ?></th>
				<th width="10%"><?php echo __('In Stock'); ?></th>
				<th width="10%"><?php echo __('Request OR Item Quantity'); ?></th>
				<th width="31%"><?php echo __('Notes / Remarks'); ?></th>
			</tr>
		   <?php 
		        $cnt = 0;
		       if(count($getOtItemQuantity) > 0) { 
		       foreach($getOtItemQuantity as $getOtItemQuantityVal){
                 $cnt++;
   		   ?>
			<tr>
				<td>
				<?php 
					 echo $this->Form->checkbox('OtItemAllocationDetail.ot_item_check.', array('label'=> false, 'div' => false, 'value' => $getOtItemQuantityVal['OtItemQuantity']['ot_item_id'], 'id'=> 'ot_item_check'.$getOtItemQuantityVal['OtItemQuantity']['ot_item_id']));
				?>
				</td>
				<td><?php echo $getOtItemQuantityVal['OtItem']['name'];?></td>
				<td><?php echo $getOtItemQuantityVal[0]['quantity'];?></td>				
			    <td><?php if(array_key_exists($getOtItemQuantityVal['OtItemQuantity']['ot_item_id'], $getAllocatedItemWithIdIndex)) { print($getOtItemQuantityVal[0]['quantity']-$getAllocatedItemWithIdIndex[$getOtItemQuantityVal['OtItemQuantity']['ot_item_id']]); } else { echo $getOtItemQuantityVal[0]['quantity']; } ?></td>
			    <td>
			    <?php 
					 echo $this->Form->input('OtItemAllocationDetail.ot_item_id.'.$getOtItemQuantityVal['OtItemQuantity']['ot_item_id'], array('label'=> false, 'div' => false, 'error' => false, 'id'=> 'ot_item_quntity'.$getOtItemQuantityVal['OtItemQuantity']['ot_item_id']));
				?>
			    </td>
				<td>
				<?php 
					 echo $this->Form->input('OtItemAllocationDetail.remark1.'.$getOtItemQuantityVal['OtItemQuantity']['ot_item_id'], array('label'=> false, 'div' => false, 'error' => false, 'id'=> 'ot_item_remark'.$getOtItemQuantityVal['OtItemQuantity']['ot_item_id']));
				?>
				</td>
			</tr>
		<?php  }  
               } else {
        ?>
			<tr>
				<td colspan="8" align="center">
					No Record Found
				</td>
			</tr>
		<?php } ?>
	   </table>
	   <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" >
	   <tr>
		 <td colspan="6" align="right">
		   <?php echo $this->Html->link(__('Cancel', true),array('action' => 'ot_item_allocation'), array('escape' => false,'class'=>'grayBtn'));?>
		&nbsp;&nbsp;<input type="submit" value="Save" class="blueBtn" id = "submit" >
		 </td>
		</tr>
		</table>
	</form> 
   <!-- form element end-->


<script>
$(document).ready(function(){
          
          $("#opt_id").change(function() { 
          $('#busy-indicator1').show();
          var data = 'opt_id=' + $('#opt_id').val() ; 
          // for surgery category name field //
          $.ajax({url: "<?php echo $this->Html->url(array("action" => "getOptTableList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) {  $('#changeOptTableList').show(); $('#changeOptTableList').html(html);  $('#busy-indicator1').hide();  } });

         }); 
 		
});
  </script>
