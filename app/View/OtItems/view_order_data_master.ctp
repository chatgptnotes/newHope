<div class="inner_title">
 <h3>	
  	<div style="float:left"><?php echo __('View Order Data Master'); ?></div>			
  	<div style="float:right;">
   	<?php echo $this->Html->link(__('Back'), array('action' => 'order_data_master'), array('escape' => false,'class'=>'blueBtn'));
   	?>
  	</div>
 </h3>
	<div class="clr"></div>
	</div>
	<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format">
 	<tr class="first">
  			<td class="row_format">
  		<strong>
   		<?php echo __('Order Category',true);?>
  		</strong>
  		</td>
  		<td>
   		<?php echo $opt['OrderDataMaster']['order_category']; ?>
  		</td>
 		</tr>
 	<tr>
  		<td class="row_format">
   		<strong>
   		<?php echo __('Name',true); ?>
   		</strong>
  		</td>
  		<td>
   		<?php echo $opt['OrderDataMaster']['name']; ?>
  		</td>
  	</tr>
  	
  	<tr>
  		<td class="row_format">
   		<strong>
   		<?php echo __('Description',true); ?>
   		</strong>
  		</td>
  		<td>
   		<?php echo $opt['OrderDataMaster']['description']; ?>
  		</td>
  	</tr>
  	
  	
  	
 
 	<tr>
   <td class="row_format"><strong>
   <?php echo __('Is Active',true); ?></strong>
   </td>
   <td class="row_format">
   <?php if($opt['OrderDataMaster']['is_active'] == 0) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
 	</table>
