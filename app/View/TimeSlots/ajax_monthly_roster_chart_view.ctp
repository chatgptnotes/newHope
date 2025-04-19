<table width="100%" cellpadding="0" cellspacing="1" border="0" id= 'rosterTable'
	class="tabularForm">
	<tr>
		<th width="13%" class="note1" style="text-align: center; padding: 0px"><div>&nbsp;</div><div>Date</div>
			<div class="firstColumn" style="height: 25px;">Name</div></th>
		<?php $allshifts = $shiftNames;?>
		<?php for($i = 1; $i <= date('t') ; $i++){?>
		<?php $leave[$i] = 0;?>
		<th width="100" align="center" valign="top"
			style="text-align: center;"><?php echo $i." ".date('D',strtotime(date('Y-m-'.$i)));?>
		</th>
		<?php }?>
		<th width="100" align="center" valign="top"
			style="text-align: center;">Total Work Hours</th>
	</tr>
	<?php 
	$userArray = array();
	$isApproved = false;
	$leaveTypes = configure::read('leaveTypes');?>
	<?php foreach($rosterData as $roster){?>
	<?php if(empty($roster['DutyRoster']))continue;?>
	<tr oncontextmenu="return false">
		<td align="left" valign="top" class="firstColumn"><?php echo $roster['User']['full_name'];?>
			<?php $allUsers[] = $roster['User']['id'];?></td>
		<?php for($i = 1; $i <= date('t') ; $i++){?>
		<?php if($i < date('j',strtotime($roster['DutyRoster']['0']['date']))){?>
		<td style="text-align: center;">--</td>
		<?php }?>
		<?php }?>
		<?php 
		$monthlyHours = 0;
		foreach($roster['DutyRoster'] as $key =>$shifts){
		if($shifts['day_off'] =='0'){
			$userArray[date('j',strtotime($shifts['date']))][strtolower($shifts['shift'])] = (int) ($userArray[date('j',strtotime($shifts['date']))][strtolower($shifts['shift'])]) + 1;
			$monthlyHours = $monthlyHours + $shiftTimes[strtolower($shifts['shift'])];
			$shiftHours[strtolower($shifts['shift'])] = floatval($shiftHours[strtolower($shifts['shift'])]) +  $shiftTimes[strtolower($shifts['shift'])];
		}else{
			$userArray[date('j',strtotime($shifts['date']))]['leave'] = (int) ($userArray[date('j',strtotime($shifts['date']))]['leave']) + 1;
		}
		$shiftLeaveTitle = ($shifts['day_off'] != '0') ? $leaveTypes[$shifts['day_off']] : ucfirst($shifts['shift']);
		$shiftLeave = ($shifts['day_off'] != '0') ? $shifts['day_off'] : ucfirst(substr($shifts['shift'],0 , 1 )) ;
		?>
		<?php 
		  $background = ($shifts['duty_on_cash']) ? "background: red;" : ""; ?>
		 <?php  $invalid = checkDeviation($shifts , $shiftRange);?>
		<td style="text-align: center; cursor: pointer; <?php echo $background;?> "
			title="<?php echo ($invalid[0]) ? $invalid[0] : $shiftLeaveTitle; ?>" class="detailItem  <?php echo $invalid[1];?>"  
			id="<?php echo $shifts['id']?>"
			onmousedown="HideMenu('contextMenu');"
			onclick="HideMenu('contextMenu');"
			onmouseup="HideMenu('contextMenu');"
			<?php if(!$roster['DutyPlan']['duty_plan_approved']){?>oncontextmenu="ShowMenu('contextMenu',event,'<?php echo $shifts[id]?>');"<?php }?> >
			<?php if($roster['DutyPlan']['duty_plan_approved'])$isApproved = true;?>
			<?php echo substr($shiftLeave, 0 ,2) ;?>
		</td>
		<?php }?>
		<td style="text-align: center;"><?php echo $monthlyHours;?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="<?php echo date('t')+2;?>">&nbsp;</td>
	</tr>
	<?php foreach($shiftNames as $key=>$shift){?>
	<tr>
		<th width="13%" style="text-align: center; padding: 0px"><?php echo ucfirst($shift); ?>
		</th>
		<?php for($i = 1; $i <= date('t') ; $i++){?>
		<th width="100" align="center" valign="top"
			style="text-align: center;"><?php echo ($userArray[$i][strtolower($shift)]) ? $userArray[$i][strtolower($shift)] : '0';?>
		</th>
		<?php }?>
		<th style="text-align: center;"><?php echo $shiftHours[strtolower($shift)]?>
		</th>
	</tr>
	<?php }?>
	<tr>
		<th width="13%" style="text-align: center; padding: 0px"><?php echo __('Leave'); ?>
		</th>
		<?php for($i = 1; $i <= date('t') ; $i++){?>
		<th width="100" align="center" valign="top"
			style="text-align: center;"><?php echo ($userArray[$i]['leave']) ? $userArray[$i]['leave'] : '0';?>
		</th>
		<?php }?>
		<th style="text-align: center;">--</th>
	</tr>
</table>
<div class="clr ht5"></div>
<?php echo $this->Form->hidden('',array('name'=>'allUsers','id'=>'allUsers','value'=>implode(',',$allUsers)));?>
<div class="" style="float: right;">
	<?php echo $this->Form->button('Approve',array('type'=>'button','id'=>'approve'));?>
	<?php if($isApproved) echo $this->Html->link('Get Attendence Report',array('controller'=>'HR','action'=>'generateAttendanceSheet'),array('class'=>'blueBtn','id'=>'getReport'));?>
</div>
<div class="clr ht5"></div>
<div style="display: none;" id="contextMenu">
	<table border="0" cellpadding="0" cellspacing="0"
		style="border: thin solid #808080; cursor: default;" width="110px"
		bgcolor="White">
		<?php foreach($shiftNames as $key=>$shift){?>
		<tr>
			<td>
				<div class="ContextItem detailItem" value="<?php echo $shift;?>">
					<?php echo ucfirst($shift); ?>
				</div>
			</td>
		</tr>
		<?php }?>
		<?php foreach(Configure::read('leaveTypes') as $key=>$leaveTypes){?>
		<tr>
			<td>
				<div class="ContextItem detailItem" value="<?php echo $key;?>">
					<?php echo $leaveTypes; ?>
				</div>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td>
				<div class="ContextItem detailItem" value="OFF">OFF</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="ContextItem detailItem " style="background: red;"
					value="dutyONCash" id="dutyONCash">Duty On Cash</div>

			</td>
		</tr>
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
		$.ajax({
			url: "<?php echo $this->Html->url(array("controller" => 'TimeSlots', "action" => "monthlyRosterChartView", "admin" => false)); ?>",
			context: document.body,
			method : 'GET',
			data : 'approve='+true,
			beforeSend:function(){
				$('#busy-indicator').show('fast');
			  },				  		  
			success: function(data){
				$('#mainChart').html(data);
				$('#busy-indicator').hide('slow'); 
			}   
		});
	});

	$('.ContextItem').click(function (){
		var shift = $(this).attr('value');
		$.ajax({
			url: "<?php echo $this->Html->url(array("controller" => 'TimeSlots', "action" => "monthlyRosterChartView", "admin" => false)); ?>",
			context: document.body,
			method : 'POST',
			data : 'dutyRosterId='+currentElementId+'&shift='+shift,
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
