<?php  if(!($this->request['isAjax'])){
	//echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js',
		//	'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js','jquery.fancybox-1.3.4','jquery.blockUI'));
	//echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','jquery.fancybox-1.3.4.css')) ;
	
}?>

<div style="padding-left: 20px; padding-top: 20px">
<?php echo $this->Form->create('Payment',array('id'=>'payment'))?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center;border: solid 1px black">
		<tr> 
			<th class="table_cell" colspan="8" align="left">Customer Name : <?php 
				echo ucfirst($data['0']['PharmacySalesBill']['customer_name']);
			?></th>
		
		</tr>
		<tr class="row_title">
			<td class="table_cell" align="left"><?php echo  __('Total Amount.', true); ?>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Total Paid', true); ?> </strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Discount', true); ?> </strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Refund', true); ?> </strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Return', true); ?> </strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Balance', true); ?>
			</strong></td>
		</tr>
		
		<tr class="row_gray">
		<?php 
			foreach($data as $details){ 
			$total = $details[0]['total']; $discount = $details[0]['disc']; $paid = $details['PharmacySalesBill']['paid_amnt']; 
			$returnAmt = $returnData[$details['PharmacySalesBill']['id']]; $refund = $details[0]['refundAmount'];?>
			<td class="table_cell" align="left"><?php echo (number_format($total,2)); ?> </td>
			<td class="table_cell" align="left"><?php echo (number_format($paid/* - $discount*/,2)); ?> </td>
			<td class="table_cell" align="left"><?php echo (number_format($discount,2)); ?> </td>
			<td class="table_cell" align="left"><?php echo (number_format($refund,2))?></td>
			<td class="table_cell" align="left"><?php echo (number_format($returnAmt,2))?></td>
			<td class="table_cell" align="left" id ="balance"><?php echo (number_format($balance = ($total-$paid-$discount-$returnAmt)+$refund ,2)); ?> </td>
		<?php }?>
		</tr>
		
 		<tr>
 			<td class="table_cell" align="left">
 				<?php echo __("Pay Amount:"); ?>
 			</td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Form->input('paid_amount',array('type'=>'text','id'=>'paid_amount','div'=>false,'label'=>false,'autocomplete'=>false));?>
 			</td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Form->hidden('total_amount',array('value'=>$total)); ?>
 			</td>
 		</tr>
 		<?php if($balance > 0 && $balance != 0){?>
 		<tr id="discountField">
 			<td class="table_cell" align="left">
 				<?php echo __("Discount:"); ?>
 			</td>
 			<td class="table_cell" align="left">
 				<?php $discount=array('Amount'=>'Amount','Percentage'=>'Percentage');
						echo $this->Form->input('discount_type', array('id' =>'discountType','options' => $discount,
							'autocomplete'=>'off','readonly'=>false,'legend' =>false,'label' => false,'div'=>false,'class'=>'discountType',
							'type' => 'radio','separator'=>'&nbsp;','disabled'=>false));
				?>
 			</td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Form->input('is_discount',array('type'=>'text','legend'=>false,'label'=>false,
											'id' => 'discount','autocomplete'=>'off','style'=>'text-align:right; display:none; width:50px;',
											'value'=>$discountAmount,'readonly'=>false,'div'=>false));
					  echo $this->Form->hidden('discount',array('id'=>'disc', 'value'=>'')); 
				?>
				<span id="show_percentage" style="display:none">%</span>
 			</td>
 		</tr>
 		<?php }?>
 		<tr>
 			<td class="table_cell" align="left">
 				<?php echo __("Refund:"); ?>
 			</td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Form->input('refund',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'is_refund')); ?>Yes/No
 			</td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Form->input('paid_to_patient',array('type'=>'text','id'=>'refund_amount','style'=>"display:none; width:50px;",'label'=>false,'div'=>false));?>
 			</td>
 		</tr>
 		<tr>
 			<td class="table_cell" align="left">
 				<strong><?php echo __("Balance:"); ?></strong>
 			</td>
 			<td class="table_cell" align="left">
 				<strong><?php echo $this->Form->input('amount_pending',array('type'=>'text','id'=>'balance_amount','readonly'=>true,'div'=>false,'label'=>false,'autocomplete'=>false)); ?>
 			</td>
 			<td class="table_cell" align="left"></td>
 		</tr>
 		<tr>
 			<td class="table_cell" align="left">
 				<?php echo __("Remark:"); ?>
 			</td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Form->input('remark',array('type'=>'textarea','id'=>'remark','readonly'=>false,'row'=>'3','div'=>false,'label'=>false,'autocomplete'=>false)); ?>
 			</td>
 			<td class="table_cell" align="left"></td>
 		</tr>
 		<tr>
 			<td class="table_cell" align="left">
 				<?php echo __("Date:"); ?>
 			</td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Form->input('date',array('type'=>'text','id'=>'payment_date','readonly'=>true,'label'=>false,'autocomplete'=>false,'class'=>'textBoxExpnd','value'=>date('d/m/Y H:i:s'))); ?>
 			</td>
 			<td class="table_cell" align="left"></td>
 		</tr>
	<?php /* if(ucfirst($data[0]['PharmacySalesBill']['payment_mode']) == 'Credit'){ 
 					if($balance != 0){ */
	?>
	 		<tr>
	 			<td class="table_cell" align="left"></td>
	 			<td class="table_cell" align="left">
	 				<?php echo $this->Html->link(__('Pay Amount'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn saveAmt','id'=>'saveAmt')); ?>
	 			</td>
	 			<td class="table_cell" align="left"></td>
	 		</tr>
	 	<?php /*  } 
	 		}else{  */ ?>
 		<?php //} ?>
 		<tr><td colspan="3">&nbsp;</td></tr>
 	</table>
 		<?php echo $this->Form->end();?>
 </div>
 
 <script>
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

 function display(){
		var disc = '';
		var balance = '<?php echo $balance; ?>'; 
		var paid_amount = $("#paid_amount").val()!=''?$("#paid_amount").val():0; 
		var calBal = parseFloat(balance) - paid_amount; 
		$("#balance_amount").val(calBal.toFixed(2));
		var balance_amount = $("#balance_amount").val(); 
		if(balance_amount != 0 && balance_amount != ""){
			
		}
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
	        var balance = '<?php echo $balance; ?>'; 
			if(balance < 0){
				$("#refund_amount").val(Math.abs(balance));
				display(); 
			}
		}else{
			$("#refund_amount").hide();
		}
	 });

	$("#paid_amount, #discount, #refund_amount, #is_refund").on('keyup keypress blur change input',function()
	{
		display();
	});

	$("#refund_amount").on('keyup',function()
			{
				if (/[^0-9\.]/g.test(this.value)){this.value = this.value.replace(/[^0-9\.]/g,'');}
				if(isNaN(refund_amount)){
			 		$("#balance_amount").val('');
			 	}
				var balance = '<?php echo $balance; ?>';
				var returnAmnt;
				if(balance < 0){
					returnAmnt = Math.abs(balance);
				} else{
					var returnAmount = '<?php echo $returnAmt; ?>'; 
					returnAmnt = parseFloat( returnAmount != 0 ? returnAmount : 0 ); 
				}
				var balance = $("#balance").val(); 
				
				//alert("bal=>"+balance);
				//alert(returnAmnt);
				if(parseFloat($("#refund_amount").val()) > parseFloat(returnAmnt)){
					alert("Refund amount is greater than Return Amount");
					$("#refund_amount").val('');
					$("#refund_amount").focus();
					display();
				}
		});
			
 	$("#saveAmt").click(function(){ 
 		var form_value = $("#payment").serialize(); 
 		//alert(form_value);

 		var otherSaleBillId = '<?php echo $data[0]['PharmacySalesBill']['id']; ?>'; 

 		$.ajax({
 	 		type:'POST',
 			url: '<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'savePharmacyPaymentIntoSaleBill','inventory'=>false));?>'+"/"+otherSaleBillId,
 			data: form_value,
 			beforeSend:function(data){
 				//loading('rightView_content','id');
 			},
 			success:function(data){
 	 			
 				//$('#rightView_content').html(data);
				//onCompleteRequest('rightView_content','id');
				//window.location.href= "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "get_other_pharmacy_details" ,'sales','inventory'=>true));?>";
 				parent.window.location.reload();
 			}
 		});
 	});

$(document).ready(function(){
 	$( "#payment_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
	});
});
 </script>
