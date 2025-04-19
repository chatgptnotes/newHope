<div class="inner_title" >
<?php echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy')); ?>
	<h3>Sales Return</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>

<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InventoryPharmacySalesReturnInventorySalesReturnForm").validationEngine();
	});
	
	$(document).on('click',"#submitButton",function(){ 
		var valid = jQuery("#InventoryPharmacySalesReturnInventorySalesReturnForm").validationEngine('validate');
		if(valid == true){
			$("#submitButton").hide();
		}else{
			return false;
		}
	});

</script>
<style>
.formErrorContent {
	width: 43px !important;
}
</style>
<?php
//echo $this->Html->script('jquery.autocomplete_pharmacy');
//echo $this->Html->css('jquery.autocomplete.css');

echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>
<div class="clr ht5"></div>
<?php echo $this->Form->create('InventoryPharmacySalesReturn',array('id'=>'InventoryPharmacySalesReturnInventorySalesReturnForm','onkeypress'=>"return event.keyCode != 13;"));
echo $this->Form->hidden('InventoryPharmacySalesReturn.phar_sale_discount',array('value'=>'','id'=>'pharmacySaleDiscountPer'));

		?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="100">&nbsp;</td> 
		<td class="tdLabel2">Patient Name/ID <font color="red">*</font>:&nbsp;</td>
		<td width="300" class="tdLabel2"><input name="InventoryPharmacySalesReturn[party_name]" type="text"  
			class="textBoxExpnd validate[required]" id="party_name" onkeyup="checkIsRemoved(this)"
			value="<?php echo $editReturn['Patient']['lookup_name']?>" onkeyup="clearField(this)" /><input
			name="InventoryPharmacySalesReturn[patient_id]" id="person_id"
			value="<?php echo $editReturn['Patient']['id']?>" type="hidden" />
			<input name="InventoryPharmacySalesReturn[party_code]" type="hidden"
			class="textBoxExpnd" id="party_code" value="<?php echo $editReturn['Patient']['admission_id']?>"
			onkeyup="clearField(this)" /> 
			<input	name="InventoryPharmacySalesReturn[admission_type]" id="admission_type" type="hidden" />
			<?php echo $this->Form->hidden('',array('id'=>'tariff_id','name'=>"data[PharmacySalesBill][tariff]",'value'=>''));?>
			<input name="pharmacy_sales_bill_id"
			id="pharmacy_sales_bill_id" value="" type="hidden" /> 
		</td>
		<td width="140"><?php echo $this->Form->input('all_encounter',array('type'=>'checkbox','label'=>false,'div'=>false,'id'=>'all_encounter','title'=>'Show all encounter of patient')); 
						echo $this->Form->hidden('isChecked',array('id'=>'is_checked','value'=>'0')); ?>All Encounter</td>
		<td id="tariff" width="140"></td>
	</tr>
</table>
<div class="clr ht5"></div>


