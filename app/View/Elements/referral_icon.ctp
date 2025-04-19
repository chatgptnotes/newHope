
<style>
.referralindex {
	font-size: 10px;
	color: black;
	float:left;
	width:453%;
	/*border-bottom: 1px solid #4C5E64;*/
	
}

.referralindex_td {
	float: left;
	font-size: 10px;
	font-weight: bold;
	height:64px;
	margin: 0 24px 0px 0;
	padding: 0;
	text-align: center;
	width: 39px;
}
.referralindex_td img{ width:35px; height:35px;}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 14px;
	font-weight: bold;
}
.black_line{
	
	 
}

</style>

<div  class="title_format" style="padding-top: px"><!-- class="inner_title" is removed frm div  -->
	
		<?php //echo __('Referral Mailbox') ?>
	
	
	<span> <?php 
	//echo $this->Html->link(__('Back'),array('action'=>'index'),array('escape'=>false,'class'=>'blueBtn'));
	if($hasXml['XmlNote']['patients_e2_filename'] != ''){
		$role = $this->Session->read('role');

		if(strtolower($role)==Configure::read('patientLabel')){
			echo $this->Html->link(__('Download Clinical Summary'),array('controller'=>'ccda','action'=>'downloadXml',$patient_id),array('escape'=>false,'class'=>'blueBtn'));
			echo $this->Html->link(__('View Clinical Summary'),'#',array('escape'=>false,'class'=>'blueBtn','onclick'=>'javascript:view_consolidate_ccda('.$patient_id.')'));

		}
	}else if($patient_type=="IPD" && $hasXml['XmlNote']['filename'] != ''){
			
		echo $this->Html->link(__('Download Clinical Summary'),array('controller'=>'ccda','action'=>'downloadXml',$patient_id),array('escape'=>false,'class'=>'blueBtn'));
		echo $this->Html->link(__('View Clinical Summary'),'#',array('escape'=>false,'class'=>'blueBtn','onclick'=>'javascript:view_consolidate_ccda('.$patient_id.')'));

	}
	?>
	</span>
	<div class="referralindex " >
	
		<?php if(strtolower($role) != 'patient'){
			  if($id==''){
			?>
				<div class="referralindex_td">
					<?php
						echo  $this->Html->link($this->Html->image('/img/icons/compose_mail.png', array('alt' => 'Compose')),
						array("controller"=>"messages","action" => "patientList",'plugin' => false), array('escape' => false,'label'=>'Compose')); ?>
				</div>
			<?php }else{?>
				
				<div class="referralindex_td">
					<?php
						echo  $this->Html->link($this->Html->image('/img/icons/compose_mail.png', array('alt' => 'Compose')),
						array("controller"=>"messages","action" => "composeCcda",$id,'plugin' => false), array('escape' => false,'label'=>'Compose')); ?>
				</div>
		    <?php }  ?>
	
		<?php }else {?>
			<div class="referralindex_td"><?php echo  $this->Html->link($this->Html->image('/img/icons/compose_mail.png', array('alt' => 'Composed CCDA Message')),
				array("controller"=>"messages","action" => "composeCcda",$patient_id,'plugin' => false), array('escape' => false,'label'=>'Composed CCDA Message')); ?>
			</div>
		<?php }?>
	
		<div class="referralindex_td"><?php echo  $this->Html->link($this->Html->image('/img/icons/inbox.png', array('alt' => 'Inbox')),
			array("controller" => "ccda", "action" => "searchParsePatient",'plugin' => false), array('escape' => false,'label'=>'Inbox')); ?>
		</div>

		<div class="referralindex_td"><?php echo  $this->Html->link($this->Html->image('/img/icons/mail_outbox.png', array('alt' => 'OutBox')),
			array("controller" => "ccda", "action" => "out_box",'plugin' => false), array('escape' => false,'label'=>'OutBox')); ?>
		</div>

		<div class="referralindex_td"><?php echo  $this->Html->link($this->Html->image('/img/icons/ccda_icon.jpg', array('alt' => 'Summary')),
			array("controller" => "ccda", "action" => "search",'plugin' => false), array('escape' => false,'label'=>'Summary')); ?>
		</div>

		<div class="referralindex_td"><?php echo  $this->Html->link($this->Html->image('/img/icons/Database.png', array('alt' => 'Incorporated')),
			array("controller" => "ccda", "action" => "incorporate",$patient_id,'plugin' => false), array('escape' => false,'label'=>'Incorporated')); ?>
		</div>
	</div>
</div>
<div  width="100%" style="margin-top: -290px;">
	
</div>
