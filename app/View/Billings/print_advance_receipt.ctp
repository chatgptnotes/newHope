<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" moznomarginboxes mozdisallowselectionprint> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true);
		
		$website=$this->Session->read("website.instance");
		if($website=='kanpur')
		{
			$paddingTop="10px";
		    $paddingLeft="4px";
		    
		    if($this->request->query['flag'] == 'without_header')
		    {
		    	$paddingTop="25%";
		    }
		}
		else
		{
			//$paddingTop="100px";
			$paddingLeft="0px";
		}
		
		?>
		 
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
<body style="background:none;width:98%;margin:auto;padding: 20px;!important">

 <?php /*if(!empty($billingData['Billing']['discount'])){
 		if(strtolower($billingData['Billing']['payment_category'])!='finalbill'){
	 		$billingData['Billing']['amount']=$billingData['Billing']['amount']+$billingData['Billing']['discount'];
	 		$receiptLabel='DISCOUNT';
 		}elseif(strtolower($billingData['Billing']['payment_category'])=='finalbill' && $this->params->query['flag']!='discountAmount'){
			$billingData['Billing']['amount']=$billingData['Billing']['amount'];
		}elseif($this->params->query['flag']='discountAmount'){
			$billingData['Billing']['amount']=$billingData['Billing']['discount'];
		}
 }*/?>
<!--
set padding to 50px to adjust print page with default header coming on page
	-->
	<table width="200" style="float:right">
		<?php if($patientData['Patient']['tariff_standard_id']==$getTariffRgjayId && $patientData['Patient']['admission_type']=="IPD"){
			}else{?>
		<tr>
			<td align="right">
			<div id="printButton"><?php 

			echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
			?></div>
			</td>
		</tr>
		<?php }?>
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
	</table>
	<?php } ?> 
	
	<div style="padding:20px">
	    <strong>Reciept No:</strong> <?php echo h($billingId); ?>
	</div>
	
	 
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="padding-top:<?php echo $paddingTop;?>;">
		  <?php if($website=='vadodara'){?>
		  <tr>
			  <td>&nbsp;</td>
			  <td align="" valign="top" colspan="1" style="text-decoration:underline;letter-spacing: 0.2em;"><strong>RECEIPT</strong></td>
		  </tr>
		  <?php }?>
		  <!-- <tr>
		  	<td>&nbsp;</td>
		  	<?php //if($billingData['Billing']['refund']==1){?>
		  	<td align="" valign="top" colspan="1" style="text-decoration:underline;letter-spacing: 0.2em;"><strong>REFUND RECEIPT</strong></td>
		  	<?php //}else{?>
		  	<td align="" valign="top" colspan="1" style="text-decoration:underline;letter-spacing: 0.2em;"><strong><?php //echo $receiptLabel?$receiptLabel:'';?> RECEIPT</strong></td>
		  	<?php //}?>
		  </tr> -->
		  <tr><td>&nbsp;</td></tr>
		  
		  <tr>
		  	<?php if($billingData['Billing']['refund']==1){?>
		  	<td width="200">Refund to:</td>
		  	<?php }else{?>
		  	<td width="200">Received with thanks from :</td>
		  	<?php }?>
		  	<td> <?php echo $patientData['PatientInitial']['name']." ".ucwords($patientData['Patient']['lookup_name'])."(".$patientData['Patient']['admission_id'].")"; ?></td>	
		  </tr>
		  <tr>
		  	<td>The sum of :</td><?php //debug($billingData['Billing']['refund']);?>
		  	<td> <?php  if($billingData['Billing']['refund']==1){
		  					echo $this->RupeesToWords->no_to_words($billingData['Billing']['paid_to_patient']); 
				  		}else{
				  			echo $this->RupeesToWords->no_to_words($billingData['Billing']['amount']); 
						}?></td>
		  </tr>
		  <?php if($website!='vadodara'){?>
		  <tr>
		  	<td>By :</td>
		  	<td> <?php echo $billingData['Billing']['mode_of_payment'];?></td>
		  </tr>
		  <?php }?>
		 <?php if($website =='kanpur'){
		 	    if($this->request->query['flag'] == 'roman_header' || $this->request->query['flag_roman'] == 'roman_header'){
					$display='none';
				}
		       }else{
		    		$display='';
		       }
		  if($billingData['Billing']['remark']){//if remark present thn show?>
		  <tr style="display:<?php echo $display; ?>">
		  	<td>Remarks :</td>
		  	<td> <?php echo $billingData['Billing']['remark']; ?> <?php echo h($billingId); ?> <?php if($website == 'kanpur') echo "&nbsp;".$billingData['Billing']['id']; ?></td>
		  </tr>
		<?php }?>
		  <tr>
		  	<td>Date :</td>
		  	<td> <?php echo $this->DateFormat->formatDate2Local($billingData['Billing']['date'],Configure::read('date_format'),true); ?></td>
		  </tr>
		<?php   if($website =='vadodara'){?>
		  <tr>
		    <td>Corporate Type:</td>
		    <td><?php echo $patientData['TariffStandard']['name'];?></td>
		  </tr>
		  <?php }?>
		  <tr><td>&nbsp;</td></tr>
		   <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr>
		  	<td><?php 
					if($billingData['Billing']['discount'] && $billingData['Billing']['refund']!=1)
		  			echo __("Discount : ") .$billingData['Billing']['discount'];?>
		  	</td>
		  </tr>
		  <?php if($website!='vadodara'){ //for other instance  --yashwant?>
		  <tr>
		  	<td><?php 
		  		if($billingData['Billing']['refund']==1){
					echo $billingData['Billing']['paid_to_patient']."/-";
				}else{
		  			echo $billingData['Billing']['amount']."/-"; 
				}echo $this->Html->image('icons/rupee_symbol.png');?>
			</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		  	<td>Username :&nbsp;<strong><?php echo $billingData['User']['first_name'].' '.$billingData['User']['last_name']; ?></strong></td>
			<?php if($website=='hope'){?>
		  	<td align="right">Name & Sign of Patient &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Authorised Signatory</td>
		  	<?php }else{?>
		  	<td align="right">Name & Sign of Patient &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Authorised Signatory</td>
		  	<?php }?>
		  </tr>
		  <?php }else{//for vaddara instance  --yashwant?>
		  
		  <tr>
		  	<td>By Cash:&nbsp;
		  	<?php echo $this->Html->image('icons/rupee_symbol.png',array('style'=>'float:none; vertical-align:top;'));?>&nbsp;<?php 
		  		if($billingData['Billing']['refund']==1){
					echo $billingData['Billing']['paid_to_patient']."/-";
				}else{
		  			echo $billingData['Billing']['amount'] -$billingData['PatientCard']['amount']."/-"; 
				}?>
			</td>
			<td></td>
		  </tr>
		  <?php if($billingData['PatientCard']['amount']){?>
		  <tr>
		  	<td>By Card:&nbsp;
		  	<?php  echo $this->Html->image('icons/rupee_symbol.png',array('style'=>'float:none; vertical-align:top;'));?>&nbsp;<?php 
		  			echo $billingData['PatientCard']['amount']."/-"; ?>
			</td>
			<td></td>
		  </tr>
		  <?php }?>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr>
		  	<td>Username :&nbsp;<strong><?php echo $billingData['User']['first_name'].' '.$billingData['User']['last_name']; ?></strong></td>
		    <td align="right">Name & Sign of Patient &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Authorised Signatory</td>
		  </tr>
		 <?php }?>
	</table> 
 
</body>
 </html>                    
  
 