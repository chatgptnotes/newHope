<?php 
$consultationTotal=0;
$consultationPaid=0;
foreach($consultationCharge as $consultation_charge){
	if($consultation_charge['Billing']['total_amount']>$consultationTotal)$consultationTotal=$consultation_charge['Billing']['total_amount'];
	$consultationPaid=$consultationPaid+$consultation_charge['Billing']['amount'];
	//$consultationPaid=$consultationPaid+$consultation_charge['Billing']['discount'];
}

if(!empty($consultantBillingData)){?>
<table width="100%">
	<tr>
		<td style="padding-bottom: 10px" align="right">
		<?php 
		if($isNursing!='yes'){
			echo $this->Html->link('Report','#',
				array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
				 	$patientID,'?'=>array('flag'=>'Consultant')))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
		}?>
		</td>
	</tr>
 </table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="serviceGrid">
		<tr>
			<th width="230"><?php echo __('Date');?></th>
			<th width="250"><?php echo __('Type');?></th>
			<th width="250" style=""><?php echo __('Name');?></th>
			<!-- <th width="250" style=""><?php echo __('Service Group/Sub Group');?></th> -->
			<th width="250" style=""><?php echo __('Service');?></th>
			<!-- <th width="250" style=""><?php echo __('Hospital Cost');?></th> -->
			<th width="80"><?php echo __('Amount');?></th>
			<?php if($isDischarge['is_discharge']!=1){?>
			<th width="80"><?php echo __('Action');?></th>
			<?php }?>
		</tr>
	<?php $totalAmt=0;
	foreach($consultantBillingData as $consultantData){?>
		<tr>
			<td valign="middle"><?php //echo $consultantData['ConsultantBilling']['date'] ;
			if(!empty($consultantData['ConsultantBilling']['date']))
			echo $this->DateFormat->formatDate2Local($consultantData['ConsultantBilling']['date'],Configure::read('date_format'),true);
			?></td>
			<td valign="middle"><?php 
			$totalAmount = $consultantData['ConsultantBilling']['amount'] + $totalAmount;
			if($consultantData['ConsultantBilling']['category_id']==0){
				echo 'External Consultant';
			}else if($consultantData['ConsultantBilling']['category_id'] ==1){
				echo 'Treating Consultant';
			}
			?></td>
			<td valign="middle" style="text-align: left;"><?php
			if($consultantData['ConsultantBilling']['category_id'] == 0){
				echo $allConsultantsList[$consultantData['ConsultantBilling']['consultant_id']];
			}else if($consultantData['ConsultantBilling']['category_id'] == 1){
				echo $allDoctorsList[$consultantData['ConsultantBilling']['doctor_id']];
			}
			?></td>

			<!-- <td valign="middle"><?php //echo $consultantData['ServiceCategory']['name']."/".$consultantData['ServiceSubCategory']['name'];?></td> -->
			
			<td valign="middle"><?php echo $consultantData['TariffList']['name'];?></td>
			<!-- <td valign="middle" style="text-align: center;">---</td> --> 

			<td valign="middle" style="text-align: right;"><?php echo $totalAmount1=$consultantData['ConsultantBilling']['amount'];
			$totalAmt=$totalAmt+$totalAmount1;
			?></td>
			<?php if($isDischarge['is_discharge']!=1){?>
			<td valign="middle" style="text-align: center;">
			<?php 
			if(empty($consultationCharge)){
				echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteConsultation',
						'id'=>'deleteConsultation_'.$consultantData['ConsultantBilling']['id']),array('escape' => false));
			}
			?>
			</td>
			<?php }?>
		</tr>
	<?php }?>
	<tr>
		<td colspan="4" valign="middle" align="right"><?php echo __('Total Amount');?></td>
		<td valign="middle" style="text-align: right;"><?php echo $totalAmount;?></td>
		<?php if($isDischarge['is_discharge']!=1){?>
		<td>&nbsp;</td>
		<?php }?>
	</tr>
</table>
<?php }?>

