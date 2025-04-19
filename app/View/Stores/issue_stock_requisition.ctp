<?php  
	echo $this->Html->script(array('jquery.blockUI'));
?>
<div class="inner_title">
	<h3>
		Issue Slip of Stock Location
		<?php echo __($StoreRequisition['StoreRequisition']['store_location']); ?>
	</h3>
	<?php if($this->params->query['pharmacy']){?>
	<span><?php echo $this->Html->link(__('Back'), array('controller'=>'InventoryCategories','action' => 'store_requisition_list','?'=>array('pharmacy'=>'pharmacy')), array('escape' => false,'class'=>'blueBtn'));?></span>
	<?php }else{?>
	<span><?php // echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	 echo $this->Html->link(__('Back'), array('controller'=>'InventoryCategories','action' => 'stock_requisition_list'), array('escape' => false,'class'=>'blueBtn'));?>
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
echo $this->Form->create('InventoryPurchaseDetail',array('id'=>'InventoryPurchaseDetailIssueRequisitionForm'));?>
<table width="50%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>Requisition From<font color="red">*</font>
		</td>
		<td><input name="party_name" type="text"
			class="textBoxExpnd validate[required]" id="party_name"
			value="<?php echo $requisition_from['Location']['name'];?>" disabled="disabled" />
			<input name="loc_from_id" type="hidden"
			class="textBoxExpnd" id="loc_from_id" 
			value="<?php echo $requisition_from['Location']['id'] ;?>" /></td>
		</td>
		<td>Requisition To<font color="red">*</font>
		</td>
		<td><input name="party_name" type="text"
			class="textBoxExpnd validate[required]" id="party_name"
			value="<?php echo $requisition_to['Location']['name'];?>" disabled="disabled" />
			<input name="loc_to_id" type="hidden"
			class="textBoxExpnd" id="loc_to_id" 
			value="<?php echo $requisition_to['Location']['id'];?>" /></td>
		</td>
	</tr>
</table>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="item-row">
	<tr>
		<th width="6%" align="center" valign="top" style="text-align: center;">Sr.</th>
		<th width="15%" align="center" valign="top"
			style="text-align: center;">Item Name<font color="red">*</font>
		</th>
		<th width="8%" align="center" valign="top"
			style="text-align: center;">Batch
		</th>
		<!-- <th width="80" align="center" valign="top" style="text-align: center;">Manufacturer</th> -->
		<!-- <th width="60" valign="top" style="text-align: center;">Pack</th>-->
		
		<th width="10%" valign="top" style="text-align: center;">Requested Qty<font
			color="red">*</font>
		</th>
		<th width="15%" valign="top" style="text-align: center;">Stock Quantity From <?php echo $requisition_from['Location']['name'];?>
		</th>
		<th width="15%" valign="top" style="text-align: center;">Stock Quantity To <?php echo $requisition_to['Location']['name'];?>
		</th>
		<th width="5%" valign="top" style="text-align: center;">Pre-Issued Qty
		</th>
		<th width="5%" valign="top" style="text-align: center;">Issued Qty<font
			color="red">*</font>
		</th>
		
	<!-- <th width="80" valign="top" style="text-align: center;">Deny</th> -->
		<th width="20%" valign="top" style="text-align: center;">Issue Remark
			<!--<font color="red">*</font>-->
		</th>
		<th width="3%" valign="top" style="text-align: center;">
		</th>

	</tr>
	<?php $slip_detail  = $storeDetails;?>
	<input type="hidden" value="<?php echo count($slip_detail);?>"
		id="no_of_fields" />
	<?php  		
	$i=0;$totalAmt=0;$checked="";
	foreach($slip_detail as $key=>$value){ 

		$i++;
			?>
	<tr id="<?php echo 'row'.$i ?>">
		<td align="center" valign="middle" class="sr_number"><?php echo $i;?>
		</td>
		
		<td align="center" valign="middle" width="250"><?php echo $value['ProductRate']['name'];?>
		<input name="StoreRequisition[slip_detail][item_name][]"
			type="hidden" class="item_name" id="<?php echo "item_name".$i?>"
			value="<?php echo $value['ProductRate']['name'];?>"
			fieldNo="<?php echo $i?>" />
			<input
			name="StoreRequisition[slip_detail][item_id][]"
			id="<?php echo 'item_id'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['item_id'];?>" />
			<input
			name="StoreRequisition[slip_detail][id][]"
			id="<?php echo 'StoreRequisitionParticularId'.$i;?>" type="hidden"
			value="<?php echo $value['StoreRequisitionParticular']['id'];?>" />
			<input	name="StoreRequisition[slip_detail][existing_stock_order_item_id][]" type="hidden"
			class="textBoxExpnd" id="pitemIdfrm1" fieldNo="<?php echo $i?>" value="<?php echo $value['ProductRate']['FromItemId'];?>" />
			
			<input	name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden"
			class="textBoxExpnd" id="Pitem_id1" fieldNo="<?php echo $i?>" value="<?php echo $value['ProductRate']['ToItemId'];?>" />
			
		</td>
		<td>
		<?php 		unset($batchArr);
		 		 foreach($commArr[$value['ProductRate']['toId']] as $keyBatch=>$prodBatch){
					if(empty($prodBatch['PharmacyItemRate']['batch_number']))
						continue;
					$batchArr[$prodBatch['PharmacyItemRate']['id']]=$prodBatch['PharmacyItemRate']['batch_number'];
				 }
				 echo $this->Form->input('',array('type'=>'select','options'=>$batchArr,'class'=>'textBoxExpnd validate[required] batch_number','id'=>'batch_number1','autocomplete'=>"off" ,"tabindex"=>"9","fieldNo"=>"1",'label'=>false,'name'=>"StoreRequisition[slip_detail][batch][]",'style'=>'width:80%;'));
			     //unset($commArr[$value['ProductRate']['id']]);
		?>
		</td>
		<!-- <td align="center" valign="middle" style="text-align: center;"><?php echo $value['Product']['pack'];?>
		<input name="pack[]" type="hidden" class="pack"
			id="<?php echo 'pack'.$i;?>"
			value="<?php echo $value['Product']['pack'];?>" />
		</td> -->
		
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
		<td valign="middle" style="text-align: center;"><?php //debug($itemsFrm);
		echo $value['ProductRate']['stockfrom'] //$value['ProductRate']['stock'] * $value['Product']['pack'] ?>  
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $value['ProductRate']['stock'] //$value['ProductRate']['stock'] * $value['Product']['pack'] ?>
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
			class="<?php echo $txtclass.' textBoxExpnd issue_quantity';?>"
			id="<?php echo 'issue_qty'.$i;?>" value="<?php echo $issue?>"
			style="width: 80%;" fieldNo="<?php echo $i?>" /><input type="hidden"
			id="<?php echo 'stockQty'.$i;?>" value="0" />
			<input name="StoreRequisition[slip_detail][mrp][]"
			type="hidden" class="mrp"
			id="<?php echo 'mrp'.$i;?>"
			value="<?php echo $value['ProductRate']['mrp'];?>"/>
		</td>
	
		<!-- <td valign="middle" style="text-align: center;"><?php
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
		</td>  -->
		<td valign="middle" style="text-align: center;"><input
			name="StoreRequisition[slip_detail][issue_remark][]" type="text"
			class="textBoxExpnd  issue_remark "
			id="<?php echo 'issue_remark'.$i;?>"
			value="<?php echo $value['StoreRequisitionParticular']['issue_remark'];?>"
			style="width: 100%;" fieldNo="<?php echo $i?>" />
		</td>
		<td></td>

	</tr>
	<?php //$totalAmt=$totalAmt+$amt;

}
?>
</table>
<div class="clr ht5"></div>
<div align="right">
	<input name="" type="button" value="Add More" class="blueBtn"
		onclick="addFields()" /><input name="" type="button" value="Remove"
		id="remove-btn" class="blueBtn" onclick="removeRow()"
		style="display: none" />
</div>
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
								<td width="140"><?php $issueValueDate=date('d/m/Y H:i:s');?> <input
									name="StoreRequisition[issue_date]" type="text"
									class="textBoxExpnd datetime " id="issue_date"
									style="width: 120px;" value="<?php echo $issueValueDate;?>" />
									</td>
							</tr>
						</table></td>
				</tr>

			</table></td>
	</tr>
</table>
<div class="btns">
	<?php echo $this->Form->input('StoreRequisition.status',array('id'=>'status','value'=>$status,'type'=>'hidden'));?>
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
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
    
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
	// $('#'+issueId).val('');
	 //$('#value'+fieldNo).val('');	 
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
	   field += '<tr id="row'+number_of_field+'"> ';
       field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
   	   field += '<td><input name="StoreRequisition[slip_detail][id][]" type="hidden" class="textBoxExpnd validate[required] item_name" id="StoreRequisitionParticularId'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/><input name="StoreRequisition[slip_detail][item_name][]" type="text" class="textBoxExpnd validate[required] item_name" id="itemName_'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/><input name="StoreRequisition[slip_detail][item_id][]" type="hidden" class="textBoxExpnd item_id" id="item_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> <input name="StoreRequisition[slip_detail][Pitem_id][]" type="hidden" class="textBoxExpnd Pitem_id" id="Pitem_id'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/> <input name="StoreRequisition[slip_detail][existing_stock_order_item_id][]" type="hidden" class="textBoxExpnd pitemIdfrm" id="pitemIdfrm'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:180px;"/></td>';
	   field += '<td><select name="StoreRequisition[slip_detail][batch][]" id="batch_number'+number_of_field+'" class="textBoxExpnd validate[required] batch_number" value=""  style="width:80%;" autocomplete="off" fieldNo="'+number_of_field+'"></select></td>';
	   field += 	'<td><input name="StoreRequisition[slip_detail][qty][]" type="text" autocomplete="off" class="textBoxExpnd validate[required,custom[number]] req_quantity" id="req_qty'+number_of_field+'" fieldNo="'+number_of_field+'" style="width:80px;"/> </td>';
	   //field += 	'<td align="center" id="pack'+number_of_field+'"></td>';
	   field += 	'<td align="center" id="stockfrm'+number_of_field+'"></td>';	 
	   field += 	'<td align="center" id="stock'+number_of_field+'"></td>';
	   field += 	'<td align="center" id="pack6667'+number_of_field+'">0</td>';
	   field += 	'<td><input name="StoreRequisition[slip_detail][issued_qty][]" type="text" autocomplete="off" class="textBoxExpnd issue_quantity" fieldNo="'+number_of_field+'" id="issue_qty'+number_of_field+'" style="width:60%; min-width:200px;"/> </td>';
	   field += 	'<td><input name="StoreRequisition[slip_detail][issue_remark][]" type="text" autocomplete="off" class="textBoxExpnd issue_remark" fieldNo="'+number_of_field+'" id="issue_remark'+number_of_field+'" style="width:60%; min-width:200px;"/> </td>';
	   field += 	'<td align="center"><a href="javascript:void(0);" onclick="deleteRow('+number_of_field+')"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>';
	   field += '</tr>    ';
	   /*field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
	   field += '<td align="center" valign="middle"><input name="StoreRequisition[slip_detail][item_code][]" id="item_code'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_code"   value="" style="width:100%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/></td>';
       field += '<td align="center" valign="middle"><input name="StoreRequisition[slip_detail][item_name][]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_name"  value="" style="width:70%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="StoreRequisition[slip_detail][item_id][]" id="item_id'+number_of_field+'" type="hidden" class="textBoxExpnd item_id"  value="" fieldNo="'+number_of_field+'"/><a href="#" id="viewDetail'+number_of_field+'"'+number_of_field+'" class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/DrmHope/img/icons/view-icon.png"></a></td>';
       field += '<td align="center" valign="middle"><input name="manufacturer[]" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"  value=""  style="width:100%;" autocomplete="off" readonly="true"/></td>';
	   field += '<td align="center" valign="middle"><input name="pack[]" id="pack'+number_of_field+'" type="text" class="textBoxExpnd "  value=""  style="width:100%;" readonly="true"/></td>';
	   field += '<td align="center" valign="middle"><input name="batch_no[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required] batch_number"  value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"/></td>';
	   field += '<td align="center" valign="middle"><input name="StoreRequisition[slip_detail][expiry_date][]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[required,future[NOW]] expiry_date"   value=""  style="width:80%;" autocomplete="off"/></td>';
	   field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd validate[required,number]"  value="" id="mrp'+number_of_field+'" style="width:100%;" readonly="true"/></td>';
	   field += ' <td valign="middle" style="text-align:center;"><input name="StoreRequisition[slip_detail][qty][]" type="text" class="textBoxExpnd quantity validate[required,number,funcCall[checkstock]]"  value="" id="requested_qty'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/></td>';
	   field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><img title="delete row" alt="Remove Item" src="/DrmHope/img/icons/cross.png" ></a></td>';
	   field +='  </tr>    ';*/
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
 $(document).on('focus','.item_name', function() {
		var flag=false;
		fieldNo= $(this).attr('fieldNo');
		var t = $(this);
		var LocIdFrm = $('#loc_from_id').val();
		var LocIdTo = $('#loc_to_id').val();	//send storeLocation id to fetch the product
     $(this).autocomplete({
          source: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "pharmacy_stock","admin" => false,"plugin"=>false)); ?>"+'/'+LocIdFrm+'/'+LocIdTo,
              minLength: 1,
              select: function( event, ui ) {
             	 selectedId = t.attr('id');
             	// var selectedId = ($(this).attr('id'));
             	 
  			loadDataFromRate(ui.item.id,selectedId);
  			
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
	             	     var value=ui.item.value;
	             	   //  console.log(value);
	             	     var split=value.split('(');
	             	     ui.item.value=split[0];    
	             	  
	             	     var pack = parseInt(ui.item.pack);
	             	     var quantity = parseInt(ui.item.quantity);
	             	  
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
	      				
	      				// onCompleteRequest(fieldNo);
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
 </script>
