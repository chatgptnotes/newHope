<style>
.row_action img{
float:in]erit;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Order Data Master', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Add Order Data Master'), array('action' => 'add_order_data_master'), array('escape' => false,'class'=>'blueBtn'));
	      echo $this->Html->link(__('Back'), array('controller' => 'users', 'action' => 'menu', '?' => 'type=master', 'admin' => true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
 	</div>
 	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
 
		<tr class="row_title">
			<td class="table_cell" align="left">
			<strong><?php echo $this->Paginator->sort('OrderDataMaster.order_category', __('Order Category', true));?>
			</strong></td>
	
			
			<td class="table_cell"align="left">
			<strong><?php echo $this->Paginator->sort('OrderDataMaster.name', __('Name',true)); ?>
			</strong></td>
			
			<td class="table_cell"align="left">
			<strong><?php echo $this->Paginator->sort('OrderDataMaster.description', __('Description',true)); ?>
			</strong></td>
			
		
			<td class="table_cell" align="left" >
			<strong><?php echo __('Action', true); ?>
			</strong></td>
		</tr>
		
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       
      foreach($data as $opts):
       $cnt++;
       ?>
		<tr<?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"align="left"><?php echo $getOrderCateRecord[$opts['OrderDataMaster']['order_description']]; ?>
			</td>
			<td class="row_format" align="left"> <?php
		if(strlen($opts['OrderDataMaster']['name']) > 50) {
           	echo substr($opts['OrderDataMaster']['name'], 0, 50);
           } else {
          	echo $opts['OrderDataMaster']['name'];
           }
           ?></td>
           <td class="row_format" align="left"> <?php
		    if(strlen($opts['OrderDataMaster']['description']) > 50) {
           	echo substr($opts['OrderDataMaster']['description'], 0, 50);
           } else {
          	echo $opts['OrderDataMaster']['description'];
           }
           ?></td>
    
		
		<td class="row_action" align="left">
		<?php echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Order Data Master', true),'title' => __('View Order Data Master', true))),array('controller'=>'OtItems','action' => 'viewOrderDataMaster',  $opts['OrderDataMaster']['id']),  array('escape' => false));
		?> 
		
		<?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Order Data Master', true),'title' => __('Edit Order Data Master', true))),array('action' => 'edit_order_data_master', $opts['OrderDataMaster']['id']), array('escape' => false));
		?> 
		<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Order Data Master', true),'title' => __('Delete Order Data Master', true))), array('action' => 'delete_order_data_master', $opts['OrderDataMaster']['id']), array('escape' => false),__('Are you sure?', true));
		?>
		</td>
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="5" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
			</span>
			</TD>
		</tr>
		<?php
         } else {
  		?>
		<tr>
		<TD colspan="5" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
      }
      ?>
	</table>

