<style>
.rightSpace{
	padding-right: 40px;
}
.inner_title{
	padding-bottom: 0px;
}
	.blue-row{
		background-color:#D9D9D9;
	}
	.ho:hover{
		background-color:#C1BA7C;
		}
</style>
<?php 
echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>
<script>
	jQuery(document).ready(function(){
		jQuery("#PharmacyItem").validationEngine();
	});

</script>
<?php 

//echo $this->Html->script('jquery.autocomplete');
//echo $this->Html->css('jquery.autocomplete.css');
if(!empty($errors)) {
?>
 
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center" style="color: red">
	<tr>
		<td colspan="2" align="center"><?php
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>

<?php $doseForm = array('Pack'=>'Pack','Inj'=>'Inj','Vial'=>'vial','Syrup'=>'Syrup','Syringe'=>'Syringe'); ?>
<div class="inner_title">

<?php if($flagForBack!=1){?>
	<?php echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy')); ?>
<?php }?>
	<h3>
		&nbsp;
		<?php echo __('Pharmacy Management - Add Item', true); ?>
	</h3>
	<!-- to open fancy box without back btn -->
	<?php if($flagForBack!=1){?>
	<span style="padding-right: 40px;padding-top: 10px;"> <?php
	echo $this->Html->link(__('Back'), array('action' => 'item_list','list' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
	<?php } ?>
	<!-- end -->
	<div class="clr ht5"></div>
</div>

<div class="clr ht5"></div>
<?php echo $this->Form->create('PharmacyItem',array('id'=>"PharmacyItem",'onkeypress'=>"return event.keyCode != 13;"));
echo $this->Form->input('',array('name'=>'PharmacyItem[id]','type'=>'hidden','id'=>'itemId'));
echo $this->Form->input('',array('name'=>'PharmacyItem[stock]','type'=>'hidden','id'=>'stock'));
?>
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">

	<tr>
		<td width="250"></td>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Item Name<font color="red">*</font></td>
		<td width="250"><input type="text" name="PharmacyItem[name]" id="name"	class="textBoxExpnd item_name validate[required]" tabindex="1" /></td>
		<td width="">&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Item Code</td>
		<td><input type="text" name="PharmacyItem[item_code]" id="item_code" class="textBoxExpnd item_code" tabindex="7" /></td>
		<td width="250"></td>
	</tr>

	
	<tr>
		<td width="250"></td>
		<td class="tdLabel" id="boxSpace" >Pack<font color="red">*</font></td>
		<td><table><tr><td width="10%"><input type="text" name="PharmacyItem[pack]" id="pack" class="textBoxExpnd validate[required] onlyNumber" tabindex="3" style="width: 90%;"/></td>
		<td width="30%">
		<?php
			echo $this->Form->input('PharmacyItem.doseForm',array('type'=>'select','autocomplete'=>"off",'label'=>false,'options'=>$doseForm,'style'=>"width:56%;"));
		 ?>
		</td></tr></table></td>

		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Minimum</td>
		<td><input type="text" name="PharmacyItem[minimum]" id="minimum" class="textBoxExpnd onlyNumber" tabindex="4" /></td>
		<td width="250"></td>
	</tr>
	<tr>
		<td width="250"></td>
		<td valign="middle" class="tdLabel" id="boxSpace">Manufacturer</td>
		<td><input type="text" name="PharmacyItem[manufacturer]" id="manufacturer" class="textBoxExpnd manufacturer" tabindex="5" />
		<?php echo $this->Form->hidden('manufacturer_id',array('id'=>'manufacturer_id','name'=>"PharmacyItem[manufacturer_id]")); 
			  echo $this->Html->link($this->Html->image('icons/plus_6.png',array('title'=>'Add Manufacturer','alt'=>'Add Manufacturer')), 'javascript:void(0)', array('escape' => false,'onclick'=>"getAddManufacturer()"));
			?>
		</td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Maximum</td>
		<td><input type="text" name="PharmacyItem[maximum]" id="maximum" class="textBoxExpnd onlyNumber" tabindex="6" /></td>
		<td width="250"></td>
	</tr>
	<!--<tr>
		<td width="250"></td>
		<td width="100" class="tdLabel" id="boxSpace">Date</td>
		<td width="250">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width=""><input name="PharmacyItem[date]" type="text" class="textBoxExpnd" id="date" tabindex="2" value=""	style="width: 58%" />
					</td>
				</tr>
			</table>
		</td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Supplier</td>
		<td><input type="text" name="PharmacyItem[supplier_name]" id="search_supplier"
			class="textBoxExpnd" tabindex="10" />
			<?php echo $this->Form->hidden('',array('id'=>'supplier_id','name'=>"PharmacyItem[supplier_id]",'value'=>'')); 
			 
			echo $this->Html->link($this->Html->image('icons/plus_6.png',
					array('title'=>'Add Supplier','alt'=>'Add Supplier')), 'javascript:void(0)', array('escape' => false,'onclick'=>"getAddSupplier()"));
			?></td>
		<td width="250"></td>
		<!--  <td class="tdLabel" id="boxSpace">Shelf</td>
		<td><input type="text" name="PharmacyItem[shelf]" id="shelf"
				class="textBoxExpnd" tabindex="8" />
		</td>
		<td width="250"></td>-->
	</tr>
	<tr>
		<td width="250"></td>
		<td valign="middle" class="tdLabel" id="boxSpace">Generic</td>
		<td><input type="text" name="PharmacyItem[generic]" id="generic"
			class="textBoxExpnd generic" tabindex="9" /></td>
		<td width="250"></td>
		<td valign="middle" class="tdLabel" id="boxSpace">Expensive</td>
		<td><?php 
				echo $this->Form->input('PharmacyItem.expensive_product', array('type' => 'checkbox','class' => '','label' => false,'legend' => false));
			?>	
		</td>
		
	</tr>
	<tr>
		<td width="250"></td>
		<td valign="middle" class="tdLabel" id="boxSpace">
			Reorder Level:</td>
		<td>
			<?php echo $this->Form->input('',array('type'=>'text','class'=>'textBoxExpnd','id'=>'reorder_level','class'=>'vatClass' ,'autocomplete'=>"off",'label'=>false,'name'=>"data[PharmacyItem][reorder_level]")); ?>
		</td>
		<td width="250"></td>
		<td valign="middle" class="tdLabel" id="boxSpace">Profit Percent</td>
		<td><input type="text" name="PharmacyItem[profit_percentage]" id="profit_percentage"
			class="textBoxExpnd" tabindex="13" /></td>
		<td>%</td> 
		
	</tr>
	<tr>
		<?php if(strtolower($websiteConfig['instance']) == 'kanpur'){ ?>
		<td width="250"></td>
		<td valign="middle" class="tdLabel" id="boxSpace">Vat of Class:</td>
		<td>
			<?php echo $this->Form->input('',array('type'=>'select','class'=>'textBoxExpnd','id'=>'vat_of_class','calss'=>'vatClass','empty'=>'Select Vat','autocomplete'=>"off",'label'=>false,'name'=>"data[PharmacyItem][vat_class_id]",'options'=>$vatAll)); ?>
		</td>
		<?php } ?>
		<td width="250"></td>
		<td valign="middle" class="tdLabel" id="boxSpace">
			 </td>
		<td>
		</td>
	</tr>
	
	<tr>
	<td width="250"></td>
	<td valign="middle" class="tdLabel" id="boxSpace">Implant</td> <!-- added by mrunal - as per the Murali sir Requirement -->
	<td><?php 
			echo $this->Form->input('PharmacyItem.is_implant', array('type' => 'checkbox','class' => '','label' => false,'legend' => false));
		?>
	</td>
	</tr>
</table>
</br>

<table>
	<tr>
		<td>
			<?php echo $this->Html->link(__('Add Item Rate'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'addItemRateButton')); ?>
		</td>
	</tr>
</table>


<div id="itemRateTable" style="display:none;">
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="table_format" id="item-row">
	<tr class="row_title">
		<td class="table_cell" valign="top" style="text-align: center;">Batch Number<font color="red">*</font></td>
		<td class="table_cell" valign="top" style="text-align: center;">Expiry Date<font color="red">*</font></td>
		<td class="table_cell" valign="top" style="text-align: center;">Purchase Price<font color="red">*</font></td>
		<td class="table_cell" valign="top" style="text-align: center;">MRP<font color="red">*</font></td>
		<td class="table_cell" valign="top" style="text-align: center;">Selling Price<font color="red">*</font></td>
		<?php if($websiteConfig['instance'] == 'kanpur'){ ?>
		<td class="table_cell" valign="top" style="text-align: center;">Vat Of Class</td>
		<?php }?>
		<td class="table_cell" valign="top" style="text-align: center;">Stock(MSU)<font color="red">*</font></td>
		<td class="table_cell" valign="top" style="text-align: center;">Action</td>
	</tr>

	<input type="hidden" value="1" id="no_of_fields" />
	<tr id="row1" class="row_gray ho">
		<td align="left" valign="middle"><?php echo $this->Form->input('',array('div'=>false,'label'=>false,'type'=>'text','fieldNo'=>"1",'autocomplete'=>"off",'name'=>"data[PharmacyItemRate][1][batch_number]",'class'=>"textBoxExpnd batch_number validate[required]",'id'=>'batch-number_1','placeholder'=>"Batch No"));?></td>
		<td align="left" valign="middle"><?php echo $this->Form->input('',array('div'=>false,'label'=>false,'type'=>'text','fieldNo'=>"1",'autocomplete'=>"off",'name'=>"data[PharmacyItemRate][1][expiry_date]",'class'=>"textBoxExpnd expiry_date validate[required]",'id'=>'expiryDate_1'));?></td>
		<td align="left" valign="middle"><?php echo $this->Form->input('',array('div'=>false,'label'=>false,'type'=>'text','fieldNo'=>"1",'autocomplete'=>"off",'name'=>"data[PharmacyItemRate][1][purchase_price]",'class'=>"textBoxExpnd purchase_price validate[required]",'id'=>'purchasePrice_1','placeholder'=>"Purchase Price"));?></td>
		<td align="left" valign="middle"><?php echo $this->Form->input('',array('div'=>false,'label'=>false,'type'=>'text','fieldNo'=>"1",'autocomplete'=>"off",'name'=>"data[PharmacyItemRate][1][mrp]",'class'=>"textBoxExpnd mrp validate[required]",'id'=>'mrp_1','placeholder'=>"MRP"));?></td>
		<td align="left" valign="middle"><?php echo $this->Form->input('',array('div'=>false,'label'=>false,'type'=>'text','fieldNo'=>"1",'autocomplete'=>"off",'name'=>"data[PharmacyItemRate][1][sale_price]",'class'=>"textBoxExpnd selling_price validate[required]",'id'=>'sellingPrice_1','placeholder'=>"Selling Price"));?></td>
		<?php if($websiteConfig['instance'] == 'kanpur'){ ?>
		<td align="left" valign="middle"><?php echo $this->Form->input('',array('div'=>false,'label'=>false,'type'=>'select','fieldNo'=>"1",'autocomplete'=>"off",'name'=>"data[PharmacyItemRate][1][vat_class_id]",'class'=>"textBoxExpnd vatClass",'id'=>'vatClass_1','empty'=>'Select Vat','options'=>$vatAll));?></td>
		<?php }?>
		<td align="left" valign="middle"><?php echo $this->Form->input('',array('div'=>false,'label'=>false,'type'=>'text','fieldNo'=>"1",'autocomplete'=>"off",'name'=>"data[PharmacyItemRate][1][stock]",'class'=>"textBoxExpnd stock validate[required]",'id'=>'stock_1','placeholder'=>"Stock"));?></td>
		<td align="left" valign="middle"><a href="javascript:void(0);" id="delete row" onclick="deletRow('1');"><?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?> </a></td>
	</tr>
</table>

</br>
<table>
	<tr>
		<td>
			<?php echo $this->Html->link(__('Add More'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'addMore','onclick'=>"addFields()")); ?>
		</td>
	</tr>
</table>
</div>
<!-- billing activity form end here -->
<div style="padding-right: 40px;"
	class="btns subClose">
	<!--  <input name="" type="button" value="Print" class="blueBtn" tabindex="11"/>-->
	<input  name="" type="submit" value="Submit" class="blueBtn "
		tabindex="11" />

</div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>


<!-- Right Part Template ends here -->
</td>
</table>

<script>

var opt = '';
var optValue = '';
var instance = "<?php echo $websiteConfig['instance'];?>";
//TO CLOSE ADD SUPPLIER WINDOW - BY MRUNAL
$(document).ready(function(){	
	
	optValue = $.parseJSON('<?php echo ($dataValue); ?>');
	opt = $.parseJSON('<?php echo ($vatAllData); ?>');
	
	//alert('<?php //echo $setFlash ?>');
	if('<?php echo $setFlash ?>' == '1'){
	//alert("hello");
	parent.$.fancybox.close();
	
	}

	$( ".expiry_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		minDate:new Date(),			 
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
	    
	});
});
//EOC

$( "#date" ).datepicker({
			showOn: "both",
			buttonImage: "../../img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
		});


(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "!@#$%^&*()+=-[]\\\';,./{}|\":<>?",
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
                    "alertText": "* Invalid name address"
                },
				 "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Invalid phone number"
                },
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

/*$("#search_supplier").autocomplete("<?php //echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name","null","null","no", "admin" => false,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			width:20, 
			onItemSelect:function (data1)  { 
				
			$("#supplier_id").val(data1.extra[0]);
			
			},
			autoFill:true,

		}
	);*/

$('#search_supplier').autocomplete({	
	   
	 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name","null","null", "admin" => false,"plugin"=>false)); ?>",
  	 minLength: 1,
  	
	select: function( event, ui ) {
		
		var supply_id = ui.item.id;
		$("#supplier_id").val(supply_id);
		//alert(supply_id) ;
		
	},

	// apply below for avoiding messages
messages:{
	noResults: '',
	results: function() {}
	} 
});


$('#manufacturer').autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","ManufacturerCompany","name",'null',"no",'no','is_deleted=0',"admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 select: function( event, ui ) {
		 $('#manufacturer_id').val(ui.item.id); 
	 },
	 messages: {
	        noResults: '',
	        results: function() {}
	 }
});


