<?php
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css'));
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Order Category Management', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Add Order Category'), array('controller' => 'OrderCategories','action' => 'add','admin'=>true), array('escape' => false,'class'=>'blueBtn'));
	
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
	</span>
</div>
<?php echo $this->Form->create('',array('action'=>'admin_index'));?>
	<table border="0" class="table_format" cellpadding="3" cellspacing="0"
		width="60%" align="center">
		<tr class="row_title">
			<td class=" " align="left" width="30%"><?php echo __('Order Category Name') ?>
				:</td>
			<td class=" " width="20%"><?php 
			echo $this->Form->input('Order_Category_Name', array( 'id' => 'Order_Category_Name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false,'style'=>'width:280px;'));
			?>
			</td>			
			<td width="10%"><?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?></td>
			<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index','admin'=>true),array('escape'=>false, 'title' => 'refresh'));?></td>
		</tr>	  
	</table>
	<?php echo $this->Form->end();?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
		<tr class="row_title">			
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('OrderCategory.order_description', __('Order Category Name', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('OrderCategory.status', __('Status', true)); ?>
			<td class="table_cell"><strong><?php echo __('Action', true); ?>			
			</td>
		</tr>
		<?php 
		$cnt =0;
		if(count($data) > 0) {

       foreach($data as $OrderCategoryData):
       $cnt++;
       
      
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>	
		<td class="row_format"><?php echo $OrderCategoryData['OrderCategory']['order_description']; ?>
			</td>
			<td class="row_format"><?php echo $OrderCategoryData['OrderCategory']['status']; ?>
			</td>		
				
			<td><?php 
		//	echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view',  $OrderCategoryData['OrderCategory']['id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
			echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'edit', $OrderCategoryData['OrderCategory']['id'],'admin'=>true), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
		 	echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $OrderCategoryData['OrderCategory']['id'],'admin'=>true), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
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
			<TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
      }
      ?>
	</table>

	<script>	
	$(function() {
		$("#Order_Category_Name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","OrderCategory","order_description",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
	});
</script>