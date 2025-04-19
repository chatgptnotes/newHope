
<div style="padding-left: 10px; padding-top: 10px">
<?php echo $this->Form->create('Return',array('id'=>'returnForm')); ?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align: center;border: solid 1px black">
		<tr> 
			<th class="table_cell" colspan="8" align="left">Customer Name : <?php 
				echo ucfirst($data[0]['PharmacySalesBill']['customer_name']);
			?></th>
		
		</tr>
		<tr class="row_title">
			<td class="" align="left"><?php echo __('Item Name', true); ?> </td>
			<td class="" align="left"><strong><?php echo __('SoldQty', true); ?> </strong></td>
			<td class="" align="left"><strong><?php echo __('Amount', true); ?> </strong></td>
			<td class="" align="left"><strong><?php echo __('ReturnQty', true); ?> </strong>	</td>
			<td class="" align="left"><strong><?php echo __('ReturnAmt.', true); ?> </strong></td>
			<td class="" align="left"><strong><?php echo __('ReturnNetAmt.', true); ?> </strong></td>
			<td class="" align="left"><strong><?php echo __('#'); ?> </strong></td>
		</tr>
		
		<?php $getPercentageForeachItem1=($data['0']['PharmacySalesBill']['discount']*100)/$data['0']['PharmacySalesBill']['total'];	
		$getPercentageForeachItem=$getPercentageForeachItem1;  ////BOF-Mahalaxmi for Percentge %	
		echo $this->Form->hidden('InventoryPharmacySalesReturn.discount',array('value'=>$getPercentageForeachItem,'id'=>'discount'));
		$count = 0;
		
		 foreach($data as $key=>$val){ $count++;  
			$class = $count%2==0 ? "row_gray" : ""; ?>
		<tr class="<?php echo $class; ?>">
			<td class=" " align="left">
				<?php echo $val['PharmacyItem']['name']; 
					echo $this->Form->hidden('',array('value'=>$val['PharmacySalesBillDetail']['item_id'],'name'=>"data[item_id][$key]")); 
				?> 
			</td>
			<td class=" " align="center">
				<?php
					$soldQty = $val['PharmacySalesBillDetail']['qty'];
					$retQty = $returnQty[$val['PharmacySalesBillDetail']['item_id']];
				    echo $qty = $soldQty - $retQty;
					//echo $qty = $val['PharmacySalesBillDetail']['qty']; 
					
					$pack = (int)$val['PharmacySalesBillDetail']['pack'];//debug($val['PharmacySalesBillDetail']['pack']);
					$qtyType = $val['PharmacySalesBillDetail']['qty_type'];
					$batch = $val['PharmacySalesBillDetail']['batch_number'];
					$expiry = $this->DateFormat->formatDate2Local($val['PharmacySalesBillDetail']['expiry_date'],Configure::read('date_format'));
					$pharmacyRateId = $val['PharmacyItemRate']['id'];
					echo $this->Form->hidden('test1',array('value'=>$qty,'id'=>'soldQty_'.$key,'name'=>"data[sold_qty][$key]"));
					echo $this->Form->hidden('test2',array('value'=>$qtyType,'id'=>'qtyType_'.$key,'name'=>"data[itemType][$key]"));
					echo $this->Form->hidden('test3',array('value'=>$pack,'id'=>'pack_'.$key,'name'=>"data[pack][$key]"));
					echo $this->Form->hidden('test4',array('value'=>$batch,'id'=>'batch_'.$key,'name'=>"data[batch_number][$key]"));
					echo $this->Form->hidden('test5',array('value'=>$expiry,'id'=>'expiry_'.$key,'name'=>"data[expiry_date][$key]"));
					echo $this->Form->hidden('test6',array('value'=>$pharmacyRateId,'id'=>'pharmacyItemId_'.$key,'name'=>"data[pharmacyItemId][$key]"));
					echo $this->Form->hidden('test7',array('value'=>$val['PharmacySalesBillDetail']['mrp'],'id'=>'mrpnew_'.$key,'name'=>"data[mrp][$key]")); //Only MRP Prize for per qountity
					$getPerForMrp=$val['PharmacySalesBillDetail']['mrp']*($getPercentageForeachItem/100);
					$getDeductedMrp=$val['PharmacySalesBillDetail']['mrp']-$getPerForMrp;
					echo $this->Form->hidden('test8',array('value'=>$val['PharmacySalesBillDetail']['mrp'],'id'=>'mrp_'.$key));
					echo $this->Form->hidden('test9',array('value'=>$getDeductedMrp,'id'=>'mrpDeductDiscount_'.$key));
					
					echo $this->Form->hidden('test10',array('value'=>$val['PharmacySalesBillDetail']['sale_price'],'id'=>'salePricenew_'.$key,'name'=>"data[rate][$key]"));  //Only Sale_prize Prize for per qountity
						
					$getPerForSalePrice=$val['PharmacySalesBillDetail']['sale_price']*($getPercentageForeachItem/100);
					$getDeductedSalePrice=$val['PharmacySalesBillDetail']['sale_price']-$getPerForSalePrice;					
					echo $this->Form->hidden('test11',array('value'=>$val['PharmacySalesBillDetail']['sale_price'],'id'=>'salePrice_'.$key));
					echo $this->Form->hidden('test12',array('value'=>$getDeductedSalePrice,'id'=>'salePriceDeductDiscount_'.$key));
				?> 
			</td>
			<?php 
				$pack = $val['PharmacySalesBillDetail']['pack'];
				if(!empty($val['PharmacySalesBillDetail']['sale_price'])) { 
					$price = $val['PharmacySalesBillDetail']['sale_price'] ;
				}else{
					$price = $val['PharmacySalesBillDetail']['mrp'] ;
				}
				if($qtyType == "Tab"){
					$amount = ($price / $pack) * $qty;
				}else{
					$amount = $price * $qty;
				}
				?>
			<td class=" " align="left"><?php echo number_format($amount,2); ?> </td>
			<td class=" " align="left"><?php echo $this->Form->input('test13',array('type'=>'text','div'=>false,'label'=>false,'id'=>'returnQty_'.$key,'class'=>'returnQty','name'=>"data[qty][$key]")); ?> </td>
			<td class=" " align="left"><?php echo $this->Form->input('test14',array('type'=>'text','div'=>false,'label'=>false,'id'=>'returnAmount_'.$key,'class'=>'returnAmount','readonly'=>true,'name'=>"data[return_amount][$key]")); ?> </td>
			<td class=" " align="left"><?php echo $this->Form->input('test15',array('type'=>'text','div'=>false,'label'=>false,'id'=>'returnAmountNet_'.$key,'class'=>'returnAmountNet','readonly'=>true,'name'=>"data[return_net_amount][$key]")); ?> </td>
		
			<td class=" " align="left"><?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?> </td>
		</tr>
 		<?php } ?>
 		<tr><td></td></tr>
 		<tr>
		<td align="left"><b><?php echo __("Payment Mode :");?></b><font color="red" >*</font></td>
		<td align="left"> <?php 
		 		echo $this->Form->input('InventoryPharmacySalesReturn.payment_mode', array('class' => 'validate[required]','style'=>'width:141px;', 'type'=>'select',
   					'div' => false,'label' => false,'autocomplete'=>'off','options'=>$mode_of_payment,$disabled,'value'=>"Cash",'id' => 'payment_mode')); ?> 
   		</td>
   		</tr>
 		<tr>
	 		<td colspan="3" align="left"><b>Total Return Amt. : </b><b id="showTotal"><?php //$data['0']['PharmacySalesBill']['total']
	 		echo number_format($totalBill,2);	 		
	 		 ?>	 		
 		</b> </td>
	 	</tr>
	 	<?php echo $this->Form->hidden('InventoryPharmacySalesReturn.total',array('id'=>'total'));
	 		?>
 		<tr>
	 		<td colspan="3" align="left"><b>Discount Reversal Amt. : </b><b id="showDisTotal"><?php echo number_format($totolDiscount,2);
	 		?></b></td>
	 	</tr>
 		<tr>
	 		<td colspan="3" align="left"><b>Net Return Amt. : </b><b id="showNetTotal"><?php echo number_format($totalNetBill,2);?></b> </td>
	 	</tr>
 		<tr>
	 		<td class=" " align="right" colspan="6">
	 			<?php echo $this->Html->link(__('Submit'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn saveAmt','id'=>'saveAmt')); ?>
	 		</td>
 		</tr>
 		<tr><td colspan="3">&nbsp;</td></tr>
 	</table>
 		<?php echo $this->Form->end();?>
 		
 <!-- Return List -->
 <?php if(count($returnData)>0){ $totalreturnAmt = 0; ?>
 
 <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align: center;border: solid 1px black">
		<tr> 
			<th class="table_cell" colspan="8" align="left"><b>Return List</b></th>
		
		</tr>
		<tr class="row_title">
			<td class="" align="left"><?php echo  __('Item Name', true); ?> </td>
			<td class="" align="left"><strong><?php echo __('Return Qty', true); ?> </strong></td>
			<td class="" align="left"><strong><?php echo  __('Amount', true); ?> </strong></td>
		</tr>
		
		<?php $count = 0; foreach($returnData as $key=>$val){ $count++; 
			$class = $count%2==0 ? "row_gray" : ""; ?>
		<tr class="<?php echo $class; ?>">
			<td class=" " align="left">
				<?php echo $val['PharmacyItem']['name']; ?> 
			</td>
			<td class=" " align="left" id="returnQty_<?php echo $val['InventoryPharmacySalesReturn']['pharmacy_sale_bill_id'];?>">
				<?php echo $qty = $val['InventoryPharmacySalesReturnsDetail']['qty'];
						   $qtyType = $val['InventoryPharmacySalesReturnsDetail']['qty_type']; 
						   $returnPack = $val['InventoryPharmacySalesReturnsDetail']['pack'];
						  ?> 
						   
			</td>
			<?php 
				if(!empty($val['InventoryPharmacySalesReturnsDetail']['sale_price'])) { 
					$price = $val['InventoryPharmacySalesReturnsDetail']['sale_price'] ;
				}else{
					$price = $val['InventoryPharmacySalesReturnsDetail']['mrp'] ;
				}
				
				if($qtyType == "Tab"){
					$amount = ($price / $returnPack) * $qty;
				}else{
					$amount = $price * $qty;
				}
				$totalreturnAmt += $amount;
				?>
			<td class=" " align="left"><?php echo number_format($amount,2); ?> </td>
		</tr>
 		<?php } ?>
 		<tr>
	 		<td colspan="2" align="left"><b>Total Returned : <?php echo number_format($totalreturnAmt,2);?></b></td>
	 		<td></td>
 		</tr>
 		
 		<tr>
	 		 <td colspan="2" ></td>
	 		<td class=" " align="right" style="float: right">
	 			<?php /*echo $this->Html->link(__('Print'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn print','id'=>'printButton',
	 					'onClick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','InventoryPharmacyDirectSalesReturnsDetail',$val['InventoryPharmacySalesReturn']['id'],'?'=>'flag=header'))."','_blank',
							'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')"));*/ ?>
							
							 <?php echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','InventoryPharmacyDirectSalesReturnsDetail',$val['InventoryPharmacySalesReturn']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print Without Header')); ?> 
							
			   <?php echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','InventoryPharmacyDirectSalesReturnsDetail',$val['InventoryPharmacySalesReturn']['id'],'?'=>'flag=header'))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print With Header')); ?>          	
	 		</td>
 		</tr>
 		<tr><td colspan="3">&nbsp;</td></tr>
 	</table>
 <?php } ?>
 </div>
 
 <script>
 	
 	$("#saveAmt").click(function(){ 
 		var form_value = $("#returnForm").serialize();  
 		
 		var Id = $(".returnQty").attr('id');
 		var ID = Id.split("_");
 		var returnVal = $("#returnQty_"+ID[1]).val();
 		var qty = $("#returnQty_").val();
 		var otherSaleBillId = '<?php echo $data[0]['PharmacySalesBill']['id']; ?>';
		var mode = $("#payment_mode").val();
		var notEmpty = false;
 		$('.returnQty').each(function() {  
		    if($(this).val() != '' ){ 
			    notEmpty = true; 
		    }
		});
		
 		if(notEmpty == false){
 	 		alert("Please Enter Quantity");
 			return false;
 		} 
 
 		if(otherSaleBillId!=""){
 			$("#saveAmt").hide();
 		}
 		
 		//return false;
 		$.ajax({
 	 		type:'POST',
 			url: '<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'savePharmacyDirectReturn','inventory'=>false));?>'+"/"+otherSaleBillId,
 			data: form_value,
 			beforeSend:function(data){
 				//loading('rightView_content','id');
 			},
 			success:function(data){
 				//$('#rightView_content').html(data);
				//onCompleteRequest('rightView_content','id');
			   var url='<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'inventory_print_view','InventoryPharmacyDirectSalesReturnsDetail'));?>'+"/"+data;
	            window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready
			    parent.window.location.reload();
				//window.location.href= "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "get_other_pharmacy_details" ,'sales','inventory'=>true));?>";
 			}
 		});
 	});

 	$(".returnQty").keyup(function(){ 	 
 		if (/[^0-9]/g.test(this.value)){ this.value = this.value.replace(/[^0-9]/g,'');  }
 		var returnQtyVal = $(this).val();
 		if(returnQtyVal == 0){$(this).val("");}
 	 	id = $(this).attr('id'); 
		splittedArr = id.split("_");

		var pack = parseInt($("#pack_"+splittedArr[1]).val());	 
		var qtyType = $("#qtyType_"+splittedArr[1]).val(); 
		var returnQty = $("#returnQty_").val();		
		var soldQty = parseInt($("#soldQty_"+splittedArr[1]).val());	
		var mrp = $("#mrp_"+splittedArr[1]).val()!="" ? $("#mrp_"+splittedArr[1]).val() : 0;		
		var salePrice = $("#salePrice_"+splittedArr[1]).val() ? $("#salePrice_"+splittedArr[1]).val() : 0;
		var price = parseFloat( salePrice != 0 ? salePrice : mrp );
		
		//*****BOF-Mahalaxmi for deduct discount amount********//
		var mrpDeducted = $("#mrpDeductDiscount_"+splittedArr[1]).val()!="" ? $("#mrpDeductDiscount_"+splittedArr[1]).val() : 0;		
		var salePriceDeducted = $("#salePriceDeductDiscount_"+splittedArr[1]).val() ? $("#salePriceDeductDiscount_"+splittedArr[1]).val() : 0;
		var priceDeducted = parseFloat( salePriceDeducted != 0 ? salePriceDeducted : mrpDeducted );
		var discountValue=0;
		//*****EOF-Mahalaxmi for deduct discount amount********//
		
		if(this.value > soldQty){
			alert('Return Quantity Is Greater Than Sold Quantity');
			$(this).val('');
			$(this).focus();
			$("#returnAmount_"+splittedArr[1]).val(''); 
			var sum = 0;
		    $('.returnAmount').each(function() { 
			    if(this.value!== undefined  && this.value != ''  ){
		        	sum += parseFloat(this.value);	       

		        }	      				        

		    });
			$("#showTotal").html(sum.toFixed(2)); 
			$("#showNetTotal").html(sum.toFixed(2)); 
			$("#total").val(sum.toFixed(2));
			return false;

		}else{  
			if(qtyType == "Tab"){				
				var amount = price / pack * $(this).val();		
				var amountNet = priceDeducted / pack * $(this).val();				
			}else{
				var amount = price * $(this).val();	
				var amountNet = priceDeducted * $(this).val();			
			}
			console.log(price+"price");
			console.log(priceDeducted+"denet");
			$("#returnAmount_"+splittedArr[1]).val(amount.toFixed(2));
			var sum = 0;			
		    $('.returnAmount').each(function() { 
			    if(this.value!== undefined  && this.value != ''  ){
				   sum += parseFloat(this.value);	
				  
		       }			        				        
		    });
			//*****BOF-Mahalaxmi for deduct discount amount********//
			
		 $("#returnAmountNet_"+splittedArr[1]).val(amountNet.toFixed(2));
		    var sumNet = 0;
		    $('.returnAmountNet').each(function() { 
			    if(this.value!== undefined  && this.value != ''  ){
				  	sumNet += parseFloat(this.value);	
				  
		        }			        				        
		    });
			$("#showNetTotal").html(sumNet.toFixed(2)); 
			discountValue=sum-sumNet;
			
			
			$("#showDisTotal").html(discountValue.toFixed(2)); 
						   
			//*****EOF-Mahalaxmi for deduct discount amount********//
			
			$("#showTotal").html(sum.toFixed(2));			
			$("#total").val(sum.toFixed(2));
		}
 	 });
 </script>
