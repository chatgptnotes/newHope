<style>
.td_second{
	border-left-style:solid; 
	padding-left: 15px; 
	background-color: #404040; 
	color:#ffffff;
	width:5%;
}

.formFull td{
	padding: 0px 0 ;
}

.blue-row{
	background-color:#D9D9D9;
}
.alert-row{
	background-color:red;
}
.ho:hover{
	background-color:#C1BA7C;
}


</style>
<?php 
   echo $this->Html->script(array('jquery.blockUI'));
	//echo $this->Html->css(array('jquery.autocomplete.css'));
	//echo $this->Html->script(array('jquery.autocomplete.js'));
   echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
   echo $this->Html->script(array('jquery.fancybox-1.3.4'));
   $referral = $this->request->referer();
   echo $this->Form->hidden('formReferral',array('value'=>'','id'=>'formReferral'));
?>
<?php if($websiteConfig['instance']=='vadodara'){
	$readonlForVado = "readonly";
}else{
	$readonlForVado = "";
}?>
<div class="inner_title">
	<h3>
		<?php echo __('OT Pharmacy Management - Sales Bill', true); ?>
	</h3>
	<?php echo $this->element('ot_pharmacy_menu');?>
	<span style="float: right;">
	<?php echo $this->Html->link(__('Import Data', true),array('controller' => 'pharmacy', 'action' => 'import_data', '?'=>array('location'=>'OtPharma'), 'admin' => true), array('escape' => false,'class'=>'blueBtn' ));?>
	</span>
