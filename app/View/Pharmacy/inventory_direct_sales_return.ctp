<style>
.formErrorContent {
	width: 43px !important;
}
</style>


<?php
echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>

<div class="inner_title" >
<?php echo $this->element('pharmacy_menu');?>
	<h3>Direct Sales Return</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>

<div class="clr ht5"></div>
<?php echo $this->Form->create('InventoryPharmacySalesReturn',array('id'=>'InventoryPharmacySalesReturnInventorySalesReturnForm','onkeypress'=>"return event.keyCode != 13;"));?>
<table width='70%' cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><?php echo __('Patient Name');?><font color="red" style="font-weight: bold;">*</font>:</td>
		<td class="tdLabel2">
		<?php echo $this->Form->input('DirectReturn.patient_name',array('id'=>'patient','label'=>false,'div'=>false,'type'=>'text','autofocus'=>'autofocus','autocomplete'=>'off',
				'class' => ' validate[required] textBoxExpnd','tabindex'=>"1", 'onkeyup'=>'checkIsRemoved(this)', 'onkeyup'=>'clearField(this)','name'=>"DirectReturn[patient_name]"));
				echo $this->Form->hidden('DirectReturn.patient_id',array('id'=>'patient_id','name'=>"DirectReturn[patient_id]")); 
		?>
		</td>
		<td><?php echo __('Return Date')?><font color="red" style="font-weight: bold;">*</font>:</td>
		<td class="tdLabel2">
		<?php $currentDate = date('d/m/Y');
		echo $this->Form->input('DirectReturn.return_date',array('id'=>'return_date','label'=>false,'div'=>false,'type'=>'text','autofocus'=>'autofocus','autocomplete'=>'off',
					'class'=>'validate[required] textBoxExpnd','tabindex'=>'2','onkeyup'=>'checkIsRemoved(this)', 'onkeyup'=>'clearField(this)','name'=>"DirectReturn[return_date]",'value'=>$currentDate));
		?>
		</td>
		<td><?php echo __('Doctor Name')?><font color="red" style="font-weight: bold;">*</font>:</td>
		<td>
		<?php 
			echo $this->Form->input('DirectReturn.doctor_name',array('id'=>'doctor_name','label'=>false,'div'=>false,'type'=>'text','autofocus'=>'autofocus','autocomplete'=>'off',
				'class'=>'validate[required] textBoxExpnd','tabindex'=>'3','onkeyup'=>'checkIsRemoved(this)', 'onkeyup'=>'clearField(this)','name'=>"DirectReturn[doctor_name]"));
		?>
		</td>
		<input name="pharmacy_sales_bill_id" id="pharmacy_sales_bill_id" value="" type="hidden" /> 
		
	</tr>
</table>
<div class="clr ht5"></div>


<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<tr><td colspan="2"><font color="#ff343"><i>(MSU = Minimum Saleable Unit)</i></font></td></tr>
	<tr>
		
		<th width="80" align="center" valign="top"
			style="text-align: center;">Item Name<font color="red">*</font></th>
		<th width="100" valign="top" style="text-align: center;">Quantity<font color="red">*</font></th>
	
		<th width="50" valign="top" style="text-align: center;">Pack</th>
		<th width="100" align="center" valign="top" style="text-align: center;">Batch
			No.<font color="red">*</font></th>
		<th width="150" align="center" valign="top" style="text-align: center;">Expiry Date<font color="red">*</font></th>
		<th width="50" valign="top" style="text-align: center;">MRP<font color="red">*</font></th>
		<th width="50" valign="top" style="text-align: center;">Price<font color="red">*</font></th>
		<th width="40" valign="top" style="text-align: center;">Discount</th>
		<th width="60" valign="top" style="text-align: center;">Amount<font color="red">*</font></th>
		<th width="10" valign="top" style="text-align: center;">#</th>
	</tr>
<?php $cnt=1;?>
	
