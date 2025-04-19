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

if($this->params->query['showPhar']){
	$pharmaConfig='yes';
}
//EOF
$hospitalType = $this->Session->read('hospitaltype');
if($hospitalType == 'NABH'){$nursingServiceCostType = 'nabh_charges';}else{$nursingServiceCostType = 'non_nabh_charges';}
$total_amount_lab=0;
foreach($getLabData as $getLabData){
	if(!empty($getLabData['LaboratoryTestOrder']['amount']) && $getLabData['LaboratoryTestOrder']['amount']!=0){
		$total_amount_lab=$total_amount_lab+$getLabData['LaboratoryTestOrder']['amount'];
	}else{
		$total_amount_lab=$total_amount_lab+$getLabData['TariffAmount'][$nursingServiceCostType];
	}	
	//$total_amount_lab=$total_amount_lab+$getLabData['TariffAmount'][$nursingServiceCostType];
}
 
$total_amount_rad=0;
foreach($getRadData as $getRadData){
	if(!empty($getRadData['RadiologyTestOrder']['amount']) && $getRadData['RadiologyTestOrder']['amount']!=0){
		$total_amount_rad=round($total_amount_rad+$getRadData['RadiologyTestOrder']['amount'],2);
	}else{
		$total_amount_rad=round($total_amount_rad+$getRadData['TariffAmount'][$nursingServiceCostType],2);
	}
	//$total_amount_rad=$total_amount_rad+$getRadData['TariffAmount'][$nursingServiceCostType];
}
$registrationRate=explode('.',$registrationRate);
$doctorRate=explode('.',$doctorRate);
$doctorCharges=$doctorCharges?$doctorCharges:'0';
$nursingCharges=$nursingCharges?$nursingCharges:'0';
$totalMandatoryService=$doctorCharges+$nursingCharges;//debug($this->Number->currency($doctorRate));
/*** Private Package Cost variable */
$packageTotalCost =  $packageCost['EstimateConsultantBilling']['package_total_cost'];
/*if($discountData['FinalBilling']['discount_type']=='Percentage'){
	$perVar=($discountData['FinalBilling']['discount'])/100;
	$discount=ceil(($discountData['FinalBilling']['total_amount'])*$perVar);
	$discauntedBal=$discountData['FinalBilling']['total_amount']-$discount;
}else{
	$discount=$discountData['FinalBilling']['discount'];
	$discauntedBal=$discountData['FinalBilling']['total_amount']-$discount;
}*/

//Pharmacy Charges
/*$totalPharmacyCharge=0;
foreach($pharmacy_charges as $charges){
	//$pharmacyTax=$charges['pharmacySalesBillTax'];
	$perItemCharge=$charges['quantity']*$charges['rate'];
	$totalPharmacyCharge=$totalPharmacyCharge+$perItemCharge;
}*/ //commnted by pankaj
$saleMinusReturnDisc = ($pharmacy_charges[0]['discount']-$pharmacyReturnCharges[0]['sumReturnDiscount']);
$totalPharmacyCharge = round($pharmacy_charges[0]['total']-$saleMinusReturnDisc); 
//$totalPharmacyCharge=$totalPharmacyCharge+($totalPharmacyCharge*($pharmacyTax/100));debug($totalPharmacyCharge);//dont remove

