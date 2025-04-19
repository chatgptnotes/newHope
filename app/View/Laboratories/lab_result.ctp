<div class="inner_title">
	<h3>Lab Result</h3>
</div>

<div class="clr ht5"></div>
<?php
echo $this->element ( 'patient_information' );

// if(isset($this->data['Laboratory']['laboratory_id']) && !empty($this->data['Laboratory']['laboratory_id'])) {

echo $this->Form->create ( 'LaboratoryResult', array (
		'url' => array (
				'controller' => 'laboratories',
				'action' => 'lab_result',
				$patient_id 
		),
		'id' => 'labResultfrm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );

// echo $this->Form->hidden('laboratory_categories_id',array('value'=>$this->data['Laboratory']['category_id']));
?>
<table width="100%" cellpadding="5" cellspacing="4" border="0"
	id="ExtraRow">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="30%"><?php  echo __('Pathologist '); ?>:  </td>
		<td width="30%"><?php
		
		echo $this->Form->input ( 'user_id', array (
				'type' => 'select',
				'options' => $pathologist,
				'empty' => __ ( 'Please Select' ),
				'value' => $test_atrributes [0] ['LaboratoryResult'] [0] ['user_id'] 
		) );
		?></td>

		<td height="30" width="20%" class="tdLabel2">Specimen ID:  <?php echo strtoupper($token['LaboratoryToken']['sp_id']); ?></td>
		<td class="tdLabel2" width="20%">Accession ID:  <?php echo strtoupper($token['LaboratoryToken']['ac_id']);?></td>
	</tr>

	<tr>
		<td>
		           		   		 	<?php  echo __('Group'); ?>:  </td>
		<td><strong> <?php  echo ucfirst($testGroup); ?> </strong></td>

	</tr>
	<tr>
		<td> <?php  echo __('Test Name'); ?>:  </td>
		<td><strong> <?php  echo $labTest; ?> </strong></td>

	</tr> 
		           		   	<?php
																			$count = 0;
																			if (! empty ( $testOrder ) && ! empty ( $testOrder ['LaboratoryTestOrder'] ['dynamic_labels'] )) {
																				$customLabels = unserialize ( $testOrder ['LaboratoryTestOrder'] ['dynamic_labels'] );
																				$customValues = unserialize ( $testOrder ['LaboratoryTestOrder'] ['dynamic_values'] );
																				
																				foreach ( $customLabels as $key => $label ) {
																					$newHtml = '<tr id="ExtraRow' . $count . '">';
																					$newHtml .= '<td valign="top" align="left">';
																					$newHtml .= '<input type="text" value="' . $label . '" id="name' . $count . '" class="textBoxExpnd" name="data[LaboratoryTestOrder][dynamic_labels][' . $count . ']">';
																					$newHtml .= ':</td>';
																					$newHtml .= '<td valign="top">';
																					$newHtml .= '<input type="text" value="' . $customValues [$key] . '" style="width:87%;" id="" class="textBoxExpnd" name="data[LaboratoryTestOrder][dynamic_labels_values][' . $count . ']">';
																					$newHtml .= $this->Html->image ( '/img/icons/cross.png', array (
																							'id' => "remove_$count",
																							'class' => "removeButton" 
																					) );
																					$newHtml .= '</td>';
																					$newHtml .= '</tr>';
																					echo $newHtml;
																					$count ++;
																				}
																			} else {
																				$newHtml = '<tr id="ExtraRow' . $count . '">';
																				$newHtml .= '<td valign="top" align="left">';
																				$newHtml .= '<input type="text" value="" id="name' . $count . '" class="textBoxExpnd" name="data[LaboratoryTestOrder][dynamic_labels][' . $count . ']">';
																				$newHtml .= ':</td>';
																				$newHtml .= '<td valign="top">';
																				$newHtml .= '<input type="text" value="" style="width:87%;" id="" class="textBoxExpnd" name="data[LaboratoryTestOrder][dynamic_labels_values][' . $count . ']">';
																				$newHtml .= '</td>';
																				$newHtml .= '<td colspan="2"><i>(For customize labels and values) </i></td>';
																				$newHtml .= '</tr>';
																				echo $newHtml;
																				$count = 1;
																			}
																			?>
		           		 
	           		   </table>
<div>
	<input type="button" id="addButton" value="Add more" align="right"
		class="blueBtn">
</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">

	<tr>
		<th style="text-align: left;">TEST NAME</th>
		<th width="250" style="text-align: center;"><strong>OBSERVED VALUE</strong></th>
		<th width="120" style="text-align: center;"><strong>NORMAL RANGE</strong></th>
		<th width="90" style="text-align: center;"><strong>UNITS</strong></th>
		<!--  <th width="90" style="text-align:center;"><strong>INTERPRETATION</strong></th>-->
	</tr>
	                     	<?php
																							
																							// loop through all attributes of selected test
																							
																							$statusArr = array (
																									'normal' => 'Normal',
																									'abnormal' => 'Abnormal' 
																							);
																							
																							if (isset ( $test_atrributes )) {
																								$i = 1;
																								foreach ( $test_atrributes as $k => $data ) {
																									$parameterData = $data ['LaboratoryParameter'];
																									$catData = $data ['LaboratoryCategory'];
																									$resultData = $data ['LaboratoryResult'];
																									$catId = $catData ['id'];
																									foreach ( $parameterData as $key => $dataKey ) {
																										
																										echo "<tr>";
																										echo "<td>" . $dataKey ['name'] . "</td>";
																										$resultId = isset ( $resultData [$key] ['id'] ) ? $resultData [$key] ['id'] : '';
																										$resultText = isset ( $resultData [$key] ['text'] ) ? $resultData [$key] ['text'] : '';
																										$resultValue = isset ( $resultData [$key] ['value'] ) ? $resultData [$key] ['value'] : '';
																										$resultStatus = isset ( $resultData [$key] ['status'] ) ? $resultData [$key] ['status'] : '';
																										
																										if ($resultStatus == 'ABNORMAL') {
																											$color = 'red';
																										} else {
																											$color = '';
																										}
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][patient_id]",
																												'value' => $patient_id 
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][laboratory_test_order_id]",
																												'value' => $lab_test_order_id 
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][laboratory_categories_id]",
																												'value' => $catId 
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][id]",
																												'value' => $resultId 
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][laboratory_id]",
																												'value' => $lab_id 
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][laboratory_parameter_id]",
																												'value' => $dataKey ['id'] 
																										) );
																										
																										if ($dataKey ['type'] == 'text') {
																											echo "<td>";
																											echo $this->Form->textarea ( '', array (
																													'name' => "data[LaboratoryResult][$catId][$key][text]",
																													'value' => $resultText,
																													'rows' => 3,
																													'style' => "color:$color",
																													'class' => 'textBoxExpnd',
																													'id' => 'attri-text' 
																											) );
																											echo "</td><td colspan=3 align='left' valign='top'><div style='height:60px;'>";
																											echo $dataKey ['parameter_text'];
																											echo "</div></td>";
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
																											echo "<td>";
																											echo $this->Form->input ( '', array (
																													'type' => 'text',
																													'name' => "data[LaboratoryResult][$catId][$key][value]",
																													'id' => $i,
																													'value' => $resultValue,
																													'style' => "color:$color",
																													'class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]' 
																											) );
																											echo "</td>";
																											// new
																											if (! empty ( $lower ) && ((trim ( $upper ) == ''))) {
																												echo "<td style='text-align:center;'>" . "Greater Than " . $lower . "</td>";
																											} else if ((trim ( $lower ) == '') && (! empty ( $upper ))) {
																												echo "<td style='text-align:center;'>" . "Up To " . $upper . "</td>";
																											} else {
																												echo "<td style='text-align:center;'>" . $lower . " – " . $upper . "</td>";
																											}
																											// EOF new
																											
																											if (! empty ( $lower ) || ! empty ( $upper )) {
																												echo $this->Form->hidden ( '', array (
																														'name' => "data[LaboratoryResult][$catId][$key][range]",
																														'value' => $lower . "-" . $upper 
																												) );
																											}
																											echo "<td style='text-align:center;'>" . $dataKey ['unit'] . "</td>";
																											// echo "<td style='text-align:center;'>";
																											// echo $this->Form->input('',array('type'=>'text' ,'name'=>"data[LaboratoryResult][$catId][$key][status]",'value'=>$resultStatus,
																											// 'class'=>'','style'=>"color:$color"));
																											// echo "</td>";
																										}
																										echo "</tr>";
																										$i ++;
																									}
																									echo "<tr><td colspan='5' style='font-size:9px;'><i>";
																									echo strtoupper ( $catData ['category_name'] );
																									echo "</i></td></tr>";
																								}
																							}
																							?> 
	                     	<tr>
		<td>Notes</td>
		<td colspan="4">
	                     			<?php
																									echo $this->Form->textarea ( 'LaboratoryTestOrder.notes', array (
																											'class' => 'textBoxExpnd',
																											'id' => 'notes',
																											'style' => 'width:98%',
																											'rows' => 7,
																											'value' => $testOrder ['LaboratoryTestOrder'] ['notes'] 
																									) );
																									?>
	                     		</td>
	</tr>
	<tr>
		<td>Sample Collected On</td>
		<td colspan="4">
	                     			<?php echo $token['LaboratoryToken']['collected_date']  ;  ?>
	                     		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="4">
	                     			<?php
																									echo $this->Form->hidden ( 'LaboratoryTestOrder.id', array (
																											'value' => $lab_test_order_id 
																									) );
																									echo $this->Form->textarea ( 'LaboratoryTestOrder.signature', array (
																											'class' => 'textBoxExpnd',
																											'id' => 'notes',
																											'style' => 'width:98%',
																											'rows' => 7,
																											'value' => $testOrder ['LaboratoryTestOrder'] ['signature'] 
																									) );
																									?>
	                     		</td>
	</tr>
