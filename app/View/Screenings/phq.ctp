<?php// $patient_id = 72; //static value?>

<style>
label {
float: none;
}

.tabularForm th {
text-align: center;
font-size: 14px;
}
</style>

<div class="inner_title">
<h3>
<?php echo __('PATIENT HEALTH QUESTIONNAIRE'); ?>
</h3>
</div>
<div>&nbsp</div>
<?php
$options =array('0'=>'Not At All',
'1'=>'Several Days',
'2'=>'More than half the days',
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
$q[0] = "Little interest or pleasure in doing things";
$q[1] = "Feeling down, depressed , or hopeless";
$q[2] = "Trouble falling or staying asleep, or sleeping too much";
$q[3] = "Feeling tired or having little energy";
$q[4] = "Poor appetite or overeating";
$q[5] = "Feeling bad about yourself- or you are a failure or have let yourself or your family down";
$q[6] = "Trouble concentrating on things, such as reading the newspaper or watching television";
$q[7] = "Moving or speaking so slowly that other people could have noticed. Or the opposite-being so figety or restless that you have been moving around a lot more than usual";
$q[8] = "Thoughts that you would be better off dead, or of hurting yourself";
// $q[9] = "If you checked off any problems, how difficult have these problems made it for you to do your work, take care of things at home, or get along with other people?";


?>
<?php echo $this->Form->create('Screening',array('controller'=>'Screenings','action'=>'phq',$patient_id))?>
<?php echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][form_name]",'value'=>"phq"))?>
<?php echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][id]",'value'=>$Screenings['Screening']['id']));?>
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

<td colspan="4" style="text-align: left; font-size: 14px;font-weight:bold;" ><?php echo __('Que:-Over the last 2 weeks, how often have you been bothered by any of the following problems?'); ?>
</td>

</tr>
<?php $unser = unserialize($Screenings['Screening']['ser_data']); //unserialize data ?>

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
<td style="text-align: center"> <span id="score_<?php echo $count;?>"><?php if(isset($checked)) { echo $checked; }?></span>
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
<td width="44%">If you checked off any problems, how difficult have
these problems made it for you to do your work, take care of things
at home, or get along with other people?</td>
<?php if(isset($unser[q9]))
{
$checked = $unser[q9];
}
?>
<td width="45%" colspan=1">
<table>
<tr>
<td width="40%"><?php echo $this->Form->input('',array('type'=>'radio','options'=>$opt,'default'=>$checked,'legend'=>false,'name'=>"data[Screening][questions][q9]"))?>
</td>
</tr>
</table>
</td>

</tr>
</table>

<div class="btns">
<input type="submit" value="Submit" class="blueBtn" >
<?php echo $this->Html->link(__('Cancel'),array('action' =>'phq'),array('escape' => false,'class'=>'blueBtn')); ?>
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
$( ".ans" ).each( function( index, element ){

if($(this).attr('checked'))
totalScore += parseInt( $( this ).val()) ;

});

//console.log(totalScore);
$("#total").html(totalScore);

});

});
</script>
