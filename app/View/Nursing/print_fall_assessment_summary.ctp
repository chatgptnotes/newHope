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
			<th width="4%">Date</th>			
			<th width="2%">Time</th>
			<th width="6%">Score</th>
			<th width="10%">Risk</th>
		</tr>
	<?php if(!empty($record)){
			$i = 1;
		foreach($record as $data){	
	?><tr>
		  <td align="center"><?php echo $this->DateFormat->formatDate2Local($data['FallAssessment']['date'],Configure::read('date_format'));?> </td>		  
		  <td align="center"><?php echo $data['FallAssessment']['time'];?> </td>
		  <td align="center"><?php echo $data['FallAssessment']['total_score'];?></td>                   		  
			<?php if($data['FallAssessment']['risk_level'] == 'Low Risk Level'){?>
			<td align="center">&nbsp;&nbsp;<font color="#1B1B1B" style="font-weight:bold;"><?php echo $data['FallAssessment']['risk_level'];?></font></td>
			<?php } else if($data['FallAssessment']['risk_level'] == 'Midium Risk Level') {?>
			<td align="center">&nbsp;&nbsp;<font color="#1B1B1B" style="font-weight:bold;"><?php echo $data['FallAssessment']['risk_level'];?></font></td>
			<?php } else { ?>
			<td align="center">&nbsp;&nbsp;<font color="#B01519" style="font-weight:bold;"><?php echo $data['FallAssessment']['risk_level'];?></font></td>
			<?php }  ?>						
		</tr>
	<?php $i++; } } else {?>
		<tr>
			<td colspan="8" align="center">No Record Found </td>
		</tr>
	<?php }?>
   </table>

   <div class="ht5">&nbsp;</div>                   


<div class=" ">
	+ Restraint order is valid only for 24 hours. Must be reviewed daily.<br />
	+ Specific ambulation orders must be given.<br />
	+ Counselling regarding diet and specific family education and training to be given.
</div>
   <!-- Right Part Template ends here -->
   </td>
</table>
<!-- Left Part Template Ends here -->

</div>  
</body>