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
</style>
<?php 
echo $this->Html->script('topheaderfreeze') ;
?>
<div class="inner_title">
	<h3>
		<?php echo __('Cash Book', true); ?>
	</h3>
	<span>
	<?php
	echo $this->Form->button(__('Export To Excel'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'excel'));
	echo $this->Form->button(__('Print'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'print'));
	?>
	</span>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Patient_voucher',array('id'=>'patientVoucher','url'=>array('controller'=>'Billings',
		'action'=>'getAllCashierTransactions','admin'=>false),));?>
<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tbody>
		<tr class="row_title">	
			<td>
				<?php echo $this->Form->input('Voucher.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false,
					'div' => false, 'error' => false,'placeholder'=>'From','readonly'=>'readonly','value'=>$from));?>
			</td>
			<td>
				<?php echo $this->Form->input('Voucher.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false,
					'div' => false, 'error' => false,'placeholder'=>'To','readonly'=>'readonly','value'=>$to));?>
			</td>
			<td>
				<?php echo $this->Form->input('Voucher.narration', array('class'=>'textBoxExpnd','style'=>'width:160px','id'=>'narration','label'=> false,
					'div' => false, 'error' => false,'placeholder'=>'Search by Narration', 'autocomplete'=>'off'));?>
			</td>
			<td>
				<?php echo $this->Form->input('Voucher.amount', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'amount','label'=> false,
					'div' => false, 'error' => false,'placeholder'=>'Search by Amount', 'autocomplete'=>'off'));?>
			</td>
			<td>
				<?php echo $this->Form->input('Voucher.type', array('type'=>'select','empty'=>'Select Type',
					'options'=>array('credit'=>'credit','debit'=>'debit'),'class'=>'textBoxExpnd','style'=>'width:110px','id'=>'type','label'=> false,
					'div' => false, 'error' => false,'placeholder'=>'Search by Amount', 'autocomplete'=>'off'));?>
			</td>
			<td>
				<?php echo $this->Form->input('Voucher.user_type', array('type'=>'select','empty'=>'Select User','options'=>$userName,
					'class'=>'textBoxExpnd','style'=>'width:110px','id'=>'type','label'=> false, 'div' => false, 'error' => false, 'autocomplete'=>'off'));?>
			</td>
			<?php if(isset($accountManagerName)){?>
				<td>
					<?php echo $this->Form->input('Voucher.manager_type', array('type'=>'select','empty'=>'Select User','options'=>$accountManagerName,
						'class'=>'textBoxExpnd','style'=>'width:110px','id'=>'type','label'=>false,'div'=>false,'error'=>false,'autocomplete'=>'off'));?>
				</td>
			<?php }?>
			<td>
				<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'search'));?>
			</td>
			<td>
				<?php echo $this->Form->input('Voucher.isHide',array("type" => "checkbox",'id'=>'isShowNarration','label'=>false,'legend'=>false));?>
			</td>
			<td><?php echo __("Hide Narration");?></td>
		</tr>
	</tbody>
</table>

<?php echo $this->Form->end();?>
<div class="clr inner_title" style="text-align: right;"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0" style="padding-top:5px">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
	<table cellspacing="0" cellpadding="0" width="98%" align="center">
		<tr>
			<td></td>
			<td align="right">
			<?php $from1=explode(' ',$from);
				  $to1=explode(' ',$to);
				  
				  if($from!=null || $to!=null)
				  echo $from1[0]."  To ".$to1[0];
				  ?>
			</td>
		</tr>
	</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm" id="container-table">
	<thead>
		<tr> 
			<th width="7%" align="center" valign="top" style="text-align: center;"><?php echo __('Date');?></th>
			<th width="47%" align="center" valign="top" style="text-align: center;"><?php echo __('Particulars');?></th> 
			<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Voucher Type');?></th>
			<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Voucher No.');?></th> 
			<th width="13%" align="center" valign="top" style="text-align: center;"><?php echo __('Debit');?></th>
			<th width="13%" align="center" valign="top" style="text-align: center;"><?php echo __('Credit');?></th> 
		</tr> 
	</thead>
	<tbody>
		<tr>
			<td align="left" valign="top" style= "text-align: left;">
				<?php echo $from; ?>
			</td>
			<td align="left" valign="top" style= "text-align: left;font-weight:bold">
				<?php echo __('Opening Balance');?>
			</td>
			
			<td align="left" valign="top" style= "text-align: left;">
				&nbsp;
			</td>
			<td align="left" valign="top" style= "text-align: left;">
				&nbsp;
			</td>
			<td align="left" valign="top" style= "text-align: right; font-weight:bold">
			<?php if($type=='Dr'){ ?>
				<?php echo $this->Number->currency($openingBalance);?>
				<?php } ?>
			</td>
	
			<td align="left" valign="top" style= "text-align: right;">
				<?php if($type=='Cr'){ ?>
					<?php echo $this->Number->currency($openingBalance);?>					
				<?php }	?>
			</td> 
		</tr>
