<?php echo $this->Html->script(array('jquery.blockUI'));
$referral = $this->request->referer();
echo $this->Form->hidden('formReferral',array('value'=>'','id'=>'formReferral'));?>
<style>
	.blue-row{
		background-color:#D9D9D9;
	}
	.ho:hover{
		background-color:#C1BA7C;
	}
		
	.textBoxExpnd  {
	    background: -moz-linear-gradient(center top , #f1f1f1, #fff) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
	    border: 1px solid #214a27;
	    color: #000;
	    float: left;
	    font-size: 13px;
	    height: 15px;
	    line-height: 20px;
	    outline: 0 none;
	    resize: none;
	    width: 90.3%;
	}
</style>
<div class="inner_title" >
	<?php echo $this->element('pharmacy_menu');?>
	<h3>Direct Sales Bill</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	//echo $this->Html->link(__('Add Product'),'javascript:void(0)',array('escape'=>false,'class'=>'blueBtn','id'=>'addProduct'));
	?> </span>
</div>

<script>

	$(document).ready(function(){
            getPaymentMode();
		var print="<?php echo isset($this->params->query['print'])?$this->params->query['print']:'' ?>"; 
		var referral = "<?php echo $referral ; ?>" ;	
		if(print && referral != '/' && $("#formReferral").val()==''){ 
			$("#formReferral").val('yes') ;
			var url="<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'inventory_print_view','PharmacySalesBill',$_GET['id'],'?'=>"flag=header")); ?>";
		    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready
		}	
	});

	
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#InventoryPurchaseDetail").validationEngine();
		$('#InventoryPurchaseDetail').validationEngine('hideAll');
	});

	$(document).on('click',"#submitButton",function(){ 
		var valid = jQuery("#InventoryPurchaseDetail").validationEngine('validate'); 
		if(valid == true){
			$("#submitButton").hide();
		}else{
			return false;
		}
	});
	
	/*jQuery(document).ready(function(){
		jQuery("#PharmacyItem").validationEngine();
	});*/

</script>
<style>
.formErrorContent {
	width: 43px !important;
}
.inner_title{
	padding-bottom: 0px;
}
.table_format {
    padding: 10px;
}
.tdLabel2 {
	width: 125px;
}
</style>


<?php
//echo $this->Html->script('jquery.autocomplete_pharmacy');
//echo $this->Html->css('jquery.autocomplete.css');

echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
echo $this->Html->script('pharmacy_sales');
?>

<div class="clr ht5"></div>
<?php echo $this->Form->create('InventoryPurchaseDetail',array('onkeypress'=>"return event.keyCode != 13;",'id'=>'InventoryPurchaseDetail','inputDefaults'=> array('div'=>false,'label'=>false)));?>

<table width="80%" cellpadding="0" cellspacing="5" border="0">
    <tr>
        <td colspan="8">
            <?php echo $this->Form->hidden('',array('name'=>'is_staff','id'=>'is_staff')); ?>
        </td>
    </tr>
    <tr  style="display: none;" >
        <td><?php echo __('Search Emp Id : ');?><font color="red">*</font>:</td>
        <td><?php echo $this->Form->input('PharmacyItem.cust_name',array('id'=>'patient','label'=>false,'div'=>false,'type'=>'text','autofocus'=>'autofocus','autocomplete'=>'off',
                        'class' => ' validate[required]','tabindex'=>"1",'id'=>'staff_name'));
         ?></td>
        
    </tr> 
    <tr><td><?php echo 'For Hope Employee :'.$this->Form->input('emp_code',array('type'=>'checkbox','id'=>'emp_code','div'=>false,'label'=>false)); ?></td>

    </tr>
    <tr>
		<td><?php echo __('Name');?><font color="red">*</font>:</td>
		<td><?php echo $this->Form->input('PharmacyItem.cust_name',array('id'=>'patient','label'=>false,'div'=>false,'type'=>'text','autofocus'=>'autofocus','autocomplete'=>'off',
				'class' => ' validate[required]','tabindex'=>"1"));
				echo $this->Form->hidden('Patient.patient_id',array('id'=>'patient_id'));
                echo $this->Form->hidden('Patient.account_id',array('id'=>'account_id')); ?></td>
        <td class="accountDetailBlock" style="display: none;"><?php echo __('Employee Name : '); echo $this->Form->hidden('PharmacyItem.customer_name',array('id'=>'customer_name')); ?> </td>
        <td id="emp_name" style="display: none;"></td>	
		
	</tr> 
	<tr class="patientDetailBlock">
            <?php if($websiteConfig['instance']=='kanpur'){ ?>
		<td><?php echo __('Date: ');?></td>
		<td><?php $currentDate = date('d/m/Y'); 
				echo $this->Form->input('PharmacySalesBill.m_date', array('type'=>'text','readonly'=>'readonly','class' => 'textBoxExpnd','id' => 'date','style'=>"width:110px",'value'=>$currentDate));
				?>
		</td>
		<?php }?>
  		<td><?php echo __('Date of Birth: ');?></td>
		<td>
			<?php 
				echo $this->Form->input('PharmacySalesBill.p_dob', array('type'=>'text','style'=>'width:110px','readonly'=>'readonly','size'=>'20','class' => 'textBoxExpnd','id' => 'dob',));
			?>
		</td>
		<td><?php echo __('Age: ');?></td>
		<td>
			<?php echo $this->Form->input('PharmacySalesBill.c_age', array('type'=>'text','style'=>'width:40px; float: none' , 'class' => 'textBoxExpnd','id' => 'age'));
			?>
			</td>
		<td><?php echo __('Gender:');?></td>
		<td>
			<?php  
				echo $this->Form->input('PharmacySalesBill.gender', array('options'=>array(""=>__('Select gender'),"male"=>__('Male'),'female'=>__('Female')),'class' => '','id' => 'gender')); ?>
		</td> 
		
		<td><?php echo __('Address :');?></td>
		<td>
			<input name="PharmacySalesBill[p_address]" type="text" id="custaddr"  autocomplete="off" class="" />
		</td>
			
		<td><?php echo __('Doctor Name :');?><font color="red">*</font>:</td>
		<td>
			<input name="PharmacySalesBill[p_doctname]" type="text" id="doctname" class=" validate[required]" autocomplete="off" tabindex="2"/>
		</td>
	</tr>
