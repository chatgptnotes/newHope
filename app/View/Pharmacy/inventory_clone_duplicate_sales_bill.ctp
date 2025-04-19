<?php echo $this->Html->script(array('jquery.blockUI'));
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
?>
<style>
	.blue-row{
		background-color:#D9D9D9;
	}
	.ho:hover{
		background-color:#C1BA7C;
		}
</style>
<div class="inner_title" >
	<?php echo $this->element('pharmacy_menu');?>
	<h3>Sales Bill</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Add Product'),'javascript:void(0)',array('escape'=>false,'class'=>'blueBtn','id'=>'addProduct'));
	?> </span>
</div>

<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#InventoryPurchaseDetailInventorySalesBillForm").validationEngine();
		$('#InventoryPurchaseDetailInventorySalesBillForm').validationEngine('hideAll');
	});

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
//echo $this->Html->script('pharmacy_sales');
$patient_name="";
$patient_admission_id = "";
$patient_id="";
if(isset($patient)){
	$patient_name=$patient['Patient']['lookup_name'];
	$patient_admission_id = $patient['Patient']['admission_id'];
	$patient_id = $patient['Patient']['id'];
  }

  
  ?>
<div class="clr ht5"></div>
<?php 
echo $this->Form->create('InventoryPurchaseDetail',array('onkeypress'=>"return event.keyCode != 13;",'url'=>array('controller'=>'pharmacy','action'=>'duplicate_sales_bill','inventory'=>true)));?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="50">&nbsp;</td>
		
		<td width="45" class="tdLabel2">Date</td>
		<td width="140" class="tdLabel2"><input name="sale_date" type="text"
			class="textBoxExpnd" id="sale_date" 
			value="<?php echo date('d/m/Y H:i:s') ;?>" /></td>

		<td width="45" class="tdLabel2">Patient ID</td>
		<td width="140" class="tdLabel2"><input name="party_code" type="text"
			class="textBoxExpnd" id="party_code" 
			value="<?php echo $patient_admission_id ;?>" /></td>
		<td width="10">&nbsp;</td>
		<td width="45" class="tdLabel2">Patient Name<font color="red">*</font>
		</td>
		<td width="140" class="tdLabel2"><input name="party_name" type="text"
			class="textBoxExpnd validate[required]" id="party_name" 
			value="<?php echo $patient_name ;?>" /><input
			name="PharmacyDuplicateSalesBill[person_id]" id="person_id"
			value="<?php echo $patient_id ;?>" type="hidden" />
		<a href="#" id="ss"><?php echo $this->Html->image('/img/icons/1361479921_credit-card.png', array('alt' => 'View Credit',"title"=>"View Credit"));?>
		</a></td>

		<?php
		if(isset($patient)){
			echo "<input type='hidden' name='redirect_to_billing' value='1'>";
		} 					 ?>
		<td width="45" class="tdLabel2">Doctor Name</td>
		<td width="120" class="tdLabel2"><input name="doctor_name" type="text"
			class="textBoxExpnd" id="doctor_name"  value="<?php echo $patient['DoctorProfile']['doctor_name'];?>" />
			<input
			name="PharmacyDuplicateSalesBill[doctor_id]" id="doctor_id" value="<?php echo $patient['DoctorProfile']['user_id'] ; ?>"
			type="hidden" /></td>
	</tr>
</table>
<div class="clr ht5"></div>


