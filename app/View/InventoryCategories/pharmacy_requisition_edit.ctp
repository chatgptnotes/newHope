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
<?php	
$slip_detail  = $storeDetails;
	
?>
<input
	type="hidden" value="<?php echo count($slip_detail);?>"
	id="no_of_fields" />
<div class="inner_title">


	<h3>Pharmacy Requisition Slip - Edit</h3>
	
		<span><?php  echo $this->Html->link(__('Back'), array('action' => 'store_requisition_list','?'=>array('pharmacy'=>'pharmacy')), array('escape' => false,'class'=>"blueBtn"));?>
		</span>
	
	
	
</div>
<p class="ht5"></p>

<!-- billing activity form start here -->
<?php echo $this->Form->create('StoreRequisition',array('onkeypress'=>"return event.keyCode != 13;",'id'=>'storeRequisition'));?>

<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm">
	<tr>
		<th colspan="5">STORE REQUISITION &amp; ISSUE SLIP</th>
	</tr>
	<td width="26%" class="tdLabel" colspan=""><?php echo __('Requisition for:'); ?>
		</td>

		<?php $selectedRadio = $StoreRequisition['StoreRequisition']['requisition_for']; ?>
		<td width="18%" colspan="">
			Pharmacy
		</td>
		
		<td class="tdLabel"><?php 
		if($storeLocation['StoreLocation']['name']=='Ward'){
                     echo $this->Form->input('StoreRequisition.ward',array('id' => 'ward', 'label'=> false, 'div' => false, 'error' => false,
                     'empty'=>'Please Select ward','value'=>$StoreRequisition['StoreRequisition']['requister_id'],'style'=>'display: block;',
                                'options'=>$wards,'div'=>false,'class'=>'requisition_option validate[required]'));
                }
                ?> <?php if($storeLocation['StoreLocation']['name']=='OT'){
                	echo $this->Form->input('StoreRequisition.ot', array('id' => 'ot', 'label'=> false,'value'=>$StoreRequisition['StoreRequisition']['requister_id'],
                     'div' => false, 'error' => false,'empty'=>'Please Select OT',
                                'options'=>$ot,'div'=>false,'class'=>'requisition_option  validate[required]'));
                }
                ?> <?php if($storeLocation['StoreLocation']['name']=='Chamber'){
                	echo $this->Form->input('StoreRequisition.chamber',array( 'id' =>'chamber', 'label'=> false,'value'=>$StoreRequisition['StoreRequisition']['requister_id'],
                      'div' => false, 'error' => false,'empty'=>'Please Select chamber',
                                'options'=>$chambers,'div'=>false,'class'=>'requisition_option  validate[required]'));
                }
                ?> <?php
                echo $this->Form->input('StoreRequisition.other',array('id' => 'other', 'label'=> false,'value'=>$StoreRequisition['StoreRequisition']['requister_id'],
                     'div' => false, 'error' => false,'empty'=>'Please Select',
                                'options'=>$department,'div'=>false,'class'=>'requisition_option  validate[required]'));
               ?>
		</td>
	</tr>
	<tr>
		<td width="150" class="tdLabel" colspan=""><?php echo __('Store Location:'); ?>
		</td>
		<td width="150" class="tdLabel" colspan="2"><?php 
		echo $this->Form->input('StoreRequisition.store_location_id', array('id' => 'storeLocation', 'label'=> false,'div' => false, 'error' => false,
                                'options'=>$centralStoreDepart,'value'=>$requestedTo,'div'=>false,'class'=>'textBoxExpnd  validate[required]','style'=>'width : 17%;'));
               ?>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" id="tabularForm">
	<tr>
		<th width="200">Item Name<font color="red">*</font>
		</th>
		<th width="130" align="center">Requisition Quantity<font color="red">*</font>
		</th>
		<th width="100">Package</th>
        <th width="100">Stock Quantity</th>
        <th width="100">Limit</th>
        <!--<td width="110" align="center">Issue Quantity</td> -->
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
			value="<?php echo $value['Product']['name'];?>" /> <input
			name="StoreRequisition[slip_detail][item_id][]" type="hidden"
			class="textBoxExpnd item_id" id="item_id<?php echo $i;?>"
			style="width: 180px;"
			value="<?php echo $value['StoreRequisitionParticular']['item_id'];?>" />
			<input name="StoreRequisition[slip_detail][id][]" type="hidden"
			class="textBoxExpnd id" id="id<?php echo $i;?>" style="width: 180px;"
			value="<?php echo $value['StoreRequisitionParticular']['id'];?>" /></td>
		<td><input name="StoreRequisition[slip_detail][qty][]" type="text"
			class="textBoxExpnd validate[required,custom[number]]"
			id="qty<?php echo $i;?>" style="width: 180px;"
			value="<?php echo $value['StoreRequisitionParticular']['requested_qty'];?>" />
		</td>
		 <td align="center" id="pack<?php echo $i;?>"> <?php echo $value['Product']['pack'];?> </td>  
		 <td align="center" id="stock<?php echo $i;?>"><?php echo  $value['Product']['quantity']; ?>       
         <td align="center" id="limit<?php echo $i;?>"> <?php echo $value['Product']['maximum'];?> </td>
		
		</td>
		<!--<td><input name="StoreRequisition[slip_detail][issued_qty][]" type="text" class="textBoxExpnd validate[custom[number]] disabled" id="issued_qty<?php echo $i;?>" style="width:180px;" value="<?php  if(isset($value['StoreRequisitionParticular']['issued_qty'])){echo $value['StoreRequisitionParticular']['issued_qty'];}?>" readonly="true"/></td> -->
		<td><input name="StoreRequisition[slip_detail][remark][]" type="text"
			class="textBoxExpnd" id="remark<?php echo $i;?>"
			style="width: 95%; min-width: 200px;"
			value="<?php echo $value['StoreRequisitionParticular']['remark'];?>" />
		</td>

		<td align="center"><a href="javascript:void(0);"
			onclick="deleteRow(<?php echo $i;?>)"><img border="0" alt=""
				src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"> </a></td>

	</tr>
	<?php
						}
					 ?>
