<?php  
$pharmacyTotal=0;
$pharmacyPaidCharge=0;
foreach($pharmacyPaid as $pharmacy_paid){
	if($pharmacy_paid['Billing']['total_amount']>$pharmacyTotal)$pharmacyTotal=$pharmacy_paid['Billing']['total_amount'];
	$pharmacyPaidCharge=$pharmacyPaidCharge+$pharmacy_paid['Billing']['amount'];
}
 
if(!empty($pharmacyCharges)){?>
<!-- <table width="100%">
	<tr>
	<?php //if($patient_details['Patient']['is_discharge']!=1){?>
		<td style="padding-bottom: 10px" align="right">
		 <?php  //echo $this->Html->link('Report','#',
			 	//	array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
			 	//			$patientID,'?'=>array('flag'=>'pharmacy')))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
		 ?></td>
	<?php //}?>
	</tr>
</table> -->
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="serviceGridPharmacy">
		<tr class="row_title">
			<!-- <th class="table_cell"><strong><?php echo __('Date'); ?></strong></th> -->
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<!-- <th class="table_cell"><strong><?php echo __('Rate'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Qty'); ?></strong></th> -->
			<th class="table_cell"><strong><?php echo __('Amount'); ?></strong></th>
			<?php //if($patient_details['Patient']['is_discharge']!=1 /*&& empty($labCharge)*/){?>
			<!-- <th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th> -->
			<?php //}?>
		</tr>
		<?php $totalAmt=0;
		/*$hospitalType = $this->Session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$nursingServiceCostType = 'nabh_charges';
		}else{
			$nursingServiceCostType = 'non_nabh_charges';
		}*/
		/*foreach($pharmacyCharges as $pharmacyCharges){
		
		$date=$this->DateFormat->formatDate2Local($pharmacyCharges['purchaseDate'],Configure::read('date_format'),true);
		$rate=$pharmacyCharges['rate']?$pharmacyCharges['rate']:1;
		$quantity=$pharmacyCharges['quantity']?$pharmacyCharges['quantity']:1;
		
		$amount=$rate*$quantity;
		$totalAmt=$totalAmt+$amount;*/
 ?>
		<!-- <tr class="row"  >
			<td valign="middle"> <?php //echo $this->DateFormat->formatDate2Local($pharmacyCharges['purchaseDate'],Configure::read('date_format'),true); ?></td>
			<td valign="middle"> <?php //echo $pharmacyCharges['itemName']; ?></td>
			<td valign="middle" style="text-align: right;"> <?php //echo $rate=$pharmacyCharges['rate']?$pharmacyCharges['rate']:1; ?></td>
			<td valign="middle" style="text-align: right;"><?php //echo $quantity=$pharmacyCharges['quantity']?$pharmacyCharges['quantity']:1;
			//echo $totalAmount1=$labData['TariffAmount'][$nursingServiceCostType];
			//echo $this->Number->format($totalAmount1,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
			//$totalAmt=$totalAmt+$totalAmount1;
			?>
			</td>
			
			<td valign="middle" style="text-align: right;"> 
				<?php //echo $amount=$rate*$quantity; 
				//$totalAmt=$totalAmt+$amount;?>
			</td>
			
		</tr> -->
		<?php //} 
		$totalAmt =  ceil($pharmacyCharges[0]['total']-$pharmacyReturnCharges[0]['sumTotal']) ; //by pankaj 
		
		?>
		
		<!-- <tr>
			<td colspan="4" valign="middle" align="right"><?php //echo __('Total Amount');?></td>
			<td valign="middle" style="text-align: right;"><?php //echo $this->Number->currency($totalAmt);?></td>
		</tr> -->
		<?php if($pharmacyCharges[0]['total']){?>
		<tr>
			<!-- <td valign="middle" ><?php //echo $date;?></td> -->
			<td valign="middle" ><?php echo __("Pharmacy Charges");?></td>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->format($pharmacyCharges[0]['total']);?></td>
		</tr> 
		<?php }
		if($pharmacyReturnCharges[0]['sumTotal']){
		?>
		<tr>
			<td valign="middle" ><?php echo __("Pharmacy Return Charges");?></td>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->format($pharmacyReturnCharges[0]['sumTotal']);?></td>
		</tr>
		<?php }?>
		
		<tr>
			<td valign="middle" align="right" ><?php echo __("Total");?></td>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->format($pharmacyCharges[0]['total']-$pharmacyReturnCharges[0]['sumTotal']);?></td>
		</tr>
</table>
  
<?php if(!empty($pharmacyPaid)){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For Pharmacy</strong></td>
  	</tr>
  	
  	<tr>
  	<td>
  		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm">
		<tr >
		 	<th >Deposit Amount</th>
            <th >Date/Time</th>
            <th >Mode of Payment</th>
            <th >Action</th>
		</tr>
		<?php  $totalpaid=0;
		foreach($pharmacyPaid as $pharmacyPaid){
			if($pharmacyPaid['Billing']['refund']=='1'){
				//echo $paidtopatient1=$pharmacyPaid['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$pharmacyPaid['Billing']['paid_to_patient'];
				continue;
			}else{
				if(!empty($pharmacyPaid['Billing']['discount'])){
					//echo $totalpaid1=$pharmacyPaid['Billing']['discount'];
					$totalpaid=$totalpaid+$pharmacyPaid['Billing']['discount'];
					$totalpaidDiscount=$totalpaidDiscount+$pharmacyPaid['Billing']['discount'];
					if(empty($pharmacyPaid['Billing']['amount']))
						continue;
				}
			} ?>
		<tr>
			<td align="right"><?php 
			if(!empty($pharmacyPaid['Billing']['amount'])){
				echo $totalpaid1=$pharmacyPaid['Billing']['amount'];
				$totalpaid=$totalpaid+$totalpaid1;
			}
			?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($pharmacyPaid['Billing']['date'],Configure::read('date_format'),true);?></td>
			<!-- <td><?php //echo $pharmacyPaid['Billing']['reason_of_payment'];?></td> -->
			<td><?php echo $pharmacyPaid['Billing']['mode_of_payment'];?></td>
			<td><?php 
			
			echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deletePharmacyRec',
					'id'=>'deletePharmacyRec_'.$pharmacyPaid['Billing']['id']),array('escape' => false));

			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				 $pharmacyPaid['Billing']['id']))."', '_blank',
				 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?></td>
		</tr>
		<?php }?> 
		</table>
  	</td>
  	</tr>
  	<tr><td >&nbsp;</td></tr>
  	 
