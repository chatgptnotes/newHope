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
		<?php echo __('Reports Management', true); ?>
	</h3>
</div>

<table id="managerial" width="50%"
	style="border-left: 1px solid #4C5E64; border-right: 1px solid #4C5E64; border-top: 1px solid #4C5E64; margin-top: 20px;">
	<tr class="row_title">
		<td width="10%" height="30px" class="table_cell">Sr. No.</td>
		<td class="table_cell">Name Of Report</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;1</td>
		<td class="tbLabel">&nbsp;New Patient Report
			<table id="total_reg">
				<ul class="all_ul">

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total Number Of New Patients',array('controller'=>'reports','action'=>'patient_registration_report','admin'=>true));?>
					</li>


					<li class="all_li">&nbsp;<?php echo $this->Html->link('Company Report',array('controller'=>'reports','action'=>'patient_sponsor_report','admin'=>true));?>
					</li>
				</ul>

			</table>
		</td>
	</tr>
	<!-- gaurav
	<tr>
		<td valign="top">&nbsp;2</td>
		<td class="tbLabel">&nbsp;OR Report
			<table id="total_ad">
				<ul class="all_ul" >
					
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total Surgery Report',array('controller'=>'reports','action'=>'patient_ot_report','admin'=>true));?>
					</li>
				</tr>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('OR Utilization Rate',array('controller'=>'reports','action'=>'ot_utilization_rate','admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('OR Calendar Report',array('controller'=>'reports','action'=>'ot_list','admin'=>true));?>
					</li></ul>
			</table>
		</td>
	</tr>
	 -->
	<tr>
		<td valign="top">&nbsp;2</td>
		<td class="tbLabel">&nbsp;New Visits Report
			<table cellpadding="0" cellspacing='0'>
				<ul class="all_ul">

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total New Visits Report',array('controller'=>'reports','action'=>'patient_admission_report','admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Time Taken for Check-in',array('controller'=>'reports','action'=>'ipd_opd','admin'=>true));?>
					</li>
					</tr>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Patient Check-in Report',array('controller'=>'reports','action'=>'patient_admitted_report','admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total New Visit Report By Referring Physician',array('controller'=>'reports','action'=>'admission_report_by_reference_doctor','admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total New Visit Report By Patient Location',array('controller'=>'reports','action'=>'admission_report_by_patient_location','admin'=>true));?>
					</li>
				</ul>
			</table>
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;3</td>
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
	<!--  gaurav
	<tr class="row_gray">
		<td valign="top">&nbsp;5</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('SSI Report',array('controller'=>'reports','action'=>'surgical_site_infections','admin'=>true));?>
		</td>
	</tr>
 
	<tr>
		<td valign="top">&nbsp;6</td>
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
	<tr class="row_gray">
		<td valign="top">&nbsp;7</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Total Discharge Report',array('controller'=>'reports','action'=>'patient_discharge_report','admin'=>true));?>
		</td>
	</tr>
	
	<tr>
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
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;9</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Average Length of Stay Report',array('controller'=>'reports','action'=>'admin_length_of_stay','admin'=>true));?>
		</td>
	</tr>
	<tr>
		<td valign="top">&nbsp;10</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Bed Occupancy Report',array('controller'=>'reports','action'=>'ward_occupancy_rate','admin'=>false));?>
		</td>
	</tr>
	-->
	<tr>
		<td valign="top">&nbsp;4</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Encounters By Month',array('controller'=>'reports','action'=>'monthly_consultations','admin'=>true));?>
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;5</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Encounters By Department',array('controller'=>'reports','action'=>'consultationsby_department','admin'=>true));?>
		</td>
	</tr>
	<!-- 
	<tr class="row_gray">
		<td valign="top">&nbsp;13</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Patient Summary By Type Of Payment',array('controller'=>'reports','action'=>'patient_summary','admin'=>true));?>
		</td>
	</tr>
	 -->
	<!--<tr>
		<td valign="top">&nbsp;6</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Total Number of Anesthesia',array('controller'=>'reports','action'=>'total_anesthesia','admin'=>true));?>
		</td>
	</tr> 
	<tr class="row_gray">
		<td valign="top">&nbsp;6</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Waiting Time For Initial Assessment',array('controller'=>'reports','action'=>'initial_assessment_time','admin'=>true));?>
		</td>
	</tr>
	<tr>
		<td valign="top">&nbsp;7</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Time Taken For Initial Assessment ', array('controller'=>'reports','action'=>'time_taken_initial_assessment','admin'=>true));?>
		</td>
	</tr>-->

	<!-- <tr>
		<td valign="top">&nbsp;17</td>
		<td>&nbsp;<?php echo $this->Html->link('ICU Utilization Rate',array('controller'=>'reports','action'=>'icu_utilization_report','admin'=>true));?>
		</td>
	</tr> -->
	<!-- gaurav
	<tr class="row_gray">
		<td valign="top">&nbsp;17</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Total Number of Patient Readmitted to ICU within 48 hrs',array('controller'=>'reports','action'=>'patient_readmitted_to_icu','admin'=>true));?>
		</td>
	</tr>
	<tr>
		<td valign="top">&nbsp;18</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Time Taken For Discharge',array('controller'=>'reports','action'=>'time_taken_for_discharge','admin'=>true));?>
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;19</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Hospital Turnover Rate',array('controller'=>'reports','action'=>'tor','admin'=>true));?>
		</td>
	</tr>
	 -->
<!-- 	<tr class="row_gray">
		<td valign="top">&nbsp;8</td> 
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Complaints',array('controller'=>'reports','action'=>'complaints','admin'=>true));?>
		</td> 
<!-- 	</tr> -->
	<!--<tr>
		<td valign="top">&nbsp;23</td>
		<td>&nbsp;<?php //echo $this->Html->link('X-Ray utilization Rate',array('controller'=>'reports','action'=>'x_ray_utilization_report','admin'=>true));?></td>
	</tr> -->
	<!-- <tr>
		<td valign="top">&nbsp;9</td>
		<td class="tbLabel">&nbsp;MIS Reports
			<table id="total_ad">
				<ul class="all_ul">

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Daily Cash Collection',array('controller'=>'reports','action'=>'daily_cash_collection','admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Daily Credit Card Collection',array('controller'=>'reports','action'=>'daily_credit_collection', 'admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Daily Cheque Collection and Fund Transfer Details',array('controller'=>'reports','action'=>'daily_check_collection', 'admin'=>true));?>
					</li>
					 <li class="all_li">&nbsp;<?php //echo $this->Html->link('Payment Receivable',array('controller'=>'reports','action'=>'payment_dues', 'admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Provider Wise Billing',array('controller'=>'reports','action'=>'doctorwise_collection', 'admin'=>true));?>
					</li>
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Total Concessions',array('controller'=>'reports','action'=>'total_concessions', 'admin'=>true));?>
					</li>
				</ul>

			</table>
		</td>
	</tr> -->
	<tr >
		<td valign="top">&nbsp;6</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Appointment Report',array('controller'=>'reports','action'=>'appointment','admin'=>true));?>
		</td>
	</tr>
	<!-- 
	<tr class="row_gray">
		<td valign="top">&nbsp;23</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Mortality Rate',array('controller'=>'reports','action'=>'birth_death', 'admin'=>true));?>
		</td>
	</tr>

	<tr>
		<td valign="top">&nbsp;24</td>
		<td class="tbLabel">&nbsp; Pharmacy Reports
			<table id="total_ad">
				<ul class="all_ul" >
					
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Pharmacy Purchase Report',array('controller'=>'reports','action'=>'purchase_report','admin'=>true));?>
					</li>
				<li class="all_li">&nbsp;<?php echo $this->Html->link('Pharmacy Sales Report',array('controller'=>'reports','action'=>'sales_report','admin'=>true));?>
					</li>
				</ul>
			</table>
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;25</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Laundry Items Management - Report',array('controller'=>'laundries','action'=>'laundry_report', 'inventory'=>true));?>
		</td>
	</tr>
	 -->
	<!-- <tr class="row_gray">
		<td valign="top">&nbsp;7</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Insurance Status Report',array('controller'=>'reports','action'=>'card_patients_status', 'admin'=>true));?>
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
	 -->
	<!-- <tr >
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
	 -->
	<!-- <tr class="row_gray">
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
<!-- 	</tr> -->
	<tr >
		<td valign="top">&nbsp;7</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Department-wise Receipts Report',array('controller'=>'Users','action'=>'profitDepartment','admin'=>false));?>
			
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;8</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Physician-wise Profit Sharing Receipts Report',array('controller'=>'Users','action'=>'profitPhysician','admin'=>false));?>
			
		</td>
	</tr>
	<tr >
		<td valign="top">&nbsp;9</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Number of VIP Patients Report',array('controller'=>'Reports','action'=>'no_of_freevip','admin'=>false));?>
			
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;10</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Number of Follow Up Patients',array('controller'=>'Reports','action'=>'no_of_followup','admin'=>false));?>
			
		</td>
	</tr>
	<!-- <tr class="row_gray">
		<td valign="top">&nbsp;21</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Total Registration Report By Referral Doctor',array('controller'=>'reports','action'=>'admission_report_by_reference_doctor','admin'=>true));?></td>
	
	</tr> -->
	<tr >
		<td valign="top">&nbsp;11</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Daily Cash Collection',array('controller'=>'reports','action'=>'daily_cash_collection','admin'=>true));?></td>
			
		</tr>
		
	<tr class="row_gray">
		<td valign="top">&nbsp;12</td>
		<td class="tbLabel">&nbsp;Referral Doctor Reports
			<table cellpadding="0" cellspacing='0'>
				<ul class="all_ul">
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Referral Doctor-wise Receipts Report',array('controller'=>'reports','action'=>'profit_referral_doctor','admin'=>false));?>
					</li>
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
	 <!--<tr>
		<td valign="top">&nbsp;16</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Immunization',array('controller'=>'Imunization','action'=>'reportImmunization', 'admin'=>false));?>
		</td>
	</tr>-->

	
	<!--------------------------  Advance Billing Report	---------------------------->
	<tr > 
				 <td valign="top">&nbsp;13</td> 
				 <td>&nbsp;<?php echo $this->Html->link('Advance Statement',array('controller'=>'Billings','action'=>'advanced_billing', 'admin'=>false));?></td>
	</tr> 
	
	<!---------------------------------  RGJAY Report	-------------------------------->			
	<!-- <tr class="row_gray">
				 <td valign="top">&nbsp;26</td> 
				 <td>&nbsp;<?php echo $this->Html->link('RGJAY Report',array('controller'=>'corporates','action'=>'rgjay_report', 'admin'=>true));?></td>
			</tr> -->
				
	<!---------------------------------  Surgery Report	-------------------------------->
	<tr class="row_gray"> 
 				 <td valign="top">&nbsp;14</td>  
				 <td>&nbsp;<?php echo $this->Html->link('Surgeon payment report',array('controller'=>'corporates','action'=>'surgeon_payment_report', 'admin'=>true));?></td>
 	</tr>
				
	<!---------------------------------  Discharge Report	-------------------------------->
 	<tr > 
				 <td valign="top">&nbsp;15</td>  
				 <td>&nbsp;<?php echo $this->Html->link('Discharge Report-Private',array('controller'=>'Corporates','action'=>'discharge_report', 'admin'=>true));?></td>
	</tr> 
	<!---------------------------------  Discharge  summary Report All Patients	-------------------------------->
 	<tr > 
				 <td valign="top">&nbsp;16</td>  
				 <td>&nbsp;<?php echo $this->Html->link('Discharge Summary Report-All',array('controller'=>'Corporates','action'=>'discharge_summary_report_all', 'admin'=>true));?></td>
	</tr> 
	

				<!---------------------------------Company  Discharge Report -------------------------------->
	<tr class="row_gray"> 
				 <td valign="top">&nbsp;17</td> 
				 <td>&nbsp;<?php echo $this->Html->link('Discharge Report-Company',array('controller'=>'corporates','action'=>'company_discharge_report', 'admin'=>true));?></td>
 	</tr> 
<!-- <tr class="row_gray">
				 <td valign="top">&nbsp;18</td> 
				 <td>&nbsp;<?php echo $this->Html->link('Overstay Customers',array('controller'=>'reports','action'=>'overstay_customers', 'admin'=>false));?></td>
	</tr> -->	
 	<!--  <tr class="row_gray"> 
 		<td valign="top">&nbsp;30</td> 
 		<td>&nbsp;Outstanding Reports 
 			<table id="total_ad"> 
 				<tr> 
 					<td valign="top">=></td> 
					<td>&nbsp;<?php echo $this->Html->link('BHEL',array('controller'=>'Corporates','action'=>'bhel_outstanding_report','admin'=>true));?></td>
 				</tr> 
 				<tr> 
 					<td valign="top">=></td> 
					<td>&nbsp;<?php  echo $this->Html->link('BSNL',array('controller'=>'Corporates','action'=>'bsnl_report', 'admin'=>true));?></td>
 				</tr> 
                 <tr> 
 					<td>=></td> 
					<td>&nbsp;<?php echo $this->Html->link('CGHS (Ordnance Factory Chanda )',array('controller'=>'Corporates','action'=>'cghs_report', 'admin'=>true));?></td>
 				</tr> 
                                 <tr> 
 					<td>=></td> 
					<td>&nbsp;<?php echo $this->Html->link('ECHS',array('controller'=>'Corporates','action'=>'echs_report', 'admin'=>true));?></td>
 				</tr> 
                                 <tr> 
 					<td>=></td> 
					<td>&nbsp;<?php echo $this->Html->link('Mahindra & Mahindra',array('controller'=>'Corporates','action'=>'mahindra_report', 'admin'=>true));?></td>
 				</tr> 
                 <tr> 
 					<td>=></td> 
					<td>&nbsp;<?php echo $this->Html->link('FCI',array('controller'=>'Corporates','action'=>'fci_report', 'admin'=>true));?></td>
 				</tr> 
 				<tr> 
 					<td>=></td>
					<td>&nbsp;<?php echo $this->Html->link('Raymond',array('controller'=>'Corporates','action'=>'raymond_report', 'admin'=>true));?></td>
 				</tr>
 				<tr> 
 					<td>=></td>
					<td>&nbsp;<?php echo $this->Html->link('WCL',array('controller'=>'Corporates','action'=>'wcl_report', 'admin'=>true));?></td>
 				</tr> 
 				<tr> 
 					<td>=></td> 
					<td>&nbsp;<?php  echo $this->Html->link('MPKAY',array('controller'=>'Corporates','action'=>'mpkay_report', 'admin'=>true));?></td>
 				</tr> 
 				<tr> 
 					<td>=></td>
					<td>&nbsp;<?php echo $this->Html->link('RGJAY Outstanding Report',array('controller'=>'Corporates','action'=>'rgjay_outstanding_report', 'admin'=>true));?></td>
 				</tr> 
 				<tr> 
 					<td>=></td> 
					<td>&nbsp;<?php  echo $this->Html->link('RGJAY Payment Received Report.',array('controller'=>'Corporates','action'=>'rgjay_payment_received_report', 'admin'=>true));?> </td>
 				</tr> 
 				<tr> 
 					<td>=></td>
					<td>&nbsp;<?php echo $this->Html->link('RGJAY Tasks Report.',array('controller'=>'Corporates','action'=>'rgjay_tasks_report', 'admin'=>true));?></td>
 				</tr> 
				
				</table>
 				</td>
				</tr>  -->
				
			

</table>

