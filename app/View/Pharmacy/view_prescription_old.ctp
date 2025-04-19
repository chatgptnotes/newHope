<style>
@media print {
	#printButton {
		display: none;
	}
}

body {
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000;
}

.boxBorder {
	border: 1px solid #3E474A;
}

.boxBorderBot {
	border-bottom: 1px solid #3E474A;
}

.boxBorderRight {
	border-right: 1px solid #3E474A;
}

.tdBorderBt {
	border-bottom: 1px solid #3E474A;
}

.tdBorderTp {
	border-top: 1px solid #3E474A;
}

.tdBorderRt {
	border-right: 1px solid #3E474A;
}

.tdBorderTpBt { /* border-bottom: 1px solid #3E474A; */
	border-top: 1px solid #3E474A;
}

.tdBorderTpRt {
	border-top: 1px solid #3E474A;
	border-right: 1px solid #3E474A;
}

.columnPad {
	padding: 5px;
}

.columnLeftPad {
	padding-left: 5px;
}

.tbl {
	background: #CCCCCC;
}

.tbl td {
	background: #FFFFFF;
}

.totalPrice {
	font-size: 14px;
}

.itemName {
	padding-left: 75px;
	font-size: 13px;
}

.itemqty {
	padding-left: 65px;
	font-size: 13px;
}

.rx {
	vertical-align: bottom;
	height: 41px;
}
</style>
<html moznomarginboxes mozdisallowselectionprint>

