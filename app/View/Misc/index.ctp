<div class="inner_title">
<h3><?php echo __('Miscellaneous', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),"/", array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<ul
	class="interIcons">
	<!-- <li><?php echo $this->Html->link($this->Html->image('/img/icons/service_providers.png', array('alt' => 'Help Desk')),array('controller'=>'Misc',"action" => "helpDesk"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Help Desk DashBoard',true); ?>
	
	</li>-->
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/patient-documents.jpg', array('alt' => 'Documents')),array('controller'=>'PatientDocuments',"action" => "index"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Documents',true); ?>
	
	</li>
	<!--<li><?php echo $this->Html->link($this->Html->image('/img/icons/ot-medical-replacement-slip.jpg', array('alt' => 'Approve Request')),array('controller'=>'Billings',"action" => "discount_requests"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Approve Request',true); ?>
	
	</li>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/mu.png', array('alt' => 'MU Report')),array('controller'=>'MeaningfulReport',"action" => "all_report",'admin'=>true), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Approve Request',true); ?>
	
	</li>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/audit_log.png', array('alt' => 'Audit Log')),array('controller'=>'AuditLogs',"action" => "audit_logs",'admin'=>true), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Audit Log',true); ?>
	
	</li>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/hope2sms.png', array('alt' => 'Hope2 Sms')),array('controller'=>'Messages',"action" => "hope_two_sms"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Hope2 Sms',true); ?>
	
	</li>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/appointment.png', array('alt' => 'Scheduling')),array('controller'=>'DoctorSchedules',"action" => "doctor_event"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Scheduling',true); ?>
	
	</li>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/complaints.jpg', array('alt' => 'Complaints')),array('controller'=>'Complaints',"action" => "index"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Complaints',true); ?>
	
	</li>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/equipment.png', array('alt' => 'Departmental Equipment')),array('controller'=>'store',"action" => "allot_list"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Departmental Equipment',true); ?>
	
	</li> -->
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/camp.jpg', array('alt' => 'Medical Camp')),array('controller'=>'Surveys',"action" => "camp_list"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Medical Camp',true); ?>
	
	</li>
	
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/file_number.png', array('alt' => 'Patients File Number List')),array('controller'=>'Surveys',"action" => "patient_file_list"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Patients File Number List',true); ?>
	
	</li>
	 
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/ceomsg.jpg', array('alt' => 'CEO Message')),array('controller'=>'Messages',"action" => "ceomessage"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('CEO Message',true); ?>
	
	</li>
	<!-- Upload Rgjay Documents -->
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/uploadDoc.png', array('alt' => 'Upload RGJAY Documents')),array('controller'=>'Radiologies',"action" => "getRgjayPackagePatientResult"), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Upload RGJAY Document',true); ?>
	
	</li>
	
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/rgjayfile.jpg', array('alt' => 'RGJAY Package Claim/PreAuth Documents')),array("controller" => "PatientDocuments", "action" => "rgjay_list", "admin" => false, 'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('RGJAY Package Claim/PreAuth Documents',true); ?></li>
	
</ul>