</div>
<?php echo $this->Form->create('OtPharmacySalesBillFrm',array('onkeypress'=>"return event.keyCode != 13;",'id'=>"otPharmacyForm"));?>

	<table align="center" width="80%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><?php echo __("Patient Name/ID:");?><font color="red">*</font></td>
			<td>
			<input name="party_name" type="text" class="textBoxExpnd validate[required]" id="party_name" autocomplete="off"
				value="<?php //echo $pharmacySales['PharmacySalesBill']['customer_name'];?>" />
			<input	name="OtPharmacySalesBill[patient_id]" id="person_id" calss="textBoxExpnd validate[required]"
				value="<?php echo $patient_id ;?>" type="hidden" />
			<input	name="OtPharmacySalesBill[admission_type]" id="admission_type" calss="textBoxExpnd validate[required]" type="hidden" />
			<?php echo $this->Form->hidden('',array('id'=>'tariff_id','name'=>"data[OtPharmacySalesBill][tariff]",'value'=>''));?>
			<?php echo $this->Form->hidden('',array('id'=>'roomType','name'=>"data[OtPharmacySalesBill][room_type]",'value'=>''));?>
			</td>
			<td id="tariff" width="140"></td>
			<td><?php echo __("Doctor Name:");?></td>
			<td>
			<input name="doctor_name" type="text" class="textBoxExpnd" id="doctor_name" autocomplete="off" value="<?php //echo $pharmacySales['PharmacySalesBill']['p_doctname'];?>" />
			<input name="OtPharmacySalesBill[doctor_id]" id="doctor_id" value="" type="hidden" />
			</td>
	 	</tr>
	</table>
	
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="table_format" id="item-row">
		<tr><td colspan="2"><font color="#ff343"><i>(MSU = Minimum Saleable Unit)</i></font></td></tr>
		<tr class="row_title" style="border:1pt solid black;" >
			<td width="180" align="center" valign="top" class="table_cell" 	style="text-align: center;">Item Name<font color="red">*</font>	</td>
			<td width="110" valign="top" class="table_cell" style="text-align: center;">Quantity<font color="red">*</font></td>
			<td width="30" valign="top" style="text-align: center;" class="table_cell">Pack</td>
			<td width="90" align="center" valign="top" style="text-align: center;" class="table_cell">Batch No.<font color="red">*</font>	</td>
			<td width="80" align="center" valign="top" style="text-align: center;" class="table_cell">Stock</td>
			<td width="150" align="center" valign="top"	style="text-align: center;" class="table_cell">Expiry Date<font color="red">*</font></td>
			<td width="50" valign="top" style="text-align: center;" class="table_cell">MRP<font color="red">*</font></td>
			<td width="50" valign="top" style="text-align: center;" class="table_cell">Price<font color="red">*</font>	</td>
			<?php if(strtolower($this->Session->read('website.instance'))=='vadodara' || strtolower($this->Session->read('website.instance'))=='kanpur'){ ?>
			<td width="50" valign="top" style="text-align: center;" class="table_cell">Discount</td>
			<?php } ?>
			<td width="50" valign="top" style="text-align: center;" class="table_cell">Amount<font	color="red">*</font></td>
			<td width="10" style="text-align: center;" class="table_cell">#</td>
		</tr>
		<?php $cnt = 1;  ?>
		<input type="hidden" value="1" id="counter" />
		<tr id="row_<?php echo $count;?>" class="row_gray ho">
			<td align="" valign="middle">
				<table width="100%">
					<tr>
						<td style="padding:0px;">
							<input name="OtPharmacySalesBill[item_name][]" type="text" class="textBoxExpnd validate[required] item_name" id="name_1" value="" fieldNo="1"
					 			 autocomplete="off" style="width:95%;" onkeyup="checkIsItemRemoved(this)"/>
						</td>
						<td style="padding:0px;">
							<a href="javascript:void(0);" id="Generic" onclick="showGeneric('1');" style="padding: 0px;">
								<?php echo $this->Html->image('icons/generic.png',array('title'=>'Generic','alt'=>'Generic','class'=>'showGeneric','fieldNo'=>"1"));?>
							</a>
							<?php 
								echo $this->Form->hidden('PharmacySalesBill.generic',array('id'=>'genericName1','name'=>"generic[]",'fieldNo'=>'1','value'=>'','class'=>'genericName'));
							?>
						</td>
					</tr>
				</table>
			
			 <input name="OtPharmacySalesBill[item_id][]" id="itemId_1" class="itemIdd" type="hidden"  value="" fieldNo="1"/>
			 <input name="OtPharmacySalesBill[product_id][]" id="productId_1" class="productId" type="hidden"  value="" fieldNo="1"/>
			</td>
			<td>
			<table>
				<tr><td>
					<input name="OtPharmacySalesBill[qty][]" type="text" class="textBoxExpnd validate[required] quantity" autocomplete="off" id="qty_1" value="" 
						style="width:100%;" fieldNo="1" /> 
					</td>
					<td>
						<?php 
   							echo $this->Form->input('OtPharmacySalesBill.item_type', array('style'=>'width:55px;','name'=>"OtPharmacySalesBill[itemType]",'class'=>'itemType',
   								'div' => false,'fieldNo'=>"1",'label' => false,'autocomplete'=>'off','id' => 'itemType_'.$cnt, 'readonly'=>true,
   								'options'=>array('Tab'=>'MSU'/*,'Pack'=>'Pack','Unit'=>'Unit'*/))); 
						?>
				</td></tr>
			</table>
			</td>
			<td>
			<input name="OtPharmacySalesBill[pack][]" type="text"  id="pack_1" fieldNo="1"  value="" style="width:50px"  autocomplete="off" readonly=true/>
			<?php //echo $this->Form->input('',array('type'=>'text','id'=>'doseForm_1','autocomplete'=>'off',"fieldNo"=>"1",'label'=>false, 'style'=>'width:50px',
					//'value'=>"",'name'=>"OtPharmacySalesBill[doseForm][]")); ?>
			</td>
			<td>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>'','class'=>'textBoxExpnd validate[required] batch_number','id'=>'batchNumber_1',
					'autocomplete'=>"off" ,"tabindex"=>"9","fieldNo"=>"1",'label'=>false,'name'=>"data[pharmacyItemId][]",'style'=>'width:95px;')); ?>
			</td>
			<td valign="middle" style="text-align: center;">
				<table width="100%">
				<tr>
					<td><input type="text" id="stockWithLoose_1" name="OtPharmacySalesBill[stockWithLoose][]" fieldNo="1" class="textBoxExpnd" value="0" readonly="true" />
					<input type="hidden" id="stockQty_1" name="OtPharmacySalesBill[stok][]" fieldNo="1" class="textBoxExpnd" value="0" readonly="true" />
					<input type="hidden" id="looseStockQty_1" class="textBoxExpnd" value="0" readonly="true" /></td>
				</tr>
				</table>
			</td>
			<!-- <td>
			
			<input type="text" id="stockQty_1" name="OtPharmacySalesBill[stok][]" fieldNo="1" class="textBoxExpnd" value="0" readonly="true" />
			</td> -->
			<td>
			<input name="OtPharmacySalesBill[expiry_date][]" type="text" class="validate[future[now]] textBoxExpnd expiry_date" <?php //echo $disabled;?> id="expiryDate_1"  
					value="" style="width: 80%;" autocomplete="off" />
			</td>
			<td>
			<input name="OtPharmacySalesBill[mrp][]" type="text" class="textBoxExpnd validate[required,number] mrp" id="mrp_1" fieldNo="1" value="" style="width: 100%;" 
					autocomplete="off" readonly="true"/>
			</td>
			<td>
			<input name="OtPharmacySalesBill[rate][]" type="text" class="textBoxExpnd validate[required,number] rate" fieldNo="1" id="rate_1" value="" style="width: 100%;" 
					autocomplete="off" readonly="true"/>
			</td>
			
			<?php if(strtolower($this->Session->read('website.instance'))=='vadodara'){ ?>
		
		<td valign="middle" style="text-align: center;">
		<table>
			<tr>
				<td style="padding:0">
					<input name="OtPharmacySalesBill[itemWiseDiscountAmount][]" type="text" class="textBoxExpnd itemWiseDiscountAmount" fieldNo="1" id="itemWiseDiscountAmount1"
						 value="" style="width: 100%;" autocomplete="off"  />
					<input type="hidden" name="itemWiseDiscount[]" class="itemWiseDiscount" fieldNo="1" id="itemWiseDiscount1" value=""/>
				</td>
				<td fielno="1" id="displayDiscPer1" style="padding:0">
				</td>
			</tr>
		</table>
		</td>		 
		
		<?php } else if(strtolower($this->Session->read('website.instance'))=='kanpur'){ ?>
		
		<td valign="middle" style="text-align: center;">
		<table>
			<tr>
				<td>
					<input name="OtPharmacySalesBill[itemWiseDiscountAmount][]" type="text" class="textBoxExpnd itemWiseDiscountAmount" fieldNo="1" id="itemWiseDiscountAmount1"
						 value="" style="width: 100%;" autocomplete="off"/>
					<input type="hidden" name="itemWiseDiscount[]" class="itemWiseDiscount" fieldNo="1" id="itemWiseDiscount1" value=""/>
				</td>
				<td fielno="1" id="displayDiscPer1">
				</td>
			</tr>
		</table>
		</td>	
		<?php } ?>	 
		
			<td>
			<input name="OtPharmacySalesBill[amount][]" type="text" class="textBoxExpnd validate[required,number] amount" fieldNo="1" readonly="readonly" id="amount_1"  
					value="" style="width: 100%;" autocomplete="off" />
			</td>
			<td>
			<a href="javascript:void(0);" fieldNo="1"  onclick="deleteRow('1');">
				<?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?> 
			</a>
			</td>
		</tr>  
	</table>
	
	<div align="left">
				<input name="" type="button" value="Add More" class="blueBtn Add_more"onclick="addFields()" />
	</div>
	<div align="right">
			<?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','id'=>'submitButton','div'=>false,'label'=>false)); ?>
		</div>
	
	<table><tr>
		<td><?php echo __('Total Amount:');?></td>
	    <td><?php echo  $this->Session->read('Currency.currency_symbol'); ?>&nbsp;
	    <span id="total_amount">
			<?php //echo number_format(!empty($editSales['PharmacySalesBill']['total'])?$editSales['PharmacySalesBill']['total']:$totalAmForEachMed,2); ?>
		</span>
			<input name="OtPharmacySalesBill[total]" id="total_amount_field" autocomplete='off'  value="<?php //echo round(!empty($editSales['PharmacySalesBill']['total'])?$editSales['PharmacySalesBill']['total']:$totalAmForEachMed,2) ;?>" type="hidden" /> 
		</td></tr>
		
		<tr>
			<td>Discount :</td>
			<td><?php echo $this->Form->input('',array('name'=>"data[OtPharmacySalesBill][discount]",'id'=>'totalItemWiseDiscount','div'=>false,'label'=>false,'readonly'=>true));?></td>
		</tr>
		
		<!--<tr>
		<td id="showDiscountDetails" style="display:none;">
		<table><tr>
   			<td style="text-align:right;padding:0 7px 0 0;">Is Discount:</td>
   		<?php if(!empty($editSales['OtPharmacySalesBill']['discount'])){
   				$discount = $editSales['OtPharmacySalesBill']['discount'];
   				$checked = "checked";
   			}else{
   				$discount = 0;		
   			}
   			?>
			<td>
			<?php echo $this->Form->input('OtPharmacySalesBill.is_discount',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'isDiscount','checked'=>$checked))?>
			</td>
		</tr></table></td>
		<td style="text-align:right;padding:0 7px 0 0; display:none;" id="showDiscount" colspan="4">
	   		<table>
	   			<tr>
	   				<td>
	   					<?php $discount=array('Amount'=>'Amount','Percentage'=>'Percentage');
							echo $this->Form->input('OtPharmacySalesBill.discount_type', array('id' =>'discountType','options' => $discount,
								'readonly'=>false,'legend' =>false,'label' => false,'div'=>false,'class'=>'discountType',
								'type' => 'radio','separator'=>'&nbsp;','default'=>'Amount','readonly'=>true)); ?>
	   				</td>
	   				<td>
	   					<input name="data[OtPharmacySalesBill][input_discount]" type="text" autocomplete='off' class="textBoxExpnd" id="inputDiscount" style="width: 30%" value="<?php //echo $editSales['PharmacySalesBill']['discount'];?>" /> 
	   					<input name="OtPharmacySalesBill[discount]" id="discount" type="hidden" />
	   				</td>
	   			</tr>
	   		</table>
   		</td>
		</tr>
		--><tr>
		<td>Net Amount :</td>
	    <td><?php echo  $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
	    <span id="net_amount"><?php //echo number_format(!empty($editSales['PharmacySalesBill']['total'])?$editSales['PharmacySalesBill']['total']-$editSales['PharmacySalesBill']['discount']:$totalAmForEachMed,2); ?></span> 
		</td>		
		</tr>
		<tr>
		<td><?php echo __("Payment Mode");?><font color="red" >*</font></td>
		<td> <?php 
		 		//$paymentOptions = array(/*'Cheque'=>'Cheque',*/'Credit'=>'Credit','Cash'=>'Cash',/*,'Credit Card'=>'Credit Card','NEFT'=>'NEFT'*/);
   				echo $this->Form->input('OtPharmacySalesBill.payment_mode', array('class' => 'validate[required]','style'=>'width:141px;', 'type'=>'select',
   					'div' => false,'label' => false,'autocomplete'=>'off','options'=>$mode_of_payment,
					'value'=>!empty($editSales['OtPharmacySalesBill']['payment_mode'])?$editSales['OtPharmacySalesBill']['payment_mode']:"Credit",'id' => 'payment_mode')); ?> 
   		</td>
   		
	</tr>
	</table></td> 
	</tr></table>
	


