<style>
.text_center{ text-align:center;}
.row_action img {
    
}
</style>

<div class="inner_title">
	<h3 > &nbsp; <?php echo __('Discount Requests', true); ?></h3>
	<span>
	<?php
		echo $this->Html->link(__('Refund Requests'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn refund-button'));
		if($this->Session->read("website.instance")=='lifespring'){
		echo $this->Html->link(__('Ward and Tariff Requests'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn wardTariffRequests-button'));
			} ?></span>
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
				<?php echo __("Total Amount"); ?>
			</td>
			
			<td class="table_cell">
				<?php echo __("Amount"); ?>
			</td>
			
			<td class="table_cell">
				<?php echo __("Approval for"); ?>
			</td>
					
			<td class="table_cell">
				<?php echo __("Reason"); ?>
			</td>
				
			<td class="table_cell">
				<?php echo __("Action"); ?>
			</td>
		</tr>
	</thead>
	
	<tbody>
		<?php $count = 1; foreach($results as $result) {  if($result['DiscountRequest']['type'] != "Refund") { ?>
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
			
			<td class="row_format text_center">
				<?php echo $result['DiscountRequest']['total_amount']; ?>
			</td>
			
			<td class="row_format text_center">
				<?php if($result['DiscountRequest']['type'] == "Amount") {
					echo $result['DiscountRequest']['discount_amount'];
				}else 
					if($result['DiscountRequest']['type'] == "Percentage"){	//calculate percentage
						$total = $result['DiscountRequest']['total_amount'];
						$per = $result['DiscountRequest']['discount_percentage'];
						echo $net = ($total * $per )/100;
					}
				?>
			</td>
			
			<td class="row_format text_center">
				<?php 
					if(is_numeric($result['DiscountRequest']['payment_category']))
					{	
						echo $result['ServiceCategory']['alias'] ? $val = $result['ServiceCategory']['alias'] : $val = $result['ServiceCategory']['name']; 
					} 
					else 
					{
						echo $result['DiscountRequest']['payment_category'];
					}
				?>
				<?php //if(!empty($val)) echo $val; else echo $result['DiscountRequest']['payment_category']; ?>
			</td>
			
			<td class="row_format text_center">
				<?php
					echo $result['DiscountRequest']['reason'];
				?>
			</td>
			
			<td class="row_format text_center" id="status_<?php echo $result['DiscountRequest']['id'];?>">
			<?php
				if($result['DiscountRequest']['is_deleted'] == 1)
				{
					echo "Cancelled by User";
				}else
				if($result['DiscountRequest']['is_approved'] == 1)
				{
					echo "Approved";
				}else
				if($result['DiscountRequest']['is_approved'] == 2)
				{
					echo "Rejected";
				}else
				{
					echo $this->Html->link(__('Approve'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn approved','value'=>$result['DiscountRequest']['id'],'id'=>'approved_'.$result['DiscountRequest']['id']));
					echo "&nbsp;";
			    	echo $this->Html->link(__('Reject'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn reject','value'=>$result['DiscountRequest']['id'],'id'=>'reject_'.$result['DiscountRequest']['id']));
				}
			?>
			</td>
			
		</tr>
		<?php $count++; } } ?>
	</tbody>
</table>