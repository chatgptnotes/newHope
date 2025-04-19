<style>
.trShow{
background-color:#ccc;

}
.pointer{
	cursor: pointer;
}
</style><?php 
echo $this->Form->hidden('noallergycheck',array('id'=>'noallergycheck','value'=>$getallergycheck['Diagnosis']['no_allergy_flag'])) ;?>
<?php if(!empty($data)){
	echo $this->Form->hidden('allergyCnt',array('id'=>'allergyCnt','value'=>count($data))) ;
?>
<table width="100%" class="formFull formFullBorder">
	<tr class="trShow">
		<td>&nbsp;</td>
		<td style=" padding:0 0 0 10px;">Allergy</td>
		<td style=" padding:0 0 0 10px;">Severity Level</td>
		<td style=" padding:0 0 0 10px;">Reaction</td>
		<td style=" padding:0 0 0 10px;">Date</td>
	</tr>
	<?php 
	foreach($data as $data){
	$pID = $data['NewCropAllergies']['patient_uniqueid'];
	$newCropAllergies_id = $data['NewCropAllergies']['id'];?>
	<tr class="" id='<?php $pID ?>'>
		<td><?php if($data['NewCropAllergies']['CompositeAllergyID']=='' || $data['NewCropAllergies']['CompositeAllergyID']=='0' && $data['NewCropAllergies']['CompositeAllergyID']==null){
			$pt_id=$data['NewCropAllergies']['patient_uniqueid'];
			$al_id=$data['NewCropAllergies']['id'];
			$flag='notPresent';
			echo $this->Html->image('icons/exlpoint.jpeg',array('title'=>'Allergy is not present in our database, so select alternate allergy.','alt'=>'Remove','id'=>$data[NewCropAllergies][patient_uniqueid].'_'.$data[NewCropAllergies][id].'_'.$flag,'class'=>'allergy medNotPresent','escape' => false,'style'=>'float:left;',"onclick"=>"addAllergy('$pt_id','$al_id','$flag')"));
			}?></td>
		<td class="pointer light allergy" style=" padding:0 0 0 10px;" pid='<?php echo $pID;?>'   id='<?php echo $newCropAllergies_id;?>'><?php echo $data['NewCropAllergies']['name'];?></td>
		<td class="" style=" padding:0 0 0 10px;"  pid='<?php echo $pID;?>'   id='<?php echo $newCropAllergies_id;?>'><?php echo $data['NewCropAllergies']['AllergySeverityName'];?></td>
		<td class="" style=" padding:0 0 0 10px;"  pid='<?php echo $pID;?>'   id='<?php echo $newCropAllergies_id;?>'><?php echo ucwords($data['NewCropAllergies']['note']);?></td>
		<td class="" style=" padding:0 0 0 10px;" pid='<?php echo $pID;?>'   id='<?php echo $newCropAllergies_id;?>'><?php echo $this->DateFormat->formatDate2Local($data['NewCropAllergies']['onset_date'],Configure::read('date_format_us'),false);?></td>
	</tr>
	<?php } ?>
</table>
<?php }else{?>
<table>
	<tr>
		<td><span style="color: grey; font-size: 13px;"><?php echo __('No Record Found')?> </td>
	</tr>
</table>
<?php }?>
<script>
$('.allergy').click(function(){ 
	
	if($(this).hasClass("medNotPresent")){
		var currentId=$(this).attr('id');
		splittedVar = currentId.split("_");	
		var pID = splittedVar['0'];
		var ID = splittedVar['1'];
		var flag=splittedVar['2'];
	}else{
		var currentpId=$(this).attr('pid');
		var currentId=$(this).attr('id');
		var pID = currentpId;
		var ID = currentId;
		var flag='';
	}

	$.fancybox({
		'width' : '80%',
		'height' : '60%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			getAllergy();
			getAllergyTop();
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "allallergies")); ?>"+'/'+pID+'/'+ID+'?allergyAbsent='+flag,
				
	});
});
</script>