<?php echo $this->Form->end();?>

<?php /* if(isset($this->params->query['print']) && !empty($_GET['id'])){ 
			echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'OtPharmacy','action'=>'print_view','OtPharmacySalesBill',$_GET['id'],'?'=>"flag=header"))."', '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
			
		}  */
	?>
<script>

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

jQuery(document).ready(function(){
	//jQuery("#otPharmacyForm").validationEngine('validate');
});


$(document).ready(function(){

	itemAutoComplete("name_1");	//for initial autocomplete
	
	var print="<?php echo isset($this->params->query['print'])?$this->params->query['print']:'' ?>";
	var referral = "<?php echo $referral ; ?>" ;
	 
	if(print && referral != '/' && $("#formReferral").val()=='' ){
		$("#formReferral").val('yes') ;
		var url="<?php echo $this->Html->url(array('controller'=>'OtPharmacy','action'=>'print_view','OtPharmacySalesBill',$_GET['id'],'?'=>"flag=header")); ?>";
	    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready

		}

	$(".item_name").focus(function(){
		if($("#person_id").val()=="")
		{	 
			alert("Please Select Patient First");
			$("#party_name").focus();
			return false;
		}
	});

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


	$("#party_name").autocomplete({ 

		//source: "<?php echo $this->Html->url(array("controller" => "OtPharmacy", "action" => "fetch_otpatient_detail","lookup_name","plugin"=>false)); ?>",
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","non-discharge","inventory" => true,"plugin"=>false)); ?>",
		 minLength: 1, 
		 select: function( event, ui ) {
			console.log(ui.item);
			var party_code = ui.item.party_code;
			var patient_id = ui.item.id;
			var admission_type = ui.item.admission_type;
			var tariff_id = ui.item.tariff_id;
			var tariff_name = ui.item.tariff_name;
			roomType = ui.item.room_type;
			$("#party_code").val(party_code);
			$("#party_code").val(party_code);
			$("#person_id").val(patient_id);
			$("#admission_type").val(admission_type);
			$("#tariff_id").val(tariff_id);
			$("#roomType").val(roomType);
			$("#tariff").html("("+tariff_name+")"+" - "+admission_type);
			
			getDoctorName(patient_id);//call for doctor name 
		},
			messages: {
		        noResults: '',
		        results: function() {}
		 }	
	});

	function getDoctorName(patient_id){
		if(patient_id=='') return false ;
		$.ajax({
			type: "GET",
			url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_doctor_name","inventory" => true,"plugin"=>false)); ?>",
			data: "patient="+patient_id,
			success: function(data){
			if(data != ''){
				var item = $.parseJSON(data);
				$("#doctor_id").val(item.id);
				$("#doctor_name").val(item.name);
				$("#name_1").focus();
			}
			}
		});
	}
	
});


