<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('OR Items', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('OR Item Allocation'), array('controller' => 'ot_items', 'action' => 'ot_item_allocation'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('OR Item Quantities'), array('action' => 'ot_item_quantities'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Add OR Item'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'), array('controller' => 'opts', 'action' => 'listAllOt'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('OtItemCategory.name', __('OR Item Category', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('PharmacyItem.name', __('OR Item', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('OtItem.description', __('Description', true)); ?>
		</strong></td>
		<td class="table_cell" align="center"><strong><?php echo __('Action', true); ?>
		</strong></td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $opts):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format"><?php echo $opts['OtItemCategory']['name']; ?>
		</td>
		<td class="row_format"><?php echo $opts['PharmacyItem']['name']; ?>
		</td>
		<td class="row_format"><?php
		if(strlen($opts['OtItem']['description']) > 50) {
           	echo substr($opts['OtItem']['description'], 0, 50);
           } else {
           	echo $opts['OtItem']['description'];
           }
           ?>
		</td>
		<td align="center"><?php 
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View OR Item', true),'title' => __('View OR Item', true))), array('action' => 'view',  $opts['OtItem']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit OR Item', true),'title' => __('Edit OR Item', true))),array('action' => 'edit', $opts['OtItem']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete OR Item', true),'title' => __('Delete OR Item', true))), array('action' => 'delete', $opts['OtItem']['id']), array('escape' => false),__('Are you sure?', true));
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

