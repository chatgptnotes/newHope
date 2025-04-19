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

<input type="hidden" value="1"
	id="no_of_fields" />
<div class="inner_title">	
	<h3>Stock Transfer</h3>
	<span> <?php  echo $this->Html->link(__('Back'), array('action' => 'stock_requisition_list'), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>
<p class="ht5"></p>

<!-- billing activity form start here -->
<?php echo $this->Form->create('StoreRequisition',array('onkeypress'=>"return event.keyCode != 13;",'id'=>'StoreRequisition'));?>

<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" 
	class="tabularForm">
	<tr>
		<th colspan="5">STOCK TRANSFER</th>
	</tr>
	<tr>
		<td width="10%" class="tdLabel" colspan=""><?php echo __('Requisition From:'); ?>
		</td>
		<td width="150" colspan=""><?php
		                echo $this->Form->input('StoreRequisition.location_from_id',
                                array('label'=> false, 'error' => false,'empty'=>'Select Other Location',
                                'options'=>$accessableLocation,'div'=>false,'class'=>'requisition_selector validate[required]','id'=>'location_from','selected'=>$this->Session->read('locationid'))); 
				echo $this->Form->hidden('StoreRequisition.stock_requisition_flag',array('id'=>'stock_requisition_flag','value'=>true));
			
				?> 
		</td>
		<td width="10%" class="tdLabel" colspan=""><?php echo __('Requisition To:'); ?>
		</td>
		<td width="180" class="tdLabel"><?php
 			echo $this->Form->input('StoreRequisition.requisition_for',
                                array('label'=> false, 'error' => false,'empty'=>'Select Other Location',
                                'options'=>$accessableLocation,'div'=>false,'class'=>'requisition_selector validate[required]','id'=>'location_to','default'=>'25'));
			//echo $this->Form->hidden('StoreRequisition.location_to_id',array('id'=>'location_to_id')); 
		              ?>
		</td>
	</tr>
	
	</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" id="tabularForm">
	<tr>
		<td width="200">Item Name<font color="red">*</font>
		</td>
		<!-- <td width="130" align="center">Batch
		</td> -->
		<td width="130" align="center">Requisition Quantity<font color="red">*</font>
		</td>
		<td width="65" align="center">Pack</td>
		<td width="166" align="center">Stock Quantity (MSU) From <span id="stockFrm" style="color: #FF0000;"></span></td>
		<td width="150" align="center">Stock Quantity (MSU) To <span id="stockTo" style="color: #FF0000;"></span></td>
		<!-- <td width="110" align="center">Limit</td> -->
		<td>Remark<!--<font color="red">*</font>--></td>
		<td width="50" align="center">Remove</td>		
	</tr>
	<tr id="row1">
		<td><input name="StoreRequisition[slip_detail][item_name][]"
			type="text" class="textBoxExpnd validate[required] item_name"
			id="itemName_1" style="width: 180px;" fieldNo="1" onkeyup="checkIsRemoved(this)"/> <input
			name="StoreRequisition[slip_detail][item_id][]" type="hidden"
			class="textBoxExpnd item_id itemId" id="item_id1" fieldNo="1" />
			<input	name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden"
			class="textBoxExpnd Pitem_id" id="Pitem_id1" fieldNo="1" />
			<input	name="StoreRequisition[slip_detail][existing_stock_order_item_id][]" type="hidden"
			class="textBoxExpnd Pitem_id" id="pitemIdfrm1" fieldNo="1" />
		</td>
	<!-- 	<td>
		<?php  //echo $this->Form->input('',array('type'=>'select','options'=>'','class'=>'textBoxExpnd validate[required] batch_number','id'=>'batch_number1','autocomplete'=>"off" ,"tabindex"=>"9","fieldNo"=>"1",'label'=>false,'name'=>"StoreRequisition[slip_detail][batch][]",'style'=>'width:100%;')); ?>
		 		
		</td> -->
		<td><input name="StoreRequisition[slip_detail][qty][]" type="text"
			class="textBoxExpnd validate[required,custom[number]] quantity" autocomplete="off"
			id="qty1" fieldNo="1" style="width: 180px;" /></td>
		<td align="center" id="pack1">
			<!--  renders pack form db  -->
		</td>
		<td align="center" id="stockfrm1">
			<!-- renders quantity frm form db -->
		</td>
		<td align="center" id="stock1">
			<!-- renders quantity form db -->
		</td>
		<!--<td align="center" id="limit1">
			 renders quantity form db
		</td>		 -->
		<td><input name="StoreRequisition[slip_detail][remark][]" type="text"
			class="textBoxExpnd remark" id="remark1" fieldNo="1" autocomplete="off"
			style="width: 95%; min-width: 200px;" /></td>
		<td align="center"><a href="javascript:void(0);" onclick="deleteRow('1')"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>
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
			<table width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr><td width="155px"><?php echo "Expiration of Requisition : "?></td>
			<td><?php echo $this->Form->input('StoreRequisition.req_expiry',array('id'=>'req_exp','class'=>'textBoxExpnd validate[required]','value'=>date('d/m/Y H:i:s',strtotime('+1 weeks')),'label'=>false,'div'=>false));?></td>
			</tr>
				<tr>
					<td height="22" colspan="2" valign="top">Requisition By:</td>
				</tr>
				<tr>
					<td width="60" height="25">Name</td>
					<td><?php $name= $reqFirstName.' '.$reqLastName;?> <input
						name="StoreRequisition[requisition_by_name]" type="text"
						class="textBoxExpnd requisition_name " id="requisition_by"
						style="width: 180px;" value="<?php echo $name;?>" /> <input
						name="StoreRequisition[requisition_by]" type="hidden"
						class="textBoxExpnd requisition_id " id="requisition_id"
						style="width: 180px;" /></td><!-- value="<?php echo $reqId?>" -->
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
			<!-- 	<tr>
					<td height="22" colspan="2" valign="top">Entered By:</td>
				</tr> -->
				<tr>
							<!-- <td width="60" height="25">Name</td>
					<td><!--<input name="StoreRequisition[entered_by_name]" type="text"
						class="textBoxExpnd entered_name" id="entered_by"
						style="width: 180px;" value="<?php echo $this->Session->read('location_name');?>" />  --><input
						name="StoreRequisition[entered_by]" type="hidden"
						class="textBoxExpnd " id="entered_id" style="width: 180px;"
						value="<?php echo $reqId;?>" /></td>
				</tr>
				<tr>
					<!-- <td height="25">Date</td>
					<td><table width="165" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="140"><input name="StoreRequisition[entered_date]"
									type="text" class="textBoxExpnd datetime" id="entered_date"
									value="<?php echo date('d/m/Y H:i:s');?>" style="width: 120px;" /></td>
							</tr>
						</table></td> -->
				</tr>

			</table></td>
	</tr>
	
</table>


<div class="btns">
	<input  name="submit" type="submit" id="submit" value="Submit" class="blueBtn submit" />

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
	<!--<td class="footStrp">&nbsp;</td>-->
	<td>&nbsp;</td>
</tr>
</table>
<?php echo $this->Form->end();?>
<script>
	jQuery(document).ready(function(){
		if($('#location_from').val()!=''){
			var locFrmvalue=$('#location_from option:selected').val();
			var locFrmTxt=$('#location_from option:selected').text();
	        $('#stockFrm').html(locFrmTxt);
		}
		if($('#location_to').val()!=''){
			var locTovalue=$('#location_to option:selected').val();
			var locToTxt=$('#location_to option:selected').text();
	        $('#stockTo').html(locToTxt);
		}
	// binds form submission and fields to the validation engine
	jQuery("#StoreRequisitionStoreRequisitionForm").validationEngine();
	});
$( ".datetime, #req_exp" ).datepicker({
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
	   field += 	'<td><input name="StoreRequisition[slip_detail][item_name][]" onkeyup="checkIsRemoved(this)" type="text" class="textBoxExpnd validate[required] item_name" id="itemName_'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/><input name="StoreRequisition[slip_detail][item_id][]" type="hidden" class="textBoxExpnd item_id" id="item_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> <input name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden" class="textBoxExpnd Pitem_id" id="Pitem_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> <input name="StoreRequisition[slip_detail][existing_stock_order_item_id][]" type="hidden" class="textBoxExpnd pitemIdfrm" id="pitemIdfrm'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/></td>';
	  // field += '<td><select name="StoreRequisition[slip_detail][batch_number][]" id="batch_number'+number_of_field+'" class="textBoxExpnd validate[required] batch_number" value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"></select></td>';
	      
	   field += 	'<td><input name="StoreRequisition[slip_detail][qty][]" type="text" autocomplete="off" class="textBoxExpnd validate[required,custom[number]] quantity" id="qty'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> </td>';
	  field += 	'<td align="center" id="pack'+number_of_field+'"></td>';
	   field += 	'<td align="center" id="stockfrm'+number_of_field+'"></td>';	 
	   field += 	'<td align="center" id="stock'+number_of_field+'"></td>';
	   /*field += 	'<td align="center" id="limit'+number_of_field+'"></td>';*/
	   field += 	'<td><input name="StoreRequisition[slip_detail][remark][]" type="text" autocomplete="off" class="textBoxExpnd remark" fieldNo="'+number_of_field+'" id="remark'+number_of_field+'" style="width:95%; min-width:200px;"/> </td>';
	   field += 	'<td align="center"><a href="javascript:void(0);" onclick="deleteRow('+number_of_field+')"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>';
	   field += '</tr>    ';

      	$("#no_of_fields").val(number_of_field);
		$("#tabularForm").append(field);
		$("#itemName"+number_of_field).focus();
		if (parseInt($("#no_of_fields").val()) == 1){
			$("#remove-btn").css("display","none");
		}else{
			$("#remove-btn").css("display","inline");
		}
}
function deleteRow(rowId){
	var count = 0;
	$(".item_name").each(function(){
		count++;
	});
	if(count == 1){
		alert("Single row can't delete.");
		return false;
	} 
	if(count > 1){
		$("#row"+rowId).remove(); 
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
 $(".requisition_selector").change(function(){
        $(".requisition_option").css("display","none").val('');
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
		var flag=false;
		fieldNo= $(this).attr('fieldNo');
		//alert(fieldNo);
		var t = $(this);
		var LocIdFrm = $('#location_from').val();
		var LocIdTo = $('#location_to').val();	//send storeLocation id to fetch the product
        $(this).autocomplete({
             source: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "pharmacy_stock","admin" => false,"plugin"=>false)); ?>"+'/'+LocIdFrm+'/'+LocIdTo,
                 minLength: 1,
                 select: function( event, ui ) {
                	 selectedId = t.attr('id');
                	// var selectedId = ($(this).attr('id'));
                	 
     				//loadDataFromRate(ui.item.id,selectedId);
     			
				   //Code to avoid duplicate entry of product in list
                  	 var currentField = $("#"+selectedId);
                	 var itemID = ui.item.pId; //purchase order detail id
                	 var itemid = ui.item.id;
					 var exist = false;
					//console.log(exist);
                	 $(".item_id").each(function(){                		
             			if(this.value == itemid){             				
                 			exist = true; 
                 			return false;
             			} 
             		 });
					/*if(exist == true){
	       				alert("This Item already in list please select another.");
	       				$("#submitButton").attr('disabled','disabled');
	       				currentField.val("");
	       				$("#itemName"+fieldNo).val("");
	       				$("#itemName"+fieldNo).focus();
	       				$('#item_id'+fieldNo).val("");
	       				$('#stock'+fieldNo).val("");
	       			 	$("#pack"+fieldNo).val("");
	       			    $('#limit'+fieldNo).val("");
	       			    $('#Pitem_id'+fieldNo).val("");
	       			 $('#stockfrm'+fieldNo).html(ui.item.quantityFrm);
      				$('#pitemIdfrm'+fieldNo).val(ui.item.pItemIdFrm);
	       			return false;
       				}*/
					
	         	      if(exist == false){
						  if(ui.item.quantityFrm=='FlagNotExist'){								
								alert("This Item is not exist in "+ui.item.locationfrmName+" Location.");
								return false;
						   } 
	             	     var value=ui.item.value;	             	
	             	     var split=value.split('(');
	             	     ui.item.value=split[0];    
	             	  
	             	     var pack = parseInt(ui.item.pack);
	             	     var quantity = parseInt(ui.item.quantity);
	             	
	             	    // var msu = pack * quantity; 
	             	
	             	     loading(fieldNo);  	      
	         	    	 $('#itemName'+fieldNo).val(split[0]); 
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
    
	/* load the data from supplier master */
	function loadDataFromRate(itemID,selectedId){
		//var currentField = $("#"+selectedId);
		var currentField = selectedId.split("_");
		//var fieldno = currentField.attr('fieldNo') ;
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
		$.ajax({
			  type: "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item",'item_id','true',"inventory" => true,"plugin"=>false)); ?>",
			  data: "item_id="+itemID/*+"&tariff="+tariff+"&roomType="+room*/,
			}).done(function( msg ) {
			 	var item = jQuery.parseJSON(msg);
			 	console.log(item);
			 	
				var pack = parseInt(item.PharmacyItem.pack);
			 	$("#itemName-"+fieldno).val(item.PharmacyItem.name);
				$("#item_id"+fieldno).val(item.PharmacyItem.id);
				//$("#itemWiseDiscount"+fieldno).val(item.PharmacyItem.discount);
	 
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
					var batchNo = new Array();
				
				$('.itemId').each(function(){
					var curField = $(this).attr('fieldNo');
					var itemId = $(this).val();
					if($("#batch_number"+curField).val() != '' && itemID == itemId && curField != fieldno ){ //second cond added to prevent time med selection  row cond
						batchNo.push($("#batch_number"+curField).val());
					} 
				});	
					//console.log(batchNo);
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
				
				var itemrateid=$("#batch_number"+fieldno).val();
				var editUrl  = "<?php echo $this->Html->url(array('controller'=>'pharmacy','action'=>'edit_item_rate','inventory'=>false))?>";
				$("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
				$("#qty_"+fieldno).attr('readonly',false);
				$("#qty_"+fieldno).focus();
				onCompleteRequest(fieldno);
		});
			selectedId='';
	}
	
	 $("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
	});
 /*$(".requisition_name").focus(function(){
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
*/
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

 /*$(".entered_name").focus(function(){
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
	 });*/

 $(document).on('keyup','.quantity',function(){
	 fieldNo= $(this).attr('fieldNo');
	 var stock=$('#stock'+fieldNo).html(); 	
	 var reqQty=$('#qty'+fieldNo).val(); 	
	 var limit=$('#limit'+fieldNo).html();
	
	/* if(parseInt(reqQty) > parseInt(stock)){
		 alert('Requested quantity is exceeding from Stock quantity');
		 $('#qty'+fieldNo).val(''); 
	 }
	 if(parseInt(reqQty) > parseInt(limit)){
		 alert('Maximum Order Limit is '+limit+'. You can not Order More than the limit quantity');
		 $('#qty'+fieldNo).val(''); 
	 } */
 });

 //alert for requisition expiry--Pooja
 $(".submit").click(function(){
	 if($('#req_exp').val()!='')
		var valid=jQuery("#StoreRequisition").validationEngine('validate');
		if(valid){
			/*var expiry=confirm('Your Requistion will expiry on '+$('#req_exp').val());
			 if(expiry){
				 return true;
			 }else{
				 $('#req_exp').val('');
				 $('#req_exp').focus();
				 return false;
			 }*/
			 $("#submit").hide();
			 $('#busy-indicator').show();
		}else{
			return false;
		}
 });

 function checkIsRemoved(id){
	 var thisVal = id.value;
	 var fieldNo = $(id).attr('fieldno');
	 if(thisVal == ''){   
		$("#itemName"+fieldNo).val("");
		$('#item_id'+fieldNo).val("");
		$('#stock'+fieldNo).empty();
	 	$("#pack"+fieldNo).empty();
	    $('#limit'+fieldNo).empty();
	    $('#Pitem_id'+fieldNo).val("");
		return false;
	 }
 }

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
	/*********BOF-Mahalaxmi For get requisition_by ***************/
	$("#location_from").change(function(){       
        var locFrmvalue=$('#location_from option:selected').val();
        var locFrmTxt=$('#location_from option:selected').text();
        $('#entered_by').val(locFrmTxt);
        $('#stockFrm').html(locFrmTxt);
        
    });
	$("#location_to").change(function(){       
         var locToTxt=$('#location_to option:selected').text()
        $('#stockTo').html(locToTxt);
        
    });
	
	/*********EOF-Mahalaxmi For get requisition_by ***************/
	
 </script>