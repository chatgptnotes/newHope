<div id="message_error" align="center"></div>
<div class="mailbox_div">
	<?php echo $this->element('mailbox_index');?>
</div>
<div class="mailbox_div">
	<?php echo $this->element('hl7_list');?>
</div>
<div class="inner_title">
	<h3><?php echo __('Result') ?></h3>
	<!-- <span><?php  echo $this->Html->link('Back',array("controller"=>"Messages","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span> -->
</div>
<div id="successMessage" align="center" class="message"
	style="display: none"></div>
<div align="right">
		<?php echo $this->Form->create('hlseven',array('type'=>'post'));?>
		<table width="50%" cellpadding="0" cellspacing="0" border="0"
		align='left' class="formFull formFullBorder">

		<tr>
			<td><strong><?php echo __(' Message')?>
				</strong></td>
			<td class=""><?php 	echo $this->Form->input('message', array('type'=>'text','label'=>false,'id' => 'message','row'=>'5','cols'=>'70','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
				</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right" style="padding-right: 25px;"><?php 	  echo $this->Form->submit(Submit,array('type'=>'submit','class'=>'blueBtn','div'=>false,'error'=>false)); ?></td>
		</tr>
			<?php echo $this->Form->end()?>
		</table>
</div>