<style>
#boxspace {border-right: 0.3px solid #384144;
    padding-right: 5px;}
td
{
border-bottom: solid ;
}
</style>

<table width="80%" align="center"  >
<tr>
<td valign="top" width="50%">
<?php echo __("NAUSEA AND VOMITING -- Ask ".'"'."Do you feel sick to your stomach? Have you vomited?".'"'."Observation."); ?><br/>
<?php echo $this->Form->input('nausea_vomiting', array('type'=>'radio','options'=>array('0'=>'no nausea and no vomiting',
		'1'=>'mild nausea with no vomiting',
		'2'=>'','3'=>'',
		'4'=>'intermittent nausea with dry heaves',
		'5'=>'','6'=>''), 'label'=>false,'seperator'=>'')); ?><br/>

</td>

<td valign="top" width="50%">
<?php echo __("TACTILE DISTURBANCES -- Ask Have you any itching, pins and needles sensations, any burning, any numbness, or do you feel bugs crawling on or under your skin? Observation."); ?><br/>
<?php echo $this->Form->input('tactile_disturbance', array('type'=>'radio','options'=>array('0'=>'none',
		'1'=>'very mild itching, pins and needles, burning or numbness',
		'2'=>'mild itching, pins and needles, burning or numbness',
		'3'=>'moderate itching, pins and needles, burning or numbness',
		'4'=>'moderately severe hallucinations',
		'5'=>'severe hallucinations',
		'6'=>'extremely severe hallucinations',
		'7'=>'continuous hallucinations'), 'label'=>false)); ?><br/>

</td>
</tr>

<tr>
<td  valign="top" width="50%"><br/>
<?php echo __("TREMOR -- Arms extended and fingers spread apart. Observation."); ?><br/>
<?php echo $this->Form->input('tremor', array('type'=>'radio','options'=>array('0'=>'no tremor',
		'1'=>'not visible, but can be felt fingertip to fingertip',
		'2'=>'','3'=>'',
		'4'=>"moderate, with patient"."'"."s arms extended",
		'5'=>'','6'=>'',
		'7'=>'severe, even with arms not extended'), 'label'=>false)); ?><br/>

</td>

<td  valign="top" width="50%"><br/>
<?php echo __("AUDITORY DISTURBANCES -- Ask ".'"'."Are you more aware of sounds around you? Are they harsh? Do they frighten you? Are you hearing anything that is disturbing to you? Are you hearing things you know are not there?".'"'." Observation."); ?><br/>
<?php echo $this->Form->input('auditory_disturbances', array('type'=>'radio','options'=>array('0'=>'not present',
		'1'=>'very mild harshness or ability to frighten',
		'2'=>'mild harshness or ability to frighten',
		'3'=>'moderate harshness or ability to frighten',
		'4'=>'moderately severe hallucinations',
		'5'=>'severe hallucinations',
		'6'=>'extremely severe hallucinations',
		'7'=>'continuous hallucinations'), 'label'=>false)); ?><br/>
</td>
</tr>

<tr>
<td  valign="top" width="50%"><br/>
<?php echo __("PAROXYSMAL SWEATS -- Observation."); ?><br/>
<?php echo $this->Form->input('paroxysmal', array('type'=>'radio','options'=>array('0'=>'no sweat visible',
		'1'=>'barely perceptible sweating, palms moist',
		'2'=>'','3'=>'',
		'4'=>"beads of sweat obvious on forehead",
		'5'=>'','6'=>'',
		'7'=>'drenching sweats'), 'label'=>false)); ?><br/>
</td>

<td  valign="top" width="50%"><br/>
<?php echo __("VISUAL DISTURBANCES -- Ask ".'"'."Does the light appear to be too bright? Is its color different? Does it hurt your eyes? Are you seeing anything that is disturbing to you? Are you seeing things you know are not there?".'"'." Observation."); ?><br/>
<?php echo $this->Form->input('visiul_disturbance', array('type'=>'radio','options'=>array('0'=>'not present',
		'1'=>'very mild sensitivity',
		'2'=>'mild sensitivity',
		'3'=>'moderate sensitivity',
		'4'=>'moderately severe hallucinations',
		'5'=>'severe hallucinations',
		'6'=>'extremely severe hallucinations',
		'7'=>'continuous hallucinations'), 'label'=>false)); ?><br/>
</td>
</tr>

<tr>
<td  valign="top" width="50%"><br/>
<?php echo __("ANXIETY -- Ask ".'"'."Do you feel nervous?".'"'." Observation."); ?><br/>
<?php echo $this->Form->input('anxiety', array('type'=>'radio','options'=>array('0'=>'no anxiety, at ease',
		'1'=>'mild anxious',
		'2'=>'','3'=>'',
		'4'=>'moderately anxious, or guarded, so anxiety is inferred',
		'5'=>'','6'=>'',
		'7'=>'equivalent to acute panic states as seen in severe delirium or acute schizophrenic reactions'), 'label'=>false)); ?><br/>

</td>

<td  valign="top" width="50%"><br/>
<?php echo __("HEADACHE, FULLNESS IN HEAD -- Ask ".'"'."Does your head feel different? Does it feel like there is a band around your head?".'"'." Do not rate for dizziness or lightheadedness. Otherwise, rate severity."); ?><br/>
<?php echo $this->Form->input('headache', array('type'=>'radio','options'=>array('0'=>'not present',
		'1'=>'very mild',
		'2'=>'mild',
		'3'=>'moderate',
		'4'=>'moderately severe',
		'5'=>'severe',
		'6'=>'very severe',
		'7'=>'extremely severe'), 'label'=>false)); ?><br/>
</td>
</tr>

<tr>
<td  valign="top" width="50%"><br/>
<?php echo __("Observation."); ?><br/>
<?php echo $this->Form->input('observation', array('type'=>'radio','options'=>array('0'=>'normal activity',
		'1'=>'somewhat more than normal activity',
		'2'=>'','3'=>'',
		'4'=>'moderately fidgety and restless',
		'5'=>'','6'=>'',
		'7'=>'paces back and forth during most of the interview, or constantly thrashes about'), 'label'=>false)); ?><br/>
</td>

<td  valign="top" width="50%"><br/>
<?php echo __("ORIENTATION AND CLOUDING OF SENSORIUM -- Ask ".'"'."What day is this? Where are you? Who am I?".'"'); ?><br/>
<?php echo $this->Form->input('operation_clouding', array('type'=>'radio','options'=>array('0'=>'oriented and can do serial additions',
		'1'=>'cannot do serial additions or is uncertain about date',
		'2'=>'disoriented for date by no more than 2 calendar days',
		'3'=>'disoriented for date by more than 2 calendar days',
		'4'=>'disoriented for place/or person'), 'label'=>false)); ?><br/>
</td>
</tr>
</table>