<style>
.text_center{ text-align:center;}
.row_action img {
    
}
</style>
<div class="inner_title">
<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
	<h3>
		<?php echo __('Purchase Orders list', true); ?>
	</h3><span>
		<?php
			echo $this->Html->link(__('Add Purchase Order'),array('controller'=>'PurchaseOrders','action'=>'add_order'), array('escape' => false,'class'=>'blueBtn'));
		?>
		
		<?php
			echo $this->Html->link(__('Back'),array('controller'=>'Pharmacy','action'=>'department_store'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>
<table border="0" class="table_format" cellpadding="5" cellspacing="0"
		width="100%">
		<?php echo $this->Form->create('PurchaseOrder',array('type'=>'GET')); ?>
		<tbody>
			<tr class="row_title">
			<td> &nbsp;</td>
				<td><?php echo __("Service Provider :"); ?></td>
				<td><?php
					echo  $this->Form->input("supplier_name", array('type'=>'text','id' => 'supplier_name','name'=>'supplier_name','label'=> false, 'div' => false, 'error' => false));
					echo $this->Form->hidden("supplier_id",array('id'=>'supplier_id','value'=>''));
				?>
				</td>
				
				<td><?php echo __("Purchase Order No :"); ?></td>
				<td><?php
					echo  $this->Form->input("order_no", array('type'=>'text','id' => 'purchase_order','name'=>'purchase_order','label'=> false, 'div' => false, 'error' => false));
					echo $this->Form->hidden("purchase_order_id",array('id'=>'purchase_order_id','value'=>''));
				?>
				</td>
				
				<td><?php echo __("Status:");?></td>
				<td><?php $status = array('Pending'=>'Pending','Closed'=>'Closed');?>
			<?php echo $this->Form->input('status',array('type'=>'select','empty'=>'All','options'=>$status,'class'=>'textBoxExpnd','name'=>"status",'id'=>'status','div'=>false,'label'=>false));?>
				</td>
				
				<td align="right" colspan="2">
				<input name="" type="submit" value="Search" class="blueBtn search" />
				</td>
				<td></td>
			</tr>
		</tbody>
		<?php echo $this->Form->end(); ?>
	</table>
<?php if(!empty($PurchaseOrder)) { ?>

<table width="100%">
	<tr>
		<td colspan="4" align="center">
			<?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     		<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
    		<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
     		<span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
		</td>
	</tr>
</table>	

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_format" id="item-row">
	<thead>	
		<tr class="row_title">
			<td width="1%" align="center" valign="top" style="text-align: center;" class="table_cell" >Sr.No.</td>
			<td width="12%" align="center" valign="top" style="text-align: center;" class="table_cell">Purcahse Order No.</td>
			<td width="12%" align="center" valign="top" style="text-align: center;" class="table_cell">Order For.</td>
			<td width="20%" align="center" valign="top" style="text-align: center;" class="table_cell">Supplier</td>
			<td width="10%" valign="top" style="text-align: center;" class="table_cell">Type</td>
			<td width="10%" align="center" valign="top" style="text-align: center;" class="table_cell">Status</td>
			<td width="12%" valign="top" style="text-align: center;" class="table_cell">Created Date</td>
			<td width="20%" valign="middle" style="text-align: center;" class="table_cell">Action</td>			
		</tr>
	</thead>
	
	<tbody>
		<?php $count = 0; foreach($PurchaseOrder as $purchase) { $count++; ?>
		<tr class=" <?php if($count%2==0) echo "row_gray"; ?>">
		
			<td class="text_center row_format">
				<?php echo $count; ?>
			</td>
			
			<td class=" row_format" align="left">
				<?php echo $purchase['PurchaseOrder']['purchase_order_number']; ?>
			</td>
			
			
			<td class="row_format">
				<?php echo $purchase['StoreLocation']['name'];?>
			</td>
			
			<td class="row_format">
				<?php echo $purchase['InventorySupplier']['name']; ?>
			</td>
			
			<td class="row_format">
				<?php echo $purchase['PurchaseOrder']['type']; ?>
			</td>
			
			<td class="row_format">
				<?php echo $status = $purchase['PurchaseOrder']['status']; ?>
			</td>
			
			<td class="text_center row_format">
				<?php echo $this->DateFormat->formatDate2Local($purchase['PurchaseOrder']['create_time'],Configure::read('date_format'),true); ?>
			</td>
			
			<td align="right" class="row_action" style="text-align:right;">
			 <?php
				echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Item', true),'title' => __('View Item', true))),array('action'=>'view_purchase_order',$purchase['PurchaseOrder']['id']), array('escape' => false));
				if($purchase['PurchaseOrder']['status']=="Pending"){
					echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Item', true),'title' => __('Edit Item', true))),array('action'=>'edit_purchase_order',$purchase['PurchaseOrder']['id']), array('escape' => false));		
				}
				//echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Items', true),'title' => __('Print Items', true))),array('action'=>'printPurchaseOrder',$purchase['PurchaseOrder']['id']), array('escape' => false));
				/*echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Items', true),'title' => __('Print Items', true))),'javascript:void(0);',array('action'=>'printPurchaseOrder',$purchase['PurchaseOrder']['id']),array('escape' => false,'class'=>' printButton','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'PurchaseOrders','action'=>'printPurchaseOrder',
$purchase['PurchaseOrder']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));*/
				echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Item', true),'title' => __('Delete Item', true))),array('action'=>'delete_order',$purchase['PurchaseOrder']['id']), array('escape' => false),__('Are you sure?', true));
			?>
			<?php 
				if($status != "Closed")
				echo $this->Html->link($this->Html->image('icons/arrow_curved_blue1.png', array('alt' => __('Receive Goods', true),'title' => __('Receive Goods', true),'class'=>'edit','id'=>'edit_'.$purchase['PurchaseOrder']['id'])),'javascript:void(0)', array('escape' => false));
			?> 
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<table width="100%">
	<tr>
		<td colspan="4" align="center">
			<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			?>
			<?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     		<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
    		<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
     		<span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
		</td>
	</tr>
</table>		
		
<?php } else { echo "<table width='100%'><tr><td align='center'><strong>No Record Found..!!</strong></td></tr></table>";  }?>


<?php 					
	if(isset($this->params->query['print']) && !empty($_GET['id'])){ 
		echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'PurchaseOrders','action'=>'printPurchaseOrder',$_GET['id']))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
	}
?>
	
	
<script>

$('#supplier_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null','no','no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			var service_provider_id = ui.item.id;
			$("#supplier_id").val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
	
	$('#purchase_order').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "autocompletePurchaseOrder","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			var service_provider_id = ui.item.id;
			$("#purchase_order_id").val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});

	$(".edit").click(function()
	{
		newId = (this.id).split('_'); 
		window.location.href= "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "purchase_receipt"));?>"+"/"+newId[1];
	});
			
</script>