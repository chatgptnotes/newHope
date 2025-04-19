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
		<?php  echo __('Patient Communications List', true); ?>
	</h3>
	</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center" width=55%
	 style="text-align: center;">
	<tr class="row_title">
		<td class="table_cell" style="text-align: center;"><strong><?php echo __('Sr No'); ?> </strong></td>
		<td class="table_cell" style="text-align: left"><strong><?php echo __('Patient Name'); ?>
		</strong></td>
		<td class="table_cell" style="text-align: center;"><strong><?php echo __('Date'); ?> </strong></td>
		<td>&nbsp;</td>
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
				<td class="table_cell" width="20%" style="text-align: left"><?php echo $value;?></td>
				<td width="40%" style="text-align: center;"><?php echo $this->DateFormat->formatDate2Local($key,
						Configure::read('date_format'),true);?></td>
				<td width="20%">&nbsp;</td>
<?php }
?>
</table>
