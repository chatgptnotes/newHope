<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Anesthesia Management', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Add Anesthesia'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'), array('controller' => 'opts', 'action' => 'listAllOt'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('Anesthesia.id', __('Id', true)); ?></td>
    -->
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Anesthesia.name', __('Name', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Anesthesia.description', __('Description', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $anesthesias):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<!-- <td class="row_format"><?php echo $anesthesias['Surgery']['id']; ?></td>
    -->
		<td class="row_format"><?php echo $anesthesias['Anesthesia']['name']; ?>
		</td>
		<td class="row_format"><?php
		if(strlen($anesthesias['Anesthesia']['description']) > 50) {
           	echo substr($anesthesias['Anesthesia']['description'], 0, 50);
           } else {
           	echo $anesthesias['Anesthesia']['description'];
           }
           ?>
		</td>
		<td><?php 
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Anesthesia', true),'title' => __('View Anesthesia', true))), array('action' => 'view',  $anesthesias['Anesthesia']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Anesthesia', true),'title' => __('Edit Anesthesia', true))),array('action' => 'edit', $anesthesias['Anesthesia']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Anesthesia', true),'title' => __('Delete Anesthesia', true))), array('action' => 'delete', $anesthesias['Anesthesia']['id']), array('escape' => false),__('Are you sure?', true));
			
		?></td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="10" align="center">
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
		<TD colspan="4" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
</table>

