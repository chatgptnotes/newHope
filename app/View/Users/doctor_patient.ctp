<div class="inner_title">
	<h3>OPD</h3>
</div>
<ul>
<li> 
                                <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'Out Patient')),array("controller" => "persons", "action" => "index", "admin" => false,"?type=OPD",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Registration',true); ?></p></li>
				
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'Out Patient')),array("controller" => "doctor_schedules", "action" => "doctor_event", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Appointment Scheduling',true); ?></p></li>
<li><?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'Out Patient')),array("controller" => "doctor_schedules", "action" => "view_alldoctor_event", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('View Appointment',true); ?></p></li>
<li><?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'Out Patient')),array("controller" => "doctor_schedules", "action" => "#", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Token Generation',true); ?></p></li>
				
				
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'Out Patient')),array("controller" => "laboratories", "action" => "lab_manager", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Investigation Request',true); ?></p></li>
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'Out Patient')),array("controller" => "doctor_schedules", "action" => "#", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Invoicing',true); ?></p></li>
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'Out Patient')),array("controller" => "patients", "action" => "search", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Assessment',true); ?></p></li>
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'Out Patient')),array("controller" => "patients", "action" => "search", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Patient Enquiry',true); ?></p></li>

</ul>
