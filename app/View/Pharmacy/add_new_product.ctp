
<?php 
echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>

<div class="inner_title">
	<h3 style="padding-left: 2%">
		<?php echo __('Add Product', true); ?>
	</h3>
	<span> 
	<?php
		//echo $this->Html->link(__('Back'), array('controller'=>'Store','action'=>'index'), array('escape' => false,'class'=>'blueBtn back'));
	?>
	</span>

</div>

<div class="clr ht5"></div>

<?php echo $this->Form->create('Products',array('id'=>'ProductForm'));?>

<table width="80%" border="0" cellspacing="0" cellpadding="0" class="formFull" align="center">

	<tr>
		<td id="boxSpace" style="padding-left: 2%">Product Name<font color="red">*</font></td>
		<td><?php echo $this->Form->input('Product.name',
				array('type'=>'text','id'=>'name', 'class'=>"textBoxExpnd validate[required] product_name",
							 'tabindex'=>1,'div'=>false,'label'=>false,'autocomplete'=>'off'));?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td id="boxSpace">Product Code <!-- <font color="red">*</font>--></td>
		<td><?php echo $this->Form->input('Product.product_code',
				array('type'=>'text','class'=>"textBoxExpnd charUpper",'id'=>'item_code','tabindex'=>2,'div'=>false,'label'=>false));?>
		</td>
	</tr>

	<tr>
		<td id="boxSpace" style="padding-left: 2%">Manufacturer</td>
		<td><?php echo $this->Form->input('Product.manufacturer',
				array('type'=>'text','class'=>"textBoxExpnd manufacturer",'id'=>'manufacturer','tabindex'=>3,'div'=>false,'label'=>false));

				echo $this->Form->hidden('Product.manufacturer_id',array('id'=>'manufacturer_id'));
				
				echo $this->Html->link($this->Html->image('icons/plus_6.png',
			array('title'=>'Add Manufacturer','alt'=>'Add Manufacturer')), 'javascript:void(0)', array('escape' => false,'onclick'=>"getAddManufacturer()"));
			?>			 
		</td>
		<td>&nbsp;</td>
		<td >&nbsp;</td>
		<td valign="middle" id="boxSpace">Supplier </td>
		<td><?php echo $this->Form->input('Product.supplier_name',
				array('type'=>'text','id'=>'supplier_name','class'=>"textBoxExpnd supplier_name",
							 'tabindex'=>4,'div'=>false,'label'=>false));
				
				echo $this->Form->hidden('Product.supplier_id',array('id'=>'supplier_id'));
			echo $this->Html->link($this->Html->image('icons/plus_6.png',
			array('title'=>'Add Supplier','alt'=>'Add Supplier')), 'javascript:void(0)', array('escape' => false,'onclick'=>"getAddSupplier()"));
		?>
		</td>
	</tr>
	 <tr>
		<td id="boxSpace" style="padding-left: 2%">Pack  <font color="red">*</font> 
		</td>
		<td><table><tr><td><input type="text" name="Product[pack]" id="pack"class="textBoxExpnd validate[required] onlyNumber" tabindex="5"/></td>
		<td>
		<?php
		 $doseForm = array('Pack'=>'Pack','Inj'=>'Inj','Vial'=>'vial','Syrup'=>'Syrup','Syringe'=>'Syringe'); 
			echo $this->Form->input('Product.doseForm',array('type'=>'select','tabindex'=>6,'autocomplete'=>"off",'label'=>false,'options'=>$doseForm));
		 ?>
		</td></tr></table></td><td width="">&nbsp;</td>
		<td>&nbsp;</td>
		<td id="boxSpace">Generic <font color="red">*</font></td>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><?php echo $this->Form->input('Product.generic',
							array('type'=>'text', 'class'=>"textBoxExpnd charUpper validate[required]",
							 'tabindex'=>8,'div'=>false,'label'=>false));?></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td id="boxSpace" style="padding-left: 2%">Minimum</td>
		<td><?php echo $this->Form->input('Product.minimum',
				array('type'=>'text','id'=>'minimum','class'=>"textBoxExpnd minimum onlyNumber",
							 'tabindex'=>9,'div'=>false,'label'=>false));?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td id="boxSpace">Maximum</td>
		<td><?php echo $this->Form->input('Product.maximum',
				array('type'=>'text','class'=>"validate[custom[number] textBoxExpnd maximum onlyNumber",'id'=>'maximum','tabindex'=>10,'div'=>false,'label'=>false));?></td>
	</tr>
	<tr>
		<td id="boxSpace" style="padding-left: 2%">Expensive</td>
		<td><?php 
		echo $this->Form->input('Product.expensive_product', array('type' => 'checkbox','tabindex'=>11,'class' => '','label' => false,'legend' => false));
		?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td id="boxSpace">Location</td>
		<td><?php $thisLocation = $this->Session->read('locationid');
				echo $this->Form->input('Product.location_id',
				array('type'=>'select','class'=>"textBoxExpnd ",'id'=>'location_id','options'=>$locations,'value'=>$thisLocation,'tabindex'=>12,'div'=>false,'label'=>false));?>
		</td>
	</tr>
	<tr>
	<td id="boxSpace" style="padding-left: 2%">Implant</td> <!-- added by mrunal - as per the Murali sir Requirement -->
	<td><?php 
			echo $this->Form->input('Product.is_implant', array('type' => 'checkbox','class' => '','label' => false,'legend' => false));
		?>
	</td>
	</tr>
	<?php if($websiteConfig['instance'] == 'kanpur'){ ?>
	<tr>
		<td valign="middle" id="boxSpace"  style="padding-left: 2%"> <?php echo __("Vat Class") ?> </td>   
		<td>
			<?php echo $this->Form->input('',array('type'=>'select','tabindex'=>13,'class'=>'textBoxExpnd','id'=>'vat','calss'=>'vatClass', 'style'=>"width: 30%",'empty'=>'Please select','autocomplete'=>"off",'label'=>false,'name'=>"data[Product][vat_class_id]",'options'=>$vatData)); ?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>	
		<td valign="middle" id="boxSpace"></td>
			<td> </td>
	 </tr>
	 <?php } ?>
