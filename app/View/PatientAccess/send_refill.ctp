<?php echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));?>
<?php echo $this->Form->create('',array('url'=>array('controllor'=>'PatientAccess','action'=>'sendRefill')));?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Request to Primary Care Provider', true);
		?>

	</h3>
	</div>
<table>
<tr>
<td><?php echo __('To')?></td>
<td><?php echo $this->Form->input('to',array('type'=>'text','label'=>false,'value'=>$getMedicationData['User']['username'],'readonly'=>'readonly'));?></td>
<?php  echo $this->Form->input('first_name',array('type'=>'hidden','label'=>false,'value'=>$getMedicationData['User']['first_name']));?>
<?php  echo $this->Form->input('last_name',array('type'=>'hidden','label'=>false,'value'=>$getMedicationData['User']['last_name']));?>
</tr>
<tr>
<td><?php echo __('From')?></td>
<td><?php  echo $this->Form->input('From',array('type'=>'text','label'=>false,'value'=>$getMedicationData['Patient']['lookup_name'],'readonly'=>'readonly'));?></td>
<?php  echo $this->Form->input('From1',array('type'=>'hidden','label'=>false,'value'=>$getMedicationData['Patient']['patient_id']));?>
</tr>
<tr>
<td><?php echo __('Subject')?></td>
<td><?php  echo $this->Form->input('subject',array('type'=>'text','label'=>false,'value'=>"Request For Refills",'readonly'=>'readonly'));?></td>
</tr>
<tr>
<td><?php echo __('Message')?></td>
<td><?php  echo $this->Form->input('message',array('type'=>'TextArea','label'=>false,'id'=>'msg1'));?></td>
</tr>
<tr>
<td><?php echo __('')?></td>
<td><?php  echo $this->Form->submit(__('Send Mail'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'submit'));?></td>
</tr>
</table>
<?php echo $this->Form->hidden('close',array('id'=>'close','value'=>$close));?>
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){
	var conditionsClose=$('#close').val();
	if($.trim(conditionsClose)=='close'){
		window.top.location.href="<?php echo $this->Html->url(array('controller'=>'Landings','action'=>'index'))?>";
		parent.$.fancybox.close();
	}
});
$('#submit').click(function(){
if($('#msg1').val()==''){
	$('#msg1').addClass('redClass');
	return false;
}
	
});
		</script>
		<style>
		.redClass{
		border-color:red;
		}
		</style>