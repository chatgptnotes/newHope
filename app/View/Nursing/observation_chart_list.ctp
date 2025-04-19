<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
	<h3>
		<?php echo __('Observation Chart List'); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Add'), array('action' => 'observation_chart',$patient_id), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'patient_information/',$this->params['pass'][0]), array('escape' => false,'class'=>'blueBtn'));
	?> </span>
</div>
<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>


<table class="table_format" border="0" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">

	<tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('ObservationChart.create_time', __('Record date/time', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('ObservationChart.date', __('Date', true)); ?>
		</strong></td>
		<td class="table_cell"  align="left"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$toggle =0;
	if(count($data) > 0) {
       foreach($data as $observation):
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }

       ?>
       <td  align="left"><?php
	echo $this->DateFormat->formatDate2local($observation['ObservationChart']['create_time'],Configure::read('date_format'),true);

	?>
	</td>
	<td  align="left"><?php
	echo $this->DateFormat->formatDate2local($observation['ObservationChart']['date'],Configure::read('date_format'),false);

	?>
	</td>
	<td class="row_action" align="left"><a
		href="<?php echo $this->Html->url(array('action' => 'observation_chart',$observation['ObservationChart']['patient_id']));?>?date=<?php echo $this->DateFormat->formatDate2local($observation['ObservationChart']['date'],Configure::read('date_format'),false);?>&patient_id=<?php echo $observation['ObservationChart']['patient_id'];?>"><?php echo $this->Html->image('icons/edit-icon.png', array('alt' => __('View', true), 'title' => __('View', true)));?>
	</a>
	</td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
		</span>
		</TD>
	</tr>
	<?php

      } else {
  ?>
	<tr>
		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
</table>
