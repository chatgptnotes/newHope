<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Order Categories', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Add Order Category'), array('action' => 'add_order_category'), array('escape' => false,'class'=>'blueBtn'));
	      echo $this->Html->link(__('Back'), array('controller' => 'users', 'action' => 'menu', '?' => 'type=master', 'admin' => true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
 	</div>
 	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">

		<tr class="row_title">
			<td class="table_cell" align="left">
			<strong><?php echo $this->Paginator->sort('OrderCategory.Order_Category', __('Order Category', true)); ?>
			</strong></td>
			<td class="table_cell"align="left">
			<strong><?php echo $this->Paginator->sort('OrderCategory.Order_alias', __('Order Alias', true)); ?>
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
			<td class="row_format"align="left"><?php echo $opts['OrderCategory']['order_category']; ?>
			</td>
			<td class="row_format" align="left"><?php
		if(strlen($opts['OrderCategory']['order_alias']) > 50) {
           	echo substr($opts['OrderCategory']['order_alias'], 0, 50);
           } else {
          	echo $opts['OrderCategory']['order_alias'];
           }
           ?>
    
		
		<td class="row_action" align="left">
		<?php echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Order Category', true),'title' => __('View Order Category', true))), array('action' => 'view_order_category',  $opts['OrderCategory']['id']), array('escape' => false));
		?> 
		<?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Order Category', true),'title' => __('Edit Order Category', true))),array('action' => 'edit_order_category', $opts['OrderCategory']['id']), array('escape' => false));
		?> 
		<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Order Category', true),'title' => __('Delete Order Category', true))), array('action' => 'delete_order_category', $opts['OrderCategory']['id']), array('escape' => false),__('Are you sure?', true));
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

