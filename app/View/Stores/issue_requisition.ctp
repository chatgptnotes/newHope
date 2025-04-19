<div class="inner_title">
	<h3>
		Issue Slip of Store Location
		<?php echo __($StoreRequisition['StoreRequisition']['store_location']); ?>
	</h3>
	<?php if($this->params->query['pharmacy']){?>
	<span><?php echo $this->Html->link(__('Back'), array('controller'=>'InventoryCategories','action' => 'store_requisition_list','?'=>array('pharmacy'=>'pharmacy')), array('escape' => false,'class'=>'blueBtn'));?></span>
	<?php }else{?>
	<span><?php echo $this->Html->link(__('Back'), array('controller'=>'InventoryCategories','action' => 'store_inbox_requistion_list'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
	<?php }?>
</div>
<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	var formValidate = jQuery("#InventoryPurchaseDetailIssueRequisitionForm").validationEngine();
	
	
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
         			echo $errorsval ;
         			echo "<br />";
     			}
     ?>
			</div>
		</td>
	</tr>
</table>
<?php }

?>
<?php //echo $this->Html->script('jquery.autocomplete_pharmacy');
//echo $this->Html->css('jquery.autocomplete.css');
//echo $this->Html->script('jquery.fancybox-1.3.4');
//echo $this->Html->css('jquery.fancybox-1.3.4.css');
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
			class="textBoxExpnd validate[required]" id="party_name"
			value="<?php echo $requisition_for ;?>" disabled="disabled" /></td>
		</td>

	</tr>
