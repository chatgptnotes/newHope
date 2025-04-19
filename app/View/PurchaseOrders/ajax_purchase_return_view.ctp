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
<table cellpadding="0" cellspacing="0" border="0" align="center">
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

<?php echo $this->Form->create('',array('id'=>'Purchase-receipt'));?>
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
<table width="95%" align="center" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<thead>
		<tr>
			<th width="40" align="center" valign="top" style="text-align: center;">Return Date</th>
			<th width="40" align="center" valign="top" style="text-align: center;">GRN.No.</th>
			<th width="100" align="center" valign="top" style="text-align: center;">Product Name</th>
			<th width="60" valign="top" style="text-align: center;">Quantity Received</th>
			<th width="60" valign="top" style="text-align: center;">Quantity Returned</th>
			<th width="20" valign="top" style="text-align: center;">Remark</th>
			
		</tr>
	</thead>
	<?php //debug($receipt_items);?>
	<tbody>
		<?php $count=0; foreach($returnValues as $key=>$item) { $count++; ?>
		<tr>
			<td align="center" valign="middle" >
			<?php 
				echo $this->DateFormat->formatDate2Local($item['PurchaseReturn']['created_time'],Configure::read('date_format'),true);
			?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo $item['PurchaseReturn']['grn_no'];
				?>
			</td>
			<td style="text-align: center;">
				<?php 
					echo $item['Product']['name'];
				?>
			</td>
			<td valign="middle" style="text-align: center;">
				<?php 
					echo $item['PurchaseOrderItem']['quantity_received'];
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo ($item['PurchaseReturn']['return_quantity']);
				?>
			</td>
			<td style="text-align: center;">
				<?php 
					echo $item['PurchaseReturn']['remark'];
				?>
			</td>
			</tr>
		<?php } //foreach ends here ?>
		
	</tbody>
</table>
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
<div class="clr ht5"></div>
<div class="btns">
	<!--<input name="submit" type="submit" value="Submit" class="blueBtn" id="submitButton" />-->
<?php echo $this->Form->end();?>
</div>


<div class="btns">
	<?php
		//echo $this->Html->link('Print','javascript:void(0)',array('escape' => false,'class'=>'blueBtn printButton','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'PurchaseOrders','action'=>'printPurchaseReceived',
//$po_details['PurchaseOrder']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));
	?>
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


$("#submitButton").click(function(){

	var valid = jQuery("#Purchase-receipt").validationEngine('validate');
	if(valid){
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




</script>