<input type="hidden" value="<?php echo $cnt;?>" id="no_of_fields" />
	<tr id="row1">
		
		<td align="center" valign="middle" width="185">
		<input name="item_id[]" id="item_id1" type="hidden" value="" class="itemId" fieldNo="1"/>
		
		<input	name="item_name[]" type="text"
			class="textBoxExpnd validate[required] item_name" id="item_name-1"
			value="" style="width: 100%;" fieldNo="1"
			onkeyup="checkIsItemRemoved(this)" /> 
		
		
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
		
		<td align="center" valign="middle"><input name="pack[]" type="text"
			class="textBoxExpnd " id="pack1"  value=""
			style="width: 100%;" readonly="true" /></td>
		<td valign="middle" style="text-align: center;" >
			<?php echo $this->Form->input('',array('type'=>'select','options'=>'','class'=>'textBoxExpnd validate[required] batch_number','id'=>'batch_number1', 'style'=>"width: 100%",'autocomplete'=>"off" ,"tabindex"=>"9","fieldNo"=>"1",'label'=>false,'name'=>"data[pharmacyItemId][]")); ?>
		</td>
		
		<td valign="middle" style="text-align: center;"><input
				name="expiry_date[]" type="text"
				class="textBoxExpnd"
				id="expiry_date1" value="" style="width: 80%;"
				autocomplete="off" readonly="true" /></td>
		
		<td valign="middle" style="text-align: center;"><input name="mrp[]"
			type="text" class="textBoxExpnd validate[required,number] mrp" id="mrp1" fieldNo="1"
			value="" style="width: 100%;" readonly="readonly"  /></td>
			

		
		<td valign="middle" style="text-align: center;"><input name="rate[]"
			type="text" class="textBoxExpnd validate[required,number] rate" id="rate1" fieldNo="1"
			 value="" style="width: 100%;"  readonly="readonly" />
		</td>
		
		<?php if(strtolower($this->Session->read('website.instance'))!="hope") { ?>
		<td>
			<table width="100%" style="padding:0">
				<tr>
					<td style="padding:0">
						<input name="discount[]" type="text" class="itemWiseDiscountAmount textBoxExpnd" id="itemWiseDiscountAmount1"  fieldNo="1" placeholder="Percent" value=""/>
						<input name="itemWiseDiscount[]" type="hidden" class="itemWiseDiscount" id="itemWiseDiscount1" fieldNo="1" value=""/>
					</td>
					<td>
					%
					</td>
				
				</tr>
			</table>
		</td>
		<?php } ?>
		
		<td valign="middle" style="text-align: center;"><input name="value[]"
			type="text" class="textBoxExpnd validate[required,number] value"
			id="value1"  value="" style="width: 100%;" /></td>
		<td valign="middle" style="text-align: center;"><a href="javascript:void(0);"
			id="delete-row" onclick="deletRow('1');">
			<?php echo $this->Html->image('icons/cross.png',array('title'=>'delete row','alt'=>'delete row')); ?></a></td>
	</tr>

</table>

<div class="clr ht5"></div>
<div align="right">
	<input name="" type="button" value="Add More" class="blueBtn Add_more"
		onclick="addFields()" />
	
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><?php echo __("Payment Mode");?><font color="red" >*</font></td>
		<td> <?php 
		 		echo $this->Form->input('InventoryPharmacySalesReturn.payment_mode', array('class' => 'validate[required]','style'=>'width:141px;', 'type'=>'select',
   					'div' => false,'label' => false,'autocomplete'=>'off','options'=>$mode_of_payment,$disabled,'value'=>"Cash",'id' => 'payment_mode')); ?> 
   		</td>
   	</tr>
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

		<input name="submit" type="submit" value="Submit"
		class="blueBtn"  id="submitButton" />

	<?php echo $this->Form->end();?>
</div>

<?php 				
	if(isset($this->params->query['print']) && !empty($_GET['id'])){ 
		echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'Pharmacy','action'=>'inventory_print_view','DirectSalesReturn',$_GET['id']))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
	}
?>
	
