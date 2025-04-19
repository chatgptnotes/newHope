<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Cash_book_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
<style>
body{
font-size:13px;
}
</style>
<STYLE type='text/css'>
.tableTd {
border-width: 0.5pt;
border: solid;
}
.tableTdContent{
border-width: 0.5pt;
border: solid;
}
#titles{
font-weight: bolder;
}

</STYLE>
	<table cellspacing="0" cellpadding="0" width="98%" align="center">
		<tr>
			<td></td>
			<td align="right">
			<?php echo __('Cash Book', true); ?>
			<?php $from1=explode(' ',$from);
				  $to1=explode(' ',$to);
				  
				  if($from!=null || $to!=null)
				  echo $from1[0]."  To ".$to1[0];
				  ?>
			</td>
		</tr>
	</table>

<table width="90%" cellpadding="0" cellspacing="0" border="1" align="center">
	<tr> 
		<th width="7%" align="center" valign="top" style="text-align: center;"><?php echo __('Date');?></th>
		<th width="47%" align="center" valign="top" style="text-align: center;"><?php echo __('Particulars');?></th> 
		<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Voucher Type');?></th>
		<th width="10%" valign="top"><?php echo __('Voucher No.');?></th> 
		<th width="13%" align="center" valign="top" style="text-align: center;"><?php echo __('Debit');?></th>
		<th width="13%" align="center" valign="top" style="text-align: center;"><?php echo __('Credit');?></th>  
	</tr> 
	
	<tr>
		<td valign="top" style= "text-align: center;">
			<?php echo $this->DateFormat->formatDate2Local($transactionPaidAccounts[0]['AccountReceipt']['date'],Configure::read('date_format')); ?>
		</td>
		<td  valign="top" style= "text-align: center;font-weight:bold">
			<?php echo __('Opening Balance');?>
		</td>
		
		<td  valign="top" style= "text-align: center;">
			&nbsp;
		</td>
		<td valign="top" style= "text-align: center;">
			&nbsp;
		</td>
		<td  valign="top" style= "text-align: center;font-weight:bold">
			<?php if($type=='Dr'){
				echo $this->Number->currency($openingBalance);
			} ?>
		</td>

		<td align="left" valign="top" style= "text-align: right;">
			<?php if($type=='Cr'){
				echo $this->Number->currency($openingBalance);			
			}?>
		</td>  
	</tr>
