<table width="100%" cellpadding="0" cellspacing="1" border="0" id= 'rosterTable'
	class="tabularForm" style="max-height:200px">
	<tr>
		<th width="13%" class="note1" style="text-align: center; padding: 0px"><div>&nbsp;</div><div>Date</div>
			<div class="firstColumn" style="height: 25px;">Name</div></th>
		<?php $allshifts = $shiftNames; $shiftNames = $shifts; ?> 
                <?php //debug($this->DateFormat->get_date_range(date("Y-m-".Configure::read('payrollFromDate'),'-1 month'),date("Y-m-".Configure::read('payrollToDate'))));?>
		<?php //for($i = 1; $i <= date('t',strtotime($firstDate)) ; $i++){
                    foreach($dateList as $key => $val) {
                        list($year,$month,$day) = explode("-", $val);
                ?>
		<?php $leave[$i] = 0;?>
		<th width="100" align="center" valign="top"
			style="text-align: center;"><?php echo $day." ".date('D',strtotime(date('Y-m-'.$day,strtotime($val))));?>
		</th>
		<?php }?>
		<th width="100" align="center" valign="top"
			style="text-align: center;">Total Work Hours</th>
	</tr>
	<?php 
	$userArray = array();
	//$isApproved = false;
	$leaveTypes = configure::read('leaveTypes'); ?>
	<tbody id="dataTable">
	<?php foreach($users as $key => $value){ $monthlyHours = 0; ?> 
		<tr oncontextmenu="return false">
			<td align="left" valign="top" class="firstColumn" style="text-align:left"><?php echo $value[0]['full_name']; $allUsers[] = $userId = $value['User']['id']; ?></td>
			<?php //for($i = 1; $i <= date('t',strtotime($firstDate)) ; $i++){ 
                            foreach($dateList as $key => $val) { 
                            list($year,$month,$day) = explode("-", $val);
                        ?> 	
                                <?php $date = str_pad($day,2,0,STR_PAD_LEFT);?>
				<?php  
                                    $holidayText = $background = '';
                                    if(isset($holidays[$date]) && !empty($holidays[$date]) && empty($rosterData[$userId][$val/*date("Y-m-$date",strtotime($val))*/]['shift'])){
                                        $holidayText = "\nHoliday : ".ucfirst($holidays[$date]);
                                        $background = "background: red;" ;
                                    } 
				  //$background = ($shifts['duty_on_cash']) ? "background: red;" : ""; ?>
				 <?php  $invalid = checkDeviation($shifts , $shiftRange);?>
				<td style="text-align: center; cursor: pointer; <?php echo $background;?> "
					date="<?php echo $date; ?>"
					id="<?php echo $rosterId = $rosterData[$userId][$val/*date("Y-m-$date",strtotime($val))*/]['id']?>"
					onmousedown="HideMenu('contextMenu');"
					onclick="HideMenu('contextMenu');"
					onmouseup="HideMenu('contextMenu');" 
                                        
					<?php if(empty($isApproved)){?>oncontextmenu="ShowMenu('contextMenu',event,'<?php echo $rosterId; ?>','<?php echo $value['User']['id']; ?>','<?php echo $val;//$date; ?>','<?php echo $value['User']['role_id']; ?>');"<?php }?> 
					<?php if($roster['DutyPlan']['duty_plan_approved'])$isApproved = true;?> 
					<?php if(!empty($rosterData[$userId][$val/*date("Y-m-$date",strtotime($val))*/]['shift'])) {   
							$appliedShift = $shifts[$rosterData[$userId][$val/*date("Y-m-$date",strtotime($val))*/]['shift']];	//shift from duty_roster table
						}else{
                                                    $appliedShift = $shifts[$value['PlacementHistory']['shifts']];	//by defualt shift from users table
						}
					?> 
					title="<?php echo $value[0]['full_name']."\n(".date("$date/m/Y",strtotime($val)).")\nShift : ".$appliedShift." (".$shiftStart[$appliedShift]." - ".$shiftEnd[$appliedShift].")".$holidayText; ?><?php echo ($invalid[0]) ? $invalid[0] : $shiftLeaveTitle; ?>" class="detailItem  <?php echo $invalid[1];?>"  >
					<?php if($rosterData[$userId][$val/*date("Y-m-$date",strtotime($val))*/]['day_off'] > '0'){
							echo $rosterData[$userId][$val/*date("Y-m-$date",strtotime($val))*/]['day_off'];
						}else if(!empty($holidayText)){
                                                    echo "OH";
                                                }else{
							echo $shiftAlias[trim($appliedShift)];//substr($appliedShift,0,1);
							$monthlyHours = $monthlyHours + $shiftTimes[$appliedShift]; //calculate total working hours of particular user
							$totalDaysOfDate[$date][$appliedShift] += 1;
						}
					?> 
				</td> 
			<?php }?>
				<td><?php echo $monthlyHours; ?></td>
		</tr>
	<?php }?> 
	</tbody> 
	<tr>
		<td colspan="<?php echo count($dateList)+2;//date('t',strtotime($val))+2;?>">&nbsp;</td>
	</tr> 
	<?php foreach($shiftNames as $key=>$shift){?>
	<tr>
		<th width="13%" style="text-align: center; padding: 0px"><?php echo ucfirst($shift); ?>
		</th>
		<?php //for($i = 1; $i <= date('t',strtotime($firstDate)) ; $i++){ 
                    foreach($dateList as $key => $val) {
                    list($year,$month,$day) = explode("-", $val);
                    $date = str_pad($day,2,0,STR_PAD_LEFT); ?>
		<th width="100" align="center" valign="top"
			style="text-align: center;"><?php echo ($totalDaysOfDate[$date][$shift]) ? $totalDaysOfDate[$date][$shift] : '0';?>
		</th>
		<?php }?>
		<th style="text-align: center;"><?php echo $shiftHours[strtolower($shift)]?>
		</th>
	</tr>
	<?php }?>
	<tr>
		<th width="13%" style="text-align: center; padding: 0px"><?php echo __('Leave'); ?>
		</th>
		<?php //for($i = 1; $i <= date('t',strtotime($firstDate)) ; $i++){
                    foreach($dateList as $key => $val) {
                    list($year,$month,$day) = explode("-", $val);
                ?>
		<th width="100" align="center" valign="top"
			style="text-align: center;"><?php echo ($userArray[$day]['leave']) ? $userArray[$day]['leave'] : '0';?>
		</th>
		<?php }?>
		<th style="text-align: center;">--</th>
	</tr>
