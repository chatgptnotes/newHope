<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html moznomarginboxes mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $hospital_details = $this->General->billingHeader($this->Session->read('locationid'));?>
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		 
	</title>
	<?php echo $this->Html->css('internal_style.css');?> 
	<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
	.heading{font-weight:bold; padding-bottom:10px; font-size:19px; text-decoration:underline;}
	.headBorder{border:1px solid #ccc; padding:3px 0 15px 3px;}
	.title{font-size:14px; text-decoration:underline; font-weight:bold; padding-bottom:10px;color:#000;}
	input, textarea{border:1px solid #999999; padding:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.tbl .totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	.tabularForm td{background:none;}
	@media print {

  		#printButton{display:none;}
    }
    .bor_right{border-right:1px solid #000;}
    .border{border-top:1px solid #000 !important;border-bottom:1px solid #000 !important;}
</style> 
 
</head>
<body style="background:none;width:98%;margin:auto;">
 

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="800px;" style="padding-top:0px;padding-left:30px;" align="center">
		<tr>
			<td colspan="3" align="right">
			<div id="printButton">
			  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();')); ?>
			 </div>
		 	</td>
		</tr>
		
		
		<tr>
			<td style="text-align: center;" colspan="2">
				<?php echo Configure::read('locationLable');//echo $hospital_details['Location']['name']; ?><br>
				<?php echo $hospital_details['Location']['address1']; ?><br>
				<?php echo $hospital_details['City']['name'].' - '.$hospital_details['Location']['zipcode']; ?><br>
				<?php echo '<u>'.'E-Mail : '.$hospital_details['Location']['email'].'</u>'; ?><br>
			</td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>
		  
		<tr>	  
		  	<td valign="top" style="text-align:center;font-size:15px;" colspan="3"><strong>PAYMENT VOUCHER</strong></td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>
		  
		  
		  <tr>
			<td>No. : <b> <?php echo $voucherPaymentData['VoucherPayment']['id']; ?></b></td>
			<td align="center">Dated:  <b><?php echo $this->DateFormat->formatDate2Local($voucherPaymentData['VoucherPayment']['date'],Configure::read('date_format'),false); ?></b></td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>  
		<tr>
			<td style="padding-left:20px;" class="bor_right border">Particulars</td>
			<td align="center" class="border" style="">Amount</td>
		</tr>
		<tr>
		  	<td class="bor_right"><b>Account : </b> </td>
		  	<td></td>
		</tr>
		<tr>
		<td style="padding-left:30px;" class="bor_right"><?php echo $voucherPaymentData['Account']['name']; ?></td>
		<td align="center"><b><?php echo $this->Number->currency($voucherPaymentData['VoucherPayment']['paid_amount']); ?></b></td>
		</tr>
		<tr><td class="bor_right">&nbsp;</td></tr>
		  
		<tr>
		  	<td class="bor_right"><b>Through :</b></td>
		</tr>
		
		<tr>
			<td style="padding-left:30px;" class="bor_right"><?php echo $voucherPaymentData['AccountAlias']['name']; ?></td>
		</tr>
		<tr>
			<td class="bor_right"><b>On Account of :</b></td>
		</tr>
		
		<tr>
			<td style="padding-left:30px;" class="bor_right"><?php echo $voucherPaymentData['VoucherPayment']['narration']; ?></td>
		</tr>
		<tr>
		  	<td class="bor_right"><b>Amount (in words):</b></td>
		</tr>
		<tr>
			<td style="padding-left:30px;" class="bor_right"><?php echo $this->RupeesToWords->no_to_words($voucherPaymentData['VoucherPayment']['paid_amount']); ?></td>	
		</tr>
		<tr>
			<td class="bor_right">&nbsp;</td>
			<td align="center" class="border"><b><?php echo $this->Number->currency($voucherPaymentData['VoucherPayment']['paid_amount']); ?></b></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		
		<tr>
		  	<td> Receiver's Signature:</td>
		  	<td> Authorised Signatory</td>
		</tr>
	</table> 
 
</body>
 </html>