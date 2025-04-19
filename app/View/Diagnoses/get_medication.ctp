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

 
 <?php 
			echo $this->Form->create('User', array('type' => 'post','url' => 'https://secure.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
			<tr>
				<td colspan="8" style="display: none"><textarea id="RxInput"
						name="RxInput" rows="33" cols="79" align="center" style="display:none">
						<?php echo $patient_xml?>
					</textarea></td>
			</tr>
			<tr><td align="center" style="display: none"><iframe name="aframe" id="aframe" frameborder="0" style="display: none"></iframe></td></tr>
<?php echo $this->Form->end();?> 
<?php echo $this->Form->hidden('noMedCheck',array('id'=>'noMedCheck','value'=>$getcheck['Diagnosis']['no_med_flag'])) ;?>
<?php if(!empty($data)){
echo $this->Form->hidden('noMeddisable',array('id'=>'noMeddisable','value'=>count($data))) ;?>
<table width="100%" class="formFull formFullBorder">
	<tr class="trShow">
		<td style="padding:5px 0 5px 10px;">Drug Name</td>
		<td style="padding:5px 0 5px 2px;">Dose</td>
		<td style="padding:5px 5px 5px 5px;">Route</td>
		<td style="padding:5px 5px 5px 5px;">Frequency</td>
		<td style="padding:5px 0 5px 10px;">Start Date</td>
	</tr>
	<?php $dose = Configure :: read('dose_type');
		  $route = Configure :: read('route_administration');
		 $freq_fullform=Configure :: read('frequency');
		  
		  ?>

	<?php foreach($data as $subData){
if(!empty($subData['VaccineDrug']['MEDID'])){
$vax=" (".Vaccine.")";
}else{
$vax="";
}?>

	<tr class="light">
		<td style="padding:0 0 0 10px;"><?php if(empty($subData['NewCropPrescription']['drug_id'])){
			$pt_id=$subData['NewCropPrescription']['patient_uniqueid'];
			$med_id=$subData['NewCropPrescription']['id'];
			$flag='notPresent';
			echo $this->Html->link($this->Html->image('icons/exlpoint.jpeg',array('title'=>'Medication is not present in our database, so select alternate medication.','alt'=>'Remove')),
				array('controller'=>'Diagnoses','action'=>'currentTreatment',$subData['NewCropPrescription']['patient_uniqueid'],$subData['NewCropPrescription']['id'],$subData['NewCropPrescription']['patient_id'],'null','null',$appointmentID,'?'=>array('appt_id'=>$appointmentID,'patientId'=>$patientId,'flag'=>$flag)),array('id'=>'','class'=>'alternateMed','escape' => false,'style'=>'float:left;'));
			}?>&nbsp;
		<?php  		if($subData['NewCropPrescription']['is_med_administered']=='2' || $subData['NewCropPrescription']['refusetotakeimmunization']=='1' ){
						 echo $this->Html->link(stripslashes(ucfirst($subData['NewCropPrescription']['description']).$vax),'#',array('style'=>'text-decoration:none','title'=>'This medication is administered or refused by patient. You can not edit it.'));
				}else{
					 echo $this->Html->link(stripslashes(ucfirst($subData['NewCropPrescription']['description']).$vax),
					array('controller'=>'Diagnoses','action'=>'currentTreatment',$subData['NewCropPrescription']['patient_uniqueid'],
					$subData['NewCropPrescription']['id'],$subData['NewCropPrescription']['patient_id'],'null','null',$appointmentID,
					'?'=>array('appt_id'=>$appointmentID,'patientId'=>$patientId)),array('alt'=>'Edit','title'=>'Edit'));
				}?></td>
		<td style="padding:0 5px 0 5px;"><?php echo $dose[$subData['NewCropPrescription']['dose']];?></td>
		<td style="padding:0 5px 0 5px;"><?php echo $route[$subData['NewCropPrescription']['route']];?></td>
		<td style="padding:0 5px 0 5px;"><?php echo  $freq_fullform[$subData['NewCropPrescription']['frequency']];?></td>
		<td style="padding:0 5px 0 5px;"><?php echo $this->DateFormat->formatDate2Local($subData['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);?></td>
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
		  /*
function editMedication(ID,PUID){
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
			getmedication();
			getMedicationHistory();
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "currentTreatment",$patientId)); ?>"+"/"+ID+"/"+PUID+"/",
				
		
	});
}
		  */

$(document).ready(function(){
	//submit_form();	
	 
});
function submit_form()
{
	document.getElementById('UserGetMedicationForm').submit();
}
</script>