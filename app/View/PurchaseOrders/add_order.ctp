<?php 
	//echo $this->Html->script('jquery.fancybox-1.3.4');
	//echo $this->Html->css('jquery.fancybox-1.3.4.css');
 echo $this->Html->script(array('jquery.fancybox.js' ));
	echo $this->Html->css(array('jquery.fancybox' ));
?>

<div class="inner_title">
 <?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
	<h3>
		<?php echo __('Add Purchase Order', true); ?>
	</h3>
	<span>
		<?php
			echo $this->Html->link(__('Back'),array('controller'=>'Pharmacy','action'=>'department_store'), array('escape' => false,'class'=>'blueBtn'));
			echo "&nbsp;";
			echo $this->Html->link(__('Add Product'),'javascript:void(0)',array('escape'=>false,'class'=>'blueBtn','id'=>'addProduct'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>

<div class="clr ht5"></div>
<?php echo $this->Form->create('purchase_order',array('id'=>'Purchase-order','onkeypress'=>"return event.keyCode != 13;"));?>
<table width="" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="70" class="tdLabel2">PO ID: </td>
		<td width="180" class="tdLabel2">
			<?php echo $this->Form->input('purchase_order_number',array('type'=>'text','div'=>false,'label'=>false,'readonly'=>'readonly','class'=>'textBoxExpnd','value'=>$purchase_order_number));?>
		<td width="20">&nbsp;</td>
		<td width="120" class="tdLabel2">Order Date: <font color="red">*</font></td>
		<td width="350" class="tdLabel2">
		<?php $date = date("d/m/Y H:i:s"); ?>
		<?php if($websiteConfig['instance'] == 'vadodara'){ 
			echo $this->Form->input('order_date',array('type'=>'text','class'=>'textBoxExpnd validate[required] order_date_no_back','autocomplete'=>'off','id'=>'order_date_no_back','div'=>false,'label'=>false,'value'=>$date));
		}else{
			echo $this->Form->input('order_date',array('type'=>'text','class'=>'textBoxExpnd validate[required] order_date','autocomplete'=>'off','id'=>'orderDate','div'=>false,'label'=>false,'value'=>$date));
		}
		?> 
		</td>
		
		
		<td width="20">&nbsp;</td>
		<td width="120" class="tdLabel2">Order For: <font color="red">*</font></td>
		<td width="350" class="tdLabel2">
			<?php echo $this->Form->input('order_for',array('type'=>'select','options'=>$storeLocation,'class'=>'textBoxExpnd validate[required]','autocomplete'=>'off','div'=>false,'label'=>false,'id'=>'orderFor'));
			?> 
		</td>
		
		
		<td width="20">&nbsp;</td>
		<td width="80" class="tdLabel2">Supplier: <font color="red">*</font></td>
		<td width="350" class="tdLabel2">
			<?php echo $this->Form->input('vendor',array('type'=>'text','class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'id'=>'supplier_name','autocomplete'=>'off'));
					echo $this->Form->hidden('supplier_id',array('id'=>'supplier_id'));
			?> 
		</td>
		
		<?php if(strtolower($this->Session->read('website.instance')) == "vadodara"){ ?>
		<!--<td width="20">&nbsp;</td>
		<td width="80" class="tdLabel2">Contract: </td>
		<td width="350" class="tdLabel2">
			<?php echo $this->Form->input('contract_id',array('type'=>'select','empty'=>'Select','class'=>'textBoxExpnd','div'=>false,'label'=>false,'id'=>'contract_name'));
				  echo $this->Form->hidden('contract_id',array('id'=>'contract_id'));
			?> 
		</td>-->
		<?php } ?>
		<!--
		<td width="50" class="tdLabel2">Type: </td>
		<td width="350" class="tdLabel2">
			<?php $type = array('Single Release'=>'Single Release','Bill-Only'=>'Bill-Only','Blanket'=>'Blanket','Capital'=>'Capital','Consignment'=>'Consignment','Pre-Paid'=>'Pre-Paid','Return'=>'Return','Standing'=>'Standing'); ?>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$type,'class'=>'textBoxExpnd','name'=>"data[purchase_order][type]",'div'=>false,'label'=>false));?>
		</td>
		<td width="50" class="tdLabel2">Status: </td>
		<td width="350" class="tdLabel2">
			<?php $status = array('Pending'=>'Pending','Open'=>'Open','Closed'=>'Closed');?>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$status,'class'=>'textBoxExpnd','name'=>"data[purchase_order][status]",'div'=>false,'label'=>false));?>
		</td>
		 -->
	</tr>
</table>

<div class="clr ht5"></div>

