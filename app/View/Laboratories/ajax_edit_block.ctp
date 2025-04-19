<!--	<td valign="top" style="padding-top:10px;"><?php echo $counter ; $IncCounter = $counter;?></td>-->
<?php if($categoryValueCount){
	$categoryValueCount = $categoryValueCount;
}else{
$categoryValueCount = $counter;
}?>

<td valign="top">  
	                                <?php if(empty($isCategoryAllowed) || ($isCategoryAllowed == 'isCategoryAllowed')) { ?>
	                                <table>
										<tr>
											<?php if($hideCatCheckBox != 'hideCatCheckBox'){?>
											<td>
	                                			<?php echo __("is Category?").$this->Form->input('',array('type'=>'checkbox','name'=>$IncCounter,'div'=>false,'label'=>false,'class'=>'category','id'=>"category_$IncCounter")).__("Yes/No");  ?>
	                                			<br>
			                                	<?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMore','class'=>'addMore','title'=>'Add','style'=>"display:none;")); ?>                              	 
			                                	
	                                		</td>
										<?php }?></tr>
		<tr>
			<td>
                                				<?php
																																		// echo $this->Form->hidden('',array('class'=>'CateName','id'=>'CateName_'.$IncCounter,'value'=>$CategoryValue,'name'=>"data[LaboratoryParameter][$counter][category_name]"));
																																		echo $this->Form->input ( '', array (
																																				'type' => 'text',
																																				'name' => $IncCounter,
																																				'class' => 'CategoryName',
																																				'id' => 'CategoryName_' . $IncCounter,
																																				'count'=>$categoryValueCount,	
																																				'style' => "display:none;" 
																																		) );
																																		?>
                                			</td>
		</tr>
		<tr>
			<td><?php 																													/*echo $this->Form->input ( '', array (
																																				'type' => 'text',
																																				'name' => $IncCounter,
																																				'class' => 'sort',
																																				'id' => 'sort_' . $IncCounter,
																																				'count'=>$categoryValueCount,
																																				'placeholder'=>'sort order',	
																																				'style' => "display:none;" 
																																		) );*/?>
			</td>
		</tr>
		<tr>
			<td>
                                				<?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMore_'.$IncCounter,'class'=>'addMore','title'=>'Add','style'=>'display:none;','count'=>$categoryValueCount)); ?>
                                			</td>
		</tr>
	</table>
	                                <?php }?>
                                </td>
