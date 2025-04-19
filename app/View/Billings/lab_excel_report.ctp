<?php 
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"DetailLaboratoryReport.xls" );
header ("Content-Description: Generated Laboratory Report" );
ob_clean();
flush();
?>
<style>
.boxBorderBot {
	border-bottom: 1px solid #3E474A;
}

.boxBorder {
	border: 1px solid #3E474A;
	margin-top: 60px;
}

.tdBorderRtBt {
	border-right: 1px solid #3E474A;
	border-bottom: 1px solid #3E474A;
}

.tdBorderBt {
	border-bottom: 1px solid #3E474A;
}

.tdBorderOnlytop {
	border-top: 1px solid #3E474A;
}

.tdBorderTp {
	border-top: 1px solid #3E474A;
	border-right: 1px solid #3E474A;
}

.tdBorderRt {
	border-right: 1px solid #3E474A;
}

.tdBorderTpBt {
	border-bottom: 1px solid #3E474A;
	border-top: 1px solid #3E474A;
}

.tdBorderTpRt {
	border-top: 1px solid #3E474A;
	border-right: 1px solid #3E474A;
}
</style> 
<!-- <div align="center"><h3>LIST OF <?php echo strtoupper($groupFlag);?> TESTS</h3></div> -->
 <?php /* ?>
<div>

<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" class="boxBorder" >
  <tr>
    <td width="370" align="left" valign="top">Name Of Patient</td>
    <td width="10" valign="top">:</td>
    <td valign="top"><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'];
    if($patient['Patient']['vip_chk']=='1'){
		echo __("  ( VIP )");
	}
    ?></td>
  </tr>
  <?php if($patient['Person']['name_of_ip']!=''){?>
  <tr>
    <td align="left" valign="top">Name Of the I. P.</td>
    <td valign="top">:</td>
    <td valign="top"><?php //echo $patient['Patient']['lookup_name'];
			//echo $this->Form->input('Billing.name_of_ip',array('value'=>$person['Person']['name_of_ip'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'name_of_ip','style'=>'width:150px;'));
			echo $patient['Person']['name_of_ip'];
			?></td>
  </tr>
  <?php }?>
  <?php if($patient['Person']['relation_to_employee']!=''){?>
  <tr>
    <td align="left" valign="top">Relation with I. P.</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    //echo $this->Form->input('Billing.relation_to_employee',array('value'=>$person['Person']['relation_to_employee'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'relation_to_employee','style'=>'width:150px;'));
    $relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
    echo $relation[$patient['Person']['relation_to_employee']];
    ?></td>
  </tr>
  <?php }?>
   <tr>
    <td align="left" valign="top">Age/Sex</td>
    <td valign="top">:</td>
    <td valign="top"><?php //echo '<pre>'; print_r($patient['Person']);
    if(!empty($patient['Person']['dob'])){
		$date1 = new DateTime($patient['Person']['dob']);
		$date2 = new DateTime();
		$interval = $date1->diff($date2);
		$date1_explode = explode("-",$patient['Person']['dob']);
		$person_age_year =  $interval->y . " Year";
		$personn_age_month =  $interval->m . " Month";
		$person_age_day = $interval->d . " Day";
		if($person_age_year == 0 && $personn_age_month > 0){
			$age = $interval->m ;
			if($age==1){
				$age=$age . "M";
			}else{
				$age=$age . "M";
			}
		}else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day > -1){
			$age = $interval->d . " " + 1 ;
			if($age==1){
				$age=$age . "D";
			}else{
				$age=$age . "D";
			}
		}else{
			$age = $interval->y;
			if($age==1){
				$age=$age . "Y";
			}else{
				$age=$age . "Y";
			}
		}
	}
    	echo $age."/".ucfirst($patient['Person']['sex']);
    ?></td>
  </tr> 
  <?php //if($patient['Person']['plot_no']!='' || $patient['Person']['taluka']!='' || $patient['Person']['city']!='' || $patient['Person']['district']!=''){
    if(!empty($address)){?>
  <tr>
    <td align="left" valign="top">Address</td>
    <td valign="top">:</td>
    <td valign="top"> <?php echo $address ?></td>
  </tr>
  <?php }?>
  <?php if($patient['Person']['insurance_number']!='' || $patient['Person']['executive_emp_id_no']!='' || $patient['Person']['non_executive_emp_id_no']!=''){?>
  <tr>
    <td align="left" valign="top">Insurance Number/Staff Card No/Pensioner Card No.</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    if($patient['Person']['insurance_number']!=''){
    	echo $patient['Person']['insurance_number'];
    }elseif($patient['Person']['executive_emp_id_no']!=''){
    	echo $patient['Person']['executive_emp_id_no'];
    }elseif($patient['Person']['non_executive_emp_id_no']!=''){
    	echo $patient['Person']['non_executive_emp_id_no'];
    }
    ?></td>
  </tr>
  <?php }?>
  <?php if($patient['Patient']['date_of_referral']!=''){?>
  <tr>
    <td align="left" valign="top">Date of Referral</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    //$dateOfReferral = explode(" ",$patient['Patient']['date_of_referral']);
    if($patient['Patient']['date_of_referral']!='')
                   	  	  	echo $this->DateFormat->formatDate2Local($patient['Patient']['date_of_referral'],Configure::read('date_format'));
    ?></td>
  </tr>
  <?php }?>
  <?php if($patient['Patient']['form_received_on']!=''){?>
  <tr>
    <td align="left" valign="top">Date Of Registration</td>
    <td valign="top">:</td>
    <td valign="top"><?php $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
                   	  	  	echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></td>
  </tr>
  <?php }?>
  <?php if($finalBillingData['FinalBilling']['discharge_date']!=''){?>
   <tr>
    <td align="left" valign="top">Date Of <?php echo $dynamicText ;?></td>
    <td valign="top">:</td>
    <td valign="top"><?php
              
   if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
   	$splitDate = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
   	echo $this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true);
   }
   ?></td>
  </tr>
  <?php }?>
  <?php if($finalBillingData['FinalBilling']['patient_discharge_condition']!=''){?>
  <tr>
    <td align="left" valign="top">Condition of the patient on <?php echo $dynamicText ;?></td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    echo $finalBillingData['FinalBilling']['patient_discharge_condition'];
    ?></td>
  </tr>
  <?php }?>
  <?php if($invoiceMode!='direct'){?>
  <tr>
    <td align="left" valign="top">Invoice No.</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $billNumber;?></td>
  </tr>
  <?php }?>
  <?php if($patient['Patient']['admission_id']!=''){?>
  <tr>
    <td align="left" valign="top">Registration No.</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $patient['Patient']['admission_id'];?></td>
  </tr>
  <?php }?>
  <?php if($corporateEmp!=''){
  		$hideCGHSCol = '';
  		if(strtolower($corporateEmp) == 'private'){
  			$hideCGHSCol = 'none' ;
  		}?>
  <tr>
    <td align="left" valign="top">Category</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $tariffData[$patient['Patient']['tariff_standard_id']];?></td>
  </tr>
  <?php }?>
  <?php if($primaryConsultant[0]['fullname']!=''){?>
  <tr>
    <td align="left" valign="top">Primary Consultant</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $primaryConsultant[0]['fullname']; 
				?></td>
  </tr>
  <?php }?>
  <?php if($finalBillingData['FinalBilling']['credit_period']!=''){?>
  <tr>
    <td align="left" valign="top">Credit Period (in days)</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $finalBillingData['FinalBilling']['credit_period'];
   ?></td>
  </tr>
  <?php }?>
  <?php if($finalBillingData['FinalBilling']['other_consultant']!=''){?>
  <tr>
    <td align="left" valign="top">Other Consultant Name</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    echo $finalBillingData['FinalBilling']['other_consultant'];?></td>
  </tr>
  <?php }?>
 <?php if(!empty($finalBillingData['FinalBillingOption'])){
			$count = 0 ;
			foreach($finalBillingData['FinalBillingOption'] as $finalOptions){
				$newHtml  =	'<tr>';
				$newHtml .=  '<td align="left" valign="top">'.ucwords($finalOptions['name']).'</td>' ;
				$newHtml .=  '<td valign="top">:</td>';
				$newHtml .=  '<td valign="top">'; 
				$newHtml .=  ucwords($finalOptions['value']).'</td>';
			  	$newHtml .=  '</tr>';
				
				echo $newHtml  ;
				$count++ ;  
			}
	}?>
</table>
</div>
<?php */ ?>
<table width="800" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td ><table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" style="margin-top: 0px !important">
		<tr>
		  <td colspan="7" align="center" class="boxBorder"><b>HOPE MULTISPECIALITY HOSPITAL & RESEARCH CENTER</b></td>
		</tr>
		<tr> <?php if($groupFlag=='laboratory'){
			$brkUpText ="PATHOLOGY BREAK - UP";
		}else if($groupFlag=='radiology'){
			$brkUpText ="RADIOLOGY BREAK - UP";
		}else{
			$brkUpText = "BREAK - UP";
		}?>
		  <td colspan="7" align="center" class="boxBorder"><b><?php echo $patient['TariffStandard']['name']." ".$brkUpText;?>  </b></td>
		</tr>
		<tr>
		  <td colspan="7" align="center" class="boxBorder"><b>NAME OF PATIENT : <?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name']; ?></b></td>
		</tr>
		<tr>
		<?php $admissionDate = $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),false);
			  $dischargeDate = $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),false);
		?>
		 <td colspan="7" align="center" class="boxBorder"><b>FROM : <?php echo $admissionDate." TO ".$dischargeDate; ?></b></td>
		</tr>
		
