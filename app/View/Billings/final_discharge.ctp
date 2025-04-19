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

<?php if($this->params->query['is_success'] == 'yes'){?>
<script>
	parent.location.href  = "<?php echo $this->Html->url(array('controller'=>"Billings",'action'=>'multiplePaymentModeIpd',$patientID)); ?>"; 

	parent.getbillreceipt('<?php echo $patientID;?>');
	parent.jQuery.fancybox.close();
</script>
<?php } 

echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveFinalBill','id'=>'saveFinalBill','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('Billing.patient_id',array('value'=>$patientID));
echo $this->Form->hidden('Billing.appoinment_id',array('value'=>$appoinmentID));
echo $this->Form->hidden('payOnlyAmount',array('value'=>$totalPaymentFlag));

echo $this->Form->hidden('doctor_charges',array('value'=>$doctorCharges));
echo $this->Form->hidden('nursing_charges',array('value'=>$nursingCharges));
echo $this->Form->hidden('room_charges',array('value'=>serialize($ward_days)));

$hospitalType = $this->Session->read('hospitaltype');
if($hospitalType == 'NABH'){
	$nursingServiceCostType = 'nabh_charges';
}else{$nursingServiceCostType = 'non_nabh_charges';
}
$total_amount_lab=0;
foreach($getLabData as $getLabData){
	if(!empty($getLabData['LaboratoryTestOrder']['amount']) && $getLabData['LaboratoryTestOrder']['amount']!=0){
		$total_amount_lab=$total_amount_lab+$getLabData['LaboratoryTestOrder']['amount'];
	}else{
		$total_amount_lab=$total_amount_lab+$getLabData['TariffAmount'][$nursingServiceCostType];
	}
	//$total_amount_lab=$total_amount_lab+$getLabData['TariffAmount'][$nursingServiceCostType];
}

$total_amount_rad=0;
foreach($getRadData as $getRadData){
	if(!empty($getRadData['RadiologyTestOrder']['amount']) && $getRadData['RadiologyTestOrder']['amount']!=0){
		$total_amount_rad=$total_amount_rad+$getRadData['RadiologyTestOrder']['amount'];
	}else{
		$total_amount_rad=$total_amount_rad+$getRadData['TariffAmount'][$nursingServiceCostType];
	}
	//$total_amount_rad=$total_amount_rad+$getRadData['TariffAmount'][$nursingServiceCostType];
	//$total_amount_rad=$total_amount_rad+$getRadData['RadiologyTestOrder']['amount'];
}

//pharmacy charge
/*$totalPharmacyCharge=0;
foreach($pharmacyCharges as $pharmacyCharges){
	$rate=$pharmacyCharges['rate']?$pharmacyCharges['rate']:1;
	$quantity=$pharmacyCharges['quantity']?$pharmacyCharges['quantity']:1;
	$totalPharmacyChargeTemp=$rate*$quantity;
	$totalPharmacyCharge=$totalPharmacyCharge+$totalPharmacyChargeTemp;
}*/

//surgery charge
$totalSurgeryAmount=0;
foreach($surgeryData as $key => $surgery){
	if($surgery['start']){
	$anaesthesiaCost = ($surgery['anaesthesist']) ? $surgery['anaesthesia_cost'] : 0;
	$asstSurgeonOneCharge = ($surgery['asst_surgeon_one']) ? $surgery['asst_surgeon_one_charge'] : 0;
	$asstSurgeonTwoCharge = ($surgery['asst_surgeon_two']) ? $surgery['asst_surgeon_two_charge'] : 0;
	$cardiologist = ($surgery['cardiologist']) ? $surgery['cardiologist_charge'] : 0;
	
		$totalSurgeryAmount = $totalSurgeryAmount + $surgery['cost'] + $anaesthesiaCost + $surgery['ot_charges'] + $surgery['surgeon_cost'] + $asstSurgeonOneCharge + 
		$asstSurgeonTwoCharge + $cardiologist + $surgery['ot_assistant'] + $surgery['extra_hour_charge'] + array_sum($surgery['ot_extra_services']) ;
	}
}

//service charge
$totalMandatoryService=$registrationRate+$doctorRate;
$serviceTotal=0;
foreach($servicesData as $serviceKey =>$serviceValue){
	$serviceTotal=$serviceTotal+$serviceValue[0]['totalService'];
}

//Pharmacy Charges
/*$pharmaTotal=0;
foreach($pharmacy_charges as $charges){
	$perItemCharge=$charges['quantity']*$charges['rate'];
	$pharmaTotal=$pharmaTotal+$perItemCharge;
}*/

//consultant charge
$total_amount_consultant=0;
foreach($getconsultantData as $getconsultantData){
	$total_amount_consultant=$total_amount_consultant+$getconsultantData['ConsultantBilling']['amount'];
}
/**
$variable = $pharmacy_charges[0][total];
echo "$totalCharge = $serviceTotal + $total_amount_lab + $total_amount_rad + $variable + $totalSurgeryAmount + $totalRoomTariffCharge +
$doctorCharges + $nursingCharges + $total_amount_consultant + $package[total_amount];";
*/
$totalCharge=$serviceTotal+$total_amount_lab+$total_amount_rad+ceil($pharmacy_charges[0]['total'])+$totalSurgeryAmount+$totalRoomTariffCharge+
$doctorCharges+$nursingCharges+$total_amount_consultant+$package['total_amount']/*+$totalMandatoryService*/;
 
$singleAdvancePaid = 0 ;//set advance paid

foreach($servicePaidData as $servicePaidDataKey =>$servicePaidDataValue){
	$singleAdvancePaid=$singleAdvancePaid+$servicePaidDataValue[0]['sumService'];
}

if($patient['Patient']['is_discharge']!=1){
	/*$totalPaid=$serviceData[0]['sumService']+$labData[0]['sumLab']+$radData[0]['sumRad']+$paidMandatoryServiceCharge['0']['sumService']+
	 $implantData[0]['sumService']+$bloodData[0]['sumService']+$advancePaid[0]['sumAdvance'];/*-$refundPatient[0]['sumRefund'];*/
	$totalPaid=$singleAdvancePaid+$pharmacy_cash_total;
}else{
	$totalPaid=$finaltotalPaid['0']['sumFinaltotalPaid']+$advancePaid[0]['sumAdvance']+$pharmacy_cash_total;
}
$totalBal=$totalCharge-$totalPaid-$totalHeadDiscount[0]['sumDiscount']+$totalHeadRefund[0]['sumRefund']/* -$totalPharmacyRefund[0]['sumRefund'] */;
//for refunded amount
/*if($discountData['FinalBilling']['refund']=='1'){
	$totalRefund=$discountData['FinalBilling']['paid_to_patient'];
	$totalBal=$totalBal+$totalRefund;
}else{
	$totalRefund='0';
	$totalBal=$totalBal+$totalRefund;
}*/

//EOF for refunded amount
//debug($totalHeadDiscount);
if($discountData['FinalBilling']['discount_type']=='Percentage'){
	$discountAmount=$discountData['FinalBilling']['discount'];
	$perVar=($discountData['FinalBilling']['discount'])/100;
	$discountVal=ceil(($discountData['FinalBilling']['total_amount'])*$perVar);
	$discauntedBal=$discountData['FinalBilling']['total_amount']-$discountVal;
}else{
	$discountVal=$discountData['FinalBilling']['discount'];
	$discauntedBal=$discountData['FinalBilling']['total_amount']-$discountVal;
	$discountAmount=$discountData['FinalBilling']['discount'];
}
?>
<script>
//var isRefunded='<?php //echo $discountData['FinalBilling']['refund'];?>';
//var refundedAmount='<?php //echo $discountData['FinalBilling']['paid_to_patient'];?>';

$(document).ready(function(){
	checkBalance();		//check balance if >0 display reason of balance
	var patientIsVIP='<?php echo $patient['Person']['vip_chk'];?>';
	if(patientIsVIP=='1'){
		 $("#show_percentage").show();
		 $("input[type='radio'][name='data[Billing][discount_type]'][value='Percentage']").attr('checked',true);
		 $('#discount').removeAttr("disabled");
		 $('#discount').val("100");
		 $('#totalamountpending').val('0');
		 $('#mode_of_payment').removeClass('validate[required,custom[mandatory-select]]');
		 $("#mandatoryModeOfPayment").hide();
	}
	
	/* var discountGivenBy='<?php //echo $discountData['FinalBilling']['refund_authorize_by'];?>';
	if(isRefunded=='1'){
		$('#is_refund').attr('checked',true);
        $("#refund_amount").show();
        $("#refund_amount").val(refundedAmount);
        $("#discount_authorize_by_for_refund").show();
        $("#discount_authorize_by_for_refund").val(discountGivenBy);
        //$("#send-approval-for-refund").show();
	}*/
});	
</script>
<div class="inner_title" style="width: 95%">
	<h3>
		&nbsp;
		<?php echo __('Final Payment', true); ?>
	</h3>
