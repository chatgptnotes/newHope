
<style>
.trShow{
background-color:#ccc;

}
</style>
<table width="100%" class="formFull formFullBorder">
	<tr>
		<td style="text-align: left;"><?php 
			if(!empty($data)){
				$disable='disabled';
			}else{
				$disable='';
	
				if(empty($getcheckmed)){
					if($checkDiagnosis['Note']['no_diagnoses_check']=='yes'){
						$check='checked';
					}elseif($checkDiagnosis['Note']['no_diagnoses_check']=='no'){
						$check='';
					}
				
			}
			}
			echo $this->Form->checkbox('',array('name'=>'no_diagnoses_check','id'=>'noDiagnosescheck','checked'=>$check,'onclick'=>'save_checkDiagnosis();','disabled'=>$disable));?> No known Diagnoses
		</td>
	</tr>
	<tr class="trShow">
		<td style="padding:5px 0 5px 10px;">Diagnosis</td>
		<td style="padding:5px 0 5px 10px;">Info Button</td>
		<td style="padding:5px 0 5px 10px;">ICD9 Code</td>
		<td style="padding:5px 0 5px 10px;">ICD10 Code</td>
	</tr>
	<?php if(!empty($data)) {
	
		?>
	<?php foreach($data as $subData){?>
	<tr>
				<td style="padding:0 0 0 10px;"><?php $icd=$subData['NoteDiagnosis']['snowmedid'];
		echo $this->Html->link($subData['NoteDiagnosis']['diagnoses_name'],'#',
				array('onclick'=>'editProblem('.$subData['NoteDiagnosis']['patient_id'].',"'.$icd.'",'.$subData['NoteDiagnosis']['id'].')'));?></td>
				<td style="padding:0 0 0 10px;"><?php echo $this->Html->link($this->Html->image('icons/infobutton.png',array('class'=>'pData','id'=>$subData['NoteDiagnosis']['diagnoses_name'].','.$subData['NoteDiagnosis']['patient_id'].','.$subData['NoteDiagnosis']['snowmedid'])),"javascript:void(0)",
				array('escape'=>false));?></td>
		<td style="padding:0 0 0 10px;"><?php echo $subData['NoteDiagnosis']['icd_id'];?></td>
		<td style="padding:0 0 0 10px;"><?php echo $subData['NoteDiagnosis']['snowmedid'];?></td>
	</tr>
	<?php }}else{?>
	<tr>
		<td style="padding:0 0 0 10px;"><?php echo "No records found"?></td>
	</tr>
	<?php }?>
</table>
<script>
function editProblem(id,icd_id,diagnosisId) {
	$
	.fancybox({
				'width' : '60%',
				'height' : '60%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
				+ '/' + id + '/' + icd_id+"/"+diagnosisId+'?returnUrl=callGetProblem',

			});

}
$('.pData').click(function(){
var cData= $(this).attr('id');
var newDta=cData.split(',');


	$.fancybox({

				'width' : '60%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "infobutton")); ?>" + '/'+newDta[2]+ '/' + newDta[0] + '/'+newDta[1]
						
	});

});

function save_checkDiagnosis(){
	if($('#noDiagnosescheck').prop('checked')){
		var checkall=1;
	}else{
	  	var checkall=0;
    }
var patientid="<?php echo $patientId?>";
note_id="<?php echo $noteId?>";
if(note_id==''){
	note_id=$.trim($('#subjectNoteId').val()); 
	
}
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "setNoActiveDiagnosis","admin" => false)); ?>";
$.ajax({
    type: 'POST',
     url: ajaxUrl+"/"+patientid+"/"+checkall+"/"+note_id,
     //data: formData,
     dataType: 'html',
     success: function(data){
    	 var noteid=parseInt($.trim(data));
    	 $('#familyid').val(data);
		  $('#ccid').val(data); 
		  $('#subjectNoteId').val(data); 
		  $('#assessmentNoteId').val(data); 
		  $('#objectiveNoteId').val(data); 
		  $('#planNoteId').val(data); 
		  $('#signNoteId').val(data);
     },
	 error: function(message){
        alert(message);
     }       
   });
}
		</script>