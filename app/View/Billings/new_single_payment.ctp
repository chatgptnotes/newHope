<?php 
//echo $this->element('billing_header');
//echo $this->General->minDate($wardInDate)  ;exit;
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Finalization of Invoice', true); ?>
	</h3>
	<span></span>
</div>
<div class="patient_info">
	<?php // echo $this->element('patient_information');?>
</div>

<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveFinalBill/'.$patient['Patient']['id'],'id'=>'ConsultantBilling','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('Billing.patient_id',array('value'=>$patient['Patient']['id']));?>
<table width="100%">
	<tr>
		<td></td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0"
	align="right"
	style="border-bottom: 1px solid rgb(62, 71, 74); padding-bottom: 10px;">
	<tbody>
		<tr class="rowEven">
			<td width="130" class="tdLabel2"><?php echo __('Date Of Registration');?>:&nbsp;</td>
			<td width="80" class="tdLabel2"><?php 
			$admissionDate = explode(" ",$patient['Patient']['form_received_on']);
			echo  $admissionDate  = $this->DateFormat->formatDate2Local($admissionDate[0],Configure::read('date_format'));
			?>
			</td>
			<td width="50">&nbsp;</td>

			<?php if($patient['Patient']['is_discharge']==1){ ?>
			<td width="100" class="tdLabel2"><?php echo __("Discharge Date");?>:&nbsp;</td>
			<td width="80" class="tdLabel2"><?php	echo $todayDate = $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format')); ?>
			</td>
			<td width="50">&nbsp;</td>
			<td width="70" class="tdLabel2"><?php 
			$daysDiff =  $this->DateFormat->dateDiff($patient['Patient']['discharge_date'],$patient['Patient']['form_received_on']);
			$days = $daysDiff->d ;
			echo ($daysDiff->d > 1)?__('Total Days' ):__('Total Day');?>:&nbsp;</td>
			<td width="25"><?php 
			echo $days+1 ; //anything greater than 1 day + hours
			?>
			</td>
			<?php }else{ ?>
			<td width="85" class="tdLabel2"><?php 

			echo __("Today's Date");?>:&nbsp;</td>
			<td width="80" class="tdLabel2"><?php	echo $todayDate = $this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format')); ?>
			</td>
			<td width="50">&nbsp;</td>
			<td width="70" class="tdLabel2"><?php $daysDiff =  $this->DateFormat->dateDiff(date('Y-m-d H:i:s'),$patient['Patient']['form_received_on']);
			echo ($daysDiff->d > 1)?__('Total Days' ):__('Total Day');?>:&nbsp;</td>
			<td width="25"><?php 

			$daysDiff =  $this->DateFormat->dateDiff(date('Y-m-d H:i:s'),$patient['Patient']['form_received_on']);
			echo (int)$daysDiff->d + 1 ; //anything greater than 1 day + hours
	       
			?></td>
			<?php  } ?>
			<td width="50">&nbsp;</td>
			<td width="">&nbsp;</td>
			<!-- <td width="100" class="tdLabel"><strong><?php echo __('Total Amount' );?></strong></td>
                            <td width="80"><input type="text" style="font-size: 14px; font-weight: bold;" value="<?php echo $totalBill;//ceil($totalCost);?>" tabindex="16" id="textfield" class="textBoxExpnd" name="textfield"></td>
                             -->
		</tr>
	</tbody>
</table>

