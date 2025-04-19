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
	
	.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
		 background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}

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
 
<!-- set padding to 50px to adjust print page with default header coming on page -->
<table border="0" class="" cellpadding="0" cellspacing="0" width="100%" style="padding-left:30px;" align="center" >
	<tr>
		<td colspan="4" align="right">
			<div id="printButton">
			  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
			 </div>
		 </td>
	</tr>
	<tr>  
  		<td valign="top" colspan="13" style="text-align:center;" align="center">
  			<h2><?php echo "Daily Cash Collection Detail";?></h2>
  		</td>
   </tr>
   <tr>
    	<?php 
	    	$getTo=explode(" ",$date);
	    	$getToFinal = str_replace("/", "-",$getTo[0]);
	    	$getToFinal=date('jS-M-Y', strtotime($getToFinal));
    	?>
    	<td align="" valign="top" colspan="2" style="letter-spacing: 0.1em;text-align:center;">
	  		<?php echo $getToFinal; ?>
		</td>
    </tr>      
	</table>
	
	<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="100%" valign="top">
		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="20%" align="center" valign="center" style="text-align: center"><?php echo __("User Name"); ?></th> 
						<th width="10%" align="center" valign="center" style="text-align: center"><?php echo __("Role"); ?></th> 
						<th width="30%" align="center" valign="center" colspan="3" style="text-align: center">
							<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
								<tr>
									<th colspan="3" align="center" style="text-align: center"><?php echo __("Collection"); ?></th>	
								</tr>
								<tr>
									<th width="145px" style="text-align: center"><?php echo __("Cash"); ?></th>
									<th width="100px" style="text-align: center"><?php echo __("Cheque"); ?></th>
									<th style="text-align: center"><?php echo __("Patient Card"); ?></th>
								</tr>
							</table>
						</th> 
						<th width="20%" align="center" valign="center" colspan="2" style="text-align: center">
							<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
								<tr>
									<th colspan="2" style="text-align: center"><?php echo __("Refund"); ?></th>	
								</tr>
								<tr>
									<th style="text-align: center"><?php echo __("Cash"); ?></th>
									<th style="text-align: center"><?php echo __("Patient Card"); ?></th>
								</tr>
							</table>
						</th>  
						<th width="10%" align="center" valign="center" style="text-align: center;"><?php echo __("Nett Amount"); ?></th>
						<th width="10%" align="center" valign="center" style="text-align: center;"><?php echo __("Patient Card Amount"); ?></th>
					</tr> 
				</thead>
				
				<tbody>
				<?php 
				 foreach($data as $key=> $userData) { 
					$billingTotal =  set::classicExtract($userData,"Billing.0.Billing.0.total");
					$billingCheque =  set::classicExtract($userData,"Billing.1.Billing.0.total");
					$cardCheque =  set::classicExtract($userData,"PatientCardAliasThree.0.PatientCardAliasThree.0.card_amount_cheque");
					$billRefund = set::classicExtract($userData,"Billing.0.Billing.0.return_total");
					$cardDeposit = set::classicExtract($userData,"PatientCard.0.PatientCard.0.card_total");
					$cardRefund = set::classicExtract($userData,"PatientCardAlias.0.PatientCardAlias.0.card_refund");
					$cardPayment = set::classicExtract($userData,"PatientCardAliasTwo.0.PatientCardAliasTwo.0.card_payment");
					$netCashAmount = $billingTotal - $cardPayment;
					$cardNetAmount = abs($cardPayment);
					$billingChequeTotal = $billingCheque + $cardCheque;
					$billingRefund = round($cardRefund + $billRefund);
					
					if($netCashAmount!=0 || $billingChequeTotal!=0 || $cardDeposit!=0
							|| $billingRefund!=0 || $cardNetAmount!=0 || $cardPayment!=0){
				?>
					<tr>
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<?php echo $userData['User']['full_name']; ?>
							</div>
						</td>
						<td align="left" valign="top" style= "text-align: left;">
							<?php echo $userData['Role']['name']; ?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $netCashAmount ?$netCashAmount :0;
							$totalCash +=  (double) $netCashAmount; ?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $billingChequeTotal ?$billingChequeTotal :0;
							$totalChequeAmount +=  (double) $billingChequeTotal; ?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $cardDeposit ?$cardDeposit :0;
							$totalCardAmount +=  (double) $cardDeposit; ?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $billingRefund ?$billingRefund :0;
							$totalCashRefund +=  (double) $billingRefund;?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $cardNetAmount ?$cardNetAmount :0;
							$totalCardRefund +=  (double) $cardNetAmount;?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
							<?php $netAmount = round($netCashAmount + $cardDeposit - $billingRefund);
							echo $netAmount;  
							$totalNetAmount +=  (double) $netAmount; ?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
						<?php $netCardAmount = ($cardDeposit - $cardNetAmount);
							 echo $netCardAmount;
							 $totalNetCardAmount +=  (double) $netCardAmount; ?>
						</td>
				  	</tr>
			  	<?php }
					}?>
				</tbody>
			</table>
		
			<table  width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
				<tr>
					<td colspan = "2"><?php echo " ";?></td>
					<td width="14%" align="center" valign="center" style="text-align: center"><b><?php echo __("Cash Collection"); ?></b></td>
					<td width="8%" align="center" valign="center" style="text-align: center"><b><?php echo __("Cheque Collection"); ?></b></td>
					<td width="8%" align="center" valign="center" style="text-align: center"><b><?php echo __("Patient Card Transaction"); ?></b></td>
					<td width="10%" align="center" valign="center" style="text-align: center"><b><?php echo __("Cash Refund"); ?></b></td>
					<td width="10%" align="center" valign="center" style="text-align: center"><b><?php echo __("Patient Card Refund"); ?></b></td>
					<td width="10%" align="center" valign="center" style="text-align: center"><b><?php echo __("Nett Collection"); ?></b></td>
					<td width="10%" align="center" valign="center" style="text-align: center"><b><?php echo __("Nett Patient Card Transaction"); ?></b></td>
				</tr>
				<tr>
					<td class="tdLabel" colspan="2" style="text-align: right;"><font color="red"><b><?php echo __('Total :');?></b></font></td>
					<?php 
					if(empty($totalCash)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalCash)?></b></font></td>
					<?php }
					if(empty($totalChequeAmount)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalChequeAmount)?></b></font></td>
					<?php } 
					if(empty($totalCardAmount)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalCardAmount)?></b></font></td>
					<?php }
					if(empty($totalCashRefund)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalCashRefund)?></b></font></td>
					<?php } 
					if(empty($totalCardRefund)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalCardRefund)?></b></font></td>
					<?php }
					if(empty($totalNetAmount)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalNetAmount)?></b></font></td>
					<?php }
					if(empty($totalNetCardAmount)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalNetCardAmount)?></b></font></td>
					<?php }?>
				</tr>  
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>
 </html>