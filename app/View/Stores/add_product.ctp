
<?php 
echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>


<div class="inner_title">
	<h3>
		<?php echo __('Add Product', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Back'), array('controller'=>'Store','action'=>'index'), array('escape' => false,'class'=>'blueBtn back'));
	?>
	</span>

</div>

<div class="clr ht5"></div>


<?php echo $this->Form->create('Products',array('id'=>'ProductForm'));?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull" align="center">
	<tr>
		<td width="20%" align="right">Product Name <font color="red">*</font>:</td>
		<td width="3%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.name',array('type'=>'text','id'=>'name','autocomplete'=>'off', 'class'=>"textBoxExpnd capsName validate[required]",
							 'tabindex'=>1,'div'=>false,'label'=>false));?></td>
		<td width="6%"></td>
		<td width="20%" align="right">Product Code :</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.product_code',
				array('type'=>'text','autocomplete'=>'off','class'=>"textBoxExpnd capsName",'id'=>'item_code','tabindex'=>2,'div'=>false,'label'=>false));?></td>
		<td width="6%"></td>
	</tr>
	
	<tr>
		<td width="20%" align="right">Manufacturer :</td>
		<td width="3%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.manufacturer',
				array('type'=>'text','class'=>"textBoxExpnd capsName",'id'=>'manufacturer','tabindex'=>3,'div'=>false,'label'=>false));
 				echo $this->Form->hidden('Product.manufacturer_id',array('id'=>'manufacturer_id')); ?></td>
		<td width="6%"></td>
		<td width="20%" align="right">Supplier :</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.supplier_name',
				array('type'=>'text','id'=>'supplier_name','class'=>"textBoxExpnd capsName",
							 'tabindex'=>3,'div'=>false,'label'=>false));
					echo $this->Form->hidden('Product.supplier_id',
							array('id'=>'supplier_id','class'=>"textBoxExpnd",
							 'tabindex'=>4,'div'=>false,'label'=>false));?></td>
		<td width="6%"></td>
	</tr> 
	
	<tr>
		<td width="20%" align="right">Pack <font color="red">*</font>:</td>
		<td width="3%"></td>
		<td width="20%" align="left">
			<table>
				<tr>
					<td><?php echo $this->Form->input('Product.pack', array('type'=>'text','id'=>'pack','class'=>"textBoxExpnd validate[required] numberOnly",
							 'tabindex'=>5,'div'=>false,'autocomplete'=>'off','label'=>false));?> </td>
					<td><?php $doseForm = array('Pack'=>'Pack','Inj'=>'Inj','Vial'=>'vial','Syrup'=>'Syrup','Syringe'=>'Syringe'); 
						echo $this->Form->input('Product.doseForm',array('type'=>'select','tabindex'=>6,'autocomplete'=>"off",'label'=>false,'options'=>$doseForm,'style'=>"width:100%;"));
					?></td>
				</tr>
			</table>
		</td>
		<td width="6%"></td>
		<td width="20%" align="right">Generic :</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.generic', array('type'=>'text','autocomplete'=>'off', 'class'=>"textBoxExpnd capsName",'tabindex'=>7,'div'=>false,'label'=>false,'id'=>'genericName'));
		echo $this->Form->input('Product.generic_id', array('type'=>'hidden','id'=>'genericId'));
		?></td>
		<td width="6%"></td>
	</tr>
	
	<tr>
		<td width="20%" align="right">Minimum :</td>
		<td width="3%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.minimum', array('type'=>'text','id'=>'minimum','class'=>"textBoxExpnd numberOnly",
							 'tabindex'=>8,'div'=>false,'autocomplete'=>'off','label'=>false));?></td>
		<td width="6%"></td>
		<td width="20%" align="right">Maximum :</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.maximum',
				array('type'=>'text','autocomplete'=>'off','class'=>"validate[custom[number] numberOnly textBoxExpnd",'id'=>'maximum','tabindex'=>9,'div'=>false,'label'=>false));?>
		</td>
		<td width="6%"></td>
	</tr>
	
	<tr>
		<td width="20%" align="right">Date <font color="red">*</font>:</td>
		<td width="3%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.date',array('type'=>'text','name'=>"date",'class'=>"textBoxExpnd", 'id'=>"date", 'tabindex'=>10,'div'=>false,'label'=>false));?></td>
		<td width="6%"></td>
		<td width="20%" align="right">Location :</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php $thisLocation = $this->Session->read('locationid');
				echo $this->Form->input('Product.location_id', array('type'=>'select','class'=>"textBoxExpnd ",'id'=>'location_id','options'=>$locations,'value'=>$thisLocation,'tabindex'=>11,'div'=>false,'label'=>false));?>
		</td>
		<td width="6%"></td>
	</tr>
	
	<tr>
		<td width="20%" align="right">Expensive :</td>
		<td width="3%"></td>
		<td width="20%" align="left"><?php 
			echo $this->Form->input('Product.expensive_product', array('type' => 'checkbox','class' => '','label' => false,'legend' => false,'tabindex'=>12));
		?></td>
		<td width="6%"></td>
		<td width="20%" align="right">Reorder Level :</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.reorder_level', array('type'=>'text','id'=>'pack','autocomplete'=>'off','class'=>"textBoxExpnd validate[custom[number]  ",
							 'tabindex'=>13,'div'=>false,'label'=>false));?></td>
		<td width="6%"></td>
	</tr>
	
	<tr>
		<td width="20%" align="right">Profit Percentage :</td>
		<td width="3%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.profit_percentage',array('type'=>'text','autocomplete'=>'off','id'=>"profit_percentage", 'class'=>"textBoxExpnd validate[custom[number]",
							 'tabindex'=>14,'div'=>false,'label'=>false));?></td>
		<td width="6%">%</td>
		<td width="20%" align="right">Target Quantity :</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.target',array('type'=>'text','autocomplete'=>'off','id'=>'minimum','class'=>"textBoxExpnd ",
							 'tabindex'=>15,'div'=>false,'label'=>false));?></td>
		<td width="6%"></td>
	</tr>
	
	<?php if($websiteConfig['instance'] == 'kanpur'){ ?>
	<tr>
		<td width="20%" align="right">Vat Class :</td>
		<td width="3%"></td>
		<td width="20%" align="left">
			<?php echo $this->Form->input('',array('type'=>'select','tabindex'=>16,'class'=>'textBoxExpnd','id'=>'vat','calss'=>'vatClass','empty'=>'Please select','autocomplete'=>"off",'label'=>false,'name'=>"data[Product][vat_class_id]",'options'=>$vatData)); ?>
		</td>
		<td width="6%"></td>
		<td width="20%" align="right"></td>
		<td width="5%"></td>
		<td width="20%" align="left"></td>
		<td width="6%"></td>
	</tr>
	<?php } ?>	