<?php if(!empty($consultationCharge) && $isNursing!='yes'){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For Consultant Visits</strong></td>
  	</tr>
  	
  	<tr>
  	<td>
  		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm">
		<tr >
		 	<th >Deposit Amount</th>
            <th >Date/Time</th>
            <th >Mode of Payment</th>
            <th >Action</th>
            <th >Print Receipt</th>
		</tr>
		<?php  $totalpaid=0;
			   $paidtopatient=0;
			   $totalpaidDiscount=0;
		foreach($consultationCharge as $consultationCharge){
			if($consultationCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$consultationCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$consultationCharge['Billing']['paid_to_patient'];
				continue;
			}else{
				if(!empty($consultationCharge['Billing']['discount'])){
					//echo $totalpaid1=$consultationCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$consultationCharge['Billing']['discount'];
					$totalpaidDiscount=$totalpaidDiscount+$consultationCharge['Billing']['discount'];
					if(empty($consultationCharge['Billing']['amount']))
						continue;
				} 
			}?>
		<tr>
			<td align="right"><?php 
			/*if($consultationCharge['Billing']['refund']=='1'){
				echo $paidtopatient1=$consultationCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$paidtopatient1;
			}else{*/
			/*	if(empty($consultationCharge['Billing']['amount']) && !empty($consultationCharge['Billing']['discount'])){
					echo $totalpaid1=$consultationCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$totalpaid1;
					$totalpaidDiscount=$totalpaidDiscount+$totalpaid1;
				}else*/if(!empty($consultationCharge['Billing']['amount'])){
					echo $totalpaid1=$consultationCharge['Billing']['amount']/*+$consultationCharge['Billing']['discount']*/;
					$totalpaid=$totalpaid+$totalpaid1;
				}
			//}?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($consultationCharge['Billing']['date'],Configure::read('date_format'),true);?></td>
			<!-- <td><?php echo $consultationCharge['Billing']['reason_of_payment'];?></td> -->
			<td><?php echo $consultationCharge['Billing']['mode_of_payment'];?></td>
			<td><?php 
			
			echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteConsultRec',
					'id'=>'deleteConsultRec_'.$consultationCharge['Billing']['id']),array('escape' => false));
			
			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				 $consultationCharge['Billing']['id']))."', '_blank',
				 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?></td>
			<td height="30px"><?php  
			if(!empty($consultationCharge['Billing']['tariff_list_id'])){
				echo $this->Html->link('Print Receipt','javascript:void(0)',
			 		array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
			 				$patientID,'?'=>array('flag'=>'Radiology','recID'=>$consultationCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			 }?></td>
		</tr>
		<?php }?> 
		</table>
  	</td>
  	</tr>
  	<tr><td >&nbsp;</td></tr>
  	 
</table>
<?php }?>

<script>
$( '#paymentDetail', parent.document ).trigger('reset');
$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
$( '#totaladvancepaid', parent.document ).val('<?php echo $consultationPaid=$consultationPaid/*+$totalpaidDiscount*/;?>');
$( '#totalamountpending', parent.document ).val('<?php echo $totalAmount+$paidtopatient-$consultationPaid-$totalpaidDiscount;?>');
$( '#maintainDiscount', parent.document ).val('<?php echo $totalpaidDiscount;?>');

$(".deleteConsultation").click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];
	patient_id='<?php echo $patientID;?>';
	tariff_standard_id='<?php echo $isDischarge['tariff_standard_id'];?>';
	
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteConsultantCharges", "admin" => false)); ?>"+"/"+recId+"/"+patient_id+'?Flag=consultaionBill',
			  context: document.body,
			  success: function(data){ 
					  parent.getConsultationData(patient_id,tariff_standard_id);
					  parent.getbillreceipt(patient_id);		
				  $("#busy-indicator").hide();			  
			  },
			  beforeSend:function(){$("#busy-indicator").show();},		  
		});
	}else{
		return false;
	}
});

$('.deleteConsultRec').click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];

	patient_id='<?php echo $patientID;?>';
	tariff_standard_id='<?php echo $isDischarge['tariff_standard_id'];?>';
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
		  type : "POST",
		  //data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteBillingEntry", "admin" => false)); ?>"+"/"+recId,
		  context: document.body,
		  success: function(data){ 
				  parent.getConsultationData(patient_id,tariff_standard_id);
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