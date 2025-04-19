<style>
#printBtn{
	float:right;
	padding:10px 40px 0px 0px;
}
.blueBtn {
    background: url("../img/submit-bg.gif") repeat-x scroll center center #B0C0C5;
    border: 1px solid #B0C0C5;
    border-radius: 4px;
    color: #000000;
    cursor: pointer;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 0;
    margin: 2px;
    padding: 3px 12px;
    text-decoration: none;
    text-shadow: 1px 1px 2px #E2E8EA;
}
</style>
<html>
<div id="printBtn" >
		<?php echo $this->Html->link('Print',"#",array('escape'=>true,'class'=>'blueBtn','onclick'=>'window.print();'))?>
	</div>
<h1 style="font-family:Arial">Patient Receipt</h1>
<div style='text-align: left;'>Appointment Date: <?php echo $this->DateFormat->formatDate2Local($getDiagnosis[0]['NoteDiagnosis']['start_dt'],Configure::read('date_format')); ?></div>
<div style='text-align: left; background-color: gray'>Provider
	Information</div>
<div>Provider Name: <?php echo $getPatientdetails['User']['last_name'].", ".$getPatientdetails['User']['first_name']?></div>
<div style='float: left; width: 30%'>Billing NPI:<?php echo rand(6,17);?></div>
<div style='float: left; width: 30%'>Place of Service Code:<?php echo rand(6,17);?></div>
<div style='float: left; width: 30%'>Office Phone:<?php echo $_SESSION['Auth']['User']['phone1'];?></div>
<div style='float: left; width: 30%'>Provider NPI:<?php echo rand(10,17);?></div>
<div style='width: 30%'>Email: <?php echo $_SESSION['email'];?></div>
<p>


<div style='text-align: left; background-color: gray'>Patient
	Information</div>
<div style='float: left; width: 50%'>Patient Name: <?php echo $getPatientdetails['Patient']['lookup_name']?></div>
<div style='float: left; width: 50%'>Patient Address: <?php echo $getPatientdetails['Person']['landmark'].",".$getPatientdetails['Person']['pin_code'];?></div>
<div style='float: left; width: 30%'>Date of Brith: <?php  echo$this->DateFormat->formatDate2Local($getPatientdetails['Person']['dob'],Configure::read('date_format'));?></div>
</p>
<br>

<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tr>
		<td width="5%" valign="middle" class="tdLabel" id="boxSpace"><strong>Diagnosis:</strong>
		</td>
	</tr>
	<?php if(!empty($getDiagnosis)){?>
	<tr style='background-color: gray'>
		<td width="5%" valign="middle" class="tdLabel" id="boxSpace">#</td>
		<td width="10%" valign="middle" class="tdLabel" id="boxSpace">Date of
			Visit</td>
		<td width="" valign="middle" class="tdLabel" id="boxSpace">Diagnosis
			Code</td>
	</tr>
	<?php  foreach($getDiagnosis as $key=>$getDiagnosiss){?>
	<tr>
		<td><?php echo $key+1;?>
		</td>
		<td><?php echo $this->DateFormat->formatDate2Local($getDiagnosiss['NoteDiagnosis']['start_dt'],Configure::read('date_format')); ?>
		</td>
		<td><?php echo $getDiagnosiss['NoteDiagnosis']['icd_id'].": ".$getDiagnosiss['NoteDiagnosis']['diagnoses_name']?>
		</td>
	</tr>
	<?php }}else{?>
	<td><?php echo __('No records Found')?>
		</td>
	<?php }?>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tr>
		<td width="5%" valign="middle" class="tdLabel" id="boxSpace"><strong>Treatment:</strong>
		</td>
	</tr>
	<?php if(!empty($getIpdServices)){?>
	<tr style='background-color: gray'>
		<td width="10%" valign="middle" class="tdLabel" id="boxSpace">Date of
			Visit</td>
		<td width="" valign="middle" class="tdLabel" id="boxSpace">Billing
			Code</td>
		<td width="" valign="middle" class="tdLabel" id="boxSpace">Modifier</td>
		<td width=""  align="right"  class="tdLabel" id="boxSpace">Diagnosis
			Pointer</td>
		<td width=""  align="right"  class="tdLabel" id="boxSpace"># Service</td>
		<td width=""  align="right"  class="tdLabel" id="boxSpace">@ Fee</td>
		<td width=""  align="right"  class="tdLabel" id="boxSpace">Discount</td>
		<td width="" align="right"  class="tdLabel" id="boxSpace">Total</td>

	</tr>
	<?php foreach($getIpdServices as $key=>$getIpdServices){?>
	<tr>
		<td width="10%" valign="middle" class="tdLabel" id="boxSpace"><?php echo $this->DateFormat->formatDate2Local($getIpdServices['ServiceBill']['date'],Configure::read('date_format')); ?>
		</td>
		<td width="" valign="middle" class="tdLabel" id="boxSpace"><?php echo $getIpdServices['Icd10pcMaster']['ICD10PCS'].": ".$getIpdServices['Icd10pcMaster']['ICD10PCS_FULL_DESCRIPTION']?>
		</td>
		<td width="" valign="middle" class="tdLabel" id="boxSpace"><?php echo '--';?>
		</td>
		<td width="" align="center" class="tdLabel" id="boxSpace"><?php echo  rand(5, 15);?>
		</td>
		<td width="" align="center" class="tdLabel" id="boxSpace"><?php echo '1.00';?>
		</td>
		<?php if(empty($getIpdServices['Icd10pcMaster']['charges'])){
			$charge='100';
		}else{
			$charge=$getIpdServices['Icd10pcMaster']['charges'];
			}?>
		<td width="" align="right" class="tdLabel" id="boxSpace"><?php echo $currency.$charge; ?>
		</td>
		<td width="" align="right" class="tdLabel" id="boxSpace"><?php echo $currency.'0.00';?>
		</td>
		<td width="" align="right" class="tdLabel" id="boxSpace"><?php echo $currency.$charge;?>
		</td><?php $totalCharge+=$charge;?>
	</tr>
	<?php }}else{?>
	<td ><?php echo __('No records found')?>
		</td>
	<?php }?>
</table>
<p>


<p>


<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tr>
		<td width="10%" valign="middle" class="tdLabel" id="boxSpace">Total
			Charges:<?php echo $currency.$totalCharge;?></td>
	</tr>
	<tr>
		<td width="" valign="middle" class="tdLabel" id="boxSpace">Total
			Discounts:<?php echo $currency.'0.00';?></td>
	</tr>
	<tr>
		<td width="" valign="middle" class="tdLabel" id="boxSpace">Total Paid:<?php echo $currency.'0.00';?></td>
	</tr>
	<tr>
		<td width="" valign="middle" class="tdLabel" id="boxSpace">Total Paid
			via Square:</td>
	</tr>
	<tr>
		<td width="" valign="middle" class="tdLabel" id="boxSpace">Patient
			Balance Due:</td>
	</tr>
	<tr>
		<td width="" valign="middle" class="tdLabel" id="boxSpace">Insurance
			Balance Due:</td>
	</tr>
	

</table>

</html>