<!--  Following fields are added for only vadodara because item price varries as per wards- Atul  -->
	<?php if($this->Session->read('website.instance')=='vadodara'){?>
	<tr>
		<td width="20%" align="right">General Ward :</td>
		<td width="3%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.gen_ward_discount',array('type'=>'text','tabindex'=>16,'id'=>"gendis", 'class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?></td>
		<td width="6%">%</td>
		<td width="20%" align="right">Special Ward:</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.spcl_ward_discount',array('type'=>'text','tabindex'=>17,'id'=>'spcldis','class'=>"textBoxExpnd validate[custom[number]  ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?></td>
		<td width="6%">%</td>
	</tr>
		<tr>
		<td width="20%" align="right">Delux Ward :</td>
		<td width="3%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.dlx_ward_discount',array('type'=>'text','tabindex'=>18,'id'=>"dlxdis", 'class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?></td>
		<td width="6%">%</td>
		<td width="20%" align="right">Semi-Special Ward:</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.semi_spcl_ward_discount',array('type'=>'text','tabindex'=>19,'id'=>'semispldis','class'=>"textBoxExpnd validate[custom[number]  ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?></td>
		<td width="6%">%</td>
	</tr>
	<tr>
		<td width="20%" align="right">Isolation Ward</td>
		<td width="3%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.islolation_ward_discount',array('type'=>'text', 'tabindex'=>20,'id'=>"isodis", 'class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?>
		</td>
		<td width="6%">%</td>
		<td width="20%" align="right">OPD General</td>
		<td width="5%"></td>
		<td width="20%" align="left"><?php echo $this->Form->input('Product.opdgeneral_ward_discount',array('type'=>'text', 'tabindex'=>21,'id'=>"opdgendis", 'class'=>"textBoxExpnd validate[custom[number] ",'autocomplte'=>'off',
							 'div'=>false,'label'=>false));?></td>
		<td width="6%">%</td>
	</tr>
	
<?php }?>
<?php if($this->Session->read('website.instance')!='vadodara' && $this->Session->read('website.instance')!='kanpur'){?>
    <tr>
		<td width="20%" align="right">Tax :</td>
		<td width="3%"></td>
		<td width="20%" align="left">
			<?php echo $this->Form->input('Product.tax',array('type'=>'text','id'=>"tax", 'class'=>"textBoxExpnd validate[custom[number]",
							 'tabindex'=>22,'div'=>false,'label'=>false));?>
		</td>
		<td width="6%"></td>
		<td width="20%" align="right"></td>
		<td width="5%"></td>
		<td width="20%" align="left"></td>
		<td width="6%"></td>
	</tr>
	<?php }?>
