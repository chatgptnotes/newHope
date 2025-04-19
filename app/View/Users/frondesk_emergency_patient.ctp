



<div class="inner_title">
	<h3>Emergency</h3>
</div>
<ul class="interIcons">

	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/register.jpg', array('alt' => 'register')),array("controller" => "patients", "action" => "add", "admin" => false,"?"=>array('type'=>'emergency'),'plugin' => false), array('escape' => false,'label'=>'Registration')); ?></li>

	<!--<li> <?php //echo $this->Html->link($this->Html->image('/img/icons/Back-dated-Registration.jpg', array('alt' => 'Back Dated Registration')),array("controller" => "patients", "action" => "search", "admin" => false,"?"=>array('type'=>'EMERGENCY'),'plugin' => false), array('escape' => false,'label'=>'Back Dated Registration')); ?></li>-->
						
	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/in-patient-assessment.jpg', array('alt' => 'Assessment')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'emergency','mod'=>'assessment'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Assessment')); ?></li>				
					
	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/Investigation-Request.jpg', array('alt' => 'Investigation Request')),array("controller" => "laboratories", "action" => "patient_search",'?'=>array('type'=>'emergency'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Test Order')); ?></li>				
								
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/ward-management.jpg', array('alt' => 'Room Management')),array("controller" => "wards", "action" => "ward_occupancy", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Room')); ?></li>
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/bill-invoicing.jpg', array('alt' => 'Generate Invoice')),array("controller" => "billings", "action" => "patientSearch",'?'=>array('type'=>'emergency'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Bill')); ?></li>
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/Patient-Enquiry.jpg', array('alt' => 'Patient Enquiry')),array("controller" => "patients", "action" => "search",'searchFor'=>'emergency',"?"=>array('type'=>'emergency'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Find Patient')); ?></li>				
									
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/discharge.jpg', array('alt' => 'Discharge')),array("controller" => "billings", "action" => "PatientSearch", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Discharge')); ?></li>
	
	<li><?php echo $this->Html->link($this->Html->image('icons/billing.jpg', array('alt' => 'Payment')),array("controller" => "billings", "action" => "paymentReceipt","?"=>array('type'=>'emergency'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Payment')); ?></li>
	

	<li><?php  
	$isEnabled = $this->Session->read('discharge_from_ed');
	if($isEnabled != 'No')
	echo $this->Html->link($this->Html->image('/img/icons/discharge.jpg', array('alt' => 'Discharged Patient Enquiry')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'emergency','patientstatus' => 'discharged'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Discharged Patient Enquiry')); ?></li>

</ul>
