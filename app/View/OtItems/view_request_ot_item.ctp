<div class="inner_title">
 <h3><?php echo __('View Request OR Item'); ?></h3>
</div>
   <!-- form elements start-->
   
	   <div>&nbsp;</div>
	<form name="requestotitem" id="requestotitem" action="<?php echo $this->Html->url(array("controller" => 'ot_items', "action" => "ot_item_allocation")); ?>" method="post" >

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
			<td width="100" class="tdLabel"><?php echo __('OR Table:'); ?></td>
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
				<th width="20%"><?php echo __('OR Item'); ?></th>
				<th width="15%"><?php echo __('Total Stock'); ?></th>
				<th width="10%"><?php echo __('In Stock'); ?></th>
				<th width="15%"><?php echo __('Requested OR Item Quantity'); ?></th>
				<th width="15%"><?php echo __('Allocate OR Item Quantity'); ?></th>
				<th width="14%"><?php echo __('Requested Date'); ?></th>
				<th width="14%"><?php echo __('Remark'); ?></th>
				
			</tr>
		   <?php 
		        $cnt = 0;
		       if(count($getOtItemAllocationDetail) > 0) { 
		       foreach($getOtItemAllocationDetail as $getOtItemAllocationDetailVal){
                 $cnt++;
   		   ?>
			<tr>
				 <td><?php echo $getOtItemAllocationDetailVal['PharmacyItem']['name'];?> </td>
				<td><?php echo $getOtItemQuantityWithIdIndex[$getOtItemAllocationDetailVal['OtItem']['id']];?></td>				
			    <td><?php echo ($getOtItemQuantityWithIdIndex[$getOtItemAllocationDetailVal['OtItem']['id']]-$getAllocatedItemWithIdIndex[$getOtItemAllocationDetailVal['OtItem']['id']]);?></td>
			    <td>
			    <?php 
					 echo $getOtItemAllocationDetailVal['OtReplaceDetail']['request_quantity'];
				?>
			    </td>
			    <td>
			    <?php 
					 echo $getOtItemAllocationDetailVal['OtReplaceDetail']['recieved_quantity'];
				?>
			    </td>
			    
				<td>
				<?php 
					 echo $this->DateFormat->formatDate2Local($getOtItemAllocation['OtReplace']['create_time'],Configure::read('date_format'), false);
				?>
				</td>
				<td>
			    <?php 
					 echo $getOtItemAllocationDetailVal['OtReplaceDetail']['remark'];
				?>
			    </td>
				
			</tr>
		<?php  }  
               } else {
        ?>
			<tr>
				<td colspan="9" align="center">
					<?php echo __('No Record Found'); ?>
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
		   <?php echo $this->Html->link(__('Back', true),array('action' => 'ot_item_allocation'), array('escape' => false,'class'=>'grayBtn'));?>
		 </td>
		</tr>
		</table>
	 
