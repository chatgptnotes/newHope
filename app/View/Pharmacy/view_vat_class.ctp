<div class="inner_title">
	<h3>
		<div style="float: left">
			&nbsp;
			<?php echo __('View VatClass Details'); ?>
		</div>
		<div style="float: right;">
			<?php
			echo $this->Html->link(__('Back to List'), array('controller'=>'Pharmacy','action' => 'vat'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>

<table border="0" class="table_view_format" cellpadding="0"
	cellspacing="0" width="550" align="center">
	<tr class="first">
		<td class="row_format"><strong> <?php echo __('Vat Class :')?>
		
		</td>
		<td class="row_format"><?php echo $data['VatClass']['vat_of_class']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Vat % :');  ?>
		
		</td>
		<td class="row_format"><?php  echo $data['VatClass']['vat_percent']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Sat % :');  ?>
		
		</td>
		<td class="row_format"><?php  echo $data['VatClass']['sat_percent']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Effective From :');  ?>
		
		</td>
		
		<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($data['VatClass']['effective_from'],Configure::read('date_format')); ?>
		</td>
	</tr>

</table>