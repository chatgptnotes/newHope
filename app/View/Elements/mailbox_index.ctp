
<?php //echo $this->Html->css(array('tooltipster.css','jBox.css','jquery.ui.all.css'));
//echo $this->Html->script(array('jquery.tooltipster.min.js','jBox.min.js','jquery.min.js'));?> 

<style>
.mailindex{font-size:10px !important;
  color:#FFFFFF;
  border-bottom: 1px solid #4C5E64;
  float:left;
  width:100%;
  }

  .mailindex_inner
{
	 float:left;
	 margin:0px;
	 padding:0px;
	 display:block;
	 width:75px;
	 font-weight:bold;
	 height: 80px;
	float: left;
    /*font-size: 10px;
    font-weight: bold;
    height: 90px;
    margin: 0 15px 20px 0;
    padding: 0;
    text-align: center;
    width: 70px;*/
	}
.mailindex_inner p{ float:left; clear:left;font-size:10px; height:27px; width:10px;}
.mailindex_inner a{ float:left;}
.mailindex_inner img{ width:35px; height:35px;}

.inner_title{ clear:both;}

.first_divmailbox{
	 
	padding-top: 10px;
}

#menu_temp{
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #cccccc;
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    left: 95px;
    margin: 0 auto;
    min-height: 65px;
    padding: 17px 17px 0px;
    position: absolute;
    left:86px;
    top: 395px;
    width: 347px;
    z-index: 2000;
}

#menu_temp1{
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #cccccc;
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    left: 95px;
    margin: 0 auto;
    min-height: 65px;
    padding: 17px 8px 0px 25px;
    position: absolute;
    left:86px;
    top: 472px;
    width: 277px;
    z-index: 2000;
}

#menu_temp2{
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #cccccc;
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    left: 89px;
    margin: 0 auto;
    min-height: 65px;
    padding: 14px 0 0 25px;
    position: absolute;
    top: 567px;
    width: 152px;
    z-index: 2000;
}

#menu_temp3{
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #cccccc;
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    left: 89px;
    margin: 0 auto;
    min-height: 65px;
    padding: 7px 0 0 25px;
    position: absolute;
    top: 663px;
    width: 137px;
    z-index: 2000;
}
</style>
<!-- <div class="inner_title" style="margin-bottom: 25px;">
	<h3> -->
		<?php //echo __('Mailbox') ?>
		
<!-- 	</h3> -->
<!-- </div> -->
		<?php $role = $this->Session->read('role');?>
<div width = "100%" class="first_divmailbox" >	<!-- this class="mailindex" is for bottom line -->
	<div>
		<div class="mailindex_inner">
			<?php echo  $this->Html->link($this->Html->image('/img/icons/compose_mail.png', array('alt' => 'Compose')),
				array("controller" => "messages", "action" => "compose_new",$u_id,$id,'plugin' => false), array('escape' => false,'label'=>'Compose')); ?>
		</div>
		
		<div class="mailindex_inner"><?php  echo  $this->Html->link($this->Html->image('/img/icons/inbox.png', array('alt' => 'Inbox')),
				array("controller" => "messages", "action" => "inbox",'plugin' => false), array('escape' => false,'label'=>'Inbox')); ?>
		</div>
		
		<div class="mailindex_inner"><?php echo  $this->Html->link($this->Html->image('/img/icons/mail_outbox.png', array('alt' => 'Outbox')),
				array("controller" => "messages", "action" => "outbox",'plugin' => false), array('escape' => false,'label'=>'Outbox')); ?>
		</div>
		<!-- 
		<div class="mailindex_inner"><?php //echo  $this->Html->link($this->Html->image('/img/icons/change_password_inner_1.png', array('alt' => 'Change Password')), array("controller" => "messages", "action" => "changepassword",'plugin' => false), array('escape' => false,'label'=>'Change Password')); ?>
		</div>
		 -->
