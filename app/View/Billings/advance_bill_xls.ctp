<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"advance_bill_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
 <STYLE type='text/css'>
.tableTd {
border-width: 0.5pt;
border: solid;
}
.tableTdContent{
border-width: 0.5pt;
border: solid;
}
#titles{
font-weight: bolder;
}

</STYLE>
 
<?php 
	//Calcualtions of lab charges and lab paid charges
	foreach($lab as $getLabData){

		$total_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']]=$total_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']]+$getLabData['LaboratoryTestOrder']['amount'];
		$total_paid_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']]=$total_paid_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']]+$getLabData['LaboratoryTestOrder']['paid_amount'];
		
		//$total_amount_lab=$total_amount_lab+$getLabData['TariffAmount'][$nursingServiceCostType];
	}
	
	//Calcualtions of rad charges and rad paid charges
	foreach($rad as $getRadData){
		
		$total_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']]=$total_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']]+$getRadData['RadiologyTestOrder']['amount'];
		$total_paid_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']]=$total_paid_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']]+$getRadData['RadiologyTestOrder']['paid_amount'];
		
	}
	
	
	//surgery charge
	
	foreach($surgeriesData as $key => $surgery){
		$totalSurgeryAmount[$surgery['OptAppointment']['patient_id']]=$totalSurgeryAmount[$surgery['OptAppointment']['patient_id']]+$surgery['OptAppointment']['surgery_cost']+$surgery['OptAppointment']['anaesthesia_cost']+$surgery['OptAppointment']['ot_charges'];
	}
	//service charge including doctor and nursing charges
	
	
	$hospitalType = $this->Session->read('hospitaltype');
	if($hospitalType == 'NABH'){
		$nursingServiceCostType = 'nabh_charges';
	}else{$nursingServiceCostType = 'non_nabh_charges';
	}
	
	
	foreach($servicesData as $serviceKey =>$serviceValue){
			foreach($serviceValue as $amount){
				$service_tot[$serviceKey] = $service_tot[$serviceKey] + ($amount['cost']);
			}
	}
	
	//Pharmacy Charges "$pharmacy_charges array is addded for pharmacy charges"--Pooja
	
	//consultant  charge
	foreach($getconsultantData as $getconsultantData){
		$total_amount_consultant[$getconsultantData['ConsultantBilling']['patient_id']]=$total_amount_consultant[$getconsultantData['ConsultantBilling']['patient_id']]+$getconsultantData['ConsultantBilling']['amount'];
	}
	
	foreach($patientID as $patient){
		$totalBillAmount[$patient]=$total_amount_lab[$patient]+$total_amount_rad[$patient]+
								$totalSurgeryAmount[$patient]+$service_tot[$patient]+
								$getconsultantData[$patient]+$doctorCharges[$patient]+$nursingCharges[$patient]+
								$patientWardCharges[$patient]+$total_amount_consultant[$patient];
		if(strtolower($pharmacy_service_type)=='yes')
			$totalBillAmount[$patient]=$totalBillAmount[$patient]+$pharmacy_charges[$patient]['0']['total'];
		
	}
	
	
	foreach($advancePayment as $servicePaidDataKey =>$servicePaidDataValue){
		$singleAdvancePaid[$servicePaidDataValue['Billing']['patient_id']]=$singleAdvancePaid[$servicePaidDataValue['Billing']['patient_id']]+$servicePaidDataValue['Billing']['amount'];
	}
	foreach($patientID as $patient){
		$totalPaid[$patient]=$finaltotalPaid[$patient];		
	}
	foreach($patientID as $patient){
		$totalBal[$patient]=$totalBillAmount[$patient]-$totalPaid[$patient]-$totalDiscount[$patient];
	}
	
	foreach($advancePayment as $pay)
	{
		if(!empty($pay['Billing']['amount'])){
			$last_amount[$pay['Billing']['patient_id']] = $pay['Billing']['amount'];
			$last_date[$pay['Billing']['patient_id']] = $pay['Billing']['date'];
		}
	
	}
	
	
	$i=0;
	
	/*- debug($total_amount_lab);
	debug($total_amount_rad);
	debug($totalSurgeryAmount);
	debug($service_tot);
	debug($pharmaTotal);
	debug($total_amount_consultant);
	debug($totalBillAmount);
	debug($totalPaid);
	debug($totalBal); */
	
	
	//for refunded amount
	/*if($discountData['FinalBilling']['refund']=='1'){
		$totalRefund=$discountData['FinalBilling']['paid_to_patient'];
		$totalBal=$totalBal+$totalRefund;
	}else{
		$totalRefund='0';
		$totalBal=$totalBal+$totalRefund;
	}
	//EOF for refunded amount
	
	if($discountData['FinalBilling']['discount_type']=='Percentage'){
		$discountAmount=$discountData['FinalBilling']['discount'];
		$perVar=($discountData['FinalBilling']['discount'])/100;
		$discountVal=ceil(($discountData['FinalBilling']['total_amount'])*$perVar);
		$discauntedBal=$discountData['FinalBilling']['total_amount']-$discountVal;
	}else{
		$discountVal=$discountData['FinalBilling']['discount'];
		$discauntedBal=$discountData['FinalBilling']['total_amount']-$discountVal;
		$discountAmount=$discountData['FinalBilling']['discount'];
	}*/