<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<tr><td colspan="2"><font color="#ff343"><i>(MSU = Minimum Saleable Unit)</i></font></td></tr>
	<tr>
		<!--<th width="40" align="center" valign="top" style="text-align: center;">Sr.
			No.</th>-->
		<!--<th width="80" align="center" valign="top" style="text-align: center;">Item
			Code<font color="red">*</font></th>
		-->
		<th width="80" align="center" valign="top"
			style="text-align: center;">Item Name<font color="red">*</font></th>
		<th width="100" valign="top" style="text-align: center;">Quantity<font color="red">*</font></th>
		<th width="50" valign="top" style="text-align: center;">Sold Quantity<font color="red"></font></th>
		<!-- <th width="120" align="center" valign="top" style="text-align: center;">Manufacturer</th> -->
		<th width="50" valign="top" style="text-align: center;">Pack</th>
		<th width="100" align="center" valign="top" style="text-align: center;">Batch
			No.<font color="red">*</font></th>
		<th width="150" align="center" valign="top" style="text-align: center;">Expiry Date<font color="red">*</font></th>
		<th width="50" valign="top" style="text-align: center;">MRP<font color="red">*</font></th>
		<!-- <th width="60" valign="top" style="text-align: center;">Ordered Qty</th> --> 
		<th width="50" valign="top" style="text-align: center;">Price<font color="red">*</font></th>
		<?php if(strtolower($this->Session->read('website.instance'))!="hope") { ?>
		<th width="40" valign="top" style="text-align: center;">Discount</th>
		<?php } ?>
		
		<th width="60" valign="top" style="text-align: center;">Amount<font color="red">*</font></th>
		<th width="60" valign="top" style="text-align: center;">Net Amount<font color="red">*</font></th>
		<th width="10" valign="top" style="text-align: center;">#</th>
	</tr>
	
	<?php $cnt=1;
	if(!empty($editReturn)){
		//debug($editReturn);
	foreach($editReturn['InventoryPharmacySalesReturnsDetail'] as $editItem){?>
		<tr id="<?php echo "row$cnt"?>">
		<!--<td align="center" valign="middle" class="sr_number">1</td>-->
		
		<!--<td align="center" valign="middle">
		<input name="item_code[]"
			type="text" class="textBoxExpnd validate[required,number] item_code"
			id="<?php echo "item_code$cnt"?>"  value="<?php echo $itemArray[$editItem['item_id']]['item_code']?>" style="width: 100%;" fieldNo="<?php echo $cnt?>"
			onkeyup="checkIsItemRemoved(this)" /> 
					</td>-->
					
			<td align="center" valign="middle" width="185">
					<input name="item_id[]"
			id="item_id1" type="hidden" value="<?php echo $editItem['item_id']?>" style="width: 80%;" />
			<input	name="item_name[]" type="text"
			class="textBoxExpnd validate[required] item_name" id="<?php echo "item_name-$cnt"?>"
			value="<?php echo $itemArray[$editItem['item_id']]['item_name']?>" style="width: 70%;" fieldNo="<?php echo $cnt?>"
			onkeyup="checkIsItemRemoved(this)" /> <a href="#" id="viewDetail1"
			class='fancy' ><img title="View Item"
				alt="View Item" src="/DrmHope/img/icons/view-icon.png"> </a></td>
			<td valign="middle" style="text-align: center;">
			
			<table >
				<tr>
					<td>
						<input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" id="<?php echo "qty_$cnt"?>" value="<?php echo $editItem['qty']?>" 
							style="width:100%;" fieldNo="<?php echo $cnt?>" /> 
						<input type="hidden" id="<?php echo "stockQty$cnt"?>" value="<?php echo $itemArray[$editItem['item_id']]['stock']?>" />
						<input type="hidden" id="<?php echo "returnLimit$cnt"?>" value="0" />
					</td>
					<td>
						<?php 
   							echo $this->Form->input('PharmacySalesBill.item_type', array('style'=>'width:60px;','name'=>"itemType[]",'class'=>'textBoxExpnd itemType',
   								'div' => false,'fieldNo'=>"1",'label' => false,'autocomplete'=>'off','id' => 'itemType_'.$cnt,'value'=>$editItem['qty_type'],
   								'options'=>array('Tab'=>'MSU'/*,'Pack'=>'Pack','Unit'=>'Unit'*/))); 
						?>
					</td>
				</tr>
			</table>
				</td>		
				<input name="oQty[]"
					type="hidden" class="textBoxExpnd validate[required,number] "
					id="<?php echo "oQty$cnt"?>"  value="" style="width: 100%;" fieldNo="<?php echo $cnt?>" readonly="true"/> 
				
				<td valign="middle" style="text-align: center;">
				<input name="sQty[]" type="text" id="<?php echo "sQty$cnt"?>"  value="<?php echo $itemArray[$editItem['item_id']]['sold_qty']?>" style="width: 100%;" fieldNo="<?php echo $cnt?>" readonly="true"/> 
				</td>
				<!--<td align="center" valign="middle"><input name="manufacturer[]"
					type="text" class="textBoxExpnd " id="<?php echo "manufacturer$cnt"?>" 
					value="<?php echo $itemArray[$editItem['item_id']]['manufacturer']?>" style="width: 100%;" readonly="true" /></td>
				-->
				<td align="center" valign="middle"><input name="pack[]" type="text"
					class="textBoxExpnd " id="<?php echo "pack$cnt"?>"  value="<?php echo $itemArray[$editItem['item_id']]['pack']?>"
					style="width: 100%;" readonly="true" /></td>
			
		<td valign="middle" style="text-align: center;"><input
					name="batch_number[]" type="text"
					class="textBoxExpnd validate[required] batch_number"
					id="<?php echo "batch_number$cnt"?>" value="<?php echo $editItem['batch_no']?>" style="width: 100%;"
					autocomplete="off" fieldNo="<?php echo $cnt?>" /></td>
					
		<?php $expDate=$this->DateFormat->formatDate2Local($editItem['expiry_date'],Configure::read('date_format'),false);?>\
		<?php $website = $this->Session->read('website.instance');
			if($website == "kanpur"){?>
				<td valign="middle" style="text-align: center;"><input
					name="expiry_date[]" type="text"
					class=" textBoxExpnd"
					id="<?php echo "expiry_date$cnt"?>" value="<?php echo $expDate?>" style="width: 80%;"
					autocomplete="off" readonly="true" /></td>
		<?php }else{?>
			<td valign="middle" style="text-align: center;"><input
					name="expiry_date[]" type="text"
					class=" textBoxExpnd validate[required] expiry_date"
					id="<?php echo "expiry_date$cnt"?>" value="<?php echo $expDate?>" style="width: 80%;"
					autocomplete="off" readonly="true" /></td>
		
		<?php }?>
				<td valign="middle" style="text-align: center;"><input name="mrp[]"
					type="text" class="textBoxExpnd validate[required,number] mrp" id="<?php echo "mrp$cnt"?>" fieldNo="<?php echo $cnt?>"
					value="<?php echo $editItem['mrp']?>" style="width: 100%;"  /></td>
					
		<!-- 		<td valign="middle" style="text-align: center;">
		 		<lable name="oQty[]" id="oQty1" readonly="true"></lable>  -->
		<!--  		</td> -->
				
				<td valign="middle" style="text-align: center;"><input name="rate[]"
					type="text" class="textBoxExpnd validate[required,number] rate" id="<?php echo "rate$cnt"?>" fieldNo="<?php echo $cnt?>"
					 value="<?php echo $editItem['sale_price']?>" style="width: 100%;" /></td>
				<?php $amt= $editItem['sale_price'] * $editItem['qty'];?>
				
				<?php if($editItem['qty_type'] == "Tab") { 
					$amt= ($editItem['sale_price'] * $editItem['qty'])/(int)$editItem['pack'];
				}
				?>
				<td valign="middle" style="text-align: center;"><input name="value[]"
					type="text" class="textBoxExpnd validate[required,number] value"
					id="value1"  value="<?php echo $amt?>" style="width: 100%;" /></td>
				<td valign="middle" style="text-align: center;"><a href="javascript:void(0);"
					id="delete-row" onclick="deletRow('1');"><img title="delete row"
						alt="delete row" src="/DrmHope/img/icons/cross.png"> </a></td>
			</tr>
			<input type="hidden" value="<?php echo $editItem['qty']?>" name="pre_sold_qty[]" />
		<input type="hidden" value="<?php echo $cnt;?>" id="no_of_fields" />
	<?php $totAmt=$totAmt+$amt;
	$cnt++;}//EOF foreach
}else{?>
<input type="hidden" value="<?php echo $cnt;?>" id="no_of_fields" />
	<tr id="row1">
		<!--<td align="center" valign="middle" class="sr_number">1</td>-->
		<!--<td align="center" valign="middle"><input name="item_code[]"
			type="text" class="textBoxExpnd validate[required,number] item_code"
			id="item_code1"  value="" style="width: 100%;" fieldNo="1"
			onkeyup="checkIsItemRemoved(this)" /> </td>
		-->
		<td align="center" valign="middle" width="185">
		<input name="item_id[]" id="item_id1" type="hidden" value="" class="itemId" fieldNo="1"/>
		
		<input	name="item_name[]" type="text"
			class="textBoxExpnd validate[required] item_name" id="item_name-1"
			value="" style="width: 100%;" fieldNo="1"
			onkeyup="checkIsItemRemoved(this)" /> 
		<!-- 	<a href="#" id="viewDetail1"
			class='fancy' style="visibility: hidden"><img title="View Item"
				alt="View Item" src="/DrmHope/img/icons/view-icon.png"> </a> -->
				
			</td>
		
		<!-- <td valign="middle" style="text-align: center;"><input name="qty[]"
			type="text" class="textBoxExpnd validate[required,number] quantity"
			id="qty1" value="" style="width: 100%;" fieldNo="1" /> <input
			type="hidden" id="stockQty1" value="0" />
			<input type="hidden" id="returnLimit1" value="0" />
			 <?php 
   				/* echo $this->Form->input('PharmacySalesBill.item_type', array('style'=>'width:60px;','class'=>'itemType',
   								'div' => false,'label' => false,'autocomplete'=>'off','id' => 'itemType_'.$count,
   								'options'=>array('Pack'=>'Pack','Tab'=>'Tab','Unit'=>'Unit')));  */
			?>
		</td> -->
		
		<td valign="middle" style="text-align: center; padding:0px;">
			<table >
				<tr>
					<td>
						<input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" id="qty_1" value="" 
							style="width:100%;" fieldNo="1" readonly="readonly"/> 
						<input type="hidden" id="stockQty1" value="0" autocomplete="off" />
						<input type="hidden" id="returnLimit1" value="0" />
					</td>
					<td>
						<?php 
   							echo $this->Form->input('PharmacySalesBill.item_type', array('style'=>'width:60px;','name'=>"itemType[]",'class'=>'textBoxExpnd itemType',
   								'div' => false,'fieldNo'=>"1",'label' => false,'autocomplete'=>'off','id' => 'itemType_'.$cnt,
   								'options'=>array('Tab'=>'MSU'/*,'Pack'=>'Pack','Unit'=>'Unit'*/))); 
						?>
					</td>
				</tr>
			</table>
		</td>
							
		<input name="oQty[]"
			type="hidden" class="textBoxExpnd validate[required,number] "
			id="oQty1"  value="" style="width: 100%;" fieldNo="1" readonly="true"/> 
		
		<td valign="middle" style="text-align: center;">
		<input name="sQty[]" type="text" id="sQty1" class="textBoxExpnd" value="" style="width: 100%;" fieldNo="1" readonly="true"/> 
		</td>
		<!--<td align="center" valign="middle"><input name="manufacturer[]"
			type="text" class="textBoxExpnd " id="manufacturer1" 
			value="" style="width: 100%;" readonly="true" /></td>
		--><td align="center" valign="middle"><input name="pack[]" type="text"
			class="textBoxExpnd " id="pack1"  value=""
			style="width: 100%;" readonly="true" /></td>
		<td valign="middle" style="text-align: center;" >
			<?php echo $this->Form->input('',array('type'=>'select','options'=>'','class'=>'textBoxExpnd validate[required] batch_number','id'=>'batch_number1', 'style'=>"width: 100%",'autocomplete'=>"off" ,"tabindex"=>"9","fieldNo"=>"1",'label'=>false,'name'=>"data[pharmacyItemId][]")); ?>
		</td>
		<?php $website = $this->Session->read('website.instance');  
			if($website == "kanpur"){
		?>
			<td valign="middle" style="text-align: center;"><input
				name="expiry_date[]" type="text"
				class="textBoxExpnd"
				id="expiry_date1" value="" style="width: 80%;"
				autocomplete="off" readonly="true" /></td>
		<?php }else{?>
		<td valign="middle" style="text-align: center;"><input
			name="expiry_date[]" type="text"
			class="textBoxExpnd validate[required] expiry_date"
			id="expiry_date1" value="" style="width: 80%;"
			autocomplete="off" readonly="true" /></td>
		<?php }?>
		<td valign="middle" style="text-align: center;"><input name="mrp[]"
			type="text" class="textBoxExpnd validate[required,number] mrp" id="mrp1" fieldNo="1"
			value="" style="width: 100%;"  /></td>
			
<!-- 		<td valign="middle" style="text-align: center;">
 		<lable name="oQty[]" id="oQty1" readonly="true"></lable>  -->
<!--  		</td> -->
		
		<td valign="middle" style="text-align: center;"><input name="rate[]"
			type="text" class="textBoxExpnd validate[required,number] rate" id="rate1" fieldNo="1"
			 value="" style="width: 100%;" />
		</td>
		
		<?php if(strtolower($this->Session->read('website.instance'))!="hope") { ?>
		<td>
			<table width="100%" style="padding:0">
				<tr>
					<td style="padding:0">
						<input name="discount[]" type="text" class="itemWiseDiscountAmount textBoxExpnd" id="itemWiseDiscountAmount1" readonly="readonly" fieldNo="1"  value=""  style="width:60%;"/>%
						<input name="itemWiseDiscount[]" type="hidden" class="itemWiseDiscount" id="itemWiseDiscount1" fieldNo="1" value=""/>
					</td>
				<!--<td style="padding:0" id="displayDisc1">
						
					</td>-->
				</tr>
			</table>
		</td>
		<?php } ?>
		
		<td valign="middle" style="text-align: center;"><input name="value[]"
			type="text" class="textBoxExpnd validate[required,number] value"
			id="value1"  value="" style="width: 100%;" /></td>
			
			<td valign="middle" style="text-align: center;"><input name="valueNet[]"
			type="text" class="textBoxExpnd validate[required,number] valueNet"
			id="valueNet1"  value="" style="width: 100%;" /></td>
		<td valign="middle" style="text-align: center;"><a href="javascript:void(0);"
			id="delete-row" onclick="deletRow('1');">
			<?php echo $this->Html->image('icons/cross.png',array('title'=>'delete row','alt'=>'delete row')); ?></a>
			
		</td>
	</tr>
<?php }?>
<?php echo $this->Form->hidden('InventoryPharmacySalesReturn.total_discount_perc',array('value'=>'','id'=>'total_discount_perc'));?>
</table>

