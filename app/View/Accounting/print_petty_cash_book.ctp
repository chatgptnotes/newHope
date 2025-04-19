<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $hospital_details = $this->General->billingHeader($this->Session->read('locationid'));?>
<?php echo $this->Html->charset(); ?>
<title>
	<?php echo __('Hope', true); ?>	 
</title>
	<?php echo $this->Html->css('internal_style.css');?> 
<style>
	@media print {
  		#printButton{display:none;}
    }
</style> 
</head>
<body style="background:none;width:98%;margin:auto;">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="padding-left:30px;" align="center" >
		  <tr>
			  <td colspan="4" align="right">
				  <div id="printButton">
						<?php echo $this->Html->link(__('Print', true),'#',array('escape'=>false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
				  </div>
		 	 </td>
		  </tr>
		  
		  <tr>
		  	<td>&nbsp;</td>
			<td style="text-align: center;">
				<?php echo Configure::read('locationLable');?><br>
				<?php echo $hospital_details['Location']['address1']; ?><br>
				<?php echo $hospital_details['City']['name'].' - '.$hospital_details['Location']['zipcode']; ?><br>
				<?php echo '<u>'.'E-Mail : '.$hospital_details['Location']['email'].'</u>'; ?><br>
			</td>
		</tr>

		<tr>
		  	<td>&nbsp;</td>		  
		  	<td valign="top" colspan="2" style="text-align:center;font-size:18px;"><strong><?php echo __("Petty Cash Book");?></strong></td>
		</tr>
		<tr>
		  	<td>&nbsp;</td>		  
		  	<td valign="top" colspan="2" style="letter-spacing: 0.1em;text-align:center;">
		  	<?php if(empty($dateArray)){
		  				$getFrm=explode(" ",$from);
						$getFrmFinal = str_replace("/", "-",$getFrm[0]);				
						$getFrmFinal=date('jS-M-Y', strtotime($getFrmFinal));					
						$getTo=explode(" ",$to);
						$getToFinal = str_replace("/", "-",$getTo[0]);
						$getToFinal=date('jS-M-Y', strtotime($getToFinal));
					echo $getFrmFinal." To ".$getToFinal; 
		  				}else{
						$getTo=explode(" ",$to);
						$getToFinal = str_replace("/", "-",$getTo[0]);
						$getToFinal=date('jS-M-Y', strtotime($getToFinal));
					echo $getToFinal;
						}
				?>
				</td>
		    </tr>
	</table> 
	<table width="90%" cellpadding="0" cellspacing="0" border="1" align="center">
	<tr> 
		<th width="7%" align="center" valign="top" style="text-align: center;"><?php echo __('Date');?></th>
		<th width="47%" align="center" valign="top" style="text-align: center;"><?php echo __('Particulars');?></th> 
		<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Voucher Type');?></th>
		<th width="10%" valign="top" style="text-align: center;"><?php echo __('Voucher No.');?></th> 
		<th width="13%" align="center" valign="top" style="text-align: center;"><?php echo __('Debit');?></th>
		<th width="13%" align="center" valign="top" style="text-align: center;"><?php echo __('Credit');?></th>  
	</tr> 
	
	<tr>
		<td valign="top" style= "text-align: center;">
			<?php echo $from; ?>
		</td>
		<td valign="top" style= "text-align: center;font-weight:bold">
			<?php echo __('Opening Balance');?>
		</td>
		
		<td valign="top" style= "text-align: center;">
			&nbsp;
		</td>
		<td valign="top" style= "text-align: center;">
			&nbsp;
		</td>
		<td  valign="top" style= "text-align: center;font-weight:bold">
			<?php if($type=='Dr'){ ?>
			<?php echo $this->Number->currency($openingBalance);?>
			<?php } ?>
		</td>

		<td align="left" valign="top" style= "text-align: right;">
			<?php if($type=='Cr'){ ?>
				<?php echo $this->Number->currency($openingBalance);?>					
			<?php }	?>
		</td>  
	</tr>
<?php 
$totalCreditAmount = $totalDebitAmount = 0;
//only shows entry receipt n payment by cash /commented by amit jain 
if($isHide == 0){
	$display = "display:block";
}else{
	$display = "display:none";
}
?>
<!-- for Payment Voucher Entry by amit jain -->
<?php if($this->request->data['Voucher']['type']!='debit' ){
 foreach($voucherPaymentDetails as $voucherPaymentDetails){?>			
	 <tr>
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo $this->DateFormat->formatDate2Local($voucherPaymentDetails['VoucherPayment']['date'],Configure::read('date_format'),true); ?>
		</td>
		
		<td align="left" valign="top" style= "text-align: left;">
			<div style="padding-left:35px;padding-bottom:3px;">
				<?php echo $voucherPaymentDetails['Account']['name'] ;?>
			</div>
			<div style="padding-left: 65px; font-size:13px; font-style:italic;">
				<?php echo __('Entered By : ').$voucherPaymentDetails['User']['first_name'].' '.$voucherPaymentDetails['User']['last_name'] ;?>
			</div>
			<div style="padding-left:65px;padding-top:5px; font-style:italic;<?php echo $display?>">
				<?php echo __('Narration : ').$voucherPaymentDetails['VoucherPayment']['narration'] ; ?>
			</div>
		</td>
		
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo __("Payment") ;?>
		</td>
		
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo $voucherPaymentDetails['VoucherPayment']['id'] ;?>
		</td>
		
		<?php if($voucherPaymentDetails['VoucherPayment']['account_id']==$cash['Account']['id']) { ?>
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo $this->Number->currency($voucherPaymentDetails['VoucherPayment']['paid_amount']) ;
			$totalDebitAmount +=  (int) $voucherPaymentDetails['VoucherPayment']['paid_amount'];
			?>
		</td>
		<td align="left" valign="top" style= "text-align: right;">
			&nbsp;
		</td> 
		<?php } else{ ?>
		
		<td align="left" valign="top" style= "text-align: right;">
			&nbsp;
		</td>
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo $this->Number->currency($voucherPaymentDetails['VoucherPayment']['paid_amount']) ;
			$totalCreditAmount +=  (int) $voucherPaymentDetails['VoucherPayment']['paid_amount'];
			?>
		</td> 
		<?php }?>
	</tr>
<?php } ?>	
<?php } ?>
<!-- for Receipt Voucher Entry by amit jain -->
<?php if($this->request->data['Voucher']['type']!='credit' ){
 foreach($transactionPaidAccounts as $transactionPaidAccounts) { ?>			
	 <tr>
		<td align="left" valign="top" style= "text-align: left;">
			<?php echo $this->DateFormat->formatDate2Local($transactionPaidAccounts['AccountReceipt']['date'],Configure::read('date_format'),true); ?>
		</td>
		
		<td align="left" valign="top" style= "text-align: left;">
			<div style="padding-left:35px;padding-bottom:3px;">
				<?php echo $transactionPaidAccounts['Account']['name']; ?>
			</div>
			<div style="padding-left: 65px; font-size:13px; font-style:italic;">
				<?php echo __('Entered By : ').$transactionPaidAccounts['User']['first_name'].' '.$transactionPaidAccounts['User']['last_name']; ?>
			</div>
			<div style="padding-left:65px;padding-top:5px; font-style:italic;<?php echo $display?>">
				<?php echo __('Narration : ').$transactionPaidAccounts['AccountReceipt']['narration']; ?>
			</div>
		</td>
		
		<td align="left" valign="top" style= "text-align: center;"  >
			<?php echo __("Receipt") ;?>
		</td>
		
		<td align="left" valign="top" style= "text-align: center;"  >
			<?php echo $transactionPaidAccounts['AccountReceipt']['id']; ?>
		</td>
			
		<?php if($transactionPaidAccounts['AccountReceipt']['account_id']==$cash['Account']['id']) { ?>
		<td align="left" valign="top" style= "text-align: right;"  >
			&nbsp;
		<td align="left" valign="top" style= "text-align: center;"  >
			<?php echo $this->Number->currency($transactionPaidAccounts['AccountReceipt']['paid_amount']) ;
			$totalCreditAmount +=  (int) $transactionPaidAccounts['AccountReceipt']['paid_amount'];
			?>
		</td>
		<?php } else{ ?>
		<td align="left" valign="top" style= "text-align: center;"  >
			<?php echo $this->Number->currency($transactionPaidAccounts['AccountReceipt']['paid_amount']) ;
			$totalDebitAmount +=  (int) $transactionPaidAccounts['AccountReceipt']['paid_amount'];
			?>
		<td align="left" valign="top" style= "text-align: right;"  >
			&nbsp;
		</td>
		<?php }?>
	</tr>
<?php } }?>
<?php foreach($transactionContraEntry as $transactionContraEntry){
	if($transactionContraEntry['Account']['alias_name'] == 'Petty Cash-in-hand'){
		if($this->request->data['Voucher']['type']!='debit' ){ ?>
		 <tr>
			<td align="left" valign="top" style= "text-align: left;">
				<?php echo $this->DateFormat->formatDate2Local($transactionContraEntry['ContraEntry']['date'],Configure::read('date_format'),true) ; ?>
			</td>
			<td align="left" valign="top" style= "text-align: left;">
				<div style="padding-left:35px;padding-bottom:3px;">
					<?php echo $transactionContraEntry['AccountAlias']['name'] ; ?>
				</div>
				<div style="padding-left: 65px; font-size:13px; font-style:italic;">
					<?php echo __('Entered By : ').$transactionContraEntry['User']['first_name'].' '.$transactionContraEntry['User']['last_name'] ;?>
				</div>
				<div style="padding-left:65px;padding-top:5px; font-style:italic;<?php echo $display?>">
					<?php echo __('Narration : ').$transactionContraEntry['ContraEntry']['narration'];?>
				</div>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;">
				<?php echo __("Contra") ;?>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;">
				<?php echo $transactionContraEntry['ContraEntry']['id'] ;?>
			</td>
			
			<td>&nbsp;</td>
			<td align="left" valign="top" style= "text-align: center;"  >
				<?php echo $this->Number->currency($transactionContraEntry['ContraEntry']['debit_amount']) ;
				$totalCreditAmount +=  (int) $transactionContraEntry['ContraEntry']['debit_amount'];
				?>
			</td> 
		</tr>
	<?php } } else {  if($this->request->data['Voucher']['type']!='credit' ){?>
		<tr>
			<td align="left" valign="top" style= "text-align: left;">
				<?php echo $this->DateFormat->formatDate2Local($transactionContraEntry['ContraEntry']['date'],Configure::read('date_format'),true) ; ?>
			</td>
			<td align="left" valign="top" style= "text-align: left;">
				<div style="padding-left:35px;padding-bottom:3px;">
					<?php echo $transactionContraEntry['Account']['name'] ; ?>
				</div>
				<div style="padding-left: 65px; font-size:13px; font-style:italic;">
					<?php echo __('Entered By : ').$transactionContraEntry['User']['first_name'].' '.$transactionContraEntry['User']['last_name'] ;?>
				</div>
				<div style="padding-left:65px;padding-top:5px; font-style:italic;<?php echo $display?>">
					<?php echo __('Narration : ').$transactionContraEntry['ContraEntry']['narration'];?>
				</div>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;"  >
				<?php echo __("Contra") ;?>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;"  >
				<?php echo $transactionContraEntry['ContraEntry']['id'] ;?>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;">
				<?php echo $this->Number->currency($transactionContraEntry['ContraEntry']['debit_amount']) ;
				$totalDebitAmount +=  (int) $transactionContraEntry['ContraEntry']['debit_amount'];?>
			</td>
			<td>&nbsp;</td>
		</tr>
	<?php }}?>
<?php }	
			$totalDebitAmount += (double) $openingBalance;?>
			    <tr>			
					<td valign="top" style= "text-align: center;"  colspan="4">
					&nbsp;
					</td>
					<td valign="top" style= "text-align: center;border-top:solid 1px #000000;"  colspan="1">
					<?php echo $this->Number->currency($totalDebitAmount);?>
					</td>
					<td valign="top" style= "text-align: center;border-top:solid 1px #000000;"  colspan="1">
					<?php echo $this->Number->currency($totalCreditAmount);?>
					</td>
				</tr>
				
				<tr>			
					<td valign="top" style= "text-align: center;"  colspan="4" >
					<strong><?php echo __("Closing Balance");?></strong> 
					</td>
					<td valign="top" style= "text-align: center;border-bottom:solid 1px #000000;"  colspan="1">
						<b>
						<?php 
							if($totalCreditAmount > $totalDebitAmount){
								echo $this->Number->currency($totalCreditAmount - $totalDebitAmount);
							}else{
							echo "&nbsp";
							}
						?>
						</b>
					</td>
					<td valign="top" style= "text-align: center;border-bottom:solid 1px #000000;"  colspan="1">
						<b>
						<?php 
							if($totalDebitAmount > $totalCreditAmount){
								echo $this->Number->currency($totalDebitAmount - $totalCreditAmount);
							}else{
							echo "&nbsp";
							}
						?>
						</b>
					</td>
				</tr>
				
				<tr>			
					<td valign="top" style= "text-align: center;"  colspan="4">
					&nbsp;
					</td>
					
					<td valign="top" style= "text-align: center;border-bottom:solid 1px #000000;"  colspan="1">
					<?php 
						if($totalCreditAmount > $totalDebitAmount){
							echo $this->Number->currency($totalCreditAmount);
						}
						if($totalDebitAmount > $totalCreditAmount){
							echo $this->Number->currency($totalDebitAmount);
						}
					?>
					</td>
					<td valign="top" style= "text-align: center;border-bottom:solid 1px #000000;"  colspan="1">
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
</body>
 </html>                    
  
 