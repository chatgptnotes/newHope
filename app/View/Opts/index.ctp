<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('OR Room', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Add OR'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'), array('controller' => 'opts', 'action' => 'listAllOt'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<!-- <tr>
		<td colspan="5" align="right"><?php 
		echo $this->Html->link(__('Add OR'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
		?>
		</td>
	</tr> -->
	<tr class="row_title">
		<!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('Opt.id', __('Id', true)); ?></strong></td>
    -->
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Opt.number', __('OR Number', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Opt.name', __('OR Name', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Opt.description', __('Description', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $opts):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<!-- <td class="row_format"><?php echo $opts['Opt']['id']; ?></td>
    -->
		<td class="row_format"><?php echo $opts['Opt']['number']; ?>
		</td>
		<td class="row_format"><?php echo $opts['Opt']['name']; ?>
		</td>
		<td class="row_format"><?php
		if(strlen($opts['Opt']['description']) > 50) {
           	echo substr($opts['Opt']['description'], 0, 50);
           } else {
           	echo $opts['Opt']['description'];
           }
           ?>
		</td>
		<td><?php 
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View OT', true),'title' => __('View OT', true))), array('action' => 'view',  $opts['Opt']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit OT', true),'title' => __('Edit OT', true))),array('action' => 'edit', $opts['Opt']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete OT', true),'title' => __('Delete OT', true))), array('action' => 'delete', $opts['Opt']['id']), array('escape' => false),__('Are you sure?', true));
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

