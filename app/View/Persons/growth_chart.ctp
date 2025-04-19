
<style>
.row_action img {
	float: inherit;
}
</style>
<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
									'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>
<div class="inner_title" style="padding-bottom: 10px;">
	<?php #pr($data);exit;

$complete_name  = ucfirst($patient[0]['Patient']['lookup_name'])  ;
//echo __('Set Appoinment For-')." ".$complete_name;
?>
	<h3>
		&nbsp;
		<?php echo __('BMI Chart Information -')." ".$complete_name ?>
	</h3>
	<span><?php //echo $this->Html->link(__('Back'),array(), array('escape' => false,'class'=>'blueBtn back')); ?>
		<input type="button" name="Back" value="Back" class="blueBtn goBack">
	</span>


</div>

<?php //debug($patient);
	 
?>

<?php 
		//$this->DateFormat->dateDiff($patient['Person']['dob'],$data['BmiResult']['created_time']);
		if($patient[0]['Patient']['age'] >=0 && $patient[0]['Patient']['age']<=3)
	   							{ ?>
				<div class="inner_left">
				<div class="clr"></div>
				<div id="fun_btns">
				<table>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><?php
								if(strToLower($patient[0]['Person']['sex'])=='female')
									{
								echo $this->Html->link(__('Head Circumference Chart'),array("action"=>"bmi_infants_headcircumference_female",$id),
	   										array('escape' => false,'class'=>'blueBtn'));
									}
								else{
	   									echo $this->Html->link(__('Head Circumference Chart'),array("action"=>"bmi_infants_headcircumference_male",$id),
	   											array('escape' => false,'class'=>'blueBtn'));
	   								}
	   								?>
						</td>
					</tr>
					<tr>
						<td><br /> <?php if(strToLower($patient[0]['Person']['sex'])=='female')
								{
									echo $this->Html->link(__('Length for Age'),array("action"=>"bmi_infants_lenghtforage_female",$id),
	   																    array('escape' => false,'class'=>'blueBtn'));
								}
							else{
									echo $this->Html->link(__('Length for Age Chart'),array("action"=>"bmi_infants_lengthforage_male",$id),
													array('escape' => false,'class'=>'blueBtn'));
	   							}
	   								?>
						</td>
					</tr>
					<tr>
						<td><br /> <?php
										if(strToLower($patient[0]['Person']['sex'])=='female')
										{
											echo $this->Html->link(__('Weight for Age'),array("action"=>"bmi_infants_weightforage",$id),
							   																    array('escape' => false,'class'=>'blueBtn'));
										}
										else {
												echo $this->Html->link(__('Weight for Age'),array("action"=>"bmi_infants_weightforage_male",$id),
							   							array('escape' => false,'class'=>'blueBtn'));
	   										  }
	   								?>
						</td>
					</tr>
					<tr>
						<td><br /> <?php
										if(strToLower($patient[0]['Person']['sex'])=='female')
										{
											echo $this->Html->link(__('Weight for Length'),array("action"=>"bmi_infants_weightforlength_female",$id),
	   																    array('escape' => false,'class'=>'blueBtn'));
										}
									else {
											echo $this->Html->link(__('Weight for Length'),array("action"=>"bmi_infants_weightforlength_male",$id),
	   										array('escape' => false,'class'=>'blueBtn'));
	   																}
	   																?>
						</td>
					</tr>
				</table>
			</div>
			</div>
					<?php }
							elseif($patient[0]['Patient']['age'] >=2 && $patient[0]['Patient']['age']<=20)
							{ ?>
						<div class="inner_left">

						<div class="clr"></div>
						<div id="fun_btns">
						<table>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td><?php 
				if(strToLower($patient[0]['Person']['sex'])=='female')
				{
					echo $this->Html->link(__('BMI Chart'),array("action"=>"bmi_chart_female",$id),
								    array('escape' => false,'class'=>'blueBtn'));
				}
				else{
									echo $this->Html->link(__('Bmi chart'),array("action"=>"bmi_chart_male",$id),
									array('escape' => false,'class'=>'blueBtn'));
								}
								?>
				</td>
			</tr>
			<tr>
				<td><br /> <?php if(strToLower($patient[0]['Person']['sex'])=='female')
				{
					echo $this->Html->link(__('Stature for Age'),array("action"=>"bmi_statureforage_female",$id),
								    array('escape' => false,'class'=>'blueBtn'));
				}
				else{
									echo $this->Html->link(__('Stature for Age'),array("action"=>"bmi_statureforage_male",$id),
									array('escape' => false,'class'=>'blueBtn'));
								}
								?>
				</td>
			</tr>
			<tr>
				<td><br /> <?php
				if(strToLower($patient[0]['Person']['sex'])=='female')
				{
					echo $this->Html->link(__('Weight for Age'),array("action"=>"bmi_weightforage_female",$id),
								    array('escape' => false,'class'=>'blueBtn'));
				}
				else {
										echo $this->Html->link(__('Weight for Age'),array("action"=>"bmi_weightforage_male",$id),
		array('escape' => false,'class'=>'blueBtn'));
								}
								?>
							</td>
						</tr>
						</table>
					</div>
				</div>
<?php  } 
elseif($patient[0]['Patient']['age']>20)
   										{?>
<div class="inner_left">

	<div class="clr"></div>
	<div id="fun_btns">
		<table>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php 

				echo $this->Html->link(__('Bmi chart'),array("action"=>"bmi_chart",$id),
								    array('escape' => false,'class'=>'blueBtn'));

							?>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php }?>



<div class="clr"></div>
<div class="inner_left">
	<div class="inner_title">
		<BR>
		<h3>

			<!--  <span style="float: right;"> <?php		
			//           echo $this->Html->link(__('New Encounter'), array('controller' => 'patients', 'action' => 'add', $id, 'submitandregister' => 1), array('escape' => false,'class'=>'blueBtn'));
			//echo $this->Html->link(__('New Encounter') ,"/patients/add/".$id, 'submitandregister' => 1,array('class'=>'blueBtn','escape' => false));

			?> <a href="#" id="pres">Show BMI Growth Chart </a> <?php

			//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
			?>
			</span>-->
		</h3>
		<div class="clr"></div>
	</div>

</div>
<script>
	$('#pres')
			.click(
					function() {
						//	var patient_id = $('#selectedPatient').val();
						
						$
								.fancybox({
									'width' : '70%',
									'height' : '90%',
									'autoScale' : true,
									'transitionIn' : 'fade',
									'transitionOut' : 'fade',
									'type' : 'iframe',
									'onComplete' : function() {
										$("#allergies").css({
											top : '20px',
											bottom : auto,
											position : absolute
										});
									},
									<?php if($patient_details['Person']['sex']=='Female' || $patient_details['Person']['sex']=='female')
									{?>
									'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_chart_female",$id)); ?>"
									<?php }
									else 
									{?>
									'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_chart_male",$id)); ?>"
									<?php }?>
								});

					});
	
	$(document).ready(function(){     
		$('.goBack').click(function(){         parent.history.back();         return false;     }); });
	</script>