<table width="100%" cellpadding="0" cellspacing="1" border="0" class="table_format" id="item-row">
	<tr class="row_title" style="border:1pt solid black;">
		<td width="80" align="center" class="table_cell" valign="top" style="text-align: center;">Item Code<font color="red">*</font></td>
		<td width="200" align="center" valign="top" class="table_cell" 	style="text-align: center;">Item Name<font color="red">*</font>	</td>
		<td width="120" valign="top" class="table_cell" style="text-align: center;">Qty<font color="red">*</font></td>
		<td width="120" align="center" valign="top" class="table_cell" style="text-align: center;">Manufacturer</td>
		<td width="60" valign="top" style="text-align: center;" class="table_cell">Pack</td>
		<td width="80" align="center" valign="top" style="text-align: center;" class="table_cell">Batch No.<font color="red">*</font>	</td>
		<td width="40" align="center" valign="top" style="text-align: center;" class="table_cell">Stock</td>
		<td width="150" align="center" valign="top"	style="text-align: center;" class="table_cell">Expiry Date<font color="red">*</font></td>
		<td width="60" valign="top" style="text-align: center;" class="table_cell">MRP<font color="red">*</font></td>
		
		<!--<th width="60" valign="top" style="text-align: center;">Tax</th>
		<th width="60" valign="top" style="text-align: center;">VAT</th>
		-->
		
		<td width="60" valign="top" style="text-align: center;" class="table_cell">Price<font color="red">*</font>	</td>
		<td width="80" valign="top" style="text-align: center;" class="table_cell">Amount<font	color="red">*</font></td>
		<td width="10" style="text-align: center;" class="table_cell">#</td>
	</tr>
	 <?php $cnt = 1;?>
		
		
		<?php
			if($cnt%2 != 0){
				$clas = "row_gray";
			}else{
				$clas = "blue-row";
			}
			$totalAmForEachMed = 0 ; 
			foreach($pharmacyData as $prescriptions){ 
				//debug($prescriptions);
				?>
		<tr id="<?php echo 'row'.$cnt?>" class="ho <?php echo $clas;?>">
		<td align="center" valign="middle"><input name="item_code[]"
			type="text" class="textBoxExpnd item_code" autocomplete="off"
			id="item_code<?php echo $cnt?>"  value="<?php echo $prescriptions['PharmacyItem']['item_code'];?>" style="width: 100%;" fieldNo="<?php echo $cnt;?>"
			onkeyup="checkIsItemRemoved(this)" /> <input name="item_id[]"
			id="item_id<?php echo $cnt?>" type="hidden"  value="<?php echo $prescriptions['PharmacyItem']['id'];?>" style="width: 80%;" />
		</td>
		
		<td align="center" valign="middle" width="185"><input
			name="item_name[]" type="text" autocomplete="off"
			class="textBoxExpnd validate[required] item_name" id="item_name-<?php echo $cnt?>"
			value="<?php echo $prescriptions['PharmacyItem']['name'];?>" style="width: 90%;" fieldNo="<?php echo $cnt;?>"
			onkeyup="checkIsItemRemoved(this)" /> <a href="#" id="viewDetail<?php echo $cnt?>"
			class='fancy' style="visibility: hidden"><img title="Edit Item Rate"
				alt="View Item" src="/DrmHope/img/icons/view-icon.png"> </a></td>
				<td valign="middle" style="text-align: center;">
		<?php
			if($requisitionType == 'ot'){ 
		?>
		<input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off"
			id="qty_<?php echo $cnt ?>" twidowsex="10"  style="width: 100%;" fieldNo="<?php echo $cnt ;?>" value="<?php echo $drugQty[$cnt-1]; ?>"/>
			<?php 
			//calcualte amount
			if(!empty($prescriptions['PharmacyItemRate']['sale_price'])){
				$totalAmForEachMed = $totalAmForEachMed+$prescriptions['PharmacyItemRate']['sale_price']* $drugQty[$cnt-1] ;
				$totalAmt=$prescriptions['PharmacyItemRate']['sale_price']* $drugQty[$cnt-1] ;
			}else if(!empty($prescriptions['PharmacyItemRate']['mrp'])){
				$totalAmForEachMed =$totalAmForEachMed+ $prescriptions['PharmacyItemRate']['mrp']* $drugQty[$cnt-1] ;
				$totalAmt=$prescriptions['PharmacyItemRate']['mrp']* $drugQty[$cnt-1] ;
			}
		} else { //else for medication quatityt  form newcropprescription table

		//calcualte amount
			if(!empty($prescriptions['PharmacyItemRate']['sale_price'])){
				$totalAmForEachMed = $totalAmForEachMed+$prescriptions['PharmacyItemRate']['sale_price']* $prescriptions['NewCropPrescription']['quantity'] ;
				$totalAmt=$prescriptions['PharmacyItemRate']['sale_price']* $prescriptions['NewCropPrescription']['quantity'] ;
			}else if(!empty($prescriptions['PharmacyItemRate']['mrp'])){
				$totalAmForEachMed =$totalAmForEachMed+ $prescriptions['PharmacyItemRate']['mrp']* $prescriptions['NewCropPrescription']['quantity'] ;
				$totalAmt=$prescriptions['PharmacyItemRate']['mrp']* $prescriptions['NewCropPrescription']['quantity'] ;
			}
			
			?> 
			
				<input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off"
			id="qty_<?php echo $cnt ?>" twidowsex="11"  style="width: 100%;" fieldNo="<?php echo $cnt ;?>" value="<?php  echo !empty($pharmaItemQty[$prescriptions['PharmacyItem']['id']])?$pharmaItemQty[$prescriptions['PharmacyItem']['id']]:$prescriptions['NewCropPrescription']['quantity'];
			/*echo $prescriptions['NewCropPrescription']['quantity'];*/ ?>"/>
			<?php $rowTotal=$pharmaItemQty[$prescriptions['PharmacyItem']['id']]*$prescriptions['PharmacyItemRate']['sale_price'];
			
 } ?>
 			<?php 
   				echo $this->Form->input('itemType', array('style'=>'width:60px;','class'=>'itemType','name'=>"itemType[]",
   								'div' => false,'fieldNo'=>$cnt,'label' => false,'autocomplete'=>'off','id' => 'itemType_'.$cnt,
   								'options'=>array(/* 'Pack'=>'Pack', */'Tab'=>'MSU'/* ,'Unit'=>'Unit' */))); 
			?>
			 <input type="hidden" id="stockQty<?php echo $cnt ?>" value="<?php echo $prescriptions['PharmacyItem']['stock'] ?>" />
		</td>
		
		<td align="center" valign="middle"><input name="manufacturer[]" autocomplete="off"
			type="text" class="textBoxExpnd " id="manufacturer<?php echo $cnt?>" 
			value="<?php echo $prescriptions['PharmacyItem']['manufacturer'];?>" style="width: 100%;" readonly="true" /></td>
		<td align="center" valign="middle"><input name="pack[]" type="text" autocomplete="off" fieldNo="<?php echo $cnt;?>"
			class="textBoxExpnd " id="pack<?php echo $cnt?>"  value="<?php echo $prescriptions['PharmacyItem']['pack'];?>"
			style="width: 100%;" readonly="true" /></td>
		<td valign="middle" style="text-align: center;">
		
		<?php 
			$batches = ""; 
			$pharmaSalePriceDisplay = $pharmaSalePrice[$prescriptions['PharmacyItem']['id']];
			$pharmaSaleMrpDisplay = $pharmaMrp[$prescriptions['PharmacyItem']['id']];
			$pharmaType = $pharmaItemType[$prescriptions['PharmacyItem']['id']];
			$pStock = $pharmStock[$prescriptions['PharmacyItem']['id']];
			$pharmExp = $pharmExpiry[$prescriptions['PharmacyItem']['id']];
			foreach($prescriptions['PharmacyItemRate'] as $key => $val){
				$batches[$val['id']] = $val['batch_number'];
			}
			$myKey = array_search($editSales['PharmacyDuplicateSalesBillDetail'][$cnt-1]['batch_number'], $batches);
			
		echo $this->Form->input('batch_number',array('type'=>'select','options'=>$batches,'value'=>$myKey,'div'=>false,'class'=>'textBoxExpnd validate[required] batch_number',
				'id'=>'batch_number'.$cnt, 'style'=>"width: 100%",'autocomplete'=>"off" ,"fieldNo"=>$cnt,'label'=>false,'name'=>"data[pharmacyItemId][]"));?>
				
			<!--<input name="batch_no[]" type="text" autocomplete="off"	class="textBoxExpnd validate[required] batch_number" id="batch_number<?php echo $cnt?>"
				 value="<?php echo $prescriptions['PharmacyItemRate']['batch_number'];?>" style="width: 100%;" autocomplete="off" fieldNo="1" />
				 
		--></td>
			<?php //debug($prescriptions); ?>
		<!--<td valign="middle" style="text-align: center;" ><?php $batch = $prescriptions['PharmacyItemRate']['batch_number'];?>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>'','class'=>'textBoxExpnd batch_number','id'=>'batch_number'.$cnt, 
							'style'=>"width: 100%",'autocomplete'=>"off","tabindex"=>"9","fieldNo"=>$cnt,'label'=>false,'name'=>"data[pharmacyItemId][]")); ?>
		</td>-->
		<td valign="middle" style="text-align: center;">
		<label name="qty[]"
			type="hidden"  value="<?php  echo !empty($pharmaItemQty[$prescriptions['PharmacyItem']['id']])?$pStock:''?>" style="width: 10px;" fieldNo="<?php echo $cnt;?>" /> 
			<input type="" id="stockQty<?php echo $cnt;?>" value="<?php echo $pStock;?>" readonly="false" style="width: 60px;" autocomplete="off" />
		</td>
		<td valign="middle" style="text-align: center;"><input
			name="expiry_date[]" type="text"
			class="validate[future[NOW]] textBoxExpnd expiry_date"
			id="expiry_date<?php echo $cnt;?>" style="width: 80%;"
			autocomplete="off" readonly="true" value="<?php echo $this->DateFormat->formatDate2Local($pharmExp,Configure::read('date_format')); ?>" fieldNo="<?php echo $cnt;?>"/>
		</td>
		<td valign="middle" style="text-align: center;"><input name="mrp[]" autocomplete="off"
			type="text" class="textBoxExpnd validate[required,number] mrp"  fieldNo="<?php echo $cnt;?>" id="mrp<?php echo $cnt?>"
			  value="<?php echo $mrp = $pharmaSaleMrpDisplay;?>" style="width: 100%;" /></td>
		
		
		<td valign="middle" style="text-align: center;"><input name="rate[]" autocomplete="off"
			type="text" class="textBoxExpnd validate[required,number] rate" fieldNo="<?php echo $cnt;?>"  id="rate<?php echo $cnt?>"
			 value="<?php echo $sale_price = $pharmaSalePriceDisplay;?>" style="width: 100%;" /></td> 
		<td valign="middle" style="text-align: center;">
		<?php //debug($drugQty[$cnt-1]); ?>
		<?php 
			$price = !empty($sale_price)?$sale_price:$mrp;
			$prescriptions['NewCropPrescription']['quantity'] ;
			if($this->request->params['pass'][1]=='ot'){
				$amount = $price*$drugQty[$cnt-1];
			}else{  
				$pack = (int)$pharmaPack[$prescriptions['PharmacyItem']['id']];
				$qtyVar = !empty($pharmaItemQty[$prescriptions['PharmacyItem']['id']])?$pharmaItemQty[$prescriptions['PharmacyItem']['id']]:$prescriptions['NewCropPrescription']['quantity'] ;
				$amount = ($price/$pack )*(int)$qtyVar;
			}
			$totalAmForEachMed += $amount; 
		?>		
		<input name="value[]" 	type="text" class="textBoxExpnd validate[required,number] value" autocomplete="off"
		id="value<?php echo $cnt?>" fieldNo="<?php echo $cnt;?>" value="<?php echo $amount; ?>" style="width: 100%;" />
			
			
		</td>  
		<td valign="middle" style="text-align: center;"><a href="#this"
			id="delete row" onclick="deletRow('<?php echo $cnt?>');"><img title="delete row"
				alt="Remove Item" src="/Hope/img/icons/cross.png"> </a></td>
	</tr>
	
	<?php $cnt++;
			 }?>

	<input type="hidden" value="<?php echo $cnt-1;?>" id="no_of_fields" />