</table>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="table_format" id="item-row">
		<tr><td></td><td colspan="2"><font color="#ff343"><i>(MSU = Minimum Saleable Unit)</i></font></td></tr>
		<tr class="row_title" style="border:1pt solid black;">
		<td width="50" align="center" class="table_cell" valign="top" style="text-align: center;">Item Code</td>
		<td width="180" align="center" valign="top" class="table_cell" 	style="text-align: center;">Item Name<font color="red">*</font>	</td>
		<td width="110" valign="top" class="table_cell" style="text-align: center;">Quantity<font color="red">*</font></td>
		<!-- <td width="120" align="center" valign="top" class="table_cell" style="text-align: center;">Manufacturer</td> -->
		<td width="30" valign="top" style="text-align: center;" class="table_cell">Pack</td>
		<td width="80" align="center" valign="top" style="text-align: center;" class="table_cell">Batch No.<font color="red">*</font>	</td>
		<td width="80" align="center" valign="top" style="text-align: center;" class="table_cell">Stock</td>
		<td width="150" align="center" valign="top"	style="text-align: center;" class="table_cell">Expiry Date<font color="red">*</font></td>
		<?php if($websiteConfig['instance']=='kanpur'){ ?>
		<td width="50" valign="top" style="text-align: center;" class="table_cell">MRP</td>
		<td width="90" valign="top" style="text-align: center;" class="table_cell">Class Of Vat</td>
		<?php }else{?>
			<td width="50" valign="top" style="text-align: center;" class="table_cell">MRP<font color="red">*</font></td>
		<?php	}?>
		<td width="50" valign="top" style="text-align: center;" class="table_cell">Price<font color="red">*</font>	</td>
		<td width="50" valign="top" style="text-align: center;" class="table_cell">Amount<font	color="red">*</font></td>
		<td width="10" style="text-align: center;" class="table_cell">#</td>
	</tr>
	<?php $cnt = 1; $grossAmount = 0;?>
	<?php if(empty($pharmacyData)){ //to add direct items in sales bill  ?>
	<input type="hidden" value="1" id="no_of_fields" />
	<tr id="row1" class="row_gray ho" >	
		<td align="center" valign="middle"><input name="item_code[]"
			type="text" class="textBoxExpnd item_code"
			id="item_code1" value="" style="width: 100%;" fieldNo="1"
			onkeyup="checkIsItemRemoved(this)" autocomplete="off"/> <input name="item_id[]"
			id="item_id1" type="hidden" tabindex="6" value="" style="width: 80%;" />
		</td>
		<td align="center" valign="middle" width="185"><input
			name="item_name[]" type="text" tabindex="3"
			class="textBoxExpnd validate[required] item_name" id="item_name-1"
			 value="" style="width: 90%;" fieldNo="1"
			onkeyup="checkIsItemRemoved(this)" autocomplete="off" /> 
			<!--<a href="#" id="viewDetail1"
			class='fancy' style="visibility: hidden"><img title="Remove Item"
				alt="View Item" src="<?php echo Router::url("/");?>/img/icons/view-icon.png">
				 </a>
		--></td>
			
		
		<td valign="middle" style="text-align: center;">
			<table>
				<tr>
					<td>
						<input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" id="qty_1" value="" readonly=true
							style="width:100%;" fieldNo="1" /> 
						<input type="hidden" id="stockQty" value="0" autocomplete="off" />
					</td>
					<td>
						<?php 
   							echo $this->Form->input('PharmacySalesBill.item_type', array('style'=>'width:60px;','name'=>"itemType[]",'class'=>'itemType',
   								'div' => false,'fieldNo'=>"1",'label' => false,'autocomplete'=>'off','id' => 'itemType_'.$cnt,
   								'options'=>array('Tab'=>'MSU'/*,'Pack'=>'Pack','Unit'=>'Unit'*/))); 
						?>
					</td>
				</tr>
			</table>
		</td>
		
		<!--  <td align="center" valign="middle"><input name="manufacturer[]"
			type="text" class="textBoxExpnd " id="manufacturer1" tabindex="7"
			value="" style="width: 100%;" readonly="true" autocomplete="off" /></td>-->
		<td align="center" valign="middle"><input name="pack[]" type="text"
			class="textBoxExpnd " id="pack1" tabindex="8" value=""
			style="width: 100%;" readonly="true" autocomplete="off"/></td>
		<td>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>'','class'=>'textBoxExpnd validate[required] batch_number','id'=>'batch_number1', 'style'=>"width: 100%",'autocomplete'=>"off" ,"fieldNo"=>"1",'label'=>false,'name'=>"data[pharmacyItemId][]")); ?>
		
		</td>

		<!--<td valign="middle" style="text-align: center;"><label name="stok[]"
			type="hidden"  value="" style="width: 10px;" fieldNo="1" tabindex="10" /> 
			<input type="" id="stockQty1" value="0" readonly="true" style="width: 60px;" />	
		</td>-->
		
		<td valign="middle" style="text-align: center;">
		<table width="100%">
			<tr>
				<td><input type="text" id="stockWithLoose_1" name="stockWithLoose[]" fieldNo="1" class="textBoxExpnd" value="0" readonly="true" />
				<input type="hidden" id="stockQty1" name="stok[]" fieldNo="1" class="textBoxExpnd" value="0" readonly="true" />
				<input type="hidden" id="looseStockQty1" class="textBoxExpnd" value="0" readonly="true" /></td>
			</tr>
		</table>
		</td>
		<?php if($websiteConfig['instance']=='kanpur'){?>	
		<td valign="middle" style="text-align: center;"><input
			name="expiry_date[]" type="text"
			class=" textBoxExpnd " id="expiry_date1"
			 value="" style="width: 80%;"
			autocomplete="off" readonly="true" /></td>

		<td valign="middle" style="text-align: center;"><input name="mrp[]"
			type="text" class="textBoxExpnd mrp" id="mrp1"
			 fieldNo="1" value="" style="width: 100%;" autocomplete="off" readonly="true"/></td>
		<?php }else{ ?>
		<td valign="middle" style="text-align: center;"><input
			name="expiry_date[]" type="text"
			class="validate[future[NOW]] textBoxExpnd expiry_date"
			id="expiry_date1"  value="" style="width: 80%;"
			autocomplete="off" readonly="true" /></td>
		<td valign="middle" style="text-align: center;"><input name="mrp[]"
			type="text" class="textBoxExpnd validate[required,number] mrp" id="mrp1"
			 fieldNo="1" value="" style="width: 100%;" autocomplete="off" readonly="true"/></td>
		<?php }?>
		<?php if($websiteConfig['instance']=='kanpur'){ ?>
			<td valign="middle" style="text-align: center;"><input name="vat_class_name[]"
			type="text" class="textBoxExpnd" id="vat_class_name1"
			 value="" style="width: 90%;" /><input name="vat[]"
			type="hidden" class="textBoxExpnd" id="vat1"
			 value="" style="width: 90%;" /></td>
			
		<?php } ?>

		<td valign="middle" style="text-align: center;"><input name="rate[]"
			type="text" class="textBoxExpnd validate[required,number] rate" id="rate1"
			value="" style="width: 100%;" autocomplete="off" readonly="readonly"/></td>
			
		<td valign="middle" style="text-align: center;"><input name="value[]"
			type="text" class="textBoxExpnd validate[required,number] value"  readonly="readonly"
			id="value1" value="" style="width: 100%;" autocomplete="off"  readonly="true"/></td>
		<td valign="middle" style="text-align: center;"><a href="javascript:void(0);"
			id="delete row" onclick="deletRow('1');"><?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?> </a></td>
	</tr>
	<?php $cnt++;?>
	<?php }?>
	
