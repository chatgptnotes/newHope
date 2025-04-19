<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html moznomarginboxes mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $hospital_details = $this->General->billingHeader($journalData['location_id']);?>
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
			<td style="text-align: center;" colspan="3">
				<?php echo $hospital_details['Location']['name']; ?><br>
				<?php echo $hospital_details['Location']['address1']; ?><br>
				<?php echo $hospital_details['City']['name'].' - '.$hospital_details['Location']['zipcode']; ?><br>
				<?php echo '<u>'.'E-Mail : '.$hospital_details['Location']['email'].'</u>'; ?><br>
			</td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>
		  
		<tr>	  
		  	<td valign="top" style="text-align:center;font-size:15px;" colspan="3"><strong><?php echo __("Journal Voucher");?></strong></td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>
		  
		<tr>
			<td><?php echo __("No. : ");?><b> <?php echo $journalData['journal_voucher_no']; ?></b></td>
			<td align="right"><?php echo __("Dated : ");?></td>
			<td align="right"><b><?php echo date('j-M-Y',strtotime($journalData['date'])); ?></b></td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>  
		<tr>
			<td style="padding-left:20px;" class="bor_right border" width="70%"><?php echo __("Particulars");?></td>
			<td align="right" class="bor_right border" width="15%"><?php echo __("Debit");?></td>
			<td align="right" class="border" width="15%"><?php echo __("Credit");?></td>
		</tr>
		<tr>
			<td style="padding-left:30px;" class="bor_right"><span style="float:left"><?php echo $journalData['debit']['name']; ?></span><span style="float:right"><i><?php echo __("Dr");?></i></td>
			<td align="right" class="bor_right"><b><?php echo $this->Number->precision($journalData['debit']['debit_amount'],2); ?></b></td>
			<td></td>
		</tr>
		<?php foreach ($journalData['credit'] as $data){?>
		<tr>
		  	<td class="bor_right"><i><?php echo __("To ");?></i> <?php echo $data['name']; ?></td>
		  	<td class="bor_right"></td>
		  	<td align="right"><b><?php echo $this->Number->precision($data['credit_amount'],2); ?></b></td>
		</tr>
		<?php }?>
		<tr>
			<td height="200px;" class="bor_right"></td>
			<td height="200px;" class="bor_right"></td>
			<td height="200px;"></td>
		</tr>
		<tr>
			<td class="bor_right"><b><?php echo __("On Account of : ");?></b></td>
			<td class="bor_right"></td>
		</tr>
		<tr>
			<td style="padding-left:30px;" class="bor_right"><?php echo $journalData['narration']; ?></td>
			<td class="bor_right"></td>
			<td></td>
		</tr>
		<tr>
			<td class="bor_right"></td>
			<td class="bor_right border" align="right"><b><?php echo $this->Number->precision($journalData['total_amount'],2); ?></b></td>
			<td class="border" align="right"><b><?php echo $this->Number->precision($journalData['total_amount'],2); ?></b></td>
		</tr>
		
		<tr>
			<td height="30px;"></td>
			<td height="30px;"></td>
			<td height="30px;"></td>
		</tr>
		
		<tr>
		  	<td></td>
		  	<td colspan="2" align="right"><?php echo __("Authorised Signatory");?></td>
		</tr>
	</table> 
</body>
</html>