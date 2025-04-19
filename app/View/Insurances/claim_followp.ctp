<?php 
echo $this->Html->script(array('jquery-1.5.1.min','jquery-ui-1.8.5.custom.min.js'));
echo $this->Html->css(array('internal_style.css'));?>
<div class="clr"></div>
<div class="inner_title">
	<h3>
		<?php echo __('FollowUp'); ?>
	</h3>
</div>
<?php echo $this->Form->create('claimFollowp',array('id'=>'followupfrm','url'=>array('controller' => 'Insurances','action'=>'claimFollowp',$patientId,$finalBillId),
		'inputDefaults' => array( 'label' => false,'div' => false, 'error'=>false )));
?>
<table class="formFull" width="100%" align="center">
	<tr>
		<td width="20%" class="tdLabel"><?php echo __('Status',true);?>
		</td>
		<?php $status =array('Billed'=>'Billed','Created'=>'Created','Claim Process'=>'Claim Process','Re-Billed'=>'Re-Billed','Rejection'=>'Rejection',
				'Transfer'=>'Transfer');?>
		<td width="20%" class="tdLabel"><?php echo $this->Form->input('status',array('options'=>$status,'class'=>'textBoxExpnd'));?>
		</td>
	</tr>
	<tr>
		<td width="20%" class="tdLabel"><?php echo __('Description',true);?>
		</td>
		<td width="20%" class="tdLabel"><?php echo $this->Form->input('note',array('type'=>'textarea'));?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="tdLabel">&nbsp;</td>
		<td width="20%" class="tdLabel"><?php echo $this->Form->input('Submit',array('type'=>'submit','class'=>'blueBtn'));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){
	// condition to close fancyBox and show sucess msg to parent wind.
	if('<?php echo $recordSaved == true ?>'){
		$('#flashMessage', parent.document).html('Followup Note Saved Sucessfully');
		$('#flashMessage', parent.document).show();
		parent.hideFlash();
		parent.$.fancybox.close();
	}
});
</script>
