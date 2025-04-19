<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align='left' class="formFull formFullBorder">




	<?php 
	if(!empty($allergies_data)){
		foreach($allergies_data as $allergies_datas){
			echo "<tr><td width='50%'>".$allergies_datas['NewCropAllergies']['name']."</td></tr>";//echo  "<td align='left'>".$this->Html->image('/img/icons/infobutton.png',array('alt'=>'infoButton','title'=>'Info Button','url'=>array('controller'=>'patients','action' =>'infobutton',$icd_imos['NoteDiagnosis']['diagnoses_name'])))."</td></tr>";

		}
		?>

	<?php }else?>
	<tr>
		<?php 	if(empty($allergies_data)){ ?>
		<td>No data recorded</td>
	</tr>
	<?php }?>
	<tr>
		<td><a href="#" id="allergies" onclick="getAllergies()"> View Allergy details</a>
	
	</tr>
</table>