</table>


<!-- billing activity form end here -->
<div class="btns">
	<input name="" type="submit" value="Submit" class="blueBtn submit"
		id="submit" tabindex="23" />
		<?php echo $this->Form->end();?>
	<?php
	echo $this->Html->link(__('Cancel'), array('action'=>'index'), array('escape' => false,'class'=>'blueBtn cancel'));
	?>
</div>

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
			<?php echo $this->Form->input('Product.date',array('type'=>'text','name'=>"date",'class'=>"textBoxExpnd", 'id'=>"date", 'tabindex'=>5,'div'=>false,'label'=>false));?>
		</td>
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
		$(".submit").hide();
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

$('#genericName').autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","GenericComponent","generic_name",'null',"no",'no','is_deleted=0',"admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 select: function( event, ui ) {
		 $('#genericId').val(ui.item.id); 
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
	showOn: "both",
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
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,
	yearRange: '1950',
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
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


$(document).on('keyup',"#profit_percentage",function(){
	percent = parseInt($("#profit_percentage").val());
	if(percent > 100)
	{
		alert("please enter valid Percent");
		$("#profit_percentage").val('');
		$("#profit_percentage").focus();		
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


/***
 * to add supplier
 * By Mrunal
 */
function getAddSupplier(){
	$.fancybox({
		'width' : '80%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' :'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>"store", "action" => "add_supplier",'?'=>array('flag'=>1))); ?>"

	});
}

function getAddManufacturer(){
	$.fancybox({
		'width' : '80%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' :'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>"Store", "action" => "manufacturingCompany",'?'=>array('flag'=>1))); ?>"

	});
}

$(document).on('input',".numberOnly, .discount",function() {
	if (/[^0-9]/g.test(this.value))
    {
    	this.value = this.value.replace(/[^0-9]/g,'');
    }
	if (this.value.length > 5) this.value = this.value.slice(0,5);
});

$(document).on('input',".capsName",function() {
	if (/[^0-9 a-z A-Z-.,\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9 a-z A-Z-.,\.]/g,'');
    }
	 $(this).val($(this).val().toUpperCase());
}); 

/*End OF Code*/

</script>
