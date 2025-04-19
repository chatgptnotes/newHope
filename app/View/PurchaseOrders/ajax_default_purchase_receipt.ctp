<!--<table width="" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="200" class="tdLabel2">Search by Supplier:<font color="red">*</font></td>
		<td width="300" class="tdLabel2">
			<?php echo $this->Form->input('vendor',array('type'=>'text','class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'id'=>'supplier_name','autocomplete'=>'off'));
					echo $this->Form->hidden('supplier_id',array('id'=>'supplier_id'));
			?> 
		</td>
		
		<td width="200" class="tdLabel2">Purchase Order Number:</td>
		<td width="350" class="tdLabel2">
			<?php echo $this->Form->input('',array('type'=>'select','options'=>array(),'class'=>'textBoxExpnd','id'=>'purchase_order_number','div'=>false,'label'=>false));?>
		</td>
	</tr>
</table>-->

<div class="clr ht5"></div>

<div class="clr ht5"></div>
	<div style="float: right">
		 <?php $grandTotal= "Grand Total :"; 
		 echo '<strong><font color="red"> ' .$grandTotal. '</font></strong>'; ?>
		 <?php
		 $total=$this->Number->currency($totalAmt[0][0]['sum']+$totalVat[0][0]['sumVat']);
		 echo '<b> <font color="red">' .$total. '</font></b>'; ?>
		
   </div>
<?php if(!empty($PurchaseOrder)) { ?>

<table width="100%">
	<tr>
		<td colspan="4" align="center">
			<?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#container',    												
					'complete' => "onCompleteRequest('myclass','class');",
	    		 	'before' => "loading('myclass','class');"), null, array('class' => 'paginator_links'));  ?>
	    	<span class="paginator_links">
	    		<?php  echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span>
			<?php  echo $this->Paginator->next(__('Next »', true), array('update'=>'#container',    												
					'complete' => "onCompleteRequest('myclass','class');",
	    		 	'before' => "loading('myclass','class');"), null, array('class' => 'paginator_links'));  
			
				 echo $this->Js->writeBuffer();
			?>
		</td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm myclass" id="item-row">
	<thead>	
		<tr class="row_title">
			<td width="1%" align="center" valign="top" style="text-align: center;" class="table_cell" >#</td>
			<td width="10%" align="center" valign="top" style="text-align:center;" class="table_cell">GRN No.</td>
			<td width="10%" align="center" valign="top" style="text-align: center;" class="table_cell">Grn For</td>
			<td width="10%" align="center" valign="top" style="text-align: center;" class="table_cell">Party Invoice No</td>
			<td width="27%" align="center" valign="top" style="text-align: center;" class="table_cell">Supplier</td>
			<td width="15%" align="center" valign="top" style="text-align: center;" class="table_cell">Amount</td> 
			<td width="15%" valign="top" style="text-align: center;" class="table_cell">Received Date</td>
			<td width="15%" valign="middle" style="text-align: center;" class="table_cell">Action</td>			
		</tr>
	</thead>
	
	<tbody>
	<?php $count = $this->params->paging['PurchaseOrder']['limit']*($this->params->paging['PurchaseOrder']['page']-1); ?>
		<?php /*$count = 0;*/  foreach($PurchaseOrder as $purchase) { 
			$count++; ?>
		<tr class=" <?php if($count%2==0) echo "row_gray"; ?>">
		
			<td class="text_center row_format">
				<?php echo $count; ?>
			</td>
			
			<td class="text_center row_format" align="center">
				<?php echo $purchase['PurchaseOrderItem']['grn_no']; ?>
			</td>
			
			<td class="text_center row_format" align="center">
				<?php echo ($purchase['StoreLocation']['name']); ?>
			</td>
			
			<td class="row_format" align="center">
					<?php echo $purchase['PurchaseOrderItem']['party_invoice_number']; ?>
			</td>
				
			<td class="row_format" align="center">
				<?php echo $purchase['InventorySupplier']['name']; ?>
			</td>
			
			<!-- <td class="row_format" align="center">
				<?php 
				$toataAmount = $purchase['PurchaseOrder']['total'] - $purchase['PurchaseOrder']['discount']+$purchase['PurchaseOrder']['vat'];
				if($purchaseReturn[$purchase['PurchaseOrder']['id']] != 0 || $purchaseReturn[$purchase['PurchaseOrder']['id']]!= ''){

					echo number_format($toataAmount - $purchaseReturn[$purchase['PurchaseOrder']['id']],2);
				}else{
					echo number_format($toataAmount,2);
				}
				?>
			</td> commneted by pankaj to fix issues generated using single PO with multiple GRN-->
			<td class="row_format" align="center">
			<?php  
				if($purchaseReturn[$purchase['PurchaseOrder']['id']]){
				  	$total = $purchase[0]['sum']+$purchase['PurchaseOrder']['vat']-$purchaseReturn[$purchase['PurchaseOrder']['id']];
				}else{
					$total = $purchase[0]['sum']+$purchase['PurchaseOrder']['vat'];
				}
			?>
			<?php echo number_format($total,2); 
				$amountTotal +=  (float) $purchase[0]['sum'];?>
			</td>
			
			<td class="text_center row_format" align="center">
				<?php echo $this->DateFormat->formatDate2Local($purchase['PurchaseOrderItem']['received_date'],Configure::read('date_format'),true); ?>
			</td>
			
			<td class="row_action" ><?php
			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit GRN', true),'title' => __('Edit GRN', true),'class'=>'editGrn','id'=>'edit_'.$purchase['PurchaseOrder']['id'],'poiId'=>$purchase['PurchaseOrderItem']['id'])),'javascript:void(0)', array('escape' => false));
                        echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Item', true),'title' => __('View Item', true),'class'=>'view','id'=>'view_'.$purchase['PurchaseOrder']['id'],'poiId'=>$purchase['PurchaseOrderItem']['id'])),'javascript:void(0)', array('escape' => false));
			?> 
			<?php
			echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Items', true),'title' => __('Print Items', true))),'javascript:void(0);', array('escape' => false,'class'=>' printButton','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'PurchaseOrders','action'=>'printPurchaseReceived',
			$purchase['PurchaseOrder']['id'],$purchase['PurchaseOrderItem']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));
			?> 
			<?php 
			echo $this->Html->link($this->Html->image('icons/returnProduct.png', array('alt' => __('Return Item', true),'title' => __('Return Item', true),
			'class'=>'return','id'=>'return_'.$purchase['PurchaseOrder']['id'],'poiReturnId'=>$purchase['PurchaseOrderItem']['id'],'returnValue'=>'return')),'javascript:void(0)', array('escape' => false));
			?>
			<?php
			echo $this->Html->link($this->Html->image('icons/issue_product.png', array('alt' => __('Return Item', true),'title' => __('Return Item', true),
				'class'=>'returnView','id'=>'returnView_'.$purchase['PurchaseOrder']['id'],'poiId'=>$purchase['PurchaseOrderItem']['id'],'viewReturn' =>'viewReturnItem')),
				'javascript:void(0)', array('escape' => false));
			?>
			</td>
		</tr>
		<?php  } ?>
	</tbody>
