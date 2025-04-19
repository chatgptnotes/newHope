<table width="80%" align="center" cellpadding="0" cellspacing="0"
	border="0" class="tbl" style="border: 1px solid #3e474a;">
	<!-- <tr>
                              	<th colspan="2">Patient Information</th>
                              </tr> -->
	<?php //debug($patient);//exit;?>
	<tr>
		<td width="50%" valign="top">
			<table width="100%" border="0" cellspacing="2" cellpadding="5">
				<tr>
					<td></td>
					<td valign="top"><?php echo __('Patient ID')?></td>
					<td>:</td>
					<td align="left" valign="top"><?php echo $patient['Patient']['patient_id'] ;?>
					
					</td>
				</tr>
				<tr>
					<td></td>
					<td valign="top"><?php echo __('Patient Name')?>
					</td>
					<td>:</td>
					<td align="left" valign="top" style="padding-bottom: 10px;"><?php echo  $complete_name  =  $patient['Patient']['lookup_name']  ;?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td valign="top">Sex / Age</td>
					<td>:</td>
					<td align="left" valign="top" style="padding-bottom: 10px;"><?php echo ucfirst($sex);?>
						/ <?php echo ucfirst($age)?>
					</td>
				</tr>
				
				<tr>
					<td></td>
					<td valign="top">Phone No</td>
					<td>:</td>
					<td align="left" valign="top" style="padding-bottom: 10px;"><?php echo $patient['Person']['mobile'];?>
					</td>
				</tr>
			
				<?php if($patient['Patient']['admission_type']=="IPD"){?>
				<tr>
					<td></td>
					<td valign="top">Ward /Room</td>
					<td>:</td>
					<td align="left" valign="top" style="padding-bottom: 10px;"><?php echo ucfirst($wardInfo['Ward']['name']) ;?>
						/ <?php echo ucfirst($wardInfo['Room']['name']) ;?>
					</td>
				</tr>
				<?php }?>
				<?php if($patient['Patient']['admission_type']=="OPD"){?>
				<tr>
					<td></td>
					<td valign="top"><?php echo __('Token No')?></td>
					<td>:</td>
					<td align="left" valign="top" style="padding-bottom: 10px;"><?php echo ucfirst($wardInfo['Ward']['name']) ;?>
						/ <?php echo ucfirst($wardInfo['Room']['name']) ;?>
					</td>
				</tr>
				<?php }?>
			</table>
		</td>

		<td width="50%" valign="top">
			<table align="right" width="100%" border="0" cellspacing="2"
				cellpadding="5">
				<tr>
					<td style="float: right" valign="top" id="boxSpace3">Consultant</td>
					<td>:</td>
					<td valign="top"><?php echo "Dr.".ucfirst($treating_consultant[0]['fullname']);?>/<?php echo $patient['Department']['name'] ;?>
					</td>
				</tr>
				<tr>
					<td style="float: right" valign="top" id="boxSpace3"><?php
								if($patient['Patient']['admission_type']=="IPD"){
			                    echo __('Registration Date');
                                }else{
								echo __('Visit Date');
			                         }?>
			        </td>
					<td>:</td>
					<td valign="top" style="padding-bottom: 10px;"><?php echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),false)?>
					</td>
				</tr>
				<tr>
					<td style="float: right" valign="top" id="boxSpace3"><?php echo __('Receipt Time')?></td>
					<td>:</td>
					<td valign="top" style="padding-bottom: 10px;"><?php echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true)?>
					</td>
				</tr>
				<tr>
					<td style="float: right" valign="top" id="boxSpace3"><?php echo __('Patient Type')?></td>
					<td>:</td>
					<td valign="top" style="padding-bottom: 10px;"><?php echo $patient['TariffStandard']['name'];?>
					</td>
				</tr>
				<?php if($patient['Patient']['admission_type']=="IPD"){?>
				<tr>
					<td style="float: right" valign="top" id="boxSpace3">Bed No</td>
					<td>:</td>

					<td align="left" valign="top" style="padding-bottom: 10px;"><?php echo $wardInfo['Room']['bed_prefix'].$wardInfo['Bed']['bedno'] ;?>
					</td>
				</tr>
				<?php }?>
			</table>
		</td>


	</tr>
</table>