//surgery charge
$totalSurgeryAmount=0;
foreach($surgeryData as $key => $surgery){
	if($surgery['start']){
	$anaesthesiaCost = ($surgery['anaesthesist'] != '') ? $surgery['anaesthesist_cost'] : 0;
	$asstSurgeonOneCharge = ($surgery['asst_surgeon_one'] != '') ? $surgery['asst_surgeon_one_charge'] : 0;
	$asstSurgeonTwoCharge = ($surgery['asst_surgeon_two'] != '') ? $surgery['asst_surgeon_two_charge'] : 0;
	$cardiologist = ($surgery['cardiologist'] != '') ? $surgery['cardiologist_charge'] : 0;
	/* $var1 = $surgery[cost];
	$var2 = $surgery[ot_charges];
	$var3 = $surgery[surgeon_cost];
	$var4 = $surgery[ot_assistant];
	$var5 = $surgery[extra_hour_charge];
	$var6 = array_sum($surgery['ot_extra_services']);
	echo "$totalSurgeryAmount = $totalSurgeryAmount + $var1 + $anaesthesiaCost + $var2 + $var3 + $asstSurgeonOneCharge + 
		$asstSurgeonTwoCharge + $cardiologist + $var4 + $var5 + $var6 "; */
		$totalSurgeryAmount = $totalSurgeryAmount + $surgery['cost'] + $anaesthesiaCost + $surgery['ot_charges'] + $surgery['surgeon_cost'] + $asstSurgeonOneCharge + 
		$asstSurgeonTwoCharge + $cardiologist + $surgery['ot_assistant'] + $surgery['extra_hour_charge'] + array_sum($surgery['ot_extra_services']) ;
	}
}

//consultant charges
$total_amount_consultant=0;
foreach($getconsultantData as $getconsultantData){
	$total_amount_consultant=$total_amount_consultant+$getconsultantData['ConsultantBilling']['amount'];
}

