
<style>
.referralindex{font-size:10px;
  color:#000;
 /* border-bottom: 1px solid #4C5E64;*/
  float:left;
  width:104%;}
.referralindex_td{float: left;
    font-size: 10px;
    font-weight: bold;
    height: 90px;
    margin: 0 24px 0px 0;
    padding: 0;
    text-align: center;
    width: 57px;
	height:80px;}
.referralindex_td img{ width:35px; height:35px;}	
.referralindex_td p{ float:left; clear:left;font-size:10px; height:27px; width:10px;}
.referralindex_td a{ float:left;}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}
</style>
	<h3 class="title_format">
		<?php //echo __('Immunization Mailbox') ?>
	</h3> 
<div class="referralindex" width = "100%">
<div>
	<div class="referralindex_td"><?php echo  $this->Html->link($this->Html->image('/img/icons/inbox.png', array('alt' => 'Immunization Inbox')),
			array("controller" => "Hl7TextMessages", "action" => "hl7ImmunizationInbox",'plugin' => false), array('escape' => false,'label'=>'Immunization Inbox')); ?>
	</div>
	 
	<div class="referralindex_td"><?php echo  $this->Html->link($this->Html->image('/img/icons/mail_outbox.png', array('alt' => 'Immunization  Outbox')),
			array("controller" => "Hl7TextMessages", "action" => "immunizationOutbox",'plugin' => false), array('escape' => false,'label'=>'Immunization Outbox')); ?>
	</div>
	<!-- 
	<td class="referralindex_td"><?php echo  $this->Html->link($this->Html->image('/img/icons/Database.png', array('alt' => 'Incorporate')),
			array("controller" => "messages", "action" => "hl7MessageEncorporation",'plugin' => false), array('escape' => false,'label'=>'Lab Incorporate')); ?>
	</td>
	-->
    
</div>
</div>