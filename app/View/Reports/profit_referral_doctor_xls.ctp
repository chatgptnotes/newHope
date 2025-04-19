<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"profit_referral_doctor_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Doctor-wise Receipts  Report" );
ob_clean();
flush();
?>
<div class="inner_title" align="center">
	<h3>
		<?php echo __(' Doctor-wise Receipts Report', true); ?>
</h3>

</div>
<?php if(!empty($data)){?>
<table width="100%" cellpadding="0" cellspacing="2" border="1" 	class="tabularForm" id="content-list"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
	<tr> 
		<th width="2%" align="center" valign="top" style="text-align: center;;">Referral Doctor Name</th>
		<th width="25%" align="center" valign="top" style="text-align: center;;">PatientName<br>SexAge<br></th>
		<th width="25%" align="center" valign="top" style="text-align: center;;">Address <br> City <br> Payer</th>
		<th width="25%" align="center" valign="top" style="text-align: center;;">Admission Date <br> Discharge Date</th>
		<th width="25%" align="center" valign="top" style="text-align: center;;">Marketing Team </th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Yes/No </th>
		<th width="25%" align="center" valign="top" style="text-align: center;;">Spot Amount </th>
		<th width="25%" align="center" valign="top" style="text-align: center;;">Spot Payment date </th>
		<th width="25%" align="center" valign="top" style="text-align: center;;">B Amount </th>
		<th width="25%" align="center" valign="top" style="text-align: center;;">B Payment Date </th>
		<th width="25%" align="center" valign="top" style="text-align: center;;">Discount Given </th>
		<th width="50%" align="center" valign="top" style="text-align: center;;">Total Bill Paid By Patient</th>
		<th width="50%" align="center" valign="top" style="text-align: center;;">Total Bill Excluding Expenses</th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Referal Profit Percent</th>
		<th width="12%" align="center" valign="top" style="text-align: center;;">Referal Profit Amount</th>
		<th width="10%" align="center" valign="top" style="text-align: center;">Profit Amount</th> 
	</tr> 
		<?php
   $toggle =0;
      if(count($patientData) > 0) {
      	$totalprofit = 0;
      	//debug($patientData);exit;
       foreach($patientData as $personval){
		$getexcludingExpProfit=0;$ss='';$getProfitPer=0;$getexcludingExp=0;
       $cnt++;
      /* $p_id = $personval['patient_id'];
       $v_id = $personval['id']['id']; //debug($v_id);exit;*/
        
       
        
	
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
    <td align="center">
    	<?php echo $personval['referal'];

    	if($personval['referal']=='Direct'){
			$disabled='disabled';
		}else{
			$disabled='';
		}?> </td>
    <td align="center">
   		<?php echo $personval['name'].'<br>';?>
		   <?php 
						if($personval['dob'] == '0000-00-00' || $personval['dob'] == ''){
			$age = "";
		}else{
		$date1 = new DateTime($personval['dob']);
		$date2 = new DateTime();
		$interval = $date1->diff($date2);
		$date1_explode = explode("-",$personval['dob']);
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
	}//Gender
		if(strtolower($personval['sex'])=='male'){
				$sex= "M";
			}else if(strtolower($personval['sex'])=='female'){
				$sex= "F";
			}else{
				$sex= "Others";
			} 	
						echo $sex.$age;
		?>
    </td>
     <td  align="center" >
		<?php 
		echo $personval['address'].'<br>'.$personval['city'].'<br>'.$personval['tariff_type'];?>
    </td>
     <td  align="center">
 					<?php  $admissDate= $personval['admission_date'];
						echo $this->DateFormat->formatDate2Local($admissDate,Configure::read('date_format')).'<br>';
						?>
					<?php
						 $disDate = $personval['discharge_date'];
						 echo  $this->DateFormat->formatDate2Local($disDate,Configure::read('date_format'));
						?>
		</td>
     <td  align="center" >
    <?php 
  
    echo $personval['team'];?> </td>
    <td  align="center" > 
    
   <?php   
        if(!empty($personval['paid_amt']))
        {
		 echo "Yes"; 
		}
		else{	 	
		     echo "No";
	        }
	        ?>
  		</td>
    <td  align="center">
    <?php 
/*          echo $this->Form->input('Patient.spot_amount', array('id'=>'sAmt_'.$patient_id,'type' => 'text','style'=>"width:20%",$disabled,'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_s_amount','value'=>$personval['spot_amt']));
 */	 
    if($personval['is_approved']){
    	$disabled='disabled=disabled';
    	$checked='checked=checked';
    }else{
    	$disabled='';
    	$checked='';
    }
 if($personval['type']=='S'){
    	echo 	$personval['paid_amt'].'<br>';
    	$val=$val+ $personval['paid_amt'];
    }else{
			echo '0'.'<br>';;
	 }
    
     ?>		
 </td>
 
  <td  align="center" >
					<?php 
					if($personval['type']=='S'){
							$ss = $personval['voucher_date'];
							echo  $this->DateFormat->formatDate2Local($ss,Configure::read('date_format'));
						  }else{
							echo '--';
						  }
						?>
						</td> 
    <td  align="center" >
    <?php // echo $this->Form->input('b_amount', array('id'=>'bAmt_'.$patient_id,'type' => 'text','label'=>false ,'style'=>"width:100%;",$disabled,'div'=>false,'style'=>"width: 100%;",'class'=>'add_b_amount','value'=>$personval['b_amt']));
				if($personval['type']=='B'){
			    	echo 	$personval['paid_amt'].'<br>';; 
			    	$val1=$val1+ $personval['paid_amt'];
			     }else{
						echo '0'.'<br>';;
				 }
				//echo $this->Form->input('status', array('type' => 'checkbox','class' =>'update_status','id'=>'status_'.$personval['id'],'label' => false,'legend' => false)); ?>
		  </td>
     <td  align="center" >
   
					<?php if($personval['type']=='B'){
							$bb = $personval['voucher_date'];
							echo  $this->DateFormat->formatDate2Local($bb,Configure::read('date_format')); 
						  }else{
							echo '--'.'<br>';;
				 		  }?>
 </td>
      <td  align="center">
   <?php  echo $billData['Bill'][$personval['patient_id']]['discount'];
					?>
 </td>
  
  <td  align="right"><?php 
					  if(!empty($billData['Bill'][$personval['patient_id']]['amount_paid'])){
					   echo $this->Number->format(round($billData['Bill'][$personval['patient_id']]['amount_paid']));
					  }else{
						echo '0';
					  } 
					  $totpatPaid[$personval['patient_id']]=$billData['Bill'][$personval['patient_id']]['amount_paid'];?> </td>
		<td  align="right" ><?php if(!empty($billData['Bill'][$personval['patient_id']]['amount_paid'])){
									$getDiff=$billData['Bill'][$personval['patient_id']]['amount_paid']-$billData['Bill'][$personval['patient_id']]['pharmacyCharges'];
									$getDiffFinal=$getDiff-($billData['Bill'][$personval['patient_id']]['radCharges']+
															$billData['Bill'][$personval['patient_id']]['labCharges']
															);
									$getexcludingExp=$getDiffFinal-$billData['Bill'][$personval['patient_id']]['BloodImplantCharges'];
   										echo $this->Number->format(round($getexcludingExp));   										
 									 }else{
										echo '0';
									}
									$totExcExp[$personval['patient_id']]=$getexcludingExp;
									if(!empty($billData['Bill'][$personval['patient_id']]['pharmacyCharges']))									
										$toolTip.='<b>Phamacy- </b>'.$billData['Bill'][$personval['patient_id']]['pharmacyCharges'].'<br>';
									if(!empty($billData['Bill'][$personval['patient_id']]['radCharges']))
										$toolTip.='<b>Radiology- </b>'.$billData['Bill'][$personval['patient_id']]['radCharges'].'<br>';
									if(!empty($billData['Bill'][$personval['patient_id']]['labCharges']))
										$toolTip.='<b>Laboratory- </b>'.$billData['Bill'][$personval['patient_id']]['labCharges'].'<br>';
									if(!empty($billData['Bill'][$personval['patient_id']]['BloodImplantCharges']))
										$toolTip.='<b>Blood and Implant Charges- </b>'.$billData['Bill'][$personval['patient_id']]['BloodImplantCharges'].'<br>';
									/*if(!empty($billData['Bill'][$personval['patient_id']]['visitCharges']))
										$toolTip.='<b>Visit Charges- </b>'.$billData['Bill'][$personval['patient_id']]['visitCharges'].'<br>';
									if(!empty($billData['Bill'][$personval['patient_id']]['surgeonCharges']))
										$toolTip.='<b>Surgeon Charges- </b>'.$billData['Bill'][$personval['patient_id']]['surgeonCharges'].'<br>';
									if(!empty($billData['Bill'][$personval['patient_id']]['anaesthesiaCharges']))
										$toolTip.='<b>Anaesthesia Charges- </b>'.$billData['Bill'][$personval['patient_id']]['anaesthesiaCharges'].'<br>';*/
									/*if(!empty($personval['spot_amt']))
										$toolTip.='<b>Spot Amount- </b>'.$personval['spot_amt'];
									if(!empty($personval['b_amt']))
										$toolTip.='<b>Backing Amount- </b>'.$personval['spot_amt'];*/
									//print_r($toolTip);
									
									//echo '<br>'.$this->Html->image('/img/icons/vital_icon.png', array('class'=>'tooltip','alt'=>$tooltip));
									
									if($toolTip=='')
										$toolTip='Direct Patient';
									?>
									
									<!--  <span valign="middle" class="td_ht tooltip" title="<?php echo $toolTip ?>" ><?php echo $this->Html->image('/img/icons/vital_icon.png')?></span> </td>
									<?php $toolTip='';?>-->
									<td  align="right"><?php if(!empty($personval['referal_percent'])){
														$getProfitPer=$getexcludingExp*($personval['referal_percent']/100);
														echo $personval['referal_percent'].'%';
													}
								
								 	?> </td>
									 <td  align="right"><?php if(!empty($personval['referal_percent'])){
																$getProfitPer=$getexcludingExp*($personval['referal_percent']/100);
																echo $this->Number->format(round($getProfitPer));
															  }else{
																	echo '0';
															  }
															  
										
															  
									 ?> </td>
										<td  align="right"><?php if($getexcludingExp){
											$getexcludingExpProfit=$getexcludingExp-
											($billData['Bill'][$personval['patient_id']]['visitCharges']+
												$billData['Bill'][$personval['patient_id']]['surgeonCharges']+
												$billData['Bill'][$personval['patient_id']]['anaesthesiaCharges']/*+
												$personval['spot_amt']+$personval['b_amt']*/);
											echo $this->Number->format(round($getexcludingExpProfit));
										}else echo '0';
										if(!empty($billData['Bill'][$personval['patient_id']]['visitCharges']))									
										$extraToolTip.='<b>Visit charges- </b>'.$billData['Bill'][$personval['patient_id']]['visitCharges'].'<br>';
										if(!empty($billData['Bill'][$personval['patient_id']]['surgeonCharges']))
											$extraToolTip.='<b>Surgeon charges- </b>'.$billData['Bill'][$personval['patient_id']]['surgeonCharges'].'<br>';
										if(!empty($billData['Bill'][$personval['patient_id']]['anaesthesiaCharges']))
											$extraToolTip.='<b>Anaesthesia charges- </b>'.$billData['Bill'][$personval['patient_id']]['anaesthesiaCharges'].'<br>';
										/*if(!empty($personval['spot_amt']))
											$extraToolTip.='<b>S amount- </b>'.$personval['spot_amt'].'<br>';
										if(!empty($personval['b_amt']))
											$extraToolTip.='<b>b amount- </b>'.$personval['b_amt'].'<br>';*/
										if(empty($extraToolTip)){
											$extraToolTip='No Deductions';
										}
									?>
										<!--<span valign="middle" class="td_ht tooltip" title="<?php echo $extraToolTip ?>" ><?php echo $this->Html->image('/img/icons/vital_icon.png')?></span> </td>
																			<?php $extraToolTip='';?>-->
										<?php  $totalprofit = $getexcludingExpProfit;
								       $total[$personval['patient_id']]=$totalprofit;
								
									 ?><br>
									 </td>
									 
  								</tr> 
  
  <?php }  
  $queryStr = $this->General->removePaginatorSortArg($queryString);  //for sort column
  $queryStr['from_date'] = $this->DateFormat->formatDate2STDForReport($queryStr['from_date'],Configure::read('date_format'))." 00:00:00";
  $queryStr['to_date'] = $this->DateFormat->formatDate2STDForReport($queryStr['to_date'],Configure::read('date_format'))." 23:59:59"; ?>
  
  <tr> 
	<td  align="center"style="text-align: center;font-weight:bold;"colspan="6">Actual  Amount Receivable </td>			
	<td   align="center"style="text-align: center; font-weight: bold;">
		<?php echo $val ?></td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  ?> </td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  echo $val1?>	</td>
	<td  align="center"style="text-align: center;font-weight:bold;" colspan="2">
		<?php  ?> </td>	
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php foreach($totpatPaid as $tpaid){
			$totalpaid=$totalpaid+$tpaid;
		} 
		 echo $this->Number->format(round($totalpaid)); ?> </td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  foreach($totExcExp as $texp){
			$totalExp=$totalExp+$texp;
		} 
		echo $this->Number->format(round($totalExp));?> </td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  ?> </td>	
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  ?> </td>
    <td  align="center"style="text-align: center;font-weight:bold;">
		<?php foreach($total as $tAmt){
			$totalVal=$totalVal+$tAmt;
		}
		  echo $this->Number->format(round($totalVal)); ?>	</td>
	</tr>
		 
  <?php
      } ?> 
</table>
<?php  } else{   	
  ?>
  <tr>
   <TD colspan="4" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php }?>