?>
<div>
<?php //if(!empty($billingData)){?>
<table width="90%" cellspacing="1" cellpadding="0" border="0" style=" clear:both" class="tabularForm" >
   <tbody>
   		<tr>
   			<th width="12%" class="table_cell">&nbsp;</th>
   			<!-- <th class="table_cell">Mandatory Service</th> -->
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

   			if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
   			<th class="table_cell">Final Payment</th>
   			<?php }?> 
   			
   			<th class="table_cell">Total</th>
   		</tr>
   		<tr>
   			<td align="" >Total Amount</td>
   			<!-- <td align="right" ><?php //if($totalMandatoryService)echo $totalMandatoryService;else echo ''; ?></td> -->
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
   					if($total_amount_rad) echo round($total_amount_rad);else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='pharmacy'){
   					if($totalPharmacyCharge)
   						 echo $totalPharmacyCharge.' '.$this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View pharmacy Bills')),'javascript:void(0)',array('id'=>'pharmacyBill','escape'=>false,'style'=>'float:right'));
   					else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='surgery'){
   					if($totalSurgeryAmount) echo $totalSurgeryAmount;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='room tariff'){
   					if($totalRoomTariffCharge) echo $totalRoomTariffCharge['total'];else echo '';
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
   				//$serviceTotal=0;
   				if($servicesData){
	   				foreach($servicesData as $serviceKey =>$serviceValue){//debug($serviceValue);
	   					if($serviceValue['ServiceBill']['service_id']==$serviceGroupTotal['ServiceCategory']['id']){
							if(($serviceGroupTotal['ServiceCategory']['name'])==Configure::read('mandatoryservices') && !$hasMandatoryChargesPrinted){
								//echo $serviceValue[0]['totalService']=($serviceValue[0]['totalService'] || $totalMandatoryService)?$serviceValue[0]['totalService']+$totalMandatoryService:'';
								$totalMandCharges += $serviceValue[0]['totalService']+$totalMandatoryService;
								
								/*if($serviceValue[0]['totalService']!=0 && !empty($serviceValue[0]['totalService'])){
									$totalMandCharges += $serviceValue[0]['totalService']+$totalMandatoryService;
								}else{
									$totalMandCharges += $serviceValue[0]['totalService'];//+$totalMandatoryService;
								}*/								
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
							/* for continue visit. solve later
							 * if(($serviceGroupTotal['ServiceCategory']['name'])==Configure::read('mandatoryservices') && !$hasMandatoryChargesPrinted ){
								if($totalMandatoryService){
									echo  $serviceValue[0]['totalService']=($totalMandatoryService)?$totalMandatoryService:'';
									$hasMandatoryChargesPrinted = true ;
								} 
								$singleServiceCharge = "singleServiceCharge_".$serviceGroupTotal['ServiceCategory']['id'];
								$$singleServiceCharge = (int)$serviceValue[0]['totalService'] ;
								//$serviceTotal 		+= (int)$serviceValue[0]['totalService'] ;
							}*/

							if($totalMandatoryService && ($serviceGroupTotal['ServiceCategory']['name'])==Configure::read('mandatoryservices') && !$hasMandatoryChargesPrinted){
								//echo $serviceTotal=$totalMandatoryService;
								//echo  ($totalMandatoryService)?$totalMandatoryService:'';
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
						//echo $serviceTotal=$totalMandatoryService;
						echo  ($totalMandatoryService)?$totalMandatoryService:'';
						$singleServiceCharge = "singleServiceCharge_".$serviceGroupTotal['ServiceCategory']['id'];
						$$singleServiceCharge = (int)$totalMandatoryService ;
						$serviceTotal 		+= (int)$totalMandatoryService ;
					}
				}
   				//EOF charges  
   				
   				?></td>
   			<?php } 
   			
   			if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
   			<td align="right"></td>
   			<?php }?>
   			
   			 
            <td align="right" ><strong><?php 
            $totalCharge=/* $totalMandatoryService+ */$total_amount_lab+$total_amount_rad+$serviceTotal+$totalSurgeryAmount
            			+$totalRoomTariffCharge['total']+$total_amount_consultant + $packageTotalCost;
//debug($totalCharge);debug($totalPharmacyCharge);

			if($pharmaConfig=='yes' || $patientData['Patient']['is_packaged']=='1' ){
				$totalCharge= $totalCharge+$totalPharmacyCharge;
			}
		//	debug($totalCharge);
            if($totalCharge)echo round($totalCharge);else echo '';
            ?></strong></td>
           
        </tr>
        
        <tr>
	        <td align="" >Discount</td>
	        <?php if(!empty($advanceBillingPaid) && $website != 'vadodara'){?>
   			<td align="right"></td>
   			<?php }?> 
	        <?php $hasPharmacyDiscount = false  ;$totalAdvanceDiscount = 0;
	        foreach($service_group as $serviceGroup){ 
				/** condition for non packaged patient ( hiding private package head) */
				if( !$packageTotalCost && strtolower($serviceGroup['ServiceCategory']['name']) == 'private package') continue;
				?>
	   			<td align="right" > 
	   			<?php //second row discount amount  
					$showDiscountTotal=0;
		   			$singleDiscount = 0 ;//set discount
		   			if(strtolower($serviceGroup['ServiceCategory']['name'])=='private package'){
							$packageDiscount = ($packageCost['EstimateConsultantBilling']['totalDiscount']['total_discount']);
		   				echo ($packageDiscount != 0) ? "$packageDiscount</br>" : '';
		   				$totalAdvanceDiscount += (int) $packageDiscount;
		   			} if($discountData){ //debug($discountData);
					#dpr($discountData);
						foreach($discountData as $serviceDiscountKey =>$serviceDiscountValue){ 
						 if($serviceDiscountValue['Billing']['payment_category'] != $pharmacyCategoryId){
							if($serviceDiscountValue['Billing']['payment_category'] == $serviceGroup['ServiceCategory']['id']){
							 
								//echo  ($serviceDiscountValue['Billing']['discount'])?$serviceDiscountValue['Billing']['discount']:'';
								if(!empty($serviceDiscountValue['Billing']['discount'])){// by yashwant for </br>
									//echo $showDiscountTotal=(int)$showDiscountTotal+(int)$serviceDiscountValue['Billing']['discount'];
									$showDiscountTotal=(int)$showDiscountTotal+(int)$serviceDiscountValue['Billing']['discount'];
									/*?></br><?php */
								}else{ 
									echo '';
								}
								
								if(strtolower($serviceGroup['ServiceCategory']['name'])=='pharmacy'){
									if($pharmaConfig=='yes'){
										$totalAdvanceDiscount 	+= 	$serviceDiscountValue['Billing']['discount'] ;
									} 
									$singleAdvance			+= 	$serviceDiscountValue['Billing']['discount'] ;
									$singleAdvanceDiscount 	= 	$serviceDiscountValue['Billing']['discount'];
									$singleAdvanceDiscount 	= 	"singleDiscount_".$serviceGroup['ServiceCategory']['id'] ;
									$$singleAdvanceDiscount	= 	(int)$singleAdvance ;
								}else if(strtolower($serviceGroup['ServiceCategory']['name'])!='pharmacy'){
									$totalAdvanceDiscount 	+= 	$serviceDiscountValue['Billing']['discount'];
									$singleAdvance			+= 	$serviceDiscountValue['Billing']['discount'] ;
									$singleAdvanceDiscount 	= 	$serviceDiscountValue['Billing']['discount'] ;
									$singleAdvanceDiscount 	= 	"singleDiscount_".$serviceGroup['ServiceCategory']['id'] ;
									$$singleAdvanceDiscount	= 	(int)$singleAdvance ;
								}
								 
							}
						 }
						}
						$singleAdvance=0;
					} else{
			   			if(strtolower($serviceGroup['ServiceCategory']['name'])=='pharmacy' && !$hasPharmacyChargesPrinted){
							//echo ($totalPharmacyCharge>0)?$totalPharmacyCharge:'';
							//$hasPharmacyDiscount = true ;
							
						}
		   			} 
					//EOF charges
					
					if($showDiscountTotal){
		   				echo $showDiscountTotal;
		   			}
		   			?>
	   			</td>
	   		<?php }
	        
	        if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
	        <td align="right" ><?php //debug($sumFinalDiscount);
				$totalFinalDiscount=0;
				$showTotalFinalDiscount=0;
	   			foreach($sumFinalDiscount as $sumFinalDiscount){
		   			if(!empty($sumFinalDiscount[0]['sumFinalDiscount'])){
			   		/*	echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
							 $sumFinalDiscount['Billing']['id'],'?'=>array('flag'=>'discountAmount')))."', '_blank',
							 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
				 commented for hope hospital, coz they dont need print of discount	*/
			   			//echo $showTotalFinalDiscount=$showTotalFinalDiscount+$sumFinalDiscount[0]['sumFinalDiscount'];
			   			$showTotalFinalDiscount=$showTotalFinalDiscount+$sumFinalDiscount[0]['sumFinalDiscount'];
			   			$totalFinalDiscount=(int)$totalFinalDiscount+(int)$sumFinalDiscount[0]['sumFinalDiscount'];
			   			/*?></br><?php */
		   			}
				}
				if($showTotalFinalDiscount){
					echo $showTotalFinalDiscount;
				}
				?>
	        
	        
	        
	        <?php //echo $discount;?></td>
	        <?php }?>
	        <td align="right" ><strong><?php  $totalDiscount=$totalAdvanceDiscount+$totalFinalDiscount;
	        echo ($totalDiscount)?round($totalDiscount):'';?></strong></td>
        </tr>
        
        
        
        <tr>
   			<td align="" >Amount Paid</td>
   			<?php if(!empty($advanceBillingPaid) && $website != 'vadodara'){?>
   			<td align="right"><?php echo $advanceBillingPaid;?></td>
   			<?php }?> 
   			<?php 
   			$hasPharmacyChargesPrinted = false  ; //to avoid repeated charges print
   			foreach($service_group as $serviceGroupPaid){ 
				/** condition for non packaged patient ( hiding private package head) */
				if( !$packageTotalCost && strtolower($serviceGroupPaid['ServiceCategory']['name']) == 'private package') continue;
			 ?>
   			<td align="right" ><?php  
   			//second row paid amount  
   			$singleAdvancePaid = 0 ;//set advance paid 
   			if($servicePaidData){
				 
				foreach($servicePaidData as $servicePaidDataKey =>$servicePaidDataValue){
					/*if(strtolower($serviceGroupPaid['ServiceCategory']['name'])=='pharmacy' && !$hasPharmacyChargesPrinted){
						echo ($pharmacy_cash_total>0)?$pharmacy_cash_total:'';
						$hasPharmacyChargesPrinted = true ;
					}else*/
						 
					   if( $servicePaidDataValue['Billing']['payment_category']==$serviceGroupPaid['ServiceCategory']['id']){
								
								/*if(strtolower($serviceGroupPaid['ServiceCategory']['name'])=='pharmacy' && !$hasPharmacyChargesPrinted){
									echo ($pharmacy_cash_total>0)?$pharmacy_cash_total+$servicePaidDataValue[0]['sumService']:'';
									$hasPharmacyChargesPrinted = true ;
								}else{*/
								if(strtolower($serviceGroupPaid['ServiceCategory']['name'])=='pharmacy' && $pharmaConfig=='yes'){
									if(strtolower($admission_type)=='ipd' && $by_nurse=='1'){
										if($is_received=='1'){											 
											echo  ($servicePaidDataValue[0]['sumService'])?round($servicePaidDataValue[0]['sumService']):'';
										}
									}else{									 
										echo  ($servicePaidDataValue[0]['sumService'])?round($servicePaidDataValue[0]['sumService']):'';
									}
								}else{
									 
									echo  ($servicePaidDataValue[0]['sumService'])?round($servicePaidDataValue[0]['sumService']):'';
								}
								//}
							if(strtolower($serviceGroupPaid['ServiceCategory']['name'])=='pharmacy' /*&& $pharmaConfig=='yes'*/){	
								if(strtolower($admission_type)=='ipd' && $by_nurse=='1'){
									if($is_received=='1'){
										if($pharmaConfig=='yes'){
											$totalAdvancePaid  	+= 	round($servicePaidDataValue[0]['sumService']) ;
										}
										$singleAdvancePaid 	= 	round($servicePaidDataValue[0]['sumService']) ;
										$singleAdvancePaid 	= 	"singleAdvancePaid_".$serviceGroupPaid['ServiceCategory']['id'] ;
										$$singleAdvancePaid	= 	(int)round($servicePaidDataValue[0]['sumService']) ;
									}
								}else{
									if($pharmaConfig=='yes'){
										$totalAdvancePaid  	+= 	round($servicePaidDataValue[0]['sumService']) ;
									}
									$singleAdvancePaid 	= 	round($servicePaidDataValue[0]['sumService']) ;
									$singleAdvancePaid 	= 	"singleAdvancePaid_".$serviceGroupPaid['ServiceCategory']['id'] ;
									$$singleAdvancePaid	= 	(int)round($servicePaidDataValue[0]['sumService']) ;
								} 
							}else if(strtolower($serviceGroupPaid['ServiceCategory']['name'])!='pharmacy'){
								$totalAdvancePaid  	+= 	$servicePaidDataValue[0]['sumService'] ;
								$singleAdvancePaid 	= 	$servicePaidDataValue[0]['sumService'] ;
								$singleAdvancePaid 	= 	"singleAdvancePaid_".$serviceGroupPaid['ServiceCategory']['id'] ;
								$$singleAdvancePaid	= 	(int)$servicePaidDataValue[0]['sumService'] ;
							}
						}

						/*if(strtolower($serviceGroupPaid['ServiceCategory']['name'])=='pharmacy'){
							echo ($totalPharmacyCharge>0)?$totalPharmacyCharge+$servicePaidDataValue[0]['sumService']:'';
							if($pharmaConfig=='yes'){
								 $hasPharmacyChargesPrinted = true ;
								$totalAdvancePaid  	+= 	$servicePaidDataValue[0]['sumService'] ;
								$singleAdvancePaid 	= 	$servicePaidDataValue[0]['sumService'] ;
								$singleAdvancePaid 	= 	"singleAdvancePaid_".$serviceGroupPaid['ServiceCategory']['id'] ;
								$$singleAdvancePaid	= 	(int)$servicePaidDataValue[0]['sumService'] ;
							}
						}*/
				}
			}else{//if billing pagee has amount of only pharmacy
	   			if(strtolower($serviceGroupPaid['ServiceCategory']['name'])=='pharmacy' && !$hasPharmacyChargesPrinted && $pharmaConfig=='yes'){
					//echo ($totalPharmacyCharge>0)?$totalPharmacyCharge+$servicePaidDataValue[0]['sumService']:'';
					//$hasPharmacyChargesPrinted = true ;
					$totalAdvancePaid  	+= 	$servicePaidDataValue[0]['sumService'] ;
					$singleAdvancePaid 	= 	$servicePaidDataValue[0]['sumService'] ;
					$singleAdvancePaid 	= 	"singleAdvancePaid_".$serviceGroupPaid['ServiceCategory']['id'] ;
					$$singleAdvancePaid	= 	(int)$servicePaidDataValue[0]['sumService'] ;
					 
				}else if(strtolower($serviceGroupPaid['ServiceCategory']['name'])=='pharmacy'){
					//echo ($totalPharmacyCharge>0)?$totalPharmacyCharge+$servicePaidDataValue[0]['sumService']:'';
					echo ($servicePaidDataValue[0]['sumService'])?$servicePaidDataValue[0]['sumService']:'';
					if($servicePaidDataValue[0]['sumService']){
						$totalAdvancePaid  	+= 	round($servicePaidDataValue[0]['sumService']) ;
						$singleAdvancePaid 	= 	round($servicePaidDataValue[0]['sumService']) ;
						$singleAdvancePaid 	= 	"singleAdvancePaid_".$serviceGroupPaid['ServiceCategory']['id'] ;
						$$singleAdvancePaid	= 	(int)round($servicePaidDataValue[0]['sumService']) ;
					}
				}
   			}
   			//EOF charges 
   			?></td>
   			<?php } //EOF service group foreach 
   			if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
   			<td align="right"><?php //debug($finalBillData);
				$totalFinalPaid=0;
	   			foreach($finalBillData as $finalBillData){
	   			//if(!empty($finalBillData[0]['sumFinalBill'])){
		   			if(!empty($finalBillData['Billing']['amount']) && $finalBillData['Billing']['refund']!='1'){
			   			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
							 $finalBillData['Billing']['id']))."', '_blank',
							 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			   			//echo $finalBillData[0]['sumFinalBill'];
			   			echo $finalBillData['Billing']['amount'];
			   			$totalFinalPaid=$totalFinalPaid+$finalBillData['Billing']['amount'];
			   			?></br><?php 
		   			}
				}?>
   			</td>
   			<?php }?>
   			
   			 			 
            <td align="right" ><strong><?php   
            //$totalPharmacyPaid=($pharmacy_cash_total)?$pharmacy_cash_total:'0';
           /*  $totalPaid= $mServiceData[0]['sumService']+$servicePaidData[0]['sumService']+$labPaidData[0]['sumLab']+
            			$radPaidData[0]['sumRad']+$implantPaidData[0]['sumService']+$bloodPaidData[0]['sumService']; */
            $totalMandatoryPaid = /*$mandatoryAdvancePaid+*/$totalAdvancePaid+$totalFinalPaid+$totalPharmacyPaid+$advanceBillingPaid ; //total mandatory and other paid amount
            if($totalMandatoryPaid) echo round($totalMandatoryPaid);else echo '';
            ?></strong></td>            
        </tr>
        
        <tr>
	        <td align="" >Refunded Amount</td>
	        <?php if(!empty($advanceBillingPaid) && $website != 'vadodara'){?>
   			<td align="right"></td>
   			<?php }?>
	        <?php foreach($service_group as $serviceCategory){ 
	        /** condition for non packaged patient ( hiding private package head) */
				if( !$packageTotalCost && strtolower($serviceCategory['ServiceCategory']['name']) == 'private package') continue;
				?>
   				<td align="right" style="width: auto;">
   				<?php //second row refund amount  
		   			$singleRefund = 0 ;//set refund
		   			if($servicePaidData){
						foreach($refundData as $serviceRefundKey =>$serviceRefundValue){
							if($serviceRefundValue['Billing']['payment_category'] == $serviceCategory['ServiceCategory']['id']){
								 
                               if($website != 'vadodara'){
									echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
										array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array(
										'action'=>'printRefundPayment',$serviceRefundValue['Billing']['id'],'?'=>array('flag'=>'refund')))."', '_blank',
						 				'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));

                               		echo $this->Html->link($this->Html->image('icons/printer_mono.png',array('title'=>'Print With Header')),'#',
                               			array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array(
                               		    'action'=>'printRefundPayment',$serviceRefundValue['Billing']['id'],'?'=>array('flag'=>'refund','header'=>'without')))."', '_blank',
						 			    'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;")) ;
                               }else{
                               		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
										array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array(
										'action'=>'printAdvanceReceipt',$serviceRefundValue['Billing']['id'],'?'=>array('flag'=>'refund')))."', '_blank',
						 				'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));
                               }
         
								//echo  ($serviceRefundValue['Billing']['paid_to_patient'])?$serviceRefundValue['Billing']['paid_to_patient']:'';
								if($serviceRefundValue['Billing']['paid_to_patient']){// by yashwant for </br>
									echo round($serviceRefundValue['Billing']['paid_to_patient']);
									?></br><?php
								}else{ 
									echo '';
								}
								
								if(strtolower($serviceCategory['ServiceCategory']['name'])=='pharmacy'  ){
									if($pharmaConfig=='yes'){
										$totalAdvanceRefund 	+= 	$serviceRefundValue['Billing']['paid_to_patient'] ;
									}
									$singleRefund			+= 	round($serviceRefundValue['Billing']['paid_to_patient']) ;
									$singleAdvanceRefund 	= 	$serviceRefundValue['Billing']['paid_to_patient'] ;
									$singleAdvanceRefund 	= 	"singleRefund_".$serviceCategory['ServiceCategory']['id'] ;
									$$singleAdvanceRefund	= 	(int)$singleRefund ;
								}else if(strtolower($serviceCategory['ServiceCategory']['name'])!='pharmacy'){
									$totalAdvanceRefund 	+= 	$serviceRefundValue['Billing']['paid_to_patient'] ;
									$singleRefund			+= 	$serviceRefundValue['Billing']['paid_to_patient'] ;
									$singleAdvanceRefund 	= 	$serviceRefundValue['Billing']['paid_to_patient'] ;
									$singleAdvanceRefund 	= 	"singleRefund_".$serviceCategory['ServiceCategory']['id'] ;
									$$singleAdvanceRefund	= 	(int)$singleRefund ;
								}
								 
							}
						}
						$singleRefund=0;
					}else{
			   			if(strtolower($serviceCategory['ServiceCategory']['name'])=='pharmacy' && !$hasPharmacyChargesPrinted){
							//echo ($totalPharmacyCharge>0)?$totalPharmacyCharge:'';
							//$hasPharmacyDiscount = true ;
						}
		   			}//EOF charges ?>
   				</td>
	   		<?php }
	   		
	        if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){ ?>
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

	        			//echo $sumFinalRefund[0]['sumFinalRefund'];
	        			echo $sumFinalRefund['Billing']['paid_to_patient'];
	        			$totalFinalRefund=$totalFinalRefund+$sumFinalRefund['Billing']['paid_to_patient'];
	        			?></br><?php
        			}
        		}?>
	        	</td>
	        <?php }?>
        	<td align="right" ><strong><?php 
		        //if($discountData['FinalBilling']['refund']=='1'){
					$totalRefund=$totalAdvanceRefund+$totalFinalRefund;
					echo $totalRefund=($totalRefund)?round($totalRefund):'';
				/*}else{
					$totalRefund='0';
				}*/
		        ?></strong>
		    </td>
        </tr>
        <tr>
   			<td align="" >Balance</td>
   			<?php if(!empty($advanceBillingPaid) && $website != 'vadodara'){?>
   			<td align="right"></td>
   			<?php }?>
   			<!-- <td align="right" ><?php //$MserBal=$totalMandatoryService-$mandatoryAdvancePaid;
   			//if($MserBal)echo $MserBal;else echo '';
   			?></td> -->
   			
   			<?php foreach($service_group as $serviceGroupBal){ 
   				$packageDiscount = 0; 
   				/** condition for non packaged patient ( hiding private package head) */
   				if( !$packageTotalCost && strtolower($serviceGroupBal['ServiceCategory']['name']) == 'private package') continue;
   				?>
   			<td align="right" ><?php 
		   			if(strtolower($serviceGroupBal['ServiceCategory']['name'])=='laboratory'){		   				 
		   				$singleServiceChargeTot = $total_amount_lab;
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='radiology'){		   				 
		   				$singleServiceChargeTot = $total_amount_rad;
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='pharmacy' /*&& $pharmaConfig=='yes'*/){
		   				 
						$singleServiceChargeTot = $totalPharmacyCharge;//$pharmacy_credit_total;
		   			/*}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])==Configure::read('mandatoryservices')){
		   				$singleServiceChargeTot = $totalMandatoryService;*/
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='surgery'){		   				 
		   				$singleServiceChargeTot = $totalSurgeryAmount;
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='room tariff'){		   				 
		   				$singleServiceChargeTot = $totalRoomTariffCharge['total'];
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='consultant'){		   				 
		   				$singleServiceChargeTot = $total_amount_consultant;
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='private package'){		   				 
		   				$singleServiceChargeTot = $packageTotalCost;
		   				$packageDiscount = $packageCost['EstimateConsultantBilling']['totalDiscount']['total_discount'];
		   			}else{ //for rest of the services

						$singleServiceChargeTot = 'singleServiceCharge_'.$serviceGroupBal['ServiceCategory']['id'] ;
						$singleServiceChargeTot = $$singleServiceChargeTot ; 
					}
		   			 //third row balance amount 
	   				 $singleAdvancePaidTot  	= 'singleAdvancePaid_'.$serviceGroupBal['ServiceCategory']['id'] ; //for paid amount
	   				 $singleDiscountTot  	= 'singleDiscount_'.$serviceGroupBal['ServiceCategory']['id'] ;//for discount
	   				 $singleRefundTot  	= 'singleRefund_'.$serviceGroupBal['ServiceCategory']['id'] ;//for refund
	   				 # echo $singleServiceChargeTot."<br>".$$singleAdvancePaidTot."<br>".$$singleDiscountTot."<br>".$$singleRefundTot;
		   			 $singleBalance =  (int)$singleServiceChargeTot - (int)$$singleAdvancePaidTot-(int)$$singleDiscountTot - (int)$packageDiscount+(int)$$singleRefundTot ;
					 $headBalance =  $singleServiceChargeTot - $$singleAdvancePaidTot;//for calculate total coz of ($$singleDiscountTot)
		   			 if(strtolower($serviceGroupBal['ServiceCategory']['name'])!='pharmacy' || $pharmaConfig=='yes' || $patientData['Patient']['is_packaged']=='1' ){						 
						$totalBalance += $headBalance ;
					 }
		   			  
		   			 
		   			if($patientData['Patient']['is_discharge']!='1' /*&& empty($finalBillData)*/){ 
   				 		if($singleBalance) echo $singleBalance;else echo '';
   				 	}
   					
   				?></td>
   			<?php }
   			
   			//$totalBalance  = $totalBalance /*+ $MserBal*/;
   			 
   			if(!empty($totalDiscount))$totalBalance  = $totalBalance-$totalDiscount ; 
			
   			if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
   			<td align="right">&nbsp;<?php $totalBalance=$totalBalance-$totalFinalPaid;
   			 
   			//echo $totalBalance."/-";
   			?></td>
   			<?php }?>
   			
            <td align="right" ><strong><?php //$totalBal=$MserBal+$serBal+$labBal+$radBal+$implantBal+$bloodBal;
   			if($advanceBillingPaid)$totalBalance=$totalBalance-$advanceBillingPaid;// to deduct advance from total 
   			if($totalRefund)$totalBalance=$totalBalance+$totalRefund;//for refunded amount...
            if($totalBalance) echo round($totalBalance);else echo '0';
            ?></strong></td>
        </tr>
   </tbody>
</table>
<?php //}
            $patientId=$patientData['Patient']['id'];?>
</div>
<div>&nbsp;</div>
<script>
//$( '#totalCharge', parent.document ).val('<?php //echo $serviceTotal+$labTotal+$radTotal;?>');
//$( '#totalPaid', parent.document ).val('<?php //echo $servicePaid+$consultationPaid+$labPaid+$radPaid;?> ');

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
