<style>
br{
	clear: both;
} 
.TbodySales{
	max-height:none !important ;
}
</style>
<?php $website  = $this->Session->read('website.instance');
 
//to maintain pharmacy charge in heads  -yashwant
foreach($service_group as $key=>$chkPharmcyGroup){
	$pharmacyGroupArray[$key]=$chkPharmcyGroup['ServiceCategory']['name'];
}
if(!in_array("Pharmacy", $pharmacyGroupArray)){
	$pharmaConfig='no';
}  
//EOF
$hospitalType = $this->Session->read('hospitaltype');
if($hospitalType == 'NABH'){$nursingServiceCostType = 'nabh_charges';}else{$nursingServiceCostType = 'non_nabh_charges';}
$total_amount_lab=0;
$total_amount_lab_paid=0;
$total_amount_lab_discount=0;
foreach($getLabData as $getLabData){
	if(!empty($getLabData['LaboratoryTestOrder']['amount']) && $getLabData['LaboratoryTestOrder']['amount']!=0){
		$total_amount_lab=$total_amount_lab+round($getLabData['LaboratoryTestOrder']['amount']);
	}else{
		$total_amount_lab=$total_amount_lab+round($getLabData['TariffAmount'][$nursingServiceCostType]);
	}
	
	if(!empty($getLabData['LaboratoryTestOrder']['paid_amount'])){
		$total_amount_lab_paid=$total_amount_lab_paid+round($getLabData['LaboratoryTestOrder']['paid_amount']);//-round($getLabData['LaboratoryTestOrder']['discount']);
	}
	
	if(!empty($getLabData['LaboratoryTestOrder']['discount'])){
		$total_amount_lab_discount=$total_amount_lab_discount+round($getLabData['LaboratoryTestOrder']['discount']);
	}
}
 
$total_amount_rad=0;
$total_amount_rad_paid=0;
$total_amount_rad_discount=0;
foreach($getRadData as $getRadData){
	if(!empty($getRadData['RadiologyTestOrder']['amount']) && $getRadData['RadiologyTestOrder']['amount']!=0){
		$total_amount_rad=$total_amount_rad+round($getRadData['RadiologyTestOrder']['amount']);
	}else{
		$total_amount_rad=$total_amount_rad+round($getRadData['TariffAmount'][$nursingServiceCostType]);
	}
	
	if(!empty($getRadData['RadiologyTestOrder']['paid_amount'])){
		$total_amount_rad_paid=$total_amount_rad_paid+round($getRadData['RadiologyTestOrder']['paid_amount']);
	}
	if(!empty($getRadData['RadiologyTestOrder']['discount'])){
		$total_amount_rad_discount=$total_amount_rad_discount+round($getRadData['RadiologyTestOrder']['discount']);
	}
}
$registrationRate=explode('.',$registrationRate);
$doctorRate=explode('.',$doctorRate);
$doctorCharges=$doctorCharges?$doctorCharges:'0';
$nursingCharges=$nursingCharges?$nursingCharges:'0';
$totalMandatoryService=$doctorCharges+$nursingCharges;//debug($this->Number->currency($doctorRate));
/*** Private Package Cost variable */
$packageTotalCost =  $packageCost['EstimateConsultantBilling']['package_total_cost'];
 
$totalPharmacyCharge = 0;//round($pharmacy_charges[0]['total']); 
$paidPharmacyCharge =0;// round($pharmacy_charges[0]['paid_amount']);
$discountPharmacyCharge =0;// round($pharmacy_charges[0]['discount']);
foreach($pharmacySaleBIllData as $pharmacySaleBIllDataKey=>$pharmacySaleBIllDataValue){
	$totalPharmacyCharge=$totalPharmacyCharge+$pharmacySaleBIllDataValue['PharmacySalesBill']['total'];
	$paidPharmacyCharge=$paidPharmacyCharge+$pharmacySaleBIllDataValue['PharmacySalesBill']['paid_amnt'];
	$discountPharmacyCharge=$discountPharmacyCharge+$pharmacySaleBIllDataValue['PharmacySalesBill']['discount'];
}
//round all variables total here for pharmacy  --yashwant
$totalPharmacyCharge=round($totalPharmacyCharge);
$paidPharmacyCharge=round($paidPharmacyCharge);
$discountPharmacyCharge=round($discountPharmacyCharge)-round($pharmacyReturnCharges['0']['sumReturnDiscount']);//deucting return discount from total discount --yashawant
$totalPharmacyCharge=$totalPharmacyCharge-round($pharmacyReturnCharges['0']['sumTotal']);//deducting return pharmacy amount  --yashwant
dpr($totalPharmacyCharge);exit;
//$OtPharmacyData
$totalOtPharmacyCharge = 0;//round($pharmacy_charges[0]['total']);
$paidOtPharmacyCharge =0;// round($pharmacy_charges[0]['paid_amount']);
$discountOtPharmacyCharge =0;// round($pharmacy_charges[0]['discount']);
foreach($OtPharmacyData as $OtPharmacyDataKey=>$OtPharmacyDataValue){//debug($OtPharmacyDataValue);
	$totalOtPharmacyCharge=$totalOtPharmacyCharge + $OtPharmacyDataValue['OtPharmacySalesBill']['total'];
	$paidOtPharmacyCharge=$paidOtPharmacyCharge + $OtPharmacyDataValue['OtPharmacySalesBill']['paid_amount'];
	$discountOtPharmacyCharge=$discountOtPharmacyCharge + $OtPharmacyDataValue['OtPharmacySalesBill']['discount'];
}

