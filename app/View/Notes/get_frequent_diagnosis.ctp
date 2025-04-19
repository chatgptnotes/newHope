<style>
.trShow{
background-color:#ccc;

}
</style>
<table class="formFull formFullBorder" style="text-align: left; padding: 0px !important;margin: 11px auto 0; " width="99%">
	<tr class="trShow">
		<td class="row_format">Diagnosis Name</td>
		<td class="row_format">ICD 9 codes</td>
		<td class="row_format">ICD 10 codes</td>
	</tr>
	<?php foreach($frequentProblemByDoctor as $data){?>
	<tr>
	<?php 	$icdStr=$data['NoteDiagnosis']['icd_id'];
			$snowmeStr=$data['NoteDiagnosis']['snowmedid'];
			$diagnosesStr=$data['NoteDiagnosis']['diagnoses_name'];
		?>
	<!-- ($id=null,$icd=null,$note_id=null,$snow_id=null){ ,F52.9, Abnormal psychosexual phase (finding),1 -->
	<!-- patient_id , allIdsn, noteId -->
		<td><?php echo $this->Html->link($data['NoteDiagnosis']['diagnoses_name'],'javascript:void(0)',
				array('onclick'=>"AddProblem('$patientId','$icdStr','$snowmeStr','".$diagnosesStr."','$noteId')",'escape'=>false));?></td>
		<td><?php echo $data['NoteDiagnosis']['icd_id'];?></td>
		<td><?php echo $data['NoteDiagnosis']['snowmedid'];?></td>
	</tr>
	<?php }?>
	<?php if(empty($frequentProblemByDoctor)){?><tr>
	<td class="row_format" colspan="3">No record found.</td>
	</tr>
	<?php }?>
	</table>
	<script>
	function AddProblem(id,icd_id,snowmeStr,diagnosesStr,noteId) {
		var icdStr=icd_id+','+snowmeStr+','+diagnosesStr+','+noteId;
		$
		.fancybox({
					'width' : '60%',
					'height' : '60%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
					+ '/' + id + '/' + icdStr+"?str=fav",

				});

	}
	</script>