<div class="clr ht5"></div>
<div align="right">
	<input name="" type="button" value="Add More" class="blueBtn Add_more"
		onclick="addFields()" />
	<!--<input name="" type="button"
		value="Remove" id="remove-btn" class="blueBtn" 
		onclick="removeRow()" style="display: none" />
--></div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php if($this->Session->read('website.instance') == 'kanpur'){?>
	<tr>
		<td><?php echo __("Payment Mode");?><font color="red" >*</font></td>
		<td> <?php 
		 		echo $this->Form->input('InventoryPharmacySalesReturn.payment_mode', array('class' => 'validate[required]','style'=>'width:141px;', 'type'=>'select',
   					'div' => false,'label' => false,'autocomplete'=>'off','options'=>$mode_of_payment,$disabled,'value'=>"Cash",'id' => 'payment_mode')); ?> 
   		</td>
   	</tr>
   	<?php }?>
	<tr>
		<td align="right">
		<?php $instance = strtolower($this->Session->read('website.instance')); 
		if($instance != "hope"){ ?>
			<span id="cashDisplay" style="display:none;"><?php echo __("Cash : "); ?>
				<?php echo $this->Form->input('is_cash',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'isCash')); ?>	
				<?php echo $this->Form->input('cash_collected',array('type'=>'text','id'=>'cashAmount','readonly'=>'readonly','div'=>false,'label'=>false,'style'=>'width:70px;'))?>
			</span>	
		</td>
		<?php } ?>
		<td align="right" class="tdLabel2" width="80%" style="text-align:right">Total Amount :</td>
		<td width="8%" style="text-align:right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
		<span id="total_amount"><?php echo isset($totAmt)?$totAmt:'0';?></span>
		<input name="InventoryPharmacySalesReturn[total]" id="total_amount_field"
			 value="<?php echo isset($totAmt)?$totAmt:'0';?>" type="hidden" /></td>
	</tr>
	<tr>
		<td align="right"></td>
		<td class="tdLabel2" style="text-align:right">Total Discount :</td>
		<td style="text-align:right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
		<span id="showTotalDiscount">0</span>
		<input type="hidden" id="totalDiscount" name="InventoryPharmacySalesReturn[discount]" value=""/>
		<input type="hidden" id="totalAmountDiscount" name="InventoryPharmacySalesReturn[discount_amount]" value=""/>
	</td>
	</tr>
	
	<tr>
		<td align="right"></td>
		<td class="tdLabel2" style="text-align:right">Net Amount :</td>
		<td style="text-align:right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
		<span id="showNetAmount">0</span>
		</td>
	</tr>
