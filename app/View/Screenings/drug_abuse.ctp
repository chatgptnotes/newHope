<?php $patient_id = 1; //static value?> 
<style>
label{
float:none;
}
</style>
<div class="inner_title">
 <h3><?php echo __('Drug Abuse Screening Screening (DAST) Check List'); ?></h3>
</div>
<?php 
		$options =array('1'=>'Yes','0'=>'No');
		$options_except =array('0'=>'Yes','1'=>'No');				//for except 4 and 5 Question value on yes.

		$opt = array(3,4);

	$q=array();
	$q[0] = 'Have you used drugs other than those required for medical reasons?';
	$q[1] = 'Have you abused prescription drugs?';
	$q[2] = 'Do you abuse more than one drug at a time?';
	$q[3] = 'Can you get through the week without using drugs?';
	$q[4] = 'Are you always able to stop using drugs when you want to?';
	$q[5] = 'Have you had "blackouts" or "flashbacks" as a result of drug use?';
	$q[6] = 'Do you ever feel bad or guilty about your drug use?';
	$q[7] = 'Does your spouse (or parents) ever complain about your involvement with drugs?';
	$q[8] = 'Has drug abuse created problems between you and your spouse or your parents?';
	$q[9] = 'Have you lost friends because of your use of drugs?';
	$q[10] = 'Have you neglected your family because of your use of drugs?';
	$q[11] = 'Have you been in trouble at work because of your use of drugs?';
	$q[12] = 'Have you lost a job because of drug abuse?';
	$q[13] = 'Have you gotten into fights when under the influence of drugs?';
	$q[14] = 'Have you engaged in illegal activities in order to obtain drugs?';
	$q[15] = 'Have you been arrested for possession of illegal drugs?';
	$q[16] = 'Have you ever experienced withdrawal symptoms (felt sick) when you stopped taking drugs?';
	$q[17] = 'Have you had medical problems as a result of your drug use (e.g., memory loss, hepatitis, convulsions, bleeding, etc.)?';
	$q[18] = 'Have you gone to anyone for help for a drug problem?';
	$q[19] = 'Have you been involved in a treatment program especially related to drug use?';
?>
<?php echo $this->Form->create('Screening',array('controller'=>'Screenings','action'=>'drug_abuse',$patient_id));
echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][form_name]",'value'=>"drug_abuse"));
echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][id]",'value'=>$Screenings['Screening']['id']));?>
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
 <tr>
 	<thead>
 		<th width="5%"><?php echo __('No.');?></th>
	  	<th width="70%"><?php echo __('Questions'); ?></th>
	  	<th width="13%"><?php echo __('Action');?></th>
	  	<th width="12%"><?php echo __('Score');?></th>
  	</thead>
 
 <?php $unser = unserialize($Screenings['Screening']['ser_data']); //unserialize data ?>
 
 <tbody>
 <?php $count = 1; $total = 0; foreach($q as $key=>$q) {  ?>
 	<tr>
 		<td align="center"><?php echo $count;?></td>
 		<td><?php echo $q;?></td>
 		<?php if(isset($unser[q.$key]))
 				{
 					$checked = $unser[q.$key];
 					$total = $total + $checked; 
 				}
 		?>
 		<td>
 			<table>
 				<tr>
 					<?php if(in_array($key,$opt)) { ?>
 					<td>
 						<?php echo $this->Form->input('',array('type'=>'radio','options'=>$options_except,'idd'=>$count,'id'=>'ans_'.$count,'default'=>$checked,'class'=>'ans','legend'=>false,'label'=>true,'name'=>"data[Screening][questions][q$key]"))?>
 					</td>
 					<?php } else {?>
 					<td>
 						<?php echo $this->Form->input('',array('type'=>'radio','options'=>$options,'idd'=>$count,'id'=>'ans_'.$count,'default'=>$checked,'class'=>'ans','legend'=>false,'label'=>true,'name'=>"data[Screening][questions][q$key]"))?>
 					</td>
 					<?php }?>
 				</tr>
 			</table>
 		</td>
 		<td align="center">
 			<span id="score_<?php echo $count;?>"><?php if(isset($checked)) { echo $checked; }?></span>
 		</td>
 	</tr>
 	
 	<?php $count++; } unset($checked); ?>
 	<tr>
 		<td colspan="3" align="right"><?php echo __('Total'); ?></td>
		<td align="center" id="total"><?php if(isset($total)) { echo $total; }?></td>
 	</tr>
 </tbody>
 
</table>

<div class="btns">
	<table>
		<tr>
			<td><?php echo $this->Form->submit(__("Submit"),array('class'=>'blueBtn'));?></td>
			<td><?php echo $this->Html->link(__('Cancel'),array('action' => 'drug_abuse'),array('escape' => false,'class'=>'blueBtn')); ?></td>
		</tr>
	</table>
</div>

<?php echo $this->Form->end();?>
 
 <script>
$(document).ready(function(){
	$('.ans').click(function()
	{ 
		currentRow = $(this).attr('idd') ;
		value = $(this).val();
		$("#score_"+currentRow).html(value);
		totalScore =  0 ;
		$( ".ans" ).each( function( index, element ){ 
			if($(this).attr('checked'))
			totalScore += parseInt( $( this ).val()) ;
		});
		console.log(totalScore);
		$("#total").html(totalScore);
	});
});
</script>
