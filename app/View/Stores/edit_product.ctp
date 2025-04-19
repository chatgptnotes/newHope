
<div class="inner_title">
	<h3>
		<?php echo __('Edit Product', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Back'), '#', array('escape' => false,'class'=>'blueBtn back'));
	?>
	</span>

</div>

<div class="clr ht5"></div>


<?php echo $this->Form->create('Products',array('id'=>'ProductForm'));?>


<table width="60%" border="0" cellspacing="0" cellpadding="0"
	class="formFull" align="center">

	<tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Product
			Name<font color="red">*</font>
		</td>
		<td width="250"><?php echo $this->Form->input('Product.name',
				array('type'=>'text','id'=>'name', 'class'=>"textBoxExpnd validate[required]",
							 'tabindex'=>1,'div'=>false,'label'=>false));?>
		</td>

		<td width="">&nbsp;</td>

		<td width="100" class="tdLabel" id="boxSpace">Product Code </td>
		<td><?php echo $this->Form->input('Product.product_code',
				array('type'=>'text','class'=>"textBoxExpnd",'id'=>'item_code','tabindex'=>2,'div'=>false,'label'=>false));?>
		</td>

	</tr>

	<tr>
		<td class="tdLabel" id="boxSpace">Manufacturer</td>
		<td><?php echo $this->Form->input('Product.manufacturer',
				array('type'=>'text','class'=>"textBoxExpnd",'id'=>'manufacturer','tabindex'=>3,'div'=>false,'label'=>false));
		
		echo $this->Form->hidden('Product.manufacturer_id',
							array('id'=>'manufacturer_id','class'=>"",
							 'div'=>false,'label'=>false));?></td>
		
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Supplier </td>
		<td><?php echo $this->Form->input('Product.supplier_name',
				array('type'=>'text','id'=>'supplier_name','class'=>"textBoxExpnd",
							 'tabindex'=>3,'div'=>false,'label'=>false));
					echo $this->Form->hidden('Product.supplier_id',
							array('id'=>'supplier_id','class'=>"textBoxExpnd",
							 'tabindex'=>4,'div'=>false,'label'=>false));?>
		</td>
		
	</tr>
	
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Pack</td>
		<td>
			<table>
				<tr>
					<td>
						<?php echo $this->Form->input('Product.pack', array('type'=>'text','id'=>'pack','class'=>"textBoxExpnd",
							 'tabindex'=>5,'div'=>false,'label'=>false));?>
					</td>
					<td>
						<?php $doseForm = array('Pack'=>'Pack','Inj'=>'Inj','Vial'=>'vial','Syrup'=>'Syrup','Syringe'=>'Syringe'); 
						echo $this->Form->input('Product.doseForm',array('type'=>'select','autocomplete'=>"off",'tabindex'=>6,'label'=>false,'options'=>$doseForm,'style'=>"width:100%;"));
					?>
					</td>
				</tr>
			</table>
			 <!--  <input type="text" name="pack" id="pack"
			class="textBoxExpnd validate[required,custom[mandatory-enter]]"
			tabindex="3" />--></td>
		<td>&nbsp;</td>
		<td valign="middle"  class="tdLabel" id="boxSpace">Generic</td>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><?php echo $this->Form->input('Product.generic',
							array('type'=>'text', 'class'=>"textBoxExpnd",
							 'tabindex'=>7,'div'=>false,'label'=>false,'id'=>'genericName'));?> </td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<!--<td valign="middle" class="tdLabel" id="boxSpace">Description</td>
		<td><?php echo $this->Form->input('Product.description',
				array('type'=>'textarea','class'=>"textBoxExpnd",'tabindex'=>8,'div'=>false,'label'=>false));?>
			<!-- <input type="text" name="manufacturer"
			id="manufacturer" class="textBoxExpnd" tabindex="5" /> </td>
		-->
		
		<td class="tdLabel" id="boxSpace">Minimum</td>
		<td><?php echo $this->Form->input('Product.minimum',
				array('type'=>'text','id'=>'minimum','class'=>"textBoxExpnd num",
							 'tabindex'=>9,'div'=>false,'label'=>false));?> <!--<input type="text" name="minimum" id="minimum"
			class="textBoxExpnd" tabindex="4" />--></td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Maximum</td>
		<td><?php echo $this->Form->input('Product.maximum',
				array('type'=>'text','class'=>"textBoxExpnd num",'id'=>'maximum','tabindex'=>10,'div'=>false,'label'=>false));?></td>
	</tr>

	<tr>
		<td class="tdLabel" id="boxSpace">Date<font color="red">*</font></td>
					<td width=""><?php $date= $this->DateFormat->formatDate2Local($this->data['Product']['date'],Configure::read('date_format'));
					echo $this->Form->input('Product.date',
							array('type'=>'text','id'=>'date', 'class'=>"textBoxExpnd validate[required]",'value'=>$date,
							 'tabindex'=>11,'div'=>false,'label'=>false));?>
					</td>
				     <td width="">&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Location <font color="red">*</font></td>
		    <td><?php $thisLocation = $this->Session->read('locationid');
								echo $this->Form->input('Product.location_id', array('type'=>'select','class'=>"textBoxExpnd ",'id'=>'location_id','options'=>$locations,'value'=>$thisLocation,'tabindex'=>12,'div'=>false,'label'=>false));?>
		    			 </td>
   </tr>
		<tr>
		<td class="tdLabel">Expensive</td>
		<td><?php 
		echo $this->Form->input('Product.expensive_product', array('type' => 'checkbox','tabindex'=>13,'class' => '','label' => false,'legend' => false));
		?>
		</td>
		  <td width="">&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Reorder Level</td>
		    <td><?php 	echo $this->Form->input('Product.reorder_level', array('type'=>'text','class'=>"textBoxExpnd ",'id'=>'location_id','tabindex'=>14,'div'=>false,'label'=>false));?>
		    			 </td>
		
	  </tr>
		<!--<td class="tdLabel" id="boxSpace">Shelf</td>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><?php echo $this->Form->input('Product.shelf',
							array('type'=>'text', 'class'=>"textBoxExpnd validate[required]",
							 'tabindex'=>15,'div'=>false,'label'=>false));?></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>-->
	</tr>
	<tr>
		<!--<td class="tdLabel" id="boxSpace">Reorder Level <font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('Product.reorder_level',
				array('type'=>'text','id'=>'pack','class'=>"textBoxExpnd num validate[required] ",
								 'tabindex'=>16,'div'=>false,'label'=>false));?>
		
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Target Quatity</td>
		<td><?php echo $this->Form->input('Product.target',
				array('type'=>'text','id'=>'minimum','class'=>"textBoxExpnd ",
								 'tabindex'=>17,'div'=>false,'label'=>false));?>
		</td>-->
	</tr>
	<tr>
		<!--<td class="tdLabel" id="boxSpace">Quantity<font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('Product.quantity',array('type'=>'text',/*'value'=>$data['Product']['quantity'],*/ 'class'=>"textBoxExpnd validate[custom[number] validate[required] ", 'tabindex'=>16,'div'=>false,'label'=>false));?>
		</td>
		<td>&nbsp;</td>-->
		
	</tr>
	<tr>
		<!--<td valign="middle" class="tdLabel" id="boxSpace">Batch No. <font color="red">*</font></td>
		<td><?php 
		echo $this->Form->input('Product.batch_number',array('type'=>'text','id'=>"batch_number", 'class'=>"textBoxExpnd validate[required]",
							 'tabindex'=>10,'div'=>false,'label'=>false));?>
		
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Expiry Date <font color="red">*</font></td>
		<td><?php $expiry_date= $this->DateFormat->formatDate2Local($this->data['Product']['expiry_date'],Configure::read('date_format'));
		echo $this->Form->input('Product.expiry_date',array('type'=>'text','id'=>"expiry_date", 'class'=>"textBoxExpnd",
							 'value'=>$expiry_date,'tabindex'=>10,'div'=>false,'label'=>false));?>-->
	
	</tr>
	<tr>
		<!--<td valign="middle" class="tdLabel" id="boxSpace">MRP <font color="red">*</font></td>
		<td><?php echo $this->Form->input('Product.mrp',array('type'=>'text','id'=>"mrp", 'class'=>"textBoxExpnd num validate[required] ",
							 'tabindex'=>10,'div'=>false,'label'=>false));?>
		
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Tax%</td>
		<td><?php echo $this->Form->input('Product.tax',array('type'=>'text','id'=>"tax", 'class'=>"textBoxExpnd num",
							 'tabindex'=>10,'div'=>false,'label'=>false));?>-->
	
	</tr>
	<tr>
		<!--<td valign="middle" class="tdLabel" id="boxSpace">Purchase Price <font color="red">*</font></td>
		<td><?php echo $this->Form->input('Product.purchase_price',array('type'=>'text','id'=>"purchase_price", 'class'=>"textBoxExpnd num validate[required] ",
							 'tabindex'=>10,'div'=>false,'label'=>false));?>
		
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">CST</td>
		<td><?php echo $this->Form->input('Product.cst',array('type'=>'text','id'=>"cst", 'class'=>"textBoxExpnd",
							 'tabindex'=>10,'div'=>false,'label'=>false));?>-->
	
	</tr>
	<tr>
		<!--<td valign="middle" class="tdLabel" id="boxSpace">Sale Price <font color="red">*</font></td>
		<td><?php echo $this->Form->input('Product.sale_price',array('type'=>'text','id'=>"sale_price", 'class'=>"textBoxExpnd num validate[required] ",
							 'tabindex'=>10,'div'=>false,'label'=>false));?>
		
		<td>&nbsp;</td>-->
		<td class="tdLabel" id="boxSpace">Profit Percentage</td>
		<td><?php echo $this->Form->input('Product.profit_percentage',array('type'=>'text','id'=>"profit_percentage", 'class'=>"textBoxExpnd num",
							 'tabindex'=>17,'div'=>false,'label'=>false));?><?php echo __("%"); ?>
							&nbsp;  
		</td>
	</tr>
	<!--  <tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Department<font
			color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('',array('name'=>'department_id','multiple'=>false,'class'=>'validate[required] textBoxExpnd',
				'value'=>$this->request->data['Product']['department_id'],'options'=>$departments,'empty'=>'Please Select','label'=>false)); ?>
		</td>
		<td>&nbsp;</td>

	</tr>-->
	
		<?php if($this->Session->read('website.instance')=='vadodara'){?>
		
	<tr>
		<td class="tdLabel" id="boxSpace">General Ward :</td>
		<td width=""><?php echo $this->Form->input('Product.gen_ward_discount',array('type'=>'text','id'=>"gendis", 'class'=>"textBoxExpnd disc ",'autocomplete'=>'off',
							 'div'=>false,'tabindex'=>18,'label'=>false));?><?php echo __("%"); ?>&nbsp; 
		</td>
	    <td width="">&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Special Ward: </td>
		<td><?php echo $this->Form->input('Product.spcl_ward_discount',array('type'=>'text','id'=>'spcldis','class'=>"textBoxExpnd disc",'autocomplete'=>'off',
							 'div'=>false,'tabindex'=>19,'label'=>false));?><?php echo __("%"); ?>&nbsp;
		</td>
   </tr>
   
   		
	<tr>
		<td class="tdLabel" id="boxSpace">Delux Ward :</td>
		<td width=""><?php echo $this->Form->input('Product.dlx_ward_discount',array('type'=>'text','id'=>"dlxdis", 'class'=>"textBoxExpnd disc",'autocomplete'=>'off',
							 'div'=>false,'tabindex'=>20,'label'=>false));?><?php echo __("%"); ?>&nbsp;
		</td>
	    <td width="">&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Semi-Special Ward: </td>
		<td><?php echo $this->Form->input('Product.semi_spcl_ward_discount',array('type'=>'text','id'=>'semispldis','class'=>"textBoxExpnd disc",'autocomplete'=>'off',
							 'div'=>false,'tabindex'=>21,'label'=>false));?><?php echo __("%"); ?>&nbsp;
		</td>
   </tr>

   <tr>
		<td class="tdLabel" id="boxSpace">Isolation Ward :</td>
		<td width=""><?php echo $this->Form->input('Product.islolation_ward_discount',array('type'=>'text','id'=>"isodis", 'autocomplete'=>'off','class'=>"textBoxExpnd disc ",
							 'div'=>false,'tabindex'=>22,'label'=>false));?><?php echo __("%"); ?>&nbsp;
		</td>
		 <td width="">&nbsp;</td>
	    <td class="tdLabel" id="boxSpace">OPD General :</td>
		<td ><?php echo $this->Form->input('Product.opdgeneral_ward_discount',array('type'=>'text','id'=>"opdgendis", 'autocomplete'=>'off','class'=>"textBoxExpnd disc ",
							 'div'=>false,'tabindex'=>23,'label'=>false));?><?php echo __("%"); ?>&nbsp;</td>
		<td>
		</td>
   </tr>
<?php }?>
	
</table>
<!-- billing activity form end here -->
<div class="btns">
	<input name="" type="submit" value="Submit" class="blueBtn submit"
		id="submit" tabindex="24" />
	<?php
	echo $this->Html->link(__('Cancel'), array('controller'=>'Store','action'=>'index'), array('escape' => false,'class'=>'blueBtn cancel'));
	?>
</div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>

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
	profitPercentage();
	
$('#name').focus();
$('#supplier_name').autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
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

$("#date").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,
	yearRange: '1950',
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
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

$('.cancel, .back').click(function(){
	window.location.href="<?php echo $this->Html->url(array("controller"=>'Store','action'=>'index'));?>"
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

function profitPercentage()
{
	percent = $("#profit_percentage").val();
	//percent = parseInt($(this).val());
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
}

$("#profit_percentage").keyup(function(){
	profitPercentage();
});

$(document).on('input',".disc",function() { 
	if (/[^0-9.]/g.test(this.value))
    {
    	this.value = this.value.replace(/[^0-9.]/g,'');
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


</script>
