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
	<h3>
		&nbsp;
		  <?php
	//  $dateFrom=date("m/d/Y", strtotime($date[0]));
	 // $dateTo=date("m/d/Y", strtotime($date[1]));
	 ?>
		<?php echo __('Patient List', true); ?>
	</h3>
	</div>
	<table width="53%" align="center" class="formFull" cellpadding="0" cellspacing="0" border="1">
		<?php
		if(!empty($patientList)){
			echo "<tr class='row_gray'>
				<th  width='15%' style='text-align: left;'>Patient Name</th>
				<th  width='15%' style='text-align: left;'>Status</th>
				<th  width='10%' style='text-align: left;'>Appointment Date</th>				
	  			</tr>	";
				$toggle=0;$sr=1;
				foreach($patientList as $data){
					if($toggle == 0) {
					echo "<tr>";
					$toggle = 1;
					}else{
					echo "<tr class='row_gray'>";
					$toggle = 0;
					}
					?>
					<td class="table_cell"  style="text-align: left"><?php echo $data['Patient']['lookup_name'];?></td>
				<td >
				<?php 
					echo 'No-Show';				
				?></td>
				<td ><?php echo $this->DateFormat->formatDate2Local($data['Appointment']['date'],
						Configure::read('date_format'),true);?></td>									
					</tr>
				

		<?php $sr++; } }//end of if	?>
	</table>
	