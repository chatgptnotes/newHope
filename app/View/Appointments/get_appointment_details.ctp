
<?php 
//echo $this->Html->css(array('tooltipster.css'));
//echo $this->Html->script(array('jquery.tooltipster.min.js'));
?>
<style>
.daysheading {
	font-weight: bold;
	height: 25px;
	text-align: center;
	background: #a1b6bd;
}

.schedule_appointment {
	color: #FFFFFF !important;
	font-size: 13px;
}

.next img {
	float: inherit;
}
</style>
<table width="84%">
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<!-- <td colspan="2" style="padding-bottom:20px"><?php //if(!empty($timePeriodPrev)) echo $this->Html->link("<<<",array('controller'=>'appointments','action'=>'getAppointmentDetails',$doctorId,$timePeriodPrev), array('escape' => false)).'&nbsp;&nbsp;&nbsp;';?><?php // echo $timePeriodNext; ?>&nbsp;&nbsp;&nbsp;<?php //echo $this->Html->link(">>>",array('controller'=>'appointments','action'=>'getAppointmentDetails',$doctorId,$lastWeekDate), array('escape' => false)); ?></td>-->
		<td class="next" colspan="3" style="padding-bottom: 20px"
			align="right"><?php if(!empty($timePeriodPrev)) echo $this->Html->image('/img/icons/prev.png',array('style'=>'cursor:hand;cursor:pointer;' ,'onclick'=>"getDoctorsAppointment('$timePeriodPrev')"))?>&nbsp;&nbsp;&nbsp;<?php echo $timePeriodNext; ?>&nbsp;&nbsp;&nbsp;<?php echo $this->Html->image('/img/icons/next.png',array('style'=>'cursor:hand;cursor:pointer;' ,'onclick'=>"getDoctorsAppointment('$lastWeekDate')"))?>
		</td>

	</tr>

	<tr>
		<td class="daysheading" width="8%" align="left"><?php echo date("d D",strtotime($currentDate)); ?>
		</td>
		<td class="daysheading" width="8%" align="left"><?php echo date("d D",strtotime("+1 day",strtotime($currentDate)));?>
		</td>
		<td class="daysheading" width="8%" align="left"><?php echo date("d D",strtotime("+2 day",strtotime($currentDate)));?>
		</td>
		<td class="daysheading" width="8%" align="left"><?php echo date("d D",strtotime("+3 day",strtotime($currentDate)));?>
		</td>
		<td class="daysheading" width="8%" align="left"><?php echo date("d D",strtotime("+4 day",strtotime($currentDate)));?>
		</td>
		<td class="daysheading" width="8%" align="left"><?php echo date("d D",strtotime("+5 day",strtotime($currentDate)));?>
		</td>
		<td class="daysheading" width="8%" align="left"><?php echo date("d D",strtotime("+6 day",strtotime($currentDate)));?>
		</td>
	</tr>
	<?php 
	$dateNotAvailable=array();
	$filledArray =array();
	if($doctorChambers){
  for($i=1;$i<=$minutesDifference;$i++){
  	if($i == 1)
  		$timeInterval1 = 0;
  	else
  		$timeInterval1 = $timeInterval;
  	$startHours = date("h:i A",strtotime("+".($timeInterval1)." minutes",strtotime($startHours)));//echo $startHours.'<br>';
  	?>
	<?php 
	$string ='<tr>';

	?>
	<?php 
	$slotBlocked = 0;
  	for($j=1;$j<8;$j++){ 	?>
	<?php 
	$currentDateNew = date("Y-m-d",strtotime("+".($j-1)." day",strtotime($currentDate)));
	if($appointments){
		foreach ($appointments as $key=>$appointment){
			
			$convertedStartTime = date("H:i", strtotime($startHours));
			$convertedEndTime = date("H:i",strtotime("+".($timeInterval1)." minutes",strtotime($startHours)));

			$appointmentStartDateWithTime = $appointment['Appointment']['date']." ".$appointment['Appointment']['start_time'];
			$startTimeStringInLocal = date("H:i",strtotime($appointmentStartDateWithTime));

			$appointmentEndDateWithTime = $appointment['Appointment']['date']." ".$appointment['Appointment']['end_time'];
			$endTimeStringInLocal = date("H:i",strtotime($appointmentEndDateWithTime));
			if((strtotime($convertedStartTime) == strtotime($startTimeStringInLocal)) && (strtotime($currentDateNew) == strtotime($appointment['Appointment']['date'])) && ($appointment['Appointment']['person_id'] == $patientId) && checkTimeSlot($currentDateNew,$convertedStartTime)){
				$slotBlocked = 1;
				if(strtotime($convertedEndTime) < strtotime($endTimeStringInLocal)){
					$appointments[$key]['Appointment']['start_time'] = date("H:i",strtotime("+".($timeInterval1)." minutes",strtotime($appointments[$key]['Appointment']['start_time'])));
				}
				if(strtolower($appointment['Appointment']['status']) != 'pending'){
					$seenStatus = "Confirmed";
					$filledArray[$currentDateNew] = $convertedStartTime;
				}else{
					$seenStatus = "Appointment Requested";
					$filledArray[$currentDateNew] = $convertedStartTime;
				}
				//$isDone = true;
				
				$string .= '<td class="workhoursheight1" align="left">';
				$string .= $this->Html->link($seenStatus,"#",array('class'=>'tooltip','title'=> $seenStatus,'escape' => false,'error'=>false));
				$string .= '</td>';
				$stringYellow .= '<td class="workhoursheight1" align="left">';
				$stringYellow .= $this->Html->link($seenStatus,"#",array('class'=>'tooltip','title'=> $seenStatus,'escape' => false,'error'=>false));
				$stringYellow .= '</td>';
				$searchStrRed .= '<td id="'.$currentDateNew.$convertedStartTime.'"  class="workhoursheight" align="left">';
				$searchStrRed .= '&nbsp;';
				$searchStrRed .= '</td>';
				$string = str_replace($stringYellow, '', $string);
				$string = str_replace($searchStr, '', $string);
				$searchStr = '';
			}else{
				if((strtotime($convertedStartTime) == strtotime($startTimeStringInLocal)) && ($currentDateNew == $appointment['Appointment']['date']) && checkTimeSlot($currentDateNew,$convertedStartTime)){
					$slotBlocked = 1;
					if(!checkSlotFilled($filledArray,$currentDateNew,$convertedStartTime)){
						$searchStr .= '<td id="'.$currentDateNew.$convertedStartTime.'"  class="workhoursheight" align="left">';
						$searchStr .= '&nbsp;';
						$searchStr .= '</td>';
						$string = str_replace($searchStr, '', $string);
						$string .= '<td id="'.$currentDateNew.$convertedStartTime.'"  class="workhoursheight" align="left">';
						$string .= '&nbsp;';
						$string .= '</td>';
						$searchStr = '';
					}
					$filledArray[$currentDateNew] = $convertedStartTime;
					//$isDone = false;
				}
			}
		}
		if($slotBlocked == 0){
			foreach($doctorChambers as $doctorChamber){
				
				if((strtotime($doctorChamber['0']['starttime']) == strtotime($currentDateNew)) && ($doctorChamber['DoctorChamber']['holiday'] == 0)){

					if((strtotime($startHours) >= strtotime($doctorChamber['DoctorChamber']['start_time'])) && (strtotime($startHours) < strtotime($doctorChamber['DoctorChamber']['end_time']))){//&& (strtotime($doctorChamber['0']['starttime']) == strtotime(date("Y-m-d")))
						if(((strtotime($startHours) < strtotime(date("h:i A"))) &&  ($currentDateNew == date("Y-m-d")))){
							$string .= '<td align="left"  class="workhoursheight">&nbsp;</td>' ;
						}else{
							$convertedEndTime = date("H:i",strtotime("+".($timeInterval1)." minutes",strtotime($startHours)));
							if(!addBlockHours($blockHours,$currentDateNew,$startHours,$convertedEndTime)){
								$string .= '<td class="workhoursheight3" align="left">';
								$string .= $this->Html->link($startHours,"#",array('class'=>'schedule_appointment','escape' => false,'onclick'=>"showfancyBox('$currentDate','$startHours','$currentDateNew')"));
								$string .= '</td>';
							}else{
								$string .= '<td align="left" class="workhoursheight">&nbsp;</td>' ;
							}

						}
						$slotBlocked = 0;
					}else{
						$string .= '<td align="left">&nbsp;</td>' ;
					}
				}else if(strtotime($doctorChamber['0']['starttime']) == strtotime($currentDateNew) && ($doctorChamber['DoctorChamber']['holiday'] == 1)){
					if((strtotime($startHours) >= strtotime($doctorChamber['DoctorChamber']['start_time'])) && (strtotime($startHours) < strtotime($doctorChamber['DoctorChamber']['end_time']))){
						$string .= '<td class="workhoursheight" align="left">';
						$string .= '&nbsp;';
						$string .= '</td>';
						$slotBlocked = 0;
					}else{
						$string .= '<td align="left">&nbsp;</td>' ;
					}
				}
			}
		}
	}else{
		foreach($doctorChambers as $doctorChamber){
			if(strtotime($doctorChamber['0']['starttime']) == strtotime($currentDateNew) && ($doctorChamber['DoctorChamber']['holiday'] == 0)){
				if((strtotime($startHours) >= strtotime($doctorChamber['DoctorChamber']['start_time'])) && (strtotime($startHours) < strtotime($doctorChamber['DoctorChamber']['end_time']))){
					if(((strtotime($startHours) < strtotime(date("h:i A"))) &&  ($currentDateNew == date("Y-m-d")))){
						$string .= '<td align="left" class="workhoursheight">&nbsp;</td>' ;
					}else{
						$convertedEndTime = date("H:i",strtotime("+".($timeInterval1)." minutes",strtotime($startHours)));
						if(!addBlockHours($blockHours,$currentDateNew,$startHours,$convertedEndTime)){
							$string .= '<td class="workhoursheight3" align="left">';
							$string .= $this->Html->link($startHours,"#",array('class'=>'schedule_appointment','escape' => false,'onclick'=>"showfancyBox('$currentDate','$startHours','$currentDateNew')"));
							$string .= '</td>';
						}else{
							$string .= '<td align="left" class="workhoursheight">&nbsp;</td>' ;
						}
					}
					$slotBlocked = 0;
				}else{
					$string .= '<td align="left">&nbsp;</td>' ;
				}
			}else if(strtotime($doctorChamber['0']['starttime']) == strtotime($currentDateNew) && ($doctorChamber['DoctorChamber']['holiday'] == 1)){
				if((strtotime($startHours) >= strtotime($doctorChamber['DoctorChamber']['start_time'])) && (strtotime($startHours) < strtotime($doctorChamber['DoctorChamber']['end_time']))){
					$string .= '<td class="workhoursheight" align="left">&nbsp;';

					$string .= '</td>';
						
					$slotBlocked = 0;
				}else{
					$string .= '<td align="left">&nbsp;</td>' ;
				}
			}
		}
	}
	?>
	<?php 
	
	$slotBlocked = 0;
	$timeInterval1 = 0;
}?>
	<?php $string .= '</tr>';
	if($string != '<tr><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr>'){
		echo $string;
	}
	?>
	<?php 
	}
?>
</table>
<?php }else{?>

<?php } 
?>

