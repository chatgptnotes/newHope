<?php  if(!($this->request['isAjax'])){
	echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js',
			'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js','jquery.fancybox-1.3.4','jquery.blockUI'));
	echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','jquery.fancybox-1.3.4.css')) ;
	
}?>

<style>
	.paid{
		background-color:#D9D9D9;
	}
	.selectedRow{
		background-color:#DEE2B4;
	}
</style>


<div style="padding-left: 20px; padding-top: 20px">
	<?php echo $this->Form->create('Payment',array('id'=>'payment'))?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center; border: solid 1px black">
		<tr>
			<th class="table_cell" colspan="8" align="left">Patient Name : <?php 
			if(is_null($data[0]['PharmacySalesBill']['patient_id']))
				echo ucfirst($data[0]['PharmacySalesBill']['customer_name']);
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
       foreach($data as $key => $sale):
       $cnt++;
       ?>
       <?php if($cnt%2 == 0) { $rowClass = "row_gray"; }else{ $rowClass = ""; }?>
       
       <?php 
       $tax = ($sale['PharmacySalesBill']['tax'] * $sale['PharmacySalesBill']['total']) / 100;
       $total = round($sale['PharmacySalesBill']['total']+ $tax); ?>
			<?php $totalPaid = round($sale['PharmacySalesBill']['paid_amnt'] + $sale['PharmacySalesBill']['discount'] + $tax); ?>
			<?php if($totalPaid == $total) {
				$checked = "checked"; 
				$disabled= "disabled"; 
				$rowClass = "paid";
				$paid = "yes";
			} else { 
				$isAbleToSave = false;
				$checked = $disabled = "";
				$paid = "no"; 
			}?>		
			
			
		<tr class="<?php echo $rowClass; ?>" id="row_<?php echo $key; ?>">
			
			<td class="row_format" align="left"><?php echo $this->Form->input('',array('name'=>"data[Payment][bill_id][]",'isPaid'=>$paid,'fieldno'=>$key,'hiddenField'=>false,'type'=>'checkbox','checked'=>$checked,'disabled'=>$disabled,'div'=>false,'label'=>false,'id'=>'saleBill_'.$sale['PharmacySalesBill']['id'],'class'=>'isCheck','value'=>$sale['PharmacySalesBill']['id'])); ?></td>
			<td class="row_format" align="left"><?php echo  ($sale['PharmacySalesBill']['bill_code']); ?>
			</td>

			<!-- <td class="row_format" align="left"><?php
			if(is_null($sale['PharmacySalesBill']['patient_id']))
				echo ucfirst($sale['PharmacySalesBill']['customer_name']);
			else
				echo ucfirst($sale['Patient']['lookup_name']);
			?>
			</td>-->
			<td class="row_format" align="left"><?php echo ucfirst($sale['PharmacySalesBill']['payment_mode']); ?>
			</td>
			<?php if(!empty($sale['PharmacySalesBill']['modified_time'])){ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['PharmacySalesBill']['modified_time'],Configure::read('date_format')); ?>
			</td>
			<?php }else{ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['PharmacySalesBill']['create_time'],Configure::read('date_format')); ?>
			</td>
			<?php } ?>
			<td class="row_format" align="left"><?php echo number_format(round($total),2);?></td>
			<td class="row_format" align="left"><?php 
				$paid = round($sale['PharmacySalesBill']['paid_amnt']);//-$sale['PharmacySalesBill']['discount'];
				echo $this->Form->hidden('',array('name'=>"data[Payment][paid_to_patient][]",'value'=>$paid,'class'=>'paidAmt','id'=>'paidAmt_'.$sale['PharmacySalesBill']['id'])); 
			 echo  number_format($paid,2);?></td>
			<td class="row_format" align="left"><?php $discount=$sale['PharmacySalesBill']['discount'];
			echo  number_format($discount,2);?></td>
			<td class="row_action" align="left">
				<?php echo number_format(round($total - $totalPaid + $tax),2); ?>
			 	<?php echo $this->Form->hidden('',array('name'=>"data[Payment][amount][]", 'class'=>'amount','id'=>'amount_'.$sale['PharmacySalesBill']['id'],'value'=>round($total - $totalPaid + $tax)));?>
			</td>
		</tr>
		<?php $totalBill=$totalBill+$total; 
		endforeach;
		}
		?>
		<tr class="row_title">
			<td colspan="8" align="right"></td>
		</tr>
		
		<tr>
			<td colspan="8" align="center">
				<table align="left">
				<?php if($isAbleToSave == false){ ?>
					<tr id="amountPay">
						<td align="left">Amount Paying: </td>
						<td align="left"><?php echo $this->Form->input('total_amount',array('id'=>'amount','type'=>'text','readonly'=>'readonly','div'=>false,'label'=>false,'style'=>"width:50px;"));
						echo $this->Form->hidden('advance_used',array('id'=>'adv_used','value'=>$billAdv,'readonly'=>'readonly','div'=>false,'label'=>false,'style'=>"width:50px;"));?></td>
						<?php if(strtolower($this->Session->read('website.instance')) != "vadodara" ) {?>
							<td align="left"  ><?php echo __("Advance Amount : ");?><span id="advance"><?php if($paidAmt-$billAdv > 0) { echo $paidAmt-$billAdv; }else{ echo "0"; }?></span></td>
							<td align="left" ><?php 
							if($this->Session->read('website.instance')!="vadodara" && $this->Session->read('website.instance')!="kanpur"){ 
								echo __(" Amount after discount : ");?>
								<span id="discAmt">
									<?php echo $paidAmt-$billAdv;?>
								</span>
							<?php } ?></td>
						<?php }?>	
						<td style="float: right;"><?php echo __('Return Amount:');?></td>
						<td>
						<?php echo $returnTotal = $returnedAmnt[$data[0]['PharmacySalesBill']['patient_id']] - $refund; 
						echo $this->Form->hidden('return_amount',array('id'=>'return_amount','div'=>false,'label'=>false,'value'=>$returnTotal));
						echo $this->Form->hidden('return_amount',array('id'=>'refund_amount','div'=>false,'label'=>false,'value'=>$refund));
						?>
						</td>
						
					</tr>
					<?php if(strtolower($this->Session->read('website.instance')) != "vadodara" && strtolower($this->Session->read('website.instance')) != "kanpur") {?>
					<tr id="discamount">
						<td align="left">Is Discount:</td>
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
						</td>
						<td align="left"> </td>
					</tr>
					<?php } ?>
					<?php if($this->Session->read('website.instance')!='kanpur'){?>
		<tr id='cardRow' >
		<td><?php echo 'Move From Card'?></td>
			<td style=" padding: 0px 0px 0px 2px;" colspan="3">
				<?php echo $this->Form->input('PharmacySalesBill.is_card',array('type'=>'checkbox',
						'div'=>false,'label'=>false,'id'=>'card_pay','style'=>'float:left;'));?>
						<span id="balance_card" style="display: none;"><b>Balance In Card : <font  color="green" id="cardBal">
				<?php echo !empty($patientCard['Account']['card_balance'])?$patientCard['Account']['card_balance']:'0';?>
			  </b></font></span></td>
			
		</tr>
		<tr>
			<td colspan="3"> 
				<table  id="patientCard" style="display:none">
	   		    	<tr>
						<td style=" padding: 0px 0px 0px 2px;">
						  	<?php 
						  	if(empty($patientCard['Account']['card_balance'])){
						  		$payFromCard='0';
						  	}
						  	if($patientCard['Account']['card_balance']>=$totalCost){
						  		$payFromCard=$totalCost;
						  	}elseif($patientCard['Account']['card_balance']<=$totalCost){
								$payFromCard=$patientCard['Account']['card_balance'];
							}
							$payOtherMode=$totalCost-$payFromCard;
						  	echo 'Amount To Deduct From Card  '.$this->Form->input('PharmacySalesBill.patient_card',array('type'=>'text','class'=>'patient_card','legend'=>false,'label'=>false,'div'=>false,'value'=>$payFromCard,'id' => 'patient_card'));?></td>
					  </td>
					  </tr>
					  <tr>
					   <td style="vertical-align: top"><?php echo "<b>Pay By Cash : <font color='red'><span id='otherPay'>$payOtherMode</span></font></b>";?></td>
					</tr>   		    
	   		    </table>
   		   </td>
   	  </tr>
	<?php }?>
					
					<!-- <tr>
						<td align="left">Is Refund: </td>
						<td align="left"><?php echo $this->Form->input('is_refund',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'isRefund'))?></td>
						<td align="left">
							<span id="showRefund" style="display:block;">
							<?php echo $this->Form->input('refund_amount', array('id' =>'refund_amount','label' => false,'div'=>false,'class'=>'refundAmount',
								'type' => 'text','style'=>"width:50px")); ?>
							</span>
						</td>
					</tr>
					 -->
					<tr>
						<td align="left"> </td>
						<td align="left" colspan="3">
							<span id="payAmountButton">
								<?php echo $this->Html->link(__('Pay Amount'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn saveAmt','id'=>'saveAmt')); ?>
							</span>
							<span id="refundAmountButton" style="display:none;">
								<?php echo $this->Html->link(__('Refund Amount'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn refundAmt','id'=>'refundAmt')); ?>
							</span>
						</td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
		
	</table>
	<?php echo $this->Form->end(); ?>
</div>












































<!--  
<div style="padding-left: 20px; padding-top: 20px">
<?php echo $this->Form->create('Payment',array('id'=>'payment'))?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center;border: solid 1px black">
		<tr>
			<th class="table_cell" colspan="8" align="left">Customer Name : <?php 
			if(is_null($data[0]['PharmacySalesBill']['patient_id']))
				echo ucfirst($data[0]['PharmacySalesBill']['customer_name']);
			else
				echo ucfirst($data[0]['Patient']['lookup_name']);?></th>
		
		</tr>
		<tr class="row_title">
			<td class="table_cell" align="left"><?php echo  __('Total Amt.', true); ?>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Paid', true); ?> </strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Total Return', true); ?> </strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Total Discount', true); ?> </strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Total Refund', true); ?> </strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Balance', true); ?>
			</strong></td>
		</tr>
		
		<tr class="row_gray">
			<td class="table_cell" align="left"><?php echo $this->Number->currency($total = (double)$data[0][0]['total']); ?></td>
			<td class="table_cell" align="left"><?php echo $this->Number->currency((double)$paidAmt/* - (double) $data[0][0]['disc']*/); ?> </td>
			<td class="table_cell" align="left"><?php echo $this->Number->currency((double)$returnAmt); ?> </td>
			<td class="table_cell" align="left"><?php echo $this->Number->currency((double)$billDiscount); ?> </td>
			<td class="table_cell" align="left"><?php echo $this->Number->currency((double)$refundAmt); ?> </td>
			<td class="table_cell" align="left"><?php
			//echo $total - $paidAmt - $data[0][0]['disc'].' + '. (int)$returnAmt.' + '.$billDiscount.')';
			echo $this->Number->currency($balance = $total - ( (double)$paidAmt /*- (double) $data[0][0]['disc']*/ + (double) $returnAmt + (double) $billDiscount) + $refundAmt); ?></td>
		</tr>
		
		<tr>
			<td colspan="4">
			<table>
				<tr>
 			<td class="table_cell" align="left">
 				<?php echo __("Pay Amount:"); ?>
 			</td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Form->input('paid_amount',array('type'=>'text','id'=>'paid_amount','div'=>false,'label'=>false,'autocomplete'=>false));?>
 			</td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Form->hidden('total_amount',array('value'=>$total,'id'=>'total-Amount')); ?>
 			</td>
 		</tr>
 		<tr>
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
 				<strong><?php echo $this->Form->input('amount_pending',array('type'=>'text','id'=>'balance_amount','readonly'=>true,'value'=>(float)$balance,'div'=>false,'label'=>false,'autocomplete'=>false)); ?>
 			</td>
 			<td class="table_cell" align="left"></td>
 		</tr>
 		<?php if($this->Session->read('website.instance')!='kanpur'){?>
		<tr id='cardRow' >
		<td><?php echo 'Move From Card'?></td>
			<td style=" padding: 0px 0px 0px 2px;">
				<?php echo $this->Form->input('PharmacySalesBill.is_card',array('type'=>'checkbox',
						'div'=>false,'label'=>false,'id'=>'card_pay','style'=>'float:left;'));?>
						<span id="balance_card" style="display: none;"><b>Balance In Card : <font  color="green" id="cardBal">
				<?php echo !empty($patientCard['Account']['card_balance'])?$patientCard['Account']['card_balance']:'0';?>
			  </b></font></span></td>
			<td>
		</tr>
		<tr>
			<td colspan="3"> 
				<table  id="patientCard" style="display:none">
	   		    	<tr>
						<td style=" padding: 0px 0px 0px 2px;">
						  	<?php 
						  	if(empty($patientCard['Account']['card_balance'])){
						  		$payFromCard='0';
						  	}
						  	if($patientCard['Account']['card_balance']>=$totalCost){
						  		$payFromCard=$totalCost;
						  	}elseif($patientCard['Account']['card_balance']<=$totalCost){
								$payFromCard=$patientCard['Account']['card_balance'];
							}
							$payOtherMode=$totalCost-$payFromCard;
						  	echo 'Amount To Deduct From Card  '.$this->Form->input('PharmacySalesBill.patient_card',array('type'=>'text','legend'=>false,'label'=>false,'div'=>false,'value'=>$payFromCard,'id' => 'patient_card'));?></td>
					  </td>
					  </tr>
					  <tr>
					   <td style="vertical-align: top"><?php echo "<b>Pay By Cash : <font color='red'><span id='otherPay'>$payOtherMode</span></font></b>";?></td>
					</tr>   		    
	   		    </table>
   		   </td>
   	  </tr>
	<?php }?>
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
 			<td class="table_cell" align="left"></td>
 			<td class="table_cell" align="left">
 				<?php echo $this->Html->link(__('Pay Amount'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn saveAmt','id'=>'saveAmt')); ?>
 			</td>
 			<td class="table_cell" align="left"></td>
 		</tr>
			</table>
			</td>
 		</tr>
 	</table>
 		<?php echo $this->Form->end();?>
 </div>
 -->
 
 
 <script>
 var advanceAmount = parseFloat("<?php echo $paidAmt-$billAdv; ?>");
 	/*function display(){
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
	*/
	
	/*$("#discount").on('keyup',function()
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
	});*/

	/*$("#refund_amount").on('keyup',function(){
	   if( parseFloat($("#refund_amount").val()) > parseFloat($("#total-Amount").val()) ){
			alert("Refund amount is greater then total amount");
			$("#refund_amount").val('');
			$("#refund_amount").focus();
			display();
		}
		});
	*/
 	$("#saveAmt").click(function(){
 		var form_value = $("#payment").serialize();
 		//alert(form_value);
 		//return false;  
 		var patientId = '<?php echo $data[0]['Patient']['id']; ?>';
 		$.ajax({
 	 		type:'POST',
 			url: '<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'savePaymentFromPharmacy','inventory'=>false));?>'+"/"+patientId,
 			data: form_value,
 			beforeSend:function(data){
 				loading('content-list','id');
 			},
 			success:function(data){
 				$('#content-list').html(data);
				onCompleteRequest('content-list','id');
				window.location.href= "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "pharmacy_details" ,'sales','inventory'=>true));?>";
 			}
 		});
 	});

	$("#inputDiscount").keyup(function(){
		if(/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
	});
		
	$(".discountType").change(function(){
		var type = $(this).val();
		$("#inputDiscount").show();
		$("#inputDiscount").val('');
		$("#discAmt").text(parseInt($('#amount').val()));
		if($('#card_pay').is(":checked",true)){
			$("#patientCard").hide();
			$('#balance_card').hide();
			 $('#patientCardDetails').hide();
			 $("#card_pay").prop('checked',false);
		}
	});

	$("#inputDiscount").on('keyup',function()
	{
		if($('#card_pay').is(":checked",true)){
			$("#patientCard").hide();
			$('#balance_card').hide();
			 $('#patientCardDetails').hide();
			 $("#card_pay").prop('checked',false);
		}
		var disc='';
		$(".discountType").each(function () {  
	        if ($(this).prop('checked')) {
	           var type = this.value; 
	           var discount_value = parseFloat(($("#inputDiscount").val()!= '') ? $("#inputDiscount").val() : 0); //alert(discount_value);
	           if(type == "Percentage")
	            {
	            	if(discount_value > 101){
	        			alert("Percentage should be less than or equal to 100");
	        			$("#inputDiscount").val('');
	        			$("#inputDiscount").focus();
	        			//display();
	        		}else{
	        			var discount_value = ($("#inputDiscount").val()!= '') ? parseInt($("#inputDiscount").val()) : 0; //alert(discount_value);
		            	disc = parseFloat($('#amount').val()*discount_value)/100; //alert(disc);return false;
		        		}
	            }else if(type == "Amount"){
	            	if(discount_value > parseFloat($("#amount").val()) ){
	            		alert("Discount amount is greater then total amount");
	        			$("#inputDiscount").val('');
	        			$("#inputDiscount").focus();
	        			//display();
	            	}else{
	            		disc = ($("#inputDiscount").val() != '') ? parseFloat($("#inputDiscount").val()) : 0;
	            	}
	            }
	            	
	        }
	    });
           var afterdis=parseInt($('#amount').val())-disc;
		   $("#discAmt").text(afterdis.toFixed(2));
	});

	

 	$('#card_pay').click(function(){
		 var amtInCard="<?php echo $patientCardAmt['Account']['card_balance'];?>";
		 var chkpay= Math.round($('#amount').val());
		 var patientId = '<?php echo $data[0]['Patient']['id']; ?>';
		 
		 if($("#card_pay").is(":checked")){			 
		 	if(!chkpay || chkpay<='0'){
			     alert('Please Enter Amount');
			      $('#amount').focus();
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
				 if(data.Account.card_balance=='0' || isNaN(data.Account.card_balance)){				
					 alert("Insufficient Funds in Patient Card");
					 $("#card_pay").attr("checked",false);
					 $("#patientCard").hide();
					 $('#patientCardDetails').hide();
					 return false;
				 }
				 $('#balance_card').show();
				 $('#cardBal').text(data.Account.card_balance);
			 	 $('#patient_card').val(data.Account.card_balance);
			 	amtInCard=data.Account.card_balance;
				 var cardPay=amtInCard;
				 	var otherPay=0;
					if(parseInt(chkpay)<parseInt(cardPay)){
						otherPay=0;
					    $('#patient_card').val(parseInt(chkpay));
					}else{					
					   otherPay=parseInt(chkpay)-parseInt(cardPay);
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
		 var changeAmt=parseInt($(this).val()?$(this).val():0);
		 var otherPay=$('#otherPay').text();
		 if(parseInt(changeAmt)>parseInt(amtInCard)){
			 alert("Insufficient Funds in Patient Card");
			 $("#card_pay").attr("checked",false);
			 $('#patient_card').val('');
			 $("#patientCard").hide();
			 $("#patientCardDetails").hide();
		 }else{
			 var chkpay= Math.round($('#amount').val());
			 if(parseInt(changeAmt)>(parseInt(chkpay))){
				 alert("Amount Paid is greater");
				 $("#card_pay").attr("checked",false);
				 $('#patient_card').val('');
				 $("#patientCard").hide();
				 $("#patientCardDetails").hide();
				 return false;
			 }
			 
			 var otherPay=parseInt(chkpay)-parseInt(changeAmt);
			 if(parseInt(otherPay)<=0)
		     otherPay=0;	
			 $('#otherPay').text(otherPay); 
		 }
	});

	$("#isDiscount").change(function(){
		if($(this).is(":checked",true)){
			$("#showDiscRadio").show();
			$("#showDiscTextbox").show();
			 $("#patientCard").hide();
			 $('#patientCardDetails').hide();
			 $('#balance_card').hide();			 
			 $("#card_pay").prop('checked',false);
			 
		}else{
			$("#showDiscRadio").hide();
			$("#showDiscTextbox").hide();
			$("#inputDiscount").val('');
			$("#discount").val('');
			$("#discAmt").text($("#amount").val());
			$("#patientCard").hide();
			$('#balance_card').hide();
			 $('#patientCardDetails').hide();
			 $("#card_pay").prop('checked',false);
		}
	});

	$(document).on('click',".isCheck",function(){
		var amounTotal = 0;	var paid = 0;var amount = 0;
		var fieldno = $(this).attr('fieldno'); 
		if($(this).is(":checked",true)){
			$("#row_"+fieldno).addClass('selectedRow');
		}else{
			$("#row_"+fieldno).removeClass('selectedRow');
		}
		if($('.discountType').is(":checked",true)){
			$("#showDiscRadio").hide();
			$("#showDiscTextbox").hide();
			$("#inputDiscount").val('');
			$("#discount").val('');
			$('#isDiscount').prop('checked',false);
			$("#discAmt").text($("#amount").val());
		}
		if($('#card_pay').is(":checked",true)){
			$("#patientCard").hide();
			$('#balance_card').hide();
			 $('#patientCardDetails').hide();
			 $("#card_pay").prop('checked',false);
		}
		$(".isCheck").each(function(){ 
			if($(this).is(":checked",true)){
				id = $(this).attr('id').split("_")[1];
				amounTotal += parseFloat($('#amount_'+id).val()); 
				paid += parseFloat($('#paidAmt_'+id).val());
			} 
			
			var returnAmnt = ($('#return_amount').val());
			amount = amounTotal-returnAmnt;
			
		});
		if($("#isRefund").is(":checked",true)){
			$("#refund_amount").val(paid);
		}
		$("#amount").val(amount.toFixed());
		$("#discAmt").text(amount.toFixed());  
	});

	$(document).on('click',".checkMaster",function(){
		var amounTotal = 0;
		var paid = 0;
		var amount = 0;
		if($('.discountType').is(":checked",true)){
			$("#showDiscRadio").hide();
			$("#showDiscTextbox").hide();
			$("#inputDiscount").val('');
			$("#discount").val('');
			$('#isDiscount').prop('checked',false);
			$("#discAmt").text($("#amount").val());
		}
		if($('#card_pay').is(":checked",true)){
			$("#patientCard").hide();
			$('#balance_card').hide();
			 $('#patientCardDetails').hide();
			 $("#card_pay").prop('checked',false);
		}
		
		if($(this).is(":checked",true)){
			$(".isCheck").each(function(){
				var fieldno = $(this).attr('fieldno');
				if($(this).attr('disabled') != 'disabled'){
				 	$(this).prop('checked',true);
				 	$("#row_"+fieldno).addClass('selectedRow');
				 	id = $(this).attr('id').split("_")[1];
					amounTotal += parseFloat($('#amount_'+id).val());
					paid += parseFloat($('#paidAmt_'+id).val());
				}
				
				var returnAmnt = ($('#return_amount').val());
				amount = amounTotal-returnAmnt;
			});
		}else{
			$(".isCheck").each(function(){
				var fieldno = $(this).attr('fieldno');
				if($(this).attr('disabled') != 'disabled'){
					$(this).prop('checked',false); 
					$("#row_"+fieldno).removeClass('selectedRow');
				}
			});
		}
		if($("#isRefund").is(":checked",true)){
			$("#refund_amount").val(paid);
		}
		if(advanceAmount > amount){
			$("#amount").val('0');
			$("#discAmt").text(0);
			$("#advance").html(advanceAmount - amount);
		}else{
			$("#amount").val(amount);
			$("#discAmt").text(amount);
		}	
	});

	$("#isRefund").change(function(){
		$("#checkMaster").prop('checked',false);
		if($(this).is(":checked",true)){
			$(".isCheck").each(function(){
				var isPaid = $(this).attr('ispaid');
				var fieldno = $(this).attr('fieldno'); 
				if(isPaid == "yes"){
					$("#row_"+fieldno).removeClass('paid');
				 	$(this).prop('checked',false);
				 	$(this).prop('disabled',false); 
				}else{
					$("#row_"+fieldno).addClass('paid');
					$(this).prop('checked',false);
				 	$(this).prop('disabled',true);
				}
			});
			$("#discamount").hide();
			$("#amountPay").hide();
			$("#payAmountButton").hide();
			$("#refundAmountButton").show();
		}else{	//if uncheck refund checkbox
			$(".isCheck").each(function(){
				var isPaid = $(this).attr('ispaid');
				var fieldno = $(this).attr('fieldno');
				if(isPaid == "yes"){
					$("#row_"+fieldno).addClass('paid');
				 	$("#row_"+fieldno).removeClass('selectedRow');
				 	$(this).prop('checked',false);
				 	$(this).prop('disabled',true); 
				}else{
					$("#row_"+fieldno).removeClass('paid');
					$(this).prop('checked',false);
				 	$(this).prop('disabled',false);
				}
			});
			$("#payAmountButton").show();
			$("#refundAmountButton").hide();
			$("#checkMaster").prop('checked',false);
			$("#discamount").show();
			$("#amountPay").show();
			$("#refund_amount").val(0);
		}
	});

	$("#refundAmt").click(function(){
 		var form_value = $("#payment").serialize(); 
 		var patientId = '<?php echo $data[0]['Patient']['id']; ?>';
 		$.ajax({
 	 		type:'POST',
 			url: '<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'savePaymentFromPharmacy','inventory'=>false));?>'+"/"+patientId,
 			data: form_value,
 			beforeSend:function(data){
 				loading('content-list','id');
 			},
 			success:function(data){
 				$('#content-list').html(data);
				onCompleteRequest('content-list','id');
				window.location.href= "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "pharmacy_details" ,'sales','inventory'=>true));?>";
 			}
 		});
 	});

	$(document).on('input',".patient_card",function() { 
		if (/[^0-9]/g.test(this.value))
	    {
	    	this.value = this.value.replace(/[^0-9]/g,'');
	    }
	});
 </script>
