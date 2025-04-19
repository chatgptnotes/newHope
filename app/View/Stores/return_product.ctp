<div class="inner_title">
	<h3>Return Requistions Form</h3>
	<?php if($this->params->query['pharmacy']){?>
		<span><?php echo $this->Html->link(__('Back'), array('controller'=>'InventoryCategories','action' => 'store_requisition_list','?'=>array('pharmacy'=>'pharmacy')), array('escape' => false,'class'=>'blueBtn'));?></span>
	<?php }else{?>
	<span><?php echo $this->Html->link(__('Back'), array('controller'=>'InventoryCategories','action' => 'store_requisition_list'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
	<?php }?>
</div>
<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InventoryPurchaseDetailReturnProductForm").validationEngine();
}); 
</script>
<style>
.formErrorContent {
	width: 43px !important;
}

.tdLabel2 {
	width: 125px;
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
<?php // echo $this->Html->script('jquery.autocomplete_pharmacy');
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
<?php echo $this->Form->create('InventoryPurchaseDetail');?>
<table width="20%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>Requisition For<font color="red">*</font>
		</td>
		<td><input name="party_name" type="text"
			class="textBoxExpnd validate[required]" id="party_name" readonly="true"
			value="<?php echo $requisition_for ;?>" /></td>
		</td>

	</tr>
</table>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="item-row">
	<tr>
		<th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th>
		<th width="40" align="center" valign="top" style="text-align: center;">Item
			Code 
		</th>
		<th width="100" align="center" valign="top"
			style="text-align: center;">Item Name<font color="red">*</font>
		</th>
		<th width="40" align="center" valign="top" style="text-align: center;">Batch
			No.<font color="red">*</font>
		</th>
		<th width="40" align="center" valign="top" style="text-align: center;">Expiry
			Date<font color="red">*</font>
		</th>
		<th width="40" valign="top" style="text-align: center;">Issued Qty<font
			color="red">*</font>
		</th>
		<th width="40" valign="top" style="text-align: center;">Issue Date<font
			color="red">*</font>
		</th>
		
		<th width="60" valign="top" style="text-align: center;">Used Qty<font
			color="red">*</font>
		</th>
	
		<th width="60" valign="top" style="text-align: center;">Returned Qty<font
			color="red">*</font>
		</th>
		<th width="60" valign="top" style="text-align: center;">Return Remark
		</th>
	</tr>
	<?php  
		$slip_detail  = $storeDetails;?>
	<input type="hidden" value="<?php echo count($slip_detail);?>"
		id="no_of_fields" />
	<?php  		
	$i=0;$totalAmt=0;$checked="";
	foreach($slip_detail as $value){
		if (isset($value['PharmacyItem'])) {
			$value['Product'] = $value['PharmacyItem'];
		}
			$i++;
			
			?>
	<tr id="<?php echo 'row'.$i ?>">
		<td align="center" valign="middle" class="sr_number"><?php echo $i;?>
		</td>
		<td align="center" valign="middle"><input
			name="StoreRequisition[slip_detail][item_code][]" type="text"
			class="textBoxExpnd   item_code"
			id="<?php echo 'item_code'.$i;?>"
			value="<?php echo $value['Product']['product_code'];?>"
			style="width: 80%;" fieldNo="<?php echo $i?>"
			onkeyup="checkIsItemRemoved(this)" /> <input
			name="StoreRequisition[slip_detail][item_id][]"
			id="<?php echo 'item_id'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['item_id'];?>" />
			
			<input
			name="StoreRequisition[slip_detail][Pitem_id][]"
			id="<?php echo 'Pitem_id'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['purchase_order_item_id'];?>" />

			<input name="StoreRequisition[slip_detail][qty][]"
			id="<?php echo 'requested_id'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['requested_qty'];?>" />

			<input name="StoreRequisition[slip_detail][id][]"
			id="<?php echo 'id'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['id'];?>" />
		</td>
		<td align="center" valign="middle"><input
			name="StoreRequisition[slip_detail][item_name][]" type="text"
			class="textBoxExpnd validate[required] item_name"
			id="<?php echo "item_name".$i?>"
			value="<?php echo $value['Product']['name'];?>" style="width: 62%;"
			fieldNo="<?php echo $i?>" onkeyup="checkIsItemRemoved(this)" /> <!-- <a
			href="#" id="viewDetail1" class='fancy' style="visibility: hidden"><img
				title="View Item" alt="View Item" src="/img/icons/view-icon.png"> </a>-->
		</td>
		<td valign="middle" style="text-align: center;"><input
			name="StoreRequisition[slip_detail][batch_no][]" type="text"
			class="textBoxExpnd validate[required] batch_number"
			id="<?php echo 'batch_number'.$i;?>"
			value="<?php echo $value['PurchaseOrderItem']['batch_number'];?>"
			style="width: 80%;" autocomplete="off" fieldNo="<?php echo $i?>" />
		</td>
		<td valign="middle" style="text-align: center;"><?php $dateExp=$this->DateFormat->formatDate2Local($value['PurchaseOrderItem']['expiry_date'],Configure::read('date_format'));?>
			<label style="width: 70px;"><?php echo $dateExp;?> </label>
		</td>
		<td valign="middle" style="text-align: center;"><?php //issued qty
			if($value['StoreRequisitionParticular']['issued_qty']){
			$issue=$value['StoreRequisitionParticular']['issued_qty'];
		}else{
			$issue=$value['StoreRequisitionParticular']['requested_qty'];
		}?> <label style="width: 70px;"><?php echo $issue;?> </label> <input
			name="StoreRequisition[slip_detail][issued_qty][]" type="hidden"
			id="<?php echo 'issue_qty'.$i;?>" value="<?php echo $issue?>"
			fieldNo="<?php echo $i?>" />
		</td>
		<td valign="middle" style="text-align: center;"><?php $dateIssue=$this->DateFormat->formatDate2Local($StoreRequisition['StoreRequisition']['issue_date'],Configure::read('date_format'));?>
			<label style="width: 70px;"><?php echo $dateIssue;?> </label>
		</td>
		
		<td valign="middle" style="text-align: center;"><?php //used quatity?>
			<input name="StoreRequisition[slip_detail][used_qty][]" type="text"
			class="textBoxExpnd  used_quantity"
			id="<?php echo 'used_qty'.$i;?>"
			value="<?php echo $value['StoreRequisitionParticular']['used_qty'];?>"
			style="width: 80%;" fieldNo="<?php echo $i?>" /><input type="hidden"
			id="<?php echo 'stockQty'.$i;?>" value="0" />
		</td>
		<td valign="middle" style="text-align: center;"><?php //returned qty
		?> <input name="StoreRequisition[slip_detail][returned_qty][]"
			type="text"
			class="textBoxExpnd validate[required,number] return_quantity"
			id="<?php echo 'return_qty'.$i;?>"
			value="<?php echo $value['StoreRequisitionParticular']['returned_qty'];?>"
			style="width: 80%;" fieldNo="<?php echo $i?>" /><input type="hidden"
			id="<?php echo 'stockQty'.$i;?>" value="0" />
		</td>
		<td valign="middle" style="text-align: center;"><input
			name="StoreRequisition[slip_detail][return_remark][]" type="text"
			id="<?php echo 'return_remark'.$i;?>" style="width: 100%;"
			fieldNo="<?php echo $i?>" />
		</td>

	</tr>
	<?php $totalAmt=$totalAmt+$amt;
}?>
</table>
<div class="clr ht5"></div>

<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="250" align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="22" colspan="2" valign="top">Issue By:</td>
				</tr>
				<tr>
					<td width="60" height="25">Name</td>
					<td><input name="StoreRequisition[issue_by_name]" type="text"
						class="textBoxExpnd issue_name" id="issue_by" readonly="true"
						style="width: 180px;"
						value="<?php echo $issueBy['User']['first_name'].' '.$issueBy['User']['last_name']?>" />
						<input name="StoreRequisition[issue_by]" type="hidden"
						class="textBoxExpnd  issue_id" id="issue_id" style="width: 180px;"
						value="<?php echo $StoreRequisition['StoreRequisition']['issue_by'];?>" />
					</td>
				</tr>
				<tr>
					<td height="25">Date</td>
					<td><table width="165" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="140"><?php $date=date('d/m/Y');?> <input
									name="StoreRequisition[issue_date]" type="text"
									class="textBoxExpnd datetime " id="issue_date" readonly="true"
									style="width: 120px;" value="<?php echo $date;?>" /></td>
							</tr>
						</table></td>
				</tr>

			</table>
		</td>
		<td>&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="22" colspan="2" valign="top">Returned By:</td>
				</tr>
				<tr>
					<td width="60" height="25">Name</td>
					<td><input name="StoreRequisition[return_by_name]" type="text"
						class="textBoxExpnd return_name" id="return_by"
						style="width: 180px;"
						value="<?php echo $this->Session->read('first_name').' '.$this->Session->read('last_name')?>" />
						<input name="StoreRequisition[return_by]" type="hidden"
						class="textBoxExpnd  return_id" id="return_id"
						style="width: 180px;"
						value="<?php echo $this->Session->read('userid');?>" /></td>
				</tr>
				<tr>
					<td height="25">Date</td>
					<td><table width="165" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="140"><?php $date=date('d/m/Y');?> <input
									name="StoreRequisition[return_date]" type="text"
									class="textBoxExpnd datetime " id="return_date" readonly="true"
									style="width: 120px;" value="<?php echo $date;?>" /></td>
							</tr>
						</table></td>
				</tr>

			</table></td>

	</tr>
</table>
<div class="btns">
	<!--<input name="print" type="button" value="Print" class="blueBtn" /> -->
	<input
		name="submit" type="submit" value="Submit" class="blueBtn"
		id="submitButton" />
	<?php echo $this->Form->end();?>
</div>
<script>


$(document).ready(function() {
	isInStock=new Array();  // variable for check the item is in stock or not.
	$(".item_name").on('focus',function()
	{ 
		var fieldNo= $(this).attr('fieldNo');
		 var t = $(this);
		 $(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "store", "action" => "autocomplete_product","name","admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,
				cacheLength:10,
				onItemSelect:function (data1) {
					selectedId = t.attr('id');
					selectItem(data1,selectedId);
				},
				autoFill:false
			}
		);
	});

	/*
	*condition on both first and last name
	*user_autocomplete returns first and last name
	*/

	$(".return_name").focus(function(){
		$("#return_by").val('');
		$("#return_id").val('');
		$(this).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Users", "action" => "user_autocomplete","admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				 $('#return_id').val(ui.item.id); 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	 });
	
	$( "#return_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',	
		minDate: new Date(),		 
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
	    
	});

});





