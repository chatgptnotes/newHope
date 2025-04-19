<style>
 .ui-menu-item{
    color: black !important;
    cursor: pointer;
    list-style-image: url("../img/ui-icons_454545_256x240.png");
    margin: 0;
    min-height: 0;
    padding: 3px 1em 3px 0.4em;
    position: relative;
   
   }
  .ui-menu { width: 300px !important;
    color: #31859c !important;
    font-size: 12px;
    padding: -1 17px !important;
    line-height: 18px;
}
.ui-menu-item a {
    display: block;
    font-weight: normal;
    line-height: 1.5;
    min-height: 0;
    text-decoration: none;
}
 .ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited {
    background-color: white ;
    color: #ffffff;
    text-decoration: none;
}
 .sty{
    margin-left: 20px !important;
    padding-top: 33px !important;
     position: absolute!important;
    z-index: 2000 !important;
}
.ui-menu {
    color: blue !important;
    font-size: 12px !important;
    line-height: 21px !important;
}
</style>
<?php 
 echo $this->Html->script(array('jquery-ui-1.10.2.js','jquery-ui-1.11.2.js'));
 echo $this->Html->css(array('jquery-ui-1.11.2.css')); ?>

</script>
<style>
.ui-menu { width: 160px;
color: #31859c !important;
	font-size: 13px;
	line-height: 30px; 
	padding: 0 17px; }
</style>
<body>
	<div style="padding-top:15px;">
		<?php 
			echo $this->Html->image('icons/arrRight.jpg',array('title' => 'Reports Menu','escape' => false,'id'=>'hideAndShow')); 
		?>
	 </div> 	
<div class="sty" id="reportMenuList">
<ul id="menu" class="ss">

<li>New Patient Report
	<ul>
		<li><?php echo $this->Html->link('Total Number Of New Patients',array('controller'=>'reports','action'=>'patient_registration_report','admin'=>true),array('alt' => 'Add Item'));?></li>
		<li><?php echo $this->Html->link('Company Report',array('controller'=>'reports','action'=>'patient_sponsor_report','list','admin'=>true),array('alt' => 'Item List'));?></li>	
	</ul>
</li>
<li>OR Report
	<ul> 
		<li><?php echo  $this->Html->link('Total Surgery Report',array('controller'=>'reports','action'=>'patient_ot_report','admin'=>true),array('alt' => 'Add Item Rate'));?></li>
		<li><?php echo  $this->Html->link('OR Utilization Rate',array('controller'=>'reports','action'=>'ot_utilization_rate','admin'=>true),array('alt' => 'Item Rate List'));?></li>
		<li><?php echo  $this->Html->link('OR Calendar Report',array('controller'=>'reports','action'=>'ot_list','admin'=>true),array('alt' => 'Item Rate List'));?></li>
   </ul>
</li>
<li >New Visits Report
	<ul> 
		<li><?php echo  $this->Html->link('Total New Visits Report',array('controller'=>'reports','action'=>'patient_ot_report','admin'=>true),array('alt' => 'Add Item Rate'));?></li>
		<li><?php echo  $this->Html->link('Time Taken for Check-in',array('controller'=>'reports','action'=>'ot_utilization_rate','admin'=>true),array('alt' => 'Item Rate List'));?></li>
		<li><?php echo  $this->Html->link('Patient Check-in Report',array('controller'=>'reports','action'=>'ot_list','admin'=>true),array('alt' => 'Item Rate List'));?></li>
		<li><?php echo  $this->Html->link('Total New Visit Report By Referring Physician',array('controller'=>'reports','action'=>'patient_admitted_report','admin'=>true),array('alt' => 'Item Rate List'));?></li>
		<li><?php echo  $this->Html->link('Patient Check-in Report',array('controller'=>'reports','action'=>'admission_report_by_reference_doctor','admin'=>true),array('alt' => 'Item Rate List'));?></li>
		<li><?php echo  $this->Html->link('Total New Visit Report By Patient Location',array('controller'=>'admission_report_by_patient_location','action'=>'ot_list','admin'=>true),array('alt' => 'Item Rate List'));?></li>
	</ul>
