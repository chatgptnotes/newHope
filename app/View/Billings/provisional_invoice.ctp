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
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #E7EEEF;
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
	margin-top: 37mm;
}

@page :last { @bottom { content:element(tblFooter);
	
}
}
</style>
<style>
.print_form {
	background: none;
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
	background: #ffffff;
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


	<table width="200" style="float: right">
		<tr>
			<td align="right">
				<div id="printButton">
					<?php 

					echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
					?>
				</div>
			</td>
		</tr>
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
			<td><div style="float: left">
					<?php echo  $this->Html->image('icons/MSA.jpg',array('width'=>100,'height'=>100)) ; ?>
				</div></td>
			<td><div style="float: right">
					<?php echo  $this->Html->image('icons/KCHRC.jpg',array('width'=>100,'height'=>100)) ; ?>
			
			</td>
		</tr>
	</table>
	<?php } ?>
	<!-- Do not remove this table as it is used to separate header print page by pankaj w :) -->

	<?php $hospitaType = $this->Session->read('hospitaltype');
	if($hospitaType == 'NABH'){
          	$nabhType='nabh_charges';
          }else{
          	$nabhType='non_nabh_charges';
          }
          ?>
	<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" id="fullTbl" class="boxBorder headerInfo" style="margin-left: <?php echo $marginLeft;?>">
		<thead>
			<tr>
				<td>
					<table style="" width="800" border="0" cellspacing="0"
						cellpadding="0" align="center">
						<tr>
							<th>&nbsp;</th>
						</tr>
						<tr>
							<td width="100%" align="center" valign="top" class="heading"
								id="tblHead"><strong><?php 
								echo 'PROVISIONAL INVOICE';
								if($patient['Patient']['admission_type']=='IPD'){
							  		$dynamicText = 'Discharge' ;
							  	}else{
							  		$dynamicText = 'completion of OPD process' ;
							  	}
							  	?> </strong></td>
						</tr>
						<tr>
							<td width="100%" align="left" valign="top" class="boxBorderBot">
								<table width="800" border="0" cellspacing="0" cellpadding="3"
									class="tdBorderTp">
									<tr>
										<td width="370" align="left" valign="top">Name Of Patient</td>
										<td width="10" valign="top">:</td>
										<td valign="top"><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'];
										if($patient['Patient']['vip_chk']=='1'){
											echo __("  ( VIP )");
										} ?>
										</td>
									</tr>
									<?php if($patient['Person']['name_of_ip']!=''){?>
									<tr>
										<td align="left" valign="top">Name Of the I. P.</td>
										<td valign="top">:</td>
										<td valign="top"><?php echo $person['Person']['name_of_ip']; ?>
										</td>
									</tr>
									<?php }?>
									<?php if($patient['Person']['relation_to_employee']!=''){?>
									<tr>
										<td align="left" valign="top">Relation with I. P.</td>
										<td valign="top">:</td>
										<td valign="top"><?php 
										$relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
										echo $relation[$patient['Person']['relation_to_employee']];
										?>
										</td>
									</tr>
									<?php }?>
									<tr>
										<td align="left" valign="top">Age/Sex</td>
										<td valign="top">:</td>
										<td valign="top"><?php 
										echo $patient['Person']['age']."/".ucfirst($patient['Person']['sex']);
										?>
										</td>
									</tr>
									<?php 
									if(!empty($address)){?>
									<tr>
										<td align="left" valign="top">Address</td>
										<td valign="top">:</td>
										<td valign="top"><?php echo $address ?></td>
									</tr>
									<?php }?>
									<?php if($patient['Person']['insurance_number']!='' || $patient['Person']['executive_emp_id_no']!='' || $patient['Person']['non_executive_emp_id_no']!=''){?>
									<tr>
										<td align="left" valign="top">Insurance Number/Staff Card
											No/Pensioner Card No.</td>
										<td valign="top">:</td>
										<td valign="top"><?php 
										if($patient['Person']['insurance_number']!=''){
									    	echo $patient['Person']['insurance_number'];
									    }elseif($patient['Person']['executive_emp_id_no']!=''){
									    	echo $patient['Person']['executive_emp_id_no'];
									    }elseif($patient['Person']['non_executive_emp_id_no']!=''){
									    	echo $patient['Person']['non_executive_emp_id_no'];
									    }
									    ?>
										</td>
									</tr>
									<?php }?>
									<?php if($patient['Patient']['date_of_referral']!=''){?>
									<tr>
										<td align="left" valign="top">Date of Referral</td>
										<td valign="top">:</td>
										<td valign="top"><?php 
										if($patient['Patient']['date_of_referral']!='')
											echo
											$this->DateFormat->formatDate2Local($patient['Patient']['date_of_referral'],Configure::read('date_format'));
										?>
										</td>
									</tr>
									<?php }?>
									<?php if($patient['Patient']['form_received_on']!=''){?>
									<tr>
										<td align="left" valign="top">Date Of Registration</td>
										<td valign="top">:</td>
										<td valign="top"><?php $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
										echo
										$this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?>
										</td>
									</tr>
									<?php }?>
									<?php if($finalBillingData['FinalBilling']['discharge_date']!=''){?>
									<tr>
										<td align="left" valign="top">Date Of <?php echo $dynamicText ;?>
										</td>
										<td valign="top">:</td>
										<td valign="top"><?php
										if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
											$splitDate = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
											echo $this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true);
										}
										?>
										</td>
									</tr>
									<?php }?>
									<?php if($finalBillingData['FinalBilling']['patient_discharge_condition']!=''){?>
									<tr>
										<td align="left" valign="top">Condition of the patient on <?php echo $dynamicText ;?>
										</td>
										<td valign="top">:</td>
										<td valign="top"><?php 
										echo $finalBillingData['FinalBilling']['patient_discharge_condition'];
										?>
										</td>
									</tr>
									<?php }?>
									<?php if($invoiceMode!='direct'){?>
									<tr>
										<td align="left" valign="top">Invoice No.</td>
										<td valign="top">:</td>
										<td valign="top"><?php echo $billNumber;?></td>
									</tr>
									<?php }?>
									<?php if($patient['Patient']['admission_id']!=''){?>
									<tr>
										<td align="left" valign="top">Registration No.</td>
										<td valign="top">:</td>
										<td valign="top"><?php echo $patient['Patient']['admission_id'];?>
										</td>
									</tr>
									<?php }?>
									<?php if($patient['TariffStandard']['name']!=''){
										$hideCGHSCol = '';
										//echo $patient['TariffStandard']['name'] ;
										if(strtolower($patient['TariffStandard']['name']) == 'private'){
								  			$hideCGHSCol = 'none' ;
								  		}
								  		?>
									<tr>
										<td align="left" valign="top">Category</td>
										<td valign="top">:</td>
										<td valign="top"><?php //echo $patient['TariffStandard']['name'];
								  		echo $tariffData[$patient['Patient']['tariff_standard_id']];?>
										</td>
									</tr>
									<?php }?>
									<?php if($primaryConsultant[0]['fullname']!=''){?>
									<tr>
										<td align="left" valign="top">Primary Consultant</td>
										<td valign="top">:</td>
										<td valign="top"><?php echo $primaryConsultant[0]['fullname']; 
										?>
										</td>
									</tr>
									<?php }?>
									<?php if($finalBillingData['FinalBilling']['credit_period']!=''){?>
									<tr>
										<td align="left" valign="top">Credit Period (in days)</td>
										<td valign="top">:</td>
										<td valign="top"><?php echo $finalBillingData['FinalBilling']['credit_period'];
										?>
										</td>
									</tr>
									<?php }?>
									<?php if($finalBillingData['FinalBilling']['other_consultant']!=''){?>
									<tr>
										<td align="left" valign="top">Other Consultant Name</td>
										<td valign="top">:</td>
										<td valign="top"><?php 
										echo $finalBillingData['FinalBilling']['other_consultant'];?>
										</td>
									</tr>
									<?php }?>
									<?php if(!empty($finalBillingData['FinalBillingOption'])){
										$count = 0 ;
										foreach($finalBillingData['FinalBillingOption'] as $finalOptions){
											$newHtml  =	'<tr>';
											$newHtml .=  '<td align="left" valign="top">'.ucwords($finalOptions['name']).'</td>' ;
											$newHtml .=  '<td valign="top">:</td>';
											$newHtml .=  '<td valign="top">';
											$newHtml .=  ucwords($finalOptions['value']).'</td>';
											$newHtml .=  '</tr>';

											echo $newHtml  ;
											$count++ ;
										}

									}
									?>
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
							<td>
								<table width="100%" cellpadding="5" cellspacing="0" border="0">
									<?php if($diagnosisData['Diagnosis']['final_diagnosis']!=''){?>
									<tr>
										<td valign="top">Diagnosis<br /> <?php 
										echo $diagnosisData['Diagnosis']['final_diagnosis'];
										?>
										</td>
									</tr>
									<?php }?>
									<?php if(!empty($surgeriesData)){?>
									<tr>
										<td valign="top">Surgeries<br /> <?php 
										$b=1;
										foreach($surgeriesData as $surg){
                    						if($b==1 && $surg['TariffList']['name']!=''){
                    							echo $b.'. '.$surg['TariffList']['name'];
                    							$b++;
                    						}else if($surg['TariffList']['name'] != ''){
                    							echo ', '.$b.'. '.$surg['TariffList']['name'];
                    							$b++;
                    						}
                   						} ?>
										</td>
									</tr>
									<?php }?>
								</table>
							</td>
						</tr>
						<tr>
							<td width="100%" align="left" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="5"
									class="tdBorderTpBt">
									<tr>
										<td width="2%" align="center" class="tdBorderRtBt">Sr. No.</td>
										<td align="center" class="tdBorderRtBt" width="54%">Item</td>
										<td width="14%" align="center" class="tdBorderRtBt" style="display:<?php echo $hideCGHSCol ;?>">CGHS
											Code No.</td>
										<td width="14%" align="center" class="tdBorderRtBt">Rate</td>
										<td width="14%" align="center" class="tdBorderRtBt">Qty.</td>
										<td width="14%" align="center" class="tdBorderBt tdBorderRt">Amount</td>
									</tr>
									

									<?php if($patient['Patient']['payment_category']!='cash'){?>
									<tr>
										<td align="center" class="tdBorderRt">&nbsp;</td>
										<td class="tdBorderRt" style="font-size: 12px;"><strong><i>Conservative
													Charges</i> </strong><span id="firstConservativeText"></span>
										</td>
										<td align="center" class="tdBorderRt">&nbsp;</td>
										<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
										<td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong>
										</td>
										<td align="right" valign="top" >&nbsp;</td>
									</tr>
									<?php }?>

									<?php /* --------------------SUB RECORDS-------------------------------------------------------------- */?>
									<?php $srNoHead=1;?>
									<?php $totalAmount = 0;?>
									<?php foreach($finalBillArray as $head => $services){?>
									<tr>
										<td align="center" class="tdBorderRt"><?php echo $srNoHead;?></td>
										<td class="tdBorderRt" style="font-size: 12px;"><strong><i><?php echo $head;?></i> </strong>
										</td>
										<td align="center" class="tdBorderRt">&nbsp;</td>
										<td align="center" class="tdBorderRt">&nbsp;</td>
										<td align="right" valign="top"><strong>&nbsp;</strong>
										</td>
										
									</tr>
									<?php //if($head != Configure::read('surgeryservices')){?>
									<?php foreach($services as $head=>$service){?>
									<tr>
										<td align="center" class="tdBorderRt"><?php //echo $srno++;?>&nbsp;</td>
										<td class="tdBorderRt" style="padding-left: 13px;"><?php echo $service['ServiceName']?></td>
										<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
										echo $service['CGHSCode'];
										?>
										</td>
										<td align="right" valign="top" class="tdBorderRt"><?php echo $service['Rate'];
										?>
										</td>
										<td align="center" valign="top" class="tdBorderRt"><?php 
										echo $service['NoOFTimes'];
										?>
										</td>
										<td align="right" valign="top"><?php 
										echo $service['Amount'];
										$totalAmount = $totalAmount + $service['Amount'];
										?>
										</td>
									</tr>
									<?php }?>
									<?php //}else{?>
									<?php //}?>
									<?php $srNoHead++;?>
									<?php }?>
									<?php $finalRefundAndDiscount['TotalAmount'] = $totalAmount;?>
									<?php /* -------------------------------------------------------------------------------------------*/?>
									<!--  Registration Charges -->
									<tr>
										<td class="tdBorderRt" align="center" valign="top"
											id="addColumnHt1"></td>
										<td class="tdBorderRt"></td>
										<td class="tdBorderRt" align="center"></td>
										<td class="tdBorderRt" align="right" valign="top"></td>
										<td align="right" valign="top"></td>
									</tr>
									<tr>
										<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
										<td align="right" valign="top" class="tdBorderTpRt"><strong>Total</strong>
										</td>
										<td align="center" class="tdBorderTpRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
										<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
										<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
										<td align="right" valign="top"
											class="tdBorderTp totalPrice tdBorderRt"><strong> <span
												class="WebRupee"></span> <?php  echo $this->Number->currency(ceil($finalRefundAndDiscount['TotalAmount'])); ?>
										</strong></td>
									</tr>
								</table>
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
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="boxBorderRight columnPad">Amount
							Chargeable (in words)<br /> <strong><?php echo $this->RupeesToWords->no_to_words(ceil($finalRefundAndDiscount['TotalAmount']));?>
						</strong>
						</td>
						<td width="292" class="tdBorderRt">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Amount
										Paid</td>
									<td align="right" valign="top" class="tdBorderBt"><?php 
									echo $this->Number->currency(ceil($finalRefundAndDiscount['TotalPaid']));
									?>
									</td>
								</tr>

								<?php 

								if($totalDiscountGiven[0]['sumDiscount']){
							$discountAmount=$totalDiscountGiven[0]['sumDiscount'];
						}else{
							$discountAmount='';
						}
	                    if($discountAmount != '' && $discountAmount!=0){?>
								<tr>
									<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Discount</td>
									<td align="right" valign="top" class="tdBorderBt"><?php  
									echo $this->Number->currency(ceil($discountAmount));
									?>
									</td>
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
									<td height="20" valign="top" class="tdBorderRtBt">&nbsp; <?php  echo 'Refunded Amount';?>
									</td>
									<td align="right" class="tdBorderBt"><?php 
									echo $this->Number->currency(ceil($totalRefund));
									?>
									</td>
								</tr>
								<?php }else{$totalRefund='0';
}?>


								<tr>
									<td height="20" valign="top" class="tdBorderRtBt">&nbsp; <?php if($invoiceMode=='direct') echo 'To Pay on '.$dynamicText;
	    						else echo 'Balance';?>
									</td>
									<td align="right" valign="top" class="tdBorderBt"><?php 
									//echo $this->Html->image('icons/rupee_symbol.png');
                                                                        //if($finalRefundAndDiscount['AdvancePaid'] != 0 ) 
                                                                         //   $finalRefundAndDiscount['TotalPaid'] = $finalRefundAndDiscount['AdvancePaid'] - $finalRefundAndDiscount['TotalPaid'];
									echo $this->Number->currency(ceil($finalRefundAndDiscount['TotalAmount'] - $finalRefundAndDiscount['TotalPaid'] - $discountAmount+$totalRefund));
									?>
									</td>
								</tr>


							</table>
						</td>
					</tr>
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
