<style>
	.tdOne{
		width: 10%;
		text-align: center;
	}
	.tdTwo{
		width: 40%;
	}
	textArea{
		width: 460px; 
		height: 89px;	
	}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Admission Notes '); ?>
	</h3>
</div>
<div style="float: right;">
<?php 
      echo $this->Html->link('Print','javascript:void(0);',array('class'=>'blueBtn','onclick'=>'printAdmission();'))
    ?>
    </div>
<?php $data=$dataNote['Admissionnote'];
	$complaint=isset($data['complaint'])?$data['complaint']:'';
	$hpi=isset($data['hpi'])?$data['hpi']:'';
	$illness=isset($data['pastillness'])?$data['pastillness']:'';
	$habit=isset($data['habits'])?$data['habits']:'';
	$history=isset($data['familyhistory'])?$data['familyhistory']:'';
	$exam=isset($data['clinicalExam'])?$data['clinicalExam']:'';
	$investigation=isset($data['investigation'])?$data['investigation']:'';
	$diagnosis=isset($data['diagnosis'])?$data['diagnosis']:'';
	$dname=isset($data['dname'])?$data['dname']:'';
	$plan=isset($data['plan'])?$data['plan']:'';
	$id=isset($data['id'])?$data['id']:'';
?>
<?php echo $this->Form->create('admissionNote',array('type' => 'file','name'=>'register','id'=>'personfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	)));
	echo $this->Form->hidden('id',array('value'=>$id));
?>
<table width="100%" cellspacing="1" cellpadding="1">
	<tr>
		<td>Name: <b><?php echo $getElement['Patient']['lookup_name'];?></b></td>
		<td>Admission Type: <b><?php echo $getElement['Patient']['admission_type'];?></b></td>
		<td>Gender: <b><?php echo ucfirst($getElement['Person']['sex']);?></b></td>
		<td>Age: <b><?php echo $getElement['Person']['age'];?></b></td>
		<td>Admission ID: <b><?php echo $getElement['Patient']['admission_id'];?></b></td>
	</tr>
</table>
<table width="100%" cellpadding="1" cellspacing="2" >
	<tr>
		<td class="tdOne"><?php echo "Doctor Name :";?></td>
		<td class="tdTwo"><?php echo $this->Form->input('dname',array('type'=>'text','label'=>false,'value'=>$dname));?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Complaint :";?></td>
		<td class="tdTwo"><?php echo $this->Form->input('complaint',array('type'=>'textArea','label'=>false,'value'=>$complaint));?></td>
		<td class="tdOne"><?php echo "History Of Present Illness :";?></td>
		<td class="tdTwo"><?php echo $this->Form->input('hpi',array('type'=>'textArea','label'=>false,'value'=>$hpi));?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Past Illness :";?></td>
		<td><?php echo $this->Form->input('pastillness',array('type'=>'textArea','label'=>false,'value'=>$illness));?></td>
		<td class="tdOne"><?php echo "Personal History/Habits :";?></td>
		<td><?php echo $this->Form->input('habits',array('type'=>'textArea','label'=>false,'value'=>$habit));?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Occupation History & Family History :";?></td>
		<td><?php echo $this->Form->input('familyhistory',array('type'=>'textArea','label'=>false,'value'=>$history));?></td>
		<td class="tdOne"><?php echo "Clinical Examination :";?></td>
		<td><?php echo $this->Form->input('clinicalExam',array('type'=>'textArea','label'=>false,'value'=>$exam));?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Investigation :";?></td>
		<td><?php echo $this->Form->input('investigation',array('type'=>'textArea','label'=>false,'value'=>$investigation));?></td>
		<td class="tdOne"><?php echo "Provisional Diagnosis :";?></td>
		<td><?php echo $this->Form->input('diagnosis',array('type'=>'textArea','label'=>false,'value'=>$diagnosis));?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Surgery Plans :";?></td>
		<td><?php echo $this->Form->input('plan',array('type'=>'textArea','label'=>false,'value'=>$plan));?></td>
		<td class="tdOne">&nbsp;</td>
		<td>
			<?php
				echo $this->Form->hidden('patient_id',array('value'=>$patientID)); 
				echo $this->Form->hidden('note_id',array('value'=>$noteID));
				echo $this->Form->input('Save',array('type'=>'Submit','label'=>false,'class'=>'blueBtn'));
			?></td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<script type="text/javascript">
	function printAdmission(patientID,Key){
   var url="<?php echo $this->Html->url(array('controller' => 'Patients', 'action' => 'admissionNotesPrint',$patientID,$noteID)); ?>";
   window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready
  
}
</script>