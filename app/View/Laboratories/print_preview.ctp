<div style="float: right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
<div style="margin-top: 90px; text-align: center;">
	<h3><?php echo "<strong>".ucfirst($testGroup)."</strong>";?></h3>
	<!--
    <h3><?php echo "Report on "." : <strong>".$test_atrributes[0]['Laboratory']['name']."</strong>";?></h3>
-->
</div>
<!--<div style="float:right;" >
  <h3><?php echo "Result"." :<strong>".$this->DateFormat->formatDate2Local($test_atrributes[0]['LaboratoryResult'][0]['modify_time'],Configure::read('date_format'),true)."</strong>";?></h3>
</div>

              
                 -->
<p class="ht5"></p>
<div>&nbsp;</div>
<table width="100%" border="0" cellspacing="1" cellpadding="3"
	class="tbl">
					<?php
					if (! empty ( $testOrder )) {
						$customLabels = unserialize ( $testOrder ['LaboratoryTestOrder'] ['dynamic_labels'] );
						$customValues = unserialize ( $testOrder ['LaboratoryTestOrder'] ['dynamic_values'] );
						$newHtml = '<tr>';
						$count = 0;
						foreach ( $customLabels as $key => $label ) {
							if (! empty ( $label )) {
								if (($count % 2) == 0 && ($count != 0)) {
									$newHtml .= '</tr><tr>';
								}
								$newHtml .= '<td width="150"><strong>' . ucwords ( $label ) . ':</strong></td>
												         <td width="300" align="left">' . ucfirst ( $customValues [$key] ) . '</td>';
								$count ++;
							}
						}
						$newHtml .= '</tr>';
						echo $newHtml;
					}
					?>
					          <tr>
		<td width="107"><strong>Name:</strong></td>
		<td width="327" align="left"><?php echo $patient[0]['lookup_name'];?></td>
		<td><strong>Reg ID:</strong></td>
		<td><?php echo $patient['Patient']['admission_id'];?></td>
	</tr>
	<tr>
		<td valign="top"><strong>Address:</strong></td>
		<td><?php echo $address;?></td>
		<td align="left" valign="top"><strong>Age/Sex:</strong></td>
		<td align="left" valign="top"><?php echo $patient['Patient']['age']." Yrs / ".ucfirst($patient['Patient']['sex']);?></td>
	</tr>
	<tr>
		<td valign="top"><strong>Refer By:</strong></td>
		<td><?php echo $treating_consultant[0]['fullname'] ;?></td>
		<td align="left" valign="top"><strong>Date:</strong></td>
		<td align="left" valign="top"><?php echo $this->DateFormat->formatDate2Local($test_atrributes[0]['LaboratoryResult'][0]['modify_time'],Configure::read('date_format'));?></td>
	</tr>
	<tr>
		<td width="107"><strong>Specimen ID: </strong></td>
		<td width="327"><?php echo strtoupper($token['LaboratoryToken']['sp_id']); ?></td>
		<td width="107"><strong>Accession ID: </strong></td>
		<td width="327"> <?php echo strtoupper($token['LaboratoryToken']['ac_id']);?></td>
	</tr>
