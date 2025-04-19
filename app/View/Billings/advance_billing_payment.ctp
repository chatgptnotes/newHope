<style>
.billing_table {
	padding-left: 10px;
	margin-left: 10px;
	padding-top: 10px;
	margin-top: 10px;
	padding-right: 10px;
	margin-right: 10px;
	clear: both;
	background: lightgray"
}
</style>
<?php if($isSuccess == 'yes'){ ?>
<script>
	parent.location.href  = "<?php echo $this->Html->url(array('controller'=>"Billings",'action'=>'multiplePaymentModeIpd',$patientID,'#'=>'serviceOptionDiv')); ?>"; 
	parent.getbillreceipt('<?php echo $patientID;?>');
	parent.jQuery.fancybox.close();
</script>
<?php }elseif($isSuccess == 'no'){  //for pharmacy advance payment  --yashwant?>
<script>
	//parent.location.href  = "<?php //echo $this->Html->url(array('controller'=>"Pharmacy",'action'=>'inpatientList')); ?>"; 
	parent.jQuery.fancybox.close();
</script>
<?php }
echo $this->Form->create('billings',array('url'=>array('controller'=>'billings','action'=>'advanceBillingPayment','?'=>array('category'=>$category)),'id'=>'advancePaymentFrm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('Billing.patient_id',array('value'=>$patientID));
echo $this->Form->hidden('Billing.appoinment_id',array('value'=>$appoinmentID));
?>
<div class="inner_title" style="width: 96%">
	<h3>&nbsp;
		<?php echo __('Advance Payment', true); ?>
	</h3>
</div>
<table width="95%" cellspacing="0" cellpadding="0" border="0" class="billing_table" bgcolor="LightGray" >
	<tbody>
	
		<tr>
			<td width=" " valign="top">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<?php 
				if($category=='pharmacy'){
					if(isset($returnAmount) && !empty($returnAmount)){ ?>
						<tr>
							<td width="25%" height="30" class="tdLabel2"><strong>Returned Amount: </strong></td>
							<td><?php 
							echo number_format($returnAmount,2);
							echo $this->Form->hidden('Billing.returned_amount',array('type'=>'text','div'=>false,'label'=>false,'id'=>'returned_amount'));?>
							<td>&nbsp;</td>
						</tr>
					<?php }
				}else{?>
					<tr>
						<td width="25%" height="30" class="tdLabel2"><strong>Returned Amount: </strong></td>
						<td><?php 
						echo number_format($returnAmount,2);
						echo $this->Form->hidden('Billing.returned_amount',array('type'=>'text','div'=>false,'label'=>false,'id'=>'returned_amount'));?>
						<td>&nbsp;</td>
					</tr>
				<?php }?>
				<?php if(isset($maxRefundAmount) && !empty($maxRefundAmount)) { ?>
				<tr>
					<td width="25%" height="30" class="tdLabel2"><strong>Advance Amount</strong></td>
					<td><?php echo number_format($maxRefundAmount,2); ?> </td>
					<td>&nbsp;</td>
				</tr> 
				<?php } ?>
				<?php 
				if($category=='pharmacy'){
					if(isset($returnAmount) && !empty($returnAmount)){?>
					<tr>
						<td width="25%" height="30" class="tdLabel2"><strong>Is Refund:</strong></td>
						<td><?php echo $this->Form->input('Billing.refund',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'is_refund','title'=>'Check For Refund'));?>
						<?php echo $this->Form->input('Billing.paid_to_patient',array('legend'=>false,'label'=>false,'id' => 'refundAmount',
								'style'=>'text-align:right; display:none','class' => 'validate[required,custom[onlyNumber]]' )); ?> </td>
						<td>&nbsp;</td>
					</tr> 
					<?php }
				}else{?>
					<tr>
						<td width="25%" height="30" class="tdLabel2"><strong>Is Refund:</strong></td>
						<td><?php echo $this->Form->input('Billing.refund',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'is_refund','title'=>'Check For Refund'));?>
						<?php echo $this->Form->input('Billing.paid_to_patient',array('legend'=>false,'label'=>false,'id' => 'refundAmount',
								'style'=>'text-align:right; display:none','class' => 'validate[required,custom[onlyNumber]]' )); ?> </td>
						<td>&nbsp;</td>
					</tr>
				<?php }?>
				<?php if($patient['Patient']['is_discharge']!='1'){?>
				<tr id="nonRefundAmount">
					<td width="25%" height="30" class="tdLabel2"><strong>Collect from Patient:</strong><font color="red">*</font></td>
					<td> <?php echo $this->Form->input('Billing.amount',array('value' =>$totalBal,'legend'=>false,'label'=>false,'id' => 'totalamountpending',
							'style'=>'text-align:right;','class' => 'validate[required,custom[onlyNumber]]' )); ?> </td>
				   	<td>&nbsp;</td>
				</tr> 
				<?php }?>
				
                 
				<tr>
				    <td height="30" class="tdLabel2">Payment Date<font color="red">*</font></td>
				    <td><?php $todayDate=date("d/m/Y H:i:s");
				    	echo $this->Form->input('Billing.date',array('readonly'=>'readonly','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text',
							'legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:140px;','autocomplete'=>'off','value'=>$todayDate));?></td>
			    </tr>
			 	
			 	<tr>
				 	<td height="30" class="tdLabel2"><strong>Mode Of Payment<span id="mandatoryModeOfPayment"><font color="red">*</font></span></strong></td>
				    <td><?php echo $this->Form->input('Billing.mode_of_payment', array('class' => 'textBoxExpnd','style'=>'width:141px;',
   								'div' => false,'label' => false,/*'empty'=>__('Please select'),*/'autocomplete'=>'off','default'=>'Cash',
   								'options'=>array('Bank Deposit'=>'Bank Deposit','Cash'=>'Cash','Cheque'=>'Cheque','Debit Card'=>'Debit Card','Credit Card'=>'Credit Card','NEFT'=>'NEFT'),
				    			'id' => 'mode_of_payment')); ?></td>
				</tr>
 
				<tr id="creditDaysInfo" style="display: none">
					<td height="30" class="tdLabel2">Credit Period<font color="red">*</font><br />(in days)</td>
					<td><?php echo $this->Form->input('Billing.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'credit_period','class'=> 'validate[required,custom[mandatory-enter-only]]'));?>
					</td>
				</tr>
						
				<tr id="bankDeposite" style="display:none">
				  	<td height="30" class="tdLabel2">Bank Name<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.bank_deposite',array('empty'=>__('Please select'),'options'=>$bankData,'legend'=>false,'label'=>false,'id' => 'bank_deposite',
				    		'class'=> 'validate[required,custom[mandatory-select]]'));?></td>
			   </tr>
   
				<tr id="paymentInfo" style="display: none">
					<td height="30" colspan="2" class="tdLabel2">
						<table width="100%">
							<tr>
								<td class="tdLabel2" width="20%">Bank Name<font color="red">*</font></td>
								<td><?php echo $this->Form->input('Billing.bank_name',array('class'=>'validate[required,custom[mandatory-enter]]',
										'empty'=>__('Please select'),'options'=>$bankData,'legend'=>false,'label'=>false,'id' => 'BN_paymentInfo'));?></td>
							</tr>
							<tr>
								<td class="tdLabel2">Account No.</td>
								<td><?php echo $this->Form->input('Billing.account_number',array('class'=>'','type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfo'));?>
								</td>
							</tr>
							<tr>
								<td class="tdLabel2"><span id="chequeCredit"></span><font
									color="red">*</font></td>
								<td><?php echo $this->Form->input('Billing.check_credit_card_number',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?>
								</td>
							</tr>
							<tr>
							    <td>Date<font color="red">*</font></td>
							    <td><?php echo $this->Form->input('Billing.cheque_date',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd','id' => 'cheque_date'));?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr id="neft-area" style="display: none;">
					<td height="30" colspan="2" class="tdLabel2">
						<table width="100%">
							<tr>
								<td class="tdLabel2" width="20%">Bank Name<font color="red">*</font></td>
								<td><?php echo $this->Form->input('Billing.bank_name_neft',array('class'=>'validate[required,custom[mandatory-enter]]',
										'empty'=>__('Please select'),'options'=>$bankData,'legend'=>false,'label'=>false,'id' => 'BN_neftArea'));?>
								</td>
							</tr>
							<tr>
								<td class="tdLabel2">Account No.</td>
								<td><?php echo $this->Form->input('Billing.account_number_neft',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea'));?>
								</td>
							</tr>
							<tr>
								<td class="tdLabel2">NEFT No.<font color="red">*</font>
								</td>
								<td><?php echo $this->Form->input('Billing.neft_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number'));?>
								</td>
							</tr>
							<tr>
								<td class="tdLabel2">NEFT Date<font color="red">*</font>
								</td>
								<td><?php echo $this->Form->input('Billing.neft_date',array('type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd','id' => 'neft_date'));?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			  
				<tr id="reasonForBalance" style="display:none;">
					<td width="20%" height="30" class="tdLabel2"><?php echo __('Reason For Balance' );?><font color="red">*</font></td>
					<td width="20%"><?php echo $this->Form->input('Billing.reason_of_balance', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'empty'=>__('Please select'),
										'options'=>array('Insufficient Money'=>'Insufficient Money','No Money'=>'No Money','Poor'=>'Poor','Credit Period'=>'Credit Period'),'id' => 'reason_of_balance'));  ?>
			    	</td>
	
					<td width="80%">
						<table width="80%" border="0">
							<tr>
								<td><?php echo $this->Form->input('Billing.balance_authorize_by', array('class' => 'textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'balance_authorize_by','style'=>"display:none; width:120px"));?></td>
							<td><?php echo $this->Html->link(__('Send request for approval'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send_approval_for_balance',"style"=>"display:none;"));
		                 	 echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-balance-approval',"style"=>"display:none;"));?>
		                		</td>
		                		<td><?php echo $this->Form->hidden('Billing.is_balance_approved',array('id'=>'balance_approved','value'=>''));?></td>
		                	</tr>
	                	</table>
	                </td>
	            </tr> 
						 
				<tr>
					<td height="30" class="tdLabel2">Remark</td>
					<td width="200" colspan="2" class="paymentRemarkReceived">
					<?php echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,'id' => 'receivedRemark','cols'=>'20','rows'=>'5',
							'value'=>'Being cash received towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));?></td>
				</tr>
				
				<tr>
					<td><?php echo $this->Form->submit('Save',array('id'=>'submitBill','class'=>'blueBtn submitBill','div'=>false,'label'=>false,
							'style'=>'float:left;margin-right:10px;'));?></td>
				</tr>
				</tbody>
			</table>
			</td>
			 
           </tr>
           <?php //}?>
		<tr>
			<td>&nbsp;</td>
		</tr>
		
		<?php if($advancePaymentList){?>
		<tr>
		<td align="center">
			<?php //debug($advancePaymentList);?>
			<table width="60%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm"  >
				<tr>
					<th>Date</th>
					<th>Amount</th>
					<?php if($patient['Patient']['tariff_standard_id']!=$getTariffRgjayId){?>
					<th>Print</th>
					<?php }?>
				</tr>
				
				<?php foreach($advancePaymentList as $advancePaymentList){?>
				<tr>
					<td><?php echo $this->DateFormat->formatDate2Local($advancePaymentList['Billing']['date'],Configure::read('date_format'),true);?></td>
					<td><?php echo $advancePaymentList['Billing']['amount'];?></td>
					<?php if($patient['Patient']['tariff_standard_id']!=$getTariffRgjayId){?>
					<td><?php 
					if($category=='pharmacy' && strtolower($this->Session->read('website.instance'))=='kanpur'){
						echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
							$advancePaymentList['Billing']['id'],'?'=>array('flag'=>'roman_header')))."', '_blank',
							'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
					}else{
						echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
							$advancePaymentList['Billing']['id']))."', '_blank',
							'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
					}
					 /* //comented because delete is not needed as refund is there.. --yashwant
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteAdvanceEntery','id'=>'deleteAdvanceEntery_'.$advancePaymentList['Billing']['id']),
							array('escape' => false)),array('controller'=>'billings','action'=>'deleteAdvanceBillingEntry',$advancePaymentList['Billing']['id'],$patientID),array('escape' => false),__('Are you sure?', true));
					*/?></td>
					<?php }?>
				</tr>
				<?php }?>
			</table>
		</td>
		</tr>
		<?php }?>
	</tbody>
</table>

<?php echo $this->Form->end(); ?>

<script> 

$("#submitBill").click(function(){
	var validatePerson = jQuery("#advancePaymentFrm").validationEngine('validate'); 
 	if(!validatePerson){
	 	return false;
	}
});
					
   if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque' || $("#mode_of_payment").val() == 'Debit Card'){
		 $("#paymentInfo").show();
		 $("#creditDaysInfo").hide();
		 $('#neft-area').hide();
		 $('#bankDeposite').hide();
	} else if($("#mode_of_payment").val() == 'Credit') {
	 	$("#creditDaysInfo").show();
	 	$("#paymentInfo").hide();
	 	$('#neft-area').hide();
	 	$('#bankDeposite').hide();
	} else if($('#mode_of_payment').val()=='NEFT') {
	    $("#creditDaysInfo").hide();
		$("#paymentInfo").hide();
		$('#neft-area').show();
		$('#bankDeposite').hide();
	} else if($('#mode_of_payment').val()=='Bank Deposit') {
 	    $("#creditDaysInfo").hide();
 		$("#paymentInfo").hide();
 		$('#neft-area').hide();
 		$('#bankDeposite').show();
 	}
	//EOF payment laod
	
	if($('#mode_of_discharge').val() == 'Recovered'){
		$('#dischargeSummery').show();
		$('#dischargeDate').show();
	}
	if($('#mode_of_discharge').val() == 'DAMA'){
		$('#dama').show();
		$('#dischargeDate').show();
	}
	if($('#mode_of_discharge').val() == 'Death'){
		$('#death').show();
		$('#dischargeDate').show();
	}
	if($('#mode_of_discharge').val() == 'DischargeOnRequest'){
		//alert('here');
		$('#dischargeSummery').show();
		$('#dischargeDate').show();
	}
	 
	// jQuery("#ConsultantBilling").validationEngine();
	 $( "#discharge_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',

			minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
			maxDate : new Date(),
			
			onSelect:function(){$(this).focus();}
			
		});

	 $( "#cheque_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			//minDate:new Date(<?php //echo $this->General->minDate($wardInDate) ?>),
			onSelect:function(){$(this).focus();}
		});

	 $( "#neft_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
		///	minDate:new Date(<?php //echo $this->General->minDate($wardInDate) ?>),
			onSelect:function(){$(this).focus();}
		});
		
 $("#mode_of_payment").change(function(){
 $('#chequeCredit').html($(this).val()+' No.');
	if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque' || $("#mode_of_payment").val() == 'Debit Card'){
		 $("#paymentInfo").show();
		 $("#creditDaysInfo").hide();
		 $('#neft-area').hide();
		 $('#bankDeposite').hide();
	} else if($("#mode_of_payment").val() == 'Credit') {
	 	$("#creditDaysInfo").show();
	 	$("#paymentInfo").hide();
	 	$('#neft-area').hide();
	 	$('#bankDeposite').hide();
	} else if($('#mode_of_payment').val()=='NEFT') {
	    $("#creditDaysInfo").hide();
		$("#paymentInfo").hide();
		$('#neft-area').show();
		$('#bankDeposite').hide();
	}else if($('#mode_of_payment').val()=='Bank Deposit') {
	    $("#creditDaysInfo").hide();
		$("#paymentInfo").hide();
		$('#neft-area').hide();
		$('#bankDeposite').show();
	}else{
		 $("#creditDaysInfo").hide();
		 $("#paymentInfo").hide();
		 $('#neft-area').hide();
		 $('#bankDeposite').hide();
	}
 });
	 
 $("#mode_of_discharge").change(function(){
	if($("#mode_of_discharge").val() == 'Recovered'){
		 $("#dischargeSummery").show();
		 $("#death").hide();
		 $("#dama").hide();
		 $("#dischargeDate").show();
		 
	}else if($("#mode_of_discharge").val() == 'DischargeOnRequest'){
		 $("#dischargeSummery").show();
		 $("#death").hide();
		 $("#dama").hide();
		 $("#dischargeDate").show();
	}else if($("#mode_of_discharge").val() == 'DAMA'){
		$("#dama").show();
		$("#dischargeSummery").hide();
		$("#death").hide();
		$("#dischargeDate").show();
	}else if($("#mode_of_discharge").val() == 'Death'){
		$("#death").show();
		$("#dama").hide();
		$("#dischargeSummery").hide();
		$("#dischargeDate").show();
	}else if($("#mode_of_discharge").val() == ''){
		$("#dischargeDate").hide();
	}
 });
	  