</table></td>
  </tr>
  <tr>
 	 <td >
		<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" style="margin-top: 0px !important">
		<tr >
		  <td align="center" class="boxBorder"><b>Sr. No.</b></td>
		  <td align="center" class="boxBorder"><b>Date</b></td>
		  <td align="center" class="boxBorder"><b>Service Name</b></td>
		  <td align="center" class="boxBorder"><b>CGHS Code</b></td>
		  <td align="center" class="boxBorder"><b>CGHS Rate(Rs)</b></td>
		  <td align="center" class="boxBorder"><b>Qty</b></td>
		  <td align="center" class="boxBorder"><b>Amount</b></td>
		</tr>
		  <?php  
		  $nabhType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
		  if($labRate && $groupFlag=='laboratory'){
			$i=1;
			$Cost = 0 ; $t=0;
			  foreach($labRate as $labKey=>$labCost){
			  	if($labCost['LaboratoryTestOrder']['amount'] > 0){
			  		$Cost += $labCost['LaboratoryTestOrder']['amount']* $labCost['qty'] ;
			  		$formatLabCost = $labCost['LaboratoryTestOrder']['amount'] * $labCost['qty'];
			  	}else{
			  		$Cost += $labCost['TariffAmount'][$nabhType]* $labCost['qty'] ;
			  		$formatLabCost = $labCost['TariffAmount'][$nabhType] * $labCost['qty'] ;
			  	}
			  	?>
			  	<tr>
			  		<td align="center" valign="top" class="tdBorderTp"><?php echo $i++ ;?></td>
			  		<td class="tdBorderTp">&nbsp;&nbsp;<?php 
				  		$splitDateIn = explode(" ",$labCost['LaboratoryTestOrder']['start_date']);
				  		echo $this->DateFormat->formatDate2Local($labCost['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false); ?></td>
			  		<td class="tdBorderTp">&nbsp;&nbsp;<?php echo $labCost['Laboratory']['name'];?></td>
			  		<td align="center" valign="top" class="tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>"><?php echo $labCost['TariffList']['cghs_code'];?></td>
			  		<td align="center" valign="top" class="tdBorderTp" ><?php echo $this->Number->format($labCost['TariffAmount'][$nabhType]);?></td>
			  		<td align="center" valign="top" class="tdBorderTp"><?php echo $labCost['qty'];?></td>
			  		<td align="right" valign="top" class="tdBorderOnlytop"><?php echo $this->Number->format($formatLabCost);?></td>
			  	</tr>
		  	<?php } }?>
		  	
		  	<?php 
		  	if($radRate && $groupFlag=='radiology'){
				$j=1;
				$Cost = 0 ; $t=0; //echo '<pre>';print_r($radRate);
				foreach($radRate as $radKey=>$radCost){
					if($radCost['RadiologyTestOrder']['amount'] > 0){
						$Cost += $radCost['RadiologyTestOrder']['amount']* $radCost['qty'] ;
						$formatRadCost = $radCost['RadiologyTestOrder']['amount'] * $radCost['qty'];
					}else{
						$Cost += $radCost['TariffAmount'][$nabhType]* $radCost['qty'] ;
						$formatRadCost = $radCost['TariffAmount'][$nabhType] * $radCost['qty'] ;
					}?>
				<tr>
					<td align="center" valign="top" class="tdBorderTp"><?php echo $j++ ;?></td>
					<td class="tdBorderTp">&nbsp;&nbsp;<?php 
						$splitDateIn = explode(" ",$radCost['RadiologyTestOrder']['create_time']);
						echo $this->DateFormat->formatDate2Local($radCost['RadiologyTestOrder']['create_time'],Configure::read('date_format'),false);
						?>
					</td>
					<td class="tdBorderTp">&nbsp;&nbsp;<?php echo $radCost['Radiology']['name'];?></td>
					<td align="center" valign="top" class="tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>"><?php echo $radCost['TariffList']['cghs_code'];?></td>
					<td align="center" valign="top" class="tdBorderTp" ><?php echo $this->Number->format($radCost['TariffAmount'][$nabhType]);?></td>
					<td align="center" valign="top" class="tdBorderTp"><?php echo $radCost['qty'];?></td>
					<td align="right" valign="top" class="tdBorderOnlytop"><?php echo $this->Number->format($formatRadCost);?></td>
				</tr>
				<?php } }?>
		  	
		  	<tr>
		  	<td colspan="6" class="tdBorderTp" align="right"><strong>Sub Total</strong></td>
		  	<td class="tdBorderOnlytop" align="right"><strong><?php echo $Cost;?></strong></td>
		  	</tr>
		</table>
	 </td>
   </tr>
</table>
