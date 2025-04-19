<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center">
	<tr>
		<td align="left" colspan="2">&nbsp;Date of Previous Fall&nbsp;<span id="second_date">
		<?php $setDate = $this->DateFormat->formatDate2Local($date,Configure::read('date_format')); 
			echo $this->Form->input('FallAssessment.datePrevious', array('type'=>'text','id'=>'previousDate','label'=> false, 'div' => false, 'error' => false,'style'=>'width:150px;','readonly'=>'readonly','value'=>$setDate,'onchange'=> $this->Js->request(array('action' => 'fall_assessment','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#formTable', 'data' => '{date:$("#previousDate").val(),patient_id:'.$patient_id.'}', 'dataExpression' => true, 'div'=>false))));?></span>
		</td>
		
		<td colspan = "2">Time of Fall :&nbsp;<?php if(!empty($getData['FallAssessment']['time'])) { 
				echo $getData['FallAssessment']['time'];
		}?></td>
	</tr>
	<tr>
		<th width="6%" align="center">Sr. No.</th>	
		<th width="20%" align="center">Terms</th>
		<th width="20%" align="center">Values</th>
		<th width="2%" align="center">Score</th>
	</tr>
<?php if(!empty($getData)){?>
	<tr>
	 <td align="center">1</td>
	  <td> History Of Falling</td>
	  <td><?php echo $getData['FallAssessment']['history']; ?></td>
	  <td><?php echo $getData['FallAssessment']['history_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">2</td>
	  <td>Secondary Diagnosis</td>
	  <td><?php echo $getData['FallAssessment']['secondary_diagnosis']; ?></td>
	  <td><?php echo $getData['FallAssessment']['secondary_diagnosis_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">3</td>
	  <td>Ambulatory Aid </td>
	  <td><?php $ambulatory_aid = $getData['FallAssessment']['ambulatory_aid'];
				if($ambulatory_aid == 'non_bed_rest_nurse_assist'){
					echo 'None/bed rest/nurse assist';				
				} else if($ambulatory_aid == 'crutches_cane_walker'){
					echo 'Crutches/cane/walker';
				} else {
					echo ucfirst($getData['FallAssessment']['ambulatory_aid']);
				}?></td>
	  <td><?php echo $getData['FallAssessment']['ambulatory_aid_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">4</td>
	  <td>IV or IV Access</td>
	  <td><?php echo $getData['FallAssessment']['access'];?></td>
	  <td><?php echo $getData['FallAssessment']['access_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">5</td>
	  <td>Gait</td>
	  <td><?php $gait = $getData['FallAssessment']['gait'];
				if($gait == 'Normal_bed_rest_wheelchair'){
					echo ' Normal/bed rest/wheelchair';				
				} else {
					echo ucfirst($getData['FallAssessment']['gait']);
				}?></td>
	  <td><?php echo $getData['FallAssessment']['gait_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">6</td>
	  <td>Mental status </td>
	  <td><?php 
			$mental_status =  $getData['FallAssessment']['mental_status'];
			if($mental_status == 'oriented_to_own_ability'){
				echo 'Oriented to own ability';
			} else if($mental_status == 'overestimates_or_forgets_limitations'){
				echo ' Overestimates or forgets limitations';
			}?></td>
	  <td><?php echo $getData['FallAssessment']['mental_status_score'];?></td>                   		  
	</tr>
<?php } else { ?>
	<tr>
		<td colspan="3">No Record Found!</td>
	</tr>
<?php }?>
</table>	
<div class="ht5">&nbsp;</div>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="">
	<tr>
		<td width="104" height="28" align="right" valign="middle"><strong>Total Score :</strong></td>
		<td align="center"><?php echo $getData['FallAssessment']['total_score'];?></td>
		<td>&nbsp;</td>
		<td width="150" height="28" align="right" valign="middle"><strong>Risk Level :</strong></td>
		<?php if($getData['FallAssessment']['risk_level'] == 'Low Risk Level'){?>
		<td align="left">&nbsp;&nbsp;<font color="#FFFFFF" style="font-weight:bold;"><?php echo $getData['FallAssessment']['risk_level'];?></font></td>
		<?php } else if($getData['FallAssessment']['risk_level'] == 'Midium Risk Level') {?>
		<td align="left">&nbsp;&nbsp;<font color="#FABF00" style="font-weight:bold;"><?php echo $getData['FallAssessment']['risk_level'];?></font></td>
		<?php } else { ?>
		<td align="left">&nbsp;&nbsp;<font color="#B01519" style="font-weight:bold;"><?php echo $getData['FallAssessment']['risk_level'];?></font></td>
		<?php } ?>
	</tr> 
	
		
</table>
  <div class="btns">		  
			<?php if(!empty($getData)){
				echo $this->Html->link(__('Print'),'#', array('id'=>'print','escape' => false,'class'=>'blueBtn','style'=>'padding:5px;12px;','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_fallassessment',$patient_id,'date'=>$date))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
									
			} ?>
		   <?php echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'fall_assessment/',$patient_id), array('escape' => false,'class'=>'grayBtn'));?>
		 
 </div>

 <script>
  var daysToEnable = <?php echo json_encode($arrayDate); ?>;	
 $(function () {	
	//alert(daysToEnable);
            $('#previousDate').datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				maxDate: new Date(),
                beforeShowDay: enableSpecificDates,
               dateFormat:'<?php echo $this->General->GeneralDate();?>',
            });
 
	//Function created to collect previous dates only. Return true if date found and false to hide date not in table
            function enableSpecificDates(date) {
                var month = date.getMonth();
                var day = date.getDate();
                var year = date.getFullYear();
                for (i = 0; i < daysToEnable.length; i++) {
                    if ($.inArray((month + 1) + '-' + day + '-' + year, daysToEnable) != -1) {
                        return [true];
                    }
                }
                return [false];
            }
        });
 </script>
