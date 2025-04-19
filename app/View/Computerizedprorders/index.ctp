
<div class="inner_title">
	<h3>Computerized Provider Order Entry</h3>
</div>
<ul class="interIcons">

	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/register.jpg', array('alt' => 'Lab Order')),array("controller" => "patients", "action" => "add", "admin" => false,"?"=>array('type'=>'IPD'),'plugin' => false), array('escape' => false,'label'=>'Lab Order')); ?></li>
					
	<!--<li> <?php //echo $this->Html->link($this->Html->image('/img/icons/Back-dated-Registration.jpg', array('alt' => 'Back Dated Registration')),array("controller" => "patients", "action" => "search", "admin" => false,"?"=>array('type'=>'IPD'),'plugin' => false), array('escape' => false,'label'=>'Back Dated Registration')); ?></li>-->
						
	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/in-patient-assessment.jpg', array('alt' => 'Lab Result')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'IPD','mod'=>'assessment'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Lab Result')); ?></li>				
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/Investigation-Request.jpg', array('alt' => 'Rad Order')),array("controller" => "laboratories", "action" => "patient_search",'?'=>array('type'=>'IPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Rad Order')); ?></li>				
								
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/ward-management.jpg', array('alt' => 'Rad Result')),array("controller" => "wards", "action" => "ward_occupancy", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Rad Result')); ?></li>
				
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/bill-invoicing.jpg', array('alt' => 'Generate Invoice')),array("controller" => "billings", "action" => "patientSearch",'?'=>array('type'=>'IPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Generate Invoice')); ?></li>			
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/Patient-Enquiry.jpg', array('alt' => 'Rx')),array("controller" => "patients", "action" => "search","?"=>array('type'=>'IPD'), "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Rx')); ?></li>				
								

</ul>
