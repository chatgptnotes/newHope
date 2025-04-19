<script>
function checkForm() {
	instock = "";
	$(':checkbox').each(function(i){
		var getOtItemCheckboxId = 'ot_item_check'+$(this).val();
		var getAllocateOtItemId = 'recieved_quantity'+$(this).val();
		var getInStockVal = 'instock'+$(this).val();
		
 	  if($("#"+getOtItemCheckboxId).is(':checked') == true) { 
 		  $("#"+getAllocateOtItemId).addClass("validate[required,custom[onlyNumberSp]]");
 		  if(eval($("#"+getAllocateOtItemId).val()) > eval($("#"+getInStockVal).text())) {
	 		 instock = "overflow";
 		  } 
 	  } else {
	  	 $("#"+getAllocateOtItemId).removeClass("validate[required,custom[onlyNumberSp]]");
 	  }
    });
       if(instock == "overflow") {
            alert("Please enter allocate OT Item quantities less than in stock.");
            return false;
       }
}
	jQuery(document).ready(function(){
		    
	    // binds form submission and fields to the validation engine
		jQuery("#requestotitem").validationEngine();
		
		
	});
	
 </script>
<div class="inner_title">
 <h3><?php echo __('Allocate OR Item'); ?></h3>
</div>
   <!-- form elements start-->
   
	   <div>&nbsp;</div>
	<form name="requestotitem" id="requestotitem" action="<?php echo $this->Html->url(array("controller" => 'ot_items', "action" => "edit_request_ot_item")); ?>" method="post"  onsubmit="return checkForm();">
       <?php 
              echo $this->Form->input('OtReplace.id', array('type' => 'hidden', 'value' => $getOtItemAllocation['OtReplace']['id'])); 
        ?>
	   <table cellpadding="0" cellspacing="0" border="0" align="center" >
	   <tr>
	        <td width="120"  class="tdLabel"><?php echo __('Requested Person:'); ?></td>
			<td width="190"><strong>
			    <?php 
					 echo  $getOtItemAllocation['User']['full_name']; 
				?></strong>
				</td>
	        <td width="100" class="tdLabel"><?php echo __('OR Room:'); ?></td>
			<td width="150"><strong>
				<?php 
					 echo $getOtItemAllocation['Opt']['name']; 
				 ?></strong>
			</td>
			<td width="100" class="tdLabel"><?php echo __('OT Table:'); ?></td>
			<td width="150" id="changeOptTableList"><strong>
				<?php 
					 echo  $getOtItemAllocation['OptTable']['name']; 
				?></strong>
			</td>
						
	   </tr>
	   <tr>
			<td colspan="4" height="10"></td>
	   </tr>                       
	   </table>
	   <p class="ht5"></p>
	   <table  cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center" id = 'changeCreditTypeList' width="100%">
			<tr>
				<th width="4%"><?php echo __('Selected'); ?></th>
				<th width="20%"><?php echo __('OR Item'); ?></th>
				<th width="15%"><?php echo __('Total Stock'); ?></th>
				<th width="10%"><?php echo __('In Stock'); ?></th>
				<th width="15%"><?php echo __('Request OR Item Quantity'); ?></th>
				<th width="10%"><?php echo __('Request Date'); ?></th>
				<th width="15%"><?php echo __('Allocate OR Item Quantity'); ?></th>
				<th width="14%"><?php echo __('Remark'); ?></th>
				
			</tr>
		   <?php 
		        $cnt = 0;
		       if(count($getOtItemAllocationDetail) > 0) { 
		       foreach($getOtItemAllocationDetail as $getOtItemAllocationDetailVal){
                 $cnt++;
   		   ?>
   		   <?php 
              echo $this->Form->input('OtReplaceDetail.adid.'.$getOtItemAllocationDetailVal["OtReplaceDetail"]["id"], array('type' => 'hidden', 'value' => $getOtItemAllocationDetailVal['OtReplaceDetail']['id'])); 
        ?>
			<tr>
				<td>
				<?php 
					 echo $this->Form->checkbox('OtReplaceDetail.ot_item_check.', array('label'=> false, 'div' => false, 'value' => $getOtItemAllocationDetailVal['OtReplaceDetail']['id'], 'id'=> 'ot_item_check'.$getOtItemAllocationDetailVal['OtReplaceDetail']['id'], 'checked' => 'checked', 'disabled' => 'disabled'));
				?>
				</td>
				<td><?php echo $getOtItemAllocationDetailVal['PharmacyItem']['name'];?></td>
				<td align="center"><?php echo $getOtItemQuantityWithIdIndex[$getOtItemAllocationDetailVal['OtItem']['id']]; ?></td>				
			    <td align="center" value="<?php echo ($getOtItemQuantityWithIdIndex[$getOtItemAllocationDetailVal['OtItem']['id']]-$getAllocatedItemWithIdIndex[$getOtItemAllocationDetailVal['OtItem']['id']]); ?>" id="instock<?php echo $getOtItemAllocationDetailVal['OtReplaceDetail']['id'];?>" ><?php echo ($getOtItemQuantityWithIdIndex[$getOtItemAllocationDetailVal['OtItem']['id']]-$getAllocatedItemWithIdIndex[$getOtItemAllocationDetailVal['OtItem']['id']]); ?></td>
			    <td align="center">
			    <?php 
					 echo $getOtItemAllocationDetailVal['OtReplaceDetail']['request_quantity'];
				?>
			    </td>
			    <td align="center">
			    <?php 
					 echo $this->DateFormat->formatDate2Local($getOtItemAllocation['OtReplace']['create_time'],Configure::read('date_format'), false);
				?></td>
			    <td align="center">
			    <?php 
			         if($getOtItemAllocation['OtReplace']['status'] == 'A') {
					  echo $getOtItemAllocationDetailVal['OtReplaceDetail']['recieved_quantity'];
			         } else {
			         	echo $this->Form->input('OtReplaceDetail.recieved_quantity.'.$getOtItemAllocationDetailVal['OtReplaceDetail']['id'], array('label'=> false, 'div' => false, 'error' => false, 'id'=> 'recieved_quantity'.$getOtItemAllocationDetailVal['OtReplaceDetail']['id']));
			         }
				?>
			    </td>
				 <td align="center">
			    <?php 
			         if($getOtItemAllocation['OtReplace']['status'] == 'A') {
					  echo $getOtItemAllocationDetailVal['OtReplaceDetail']['remark'];
			         } else {
			         	echo $this->Form->input('OtReplaceDetail.remark.'.$getOtItemAllocationDetailVal['OtReplaceDetail']['id'], array('label'=> false, 'div' => false, 'error' => false, 'id'=> 'remark'.$getOtItemAllocationDetailVal['OtReplaceDetail']['id']));
			         }
				?>
			    </td>
				
			</tr>
		<?php  }  
               } else {
        ?>
			<tr>
				<td colspan="9" align="center">
					No Record Found
				</td>
			</tr>
		<?php } ?>
	   </table>
	   <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" >
	   <tr>
	   <td colspan="9">&nbsp;</td>
	   </tr>
	   <tr>
		 <td colspan="9" align="right">
		   <?php echo $this->Html->link(__('Cancel', true),array('action' => 'ot_item_allocation'), array('escape' => false,'class'=>'grayBtn'));?>
		&nbsp;&nbsp;<?php if($getOtItemAllocation['OtReplace']['status'] != 'A') {?><input type="submit" value="Save" class="blueBtn" id = "submit" ><?php  }?>
		 </td>
		</tr>
		</table>
	 </form>
   <!-- form element end-->