function itemAutoComplete(id){	
	$(".item_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "OtPharmacy", "action" => "autocomplete_item",'name',"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function(event, ui ) {
			console.log(ui.item);
			var selectedId = ($(this).attr('id')); 
			loadDataFromRate(ui.item.id,selectedId);
			
		 },
		 messages: {
	        noResults: '',
	        results: function() {}
		 }		
	});
}

function addFields(){
	
	if($("#person_id").val()=="")
	{ 
		alert("Please Select Patient First");
		$("#party_name").focus();
		return false;
	}
	var counter = parseInt($("#counter").val())+1; 
	var hovClass = "";
	   if(counter %2 != 0){
		   hovClass = "row_gray";
	   }else{
		   hovClass = "blue-row";
	   }

	var addRow = '';
		addRow += '<tr id="row_'+counter+'" class="ho '+hovClass+'">'; 
		addRow += '<td> <table width="100%"> <tr> <td style="padding:0px;"> <input name="OtPharmacySalesBill[item_name][]" type="text" class="textBoxExpnd validate[required] item_name" id="name_'+counter+'" value="" fieldNo="'+counter+'" autocomplete="off" style="width:95%;" onkeyup="checkIsItemRemoved(this)"/> <input name="OtPharmacySalesBill[item_id][]" id="itemId_'+counter+'" class="itemIdd" type="hidden"  value="" fieldNo="'+counter+'"/></td><td style="padding:0px;"> <input type="hidden" name="genericName" id="genericName'+counter+'" class="genericName" value="" fieldNo="'+counter+'"/> <a href="javascript:void(0);" style="padding: 0px;" id="Generic" onclick="showGeneric('+counter+');"><?php echo $this->Html->image('icons/generic.png',array('title'=>'Generic','alt'=>'Generic','class'=>'showGeneric'));?></a></td></tr></table></td>';
		addRow += '<td><table><tr><td><input name="OtPharmacySalesBill[qty][]"  type="text" autocomplete="off" class="textBoxExpnd quantity validate[required]"  value="" id="qty_'+counter+'" style="width:100%;" fieldNo="'+counter+'"/></td><td><select name="itemType[]" fieldNo="'+counter+'", id="itemType_'+counter+'" class="itemType"></option><option value="Tab">MSU</option></select></td></tr></table></td>';
		addRow += '<td><input name="OtPharmacySalesBill[pack][]" type="text"  id="pack_'+counter+'" fieldNo="'+counter+'"  value="" style="width:50px"  autocomplete="off" readonly="true" /></td>';
		addRow += '<td><select name="data[pharmacyItemId][]" id="batchNumber_'+counter+'" class="textBoxExpnd validate[required] batch_number" value=""  style="width:95px;" autocomplete="off" fieldNo="'+counter+'"></select></td>';
		addRow += '<td valign="middle" style="text-align: center;"><table><tr><td><input name="OtPharmacySalesBill[stockWithLoose][]" id="stockWithLoose_'+counter+'" class="textBoxExpnd" type="text"  value="0" fieldNo="'+counter+'" readonly="true"/> <input type="hidden" class="textBoxExpnd" id="stockQty_'+counter+'" value="0" autocomplete="off" readonly="true" /><input type="hidden" id="looseStockQty_'+counter+'" class="textBoxExpnd" value="0" readonly="true" /></td></tr></table></td>';
		//addRow += '<td><input type="text" id="stockQty_'+counter+'" name="OtPharmacySalesBill[stok][]" fieldNo="'+counter+'" class="textBoxExpnd" value="0" readonly="true" /></td>';   
		addRow += '<td><input name="OtPharmacySalesBill[expiry_date][]" type="text" class="validate[future[now]] textBoxExpnd expiry_date" id="expiryDate_'+counter+'" value="" style="width: 80%;" autocomplete="off" /></td>';
		addRow += '<td><input name="OtPharmacySalesBill[mrp][]" type="text" class="textBoxExpnd validate[required,number] mrp" id="mrp_'+counter+'" fieldNo="'+counter+'" value="" style="width: 100%;" autocomplete="off" readonly="true"/></td>';   
		addRow += '<td><input name="OtPharmacySalesBill[rate][]" type="text" class="textBoxExpnd validate[required,number] rate" fieldNo="'+counter+'" id="rate_'+counter+'" value="" style="width: 100%;" autocomplete="off" readonly="true"/></td>';

		"<?php if(strtolower($this->Session->read('website.instance'))=='vadodara'){ ?>"
	    addRow += '<td valign="middle" style="text-align: center;"><table><tr><td style="padding:0"><input name="OtPharmacySalesBill[itemWiseDiscountAmount][]" type="text" class="textBoxExpnd itemWiseDiscountAmount" fieldNo="'+counter+'" id="itemWiseDiscountAmount'+counter+'" value="" style="width: 100%;" autocomplete="off"/><input type="hidden" name="itemWiseDiscount[]" class="itemWiseDiscount" fieldNo="'+counter+'" id="itemWiseDiscount'+counter+'" value=""/></td><td fielno="'+counter+'" id="displayDiscPer'+counter+'" style="padding:0"></td></tr></table></td>';
	    "<?php }else if(strtolower($this->Session->read('website.instance'))=='kanpur'){ ?>"
	    addRow += '<td valign="middle" style="text-align: center;"><table><tr><td style="padding:0"><input name="OtPharmacySalesBill[itemWiseDiscountAmount][]" type="text" class="textBoxExpnd itemWiseDiscountAmount" fieldNo="'+counter+'" id="itemWiseDiscountAmount'+counter+'" value="" style="width: 100%;" autocomplete="off"/><input type="hidden" name="itemWiseDiscount[]" class="itemWiseDiscount" fieldNo="'+counter+'" id="itemWiseDiscount'+counter+'" value=""/></td><td fielno="'+counter+'" id="displayDiscPer'+counter+'" style="padding:0"></td></tr></table></td>';
	    "<?php }?>"

		addRow += '<td><input name="OtPharmacySalesBill[amount][]" readonly="readonly" type="text" class="textBoxExpnd  validate[required,number] amount" id="amount_'+counter+'" value=""  style="width:100%;" autocomplete="off"/></td> ';
		addRow += '<td><a href="javascript:void(0);"  onclick="deleteRow('+counter+');"> <?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a></td>';
		addRow += '<tr>';   

		$("#counter").val(counter); 
		$("#item-row").append(addRow);
		
		itemAutoComplete("name_"+counter);
		$("#name_"+counter).focus();
		$(".expiry_date").datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
		    
		});
}

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
			$("#item_name-1").focus();
		}
		}
	});
}