</table>
<?php }?> 
<?php }?>
<script>
$( '#paymentDetail', parent.document ).trigger('reset');

$( '#totalamount', parent.document ).val('<?php echo $totalAmt;?>');
$( '#totaladvancepaid', parent.document ).val('<?php echo $pharmacyPaidCharge=/*$totalAmt+*/$pharmacyPaidCharge;?>');
$( '#totalamountpending', parent.document ).val('<?php echo $totalAmt-$pharmacyPaidCharge+$paidtopatient-$totalpaidDiscount;?>');
$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
$( '#maintainDiscount', parent.document ).val('<?php echo $totalpaidDiscount;?>');

//for deleting billing record
$('.deletePharmacyRec').click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];

	patient_id='<?php echo $patientID;?>';
	tariffStandardId='<?php echo $tariffStandardId;?>';
	
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
		  type : "POST",
		  //data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteBillingEntry", "admin" => false)); ?>"+"/"+recId,
		  context: document.body,
		  success: function(data){ 
			  parent.getPharmacyData(patient_id,tariffStandardId);
			  parent.getbillreceipt(patient_id);	
		  	  $("#busy-indicator").hide();				  
		  },
		  beforeSend:function(){$("#busy-indicator").show();},		  
		});
	}else{
		return false;
	}
});
</script>