<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
	xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset();
$website=$this->Session->read("website.instance");
if($website=='kanpur')
	$marginLeft="0px";
else
	$marginLeft="0px";
?>
<title></title>
<?php echo $this->Html->css(array('internal_style.css')); ?>
<style>
body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Bookman Old Style;
	font-size: 14px;
	color: #E7EEEF;
}

.heading {
    font-size: 14px;
    font-weight: bold;
    padding-bottom: 4px;
    text-decoration: underline;
}

.boxBorder {
	border: 1px solid #3E474A;
}

.boxBorderBot {
	border-bottom: 1px solid #3E474A;
}

.boxBorderRight {
	border-right: 1px solid #3E474A;
}

.tdBorderRtBt {
	border-right: 1px solid #3E474A;
	border-bottom: 1px solid #3E474A;
}

.tdBorderBt {
	border-bottom: 1px solid #3E474A;
}

.tdBorderTp {
	border-top: 1px solid #3E474A;
}

.tdBorderRt {
	border-right: 1px solid #3E474A;
}

.tdBorderTpBt {
	border-bottom: 1px solid #3E474A;
	border-top: 1px solid #3E474A;
}

.tdBorderTpRt {
	border-top: 1px solid #3E474A;
	border-right: 1px solid #3E474A;
}

.columnPad {
	padding: 5px;
}

.columnLeftPad {
	padding-left: 5px;
}

.tbl {
	background: #CCCCCC;
}

.tbl td {
	background: #FFFFFF;
}

.totalPrice {
	font-size: 14px;
}

.adPrice {
	border: 1px solid #CCCCCC;
	border-top: 0px;
	padding: 3px;
}

@page {
	size: auto;
	/*margin-top: 37mm;*/
}

@page :last { @bottom { content:element(tblFooter);
	
}
}
</style>
<style>
.print_form {
	/*background: none;*/
	font-color: black;
	color: #000000;
	min-height: 800px;
}

.formFull td {
	color: #000000;
}

.tabularForm {
	background: #000;
}

.tabularForm td {
/*	background: #ffffff;*/
	color: #333333;
	font-size: 13px;
	padding: 5px 8px;
}