</table>
<!-- billing activity form end here -->
<div>&nbsp;</div>
<div class="btns">
               			<?php
																		if ($test_atrributes [0] ['LaboratoryResult'] [0] ['confirm_result'] == 1) {
																			$checked = 'checked';
																			echo "<strong>Result Publish On : </strong>";
																			echo $this->DateFormat->formatDate2Local ( $test_atrributes [0] ['LaboratoryResult'] [0] ['result_publish_date'], Configure::read ( 'date_format' ), true );
																			echo $this->Form->input ( 'confirm_result', array (
																					'type' => 'hidden',
																					'value' => 1 
																			) ); // maintian previous state
																		} else {
																			$checked = '';
																			echo "<strong>Publish Result</strong>";
																			echo $this->Form->input ( 'confirm_result', array (
																					'id' => 'confirm_result',
																					'type' => 'checkbox',
																					'value' => 1,
																					'checked' => $checked,
																					'autocomplete' => 'off' 
																			) );
																			echo $this->Form->input ( 'result_publish_date', array (
																					'id' => 'result_publish_date',
																					'type' => 'text',
																					'autocomplete' => false,
																					'readonly' => 'readonly',
																					'autocomplete' => 'off' 
																			) );
																		}
																		if (empty ( $test_atrributes [0] ['LaboratoryResult'] [0] ['result_publish_date'] ) && $test_atrributes [0] ['LaboratoryResult'] [0] ['confirm_result'] == 1) {
																			echo $this->Form->input ( 'result_publish_date', array (
																					'id' => 'result_publish_date',
																					'type' => 'text',
																					'autocomplete' => false,
																					'readonly' => 'readonly',
																					'autocomplete' => 'off' 
																			) );
																		}
																		echo "&nbsp;&nbsp;";
																		echo $this->Html->link ( __ ( 'Cancel' ), array (
																				'controller' => 'laboratories',
																				'action' => 'lab_test_list',
																				$patient_id 
																		), array (
																				'escape' => false,
																				'class' => 'grayBtn' 
																		) );
																		?>
						&nbsp;&nbsp;<input type="Submit" value="Save" class="blueBtn">

