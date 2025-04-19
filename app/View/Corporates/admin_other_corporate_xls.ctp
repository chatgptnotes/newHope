<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"other_corporate_report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Other Corpoarte Report" );
ob_clean();
flush();
?>

<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}

.top-header {
	background: #3e474a;
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea {
	width: 85px;
}
</style>

<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm top-header">
	<tr class='row_title'>
		<td colspan="13" width="100%" height='30px' align='center' valign='middle'>
			<h2>Outstanding Report -
				<?php echo $tariffData[$tariffStandardID];?>
			</h2>
		</td>
	</tr>
	
	<tr> 
		<thead> 
			<th width="2%"  align="center" style="text-align:center;">No.</th>
		<th width="10%"  align="center" style="text-align:center;">Name Of Patient</th>
		<th width="10%"  align="center" style="text-align:center;">Tariff</th>
		<th width="10%"  align="center" style="text-align: center;">MRN ID</th>
		<th width="10%"  align="center" style="text-align: center;">Date of Addmision</th> 
		<th width="10%"  align="center" style="text-align: center;">Date of Discharge</th>
		<th width="10%"  align="center" style="text-align: center;">No Of Days After Discharge</th>
		<th width="10%"  align="center" style="text-align: center;">Date of Bill Prepared</th>
		<th width="10%"  align="center" style="text-align: center;">Bill Prepared By</th>
		<th width="10%"  align="center" style="text-align: center;">Date of Bill Submission</th>
		<th width="10%"  align="center" style="text-align: center;">Bill Submitted By</th>
		<th width="10%"  align="center" style="text-align: center;">No Of Days After Submission</th>
		<th width="10%"  align="center" style="text-align: center;">Total Amount</th> 
		<th width="10%"  align="center" style="text-align: center;">Amount Paid By Patient</th> 
		<th width="10%"  align="center" style="text-align: center;">Amount Received</th>
		<th width="10%"  align="center" style="text-align: center;">Balance</th> 
		<th width="10%"  align="center" style="text-align: center;">Reason For Delay</th> 
		</thead>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm">
	<?php 
	echo $this->Form->hidden('patient_id_place_holder',array('id'=>'patient_id_place_holder')) ;
	$i=0;$val = 0;
	foreach($results as $result)
	{	


			$discDate = new DateTime($result['Patient']['discharge_date']);
			$currentDate = new DateTime();
			$noOfDaysAfterDischargeInterVal = $discDate->diff($currentDate);
        
        	$billSubmitDate = new DateTime($result['FinalBilling']['dr_claim_date']);
			$currentDate = new DateTime();
			$noOfDaysAfterBillSubmitInterVal = $billSubmitDate->diff($currentDate);     

		
		if($this->request->query['bill_options']=='not prepared'){
			$date1 = new DateTime($result['Patient']['discharge_date']);
			$date2 = new DateTime();
			$interval = $date1->diff($date2);
           
        }else if($this->request->query['bill_options']=='not submitted'){
        	$date1 = new DateTime($result['Patient']['discharge_date']);
			$date2 = new DateTime($result['FinalBilling']['bill_uploading_date']);
			$interval = $date1->diff($date2);            
        }

        
					$i++;
		$patient_id = $result['Patient']['id'];
		$bill_id = $result['FinalBilling']['id'];
		//holds the id of patient corpotateDiscount
		 
		$total_amount = $result[0]['total_amount']-$result[0]['patientPaid'];
		$advance_paid=$result[0]['advacnePAid'];//$result[0]['paid_amount'];
		$tds=$result[0]['TDSPAid'];
		$discount = $result[0]['total_discount'];
		$totalPaid = $advance_paid+ $tds+$discount ; 
		$color = '' ;
		$showEdit='';
		$showDelete='';
		$advacneCardPAid=$patientCardData[$result['Patient']['person_id']];
		
		if($total_amount == $totalPaid && $result[0]['total_amount']>'0'){
			$color = 'paid_payment';
			$showEdit='none';
			if($result['FinalBilling']['amount_pending']<='0')$showDelete='';
		}else{
			$showEdit='';
			$showDelete='none';
		}
		
		if($result['FinalBilling']['amount_pending']<='0'){
			$showSettlement='none';
		}else{
			$showSettlement='';
		}

		if($this->params->query['delay_in_bill_preparation'] == '7 Days'){
			if($noOfDaysAfterDischargeInterVal->days < 7 || $noOfDaysAfterDischargeInterVal->days > 15) continue; 
		}

		if($this->params->query['delay_in_bill_preparation'] == '15 Days'){
			if($noOfDaysAfterDischargeInterVal->days < 15 || $noOfDaysAfterDischargeInterVal->days > 30) continue; 
		}

		if($this->params->query['delay_in_bill_preparation'] == '1 Month'){
			if($noOfDaysAfterDischargeInterVal->days < 30 || $noOfDaysAfterDischargeInterVal->days > 90) continue; 
		}

		if($this->params->query['delay_in_bill_preparation'] == '3 Month'){
			if($noOfDaysAfterDischargeInterVal->days < 90 || $noOfDaysAfterDischargeInterVal->days > 365) continue; 
		}

		if($this->params->query['delay_in_bill_preparation'] == 'More Than 3 Months'){
			if($noOfDaysAfterDischargeInterVal->days < 90 ) continue; 
		}

		/**************************************************************************************/
		if($this->params->query['delay_in_receiving_payment'] == '15 Days'){
			if($noOfDaysAfterBillSubmitInterVal->days < 15 || $noOfDaysAfterBillSubmitInterVal->days > 30 || $result['FinalBilling']['dr_claim_date'] == '') continue; 
		}

		if($this->params->query['delay_in_receiving_payment'] == '1 Month'){
			if($noOfDaysAfterBillSubmitInterVal->days < 30 || $noOfDaysAfterBillSubmitInterVal->days > 90 || $result['FinalBilling']['dr_claim_date'] == '') continue; 
		}

		if($this->params->query['delay_in_receiving_payment'] == '3 Month'){
			if($noOfDaysAfterBillSubmitInterVal->days < 90 || $noOfDaysAfterBillSubmitInterVal->days > 180 || $result['FinalBilling']['dr_claim_date'] == '') continue; 
		}

		if($this->params->query['delay_in_receiving_payment'] == '6 Month' ){
			if($noOfDaysAfterBillSubmitInterVal->days < 180 || $noOfDaysAfterBillSubmitInterVal->days > 365 && $result['FinalBilling']['dr_claim_date'] == '') continue; 
		}

		if($this->params->query['delay_in_receiving_payment'] == 'More Than 1 Year' ){
			if($noOfDaysAfterBillSubmitInterVal->days < 365 || $result['FinalBilling']['dr_claim_date'] == '' ) continue; 
		}


		if($this->params->query['bill_status'] == 'bill_submitted'){
			if($result['FinalBilling']['dr_claim_date'] == '') continue;
		}

		if($this->params->query['bill_status'] == 'bill_not_submitted'){
			if($result['FinalBilling']['dr_claim_date'] != '') continue;
		}
		
		


		?>
	<tr >
		<td width="21px"  align="center" style="text-align:center;" class="<?php echo $color ;?>"> <?php  echo $i; ?> </td>
		
		<td width="89px"  align="center" style="text-align:center;" class="<?php echo $color ;?>"> <?php echo $result['Patient']['lookup_name'];  ?> </td> 

		<td width="89px"  align="center" style="text-align:center;" class="<?php echo $color ;?>"> <?php echo $result['TariffStandard']['name'];  ?> </td> 
		
		<!--<td  align="center" style=" text-align:center;" class="<?php echo $color ;?>"><?php echo $result['Patient']['patient_id'];?></td>-->
		
		<td  align="center" style=" text-align:center;" class="<?php echo $color ;?>"><?php echo $result['Patient']['admission_id'];?></td>
		
		<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); //date of admission	?>
		</td> 
		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php  echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); //date of discharge ?>
		</td>

		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php echo $noOfDaysAfterDischargeInterVal->days; ?>
		</td>
		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php  echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format')); //date of discharge ?>
		</td>

		<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php echo $result['User']['first_name']." ".$result['User']['last_name'] ;	?>
		</td> 

		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php  echo $this->DateFormat->formatDate2Local($result['FinalBilling']['dr_claim_date'],Configure::read('date_format')); //date of discharge ?>
		</td>

		<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php echo $result['UserAlias']['first_name']." ".$result['UserAlias']['last_name'] ;	?>
		</td> 

		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php echo $noOfDaysAfterBillSubmitInterVal->days; ?>
		</td>

		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"> 
			<?php 

			$totalBillAmount = ($result['FinalBilling']['hospital_invoice_amount']) ? $result['FinalBilling']['hospital_invoice_amount'] : $result[0]['total_amount'] ;
			echo $this->Form->hidden('cmp_amt_paid', array('id'=>'amt_'.$bill_id,'type' => 'text','style'=>"width:20%",'label'=>false ,
					'div'=>false,'style'=>"width: 70%;",'class'=>'cmp_amt_paid','value'=> $totalBillAmount/*$total_amount*/));
				  echo  $totalBillAmount;//$total_amount ;?>
		</td> 
		
		<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"> <?php echo $amntRecievedByPatient =$result[0]['patientPaid']; // Amount by patient ?> </td>
		
		<!--<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"> <?php echo $amntpending =$result['FinalBilling']['amount_pending']; // Hospital Invoice Amount  ?> </td>-->
		
		<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"> <?php echo $amntRecieved =$result[0]['advacnePAid']+$advacneCardPAid; // Amount received form card and billing  ?> </td>  
		
		<!-- <td width="85px"  align="center" style=" text-align:center;" class="<?php echo $color ;?>">  <?php   echo $tdsAmnt=$result[0]['TDSPAid']; //tds amountt  ?> </td>
		 
		<td class="<?php echo $color ;?>"><?php echo $otherDeduction=$result[0]['total_discount'] ; ?> </td> -->
		
		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"><?php echo $balAmount=$totalBillAmount-$amntRecievedByPatient-$tdsAmnt-$otherDeduction-$amntRecieved;//bal amount?></td> 

		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"><?php echo $result['FinalBilling']['reason_for_delay'] ; ?></td> 
		  
		
	</tr>
	<?php } ?>
</table>
<?php 
	function add_dates($cur_date,$no_days){		//to get the day by adding no of days from cur date
		$date = $cur_date;
		$date = strtotime($date);
		$date = strtotime("+$no_days day", $date);
		return date('Y-m-d', $date);
	}
?> 