</table>
<div class="clr ht5"></div>
<?php echo $this->Form->hidden('',array('name'=>'allUsers','id'=>'allUsers','value'=>implode(',',$allUsers)));?>
<div class="" style="float: right;">
<?php ?>
	<?php if($isApproved == "1"){ 
		echo $this->Form->button('Cancel Approval',array('type'=>'button','class'=>'blueBtn','id'=>'approve','is_approved'=>'0')); 
	} else {
		echo $this->Form->button('Approve',array('type'=>'button','class'=>'blueBtn','id'=>'approve','is_approved'=>'1'));
	}?>
	<?php if($isApproved) echo $this->Html->link('Get Attendence Report',array('controller'=>'HR','action'=>'generateAttendanceSheet',$year,$month),array('class'=>'blueBtn','id'=>'getReport'));?>
</div> 
<div class="clr ht5"></div>
<div style="display: none;" id="contextMenu">
	<table border="0" cellpadding="0" cellspacing="0"
		style="border: thin solid #808080; cursor: default;" width="110px"
		bgcolor="White">
		<?php foreach($shiftNames as $key => $shift){?>
		<tr>
			<td>
				<div class="ContextItem detailItem" value="<?php echo $shift;?>">
					<?php echo ucfirst($shift); ?>
				</div>
			</td>
		</tr>
		<?php }?>
		<?php foreach($leaveTypes  as $key=>$leaveType){?>
		<tr>
			<td>
				<div class="ContextItem detailItem" value="<?php echo $key;?>">
					<?php echo $leaveType; ?>
				</div>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td>
				<div class="ContextItem detailItem" value="OFF">OFF</div>
			</td>
		</tr>
<!--		<tr>
			<td>
				<div class="ContextItem detailItem " style="background: red;"
					value="dutyONCash" id="dutyONCash">Duty On Cash</div>

			</td>
		</tr>-->
	</table>
</div>
<?php 

function checkDeviation($data = array() , $shifts ){
	
	$inOut = explode( '::', $data['inouttime'] );
	$in = reset( $inOut );
	if(count($inOut) % 2 == 0)
		$out = end( $inOut );
	else
		$out = $inOut[count($inOut)-2];
	if($out == '')  return true;;
	
	foreach($shifts as $shiftName=>$shiftStartEnd){
		$beforeStart = date('H:i',strtotime($shiftStartEnd['start']) - 3600);//substracting 1 hour
		$afterEnd = date('H:i',strtotime($shiftStartEnd['end']) );// adding 1 hour + 3600
		
			if( $beforeStart <= $in && $afterEnd >= $out && strtolower($data['shift']) != strtolower($shiftName) ){
//echo "$beforeStart <= $in && $afterEnd >= $out && ".strtolower($data['shift'])." != ".strtolower($shiftName)."</br>";
				return array( ucfirst($shiftName) , 'tooltip invalid');
			}/*else 
				return true;*/
	}
}
?>
<script>

$(document).ready(function (){
	if($( "td" ).hasClass( "invalid" ))
		$('#approve').hide();
	else
		$('#approve').show();

	$('#approve').click(function (){
		var month = $('#month').val();
		var year = $('#year').val();
		var isApproved = $(this).attr('is_approved');
		$.ajax({
			url: "<?php echo $this->Html->url(array("controller" => 'TimeSlots', "action" => "monthlyRosterApproval", "admin" => false)); ?>",
			context: document.body,
			method : 'GET',
			data : 'month='+month+'&Year='+year+'&is_approved='+isApproved,
			beforeSend:function(){
				$('#busy-indicator').show('fast');
			  },				  		  
			success: function(data){
				if(data=="true"){
                                    $("#search").trigger('click');
				}else{
                                    alert("Something went wrong, please try again!");
				}
				//$('#mainChart').html(data);
				$('#busy-indicator').hide('slow'); 
			}   
		});
	});

	$('.ContextItem').click(function (){
		var shift = $(this).attr('value'); 
		var month = $('#month').val();
		var year = $('#year').val();
                var role_id = $('#roles').val();   
		$.ajax({
			url: "<?php echo $this->Html->url(array("controller" => 'TimeSlots', "action" => "newMonthlyRosterChartView", "admin" => false)); ?>",
			context: document.body,
			method : 'POST',
			data : 'dutyRosterId='+currentElementId+'&user_id='+currentUserId+'&shift='+shift+'&date='+currentDate+'&month='+month+'&Year='+year+'&role_id='+role_id+'&user_role_id='+currentUserRole,
			beforeSend:function(){
				$('#busy-indicator').show('fast');
			  },				  		  
			success: function(data){
				$('#mainChart').html(data);
				$('#busy-indicator').hide('slow'); 
			}  
		});
	});

$('.tooltip').tooltipster({
 		interactive:true,
 		position:"top", 
 	});
});

</script>
