<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"DetailInvoiveReport.xls" );
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); 
		
$website=$this->Session->read("website.instance");
if($website=='kanpur')
{   $marginTop="0px";
	$paddingLeft="0px";
}else
{ 
	$marginTop="70px";
	$paddingLeft="30px";
}
?>
<?php //echo $this->Html->css('internal_style.css'); ?>
<style>
body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #000000;
}

.heading {
	font-weight: bold;
	padding-bottom: 10px;
	font-size: 19px;
	text-decoration: underline;
}

.headBorder {
	border: 1px solid #ccc;
	padding: 3px 0 15px 3px;
}

.title {
	font-size: 14px;
	text-decoration: underline;
	font-weight: bold;
	padding-bottom: 10px;
	color: #000;
}

input,textarea {
	border: 1px solid #999999;
	padding: 5px;
}

.tbl {
	background: #CCCCCC;
}

.tbl td {
	background: #FFFFFF;
}

.tbl .totalPrice {
	font-size: 14px;
}

.adPrice {
	border: 1px solid #CCCCCC;
	border-top: 0px;
	padding: 3px;
}

.
.tabularForm td {
	background: none;
}

@media print {
	#printButton {
		display: none;
	}
}

.page-break {
	page-break-after: always;
}

.inner_title {
	border-top: 1px solid #4C5E64;
	text-align: left;
	color: #000000;
	display: block;
	font-size: 20px;
	padding: 0;
}

.inner_title h3 {
	color: #000000;
	font-size: 16px;
	margin: 0;
	padding: 0;
	text-transform: capitalize;
}

.table_cell {
	color: #000;
	font-size: 13px;
	padding: 8px 5px;
	border-top: 1px solid #4C5E64;
	border-bottom: 1px solid #4C5E64;
}

h3 {
	color: #000000;
	font-size: 16px;
	margin: 0;
	padding: 20px 0px 10px 0px;
	text-align: left;
	text-transform: uppercase;
}

.print_form {
	background: none;
	font-color: black;
	color: #000000;
}

.formFull td {
	color: #000000;
}

.tabularForm {
	background: #000;
}

.tabularForm td {
	background: #ffffff;
	color: #333333;
	font-size: 13px;
	padding: 5px 8px;
}

body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

.boxBorder {
	border: 1px solid #3E474A;
	margin-top: 60px;
}

.boxBorderBot {
	border-bottom: 1px solid #3E474A;
}

.boxBorderRight {
	border-right: 1px solid #3E474A;
}

.tdBorderRtBt {
	border-right: 1px solid #3E474A;
	border-bottom: 1px solid #3E474A;
}

