<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View Item Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	
	<div class="clr"></div>
</div>
<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" align="center">
	<tr class="first">
		<td class="row_format"><strong>
		<?php echo __('Item Code')?> 
		</td>
		<td class="row_format">
			<?php echo $items['InventoryLaundry']['item_code']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		<?php echo __('Name')?> 
		</td>
		<td class="row_format">
		<?php echo $items['InventoryLaundry']['name']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		<?php echo __('Quantity')?> 
		</td>
		<td class="row_format">
		<?php echo $items['InventoryLaundry']['quantity']; ?>
		</td>
	</tr>
	<!-- <tr>
		<td class="row_format"><strong>
		<?php echo __('Minimum Quantity')?> 
		</td>
		<td class="row_format">
		<?php echo $items['InventoryLaundry']['min_quantity']; ?>
		</td>
	</tr> -->
	<tr>
		<td class="row_format"><strong>
		<?php echo __('Manufacturer')?> 
		</td>
		<td class="row_format">
		<?php echo $items['InventoryLaundry']['manufacturer']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		<?php echo __('Supplier')?> 
		</td>
		<td class="row_format">
		<?php echo $items['InventoryLaundry']['supplier']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		<?php echo __('Date') ; ?> 
		</td>
		<td class="row_format">
			<?php
			echo $this->DateFormat->formatDate2Local($items['InventoryLaundry']['date'],Configure::read('date_format'))
			  ?>
		</td>
	</tr> 
	<tr class="row_gray">
		<td class="row_format"><strong>
		 <?php echo __('Created By');  ?> 
		</td>
		<td class="row_format">
	         <?php  
				$user = ClassRegistry::init('User')->find('first',array('conditions'=>array('User.id'=>$items['InventoryLaundry']['created_by'])));
				//pr($user);exit;
			   echo ($user['User']['first_name']=='')?__('Admin'):$user['User']['first_name']." ".$user['User']['last_name']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		 <?php echo __('Modified By');  ?> 
		</td>
		<td class="row_format">
	         <?php  echo ($user['User']['first_name']=='')?__('Admin'):$user['User']['first_name']." ".$user['User']['last_name']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		 <?php echo __('Created On');  ?> 
		</td>
		<td class="row_format">
	         <?php 
	 				echo $this->DateFormat->formatDate2Local($items['InventoryLaundry']['create_time'],Configure::read('date_format'),true);
        	  ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong>
		 <?php echo __('Modified On');  ?> 
		</td>
		<td class="row_format">
	         <?php   echo $this->DateFormat->formatDate2Local($items['InventoryLaundry']['modify_time'],Configure::read('date_format'),true);  ?>
		</td>
	</tr>
	 
	</table>
</form>
