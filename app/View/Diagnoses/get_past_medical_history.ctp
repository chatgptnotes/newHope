<table width="100%" border="0" cellspacing="1" cellpadding="0"
						id='DrugGroup' class="tabularForm">
<?php if(!empty($previousDiagnosis)){?>
						<tr>
							<td width="20%" height="20" align="center" valign="top"><b><?php echo __('Diagnosis Name');?></b></td>
							<td width="20%" height="20" align="center" valign="top"><b><?php echo __('Diagnosis Type');?></b></td>
							<td width="20%" height="20" align="center" valign="top"><b><?php echo __('ICD9 Code');?></b></td>
							<td width="20%" height="20" align="center" valign="top"><b><?php echo __('ICD10 Code');?></b></td>
							<td width="20%" height="20" align="center" valign="top"><b><?php echo __('Status');?></b></td>
							<td width="20%" height="20" align="center" valign="top"><b><?php echo __('Action');?></b></td>
						
						</tr>
						<?php foreach($previousDiagnosis as $diagno){?>
							<?php if($diagno['NoteDiagnosis']['diagnosis_type'] == 'PD'){
									$type = 'Principal Diagnosis';
							      }else if($diagno['NoteDiagnosis']['diagnosis_type'] == 'O'){
									$type = 'Other';
								  }else{
									$type = '---';	
								  }?>
						<tr id='diag'>
						<?php $icd=$diagno['NoteDiagnosis']['snowmedid'];
								if($diagno['NoteDiagnosis']['terminal']=='Yes'){
									$status= 'Inactive';
								}else{
									$status= 'Active';
								}
						?>
						
							<td align="left"><?php echo ($diagno['NoteDiagnosis']['diagnoses_name']);?></td>
							<td align="left"><?php echo ($type);?></td>
							<td align="left"><?php echo ($diagno['NoteDiagnosis']['icd_id']);?></td>
							<td align="left"><?php echo ($diagno['NoteDiagnosis']['snowmedid']);?></td>
							<td align="left"><?php echo $status;?></td>
							<td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)', array('onclick'=>'editProblem('.$diagno['NoteDiagnosis']['patient_id'].',\''.$icd.'\','.$diagno['NoteDiagnosis']['id'].')','title'=>'Edit Diagnoses','escape' => false));?>
							
						</tr>
						<?php } }?>
						
</table>

<script>

function editProblem(id,icd_id,diagnosisId) {
	$.fancybox({
				'width' : '42%',
				'height' : '30%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'onClosed':function(){
					getPastMedicalHistory();
				},
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
				+ '/' + id + '/' + icd_id+"/"+diagnosisId+'?returnUrl=callGetProblem',

			});

}

</script>