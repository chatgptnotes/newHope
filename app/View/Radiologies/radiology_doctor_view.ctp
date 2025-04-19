<style>
.patientInfo {
	font-size: 20px;
	font-family: verdana;
	color: darkolivegreen;
	float: left;
	padding-top: 26px ;
}

.radName{
 color:#9E8579 !important;
 font-size: 20px !important;
 font-family: trebuchet MS,Lucida sans,Arial;
}

</style>
<div class="inner_title patientInfo">
		<div style="float: left">
		<?php echo $getBasicData['Patient']['lookup_name']." - ".$getBasicData['Patient']['admission_id'] ;?>
		</div>
		<div style="text-align: center;padding-right: 5%" class="radName">
		<strong> <font><?php echo $radiologyTestName; ?>
		</strong>
		<div style="float: right"><?php echo $this->Html->link(__('Back'), array('action'=>'radDashBoard','?'=>array('conditionalFlag'=>$conditionalFlag)), array('escape' => false,'class' => 'blueBtn'));?></div>
		</div>
</div> 
<p class="ht5"></p>
<div style="float: right;padding-top: 5px;width: 32%"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" align="center">
	
	<tr>

		<td valign="top" width="100%"><?php
		$labID = $this->data['Radiology']['radiology_id'] ;

		?>
			<div class="ht5"></div>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<?php if($radiologist['User']['full_name']!=""){?>
				<tr>

					<td valign="top" align="right" width="20%"><?php echo __('Radiologist  ')?>:</td>
					<td class="tempHead" valign="top"><?php   echo $radiologist['User']['full_name']  ;?>
					</td>

				</tr>
				<?php }?>
				<tr>
					<td valign="top" align="right" style="width: 14%"><?php echo __('View file/record ')?>:</td>
					<td width="50%" style="padding: 0;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<?php 
								 
								echo $this->Form->hidden('radiology_id',array('value'=>$labID));
								echo $this->Form->hidden('patient_id',array('value'=>$patient_id));
								$resultID = isset($doctorNote['id'])?$doctorNote['id']:'' ;
								echo $this->Form->hidden('RadiologyDoctorNote.id',array('value'=>$resultID));
								echo $this->Form->hidden('RadiologyDoctorNote.radiology_id',array('value'=>$labID));
								echo $this->Form->hidden('RadiologyDoctorNote.patient_id',array('value'=>$patient_id));
								if(!isset($data[0]['RadiologyReport']['file_name'])){
						              	  				$display ="none";
						              	  			}else{
						              	  				$display ="block";
						              	  			}
						              	  			?>
								<td  class="tempHead" valign="top" id="icdSlc"   style="display:<?php echo $display ;?>;">
									<?php               	  			 
									foreach($data as $temData){
		              	  					if($temData['RadiologyReport']['file_name']){
		              	  						$id = $temData['RadiologyReport']['id'];
		              	  						echo "<p id="."icd_".$id." style='padding:0px 0px;'>";
		              	  						$replacedText =$temData['RadiologyReport']['file_name'] ;
		              	  						echo $this->Html->link($replacedText,'/uploads/radiology/'.$temData['RadiologyReport']['file_name'],array('escape'=>false,'target'=>'__blank','style'=>'text-decoration:underline;'));
		              	  						echo "</p>";
		              	  					}
		              	  				}
		              	  				?>

								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right"><?php echo __('Notes')?>:</td>

					<td class="tempHead" valign="top"><?php   
					$note = isset($data[0]['RadiologyResult']['note'])?$data[0]['RadiologyResult']['note']:'' ;
					echo nl2br($note);
					?>
					</td>
				</tr>
				<?php  if($data[0]['RadiologyResult']['split']!=""){?>
				<tr>
					<td valign="top" align="right"><?php echo __('No of Slices')?>:</td>
					<td class="tempHead" valign="top"><?php  
					$split = isset($data[0]['RadiologyResult']['split'])?$data[0]['RadiologyResult']['split']:'' ;
					echo $split;
					?>
					</td>
				</tr>
				<?php }?>
				<?php  if($data[0]['RadiologyResult']['img_impression']!=""){?>
				<tr>
					<td valign="top" align="right"><?php echo __('Image Impression')?>:</td>
					<td class="tempHead" valign="top"><?php  
					$img = isset($data[0]['RadiologyResult']['img_impression'])?$data[0]['RadiologyResult']['img_impression']:'' ;
					echo $img;
					?>
					</td>
				</tr>
				<?php }?>
				<?php  if($data[0]['RadiologyResult']['advice']!=""){?>
				<tr>
					<td valign="top" align="right"><?php echo __('Advice')?>:</td>
					<td class="tempHead" valign="top"><?php  
					$advice = isset($data[0]['RadiologyResult']['advice'])?$data[0]['RadiologyResult']['advice']:'' ;
					echo $advice;
					?>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td valign="top" align="right"><?php echo __('Result Publish On'); ?>:</td>


					<td class="tempHead" valign="top"><?php  
					$resultDatVal = isset($data[0]['RadiologyResult']['result_publish_date'])?$this->DateFormat->formatDate2Local($data[0]['RadiologyResult']['result_publish_date'],Configure::read('date_format'),true):'' ;
					echo $resultDatVal;
					?>
					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>

