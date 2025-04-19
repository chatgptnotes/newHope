<style>.row_action img{float:inherit;}</style>

<?php
if(!empty($errors)) {
	?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>
<div class="inner_title">
<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
	<h3>
		&nbsp;
		<?php echo __('Store Management - Supplier List', true); ?>
	</h3>
<span> 
<?php 
	echo $this->Html->link(__('Add Supplier'), array('action' => 'add_supplier'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'department_store','admin'=>false,'?'=>array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
	?>

	</span>

</div>
<div class="btns">
	<?php 
	echo $this->Html->link(__('Search Supplier'), array('action' => 'search','InventorySupplier'), array('escape' => false,'class'=>'blueBtn'));
	?>
	
</div>
<?php echo $this->Form->create( 'InventorySupplier', array('id' => 'inventorySupplier','type'=>'GET'));?>
<table>
  <tr>
	<td>
	<?php 	
	echo $this->Form->input('name', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'placeholder'=>'Types to Search'));
	echo $this->Form->hidden( 'supplier_id', array('id' => 'supplier_id'));?>
	</td>
	<td><?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false));?></td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<tr>
		<td colspan="8" align="right"></td>
	</tr>
	<tr class="row_title">

		<td class="table_cell" align="left"><strong><?php echo  $this->Paginator->sort('InventorySupplier.name', __('Supplier Name'))  ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?>
		
		</td>

		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('InventorySupplier.code', __('Account Number')) ; //echo $this->Paginator->sort('is_active', __('Pack', true)); ?>
		
		</td>
		<td class="table_cell" align="left"><strong><?php echo __('DL No.', true); ?>
		
		</td>
		<td class="table_cell" align="left"><strong><?php echo __('CST No.', true); ?>
		
		</td>
		<td class="table_cell" align="left"><strong><?php echo __('S.Tax No.', true); ?>
		
		</td>
		<td class="table_cell" align="left"><strong><?php echo __('Phone', true); ?>
		
		</td>
		<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?>
		
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $supplier):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

		<td class="row_format" align="left"><?php echo $supplier['InventorySupplier']['name']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $supplier['InventorySupplier']['code']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $supplier['InventorySupplier']['dl_no']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $supplier['InventorySupplier']['stax_no']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $supplier['InventorySupplier']['cst']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $supplier['InventorySupplier']['phone']; ?>
		</td>
		<td class="row_action" align="left"><?php 
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Insurance Type', true),'title' => __('View Item', true))), array('action' => 'view_supplier',  $supplier['InventorySupplier']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Insurance Type', true),'title' => __('Edit Item', true))),array('action' => 'edit_supplier', $supplier['InventorySupplier']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Insurance Type', true),'title' => __('Delete Item', true))), array('action' => 'supplier_delete', $supplier['InventorySupplier']['id']), array('escape' => false),__('Are you sure?', true));
			
		?></td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="10" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
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
$(document).ready(function(){		
 	$('#name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name","null","null","null", "admin" => false,"plugin"=>false)); ?>",
		setPlaceHolder : false,
		select: function(event,ui){	
	   	$('#supplier_id').val(ui.item.id);
	   			
	},
	 messages: {
         noResults: '',
         results: function() {},
   },
});
});

	</script>
		