$totalOtPharmacyReturnCharge = 0;//OT pharmacy return charges
$totalOtPharmacyReturnDiscount = 0;//OT pharmacy return Discount charges
foreach($OtPharmacyReturnData as $OtPharmacyReturnDataKey=>$OtPharmacyReturnDataValue){
	$totalOtPharmacyReturnCharge=$totalOtPharmacyReturnCharge+$OtPharmacyReturnDataValue['OtPharmacySalesReturn']['total'];
	$totalOtPharmacyReturnDiscount=$totalOtPharmacyReturnDiscount+$OtPharmacyReturnDataValue['OtPharmacySalesReturn']['discount'];
}
//round all variables total here for ot pharmacy  --yashwant
$totalOtPharmacyCharge=round($totalOtPharmacyCharge);
$paidOtPharmacyCharge=round($paidOtPharmacyCharge);
$discountOtPharmacyCharge=round($discountOtPharmacyCharge)-round($totalOtPharmacyReturnDiscount);//ot pharmacy return discount should get deducted  --yashwant
$totalOtPharmacyReturnCharge=round($totalOtPharmacyReturnCharge);

//surgery charge
$totalSurgeryAmount=0;
$totalSurgeryPaidAmount=0;
$totalSurgeryDiscount=0;
foreach($surgeryData as $key => $surgery){
	if($surgery['start']){
	$anaesthesiaCost = ($surgery['anaesthesist'] != '') ? $surgery['anaesthesist_cost'] : 0;
	$asstSurgeonOneCharge = ($surgery['asst_surgeon_one'] != '') ? $surgery['asst_surgeon_one_charge'] : 0;
	$asstSurgeonTwoCharge = ($surgery['asst_surgeon_two'] != '') ? $surgery['asst_surgeon_two_charge'] : 0;
	$cardiologist = ($surgery['cardiologist'] != '') ? $surgery['cardiologist_charge'] : 0;
	 
		if($surgery['procedure_complete']!='0' && $website == 'vadodara'){//for vadodara surgery charges only be shown if procedure complete  --yashwant
			$totalSurgeryAmount = $totalSurgeryAmount + $surgery['cost'] + $anaesthesiaCost + $surgery['ot_charges'] + $surgery['surgeon_cost'] + $asstSurgeonOneCharge + 
				$asstSurgeonTwoCharge + $cardiologist + $surgery['ot_assistant'] + $surgery['extra_hour_charge'] + array_sum($surgery['ot_extra_services']) ;
			
			$totalSurgeryPaidAmount=$totalSurgeryPaidAmount+round($surgery['paid_amount']);
			$totalSurgeryDiscount=$totalSurgeryDiscount+round($surgery['discount']);
		}else{
			$totalSurgeryAmount = $totalSurgeryAmount + $surgery['cost'] + $anaesthesiaCost + $surgery['ot_charges'] + $surgery['surgeon_cost'] + $asstSurgeonOneCharge +
			$asstSurgeonTwoCharge + $cardiologist + $surgery['ot_assistant'] + $surgery['extra_hour_charge'] + array_sum($surgery['ot_extra_services']) ;
				
			$totalSurgeryPaidAmount=$totalSurgeryPaidAmount+round($surgery['paid_amount']);
			$totalSurgeryDiscount=$totalSurgeryDiscount+round($surgery['discount']);
		}
	}
}

//consultant charges
$total_amount_consultant=0;
$total_paidAmount_consultant=0;
$total_discount_consultant=0;
foreach($getconsultantData as $getconsultantData){
	$total_amount_consultant=$total_amount_consultant+round($getconsultantData['ConsultantBilling']['amount']);
	$total_paidAmount_consultant=$total_paidAmount_consultant+round($getconsultantData['ConsultantBilling']['paid_amount']);
	$total_discount_consultant=$total_discount_consultant+round($getconsultantData['ConsultantBilling']['discount']);
}