<table width="100%" border="0" cellspacing="10" cellpadding="0"
	align="center">
	<tr>
		<td></td>
		<td align="right" id='printButton'><?php 
						echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();'));	?>
		</td>
	</tr>
	<?php while (!empty($phramacySalesData)) {?>
	<tr>
		<td valign="top">
			<table width="390" border="0" cellspacing="" cellpadding="0"
				align="center">
				<tr>
					<td width="20px" valign="top" class="heading"
						style="font-size: 19px;"><u><strong><?php echo 'Prescription'; ?>
						</strong> </u>
					</td>
					<td width="20px">
						<div style="float: right">
							<?php echo  " " ;?>
						</div>
					</td>
					<!-- <td width="20px"><div style="float: right">
							<?php //echo  $this->Html->image('hope-logo-sm.gif',array('width'=>120,'height'=>40)) ;?>
						</div>
					</td> -->
				</tr>
			</table>

			<table width="390" border="0" cellspacing="0" cellpadding="0"
				height="430px" align="center" class="">

				<tr align='center' height='28px'>
					<td width="100%" align="center" valign="top" class="boxBorderBot">
						<table width="100%" border="0" cellspacing="3px" cellpadding=" ">
							<tr>
								<td width="45%">Patient Name :</td>
								<td><?php echo $patientDetail['Patient']['lookup_name'];?>
								</td>
							</tr>
							<tr>
								<td>Registration Number :</td>
								<td><?php echo $patientDetail['Patient']['admission_id'];?></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td width="" height="" align="left" valign="top">
						<table width="100%" border="0" cellspacing="1">
							<?php $cnt = 0;$date= '';$saleId = ''; //debug($phramacySalesData); ?>
							<?php foreach ($phramacySalesData as $key=>$drugDetails) {
									$saleBillDate = $drugDetails[$model]['create_time'];
									if (isset($drugDetails['PharmacyItem']['generic'])) {
										$drugName = $drugDetails['PharmacyItem']['generic'];
									} else {
										$drugName = $drugDetails['PharmacyItem']['name'];
									}
								?>
							<?php
								
								if($model == "PharmacyDuplicateSalesBill"){
									$saleBillId = $drugDetails['PharmacyDuplicateSalesBillDetail']['pharmacy_duplicate_sales_bill_id'];
								}else{
									$saleBillId = $drugDetails['PharmacySalesBillDetail']['pharmacy_sales_bill_id'];
								}
							$billDate = $this->DateFormat->formatDate2Local($saleBillDate,Configure::read('date_format'),false);
							//debug($saleId."---".$saleBillId);
							if($saleId != '' && $saleId != $saleBillId || $cnt == 12) continue;?>
							<?php if($cnt == 0){?>
							<tr>
								<td align="left" class="rx"><span
									style="padding-left: 50px; font-size: 14px;">Rx</span></td>
								<td align="left"><span
									style="font-size: 14px;"> <?php echo 'Date : '.$billDate; ?>
								</span></td>
							</tr>
							<?php }?>
							<tr>
								<td class="itemName"><?php echo $drugName;?>
								</td>
								<td class="itemqty"><?php echo $drugDetails[$model.'Detail']['qty'];?>
								</td> 
							</tr>
							<?php $saleId = $saleBillId;?>
							<?php $cnt++;?>
							<?php unset($phramacySalesData[$key])?>
							<?php } ?>
						</table>
					</td>
				</tr>

				<tr>
					<td width="100%" align="left" valign="bottom">

						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="tdBorderTpBt">
							<!-- <tr>
								<td style="font-size: 12; padding-right: 69px;" height="20"
									align="left" valign="top"><strong>Physician Name</strong></td>
							</tr> -->
							<tr>
								<td valign="top" height="20" align="left"
									style="padding-right: 45px;"><strong><?php echo $patientDetail['0']['name'];?>
								</strong></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
		</td>

		<td valign="top">
			<table width="390" border="0" cellspacing="" cellpadding="0"
				align="center">
				<tr>
					<td width="20px" valign="top" class="heading"
						style="font-size: 19px;"><u><strong><?php echo 'Prescription'; ?>
						</strong> </u>
					</td>
					<td width="20px">
						<div style="float: right">
							<?php echo  " " ;?>
						</div>
					</td>
					<!--  <td width="20px"><div style="float: right">
							<?php //echo  $this->Html->image('hope-logo-sm.gif',array('width'=>120,'height'=>40)) ;?>
						</div>
					</td>-->
				</tr>
			</table>

			<table width="390" border="0" cellspacing="0" cellpadding="0"
				height="430px" align="center" class="">

				<tr align='center' height='8px'>
					<td width="100%" align="center" valign="top" class="boxBorderBot">
						<table width="100%" border="0" cellspacing="3px" cellpadding=" ">
							<tr>
								<td width="45%">Patient Name :</td>
								<td><?php echo $patientDetail['Patient']['lookup_name'];?>
								</td>
							</tr>
							<tr>
								<td>Registration Number :</td>
								<td><?php echo $patientDetail['Patient']['admission_id'];?></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td width="" height="" align="left" valign="top">
						<table width="100%" border="0" cellspacing="1">
							<?php $cnt = 0;$date= ''; $saleId = '';?>
							<?php foreach($phramacySalesData as $key=>$drugDetails){
									$saleBillDate = $drugDetails[$model]['create_time'];
									if (isset($drugDetails['PharmacyItem']['generic'])) {
										$drugName = $drugDetails['PharmacyItem']['generic'];
									} else {
										$drugName = $drugDetails['PharmacyItem']['name'];
									}
									
									if ($model == "PharmacyDuplicateSalesBill") {
										$saleBillId = $drugDetails['PharmacyDuplicateSalesBillDetail']['pharmacy_duplicate_sales_bill_id'];
									} else {
										$saleBillId = $drugDetails['PharmacySalesBillDetail']['pharmacy_sales_bill_id'];
									} 
							$billDate = $this->DateFormat->formatDate2Local($saleBillDate,Configure::read('date_format'),false);
							if($saleId != '' && $saleId != $saleBillId || $cnt == 12)continue;?>
							<?php if($cnt == 0){?>
							<tr>
								<td align="left" class="rx"><span
									style="padding-left: 50px; font-size: 14px;">Rx</span></td>
								<td align="left"><span
									style="font-size: 14px;"> <?php echo 'Date : '.$billDate; ?>
								</span></td>
							</tr>
							<?php }?>
							<tr>
								<td class="itemName"><?php echo $drugName;?>
								</td>
								<td class="itemqty"><?php echo $drugDetails[$model.'Detail']['qty'];?>
								</td>
							</tr>
							<?php $saleId = $saleBillId;?>
							<?php $cnt++;?>
							<?php unset($phramacySalesData[$key])?>
							<?php } ?>
						</table>
					</td>
				</tr>
				<tr>
					<td width="100%" align="left" valign="bottom">

						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="tdBorderTpBt">

							<!-- <tr>
								<td style="font-size: 12; padding-right: 69px;" height="20"
									align="right" valign="top"><strong>Physician Name</strong></td>
							</tr> -->
							<tr>
								<td valign="top" height="20" align="left"
									style="padding-right: 45px;"><strong><?php echo $patientDetail['0']['name'];?>
								</strong></td>
							</tr>

						</table>

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr style="height: 90px;">
		<td>&nbsp;</td>
	</tr>
	<?php }?>
	<?php /*?>
	<tr>
		<td valign="top">
			<table width="60%" border="0" cellspacing="0" cellpadding="0"
				align="center">
				<tr>
					<td width="" align="center" valign="top" class="heading"
						style="font-size: 19px;"><u><strong><?php echo 'Prescription'; ?>
						</strong> </u></td>
					<td><div style="float: right">
							<?php echo  $this->Html->image('hope-logo-sm.gif',array('width'=>120,'height'=>40)) ;?>
						</div></td>
				</tr>
			</table>

			<table width="60%" border="0" cellspacing="0" cellpadding="0"
				height="430px" align="center" class="boxBorder">

				<tr align='center' height='28px'>
					<td width="100%" align="center" valign="top" class="boxBorderBot">
						<table width="100%" border="0" cellspacing="3px" cellpadding=" ">
							<tr>
								<td width="40%">Patient Name :</td>
								<td><?php echo $patientDetail['Patient']['lookup_name'];?>
								</td>
							</tr>
							<tr>
								<td>Registration Number :</td>
								<td><?php echo $patientDetail['Patient']['admission_id'];?></td>
							</tr>

						</table>
					</td>
				</tr>

				<tr>
					<td width="" height="" align="left" valign="top">
						<table width="100%" border="0" cellspacing="1">
							<?php $cnt = 0;$date= '';?>
							<?php foreach($phramacySalesData as $key=>$drugDetails){?>
							<?php $billDate = $this->DateFormat->formatDate2Local($drugDetails[$model]['create_time'],Configure::read('date_format'),false);?>
							<?php if($date != '' && $date != $billDate || $cnt == 12)continue;?>
							<?php if($cnt == 0){?>
							<tr>
								<td align="left" class="rx"><span
									style="padding-left: 50px; font-size: 14px;">Rx</span></td>
								<td align="left"><span
									style="padding-left: 50px; font-size: 14px;"> <?php echo 'Date : '.$billDate; ?>
								</span></td>
							</tr>
							<?php }?>
							<tr>
								<td class="itemName"><?php echo $drugDetails['PharmacyItem']['name'];?>
								</td>
								<td class="itemqty"><?php echo $drugDetails[$model.'Detail']['qty'];?>
								</td>
							</tr>
							<?php $date = $billDate;?>
							<?php $cnt++;?>
							<?php unset($phramacySalesData[$key])?>
							<?php } ?>
						</table>
					</td>
				</tr>
				<tr>
					<td width="100%" align="left" valign="bottom">

						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="tdBorderTpBt">

							<tr>
								<td style="font-size: 12; padding-right: 69px;" height="20"
									align="right" valign="top"><strong>Physician Name</strong></td>
							</tr>
							<tr>
								<td valign="top" height="20" align="right"
									style="padding-right: 45px;"><strong><?php echo $patientDetail['0']['name'];?>
								</strong></td>
							</tr>

						</table>

					</td>
				</tr>
			</table>
		</td>

		<td valign="top">
			<table width="60%" border="0" cellspacing="0" cellpadding="0"
				align="center">
				<tr>
					<td width="" align="center" valign="top" class="heading"
						style="font-size: 19px;"><u><strong><?php echo 'Prescription'; ?>
						</strong> </u></td>
					<td><div style="float: right">
							<?php echo  $this->Html->image('hope-logo-sm.gif',array('width'=>120,'height'=>40)) ;?>
						</div></td>
				</tr>
			</table>

			<table width="60%" border="0" cellspacing="0" cellpadding="0"
				height="430px" align="center" class="boxBorder">

				<tr align='center' height='28px'>
					<td width="100%" align="center" valign="top" class="boxBorderBot">
						<table width="100%" border="0" cellspacing="3px" cellpadding=" ">
							<tr>
								<td width="40%">Patient Name :</td>
								<td><?php echo $patientDetail['Patient']['lookup_name'];?>
								</td>
							</tr>
							<tr>
								<td>Registration Number :</td>
								<td><?php echo $patientDetail['Patient']['admission_id'];?></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td width="" height="" align="left" valign="top">
						<table width="100%" border="0" cellspacing="1">
							<?php $cnt = 0;$date= '';?>
							<?php foreach($phramacySalesData as $key=>$drugDetails){?>
							<?php $billDate = $this->DateFormat->formatDate2Local($drugDetails[$model]['create_time'],Configure::read('date_format'),false);?>
							<?php if($date != '' && $date != $billDate || $cnt == 12)continue;?>
							<?php if($cnt == 0){?>
							<tr>
								<td align="left" class="rx"><span
									style="padding-left: 50px; font-size: 14px;">Rx</span></td>
								<td align="left"><span
									style="padding-left: 50px; font-size: 14px;"> <?php echo 'Date : '.$billDate; ?>
								</span></td>
							</tr>
							<?php }?>
							<tr>
								<td class="itemName"><?php echo $drugDetails['PharmacyItem']['name'];?>
								</td>
								<td class="itemqty"><?php echo $drugDetails[$model.'Detail']['qty'];?>
								</td>
							</tr>
							<?php $date = $billDate;?>
							<?php $cnt++;?>
							<?php unset($phramacySalesData[$key])?>
							<?php } ?>
						</table>
					</td>
				</tr>
				<tr>
					<td width="100%" align="left" valign="bottom">

						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="tdBorderTpBt">

							<tr>
								<td style="font-size: 12; padding-right: 69px;" height="20"
									align="right" valign="top"><strong>Physician Name</strong>
								</td>
							</tr>
							<tr>
								<td valign="top" height="20" align="right"
									style="padding-right: 45px;"><strong><?php echo $patientDetail['0']['name'];?>
								</strong></td>
							</tr>

						</table>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php */?>
</table>
<?php //debug($phramacySalesData);?>