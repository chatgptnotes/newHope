<?php if($package['PackageEstimate']){?>
<table cellspacing="1" cellpadding="0" border="0" width="100%"
	id="serviceGrid" class="tabularForm" style="clear: both">
	<tbody>
		<tr class="row_title">
			<th class="table_cell"><strong>Date</strong></th>
			<th class="table_cell"><strong>Package Name</strong></th>
			<th class="table_cell"><strong>Amount(Rs.)</strong></th>
			<th class="table_cell"><strong>Description</strong></th>

		</tr>
		<tr id="row_32" class="row">
			<td valign="middle"><?php echo $this->DateFormat->formatDate2LocalForReport($package['Patient']['package_application_date'],Configure::read('date_format'),true);?>
			-<?php echo $this->DateFormat->formatDate2LocalForReport($package['EstimateConsultantBilling']['endDate'],Configure::read('date_format'),true);?>
			</td>
			<td valign="middle"><?php echo ucfirst($package['PackageEstimate']['name']);?>
			</td>
			<td valign="middle" id="amountBill_0" style="text-align: right;"><?php
			$totalPackgeWithoutDiscount = $package['EstimateConsultantBilling']['totalAmount'] + $package['EstimateConsultantBilling']['totalDiscount']['total_discount'];
			 echo $totalPackgeWithoutDiscount;
			?>
			</td>
			<td valign="middle"><?php echo $package['EstimateConsultantBilling']['remark']; ?>
			</td>
		</tr>
		
		<tr>
			<td align="right" valign="middle" colspan="3">Total Amount</td>
			<td valign="middle" style="text-align: right;"><?php
			
			 echo $this->Number->currency($totalPackgeWithoutDiscount);
			$totalAmount = $package['EstimateConsultantBilling']['totalAmount'];  ?>
			</td>
		</tr>
	</tbody>
</table>
<?php }?>
<?php if(!empty($packagePayments)){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	style="clear: both">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align: center" colspan="5"><strong>Payment Received
				For Package</strong></td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				style="clear: both" class="tabularForm">
				<tr>
					<th>Deposit Amount</th>
					<th>Date/Time</th>
					<th>Mode of Payment</th>
					<th>Action</th>
				</tr>
				<?php $totalPaid = 0;
					  $paidtopatient=0;
			  		  $totalpaidDiscount=0;
			  		  $recordFound = false;
			  		  ?>
				<?php foreach($packagePayments as $payments ){
					if($payments['Billing']['refund']=='1'){
						$paidtopatient = $paidtopatient + $payments['Billing']['paid_to_patient'];
						continue;
					}else{
						if(!empty($payments['Billing']['discount'])){
							$totalpaid = $totalpaid + $payments['Billing']['discount'];
							$totalpaidDiscount = $totalpaidDiscount + $payments['Billing']['discount'];
							if(empty($payments['Billing']['amount']))
								continue;
						}
					}$recordFound = true;
				?>
				<tr>
					<td align="right"><?php echo $payments['Billing']['amount'];?></td>
					<?php $totalPaid = $totalPaid + (int) $payments['Billing']['amount'];?>
					<td><?php echo $this->DateFormat->formatDate2LocalForReport($payments['Billing']['date'],Configure::read('date_format'),true);?></td>
					<td><?php echo $payments['Billing']['mode_of_payment'];?></td>
					<td><?php 
					echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
						 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
						 $payments['Billing']['id']))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?>
					</td>
				</tr>
				<?php }?>
				<?php if(!$recordFound){?>
				<tr>
					<td align="center" colspan="4">No Record Found</td>
				</tr>
				<?php }?>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

</table>
<?php } ?>
<?php $pendingAmount = ($totalAmount + $paidtopatient)  - ($totalPaid + $totalpaidDiscount);?>
<script>
$( '#paymentDetail', parent.document ).trigger('reset');
$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
$( '#totaladvancepaid', parent.document ).val('<?php echo $totalPaid;?>');
$( '#totalamountpending', parent.document ).val('<?php echo $pendingAmount;?>');
$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
$( '#maintainDiscount', parent.document ).val('<?php echo $totalpaidDiscount;?>');
</script>