$('#reason_of_balance').change(function(){
	if($(this).val()=='Credit Period'){
	  $('#mandatoryGuarantor').show();
	  $('#guarantor').addClass('validate[required,custom[mandatory-select]]');
	}else{
	  $('#mandatoryGuarantor').hide();
	  $('#guarantor').removeClass('validate[required,custom[mandatory-select]]');
	}
});

$(document).on('keyup',"#refundAmount",function() {
  	if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }

  })

$('#is_refund').click(function(){// --yashwant for refund
	var patientName='<?php echo $patient['Patient']['lookup_name'];?>';
	if($("#is_refund").is(":checked")){
		$('#totalamountpending').val('');
		$('#refundAmount').show('slow');
		$('#nonRefundAmount').hide('slow');
		$('#receivedRemark').val('Being cash refunded to pt. '+patientName+' against R. No.:');
		
	}else{
		$('#refundAmount').val('');
		$('#refundAmount').hide('slow');
		$('#nonRefundAmount').show('slow');
		$('#receivedRemark').val('Being cash received towards  from pt. '+patientName+' against R. No.:');

		
	}
});

$('#refundAmount').keyup(function(){ //--yashwant for refund not greater than max refund amount
	var returnAmount = parseInt('<?php echo $returnAmount;?>');
	var maxRefundAmount = parseInt('<?php echo $maxRefundAmount;?>');
	if(returnAmount != ''){
		maxRefundAmount = maxRefundAmount + returnAmount;
	}
	var refundAmount=parseInt($(this).val());
	if(refundAmount>maxRefundAmount){
		alert('Refunded amount can not be greater than '+maxRefundAmount);
		$(this).val('');
		$(this).focus();
	}
});

</script>