function deleteRow(id){ 

	$("#row_"+id).remove(); 
	$(".formError").remove();
	var counter = parseInt($("#counter").val()); 
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

	var totalItemDiscount = 0;
    $('.itemWiseDiscountAmount').each(function() { 
	    if(this.value!== undefined  && this.value != ''  ){
        	totalItemDiscount += parseFloat(this.value);	       
        } 			        				        
    });

    $("#totalItemWiseDiscount").val(totalItemDiscount.toFixed(2)); 
	 
	$("#submitButton").removeAttr('disabled');
		var $form = $('#otPharmacyForm'),  
			$summands = $form.find('.amount');
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

/* load the data from supplier master */
function loadDataFromRate(itemID,selectedId){
	
	var currentField = selectedId.split("_");
	var fieldno = currentField[1]; 
	loading(fieldno);
	$("#expiryDate_"+fieldno).val("");
	$("#stockQty_"+fieldno).val("");
	$("#looseStockQty_"+fieldno).val("");
	$("#mrp_"+fieldno).val("");
	$("#rate_"+fieldno).val("");
	$("#amount_"+fieldno).val("");
	$("#pack_"+fieldno).val("");
	$("#qty_"+fieldno).val("");
	var room = $("#roomType").val(); 
	
	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "OtPharmacy", "action" => "fetch_rate_for_item",'item_id','true',"plugin"=>false)); ?>",
		  data: "item_id="+itemID+"&roomType="+room,
		}).done(function( msg ) {
		 	var item = jQuery.parseJSON(msg); 
		 	console.log(item);
		 	var pack = parseInt(item.OtPharmacyItem.pack);
		 	$("#name_"+fieldno).val(item.OtPharmacyItem.name);
			$("#itemId_"+fieldno).val(item.OtPharmacyItem.id);
			$("#productId_"+fieldno).val(item.OtPharmacyItem.product_id);
			$("#pack_"+fieldno).val(item.OtPharmacyItem.pack);
			$("#itemWiseDiscount"+fieldno).val(item.OtPharmacyItem.discount);
			 
			if( item.OtPharmacyItem.discount != null ||  item.OtPharmacyItem.discount > 0 ){
				showDisc = "&nbsp;("+item.OtPharmacyItem.discount+"%)";
			}else{
				showDisc = '';
			}
			
			$("#displayDiscPer"+fieldno).html(showDisc);
			
			batches= item.OtPharmacyItemRate; 
			var batchNo = new Array();
			
			$('.itemIdd').each(function(){
				var curField = $(this).attr('fieldNo');
				var itemId = $(this).val();
				if($("#batchNumber_"+curField).val() != '' && itemID == itemId && curField != fieldno ){ 
					batchNo.push($("#batchNumber_"+curField).val());
				} 
			});	
				
			$("#batchNumber_"+fieldno).find('option').remove();
			
			if(batches!=''){
				$.each(batches, function(index, value) { 
					if(batchNo != ''){
						$.each(batchNo,function(id,collctedBatchID){ 
							if(value.id != collctedBatchID){
						    	$("#batchNumber_"+fieldno).append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
							}
						}) ;
					}else{	
						$("#batchNumber_"+fieldno).append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
					}
				    
					if(index==0){
						var stock = parseInt(value.stock!="" ? value.stock : 0);
						var looseStock = parseInt(value.loose_stock!="" ? value.loose_stock:0);
					    if(isNaN(looseStock) == true){							/// If loose Stock is not a number
						    looseStock = 0;
					    }
					   	var myStock = (stock * pack) + looseStock;
						
						$("#stockWithLoose_"+fieldno).val(myStock);	
						$("#stockQty_"+fieldno).val(value.stock);
						$("#looseStockQty_"+fieldno).val(value.loose_stock);
						$("#expiryDate_"+fieldno).val(value.expiry_date);
						$("#mrp_"+fieldno).val(value.mrp);
						$("#rate_"+fieldno).val(value.sale_price);
		            }					
				});
			}
			
			var itemrateid=$("#batchNumber_"+fieldno).val();
			//var editUrl  = "<?php echo $this->Html->url(array('controller'=>'OtPharmacy','action'=>'edit_item_rate','inventory'=>false))?>";
			//$("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
			$("#qty_"+fieldno).attr('readonly',false);
			$("#qty_"+fieldno).focus();
			onCompleteRequest(fieldno);
	});
		selectedId='';
}