</table>
<!-- billing activity form end here -->
<br>
	<div align="left">
		<input type="button" value="Add Row" class="blueBtn" onclick="addFields()" />
	</div>
<br>
<div class="clr"></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="tdLabel2" style="border: 1px solid #3E474A; padding: 10px;">
	<tr>
		<td width="250" align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
						value="<?php echo $StoreRequisition['StoreRequisition']['requisition_by'];?>" />
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
				<tr>
					<td height="22" colspan="2" valign="top">Entered By:</td>
				</tr>
				<tr>
					<td width="60" height="25">Name</td>
					<td><input name="StoreRequisition[entered_by_name]" type="text"
						class="textBoxExpnd entered_name" id="entered_by"
						style="width: 180px;" value="<?php echo $entered_by_name;?>" /> <input
						name="StoreRequisition[entered_by]" type="hidden" class=""
						id="entered_id"
						value="<?php echo $StoreRequisition['StoreRequisition']['entered_by'];?>" />
					</td>
				</tr>
				<tr>
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

			</table></td>
	</tr>
</table>
<div class="clr">&nbsp;</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
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
				<!-- <tr>
                            <td width="100" height="25">Approved By</td>
                            <td><input name="StoreRequisition[approved_by]" type="text" class="textBoxExpnd disabled" id="approved_by" style="width:200px;" value="<?php echo $StoreRequisition['StoreRequisition']['approved_by'];?>" disabled="disabled"/></td>
                          </tr>-->
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

