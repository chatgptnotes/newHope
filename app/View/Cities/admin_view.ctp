<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View City Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	
	<div class="clr"></div>
</div>
<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" align="center">
	<tr class="first">
		<td class="row_format"><strong>
		<?php echo __('City')?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($Cities['City']['name']); ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		<?php echo __('State')?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($Cities['State']['name']); ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		<?php echo __('Country') ; ?> 
		</td>
		<td class="row_format">
			<?php echo ucfirst($Cities['Country']['name']); ?>
		</td>
	</tr> 
	<tr>
		<td class="row_format"><strong>
		 <?php echo __('Created By');  ?> 
		</td>
		<td class="row_format">
	         <?php  echo ($Cities['User']['first_name']=='')?__('Admin'):$Cities['User']['first_name']." ".$Cities['User']['last_name']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		 <?php echo __('Modified By');  ?> 
		</td>
		<td class="row_format">
	         <?php  echo ($Cities['User']['first_name']=='')?__('Admin'):$Cities['User']['first_name']." ".$Cities['User']['last_name']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		 <?php echo __('Created On');  ?> 
		</td>
		<td class="row_format">
	         <?php    
	         echo $this->DateFormat->formatDate2Local($Cities['City']['create_time'],Configure::read('date_format'));
								   		
	         ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		 <?php echo __('Modified On');  ?> 
		</td>
		<td class="row_format">
	         <?php   
echo $this->DateFormat->formatDate2Local($Cities['City']['modify_time'],Configure::read('date_format'));
			
	         ?>
		</td>
	</tr>
	 
	</table>
</form>
