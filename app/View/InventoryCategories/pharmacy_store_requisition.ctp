<?php  //echo $this->Html->script('jquery.autocomplete');
 // echo $this->Html->css('jquery.autocomplete.css');?>
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

if($this->params->query['type']=='OPD'){
		$urlType= 'OPD';
		$serachStr ='OPD';
		$searchStrArr = array('type'=>'OPD');
	}else if($this->params->query['type']=='emergency'){
		$urlType= 'emergency';
		$serachStr ='IPD&is_emergency=1';
		$searchStrArr = array('type'=>'IPD','is_emergency'=>1);
	}else if($this->params->query['type']=='IPD'){
		$urlType= 'IPD' ;
		$serachStr ='IPD&is_emergency=0' ;
		$searchStrArr = array('type'=>'IPD','is_emergency'=>0);
	}
	$queryStr =  $this->General->removePaginatorSortArg($this->params->query) ;
	?>

<input type="hidden"
	value="1" id="no_of_fields" />
<div class="inner_title">
<?php if($this->params->query['pharmacy']){ ?>
	<?php echo $this->element('pharmacy_menu');?>
	<h3>Pharmacy Requisition Slip</h3>
	<span> 

	<?php  echo $this->Html->link(__('Back'), array('action' => 'store_requisition_list','?'=>array('pharmacy'=>'pharmacy')), array('escape' => false,'class'=>"blueBtn"));?>
 	</span> 
 	
</div>
<p class="ht5"></p>

<!-- billing activity form start here -->
<?php echo $this->Form->create('StoreRequisition',array('?'=>array('pharmacy'=>'pharmacy')));?>

<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm">
	<tr>
		<th colspan="5">STORE REQUISITION &amp; ISSUE SLIP</th>
	</tr>
	<tr>
		<td width="10%" class="tdLabel" colspan=""><?php echo __('Requisition From :'); ?>
		</td>
		<td width="150" colspan=""><?php
		if(!empty($requisition_for)){
				echo $requisition_for;
			}else{
               echo $this->Form->input('StoreRequisition.requisition_for',
                                array('label'=> false,'div' => false, 'error' => false,
                                'options'=>$department,'value'=>$pharmaDepart,'div'=>false,'class'=>'validate[required]','disabled' => 'disabled'));
				echo $this->Form->hidden('StoreRequisition.requisition_for_name',array('id'=>'for_name','value'=>"pharmacy"));
				}
				?> <!-- <label><input type="radio" value="ward"
				name="requisition_for" class="requisition_selector"
				checked='checked'>Ward</label> <label><input type="radio" value="ot"
				name="requisition_for" class="requisition_selector"> OT</label> <label><input
				type="radio" value="chamber" name="requisition_for"
				class="requisition_selector"> Chamber</label> <label><input
				type="radio" value="other" name="requisition_for"
				class="requisition_selector"> Other</label>-->
		</td>
		
	</tr>
	<tr>
		<td width="150" class="tdLabel" colspan=""><?php echo __('Requisition To:'); ?>
		</td>
<!--		<td width="150" class="tdLabel" colspan="2"><?php
// 		echo $this->Form->input('StoreRequisition.store_location',
//                                 array('id' => 'storeLocation', 'label'=> false,'div' => false, 'error' => false,'empty'=>'Select Store Location',
//                                 'options'=>Configure::read('storeLocations'),'div'=>false,'class'=>'textBoxExpnd  validate[required]','style'=>'width : 17%;'));
//                ?>
 		</td> -->
 		<td width="150" class="tdLabel" colspan="2"><?php
		echo $this->Form->input('StoreRequisition.store_location_id',
                                array('id' => 'storeLocation', 'label'=> false,'div' => false, 'error' => false,/* 'empty'=>'Select Store Location',*/
							  'options'=>$centralStoreDepart,'div'=>false,'class'=>'textBoxExpnd  validate[required]','style'=>'width : 17%;'));
		
               ?>
		</td>
	</tr>
	
	<!--<tr>
		<td width="150" class="tdLabel" colspan=""><?php echo __('Type:'); ?>
		</td>
		<td width="150" class="tdLabel" colspan="2"><?php $type=array('catalogued'=>'Catalogued','non-catalogued'=>'Non-Catalogued');
		echo $this->Form->input('StoreRequisition.type',
                                array('id' => 'type', 'label'=> false,'div' => false, 'error' => false,
                                'options'=>$type,'div'=>false,'class'=>'textBoxExpnd','style'=>'width : 17%;'));
               ?>
		</td>
	</tr>
--></table>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" id="tabularForm">
	<tr>
		<td width="200">Item Name<font color="red">*</font>
		</td>
		<td width="130" align="center">Requisition Quantity<font color="red">*</font>
		</td>
		<td width="110" align="center">Package</td>
		<td width="110" align="center">Stock Quantity</td>
		<td width="110" align="center">Limit</td>
		<td>Remark
		</td>
		<td width="50" align="center">Remove</td>
	</tr>
	<tr id="row1">
		<td><input name="StoreRequisition[slip_detail][item_name][]"
			type="text" class="textBoxExpnd validate[required] item_name"
			id="item_name1" style="width: 180px;" fieldNo="1" /> <input
			name="StoreRequisition[slip_detail][item_id][]" type="hidden"
			class="textBoxExpnd item_id" id="item_id1" fieldNo="1" />
			<input
			name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden"
			class="textBoxExpnd Pitem_id" id="Pitem_id1" fieldNo="1" /></td>
		<td><input name="StoreRequisition[slip_detail][qty][]" type="text"
			class="textBoxExpnd validate[required,custom[number]] quantity"
			id="qty1" fieldNo="1" style="width: 180px;" /></td>
		<td align="center" id="pack1">
		
			<!-- renders pack form db -->
			
		</td>
		<td align="center" id="stock1">
			<!-- renders quantity form db -->
		</td>
		<td align="center" id="limit1">
			<!-- renders quantity form db -->
		</td>	
		<td><input name="StoreRequisition[slip_detail][remark][]" type="text"
			class="textBoxExpnd  remark" id="remark1"
			style="width: 95%; min-width: 200px;" /></td>
		<td align="center">&nbsp;</td>
	</tr>
</table>
<table>
	<!--   <tr>
						<td class=" " align="right"><label><?php echo __('MRN') ?> :</label></td>
						<td class=" ">											 
				    	<?php 
				    		 echo $this->Form->input('StoreRequisition.admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
				    	?>
		  				</td>
                   	 </tr>-->
</table>



<!-- billing activity form end here -->
<div
	class="btns">
	<input type="button" value="Add Row" class="blueBtn"
		onclick="addFields()" />
	<!--<input name="" type="button" value="Remove" class="blueBtn" tabindex="36" id="remove-btn"  style="display:none" onclick="removeRow()"/>-->

</div>
<div class="clr"></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="tdLabel2" style="border: 1px solid #3E474A; padding: 10px;">
	<tr>
		<td width="250" align="left" valign="top">
			<table width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr><td width="155px"><?php echo "Expiration of Requisition : "?></td>
				<td><?php echo $this->Form->input('StoreRequisition.req_expiry',
						array('id'=>'req_exp','class'=>'textBoxExpnd validate[required]','value'=>date('d/m/Y H:i:s',strtotime('+5 hours')),'label'=>false,'div'=>false));?>
				</td>
			</tr>
			<tr>
					<td height="22" colspan="2" valign="top">Requisition By:</td>
				</tr>
				<tr>
					<td width="60" height="25">Name</td>
					<td><?php $name= $reqFirstName.' '.$reqLastName;?> <input
						name="StoreRequisition[requisition_by_name]" type="text"
						class="textBoxExpnd requisition_name " id="requisition_by"
						style="width: 180px;" value="<?php echo $name?>" /> <input
						name="StoreRequisition[requisition_by]" type="hidden"
						class="textBoxExpnd requisition_id " id="requisition_id"
						style="width: 180px;" value="<?php echo $reqId?>" /></td>
				</tr>
				<tr>
					<td height="25">Date</td>
					<td><table width="165" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="140"><input name="StoreRequisition[requisition_date]"
									type="text" class="textBoxExpnd datetime" id="requisition_date" 
									value="<?php echo date('d/m/Y H:i:s');?>" style="width: 120px;" /></td>

							</tr>
						</table></td>
				</tr>
			</table>

		</td>
		<td width="30">&nbsp;</td>
		<td width="30">&nbsp;</td>
		<td width="250" align="left" valign="top"><table width="100%"
				border="0" cellspacing="3" cellpadding="0">
				<tr>
					<td height="22" colspan="2" valign="top">Entered By:</td>
				</tr>
				<tr>
					<td width="60" height="25">Name</td>
					<td><input name="StoreRequisition[entered_by_name]" type="text"
						class="textBoxExpnd entered_name" id="entered_by"
						style="width: 180px;" value="<?php echo $name;?>" /> <input
						name="StoreRequisition[entered_by]" type="hidden"
						class="textBoxExpnd " id="entered_id" style="width: 180px;"
						value="<?php echo $reqId;?>" /></td>
				</tr>
				<tr>
					<td height="25">Date</td>
					<td><table width="165" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="140"><input name="StoreRequisition[entered_date]"
									type="text" class="textBoxExpnd datetime" id="entered_date"
									value="<?php echo date('d/m/Y H:i:s');?>" style="width: 120px;" /></td>
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
		<td width="51%" valign="top"><table width="100%" border="0"
				cellspacing="3" cellpadding="0">

				<tr>
					<td width="170" height="25">Reviewed</td>
					<td><input name="StoreRequisition[reviewed_by]" type="text"
						class="textBoxExpnd" id="reviewed_by" style="width: 200px;"
						value="<?php echo $name?>" /></td>
				</tr>
				<tr>
					<td height="25" style="min-width: 170px;">Management Representative</td>
					<td><input name="StoreRequisition[management_representative]"
						type="text" class="textBoxExpnd" id="management_representative"
						style="width: 200px;" /></td>
				</tr>

			</table></td>
		<td width="30">&nbsp;</td>
		<td width="300" valign="top"><table width="100%" border="0"
				cellspacing="3" cellpadding="0">
<!-- 				<tr> -->
<!-- 					<td width="100" height="25">Approved By</td> -->
<!-- 					<td><input name="StoreRequisition[approved_by]" type="text" -->
<!-- 						class="textBoxExpnd disabled" id="approved_by" 
						style="width: 200px;" disabled="disabled" /></td>-->
<!-- 				</tr> -->
				<tr>
					<td height="25">Authority</td>
					<td><input name="StoreRequisition[proprietor]" type="text"
						class="textBoxExpnd " id="proprietor" style="width: 200px;" /></td>
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
<?php }?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#StoreRequisitionStoreRequisitionForm").validationEngine();
	});
