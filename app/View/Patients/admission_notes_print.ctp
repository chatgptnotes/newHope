<style>
<!--
.textBoxExpnd{
	float: none ;
}
body{
	background:none;
	margin-top:10px !important;
	padding:none !important;
}
-->
</style>
<?php 
	$data = $this->data['OperativeNote'] ;		
?>
<table align="center">
	<tr><td><?php echo $this->Html->image('hope-logo-sm.gif');?></td></tr>
	<tr><td style="font-size: 20px;font-weight: bold;"><?php echo "ADMISSION NOTES";?></td></tr>
</table>
<div class="inner_title">&nbsp;
	<span><?php echo $this->Html->link('Print','javascript:void(0)',array('escape'=>false,'class'=>'blueBtn','onclick'=>'window.print();','id'=>'printButton'))?></span></div>
<table width="100%" cellspacing="1" cellpadding="1">
	<tr>
		<td>Name: <b><?php echo $getElement['Patient']['lookup_name'];?></b></td>
		<td>Admission Type: <b><?php echo $getElement['Patient']['admission_type'];?></b></td>
		<td>Gender: <b><?php echo ucfirst($getElement['Person']['sex']);?></b></td>
		<td>Age: <b><?php echo $getElement['Person']['age'];?></b></td>
		<td>Admission ID: <b><?php echo $getElement['Patient']['admission_id'];?></b></td>
	</tr>
</table>
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
<table width="100%" cellpadding="1" cellspacing="2" class="table_format" >
	<!-- <tr>
		<td class="tdOne"><?php echo "Doctor Name :";?></td>
		<td class="tdTwo"><?php echo $this->Form->input('dname',array('type'=>'text','label'=>false,'value'=>$dname));?></td>
	</tr> -->
	<tr>
		<td class="tdOne"><?php echo "Complaint :";?></td>
		<td class="tdTwo"><?php echo $complaint;?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "History Of Present Illness :";?></td>
		<td class="tdTwo"><?php echo $hpi;?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Past Illness :";?></td>
		<td><?php echo $illness;?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Personal History/Habits :";?></td>
		<td><?php echo $habit;?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Occupation History & Family History :";?></td>
		<td><?php echo $history;?></td>
	</tr>
	<tr>	
		<td class="tdOne"><?php echo "Clinical Examination :";?></td>
		<td><?php echo $exam;?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Investigation :";?></td>
		<td><?php echo $investigation;?></td>
	</tr>
	<tr>	
		<td class="tdOne"><?php echo "Provisional Diagnosis :";?></td>
		<td><?php echo $diagnosis;?></td>
	</tr>
	<tr>
		<td class="tdOne"><?php echo "Surgery Plans :";?></td>
		<td><?php echo $plan;?></td>
		<td class="tdOne">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%">
				<tr>
					<td valign="top" width="21%"><b>&nbsp;</b></td>
					<td valign="top" width="20%">&nbsp;</td>
					<td valign="top" width="22%"><b>Signature of Doctor </b></td>
					<td>________________________________</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td valign="top">&nbsp;</td>
					<td valign="top"><b>Name Of Surgeon :</b></td>
					<td><?php echo ucfirst($dname) ;?></td>
				</tr>
			</table>
<p>&nbsp;</p> 
 
