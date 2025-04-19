
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center;border: solid 1px black">
		<tr>
			<th class="table_cell" colspan="8" align="left">Customer Name : <?php 
				echo ucfirst($salesBillArray[0]['Patient']['lookup_name']);
			?></th>
		
		</tr>
		<tr class="row_title">
			<td class="table_cell" align="left"><?php echo  __('Date.', true); ?></td>
			<td class="table_cell" align="left"><strong><?php echo __('Paid Amt', true); ?> </strong></td>
			<td class="table_cell" align="left"><strong><?php echo __('Discount', true); ?> </strong></td>
			<!--  <td class="table_cell" align="left"><strong><?php echo __('Refund', true); ?> </strong></td> -->
			<td class="table_cell" align="left"><strong><?php echo  __('Action', true); ?></strong></td>		
		</tr>
		<?php
		$cnt =0; $totalBill=0;
		if(count($salesBillArray) > 0) {
       foreach($salesBillArray as $sale):
       		$cnt++; 
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['OtPharmacySalesBill']['created_time'],Configure::read('date_format')); ?></td>
			<td class="row_format" align="left"><?php echo number_format($sale['OtPharmacySalesBill']['paid_amount'],2); ?></td>
			<td class="row_format" align="left"><?php echo number_format($sale['OtPharmacySalesBill']['discount'],2); ?></td>
			<!--  <td class="row_format" align="left"><?php echo number_format($sale['OtPharmacySalesBill']['paid_to_patient'],2); ?></td> -->
			<td class="row_format" align="left"><?php 
			
			//echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteOtRec',
					///'id'=>'deleteOtRec_'.$sale['Billing']['id']),array('escape' => false));

			/* echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printRefundReceipt',
				 $sale['Billing']['id'],'?'=>'flag=roman_header'))."', '_blank',
				 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;")); */

			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'OtPharmacy','action'=>'printRefundReceipt',
				$sale['OtPharmacySalesBill']['id'],'?'=>'flag=roman_header'))."', '_blank',
				 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?>
			</td>
			</tr>
		<?php $totalBill=$totalBill+$sale['OtPharmacySalesBill']['paid_amount'];
			  $totalDiscount = $totalDiscount + $sale['OtPharmacySalesBill']['discount']; 
			  //$totalCollected = $totalBill;
		endforeach;
		}
		?>
 		<tr>'
 		<td class="row_format" align="left"><b>Total</b></td>
 		<td class="row_format" align="left"><b><?php echo number_format($totalBill,2) ?></b></td>
 		<td class="row_format" align="left"><b><?php echo number_format($totalDiscount,2) ?></b> </td>
 		</tr>
 		</table>
 
<script>
//for deleting billing record
$('.deleteOtRec').click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];

	patient_id='<?php echo $patientID;?>';
	//tariffStandardId='<?php echo $tariffStandardId;?>';
	
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
		  type : "POST",
		  //data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteBillingEntry", "admin" => false)); ?>"+"/"+recId,
		  context: document.body,
		  success: function(data){ 
			  //parent.getPharmacyData(patient_id,tariffStandardId);
			  //parent.getbillreceipt(patient_id);	
		  	  $("#busy-indicator").hide();				  
		  },
		  beforeSend:function(){$("#busy-indicator").show();},		  
		});
	}else{
		return false;
	}
});
</script>
 