$('#name').autocomplete({
	source:"<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>",
	selectFirst: true,
	valueSelected:true,
	loadId : 'name,itemId',
	 select: function( event, ui ) {
		 $("#item_code").val(ui.item.item_code);
		 $("#itemId").val(ui.item.id);
		$.ajax({
			  type: "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item","inventory" => true,"plugin"=>false)); ?>",
			  data: "item_id="+$("#itemId").val(),
			}).done(function( msg ) {
				var ItemDetail = jQuery.parseJSON(msg);
				console.log(ItemDetail);
				$("#date").val(ItemDetail.PharmacyItem.date);
            	$("#pack").val(ItemDetail.PharmacyItem.pack);
            	$("#minimum").val(ItemDetail.PharmacyItem.minimum);
            	$("#maximum").val(ItemDetail.PharmacyItem.maximum);
            	$("#shelf").val(ItemDetail.PharmacyItem.shelf);
            	$("#manufacturer").val(ItemDetail.PharmacyItem.manufacturer);
            	$("#item_code").val(ItemDetail.PharmacyItem.item_code);
            	$("#generic").val(ItemDetail.PharmacyItem.generic);
            	$("#stock").val(ItemDetail.PharmacyItem.stock);
            	$("#search_supplier").val(ItemDetail.PharmacyItem.supplier_name);
		});
	},

	messages:{
		noResults: '',
		results: function() {}
		}
	});

