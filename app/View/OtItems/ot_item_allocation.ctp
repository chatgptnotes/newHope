<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('OR Item Allocation', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Back'), array('controller' => 'ot_items', 'action' => 'index'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr>
		<td colspan="6" align="right"><?php 
		//echo $this->Html->link(__('Request For OR Item'), array('action' => 'request_ot_item'), array('escape' => false,'class'=>'blueBtn'));
		?>
		</td>
	</tr>
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.full_name', __('Request Person', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Opt.name', __('OR Room', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('OptTable.name', __('Table Name', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('OtReplace.status', __('Status', true)); ?>
		</strong></td>
		<td class="table_cell" align="center"><strong><?php echo __('Action', true); ?>
		</strong></td>
	</tr>
	<?php
	$status = array('P' => 'Pending', 'R' => 'Rejected', 'A' => 'Accepted');
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $opts):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format"><?php echo $opts['User']['full_name']; ?></td>
		<td class="row_format"><?php echo $opts['Opt']['name']; ?>
		</td>
		<td class="row_format"><?php echo $opts['OptTable']['name']; ?>
		</td>
		<td class="row_format"><?php echo $status[$opts['OtReplace']['status']]; ?>
		</td>
		<td align="center"><?php 
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View OR Item Allocation', true),'title' => __('View OR Item Allocation', true))), array('action' => 'view_request_ot_item',  $opts['OtReplace']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Allocate OR Item', true),'title' => __('Allocate OR Item', true))),array('action' => 'edit_request_ot_item', $opts['OtReplace']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete OR Item Allocation', true),'title' => __('Delete OR Item Allocation', true))), array('action' => 'delete_request_ot_item', $opts['OtReplace']['id']), array('escape' => false),__('Are you sure?', true));
		?>
		</td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="6" align="center">
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
		<TD colspan="6" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
</table>

