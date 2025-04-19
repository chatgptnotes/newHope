<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset();

$website=$this->Session->read("website.instance");
if($website=='kanpur')
	$marginLeft="0px";
else
	$marginLeft="0px";
?>
<title>
</title>
	<?php echo $this->Html->css(array('internal_style.css')); ?>
	<style>
		body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#E7EEEF;}

 
		.boxBorder{border:1px solid #3E474A;}
		.boxBorderBot{border-bottom:1px solid #3E474A;}
		.boxBorderRight{border-right:1px solid #3E474A;}
		.tdBorderRtBt{border-right:1px solid #3E474A; border-bottom:1px solid #3E474A;}
		.tdBorderBt{border-bottom:1px solid #3E474A;}
		.tdBorderTp{border-top:1px solid #3E474A;}
		.tdBorderRt{border-right:1px solid #3E474A;}
		.tdBorderTpBt{border-bottom:1px solid #3E474A; border-top:1px solid #3E474A;}
		.tdBorderTpRt{border-top:1px solid #3E474A; border-right:1px solid #3E474A;}
		.columnPad{padding:5px;}
		.columnLeftPad{padding-left:5px;}
		.tbl{background:#CCCCCC;}
		.tbl td{background:#FFFFFF;}
		.totalPrice{font-size:14px;}
		.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}

		
<?php if($this->Session->read('website.instance')!='vadodara'){?>	 
 @page{
	size: auto;   
	margin-top: 37mm;
 }
 <?php }?>
 @page:last{
	@bottom {
      content: element(tblFooter);
    }
 }
 

	</style>
	<style>
	.print_form{
		background:none;
		font-color:black;
		color:#000000;
		min-height:800px;
	}
	.formFull td{
		color:#000000;
	}
	.tabularForm {
	    background:#000;
	}
	.tabularForm td {
	    background: #ffffff;
	    color: #333333;
	    font-size: 13px;
	    padding: 5px 8px;
	}
	@media print {
		#printButton {
			display: none;
		}
		
		#hideFromPage{
		display: none;
		}
                .discountBtn{
                 display: none !important;
                }
	}
	
	
	</style>
</head>
<!-- onload="javascript:window.print();" -->
<body class="print_form" >
<?php echo $this->Html->script('jquery-1.5.1.min.js'); ;?>
<!-- <div>&nbsp;</div> --> 

 
<table width="200" style="float:right">
	<tr>
		<td align="right">
		<div id="printButton"><?php 

		echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
		?></div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
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
 <!-- Do not remove this table as it is used to separate header print page by pankaj w :) --> 
 
 <?php $hospitaType = $this->Session->read('hospitaltype');
          if($hospitaType == 'NABH'){
          	$nabhType='nabh_charges';
          }else{
          	$nabhType='non_nabh_charges';
          }
?>
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
				if(strtolower($patient['TariffStandard']['name']) == 'private' || strtolower($patient['TariffStandard']['name']) == 'raymonds' || strtolower($patient['TariffStandard']['name']) == 'mahindra & mahindra'|| $patient['TariffStandard']['tariff_standard_type']=='TPA'){
					$hideCGHSCol = 'none' ;
				}else{
					$hideCGHSCol = '' ;
				}
			}
		
			?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" id="fullTbl" class="boxBorder headerInfo" style="margin-left: <?php echo $marginLeft;?>">
<thead>
<tr>
<td>  
<table style="" width="800" border="0" cellspacing="0" cellpadding="0" align="center" >
	
		   
	<tr>
    <td  width="100%" align="center" valign="top" class="heading" id="tblHead"><strong><?php 
    //if($invoiceMode=='direct') echo 'PROVISIONAL INVOICE';
    //else echo 'INVOICE';
     if($this->Session->read('website.instance')!='hope'){
        echo 'PROVISIONAL INVOICE';
       }
    if($patient['Patient']['admission_type']=='IPD'){
  		$dynamicText = 'Discharge' ;
  	}else{
  		$dynamicText = 'completion of OPD process' ;
  	}
    ?></strong></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
    <?php if($this->Session->read('website.instance')!='vadodara'){
           ?>
         <table width="800" border="0" cellspacing="0" cellpadding="3" class="tdBorderTp">
 
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
			echo $person['Person']['name_of_ip'];
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
    <td valign="top"><?php 
    	echo $patient['Person']['age']."/".ucfirst($patient['Person']['sex']);
    ?></td>
  </tr> 
  <?php 
    //if($patient['Person']['plot_no']!='' || $patient['Person']['taluka']!='' || $patient['Person']['city']!='' || $patient['Person']['district']!=''){
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
  <?php //echo "<pre>"; print_r($patient); ?>
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
  <?php if($finalBillingData['FinalBilling']['discharge_date']!='' && $finalBillingData['FinalBilling']['discharge_date']!='0000-00-00 00:00:00'){?>
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
  <?php } else {	//else part by swapnil - 18.02.2016 if discharge_date is not present in finalbilling, retrieve date from patient?>
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
  <?php if($invoiceMode!='direct'){?>
  <tr>
    <td align="left" valign="top">Invoice No.</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $billNumber;?></td>
  </tr>
  <?php }?>
  <?php if($patient['Patient']['admission_id']!=''){
  		if($this->Session->read('website.instance')=='vadodara'){
  			$personUID='( '.$patient['Patient']['patient_id'].' )';
  		}else{
  			$personUID='';
  		} ?>
  <tr>
    <td align="left" valign="top">Registration No.</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $patient['Patient']['admission_id'].' '.$personUID;?></td>
  </tr>
  <?php }?>
  
  <?php   
  if($corporateEmp!=''){
  		$hideCGHSCol = '';
		//echo $corporateEmp ;
  		if(strtolower($corporateEmp) == 'private'   || strtolower($patient['TariffStandard']['name']) == 'raymonds' || strtolower($patient['TariffStandard']['name']) == 'mahindra & mahindra' || $patient['TariffStandard']['tariff_standard_type']=='TPA'){
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
	<?php }?>
	</td></tr></table>
	</td></tr>
	</thead>
	<tbody>
   
  <?php 
  $hospitalType = $this->Session->read('hospitaltype');
   			if($hospitalType == 'NABH'){
   				$nabhKey = 'nabh_charges';
   				$nabhKeyC = 'cghs_nabh';
   			}else{
   				$nabhKey = 'non_nabh_charges';
   				$nabhKeyC = 'cghs_non_nabh';
   			}
   //Name field for services for cghs patient - pooja	
   $nameField='';
   if(strtolower($patient['TariffStandard']['name'])=='cghs' && Configure::read('show_cghs_name')==1){
   		$nameField='cghs_alias_name';
   }else{
   		$nameField='name';
   }  			
  ?>
  <tr><td>  
  <table width="100%">
  <tr><td>
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
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
                    $b=1;//debug($surgeriesData);
                foreach($surgeriesData as $surg){
                    	if($b==1 && $surg['TariffList'][$nameField]!=''){ 
                    		echo $b.'. '.$surg['TariffList'][$nameField];
                    		$b++;
                    	}
                    	else if($surg['TariffList'][$nameField] != ''){
                    		echo ', '.$b.'. '.$surg['TariffList'][$nameField];
                    		$b++;
                    	}
                    }
   
  ?>
                    </td>
                </tr>
          <?php }?>  
         <?php if($this->Session->read('website.instance')=='hope') {?>
            <tr id='hideFromPage'>
            
               <td  align="right" ><?php
		            /*if($pharmConfig['addChargesInInvoice']=='yes'){
		            	$buttonLabel="Hide Pharmacy Charge";
		            }else{
		            	$buttonLabel="Show Pharmacy Charge";
		            }*/

                if($this->params->query['showPhar']){
                  $buttonLabel="Hide Pharmacy Charge";
                }else{
                  $buttonLabel="Show Pharmacy Charge";
                }
		            
		            echo $this->Form->submit($buttonLabel,array('style'=>'','type'=>'button','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'showPharm'));?>
		      </td>
		    </tr>  
		    <?php }?>
	
            </table></td></tr> 
  <tr>
    <td width="100%" align="left" valign="top">
       <table width="100%" border="0" cellspacing="0" cellpadding="5" class="tdBorderTpBt">
          <tr>
          <td width="2%" align="center" class="tdBorderRtBt">Sr. No.</td>          
          <?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?> //MOA no. not required, removed as per disscussion with murali sir, w sir  --yashwant
          <td width="14%" align="center" class="tdBorderRtBt"><?php echo $patient['TariffStandards']['name'];?> MOA Sr. No.</td>
          <?php }*/?>          
            <td align="center" class="tdBorderRtBt" width="54%">Item</td>
            <td width="14%" align="center" class="tdBorderRtBt" style="display:<?php echo $hideCGHSCol ;?>">CGHS Code No.</td>
            <td width="14%" align="center" class="tdBorderRtBt">Rate</td>
            <td width="14%" align="center" class="tdBorderRtBt">Qty.</td>
            <td width="14%" align="center" class="tdBorderBt tdBorderRt">Amount</td>
          </tr>
          <?php $srNo=0;?>
          <?php
          /**
           * for private package [Package detail and cost]gaurav
           */$totalCost=0;
           if($privatePackageData){
          $srNo++;
          $startDate = $this->DateFormat->formatDate2Local($privatePackageData['startDate'],Configure::read('date_format'),true);
          $endDate = $this->DateFormat->formatDate2Local($privatePackageData['endDate'],Configure::read('date_format'),true);
          	?>
          <tr>
          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
          	<td class="tdBorderRt" style="font-size:12px;"><i><strong><?php echo $privatePackageData['packageName'];?></strong> </i></br>
		           <?php echo "<i>(".$startDate."-".$endDate.")</i>";?>
		    </td>
          	<td align="right" class="tdBorderRt"><?php echo $privatePackageData['packageAmount'] ;  ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php echo '--';  ?></td>
            <td align="right" valign="top"><?php echo $privatePackageData['packageAmount']; ?></td>
          </tr>
          <?php $totalCost = $totalCost + ($privatePackageData['packageAmount']);?>
          <?php }?>
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
          <?php }  ?>
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
          
           <?php $v=0; 
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
		  $totalCost = $totalCost+$pharmacy_charges/*-$pharmacyPaidAmount*/;//+$ward_charges;
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
          foreach($wardServicesDataNew as $uniqueSlot){//debug($uniqueSlot);
          	$srNo++;
          		if(isset($uniqueSlot[$nameField])){
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
		            		$endOfSurgery = strtotime($uniqueSlot['start']." +".$uniqueSlot['validity']." days");
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
				            echo $uniqueSlot[$nameField];
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
		          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
		          	
		          	<?php /*if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
		          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['moa_sr_no'];?></td>
		          	<?php }*/?>
		          	
		            <td class="tdBorderRt" style="padding-left:10px;"><?php 
			            echo $uniqueSlot[$nameField].'('.$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true).')</br>'; 
			            //echo '&nbsp;&nbsp;&nbsp;&nbsp;Surgery Charges' ;
			            
			            /** gaurav OT Rule Charges*/
			            if($uniqueSlot['doctor']){
			            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Fees' ;
			            	echo '<i> ('.rtrim($uniqueSlot['doctor'].','.$uniqueSlot['doctor_education'],',').')</i>';
			            }
			            if($uniqueSlot['asst_surgeon_one']){
			            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon I Fees' ;
			            	echo '<i> ('.rtrim($uniqueSlot['asst_surgeon_one'],',').')</i>';
			            }
			            if($uniqueSlot['asst_surgeon_two']){
			            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon II Fees' ;
			            	echo '<i> ('.rtrim($uniqueSlot['asst_surgeon_two'],',').')</i>';
			            }
			            //anaesthesia charges
			            echo ($uniqueSlot['anaesthesist'])?'<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Fees':'' ;
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
			   			$valueForSurgeon =  $uniqueSlot[$nameField].'('.
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
		            
			        echo "<br><br>".$uniqueSlot['cost'];
		            echo (!empty($uniqueSlot['doctor']))?$uniqueSlot['surgeon_cost']:'';
		            echo (!empty($uniqueSlot['asst_surgeon_one'])) ? "<br>".$uniqueSlot['asst_surgeon_one_charge']:'';
		            echo (!empty($uniqueSlot['asst_surgeon_two'])) ? "<br>".$uniqueSlot['asst_surgeon_two_charge']:'';
		            echo (!empty($uniqueSlot['anaesthesist'])) ? "<br>".$uniqueSlot['anaesthesist_cost'] : '';
		            echo (!empty($uniqueSlot['cardiologist'])) ? "<br>".$uniqueSlot['cardiologist_charge'] : '';
		            echo (!empty($uniqueSlot['ot_assistant'])) ? "<br>".$uniqueSlot['ot_assistant'] : '';
		            echo (!empty($uniqueSlot['ot_charges'])) ? "<br>".$uniqueSlot['ot_charges'] : '';
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
		            
		            echo '<br>';
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
		            echo "<br><br>".$uniqueSlot['cost'];
		            echo (!empty($uniqueSlot['doctor']))? $uniqueSlot['surgeon_cost']:'';
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
            //echo $this->Number->format((round($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo (round($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100));
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $doctorRate;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => round($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo 1;
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format((round($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format((round($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo round($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100);
            $anesthesiaCharges = $anesthesiaCharges + round($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100);
            ?></td>
          	</tr>
          	
          <?php }
          }
          }
          
          // Anesthesia Charges Ends
          
          
          if($totalWardDays>0){
          	 
          ?>
           <?php if($doctorRate!='' && $doctorRate!=0 && $this->params->query['privatePackage'] == ''){ // privatePackage condition for packaged patient gaurav
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
          	<?php if($nursingRate!='' && $nursingRate!=0 && $this->params->query['privatePackage'] == ''){ // privatePackage condition for packaged patient gaurav
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
          <?php /**if($doctorRate!='' && $doctorRate!=0 ){
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
			$resetNursingServices  = array() ;
		   	foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){ 
				$nursingCnt = $nursingServicesCost['TariffList']['id'] ; 
				$resetNursingServices[$nursingCnt]['qty'] = $resetNursingServices[$nursingCnt]['qty']+$nursingServicesCost['ServiceBill']['no_of_times'];
				$resetNursingServices[$nursingCnt]['name'] = ucfirst($nursingServicesCost['TariffList'][$nameField]) ; 
				$resetNursingServices[$nursingCnt]['amount'] = $nursingServicesCost['ServiceBill']['amount'] ;
				//For editted charges - Pooja
				$resetNursingServices[$nursingCnt]['cost'] = $resetNursingServices[$nursingCnt]['cost']+($nursingServicesCost['ServiceBill']['amount']*$nursingServicesCost['ServiceBill']['no_of_times']);
				$resetNursingServices[$nursingCnt]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
				$resetNursingServices[$nursingCnt]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code']; 
			//	$nursingCnt++;
		   	}
		    
		   	
		   	 
	   		//EOF pankaj
		  	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Nursing Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		  	//if($patient['TariffStandard']['tariff_standard_type']!='TPA'){//Comment by pooja as ther services list is not coming for tps patients
		      	foreach($resetNursingServices as $resetNursingServicesName=>$nursingService){
 
				$k++;
				$totalUnit= $nursingService['qty'];  
				$srNo++;
				
				echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][name]",'value' => $nursingService['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));

				/*if($srNo%14==0){
					?>
					<tr class="page-break"><td>&nbsp;</td></tr>
					<?php
				}*/
				
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
		            <?php } */?> 
		            <td class="tdBorderRt"><?php echo $nursingService['name'];?></td>
		            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
			            if($nursingService['nabh_non_nabh']!='')
			            	echo $nursingService['nabh_non_nabh'];
			            else echo '&nbsp;';
			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][nabh_non_nabh]",'value' => $nursingService['nabh_non_nabh'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			            ?>
		            </td>
		            <td align="right" valign="top" class="tdBorderRt"><?php
		                 //$totalUnit = array_sum($nursingService['qty']);
						  echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $nursingService['amount'],'legend'=>false,'label'=>false,'id' => 'nursing_service_rate','style'=>'text-align:right;'));
		
						  $star='';$unitsAmt='';$actualCost='';				  
						  $unitsAmt=round($totalUnit*$nursingService['amount']);
						  $actualCost=$nursingService['cost'];
						  if($unitsAmt!=$actualCost){//Checking that the total service amt is same from qty*amt or not if not add star to amount
						  	$star='**';
						  }else{
						  	$star='';
						  }
						  
						  echo $this->Number->format($nursingService['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).$star;
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
						  			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format(/*$totalUnit**/$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'nursing_service_amount','style'=>'text-align:right;'));
									echo $this->Number->format(/*$totalUnit*/$nursingService['cost']);
									//echo $this->Number->format($totalUnit*$nursingService['cost']);
						  			$totalNursingCharges = $totalNursingCharges + /*$totalUnit**/$nursingService['cost'];
									//echo $totalNursingCharges1;
					  	  ?></td>
	          </tr>
          <?php } //}
           //$totalCost=$totalCost+$wardDetailCharges['wardOtherCharges']
           if($pharmacy_charges !='' && $pharmacy_charges!=0){
		   	$v++;$srNo++;
		   	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Pharmacy Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;')); 
           	#echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		   ?>
		   <tr>
			   <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
			    
	            <td class="tdBorderRt ">Pharmacy Charges</td>
	            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
	            <td align="right" valign="top" class="tdBorderRt ">
				<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format(round($pharmacy_charges/*-$pharmacyPaidAmount*/),
						array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						//echo $this->Number->format(round($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					if($this->Session->read('website.instance')=='vadodara'){
						echo $this->Number->format(round($pharmacy_charges)+round($pharmacyReturnChargesInInvoice));
			   		}else{
			   			echo $this->Number->format(round($pharmacy_charges/*-$pharmacyPaidAmount*/));
			   		}?>
				</td>
				<td align="center" valign="top" class="tdBorderRt ">
				<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
					  echo '--';?>
				</td>
	            
	            <td align="right" valign="top" ><?php 
	            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(round($pharmacy_charges/*-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
 
	            if($this->Session->read('website.instance')=='vadodara'){
	            	echo $this->Number->format(round($pharmacy_charges)+round($pharmacyReturnChargesInInvoice));
	            }else{
	            	echo $this->Number->format(round($pharmacy_charges/*-$pharmacyPaidAmount*/));
	            }?></td>
          </tr>
          <?php }?>
          
          <?php if($this->Session->read('website.instance')=='vadodara'){  //for pharmacy return charges...
	            if($pharmacyReturnChargesInInvoice){?>
           <tr>
			   <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
	            <td class="tdBorderRt ">Pharmacy Return Charges</td>
	            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
	            <td align="right" valign="top" class="tdBorderRt "><?php echo $this->Number->format(round($pharmacyReturnChargesInInvoice)); ?></td>
				<td align="center" valign="top" class="tdBorderRt "><?php echo '--';?></td>
	            <td align="right" valign="top" ><?php echo $this->Number->format(round($pharmacyReturnChargesInInvoice));?></td>
          </tr>
          <?php }}?>
          
           <!-- BOF lab charges -->
         
          <!-- OT Pharmacy Charges -->
          <?php if($otPharmacyToatalAmount!=0 && $otPharmacyToatalAmount!=''){ 
          		if($return_amount != 0 && $return_amount != ""){
					$return_amount;
				}else{
					$return_amount = 0;
				}
			$v++;$srNo++;
			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Pharmacy Charges",'legend'=>false,'label'=>false,
					'id' => 'registration_rate','style'=>'text-align:right;'));?>
			
		   <tr>
		   <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
		   
		   <td class="tdBorderRt ">OT Medicine Charges</td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt ">
			<?php   echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format(round($otPharmacyToatalAmount/* -$return_amount */),
					array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'
					legend'=>false,'label'=>false,'id' => 'otPharmacyRate','style'=>'text-align:right;'));
					echo $this->Number->format(round($otPharmacyToatalAmount/*-$return_amount*/));
			?>
			</td>
			<td align="center" valign="top" class="tdBorderRt ">
			<?php 	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,
					'id' => 'otPharmacyRate','style'=>'text-align:center;'));
					echo '--';?>
			</td>
            
            <td align="right" valign="top" ><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(round($otPharmacyToatalAmount/*-$return_amount*/),
			array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            echo $this->Number->format(round($otPharmacyToatalAmount/*-$return_amount*/));?>
            </td>
          </tr>
          <?php } ?>
          <!-- END of OT Pharmacy Charges -->
          
         <?php if($this->Session->read('website.instance')=='vadodara'){  //for OT pharmacy return charges...
	            if($return_amount){?>
           <tr>
			   <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
	            <td class="tdBorderRt ">OT Pharmacy Return Charges</td>
	            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
	            <td align="right" valign="top" class="tdBorderRt "><?php echo $this->Number->format(round($return_amount)); ?></td>
				<td align="center" valign="top" class="tdBorderRt "><?php echo '--';?></td>
	            <td align="right" valign="top" ><?php echo $this->Number->format(round($return_amount));?></td>
          </tr>
          <?php }}?>
          
          
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
  			$totalCost = $otherServicesCharges + $registrationRate + $totalNursingCharges + $totalDoctorCharges + $totalNewWardCharges + $totalCost + $lCost + $rCost-$radPaidAmount-$labPaidAmount+$anesthesiaCharges+$otPharmacyToatalAmount;// + $extraSurgeryCost;
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
                     
            <td align="right" valign="top"></td>
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
            echo $this->Number->currency(round($totalCost));
            echo $this->Form->hidden('Billing.total_amount',array('value' => ($totalCost),'legend'=>false,'label'=>false));
            ?></strong></td>
          </tr>
        </table>
    </td>
  </tr>
  </table>
  </td></tr>
  </tbody>
 
	<!-- <tfoot> -->
	<tr>
	    <td width="100%" align="left" valign="top" class="tblFooter" id="tblFooter">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td valign="top" class="boxBorderRight columnPad">
	            	Amount Chargeable (in words)<br />
					<strong><?php echo $this->RupeesToWords->no_to_words(round($totalCost));?></strong>            </td>
	            	<td width="292" class="tdBorderRt">
	            	<table width="100%" cellpadding="0" cellspacing="0" border="0" >
	                	<tr>
	                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Amount Paid</td>
	                        <td align="right" valign="top" class="tdBorderBt">
	                            <!-- reduces rad and lab charges from the Amount paid @7387737062 Start-->
	                        <?php 
	                       // <?php
// Radiology aur Laboratory charges calculate karna
// $laboratoryTotal = 0;
// $radiologyTotal = 0;

// // Radiology charges calculate karna
// if (!empty($radRate)) {
//     foreach ($radRate as $labCost) {
//         if ($labCost['RadiologyTestOrder']['amount'] > 0) {
//             $radiologyTotal += $labCost['RadiologyTestOrder']['amount'];
//         } else {
//             $radiologyTotal += $labCost['TariffAmount'][$nabhType];
//         }
//     }
// }

// // Lab charges calculate karna agar lab data available hai
// if (!empty($labRate)) {
//     foreach ($labRate as $labData) {
//         if (!empty($labData['LaboratoryTestOrder']['amount'])) {
//             $laboratoryTotal += $labData['LaboratoryTestOrder']['amount'];
//         }
//     }
// }

// // Total reduce kiye gaye charges calculate karna
// $totalChargesReduced = $radiologyTotal + $laboratoryTotal;

// // Total amount paid ko update karna
// $totalAmountPaid = $totalAdvancePaid - $totalChargesReduced;

// // Agar totalAmountPaid null ya zero hai to usse handle karna
// if ($totalAmountPaid === null || $totalAmountPaid <= 0) {
//     $totalAmountPaid = 0;
// }

// // Final amount ko currency format mein dikhana
// // Rupee symbol aur formatted value ko echo karna
// echo $this->Html->image('icons/rupee_symbol.png');
// echo $this->Number->currency(round($totalAmountPaid));

// // Hidden field mein total amount paid ka value set karna
// echo $this->Form->hidden('Billing.amount_paid', array(
//     'value' => $totalAmountPaid,
//     'legend' => false,
//     'label' => false
// ));


	                        ?>
	                          <!-- reduces rad and lab charges from the Amount paid @7387737062End -->
	                         <?php
// Radiology aur Laboratory charges calculate karna
$laboratoryTotal = 0;
$radiologyTotal = 0;

// Radiology charges calculate karna
if (!empty($radRate)) {
    foreach ($radRate as $labCost) {
        if ($labCost['RadiologyTestOrder']['amount'] > 0) {
            $radiologyTotal += $labCost['RadiologyTestOrder']['amount'];
        } else {
            $radiologyTotal += $labCost['TariffAmount'][$nabhType];
        }
    }
}

// Lab charges calculate karna agar lab data available hai
if (!empty($labRate)) {
    foreach ($labRate as $labData) {
        if (!empty($labData['LaboratoryTestOrder']['amount'])) {
            $laboratoryTotal += $labData['LaboratoryTestOrder']['amount'];
        }
    }
}

// Total reduce kiye gaye charges calculate karna
$totalChargesReduced = $radiologyTotal + $laboratoryTotal;

// Initial total amount paid ko set karna
$totalAmountPaid = $totalAdvancePaid - $totalChargesReduced;

// Agar totalAmountPaid null ya zero hai to usse handle karna
if ($totalAmountPaid === null || $totalAmountPaid <= 0) {
    $totalAmountPaid = 0;
}

// JavaScript code jo amount ko local storage mein save karega aur formatted amount display karega
?>
<div id="formattedAmount" contenteditable="true" style="padding: 5px; display: inline-block;">
    Rs <?php echo number_format($totalAmountPaid, 2); ?>
</div>

<script>
// Page load hone par local storage se amount set karna
document.addEventListener("DOMContentLoaded", function() {
    var storedAmount = localStorage.getItem("manualAmount");
    var formattedAmountDiv = document.getElementById("formattedAmount");

    if (storedAmount) {
        formattedAmountDiv.innerText = "Rs " + parseFloat(storedAmount).toFixed(2);
    }
});

// Jab amount change ho to value ko local storage mein save karna
document.getElementById("formattedAmount").addEventListener("input", function() {
    var amountText = this.innerText.replace(/[^0-9.]/g, ""); // Non-numeric characters ko remove karna
    localStorage.setItem("manualAmount", amountText);
    this.innerText = "Rs " + parseFloat(amountText || 0).toFixed(2);
});
</script>

<?php
// Hidden field mein total amount paid ka value set karna (original calculation ko bhi rakha gaya hai)
echo $this->Form->hidden('Billing.amount_paid', array(
    'value' => $totalAmountPaid,
    'legend' => false,
    'label' => false
));
?>

	                        </td>
	                    </tr>
	                    
	                    <?php //debug($paidReturnForPharmacyInInvoice['pharmacy'][0]['total']."--".$paidReturnForPharmacyInInvoice['otpharmacy'][0]['total']);
	                    
	                   /* if(isset($finalBillingData['FinalBilling']['discount_type']) && $finalBillingData['FinalBilling']['discount'] !=''){
	                        	$discountAmount = $finalBillingData['FinalBilling']['discount'];
	                    }else{
	                        	$discountAmount=0;
	                    }*/
	                    //if($discountAmount != '' && $discountAmount!=0){
						//echo $totalDiscountGiven[0]['sumDiscount'] ;
						
	                    if($totalDiscountGiven[0]['sumDiscount']){
							//$discountAmount=$totalDiscountGiven[0]['sumDiscount']-round($pharmacyReturnCharges['0']['sumReturnDiscount']);
							$discountAmount=$totalDiscountGiven[0]['sumDiscount']-round($paidReturnForPharmacyInInvoice['pharmacy'][0]['total_discount'])
								-round($paidReturnForPharmacyInInvoice['otpharmacy'][0]['total_discount']);
						}else{
							$discountAmount='';
						}
	                    if($discountAmount != '' && $discountAmount!=0){?>
	                    <tr class="discountRow">
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

						//debug($totalRefundGiven);if($discountData['FinalBilling']['refund']=='1'){?>
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
	                	  <td align="right" valign="top" class="tdBorderBt" id="showFullBalance"><?php 
	                	  //echo $this->Html->image('icons/rupee_symbol.png');
	                	  echo $this->Number->currency(round($balance = $totalCost-$totalAdvancePaid-$discountAmount+$totalRefund));
	                	  echo $this->Form->hidden('Billing.amount_pending',array('value' => ($totalCost-$totalAdvancePaid-$discountAmount+$totalRefund),'legend'=>false,'label'=>false));
	                	  ?></td>
                                </tr>
                           <tr class="removeDiscount discountBtn">
                               <td colspan="2" height="20" valign="top" class="tdBorderRtBt">&nbsp;
                                   <?php echo $this->Form->submit('Remove Discount',array('style'=>'','type'=>'button','class'=>'blueBtn ','div'=>false,'error'=>false,'id'=>'hideDiscount'));?></td>
                               
                           </tr>
                           <tr class="applyDiscount discountBtn" style="display:none">
                               <td colspan="2" height="20" valign="top" class="tdBorderRtBt">&nbsp;
                                   <?php echo $this->Form->submit('Show Discount',array('style'=>'','type'=>'button','class'=>'blueBtn ','div'=>false,'error'=>false,'id'=>'showDiscount'));?></td>
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
	<!--   </tfoot> -->	
</table>
<span><b>(NOTE: ** Indicates that calculated price may vary .Please ask for "Detailled Bill" to see the details.)</b></span>
 
 <script>
 $('#showPharm').click(function (){
		 $.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "pharmacyShow", "admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					  $('#busy-indicator').show('slow');
					  }, 	  		  
				  success: function(data){
					  $('#busy-indicator').hide('slow');
					  window.location.reload(true);
					  }
				  
			});
	});
        
        $('#hideDiscount').click(function(){			
            $(".discountRow").hide();
            $(".removeDiscount").hide();
            $(".applyDiscount").show();
            calculateBalance("add");
            
         });
         $('#showDiscount').click(function(){			
            $(".discountRow").show();
            $(".removeDiscount").show();
            $(".applyDiscount").hide();
            calculateBalance("sub");
            
         });
	   
        function calculateBalance(type){
           totalDis = parseInt("<?php echo $discountAmount;?>");      
           bal =parseInt("<?php echo $balance;?>");
           if(type ==='add'){
            var  totalBalance = bal+totalDis;
           }else if(type ==='sub'){
            var  totalBalance = bal; 
           }
          
          $("#showFullBalance").text('Rs ' + parseFloat(totalBalance).toFixed(2));
         // $("#showFullBalance").text(totalBalance);
        }
        

 </script>

</body>
</html>
