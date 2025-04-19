
<div class="inner_title">
	<h3>Inpatient</h3>
</div>
<ul class="interIcons">

	<!--<li> <?php //echo $this->Html->link($this->Html->image('/img/icons/register.jpg', array('alt' => 'register')),array("controller" => "patients", "action" => "add", "admin" => false,"?"=>array('type'=>'IPD'),'plugin' => false), array('escape' => false,'label'=>'Registration ')); ?></li>
					
	<li> <?php //echo $this->Html->link($this->Html->image('/img/icons/Back-dated-Registration.jpg', array('alt' => 'Back Dated Registration')),array("controller" => "patients", "action" => "search", "admin" => false,"?"=>array('type'=>'IPD'),'plugin' => false), array('escape' => false,'label'=>'Back Dated Registration')); ?></li>-->
						
	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/in-patient-assessment.jpg', array('alt' => 'Assessment')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'IPD','mod'=>'assessment'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Assessment')); ?></li>				
					
	<!-- <li><?php // echo $this->Html->link($this->Html->image('/img/icons/Investigation-Request.jpg', array('alt' => 'Investigation Request')),array("controller" => "laboratories", "action" => "patient_search",'?'=>array('type'=>'IPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Lab Order')); ?></li> -->				
								
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/ward-management.jpg', array('alt' => 'Ward Management')),array("controller" => "wards", "action" => "ward_occupancy", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Room')); ?></li>
				
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/bill-invoicing.jpg', array('alt' => 'Generate Invoice')),array("controller" => "billings", "action" => "patientSearch",'?'=>array('type'=>'IPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Generate Bill')); ?></li>			
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/Patient-Enquiry.jpg', array('alt' => 'Patient Enquiry')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'IPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Find Patient')); ?></li>				
									
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/discharge.jpg', array('alt' => 'Discharge')),array("controller" => "billings", "action" => "PatientSearch", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Discharge')); ?></li>
<!-- 
	<li><a href="<?php echo $this->Html->url(array('action'=>'dischargePatientSearch','controller'=>'billings'));?>"><img src="../img/icons/discharge.jpg"><p style="margin:0px; padding: 5px 0 0;">Settlement Billing</p></a></li>
 -->
 <li><?php echo $this->Html->link($this->Html->image('icons/billing.jpg', array('alt' => 'Payment')),array("controller" => "billings", "action" => "paymentReceipt","?"=>array('type'=>'IPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Payment')); ?></li>
 
 <li><?php  echo $this->Html->link($this->Html->image('/img/icons/discharge.jpg', array('alt' => 'Discharged Patient Enquiry')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'IPD','patientstatus' => 'discharged'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Find Discharged Pt.')); ?></li>

</ul>
