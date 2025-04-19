
<?php if(!empty($products)) { ?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<thead>
		<tr>
			<th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th>
			<th width="150" align="center" valign="top" style="text-align: center;">Product Name</th>
			<th width="120" align="center" valign="top" style="text-align: center;">Manufacturer</th>
			<th width="60" valign="top" style="text-align: center;">Pack</th>
			<th width="80" align="center" valign="top" style="text-align: center;">Batch No.</th>
			<th width="60" valign="top" style="text-align: center;">MRP</th>
			<th width="60" valign="top" style="text-align: center;">Purchase Price</th>
		</tr>
	</thead>
	
	<tbody>
		<?php $count = 0; foreach($products as $key=>$product) { ?>
		<tr>
			<td valign="middle" style="text-align: center;">
				<?php echo ++$count; ?>
			</td>
			
			<td valign="middle">
				<?php echo $product['Product']['name'];?>
				<?php echo $this->Form->hidden('product_id',array('id'=>'productId_'.$key,'class'=>'productId','value'=>$product['Product']['id']));?>
			</td>
			
			<td valign="middle">
				<?php echo $product['ManufacturerCompany']['name'];?>
			</td>
			
			<td valign="middle">
				<?php echo $product['Product']['pack'];?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php echo $product['Product']['batch_number'];?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php echo $product['Product']['mrp'];?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php echo $this->Form->input('purchase_price',array('type'=>'text','name'=>"data['PurchaseOrder'][$key]['purchase_price']",'value'=>$product['Product']['purchase_price'],'div'=>false,'label'=>false,'style'=>'width:100%','class'=>'textBoxExpnd price','id'=>'price_'.$key)); ?>
			</td>
		</tr>
		<?php } //end of foreach loop ?>
	</tbody>
</table>

<div class="clr ht5"></div>
<div class="btns">
	<?php
		//echo $this->Html->link(__('Back'),array('controller'=>'Contracts','action'=>'add_contract'), array('escape' => false,'class'=>'blueBtn'));
	?>
</div>

<?php }
	 else { 
		 echo "There is no any product for this contract"; 
 	  }
 ?>
 
 
<script>

$(function(){
	$(".price").blur(function(){
		var contract_id = "<?php echo $this->params['pass'][0]; ?>";
		var idd = $(this).attr('id');
		var new_id = idd.split('_');
		var product_id = $("#productId_"+new_id[1]).val();
		var price = $(this).val();
		if(price != '')
		{
			$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'Contracts', "action" => "addProductPrice", "admin" => false)); ?>"+"/"+contract_id+"/"+product_id+"/"+price,
			  context: document.body,
			  beforeSend:function(data){
				$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
				}
			});
		}	
		//alert(price);
		//alert(product_id);
		
	});
});
</script>