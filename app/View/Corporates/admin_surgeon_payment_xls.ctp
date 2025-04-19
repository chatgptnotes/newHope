<?php header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"surgeon_payment_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description:Surgeon_Report" );
ob_clean();
flush();
?>
<div>
	<h3 style="float:left;" align="center">Surgeon Payment Report</h3>
		<div style="float:right;"> 
</div>		      
<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="2" border="1" class="tabularForm labTable resizable sticky" id="item-row"
	style="top:0px;overflow: scroll;">
	  <tr>
	  	<thead>
	  		<th valign="top" align="center" style="text-align:center;">#</th>
			<th valign="top" align="center" style="text-align:center;">Date of surgery</th>
			<th valign="top" align="center" style="text-align:center;">Patient Name</th>
			<th valign="top" align="center" style="text-align:center;">Surgeon</th>
			<th valign="top" align="center" style="text-align:center;">Anaesthetist</th>
			<th valign="top" align="center" style="text-align:center;">Surgery name</th>
			<th valign="top" align="center" style="text-align:center;">surgeon fees as per tariff</th>
			<th valign="top" align="center" style="text-align:center;">Surgeon to be paid</th>	
			<th valign="top" align="center" style="text-align:center;">Anaesthetist as per tariff</th>
			<th valign="top" align="center" style="text-align:center;">Anaesthetist to be paid</th>
			<!--<th valign="top" align="center" style="text-align:center;">Implant? as per tariff</th>
			<th valign="top" align="center" style="text-align:center;">Implant charges to be paid</th>
			<th valign="top" align="center" style="text-align:center;">Authorised</th> -->
   		</thead>
      </tr>                             	
			<?php
				$i=0;$val = 0;
		foreach($data as $ot)
		{
			$i++;
			$patient_id = $ot['Patient']['id'];
			$opt_id =$ot['OptAppointment']['id'];
						//holds the id of patient
			 $total = $ot['OptAppointment']['surgeon_amt'];
       $val = $val + $total;
       $total1 = $ot['OptAppointment']['cost_to_hospital'];
       $val1 = $val1 + $total1;
       
         $total2 = $ot['OptAppointment']['anaesthesist_amt'];
       $val2 = $val2 + $total2;
       
         $total3 = $ot['OptAppointment']['anaesthesia_cost'];
       $val3 = $val3 + $total3;			
			?>
	 <tr>
		<td width="21px"  align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
    		<td align="center">	
    			<?php $surDate= $this->DateFormat->formatDate2Local($ot['OptAppointment']['schedule_date'],Configure::read('date_format'), true);
						echo $surDate ?>
			</td>
			<td  align="center" style="text-align:center;">
				<?php  
				  	echo $ot['Patient']['lookup_name'];  ?>
	     	</td>
			<td>  
			<?php $doctorId = 'doctor_'.$ot['OptAppointment']['id']; 
		      		 echo $ot['DoctorProfile']['doctor_name'];
					?>  
			</td>
			<td>
				<?php echo $ot[0]['name']; ?>
			</td>
		 	
			<td align="center">
					 <?php echo $ot['Surgery']['name']; ?>
			</td>
			
			<td align="center">
				 <?php echo $ot['OptAppointment']['surgeon_amt']; ?>
			</td>
			
			<td align="center">
				<?php echo $ot['OptAppointment']['cost_to_hospital']; ?>
			</td>
			 <td align="center">
				<?php echo $ot['OptAppointment']['anaesthesist_amt']; ?>
			</td>
			<td align="center">
				<?php echo $ot['OptAppointment']['anaesthesia_cost']; ?>
			</td>
			
		</tr>
		<?php } ?>
				<tr> 
	<td  align="center"style="text-align: center;font-weight:bold;"colspan="6">Actual  Amount Receivable </td>			
	<td   align="center"style="text-align: center; font-weight: bold;">
		<?php echo $val ?></td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  echo $val1?>	</td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  echo $val2?>	</td>	
    <td  align="center"style="text-align: center;font-weight:bold;"colspan="">
		<?php  echo $val3?>	</td>
	</tr>
	</table> 
</div>
	</table> 
</div>

<!--******************************************* table closed *******************************************************-->                    
                     
 