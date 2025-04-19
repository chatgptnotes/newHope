<style>
#LabTableId{ padding-bottom:10px;margin-left:10px;}
#radTableId{ padding-bottom:10px;margin-left:10px;}
.data_section{ margin-left:10px;}
.text{float: left; margin: 0 0 4px 10px;padding: 0;}

.fontTypeForHeads{
font-size:15px !important;
}
</style>

<table id="LabTableId">
<tr>
	<td class="fontTypeForHeads"><strong> Lab:</strong></td>
	<?php if(!empty($getLabData)){?>
	<td><?php echo $this->Html->image('icons/print.png',
								array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'laboratories','action'=>'investigation_print',$patientId,$getLabData['0']['LaboratoryTestOrder']['batch_identifier']))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,left=400,top=300,height=700');  return false;"));?></td>
<?php }?>
	</tr>
<?php foreach($getLabData as $showLab){
?>
<tr id="lab_<?php echo $showLab['LaboratoryTestOrder']['id'];?>">
	<td class="text"><?php  if(!empty($showLab['LaboratoryResult']['id']) && $showLab['LaboratoryResult']['is_authenticate']=='1'){
	 //echo $this->Html->link($showLab['Laboratory']['name'],array("controller" => "laboratories", "action" => //"viewLabTestResultsHl7",$showLab['LaboratoryTestOrder']['patient_id'],$showLab['LaboratoryTestOrder']['id'],$showLab['LaboratoryResult']['id']),array('tit//le'=>'View Detail Result','target'=>'_blank')); 
	 echo $this->Html->link($showLab['Laboratory']['name'],array("controller" => "NewLaboratories", "action" => "printLab",'?'=>array('testOrderId'=>$showLab['LaboratoryTestOrder']['id'])),array('title'=>'View Detail Result','target'=>'_blank'));
		//echo " Result: ".$showLab['LaboratoryHl7Result']['result'].' '.$showLab['LaboratoryHl7Result']['unit'];
	}else{
echo $showLab['Laboratory']['name'];
if(empty($showLab['LaboratoryTestOrder']['paid_amount'])){?>
<span style="float:right;"><?php echo $this->Html->image('/img/icons/cross.png',
		array('class'=>'deleteLab','id'=>$showLab['LaboratoryTestOrder']['id'],'alt' => 'Remove'));?></span>
<?php }	
	}?></td>
	
</tr>
<?php }?>
</table>
<table id="radTableId">
<tr>
	<td class="fontTypeForHeads"><strong> Radiology:</strong></td>
	<?php if(!empty($getRadData)){?>
	<td><?php echo $this->Html->image('icons/print.png',
								array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Radiologies','action'=>'investigation_print',$patientId))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,left=400,top=300,height=700');  return false;"));?></td>
	<?php }?>
</tr>
<?php 
 foreach($getRadData as $showRad){?>
<tr id="rad_<?php echo $showRad['RadiologyTestOrder']['id'];?>">
<td>
	<?php  if(!empty($showRad['RadiologyResult']['id'])){
	 echo $this->Html->link($showRad['Radiology']['name'],array('controller'=>'radiologies','action' => 'add_comment',$showRad['RadiologyTestOrder']['patient_id'],
	 				$showRad['Radiology']['id'],$showRad['RadiologyTestOrder']['id'],'?'=>array('from'=>'SmartNote')),array('target'=>'_blank')); 
	 echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'float:right;')),'javascript:void(0)',array('escape' => false,
	 		'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Radiologies','action'=>'print_preview',$showRad['RadiologyTestOrder']['patient_id'],
	 				$showRad['Radiology']['id'],$showRad['RadiologyTestOrder']['id'])).
	 		"', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
	

	}else{
echo $showRad['Radiology']['name'];
if(empty($showRad['RadiologyTestOrder']['paid_amount'])){?>
<span style="float:right;"><?php echo $this->Html->image('/img/icons/cross.png',
		array('class'=>'deleteRad','id'=>$showRad['RadiologyTestOrder']['id'],'alt' => 'Remove'));?></span>
<?php }
	}?>
<td>
</tr>
<?php }?>
</table>
<table id="procedureTableId" style="margin-left:10px;">
	<tr>
		<td class="fontTypeForHeads"><strong> MRI/CT:</strong></td>
	</tr>
<?php 
foreach($getMridData as $showMri){ ?>
	<tr>
		<td>
			<?php if(!empty($showMri['Radiology']['name'])){echo $showMri['Radiology']['name'];}?>
		<td>
	</tr>
<?php }?>
</table>
<table id="" style="margin-left:10px;">
<tr>
	<td id="medSH" class="fontTypeForHeads"><strong> Medication:</strong></td>
