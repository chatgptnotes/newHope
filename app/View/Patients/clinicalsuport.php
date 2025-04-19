<?php
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
$vals = array('Hispanic','Non-Hispanic','Latino','Others');

?>
<style>
#span_new {
	float: left;
	margin-left: 113px;
	padding: 0;
}
</style>
<div class="inner_title">
	<!-- Start for search -->
	<div align="left">
		<?php echo $this->Form->create('clinicalsuport',array('action'=>'clinicalsuport','type'=>'post'));?>
		<div>
			<h3>Clinical Dession Support Intervension.</h3>
		</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<td><h4>Please select the Intervension</h4></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<td width="20px"><?php echo ("Hypertension Reminders"); ?>
				</td>
				<td><?php echo $this->Form->input('Hyptension', array('type' => 'checkbox','label'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td width="20px"><?php echo "Cervial Cancer Reminders "; ?>
				</td>
				<td><?php echo $this->Form->input('ccr', array('type' => 'checkbox','label'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td width="20px"><?php echo "Diabetes Reminders"; ?>
				</td>
				<td><?php echo $this->Form->input('dr', array('type' => 'checkbox','label'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td width="20px"><?php echo "Durg Medication Reminders"; ?>
				</td>
				<td><?php echo $this->Form->input('dmc', array('type' => 'checkbox','label'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td width="20px"><?php echo "Consolidated Reminders"; ?>
				</td>
				<td><?php echo $this->Form->input('conso', array('type' => 'checkbox','label'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td>	<?php echo $this->Form->end('Submit'); ?><?php //echo $this->Form->submit(__('Submit', true),array('controller'=>'doctors','action' => 'clinicalsuport'), array('escape' => false,'class'=>'grayBtn'));?></td>
			</tr>
			
			</table>
	
	</div>
</div>
