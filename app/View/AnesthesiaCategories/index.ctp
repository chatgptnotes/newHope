<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Category Management', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Add Category'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'), array('controller' => 'opts', 'action' => 'listAllOt'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('AnesthesiaCategory.id', __('Id', true)); ?></td>
    -->
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('AnesthesiaCategory.name', __('Name', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('AnesthesiaCategory.description', __('Description', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $anesthesiacategories):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<!--  <td class="row_format"><?php echo $anesthesiacategories['AnesthesiaCategory']['id']; ?></td>
   -->
		<td class="row_format"><?php echo $anesthesiacategories['AnesthesiaCategory']['name']; ?>
		</td>
		<td class="row_format"><?php
		if(strlen($anesthesiacategories['AnesthesiaCategory']['description']) > 50) {
           	echo substr($anesthesiacategories['AnesthesiaCategory']['description'], 0, 50);
           } else {
           	echo $anesthesiacategories['AnesthesiaCategory']['description'];
           }
           ?>
		</td>
		<td><?php 
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Category', true),'title' => __('View Category', true))), array('action' => 'view',  $anesthesiacategories['AnesthesiaCategory']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Category', true),'title' => __('Edit Category', true))),array('action' => 'edit', $anesthesiacategories['AnesthesiaCategory']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Category', true),'title' => __('Delete Category', true))), array('action' => 'delete', $anesthesiacategories['AnesthesiaCategory']['id']), array('escape' => false),__('Are you sure?', true));
			
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