</table>
<div class="btns">
<!-- 	<input name="print" type="submit" value="Print" class="blueBtn" -->
<!-- 		/>  -->
		<input name="submit" type="submit" value="Submit"
		class="blueBtn"  id="submitButton" />

	<?php echo $this->Form->end();?>
</div>

<?php 					
	if(isset($this->params->query['print']) && !empty($_GET['id'])){ 
		echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'Pharmacy','action'=>'inventory_print_view','InventoryPharmacySalesReturnsDetail',$_GET['id']))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
	}
?>
	
<script>
var instance = "<?php echo strtolower($this->Session->read('website.instance')); ?>";
$(document).ready(function(){

	if(instance == "vadodara"){
		$(".expiry_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate("");?>'
		});
	}
		
	$("#party_name").focus(function(){
		$(this).autocomplete({
			source:	"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","non-discharge","inventory" => true,"plugin"=>false)); ?>"+"/"+$("#is_checked").val(),
			select:function (event, ui) {
			    $("#pharmacy_sales_bill_id").val("");
				var person_id = ui.item.id;
				var admissionType = ui.item.admission_type;
				$("#admission_type").val(admissionType);
				$("#person_id").val(person_id);
				$("#party_name").val(ui.item.value);
				var tariff_id = ui.item.tariff_id;
				var tariff_name = ui.item.tariff_name;
				$("#tariff_id").val(tariff_id);
				$("#tariff").html("("+tariff_name+")"+" - "+admissionType);
				diplayCard(admissionType);
				$("#item_name-1").focus();
			},
			 messages: {
		        noResults: '',
		        results: function() {}
			 }	
		});
	});
	itemAutoComplete("item_name-1");	//for initial autocomplete// initial autocomplete for item name
});	

	$(".item_name").focus(function(){
		if($("#person_id").val()=="" && $("#pharmacy_sales_bill_id").val() =="")
			{ 
			alert("Please Select Patient First.");
			$("#party_name").focus();
		}
	});

  function clearField(obj){
	if($.trim(obj.value.length)==0){
	$("#party_code").val("");
		$("#party_name").val("");
		$("#total_amount").html("0");
	}
}
  
  function deletRow(id){
  	var count = 0;
	$(".item_name").each(function(){
		count++;
	});
	if(count == 1){
		alert("Single row can't delete.");
		$("#remove-btn").css("display","none");
		return false;
	}
	$("#row"+id).remove();
	//getTotal(this);
	var sum = 0;
	count = 1;
	$('.value').each(function() { 
	    if(this.value!== undefined  && this.value != ''  ){
        	sum += parseFloat(this.value);	       
        }
		count++;			        				        
    });
	$("#total_amount_field").val((sum.toFixed(2)));
	$("#total_amount").html((sum.toFixed(2))); 
}
  
   function checkIsItemRemoved(obj){
	var fieldno = $(obj).attr('fieldNo') ;
	if($.trim(obj.value.length)==0){
			$("#item_name-"+fieldno).val("");
			$("#viewDetail"+fieldno).remove();
			$("#item_id"+fieldno).val("");
			$("#item_code"+fieldno).val("");
            $("#manufacturer"+fieldno).val("");
		 	$("#pack"+fieldno).val("");
			$("#mrp"+fieldno).val("");
			$("#rate"+fieldno).val("");
			$("#stockQty"+fieldno).val("");
			$("#batch_number"+fieldno).val("");
			$("#expiry_date"+fieldno).val("");
			$("#qty"+fieldno).val("");
			$("#value"+fieldno).val("");
			$("#free"+fieldno).val("");
	}
}
   
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
				 "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Invalid format"
                },
				"future":{
				 	"alertText": "Expiry Date should be future date."
				}
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

	$(document).keypress(('.quantity'),function(e) {
	 	var fieldNo = $(this).attr('fieldNo') ;
	    if (e.keyCode==40) {	//key down
	        $("#quantity_"+fieldNo).focus();
	    } 
	    if(e.keyCode==13){		//key enter
		    if($("#item_id"+fieldNo).val()!=0 || $("#item_id"+fieldNo).val()!=''){
	    		addFields();
		    }
	    } 
	    $( ".expiry_date" ).datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
		});
	});
	
  var number_of_field = 1;
  
	function addFields(){
		if($("#person_id").val()=="")
		{ 
			alert("Please Select Patient First.");
			$("#party_name").focus();
			return false;
		}
			number_of_field = number_of_field+1; 
		 //var number_of_field = parseInt($("#no_of_fields").val())+1; 
           var field = '';
		   	field += '<tr id="row'+number_of_field+'"><!--<td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>-->';
		    field += '<td align="center" valign="middle"><input name="item_id[]" class="itemId" fieldNo="'+number_of_field+'" id="item_id'+number_of_field+'" type="hidden" value=""/><input name="item_name[]" id="item_name-'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_name"  value="" style="width:100%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/> <!--<a href="#" id="viewDetail'+number_of_field+'" class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/DrmHope/img/icons/view-icon.png"></a>--></td>';
        	field += '<td style="text-align:center; padding:0px;"><table><tr><td><input name="qty[]" readonly="readonly" type="text" autocomplete="off" class="textBoxExpnd quantity validate[required,number]"  value="" id="qty_'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/> <input type="hidden" value="0" id="stockQtys'+number_of_field+'"></td><td><select name="itemType[]" fieldNo="'+number_of_field+'", id="itemType_'+number_of_field+'" class="itemType"></option><option value="Tab">MSU<!--<option value="Pack">Pack</option><option value="Unit">Unit</option>--></select> </td></tr></table></td>';
       		field += '<td valign="middle" style="text-align: center;"><input name="sQty[]" type="text" id="sQty'+number_of_field+'" value="" style="width: 100%;" fieldNo="1" readonly="true"/></td>'
       		field += '<td align="center" valign="middle"><input name="pack[]" id="pack'+number_of_field+'" type="text" class="textBoxExpnd "  value=""  style="width:100%;" readonly="true"/></td>';
			field += '<td align="center" valign="middle"><select name="data[pharmacyItemId][]" id="batch_number'+number_of_field+'" class="textBoxExpnd validate[required] batch_number" value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"></select></td>';
			"<?php $website = $this->Session->read('website.instance');
			if($website == "kanpur"){?>"
				field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd" value=""  style="width:80%;" autocomplete="off" readonly="true"/></td>';
			"<?php }else{?>"
				field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[required] expiry_date" value=""  style="width:80%;" autocomplete="off"/></td>';
			"<?php }?>"
		   	field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" fieldNo="'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] mrp" value="" id="mrp'+number_of_field+'" style="width:100%;" /></td>';
		   	field += '<td valign="middle" style="text-align:center;"><input name="rate[]"  fieldNo="'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] rate" value="" id="rate'+number_of_field+'" style="width:100%;" /></td>';
		   	"<?php if($website == "kanpur"){?>"
			field += '<td> <table width="100%" style="padding:0"> <tr> <td style="padding:0"><input name="discount[]" type="text" class="itemWiseDiscountAmount textBoxExpnd" id="itemWiseDiscountAmount'+number_of_field+'" readonly="readonly" fieldNo="'+number_of_field+'"  value=""  style="width:60%;"/><input name="itemWiseDiscount[]" type="hidden" class="itemWiseDiscount" id="itemWiseDiscount'+number_of_field+'" fieldNo="'+number_of_field+'" value=""/>%</td>	<td style="padding:0" id="displayDisc'+number_of_field+'"></td></tr></table></td>';
           	"<?php } else if($website == "vadodara"){ ?>"
           	field += '<td> <table width="100%" style="padding:0"> <tr> <td style="padding:0"><input name="discount[]" type="text" class="itemWiseDiscountAmount textBoxExpnd" id="itemWiseDiscountAmount'+number_of_field+'" readonly="readonly" fieldNo="'+number_of_field+'"  value=""/><input name="itemWiseDiscount[]" type="hidden" class="itemWiseDiscount" id="itemWiseDiscount'+number_of_field+'" fieldNo="'+number_of_field+'" value=""/></td> <!--<td style="padding:0" id="displayDisc'+number_of_field+'"></td>--></tr></table></td>';
           	"<?php } ?>"
           	field += '<td valign="middle" style="text-align:center;"><input name="return_tot_amount[]" type="text" class="textBoxExpnd  validate[required,number] value" id="value'+number_of_field+'" value=""  style="width:100%;"/></td>';

           	field += '<td valign="middle" style="text-align:center;"><input name="valueNet[]" type="text" class="textBoxExpnd  validate[required,number] valueNet" id="valueNet'+number_of_field+'" value=""  style="width:100%;"/></td>';
        	
			if(number_of_field>=1)
		   	field +='<td valign="middle" style="text-align:center;"> <a href="javascript:void(0);" id="delete-row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a></td>';
		   
		  	field +='</tr>';
		  $("#item-row").append(field);
		  $("#item_name-"+number_of_field).focus();
		  if (number_of_field == 1){
				$("#remove-btn").css("display","none");
			}else{
				$("#remove-btn").css("display","inline");
			}
		  itemAutoComplete("item_name-"+number_of_field);
      	/*$("#no_of_fields").val(number_of_field);
		$("#item-row").append(field);
			if (number_of_field == 1){
						$("#remove-btn").css("display","none");
					}else{
		$("#remove-btn").css("display","inline");
		}*/
}
	