$paidDrCharges=($totalRoomTariffCharge['dr_paid_amount'])?round($totalRoomTariffCharge['dr_paid_amount']):'0';
$paidNurseCharges=($totalRoomTariffCharge['nurse_paid_amount'])?round($totalRoomTariffCharge['nurse_paid_amount']):'0';
$paidDrNurseCharges=$paidDrCharges+$paidNurseCharges;

//total discount from billing heads for 1rs round diff --yashwant
/* $showDiscountTotal=0;
foreach($discountData as $discountDataKey=>$discountDataValue){//debug($discountDataValue['Billing']['discount']);
	//$showDiscountTotal=$showDiscountTotal+$discountDataValue['Billing']['discount'];
} */
$showDiscountTotalFrmFinal=0;
foreach($sumFinalDiscount as $sumFinalDiscountKey=>$sumFinalDiscountValue){
	$showDiscountTotalFrmFinal=$showDiscountTotalFrmFinal+$sumFinalDiscountValue[0]['sumFinalDiscount'];
}
$showDiscountTotal=/*round($showDiscountTotal)+*/round($showDiscountTotalFrmFinal);///+$discountPharmacyCharge+$discountOtPharmacyCharge;//total discount from billing

$totalFinalRefundAmount=0;
foreach($sumFinalRefund as $sumFinalRefundKey=>$sumFinalRefundValue){
	$totalFinalRefundAmount=$totalFinalRefundAmount+$sumFinalRefundValue['Billing']['paid_to_patient'];
}

$totalCategoryPaymentFrmBilling=0;
foreach($servicePaidData as $servicePaidDataKey => $servicePaidDataValue){
	$totalCategoryPaymentFrmBilling=$totalCategoryPaymentFrmBilling+$servicePaidDataValue[0]['sumService'];
}
 
$totalPaidFromFinalBillng=0;
foreach($finalBillData as $finalBillDataKey=>$finalBillDataValue){
	$totalPaidFromFinalBillng=$totalPaidFromFinalBillng+$finalBillDataValue['Billing']['amount'];
}
 