/***
 * to add rates of particular item on add item window only
 * By Mrunal
 */
function getAddItemRate(){
	$.fancybox({
		'width' : '80%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' :'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>"pharmacy", "action" => "inventory_item_rate_master","inventory" => true,'admin'=>false,'?'=>array('flag'=>1))); ?>"

	});
}

/* to add Supplier */
function getAddSupplier(){
	$.fancybox({
		'width' : '80%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' :'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>"Store", "action" => "add_supplier",'inventory'=>false,'?'=>array('flag'=>1))); ?>"

	});
}

/* to add manufacturer*/
function getAddManufacturer(){
	$.fancybox({
		'width' : '80%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' :'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>"Store", "action" => "manufacturingCompany",'inventory'=>false,'?'=>array('flag'=>1))); ?>"
	});
	
}

$("#addItemRateButton").click(function(){
	$("#itemRateTable").show();	
});

function addFields(){

	//console.log(vats);
	var number_of_field = parseInt($("#no_of_fields").val())+1;
	 if(number_of_field %2 != 0){
		   clas = "row_gray";
	   }else{
		   clas = "blue-row";
	   }
	   var field = '';
	   field += '<tr id="row'+number_of_field+'" class="ho '+clas+'">';
	   field += '<td><input name="data[PharmacyItemRate]['+number_of_field+'][batch_number]" id="batch-number_'+number_of_field+'" type="text" autocomplete="off" class="textBoxExpnd  batch_number validate[required]" value="" fieldNo="'+number_of_field+'" placeholder="Batch No"/></td>';
	   field += '<td><input name="data[PharmacyItemRate]['+number_of_field+'][expiry_date]" id="expiryDate_'+number_of_field+'" type="text" autocomplete="off" class="textBoxExpnd  expiry_date validate[required]" value="" fieldNo="'+number_of_field+'" /></td>';
	   field += '<td><input name="data[PharmacyItemRate]['+number_of_field+'][purchase_price]" id="purchasePrice_'+number_of_field+'" type="text" autocomplete="off" class="textBoxExpnd  purchase_price validate[required]" value="" fieldNo="'+number_of_field+'" placeholder="Purchase Price"/></td>';
	   field += '<td><input name="data[PharmacyItemRate]['+number_of_field+'][mrp]" id="mrp_'+number_of_field+'" type="text" autocomplete="off" class="textBoxExpnd  mrp validate[required]" value="" fieldNo="'+number_of_field+'" placeholder="MRP"/></td>';
	   field += '<td><input name="data[PharmacyItemRate]['+number_of_field+'][sale_price]" id="sellingPrice_'+number_of_field+'" type="text" autocomplete="off" class="textBoxExpnd  selling_price validate[required]" value="" fieldNo="'+number_of_field+'" placeholder="Selling Price"/></td>';
	   if(instance == "kanpur"){
			field += '<td valign="middle" style="text-align:center;"><select name="data[PharmacyItemRate]['+number_of_field+'][vat_class_id]" class="textBoxExpnd vatDisplay" id="vatDisplay_'+number_of_field+'" style="width:100%;" autocomplete="off"></select></td>';
		}
	   //field += '<td><select name="data[PharmacyItemRate]['+number_of_field+'][vat_of_class]" id="vatClass_'+number_of_field+'" autocomplete="off" class="textBoxExpnd  vatClass validate[required]" value="" fieldNo="'+number_of_field+'"></select></td>';
	   field += '<td><input name="data[PharmacyItemRate]['+number_of_field+'][stock]" id="stock_'+number_of_field+'" type="text" autocomplete="off" class="textBoxExpnd  stock validate[required]" value="" fieldNo="'+number_of_field+'" placeholder="Stock"/></td>';
	   field +='<td valign="middle" style="text-align:center;"> <a href="javascript:void(0);" id="delete row" onclick="deletRow('+number_of_field+');"> <?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a></td>';
       field +='</tr>';
	$("#no_of_fields").val(number_of_field);
	$("#item-row").append(field);
	$("#batch-number_"+number_of_field).focus();
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}else{
		$("#remove-btn").css("display","inline");
	}
	
	$("#vatDisplay_"+number_of_field).append( new Option('Select Vat' , '') );
	console.log(opt);
	$.each(opt, function (key, value) {
		$("#vatDisplay_"+number_of_field).append("<option value='"+key+"'>"+value+"</option>" );
	});
}

