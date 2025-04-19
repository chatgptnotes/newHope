<div class="inner_title">
	<h3>EKG Result</h3>
</div>
<p class="ht5"></p>

<!-- billing activity form start here -->
<?php 
echo $this->element('patient_information');
?>
<p class="ht5"></p>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" align="center">
	<tr>
		<th colspan="2"><?php echo __('EKG Reports'); ?>
		</th>
	</tr>
	<tr>

		<td valign="top" width="100%"><?php
		$labID = $this->data['Radiology']['radiology_id'] ;

		?>
			<div class="ht5"></div>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">



				<tr>
					<td valign="top" align="right" width="20%"><?php echo __('View file/record ')?>:</td>
					<td width="50%" style="padding: 0;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="tempHead" valign="top"><?php 
								if(!isset($resultData[0]['EkgResult']['file_name'])){
						              	  				$display ="none";
						              	  			}else{
						              	  				$display ="block";
						              	  			}
						              	  			?>
									<div id="icdSlc"   style="display:<?php echo $display ;?>;">
										<?php               	  			 
										foreach($resultData as $temData){
						              	  					if($temData['EkgResult']['file_name']){
						              	  						$id = $temData['EkgResult']['id'];
						              	  						echo "<p id="."icd_".$id." style='padding:0px 10px;'>";
						              	  						$replacedText =$temData['EkgResult']['file_name'] ;
						              	  						echo $this->Html->link($replacedText,'/uploads/ekg/'.$temData['EkgResult']['file_name'],array('escape'=>false,'target'=>'__blank','style'=>'text-decoration:underline;'));
						              	  						/*  echo $this->Html->link($this->Html->image('/img/icons/cross.png'),array('action'=>'delete_report',$patient_id,$labID,$id),array('escape'=>false,"align"=>"right","id"=>"$id" ,"title"=>"Remove"
						              	  						 ,"style"=>"cursor: pointer;","alt"=>"Remove","class"=>"radio_eraser"),'Are you sure ?');*/
							              	  			        echo "</p>";
						              	  					}
						              	  				}
						              	  				?>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right"><?php echo __('Notes')?>:</td>
					<td width="50%" style="padding: 0;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>

								<td class="tempHead" valign="top"><?php   
								$note = isset($resultData[0]['EkgResult']['note'])?$resultData[0]['EkgResult']['note']:'' ;
								echo nl2br($note);
								?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right"><?php echo __('Result Publish On'); ?>:</td>
					<td width="50%" style="padding: 0;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>

								<td class="tempHead" valign="top"><?php  
								$resultDatVal = isset($resultData[0]['EkgResult']['result_publish_date'])?$this->DateFormat->formatDate2Local($resultData[0]['EkgResult']['result_publish_date'],Configure::read('date_format'),true):'' ;
								echo $resultDatVal;
								?>
								</td>
							</tr>
						</table>
					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>
<p class="ht5"></p>
<p class="ht5"></p>
<div align="right">
	<?php 

	echo $this->Html->link(__('Back'), array('action'=>'ekg_list',$patient_id), array('escape' => false,'class' => 'grayBtn','id'=>'cancel-order-form'));

	?>
</div>