</table>
<div class="clr ht5"></div>
<div align="left">
	<input name="" type="button" value="Add More" class="blueBtn Add_more"
		 onclick="addFields()" />
		 <!--<input name="" type="button"
		value="Remove" id="remove-btn" class="blueBtn" 
		onclick="removeRow()" style="display: none" />-->
</div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="70%"><?php echo __("Payment Mode:");?><font color="red" >*</font>
		<?php 
		 	echo $this->Form->input('PharmacySalesBill.payment_mode', array('class' => 'validate[required]','style'=>'width:141px;', 'type'=>'select',
   				'div' => false,'label' => false,/*'empty'=>__('Please select'),*/'autocomplete'=>'off',
   				'options'=>$mode_of_payment,
				'value'=>!empty($editSales['PharmacySalesBill']['payment_mode'])?$editSales['PharmacySalesBill']['payment_mode']:"Cash",'id' => 'payment_mode')); 
		?> 
   		</td>
   		<td></td>
   		<td></td>
   		<td></td>
	   	<td style="float: right;"><?php echo __('Total Amt :');?><?php echo  $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
		    <span id="total_amount">
				<?php echo !empty($editSales['PharmacySalesBill']['total'])?$editSales['PharmacySalesBill']['total']:$totalAmForEachMed; ?>
			</span>
				<input name="PharmacySalesBill[total]" id="total_amount_field" autocomplete='off'  value="<?php echo !empty($editSales['PharmacySalesBill']['total'])?$editSales['PharmacySalesBill']['total']:$totalAmForEachMed; ;?>" type="hidden" /> 
		</td>
   	</tr>
   	<tr class="clr ht5"></tr>
   	<tr>
   	<?php  if(!empty($websiteConfig['instance']) && $websiteConfig['instance']=='kanpur'){ ?>	
   
   		
   		<!--  <table>
   				<tr>
   				<td style="width:95px"><?php echo __("Is Discount:");?></td> 
   			<?php if(!empty($editSales['PharmacySalesBill']['discount'])){
   				$discount = $editSales['PharmacySalesBill']['discount'];
   				$checked = "checked";
   			}else{
   				$discount = 0;		
   			}
   			?>
			<td><?php echo $this->Form->input('PharmacySalesBill.is_discount',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'isDiscount','checked'=>$checked))?></td>-->
		
	   	<td id="showDiscount">
	   		<table width="40%">
	   			<tr>
	   				<td>
	   					<?php $discount=array('Amount'=>"Amount",'Percentage'=>"Percentage");
							echo $this->Form->input('PharmacySalesBill.discount_type', array('id' =>'discountType','options' => $discount,
								'readonly'=>false,'legend' =>false,'label' => false,'div'=>false,'class'=>'discountType',
								'type' => 'radio','separator'=>'&nbsp;','default'=>'Percentage','disabled'=>false )); ?>
	   				</td>
	   				<td>:</td>
	   				<td>
	   					<input name="data[PharmacySalesBill][input_discount]" type="text" autocomplete='off' class="textBoxExpnd" id="inputDiscount" style="width: 70%" value="<?php echo $editSales['PharmacySalesBill']['discount'];?>" /> 
	   					<input name="PharmacySalesBill[discount]" id="discount" type="hidden" />
	   				</td>
	   			</tr>
	   		</table>
	   	</td>
	   	<?php }?>
   		<td></td>
   		<td></td>
   		<td></td>
   		<td style="float: right;">
   		<?php echo __('Net Amt :');?><?php echo  $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
	    	<span id="net_amount">
	    		<?php echo !empty($editSales['PharmacySalesBill']['total'])?$editSales['PharmacySalesBill']['total']-$editSales['PharmacySalesBill']['discount']:$totalAmForEachMed; 
	    		?>
	    	</span> 
		</td>
	</tr>
	
	<tr>
		<tr id="paymentInfoCreditCard" style="display:none">
	  	 <td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%" > 
			    <tr>
				    <td>Bank Name</td>
				    <td><?php echo $this->Form->input('PharmacySalesBill.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_paymentInfoCreditCard',"autocomplete"=>'off'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('PharmacySalesBill.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfoCreditCard',"autocomplete"=>'off'));?></td>
				</tr>
				    <tr>
				    <td>Cheque/Credit Card No.</td>
				    <td><?php echo $this->Form->input('PharmacySalesBill.credit_card_no',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number',"autocomplete"=>'off'));?></td>
			    </tr>
			</table>
	    </td>
   </tr>
   <tr id="neft-area" style="display:none;">
	  	<td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%"> 
			    <tr>
				    <td width="47%">Bank Name</td>
				    <td><?php echo $this->Form->input('PharmacySalesBill.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_neftArea',"autocomplete"=>'off'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('PharmacySalesBill.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea',"autocomplete"=>'off'));?></td>
				</tr> 
			    <tr>
				    <td>NEFT No.</td>
				    <td><?php echo $this->Form->input('PharmacySalesBill.neft_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number',"autocomplete"=>'off'));?></td>
				</tr>
				    <tr>
				    <td>NEFT Date</td>
				    <td><?php echo $this->Form->input('PharmacySalesBill.neft_date',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_date','style'=>'width:150px;',"autocomplete"=>'off'));?></td>
				</tr>
		    </table>
	    </td>
  </tr> 
		<tr> 	
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		</tr>
	<tr>
        <td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>	
		

	</tr>
</table>
<div class="btns">
<!-- 	<input name="print" type="submit" value="Print" class="blueBtn" tabindex="36" /> -->
<input name="submit" type="submit" value="Submit" class="blueBtn" tabindex="37" id="submitButton" /> 
	<?php echo $this->Form->end();?>
</div>
</div>
<script>
var instance = "<?php echo strtolower($this->Session->read('website.instance')); ?>"
 
$(document).ready(function(){ 
	if($('#emp_code').is(':checked')){
		var autoUrl="<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "employeeAutocomplete","admin" => false,"plugin"=>false)); ?>";
	}else{
		var autoUrl="<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Account","name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>";
	}
	$( "#patient").autocomplete({
		 source: autoUrl,
		 minLength: 1,
		 select: function( event, ui ) {
			$('#patient_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	}); 
	// Autocomplet if satff check selected -show only satff othrewise 
	$( "#patient" ).keyup(function(){
            //if text is numeric then only autocomplete for emp id
            if($(this).val() == '' ){
                $("#is_staff").val('0');
                staffCheck();
            }
            if(isNumeric($(this).val()) == true){
                $(this).autocomplete({
                    source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Account","name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>",
                    minLength: 1,
                    select: function( event, ui ) {
                           $('#patient_id').val(ui.item.id);
                    },
                    messages: {
                           noResults: '',
                           results: function() {},
                    }
                });
                $(this).autocomplete({
                    source: "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "employeeAutocomplete","admin" => false,"plugin"=>false)); ?>",
                    minLength: 1, 
                    select: function( event, ui ) { 
                        $("#emp_name").text(ui.item.name);
                        $("#account_id").val(ui.item.id);
                        $("#customer_name").val(ui.item.name); 
                        $("#is_staff").val('1');
                        staffCheck();
                    },
                        messages: {
                        noResults: '',
                        results: function() {}
                    }	
                });
            }else{
                 $(this).autocomplete("destroy");
            }
        });

 

   //checking for paymetn mode option and there respetuve fields to display on page load 
	
	/*if($("#payment_mode").val() == 'Credit'){
		 $("#paymentInfo").show();
	} 
	$("#BN_paymentInfo").on('keyup change blur',function(){
		
		$("#BN_neftArea").val($(this).val());
		 
	});
	$("#AN_paymentInfo").on('keyup change blur',function(){
		$("#AN_neftArea").val($(this).val());
	});
	$("#card_check_number").on('keyup change blur',function(){
		$("#card_neftArea").val($(this).val());
	});*/

	//EOF payment laod
	$('#payment_mode').change(function(){
		 if($("#payment_mode").val() == 'Cash'){
			$("#showDiscountDetails").show();
		}else if($("#payment_mode").val() == 'Credit'){
			$("#showDiscountDetails").hide();
		}
	});
	
	if ($("#isDiscount").attr('checked')) {
		$("#showDiscount").show();
	}
	
	isInStock=new Array();  // variable for check the item is in stock or not.
	itemAutoComplete("item_name-1");	//for initial autocomplete
	
  

	$(".item_code").on('focus',function(){
			var t = $(this);
			$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "autocomplete_item","item_code","inventory" => true,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,
				cacheLength:10,
				onItemSelect:function (data1) {
					selectedId = t.attr('id');
					selectItem(data1,selectedId);
				},
				autoFill:false
			});
	  });
});


/*$('#patient').focus(function(){
	if($('#emp_code').is(':checked')){
		var autoUrl="<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "employeeAutocomplete","admin" => false,"plugin"=>false)); ?>";
	}else{
		var autoUrl="<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Account","name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>";
	}
	$( "#patient").autocomplete({
		 source: autoUrl,
		 minLength: 1,
		 select: function( event, ui ) {
		 	if($('#emp_code').is(':checked')){
		 		$('#patient_id').val(ui.item.id);
		 		$('#staff_name').val(ui.item.name);
        		$("#account_id").val(ui.item.id);
        		$("#is_staff").val('1');
		 	}else{
				$('#patient_id').val(ui.item.id);
			}
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	}); 
});*/

/*$(document).on('keyup',"#patient",function() {
  	if (/[^A-z \.]/g.test(this.value)){ this.value = this.value.replace(/[^A-z \.]/g,''); }
  });
  */
$(document).on('keyup',"#age",function() {
  	if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
  	 var agel = $(this).val(); 
  	 lengthAge = agel.length; 
  	 if(lengthAge > 3){
		$("#age").val("");
  	 }
  });

//function for all autocomplete
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

	if(instance != "vadodara"){
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
	
}

function openCreditDetail(person_id){
    window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_credit_detail","plugin"=>false)); ?>/'+person_id,'','width=500,height=150,location=0,scrollbars=no');
}

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
			console.log(ItemDetail.PharmacyItem);	
			var pack = parseInt(ItemDetail.PharmacyItem.pack);
			var stock = parseInt(ItemDetail.PharmacyItemRate.stock);
			var looseStock = parseInt(ItemDetail.PharmacyItemRate.loose_stock);
			var myStock = (stock*pack)+looseStock;
			$("#stockWithLoose_"+fieldno).val(myStock);
			$("#stockQty"+fieldno).val(ItemDetail.PharmacyItemRate.stock);
			$("#looseStockQty"+fieldno).val(ItemDetail.PharmacyItemRate.loose_stock);
			$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
			$("#vat_class_name"+fieldno).val(ItemDetail.PharmacyItemRate.vat_class_name);
			$("#vat"+fieldno).val(ItemDetail.PharmacyItemRate.vat_sat_sum);
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

function checkstock(field, rules, i, options){
	 var fieldno = field.attr('fieldNo') ;
	 var stock = parseInt($("#stockQty"+fieldno).val());
	 if(stock < field.val()){
	 	return 'Insufficient quantity in stock';

	 }

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

 /* load the data from supplier master */
/* load the data from supplier master */
function loadDataFromRate(itemID,selectedId){ 
	var currentField = selectedId.split("-"); 
	var fieldno = currentField[1];
	loading(fieldno);
	$("#expiry_date"+fieldno).val("");
	$("#stockQty"+fieldno).val("");
	$("#looseStockQty"+fieldno).val("");
	$("#mrp"+fieldno).val("");
	$("#vat_class_name"+fieldno).val("");
	$("#vat"+fieldno).val(""); 
	$("#rate"+fieldno).val("");
	$("#value"+fieldno).val("");
	$("#pack"+fieldno).val("");
	$("#qty_"+fieldno).val("");
 	var tariff = $("#tariff_id").val();
 	var room = $("#roomType").val(); 

 	/*******************************/
 	
 	var batchesArray = new Array();
	var batchesIDArray = new Array();
	
	$(".itemId").each(function(){
		if(itemID === $(this).val()){
			var fieldCount = $(this).attr('fieldNo'); 	//current fieldno of loop
			var batchNO = $("#batch_number"+fieldCount+" option:selected").text(); 
			var batchID = $("#batch_number"+fieldCount).val();
			batchesArray.push(batchNO);
			batchesIDArray.push(batchID);
		}
	});
 
 	/********************************/
	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item",'item_id','true',"inventory" => true,"plugin"=>false)); ?>",
		  data: "item_id="+itemID+"&tariff="+tariff+"&roomType="+room+"&batch_number="+batchesArray,
		}).done(function( msg ) {
		 	var item = jQuery.parseJSON(msg); 
		 	console.log(item);
			var pack = parseInt(item.PharmacyItem.pack);
		 	$("#item_name-"+fieldno).val(item.PharmacyItem.name);
			$("#item_id"+fieldno).val(item.PharmacyItem.id);
			$("#itemWiseDiscount"+fieldno).val(item.PharmacyItem.discount);
 
			if( item.PharmacyItem.discount != null ||  item.PharmacyItem.discount > 0 ){
				showDisc = "&nbsp;("+item.PharmacyItem.discount+"%)";
			}else{
				showDisc = '';
			}
			
			$("#displayDiscPer"+fieldno).html(showDisc);
			$("#item_code-"+fieldno).val(item.PharmacyItem.item_code);
			$("#pack"+fieldno).val(item.PharmacyItem.pack);
			$("#doseForm"+fieldno).val(item.PharmacyItem.doseForm);
			$("#genericName"+fieldno).val(item.PharmacyItem.generic);
			batches= item.PharmacyItemRate; 

			var batches = item.batches;
			$("#batch_number"+fieldno+" option").remove(); 
			if(batches!='' && batches!=null){ 
				var totalBatches = 0;
				$.each(batches, function(index, value) { 
			    	$("#batch_number"+fieldno).append( "<option value='"+index+"'>"+value+"</option>" );
			    	totalBatches++;
				}) ;

				var totalRemovedBatches = 0;
				$.each(batchesIDArray, function(key, batchId) { 
					$("#batch_number"+fieldno+" option[value='"+batchId+"']").remove(); 
					totalRemovedBatches++;
				}); 

				if(totalBatches != totalRemovedBatches){
					var stock = parseInt(item.PharmacyItemRate.stock!="" ? item.PharmacyItemRate.stock : 0);
					var looseStock = parseInt(item.PharmacyItemRate.loose_stock!="" ? item.PharmacyItemRate.loose_stock:0);
					var myStock = (stock * pack) + looseStock;
					if(myStock > 0){
						$("#expiry_date"+fieldno).val(item.PharmacyItemRate.expiry_date);
						$("#stockWithLoose_"+fieldno).val(myStock);	
						$("#stockQty"+fieldno).val(item.PharmacyItemRate.stock);
						$("#looseStockQty"+fieldno).val(item.PharmacyItemRate.loose_stock);
						$("#mrp"+fieldno).val(item.PharmacyItemRate.mrp);
						$("#vat_class_name"+fieldno).val(item.PharmacyItemRate.vat_class_name);
						$("#vat"+fieldno).val(item.PharmacyItemRate.vat_sat_sum); 
						$("#rate"+fieldno).val(item.PharmacyItemRate.sale_price);
					}else{
						alert("Sorry, no stock available in this batch..!!");
					}
				}else{
					alert("Sorry, no stock available in another batche for this product..!!");
				}
			}else{
				alert("Sorry, no stock available in any batches..!!");
			}
			
			/*var batchNo = new Array();
			
			$('.itemId').each(function(){
				var curField = $(this).attr('fieldNo');
				var itemId = $(this).val();
				if($("#batch_number"+curField).val() != '' && itemID == itemId && curField != fieldno ){ //second cond added to prevent time med selection  row cond
					batchNo.push($("#batch_number"+curField).val());
				} 
			});	
				
			$("#batch_number"+fieldno+" option").remove();
			if(batches!=''){
				$.each(batches, function(index, value) { 
					if(batchNo != ''){
						$.each(batchNo,function(id,collctedBatchID){ 
							if(value.id != collctedBatchID){
						    	$("#batch_number"+fieldno).append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
							}
						}) ;
					}else{	
						$("#batch_number"+fieldno).append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
					}
				    
					if(index==0){
						var stock = parseInt(value.stock!="" ? value.stock : 0);
						var looseStock = parseInt(value.loose_stock!="" ? value.loose_stock:0);
						var myStock = (stock * pack) + looseStock;
						$("#expiry_date"+fieldno).val(value.expiry_date);
						$("#stockWithLoose_"+fieldno).val(myStock);	
						$("#stockQty"+fieldno).val(value.stock);
						$("#looseStockQty"+fieldno).val(value.loose_stock);
						$("#mrp"+fieldno).val(value.mrp);
						$("#vat_class_name"+fieldno).val(value.vat_class_name);
						$("#vat"+fieldno).val(value.vat_sat_sum); 
						$("#rate"+fieldno).val(value.sale_price);
		            }					
				});
			}
			*/
			var itemrateid=$("#batch_number"+fieldno).val();
			var editUrl  = "<?php echo $this->Html->url(array('controller'=>'pharmacy','action'=>'edit_item_rate','inventory'=>false))?>";
			$("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
			$("#qty_"+fieldno).attr('readonly',false);
			$("#qty_"+fieldno).focus();
			onCompleteRequest(fieldno);
	});
		selectedId='';
}


$("#cust_name").on('focus',function(){
	var t = $(this); 
	$("#ss").hide();
	$(this).autocomplete({
	source:"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_other_patient_detail","inventory" => true,"plugin"=>false)); ?>",
	select:function (event, ui) {
	  	var person_id = li.extra[0];
		$("#cust_name").val(pharmacyitem_id);
	         var link = '<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_other_patient_credit_detail","plugin"=>false)); ?>/'+pharmacyitem_id;
	           $("#ss").attr("href",link);
	           $("#ss").show();
	},
	autoFill:false
	});
});



$("#tax").on("blur",function(){

    var tax = parseFloat($("#tax").val());
    var amount = parseFloat($("#total_amount_field").val());
    if(isNaN(tax)){
        alert("Please enter the valid tax amount.");
        $("#tax").val("0");
        return false;
    }
        	var i=1;var totAmt=0;var amt=0;
			$.each('.quantity', function() {
					amt= $('#value'+i).val();				
					if(amt!='' && !isNaN(amt)){					
					totAmt= parseInt(totAmt)+parseInt(amt);				
				}
				i++;
				});

        var taxAmount = ((totAmt*tax)/100);
        totAmt = totAmt+taxAmount;
        $("#total_amount_field").val((totAmt.toFixed(2)));
		$("#total_amount").html((totAmt.toFixed(2)));

});

	$("#dob").datepicker({
		showOn : "both",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true,
		yearRange: '-100:' + new Date().getFullYear(),
		maxDate : new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			calculateAge();		 			
			$(this).validationEngine("hide");
		}						
	});

	function calculateAge() {	//function to calculate age using date of birth
		var dateofbirth = $("#dob").val();
		if (dateofbirth != "") {
			var currentdate = new Date();
			var splitBirthDate = dateofbirth.split("/");
			var caldateofbirth = new Date(splitBirthDate[2]+ "/"+ splitBirthDate[1]+ "/"+ splitBirthDate[0]+ " 00:00:00");
			var caldiff = currentdate.getTime()	- caldateofbirth.getTime();
			var calage = Math.floor(caldiff/(1000 * 60 * 60 * 24 * 365.25)); 
			$("#age").val(calage);
		}
	}
	

  	$("#ss").hide();
 	$("#ss").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
	
  function prescriptionData(patientId){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'sales_bill','inventory'=>true))?>"+'/'+patientId;
		}	