function deletRow(id){ 
	$("#row"+id).remove(); 
}

//any key press up/down
$(document).on('keypress','.mrp, .batch_number, .stock, .purchase_price, .selling_price',function(e) {
	id = $(this).attr('id');
	var count = id.split("_");
    var fieldNominus = parseInt(count[1])-1;
    var fieldNoplus = parseInt(count[1])+1;
    if (e.keyCode==40) {	//down
        $("#"+count[0]+"_"+fieldNoplus).focus();
    }
    if (e.keyCode==38) {	//up
        $("#"+count[0]+"_"+fieldNominus).focus();
    } 
    if(e.keyCode==13){		//enter
	    if($("#batch-number_"+count[1]).val()!=0 || $("#batch-number_"+count[1]).val()!=''){
    		$('#addMore').trigger('click');
    		//addFields();
    		//addFields();
	    }
    } 
    $( ".expiry_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		minDate:new Date(),			 
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
	    
	});
});

$(document).on('blur',".batch_number", function() {
	id = $(this).attr('id');
	var count = id.split("_");
    var valueOfChangedInput = $(this).val();
    var timeRepeated = 0;
    $(".batch_number").each(function () {
        if ($(this).val() == valueOfChangedInput && $(this).val() != "") {
            timeRepeated++; 
        }
    });
    if(timeRepeated > 1) {
        alert("Duplicate batch number found");
        $("#batch-number_"+count[1]).val('');
        $("#batch-number_"+count[1]).focus();
    }
});

