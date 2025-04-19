<?php $patient_id = 10; //static value?> 

<div class="inner_title">
	<h3>
		<?php echo __('Alcohol Use Disorders Identification Screening (AUDIT)'); ?>
	</h3>
</div>

<style>
label{
float:none;
}
</style>
<?php 

	//for question no 2.i.e 7th in array	
	$optionsTw =array('0'=>'1 or 2','1'=>'3 or 4','2'=>'5 or 6','3'=>'7 to 9','4'=>'10 or more');
	
	//for Question 8 - 9	
	$optionsTwo =array('0'=>'No','2'=>'Yes, but not in the last year','4'=>'Yes, during the last year');
	
	//for other 0-6  questions	
	$options =array('0'=>'Never','1'=>'Monthly or less','2'=>'Two to four times a month','3'=>'Two to three times per week','4'=>'Four or more times per week');
	
	$opt = array(0,1,2,3,4,5,6);
	$opt1 = array(7);
	$opt2 = array(8,9);
	//for Questions
	$q=array();
	$q[0] = "How often do you have a drink containing alcohol? ";
	$q[1] = "How often do you have six or more drinks on one occasion? ";
	$q[2] = "How often during the last year have you found that you were not able to stop drinking once you had started? ";
	$q[3] = "How often during the last year have you failed to do what was normally expected from you because of drinking? ";
	$q[4] = "How often during the last year have you needed a first drink in the morning to get yourself going after a heavy drinking session? ";
	$q[5] = "How often during the last year have you had a feeling of guilt or remorse after drinking? ";
	$q[6] = "How often during the last year have you been unable to remember what happened the night before because you had been drinking? ";
	$q[7]= "How many drinks containing alcohol do you have on a typical day when you are drinking? ";
	$q[8] = "Have you or someone else been injured as a result of your drinking? ";
	$q[9] = "Has a relative or friend, or a doctor or other health worker, been concerned about your drinking or suggested you cut down?";
	
?>


<?php
		echo $this->Form->create('Screening',array('controller'=>'Screenings','action'=>'audit',$patient_id));
		echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][form_name]",'value'=>"audit"));
		echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][id]",'value'=>$Screenings['Screening']['id']));
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
 <tr>
 	<thead>
 		<th width="3%" align="center"></th>
	  	<th width="27%"><?php echo __('Identification Screening'); ?></th>
	  	<th width="70%">&nbsp;</th>
	  	<th width="1%">Score</th>
  	</thead>
 </tr>
 
 <p class="ht5"></p>  

 <?php 
 	$unser = unserialize($Screenings['Screening']['ser_data']); //unserialize data
  //debug($unser);
 ?>
 
 <tbody>
 <?php $i = 1; $total = 0;
 		foreach($q as $key=>$q) { 
 ?>
 	<tr>
 		<td align="center" width="3%"><?php echo $i;?></td>
 		<td><?php echo $q;?></td>
 		<?php if(isset($unser[q.$key]))
 				{
 					$checked = $unser[q.$key]; 	
 				}
 		?>
 		<td>
 			<table align="center" width="95%">
 				<tr>
 					<?php if(in_array($key,$opt)) { ?>
 					<td>
 						<?php 
 							echo $this->Form->input('',array('type'=>'radio','options'=>$options,'idd'=>$i,'id'=>'ans_'.$i,'default'=>$checked,
							'class'=>'ans','legend'=>false,'name'=>"data[Screening][questions][q$key]"));
 						?>
 					</td>
 					<?php }
 						 if(in_array($key,$opt1)) {?>
 					<td>
 						<?php 
 							echo $this->Form->input('',array('type'=>'radio','options'=>$optionsTw,'idd'=>$i,'id'=>'ans_'.$i,'default'=>$checked,
							'class'=>'ans','legend'=>false,'name'=>"data[Screening][questions][q$key]"));
 						?>
 					</td>	
 					 <?php }
 						 if(in_array($key,$opt2)) {?>
 					<td>
 						<?php 
 							echo $this->Form->input('',array('type'=>'radio','options'=>$optionsTwo,'idd'=>$i,'id'=>'ans_'.$i,'default'=>$checked,
							'class'=>'ans','legend'=>false,'name'=>"data[Screening][questions][q$key]"));
 						?>
 					</td> 
 					<?php } ?>	 
 				</tr>
 			</table>
 		</td>
 		<td align="center">
 			<span id="score_<?php echo $i;?>">
	 			<?php if(isset($checked)) { 
	 					echo $checked; 
	 				  }
	 			?>
 			</span>
 		</td>
 	</tr>
 <?php 
 		$i++; 
 		$total = $total + $checked;
		}
 ?>
 	<tr>
 		<td colspan="3" align="right"><?php echo __('Total'); ?></td>
		<td align="center" id="total"><?php echo $total ?></td>
 	</tr>
 </tbody>
</table>
<div class="btns">
	<table>
		<tr>
			<td><?php echo $this->Form->submit(__("Submit"),array('class'=>'blueBtn'));?></td>
			<td><?php echo $this->Html->link(__('Cancel'),array('action' => 'audit'), array('escape' => false,'class'=>'blueBtn')); ?></td>
		</tr>
	</table>
</div>
<?php echo $this->Form->end();?>

 <script>
 $(document).ready(function(){
		$('.ans').click(function()
		{
			currentRow = $(this).attr('idd') ; 					// It will hold 
			value = $(this).val();
			//alert(currentRow);
			$("#score_"+currentRow).html(value);
			totalScore = 0 ;
			$( ".ans" ).each( function( index, element ){
				if($(this).attr('checked'))
				totalScore += parseInt( $( this ).val()) ;
			});
			//console.log(totalScore);
			$("#total").html(totalScore);
		});
	});
 </script>