/* load the data from supplier master */
function loadDataFromRate(itemID,selectedId){
	var currentField = $("#"+selectedId);
	var fieldno = currentField.attr('fieldNo') ;
	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "store", "action" => "fetch_rate_for_item",'item_id','true',"admin" => false,"plugin"=>false)); ?>",
		  data: "item_id="+itemID,
		}).done(function( msg ) {
		 	var item = jQuery.parseJSON(msg);
			$("#item_name"+fieldno).val(item.Product.name);
			$("#item_id"+fieldno).val(item.Product.id);
			$("#item_code"+fieldno).val(item.Product.product_code);
            $("#manufacturer"+fieldno).val(item.Product.manufacturer);
		 	$("#pack"+fieldno).val(item.Product.pack);
			$("#batch_number"+fieldno).val(item.Product.batch_number);
			$("#expiry_date"+fieldno).val(item.Product.expiry_date);
			$("#stockQty"+fieldno).val(item.Product.stock);
			$("#mrp"+fieldno).val(item.Product.mrp);
			$("#rate"+fieldno).val(item.Product.sale_price);


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

 $(".issue_quantity").on('focus',function(){
	 var issueId=$(this).attr('id');
	 var fieldNo= $(this).attr('fieldno');
	 $('#'+issueId).val('');
	 $('#value'+fieldNo).val('');	 
 });
 $(".issue_quantity").on('change',function(){
	 var issueId=$(this).attr('id');
	 var fieldNo= $(this).attr('fieldno');
	 var issueQty = $('#'+issueId).val();
	 var reqQty=$('#requested_qty'+fieldNo).html();	 
	 var reqQty1=$('#requested_qty'+fieldNo).val();
	 if(reqQty=='' || isNaN(reqQty)){
		 reqQty=reqQty1;
	 }
	 var rate =$('#rate'+fieldNo).val();
	 var totAmt=0;
	 var i =1;
	 if(parseInt(issueQty) > parseInt(reqQty)){
		 alert('Issued quatity is exceeding from requested quantity');
		 $('#'+issueId).val('');
		 $('#value'+fieldNo).val('');
	 }else{
	 total = parseInt(issueQty)*parseInt(rate);
	 $('#value'+fieldNo).val(total);	
	 $.each('.issue_quantity', function() { 
		 amt= $('#value'+i).val();
		 if(amt!='' && !isNaN(amt)){
			totAmt= parseInt(totAmt)+parseInt(amt);
		 }
		 i++;
	 }); 
	 $("#total_amount").html(totAmt);
	 totAmt=0;
	 }
 });
 $(".deny").on('click', function(){
	 var fieldNo= $(this).attr('fieldno');
	
	 if(document.getElementById('deny'+fieldNo).checked==true){
		 $('#deny'+fieldNo).val('1');
		 $('#issue_remark'+fieldNo).addClass('validate[required]');
	 }else{
		 $('#deny'+fieldNo).val('0');
		 $('#issue_remark'+fieldNo).removeClass('validate[required]');
	 }
 });
 /* function addFields(){
	   var number_of_field = parseInt($("#no_of_fields").val())+1;
	   $(".formError").remove();
       var field = '';
	   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
	   field += '<td align="center" valign="middle"><input name="StoreRequisition[slip_detail][item_code][]" id="item_code'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_code"   value="" style="width:100%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/></td>';
       field += '<td align="center" valign="middle"  width="185"><input name="StoreRequisition[slip_detail][item_name][]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_name"  value="" style="width:70%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="StoreRequisition[slip_detail][item_id][]" id="item_id'+number_of_field+'" type="hidden" class="textBoxExpnd item_id"  value="" fieldNo="'+number_of_field+'"/><a href="#" id="viewDetail'+number_of_field+'"'+number_of_field+'" class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/DrmHope/img/icons/view-icon.png"></a></td>';
       field += '<td align="center" valign="middle"><input name="batch_no[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required] batch_number"  value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"/></td>';
	   field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[required] expiry_date"   value=""  style="width:80%;" autocomplete="off"/></td>';
	   field += ' <td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][issued_qty][]" type="text" class="textBoxExpnd issue_quantity validate[required]"  value="" id="issue_qty'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/></td>';
	   field += '<td align="center" valign="middle"><input name="issue_date[]" id="issue_date'+number_of_field+'" type="text" class="textBoxExpnd validate[required] issue_date"   value=""  style="width:80%;" autocomplete="off"/></td>';
	   field += ' <td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][used_qty][]" type="text" class="textBoxExpnd used_quantity validate[required]"  value="" id="used_qty'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/></td>';
	   field += ' <td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][returned_qty][]" type="text" class="textBoxExpnd return_quantity validate[required]"  value="" id="return_qty'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/></td>';
	   field += '<td align="center" valign="middle"><input name="return_date[]" id="return_date'+number_of_field+'" type="text" class="textBoxExpnd  return_date"   value=""  style="width:80%;" autocomplete="off"/></td>';
	   field += '<td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][is_denied]['+number_of_field+']" type="checkbox" class="textBoxExpnd  deny" id="deny'+number_of_field+'" fieldNo="'+number_of_field+'" value=""  style="width:80%;"/></td>';
	   field += '<td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][issue_remark][]" type="text" class="textBoxExpnd  issue_remark" id="issue_remark'+number_of_field+'" value=""  style="width:80%;"/></td>';
	   field +='  </tr>    ';
	$("#no_of_fields").val(number_of_field);
	$("#item-row").append(field);

		if (parseInt($("#no_of_fields").val()) == 1){
					$("#remove-btn").css("display","none");
				}else{
	$("#remove-btn").css("display","inline");
	}

}

 function deletRow(id){
	 	$("#row"+id).remove();
		$(".formError").remove();
		 var number_of_field = parseInt($("#no_of_fields").val());
		 $("#no_of_fields").val(number_of_field-1);
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
		$('.qty'+id+"formError").remove();
		$('.value'+id+"formError").remove();
		$('.rate'+id+"formError").remove();
		$('.mrp'+id+"formError").remove();
						if (parseInt($("#no_of_fields").val()) == 1){
							$("#remove-btn").css("display","none");
						}
						$("#submitButton").removeAttr('disabled');
		//field = "<td align='center' colspan='12'> Row deleted</td>";
		//$("#row"+id).append(field);
			var $form = $('#InventoryPurchaseDetailIssueRequisitionForm'),
	   				$summands = $form.find('.value');

						var sum = 0;
						$summands.each(function ()
						{
							var value = Number($(this).val());
							if (!isNaN(value)) sum += value;
						});

					$("#total_amount_field").val((sum.toFixed(2)));
					$("#total_amount").html((sum.toFixed(2)));

	}
 */
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

 $(".used_quantity").on('change',function(){
	 var usedId=$(this).attr('id');
	 var usedQty=$(this).val();
	 var fieldNo= $(this).attr('fieldno');
	 var issuedQty=$('#issue_qty'+fieldNo).val();
	 var returnedQty=parseInt(issuedQty)-parseInt(usedQty);
	 if(returnedQty<0){
		 alert("Returned Quantity is greater than issued quantity!");
		 $('#'+usedId).val('');		
	 }else{
		 $('#return_qty'+fieldNo).val(returnedQty);
	 }
 });

 $(".return_quantity").on('change',function(){
	 var usedId=$(this).attr('id');
	 var returnedQty=$(this).val();
	 var fieldNo= $(this).attr('fieldno');
	 var usedQty=$('#used_qty'+fieldNo).val();
	 var issuedQty=$('#issue_qty'+fieldNo).val();
	 var totalQty=parseInt(returnedQty)+parseInt(usedQty);
	 console.log(totalQty+"<"+issuedQty);
	 if(totalQty>issuedQty){
		 alert(" Returned Quantity is greater than  issued quantity!");
		 $('#'+usedId).val('');		
	 }
	
	 /*else if(totalQty<issuedQty){
		 alert(" Returned Quantity is less than  issued quantity!");
		 $('#'+usedId).val('');		
	 }*/
	 else{
		 $('#return_qty'+fieldNo).val(returnedQty);
	 }
 });

	$(document).on('input','.used_quantity,.return_quantity',function(){
		if (/[^0-9]/g.test(this.value))
	    {
	    	this.value = this.value.replace(/[^0-9]/g,'');
	    } 
		if (this.value.length > 7) this.value = this.value.slice(0,7);
	});
	
 </script>
