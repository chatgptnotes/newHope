<?php header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Discharge_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description:Raymond_Report" );
ob_clean();
flush();
?>


 <style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}

.top-header {
	background: #3e474a;
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea {
	width: 100px;
	padding: 0;
}

.inner_title span{ margin:-26px 0px;}
#inner_menu img{ float:none !important;}
div{ font-size:13px;}

</style>


<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="1">
	<tr > 
		   <td colspan="16" width="100%" height='30px' align='center' valign='middle'>
		   		<h2><?php echo __('Discharge Summary Patient Report'); ?></h2>
		   </td>
	 </tr>
	<tr>
		<th width="5px" valign="top" align="center" style="text-align:center;">Sr No</th>
		
		<th width="72px" valign="top" align="center"
			style="text-align: center;">PATIENT NAME</th>
		<th width="50px" valign="top" align="center"
			style="text-align: center;">COMPANY NAME</th>	
		<th width="50px" valign="top" align="center"
			style="text-align: center;">ADMISSION DATE</th>
		<th width="50px" valign="top" align="center"
			style="text-align: center;">DISCHARGE DATE</th>
		<th width="50px" valign="top" align="center"
			style="text-align: center;">STATUS</th>
	</tr>
	<tbody>
		<?php
			 $status_update = array(
			 		'0'=>'On Bed',
			 		'1'=>'Discharged and Payment Pending',
			 		'2'=>'Discharged and Payment Recevied',
			 		'3'=>'Discharged but bill not made',
			 		'4'=>'Discharged and bill made but file not submitted ',
			 		'5'=>'File Submitted',
					'6'=>'Discharged but bill not Open',
					'7'=>'File Pending for submission(RGJAY)',
					'8'=>'Preauth Approved',
					'9'=>'Preauth Pending',
					'10'=>'Surgery Update',
					'11'=>'Discharge Update',
					'12'=>'Claim Doctor Pending',
					'13'=>'Claim Doctor Pending Updated',
					'14'=>'Bill Submitted');
			$i=0;
			foreach($results as $result)
	     	{
		     	$bill_id = $result['FinalBilling']['id'];
		     	$patient_id = $result['Patient']['id'];
		     	$i++;
	    ?>
	<tr>
		<td width="8px" valign="top" align="center" style="text-align:center;">
    		<?php echo $i;?>
    	</td>
    	
		<td width="50px" align="center">
			<?php echo $result['Patient']['lookup_name']; ?>
		</td>
		<td width="65px" align="center">
			<?php echo $result['TariffStandard']['name']; ?>
		</td>
		<td width="65px" align="center">
			<?php echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); ?>
		</td>
	
		<td width="65px" align="center">
			<?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); ?>
		</td>
	
		<td width="77px" align="center" style="text-align: center;">
			 <?php 
				echo $result['Patient']['discharge_status'];
				//echo $status_update[$result['Patient']['discharge_status']];
			?>
		</td>

	</tr>
	<?php } ?>
</tbody>
</table>

