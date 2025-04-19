<div class="inner_title">
	<h3>
		<?php echo __('Account Receivable-'.$patientData['Patient']['lookup_name'], true); ?>
	</h3>
</div> 
<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
<tr>
		<th width="100" align="center" valign="top" style="text-align: center; min-width: 100px;">Date</th>
		<th width="100" align="center" valign="top" style="text-align: center;">Ref No.</th>
		<th width="150" align="center" valign="top" style="text-align: center; min-width: 150px;">Party's Name</th>
		<th width="90" align="center"  valign="top"  style="text-align: center;">Voucher No.</th>
		<th width="125" align="center" valign="top" style="text-align: center;">Debit</th>
		<th width="125" align="center" valign="top" style="text-align: center;">Credit</th>
	</tr> 
	<?php 
	$bal=0;
	foreach($data as $key => $userData){
		$date=$this->DateFormat->formatDate2Local($datas['Billing']['date'],Configure::read('date_format'),true);?>
		<tr>
			<td align="center" valign="top" style="text-align: center;"><?php echo $date ?>
			</td>
			<td align="center" valign="top" style="text-align: center;"><i><?php echo $userData['User'][0]['full_name'] ?>
			</i></td>
			<td align="center" valign="top" style="text-align: center;"><?php  ?>
			</td>
			<td align="center" valign="top" style="text-align: center;"><?php echo $userData['User']['payment']; ?>
			</td>
			<td align="center" valign="top" style="text-align: center;"><?php   ?>
			</td>
			<td align="center" valign="top" style="text-align: center;"><?php ?></td>
		</tr>
	<?php 
		$bal=$bal+$datas['Billing']['amount'];
	}
	$total=0;
	foreach($getIpdServices as $amount){
		$total=$total+$amount['Icd10pcMaster']['charges'];
	}
	$current_bal=$total-$bal;
	?>
	<tr>
		<td colspan="4"></td>
		<td colspan="2">
			<table width="100%">
				<tr>
					<td style="text-align:right;"> Opening Balance:</td>
					<td style="text-align:left;"> <?php echo $this->Number->currency(ceil($total));?></td>
				</tr>
				<tr>
					<td style="text-align:right;" > Current Total:</td>
					<td style="text-align:left;" > <?php echo $this->Number->currency(ceil($current_bal));?></td>
				</tr>
				<tr>
					<td>
						<?php $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;')) ; ?>
					</td>
				</tr>
			</table>
		</td> 
	</tr> 
</table>