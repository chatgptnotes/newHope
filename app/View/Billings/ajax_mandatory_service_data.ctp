<?php 
$mServiceTotal=0;
$mServicePaid=0;
foreach($mandatoryServiceCharge as $MandatoryServiceCharge){
	if($MandatoryServiceCharge['Billing']['total_amount']>$mServiceTotal)$mServiceTotal=$MandatoryServiceCharge['Billing']['total_amount'];
	$mServicePaid=$mServicePaid+$MandatoryServiceCharge['Billing']['amount'];
}
?>

<table width="100%">
	<tr>
		<td style="padding-bottom: 10px" align="right"><?php 
		echo $this->Html->link('Report','#',
				array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
				$patientID,'?'=>array('flag'=>'MandatoryServices')))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
		?>
	</tr>
</table>
 
 
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	style="clear: both" class="tabularForm" id="mandatoryService">
	<tr>
		<th class="table_cell"></th>
		<th class="table_cell">Charges</th>
		<th class="table_cell">Total</th>
	</tr>

	<tr>
		<td class="tdBorderRt">Registration Charges</td>
		<td align="right" valign="top" class="tdBorderRt"><?php echo $registrationRate; ?>
			<?php //echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
		<td align="right" valign="top"><?php //echo $this->Number->currency($registrationRate);?> <?php echo $registrationRate; ?></td>
	</tr>

	<tr>
		<td class="tdBorderRt"><?php echo ($mandatoryData['TariffList']['name'])?($mandatoryData['TariffList']['name']):'Consultation Fee' ;?>
		<td align="right" valign="top" class="tdBorderRt"><?php echo $this->Number->format($doctorRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)); ?></td>
		<td align="right" valign="top" class="tdBorderRt"><?php echo $this->Number->format($doctorRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)); ?></td>
	</tr>

	<tr>
		<td colspan="2" valign="middle" align="right"><?php echo __('Total Amount');?> </td>
		<td valign="middle" style="text-align: right;"><?php $total=$registrationRate +$doctorRate;
		echo $this->Number->currency($total);?> </td>
	</tr>
</table>

<?php if(!empty($mandatoryServiceCharge)){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For Mandatory Services</strong></td>
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
		foreach($mandatoryServiceCharge as $mandatoryServiceCharge){ ?>
		<tr>
			<td align="right"><?php echo $totalpaid1=$mandatoryServiceCharge['Billing']['amount'];
			$totalpaid=$totalpaid+$totalpaid1;?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($mandatoryServiceCharge['Billing']['date'],Configure::read('date_format'),true);?></td>
			<!-- <td><?php echo $mandatoryServiceCharge['Billing']['reason_of_payment'];?></td> -->
			<td><?php echo $mandatoryServiceCharge['Billing']['mode_of_payment'];?></td>
			<td><?php 
			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				 $mandatoryServiceCharge['Billing']['id']))."', '_blank',
				 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?></td>
		</tr>
		<?php }?> 
		</table>
  	</td>
  	</tr>
  	<tr><td >&nbsp;</td></tr>
  	<!-- <tr>
	<td>
		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm">
		   <tbody>
				<tr>
					<td align="right" height="35" class="tdLabel2"><strong><?php echo __('Total Amount');?></strong></td>
					<td align="right" height="35" class="tdLabel2"><strong><?php echo __('Total Amount Received');?></strong></td>
					<td align="right" height="35" class="tdLabel2"><strong><?php echo __('Balance Amount');?></strong></td>
		        </tr>
		        <tr>
		            <td align="right" ><?php echo $mandatoryServiceCharge['Billing']['total_amount']; ?></td>
		            <td align="right" ><?php echo $totalpaid;?></td>
		            <td align="right" ><?php echo $pendingAmt=$mandatoryServiceCharge['Billing']['total_amount']-$totalpaid;?></td>
		        </tr>
		   </tbody>
		</table>	  			
	</td>
  	</tr> -->
</table>
<?php }?>
<script> 
$( '#paymentDetail', parent.document ).trigger('reset');
$( '#totalamount', parent.document ).val('<?php echo $total;?>');
$( '#totaladvancepaid', parent.document ).val('<?php echo $mServicePaid;?>');
$( '#totalamountpending', parent.document ).val('<?php echo $total-$mServicePaid;?>');
</script>