</tr>
<?php foreach($getMedData as $showMed){ ?>
<tr class="medSHList" style="display:none">
	<td class="text"><?php  $str=$showMed['NewCropPrescription']['patient_uniqueid']."_".$showMed['NewCropPrescription']['id'];
	echo $this->Html->link(strtoupper($showMed['NewCropPrescription']['description']),'javascript:void(0)',
			array('onclick'=>"editMedNew('$str')"));?></td>
	 
</tr>
<?php }?>
<tr>
	<td id='medSHListMgs' style="display:none"> Click Medication to view all.</td>
</tr>


</table>
<table id="" style="margin-left:10px;">
<tr>
	<td id="allergySH" class="fontTypeForHeads"><strong> Allergy:</strong></td>
</tr>
<?php foreach($getAllergyData as $showAllergy){ ?>
<tr class="allergySHList" style="display:none">
	<td class="text"><?php  $str=$showAllergy['NewCropAllergies']['patient_uniqueid']."_".$showAllergy['NewCropAllergies']['id'];
	echo $this->Html->link(strtoupper($showAllergy['NewCropAllergies']['name']),'javascript:void(0)',
			array('onclick'=>"editallergyNew('$str')"));?></td>
	 
</tr>
<?php }?>
<tr>
	<td id='allergySHListMgs' style="display:none"> Click Allergy to view all.</td>
</tr>


</table>
<table class="data_section">
<tr>
<td id="vitalsShowHide"  class="fontTypeForHeads"><strong>Vitals</strong></td>
</tr>
<tr class="vitalsShowHideList">
	<td><?php if(!empty($getSubData['BmiResult']['temperature'])) echo "Temperature:".$getSubData['BmiResult']['temperature']."<sup>0</sup>".F;?></td>
</tr>
<tr class="vitalsShowHideList">
<td><?php  if(!empty($getSubData['BmiResult']['respiration'])) echo "Respiration Rate:".$getSubData['BmiResult']['respiration']." breaths per minute";?> </td>
</tr>
<tr class="vitalsShowHideList">
<td><?php  if(!empty($getSubData['BmiBpResult']['systolic'])) echo "Blood Pressure:".$getSubData['BmiBpResult']['systolic'].'/'.$getSubData['BmiBpResult']['diastolic']." mmHg";?></td>
</tr>
<tr class="vitalsShowHideList">
<td><?php  if(!empty($getSubData['BmiBpResult']['pulse_text'])) echo "Heart Rate:".$getSubData['BmiBpResult']['pulse_text']." beats per minute";?></td>
</tr>


<tr>
<td id="ChiefShowHide" class="fontTypeForHeads"><strong>Chief Complaints</strong></td>
</tr>
<tr class="ChiefShowHideList">
<td class="text"><?php echo $getSubData['Diagnosis']['complaints']?></td>
</tr>
<tr>
<?php /** BOF HPI & ROS sentence */
//debug($hpiMasterData);
	//$hpiRosSentence = GeneralHelper::createHpiSentence($hpiMasterData,$hpiResultOther,$rosResultOther);
	$HpiNew = $hpiRosSentence['HpiSentence']; 
	//debug($HpiNew);
	$RosNew = $hpiRosSentence['RosSentence'];// debug($RosNew);
	//$peNewData = GeneralHelper::createPhysicalExamSentence($peMasterData,$peResultOther,$pEButtonsOptionValue);
	//debug($peNewData);