</table>
<div class="clr ht5">&nbsp;</div>
<div class="clr ht5">&nbsp;</div>
<table width="100%" cellpadding="3" cellspacing="1" border="0">  
	                      
	                     	<?php
																							
																							// loop through all attributes of selected test
																							
																							$statusArr = array (
																									'normal' => 'Normal',
																									'abnormal' => 'Abnormal' 
																							);
																							
																							if (isset ( $test_atrributes )) {
																								
																								foreach ( $test_atrributes as $k => $data ) {
																									
																									$parameterData = $data ['LaboratoryParameter'];
																									$catData = $data ['LaboratoryCategory'];
																									$resultData = $data ['LaboratoryResult'];
																									if ($test_atrributes [$k] ['LaboratoryParameter'] [0] ['type'] == 'numeric' && $test_atrributes [$k - 1] ['LaboratoryParameter'] [0] ['type'] != 'numeric') {
																										?>
	                     				 <tr id="catId<?php echo $k ;?>>">
		<th style="text-align: left;">TEST NAME</th>
		<th width="250" style="text-align: left;"><strong>OBSERVED VALUE</strong></th>
		<th width="120" style="text-align: center;"><strong>NORMAL RANGE</strong></th>
		<th width="90" style="text-align: center;"><strong>UNITS</strong></th>
		<th width="90" style="text-align: center;"><strong>INTERPRETATION</strong></th>
	</tr>
				                     	 <?php
																									}
																									echo "<tr><th align='left'>";
																									$catId = $catData ['id'];
																									echo "</th></tr>";
																									$separator = true;
																									foreach ( $parameterData as $key => $dataKey ) {
																										if ($dataKey ['type'] == 'text' && $separator) {
																											echo "<tr><td style='text-align:center;' colspan='5'>&nbsp;</td></tr>";
																											$separator = false;
																										}
																										echo "<tr>";
																										echo "<td width='40%'>" . $dataKey ['name'] . "</td>";
																										$resultId = isset ( $resultData [$key] ['id'] ) ? $resultData [$key] ['id'] : '';
																										$resultText = isset ( $resultData [$key] ['text'] ) ? $resultData [$key] ['text'] : '';
																										$resultValue = isset ( $resultData [$key] ['value'] ) ? $resultData [$key] ['value'] : '';
																										$resultStatus = isset ( $resultData [$key] ['status'] ) ? $resultData [$key] ['status'] : '';
																										
																										if ($resultStatus == 'ABNORMAL') {
																											$color = 'red';
																										} else {
																											$color = '';
																										}
																										if ($dataKey ['type'] == 'text') {
																											echo "<td colspan='4' style='text-align:left;'>";
																											echo $resultText;
																											echo "</td>";
																										} else {
																											if ($dataKey ['by_gender_age'] == 'gender') { // by gender
																												if (strtolower ( $sex ) == 'male') {
																													$lower = $dataKey ['by_gender_male_lower_limit'];
																													$upper = $dataKey ['by_gender_male_upper_limit'];
																												} else { // female
																													$lower = $dataKey ['by_gender_female_lower_limit'];
																													$upper = $dataKey ['by_gender_female_upper_limit'];
																												}
																											} else { // by age
																												$foundRange = false;
																												if ($dataKey ['by_age_less_years'] == 1) {
																													if ($age < $dataKey ['by_age_num_less_years']) {
																														$lower = $dataKey ['by_age_num_less_years_lower_limit'];
																														$upper = $dataKey ['by_age_num_less_years_upper_limit'];
																														$foundRange = true;
																													}
																												}
																												if ($dataKey ['by_age_more_years'] == 1 && ! ($foundRange)) {
																													if ($age > $dataKey ['by_age_num_more_years']) {
																														$lower = $dataKey ['by_age_num_gret_years_lower_limit'];
																														$upper = $dataKey ['by_age_num_gret_years_upper_limit'];
																														$foundRange = true;
																													}
																												}
																												if ($dataKey ['by_age_between_years'] == 1 && ! ($foundRange)) {
																													if (($age >= $dataKey ['by_age_between_num_less_years']) && ($age <= $dataKey ['by_age_between_num_gret_years'])) {
																														$lower = $dataKey ['by_age_between_years_lower_limit'];
																														$upper = $dataKey ['by_age_between_years_upper_limit'];
																														$foundRange = true;
																													}
																												}
																											}
																											echo "<td style='text-align:left;color:$color'>";
																											echo $resultValue;
																											echo "</td>";
																											if (! empty ( $lower ) && (empty ( $upper ))) {
																												echo "<td style='text-align:center;'>" . "Greater Than " . $lower . "</td>";
																											} else if (empty ( $lower ) && (! empty ( $upper ))) {
																												echo "<td style='text-align:center;'>" . "Up To " . $upper . "</td>";
																											} else {
																												echo "<td style='text-align:center;'>" . $lower . " – " . $upper . "</td>";
																											}
																											echo "<td style='text-align:center;'>" . $dataKey ['unit'] . "</td>";
																											echo "<td style='text-align:center;color:$color''>";
																											echo $resultStatus;
																											echo "</td>";
																										}
																										echo "</tr>";
																									}
																									echo "<tr><td colspan='5' style='font-size:9px;'><i>";
																									echo strtoupper ( $catData ['category_name'] );
																									echo "</tr></td></i>";
																									echo "<tr><td colspan='5' style='border-top:1px solid black;'>&nbsp;</td></tr>";
																								}
																							}
																							?>  
	                   </table>
<div class="clr">&nbsp;</div>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
		                   		<?php if(!empty($testOrder['LaboratoryTestOrder']['notes'])) { ?>
		                     	<tr>
		<td width="20%">Notes</td>
		<td>:</td>
		<td>
		                     			<?php
																								echo nl2br ( $testOrder ['LaboratoryTestOrder'] ['notes'] );
																								?>
		                     		</td>
	</tr>
		                     	<?php }if(!empty($token['LaboratoryToken']['collected_date'])){ ?>
		                     	<tr>
		<td>Sample Collected On</td>
		<td>:</td>
		<td>
		                     			<?php
																								echo $this->DateFormat->formatDate2Local ( $token ['LaboratoryToken'] ['collected_date'], Configure::read ( 'date_format' ), true );
																								?>
		                     		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">
			<h3>
				<strong>
						            	<?php echo strtoupper($pathologist['User']['full_name']); ?>
						            	</strong>
			</h3> <br />
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
		                     	<?php }if(!empty($testOrder['LaboratoryTestOrder']['signature'])){?>
		                     	<tr>
		<td colspan="3"> 
		                     			<?php echo nl2br($testOrder['LaboratoryTestOrder']['signature']); ?>
		                     		</td>
	</tr>
		                    	<?php } ?>
	                   </table>
<div class="clr">&nbsp;</div>
<div class="clr">&nbsp;</div>
<table>
	<!--
	                   		<tr>
    <td align="left" valign="top" style="border-top:1px solid #cccccc; p">&nbsp;</td>
  </tr>
  -->
	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
</table>