<?php 
$totalCreditAmount = $totalDebitAmount = 0;
?>

<!-- for Payment Voucher Entry by amit jain -->
<?php 
	if($this->request->data['Voucher']['type']!='debit' ){
		foreach($voucherPaymentDetails as $voucherPaymentDetails){?>	
				 <tr>
					<td align="left" valign="top" style= "text-align: left;">
					<?php echo $this->DateFormat->formatDate2Local($voucherPaymentDetails['VoucherPayment']['date'],Configure::read('date_format'),true); ?>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
					<div style="padding-left:0px;padding-bottom:3px;">
					<?php if($voucherPaymentDetails['VoucherPayment']['type']=='RefferalCharges'){
						echo "ML Enterprise";
					}else {?>
					<?php echo ucwords($voucherPaymentDetails['Account']['name']); 
					}?>
					</div>
					<div style="padding-left: 35px; font-size:13px; font-style:italic;">
					<?php
					echo __('Entered By : ').$voucherPaymentDetails['User']['first_name'].' '.$voucherPaymentDetails['User']['last_name'] ;
					?>
					</div>
					<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
					<?php echo __('Narration : ').$voucherPaymentDetails['VoucherPayment']['narration'] ; ?>
					</div>
					
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo __("Payment") ;?>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $voucherPaymentDetails['VoucherPayment']['id'] ;?>
					</td>
					<?php if($voucherPaymentDetails['VoucherPayment']['account_id']==$cash['Account']['id']) { ?>
					<td align="left" valign="top" style= "text-align: right;">
						<?php echo $this->Number->currency($voucherPaymentDetails['VoucherPayment']['paid_amount']) ;
						$totalDebitAmount +=  (double) $voucherPaymentDetails['VoucherPayment']['paid_amount'];
						?>
					</td>
					<td align="left" valign="top" style= "text-align: right;">
						&nbsp;
					</td> 
					<?php } else{ ?>
					<td align="left" valign="top" style= "text-align: right;">
						&nbsp;
					</td>
					<td align="left" valign="top" style= "text-align: right;">
						<?php echo $this->Number->currency($voucherPaymentDetails['VoucherPayment']['paid_amount']) ;
						$totalCreditAmount +=  (double) $voucherPaymentDetails['VoucherPayment']['paid_amount'];
						?>
					</td> 
					<?php }?>
				</tr>
		<?php } ?>
<?php }//EOF credit cond by pankaj ?>	

<!-- for Receipt Voucher Entry by amit jain -->
<?php if($this->request->data['Voucher']['type']!='credit' ){
foreach($transactionPaidAccounts as $transactionPaidAccounts) { ?>	
				
				 <tr>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $this->DateFormat->formatDate2Local($transactionPaidAccounts['AccountReceipt']['date'],Configure::read('date_format'),true); ?>
					</td>
					
					<td align="left" valign="top" style= "text-align: left;">
						<div style="padding-left:0px;padding-bottom:3px;">
							<?php echo ucwords($transactionPaidAccounts['Account']['name']); ?>
						</div>
						
						<div style="padding-left: 35px; font-size:13px; font-style:italic;">
							<?php echo __('Entered By : ').$transactionPaidAccounts['User']['first_name'].' '.$transactionPaidAccounts['User']['last_name']; ?>
						</div>
					
						<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
							<?php echo __('Narration : ').$transactionPaidAccounts['AccountReceipt']['narration']; ?>
						</div>
					
						<td align="left" valign="top" style= "text-align: left;"  >
							<?php echo __("Receipt") ;?>
						</td>
						
						<td align="left" valign="top" style= "text-align: left;"  >
							<?php echo $transactionPaidAccounts['AccountReceipt']['id']; ?>
						</td>
						
					<?php if($transactionPaidAccounts['AccountReceipt']['account_id']==$cash['Account']['id']) { ?>
					<td align="left" valign="top" style= "text-align: right;"  >
						&nbsp;
					<td align="left" valign="top" style= "text-align: right;"  >
						<?php echo $this->Number->currency($transactionPaidAccounts['AccountReceipt']['paid_amount']) ;
						$totalCreditAmount +=  (double) $transactionPaidAccounts['AccountReceipt']['paid_amount'];
						?>
					</td>
					<?php } else{ ?>
					<td align="left" valign="top" style= "text-align: right;"  >
						<?php echo $this->Number->currency($transactionPaidAccounts['AccountReceipt']['paid_amount']) ;
						$totalDebitAmount +=  (double) $transactionPaidAccounts['AccountReceipt']['paid_amount'];
						?>
					<td align="left" valign="top" style= "text-align: right;"  >
						&nbsp;
					</td>
					<?php }?>
				</tr>

<?php } }//eof debit cond by pankaj ?>