<!-- 		<div class="mailindex_inner" id="referral_element1"><?php //echo  $this->Html->link($this->Html->image('/img/icons/referral_mailbox.png', array('alt' => 'Referral Mailbox')),
// 				array("controller" => "messages", "action" => "ccdaMessage",$id,'plugin' => false), array('escape' => false,'label'=>'Referral')); ?>
 		</div> -->
		
		<div class="mailindex_inner" id="referral_element1">
			<?php echo  $this->Html->link($this->Html->image('/img/icons/referral_mailbox.png', array('alt' => 'Referral Mailbox')),
				'javascript:void(null)', array('escape' => false,'label'=>'Referral'));?>
		</div>
		
		
		<!-- <td class="mailindex_td"><?php //echo  $this->Html->link($this->Html->image('/img/icons/laboratory.png', array('alt' => 'Result')),array("controller" => "laboratories", "action" => "hlseven",'plugin' => false), array('escape' => false,'label'=>'Lab'));?>
		</td> -->
		
<!-- 		<div class="mailindex_inner" > -->
			<?php //echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Lab Mailbox')),array("controller" => "messages", "action" => "hl7Mailbox",'plugin' => false), array('escape' => false,'label'=>'Laboratory'));?>
<!-- 		</div> -->
		<?php if(strtolower($role) != strtolower(Configure::read('patientLabel'))){?>
		<!-- <div class="mailindex_inner" id="lab_element1">
			<?php echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Lab Mailbox')),
				'javascript:void(null)', array('escape' => false,'label'=>'Laboratory'));?>
		</div> -->
		
<!-- 		<div class="mailindex_inner"> -->
			<?php //echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Immunization Mailbox')),array("controller" => "Hl7TextMessages", "action" => "hl7ImmunizationMailbox",'plugin' => false), array('escape' => false,'label'=>'Immunization'));?>
<!-- 		</div> -->
		
	<!-- 	<div class="mailindex_inner" id="imune_element1"> 
			<?php echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Immunization Mailbox')),
				'javascript:void(null)', array('escape' => false,'label'=>'Immunization'));?>
 		</div>
		 -->
<!-- 		<div class="mailindex_inner"> -->
			<?php //echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Syndromic Mailbox')),array("controller" => "Hl7TextMessages", "action" => "hl7AdtMailbox",'plugin' => false), array('escape' => false,'label'=>'Syndromic Surveillance'));?>
<!-- 		</div> -->
		
	<!-- 	<div class="mailindex_inner" id="syndrom_element1"> 
			<?php echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Syndromic Mailbox')),
				'javascript:void(null)', array('escape' => false,'label'=>'Syndromic Mailbox'));?>
 		</div>
	 -->	
		<div class="mailindex_inner">
			<?php  echo  $this->Html->link($this->Html->image('/img/icons/billingsummary_1.png', array('alt' => 'CCDA Reports')),array("controller" => "Ccda", "action" => "referal_to_specialist_report",'plugin' => false), array('escape' => false,'label'=>'CCDA Reports'));?>
		</div>
		<?php } //EOF role condition?>
	</div>
</div>

 
	<div id="menu_temp" class="refer" style="display: none;" >
		<?php echo $this->element('referral_icon'); ?>
	</div> 
	
	<div id="menu_temp1" class="Lab" style="display: none;" >
		<?php echo $this->element('hl7_list'); ?>
	</div>
	
	<div id="menu_temp2" class="imune" style="display: none;"  >
			<?php echo $this->element('hl7_list_immunization'); ?>
	</div>
	
	<div id="menu_temp3" class="syndrom" style="display: none;"  >
			<?php echo $this->element('hl7_list_adt'); ?>
	</div>
	
<script>

$(function(){		

		$("#referral_element1").click(function(event){
	       	event.stopPropagation();
	        $('.refer').toggle(); 
	        $(".Lab").hide();
	        $(".imune").hide();
	        $(".syndrom").hide();
	    });

	    $("#lab_element1").click(function(event){
	        $(".Lab").toggle();
	        event.stopPropagation();
	        $(".refer").hide();
	        $(".imune").hide();
	        $(".syndrom").hide();
	    });

	    $("#imune_element1").click(function(event){
	        $(".imune").toggle();
	        event.stopPropagation();
	        $(".refer").hide();
	        $(".Lab").hide();
	        $(".syndrom").hide();
	    });
	
	    $("#syndrom_element1").click(function(event){
	        $(".syndrom").toggle();
	        event.stopPropagation();
	        $(".Lab").hide();
	        $(".imune").hide();
	        $(".refer").hide();
	    });

		$("body").click(function(){
	        $(".imune").hide();
	        $(".syndrom").hide();
	        $(".Lab").hide();
	        $(".refer").hide();
	    });
});				
</script>
	
	
	