</table>
<table width="100%">
	<tr>
		<td colspan="4" align="center">
			<?php 
			
			$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
		    
			echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#container',    												
					'complete' => "onCompleteRequest('myclass','class');",
	    		 	'before' => "loading('myclass','class');"), null, array('class' => 'paginator_links'));  ?>
	    	<span class="paginator_links">
	    		<?php  echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span>
			<?php  echo $this->Paginator->next(__('Next »', true), array('update'=>'#container',    												
					'complete' => "onCompleteRequest('myclass','class');",
	    		 	'before' => "loading('myclass','class');"), null, array('class' => 'paginator_links'));  
			
				 echo $this->Js->writeBuffer();
			?>
		</td>
	</tr>
</table>
	
<?php } else { echo "<table width='100%'><tr><td align='center'><strong>No Record Found..!!</strong></td></tr></table>"; }?>



<script>

$(document).ready(function(){

	/* For View Purchase Item */
	$(".view").click(function(){
		newId = (this.id).split('_');
		var poId = $(this).attr('poiId'); 
		getItems(newId[1],poId);
	});

	/* For Purchase Return*/
	$(".return").click(function(){
		newId = (this.id).split('_');
		var poiReturnId = $(this).attr('poiReturnId');
		var returnItem = $(this).attr('returnValue');
		getItems(newId[1],poiReturnId,returnItem);
	});

	/* For Return View */
	$(".returnView").click(function(){
		newId = (this.id).split('_');
		var poiReturnId = $(this).attr('poiReturnId');
		var returnItem = $(this).attr('viewReturn');
		getItems(newId[1],poiReturnId,returnItem);
	});
		
	
	$("#purchase_order_number").change(function(){
		getItems($(this).val());
	});

	function getItems(poID,itemId,returnItem)		
	{
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'PurchaseOrders', "action" => "getItems", "admin" => false));?>";
		$.ajax({
		url : ajaxUrl + '/' + poID +'/'+ itemId+'/'+returnItem,
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
			$("#container").html(data).fadeIn('slow');
			
		}
		});
	}

	$(".edit").click(function()
	{
		newId = (this.id).split('_');
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'PurchaseOrders', "action" => "getItemDetails", "admin" => false));?>";
		$.ajax({
		url : ajaxUrl + '/' + newId[1],
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
			$("#container").html(data).fadeIn('slow');
		}
		});
	});
        
        $(".editGrn").click(function(){
		newId = (this.id).split('_');
		var poId = $(this).attr('poiId'); 
		editItems(newId[1],poId);
	});
        
        function editItems(poID,itemId)		
	{
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'PurchaseOrders', "action" => "editGrn", "admin" => false));?>";
		$.ajax({
		url : ajaxUrl + '/' + poID +'/'+ itemId,
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
			$("#container").html(data).fadeIn('slow');
		}
		});
	}
});

</script>