</table>
<div class="clr ht5"></div>
<div align="left">
	<input name="" type="button" value="Add More" class="blueBtn Add_more"
		 onclick="addFields()" /><input name="" type="button"
		value="Remove" id="remove-btn" class="blueBtn" 
		onclick="removeRow()" style="display: none" />
</div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><?php echo __("Payment Mode");?><font color="red" >*</font>
		</td>

		 <td> <?php 
		 		//$paymentOptions = array(/*'Cheque'=>'Cheque',*/'Credit'=>'Credit','Cash'=>'Cash',/*,'Credit Card'=>'Credit Card','NEFT'=>'NEFT'*/);
   				echo $this->Form->input('PharmacyDuplicateSalesBill.payment_mode', array('class' => 'validate[required]','style'=>'width:141px;', 'type'=>'select',
   								'div' => false,'label' => false,/*'empty'=>__('Please select'),*/'autocomplete'=>'off',
   								'options'=>$mode_of_payment,
								'value'=>!empty($editSales['PharmacyDuplicateSalesBill']['payment_mode'])?$editSales['PharmacyDuplicateSalesBill']['payment_mode']:"Credit",'id' => 'payment_mode')); ?> 
   		</td>
   		
	   	<td style="text-align:right;padding:0 7px 0 0;"> Tax:</td>
			<td><input name="PharmacyDuplicateSalesBill[tax]" type="text" autocomplete='off'
				class="textBoxExpnd" id="tax"  value="<?php echo !empty($editSales['PharmacyDuplicateSalesBill']['tax'])?$editSales['PharmacyDuplicateSalesBill']['tax']:'';?>"
				style="width: 30%" /> 
		</td>
		
    	<td>Total Amount :</td>
	    <td><?php echo  $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;<span
			id="total_amount"><?php echo !empty($editSales['PharmacyDuplicateSalesBill']['total'])?$editSales['PharmacyDuplicateSalesBill']['total']:$totalAmForEachMed; ?></span><input name="PharmacyDuplicateSalesBill[total]"
			id="total_amount_field" autocomplete='off'  value="<?php echo !empty($editSales['PharmacyDuplicateSalesBill']['total'])?$editSales['PharmacyDuplicateSalesBill']['total']:$totalAmForEachMed; ;?>" type="hidden" /> 
		</td>
   		
   		<td style="text-align:right;padding:0 7px 0 0;">Is Discount:</td>
   		<?php if(!empty($editSales['PharmacyDuplicateSalesBill']['discount'])){
   				$discount = $editSales['PharmacyDuplicateSalesBill']['discount'];
   				$checked = "checked";
   			}else{
   				$discount = 0;		
   			}
   			?>
			<td><?php echo $this->Form->input('PharmacyDuplicateSalesBill.is_discount',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'isDiscount','checked'=>$checked))?></td>
		</td>
		
   		<td style="text-align:right;padding:0 7px 0 0; display:none;" id="showDiscount">
	   		<table>
	   			<tr>
	   				<td>
	   					<?php $discount=array('Amount'=>'Amount','Percentage'=>'Percentage');
							echo $this->Form->input('PharmacyDuplicateSalesBill.discount_type', array('id' =>'discountType','options' => $discount,
								'readonly'=>false,'legend' =>false,'label' => false,'div'=>false,'class'=>'discountType',
								'type' => 'radio','separator'=>'&nbsp;','default'=>'Amount','disabled'=>false)); ?>
	   				</td>
	   				<td>
	   					<input name="data[PharmacyDuplicateSalesBill][input_discount]" type="text" autocomplete='off' class="textBoxExpnd" id="inputDiscount" style="width: 30%" value="<?php echo $editSales['PharmacyDuplicateSalesBill']['discount'];?>" /> 
	   					<input name="PharmacyDuplicateSalesBill[discount]" id="discount" type="hidden" />
	   				</td>
	   			</tr>
	   		</table>
   		</td>
		<td></td>
		<td>Net Amount :</td>
	    <td><?php echo  $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
	    <span id="net_amount"><?php echo !empty($editSales['PharmacyDuplicateSalesBill']['total'])?$editSales['PharmacyDuplicateSalesBill']['total']-$editSales['PharmacyDuplicateSalesBill']['discount']:$totalAmForEachMed; ?></span> 
		</td>
	</tr>
	
	
	<tr>
	<!--
		<?php if(!empty($editSales['PharmacyDuplicateSalesBill']['credit_period'])){
			$style="";
		}else{
			$style="display:none";
		}?>
		<tr id="creditDaysInfo" style="<?php echo $style;?>">
		  	<td height="35" class="tdLabel2"> 
		  		Credit Period<font color="red">*</font><br /> (in days)</td>
		    <td>
		    	<?php echo $this->Form->input('PharmacyDuplicateSalesBill.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'credit_period',"autocomplete"=>'off',
		    			'class'=> 'validate[required]','value'=>!empty($editSales['PharmacyDuplicateSalesBill']['credit_period'])?$editSales['PharmacyDuplicateSalesBill']['credit_period']:''));?>
		    </td>
		    <td class="tdLabel2"> &nbsp;</td>
             <td class="tdLabel2">	 <span>Guarantor :</span>
		            <?php
 		            	echo $this->Form->input('PharmacyDuplicateSalesBill.guarantor_id',array('empty'=>'Please select','id'=>'guarantor_id',"autocomplete"=>'off',
									'options'=>$userName,'value'=>!empty($editSales['PharmacyDuplicateSalesBill']['guarantor_id'])?$editSales['PharmacyDuplicateSalesBill']['guarantor_id']:'' ,'label'=> false,'style'=> 'width:200px'));
 		            ?>
 		     </td> 
	   </tr> 
   		-->
		<tr id="paymentInfoCreditCard" style="display:none">
	  	 <td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%" > 
			    <tr>
				    <td>Bank Name</td>
				    <td><?php echo $this->Form->input('PharmacyDuplicateSalesBill.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_paymentInfoCreditCard',"autocomplete"=>'off'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('PharmacyDuplicateSalesBill.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfoCreditCard',"autocomplete"=>'off'));?></td>
				</tr>
				    <tr>
				    <td>Cheque/Credit Card No.</td>
				    <td><?php echo $this->Form->input('PharmacyDuplicateSalesBill.credit_card_no',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number',"autocomplete"=>'off'));?></td>
			    </tr>
			</table>
	    </td>
   </tr>
   <tr id="neft-area" style="display:none;">
	  	<td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%"> 
			    <tr>
				    <td width="47%">Bank Name</td>
				    <td><?php echo $this->Form->input('PharmacyDuplicateSalesBill.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_neftArea',"autocomplete"=>'off'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('PharmacyDuplicateSalesBill.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea',"autocomplete"=>'off'));?></td>
				</tr> 
			    <tr>
				    <td>NEFT No.</td>
				    <td><?php echo $this->Form->input('PharmacyDuplicateSalesBill.neft_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number',"autocomplete"=>'off'));?></td>
				</tr>
				    <tr>
				    <td>NEFT Date</td>
				    <td><?php echo $this->Form->input('PharmacyDuplicateSalesBill.neft_date',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_date','style'=>'width:150px;',"autocomplete"=>'off'));?></td>
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
<?php if($this->params['pass'][1]=='nurse'){?>
<?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?>
	<!--<input name="submit" type="submit" value="Submit" class="blueBtn"  id="submitButton"   /> -->
<?php }else{ ?>
<!-- 	<input name="print" type="submit" value="Print" class="blueBtn"  /> -->
<input name="submit" type="submit" value="Submit" class="blueBtn"  id="submitButton"  /> 
<?php } ?>
<?php //echo $this->Html->link('submit','javascript:void(0)',array('onclick'=>'printSp("'.$patientId.'")', 'id'=>'submitButton','class'=>'blueBtn')); ?>

	<?php echo $this->Form->end();?>
	 
</div>
 


<script>
$(document).ready(function(){

	if ($("#isDiscount").attr('checked')) {
		$("#showDiscount").show();
	}
	
	if($("#payment_mode").val() == 'Credit Card' || $("#payment_mode").val() == 'Cheque'){
		 $("#paymentInfoCreditCard").show();
		 $("#creditDaysInfo").hide();
		 $('#neft-area').hide();
	} 
    else if($('#payment_mode').val() =='NEFT') {
		$('#neft-area').show();
		$("#creditDaysInfo").hide();
		$("#paymentInfoCreditCard").hide();
	}
    else if($('payment_mode').val() == 'Credit'){
	    $('#neft-area').hide();
		$("#creditDaysInfo").show();
		$("#paymentInfoCreditCard").hide();
	}
 
	//EOF payment laod
	$('#payment_mode').change(function(){
		if($("#payment_mode").val() == 'Credit Card' || $("#payment_mode").val() == 'Cheque'){
			 $("#paymentInfoCreditCard").show();
			 $("#creditDaysInfo").hide();
			 $("#neft-area").hide();
		} 
		else if($("#payment_mode").val() == 'Cash'){
			$("#paymentInfoCreditCard").hide();
			$("#creditDaysInfo").hide();
			$("#neft-area").hide();
		}
		else if($("#payment_mode").val() == 'NEFT'){
			$("#paymentInfoCreditCard").hide();
			$("#creditDaysInfo").hide();
			$("#neft-area").show();
		}
		else if($("#payment_mode").val() == 'Credit'){
			$("#paymentInfoCreditCard").hide();
			$("#creditDaysInfo").show();
			$("#neft-area").hide();
		}else{
			 $("#creditDaysInfo").hide();
			 $("#paymentInfoCreditCard").hide();
			 $('#neft-area').hide();
		}
	});

	$("#BN_paymentInfoCreditCard").on('keyup change blur',function(){
		$("#BN_neftArea").val($(this).val());
	});

	$("#AN_paymentInfoCreditCard").on('keyup change blur',function(){
		$("#AN_neftArea").val($(this).val());
	});
	
	$("#card_check_number").on('keyup change blur',function(){
		$("#card_neftArea").val($(this).val());
	});
		// End of code
});

	/**
	* function to fetch prescribed mediaction
	*/
	function getPatientPrescriptionDetails1(patientId){
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "getPrescribedDetail" ,"inventory" => false,"plugin"=>false)); ?>"+"/"+patientId;
		$.ajax({
			  type: "GET",
			  url: ajaxUrl,
			  success : function(data){
				  var obj = jQuery.parseJSON( data );
			  }
		})
	}


