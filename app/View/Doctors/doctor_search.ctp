<div class="inner_title">
	<h3>Providers List</h3>
</div>
<ul class="interIcons">

	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/doctor-inner.jpg', array('alt' => 'In-House Doctor Enquiry')),array("controller" => "doctors", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'In-House Doctor Enquiry')); ?></li>
	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/inhouse-external-doctor.jpg', array('alt' => 'External Consultant')),array("controller" => "consultants", "action" => "inhouse_externaldoctor", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'External Consultant')); ?></li>				
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/referral_doctor.png', array('alt' => 'Referral Doctor')),array("controller" => "consultants", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Referral Doctor')); ?></li>
				
</ul>