<?php echo $this->Form->hidden('',array('name'=>"data[purchase_order][status]",'value'=>'Pending')); ?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row" style="display: none;">
	
	<tr>
		<!-- <th width="15" align="center" valign="top" style="text-align: center;">#</th> -->
		<th width="150" align="center" valign="top" style="text-align: center;">Product Name <font color="red">*</font></th>
		<th width="120" align="center" valign="top" style="text-align: center;">Manufacturer</th>
		<th width="60" valign="top" style="text-align: center;">Pack</th>
		<th width="80" align="center" valign="top" style="text-align: center;">Batch No.</th>
		<th width="60" valign="top" style="text-align: center;">MRP</th>
		<th width="60" valign="top" style="text-align: center;">Sale Price</th>
		<th width="60" valign="top" style="text-align: center;">Purchase Price</th>
		<?php if($websiteConfig['instance'] == 'kanpur'){ ?> 
		<th width="60" valign="top" style="text-align: center;">Vat of Class</th>
		<?php } else if($websiteConfig['instance'] == 'hope') { ?>
		<th width="60" valign="top" style="text-align: center;">Tax</th>
		<?php }?>
		<th width="60" valign="top" style="text-align: center;">Total Stock</th>
		<th width="60" valign="top" style="text-align: center;">Order Qty<font color="red">*</font>(MSU)</th>
		<?php if($websiteConfig['instance'] != 'vadodara'){ ?> 
		<th width="60" valign="top" style="text-align: center;">Vat Amt</th>
		<?php } ?>
		<th width="80" valign="top" style="text-align: center;">Amount</th>
		<th width="50" valign="top" style="text-align: center;">Action</th>
	</tr>
	
	<?php //debug($products);?>
	<?php if(!empty($products)) { $count = 0;?>
	<?php foreach($products as $key => $product) { $count++;?>
	<tr id="row<?php echo $count;?>">
		<!-- <td align="center" valign="middle" class="sr_number"><?php echo $count;?></td> -->
		<td valign="middle">
		<?php 
			echo $this->Form->input('',array('type'=>'text','name'=>"data[purchase_order_item][$key][product_name]",'value'=>$product['Product']['name'],'readonly'=>true,'fieldNo'=>"$key",'autocomplete'=>'off','id'=>'item-name_'.$key,'class'=>'textBoxExpnd validate[required] product_name','style'=>"width:100%",'div'=>false,'label'=>false ));
			echo $this->Form->hidden('',array('id'=>'productid_'.$key,'class'=>'product_id','name'=>"data[purchase_order_item][$key][product_id]",'value'=>$product['Product']['id']));
		?>
		</td>
		
		<td align="center" valign="middle">
			<?php
				 echo $this->Form->input('manufacturer',array('type'=>'text','name'=>"data[purchase_order_item][$key][manufacturer]",'value'=>$product['Product']['manufacturer'],'readonly'=>true,'fieldNo'=>$key,'autocomplete'=>'off','id'=>'manufacturer_'.$key,'class'=>'textBoxExpnd manufacturer','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<td align="center" valign="middle">
			<?php
				 echo $this->Form->input('pack',array('type'=>'text','name'=>"data[purchase_order_item][$key][pack]",'value'=>$product['Product']['pack'],'readonly'=>true,'fieldNo'=>'$key','autocomplete'=>'off','id'=>'pack_'.$key,'class'=>'textBoxExpnd pack','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('batch_number',array('type'=>'text','name'=>"data[purchase_order_item][$key][batch_number]",'value'=>$product['Product']['batch_number'],'readonly'=>true,'fieldNo'=>$key,'autocomplete'=>'off','id'=>'batch-number_'.$key,'class'=>'textBoxExpnd batch_number','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('selling_price',array('type'=>'text','name'=>"data[purchase_order_item][$key][selling_price]",'value'=>$product['Product']['selling_price'],'readonly'=>false,'fieldNo'=>$key,'autocomplete'=>'off','id'=>'sellingPrice_'.$key,'class'=>'textBoxExpnd sellingPrice onlyNumber','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('purchase_price',array('type'=>'text','name'=>"data[purchase_order_item][$key][purchase_price]",'value'=>$product['Product']['mrp'],'readonly'=>false,'fieldNo'=>$key,'autocomplete'=>'off','id'=>'mrp_'.$key,'class'=>'textBoxExpnd mrp numberOnly','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>

		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('hav_quantity',array('type'=>'text','name'=>"data[purchase_order_item][$key][hav_quantity]",'fieldNo'=>$key,'autocomplete'=>'off','id'=>'havquantity_'.$key,'class'=>'textBoxExpnd havquantity','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>'readonly'));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('quantity_order',array('type'=>'text','name'=>"data[purchase_order_item][$key][quantity_order]",'fieldNo'=>$key,'autocomplete'=>'off','id'=>'quantity_'.$key,'class'=>'textBoxExpnd quantity validate[required]','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('amount',array('type'=>'text','name'=>"data[purchase_order_item][$key][amount]",'disabled'=>'disabled','fieldNo'=>$key,'autocomplete'=>'off','id'=>'amount_'.$key,'class'=>'textBoxExpnd amount','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		<td align="center" valign="middle" style="text-align: center;">
			<a href="javascript:void(0);" id="delete-row" onclick="deletRow('<?php echo $count;?>');"><?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?> 
			</a>
		</td>
		
	</tr>
	<?php } //end of foreach?>
	<?php echo $this->Form->hidden('no',array('id'=>'no_of_fields','value'=>$count));?>
	
	<?php } else { ?>
	
	<?php echo $this->Form->hidden('no',array('id'=>'no_of_fields','value'=>'1'));?>
	<tr id="row1">
		<!-- <td align="center" valign="middle" class="sr_number">1</td> -->
		
		<td valign="middle">
			<?php
				 echo $this->Form->input('',array('type'=>'text','name'=>'data[purchase_order_item][1][product_name]','fieldNo'=>'1','autocomplete'=>'off','id'=>'item-name_1','class'=>'textBoxExpnd validate[required] product_name','style'=>"width:100%",'div'=>false,'label'=>false ));
				 echo $this->Form->hidden('',array('id'=>'productid_1','class'=>'product_id','name'=>"data[purchase_order_item][1][product_id]"));
				 echo $this->Form->hidden('',array('id'=>'ItisContract_1','class'=>'ItisContract','value'=>0,'name'=>"data[purchase_order_item][1][is_contract]"));
			?>
		</td>
		
		<td align="center" valign="middle">
		<span class="manufact" id="manu_1"> </span>
			<?php
				 echo $this->Form->hidden('manufacturer',array('type'=>'text','name'=>'data[purchase_order_item][1][manufacturer]','fieldNo'=>'1','autocomplete'=>'off','id'=>'manufacturer_1','class'=>'textBoxExpnd manufacturer','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>true));
			?>
		</td>
		
		<td align="center" valign="middle">
		<span class="packk" id="pac_1"> </span>
			<?php
				 echo $this->Form->hidden('pack',array('type'=>'text','name'=>'data[purchase_order_item][1][pack]','fieldNo'=>'1','autocomplete'=>'off','id'=>'pack_1','class'=>'textBoxExpnd pack','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>true));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
		<span class="batchnumber" id="batch_1"> </span>
			<?php
				 echo $this->Form->hidden('batch_number',array('type'=>'text','name'=>'data[purchase_order_item][1][batch_number]','fieldNo'=>'1','autocomplete'=>'off','id'=>'batch-number_1','class'=>'textBoxExpnd batch_number','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>true));
				 echo $this->Form->hidden('expiry_date',array('name'=>'data[purchase_order_item][1][expiry_date]','fieldNo'=>'1','id'=>'expiryDate_1'));
			?>
		</td>
		
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('mrp',array('type'=>'text','name'=>"data[purchase_order_item][1][mrp]",'fieldNo'=>'1','autocomplete'=>'off','id'=>'mrp_1','class'=>'textBoxExpnd mrp numberOnly','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>false));
				 //echo $this->Form->hidden('selling_price',array('name'=>"data[purchase_order_item][1][selling_price]",'fieldNo'=>'1','id'=>'sellingPrice_1'));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('selling_price',array('type'=>'text','name'=>'data[purchase_order_item][1][selling_price]','fieldNo'=>'1','autocomplete'=>'off','id'=>'sellingPrice_1','class'=>'textBoxExpnd numberOnly sellingPrice','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('purchase_price',array('type'=>'text','name'=>'data[purchase_order_item][1][purchase_price]','fieldNo'=>'1','autocomplete'=>'off','id'=>'purchasePrice_1','class'=>'textBoxExpnd purchasePrice numberOnly','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>false));
			?>
		</td>
		
		<?php if($websiteConfig['instance'] == 'kanpur'){  ?>
		<td valign="middle" style="text-align: center;">
			<?php 
				echo $this->Form->input('vat_class_id',array('type'=>'select','empty'=>'Select Vat','name'=>'data[purchase_order_item][1][vat_class_id]','fieldNo'=>'1','options'=>$vatAll,'autocomplete'=>'off','id'=>'vatDisplay_1','class'=>'textBoxExpnd vatDisplay','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>false));
				echo $this->Form->hidden('tax',array('name'=>'data[purchase_order_item][1][tax]','fieldNo'=>'1','id'=>'tax_1','class'=>'tax'));
			 ?>
		</td>
		<?php }  else if($websiteConfig['instance'] == 'hope') {?>
		<td valign="middle" style="text-align: center;">  
			<?php
				 echo $this->Form->input('tax',array('type'=>'text','name'=>'data[purchase_order_item][1][tax]','fieldNo'=>'1','autocomplete'=>'off','id'=>'tax_1','class'=>'textBoxExpnd tax','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>false));
			?>
		</td>
		<?php } ?>
		<td valign="middle" style="text-align: center;" class="havquantity" id="havquantity_1">
			<?php
				// echo $this->Form->input('hav_quantity',array('type'=>'text','name'=>"data[purchase_order_item][1][hav_quantity]",'fieldNo'=>'1','autocomplete'=>'off','id'=>'havquantity_1','class'=>'textBoxExpnd havquantity','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>'readonly'));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('quantity_order',array('type'=>'text','name'=>'data[purchase_order_item][1][quantity_order]','fieldNo'=>'1','autocomplete'=>'off','id'=>'quantity_1','class'=>'textBoxExpnd quantity validate[required]','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<?php if($websiteConfig['instance'] != 'vadodara'){ ?> 
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('vat',array('type'=>'text','name'=>'data[purchase_order_item][1][vat]','fieldNo'=>'1','autocomplete'=>'off','id'=>'vat_1','class'=>'textBoxExpnd vat validate[required]','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		<?php } ?>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('amount',array('type'=>'text','name'=>'data[purchase_order_item][1][amount]','fieldNo'=>'1','autocomplete'=>'off','id'=>'amount_1','readonly'=>'readonly','class'=>'textBoxExpnd amount','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<td>
			<table>
				<tr>
					<td id="isContract_1" style="display:none;">
						<?php echo $this->Html->image('tick.png', array('alt' => 'contract','title'=>'Contract'));?>
					</td>
					
					<td align="right" valign="middle" style="text-align: center;">
						<?php //echo $this->Html->link($this->Html->image('/img/icons/cross.png',array('alt'=>'Delete','title'=>'Delete Row')),array('#'))?>
						<a href="javascript:void(0);" id="delete-row" onclick="deletRow('1');">
						<?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?>
						</a>
					</td>			
				</tr>
			</table>
		</td>
		
	</tr>
	
	<?php } ?>
	<?php if(strtolower($this->Session->read('website.instance'))=="vadodara"){
			$colspan=9; 
		} else{
			$colspan=11; 
		} ?>
	<tr id="ampoutRow">
		<td colspan="<?php echo $colspan; ?>" valign="middle" align="right">
			<table>
				<tr>
					<td>
						<?php echo __('Total Amount');?>
							<?php echo $this->Form->hidden('total_amount',array('id'=>'total_amount','value'=>'')); ?>
							<?php echo $this->Form->hidden('net_amount',array('id'=>'net_amount','value'=>'')); ?>
							<?php echo $this->Form->hidden('total_vat',array('id'=>'total_vat','value'=>'')); ?>
					</td>
				</tr>
				<?php if(strtolower($this->Session->read('website.instance')) != "vadodara") { ?>
				<tr>
					<td>
						<?php echo __('Total Tax');?>
					</td>
				</tr>
				
				<tr>
					<td>
						<?php echo __('Net Amount');?>
					</td>					
				</tr>
				<tr>
					<td>
						<?php echo __('Round Off');?>
					</td>					
				</tr>
				<?php } ?>
			</table>
		</td>
		
		<td align="right">
			<table style="text-align: right;" align="right">
				<tr>
					<td valign="middle" style="text-align: right;" class="total" id="total">
					0
					</td>
				</tr>
				<?php if(strtolower($this->Session->read('website.instance')) != "vadodara") { ?>
				<tr>
					<td valign="middle" style="text-align: right;" class="Tvat" id="Tvat">
					0
					</td>
				</tr>
				
				<tr>
					<td valign="middle" style="text-align: right;" class="Tnet" id="Tnet">
					0
					</td>
				</tr>
				<tr>
					<td valign="middle" style="text-align: right;" class="roundOff" id="roundOff">
					0
					</td>
				</tr>
				<?php } ?>
			</table>	
		</td>
		<td>&nbsp;</td>
	</tr>
</table>
<div class="clr ht5"></div>

<div align="left">
	<input name="" type="button" value="Add More" class="blueBtn Add_more" tabindex="36" onclick="addFields()" />
	<!-- <input name="" type="button" value="Remove" id="remove-btn" class="blueBtn" tabindex="36" onclick="removeRow()" style="display: none" /> -->
</div>

<div class="clr ht5"></div>
<div class="btns">
		<span id="note" style="display:none">
			<i>(
				<font color="red">Note: </font>
					<span id="min-max-po"> </span>
				)
			</i>
		</span>&nbsp;
		
		<input name="receive" type="submit" value="Submit & Receive" class="blueBtn submitt" id="submitButtonToGrn"  />
		
		<input name="submit" type="submit" value="Submit" class="blueBtn submitt" id="submitButton" />
		
	<?php echo $this->Form->end();?>
</div>

<div class="inner_title">
	<div class="clr ht5"></div>
</div>

<?php //debug($dataValue); ?>

<script>
var sum = 0;
var vat = 0;
var net = 0;
var minPOAmt = 0 ;
var maxPOAmt = 0 ; 
var instance = "<?php echo $websiteConfig['instance'];?>";
var opt = '';
var optValue = '';


$(document).ready(function(){

	optValue = $.parseJSON('<?php echo ($dataValue); ?>');
	opt = $.parseJSON('<?php echo ($vatAllData); ?>');

	/*console.log(optValue);
	console.log(opt);*/
	
	var ProDuctID = $("#productid_1").val();
	if(ProDuctID == "")
	{
		$("#item-row").hide();
		$(".Add_more").hide();
		$("#submitButton").hide();
		$("#submitButtonToGrn").hide();
	}
	else
	{
		$("#item-row").show();
	}

	
	$('#supplier_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null','no','null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 var supplier_id = ui.item.id;
			 $('#supplier_id').val(ui.item.id);

			if(instance == "vadodara"){
				//for Contract by swapnil updated on 25.03.2015
				$.ajax	({
				  url: "<?php echo $this->Html->url(array("controller" => 'Contracts', "action" => "findContracts", "admin" => false)); ?>"+"/"+supplier_id,
				  context: document.body,				  		  
				  beforeSend:function(data){
					$('#busy-indicator').show();
					},
				success: function(data)
				  {
				  	data= $.parseJSON(data);
				  	$("#contract_name option").remove();
				  	$("#contract_name").append( "<option value=''>Select</option>" );
					$.each(data, function(val, text) {
					    $("#contract_name").append( "<option value='"+val+"'>"+text+"</option>" );
					});		 
					$('#busy-indicator').hide();		    		
				  }
				});	
			}
			
			if(supplier_id != "")
			 {
				$("#item-row").show();
				$(".Add_more").show();
				$("#submitButton").show();
				$("#submitButtonToGrn").show();
				$("#item-name_1").focus();
				//document.getElementById('contract_name').disabled = false;
			 }
			 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});

});



$(".product_name").change(function(){
	var contract = ($('#contract_name').val()) ? $('#contract_name').val() : 'null' ;
	var supplier_id = ($('#supplier_id').val()) ? $('#supplier_id').val() : 'null' ;
	var orderFor = ($('#orderFor').val()) ? $('#orderFor').val() : null ;

	$('.product_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "autocompleteForPO","admin" => false,"plugin"=>false)); ?>"+"/"+supplier_id+"/"+contract+"/"+orderFor,
		 minLength: 1,
		 select: function( event, ui ) {
			 
			var idd = $(this).attr('id');
	        splitted = idd.split("_");
	        
	        $('#productid_'+splitted[1]).val(ui.item.id);
	        $('#manufacturer_'+splitted[1]).val(ui.item.manufacturer);
	        $('#pack_'+splitted[1]).val(ui.item.pack);
	        $('#havquantity_'+splitted[1]).text(ui.item.quantity);
	        $('#batch-number_'+splitted[1]).val(ui.item.batch_number);
	        $('#mrp_'+splitted[1]).val(ui.item.mrp);
	        $('#purchasePrice_'+splitted[1]).val(ui.item.purchase_price);
	        $('#expiryDate_'+splitted[1]).val(ui.item.expiry_date);

	        if(instance == "kanpur"){
		        $('#vatDisplay_'+splitted[1]).val(ui.item.vat_class_id);
	            $.each(optValue, function (key, value) {
	        		if(key == ui.item.vat_class_id){
	        			$("#tax_"+splitted[1]).val(value);
	        		}
	        	});
		    }else  if(instance == "hope"){
		    	 $('#tax_'+splitted[1]).val(ui.item.tax);
		    }
		    
	        var is_contract = ui.item.is_contract;
	        if(is_contract == '1')
	        {
	        	$('#isContract_'+splitted[1]).show();
	        	$('#ItisContract_'+splitted[1]).val(1);
	        }
	        else
	        {
	        	$('#isContract_'+splitted[1]).hide();
	        	$('#ItisContract_'+splitted[1]).val(0);
	        }
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }		
		});
});

//any key press up/down
$(document).on('keypress','.tax, .mrp, .vat, .batch_number, .quantity, .pack, .purchasePrice, .manufacturer, .amount, .havquantity',function(e) {
	id = $(this).attr('id');
	var count = id.split("_");
    var fieldNominus = parseInt(count[1])-1;
    var fieldNoplus = parseInt(count[1])+1;
    if (e.keyCode==40) {	//down Key
        $("#"+count[0]+"_"+fieldNoplus).focus();
    }
    if (e.keyCode==38) {	//up key
        $("#"+count[0]+"_"+fieldNominus).focus();
    } 
    if(e.keyCode==13){		//enter key
	    if($("#productid_"+count[1]).val()!=0 || $("#productid_"+count[1]).val()!=''){
    		$('.Add_more').trigger('click');	//trigger click for
	    }
    } 
});


$(document).on('input','.product_name',function() {
    $(this).val($(this).val().toUpperCase());
});


$(document).on('focus',".product_name",function(){
	//document.getElementById('contract_name').disabled = true;  //to disable the contract select
	var contract = ($('#contract_name').val()) ? $('#contract_name').val() : null ;
	var supplier_id = ($('#supplier_id').val()) ? $('#supplier_id').val() : null ;
	var orderFor = ($('#orderFor').val()) ? $('#orderFor').val() : null ;
	
	$('.product_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "autocompleteForPO","admin" => false,"plugin"=>false)); ?>"+"/"+supplier_id+"/"+contract+"/"+orderFor,
		 minLength: 1,
		 select: function( event, ui ) {
			var idd = $(this).attr('id');
            splitted = idd.split("_");
			
			var curField = splitted[1]; 
			var productId = parseInt(ui.item.id);
			var exist = false;
			var thisFeild = '';
			/********* DONT REMOVE COMMENTED CODE- MRUNAL code restrict to add same item multiple time in purchase order *************/
            /*$(".product_id").each(function(){
    			if(this.value == productId){
    				var id = $(this).attr('id');
        			thisField = id.split("_");
    				exist = true;
    				return false;
    			}
    		});	*/
			
            //if(exist == true && curField == thisField){
            	/*alert('This product is already selected');
				$("#item-name_"+splitted[1]).val('');
				$("#item-name_"+splitted[1]).focus();
   				return false;*/
			//}
            //if(exist == false){ 
            /************** END OF COMMENTs ******************/
	            $('#productid_'+splitted[1]).val(ui.item.id);
	            $('#manufacturer_'+splitted[1]).val(ui.item.manufacturer);
	            $('#pack_'+splitted[1]).val(ui.item.pack);
	            $('#manu_'+splitted[1]).html(ui.item.manufacturer);
	            $('#pac_'+splitted[1]).html(ui.item.pack);
	            $('#batch_'+splitted[1]).html(ui.item.batch_number);
	            $('#havquantity_'+splitted[1]).text(ui.item.quantity);
	            $('#batch-number_'+splitted[1]).val(ui.item.batch_number);
	            $('#mrp_'+splitted[1]).val(ui.item.mrp);
	            $('#sellingPrice_'+splitted[1]).val(ui.item.selling_price);
	            $('#purchasePrice_'+splitted[1]).val(ui.item.purchase_price);
	            $('#expiryDate_'+splitted[1]).val(ui.item.expiry_date);
	            
	            if(instance == "kanpur"){
			        $('#vatDisplay_'+splitted[1]).val(ui.item.vat_class_id);
		            $.each(optValue, function (key, value) {
		        		if(key == ui.item.vat_class_id){
		        			$("#tax_"+splitted[1]).val(value);
		        		}
		        	});
			    }else  if(instance == "hope"){
			    	 $('#tax_'+splitted[1]).val(ui.item.tax);
			    }
           
	            var is_contract = ui.item.is_contract;
	            if(is_contract == '1')
	            {
	            	$('#isContract_'+splitted[1]).show();
	            	$('#ItisContract_'+splitted[1]).val(1);
	            }
	            else
	            {
	            	$('#isContract_'+splitted[1]).hide();
	            	$('#ItisContract_'+splitted[1]).val(0);
	            }
            //}
		 },
		 messages: {
		        noResults: '',
		        results: function() {
			        }
		 }		
 	});
});

/* $('.Add_more').on('click',function(){ 

	//document.getElementById('contract_name').disabled = true;  //to disable the contract select
	var contract = ($('#contract_name').val()) ? $('#contract_name').val() : null ;
	var supplier_id = ($('#supplier_id').val()) ? $('#supplier_id').val() : null ;
	var orderFor = ($('#orderFor').val()) ? $('#orderFor').val() : null ;
	
	//EOF enter click
	$('.product_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "autocompleteForPO","admin" => false,"plugin"=>false)); ?>"+"/"+supplier_id+"/"+contract+"/"+orderFor,
		 minLength: 1,
		 select: function( event, ui ) {
			var idd = $(this).attr('id');
            splitted = idd.split("_");
            $('#productid_'+splitted[1]).val(ui.item.id);
            $('#manufacturer_'+splitted[1]).val(ui.item.manufacturer);
            $('#pack_'+splitted[1]).val(ui.item.pack);
            $('#havquantity_'+splitted[1]).val(ui.item.quantity);
            $('#batch-number_'+splitted[1]).val(ui.item.batch_number);
            $('#mrp_'+splitted[1]).val(ui.item.mrp);
            $('#sellingPrice_'+splitted[1]).val(ui.item.selling_price);
            $('#purchasePrice_'+splitted[1]).val(ui.item.purchase_price);
            $('#tax_'+splitted[1]).val(ui.item.tax);

            var is_contract = ui.item.is_contract;
            if(is_contract == '1')
            {
            	$('#isContract_'+splitted[1]).show();
            	$('#ItisContract_'+splitted[1]).val(1);
            }
            else
            {
            	$('#isContract_'+splitted[1]).hide();
            	$('#ItisContract_'+splitted[1]).val(0);
            }
		 },
		 messages: {
		        noResults: '',
		        results: function() {
			        }
		 }		
 	});

});*/


function displayQty(id)
{
      var idd = $(id).attr('id');
	  splitted = idd.split("_");
	  var purchasePrice = parseFloat(($("#purchasePrice_"+splitted[1]).val()!='')?$("#purchasePrice_"+splitted[1]).val():0);
	  var tax = parseFloat(($("#tax_"+splitted[1]).val()!='')?$("#tax_"+splitted[1]).val():0);
	  var quantity = parseFloat(($("#quantity_"+splitted[1]).val()!='')?$("#quantity_"+splitted[1]).val():0);
	 if(isNaN(tax)){
		tax = 0;
	 } 
	  var vatTotal = (purchasePrice*tax)/100;

	  total = quantity * purchasePrice;		//total amount

	  var totalVatForQuantity = quantity * vatTotal;		//for particular product VAT			

	  $("#amount_"+splitted[1]).val(total.toFixed(2));
	  $("#vat_"+splitted[1]).val(totalVatForQuantity.toFixed(2));

	  sum = 0;
	  vat = 0;
		
	  $('.amount').each(function() { 
		    if(this.value!== undefined  && this.value != ''  ){
			    var fieldNo = $(this).attr('fieldno'); 
	        	sum += parseFloat(this.value); 
	        	if($("#vat_"+fieldNo).val() != undefined){	 
			    	vat += parseFloat($("#vat_"+fieldNo).val());
	        	}	  
	        } 		        				        
	    }); 
	    
	  $("#total").html(sum.toFixed(2));			//display total
      $("#total_amount").val(Math.round(sum.toFixed(2)));	//hold total
      $("#Tvat").html(vat.toFixed(2));			//display total vat
      $("#total_vat").val(Math.round(vat.toFixed(2)));		//hold total vat

      Tnet = parseFloat(sum + vat);
      var roundOff = Tnet - Math.round(Tnet);
      $("#Tnet").html(Math.round(Tnet.toFixed(2)));			//display total net amount
      $("#total_net").val(Math.round(Tnet.toFixed(2)));		//hold total net amount
      $("#roundOff").html(roundOff.toFixed(2));
}

$(document).on('keyup',".quantity, .tax, .purchasePrice",function() {
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
	displayQty(this);
});



function addFields()
{
	var number_of_field = parseInt($("#no_of_fields").val())+1;
	
	var amoutRow = $("#ampoutRow");
    var field = '';
    field += '<tr id="row'+number_of_field+'">';
	//field += '<td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
    field += '<td align="center" valign="middle"  width="185"><input name="data[purchase_order_item]['+number_of_field+'][product_name]" id="item-name_'+number_of_field+'" type="text" class="textBoxExpnd validate[required] product_name"   style="width:100%;" fieldNo="'+number_of_field+'" /><input type="hidden" name="data[purchase_order_item]['+number_of_field+'][product_id]" class="product_id" id="productid_'+number_of_field+'"/> <input type="hidden" name="data[purchase_order_item]['+number_of_field+'][is_contract]" class="ItisContract" id="ItisContract_'+number_of_field+'" value="0"/> </td>';
	field += '<td align="center" valign="middle"><span class="manufact" id="manu_'+number_of_field+'"></span><input name="data[purchase_order_item]['+number_of_field+'][manufacturer]" id="manufacturer_'+number_of_field+'" type="hidden" class="textBoxExpnd manufacturer" style="width:100%;" readonly="readonly"/></td>';
	field += '<td align="center" valign="middle"><span class="packk" id="pac_'+number_of_field+'"></span><input name="data[purchase_order_item]['+number_of_field+'][pack]" id="pack_'+number_of_field+'" type="hidden" class="textBoxExpnd pack" style="width:100%;" readonly="readonly" autocomplete="off"/></td>';
    field += '<td align="center" valign="middle"><span class="batchnumber" id="batch_'+number_of_field+'"></span><input name="data[purchase_order_item]['+number_of_field+'][batch_number]" id="batch-number_'+number_of_field+'" type="hidden" class="textBoxExpnd batch_number" style="width:100%;" autocomplete="off" readonly="readonly" fieldNo="'+number_of_field+'"/><input type="hidden" name="data[purchase_order_item]['+number_of_field+'][expiry_date]" id="expiryDate_'+number_of_field+'" /></td>';
    field += '<td align="center" valign="middle"><input name="data[purchase_order_item]['+number_of_field+'][mrp]" id="mrp_'+number_of_field+'" type="text" class="numberOnly textBoxExpnd mrp" style="width:100%;"  autocomplete="off"/></td>';
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][selling_price]" type="text" class="textBoxExpnd numberOnly sellingPrice" id="sellingPrice_'+number_of_field+'" style="width:100%;" autocomplete="off"/></td>';
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][purchase_price]" type="text" class="textBoxExpnd numberOnly purchasePrice" id="purchasePrice_'+number_of_field+'" style="width:100%;" autocomplete="off"/></td>';
    

	if(instance == "kanpur"){
		field += '<td valign="middle" style="text-align:center;"><select name="data[purchase_order_item]['+number_of_field+'][vat_class_id]" class="textBoxExpnd vatDisplay" id="vatDisplay_'+number_of_field+'" style="width:100%;" autocomplete="off"></select> <input type="hidden" name="data[purchase_order_item]['+number_of_field+'][tax]" id="tax_'+number_of_field+'" value=""/></td>';
	}else  if(instance == "hope"){
		field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][tax]" type="text" class="textBoxExpnd tax" id="tax_'+number_of_field+'" style="width:100%;" autocomplete="off" /><input type="hidden" name="data[purchase_order_item]['+number_of_field+'][vatTotal]" id="vatTotal_'+number_of_field+'" value=""/></td>';
	}
    
    field += '<td valign="middle" style="text-align:center;" id="havquantity_'+number_of_field+'" class="havquantity"> </td>';
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][quantity_order]" type="text" class="textBoxExpnd quantity validate[required]" id="quantity_'+number_of_field+'" autocomplete="off" style="width:100%;" fieldNo="'+number_of_field+'"/></td>';
    if(instance != "vadodara"){
    	field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][vat]" type="text" class="textBoxExpnd vat" value="" id="vat_'+number_of_field+'" style="width:100%;" readonly="readonly" autocomplete="off"/></td> ';
    }
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][amount]" fieldNo="'+number_of_field+'" type="text" class="textBoxExpnd amount"  value" id="amount_'+number_of_field+'" style="width:100%;" readonly="readonly" autocomplete="off"/></td> ';
	field += '<td valign="middle" style="text-align:center;"> <table> <tr> <td id="isContract_'+number_of_field+'" style="display:none;"> <img title="Contract" alt="Contract" src="/DrmHope/img/tick.png" /> </td> <td> <a href="javascript:void(0);" id="delete-row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a> </td> </tr> </table> </td> ';
	field += '</tr>';
	$("#no_of_fields").val(number_of_field);
	$("#item-row").append(field);
	$("#item-row").append(amoutRow);
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}else{
	$("#remove-btn").css("display","inline");
	}
	$("#item-name_"+number_of_field).focus();
	//event.preventDefault();
	$("#vatDisplay_"+number_of_field).append( new Option('Select Vat' , '') );
	$.each(opt, function (key, value) {
		$("#vatDisplay_"+number_of_field).append("<option value='"+key+"'>"+value+"</option>" );
	});
	
}

$(document).on('change',".vatDisplay",function(){
	var id = $(this).attr('id');
	splittedArr = id.split("_");
	var vatVal = this.value;
	if(vatVal != ''){
		$.each(optValue, function (key, value) {
			if(key == vatVal){
				$("#tax_"+splittedArr[1]).val(value);
			}
		});
	}else{
		$("#tax_"+splittedArr[1]).val(0);
	}
	displayQty(this);
});

function removeRow(){
 	var number_of_field = parseInt($("#no_of_fields").val());
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();
		$("#no_of_fields").val(number_of_field-1);
	}
		if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}
}

function deletRow(id){
	var number_of_field = parseInt($("#no_of_fields").val());

	var count = 0;
	$(".product_name").each(function(){
		count++;
	});
	if(count == 1){
		alert("Single row can't delete.");
		return false;
	}

	$("#row"+id).remove();
	displayQty(this);
	//$("#no_of_fields").val(number_of_field-1);
		var table = $('#item-row');
	   	summands = table.find('tr');
		var sr_no = 1;
		summands.each(function ()
		{
			var cell = $(this).find('.sr_number');
			cell.each(function ()
			{
				$(this).html(sr_no);
				sr_no = sr_no+1;
			});
		});
		if (parseInt($("#no_of_fields").val()) == 1){
			$("#remove-btn").css("display","none");
		}
	}


$("#contract_name").change(function(){

	if($(this).val() != '')
	{
		$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'Contracts', "action" => "findContractDetails", "admin" => false)); ?>"+"/"+$(this).val(),
			  context: document.body,
				success: function(data){
				    $("#note").show();
				    parseData = $.parseJSON(data);
					$("#min-max-po").html(parseData.minWithCurrency).fadeIn('slow');
					minPOAmt = parseData.minPOAmt;
					maxPOAmt = parseData.maxPOAmt;
				}
		});	
	}
	else
	{
		$("#note").hide();
	}
});



$("#submitButton, #submitButtonToGrn").click(function(){
	var valid = jQuery("#Purchase-order").validationEngine('validate');
	
	if(valid == true){
		$("#submitButton").hide();
		$("#submitButtonToGrn").hide(); 
		
		var contractIds = $("#contract_name").val(); 
			var totalAmt =  parseInt($("#total_amount").val()); 
			
			/*if(contractIds != '')
			{ 
				if(totalAmt >= minPOAmt && totalAmt <= maxPOAmt)
				{
					return true  ;
				}else {
					alert("Total amount should be in range of Contract Min - Max PO Amount");
					return false;
				}  
				//return false ; 
			}*/
	}else{
		return false;
	}
});


(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"Required.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Minimum ",
                    "alertText2": " characters allowed"
                },
             	"email": {
                    // Simplified, was not working in the Iphone browser
                    "regex": /^([A-Za-z0-9_\-\.\'])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/,
                    "alertText": "* Invalid email address"
                },
				 "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Invalid phone number"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Numbers Only"
                }
            };

        }
    };
    $.validationEngineLanguage.newLang();

    $( "#orderDate" ).datepicker({
    	showOn: "both",
    	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
    	buttonImageOnly: true,
    	changeMonth: true,
    	changeYear: true,
    	yearRange: '1950',			 
    	dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',	
    });

    $( "#order_date_no_back" ).datepicker({
    	showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',	
		minDate: new Date(),		  
		dateFormat: '<?php echo $this->General->GeneralDate("HH:II:SS");?>',		
    });


})(jQuery);

$("#addProduct").click(function(){
    $.fancybox(
    { 						
        'autoDimensions':false,
        'width'    : '70%',
        'height'   : '90%',
        'autoScale': true,
            'transitionIn': 'fade',
        'transitionOut': 'fade', 
        'transitionIn'	:	'elastic',
            'transitionOut'	:	'elastic',
            'speedIn'		:	600, 
            'speedOut'		:	200,				    
        'type': 'iframe',
        'iframe' : {
            scrolling : 'auto',
            preload   : false //opening the fancy box before it gets loaded 
        },
        'helpers'   : { 
            'overlay' : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
        },
        'afterClose':function(){
                //  getReload(year,month);
        },
        'href' : "<?php echo $this->Html->url(array("controller"=>"pharmacy", "action" => "add_new_product","inventory" => false,'admin'=>false,'?'=>array('flag'=>1))); ?>"
        //'href' : "<?php echo $this->Html->url(array("controller" =>"BloodBanks","action" =>"wholeBloodStockAvailable","admin"=>false)); ?>"
    });
    
        
});

$(document).on('keyup',".product_name",function(){
	var fieldno = $(this).attr('fieldno');
	if($(this).val() == ''){  
		$("#productid_"+fieldno).val('');
		$("#manufacturer_"+fieldno).val('');
		$("#pack_"+fieldno).val('');
		$('#manu_'+fieldno).empty();
        $('#pac_'+fieldno).empty();
        $('#batch_'+fieldno).empty();
		$("#batch-number_"+fieldno).val('');
		$("#mrp_"+fieldno).val('');
		$("#sellingPrice_"+fieldno).val('');
		$("#purchasePrice_"+fieldno).val('');
		$("#tax_"+fieldno).val('');
		$("#havquantity_"+fieldno).text('');
		$("#quantity_"+fieldno).val('');
		$("#vat_"+fieldno).val('');
		$("#amount_"+fieldno).val('');
	}
});


/*function checkIsItemRemovedtest(id){
	var fieldno = $(id).attr('fieldno');
	console.log(fieldno+"****8"+id);
	if($(id).val() == ''){ 
		$("#productid_"+fieldno).val('');
		$("#manufacturer_"+fieldno).val('');
		$("#pack_"+fieldno).val('');
		$('#manu_'+splitted[1]).empty();
        $('#pac_'+splitted[1]).empty();
        $('#batch_'+splitted[1]).empty();
		$("#batch-number_"+fieldno).val('');
		$("#mrp_"+fieldno).val('');
		$("#sellingPrice_"+fieldno).val('');
		$("#purchasePrice_"+fieldno).val('');
		$("#tax_"+fieldno).val('');
		$("#havquantity_"+fieldno).val('');
		$("#quantity_"+fieldno).val('');
		$("#vat_"+fieldno).val('');
		$("#amount_"+fieldno).val('');
	}	
}*/

	function checkExistProduct(productId,fieldno){
		$(".product_id").each(function(){
			if(this.value == productId){
				alert('This product is already selected');
				$("#item-name_"+fieldno).val('');
				$("#item-name_"+fieldno).focus();
				return false;
			}
		});	
	}

	$(document).on('input','.numberOnly',function(){
		if (/[^0-9\.]/g.test(this.value))
	    {
	    	this.value = this.value.replace(/[^0-9\.]/g,'');
	    }
	    if(this.value.split('.').length>2) 
			this.value =this.value.replace(/\.+$/,"");
	
	});

</script>