<table width="100%">
	<tr>
		<td><?php 
		echo $this->Form->hidden('doctorId', array('value'=>$doctorId));
		//echo $this->Form->hidden('startDate', array('value'=>$id));
		?>
		</td>
	</tr>
</table>

<?php 
function addBlockHours($blockHours = array(),$date,$startTime,$endTime){
	if($blockHours){
		foreach($blockHours as $key=>$value){
			if($date == $key){
				foreach($value as $newKey=>$newValue){
					$startNowTime = strtotime($startTime);
					$endNowTime = strtotime($startTime) + 900;
					$blockStart = strtotime($newValue['block_start_time']);
					$blockEnd = strtotime($newValue['block_end_time']) - 900;

					if($endNowTime > $blockStart && $endNowTime <= $blockEnd) {
						return true;
					}
					if($blockEnd <= $endNowTime && $startNowTime <= $blockEnd) {
						return true;
					}
					if($startNowTime >= $blockStart && $startNowTime <= $blockEnd) {
						return true;
					}
				}
			}
		}
	}else{
		return false;
	}
}

function checkSlotFilled($filledArray,$date,$time,$isDone){
$isDone = true;
	foreach ($filledArray as $key=>$value){
		if(($key == $date) && ($value == $time) && $isDone){
			return true;
		}else{
			return false;
		}
	}
}

function checkTimeSlot($currentSlotDate,$currentSlotTime){
	$calenderStartTime = Configure::read('calendar_start_time').":00";
	$calenderEndTime = Configure::read('calendar_end_time').":00";
	if( (strtotime($currentSlotDate.' '.$currentSlotTime) >= strtotime($currentSlotDate.' '.$calenderStartTime)) && (strtotime($currentSlotDate.' '.$currentSlotTime) <= strtotime($currentSlotDate.' '.$calenderEndTime))){
		return true;
	}else{
		return false;
	}
}
?>