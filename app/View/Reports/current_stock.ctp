<?php
	echo $this->Html->script(array('inline_msg','jquery.selection.js','jquery.fancybox-1.3.4'  ,'jquery.blockUI','jquery.contextMenu'));
?>

<style>

.tabularForm th{
	padding: 0px 0px ;
}
.table_format {
	/*border: 1px solid #3E474A;*/
	background:#f5f5f5;
}

.first_row{
	padding-bottom: 185px;
	
}

.row_gray{ background:none;}
.nav_link{ width:85%; float:left; margin:0px; padding:20px;}
.links{ float:left; font-size:13px; clear:left; line-height:30px;}
.links:hover{ background:#F5F5F5;padding:0px; margin:0px;text-decoration: none !important;}
.nav_link a:hover{text-decoration: none !important;}
.table_format td{ border-bottom:1px solid #DCDCDC;}
#report_1{ font-weight: bold;};

</style>


<div class="inner_title">
<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
<h3>&nbsp; <?php echo __('Current Stock', true); ?></h3>
	 <span align="right" >
	 <?php echo $this->Html->link(__('Back'), array('controller'=>'pharmacy','action' => 'department_store'), array('escape' => false,'class'=>'blueBtn'));?> 
	 
	 </span>
	
</div>
<?php echo $this->Form->create('',array('id'=>'stock_containt'));?>
			 <div class="clr ht5"></div>
			<table  align="center" cellpadding="0" cellspacing="" border="0" >
				<tr>
					<td><?php echo __(" Department : "); ?></td>
					<td>
		 				<?php echo $this->Form->input('department',array('name'=>'department','empty'=>'Please select','type'=>'select','class'=>'textBoxExpnd','options'=>$location_id, 'label'=> false,'div' => false,)); ?>
					</td>
					<td>&nbsp;</td>
					<td><?php echo __(" Item Name : "); ?></td>
					<td>
						<?php echo $this->Form->input('',array('type'=>'text','class'=>'textBoxExpnd','name'=>'item_name', 'id'=>'item_name','label'=>false,'div'=>false)); ?>
					</td>
					<td>&nbsp;</td>
					<td ><?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false)); ?></td>
					<td>&nbsp;</td>
					<td><?php echo $this->Form->submit(__('Generate Excel'),array('style'=>'padding:0px;','class'=>'blueBtn','id'=>'ExcelGenerate','div'=>false,'label'=>false)); ?> </td>
					<td>&nbsp;</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'current_stock'),array('escape'=>false, 'title' => 'refresh'));?></td>
				</tr>
			</table> 
			<div class="clr ht5"></div>
			<table width="100%" class="tabularForm" cellpadding="0" cellspacing="0" >
				<tr>
					<thead>
					
						<th width="5px" valign="top" style="text-align:center;">SNo.</th>
						<th width="70px" valign="top" style="text-align:center;">Item Name</th>
						<th width="60px" valign="top" style="text-align:center;">Cur.Stock</th>
						<th width="65px" valign="top" style="text-align:center;">ToatalCur.Stock</th>
						<th width="60px" valign="top" style="text-align:center;">BatchNo.</th>
						<th width="65px" valign="top" style="text-align:center;">ExpiryDate</th>
						<th width="60px" valign="top" style="text-align:center;">ReOrderLevel</th>
						<th width="60px" valign="top" style="text-align:center;">PurPrice</th>
						<th width="51px" valign="top" style="text-align:center;">MRP</th>
						<th width="65px" valign="top" style="text-align:center;">TotalPrice</th>
						<th width="51px" valign="top" style="text-align:center;">TotalSale</th>
					
					</thead>
				</tr>
				<?php 
					$i=0;
					foreach ($record as $records){
					$i++;	
				?>
				<tr>
					<td align="center"><?php echo $i;?></td>
					<td align="center"><?php echo $records['StockMaintenanceDetail']['product_name'];?></td>
					<td align="center"><?php echo $records['StockMaintenanceDetail']['stock_qty'];?></td>
					<td align="center"><?php echo $records['Product']['maximum'];?></td>
					<td align="center"><?php echo $records['StockMaintenanceDetail']['product_batch'];?></td>
					<td align="center"><?php echo $records['StockMaintenanceDetail']['product_expiry'];?></td>
					<td align="center"><?php echo $records['StockMaintenanceDetail']['reorder_level'];?></td>
					<td align="center"><?php echo $records['PurchaseOrderItem']['purchase_price'];?></td>
					<td align="center"><?php echo $records['StockMaintenanceDetail']['mrp'];?></td>
					<td align="center"><?php echo $records['PurchaseOrderItem']['amount'];?></td>
					<td align="center"><?php echo '0.00';?></td>
				</tr>
				<?php }?>
			</table> 
	<?php echo $this->Form->end();?>
<?php if($this->request->data){ ?>	
<table align="center">
		<tr>
			<?php $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
			?>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			
			</TD>
		</tr>
</table>
<?php }?>
<script>


$("#item_name").focus(function(){
	$("#item_name").val('');
	$("#item_id").val('');
	$(this).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","name", "admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 
		 select: function( event, ui ) {
			 $('#item_id').val(ui.item.id); 
			
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
 });

$("#ExcelGenerate").click(function(){
	 window.location.href = "<?php echo $this->Html->url(array('controller'=>'Reports','action'=>'current_stock_xls'))?>"
	 });
		 			
</script>
		