$("#addMore").click(function()
{
	$( ".expiry_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		minDate:new Date(),			 
		dateFormat:'<?php echo $this->General->GeneralDate("");?>', 
	});
});

$(document).on('input','.mrp, .purchase_price, .selling_price',function(){
	if (/[^0-9\.]/g.test(this.value))
    {
    	this.value = this.value.replace(/[^0-9\.]/g,'');
    }
    if(this.value.split('.').length>2) 
		this.value =this.value.replace(/\.+$/,"");

});

$(document).on('keyup',".stock",function() {
	if (/[^0-9]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9]/g,'');
    }
});

$(document).on('input',".batch_number",function() {
	if (/[^0-9a-zA-Z\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9a-zA-Z\.]/g,'');
    }
    $(this).val($(this).val().toUpperCase());
});

$(document).on('input',"#profit_percentage",function() {
	if (/[^A-z\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^A-z\.]/g,'');
    }
    if($("#profit_percentage").val() > 100){
		alert("Please enter valid percentage");
		$("#profit_percentage").val('');
		$("#profit_percentage").focus()
    }
});

$(document).on('input',".onlyNumber",function() {
	if (/[^0-9]/g.test(this.value))
    {
    	this.value = this.value.replace(/[^0-9]/g,'');
    }
	if (this.value.length > 5) this.value = this.value.slice(0,5);
});

$(document).on('input',".item_code,.generic,.item_name",function() {
	if (/[^0-9a-zA-Z \.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9a-zA-Z%\.]/g,'');
    }
});
$(document).on('input',".manufacturer",function() {
	if (/[^a-zA-Z\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^a-zA-Z\.]/g,'');
    }
});
$(document).on('input',"#pack",function(){
	if (/[^0-9]/g.test(this.value)){this.value = this.value.replace(/[^0-9]/g,'');}
	if($("#pack").val() == 0){
		$("#pack").val('');
	}
});

/**
 * End Of Code
 */
</script>
