<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View State Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" align="center" class = "table_view_format">
	<tr class="first">
		<td class="row_format"><strong>
		<?php echo __('State')?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($States['State']['name']); ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		<?php echo __('Country') ; ?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($States['Country']['name']); ?>
		</td>
	</tr> 
	<tr class="row_gray">
		<td class="row_format"><strong>
		 <?php echo __('Created By');  ?> 
		</td>
		<td class="row_format">
			 <?php  echo ($States['User']['first_name']=='')?__('Admin'):$States['User']['first_name']." ".$States['User']['last_name']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		 <?php echo __('Modified By');  ?> 
		</td>
		<td class="row_format">
			 <?php  echo ($States['User']['first_name']=='')?__('Admin'):$States['User']['first_name']." ".$States['User']['last_name']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		 <?php echo __('Created On');  ?> 
		</td>
		<td class="row_format">
			 <?php  echo $this->DateFormat->formatDate2Local($States['State']['create_time'],Configure::read('date_format')); ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		 <?php echo __('Modified On');  ?> 
		</td>
		<td class="row_format">
			 <?php  echo $this->DateFormat->formatDate2Local($States['State']['modify_time'],Configure::read('date_format'));  ?>
		</td>
	</tr>
	    
</table>
</form>