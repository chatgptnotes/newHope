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
.td_second{
	border-left-style:solid; 
	padding-left: 15px; 
	background-color: #404040; 
	color:#ffffff;
	width:5%;
}

tbody.scrollContent 
        {
       		width: 100%;
           	overflow: auto;
            display: list-item;
            height: 300px;
        }
</style>

<?php 
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->script('jquery.autocomplete.js');
echo $this->Html->css('jquery.autocomplete.css');
?>
<script>
	jQuery(document).ready(function(){
		jQuery("#OtPharmacyItem").validationEngine();
	});

</script>
<?php 

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

	<h3>
		&nbsp;
		<?php echo __('OT Pharmacy Management - Item List', true); ?>
		<?php echo $this->element('ot_pharmacy_menu');?>
	</h3>
	
	<div class="clr ht5"></div>
</div>	
 <form accept-charset="utf-8" method="POST" id="inventory_search" style="padding-top: 0px;"
	action="<?php echo $this->Html->url(array('action' => 'add_item'));?>">

	<table border="0" align="center" class="table_format" cellpadding="0" cellspacing="0"
		width="80%">
		<tbody>

		<tr></tr>
 			<tr class="row_title"> 

				<td width="100" style="padding-left: 150px;"><label>Item Name :</label></td>
				<td>
<?php
 				      echo $this->Form->input( "name", array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
 				?>
 				</td> 

				<td style="width: 90px;"><label>Item Code :</label></td>
				<td><?php
 				echo    $this->Form->input("item_code", array('type'=>'text','id' => 'item_code', 'label'=> false, 'div' => false, 'error' => false));
 				?>
 				</td> 
 			   <?php if($this->Session->read('website.instance')=="vadodara"){?>
				<td style="width: 106px;"><label>Location:</label></td>
				<td><?php
					echo  $this->Form->input("location_id", array('empty'=>'Please Select','id' => 'location_id','name'=>'location_id', 'options'=>$location,'label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
	           <?php }?>

				<td align="right" colspan="2"><?php
 				echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));
 				?>
 				</td>
 				<td>
 					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'OtPharmacy','action'=>'add_item'),array('escape'=>false, 'title' => 'refresh'));?>
 				</td>
			</tr> 
		</tbody>
	</table>
