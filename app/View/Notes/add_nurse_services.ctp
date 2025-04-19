<table class="loading" style="text-align: left; padding: 0px !important;margin: 11px auto 0; " width="99%">
	<tr>
		<td width="100%" valign="top" align="left" style="padding: 2px;" colspan="4">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm">
				<!-- row 1 -->
				<tr>
					<td width="100%" valign="top" align="left" colspan="6">
						<table width="100%" border="0" cellspacing="1" cellpadding="0" id='DrugGroup' style="padding: 0px !important;margin-top: 10px;" class="tabularForm">
							<tr>
								<th  height="20" align="left" valign="top" style="padding-right: 3px;" class="">Drug Name</th>
								<th  height="20" align="left" valign="top" class="">Strength</th>
								<th  height="20" align="left" valign="top" class="" >Dosage</th>
								<th  align="left" valign="top" class="">Dose Form</th>
								<th  height="20" align="left" valign="top" class="">Route</th>
								<th  align="left" valign="top" class="">Frequency</th>
								<th  align="left" valign="top" class="">Days</th>
								<th  align="left" valign="top" class="">Qty</th>
								<th  align="left" valign="top" class="">As Needed (p.r.n)</th>
								<th  align="left" valign="top" class="">Dispense As Written</th>
								<th  align="left" valign="top" class="" >First Dose Date/Time</th>
								<th  align="left" 	valign="top" class="" >Stop Date/Time</th>
								<th  align="left" valign="top" class="">Active</th>
							</tr>
							<?php
							if(isset($getPreviousMedication) && !empty($getPreviousMedication)){
			               		foreach($getPreviousMedication as $i=>$data){
			               			?>
			               	<tr id="DrugGroup<?php echo $i;?>">
								<td align="left" valign="top" style="padding-right: 3px"><?php echo stripslashes($data['NewCropPrescription']['description']); ?></td>
								
								<td align="left" valign="top" style="padding-right: 3px"><?php 
									$strengthArray=Configure :: read('strength');
									echo $data['NewCropPrescription']['dose'] .', '.$strengthArray[$data['NewCropPrescription']['DosageForm']]; ?></td>
								
								<td align="left" valign="top" style="padding-right: 3px"><?php echo $data['NewCropPrescription']['dosageValue'];?></td>
								
	                            <td align="left" valign="top" style="padding-right: 3px"><?php 
		                            $roopArray=Configure :: read('roop');
		                            echo $roopArray[$data['NewCropPrescription']['strength']];?></td>
								
	
								<td align="left" valign="top" style="padding-right: 3px"><?php 
									$route_administrationArray=Configure :: read('route_administration');
									echo $route_administrationArray[$data['NewCropPrescription']['route']];?></td>
	
								<td align="left" valign="top" style="padding-right: 3px"><?php 
									$frequencyArray=Configure :: read('frequency');
									echo $frequencyArray[$data['NewCropPrescription']['frequency']];?></td>
								
								
								<td align="left" valign="top" style="padding-right: 3px"><?php echo $data['NewCropPrescription']['day'];?></td>
	
								<td align="left" valign="top" style="padding-right: 3px"><?php echo $data['NewCropPrescription']['quantity'];?></td>
	
								<td align="center" valign="top" style=""><?php $options = array('1'=>'Yes','0'=>'No');
										echo $options[$data['NewCropPrescription']['prn']];?></td>
	
								<td align="center" valign="top" style=""><?php echo $options[$data['NewCropPrescription']['daw']];?></td>
	
								<td align="center" valign="top" style="padding-right: 3px"><?php echo $this->DateFormat->formatDate2Local($data['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);?></td>
	
								<td align="center" valign="top" style="padding-right: 3px"><?php echo $this->DateFormat->formatDate2Local($data['NewCropPrescription']['stopdose'],Configure::read('date_format'),true);?></td>
	
								<td align="center" valign="top" style=""><?php $options_active = array('1'=>'Yes','0'=>'No');
										echo $options_active[$data['NewCropPrescription']['isactive']];?></td>
							</tr>
							
						<?php } }?>
						</table>
					</td>
				</tr>

                <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			</table>
		</td>
	</tr>
</table>