$totalPaidFromBilling=round($totalCategoryPaymentFrmBilling)/*+round($totalPaidFromFinalBillng)*/-$totalFinalRefundAmount ;//total amount paid from billing
 

 
$patientId=$patientData['Patient']['id'];?>
<div style="width: 100%">
<div style="float: left; width: 80%">
<?php //if(!empty($billingData)){?>
<table width="90%" cellspacing="1" cellpadding="0" border="0" style=" clear:both;" class="tabularForm" >
   <tbody>
   		<tr>
   			<th width="12%" class="table_cell">&nbsp;</th>
   			<?php if(!empty($advanceBillingPaid) && $website != 'vadodara'){?>
   			<th class="table_cell">Advance Payment</th>
   			<?php }?> 
   			
   			<?php foreach($service_group as $serviceGroup){ ?>
   			<?php /** condition for non packaged patient ( hiding private package head) */
					if( !$packageTotalCost && strtolower($serviceGroup['ServiceCategory']['name']) == 'private package') continue;
			?>
   			<th class="table_cell"><?php 
	   			echo $serviceGroup['ServiceCategory']['alias'] ?$serviceGroup['ServiceCategory']['alias']:$serviceGroup['ServiceCategory']['name']; 
	   			//echo $serviceGroup['ServiceCategory']['name'];
   			?></th>
   			<?php }

   			/*if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
   			<th class="table_cell">Final Payment</th>
   			<?php }*/?> 
   			
   			<th class="table_cell">Total</th>
   		</tr>
   		<tr>
   			<td align="" >Total Amount</td>
   			<?php if(!empty($advanceBillingPaid) && $website != 'vadodara'){?>
   			<td align="right"></td>
   			<?php }?> 
   			<?php  
			//first row total charges  
   			$totalAdvancePaid = 0 ;//total advance paid
   			$serviceTotal = 0 ; //total charges
   			foreach($service_group as $serviceGroupTotal){ 	
				 /** condition for non packaged patient ( hiding private package head) */
				if( !$packageTotalCost && strtolower($serviceGroupTotal['ServiceCategory']['name']) == 'private package') continue;
  			?>
   			<td align="right" ><?php  
   				//fixed categories as these are pulled from different tables
   				if(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='laboratory'){
   					if($total_amount_lab) echo $total_amount_lab;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='radiology'){
   					if($total_amount_rad) echo $total_amount_rad;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='pharmacy'){
   					if($totalPharmacyCharge)
   						 echo $totalPharmacyCharge.' '.$this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View pharmacy Bills')),'javascript:void(0)',array('id'=>'pharmacyBill','escape'=>false,'style'=>'float:right'));
   					else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='ot pharmacy'){
   					if($totalOtPharmacyCharge)echo $totalOtPharmacyCharge_var=$totalOtPharmacyCharge-$totalOtPharmacyReturnCharge;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='surgery'){
   					if($totalSurgeryAmount) echo $totalSurgeryAmount;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='roomtariff'){
   					if($totalRoomTariffCharge) echo $totalRoomTariffCharge_var=round($totalRoomTariffCharge['total']);else echo '';
   					 
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='consultant'){
   					if($total_amount_consultant) echo $total_amount_consultant;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name']) == 'private package'){
					echo $packageTotalCost;
					continue;
   				}   	
   				//for charges 
   				$hasMandatoryChargesPrinted = false ;//to avoid repeated charges print
   				$singleServiceCharge = '' ;  
   				$totalMandCharges = 0;$isDone=false;
   				if($servicesData){
	   				foreach($servicesData as $serviceKey =>$serviceValue){//debug($serviceValue);
	   					if($serviceValue['ServiceBill']['service_id']==$serviceGroupTotal['ServiceCategory']['id']){
							if(($serviceGroupTotal['ServiceCategory']['name'])==Configure::read('mandatoryservices') && !$hasMandatoryChargesPrinted){
								$totalMandCharges += $serviceValue[0]['totalService']+$totalMandatoryService;
								
								if($totalMandatoryService){
									$isDone = true;
								}
								$hasMandatoryChargesPrinted = true ;
							}else{
								if(($serviceGroupTotal['ServiceCategory']['name'])!=Configure::read('mandatoryservices')){
									echo  ($serviceValue[0]['totalService'])?$serviceValue[0]['totalService']:'';
								}else{
									$totalMandCharges += (int)$serviceValue[0]['totalService'] ;
								}
							}
	   						
							if(($serviceGroupTotal['ServiceCategory']['name'])!=Configure::read('mandatoryservices')){
								$singleServiceCharge = "singleServiceCharge_".$serviceGroupTotal['ServiceCategory']['id'];
								$$singleServiceCharge = (int)$serviceValue[0]['totalService'] ;
								$serviceTotal 		+= (int)$serviceValue[0]['totalService'];
							}else{
								$singleServiceCharge = "singleServiceCharge_".$serviceGroupTotal['ServiceCategory']['id'];
								$$singleServiceCharge = (int)$totalMandCharges ;
								if($isDone == false)
									$serviceTotal 		+= (int)$serviceValue[0]['totalService'];
								else
									$serviceTotal 		+= (int)$serviceValue[0]['totalService'] + $totalMandatoryService;
							}
	   					}else{

							if($totalMandatoryService && ($serviceGroupTotal['ServiceCategory']['name'])==Configure::read('mandatoryservices') && !$hasMandatoryChargesPrinted){
								$totalMandCharges += (int) $totalMandatoryService;
								$singleServiceCharge = "singleServiceCharge_".$serviceGroupTotal['ServiceCategory']['id'];
								$$singleServiceCharge = (int)$totalMandatoryService ;
								$serviceTotal 		+= (int)$totalMandatoryService ;
								$hasMandatoryChargesPrinted = true ;
							}
						}
	   				}
	   				if(($totalMandatoryService && ($serviceGroupTotal['ServiceCategory']['name'])==Configure::read('mandatoryservices')) || (($serviceGroupTotal['ServiceCategory']['name'])==Configure::read('mandatoryservices'))){
						echo $totalMandCharges;
					}
	   				
	   			}else{//in case reg charges are not come only dr, and nursing charges are comming..
					if($totalMandatoryService && ($serviceGroupTotal['ServiceCategory']['name'])==Configure::read('mandatoryservices') && !$hasMandatoryChargesPrinted){
						echo  ($totalMandatoryService)?$totalMandatoryService:'';
						$singleServiceCharge = "singleServiceCharge_".$serviceGroupTotal['ServiceCategory']['id'];
						$$singleServiceCharge = (int)$totalMandatoryService ;
						$serviceTotal 		+= (int)$totalMandatoryService ;
					}
				}
   				//EOF charges  
   				?></td>
   			<?php } 
   			
   			/*if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
   			<td align="right"></td>
   			<?php }*/?>
   			 
            <td align="right" ><strong><?php 
            $totalCharge=$total_amount_lab+$total_amount_rad+$serviceTotal+$totalSurgeryAmount+$totalRoomTariffCharge_var+$total_amount_consultant + $packageTotalCost+$totalOtPharmacyCharge_var;
			if($pharmaConfig=='yes'){
				$totalCharge= $totalCharge+$totalPharmacyCharge;
			}
            if($totalCharge)echo round($totalCharge);else echo '';
            ?></strong></td>
        </tr>
       
       
       <tr>
   			<td align="" >Discount</td>
   			<?php if(!empty($advanceBillingPaid) && $website != 'vadodara'){?>
   			<td align="right"></td>
   			<?php } 
			//first row total charges  
   			$serviceDiscountTotal = 0 ; //total charges
   			foreach($service_group as $serviceGroupDiscountTotal){ 	
				//if( !$packageTotalCost && strtolower($serviceGroupDiscountTotal['ServiceCategory']['name']) == 'private package') continue;
  			?>
   			<td align="right" ><?php  
   				//fixed categories as these are pulled from different tables
   				if(strtolower($serviceGroupDiscountTotal['ServiceCategory']['name'])=='laboratory'){
   					if($total_amount_lab_discount) echo $total_amount_lab_discount;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupDiscountTotal['ServiceCategory']['name'])=='radiology'){
   					if($total_amount_rad_discount) echo $total_amount_rad_discount;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupDiscountTotal['ServiceCategory']['name'])=='pharmacy'){
   					if($discountPharmacyCharge)echo $discountPharmacyChargeVar=$discountPharmacyCharge;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupDiscountTotal['ServiceCategory']['name'])=='ot pharmacy'){
   					if($discountOtPharmacyCharge)echo $discountOtPharmacyChargeVar=$discountOtPharmacyCharge;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupDiscountTotal['ServiceCategory']['name'])=='surgery'){
   					if($totalSurgeryDiscount) echo $totalSurgeryDiscount;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupDiscountTotal['ServiceCategory']['name'])=='roomtariff'){//discount is not needed for room tariff
   					if($totalRoomTariffCharge['discount']) echo $totalRoomTariffChargeDiscount_var=round($totalRoomTariffCharge['discount']);else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupDiscountTotal['ServiceCategory']['name'])=='consultant'){
   					if($total_discount_consultant) echo $total_discount_consultant;else echo '';
   					continue;
   				}/*elseif(strtolower($serviceGroupDiscountTotal['ServiceCategory']['name']) == 'private package'){
					echo $packageTotalCost;
					continue;
   				}    */	
   				//for charges 
   				//$hasMandatoryChargesPrinted = false ;//to avoid repeated charges print
   				//$singleServiceCharge = '' ;  
   				//$totalMandCharges = 0;$isDone=false;
   				if($servicesData){//totalServicePaid
	   				foreach($servicesData as $serviceDiscountKey =>$serviceDiscountValue){
	   					if($serviceDiscountValue['ServiceBill']['service_id']==$serviceGroupDiscountTotal['ServiceCategory']['id']){
							$singleAdvance = 0 ;
							echo  ($serviceDiscountValue[0]['totalServiceDiscount'])?round($serviceDiscountValue[0]['totalServiceDiscount']):''; 
							 
							$totalAdvanceDiscount 	+= 	$serviceDiscountValue[0]['totalServiceDiscount'] ;
							$singleAdvance			+=  $serviceDiscountValue[0]['totalServiceDiscount'] ;
							$singleAdvanceDiscount 	= 	$serviceDiscountValue[0]['totalServiceDiscount'] ;
							$singleAdvanceDiscount 	= 	"singleDiscount_".$serviceGroupDiscountTotal['ServiceCategory']['id'] ;
							$$singleAdvanceDiscount	= 	(int)$singleAdvance ;
	   					} 
	   				}
	   			}
   				//EOF charges  
   				?></td>
   			<?php } 
   			
   			/*if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
   			<td align="right"><?php 
				$totalFinalPaid=0;
	   			foreach($finalBillData as $finalBillData){
		   			if(!empty($finalBillData['Billing']['amount']) && $finalBillData['Billing']['refund']!='1'){
			   			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
							 $finalBillData['Billing']['id']))."', '_blank',
							 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			   			echo $finalBillData['Billing']['amount'];
			   			$totalFinalPaid=$totalFinalPaid+$finalBillData['Billing']['amount'];
			   			?></br><?php 
		   			}
				}?>
   			</td>
   			<?php }*/?>
   			
           <td align="right" ><strong><?php  /*$totalDiscount=$total_amount_lab_discount+$total_amount_rad_discount+$totalAdvanceDiscount+$total_discount_consultant+
           		$totalSurgeryDiscount+$totalRoomTariffCharge['discount']+$discountOtPharmacyChargeVar;  //  DO NOT REMOVE COMMENTED LINE  --yashwant*/
           
           	   if($showDiscountTotal)$totalDiscount=$showDiscountTotal+$discountOtPharmacyChargeVar;else echo '';// because 1 rs issue total from billing page
           
	           if($pharmaConfig=='yes'){
	           	$totalDiscount= $totalDiscount+$discountPharmacyChargeVar;
	           }
	           echo ($totalDiscount)?round($totalDiscount):''; // because 1 rs issue
	        
	        ?></strong></td>
        </tr>
        
        
        <tr>
   			<td align="" >Amount Paid</td>
   			<?php if(!empty($advanceBillingPaid) && $website != 'vadodara'){?>
   			<td align="right"></td>
   			<?php } 
			//first row total charges  
   			//$totalAdvancePaid = 0 ;//total advance paid
   			$servicePaidTotal = 0 ; //total charges
   			foreach($service_group as $serviceGroupPaidTotal){ 	
				//if( !$packageTotalCost && strtolower($serviceGroupPaidTotal['ServiceCategory']['name']) == 'private package') continue;
  			?>
   			<td align="right" ><?php  
   				//fixed categories as these are pulled from different tables
   				if(strtolower($serviceGroupPaidTotal['ServiceCategory']['name'])=='laboratory'){
   					if($total_amount_lab_paid) echo $total_amount_lab_paid_var=$total_amount_lab_paid/* -$total_amount_lab_discount */;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupPaidTotal['ServiceCategory']['name'])=='radiology'){
   					if($total_amount_rad_paid) echo $total_amount_rad_paid_var=$total_amount_rad_paid/* -$total_amount_rad_discount */;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupPaidTotal['ServiceCategory']['name'])=='pharmacy'){
   					if($paidPharmacyCharge)echo $paidPharmacyCharge_var=$paidPharmacyCharge-round($paidReturnForPharmacy['pharmacy'][0]['total']);else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupPaidTotal['ServiceCategory']['name'])=='ot pharmacy'){
   					if($paidOtPharmacyCharge)echo $paidOtPharmacyCharge_var=$paidOtPharmacyCharge-round($paidReturnForPharmacy['otpharmacy'][0]['total']);else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupPaidTotal['ServiceCategory']['name'])=='surgery'){
   					if($totalSurgeryPaidAmount) echo $totalSurgeryPaidAmount_var=$totalSurgeryPaidAmount/* -$totalSurgeryDiscount */;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupPaidTotal['ServiceCategory']['name'])=='roomtariff'){
   					if(!empty($totalRoomTariffCharge['paid_amount'])) echo $totalRoomTariffChargePaid_var=round($totalRoomTariffCharge['paid_amount']);else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupPaidTotal['ServiceCategory']['name'])=='consultant'){
   					if($total_paidAmount_consultant) echo $total_paidAmount_consultant_var=$total_paidAmount_consultant/* -$total_discount_consultant */;else echo '';
   					continue;
   				}/*elseif(strtolower($serviceGroupPaidTotal['ServiceCategory']['name']) == 'private package'){
					echo $packageTotalCost;
					continue;
   				}    */	
   				//for charges 
   				$hasMandatoryChargesPrinted = false ;//to avoid repeated charges print
   				$singleServiceCharge = '' ;  
   				$totalMandCharges = 0;$isDone=false;
   				if($servicesData){//totalServicePaid
	   				foreach($servicesData as $servicePaidKey =>$servicePaidValue){
	   					if($servicePaidValue['ServiceBill']['service_id']==$serviceGroupPaidTotal['ServiceCategory']['id']){ 
							$servicePaidVar = ''; 
							if(($serviceGroupPaidTotal['ServiceCategory']['name'])!=Configure::read('mandatoryservices')){
								if($servicePaidValue[0]['totalServicePaid']){
									$servicePaidVar=$servicePaidValue[0]['totalServicePaid'];//-$servicePaidValue[0]['totalServiceDiscount'];
								}
							}else{
								if($servicePaidValue[0]['totalServicePaid']){
									$servicePaidVar=$servicePaidValue[0]['totalServicePaid']+$paidDrNurseCharges;//-$servicePaidValue[0]['totalServiceDiscount'];
								}
							}
							echo  ($servicePaidVar)?round($servicePaidVar):'';  
							$totalAdvancePaid  	+= 	$servicePaidVar ;
							$singleAdvancePaid 	= 	"singleAdvancePaid_".$serviceGroupPaidTotal['ServiceCategory']['id'] ;
							$$singleAdvancePaid	= 	(int)$servicePaidVar ;
							
	   					} 
	   				}
	   			}
   				//EOF charges  
   				?></td>
   			<?php } 
   			
   			/*if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
   			<td align="right"><?php 
				$totalFinalPaid=0;
	   			foreach($finalBillData as $finalBillData){
		   			if(!empty($finalBillData['Billing']['amount']) && $finalBillData['Billing']['refund']!='1'){
			   			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
							 $finalBillData['Billing']['id']))."', '_blank',
							 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			   			echo $finalBillData['Billing']['amount'];
			   			$totalFinalPaid=$totalFinalPaid+$finalBillData['Billing']['amount'];
			   			?></br><?php 
		   			}
				}?>
   			</td>
   			<?php }*/?>
   			
            <td align="right" ><strong><?php 
            $totalPaidCharge=$total_amount_lab_paid_var+$total_amount_rad_paid_var+$totalAdvancePaid+$total_paidAmount_consultant_var+$totalRoomTariffChargePaid_var+
            	$totalSurgeryPaidAmount_var+$paidOtPharmacyCharge_var;
			if($pharmaConfig=='yes'){
				$totalPaidCharge= $totalPaidCharge+$paidPharmacyCharge_var;
			}
           // if($totalPaidCharge)echo round($totalPaidCharge);else echo '';
            
            
            if($totalPaidFromBilling)echo $totalPaidCharge=$totalPaidFromBilling;else echo '';
            ?></strong></td>
        </tr>
        
         <?php if($website == 'vadodara'){//for showing card payment in heads for vadodara only?>
         <tr>
   			<td align="" >Card Amount</td>
   			<?php foreach($service_group as $serviceGroupCard){ ?>
   			<td align="right" > </td>
   			<?php } ?>
            <td align="right" ><strong><?php 
            $totalCardPaid=$paymentCardBal['Account']['card_balance'];
            if($totalCardPaid)echo round($totalCardPaid);else echo '';
            ?></strong></td>
        </tr>
         <?php }?>
         
        <tr>
   			<td align="" >Balance</td>
   			<?php if(!empty($advanceBillingPaid) && $website != 'vadodara'){?>
   			<td align="right"></td>
   			<?php } 
   			  foreach($service_group as $serviceGroupBal){ 
   				$packageDiscount = 0; 
   				/** condition for non packaged patient ( hiding private package head) */
   				if( !$packageTotalCost && strtolower($serviceGroupBal['ServiceCategory']['name']) == 'private package') continue;
   				//debug($total_amount_lab);debug($total_amount_lab_paid);debug($total_amount_lab_discount);?>
   			<td align="right" ><?php 
		   			if(strtolower($serviceGroupBal['ServiceCategory']['name'])=='laboratory'){		   				 
		   				$singleServiceChargeTot = $total_amount_lab-$total_amount_lab_paid-$total_amount_lab_discount;
		   				 
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='radiology'){		   				 
		   				$singleServiceChargeTot = $total_amount_rad-$total_amount_rad_paid-$total_amount_rad_discount;
		   				 
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='pharmacy'){//pharmacySaleBill
						$singleServiceChargeTot = $totalPharmacyCharge-$paidPharmacyCharge_var-$discountPharmacyChargeVar;//$pharmacy_credit_total;
						 
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='ot pharmacy'){//pharmacySaleBill
						$singleServiceChargeTot = $totalOtPharmacyCharge-$paidOtPharmacyCharge_var-$discountOtPharmacyChargeVar-$totalOtPharmacyReturnCharge;//$pharmacy_credit_total;
						 
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='surgery'){//optappointments	   				 
		   				$singleServiceChargeTot = $totalSurgeryAmount-$totalSurgeryPaidAmount-$totalSurgeryDiscount;
		   				 
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='roomtariff'){	//wardPatientService	   				 
		   				$singleServiceChargeTot = $totalRoomTariffCharge_var-$totalRoomTariffChargePaid_var-$totalRoomTariffChargeDiscount_var;
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='consultant'){	//consultantBIlling	   				 
		   				$singleServiceChargeTot = $total_amount_consultant-$total_paidAmount_consultant-$total_discount_consultant;
		   				 
		   			/*}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='private package'){		   				 
		   				$singleServiceChargeTot = $packageTotalCost;
		   				$packageDiscount = $packageCost['EstimateConsultantBilling']['totalDiscount']['total_discount']; */
		   			}else{ //for rest of the services

						$singleServiceChargeTot = 'singleServiceCharge_'.$serviceGroupBal['ServiceCategory']['id'] ;
						$singleServiceChargeTot = $$singleServiceChargeTot ; 
					}
					
		   			 //third row balance amount 
	   				 $singleAdvancePaidTot  	= 'singleAdvancePaid_'.$serviceGroupBal['ServiceCategory']['id'] ; //for paid amount
	   				 $singleDiscountTot  	= 'singleDiscount_'.$serviceGroupBal['ServiceCategory']['id'] ;//for discount
	   				 $singleRefundTot  	= 'singleRefund_'.$serviceGroupBal['ServiceCategory']['id'] ;//for refund
	   				 
	   				// debug($singleServiceChargeTot);debug($$singleAdvancePaidTot);debug($$singleDiscountTot);
	   				 
		   			 $singleBalance =  (int)$singleServiceChargeTot - (int)$$singleAdvancePaidTot-(int)$$singleDiscountTot - (int)$packageDiscount;//+(int)$$singleRefundTot ;
					 $headBalance =  $singleServiceChargeTot - $$singleAdvancePaidTot;//for calculate total coz of ($$singleDiscountTot)
		   			 if(strtolower($serviceGroupBal['ServiceCategory']['name'])!='pharmacy' || $pharmaConfig=='yes'){						 
						$totalBalance += $headBalance ;
					 }
		   			 
		   			 if($patientData['Patient']['is_discharge']!='1' /*&& empty($finalBillData)*/){ 
   				 		if($singleBalance) echo $singleBalance;else echo '';
   				 	 }
   					
   				?></td>
   			<?php }
   			
   			$totalBalance  = $totalCharge ;
   			if(!empty($totalDiscount))$totalBalance  = $totalBalance-$totalDiscount ; 
			
   			if($website == 'vadodara' && !empty($totalCardPaid))$totalBalance=$totalBalance-$totalCardPaid; //deducting card balance (not payment by w sir) form total only for vadodara
   			?>
   			
            <td align="right" ><strong><?php   
   			if($totalPaidCharge)$totalBalance=$totalBalance-$totalPaidCharge;// to deduct advance from total 
   			
            if($totalBalance) echo round($totalBalance);else echo '0';
            ?></strong></td>
        </tr>
   </tbody>
