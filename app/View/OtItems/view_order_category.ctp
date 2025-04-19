<div class="inner_title">
 <h3>	
  	<div style="float:left"><?php echo __('View Order Category'); ?></div>			
  	<div style="float:right;">
   	<?php echo $this->Html->link(__('Back'), array('action' => 'order_category'), array('escape' => false,'class'=>'blueBtn'));
   	?>
  	</div>
 </h3>
	<div class="clr"></div>
	</div>
	<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format">
 	<tr class="first">
  			<td class="row_format">
  		<strong>
   		<?php echo __('Order Category',true); ?>
  		</strong>
  		</td>
  		<td>
   		<?php echo $opt['OrderCategory']['order_category']; ?>
  		</td>
 		</tr>
 	<tr>
  		<td class="row_format">
   		<strong>
   		<?php echo __('OrderAlias',true); ?>
   		</strong>
  		</td>
  		<td>
   		<?php echo $opt['OrderCategory']['order_alias']; ?>
  		</td>
  	</tr>
 
 	<tr>
  <td class="row_format"><strong>
   <?php echo __('Is Active',true); ?></strong>
  </td>
  <td class="row_format">
   <?php if($opt['OrderCategory']['is_active'] == 1) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
 	</table>
