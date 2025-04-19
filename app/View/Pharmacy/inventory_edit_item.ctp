
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PharmacyItemInventoryEditItemForm").validationEngine();
	});

</script>
<?php
echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
/* echo $this->Html->script('jquery.autocomplete_pharmacy');
echo $this->Html->css('jquery.autocomplete.css'); */
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
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Pharmacy Management - Edit Item', true); ?>
	</h3>
	<span> <?php if(isset($this->params['pass']['1']) && $this->params['pass']['1'] == "apam"){
		echo $this->Html->link(__('Back'), array('action' => 'apam_item_list' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	}else{
		echo $this->Html->link(__('Back'), array('action' => 'item_list' ,'list','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	}
	?>
	</span>

</div>
<?php $doseForm = array('Pack'=>'Pack','Inj'=>'Inj','Vial'=>'vial','Syrup'=>'Syrup','Syringe'=>'Syringe'); ?>
<div class="clr ht5"></div>
<?php  
echo $this->Form->create('PharmacyItem',array('id'=>'PharmacyItemInventoryEditItemForm'));?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<td width="15%" valign="middle" class="tdLabel" id="boxSpace">Item
			Name<font color="red">*</font>
		</td>
		<td width="15%"><input type="text" name="PharmacyItem[name]" id="name"
			class="textBoxExpnd validate[required]" tabindex="1"
			value="<?php 
			echo $data['PharmacyItem']['name'];?>" />
			<input type="hidden" name="PharmacyItem[nameHidden]" id="name"
			class="textBoxExpnd validate[required]" tabindex="1"
			value="<?php echo $data['PharmacyItem']['name'];?>" />
		</td>
		<td width="6%"></td>
		<td width="15%" class="tdLabel" id="boxSpace">Item Code</td>
		<td width="250">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width=""><input name="PharmacyItem[item_code]" type="text"
						class="textBoxExpnd" id="item_code" tabindex="2" style="width: 90%"
						value="<?php echo $data['PharmacyItem']['item_code'];?>" /></td>
				</tr>
			</table>
		</td>
		
		<!--  <td width="100" class="tdLabel" id="boxSpace">Date</td>
		<td width="250">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width=""><input name="PharmacyItem[date]" type="text"
						class="textBoxExpnd" id="date" tabindex="2" style="width: 82%"
						value="<?php echo $this->DateFormat->formatDate2Local($data['PharmacyItem']['date'],Configure::read('date_format'),true);?>" /></td>
				</tr>
			</table>
		</td>-->
		 
	
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Pack<font color="red">*</font>
		</td>
		<td><table><tr><td width="10%"><input type="text" name="PharmacyItem[pack]" id="pack" class="textBoxExpnd validate[required] onlyNumber" tabindex="3" style="width: 90%;" value="<?php echo $data['PharmacyItem']['pack'];?>"/></td>
		<td width="30%">
		<?php
			echo $this->Form->input('PharmacyItem.doseForm',array('type'=>'select','autocomplete'=>"off",'label'=>false,'options'=>$doseForm,'value'=>$data['PharmacyItem']['doseForm'],'style'=>"width:56%;"));
		 ?>
		</td></tr></table></td>
	    <td></td>
		<td class="tdLabel" id="boxSpace">Minimum</td>
		<td><input type="text" name="PharmacyItem[minimum]" id="minimum"
			class="textBoxExpnd onlyNumber" tabindex="4"
			value="<?php echo $data['PharmacyItem']['minimum'];?>" /></td>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Manufacturer</td>
		<td><input type="text" name="PharmacyItem[manufacturer]"
			id="manufacturer" class="textBoxExpnd" tabindex="5"
			value="<?php echo $data['PharmacyItem']['manufacturer'];?>" />
			<?php 
			echo $this->Form->hidden('manufacturer_id',array('id'=>'manufacturer_id','value'=>$data['PharmacyItem']['manufacturer_company_id'],'name'=>"PharmacyItem[manufacturer_id]")); ?>
			</td>
		<td></td>
		<td class="tdLabel" id="boxSpace">Maximum</td>
		<td><input type="text" name="PharmacyItem[maximum]" id="maximum"
			class="textBoxExpnd onlyNumber" tabindex="6"
			value="<?php echo $data['PharmacyItem']['maximum'];?>" /></td>
	</tr>
	<!--<tr>
	<td class="tdLabel" id="boxSpace">Shelf</td>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width=""><input type="text" name="PharmacyItem[shelf]"
						id="shelf" class="textBoxExpnd" tabindex="8"
						value="<?php echo $data['PharmacyItem']['shelf']; ?>" /></td>

				</tr>
			</table></td>
		<td class="tdLabel" id="boxSpace">Supplier</td>
		<td><input type="text" name="PharmacyItem[supplier_name]" id="search_supplier"
			class="textBoxExpnd" tabindex="10"  
			value="<?php echo $data['InventorySupplier']['name']; ?>"/>
			<?php echo $this->Form->hidden('',array('id'=>'supplier_id','name'=>"PharmacyItem[supplier_id]",'value'=>$data['PharmacyItem']['supplier_id'])); ?></td>
	</tr>-->
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Generic</td>
		<td><input type="text" name="PharmacyItem[generic]" id="generic" class="textBoxExpnd" tabindex="7" value="<?php echo $data['PharmacyItem']['generic'];?>" />
			<input type="hidden" name="PharmacyItem[generic_id]" id="genericId" />
			
		</td>
		<td></td>
			
		<td valign="middle" class="tdLabel" id="boxSpace">Expensive</td>
		<td><?php 
		if($data['PharmacyItem']['expensive_product'] == 1){
			$checked = "checked";
		}else{
			$checked = "";
		}
		echo $this->Form->input('PharmacyItem.expensive_product', array('type' => 'checkbox','class' => '','checked'=>$checked,'label' => false,'legend' => false,'tabindex'=>8));
		?>
		</td>
	
	</tr>
	
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace"> Reorder Level:</td>
		<td>
			<?php echo $this->Form->input('',array('type'=>'text','id'=>'reorder_level','class'=>' textBoxExpnd vatClass' ,'autocomplete'=>"off",'tabindex'=>9,'label'=>false,'div'=>false,'name'=>"data[PharmacyItem][reorder_level]",'value'=>$data["PharmacyItem"]["reorder_level"])); ?>
		</td> 
		<td></td>
		<td valign="middle" class="tdLabel" id="boxSpace">Profit Percent</td>
		<td><input type="text" name="PharmacyItem[profit_percentage]" id="profit_percentage" class="textBoxExpnd" tabindex="10" value="<?php echo $data['PharmacyItem']['profit_percentage'];?>"/></td>
		<td>%</td> 
	</tr>
	<?php if($this->Session->read('website.instance')=='vadodara'){?>
	<tr>
		<td class="tdLabel" id="boxSpace">General Ward</td>
		<td><?php echo $this->Form->input('PharmacyItem.gen_ward_discount',array('type'=>'text','id'=>"gendis", 'class'=>"textBoxExpnd number",'autocomplte'=>'off','tabindex'=>11,
			'div'=>false,'label'=>false,'value'=>$data['PharmacyItem']['gen_ward_discount']));?></td>
			<td>%</td> 
	    <td class="tdLabel" id="boxSpace">Special Ward</td>
		<td><?php echo $this->Form->input('PharmacyItem.spcl_ward_discount',array('type'=>'text','id'=>'spcldis','class'=>"textBoxExpnd number",'autocomplte'=>'off','tabindex'=>12,
							 'div'=>false,'label'=>false,'value'=>$data['PharmacyItem']['spcl_ward_discount']));?></td>		
		<td>%</td> 
	</tr>
	
	<tr>
		<td class="tdLabel" id="boxSpace">Delux Ward</td>
		<td><?php echo $this->Form->input('PharmacyItem.dlx_ward_discount',array('type'=>'text','id'=>"dlxdis", 'class'=>"textBoxExpnd number",'autocomplte'=>'off','tabindex'=>13,
			'div'=>false,'label'=>false,'value'=>$data['PharmacyItem']['dlx_ward_discount']));?></td>
		<td>%</td> 
	    <td class="tdLabel" id="boxSpace">Semi-Special Ward</td>
		<td><?php echo $this->Form->input('PharmacyItem.semi_spcl_ward_discount',array('type'=>'text','id'=>'semispldis','class'=>"textBoxExpnd number",'autocomplte'=>'off','tabindex'=>14,
							 'div'=>false,'label'=>false,'value'=>$data['PharmacyItem']['semi_spcl_ward_discount']));?></td>	
		<td>%</td> 	
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Isolation Ward</td>
		<td><?php echo $this->Form->input('PharmacyItem.islolation_ward_discount',array('type'=>'text','id'=>"isodis", 'class'=>"textBoxExpnd number ",'autocomplte'=>'off','tabindex'=>15,
			'div'=>false,'label'=>false,'value'=>$data['PharmacyItem']['islolation_ward_discount']));?></td>
		<td>%</td> 
	   <td class="tdLabel" id="boxSpace">OPD General</td>
		<td><?php echo $this->Form->input('PharmacyItem.opdgeneral_ward_discount',array('type'=>'text','id'=>'opdgendis','class'=>"textBoxExpnd number",'autocomplte'=>'off','tabindex'=>14,
							 'div'=>false,'label'=>false,'value'=>$data['PharmacyItem']['opdgeneral_ward_discount']));?></td>	
		<td>%</td> 
	</tr>
	<?php } ?>
	<tr>
			
		<?php if($websiteConfig['instance'] == 'kanpur'){ ?>
		<td class="tdLabel" id="boxSpace">Vat of Class:</td>
		<td>
			<?php echo $this->Form->input('',array('type'=>'select','class'=>'textBoxExpnd','id'=>'vat_of_class','calss'=>'vatClass','empty'=>'Select Vat','autocomplete'=>"off",'label'=>false,'name'=>"data[PharmacyItem][vat_class_id]",'options'=>$vatData)); ?>
		</td> 
		<?php }?>
		<td valign="middle" class="tdLabel" id="boxSpace"> </td>
		<td> 
		</td>
	</tr>
	
<!-- 	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Stock</td>
		<td><input type="text" name="PharmacyItem[stock]" id="stock"
			class="textBoxExpnd" tabindex="11"
			value="<?php echo $data['PharmacyItem']['stock'];?>" /></td>
		<td>&nbsp;</td>
		<td valign="middle" class="tdLabel" id="boxSpace">Batch No.</td> -->
<!-- 		<td><input type="text" name="PharmacyItem[batch_number]" id="batch_number" 
<!-- 			class="textBoxExpnd" tabindex="11" 
			value="<?php //echo $data['PharmacyItem']['batch_number'];?>" /></td>
	</tr>-->
 
</table>
 
<!-- biling activity form end here -->
<div class="btns">
	<!-- <input name="" type="button" value="Print" class="blueBtn" tabindex="11"/> -->
	<input name="" type="submit" value="Submit" class="blueBtn" tabindex="16" />

</div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>


<!-- Right Part Template ends here -->
</td>
</table>

<script>

$( "#expiry_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
		});
$( "#date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
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

$('#generic').autocomplete({
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


$(document).on('input',".stock, .mrp, .purchase_price, .selling_price,.number",function() {
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
});

$(document).on('input',"#name, .batch_number",function() {
    $(this).val($(this).val().toUpperCase());
});

$(document).on('input',"#profit_percentage",function() {
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
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
$(document).on('input',"#pack",function(){
	if (/[^0-9]/g.test(this.value)){this.value = this.value.replace(/[^0-9]/g,'');}
	if($("#pack").val() == 0){
		$("#pack").val('');
	}
});

</script>
