<?php  
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
		$total_amount_rad=$total_amount_rad+$getRadData['RadiologyTestOrder']['amount'];
	}else{
		$total_amount_rad=$total_amount_rad+$getRadData['TariffAmount'][$nursingServiceCostType];
	}
	//$total_amount_rad=$total_amount_rad+$getRadData['TariffAmount'][$nursingServiceCostType];
}
$registrationRate=explode('.',$registrationRate);
$doctorRate=explode('.',$doctorRate);
$doctorCharges=$doctorCharges?$doctorCharges:'0';
$nursingCharges=$nursingCharges?$nursingCharges:'0';
$totalMandatoryService=$doctorCharges+$nursingCharges;//debug($this->Number->currency($doctorRate));
/*** Private Package Cost variable */
$packageTotalCost =  $packageCost['EstimateConsultantBilling']['total_amount'];
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
 
$totalPharmacyCharge = ceil($pharmacy_charges[0]['total']);
//$totalPharmacyCharge=$totalPharmacyCharge+($totalPharmacyCharge*($pharmacyTax/100));debug($totalPharmacyCharge);//dont remove

//surgery charge
$totalSurgeryAmount=0;
foreach($surgeryData as $key => $surgery){
	$totalSurgeryAmount=$totalSurgeryAmount+$surgery['OptAppointment']['surgery_cost']+$surgery['OptAppointment']['anaesthesia_cost']+$surgery['OptAppointment']['ot_charges'];
}

//consultant charges
$total_amount_consultant=0;
foreach($getconsultantData as $getconsultantData){
	$total_amount_consultant=$total_amount_consultant+$getconsultantData['ConsultantBilling']['amount'];
}

