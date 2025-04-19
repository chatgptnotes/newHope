<script>

jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#changepassword").validationEngine();
	});
						
	</script>

<style>
.is_read{
font-weight: bold;
font-size: 14px;
}
#forward_message_text{
display:none;
}
#open_message{
display:none;
}
.class_td{
font-size:16px;
font-weight:bold;
background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
border-bottom: 1px solid #3E474A;
color: #FFFFFF;
}

.class_td1{background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
   border-bottom: 1px solid #3E474A;
   color: #FFFFFF; font-size:14px;font-weight:bold;
}
.class_td2{background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
   border-bottom: 1px solid #3E474A;
   color: #FFFFFF; font-size:14px;font-weight:bold;
}
.table_format{
border: 1px solid #3E474A;}
.email_format{border: 1px solid #3E474A;}

/**
 * for left element1
 */
.table_first{
 	margin-bottom: -20px;
 	
}

.td_second{
	border-left-style:solid; 
	padding-left: 25px; 
	padding-top: 25px
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}
.table_format{
	padding: 0px;
}


/* EOCode */


</style>
<div id="message_error" align="center"></div>

<div class="inner_title"  >
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Change Password') ?>
	</h3>
</div>


<table class="table_first" width="100%"  cellspacing='0' cellpadding='0'>
	<tr>
		<td valign="top" width="5%">
			<div class=""><!-- patient_info is removed from div -->
				<?php echo $this->element('mailbox_index');?>
			</div>
		</td>
		<td class="td_second" valign="top" >
<!--			<div class="inner_title" >
				<h3><?php //echo __('Change Password') ?></h3>
 			</div> -->
			<?php echo $this->Form->create('',array('action'=>'changepassword','type'=>'post','id'=>'changepassword','name'=>'changepassword'));?>
			
			<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
			
			 <tr class="row_title">
			<td class="table_cell" width="150px;"><?php echo __('Password') ?><font color="red">*</font></td>
			   <td class="table_cell" width="200px;"><strong><?php echo $this->Form->input('current_password', array('type'=>'password','class' => 'validate[required,custom[passrequired]] textBoxExpnd','id' => 'old_password','label'=>false)); ?></strong></td>
			   </tr>
			   <tr class="row_title">
			   <td class="table_cell"><?php echo __('New Password') ?><font color="red">*</font></td>
			   <td class="table_cell"><strong><?php echo $this->Form->input('new_password', array('type'=>'password','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'new_password','label'=>false)); ?></strong></td>
			   </tr>
			   <tr class="row_title">
			   <td class="table_cell"><?php echo __('Confirm Password') ?><font color="red">*</font></td>
			   <td class="table_cell"><strong><?php echo $this->Form->input('confirm_password', array('type'=>'password','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'current_password','label'=>false)); ?></strong></td>
			   </tr>
			   <?php //echo $this->Form->input('id', array('type'=>'hidden','class' => 'validate['',custom[newpassrequired],custom[equals]] textBoxExpnd','id' => 'id','label'=>false,'value'=>'')); ?>
			  <tr class="row_title">
			   <td class="table_cell"><input class="blueBtn" type="submit" value="Submit" id="submit">
			   <input class="grayBtn" type="button" value="Cancel" onclick="window.location='<?php echo $this->Html->url(array("controller" => 'messages', "action" => "index"));?>'">
			   </td>
			   <td class="table_cell"></td>
			   </tr>
			  
			</table>
			<?php echo $this->Form->end(); ?>
			<div>&nbsp;</div>
		</td>
	</tr>
</table>




