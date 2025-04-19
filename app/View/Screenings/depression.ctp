<?php $patient_id = 1234; //static value?> 
<style> label{float:none;} </style>
<div class="inner_title">
 <h3><?php echo __('DEPRESSION SCALE'); ?></h3>
</div>
<?php 
		$options_asc =array('1'=>'A little of the time', '2'=>'Some of the time', '3'=>'Good part of the time', '4'=>'Most of the time');
		$options_desc =array('4'=>'A little of the time','3'=>'Some of the time', '2'=>'Good part of the time',	'1'=>'Most of the time');
		$asc = array(0,2,3,6,7,8,9,12,14,18);	//for ascending options ($options_asc)
		
		//questions
		$q=array();
		$q[0] = "I feel down-hearted and blue";								//asc
		$q[1] = "Morning is when I feel the best";								//desc
		$q[2] = "I have crying spells or feel like it";						//asc
		$q[3] = "I have trouble sleeping at night";							//asc
		$q[4] = "I eat as much as I used to";									//desc
		$q[5] = "I still enjoy sex";											//desc
		$q[6] = "I notice that I am losing weight";							//asc
		$q[7] = "I have trouble with constipation";							//asc
		$q[8] = "My heart beats faster than usual";							//asc
		$q[9] = "I get tired for no reason";								//asc
		$q[10] = "My mind is as clear as it used to be";						//desc
		$q[11] = "I find it easy to do the things I used to";					//desc
		$q[12] = "I am restless and can't keep still";						//asc
		$q[13] = "I feel hopeful about the future";								//desc
		$q[14] = "I am more irritable than usual";							//asc
		$q[15] = "I find it easy to make decisions";							//desc
		$q[16] = "I feel that I am useful and needed";							//desc
		$q[17] = "My life is pretty full";										//desc
		$q[18] = "I feel that others would be better off if I were dead";	//asc
		$q[19] = "I still enjoy the things I used to do";						//desc
?>	

<?php
		echo $this->Form->create('Screening',array('controller'=>'screenings','action'=>'depression',$patient_id));
		echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][form_name]",'value'=>"depression"));
		echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][id]",'value'=>$Screenings['Screening']['id']));?>
		
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
 <tr>
 	<thead>
 		<th width="5%" align="center"></th>
	  	<th width="40%"><?php echo __('PATIENT INITIALS'); ?></th>
	  	<th width="45%">&nbsp;</th>
	  	<th width="10%">Score</th>
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
 					<?php if(in_array($key,$asc)) { ?>
 					<td>
 						<?php echo $this->Form->input('',array('type'=>'radio','options'=>$options_asc,'idd'=>$count,'id'=>'ans_'.$count,'default'=>$checked,'class'=>'ans','legend'=>false,'label'=>true,'name'=>"data[Screening][questions][q$key]"))?>
 					</td>
 					<?php } else {?>
 					<td>
 						<?php echo $this->Form->input('',array('type'=>'radio','options'=>$options_desc,'idd'=>$count,'id'=>'ans_'.$count,'default'=>$checked,'class'=>'ans','legend'=>false,'label'=>true,'name'=>"data[Screening][questions][q$key]"))?>
 					</td>
 					<?php }?>
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
			<td><?php echo $this->Html->link(__('Cancel'),array('action' => 'depression'),array('escape' => false,'class'=>'blueBtn')); ?></td>
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