<!--  Following fields are added for only vadodara because item price varries as per wards- Atul  -->
	 <?php if($websiteConfig['instance'] == 'vadodara'){ ?>
	 <tr>
		
		
		<td valign="middle" id="boxSpace" style="padding-left: 2%"> <?php echo __("Profit Percentage") ?> </td>
		<td><input type="text" name="PharmacyItem[profit_percentage]" id="profit_percentage" class="textBoxExpnd onlyNumber" tabindex="13" />%</td>
		
		<td>&nbsp;</td>
		<td>&nbsp;</td>	
		<td valign="middle" id="boxSpace"><?php echo __("General Ward") ?> </td>
	  <td><?php echo $this->Form->input('Product.gen_ward_discount',array('type'=>'text','id'=>"gendis", 'class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
			'div'=>false,'label'=>false));?> %</td> 
	 </tr>
	 
	  <tr>
		<td valign="middle" id="boxSpace" style="padding-left: 2%"> <?php echo __("Special Ward") ?> </td>
		<td><?php echo $this->Form->input('Product.spcl_ward_discount',array('type'=>'text','id'=>'spcldis','class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?>%</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>	
		<td valign="middle" id="boxSpace"><?php echo __("Delux Ward") ?> </td>
	    <td><?php echo $this->Form->input('Product.dlx_ward_discount',array('type'=>'text','id'=>"dlxdis", 'class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?>%</td> 
	 </tr>
	 
	  <tr>
		<td valign="middle" id="boxSpace" style="padding-left: 2%"> <?php echo __("Semi-Special Ward") ?> </td>
		<td><?php echo $this->Form->input('Product.semi_spcl_ward_discount',array('type'=>'text','id'=>'semispldis','class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?>%</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>	
		<td valign="middle" id="boxSpace"><?php echo __("Isolation Ward") ?> </td>
	    <td><?php echo $this->Form->input('Product.islolation_ward_discount',array('type'=>'text','id'=>"isodis", 'class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?>%</td> 
	 </tr>
	  <tr>
		<td valign="middle" id="boxSpace" style="padding-left: 2%"> <?php echo __("OPD General") ?> </td>
		<td><?php echo $this->Form->input('Product.opdgeneral_ward_discount',array('type'=>'text','id'=>'opdgendis','class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?>%</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>	
		<td valign="middle" id="boxSpace"> </td>
	    <td></td> 
	 </tr>
	 
	 
	  <?php } ?>
</table>



<!-- billing activity form end here -->
<div class="btns" style="padding-right:100px">
	<input name="" type="submit" value="Submit" class="blueBtn submit"
		id="submit" tabindex="6"  />
		<?php echo $this->Form->end();?>
</div>
<?php echo $this->Html->link(__('Cancel'), array('action'=>'index'), array('escape' => false,'class'=>'blueBtn cancel')); ?>
<p class="ht5"></p>	


<!--  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="ProductForm" class="formFull">
	
	<tr>
		<td width="30%" valign="middle" class="tdLabel">
			<?php echo __("Product Name");?><font color="red">*</font>
		</td>
		<td width="40%">
			<?php echo $this->Form->input('Product.name',array('type'=>'text','name'=>'name','id'=>'name','class'=>"textBoxExpnd validate[required]",'value'=>$data['Product']['name'], 'tabindex'=>1,'div'=>false,'label'=>false)); ?>
		</td>
		<td width="30%"></td>
	</tr>
	
	<tr>
		<td width="30%" valign="middle" class="tdLabel">
			<?php echo __("Description");?></td>
		<td width="40%">
			<?php echo $this->Form->input('Product.description',array('type'=>'textarea','name'=>"description",/*'value'=>$data['Product']['description'],*/'class'=>"textBoxExpnd",'tabindex'=>2, 'value'=>"",'div'=>false,'label'=>false));?>
		</td>
		<td></td>
	</tr>

	<tr>
		<td width="30%" valign="middle" class="tdLabel">
			<?php echo __("Quantity");?><font color="red">*</font>
		</td>
		<td>
			<?php echo $this->Form->input('Product.quantity',array('type'=>'text','name'=>"quantity",/*'value'=>$data['Product']['quantity'],*/ 'class'=>"textBoxExpnd validate[required]", 'tabindex'=>3,'div'=>false,'label'=>false));?></td>
	</tr>
	
	
	<tr>
		<td class="tdLabel"><?php echo __("Supplier");?></td>
		<td>
		<?php echo $this->Form->input('Product.supplier_id',array('type'=>'select','options'=>$serviceProviders,'empty'=>'Please Select',/*'default'=>$data['Product']['supplier_id'],*/'name'=>"supplier_id",'class'=>"textBoxExpnd",'tabindex'=>4,'div'=>false,'label'=>false));?>
		</td>
		<td></td>
	</tr>
	
	<tr>
		<td width="30%" valign="middle" class="tdLabel">
			<?php echo __("Date");?><font color="red">*</font></td>
		<td width="40%">
			<?php $date= $this->DateFormat->formatDate2Local($this->data['Product']['date'],Configure::read('date_format'));
					echo $this->Form->input('Product.date',
							array('type'=>'text','id'=>'date', 'class'=>"textBoxExpnd ",'value'=>$date,
							 'tabindex'=>14,'div'=>false,'label'=>false));?></td>
		<td></td>
	</tr>
</table>-->

<!-- billing activity form end here -->
<!-- <div class="btns">
	<input name="" type="submit" value="Submit" class="blueBtn" tabindex="6" />
</div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>
-->

<script>

$(".submit").click(function(){
	var valid=jQuery("#ProductForm").validationEngine('validate');  
	if(valid == true){ 
		$("#submit").hide(); 
		return true;
	}else{
		return false;
	}
	});

$(document).ready(function(){
$('#name').focus();
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
$('#supplier_name').autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null',"no",'no','is_deleted=0',"admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 select: function( event, ui ) {
		 $('#supplier_id').val(ui.item.id); 
	 },
	 messages: {
	        noResults: '',
	        results: function() {}
	 }
});
});


$("#date").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,
	yearRange: '1950',
	dateFormat:'<?php echo $this->General->GeneralDate();?>'
});
$("#expiry_date").datepicker({
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

$('.cancel, .back').click(function(){
	window.location.href="<?php echo $this->Html->url(array("controller"=>'Store','action'=>'index'));?>"
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


$("#profit_percentage").keyup(function(){
	percent = parseInt($(this).val());
	if(percent != null || percent != 0)
	{
		mrp = parseInt($("#mrp").val());
		profit_price = parseInt(mrp + (percent * mrp) /100);
		$("#profit-sale").show();
		$("#profit-value").html(profit_price);
	}
	else
	{
		$("#profit-sale").hide();
	}
	//alert(profit_price);
});


/***
 * to add supplier
 * By Mrunal
 */
function getAddSupplier(){
	$.fancybox({
		'width' : '100%',
		'height' : '100%',
		//'autoScale' : true,
		'transitionIn' :'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>"store", "action" => "add_supplier",'?'=>array('flag'=>1))); ?>"

	});
}

function getAddManufacturer(){
	$.fancybox({
		'width' : '100%',
		'height' : '100%',
		//'autoScale' : true,
		'transitionIn' :'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>"Store", "action" => "manufacturingCompany",'?'=>array('flag'=>1))); ?>"

	});
}
//all capitals by Swapnil G.Sharma

$(document).on('input',".product_name",function() {
	if (/[^0-9 a-z A-Z-.,%'"\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9 a-z A-Z-.,%'"\.]/g,'');
    }
	 $(this).val($(this).val().toUpperCase());
}); 
$(document).on('input',".manufacturer,.supplier_name",function() {
	if (/[^a-z A-Z\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^a-z A-Z\.]/g,'');
    }
	 $(this).val($(this).val().toUpperCase());
}); 

$(document).on('input'," .charUpper",function() {
	 $(this).val($(this).val().toUpperCase());
}); 


// only numeric 
$(document).on('keyup',".quantity, .mrp, .tax, .purchase_price, .sale_price, .percentage",function() {
	if (/[^0-9\.]/g.test(this.value))
	{
		 this.value = this.value.replace(/[^0-9\.]/g,'');
	}
});

$(".mrp").keyup(function(){
	$(".sale_price").val($(this).val());
});

$(".sale_price").keyup(function(){
	$(".mrp").val($(this).val());
});

$(document).on("input",".onlyNumber",function(){
	if (/[^0-9]/g.test(this.value))
	{
		 this.value = this.value.replace(/[^0-9]/g,'');
	}
});

$(document).on('input',"#profit_percentage",function(){
	percent = parseInt($("#profit_percentage").val());
	if(percent > 101)
	{
		alert("Percentage should be less than or equal to 100");
		$("#profit_percentage").val('');
	}
});

$(document).on('input',"#gendis",function(){
	percent = parseInt($("#gendis").val());
	if(percent > 101)
	{
		alert("Percentage should be less than or equal to 100");
		$("#gendis").val('');
	}
});


$(document).on('input',"#spcldis",function(){
	percent = parseInt($("#spcldis").val());
	if(percent > 101)
	{
		alert("Percentage should be less than or equal to 100");
		$("#spcldis").val('');
	}
});
$(document).on('input',"#semispldis",function(){
	percent = parseInt($("#semispldis").val());
	if(percent > 101)
	{
		alert("Percentage should be less than or equal to 100");
		$("#semispldis").val('');
	}
});
$(document).on('input',"#dlxdis",function(){
	percent = parseInt($("#dlxdis").val());
	if(percent > 101)
	{
		alert("Percentage should be less than or equal to 100");
		$("#dlxdis").val('');
	}
});
$(document).on('input',"#isodis",function(){
	percent = parseInt($("#isodis").val());
	if(percent > 101)
	{
		alert("Percentage should be less than or equal to 100");
		$("#isodis").val('');
	}
});
$(document).on('input',"#opdgendis",function(){
	percent = parseInt($("#opdgendis").val());
	if(percent > 101)
	{
		alert("Percentage should be less than or equal to 100");
		$("#opdgendis").val('');
	}
});
/*End OF Code*/

</script>
