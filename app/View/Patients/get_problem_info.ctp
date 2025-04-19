<table width="50%" cellpadding="0" cellspacing="0" border="0"
	align='left' class="formFull formFullBorder">
	<?php if(!empty($icd_imo)){
		foreach($icd_imo as $icd_imos){
			$name=$icd_imos['NoteDiagnosis']['diagnoses_name'];
			$id=$icd_imos['NoteDiagnosis']['patient_id'];
			echo "<tr><td width='50%'>".$icd_imos['NoteDiagnosis']['diagnoses_name']."</td>";
			//echo "<td width='20px' >".$this->Html->image('/img/icons/infobutton.png',array('alt'=>'infoButton','title'=>'Info Button','onClick'=>"javascript:icdwin('$name','$id')")) ."</td>";
			echo  "<td align='left' width='25px' height='25' onclick=\"javascript:icdwin('$name','$id')\" class='info_button' alt='Info Button' title='Info Button' valign='middle'></td>";
			echo "<td align='left' style='padding-left:5px'>".$this->Html->link($this->Html->image('/img/icons/Leaflet_1.png'), 'http://online.lexi.com/lco/action/pcm', array('target' => '_blank','escape'=>false,'alt'=>'leaflet','title'=>'leaflet','valign'=>'top')) ."</td></tr>";
		}
			
		?>
	<?php }else{?>
	<tr>
		<td><?php echo __("No data recorded");?></td>
	</tr>
	<?php }?>
	<tr>
		<td><a href="#" id="dxhistory" onclick="getDxHistory()"><?php echo __("View Dx History");?></a>
		</td>
	</tr>
</table>
