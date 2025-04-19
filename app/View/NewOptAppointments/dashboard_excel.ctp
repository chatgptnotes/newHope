<?php 
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"OR_Dashboard_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Expiry Report" );
ob_clean();
flush();
?>
<?php if(!empty($data)){  ?>
<table valign="top" border="1" class="table_format"  cellpadding="2" cellspacing="0" width="40%" style="text-align:left;vertical-align:top;margin-top:-30px;">
		<tr>
				<td colspan = "5" align="center"><h2><strong>OR Dashboard Report</strong></h2></td>
				<td align="left" colspan ="3" ><strong>Print Date & Time : <?php echo $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true);?></strong></td>
		</tr>
		
		<tr>
				<td colspan = "8" align="center"><strong><?php 
			if(!empty($this->request->data['dateFrom'])){
			echo " From ".$this->request->data['dateFrom'];
			} ?></strong> 
			<?php if(!empty($this->request->data['dateTo'])){?>
			to <strong><?php echo $this->request->data['dateTo'];
			}?></strong></td>			
		</tr>
		<tr class="row_title">
			<th width="2%" valign="top" class="table_cell">Sr.No.</th>
			<th width="6%" valign="top" class="table_cell">Patient</th>
			<th width="5%" valign="top" class="table_cell">Patient ID</th>
			<th width="5%" valign="top" class="table_cell">Surgery</th>
			<th width="3%" valign="top" class="table_cell">Preference Card/<br/>Surgical Implant</th>
			<th width="5%" valign="top" class="table_cell">Anaesthetist / <br/>Surgeon</th>			
			<th width="5%" valign="top" class="table_cell">Room <br/>Table</th>		
			<th width="5%" valign="top" class="table_cell">Date Of Surgery <br/>In time <br/> Out time</th>		
			<th width="5%" valign="top" class="table_cell">Actual Date Of Surgery <br/>In time <br/> Out time</th>					
		</tr>
		<?php 
		$toggle =0;
		$i=0 ;
		$role  = $this->Session->read('role');
		foreach($data as $ot){
			$currentAppointment =  strtotime($this->DateFormat->formatDate2Local($ot['OptAppointment']['starttime'],Configure::read('date_format'), false));
			
			if($currentAppointment == strtotime(date('Y-m-d')) && $futureApp){
				return false;
			}
			   $i++;
			   if($toggle == 0) {
			       	echo "<tr class='row_gray'>";
			       	$toggle = 1;
		       }else{
			       	echo "<tr class='row_gray_dark'>";
			       	$toggle = 0;
		       }
		   
	?>

<td valign="top"><?php   echo $i;?>
</td>
<td valign="top"><?php   echo $ot['Patient']['lookup_name']."<br /> (".$ot['TariffStandard']['name'].")";?>
</td>
 <td valign="top"><?php echo $ot['Patient']['patient_id'];?>
 </td>
		<td style="text-align: left;" valign="top"><?php 
		
		
		if($ot['Surgery']['name']=='Dummy'){
				echo ($ot['OptAppointment']['dummy_surgery_name'])."<br/>";
		}else{	
				unset($surgeryNameArr);
				$surgeryNameArr=array();
               foreach ($ot['Surgery'] as $surgeryKey=>$surgeryVal){
				   $surgeryNameArr[]=$surgeryVal['name'];
				//echo ($surgeryVal['name'])."<br/>";
				}
				$surgeryNameArr=array_filter($surgeryNameArr);
				echo implode(",\n",$surgeryNameArr);
		}?>
		</td>
		<td style="text-align: left;" valign="top">
		<?php if(!empty($ot['SurgicalImplant'])){
				unset($implantNameArr);
				$implantNameArr=array();
	               	foreach ($ot['SurgicalImplant'] as $implantKey=>$implantVal){
					   $implantNameArr[]=$implantVal['name'];				
					}
				$implantNameArr=array_filter($implantNameArr);				
				echo $ot['Preferencecard']['card_title']."/".implode(",\n",$implantNameArr);				
			 }else{
				echo $ot['Preferencecard']['card_title'];
			 }		
		?>
		</td>
		
		<td valign="middle" style="text-align: left;" valign="top">
					<?php
		unset($surgeryArr);
		$surgeryArr=array();
		foreach ($ot['DoctorProfile'] as $surgeonKey=>$surgeonVal){			
			$getDoctorNameFirstLast=explode(" ",$surgeonVal['doctor_name']);
			$getDoctorNameFirstLast=array_filter($getDoctorNameFirstLast);
			$getDoctorNameFirstLast=array_values($getDoctorNameFirstLast);		
			$surgeryArr[]=$getDoctorNameFirstLast[0]." ".$getDoctorNameFirstLast[1];
		}
		
		$surgeryArr=array_filter($surgeryArr);
		echo implode(",\n",$surgeryArr);
		?>
		</td>
		<td style="text-align: left;" valign="top"><?php echo ucfirst($ot['Opt']['name'])." ".$ot['OptTable']['name']; ?>
		</td>
		
		
		<?php $surDate= $this->DateFormat->formatDate2Local($ot['OptAppointment']['schedule_date'],Configure::read('date_format'), true);
		
		?>
		
		
		<?php $inTime = ($ot['OptAppointment']['ot_in_date']) ? $ot['OptAppointment']['ot_in_date'] : $ot['OptAppointment']['starttime'];?>
		<?php $startDate= explode(" ",$this->DateFormat->formatDate2Local($inTime,Configure::read('date_format'), true));
		?>
		
		<?php $outTime = ($ot['OptAppointment']['out_date']) ? $ot['OptAppointment']['out_date'] : $ot['OptAppointment']['endtime'];?>
		<?php $endDate= explode(" ",$this->DateFormat->formatDate2Local($outTime,Configure::read('date_format'), true));
		?>
		
		<?php $optAppointmentId=$ot['OptAppointment']['id'];
			$optAppointmentPatientId=$ot['OptAppointment']['patient_id'];
		?>
		<td style="text-align: left;" valign="top"><?php  echo $surDate." ".date("H:i", strtotime($startDate['1']))." ".date("H:i", strtotime($endDate['1'])); ?>
		</td>
		<td style="text-align: left;" valign="top">
		</td>
		
		</tr>
		<?php 	 } ?>
		
	</table>
	<?php }  ?>
