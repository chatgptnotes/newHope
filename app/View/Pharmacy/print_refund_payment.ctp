<?php $website=$this->Session->read("website.instance");
if($website=='kanpur')
{
	if($this->request->query['header'] == 'without')
	{
		$paddingTop="24%";
	}
	
	$class="";
	$cls_left_border="bor_left";
	$cls_bot_border="bor_bottom";
	$cls_right_border="bor_right";
}else {
	$class="table_format";
	$cls_left_border="";
	$cls_bot_border="";
	$cls_right_border="";
}?>

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
	<link rel="stylesheet" type="text/css" href="http://cdn.webrupee.com/font" />
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
    .bor_left{border-left:1px solid #000;}
    .bor_bottom{border-bottom:1px solid #000;}
    .border{border-top:1px solid #000 !important;border-bottom:1px solid #000 !important;}
</style> 
 
</head>
<body style="background:none;width:98%;margin:auto;">
	<table width="200" style="float:right">
	<tr>
		<td align="right">
		<div id="printButton"><?php 

		echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
		?>
		</div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	</table>
	<?php

		if($website=='vadodara'){
	?>
	<table width="800">
		<tr>
			<td><div style="float:left"><?php echo  $this->Html->image('icons/MSA.jpg',array('width'=>100,'height'=>100)) ; ?></div></td>
			<td><div style="float:right"><?php echo  $this->Html->image('icons/KCHRC.jpg',array('width'=>100,'height'=>100)) ; ?></td>  
		</tr>
	</table>
	<?php } ?>
	
	<table border="0" class="<?php echo $class;?>" cellpadding="0" cellspacing="0" width="800px;" style="padding-top:<?php echo $paddingTop;?>;padding-left: 8px"  >
		<?php  
		if($website !='kanpur'){
		?>
		<tr>
			<td style="text-align: center;" colspan="2">
				<?php //echo $hospital_details['Location']['name']; ?><br>
				<?php //echo $hospital_details['Location']['address1']; ?><br>
				<?php //echo $hospital_details['City']['name'].' - '.$hospital_details['Location']['zipcode']; ?><br>
				<?php //echo '<u>'.'E-Mail : '.$hospital_details['Location']['email'].'</u>'; ?><br>
			</td>
		</tr>
		
		<tr>
			<td style="text-align: center;" colspan="2">
				<?php echo $hospital_details['Location']['name']; ?><br>
				<?php echo $hospital_details['Location']['address1']; ?><br>
				<?php echo $hospital_details['City']['name'].' - '.$hospital_details['Location']['zipcode']; ?><br>
				<?php echo '<u>'.'E-Mail : '.$hospital_details['Location']['email'].'</u>'; ?><br>
			</td>
		</tr>
		
		  <!-- 
		<tr>	  
		  	<td valign="top" style="text-align:center;font-size:15px;" colspan="3"><strong>PAYMENT VOUCHER</strong></td>
		</tr>
		 -->
		<tr><td>&nbsp;</td></tr>
		<?php }?>
		<tr>
			<!-- <td>No. : <b> <?php //echo $voucherPaymentData['VoucherPayment']['payment_voucher_no']; ?></b></td> -->
			<td align="center" style="font-size: 16px;padding-left: 20%"><strong>Refund Receipt</strong></td>
			<td align="center">Dated:  <b><?php echo $this->DateFormat->formatDate2Local($billingData['Billing']['date'],Configure::read('date_format'),false); ?></b></td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>  
		<tr>
			<td style="padding-left:20px;" class="bor_right border <?php echo $cls_left_border;?>">Particulars</td>
			<td align="center" class="border <?php echo $cls_right_border;?>" style="">Amount</td>
		</tr>
		<tr><td class="bor_right <?php echo $cls_left_border;?>">&nbsp;</td>
		    <td class="bor_right <?php echo $cls_right_border;?>">&nbsp;</td>
		</tr>
		<tr><td style="padding-left:10px;" class="bor_right <?php echo $cls_left_border;?>"><b>Account :</b></td>
			<td class="bor_right <?php echo $cls_right_border;?>">&nbsp;</td>
		</tr>
		 
		 
		<tr>
			<td style="padding-left:30px;" class="bor_right <?php echo $cls_left_border;?>"><?php echo $data['PharmacySalesBill']['customer_name'];?></td>
			<td align="center" class="<?php echo $cls_right_border;?>"><b><?php echo $this->Number->currency($data['PharmacySalesBill']['paid_to_patient']); ?></b></td>
		</tr>
		
		<tr><td class="bor_right <?php echo $cls_left_border;?>">&nbsp;</td>
			<td class="bor_right <?php echo $cls_right_border;?>">&nbsp;</td>
		</tr>
	  
		<tr><td style="padding-left:10px;" class="bor_right <?php echo $cls_left_border;?>"><b>Remark :</b></td>
			<td class="bor_right <?php echo $cls_right_border;?>">&nbsp;</td>
		</tr>
		
		<tr><td style="padding-left:30px;" class="bor_right <?php echo $cls_left_border;?>"><?php echo $data['PharmacySalesBill']['remark'];?><?php if($website == 'kanpur') echo "&nbsp;".$billingData['Billing']['id']; ?></td>
			<td class="bor_right <?php echo $cls_right_border;?>">&nbsp;</td>
		</tr>
		
		<tr><td class="bor_right <?php echo $cls_left_border;?>">&nbsp;</td>
			<td class="bor_right <?php echo $cls_right_border;?>">&nbsp;</td>
		</tr>
		
		<tr><td style="padding-left:10px;" class="bor_right <?php echo $cls_left_border;?>"><b>Amount (in words):</b></td>
			<td class="bor_right <?php echo $cls_right_border;?>">&nbsp;</td>
		</tr>
		
		<tr>
			<td style="padding-left:30px;" class="bor_right <?php echo $cls_left_border;?>"><?php 
				//echo $this->RupeesToWords->no_to_words(); ?></td>	
			<td class="bor_right <?php echo $cls_right_border;?>">&nbsp;</td>
		</tr>
		
		<tr>
			<td class="bor_right <?php echo $cls_left_border;?> <?php echo $cls_bot_border;?>">&nbsp;</td>
			<td align="center" class="border <?php echo $cls_right_border;?> "><b><?php echo $this->Number->currency($data['PharmacySalesBill']['paid_to_patient']); ?></b></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		
		<tr>
		  	<td style="padding-left:10px;"> Receiver's Signature:</td>
		  	<td> Authorised Signatory</td>
		</tr>
	</table> 
 
</body>
</html>