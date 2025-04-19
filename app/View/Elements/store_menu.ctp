<style>
.ui-menu-item{
    color: black !important;
    cursor: pointer;
    list-style-image: url("../img/ui-icons_454545_256x240.png");
    margin: 0;
    min-height: 0;
    padding: 3px 1em 3px 0.4em;
    position: relative;
   }
   .ui-menu { width: 300px !important;
    color: #31859c !important;
    font-size: 12px;
    padding: -1 17px !important;
    line-height: 18px;
}
.ui-menu-item a {
    display: block;
    font-weight: normal;
    line-height: 1.5;
    min-height: 0;
    text-decoration: none;
}
 .ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited {
    background-color: white ;
    color: #ffffff;
    text-decoration: none;
}
 .sty{
    margin-left: 20px !important;
    padding-top: 33px !important;
     position: absolute!important;
    z-index: 2000 !important;
}
.ui-menu {
    color: blue !important;
    font-size: 12px !important;
    line-height: 21px !important;
}
</style>
<?php echo $this->Html->script(array('jquery-ui-1.10.2.js','jquery-ui-1.11.2.js'));
echo $this->Html->css(array('jquery-ui-1.11.2.css')); ?>
<style>
.ui-menu { width: 160px;
color: #31859c !important;
	font-size: 13px;
	line-height: 30px; 
	padding: 0 17px; }
	
</style>
<body>
	<div style="padding-top:15px;">
		<?php 
			echo $this->Html->image('icons/arrRight.jpg',array('title' => 'Store Menu','escape' => false,'id'=>'hideAndShow')); 
		?>
	 </div> 	
<div class="sty" id="storeMenuList">
<ul id="menu">
	
<li>Product List
	<ul>
	   <li><?php echo $this->Html->link('Product List',array('controller'=>'Store','action'=>'index','inventory'=>false),array('alt' => 'Product List'));?></li>
	   <li><?php echo $this->Html->link('Add Product',array('controller'=>'Store','action'=>'addProduct','inventory'=>false),array('alt' => 'Product List'));?></li>
	
	</ul>
</li>
<li>Supplier
	<ul> 
		<li><?php echo $this->Html->link('Supplier List',array('controller'=>'Store','action' => 'supplierList','sales'),array('alt' => 'supplierList'));?></li>
	     <li><?php echo $this->Html->link('Add Supplier',array('controller'=>'Store','action' => 'add_supplier','sales'),array('alt' => 'supplierList'));?></li>
	</ul>
</li>
<li >Manufacturers
	<ul> 
		<li><?php echo $this->Html->link('Manufacturers',array('controller'=>'Store','action'=>'manufacturingCompany','inventory'=>false),array('alt' => 'Manufacturers'));?></li>
	</ul>
</li>
<li >store
	<ul> 
		<li><?php echo  $this->Html->link('Store Requisition List',array('controller'=>'InventoryCategories','action'=>'store_requisition_list','inventory'=>false,'?'=>array('pharmacy'=>'pharmacy')),array('alt' => 'Store Requisition List'));?></li>
		<li><?php echo  $this->Html->link('Add Requisition ',array('controller'=>'InventoryCategories','action'=>'store_requisition','inventory'=>false,'?'=>array('pharmacy'=>'pharmacy')),array('alt' => 'Add Requisition'));?></li>
		<li><?php echo  $this->Html->link('Received Requisition List',array('controller'=>'InventoryCategories','action'=>'store_inbox_requistion_list','inventory'=>false,'?'=>array('pharmacy'=>'pharmacy')),array('alt' => 'Received Requisition List'));?></li>
	</ul>		