</form>
	<?php echo $this->Form->create('OtPharmacyItem',array('id'=>"OtPharmacyItem",'onkeypress'=>"return event.keyCode != 13;"));
	echo $this->Form->input('',array('name'=>'OtPharmacyItem[id]','type'=>'hidden','id'=>'itemId'));
	echo $this->Form->input('',array('name'=>'OtPharmacyItem[stock]','type'=>'hidden','id'=>'stock'));
	
	?>




	<!--<table cellpadding="0" cellspacing="0" align="center" width="60%" class="formFull" >
		<tr>
			<td></td>
			<td valign="middle" class="tdLabel" id="boxSpace">Item Name<font color="red">*</font></td>
			<td><input type="text" name="OtPharmacyItem[name]" id="name" class="textBoxExpnd validate[required]" tabindex="1" /></td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">Item Code</td>
			<td><input type="text" name="OtPharmacyItem[item_code]" id="item_code" class="textBoxExpnd" tabindex="7" /></td>
			<td></td>
		</tr>
	
		
		<tr>
			<td></td>
			<td class="tdLabel" id="boxSpace" >Pack<font color="red">*</font></td>
			<td><input type="text" name="OtPharmacyItem[pack]" id="pack" class="textBoxExpnd validate[required]" tabindex="3" style="width: 90%;"/></td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">Minimum</td>
			<td><input type="text" name="OtPharmacyItem[minimum]" id="minimum" class="textBoxExpnd" tabindex="4" /></td>
			<td></td>
		</tr>
		  <tr>
			<td></td>
			<td class="tdLabel" id="boxSpace">Supplier</td>
			<td><input type="text" name="OtPharmacyItem[supplier_name]" id="search_supplier"
				class="textBoxExpnd" tabindex="10" />
				<?php echo $this->Form->hidden('',array('id'=>'supplier_id','name'=>"OtPharmacyItem[supplier_id]",'value'=>'')); 
				 
				echo $this->Html->link($this->Html->image('icons/plus_6.png',
						array('title'=>'Add Supplier','alt'=>'Add Supplier')), 'javascript:void(0)', array('escape' => false,'onclick'=>"getAddSupplier()"));
				?></td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">Maximum</td>
			<td><input type="text" name="OtPharmacyItem[maximum]" id="maximum" class="textBoxExpnd" tabindex="6" /></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td class="tdLabel" id="boxSpace">Date</td>
			<td>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width=""><input name="OtPharmacyItem[date]" type="text" class="textBoxExpnd" id="date" tabindex="2" value=""	style="width: 58%" />
						</td>
					</tr>
				</table>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">Shelf</td>
			<td><input type="text" name="OtPharmacyItem[shelf]" id="shelf"
					class="textBoxExpnd" tabindex="8" />
			</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td valign="middle" class="tdLabel" id="boxSpace">Generic</td>
			<td><input type="text" name="OtPharmacyItem[generic]" id="generic"
				class="textBoxExpnd" tabindex="9" /></td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">Manufacturer</td>
			<td><input type="text" name="OtPharmacyItem[manufacturer]" id="manufacturer" class="textBoxExpnd" tabindex="5" />
			<?php echo $this->Form->hidden('manufacturer_id',array('id'=>'manufacturer_id','name'=>"OtPharmacyItem[manufacturer_id]")); 
				  echo $this->Html->link($this->Html->image('icons/plus_6.png',array('title'=>'Add Manufacturer','alt'=>'Add Manufacturer')), 'javascript:void(0)', array('escape' => false,'onclick'=>"getAddManufacturer()"));
				?>
			</td>
			<td></td>
		</tr>
		<tr>
		<td></td><td></td>
		<td></td><td></td>
		<td></td><td></td>
		<td>
			<input  name="" type="submit" value="Submit" class="blueBtn" tabindex="11" />
		</td>
		</tr>
	</table>-->
	<?php $website= $this->Session->read('website.instance');?>
	<table border="0" align="center" class="table_format" cellpadding="0" cellspacing="0" width="100%" >
	<tbody class="">
		
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo __('Item Name', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('Item Code', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('Pack', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('Stock', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('Stock(MSU)', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('Generic', true); ?></strong></td>
			<?php if($this->Session->read('website.instance')=="vadodara"){?>
			<td class="table_cell"><strong><?php echo __('Location', true); ?></strong></td>
			<?php }?>
		 	<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong></td> 
		</tr>
		
		<?php 
			$cnt =0;
			if(count($data) > 0) { 
		       foreach($data as $itemData):
		       $cnt++;
		?>
		
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"><?php echo $itemData['OtPharmacyItem']['name']; ?></td>
			<td class="row_format"><?php echo $itemData['OtPharmacyItem']['item_code']; ?></td>
			<td class="row_format"><?php echo $pack = $itemData['OtPharmacyItem']['pack']; ?></td>
			<td class="row_format"><?php echo $itemData['OtPharmacyItem']['stock']; ?></td>
			<td class="row_format"><?php echo (int)$pack * $itemData['OtPharmacyItem']['stock'] + $itemData['OtPharmacyItem']['loose_stock'];  ?></td>
			<!-- <td class="row_format"><?php echo $itemData['OtPharmacyItem']['minimum']; ?></td> -->
			<td class="row_format"><?php echo $itemData['OtPharmacyItem']['generic']; ?></td>
			<?php if($this->Session->read('website.instance')=="vadodara"){?>
			<td class="row_format"><?php echo $itemData['Location']['name']; ?></td>
			<?php }?>
			<td class="row_format">
				<?php 
				
				echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Item', true), 
				'eachBatchId'=>$itemData['OtPharmacyItem']['id'],'id'=>'viewBatches','class'=>'viewBatches' ,
				'title' => __('View Item', true))),'javascript:void(0);', array('escape' => false));
				
				echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),'id'=>'editItem',
						'alt'=> __('Edit', true))), array('controller'=>'OtPharmacy','action' => 'edit_item',$itemData['OtPharmacyItem']['id']), array('escape' => false ));
				echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
						'alt'=> __('Delete', true))), array('controller'=>'OtPharmacy','action' => 'item_delete', $itemData['OtPharmacyItem']['id']), array('escape' => false ),"Are you sure ?");
				
				 ?>
			</td> 
		</tr>
		
		<?php endforeach;
			}?>
		<tr>
		<TD colspan="10" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
		</span>
		</TD>
		</tr>
		</tbody>
	</table>

<?php echo $this->Form->end();?>



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
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);


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
		dateFormat:'<?php echo $this->General->GeneralDate("");?>', 
	});
});

$(document).on('keyup',".stock, .mrp, .purchase_price, .selling_price",function() {
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
});
/*
$(document).on('input',"#name, .batch_number",function() {
    $(this).val($(this).val().toUpperCase());
});

$("#submitButton").click(function(){
	var valid = jQuery("#OtPharmacyItem").validationEngine('validate');
	if(valid){
		$("#submitButton").hide();
		$('#busy-indicator').show();
	}else{
		return false;
	}
});
*
 * End Of Code
 */
</script>
<script>
$('#name').on('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","OtPharmacyItem","name","null","null","no", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1, 
			}
		);

	}
		);
$('#item_code').on('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","OtPharmacyItem","item_code","null","null","null", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,

				autoFill:true
			}
		);

	});

$(".viewBatches").click(function(){ 
	var itemId = $(this).attr('eachBatchId');
	 $.fancybox({ 
		 	'width' : '80%',
			'height' : '80%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':true,
			'showCloseButton':true,
			'onClosed':function(){
			},
			'href' : "<?php echo $this->Html->url(array("controller" =>"OtPharmacy","action" =>"viewBatches")); ?>"+'/'+itemId,
	 });
	 $(document).scrollTop(0);
 });
</script> 