$(document).ready(function() {

	itemAutoComplete("item_name-1")
	
	 $(document).on('keyup change',".quantity, .mrp, .rate, .itemType",function()
	  {
	  	if (/[^0-9\.]/g.test(this.value)){
	      	 this.value = this.value.replace(/[^0-9\.]/g,'');
	      }
	  	getTotal(this);
	  }); 
	  
	// Credit card 
	$(".item_code").on('focus',function()
	{
		var t = $(this);
		$(this).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "autocomplete_item","item_code","inventory" => true,"plugin"=>false)); ?>",
		select:function (event, ui) {
				selectedId = t.attr('id');
				//selectItem(data1,selectedId);
				loadDataFromRate(ui.item.id,selectedId)
			},
			messages: {
		        noResults: '',
		        results: function() {}
			 }
		});
  });
});


$("#party_code").on('focus',function()
{
	  var t = $(this);
      $("#ss").hide();
	  $(this).autocomplete({
	 source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","admission_id","inventory" => true,"plugin"=>false)); ?>",
			select:function (event, ui) {
			 	console.log(ui);
			 	person_id = ui.item.id;
				$("#person_id").val(person_id);
				party_name = ui.item.value ;
				$("#party_name").val(party_name.split("-")[0]);
                var link = '<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_credit_detail","plugin"=>false)); ?>/'+person_id;
                 $("#ss").attr("href",link);
                   $("#ss").show();
				getDoctorName(person_id);
			},
			messages: {
		        noResults: '',
		        results: function() {}
			 }
		});
});

	//function to set doctor name from patient selection 
	function getDoctorName(patient_id){
		if(patient_id=='') return false ;
		$.ajax({
			type: "GET",
			url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_fetch_patient_doctor_name","inventory" => true,"plugin"=>false)); ?>",
			data: "patient="+patient_id,
			success: function(data){
			if(data != ''){
				var item = $.parseJSON(data);
				$("#doctor_id").val(item.id);
				$("#doctor_name").val(item.name);
			}
			}
		});
	}

	function itemAutoComplete(id){	
		$(".item_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "autocomplete_item",'name',"inventory" =>true,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				console.log(ui.item);
				//selectItem(data1,id);
				loadDataFromRate(ui.item.id,id);
			 },
			 messages: {
		        noResults: '',
		        results: function() {}
			 }		
		});
	}

	function openCreditDetail(person_id){
		window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_credit_detail","plugin"=>false)); ?>/'+person_id,'','width=500,height=150,location=0,scrollbars=no');

	}


	$("#doctor_name").on('focus',function()
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

	

$(".batch_number").on('change',function()
{
	var t = $(this);
	var fieldno = t.attr('fieldNo') ;
	$.ajax({
		type: "GET",
        url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_fetch_batch_for_item","inventory" => true,"plugin"=>false)); ?>",
        data: "itemRate="+$(this).val(),
        success: function(data){
			var ItemDetail = jQuery.parseJSON(data);
			//console.log(ItemDetail.PharmacyItemRate);	
			$("#stockQty"+fieldno).val(ItemDetail.PharmacyItemRate.stock);
			$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
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



$("#party_name").on('focus',function() {
	var t = $(this); 
    $("#ss").hide();
	$(this).autocomplete({
		source:	"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","inventory" => true,"plugin"=>false)); ?>",
		select:function (event, ui) {
				var person_id = ui.item.id;
				$("#person_id").val(person_id);
				$("#party_code").val(ui.item.party_code);
				var link = '<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_credit_detail","plugin"=>false)); ?>/'+person_id;
				$("#ss").attr("href",link);
				$("#ss").show();
				//call for doctor name 
				getDoctorName(person_id);
			},
			messages: {
		        noResults: '',
		        results: function() {}
			 }
		});
});


$( "#expiry_date1" ).datepicker({

	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate("");?>',
    
});


$( "#sale_date" ).datepicker({

	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
    
});


$(".Add_more").click(function()
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


function addFields(){
	   var number_of_field = parseInt($("#no_of_fields").val())+1;
	 
	   var clas = "";
	   if(number_of_field %2 != 0){
		   clas = "row_gray";
	   }else{
		   clas = "blue-row";
	   }
			
		//addCalenderOnDynamicField();
	   //alert(number_of_field);
	 $(".formError").remove();
    var field = '';
	   field += '<tr id="row'+number_of_field+'" class="ho '+clas+'">';
	   field += '<td align="center" valign="middle"><input name="item_code[]" id="item_code'+number_of_field+'" type="text" autocomplete="off" class="textBoxExpnd  item_code" value="" style="width:100%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden" value="" style="width:80%;"/></td>';
  	   field += '<td align="center" valign="middle"  width="185"><input name="item_name[]" autocomplete="off" id="item_name-'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_name"  value="" style="width:90%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/> <a href="javascript:void(0);" id="viewDetail'+number_of_field+'"'+number_of_field+'" class="fancy" style="visibility:hidden;"> <?php echo $this->Html->image("/img/icons/view-icon.png"); ?></a></td>';
	   field += '<td style="text-align:center;"><table><tr><td><input name="qty[]" type="text" autocomplete="off" class="textBoxExpnd quantity validate[required,number]"  value="" id="qty_'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/> <input type="hidden" value="0" id="stockQtys'+number_of_field+'"></td><td><select name="itemType[]" fieldNo="'+number_of_field+'", id="itemType_'+number_of_field+'" class="itemType"><option value="Pack">Pack</option><option value="Tab">Tab</option><option value="Unit">Unit</option></select> </td></tr></table></td>';
       field += '<td align="center" valign="middle"><input name="manufacturer[]" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"   value=""  style="width:100%;" autocomplete="off" readonly="true"/></td>';
	   field += '<td align="center" valign="middle"><input name="pack[]" id="pack'+number_of_field+'" type="text" class="textBoxExpnd "   value=""  style="width:100%;" readonly="true" autocomplete="off"/></td>';
	   field += '<td align="center" valign="middle"><select name="pharmacyItemId[]" id="batch_number'+number_of_field+'" class="textBoxExpnd validate[required] batch_number" value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"></select></td>';
       field += '<td valign="middle" style="text-align: center;"><input name="stok[]" type="hidden"  value="" fieldNo="'+number_of_field+'" /> <input type="" class="textBoxExpnd" style="width: 60px;" id="stockQty'+number_of_field+'" value="0" autocomplete="off" readonly="false" /></td>';
	   field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[future[NOW]] expiry_date" value=""  style="width:80%;" autocomplete="off"/></td>';
	   field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd mrp validate[required,number]"  fieldNo="'+number_of_field+'" value="" id="mrp'+number_of_field+'" style="width:100%;" autocomplete="off"/></td>';
	   //field += '<td valign="middle" style="text-align:center;"><input name="tax[]" type="text" class="textBoxExpnd"   value="" id="tax'+number_of_field+'" style="width:80%;" readonly="true"/></td>';
	//	field += '<td valign="middle" style="text-align:center;"><input name="vat[]" type="text" class="textBoxExpnd"   value="" id="vat'+number_of_field+'" style="width:80%;" readonly="true"/></td>';

	   field += '<td valign="middle" style="text-align:center;"><input name="rate[]" fieldNo="'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] rate" value="" id="rate'+number_of_field+'" style="width:100%;" autocomplete="off" /></td>';
       field += ' <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd  validate[required,number] value" id="value'+number_of_field+'" value=""  style="width:100%;" autocomplete="off"/></td> ';
	   field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"> <?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a></td>';
	  field +='</tr>';
	$("#no_of_fields").val(number_of_field);
	$("#item-row").append(field);
	//$("#item_name-"+number_of_field).focus();
		if (parseInt($("#no_of_fields").val()) == 1){
					$("#remove-btn").css("display","none");
				}else{
	$("#remove-btn").css("display","inline");
	}
		itemAutoComplete("item_name-"+number_of_field);
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

 	$(document).keypress(('.quantity'),function(e) {
	 	var fieldNo = $(this).attr('fieldNo') ;
	    if (e.keyCode==40) {	//key down
	        $("#qty_"+fieldNo).focus();
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
	
/* load the data from supplier master */
function loadDataFromRate(itemID,selectedId){
	//var currentField = $("#"+selectedId);
	var currentField = selectedId.split("-");
	//var fieldno = currentField.attr('fieldNo') ;
	var fieldno = currentField[1];
	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item",'item_id','true',"inventory" => true,"plugin"=>false)); ?>",
		  data: "item_id="+itemID,
		}).done(function( msg ) {
		 	var item = jQuery.parseJSON(msg);
			$("#item_id"+fieldno).val(item.PharmacyItem.id);
			$("#item_code"+fieldno).val(item.PharmacyItem.item_code);
			$("#manufacturer"+fieldno).val(item.ManufacturerCompany.name); 
			$("#pack"+fieldno).val(item.PharmacyItem.pack);
			
			batches= item.PharmacyItemRate;
			$("#batch_number"+fieldno+" option").remove();
			if(batches!=''){
				$.each(batches, function(index, value) { 
				    $("#batch_number"+fieldno).append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
					if(index==0){
						$("#expiry_date"+fieldno).val(value.expiry_date);
						$("#stockQty"+fieldno).val(value.stock);
						$("#mrp"+fieldno).val(value.mrp);
						$("#rate"+fieldno).val(value.sale_price);
		            }					
				});
			}
			var itemrateid=$("#batch_number"+fieldno).val();
			var editUrl  = "<?php echo $this->Html->url(array('controller'=>'pharmacy','action'=>'edit_item_rate','inventory'=>false))?>";
			$("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
			$("#qty_"+fieldno).focus();
	});
		selectedId='';
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
  function prescriptionData(patientId,requisitionType){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'sales_bill','inventory'=>true))?>"+'/'+patientId+"/"+requisitionType;
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
			var $form = $('#InventoryPurchaseDetailInventorySalesBillForm'),
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
	}

  	function getTotal(id){
  		if($(id)!=""){
			var fieldno = $(id).attr('fieldNo') ;
			var qty = $("#qty_"+fieldno).val();
	        var price = ($("#rate"+fieldno).val()!="")?$("#rate"+fieldno).val():0.00;
	        var qtyType = $("#itemType_"+fieldno).val();
	        var pack = parseInt($('#pack'+fieldno).val());  
           		 
				if(price<=0){
					price = parseFloat(($("#mrp"+fieldno).val()!="")?$("#mrp"+fieldno).val():0.00);
				}
				var	sub_total = qty*price;
				if(qtyType == 'Tab'){
				 	var calAmnt = (price/pack)*qty; 							//calculate amnt per tablet
				 	var sub_total = Math.round(calAmnt * 100) / 100; 
				}
				var totalWithTax = sub_total;
				if(price != 0 || price !=''){
					$("#value"+fieldno).val(totalWithTax.toFixed(2));
				}
				var sum = 0;
				count = 1;
			    $('.value').each(function() {
				    if($("#value"+count).val() !== undefined  && $("#value"+count).val() != ''  ){
			        	sum += parseFloat($("#value"+count).val());	       
			        }
					count++;			        				        
			    });
				$("#total_amount_field").val((sum.toFixed(2)));
				$("#total_amount").html(sum.toFixed(2)); 
				$('#net_amount').html(sum.toFixed(2));
				calculateDiscount();

         }
  	}


  	
$(".quantity, .mrp, .rate, .itemType").on('keyup keypress blur change input',function()
{
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
	getTotal(this);
});

  $('#hide_patients').click(function(){	  
	  $('#show_patients').show();
	  $('#iframeDisplay').hide();
	  $('#hide_patients').hide();
  });

  $("#addProduct").click(function(){
	  $.fancybox({
			'width' : '80%',
			'height' : '150%',
			'autoScale' : true,
			'transitionIn' :'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller"=>"pharmacy", "action" => "add_new_product","inventory" => false,'admin'=>false,'?'=>array('flag'=>1))); ?>"

		});
		//$(document).scrollTop(0);
		$(window).scrollTop(100);  
				    return false ;
  });


  $("#tax").on("blur",function(){
	    var tax = parseFloat($("#tax").val()); 
	    var amount = parseFloat($("#total_amount_field").val());
	    if(isNaN(tax)){
	        alert("Please enter the valid tax amount.");
	      //  $("#tax").val("0");
	        return false;
	    }
	        	var $form = $('#InventoryPurchaseDetailInventorySalesBillForm'),
	   				$summands = $form.find('.value');

						var sum = 0;
						$summands.each(function ()
						{
							var value = Number($(this).val());
							if (!isNaN(value)) sum += value;
						});

	        var taxAmount = ((sum*tax)/100);
	        sum = sum+taxAmount;
	        $("#total_amount_field").val((sum.toFixed(2)));
			$("#total_amount").html((sum.toFixed(2)));
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

function calculateDiscount(){
	var disc = '';
	var totalAmount = $("#total_amount_field").val();
	$(".discountType").each(function () { 
		if ($(this).attr('checked')) {
			var type = this.value;
			if(type == "Amount")
            {    
            	disc = ($("#inputDiscount").val() != '') ? parseInt($("#inputDiscount").val()) : 0;
            }else if(type == "Percentage")
            {
            	var discount_value = ($("#inputDiscount").val()!= '') ? parseInt($("#inputDiscount").val()) : 0;
				if(discount_value < 101){
       		    	disc = parseInt(Math.ceil((totalAmount*discount_value)/100));
				}else{
					alert("Percentage should be less than or equal to 100");
				}
            }
			//$("#discount").val(disc.toFixed(2));
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

  $('#show_patients').click(function(){ 

	   <?php if($patient_id){ ?>
	  			url="<?php echo $this->Html->url(array("controller" => "patients", "action" => "get_patient_prescription_details",$patient_id,"inventory" => false,"plugin"=>false));?>";
	  <?php }else{?>
				url="<?php echo $this->Html->url(array("controller" => "patients", "action" => "get_patient_prescription","inventory" => false,"plugin"=>false)); ?>";
	  <?php }?>



		$.fancybox({
		            'width'    : '95%',
				    'height'   : '90%',
				    'autoScale': true,
				    'transitionIn': 'fade',
				    'transitionOut': 'fade',
				    'type': 'iframe',
				    'href': url 
			    });


	  return false ;

	  $('#iframeDisplay').show();
	  $('#show_patients').hide();
		$('#hide_patients').show();
	  <?php if($patient_id){ ?>
	  			url="<?php echo $this->Html->url(array("controller" => "patients", "action" => "get_patient_prescription_details",$patient_id,"inventory" => false,"plugin"=>false));?>";
	  <?php }else{?>
				url="<?php echo $this->Html->url(array("controller" => "patients", "action" => "get_patient_prescription","inventory" => false,"plugin"=>false)); ?>";
	  <?php }?>

		$.ajax({
			  type : "POST",
			  url: url,
			  context: document.body,
			  beforeSend:function(){
			    loading('iframeDisplay','id');
			  } 
			  ,	  		  
			  success: function(data){					 
				$('#iframeDisplay').html(data);	
				$('#iframeDisplay').show();			
				
				
			  }
		});
	  
  });

  

</script>
