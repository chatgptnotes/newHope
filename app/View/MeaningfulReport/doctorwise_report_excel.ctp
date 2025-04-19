<?php
	header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT"); 
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=\"PCMH IT Checklist - ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
	header ("Content-Description: Generated Report" ); 
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	ob_clean();
	flush();
?>
<STYLE type="text/css">
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE>
<div class="inner_title">
<h3><font style="color:#000">
<?php if(!empty($date)){	
		 echo __('Percentage of Patients Seen by Physician Report From '.date('m/d/Y',strtotime($date[0])).' To '.date('m/d/Y',strtotime($date[1])), true);}
 	  else{
		echo __('Percentage of Patients Seen by Physician Report-'.date('Y'), true);
	  }?> </font></h3></div>
	<table width="500px">
	<tr>
	<td><b>Physician Name</b></td>
	<td><b>No.of Patients</b></td>
	<td><b>Percentage</b></td>
	</tr>
	<?php 
     foreach($pieData as $data){
			
		echo '<tr><td>'.$data['name'].'</td>
		<td style="text-align:center;">'.$data['count'].'</td>';?>
		<?php $physicianCalculation = ($data['count']/$totalPatient[0][0]['count'])*100;
               echo '<td style="text-align:center;">'.$this->Number->toPercentage($physicianCalculation).'</td>
		</tr>';
		
	 }
     ?> 
	<tr>
	<td ><?php echo '<b>Total no.of Patients Arrived At Clinic</b>'?></td>
	<td style="text-align:center;"><b><?php echo $totalPatient[0][0]['count'];?></b></td></tr>
	</table>
 