</table>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="item-row">
	<tr>
		<th width="10" align="center" valign="top" style="text-align: center;">Sr.</th>
		<th width="80" align="center" valign="top" style="text-align: center;">Item
			Code<!--<font color="red">*</font>
		--></th>
		<th width="150" align="center" valign="top"
			style="text-align: center;">Item Name<font color="red">*</font>
		</th>
		<th width="80" align="center" valign="top" style="text-align: center;">Manufacturer</th>
		<th width="60" valign="top" style="text-align: center;">Pack</th>
		<!--<th width="80" align="center" valign="top" style="text-align: center;">Batch
			No.<font color="red">*</font>
		</th>
		<th width="50" align="center" valign="top" style="text-align: center;">Expiry
			Date<font color="red">*</font>
		</th> -->
		<!-- <th width="60" valign="top" style="text-align: center;">MRP<font
			color="red">*</font>
		</th> -->
		<th width="60" valign="top" style="text-align: center;"> Sale Price
		</th>
		<th width="60" valign="top" style="text-align: center;">Requested Qty<font
			color="red">*</font>
		</th>
		<th width="60" valign="top" style="text-align: center;">Current Stock
		</th>
		<th width="60" valign="top" style="text-align: center;">Pre-Issued Qty
		</th>
		<th width="60" valign="top" style="text-align: center;">Issued Qty<font
			color="red">*</font>
		</th>
		<!-- <th width="60" valign="top" style="text-align: center;">Price<font
			color="red">*</font>
		</th>
		<th width="80" valign="top" style="text-align: center;">Amount<font
			color="red">*</font>
		</th>-->
		<th width="30" valign="top" style="text-align: center;">Deny</th>
		<th width="200" valign="top" style="text-align: center;">Issue Remark
			<!--<font color="red">*</font>-->
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
		if($value['StoreRequisitionParticular']['requested_qty'] != $value['StoreRequisitionParticular']['issued_qty']){
			$i++;
			 
		
			?>
	<tr id="<?php echo 'row'.$i ?>">
		<td align="center" valign="middle" class="sr_number"><?php echo $i;?>
		</td>
		<td align="center" valign="middle"><label><?php echo $value['Product']['product_code'];?>
		</label> <input name="StoreRequisition[slip_detail][item_code][]"
			type="hidden" class="item_code" id="<?php echo 'item_code'.$i;?>"
			value="<?php echo $value['Product']['product_code'];?>"
			fieldNo="<?php echo $i?>" /> <input
			name="StoreRequisition[slip_detail][item_id][]"
			id="<?php echo 'item_id'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['item_id'];?>" />
			<input
			name="StoreRequisition[slip_detail][Pitem_id][]"
			id="<?php echo 'Pitem_id'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['purchase_order_item_id'];?>" />
			<input name="StoreRequisition[slip_detail][id][]"
			id="<?php echo 'id'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['id'];?>" />
		</td>
		<td align="center" valign="middle"><label><?php echo $value['Product']['name'];?>
		</label> <input name="StoreRequisition[slip_detail][item_name][]"
			type="hidden" class="item_name" id="<?php echo "item_name".$i?>"
			value="<?php echo $value['Product']['name'];?>"
			fieldNo="<?php echo $i?>" />
		</td>
		<td align="center" valign="middle" style="text-align: center;" > <?php echo $value['ManufacturerCompany']['name'];?> 
		 <input name="manufacturer[]" type="hidden"
			class="manufacturer" id="<?php echo 'manufacturer'.$i;?>"
			value="<?php echo $value['ManufacturerCompany']['id'];?>" />
		</td>
		<td align="center" valign="middle" style="text-align: center;"><?php echo $value['Product']['pack'];?>
		<input name="pack[]" type="hidden" class="pack"
			id="<?php echo 'pack'.$i;?>"
			value="<?php echo $value['Product']['pack'];?>" />
		</td>
		<!-- 
		<td valign="middle" style="text-align: center;"><label><?php echo $value['ProductRate']['batch_number'];?>
		</label> <input name="StoreRequisition[slip_detail][batch_no][]" type="hidden" class="batch_number"
			id="<?php echo 'batch_number'.$i;?>"
			value="<?php echo $value['ProductRate']['batch_number'];?>"
			fieldNo="<?php echo $i?>" />
		</td>
		<td valign="middle" style="text-align: center;"><?php $dateExp=$this->DateFormat->formatDate2Local($value['ProductRate']['expiry_date'],Configure::read('date_format'));?>
			<label><?php echo $dateExp;?> </label> <input name="StoreRequisition[slip_detail][expiry_date][]"
			type="hidden" id="<?php echo 'expiry_date'.$i;?>"
			value="<?php echo $dateExp;?>" /></td> -->
		<!-- <td valign="middle" style="text-align: center;"><label
			style="text-align: center;" class="mrp" id="<?php echo 'mrp'.$i;?>"><?php echo $value['Product']['mrp'];?>
		</label>
		</td>-->
		<td valign="middle" style="text-align: center;"> <?php echo number_format($value['ProductRate']['sale_price'],2);?>  
		</td>
		<td valign="middle" style="text-align: center;"><label
			style="text-align: center;" class="req_quantity"
			id="<?php echo 'req_qty'.$i;?>" fieldNo="<?php echo $i?>"><?php echo $value['StoreRequisitionParticular']['requested_qty'];?>
		</label> <input name="StoreRequisition[slip_detail][qty][]"
			id="<?php echo 'requested_qty'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['requested_qty'];?>" />
			<input name="StoreRequisition[slip_detail][remark][]"
			id="<?php echo 'remark'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['remark'];?>" />
		</td>
		<td valign="middle" style="text-align: center;"><?php echo ($value['ProductRate']['stock'] * $value['Product']['pack']) + $value['ProductRate']['loose_stock']; ?>
		</td>
		<?php $txtclass='';$preIssue=0;
		if($value['StoreRequisitionParticular']['issued_qty']){
			if($value['StoreRequisitionParticular']['issued_qty']<$value['StoreRequisitionParticular']['requested_qty']){
				$issue=$value['StoreRequisitionParticular']['requested_qty']-$value['StoreRequisitionParticular']['issued_qty'];
				$preIssue=$value['StoreRequisitionParticular']['issued_qty'];
			}else if($value['StoreRequisitionParticular']['issued_qty']==$value['StoreRequisitionParticular']['requested_qty']){
				$preIssue=$value['StoreRequisitionParticular']['issued_qty'];
				$issue='0';
			}
			$txtclass='validate[required,number]';
		}else{
				if($value['StoreRequisitionParticular']['is_denied']){
					$issue='';
					$txtclass='';
				}else{
					$issue=$value['StoreRequisitionParticular']['requested_qty'];
					$txtclass='validate[required,number]';
					}
		}
		?>
		<td valign="middle" style="text-align: center;"><?php echo $preIssue;?></td>
		<td valign="middle" style="text-align: center;">
		    <input name="StoreRequisition[slip_detail][pre_issued_qty][]"
			type="hidden"
			class="<?php echo $txtclass.'textBoxExpnd pre_issue_quantity';?>"
			id="<?php echo 'pre_issue_qty'.$i;?>" value="<?php echo $preIssue?>"
		    fieldNo="<?php echo $i?>" />
		
		<input name="StoreRequisition[slip_detail][issued_qty][]"
			type="text"
			class="<?php echo $txtclass.'textBoxExpnd issue_quantity';?>"
			id="<?php echo 'issue_qty'.$i;?>" value="<?php echo $issue?>"
			style="width: 80%;" fieldNo="<?php echo $i?>" /><input type="hidden"
			id="<?php echo 'stockQty'.$i;?>" value="0" />
			<input name="StoreRequisition[slip_detail][mrp][]"
			type="hidden" class="mrp"
			id="<?php echo 'mrp'.$i;?>"
			value="<?php echo $value['ProductRate']['mrp'];?>"/>
		</td>
		<!-- <td valign="middle" style="text-align: center;"><input name="rate[]"
			type="text" class="textBoxExpnd validate[required,number] rate"
			id="<?php echo 'rate'.$i;?>"
			value="<?php echo $value['ProductRate']['sale_price'];?>"
			style="width: 80%;" />
		</td>
		<td valign="middle" style="text-align: center;"><?php $amt=$issue*$value['ProductRate']['sale_price'];?>
			<input name="value[]" type="text"
			class="textBoxExpnd validate[required,number] value"
			id="<?php echo 'value'.$i;?>" value="<?php echo $amt;?>"
			style="width: 80%;" />
		</td>  -->
		<td valign="middle" style="text-align: center;"><?php
		if(!empty($value['StoreRequisitionParticular']['is_denied']) && $value['StoreRequisitionParticular']['is_denied']!=NULL){
			$checked="checked='checked'";
		}else{
			$checked=false;
			}
			?> <input
			name="StoreRequisition[slip_detail][is_denied][<?php echo $i;?>]"
			type="checkbox" class="textBoxExpnd deny" <?php echo $checked;?>
			id="<?php echo 'deny'.$i;?>"
			value="<?php echo $value['StoreRequisitionParticular']['is_denied'];?>"
			style="width: 80%;" fieldNo="<?php echo $i?>" />
		</td>
		<td valign="middle" style="text-align: center;"><input
			name="StoreRequisition[slip_detail][issue_remark][]" type="text"
			class="textBoxExpnd  issue_remark "
			id="<?php echo 'issue_remark'.$i;?>"
			value="<?php echo $value['StoreRequisitionParticular']['issue_remark'];?>"
			style="width: 100%;" fieldNo="<?php echo $i?>" />
		</td>

	</tr> 
	<?php } //end of if?>
	<?php //$totalAmt=$totalAmt+$amt;

}
?>
</table>
<div class="clr ht5"></div>
<!--<div align="right">
	<input name="" type="button" value="Add More" class="blueBtn"
		onclick="addFields()" /><input name="" type="button" value="Remove"
		id="remove-btn" class="blueBtn" onclick="removeRow()"
		style="display: none" />
