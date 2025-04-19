 
<?php  
	echo $this->Html->script(array('jquery.blockUI'));
	$referral = $this->request->referer();
	echo $this->Form->hidden('formReferral',array('value'=>'','id'=>'formReferral'));
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
	
	
<?php if(!empty($itemData)) { 
	echo $this->Form->hidden('',array('id'=>'no_of_fields','value'=>count($itemData)));
} else { ?>
<input type="hidden" value="1" id="no_of_fields" />
<?php } ?>



<div class="inner_title">
	<?php 
		if($identifyRole == "PHAR"){
			echo $this->element('pharmacy_menu');
		}
	?>
	<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
	<h3>Store Requisition Slip</h3>
	<span> <?php  echo $this->Html->link(__('Back'), array('action' => 'store_requisition_list'), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>
<p class="ht5"></p>

<!-- billing activity form start here -->
<?php echo $this->Form->create('StoreRequisition',array('onkeypress'=>"return event.keyCode != 13;",'id'=>'storeRequisition'));?>

<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0"  class="tabularForm">
	<tr>
	
		<th colspan="5">STORE REQUISITION SLIP</th>
	</tr>
	<tr>
		<td width="10%" class="tdLabel" colspan=""><?php echo __('Requisition From:'); ?><font color="red">*</font> </td>
		<td width="150" colspan=""><?php 
		if(!empty($requisition_for)){ 
				echo $requisition_for;
			}else{  
                echo $this->Form->input('StoreRequisition.requisition_for',
                                array('label'=> false,'div' => false, 'error' => false,'empty'=>'Select Other Location',
                                'options'=>$department,'value'=>$from,'div'=>false,'class'=>'requisition_selector validate[required]')); 
				echo $this->Form->hidden('StoreRequisition.requisition_for_name',array('id'=>'for_name','value'=>$department[$from]));
				}
			?> 
		</td>
		<td width="180" class="tdLabel"><?php
		echo $this->Form->input('StoreRequisition.ward',
                                array('id' => 'ward', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select ward',
                                'options'=>$wards,'div'=>false,'class'=>'requisition_option validate[required]'));
               ?> <?php
               echo $this->Form->input('StoreRequisition.ot',
                                array('id' => 'ot', 'label'=> false,'div' => false, 'error' => false,'empty'=>'Select OT',
                                'options'=>$ot,'div'=>false,'class'=>'requisition_option  validate[required]'));
               ?> <?php
               echo $this->Form->input('StoreRequisition.chamber',
                                array( 'id' =>'chamber', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select chamber',
                                'options'=>$chambers,'div'=>false,'class'=>'requisition_option  validate[required]'));
               ?> <?php
               echo $this->Form->input('StoreRequisition.other',
                                array('id' => 'other', 'label'=> false,'div' => false, 'error' => false,'empty'=>'Select Other Location',
                                'options'=>$department,'div'=>false,'class'=>'requisition_option  validate[required]'));
               ?>
		</td>
	</tr>
	<tr>
		<td width="150" class="tdLabel" colspan=""><?php echo __('Department:'); ?>
		</td>
		<td width="150" class="tdLabel" colspan="2"><?php 
		echo $this->Form->input('StoreRequisition.store_location_id',
                                array('id' => 'storeLocation', 'label'=> false,'div' => false, 'error' => false,/*'empty'=>'Select Store Location',*/
                                'options'=>$centralStoreDepart,'div'=>false,'class'=>'textBoxExpnd  validate[required]','style'=>'width : 17%;',
									'value'=>$centralId));
               ?>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" id="tabularForm">
	<tr>
		<td width="200">Product Name<font color="red">*</font>
		</td>
		<td width="130" align="center">Requisition Quantity<font color="red">*</font> </td>
		<td width="110" align="center">Package</td>
		<td width="110" align="center">Sale Price</td>
		<td width="150" align="center">Stock Quantity (MSU)</td>
		<td width="110" align="center">Limit</td>
		<td>Remark<!--<font color="red">*</font>--></td>
		<td width="50" align="center">Remove</td>
	</tr>
	
	<?php $count = 0; if(!empty($itemData)) { foreach($itemData as $key=> $item) { $count++; ?>
	<tr id="row<?php echo $count;?>">
		<td>
			<?php echo $this->Form->input('',array('name'=>"data[StoreRequisition][slip_detail][item_name][]",'onkeyup'=>"checkIsRemoved(this)",
					'id'=>'item_name'.$count,'class'=>'textBoxExpnd validate[required] item_name','type'=>'text','fieldNo'=>$count,
					'value'=>$item['Product']['name'],'div'=>false,'label'=>false,'style'=>"width: 180px;"))?> 
					
			<?php echo $this->Form->hidden('',array('name'=>"data[StoreRequisition][slip_detail][item_id][]",'id'=>'item_id'.$count,
					'class'=>'item_id', 'fieldNo'=>$count,'value'=>$item['Product']['id']));
				 
				  echo $this->Form->hidden('',array('name'=>"data[StoreRequisition][slip_detail][Pitem_id][]",'id'=>'Pitem_id'.$count,
					'class'=>'Pitem_id', 'fieldNo'=>$count,'value'=>$item['Product']['id']))?>
		</td>
		<td>
			<?php if($item['Product']['expensive_product'] == 1) { 
				$qty = $item['Product']['quantity'];
               }else{
     			$qty = '';
               }
               if(isset($from) && $from == $otPharId) {
					$qty = $item['Product']['req_quantity'];
				}
               ?>
			<?php echo $this->Form->input('',array('name'=>"data[StoreRequisition][slip_detail][qty][]",'id'=>'qty'.$count,'autocomplete'=>"off",
					'class'=>'textBoxExpnd numberOnly validate[required,custom[number]] quantity','type'=>'text','fieldNo'=>$count,
					'value'=>$qty,'div'=>false,'label'=>false,'style'=>"width: 180px;"));?>
					 
		</td>
		<td align="center" id="pack<?php echo $count;?>">
			<?php echo $item['Product']['pack'];?>
		</td>
		<td align="center" id="salePrice<?php echo $count;?>">
			<?php echo $item['ProductRate']['sale_price'];?>
		</td>
		<td align="center" id="stock<?php echo $count;?>">
			<?php echo $msuStock = ($item['Product']['quantity'] * (int)$item['Product']['pack'] ) + $item['Product']['loose_stock'];?>
		</td>
		<td align="center" id="limit<?php echo $count;?>">
			<?php if($item['Product']['expensive_product'] == 1) {
				$limit = $msuStock;
			}else{
				
				$limit = $msuStock - (($msuStock * 0.1) + $item['Product']['reorder_level']);
			} 
			 echo $limit;?>
		</td>		
		<td>
		<?php echo $this->Form->input('',array('name'=>"data[StoreRequisition][slip_detail][remark][]",'id'=>'remark'.$count,'class'=>'textBoxExpnd remark',
				'type'=>'text','autocomplete'=>"off",'fieldNo'=>$count,'div'=>false,'label'=>false,'style'=>"width:95%; min-width: 200px;"))?>
		</td>
		<td align="center"><a href="javascript:void(0);" onclick="deleteRow(<?php echo $count; ?>)"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>
	</tr>
	<?php } //end of foreach?>
	<?php } else { ?>
	
	<tr id="row1">
		<td><input name="StoreRequisition[slip_detail][item_name][]"
			type="text" class="textBoxExpnd validate[required] item_name"
			id="item_name1" style="width: 180px;" fieldNo="1" onkeyup="checkIsRemoved(this)"/> <input
			name="StoreRequisition[slip_detail][item_id][]" type="hidden"
			class="textBoxExpnd item_id" id="item_id1" fieldNo="1" />
			<input
			name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden"
			class="textBoxExpnd Pitem_id" id="Pitem_id1" fieldNo="1" /></td>
		<td><input name="StoreRequisition[slip_detail][qty][]" type="text"
			class="textBoxExpnd numberOnly validate[required,custom[number]] quantity" autocomplete="off"
			id="qty1" fieldNo="1" style="width: 180px;" /></td>
		<td align="center" id="pack1">
			<!-- renders pack form db -->
		</td>
		<td align="center" id="salePrice1">
			<!-- renders sale Price form db -->
		</td>
		<td align="center" id="stock1">
			<!-- renders quantity form db -->
		</td>
		<td align="center" id="limit1">
			<!-- renders quantity form db -->
		</td>		
		<td><input name="StoreRequisition[slip_detail][remark][]" type="text"
			class="textBoxExpnd remark" id="remark1" fieldNo="1" autocomplete="off"
			style="width: 95%; min-width: 200px;" /></td>
		<td align="center"><a href="javascript:void(0);" onclick="deleteRow('1')">
			<img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a>
		</td>
	</tr>
	<?php } ?>
</table>
<table>
	<!--<tr>
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
				<!--  <tr>
					<td width="100" height="25">Approved By</td>
					<td><input name="StoreRequisition[approved_by]" type="text"
						class="textBoxExpnd disabled" id="approved_by"
						style="width: 200px;" disabled="disabled" /></td>
				</tr>-->
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
	var print="<?php echo isset($this->params->query['storeId'])?$this->params->query['storeId']:'' ?>";
     var referral = "<?php echo $referral ; ?>" ;
     if(print && referral != '/' && $("#formReferral").val()==''){
    	$("#formReferral").val('yes') ;
		 var url="<?php echo $this->Html->url(array('controller'=>'InventoryCategories','action'=>'printRequisitionBeforeIssue',$this->params->query['storeId'])); ?>";
		    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200");
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
			//minDate:-1,
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
	   field += 	'<td><input name="StoreRequisition[slip_detail][item_name][]" onkeyup="checkIsRemoved(this)" type="text" class="textBoxExpnd validate[required] item_name" id="item_name'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/><input name="StoreRequisition[slip_detail][item_id][]" type="hidden" class="textBoxExpnd item_id" id="item_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> <input name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden" class="textBoxExpnd Pitem_id" id="Pitem_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> </td>';
	   field += 	'<td><input name="StoreRequisition[slip_detail][qty][]" type="text" autocomplete="off" class="textBoxExpnd numberOnly validate[required,custom[number]] quantity" id="qty'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> </td>';
	   field += 	'<td align="center" id="pack'+number_of_field+'"></td>';
	   field += 	'<td align="center" id="salePrice'+number_of_field+'"></td>';
	   field += 	'<td align="center" id="stock'+number_of_field+'"></td>';
	   field += 	'<td align="center" id="limit'+number_of_field+'"></td>';
	   field += 	'<td><input name="StoreRequisition[slip_detail][remark][]" type="text" autocomplete="off" class="textBoxExpnd remark" fieldNo="'+number_of_field+'" id="remark'+number_of_field+'" style="width:95%; min-width:200px;"/> </td>';
	   field += 	'<td align="center"><a href="javascript:void(0);" onclick="deleteRow('+number_of_field+')"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>';
	   field += '</tr>    ';

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
        var txt=$('.requisition_selector option:selected').text().toLowerCase(); 
        $('#for_name').val(txt);
        switch($('.requisition_selector option:selected').text().toLowerCase())
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
		var storeLocId = $('#storeLocation').val();	//send storeLocation id to fetch the product
        $(this).autocomplete({
             source: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "product_stock","admin" => false,"plugin"=>false)); ?>"+'/'+storeLocId,
                 minLength: 1,
                 select: function( event, ui ) {
                	 selectedId = t.attr('id'); 
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
	       			 	$("#salePrice"+fieldNo).val("");
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
	             	     var loose_stock = parseInt(ui.item.loose_stock); 
	             	     var msu = (pack * quantity) + loose_stock; 
	             	     
						 var max = parseInt(ui.item.max);	//max is nothing but reorder level value
	             	     var limit = Math.floor((msu * 0.1) + max);
 
	             	     loading(fieldNo);  	      
	         	    	 $('#item_name'+fieldNo).val(split[0]); 
	      				 $('#item_id'+fieldNo).val(ui.item.id); 
	      				 $('#stock'+fieldNo).html(msu);
	      				 $('#pack'+fieldNo).html(ui.item.pack);
	      				 $('#salePrice'+fieldNo).html(parseFloat(ui.item.rate).toFixed(2));
	      				 $('#limit'+fieldNo).html(msu/*-limit*/);
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
	//$("#requisition_by").val('');
	//$("#requisition_id").val('');
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
		//$("#issue_by").val('');
		//$("#issue_id").val('');
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
		//$("#entered_by").val('');
		//$("#entered_id").val('');
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

 $(document).on('keyup','.quantity',function(){
	 fieldNo= $(this).attr('fieldNo');
	 var stock=$('#stock'+fieldNo).html(); 
	 var reqQty=$('#qty'+fieldNo).val(); 
	 var limit=$('#limit'+fieldNo).html();
	 if(parseInt(reqQty) > parseInt(stock)){
		// alert('Requested quantity is exceeding from Stock quantity');
		 //$('#qty'+fieldNo).val(''); 
	 }
	 if(parseInt(reqQty) > parseInt(limit)){
		 alert('Maximum Order Limit is '+limit+'. You can not Order More than the limit quantity');
		 $('#qty'+fieldNo).val(''); 
	 } 
 });

 //alert for requisition expiry--Pooja
 $(".submit").click(function(){
	 if($('#req_exp').val()!='')
		var valid=jQuery("#storeRequisition").validationEngine('validate');
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
		$("#item_name"+fieldNo).val("");
		$('#item_id'+fieldNo).val("");
		$('#stock'+fieldNo).empty();
	 	$("#pack"+fieldNo).empty();
	 	$("#salePrice"+fieldNo).empty();
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
	

	$(document).on('input','.numberOnly',function(){
		if (/[^0-9]/g.test(this.value))
	    {
	    	this.value = this.value.replace(/[^0-9]/g,'');
	    } 
		if (this.value.length > 7) this.value = this.value.slice(0,7);
	});
 </script>