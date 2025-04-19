<style>
label{
	float:none;
}
.tabularForm th{
	text-align:center;
	</style>

	<div class="inner_title">
	<h3><?php echo __('Generalized Anxiety Disorder 7-item (GAD-7) scale'); ?></h3>
</div>
<div>&nbsp</div>
<?php 
		$options =array('0'=>'Not At All',
						'1'=>'Several Days',
						'2'=>'Over half the days',
						'3'=>'Nearly every days');
?>

<?php 
	    $opt =array('0'=>'Not difficult At All',
						'1'=>'Somewhat difficult',
						'2'=>'Very difficult',
						'3'=>'Extreamely Difficult');
?>

<?php
	$q=array();
	$q[0] = "Feeling nervous, anxious, or on edge";
	$q[1] = "Not being able to stop or control worrying ";
	$q[2] = "Worrying too much about different things";
	$q[3] = "Trouble relaxing";
	$q[4] = "Being so restless that it's hard to sit still";
	$q[5] = "Becoming easily annoyed or irritable";
	$q[6] = "Feeling afraid as if something awful might happen  ";
	
?>
<?php echo $this->Form->create('Screening',array('controller'=>'Screenings','action'=>'gad'))?>
<?php echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][form_name]",'value'=>"gad"))?>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm">
<tr>
	<thead>
		<th width="5%" align="center"><?php echo __('SR.NO'); ?></th>
		<th width="40%"><?php echo __('QUESTIONS'); ?></th>
		<th width="55%"><?php echo __('OPTIONS'); ?></th>
		<th width="10%"><?php echo __('SCORE'); ?></th>

	</thead>
</tr>

<tr>
	<thead>
		<th colspan="4" style="text-align: left" ><?php echo __('Que:-Over the last 2 weeks, how often have you been bothered by any of the following problems?'); ?>
		</th>
	</thead>
</tr>
 <?php $unser = unserialize($Screenings['Screening']['ser_data']); //unserialize data
  //debug($unser);
?>

	<tbody>
		<?php $count = 1; $total = 0; foreach($q as $key=>$q) { ?>
		<tr>
			<td align="center"><?php echo $count;?></td>
			<td width="50%"><?php echo $q;?></td>
			<?php if(isset($unser[q.$key]))
 				{
 					$checked = $unser[q.$key]; 
 					$total = $total + $checked;
 				}
 		?>
			<td width="50%">
				<table>
					<tr>
						<td width="40%"><?php echo $this->Form->input('',array('type'=>'radio','options'=>$options,'idd'=>$count,'id'=>'ans_'.$count,'default'=>$checked,'class'=>'ans','legend'=>false,'name'=>"data[Screening][questions][q$key]"))?>
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

			<td colspan="3" style="text-align: center; font-weight:bold;"><?php echo __('TOTAL');?>
			</td>
			<td align="center" id="total"><?php if(isset($total)) { echo $total; }?></td>
	</tbody>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm">
	<tr>
		<td width="5%" align="center"><?php echo $count;?></td>
		<td width="44%"><?php $str="If you checked off any problems, how difficult have
			these problems made it for you to do your work, take care of things
			at home, or get along with other people?";
          echo __($str);
          ?></td>
          
          <?php if(isset($unser[q7]))
 				{
 					$checked = $unser[q7]; 
 				}
 		?>
		<td width="45%" colspan=1">
			<table>
				<tr>
					<td width="40%"><?php echo $this->Form->input('',array('type'=>'radio','options'=>$opt,'default'=>$checked,'legend'=>false,'name'=>"data[Screening][questions][q7]"))?>
					</td>
				</tr>
			</table>
		</td>

	</tr>
</table>
<div class="clr ht5"></div>
<div class="btns">
	<table>
		<tr>
			<td><?php echo $this->Form->submit(__("Submit"),array('class'=>'blueBtn'));?></td>
			<td><?php echo $this->Html->link(__('Cancel'),array('action' => 'gad'),array('escape' => false,'class'=>'blueBtn')); ?></td>
		</tr>
	</table>
</div>
<div class="clr ht5"></div>
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
			$( ".ans" ).each( function( index, element ){
			
			if($(this).attr('checked'))
			totalScore += parseInt( $( this ).val()) ;
			
			});
			
			console.log(totalScore);
			$("#total").html(totalScore);
			
			});
			
			});
</script>

 
 
 
 
 
 