</div>-->
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">

	<!-- <tr>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2">Total Amount :</td>
		<td><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;<span
			id="total_amount"><?php echo $totalAmt?> </span><input
			name="PharmacySalesBill[total]" id="total_amount_field"
			value="<?php echo $totalAmt?>" type="hidden" />
		</td>
	</tr> -->
	<tr>
		<td width="250" align="left" valign="top"><table width="100%"
				border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="22" colspan="2" valign="top">Issue By:</td>
				</tr>
				<tr>
					<td width="60" height="25">Name</td>
					<td><input name="StoreRequisition[issue_by_name]" type="text"
						class="textBoxExpnd issue_name" id="issue_by"
						style="width: 180px;"
						value="<?php echo $this->Session->read('first_name').' '.$this->Session->read('last_name')?>" />
						<input name="StoreRequisition[issue_by]" type="hidden"
						class="textBoxExpnd  issue_id" id="issue_id" style="width: 180px;"
						value="<?php echo $this->Session->read('userid');?>" /></td>
				</tr>
				<tr>
					<td height="25">Date</td>
					<td><table width="165" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="140"><?php $date=date('d/m/Y H:i:s');?> <input
									name="StoreRequisition[issue_date]" type="text"
									class="textBoxExpnd datetime " id="issue_date"
									style="width: 120px;" value="<?php echo $date;?>" /></td>
							</tr>
						</table></td>
				</tr>

			</table></td>
	</tr>
</table>
<div class="btns">
	<?php echo $this->Form->input('StoreRequisition.status',array('id'=>'status','value'=>$status,'type'=>'hidden'));?>
	<!-- <input name="print" type="submit" value="Print" class="blueBtn" /> --> 
	<input name="submit" type="submit" value="Submit" class="blueBtn"
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



});

$("#party_code").on('focus',function()
			  {
			  var t = $(this);
               $("#ss").hide();
			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","admission_id","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:function (li) {
			  if( li == null ) return alert("No match!");
				var person_id = li.extra[0];
				$("#person_id").val(person_id);
				$("#party_name").val(li.extra[1]);
                var link = '<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_credit_detail","plugin"=>false)); ?>/'+person_id;
                 $("#ss").attr("href",link);
                   $("#ss").show();
             
			},
			autoFill:false
		}
	);
			  });

