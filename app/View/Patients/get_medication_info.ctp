<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align='left' class="formFull formFullBorder">


	<?php
	/*if(!empty($localMedicationData)){
		foreach($localMedicationData as $localMedicationDatas){

			$local_medication_name=$localMedicationDatas['PharmacyItem']['name'];
			
			?>
	<?php   echo "<tr><td width='50%'>". $local_medication_name=$localMedicationDatas['PharmacyItem']['name'] ."</td>";
	//echo  "<td align='left'>".$this->Html->image('',array('alt'=>'infoButton','title'=>'Info Button','class'=>'info_button','onClick'=>"javascript:infomedication('$medication_name')"))."</td></tr>";
	echo  "<td align='left' width='25px' height='25' onclick=\"javascript:infomedication('$medication_name')\") class='info_button' alt='Info Button' title='Info Button'></td><td></td></tr>";
					}?>
	
	<?php }*/

	if(!empty($prescription_data)){
					foreach($prescription_data as $prescription_datas){

					$medication_name=$prescription_datas['NewCropPrescription']['description'];
					$drug_id=$prescription_datas['NewCropPrescription']['drug_id'];
				
					?>
	<?php   echo "<tr><td width='50%'>". $prescription_datas['NewCropPrescription']['description'] ."</td>";
	//echo  "<td align='left'>".$this->Html->image('',array('alt'=>'infoButton','title'=>'Info Button','class'=>'info_button','onClick'=>"javascript:infomedication('$medication_name')"))."</td></tr>";
	echo  "<td align='left' width='25px' height='25' drug_id='".$drug_id."' id='".$this->General->clean($medication_name)."' name ='".$medication_name."'  class='info_button infomedication' alt='Info Button' title='Info Button'></td><td></td></tr>";
					}?>
	
	<?php }else{?>
	<tr>

		<td>No data recorded</td>
	</tr>
	<?php }?>
	<tr>
		<td><a href="#" id="pres" onclick="getRxHistory()">View Rx History</a>
		</td>
	</tr>
	<?php 	if(!empty($prescription_data)){ 
		$prescriptionCount = count($prescription_data);
?>
	<tr>
		<td><a href="#" id="pres_det" onclick="getPresDetails(<?php echo $prescriptionCount;?>)">Prescription
				Details</a></td>
	</tr>
	<?php }?>
</table>
<script>
$(document).ready(function () {
	var viewedQr = "<?php echo $medication_flag['Patient']['newmedicationqr_flag'] ?>";
	var noQrCard = "<?php echo noQrCard;?>";
	if(viewedQr == 1){
		$('#qrmedication').addClass("newqr-btn");
	}
	if(noQrCard==1){
		$('#medication-Qr').hide();;
	}	
});
</script>