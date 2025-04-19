<style>
.table_cell {
    color: #000;
    font-size: 13px;
    padding: 8px 5px;
}
</style>
<table width="100%">
	<tr class="row_title">
		<!--<td><?php echo __('Billing Invoice')?></td>
		<td><?php echo __('Plan ID')?></td>
		<td><?php echo __('Trans Code')?></td>-->
		<td style="text-align: center" width="15%"><?php echo __('Date Received')?></td>
		<td style="text-align: center"><?php echo __('Amount')?></td>
		<td style="text-align: center" width="12%"><?php echo __('Mode Of Payment')?></td>
		<td style="text-align: center" width="15%"><?php echo __('Voucher Type')?></td>
		<td style="text-align: center"><?php echo __('Description')?></td>
		<!--<td><?php echo __('Remit')?></td>
		<td><?php echo __('NRV')?></td>-->
		<td style="text-align: center"><?php echo __('Action')?></td>
	</tr>
	<?php foreach($advancedPayments as $paymentRecord){ ?>
	<?php if($toggle==0){ 
		$greyClass = "row_gray"; $toggle=1;
	}else{$toggle=0; $greyClass='';
}?>
	<tr class="<?php echo $greyClass?>" style="border: none;">
		<!--<td class="table_cell"><?php //echo $paymentRecord[''][''];?></td>
		<td class="table_cell"><?php echo $paymentRecord['Billing']['plan'];?></td>
		<td class="table_cell"><?php echo $paymentRecord['Billing']['transac_code'];?></td>-->
		<td class="table_cell" style="text-align: center"><?php echo $this->DateFormat->formatDate2Local($paymentRecord['Billing']['date'],Configure::read('date_format'),false);?></td>
		<td class="table_cell" style="text-align: center"><?php if($paymentRecord['Billing']['refund']==1){
										echo $this->Number->currency(ceil($paymentRecord['Billing']['paid_to_patient']));
		  							 }else{
				  						echo $this->Number->currency(ceil($paymentRecord['Billing']['amount'])); 
									 }?></td>
		<td class="table_cell" style="text-align: center"><?php echo $paymentRecord['Billing']['mode_of_payment'];?></td>
		<?php $refundValue = ($paymentRecord['Billing']['refund'])?>
		<td class="table_cell" style="text-align: center">
		<?php if($refundValue==0){
		 echo "Receipt";
		}else{
		echo "Payment";}?></td>
		<td class="table_cell" style="text-align: center"><?php echo ucwords($paymentRecord['Billing']['description']);?></td>
		<!--<td class="table_cell"><?php echo $paymentRecord['Billing']['remit'];?></td>
		<td class="table_cell"><?php echo $paymentRecord['Billing']['nvr'];?></td>-->
		<td class="table_cell" style="text-align: center"><?php echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
     		array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Billings','action'=>'printAdvanceReceipt',
     		$paymentRecord['Billing']['id']))."', '_blank',
           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?></td>
	</tr>
	<?php }?>
</table>
<?php //debug($advancedPayments);?>