/** EOF HPI & ROS sentence */?>
<td id="HPIShowHide" class="fontTypeForHeads"><strong>HPI</strong></td>
</tr>
<tr>
<td class="HPIShowHideList"><?php echo $getSubData['Note']['subject']?></td>
</tr>
<tr>
<td id="ROSShowHide" class="fontTypeForHeads"><strong> ROS</strong></td>
</tr>
<tr>
<td class="ROSShowHideList"><?php echo $getSubData['Note']['ros'];?></td>
</tr>
<tr>
<td id="ObjectiveShowHide" class="fontTypeForHeads"><strong>Objective</strong></td>
</tr>
<tr>
<td class="ObjectiveShowHideList"><?php echo $getSubData['Note']['object']?></td>
</tr>
<tr>
<td id="AssessmentShowHide" class="fontTypeForHeads"><strong> Assessment</strong></td>
</tr>
<tr>
<td class="AssessmentShowHideList"><?php echo $getSubData['Note']['assis']?></td>
</tr>
<tr>
<td class="text" class="fontTypeForHeads"><strong> <?php echo "Prov Diagnosis";?></strong></td>
</tr>
<?php foreach($getNoteDiagnosisData as $key=>$provDia){if($provDia['NoteDiagnosis']['code_system']=='1') { ?>
<tr id="prod_<?php echo $provDia['NoteDiagnosis']['id'];?>">
<td class="text"><?php  echo $provDia['NoteDiagnosis']['diagnoses_name'];?></td>
<td class="text"><?php echo $this->Html->image('/img/icons/cross.png',
        	    		 array('class'=>'deleteProDia','id'=>$provDia['NoteDiagnosis']['id'],'alt' => 'Remove'));?></td>
</tr>
<?php }}?>
<tr>
<td class="text" class="fontTypeForHeads"><strong> <?php echo "Final Diagnosis";?></strong></td>
</tr>
<?php foreach($getNoteDiagnosisData as $FinalDia){ if($FinalDia['NoteDiagnosis']['code_system']==''){?>
<tr id="final_<?php echo $FinalDia['NoteDiagnosis']['id'];?>">
<td class="text"><?php  echo $FinalDia['NoteDiagnosis']['diagnoses_name'];?></td>
<td class="text"><?php echo $this->Html->image('/img/icons/cross.png',
        	    		 array('class'=>'deleteFinalDia','id'=>$FinalDia['NoteDiagnosis']['id'],'alt' => 'Remove'));?></td>

</tr>
<?php }}?>
<tr>
<td class="fontTypeForHeads"><strong> Plan</strong></td>
</tr>
<tr>
<td class="text"><?php $explodePlan=explode(':::',$getSubData['Note']['plan']);
echo $explodePlan[0];?></td>
</tr>
</table>
<script>
$(document).ready(function(){	
	$(document).on("click",".removeLabRow",function(){
		var currentIdLab=$(this).attr('id');
		var trToDel=currentIdLab.split('_');
		$('#LabTr'+trToDel[1]).remove();
		var toPop=trToDel[1];
		var index = toSaveArrayLab.indexOf(toPop);
		if (index > -1) {
			toSaveArrayLab.splice(index, 1);
		}
	});
	$(document).on("click",".removeRadRow",function(){
		var currentIdLab=$(this).attr('id');
		var trToDel=currentIdLab.split('_');
		$('#RadTr'+trToDel[1]).remove();
		var toPop=trToDel[1];
		var index = toSaveArrayRad.indexOf(toPop);
		if (index > -1) {
			toSaveArrayRad.splice(index, 1);
		}
	});
	$(document).on("click",".removeProcedureRow",function(){
		var currentIdLab=$(this).attr('id');
		var trToDel=currentIdLab.split('_');
		$('#procedureTr'+trToDel[1]).remove();
		var toPop=trToDel[1];
		var index = toSaveArrayProcedure.indexOf(toPop);
		if (index > -1) {
			toSaveArrayProcedure.splice(index, 1);
		}
	});
});
$('#labPrint').click(function(){	
});
$('.deleteProDia').click(function(){
		var currentid=$(this).attr('id');
	 if(confirm('Are you sure?')){
	 }else{
		 return false;
	 }
		var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "deleteProblem","admin" => false)); ?>";
		$.ajax({
			beforeSend : function() {
	    		$('#busy-indicator').show('fast');
	    	},
	   	type: 'POST',
	    url: ajaxUrl+'/'+currentid,
	  // 	data: strDataSend,//+"&ProcedureId="+toSaveArrayProcedure
	  	dataType: 'html',
		  	success: function(data){
			  	if(data=='Please try again'){
				  	
			  	}else{
			  	var id= $.trim(data);
		  		$('#prod_'+id).remove();
			  	}
				$('#busy-indicator').hide('fast');
		 	},
		});
		});
	$('.deleteFinalDia').click(function(){
		var currentid=$(this).attr('id');
	 if(confirm('Are you sure?')){
	 }else{
		 return false;
	 }
		var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "deleteProblem","admin" => false)); ?>";
		$.ajax({
			beforeSend : function() {
	    		$('#busy-indicator').show('fast');
	    	},
	   	type: 'POST',
	    url: ajaxUrl+'/'+currentid,
	  // 	data: strDataSend,//+"&ProcedureId="+toSaveArrayProcedure
	  	dataType: 'html',
		  	success: function(data){
			  	if(data=='Please try again'){
				  	
			  	}else{
			  	var id= $.trim(data);
		  		$('#final_'+id).remove();
			  	}
				$('#busy-indicator').hide('fast');
		 	},
		});
		});
	$('.deleteLab').click(function(){
		var currentid=$(this).attr('id');
		var noteId='<?php echo $noteId?>';
	 if(confirm('Are you sure?')){
	 }else{
		 return false;
	 }
		var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "deleteLaboratoryTestOrder","admin" => false)); ?>";
		$.ajax({
			beforeSend : function() {
	    		$('#busy-indicator').show('fast');
	    	},
	   	type: 'POST',
	    url: ajaxUrl+'/'+currentid+'/'+noteId,
	  // 	data: strDataSend,//+"&ProcedureId="+toSaveArrayProcedure
	  	dataType: 'html',
		  	success: function(data){
			  	var dataSplited=data.split("_");
			  	if(dataSplited["0"]=='Please try again'){
				  	
			  	}else{
			  	var id= $.trim(dataSplited["0"]);
		  		$('#lab_'+id).remove();
			  	}
			  	
				$('#messageLabRad').val(dataSplited["1"]);
				$('#busy-indicator').hide('fast');
		 	},
		});
		});
	$('.deleteRad').click(function(){
		var currentid=$(this).attr('id');
		var noteId='<?php echo $noteId?>';
	 if(confirm('Are you sure?')){
	 }else{
		 return false;
	 }
		var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "deleteRadiologyTestOrder","admin" => false)); ?>";
		$.ajax({
			beforeSend : function() {
	    		$('#busy-indicator').show('fast');
	    	},
	   	type: 'POST',
	    url: ajaxUrl+'/'+currentid+'/'+noteId,
	  // 	data: strDataSend,//+"&ProcedureId="+toSaveArrayProcedure
	  	dataType: 'html',
		  	success: function(data){
		  		var dataSplited=data.split("_");
			  	if(dataSplited["0"]=='Please try again'){
				  	
			  	}else{
			  	var id= $.trim(dataSplited["0"]);
		  		$('#rad_'+id).remove();
			  	}
			  	
				$('#messageLabRad').val(dataSplited["1"]);
				$('#busy-indicator').hide('fast');
		 	},
		});
		});
	 function editMedNew(id){
		var noteId="<?php echo $noteId;?>";
		var parmsnew=id.split('_');
		var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addMedication","admin" => false)); ?>";
		$.ajax({
			beforeSend : function() {
	    		$('#busy-indicator').show('fast');
	    	},
	   	type: 'POST',
	    url: ajaxUrl+'/'+parmsnew['0']+'/'+parmsnew['1']+"?ajaxFlag=ajaxHold&noteId="+noteId,
	  // 	data: strDataSend,//+"&ProcedureId="+toSaveArrayProcedure
	  	dataType: 'html',
		  	success: function(data){
		  	$('#Prescription').html(data);
		 	$('#busy-indicator').hide('fast');
		  	jQuery('.tabs ' + "#Prescription").show().siblings().hide();
        // Change/remove current tab to active
       		 jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
       		$(window).scrollTop(30);  
		 	},
		});
	}
	 function editallergyNew(id){
			var noteId="<?php echo $noteId;?>";		
			var parmsnew=id.split('_');
			var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "ajax_allallergies","admin" => false)); ?>";
			$.ajax({
				beforeSend : function() {
		    		$('#busy-indicator').show('fast');
		    	},
		   	type: 'POST',
		    url: ajaxUrl+'/'+parmsnew['0']+'/'+"<?php echo $noteId;?>"+'/'+"<?php echo $appointmentId;?>"+'/'+parmsnew['1'],  ///+"?ajaxFlag=ajaxHold&noteId="+noteId
		  // 	data: strDataSend,//+"&ProcedureId="+toSaveArrayProcedure
		  	dataType: 'html',
			  	success: function(data){
			  	$('#Allergy').html(data);
			 	$('#busy-indicator').hide('fast');
			  	jQuery('.tabs ' + "#Allergy").show().siblings().hide();
	        // Change/remove current tab to active
	       		 jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
	       		$(window).scrollTop(30);   
			 	},
			});
		}

	 
	 $( "#vitalsShowHide" ).click(function() {
		 $( ".vitalsShowHideList" ).toggle( "slow", function() {
		// $("#vitalsShowHide").show();
		 });
		 });
	 var too='1';
	 $( "#medSH" ).click(function() {
		 too++;
		 $( ".medSHList" ).toggle( "slow", function() {
			/*if(too%2==0){
					$("#medSHListMgs").show();
				}*/
		 });
		 });

	 var too3='1';
	 $( "#medSHListMgs" ).click(function() {
		 too3++;
		 $( ".medSHList" ).toggle( "slow", function() {
	//	$("#medSHListMgs").show();
				if(too3%2==0){
					$("#medSHListMgs").hide();
				}else{
					$("#medSHListMgs").show();
				}
		 });

		
		 });
	 
	 var too1='1';
	 $( "#allergySHListMgs" ).click(function() {
		 too1++;
		 $( ".allergySHList" ).toggle( "slow", function() {
	//	$("#medSHListMgs").show();
				if(too1%2==0){
					$("#allergySHListMgs").hide();
				}else{
					$("#allergySHListMgs").show();
				}
		 });

		
		 });
		
	 var too2='1';
	 $( "#allergySH" ).click(function() {
		 too2++;
		 $( ".allergySHList" ).toggle( "slow", function() {
		//$("#allergySHListMgs").show();
				/*if(too2%2==0){
					$("#allergySHListMgs").hide();
				}*/
		 });

		
		 });
		
</script>