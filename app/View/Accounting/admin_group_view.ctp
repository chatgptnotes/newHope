<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View Group Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'group_creation'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	
	<div class="clr"></div>
</div>
<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" align="center">
	<tr class="first">
		<td class="row_format"><strong>
		<?php echo __('Name')?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($view['AccountingGroup']['name']); ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		<?php echo __('Description')?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($view['AccountingGroup']['description']); ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		<?php echo __('Under Account Type') ; ?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($view['AccountingGroup']['account_type']); ?>
		</td>
	</tr> 
	<tr>
		<td class="row_format"><strong>
		<?php echo __('Group behave like a sub-ledger?') ; ?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($view['AccountingGroup']['is_subledger']); ?>
		</td>
	</tr> 
	<tr  class="row_gray" >
		<td class="row_format"><strong>
		<?php echo __('Net Debit/Credit balances for reporting?') ; ?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($view['AccountingGroup']['net_reporting']); ?>
		</td>
	</tr> 
	<tr >
		<td class="row_format"><strong>
		 <?php echo __('Created On');  ?> 
		</td>
		<td class="row_format">
	         <?php    
	         echo $this->DateFormat->formatDate2Local($view['AccountingGroup']['created_time'],Configure::read('date_format'));
								   		
	         ?>
		</td>
	</tr>
	<tr  class="row_gray">
		<td class="row_format"><strong>
		 <?php echo __('Modified On');  ?> 
		</td>
		<td class="row_format">
	         <?php   
echo $this->DateFormat->formatDate2Local($view['AccountingGroup']['modified_time'],Configure::read('date_format'));
			
	         ?>
		</td>
	</tr>
	 
	</table>