function addFields(){
	   var number_of_field = parseInt($("#no_of_fields").val())+1;
	   var clas = "";
	   if(number_of_field %2 != 0){
		   clas = "row_gray";
	   }else{
		   clas = "blue-row";
	   }
		
	 $(".formError").remove();
    var field = '';
	   field += '<tr id="row'+number_of_field+'" class="ho '+clas+'">';
	   field += '<td align="center" valign="middle"><input name="item_code[]" id="item_code'+number_of_field+'" type="text" autocomplete="off" class="textBoxExpnd  item_code" value="" style="width:100%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden" value="" style="width:80%;"/></td>';
  	   field += '<td align="center" valign="middle"  width="185"><input name="item_name[]" autocomplete="off" id="item_name-'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_name"  value="" style="width:90%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/> </td>';
  	 field += '<td style="text-align:center;"><table><tr><td><input name="qty[]" readonly="readonly" type="text" autocomplete="off" class="textBoxExpnd quantity validate[required,number]"  value="" id="qty_'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/> <input type="hidden" value="0" id="stockQtys'+number_of_field+'"></td><td><select name="itemType[]" fieldNo="'+number_of_field+'", id="itemType_'+number_of_field+'" class="itemType"><option value="Tab">MSU</option><!--<option value="Pack">Pack</option><option value="Unit">Unit</option>--></select> </td></tr></table></td>';
       //field += '<td align="center" valign="middle"><input name="manufacturer[]" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"   value=""  style="width:100%;" autocomplete="off" readonly="true"/></td>';
	   field += '<td align="center" valign="middle"><input name="pack[]" id="pack'+number_of_field+'" type="text" class="textBoxExpnd "   value=""  style="width:100%;" readonly="true" autocomplete="off"/></td>';
	   field += '<td align="center" valign="middle"><select name="pharmacyItemId[]" id="batch_number'+number_of_field+'" class="textBoxExpnd validate[required] batch_number" value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"></select></td>';
	   field += '<td valign="middle" style="text-align: center;"><table><tr><td><input name="stokWithLoose[]" id="stockWithLoose_'+number_of_field+'" type="text"  value="0" fieldNo="'+number_of_field+'" readonly="true"/> <input type="hidden" class="textBoxExpnd" id="stockQty'+number_of_field+'" value="0" autocomplete="off" readonly="true" /><input type="hidden" id="looseStockQty'+number_of_field+'" class="textBoxExpnd" value="0" readonly="true" /></td></tr></table></td>';
	  "<?php if($websiteConfig['instance']=='kanpur'){ ?>"
	   field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd" value=""  style="width:80%;" autocomplete="off" readonly="true" fieldNo="'+number_of_field+'"/></td>';
	   field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd mrp"  fieldNo="'+number_of_field+'" value="" id="mrp'+number_of_field+'" style="width:100%;" autocomplete="off" readonly="true"/></td>';
	   field += '<td valign="middle" style="text-align:center;"><input name="vat_class_name[]" type="text" class="textBoxExpnd"  fieldNo="'+number_of_field+'" value="" id="vat_class_name'+number_of_field+'" style="width:100%;" autocomplete="off" readonly="true"/><input name="vat[]" type="hidden" class="textBoxExpnd vat"  fieldNo="'+number_of_field+'" value="" id="vat'+number_of_field+'" style="width:100%;" autocomplete="off" readonly="true"/></td>';
	   
	    "<?php }else{ ?>"
	    field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[future[NOW]] expiry_date" value=""  style="width:80%;" autocomplete="off"/></td>';
	    field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd mrp validate[required,number]"  fieldNo="'+number_of_field+'" value="" id="mrp'+number_of_field+'" style="width:100%;" autocomplete="off" readonly="true"/></td>';
	    "<?php } ?>"
	    
	   field += '<td valign="middle" style="text-align:center;"><input name="rate[]" fieldNo="'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] rate" value="" id="rate'+number_of_field+'" style="width:100%;" autocomplete="off" readonly="readonly" /></td>';
       field += ' <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd validate[required,number] value" readonly="readonly" id="value'+number_of_field+'" value=""  style="width:100%;" autocomplete="off"/></td> ';
	   field +='<td valign="middle" style="text-align:center;"> <a href="javascript:void(0);" id="delete row" onclick="deletRow('+number_of_field+');"> <?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a></td>';
	   field +='</tr>';
		$("#no_of_fields").val(number_of_field);
		$("#item-row").append(field);
		if (parseInt($("#no_of_fields").val()) == 1){
			$("#remove-btn").css("display","none");
		}else{
			$("#remove-btn").css("display","inline");
		}
		//bind autocomplete
		itemAutoComplete("item_name-"+number_of_field);
		$("#item_name-"+number_of_field).focus();
}