?>
<div>
<?php //if(!empty($billingData)){?>
<table width="85%" cellspacing="1" cellpadding="0" border="0" style=" clear:both" class="tabularForm" >
   <tbody>
   		<tr>
   			<th width="200px" class="table_cell">&nbsp;</th>
   			<!-- <th class="table_cell">Mandatory Service</th> -->
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
   			<!-- <td align="right" ><?php if($totalMandatoryService)echo $totalMandatoryService;else echo ''; ?></td> -->
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
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='surgery'){
   					if($totalSurgeryAmount) echo $totalSurgeryAmount;else echo '';
   					continue;
   				}elseif(strtolower($serviceGroupTotal['ServiceCategory']['name'])=='roomtariff'){
   					if($totalRoomTariffCharge) echo $totalRoomTariffCharge;else echo '';
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
            			+$totalRoomTariffCharge+$total_amount_consultant + $packageTotalCost;
//debug($totalCharge);debug($totalPharmacyCharge);
			if($pharmaConfig=='yes'){
				$totalCharge= $totalCharge+$totalPharmacyCharge;
			}
		//	debug($totalCharge);
            if($totalCharge)echo $totalCharge;else echo '';
            ?></strong></td>
           
        </tr>
        
        <tr>
	        <td align="" >Discount</td>
	        
	        <?php $hasPharmacyDiscount = false  ;$totalAdvanceDiscount = 0;
	        foreach($service_group as $serviceGroup){ 
				/** condition for non packaged patient ( hiding private package head) */
				if( !$packageTotalCost && strtolower($serviceGroup['ServiceCategory']['name']) == 'private package') continue;
				?>
	   			<td align="right" >
	   			<?php //second row discount amount  
		   			$singleDiscount = 0 ;//set discount
		   			if(strtolower($serviceGroup['ServiceCategory']['name'])=='private package'){
		   				echo $packageCost['EstimateConsultantBilling']['totalDiscount']['total_discount'];
		   				$totalAdvanceDiscount += (int) $packageCost['EstimateConsultantBilling']['totalDiscount']['total_discount'];
		   			}else if($servicePaidData){
						foreach($servicePaidData as $serviceDiscountKey =>$serviceDiscountValue){
							if($serviceDiscountValue['Billing']['payment_category'] == $serviceGroup['ServiceCategory']['id']){
								echo  ($serviceDiscountValue['0']['sumDiscount'])?$serviceDiscountValue['0']['sumDiscount']:'';
								$totalAdvanceDiscount 	+= 	$serviceDiscountValue['0']['sumDiscount'] ;
								$singleAdvanceDiscount 	= 	$serviceDiscountValue['0']['sumDiscount'] ;
								$singleAdvanceDiscount 	= 	"singleDiscount_".$serviceGroup['ServiceCategory']['id'] ;
								$$singleAdvanceDiscount	= 	(int)$serviceDiscountValue['0']['sumDiscount'] ;
							}
							
						}
					}else{
			   			if(strtolower($serviceGroup['ServiceCategory']['name'])=='pharmacy' && !$hasPharmacyChargesPrinted){
							//echo ($totalPharmacyCharge>0)?$totalPharmacyCharge:'';
							//$hasPharmacyDiscount = true ;
						}
		   			}
		   			//EOF charges 
		   			?>
	   			</td>
	   		<?php }
	        
	        if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){?>
	        <td align="right" ><?php //debug($sumFinalDiscount);
				$totalFinalDiscount=0;
	   			foreach($sumFinalDiscount as $sumFinalDiscount){
		   			if(!empty($sumFinalDiscount[0]['sumFinalDiscount'])){
			   		/*	echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
							 $sumFinalDiscount['Billing']['id'],'?'=>array('flag'=>'discountAmount')))."', '_blank',
							 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
				 commented for hope hospital, coz they dont need print of discount	*/
			   			echo $sumFinalDiscount[0]['sumFinalDiscount'];
			   			$totalFinalDiscount=$totalFinalDiscount+$sumFinalDiscount[0]['sumFinalDiscount'];
			   			?></br><?php 
		   			}
				}?>
	        
	        
	        
	        <?php //echo $discount;?></td>
	        <?php }?>
	        <td align="right" ><strong><?php  $totalDiscount=$totalAdvanceDiscount+$totalFinalDiscount;
	        echo ($totalDiscount)?$totalDiscount:'';?></strong></td>
        </tr>
        
        
        
        <tr>
   			<td align="" >Amount Paid</td>
   			<!-- <td align="right" ><?php 
   			$mandatoryAdvancePaid=0;
   			//second row paid amount for mandatory services only
   			/*foreach($servicePaidData as $servicePaidDataKey =>$servicePaidDataValue){
   				if($servicePaidDataValue['Billing']['payment_category']=='mandatoryServices'){
   					echo  ($servicePaidDataValue[0]['sumService'])?$servicePaidDataValue[0]['sumService']:'';
   					$mandatoryAdvancePaid = $servicePaidDataValue[0]['sumService'] ;
   				}
   			}*/
   			//if($mServiceData[0]['sumService'])echo $mServiceData[0]['sumService']."/-";else echo ''; ?></td>   	 -->		
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
								echo  ($servicePaidDataValue[0]['sumService'])?$servicePaidDataValue[0]['sumService']:'';
								//}
							if(strtolower($serviceGroupPaid['ServiceCategory']['name'])=='pharmacy' && $pharmaConfig=='yes'){									
								$totalAdvancePaid  	+= 	$servicePaidDataValue[0]['sumService'] ;
								$singleAdvancePaid 	= 	$servicePaidDataValue[0]['sumService'] ;
								$singleAdvancePaid 	= 	"singleAdvancePaid_".$serviceGroupPaid['ServiceCategory']['id'] ;
								$$singleAdvancePaid	= 	(int)$servicePaidDataValue[0]['sumService'] ;
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
					echo ($totalPharmacyCharge>0)?$totalPharmacyCharge+$servicePaidDataValue[0]['sumService']:'';
					$hasPharmacyChargesPrinted = true ;
					$totalAdvancePaid  	+= 	$servicePaidDataValue[0]['sumService'] ;
					$singleAdvancePaid 	= 	$servicePaidDataValue[0]['sumService'] ;
					$singleAdvancePaid 	= 	"singleAdvancePaid_".$serviceGroupPaid['ServiceCategory']['id'] ;
					$$singleAdvancePaid	= 	(int)$servicePaidDataValue[0]['sumService'] ;
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
            $totalPharmacyPaid=($pharmacy_cash_total)?$pharmacy_cash_total:'0';
           /*  $totalPaid= $mServiceData[0]['sumService']+$servicePaidData[0]['sumService']+$labPaidData[0]['sumLab']+
            			$radPaidData[0]['sumRad']+$implantPaidData[0]['sumService']+$bloodPaidData[0]['sumService']; */
            $totalMandatoryPaid = /*$mandatoryAdvancePaid+*/$totalAdvancePaid+$totalFinalPaid+$totalPharmacyPaid ; //total mandatory and other paid amount
            if($totalMandatoryPaid) echo $totalMandatoryPaid;else echo '';
            ?></strong></td>            
        </tr>
        
        <tr>
	        <td align="" >Refunded Amount</td>
	        <?php foreach($service_group as $serviceCategory){ 
	        /** condition for non packaged patient ( hiding private package head) */
				if( !$packageTotalCost && strtolower($serviceCategory['ServiceCategory']['name']) == 'private package') continue;
				?>
   				<td align="right" >
   				
   				<?php //second row refund amount  
		   			$singleRefund = 0 ;//set refund
		   			if($servicePaidData){
						foreach($refundData as $serviceRefundKey =>$serviceRefundValue){
							if($serviceRefundValue['Billing']['payment_category'] == $serviceCategory['ServiceCategory']['id']){
								echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
									array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array(
									'action'=>'printRefundPayment',$serviceRefundValue['Billing']['id'],'?'=>array('flag'=>'refund')))."', '_blank',
						 			'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));

								echo  ($serviceRefundValue['Billing']['paid_to_patient'])?$serviceRefundValue['Billing']['paid_to_patient']:'';
								
								if(strtolower($serviceCategory['ServiceCategory']['name'])=='pharmacy' && $pharmaConfig=='yes'){
									$totalAdvanceRefund 	+= 	$serviceRefundValue['Billing']['paid_to_patient'] ;
									$singleRefund			+= 	$serviceRefundValue['Billing']['paid_to_patient'] ;
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
								?></br><?php
							}
						}
						$singleRefund=0;
					}else{
			   			if(strtolower($serviceCategory['ServiceCategory']['name'])=='pharmacy' && !$hasPharmacyChargesPrinted){
							//echo ($totalPharmacyCharge>0)?$totalPharmacyCharge:'';
							//$hasPharmacyDiscount = true ;
						}
		   			}
		   			//EOF charges 
		   			?>
   				</td>
	   		<?php }
	   		
	        if(!empty($finalBillData) || $patientData['Patient']['is_discharge']=='1'){ ?>
	        	<td align="right" >
	        	<?php $totalFinalRefund=0; //debug($sumFinalRefund);
	        	foreach($sumFinalRefund as $sumFinalRefund){
	        		if(!empty($sumFinalRefund['Billing']['paid_to_patient'])){
	        			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
							array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array(
							'action'=>'printRefundPayment',$sumFinalRefund['Billing']['id'],'?'=>array('flag'=>'refund')))."', '_blank',
				 			'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));
 
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
					echo $totalRefund=($totalRefund)?$totalRefund:'';
				/*}else{
					$totalRefund='0';
				}*/
		        ?></strong>
		    </td>
        </tr>
        <tr>
   			<td align="" >Balance</td>
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
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='pharmacy' && $pharmaConfig=='yes'){
		   				$singleServiceChargeTot = $totalPharmacyCharge;//$pharmacy_credit_total;
		   			/*}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])==Configure::read('mandatoryservices')){
		   				$singleServiceChargeTot = $totalMandatoryService;*/
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='surgery'){		   				 
		   				$singleServiceChargeTot = $totalSurgeryAmount;
		   			}elseif(strtolower($serviceGroupBal['ServiceCategory']['name'])=='roomtariff'){		   				 
		   				$singleServiceChargeTot = $totalRoomTariffCharge;
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
	   				  
		   			 $singleBalance =  $singleServiceChargeTot - $$singleAdvancePaidTot-$$singleDiscountTot - $packageDiscount+$$singleRefundTot ;
		   			 $headBalance =  $singleServiceChargeTot - $$singleAdvancePaidTot;//for calculate total coz of ($$singleDiscountTot)
		   			 
		   			 $totalBalance += $headBalance ;
		   			 
		   			 if($patientData['Patient']['is_discharge']!='1' && empty($finalBillData)){ 
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
   			if($totalRefund)$totalBalance=$totalBalance+$totalRefund;//for refunded amount...
            if($totalBalance) echo $totalBalance;else echo '0';
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

$('#pharmacyBill').click(function(){
	$.fancybox({
		'width' : '70%',
		'height' : '100%',
		'autoScale': true,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "pharmacy_details","detail_bill",'?'=>array('person_id'=>$patientId),"inventory"=>true)); ?>",
		'onLoad': function () {//window.location.reload();
			}
		});
});

</script>
