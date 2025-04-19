<div id="printButton">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<body class="print_form" onload="window.print();">
	<?php 
		echo $this->element('patient_header') ;
	?>
	<div class="ht5"></div>
<table width="100%" cellpadding="3" cellspacing="0" border="1" class="">
	<tr>
		<th width="5%">Date</th>
		<th width="5%">Time</th>
		<th width="5%">Score</th>
		<th width="12%">Risk</th>
	</tr>
	<tr>
	  <td align="center"><?php echo $this->DateFormat->formatDate2Local($PreviousEntry['FallAssessment']['date'],Configure::read('date_format'));?></td>		  
	  <td align="center"><?php echo $PreviousEntry['FallAssessment']['time'];?></td>
	  <td align="center"><?php echo $PreviousEntry['FallAssessment']['total_score'];?></td>                   		  
		<?php if($PreviousEntry['FallAssessment']['risk_level'] == 'Low Risk Level'){?>
		<td align="left">&nbsp;&nbsp;<font color="#1B1B1B" style="font-weight:bold;"><?php echo $PreviousEntry['FallAssessment']['risk_level'];?></font></td>
		<?php } else if($PreviousEntry['FallAssessment']['risk_level'] == 'Medium Risk Level') {?>
		<td align="left">&nbsp;&nbsp;<font color="#FABF00" style="font-weight:bold;"><?php echo $PreviousEntry['FallAssessment']['risk_level'];?></font></td>
		<?php } else { ?>
		<td align="left">&nbsp;&nbsp;<font color="#B01519" style="font-weight:bold;"><?php echo $PreviousEntry['FallAssessment']['risk_level'];?></font></td>
		<?php }?>		 
	</tr>
</table>
  <div class="ht5">&nbsp;</div>
<table width="85%" style="padding-left:20px;">
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
		 </ul>
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
		<th><font color="#FFD63A">MODERATE FALL RISK</font></th>
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
			</ol>
			 <b>Follow "Low Falls" risk interventions plus:</b><br>Monitor & assist patient in following daily schedules:
			<ul>
				<li>Supervise/assist bedside sitting, personal hygiene and toileting as appropriate.</li>
				<li>Reorient confused patient as necessary.</li>
				<li>Establish elimination schedule and use of bedside commode if appropriate.</li>
			</ul>
			Evaluate need for: </br>
			<ul>
				<li>PT consults if patient has history of falls and /or mobility impairment. </li>
				<li>OT consults.</li>
			</ul>
		</td>
	</tr>
	<tr id="tr_high_heading" style="display:none;">
		<th><font color="#F4252D">HIGH FALL RISK</font></th>
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
		 </ul>
		 <b>Institute flagging system:</b>
		<ol>
			<li>Apply falls risk arm band</li>
			<li>Falling star  (yellow) outside the patient&rsquo;s door</li>
			<li>Falls risk sticker on the medical record.</li>
		</ol>
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
		 </ul>
	</tr>
</table>
<hr/>

<table width="85%" style="padding-left:20px;">
	<tr id="tr_low_heading_small" style="display:none; font-size:13px;color:#FFFFFF;">
		<th align="center"><b>LOW FALLS RISK  (Universal Falls Precautions)</b></th>
	</tr>
	<tr id="tr_low_small" style="display:none;font-size:12px;">
		<td><b>Maintain safe unit environment </b>
		  <ul>
			<li>Remove excess equipment/supplies/ furniture from rooms & hallways.</li>
			<li>Coil and secure excess electrical and telephone wires/cords.</li>
			<li>Clean all spills in patient room or in hallway immediately. </li>
			<li>Instruct patient to call for help before getting out of bed.</li>
			<li>Patient/Family Education</li>
			<li>Place a signage to indicate wet floor danger.</li>
		 </ul>
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
	<tr id="tr_medium_heading_small" style="display:none; font-size:13px;">
		<th><font color="#FCC206">MODERATE FALL RISK</font></th>
	</tr>
	<tr id="tr_medium_small" style="display:none;font-size:12px;">
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
			</ol>
			<br>Monitor & assist patient in following daily schedules:
			<ul>
				<li>Supervise/assist bedside sitting, personal hygiene and toileting as appropriate.</li>
				<li>Reorient confused patient as necessary.</li>
				<li>Establish elimination schedule and use of bedside commode if appropriate.</li>
			</ul>
			Evaluate need for: </br>
			<ul>
				<li>PT consults if patient has history of falls and /or mobility impairment. </li>
				<li>OT consults.</li>
			</ul>
		</td>
	</tr>
</table>
</body>
<script>
	var risk_level = <?php echo json_encode($risk_level); ?>;
		
		if(risk_level == 'Low Risk Level'){			
			// intereventions as per risklevel
			    document.getElementById('tr_low_heading').style.display="block";document.getElementById('tr_low').style.display="block";
					
			} else if(risk_level == 'Medium Risk Level'){
				document.getElementById('tr_medium_heading').style.display="block";document.getElementById('tr_medium').style.display="block";
				document.getElementById('tr_low_heading_small').style.display="block";document.getElementById('tr_low_small').style.display="block";
				
			 } else if(risk_level == 'Highest Risk Level'){				
				document.getElementById('tr_high_heading').style.display="block";document.getElementById('tr_high').style.display="block";
				document.getElementById('tr_medium_heading_small').style.display="block";document.getElementById('tr_medium_small').style.display="block";
				document.getElementById('tr_low_heading_small').style.display="block";document.getElementById('tr_low_small').style.display="block";
				
			 }

</script>