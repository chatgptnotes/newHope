<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<?php echo $this->Html->css(array('internal_style.css')); ?>
<?php echo $this->Html->script('jquery-1.5.1.min.js'); 

$website=$this->Session->read("website.instance");
if($website=='kanpur')
{
	$paddingTop="10px";
	$paddingLeft="5px";
	
	if($this->request->query['header'] == 'without')
	{
		$paddingTop="22%";
	}
}
else
{
	$paddingTop="10px";
	$paddingLeft="0px";
} 
?>
<title>
		<?php echo __('Bill Receipt', true); ?>
 </title>
 <style>
 body{padding:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000;}
	.boxBorder{border:1px solid #3E474A;}
	.boxBorderBot{border-bottom:1px solid #3E474A;}
	.boxBorderRight{border-right:1px solid #3E474A;}
	.boxBorderLeft{border-left:1px solid #3E474A;}
	.tdBorderRtBt{border-right:1px solid #3E474A; border-bottom:1px solid #3E474A;}
	.tdBorderBt{border-bottom:1px solid #3E474A;}
	.tdBorderTp{border-top:1px solid #3E474A;}
	.tdBorderRt{border-right:1px solid #3E474A;}
	.tdBorderTpBt{border-bottom:1px solid #3E474A; border-top:1px solid #3E474A;}
	.tdBorderTpRt{border-top:1px solid #3E474A; border-right:1px solid #3E474A;}
 </style>
</head>
<body style="background:none;width:98%;margin:auto;">
 <table width="200" style="float:right">
		<tr>
			<td align="right">
			<div id="printButton"><?php 

			echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
			?></div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table> 
	<?php
		$website  = $this->Session->read('website.instance');
		if($website=='vadodara'){
	?>
	<table width="800">
		<tr>
			<td><div><?php echo $this->element('vadodara_header');?> </div></td>
		</tr>
		<tr><td><div><?php echo $this->element('print_patient_info');?></div></td></tr>
	</table>
	<?php } ?>
<table border="0" class="" cellpadding="0" cellspacing="0" width="100%" style="padding-top:<?php echo $paddingTop;?>;padding-left:<?php echo $paddingLeft;?> ">
  
  <tr>
  	<td>
  		<table border="0" class="" align="center" cellpadding="0" cellspacing="0" width="100%">
  		<!-- -	<tr>
  				<td class="tdLabel2"  style="text-align:center" colspan="5"><strong><?php //echo $flag;?> Bill Receipt</strong></td>
  			</tr> -->
  			<tr><td colspan="5">&nbsp;</td></tr>
  				
  			<tr>
  				<td>  <?php //if($billFlag=='yes')echo $this->element('billing_patient_header');else echo $this->element('print_patient_info');billNo ?> </td>
  			</tr>
  			
  			<tr>
  			   <td>
  			   <table border="0" class="" align="center" cellpadding="0" cellspacing="0" width="100%">
  			  <?php if($billFlag=='yes'){ ?>
  			   <tr>
  			     <td width="33%"  class="tdBorderTp tdBorderBt boxBorderLeft"></td>
	             <td align="center" style="font-size:14px;"  class="tdBorderTp tdBorderBt "><strong><?php echo "R E C E I P T ";?></strong></td>
	             <td width="33%" align="right" style="font-size:14px;"  class="tdBorderTp tdBorderBt boxBorderRight"><strong><?php echo "Receipt No - ".$billNo;?></strong></td>
	           </tr>
	          <?php }else{ ?>
	          	<tr>
  			     <td width="33%" class="tdBorderTp tdBorderBt boxBorderLeft">&nbsp;</td>
	             <td align="center" style="font-size:14px;"  class="tdBorderTp tdBorderBt "><strong><?php echo "R E C E I P T ";?></strong></td>
	             <td width="33%" align="right" style="font-size:14px;"  class="tdBorderTp tdBorderBt boxBorderRight"><strong><?php echo "Receipt No - ".$billNo;?></strong></td>
	           </tr>
	          <?php }?>
	          </table></td>
	   </tr>
  			
  			<?php if(!empty($billedService)){?>
  			<tr>
  				<td>
	  				<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both" >
						<tr>
							<th width="" align="left"  style="font-size:14px;" class="tdBorderRtBt"><?php echo __('PARTICULARS');?></th>
							<th width="" align="left"  style="font-size:14px;" class="tdBorderRtBt"><?php echo __('UNIT PRICE');?></th>
							<th width="" align="left"  style="font-size:14px;" class="tdBorderRtBt"><?php echo __('UNIT/S');?></th>
							<th width="" align="left"  style="font-size:14px;" class="tdBorderRtBt"><?php echo __('Discount');?></th>
							<th width="" align="right" width="20%" style="font-size:14px;" class="tdBorderRtBt"><?php echo __('AMOUNT');?></th>
	 					</tr>
						 
							<?php $totalAmt=0; 
							$ctr=0;
							$refundAmt=0;
						foreach($billedService[$billID] as $serKey=>$services){
							?>
						<tr>
							<td align="left" width="" style="" class="tdBorderRtBt "><?php 
							echo $services['name'];?></td>
							<td align="left" width="" style="" class="tdBorderRtBt "><?php echo $services['rate']; ?></td>
							<td align="left" width="" style="" class="tdBorderRtBt "><?php echo $services['qty']; ?></td>	
							<td align="left" width="" style="" class="tdBorderRtBt "><?php echo $services['discount']; ?></td>						
							<td class="amountBill tdBorderRtBt" align="right" width="" style="" >
							<?php if($services['paid']){
								$paid=$services['paid'];
							}else{
									$paid=$services['rate']*$services['qty'];
									// if the service has been refunded then to keep the bill as it is withount any discount
							}
							echo $this->Number->currency($paid);
								
							?></td>
						</tr>
						<?php $ctr++; 
						$discount=$discount+$services['discount'];
						$total=$total+$services['amount'];
						$refundAmt=$refundAmt+$services['refund'];
							}
						}?>
						
						
  		</table>
  	</td>
  </tr>
  
  <tr><td align="right">Total Bill Amount : <b><?php echo round($total);?></b></td></tr>
  <?php if($discount){?>
  <tr><td align="right">Discount Amount : <b><?php echo round($discount);?></b></td></tr>
  <?php }?>
  <tr><td align="right">Total Paid Amount : <b><?php echo round($billData['Billing']['amount']);?></b></td></tr>
  <?php if($refundAmt){?>
  <tr><td align="right">Total Refunded Amount : <b><?php echo round($refundAmt);?></b></td></tr>
  <?php } ?>
  <?php if(!empty($billData['PatientCard']['amount'])){?>
  <tr><td align="">By Card : <b><?php echo round($billData['PatientCard']['amount']);?></b></td></tr>
  <?php }else{$billData['PatientCard']['amount']='0';}?>
  <tr><td align="">By Cash : <b><?php echo round($billData['Billing']['amount']-$billData['PatientCard']['amount']);?></b></td></tr>
  
  <tr>
	<td>
	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both" >
	   <tbody>
		<tr>
			<td colspan="2" class="boxBorder" width="100%"  style="padding-left: 10px;">Received with thanks from <strong><?php echo $patient['Patient']['lookup_name'];?></strong> sum of <strong><?php echo $this->RupeesToWords->no_to_words(round($billData['Billing']['amount']));?></strong>.</td>
		</tr>
		<tr><td >&nbsp;</td></tr>
		<tr><td >&nbsp;</td></tr>
		<tr><td >&nbsp;</td></tr>
		<tr class="boxBorder" >
        	<td align="left" width="30%"style=""><strong>Name & Sign. Of Patient</strong></td>
            <td align="right" width="20%" style=""><strong>Auth. Sign.</strong></td>
		</tr>
	   </tbody>
	</table>	  			
	</td>
  </tr>
  			<?php ?>
</table> 
</body>
</html>                    
  
 