function onCompleteRequest(id){
	 $('#item-row').unblock();
}

$(document).on('keyup',".quantity",function() {
  	if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
  	checkStockLimit(this);
  	getTotal(this);
  });


function getTotal(id){
	if($(id)!=""){
		var fieldno = $(id).attr('fieldNo') ;
		var qty = parseInt($("#qty_"+fieldno).val()!=""?$("#qty_"+fieldno).val():0);
        var price = ($("#rate_"+fieldno).val()!="")?$("#rate_"+fieldno).val():0.00;
        var itemDiscount = ($("#itemWiseDiscount"+fieldno).val()!="")?$("#itemWiseDiscount"+fieldno).val():0.00;
        var qtyType = $("#itemType_"+fieldno).val();
        var packNan = isNaN($('#pack_'+fieldno).val()); 
		var pack = parseInt($('#pack_'+fieldno).val().match(/\d+/)); // 123456  from 123456ML
		
		if(price<=0){
			price = parseFloat(($("#mrp_"+fieldno).val()!="")?$("#mrp_"+fieldno).val():0.00);
		}
		
		if(qtyType == 'Tab'){
		 	var calAmnt = (price/pack)*qty; 	//calculate amnt per tablet
		 	var sub_total = (calAmnt * 100) / 100; 
		}else{
			var sub_total = (price*qty);
		}

		var itemDiscountAmount = (sub_total * itemDiscount)/100; 
		$("#itemWiseDiscountAmount"+fieldno).val(itemDiscountAmount.toFixed(2));
		
		var totalWithTax = sub_total;
		if(price != 0 || price !=''){
			$("#amount_"+fieldno).val(totalWithTax.toFixed(2));
		}
		var sum = 0;
		count = 1;
	    $('.amount').each(function() { 
		    if(this.value!== undefined  && this.value != ''  ){
	        	sum += parseFloat(this.value);	       
	        }
			count++;			        				        
	    });
	    
	    var totalItemDiscount = 0;
	    $('.itemWiseDiscountAmount').each(function() { 
		    if(this.value!== undefined  && this.value != ''  ){
	        	totalItemDiscount += parseFloat(this.value);	       
	        } 			        				        
	    }); 
	    
	    $("#totalItemWiseDiscount").val(totalItemDiscount.toFixed(2)); 	
		$("#total_amount_field").val((Math.round(sum.toFixed(2))));
		$("#total_amount").html(Math.round(sum.toFixed(2)));  
		var netAmount = sum - totalItemDiscount;  
		$("#net_amount").html(Math.round(netAmount.toFixed(2)));
		//alert($('#net_amount').html(sum.toFixed(2)));
		//calculateDiscount();
		return false;
    }
} 

$("#isDiscount").change(function(){
	if($(this).is(":checked",true)){
		$("#showDiscount").show();
	}else{
		$("#showDiscount").hide();
		$("#inputDiscount").val('');
		$("#discount").val('');
		$("#net_amount").html($("#total_amount_field").val());
		if($("#card_pay").is(":checked")){
			var chkpay= $('#net_amount').text();
			var cardPay=$('#cardBal').text();
			var otherPay=0;
			if(parseInt(chkpay)<parseInt(cardPay)){
				otherPay=0;
			    $('#patient_card').val(chkpay);
			}else{					
			   otherPay=chkpay-cardPay;
			   $('#patient_card').val(cardPay);
			}		
			 $('#otherPay').text(otherPay);
		}
	}
});