<?php
 foreach($transactionContraEntry as $transactionContraEntry){?>
<?php if($transactionContraEntry['Account']['name'] == Configure::read('cash')){ ?>	
<?php if($this->request->data['Voucher']['type']!='debit' ){ ?>
				 <tr>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $this->DateFormat->formatDate2Local($transactionContraEntry['ContraEntry']['date'],Configure::read('date_format'),true) ; ?>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<div style="padding-left:0px;padding-bottom:3px;">
							<?php echo ucwords($transactionContraEntry['AccountAlias']['name']); ?>
						</div>
						<div style="padding-left: 35px; font-size:13px; font-style:italic;">
							<?php echo __('Entered By : ').$transactionContraEntry['User']['first_name'].' '.$transactionContraEntry['User']['last_name'] ;?>
						</div>
						<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
							<?php echo __('Narration : ').$transactionContraEntry['ContraEntry']['narration'];?>
						</div>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo __("Contra") ;?>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $transactionContraEntry['ContraEntry']['id'] ;?>
					</td>
					<td>&nbsp;</td>
					<td align="left" valign="top" style= "text-align: right;"  >
						<?php echo $this->Number->currency($transactionContraEntry['ContraEntry']['debit_amount']) ;
						$totalCreditAmount +=  (double) $transactionContraEntry['ContraEntry']['debit_amount'];
						?>
					</td> 
					</tr>
					<?php } } else { if($this->request->data['Voucher']['type']!='credit' ){?>
					<tr>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $this->DateFormat->formatDate2Local($transactionContraEntry['ContraEntry']['date'],Configure::read('date_format'),true) ; ?>
					</td>
					<td align="left" valign="top" style= "text-align: left;">
						<div style="padding-left:0px;padding-bottom:3px;">
							<?php echo ucwords($transactionContraEntry['Account']['name']); ?>
						</div>
						<div style="padding-left: 35px; font-size:13px; font-style:italic;">
							<?php echo __('Entered By : ').$transactionContraEntry['User']['first_name'].' '.$transactionContraEntry['User']['last_name'] ;?>
						</div>
						<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
							<?php echo __('Narration : ').$transactionContraEntry['ContraEntry']['narration'];?>
						</div>
					</td>
					<td align="left" valign="top" style= "text-align: left;"  >
						<?php echo __("Contra") ;?>
					</td>
					<td align="left" valign="top" style= "text-align: left;"  >
						<?php echo $transactionContraEntry['ContraEntry']['id'] ;?>
					</td>
					<td align="left" valign="top" style= "text-align: right;">
						<?php echo $this->Number->currency($transactionContraEntry['ContraEntry']['debit_amount']) ;
						$totalDebitAmount +=  (double) $transactionContraEntry['ContraEntry']['debit_amount'];?>
					</td>
					<td>&nbsp;</td>
					</tr>
					<?php } 
						}
					 }?>
				</tbody>
			</table>
	
			<table width="99%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
				<?php 
					if($type == 'Dr'){
					$totalDebitAmount += (double) $openingBalance;
					}else if($type == 'Cr'){
					$totalCreditAmount += (double) $openingBalance;
					}
				?>
			    <tr>			
					<td align="right" valign="top" style= "text-align: left;" colspan="4" width="74%">
						&nbsp;
					</td>
					<td align="left" valign="top" style= "text-align: right;" colspan="1" width="13%">
						<?php echo $this->Number->currency($totalDebitAmount);?>
					</td>
					<td align="left" valign="top" style= "text-align: right;" colspan="1" width="13%">
						<?php echo $this->Number->currency($totalCreditAmount);?>
					</td>
				</tr>
				
				<tr>			
					<td align="right" valign="top" style= "text-align: right;" colspan="4" width="74%">
						<font color="red"><b><?php echo __("Closing Balance :");?></b></font>
					</td>
					<td align="left" valign="top" style= "text-align: right;" colspan="1" width="13%"><font color="red"><b>
					<?php 
						if($totalCreditAmount > $totalDebitAmount){
							echo $this->Number->currency($totalCreditAmount - $totalDebitAmount);
						}
					?>
					</b></font></td>
					<td align="left" valign="top" style= "text-align: right;" colspan="1" width="13%"><font color="red"><b>
					<?php 
						if($totalDebitAmount > $totalCreditAmount){
							echo $this->Number->currency($totalDebitAmount - $totalCreditAmount);
						}
					?>
					</b></font></td>
				</tr>
				
				<tr>			
					<td align="right" valign="top" style= "text-align: left;"  colspan="4" width="74%">
					&nbsp;
					</td>
					<td align="left" valign="top" style= "text-align: right;"  colspan="1" width="13%">
					<?php 
						if($totalCreditAmount > $totalDebitAmount){
							echo $this->Number->currency($totalCreditAmount);
						}
						if($totalDebitAmount > $totalCreditAmount){
							echo $this->Number->currency($totalDebitAmount);
						}
					?>
					</td>
					<td align="left" valign="top" style= "text-align: right;"  colspan="1" width="13%">
					<?php 
						if($totalCreditAmount > $totalDebitAmount){
							echo $this->Number->currency($totalCreditAmount);
						}
						if($totalDebitAmount > $totalCreditAmount){
							echo $this->Number->currency($totalDebitAmount);
						}
					?>
					</td>
				</tr>	
			</table>
		</td>
	</tr>
