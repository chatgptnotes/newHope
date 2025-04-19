<div class="inner_title">
	<h3>
		<div style="float: left">
			&nbsp;
			<?php echo __('View Store Location Details'); ?>
		</div>
		<div style="float: right;">
			<?php
			echo $this->Html->link(__('Back to List'), array('controller'=>'Locations','action' => 'storeLocation'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>

<table border="0" class="table_view_format" cellpadding="0"
	cellspacing="0" width="550" align="center">
	<tr class="first">
		<td class="row_format"><strong> <?php echo __('Location Name')?>
		
		</td>
		<td class="row_format"><?php echo $location['StoreLocation']['name']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Specialty');  ?>
		
		</td>
		<td class="row_format"><?php  echo ($location['Department']['name']); ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Role');  ?>
		
		</td>
		<td class="row_format"><?php  echo implode(', ',$role); ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Account');  ?>
		
		</td>
		<td class="row_format"><?php  echo $location['Account']['name']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Type');  ?>
		
		</td>
		<td class="row_format"><?php  echo $location['LocationType']['name']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Assignment Path Rule');  ?>
		
		</td>
		<td class="row_format"><?php 
		echo $location['StoreLocation']['assignment_path_rule'];
		?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Description');  ?>
		
		</td>
		<td class="row_format"><?php  echo $location['StoreLocation']['description'];?>
		</td>
	</tr>

</table>