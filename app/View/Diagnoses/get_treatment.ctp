<style>
.trShow{
background-color:#ccc;

}
.light:hover {
background-color: #F7F6D9;
text-decoration:none;
    color: #000000; 
}
</style>
<?php if(!empty($data)){?>
<table width="100%" class="formFull formFullBorder">
	<tr class="trShow">
		<td colspan="2" align="center"><?php echo __('Chemotherapy')?></td>
		<td colspan="2" align="center"><?php echo __('Radiation Therapy')?></td>
		<td><?php echo __('Patient Receive');?></td>
		<td></td>
	</tr>
	<tr class="trShow">
		<td><?php echo __('Drug Name')?></td>
		<td><?php echo __('First Round Date')?></td>
		<td><?php echo __('Previous Treatment')?></td>
		<td><?php echo __('Treatment center Date Start')?></td>
		<td><?php echo __('Start Date')?></td>
		<td><?php echo __('Karnofsky Score')?> </td>
		
	</tr>
	
	<?php 
	$config = Configure::read('karnofsky_score');
	foreach($data as $subData){ ?>
	<tr class="pointer light" id="otherTreatment_link">
	<?php if($subData['OtherTreatment']['chemotherapy'] != '0'){?>
		<td><?php echo $subData['OtherTreatment']['chemotherapy_drug_name'];?></td>
		<td><?php echo $this->DateFormat->formatDate2Local($subData['OtherTreatment']['first_round_date'],Configure::read('date_format'),false);?></td>
	<?php }else{?>
		<td><?php echo 'No'?></td>
		<td><?php echo 'No'?></td>
	<?php }?>	
	<?php if($subData['OtherTreatment']['radiation_therapy'] != '0'){?>
		<td><?php echo $subData['OtherTreatment']['radiation_previous_treatment'];?></td>
		<td><?php echo $this->DateFormat->formatDate2Local($subData['OtherTreatment']['radiation_start_date'],Configure::read('date_format'),false);?></td>
	<?php }else{?>
		<td><?php echo 'No'?></td>
		<td><?php echo 'No'?></td>
	<?php }?>	
	<?php if($subData['OtherTreatment']['receive_chemotherapy_concurrently'] != '0'){?>
		<td><?php echo $this->DateFormat->formatDate2Local($subData['OtherTreatment']['receive_chemotherapy_date'],Configure::read('date_format'),false);?></td>
	<?php }else{?>	
	<td><?php echo "No";?></td>
	<?php }?>
	<?php if($config[$subData['OtherTreatment']['karnofsky_score']] == 'Please Select'){
			$karnofsky_score = '';
		}else{
			$karnofsky_score = $config[$subData['OtherTreatment']['karnofsky_score']];
		} ?>
	<td><?php echo $karnofsky_score;?></td>
	</tr>
	<?php }?>
</table>
<?php }else{?>
<table>
	<tr>
		<td><span style="color: grey; font-size: 13px;"><?php echo __('No Record Found')?> 
		
		</td>
	</tr>
</table>
<?php }?>
<script>
$('#otherTreatment_link').click(function(){
	$.fancybox({
		'width' : '100%',
		'height' : '40%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			getTreatment();
			getMedicationHistory();
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "otherTreatment",$patientId/* ,$subData['OtherTreatment']['id'] */)); ?>",
		
	});
});
</script>