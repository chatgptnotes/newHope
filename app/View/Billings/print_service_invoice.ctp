<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" moznomarginboxes mozdisallowselectionprint> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true);?></title>
<style>

   @media print {
    #printButton {
      display: none;
    }
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
<?php echo $this->Html->css('internal_style.css');?> 
<?php echo $this->Html->script('jquery-1.5.1.min.js'); ;?>
</head>
<body style="background:none;width:98%;margin:auto;">
<table width="200" style="float:right">
	<tr>
		<td align="right">
		<div id="printButton"><?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();')); ?></div>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
</table>  



<div align="center" style="padding-top: 70px;"><h3>LIST OF <?php echo strtoupper($groupFlag);?> TESTS</h3></div>
 
<div>

<table width="800" border="0" cellspacing="0" cellpadding="5" class="boxBorder" >
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
                   	  	  	echo 
                   	  	  	$this->DateFormat->formatDate2Local($patient['Patient']['date_of_referral'],Configure::read('date_format'));
    ?></td>
  </tr>
  <?php }?>
  <?php if($patient['Patient']['form_received_on']!=''){?>
  <tr>
    <td align="left" valign="top">Date Of Registration</td>
    <td valign="top">:</td>
    <td valign="top"><?php $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
                   	  	  	echo 
                   	  	  	$this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></td>
  </tr>
  <?php }?>
  <?php if($finalBillingData['FinalBilling']['discharge_date']!=''){?>
   <tr>
    <td align="left" valign="top">Date Of <?php echo $dynamicText ;?></td>
    <td valign="top">:</td>
    <td valign="top"><?php
              
   if(isset($patient['Patient']['discharge_date']) && $patient['Patient']['discharge_date']!=''){
   	$splitDate = explode(" ",$patient['Patient']['discharge_date']);
   	echo $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),true);
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
  		}
  ?>
  <tr>
    <td align="left" valign="top">Category</td>
    <td valign="top">:</td>
    <td valign="top"><?php //echo $corporateEmp;
  		echo $tariffData[$patient['Patient']['tariff_standard_id']];?></td>
  </tr>
  <?php }?>
  <!-- 
  <tr>
    <td align="left" valign="top">Category Details</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;</td>
  </tr>
   -->
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
		
	}
	?>
</table>
</div>

<div>&nbsp;</div>

<table width="800" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td ><h3><?php echo ucfirst($groupFlag);?></h3></td>
  </tr>
  <tr>
 	 <td >
		<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" style="margin-top: 0px !important">
		<tr >
		  <th class="tdBorderRt">Sr. No.</th>
		  <th class="tdBorderRt ">Service Name</th>
		  <th class="tdBorderRt ">Date & Time</th>
		  <th class="tdBorderRt ">CGHS Code</th>
		  <th class="tdBorderRt ">Qty</th>
		  <th>Amount</th>
		</tr>
		  <?php  
		  
		  if($labRate && $groupFlag=='laboratory'){
			$i=1;
			$Cost = 0 ; $t=0;
			  foreach($labRate as $labKey=>$labCost){
			  	if($labCost['LaboratoryTestOrder']['amount'] > 0 ){
			  		$Cost += $labCost['LaboratoryTestOrder']['amount'] ;
			  	}else{
			  		$Cost += $labCost['TariffAmount'][$hosType] ;
			  	}
			  	?>
			  	<tr>
			  		<td align="center" valign="top" class="tdBorderTp"><?php echo $i++ ;?></td>
			  		<td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $labCost['Laboratory']['name'];?></td>
			  		<td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
				  		$splitDateIn = explode(" ",$labCost['LaboratoryTestOrder']['start_date']);
				  		echo $this->DateFormat->formatDate2Local($labCost['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true); ?></td>
			  		<td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>"><?php echo $labCost['TariffList']['cghs_code'];?></td>
			  		<td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
			  		<td align="right" valign="top" class="tdBorderOnlytop"><?php echo $this->Number->format($labCost['LaboratoryTestOrder']['amount']);?></td>
			  	</tr>
		  	<?php } }?>
		  	
		  	<?php 
		  	if($radRate && $groupFlag=='radiology'){
				$j=1;
				$Cost = 0 ; $t=0; //echo '<pre>';print_r($radRate);
				$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
				foreach($radRate as $radKey=>$radCost){
					if($radCost['RadiologyTestOrder']['amount'] > 0){
						$Cost += $radCost['RadiologyTestOrder']['amount'] ;
						$formatRadCost = $radCost['RadiologyTestOrder']['amount'] ;
					}else{
						$Cost += $radCost['TariffAmount'][$nabhType] ;
						$formatRadCost = $radCost['TariffAmount'][$nabhType] ;
					}?>
				<tr>
					<td align="center" valign="top" class="tdBorderTp"><?php echo $j++ ;?></td>
					<td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $radCost['Radiology']['name'];?></td>
					<td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
					//echo $radCost['RadiologyTestOrder']['create_time'];
					$splitDateIn = explode(" ",$radCost['RadiologyTestOrder']['create_time']);
					echo $this->DateFormat->formatDate2Local($radCost['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true);
						
					?></td>
					<td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>"><?php echo $radCost['TariffList']['cghs_code'];?></td>
					<td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
					<td align="right" valign="top" class="tdBorderOnlytop"><?php echo $this->Number->format($formatRadCost);?></td>
				</tr>
				<?php } }?>
		  	
		  	<tr>
		  	<td colspan="5" class="tdBorderRt tdBorderOnlytop" align="right"><strong>Sub Total</strong></td>
		  	<td class="tdBorderOnlytop" align="right"><strong><?php echo $Cost;?></strong></td>
		  	</tr>
		</table>
	 </td>
   </tr>
</table>

</body>
</html>                    
  
 