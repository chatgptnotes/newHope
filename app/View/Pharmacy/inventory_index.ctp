
<?php echo $this->Html->script(array('jquery.blockUI')); ?>

<div class="inner_title">
<h3> &nbsp; <?php echo __('Pharmacy Manager', true); ?></h3>
	<span style="margin-top:-25px;">

	</span>
    <div align="right">
 <?php if($this->Session->read('website.instance')!='vadodara'){
 	echo $this->Html->link(__('Import Data', true),array('controller' => 'pharmacy', 'action' => 'import_data','admin' => true), array('escape' => false,'class'=>'blueBtn' ));
 	 echo $this->Html->link(__('Update OpeningStock'), 'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'updateStock','title'=>'To update opening stock'));
 }else if($this->Session->read('website.instance')=='vadodara'){
 	 /*   echo $this->Html->link(__('Import OTROL', true),array('controller' => 'pharmacy', 'action' => 'import_data','?'=>array('location'=>"otRol") ,'admin' => true), array('escape' => false,'class'=>'blueBtn' ));
 	echo $this->Html->link(__('Import ProductROL', true),array('controller' => 'pharmacy', 'action' => 'import_data','?'=>array('location'=>"productRol") ,'admin' => true), array('escape' => false,'class'=>'blueBtn' ));
 	echo $this->Html->link(__('Import ProductAPAMROL', true),array('controller' => 'pharmacy', 'action' => 'import_data','?'=>array('location'=>"kchApamRol") ,'admin' => true), array('escape' => false,'class'=>'blueBtn' )); 
 	echo $this->Html->link(__('Import PharmacyROL', true),array('controller' => 'pharmacy', 'action' => 'import_data','?'=>array('location'=>"pharmacyRol") ,'admin' => true), array('escape' => false,'class'=>'blueBtn' ));
 	echo $this->Html->link(__('Import Data', true),array('controller' => 'pharmacy', 'action' => 'import_data','?'=>array('location'=>"pharmacy") ,'admin' => true), array('escape' => false,'class'=>'blueBtn' ));
 	echo $this->Html->link(__('Import Discount Data', true),array('controller' => 'pharmacy', 'action' => 'import_data', 'admin' => true,'?'=>array('location'=>"discount")), array('escape' => false,'class'=>'blueBtn' ));
 	*/
 	echo $this->Html->link(__('Import KCHRC Data', true),array('controller' => 'pharmacy', 'action' => 'import_data','?'=>array('location'=>"kchrc"), 'admin' => true), array('escape' => false,'class'=>'blueBtn' ));
	echo $this->Html->link(__('Import Pharmacy Data', true),array('controller' => 'pharmacy', 'action' => 'import_data', '?'=>array('location'=>"Pharmacy"), 'admin' => true), array('escape' => false,'class'=>'blueBtn' )); 
	/*echo $this->Html->link(__('Import Expensive', true),array('controller' => 'pharmacy', 'action' => 'import_data', '?'=>array('location'=>"expensive"), 'admin' => true), array('escape' => false,'class'=>'blueBtn' ));
	echo $this->Html->link(__('Import APAMmrp ', true),array('controller' => 'pharmacy', 'action' => 'import_data', '?'=>array('location'=>"APAMmrp"), 'admin' => true), array('escape' => false,'class'=>'blueBtn' )); */
 }
 
?>
</div>
</div>
<ul class="interIcons">

 <li>  <?php echo $this->Html->link($this->Html->image('/img/icons/item-list.gif', array('alt' => 'item_list')),array("action" => "item_list",'list','plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Item List',true); ?></li> 
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/item-rate.gif', array('alt' => 'Item Rate')),array("action" => "view_item_rate",'inventory'=>false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Item Rate',true); ?></li>
				 
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/store-requisition-issue-slip.jpg', array('alt' => 'Store Rquisition')),array("controller"=>"InventoryCategories","action" => "store_requisition_list",'inventory'=>false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Store Requisition',true); ?> </li>
 
<!-- All Purchase Modules -->
				