$( ".datetime, #req_exp" ).datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
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
		   field += ' <td><input name="StoreRequisition[slip_detail][item_name][]" type="text" class="textBoxExpnd validate[required] item_name" id="item_name'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/><input name="StoreRequisition[slip_detail][item_id][]" type="hidden" class="textBoxExpnd item_id" id="item_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/><input name="StoreRequisition[slip_detail][item_id][]" type="hidden" class="textBoxExpnd item_id" id="item_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> <input name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden" class="textBoxExpnd Pitem_id" id="Pitem_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> </td>';
	       field += ' <td><input name="StoreRequisition[slip_detail][qty][]" type="text" class="textBoxExpnd validate[required,custom[number]] quantity" id="qty'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> </td>';
	       field += '<td align="center" id="pack'+number_of_field+'"></td>';
		   field += '<td align="center" id="stock'+number_of_field+'"></td>';
		   field += '<td align="center" id="limit'+number_of_field+'"></td>';
		   field += ' <td><input name="StoreRequisition[slip_detail][remark][]" type="text" class="textBoxExpnd  remark" id="remark'+number_of_field+'" style="width:95%; min-width:200px;"/> </td>';
		   field += ' <td align="center"><a href="#this" onclick="deleteRow('+number_of_field+')"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>';
		   field +='  </tr>    ';

      	$("#no_of_fields").val(number_of_field);
		$("#tabularForm").append(field);
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
        $(".requisition_option").css("display","none").val('');
        var position = $(this).position();
        
        switch($(this).val())
            {
                case 'ward':
                 $("#ward").css("display","block");

                break;
                case 'ot':
                 $("#ot").css("display","block");

                break;
                case 'chamber':

                    $("#chamber").css("display","block");

                break;
                case 'other':
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
		
		var flag=false;
		fieldNo= $(this).attr('fieldNo');
		var t = $(this);
		var departmentId = $('#other').val();
		var storeLocation = $("#storeLocation").val();
        $(this).autocomplete({
             source: "<?php  echo $this->Html->url(array("controller" => "Store", "action" => "product_stock","admin" => false,"plugin"=>false)); ?>"+'/'+storeLocation,
                 minLength: 1,
                 select: function( event, ui ) {
                	 selectedId = t.attr('id');
				   //Code to avoid duplicate entry of product in list
                  	 var currentField = $("#"+selectedId);
                	 var itemID = ui.item.pId; //purchase order detail id
                	 var fields = $('input[name="StoreRequisition[slip_detail][Pitem_id][]"]').serializeArray();
         	         jQuery.each(fields, function(i, field){
         	        	if(parseInt(field.value) == parseInt(itemID)){	        		
         					flag = true;
         				}
         	    	});

         	       if(flag){
       				alert("This Item already in list please select another.");
       				$("#submitButton").attr('disabled','disabled');
       				currentField.val("");
       				$("#item_name"+fieldNo).val("");
       				$('#item_id'+fieldNo).val("");
       				$('#stock'+fieldNo).val("");
       			 	$("#pack"+fieldNo).val("");
       			    $('#limit'+fieldNo).val("");
       			    $('#Pitem_id'+fieldNo).val("");
       				return false;
       			}
         	      if(flag==false){
             	     var value=ui.item.value;
             	     var split=value.split('(');
             	     ui.item.value=split[0];            	      
         	    	 $('#item_name'+fieldNo).val(split[0]); 
      				 $('#item_id'+fieldNo).val(ui.item.id); 
      				 $('#stock'+fieldNo).html(ui.item.quantity);
      				 $('#pack'+fieldNo).html(ui.item.pack);
      				 $('#limit'+fieldNo).html(ui.item.max);
      				 $('#Pitem_id'+fieldNo).val(ui.item.pId);
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
			source: "<?php echo $this->Html->url(array("controller" => "Users", "action" => "user_autocomplete", "admin" => false,"plugin"=>false)); ?>",
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
 
 $('.quantity').change(function(){
	 
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

//alert for requisition expiry--Pooja
 $(".submit").click(function(){
	 if($('#req_exp').val()!='')
	  var expiry=confirm('Your Requistion will expiry on '+$('#req_exp').val());
	 if(expiry){
		 return true;
	 }else{
		 $('#req_exp').val('');
		 $('#req_exp').focus();
		 return false;
	 }
 });
 
</script>
