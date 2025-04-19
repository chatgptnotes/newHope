<?php
echo $this->Html->css(array('internal_style'));
//pr($billingData) ;
?>
<style>
body{
font-size:13px;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Cash Book', true); ?>
	</h3>
</div> 
<div style="padding-top:10px;"><?php echo __("For ").$this->DateFormat->formatDate2Local($batchDetails['CashierBatch']['start_transaction_date'],Configure::read('date_format'));?></div>
<div class="clr">&nbsp;</div>


<table width="100%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
	<tr> 
		<th width="7%" align="center" valign="top" style="text-align: left;;">Date</th>
		<th width="47%" align="center" valign="top" style="text-align: center; min-width: 150px;">Particulars</th> 
		<th width="10%" align="center" valign="top" style="text-align: left;;">Voucher Type</th>
		<th width="10%" align="center" valign="top" style="text-align: center; ">Voucher No.</th> 
		<th width="13%" align="center" valign="top" style="text-align: left;;">Debit</th>
		<th width="13%" align="center" valign="top" style="text-align: center; ">Credit</th> 
	</tr> 
	
	<tr>
	<td align="left" valign="top" style= "text-align: left;">
	<?php echo $this->DateFormat->formatDate2Local($batchDetails['CashierBatch']['start_transaction_date'],Configure::read('date_format'));?>
						</td>
						<td align="left" valign="top" style= "text-align: left;font-weight:bold"  >
							<?php echo __('Opening Balance');?>
						</td>
						
						<td align="left" valign="top" style= "text-align: left;"  >
							&nbsp;
						</td>
						<td align="left" valign="top" style= "text-align: left;"  >
							&nbsp;
						</td>
						<td align="left" valign="top" style= "text-align: right;font-weight:bold"  >
						<?php $openingBalance = $batchDetails['CashierBatch']['opening_balance']?>
							<?php echo $this->Number->currency($openingBalance);
							?>
						</td>
						<td align="left" valign="top" style= "text-align: right;"  >
							&nbsp;
						</td> 
					</tr>
<?php 
$totalCreditAmount = $totalDebitAmount = 0;

foreach($paymentDetails as $payment){?>
				<tr>			
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $this->DateFormat->formatDate2Local($payment['VoucherPayment']['date'],Configure::read('date_format'),true); ;?>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<div style="padding-left:0px;padding-bottom:3px;">
							<?php echo $payment['Account']['name']; ?>
						</div>
						<div style="padding-left: 35px; font-size:13px; font-style:italic;">
							<?php echo __('Entered By : ').$payment['User']['first_name'].' ('.$payment['User']['last_name'].')' ;?>
						</div>
						<div style="padding-left:35px;padding-top:5px; font-style:italic;">
							<?php echo __('Narration : ').$payment['VoucherPayment']['narration'];?>
						</div>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo __("Payment") ;?>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $payment['VoucherPayment']['id'];?>
					</td>
					<td align="left" valign="top" style= "text-align: right;">
						&nbsp;
					</td>
					<td align="left" valign="top" style= "text-align: right;">
						<?php echo $this->Number->currency($payment['VoucherPayment']['paid_amount']);
						$totalCreditAmount +=  (int) $payment['VoucherPayment']['paid_amount'];
						?>
					</td> 
				</tr>		
<?php }

foreach($receiptDetails as $receipt){?>

				 <tr>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $this->DateFormat->formatDate2Local($receipt['AccountReceipt']['date'],Configure::read('date_format'),true) ; ?>
					</td>
					
					<td align="left" valign="top" style= "text-align: left;">
						<div style="padding-left:0px;padding-bottom:3px;">
							<?php echo $receipt['Account']['name'] ; ?>
						</div>
						<div style="padding-left: 35px; font-size:13px; font-style:italic;">
							<?php echo __('Entered By : ').$receipt['User']['first_name'].' '.$receipt['User']['last_name'] ;?>
						</div>
						<div style="padding-left:35px;padding-top:5px; font-style:italic;">
							<?php echo __('Narration : ').$receipt['AccountReceipt']['narration']; ?>
						</div>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo __("Receipt") ;?>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $receipt['AccountReceipt']['id'];?>
					</td>
					<td align="left" valign="top" style= "text-align: right;">
						<?php echo $this->Number->currency($receipt['AccountReceipt']['paid_amount']);
						$totalDebitAmount +=  (int) $receipt['AccountReceipt']['paid_amount'];
						?>
					</td> 
					<td align="left" valign="top" style= "text-align: right;">
						&nbsp;
					</td>
				</tr>
<?php } ?>
			<?php
						$totalDebitAmount += (int) $openingBalance;
					?>
			    <tr>			
					<td align="right" valign="top" style= "text-align: left;"  colspan="2">
					&nbsp;
					</td>
					<td align="left" valign="top" style= "text-align: left;"  colspan="2">
						&nbsp;
					</td>
					<td align="left" valign="top" style= "text-align: right;"  colspan="1">
					<?php echo $this->Number->currency($totalDebitAmount);?>
					</td>
					<td align="left" valign="top" style= "text-align: right;"  colspan="1">
					<?php echo $this->Number->currency($totalCreditAmount);?>
					</td>
				</tr>
				
				<tr>			
					<td align="right" valign="top" style= "text-align: left;"  colspan="2">
						<?php echo __("Closing Balance");?>
					</td>
					<td align="left" valign="top" style= "text-align: left;"  colspan="2">
						&nbsp;
					</td>
					<td align="left" valign="top" style= "text-align: right;"  colspan="1">
					<?php 
						if($totalCreditAmount > $totalDebitAmount){
							echo $this->Number->currency($totalCreditAmount - $totalDebitAmount);
						}
					?>
					</td>
					<td align="left" valign="top" style= "text-align: right;"  colspan="1">
					<?php 
						if($totalDebitAmount > $totalCreditAmount){
							echo $this->Number->currency($totalDebitAmount - $totalCreditAmount);
						}
						
					?>
					</td>
				</tr>
				
				<tr>			
					<td align="right" valign="top" style= "text-align: left;"  colspan="2">
					&nbsp;
					</td>
					<td align="left" valign="top" style= "text-align: left;"  colspan="2">
						&nbsp;
					</td>
					<td align="left" valign="top" style= "text-align: right;"  colspan="1">
					<?php 
						if($totalCreditAmount > $totalDebitAmount){
							echo $this->Number->currency($totalCreditAmount);
						}
						if($totalDebitAmount > $totalCreditAmount){
							echo $this->Number->currency($totalDebitAmount);
						}
					?>
					</td>
					<td align="left" valign="top" style= "text-align: right;"  colspan="1">
					<?php 
						if($totalCreditAmount > $totalDebitAmount){
							echo $this->Number->currency($totalCreditAmount);
						}
						if($totalDebitAmount > $totalCreditAmount){
							echo $this->Number->currency($totalDebitAmount);
						}
						
					?>
					</td>
				</tr>
				
				
	</table>
	