<!--  <li>  <?php echo $this->Html->link($this->Html->image('/img/icons/purchase-receipt.gif', array('alt' => 'Purchase Receipt')),array("action" => "purchase_receipt",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Purchase Receipt',true); ?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/purchase-view.gif', array('alt' => 'View Purchase')),array('action' => 'purchase_details_list'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('View Purchase',true); ?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/purchase-return-view.gif', array('alt' => 'Purchase Return')),array("action" => "purchase_return",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Purchase Return',true); ?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-return-view.gif', array('alt' => 'View Purchase Return')),array('action' => 'get_pharmacy_details','purchase_return'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('View Purchase Return',true); ?></li>-->

<!-- End Of Purchase Modules -->				
				
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-bill.gif', array('alt' => 'Sales Bill')),array("action" => "sales_bill",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Sales Bill',true); ?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-view.gif', array('alt' => 'View Sales')),array('action' => 'pharmacy_details','sales'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('View Sales',true); ?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-return.gif', array('alt' => 'Sales Return')),array("action" => "sales_return",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Sales Return',true); ?></li>

<!--<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-return-view.gif', array('alt' => 'View Sales Return')),array('action' => 'pharmacy_details','sales_return'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('View Sales Return',true); ?></li>
  <li>  <?php //secho $this->Html->link($this->Html->image('/img/icons/patient-outward-inner.jpg', array('alt' => 'Pharmacy Outward')),array('action' => 'inventory_outward_list'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Pharmacy Outward',true); ?></li> -->
<li>  <?php //echo $this->Html->link($this->Html->image('/img/icons/supplier-list.gif', array('alt' => 'Supplier List','title' => __('Supplier List'))),array("controller"=>"Pharmacy","action" => "supplier_list", "inventory" => true,"admin" => false,'plugin' => false,'superadmin'=> false),  array('escape' => false,'label'=>'Supplier List')); ?></li>

<!-- Direct Sales Bill  for Hope -->
<?php if($this->Session->read('website.instance')!='vadodara'){?>
 <li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-bill.gif', array('alt' => 'Direct Sales Bill')),array("controller"=>"Pharmacy","action" => "other_sales_bill",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Direct Sales Bill',true); ?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-view.gif', array('alt' => 'View Sales')),array('action' => 'get_other_pharmacy_details','sales'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Direct Sales View',true); ?></li>	
<?php }?>	
<!-- END OF Direct Sales -->

<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/report-int.jpg', array('alt' => 'Report')),array('action' => 'pharmacy_report','purchase'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Pharmacy Report',true); ?></li>
<?php $website = $this->Session->read('website.instance');
		if($website == "kanpur"){
			if($this->Session->read('locationid') == 1 || $this->Session->read('locationid') == 25){	
			}else{?>			
				<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-bill.gif', array('alt' => 'Nurse Prescription')),array("controller"=>"Nursings","action" => "add_prescription",'inventory'=>false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Nurse Prescriptions',true); ?></li>
			<?php }
		}else{?>
			<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-bill.gif', array('alt' => 'Nurse Prescription')),array("controller"=>"Nursings","action" => "add_prescription",'inventory'=>false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Nurse Prescriptions',true); ?></li>
		<?php } ?>
<!--  <li>  <?php //echo $this->Html->link($this->Html->image('/img/icons/report-int.jpg', array('alt' => 'Report')),array('action' => 'pharmacy_all_reports','purchase'), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php //echo __('Reports',true); ?></li>-->
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-bill.gif', array('alt' => 'Duplicate Sales Bill')),array("action" => "duplicate_sales_bill",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Duplicate Sales Bill',true); ?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-view.gif', array('alt' => 'Duplicate Sales Bill View')),array("action" => "duplicate_sales_details",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Duplicate Sales Bill view',true); ?></li>
<?php if($website != "vadodara"){?>			
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/sales-view.gif', array('alt' => 'Pharmacy Advance Payment')),array("action" => "inpatientList","inventory" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Pharmacy Advance Payment',true); ?></li>
<?php }?>
<?php if($website == "kanpur"){?>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/store-requisition-issue-slip.jpg', array('alt' => 'Stock Transfer')),array("controller"=>"InventoryCategories","action" => "stock_requisition_list",'inventory'=>false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Stock Transfer Requisition',true); ?> </li>
<?php }?>
 
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/store-requisition-issue-slip.jpg', array('alt' => 'Treatment Sheet')),array("controller"=>"Pharmacy","action" => "treatmentSheet",'inventory'=>false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Treatment Sheet',true); ?> </li>
</ul>

<script>
$("#updateStock").click(function() {
    loading();
    $.ajax({ 
          url: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "updateOpeningStock" ,"inventory" => false,"plugin"=>false)); ?>",
          success : function(data){
              alert(data);
              onCompleteRequest();
          }
    })
});

function loading(){
    $('body').block({
        message: '',
       css: {
            padding: '5px 0px 5px 18px',
            border: 'none',
            padding: '15px',
            backgroundColor: '#000000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            color: '#fff',
            'text-align':'left'
        },
        overlayCSS: { backgroundColor: '#00000' } 
    });
    function onCompleteRequest(id){
		 $('body').unblock();
	} 
}

</script>