.tdBorderBt {
	border-bottom: 1px solid #3E474A;
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

.adPrice {
	border: 1px solid #CCCCCC;
	border-top: 0px;
	padding: 3px;
}
.tbl {
    background: none repeat scroll 0 0 #000 !important;
}
</style>
</head>
<!-- onload="javascript:window.print();" -->
<body class="print_form" >
<?php  		echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveGenerateReceipt','type' => 'file','id'=>'ConsultantBilling','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
			echo $this->Form->hidden('Billing.patient_id',array('value'=>$patient['Patient']['id']));
			echo $this->Form->hidden('Billing.bill_number',array('value'=>$billNumber)); 			
			?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="left" id="fullTbl" style="padding-left:3px <?php //echo $paddingLeft; ?>">
<tr>
<td>

		
<table width="800" border="0" cellspacing="0" cellpadding="0" margin-top:-34px;margin-bottom:-51px;
 style="margin-top:-34px<?php //echo $marginTop;?>;margin-bottom:-51px;" align="center">
<tr>
    <td width="100%" align="center" valign="top" class="heading" id="tblHead"><strong><?php echo 'DETAILED INVOICE REPORT'; ?></strong></td>
</tr>
</table>		
		
			
			
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" id="tblContent">
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
         <table width="800" border="0" cellspacing="0" cellpadding="5">
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
  		}
  ?>
  <tr>
    <td align="left" valign="top">Category</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
      if($patient['Patient']['corporate_sublocation_id']){
        $sublocationName = $subLocations[$patient['Patient']['corporate_sublocation_id']];
        echo $sublocationName;
      }else{
        echo $tariffData[$patient['Patient']['tariff_standard_id']];
      }
      ?>
    </td>
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
    </td>
  </tr>
  <?php 
  $hospitalType = $this->Session->read('hospitaltype');
   			if($hospitalType == 'NABH'){
   				$nabhKey = 'nabh_charges';
   				$nabhKeyC = 'cghs_nabh';
   			}else{
   				$nabhKey = 'non_nabh_charges';
   				$nabhKeyC = 'cghs_non_nabh';
   			}
  ?>
  <tr><td><table width="100%" cellpadding="5" cellspacing="0" border="0">
  <?php if($diagnosisData['Diagnosis']['final_diagnosis']!=''){?>
            	<tr>
                	<td valign="top">
                	Diagnosis<br />
                    <?php 
                    //echo $patient['Diagnosis']['final_diagnosis'];
                    echo $diagnosisData['Diagnosis']['final_diagnosis'];
                    ?>
                    </td>
                </tr>
   <?php }?>             
                <?php if(!empty($surgeriesData)){?>
                <tr>
                	<td valign="top">
                	Surgeries<br />
                    <?php 
                    $b=1;
                foreach($surgeriesData as $surg){
                    	if($b==1 && $surg['TariffList']['name']!=''){ 
                    		echo $b.'. '.$surg['TariffList']['name'];
                    		$b++;
                    	}
                    	else if($surg['TariffList']['name'] != ''){
                    		echo ', '.$b.'. '.$surg['TariffList']['name'];
                    		$b++;
                    	}
                    }
   
  ?>
                    </td>
                </tr>
          <?php }?>      
            </table></td></tr>
  
  <tr>
    <td width="100%" align="left" valign="top">
       <table width="100%" border="0" cellspacing="0" cellpadding="5" class="tdBorderTpBt">
          <tr>
          <td width="2%" align="center" class="tdBorderRtBt">Sr. No.</td>          
          <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>//MOA no. not required, removed as per disscussion with murali sir, w sir  --yashwant
          <td width="14%" align="center" class="tdBorderRtBt"><?php echo $patient['TariffStandards']['name'];?> MOA Sr. No.</td>
          <?php }*/?>          
            <td align="center" class="tdBorderRtBt" width="54%">Item</td>
            <td width="14%" align="center" class="tdBorderRtBt" style="display:<?php echo $hideCGHSCol ;?>">CGHS Code No.</td>
            <td width="14%" align="center" class="tdBorderRtBt">Rate</td>
            <td width="14%" align="center" class="tdBorderRtBt">Qty.</td>
            <td width="14%" align="center" class="tdBorderBt tdBorderRt">Amount</td>
          </tr>
          <?php $srNo=0;?>
          <?php if($patient['Patient']['payment_category']!='cash'){?>
          <tr>
            <td align="center" class="tdBorderRt">&nbsp;</td>
            <td class="tdBorderRt" style="font-size:12px;"><strong><i>Conservative Charges</i></strong><span id="firstConservativeText"></span></td>
            <td align="center" class="tdBorderRt">&nbsp;</td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRt">&nbsp;</td> 
            <!--  <td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>  -->
          </tr>
          
          <?php $lastSection='Conservative Charges';?>
          <?php }?>
          <?php if($registrationRate!='' && $registrationRate !=0){
          $srNo++;
          	?>
          <tr>
          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
          	
          	<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
          	<td align="center" class="tdBorderRt"><?php echo $registrationChargesData['TariffAmount']['moa_sr_no'];
          	echo $this->Form->hidden('',array('name'=>'data[Billing][0][moa_sr_no]','value' => $registrationChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
          	?></td>
          	<?php }*/?>
          	
            <td class="tdBorderRt">Registration Charges</td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            
            echo $registrationChargesData['TariffList']['cghs_code'];
            echo $this->Form->hidden('',array('name'=>'data[Billing][0][nabh_non_nabh]','value' => $registrationChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
            ?></td>
            <td align="right" valign="top" class="tdBorderRt">
            <?php echo $this->Form->hidden('',array('name'=>'data[Billing][0][unit]','value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
                // echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
                 echo $registrationRate;
            ?>
            </td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            echo $this->Form->hidden('',array('name'=>'data[Billing][0][name]','value' => 'Registration Charges','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;')); 
            #echo $this->Form->hidden('',array('name'=>'data[Billing][0][unit]','value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            echo $this->Form->hidden('',array('name'=>'data[Billing][0][rate]','value' => $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
             echo '--';
            ?></td>
            
            <td align="right" valign="top"><?php 
            echo $this->Form->hidden('',array('name'=>'data[Billing][0][amount]','value' => $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_amount','style'=>'text-align:right;'));
            //echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $registrationRate;
            ?></td>
          </tr>
          <?php }?>
          
           <?php $totalCost=0;$v=0;
          foreach ($cCArray as $cBilling){ 
	          foreach($cBilling as $consultantBillingDta){
	          	foreach($consultantBillingDta as $consultantBilling){
	          	$v++;$srNo++;
	          	#pr($consultantBilling);exit;
	          ?>
	          <tr>
	          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
	          	
	          	<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
	          	<td align="center" class="tdBorderRt">&nbsp;</td>
	          	<?php }*/?>
	          	
	            <td class="tdBorderRt"><?php //if($consultantBilling['ConsultantBilling']['category_id'] == 0){
	            	 
	          		echo $consultantBilling[0]['ServiceCategory']['name'];
	          		$completeConsultantName = $consultantBilling[0]['Initial']['name'].$consultantBilling[0]['Consultant']['first_name'].' '.$consultantBilling[0]['Consultant']['last_name'];
	            	echo '<br>&nbsp;&nbsp;<i>'.$completeConsultantName.'</i> ';
	            	$sDate = explode(" ",$consultantBilling[0]['ConsultantBilling']['date']);
	            	$lRec = end($consultantBilling);
	            	$eDate = explode(" ",$lRec['ConsultantBilling']['date']);
	            	if($patient['Patient']['admission_type']=='OPD'){
	   					echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).')';
	            	}else{
	            		echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($lRec['ConsultantBilling']['date'],Configure::read('date_format')).')';
	            	}
	            ?></td>
	            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $consultantBilling[0]['TariffList']['cghs_code'];?></td>
	            <td align="right" valign="top" class="tdBorderRt"><?php 
	            	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => count($consultantBilling),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
	            	//echo $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
	            	echo $consultantBilling[0]['ConsultantBilling']['amount'];
	            	?></td>
	            <td align="center" valign="top" class="tdBorderRt"><?php 
	            $totalCost = $totalCost + ($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling));
	            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
	            echo count($consultantBilling);
	            ?></td>
	            
	            <td align="right" valign="top"><?php 
	            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
	            //echo $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
	            echo $consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling);
	            ?></td>
	          </tr>
	            	
	          <?php }
          }
          
          }
          ?>
          
          
          <?php #pr($consultantBillingDataD);exit;
            //if($consultantBilling['ConsultantBilling']['category_id'] == 1){
          foreach ($cDArray as $cBilling){ 
           foreach($cBilling as $consultantBillingDta){#pr($consultantBilling);
           	foreach($consultantBillingDta as $consultantBilling){
           $v++;$srNo++;
           	?>
           <tr>
           <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
           
           <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
           <td align="center" class="tdBorderRt">&nbsp;</td>
           <?php }*/?>
           
            <td class="tdBorderRt">
            <?php 
           		 
            	echo $consultantBilling[0]['ServiceCategory']['name'];
            	$completeDoctorName = $consultantBilling[0]['Initial']['name'].$consultantBilling[0]['DoctorProfile']['doctor_name'] ;
            	echo '<br>&nbsp;&nbsp;<i>'.$completeDoctorName.'</i> ';
            	$sDate = explode(" ",$consultantBilling[0]['ConsultantBilling']['date']);
            	$lRec = end($consultantBilling);
            	$eDate = explode(" ",$lRec['ConsultantBilling']['date']);
            	if($patient['Patient']['admission_type']=='OPD'){
   					echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).')';
            	}else{
            		echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($lRec['ConsultantBilling']['date'],Configure::read('date_format')).')';
            	}
   	 
            ?></td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $consultantBilling[0]['TariffList']['cghs_code'];?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => count($consultantBilling),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
            	//echo $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            	echo $consultantBilling[0]['ConsultantBilling']['amount'];
            	?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            $totalCost = $totalCost + ($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
            echo count($consultantBilling);
            
            ?></td>
            
            <td align="right" valign="top"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
            //echo $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling);
            ?></td>
          </tr>
          <?php }
          }
          }
          ?>
          <?php //} for end
		  $totalCost = $totalCost+$pharmacy_charges/*-$pharmacyPaidAmount*/;//+$ward_charges;// paid charges should not be deleted.....
		  ?>
		  
		  
		  <!-- 
		  <tr>
            <td class="tdBorderRt">Bed Charges</td>
            <td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
            <td valign="top" align="right" class="tdBorderRt">&nbsp;</td>
            <td align="right" valign="top">&nbsp;</td>
          </tr>
          -->
          <?php if($patient['Patient']['admission_type']=='IPD'){
          $totalWardNewCost=0;
          $totalWardDays=0;
          $totalNewWardCharges=0;
          if(is_array($wardServicesDataNew)){
          foreach($wardServicesDataNew as $uniqueSlot){
          	$srNo++;
          		if(isset($uniqueSlot['name'])){
					$totalWardNewCost = $totalWardNewCost + $uniqueSlot['cost'];
					$v++;
					$lastSection = 'Conservative Charges';
				?>
				<?php if($patient['Patient']['payment_category']!='cash' && $uniqueSlot['validity']> 1 ){
					$lastSection = '';
					?>	
					<tr>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					
					<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<?php }*/?>
					
		            <td class="tdBorderRt" style="font-size:12px;"><i><strong>Surgical Charges</strong> </i>
		            	<?php  
		            		$endOfSurgery = strtotime($uniqueSlot['surgery_billing_date']." +".$uniqueSlot['validity']." days");
		            		$startOfSurgery  = $this->DateFormat->formatDate2Local($uniqueSlot['start'],Configure::read('date_format')) ;
		            		echo $surgeryDate = "<i>(".$startOfSurgery."-".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$endOfSurgery),Configure::read('date_format')).")</i>";?>
		           
		            
		            
		            </td>
		            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
		            <td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
		            <td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
		            
		            <td align="right" valign="top">&nbsp;</td>
		          	</tr> 
	          		<?php $v++; 
				 }
				 //if surgery is package
				 	if($uniqueSlot['validity']> 1){
				 		
				 ?>
		          	<tr>
			          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
			          	
			          	<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
			          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['moa_sr_no'];?></td>
			          	<?php }*/?>
			          	
			            <td class="tdBorderRt" style="padding-left:10px;"><?php  
				            echo $uniqueSlot['name'];
				            //echo '(<i>'.$uniqueSlot['doctor'].'</i>)';
				           		      
				            $splitDate = explode(" ",$uniqueSlot['start']);
				   			echo "<br><i>(".$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true)."-".
				   			$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['end'],Configure::read('date_format'),true).")</i>";
				   		
				            ?>
			            </td>
			            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php //echo $uniqueSlot['cghs_code'];?></td>
			            <td align="right" valign="top" class="tdBorderRt"><?php 
			            //echo '1';
			        
			            echo $uniqueSlot['cost'];
			            ?></td>
			            <td align="center" valign="top" class="tdBorderRt"><?php 
			            //echo $uniqueSlot['cost'];
			        
			            echo '1';
			            ?></td>
			            
			            <td align="right" valign="top"><?php 
			            //echo $uniqueSlot['cost'];
			        
			            echo $uniqueSlot['cost'];
			            $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost'];
			            ?></td>
		          	</tr>	
		          	
				<?php }else{    ?>
					<tr>
		          	<td valign="top" align="center" class="tdBorderRt"><?php echo $srNo;?></td>
		          	
		          	<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
		          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['moa_sr_no'];?></td>
		          	<?php }*/?>
		          	
		            <td class="tdBorderRt" style="padding-left:10px;"><?php 
			            echo $uniqueSlot['name'].'('.$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true).')</br>'; 
			            echo '&nbsp;&nbsp;&nbsp;&nbsp;Surgery Charges' ;
			            
			            /** gaurav OT Rule Charges*/
			            if($uniqueSlot['doctor']){
			            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges' ;
			            	echo '<i> ('.rtrim($uniqueSlot['doctor'].','.$uniqueSlot['doctor_education'],',').')</i>';
			            }
			            if($uniqueSlot['asst_surgeon_one']){
			            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon I Charges' ;
			            	echo '<i> ('.rtrim($uniqueSlot['asst_surgeon_one'],',').')</i>';
			            }
			            if($uniqueSlot['asst_surgeon_two']){
			            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon II Charges' ;
			            	echo '<i> ('.rtrim($uniqueSlot['asst_surgeon_two'],',').')</i>';
			            }
			            //anaesthesia charges
			            echo ($uniqueSlot['anaesthesist'])?'<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges':'' ;
			            echo ($uniqueSlot['anaesthesist'])?'<i> ('.rtrim($uniqueSlot['anaesthesist'],',').')</i>':'';
			            
			            if($uniqueSlot['cardiologist']){
			            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Cardiology Charges' ;
			            	echo '<i> ('.$uniqueSlot['cardiologist'].')</i>';
			            }
			            if($uniqueSlot['ot_assistant']){
			            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;OT Assistant Charges' ;
			            }
			            /** EOF gaurav*/
			            if(!empty($uniqueSlot['ot_charges'])){
						echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;OT Charges';
						}
						if($uniqueSlot['extra_hour_charge'] != 0){
							echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;Extra OT Charges ';
						}
						if($this->Session->read('website.instance') == 'kanpur'){
							foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
								echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;'.$name;
							}
						}
			            //EOF anaesthesia charges
			            $splitDate = explode(" ",$uniqueSlot['start']);
			            if($uniqueSlot['anaesthesist_cost']){
			            	$valueForAnaesthesist = '<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges<i> ('.$uniqueSlot['anaesthesist'].')</i>';
			            }else{
			            	$valueForAnaesthesist ='' ;
			            }
			   			$valueForSurgeon =  $uniqueSlot['name'].'('.
			   								$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true).')</br>'.
			   								'&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges <i>('.$uniqueSlot['doctor'].','.
			   								$uniqueSlot['doctor_education'].')</i>)'.$valueForAnaesthesist ;
			   			
			            
			         
		            ?></td>
		            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $uniqueSlot['cghs_code'];?></td>
		            <td align="right" valign="top" class="tdBorderRt"><?php 
					if($uniqueSlot['anaesthesist_cost']){
		            	
		            	$anaeCost = "<br>".$uniqueSlot['anaesthesist_cost'] ;
		            	$anaeUnit = "<br>1" ;
		            }
		            
			            echo "<br>".$uniqueSlot['cost'];
		            echo (!empty($uniqueSlot['doctor']))?"<br>".$uniqueSlot['surgeon_cost']:'';
		            echo (!empty($uniqueSlot['asst_surgeon_one'])) ? "<br>".$uniqueSlot['asst_surgeon_one_charge']:'';
		            echo (!empty($uniqueSlot['asst_surgeon_two'])) ? "<br>".$uniqueSlot['asst_surgeon_two_charge']:'';
		            echo (!empty($uniqueSlot['anaesthesist'])) ? "<br>".$uniqueSlot['anaesthesist_cost'] : '';
		            echo (!empty($uniqueSlot['cardiologist'])) ? "<br>".$uniqueSlot['cardiologist_charge'] : '';
		            echo (!empty($uniqueSlot['ot_assistant'])) ? "<br>".$uniqueSlot['ot_assistant'] : '';
		            if(!empty($uniqueSlot['ot_charges'])){
						echo "<br>".$uniqueSlot['ot_charges'];
					}
					if($uniqueSlot['extra_hour_charge'] != 0){
						$units = (strtolower($uniqueSlot['operationType']) == 'major') ? $uniqueSlot['extra_hour_charge']/2000 : $uniqueSlot['extra_hour_charge']/1000;
						echo "<br>".($uniqueSlot['extra_hour_charge']/$units);
					}
					if($this->Session->read('website.instance') == 'kanpur'){
						foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
							echo '<br>'.$charge;
						}
					}
		            ?></td>
		            <td align="center" valign="top" class="tdBorderRt"><?php 
		            	$surgonCost = "<br>".$uniqueSlot['cost'].$anaeCost ;
		            
		            echo '<br>1';
		            echo ($uniqueSlot['doctor'])?'<br>1':'';
		            echo ($uniqueSlot['asst_surgeon_one'])?'<br>1':'';
		            echo ($uniqueSlot['asst_surgeon_two'])?'<br>1':'';
		            echo ($uniqueSlot['anaesthesist'])?'<br>1':'';
		            echo ($uniqueSlot['cardiologist'])?'<br>1':'';
		            echo ($uniqueSlot['ot_assistant'])?'<br>1':'';
		            echo ($uniqueSlot['ot_charges'])?'<br>1':'';
		            echo ($uniqueSlot['extra_hour_charge'] != 0) ? "<br>".$units : '';
		            if($this->Session->read('website.instance') == 'kanpur'){
		            	foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
		            		echo '<br>1';
		            	}
		            }
			        ?></td>
		            <td align="right" valign="top"><?php
			            echo "<br>".$uniqueSlot['cost'];
		            echo (!empty($uniqueSlot['doctor']))?"<br>".$uniqueSlot['surgeon_cost']:'';
		            if($uniqueSlot['asst_surgeon_one'])
		            	echo "<br>".$uniqueSlot['asst_surgeon_one_charge'];
		            else
		            	$uniqueSlot['asst_surgeon_one_charge'] = 0;
		            if(!empty($uniqueSlot['asst_surgeon_two']))
		            	echo "<br>".$uniqueSlot['asst_surgeon_two_charge'];
		            else 
		            	$uniqueSlot['asst_surgeon_two_charge'] = 0;

		            if(!empty($uniqueSlot['anaesthesist']))
		            	echo "<br>".$uniqueSlot['anaesthesist_cost'];
		            else
		            	$uniqueSlot['anaesthesist_cost'] = 0;
		            
		            
		            if(!empty($uniqueSlot['cardiologist']))
		            	echo "<br>".$uniqueSlot['cardiologist_charge'];
		            else
		            	$uniqueSlot['cardiologist_charge'] = 0;
		            
		            if(!empty($uniqueSlot['ot_assistant']))
		            	echo "<br>".$uniqueSlot['ot_assistant'];
		            else
		            	$uniqueSlot['ot_assistant'] = 0;
		            
		            if(!empty($uniqueSlot['ot_charges'])){
						echo "<br>".$uniqueSlot['ot_charges'];
					}
					echo ($uniqueSlot['extra_hour_charge'] != 0) ? "<br>".$uniqueSlot['extra_hour_charge']:'';
					$totalOtServiceCharge = 0;
					if($this->Session->read('website.instance') == 'kanpur'){
						foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
							echo '<br>'.$charge;
							$totalOtServiceCharge = $totalOtServiceCharge + $charge;
						}
					}
					/** gaurav */
		            //$totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost']+$uniqueSlot['anaesthesist_cost']+$uniqueSlot['ot_charges'];
		             $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost'] + $uniqueSlot['surgeon_cost'] + $uniqueSlot['asst_surgeon_one_charge'] +
		            $uniqueSlot['asst_surgeon_two_charge'] + $uniqueSlot['anaesthesist_cost'] + $uniqueSlot['cardiologist_charge'] + $uniqueSlot['ot_assistant'] +
		            $uniqueSlot['ot_charges'] + $uniqueSlot['extra_hour_charge'] + $totalOtServiceCharge;
		            /** EOF gaurav */
		            ?></td>
		          	</tr>
				<?php 	
				  } //EOF package cond for surgery display
          		}else{
					$v++;
					$wardNameKey = key($uniqueSlot);#pr($uniqueSlot[$wardNameKey][0]['cost']);exit;
					$wardCostPerWard = $uniqueSlot[$wardNameKey][0]['cost'];
					#echo $wardCostPerWard;exit;
					$daysCountPerWard=count($uniqueSlot[$wardNameKey]);
					$totalWardNewCost = $totalWardNewCost + (count($uniqueSlot[$wardNameKey]) * $wardCostPerWard);
					$totalWardDays = $totalWardDays + count($uniqueSlot[$wardNameKey]);
					$totalWardDaysW = count($uniqueSlot[$wardNameKey]);
					
					$splitDateIn = explode(" ",$uniqueSlot[$wardNameKey][0]['in']);
		            $splitDateOut = explode(" ",$uniqueSlot[$wardNameKey][$daysCountPerWard-1]['out']);
		   			$inDate= $this->DateFormat->formatDate2Local($uniqueSlot[$wardNameKey][0]['in'],Configure::read('date_format'));//.' '.$splitDateIn[1];
		            $outDate= $this->DateFormat->formatDate2Local($uniqueSlot[$wardNameKey][$daysCountPerWard-1]['out'],Configure::read('date_format'));//.' '.$splitDateOut[1];
			if($patient['Patient']['payment_category']!='cash'){
				if($conservativeCount==0) {
					$conservativeDateRange = ' ('.$inDate.'-'.$outDate.')' ;
				 ?>
					 <script> 
					 	$('#firstConservativeText').html("<?php echo $conservativeDateRange; ?>");
					 	$('#first_conservative_cost').html("<?php echo 'Conservative Charges '.$conservativeDateRange; ?>"); 
					 </script>
				 <?php 
				}
				$conservativeCount++;
			if($lastSection !='Conservative Charges'){
					?>
			<tr>
			<td align="center" class="tdBorderRt">&nbsp;</td>
			
			<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
			<td align="center" class="tdBorderRt">&nbsp;</td>
			<?php }*/?>
			
            <td class="tdBorderRt" style="font-size:12px;"><i><strong>Conservative Charges</strong>
            	<?php 	echo ' ('.$inDate.'-'.$outDate.')' ; ?>
            	</i></td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp; 
            <?php 
            	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Conservative Charges','legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
            
            <td align="right" valign="top">&nbsp;</td>
          	</tr>
          	
          	<?php }?>
          	<?php $v++;?>
          	<?php }?>
          	<?php //echo $uniqueSlot[$wardNameKey][0]['moa_sr_no'].'here';exit;?>
          	<tr>
          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
          	
          	<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot[$wardNameKey][0]['moa_sr_no'];
          	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $uniqueSlot[$wardNameKey][0]['moa_sr_no'],'legend'=>false,'label'=>false));
          	?></td>
            <?php }*/?>
            
            <td class="tdBorderRt"><?php 
            
   			echo $wardNameKey.' ('.$inDate.'-'.$outDate.')';
   			
   			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $wardNameKey.' ('.$inDate.'-'.$outDate.')','legend'=>false,'label'=>false));
   			?></td>
   			<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
   			$hospitalType = $this->Session->read('hospitaltype');
   			if($hospitalType == 'NABH'){
   				echo $uniqueSlot[$wardNameKey][0]['cghs_code'];
   				echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_code'],'legend'=>false,'label'=>false));
   			}else{
   				echo $uniqueSlot[$wardNameKey][0]['cghs_code'];
   				echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_code'],'legend'=>false,'label'=>false));
   			}
   			?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php //echo $totalWardDays;
   			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
   			//echo $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
   			echo $this->Number->format($wardCostPerWard);
   			?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $totalWardDaysW;
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format(($totalWardDaysW*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $totalWardDaysW*$wardCostPerWard;
            $totalNewWardCharges = $totalNewWardCharges + ($totalWardDaysW*$wardCostPerWard);
            ?></td>
          	</tr>
          	<?php $v++;?>
          	
				<?php }?>
         
          <?php 
          #$totalWardDays=0;
          }
          
          // Anesthesia Charges Starts
          if(!empty($anesthesiaDetails)){
          $v++;$anesthesiaCharges = 0;
          foreach($anesthesiaDetails as $anesthesiaDetail){
			if(!empty($anesthesiaDetail['Surgery']['anesthesia_charges'])){
          	$srNo++;
          	
				?>
          	<tr>
          <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
          
          <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
          <td align="center" class="tdBorderRt"><?php 
          //echo $doctorChargesData['TariffAmount']['moa_sr_no'].'here';exit;
          echo '';
          echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => '','legend'=>false,'label'=>false));
          ?></td>
          <?php }*/?>
          
          <td class="tdBorderRt">Anesthesia Charges
            <?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Anesthesia Charges','legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            echo '';
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => '','legend'=>false,'label'=>false));
            
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            //echo $totalWardDays;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
            //echo $this->Number->format((ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo (ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100));
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $doctorRate;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo 1;
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format((ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format((ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100);
            $anesthesiaCharges = $anesthesiaCharges + ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100);
            ?></td>
          	</tr>
          	
          <?php }
          }
          }
          
          // Anesthesia Charges Ends
          
          
          if($totalWardDays>0){
          	
          ?>
           <?php if($doctorRate!='' && $doctorRate!=0){
          $srNo++;
          	?>
          <tr>
          <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
          
          <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
          <td align="center" class="tdBorderRt"><?php 
          //echo $doctorChargesData['TariffAmount']['moa_sr_no'].'here';exit;
          echo $doctorChargesData['TariffAmount']['moa_sr_no'];
          echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $doctorChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
          ?></td>
          <?php }*/?>
          
          <td class="tdBorderRt">Doctor Charges
            <?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Doctor Charges','legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            echo $doctorChargesData['TariffList']['cghs_code'];
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $doctorChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));
            
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            //echo $totalWardDays;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
            //echo $this->Number->format($doctorRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $doctorRate;
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $doctorRate;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $doctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $totalWardDays;
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->format($totalWardDays*$doctorRate);
            $totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$doctorRate);
            ?></td>
          	</tr>
          	<?php }?>
          	<?php $v++;?>
          	<?php if($nursingRate!='' && $nursingRate!=0){
          		$srNo++;
          	?>
          	<tr>
          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
          	
          	<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
          	<td align="center" class="tdBorderRt"><?php 
          	echo $nursingChargesData['TariffAmount']['moa_sr_no'];
          	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $nursingChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
          	?></td>
            <?php }*/?>
            
            <td class="tdBorderRt">Nursing Charges
            <?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Nursing Charges','legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            echo $nursingChargesData['TariffList']['cghs_code'];
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $nursingChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));
            
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            //echo $totalWardDays;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
            //echo $this->Number->format(($nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->format($nursingRate);
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $nursingRate;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $nursingRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $totalWardDays;
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->format($totalWardDays*$nursingRate);
            $totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$nursingRate);
            ?></td>
          	</tr>
          <?php }?>	
          <?php }
           }
          }else{?>
          <?php /**if($doctorRate!='' && $doctorRate!=0){
          $srNo++;
          	?>
          	<tr>
          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
          	
          	<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
          	<td align="center" class="tdBorderRt"><?php 
          echo $doctorChargesData['TariffAmount']['moa_sr_no'];
          echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $doctorChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
          ?></td>
            <?php }?>
            
            <td class="tdBorderRt"><?php echo ($patient['TariffList']['name'])?($patient['TariffList']['name']):'Consultation Fee' ;?>
            <?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Doctor Charges','legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            echo $doctorChargesData['TariffList']['cghs_code'];
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $doctorChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));
            
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            //echo $totalWardDays;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
            echo $doctorRate;
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $doctorRate;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $doctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo '--';
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $doctorRate;
            $totalNewWardCharges = $totalNewWardCharges + ($doctorRate);
            ?></td>
          	</tr>
          <?php } **/
          }
          ?>
          
          
          
         
         <?php 
		  #pr($nursingServices);exit;
		  $hospitalType = $this->Session->read('hospitaltype');
		  $serviceListArray=array();
		  $serviceListCountArray=array();
		  //$v++;
		  $k=0;$totalNursingCharges=0;
		  
		  //BOF pankaj- reset array to service as main key		  
		   		$ng=0;$nt=0;	
		    	if($hospitalType == 'NABH'){
					 $nursingServiceCostType = 'nabh_charges';
			  	}else{
			  		 $nursingServiceCostType = 'non_nabh_charges';
			  		
			  	}
			  	 
			//$nursingCnt = 0;
 
		   	foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){ 
				$nursingCnt = $nursingServicesCost['TariffList']['id'] ; 
				$resetNursingServices[$nursingCnt]['qty'] = $resetNursingServices[$nursingCnt]['qty']+$nursingServicesCost['ServiceBill']['no_of_times'];
				$resetNursingServices[$nursingCnt]['name'] = $nursingServicesCost['TariffList']['name'] ; 																						
				$resetNursingServices[$nursingCnt]['cost'] = $nursingServicesCost['ServiceBill']['amount'];
				$resetNursingServices[$nursingCnt]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
				$resetNursingServices[$nursingCnt]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code']; 
				//	$nursingCnt++;
		   	} 
		   	 
	   		//EOF pankaj
		  	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Nursing Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		   	foreach($resetNursingServices as $resetNursingServicesName=>$nursingService){
		  	$k++;
		  	$totalUnit= $nursingService['qty'];  
		  	$srNo++;
		  	
		  	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][name]",'value' => $nursingService['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		  	?>
          
            <tr>
            <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
            
            <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
            <td align="center" class="tdBorderRt"><?php 
            if($nursingService['moa_sr_no']!='')
            	echo $nursingService['moa_sr_no'];
            else echo '&nbsp;';
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][moa_sr_no]",'value' => $nursingService['moa_sr_no'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            ?></td>
            <?php }*/?>
            
            <td class="tdBorderRt"><?php echo $nursingService['name'];?></td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            if($nursingService['nabh_non_nabh']!='')
            	echo $nursingService['nabh_non_nabh'];
            else echo '&nbsp;';
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][nabh_non_nabh]",'value' => $nursingService['nabh_non_nabh'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php
            //$totalUnit = array_sum($nursingService['qty']);
				  echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $nursingService['cost'],'legend'=>false,'label'=>false,'id' => 'nursing_service_rate','style'=>'text-align:right;'));
				echo $this->Number->format($nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
				///echo $nursingService['cost'];
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
              	if($totalUnit<1) $totalUnit=1;
            	echo $totalUnit;
             	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => $totalUnit,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
		    
            
            ?></td>
            
            <td align="right" valign="top"><?php 
		  $hospitalType = $this->Session->read('hospitaltype');
            $totalNursingCharges1=0;
		  			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format($totalUnit*$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'nursing_service_amount','style'=>'text-align:right;'));
					echo $this->Number->format($totalUnit*$nursingService['cost']);
					//echo $this->Number->format($totalUnit*$nursingService['cost']);
		  			$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
				
					
				//echo $totalNursingCharges1;
		  	?></td>
          </tr>
          <?php }
          
          ?>  
            
            
		
		   <?php //$totalCost=$totalCost+$wardDetailCharges['wardOtherCharges']
		   if($pharmacy_charges !='' && $pharmacy_charges!=0){
		   	$v++;$srNo++;
		   	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Pharmacy Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;')); 
           	#echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
           	
           
		   ?>
		   <tr>
		   <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
		   
		   <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
		   <td align="center" class="tdBorderRt">&nbsp;</td>
		   <?php }*/?>
		   
		   
            <td class="tdBorderRt ">Pharmacy Charges</td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt ">
