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
	..tabularForm td{background:none;}
	@media print {

  		#printButton{display:none;}
    }
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
			<td>No. : <b> <?php echo $accountReceiptData['AccountReceipt']['id']; ?></b></td>
			<td>&nbsp;</td>
			<td>Dated:  <b><?php echo $this->DateFormat->formatDate2Local($accountReceiptData['AccountReceipt']['date'],Configure::read('date_format'),false); ?></b></td>
		</tr>
		
		<tr><td>&nbsp;</td></tr> 
		
		<tr><td>&nbsp;</td>
			<td style="text-align: center;">
				<?php echo Configure::read('locationLable');//echo $hospital_details['Location']['name']; ?><br>
				<?php echo $hospital_details['Location']['address1']; ?><br>
				<?php echo $hospital_details['City']['name'].' - '.$hospital_details['Location']['zipcode']; ?><br>
				<?php echo '<u>'.'E-Mail : '.$hospital_details['Location']['email'].'</u>'; ?><br>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr> 
		<!-- <tr>	  
		  	<td valign="top" style="text-decoration:underline;letter-spacing: 0.2em; text-align:center" colspan="3"><strong>RECEIPT VOUCHER</strong></td>
		</tr> -->
		<tr><td>&nbsp;</td></tr> 
		<tr>
		  	<td><i>Received with thanks from </i> </td>
		  	<?php if(empty($accountReceiptData['AccountReceipt']['name_on_receipt'])){?>
		  	<td><b><?php echo ":". "&nbsp;&nbsp;".$accountReceiptData['Account']['name']; ?></b></td>
		<?php } else {?>
			<td><b><?php echo ":". "&nbsp;&nbsp;".$accountReceiptData['AccountReceipt']['name_on_receipt']; ?></b></td>
		<?php }?>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		  	<td><i>The sum of</i></td>
		  	<td><b><?php echo ":". "&nbsp;&nbsp;".$this->RupeesToWords->no_to_words($accountReceiptData['AccountReceipt']['paid_amount']); ?></b></td>	
		</tr>
		<tr><td>&nbsp;</td></tr> 
		<tr>
		  	<td><i>By </i></td>
		  	<td><b><?php echo ":". "&nbsp;&nbsp;".$accountReceiptData['AccountAlias']['name']; ?></b></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td><i>Remarks</i></td>
			<td><b><?php echo ":". "&nbsp;&nbsp;".$accountReceiptData['AccountReceipt']['narration']; ?></b></td>
		</tr>
		</tr>
		<tr><td>&nbsp;</td></tr> 
		<tr>
		
		<tr><td>&nbsp;</td></tr>
		<tr>
		  	<td width="1%" style="text-decoration:underline;"><b><?php echo $this->Number->currency($accountReceiptData['AccountReceipt']['paid_amount'])."/-"; ?></b></td>
		  	<td width="1%"> Name & Sign of Patient</td>
		  	<td width="1%"> Authorised Signatory</td>
		</tr>
	</table> 
</body>
 </html>