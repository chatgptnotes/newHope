<div class="inner_title">
	<h3>
		<?php echo __('Goods Received Notes', true); ?>
	</h3>
	<span>
		<?php
			echo $this->Html->link(__('Back to list'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn Back-to-List','id'=>'Back-to-List'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>

<?php if(!empty($po_details)) { ?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td>
	<table>
		<td class="tdLabel2"><font style="font-weight:bold;">Purchase Order Number: </font> 
			<?php  
				echo $po_details['PurchaseOrder']['purchase_order_number'];
			?>
		</td>
		
		<td class="tdLabel2"><font style="font-weight:bold;">GRN Number: </font> 
			<?php  
				echo $receipt_items[0]['PurchaseOrderItem']['grn_no'];
			?>
		</td>
	
		<td class="tdLabel2"><font style="font-weight:bold;">Party Invoice Number: </font> 
			<?php  
				echo $receipt_items[0]['PurchaseOrderItem']['party_invoice_number'];
			?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Supplier: </font>
			<?php echo $po_details['InventorySupplier']['name']; ?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Order Created Date: </font>
			<?php 
				echo $this->DateFormat->formatDate2Local($po_details['PurchaseOrder']['order_date'],Configure::read('date_format'),true); ?>
		</td>
		
		<?php if(!empty($po_details['PurchaseOrder']['create_time'])) { ?>
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Goods Received Date: </font>
			<?php 
				echo $this->DateFormat->formatDate2Local($receipt_items[0]['PurchaseOrderItem']['received_date'],Configure::read('date_format'),true); ?>
		</td>
		<?php } ?>
	</table>
	</td>	
	</tr>
</table>
<?php }  ?>

<div class="clr ht5"></div>
<?php //debug($this->params->pass);?>
<?php echo $this->Form->create('Purchase_return',array('id'=>'purchase_return'));?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row" align="center">
	<thead>
		<tr>
			<th class="table_cell" align="left"><?php echo $this->Form->input('',
					array('id'=>'checkMaster','class'=>'checkMaster','type'=>'checkbox','div'=>false,'label'=>false)); ?></th>
			<th style="text-align: center;">Product Name</th>
			<th style="text-align: center;">Current Stock</th>
			<th style="text-align: center;">Quantity Received</th>
			<th style="text-align: center;">Returned Quantity</th>
			<th style="text-align: center;">Cause Of Return</th>
			<th style="text-align: center;">Return Amount</th>
		</tr>	
	</thead>
]	<?php //debug($receipt_items);?>	
	<tbody>
		<?php foreach($receipt_items as $key=>$item) {  
				$recived_qty = $item['PurchaseOrderItem']['quantity_received'];
				$curr_stock = ($item['PharmacyItem']['stock']*$item['PharmacyItem']['pack'])+$item['PharmacyItem']['loose_stock'];
		?>
		<tr class="rowClass" id="row_<?php echo $key; ?>">
			<td class="table_cell" align="left">
			<?php 
			echo $this->Form->hidden('',array('name'=>"data[Purchase_return][$key][purchase_order_id]",'value'=>$item['PurchaseOrderItem']['purchase_order_id']));
			echo $this->Form->hidden('',array('name'=>"data[Purchase_return][$key][purchase_order_item_id]",'value'=>$item['PurchaseOrderItem']['id']));
			echo $this->Form->hidden('',array('name'=>"data[Purchase_return][$key][product_id]",'value'=>$item['PurchaseOrderItem']['product_id']));
			echo $this->Form->hidden('',array('name'=>"data[Purchase_return][$key][grn_no]",'value'=>$item['PurchaseOrderItem']['grn_no']));
			echo $this->Form->hidden('',array('name'=>"data[Purchase_return][$key][pack]",'value'=>$item['PharmacyItem']['pack']));
			echo $this->Form->hidden('',array('id'=>'purchasePrice_'.$key,'name'=>"data[Purchase_return][$key][purchase_price]",'value'=>$item['PurchaseOrderItem']['purchase_price']));
			?>
			<?php
			//debug($item);
				echo $this->Form->input('Item.checkedReturn',array('hiddenField'=>false,'type'=>'checkbox'/* ,'checked'=>'checked' */,'fieldno'=>$key,'div'=>false,'label'=>false,
					'id'=>'checkReturn_'.$item['Product']['id'],'class'=>'isCheck','value'=>$item['Product']['id'])); 
				?>
			</td>
			
			<td valign="middle">
				<?php
					echo $item['Product']['name'];
				?>
			</td>
			
			<td valign="middle" align="center">
				<?php
					echo $curr_stock;
					echo $this->Form->input('',array('id'=>'currentStock_'.$key,'type'=>'hidden','class'=>'current_stock','div'=>false,'value'=>$curr_stock,'fieldno'=>$key,'label'=>false));
				?>
			</td>
			
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo $recived_qty;
					echo $this->Form->input('',array('id'=>'recievedQty_'.$key,'type'=>'hidden','class'=>'textBoxExpnd validate[required] recieved_qty','div'=>false,'value'=>$recived_qty,'fieldno'=>$key,'label'=>false));
				?>
			</td>
			
			<td valign="middle" style="text-align: center;" >
			<?php 
				echo $this->Form->input('return_quantity1',array('name'=>"data[Purchase_return][$key][return_quantity]",'id'=>'returnQty_'.$key,'class'=>'return_quantity','type'=>'text','div'=>false ,'readonly'=>'readonly','fieldno'=>$key,'label'=>false,'style'=>"width:80px;"));
			?>
			</td>
			
			<td valign="middle" style="text-align: center;">
			<?php 
			echo $this->Form->input('causeToReturn',array('name'=>"data[Purchase_return][$key][return_cause]",'id'=>'return_cause_'.$key,'type'=>'text','fieldno'=>$key,'readonly'=>'readonly','div'=>false,'label'=>false));
			?>
			</td>
			
			<td>
			<?php echo $this->Form->input('return_amount',array('name'=>"data[Purchase_return][$key][total]",'id'=>'returnAmount_'.$key,'type'=>'text','fieldno'=>$key,'readonly'=>'readonly','div'=>false,'label'=>false)); ?>
			</td>
			<?php echo $this->Form->hidden('',array('name'=>"data[Purchase_return][$key][batch_number]",'value'=>$item['PurchaseOrderItem']['batch_number']));?>
			</tr>
		<?php  } //foreach ends here ?>
		
	</tbody>
</table>

<div class="clr ht5"></div>
<div class="btns">
	<input name="submit" type="submit" value="Submit" class="blueBtn" id="submitButton" />
<?php echo $this->Form->end();?>
</div>

<script>


$(".quantity").blur(function(){
	//alert("yoyo");
	  if($(this).val()!=""){
		  if($(this).val() == 0)
		  {
			  alert("please enter atleast product");
		  }
		  else
		  {
			  var idd = $(this).attr('id');
			  splitted = idd.split("_");
			  var purchasePrice = $("#purchasePrice_"+splitted[1]).val();
			  var total = $(this).val()*purchasePrice;
			  //alert(purchasePrice);
			  $("#amount_"+splitted[1]).val(total);
	          
		  }
	  }
});

$(document).ready(function(){
	
	$(function()
	{
		$(".expiry_date").datepicker({
			showOn: "button",
			buttonImage: "/getnabh/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
		});
	});
	
});

var poId = "<?php echo $this->params->pass[0];?>"
var poiId = "<?php echo $this->params->pass[1];?>"
var returnValue = "<?php echo $this->params->pass[2];?>"
		
$("#submitButton").click(function(){
	var valid = jQuery("#purchase_return").validationEngine('validate');
	
	if(valid){
		$("#submitButton").hide();
		return true;
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
})(jQuery);

/* On click of invidual ckeckbox make readonly true false */
var fieldno = $(this).attr('fieldno');
$('.isCheck').click(function(){
	var data = $(this).attr('id');
	splitted = data.split("_"); 
	var fieldno = $(this).attr('fieldno');
	if($('#checkReturn_'+splitted[1]).is(":checked",true)){
		$('#returnQty_'+fieldno).prop('readonly',false);
		$('#return_cause_'+fieldno).prop('readonly',false);
	}else{
		$('#returnQty_'+fieldno).prop('readonly',true);
		$('#return_cause_'+fieldno).prop('readonly',true);
		$('#returnQty_'+fieldno).val('');
		$('#return_cause_'+fieldno).val('');
	}
	
});

/* Check or Uncheck on click of checkMaster */
$(".checkMaster").click(function(){
	if($(this).is(":checked",true)){
		$(".isCheck").each(function(){
			var fieldno = $(this).attr('fieldno');
			$(this).prop('checked',true);
			$('#returnQty_'+fieldno).prop('readonly',false);
			$('#return_cause_'+fieldno).prop('readonly',false);
		});
	}else{
		$(".isCheck").each(function(){
			var fieldno = $(this).attr('fieldno');
			$(this).prop('checked',false);
			$('#returnQty_'+fieldno).prop('readonly',true);
			$('#return_cause_'+fieldno).prop('readonly',true);
			$('#returnQty_'+fieldno).val('');
			$('#return_cause_'+fieldno).val('');
		});
	}
});

/* On click of retuirn quantity dont allow quantiyt more than stock*/
$(".return_quantity").keyup(function(){
	var fieldno = $(this).attr('fieldno');
	var qty = parseInt($('#returnQty_'+fieldno).val());
	var currentStock = parseInt($('#currentStock_'+fieldno).val());
	var recievedQty = parseInt($('#recievedQty_'+fieldno).val());

	if(qty > currentStock){
		alert('Quantity is greater than stock');
		$('#returnQty_'+fieldno).val('');
	}
	if(qty > recievedQty){
		alert('Quantity is greater than recieved quantity');
		$('#returnQty_'+fieldno).val('');
	}
	
 	calculateReturnAmount(this);
	
});
/* END of Validation for returnQty*/
function calculateReturnAmount(id){

	if($(id)!=""){
		var fieldno = $(id).attr('fieldNo') ;
		var qty = parseInt($("#returnQty_"+fieldno).val()!=""?$("#returnQty_"+fieldno).val():0);
		var purchase_price = parseFloat($("#purchasePrice_"+fieldno).val()!=""?$("#purchasePrice_"+fieldno).val():0); 
		var pack = parseInt($("#pack_"+fieldno).val()!=""?$("#pack_"+fieldno).val():0);

		var returnAmnt = (purchase_price*qty);
		$('#returnAmount_'+fieldno).val(returnAmnt.toFixed(2));
			
	}	
	
}
 
 
</script>