function deletRow(id){ 
	$("#row"+id).remove(); 
	$(".formError").remove();
	var number_of_field = parseInt($("#no_of_fields").val());
	var table = $('#item-row');
		summands = table.find('tr');
	var sr_no = 1;
	summands.each(function ()
	{
		var cell = $(this).find('.sr_number'); 
		cell.each(function ()
		{
			$(this).html(sr_no);
			sr_no = sr_no+1;
		});
	});
	
	$('.item_name'+number_of_field+"formError").hide();
	$('.item_code'+id+"formError").remove();
	$('.item_name'+id+"formError").remove();
	$('.batch_number'+id+"formError").remove();
	$('.expiry_date'+id+"formError").remove();
	$('.qty_'+id+"formError").remove();
	$('.value'+id+"formError").remove();

	$('.rate'+id+"formError").remove();
	$('.mrp'+id+"formError").remove();
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}
	$("#submitButton").removeAttr('disabled');
		var $form = $('#InventoryPurchaseDetail'),
			$summands = $form.find('.value');
			var sum = 0;
			$summands.each(function ()
			{
				var value = Number($(this).val());
				if (!isNaN(value)) sum += value;
			});
		$("#total_amount_field").val((sum.toFixed(2)));
		$("#total_amount").html((sum.toFixed(2)));
		$('#net_amount').html(sum.toFixed(2));
		calculateDiscount();
}
	


