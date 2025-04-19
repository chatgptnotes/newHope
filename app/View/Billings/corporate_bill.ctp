<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<?php echo $this->Html->css('internal_style.css'); ?>
<!--<link rel="stylesheet" type="text/css"
	href="http://cdn.webrupee.com/font" />-->
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
	
	.printIcons{
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
	/*border-top: 1px solid #3E474A;*/
	/*border-right: 1px solid #3E474A;*/
	border :1px solid #3E474A;
	padding: 4px;
}

.tdBorderRt {
	/*border-right: 1px solid #3E474A;*/
	border: 1px solid #3E474A;
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
#sub_total{
    display:none;
}
.total_amount h4 {
    text-align: center;
    padding:0px!important;
}
</style>
</head>
<!-- onload="javascript:window.print();" -->
<body class="print_form" >
<?php echo $this->Html->script('jquery-1.5.1.min.js'); ;?>
<!-- <div>&nbsp;</div> --> 
<table  width="200" style="float:right">
	<tr>
		<td align="right">
		<div id="printButton"><?php 
			echo $this->Html->link(__('Print', true),'#', array('escape' => false,'height'=>'50','class'=>'blueBtn','onclick'=>'window.print();window.close();'));?> </div>
		
		<div id="printButton"  style="float: left; padding-top: 10%; padding-left: 16%"><?php echo $this->Html->link('Generate Excel Report',array('controller'=>'billings',
				'action'=>'detail_payment',$patient['Patient']['id'],'?'=>array('type'=>'excel')),array('escape' => false,'class'=>'blueBtn'));?></div>
		</td>
		<td>
		
		</td>
	</tr>
</table>
<?php
		$website  = $this->Session->read('website.instance');
		if($website=='vadodara'){
?>
	<table width="800">
		<tr>
			<td><div><?php echo $this->element('vadodara_header');?> </div></td>
		</tr>
		<tr><td><div><?php echo $this->element('print_patient_info');?></div></td></tr>
	</table>
<?php } ?>
<?php 
//echo '<pre>';print_r($finalBillingData);exit;?>
<?php 			echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveGenerateReceipt','type' => 'file','id'=>'ConsultantBilling','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
			echo $this->Form->hidden('Billing.patient_id',array('value'=>$patient['Patient']['id']));
			echo $this->Form->hidden('Billing.bill_number',array('value'=>$billNumber)); 

			if($patient['TariffStandard']['name']){//to hode CGHS column  --yashwant
				$hideCGHSCol = '';
				if(strtolower($patient['TariffStandard']['name']) == 'private'){
					$hideCGHSCol = 'none' ;
				}else{
					$hideCGHSCol = '' ;
				}
			}
			?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="left" id="fullTbl" style="padding-left:3px <?php //echo $paddingLeft; ?>">
<tr>
<td>

		
<table width="800" border="0" cellspacing="0" cellpadding="0" margin-top:-34px;margin-bottom:-51px;
 style="margin-top:-34px<?php //echo $marginTop;?>;margin-bottom:-51px;" align="center">
<tr>
    <td width="100%" align="center" valign="top" class="heading" id="tblHead"><strong><?php 
    if($this->Session->read('website.instance')!='vadodara'){
    if($invoiceMode=='direct') echo 'PROVISIONAL INVOICE';
    else echo 'DETAILED INVOICE';
    }
    
    if($patient['Patient']['admission_type']=='IPD'){
  		$dynamicText = 'Discharge' ;
  	}else{
  		$dynamicText = 'completion of OPD process' ;
  	}
    ?></strong></td>
  </tr>
