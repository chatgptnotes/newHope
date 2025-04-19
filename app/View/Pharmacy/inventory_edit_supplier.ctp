<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PharmacyItemInventoryAddSupplierForm").validationEngine();
	});
	
</script>
<style> 
textarea{ width:146px;}
</style>
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
		<?php echo __('Pharmacy Management - Edit Supplier', true); ?>
	</h3>
	<span> <?php 
	echo $this->Html->link(__('Back'), array('action' => 'supplier_list' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>

</div>

<div class="clr ht5"></div>
<?php echo $this->Form->create('PharmacyItem');?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
       <td>
         <table width="67%">
          <tr>
		<td width="59" valign="middle" class="tdLabel" id="boxSpace">Supplier
			Name<font color="red">*</font>
		</td>
		<td width="138"><input type="text" name="InventorySupplier[name]"
			id="name" class="textBoxExpnd validate[required]" tabindex="1"
			value="<?php echo $data['InventorySupplier']['name'];?>" /></td>
		
		<td width="59" class="tdLabel" id="boxSpace">CST<font color="red">*</font>
		</td>
		<td width="138">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><input type="text" name="InventorySupplier[cst]" id="cst"
						class="textBoxExpnd validate[required]" tabindex="8"
						value="<?php echo $data['InventorySupplier']['cst'];?>" /></td>

				</tr>
			</table>
		</td>
	</tr>

	<tr>

		<td class="tdLabel" id="boxSpace">Supplier Code<font color="red">*</font>
		</td>
		<td><input type="text" name="InventorySupplier[code]" id="code"
			class="textBoxExpnd validate[required]" tabindex="3"
			value="<?php echo $data['InventorySupplier']['code'];?>"
			readonly="true" /></td>
		
		<td class="tdLabel" id="boxSpace">S. Tax No.<font color="red">*</font>
		</td>
		<td><input type="text" name="InventorySupplier[stax_no]" id="stax_no"
			class="textBoxExpnd validate[required]" tabindex="8"
			value="<?php echo $data['InventorySupplier']['stax_no'];?>" /></td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace"> Supplier Type</td>
		<td>
		<?php 
		    echo $this->Form->input('InventorySupplier.supplier_type',array('empty'=>$data['InventorySupplier']['supplier_type'],
			'options'=>array('Manufacturers and Vendors'=>'Manufacturers and Vendors','Wholesalers and Distributors'=>'Wholesalers and Distributors',
						'Affiliate Merchants'=>'Affiliate Merchants','Franchisors'=>'Franchisors','Importers and exporters'=>'Importers and exporters',
						'Independent crafts people'=>'Independent crafts people','Dropshippers'=>'Dropshippers', ),
			'id' => 'supplier_type', 'label'=> false,'style'=> 'width:200px'));
		    
		 ?>
		</td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">Phone</td>
		<td><input type="text" name="InventorySupplier[phone]" id="phone"
			class="textBoxExpnd validate[custom[phone]]" tabindex="7"
			value="<?php echo $data['InventorySupplier']['phone'];?>" /></td>
		
		<td class="tdLabel" id="boxSpace">Address</td>

		<td width=""><textarea name="InventorySupplier[address]" type="text"
				class="" id="address" tabindex="6">
				<?php echo $data['InventorySupplier']['address'];?>
			</textarea></td>
	</tr>

	<tr>

		<td class="tdLabel" id="boxSpace">Credit Limit<font color="red">*</font>
		</td>
		<td><input type="text" name="InventorySupplier[credit_limit]"
			id="credit_limit" class="textBoxExpnd validate[required]"
			tabindex="7"
			value="<?php echo $data['InventorySupplier']['credit_limit'];?>" /></td>
		
		<td class="tdLabel" id="boxSpace">Credit Day<font color="red">*</font>
		</td>

		<td width=""><input name="InventorySupplier[credit_day]" type="text"
			class="textBoxExpnd validate[required]" id="credit_day" tabindex="8"
			value="<?php echo $data['InventorySupplier']['credit_day'];?>">
		</td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">Email</td>
		<td><input type="text" name="InventorySupplier[email]" id="email"
			class="textBoxExpnd validate[custom[email]]" tabindex="9"
			value="<?php echo $data['InventorySupplier']['email'];?>" /></td>
		
		<td class="tdLabel" id="boxSpace">Bank or Branch</td>

		<td width=""><input name="InventorySupplier[bank]" type="text"
			class="textBoxExpnd" id="bank" tabindex="10"
			value="<?php echo $data['InventorySupplier']['bank'];?>">
		</td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">Pin</td>
		<td><input type="text" name="InventorySupplier[pin]" id="pin"
			class="textBoxExpnd " tabindex="11"
			value="<?php echo $data['InventorySupplier']['pin'];?>" /></td>
		
		<td class="tdLabel" id="boxSpace">Mobile</td>

		<td width=""><input name="InventorySupplier[mobile]" type="text"
			class="textBoxExpnd validate[custom[phone]]" id="mobile"
			tabindex="12"
			value="<?php echo $data['InventorySupplier']['mobile'];?>">
		</td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">DL. No.<font color="red">*</font>
		</td>
		<td><input type="text" name="InventorySupplier[dl_no]" id="dl_no"
			class="textBoxExpnd validate[required]" tabindex="13"
			value="<?php echo $data['InventorySupplier']['dl_no'];?>" /></td>
		<td class="tdLabel" id="boxSpace"> <?php echo __('Is Implant',true); ?>
		</td>
		<td><?php 
		echo $this->Form->checkbox('InventorySupplier.is_implant',array('id'=>'is_implant','class'=>'','legend' => false,'checked'=>$data['InventorySupplier']['is_implant']));
		?>
		</td>
	</tr>
	<tr>

		<td class="tdLabel" id="boxSpace">Account Group</td>
		<td><?php 
		if(empty($this->data['InventorySupplier']['accounting_group_id']) || $this->data['InventorySupplier']['accounting_group_id']=='0'){
			$Id = $groupId;
		}else{
			$Id = $this->data['InventorySupplier']['accounting_group_id'];
		}
		 echo $this->Form->input('InventorySupplier.accounting_group_id',array('type'=>'select','options'=>$group,'value'=>$Id,'id'=>'group_id','label'=> false, 'div' => false, 'error' => false,'class'=>'validate[required,custom[mandatory-select]]','empty'=>'Please Select'))?></td>
	</tr>
	  <tr>
		<th class="tdLabel" id="boxSpace" colspan="5">Bank account details<?php echo $this->Form->hidden('HrDetail.id',array('id'=>'HrDetailId','value'=>$hrDetails['HrDetail']['id']));?></th>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Bank name</td>
		<td><?php echo $this->Form->input('HrDetail.bank_name', array('label'=>false,'div'=>false,'id' => 'bank_name','class'=> 'textBoxExpnd','value'=>$hrDetails['HrDetail']['bank_name'])); ?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Bank Branch</td>
		<td><?php echo $this->Form->input('HrDetail.branch_name', array('label'=>false,'id' => 'branch_name','class'=>'textBoxExpnd','value'=>$hrDetails['HrDetail']['branch_name'])); ?>
		</td>			
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Account number</td>
		<td><?php echo $this->Form->input('HrDetail.account_no', array('type'=>'text','label'=>false,'id' => 'account_no','class'=>'textBoxExpnd validate["",custom[onlyNumber]]','value'=>$hrDetails['HrDetail']['account_no'])); ?></td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">IFSC Code</td>
		<td><?php echo $this->Form->input('HrDetail.ifsc_code', array('type'=>'text','label'=>false,'id' => 'ifsc_code','class'=>'textBoxExpnd','maxlength'=>'11','value'=>$hrDetails['HrDetail']['ifsc_code'])); ?></td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Bank pass book copy obtained</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.pass_book_copy', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['pass_book_copy'])); ?>
		</td>
	</tr>
  
	<tr>
		<td class="tdLabel" id="boxSpace">NEFT authorization received</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.neft_authorized_received', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['neft_authorized_received'])); ?>
		</td>
	</tr>  		
	<tr>
		<td class="tdLabel" id="boxSpace">PAN</td>
		<td><?php 	echo $this->Form->input('HrDetail.pan', array( 'id' => 'pan','type'=>'text', 'selected'=>'84', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd','value'=>$hrDetails['HrDetail']['pan']));?>
		</td>
	</tr> 
    </table>
    </td>
    </tr>    
</table>

<!-- billing activity form end here -->
<div
	class="btns">
	<!--  <input name="" type="button" value="Print" class="blueBtn" tabindex="11"/>-->
	<input name="" type="submit" value="Submit" class="blueBtn"
		tabindex="12" />

</div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>


<!-- Right Part Template ends here -->
</td>
</table>

<script>

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
})(jQuery);</script>
