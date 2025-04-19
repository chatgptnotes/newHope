
<style>
.mailindex{font-size:10px !important;
  color:#FFFFFF;
  border-bottom: 1px solid #4C5E64;
  float:left;
  width:100%;}
/*.mailindex_td{float: left;
    font-size: 10px;
    font-weight: bold;
    height: 90px;
    margin: 0 15px 20px 0;
    padding: 0;
    text-align: center;
    width: 70px;}
.inner_title{ clear:both;}*/
.mailindex_inner
{
	 float:left;
	 margin:0px;
	 padding:0px;
	 display:block;
	 width:75px;
	 font-weight:bold;
	 height: 80px;
	/*float: left;
    font-size: 10px;
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
	
	margin-top: 10px;
}

#menu_0{
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #cccccc;
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    left: 95px;
    margin: 0 auto;
    min-height: 65px;
    padding: 17px 18px 0px;
    position: absolute;
    left:86px;
    top: 472px;
    width: 354px;
    z-index: 2000;
}

#menu_1{
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #cccccc;
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    left: 95px;
    margin: 0 auto;
    min-height: 65px;
    padding: 17px 10px 0px 25px;
    position: absolute;
    left:86px;
    top: 556px;
    width: 277px;
    z-index: 2000;
}

#menu_2{
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #cccccc;
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    left: 89px;
    margin: 0 auto;
    min-height: 65px;
    padding: 9px 7px 0 25px;
    position: absolute;
    top: 637px;
    width: 152px;
    z-index: 2000;
}


#menu_3{
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #cccccc;
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    left: 89px;
    margin: 0 auto;
    min-height: 65px;
    padding: 6px 0 0 22px;
    position: absolute;
    top: 716px;
    width: 135px;
    z-index: 2000;
}
</style>

<!--<div class="inner_title" style="margin-bottom: 25px;">
 	<h3> -->
		<?php //echo __('Mailbox') ?>
<!-- 	</h3> -->
<!-- </div> -->
<div class="first_divmailbox" width = "100%"><div>
	<div class="mailindex_inner"><?php echo  $this->Html->link($this->Html->image('/img/icons/compose_mail.png', array('alt' => 'Compose')),
			array("controller" => "messages", "action" => "compose",$u_id,'plugin' => false), array('escape' => false,'label'=>'Compose')); ?>
	</div>
	
	<div class="mailindex_inner"><?php  echo  $this->Html->link($this->Html->image('/img/icons/inbox.png', array('alt' => 'Inbox')),
			array("controller" => "messages", "action" => "inbox",'plugin' => false), array('escape' => false,'label'=>'Inbox')); ?>
	</div>
	
	<div class="mailindex_inner"><?php echo  $this->Html->link($this->Html->image('/img/icons/mail_outbox.png', array('alt' => 'Outbox')),
			array("controller" => "messages", "action" => "outbox",'plugin' => false), array('escape' => false,'label'=>'Outbox')); ?>
	</div>
	
	<div class="mailindex_inner"><?php echo  $this->Html->link($this->Html->image('/img/icons/change_password_inner_1.png', array('alt' => 'Change Password')),
			array("controller" => "messages", "action" => "changepassword",'plugin' => false), array('escape' => false,'label'=>'Change Password')); ?>
	</div>
	
<!--	<div class="mailindex_inner"><?php // echo  $this->Html->link($this->Html->image('/img/icons/referral_mailbox.png', array('alt' => 'Referral Mailbox')),
// 			array("controller" => "messages", "action" => "ccdaMessage",'plugin' => false), array('escape' => false,'label'=>'Referral Mailbox')); ?>
 	</div> -->
 	
 	<div class="mailindex_inner" id="referral_element1">
			<?php echo  $this->Html->link($this->Html->image('/img/icons/referral_mailbox.png', array('alt' => 'Referral Mailbox')),
				'javascript:void(null)', array('escape' => false,'label'=>'Referral'));?>
		</div>
 	
	<!-- <td class="mailindex_td"><?php echo  $this->Html->link($this->Html->image('/img/icons/laboratory.png', array('alt' => 'Result')),array("controller" => "laboratories", "action" => "hlseven",'plugin' => false), array('escape' => false,'label'=>'Lab Mailbox'));?>
	</td> -->
<!--	<div class="mailindex_inner"><?php // echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Lab Mailbox')),array("controller" => "messages", "action" => "hl7Mailbox",'plugin' => false), array('escape' => false,'label'=>'Lab Mailbox'));?>
 	</div> -->
 	
 	<div class="mailindex_inner" id="lab_element1">
			<?php echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Lab Mailbox')),
				'javascript:void(null)', array('escape' => false,'label'=>'Laboratory'));?>
		</div>
 	
<!--	<div class="mailindex_inner"><?php //echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Immunization Mailbox')),array("controller" => "Hl7TextMessages", "action" => "hl7ImmunizationMailbox",'plugin' => false), array('escape' => false,'label'=>'Immunization Mailbox'));?>
 	</div> -->
 	
 	<div class="mailindex_inner" id="imune_element1"> 
			<?php echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Immunization Mailbox')),
				'javascript:void(null)', array('escape' => false,'label'=>'Immunization'));?>
 		</div>
 	
<!-- 	<div class="mailindex_inner"><?php //echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Syndromic Mailbox')),array("controller" => "Hl7TextMessages", "action" => "hl7AdtMailbox",'plugin' => false), array('escape' => false,'label'=>'Syndromic Mailbox'));?>
	</div> -->
	
	<div class="mailindex_inner" id="syndrom_element1"> 
			<?php echo  $this->Html->link($this->Html->image('/img/icons/HL7OUTER_1.png', array('alt' => 'Syndromic Mailbox')),
				'javascript:void(null)', array('escape' => false,'label'=>'Syndromic Mailbox'));?>
 		</div>
	
</div>
</div>


	<div id="menu_0" class="refer" style="display: none;" >
			<?php echo $this->element('referral_icon'); ?>
	</div>
	<div id="menu_1" class="Lab" style="display: none;" >
		<?php echo $this->element('hl7_list'); ?>
	</div>
	
	<div id="menu_2" class="imune" style="display: none;" >
		<?php echo $this->element('hl7_list_immunization'); ?>
	</div>
	
	<div id="menu_3" class="syndrom" style="display: none;" >
		<?php echo $this->element('hl7_list_adt'); ?>
	</div>
	
	
<script>
			

	$(function(){
	    $("body").click(function(){
	        $(".refer").hide();
	    });
	    $("#referral_element1").click(function(event){
	        $(".refer").toggle();
	        event.stopPropagation();
	    });
	})

	$(function(){
	    $("body").click(function(){
	        $(".Lab").hide();
	    });
	    $("#lab_element1").click(function(event){
	        $(".Lab").toggle();
	        event.stopPropagation();
	    });
	})
	
	$(function(){
	    $("body").click(function(){
	        $(".imune").hide();
	    });
	    $("#imune_element1").click(function(event){
	        $(".imune").toggle();
	        event.stopPropagation();
	    });
	})
		
	$(function(){
	    $("body").click(function(){
	        $(".syndrom").hide();
	    });
	    $("#syndrom_element1").click(function(event){
	        $(".syndrom").toggle();
	        event.stopPropagation();
	    });
	})
		
</script>
