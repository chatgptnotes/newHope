<style>
	.tabularForm td td{
	padding:0px;
	font-size:13px;
	color:#e7eeef;
	background:#1b1b1b;
	}
	.tabularForm th td{
	padding:0px;
	font-size:13px;
	color:#e7eeef;
	background:none;
	}
	.tabularForm td td.hrLine{background:url(images/line-dot.gif) repeat-x center;}
	.tabularForm td td.vertLine{background:url(images/line-dot.gif) repeat-y 0 0;}

	#busy-indicator {
    display: none;
    left: 50%;
    margin-top: 250px;
    position: absolute;
}
</style>
<style>	
	td.highlight {
    background-color: #9400D3;
    border: 1px blue ;
}

</style>

<div class="clr ht5"></div>
<?php
if(!isset($isAjax)){
?>
<div class="inner_title">
<h3><?php echo __('Observation Chart'); ?></h3>
</div>
<div class="clr ht5"></div>
<?php
	echo $this->element('patient_information');
	}
?>
<div class="clr ht5"></div>
<form name="itemfrm" id="itemfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "observation_chart/".$patient_id)); ?>" method="post" >
<table>
	<tr>		
		<td align="right">Observation Date<font color="red">*</font> : </td>
		<td>
			<?php echo $this->Form->input('ObservationChart.date', array('type'=>'text','id'=>'previousDate','label'=> false, 'div' => false, 'value'=>$observationDate,'error' => false,'style'=>'width:150px;','readonly'=>'readonly','onchange'=> $this->Js->request(array('action' => 'observation_chart','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#itemfrm', 'data' => '{date:$("#previousDate").val(),patient_id:'.$patient_id.'}', 'dataExpression' => true, 'div'=>false))));?>
		</td>
		<td>&nbsp;</td>
		
	</tr>
</table>
<div class="clr ht5"></div>

<div class="clr ht5"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" id = "row">
  <tr>
	 <th style="text-align:center;">Time<font color="red">*</font></th>
	 <th style="text-align:center;">Pulse</th>
	 <th style="text-align:center;">R/R</th>
	 <th style="text-align:center;width:82px;">B.P.</th>
	 <th style="text-align:center;">TEMP</th>
	 <th style="text-align:center;">O<sub>2</sub>SAT</th>
	 <th style="text-align:center;">RBS</th>
	 <th colspan="4" style="text-align:center;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td colspan="4" height="60" align="center" style="border-bottom:1px solid #3E474A;">Intake</td>
			</tr>
			<tr>
				<td width="60" height="30" align="center">IVF</td>
				<td width="60" align="center">RTF</td>
				<td width="60" align="center">OTHER</td>
				<td width="60" align="center">TOTAL</td>
			</tr>
	   </table>
	 </th>
	 <th colspan="2" style="text-align:center;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td colspan="2" height="30" align="center" style="border-bottom:1px solid #465053;">Output</td>
			</tr>
			<tr>
				<td colspan="2" height="30" align="center" style="border-bottom:1px solid #465053;">Urine</td>
			</tr>
			<tr>
				<td width="60" height="30" align="center">Hourly</td>
				<td width="60" align="center">Total</td>
			</tr>
	   </table>
	 </th>
	 <th style="text-align:center;">Bowel</th>
	 <!--  <th style="text-align:center;">Delete</th>-->
  </tr>
