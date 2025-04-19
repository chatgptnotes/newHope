<div class="inner_title">
	<h3>Ambulatory</h3>
</div>

<ul class="interIcons">
<?php   
				
				$usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']);
				if($usertype=='hospital' || $usertype==''){
				//echo $this->element('quality_management_navigation');	
				
			
			?>

	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/register.jpg', array('alt' => 'register')),array("controller" => "patients", "action" => "add", "admin" => false,"?"=>array('type'=>'OPD'),'plugin' => false), array('escape' => false,'label'=>'Registration ')); ?></li>
	<?php if(strtolower($this->Session->read('role')) == Configure::read('doctor') ) { ?>
	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient-inner.jpg', array('alt' => 'Out Patient')),array("controller" => "doctor_schedules", "action" => "schedule_event", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'View My Appointment')); ?>
	      
	</li>
	<?php } else { ?>	
           <!--  <li>  <?php //echo $this->Html->link($this->Html->image('/img/icons/out-patient-inner.jpg', array('alt' => 'Out Patient')),array("controller" => "doctor_schedules", "action" => "doctor_event", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Schedule')); ?></li> -->
           <li><?php echo $this->Html->link($this->Html->image('/img/icons/out-patient-inner.jpg', array('alt' => 'Patient-Enquiry')),array("controller" => "patients", "action" => "search",  "?"=>array('type'=>'', 'listflag' => 'appt'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Future Appointment')); ?></li>		
        <?php } ?>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/view-appointment.jpg', array('alt' => 'view-appointment')),array("controller" => "doctor_schedules", "action" => "view_alldoctor_event", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'View Appt.')); ?></li>
					

	<!-- <li><?php // echo $this->Html->link($this->Html->image('/img/icons/Investigation-Request.jpg', array('alt' => 'Investigation-Request')),array("controller" => "laboratories", "action" => "patient_search",'?'=>array('type'=>'OPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Test Order')); ?></li> -->
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/bill-invoicing.jpg', array('alt' => 'Generate Invoice')),array("controller" => "billings", "action" => "patientSearch",'?'=>array('type'=>'OPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Generate Bill')); ?></li>
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/Patient-Enquiry.jpg', array('alt' => 'Patient-Enquiry')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'OPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Find Patient')); ?></li>
	
	<li><?php echo $this->Html->link($this->Html->image('icons/billing.jpg', array('alt' => 'Payment')),array("controller" => "patients", "action" => "payment","?"=>array('type'=>'OPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Payment')); ?></li>
	
	<li><?php  echo $this->Html->link($this->Html->image('/img/icons/discharge.jpg', array('alt' => 'OPD Process Done Patient Enquiry')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'OPD','patientstatus' => 'processed'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Pt. Process Enquiry')); ?></li>
 <?php  } ?>	
</ul>
<?php   
				
				$usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']);
				if($usertype=='ambulatory'){
				//echo $this->element('quality_management_navigation');	
				
			
			?>
<ul class="interIcons">
	
	<?php if(strtolower($this->Session->read('role')) == Configure::read('doctor') ) { ?>
	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient-inner.jpg', array('alt' => 'Out Patient')),array("controller" => "doctor_schedules", "action" => "schedule_event", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'View My Appointment')); ?></li>
	<?php } else { ?>	
           <li>  <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient-inner.jpg', array('alt' => 'Out Patient')),array("controller" => "doctor_schedules", "action" => "doctor_event", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Appointment Scheduling')); ?></li>		
        <?php } ?>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/view-appointment.jpg', array('alt' => 'view-appointment')),array("controller" => "doctor_schedules", "action" => "view_alldoctor_event", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'View Appointment')); ?></li>
					
	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/in-patient-assessment.jpg', array('alt' => 'Assessment')),array("controller" => "patients", "action" => "search_ambi","?"=>array('type'=>'OPD','mod'=>'assessment'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Assessment')); ?></li>	
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/Investigation-Request.jpg', array('alt' => 'Investigation-Request')),array("controller" => "laboratories", "action" => "patient_search",'?'=>array('type'=>'OPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Investigation Request')); ?></li>
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/bill-invoicing.jpg', array('alt' => 'Generate Invoice')),array("controller" => "billings", "action" => "patientSearch",'?'=>array('type'=>'OPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Generate Bill')); ?></li>
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/Patient-Enquiry.jpg', array('alt' => 'Patient-Enquiry')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'OPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Find Patient')); ?></li>
	
	<li><?php echo $this->Html->link($this->Html->image('icons/billing.jpg', array('alt' => 'Payment')),array("controller" => "patients", "action" => "payment","?"=>array('type'=>'OPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Payment & Receipt')); ?></li>
	
	<li><?php  echo $this->Html->link($this->Html->image('/img/icons/discharge.jpg', array('alt' => 'OPD Process Done Patient Enquiry')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'OPD','patientstatus' => 'processed'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'OPD Process Done Patient Enquiry')); ?></li>
 <?php  } ?>	
</ul>