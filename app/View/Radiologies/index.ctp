<div class="inner_title">
	<h3><?php echo __('Radiology Manager'); ?></h3>
</div>
<ul class="interIcons">
	<li>
		<?php echo $this->Html->link($this->Html->image('icons/Patient-Enquiry.jpg', array('alt' => 'Patient Enquiry')),array("action" => "radiology_manager", "admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('Patient Enquiry',true); ?></p>
	</li>
	<li><?php echo $this->Html->link($this->Html->image('icons/recipts.png', array('alt' => 'Receipt')),array("action" => "receipts", "admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('Receipt',true); ?></p>
	</li>
	<li><?php echo $this->Html->link($this->Html->image('icons/billing.jpg', array('alt' => __('Payment'), 'title' => __('Payment'))),array("action" => "payment", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php echo __('Payment',true); ?>		
    </li>
    <li><?php echo $this->Html->link($this->Html->image('/img/icons/interactive_view.png', array('alt' => __('Rad DashBoard'), 'title' => __('Rad DashBoard'))),array("action" => "radDashBoard", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php echo __('Radiology DashBoard',true); ?>		
    </li>
    <li><?php echo $this->Html->link($this->Html->image('/img/icons/patient_registration.png', array('alt' => __('Pt. Registration'), 'title' => __('Pt. Registration'))),array("controller"=>"persons","action" => "add", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php echo __('Patient Registration',true); ?>		
    </li> 
     <li><?php echo $this->Html->link($this->Html->image('/img/icons/interactive_view.png', array('alt' => __('Modality and Material management'), 'title' => __('Modality and Material management'))),array('controller' => 'Preferences', 'action' => 'user_preferencecard','null','Radiology', "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php echo __('Modality and Material management',true); ?>		
    </li>
</ul>