<script>
/********** Validation Code *********/
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
<script>
	// validation function
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
/********** END Of Validation Code ******************/
 
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

	$("#return_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
	});

	
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
       		field += '<td align="center" valign="middle"><input name="pack[]" id="pack'+number_of_field+'" type="text" class="textBoxExpnd "  value=""  style="width:100%;" readonly="true"/></td>';
			field += '<td align="center" valign="middle"><select name="data[pharmacyItemId][]" id="batch_number'+number_of_field+'" class="textBoxExpnd validate[required] batch_number" value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"></select></td>';
			
			field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd" value=""  style="width:80%;" autocomplete="off" readonly="true"/></td>';
			field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" fieldNo="'+number_of_field+'" readonly="readonly" type="text" class="textBoxExpnd validate[required,number] mrp" value="" id="mrp'+number_of_field+'" style="width:100%;" /></td>';
		   	field += '<td valign="middle" style="text-align:center;"><input name="rate[]"  fieldNo="'+number_of_field+'"  readonly="readonly" type="text" class="textBoxExpnd validate[required,number] rate" value="" id="rate'+number_of_field+'" style="width:100%;" /></td>';
		   	
			field += '<td> <table width="100%" style="padding:0"> <tr> <td style="padding:0"><input name="discount[]" type="text" class="itemWiseDiscountAmount textBoxExpnd" id="itemWiseDiscountAmount'+number_of_field+'"  fieldNo="'+number_of_field+'" placeholder="Percent"  value=""/><input name="itemWiseDiscount[]" type="hidden" class="itemWiseDiscount" id="itemWiseDiscount'+number_of_field+'" fieldNo="'+number_of_field+'" value=""/></td>	<td>%</td></tr></table></td>';
           	field += '<td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd  validate[required,number] value" id="value'+number_of_field+'" value=""  style="width:100%;"/></td>';

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
      	
}

//for first initialization
itemAutoComplete("item_name-1");

function itemAutoComplete(id){	
	$(".item_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "autocomplete_item",'name',"inventory" =>true,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			console.log(ui.item);
			var selectedId = ($(this).attr('id'));
			loadDataFromRate(ui.item.id,selectedId);
			
		 },
		 messages: {
	        noResults: '',
	        results: function() {}
		 }		
	});

	$( ".expiry_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
	});
	
	
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
function loadDataFromRate(itemID,selectedId){ 
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
		 	console.log(item);
		 	var qty = '';
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
		 	
		 	$("#displayDisc"+fieldno).html(" ("+item.PharmacyItem.itemDiscount+"%)");
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

$(document).on('keyup',".itemWiseDiscountAmount",function()
{
	getTotal(this);
});

	function getTotal(id){
		if($(id)!=""){
		var fieldno = $(id).attr('fieldNo') ;
		var soldQty = parseInt($("#sQty"+fieldno).val());
		var qty = parseInt($("#qty_"+fieldno).val()!=""?$("#qty_"+fieldno).val():0);
		var discAmount = $('#itemWiseDiscountAmount'+fieldno).val()!=""?$('#itemWiseDiscountAmount'+fieldno).val():0; 
		
        var price = ($("#rate"+fieldno).val()!="")?$("#rate"+fieldno).val():0.00;
        var qtyType = $("#itemType_"+fieldno).val();
		if($('#pack'+fieldno).val())
			var pack = parseInt($('#pack'+fieldno).val());  
		else 
			var pack = 1 ; 
			
        var vat = parseInt($('#vat'+fieldno).val()); 
        
       	if(!isNaN(price)){ 
			if(price<=0){
				price = parseFloat(($("#mrp"+fieldno).val()!="")?$("#mrp"+fieldno).val():0.00);
			}
			 
			if(qtyType == "Tab"){				
				var	sub_total = qty*price/pack;
			}else{
				var	sub_total = qty*price;
			}
			var totalWithTax = sub_total;
			if(price != 0 || price !=''){
				$("#value"+fieldno).val(totalWithTax.toFixed(2));
			}

			//by Mrunal to calculate discount from percentage
			discountValue = sub_total * (discAmount/100);
			$("#itemWiseDiscount"+fieldno).val(discountValue.toFixed(2));
			
			var sum = 0 ; discAmt = 0; discInPercent = 0;
			count = 1;
			$('.itemWiseDiscount').each(function() { 
			    if(this.value!== undefined  && this.value != ''  ){
		        	discAmt += parseFloat(this.value);
		        	 	       
		        }
		    });

			$('.itemWiseDiscountAmount').each(function(){
				if(this.value!== undefined  && this.value != ''  ){
					discInPercent += parseFloat(this.value);
		        }
			});
			
			$('.value').each(function() { 
			    if(this.value!== undefined  && this.value != ''  ){
		        	sum += parseFloat(this.value);	       
		        }
				count++;			        				        
		    });
			
			var discountPercentage = (discAmt * 100)/sum;
				
		    $("#totalDiscount").val(discountPercentage.toFixed());
		    $("#showTotalDiscount").html(discAmt.toFixed(2));
			$("#total_amount_field").val((sum.toFixed(2)));
			$("#total_amount").html((sum.toFixed(2))); 
			$("#showNetAmount").html((sum - discAmt).toFixed());
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

	
 </script>