<?php   echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format(ceil($pharmacy_charges/*-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		//echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		echo $this->Number->format(ceil($pharmacy_charges/*-$pharmacyPaidAmount*/));
	
?>
</td>
            <td align="center" valign="top" class="tdBorderRt ">
<?php 	
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
		echo '--';
?>
</td>
            
            <td align="right" valign="top" ><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(ceil($pharmacy_charges/*-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            //echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->format(ceil($pharmacy_charges/*-$pharmacyPaidAmount*/));
            //echo $this->Number->format($pharmacy_charges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
          </tr>
          <?php 
		   }?>
          <?php $hospitaType = $this->Session->read('hospitaltype');
          if($hospitaType == 'NABH'){
          	$nabhType='nabh_charges';
          }else{
          	$nabhType='non_nabh_charges';
          }
          ?>
           <!-- BOF lab charges -->
          <?php if(count($labRate)>0){
          foreach($labRate as $lab=>$labCost){
          			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
          				$k++;
          				if($labCost['LaboratoryTestOrder']['amount'] >0 ){
							$lCost += $labCost['LaboratoryTestOrder']['amount'] ;
						}else{
							$lCost += $labCost['TariffAmount'][$nabhType] ;
						}
          				//$lCost += $labCost['TariffAmount'][$nabhType] ;
          				
          }
          $lCost = $lCost - $labPaidAmount;$srNo++;
          //}
          	?>
           <tr>
           <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
           
           <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
           <td align="center" class="tdBorderRt">&nbsp;</td>
           <?php }*/?>
           
            <td class="tdBorderRt">Laboratory Charges
            <?php $v++;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Laboratory Charges",'legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">
            <?php
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
			//echo $this->Number->format($lCost) ;
            ?>
            </td>
            <td align="center" valign="top" class="tdBorderRt">
