<?php $patient_id = 1234; //static value?> 
<style> label{float:none;} </style>
<div class="inner_title">
 <h3><?php echo __('DEPRESSION SCALE'); ?></h3>
</div>
<?php 
		$options =array('0'=>'Not Present', '1'=>'Mild', '2'=>'Moderate' ,'3'=>'Severe,', '4'=>'Very Severe');
		
		//questions
		$q=array();
		$q[0] = "<strong>Anxious mood</strong> <br> (Worries, anticipation of the worst, fearful anticipation, irritability)";						
		$q[1] = "<strong>Tension</strong> <br> (Feelings of tension, fatigability, startle response, moved to tears easily, trembling, feelings of restlessness, inability to relax)";							
		$q[2] = "<strong>Fears</strong> <br> (Of dark, of strangers, of being left alone, of animals, of traffic, of crowds)";						
		$q[3] = "<strong>Insomnia</strong> <br> (Difficulty in falling asleep, broken sleep, unsatisfying sleep and fatigue on waking, dreams, nightmares, night terrors.)";							
		$q[4] = "<strong>Intellectual</strong> <br> (Difficulty in concentration, poor memory)";									
		$q[5] = "<strong>Depressed Mood</strong> <br> (Loss of interest, lack of pleasure in hobbies, depression, early waking, diurnal swing)";											
		$q[6] = "<strong>Somatic (muscular)</strong> <br> (Pains and aches, twitching, stiffness, myoclonic jerks, grinding of teeth, unsteady voice, increased muscular tone)";							
		$q[7] = "<strong>Somatic (Sensory)</strong> <br> (Tinnitus, blurring of vision, hot and cold flushes, feelings of weakness, pricking sensation)";						
		$q[8] = "<strong>Cardiovascular symptoms</strong> <br> (Tachycardia, palpitations, pain in chest, throbbing of vessels, fainting feelings, missing beat)";						
		$q[9] = "<strong>Respiratory symptoms</strong> <br> (Pressure or constriction in chest, choking feelings, sighing, dyspnea.)";								
		$q[10] = "<strong>GastroinScreeninginal symptoms </strong><br> (Difficulty in swallowing, wind abdominal pain, burning sensations, abdominal fullness, nausea, vomiting, borborygmi, looseness of bowels, loss of weight, constipation)";						
		$q[11] = "<strong>Genitourinary symptoms </strong><br> (Frequency of micturition, urgency of micturition, amenorrhea, menorrhagia, development of frigidity, premature ejaculation, loss of libido, impotence.)";					
		$q[12] = "<strong>Genitourinary symptoms </strong><br> (Dry mouth, flushing, pallor, tendency to sweat, giddiness, tension headache, raising of hair.)";						
		$q[13] = "<strong>Behavior at interview </strong><br> (Fidgeting, restlessness or pacing, tremor of hands, furrowed brow, strained face, sighing or rapid respiration, facial pallor, swallowing, etc.)";								
?>	

<?php
		echo $this->Form->create('Screening',array('controller'=>'screenings','action'=>'hamilton'));
		echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][form_name]",'value'=>"hamilton"));
		echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][id]",'value'=>$Screenings['Screening']['id']));?>
		
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
 <tr>
 	<thead>
 		<th width="1%" align="center"></th>
	  	<th width="47%"><?php echo __('PATIENT INITIALS'); ?></th>
	  	<th width="29%">&nbsp;</th>
	  	<th width="1%">Score</th>
  	</thead>
 </tr>
 
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
 					<td>
 						<?php echo $this->Form->input('',array('type'=>'radio','options'=>$options,'default'=>$checked,'idd'=>$count,'id'=>'ans_'.$count,'class'=>'ans','legend'=>false,'label'=>true,'name'=>"data[Screening][questions][q$key]"))?>
 					</td>
 				</tr>
 			</table>
 		</td>
 		<td align="center">
 			<span id="score_<?php echo $count;?>"><?php if(isset($checked)) { echo $checked; }?></span>
 		</td>
 	</tr>
 	<?php $count++; } unset($checked);?>
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
			<td><?php echo $this->Html->link(__('Cancel'),array('action' => 'hamilton'),array('escape' => false,'class'=>'blueBtn')); ?></td>
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
		//alert(currentRow);
		$("#score_"+currentRow).html(value);
		
		totalScore = 0 ;
		$(".ans").each(function(index,element ){
			if($(this).attr('checked'))
			totalScore += parseInt($(this).val()) ;
		});
			//console.log(totalScore);
			$("#total").html(totalScore);	
	});
});
</script>