$('#payment_mode').change(function(){
	$("#showDiscountDetails").hide();
	if($("#payment_mode").val() == 'Cash'){
		$("#showDiscountDetails").show();
		$("#paymentInfoCreditCard").hide();
		$("#creditDaysInfo").hide();
		$("#neft-area").hide();
	}else if($("#payment_mode").val() == 'Credit'){
		$("#showDiscountDetails").hide();
		$("#isDiscount").attr('checked', false);
		$("#inputDiscount").val('');
		$("#discount").val('');
		$("#showDiscount").hide();
		calculateDiscount();
	}
});

function calculateDiscount(){
	var disc = ''; 
	var totalAmount = parseFloat($("#total_amount_field").val());
	$(".discountType").each(function () {  
        if ($(this).prop('checked')) {
           var type = this.value;
           var discount_value = parseFloat($("#inputDiscount").val()!= '' ? $("#inputDiscount").val() : 0);
          	
           if(type == "Amount") 
            {     
               if(discount_value <= totalAmount){
            	   disc = discount_value;
               }else{
				   alert("Discount Should be Less Than TotalAmount");
				   $("#inputDiscount").val('');
					$("#inputDiscount").focus();
					calculateDiscount();
               }
            }else if(type == "Percentage"){ 
				if(discount_value < 101){ 
       		    	disc = parseFloat(((totalAmount*discount_value)/100));
				}else{
					alert("Percentage should be less than or equal to 100");
					$("#inputDiscount").val('');
					$("#inputDiscount").focus();
					calculateDiscount();
				}
            }
           
           //$("#discount").val(disc.toFixed(2));
        }
    });
	
	
	var netAmnt = parseFloat(totalAmount) - disc;
	
	//$("#discount").val(disc.toFixed(2)); 
	$("#net_amount").html(netAmnt.toFixed(2));
	
}

$("#inputDiscount").keyup(function(){
	calculateDiscount();
});

$(".discountType").change(function(){
	calculateDiscount();
});

$("#submitButton").click(function(){
	var flag = false; 
	$('.itemIdd').each(function(){
		var curField = $(this).attr('fieldNo');
		var itemId = $(this).val();
		var batchNo = $("#batchNumber_"+curField).val();
		$("#row_"+curField).removeClass("alert-row");
		$('.itemIdd').each(function(){
			var tempField = $(this).attr('fieldNo');
			var tempId = $(this).val();
			var tempBatch = $("#batchNumber_"+tempField).val();
			if( itemId == tempId && batchNo == tempBatch && curField != tempField){		//same item having same batch but different row
				alert("you've selected same product with same batch");
				$("#row_"+tempField).addClass("alert-row");
				flag = true;
				return false;
			}
		});
		if(flag == true){
			return false;
		}
	});		

	if(flag == false){
		var count = 0;
		 $('.quantity').each(function(){ 
		    if(this.value!== undefined  && this.value != ''  ){
			    var fieldno = $(this).attr('fieldNo');
			    var qty = parseInt($("#qty_"+fieldno).val());
		        var qtyType = $("#itemType_"+fieldno).val();
		        var pack = parseInt($("#pack_"+fieldno).val().match(/\d+/));

		        var stockQty = parseInt($("#stockWithLoose_"+fieldno).val());
		    	var totalTab = (pack * stockQty);
		    	var TotalQty = Math.floor(totalTab/pack);
		    	
		    	if(qtyType == "Tab"){
		    		TotalQty = totalTab;
			    }
		        if(qty > TotalQty){
		            alert("Quantity Is Greater Than Stock");
		            $("#qty_"+fieldno).val('');
		            $("#qty_"+fieldno).focus();
		            return false;
		        }	
	        }			        				        
	    });

		var valid=jQuery("#otPharmacyForm").validationEngine('validate');
		  
		if(valid){
			$("#submitButton").hide();
			$('#busy-indicator').show();
		}else{
			return false;
		}
	}
});

/* To check the Item Stock */
function checkStockLimit(id){	
		if($(id)!=""){
			var fieldno = $(id).attr('fieldNo') ; 
			var qty = parseInt($("#qty_"+fieldno).val()); 
	        var qtyType = $("#itemType_"+fieldno).val();
	        var pack = parseInt($('#pack_'+fieldno).val().match(/\d+/));
	       
	    	var stockQty = parseInt($("#stockQty_"+fieldno).val());
	    	var looseStock = parseInt($("#looseStockQty_"+fieldno).val()!=''?$("#looseStockQty_"+fieldno).val():0);
	    	
	    	var totalTab = (pack * stockQty) + looseStock; 
	    	var TotalQty = Math.floor(totalTab/pack);
	    	
	    	if(qtyType == "Tab"){
	    		TotalQty = totalTab;
		    }
	        if(qty > TotalQty){
	            alert("Quantity Is Greater Than Stock");
	            $("#qty_"+fieldno).val('');
	            $("#qty_"+fieldno).focus();
	            return false;
	        }
	        return true;
		}
	  }