function removeRow(){
	$('.item_code'+number_of_field+"formError").remove();
	$('.item_name'+number_of_field+"formError").remove();
	$('.batch_number'+number_of_field+"formError").remove();
 	$('.expiry_date'+number_of_field+"formError").remove();
	$('.qty'+number_of_field+"formError").remove();
	$('.value'+number_of_field+"formError").remove();
	$('.rate'+number_of_field+"formError").remove();
	$('.mrp'+number_of_field+"formError").remove();
	
	var count = 0;
	$(".item_name").each(function(){
		count++;
	});
	if(count == 1){
		alert("Single row can't delete.");
		$("#remove-btn").css("display","none");
		return false;
	}

		var sum = 0;
		count = 1;
		$('.value').each(function() { 
		    if(this.value!== undefined  && this.value != ''  ){
	        	sum += parseFloat(this.value);	       
	        }
			count++;			        				        
	    });
		$("#total_amount_field").val((sum.toFixed(2)));
		$("#total_amount").html((sum.toFixed(2))); 
	/*var sum = 0;
	$('.value').each(function() { 
	    if(this.value!== undefined  && this.value != ''  ){
        	sum += parseFloat(this.value);	       
        }
		count++;			        				        
    });*/
	//getTotal(this);
}

function itemAutoComplete(id){
	var patientId  = $("#person_id").val();
	var party_name = $("#party_name").val(); 

/*	$(".item_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "inventory_autocomplete_sales_return_item",'name',"inventory" =>true,"plugin"=>false)); ?>"+'?patient_id='+patientId,
		 minLength: 1,
		 select: function( event, ui ) {
			console.log(ui.item);
			
			loadDataFromRate(ui.item.id,id);
			
		 },
		 messages: {
	        noResults: '',
	        results: function() {}
		 }		
	});*/

	 	src  = "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_autocomplete_sales_return_item","name","inventory" => true,"plugin"=>false)); ?>" ;

	 /*	$(document).on('focus','.item_name',function(){ 
		 	var newId = $(".item_name :last").attr('id');
			$("#"+id).val("%"); 
			$("#"+id).autocomplete('enable');
			$("#"+id).autocomplete('search');
			//console.log($(".item_name :last").attr('id').val());
	 	});*/
		 	
	 	//$('.item_name :last').autocomplete({
	 	$('.item_name').autocomplete({
		source:	function(request, response) {
            $.ajax({
            	dataType: 'json',
                url: src, 
                data: {patientId:$("#person_id").val(),party_name:$("#party_name").val(),term: request.term},
                success: function(data) {
                    response(data);
                }
            });
        }, 
		select:function (event, ui) {			
			//selectedId = t.attr('id');
			selectedId = $(this).attr('id');
			loadDataFromRate(ui.item.id,selectedId);
		},
		 messages: {
	        noResults: '',
	        results: function() {}
		 }
		}); 
	}

	/* for auto populate the data */
