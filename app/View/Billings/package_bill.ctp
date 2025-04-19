<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
	xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<style>
body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
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
	<div>&nbsp;</div>
	<table width="100%">
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
	<table width="800" border="0" cellspacing="0" cellpadding="0"
		align="center" id="fullTbl">
		<tr>
			<td>
				<table width="800" border="0" cellspacing="0" cellpadding="0"
					style="margin-top: 70px; margin-bottom: 10px;" align="center">
					<tr>
						<td width="100%" align="center" valign="top" class="heading"
							id="tblHead"><strong>INVOICE </strong></td>
					</tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0"
					align="center" class="boxBorder" id="tblContent">
					<tr>
						<td width="100%" align="left" valign="top" class="boxBorderBot">
							<table width="800" border="0" cellspacing="0" cellpadding="5">
								<tr>
									<td width="370" align="left" valign="top">Name Of Patient</td>
									<td width="10" valign="top">:</td>
									<td valign="top"><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'];
									if($patient['Patient']['vip_chk']=='1') echo __("  ( VIP )");?>
									</td>
								</tr>
								<?php if($patient['Person']['name_of_ip']!=''){?>
								<tr>
									<td align="left" valign="top">Name Of the I. P.</td>
									<td valign="top">:</td>
									<td valign="top"><?php echo $patient['Person']['name_of_ip'];?>
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
								<?php if($patient['Person']['plot_no']!='' || $patient['Person']['taluka']!='' || $patient['Person']['city']!='' || $patient['Person']['district']!=''){?>
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
										echo $this->DateFormat->formatDate2Local($patient['Patient']['date_of_referral'],Configure::read('date_format'));
									?>
									</td>
								</tr>
								<?php }?>
								<?php if($patient['Patient']['form_received_on']!=''){?>
								<tr>
									<td align="left" valign="top">Date Of Registration</td>
									<td valign="top">:</td>
									<td valign="top"><?php $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
									echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?>
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
								<?php if($corporateEmp!=''){
									$hideCGHSCol = '';
									if(strtolower($corporateEmp) == 'private') $hideCGHSCol = 'none' ; ?>
								<tr>
									<td align="left" valign="top">Category</td>
									<td valign="top">:</td>
									<td valign="top"><?php echo $corporateEmp;?></td>
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
					<tr>
						<td><table width="100%" cellpadding="5" cellspacing="0" border="0">
							</table></td>
					</tr>
					<tr>
						<td width="100%" align="left" valign="top">
							<table width="100%" border="0" cellspacing="0" cellpadding="5"
								class="tdBorderTpBt">
								<tr>
									<td width="2%" align="center" class="tdBorderRtBt">Sr. No.</td>

									<td align="center" class="tdBorderRtBt" width="26%">Item</td>
									<td width="14%" align="center" class="tdBorderRtBt">Rate</td>
									<td width="14%" align="center" class="tdBorderRtBt">Qty.</td>
									<td width="14%" align="center" class="tdBorderBt tdBorderRt">Amount</td>
								</tr>
								<tr>
									<td align="center" class="tdBorderRt">&nbsp;</td>
									<td class="tdBorderRt" style="font-size: 12px;"><strong><i>Package Bill</i> </strong>
									</td>
									<td align="center" class="tdBorderRt">&nbsp;</td>
									<td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong>
									</td>
									<td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
								</tr>
								<tr>
									<td align="center" class="tdBorderRt">1</td>
									<td class="tdBorderRt">Registration Charges</td>
									<td align="center" style="display: none" class="tdBorderRt">14587
									</td>
									<td align="right" valign="top" class="tdBorderRt">500</td>
									<td align="center" valign="top" class="tdBorderRt">1</td>

									<td align="right" valign="top">500</td>
								</tr>
								<tr>
									<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
									<td align="right" valign="top" class="tdBorderTpRt"><strong>Total</strong>
									</td>
									<td align="center" style="display: none" class="tdBorderTpRt">&nbsp;</td>
									<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
									<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
									<td align="right" valign="top"
										class="tdBorderTp totalPrice tdBorderRt"><strong><span
											class="WebRupee"></span> 600.00 </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tfoot id="table_footer">
						<tr>
							<td colspan="5">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="5">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="5">&nbsp;</td>
						</tr>
					</tfoot>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0"
					style="" align="center" id="tblFooter">
					<tr>
						<td width="100%" align="left" valign="top" class="">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td valign="top" class="boxBorderRight columnPad">Amount
										Chargeable (in words)<br /> <strong> </strong>
									</td>
									<td width="292" class="tdBorderRt">
										<table width="100%" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td width="121" height="20" valign="top"
													class="tdBorderRtBt">&nbsp;Amount Paid</td>
												<td align="right" valign="top" class="tdBorderBt">0.00</td>
											</tr>
											<tr>
												<td height="20" valign="top" class="tdBorderRtBt">&nbsp;
													Balance</td>
												<td align="right" valign="top" class="tdBorderBt">0.00</td>
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
								<tr>
									<td height="18" align="left" valign="top">Hospital Service Tax
										No.</td>
									<td width="15" align="center" valign="top">:</td>
									<td align="left" valign="top"><strong>12-1234567 </strong></td>
								</tr>
								<tr>
									<td height="20" align="left" valign="top">Hospitals PAN</td>
									<td align="center" valign="top">:</td>
									<td align="left" valign="top"><strong>12 </strong></td>
								</tr>
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
										class="columnPad tdBorderTp tdBorderRt"><strong>12 </strong><br />
										<br /> <br />
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
				</table>

			</td>
		</tr>
	</table>

	<script>
 $(document).ready(function(){
	 	var screenHeight = $(window).height();
	 	if(screenHeight < 800 ) screenHeight  = 800 ;	
		var tableFull = $("#fullTbl").height();	
		var tableHead = $("#tblHead").height();
		var tableContent = $("#tblContent").height();
		var tableFooter = $("#tblFooter").height();
		//  alert(tableFull);
		if(screenHeight > tableFull)
		{
			var requireHt = screenHeight - (tableFull);
			$("#addColumnHt").css("height", (requireHt+130)+"px");
		}
		else
		{
			var division = tableFull / screenHeight;
			 
			if(division < 1.07)
			{
				
				var requireHt = screenHeight - (tableFull);
				$("#addColumnHt").css("height", (requireHt+50)+"px");
			}
			else if(division > 1.07 && division < 2.36)// second page
			{
				var screenHeight = 842;
				var requireHt = (screenHeight*2) - tableFull;
				$("#addColumnHt").css("height", (requireHt+200)+"px");		
			}	
			else if(division > 2.36)// Third page
			{
				//alert(division);
				var screenHeight = 842;
				var requireHt = (screenHeight*3) - tableFull;
				$("#addColumnHt").css("height", (requireHt+430)+"px");
			}	
		}	
	 });
</script>
</body>
</html>