</div>
<?php echo $this->Form->end();	 ?>	
                     <?php //} //EOF test check?>

<script>
 		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#labResultfrm").validationEngine();
			//function to check search filter
			$('#labResultfrm').submit(function(){
				var msg = false ;  
				$("form input:text").each(function(){
				       //access to form element via $(this)
				       if($(this).val() !=''){
				       		msg = true  ;
				       }
				    }
				); 
				$("form textarea").each(function(){
					 
				       //access to form element via $(this)
				       if($(this).val() !=''){
				       		msg = true  ;
				       }
				    }
				); 
				if(!msg){
					alert("Please fill atleast one value .");
					return false ;
				}		
			}); 
		});
 		$(function() {	
			//calender
			$( "#result_publish_date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true, 
				yearRange: '1950',			 
				dateFormat:'dd/mm/yy HH:II:SS',
	            onSelect:function(){
					$(this).focus();
					$('#confirm_result').attr('checked',true);
	            }
			});

			$('#confirm_result').click(function(){
				if($('#confirm_result').is(":checked")){
					var currentdate = new Date();
                    var showdate = " "+currentdate.getHours()+":"+currentdate.getMinutes()+":"+currentdate.getSeconds();
                    var d = new Date();

                    var month = d.getMonth()+1;
                    var day = d.getDate();
                    var showdate = ((''+day).length<2 ? '0' : '') + day + '/' +
                    ((''+month).length<2 ? '0' : '') + month + '/' +
                    d.getFullYear()+showdate ;
                    
                    var output = d.getDate()  + '/' +
                        ((''+month).length<2 ? '0' : '') + month + '/' +
                        ((''+day).length<2 ? '0' : '') + day;
                    
                    $( "#result_publish_date" ).val(showdate);
				}else{
					$( "#result_publish_date" ).val(''); 
				}
			});


			var counter = <?php echo ($count)?$count:0?>;
			 
	    	$("#addButton").click(function () {		 				 
			 
				var newCostDiv = $(document.createElement('tr'))
				     .attr("id", 'ExtraRow' + counter);
				 
				newHtml =  '<td valign="top" align="left">' ;
				newHtml += '<input type="text" value="" id="name'+counter+'" class="textBoxExpnd" name="data[LaboratoryTestOrder][dynamic_labels]['+counter+']">' ;
				newHtml += ':</td>' ;
			 
				newHtml += '<td valign="top">';
				newHtml += '<input type="text" style="width:87%;" id="" class="textBoxExpnd" name="data[LaboratoryTestOrder][dynamic_labels_values]['+counter+']">';
				newHtml += '<img src="<?php echo $this->Html->url('/img/icons/cross.png'); ?>" id="remove_'+counter+'" class="removeButton">';
				newHtml += '</td>';  	
				
				newCostDiv.append(newHtml);		 
				newCostDiv.appendTo("#ExtraRow");		
				  			 			 
				++counter;
				if(counter > 0) $('#removeButton').show('slow');
	     	});
	     	
	    	$('.removeButton').live('click',function(){
	        	 
				currentID = $(this).attr('id');
				currentClickedRow = currentID.split("_");
				$("#ExtraRow" + currentClickedRow[1]).remove(); 		 
				counter--;			 
		 		if(counter == 0) $('#removeButton').hide('slow');
		   });
 		});
 </script>