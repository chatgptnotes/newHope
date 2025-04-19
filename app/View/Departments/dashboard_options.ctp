<div class="inner_title">
	<h3><?php
		 echo $department['Department']['name'] ;
		 $dept_id  = $department['Department']['id'] ;	
	?></h3>
</div>
<ul class="interIcons">

	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient-inner.jpg', array('alt' => 'Appointments')),array("controller" => "doctor_schedules", "action" => "view_alldoctor_event", "admin" => false,"?"=>array('dept_id'=>$dept_id),'plugin' => false), array('escape' => false,'label'=>'Appointments')); ?></li>
					
	<!--<li> <?php //echo $this->Html->link($this->Html->image('/img/icons/Back-dated-Registration.jpg', array('alt' => 'Back Dated Registration')),array("controller" => "patients", "action" => "search", "admin" => false,"?"=>array('type'=>'IPD'),'plugin' => false), array('escape' => false,'label'=>'Back Dated Registration')); ?></li>-->
						
	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'OPD')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'OPD','dept_id'=>$dept_id), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'OPD')); ?></li>				
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/in-patient.jpg', array('alt' => 'IPD')),array("controller" => "patients", "action" => "search",'?'=>array('type'=>'IPD','dept_id'=>$dept_id), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'IPD')); ?></li>				
								
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/emergency.jpg', array('alt' => 'Emergency')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'emergency','dept_id'=>$dept_id), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Emergency')); ?></li>
				
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/operation_theater.png', array('alt' => 'OT')),array("controller" => "OptAppointments", "action" => "search", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'OT')); ?></li>			
					
	 
</ul>