<?php $totalAmountPending = $totalBill-$totalAdvancePaid-totalDiscount; //toal cost replaced by totalBill amount-- Pooja?>
<table width="100%" cellspacing="0" cellpadding="0" border="0"
	align="center">
	<tbody>
		<tr >
			<td width="47%" valign="top" colspan="3">
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class=""
					align="center">
					<tbody>

						<tr class="rowOdd">
							<td width="120" height="35" class="tdLabel2"><strong><?php echo __('Total Amount' );?></strong>
							</td>
							<td width="100"><?php 


							//$totalCost=	$newCost;
							if($patient['Patient']['is_discharge']==1){
			               	echo $this->Form->input('Billing.total_amount',array('value' => $this->Number->format(ceil($totalBill),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'ftotalamount','style'=>'text-align:right;','readonly'=>'readonly'));
			               }else{
			               	echo $this->Form->input('Billing.total_amount',array('value' => $this->Number->format(ceil($totalBill),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'ftotalamount','style'=>'text-align:right;','readonly'=>'readonly'));
			               }
			               ?>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr class="rowEven">
							<td height="35" class="tdLabel2"><strong>Amount Paid</strong></td>
							<td><?php 
							 if($patient['Patient']['is_discharge']==1){
						     	echo $this->Form->input('Billing.amount_paid',array('value' => $this->Number->format(ceil($totalAdvancePaid),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'ftotaladvancepaid','style'=>'text-align:right;','readonly'=>'readonly'));
						     }else{
						     	echo $this->Form->input('Billing.amount_paid',array('value' => $this->Number->format(ceil($totalAdvancePaid),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'ftotaladvancepaid','style'=>'text-align:right;','readonly'=>'readonly'));
						     }
						     ?>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr class="rowOdd">
							<td height="35" class="tdLabel2"><strong>Discount Given</strong></td>
							<td colspan ="2"><?php 
							 if($patient['Patient']['is_discharge']==1){
						     	echo $this->Form->input('Billing.discount_given',array('value' => $this->Number->format(ceil($totalDiscount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'ftotaldiscount','style'=>'text-align:right;','readonly'=>'readonly'));
						     }else{
						     	echo $this->Form->input('Billing.discount_given',array('value' => $this->Number->format(ceil($totalDiscount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'ftotaldiscount','style'=>'text-align:right;','readonly'=>'readonly'));
						     ?>
						     <?php 
						     $sevicesAvailable = explode(',',$couponDetails['Coupon']['sevices_available']);
						     	
						     if(!empty($patient['Patient']['coupon_name']) && $patient['Patient']['admission_type'] == 'IPD' && in_array($roomTarifId,$sevicesAvailable) && in_array($ManditoryGroupId,$sevicesAvailable)){?>
						     <span> <?php echo "Manditory charges-". $manditoryAndRoomdiscountChargess[0].",  Room Tariff Charges -".$manditoryAndRoomdiscountChargess[1];?>  </span>
                              <?php } 
								}
						     ?>
							</td>
						</tr>
						<tr class="rowEven">
							<td height="35" class="tdLabel2"><strong>Amount Pending</strong>
							</td>
							<td><?php 
							if(isset($finalBillingData['FinalBilling']['discount_rupees']) && $finalBillingData['FinalBilling']['discount_rupees']!=''){
						   		$dAmount = $finalBillingData['FinalBilling']['discount_rupees'];
						    }else{
						   		$dAmount=$totalDiscount;
						    }

						   if($patient['Patient']['is_discharge']==1){
						   	echo $this->Form->input('Billing.amount_pending',array('value' => $this->Number->format(ceil($totalAmountPending-$dAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'ftotalamountpending','style'=>'text-align:right;','readonly'=>'readonly'));
						   }else{
						   	echo $this->Form->input('Billing.amount_pending',array('value' => $this->Number->format(ceil($totalAmountPending-$dAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'ftotalamountpending','style'=>'text-align:right;','readonly'=>'readonly'));
						   }
						
						   ?></td>
							<td>&nbsp;</td>
						</tr>
						<?php if(($totalAmountPending >0 && $patient['Patient']['is_discharge']==1) || $patient['Patient']['is_discharge']!=1){?>
						<tr class="rowOdd">
							<td height="35"><strong>Amount</strong></td>
							<td><?php echo $this->Form->input('Billing.amount',array('type'=>'text','value'=>'','legend'=>false,'label'=>false,'id' => 'famount','class'=>'validate[optional,custom[onlyNumber]','style'=>'text-align:right;','autocomplete'=>'off'));?>
							</td>
							<td></td>
						</tr>
						<tr class="rowEven">
							<td height="35" class="tdLabel2"><strong>Mode Of Payment<font
									color="red">*</font>
							</strong></td>
							<td><?php 
							$options=array('Bank Deposit'=>'Bank Deposit','Cash'=>'Cash','Cheque'=>'Cheque',/* 'Debit Card'=>'Debit Card','Credit Card'=>'Credit Card', */'Credit'=>'Credit'/* ,'NEFT'=>'NEFT' */);
							echo $this->Form->input('Billing.mode_of_payment', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;',
   								'div' => false,'label' => false,'empty'=>__('Please select'),'autocomplete'=>'off',
   								'options'=>$options,'id' => 'fmode_of_payment')); ?>
							</td>
						</tr>
						<tr class="rowEven" id="fcreditDaysInfo" style="display: none">
							<td height="35" class="tdLabel2">Credit Period<font color="red">*</font><br />
								(in days)
							</td>
							<td><?php echo $this->Form->input('Billing.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'fcredit_period','class'=> 'validate[required,custom[mandatory-enter-only]]','autocomplete'=>'off'));?>
							</td>
						</tr>
						<tr id="fpaymentInfo" style="display: none" class="rowEven">
							<td height="35" colspan="3" class="tdLabel2">
								<table width="100%">
									<tr>
								    <td>Bank Name<font color="red">*</font></td>
								    <td><?php echo $this->Form->input('Billing.bank_name',array('empty'=>__('Please select'),
												'options'=>$bankData,'class'=>'validate[required,custom[mandatory-select]]',
								    		'legend'=>false,'label'=>false,'id' => 'fBN_paymentInfo'));?></td>
								    <td>Account No.<font color="red">*</font></td>
								    <td><?php echo $this->Form->input('Billing.account_number',
								    		array('class'=>'validate[required,custom[mandatory-enter]]',
											'type'=>'text','legend'=>false,'label'=>false,'id' => 'fAN_paymentInfo'));?></td>
									</tr>				
									<tr>
									    <td ><span id="fchequeCredit"></span><font color="red">*</font></td>
									    <td><?php echo $this->Form->input('Billing.check_credit_card_number',
									    		array('class'=>'validate[required,custom[mandatory-enter]]',
												'type'=>'text','legend'=>false,'label'=>false,'id' => 'fcard_check_number','autocomplete'=>'off'));?></td>
								    	<td>Date<font color="red">*</font></td>
									    <td><?php echo $this->Form->input('Billing.cheque_date',
									    		array(
												'type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'fcheque_date','autocomplete'=>'off'));?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr class="rowEven" id="fneft-area" style="display: none;">
							<td height="35" colspan="3" class="tdLabel2">
								<table width="100%">
									<tr>
									    <td >Bank Name<font color="red">*</font></td>
									    <td><?php echo $this->Form->input('Billing.bank_name_neft',array('empty'=>__('Please select'),'options'=>$bankData,'class'=>'validate[required,custom[mandatory-select]]',
									    		'legend'=>false,'label'=>false,'id' => 'fBN_neftArea'));?></td>
										<td>Account No.<font color="red">*</font></td>
									    <td><?php echo $this->Form->input('Billing.account_number_neft',array('class'=>'validate[required,custom[mandatory-enter]]','autocomplete'=>'off','type'=>'text','legend'=>false,'label'=>false,'id' => 'fAN_neftArea'));?></td>
									</tr> 
								    <tr>
									    <td>NEFT No.<font color="red">*</font></td>
									    <td><?php echo $this->Form->input('Billing.neft_number',array('class'=>'validate[required,custom[mandatory-enter]]','autocomplete'=>'off','type'=>'text','legend'=>false,'label'=>false,'id' => 'fneft_number'));?></td>
										<td>NEFT Date<font color="red">*</font></td>
									    <td><?php echo $this->Form->input('Billing.neft_date',array('class'=>'validate[required,custom[mandatory-enter]]','autocomplete'=>'off','type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd','id' => 'fneft_date'));?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr class="rowEven" id="fbankDeposite" style="display: none;">
							<td height="35" colspan="3" class="tdLabel2">
							 <table width="100%">
						    	<tr>
									<td>Bank Name<font color="red">*</font></td>
									<td><?php echo $this->Form->input('Billing.bank_deposite',array('empty'=>__('Please select'),'options'=>$bankData,'legend'=>false,'label'=>false,'id' => 'fbank_deposite',
									    		'class'=> 'validate[required,custom[mandatory-select]]'));?>
									</td>
				   				</tr>
				   		    </table>
				   		  </td>
				   		  </tr>

						<?php }?>

						<?php 
						if($patient['Patient']['admission_type']=='IPD'){ ?>
						<tr class="rowOdd">
							<td height="35" class="tdLabel2"><strong>Reason Of Discharge<font
									color="red">*</font>
							</strong></td>
							<td colspan="2"><?php
							$reason =isset($finalBillingData['FinalBilling']['reason_of_discharge'])?$finalBillingData['FinalBilling']['reason_of_discharge']:'';
								
							if($patient['Patient']['is_discharge']==1){ 
								$readOnly1 = 'disabled' ;$dischargeModeClass='';
							}else{ 
								$readOnly1 = '';$dischargeModeClass='validate[required,custom[mandatory-select]]';
							};
							echo $this->Form->input('Billing.reason_of_discharge', array('value'=>$reason,'class' => ' textBoxExpnd'.$dischargeModeClass,'style'=>'width:141px; ','div' => false,'label' => false,'empty'=>__('Please select'),
   											 'options'=>array('Recovered'=>'Recovered','DischargeOnRequest'=>'Discharge On Request','DAMA'=>'DAMA','Death'=>'Death'),'id' => 'fmode_of_discharge','disabled'=>$readOnly1));
   						?></td></tr>
						<tr class="rowEven" id="fdischargeDate" style="display: none">
							<td><strong>Discharge Date:</strong><font color="red">*</font>
							</td>
							<td width="200" height="35"><?php 
							if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
						      	if($patient['Patient']['is_discharge']==1) $readOnly = 'readonly';else $readOnly = '';
						      	$last_split_date_time = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
						      	echo $this->Form->input('Billing.discharge_date',array('value'=>$this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true),'class' => 'validate[required,custom[mandatory-date]] ','type'=>'text','legend'=>false,'label'=>false,'id' => 'fdischarge_date','style'=>'width:137px;float:left;','readonly'=>$readOnly));
						      }else{
						      	echo $this->Form->input('Billing.discharge_date',array('value'=>date('d/m/Y H:i:s'),'class' => 'validate[required,custom[mandatory-date]] ','autocomplete'=>'off','readonly'=>'readonly','type'=>'text','legend'=>false,'label'=>false,'id' => 'fdischarge_date','style'=>'width:137px;float:left;','readonly'=>'readonly'));
						      }
					      ?>
							</td>
						</tr>

						<?php }else{//OPD starts
						?>
						<tr class="rowOdd">
							<td height="35" class="tdLabel2"><strong>OPD Process Done</strong><font
								color="red">*</font>
							</td>
							<td colspan="2" width="200" height="35"><?php 
						  if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
				      		if($patient['Patient']['is_discharge']==1) $readOnly = 'readonly';else $readOnly = '';
				      		$last_split_date_time = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
				      		echo $this->Form->input('Billing.discharge_date',array('value'=>$this->DateFormat->formatDate2Local($last_split_date_time[0],Configure::read('date_format')).' '.$last_split_date_time[1],'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'fdischarge_date','style'=>'width:137px;float:left;','readonly'=>$readOnly));
					      }else{
					      		echo $this->Form->input('Billing.discharge_date',array('value'=>date('d/m/Y H:i:s'),'class' => 'validate[required,custom[mandatory-date]]','autocomplete'=>'off','readonly'=>'readonly','type'=>'text','legend'=>false,'label'=>false,'id' => 'fdischarge_date','style'=>'width:137px;float:left'));
					      }	?>
							</td>
						</tr>
						<?php }?>
						<tr class="rowEven">
						<td height="30" style="vertical-align: top;" class="tdLabel2 paymentRemarkReceived">
						<strong><?php echo 'Payment Remark</strong></td><td> ';echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
	      		     'id' => 'receivedRemark','cols'=>'45','rows'=>'3','value'=>'Being cash received towards  from pt. '.$patient['0']['lookup_name'].' against R. No.:'));
	      		 ?></td></tr>
					</tbody>
				</table>
			</td>
			<!--<td width="47%" valign="top" align="right"><?php //if(($totalAmountPending >0 && $patient['Patient']['is_discharge']==1) || $patient['Patient']['is_discharge']!=1){
              /*if($patient['Patient']['is_discharge']!=1){?>
				<table width="100%" cellspacing="0" cellpadding="0" border="0"
					align="center">
					<tbody>
						<tr>
							<td width="80" height="35" class="tdLabel2">Discount</td>
							<td width="70"><?php 
							if(isset($finalBillingData['FinalBilling']['discount_percent'])){
								echo $this->Form->input('Billing.discount_percent',array('value'=>$finalBillingData['FinalBilling']['discount'],'legend'=>false,'label'=>false,'id' => 'fdiscount_percent'));
							}else{
								echo $this->Form->input('Billing.discount_percent',array('legend'=>false,'label'=>false,'id' => 'fdiscount_percent'));
							}
							?> %</td>
							<td width="50"></td>
							<td width="20"></td>
							<td width="10" class="tdLabel2"><?php echo $this->Html->image('icons/refresh-icon.png',array('alt'=>__('Refresh Discount'),'title'=>__('Refresh Discount'),'id'=>'frefresh-discount'))?>
							</td>
							<td width="10">&nbsp;</td>
						</tr>
						<tr>
							<td width="80" height="35" class="tdLabel2">&nbsp;</td>
							<td width="70">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR</td>
							<td width="50"></td>
							<td width="20"></td>
							<td width="10" class="tdLabel2">&nbsp;</td>
							<td width="10">&nbsp;</td>
						</tr>
						<tr>
							<td width="80" height="35" class="tdLabel2">&nbsp;</td>
							<td width="70"><?php 
							if(isset($finalBillingData['FinalBilling']['discount_rupees'])){
									echo $this->Form->input('Billing.discount_rupees',array('value'=>$finalBillingData['FinalBilling']['discount'],'legend'=>false,'label'=>false,'id' => 'fdiscount_rupees'));
								}else{
									echo $this->Form->input('Billing.discount_rupees',array('legend'=>false,'label'=>false,'id' => 'fdiscount_rupees'));
								}
								?>
							</td>
							<td width="50"></td>
							<td width="20"></td>
							<td width="10" class="tdLabel2">&nbsp;</td>
							<td width="10">&nbsp;</td>
						</tr>
						<tr>
							<td width="80" height="35" class="tdLabel2">Reason for Discount</td>
							<td width="70"><?php 
							echo $this->Form->textarea('Billing.reason_for_discount',array('legend'=>false,'label'=>false,'id' => 'freason_for_discount'));

							?>
							</td>
							<td width="50"></td>
							<td width="20"></td>
							<td width="10" class="tdLabel2">&nbsp;</td>
							<td width="10">&nbsp;</td>
						</tr>
					</tbody>
				</table> <?php }else{  //BOF credit voucher?>
				<table width="100%" cellspacing="0" cellpadding="0" border="0"
					align="center">
					<tbody>
						<tr>
							<td width="30%" height="35" class="tdLabel2">Credit Voucher</td>
							<td width="70%"><?php  echo $this->Form->input('Billing.discount_by_credit',array('legend'=>false,'label'=>false,'id' => 'fdiscount_by_credit','class'=>'textBoxExpnd'));  ?>
							</td>
						</tr>
						<tr>
							<td height="35" class="tdLabel2">Reason</td>
							<td><?php  echo $this->Form->textarea('Billing.reason_for_credit_voucher',array('legend'=>false,'label'=>false,'id' => 'freason_for_credit_voucher','class'=>'validate[required,custom[mandatory-enter-only]] textBoxExpnd')); 
							?>
							</td>

						</tr>
					</tbody>
				</table> <?php } *///EOF credit voucher ?>
			</td>-->
		</tr>
		<tr>
			<td valign="top" style="padding-top: 15px;" colspan="2"><?php 
			echo $this->Html->link(__('Cancel'),array('action' => 'multiplePaymentModeIpd',$patient['Patient']['id']), array('escape' => false,'class'=>'grayBtn'));
			if($patient['Patient']['is_discharge']==1){
				   			if($settlementCount==0){
								$provisionalInvoiceAction = ($this->Session->read('website.instance') == 'kanpur') ? 'provisionalInvoice'  : 'printReceipt' ;?>
							<?php 
								echo $this->Html->link('View Invoice','javascript:void(0)',
									array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>$provisionalInvoiceAction,
									$patient['Patient']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
						<?php
				   				/*echo $this->Html->link(__('View Invoice'),array('action' => 'generateReceipt',$patient['Patient']['id']),
				   			 	array('escape' => false,'class'=>'blueBtn'));*/
				   			}else{
				   				//echo $this->Html->link(__('View Invoice'),array('action' => 'generateSavedReceipt',$patient['Patient']['id']),
				   			 	//array('escape' => false,'class'=>'blueBtn'));
				   			}
				   		}
				   		if($patient['Patient']['is_discharge']!=1){
					   		$buttonlabel = ($patient['Patient']['admission_type']=='IPD')?'Save & Discharge':'Save';?>
					   		 <input class="blueBtn" type="submit" value="<?php echo $buttonlabel ?>" id="fpayAmount"> 
					   	<?php }if($patient['Patient']['is_discharge']==1 && ($totalAmountPending-$dAmount)>0){?>
								<input type="hidden" value="payOnlyAmount" name="payOnlyAmount">   <input
									class="blueBtn" type="submit" value="Pay" id="fpayOnlyAmount"> <?php 
									//echo $this->Form->input('onlyCredit',array('type'=>'checkbox','id'=>'fonlyCredit'));
									//echo "Add only credit voucher" ;
					   		}  
				if(strtolower($patient['TariffStandard']['name'])=='private'){?>
					<span><font style="color:blue;font-size:12px;">(Note:Save and discharge button is visible only on Zero balance for private patients)</font></span>
				<?php }?>	   		
			</td>

			<td valign="top" align="right" style="padding-top: 15px;">&nbsp;</td>
		</tr>
	</tbody>
</table>
<?php echo $this->Form->end(); ?>

<script>
 var totalCost="<?php echo ceil($totalBill);?>";
 var totalAdvancePaid="<?php echo $totalAdvancePaid;?>";
 var totalPendingAmount="<?php echo ($totalBill-$totalAdvancePaid-$totalDiscount);?>";
 var total_discount="<?php echo ($totalDiscount);?>";
 $(document).ready(function(){
	//$('#ftotalamount').focus();
	//checking for paymetn mode option and there respetuve fields to display on page load 
	if($("#fmode_of_payment").val() == 'Credit Card' || $("#fmode_of_payment").val() == 'Cheque'){
		 $("#fpaymentInfo").show();
		 $("#fcreditDaysInfo").hide();
		 $('#fneft-area').hide();
	} else if($("#fmode_of_payment").val() == 'Credit') {
	 	$("#fcreditDaysInfo").show();
	 	$("#fpaymentInfo").hide();
	 	$('#fneft-area').hide();
	} else if($('#fmode_of_payment').val()=='NEFT') {
	    $("#fcreditDaysInfo").hide();
		$("#fpaymentInfo").hide();
		$('#fneft-area').show();
	} 

	//EOF payment laod
	$('#fonlyCredit').click(function(){
		if($(this).is(':checked')){ 
			$('#ConsultantBilling').validationEngine('hide');
			$('#fmode_of_payment').removeClass('validate[required,custom[mandatory-select]]');
		}else{ 
			$('#fmode_of_payment').addClass('validate[required,custom[mandatory-select]]');
		}
	});

	$('#ConsultantBilling').submit(function(){
		
		if($('#fdiscount_by_credit').val() != '' && $('#freason_for_credit_voucher').val()==''){ 
			$('#freason_for_credit_voucher').addClass('validate[required,custom[mandatory-enter-only]]');   
		}else{
			$('#freason_for_credit_voucher').removeClass('validate[required,custom[mandatory-enter-only]]'); 
		}
	});

	$('#fdiscount_by_credit').blur(function(){
		if($('#fdiscount_by_credit').val()==''){
			$('#freason_for_credit_voucher').removeClass('validate[required,custom[mandatory-enter-only]]');
			$('#freason_for_credit_voucher').validationEngine('hide'); 
		}else{
			$('#freason_for_credit_voucher').removeClass('validate[required,custom[mandatory-enter-only]]');
		}
	});
	 //alert($('#fmode_of_discharge').val());
	if($('#fmode_of_discharge').val() == 'Recovered'){
		$('#fdischargeSummery').show();
		$('#dischargeDate').show();
	}
	if($('#fmode_of_discharge').val() == 'DAMA'){
		$('#dama').show();
		$('#dischargeDate').show();
	}
	if($('#fmode_of_discharge').val() == 'Death'){
		$('#death').show();
		$('#dischargeDate').show();
	}
	if($('#fmode_of_discharge').val() == 'DischargeOnRequest'){
		//alert('here');
		$('#fdischargeSummery').show();
		$('#dischargeDate').show();
	}
	 
	 jQuery("#ConsultantBilling").validationEngine();
	 $( "#fdischarge_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			//minDate:new Date(<?php echo $this->General->minDate($wardDates['WardPatient']['in_date']) ?>),
			onSelect:function(){$(this).focus();}
		});

	 $( "#fneft_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			//minDate:new Date(<?php echo $this->General->minDate($wardInDate) ?>),
			onSelect:function(){$(this).focus();}
		});

	 $( "#fcheque_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			onSelect:function(){$(this).focus();}
		});
		
	 $("#fmode_of_payment").change(function(){
			$('#fchequeCredit').html($(this).val()+' No.');
		    
				if($("#fmode_of_payment").val() == 'Credit Card' || $("#fmode_of_payment").val() == 'Cheque' || $("#fmode_of_payment").val() == 'Debit Card'){
					$('#fcredit_period').val('');
					$('#fbank_deposite').val('');
					$('#fBN_paymentInfo').val('');
					$('#fAN_paymentInfo').val('');
					$('#fcard_check_number').val('');
					$('#fcheque_date').val('');
					$('#fBN_neftArea').val('');
					$('#fAN_neftArea').val('');
					$('#fneft_number').val('');
					$('#fneft_date').val('');
					 $("#fpaymentInfo").show();
					 $("#fcreditDaysInfo").hide();
					 $('#fneft-area').hide();
					 $('#fbankDeposite').hide();
				} else if($("#fmode_of_payment").val() == 'Credit') {
					$('#fcredit_period').val('');
					$('#fbank_deposite').val('');
					$('#fBN_paymentInfo').val('');
					$('#fAN_paymentInfo').val('');
					$('#fcard_check_number').val('');
					$('#fcheque_date').val('');
					$('#fBN_neftArea').val('');
					$('#fAN_neftArea').val('');
					$('#fneft_number').val('');
					$('#fneft_date').val('');
				 	$("#fcreditDaysInfo").show();
				 	$("#fpaymentInfo").hide();
				 	$('#fneft-area').hide();
				 	$('#fbankDeposite').hide();
				} else if($('#fmode_of_payment').val()=='NEFT') {
					$('#fcredit_period').val('');
					$('#fbank_deposite').val('');
					$('#fBN_paymentInfo').val('');
					$('#fAN_paymentInfo').val('');
					$('#fcard_check_number').val('');
					$('#fcheque_date').val('');
					$('#fBN_neftArea').val('');
					$('#fAN_neftArea').val('');
					$('#fneft_number').val('');
					$('#fneft_date').val('');
				    $("#fcreditDaysInfo").hide();
					$("#fpaymentInfo").hide();
					$('#fneft-area').show();
					$('#fbankDeposite').hide();
				}else if($('#fmode_of_payment').val()=='Bank Deposit') {
					$('#fcredit_period').val('');
					$('#fbank_deposite').val('');
					$('#fBN_paymentInfo').val('');
					$('#fAN_paymentInfo').val('');
					$('#fcard_check_number').val('');
					$('#fcheque_date').val('');
					$('#fBN_neftArea').val('');
					$('#fAN_neftArea').val('');
					$('#fneft_number').val('');
					$('#fneft_date').val('');
				    $("#fcreditDaysInfo").hide();
					$("#fpaymentInfo").hide();
					$('#fneft-area').hide();
					$('#fbankDeposite').show();
				}else{
					$('#fcredit_period').val('');
					$('#fbank_deposite').val('');
					$('#fBN_paymentInfo').val('');
					$('#fAN_paymentInfo').val('');
					$('#fcard_check_number').val('');
					$('#fcheque_date').val('');
					$('#fBN_neftArea').val('');
					$('#fAN_neftArea').val('');
					$('#fneft_number').val('');
					$('#fneft_date').val('');
			 		 $("#fcreditDaysInfo").hide();
					 $("#fpaymentInfo").hide();
					 $('#fneft-area').hide();
					 $('#fbankDeposite').hide();
				}
		});
	 $("#fmode_of_discharge").change(function(){
			//alert('here');
			if($("#fmode_of_discharge").val() == 'Recovered'){
				 $("#fdischargeSummery").show();
				 $("#death").hide();
				 $("#dama").hide();
				 $("#fdischargeDate").show();
				 
			}else if($("#fmode_of_discharge").val() == 'DischargeOnRequest'){
				 $("#fdischargeSummery").show();
				 $("#death").hide();
				 $("#dama").hide();
				 $("#fdischargeDate").show();
			}else if($("#fmode_of_discharge").val() == 'DAMA'){
				$("#dama").show();
				$("#fdischargeSummery").hide();
				$("#death").hide();
				$("#fdischargeDate").show();
			}else if($("#fmode_of_discharge").val() == 'Death'){
				$("#death").show();
				$("#dama").hide();
				$("#fdischargeSummery").hide();
				$("#fdischargeDate").show();
			}else if($("#fmode_of_discharge").val() == ''){
				$("#fdischargeDate").hide();
			}
		 });
	 
	 $("#freCalculate").click(function(){
		 calculateDiscount();
	});
	$("#fdiscount_percent").keyup(function(){
		 calculateDiscount();
	});
	$("#frefresh-discount").click(function(){
		 $("#ftotalamount").val(totalCost);
		 $("#ftotalamountpending").val(totalPendingAmount);
		 $("#ftotaladvancepaid").val(totalAdvancePaid);
		 $("#fdiscount_percent").val('');
		 $("#fdiscount_rupees").val('');
		 
	 });
	 $("#fdiscount_rupees").keyup(function(){
		 resetDiscount();
		/* var dCount = $("#discount_rupees").val();
		 var pAmount = $("#ftotalamountpending").val();
		 var dCountRs=pAmount-dCount;
		 $("#ftotalamountpending").val(dCountRs+'.00');*/
		 calculatePercentage();
	});

	/*$("#fBN_paymentInfo").on('keyup change blur',function(){
		
		$("#fBN_neftArea").val($(this).val());
		 
	});
	$("#fAN_paymentInfo").on('keyup change blur',function(){
		$("#fAN_neftArea").val($(this).val());
	});
	 */
 });
 
  function calculateDiscount(){
		var discountEntered = $("#fdiscount_percent").val();
		discountAmount = Math.ceil((totalCost*discountEntered)/100);
		amountRemaining=totalCost-discountAmount;//alert(totalCost+'-'+discountAmount+'-'+amountRemaining+'-'+totalAdvancePaid);
		pAmt = amountRemaining-totalAdvancePaid-total_discount;
		$("#ftotalamountpending").val(pAmt.toFixed(2));
		$("#fdiscount_rupees").val(discountAmount);
  }

  function calculatePercentage(){
		var discountEntered = $("#fdiscount_rupees").val();
		discountAmount = Math.floor((100*discountEntered)/totalCost);
		amountRemaining=totalCost-discountEntered;//alert(totalCost+'-'+discountAmount+'-'+amountRemaining+'-'+totalAdvancePaid);
		pAmt = amountRemaining-totalAdvancePaid-total_discount;
		console.log(pAmt);
		$("#ftotalamountpending").val(pAmt.toFixed(2));
		$("#fdiscount_percent").val(discountAmount);
 }

  function resetDiscount(){  	
	 $("#ftotalamountpending").val(totalPendingAmount); 
	 $("#fdiscount_percent").val('');
  }

  $('#famount').keyup(function(){
	
	var tariff="<?php echo strtolower($patient['TariffStandard']['name'])?>";
	if(tariff=='private'){
		$('#fpayAmount').hide();
	}
	var limit =$('#ftotalamountpending').val();;
 	var textVal=$(this).val();
 	console.log(tariff);
	if(limit!='' || typeof(limit)!=undefined || !isNaN(limit)){
		if(parseInt(textVal) > parseInt(limit)){
			$(this).val('');
			alert('Please Enter Amount less than Rs.'+parseInt(limit));
		}else if((parseInt(textVal)-parseInt(limit))=='0' && tariff=='private'){
			$('#fpayAmount').show();
		}
	}
			
});
  
  
 </script>
