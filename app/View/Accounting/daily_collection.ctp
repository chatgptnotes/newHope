<?php
echo $this->Html->css(array('internal_style'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>

<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}
.idSelectable:hover{
		cursor: pointer;
		}
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
		 background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}
#msg {
    width: 180px;
    margin-left: 34%;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Daily Cash Collection', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 
<?php echo $this->Form->create('Voucher',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'daily_collection','admin'=>false),));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<table align="center" style="margin-top: 10px">
			<tr>
				<!-- <td align="center"><strong><?php //echo __('User Name');?></strong></td>
				<td><?php //echo $this->Form->input('Voucher.user_id', array('type'=>'select','empty'=>'Please select','options'=>$userName,'class'=>'textBoxExpnd','style'=>'width:110px','id'=>'type','label'=> false, 'div' => false, 'error' => false, 'autocomplete'=>'off'));?> </td>-->
				<!-- <td><?php //echo $this->Form->input('Voucher.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From'));?></td> -->
				<td><?php echo $this->Form->input('Voucher.date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'date','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Select Date'));?></td>
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?>
				<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'daily_collection'),array('escape'=>false));?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/printer.png',array('title'=>'Print Daily Collection')),'#',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'daily_collection_print','?'=>array('date'=>$date)))."', '_blank',
						'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200');  return false;")); ?></td>
					<?php if($this->request->data){
						$qryStr=$this->request->data['Voucher'];
					}?>
				<td><?php echo $this->Html->link($this->Html->image('icons/pdf.png'),array('controller'=>'Accounting','action'=>'daily_collection','pdf','?'=>$qryStr,'admin'=>false),array('escape'=>false,'title' => 'Export To PDF'))?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>'Accounting','action'=>'daily_collection','excel','?'=>$qryStr,'admin'=>false),array('escape'=>false,'title' => 'Export To Excel'))?>
				<?php echo $this->Form->end();?></td>
			</tr>
		</table>

		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
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
					$billDiscount = set::classicExtract($userData,"Billing.0.Billing.0.total_discount");
					$cardDeposit = set::classicExtract($userData,"PatientCard.0.PatientCard.0.card_total");
					$cardRefund = set::classicExtract($userData,"PatientCardAlias.0.PatientCardAlias.0.card_refund");
					$cardPayment = set::classicExtract($userData,"PatientCardAliasTwo.0.PatientCardAliasTwo.0.card_payment");
					/* $pharmacyTotal =  set::classicExtract($userData,"PharmacySalesBill.0.PharmacySalesBill.0.pharmacy_total");
					$pharmacyTotalDiscount =  set::classicExtract($userData,"PharmacySalesBill.0.PharmacySalesBill.0.pharmacy_total_discount"); */
					$billingDiscount = round($billDiscount);
					$netCashAmount = round($billingTotal + $cardDeposit - $cardPayment);
					$netRefundAmt = abs($billingRefund + $cardRefund);
					 
					if($billingTotal!=0 || $billingRefund!=0 || $billingDiscount!=0 || $cardDeposit!=0 || $cardRefund!=0 || $cardPayment!=0){
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
							<?php echo $netCashAmount ?round($netCashAmount) :0;
							$totalRevenue +=  (double) round($netCashAmount);?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $netRefundAmt ?round($netRefundAmt) :0;
							$totalRefund +=  (double) round($netRefundAmt);?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $billingDiscount ?round($billingDiscount) :0 ;
							$totalDiscount +=  (double) round($billingDiscount);?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
						<?php $netAmount = ($netCashAmount - $netRefundAmt);
							 echo $netAmount;
							$totalNetAmount +=  (double) $netAmount?>
						</td>
				  	</tr>
			  	<?php 	}
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

<script>

var getUserDailyCollectionsURL = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "user_daily_collection")); ?>" ;

$(document).ready(function(){

	//$(".idSelectable").dblclick(function() {
	//	id = $(this).attr('id');
	//	var transaction_date = $(this).find('input').val();
	//	transaction_date = transaction_date.split(",");
		
	//	var date_from = transaction_date[0];
	//	var date_to = transaction_date[1];
		
	//	date_from = date_from.replace(/\//g, "_");
	//	date_to = date_to.replace(/\//g, "_");
	//	$.fancybox({
	//		'width' : '70%',
	//		'height' : '90%',
	//		'autoScale' : true,
	//		'transitionIn' : 'fade',
	//		'transitionOut' : 'fade',
	//		'type' : 'iframe',
	//		'href' : getUserDailyCollectionsURL + '/' + date_from + '/' + date_to + '/' + id
	//	});
	//});


	//$("#from").datepicker({
		//showOn: "button",
		//buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		//buttonImageOnly: true,
		//changeMonth: true,
		//changeYear: true,
		//yearRange: '1950',
		//maxDate: new Date(),
		//dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	//});	
	$(".idSelectable").click(function() {
		id = $(this).attr('id');
		var transaction_date = $(this).find('input').val();
		var tran_date = transaction_date.split("/");
		//var tran_date = tran_date[0]+"_"+tran_date[1]+"_"+tran_date[2];
		$.fancybox({
			'width' : '70%',
			'height' : '90%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : getUserDailyCollectionsURL + '/' + tran_date + '/' + id
		});
	}); 
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