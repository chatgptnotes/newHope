<?php // Get the current date
$admisionDate = $patient['Patient']['form_received_on'];

// Calculate the date 2 days from the current date
$endDate =  $admisionDate;
$endDate = strtotime("+2 days", strtotime($endDate));
$endDate = date('Y-m-d H:i:s',$endDate);

?>

<?php if($patient['Patient']['tariff_standard_id'] != 7 && strtotime($endDate) > strtotime(date('Y-m-d H:i:s'))){ ?>
<!--<div align="Center" class="titlle" style="color: red;"><u><?php echo "Attention: This patient is not scheduled for surgery until two days post-admission. All necessary paperwork must be completed during this period. Thank you for your cooperation" ;?></u></div>-->
<?php } ?>
 <tr>
 	<div align="Center" class="titlle"><u><?php echo __('Admission Notes');?></u></div>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("Complaint :")?></td>
			<?php if(isset($diagnosisData['Diagnosis']['complaints'])){?>	
			<td>
				<?php echo $diagnosisData['Diagnosis']['complaints'];?>
			</td>
			<?php }else{?>
			<td class="borderBottom"></td>
			<?php }?>
		</tr>
		<tr>
				<td>&nbsp;</td>
				<td></td>
		</tr>
		<tr>
			<td></td>
			<td class="borderBottom"></td>
		</tr>
		<tr>
				<td>&nbsp;</td>
				<td></td>
		</tr>
		<tr>
			<td></td>
			<td class="borderBottom"></td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("History Of Present Illness :")?></td>
			<?php if(isset($Notedata['Note']['subject'])){?>	
			<td>
				<?php echo $Notedata['Note']['subject'];?>
			</td>
			<?php }else{?>
			<td class="borderBottom"></td>
			<?php }?>
		</tr>
		<tr>
				<td>&nbsp;</td>
				<td></td>
		</tr>
		<tr>
			<td></td>
			<td class="borderBottom"></td>
		</tr>
		<tr>
				<td>&nbsp;</td>
				<td></td>
		</tr>
		<tr>
			<td></td>
			<td class="borderBottom"></td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("Past Illness :")?></td>
			<td class="borderBottom"></td>
		</tr>
		<tr>
				<td>&nbsp;</td>
				<td></td>
		</tr>
		<tr>
			<td></td>
			<td class="borderBottom"></td>
		</tr>
		<tr>
				<td>&nbsp;</td>
				<td></td>
		</tr>
		<tr>
			<td></td>
			<td class="borderBottom"></td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("Personal History/Habits :")?></td>
			<td class="borderBottom"></td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("Occupation History & Family History:")?></td>
			<?php if(isset($diagnosisData['Diagnosis']['family_tit_bit'])){?>	
			<td>
				<?php echo $diagnosisData['Diagnosis']['family_tit_bit'];?>
			</td>
			<?php }else{?>
			<td class="borderBottom"></td>
			<?php }?>
		</tr>
	</table>
	</td>
</tr>

<tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("Clinical Examination :")?></td>
			<?php if(isset($Notedata['Note']['object'])){?>	
			<td>
				<?php echo $Notedata['Note']['object'];?>
			</td>
			<?php }else{?>
			<td class="borderBottom"></td>
			<?php }?>
		</tr>
		<tr>
				<td>&nbsp;</td>
				<td></td>
		</tr>
		<tr>
			<td></td>
			<td class="borderBottom"></td>
		</tr>
		<tr>
				<td>&nbsp;</td>
				<td></td>
		</tr>
		<tr>
			<td></td>
			<td class="borderBottom"></td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("Investigation :")?></td>

			<?php if(isset($Notedata['Note']['ros'])){?>	
			<td>
				<?php echo $Notedata['Note']['ros'];?>
			</td>
			<?php }else{?>
			<td class="borderBottom"></td>
			<?php }?>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("Provisional Diagnosis :")?></td>
			<?php if(isset($diagnosisData['Diagnosis']['final_diagnosis'])){?>	
			<td>
				<?php echo $diagnosisData['Diagnosis']['final_diagnosis'];?>
			</td>
			<?php }else{?>
			<td class="borderBottom"></td>
			<?php }?>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("Surgery Plans :")?></td>
			<td class="borderBottom"></td>
			<td style="font-weight: bold;" width="25%"><?php echo __("Date & Time :")?></td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"></td>
			<td style="font-weight: bold;" width="41%"><?php echo __("Doctor Name :")?></td>
			<td style="font-weight: bold;" width=" "><?php echo __("Doctor Signature :")?></td>
		</tr>
	</table>
	</td>
</tr>

<!--  <tr>
	<td>
	<table width="100%" border="0">
		<tr>
			<td width="25%"><?php echo __("Date :")?></td>
		</tr>
	</table>
	</td>
</tr>-->