function calculateDiscount(){
	var disc = '';
	var totalAmount = $("#total_amount_field").val();
	$(".discountType").each(function () {  
        if ($(this).prop('checked')) {
           var type = this.value;
           if(type == "Amount") 
            {    
            	disc = ($("#inputDiscount").val() != '') ? parseFloat($("#inputDiscount").val()) : 0;
            }else if(type == "Percentage")
            {
            	var discount_value = ($("#inputDiscount").val()!= '') ? parseFloat($("#inputDiscount").val()) : 0;
				if(discount_value < 101){
       		    	disc = parseFloat(((totalAmount*discount_value)/100));
				}else{
					alert("Percentage should be less than or equal to 100");
					$("#inputDiscount").val('');
					$("#inputDiscount").focus();
				}
            }
           $("#discount").val(disc.toFixed(2));
        }
    });
	var netAmount = totalAmount - disc;
	$("#discount").val(disc.toFixed(2)); 
	$("#net_amount").html(netAmount.toFixed(2));
}

$("#inputDiscount").keyup(function(){
	calculateDiscount();
});

$(".discountType").change(function(){
	calculateDiscount();
});
	
function getTotal(id){
		if($(id)!=""){
		var fieldno = $(id).attr('fieldNo') ;
		var qty = parseInt($("#qty_"+fieldno).val()!=""?$("#qty_"+fieldno).val():0);
        var price = ($("#rate"+fieldno).val()!="")?$("#rate"+fieldno).val():0.00;
        var qtyType = $("#itemType_"+fieldno).val();
        var packNan = isNaN($('#pack'+fieldno).val()); 
		var pack = parseInt($('#pack'+fieldno).val().match(/\d+/)); // 123456  from 123456ML
		
    	var vat = ($('#vat'+fieldno).val()!="")?$('#vat'+fieldno).val():0;
       //	var tax = ($('#tax').val()!="")?$('#tax').val():0;
       
		if(price<=0){
			price = parseFloat(($("#mrp"+fieldno).val()!="")?$("#mrp"+fieldno).val():0.00);
		}
		var webInstance = "<?php echo $websiteConfig['instance']; ?>";
		
		if(qtyType == 'Tab'){
		 	var calAmnt = (price/pack)*qty; 	//calculate amnt per tablet
		 	var sub_total = (calAmnt * 100) / 100; 
		}else{
			var sub_total = (price*qty);
		}
		
		var totalWithTax = sub_total;
		if(price != 0 || price !=''){
			$("#value"+fieldno).val(totalWithTax.toFixed(2));
		}
		var sum = 0;
		count = 1;
	    $('.value').each(function() { 
		    if(this.value!== undefined  && this.value != ''  ){
	        	sum += parseFloat(this.value);	       
	        }
			count++;			        				        
	    });
	    /*if(webInstance != "kanpur"){
			//if(tax!='' || tax!=0){ 
			    var totalTax = (sum/*tax)/100;
			    sum += totalTax;
	    	//}
	    } */
	    
		$("#total_amount_field").val((sum.toFixed(2)));
		$("#total_amount").html(sum.toFixed(2)); 
		$('#net_amount').html(sum.toFixed(2));
		calculateDiscount();
     }
	} 
  	
  	
  	function checkStockLimit(id){	//by swapnil to check the enter qty with existing stock
  		if($(id)!=""){
  			var fieldno = $(id).attr('fieldNo') ;
  			var qty = parseInt($("#qty_"+fieldno).val());
  	        var qtyType = $("#itemType_"+fieldno).val();
  	        var pack = parseInt($('#pack'+fieldno).val().match(/\d+/));
  	        
  	    	var stockQty = parseInt($("#stockQty"+fieldno).val());
  	    	var looseStock = parseInt($("#looseStockQty"+fieldno).val()!=''?$("#looseStockQty"+fieldno).val():0);

  	    	var totalTab = (pack * stockQty) + looseStock;
  	    	var TotalQty = Math.floor(totalTab/pack);
  	    	
  	    	if(qtyType == "Tab"){
  	    		TotalQty = totalTab;
  		    }
  	        /*if(qty > TotalQty){
  	            alert("sold qty is greater than stock quantity");
  	            $("#qty_"+fieldno).val('');
  	            $("#qty_"+fieldno).focus();
  	            return false;
  	        }*/
  		}
  	  }
  	

  	$(document).on('keypress','.quantity',function(e) {
  	 	var fieldNo = $(this).attr('fieldNo') ;
  	    if (e.keyCode==40) {	//key down
  	        var nextRow = parseInt(fieldNo)+1;
  	        //$("#qty_"+fieldNo).focus();
  	    } 
  	    if (e.keyCode==38) {	//up key
  	    	var prevRow = parseInt(fieldNo)-1;
  	        //$("#qty_"+fieldNo).focus();
  	    } 
  	    if(e.keyCode==13){		//key enter
  		    if($("#item_id"+fieldNo).val()!=0 || $("#item_id"+fieldNo).val()!=''){
  	    		addFields();
  		    }
  	    }
  	});
  	
	 $(document).on('keyup',".quantity",function(e) {
	
	  	if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
	  	var qtyVal = $(this).val();
	  	checkStockLimit(this);
	  	getTotal(this);
  });

  $(document).on('keyup',".mrp",function() {
  	if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
  	checkStockLimit(this);
  	getTotal(this);
  });

  $(document).on('keyup change',".rate",function() {
  	if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,'');  }
  	checkStockLimit(this);
  	getTotal(this);
  });

  $(document).on('keyup change',"#tax",function() {
  	if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,'');  }
  	checkStockLimit(this);
  	getTotal(this);
  });

  $(document).on('keyup change',"#vat",function() {
  	if (/[^0-9\.]/g.test(this.value)){  this.value = this.value.replace(/[^0-9\.]/g,'');  }
  	checkStockLimit(this);
  	getTotal(this);
  });

  $(document).on('change',".itemType",function(){
	 checkStockLimit(this);
	  getTotal(this);
  });

   
	$('#age').blur(function(){
		var InitialArray=[];
		var timeLeft = '<?php echo date("Y"); ?>';
		var enterAge=$('#age').val();
		var newMinusVal = timeLeft-enterAge;
		var extarDate='<?php echo date("d/m")?>';
		var putDate=extarDate+'/'+newMinusVal;
		$('#dob').val(putDate);
	});

        

	$("#isDiscount").change(function(){
	if($(this).is(":checked",true)){
		$("#showDiscount").show();
	}else{
		$("#showDiscount").hide();
		$("#inputDiscount").val('');
		$("#discount").val('');
		$("#net_amount").html($("#total_amount_field").val());
	}
});

