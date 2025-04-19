<div class="inner_title">
	<h3>OPD</h3>
</div>
<ul class="interIcons">

<li><?php echo $this->Html->link($this->Html->image('/img/icons/view-appointment.jpg', array('alt' => 'View Appointment')),array("controller" => "doctor_schedules", "action" => "schedule_event", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('View Appointment',true); ?></p></li>
				


				
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/Investigation-Request.jpg', array('alt' => 'Investigation Request')),array("controller" => "laboratories", "action" => "lab_manager", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Investigation Request',true); ?></p></li>
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/bill-invoicing.jpg', array('alt' => 'Invoicing')),array("controller" => "billings", "action" => "PatientSearch", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Invoicing',true); ?></p></li>
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/out-patient-assessment.jpg', array('alt' => 'Assessment')),array("controller" => "patients", "action" => "search", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Assessment',true); ?></p></li>
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/Patient-Enquiry.jpg', array('alt' => 'Patient Enquiry')),array("controller" => "patients", "action" => "search", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Patient Enquiry',true); ?></p></li>

</ul>
