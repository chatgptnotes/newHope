<style>
.text_center{ text-align:center;}
.row_action img {
    
}
</style>
<div class="inner_title">
	<h3 > &nbsp; <?php echo __('Ward and Tariff Requests', true); ?></h3>
	<span>
	<?php
		echo $this->Html->link(__('Discount Requests'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn discount-button'));
		echo $this->Html->link(__('Refund Requests'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn refund-button'));
	?></span>
</div>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_format">
	<thead>
		<tr class="row_title">
			<td class="table_cell">
				<?php echo __("Sr.No"); ?>
			</td>
				
			<td class="table_cell">
				<?php echo __("Patient Name"); ?>
			</td>
			
			<td class="table_cell">
				<?php echo __("Request From"); ?>
			</td>
			
			<td class="table_cell">
				<?php echo __("Request To"); ?>
			</td>
					
			<td class="table_cell">
				<?php echo __("Approval for"); ?>
			</td>
				
			<td class="table_cell" align="center">
				<?php echo __("Action"); ?>
			</td>
		</tr>
	</thead>
	
	<tbody>
		<?php $count = 1; foreach($results as $result) {  ?>
		<tr class=" <?php if($count%2==0) echo "row_gray"; ?>">
			<td class="row_format text_center"> 
				<?php echo $count; ?>
			</td>
			
			<td class="row_format">
				<?php echo $result['Patient']['lookup_name']; ?>
			</td>
			
			<td class="row_format">
				<?php echo $result[0]['requested_by_lookup_name']; ?>
			</td>
			
			<td class="row_format">
				<?php echo $result[0]['requested_to_lookup_name']; ?>
			</td>
			<td class="row_format">
				<?php echo $result['ApproveRequest']['type']; ?>
			</td>
			
			<td class="row_format text_center" id="status_<?php echo $result['ApproveRequest']['id'];?>">
			<?php 
				if($result['ApproveRequest']['is_deleted'])
				{
					echo "Cancelled by User";
				}else
				if($result['ApproveRequest']['is_approved'] == 1 && $result['ApproveRequest']['is_deleted'] == 0)
				{
					echo "Approved";
				}else
				if($result['ApproveRequest']['is_approved'] == 2 &&	 $result['ApproveRequest']['is_deleted'] == 0)
				{
					echo "Rejected";
				}else
				{
					echo $this->Html->link(__('Approve'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn approvedreq','value'=>$result['ApproveRequest']['id'],'id'=>'approved_'.$result['ApproveRequest']['id']));
					echo "&nbsp;";
			    	echo $this->Html->link(__('Reject'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn rejectreq','value'=>$result['ApproveRequest']['id'],'id'=>'reject_'.$result['ApproveRequest']['id']));
				}
			?>
			</td>
		</tr>
		<?php $count++;  } ?>
	</tbody>
</table>