<div class="inner_title">
<h3><div style="float:left">&nbsp; <?php echo __('View Service Details', true); ?></div></h3>
	<div style="float:right;"><?php
	     echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	?></div>
	<div class="clr"></div>
</div>
<div class="clr"></div>
<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" align="center">

	<tr class="first">
		<td class="title">
		<?php echo __('Service Name'); ?> 
		</td>
		<td >
	        <?php 
	        	echo ucfirst($services[0]['Service']['name']);
	        ?>
		</td>
	</tr>
		<?php 
		
			$j =2;
			$count = count($services) ;
			foreach($services as $service) {
				 if($j%2 == 0) {
					$class1 = 'row_none';
					$class2 = 'row_gray';
				 } 
				
		?>
			<tr class = '<?php echo $class1; ?>'>
				<td class="title">
				<?php echo __('Sub Service'); ?> 
				</td>
				<td>
			       <?php 
				        	echo $service['SubService']['service'];
				        ?>
				</td>
			</tr>
			<tr class = '<?php echo $class2; ?>'>
				<td class="title">
				<?php echo __('Cost'); ?> 
				</td>
				<td>
			       <?php 
				        	echo $service['SubService']['cost'];
				        ?>
				</td>
			</tr>
		<?php
			$j++; 
		} 
		?>	 
	<tr>
	<td class="title">
	<?php echo __('Description'); ?> 
	</td>
	<td>
		 	<?php 
	        	echo ucfirst($services[0]['Service']['description']);
	        ?>
	</td>
	</tr>	 
	
	</table>
 
 