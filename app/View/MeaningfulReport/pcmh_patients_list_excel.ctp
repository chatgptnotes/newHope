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
<?php
	  $dateFrom=date("m/d/Y", strtotime($date[0]));
	  $dateTo=date("m/d/Y", strtotime($date[1]));
	 ?>
<h3><?php echo __('PCMH Patient List For ').$provider['DoctorProfile']['doctor_name'].' From '.$dateFrom.' To '.$dateTo; ?></h3>
</div>
	<table width="40%" align="center" class="formFull" cellpadding="0" cellspacing="0">
		<?php
		if(!empty($denominatorVal)){
			echo "<tr class='row_gray'>
				<th  width='2%'>Sr.no</th>
				<th  width='10%' style='text-align: left;'>Patient MRN</th>
				<th  width='15%' style='text-align: left;'>Patient Name</th>
	  			<!--<th class='tdLabel'>Mobile No.</th>
				<th class='tdLabel'>City</th>
				<th class='tdLabel'>Email</th>-->
				</tr>	";
				$toggle=0;$sr=1;
				foreach($denominatorVal as $data){
					if($toggle == 0) {
					echo "<tr>";
					$toggle = 1;
					}else{
					echo "<tr class='row_gray'>";
					$toggle = 0;
					}
					?>
					<td style="text-align: center;"><?php echo $sr;?></td>
					<td ><?php echo $data['Patient']['patient_id'];?></td>
					<td ><?php echo $data['Patient']['lookup_name']?></td>
					<!--  <td class='tdLabel'><?php echo $data['Person']['person_local_number']?></td>
					<td class='tdLabel'><?php echo $data['Patient']['city']?></td>
					<td class='tdLabel'><?php echo $data['Person']['person_email_address']?></td> -->
					</tr>
				

		<?php $sr++; } }//end of if	?>
	</table>