<?php 
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
            		echo '--';
		
?>
</td>
            
            <td align="right" valign="top">
            <?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            		echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            		//echo $this->Number->format($lCost) ;
            		?>
            </td>
          </tr>
          
          <?php $v++;
         // echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Laboratory Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
          }?>
          <!-- 
          <?php 
          		//$lCost ='';$k=0;
          		#print_r($labRate);
          	//	foreach($labRate as $lab=>$labCost){
          			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
          		//		$k++;
          		//		$lCost += $labCost['TariffAmount'][$nabhType] ;
   //echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][name]",'value' => $labCost['Laboratory']['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
    #echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));      				
    
    
    
    ?>
          				 <tr>
					            <td class="tdBorderRt">&nbsp;&nbsp;<i><?php //echo $labCost['Laboratory']['name'];?></i></td>
					            <td align="center" valign="top" class="tdBorderRt"><strong>
					            <?php 
	//echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));				            
					            ?></strong></td>
					            <td align="right" valign="top" class="tdBorderRt"><?php 
					            //echo $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					        //    echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					            ?></td>
					            
					            <td align="right" valign="top"><strong><?php 
					            //echo $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					     //       echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					            ?></strong></td>
					      </tr>
          				<?php 
          			//}
          	//	}
          	//	?>
          	-->	 
          <!-- EOF lab charges --> 
          <!-- BOF radiology charges --> 
           
          <?php if(count($radRate)>0){
          	$v++;
          	 
          	foreach($radRate as $lab=>$labCost){
				if($labCost['RadiologyTestOrder']['amount'] > 0){
					$rCost += $labCost['RadiologyTestOrder']['amount'] ;
				}else{
					$rCost += $labCost['TariffAmount'][$nabhType] ;
				}
          		//$rCost += $labCost['TariffAmount'][$nabhType] ;
          	}
          	$rCost = $rCost - $radPaidAmount;
          	$srNo++;
          	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Radiology Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
          ?>		  
           <tr>
           <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
           
           <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
           <td align="center" class="tdBorderRt">&nbsp;</td>
           <?php }*/?>
           
            <td class="tdBorderRt">Radiology Charges
            <?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Radiology Charges",'legend'=>false,'label'=>false));?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">
<?php 		
			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			echo $this->Number->format($rCost);
			//echo $this->Number->format($rCost);
?>
</td>
            <td align="center" valign="top" class="tdBorderRt">
<?php 	
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
		echo '--';
		
?>
</td>
            
            <td align="right" valign="top">
<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		echo $this->Number->format($rCost);
		//echo $this->Number->format($rCost);
		?>
</td>
          </tr>
          <?php }?>
          <!-- 
          		<?php 
          		//$rCost = '';$k=0;
          		//foreach($radRate as $lab=>$labCost){
          		//	 $k++;
          		//		$rCost += $labCost['TariffAmount'][$nabhType] ;
    //echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][name]",'value' => $labCost['Radiology']['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
    #echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));      				
    
    
    
          				?>
          				 <tr>
					            <td class="tdBorderRt">&nbsp;&nbsp;<i><?php //echo $labCost['Radiology']['name'];?></i></td>
					            <td align="center" valign="top" class="tdBorderRt"><strong>

<?php //echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));?>
</strong></td>
					            <td align="right" valign="top" class="tdBorderRt"><?php 
					            //echo $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					        //    echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					            ?></td>
					            
					            <td align="right" valign="top"><strong><?php 
					            //echo $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					       //     echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					       //     ?></strong></td>
					      </tr>
          				<?php 
          			 
          		//}
          ?>
          -->
          <!-- EOF radiology charges --> 
          
          <?php 
          $otherServicesCharges=0;
          foreach($otherServicesData as $otherServiceD){
          $v++;$srNo++;
          	?>
         
        <tr>
         <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
         
         <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
         <td align="center" class="tdBorderRt">&nbsp;</td>
         <?php }*/?>
         
            <td class="tdBorderRt"><?php echo $otherServiceD['OtherService']['service_name'];?>
            <?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $otherServiceD['OtherService']['service_name'],'legend'=>false,'label'=>false));?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">
<?php 	
			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($otherServiceD['OtherService']['service_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			//echo $this->Number->format($otherServiceD['OtherService']['service_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
			echo $this->Number->format($otherServiceD['OtherService']['service_amount']);
?>
</td>
            <td align="center" valign="top" class="tdBorderRt">
<?php 	
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '1','legend'=>false,'label'=>false,'style'=>'text-align:center'));
		#echo $otherServiceD[0]['tUnit'];
		echo '1';		
?>
</td>
            
            <td align="right" valign="top">
<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		//echo $this->Number->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		echo $this->Number->format($otherServiceD['OtherService']['service_amount']);
		$otherServicesCharges = $otherServicesCharges + ($otherServiceD['OtherService']['service_amount']);
		?>