function openCreditDetail(person_id){

    window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_credit_detail","plugin"=>false)); ?>/'+person_id,'','width=500,height=150,location=0,scrollbars=no');

}
$("#doctor_name").on('focus',function()
			  {
			  var t = $(this);
			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "doctors", "action" => "getDoctorDetail","first_name","plugin"=>false,"inventory" => false,"admin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectDoctor,
			autoFill:false
		}
	);
			  });


$(".batch_number").on('focus',function()
			  {
			  var t = $(this);
			  var fieldno = t.attr('fieldNo') ;
             $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_batch_number_of_item_for_sale","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			onItemSelect:function (data1) {
			 $("#mrp"+fieldno).val("");
            $("#rate"+fieldno).val("");
            $("#value"+fieldno).val("");
			$.ajax({
        		  type: "GET",
        		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_from_batch_no","inventory" => true,"plugin"=>false)); ?>",
        		  data: "batchno="+$("#batch_number"+fieldno).val()+"&item_id="+$("#item_id"+fieldno).val(),
        		}).done(function( msg ) {
        		 	var ItemDetail = jQuery.parseJSON(msg);

            		 	$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
                    	$("#rate"+fieldno).val(ItemDetail.PharmacyItemRate.sale_price);
                        $("#expiry_date"+fieldno).val(ItemDetail.PharmacyItemRate.expiry_date);

                	});

            },
			autoFill:false,
			extraParams: {itemId:$("#item_id"+fieldno).val() },
		}
	);

});

$("#party_name").on('focus',function()
			  {
			  var t = $(this);
               $("#ss").hide();
			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:function (li) {
			  if( li == null ) return alert("No match!");
				var person_id = li.extra[0];
				$("#person_id").val(person_id);
				$("#party_code").val(li.extra[1]);

               var link = '<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_credit_detail","plugin"=>false)); ?>/'+person_id;
                 $("#ss").attr("href",link);
                 $("#ss").show();

			},
			autoFill:false
		}
	);

});



