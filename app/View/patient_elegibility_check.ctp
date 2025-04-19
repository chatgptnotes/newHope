<style>
.styleclass{
	width:150px;
}

</style>

<div class="inner_title">
	<h3>
		<?php echo __('Patient Insurance Eligibility and Benefit Check');?>
	</h3>
</div>

<table style="width:100%">

<tr>
<td class="styleclass"><?php echo __("Coverage"); ?></td>
<td class="styleclass"><?php echo __("Unknown"); ?></td>
</tr>

<tr>
<td class="styleclass"><?php echo __("Last Updated"); ?></td>
<td class="styleclass"><?php echo __("N/A"); ?></td>
</tr>

<tr>
<td class="styleclass"><?php echo __("Coverage Details"); ?></td>
<td class="styleclass"><?php echo __("None"); ?></td>
</tr>

<tr>
<td class="styleclass"><?php echo $this->Form->input('Billing.service_type',array('id'=>'service_type','type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter-only]]','style'=>'width:150px;'));?></td>
<td class="styleclass"><?php echo __("None"); ?></td>
</tr>

</table>