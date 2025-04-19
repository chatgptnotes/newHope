<?php  
	echo $this->Html->script(array('jquery.blockUI'));
?>
<style>
.formError .formErrorContent {
	width: 60px;
}

.disabled {
	background: -moz-linear-gradient(center top, #3E474A, #343D40) repeat
		scroll 0 0 transparent;
}
</style>
<style>
.requisition_option {
	display: none;
}

.tabularForm td {
	background: none repeat scroll 0 0 #ddd;
	color: #000;
	font-size: 13px;
	padding: 3px 15px;
}
</style>
<?php
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php
				foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
			</div>
		</td>
	</tr>
</table>
<?php }

?>
<?php	$slip_detail  = $storeDetails;?>
<input
	type="hidden" value="<?php echo count($slip_detail);?>"
	id="no_of_fields" />
<div class="inner_title">
	<h3>Stock Requisition Slip - Edit</h3>
	<span><?php  echo $this->Html->link(__('Back'), array('action' => 'stock_requisition_list'), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>
<p class="ht5"></p>

<!-- billing activity form start here -->
<?php echo $this->Form->create('StoreRequisition');?>

<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm">
	<tr>
		<th colspan="5">STOCK REQUISITION &amp; ISSUE SLIP</th>
	</tr>

	<tr>
	<td width="10%" class="tdLabel" colspan=""><?php echo __('Requisition From:'); ?>
		</td>


		<td width="150" colspan=""><?php
		                echo $this->Form->input('StoreRequisition.location_from_id',
                                array('label'=> false, 'error' => false,'empty'=>'Select Other Location',
                                'options'=>$accessableLocation,'div'=>false,'class'=>'requisition_selector validate[required]','id'=>'location_from','selected'=>$StoreRequisition['StoreRequisition']['requisition_by'])); 
				echo $this->Form->hidden('StoreRequisition.stock_requisition_flag',array('id'=>'stock_requisition_flag','value'=>true));
			
				?> 
		</td>
		<td width="10%" class="tdLabel" colspan=""><?php echo __('Requisition To:'); ?>
		</td>
		<td width="180" class="tdLabel"><?php
 			echo $this->Form->input('StoreRequisition.requisition_for',
                                array('label'=> false, 'error' => false,'empty'=>'Select Other Location',
                                'options'=>$accessableLocation,'div'=>false,'class'=>'requisition_selector validate[required]','id'=>'location_to','selected'=>$StoreRequisition['StoreRequisition']['requisition_for']));
			//echo $this->Form->hidden('StoreRequisition.location_to_id',array('id'=>'location_to_id')); 
		              ?>
		</td>
		
	</tr>
	<!-- <tr>
		<td width="150" class="tdLabel" colspan=""><?php echo __('Store Location:'); ?>
		</td>
		<td width="150" class="tdLabel" colspan="2"><?php
		echo $this->Form->input('StoreRequisition.store_location_id', array('value'=>$StoreRequisition['StoreRequisition']['store_location_id'],
                     'id' => 'storeLocation', 'label'=> false,'div' => false, 'error' => false,'empty'=>'Please Select',
                                'options'=>$centralStoreDepart,'div'=>false,'class'=>'textBoxExpnd  validate[required]','style'=>'width : 17%;'));
               ?>
		</td>
	</tr> -->
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" id="tabularForm">
	<tr>
		<th width="200">Item Name<font color="red">*</font>
		</th>
		<th width="130" align="center">Requisition Quantity<font color="red">*</font>
		</th>
		<th width="60">Pack</th>
        <th width="123" align="center">Stock Quantity From</th>
		<th width="150" align="center">Stock Quantity To</th>
        <!--<th width="100">Limit</th>
        <td width="110" align="center">Issue Quantity</td> -->
		<th>Remark</th>
		<th width="50" align="center">Remove</th>
	</tr>
	<?php
	$i=0;	
	foreach($slip_detail as $key=>$value){
		$i++;
					 ?>
	<tr id="row<?php echo $i;?>">
		<td><input name="StoreRequisition[slip_detail][item_name][]"
			type="text" class="textBoxExpnd validate[required]"
			id="item_name<?php echo $i;?>" style="width: 180px;"
			value="<?php echo $value['PharmacyItem']['name'];?>" />
			<input	name="StoreRequisition[slip_detail][existing_stock_order_item_id][]" type="hidden"
			class="textBoxExpnd Pitem_id" id="pitemIdfrm1" fieldNo="1" />
			 <input
			name="StoreRequisition[slip_detail][item_id][]" type="hidden"
			class="textBoxExpnd item_id" id="item_id<?php echo $i;?>"
			style="width: 180px;"
			value="<?php echo $value['StoreRequisitionParticular']['item_id'];?>" />
			<input name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden"
			class="textBoxExpnd Pitem_id" id="Pitem_id<?php echo $i;?>" fieldNo="<?php echo $i;?>"
			value="<?php echo $value['PurchaseOrderItem']['id'];?>" />			
			<input name="StoreRequisition[slip_detail][id][]" type="hidden"
			class="textBoxExpnd id" id="id<?php echo $i;?>" style="width: 180px;"
			value="<?php echo $value['StoreRequisitionParticular']['id'];?>" /></td>
		<td><input name="StoreRequisition[slip_detail][qty][]" type="text"
			class="textBoxExpnd validate[required,custom[number]]"
			id="qty<?php echo $i;?>" style="width: 110px;"
			value="<?php echo $value['StoreRequisitionParticular']['requested_qty'];?>" />
		</td>
		 <td align="center" id="pack<?php echo $i;?>"> <?php echo $value['PharmacyItem']['pack'];?> </td>  
		 <td align="center" id="stockfrm<?php echo $i;?>"><?php echo $value['PharmacyItemAlias']['stock']*$value['PharmacyItemAlias']['pack']+$value['PharmacyItemAlias']['loose_stock']; ?>  
		  </td>
        <!--  <td align="center" id="limit<?php echo $i;?>"> <?php echo $value['Product']['maximum'];?> </td>
		
		</td> -->
		 <td align="center" id="stock<?php echo $i;?>"><?php echo  $value['PharmacyItem']['stock']*$value['PharmacyItem']['pack']+$value['PharmacyItem']['loose_stock']; ?>  
		 </td>
		<!--<td><input name="StoreRequisition[slip_detail][issued_qty][]" type="text" class="textBoxExpnd validate[custom[number]] disabled" id="issued_qty<?php echo $i;?>" style="width:180px;" value="<?php  if(isset($value['StoreRequisitionParticular']['issued_qty'])){echo $value['StoreRequisitionParticular']['issued_qty'];}?>" readonly="true"/></td> -->
		<td><input name="StoreRequisition[slip_detail][remark][]" type="text"
			class="textBoxExpnd" id="remark<?php echo $i;?>"
			style="width: 95%; min-width: 200px;"
			value="<?php echo $value['StoreRequisitionParticular']['remark'];?>" />
		</td>

		<td align="center"><a href="javascript:void(0);" 
			onclick="deleteRow(<?php echo $i.",".$value['StoreRequisitionParticular']['id'];?>)"><img border="0" alt=""
				src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"> </a></td>

	</tr>
	<?php }	 ?>
</table>
<!-- billing activity form end here -->
<div
	class="btns">
	<input type="button" value="Add Row" class="blueBtn"
		onclick="addFields()" />
	<!--<input name="" type="button" value="Remove" class="blueBtn" tabindex="36" id="remove-btn"  <?php if(count($slip_detail['item_name'])<2) {echo 'style="display:none"';}?> onclick="removeRow()"/>-->

</div>
<div class="clr"></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="tdLabel2" style="border: 1px solid #3E474A; padding: 10px;">
	<tr>
		<td width="250" align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="155px"><?php echo "Expiration of Requisition : "?></td>
					<td><?php $expdate=$this->DateFormat->formatDate2localForReport($StoreRequisition['StoreRequisition']['requisition_expiry_date'],Configure::read('date_format'),true);
					echo $this->Form->input('StoreRequisition[req_expiry]',array('id'=>'req_exp','class'=>'textBoxExpnd validate[required]','value'=>$expdate,'label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr>
					<td height="22" colspan="2" valign="top">Requisition By:</td>
				</tr>
				<tr>
					<td width="60" height="25">Name</td>
					<td><input name="StoreRequisition[requisition_by_name]" type="text"
						class="textBoxExpnd requisition_name" id="requisition_by"
						style="width: 180px;" value="<?php echo $req_by_name;?>" /> <input
						name="StoreRequisition[requisition_by]" type="hidden" class=""
						id="requisition_id"
						value="<?php echo $requsition_by_location['Location']['id'];?>" />
					</td>
				</tr>
				<tr>
					<td height="25">Date</td>
					<td><table width="165" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="140"><input name="StoreRequisition[requisition_date]"
									type="text" class="textBoxExpnd datetime" id="requisition_date"
									style="width: 120px;"
									value="<?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['requisition_date'],Configure::read('date_format'),true);?>" />
								</td>
							</tr>
						</table></td>
				</tr>
			</table>

		</td>
		<td width="30">&nbsp;</td>
		<!--  <td width="250" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td height="22" colspan="2" valign="top">Issue By:</td>
                              </tr>
                              <tr>
                                <td width="60" height="25">Name</td>
                                <td><input name="StoreRequisition[issue_by_name]" type="text" class="textBoxExpnd disabled" id="issue_by" style="width:180px;" value="<?php echo $issue_by_name;?>" disabled="disabled"/>
                                <input name="StoreRequisition[issue_by]" type="hidden" class="" id="issue_id"  value="<?php echo $StoreRequisition['StoreRequisition']['issue_by'];?>"/></td>
                              </tr>
                              <tr>
                                <td height="25">Date</td>
                                <td><table width="165" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="140"><input name="StoreRequisition[issue_date]" type="text" class="textBoxExpnd datetime disabled" id="issue_date" style="width:120px;" value="<?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['issue_date'],Configure::read('date_format'),true);?>" disabled="disabled"/></td>
                                     </tr>
                                </table></td>
                              </tr>

                            </table></td>-->
		<td width="30">&nbsp;</td>
		<td width="250" align="left" valign="top"><table width="100%"
				border="0" cellspacing="0" cellpadding="0">
				<!-- <tr>
					<td height="22" colspan="2" valign="top">Entered By:</td>
				</tr>-->
				<tr>
					<!-- <td width="60" height="25">Name</td> -->
					<td><!--<input name="StoreRequisition[entered_by_name]" type="text"
						class="textBoxExpnd entered_name" id="entered_by"
						style="width: 180px;" value="<?php echo $requsition_for_location['Location']['name'];?>" />  --><input
						name="StoreRequisition[entered_by]" type="hidden" class=""
						id="entered_id"
						value="<?php echo $requsition_for_location['Location']['id'];?>" />
					</td>
				</tr>
				<!--<tr>
					<td height="25">Date</td>
					<td><table width="165" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="140"><input name="StoreRequisition[entered_date]"
									type="text" class="textBoxExpnd datetime" id="entered_date"
									style="width: 120px;"
									value="<?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['entered_date'],Configure::read('date_format'),true);?>" />
								</td>
							</tr>
						</table></td>
				</tr>
 -->
			</table></td>
	</tr>
</table>
<div class="clr">&nbsp;</div>
<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="tdLabel2">
	<tr>
		<td width="300" valign="top"><table width="100%" border="0"
				cellspacing="0" cellpadding="0">

				<tr>
					<td width="170" height="25">Reviewed</td>
					<td><input name="StoreRequisition[reviewed_by]" type="text"
						class="textBoxExpnd reviewed_name" id="reviewed_by"
						style="width: 200px;"
						value="<?php echo $StoreRequisition['StoreRequisition']['reviewed_by'];?>" />
					</td>
				</tr>
				<tr>
					<td height="25" style="min-width: 170px;">Management Representative</td>
					<td><input name="StoreRequisition[management_representative]"
						type="text" class="textBoxExpnd" id="management_representative"
						style="width: 200px;"
						value="<?php echo $StoreRequisition['StoreRequisition']['management_representative'];?>" />
					</td>
				</tr>

			</table></td>
		<td width="30">&nbsp;</td>
		<td width="300" valign="top"><table width="100%" border="0"
				cellspacing="0" cellpadding="0">
				
				<tr>
					<td height="25">Proprietor</td>
					<td><input name="StoreRequisition[proprietor]" type="text"
						class="textBoxExpnd" id="proprietor" style="width: 200px;"
						value="<?php echo $StoreRequisition['StoreRequisition']['proprietor'];?>" />
					</td>
				</tr>

			</table></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
 -->
<div class="btns">
	<input name="submit" type="submit" value="Submit" class="blueBtn submit" />

</div>
<!-- Right Part Template ends here -->
</td>
</table>
<!-- Left Part Template Ends here -->

</div>
</td>
<td width="5%">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td class="footStrp">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>
<?php echo $this->Form->end();?>
<script>
	jQuery(document).ready(function(){
	var selectedDD = '<?php echo $selectedRadio; ?>';
	$('#'+selectedDD).show();
	// binds form submission and fields to the validation engine
	jQuery("#StoreRequisitionStoreRequisitionForm").validationEngine();
	});
	$(".datetime, #req_exp").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		minDate:-1,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate("HH:mm");?>',
		
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
				 "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Invalid format"
                }
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

function addFields(){
		   var number_of_field = parseInt($("#no_of_fields").val())+1;		 
           var field = '';
		   field += '<tr id="row'+number_of_field+'"> ';
		   field += ' <td><input name="StoreRequisition[slip_detail][item_name][]" type="text" class="textBoxExpnd validate[required] item_name" id="item_name'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/><input name="StoreRequisition[slip_detail][item_id][]" type="hidden" class="textBoxExpnd item_id" id="item_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> <input name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden" class="textBoxExpnd Pitem_id" id="Pitem_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/><input name="StoreRequisition[slip_detail][existing_stock_order_item_id][]" type="hidden" class="textBoxExpnd pitemIdfrm" id="pitemIdfrm'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/></td>';
		   field += ' <td><input name="StoreRequisition[slip_detail][qty][]" type="text" class="textBoxExpnd validate[required,custom[number]] quantity" id="qty'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:110px;"/> </td>';
		   field += '<td align="center" id="pack'+number_of_field+'"></td>';
		   field += '<td align="center" id="stockfrm'+number_of_field+'"></td>';
		   field += '<td align="center" id="stock'+number_of_field+'"></td>';
		  // field += '<td align="center" id="limit'+number_of_field+'"></td>';
		   field += ' <td><input name="StoreRequisition[slip_detail][remark][]" type="text" class="textBoxExpnd validate[required] remark" id="remark'+number_of_field+'" style="width:95%; min-width:200px;"/> </td>';
		   field += ' <td align="center"><a href="javascript:void(0);" onclick="deleteRow('+number_of_field+')"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>';
		   field +='  </tr>    ';

      	$("#no_of_fields").val(number_of_field);
		$("#tabularForm").append(field);
		if (parseInt($("#no_of_fields").val()) == 1){
			$("#remove-btn").css("display","none");
		}else{
			$("#remove-btn").css("display","inline");
		}
}
function deleteRow(rowId,itemId){
var number_of_field = parseInt($("#no_of_fields").val());
if(number_of_field > 1){
		$("#row"+rowId).remove();
		$('.qty'+rowId+"formError").remove();
		$('#stock'+rowId+"formError").remove();
		$('.issued_qty'+number_of_field+"formError").remove();
		$('.remark'+rowId+"formError").remove();
		$('.item_name'+rowId+"formError").remove();
		//$("#no_of_fields").val(number_of_field-1);

		if(itemId)delete_item('stock',itemId);	
		
	}

}
function removeRow(){
 	var number_of_field = parseInt($("#no_of_fields").val());
	$('.qty'+number_of_field+"formError").remove();
	$('#stock'+rowId+"formError").remove();
	$('.issued_qty'+number_of_field+"formError").remove();
	$('.remark'+number_of_field+"formError").remove();
	$('.item_name'+number_of_field+"formError").remove();
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();

		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}
}
 $(".requisition_selector").click(function(){
        $(".requisition_option").css("display","none");
        var position = $(this).position();
        var txt=$('.requisition_selector option:selected').text()
        $('#for_name').val(txt);
        switch($('.requisition_selector option:selected').text())
            {
                case 'Ward':
                 $("#ward").css("display","block");

                break;
                case 'OT':
                 $("#ot").css("display","block");

                break;
                case 'Chamber':

                    $("#chamber").css("display","block");

                break;
                case 'Other':
                      $("#other").css("display","block");

                break;
                default:


                break;

            }

    });
 
 $(document).ready(function(){
	
	$(document).on('focus','.item_name', function() {
		var flag=false;
		fieldNo= $(this).attr('fieldNo');
		//alert(fieldNo);
		var t = $(this);
		var departmentId = $('#other').val();
		var LocIdFrm = $('#location_from').val();
		var LocIdTo = $('#location_to').val();	//send storeLocation id to fetch the product
        $(this).autocomplete({
             source: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "pharmacy_stock","admin" => false,"plugin"=>false)); ?>"+'/'+LocIdFrm+'/'+LocIdTo,
                 minLength: 1,
                 select: function( event, ui ) {
                	 selectedId = t.attr('id');
                	 console.log(ui.item);
				   //Code to avoid duplicate entry of product in list
                  	 var currentField = $("#"+selectedId);
                	 var itemID = ui.item.pId; //purchase order detail id
                	 var itemid = ui.item.id;
					var exist = false;
				
                	 $(".item_id").each(function(){                		
             			if(this.value == itemid){             				
                 			exist = true; 
                 			return false;
             			} 
             		 });
					if(exist == true){
	       				alert("This Item already in list please select another.");
	       				$("#submitButton").attr('disabled','disabled');
	       				currentField.val("");
	       				$("#item_name"+fieldNo).val("");
	       				$("#item_name"+fieldNo).focus();
	       				$('#item_id'+fieldNo).val("");
	       				$('#stock'+fieldNo).val("");
	       			 	$("#pack"+fieldNo).val("");
	       			    $('#limit'+fieldNo).val("");
	       			    $('#Pitem_id'+fieldNo).val("");
	       			 $('#stockfrm'+fieldNo).html(ui.item.quantityFrm);
      				// $('#pitemIdfrm'+fieldNo).html(ui.item.pItemIdFrm);
      				$('#pitemIdfrm'+fieldNo).val(ui.item.pItemIdFrm);
	       				return false;
       				}
	         	      if(exist == false){
	             	     var value=ui.item.value;	             	
	             	     var split=value.split('(');
	             	     ui.item.value=split[0];   	             	  
	             	     var pack = parseInt(ui.item.pack);
	             	     var quantity = parseInt(ui.item.quantity);
	             	  
	             	    // var msu = pack * quantity; 
	             	 
	             	     loading(fieldNo);  	      
	         	    	 $('#item_name'+fieldNo).val(split[0]); 
	      				 $('#item_id'+fieldNo).val(ui.item.id); 
	      				 
	      				 $('#stockfrm'+fieldNo).html(ui.item.quantityFrm);
	      				 $('#pitemIdfrm'+fieldNo).val(ui.item.pItemIdFrm); 
	      					      				
	      				 $('#stock'+fieldNo).html(quantity);
	      				 $('#pack'+fieldNo).html(ui.item.pack);
	      				 $('#limit'+fieldNo).html(ui.item.max);
	      				 $('#Pitem_id'+fieldNo).val(ui.item.pId);
	      				 $('#qty'+fieldNo).focus();
	      				
	      				 onCompleteRequest(fieldNo);
	      			}	  
                 },
                 messages: {
                        noResults: '',
                        results: function() {},
                 },
               
            });
       
     });
    
	
	
	 $("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
	});
 $(".requisition_name").focus(function(){
	$("#requisition_by").val('');
	$("#requisition_id").val('');
	$(this).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Users", "action" => "user_autocomplete","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#requisition_id').val(ui.item.id); 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
 });

 $(".issue_name").focus(function(){
		$("#issue_by").val('');
		$("#issue_id").val('');
		$(this).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Users", "action" => "user_autocomplete","admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				 $('#issue_id').val(ui.item.id); 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	 });
 $(".entered_name").focus(function(){
		$("#entered_by").val('');
		$("#entered_id").val('');
		$(this).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Users", "action" => "user_autocomplete", "admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				 $('#entered_id').val(ui.item.id); 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	 });
 $(document).on('change','.quantity', function() {	 
	 fieldNo= $(this).attr('fieldNo');
	 var stock=$('#stock'+fieldNo).html();
	 var reqQty=$('#qty'+fieldNo).val();
	 var limit=$('#limit'+fieldNo).html();
	/* if(parseInt(reqQty) > parseInt(stock)){
		 alert('Requested quatity is exceeding from Stock quantity');
		 $('#qty'+fieldNo).val('');
	
	 }
	 if(parseInt(reqQty) > parseInt(limit)){
		 alert('Maximum Order Limit is '+limit+'. You can not Order More than the limit quantity');
		 $('#qty'+fieldNo).val('');
		
	 }*/
	
 });

//alert for requisition expiry--Pooja
/* $(".submit").click(function(){
	 if($('#req_exp').val()!='')
	  var expiry=confirm('Your Requistion will expires on '+$('#req_exp').val());
	 if(expiry){
		 return true;
	 }else{
		 $('#req_exp').val('');
		 $('#req_exp').focus();
		 return false;
	 }
 });*/


//*********************************************Ajax call to delete Items of all type***************************************
 function delete_item(modelName,preRecordId){ 
 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "InventoryCategories", "action" => "deleteItems","admin" => false)); ?>"+"/"+modelName+"/"+preRecordId;
 $.ajax({	
 	 beforeSend : function() {
 		// this is where we append a loading image
 		$('#busy-indicator').show('fast');
 		},
 		                           
  type: 'POST',
  url: ajaxUrl,
  dataType: 'html',
  success: function(data){
 	  $('#busy-indicator').hide('fast');
   		$("#resultorder").html(" ");  
  },
 	error: function(message){
 		alert("Error in Retrieving data");
  }        
  });
 }
  //**************************************************end of ajax calls****************************************************** 
 
 
</script>