function selectPatient(li,selectedId) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		$("#person_id").val(itemID);
	if(li.extra[1] == "lookup_name")
			$("#party_code").val(li.extra[0]);
		else
			$("#party_name").val(li.extra[0]);
}

 /* get the Item details*/
 function getItemDetail(itemId){
	 var res = '';
 $.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "view_item","inventory" => true,"plugin"=>false)); ?>",
		  async:false,
		  data: "item_id="+itemId,
		}).done(function( msg ) {
			res =  jQuery.parseJSON(msg);
	});
	return res;
 }
 
function selectItem(li,selectedId) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		var currentField = $("#"+selectedId);
		var fieldno = currentField.attr('fieldNo') ;
		$("#viewDetail"+fieldno).attr('href','view_item/'+itemID+'?popup=true');
		$("#viewDetail"+fieldno).css("visibility","visible");
		$("#stockQty"+fieldno).val(li.extra[2]);
		$("#viewDetail"+fieldno).fancybox({
				'width'				: '80%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		loadDataFromRate(itemID,selectedId);
}


$/*("#expiry_date1").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,
	yearRange: '1950',
	dateFormat:'<?php echo $this->General->GeneralDate("");?>'
});*/


$(".Add_more").click(function(){
	$(".expiry_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate("");?>'
	});
});