</td>
          </tr>
         
    <?php }?>     
          
		  	<!--  Registration Charges -->
  			<?php 
  			
  			//$totalCost = $otherServicesCharges + $registrationRate + $totalNursingCharges + $totalDoctorCharges + $totalNewWardCharges + $totalCost + $lCost + $rCost;//-$radPaidAmount-$labPaidAmount;// + $extraSurgeryCost;?>
  			<?php  
  			 
  			$totalCost = $otherServicesCharges + $registrationRate + $totalNursingCharges + $totalDoctorCharges + $totalNewWardCharges + $totalCost  + $lCost + $rCost-$radPaidAmount-$labPaidAmount+$anesthesiaCharges;// + $extraSurgeryCost;
  			 
  			?>
  			<!-- Registration Charges -->
          <tr>
            <td class="tdBorderRt" align="center" valign="top" id="addColumnHt1"></td>
            
            <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { // for private patient only?>
            <td class="tdBorderRt" align="center" valign="top"></td>
            <?php }*/?>
            <td class="tdBorderRt"></td>
            <td class="tdBorderRt" align="center"></td>
            <td class="tdBorderRt" align="right" valign="top"></td>
                     
            <td align="right" class="tdBorderRt" valign="top"></td>
          </tr>
          <tr>
          	<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
          	
          	<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { // for private patient only?>
          	<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
          	<?php }*/?>
          		
            <td align="right" valign="top" class="tdBorderTpRt"><strong>Total</strong></td>
            <td align="center" class="tdBorderTpRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
            
            <td align="right" valign="top" class="tdBorderTp totalPrice tdBorderRt"><strong><span class="WebRupee"></span><?php 
            //echo $this->Html->image('icons/rupee_symbol.png');
            echo $this->Number->currency(ceil($totalCost));
            echo $this->Form->hidden('Billing.total_amount',array('value' => ($totalCost),'legend'=>false,'label'=>false));
            ?></strong></td>
          </tr>
        </table>
    </td>
  </tr> 
  </table>
  <table width="800" border="0" cellspacing="0" cellpadding="0" style="" align="center" id="tblFooter">
	<tr>
	    <td width="100%" align="left" valign="top" class="">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td valign="top" class="boxBorderRight columnPad">Amount Chargeable (in words)<br />
					<strong><?php echo $this->RupeesToWords->no_to_words(ceil($totalCost));?></strong></td>
	            	<td width="50%" >
	            	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="boxBorder">
	                	<tr>
	                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Amount Paid</td>
	                        <td align="right" valign="top" class="tdBorderBt"><?php 
	                        //echo $this->Html->image('icons/rupee_symbol.png');
	                        echo $this->Number->currency(ceil($totalAdvancePaid));
	                        echo $this->Form->hidden('Billing.amount_paid',array('value' => ($totalAdvancePaid),'legend'=>false,'label'=>false));
	                        ?></td>
	                    </tr>
	                    
	                    <?php  
						if($totalDiscountGiven[0]['sumDiscount']){
							$discountAmount=$totalDiscountGiven[0]['sumDiscount'];
						}else{
							$discountAmount='';
						}

	                    if($discountAmount != '' && $discountAmount!=0){
	                    ?>
	                    
	                    <tr>
	                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Discount</td>
	                        <td align="right" valign="top" class="tdBorderBt"><?php  
	                        echo $this->Number->currency(ceil($discountAmount)); 
	                        ?></td>
	                    </tr>
	                        <?php }?>
	                    
	                    <?php 
	                    if($totalRefundGiven[0]['sumRefund']){
							$totalRefund=$totalRefundGiven[0]['sumRefund'];
						}else{
							$totalRefund='';
						}
	                    if($totalRefund != '' && $totalRefund!=0){
	                    
//if($discountData['FinalBilling']['refund']=='1'){?>
	                    <tr>
	                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp; <?php  echo 'Refunded Amount';?> </td>
	                	  <td align="right" class="tdBorderBt"><?php echo $this->Number->currency(ceil($totalRefund));?>
					      </td>
	               	    </tr>
	                   <?php }else{$totalRefund='0';}?> 
			    
			    
	                	<tr>
	                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp;
	                	  <?php if($invoiceMode=='direct') echo 'To Pay on '.$dynamicText;
	    						else echo 'Balance';?>
	                	  </td>
	                	  <td align="right" valign="top" class="tdBorderBt"><?php 
	                	  //echo $this->Html->image('icons/rupee_symbol.png');
	                	  echo $this->Number->currency(ceil($totalCost-$totalAdvancePaid-$discountAmount+$totalRefund));
	                	  echo $this->Form->hidden('Billing.amount_pending',array('value' => ($totalCost-$totalAdvancePaid-$discountAmount+$totalRefund),'legend'=>false,'label'=>false));
	                	  ?></td>
	               	  </tr>
	                  
	               	  
	              </table>
	            </td>
	          </tr>
	        </table>
	    </td>
	  </tr>
	  <tr>
	    <td width="100%" align="left" valign="top" class="columnPad ">
	    	<table width="" cellpadding="0" cellspacing="0" border="0">
	    		<?php if($this->Session->read('website.instance')=='hope'){?>
	        	<tr>
	            	<td height="18" align="left" valign="top">Hospital Service Tax No.</td>
	              	<td width="15" align="center" valign="top">:</td>
	                <td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_service_tax_no');?></strong></td>      
	      		</tr>
	        	<tr>
	        	  <td height="20" align="left" valign="top">Hospitals PAN</td>
	        	  <td align="center" valign="top">:</td>
	        	  <td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_pan_no');?></strong></td>
	      	    </tr>
	      	    <?php }else{?>
	      	    <tr><td height="18" align="left" valign="top">&nbsp;</td></tr>
	        	<tr><td height="20" align="left" valign="top">&nbsp;</td></tr>
	      	    <?php }?>
	        	<tr>
	        	  <td height="20" align="left" valign="top"><strong>Signature of Patient :</strong></td>
	        	  <td align="center" valign="top">&nbsp;</td>
	        	  <td align="left" valign="top">&nbsp;</td>
	      	  </tr>
	   	  </table>
	    </td>
	  </tr>
	  <tr>
	    <td width="100%" align="left" valign="top">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td width="55%" class="columnPad boxBorderRight">&nbsp;
	            </td>
	            <td width="45%" align="right" valign="bottom" class="columnPad tdBorderTp tdBorderRt">
	            	<strong><?php echo $this->Session->read('billing_footer_name');?></strong><br /><br /><br />
	                <table width="100%" cellpadding="0" cellspacing="0" border="0">
	                	<tr>
	                    	<td width="85">Bill Manager</td>
	                        <td width="65">Cashier</td>
	                        <td width="80">Med.Supdt. </td>
	                        <td align="right">Authorised Signatory</td>
	                	</tr>
	                </table>
	            </td>
	          </tr>
	        </table>
	    </td>
	  </tr> 
