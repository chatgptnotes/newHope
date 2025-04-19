<style> 
	.test{margin-left:10px;} 
	.total{
		width:50px
	}
	
	
</style> 
<?php $configStrength = configure::read('strength');?>
<table cellspacing="0" cellpadding="0" border="0"
	class=" row20px">
	<?php 
	$timeBar = "<tr>" ;
	$timeBar .= "<td class='gray-container row21px'>&nbsp;</td>";
	//$timeBar .= "<td class='gray-container doubleClick' id='".date("H").":00-".date("H")."'>".date("H").":00-".date("H")."-59</td>";

	foreach ($reviewData as $dataKey =>$dataValue){		 
		
		$values =  $dataValue['ReviewPatientDetail']['values']  ; 
		$dateArray[$dataValue['ReviewPatientDetail']['date']]
		[$dataValue['ReviewPatientDetail']['hourSlot']][$dataValue['ReviewPatientDetail']['review_sub_categories_id']]
		[$dataValue['ReviewPatientDetail']['review_sub_categories_options_id']]  =
		array('value'=>$values,
				'id'=>$dataValue['ReviewPatientDetail']['id'],
				'flag'=>$dataValue['ReviewPatientDetail']['flag'],
				'flag_date'=>$dataValue['ReviewPatientDetail']['flag_date'],
				'is_deleted'=>$dataValue['ReviewPatientDetail']['is_deleted'] ,
				'is_edited'=>$dataValue['ReviewPatientDetail']['is_edited'],
				'edited_on'=>$dataValue['ReviewPatientDetail']['edited_on'], );
		
	}
	
	$resetMarContinuousData= array();
	 
	foreach ($marContinuousData as $contiKey =>$contiValue){	
		$values =  $contiValue['MedicationAdministeringRecord']['inf_volume_hourly']  ;			 
		//convert date
		$performedDate = $this->DateFormat->formatDate2Local($contiValue['MedicationAdministeringRecord']['performed_datetime'],Configure::read('date_format'),true);
	 
		$resetToStdFormat = $this->DateFormat->formatDate2STDForReport($performedDate,Configure::read('date_format'));
	 	$conDate = date('Y-m-d',strtotime($resetToStdFormat)) ;
		$conTime = date('G',strtotime($resetToStdFormat)) ;
		 
		if($contiValue['MedicationAdministeringRecord']['inf_time_unit']!='hour'){			
			$infusedTime = 1 ; 	
		}else{
			$infusedTime = $contiValue['MedicationAdministeringRecord']['infused_time'] ;
		}
		$c=0;
		if(!empty($infusedTime)){
			$remainingHour  = 24-$conTime;
			$firstRow  = true ; //for the scheduled day
			for($infuse=0;$infuse<$infusedTime;$infuse++){
				if($infuse == $remainingHour || $c==24){
					$conDate = date('Y-m-d',strtotime($conDate.' +1 day'));
					$c = 0;
					$firstRow = false ;
				}
				 
				if($firstRow){
					$marDataArray[$conDate][$conTime+$infuse]
					[$contiValue['NewCropPrescription']['review_sub_category_id']]["crop".$contiValue['NewCropPrescription']['id']]  = $values;
				}else{
					$marDataArray[$conDate][$c]
					[$contiValue['NewCropPrescription']['review_sub_category_id']]["crop".$contiValue['NewCropPrescription']['id']]  = $values;
				}
				$c++;
			}
		}	
		//reset array with unique drug
		$resetMarContinuousData[$contiValue['NewCropPrescription']['id']] =$contiValue ;
	} 

	$resetMarMedicationData=array();
	foreach ($marMedicationData as $contiKey =>$contiValue){
		$values =  $contiValue['MedicationAdministeringRecord']['inf_volume_hourly']  ;			
		//convert date
		$performedDate = $this->DateFormat->formatDate2Local($contiValue['MedicationAdministeringRecord']['performed_datetime'],Configure::read('date_format'),true);
	 
		$resetToStdFormat = $this->DateFormat->formatDate2STDForReport($performedDate,Configure::read('date_format'));
	 	$conDate = date('Y-m-d',strtotime($resetToStdFormat)) ;
		$conTime = date('G',strtotime($resetToStdFormat)) ;
		 	
		$infusedTime = $contiValue['MedicationAdministeringRecord']['inf_time_unit'] ;
		if($contiValue['MedicationAdministeringRecord']['inf_time_unit']!='hour'){
			$infusedTime = 1 ;
		}else{
			$infusedTime = $contiValue['MedicationAdministeringRecord']['infused_time'] ;
		}
		if(!empty($infusedTime)){
			$remainingHour  = 24-$conTime;
			$firstRow  = true ; //for the scheduled day
			$c= 0 ;
			for($infuse=0;$infuse<$infusedTime;$infuse++){
				if($infuse == $remainingHour || $c==24){ 
					$conDate = date('Y-m-d',strtotime($conDate.' +1 day'));
					$c = 0;
					$firstRow = false ;
				}
				//if($contiValue['NewCropPrescription']['id']==2114) echo $conDate ;
				if($firstRow){
					$marDataArray[$conDate][$conTime+$infuse]
					[$contiValue['NewCropPrescription']['review_sub_category_id']]["crop".$contiValue['NewCropPrescription']['id']]  = $values;
				}else{
					$marDataArray[$conDate][$c]
					[$contiValue['NewCropPrescription']['review_sub_category_id']]["crop".$contiValue['NewCropPrescription']['id']]  = $values;
				}
				$c++;
			}
		}	
		//reset array with unique drug
		$resetMarMedicationData[$contiValue['NewCropPrescription']['id']] =$contiValue ;
	} 
	
	/**
		BOF GAURAV
	 */
	$resetMarParenteralData=array();
	foreach ($marParenteralData as $contiKey =>$contiValue){
		$values =  $contiValue['MedicationAdministeringRecord']['inf_volume_hourly']  ;
		//convert date
		$performedDate = $this->DateFormat->formatDate2Local($contiValue['MedicationAdministeringRecord']['performed_datetime'],Configure::read('date_format'),true);
	
		$resetToStdFormat = $this->DateFormat->formatDate2STDForReport($performedDate,Configure::read('date_format'));
		$conDate = date('Y-m-d',strtotime($resetToStdFormat)) ;
		$conTime = date('G',strtotime($resetToStdFormat)) ;
	
		$infusedTime = $contiValue['MedicationAdministeringRecord']['inf_time_unit'] ;
		if($contiValue['MedicationAdministeringRecord']['inf_time_unit']!='hour'){
			$infusedTime = 1 ;
		}else{
			$infusedTime = $contiValue['MedicationAdministeringRecord']['infused_time'] ;
		}
		if(!empty($infusedTime)){
			$remainingHour  = 24-$conTime;
			$firstRow  = true ; //for the scheduled day
			$c= 0 ;
			for($infuse=0;$infuse<$infusedTime;$infuse++){
				if($infuse == $remainingHour || $c==24){
					$conDate = date('Y-m-d',strtotime($conDate.' +1 day'));
					$c = 0;
					$firstRow = false ;
				}
				//if($contiValue['NewCropPrescription']['id']==2114) echo $conDate ;
				if($firstRow){
					$marDataArray[$conDate][$conTime+$infuse]
					[$contiValue['NewCropPrescription']['review_sub_category_id']]["crop".$contiValue['NewCropPrescription']['id']]  = $values;
				}else{
					$marDataArray[$conDate][$c]
					[$contiValue['NewCropPrescription']['review_sub_category_id']]["crop".$contiValue['NewCropPrescription']['id']]  = $values;
				}
				$c++;
			}
		}
		//reset array with unique drug
		$resetMarParenteralData[$contiValue['NewCropPrescription']['id']] =$contiValue ;
	}
	/**
		EOF GAURAV
	 */
	 
	$currentHr = date("H")  ;
	$shiftCount = 1 ;
	//$currentHr =  1 ;
	for($h=$currentHr;$h >=0;$h--){ 
		//nursing working hours 0700-1500(day),1500-2300(eve),2300-0700(night)
		$checkClass = date('Ymd')."_".$h;
		/* if($h==0) $k=24;
		else $k=$h ; */
		
		$k = $h ; //temp swapping
		if($k == 7){
			//night
			$timeBar .= "<td class='gray-container '><div class='time-area'>";
			$timeBar .= "Night" ;
			$timeBar .= "</div></td>" ;
			$shiftCount++;
		}else if($k == 14){
			//morning
			$timeBar .= "<td class='gray-container' ><div class='time-area'>";
			$timeBar .= "Day" ;
			$timeBar .= "</div></td>" ;
			$shiftCount++;
		}else if($k == 22){
			//afternoon
			$timeBar .= "<td class='gray-container'><div class='time-area'>";
			$timeBar .= "Evening" ;
			$timeBar .= "</div></td>" ;
			$shiftCount++;
		}

		$timeBar .= "<td class='gray-container doubleClick ' id='".date('Ymd')."_".$k."'><div class='time-area'>";
		if($h==0)
			$timeBar .= "00:00- 00:59" ;
		else
			$timeBar .= $k.":00- ".$h.":59" ;
		
		$timeBar .='<input  id="check_'.date("Ymd")."_".$k.'" type="checkbox"
				class="'.$checkClass.' dataCheck sub-cat-option" style="display: none;">';
		 
		$timeBar .= "</div></td>" ;
	}

	//Total of the day
	$timeBar .= "<td class='gray-container'  ><div class='time-area'>";
	$timeBar .= "<b>Total</b>" ;
	$timeBar .= "</div></td>" ;
	
	for($j=23;$j >6;$j--){
		$timeBar .= "<td class='gray-container ' id='".date('Ymd',strtotime("+1 day"))."_".$j."'><div class='time-area'>";
		$timeBar .= $j.":00- ".$j.":59" ;
		$timeBar .= "</div></td>" ;
			
	}

	//Total of the day
	$timeBar .= "<td class='gray-container'  ><div class='time-area'>";
	$timeBar .= "<b>Days</b>" ;
	$timeBar .= "</div></td>" ;


	for($k=23;$k >6;$k--){
		$timeBar .= "<td class='gray-container ' id='".date('Ymd',strtotime("-1 day"))."_".$k."'><div class='time-area'>";
		$timeBar .= $k.":00- ".$k.":59" ;
		$timeBar .= "</div></td>" ;

	}

	//Total of the day
	$timeBar .= "<td class='gray-container'><div class='time-area'>";
	$timeBar .= "<b>Days</b>" ;
	$timeBar .= "</div></td>" ; 
	$timeBar .= "</tr>"; 
	?>
	<tr >
		<td>
			 <table cellpadding="0" cellspacing="0">
									<tr class="test">
										<?php  
										$cols= date('H')+1 ;
										$prevDateMDY = date('m/d/Y',strtotime("-1 day")) ;
										$prevDateYMD = date('Y-m-d',strtotime("-1 day")) ;

										$nextDateMDY = date('m/d/Y',strtotime("+1 day")) ;
										$nextDateYMD = date('Y-m-d',strtotime("+1 day")) ;
										?>
										<td class="gray-container"
											style="width: 110px; border-left: none; border-top: none; border-bottom: none; font-size: 10px;">
											<table>
												<tr>
													<td>
														<div style="width:196px;">
															<span id="custom" style="padding-right: 5px; cursor: pointer; cursor: hand;" >Customize</span>
															<span id="treecontrol">
																	<a title="Collapse the entire tree below" href="#nav"> Collapse All</a>
																	<a title="Expand the entire tree below" href="#nav"> Expand All</a>
																</span>
														</div>
													</td>
												</tr>
												<tr>
													<td class="two_img">
														<span>
															<?php echo $this->Html->image('icons/refresh-icon.png',array('id'=>'refresh-data','alt'=>'Refresh data'));?>
														</span>
														<span><input type="hidden" id="io-back-date" /></span>
														<span id="icon-div">
														<?php echo $this->Html->image('../img/icons/icon_tick.gif', array('alt' => 'Save','title' => 'Save','class'=>'save-data'))?>
														</span>
													</td>
												</tr>
											</table>											 
										</td>
										<td class="gray-container" colspan=<?php echo $currentHr+$shiftCount+1 ;?>><?php echo date('m/d/Y');?>
										</td>
								<!--  <td class="gray-container">&nbsp;</td> -->		
										<td class="gray-container" colspan=18 ><?php echo date('m/d/Y',strtotime("+1 day"));?>
										</td>
										<td class="gray-container" colspan=18 ><?php echo date('m/d/Y',strtotime("-1 day"));?>
										</td>
									</tr>
									<?php echo $timeBar; ?>
								</table> 
			</td>
	</tr>
	<?php 
	//timebar html
	//echo $timeBar ;
	$count = count($subCatOptions);
	echo $this->Form->hidden('timeslot',array('id'=>'timeslot')) ;	
	echo $this->Form->hidden('subCategory',array('id'=>'subCategory','value'=>$subCategoryID))  ;
	echo $this->Form->hidden('layout',array('id'=>'layout','value'=>'io'))  ;
	echo $this->Form->hidden('current-url',array('id'=>'current-url','value'=>$this->here))  ;
	
	//BOF total calculation
	foreach ($subCatOptions as $optionKey =>$optionValue){
		$pre = 0 ;
		if(strtolower($optionValue['ReviewSubCategory']['parameter'])=='intake' && $intake==0){
			$intake = 1 ;
		}else if(strtolower($optionValue['ReviewSubCategory']['parameter'])=='output' && $output==0){
			$output=1;
		}
		if(strtolower($optionValue['ReviewSubCategory']['parameter'])=='intake'){
			$str = 'intake';
		}else{
			$str = 'output' ;
		}
		$subCatName = strtolower($optionValue['ReviewSubCategory']['name']);
		
		if($subCatName=='continuous infusion'){
				$arrayOfOptions = $resetMarContinuousData ;
		}else if($subCatName=='medications'){
				$arrayOfOptions = $resetMarMedicationData ;
		}else{
				$arrayOfOptions =$optionValue['ReviewSubCategoriesOption'] ;
		}
		  
		foreach ($arrayOfOptions as $subOptionKey =>$subOptionValue){
			if(strtolower($subCatName)=='continuous infusion' || strtolower($subCatName)=='medications'){
				$subOptionValueID = "crop".$subOptionValue['NewCropPrescription']['id'] ;
				$subOptionValueName = $subOptionValue['NewCropPrescription']['drug_name'] ;
				$isMar = true ;
				$str = 'intake' ;
			}else{
				$subOptionValueID =$subOptionValue['id'] ;
				$subOptionValueName  = $subOptionValue['name'] ;
				$isMar = false ;
			}
			//today			
			for($h=$currentHr;$h >=0;$h--){
				$currentDayT =  $dateArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['value'] ; 
				if($currentDayT ==0) continue ; //for 0
				if($dateArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['is_deleted']==1) continue ;//dont count deleted entry
				$currentSubCatTotal += $currentDayT  ;
				$datewiseSubCat[date('Y-m-d')][$h][$str][] = $currentDayT; 
				$datewiseSubCat[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][]= $currentDayT ; 
				//calculate shift count  
				if($h > 14 && $h <=23){									 
					$datewiseSubCat[date('Y-m-d')][$str]['day'][] 		= $currentDayT ;
					$datewiseSubCat[date('Y-m-d')]['shift_option']['day'][$optionValue['ReviewSubCategory']['id']][] = $currentDayT;
					$datewiseSubCat[date('Y-m-d')]['shift_sub_option']['day'][$subOptionValueID][] = $currentDayT;
				}else if($h > 7 && $h <=14){				
					$datewiseSubCat[date('Y-m-d')][$str]['morning'][] 	= $currentDayT ;
					$datewiseSubCat[date('Y-m-d')]['shift_option']['morning'][$optionValue['ReviewSubCategory']['id']][] = $currentDayT;
					$datewiseSubCat[date('Y-m-d')]['shift_sub_option']['morning'][$subOptionValueID][] = $currentDayT;
				}else{				 
					$datewiseSubCat[date('Y-m-d')][$str]['night'][] 	= $currentDayT ;
					$datewiseSubCat[date('Y-m-d')]['shift_option']['night'][$optionValue['ReviewSubCategory']['id']][] = $currentDayT;
					$datewiseSubCat[date('Y-m-d')]['shift_sub_option']['night'][$subOptionValueID][] = $currentDayT;
				}
				//EOF shift count 
			}
			//tomarrow			
			for($t=23;$t >6;$t--){
				$tomarrowDayT =  $dateArray[date('Y-m-d',strtotime('+1 day'))][$t][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['value'] ;
				if($tomarrowDayT ==0) continue ; //for 0
				if($dateArray[date('Y-m-d',strtotime('+1 day'))][$t][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['is_deleted']==1) continue ;
				$tomarrowSubCatTotal += $tomarrowDayT  ;
				$datewiseSubCat[date('Y-m-d' ,strtotime('+1 day'))][$h][$str][] = $tomarrowDayT;
			}
			//yesterday
			for($y=23;$y >6;$y--){
				$yesterDayT =  $dateArray[date('Y-m-d',strtotime('-1 day'))][$y][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['value'] ;
				if($yesterDayT ==0) continue ; //for 0
				if($dateArray[date('Y-m-d',strtotime('-1 day'))][$t][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['is_deleted']==1) continue ;
				$yesterSubCatTotal += $yesterDayT  ;
				$datewiseSubCat[date('Y-m-d' ,strtotime('-1 day'))][$h][$str][] = $yesterDayT;
			}
			$pre++; 
		} 
		if(strtolower($optionValue['ReviewSubCategory']['parameter'])=='intake' || $isMar==true){
			 $currentIntakeTotal += $currentSubCatTotal ;
			 $yesterIntakeTotal  += $yesterSubCatTotal ;
			 $tomarrowIntakeTotal  += $tomarrowSubCatTotal ;
		}else if(strtolower($optionValue['ReviewSubCategory']['parameter'])=='output'){
			 $currentOutputTotal += $currentSubCatTotal ;
			 $yesterOutputTotal  += $yesterSubCatTotal ;
			 $tomarrowOutputTotal  += $tomarrowSubCatTotal ;
		}
		$varname            = clean($optionValue['ReviewSubCategory']['name']);
		//set array for datewise subtotal 
		$datewiseSubCat[date('Y-m-d')][$varname] =   $currentSubCatTotal ; 
	    $datewiseSubCat[date('Y-m-d' ,strtotime('-1 day'))][$varname] =   $yesterSubCatTotal ; 
	    $datewiseSubCat[date('Y-m-d' ,strtotime('+1 day'))][$varname] =   $tomarrowSubCatTotal ;
	    
		$currentSubCatTotal = '' ;
		$yesterSubCatTotal ='';
		$tomarrowSubCatTotal='';
	}
	//EOF total calculation
	 
	function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	  
	?>
	<tr>
		<td><div>
				<ul id="io-browser" class="filetree treeview-famfamfam treesubmenu">
					<?php 
					 
						$intake = 0 ; //for intake total header to display once in loop
						$output = 0 ; //same for output total 
						 
						foreach ($subCatOptions as $optionKey =>$optionValue){
							$catName = clean(strtolower($optionValue['ReviewSubCategory']['name']))."_".$optionValue['ReviewSubCategory']['id'] ;	
							$subCatName = strtolower($optionValue['ReviewSubCategory']['name']);
							if($subCatName=='continuous infusion' || $subCatName=='medications'){ //From mar								
							}else{ 
								$isCustomized = $customiztionData[$catName] ;								 
								if($isCustomized != '' && (int)$customiztionData[$catName] === 0){ //customization for patient
									continue ;
								}
							}
							if(strtolower($optionValue['ReviewSubCategory']['parameter'])=='intake' && $intake==0){
							$intake = 1 ;
						?>
						<li >
							<table>
								<tr class="treesubmenu">
									<td style="border-style: none; width: 188px;"><span
										class="folder1" style="display: inline; color: white;">Intake Total</span>
									</td>
									<?php  for($h=$currentHr;$h >=0;$h--){ 
											$checkClass = date('Ymd')."_".$h;
											$timeBar = '' ;
											if($h == 7){
												//night
												$timeBar = "<td class='size50' ><div class='time-area'>";												 
												$total8 =  array_sum($datewiseSubCat[date('Y-m-d')]['intake']['night']) ; 
												$timeBar .= ($total8>0)?$total8:'' ;
												$timeBar .= "</div></td>" ;
											}else if($h == 14){
												//morning
												$timeBar = "<td  class='size50' ><div class='time-area'>";
												$total9 =  array_sum($datewiseSubCat[date('Y-m-d')]['intake']['morning']) ; 
												$timeBar .= ($total9>0)?$total9:'' ; 
												$timeBar .= "</div></td>" ;
											}else if($h == 22){
												//afternoon
												$timeBar = "<td class='size50'><div class='time-area'>";
												$total10 =  array_sum($datewiseSubCat[date('Y-m-d')]['intake']['day']) ;
												$timeBar .= ($total10>0)?$total10:'' ; 
												$timeBar .= "</div></td>" ;
											}
											echo $timeBar ;
										?>
									<td class="size50">
										<div    >
											<?php $intakeSum  = array_sum($datewiseSubCat[date('Y-m-d')][$h]['intake']) ;
												  if($intakeSum > 0) echo $intakeSum;
											?>	 
										</div>
									</td>
									<?php } ?>			
									<!-- Total of the day  -->
									<td  >
										<div class='total'>
											<?php echo  ($currentIntakeTotal)?$currentIntakeTotal:'' ;?>
										</div>
									</td>						
									<?php  for($j=23;$j >6;$j--){
										$checkClass = date('Ymd',strtotime("+1 day"))."_".$j;
										?>
									<td><div class="size50">
											<?php $yesterIntake = array_sum($datewiseSubCat[date('Y-m-d',strtotime("+1 day"))][$j]['intake']) ; 
												  if($yesterIntake > 0) echo $yesterIntake ;
											?>
										</div>
									</td>
									<?php }?>
									<!-- Total of the day  -->
									<td  >
										<div class='total'>
											<?php echo ($tomarrowIntakeTotal)?$tomarrowIntakeTotal:''  ;?>
										</div>
									</td>										
									<?php  for($j=23;$j >6;$j--){
										$checkClass = date('Ymd',strtotime("-1 day"))."_".$j;
										?>
									<td><div class="size50" >
											<?php echo array_sum($datewiseSubCat[date('Y-m-d',strtotime("-1 day"))][$j]['intake']) ; ?>
										</div>
									</td>
									<?php }?>
									<!-- Total of the day  -->
									<td  >
										<div class='total'>
											<?php echo ($yesterIntakeTotal)?$yesterIntakeTotal:'' ?>
										</div>
									</td>	
								</tr>
							</table>							 
						<?php }else if(strtolower($optionValue['ReviewSubCategory']['parameter'])=='output' && $output==0){
							$output=1;
							?> 
						<li class="custom-li" >
							<table>
								<tr class="treesubmenu">
									<td style="border-style: none; width: 188px;"><span
										class="folder1" style="display: inline; color: white;">Output Total</span>
									</td>
									<?php  for($h=$currentHr;$h >=0;$h--){
										$timeBar = '' ;
										
										if($h == 7){ 
											//night
											$timeBar = "<td class='border' ><div class='time-area'>";										 
											$total5 = array_sum($datewiseSubCat[date('Y-m-d')]['output']['night']) ;
											$timeBar .= ($total5>0)?$total5:'' ;
											$timeBar .= "</div></td>" ;
										}else if($h == 14){
											//morning 
											$timeBar = "<td  class='border' ><div class='time-area'>";
											$total6 = array_sum($datewiseSubCat[date('Y-m-d')]['output']['morning']) ;
											$timeBar .= ($total6>0)?$total6:'' ;										 
											$timeBar .= "</div></td>" ;
										}else if($h == 22){
											//afternoon
											$timeBar = "<td class='border' ><div class='time-area'>";
											$total7 = array_sum($datewiseSubCat[date('Y-m-d')]['output']['days']) ;
											$timeBar .= ($total7>0)?$total7:'' ; 
											$timeBar .= "</div></td>" ;
										}
										echo $timeBar ; 
										
										?>
									<td>
										<div class="size50" >
											<?php $outputTotal  = array_sum($datewiseSubCat[date('Y-m-d')][$h]['output']) ; 
												   if($outputTotal > 0) echo $outputTotal ;
											?>
										</div>
									</td>
									<?php  }   ?>
									<!-- Total of the day  -->
									<td>
										<div class='total'>
											<?php echo ($currentOutputTotal)?$currentOutputTotal:'' ; ?>
										</div>
									</td>	
									<?php  for($j=23;$j >6;$j--){ ?>
									<td><div class="size50" >
										<?php echo array_sum($datewiseSubCat[date('Y-m-d',strtotime("+1 day"))][$j]['output']) ; ?>
									</div>
									</td>
									<?php }?>			
									<!-- Total of the day  -->
									<td>
										<div class='total'>
											<?php echo ($tomarrowOutputTotal)?$tomarrowOutputTotal:''; ?>
										</div>
									</td>							
									<?php  for($j=23;$j >6;$j--){ ?>
									<td><div class="size50" >
										<?php $yesterOutput  =  array_sum($datewiseSubCat[date('Y-m-d',strtotime("-1 day"))][$j]['output']) ; 
											  if($yesterOutput > 0) echo $yesterOutput ;
										?>
									</div>
									</td>
									<?php }?>
									<!-- Total of the day  -->
									<td>
										<div class='total'>
											<?php echo ($yesterOutputTotal)?$yesterOutputTotal:'' ; ?>
										</div>
									</td>	
								</tr>
							</table>							
						<?php } //start of sub category options?>
						<ul>
							<li id="<?php echo clean($optionValue['ReviewSubCategory']['name']); ?>">
								<table class="treesubmenu">
									<tr>
										<td style="border-style: none; width: 172px;" title="<?php echo $optionValue['ReviewSubCategory']['name'] ;?>"><span
											class="folder1" style="display: inline; color: white;">
												<?php 
													//echo $optionValue['ReviewSubCategory']['name'];
													echo $this->General->truncate($optionValue['ReviewSubCategory']['name'],IVSTRLEN);
												 ?>
										</span></td> 
										<?php  
										for($h=$currentHr;$h >=0;$h--){
											$className = date('Ymd')."_".$h;
											$timeBar = '' ;
											if($h == 7){
												//night
												$timeBar = "<td class='border' ><div class='time-area'>";
												$total2 = array_sum($datewiseSubCat[date('Y-m-d')]['shift_option']['night'][$optionValue['ReviewSubCategory']['id']]) ;
												$timeBar .= ($total2>0)?$total2:'' ; 
												$timeBar .= "</div></td>" ;
											}else if($h == 14){
												//morning
												$timeBar = "<td  class='border'><div class='time-area'>";
												$total3 = array_sum($datewiseSubCat[date('Y-m-d')]['shift_option']['morning'][$optionValue['ReviewSubCategory']['id']]) ;
												$timeBar .= ($total3>0)?$total3:'' ;
												$timeBar .= "</div></td>" ;
											}else if($h == 22){
												//afternoon
												$timeBar = "<td class='border' ><div class='time-area'>";
												$total4  = array_sum($datewiseSubCat[date('Y-m-d')]['shift_option']['day'][$optionValue['ReviewSubCategory']['id']]) ;
												$timeBar .= ($total2>0)?$total2:'' ;
												$timeBar .= "</div></td>" ;
											}
											echo $timeBar ;
											?>
										<td>
											<div  class="<?php echo $className ?> sub-cat-option size50 ">
												<?php $total1 = array_sum($datewiseSubCat[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']]) ;
													  echo ($total1>0)?$total1:'' ;
												?>
											</div>
										</td>
										<?php } ?>
										<!-- Total of the day  -->
										<td>
										<div class='total'>
												<?php $varname = clean($optionValue['ReviewSubCategory']['name']) ; 
													  echo   $datewiseSubCat[date('Y-m-d')][$varname]  ; 
												?>
											</div>
										</td>	
										<?php  for($j=23;$j >6;$j--){ ?>
										<td><div style="width: 50px;">&nbsp;</div>
										</td>
										<?php }?>	
										<!-- Total of the day  -->
										<td>
										<div class='total'>
												<?php  
													echo   $datewiseSubCat[date('Y-m-d',strtotime('+1 day'))][$varname]  ;
												?>
											</div>
										</td>										
										<?php  for($j=23;$j >6;$j--){ ?>
										<td><div style="width: 50px;">&nbsp;</div>
										</td>
										<?php }?>
										<!-- Total of the day  -->
										<td>
										<div class='total'>
												<?php  
													echo   $datewiseSubCat[date('Y-m-d',strtotime('-1 day'))][$varname]  ;
												?>
											</div>
										</td>	
									</tr>
								</table>
								<ul>
									<?php 
									$r =0;
									$marClass = '' ;
								 	
								 	 
									if($subCatName=='continuous infusion'){ 
											$arrayOfOptions = $resetMarContinuousData ;
									}else if($subCatName=='medications'){
											$arrayOfOptions = $resetMarMedicationData ;
									}else if($subCatName=='parenteral'){
											$arrayOfOptions = $resetMarParenteralData ;
									}else{
											$arrayOfOptions =$optionValue['ReviewSubCategoriesOption'] ;
									}
									 
									//if...else for normal IV and medication order set 
									foreach ($arrayOfOptions as $subOptionKey =>$subOptionValue){
										if($subCatName=='continuous infusion' || $subCatName=='medications' || $subCatName=='parenteral'){ //From mar 
											$subOptionValueID = "crop".$subOptionValue['NewCropPrescription']['id'] ;
											$subOptionValueName = $subOptionValue['NewCropPrescription']['drug_name'] ;
											$isMar= true ;
											$unit = '' ;
											if(!empty($subOptionValue['NewCropPrescription']['strength']))
												$unit  = " <i style='float:right'>".$configStrength[$subOptionValue['NewCropPrescription']['strength']]."</i>" ;
										}else{
											$subOptionValueID =$subOptionValue['id'] ;
											$subOptionValueName  = $subOptionValue['name'] ;
											$isMar= false ;
											$optionName  = strtolower(clean($subOptionValueName)."_".$subOptionValueID) ; 
										 	
											$isOptCustomized = $customiztionData[$optionName] ;								 
											if($isOptCustomized != '' && (int)$isOptCustomized === 0){ //customization for patient
												continue ;
											}
											$unit = '' ;
											if(!empty($subOptionValue['unit']))
												$unit  = " <i style='float:right'>".$subOptionValue['unit']."</i>" ;
										}  
										
										?>
									<li><table>
											<tr> 
												<td class="container" style="width: 170px;" title="<?php echo $subOptionValue['name'] ;?>">
													<?php 														
														echo $this->General->truncate($subOptionValueName,IVSTRLEN).$unit; 
													?>
												</td>  												
												<?php  $className = "to-save" ;   $className = "" ; ?>
												<?php  for($h=$currentHr;$h >=0;$h--){
													$className = date('Ymd')."_".$h;
													$timeBar = '' ; 
												 	$currentDay =  $dateArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['value'] ;
													  
													//calculate total
													if($h > 14 && $h <=23){
														$afternoonTotal += $currentDay ;
													}else if($h > 7 && $h <= 14){
														$morningTotal += $currentDay ;
													}else{
														$nightTotal += $currentDay ;
													}
													//EOF calculation


													if($h == 7){
														//night
														$timeBar = "<td  ><div class='time-area'>";
														$total11 = array_sum($datewiseSubCat[date('Y-m-d')]['shift_sub_option']['night'][$subOptionValueID]) ;
														$timeBar .= ($total11>0)?$total11:'' ;
														$timeBar .= "</div></td>" ;
													}else if($h == 14){
														//morning
														$timeBar = "<td   ><div class='time-area'>";
														$total12 = array_sum($datewiseSubCat[date('Y-m-d')]['shift_sub_option']['morning'][$subOptionValueID]) ;
														$timeBar .= ($total12>0)?$total12:'' ;
														$timeBar .= "</div></td>" ;
													}else if($h == 22){
														//afternoon
														$timeBar = "<td  ><div class='time-area'>";
														$total13 = array_sum($datewiseSubCat[date('Y-m-d')]['shift_sub_option']['day'][$subOptionValueID]) ;
														$timeBar .= ($total13>0)?$total13:'' ;
														$timeBar .= "</div></td>" ;
													}

													echo $timeBar ;
													
													if(!empty($currentDay)) {
														$marClass = '' ;
														$rightClickClasses = 'context-menu-one box menu-1' ;
														$patientDetailID = 'detail-id="'.$dateArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['id'].'"' ; // ID of current cell
													}else{  
														$marClass = 'cell-color' ;
														$rightClickClasses = '' ;
														$patientDetailID = '' ;
													}
													 
													
													if($dateArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['flag']==1){ //display  flag
														$flagHtml =  $this->Html->image('icons/flag.png',array('class'=>'flag','title'=>$dateArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['flag_date']));
													}else{
														$flagHtml = '' ;
													}
													 
													if($dateArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['is_edited']==1){ //display triangle
														$triagleHtml =  $this->Html->image('icons/triangle.png',array('style'=>'float:right;','title'=>$dateArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['edited_on']));
													}else{
														$triagleHtml = '' ;
													}
													
													?>
												<td> 										 
													<div    <?php echo $patientDetailID; ?>  class="container <?php echo $className." ".$marClass." ".$rightClickClasses ;?>"  
														id="<?php echo $optionValue['ReviewSubCategory']['id']."-name-".$subOptionValueID?>">&nbsp;<?php
														echo $flagHtml ;
														echo $triagleHtml ;
														$is_deleted  = $dateArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['is_deleted'] ; 
														if($currentDay > 0 || $is_deleted==1){ 
															if($is_deleted==1) echo "In Error" ;
															else echo ($currentDay > 0)?$currentDay:'&nbsp;' ;
														}else{														 
															echo $marDataArray[date('Y-m-d')][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValueID].'&nbsp;'; 
														} 														
														$currentDayTotal   = $currentDay + $currentDayTotal ;
														$subCatOptionTotal += $currentDay  ;
														?>
													</div>
												</td>
												<?php  	} ?>
												<!-- Total of the day  -->
												<td>
													<div class='total'>
														<?php echo $subCatOptionTotal ;
														$subCatOptionTotal='';
														?>
													</div>
												</td>
												<?php  for($j=23;$j >6;$j--){
													$className =   date('Ymd',strtotime("+1 day"))."_".$j; 
													$tommarowVal = $dateArray[date('Y-m-d',strtotime("+1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['value'] ;
													if($tommarowVal > 0){
														$marClass = '' ;
													}else{
														$marClass = 'cell-color' ;
													}
													?>
												<td>
													<div   class="container <?php echo $className ." ".$marClass;?>" 	id="<?php echo $optionValue['ReviewSubCategory']['id']."-name-".$subOptionValueID?>">
														<?php  
															$is_deleted  = $dateArray[date('Y-m-d',strtotime("+1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['is_deleted'] ;
															
															if($tommarowVal > 0 || $is_deleted==1){
																if($is_deleted==1) echo "In Error" ;
																else echo ($tommarowVal > 0)?$tommarowVal:'&nbsp;' ;
															}else{
																echo $marDataArray[date('Y-m-d',strtotime("+1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$subOptionValueID].'&nbsp;';
															}
														
														//echo $tomarrowSubCatOpt =  $dateArray[date('Y-m-d',strtotime("+1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['value'] ;
														$tomarrowSubCatOptTotal += $tommarowVal;
														?>
													</div>
												</td>
												<?php }?>
												<!-- Total of the day  -->
												<td>
													<div class='total'>
														<?php echo $tomarrowSubCatOptTotal ; 
																	$tomarrowSubCatOptTotal='';?>
													</div>
												</td>
												<?php  for($j=23;$j >6;$j--){ 
															$className =   date('Ymd',strtotime("-1 day"))."_".$j;
															$yesterVal = $dateArray[date('Y-m-d',strtotime("-1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['value'] ;
															if($yesterVal > 0){
																$marClass = '' ;
															}else{
																$marClass = 'cell-color' ;
															}
												?>
												<td>
													<div class="container <?php echo $className." ".$marClass ;?>"
														id="<?php echo $optionValue['ReviewSubCategory']['id']."-name-".$subOptionValueID?>">
														<?php  
															$is_deleted  = $dateArray[date('Y-m-d',strtotime("-1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['is_deleted'] ;
																
															if($yesterVal > 0 || $is_deleted==1){
																if($is_deleted==1) echo "In Error" ;
																else echo ($yesterVal > 0)?$yesterVal:'&nbsp;' ;
															}else{
																echo $marDataArray[date('Y-m-d',strtotime("-1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$subOptionValueID].'&nbsp;';
															}
															//echo $yesterSubCatOpt= $dateArray[date('Y-m-d',strtotime('-1 day'))][$j][$optionValue['ReviewSubCategory']['id']][$subOptionValueID]['value'] ;
															$yesterSubCatOptTotal += $yesterVal;
														?>
													</div>
												</td>
												<?php }?>
												<!-- Total of the day  -->
												<td>
													<div class='total'>
														<?php echo $yesterSubCatOptTotal; $yesterSubCatOptTotal='';?>
													</div>
												</td>
											</tr>
										</table>
									</li>
									<?php $r++;  
} ?>
								</ul> 
							</li>
						</ul> 
					<?php //if($output==1) echo "</li>"; 

}  ?> 
					</li> 
				</ul>
			</div> 
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr >
					<td style="border-style: none; width: 202px;"><span class="folder1"
						style="display: inline; color: white;">Balance</span>
					</td>
					<?php  for($h=$currentHr;$h >=0;$h--){ 
						$checkClass = date('Ymd')."_".$h;
						$timeBar = '' ;
						if($h == 7){
							//night
							$timeBar  = "<td class='size50' ><div class='time-area'>";
							$timeBar .= $total14 =  $total8-$total5 ; 
							$timeBar .= "</div></td>" ;
						}else if($h == 14){
							//morning
							$timeBar  = "<td  class='size50' ><div class='time-area'>";
							$timeBar .= $total14 =  $total9-$total6 ; 
							$timeBar .= "</div></td>" ;
						}else if($h == 22){
							//afternoon
							$timeBar  = "<td class='size50'><div class='time-area'>";
							$timeBar .= $total14 =  $total10-$total7 ; 
							$timeBar .= "</div></td>" ;
						}
						echo $timeBar ;
											?>
					<td class="size50">
						<div>
							<?php   $balanceIntakeSum  = array_sum($datewiseSubCat[date('Y-m-d')][$h]['intake']) ;
									$balanceOutputSum  = array_sum($datewiseSubCat[date('Y-m-d')][$h]['output']) ;
						 			echo $balanceIntakeSum - $balanceOutputSum ; 
							?>
						</div>
					</td>
					<?php } ?>
					<!-- Total of the day  -->
					<td>
						<div class='total'>
							<?php echo   $currentIntakeTotal-$currentOutputTotal ;?>
						</div>
					</td>
					<?php  for($j=23;$j >6;$j--){ ?>
					<td><div class="size50">
							<?php $balanceYesterIntake = array_sum($datewiseSubCat[date('Y-m-d',strtotime("+1 day"))][$j]['intake']) ; 
								  $balanceYesterOutput = array_sum($datewiseSubCat[date('Y-m-d',strtotime("+1 day"))][$j]['output']) ;
								  echo $balanceYesterIntake - $balanceYesterOutput ;
							?>
						</div>
					</td>
					<?php }?>
					<!-- Total of the day  -->
					<td>
						<div class='total'>
							<?php echo ($tomarrowIntakeTotal)?$tomarrowIntakeTotal:''  ;?>
						</div>
					</td>
					<?php  for($j=23;$j >6;$j--){
						$checkClass = date('Ymd',strtotime("-1 day"))."_".$j;
					?>
					<td><div class="size50">
							<?php echo array_sum($datewiseSubCat[date('Y-m-d',strtotime("-1 day"))][$j]['intake']) ;  
								$balanceTomarrowIntake = array_sum($datewiseSubCat[date('Y-m-d',strtotime("-1 day"))][$j]['intake']) ;
								$balanceTomarrowOutput = array_sum($datewiseSubCat[date('Y-m-d',strtotime("-1 day"))][$j]['intake']) ;
								echo $balanceTomarrowIntake - $balanceTomarrowOutput ; 
							?>
						</div>
					</td>
					<?php }?>
					<!-- Total of the day  -->
					<td>
						<div class='total'>
							<?php echo ($yesterIntakeTotal)?$yesterIntakeTotal:'' ?>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>  
<script>
	$(document).ready(function(){

		var lastid = '';
		$("#io-browser").treeview({
			toggle: function() {
				 
			},
			animated:"slow",
			control: "#treecontrol",  
			
		});
		
	 
			
		$(".allcheck").click(function() {
			var className = this.id.replace(/\s/gi, ""); 
			if($("#" + className).is(':checked')){
				$("div").find("."+className).removeClass('inactive');
			}else{
				$("div").find("."+className).addClass('inactive');
			}
			
		}); 

		$("#io-back-date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'yymmdd',
			minDate : new Date($("#form_received_on").val()),
			//maxDate : new Date(),
			onSelect:function(dateText, inst){
				//splittedDate = dateText.split('_'); 	 
				yyyymmdd  = dateText.substr(0,4)+"-"+dateText.substr(4,2)+"-"+dateText.substr(6,2)  ; 
				//render selected date io chart for back date entry	 
				$.ajax({
					  beforeSend: function(){
						  loading(); // loading screen
					  },
					  type:'post',
					  data:"backcharting=yes&date="+yyyymmdd ,
				      url: "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "getExcelLayoutForIO",$patient_id,$subCategoryID, "admin" => false)); ?>",
				      context: document.body,
				      success: function(data){ 
				    	  onCompleteRequest(); //remove loading sreen
				    	  $("#excelArea").html(data).fadeIn('slow');
					  }
				});
			}
		}); 
	});
 
	
	$('#custom').click(function(){ 
		$.fancybox({ 
			'width':1000,
			'height':800,
		    'autoScale': true, 
		    'href': "<?php echo $this->Html->url(array("controller" => "nursings", "action" => "category_customization",$patient_id,$subCategoryID)); ?>",
		    'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	true,
			'onStart'		:   function(){
										loading();
								},
			'onComplete'    :   function(){
									onCompleteRequest();
								},
			'type':'iframe'
			 
	    }); 
	});

	
	function collapseExpandAll($flag){
		
		if(!$flag){
			
			$('#io-browser').each(function(){
				$(this).find('ul').css('display', 'block');
			});
		}else{
		
			$("#io-browser").treeview({
				toggle: function() {
					alert("dfghdfh");
					//console.log("%s was toggled.", $(this).find(">span").text());
				},
				animated:"slow",
				collapsed: true,
				unique: true,
				
			});
		}
	}
</script>
