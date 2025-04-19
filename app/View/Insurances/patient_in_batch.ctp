<?php echo $this->Html->css('internal_style.css');
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));
echo $this->Html->script(array('inline_msg','jquery.blockUI' ));?>
<div class="inner_title">
	<h3>
		<?php echo __('Patients In Batch'); ?>
	</h3>
	<span><?php  //echo $this->Html->link('Back',array("controller"=>"tariffs","action"=>"viewStandard"),array('escape'=>false,'class'=>'blueBtn','title'=>'Back')); ?>
	</span>

</div>
<table width="100%">
	<tr class="row_title">
		<td width="1%" align="center"><?php echo __('#')?></td>
		<td width="1%" align="center"><?php echo __('Patient Id')?></td>
		<td width="1%" align="center"><?php echo __('Name')?></td>
		<td width="1%" align="center"><?php echo __('Age')?></td>
		<td width="1%" align="center"><?php echo __('Gender')?></td>
		<td width="1%" align="center"><?php echo __('Primary Insurance')?></td>
		<td width="1%" align="center"><?php echo __('Secondary Insurance')?></td>
		<td width="1%" align="center"><?php echo __('Tertiary Insurance')?></td>
	</tr>
	<?php foreach($getpatientInBatch as $key=>$getBatch){?>
	<tr class="">
	<?php $id=$getBatch['Batch']['id'];?>
		<td width="1%" align="center"><?php echo $key+1;?></td>
		<td width="1%" align="center"><?php echo  $getBatch['Patient']['patient_id'];?></td>
		<td width="1%" align="center"><?php echo  $getBatch['Patient']['lookup_name'];?></td>
		<td width="1%" align="center"><?php echo ucfirst($getBatch['Patient']['age']);?></td>
		<td width="1%" align="center"><?php echo ucfirst($getBatch['Patient']['sex']);?></td>
		<td width="1%" align="center"><?php echo  $getBatch['NewInsurance']['tariff_standard_name'];?></td>
		<td width="1%" align="center"><?php echo $getBatch['Secondary']['0']['tariff_standard_name'];?></td>
		<td width="1%" align="center"><?php echo $getBatch['Secondary']['1']['tariff_standard_name'];?></td>
		
	</tr>
	<?php }?>
</table>