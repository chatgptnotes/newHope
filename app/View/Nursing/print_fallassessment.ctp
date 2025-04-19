<div id="printButton">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<body class="print_form" onload="window.print();">
	<?php 
		echo $this->element('patient_header') ;
	?>
	<div class="ht5"></div>
	<div><h3>Fall Assessment</h3></div>
  <table>
		<tr>
			<td width="50" height="35" valign="middle" align="left"><b>Date:</b></td>
			<td width="50" align="left" valign="middle"><?php 			
			echo $date;
			?>
			</td>
			<td width="50" height="35" valign="middle" align="left">&nbsp;</td> 
			<td width="100" height="35" valign="middle" align="left"><b>Time of Fall:</b></td>
			<td width="50" align="left" valign="middle"><?php 			
			echo $record['FallAssessment']['time'];
			?>
			</td>
			
		  </tr>
   </table>
   <table width="100%" cellpadding="3" cellspacing="0" border="1" class="" align="center">
	<tr>
		<th width="6%" align="center">Sr. No.</th>	
		<th width="20%" align="center">Terms</th>
		<th width="30%" align="center">Values</th>
		<th width="2%" align="center">Score</th>
	</tr>
	<tr>
	 <td align="center">1</td>
	  <td align="center"> History Of Falling</td>
	  <td align="center"><?php echo $record['FallAssessment']['history']; ?></td>
	  <td align="center"><?php echo $record['FallAssessment']['history_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">2</td>
	  <td align="center">Secondary Diagnosis</td>
	  <td align="center"><?php echo $record['FallAssessment']['secondary_diagnosis']; ?></td>
	  <td align="center"><?php echo $record['FallAssessment']['secondary_diagnosis_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">3</td>
	  <td align="center">Ambulatory Aid </td>
	  <td align="center"><?php $ambulatory_aid = $record['FallAssessment']['ambulatory_aid'];
				if($ambulatory_aid == 'non_bed_rest_nurse_assist'){
					echo 'None/bed rest/nurse assist';				
				} else if($ambulatory_aid == 'crutches_cane_walker'){
					echo 'Crutches/cane/walker';
				} else {
					echo ucfirst($record['FallAssessment']['ambulatory_aid']);
				}?></td>
	  <td align="center"><?php echo $record['FallAssessment']['ambulatory_aid_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">4</td>
	  <td align="center">IV or IV Access</td>
	  <td align="center"><?php echo $record['FallAssessment']['access'];?></td>
	  <td align="center"><?php echo $record['FallAssessment']['access_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">5</td>
	  <td align="center">Gait</td>
	  <td align="center"><?php $gait = $record['FallAssessment']['gait'];
				if($gait == 'Normal_bed_rest_wheelchair'){
					echo ' Normal/bed rest/wheelchair';				
				} else {
					echo ucfirst($record['FallAssessment']['gait']);
				}?></td>
	  <td align="center"><?php echo $record['FallAssessment']['gait_score'];?></td>                   		  
	</tr>
	<tr>
	  <td align="center">6</td>
	  <td align="center">Mental status </td>
	  <td align="center"><?php 
			$mental_status =  $record['FallAssessment']['mental_status'];
			if($mental_status == 'oriented_to_own_ability'){
				echo 'Oriented to own ability';
			} else if($mental_status == 'overestimates_or_forgets_limitations'){
				echo ' Overestimates or forgets limitations';
			}?></td>
	  <td align="center"><?php echo $record['FallAssessment']['mental_status_score'];?></td>                   		  
	</tr>
		
   </table>	
	<div style="height:50px;"></div>
	
	<table width="85%">
		<tr>
			<td align="center"><b>INTERVENTIONS</b></td>
		</tr>
		<tr>
			<td align="center">&nbsp;</td>
		</tr>
		<tr id="tr_low_heading" style="display:none;">
		<th align="center"><b>LOW FALLS RISK  (Universal Falls Precautions)</b></th>
	</tr>
	<tr id="tr_low" style="display:none;">
		<td><b>Maintain safe unit environment </b>
		  <ul>
			<li>Remove excess equipment/supplies/ furniture from rooms & hallways.</li>
			<li>Coil and secure excess electrical and telephone wires/cords.</li>
			<li>Clean all spills in patient room or in hallway immediately. </li>
			<li>Instruct patient to call for help before getting out of bed.</li>
			<li>Patient/Family Education</li>
			<li>Place a signage to indicate wet floor danger.</li>
		 </ul></br>
		 <b>Follow the following safety interventions:</b>
			<ul>
				<li>Orient the patient to surroundings, including bathroom location, use of call light.</li>
				<li>Keep bed in lowest position during use unless impractical (when doing a procedure on a patient)</li>
				<li>Keep the top 2 side rails upSecure locks on beds, stretcher, & wheel chair.</li>
				<li>Keep floors clutter/obstacle free (especially the path between bed and bathroom/commode).</li>
				<li>Place call light & frequently needed objects within patient reach.</li>
				<li>Answer call light promptly.</li>
				<li>Encourage patient/family to call for assistance as needed. </li>
				<li>Assure adequate lightening especially at night.</li>
				<li>Use proper fitting non-skid footwear.</li>
			</ul>
		</td>
	</tr>
	<tr id="tr_medium_heading" style="display:none;">
		<th><font color="#FCC206">MODERATE FALL RISK</font></th>
	</tr>
	<tr id="tr_medium" style="display:none;">
		<td><b>Maintain safe unit environment</b>
		  <ul>
			<li>Remove excess equipment/supplies/ furniture from rooms & hallways.</li>
			<li>Coil and secure excess electrical and telephone wires/cords.</li>
			<li>Clean all spills in patient room or in hallway immediately. </li>
			<li>Instruct patient to call for help before getting out of bed.</li>
			<li>Patient/Family Education</li>
			<li>Place a signage to indicate wet floor danger.</li>
		 </ul></br>
		  <b>Institute flagging system:</b>
			<ol>
				<li>Apply falls risk arm band</li>
				<li>Falling star  (yellow) outside the patient&rsquo;s door</li>
				<li>Falls risk sticker on the medical record.</li>
			</ol></br>
			 <b>Follow low falls risk interventions plus:</b><br>Monitor & assist patient in following daily schedules:
			<ul>
				<li>Supervise/assist bedside sitting, personal hygiene and toileting as appropriate.</li>
				<li>Reorient confused patient as necessary.</li>
				<li>Establish elimination schedule and use of bedside commode if appropriate.</li>
			</ul></br>
			Evaluate need for: </br>
			<ul>
				<li>PT consults if patient has history of falls and /or mobility impairment. </li>
				<li>OT consults.</li>
			</ul>
		</td>
	</tr>
	<tr id="tr_high_heading" style="display:none;">
		<th><font color="#ED3237">HIGH FALL RISK</font></th>
	</tr>
	<tr id="tr_high" style="display:none;">
		<td><b>Maintain safe unit environment</b>
		  <ul>
			<li>Remove excess equipment/supplies/ furniture from rooms & hallways.</li>
			<li>Coil and secure excess electrical and telephone wires/cords.</li>
			<li>Clean all spills in patient room or in hallway immediately. </li>
			<li>Instruct patient to call for help before getting out of bed.</li>
			<li>Patient/Family Education</li>
			<li>Place a signage to indicate wet floor danger.</li>
		 </ul></br>
		 <b>Institute flagging system:</b>
		<ol>
			<li>Apply falls risk arm band</li>
			<li>Falling star  (yellow) outside the patient&rsquo;s door</li>
			<li>Falls risk sticker on the medical record.</li>
		</ol></br>
		<b>Follow "LOW" and "MODERATE" falls risk interventions plus:</b><br>
		<ul>
			<li>Remain with patient while toileting.</li>
			<li>Observe q 60 minutes unless patient is on activated bed or chair alarm.</li>
			<li>When necessary transport throughout hospital with assistance of staff or trained care givers. Consider bedside procedure. </li>
		</ul></br>
		Evaluate need for following measure going from less restrictive to more restrictive:</br>
		<ul>
			<li>Moving patient to room with best visual access to nursing station.</li>
			<li>Activated bed/chair alarm.</li>
			<li>24 hour supervision/sitter/1:1 </li>
			<li>Physical restraint- only with authorized.</li>
			<li>Prescriber order.</li>
		 </ul></br>
	</tr>
	</table>
</body>
	<?php $total = $record['FallAssessment']['total_score'];?>
<!-- Left Part Template Ends here -->
  
<script>
	
		var total = <?php echo $total;?>;
			//alert(total);
		if(total <=24){
			risk_level = 'Low Risk Level';				
			document.getElementById('tr_low_heading').style.display="block";document.getElementById('tr_low').style.display="block";
			document.getElementById('tr_medium_heading').style.display="none";document.getElementById('tr_medium').style.display="none";
			document.getElementById('tr_high_heading').style.display="none";document.getElementById('tr_high').style.display="none";
				
		 } else if(total >= 25  && total <= 44){		
			risk_level = 'Midium Risk Level';	
			document.getElementById('tr_medium_heading').style.display="block";document.getElementById('tr_medium').style.display="block";
			document.getElementById('tr_low_heading').style.display="none";document.getElementById('tr_low').style.display="none";
			document.getElementById('tr_high_heading').style.display="none";document.getElementById('tr_high').style.display="none";
		 } else if(total >=45){
			risk_level = 'Highest Risk Level';
			document.getElementById('tr_high_heading').style.display="block";document.getElementById('tr_high').style.display="block";
			document.getElementById('tr_low_heading').style.display="none";document.getElementById('tr_low').style.display="none";
			document.getElementById('tr_medium_heading').style.display="none";document.getElementById('tr_medium').style.display="none"
		 }
	

</script>

