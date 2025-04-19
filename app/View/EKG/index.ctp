<div class="inner_title">
	<h3><?php echo __('EKG Manager'); ?></h3>
</div>
<ul class="interIcons">
	<li>
		<?php echo $this->Html->link($this->Html->image('icons/Patient-Enquiry.jpg', array('alt' => 'Patient Enquiry')),array("controller"=>"EKG","action" => "ekg_manager", "admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('Patient Enquiry',true); ?></p>
	</li>
	
</ul>