</li>
<li >Survey Reports
	<ul> 
		<li><?php echo  $this->Html->link('Staff Survey Report',array('controller'=>'reports','action'=>'staffsurvey_reports','admin'=>true),array('alt' => 'Add Item Rate'));?></li>
		 		
		<li><?php echo  $this->Html->link('Patient Survey Report',array('controller'=>'reports','action'=>'patient_survey_type','admin'=>true),array('alt' => 'Item Rate List'));?></li>
	</ul>
</li>		
<li>Hospital Associated Infections Reports
	<ul> 
		<li> <?php echo $this->Html->link('Hospital Associated Infections Cases',array('controller'=>'reports','action'=>'hospital_acquire_infections_reports','admin'=>true));?></li>
		<li> <?php echo $this->Html->link('Hospital Associated Infections Rate',array('controller'=>'reports','action'=>'hai_cent', 'admin'=>true));?></li>
		<li> <?php echo $this->Html->link('SSI Rate',array('controller'=>'reports','action'=>'ssirate', 'admin'=>true));?></li>
		<li> <?php echo $this->Html->link('UTI Rate',array('controller'=>'reports','action'=>'utirate', 'admin'=>true));?></li>
		<li> <?php echo $this->Html->link('VAP Rate',array('controller'=>'reports','action'=>'vaprate', 'admin'=>true));?></li>
		<li><?php echo $this->Html->link('BSI Rate',array('controller'=>'reports','action'=>'bsirate', 'admin'=>true));?></li>
		<li><?php echo $this->Html->link('Thrombophlebitis Rate',array('controller'=>'reports','action'=>'thrombophlebitisrate', 'admin'=>true));?></li>
	</ul>
</li>
<li>Pharmacy Report
	<ul>
		<li><?php echo $this->Html->link('Pharmacy Purchase Report',array('controller'=>'reports','action'=>'purchase_report','admin'=>true));?></li>
		<li><?php echo $this->Html->link('Pharmacy Sales Report',array('controller'=>'reports','action'=>'sales_report','admin'=>true));?></li>
	</ul>