</table>		
		
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" id="tblContent">
 <tr>
         <th>&nbsp;</th> 
	</tr>  
			
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
    <?php
  if($this->Session->read('website.instance')!='vadodara'){?>
    
  <table width="800" border="0" cellspacing="0" cellpadding="5">
       <p align="center"style="margin: 0px !important;"><strong> <b>Final Bill</b></strong></p>
      <hr>
       
       <p align="center" style="margin: 0px !important; "><strong><b>
           <?php
        //      if (!empty($tariffname['TariffStandard']['name'])) {
        //     echo h($tariffname['TariffStandard']['name']);
        // } 
								?>
								<?php 
                                      if($patient['Patient']['corporate_sublocation_id']){
                                        $sublocationName = $subLocations[$patient['Patient']['corporate_sublocation_id']];
                                        echo $sublocationName;
                                      }else{
                                  		  echo $tariffData[$patient['Patient']['tariff_standard_id']];
                                      }
                                     ?></b></strong></p>
     <hr>
      <p align="center"style="margin: 0px !important;"><strong> <b>CLAIM ID: 356277</b></strong></p>
       <hr>
     <p align="right"  style="margin: 0px !important;padding: 10px;">Date : 	<b> <?php 
    
    if (isset($patient['Patient']['discharge_date']) && $patient['Patient']['discharge_date'] != '') {
    $splitDate = explode(" ", $patient['Patient']['discharge_date']); 
    $onlyDate = $splitDate[0]; 
    echo $this->DateFormat->formatDate2Local($onlyDate, Configure::read('date_format'), true);
    }

    ?></b> </p>
     <?php if($invoiceMode!='direct'){?>
  <tr>
    <td align="left" valign="top">BILL NO.</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $billNumber;?></td>
  </tr>
  <?php }?>
  <?php if($patient['Patient']['admission_id']!=''){
  	if($this->Session->read('website.instance')=='vadodara'){
  		$personUID='( '.$patient['Patient']['patient_id'].' )';
  	}else{
  		$personUID='';
  	}?>
  <tr>
    <td align="left" valign="top">REGISTRATION NO.</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $patient['Patient']['admission_id'].' '.$personUID;?></td>
  </tr>
  <?php }?>
  <tr>
    <td width="370" align="left" valign="top">NAME OF PATIENT</td>
    <td width="10" valign="top">:</td>
    <td valign="top"><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'];
    if($patient['Patient']['vip_chk']=='1'){
		echo __("  ( VIP )");
	}
    ?></td>
  </tr>
  <tr>
    <td align="left" valign="top">AGE</td>
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
		echo $age;
	}
