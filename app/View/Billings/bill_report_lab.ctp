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
  				<td>  <?php //if($billFlag=='yes')echo $this->element('billing_patient_header');else echo $this->element('print_patient_info'); ?> </td>
  			</tr>
  			
  			<tr>
  			   <td>
  			   <table border="0" class="" align="center" cellpadding="0" cellspacing="0" width="100%">
  			  <?php if($billFlag=='yes'){ ?>
  			   <tr>
  			     <td width="40%" class="tdBorderTp tdBorderBt boxBorderLeft"></td>
	             <td align="center" style="font-size:14px;"  class="tdBorderTp tdBorderBt "><strong><?php echo "R E C E I P T ";?></strong></td>
	             <td align="right" style="font-size:14px;"  class="tdBorderTp tdBorderBt boxBorderRight"><strong><?php echo "Receipt No - ".$billingData[0]['Billing']['id'];?></strong></td>
	           </tr>
	          <?php }else{ ?>
	          	<tr>
  			     <td width="" class="tdBorderTp tdBorderBt boxBorderLeft"></td>
	             <td align="center" style="font-size:14px;"  class="tdBorderTp tdBorderBt "><strong><?php echo "R E C E I P T ";?></strong></td>
	             <td align="right" style="font-size:14px;"  class="tdBorderTp tdBorderBt boxBorderRight"><strong><?php echo " ";?></strong></td>
	           </tr>
	          <?php }?>
	          </table></td>
	   </tr>
  			
  			<?php if(!empty($servicesData)){?>
  			<tr>
  				<td>
	  				<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both" >
						<tr>
							<th width="" align="left" style="font-size:14px;" class="tdBorderRtBt boxBorderLeft"><?php echo __('DATE');?></th>
							<th width="" align="left"  style="font-size:14px;" class="tdBorderRtBt"><?php echo __('PARTICULARS');?></th>
							<th width="" align="left"  style="font-size:14px;" class="tdBorderRtBt"><?php echo __('UNITS');?></th>
							<th width="" align="left"  style="font-size:14px;" class="tdBorderRtBt"><?php echo __('UNIT PRICE');?></th>
							<th width="" align="right" width="20%" style="font-size:14px;" class="tdBorderRtBt"><?php echo __('AMOUNT');?></th>
	 					</tr>
						 
							<?php $totalAmt=0; 
							$ctr=0;
						foreach($servicesData as $services){?>

						<tr><?php 
							if(strtolower($services['Patient']['admission_type'])=='opd'){ 
								if($ctr=='0'){?>
								    <td align="left" width=""style="" class="tdBorderRtBt boxBorderLeft">
										<?php 
										if($servicesData[0]['ServiceCategory']['name']==Configure::read('mandatoryservices')){
											echo $this->DateFormat->formatDate2Local($servicesData[0]['Patient']['form_received_on'],Configure::read('date_format'),false);
										}else{
											echo $this->DateFormat->formatDate2Local($servicesData[0]['ServiceBill']['date'],Configure::read('date_format'),false);
										}?>
									</td>
								<?php }else{?>
									<td align="left" width=""style="" class="tdBorderRtBt boxBorderLeft"></td>
							<?php }
							}elseif(strtolower($services['Patient']['admission_type'])=='ipd'){ ?>
								<td align="left" width=""style="" class="tdBorderRtBt boxBorderLeft">
									<?php 
									if($servicesData[0]['ServiceCategory']['name']==Configure::read('mandatoryservices')){
										echo $this->DateFormat->formatDate2Local($servicesData[0]['Patient']['form_received_on'],Configure::read('date_format'),false);
									}else{
										echo $this->DateFormat->formatDate2Local($servicesData[0]['ServiceBill']['date'],Configure::read('date_format'),false);
									}?>
								</td>
							<?php }?>
							
							<td align="left" width="" style="" class="tdBorderRtBt "><?php 
							if($services['ServiceBill']['description'])$description="(".$services['ServiceBill']['description'].")";else$description="";
							echo $services['TariffList']['name']." ".$description;?></td>
							<?php $services['ServiceBill']['amount'];
							 	  $no_of_time = $services['ServiceBill']['no_of_times']?$services['ServiceBill']['no_of_times']:1;?>
							 	  
							<td align="left" width="" style="" class="tdBorderRtBt "><?php echo $no_of_time; ?></td>
							
							<td align="left" width="" style="" class="tdBorderRtBt "><?php echo $services['ServiceBill']['amount']; ?></td>
							
							<td  class="amountBill tdBorderRtBt" align="right" width="" style="" ><?php echo $this->Number->currency(($totalAmount1=$services['ServiceBill']['amount']*$no_of_time));
							$totalAmt=$totalAmt+$totalAmount1;?></td>
						</tr>
						<?php $ctr++;}?>
						
						<tr><td height="" class="tdBorderRtBt boxBorderLeft" >&nbsp;</td>
						    <td height="" class="tdBorderRtBt " >&nbsp;</td>
						    <td height="" class="tdBorderRtBt " >&nbsp;</td>
						    <td height="" class="tdBorderRtBt " >&nbsp;</td>
						    <td height="" class="tdBorderRtBt " >&nbsp;</td>
						</tr>
						
						<tr>
							<td  align="left" width=""style="" class="tdBorderRtBt boxBorderLeft"><strong><?php echo __('Total');?></strong></td>
							<td  colspan="3" align="left" width="" style="" class="tdBorderRtBt "><strong><?php echo $this->RupeesToWords->no_to_words(ceil($totalAmt));?></strong></td>
							<td  align="right" width="" style="" class="tdBorderRtBt"><strong><?php echo $this->Number->currency($totalAmt);?></strong></td>
						</tr>
						
						<?php if($billingData ){?>
						<tr>
							 <td></td>
							 <td></td>
							 <td></td>
							 <td></td>
							 <td align="right">
								<table class=" " width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr><td>&nbsp;</td></tr>
									<tr>
										<td valign="top" class="boxBorderLeft tdBorderRtBt  tdBorderTp">&nbsp;<?php echo __('Paid');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt  tdBorderTp"><?php 
											echo $this->Number->currency($totalPaidAmount=$billingData['0']['Billing']['amount']);?></td>
									</tr>
									
									<?php if($billingData['0']['Billing']['discount']){?>
									<tr>
										<td class="boxBorderLeft tdBorderRtBt  ">&nbsp;<?php echo __('Discount');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt tdBorderRt "><?php echo $this->Number->currency($billingData['0']['Billing']['discount']);?></td>
									</tr>
									<?php }?>
									
									<?php if($billingData['0']['Billing']['paid_to_patient']){?>
									<tr>
										<td class="boxBorderLeft tdBorderRtBt  ">&nbsp;<?php echo __('Refund');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt tdBorderRt "><?php echo $this->Number->currency($billingData['0']['Billing']['paid_to_patient']);?></td>
									</tr>
									<?php }?>
									
									<?php if($this->Session->read('website.instance')!='vadodara'){?>
									<tr>
										<td class="boxBorderLeft tdBorderRtBt  ">&nbsp;<?php echo __('Balance');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt tdBorderRt "><?php echo $this->Number->currency($totalAmt-$billingData['0']['Billing']['amount']-$billingData['0']['Billing']['discount']);?></td>
									</tr>
									<?php }?>
									<tr><td>&nbsp;</td></tr>
								</table>
							
							</td>
						</tr>
						<?php  }?>
					</table>
  				</td>
  			</tr>
  			<!-- <tr><td >&nbsp;</td></tr> -->
  			
  			<?php }?>
  		
  			<?php if(!empty($labData)){?>
  			<tr>
  				<td>
	  				<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both" >
						<tr class="row_title">
							<th width="30%" align="left" style="font-size:14px;" class="tdBorderRtBt boxBorderLeft"><?php echo __('DATE'); ?></th>
							<th width="50%" align="left"  style="font-size:14px;" class="tdBorderRtBt"><?php echo __('PARTICULARS'); ?></th>
							<th width="20%" align="right" width="20%" style="font-size:14px;" class="tdBorderRtBt"><?php echo __('AMOUNT'); ?></th>
						</tr>
						<?php $totalAmt=0;
						$hospitalType = $this->Session->read('hospitaltype');
						if($hospitalType == 'NABH'){
							$nursingServiceCostType = 'nabh_charges';
						}else{
							$nursingServiceCostType = 'non_nabh_charges';
						}
						$ctr=0;
						 foreach($labData as $labData){?>
						<tr><?php 
							if(strtolower($patient_details['Patient']['admission_type'])=='opd'){ 
								if($ctr=='0'){?>
								  <td align="left" width="30%"style="" class="tdBorderRtBt boxBorderLeft"> 
								  <?php echo $this->DateFormat->formatDate2Local($labData['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false); ?></td>
								<?php }else{?>
									<td align="left" width="30%"style="" class="tdBorderRtBt boxBorderLeft"></td>
							<?php }
							}elseif(strtolower($patient_details['Patient']['admission_type'])=='ipd'){?>
								<td align="left" width="30%"style="" class="tdBorderRtBt boxBorderLeft"> 
								<?php echo $this->DateFormat->formatDate2Local($labData['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false); ?></td>
							<?php }?>
							 
							<td align="left" width="50%" style="" class="tdBorderRtBt "> <?php 
							if($labData['LaboratoryTestOrder']['description'])$labDescription="(".$labData['LaboratoryTestOrder']['description'].")";else$labDescription="";
							echo $labData['Laboratory']['name']." ".$labDescription; ?></td>
							<td class="tdBorderRtBt" align="right" width="20%" style=""><?php 
							//echo $totalAmount1=$labData['TariffAmount'][$nursingServiceCostType];
							echo $this->Number->currency($totalAmount1=$labData['LaboratoryTestOrder']['amount']);
							$totalAmt=$totalAmt+$totalAmount1;
							?></td>
						</tr>
						<?php }?>
						<tr><td height="80px" class="tdBorderRtBt boxBorderLeft" >&nbsp;</td>
						    <td height="40px" class="tdBorderRtBt " >&nbsp;</td>
						    <td height="40px" class="tdBorderRtBt " >&nbsp;</td>
						</tr>
						<tr>
							<td  align="left" width="30%"style="" class="tdBorderRtBt boxBorderLeft"  ><strong><?php echo __('Total');?></strong></td>
							<td align="left" width="50%" style="" class="tdBorderRtBt "><strong><?php echo $this->RupeesToWords->no_to_words(ceil($totalAmt));?></strong></td>
							<td align="right" width="20%" style="" class="tdBorderRtBt"><strong><?php echo $this->Number->currency($totalAmt);?></strong></td>
						</tr>
						 
						 
						
						<?php if($billingData ){?>
						<tr>
							 <td></td>
							 <td></td>
							 <td align="right">
								<table class=" " width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr><td>&nbsp;</td></tr>
									<tr>
										<td valign="top" class="boxBorderLeft tdBorderRtBt  tdBorderTp">&nbsp;<?php echo __('Paid');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt  tdBorderTp"><?php 
											echo $this->Number->currency($totalPaidAmount=$billingData['0']['Billing']['amount']);?></td>
									</tr>
									
									<?php if($billingData['0']['Billing']['discount']){?>
									<tr>
										<td class="boxBorderLeft tdBorderRtBt  ">&nbsp;<?php echo __('Discount');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt tdBorderRt "><?php echo $this->Number->currency($billingData['0']['Billing']['discount']);?></td>
									</tr>
									<?php }?>
									
									<?php if($billingData['0']['Billing']['paid_to_patient']){?>
									<tr>
										<td class="boxBorderLeft tdBorderRtBt  ">&nbsp;<?php echo __('Refund');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt tdBorderRt "><?php echo $this->Number->currency($billingData['0']['Billing']['paid_to_patient']);?></td>
									</tr>
									<?php }?>
									
									<?php if($this->Session->read('website.instance')!='vadodara'){?>
									<tr>
										<td class="boxBorderLeft tdBorderRtBt  ">&nbsp;<?php echo __('Balance');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt tdBorderRt "><?php echo $this->Number->currency($totalAmt-$billingData['0']['Billing']['amount']-$billingData['0']['Billing']['discount']);?></td>
									</tr>
									<?php }?>
									<tr><td>&nbsp;</td></tr>
								</table>
							
							</td>
						</tr>
						<?php  }?>
					</table>
  				</td>
  			</tr>
  			<?php }?>
  		
  			<?php if(!empty($radData)){?>
  			<tr>
  				<td>
	  				<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both" >
						<tr class="row_title">
							<th width="30%" align="left" style="font-size:14px;" class="tdBorderRtBt boxBorderLeft"><?php echo __('DATE'); ?></th>
							<th width="50%" align="left"  style="font-size:14px;" class="tdBorderRtBt"><?php echo __('PARTICULARS'); ?></th>
							<th width="20%" align="right" width="20%" style="font-size:14px;" class="tdBorderRtBt"><?php echo __('AMOUNT'); ?></th>
						</tr>
						<?php $totalAmt=0;
						$ctr=0;
						$hospitalType = $this->Session->read('hospitaltype');
						if($hospitalType == 'NABH'){
							$nursingServiceCostType = 'nabh_charges';
						}else{
							$nursingServiceCostType = 'non_nabh_charges';
						}
						foreach($radData as $radData){ ?>
						
						<tr><?php 
							if(strtolower($patient_details['Patient']['admission_type'])=='opd'){ 
								if($ctr=='0'){?>
								 <td align="left" width="30%"style="" class="tdBorderRtBt boxBorderLeft"> 
								 <?php echo $this->DateFormat->formatDate2Local($radData['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),false); ?></td>
								<?php }else{?>
									<td align="left" width="30%"style="" class="tdBorderRtBt boxBorderLeft"></td>
							<?php }
							}elseif(strtolower($patient_details['Patient']['admission_type'])=='ipd'){ ?>
								<td align="left" width="30%"style="" class="tdBorderRtBt boxBorderLeft"> 
								<?php echo $this->DateFormat->formatDate2Local($radData['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),false); ?></td>
							<?php }?>
							
							<td align="left" width="50%" style="" class="tdBorderRtBt "> <?php 
							if($radData['RadiologyTestOrder']['description'])$radDescription="(".$radData['RadiologyTestOrder']['description'].")";else$radDescription="";
							echo $radData['Radiology']['name']." ".$radDescription; ?></td>
							<td class="tdBorderRtBt" align="right" width="20%" style=""><?php 
							//echo $totalAmount1=$radData['TariffAmount'][$nursingServiceCostType];
							echo $this->Number->currency($totalAmount1=$radData['RadiologyTestOrder']['amount']);
							$totalAmt=$totalAmt+$totalAmount1;
							?></td>
						</tr>
						<?php }?>
						<tr><td height="80px" class="tdBorderRtBt boxBorderLeft" >&nbsp;</td>
						    <td height="40px" class="tdBorderRtBt " >&nbsp;</td>
						    <td height="40px" class="tdBorderRtBt " >&nbsp;</td>
						</tr>
						<tr>
							<td  align="left" width="30%"style="" class="tdBorderRtBt boxBorderLeft"  ><strong><?php echo __('Total');?></strong></td>
							<td  align="left" width="50%" style="" class="tdBorderRtBt "><strong><?php echo $this->RupeesToWords->no_to_words(ceil($totalAmt));?></strong></td>
							<td align="right" width="20%" style="" class="tdBorderRtBt"><strong><?php echo $this->Number->currency($totalAmt);?></strong></td>
						</tr>
						
						<?php if($billingData ){?>
						<tr>
							 <td></td>
							 <td></td>
							 <td align="right">
								<table class=" " width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr><td>&nbsp;</td></tr>
									<tr>
										<td valign="top" class="boxBorderLeft tdBorderRtBt  tdBorderTp">&nbsp;<?php echo __('Paid');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt  tdBorderTp"><?php 
											echo $this->Number->currency($totalPaidAmount=$billingData['0']['Billing']['amount']);?></td>
									</tr>
									
									<?php if($billingData['0']['Billing']['discount']){?>
									<tr>
										<td class="boxBorderLeft tdBorderRtBt  ">&nbsp;<?php echo __('Discount');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt tdBorderRt "><?php echo $this->Number->currency($billingData['0']['Billing']['discount']);?></td>
									</tr>
									<?php }?>
									
									<?php if($billingData['0']['Billing']['paid_to_patient']){?>
									<tr>
										<td class="boxBorderLeft tdBorderRtBt  ">&nbsp;<?php echo __('Refund');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt tdBorderRt "><?php echo $this->Number->currency($billingData['0']['Billing']['paid_to_patient']);?></td>
									</tr>
									<?php }?>
									
									<?php if($this->Session->read('website.instance')!='vadodara'){?>
									<tr>
										<td class="boxBorderLeft tdBorderRtBt  ">&nbsp;<?php echo __('Balance');?></td>
										<td align="right" valign="top" class="boxBorderLeft tdBorderRtBt tdBorderRt "><?php echo $this->Number->currency($totalAmt-$billingData['0']['Billing']['amount']-$billingData['0']['Billing']['discount']);?></td>
									</tr>
									<?php }?>
									<tr><td>&nbsp;</td></tr>
								</table>
							
							</td>
						</tr>
						<?php  }?>
						
					</table>
  				</td>
  			</tr>
  			<?php }?>
  			
  			<?php if(!empty($registrationRate)){?>
  			<tr>
  				<td>
	  				<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both" >
						<tr class="row_title">
							<th class=""><?php echo __('DATE'); ?></th>
							<th class=""><?php echo __('PARTICULARS'); ?></th>
							<th class=""><?php echo __('AMOUNT'); ?></th>
						</tr>
						<tr>
							<td class="tdBorderRt">Registration Charges</td>
							<td align="right" valign="top" class="tdBorderRt"><?php echo $registrationRate; ?>
								<?php //echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
							<td align="right" valign="top"><?php //echo $this->Number->currency($registrationRate);?> <?php echo $registrationRate; ?></td>
						</tr>
						<tr>
							<td class="tdBorderRt"><?php echo ($mandatoryData['TariffList']['name'])?($mandatoryData['TariffList']['name']):'Consultation Fee' ;?>
							<td align="right" valign="top" class="tdBorderRt"><?php echo $this->Number->format($doctorRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)); ?></td>
							<td align="right" valign="top" class="tdBorderRt"><?php echo $this->Number->format($doctorRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)); ?></td>
						</tr>
						<tr>
							<td colspan="2" valign="middle" align="right"><?php echo __('Total Amount');?></td>
							<td valign="middle" style="text-align: right;"><?php echo $registrationRate+$doctorRate;?></td>
						</tr>
					</table>
  				</td>
  			</tr>
  			<?php }?>
  			<!-- <tr><td >&nbsp;</td></tr> -->
  			
  			<?php if(!empty($billingData)){ ?>
  					<!-- <tr><td style="text-align:center" colspan="5"> </td></tr> -->
  					<tr>
			  			<td>
						<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both" >
						   <tbody>
						    
							<tr>
								<td colspan="2" class="boxBorder" width="100%"  style="padding-left: 10px;">Received with thanks from <strong><?php echo $patient_details['Patient']['lookup_name'];?></strong> sum of <strong><?php echo $this->RupeesToWords->no_to_words(ceil($totalPaidAmount));?></strong>.</td>
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
  			<?php } ?>
  			<tr><td >&nbsp;</td></tr> 
  		</table>
  	</td>
  </tr>
</table> 
</body>
</html>                    
  
 