<td style="padding-top: 10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="3">
				<table>
					<tr>
						<td><?php
						echo $this->Form->hidden ( "LaboratoryParameter.$counter.name", array (
								'id' => "labParaName_$counter",
								'value' => '' 
						) );
						?>
			                                	
			                                	<?php
																																				
																																				echo __ ( "Attribute Name:" ) . "&nbsp;";
																																				
																																				echo $this->Form->hidden ( '', array (
																																						'class' => 'CategoryValue',
																																						'id' => 'CategoryValue_' . $IncCounter,
																																						'value' => $CategoryValue,
																																						'name' => "data[LaboratoryCategory][$counter][category_name]" 
																																				) );
																																				echo $this->Form->hidden ( '', array (
																																						'class' => 'CateName',
																																						'id' => 'CateName_' . $IncCounter,
																																						'value' => $CategoryValue,
																																						'name' => "data[LaboratoryParameter][$counter][category_name]" 
																																				) );
																																				echo $this->Form->input ( '', array (
																																						'name' => "data[LaboratoryParameter][$counter][name_txt]",
																																						'value' => '',
																																						'class' => 'name_lab_par1 textBoxExpnd validate[required,custom[name]]',
																																						'id' => "labParaNameDisplay_$counter",
																																						'autocomplete'=>'off',
																																						'label' => false,
																																						'div' => false,
																																						'error' => false 
																																				) );
																																				echo $this->Form->hidden ( '', array (
																																						'class' => 'altCateName_'.$categoryValueCount,
																																						'id' => 'altCateName_' . $counter,
																																						'value' => $altCateName,
																																						'name' => "data[LaboratoryParameter][$counter][altCateName]" 
																																				) );
																																				echo $this->Form->hidden ( '', array (
																																						'class' => 'categorySort_'.$categoryValueCount,
																																						'id' => 'categorySort_' . $counter,
																																						'value' => $categorySort,
																																						'name' => "data[LaboratoryCategory][$counter][sort]"
																																				) );
																																				echo $this->Form->hidden ( '', array (
																																						'class' => 'sortCategory_'.$categoryValueCount,
																																						'id' => 'sortCategory_' . $counter,
																																						'value' => $sortCategory,
																																						'name' => "data[LaboratoryParameter][$counter][sort_category]"
																																				) );
																																				?>
																								                                   			</td>
																								                                   			<td><?php 
																									                                   			/*echo __ ( "Sort Attribute:" ) . "&nbsp;";
																									                                   			echo $this->Form->input ( '', array (           'placeholder'=>'Sort Order',
																																						'class' => 'sortOrder_'.$categoryValueCount,
																																						'label'=>false,
																																						'div'=>false,
																																						'id' => 'sortOrder_' . $counter,
																																						'value' => "",
																																						'name' => "data[LaboratoryParameter][$counter][sort_attribute]"
																																				) );*/?></td>
					</tr>
				</table>
				<hr>
			</td>
		</tr>
		<tr>
			<td width="40" class="tdLabel2">Type</td>
			<td width="100">
	                                      	 	<?php
																																										$type_arr = array (
																																												'numeric' => 'Numeric',
																																												'text' => 'Text' 
																																										);
																																										echo $this->Form->input ( '', array (
																																												'options' => $type_arr,
																																												'name' => "data[LaboratoryParameter][$counter][type]",
																																												'class' => 'attr-type textBoxExpnd validate[required,custom[name]]',
																																												'id' => "type_$counter",
																																												'label' => false,
																																												'div' => false,
																																												'error' => false 
																																										) );
																																										?>                                            
                              			 	</td>
			<td><?php
			
			echo __ ( "Is Mandatory : " ) . $this->Form->input ( 'is_mandatory', array (
					'type' => 'checkbox',
					'div' => false,
					'checked' => 'checked',
					'label' => false,
					'class' => 'isMandatory',
					'id' => 'isMandatory-' . $counter,
					'name' => 'data[LaboratoryParameter][' . $counter . '][is_mandatory]' 
			) );
			?>
															</td>
			<td colspan="4">
				<div id="radioGroup_<?php echo $counter;?>" style="display: block">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="25"><input type="radio" class="sort-by"
								name="data[LaboratoryParameter][<?php echo $counter ;?>][by_gender_age]"
								id="gender-<?php echo $counter ;?>" value="gender"
								checked="checked" /></td>
							<td width="80">By Sex</td>
							<td width="25"><input type="radio" class="sort-by"
								name="data[LaboratoryParameter][<?php echo $counter ;?>][by_gender_age]"
								id="age-<?php echo $counter ;?>" value="age" /></td>
							<td width="80">By Age</td>
							<td width="25"><input type="radio" class="sort-by"
								name="data[LaboratoryParameter][<?php echo $counter ;?>][by_gender_age]"
								id="range_positive_negative-<?php echo $counter ;?>"
								value="range" <?php echo $range ;?> /></td>
							<td><?php echo __('By Range');?></td>

						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
	<div class="ht5"></div>
	<div id="parameter_text_<?php echo $counter;?>" style="display: none;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			style="border-top: 1px solid #3e474a;">
			<tr>
				<td style="padding-top: 5px;">
                                       	  		<?php
																																												echo $this->Form->textarea ( '', array (
																																														'name' => "data[LaboratoryParameter][$counter][parameter_text]",
																																														'class' => 'textBoxExpnd validate[required,custom[name]]',
																																														'id' => "parameter_text_id_$counter",
																																														'label' => false,
																																														'div' => false,
																																														'error' => false 
																																												) );
																																												?> 
                                       	   </td>
			</tr>
			<tr>
				<td align="right" style="padding-top: 5px; padding-bottom: 5px;">
							<?php echo __("Is multiple options?");?>
							<?php
							
							echo $this->Form->input ( '', array (
									'name' => "data[LaboratoryParameter][$counter][is_multiple_options]",
									'type' => 'checkbox',
									'class' => '',
									'id' => 'is_multiple_options_' . $counter,
									'size' => "3",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?> [Please add comma (,) separated values]</td>
			</tr>
		</table>
	</div>
	<div id="gender-section_<?php echo $counter;?>">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			style="border-top: 1px solid #3e474a;">
			<tr>
				<td height="25">&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center">LL</td>
				<td align="center">UL</td>
				<td align="center">Default</td>
			</tr>
			<tr>
				<td width="25">
                                        		<?php
																																										
																																										echo $this->Form->input ( '', array (
																																												'name' => "data[LaboratoryParameter][$counter][by_gender_male]",
																																												'type' => 'checkbox',
																																												'class' => '',
																																												'id' => 'by_gender_male',
																																												'label' => false,
																																												'div' => false,
																																												'error' => false 
																																										) );
																																										?>
                                	 		</td>
				<td width="">Male</td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_gender_male_lower_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_male_lower_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_gender_male_upper_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_male_upper_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_gender_male_default_result]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_male_default_result',
						'size' => "20",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>

			</tr>
			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_gender_female]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_gender_female',
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="">Female</td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_gender_female_lower_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_female_lower_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_gender_female_upper_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_female_upper_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
			
			echo $this->Form->input ( '', array (
					'name' => "data[LaboratoryParameter][$counter][by_gender_female_default_result]",
					'type' => 'text',
					'autocomplete' => 'off',
					'class' => '',
					'id' => 'by_gender_female_default_result',
					'size' => "20",
					'label' => false,
					'div' => false,
					'error' => false 
			) );
			?></td>
			</tr>
			<!--CHILD  -->
			
			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_gender_child]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_gender_child',
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="">Child</td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_gender_child_lower_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_child_lower_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_gender_child_upper_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_child_upper_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
			
			echo $this->Form->input ( '', array (
					'name' => "data[LaboratoryParameter][$counter][by_gender_child_default_result]",
					'type' => 'text',
					'autocomplete' => 'off',
					'class' => '',
					'id' => 'by_gender_child_default_result',
					'size' => "20",
					'label' => false,
					'div' => false,
					'error' => false 
			) );
			?></td>
			</tr>
			
			<!--CHILD  -->
			
			
		</table>
	</div>
	<div style="display: none;" id="age-section_<?php echo $counter ;?>">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			style="border-top: 1px solid #3e474a;" id="addTrAge_<?php echo $counter; ?>">
			<tr>
				<td height="25">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center">LL</td>
				<td align="center">UL</td>
				<td align="center">Default</td>
			</tr>
			<!--  Age For Male-->
			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_less_years]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_age_less_years',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="80" align="left"><?php echo __("Less Than For Male");?></td>
				<td width="50"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_less_years]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_less_years',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="100">
						<?php
																										
							echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$counter][by_age_days_less]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_less",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_less_years_lower_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_less_years_lower_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_less_years_upper_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_less_years_upper_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_less_years_default_result]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_less_years_default_result',
						'size' => "20",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>

			</tr>
			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_more_years]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_age_more_years',
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="55" align="left"><?php echo __("More Than For Male");?></td>
				<td width="50"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_more_years]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_more_years',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="100"><?php
																										
							echo $this->Form->input ( '', array (
									'selected' => $lab_value ['Laboratory'] ['by_age_days_more'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$counter][by_age_days_more]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_more",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_gret_years_lower_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_gret_years_lower_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center">
                                         		<?php
																																											
			echo $this->Form->input ( '', array (
					'name' => "data[LaboratoryParameter][$counter][by_age_num_gret_years_upper_limit]",
					'type' => 'text',
					'autocomplete' => 'off',
					'class' => '',
					'id' => 'by_age_num_gret_years_upper_limit',
					'size' => "3",
					'label' => false,
					'div' => false,
					'error' => false 
			) );
			?></td>
							<td width="70" align="center">
			                                         		<?php
			
			echo $this->Form->input ( '', array (
					'name' => "data[LaboratoryParameter][$counter][by_age_num_gret_years_default_result]",
					'type' => 'text',
					'autocomplete' => 'off',
					'class' => '',
					'id' => 'by_age_num_gret_years_default_result',
					'size' => "20",
					'label' => false,
					'div' => false,
					'error' => false 
			) );
			?></td>

			</tr>
			<!-- EOF  Age For Male-->
			<!--  Age For Female-->
			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_less_years_female]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_age_less_years_female',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="80" align="left"><?php echo __("Less Than For Female");?></td>
				<td width="50"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_less_years_female]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_less_years_female',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="100">
						<?php
																										
							echo $this->Form->input ( '', array (
									'selected' => $lab_value ['Laboratory'] ['by_age_days_less_female'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$counter][by_age_days_less_female]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_less_female",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_less_years_lower_limit_female]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_less_years_lower_limit_female',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_less_years_upper_limit_female]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_less_years_upper_limit_female',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_less_years_default_result_female]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_less_years_default_result_female',
						'size' => "20",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>

			</tr>
			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_more_years_female]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_age_more_years_female',
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="55" align="left"><?php echo __("More Than For Female");?></td>
				<td width="50"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_more_years_female]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_more_years_female',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="100"><?php
																										
							echo $this->Form->input ( '', array (
									'selected' => $lab_value ['Laboratory'] ['by_age_days_more_female'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$counter][by_age_days_more_female]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_more_female",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_num_gret_years_lower_limit_female]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_num_gret_years_lower_limit_female',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center">
            <?php
																																											
			echo $this->Form->input ( '', array (
					'name' => "data[LaboratoryParameter][$counter][by_age_num_gret_years_upper_limit_female]",
					'type' => 'text',
					'autocomplete' => 'off',
					'class' => '',
					'id' => 'by_age_num_gret_years_upper_limit_female',
					'size' => "3",
					'label' => false,
					'div' => false,
					'error' => false 
			) );
			?></td>
				<td width="70" align="center">
                                         		<?php
			
			echo $this->Form->input ( '', array (
					'name' => "data[LaboratoryParameter][$counter][by_age_num_gret_years_default_result_female]",
					'type' => 'text',
					'autocomplete' => 'off',
					'class' => '',
					'id' => 'by_age_num_gret_years_default_result_female',
					'size' => "20",
					'label' => false,
					'div' => false,
					'error' => false 
			) );
			?></td>

			</tr>
			<!-- EOF Age For Female-->
			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_between_years]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_age_between_years',
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="55" align="left">Between
				<?php
																										
							echo $this->Form->input ( '', array (
									'selected' => $lab_value ['Laboratory'] ['by_age_sex'],
									'options' => array('Male'=>'Male','Female'=>'Female'),
									'name' => "data[LaboratoryParameter][$counter][by_age_sex][0]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_sex_$counter",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?>
				</td>
				<td width="50" colspan=""><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_between_num_less_years][0]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_between_num_less_years',
						'size' => "1",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?> -
                                	 			<?php
																																					
																																					echo $this->Form->input ( '', array (
																																							'name' => "data[LaboratoryParameter][$counter][by_age_between_num_gret_years][0]",
																																							'type' => 'text',
																																							'class' => '',
																																							'id' => 'by_age_between_num_gret_years',
																																							'size' => "1",
																																							'label' => false,
																																							'div' => false,
																																							'error' => false 
																																					) );
																																					?> 
                                         </td>
                                         <td>
		                                         <?php
																										
							echo $this->Form->input ( '', array (
									'selected' => $unSzBetween[$age],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$counter][by_age_days_between][$age]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_between",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_between_years_lower_limit][0]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_between_years_lower_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_between_years_upper_limit][0]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_between_years_upper_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="70" align="center"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_age_between_years_default_result][0]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_age_between_years_default_result',
						'size' => "20",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
<td width="70"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>"addButtonAge_$counter",'title'=>'Add','class'=>'addMoreAge1'));?></td>
			</tr>
		</table>
	</div> <!-- Pawan parameter by range start -->
	<div style="display: none;"
		id="range_positive_negative_section_<?php echo $counter ;?>">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			style="border-top: 1px solid #3e474a;" id="addTrRange_<?php echo $counter; ?>">
			<tr>
				<td height="25">&nbsp;</td>
				<td>&nbsp;</td>

				<td align="center">Value</td>
				<td align="center">Interpretation</td>
			</tr>
			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_range_less_than]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_range_less_than',
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						</td>
				<td width="25">Less Than</td>

				<td width="70" align="left"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_range_less_than_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_male_lower_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						</td>
				<td width="70" align="left"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_range_less_than_interpretation]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_male_upper_limit',
						'size' => "20",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						</td>
			</tr>
			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_range_greater_than]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_range_greater_than',
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						</td>
				<td width="">More Than</td>
				<td width="70" align="left"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_range_greater_than_limit]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_female_lower_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						</td>
				<td width="70" align="left"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_range_greater_than_interpretation]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_gender_female_upper_limit',
						'size' => "20",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						</td>
			</tr>

			<tr>
				<td width="25"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_range_between]",
						'type' => 'checkbox',
						'class' => '',
						'id' => 'by_range_between',
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						</td>
				<td width="">Between</td>
				<td width="70" align="left"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_range_between_lower_limit][0]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_range_between_lower_limit',
						'size' => "3",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						 - <?php
							
							echo $this->Form->input ( '', array (
									'name' => "data[LaboratoryParameter][$counter][by_range_between_upper_limit][0]",
									'type' => 'text',
									'autocomplete' => 'off',
									'class' => '',
									'id' => 'by_range_between_upper_limit',
									'size' => "3",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?>
						</td>
				<td width="70" align="left"><?php
				
				echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryParameter][$counter][by_range_between_interpretation][0]",
						'type' => 'text',
						'autocomplete' => 'off',
						'class' => '',
						'id' => 'by_range_between_interpretation',
						'size' => "20",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						</td>
						<td width="70"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>"addButtonRange_$counter",'title'=>'Add','class'=>'addMoreRange1'));?></td>
			</tr>
		</table>
	</div> <!-- parameter by range end -->