</li>	
<li>Location Consumption
	<ul>
		<li><?php echo  $this->Html->link('Location Consumption',array('controller'=>'Store','action'=>'productConsumption','inventory'=>false),array('alt' => 'Location Consumption'));?></li>
	 	<li><?php echo  $this->Html->link('Add New',array('controller'=>'Store','action'=>'productConsumption#',"inventory" => false,'?'=>array('pharmacy'=>'pharmacy')),array('alt' => 'Current Stock'));?></li>
		<li><?php echo  $this->Html->link('Issue Drug and Report',array('controller'=>'Store','action'=>'departmental_stock','inventory'=>false,'?'=>array('pharmacy'=>'pharmacy')),array('alt' => 'Department Level Stock'));?></li>
			
	</ul>
</li>
<li>Stock
  <ul>
      <li><?php echo  $this->Html->link('Current Stock',array('controller'=>'Store','action'=>'currentStock',"inventory" => false,'?'=>array('pharmacy'=>'pharmacy')),array('alt' => 'Current Stock'));?>
	  <li><?php echo  $this->Html->link('Department Level Stock',array('controller'=>'Store','action'=>'departmental_stock','inventory'=>false,'?'=>array('pharmacy'=>'pharmacy')),array('alt' => 'Department Level Stock'));?></li>
  	 <li><?php echo $this->Html->link('Stock Adjustment',array('controller'=>'Store','action'=>'stockAdjustment'),array('alt' => 'Stock Legder'))?></li>
     <li>Stock Adjustment
     	<ul>
         	<li><?php echo $this->Html->link('Stock Adjustment inside',array('controller'=>'Store','action'=>'stock_adjustment_inside'),array('alt' => 'Stock Legder'))?></li>
        </ul>
      </li>
      <li>Stock  
	  <ul> 
		 <li><?php echo $this->Html->link('Stock Legder',array('controller'=>'Store','action'=>'stockLedger'),array('alt' => 'Stock Legder'))?></li>
	  </ul>
</li> 
</ul>	 
</li>	
<li>Purchase Order
	<ul> 
		<li><?php echo $this->Html->link('Add Purchase Order',array('controller'=>'PurchaseOrders','action'=>'add_order','inventory'=>false),array('alt' => 'Add Purchase Order'))?></li>
		<li><?php echo $this->Html->link('Purchase Order List',array('controller'=>'PurchaseOrders','action'=>'purchase_order_list'),array('alt' => 'Purchase Order List'));?></li>
	</ul>
</li>
<li>Goods Received Notes 
	<ul> 
		<li><?php echo $this->Html->link('Add Purchase Order',array('controller'=>'PurchaseOrders','action'=>'add_order','inventory'=>false),array('alt' => 'Add Purchase Order'))?></li>
		<li><?php echo $this->Html->link('Purchase receipt List',array('controller'=>'PurchaseOrders','action'=>'purchase_receipt'),array('alt' => 'Purchase Order List'));?></li>
	</ul>
</li>
<li>Contracts 
	<ul> 
		<li><?php echo $this->Html->link('Add Contract',array('controller'=>'Contracts','action'=>'add_contract','inventory'=>false),array('alt' => 'Add Purchase Order'))?></li>
	</ul>
</li>	
	
<li>Reports
	<ul> 
      <li><?php echo  $this->Html->link('Reports',array('controller'=>'Reports','action' => 'current_stock','sales'),array('alt' => 'Reports'));?></li>
	    
	    <!--   <li><?php echo  $this->Html->link('View Purchase Return',array('controller'=>'Reports','action' => 'get_pharmacy_details','purchase_return',"inventory" => true),array('alt' => 'View Purchase Return'));?></li>
	  <li><?php echo $this->Html->link('',array('controller'=>'Reports','action' => 'inventory_outward_list','purchase_return',"inventory" => true),array('alt' => 'Store Outward'));?></li>
	   -->  
	
	</ul>
</li>
	</ul>
	</div>
</body>
<script>
$(document).ready(function(){
	$('#storeMenuList').hide();
		});
$(function() {
   $( "#menu" ).menu();
   });
$("#hideAndShow").click(function(event){
	$('#storeMenuList').toggle();
	});

$(document).click(function(){
$("#storeMenuList").hide();	
});

$("#storeMenuList,#hideAndShow").click(function(e){
    e.stopPropagation(); 
});

</script>