$( ".expiry_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate("");?>',
    
});
$( "#issue_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
    
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
 /*$("#ss").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});*/

 $(".issue_quantity").on('focus',function(){
	 var issueId=$(this).attr('id');
	 var fieldNo= $(this).attr('fieldno');
	 $('#'+issueId).val('');
	 $('#value'+fieldNo).val('');	 
 });
			 
 $(".issue_quantity").on('change',function(){
	 var issueId=$(this).attr('id');
	 var fieldNo= $(this).attr('fieldno');
	 var issueQty = parseInt($('#'+issueId).val())+parseInt($('#pre_'+issueId).val());
	 var reqQty=$('#requested_qty'+fieldNo).html();	 
	 var reqQty1=$('#requested_qty'+fieldNo).val();
	 $('#deny'+fieldNo).attr({'checked':false, 'value': '0'});
	 if(reqQty=='' || isNaN(reqQty)){
		 reqQty=reqQty1;
	 }
	 if(parseInt(issueQty) > parseInt(reqQty)){
		 alert('Issued quatity is exceeding from requested quantity');
		 $('#'+issueId).val('');
		 $('#value'+fieldNo).val('');
	 }
	 
 });
 $(".deny").on('click', function(){
	 var fieldNo= $(this).attr('fieldno');
	 $('#issue_qty'+fieldNo).val('')
	 $('#value'+fieldNo).val('');
	
	 if(document.getElementById('deny'+fieldNo).checked==true){
		 
		 $('#deny'+fieldNo).val('1');
		 $('#issue_qty'+fieldNo).removeClass('validate[required,number]');
		 $('#value'+fieldNo).removeClass('validate[required,number]');
		// $('#issue_remark'+fieldNo).addClass('validate[required]');
		
		 
	 }else{
		 $('#deny'+fieldNo).val('0');
		 $('#issue_qty'+fieldNo).addClass('validate[required,number]');
		 $('#value'+fieldNo).addClass('validate[required,number]');
		 //$('#issue_remark'+fieldNo).removeClass('validate[required]');
	 }

 });

$('#submitButton').click(function (){
	var formValidate = jQuery("#InventoryPurchaseDetailIssueRequisitionForm").validationEngine('validate');
	if(formValidate == true){
		$('#submitButton').hide();	
	var issue=false;
	var parIssue=false;
	var parReject=false;
	var recordCount = parseInt($("#no_of_fields").val()); 
	var cnt=0; var denyCnt=0;
	for( var i = 1; i <= recordCount; i++ ){
	var deniedValues = '';
	var requestedValues = '';
	var issuedValues = '';
		requestedValues = parseInt($.trim($('#req_qty'+i).html()));
		issuedValues = parseInt($('#issue_qty'+i).val())+parseInt($('#pre_issue_qty'+i).val());
		deniedValues =  $('#deny'+i).val();
		if(requestedValues == issuedValues){
			cnt++;
		}
		if(requestedValues > issuedValues){
			parIssue=true;
		}
		if($('#deny'+i).is(':checked')){
			parReject=true;
			denyCnt++
		}
	}
	if(cnt==recordCount && denyCnt==0){
		$('#status').val('Issued');
	}else if(cnt==0 && denyCnt==recordCount){
		$('#status').val('Rejected');
	}else if(denyCnt != recordCount && cnt!=recordCount && parReject==true){
		$('#status').val('Partially Rejected');
	}else if(parIssue==true && denyCnt == 0 && cnt!=recordCount && parReject==false){
		$('#status').val('Partially Issued');
	}
	}else{
		return false;
	}
	
});
 
 function addFields(){
	   var number_of_field = parseInt($("#no_of_fields").val())+1;
	   $(".formError").remove();
       var field = '';
	   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
	   field += '<td align="center" valign="middle"><input name="StoreRequisition[slip_detail][item_code][]" id="item_code'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_code"   value="" style="width:100%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/></td>';
       field += '<td align="center" valign="middle"  width="185"><input name="StoreRequisition[slip_detail][item_name][]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_name"  value="" style="width:70%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="StoreRequisition[slip_detail][item_id][]" id="item_id'+number_of_field+'" type="hidden" class="textBoxExpnd item_id"  value="" fieldNo="'+number_of_field+'"/><a href="#" id="viewDetail'+number_of_field+'"'+number_of_field+'" class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/DrmHope/img/icons/view-icon.png"></a></td>';
       field += '<td align="center" valign="middle"><input name="manufacturer[]" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"  value=""  style="width:100%;" autocomplete="off" readonly="true"/></td>';
	   field += '<td align="center" valign="middle"><input name="pack[]" id="pack'+number_of_field+'" type="text" class="textBoxExpnd "  value=""  style="width:100%;" readonly="true"/></td>';
	   field += '<td align="center" valign="middle"><input name="batch_no[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required] batch_number"  value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"/></td>';
	   field += '<td align="center" valign="middle"><input name="StoreRequisition[slip_detail][expiry_date][]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[required,future[NOW]] expiry_date"   value=""  style="width:80%;" autocomplete="off"/></td>';
	   field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd validate[required,number]"  value="" id="mrp'+number_of_field+'" style="width:100%;" readonly="true"/></td>';
	   field += ' <td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][qty][]" type="text" class="textBoxExpnd quantity validate[required,number,funcCall[checkstock]]"  value="" id="requested_qty'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/></td>';
	   field += ' <td valign="middle" style="text-align:center;">0</td>';
	   field += ' <td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][issued_qty][]" type="text" class="textBoxExpnd issue_quantity validate[required]"  value="" id="issue_qty'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/><input name="StoreRequisition[slip_detail][pre_issued_qty][]" type="hidden" class="textBoxExpnd pre_issue_quantity "  value="0" id="pre_issue_qty'+number_of_field+'"  fieldNo="'+number_of_field+'"/></td>';
       field += '<td valign="middle" style="text-align:center;"><input name="rate[]" type="text" class="textBoxExpnd validate[required,number]"  value="" id="rate'+number_of_field+'" style="width:100%;" readonly="true" /></td>';
       field += ' <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd  validate[required,number] value" id="value'+number_of_field+'"  value=""  style="width:100%;"/></td> ';
	   field += '<td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][is_denied]['+number_of_field+']" type="checkbox" class="textBoxExpnd  deny" id="deny'+number_of_field+'" fieldNo="'+number_of_field+'" value=""  style="width:80%;"/></td>';
	   field += '<td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][issue_remark][]" type="text" class="textBoxExpnd  issue_remark" id="issue_remark'+number_of_field+'" value=""  style="width:80%;"/></td>';
	   field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><img title="delete row" alt="Remove Item" src="/DrmHope/img/icons/cross.png" ></a></td>';
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

	$(document).on('input','.issue_quantity',function(){
		if (/[^0-9]/g.test(this.value))
	    {
	    	this.value = this.value.replace(/[^0-9]/g,'');
	    } 
	});
 </script>