</td>
<td valign="top"><?php

echo $this->Form->input ( "LaboratoryParameter.$counter.unit_txt", array (
		'type' => 'text',
		'autocomplete' => 'off',
		'class' => 'name_Ucms textBoxExpnd',
		'id' => "unitDisplay_$counter",
		'size' => "3",
		'label' => false,
		'div' => false,
		'error' => false 
) );
echo $this->Form->hidden ( "LaboratoryParameter.$counter.unit", array (
		'id' => "unit_$counter",
		'value' => '' 
) );
?></td>
<td valign="top" align="center" style="padding-top: 15px;">
                          		  <?php
																														echo $this->Html->link ( $this->Html->image ( 'icons/close-icon.png' ), 'javascript:return false;', array (
																																'id' => "removeButton_$counter",
																																'escape' => false,
																																'class' => 'removeBtn',
																																'title' => 'Remove' 
																														) );
																														
																														?>
                          		  </td>
<script>
                          		  $("#name_attr").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Laboratory",'id',"name",'is_panel',"admin" => false,"plugin"=>false)); ?>", {
                      				width: 250,
                    				selectFirst: true,
                    				valueSelected:true,
                    				loadId : 'testname,testcode'
                    			});



                          		var counter = 1;
                        		$('.addMoreRange1').live('click',function(){
                        		idd = $(this).attr('id');
                        		newId = idd.split("_");
                        		$("#addTrRange_"+newId[1])
                        		.append($('<tr>').attr({'id':'newBrowseRow_'+counter,'class':'newBrowseRow'})
                        				.append($('<td>'))
                        				.append($('<td>'))
                            		.append($('<td>').append($('<input>').attr({'id':'by_range_between_lower_limit_'+counter,'size':'3','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_range_between_lower_limit]['+counter+']','autocomplete':'off'})).append('&nbsp;-&nbsp;')
                            			.append($('<input>').attr({'id':'by_range_between_upper_limit_'+counter,'size':'3','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_range_between_upper_limit]['+counter+']','autocomplete':'off'})))
                            		.append($('<td>').append($('<input>').attr({'id':'by_range_between_interpretation_'+counter,'type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_range_between_interpretation]['+counter+']','autocomplete':'off'})))
                            		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
                        					.attr({'class':'removeButton','id':'removeButton_'+counter,'title':'Remove current row'}).css('float','right')))
                        			)	
                        			counter++;
                        		
                        	});
                        	$('.removeButton').live('click',function(){
                        		currentId=$(this).attr('id');
                        		splitedId=currentId.split('_');
                        		ID=splitedId['1'];
                        		$("#newBrowseRow_"+ID).remove();
                        		 
                        	});


                        	var counterAge = 1;
                        	//$('.addMoreRange').click(function(){
                        		$('.addMoreAge1').live('click',function(){
                        		idd = $(this).attr('id');
                        		newId = idd.split("_");
                        		$("#addTrAge_"+newId[1])
                        		.append($('<tr>').attr({'id':'newAgeRow_'+counterAge,'class':'newAgeRow'})
                        				.append($('<td>'))
                        				.append($('<td>').append($('<select>').attr({'id':'by_age_sex'+counterAge,'class':'textBoxExpnd ','type':'select','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_sex]['+counterAge+']'}).append($(' <option value="Male">Male</option><option value="Female">Female</option>'))))
                            		.append($('<td>').append($('<input>').attr({'id':'by_age_between_num_less_years_'+counterAge,'size':'1','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_num_less_years]['+counterAge+']','autocomplete':'off'})).append('&nbsp;-&nbsp;')
                            			.append($('<input>').attr({'id':'by_age_between_num_gret_years_'+counterAge,'size':'1','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_num_gret_years]['+counterAge+']','autocomplete':'off'})))

                            		.append($('<td  width="100">')
    			.append($('<select>').attr({'id':'by_age_days_between_'+counterAge,'class':'textBoxExpnd','type':'select','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_days_between]['+counterAge+']'})))
                            		
                            			
                            		.append($('<td  align="center">').append($('<input>').attr({'id':'by_age_between_years_lower_limit_'+counterAge,'size':'3','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_years_lower_limit]['+counterAge+']','autocomplete':'off'})))
                            		.append($('<td  align="center">').append($('<input >').attr({'id':'by_age_between_years_upper_limit_'+counterAge,'size':'3','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_years_upper_limit]['+counterAge+']','autocomplete':'off'})))
                            		.append($('<td  align="center">').append($('<input>').attr({'id':'by_age_between_years_default_result_'+counterAge,'size':'20','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_years_default_result]['+counterAge+']','autocomplete':'off'})))
                            		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
                        					.attr({'class':'removeButtonAge','id':'removeButtonAge_'+counterAge,'title':'Remove current row'}).css('float','right')))
                        			)	
                        			getDays();
                        			counterAge++;
                        		
                        	});
                        		function getDays(){
                        	 	 	var selectDaysBetween = $.parseJSON('<?php echo json_encode(array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)')) ?>');
                        	 	 	$.each(selectDaysBetween, function(key, value) {
                        	 	 	 	$('#by_age_days_between_'+counterAge).append(new Option(value , value) );
                        	 		});
                        	 	}
                        	$('.removeButtonAge').live('click',function(){
                        		currentId=$(this).attr('id');
                        		splitedId=currentId.split('_');
                        		ID=splitedId['1'];
                        		$("#newAgeRow_"+ID).remove();
                        		 
                         	});
                          		</script>
