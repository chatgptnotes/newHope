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
		  <?php	echo __('Hospital readmissions within 30 days Report', true);
		  ?>
	</h3>
	</div>
	<table width="53%" align="center" class="formFull" cellpadding="0" cellspacing="0">
		<?php
		if(!empty($patientList)){
			echo "<tr class='row_gray'>
				<th  width='10%' style='text-align: left;'>Patient Name</th>
				<th  width='15%' style='text-align: left;'>Patient Visit ID</th>
	  			<th class='tdLabel'>Date Of Birth</th>				
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
					<td class="table_cell" width="20%" style="text-align: left"><?php echo $data['Patient']['lookup_name'];?></td>
				<td width="40%">
				<?php 
				echo $data['Patient']['patient_id'];				
				?></td>
				<td width="20%" style="text-align: center;"><?php echo $this->DateFormat->formatDate2Local($data['Person']['dob'],
						Configure::read('date_format'),true);?></td>				
					</tr>
				

		<?php $sr++; } }//end of if	?>
	</table>
	