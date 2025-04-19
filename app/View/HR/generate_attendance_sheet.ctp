<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Monthly Attendence Sheet_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>

<STYLE type="text/css">
.tableTd {
	border-width: 0.5pt;
	border: solid;
}

.tableTdContent {
	border-width: 0.5pt;
	border: solid;
}

#titles {
	font-weight: bolder;
}
</STYLE>
<table border='1' class='table_format' cellpadding='0' cellspacing='0'
	width='100%' style='text-align: left; padding-top: 50px;'>
	<tr>
		<td colspan="<?php echo date('t',strtotime($firstDate)); ?>" align="center" style="border-right: medium none;"><h2>
				<?php echo __("Monthly Attendence Sheet")." - ".date('F Y',strtotime($firstDate)); ?>
			</h2></td>
		<td colspan="6" align="center" style="border-left: medium none;"><span>Printed On: <?php echo $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?>
		</span></td>
	</tr>
	<tr>
		<td width='20%'>Name</td>
		<?php for($i = 1; $i <= date('t',strtotime($firstDate)) ; $i++){?>
		<td align='center' valign='middle' width='4%'><strong><?php echo $i.'<br/>'.substr(date('D',strtotime(date("Y-m-".$i,strtotime($firstDate)))),0,2);?>
		</strong></td>
		<?php } ?>
		<td align='center' valign='middle' width='4%'><strong>P</strong></td>
		<td align='center' valign='middle' width='4%'><strong>A</strong></td>
		<td align='center' valign='middle' width='4%'><strong>WOP</strong></td>
		<td align='center' valign='middle' width='4%'><strong>WO</strong></td>
	</tr>
        <?php foreach($users as $key => $val){ $present = $absent = 0; ?>
        <tr>
            <td><?php echo $userName = $val[0]['full_name']; $userId = $val['User']['id']; ?></td>
            <?php for($i = 1; $i <= date('t',strtotime($firstDate)) ; $i++){ 
                $date = str_pad($i,2,0,STR_PAD_LEFT);
                if(!empty($rosterData[$userId][date("Y-m-$date",strtotime($firstDate))]['intime'])) { 
                    $displayText = "P";
                    $present++;
                }else{
                    $displayText = "A";
                    $absent++;
                }
            ?>
            
                <td align="center"><?php echo $displayText; ?></td>
            <?php } //end of for loop ?>
                <td><?php echo $present; ?></td>
                <td><?php echo $absent; ?></td>
        </tr>
        <?php } //end of users foreach ?>
        
        
	<?php foreach($attendenceData as $attendence){?>
	<?php if(empty($attendence['DutyRoster']))continue;?>
	<?php $attendenceLogs[$attendence['User']['id']] = array('Absent'=>0,'Present'=>0,'Late'=>0,'WO'=>0,'WOP'=>0); ?>
	<tr>
		<td><?php echo __($attendence['User']['full_name'], true); ?></td>
		<?php for($i = 1; $i <= date('t',strtotime($firstDate)) ; $i++){?>
		<?php if($i < date('j',strtotime($attendence['DutyRoster']['0']['date']))){?>
		<?php $attendenceLogs[$attendence['User']['id']]['Absent']++;?>
		<td style="text-align: center;">A</td>
		<?php }?>
		<?php }?>
		<?php 
		foreach($attendence['DutyRoster'] as $key => $dutyRoster) {
			$statusArray = calculateStatus( $dutyRoster , $shiftLength , $attendence['User']['id'] , $attendenceLogs , $shiftRange);
			$attendenceLogs[$attendence['User']['id']] = $statusArray[1]
	  ?>
		<td align="center"><?php echo $statusArray[0];?>
		</td>
		<?php } ?>
		<td align="center"><?php echo $attendenceLogs[$attendence['User']['id']]['Present'];?>
		
		<td align="center"><?php echo $attendenceLogs[$attendence['User']['id']]['Absent'];?>
		
		<td align="center"><?php echo $attendenceLogs[$attendence['User']['id']]['WOP'];?>
		
		<td align="center"><?php echo $attendenceLogs[$attendence['User']['id']]['WO'];?>
		</td>
	</tr>
	<?php }?>

</table>

<?php 
function calculateStatus($data = array() , $shiftLength , $userId , $logs , $shiftRange){

	$inOut = explode( '::', $data['inouttime'] );
	$in = reset( $inOut );
	if(count($inOut) % 2 == 0)
		$out = end( $inOut );
	else
		$out = $inOut[count($inOut)-2];
	if($out == ''){
		$logs[$userId]['Absent'] = ( int ) $logs[$userId]['Absent'] + 1;
		return array('A',$logs[$userId]);
	}
	$inTime = new DateTime( $data['date'] .' '. $in );
	$outTime = new DateTime( $data['date'] .' '. $out );
	$interval = $inTime->diff( $outTime );
	$loginHours = ( $interval->i != 0 ) ? ( int ) $interval->h + 0.5 : $interval->h;
	$shiftHours = $shiftLength[strtolower($data['shift'])];
	$presentPercent = ceil( ( $loginHours / $shiftHours ) * 100 ) ;

	foreach($shiftRange as $shiftName=>$shiftStartEnd){
		$beforeStart = date('H:i',strtotime($shiftStartEnd['start']) - 3600);//substracting 1 hour
		$afterEnd = date('H:i',strtotime($shiftStartEnd['end']));// adding 1 hour  + 3600
		if( $beforeStart <= $in && $afterEnd >= $out && strtolower($data['shift']) != strtolower($shiftName) ){
			$logs[$userId]['Absent'] = ( int ) $logs[$userId]['Absent'] + 1;
			return array('A',$logs[$userId]);
		}
	}
	
	if( $data['day_off'] == 'OFF'){
		if($presentPercent > 75){
			$logs[$userId]['WOP'] = floatval($logs[$userId]['WOP']) + 1;
			return array('WOP',$logs[$userId]);
		}else{
			$logs[$userId]['WO'] = ( int ) $logs[$userId]['WO'] + 1;
			return array('WO',$logs[$userId]);
		}
	}
	if( $data['day_off'] != '0' or !$data['inouttime'] ){
		$logs[$userId]['Absent'] = ( int ) $logs[$userId]['Absent'] + 1;
		return array('A',$logs[$userId]);
	}
	if($presentPercent < 25){
		$logs[$userId]['Absent'] = ( int ) $logs[$userId]['Absent'] + 1;
		return array('A',$logs[$userId]);
	}else if($presentPercent < 75){
		$logs[$userId]['Present'] = floatval($logs[$userId]['Present']) + 0.5;
		return array('<sup>1</sup>/<sub>2</sub>P',$logs[$userId]);
	}else{
		$logs[$userId]['Present'] = floatval($logs[$userId]['Present']) + 1;
		return array('P',$logs[$userId]);
	}
}
?>