</table> 
 <!-- Generate Receipt Changes Ends -->
            <?php if($patient['Patient']['admission_type'] !='OPD'){?>
<div class='page-break'>&nbsp;</div>
<table class="" border="0" class="table_format" cellpadding="0"
  cellspacing="0" width="100%" style="text-align: left;">
  <thead>
    <tr>
      <td colspan="6" width="100%">
      <table width="100%" style="font-weight: bold; margin-top:20px;" cellpadding="0" cellspacing="1" class="">
        <tr>
          <td width="330" valign="top">
          <table width="100%" border="0" cellspacing="1" cellpadding="5" class="tbl">
            <tr>
              <td width="38%" height="" valign="top">Name</td>
              <td align="left" valign="top"><?php 
              echo $complete_name  = $patient['Patient']['lookup_name'] ;
              ?></td>
            </tr>
            <tr>
              <td width="110" height="" valign="top" id="boxSpace3">Registration
              ID</td>
              <td align="left" valign="top"><?php echo $patient['Patient']['admission_id'] ;?></td>
            </tr>
            <tr>
              <td valign="top" id="boxSpace3">Patient ID</td>
              <td align="left" valign="top"><?php echo $patient['Patient']['patient_id'] ;?>
              </td>
            </tr>
            <tr>
              <td valign="top">Treating Consultant</td>
              <td align="left" valign="top"><?php echo ucfirst($treating_consultant[0]['fullname']) ;?></td>
            </tr>
            <tr>
              <td valign="top">Bed</td>
              <td align="left" valign="top"><?php 
                 
              echo ucfirst($wardInfo['Room']['bed_prefix'].$wardInfo['Bed']['bedno']) ;?></td>
            </tr>

            <?php if(!empty($corporate_name)){?>
            <tr>
              <td valign="top">Sponsor</td>
              <td><?php echo $corporate_name ;?></td>
            </tr>
            <?php } ?>
          
          <!-- 
            <tr>
              <td width="200" height="" valign="top" id="boxSpace3">Invoice No</td>
              <td align="left" valign="top"><?php echo $billNumber;?></td>
            </tr>
           -->  
            <tr>
              <td valign="top" id="boxSpace3">Invoice Date</td>
              <td align="left" valign="top"><?php 
              $currentDate = date("Y-m-d H:i:s") ;
              echo $this->DateFormat->formatDate2Local($currentDate,Configure::read('date_format'),true);
              //echo date('d/m/Y H:i:s') ;?></td>
            </tr>
            <tr>
              <td valign="top" id="boxSpace3">Registration Date & Time</td>
              <td align="left" valign="top"><?php 
              if($patient['Patient']['form_received_on']){
                $splitDateIn = explode(" ",$patient['Patient']['form_received_on']);
                echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
              }
              else{
                $splitDateIn = explode(" ",$patient['Patient']['create_time']);
                echo $this->DateFormat->formatDate2Local($patient['Patient']['create_time'],Configure::read('date_format'),true);
              }



              //echo $patient['Patient']['form_received_on'] ;?></td>
            </tr>
            <tr>
              <td valign="top" id="boxSpace3"><?php echo $dynamicText ;?> Date & Time</td>
              <td align="left" valign="top"><?php
              
                 if(isset($patient['Patient']['discharge_date']) && $patient['Patient']['discharge_date']!=''){
                 
                  echo $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),true);
                 }
              //echo $discharge_date ;
              ?></td>
            </tr>
          </table>
          </td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr class="tbl">
    
      <td class="table_cell" width="10%" style="border-left:1px solid #3e474a;"><strong><?php echo __('Sr.No.'); ?></strong></td>
      <td class="table_cell" style="border-left:1px solid #3e474a;"><strong><?php echo __('Service Name'); ?></strong></td>
      <td class="table_cell" style="border-left:1px solid #3e474a;"><strong><?php echo __('Date & Time'); ?></strong></td>
      <td class="table_cell" style="display:<?php echo $hideCGHSCol ;?>" style="border-left:1px solid #3e474a;border-right:1px solid #3e474a;"><strong><?php echo __('CGHS Code'); ?></strong></td>
      <!-- <td class="table_cell"><strong><?php echo __('MOA Sr. No.'); ?></strong></td> -->
      <td class="table_cell" align="center" style="border-left:1px solid #3e474a;"><strong><?php echo __('Qty'); ?></strong></td>
      <td class="table_cell" align="right" style="border-left:1px solid #3e474a;border-right:1px solid #3e474a;"><strong><?php echo __('Amount'); ?></strong></td>
              
    </tr>
    <tr>
    <td colspan="6" style="border-left:1px solid #3e474a;border-right:1px solid #3e474a;"><?php if(!empty($roomTariff)){?>
    <h3>Room Tariff</h3>
    <?php }?></td>
  </tr>
  <?php

  //BOF Room tariff
  $r=1;
  $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_rate':'non_nabh_rate' ;
  $rCost = 0 ;

  $g=0;$t=0;
  //debug($wardServicesDataNew);
  foreach($roomTariff['day'] as $roomKey=>$roomCost){
    $bedCharges[$g][$roomCost['ward']]['bedCost'][] = $roomCost['cost'] ;
    $bedCharges[$g][$roomCost['ward']][] = array('out'=>$roomCost['out'],'in'=>$roomCost['in'],'moa_sr_no'=>$roomCost['moa_sr_no'],'cghs_code'=>$roomCost['cghs_code']);
    if($roomTariff['day'][$roomKey+1]['ward']!=$roomCost['ward']){
      $g++;
    }
  }

  foreach($bedCharges as $bedKey=>$bedCost){
      
    $wardNameKey = key($bedCost);
    $bedCost= $bedCost[$wardNameKey];
    $rCost += array_sum($bedCost['bedCost']) ;
    $splitDateIn = explode(" ",$bedCost[0]['in']);

    if(count($bedCost)==2 && $bedCost[0]['in']== $bedCost[0]['out']){
      //if(!is_array($bedCharges[$bedKey+1])){
      #$nextDay = date('Y-m-d H:i:s',strtotime($splitDateIn[0].'+1 day 10 hours'));   //comented for maintaining single day chargers 
      $nextDay =   $bedCost[0]['in'];
      $lastKey = array('out'=>$nextDay) ;
      /*}else{
       $nextElement = $bedCharges[$bedKey+1] ;
       $nextElementKey = key($nextElement);
       $lastKey  = $nextElement[$nextElementKey][0] ;
       }*/
    }else{
      $lastKey  = end($bedCost) ;
    }
    $splitDateOut = explode(" ",$lastKey['out']);

    //if($t==0){$t++;
    ?>

  <tr>
    <td valign="top" class="tdBorderTp" style="border-left:1px solid #3e474a;"><?php echo $r++ ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $wardNameKey;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
      if(!empty($bedCost[0]['in'])){//time is removed form date, only date will be shown
        $inDate= $this->DateFormat->formatDate2Local($bedCost[0]['in'],Configure::read('date_format'),false);
        //  $splitDateOut  = explode(" ",$bedCost[0]['in']);
        $outDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),false);
        echo $inDate." - ".$outDate;
      }else{
        $inDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),false);
        $outDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),false);
        echo $inDate." - ".$outDate;
      }
    ?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $bedCost[0]['cghs_code'];?></td>
    <!-- <td align="center" valign="top" class="tdBorderRt tdBorderTp" ><?php echo $bedCost[0]['moa_sr_no'];?></td>
                 -->
    <td align="center" valign="top" class="tdBorderRt tdBorderTp"><?php echo count($bedCost['bedCost'])?></td>
    <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format(array_sum($bedCost['bedCost']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
  </tr>
  <?php

  }

  if($rCost>0){
    ?>
  <tr>
    <td colspan="6">
    <div class="inner_title" style="border-left:1px solid #3e474a; border-right:1px solid #3e474a;">

    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
    //echo $this->Html->image('icons/rupee_symbol.png');
    echo $rCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr>
  <?php
  }//EOF Room tariff


  if(!empty($extra_doctor_charges)){
    ?>
  <tr>
    <td colspan="6">
    <h3>Consultation</h3>
    </td>
  </tr>
  <?php
  $srno=1 ;$dCost=0;
  //checking for consulatant of refereed doctor's visit
  foreach($extra_doctor_charges as $consultantKey){
      
    //if(strtotime($consultantKey['ConsultantBilling']['date'])> $visitDateInTime &&
    //  strtotime($consultantKey['ConsultantBilling']['date'])< $preVisitDateInTime){

    $dCost += $consultantKey['ConsultantBilling']['amount'] ;
    //echo'<pre>';print_r($consultantKey);//exit;
    ?>
  <tr>
    <td valign="top" class="tdBorderTp"><?php echo $srno ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php
    if($consultantKey['ConsultantBilling']['category_id'] == 0){
      echo ucfirst($consultantKey['Consultant']['first_name'])." ".ucfirst($consultantKey['Consultant']['last_name']);
    }else if($consultantKey['ConsultantBilling']['category_id'] == 1){
      echo ucfirst($consultantKey['DoctorProfile']['doctor_name']);
    }
    ?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
    $splitDateIn = explode(" ",$consultantKey['ConsultantBilling']['date']);
    echo $this->DateFormat->formatDate2Local($consultantKey['ConsultantBilling']['date'],Configure::read('date_format'),true);?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $consultantKey['TariffList']['cghs_code'];?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
    <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($consultantKey['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
  </tr>
  <?php
  $srno++ ;
  //}
  }?>
  <tr>
    <td colspan="6">
    <div class="inner_title">
    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
    //echo $this->Html->image('icons/rupee_symbol.png');
    echo $dCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr>
  <?php }


  if(!empty($service)){
    ?>
  <tr>
    <td colspan="6" style="border-left:1px solid #3e474a;border-right:1px solid #3e474a;">
    <h3>Services</h3>
    </td>
  </tr>
  <?php
  }
  //BOF Service charges
  $s=1;
  $sCost = 0 ;$t=0;
  $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;

  foreach($service as $serviceKey=>$serviceCost){# echo'<pre>';print_r($serviceCost);exit;

    //if(isset($serviceCost['ServiceBill']['morning'])){
    //$qty  = $serviceCost['ServiceBill']['morning'] + $serviceCost['ServiceBill']['evening'] + $serviceCost['ServiceBill']['night'] + $serviceCost['ServiceBill']['no_of_times'];
    $qty  = $serviceCost['ServiceBill']['no_of_times'];
    //}
    //$qty = $qty + $serviceCost[0]['count(distinct(`ServiceBill`.`id`))'] -1;
    if($qty<1) $qty  =1 ;
    $serviceAmount=/*($serviceCost['TariffAmount'][$hosType])?$serviceCost['TariffAmount'][$hosType]:*/$serviceCost['ServiceBill']['amount'];
    $sCost += $serviceAmount*$qty ;

    ?>
  <tr>
    <td valign="top" class="tdBorderTp" style="border-left:1px solid #3e474a;"><?php echo $s++ ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $serviceCost['TariffList']['name'];?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php
    $splitDateIn = explode(" ",$serviceCost['ServiceBill']['date']);
    echo $this->DateFormat->formatDate2Local($serviceCost['ServiceBill']['date'],Configure::read('date_format'))
    //echo $serviceCost['ServiceBill']['date'];?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>"><?php echo $serviceCost['TariffList']['cghs_code'];?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp"><?php echo $qty ;?></td>
    <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($serviceAmount*$qty,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
  </tr>
  <?php

  }

  if(!empty($service)){
    ?>
  <tr>
    <td colspan="6">
    <div class="inner_title" style="border-left:1px solid #3e474a; border-right:1px solid #3e474a;">
    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
      //echo $this->Html->image('icons/rupee_symbol.png');
      echo $sCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr>
  </thead>
  
  <?php } //EOF Service charges
  ?>
  <!-- 
  <?php 
  if(!empty($roomTariff['day'])){
  ?>
  <tr>
      <td colspan="6">
        <h3>Nursing</h3> 
      </td>
  </tr>
  <?php 
  }
  //BOF Nursing charges
      $nCost = 0 ;$t=0;
      $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ; 
       
      $nurse_cost  = $nurse['TariffAmount'][$hosType]; 
      $n=1; 
      //for($n=0;$n<=$patient_days;$n++){
      foreach($roomTariff['day'] as $dayKey=>$dayValues){   
        $nCost += $nurse_cost ;  
        
              ?>
              <tr>  
                  <td valign="top" class="tdBorderTp"><?php echo $n++ ;?></td>
                  <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo __('Nursing Charges');?></td>
                  <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
        $splitDateIn = explode(" ",$dayValues['out']);
          echo $this->DateFormat->formatDate2Local($dayValues['out'],Configure::read('date_format'),true);
                        
                  //echo $dayValues['out'];?></td>
                  <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td> 
                  <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($nurse_cost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
          </tr>
              <?php 
        
    }   
    
    if(!empty($roomTariff['day'])){
  ?>
    <tr>
      <td colspan="5">
        <div class="inner_title">
          <h3 style="float:left;">Sub Total</h3><h3 style="float:right;"><?php echo $this->Html->image('icons/rupee_symbol.png');echo $this->Number->format($nCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)); ?></h3>
          <div class='clr'></div>
        </div> 
      </td>
    </tr>
  <?php } //EOF Nursing charges 
  ?>
   -->
  <!-- My Changes Starts -->
   <?php
  /* if(!empty($pharmacyCharges)){
    ?>
  <tr>
    <td colspan="6">
    <h3>Pharmacy</h3>
    </td>
  </tr>
  <?php
    }
    $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
    //BOF Pharmacy
    $p=1;
    $pCost = 0 ; $t=0;

    
    foreach($pharmacyCharges as $pharmacyKey=>$pharmacyCost){//echo '<pre>';print_r($pharmacyCost);exit;  

      #$qty = ($pharmacyCost['SuggestedDrug']['quantity']==0)?1:$pharmacyCost['SuggestedDrug']['quantity'] ;
      
      $subPharmacyCost = $pharmacyCost['rate']*$pharmacyCost['quantity'] + (($pharmacyCost['rate']*$pharmacyCost['quantity']*$pharmacyCost['tax'])/100);
      if($pharmacyCost['pharmacySalesBillTax'] != ''){
        $subPharmacyCost = $subPharmacyCost + ($subPharmacyCost*$pharmacyCost['pharmacySalesBillTax']/100); 
      }
      $pCost += $subPharmacyCost;
      ?>
  <tr>
    <td valign="top" class="tdBorderTp"><?php echo $p++ ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $pharmacyCost['itemName'];?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
    //echo $pharmacyCost['purchaseDate'];
    $splitDateIn = explode(" ",$pharmacyCost['purchaseDate']);
    echo $this->DateFormat->formatDate2Local($pharmacyCost['purchaseDate'],Configure::read('date_format'),true);
      
    ?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>">&nbsp;</td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp"><?php echo $pharmacyCost['quantity']?></td>
    <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($subPharmacyCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
  </tr>
  <?php

    }
      
    if(!empty($pharmacyCharges)){
      ?>
  <tr>
    <td colspan="6">
    <div class="inner_title">
    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
      //echo $this->Html->image('icons/rupee_symbol.png');
      echo $pCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr>
  <?php }*/
  if(!empty($labRate)){
    ?>
  <tr>
    <td colspan="4"><h3>Laboratory</h3></td>
    <td><div class="printIcons">
    <?php  
    echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Laboratry Details')),'#',
      array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printServiceInvoice',$patient_id,$patient['Patient']['tariff_standard_id'],
      '?'=>array('billNumber'=>$billNumber,'group'=>'laboratory')))."', '_blank',
      'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

    echo $this->Html->link($this->Html->image('icons/download-excel.png',array('title'=>'Laboratry Excel Reports','style'=>'padding-left: 5px; padding-right: 5px')),array('controller'=>'billings',
      'action'=>'printServiceInvoice',$patient_id,$patient['Patient']['tariff_standard_id'],'?'=>array('billNumber'=>$billNumber,'type'=>'excel','group'=>'laboratory')),array('escape' => false));

    echo $this->Html->link($this->Html->image('icons/download_pdf.png',array('title'=>'Laboratry PDF Reports')),array('controller'=>'billings',
      'action'=>'printServiceInvoice',$patient_id,$patient['Patient']['tariff_standard_id'],'?'=>array('billNumber'=>$billNumber,'type'=>'pdf','group'=>'laboratory')),array('escape' => false));?>
    </div></td>
  </tr>
  <?php
  }//EOF Pharmacy
 
  //BOF laboratory
  $i=1;
  $lCost = 0 ; $t=0;
   
  foreach($labRate as $labKey=>$labCost){ 
    //if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){  
    if($labCost['LaboratoryTestOrder']['amount'] > 0 ){
      $lCost += $labCost['LaboratoryTestOrder']['amount'] ;
    }else{
      $lCost += $labCost['TariffAmount'][$hosType] ;
    } 
    ?>
  <tr>
    <td valign="top" class="tdBorderTp"><?php echo $i++ ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $labCost['Laboratory']['name'];?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
    //echo $labCost['LaboratoryTestOrder']['create_time'];
    $splitDateIn = explode(" ",$labCost['LaboratoryTestOrder']['create_time']);
    echo $this->DateFormat->formatDate2Local($labCost['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true); 
    ?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>"><?php echo $labCost['TariffList']['cghs_code'];?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
    <td align="right" valign="top" class="tdBorderTp"><?php 
    //echo $this->Number->format($labCost['TariffAmount'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
    echo $this->Number->format($labCost['LaboratoryTestOrder']['amount']);?></td>
  </tr>
  <?php
  //  }

  }
  if(!empty($labRate)){
    ?>
  <tr>
    <td colspan="6">
    <div class="inner_title">
    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
    //echo $this->Html->image('icons/rupee_symbol.png');
    echo $lCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr>

  <?php }
  //EOF cost check
  //EOF laboratory
  if(!empty($radRate)){
   ?>
  <tr>
    <td colspan="4"><h3>Radiology</h3></td>
    
    <td><div class="printIcons">
    <?php  
    echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Radiology Details')),'#',
      array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printServiceInvoice',$patient_id,$patient['Patient']['tariff_standard_id'],
      '?'=>array('billNumber'=>$billNumber,'group'=>'radiology')))."', '_blank',
      'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

    echo $this->Html->link($this->Html->image('icons/download-excel.png',array('title'=>'Radiology Excel Reports','style'=>'padding-left: 5px; padding-right: 5px')),array('controller'=>'billings',
      'action'=>'printServiceInvoice',$patient_id,$patient['Patient']['tariff_standard_id'],'?'=>array('billNumber'=>$billNumber,'type'=>'excel','group'=>'radiology')),array('escape' => false));

    echo $this->Html->link($this->Html->image('icons/download_pdf.png',array('title'=>'Radiology PDF Reports','color'=>'red')),array('controller'=>'billings',
      'action'=>'printServiceInvoice',$patient_id,$patient['Patient']['tariff_standard_id'],'?'=>array('billNumber'=>$billNumber,'type'=>'pdf','group'=>'radiology')),array('escape' => false));?>
    </div></td>
  </tr>
  <?php
  }
  //BOF radiology
  $j=1;
  $raCost = 0 ; $t=0; //echo '<pre>';print_r($radRate);
  $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
  foreach($radRate as $radKey=>$radCost){ 
    //if($radCost['RadiologyTestOrder']['test_done']=='true'){
    if($radCost['RadiologyTestOrder']['amount'] > 0){
      $raCost += $radCost['RadiologyTestOrder']['amount'] ;
      $formatRadCost = $radCost['RadiologyTestOrder']['amount'] ;
    }else{
      $raCost += $radCost['TariffAmount'][$nabhType] ;
      $formatRadCost = $radCost['TariffAmount'][$nabhType] ;
    } 
      
    ?>
  <tr>
    <td valign="top" class="tdBorderTp"><?php echo $j++ ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $radCost['Radiology']['name'];?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
    //echo $radCost['RadiologyTestOrder']['create_time'];
    $splitDateIn = explode(" ",$radCost['RadiologyTestOrder']['create_time']);
    echo $this->DateFormat->formatDate2Local($radCost['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true);
      
    ?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>"><?php echo $radCost['TariffList']['cghs_code'];?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
    <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($formatRadCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
  </tr>
  <?php
  //}

  }
  //EOF laboratory
  if(!empty($radRate)){
    ?>
  <tr>
    <td colspan="6">
    <div class="inner_title">
    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
    //echo $this->Html->image('icons/rupee_symbol.png');
    echo $raCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr>

  <?php }

  //EOF MRI
  if(!empty($mri)){
   ?>
  <tr>
    <td colspan="6">
    <h3>MRI</h3>
    </td>
  </tr>
  <?php
  }
  //BOF MRI
  $j=1;
  $mCost = 0 ; $t=0;//echo '<pre>';print_r($mri);
  $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
  foreach($mri as $mriKey=>$mriCost){
    //if($mriCost['RadiologyTestOrder']['test_done']=='true'){
    $mCost += $mriCost['TariffAmount'][$hosType] ;
      
    ?>
  <tr>
    <td valign="top" class="tdBorderTp"><?php echo $j++ ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $mriCost['Radiology']['name'];?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
    //echo $mriCost['RadiologyTestOrder']['create_time'];
    $splitDateIn = explode(" ",$mriCost['RadiologyTestOrder']['create_time']);
    echo $this->DateFormat->formatDate2Local($mriCost['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true);
      
    ?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>">&nbsp;</td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
    <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($mriCost['TariffAmount'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
  </tr>
  <?php
  //}

  }
  //EOF laboratory
  if(!empty($mri)){
    ?>
  <tr>
    <td colspan="6">
    <div class="inner_title">
    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
    //echo $this->Html->image('icons/rupee_symbol.png');
    echo $mCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr>

  <?php }
  
  
  //EOF CT
  if(!empty($ct)){
   ?>
  <tr>
    <td colspan="6">
    <h3>CT</h3>
    </td>
  </tr>
  <?php
  }
  //BOF CT
  $j=1;
  $cCost = 0 ; $t=0;//echo '<pre>';print_r($mri);
  $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
  foreach($ct as $ctKey=>$ctCost){
    //if($ctCost['RadiologyTestOrder']['test_done']=='true'){
    $cCost += $ctCost['TariffAmount'][$hosType] ;
      
    ?>
  <tr>
    <td valign="top" class="tdBorderTp"><?php echo $j++ ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $ctCost['Radiology']['name'];?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
    //echo $ctCost['RadiologyTestOrder']['create_time'];
    $splitDateIn = explode(" ",$ctCost['RadiologyTestOrder']['create_time']);
    echo $this->DateFormat->formatDate2Local($ctCost['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true);
      
    ?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>">&nbsp;</td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
    <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($ctCost['TariffAmount'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
  </tr>
  <?php
  //}
  }
  //EOF laboratory
  if(!empty($ct)){
    ?>
  <tr>
    <td colspan="6">
    <div class="inner_title">
    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
    //echo $this->Html->image('icons/rupee_symbol.png');
    echo $cCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr>

  <?php } 
  
  
  //EOF IMPLANT
  if(!empty($implant)){
   ?>
  <tr>
    <td colspan="6">
    <h3>IMPLANT</h3>
    </td>
  </tr>
  <?php
  }
  //BOF IMPLANT
  $j=1;
  $imCost = 0 ; $t=0;//echo '<pre>';print_r($impalntCost);
  $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
  foreach($implant as $imKey=>$impalntCost){
    //if($impalntCost['RadiologyTestOrder']['test_done']=='true'){
    $imCost += $impalntCost['TariffAmount'][$hosType] ;
      
    ?>
  <tr>
    <td valign="top" class="tdBorderTp"><?php echo $j++ ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $impalntCost['Radiology']['name'];?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
    //echo $impalntCost['RadiologyTestOrder']['create_time'];
    $splitDateIn = explode(" ",$impalntCost['RadiologyTestOrder']['create_time']);
    echo $this->DateFormat->formatDate2Local($impalntCost['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true);
      
    ?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>">&nbsp;</td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
    <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($impalntCost['TariffAmount'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
  </tr>
  <?php
  //}

  }
  //EOF laboratory
  if(!empty($implant)){
    ?>
  <tr>
    <td colspan="6">
    <div class="inner_title">
    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
    //echo $this->Html->image('icons/rupee_symbol.png');
    echo $imCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr>

  <?php }



  if(!empty($otherServicesData)){
   ?>
  <tr>
    <td colspan="6">
    <h3>Other Services</h3>
    </td>
  </tr>
  <?php
  }
  //BOF radiology
  $j=1;
  $otherServicesCost = 0 ; $t=0;//echo '<pre>';print_r($radiology);
  $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_rate':'non_nabh_rate' ;
  foreach($otherServicesData as $otherServicesKey=>$otherServices){
    //if($radCost['RadiologyTestOrder']['test_done']=='true'){
    $otherServicesCost += $otherServices['OtherService']['service_amount'] ;
      
    ?>
  <tr>
    <td valign="top" class="tdBorderTp"><?php echo $j++ ;?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $otherServices['OtherService']['service_name'];?></td>
    <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
    //echo $radCost['RadiologyTestOrder']['create_time'];
    #$splitDateIn = explode(" ",$radCost['RadiologyTestOrder']['create_time']);
    echo $this->DateFormat->formatDate2Local($otherServices['OtherService']['service_date'],Configure::read('date_format'));
      
    ?></td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>">&nbsp;</td>
    <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
    <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($otherServices['OtherService']['service_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
  </tr>
  <?php
  //}

  }
  //EOF laboratory
  if(!empty($otherServicesData)){
    ?>
  <tr>
    <td colspan="6">
    <div class="inner_title">
    <h3 style="float: left;">Sub Total</h3>
    <h3 style="float: right;"><?php 
      //echo $this->Html->image('icons/rupee_symbol.png');
      echo $otherServicesCost; ?></h3>
    <div class='clr'></div>
    </div>
    </td>
  </tr> 
  <?php } ?> 
  <!-- My Changes Ends -->
  <tr>
    <td colspan="3">
    <h3>Total Amount</h3>
    </td>
    <td colspan="3" align="right">
    <h3 style="float: right;"><?php  
    //echo $this->Html->image('icons/rupee_symbol.png');
    echo $rCost+$pCost+$lCost+$raCost+$dCost+$sCost+$otherServicesCost; ?></h3>
    </td>
  </tr>
  <tr>
    <td colspan="5">In Words:&nbsp;<?php echo $this->RupeesToWords->no_to_words(round($rCost+$pCost+$lCost+$raCost+$dCost+$sCost+$otherServicesCost));?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right">Cashier</td>
  </tr>
  <tfoot id="table_footer" style="bottom: 0;">
    <tr>
      <td colspan="5" style="display:none;">_____________________________________________________________________________________________________</td>
    </tr>

  </tfoot>
</table>
    <?php }else{ //EOF if patient OP check ?>
    <div class='page-break'>&nbsp;</div>
    <table class="" border="0" class="table_format" cellpadding="0"
      cellspacing="0" width="100%" style="text-align: left;">
      <thead>
        <tr>
          <td colspan="5" width="100%">
          <table width="100%" style="font-weight: bold; margin-top: 60px;">
            <tr>
              <td width="330" valign="top">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td width="38%" height="" valign="top">Name</td>
                  <td align="left" valign="top"><?php
     
                  echo $complete_name  = $patient['Patient']['lookup_name'] ;
                  ?></td>
                </tr>
                <tr>
                  <td width="110" height="" valign="top" id="boxSpace3">Registration
                  ID</td>
                  <td align="left" valign="top"><?php echo $patient['Patient']['admission_id'] ;?></td>
                </tr>
                <tr>
                  <td valign="top" id="boxSpace3">Patient ID</td>
                  <td align="left" valign="top"><?php echo $patient['Patient']['patient_id'] ;?>
                  </td>
                </tr>
                <tr>
                  <td valign="top">Treating Consultant</td>
                  <td align="left" valign="top"><?php  
                  echo ucfirst($treating_consultant[0]['fullname']) ;?></td>
                </tr> 
                <?php if(!empty($corporate_name)){?>
                <tr>
                  <td valign="top">Sponsor</td>
                  <td><?php echo $corporate_name ;?></td>
                </tr>
                <?php } ?>
              </table>
              </td>
              <td width="30" valign="top">&nbsp;</td>
              <td width="350" valign="top">
              <table width="100%" border="0" cellspacing="0" cellpadding="2"> 
                <tr>
                  <td valign="top" id="boxSpace3">Invoice Date</td>
                  <td align="left" valign="top"><?php 
                    $currentDate = date("Y-m-d H:i:s") ;
                    echo $this->DateFormat->formatDate2Local($currentDate,Configure::read('date_format'),true);
                  ?></td>
                </tr>
                <tr>
                  <td valign="top" id="boxSpace3">Start of OP Process Date & Time</td>
                  <td align="left" valign="top"><?php 
                  if($patient['Patient']['form_received_on']){
                    $splitDateIn = explode(" ",$patient['Patient']['form_received_on']);
                    echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
                  }
                  else{
                    $splitDateIn = explode(" ",$patient['Patient']['create_time']);
                    echo $this->DateFormat->formatDate2Local($patient['Patient']['create_time'],Configure::read('date_format'),true);
                  } 
                  ?></td>
                </tr>
                <tr>
                  <td valign="top" id="boxSpace3"><?php echo $dynamicText ;?> Date & Time</td>
                  <td align="left" valign="top"><?php
              
                 if(isset($patient['Patient']['discharge_date']) && $patient['Patient']['discharge_date']!=''){
                 
                  echo $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),true);
                 }
              //echo $discharge_date ;
              ?></td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr class="">
          <td class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></td>
          <td class="table_cell"><strong><?php echo __('Service Name'); ?></strong></td>
          <td class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></td>
          <td class="table_cell" style="display:<?php echo $hideCGHSCol ;?>"><strong><?php echo __('CGHS Code'); ?></strong></td>
          <!-- <td class="table_cell"><strong><?php echo __('MOA Sr. No.'); ?></strong></td> -->
          <td class="table_cell" align="center"><strong><?php echo __('Qty'); ?></strong></td>
          <td class="table_cell" align="right"><strong><?php echo __('Amount'); ?></strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </thead>
      
      <?php   
 
      if(!empty($labDetail)){
        ?>
            <tr>
              <td colspan="6">
              <h3>Laboratory</h3>
              </td>
            </tr>
      <?php  }
      //BOF laboratory
      $i=1;
      $lCost = 0 ; $t=0;
      $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
      foreach($labDetail as $labKey=>$labCost){
        //if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
        if($labCost['LaboratoryTestOrder']['amount']){
          $lCost += $labCost['LaboratoryTestOrder']['amount'] ;
          $formalLabCost = $labCost['LaboratoryTestOrder']['amount'] ;
        }else{
          $lCost += $labCost['TariffAmount'][$hosType] ;
          $formalLabCost = $labCost['TariffAmount'][$hosType] ;
        }
      ?>
      <tr>
        <td valign="top" class="tdBorderTp"><?php echo $i++ ;?></td>
        <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $labCost['Laboratory']['name'];?></td>
        <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
        //echo $labCost['LaboratoryTestOrder']['create_time'];
        $splitDateIn = explode(" ",$labCost['LaboratoryTestOrder']['create_time']);
        echo $this->DateFormat->formatDate2Local($labCost['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true);
          
        ?></td>
        <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>">&nbsp;</td>
        <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
        <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($formalLabCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
      </tr>
      <?php
      //  }
    
      }
      if(!empty($labDetail)){
        ?>
      <tr>
        <td colspan="6">
        <div class="inner_title">
        <h3 style="float: left;">Sub Total</h3>
        <h3 style="float: right;"><?php 
        //echo $this->Html->image('icons/rupee_symbol.png');
        echo $lCost; ?></h3>
        <div class='clr'></div>
        </div>
        </td>
      </tr>
    
      <?php }
      //EOF cost check
      //EOF laboratory
      if(!empty($radiology)){
       ?>
      <tr>
        <td colspan="6">
        <h3>Radiology</h3>
        </td>
      </tr>
      <?php
      }
      //BOF radiology
      $j=1;
      $raCost = 0 ; $t=0;//echo '<pre>';print_r($radiology);
      $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
       
      foreach($radiology as $radKey=>$radCost){
        //if($radCost['RadiologyTestOrder']['test_done']=='true'){
        if($radCost['RadiologyTestOrder']['amount']){
          $raCost += $radCost['RadiologyTestOrder']['amount'] ;
          $formatCost  = $radCost['RadiologyTestOrder']['amount'];
        }else{
          $raCost += $radCost['RadiologyTestOrder'][$hosType] ;
          $formatCost  = $radCost['RadiologyTestOrder'][$hosType];          
        }  
        ?>
      <tr>
        <td valign="top" class="tdBorderTp"><?php echo $j++ ;?></td>
        <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $radCost['Radiology']['name'];?></td>
        <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
        //echo $radCost['RadiologyTestOrder']['create_time'];
        $splitDateIn = explode(" ",$radCost['RadiologyTestOrder']['radiology_order_date']);
        echo $this->DateFormat->formatDate2Local($radCost['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);         
        ?></td>
        <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>">&nbsp;</td>
        <td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
        <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($formatCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
      </tr>
      <?php
      //}   
      }
      //EOF laboratory
      if(!empty($radiology)){
        ?>
      <tr>
        <td colspan="6">
        <div class="inner_title">
        <h3 style="float: left;">Sub Total</h3>
        <h3 style="float: right;"><?php 
        //echo $this->Html->image('icons/rupee_symbol.png');
        echo $raCost; ?></h3>
        <div class='clr'></div>
        </div>
        </td>
      </tr>
    
      <?php } ?>
        <tr>
          <td colspan="3">
          <h3>Total Amount</h3>
          </td>
          <td colspan="3" align="right">
          <h3 style="float: right;"><?php  
          //echo $this->Html->image('icons/rupee_symbol.png');
          echo $lCost+$raCost; ?></h3>
          </td>
        </tr>
        <tr>
          <td colspan="5">In Words:&nbsp;<?php echo $this->RupeesToWords->no_to_words(round($lCost+$raCost));?></td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" align="right">Cashier</td>
        </tr>
        <tfoot id="table_footer" style="bottom: 0;">
          <tr>
            <td colspan="5" style=" display:none;">_____________________________________________________________________________________________________</td>
          </tr>
      
        </tfoot>
      </table>  
      <?php  } //EOF else part of OP Patient check?>
<script>
 $(document).ready(function(){
	 	var screenHeight = $(window).height();
	 	if(screenHeight < 800 ) screenHeight  = 800 ;	
		var tableFull = $("#fullTbl").height();	
		var tableHead = $("#tblHead").height();
		var tableContent = $("#tblContent").height();
		var tableFooter = $("#tblFooter").height();
		//  alert(tableFull);
		if(screenHeight > tableFull)
		{
			var requireHt = screenHeight - (tableFull);
			$("#addColumnHt").css("height", (requireHt+130)+"px");
		}
		else
		{
			var division = tableFull / screenHeight;
			 
			if(division < 1.07)
			{
				
				var requireHt = screenHeight - (tableFull);
				$("#addColumnHt").css("height", (requireHt+50)+"px");
			}
			else if(division > 1.07 && division < 2.36)// second page
			{
				var screenHeight = 842;
				var requireHt = (screenHeight*2) - tableFull;
				$("#addColumnHt").css("height", (requireHt+200)+"px");		
			}	
			else if(division > 2.36)// Third page
			{
				//alert(division);
				var screenHeight = 842;
				var requireHt = (screenHeight*3) - tableFull;
				$("#addColumnHt").css("height", (requireHt+430)+"px");
			}	
		}	
	 });
</script>
</body>
</html> 