</li>		
<li>MIS Reports
		<ul> 
			<li><?php echo $this->Html->link('Daily Cash Collection',array('controller'=>'reports','action'=>'daily_cash_collection','admin'=>true));?></li>
			<li><?php echo $this->Html->link('Daily Credit Card Collection',array('controller'=>'reports','action'=>'daily_credit_collection', 'admin'=>true));?></li>
			<li><?php echo $this->Html->link('Daily Cheque Collection and Fund Transfer Details',array('controller'=>'reports','action'=>'daily_check_collection', 'admin'=>true));?></li>
			
				<!--<li><?php echo $this->Html->link('Payment Receivable',array('controller'=>'reports','action'=>'payment_dues', 'admin'=>true));?>
					</li>-->
					<li><?php echo $this->Html->link('Provider Wise Billing',array('controller'=>'reports','action'=>'doctorwise_collection', 'admin'=>true));?>
					</li>
				<!--<li><?php echo $this->Html->link('Total Concessions',array('controller'=>'reports','action'=>'total_concessions', 'admin'=>true));?>
					</li>-->
				</ul>
			</li>
			<li class="liHeader">Referral Doctor Report
				<ul> 
					<li><?php echo $this->Html->link('Miscellaneous Report',array('controller'=>'reports','action'=>'profit_referral_doctor','admin'=>false));?></li>
				</ul>
			</li>
			<li class="liHeader">Advance Statement
				<ul> 
					<li><?php echo $this->Html->link('Advance Statement',array('controller'=>'Billings','action'=>'advanced_billing', 'admin'=>false));?></li>
				</ul>
			</li>
			<li class="liHeader">Discharge Report
				<ul> 
					<li><?php echo $this->Html->link('Discharge Report-Private',array('controller'=>'Corporates','action'=>'discharge_report', 'admin'=>true));?></li>
				    <li><?php echo $this->Html->link('Discharge Report-Company',array('controller'=>'corporates','action'=>'company_discharge_report', 'admin'=>true));?></li>
				    <li><?php echo $this->Html->link('Discharge Summary Report-All',array('controller'=>'Corporates','action'=>'discharge_summary_report_all', 'admin'=>true));?></li>
				</ul>
			</li> 
			<li class="liHeader">Corporate Report
				<ul> 
					<li>Rgjay 
					      <ul>
					        <li><?php echo $this->Html->link('RGJAY Report',array('controller'=>'corporates','action'=>'rgjay_report', 'admin'=>true));?></li>
				   			 <li><?php echo $this->Html->link('RGJAY Outstanding Report',array('controller'=>'Corporates','action'=>'rgjay_outstanding_report', 'admin'=>true));?></li>
							 <li><?php  echo $this->Html->link('RGJAY Payment Received Report.',array('controller'=>'Corporates','action'=>'rgjay_payment_received_report', 'admin'=>true));?></li> 
							<li><?php echo $this->Html->link('RGJAY Tasks Report.',array('controller'=>'Corporates','action'=>'rgjay_tasks_report', 'admin'=>true));?></li>
				   		  </ul>
				   </li>
				   <li> <?php echo $this->Html->link('BHEL',array('controller'=>'Corporates','action'=>'bhel_outstanding_report','admin'=>true));?></li>
 					<li>
					<li><?php  echo $this->Html->link('BSNL',array('controller'=>'Corporates','action'=>'bsnl_report', 'admin'=>true));?></li>
					<li><?php echo $this->Html->link('CGHS (Ordnance Factory Chanda )',array('controller'=>'Corporates','action'=>'cghs_report', 'admin'=>true));?></li>
					<li><?php echo $this->Html->link('ECHS',array('controller'=>'Corporates','action'=>'echs_report', 'admin'=>true));?>
					<li><?php echo $this->Html->link('Mahindra & Mahindra',array('controller'=>'Corporates','action'=>'mahindra_report', 'admin'=>true));?></li>
					<li><?php echo $this->Html->link('FCI',array('controller'=>'Corporates','action'=>'fci_report', 'admin'=>true));?></li>
					<li><?php echo $this->Html->link('Raymond',array('controller'=>'Corporates','action'=>'raymond_report', 'admin'=>true));?></li>
					<li><?php echo $this->Html->link('WCL',array('controller'=>'Corporates','action'=>'wcl_report', 'admin'=>true));?></li>
					<li><?php  echo $this->Html->link('MPKAY',array('controller'=>'Corporates','action'=>'mpkay_report', 'admin'=>true));?></li>
 				  
				</ul>
			</li>	
			<li class="liHeader">Surgery Report
				<ul> 
					<li><?php echo $this->Html->link('Surgery report',array('controller'=>'corporates','action'=>'surgeon_payment_report', 'admin'=>true));?>
					</li>	
				</ul>
			</li>
			<li class="liHeader">Other Reports
				<ul> 
	    <li> <?php echo $this->Html->link('Total Discharge Report',array('controller'=>'reports','action'=>'patient_discharge_report','admin'=>true));?> </li>
		<li> <?php echo $this->Html->link('Average Length of Stay Report',array('controller'=>'reports','action'=>'admin_length_of_stay','admin'=>true));?></li>
		<li><?php echo $this->Html->link('Bed Occupancy Report',array('controller'=>'reports','action'=>'ward_occupancy_rate','admin'=>false));?></li>
		<li><?php echo $this->Html->link('Encounters By Month',array('controller'=>'reports','action'=>'monthly_consultations','admin'=>true));?></li>
		<li><?php echo $this->Html->link('Encounters By Department',array('controller'=>'reports','action'=>'consultationsby_department','admin'=>true));?></li>
		<li><?php echo $this->Html->link('Patient Summary By Type Of Payment',array('controller'=>'reports','action'=>'patient_summary','admin'=>true));?></li>
	    <li><?php echo $this->Html->link('Total Number of Anesthesia',array('controller'=>'reports','action'=>'total_anesthesia','admin'=>true));?></li>
		<li><?php echo $this->Html->link('Waiting Time For Initial Assessment',array('controller'=>'reports','action'=>'initial_assessment_time','admin'=>true));?></li>
		<li><?php echo $this->Html->link('Time Taken For Initial Assessment ', array('controller'=>'reports','action'=>'time_taken_initial_assessment','admin'=>true));?></li>
		<!--  <li><?php echo $this->Html->link('ICU Utilization Rate',array('controller'=>'reports','action'=>'icu_utilization_report','admin'=>true));?></li>-->
	    <li> <?php echo $this->Html->link('Total Number of Patient Readmitted to ICU within 48 hrs',array('controller'=>'reports','action'=>'patient_readmitted_to_icu','admin'=>true));?></li>
	    <li><?php echo $this->Html->link('Time Taken For Discharge',array('controller'=>'reports','action'=>'time_taken_for_discharge','admin'=>true));?></li>
	    <li><?php echo $this->Html->link('Hospital Turnover Rate',array('controller'=>'reports','action'=>'tor','admin'=>true));?></li>
		<li><?php echo $this->Html->link('Complaints',array('controller'=>'reports','action'=>'complaints','admin'=>true));?></li>
		<li><?php echo $this->Html->link('Appointment Report',array('controller'=>'reports','action'=>'appointment','admin'=>true));?></li>
		<li><?php echo $this->Html->link('Mortality Rate',array('controller'=>'reports','action'=>'birth_death', 'admin'=>true));?></li>
		