$("#doctname").on('focus',function()
    {
		var t = $(this);
		$(this).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceTwoFieldsAutocomplete","DoctorProfile",'user_id',"doctor_name",'is_active=1','null',"admin" => false,"plugin"=>false)); ?>",
		select:function( event, ui ) {
			$("#doctor_id").val(ui.item.id);
		},
		messages: {
	        noResults: '',
	        results: function() {}
		 }
		});
	});

// For BackDated date
$( "#date" ).datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate("");?>',
});
  
function isNumeric(num){
    return !isNaN(num)
} 

function staffCheck(){
    if($('#is_staff').val() == '1'){ 
    	$('#emp_name').show();
        $('.accountDetailBlock').show();
        $('.patientDetailBlock').hide();
        $("#patient_id").val('');
    }else{
    	$('#emp_name').hide();
        $('.accountDetailBlock').hide();
        $('.patientDetailBlock').show();
        $('#staff_name').val('');
        $("#account_id").val('');
    } 
    getPaymentMode();
}

function getPaymentMode(){
    var mode = $.parseJSON('<?php echo json_encode($mode_of_payment); ?>');
    if($('#is_staff').val() == '1'){ 
        $("#payment_mode option").remove();
        $.each(mode, function(id,value){
            $("#payment_mode").append( "<option value='"+id+"'>"+value+"</option>" ); 
        }); 
    }else{
        $("#payment_mode option").remove();
        $.each(mode, function(id,value){
            if(value=="Cash"){
                $("#payment_mode").append( "<option value='"+id+"'>"+value+"</option>" ); 
            }
        }); 
    } 
}

$('#emp_code').click(function(){
	$("input[type=text], textarea").val("");
	$('#patient_id').val('');
	$('#staff_name').val('');
	$("#account_id").val('');
	$("#is_staff").val('');
	$('#dob').val('');
	$('.accountDetailBlock').hide();
	$('#emp_name').hide();
	$('.patientDetailBlock').show();
		 	
})

 </script>

