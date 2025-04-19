<?php   echo $this->Html->script(array('jquery.fancybox-1.3.4'));  
		echo $this->Html->css(array('jquery.fancybox-1.3.4')) ;
?>
<style>
.tableCell {
	border: 1px solid #4C5E64;
	padding: 2px 5px;
}
.inner_title{
	width: 96%!important;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Journal Voucher Narration');?>
	</h3>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('accountings',array('url'=>array('controller'=>'Accounting','action'=>'narration_box',$patientid,$voucherId),'id'=>'narration','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table width="70%" height="70%" style="text-align: center" align ="center">
	<tr class="row_title">
		<td style="text-align: center"><?php echo __('Narration')?><font color="red">*</font></td>
	</tr>
	<tr>
		<td class="tableCell"><?php echo $this->Form->input('narration', array('type'=>'textArea','id' => 'narration1', 'class'=>'validate[required]')); ?></td>
	</tr>
	<tr>
		<td colspan="0" align="right">
			<?php echo $this->Form->submit('Submit',array('div'=>false ,'class'=>'blueBtn','title'=>'Save','id'=>'submit'));?>
			<?php echo $this->Html->link(__('Cancel'), array('controller' => 'Accounting', 'action' => 'patient_journal_voucher'), array('title'=>'Cancel','class'=>'blueBtn'));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>


<script>
$(document).ready(function(){
	var close= '<?php echo $close?>';
	if(close=='1'){
		parent.$.fancybox.close();
	}
});  
</script>
