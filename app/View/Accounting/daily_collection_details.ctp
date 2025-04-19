<?php
echo $this->Html->css(array('internal_style'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>

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
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Daily Collection Detail', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>	
</div> 
<?php echo $this->Form->create('Voucher',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'daily_collection_details','admin'=>false),));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<table align="center" style="margin-top: 10px">
			<tr>
				<td><?php echo $this->Form->input('Voucher.date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'date','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Select Date'));?></td>
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'daily_collection_details'),array('escape'=>false));?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/printer.png',array('title'=>'Print Daily Collection Details')),'#',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'daily_collection_details_print','?'=>array('date'=>$date)))."', '_blank',
						'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200');  return false;")); ?></td>
				<?php if($this->request->data){
						$qryStr=$this->request->data['Voucher'];
				}?>
				<td><?php echo $this->Html->link($this->Html->image('icons/pdf.png'),array('controller'=>'Accounting','action'=>'daily_collection_details','pdf','?'=>$qryStr,'admin'=>false),array('escape'=>false,'title' => 'Export To PDF'))?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>'Accounting','action'=>'daily_collection_details','excel','?'=>$qryStr,'admin'=>false,'alt'=>'Export To Excel'),array('escape'=>false,'title' => 'Export To Excel'))?><?php echo $this->Form->end();?></td>
			</tr>
		</table>

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
					/* $pharmacyTotal =  set::classicExtract($userData,"PharmacySalesBill.0.PharmacySalesBill.0.pharmacy_total"); */
					$netCashAmount = round($billingTotal - $cardPayment);
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
					<?php if(empty($totalCash)){ ?>
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

<script>
$(document).ready(function(){
 	$("#date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
});
</script>
	