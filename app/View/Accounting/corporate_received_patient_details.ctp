<style>
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm td {
	 background: none repeat scroll 0 0 #fff !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}
body{
font-size:13px;
}
</style>
<!-- 
<div class="inner_title">
	<h3>
		<?php echo __('Corporate Patient Collection', true).' ('.$corporateName['TariffStandard']['name'].')'; ?>
		<div style="float:right;">
			<?php echo $this->Html->link(__('Back to List'), array('action' => 'corporate_receivable'), array('escape' => false,'class'=>'blueBtn'));?>
		</div>
	</h3>
</div>   -->

<?php echo $this->Form->create('Corporate',array('id'=>'update_corporate_amount','method'=>'post'));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="100%" valign="top">
		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
				<thead>
					<tr> 
						<th width="24%" align="center" valign="top"><?php echo __('Patient Name') ?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Amount') ?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Amount Paid') ?></th> 
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('TDS') ?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Pending Amount') ?></th>					 
					</tr> 
				</thead>				
				<tbody>
				<?php 	
				 		
				foreach($data as $key=> $userData){
					/* $netAmount = 0;
					$totalAmount=0;
					$totalPaid=0;
					$totalDiscount =0; */
					//if(!empty($userData['FinalBilling']['total_amount'])){
					$netAmount = ($userData['FinalBilling']['total_amount'] - $userData['FinalBilling']['amount_paid'] - $userData['FinalBilling']['discount']);
				?>
				<tr>
					<td><?php echo $userData['Person']['first_name']." ".$userData['Person']['last_name']; ?></td>
					<td><?php echo $userData[0]['approved_amount']?></td>
					<td><?php echo $userData[0]['received_amount']?></td>
					<td><?php echo $userData[0]['TDS'] ?></td>
					<td><?php 
							$pendingBal = $userData[0]['approved_amount']-$userData[0]['received_amount']-$userData[0]['TDS'] ; 
							echo $pendingBal;
							$totalPendingBalance += $pendingBal ;
							$totalAmount  += $userData[0]['approved_amount'];
							$totalReceivedAmount  += $userData[0]['received_amount'];
							$totalTDS  += $userData[0]['TDS']; 
							?>
					</td>  
				</tr> 
				<?php } ?>
				<tr>
					<td style="color:red !important;font-weight: bold !important;"><?php //name of patients ; ?></td>
					<td style="color:red !important;font-weight: bold !important;"><?php echo $totalAmount?></td>
					<td style="color:red !important;font-weight: bold !important;"><?php echo $totalReceivedAmount ?></td>
					<td style="color:red !important;font-weight: bold !important;"><?php echo $totalTDS ;?></td>
					<td style="color:red !important;font-weight: bold !important;"><?php echo $totalPendingBalance ?></td>  
				</tr> 
				</tbody> 
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>
 
	