</table>
</div>

<div style="float: right; width: 15%">
<?php if(!empty($finalBillData) ||!empty($sumFinalRefund)){?>
<table width="90%" cellspacing="1" cellpadding="0" border="0" style=" clear:both; float: right;" class="tabularForm">
<?php if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
	<tr>
		<?php if(!empty($finalBillData) && strtolower($admission_type)!='ipd'){?>
		<th class="table_cell">Final Payment Receipt(s)</th>
		<?php }
		if($sumFinalRefund){?>
		<th class="table_cell">Final Refund Receipt(s)</th>
		<?php }?>
	</tr>
	<tr>
		<?php if(!empty($finalBillData) && strtolower($admission_type)!='ipd'){?>
		<td align="right"><?php 
			$totalFinalPaid=0;
   			foreach($finalBillData as $finalBillData){
	   			if(!empty($finalBillData['Billing']['amount']) && $finalBillData['Billing']['refund']!='1'){

					if($this->Session->read('website.instance')=='vadodara'){
						echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
								array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'getBilledServicePrint',
										$finalBillData['Billing']['id']))."', '_blank',
													 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
						echo round($finalBillData['Billing']['amount']);
						$totalFinalPaid=$totalFinalPaid+$finalBillData['Billing']['amount'];
					}else{
			   			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
							 $finalBillData['Billing']['id']))."', '_blank',
							 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			   			echo round($finalBillData['Billing']['amount']);
			   			$totalFinalPaid=$totalFinalPaid+$finalBillData['Billing']['amount'];
		   			}
		   			?></br><?php 
	   			}
			}?>
	 	</td>
	 	<?php }
		if($sumFinalRefund){?>
     	<td align="right" >
        	<?php $totalFinalRefund=0; //debug($sumFinalRefund);
        	foreach($sumFinalRefund as $sumFinalRefund){
        		if(!empty($sumFinalRefund['Billing']['paid_to_patient'])){
					if($website != 'vadodara'){
						echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
								array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array(
										'action'=>'printRefundPayment',$sumFinalRefund['Billing']['id'],'?'=>array('flag'=>'refund')))."', '_blank',
				 			'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));

						echo $this->Html->link($this->Html->image('icons/printer_mono.png',array('title'=>'Print With Header')),'#',
							array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array(
							'action'=>'printRefundPayment',$sumFinalRefund['Billing']['id'],'?'=>array('flag'=>'refund','header'=>'without')))."', '_blank',
							'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;")) ;
					}else{
						
						echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array(
							'action'=>'printAdvanceReceipt',$sumFinalRefund['Billing']['id'],'?'=>array('flag'=>'refund')))."', '_blank',
				 			'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));
					}

        			echo round($sumFinalRefund['Billing']['paid_to_patient']);
        			$totalFinalRefund=$totalFinalRefund+$sumFinalRefund['Billing']['paid_to_patient'];
        			?></br><?php
        			}
        		}?>
      	</td>
     	<?php }?>
	</tr>
<?php }?>
</table>
<?php }?>
</div>
</div>
<div>&nbsp;</div>
<script>
patient_name='<?php echo $patientData['Patient']['lookup_name'];?>';
patient_id='<?php echo $patientId;?>';

$('#pharmacyBill').fancybox({
	'type': 'ajax',
	'fitToView': false,
	'autoSize': false,
	'width':"60%",
	'height':"60%", 
	'href': "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "pharmacy_details","detail_bill","inventory"=>true/*,'?'=>array('person_id'=>$patientId)*/)) ?>"+'?person_id='+patient_id+'&flag=billing',
});

var isDischarge='<?php echo $patientData['Patient']['is_discharge'];?>';
if(isDischarge=='1'){
	advanceBillingPaid='<?php echo $advanceBillingPaid;?>'; 
	if(advanceBillingPaid =='0' || advanceBillingPaid ==''){
		 $( '#advancePaymentArea', parent.document ).hide();
	}
}
</script>