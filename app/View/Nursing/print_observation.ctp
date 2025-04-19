<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
 <style>
	.patientHub{width:70%;margin-left:20%}
	.boxBorder{border:1px solid #000000;}
	.boxBorderBot{border-bottom:1px solid #000000;}
	.boxBorderRight{border-right:1px solid #000000;}
	.tdBorderRtBt{border-right:1px solid #000000; border-bottom:1px solid #000000;}
	.tdBorderBt{border-bottom:1px solid #000000;}
	.tdBorderTp{border-top:1px solid #000000;}
	.tdBorderRt{border-right:1px solid #000000;}
	.tdBorderTpBt{border-bottom:1px solid #000000; border-top:1px solid #000000;}
	.tdBorderTpRt{border-top:1px solid #000000; border-right:1px solid #000000;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	.th td{color:#FFFFFF;}
</style>
<div class="clr ht5"></div>
<?php echo $this->element('print_patient_info');?>
<div class="clr ht5"></div>
<div align="center">
<h3><?php echo __('Observation Chart'); ?></h3>
</div>
<div class="clr ht5"></div>

<table border="1" class="tabularForm"  cellpadding="0" cellspacing="1" width="100%" style="text-align:center;">

	<tr>
		 <th style="text-align:center;">Time</th>
		 <th style="text-align:center;">Pulse</th>
		 <th style="text-align:center;">R/R</th>
		 <th style="text-align:center;">B.P.</th>
		 <th style="text-align:center;">TEMP</th>
		 <th style="text-align:center;">O<sub>2</sub>SAT</th>
		 <th style="text-align:center;">RBS</th>
		 <th colspan="4" style="text-align:center;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="4" height="60" align="center" style="border-bottom:1px solid #3E474A;color:#fff">Intake</td>
				</tr>
				<tr>
					<td width="60" height="30" align="center" style="color:#fff">IVF</td>
					<td width="60" align="center" style="color:#fff">RTF</td>
					<td width="60" align="center" style="color:#fff">OTHER</td>
					<td width="60" align="center" style="color:#fff">TOTAL</td>
				</tr>
		   </table>
		 </th>
		 <th colspan="2" style="text-align:center;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="2" height="30" align="center" style="border-bottom:1px solid #465053;color:#fff">Output</td>
				</tr>
				<tr>
					<td colspan="2" height="30" align="center" style="border-bottom:1px solid #465053;color:#fff">Urine</td>
				</tr>
				<tr>
					<td width="60" height="30" align="center" style="color:#fff">Hourly</td>
					<td width="60" align="center" style="color:#fff">Total</td>
				</tr>
		   </table>
		 </th>
		 <th style="text-align:center;">Bowel</th>
		
	  </tr>
		 
	<?php	
		if(!empty($record)){
		foreach($timeSlots as $key => $time){
			foreach($record as $data){	
			  if($key == $data['ObservationChart']['time']){ ?>
	<tr>
		<td width="55" align="center"><?php 	if($data['ObservationChart']['time'] == '12MN'){
				echo '12 AM';
			} else if($data['ObservationChart']['time'] == '12PM'){
				echo '12 Noon';
			} else {
			  // Using regular expression to add space between
				$addSpace = preg_split('#(?<=\d)(?=[a-z])#i', $data['ObservationChart']['time']);
				echo $addSpace[0].' '.$addSpace[1];
			}
		?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['pulse'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['rr'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['bp'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['temp'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['osat'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['rbs'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['ivf'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['rtf'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['other'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['total_intake'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['hourly'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['total_output'];?></td>
		<td width="55" align="center"><?php echo $data['ObservationChart']['bowel'];?></td>
		<!-- <td width="55" align="center"><?php echo $data['ObservationChart']['progress_remark'];?></td> -->
	</tr>	
	
<?php } }}} else {?>
	<tr>
		<td colspan='14'>Norecord Found</td>
	</tr>
<?php } ?>
 
 </table>
 </br>
<table width="100%" cellpadding="0" cellspacing="1" border="1">
	<tr align="left">
		<th>Progress in last 24 hours:</th>
	</tr>
	<tr>
	  <td><?php 
		if(!empty($getRemark)){
			echo $getRemark;
		}
	?></td>                            
	</tr>
</table>
 
 