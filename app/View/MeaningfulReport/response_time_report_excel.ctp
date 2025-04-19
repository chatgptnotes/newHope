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
	  $dateFrom=date("m/d/Y", strtotime($date[0]));
	  $dateTo=date("m/d/Y", strtotime($date[1]));
	 ?>
		<?php echo __('Patient List from '.$dateFrom.' To '.$dateTo, true); ?>
	</h3>
	</div>
<?php 
if(!empty($patientList)){?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center" width=55%
	 style="text-align: center;">
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('Sr No'); ?> </strong></td>
		<td class="table_cell" style="text-align: left"><strong><?php echo __('Patient Name'); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Encounter type'); ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Time of Patient contact with doctor'); ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Contact during office hours'); ?> </strong></td>		
		<td class="table_cell"><strong><?php echo __('Note submission time'); ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Response time'); ?> </strong></td>
		</tr>
<?php 
	$toggle=0;$srno=0;
			foreach($patientList as $key=>$value){
				$srno++;
				if($toggle == 0) {
					echo "<tr class='row_gray'>";
					$toggle = 1;
				}else{
					echo "<tr>";
					$toggle = 0;
				}?>
				<td class="table_cell" width="5%" style="text-align: center;"><?php echo $srno;?></td>
				<td class="table_cell" style="text-align: left"><?php echo $value['Patient']['lookup_name'];?></td>
				<td>
				<?php 
				echo $value['Patient']['mode_communication'];								
				?></td>
				<td class="table_cell" style="text-align: center;"><?php echo $this->DateFormat->formatDate2LocalForReport($value['Patient']['form_received_on'],
						Configure::read('date_format'),true);?></td>				
				<td class="table_cell" style="text-align: center;"><?php echo $contactTime[$value['Patient']['id']]['contact'];?></td>
				
				<td class="table_cell" style="text-align: center;"><?php echo $this->DateFormat->formatDate2LocalForReport($value['Note']['create_time'],
						Configure::read('date_format'),true);?></td>
				<td class="table_cell" style="text-align: center;"><?php $response=$this->DateFormat->dateDiff($value['Patient']['form_received_on'],$value['Note']['create_time']);
				if($response->h<=9)
						$hours='0'.$response->h;
					else
						$hours=$response->h;
					if($response->i<=9)
						$min='0'.$response->i;
						else
							$min=$response->i;
				echo $hours.':'.$min;?></td>
<?php }
}?>
</table>