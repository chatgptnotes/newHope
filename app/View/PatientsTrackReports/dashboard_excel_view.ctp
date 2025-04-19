<!-- 
/*
*  Every ID and Class is meaningful, each one is either used for css or js calls.
*
*/
-->
<?php ///ebug($medicationTiming)['0']['3'];
if(isset($medicationTiming['0']['3']))
	$newTimingArray = array_values(array_unique(array_merge($medicationTiming['0']['0'], $medicationTiming['0']['1'],$medicationTiming['0']['3'])));
else
	$newTimingArray = array_values(array_unique(array_merge($medicationTiming['0']['0'], $medicationTiming['0']['1'])));
for($i=0;$i<count($newTimingArray);$i++){
	$demoArrayStr[] = strtotime($newTimingArray[$i]);
}
	array_multisort($newTimingArray, SORT_DESC, $demoArrayStr);
	$newTimingArray = array_values(array_unique(array_merge($newTimingArray,$medicationTiming['0']['2'])));
$excelTdCount = count($newTimingArray);
$configRoute = configure::read('route_administration');
$configStrength = configure::read('strength');?>
<table cellspacing="0" cellpadding="0" border="0" class="row20px "
		width="96%">
		<tr style="background: #31393B;">
		<?php  $dateBack = substr($this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s',strtotime("-1 day")),Configure::read('date_format'),true),0 , 16);
			  $dateFront = substr($this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s',strtotime("+1 day")),Configure::read('date_format'),true),0 , 16);;?>
			<td style="text-align: center; color:#DDDDDD;" ><?php echo __($dateBack." - ".$dateFront." (Clinical Range)");?>
			</td>
		</tr>
</table>
<div class="obj" style="overflow:scroll;" >
	<table cellspacing="0" cellpadding="0" border="1" class="" 
		width="100%">
		<?php	
		for($cntVar = 0; $cntVar<count($newTimingArray); $cntVar++){
				$timBarArray = substr($this->DateFormat->formatDate2LocalForReport($newTimingArray[$cntVar],Configure::read('date_format'),true),0 , 16);
				if(substr($timBarArray,2, 1) == '/' ){
					$timeBar .= "<td style='width: 175px; color:#DDDDDD; text-align: center; font-size:12px'>$timBarArray</td>";
					$menuVar= true;//for js use only
					
				}$timBarArray = '';
			}
			?>
		
		<tr style="background: #31393B;">
			<td style="background: #31393B;   border:none; color: #dddddd; " colspan="1"><b>Medication</b></td>
			<?php //timebar html
				echo $timeBar ;
			?>
		</tr>
		<?php if(!empty($scheduledMedication)): ?>
			<tr style="background-color: #106A93">
				<td colspan="<?php echo $excelTdCount+1; ?>"><b><?php echo __('Scheduled');?></b>
				</td>
			</tr><?php $foreachCntr=0;?>
			<?php foreach($scheduledMedication as $schMed){//#DDDDDD//106A93?>
			<tr style="background-color: #DBEAF9;" ><!-- id used at right click function -->
				<td colspan="" style="color: #4F4F4F;background:#DBEAF9;" id=<?php echo $schMed['NewCropPrescription']['id'];?> class="context-menu-one box menu-1" ><b><?php echo $schMed['NewCropPrescription']['drug_name']; ?>
				</b><br>&nbsp;<?php echo rtrim($schMed['PatientOrder']['sentence'], ","); ?>
				</td>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){?>
				<?php if(in_array($newTimingArray[$cnt], $medicationTiming[1][$schMed['NewCropPrescription']['description']])){?>
				<?php $toolTip = 'Medication : '.$schMed['NewCropPrescription']['drug_name'].'</br>
								Dose : '.$schMed['NewCropPrescription']['dose'].' '.$configStrength[$schMed['NewCropPrescription']['strength']].' </br>
								Route : '.$configRoute[$schMed['NewCropPrescription']['route']].'</br>';
								/*<b>Given : '.$schMed['NewCropPrescription']['date_of_prescription'].'</b></br>
								Performed By :'.$schMed['NewCropPrescription'][''].' </br>';*/?>
				<?php $medTime = $this->DateFormat->formatDate2LocalForReport($newTimingArray[$cnt],Configure::read('date_format'),true);
						$medTime = preg_replace(array('/[^\s\w]/','/\s/'),'_',$medTime);
						?>				
														<!-- id used to show administration completed ststus  -->
				<td class="tooltip" title='<?php echo $toolTip; ?>' id='<?php echo $medTime."td"; ?>'
					style="width: 175px; color: #DDDDDD; background-color: #106A93; text-align: center; vertical-align: sub;">
					<?php echo $schMed['NewCropPrescription']['dose']." ".$configStrength[$schMed['NewCropPrescription']['strength']]; ?><br>&nbsp;
					<?php if($schMed['NewCropPrescription']['firstdose'] != $schMed['NewCropPrescription']['medication_administering_time']){?>
					<?php $lastGivenTime = substr($this->DateFormat->formatDate2Local($schMed['NewCropPrescription']['medication_administering_time'],Configure::read('date_format'),true),0 ,16);?>
					<?php echo "Last given: ".$lastGivenTime;?>
					<?php }else{?>
					<?php echo "Not given"?>
					<?php } ?>
				</td>
				<?php }else{?>
				<td style="width: 175px;background:#DBEAF9"></td>
				<?php }?>
				<?php }?>
			</tr>
			<!-- tr to show administered meds -->
			<?php if(!empty($schMed['MedicationAdministeringRecord'])){?>
			<tr>
				<td colspan="" style="width: 450px; color: #DDDDDD;background:#394145;padding-right: 70px;"  class="" ><b><?php echo $schMed['NewCropPrescription']['drug_name']; ?></b>
				</td><?php $tdCounter = 0;?>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){?>
				<?php if(in_array( $newTimingArray[$cnt],$prescTimeSchedule[$foreachCntr])){?>
				<td class="" style="width: 175px; color: #394145; background-color: #DDDDDD; text-align: center; vertical-align: sub;">
					<?php echo $schMed['MedicationAdministeringRecord'][$tdCounter]['dose']." ".$configStrength[$schMed['NewCropPrescription']['strength']]." Auth(verified)"; ?>
				</td>
				<?php $tdCounter++; }else{?>
				<td style="width: 175px;background:#394145"></td>
				<?php }?>
				<?php }//endfor; ?>
			</tr>
			<?php }//end of administered meds ?>
			<?php $foreachCntr++;?>
			<?php }//endforeach; ?>
			
			<?php endif;  ?>

			<?php if(!empty($prnMedication)){ ?>

			<tr style="background-color: #709E27">
				<td colspan="<?php echo $excelTdCount+1; ?>"><b><?php echo __('PRN');?></b>
				</td>
			</tr><?php $foreachCntr=0;?>
			<?php foreach($prnMedication as $prnMed){//#26D3D6?>
			<tr style="background-color: #A2C46B;"><!-- id used at right click function -->
				<td colspan="" style="width: 450px; color: #4F4F4F;" id=<?php echo $prnMed['NewCropPrescription']['id'];?> class="context-menu-one box menu-1" >
				<b><?php echo $prnMed['NewCropPrescription']['drug_name']; ?>
				</b><br>&nbsp;<?php echo $prnMed['PatientOrder']['sentence']; ?>
				</td>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){?>
				<?php if(in_array($newTimingArray[$cnt-1], $medicationTiming[1][$prnMed['NewCropPrescription']['drug_name']])){?>
				<?php $toolTip = 'Medication : '.$prnMed['NewCropPrescription']['drug_name'].'</br>
									Dose : '.$prnMed['NewCropPrescription']['dose'].' '.$configStrength[$prnMed['NewCropPrescription']['strength']].' </br>
									Route : '.$configRoute[$prnMed['NewCropPrescription']['route']].'</br>';
									/*<b>Given : '.$schMed['NewCropPrescription']['date_of_prescription'].'</b></br>
									Performed By :'.$schMed['NewCropPrescription'][''].' </br>';*/?>
									<!-- id used to show administration completed ststus  -->
				<td class="tooltip" title='<?php echo $toolTip; ?>' id='<?php echo $prnMed['NewCropPrescription']['id']."td"; ?>'
					style="width: 175px; color: #DDDDDD; background-color: #709E27; text-align: center; vertical-align: sub;">
					<?php echo $prnMed['NewCropPrescription']['dose']." ".$configStrength[$prnMed['NewCropPrescription']['strength']]; ?><br>&nbsp;
					<?php if($prnMed['NewCropPrescription']['firstdose'] != $prnMed['NewCropPrescription']['medication_administering_time']){?>
					<?php $lastGivenTime = substr($this->DateFormat->formatDate2Local($prnMed['NewCropPrescription']['medication_administering_time'],Configure::read('date_format'),true),0 ,16);?>
					<?php echo "Last given: ".$lastGivenTime;?>
					<?php }else{?>
					<?php echo "Not given"?>
					<?php } ?>
				</td>
				<?php }else{?>
				<td style="width: 175px;"></td>
				<?php }?>
				<?php } ?>
			</tr>
			<!-- tr to show administered meds -->
			<?php if(!empty($prnMed['MedicationAdministeringRecord'])){ ?>
			<tr>
				<td colspan="" style="width: 450px; color: #DDDDDD;background:#394145;"  class="" ><b><?php echo $prnMed['NewCropPrescription']['drug_name']; ?></b>
				</td> <?php $tdCounter = 0;?>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){ ?>
				<?php if(in_array( $newTimingArray[$cnt],$prescTimePrn[$foreachCntr])){?>
				<td class="" style="width: 175px; color: #394145; background-color: #DDDDDD; text-align: center; vertical-align: sub;">
					<?php echo $prnMed['MedicationAdministeringRecord'][$tdCounter]['dose']." ".$configStrength[$prnMed['NewCropPrescription']['strength']]." Auth(verified)"; ?>
				</td>
				<?php $tdCounter++;}else{?>
				<td style="width: 175px;background:#394145"></td>
				<?php }?>
				<?php }//endfor; ?>
			</tr>
			<?php }//end of administered meds ?>
			<?php $foreachCntr++;?>
			<?php } ?>
			<?php } ?>

			<?php if(!empty($contineousInfusion)){ ?>

			<tr style="background-color: #106A93">
				<td colspan="<?php echo $excelTdCount+2; ?>"><b><?php echo __('Continuous Infusion');?></b>
				</td>
			</tr><?php $foreachCntr=0;?>
			<?php foreach($contineousInfusion as $contInf){//#26D3D6?>
			<tr style="background-color: #DBEAF9;"><!-- id used at right click function -->
				<td colspan="" style="width: 450px; color: #4F4F4F;" id=<?php echo $contInf['NewCropPrescription']['id'];?> class="context-menu-one box menu-1 doubleClick">
				<b><?php echo $contInf['NewCropPrescription']['drug_name']; ?>
				</b><br>&nbsp;<?php echo $contInf['PatientOrder']['sentence']; ?>
				</td>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){?>
				<?php if(in_array($newTimingArray[$cnt-1], $medicationTiming[1][$contInf['NewCropPrescription']['drug_name']])){?>
				<?php $toolTip = 'Medication : '.$contInf['NewCropPrescription']['drug_name'].'</br>
									Dose : '.$contInf['NewCropPrescription']['dose'].' '.$configStrength[$contInf['NewCropPrescription']['strength']].' </br>
									Route : '.$configRoute[$contInf['NewCropPrescription']['route']].'</br>';
									/*<b>Given : '.$schMed['NewCropPrescription']['date_of_prescription'].'</b></br>
									Performed By :'.$schMed['NewCropPrescription'][''].' </br>';*/?>
									<!-- id used to show administration completed ststus  -->
				<td class="tooltip" title='<?php echo $toolTip; ?>' id='<?php echo $contInf['NewCropPrescription']['id']."td"; ?>'
					style="width: 175px; color: #DDDDDD; background-color: #106A93; text-align: center; vertical-align: sub;">
					<?php echo $contInf['NewCropPrescription']['dose']." ".$configStrength[$contInf['NewCropPrescription']['strength']]; ?><br>&nbsp;
					<?php if($contInf['NewCropPrescription']['firstdose'] != $contInf['NewCropPrescription']['medication_administering_time']){?>
					<?php $lastGivenTime = substr($this->DateFormat->formatDate2Local($contInf['NewCropPrescription']['medication_administering_time'],Configure::read('date_format'),true),0 ,16);?>
					<?php echo "Last given: ".$lastGivenTime;?>
					<?php }else{?>
					<?php echo "Not given"?>
					<?php } ?>
				</td>
				<?php }else{?>
				<td style="width: 175px;"></td>
				<?php }?>
				<?php } ?>
			</tr>
			<!-- tr to show administered meds -->
			<?php if(!empty($contInf['MedicationAdministeringRecord'])){?>
			<tr>
				<td style="width: 450px; color: #DDDDDD;background:#394145;"  class="" ><b><?php echo $contInf['NewCropPrescription']['drug_name']; ?></b>
				</td><?php $tdCounter = 0;?>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){?>
				<?php if(in_array( $newTimingArray[$cnt],$prescTimeContinuous[$foreachCntr])){?>
				<td class="" style="width: 175px; color: #394145; background-color: #DDDDDD; text-align: center; vertical-align: sub;">
					<?php echo $contInf['MedicationAdministeringRecord'][$tdCounter]['dose']." ".$configStrength[$contInf['NewCropPrescription']['strength']]." Auth(verified)"; ?>
				</td>
				<?php $tdCounter++; }else{?>
				<td style="width: 175px;background:#394145"></td>
				<?php }?>
				<?php }//endfor; ?>
			</tr>
			<?php }//end of administered meds ?>
			<?php $foreachCntr++;?>
			<?php } ?>

			<?php }  ?>

			<?php if(!empty($futureMedication)){ ?>

			<tr style="background-color: #454040">
				<td colspan="<?php echo $excelTdCount+2; ?>"><b><?php echo __('Future');?></b>
				</td>
			</tr>
			<?php foreach($futureMedication as $futMed){//#26D3D6?>
			<tr style="background-color: #6A6A6A;">
				<td colspan="" style="width: 450px; color: #DDDDDD;"><b><?php echo $futMed['NewCropPrescription']['drug_name']; ?>
				</b><br>&nbsp;<?php echo $futMed['PatientOrder']['sentence']; ?>
				</td>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){?>
				<?php $toolTip = 'Medication : '.$futMed['NewCropPrescription']['drug_name'].'</br>
									Dose : '.$futMed['NewCropPrescription']['dose'].' '.$configStrength[$futMed['NewCropPrescription']['strength']].' </br>
									Route : '.$configRoute[$futMed['NewCropPrescription']['route']].'</br>';
									/*<b>Given : '.$schMed['NewCropPrescription']['date_of_prescription'].'</b></br>
									Performed By :'.$schMed['NewCropPrescription'][''].' </br>';*/?>
				<td class="tooltip" title='<?php echo $toolTip; ?>' style="width: 175px;"></td>
				<?php } ?>
			</tr>
			<?php } ?>

			<?php } ?>

			<?php if(!empty($disContScheduledMedication)){ ?>

			<tr style="background-color: #454040">
				<td colspan="<?php echo $excelTdCount+2; ?>"><b><?php echo __('Dis. Cont. Scheduled');?></b>
				</td>
			</tr>
			<?php foreach($disContScheduledMedication as $disContSchMed){//#26D3D6?>
			<tr style="background-color: #6A6A6A;">
				<td colspan="" style="width: 450px; color: #DDDDDD;"><b><?php echo $disContSchMed['NewCropPrescription']['drug_name']; ?>
				</b><br>&nbsp;<?php echo $disContSchMed['PatientOrder']['sentence']; ?>
				</td>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){?>
				<?php $toolTip = 'Medication : '.$disContSchMed['NewCropPrescription']['drug_name'].'</br>
									Dose : '.$disContSchMed['NewCropPrescription']['dose'].' '.$configStrength[$disContSchMed['NewCropPrescription']['strength']].' </br>
									Route : '.$configRoute[$disContSchMed['NewCropPrescription']['route']].'</br>';
									/*<b>Given : '.$schMed['NewCropPrescription']['date_of_prescription'].'</b></br>
									Performed By :'.$schMed['NewCropPrescription'][''].' </br>';*/?>
				<td class="tooltip" title='<?php echo $toolTip; ?>' style="width: 175px;"></td>
				<?php } ?>
			</tr>
			<?php } ?>

			<?php } ?>

			<?php if(!empty($disContPrnMedication)){ ?>

			<tr style="background-color: #454040">
				<td colspan="<?php echo $excelTdCount+2; ?>"><b><?php echo __('Dis. Cont. Prn');?></b>
				</td>
			</tr>
			<?php foreach($disContPrnMedication as $disContPrn){//#26D3D6?>
			<tr style="background-color: #6A6A6A;">
				<td colspan=""style="width: 450px; color: #DDDDDD;"><b><?php echo $disContPrn['NewCropPrescription']['drug_name']; ?>
				</b><br>&nbsp;<?php echo $disContPrn['PatientOrder']['sentence']; ?>
				</td>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){?>
				<?php $toolTip = 'Medication : '.$disContPrn['NewCropPrescription']['drug_name'].'</br>
									Dose : '.$disContPrn['NewCropPrescription']['dose'].' '.$configStrength[$disContPrn['NewCropPrescription']['strength']].' </br>
									Route : '.$configRoute[$disContPrn['NewCropPrescription']['route']].'</br>';
									/*<b>Given : '.$schMed['NewCropPrescription']['date_of_prescription'].'</b></br>
									Performed By :'.$schMed['NewCropPrescription'][''].' </br>';*/?>
				<td class="tooltip" title='<?php echo $toolTip; ?>' style="width: 175px;"></td>
				<?php } ?>
			</tr>
			<?php } ?>

			<?php }  ?>

			<?php if(!empty($disContineousInfusion)){ ?>

			  <tr style="background-color: #454040">
				<td colspan="<?php echo $excelTdCount+2; ?>"><b><?php echo __('Dis. Cont. Infusion');?></b>
				</td>
			</tr>
			<?php foreach($disContineousInfusion as $disConInf){//#26D3D6?>
			<tr style="background-color: #6A6A6A;">
				<td colspan="" style="width: 450px; color: #DDDDDD;"><b><?php echo $disConInf['NewCropPrescription']['drug_name']; ?>
				</b><br>&nbsp;<?php echo $disConInf['PatientOrder']['sentence']; ?>
				</td>
				<?php for($cnt=0;$cnt<$excelTdCount;$cnt++){?>
				<?php $toolTip = 'Medication : '.$disConInf['NewCropPrescription']['drug_name'].'</br>
									Dose : '.$disConInf['NewCropPrescription']['dose'].' '.$configStrength[$disConInf['NewCropPrescription']['strength']].' </br>
									Route : '.$configRoute[$disConInf['NewCropPrescription']['route']].'</br>';
									/*<b>Given : '.$schMed['NewCropPrescription']['date_of_prescription'].'</b></br>
									Performed By :'.$schMed['NewCropPrescription'][''].' </br>';*/?>
				<td class="tooltip" title='<?php echo $toolTip; ?>' style="width: 175px;"></td>
				<?php } ?>
			</tr>
			<?php } ?>

			<?php }  ?>
		</table>
	</div>
<!-- </div> -->
<script>
	$(document).ready(function(){
		
		if('<?php echo $menuVar ?>'){
				$('#AdminisMeds').fadeIn('slow');
			}

		$('.tooltip').tooltipster({
	 		interactive:true,
	 		position:"right", 
	 	});
		
	});
</script>