?>
<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>
<tr class="row_title">
   <td colspan = "13" align="center"><h2>ADVANCE STATEMENT - <?php echo date('d/m/Y');?></h2></td>
  </tr>
	<tr class='row_title'>
		<th width="20px;" align="center" valign="top"
			style="text-align: center;">BED</th>
		<th width="87px;" align="center" valign="top"
			style="text-align: center;">PATIENT DETAILS</th>
		<th width="15px;" valign="top" align="center" style="text-align:center;">PATIENT TYPE</th>
		<th width="15px;" valign="top" align="center" style="text-align:center;">PACKAGE DATE</th>
		<th width="58px;" align="center" valign="top"
			style="text-align: center;">CONSULTANT</th>
		<th width="80px;" align="center" valign="top"
			style="text-align: center;">DIAGNOSIS</th>
		<th width="70px;" align="center" valign="top"
			style="text-align: center;">PLANNED SURGERY OR PROCEDURE AND COST OF
			SURGERY</th>
		<th width="50px;" align="center" valign="top"
			style="text-align: center;">TOTAL BILL AS ON DATE</th>
		<th width="50px;" align="center" valign="top" style="text-align: center;">ADVANCE
			TILL DATE</th>
		<th width="50px;" align="center" valign="top" style="text-align: center;">LAST
			PAYMENT AND DATE</th>
		<th width="50px;" align="center" valign="top"
			style="text-align: center;">BALANCE</th>
		<th width="70" align="center" valign="top" style="text-align: center;">DETAIL
			OF DIFFERENCE BILL AMT</th>
		<th width="60px;" align="center" valign="top"
			style="text-align: center;">PHARMACY/ PATHOLOGY</th>
		<th width="55px;" align="center" valign="top" style="text-align: center;">ASKED TO PAY TODAY</th>
		<th width="80px;" align="center" valign="top"
			style="text-align: center;">REMARKS</th>
	</tr>
	
	
		<?php 
                     	$i=0;$patientCnt=0;
                     	foreach($results as $result)
                     	{ 
                     	$tariffCount[$result['TariffStandard']['name']]=$tariffCount[$result['TariffStandard']['name']]+1;
                     		?>
                     	<TR>
                     	<?php $col='';
								if(empty($result['Patient']['id'])){
										$col="colspan='15'";
					     		}else{
										$col='align="center"';
					    		 }?>
                     		<td  <?php echo $col;?>>
                     		<?php echo $result['Room']['bed_prefix']."<br>";
                     	          echo "Bed-".$result['Bed']['bedno']; ?>
                     	    </td>
                     	    <?php if($result['Patient']['id']){
                     	    $patientCnt++;?> 
                     		<td align="left">
                     		<?php  echo $result['Patient']['lookup_name']."<br>";	
                     			   echo $result['Patient']['admission_id']."<br>";                     		 
	             		 		   echo $result['Person']['district']."<br>";
	             		 		   echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format'))."<br>";
	             		 		   echo $result['TariffStandard']['name']; ?>
	             		 	 </td>

	             		 	 <td>
									<?php if($result['Person']['vip_chk']=='1'){
											echo "20%";
										}else{
											echo  "80%";
										}?>
								</td>
	             		 	 	<td>
                     		<!-- Print package date here -->
		
                                    <?php 
                                        $patient_id = $result['Patient']['id'];
                                        if (isset($dates[$patient_id])) {
                                            $package_number = 1; // पैकेज नंबर शुरू करें
                                            foreach ($dates[$patient_id] as $entry) {
                                                echo "Package " . $package_number . ": " . $entry['day_label'] . "<br>"; // पैकेज नंबर और दिन का लेबल प्रिंट करें
                                                $package_number++; // अगला पैकेज नंबर
                                            }
                                        } else {
                                            echo "No package";
                                        }
                                        ?>
		<!--</td>-->
                     		</td>
							<td>
							<?php  echo $result['User']['first_name'];
									echo $result['User']['last_name']; ?>
							</td>
							
                     		<td>
                     		<?php  echo $result['Diagnosis']['final_diagnosis']; ?>
                     		</td>
                     		
                     		<td> 
                     		<?php 
     			                  foreach ($surgeriesData as $surgery)
         		                        { 
         		                   	if($result['Patient']['id'] == $surgery['OptAppointment']['patient_id'])
         		            	{
         			              	echo $surgery['Surgery']['name']."<br>";	//display only the surgery details of patients
         			              	$surgeryCost=$surgery['OptAppointment']['surgery_cost']+$surgery['OptAppointment']['anaesthesia_cost']+$surgery['OptAppointment']['ot_charges'];
         			              	echo $this->Number->currency(ceil($surgeryCost)).'<br>';
         		                }
         	                 	}
     	                   	?>
     	                   </td>
		                  

		                  <td style=text-align:"center" valign="middle">
		                  <?php echo $this->Number->currency(ceil($totalBillAmount[$result['Patient']['id']]));?>
		                  </td>
		                
		                  <td>
		                  <?php  
		                 /*$pay_amount = 0;
		        			foreach($advancePayment as $pay)
							{
								if($result['Patient']['id'] == $pay['Billing']['patient_id'])
								{
								$pay_amount = $pay_amount+$pay['Billing']['amount'];
								$last_amount = $pay['Billing']['amount'];
								$last_date = $pay['Billing']['date'];
								}
							}*/
							echo $this->Number->currency(ceil($totalPaid[$result['Patient']['id']]));
							//unset($pay_amount);?>
				          </td>
				          
                     	  <td>
                     	  <?php echo $this->Number->currency(ceil($last_amount[$result['Patient']['id']]))."<br>";
			  	  				echo $this->DateFormat->formatDate2Local($last_date[$result['Patient']['id']],Configure::read('date_format'));
			  	  				 ?>
                     	 </td>
                     		
                     	  <td>
                     	 <?php $balance = $totalBal[$result['Patient']['id']]; 
                     	 //$balance = $result['Billing']['total_amount'] - $pay_amount;
                     	  echo $this->Number->currency(ceil($balance));?>
                     	  </td>
                     	  
		                  
		                 
	                     
	                     
	                     
	                     
	                     
		
		<?php 	
				$rad_amt = 0;
				$lab_amt = 0;
				$othnm = $result['OtherService']['service_name'];		//other service name
				$othamt = $result['OtherService']['service_amount'];	//amount
			  	
			 	//consultant amount
				foreach($result['ConsultantBilling'] as $key=>$value)
				{
					$val[] = $result['ConsultantBilling'][$key]['amount'];
				}
				
					$total=0;
						if(is_array($val))
						{
							foreach($val as $tot)
							{
								$total = $tot+$total;
							}
						}
					
				//service name and amount	
				$service_tot = 0;
				foreach($servicesData as $serve)
			 	{
					 if($result['Patient']['id'] == $serve['ServiceBill']['patient_id'] && (!empty($serve['TariffAmount']['non_nabh_charges'])))
					 {
					 	$service_tot = $service_tot + $serve['TariffAmount']['non_nabh_charges'];//." ".$serve['ServiceBill']['no_of_times'];
					 }
				}
				
				//radiology amount and laboatory amount
				foreach($rad as $key=>$radio)
				{
					if($result['Patient']['id']==$radio['RadiologyTestOrder']['patient_id'])
					{
						$rad_amt=  $rad_amt + $radio['TariffAmount']['non_nabh_charges'];	//radiology amount
					}
				}
				foreach($lab as $labo)
				{
					if($result['Patient']['id']==$labo['LaboratoryTestOrder']['patient_id'])
					{
						$lab_amt = $lab_amt + $labo['TariffAmount']['non_nabh_charges'];	//laboatory amount
					}
				}
				$path = $rad_amt+$lab_amt;	//total amount of radiology and laboratory
			
				$total_amount = $othamt + $service_tot + $total + $path ;
			?>
		
		<?php
			if(!empty($setDiff)){
				$Difflast=array_pop($setDiff[$result['Patient']['id']]);//to get the last element of array and remove the same
				$dispalyArray='Diff= '.$Difflast.' ( ';
				foreach($setDiff[$result['Patient']['id']] as $key=>$indvul){
					$dispalyArray.=$key.' = '.$indvul.', ';
					}
					$dispalyArray.=' )';
					}
		
		//for differance total amount
			/*if(!empty($total_amount))
			{
				 $totalAmount = ("Diff.=".$total_amount."(");
			}
		
			//for other service name and amount
			if(!empty($othnm))
			{
				$othnm;
			}
			if(!empty($othamt))
			{
				"=".$othamt."+";
			}
			$sername = array();
			//$seramt =array();
			//for service name and amount	
			foreach($servicesData as $serve)
		 	{
				 if($result['Patient']['id'] == $serve['ServiceBill']['patient_id'] && (!empty($serve['TariffAmount']['non_nabh_charges'])))
				 {
				 	$sername[] = $serve['TariffList']['name'].'=';
				 	$sername[] = $serve['TariffAmount']['non_nabh_charges'].'+';//." ".$serve['ServiceBill']['no_of_times'];
				 	 
				 }
			}
			unset($service_tot);
	
			//for consultant amount
			if(!empty($total))
			{
				$conso = "Con= ".$total."+";
			}
			unset($val);

			//for pathelogy amount
			if(!empty($path))
			{
				$patha = "Path=".$path;
			}*/
		?><td>
			<?php  echo $dispalyArray;
			//echo $tooltip  = $totalAmount.$othnm.$othamt.implode($sername).$conso.$patha; ?>
		</td>		
		
	                    <td align="right">
		                  <?php echo ceil($pharmacy_charges[$result['Patient']['id']][0]['total']-$pharPaid[$result['Patient']['id']]);
							echo "/"."<br>";							
							echo $this->Number->currency(ceil($total_amount_lab[$result['Patient']['id']]));
							unset($rad_amt);
							unset($lab_amt);
							?>
	                     </td>          
	                     
                     	  <td align="center">
							
							<?php
							$todayPayAmt=$balance+Configure::read('advanceAmtAdd');
							echo !empty($result['Billing']['amount_to_pay_today'])?$result['Billing']['amount_to_pay_today']:$todayPayAmt;
							?>
							
							</td>
							
                        	<td align="center" valign="middle">
							<?php
							echo $result['Patient']['remark'];
							?>
                            </td>
                     		                 		                     		                     		                     		                     		                     		                     		                     		                     								
                     	</TR>
                     	<?php 		 }
                     	          } ?>
                    
</table>
				 <table align="right" width="500px" border='1' class='table_format'>
                     <tr class='row_title'>
                     <td colspan="2">
                     <?php echo "<b>Total Patients = </b>";?>
                     <?php echo "<b>".$patientCnt."<b>"?></td>              
                     </tr>
                     <?php foreach($tariffCount as $key=>$tariff){?>                     
                     <?php if(!empty($key)){?>
                     <tr class='row_title'>
                     <td align="right"><?php echo "<b>".$key."<b>"?></td>
                     <td><?php echo "<b>".$tariff."<b>"?></td>
                     </tr>
                     <?php }?>                     
                     <?php }?>
                </table>
