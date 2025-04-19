<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Daily_Collection_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}

</style>
<table border="0" class="" cellpadding="0" cellspacing="0" width="100%" align="center" >
		 <tr>  
	  		<td valign="top" colspan="6" style="text-align:center;" align="center">
	  			<h2><?php echo "Daily Collection";?></h2>
	  		</td>
    	</tr>
    	<tr>
	    	<?php 
		    	$getTo=explode(" ",$date);
		    	$getToFinal = str_replace("/", "-",$getTo[0]);
		    	$getToFinal=date('jS-M-Y', strtotime($getToFinal));
	    	?>
	    	<td align="" valign="top" colspan="6" style="letter-spacing: 0.1em;text-align:center;">
			  	<?php echo $getToFinal; ?>
			</td>
    	</tr>    
	</table>
<table width="100%" cellpadding="0" cellspacing="2" border="1" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
	<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="1" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="20%" align="center" valign="top"><?php echo __('User Name');?></th> 
						<th width="20%" align="center" valign="top"><?php echo __('Role');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Revenue');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Refund Amount');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Discount');?></th>
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Nett Amount');?></th>
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($data as $key=> $userData) { ?>
				<?php
					$billingTotal =  set::classicExtract($userData,"Billing.0.Billing.0.total");
					$billingRefund = set::classicExtract($userData,"Billing.0.Billing.0.return_total");
					$billingDiscount = set::classicExtract($userData,"Billing.0.Billing.0.total_discount");
					$cardDeposit = set::classicExtract($userData,"PatientCard.0.PatientCard.0.card_total");
					$cardRefund = set::classicExtract($userData,"PatientCardAlias.0.PatientCardAlias.0.card_refund");
					$cardPayment = set::classicExtract($userData,"PatientCardAliasTwo.0.PatientCardAliasTwo.0.card_payment");
					$netCashAmount = $billingTotal + $cardDeposit - $cardPayment;
					$netRefundAmt = abs($billingRefund + $cardRefund);
					if($billingTotal!=0 || $billingRefund!=0 || $billingDiscount!=0
							|| $cardDeposit!=0 || $cardRefund!=0 || $cardPayment!=0){
				?>
				
					<tr id="<?php echo $userData['User']['id']; ?>" class="idSelectable">
					
					<input type="hidden" id="start_transaction_id_<?php echo $userData['User']['id']; ?>" value="<?php echo $date?>">
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
							$totalRevenue +=  (double) $netCashAmount;?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $netRefundAmt ?$netRefundAmt :0;
							$totalRefund +=  (double) $netRefundAmt;?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $billingDiscount ?$billingDiscount :0 ;
							$totalDiscount +=  (double) $billingDiscount;?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
						<?php $netAmount = ($netCashAmount - $netRefundAmt);
							 echo $netAmount;
							$totalNetAmount +=  (double) $netAmount?>
						</td>
				  	</tr>
			  	<?php }
				}?>
					
				</tbody>
			<tr>
				<td class="tdLabel" colspan="2" style="text-align: right;"><font color="red"><b><?php echo __('Total :');?></b></font></td>
						<?php if(empty($totalRevenue)){ ?>
								<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
							}else{ ?>
								<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalRevenue);?></b></font></td>
						<?php }
						if(empty($totalRefund)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalRefund);?></b></font></td>
						<?php } 
						if(empty($totalDiscount)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalDiscount);?></b></font></td>
						<?php }
						if(empty($totalNetAmount)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalNetAmount);?></b></font></td>
						<?php } ?>
			</tr>  
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>