@media print {
	#printButton {
		display: none;
	}
}
</style>
</head>
<!-- onload="javascript:window.print();" -->
<body class="print_form">
	<?php echo $this->Html->script('jquery-1.5.1.min.js'); ;?>
	<!-- <div>&nbsp;</div> -->

	<?php
	$website  = $this->Session->read('website.instance');

	?>

	<!-- Do not remove this table as it is used to separate header print page by pankaj w :) -->
	<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" id="fullTbl" class="boxBorder headerInfo" style="margin-left: <?php echo $marginLeft;?>">
		<thead>
			<tr>
				<td>
				 <?php $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
				          $admissionTime= date('h:i A', strtotime($admissionDate[1]));
				       $dischargeDate = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
				          $dischargeTime= date('h:i A',strtotime($dischargeDate[1]));
				          
				          
			          $balance=$finalRefundAndDiscount['TotalAmount'] - $finalRefundAndDiscount['TotalPaid'] - $discountAmount+$totalRefund;
			          
			          if($balance=='0'){
			          	$displayHeading="FINAL INVOICE";
			          }else{
			          	$displayHeading="INTERIM INVOICE";
			          }
				          
				 ?>
					<table style="" width="800" border="0" cellspacing="0"
						cellpadding="0" align="center">
						<tr><td  height="20" colspan="2"  style="text-align: center ; background-color: gray;"></td></tr>
						 <tr>
							<td colspan="2" align="center" valign="top" class="heading" id="tblHead" style="font-size: 14px"><strong><?php echo $displayHeading;?> </strong></td>
						</tr> 
						<tr><td  height="20" colspan="2"  style="text-align: center ; background-color: gray;"></td></tr>
						<tr>
						 <td width="50%" align="left" valign="top" class="boxBorderBot">
						   <table width="100%" border="1" cellspacing="0" cellpadding="3" class="tdBorderTp">
						    	<tr>
									<td width="37%" align="left" valign="top">Name Of Patient</td>
									<td valign="top"><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'];
									if($patient['Patient']['vip_chk']=='1'){
										echo __("  ( VIP )");
									} ?>
									</td>
								</tr>
							<!-- 	<tr>
									<td align="left" valign="top">Address</td>
									<td valign="top"><?php
									 if(strlen($address)<=44)
								      	{
								      		echo $address;
								      	}
								      	else
								      	{
								      		$addressWrap=substr($address,0,44) . '...';
								      		echo $addressWrap;
								      	}?></td>
								</tr> -->
								<tr>
									<td align="left" valign="top">Primary Consultant</td>
									<td valign="top"><?php echo $primaryConsultant[0]['fullname']; 
									?>
									</td>
								</tr>
								<?php if($patient['Patient']['admission_type']=='IPD'){?>
								<tr>
									<td align="left" valign="top">Ward Name/Bed No.</td>
									<td valign="top"><?php echo $patient['Ward']['name']."/".$patient['Room']['bed_prefix'].$patient['Bed']['bedno'];
									?>
									</td>
								</tr>
								<?php }?>
								<tr>
									<td align="left" valign="top">Admission Date</td>
									<td valign="top"><?php 
									echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'));?>
									</td>
								</tr>
									<tr>
									<td align="left" valign="top">Admission Time</td>
									<td valign="top"><?php echo $admissionTime;?>
									</td>
								</tr>
								<tr>
									<td align="left" valign="top">Registration No.</td>
									<td valign="top"><?php echo $patient['Patient']['admission_id'];?>
									</td>
								</tr>
						   </table>
						</td>
						
						<td width="50%" align="Right" valign="top" class="boxBorderBot">
						<table width="100%" border="1" cellspacing="0" cellpadding="3" class="tdBorderTp">
								<tr>
									<td width="37%" align="left" valign="top">Age/Sex</td>
									<td valign="top"><?php echo $patient['Person']['age']."/".ucfirst($patient['Person']['sex']);?></td>
								</tr>
								<tr>
									<td width="30%" align="left" valign="top">Contact No.</td>
									<td valign="top"><?php echo $patient['Person']['mobile'];?></td>
								</tr>
								<tr>
									<td align="left" valign="top">Case Type</td>
									<td valign="top"><?php //echo $patient['TariffStandard']['name'];
							  		echo $tariffData[$patient['Patient']['tariff_standard_id']];?>
									</td>
								</tr>
								<?php if($patient['Patient']['admission_type']=='IPD'){?>
								<!--  <tr>
									<td align="left" valign="top">Bed No</td>
									<td valign="top"><?php echo $patient['Room']['bed_prefix'].$patient['Bed']['bedno'] ;
									?>
									</td>
								</tr>-->
							   <?php }?>
							   <tr>
									<td align="left" valign="top">Discharge Date</td>
									<td valign="top"><?php
									echo $this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'));
									?>
									</td>
								</tr>
								<tr>
									<td align="left" valign="top">Discharge Time</td>
									<td valign="top"><?php 
								       if($finalBillingData['FinalBilling']['discharge_date']!=''){
                                            echo $dischargeTime;
                                         }?>
									</td>
								</tr>
								<tr>
									<td align="left" valign="top">Invoice No.</td>
									<td valign="top"><?php echo $billNumber;?></td>
								</tr>
						   </table>
						</td>
						</tr>
						<tr><td colspan="4">
							<table border="1"  style="width: 100%" >
							 <tr> <td> &nbsp; Address :   <?php echo "&nbsp &nbsp &nbsp &nbsp".$address;?></td></tr>
							</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</thead>
		<tbody>

			<?php 
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
   				$nabhKey = 'nabh_charges';
   				$nabhKeyC = 'cghs_nabh';
   			}else{
   				$nabhKey = 'non_nabh_charges';
   				$nabhKeyC = 'cghs_non_nabh';
   			}
   			?>
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td width="100%" align="left" valign="top"><?php 
							echo $this->Form->create('',array('controller'=>'Billing','action'=>'summaryInvoice','type' => 'POST','id'=>'summaryInvoice','inputDefaults' => array(
							 		'label' => false,'div' => false,'error' => false )));
                              echo $this->Form->hidden('patientID', array('value'=>$this->params->pass[0]));
                              ?>
								<table width="100%" border="0" cellspacing="0" cellpadding="5"
									class="tdBorderTpBt">
									<tr>
										<td width="2%" align="center" class="tdBorderRtBt"><strong>Sr. No.</strong></td>
										<td align="center" class="tdBorderRtBt" width="42%"><strong>Particulars</strong></td>
										<td width="2%" align="center" class="tdBorderRtBt"><strong>Unit</strong></td>
										<td width="10%" align="center" class="tdBorderRtBt"><strong>Rate</strong></td>
										<td width="14%" align="center" class="tdBorderBt tdBorderRt"><strong>Total Amount</strong></td>
									</tr>
									<?php
									$srNoHead=1;
									$totalAmount = 0;
									$summaryInvData=unserialize($patient['Patient']['summary_invoice_discount']);
									?>

									<?php
									foreach($finalBillArray as $head => $services){ ?>
								<?php if($head != Configure::read('surgeryservices')){
									 	
							 	    	 if($summaryInvData[$head]['headsTotal']!='0' && $services['Amount']!='0'){

												if($services['NoOFTimes']=='1' && !empty($summaryInvData)){
													$total=	$summaryInvData[$head]['headsTotal']*$services['NoOFTimes'];
												}else if($services['NoOFTimes']=='1' && empty($summaryInvData)){
													$total=	$services['Amount']*$services['NoOFTimes'];
												}else{
													$total=$services['Rate'];
												}
										 ?>
									<tr>
										<td align="center" class="tdBorderRt"><?php echo $srNoHead;?>
										</td>
										<td class="tdBorderRt" style="font-size: 12px;"><?php 
											if($head == 'Mandatory services'){
												echo "Registration Charges";
											}else{
												echo $head;
											}
											?></td>
										<td align="center" valign="top" class="tdBorderRt"><?php
										  if(($head == 'Mandatory services')|| ($head =='Room Tariff') || ( $head =='Surgery') ){
											  echo $services['NoOFTimes'];
											}else{
												echo "-";
											}
											?>
										</td>
										<td align="center" valign="top" id="rate"
											class="tdBorderRt rate"><?php 
											if(($head == 'Mandatory services')|| ($head =='Room Tariff') || ( $head =='Surgery') ){
												echo $total;
											}else{
												echo "-";
											}
										?> <input
											id="rateHead_<?php echo str_replace(" ","",$head);?>"
											class="hidden_rate" autocomplete='off'
											value="<?php echo $total;?>" type="hidden" />
										</td>


										<td align="center" valign="top" class=" amount totalAmt"
											id="totalHead_<?php echo str_replace(" ","",$head);?>"><?php 
											if($head != Configure::read('surgeryservices')){
                                         if($summaryInvData[$head]['headsTotal']!=''){
                                         	echo $summaryInvData[$head]['headsTotal'];
                                         	$totalAmount = $totalAmount + $summaryInvData[$head]['headsTotal'];
                                         }else{
                                         	echo $services['Amount'];
                                         	$totalAmount = $totalAmount + $services['Amount'];
                                         }
										}
										?>
										</td>
										<input
											id="totalAmount_<?php echo str_replace(" ","",$head);?>"
											class="totalAmount" value="<?php echo $services['Amount'];?>"
											type="hidden"
											name="SummaryInvoice[<?php echo $head;?>][headsTotal]" />


									</tr>
									<?php }
									 }?>
									<?php if($head == Configure::read('surgeryservices')){?>
									<?php 
										unset($services['NoOFTimes']);
										unset($services['Rate']);
										unset($services['Amount']);
										$i=1;
										
										$surgeryPrevCharge=unserialize($patient['OptAppointment']['ot_charges_for_summary_invoice']);
									    foreach($services as $head=>$service){ 
											$otService = $service['ServiceName'];
											$fieldname = $service['field_name'];
											$serviceId = $service['id'];
											$surgeryName=$service['ServiceName'];
											$surName =  str_replace("&nbsp;","",$surgeryName);
											$serviceName= explode('(', $surName);
											$serName =  str_replace("&nbsp;","",$serviceName[0]);

											if($service['NoOFTimes']=='1' && !empty($surgeryPrevCharge)){
												$total=	$surgeryPrevCharge[$fieldname][$surName]['headsTotal']*$service['NoOFTimes'];
											}else if($services['NoOFTimes']=='1' && empty($surgeryPrevCharge)){
												$total=	$service['Amount']*$service['NoOFTimes'];
											}else{
												$total=$service['Rate'];
											}
 										?>
									<tr>
										<td align="center" class="tdBorderRt"><?php echo $srNoHead++;?>&nbsp;</td>
										<td class="tdBorderRt" ><?php 
										echo $serName;
										?>
										</td>
										<td align="center" valign="top" class="tdBorderRt"><?php 
										if($surgeryPrevCharge[$fieldname][$surName]['headsTotal']!='0' && $service['Amount']!='0'){
										echo $service['NoOFTimes'];
										}
										?>
										</td>
								
										<td align="center" valign="top" id="rate"
											class="tdBorderRt rate"
											value="<?php echo $services['Amount'];?>">
											<?php 
												if($surgeryPrevCharge[$fieldname][$surName]['headsTotal']!='0' && $service['Amount']!='0'){
												echo $total;
											}?> 
											
											<input id="rateHead_<?php echo $i ;?>" class="hidden_rate"
											autocomplete='off' value="<?php echo $total;?>"
											type="hidden" />
										</td>
									
										<td align="center" valign="top" class=" amount totalAmt"
											id="totalHead_<?php echo $i;?>"><?php 
												if($surgeryPrevCharge[$fieldname][$surName]['headsTotal']!='0' && $service['Amount']!='0'){
													if($surgeryPrevCharge[$fieldname][$surName]['headsTotal']!=''){
														echo $surgeryPrevCharge[$fieldname][$surName]['headsTotal'];
														$totalAmount = $totalAmount + $surgeryPrevCharge[$fieldname][$surName]['headsTotal'];
													}else{
														echo $service['Amount'];
														$totalAmount = $totalAmount + $service['Amount'];
													}
												}
											?></td>
										<input id="totalAmount_<?php echo $i ;?>" class="totalAmount"
											value="<?php echo $service['Amount'];?>" type="hidden"
											name="SummaryInvoice[<?php echo $head;?>][headsTotal]" />
									</tr>
									<?php $i++ ; }?>
									<?php }?>


									<?php $srNoHead++;?>
									<?php }?>
									<?php $finalRefundAndDiscount['TotalAmount'] = $totalAmount;?>
									<?php /* -------------------------------------------------------------------------------------------*/?>
								</table> <?php echo $this->Form->end();?>
							</td>
						</tr>


					</table>
				</td>
			</tr>
		</tbody>

		<!-- <tfoot> -->
		<tr>
			<td width="100%" align="left" valign="top" class="tblFooter"
				id="tblFooter">
			
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr><td  height="20" colspan="2"  style="text-align: center ; background-color: gray;"></td></tr>
						
						   <tr>
									<td width="121" height="20" valign="top" class="tdBorderRtBt"><strong>&nbsp;Total Billed Amount</strong></td>
									<td align="right" valign="top" class="tdBorderBt totalPaidAmnt"><strong> <?php 
									 echo $this->Number->currency(ceil($finalRefundAndDiscount['TotalAmount'])); ?>
									</strong></td>
									<input
										id="finalAmnt" class="finalAmnt" type="hidden"
										value="<?php echo $finalRefundAndDiscount['TotalAmount'];?>"
										name="SummaryInvoice[finalTotal]" />
							</tr>
							
							<tr>
									<td width="121" height="20" valign="top" class="tdBorderRtBt"><strong>&nbsp;Advance Received</strong></td>
									<td align="right" valign="top" class="tdBorderBt totalPaidAmnt"><strong><?php 
									echo $this->Number->currency(ceil($totalAdvance['totalAdvanceAmount']));
									?>
									</strong></td>
									<input id="paidAmnt" class="paidAmnt" type="hidden"
										value="<?php echo $totalAdvance['totalAdvanceAmount'];?>" />
							</tr>
							

								<?php 

								if($totalDiscountGiven[0]['sumDiscount']){
									$discountAmount=$totalDiscountGiven[0]['sumDiscount'];
								}else{
									$discountAmount='';
								}
			                    if($discountAmount != '' && $discountAmount!=0){?>
							<tr>
								<td width="121" height="20" valign="top" class="tdBorderRtBt"><strong>&nbsp;Discounted Amount</strong></td>
								<td align="right" valign="top" class="tdBorderBt"><strong><?php  
								echo $this->Number->currency(ceil($discountAmount));
								?>
								</strong></td>
								<input id="discount" class="discount" type="hidden"
									value="<?php echo $discountAmount;?>" />
							</tr>
								<?php }?>

								<?php 
								if($totalRefundGiven[0]['sumRefund']){
									$totalRefund=$totalRefundGiven[0]['sumRefund'];
								}else{
									$totalRefund='';
								}
			                    if($totalRefund != '' && $totalRefund!=0){?>
							<tr>
								<td height="20" valign="top" class="tdBorderRtBt">&nbsp; <?php  echo '<strong>'."Refunded Amount".'</strong>';?>
								</td>
								<td align="right" class="tdBorderBt"><strong><?php 
								echo $this->Number->currency(ceil($totalRefund));
								?></strong>
								</td>
								<input id="refund" class="refund" type="hidden"
									value="<?php echo $totalRefund;?>" />
							</tr>
								<?php }else{$totalRefund='0';?>
								<input id="refund" class="refund" type="hidden"
									value="<?php echo $totalRefund;?>" />
								<?php }?>


							<tr>
								<td height="20" valign="top" class="tdBorderRtBt">&nbsp; <strong>Balance Amount</strong>
								</td>
								<td align="right" valign="top" class="tdBorderBt balance"><strong><?php 
								$balance=$finalRefundAndDiscount['TotalAmount'] - $finalRefundAndDiscount['TotalPaid'] - $discountAmount+$totalRefund;
								echo $this->Number->currency(ceil($balance));
								?>
								</strong></td>
							</tr>
							<tr>
									<td width="121" height="20" valign="top" class="tdBorderRtBt"><strong>&nbsp;Total Amount Received</strong></td>
									<td align="right" valign="top" class="tdBorderBt totalPaidAmnt"><strong><?php 
									echo $this->Number->currency(ceil($finalRefundAndDiscount['TotalPaid']));
									?>
									</strong></td>
									<input id="paidAmnt" class="paidAmnt" type="hidden"
										value="<?php echo $finalRefundAndDiscount['TotalPaid'];?>" />
							</tr>
							<tr>
									<td width="121" height="20" valign="top" class="tdBorderRtBt"><strong>&nbsp;Amount Payable</strong></td>
									<td align="right" valign="top" class="tdBorderBt "><strong><?php 
									echo $this->Number->currency(ceil($balance-$discountAmount+$totalRefund));
									?>
									</strong></td>
									
							</tr>
							
							<tr>
							     <td width="50%" height="20" valign="top" class="tdBorderRtBt">&nbsp;<?php if($summaryInvData!=''){?><strong>Amount in words</strong><?php }?></td>
							     <td align="right" valign="top" class="tdBorderBt  columnPad"><strong><?php if($summaryInvData!=''){
								         echo $this->RupeesToWords->no_to_words(ceil($finalRefundAndDiscount['TotalAmount']));
								   }?> </strong>
								</td>
							</tr>

							</table>
				
			</td>
		</tr>
		<tr><td colspan="4"  style="text-align: center ; background-color: gray;"><strong>Payment History</strong></td></tr>
		<tr>
			<td>
				<table width="100%" cellpadding="0" cellspacing="1" border="1">
				

					<tr>
						<td style="text-align: center"><strong>Type</strong></td>
						<td style="text-align: center"><strong>Date</strong></td>
						<td style="text-align: center"><strong>Amount</strong></td>
						<td style="text-align: center"><strong>Reciept No.</strong></td>
						<td style="text-align: center"><strong>Mode</strong></td>
					</tr>
					<?php foreach ($advancePaymentDeatils as $advDetails){?>
					<tr>
						<td style="text-align: center"><?php echo ucfirst($advDetails['Billing']['payment_category']);?></td>
						<td style="text-align: center"><?php echo $this->DateFormat->formatDate2Local($advDetails['Billing']['create_time'],Configure::read('date_format'),true);?></td>
						<td style="text-align: center"><?php echo $advDetails['Billing']['amount']?></td>
						<td style="text-align: center"><?php echo $advDetails['Billing']['receiptNo']?></td>
						<td style="text-align: center"><?php echo $advDetails['Billing']['mode_of_payment']?></td>
					</tr>
					<?php }?>

				</table>
			</td>
		</tr>
		<tr>
			<td width="100%" align="left" valign="top" class="columnPad ">
				<table width="" cellpadding="0" cellspacing="0" border="0">
					<?php if($this->Session->read('website.instance')=='hope'){?>
					<tr>
						<td height="18" align="left" valign="top">Hospital Service Tax No.</td>
						<td width="15" align="center" valign="top">:</td>
						<td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_service_tax_no');?>
						</strong></td>
					</tr>
					<tr>
						<td height="20" align="left" valign="top">Hospitals PAN</td>
						<td align="center" valign="top">:</td>
						<td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_pan_no');?>
						</strong></td>
					</tr>
					<?php }else{?>
					<tr>
						<td height="18" align="left" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td height="20" align="left" valign="top">&nbsp;</td>
					</tr>
					<?php }?>
					<tr>
						<td height="20" align="left" valign="top"><strong>Signature of
								Patient :</strong></td>
						<td align="center" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="100%" align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="55%" class="columnPad boxBorderRight">&nbsp;</td>
						<td width="45%" align="right" valign="bottom"
							class="columnPad tdBorderTp tdBorderRt"><strong><?php echo $this->Session->read('billing_footer_name');?>
						</strong><br /> <br /> <br />
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="85">Bill Manager</td>
									<td width="65">Cashier</td>
									<td width="80">Med.Supdt.</td>
									<td align="right">Authorised Signatory</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!--   </tfoot> -->
	</table>
</body>
</html>
<script type="text/javascript">
      jQuery(document).ready(function(){
    	  window.print();
      });
      
         
    </script>