<?php 
$i = 1;
$getRemark = '';
//pr($arrayDateHighlight);exit;
if(!empty($lastRecord)){
	foreach($timeSlots as $key => $time){
		 $j=1;
		foreach($lastRecord as $record){ 
			if($key == $record['ObservationChart']['time']){ ?>
	<tr>
	 <td width="46"> 
		<?php 	if($record['ObservationChart']['time'] == '12MN'){
					echo '12 AM';
				} else if($record['ObservationChart']['time'] == '12PM'){
					echo '12 Noon';
				} else {
				  // Using regular expression to add space between
					$addSpace = preg_split('#(?<=\d)(?=[a-z])#i', $record['ObservationChart']['time']);
					echo $addSpace[0].' '.$addSpace[1];
				}
		?>
			
		</td>	
		<td width="55" align="center"><?php echo $record['ObservationChart']['pulse'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['rr'];?></td>
		<td width="82" align="center"><?php echo $record['ObservationChart']['bp'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['temp'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['osat'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['rbs'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['ivf'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['rtf'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['other'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['total_intake'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['hourly'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['total_output'];?></td>
		<td width="55" align="center"><?php echo $record['ObservationChart']['bowel'];?></td>
		<!-- <td width="55" align="center"><input type="checkbox" name="ObservationChart[deleteId][<?php echo $j;?>]" value="<?php echo $record['ObservationChart']['id'];?>"/> </td> -->

		<?php echo $this->Form->hidden('ObservationChartOld_'.$i,array('legend'=>false,'id'=>'ObservationChart_'.$i,'label'=>false,'div'=>false,'style'=>'width:27px;','value'=>$record['ObservationChart']['time']));?>
		<?php echo $this->Form->hidden('ObservationChartOld_'.$i.'.hourly',array('legend'=>false,'label'=>false,'id'=>'ObservationChart_'.$i.'hourly','div'=>false,'style'=>'width:27px;','value'=>$record['ObservationChart']['total_output']));?>
		<?php echo $this->Form->hidden('ObservationChartOld_'.$i.'.total_output',array('legend'=>false,'label'=>false,'id'=>'ObservationChart_'.$i.'TotalOutput','div'=>false,'style'=>'width:27px;','value'=>$record['ObservationChart']['total_output']));?>	
		<?php $getRemark = $record['ObservationChart']['progress_remark']; ?>

	</tr>
		<?php $i++;$j++; } } } } else {?>
	<tr id="row1">			
		<?php 
		$flag = false;
		//$patient_id = $this->params['pass'][0];	?>		
				<td width="46"><?php echo $this->Form->input('ObservationChart_1.time',array('id'=>'ObservationChart_1','legend'=>false,'label'=>false,'div'=>false,'class'=>'getselected','style'=>'width:93px;','options'=>$timeSlots,'empty'=>'Select','onchange'=>'getChecked(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.pulse',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.rr',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="82"><?php echo $this->Form->input('ObservationChart_1.bp.0',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:24px;'));?>
								/<?php echo $this->Form->input('ObservationChart_1.bp.1',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:24px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.temp',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.osat',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.rbs',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.ivf',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','onkeyup'=>'getTotalInput(this.id);','onblur'=>'getTotalInput(this.id);','onchange'=>'getTotalInput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.rtf',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','onkeyup'=>'getTotalInput(this.id);','onblur'=>'getTotalInput(this.id);',
				'onchange'=>'getTotalInput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.other',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','onkeyup'=>'getTotalInput(this.id);','onblur'=>'getTotalInput(this.id)',
				'onchange'=>'getTotalInput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.total_intake',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly','onchange'=>'getTotalInput(this.id);','onchange'=>'getTotalInput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.hourly',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','onkeyup'=>'getTotalOutput(this.id);','onblur'=>'getTotalOutput(this.id);','onchange'=>'getTotalOutput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.total_output',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly','onkeyup'=>'getTotalOutput(this.id);','onblur'=>'getTotalOutput(this.id);','onchange'=>'getTotalOutput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.bowel',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?>
				
				<?php echo $this->Form->hidden('ObservationChart_1.time',array('id'=>'hiddenTime_1','value'=>''));?>
				</td>
				<!-- <td width="55">&nbsp;</td> -->
		
	 </tr>	
	<?php } ?>
	</table>
	<div class="clr">&nbsp;</div>
		<div class="btns" style="margin-right: -9px;" id="buttons">
			<input type="button" id = 'addButton', value="Add More" class="blueBtn" tabindex="17"/> 
			<input type="button" id = 'removeButton', value="Remove" class="grayBtn" tabindex="17"/> 
		
		</div>
	<div class="clr">&nbsp;</div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
		<tr>
			<th>Progress in last 24 hours:</th>
		</tr>
		<tr>
		  <td><?php echo $this->Form->input('ObservationChart.progress_remark',array('legend'=>false,'label'=>false,'div'=>false,'rows'=>'3','cols'=>'10','style'=>'width:98%;','value'=>$getRemark));;?></td>                            
		</tr>
	</table>
		
	   
	<div class="btns" style="margin-right: 178px;">
	<input type="submit" value="Save" class="blueBtn" tabindex="17" onclick="return getValidate();">
<?php 
//pr($lastRecord);exit;
if(!empty($lastRecord)){?>
<a target="_blank" href="<?php echo $this->Html->url(array('action' => 'print_observation',$patient_id));?>?date=<?php echo date("Y-m-d",strtotime($date));?>" class="blueBtn">
Print Chart</a>
 
<?php   						
} ?>
	<?php echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'observation_chart_list',$patient_id), array('escape' => false,'class'=>'grayBtn'));?>
		</div>
		<div class="clr ht5"></div>
	   <!-- Right Part Template ends here -->
<?php 
	if(count($lastRecord) >=1){
		$count = count($lastRecord) + 1;
	} else {
		$count = 2;
	}
?>	  
</form>
<!-- Left Part Template Ends here -->
     
 <script>
	
// Set this variable as global variable
		 var countRow = <?php echo $count; ?>;
		 var lastCount = <?php echo count($lastRecord);?>;
// Spart add more here 
 $(document).ready(function(){
	
	$('#flashMessage').remove();
	// do not show unless the roe has been added	
		$('#removeButton').hide('fast');
	// No more add more if the last entry time is 11 pm 
		if(document.getElementById("ObservationChart_"+(countRow - 1)).value == '11PM'){
			$("#addButton").hide();	
		}

		$("#addButton").click(function () {	
			//alert(countRow);
		// Create new <tr>
			var newNoteDiv = $(document.createElement('tr'))
			.attr("id", 'row' + countRow);		
		// Collect previous values if there
			var lastTime = '';
			//lastSelected = '';
			var lastSelected = document.getElementById("ObservationChart_"+(countRow - 1));
			if(countRow >= 2){
				lastTime = document.getElementById("ObservationChart_"+(countRow - 1)).value;
				
			}/* else {
				lastTime = document.getElementById("ObservationChart_"+(lastCount)).value;
				//lastSelected = document.getElementById("ObservationChart_"+(lastCount));
			}*/
			
		// Create HTML		
			var data_row = '<td width="46"><select class = "getselected" onChange="getChecked(this.id);" id="ObservationChart_'+countRow+'" style="width:93px;" name="data[ObservationChart_'+countRow+'][time]"><option value="">Select</option><option value="12AM">12 AM</option><option value="1AM">1 AM</option><option value="2AM">2 AM</option>	<option value="3AM">3 AM</option><option value="4AM">4 AM</option><option value="5AM">5 AM</option><option value="6AM">6 AM</option><option value="7AM">7 AM</option>					<option value="8AM">8 AM</option><option value="9AM">9 AM</option><option value="10AM">10 AM</option><option value="11AM">11 AM</option><option value="12PM">12 Noon</option>			<option value="1PM">1 PM</option><option value="2PM">2 PM</option><option value="3PM">3 PM</option><option value="4PM">4 PM</option><option value="5PM">5 PM</option>					<option value="6PM">6 PM</option><option value="7PM">7 PM</option><option value="8PM">8 PM</option><option value="9PM">9 PM</option><option value="10PM">10 PM</option>					<option value="11PM">11 PM</option></select></td>																																		<td width="55"><input name="data[ObservationChart_'+countRow+'][pulse]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Pulse"/></td>									<td width="55"><input name="data[ObservationChart_'+countRow+'][rr]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Rr"/></td>										<td width="82"><input name="data[ObservationChart_'+countRow+'][bp][0]" style="width:24px;" type="text" id="ObservationChart_'+countRow+'Bp0"/>/<input name="data[ObservationChart_'+countRow+'][bp][1]" style="width:24px;" type="text" id="ObservationChart_'+countRow+'Bp1"/></td>										<td width="55"><input name="data[ObservationChart_'+countRow+'][temp]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Temp"/></td>									<td width="55"><input name="data[ObservationChart_'+countRow+'][osat]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Osat"/></td>									<td width="55"><input name="data[ObservationChart_'+countRow+'][rbs]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Rbs"/></td>										<td width="55"><input name="data[ObservationChart_'+countRow+'][ivf]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Ivf"  onblur = "getTotalInput(this.id);" onkeyup = "getTotalInput(this.id);" onchange = "getTotalInput(this.id);"/></td>			<td width="55"><input name="data[ObservationChart_'+countRow+'][rtf]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Rtf"  onblur = "getTotalInput(this.id);" onkeyup = "getTotalInput(this.id);" onchange = "getTotalInput(this.id);"/></td>								<td width="55"><input name="data[ObservationChart_'+countRow+'][other]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Other" onblur = "getTotalInput(this.id);" onkeyup = "getTotalInput(this.id);" onfocus = "getTotalInput(this.id);"/></td>		<td width="55"><input name="data[ObservationChart_'+countRow+'][total_intake]" style="width:27px;" readonly="readonly" type="text" id="ObservationChart_'+countRow+'TotalIntake" onblur = "getTotalInput(this.id);" onkeyup = "getTotalInput(this.id);" onchange = "getTotalInput(this.id);"/></td><td width="55"><input name="data[ObservationChart_'+countRow+'][hourly]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Hourly" onkeyup = "getTotalOutput(this.id);" onchange = "getTotalOutput(this.id);"/></td>	<td width="55"><input name="data[ObservationChart_'+countRow+'][total_output]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'TotalOutput" readonly="readonly" onkeyup = "getTotalOutput(this.id);" onchange = "getTotalOutput(this.id);"/></td> <td width="55"><input name="data[ObservationChart_'+countRow+'][bowel]" style="width:27px;" type="text" id="ObservationChart_'+countRow+'Bowel"/><input id = "hiddenTime_'+countRow+'" type="hidden", value = "" name="data[ObservationChart_'+countRow+'][time]"></td>';		
			
		// When Time is not selected. Add more is not allowed	
			//alert(countRow);
			if(countRow >= 2){				
			// set previously calculated value for next total out put untill the new is to be enterd
				var totalOutput = $("#ObservationChart_"+(countRow - 1)+"TotalOutput").val();
				if(totalOutput == '') totalOutput = 0; // When empty set it as zero
				lastSelected.disabled = true;
			} /*else {
			// set previously calculated value for next total out put untill the new is to be enterd
				alert(lastCount);				
				var totalOutput = $("#ObservationChart_"+(lastCount)+"TotalOutput").val();
				if(totalOutput == '') totalOutput = 0; // When empty set it as zero	
				lastSelected.disabled = true;
			}*/
			if($("#ObservationChart_"+(countRow - 1)).val() != '' ){
				
		// Flag to show hide remove button
			var hideRemove = false;
		// Set limited rows
				if(countRow <= 24 && lastTime != '11PM'){
					
					newNoteDiv.append(data_row);					
					newNoteDiv.appendTo("#row");
				// Pass The calculated value to new total output input box
					$("#ObservationChart_"+countRow+"TotalOutput").val(totalOutput);
					countRow++;
				} else {
					alert("Time slots are completed!");
					lastSelected.disabled = false;
					hideRemove = true;
					//$("#row" + countRow).remove();
					//countRow--;
				}
			} else {
				alert('Please select time!');
				lastSelected.disabled = false;
				if(counter >2){
					countRow--;
				}
			}
				
		// Show renove button	
			if(countRow > 2 && hideRemove != true) $('#removeButton').show('slow');
			
		});
	
	// Remove added row
			$("#removeButton").click(function () {
				countRow--;	
				$("#row" + countRow).remove();				
				//countRow--;	
				if(lastCount == 0){
					document.getElementById("ObservationChart_"+(countRow - 1)).disabled = false;
					if(countRow <= 2) $('#removeButton').hide('slow');
				} else {
					//alert(countRow);
					document.getElementById("ObservationChart_"+(countRow - 1)).disabled = false;
					if(countRow == lastCount + 1) $('#removeButton').hide('slow');
				}
		  });
	
	})	  //EOF add n remove drug inputs
			

// Validate for selecting same time for multiple add

	function getChecked(id) {
		
		// Split collected id
			//var split = id.split('_');
			var numb = id.match(/\d/g);
			numb = numb.join("");
		// Set flag for error. 
			var error = false; // No error
		// When his is not the first row
			if(numb > 1){
					
				// Getthe previous meredian and time sepratly i.e. AM/PM			
					var prvMeredian = $("#ObservationChart_"+(numb-1)).val().match(/[A-Z]+/);  // will get AM	
					//alert(prvMeredian);
				// Seprate the number from the option selected
					var prevTime = $("#ObservationChart_"+(numb-1)).val().match(/\d/g);
				// join the number
					prevTime = prevTime.join("");
					
				// Get the current meredian and time sepratly i.e. AM/PM
					var currMeredian = $("#ObservationChart_"+(numb)+" option:selected").val().match(/[A-Z]+/); 

				// Seprate the number from the option selected
					var currTime = $("#ObservationChart_"+(numb)+" option:selected").val().match(/\d/g);
					
					//alert(currMeredian);
				// join the number
					currTime = currTime.join("");
				
				// If Selected time is less than previous time as this is passed time				
				  if(parseInt(currTime) == 12 && parseInt(currTime) > parseInt(prevTime) && ('"'+prvMeredian+'"') == ('"'+currMeredian+'"')){					
					alert('Observation of '+currTime+' '+ currMeredian+' is not allowed!');

					error = true; // Flag
				// Remove selected row
					$("#row" + numb).remove();
					document.getElementById("ObservationChart_"+(numb - 1)).disabled = false;
					countRow--;
					if(countRow <= 2) $('#removeButton').hide('slow');

				 } else if(parseInt(prevTime) != 12 && parseInt(currTime) < parseInt(prevTime) && ('"'+prvMeredian+'"') == ('"'+currMeredian+'"')){ // When time is taken is less than the previous i.e. if 3AM is selected then 1AM is ot allowed in next row					
					
					alert('Observation of '+currTime+' '+ currMeredian+' is not allowed!');
					error = true; // Flag
				// Remove selected row
					$("#row" + numb).remove();
					document.getElementById("ObservationChart_"+(numb - 1)).disabled = false;
					countRow--;
					 
					if(countRow <= 2 || lastCount == (countRow - 1)) $('#removeButton').hide('slow');
				 
				 } else if(currMeredian == 'AM' && prvMeredian == 'PM'){
					alert('Observation of '+currTime+' '+ currMeredian+' is not allowed!');
					error = true; // Flag
				// Remove selected row
					$("#row" + numb).remove();
					document.getElementById("ObservationChart_"+(numb - 1)).disabled = false;
					countRow--;
					if(countRow <= 2 || lastCount == (countRow - 1)) $('#removeButton').hide('slow');
					
				 } else {		
				// Check wheather option is selected or not in loop
					for(i=1; i<=numb; i++){					
						if($("#ObservationChart_"+numb+" option:selected").val() == $("#ObservationChart_"+(i-1)).val()){
							alert('Observation of '+currTime+' '+currMeredian+' is already selected');
							error = true; // Flag
						// Remove selected row
							$("#row" + numb).remove();	
							document.getElementById("ObservationChart_"+(numb - 1)).disabled = false;
							countRow--; //decrease the countRow
							if(countRow <= 2 || lastCount == (countRow - 1)) $('#removeButton').hide('slow');				
						}				
					}
				}
                                
				if(error == false){
					//alert($("#ObservationChart_"+numb+" option:selected").val());
					$('#hiddenTime_'+numb).val($("#ObservationChart_"+numb+" option:selected").val());
					if(numb == 2){
                                               
						$('#hiddenTime_1').val($("#ObservationChart_"+(numb-1)+" option:selected").val());
					} 
				}
				// Check wheather option is selected or not in loop
					/*for(i=1; i<=numb; i++){					
						if($("#ObservationChart_"+numb+" option:selected").val() == $("#ObservationChart_"+(i-1)).val()){
							alert('Observation of '+$("#ObservationChart_"+numb+" option:selected").val()+' is already slected');
						// Remove selected row
							$("#row" + numb).remove();
							countRow--; //decrease the countRow
							 if(countRow <= 2) $('#removeButton').hide('slow');						
						}				
					}*/

		 } 
                 // this is code is necessary if you enter only record only //
                 if(numb == 1) { 
                    $('#hiddenTime_1').val($("#ObservationChart_"+numb+" option:selected").val());
                 } 			
	}
	

// Validate for date and time

	function getValidate(){
		
		if(countRow == 2){
			var count = 1;
		} else {
			var count = countRow - 1;
		}
		var time = $("#ObservationChart_"+count).val();
		var observaionDate = $('#previousDate').val();
		
		
		if(time == '' && observaionDate == ''){
			alert("Please select date and time!");
			return false;
		} else if(time == ''){
			alert("Please select time or remove row!");
			return false;
		} else if(observaionDate == ''){
			alert("Please select date!");
			return false;
		}
		//alert(time);
		//return false;
		
	}

// To calculate the total of Intake
	function getTotalInput(id){
	// Separate the number from ID	
		var numb = id.match(/\d/g);
		numb = numb.join("");
	//  Initialize variable  
		var total = 0;
		var IVF = $('#ObservationChart_'+(numb)+'Ivf').val();
		var RTF = $('#ObservationChart_'+(numb)+'Rtf').val();
		var Other = $('#ObservationChart_'+(numb)+'Other').val();
		//alert(RTF)
		var isNumIVF = /^\s*\d+\s*$/.test(IVF);
		var isNumRTF = /^\s*\d+\s*$/.test(RTF);
		var isNumOther = /^\s*\d+\s*$/.test(Other);
		
	// Clear empty 	

			if(IVF == '' || IVF == 'undefined' || isNumIVF == false){ 
				IVF = 0;
				$('#ObservationChart_'+(numb)+'Ivf').val('');
			} 
			if(RTF =='' || RTF =='undefined' || isNumRTF == false){
				RTF = 0;
				$('#ObservationChart_'+(numb)+'Rtf').val('');
			} 
			if(Other == '' || Other == 'undefined' || isNumOther == false){
				Other = 0;
				$('#ObservationChart_'+(numb)+'Other').val('');
			}
		// Whne all empty Total is also Empty
			if(IVF == 0 && RTF == 0 && Other == 0){
				$('#ObservationChart_'+(numb)+'TotalIntake').val(0);
			}
		// Calculate Total 
			if(IVF != '' || RTF != '' || Other != ''){				
				total = parseFloat(IVF)+parseFloat(RTF)+parseFloat(Other);
			// Set total
				$('#ObservationChart_'+(numb)+'TotalIntake').val(total);
			} 
		
	}

var allTotal = 0;
// To Calculte Out Put Total

	function getTotalOutput(id){	
		
		var numb = id.match(/\d/g);
		numb = numb.join("");
		var total = 0;		
		
		var Hourly = $('#ObservationChart_'+(numb)+'Hourly').val();
		
		
		var isHourly = /^\s*\d+\s*$/.test(Hourly);
		
		if(Hourly == '' || Hourly == 'undefined' || isHourly == false){ 
			Hourly = 0;
			$('#ObservationChart_'+(numb)+'Hourly').val('');
			if(numb > 1){
				$('#ObservationChart_'+(numb)+'TotalOutput').val($('#ObservationChart_'+(numb -1)+'TotalOutput').val());
			} else {
				$('#ObservationChart_'+(numb)+'TotalOutput').val(0);
			}
		} 
		
		
		if(numb == 1 && Hourly != ''){				
			total = parseFloat(Hourly);
			$('#ObservationChart_'+(numb)+'TotalOutput').val(total);
						
		} else if(Hourly != '' && numb > 1){
			
			total = parseFloat(Hourly) + parseFloat($('#ObservationChart_'+(numb-1)+'TotalOutput').val());			
			$('#ObservationChart_'+(numb)+'TotalOutput').val(total);
			var row = countRow-1;
			
			for(i=numb; i<=row;i++){				
				total = parseFloat(Hourly) + parseFloat($('#ObservationChart_'+(numb-1)+'TotalOutput').val());	
				if( i == numb){
					$('#ObservationChart_'+(i)+'TotalOutput').val(total);
				} else {
					//$('#ObservationChart_'+(i)+'TotalOutput').val('');
					//$('#ObservationChart_'+(i)+'Hourly').val('');
					$("#row" + i).remove();
					countRow--;
					if(countRow <= 2) $('#removeButton').hide('slow');
				}
				
				
			}
			document.getElementById("ObservationChart_"+ numb).disabled = false;
		 }			
	  } 
	  
	// This is for datepicker
	 $("#previousDate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			 
			 beforeShowDay: highlightDays,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			
		});


 var dates = <?php echo json_encode($arrayDateHighlight); ?>;
function highlightDays(date) {
        for (var i = 0; i < dates.length; i++) {
            if (new Date(dates[i]).toString() == date.toString()) {              
                          return [true, 'highlight'];
                  }
          }
          return [true, ''];

 }
</script>
