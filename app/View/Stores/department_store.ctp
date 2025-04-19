<div class="inner_title">
<?php //echo $this->element('store_menu');?>
	<h3>
		&nbsp;
		
		<?php echo __('Store Manager', true); ?>
	</h3>
	<span style="margin-top: -25px;"> </span>
	<div align="right">
		<?php
		echo $this->Html->link(__('Import Data', true),array('controller' => 'pharmacy', 'action' => 'import_data', 'admin' => true), array('escape' => false,'class'=>'blueBtn' ));
		?>
	</div>
</div>
<ul
	class="interIcons">
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/item-list.gif', array('alt' => 'product_list')),array('controller'=>'Store',"action" => "index", "inventory" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Product List',true); ?>
	
	</li>


	<li><?php echo $this->Html->link($this->Html->image('/img/icons/supplier-list.gif', array('alt' => 'Supplier List')),array('controller'=>'Store',"action" => "supplierList","admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Supplier List',true); ?>
	
	</li>
	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/add_manufacturer.png', array('alt' => 'Manufacturers')),array('controller'=>'Store','action' => 'manufacturingCompany'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Manufacturers',true); ?></li>

 	<li>  <?php 
 			if($this->Session->read('role_code_name')==Configure::read('storemanager') || $this->Session->read('role_code_name')==Configure::read('adminLabel')){
 				echo $this->Html->link($this->Html->image('/img/icons/store-requisition-issue-slip.jpg', array('alt' => 'Store Requisition')),
				array('controller'=>'InventoryCategories',"action" => "store_inbox_requistion_list",'plugin' => false), array('escape' => false));
 			}else{
 				echo $this->Html->link($this->Html->image('/img/icons/store-requisition-issue-slip.jpg', array('alt' => 'Store Requisition')),
				array('controller'=>'InventoryCategories',"action" => "store_requisition_list",'plugin' => false), array('escape' => false));
			}

	 ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Store Requisition',true); ?></li>

	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/prodConsume.png', array('alt' => 'Location Consumption')),array('controller'=>'Store',"action" => "productConsumption",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Location Consumption',true); ?></li>
				
	<!--  <li>  <?php echo $this->Html->link($this->Html->image('/img/icons/item-rate.gif', array('alt' => 'Item Rate')),array("action" => "item_rate_master",'plugin' => false, "inventory" => true), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Item Rate',true); ?></li>-->


	<li><?php echo $this->Html->link($this->Html->image('/img/icons/item-rate.gif', array('alt' => 'Current Stock')),array('controller'=>'Store',"action" => "currentStock",'plugin' => false, "inventory" => false), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Current Stock',true); ?>
	
	</li>
	
	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/departStock.png', array('alt' => 'Department Level Stock')),array('controller'=>'Store','action' => 'departmental_stock'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Department Level Stock',true); ?></li>

	<li><?php echo $this->Html->link($this->Html->image('/img/icons/purchase-receipt.gif', array('alt' => 'Purchase Order Receipt')),array('controller'=>'PurchaseOrders','action' => 'add_order'), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Add Purchase Order',true); ?>
	
	</li>


	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/purchase-view.gif', array('alt' => 'Purchase Order List')),array("controller"=>"PurchaseOrders","action" => "purchase_order_list",'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;">
			<?php echo __('Purchase Order List',true); ?>
		</p>
	</li>
	
	
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/purchase-return-view.gif', array('alt' => 'Purchase Receipt')),array("controller"=>"PurchaseOrders","action" => "purchase_receipt",'plugin' => false), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('Goods Received Notes',true); ?>
		</p>
	
	</li>
	<?php if($this->Session->read('website.instance') != "vadodara") {?>
	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-return-view.gif', array('alt' => 'Add Contract')),array('controller'=>'Contracts','action' => 'add_contract',), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Add Contract',true); ?></li>
	<?php } ?>			
	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-view.gif', array('alt' => 'View Sales')),array('controller'=>'Store','action' => 'stockLedger'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Stock Legder',true); ?></li>
				
	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/stock2.png', array('alt' => 'Stock Adjustment')),array('controller'=>'Store','action' => 'stockAdjustment'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Stock Adjustment',true); ?></li>

	<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-view.gif', array('alt' => 'Reports')),array('controller'=>'Reports','action' => 'current_stock'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Reports',true); ?></li>	
				
	

	<!--<li><?php echo $this->Html->link($this->Html->image('/img/icons/sales-return-view.gif', array('alt' => 'View Purchase Return')),array('action' => 'get_pharmacy_details','purchase_return', "inventory" => true), array('escape' => false)); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php echo __('View Purchase Return',true); ?>
	
	</li>
	-->
	

	<!--  <li>  <?php echo $this->Html->link($this->Html->image('/img/icons/patient-outward-inner.jpg', array('alt' => 'Pharmacy Outward')),array('action' => 'inventory_outward_list', "inventory" => true), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Store Outward',true); ?></li>-->

	<li><?php //echo $this->Html->image('/img/icons/item-list.gif', array('alt' => 'item_list')); ?>
		<p style="margin: 0px; padding: 0px;">
			<?php // echo __('Pharmacy Report',true); ?>
	
	</li>
 
	


</ul>