$(document).on('keypress','.quantity',function(e) {
	 	var fieldNo = $(this).attr('fieldNo') ; 
	    if (e.keyCode==40) {	//key down
	        var nextRow = parseInt(fieldNo)+1;
	        $("#qty_"+nextRow).focus();
	    } 
	    if (e.keyCode==38) {	//up key
	    	var prevRow = parseInt(fieldNo)-1;
	        $("#qty_"+prevRow).focus();
	    } 
	    if(e.keyCode==13){		//key enter
		    if($("#itemId_"+fieldNo).val()!=0 || $("#itemId_"+fieldNo).val()!=''){
	    		addFields();
		    }
	    }
	});

/* For Generic Search */
	$(document).ready(function(){
		//script for open generic search by Swapnil G.Sharma
		 $(".showGeneric").click(function(){
			 var fieldNo = $(this).attr("fieldNo");
		});		
	});

  	function showGeneric(fieldNo){
  	  	var genericName = $("#genericName"+fieldNo).val();
  		$.fancybox(
			    {
			    	'autoDimensions':false,
			    	'width'    : '85%',
				    'height'   : '90%',
				    'autoScale': true,
				    'transitionIn': 'fade',
				    'transitionOut': 'fade',						    
				    'type': 'iframe',
				    'href': '<?php echo $this->Html->url(array( "action" => "generic_search")); ?>'+"/"+fieldNo+"/"+genericName,
			});
  	}
  	
  	function setInformation(productId,fieldNo){		//this function will be called from fancy page of inventory_generic_search
		var selectedId = "name_"+fieldNo;
		loadDataFromRate(productId,selectedId);
	}

  $(document).on('input',"#totalItemWiseDiscount",function(){
  	if (/[^0-9\.]/g.test(this.value)){  this.value = this.value.replace(/[^0-9\.]/g,'');  }
  	if(this.value.split('.').length>2) 
  		this.value =this.value.replace(/\.+$/,"");
  });

  $(document).on('keyup',"#totalItemWiseDiscount",function(){
		var disc = parseFloat($("#totalItemWiseDiscount").val()!=''?$("#totalItemWiseDiscount").val():0);
		var total = parseFloat($("#total_amount_field").val());
		if(disc > total){
			alert("discount amount should not be greater than total amount");
			$("#totalItemWiseDiscount").val('');
			$("#totalItemWiseDiscount").focus();
			disc = 0;
		}
		var netAmount = total - disc; 
		$("#net_amount").html(netAmount.toFixed());
	});
	  
  		
/* END Of Generic Search */

$(document).on('change',".batch_number",function()
{
	var t = $(this);
	var fieldno = t.attr('fieldno') ;
	loading(fieldno);
	$.ajax({
		type: "GET",
        url: "<?php echo $this->Html->url(array("controller" => "OtPharmacy", "action" => "fetch_batch_for_item","plugin"=>false)); ?>",
        data: "itemRate="+$(this).val(),
        success: function(data){
			var ItemDetail = jQuery.parseJSON(data);
			var stock = parseInt(ItemDetail.OtPharmacyItemRate.stock);
			var looseStock = parseInt(ItemDetail.OtPharmacyItemRate.loose_stock);
			var pack = parseInt(ItemDetail.OtPharmacyItem.pack);
			var myStock = (stock * pack) + looseStock;
			$("#stockWithLoose_"+fieldno).val(myStock);
			$("#stockQty_"+fieldno).val(ItemDetail.OtPharmacyItemRate.stock);
			$("#looseStockQty_"+fieldno).val(ItemDetail.OtPharmacyItemRate.loose_stock);
			$("#mrp_"+fieldno).val(ItemDetail.OtPharmacyItemRate.mrp);
			$("#rate_"+fieldno).val(ItemDetail.OtPharmacyItemRate.sale_price);
            $("#expiryDate_"+fieldno).val(ItemDetail.OtPharmacyItemRate.expiry_date);
            var itemrateid=$('#batchNumber_'+fieldno).val();
            var itemID=$('#itemId_'+fieldno).val();
			//var editUrl  = "<?php echo $this->Html->url(array('controller'=>'OtPharmacy','action'=>'viewBatches'))?>";
			//$("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
			getTotal(t);
			onCompleteRequest(fieldno);
		}
	});
	
});


/* Remove All fields as item removed from autocomplete */
 
 function checkIsItemRemoved(obj){
	var fieldno = $(obj).attr('fieldNo') ;
	if($.trim(obj.value.length)==0){

			$("#name_"+fieldno).val("");
			$("#itemId"+fieldno).val("");
			$("#pack_"+fieldno).val("");
            $("#mrp_"+fieldno).val("");
			$("#rate_"+fieldno).val("");
			$("#stockQty_"+fieldno).val("");
			$("#stockWithLoose_"+fieldno).val("");
			$("#batchNumber_"+fieldno).find('option').remove();
		 	$("#expiry_date"+fieldno).val("");
			$("#qty_"+fieldno).val("");
			$("#amount_"+fieldno).val("");
			
	}

}

 function loading(id){
	    $('#item-row').block({
	        message: '',
	       css: {
	            padding: '5px 0px 5px 18px',
	            border: 'none',
	            padding: '15px',
	            backgroundColor: '#000000',
	            '-webkit-border-radius': '10px',
	            '-moz-border-radius': '10px',
	            color: '#fff',
	            'text-align':'left'
	        },
	        overlayCSS: { backgroundColor: '#cccccc' }
	    });
	}
  
 

 
 
</script>