</div>
<table width="95%" cellspacing="0" cellpadding="0" border="0" class="billing_table" bgcolor="LightGray" >
	<tbody>
		<tr>
			<td width=" " valign="top">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td width="20%" height="30" class="tdLabel2"><?php echo __('Total Amount' );?>
							</td>
							<td width="100"><?php  echo $this->Form->input('Billing.total_amount',array('readonly'=>'readonly','value' =>  $totalCharge,'legend'=>false,'label'=>false,'id' => 'totalamount','style'=>'text-align:right;','readonly'=>'readonly')); ?>
							</td>
							<td>&nbsp;</td>
						</tr>
						<?php if(!empty($totalHeadDiscount[0]['sumDiscount'])){?>
						<tr>
							<td width="20%" height="30" class="tdLabel2"></td>
							<td width="100"><?php echo ("Discount Given : Rs. ".$totalHeadDiscount[0]['sumDiscount']);?></td>
							<td>&nbsp;</td>
						</tr>
						<?php }?>
	 
						<?php if(!empty($totalHeadRefund[0]['sumRefund'])){?>
						<tr>
							<td width="20%" height="30" class="tdLabel2"></td>
							<td width="100"><?php echo ("Amount Refunded : Rs. ".$totalHeadRefund[0]['sumRefund']);?></td>
							<td>&nbsp;</td>
						</tr>
						<?php }?>
  
						<tr>
							<td width="20%" height="30" class="tdLabel2"><?php echo __('Discount' );?>
							</td>
							<td width="20%"><?php  $discount=array('Amount'=>'Amount','Percentage'=>'Percentage');
							echo $this->Form->input('Billing.discount_type', array('id' =>'discountType','options' => $discount,'autocomplete'=>'off','legend' =>false,'label' => false,'div'=>false,'class'=>'discountType','type' => 'radio','value'=>$discountData['FinalBilling']['discount_type']));?>
							</td>

							<td>
								<table border="0">
									<tr>
										<td><?php echo $this->Form->input('Billing.discount',array('type'=>'text','legend'=>false,
												'label'=>false,'id' => 'discount','autocomplete'=>'off','style'=>'text-align:right;',
												'class' => 'validate[optional,custom[onlyNumber]]','disabled'=>'disabled'/*,'value'=>$discountAmount*/));?>
											<span id="show_percentage" style="display: none">%</span> <?php echo $this->Form->hidden('Billing.disPerAmount',array('value'=>'','id'=>'disPerAmount'));?>
										</td>

										<td><?php 
		                 	echo $this->Form->input('Billing.discount_by', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Select User',$authPerson),'id' => 'discount_authorize_by','style'=>"display:none;")); ?>
		                 </td>
		                 
		                 <td>
		               <?php $disountReason = array('VIP'=>'VIP','Poor & needy'=>'Poor & needy','Hospital staff'=>'Hospital staff','Waiver'=>'Waiver','Others'=>'Others');
		                 	echo $this->Form->input('Billing.discountReason', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Select Reason',$disountReason),'id' => 'discount_reason','style'=>"display:none;")); ?>
		                 </td>
		                 
		                 <?php 
                 		if(isset($approval[DiscountRequest][is_approved]) && $approval[DiscountRequest][type] != "Refund")
                 		{
		                 ?>
		                  <td>
		               <?php 
		                 	echo $this->Form->input('Billing.discount_by', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'discount_authorize_by','value'=>$approval[DiscountRequest][request_to])); ?>
		                 </td>
		                 
		                 <td>
		                 	<?php 
								echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-approval'));
		                 	?>
		                 </td>
		                 <?php }else {?>
		                 <td>
		                 	<?php 
								echo $this->Html->link(__('Send request for discount approval'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval',"style"=>"display:none;"));
		                 	?>
		                 	<?php 
								echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-approval',"style"=>"display:none;"));
		                 	?>
		                 </td>
		                 <?php }?>
		                </tr>
	                </table>
	                </td>
                 </tr>
                 
                 <tr>
				      <td height="30" class="tdLabel2">Reason For Discount</td>
				      <td width="150"><?php echo $this->Form->input('Billing.reason_for_discount',array('legend'=>false,'label'=>false,'id' => 'reason_for_discount'));  ?></td>
			      </tr>
      
                 <tr>
                 <td height="30" class="tdLabel2">Advance Amount</td>
                 <td> <?php echo $this->Form->input('Billing.amount_paid',array('readonly'=>'readonly','value' =>$totalPaid,'legend'=>false,'label'=>false,
                 		'id' => 'totaladvancepaid','style'=>'text-align:right;')); ?> </td>
                <td> <?php if(!empty($totalHeadRefund[0]['sumRefund'])) echo ("Amount Refunded : Rs. ".$totalHeadRefund[0]['sumRefund']); else echo "&nbsp;"; ?> </td>
                </tr>
                
                <tr>
                 <td height="30" class="tdLabel2">Amount Paid</td>
                 <td> <?php echo $this->Form->input('Billing.amount',array('autocomplete'=>'off','type'=>'text',
				    		'legend'=>false,'label'=>false,'id' => 'amount','style'=>'text-align:right;','class' => 'validate[optional,custom[onlyNumber]]'));?></td>
                <td></td>
                </tr>
                
                <tr>
					<td width="20%" height="30" class="tdLabel2"><?php echo __('Refund' );?>
					</td>
					<td width="20%"><?php 
			    		if(isset($approval[DiscountRequest][is_approved]) && $approval[DiscountRequest][type] == "Refund")
			    		{
			    			$checked = "checked";
			    		}
			    		else{
			    			$checked = "";
			    		}
			    		echo $this->Form->input('Billing.refund',array('type'=>'checkbox','id'=>'is_refund','label'=>false,'style'=>"width:10px;",'checked'=>$checked));
			    		?> Yes/No
			    	</td>

					<td width="80%">
						<table width="80%" border="0">
							<tr>
								<td><?php echo $this->Form->input('Billing.paid_to_patient',array('type'=>'text','id'=>'refund_amount','style'=>"display:none; "));?></td>
								<td><?php echo $this->Form->input('Billing.refund_authorize_by', array('class' => 'textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'discount_authorize_by_for_refund','style'=>"display:none; width:120px"));?></td>
							<td><?php echo $this->Html->link(__('Send request for Refund approval'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval-for-refund',"style"=>"display:none;"));
		                 	 echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-refund-approval',"style"=>"display:none;"));?>
		                		</td>
		                	</tr>
	                	</table>
	                </td>
                 </tr>
                
                 <tr>
                <td height="30" class="tdLabel2"><strong>Collect from Patient:</strong></td>
                <td> <?php echo $this->Form->input('Billing.amount_pending',array('readonly'=>'readonly','value' =>$totalBal,
                		'legend'=>false,'label'=>false,'id' => 'totalamountpending','style'=>'text-align:right;','readonly'=>'readonly')); ?> </td>
			   	<td>&nbsp;</td>
			 	</tr>
			 	
				<tr>
				    <td height="30" class="tdLabel2">Payment Date<font color="red">*</font></td>
				    <td>
				    <?php $todayDate=date("d/m/Y H:i:s");
				    echo $this->Form->input('Billing.date',array('readonly'=>'readonly','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:140px;','autocomplete'=>'off','value'=>$todayDate));?>
				    </td>
				    
			    </tr>
			 	<?php if($this->Session->read('website.instance')=='vadodara' /* || $configInstance=='hope'*/){?>
				 	<tr>
				 		<td>Move From Card</td>
				   		<td><?php echo $this->Form->input('Billing.is_card',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'card_pay'));?></td>
				   	</tr>
				   	<tr id="patientCard" style="display:none">
					  	<td height="35" class="tdLabel2"><b>Balance In Card </b></td>
					    <td><font color="green" style="font-weight: bold;"><?php echo !empty($patientCard)?$patientCard:'0'; ?></font>
				   		</td>
						
				   </tr>
				   <tr id="patientCardDetails" style="display:none"><td>Amount To Be Moved From Card</td>
				      <td >
				   <?php if(empty($patientCard)){
									  		$payFromCard='0';
									  	}
									  	if($patientCard>=$totalCost){
									  		$payFromCard=$totalCost;
									  	}elseif($patientCard<=$totalCost){
											$payFromCard=$patientCard;
										}
										$payOtherMode=$totalCost-$payFromCard;
									  	echo $this->Form->input('Billing.patient_card',array('type'=>'text','legend'=>false,'label'=>false,'value'=>$payFromCard,'id' => 'patient_card'));?></td>
						</td>
						<td><?php echo '<b>Pay By Other Mode : <font color="red"><span id="otherPay"></span></font></b>';?></td>
						</tr>
				   	<?php }?>
 	 
			 	<tr>
				 	<td height="30" class="tdLabel2"><strong>Mode Of Payment<span id="mandatoryModeOfPayment"><font color="red">*</font></span></strong></td>
				    <td><?php echo $this->Form->input('Billing.mode_of_payment', array('class' => 'textBoxExpnd','style'=>'width:141px;',
				   								'div' => false,'label' => false,/*'empty'=>__('Please select'),*/'autocomplete'=>'off','default'=>'Cash',
				   								'options'=>array('Bank Deposit'=>'Bank Deposit','Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card','Credit'=>'Credit','NEFT'=>'NEFT'),'id' => 'mode_of_payment')); ?>
							</td>
						</tr>

						<?php //if(($totalAmountPending >0 && $patient['Patient']['is_discharge']==1) || $patient['Patient']['is_discharge']!=1){?>


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
										<td class="tdLabel2">Bank Name<font color="red">*</font></td>
										<td><?php echo $this->Form->input('Billing.bank_name',array('class'=>'validate[required,custom[mandatory-enter]]',
												'empty'=>__('Please select'),'options'=>$bankData,'legend'=>false,'label'=>false,'id' => 'BN_paymentInfo'));?></td>
									</tr>
									<tr>
										<td class="tdLabel2">Account No.<font color="red">*</font>
										</td>
										<td><?php echo $this->Form->input('Billing.account_number',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfo'));?>
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
										<td class="tdLabel2" width="47%">Bank Name<font color="red">*</font>
										</td>
										<td><?php echo $this->Form->input('Billing.bank_name_neft',array('class'=>'validate[required,custom[mandatory-enter]]',
												'empty'=>__('Please select'),'options'=>$bankData,'legend'=>false,'label'=>false,'id' => 'BN_neftArea'));?>
										</td>
									</tr>
									<tr>
										<td class="tdLabel2">Account No.<font color="red">*</font>
										</td>
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
						<?php //}
  if($patient['Patient']['admission_type']=='IPD'){?>
						<tr>
							<td height="30" class="tdLabel2"><strong>Reason Of Discharge<font
									color="red">*</font>
							</strong></td>
							<td><?php	 if($patient['Patient']['is_discharge']==1) $readOnly1 = 'disabled';else $readOnly1 = '';
							$reason =isset($finalBillingData['FinalBilling']['reason_of_discharge'])?$finalBillingData['FinalBilling']['reason_of_discharge']:'';
							echo $this->Form->input('Billing.reason_of_discharge', array('value'=>$reason,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'empty'=>__('Please select'),
   											 'options'=>array('Recovered'=>'Recovered','DischargeOnRequest'=>'Discharge On Request','DAMA'=>'DAMA','Death'=>'Death'),'id' => 'mode_of_discharge','disabled'=>$readOnly1));
   			?>
							</td>
							<td></td>
							<td height="30" class="tdLabel2">
								<table width="100%" id="dischargeSummery" style="display: none">
									<tr>
										<td><?php echo $this->Html->link('Discharge Summary',array('controller'=>'billings','action'=>'discharge_summary',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?>
										</td>
									</tr>
								</table>
								<table width="100%" id="dama" style="display: none">
									<tr>
										<td><?php echo $this->Html->link('DAMA Form',array('controller'=>'billings','action'=>'dama_form',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?>
										</td>
									</tr>
									<tr>
										<td><?php echo $this->Html->link('Discharge Summary',array('controller'=>'billings','action'=>'discharge_summary',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?>
										</td>
									</tr>
								</table>
								<table width="100%" id="death" style="display: none">
									<tr>
										<td><?php echo $this->Html->link('Death Certificate',array('controller'=>'billings','action'=>'death_certificate',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?>
										</td>
									</tr>
									<tr>
										<td><?php echo $this->Html->link('Death Summary',array('controller'=>'billings','action'=>'death_summary',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php }?>
						<!--  <tr id="dischargeDate" style="display:none">
	      <td >Discharge Date:<font color="red">*</font></td>
	      <td width="200"><?php 
		      if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
		      	if($patient['Patient']['is_discharge']==1) $readOnly = 'readonly';else $readOnly = '';
		      	$last_split_date_time = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
		      	echo $this->Form->input('Billing.discharge_date',array('value'=>$this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true),'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:150px;','readonly'=>$readOnly));
		      }else{
		      	echo $this->Form->input('Billing.discharge_date',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:150px;','readonly'=>'readonly'));
		      }
		      ?></td>
      </tr>    -->
						<?php //}?>

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
                 
						<!--<tr id="reasonForBalance" style="display:none;">
							<td height="30" class="tdLabel2">Reason For Balance</td>
							<td width="200"><?php echo $this->Form->input('Billing.reason_of_balance', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'empty'=>__('Please select'),
									'options'=>array('Insufficient Money'=>'Insufficient Money','No Money'=>'No Money','Poor'=>'Poor','Credit Period'=>'Credit Period'),'id' => 'reason_of_balance'));  ?>
							</td>
						</tr>-->
						
						<tr>
							<td height="30" class="tdLabel2">Guarantor<span
								id="mandatoryGuarantor" style="display: none"><font color="red">*</font>
							</span>
							</td>
							<td width="200"><?php echo $this->Form->input('Billing.guarantor', array('class' =>'textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'empty'=>__('Please select'),
									'options'=>$guarantor,'id' => 'guarantor'));?>
							</td>
						</tr>

						<?php /*?><tr>
	      <td height="30" class="tdLabel2">Discount Given By</td>
	      <td width="150"><?php //echo $this->Form->input('Billing.discount_by', array('class' => ' textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'empty'=>__('Please select'), 'options'=>$authPerson,'id' => 'discount_by')); ?></td>
      </tr><?php */ ?>

						<tr>
							<td height="30" class="tdLabel2">Remark</td>
					<!-- 		<td width="200" colspan="2"><?php echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
									'id' => 'remark','cols'=>'20','rows'=>'5','value'=>'Being cash received towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));
	      //echo $this->Form->input('Billing.remark', array('value'=>'','class' => ' textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'id' => 'remark'));  ?>
							</td> -->
						   <td width="200" colspan="2" class="paymentRemarkReceived"><?php echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
	      		'id' => 'receivedRemark','cols'=>'20','rows'=>'5','value'=>'Being cash received towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));
	      //echo $this->Form->input('Billing.remark', array('value'=>'','class' => ' textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'id' => 'remark'));  ?></td>
	      
	      <td width="200" colspan="2" class="paymentRemarkRefund" style="display: none"><?php echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
	      		'id' => 'refundRemark','cols'=>'20','disabled'=>'disabled','rows'=>'5','value'=>'Being cash refunded towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));  ?></td>	 
						</tr>
					</tbody>
				</table>
			</td>
			<td width="50">&nbsp;</td>
			<!--  <td width="47%" valign="top" align="right">
        <?php //if(($totalAmountPending >0 && $patient['Patient']['is_discharge']==1) || $patient['Patient']['is_discharge']!=1){
              if($patient['Patient']['is_discharge']!=1){?>
              	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                	<tbody><tr>
	                    <td width="80" height="30" class="tdLabel2">Discount</td>
	                    <td width="70">
						<?php 
							if(isset($finalBillingData['FinalBilling']['discount_percent'])){
								echo $this->Form->input('Billing.discount_percent',array('value'=>$finalBillingData['FinalBilling']['discount'],'legend'=>false,'label'=>false,'id' => 'discount_percent')); 
							}else{
								echo $this->Form->input('Billing.discount_percent',array('legend'=>false,'label'=>false,'id' => 'discount_percent')); 
							}
						?>
					  	%</td>
                        <td width="50"></td>
                        <td width="20"></td>	
                        <td width="10" class="tdLabel2"><?php //echo $this->Html->image('icons/refresh-icon.png',array('alt'=>__('Refresh Discount'),'title'=>__('Refresh Discount'),'id'=>'refresh-discount'))?></td>
                        <td width="10">&nbsp;</td>
                    </tr>
					<tr>
						<td width="80" height="30" class="tdLabel2">&nbsp;</td>
						<td width="70">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR</td>
						<td width="50"></td>
						<td width="20"></td>	
						<td width="10" class="tdLabel2">&nbsp;</td>
						<td width="10">&nbsp;</td>
					</tr>
					<tr>
						<td width="80" height="30" class="tdLabel2">&nbsp;</td>
						<td width="70">
							<?php 
								if(isset($finalBillingData['FinalBilling']['discount_rupees'])){
									echo $this->Form->input('Billing.discount_rupees',array('value'=>$finalBillingData['FinalBilling']['discount'],'legend'=>false,'label'=>false,'id' => 'discount_rupees')); 
								}else{
									echo $this->Form->input('Billing.discount_rupees',array('legend'=>false,'label'=>false,'id' => 'discount_rupees')); 
								}
							?>
			  			</td>
						<td width="50"></td>
						<td width="20"></td>	
						<td width="10" class="tdLabel2">&nbsp;</td>
						<td width="10">&nbsp;</td>
					</tr>
					<tr>
						<td width="80" height="30" class="tdLabel2">Reason for Discount</td>
						<td width="70">
							<?php 
									echo $this->Form->textarea('Billing.reason_for_discount',array('legend'=>false,'label'=>false,'id' => 'reason_for_discount')); 
								
							?>
					    </td>
						<td width="50"></td>
						<td width="20"></td>	
						<td width="10" class="tdLabel2">&nbsp;</td>
						<td width="10">&nbsp;</td>
					</tr></tbody>
				</table>   
                <?php }else{  //BOF credit voucher?>
                <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                	<tbody><tr>
	                    <td width="30%" height="30" class="tdLabel2">Credit Voucher</td>
	                    <td width="70%">
							<?php  echo $this->Form->input('Billing.discount_by_credit',array('legend'=>false,'label'=>false,'id' => 'discount_by_credit','class'=>'textBoxExpnd'));  ?> 
					  	</td> 
                    </tr> 
					<tr>
						<td   height="30" class="tdLabel2">Reason</td>
						<td  >
							<?php  echo $this->Form->textarea('Billing.reason_for_credit_voucher',array('legend'=>false,'label'=>false,'id' => 'reason_for_credit_voucher','class'=>'validate[required,custom[mandatory-enter-only]] textBoxExpnd')); 
							 ?>
					    </td>
						 
					</tr></tbody>
				</table> 
				<?php } //EOF credit voucher ?>
           </td>  -->                          
           </tr>
           <tr>
            	<td float="right" valign="top" style="padding-top: 15px;" colspan="2"> 
			 		 <?php //if($patient['Patient']['is_discharge']!=1){
				   			//$buttonlabel = ($patient['Patient']['admission_type']=='IPD')?'Discharge & Print Invoice':'Done & Print Invoice';?> 
				   	<!--  <input class="blueBtn" type="button" value="save" id="payAmount"> -->
				   		
				   		<?php echo $this->Form->hidden('Patient.discharge_status',array('id'=>'dischargeStatus'));?>
				     <?php if($patient['Patient']['is_discharge']!=1){                  
				     		echo $this->Form->submit('Submit',array('id'=>'submitBill','class'=>'blueBtn submitBill','div'=>false,'label'=>false,'style'=>'float:left;margin-right:10px;'));
						   }else{?>
								<input class="blueBtn payafterDischarge" type="button" value="Done" id="payafterDischarge" style="float:left;margin-right:10px;">
						   <?php }?>
						   &nbsp;
						   
						   <?php if(isset($approval[DiscountRequest][is_approved]) && $approval[DiscountRequest][is_approved] == 0) { ?>
						   <div style="float: left; margin-top: 3px;">
						   <i id="mesage">
						   	(<font color="red">Note: </font>Request for <?php if($approval[DiscountRequest][type] != "Refund"){ echo $is_not_approved = "Discount";  } else { echo $is_not_approved = "Refund"; } ?> has been sent, please wait for approval )  
						   		<span style="float: right; margin: -3px 0px 0px 7px;"><?php echo $this->Html->image('/img/wait.gif')?> </span>
						   	</i>
						   	</div>
						   	<?php } else {?>
						   	
						   <div style="float: left; margin-top: 3px;">
						   <i id="mesage" style="display:none;">
						   	(<font color="red">Note: </font> <span id="status-approved-message"></span> )  
						   		<span class="gif" id="image-gif" style="float: right; margin: -3px 0px 0px 7px;"> </span>
						   	</i>
						   	</div>
						   	<?php }?>
						   <?php echo $this->Form->hidden('approval',array('id'=>'is_approved','value'=>'0'));
					   		 echo $this->Form->hidden('approval_for_refund',array('id'=>'is_refund_approved','value'=>'0')); ?>
			</td>
			<td valign="top" align="right" style="padding-top: 15px;">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
<?php echo $this->Form->end(); ?>

<script><!--

/*$('#payafterDischarge').click(function(){
	var validatePerson = jQuery("#saveFinalBill").validationEngine('validate'); 
 	if(!validatePerson){
	 	return false;
	}
});*/

	 
 var totalCost="<?php echo ceil($totalCost);?>";
 var totalAdvancePaid="<?php echo $totalAdvancePaid;?>";
 var totalPendingAmount="<?php echo ($totalCost-$totalAdvancePaid);?>";
 var advancedPaid = parseInt("<?php echo $totalPaid;?>");
 var totalCharge = parseInt("<?php echo $totalCharge; ?>");
 var totalBal = parseInt("<?php echo $totalBal; ?>");	//holds total balance
 var amount = $("#totalamount").val();
 var discount_type = "<?php echo $discountAmount; ?>";
 var $is_not_approved = "<?php echo $is_not_approved; ?>";

 $(document).ready(function(){
	 discountApproval(); //check is discount on load page
	 RefundApproval();	//check is refund on load page
	 
	if($is_not_approved == "Discount")
	{
		$("#is_approved").val(1); 			//to restrict the save button because the approval is not completed yet
	}
	else if($is_not_approved == "Refund")
	{
		$("#is_refund_approved").val(1); 	//to restrict the save button because the approval is not completed yet
	}
	
	var type = ''; 
	ref = false;	
	con = false;
	
	$('input:radio').each(function () { 
        if ($(this).prop('checked')) {
            type = this.value;
        } 
	});

	var discounyGiven='<?php echo $discountVal;?>';
	var pendingBalance=($('#totalamountpending').val())-discounyGiven;	//balance - discount
	//$('#totalamountpending').val(pendingBalance); commented becoz deduction of discount is done above.

	pendingAmt = $("#totalamountpending").val(); //balance
	
	if($("#discount").val() !=''){
		//$("#totalamountpending").val(pendingAmt);
		$('#discount').removeAttr("disabled");


		$('#discount_authorize_by').show();
		$('#discount_reason').show();
		$('#send-approval').show();
		//$("#discount_authorize_by_for_refund").hide();

		//$('input:radio').removeAttr('checked');		                  
		//$("#discount").val('');						// unset discount value
		$("#discount").attr('disabled');				// set disabled
		//$("#totalamountpending").val(pendingAmt);		// unset the balance
		$("#discount_authorize_by").hide();	
		$('#discount_reason').hide();
		$("#send-approval").hide();			
		
	}
	else
	{
		$('#discount_authorize_by').hide();
		$('#discount_reason').hide();
		$('#send-approval').hide();
		//$("#discount_authorize_by_for_refund").hide();
	}


	//$("#discount").val('');
	$("#discount").keyup(function(){
		if($(this).val()>=1){
			$('#discount_authorize_by').show();
			$('#discount_reason').show();
			$('#send-approval').show();
			$('#is_approved').val(1);	
		}else{
			$('#discount_authorize_by').hide();
			$('#discount_reason').hide();
			$('#send-approval').hide();
			$('#is_approved').val(0);
		}
		display();
	    /*$('input:radio').each(function () { 
	        if ($(this).prop('checked')) {
	            var type = this.value;
	            if(type == "Amount"){ 
		            CalculatebyAmount();
	            }else if(type == "Percentage"){
		            if($("#discount").val() < 101){			            
		            	CalculateByPercentage();	//enter percentage should be less than or equal to 100 
			        }else{
			            alert("Percentage should be less than or equal to 100");
		            }
	            }
	        } 
	    });*/
	   
	});
	
		$(".discountType").change(function(){
		$("#discount").show();
		$("#discount").prop("disabled", false);
		var type = $(this).val();
		var finalRefund = "<?php echo $totalHeadRefund[0]['sumRefund']; ?>";
			finalRefund = finalRefund!='' ?finalRefund : 0;
		var TotalAdvPaid = advancedPaid - parseInt(finalRefund);
		//alert(TotalAdvPaid);
		if(TotalAdvPaid > totalCharge) {
		     alert("could not be able to add discount");
		     $("#discount").hide();
		     $(".discountType").attr('checked',false)
	    }else{
			if(type == "Percentage"){
				$("#show_percentage").show();
				$("#discount").val(0);	
				$("#totalamountpending").val(totalBal);			//to display the discount from database
			}else{
				$("#show_percentage").hide();
				$("#discount").val(discounyGiven);
			}
			//alert(pendingAmt);
			//$("#totalamountpending").val(pendingAmt);		
			
		}
	 });


	 function CalculateDiscount(type) 
	 {
		var TotAmount = $("#totalamount").val();
		var discountEntered = $("#discount_percent").val();
		discountAmount = Math.ceil((totalCost*discountEntered)/100);
		amountRemaining=totalCost-discountAmount;//alert(totalCost+'-'+discountAmount+'-'+amountRemaining+'-'+totalAdvancePaid);
		pAmt = amountRemaining-totalAdvancePaid;
		$("#totalamountpending").val(pAmt.toFixed(2));
		$("#discount_rupees").val(discountAmount);
 	}

	//checking for paymetn mode option and there respetuve fields to display on page load 
	
	 if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
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
	$('#onlyCredit').click(function(){
		if($(this).is(':checked')){ 
			$('#ConsultantBilling').validationEngine('hide');
			$('#mode_of_payment').removeClass('validate[required,custom[mandatory-select]]');
		}else{ 
			$('#mode_of_payment').addClass('validate[required,custom[mandatory-select]]');
		}
	});

	$('#ConsultantBilling').submit(function(){
		
		if($('#discount_by_credit').val() != '' && $('#reason_for_credit_voucher').val()==''){ 
			$('#reason_for_credit_voucher').addClass('validate[required,custom[mandatory-enter-only]]');   
		}else{
			$('#reason_for_credit_voucher').removeClass('validate[required,custom[mandatory-enter-only]]'); 
		}
	});

	$('#discount_by_credit').blur(function(){
		if($('#discount_by_credit').val()==''){
			$('#reason_for_credit_voucher').removeClass('validate[required,custom[mandatory-enter-only]]');
			$('#reason_for_credit_voucher').validationEngine('hide'); 
		}else{
			$('#reason_for_credit_voucher').removeClass('validate[required,custom[mandatory-enter-only]]');
		}
	});
	 //alert($('#mode_of_discharge').val());
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
	 
	 jQuery("#ConsultantBilling").validationEngine();
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
			minDate:new Date(<?php echo $this->General->minDate($wardInDate) ?>),
			onSelect:function(){$(this).focus();}
		});
		
	 $("#mode_of_payment").change(function(){
		 $('#chequeCredit').html($(this).val()+' No.');
			//alert('here');
			if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
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
			//alert('here');
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
	 
	 $("#reCalculate").click(function(){
		 calculateDiscount();
	});
	
	$("#refresh-discount").click(function(){
		 $("#totalamount").val(totalCost);
		 $("#totalamountpending").val(totalPendingAmount);
		 $("#totaladvancepaid").val(totalAdvancePaid);
		 $("#discount_percent").val('');
		 $("#discount_rupees").val('');
		 
	 });
	 $("#discount_rupees").keyup(function(){
		 resetDiscount();
		/* var dCount = $("#discount_rupees").val();
		 var pAmount = $("#totalamountpending").val();
		 var dCountRs=pAmount-dCount;
		 $("#totalamountpending").val(dCountRs+'.00');*/
		 calculatePercentage();
	});

	$("#BN_paymentInfo").on('keyup change blur',function(){
		
		$("#BN_neftArea").val($(this).val());
		 
	});
	$("#AN_paymentInfo").on('keyup change blur',function(){
		$("#AN_neftArea").val($(this).val());
	});
	 
 });

	function CalculatebyAmount()
	{
		 var discount_value = $("#discount").val();
      //var bal = pendingAmt - discount_value;
      var bal = totalBal - discount_value;		//calculate balance from subtracting eneterd discount from main balance
      $("#totalamountpending").val(bal);
	}

	function CalculateByPercentage()
	{
		 var discount_value = $("#discount").val();
		 discountAmount = Math.ceil((amount*discount_value)/100);
		 $("#disPerAmount").val(discountAmount);
		 //bal = pendingAmt - discountAmount;
		 bal = totalBal - discountAmount;
		 $("#totalamountpending").val(bal);
	}
	
  function calculateDiscount(){
		var discountEntered = $("#discount_percent").val();
		discountAmount = Math.ceil((totalCost*discountEntered)/100);
		amountRemaining=totalCost-discountAmount;//alert(totalCost+'-'+discountAmount+'-'+amountRemaining+'-'+totalAdvancePaid);
		pAmt = amountRemaining-totalAdvancePaid;
		$("#totalamountpending").val(pAmt.toFixed(2));
		$("#discount_rupees").val(discountAmount);
  }

  function calculatePercentage(){
		var discountEntered = $("#discount_rupees").val();
		discountAmount = Math.floor((100*discountEntered)/totalCost);
		amountRemaining=totalCost-discountEntered;//alert(totalCost+'-'+discountAmount+'-'+amountRemaining+'-'+totalAdvancePaid);
		pAmt = amountRemaining-totalAdvancePaid;
		$("#totalamountpending").val(pAmt.toFixed(2));
		$("#discount_percent").val(discountAmount);
 }

  function resetDiscount(){
  	
	 $("#totalamountpending").val(totalPendingAmount); 
	 $("#discount_percent").val('');
  }
  
  $("#amount").keyup(function(){
	 /*	total_amount=$('#totalamount').val();
	 	amount_paid=$(this).val();
		balance=total_amount - amount_paid;	 
		$('#totalamountpending').val(balance);*/

		//var disc = $("#discount").val();
		display();
		/*var disc = '';
		$('input:radio').each(function () { 
	        if ($(this).prop('checked')) {
	            var type = this.value;
	            if(type == "Amount")
	            {    
	            	disc = parseInt($("#discount").val());
	            }else if(type == "Percentage")
	            {
	            	var discount_value = $("#discount").val();
	       		    disc = parseInt(Math.ceil((amount*discount_value)/100));
	       		    discount='Full';
	            }
	        } 
		});
		
		total_amount=parseInt($('#totalamount').val()); 
		//alert(total_amount);
	 	total_advance=parseInt($('#totaladvancepaid').val()); 
	 	//alert(total_advance);
	 	amount_paid=parseInt($(this).val());
	 	//alert(amount_paid);
	 	
	 	amount_paid=total_advance + amount_paid; 
		balance = parseInt(total_amount - amount_paid) - disc;	 
		if(isNaN(balance)==false){
			$('#totalamountpending').val(balance);
		}else if($(this).val()==''){
			if(discount=='Full'){
				$('#totalamountpending').val('0');
			}else{
				$('#totalamountpending').val('<?php echo $totalBal;?>');
			}
		}else{
			$('#totalamountpending').val('');
			} */
		
		/*if(isNaN(balance)==false){
			$('#totalamountpending').val(balance);
		}else if($(this).val()==''){
			tempTotal=total_amount - amount_paid;alert(tempTotal);
			$('#totalamountpending').val(tempTotal);
		}else{
			$('#totalamountpending').val('');
			}*/
		
	 });
 

	  $('#payafterDischarge').click(function(){

		 var amoutPending = $('#totalamountpending').val(); 
		  var dischargeStatus = (amoutPending == 0) ? '2' : '1'; 
		  $('#dischargeStatus').val(dischargeStatus); 

		  if($("#is_refund").is(":checked")){
			  if($("#amount").val()=='' && $("#discount").val()=='' && $("#refund_amount").val()==''){
				  alert('Please pay some amount.');
				  return false;
			  }
		  }else{
			  if($("#amount").val()=='' && $("#discount").val()==''){
				  alert('Please pay some amount.');
				  return false;
			  }
		  }
		  
		  var validatePerson = jQuery("#saveFinalBill").validationEngine('validate'); 
		  if($("#amount").val()!= ''){
			  $("#mode_of_payment").addClass("validate[required,custom[mandatory-select]]");
			  //return false;
		  }/*else{
			  $("#mode_of_payment").removeClass("validate[required,custom[mandatory-select]]");
		  }*/

		if(!validatePerson){
		 	return false;
		}else if($("#is_approved").val() == 1 || $("#is_refund_approved").val() == 1){
		 	alert("Cannot be Finalize Invoice, waiting for discount approval");
		 	return false;
	 	}else{
	 		$('#payafterDischarge').hide();		//hide the button whenever submit the form
	 	}

		  singleBillPay='yes';
		 	formData = $('#saveFinalBill').serialize();
	  			$.ajax({
	  				  type : "POST",
	  				  data: formData,
	  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "saveFinalBill","?"=>array('IsDischarge'=>'yes'),"admin" => false)); ?>"+'&singleBillPay='+singleBillPay,
	  				  context: document.body,
	  				  success: function(data){ 
	  					$("#busy-indicator").hide();
	  					parent.getbillreceipt('<?php echo $patientID;?>');
	  					parent.jQuery.fancybox.close();
	  				  },
	  				  beforeSend:function(){$("#busy-indicator").show();},		  
	  			});
	  });

	  $('#submitBill').click(function(){
		var amoutPending = $('#totalamountpending').val();
		var dischargeStatus = (amoutPending == 0) ? '2' : '1'; // discharged == full payment , discharge == partial payment
		  $('#dischargeStatus').val(dischargeStatus);
		  	
		  if($("#amount").val()!= '')
		  {
			  $("#mode_of_payment").addClass("validate[required,custom[mandatory-select]] ");
		  }
		  var validatePerson = jQuery("#saveFinalBill").validationEngine('validate'); 
		 	if(!validatePerson){
			 	return false;
			}
		 	else
		 	if($("#is_approved").val() == 1 || $("#is_refund_approved").val() == 1 /*|| $("#balance_approved").val() == 1*/)
		 	{
			 	alert("Cannot be Finalize Invoice, waiting for approval");
			 	return false;
		 	}
		 	else{
		 		$('#submitBill').hide();		//hide the button whenever submit the form
		 	}	
	  });

	  $('#reason_of_balance').change(function(){
		  /*if($(this).val() != ''){
			$("#balance_authorize_by").show();
			$("#send_approval_for_balance").show();
			$("#balance_approved").val(1);
		  }else{
			  $("#balance_authorize_by").hide();
			  $("#send_approval_for_balance").hide();
			  $("#balance_approved").val(0);
		  }*/
				  
		  if($(this).val()=='Credit Period'){
			  $('#mandatoryGuarantor').show();
			  $('#guarantor').addClass('validate[required,custom[mandatory-select]]');
		  }else{
			  $('#mandatoryGuarantor').hide();
			  $('#guarantor').removeClass('validate[required,custom[mandatory-select]]');
		  }
	  });



	  var interval = null;
	  var refund_interval = null;
	  
	  $("#send-approval").click(function(){
		  //alert($("#discount").val());
		
			if($("#discount").val() == '')
			{
				alert('Please Enter Discount');
				return false;
			}
			else if($("#discount_authorize_by").val() == 'empty')
		    {
		    	alert('Please select the user for approval');
				return false;
		    }
			else if($('#discount_reason').val() == 'empty')
			{
				alert("Please select reason for discount");
			}
		    else if($("#discount_authorize_by").val() != 'empty' && $("#discount").val() != '' && $('#discount_reason').val() != 'empty')
			{
				$('input:radio').each(function () { 		//check the radio whether Amount or Percentage
			        if ($(this).prop('checked')) {
						type = this.value;				
			        }
			    });
			    patientId = '<?php echo $patientID; ?>';
				discount = $("#discount").val();			//discount may be amount or percentage
				totalamount = $("#totalamount").val();
				user = $("#discount_authorize_by").val();	//authhorized user whom we are sending approval
				payment_category = "Finalbill";
				reasonForDiscount = $('#discount_reason').val();
			   
				$.ajax({
					  type : "POST",
					  data: "patient_id="+patientId+"&type="+type+"&discount="+discount+"&total_amount="+totalamount+"&request_to="+user+"&payment_category="+payment_category+"&reason="+reasonForDiscount,
					  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "requestForApproval","admin" => false)); ?>",
					  context: document.body,
					  beforeSend:function(){
						  $("#busy-indicator").show();
					  },	
					  success: function(data){ 
						 $("#busy-indicator").hide(); 
						 $("#mesage").show();
						 if(data == 1)
						{
							$("#status-approved-message").html("Request for discount has been sent, please wait for approval");
							$("#is_approved").val(1);	//for approval waiting
							 $("#image-gif").show();
							 $("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
							 $("#send-approval").hide();	//hide send approval button 
							 $("#cancel-approval").show();	//show reset button
							interval = setInterval("Notifications()", 5000);  // this will call Notifications() function in each 5000ms
						}
					} //end of success
				}); //end of ajax
		}
	});

    function Notifications()
    {
    	$('input:radio').each(function () { 
	        if ($(this).prop('checked')) {
	            var type = this.value;
	        }
	     });
    	 patientId = '<?php echo $patientID; ?>';
    	user = $("#discount_authorize_by").val();
    	payment_category = "Finalbill";
    	
        $.ajax({
        	type : "POST",
			  data: "patient_id="+patientId+"&type="+type+"&request_to="+user+"&payment_category="+payment_category,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "Resultofrequest","admin" => false)); ?>",
			  context: document.body,	
			  success: function(data){ 
				 //$("#busy-indicator").hide(); 
				 $("#mesage").show();
				if(data == '' || data == 0)
				{
					$("#status-approved-message").html("Request for discount has been sent, please wait for approval");
					$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>');
					$("#is_approved").val(1);
				}else
				if(data == 1)		//approved
				{
					$("#status-approved-message").html('<font color="green">Request for discount has been completed</font>');
					$("#image-gif").hide();
					$("#is_approved").val(2);  //for approval complete
					clearInterval(interval); // stop the interval
					$("#discount_authorize_by").hide();		//hide Approval users
					$('#discount_reason').hide();
					$("#cancel-approval").hide();			//hide cancel button
				}
				else
				if(data == 2)		// if rejected by users
				{
					$("#status-approved-message").html('<font color="red">Request for discount has been rejected</font>');
					$("#image-gif").hide();
					$("#is_approved").val(3);	// for approval reject

					clearInterval(interval); 	// stop the interval

					$("#is_approved").val(0);  	// for again sending approval
					$('input:radio').removeAttr('checked');		                  
					$("#discount").val('');		// unset discount value
					$("#discount").attr('disabled');	// set disabled
					$("#discount_authorize_by").hide();	
					$('#discount_reason').hide();
					$("#send-approval").hide();			
					$("#cancel-approval").hide();
					
					$("#totalamountpending").val(pendingAmt);	// unset the balance
						
				}
			} //end of success
		});
            
    }

    
    $("#is_refund").click(function(){
        balnc = parseInt($("#totalamountpending").val());
       /* if(balnc == '' || balnc == 0)
        {
            alert("Couldnot be refund, because there is no balance for refund");
            return false;
        }*/
	    if($('#is_refund').is(':checked')){
	       if(advancedPaid > totalCharge)
	        {
		        if(is_refund != '' || is_refund != 0){
			         //$("#refund_amount").val(refundedAmount);
		        }else{
		        	$("#refund_amount").val(Math.abs($("#totalamountpending").val()));	//refund total - advance Paid
		        }
		        //$("#discount_authorize_by").hide();
		        //$("#send-approval").hide();
		        //$("#cancel-approval").hide(); 
		       
	        }/*else{
		        alert("Could not refund");
		        $("#refund_amount").hide();
		        $("#discount_authorize_by_for_refund").hide();
		        $("#send-approval-for-refund").hide();
		        $('#is_refund').attr('checked', false);
	        } */
	        $("#refund_amount").show();
	        $("#discount_authorize_by_for_refund").show();
	        $("#send-approval-for-refund").show();

		}else{
	    	$("#refund_amount").hide();
	    	$("#send-approval-for-refund").hide();
	    	$("#discount_authorize_by_for_refund").val('');
	    	$("#discount_authorize_by_for_refund").hide();
	        //$("#discount_authorize_by").show();
	        //$("#send-approval").show();
	    	
	    }
	});
	var balanCe = parseInt($("#totalamountpending").val());	//hold the balance
	$("#refund_amount").keyup(function(){
		refund = ($(this).val()!='')?$(this).val() : 0;
		headwiseRefund1='<?php echo $totalHeadRefund[0]['sumRefund'];?>';
		headwiseRefund=(headwiseRefund1!='')?headwiseRefund1:0;

		headwiseDiscount1='<?php echo $totalHeadDiscount[0]['sumDiscount'];?>';
		headwiseDiscount=(headwiseDiscount1!='')?headwiseDiscount1:0;
		
		var adV = parseInt(($("#totaladvancepaid").val()!='')?$("#totaladvancepaid").val():0);

		var discount = parseInt(($("#discount").val()!='')?$("#discount").val():0);

		var amountPaid = parseInt(($("#amount").val()!='')?$("#amount").val():0);
		
		var total = parseInt($("#totalamount").val()) - adV-headwiseDiscount-discount-amountPaid + parseInt(refund)+parseInt(headwiseRefund);
		//alert(total);
		$("#totalamountpending").val(total);

		//for changing remark for received and refunded amount  
		if(refund!='' && refund!=0){
			$(".paymentRemarkReceived").hide();
			$(".paymentRemarkRefund").show();
			$("#receivedRemark").prop("disabled",true);
			$("#refundRemark").prop("disabled",false);
			
		}else{
			$(".paymentRemarkReceived").show();
			$(".paymentRemarkRefund").hide();
			$("#refundRemark").prop("disabled",true);
			$("#receivedRemark").prop("disabled",false);
		}
	});
    
$("#send-approval-for-refund").click(function(){
	refund_amount = $("#refund_amount").val();
	
		if(refund_amount != '' && refund_amount != 0){
			if($("#is_refund_approved").val() != '0'){
				alert("You have already sent an request");
				return false;
			}
			else 
			if($("#discount_authorize_by_for_refund").val() == 'empty')
		    {
		    	alert('Please select the user for approval');
				return false;
		    }
			else
		    if($("#discount_authorize_by_for_refund").val() != 'empty' && $("#refund_amount").val() != '')
			{
				var user = $("#discount_authorize_by_for_refund").val();
				var patientId = '<?php echo $patientID; ?>';
				refundAmount = $("#refund_amount").val();
				payment_category = "Finalbill";
				$.ajax({
					  type : "POST",
					  data: "patient_id="+patientId+"&type=Refund&refund_amount="+refundAmount+"&total_amount="+advancedPaid+"&request_to="+user+"&payment_category="+payment_category,
					  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "requestForApproval","admin" => false)); ?>",
					  context: document.body,
					  beforeSend:function(){
						  $("#busy-indicator").show();
					  },	
					  success: function(data){ 
						 $("#busy-indicator").hide(); 
						 $("#mesage").show();
						 if(data == 1)
						{
							$("#status-approved-message").html("Request for Refund has been sent, please wait for approval");
							$("#is_refund_approved").val(1);	//for approval waiting
							 $("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
							 refund_interval = setInterval("NotificationsForRefund()", 5000);  // this will call Notifications() function in each 5000ms
							$("#send-approval-for-refund").hide();
							$("#cancel-refund-approval").show();
						}
					} //end of success
				}); //end of ajax
			}		
		}
		else
		{
			alert("Please Enter the refund amount, before send request");
			return false;
		}
    });

	function NotificationsForRefund()
    {
    	user = $("#discount_authorize_by_for_refund").val();
    	 patientId = '<?php echo $patientID; ?>';
    	 payment_category = "Finalbill";
    	 
        $.ajax({
        	type : "POST",
        	data: "patient_id="+patientId+"&type=Refund"+"&request_to="+user+"&payment_category="+payment_category,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "Resultofrequest","admin" => false)); ?>",
			  context: document.body,
			  beforeSend:function(){
				  //$("#busy-indicator").show();
			  },	
			  success: function(data){ 
				 //$("#busy-indicator").hide(); 
				 $("#mesage").show();
				if(parseInt(data) == 0)
				{
					$("#status-approved-message").html("Request for Refund has been sent, please wait for approval");
					$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>');
					$("#is_refund_approved").val(1);
				}else
				if(parseInt(data) == 1)		//approved
				{
					$("#status-approved-message").html('<font color="green">Request for Refund has been completed</font>');
					$("#image-gif").hide();
					$("#is_refund_approved").val(2);  //for approval complete
					clearInterval(refund_interval); // stop the interval
					$("#cancel-refund-approval").hide();
					$("#refund_amount").show();
					
				}
				else
				if(parseInt(data) == 2)		// if rejected by users
				{
					$("#status-approved-message").html('<font color="red">Request for Refund has been rejected</font>');
					$("#image-gif").hide();
					$("#is_refund_approved").val(3);	// for approval reject
					
					clearInterval(refund_interval); 	// stop the interval

					$("#discount_authorize_by_for_refund").hide();
					$("#is_refund_approved").val('');  	// for again sending approval
					$('input:checkbox').attr('checked',false);		                  
					$("#totalamountpending").val(pendingAmt);	// unset the balance
					$("#cancel-refund-approval").hide();
					$("#refund_amount").hide();
					
				}
			} //end of success
		});
            
    }


$("#cancel-approval").click(function(){

	var discounyGiven='<?php echo $discountVal;?>';
	//var pendingBalance=($('#totalamountpending').val())-discounyGiven;
	
	patientId = '<?php echo $patientID; ?>';
	discount = $("#discount").val();
	totalamount = $("#totalamount").val();
	user = $("#discount_authorize_by").val();
	payment_category = "Finalbill";
	$('input:radio').each(function () { 
        if ($(this).prop('checked')) {
            type = this.value;
            }
        });

	$.ajax({
		  type : "POST",
		  data: "patient_id="+patientId+"&request_to="+user+"&type="+type+"&payment_category="+payment_category,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "cancelApproval","admin" => false)); ?>",
		  context: document.body,
		  beforeSend:function(){
			  $("#busy-indicator").show();
		  },	
		  success: function(data){ 
			$("#busy-indicator").hide(); 
			$("#mesage").hide();
			clearInterval(interval); 					// stop the interval
			$("#is_approved").val(0);  					// for again sending approval
			//$('input:radio').removeAttr('checked');		                  
			$("#discount").val(discounyGiven);			// unset discount value

			$('input:radio').each(function () { 
		        if ($(this).prop('checked')) {
		            var type = this.value;
		            if(type == "Amount")
		            { 
			            CalculatebyAmount();
		            }else if(type == "Percentage")
		            {
			            CalculateByPercentage();
		            }
		        } 
		    });
			$("#discount").attr('disabled');			// set disabled
			//$("#totalamountpending").val(pendingAmt);	// unset the balance
			$("#discount_authorize_by").hide();	
			$('#discount_reason').hide();
			$("#send-approval").hide();			
			$("#cancel-approval").hide();
			$("#cancel-refund-approval").hide();
			$("#discount_authorize_by_for_refund").hide();
			$("#refund_amount").hide();
			con = false;
		  }
	});
});

/*
$("#discount").focus(function(){	
	if($("#discount").val() != ''){
		if(con == false){
			var result = confirm("Would you like to change the discount amount..??");
			if(result == true){
				$("#discount_authorize_by").show();
				$('#discount_reason').show();
				$("#send-approval").show();
				con = true;
			}else{
				$("#discount_authorize_by").hide();
				$('#discount_reason').hide();
				$("#send-approval").hide();
				$("#cancel-approval").hide();
			}
		}
	}
});
*/

/*
$("#refund_amount").focus(function(){	
	if($("#refund_amount").val() != ''){
		if(ref == false){
			var result = confirm("Would you like to change the refund amount..??");
			if(result == true){
				$("#discount_authorize_by_for_refund").show();
				$("#send-approval-for-refund").show();
				ref = true;
			}else{
				$("#discount_authorize_by_for_refund").hide();
				$("#send-approval-for-refund").hide();
				$("#cancel-refund-approval").hide();
			}
		}
	}
});
*/

$("#cancel-refund-approval").click(function(){
	patientId = '<?php echo $patientID; ?>';
	totalamount = $("#totalamount").val();
	user = $("#discount_authorize_by_for_refund").val();
	payment_category = "Finalbill";
	$.ajax({
		  type : "POST",
		  data: "patient_id="+patientId+"&request_to="+user+"&type=Refund&payment_category="+payment_category,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "cancelApproval","admin" => false)); ?>",
		  context: document.body,
		  beforeSend:function(){
			  $("#busy-indicator").show();
		  },	
		  success: function(data){ 
			$("#busy-indicator").hide(); 
			$("#mesage").hide();
			clearInterval(refund_interval); 					// stop the interval
			$("#is_refund_approved").val(0);  					// for again sending approval
			$('input:checkbox').removeAttr('checked');		                  
			$("#refund_amount").val('');
			$("#refund_amount").hide();
			$("#totalamountpending").val(pendingAmt);			// unset the balance
			$("#discount_authorize_by_for_refund").hide();	
			$("#send-approval-for-refund").hide();			
			$("#cancel-refund-approval").hide();		
		  }
	});
});


function display()	//calculate final balance
{
	var disc = '';
	total_amount = ($('#totalamount').val() != '') ? parseInt($('#totalamount').val()) : 0; 
	$(".discountType").each(function () {  
        if ($(this).prop('checked')) {
           var type = this.value;
           if(type == "Amount")
            {    
            	disc = ($("#discount").val() != '') ? parseInt($("#discount").val()) : 0;
            }else if(type == "Percentage")
            {
            	var discount_value = ($("#discount").val()!= '') ? parseInt($("#discount").val()) : 0;
				if(discount_value < 101){
       		    	disc = parseInt(Math.ceil((total_amount*discount_value)/100));
				}else{
					alert("Percentage should be less than or equal to 100");
				}
            }
           $("#discount").val(disc);
        }
    });

	balance = ($('#totalamountpending').val() != '') ? parseInt($("#totalamountpending").val()) : 0;
	amount_paid = ($('#amount').val() != '') ? parseInt($("#amount").val()) : 0;
 	total_advance = ($('#totaladvancepaid').val() != '') ? parseInt($('#totaladvancepaid').val()) : 0;
 	
 	if($('#is_refund').is(':checked'))
	{
 		refund_amount = ($('#refund_amount').val() != '') ? parseInt($("#refund_amount").val()) : 0;
 	}else{
		refund_amount = 0;
 	} 	

 	headwiseDiscount='<?php echo $totalHeadDiscount[0]['sumDiscount'];?>';
	headwiseRefund='<?php echo $totalHeadRefund[0]['sumRefund'];?>';

	headwiseDiscount=parseInt((headwiseDiscount!='')?headwiseDiscount:0);
	headwiseRefund=parseInt((headwiseRefund!='')?headwiseRefund:0);
	
	bal = total_amount - total_advance - amount_paid - disc-headwiseDiscount + refund_amount+headwiseRefund;
	
	//bal=bal-parseInt(headwiseDiscount)+parseInt(headwiseRefund); comented by yashwant 
	if(isNaN(bal)==false)
		$('#totalamountpending').val(bal);	//displaying balance
	else
		$('#totalamountpending').val('');
	checkBalance();
	
}

//fnction to check discount approval
function discountApproval(){

	resetDiscountRefund();			//reset all (Discount/Refund)
	patientId = '<?php echo $patientID; ?>';
	payment_category = "Finalbill";
	clearInterval(refund_interval); 		//clear refund intervals if any
	clearInterval(interval); 		//clear discount intervals if any

	   $.ajax({
		  type : "POST",
		  data: "patient_id="+patientId+"&payment_category="+payment_category,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "checkDiscountApproval","admin" => false)); ?>",
		  context: document.body,
		  beforeSend:function(){
			 // $("#busy-indicator").show();
		  },	
		  success: function(data){
			 // $("#busy-indicator").hide(); 
			  parseData = $.parseJSON(data);
			  //console.log(parseData);
			  
		 if(parseData != null) {
			 $("#discount").show();
			  is_approved = parseInt(parseData.is_approved);
			  request_to = parseInt(parseData.request_to);
			  is_type = parseData.type;
			  $('input:radio[class=discountType][value="' + is_type + '"]').prop('checked',true); 	//checked radio Amount/Percentage
			  discount_amount = parseInt(parseData.discount_amount);								//discount_amount
			  discount_percentage = parseInt(parseData.discount_percentage);						//discount_percentage					

			  var discount = '';
			  if(discount_amount != ''){
				  discount = discount_amount;
				  $("#discType").val("Amount");
				  $("#show_percentage").hide();	
			  }else if(discount_percentage != ''){
				  discount = discount_percentage;
				  $("#discType").val("Percentage");
				  $("#show_percentage").show();	
			  }
			  //alert(discount);
			  
			if(parseInt(is_approved) == 0)
			{
				$("#mesage").show();
				$("#status-approved-message").html("apporval Request for discount has been sent, please wait for approval");
				$("#is_approved").val(1);	//for approval waiting
				$("#image-gif").show();
				$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
					  $(".discountType").prop("disabled",true);
				  $("#discount").attr('readonly',true);
				  $("#discount_authorize_by").show();		//show Approval users
				  $('#discount_reason').show();
				  $("#discount_authorize_by").val(request_to);
				  $("#discount_authorize_by").attr('disabled',true);
				  $("#cancel-approval").show();			//show cancel button to remove approval
				//set interval for clicked service group 
				interval = setInterval("Notifications()", 5000);  // this will call Notifications() function in each 5000ms
			  }
			else if(is_approved == 1)
			{	
				  $("#mesage").show();
				  $("#status-approved-message").html('<font color="green">Request for discount has been completed</font>');
				  $("#is_approved").val(2);	
				  $("#image-gif").hide();
				  //$(".discountType").prop("disabled",true);
				  $("#discount").attr('readonly',true);					  
			  }
			else if(is_approved == 2)
			{
				resetDiscountRefund();
				$("#mesage").show();
				$("#status-approved-message").html('<font color="red">Request for discount has been rejected</font>');
				$("#image-gif").hide();
				$("#is_approved").val(3);	// for approval reject
		 	} 		
		 	
			$("#discount").val(discount);
			display();	//calculate balance			  
		  }
		} 	//end of success
		}); 	//end of ajax
	}

function RefundApproval(){
	resetRefund();			//reset all Refund)
	patientId = '<?php echo $patientID; ?>';
	payment_category = $("#payment_category").val();
	clearInterval(refund_interval); 		//clear refund intervals if any
	clearInterval(interval); 		//clear discount intervals if any

	$.ajax({
		  type : "POST",
		  data: "patient_id="+patientId+"&payment_category="+payment_category,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "checkRefundApproval","admin" => false)); ?>",
		  context: document.body,
		  beforeSend:function(){
			  //$("#busy-indicator").show();
		  },	
		  success: function(data){
			  //$("#busy-indicator").hide(); 
			  parseData = $.parseJSON(data);
			  //console.log(parseData);
			  
		 if(parseData != null) {
			  is_approved = parseInt(parseData.is_approved);
			  refund_amount = parseInt(parseData.refund_amount);
			  request_to = parseInt(parseData.request_to);
			  $('input:checkbox[id=is_refund]').prop('checked',true); 	//to checked refund checkbox
			  $("#refund_amount").show();
			  $("#refund_amount").val(refund_amount);
			  $("#discount_authorize_by_for_refund").show();
			  
			if(parseInt(is_approved) == 0)
			{
				$("#mesage2").show();
				$("#status-approved-message-for-refund").html("apporval Request for Refund has been sent, please wait for approval");
				$("#is_refund_approved").val(1);	//for approval waiting
				$("#image-gif2").show();
				$("#image-gif2").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
				$("#refund_amount").attr('readonly',true);
				$("#is_refund").attr('disabled',true);
				$("#discount_authorize_by_for_refund").show();
				$("#discount_authorize_by_for_refund").val(request_to);
		        $("#discount_authorize_by_for_refund").attr('disabled',true);
		        $("#cancel-refund-approval").show();
				//set interval for clicked service group 
				refund_interval = setInterval("NotificationsForRefund()", 5000);  // this will call Notifications() function in each 5000ms
			  }
			else if(is_approved == 1)
			{	
				  $("#mesage2").show();
				  $("#status-approved-message-for-refund").html('<font color="green">Request for Refund has been completed</font>');
				  $("#is_refund_approved").val(2);	
				  $("#image-gif2").hide();
				  $("#refund_amount").attr('readonly',true);
				  $("#is_refund").attr('disabled',true);	
				  $("#discount_authorize_by_for_refund").hide();	
				  $("#hrefund").val(1);		  
			  }
			else if(is_approved == 2)
			{
				resetRefund();
				$("#mesage2").show();
				$("#status-approved-message-for-refund").html('<font color="red">Request for Refund has been rejected</font>');
				$("#image-gif2").hide();
				$("#is_refund_approved").val(3);	// for approval reject
				$("#discount_authorize_by_for_refund").hide();	
				$("#hrefund").val(1);
		 	} 		
		 	
			//$("#discount").val(discount);
			display();	//calculate balance			  
		  }
		} 	//end of success
		}); 	//end of ajax
	}

	function resetDiscountRefund()
	{
		$("#is_approved").val(0);
		$("#disc").val(0);
		$("#discount").hide();
		$("#show_percentage").hide();
		$("#discount_authorize_by").hide();
		$('#discount_reason').hide();
		$("#discount_authorize_by").attr('disabled',false);
		$("#send-approval").hide();
		$("#cancel-approval").hide();
		$("#discount").prop("readonly", false);
		//$(".discountType").prop("disabled",false);
		$(".discountType").attr('checked',false)
		$("#mesage").hide();
	}
	
	function resetRefund()
	{
		$("#is_refund").attr('disabled',false);
		$("#disc").val(0);
		$("#is_refund").attr('checked',false);
		$("#refund_amount").attr('readonly',false);
		$("#refund_amount").val('');
		$("#refund_amount").hide();
		$("#discount_authorize_by_for_refund").attr('disabled',false);
		$("#discount_authorize_by_for_refund").hide();
		$("#send-approval-for-refund").hide();
		$("#cancel-refund-approval").hide();
		$("#mesage2").hide();
	}

	function checkBalance(){
		if($("#totalamountpending").val() > 0){
			$("#reasonForBalance").show();
		}else{
			$("#reasonForBalance").hide();
		}
	}


	//	Script for Patient Card Payment --Pooja Gupta
	$('#card_pay').click(function(){
		 var amtInCard="<?php echo $patientCard;?>";
		 var chkpay= $('#amount').val();
		 
		 if($("#card_pay").is(":checked")){
			 if(!$('#amount').val()){
			      alert('Please Pay Some Amount');
			      $("#card_pay").attr("checked",false);
				  $("#patientCard").hide();	
				  $('#patientCardDetails').hide();
				  return false;
			 }else if(amtInCard=='0' || isNaN(amtInCard)){
				 alert("Insufficient Funds in Patient Card");
				 $("#card_pay").attr("checked",false);
				 $("#patientCard").hide();
				 $('#patientCardDetails').hide();
			 }
			 else{
				 var cardPay=amtInCard;//$('#patient_card').val();
					var otherPay=0;
					if(parseInt(chkpay)<parseInt(cardPay)){
						otherPay=0;
					    $('#patient_card').val(chkpay);
					}else{
						
					   otherPay=chkpay-cardPay;
					   $('#patient_card').val(cardPay);
					}		
					 $('#otherPay').text(otherPay);				
				 $("#patientCard").show();
				 $('#patientCardDetails').show();
			 }			 
		}else{
			$("#patientCard").hide();
			 $('#patientCardDetails').hide();
		}
	});

	 $('#patient_card').change(function(){
		 var amtInCard="<?php echo $patientCard;?>";
		 var changeAmt=$(this).val();
		 var otherPay=$('#otherPay').text();
		 if(parseInt(changeAmt)>parseInt(amtInCard)){
			 alert("Insufficient Funds in Patient Card");
			 $("#card_pay").attr("checked",false);
			 $('#patient_card').val('');
			 $("#patientCard").hide();
			 $("#patientCardDetails").hide();
		 }else{
			 var chkVal=$('#amount').val();
			 if(parseInt(changeAmt)>parseInt(chkVal)){
				 alert("Amount Paid is greater");
				 $("#card_pay").attr("checked",false);
				 $('#patient_card').val('');
				 $("#patientCard").hide();
				 $("#patientCardDetails").hide();
				 return false;
			 }
			 var otherPay=chkVal-changeAmt;
			 if(parseInt(otherPay)<=0)
				 otherPay=0;	
			 $('#otherPay').text(otherPay); 
		 }
		 
	 });
</script>
