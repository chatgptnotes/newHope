<?php  
/* echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js',
 'jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css',
		'home-slider.css','ibox.css','jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));
 */?>
<?php echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
		'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min',
		'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0',
		'jquery-ui-1.8.5.custom.min.js'));
echo $this->Html->css(array('jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));

if($status == "success"){
	?>
<script> 
		//alert("CCDA generated successfully"); 
		jQuery(document).ready(function() { 
			//parent.location.reload(true);
				parent.$.fancybox.close(); 
 
		});
		</script>
<?php   } ?>

<?php echo $this->Form->create('AlcohalAssesment',array('id'=>'AlcohalAssesment')); ?>

<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Clinical Institute Withdrawal Assessment of Alcohol Scale, Revised (CIWA-Ar)', true); ?>
	</h3>
	<span style="padding-right:20px"><?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn submit','div'=>false, 'id' => 'submit_alcohal_assesment')); ?></span>
</div>

<table width="100%" align="center" class="table_format">
	<tr>
		<?php echo $this->Form->input('patient_id',array('type'=>'hidden','value'=>$pid));
		echo $this->Form->hidden('id');
		?>
		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><?php echo $this->Form->input('patient_id',array('type'=>'hidden','value'=>$pid));?><br />
			<?php echo __("NAUSEA AND VOMITING -- Ask ".'"'."Do you feel sick to your stomach? Have you vomited?".'"'."Observation."); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('nausea_vomiting', array('type'=>'radio','id'=>'radio_one','class' => 'radVal  count one_count',
		'options'=>array('0'=>'0 no nausea and no vomiting',
		'1'=>'1 mild nausea with no vomiting',
		'2'=>'2',
		'3'=>'3',
		'4'=>'4 intermittent nausea with dry heaves',
		'5'=>'5',
		'6'=>'6',
		'7'=>'7 constant nausea, frequent dry heaves and vomiting'
		), 'label'=>false,'seperator'=>'', 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />

		</td>

		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><br /> <?php echo __("TACTILE DISTURBANCES -- Ask Have you any itching, pins and needles sensations, any burning, any numbness, or do you feel bugs crawling on or under your skin? Observation."); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('tactile_disturbance', array('type'=>'radio','id'=>'radio_two','class' => 'count',
		'options'=>array('0'=>'0 none',
		'1'=>'1 very mild itching, pins and needles, burning or numbness',
		'2'=>'2 mild itching, pins and needles, burning or numbness',
		'3'=>'3 moderate itching, pins and needles, burning or numbness',
		'4'=>'4 moderately severe hallucinations',
		'5'=>'5 severe hallucinations',
		'6'=>'6 extremely severe hallucinations',
		'7'=>'7 continuous hallucinations'), 'label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />

		</td>
	</tr>

	<tr>
		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><br /> <?php echo __("TREMOR -- Arms extended and fingers spread apart. Observation."); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('tremor', array('type'=>'radio','id'=>'radio_three','class' => 'count',
		'options'=>array('0'=>'0 no tremor',
		'1'=>'1 not visible, but can be felt fingertip to fingertip',
		'2'=>'2',
		'3'=>'3',
		'4'=>"4 moderate, with patient"."'"."s arms extended",
		'5'=>'5',
		'6'=>'6',
		'7'=>'7 severe, even with arms not extended'), 'label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />

		</td>

		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><br /> <?php echo __("AUDITORY DISTURBANCES -- Ask ".'"'."Are you more aware of sounds around you? Are they harsh? Do they frighten you? Are you hearing anything that is disturbing to you? Are you hearing things you know are not there?".'"'." Observation."); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('auditory_disturbances', array('type'=>'radio','id'=>'radio_four','class' => 'count',
		'options'=>array('0'=>'0 not present',
		'1'=>'1 very mild harshness or ability to frighten',
		'2'=>'2 mild harshness or ability to frighten',
		'3'=>'3 moderate harshness or ability to frighten',
		'4'=>'4 moderately severe hallucinations',
		'5'=>'5 severe hallucinations',
		'6'=>'6 extremely severe hallucinations',
		'7'=>'7 continuous hallucinations'), 'label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />
		</td>
	</tr>

	<tr>
		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><br /> <?php echo __("PAROXYSMAL SWEATS -- Observation."); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('paroxysmal_sweats', array('type'=>'radio','id'=>'radio_five','class' => 'count',
		'options'=>array('0'=>'0 no sweat visible',
		'1'=>'1 barely perceptible sweating, palms moist',
		'2'=>'2',
		'3'=>'3',
		'4'=>"4 beads of sweat obvious on forehead",
		'5'=>'5',
		'6'=>'6',
		'7'=>'7 drenching sweats'), 'label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />
		</td>

		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><br /> <?php echo __("VISUAL DISTURBANCES -- Ask ".'"'."Does the light appear to be too bright? Is its color different? Does it hurt your eyes? Are you seeing anything that is disturbing to you? Are you seeing things you know are not there?".'"'." Observation."); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('visiul_disturbance', array('type'=>'radio','id'=>'radio_six','class' => 'count',
		'options'=>array('0'=>'0 not present',
		'1'=>'1 very mild sensitivity',
		'2'=>'2 mild sensitivity',
		'3'=>'3 moderate sensitivity',
		'4'=>'4 moderately severe hallucinations',
		'5'=>'5 severe hallucinations',
		'6'=>'6 extremely severe hallucinations',
		'7'=>'7 continuous hallucinations'), 'label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />
		</td>
	</tr>

	<tr>
		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><br /> <?php echo __("ANXIETY -- Ask ".'"'."Do you feel nervous?".'"'." Observation."); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('anxiety', array('type'=>'radio','id'=>'radio_seven','class' => 'count',
		'options'=>array('0'=>'0 no anxiety, at ease',
		'1'=>'1 mild anxious',
		'2'=>'2',
		'3'=>'3',
		'4'=>'4 moderately anxious, or guarded, so anxiety is inferred',
		'5'=>'5',
		'6'=>'6',
		'7'=>'7 equivalent to acute panic states as seen in severe delirium or acute schizophrenic reactions'), 'label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />

		</td>

		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><br /> <?php echo __("HEADACHE, FULLNESS IN HEAD -- Ask ".'"'."Does your head feel different? Does it feel like there is a band around your head?".'"'." Do not rate for dizziness or lightheadedness. Otherwise, rate severity."); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('headache_fullness', array('type'=>'radio','id'=>'radio_eight','class' => 'count',
		'options'=>array('0'=>'0 not present',
		'1'=>'1 very mild',
		'2'=>'2 mild',
		'3'=>'3 moderate',
		'4'=>'4 moderately severe',
		'5'=>'5 severe',
		'6'=>'6 very severe',
		'7'=>'7 extremely severe'), 'label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />
		</td>

	</tr>

	<tr>
		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><br /> <?php echo __("Observation."); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('observation', array('type'=>'radio','id'=>'radio_nine','class' => 'count',
		'options'=>array('0'=>'0 normal activity',
		'1'=>'1 somewhat more than normal activity',
		'2'=>'2',
		'3'=>'3',
		'4'=>'4 moderately fidgety and restless',
		'5'=>'5',
		'6'=>'6',
		'7'=>'7 paces back and forth during most of the interview, or constantly thrashes about'), 'label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />
		</td>

		<td valign="top" width="50%"
			style="border-bottom: solid; font-size: 13px;"><br /> <?php echo __("ORIENTATION AND CLOUDING OF SENSORIUM -- Ask ".'"'."What day is this? Where are you? Who am I?".'"'); ?><br />
			<?php echo'<ul style="list-style:none">';
			echo $this->Form->input('operation_clouding', array('type'=>'radio','id'=>'radio_ten','class' => 'count var_eight',
		'options'=>array('0'=>'0 oriented and can do serial additions',
		'1'=>'1 cannot do serial additions or is uncertain about date',
		'2'=>'2 disoriented for date by no more than 2 calendar days',
		'3'=>'4 disoriented for date by more than 2 calendar days',
		'4'=>'4disoriented for place/or person'), 'label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>'; ?><br />
		</td>
	</tr>
	<tr>
		<td align="right" valign="top"><br /> <br /> <?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn submit','div'=>false, 'id' => 'submit_alcohal_assesment')); ?>
		</td>
		<td align="right"><?php  echo __('Total CIWA-Ar Score');echo $this->Form->input('add',array('type'=>'text','readonly'=>'readonly','id'=>'total', 'label'=>false,'div'=>false,'value'=>$this->request->data['AlcohalAssesment']['total_score']));?><br />
			<?php  //echo __("Rater"."'"."s Initials");echo $this->Form->input('rate',array('type'=>'text','readonly'=>'readonly', 'label'=>false,'div'=>false));?><br />
			<?php  echo __('Maximum Possible Score 67');?>
		</td>
	</tr>


	<tr>
		<td><br /> <br /> <?php //echo $this->Html->link(__('Back'),array($this->request->referer()), array('class'=>'blueBtn','div'=>false)); ?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>

<script>







			$(document).ready(function(){
				
			jQuery("#AlcohalAssesment").validationEngine({
				validateNonVisibleFields: true,
				updatePromptsPosition:true,
			});

			
			$('.submit').click(function() { 
			var validatePerson = jQuery("#AlcohalAssesment").validationEngine('validate');
				if (validatePerson){
					$(this).css('display', 'none');
				}
			var total=document.getElementById("total").value;
				$( '#alcholFillInfo', parent.document ).val(total);
				$( '#alcholFillInfo', parent.document ).focus();
			});
			
				$('.count').click(function (){
					var checkedValue = 0;
					 $("#AlcohalAssesment :checked").each(function () {
						 checkedValue += parseInt($(this).val());
			         });
			         $("#total").val(checkedValue);
				});
			
			});
</script>


