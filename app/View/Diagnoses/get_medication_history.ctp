<?php echo $this->Html->css(array('tooltipster.css'));
	echo $this->Html->script(array('jquery.tooltipster.min.js'));
?>
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
		<td style="padding:5px 0 5px 10px;">Drug Name</td>
		<td style="padding:5px 0 5px 10px;">Dose</td>
		<td style="padding:5px 5px 5px 5pxpx;">Route</td>
		<td style="padding:5px 5px 5px 5px;">Frequency</td>
		<td style="padding:5px 0 5px 10px;">Start Date</td>
	<!-- <td style="padding:5px 0 5px 10px;">Stop Date</td>-->
	</tr>
	<?php $dose = Configure :: read('dose_type');
		  $route = Configure :: read('route_administration');
		  $freq_fullform=Configure :: read('frequency');
		  ?>
	<?php foreach($data as $subData){?>
	<?php 
	$toolTip = 
	//'<b>Description:</b> '.ucwords(stripslashes($newCropPrescription['NewCropPrescription']['description'])).$vax.'</br>
	'<b>Drug Name:</b> '.ucwords(stripslashes($subData['NewCropPrescription']['description'])).'</br>
					  <b>Dose:</b> '.$dose[$subData['NewCropPrescription']['dose']].'</br>
					  <b>Route:</b> '.$route[$subData['NewCropPrescription']['route']].'</br>
					  <b>Frequency:</b> '.$freq_fullform[$subData['NewCropPrescription']['frequency']].'</br>
					  <b>Start Date:</b> '.$this->DateFormat->formatDate2Local($subData['NewCropPrescription']['firstdose'],Configure::read('date_format'),true).'</br>
					 <b> Stop Date:</b> '.$this->DateFormat->formatDate2Local($subData['NewCropPrescription']['stopdose'],Configure::read('date_format'),true).'</br>
					  <b>Last Dose Taken:</b> '.$this->DateFormat->formatDate2Local($subData['NewCropPrescription']['last_dose'],Configure::read('date_format'),false).'</br>';
	$toolTips = addslashes(htmlspecialchars($toolTip, ENT_QUOTES));
	?>
	<tr class="tooltip light" title="<?php echo $toolTips?>">
		<td style="padding:0 0 0 10px;"><?php  echo $this->Html->link(ucwords(stripslashes($subData['NewCropPrescription']['description'])),array('controller'=>'Diagnoses','action'=>'medicationHistory',$subData['NewCropPrescription']['patient_uniqueid'],$subData['NewCropPrescription']['id'],$subData['NewCropPrescription']['patient_id'],'null','null',$appointmentID,'?'=>array('appt_id'=>$appointmentID,'patientId'=>$patientId)),array('alt'=>'Edit','title'=>'Edit'));?></td>
		<td style="padding:0 5px 0 5px;"><?php echo $dose[$subData['NewCropPrescription']['dose']];?></td>
		<td style="padding:0 5px 0 5px;"><?php echo $route[$subData['NewCropPrescription']['route']];?></td>
		<td style="padding:0 5px 0 5px;"><?php echo  $freq_fullform[$subData['NewCropPrescription']['frequency']];?></td>
		<td style="padding:0 5px 0 5px;"><?php echo $this->DateFormat->formatDate2Local($subData['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);?></td>
	<!--<td style="padding:0 5px 0 5px;"><?php //echo $this->DateFormat->formatDate2Local($subData['NewCropPrescription']['stopdose'],Configure::read('date_format'),true);?></td> -->
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
$(document).ready(function(){
	$('.tooltip').tooltipster({
 		interactive:true,
 		position:"right",
 	});
}); 

		  /*
function editMedications(ID,PUID){
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
			getMedicationHistory();
			getmedication()
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "medicationHistory",$subData['NewCropPrescription']['patient_uniqueid'])); ?>"+"/"+ID+"/"+PUID+"/",
				
		
	});
}*/
</script>