<!--		<li><?php //echo $this->Html->link('X-Ray utilization Rate',array('controller'=>'reports','action'=>'x_ray_utilization_report','admin'=>true));?>
	    </li>
	<li> <?php //echo $this->Html->link('Physician-wise Profit Sharing Receipts Report',array('controller'=>'Users','action'=>'profitPhysician','admin'=>false));?>
 		 </li>
		<li ><?php  //echo$this->Html->link('Residents Overdue Report',array('controller'=>'MeaningfulReport','action'=>'resident_overdue_report','admin'=>false));?>
 	    </li> 
	<li class="all_li">&nbsp;<?php //echo $this->Html->link('Over Due Rad Test Results Report',array('controller'=>'Radiologies','action'=>'radOverdueTestReport','admin'=>false));?>-->
<!-- 	</li> 
<!--	<li class="all_li">&nbsp;<?php //echo $this->Html->link('Abnormal Lab Test Results',array('controller'=>'Laboratories','action'=>'labAbnormalTestReport','admin'=>false));?>-->
<!-- 	</li> -->
<!--	<li class="all_li">&nbsp;<?php //echo $this->Html->link('Abnormal Rad Test Results',array('controller'=>'Radiologies','action'=>'radAbnormalTestReport','admin'=>false));?>-->
<!-- 	</li> -->
					
 <!-- 	<li >&nbsp;<?php echo $this->Html->link('Overall Milestones of Residents',array('controller'=>'MeaningfulReport','action'=>'resident_overall_milestone','admin'=>false));?>
	</li> < -->
	</ul>
	</li>
	</ul>
	</div>
</body>
<script>
		$(document).ready(function(){
			$('#reportMenuList').hide();
			})
$(function() {
$( "#menu" ).menu();
});

$("#hideAndShow").click(function(event){
	$('#reportMenuList').toggle();
	});
$(document).click(function(){
	$("#reportMenuList").hide();	
});
$("#reportMenuList,#hideAndShow").click(function(e){
    e.stopPropagation(); 
});


</script>