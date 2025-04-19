<div class="inner_title">
	<h3>Lab Manager</h3>
</div>
<ul class="interIcons">
	<li>
		<?php echo $this->Html->link($this->Html->image('icons/Patient-Enquiry.jpg', array('alt' => 'Patient Enquiry')),array("action" => "lab_manager", "admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;"><?php echo __('Patient Enquiry',true); ?></p>
	</li>
	<li><?php echo $this->Html->link($this->Html->image('icons/recipts.png', array('alt' => 'Receipt')),array("action" => "receipts", "admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;"><?php echo __('Receipt',true); ?></p>
	</li>
	<li><?php echo $this->Html->link($this->Html->image('icons/billing.jpg', array('alt' => __('Payment'), 'title' => __('Payment'))),array("action" => "payment", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin: 0px; padding: 0px;"><?php echo __('Payment',true); ?>		
    </li>
	<!--   <li><?php  echo $this->Html->link($this->Html->image('icons/out_side_lab_order1.png', array('alt' => __('HL7'), 'title' => __('HL7'))),array("action" => "hlseven", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php echo __('HL7',true); ?>		
    </li> -->
	<li><?php echo $this->Html->link($this->Html->image('icons/out_side_lab_order1.png', array('alt' => __('Lab Order Received'), 'title' => __('Lab Order Received'))),array("action" => "labOrderReceived", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin: 0px; padding: 0px;"><?php echo __('Out Side Lab Orders',true); ?>		
    </li>
	<li><?php echo $this->Html->link($this->Html->image('icons/out_side_lab_orders_inbox.png', array('alt' => __('Out Side Lab Orders Inbox'), 'title' => __('Out Side Lab Orders Inbox'))),array("action" => "labOrderReceivedInbox", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin: 0px; padding: 0px;"><?php echo __('Out Side Lab Orders Inbox',true); ?>		
    </li>
	<li><?php
	
	echo $this->Html->link ( $this->Html->image ( '/img/icons/compose_mail.png', array (
			'alt' => 'Compose' 
	) ), array (
			"controller" => "Hl7TextMessages",
			"action" => "compose",
			$u_id,
			'plugin' => false 
	), array (
			'escape' => false,
			'label' => 'Compose' 
	) );
	?>
	</li>
	<li><?php echo  $this->Html->link($this->Html->image('/img/icons/inbox.png', array('alt' => 'Inbox')),array("controller" => "Hl7TextMessages", "action" => "index", 'plugin' => false), array('escape' => false,'label'=>false)); ?>
        <p style="margin: 0px; padding: 0px;"><?php echo __('Inbox',true); ?>		
    </li>
	<li><?php echo  $this->Html->link($this->Html->image('/img/icons/mail_outbox.png', array('alt' => 'Outbox')),array("controller" => "Hl7TextMessages", "action" => "outbox",'plugin' => false), array('escape' => false,'label'=>false)); ?>
        <p style="margin: 0px; padding: 0px;"><?php echo __('Outbox',true); ?>		
    </li>
	<li>
		<?php echo $this->Html->link($this->Html->image('/img/icons/interactive_view.png', array('alt' => 'Lab DashBoard')),array("action" => "labDashBoard", "admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;"><?php echo __('Lab DashBoard',true); ?></p>
	</li>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/interactive_view.png', array('alt' => __('Modality and Material management'), 'title' => __('Modality and Material management'))),array('controller' => 'Preferences', 'action' => 'user_preferencecard','null','Laboratories', "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin: 0px; padding: 0px;"><?php echo __('Modality and Material management',true); ?>		
    </li>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/interactive_view.png', array('alt' => __('Turn Arround Time'), 'title' => __('Turn Arround Time'))),array('controller' => 'Laboratories', 'action' => 'turnAroundTime', "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin: 0px; padding: 0px;"><?php echo __('Turn Arround Time',true); ?>		
    </li>
	<li><?php
	
	echo $this->Html->link ( $this->Html->image ( '/img/icons/compose_mail.png', array (
			'alt' => 'Sample Types' 
	) ), array (
			"controller" => "Laboratories",
			"action" => "sampleTypes",
			'plugin' => false 
	), array (
			'escape' => false,
			'label' => 'Sample Types' 
	) );
	?>
	</li>
</ul>