<div class="btns">
	<input name="submit" type="submit" value="Submit" class="blueBtn" />

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
$( ".datetime" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate("HH:mm");?>',
			minDate: new Date(),
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
		   field += ' <tr id="row'+number_of_field+'"> ';
		   field += ' <td><input name="StoreRequisition[slip_detail][item_name][]" type="text" class="textBoxExpnd validate[required] item_name" id="item_name'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/><input name="StoreRequisition[slip_detail][item_id][]" type="hidden" class="textBoxExpnd item_id" id="item_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> </td>';
		   field += ' <td><input name="StoreRequisition[slip_detail][qty][]" type="text" class="textBoxExpnd validate[required,custom[number]] quantity" id="qty'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> </td>';
		   field += ' <td align="center" id="pack'+number_of_field+'"></td>';
		   field += ' <td align="center" id="stock'+number_of_field+'"></td>';
		   field += ' <td align="center" id="limit'+number_of_field+'"></td>';
		   field += ' <td><input name="StoreRequisition[slip_detail][remark][]" type="text" class="textBoxExpnd validate[required] remark" id="remark'+number_of_field+'" style="width:95%; min-width:200px;"/> </td>';
		   field += ' <td align="center"><a href="javascript:void(0);" onclick="deleteRow('+number_of_field+')"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>';
		   field += ' </tr>';

      	$("#no_of_fields").val(number_of_field);
		$("#tabularForm").append(field);
		$("#item_name"+number_of_field).focus();
		if (parseInt($("#no_of_fields").val()) == 1){
						$("#remove-btn").css("display","none");
					}else{
		$("#remove-btn").css("display","inline");
		}
}
function deleteRow(rowId){
var number_of_field = parseInt($("#no_of_fields").val());
if(number_of_field > 1){
		$("#row"+rowId).remove();
		$('.qty'+rowId+"formError").remove();
		$('#stock'+rowId+"formError").remove();
		$('.issued_qty'+number_of_field+"formError").remove();
		$('.remark'+rowId+"formError").remove();
		$('.item_name'+rowId+"formError").remove();
		$("#no_of_fields").val(number_of_field-1);
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
	 /* $(document).on("focus",".item_name",(function()
	{
			fieldNo= $(this).attr('fieldNo');
	$(this).autocomplete({
			source: "<?php //echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","name", "admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				$('#item_id'+fieldNo).val(ui.item.id); 
				// $('#stock'+fieldNo).html(ui.item.quantity);
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});

	}));*/
	
	$(document).on('focus','.item_name', function() {
		fieldNo= $(this).attr('fieldNo');
		var t = $(this);
		var departmentId = $('#other').val();
        $(this).autocomplete({
             source: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "product_stock","admin" => false,"plugin"=>false)); ?>"+'/'+departmentId,
                 minLength: 1,
                 select: function( event, ui ) {
                /*	 $('#item_id'+fieldNo).val(ui.item.id); 
     				 $('#stock'+fieldNo).html(ui.item.quantity);
     				$('#limit'+fieldNo).html(ui.item.max);
     				$('#pack'+fieldNo).html(ui.item.pack);
                 },
                 messages: {
                        noResults: '',
                        results: function() {},
                 }*/
             
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
   				return false;
				}
     	      if(exist == false){
         	     var value=ui.item.value;
         	     var split=value.split('(');
         	     ui.item.value=split[0];       
         	     var pack = parseInt(ui.item.pack);
         	     var quantity = parseInt(ui.item.quantity);  
         	     var msu = pack * quantity; 
         	     loading(fieldNo);  	      
     	    	 $('#item_name'+fieldNo).val(split[0]); 
  				 $('#item_id'+fieldNo).val(ui.item.id); 
  				 $('#stock'+fieldNo).html(msu);
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

	 $(document).on('keypress','.quantity, .remark',function(e) { 
		 	var fieldNo = $(this).attr('fieldno') ;
		    if (e.keyCode==40) {	//down key
		        var nextRowFieldno = parseInt(fieldNo)+1; 
		        $("#qty"+nextRowFieldno).focus();
		    } 
		    if (e.keyCode==38) {	//up key
		    	var prevRowFieldno = parseInt(fieldNo)-1;
		        $("#qty"+prevRowFieldno).focus();
		    } 
		    if(e.keyCode==13){		//enter key   
			    if($("#item_id"+fieldNo).val()!=0 && $("#item_id"+fieldNo).val()!='' && $("#item_id"+fieldNo).val()!=undefined){
		    		addFields();
			    }
		    }
		 });
 
 	$(document).on('change','.quantity', function() {	 
		 fieldNo= $(this).attr('fieldNo');
		 var stock=$('#stock'+fieldNo).html();
		 var reqQty=$('#qty'+fieldNo).val();
		 var limit=$('#limit'+fieldNo).html();
		 if(parseInt(reqQty) > parseInt(stock)){
			 alert('Requested quatity is exceeding from Stock quantity');
			 $('#qty'+fieldNo).val('');
			// $('#value'+fieldNo).val('');
		 }
		 if(parseInt(reqQty) > parseInt(limit)){
			 alert('Maximum Order Limit is '+limit+'. You can not Order More than the limit quantity');
			 $('#qty'+fieldNo).val('');
			// $('#value'+fieldNo).val('');
		 }
		  //alert(fieldNo);
	 });

	 function loading(id){
	    $('#tabularForm').block({
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
	
	function onCompleteRequest(id){
		 $('#tabularForm').unblock();
	} 
</script>