</table>

<script>
$(document).ready(function(){
	$("#container-table").freezeHeader({ 'height': '500px' });
	 $("#isShowNarration").val(0);
	 $("#excel").val(0);
	 $("#isShowNarration").click(function(){
			if($(this).prop('checked')){ 
				$(".narration").hide();
	            $("#isShowNarration").val(1);
	            $("#excel").val(1);
	        }else{
	        	$(".narration").show();
	            $("#isShowNarration").val(0);
	            $("#excel").val(0);
	        }
	     });
	$("#from").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	 
 	$("#to").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
	
	$( "#search" ).click(function(){ 
		 result  = compareDates($('#from').val(),$('#to').val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat 
			 if(!result){ 
		 	alert("To date should be greater than from date");
		 }
		 return result ;
	});

	 jQuery("#patientVoucher").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});	
		
	 $("#print").click(function() {
		 var isHide = $('#isShowNarration').val();
		 var queryString = "?from="+"<?php echo $from;?>"+"&to="+"<?php echo $to;?>"+"&narration="+"<?php echo $narration;?>"+"&amount="+"<?php echo $amount;?>"+"&dateArray="+"<?php echo $dateArray;?>"+"&type="+"<?php echo $new_type;?>"+"&location_id="+"<?php echo $location_id;?>"+"&isHide="+isHide;
		 var url="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'printCashierTransaction')); ?>"+ queryString;
		 window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200");
		});
	 $("#excel").click(function() {
		 var isHide = $('#excel').val();
		 var queryString = "?from="+"<?php echo $from;?>"+"&to="+"<?php echo $to;?>"+"&narration="+"<?php echo $narration;?>"+"&amount="+"<?php echo $amount;?>"+"&dateArray="+"<?php echo $dateArray;?>"+"&type="+"<?php echo $new_type;?>"+"&location_id="+"<?php echo $location_id;?>"+"&isHide="+isHide;
		 var url="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'getAllCashierTransactions','excel')); ?>"+ queryString;
		 window.location.href=url;
		});
});
</script>
	