<?php 
$totalCreditAmount = $totalDebitAmount = 0;
//only shows entry receipt n payment by cash /commented by amit jain 
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
			<div style="padding-left: 35px; font-size:13px; font-style:italic;">
				<?php echo __('Entered By : ').$voucherPaymentDetails['User']['first_name'].' '.$voucherPaymentDetails['User']['last_name'] ;?>
			</div>
			<?php if($isHide == 0){?>
			<div style="padding-left:35px;padding-top:5px; font-style:italic;">
				<?php echo __('Narration : ').$voucherPaymentDetails['VoucherPayment']['narration'] ; ?>
			</div>
			<?php }?>
		</td>
		
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo __("Payment") ;?>
		</td>
		
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo $voucherPaymentDetails['VoucherPayment']['payment_voucher_no'] ;?>
		</td>
		
		<?php if($voucherPaymentDetails['VoucherPayment']['account_id']==$cash['Account']['id']) { ?>
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo $this->Number->currency($voucherPaymentDetails['VoucherPayment']['paid_amount']) ;
			$totalDebitAmount +=  (double) $voucherPaymentDetails['VoucherPayment']['paid_amount'];
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
			$totalCreditAmount +=  (double) $voucherPaymentDetails['VoucherPayment']['paid_amount'];
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
			<div style="padding-left: 35px; font-size:13px; font-style:italic;">
				<?php echo __('Entered By : ').$transactionPaidAccounts['User']['first_name'].' '.$transactionPaidAccounts['User']['last_name']; ?>
			</div>
			<?php if($isHide == 0){?>
			<div style="padding-left:35px;padding-top:5px; font-style:italic;">
				<?php echo __('Narration : ').$transactionPaidAccounts['AccountReceipt']['narration']; ?>
			</div>
			<?php }?>
		</td>
		
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo __("Receipt") ;?>
		</td>
		
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo $transactionPaidAccounts['AccountReceipt']['account_receipt_no']; ?>
		</td>
			
		<?php if($transactionPaidAccounts['AccountReceipt']['account_id']==$cash['Account']['id']) { ?>
		<td align="left" valign="top" style= "text-align: right;">
			&nbsp;
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo $this->Number->currency($transactionPaidAccounts['AccountReceipt']['paid_amount']) ;
			$totalCreditAmount +=  (double) $transactionPaidAccounts['AccountReceipt']['paid_amount'];
			?>
		</td>
		<?php } else{ ?>
		<td align="left" valign="top" style= "text-align: center;">
			<?php echo $this->Number->currency($transactionPaidAccounts['AccountReceipt']['paid_amount']) ;
			$totalDebitAmount +=  (double) $transactionPaidAccounts['AccountReceipt']['paid_amount'];
			?>
		<td align="left" valign="top" style= "text-align: right;">
			&nbsp;
		</td>
		<?php }?>
	</tr>
<?php }
}?>
<?php foreach($transactionContraEntry as $transactionContraEntry){
	if(strtolower($transactionContraEntry['Account']['name']) == strtolower(Configure::read('cash'))){?>
	<?php if($this->request->data['Voucher']['type']!='debit' ){ ?>
		 <tr>
			<td align="left" valign="top" style= "text-align: left;">
				<?php echo $this->DateFormat->formatDate2Local($transactionContraEntry['ContraEntry']['date'],Configure::read('date_format'),true) ; ?>
			</td>
			<td align="left" valign="top" style= "text-align: left;">
				<div style="padding-left:35px;padding-bottom:3px;">
					<?php echo $transactionContraEntry['AccountAlias']['name'] ; ?>
				</div>
				<div style="padding-left: 35px; font-size:13px; font-style:italic;">
					<?php echo __('Entered By : ').$transactionContraEntry['User']['first_name'].' '.$transactionContraEntry['User']['last_name'] ;?>
				</div>
				<?php if($isHide == 0){?>
				<div style="padding-left:35px;padding-top:5px; font-style:italic;">
					<?php echo __('Narration : ').$transactionContraEntry['ContraEntry']['narration'];?>
				</div>
				<?php }?>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;">
				<?php echo __("Contra") ;?>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;">
				<?php echo $transactionContraEntry['ContraEntry']['contra_voucher_no'] ;?>
			</td>
			
			<td>&nbsp;</td>
			<td align="left" valign="top" style= "text-align: center;"  >
				<?php echo $this->Number->currency($transactionContraEntry['ContraEntry']['debit_amount']) ;
				$totalCreditAmount +=  (double) $transactionContraEntry['ContraEntry']['debit_amount'];
				?>
			</td> 
		</tr>
	<?php } 
		}else{
		if($this->request->data['Voucher']['type']!='credit' ){?>
		<tr>
			<td align="left" valign="top" style= "text-align: left;">
				<?php echo $this->DateFormat->formatDate2Local($transactionContraEntry['ContraEntry']['date'],Configure::read('date_format'),true) ; ?>
			</td>
			<td align="left" valign="top" style= "text-align: left;">
				<div style="padding-left:35px;padding-bottom:3px;">
					<?php echo $transactionContraEntry['Account']['name'] ; ?>
				</div>
				<div style="padding-left: 35px; font-size:13px; font-style:italic;">
					<?php echo __('Entered By : ').$transactionContraEntry['User']['first_name'].' '.$transactionContraEntry['User']['last_name'] ;?>
				</div>
				<?php if($isHide == 0){?>
				<div style="padding-left:35px;padding-top:5px; font-style:italic;">
					<?php echo __('Narration : ').$transactionContraEntry['ContraEntry']['narration'];?>
				</div>
				<?php }?>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;">
				<?php echo __("Contra") ;?>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;">
				<?php echo $transactionContraEntry['ContraEntry']['contra_voucher_no'] ;?>
			</td>
			
			<td align="left" valign="top" style= "text-align: center;">
				<?php echo $this->Number->currency($transactionContraEntry['ContraEntry']['debit_amount']) ;
				$totalDebitAmount +=  (double) $transactionContraEntry['ContraEntry']['debit_amount'];?>
			</td>
			<td>&nbsp;</td>
		</tr>
	<?php }
		}
	}?>
		<?php $totalDebitAmount += (double) $openingBalance;?>
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
			<td valign="top" style= "text-align: right;"  colspan="4" >
			<strong><?php echo __("Closing Balance :");?></strong> 
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