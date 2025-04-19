
<!--<td valign="top" style="padding-top:10px;">
   	<?php
				if (empty ( $CategoryValue )) {
					echo $field + 1;
				}
				$IncCounter = $counter + 1;
				?>
	</td>-->
<td valign="top">  
		<?php if(empty($CategoryValue)) { ?>
	    <table>
		<tr><?php if($hideCatCheckBox != 'hideCatCheckBox'){?>
			<td>
	            	<?php echo __("is Category?").$this->Form->input('',array('type'=>'checkbox','name'=>$IncCounter,'div'=>false,'label'=>false,'class'=>'category','id'=>"category_$IncCounter")).__("Yes/No");  ?>
	                <br>
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
					'autocomplete' => 'off',
					'id' => 'CategoryName_' . $IncCounter,
					'style' => "display:none;" 
			) );
			?>
                                			</td>
		</tr>
		<tr>
		<?php if($hideCatCheckBox != 'hideCatCheckBox'){?>
			<td><?php //echo $this->Form->input('',array('type'=>'text','id'=>'sort_'.$IncCounter,'name' => $IncCounter,'class'=>'sort','autocomplete'=>'off'/* ,'style'=>'display:none;' */,'placeholder'=>'Sort Order'));?>
			</td>
			<?php }?>
		</tr>
		<tr>
			<td><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMore_'.$IncCounter,'class'=>'addMore','title'=>'Add','style'=>'display:none;')); ?>
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
																																						'class' => 'categorySort',
																																						'id' => 'categorySort_'. $IncCounter,
																																						'value' => $categorySort,
																																						'name' => "data[LaboratoryCategory][$counter][sort]"
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
																																						'class' => 'name_lab_par1 textBoxExpnd validate[required,custom[mandatory-enter]]',
																																						'id' => "labParaNameDisplay_$counter",
																																						'label' => false,
																																						'div' => false,
																																						'autocomplete' => 'off',
																																						'error' => false 
																																				) );
																																				echo $this->Form->hidden ( '', array (
																																						'class' => 'sortCategory',
																																						'id' => 'sortCategory_'. $IncCounter,
																																						'value' => $sortCategory,
																																						'name' => "data[LaboratoryParameter][$counter][sort_category]"
																																				) );
																																				?>
																									                                   			</td>
																									                                   			<td>
                                   																												<?php /*echo __ ( "Sort Attribute:" ) . "&nbsp;";
																																				echo $this->Form->input ( '', array (
																																						'class' => 'sortOrder',
																																						'label'=>false,
																																						'div'=>false,
																																						'id' => 'sortOrder_' . $IncCounter,
																																						'autocomplete' => 'off',
																																						'value' => "",
																																						'placeholder'=>'Sort Order',
																																						'name' => "data[LaboratoryParameter][$counter][sort_attribute]"
																																				) );*/?>
                                   			
                                   																												</td>
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
								value="range" /></td>
							<td width=""><?php echo __('By Range'); ?></td>
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
			<!-- CHILD -->
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
			
			<!-- CHILD -->
		</table>
	</div>
	<div style="display: none;" id="age-section_<?php echo $counter ;?>">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			style="border-top: 1px solid #3e474a;" id="addTrAge_<?php echo $counter;?>">
			<tr>
				<td height="25">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center">LL</td>
				<td align="center">UL</td>
				<td align="center">Default</td>
			</tr>
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
				<td width="90" align="left">Less Than For Male</td>
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
				<td width="100"><?php
																										
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
				<td width="55" align="left">More Than For Male</td>
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
				<td width="100">
						<?php echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$counter][by_age_days_more]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_more",
									'label' => false,
									'div' => false,
									'error' => false 
							) );?>
						</td>
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
			
			<!-- AGE For Female -->
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
				<td width="105" align="left">Less Than For Female</td>
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
						<?php echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$counter][by_age_days_less_female]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_less_female",
									'label' => false,
									'div' => false,
									'error' => false 
							) );?>
						</td>
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
						'id' => 'by_age_more_years',
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?></td>
				<td width="55" align="left">More Than For Female</td>
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
				<td width="100">
						<?php echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$counter][by_age_days_more_female]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_more_female",
									'label' => false,
									'div' => false,
									'error' => false 
							) );?>
						</td>
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
			
			<!-- EOF Age For Female -->
			
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
									'id' => "by_age_sex",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?>
							</td>
				<td width="62" colspan=""><?php
				
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
							'autocomplete' => 'off',
							'class' => '',
							'id' => 'by_age_between_num_gret_years',
							'size' => "1",
							'label' => false,
							'div' => false,
							'error' => false 
					) );
					?> 
                                         </td>
                                         <td width="100">
						<?php echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$counter][by_age_days_between][0]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_between",
									'label' => false,
									'div' => false,
									'error' => false 
							) );?>
						</td>
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
				<td width="70"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>"addButtonAge_$counter",'title'=>'Add','class'=>'addMoreAge'));?></td>
			</tr>
		</table>
	</div> <!-- Pawan parameter by range start -->
	<div style="display: none;"
		id="range_positive_negative_section_<?php echo $counter ;?>">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			style="border-top: 1px solid #3e474a;" id="addTrRange_<?php echo $counter;?>">
			<tr>
				<td height="25">&nbsp;</td>
				<td>&nbsp;</td>

				<td align="left">Value</td>
				<td align="left">Interpretation</td>
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
						'id' => 'by_range_between_lower_limit_0',
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
									'id' => 'by_range_between_upper_limit_0',
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
						'id' => 'by_range_between_interpretation_0',
						'size' => "20",
						'label' => false,
						'div' => false,
						'error' => false 
				) );
				?>
						</td>
						<td width="70"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>"addButtonRange_$counter",'title'=>'Add','class'=>'addMoreRange'));?></td>
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


                          		</script>
