<?php  if(!($this->request['isAjax'])){
	echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js',
			'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js','jquery.fancybox-1.3.4','jquery.blockUI'));
	echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','jquery.fancybox-1.3.4.css')) ;
	
}?>

<style>
	.paid{
		background-color:#D9D9D9;
	}
</style>


<div style="padding-left: 20px; padding-top: 20px">
	<?php echo $this->Form->create('Payment',array('id'=>'payment'))?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center; border: solid 1px black">
		<tr>
			<th class="table_cell" colspan="8" align="left">Customer Name : <?php 
			if(is_null($data[0]['OtPharmacySalesBill']['patient_id']))
				echo ucfirst($data[0]['OtPharmacySalesBill']['customer_name']);
			else
				echo ucfirst($data[0]['Patient']['lookup_name']);?>
			</th>

		</tr>
		<tr class="row_title">
			<td class="table_cell" align="left"><?php echo $this->Form->input('checkMaster',array('id'=>'checkMaster','class'=>'checkMaster','type'=>'checkbox','div'=>false,'label'=>false)); ?></td>
			<td class="table_cell" align="left"><?php echo  __('Bill No.', true); ?></td>
			<!--  <td class="table_cell" align="left"><strong><?php echo __('Customer', true); ?> </strong>
			</td>-->
			<td class="table_cell" align="left"><strong><?php echo  __('Mode', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo  __('Date', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo  __('Amt.', true); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Paid', true); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Discount', true); ?>
			</strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Balance', true);?>
			</strong>
			</td>


		</tr>
		<?php
		$cnt =0; $totalBill=0;
		if(count($data) > 0) {
			$isAbleToSave = true;
       foreach($data as $sale):
       $cnt++;
       ?>
       <?php if($cnt%2 == 0) { $rowClass = "row_gray"; }else{ $rowClass = ""; }?>
       
       <?php $total = $sale['OtPharmacySalesBill']['total'];  ?>
			<?php $totalPaid = $sale['OtPharmacySalesBill']['paid_amount'] + $sale['OtPharmacySalesBill']['discount']; ?>
			<?php if($totalPaid == $total) {
				$checked = "checked"; 
				$disabled= "disabled"; 
				$rowClass = "paid";
			} else { 
				$isAbleToSave = false;
				$checked = $disabled = ""; 
			}?>		
			
			
		<tr class="<?php echo $rowClass; ?>">
			
			<td class="row_format" align="left"><?php echo $this->Form->input('',array('name'=>"data[Payment][bill_id][]",'hiddenField'=>false,'type'=>'checkbox','checked'=>$checked,'disabled'=>$disabled,'div'=>false,'label'=>false,'id'=>'saleBill_'.$sale['OtPharmacySalesBill']['id'],'class'=>'isCheck','value'=>$sale['OtPharmacySalesBill']['id'])); ?></td>
			<td class="row_format" align="left"><?php echo ($sale['OtPharmacySalesBill']['bill_code']); ?>
			</td>

			<!-- <td class="row_format" align="left"><?php
			if(is_null($sale['OtPharmacySalesBill']['patient_id']))
				echo ucfirst($sale['OtPharmacySalesBill']['customer_name']);
			else
				echo ucfirst($sale['Patient']['lookup_name']);
			?>
			</td>-->
			<td class="row_format" align="left"><?php echo ucfirst($sale['OtPharmacySalesBill']['payment_mode']); ?>
			</td>
			<?php if(!empty($sale['OtPharmacySalesBill']['modified_time'])){ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['OtPharmacySalesBill']['modified_time'],Configure::read('date_format')); ?>
			</td>
			<?php }else{ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['OtPharmacySalesBill']['created_time'],Configure::read('date_format')); ?>
			</td>
			<?php } ?>
			<td class="row_format" align="left"><?php echo  number_format($total,2);?></td>
			<td class="row_format" align="left"><?php 
				$paid = $sale['OtPharmacySalesBill']['paid_amount'];
			  echo  number_format($paid,2);?></td>
			<td class="row_format" align="left"><?php $discount=$sale['OtPharmacySalesBill']['discount'];
			echo number_format($discount,2);?></td>
			<td class="row_action" align="left">
			<?php echo number_format(round($total - $totalPaid),2); ?>
			 	<?php echo $this->Form->hidden('',array('name'=>"data[Payment][amount][]",'type'=>'text','div'=>false,'label'=>false,'style'=>"width:50px;",'readonly'=>'readonly','class'=>'amount','id'=>'amount_'.$sale['OtPharmacySalesBill']['id'],'value'=>$total - $totalPaid));?>
			</td>
		</tr>
		<?php $totalBill=$totalBill+$total; 
		endforeach;
		}
		?>
		<tr class="row_title">
			<td colspan="8" align="right"></td>
		</tr>
		<?php if($isAbleToSave == false){ ?>
		<tr>
			<td colspan="8" align="center">
				<table align="left">
					<tr>
						<td align="left">Amount Paying: </td>
						<td align="left" colspan="3"><?php echo $this->Form->input('total_amount',array('id'=>'amount','type'=>'text','readonly'=>'readonly','div'=>false,'label'=>false,'style'=>"width:50px;"));?></td>
					</tr>
					<tr>
						<!-- <td align="left">Is Discount:</td>
						<td align="left">
							<?php echo $this->Form->input('is_discount',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'isDiscount'))?>
						</td> 
						<td align="left">
							<span id="showDiscRadio" style="display:none;">
							<?php $discount=array('Amount'=>'Amount','Percentage'=>'Percentage');
							echo $this->Form->input('discount_type', array('id' =>'discountType','options' => $discount,
								'readonly'=>false,'legend' =>false,'label' => false,'div'=>false,'class'=>'discountType',
								'type' => 'radio','separator'=>'&nbsp;','default'=>'Amount','readonly'=>true)); ?>
							</span>
						</td>	
						<td align="left">
							<span id="showDiscTextbox" style="display:none;">
							<?php echo $this->Form->input('discount',array('type'=>'text','id'=>'inputDiscount','div'=>false,'label'=>false,'style'=>"width:50px;"));
								?>
							</span>
						</td> -->
						<td></td>
						<td>
							<?php echo $this->Html->link(__('Pay Amount'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn saveAmt','id'=>'saveAmt')); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>

 <script>
 	function display(){
 		var disc = '';
 		var balance = '<?php echo $balance; ?>'; 
		var paid_amount = $("#paid_amount").val()!=''?$("#paid_amount").val():0; 
		var calBal = parseFloat(balance) - paid_amount; 
		$("#balance_amount").val(calBal.toFixed(2));
		var balance_amount = $("#balance_amount").val(); 
		
		$(".discountType").each(function () {  
	        if ($(this).prop('checked')) {
	           var type = this.value;
	           if(type == "Amount")
	            {    
	            	disc = ($("#discount").val() != '') ? parseFloat($("#discount").val()) : 0;
	            }else if(type == "Percentage")
	            {
	            	var discount_value = ($("#discount").val()!= '') ? parseInt($("#discount").val()) : 0; //alert(discount_value);
	            	disc = parseFloat(balance_amount*discount_value)/100; //alert(disc);return false;
	            }
	           $("#disc").val(disc);	
	        }
	    });
		mRefund = ($("#maintainRefund").val()!='')?$("#maintainRefund").val():0;
		mDiscount = ($("#maintainDiscount").val()!='')?$("#maintainDiscount").val():0;
		if($('#is_refund').is(':checked'))
		{
	 		refund_amount = ($('#refund_amount').val() != '') ? parseFloat($("#refund_amount").val()) : 0;
	 	}else{
			refund_amount = 0;
	 	}
	 	bal =  balance_amount - disc + refund_amount; 
	 	$("#balance_amount").val(bal.toFixed(2));
 	}
 	
 	$(".discountType").change(function(){
		var type = $(this).val();
		$("#discount").show();
		$("#discount").val('');
		if(type == "Percentage"){
			$("#show_percentage").show();	
		}else{
			$("#show_percentage").hide();	
		}
	});

	 $("#is_refund").click(function(){
	    if($('#is_refund').is(':checked')){
	        $("#refund_amount").show();
		}else{
			$("#refund_amount").hide();
		}
	 });

	$("#paid_amount, #discount, #refund_amount, #is_refund").on('keyup keypress blur change input',function()
	{
		display();
	});

	$("#paid_amount").on('keyup',function()
	{
		var balance = '<?php echo $balance; ?>'; 
		if(parseFloat($("#paid_amount").val()) > parseFloat(balance)){
			alert("Pay amount is greater than remaining balance");
			$("#paid_amount").val('');
			$("#paid_amount").focus();
			display();
		}
	});

	$("#refund_amount").on('keyup',function()
		{
			var returnAmount = '<?php echo $returnAmt; ?>';
			var returnAmnt = parseFloat( returnAmount != 0 ? returnAmount : 0 ); 
			if(parseFloat($("#refund_amount").val()) > parseFloat(returnAmnt)){
				alert("Refund amount is greater than Return Amount");
				$("#refund_amount").val('');
				$("#refund_amount").focus();
				display();
			}
	});
	
	$("#discount").on('keyup',function()
	{
		$(".discountType").each(function () {  
	        if ($(this).prop('checked')) {
	           var type = this.value; 
	           var discount_value = parseFloat(($("#discount").val()!= '') ? $("#discount").val() : 0); //alert(discount_value);
	           if(type == "Percentage")
	            {
	            	if(discount_value > 101){
	        			alert("Percentage should be less than or equal to 100");
	        			$("#discount").val('');
	        			$("#discount").focus();
	        			display();
	        		}
	            }else if(type == "Amount"){
	            	if(discount_value > parseFloat($("#total-Amount").val()) ){
	            		alert("Discount amount is greater then total amount");
	        			$("#discount").val('');
	        			$("#discount").focus();
	        			display();
	            	}
	            }
	            	
	        }
	    });
	});

	$("#refund_amount").on('keyup',function(){
	   if( parseFloat($("#refund_amount").val()) > parseFloat($("#total-Amount").val()) ){
			alert("Refund amount is greater then total amount");
			$("#refund_amount").val('');
			$("#refund_amount").focus();
			display();
		}
		});
	
 	$("#saveAmt").click(function(){
 		var form_value = $("#payment").serialize();
 		//alert(form_value);
 		//return false;  
 		var patientId = '<?php echo $data[0]['Patient']['id']; ?>';
 		$.ajax({
 	 		type:'POST',
 			url: '<?php echo $this->Html->url(array('controller'=>'OtPharmacy','action'=>'savePaymentFromOt'));?>'+"/"+patientId,
 			data: form_value,
 			beforeSend:function(data){
 				loading('content-list','id');
 			},
 			success:function(data){
 				$('#content-list').html(data);
				onCompleteRequest('content-list','id');
				window.location.href= "<?php echo $this->Html->url(array("controller" => "OtPharmacy", "action" => "ot_details" ,'sales'));?>";
 			}
 		});
 	});

 	$('#card_pay').click(function(){
		 var amtInCard="<?php echo $patientCardAmt['Account']['card_balance'];?>";
		 var chkpay= $('#paid_amount').val();
		 var patientId = '<?php echo $data[0]['Patient']['id']; ?>';
		 if($("#card_pay").is(":checked")){			 
		 	if(!$('#paid_amount').val() || $('#paid_amount').val()<='0'){
			      alert('Please Enter Amount');
			      $('#paid_amount').focus();
			      $("#card_pay").attr("checked",false);
				  $("#patientCard").hide();	
				  $('#patientCardDetails').hide();
				  return false;
			 }else {			 	
		 		$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getCardBalance",
			   "admin" =>false)); ?>"+'/'+patientId,
			  context: document.body,				  		  
			  success: function(data){
				data= $.parseJSON(data);
				if(data.Account.id=='0' || isNaN(data.Account.id)){
			 		if(data.Account.card_balance=='0' || isNaN(data.Account.card_balance)){				
					 alert("Insufficient Funds in Patient Card");
					 $("#card_pay").attr("checked",false);
					 $("#patientCard").hide();
					 $('#patientCardDetails').hide();
				 }
			 }
			 else{
				 $('#balance_card').show();
				 $('#cardBal').text(data.Account.card_balance);
			 	 $('#patient_card').val(data.Account.card_balance);
			 	amtInCard=data.Account.card_balance;
				 var cardPay=amtInCard;
				 var discountVal=0;
					var otherPay=0;
					if($('.discountType').prop('checked')){
						discountVal=$('#disc').val();
						if(!discountVal || isNaN(discountVal)){
							discountVal=0;
						}
					}
					if(parseInt(chkpay)<parseInt(cardPay)){
						otherPay=0;
					    $('#patient_card').val(parseInt(chkpay)-parseInt(discountVal));
					}else{					
					   otherPay=(parseInt(chkpay)-parseInt(discountVal))-parseInt(cardPay);
					   $('#patient_card').val(cardPay);
					}		
					 $('#otherPay').text(otherPay);				
				 $("#patientCard").show();
				 $('#patientCardDetails').show();
			 } 
			  	
			  }
		});
			 
		}	 			 
		}else{
			$("#patientCard").hide();
			 $('#patientCardDetails').hide();
		}
	});

	$('#patient_card').keyup(function(){
		 var amtInCard= $('#cardBal').text();
		 var changeAmt=$(this).val();
		 var otherPay=$('#otherPay').text();
		 if(parseInt(changeAmt)>parseInt(amtInCard)){
			 alert("Insufficient Funds in Patient Card");
			 $("#card_pay").attr("checked",false);
			 $('#patient_card').val('');
			 $("#patientCard").hide();
			 $("#patientCardDetails").hide();
		 }else{
			 var chkpay= $('#paid_amount').val();
			 var discountVal=0;
			 if($('.discountType').prop('checked')){
					discountVal=$('#disc').val();
					if(!discountVal || isNaN(discountVal)){
						discountVal=0;
					}
				}
			 if(parseInt(changeAmt)>(parseInt(chkpay)-parseInt(discountVal))){
				 alert("Amount Paid is greater");
				 $("#card_pay").attr("checked",false);
				 $('#patient_card').val('');
				 $("#patientCard").hide();
				 $("#patientCardDetails").hide();
				 return false;
			 }
			 var otherPay=(parseInt(chkpay)-parseInt(discountVal))-changeAmt;
			 if(parseInt(otherPay)<=0)
				 otherPay=0;	
			 $('#otherPay').text(otherPay); 
		 }
	});

	$("#isDiscount").change(function(){
		
		if($(this).is(":checked",true)){
			$("#showDiscRadio").show();
			$("#showDiscTextbox").show();
		}else{
			$("#showDiscRadio").hide();
			$("#showDiscTextbox").hide();
			$("#inputDiscount").val('');
			$("#discount").val('');
		}
	});

	

	$(document).on('click',".isCheck",function(){
		var amount = 0;
		$(".isCheck").each(function(){
			if($(this).is(":checked",true)){
				id = $(this).attr('id').split("_")[1];
				amount += parseFloat($('#amount_'+id).val()); 
			}
		});
		$("#amount").val(amount.toFixed());  
	});

	$(document).on('click',".checkMaster",function(){
		var amount = 0;
		if($(this).is(":checked",true)){
			$(".isCheck").each(function(){
				if($(this).attr('disabled') != 'disabled'){
				 	$(this).prop('checked',true);
				 	id = $(this).attr('id').split("_")[1];
					amount += parseFloat($('#amount_'+id).val()); 
				}
			});
		}else{
			$(".isCheck").each(function(){
				if($(this).attr('disabled') != 'disabled'){
					$(this).prop('checked',false); 
				}
			});
		}
		$("#amount").val(amount.toFixed()); 
	});
		
	
 </script>
