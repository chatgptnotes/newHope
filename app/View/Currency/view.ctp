<div class="inner_title">
	<h3>	 <?php echo __('View Currency Details'); ?>		</h3>	
			<span>
				<?php
		       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
				?>
			</span>
	
	
	<div class="clr"></div>
</div>
<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" align="center">
	<tr class="first">
		<td class="row_format"><strong>
			<?php echo __('Currency Name')?> 
			</strong>
		</td>
		<td class="row_format">
			<?php echo ucfirst($data['Currency']['name']); ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		<?php echo __('Country Code')?></strong> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($data['Currency']['country_code']); ?>
		</td>
	</tr>
	<tr class="row_gray" >
		<td class="row_format"><strong>
		<?php echo __('Currency') ; ?></strong> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($data['Currency']['currency']); ?>
		</td>
	</tr> 
	<tr>
		<td class="row_format"><strong>
		<?php echo __('Currency Code') ; ?></strong> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($data['Currency']['currency_code']); ?>
		</td>
	</tr> 
	<tr class="row_gray">
		<td class="row_format"><strong>
		<?php echo __('Currency Symbol') ; ?></strong> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($data['Currency']['currency_symbol']); ?>
		</td>
	</tr> 
	 
	</table> 
