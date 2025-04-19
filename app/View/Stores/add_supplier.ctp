
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PharmacyItemInventoryAddSupplierForm").validationEngine();
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
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Store Management - Add Supplier', true); ?>
	</h3>
	<!-- to open fancy box without back btn -->
	<?php if($flagForBack!=1){?>
	<span style="padding-right: 40px;padding-top: 10px;"> <?php 
	echo $this->Html->link(__('Back'), array('action' => 'supplierList' ,'inventory'=>false), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
	<?php } ?>
	<!-- end -->
<div class="clr ht5"></div>
</div>

<div class="clr ht5"></div>
<?php echo $this->Form->create('PharmacyItem');?>
<table align="center" width="95%"  border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Supplier
			Name<font color="red">*</font>
		</td>
		<td width="250"><input type="text" name="InventorySupplier[name]"
			id="name" class="textBoxExpnd validate[required]" tabindex="1" /></td>
		<td width="">&nbsp;</td>
		<td width="100" class="tdLabel" id="boxSpace">CST<font color="red">*</font>
		</td>
		<td width="250">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><input type="text" name="InventorySupplier[cst]" id="cst"
						class="textBoxExpnd validate[required,custom[onlyNumber]]"
						tabindex="2" /></td>

				</tr>
			</table>
		</td>
	</tr>

	<tr>


		<td class="tdLabel" id="boxSpace">Supplier Code<font color="red">*</font>
		</td>
		<td><input type="text" name="InventorySupplier[code]" id="code"
			class="textBoxExpnd validate[required]" tabindex="13" readonly="true"
			value="<?php echo $code;?>" /></td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">S. Tax No.<font color="red">*</font>
		</td>
		<td><input type="text" name="InventorySupplier[stax_no]" id="stax_no"
			class="textBoxExpnd validate[required,custom[onlyNumber]]"
			tabindex="4" /></td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace"> Supplier Type</td>
		<td>
		<?php 
		    echo $this->Form->input('InventorySupplier.supplier_type',array('empty'=>'Please select',
			'options'=>array('Manufacturers and Vendors'=>'Manufacturers and Vendors','Wholesalers and Distributors'=>'Wholesalers and Distributors',
						'Affiliate Merchants'=>'Affiliate Merchants','Franchisors'=>'Franchisors','Importers and exporters'=>'Importers and exporters',
						'Independent crafts people'=>'Independent crafts people','Dropshippers'=>'Dropshippers'),
			'id' => 'supplier_type', 'label'=> false,'style'=> 'width:200px'));
		    
		 ?>
		</td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">Phone</td>
		<td><input type="text" name="InventorySupplier[phone]" id="phone"
			class="textBoxExpnd validate[custom[phone]]" tabindex="5" /></td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Address</td>

		<td width=""><textarea name="InventorySupplier[address]" type="text"
				class="textBoxExpnd" id="address" tabindex="6"> </textarea></td>
	</tr>

	<tr>

		<td class="tdLabel" id="boxSpace">Credit Limit<font color="red">*</font>
		</td>
		<td><input type="text" name="InventorySupplier[credit_limit]"
			id="credit_limit"
			class="textBoxExpnd validate[required,custom[onlyNumber]]"
			tabindex="7" /></td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Credit Day<font color="red">*</font>
		</td>

		<td width=""><input name="InventorySupplier[credit_day]" type="text"
			class="textBoxExpnd validate[required,custom[onlyNumber]]"
			id="credit_day" tabindex="8">
		</td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">Email</td>
		<td><input type="text" name="InventorySupplier[email]" id="email"
			class="textBoxExpnd validate[custom[email]]" tabindex="9" /></td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Bank or Branch</td>

		<td width=""><input name="InventorySupplier[bank]" type="text"
			class="textBoxExpnd" id="bank" tabindex="10">
		</td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">Pin</td>
		<td><input type="text" name="InventorySupplier[pin]" id="pin"
			class="textBoxExpnd " tabindex="11" /></td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Mobile</td>

		<td width=""><input name="InventorySupplier[mobile]" type="text"
			class="textBoxExpnd validate[custom[phone]]" id="mobile"
			tabindex="12">
		</td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">DL. No.<font color="red">*</font>
		</td>
		<td><input type="text" name="InventorySupplier[dl_no]" id="dl_no"
			class="textBoxExpnd validate[required,custom[onlyNumber]]"
			tabindex="13" value="" /></td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">Account Group<font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('InventorySuppiler.accounting_group_id',array('type'=>'select','options'=>$group,'class'=>'validate[required]','label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select'))?></td>
	</tr>
</table>

<!-- billing activity form end here -->
<div style="padding-right: 40px;"
	class="btns">
	<!--  <input name="" type="button" value="Print" class="blueBtn" tabindex="11"/>-->
	<input name="" type="submit" value="Submit" class="blueBtn"
		tabindex="11" />

</div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>


<!-- Right Part Template ends here -->
</td>
</table>

<script>

// TO CLOSE ADD SUPPLIER WINDOW - BY MRUNAL
$(document).ready(function(){	
	
	if('<?php echo $setFlash ?>' == '1'){
	
	parent.$.fancybox.close();
	
}
});
// EOC

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
                "onlyLetter": {
                    "regex":"^[a-zA-Z]+$", 
                    "alertText": "* Invalid Name"
                },
				"onlyNumber": {
                    "regex":"[1-9][0-9]*|0", 
                    "alertText": "* Invalid Data"
                },
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);</script>