?>
    </td>
  </tr> 
  <tr>
    <td width="370" align="left" valign="top">SEX</td>
    <td width="10" valign="top">:</td>
    <td valign="top"><?php	echo ucfirst($patient['Person']['sex']);
   
    ?></td>
  </tr>
  
  <?php if($patient['Person']['name_of_ip']!=''){?>
  <tr>
    <td align="left" valign="top">NAME OF 	<?php 
                                      if($patient['Patient']['corporate_sublocation_id']){
                                        $sublocationName = $subLocations[$patient['Patient']['corporate_sublocation_id']];
                                        echo $sublocationName;
                                      }else{
                                  		  echo $tariffData[$patient['Patient']['tariff_standard_id']];
                                      }
                                     ?> BENEFICIARY</td>
    <td valign="top">:</td>
    <td valign="top"><?php //echo $patient['Patient']['lookup_name'];
			//echo $this->Form->input('Billing.name_of_ip',array('value'=>$person['Person']['name_of_ip'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'name_of_ip','style'=>'width:150px;'));
			echo $patient['Person']['name_of_ip'];
			?></td>
  </tr>
  <?php }?>
  <?php if($patient['Person']['relation_to_employee']!=''){?>
  <tr>
    <td align="left" valign="top">RELATION WITH 	<?php 
                                      if($patient['Patient']['corporate_sublocation_id']){
                                        $sublocationName = $subLocations[$patient['Patient']['corporate_sublocation_id']];
                                        echo $sublocationName;
                                      }else{
                                  		  echo $tariffData[$patient['Patient']['tariff_standard_id']];
                                      }
                                     ?> EMPLOYEE</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    //echo $this->Form->input('Billing.relation_to_employee',array('value'=>$person['Person']['relation_to_employee'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'relation_to_employee','style'=>'width:150px;'));
    $relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
    echo $relation[$patient['Person']['relation_to_employee']];
    ?></td>
  </tr>
  <?php }?>
  
  <?php //if($patient['Person']['plot_no']!='' || $patient['Person']['taluka']!='' || $patient['Person']['city']!='' || $patient['Person']['district']!=''){
    if(!empty($address)){?>
  <tr>
    <td align="left" valign="top">ADDRESS</td>
    <td valign="top">:</td>
    <td valign="top"> <?php echo $address ?></td>
  </tr>
  <?php }?>
  
  <!-- designation added by @7387737062-->
  <tr>
  
    <td align="left" valign="top">DESIGNATION</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
        if (!empty($patientdesignation['Patient']['designation'])) {
            echo h($patientdesignation['Patient']['designation']);
        } 
        
        ?></td>
  </tr>
  
  
  <?php if($patient['Person']['insurance_number']!='' || $patient['Person']['executive_emp_id_no']!='' || $patient['Person']['non_executive_emp_id_no']!=''){?>
  <tr>
    <!--<td align="left" valign="top">Insurance Number/Staff Card No/Pensioner Card No.</td>-->
    <td align="left" valign="top">EMPLOYEE ID NO.</td>
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
  <tr>
    <!--<td align="left" valign="top">Insurance Number/Staff Card No/Pensioner Card No.</td>-->
    <td align="left" valign="top">CONTACT NO.</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    echo'NOT AVAILABLE';
   
    ?></td>
  </tr>
 
  <tr>
    <td align="left" valign="top">BED CATEGORY </td>
    <td valign="top">:</td>
    <td valign="top"><?php 
            if (!empty($patientdesignation['Patient']['corporate_status'])) {
            // Create a mapping array for statuses
            $statusMapping = [
                1 => 'General',
                2 => 'Semi-Private',
                3 => 'Private'
            ];
        
            // Get the corporate status value
            $statusValue = $patientdesignation['Patient']['corporate_status'];
        
            // Check if the value exists in the mapping and print it
            echo isset($statusMapping[$statusValue]) 
                ? h($statusMapping[$statusValue]) 
                : 'Unknown'; // Default if no match found
        }

    
    //   if($patient['Patient']['corporate_sublocation_id']){
    //     $sublocationName = $subLocations[$patient['Patient']['corporate_sublocation_id']];
    //     echo $sublocationName;
    //   }else{
  		//   echo $tariffData[$patient['Patient']['tariff_standard_id']];
    //   }
      ?>
    </td>
  </tr>
  <?php }?>
   <tr>
    <!--<td align="left" valign="top">Insurance Number/Staff Card No/Pensioner Card No.</td>-->
    <td align="left" valign="top">UNITE NAME.</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    echo'NOT AVAILABLE';
   
    ?></td>
  </tr>
  <tr>
    <!--<td align="left" valign="top">Insurance Number/Staff Card No/Pensioner Card No.</td>-->
     <?php if($diagnosisData['Diagnosis']['final_diagnosis']!=''){?>
    <td align="left" valign="top">DAIGNOSYS</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    echo $diagnosisData['Diagnosis']['final_diagnosis'];  }
   
    ?></td>
  </tr>
 
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
    <td align="left" valign="top">DATE OF ADMISSION</td>
    <td valign="top">:</td>
    <td valign="top">
    <?php 
    // $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
    //               	  	  	echo 
    //               	  	  	$this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
    // comment by @7387737062 beacause date of registration not fetching
    
    if (!empty($patientdesignation['Patient']['designation'])) {
        echo $this->DateFormat->formatDate2Local($patientdesignation['Patient']['create_time'],Configure::read('date_format'),true);
           
        } 
                   	  	  	?>
                   	  	  	
                   	  	  	</td>
  </tr>
  <?php }?>
  <?php if($finalBillingData['FinalBilling']['discharge_date']!='' && $finalBillingData['FinalBilling']['discharge_date']!='0000-00-00 00:00:00'){?>
   <tr>
    <td align="left" valign="top">Date Of  <?php echo $dynamicText ;?></td>
    <td valign="top">:</td>
    <td valign="top"><?php
              
   if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
   	$splitDate = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
   	echo $this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true);
   }
   ?></td>
  </tr>
  <?php } else {	//else part by swapnil - 18.02.2016 if discharge_date is not present in finalbilling, retrieve date from patient?>
	  <tr>
		<td align="left" valign="top">DATE OF  <?php echo strtoupper($dynamicText);?></td>
		<td valign="top">:</td>
		<td valign="top"><?php
				  
	   if(isset($patient['Patient']['discharge_date']) && $patient['Patient']['discharge_date']!=''){
		$splitDate = explode(" ",$patient['Patient']['discharge_date']); 
		echo $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),true);
	   }
	   ?></td>
	  </tr>
  <?php } ?>
  <?php if($finalBillingData['FinalBilling']['patient_discharge_condition']!=''){?>
  <tr>
    <td align="left" valign="top">Condition of the patient on <?php echo $dynamicText ;?></td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    echo $finalBillingData['FinalBilling']['patient_discharge_condition'];
    ?></td>
  </tr>
  <?php }?>
  
  <?php if($corporateEmp!=''){
  		$hideCGHSCol = '';
  		if(strtolower($corporateEmp) == 'private'){
  			$hideCGHSCol = 'none' ;
  		}
  ?>
 
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
  <tr style="display:none">
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
</table><?php }?>
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
  <tr style="display:none">
      <td><table width="100%" cellpadding="5" cellspacing="0" border="0" style="">
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
            </table></td>
            </tr>
  
  <tr>
   
  </tr>
  <tfoot id="table_footer" >
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr><tr>
			<td colspan="5">&nbsp;</td>
		</tr>

	</tfoot>
  </table>
  <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" id="tblFooter" style="display: none;">
	<tr>
	    <td width="100%" align="left" valign="top" class="">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="display: none;">
	          <tr>
	            <td valign="top" class="boxBorderRight columnPad">
	            	Amount Chargeable (in words)<br />
					<strong><?php echo $this->RupeesToWords->no_to_words(round($totalCost));?></strong>            </td>
	            	<td width="292" class="tdBorderRt">
	            	<table width="100%" cellpadding="0" cellspacing="0" border="0" >
	                	<tr>
	                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Amount Paid</td>
	                        <td align="right" valign="top" class="tdBorderBt"><?php 
	                        //echo $this->Html->image('icons/rupee_symbol.png');
	                        echo $this->Number->currency(round($totalAdvancePaid)-round($paidReturnForPharmacyInInvoice['pharmacy'][0]['total'])
	                        		-round($paidReturnForPharmacyInInvoice['otpharmacy'][0]['total']));
	                        echo $this->Form->hidden('Billing.amount_paid',array('value' => ($totalAdvancePaid),'legend'=>false,'label'=>false));
	                        ?></td>
	                    </tr>
	                    
	                    <?php 
	                    
	                  /*  if(isset($finalBillingData['FinalBilling']['discount_type']) && $finalBillingData['FinalBilling']['discount'] !=''){
	                        	$discountAmount = $finalBillingData['FinalBilling']['discount'];
	                    }else{
	                        	$discountAmount=0;
	                    }*/

						if($totalDiscountGiven[0]['sumDiscount']){
							$discountAmount=$totalDiscountGiven[0]['sumDiscount']-round($paidReturnForPharmacyInInvoice['pharmacy'][0]['total_discount'])
								-round($paidReturnForPharmacyInInvoice['otpharmacy'][0]['total_discount']);
						}else{
							$discountAmount='';
						}

	                    if($discountAmount != '' && $discountAmount!=0){
	                    ?>
	                    
	                    <tr>
	                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Discount</td>
	                        <td align="right" valign="top" class="tdBorderBt"><?php  
	                        echo $this->Number->currency(round($discountAmount)); 
	                        ?></td>
	                    </tr><!--
	                    No need to discount reasons to patient 
	                    <tr>
	                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Reason for Discount</td>
	                        <td align="right" valign="top" class="tdBorderBt"><?php 
	                        	//echo $finalBillingData['FinalBilling']['reason_for_discount'];
	                        	//echo $this->Form->hidden('Billing.reason_for_discount',array('value' => $finalBillingData['FinalBilling']['reason_for_discount'],'legend'=>false,'label'=>false));
	                        ?></td>
	                    </tr> 
	                    --><?php }?>
	                    
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
	                	  <td align="right" class="tdBorderBt"><?php 
					        //if($discountData['FinalBilling']['refund']=='1'){
								//echo $totalRefund=$discountData['FinalBilling']['paid_to_patient'];
								echo $this->Number->currency(round($totalRefund));
							//}else{
							//	$totalRefund='0';
							//}?>
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
	                	  echo $this->Number->currency(round($totalCost-$totalAdvancePaid-$discountAmount+$totalRefund));
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
	            <td width="45%" align="right" valign="bottom" class="columnPad tdBorderTp tdBorderRt tdBorderTpBt">
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
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<!--new table start here by @7387737062-->
		<tr class="tbl">
		
			<td class="table_cell" width="10%" style="border-left:1px solid #3e474a;"><strong><?php echo __('SR.NO.'); ?></strong></td>
			<td class="table_cell" style="border-left:1px solid #3e474a;" align ="center"><strong><?php echo __('ITEM'); ?></strong></td>
			<td class="table_cell" style="border:1px solid #3e474a;"><strong><?php echo __('Date & Time'); ?></strong></td>
			<td class="table_cell" style="display:<?php echo $hideCGHSCol ;?>" style="border-left:1px solid #3e474a;border-right:1px solid #3e474a;"><strong><?php echo __('CGHS NABH CODE NO'); ?></strong></td>
			<!-- <td class="table_cell"><strong><?php echo __('MOA Sr. No.'); ?></strong></td> -->
			<td class="table_cell" align="center" style="border-left:1px solid #3e474a;"><strong><?php echo __('QTY/DAYS'); ?></strong></td>
			<td class="table_cell" align="right" style="border-left:1px solid #3e474a;border-right:1px solid #3e474a;"><strong><?php echo __('CGHS NABH RATE'); ?></strong></td>
              
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
				//	$splitDateOut  = explode(" ",$bedCost[0]['in']);
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
	<tr id="sub_total">
		<td colspan="6">
		<div class="inner_title" style="border-left:1px solid #3e474a; border-right:1px solid #3e474a; display:none">

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
	<tr id="sub_total">
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
	<tr id="sub_total">
		<td colspan="6">
		<div class="inner_title" style="border-left:1px solid #3e474a; border-right:1px solid #3e474a; display:none">
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
		$splitDateIn = explode(" ",$labCost['LaboratoryTestOrder']['start_date']);
		echo $this->DateFormat->formatDate2Local($labCost['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true); 
		?></td>
		<td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>"><?php echo $labCost['TariffList']['cghs_code'];?></td>
		<td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
		<td align="right" valign="top" class="tdBorderTp"><?php 
		//echo $this->Number->format($labCost['TariffAmount'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		echo $this->Number->format($labCost['LaboratoryTestOrder']['amount']);?></td>
	</tr>
	<?php
	//	}

	}
	if(!empty($labRate)){
		?>
	<tr id="sub_total">
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
	<tr id="sub_total">
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
	<tr id="sub_total">
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
	<tr id="sub_total">
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
		<td align="center" valign="top" class="tdBorderRt tdBorderTp" >&nbsp;</td>
		<td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>
		<td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($impalntCost['TariffAmount'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
	</tr>
	<?php
	//}

	}
	//EOF laboratory
	if(!empty($implant)){
		?>
	<tr id="sub_total">
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
	<tr id="sub_total">
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
	<!--start surgery and charges @7387737062-->
	<?php 
// <?php 
if (!empty($surgeriesData)) { 
   $corporateStatus = isset($patientdesignation['Patient']['corporate_status']) ? $patientdesignation['Patient']['corporate_status'] : null;
 // Corporate Status
    $j = 1;
    $surgeryServicesCost = 0; // Total surgery cost
    $firstSurgeryAdjustedCost = 0; // Adjusted cost of the first surgery for Status 3

    ?>
    <tr>
        <td colspan="6">
            <h3>Surgeries Services</h3>
        </td>
    </tr>
    <?php
    foreach ($surgeriesData as $surgeryKey => $surgery) {
        $originalCost = $surgery['OptAppointment']['surgery_cost']; // Original surgery cost
        $calculatedCost = $originalCost;

        // Apply logic based on corporate status
        if ($corporateStatus == 1) {
            if ($j == 1) {
                // First surgery: 10% discount
                $calculatedCost = $originalCost - ($originalCost * 0.10);
            } else {
                // Other surgeries: 10% discount, then 50% of remaining
                $calculatedCost = ($originalCost - ($originalCost * 0.10)) * 0.50;
            }
        } elseif ($corporateStatus == 2) {
            if ($j == 1) {
                // First surgery remains the same as status 1
                $calculatedCost = $originalCost - ($originalCost * 0.10);
            } else {
                // Other surgeries: 50% of original cost
                $calculatedCost = $originalCost * 0.50;
            }
        } elseif ($corporateStatus == 3) {
            if ($j == 1) {
                // First surgery: original cost + 15%
                $calculatedCost = $originalCost + ($originalCost * 0.15);
                $firstSurgeryAdjustedCost = $calculatedCost; // Save adjusted cost for later use
            } else {
                // Other surgeries: Adjusted first surgery cost - 50%
                $calculatedCost = $firstSurgeryAdjustedCost * 0.50;
            }
        }

        $surgeryServicesCost += $calculatedCost; // Add to total surgery cost
        ?>
        <tr>
            <td valign="top" class="tdBorderTp"><?php echo $j++; ?></td>
            <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $surgery['TariffList']['name']; ?></td>
            <td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;
                <?php 
                echo $this->DateFormat->formatDate2Local($surgery['OptAppointment']['starttime'], Configure::read('date_format'), true); 
                ?>
            </td>
            <td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ; ?>"><?php echo $surgery['TariffList']['cghs_code'];?></td>
            <!--<td align="center" valign="top" class="tdBorderRt tdBorderTp">1</td>-->
           <td align="center" valign="top" class="tdBorderRt tdBorderTp">
        <?php 
            $originalCost = $surgery['OptAppointment']['surgery_cost']; // मूल लागत
            $adjustedCost = $originalCost; // समायोजित लागत की डिफॉल्ट वैल्यू

            // Corporate Status के आधार पर Adjustments करें
            if ($corporateStatus == 1) {
                if ($j == 2) { 
                    $adjustedCost = $originalCost * 0.9; // 10% कम करें
                } elseif ($j > 2) {
                    $adjustedCost = ($originalCost * 0.9) * 0.5; // 50% कम करें
                }
            } elseif ($corporateStatus == 2) {
                if ($j == 2) { 
                    $adjustedCost = $originalCost * 0.5; // 50% कम करें
                }
            } elseif ($corporateStatus == 3) {
                if ($j == 1) {
                    $adjustedCost = $originalCost * 1.15; // 15% बढ़ाएं
                } else {
                    $adjustedCost = $originalCost * 0.5; // 50% कम करें
                }
            }

            // "Less: 10% Gen. Ward Charges as per CGHS Guidelines" 
            $discount = $originalCost * 0.1; // 10% डिस्काउंट
            $finalAmount = $originalCost - $discount; // डिस्काउंट के बाद नया अमाउंट

            // दोनों कॉस्ट दिखाएं (Actual, Less Discount and Adjusted)
            echo "Less: 10% Gen. Ward Charges as per CGHS Guidelines<br>";
            echo "Actual: " . $this->Number->format($originalCost, array('places' => 2, 'decimal' => '.', 'before' => false, 'thousands' => false)) . "<br>";
            echo "Discount: " . $this->Number->format($discount, array('places' => 2, 'decimal' => '.', 'before' => false, 'thousands' => false)) . "<br>";
            echo "Total after Discount: " . $this->Number->format($finalAmount, array('places' => 2, 'decimal' => '.', 'before' => false, 'thousands' => false)) . "<br>";
            echo "Adjusted: " . $this->Number->format($adjustedCost, array('places' => 2, 'decimal' => '.', 'before' => false, 'thousands' => false));
        ?>
    </td>
            <td align="right" valign="top" class="tdBorderTp"><?php echo $this->Number->format($calculatedCost, array('places' => 2, 'decimal' => '.', 'before' => false, 'thousands' => false)); ?></td>
        </tr>
        <?php 
    } 
    ?>
    <tr id="sub_total">
        <td colspan="6">
            <div class="inner_title">
                <h3 style="float: left;">Sub Total</h3>
                <h3 style="float: right;"><?php echo $surgeryServicesCost; ?></h3>
                <div class='clr'></div>
            </div>
        </td>
    </tr>
<?php 
} 
?>


          	<!--End surgery and charges @7387737062-->
	<!-- My Changes Ends -->
	<tr>
		<td class="tdBorderRt total_amount" colspan="3" align="right">
		<h4 >Total Amount</h4>
		</td>
		<td class="tdBorderTp" colspan="3" align="right">
		<h3 style="float: right;"><?php  
		//echo $this->Html->image('icons/rupee_symbol.png');
		echo $rCost+$pCost+$lCost+$raCost+$dCost+$sCost+$otherServicesCost+$surgeryServicesCost; ?></h3>
		</td>
		<!--$totalCost = $rCost + $pCost + $lCost + $raCost + $dCost + $sCost + $otherServicesCost + $surgeryServicesCost;-->
	</tr>
	<tr>
		<td colspan="5" align="center" style="padding:4px !important"><b>In Words:</b>&nbsp;<?php echo $this->RupeesToWords->no_to_words(round($rCost+$pCost+$lCost+$raCost+$dCost+$sCost+$otherServicesCost+$surgeryServicesCost));?></td>
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
	<tr style="padding: 5px !important">	<td colspan="1" align="center">Bill Manager</td>
	    	<td colspan="1" align="right">Cashier</td>
	    	<td colspan="1" align="right">Med. Supdt</td>
		<td colspan="2" align="right">Authorised Signature</td>
	</tr>
	<tfoot id="table_footer" style="bottom: 0;">
		<tr>
			<td colspan="5" style="display:;">_____________________________________________________________________________________________________</td>
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
			//	}
		
			}
			if(!empty($labDetail)){
				?>
			<tr id="sub_total">
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
			<tr id="sub_total">
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
				// 	echo 'ashwin da';
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