/* load the data from supplier master */
function loadDataFromRate(itemID,selectedId){ console.log(itemID);
	var flag = false; 
	$(".itemId").each(function(){
		if(itemID === $(this).val()){
			var fieldCount = $(this).attr('fieldNo');
			alert("This Item is already selected"); 
			$('#'+selectedId).val('');
			$('#'+selectedId).focus();
			flag = true;
			return false;
		}
	});
	if(flag == false){
	var patientId  = $("#person_id").val();
	var currentField = $("#"+selectedId);
	var fieldno = currentField.attr('fieldNo') ;
	var tariff = $("#tariff_id").val();
	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_fetch_rate_for_return_item",'item_id','name','true',"inventory" => true,"plugin"=>false)); ?>",
		  data: "item_id="+itemID+"&patient_id= "+patientId+"&tariff="+tariff,
		}).done(function( msg ) {
		 	var item = jQuery.parseJSON(msg); 		
		 	var qty = '';
			console.log(item.PharmacyItem);
		 	$("#pharmacySaleDiscountPer").val(item.PharmacyItem.pharmacy_sale_discount_percentage);
		 	$("#qty_"+fieldno).val(qty);
		 	$("#qty_"+fieldno).val(qty);
		 	$("#qty_"+fieldno).focus();
		 	$("#item_name-"+fieldno).val(item.PharmacyItem.name);
			$("#item_id"+fieldno).val(item.PharmacyItem.id);
			$("#item_code"+fieldno).val(item.PharmacyItem.item_code);
            $("#manufacturer"+fieldno).val(item.PharmacyItem.manufacturer);
            $("#pack"+fieldno).val(item.PharmacyItem.pack);
		 	$("#stockQty"+fieldno).val(item.PharmacyItem.stock);
		 	$("#sQty"+fieldno).val(item.PharmacyItem.totalSold); 

		 	//$("#itemWiseDiscount"+fieldno).val(item.PharmacyItem.itemDiscount); 
		 	$("#itemWiseDiscount"+fieldno).val(item.PharmacyItem.itemDiscount); 
		 	
		 //	$("#displayDisc"+fieldno).html(" ("+item.PharmacyItem.itemDiscount+"%)");
		 	batches= item.PharmacyItemRate;
			$("#batch_number"+fieldno+" option").remove();
			if(batches!=''){
				$.each(batches, function(index, value) { 
				    $("#batch_number"+fieldno).append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
					if(index==0){
						$("#expiry_date"+fieldno).val(value.expiry_date);
						$("#mrp"+fieldno).val(value.mrp);
						$("#vat"+fieldno).val(value.vat);
						$("#rate"+fieldno).val(value.sale_price);
		            }					
				});
			}
			$("#qty_"+fieldno).attr('readonly',false);
			$("#qty"+fieldno).focus();
		}); 
		selectedId='';
	}
}

	function getTotal(id){
		if($(id)!=""){
		var fieldno = $(id).attr('fieldNo') ;
		var soldQty = parseInt($("#sQty"+fieldno).val());
		var qty = parseInt($("#qty_"+fieldno).val()!=""?$("#qty_"+fieldno).val():0);
		var itemDiscout = parseFloat($("#itemWiseDiscount"+fieldno).val()!=""?$("#itemWiseDiscount"+fieldno).val():0);
		
        var price = ($("#rate"+fieldno).val()!="")?$("#rate"+fieldno).val():0.00;
        var qtyType = $("#itemType_"+fieldno).val();

        var discountSale = parseInt($("#pharmacySaleDiscountPer").val()!=''?$("#pharmacySaleDiscountPer").val():0);
      
		if($('#pack'+fieldno).val())
			var pack = parseInt($('#pack'+fieldno).val());  
		else 
			var pack = 1 ; 
			
        var vat = parseInt($('#vat'+fieldno).val()); 

        
       	if(!isNaN(price)){
       		
			if(price<=0){				
				price = parseFloat(($("#mrp"+fieldno).val()!="")?$("#mrp"+fieldno).val():0.00);
				
			}

			//*****BOF-Mahalaxmi for deduct discount amount********//
			var getPricePercentageDis=price*(discountSale/100);
			var DeductedPrice=price-getPricePercentageDis;
			
			if(qtyType == "Tab"){				
				var	sub_total = qty*price/pack;
				var pricePer=qty*DeductedPrice/pack;			
			}else{
				var	sub_total = qty*price;
				var pricePer=qty*DeductedPrice;			
			}
			
			var totalWithTax = sub_total;
			if(price != 0 || price !=''){
				$("#valueNet"+fieldno).val(pricePer.toFixed(2));
				$("#value"+fieldno).val(totalWithTax.toFixed(2));
			}
			
			//by Mahalaxmi to calculate discount from percentage
			//discountValue = qty * itemDiscout;
			//$("#itemWiseDiscountAmount"+fieldno).val(discountValue.toFixed(2));
			$("#itemWiseDiscountAmount"+fieldno).val(discountSale);
			var sum = 0 ; discAmt = 0;
			count = 1; inc = 0;
			$('.itemWiseDiscountAmount').each(function() { 
			    if(this.value!== undefined  && this.value != ''  ){
		        	discAmt += parseFloat(this.value);	  
		        	inc++;     
		        }
		    });
			
			$('.value').each(function() { 				
			  if(this.value!== undefined  && this.value != ''  ){					 			    
		        	sum += parseFloat(this.value);	       
		        }
				count++;			        				        
		    });

			var sumNet=0;
			$('.valueNet').each(function() { 				
			  if(this.value!== undefined  && this.value != ''  ){					   		    
				    sumNet += parseFloat(this.value);	       
		        }
				count++;			        				        
		    });
			var totalDiscount=sum-sumNet;

			var incCount = inc;
			$("#totalAmountDiscount").val(totalDiscount.toFixed(2));
		    $("#totalDiscount").val(totalDiscount.toFixed(2)); ///Mahalaxmi- adding Discount value
		    $("#total_discount_perc").val(discAmt.toFixed(2)); // Mrunal
		    $("#showTotalDiscount").html(totalDiscount.toFixed(2));///Mahalaxmi- adding Discount value
			$("#total_amount_field").val((sum.toFixed(2)));
			$("#total_amount").html((sum.toFixed())); 
			$("#showNetAmount").html(sumNet.toFixed(2));  ///Mahalaxmi- adding Discount value
			///$("#showNetAmount").html((sum - discAmt).toFixed());
        }
     }
	}


	  $(document).on('keyup',".quantity",function()
	  {
	  	if (/[^0-9\.]/g.test(this.value)){
	      	 this.value = this.value.replace(/[^0-9\.]/g,'');
	      }
	  	checkStockLimit(this);
	  	getTotal(this);
	  });

	  $(document).on('keyup',".mrp",function()
	  {
	  	if (/[^0-9\.]/g.test(this.value)){
	      	 this.value = this.value.replace(/[^0-9\.]/g,'');
	      }
	  	checkStockLimit(this);
	  	getTotal(this);
	  });

	  $(document).on('keyup',".rate",function()
	  {
	  	if (/[^0-9\.]/g.test(this.value)){
	      	 this.value = this.value.replace(/[^0-9\.]/g,'');
	      }
	  	checkStockLimit(this);
	  	getTotal(this);
	  });
	  //.mrp, .rate, #tax, #vat"
	  $(document).on('change',".itemType",function(){
		  checkStockLimit(this);
		  getTotal(this);
	  });

	    
	function checkStockLimit(id){
		if($(id)!=""){
			var fieldno = $(id).attr('fieldNo') ;
			var qty = parseInt($("#qty_"+fieldno).val());
	        var qtyType = $("#itemType_"+fieldno).val();
	    	var soldQty = parseInt($("#sQty"+fieldno).val());
	    	var pack = parseInt($('#pack'+fieldno).val());  
	    	if(qtyType != "Tab"){
				soldQty = Math.floor(soldQty/pack);
		    }
	        if(qty > soldQty){
	            alert("Return Quantity Is Greater Than Sold Quantity");
	            $("#qty_"+fieldno).val('');
	            $("#qty_"+fieldno).focus();
	            return false;
	        }
		}
	}

	
 $(".fancy").fancybox({
				'width'				: '80%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});


 $(document).on('change',".batch_number",function()
 {
 	var t = $(this);
 	var fieldno = t.attr('fieldno') ;
 	$.ajax({
 		type: "GET",
         url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_fetch_batch_for_item","inventory" => true,"plugin"=>false)); ?>",
         data: "itemRate="+$(this).val(),
         success: function(data){
 			var ItemDetail = jQuery.parseJSON(data);
 			//console.log(ItemDetail.PharmacyItemRate);	
 			$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
 			$("#vat"+fieldno).val(ItemDetail.PharmacyItemRate.vat);
         	$("#rate"+fieldno).val(ItemDetail.PharmacyItemRate.sale_price);
             $("#expiry_date"+fieldno).val(ItemDetail.PharmacyItemRate.expiry_date);
             var itemrateid=$('#batch_number'+fieldno).val();
             var itemID=$('#item_id'+fieldno).val();
 			var editUrl  = "<?php echo $this->Html->url(array('controller'=>'pharmacy','action'=>'edit_item_rate','inventory'=>false))?>";
 			$("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
 			getTotal(t);
 		}
 	});
 });

	$("#card_return").click(function(){
		if($(this).is(':checked')){
			$("#isCash").attr('checked',false);
			$("#cashAmount").val('');
		} 	
	});

	function checkIsRemoved(id){
		if(id.value == ''){
			$("#cardDisplay").hide();
			
		}
	}

	$("#isCash").click(function(){
		if($(this).is(':checked')){
			$("#card_return").attr('checked',false);
			var cashAmount = parseFloat($("#total_amount_field").val());
			$("#cashAmount").val(cashAmount);
		}else{
			$("#cashAmount").val('');
		}	
	});

	
	function diplayCard(admissionType){
		if(instance == "vadodara"){
			if(admissionType == "IPD"){
				$("#cardDisplay").show();
				$("#card_return").attr('checked',true);
			}else{
				$("#cardDisplay").show();
				$("#cashDisplay").attr('checked',false);
			}			
		}
	}

	$("#all_encounter").click(function(){
		if($(this).is(":checked")){
			$("#is_checked").val(1);
		}else{
			$("#is_checked").val(0);
		}
	});
 </script>
