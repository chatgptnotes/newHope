<style>
.all_ul {
	text-decoration: none;
	line-height: 0.5;
	font-size: 13px;
}

.all_li {
	text-decoration: none;
	line-height: 1.4;
	font-size: 13px;
}

.tbLabel {
	font-size: 13px;
}

table td {
	font-size: 13px;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Reports Management', true);?>
	</h3>
</div>
<?php if($this->Session->read('website.instance')=='vadodara'){?>
<table id="managerial" width="100%"
	style="border-left: 1px solid #4C5E64; border-right: 1px solid #4C5E64; border-top: 1px solid #4C5E64; margin-top: 20px;">
	<tr class="row_title">
		<td class="table_cell" style="font-size: 13px"><strong>Name Of Report</strong></td>
	</tr>
	<?php $selectCorporate = $this->Html->link('Corporate Billing Report',array('controller'=>'Corporates','action'=>'selectCorporate','admin'=>false))?>
	<?php if($selectCorporate){?>
	<tr class="row_gray" > 
	    <td class="tbLabel">&nbsp;&nbsp;<?php echo $selectCorporate;?></td>
 	</tr> 
 	<?php }?>
 	<?php $billingReceiptReport= $this->Html->link('Patient History Report',array('controller'=>'Billings','action'=>'billingReceiptReport','admin'=>false))?>
 	<?php if($billingReceiptReport){?>
	 <tr class="row_gray">
		<td class="tbLabel">&nbsp;&nbsp;<?php echo $billingReceiptReport ;?>
		</td>
	</tr> 
	<?php }?>
	<?php $patientOutstandingReport= $this->Html->link('Nursing Outstanding Report',array('controller'=>'Billings','action'=>'patient_outstanding_report','admin'=>false))?>
	<?php if($patientOutstandingReport){?>
	<tr class="row_gray">
		<td class="tbLabel">&nbsp;&nbsp;<?php echo  $patientOutstandingReport;?>
		</td>
	</tr>
	<?php }?>
	
	<?php $corporateRec = $this->Html->link('Corporate Receivable Report',array('controller'=>'accounting','action'=>'corporate_receivable','admin'=>false));?>
	<?php if(!empty($corporateRec)){?>
	<tr class="row_gray">
		<td class="tbLabel">&nbsp;&nbsp;<?php echo $corporateRec;?>
		</td>
	</tr>
	<?php }?>
	
	<?php $serviceWiseCollection = $this->Html->link('Service Wise Collection Report',array('controller'=>'accounting','action'=>'service_wise_collection','admin'=>false));?>
	<?php if(!empty($serviceWiseCollection)){?>
	<tr class="row_gray">
		<td class="tbLabel">&nbsp;&nbsp;<?php echo $serviceWiseCollection;?>
		</td>
	</tr>
	<?php }?>
	
	<?php $dailyCollection=$this->Html->link('Daily Cash Collection Report',array('controller'=>'accounting','action'=>'daily_collection','admin'=>false))?>
	<?php if($dailyCollection){?>
	<tr class="row_gray">
		<td class="tbLabel">&nbsp;&nbsp;<?php echo $dailyCollection;?>
		</td>
	</tr>
	<?php }?>
	<?php $dailyCardCollection=$this->Html->link('Patient Card Report',array('controller'=>'accounting','action'=>'daily_card_collection','admin'=>false))?>
	<?php if($dailyCardCollection){?>
	<tr class="row_gray">
		<td class="tbLabel">&nbsp;&nbsp;<?php  echo $dailyCardCollection;?>
		</td>
	</tr>
	<?php }?>
	<?php $dailyCollectionDetails=$this->Html->link('Daily Cash Collection Details Report',array('controller'=>'accounting','action'=>'daily_collection_details','admin'=>false))?>
	<?php if($dailyCollectionDetails){?>
	<tr  class="row_gray">
		<td class="tbLabel">&nbsp;&nbsp;<?php echo $dailyCollectionDetails;?>
		</td>
	</tr>
	<?php }?>
	<?php $UIDReg= $this->Html->link('Total Number Of New Patients',array('controller'=>'reports','action'=>'patient_registration_report','admin'=>true)); ?>
	<?php if($UIDReg){?>
	<tr class="row_gray"><td>&nbsp;&nbsp;<?php echo $UIDReg;?></td>
	</tr>
	<?php }?>
	
	<?php $reg= $this->Html->link('Total New Visits Report',array('controller'=>'reports','action'=>'patient_admission_report','admin'=>true))?>
	<?php if($reg){?>
	<tr class="row_gray"><td>&nbsp;&nbsp;<?php echo $reg;?></td>
	</tr>
	<?php }?>
	<?php $corporateSuperBillReport = $this->Html->link('Corporate Super Bill Report',array('controller'=>'Corporates','action'=>'corporate_super_bill_list','admin'=>false))?>
	<?php if($corporateSuperBillReport){?>
	<tr class="row_gray"><td>&nbsp;&nbsp;<?php echo $corporateSuperBillReport;?></td>
	</tr>
	<?php }?>
</table>

<?php }else{?>

<table id="managerial" width="100%"
	style="border-left: 1px solid #4C5E64; border-right: 1px solid #4C5E64; border-top: 1px solid #4C5E64; margin-top: 20px;">
	<tr class="row_title">
		<td width="10%" height="30px" class="table_cell">Sr. No.</td>
		<td class="table_cell">Name Of Report</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;1</td>
		<td class="tbLabel">&nbsp;
		<!--New Patient Report-->
		Patient Occupancies
			<table id="total_reg">
				<ul class="all_ul">

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total Number Of New Patients',array('controller'=>'reports','action'=>'patient_registration_report','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Company Report',array('controller'=>'reports','action'=>'patient_sponsor_report','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Patient Admission Report',array('controller'=>'reports','action'=>'patient_admission_report','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Region Wise Patient Report',array('controller'=>'reports','action'=>'getRegionWisePatientList','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
						<li class="all_li">&nbsp;<?php echo $this->Html->link('Total Number Of Corporate Patients',array('controller'=>'reports','action'=>'patient_registration_report','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
				</ul>

			</table>
		</td>
	</tr>
	
	<tr>
		<td valign="top">&nbsp;2</td>
		<td class="tbLabel">&nbsp;OT Report(Surgery Reports)
			<table id="total_ad">
				<ul class="all_ul" >
					
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total Surgery Report',array('controller'=>'reports','action'=>'patient_ot_report','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
				</tr>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('OR Utilization Rate',array('controller'=>'reports','action'=>'ot_utilization_rate','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('OR Calendar Report',array('controller'=>'reports','action'=>'ot_list','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Surgery Report',array('controller'=>'reports','action'=>'surgery_report','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Billing Surgery Report',array('controller'=>'reports','action'=>'billing_surgery_report','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
				</ul>
			</table>
		</td>
	</tr>
	
	<tr class="row_gray">
		<td valign="top">&nbsp;3</td>
		<td class="tbLabel">&nbsp;New Visits Report
			<table cellpadding="0" cellspacing='0'>
				<ul class="all_ul">

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Time Taken for Check-in',array('controller'=>'reports','action'=>'ipd_opd','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					</tr>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Patient Check-in Report',array('controller'=>'reports','action'=>'patient_admitted_report','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total New Visit Report By Patient Location',array('controller'=>'reports','action'=>'admission_report_by_patient_location','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					<!--<li class="all_li">&nbsp;<?php echo $this->Html->link('Total New Visits Report',array('controller'=>'reports','action'=>'patient_admission_report','admin'=>true));?>
					</li><li class="all_li">&nbsp;<?php //echo $this->Html->link('Total New Visit Report By Referring Physician',array('controller'=>'reports','action'=>'admission_report_by_reference_doctor','admin'=>true));?>
					</li>-->
				</ul>
			</table>
		</td>
	</tr>
	
	<tr>
		<td valign="top">&nbsp;4</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Total Discharge Report',array('controller'=>'reports','action'=>'patient_discharge_report','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>

	<tr class="row_gray">
		<td valign="top">&nbsp;5</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Average Length of Stay Report',array('controller'=>'reports','action'=>'admin_length_of_stay','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>
	<tr>
		<td valign="top">&nbsp;6</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Bed Occupancy Report',array('controller'=>'reports','action'=>'ward_occupancy_rate','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>
	
	
	<tr class="row_gray">
		<td valign="top">&nbsp;7</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Encounters By Month',array('controller'=>'reports','action'=>'monthly_consultations','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>
	<tr >
		<td valign="top">&nbsp;8</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Encounters By Department',array('controller'=>'reports','action'=>'consultationsby_department','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>

	<tr class="row_gray">
		<td valign="top">&nbsp;9</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Patient Summary By Type Of Payment',array('controller'=>'reports','action'=>'patient_summary','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>
	
	<tr>
		<td valign="top" >&nbsp;10</td>
		<td class="tbLabel">&nbsp;&nbsp;<?php echo $this->Html->link('External Requisition Report',array('controller'=>'Reports','action'=>'external_requisition_reports','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>


	<tr class="row_gray">
		<td valign="top" >&nbsp;11</td>
		<td>&nbsp;&nbsp;<?php echo $this->Html->link('Bed Dashboard Report',array('controller'=>'Wards','action'=>'bedDashboard','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>
	
	<tr class="">
		<td valign="top" >&nbsp;12</td>
		<td>&nbsp;&nbsp;<?php echo $this->Html->link('Submit i-STAT EG7+',array('controller'=>'Reports','action'=>'iStatReport','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>
	
    <tr class="row_gray">
		<td valign="top">&nbsp;13</td>
		<td>&nbsp;<?php echo $this->Html->link('Pharmacy Patients Sales',array('controller'=>'reports','action'=>'productWiseSales','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>

	<tr class="" >
		<td valign="top">&nbsp;14</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Appointment Report',array('controller'=>'reports','action'=>'appointment','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
		</td>
	</tr>
	<tr class="row_gray"> 
		 <td valign="top">&nbsp;15</td> 
		 <td>&nbsp;<?php echo $this->Html->link('Advance Statement',array('controller'=>'Billings','action'=>'advanced_billing', 'admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></td>
	</tr> 
	<tr > 
		 <td valign="top">&nbsp;16</td>  
		 <td>&nbsp;<?php echo $this->Html->link('Discharge Summary Report-All',array('controller'=>'Corporates','action'=>'discharge_summary_report_all', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></td>
	</tr> 
	
	 <tr class="row_gray">
		<td valign="top">&nbsp;17</td>
		<td class="tbLabel ">&nbsp;MIS Reports
			<table id="total_ad">
				<ul class="all_ul">

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Daily Collection Report',array('controller'=>'accounting','action'=>'daily_collection','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Daily Collection Detail Report',array('controller'=>'accounting','action'=>'daily_collection_details','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Daily Cash Collection',array('controller'=>'reports','action'=>'daily_cash_collection','admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Daily Credit Card Collection',array('controller'=>'reports','action'=>'daily_credit_collection', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Daily Cheque Collection and Fund Transfer Details',array('controller'=>'reports','action'=>'daily_check_collection', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Patient Card Report',array('controller'=>'accounting','action'=>'daily_card_collection','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('Department Wise Collection',array('controller'=>'Accounting','action'=>'department_wise_revenue', 'admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Provider Wise Billing',array('controller'=>'reports','action'=>'doctorwise_collection', 'admin'=>true));?>
					</li>
					

					<!--	 <li class="all_li">&nbsp;<?php echo $this->Html->link('Payment Receivable',array('controller'=>'reports','action'=>'payment_dues', 'admin'=>true));?>
					</li>-->
				<!--	<li class="all_li">&nbsp;<?php echo $this->Html->link('Total Concessions',array('controller'=>'reports','action'=>'total_concessions', 'admin'=>true));?>
					</li>-->
				</ul>

			</table>
		</td>
	</tr> 
	
		
	 <tr class="">
		<td valign="top">&nbsp;18</td>
		<td class="tbLabel">&nbsp;Referral Doctor Reports
			<table cellpadding="0" cellspacing='0'>
				<ul class="all_ul">
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Miscellaneous Report',array('controller'=>'reports','action'=>'profit_referral_doctor','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Referal Sharing Report',array('controller'=>'Accounting','action'=>'referralSharingReport','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>  
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Referral Discharge Report',array('controller'=>'Consultants','action'=>'referralDischargeReport','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Referal Report',array('controller'=>'reports','action'=>'referralReport','admin'=>false));?>
					
			 		<li class="all_li">&nbsp;<?php echo $this->Html->link('No shows Patients from Referral Doctor Report',array('controller'=>'reports','action'=>'referral_doc_no_show_patient','admin'=>false));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Arrivals Patients from Referral Doctor Report',array('controller'=>'reports','action'=>'arrived_for_referral_doctor','admin'=>false));?>
					</li>	
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total No. of No shows and Arrivals Patients from Referral Doctor Report',array('controller'=>'reports','action'=>'total_patient_from_referral_doctor','admin'=>false));?>
					</li>		
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total Registration Report By Referral Doctor',array('controller'=>'reports','action'=>'admission_report_by_reference_doctor','admin'=>true));?>
					</li> 
					
			</ul>
			</table>
		</td>
	</tr> 
	<!-- <tr>
		<td valign="top">&nbsp;16</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Immunization',array('controller'=>'Imunization','action'=>'reportImmunization', 'admin'=>false));?>
		</td>
	</tr>-->	

	
	<!-- Advance Billing Report	-->
	
		
 	 <tr class="row_gray"> 
 		<td valign="top">&nbsp;19</td> 
 		<td>&nbsp;Corporate Report 
 			<table id="total_ad"> 
 			<ul class="all_ul">
 			     <li class="all_li">&nbsp;<?php echo $this->Html->link('Month Wise Patients',array('controller'=>'Corporates','action'=>'admin_corporate_vice_patient', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>

                <li class="all_li">&nbsp;<?php echo $this->Html->link('Corporate Admitted Patients',array('controller'=>'Corporates','action'=>'admin_corporate_patient', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>
             <!--   <li class="all_li">&nbsp;<?php echo $this->Html->link('Corporate Vice Patients',array('controller'=>'Corporates','action'=>'admin_corporate_vice_patient', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>-->

            	<!--<li class="all_li">&nbsp;<?php echo $this->Html->link('Corporate Vice Patients',array('controller'=>'Corporates','action'=>'admin_corporate_vice_patient','admin'=>false));?></li>-->
             				
 				<li class="all_li">&nbsp;<?php echo $this->Html->link('Corporate Outstanding Report',array('controller'=>'Corporates','action'=>'other_outstanding_report', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>
 				 				<li class="all_li">&nbsp;<?php echo $this->Html->link('Month Wise Aging Statement',array('controller'=>'Corporates','action'=>'month_outstanding_report', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>

                <li class="all_li">&nbsp;<?php echo $this->Html->link('WCL Monthwise',array('controller'=>'Corporates','action'=>'wcl_report_monthwise', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>

 				<li class="all_li">&nbsp;<?php echo $this->Html->link('WCL Datewise',array('controller'=>'Corporates','action'=>'wcl_report', 'admin'=>true));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>

				

				<li class="all_li">&nbsp;<?php echo $this->Html->link('Corporate Receivable Report',array('controller'=>'accounting','action'=>'corporate_receivable','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>

				<?php $corporateSuperBillReport = $this->Html->link('Corporate Super Bill Report',array('controller'=>'Corporates','action'=>'corporate_super_bill_list','admin'=>false))?>
					<?php if($corporateSuperBillReport){?>
					<li class="all_li">&nbsp;&nbsp;<?php echo $corporateSuperBillReport;?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>
				<?php }?>
					                
 			 	<li class="all_li">&nbsp;<?php  echo $this->Html->link('BSNL',array('controller'=>'Corporates','action'=>'bsnl_report', 'admin'=>true));?></li>
                 
                <li class="all_li">&nbsp;<?php echo $this->Html->link('CGHS (Ordnance Factory Chanda )',array('controller'=>'Corporates','action'=>'cghs_report', 'admin'=>true));?></li>

                <li class="all_li">&nbsp;<?php echo $this->Html->link('ECHS',array('controller'=>'Corporates','action'=>'echs_report', 'admin'=>true));?></li>

                <li class="all_li">&nbsp;<?php echo $this->Html->link('Mahindra & Mahindra',array('controller'=>'Corporates','action'=>'mahindra_report', 'admin'=>true));?></li>

                <li class="all_li">&nbsp;<?php echo $this->Html->link('FCI',array('controller'=>'Corporates','action'=>'fci_report', 'admin'=>true));?></li>

 				<li class="all_li">&nbsp;<?php echo $this->Html->link('Raymond',array('controller'=>'Corporates','action'=>'raymond_report', 'admin'=>true));?></li>
 				
 				<li class="all_li">&nbsp;<?php  echo $this->Html->link('MPKAY',array('controller'=>'Corporates','action'=>'mpkay_report', 'admin'=>true));?></li>
                                
                <li class="all_li">&nbsp;<?php echo $this->Html->link('MJPJAY Outstanding Report',array('controller'=>'Corporates','action'=>'rgjay_outstanding_report', 'admin'=>true));?></li>

 				<li class="all_li">&nbsp;<?php  echo $this->Html->link('MJPJAY Payment Received Report.',array('controller'=>'Corporates','action'=>'rgjay_payment_received_report', 'admin'=>true));?> </li>
 				<li class="all_li">&nbsp;<?php echo $this->Html->link('MJPJAY Tasks Report.',array('controller'=>'Corporates','action'=>'rgjay_tasks_report', 'admin'=>true));?></li>
 				<li class="all_li">&nbsp;<?php echo $this->Html->link('MJPJAY Report',array('controller'=>'corporates','action'=>'rgjay_report', 'admin'=>true));?></li>

 				<li class="all_li">&nbsp;<?php echo $this->Html->link('MJPJAY Package & Pharmacy Sales',array('controller'=>'reports','action'=>'getRgjayPackageAndPharmacyAmount','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>

				<li class="all_li">&nbsp;<?php echo $this->Html->link('MJPJAY INCOME',array('controller'=>'Corporates','action'=>'rgjay_income_report','admin'=>false));?><?php echo $this->Html->image('/img/icons/green_tick.png');?></li>

 			
        	</ul>
				</table>
 				</td>
		</tr>
	<tr class="">
		<td valign="top">&nbsp;20</td>
		<td class="tbLabel">&nbsp; Pharmacy Reports
			<table id="total_ad">
				<ul class="all_ul" >
					
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Pharmacy Purchase Report',array('controller'=>'reports','action'=>'purchase_report','admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('Pharmacy Sales Report',array('controller'=>'reports','action'=>'sales_report','admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Expensive Product Report',array('controller'=>'reports','action'=>'expensive_product_report','admin'=>false));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Party wise Purchase Report',array('controller'=>'reports','action'=>'party_wise_purchase_report','admin'=>true));?>
					</li>
				<!--  	<li class="all_li">&nbsp;<?php echo $this->Html->link('Patient wise Sale Report',array('controller'=>'reports','action'=>'patient_wise_sale','admin'=>true));?>
					</li> 
					<li class="all_li">&nbsp;<?php  echo $this->Html->link('Product wise Sale Report',array('controller'=>'reports','action'=>'product_wise_sale','admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Purchase Day Book Report',array('controller'=>'reports','action'=>'purchase_day_book','admin'=>true));?>
					</li> 
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Sale Day Book',array('controller'=>'reports','action'=>'sale_day_book','admin'=>true));?>
					</li> 
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Receipt & Payment A/C Report',array('controller'=>'reports','action'=>'receipt_payment_account','admin'=>true));?>
					</li>  -->
				</ul>
			</table>
		</td>
	</tr>
	
	<tr class="row_gray">
		<td valign="top">&nbsp;21</td>
		<td class="tbLabel">&nbsp;<?php echo __('Groupwise for Accouting Reports');?>
		<table> 
 			<ul class="all_ul">

					<li class="all_li">
					<?php echo $this->Html->link('Expense Report',array('controller'=>'HR','action'=>'expense_main', 'admin'=>false));?></li>
					<li class="all_li"><?php  echo $this->Html->link('Income Report',array('controller'=>'HR','action'=>'income_sheet', 'admin'=>false));?></li>
 			</ul>
 	   </table>
		</td>
	</tr>
	<tr >
		<td valign="top">&nbsp;22</td>
		<td class="tbLabel">&nbsp;Survey Reports
			<table id="total_ad">
				<ul class="all_ul">

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Staff Survey Report',array('controller'=>'reports','action'=>'staffsurvey_reports','admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Patient Survey Report',array('controller'=>'reports','action'=>'patient_survey_type', 'admin'=>true));?>
					</li>
				</ul>
			</table>
		</td>
	</tr>
	
	<!--<tr class="row_gray">
		<td valign="top">&nbsp;5</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('SSI Report',array('controller'=>'reports','action'=>'surgical_site_infections','admin'=>true));?>
		</td>
	</tr>-->
 
	<tr class="row_gray">
		<td valign="top">&nbsp;23</td>
		<td class="tbLabel">&nbsp;Hospital Associated Infections Reports
			<table id="total_ad">
				<ul class="all_ul" >
					
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Hospital Associated Infections Cases',array('controller'=>'reports','action'=>'hospital_acquire_infections_reports','admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('Hospital Associated Infections Rate',array('controller'=>'reports','action'=>'hai_cent', 'admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('SSI Rate',array('controller'=>'reports','action'=>'ssirate', 'admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('UTI Rate',array('controller'=>'reports','action'=>'utirate', 'admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('VAP Rate',array('controller'=>'reports','action'=>'vaprate', 'admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('BSI Rate',array('controller'=>'reports','action'=>'bsirate', 'admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('Thrombophlebitis Rate',array('controller'=>'reports','action'=>'thrombophlebitisrate', 'admin'=>true));?>
					</li>
				</ul>


			</table>
		</td>
	</tr>
	<tr class="">
		<td valign="top">&nbsp;24</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Total Number of Anesthesia',array('controller'=>'reports','action'=>'total_anesthesia','admin'=>true));?>
		</td>
	</tr> 
	<tr class="row_gray">
		<td valign="top">&nbsp;25</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Waiting Time For Initial Assessment',array('controller'=>'reports','action'=>'initial_assessment_time','admin'=>true));?>
		</td>
	</tr>
	<tr class="">
		<td valign="top">&nbsp;26</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Time Taken For Initial Assessment ', array('controller'=>'reports','action'=>'time_taken_initial_assessment','admin'=>true));?>
		</td>
	</tr>

	

	<tr class="row_gray" >
		<td valign="top">&nbsp;27</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Total Number of Patient Readmitted to ICU within 48 hrs',array('controller'=>'reports','action'=>'patient_readmitted_to_icu','admin'=>true));?>
		</td>
	</tr>
	<tr class="">
		<td valign="top">&nbsp;28</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Time Taken For Discharge',array('controller'=>'reports','action'=>'time_taken_for_discharge','admin'=>true));?>
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;29</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Hospital Turnover Rate',array('controller'=>'reports','action'=>'tor','admin'=>true));?>
		</td>
	</tr>
	
	<tr class="">
		<td valign="top">&nbsp;30</td> 
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Complaints',array('controller'=>'reports','action'=>'complaints','admin'=>true));?>
		</td> 
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;31</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Mortality Rate',array('controller'=>'reports','action'=>'birth_death', 'admin'=>true));?>
		</td>
	</tr>
	<tr >
		<td valign="top">&nbsp;32</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Insurance Status Report',array('controller'=>'reports','action'=>'card_patients_status', 'admin'=>true));?>
		</td>
	</tr>
	<!--  RGJAY Report	-->			
	<!-- <tr class="row_gray">
				 <td valign="top">&nbsp;33</td> 
				 <td>&nbsp;<?php echo $this->Html->link('RGJAY Report',array('controller'=>'corporates','action'=>'rgjay_report', 'admin'=>true));?></td>
			</tr> -->
			
	<!--  Surgery Report	-->
	<tr class=""> 
 				 <td valign="top">&nbsp;34</td>  
				 <td>&nbsp;<?php echo $this->Html->link('Surgeon Payment Report',array('controller'=>'corporates','action'=>'surgeon_payment_report', 'admin'=>true));?></td>
 	</tr> 
				
	<!--  Discharge Report	-->
 	<tr class="row_gray"> 
				 <td valign="top">&nbsp;35</td>  
				 <td>&nbsp;<?php echo $this->Html->link('Discharge Report-Private',array('controller'=>'Corporates','action'=>'discharge_report', 'admin'=>true));?></td>
	</tr> 
	<!--  Discharge  summary Report All Patients	-->
 	
	

	<!--Company  Discharge Report -->
	<tr > 
		 <td valign="top">&nbsp;36</td> 
		 <td>&nbsp;<?php echo $this->Html->link('Discharge Report-Company',array('controller'=>'corporates','action'=>'company_discharge_report', 'admin'=>true));?></td>
 	</tr> 

	<tr class="row_gray">
		<td valign="top" >&nbsp;37</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Profit & Loss statement',array('controller'=>'HR','action'=>'profitLossStatement','admin'=>false));?>
		</td>
	</tr>
	 <tr>
		<td valign="top">&nbsp;38</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Patient History Report',array('controller'=>'Billings','action'=>'billingReceiptReport','admin'=>false));?>
		</td>
	</tr> 
	<tr class="row_gray">
		<td valign="top" >&nbsp;39</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Nursing Outstanding Report',array('controller'=>'Billings','action'=>'patient_outstanding_report','admin'=>false));?>
		</td>
	</tr>
	
	<tr class="">
		<td valign="top" >&nbsp;40</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Service Wise Collection Report',array('controller'=>'accounting','action'=>'service_wise_collection','admin'=>false));?>
		</td>
	</tr>
	
	<tr class="row_gray">
		<td valign="top">&nbsp;41</td>
		<td>&nbsp;<?php echo $this->Html->link('Total Income Receipt',array('controller'=>'reports','action'=>'total_receipt','admin'=>true));?>
		</td>
	</tr>
	<tr class="">
		<td valign="top">&nbsp;42</td>
		<td>&nbsp;<?php echo $this->Html->link('Diagnosis Report',array('controller'=>'reports','action'=>'diagnosisReport','admin'=>false));?>
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;43</td>
		<td>&nbsp;<?php echo $this->Html->link('HR Payment',array('controller'=>'accounting','action'=>'hrPayment','admin'=>false));?>
		</td>
	</tr>

	<tr class="">
		<td valign="top">&nbsp;44</td>
		<td>&nbsp;<?php echo $this->Html->link('ATTENDANCE REPORT',array('controller'=>'reports','action'=>'attendanceReport','admin'=>false));?>
		</td>
	</tr>
	<tr class="">
		<td valign="top">&nbsp;45</td>
		<td>&nbsp;<?php echo $this->Html->link('Camp Report',array('controller'=>'reports','action'=>'police_camp_report','admin'=>false));?>
		</td>
	</tr>
	
	<tr class="">
		<td valign="top">&nbsp;46</td>
	
	    	<td>&nbsp;<?php echo $this->Html->link('Amount Paid To Doctor',array('controller'=>'Accounting','action'=>'amount_paid_doctors','admin'=>false));?>
		</td>
	</tr>
	<!--

	// all commented reports 


	 <tr class="row_gray">
				 <td valign="top">&nbsp;18</td> 
				 <td>&nbsp;<?php echo $this->Html->link('Overstay Customers',array('controller'=>'reports','action'=>'overstay_customers', 'admin'=>false));?></td>
	</tr>
	<tr>
		<td valign="top">&nbsp;23</td>
		<td>&nbsp;<?php echo $this->Html->link('X-Ray utilization Rate',array('controller'=>'reports','action'=>'x_ray_utilization_report','admin'=>true));?></td>
	</tr> 
	 <tr class="row_gray">
		<td valign="top">&nbsp;15</td>
		<td>&nbsp;<?php // echo $this->Html->link('ICU Utilization Rate',array('controller'=>'reports','action'=>'icu_utilization_report','admin'=>true));?>
		</td>
	</tr> -->

	<!--	<tr>
		<td valign="top">&nbsp;8</td>
		<td class="tbLabel">&nbsp;Incident Report
			<table id="total_ad">
				<ul class="all_ul" >
					
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total Incident Report',array('controller'=>'reports','action'=>'incedence_report','admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('Particular Incident Report',array('controller'=>'reports','action'=>'perticular_incident_report','admin'=>true));?>
					</li>
				</ul>
			</table>
		</td>
	</tr> -->
	<!--<tr class="row_gray">
		<td valign="top">&nbsp;25</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Laundry Items Management - Report',array('controller'=>'laundries','action'=>'laundry_report', 'inventory'=>true));?>
		</td>
	</tr> -->
	<!-- commented by amit jain <tr class="">
		<td valign="top" >&nbsp;45</td>
		<td>&nbsp;&nbsp;<?php echo $this->Html->link('Marketing Team Collection Report',array('controller'=>'Reports','action'=>'marketing_team_collection','admin'=>false));?>
		</td>
	</tr> -->
	
<!-- 	<tr class="row_gray">
		<td valign="top">&nbsp;11</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Clinical Quality Measure For EP',array('controller'=>'reports','action'=>'clinical_quality_measure', 'admin'=>true));?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">&nbsp;28</td>

		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Clinical Quality Measure For EH',array('controller'=>'reports','action'=>'admin_eh'));?>
		</td>
	</tr>
	
	<tr >
		<td valign="top">&nbsp;8</td>

		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Patient List',array('controller'=>'reports','action'=>'patient_list', 'admin'=>true));?>
		</td>
	</tr> -->
<!-- 	<tr class="row_gray"> -->
<!-- 		<td valign="top">&nbsp;13</td> 
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Measure Calculation',array('controller'=>'reports','action'=>'auto_measure_calculation', 'admin'=>true));?>
		</td> 
<!-- 	</tr> -->
	<!-- 
	<tr class="row_gray">
		<td valign="top">&nbsp;31</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Adverse Event',array('controller'=>'innovations','action'=>'adverse_events', 'admin'=>false));?>
		</td>
	</tr>
	<tr>
		<td valign="top">&nbsp;32</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Hospital Aquired Infection Tracking',array('controller'=>'reports','action'=>'hospinfection'));?>
		</td>
	</tr>
	<tr>
		<td valign="top">&nbsp;33</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Tracking Board',array('controller'=>'users','action'=>'doctor_dashboard','admin'=>false));?>
		</td>
	</tr>
	<tr>
		<td valign="top">&nbsp;34</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Readmission Rate',array('controller'=>'reports','action'=>'readmission', 'admin'=>true));?>
		</td>
	</tr>
	
	<tr class="row_gray">
		<td valign="top">&nbsp;9</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Customize Charts DashBoard',array('controller'=>'users','action'=>'customize_chart_dashboard', 'admin'=>false));?>
		</td>
	</tr> -->
<!-- 	<tr class="row_gray"> -->
<!-- 		<td valign="top">&nbsp;15</td> -->
<!-- 		<td class="tbLabel">&nbsp;Lab & Rad Reports -->
<!-- 			<table cellpadding="0" cellspacing='0'> -->
<!-- 				<ul class="all_ul"> -->
<!--					<li class="all_li">&nbsp;<?php //echo $this->Html->link('Over Due Lab Test Results Report',array('controller'=>'Laboratories','action'=>'labOverdueTestReport','admin'=>false));?>-->
<!-- 					</li> -->
<!--					<li class="all_li">&nbsp;<?php //echo $this->Html->link('Over Due Rad Test Results Report',array('controller'=>'Radiologies','action'=>'radOverdueTestReport','admin'=>false));?>-->
<!-- 					</li> -->
<!--					<li class="all_li">&nbsp;<?php //echo $this->Html->link('Abnormal Lab Test Results',array('controller'=>'Laboratories','action'=>'labAbnormalTestReport','admin'=>false));?>-->
<!-- 					</li> -->
<!--					<li class="all_li">&nbsp;<?php //echo $this->Html->link('Abnormal Rad Test Results',array('controller'=>'Radiologies','action'=>'radAbnormalTestReport','admin'=>false));?>-->
<!-- 					</li> -->
<!-- 				</ul> -->
<!-- 			</table> -->
<!-- 		</td> -->
<!-- 	</tr> -->
<!-- 	<tr class="row_gray"> -->
<!-- 		<td valign="top">&nbsp;16</td> -->
<!-- 		<td class="tbLabel">&nbsp;Milestones of residents for ACGME -->
<!-- 			<table cellpadding="0" cellspacing='0'> -->
<!-- 				<ul class="all_ul"> -->
<!-- 					<li class="all_li">&nbsp;<?php echo $this->Html->link('Residents Overdue Report',array('controller'=>'MeaningfulReport','action'=>'resident_overdue_report','admin'=>false));?>-->
<!-- 					</li> -->
<!-- 					<li class="all_li">&nbsp;<?php echo $this->Html->link('Overall Milestones of Residents',array('controller'=>'MeaningfulReport','action'=>'resident_overall_milestone','admin'=>false));?>-->
<!-- 					</li> -->
					
<!-- 				</ul> -->
<!-- 			</table> -->
<!-- 		</td> -->
<!-- 	</tr>
	<tr >
		<td valign="top">&nbsp;10</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Department-wise Receipts Report',array('controller'=>'Users','action'=>'profitDepartment','admin'=>false));?>
			
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;11</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Physician-wise Profit Sharing Receipts Report',array('controller'=>'Users','action'=>'profitPhysician','admin'=>false));?>
			
		</td>
	</tr>
	<tr >
		<td valign="top">&nbsp;12</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Number of VIP Patients Report',array('controller'=>'Reports','action'=>'no_of_freevip','admin'=>false));?>
			
		</td>
	</tr> 
	<tr class="row_gray">
		<td valign="top">&nbsp;13</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Number of Follow Up Patients',array('controller'=>'Reports','action'=>'no_of_followup','admin'=>false));?>
			
		</td>
	</tr> -->
	
</table>
<?php }?>
<script>

</script>
