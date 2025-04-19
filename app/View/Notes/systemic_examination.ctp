<?php 
App::import('Vendor', 'fusion_charts');
echo $this->Html->css(array('ros_accordian.css'));
echo $this->Html->script(array('/fusionwx_charts/FusionCharts','jquery.blockUI'));
echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));?>
<style>
.addClassColor {
	background: palegreen !important;
}

.addClassWhite {
	background: white !important;
}

.addClassTomato {
	background: tomato !important;
}

.newAddedLabel {
	width: 100%;
	display: inline;
	border-bottom: 1px solid #424A4D;
	padding: 0 0 0 10px;
}

.myFont {
	font: 44px verdana, sans-serif;
	!
	important;
}

.myUnderLine {
	border-bottom: 1px solid #424A4D;
}

.radio_check {
	width: 100%;
	display: inline;
	border: none !important;
	padding: none !important;
	
}

.radio_check label {
	display: block !important;
	background: none;
	border: 1px solid #424A4D;
	float: left;
	width: 210px !important;
	text-align: left;
	color: #000 !important;
}

.dropdown label {
	background: white /* !important */;
	/* commented because it restrict make label green or red */
}

.row_format label {
	width: 140px !important;
	text-align: left !important;
}

label {
	float: left;
	width: 135px !important;
	font-size: 12px;
	text-align: left;
	margin: 0px 0px 0px 10px;
}

.inter {
	display: block;
	height: 120px;
	overflow: visible;
	padding-bottom: 10px;
	padding-top: 10px;
}

.ros_row .radio_check label {
	margin-right: 5px !important;
}

#SelectRad {
	margin: 0 0 0 32px !important;
}

.dropdown dd,.dropdown dt {
	margin: 0px;
	padding: 0px;
}

.dropdown ul {
	margin: -1px 0 0 0;
	padding: 0px;
}

.dropdown dd {
	position: relative;
}

.dropdown a {
	color: #fff !important;
	text-decoration: underline;
	outline: none;
	font-size: 12px;
}

.dropdown a:visited {
	color: blue !important;
}

.dropdown dt a {
	display: block;
	padding: 8px 20px 5px 10px;
	min-height: 25px;
	line-height: 24px;
	overflow: hidden;
	border: 0;
	width: 272px;
}

.dropdown dt a span,.multiSel span {
	cursor: pointer;
	display: inline-block;
	padding: 0 3px 2px 0;
}

.dropdown {
	background-color: #4F6877;
	border: 0;
	color: #fff;
	display: none;
	left: 0px;
	padding: 15px;
	position: absolute;
	top: 2px;
	/*   width:280px; */
	list-style: none;
	/*  height: 100px; 
	overflow: auto;*/
	font-size: 13px;
}

.dropdown ul {
	list-style: none;
	/* height: 150px; */
}

.dropdown span.value {
	display: none;
}

.dropdown dd ul li a {
	padding: 5px;
	display: block;
}

.dropdown dd ul li a:hover {
	background-color: #fff;
}

.add-new-dropdown-textarea {
	display: none;
}

.reset-template {
	display: none;
}

.search-btn-template {
	color: #fff;
}

.view-template-list {
	float: left;
	width: 250px;
}

.view-template-list ul {
	float: left;
	padding: 0px;
	margin: 0px;
	height: auto;
}

.view-template-list ul li {
	float: left;
	padding: 0px;
	margin: 0 0 0 10px;
	list-style: square outside none;
	clear: both;
}

.dropdown-icons {
	float: left;
	clear: both;
	padding: 20px 0px;
}
</style>

<div class="inner_title">
	<h3 style="font-size: 13px; margin-left: 5px;">
		<?php  echo __('Physical Examination'); ?>
	</h3>
	<span style="text-align: right"> <?php /*echo  $this->Html->link('Category Masters',array('controller'=>'templates','action'=>'template_category',
			'?'=>array('patientId'=>$patientId,'noteId'=>$noteId,'action'=>'systemicExamination')),array('class'=>'blueBtn','escape'=>false,'div'=>false));*/?>
		<?php echo  $this->Html->link('Sub-category Masters',array('controller'=>'templates','action'=>'template_sub_category',
				'?'=>array('template_category_id'=>'2','patientId'=>$patientId,'noteId'=>$noteId,'action'=>'systemicExamination')),
				array('class'=>'blueBtn','escape'=>false,'div'=>false));?> <?php echo  $this->Html->link('Back',array('controller'=>'notes','action'=>'soapNote',$patientId,$noteId),
			array('class'=>'blueBtn','id'=>'submit2','div'=>false));?> <?php //echo  $this->Form->submit('Submit',array('value'=>'Submit','class'=>'blueBtn','id'=>'submit2','div'=>false));?>
	</span>
</div>
<?php 
echo $this->Form->create('TemplateSpeciality',array('type'=>'GET','id'=>'TemplateSpeciality','url'=>array('controller'=>'Notes','action'=>'systemicExamination',$patientId,$noteId),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
<table >
	<tr>
		<td><?php echo $this->Form->input('note_Template', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','options'=>$tName,
						'style'=>'margin:1px 0 0 10px;','empty'=>'Please Select','autocomplete'=>'off','value'=>$this->params->query['note_Template'])); ?>
			<?php  // echo $this->Form->input('language', array('empty'=>__('Select'),'options'=>$languages,'id' => 'language','style'=>'width:230px')); ?>

		</td>

		<td class="form_lables"><?php echo __('Single organ system examination types',true); ?>
		</td>
		<td><?php echo $this->Form->input('TemplateSubCategories.organ_system',array('options'=>Configure::read('system_organ'),'autocomplete'=>'off','value'=>$this->params->query['organ_system']));  ?>
		</td>

		<td style="padding-bottom: 12px;"><?php echo $this->Form->submit('View Templates',array('class'=>'blueBtn','div'=>false,'style'=>"margin: 11px 0 0 10px;"));
		?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end(); 
echo $this->Form->create('',array('id'=>'TemplateTypeContent','url'=>array('contoller'=>'Notes','action'=>'systemicExamination',$patientId,$noteId,$this->params->query['note_Template'],$this->params->query['organ_system']),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
<?php if(!empty($showDialog)){?>
<table width=100%>
	<tr>
		<td style="text-align: right; width: 100%"><?php echo $this->Form->input('Submit',array('type'=>'submit','class'=>'blueBtn','id'=>'submit1','div'=>false,'label'=>false));?>

		</td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td valign="top" width="89%">
			<table class="rose_row">
				<?php 
					
				$g=0;$myCnt=0; $sysExam=0;
				$toggle= 0 ;
				$i=0;
				foreach($roseData as  $dataRose =>$datakey) {
						$componentArray[$datakey['Template']['id']] = $datakey['Template']['category_name'];
						$g++ ;
						if(!empty($datakey['TemplateSubCategories'])){

						$newId= "reset-input-examination".$g;
						$newName ="data[subCategory_examination][".trim($datakey['Template']['id'])."]" ;

						if($datakey['Template']['category_name']=='Gynecologic')
							$font=myFont;
						else
							$font=myUnderLine;
						?>
				<tr>
					<td class="row_format <?php echo $font;?>" style="<?php echo $font;?>"><label><b><?php echo $datakey['Template']['category_name'] ?>
						</b> </label>
					</td>
					<?php  
					if($toggle == 0) {
											       	echo "<td class=''>";
											       	$toggle = 1;
										       }else{
											       	echo "<td>";
											       	$toggle = 0;
										       }

										       ?>
					<table id="<?php echo $datakey['Template']['id']."TemplateTable";?>"
						class="<?php echo 'template_category_'.$i; ?>">
						<tr>
							<?php
							$selectedOptions = '' ;
							foreach($templateTypeContent as $templateKey => $templateValue){
								if($templateValue['TemplateTypeContent']['template_id']== $datakey['Template']['id']){
									$selectedOptions= unserialize($templateValue['TemplateTypeContent']['template_subcategory_id']);
									$extra_btn_options = unserialize($templateValue['TemplateTypeContent']['extra_btn_options']) ;
								}
							}

							$patientSpecificOption=unserialize($patientSpecificTemplate[$datakey['Template']['id']]);
							$r = 0 ; 
							foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
								$subCategory=$selectedOptions[$subkey['id']];
								$color ='addClassWhite' ;
								if(empty($subCategory)){
									//when nothing selected then the default selections will be green (selected)
									if($subkey['is_default']=='1')
										$subCategory=$subkey['is_default'];
								}
								if($subCategory == '1'){
									$rosChked="checked";
									$subText=$subCategory;
									$color='addClassColor';
									$sysExam++;
								}elseif( $subCategory == '2' ){
									$rosChked="";
									$color='addClassTomato';
								} else{
								 	$rosChked="";
								}
								if($r%4==0) echo "</tr><tr>" ;
								?>
							<td class="radio_check" id="radiocheck">
								<?php 
								//$att=array('legend'=>false,'for'=>$datakey['Template']['category_name'],'class'=>'rad','checked'=>$rosChked);
								//$name = "data[Category2][se_".$datakey['Template']['category_name']."]" ;
								$name = "data[subCategory_examination][".$datakey['Template']['id']."][".$subkey['id']."]" ;
								if(trim($subkey['sub_category'])=='OTHER'){
									echo $this->Form->input($datakey['Template']['category_name'],array(/*$subkey['sub_category'] ,*/'label' => $subkey['sub_category'],'type'=>'checkbox',
													'onclick'=>"setVal('".trim($subkey['sub_category'])."','".$newId."','".$datakey['Template']['id']."')",
													'id'=>$datakey['Template']['category_name']."_SE_".$subkey['sub_category'] ,'class'=>'rad',
													'value'=>$subCategory,'name'=>$name ,'autocomplete'=>'off','multiple'=>'checkbox'/*,'style'=>'margin:0px 0px 0px 10px;'*/));
		 						}else{
									echo $this->Form->hidden($datakey['Template']['category_name'],array(/*$subkey['sub_category'] ,'label' => $subkey['sub_category'] */'type'=>'checkbox',
											'onclick'=>"setVal('".$subkey['id']."','".$newId."','".$datakey['Template']['id']."')",
											'id'=>$dataRose.'_'.$sub,'class'=>'rad '.$subkey['id'],//$subkey['id'] as $dropdownCount
											'value'=>$subCategory,'name'=>$name,'checked'=>$rosChked,'autocomplete'=>'off','multiple'=>'checkbox'));
								}
								?> <?php if(trim($subkey['sub_category']) != 'OTHER'){

									$extraSubcategoryOptions = unserialize($subkey['extraSubcategory']);
									$restrictRed = '';
									if(!empty($extraSubcategoryOptions[0]) || strtolower(trim($datakey['Template']['category_name'])) == 'constitutional')
										$restrictRed = 'restrictRed';/** red button not allowed for constitutional's button and button having DD options */
									$dropdownCount = $subkey['id']; //button id
									?> <label class='dClick <?php echo $restrictRed." ".$dropdownCount." ".$color;?>'
								id='<?php echo $dataRose.'_'.$sub."_myid"?>' style="margin:0px 0px 0px 10px;"><?php echo $subkey['sub_category'];?>
									<a href="javascript:void(0);" class="dropdown-anchor"
									id="dropdown-<?php echo $dropdownCount ; ?>"> <?php 
									echo $this->Html->image('icons/dropdown-arrow.png',array('alt'=>'view','title'=>"Click to view other options",'style'=>"float:right;z-index:3000;"));
									?>
								</a> </label> <?php //maintain var to distingwish

									//if($subkey['has_dropdown'] ==  1){
								?> <!-- BOF button template text by pankaj  --> <span
								class="multiSel"
								id="option-container-<?php echo $dropdownCount;?>"></span>
								<div class="dropdown"
									id="ul-dropdown-<?php echo $dropdownCount;?>"
									style="z-index: 2000; display: none;">
									<ul>
										<?php  
										$redNotAllowedArray = array_values(unserialize($subkey[redNotAllowed]));
										$textAreaName = "data[extra_textarea_data][".$datakey['Template']['id']."][$dropdownCount]" ;
									 
										foreach($extraSubcategoryOptions as $key => $value){
												if(empty($value)) continue ;
												$dropdownSelVal  = $extra_btn_options['dropdown_options'][$dropdownCount][$key] ;////////////
												$name         = "data[dropdown_options][".$datakey['Template']['id']."][$dropdownCount][$key]" ;

												if($dropdownSelVal == 1){
													$dropdownSelClass = "addClassColor";
												}else if($dropdownSelVal==2){
													$dropdownSelClass = "addClassTomato";
												}else{
													$dropdownSelClass = "addClassWhite";
												}
												?>
										<li><?php  
										 
											$redAllow = ($redNotAllowedArray[$key] == 1) ? '' : 'redAllow';
										echo $this->Form->hidden($datakey['Template']['category_name'],array(
															'label' => $value,'type'=>'checkbox','value'=>0,
															'id'=>"dropdown-btn_$dropdownCount-$key",'class'=>'',
															'value'=>(!empty($dropdownSelVal))?$dropdownSelVal:'0','name'=>$name,'checked'=>$rosChked,'autocomplete'=>'off','multiple'=>'checkbox'));

												?> <label
											id="<?php echo "dropdown-label_$dropdownCount-$key"; ?>"
											class='dropdown-btn <?php echo $dropdownSelClass." ".$redAllow ;?>'
											style="margin: 0px !important;"> <?php echo $value;?>
										</label>
										</li>
										<?php } ?>
									</ul>
									<div class="dropdown-icons">
										<?php echo $this->Html->image('/images/tree/folder-closed.gif',array('alt'=>'View saved items','class'=>'viewBtnTemaplate','id'=>"viewBtnTemaplate_$dropdownCount"));
										echo $this->Html->image('icons/plus_6.png',array('height'=>'16','weight'=>'14','id'=>'dropdown-add-new_'.$dropdownCount,'alt'=>'Add New','class'=>"dropdown-add-new"));
										echo $this->Html->image('icons/saveSmall.png',array('style'=>'display:none;','height'=>'16','weight'=>'14','id'=>'saveBtnTemplates_'.$dropdownCount,'alt'=>'Save Template','class'=>"saveBtnTemplates"));
										
										
										echo $this->Html->image('icons/refresh-icon.png',array('height'=>'16','weight'=>'14','alt'=>"Reset",'id'=>"reset-template_$dropdownCount",'class'=>'reset-template'));
										?>
										<div class="clr">
											<textarea placeholder=""
												id="dropdown-textarea_<?php echo $dropdownCount ;?>"
												class="dropdown-textarea"
												name="<?php echo $textAreaName ;?>"><?php echo trim($extra_btn_options['extra_textarea_data'][$dropdownCount]) ;?></textarea>
											<textarea placeholder="Add new option"
												id="add-new-dropdown-textarea_<?php echo $dropdownCount ;?>"
												class="add-new-dropdown-textarea"></textarea>
										</div>
										<div class="clr view-template-list"
											id="view-template_<?php echo $dropdownCount; ?>"></div>
									</div>
								</div> <!-- EOF button template text by pankaj --> <?php    
								//}//EOF has dropdown condition
							 } //EOF OTHER condition ?>
							</td>
							<?php $display = ($subkey['sub_category'] == 'OTHER' && $rosChked == 'checked')? 'block': 'none';$r++; 
							$rowChng = $r;
						}
						if($inRowCount){
							$totalCount++;
							$inRowCount=false;
						}
						$i++;
						?>
							<?php  $temp = 0;?>
							<?php foreach($patientSpecificOption as $key=>$patientOptions){ ?>
							<?php if($rowChng%4==0) echo "</tr><tr>" ;?>
							<td class="radio_check"
								id="<?php echo $datakey['Template']['id'].$temp."_removableTd"?>"
								style="width: 100%; display: inline; border-bottom: 1px solid #424A4D; padding: 0 0 0 10px;">
								<?php echo $this->Form->hidden('',array('label' => $key,'type'=>'checkbox','id'=>$dataRose.'_'.$datakey['Template']['id'].$temp."_patentSpecificValue",
										'value'=>$patientOptions,'name'=>"data[subCategory_examination][".$datakey['Template']['id']."][patient_specific_template][".$key."]",
							'checked'=>true,'autocomplete'=>'off','multiple'=>'checkbox'));?>
								<?php  if($patientOptions == 1){
									$labelColor = 'addClassColor';
								}elseif($patientOptions == 2){
									$labelColor = 'addClassTomato';
								}else$labelColor = 'addClassWhite';?> 
								<label
								class="dClick1 changeColor <?php echo 'NotNegativeExceptHPI'.$dataRose.' '.$labelColor?>"
								id="<?php echo $dataRose.'_'.$datakey['Template']['id'].$temp;?>_patentSpecific">
									<?php echo $key;?> <?php echo $this->Html->image('icons/inactive.jpg',array('style'=>'float: right;','id'=>$datakey['Template']['id'].$temp."_removableTd",'class'=>'removeTd'));?>
							</label>
							</td>
							<?php $rowChng++; $temp++;
						}
						$rowTdTempArray[$datakey['Template']['id']] = $temp;
				$rowTdArray[$datakey['Template']['id']] = $rowChng;?>
						</tr>
						<tr id="<?php echo $datakey['Template']['id'];?>ForTr">
							<td style="display:<?php echo $display; ?>" id= '<?php echo $datakey['Template']['id'];?>'><span><?php  
							echo $this->Html->link($this->Html->image('icons/plus_6.png' ),"javascript:void(0)",array(id=>'other_'.$dataRose,'onclick'=>"addButton(".$datakey['Template']['id'].",".$dataRose.")",'escape'=>false)); ?>
							</span> <?php echo $this->Form->input('',array('id'=>'other_'.$datakey['Template']['id'],'type'=>'text','name'=>"data[subCategory_examination][textbox2][".$datakey['Template']['id']."]",'autocomplete'=>'off' ));?>
							</td>
						</tr>
					</table>
					<table width="100%"
						id="extraDataDisplay_<?php echo $datakey['Template']['id']."_";?>">
						<?php if(!empty($extraDataShow))?>
						<tr>
							<?php  if(!empty($extraDataShow)){  ?>
							<td><?php  
							echo $this->Form->input('',array('type'=>'text','value'=>$extraDataShow[$datakey['Template']['id']][$myCnt]['TemplateMiddleCategory']['name'],
									'name'=>'extra1[name][]','label'=>false,'placeholder'=>'Add Site Name'));
					?>
							</td>
						</tr>
						<tr>
							<td class="radio_check" id="radiocheck"
								style="width: 100%; display: inline; border-bottom: 1px solid #424A4D;">
								<?php foreach($roseData as $key=>$unserialData){//(2)
								if($unserialData['Template']['id']==$datakey['Template']['id']){//(3)
												foreach($extraDataShow[$datakey['Template']['id']] as $keyNew=>$newExtraDataShow){

													$newIdArray=unserialize($newExtraDataShow['TemplateMiddleCategory']['descriptions']);
													foreach($unserialData['TemplateSubCategories'] as $moreSubData){//(4)
																if($newIdArray[$moreSubData[id]]=='1'){//(5)
																			$subText=$subCategory;
																			$colornew='addClassColor';
																			$setValueNew='1';
																}
																else{
																	$setValueNew='';
																}//(5)
																/* echo $this->Form->input('',array('type'=>'text','value'=>$newExtraDataShow['TemplateMiddleCategory']['name'],
																 'name'=>'extra1[name][]','label'=>false,'placeholder'=>'Add Site Name')); */
																echo $this->Form->hidden('',array('label'=>false,'name'=>'data[extra][ids][]','value'=>$moreSubData['template_id']));
																$nameExtra="data[extra1][".$moreSubData['template_id']."][".$moreSubData['id']."]" ;
																echo $this->Form->hidden('',array('label' => $moreSubData['sub_category'],'type'=>'checkbox',
															'onclick'=>"setValNew('".trim($newData['TemplateSubCategories']['id'])."','reset-input-examination','".$newData['TemplateSubCategories']['template_id']."')",
															'id'=>$moreSubData['id']."_".$moreSubData['template_id'],'class'=>'rad',
															'value'=>$setValueNew,/*'style'=>'background:'.$color,*/'name'=>$nameExtra ,'autocomplete'=>'off','multiple'=>'checkbox','div'=>false));?>
								<label class='dClick <?php echo $colornew;?>'
						id='<?php echo $moreSubData['id']."_".$moreSubData['template_id']."_"."myIdNew"?>' ><?php echo $moreSubData['sub_category'];$colornew ='';?>
							</label> <?php } 
}//(4)
                                		}//(3)
					}$myCnt++;//(2)
					?>
							</td>
						</tr>
						<?php }//(1)}?>
						<tr>
							<td></td>
						</tr>
					</table>
					<?php 
					//echo $this->Form->hidden('',array('name'=>$newName,'id'=>$newId,'value'=>$subText,'autocomplete'=>'off'));
					$subText="";
					?>
				</tr>
				<?php } $i++;
				}?>
			</table>
		
		<td valign="top">
			<!-- BOF body chart -->
			<table>
				<tr>
					<td><?php 

					$coordinates  = unserialize($bodyChartData['Note']['body_mark_cordinates']) ;
					$chartDesc    = unserialize($bodyChartData['Note']['body_mark_desc']) ;

					echo $this->Form->input('',array('type'=>'select','value'=>$coordinates['template_id'][0],'name'=>'data[subCategory_examination][template_id][]','options'=>$componentArray,'class'=>'componentOption','id'=>'component_1'));?>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<div id="whdiagram_1" style="float: left;" class="wh_diagram">
							<?php   
							echo $this->Form->hidden('',array('name'=>'','id'=>'body_mark_cordinates'));
							echo $this->Html->image('men.jpg',array('class'=>'diagram' ));
							//pr($coordinates);
							$firstCoordinate = $coordinates['body_mark_cordinates'][1] ;
							if(!empty($firstCoordinate)){
									$pinCount  = count($firstCoordinate) ;
									foreach($firstCoordinate as $key => $value){
										if($value) $xy = explode(":",$value) ;
										else continue ;
										echo $this->Html->image('pin.gif',array('style'=>"position: absolute;left:$xy[0]px;top:$xy[1]px",'id'=>"wh-pin$key" ,'class'=>'wh-pin-edited_1'));
										echo $this->Form->hidden('',array('name'=>'data[subCategory_examination][body_mark_cordinates][1][]','id'=>"coordinate-wh-pin$key",'value'=>$value,'class'=>'wh-pin-edited_1'));
									}
								} else $pinCount = 0 ;
								echo $this->Html->image('pin.gif',array('style'=>'','id'=>"wh_pin",'style'=>'display:none;'));
								?>
						</div>
					</td>
					<td valign="top"><input type="button" value="Reset"
						class="reset-chart" class="BlueBtn" id="reset-1">
					</td>
				</tr>
				<tr>
					<td colspan="2"><?php 
					echo $this->Form->textarea("",array('value'=>$chartDesc[0],'name'=>'data[subCategory_examination][body_mark_desc][]','class'=>"textarea",'style'=>'resize:both;','id'=>'body_mark_desc'));
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('',array('type'=>'select','type'=>'select','value'=>$coordinates['template_id'][1],'name'=>'data[subCategory_examination][template_id][]','options'=>$componentArray,'class'=>'componentOption','id'=>'component_2'));?>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<div id="whdiagram_2" style="float: left;" class="wh_diagram">
							<?php  
							echo $this->Html->image('men.jpg',array('class'=>'diagram' ));
							$secondCoordinate = $coordinates['body_mark_cordinates'][2] ;
							//pr($secondCoordinate);;
							if(!empty($secondCoordinate)){
									$pinCount  = count($secondCoordinate) ;
									foreach($secondCoordinate as $key => $value){
										if($value) $xy = explode(":",$value) ;
										else continue ;
										echo $this->Html->image('pin.gif',array('style'=>"position: absolute;left:$xy[0]px;top:$xy[1]px",'id'=>"wh-pin$key" ,'class'=>'wh-pin-edited_2'));
										echo $this->Form->hidden('',array('name'=>'data[subCategory_examination][body_mark_cordinates][2][]','id'=>"coordinate-wh-pin$key",'value'=>$value,'class'=>'wh-pin-edited_2'));
									}
								}	else $pinCount = 0 ;
								//echo $this->Html->image('pin.gif',array('style'=>'','id'=>"wh_pin",'style'=>'display:none;'));
								?>
						</div>
					</td>
					<td valign="top"><input type="button" value="Reset"
						class="reset-chart" id="reset-2">
					</td>
				</tr>
				<tr>
					<td colspan="2"><?php 
					echo $this->Form->textarea("",array('value'=>$chartDesc[1],'name'=>'data[subCategory_examination][body_mark_desc][]','class'=>"textarea",'style'=>'resize:both;','id'=>'body_mark_desc'));
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('',array('value'=>$coordinates['template_id'][2],'name'=>'data[subCategory_examination][template_id][]','options'=>$componentArray,'class'=>'componentOption','id'=>'component_3'));?>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<div id="whdiagram_3" style="float: left;" class="wh_diagram">
							<?php 

							echo $this->Html->image('men.jpg',array('class'=>'diagram' ));
							$thirdCoordinate = $coordinates['body_mark_cordinates'][3] ;
							//pr($thirdCoordinate);
							if(!empty($thirdCoordinate)){
									$pinCount  = count($thirdCoordinate) ;
									foreach($thirdCoordinate as $key => $value){
										if($value) $xy = explode(":",$value) ;
										else continue ;
										echo $this->Html->image('pin.gif',array('style'=>"position: absolute;left:$xy[0]px;top:$xy[1]px",'id'=>"wh-pin$key" ,'class'=>'wh-pin-edited_3'));
										echo $this->Form->hidden('',array('name'=>'data[subCategory_examination][body_mark_cordinates][3][]','id'=>"coordinate-wh-pin$key",'value'=>$value,'class'=>'wh-pin-edited_3'));
									}
								} else $pinCount = 0 ;
								//echo $this->Html->image('pin.gif',array('style'=>'','id'=>"wh_pin",'style'=>'display:none;'));
								?>
						</div>
					</td>
					<td valign="top"><input type="button" value="Reset"
						class="reset-chart" id="reset-3">
					</td>
				</tr>
				<tr>
					<td colspan="2"><?php 
					echo $this->Form->textarea("",array('value'=>$chartDesc[2],'name'=>'data[subCategory_examination][body_mark_desc][]','class'=>"textarea",'style'=>'resize:both;','id'=>'body_mark_desc'));
					?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $this->Form->hidden('hidden',array('name'=>'noteId','value'=>$noteId,'id'=>'noteId'));?>
<?php echo $this->Form->hidden('hidden',array('name'=>'patientId','value'=>$patientId,'id'=>'patientId'));
echo $this->Form->hidden('TemplateType.note_template_id',array('value'=>$this->params->query['note_Template']));?>
<?php echo $this->Form->hidden('',array('name'=>'DiagnosisId','value'=>$diagnosisId));?>
<table width=100%>
	<tr>
		<td style="text-align: right; width: 100%"><?php echo $this->Form->input('Submit',array('type'=>'submit','class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false));?>

		</td>
	</tr>
</table>
<?php echo  $this->Form->end();?>
<?php if($this->params->query['organ_system']=='General Multi-System Examination'){
	$showChart = true;?>
<table style="border: solid 1px #000; margin: 0 0 0 10px;"
	cellspacing="0" cellpadding="0" width="67%">
	<tr>
		<td width="12%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">Level
			of Exam</td>
		<td width="42%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">Required
			elements</td>
		<td width="5%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">No.
			of documented elements in this doc.</td>
		<td width="5%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">Additional
			elements required to qualify</td>
		<td
			style="font-size: 11px; border-bottom: solid 1px #000; text-align: center;">Status
			Bar</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Problem focused</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">1-5</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php
			echo $sysExam;?>
		</td>
		<td id="count1"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php 
			if($sysExam>=1){
		 echo '0';
		 $percent1='100';
		}else{
			$req=1-$sysExam;
			echo $req;
			$percent1=($sysExam/1)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart1">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent1.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart1", "300", "45", "0", "0", "datastring", "ledChart1"); ?>

		</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Expanded problem focused</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">> or +=6</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $sysExam;?></td>
		<td id="count2"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php
			if($sysExam>=6){
		 echo '0';
		 $percent2='100';
		}else{
			$req=6-$sysExam;
			echo $req;
			$percent2=($sysExam/6)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart2">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent2.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart2", "300", "45", "0", "0", "datastring", "ledChart2"); ?>

		</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Detailed</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">2 from each of at least 6 organ systems or atleast 12 in
			2 systems</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $sysExam;?></td>
		<td id="count3"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php 
			$detailed=2;
			if($sysExam>=2){
		 echo '0';
		 $percent3='100';
		}else{
			$req=2-$sysExam;
			echo $req;
			$percent3=($sysExam/2)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart3">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent3.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart3", "300", "45", "0", "0", "datastring", "ledChart3"); ?>

		</td>
		</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Comprehensive</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">All elementsin at least 9 organs and >or = 2 for each of
			9 systems</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $sysExam;?></td>
		<td id="count4"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php
		 if($sysExam>=9){
		   echo '0';
		   $percent4='100';
		 }
		 else{
			$req=9-$sysExam;
			echo $req;
			$percent4=($sysExam/9)*100;
		}?></td>
		<td style="font-size: 11px">
			<div id="ledChart4">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent4.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart4", "300", "45", "0", "0", "datastring", "ledChart4"); ?>

		</td>
	</tr>

</table>
<?php }


if($this->params->query['organ_system']=='Cardiovascular'){
$showChart = true;?>
<table style="border: solid 1px #000; margin: 0 0 0 10px;"
	cellspacing="0" cellpadding="0" width="67%">
	<tr>
		<td width="12%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">Level
			of Exam</td>
		<td width="42%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">Required
			elements</td>
		<td width="5%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">No.
			of documented elements in this doc.</td>
		<td width="5%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">Additional
			elements required to qualify</td>
		<td
			style="font-size: 11px; border-bottom: solid 1px #000; text-align: center;">Status
			Bar</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Problem focused</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">1-5</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php
			echo $sysExam;?>
		</td>
		<td id="count1"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php 
			if($sysExam>=1){
		 echo '0';
		 $percent1='100';
		}else{
			$req=1-$sysExam;
			echo $req;
			$percent1=($sysExam/1)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart1">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent1.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart1", "300", "45", "0", "0", "datastring", "ledChart1"); ?>

		</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Expanded problem focused</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">> or +=6</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $sysExam;?></td>
		<td id="count2"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php
			if($sysExam>=6){
		 echo '0';
		 $percent2='100';
		}else{
			$req=6-$sysExam;
			echo $req;
			$percent2=($sysExam/6)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart2">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent2.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart2", "300", "45", "0", "0", "datastring", "ledChart2"); ?>

		</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Detailed</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">At least twelve elements identified by a bullet (>=12)</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $sysExam;?></td>
		<td id="count3"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php 
			$detailed=12;
			if($sysExam>=12){
		 echo '0';
		 $percent3='100';
		}else{
			$req=12-$sysExam;
			echo $req;
			$percent3=($sysExam/12)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart3">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent3.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart3", "300", "45", "0", "0", "datastring", "ledChart3"); ?>

		</td>
		</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Comprehensive</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">All elementsin at least 9 organs and >or = 2 for each of
			9 systems</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $sysExam;?></td>
		<td id="count4"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php
		 if($sysExam>=9){
		   echo '0';
		   $percent4='100';
		 }
		 else{
			$req=9-$sysExam;
			echo $req;
			$percent4=($sysExam/9)*100;
		}?></td>
		<td style="font-size: 11px">
			<div id="ledChart4">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent4.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart4", "300", "45", "0", "0", "datastring", "ledChart4"); ?>

		</td>
	</tr>

</table>
<?php }
}?>
<div class="inner_title"></div>
<script>  
//detailed is the count of details section of the chart table Different count for different conditions
var detailed="<?php echo $detailed;?>"; 

//BOF To render dynamic chart
function renderChart(chartId,ledChart,percent){ 
	percent4 = percent ;
	datastring = '<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'+percent4+'</value></chart>';
    FusionCharts.setCurrentRenderer("JavaScript"); 
    var chart = new FusionCharts("/fusionwx_charts/HLED.swf", chartId, "300", "45", "0", "0" );
        chart.setXMLData(datastring);
        chart.setTransparent(true);
        chart.render(ledChart);  
	} 
	//EOF To render dynamic chart
	
$(".dClick").dblclick(function (event) {
    //event.preventDefault();
    if($(this).hasClass('restrictRed'))return false;
	 var CurrentId=$(this).attr('id');
	 $('#'+CurrentId).removeClass('addClassWhite addClassColor');	
	 $('#'+CurrentId).addClass('addClassTomato');
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];	 
	 $('#'+hiddenId).val('2');
	 if(showChart)
	 chartCount(CurrentId);

});
	
$(".dClick").click(function (event) {
	 //event.preventDefault();
	 var CurrentId=$(this).attr('id');
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];	
	 if( $('#'+hiddenId).val().length == 0 ) {
		 $('#'+CurrentId).removeClass('addClassWhite addClassTomato');
		 $('#'+CurrentId).addClass('addClassColor');
	 		$('#'+hiddenId).val('1');
	 		
	}else{
		$('#'+CurrentId).removeClass('addClassTomato addClassColor');
		 $('#'+CurrentId).addClass('addClassWhite');
		 	$('#'+hiddenId).val('');
	} 
		if(showChart)
	chartCount(CurrentId);
});
var showChart = "<?php echo $showChart; ?>";
var finalCount = parseInt('<?php echo $i;?>');
var rSelect=0;
var rCount=0;
//BOF status bar Charts In table 
function chartCount (CurrentId) {
CurrentIdSplit=CurrentId.split('_');
var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
var quaCount1=$('#count1').html();
var quaCount2=$('#count2').html();
var quaCount3=$('#count3').html();
var quaCount4=$('#count4').html();
 	//BOF button count
 		
 		//var fruits = {};
 		for (var i=0; i <= finalCount; i++) { 
 			currentClass = 'template_category_'+i ;
	 		$('.'+currentClass).find('input[type=hidden]').each(function(index, value) {	
		 			curID = this.id;	 		
	 				val = parseInt($(this).val()); 
	 				if(!isNaN(val) && (val == 1 || val==2) && $(this).attr('label') != 'Negative except HPI' && curID.indexOf("dropdown") < 0 ){  
	 					rCount++;  
 					} 
 			}); 
 		} 
 		//BOF Table data count and chart draw
		if(rCount=='0'){
			$('#count1').html(1);
			$('#count2').html(6);
			$('#count3').html(detailed);
			$('#count4').html(9);
		} 

		if(quaCount1==0 && rCount>=1){
	    	var percent1='100';
			$('#count1').html('0');
			cId1=Math.ceil((Math.random() * 100) + 1); 
	    	chartId1="chart"+cId1;
	    	renderChart(chartId1,"ledChart1",percent1);
	    }else{
	    	quaCount1=1-parseInt(rCount);
			percent1=(parseInt(rCount)/1)*100;
			$('#count1').html(quaCount1);
			cId1=Math.floor((Math.random() * 100) + 1); 
	    	chartId1="chart"+cId1;
	    	renderChart(chartId1,"ledChart1",percent1);
	    }
		if(quaCount2==0 && rCount>=6){
			var percent2='100';
			$('#count2').html('0');
			cId2=Math.ceil((Math.random() * 200) + 1); 
	    	chartId2="chart"+cId2;
	    	renderChart(chartId2,"ledChart2",percent2);
		}
		else{
			quaCount2=6-parseInt(rCount);
			percent2=(parseInt(rCount)/6)*100;
			$('#count2').html(quaCount2);
			cId2=Math.floor((Math.random() * 200) + 1); 
	    	chartId2="chart"+cId2;
	    	renderChart(chartId2,"ledChart2",percent2);				
		}
		if(quaCount3==0 && rCount>=detailed){
			var percent3='100';
			$('#count3').html('0');
			cId3=Math.ceil((Math.random() * 300) + 1); 
	    	chartId3="chart"+cId3;
	    	renderChart(chartId3,"ledChart3",percent3);
		}
		else{
			quaCount3=detailed-parseInt(rCount);
			percent3=(parseInt(rCount)/detailed)*100;
			$('#count3').html(quaCount3);
			cId3=Math.floor((Math.random() * 300) + 1); 
	    	chartId3="chart"+cId3;
	    	renderChart(chartId3,"ledChart3",percent3);				
		}
		if(quaCount4==0 && rCount>=9){
			var percent4='100';
			$('#count4').html('0');
			cId4=Math.ceil((Math.random() * 400) + 1); 
	    	chartId4="chart"+cId4;
	    	renderChart(chartId4,"ledChart4",percent4);
		}
		else{
			quaCount4=9-parseInt(rCount);
			percent4=(parseInt(rCount)/9)*100;
			$('#count4').html(quaCount4);
			cId4=Math.floor((Math.random() * 400) + 1); 
	    	chartId4="chart"+cId4;
	    	renderChart(chartId4,"ledChart4",percent4);				
		}
	    $('.hpiCount').html(rCount);
	    rCount=0;
}	


$(".dClick_Ros").dblclick(function (event) {
	if($(this).hasClass('restrictRed'))return false;
	 var CurrentId=$(this).attr('id');
	 $('#'+CurrentId).removeClass('addClassWhite addClassColor');
	 $('#'+CurrentId).addClass('addClassTomato');
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1]+"_";
	 $('#'+hiddenId).val('2'); 
});

$(".dClick_Ros").click(function (event) {
   var CurrentId=$(this).attr('id');
   CurrentIdSplit=CurrentId.split('_');
   var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1]+"_";

   if( $('#'+hiddenId).val().length == 0 ) {
	   $('#'+CurrentId).removeClass('addClassWhite addClassTomato');
		 $('#'+CurrentId).addClass('addClassColor');
 		$('#'+hiddenId).val('1');
	}else{
		 $('#'+CurrentId).removeClass(' addClassTomato addClassColor');
		 $('#'+CurrentId).addClass('addClassWhite');
	 	$('#'+hiddenId).val('');
	}

});

$(document).ready(function(){
	$('#submit , #submit1 , #submit2').click(function(){
		$('#submit2').hide();
		$('#submit1').hide();
		$('#submit').hide();
		
		});
	
	
	var noteIdClose= '<?php echo $noteIdClose; ?>';
	if(noteIdClose!=''){
		$( '#flashMessage', parent.document ).html('Physical Examination Added Successfully');
		$( '#flashMessage', parent.document ).show();
		$( '#familyid', parent.document ).val(noteIdClose);
	  	$( '#ccid', parent.document ).val(noteIdClose);
	  	$( '#subjectNoteId', parent.document ).val(noteIdClose);
	  	$( '#assessmentNoteId', parent.document ).val(noteIdClose);
	  	$( '#objectiveNoteId', parent.document ).val(noteIdClose);
	  	$( '#planNoteId', parent.document ).val(noteIdClose);
	  	 $('#signNoteId', parent.document ).val(noteIdClose);
	  	parent.$.fancybox.close();
		
	}
});  
	

function setVal(what,where,extra){ 
	if(what == 'OTHER'){
		$('#'+extra).toggle();
	} 
	 
	$("#"+where).val(what) ;
}
$('#submit1').click(function(){
	var noteId=$('#noteId').val();
	if(noteId==''){
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "systemicExamination","admin" => false)); ?>"+"/"+'<?php echo $patientId?>';
	}else{
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "systemicExamination","admin" => false)); ?>"+"/"+'<?php echo $patientId?>'+'/'+noteId;
	}
	
	var formData = $('#TemplateTypeContent').serialize();
	  $.ajax({
      	beforeSend : function() {
      		$('#busy-indicator').show('fast');
      	},
      	type: 'POST',
      	url: ajaxUrl,
      	data: formData,
      	dataType: 'html',
      	success: function(data){
          	
      		$( '#familyid', parent.document ).val(data);
          	$( '#ccid', parent.document ).val(data);
          	$( '#subjectNoteId', parent.document ).val(data);
          	$( '#assessmentNoteId', parent.document ).val(data);
          	$( '#objectiveNoteId', parent.document ).val(data);
          	$( '#planNoteId', parent.document ).val(data);
          	 $('#signNoteId', parent.document ).val(data);
      		$('#busy-indicator').hide('fast');
      		alert('Data Save Successfully.'); 
	        
      },
		});
	
});
/*var counter=0;
function addButton(name,id) { 
	var basicName=name+"["+id+"_"+counter+"]";
	var newCostDiv = $(document.createElement('tr'))
	     .attr("id", 'appendTable' + counter);
var newHTml = '<td valign="top"><input type="text" style="width:158px!important;" value="" id="TemplateTextBox" name='+basicName+' autocomplete="off" counter='+counter+'><a href="javascript:void(0)" onclick="removeButton('+counter+','+id+')"></a></td>'; 			 			 
newCostDiv.append(newHTml);		 
newCostDiv.appendTo("#appendTable"+id);		
 			 
counter++;
if (counter > 0)
	$('#appendTable'+id).show('slow');
}

function removeButton(counter) {
	counter--;
	$("#appendTable"+counter).remove();
}*/

//function of body chart by pankaj W
$(function(){
	//var $j = jQuery.noConflict();
 	var k = <?php echo $pinCount ;?> ; 
    $(document).ready(function(){
    	$(".wh_diagram").click(function(e){  
    		var pin = $("#wh_pin").clone() ;  
    		currentIDCnt = $(this).attr('id').split("_")[1] ;
    		 
    		var placeHolder =$("#body_mark_cordinates").clone();
    		currentId  = "#"+$(this).attr('id');
			$(currentId).append(pin);
			$(currentId).append(placeHolder);
			var xy = $(currentId).offset(); 
			 
			pin.css('display','') ;
			pin.css('position',"absolute"); 
			//pin.css('left',(e.pageX - xy.left)-7 + "px");
			//pin.css('top',(e.pageY - xy.top)-7 + "px"); 
			x = (e.pageX)-7 ;
			y = (e.pageY)-7 ;
			pin.css('left',x + "px");
			pin.css('top',y + "px"); 
			pin.attr('id','wh-pin'+k);
			pin.attr('class','wh-pin_'+currentIDCnt); 
			//**********
			placeHolder.val(x+":"+y);
			placeHolder.attr('id','coordinate-wh-pin'+k);
			placeHolder.attr('class','wh-pin_'+currentIDCnt);
			if(currentIDCnt==2){ //to mainain 2nd and 3rd pin coordinates
				placeHolder.attr('name','data[subCategory_examination][body_mark_cordinates][2][]');
			}else if(currentIDCnt==3){
				placeHolder.attr('name','data[subCategory_examination][body_mark_cordinates][3][]');
			}else if(currentIDCnt==1){
				placeHolder.attr('name','data[subCategory_examination][body_mark_cordinates][1][]');
			}
			pin.bind("click", function() {  
				$(this).remove();  
				currentDelId = $(this).attr('id');  
				$("#coordinate-"+currentDelId).remove(); //place holder delete 
				return false ;
			}) 
			k++; 
		});
    });

    $(".reset-chart").click(function(){ 
        id= $(this).attr('id').split("-")[1]; 
        $(".wh-pin-edited_"+id).remove();
        $(".wh-pin_"+id).remove();
    });

    $(".wh-pin-edited_1 .wh-pin-edited_2 .wh-pin-edited_3").click(function(e){  
		currentDelId = $j(this).attr('id');   
		$j("#coordinate-"+currentDelId).remove(); //place holder delete 
		$j(this).remove(); 
		return false ; 
    });

    $(".componentOption").change(function(){ 
        id = $(this).attr('id').split("_")[1]; 
        $(".wh-pin-edited_"+id).remove();
        $("#coordinate-wh-pin"+id).remove(); //place holder delete 
    });
});

//changed live to on by pankaj
$('.addExtraDataClass').on('click',function(){
	var currentId=$(this).attr('id')
	 var ajaxUrl1 = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "callExtraInfo","admin" => false)); ?>";
	  $.ajax({
      	beforeSend : function() {
      		$('#busy-indicator').show('fast'); 
      	},
      	type: 'POST',
      	url: ajaxUrl1+"/"+'2'+"/"+currentId,// tempate_id and temaplete subId
      	dataType: 'html',
      	success: function(data){
      		$('#busy-indicator').hide('fast');
      		//$('#extraDataDisplay_'+currentId).html(data);
      		var newCostDiv1 = $(document.createElement('tr'))
   	     .attr("id", 'appendTable' + counter);
      		newCostDiv1.append(data);		 
      		newCostDiv1.appendTo('#extraDataDisplay_'+currentId);	
	        	},
	  }); 
});
var DELAY = 200, clicks = 0, timer = null;

$(document).ready(function(){
	//$(".dropdown dt a").on('click', function () {
	$(".dropdown-anchor").on('click', function (e) { 
		e.stopPropagation();
		currentID = $(this).attr('id') ; 
		currentParentClass = currentID.split("-")[1]; 
		if($('input.'+currentParentClass).val() == ''  )return false;
		var xy = $(currentID).offset(); 
		x = (e.pageX)+10;
		y = (e.pageY)+10 ; 
		selCount = currentID.split("-")[1] ;
		$(".dropdown").hide(); //hide all dropdown  
        $("#ul-dropdown-"+selCount).toggle('fast').css('left',x + "px").css('top',y + "px"); //show selected dropdown  
    });
    

    $(".dropdown dd ul li a").on('click', function () {
        $(".dropdown dd ul").hide();
    });

    function getSelectedValue(id) {
         return $("#" + id).find("dt a span.value").html();
    }

    $(document).bind('click', function (e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
    });
//save btn template
    
    //add new text template for individual button 
    // $(".dropdown-add-new").click(function(event){
    $(".dropdown-add-new").on('click',function(event){ 
            /*$(this).attr('src','<?php echo $this->webroot.'theme/'.$this->theme."/img/icons/saveSmall.png" ; ?>');
            $(this).removeClass("dropdown-add-new");
            $(this).addClass('saveBtnTemplates');*/

            currentID = $(this).attr('id').split("_")[1]; 
            $(this).hide();
            $("#saveBtnTemplates_"+currentID).show(); 
             //add class to call save event 
            //$(this).attr('class','saveBtnTemplates');  

            //hide default textarea  
            $("#dropdown-textarea_"+currentID).hide(); //hide all textarea 
            $(".add-new-dropdown-textarea").hide(); //hide all textarea 
            $("#add-new-dropdown-textarea_"+currentID).show();//display current textarea 
            //display reset btn 
            $("#reset-template_"+currentID).show();
            $("#view-template_"+currentID).hide();
            //event.stopPropagation();
            //return false ;
    }) ;

	//reset to previous step
	$(".reset-template").on('click',function(event){ 
    	//save template 
        currentID = $(this).attr('id').split("_")[1]; 


        $("#dropdown-add-new_"+currentID).show();
		$("#saveBtnTemplates_"+currentID).hide();
        
    	//$("#dropdown-add-new_"+currentID).removeClass("saveBtnTemplates").addClass('dropdown-add-new');  
    	//$("#dropdown-add-new_"+currentID).attr('src','<?php echo $this->webroot.'theme/'.$this->theme."/img/icons/plus_6.png" ; ?>');

    	
        //hide default textarea  
        $("#dropdown-textarea_"+currentID).show(); //hide all textarea 
        $(".add-new-dropdown-textarea").show(); //hide all textarea 
        $("#add-new-dropdown-textarea_"+currentID).hide();//display current textarea 
        //display reset btn 
        $("#reset-template_"+currentID).hide();
	});

	
	$(".saveBtnTemplates").click(function(){ 
		currentID = $(this).attr('id') ;
	    btnTemplateID = $(this).attr('id').split("_")[1] ;
	    formData = $("#add-new-dropdown-textarea_"+btnTemplateID).val(); 
	    //save template 
		$.ajax({
		      	beforeSend : function() {
		      		//loading("btnTemplateArea",'class');
		      		$("#busy-indicator").show();
		      	},
		      	type: 'POST',
		      	url: "<?php echo $this->Html->url(array('controller'=>'templates','action'=>'addNewBtnTemplateText'));?>/"+btnTemplateID,
		      	data: "extra_options_by_user="+formData,
		      	dataType: 'html',
		      	success: function(data){ 
		      		$("#busy-indicator").hide();
		      		onCompleteRequest("btnTemplateArea",'class');
		      		//reset to original position
		      		//$("#"+currentID).removeClass("saveBtnTemplates").addClass('dropdown-add-new');  
		            $(".add-new-dropdown-textarea").hide(); //hide all textarea    
		            $("#dropdown-textarea_"+btnTemplateID).val($("#dropdown-textarea_"+btnTemplateID).val()+" "+formData).show();
		            $("#dropdown-add-new_"+btnTemplateID).show();
		            $("#add-new-dropdown-textarea_"+btnTemplateID).val('');
		            $("#saveBtnTemplates_"+btnTemplateID).hide();
		            //$("#"+currentID).attr('src','<?php echo $this->webroot.'theme/'.$this->theme."/img/icons/plus_6.png" ; ?>');
		            //display reset btn 
		            $(".reset-template").hide();
		      	},
		});  
	});
    
	


    //select from previously added button template text
	$(".viewBtnTemaplate").click(function(){
		btnTemplateID = $(this).attr('id').split("_")[1] ;
		$.ajax({
	      	beforeSend : function() {
	      		//loading("dropdown",'class');
	      		$("#busy-indicator").show();
	      	},
	      	type: 'POST',
	      	url: "<?php echo $this->Html->url(array('controller'=>'templates','action'=>'viewBtnTemplateText'));?>/"+btnTemplateID, 
	      	dataType: 'html',
	      	success: function(data){  
	      		$("#view-template_"+btnTemplateID).html(data).fadeIn();
	      		//onCompleteRequest("dropdown",'class');
	      		$("#busy-indicator").hide();
	      	},
		});
	});

	//
	/*$(".search-btn-template").on('click',function(){
		currentID = $(this).attr('id') ;
	    btnTemplateID = $(this).attr('id').split("_")[1] ;
	    alert(formData);
		$("#dropdown-textarea_"+btnTemplateID).val($("#dropdown-textarea_"+btnTemplateID).val()+" "+formData).show();
	});*/

    
	//display selection
   $('.dropdown input[type="checkbox"]').on('click', function () { 
       var title = $(this).closest('.dropdown').find('input[type="checkbox"]').val(),
            title = $(this).val() + ","; 
        if ($(this).is(':checked')) {
            var html = '<span title="' + title + '">' + title + '</span>';
            $('.multiSel').append(html);
            $(".hida").hide();
        } 
        else {
            $('span[title="' + title + '"]').remove();
            var ret = $(".hida");
            $('.dropdown dt a').append(ret); 
        }
    });  

   //add clicked text in textarea from the added screen
   //$(document).on("click",".search-btn-template",(function(){ 
	$(".view-template-list").on('click',".search-btn-template", function() {			 
	   btnTemplateID = $(this).attr('id').split("_")[1].split("-")[0] ; //current clicked counter  
	   selHtml = $(this).html() ;  
	   $("#dropdown-textarea_"+btnTemplateID).val($("#dropdown-textarea_"+btnTemplateID).val()+" "+selHtml); 
   });

   $(".view-template-list").on('click',".delete-template",function(){
	   currentID = $(this).attr('id') ;
	   //btnTemplateID = $(this).attr('id').split("_")[1] ; //current clicked counter 
	   //splittedID =  btnTemplateID.split("-") ;
	   $(this).remove(); //remove clicked item 
	  
	   $("#search-btn-template_"+currentID).remove();//remove name and cross button 
	   $.ajax({
	      	beforeSend : function() {
	      		//loading("dropdown",'class');
	      		$("#busy-indicator").show();
	      	},
	      	type: 'POST',
	      	url: "<?php echo $this->Html->url(array('controller'=>'templates','action'=>'deleteBtnTemplateText'));?>/"+currentID, 
	      	dataType: 'html',
	      	success: function(data){ 
	      		$("#busy-indicator").hide();
	      	},
		});
   })
   
   /*$(".dropdown-textarea").on("keyup", function(e){ 
	   var elmentId = $(this).attr('id').split("_")[1];
	   var restrictedRed = $('label.'+elmentId).hasClass('restrictRed');
	   if(!restrictedRed){
		    if($.trim($(this).val()) != ''){
		    	$('label.'+elmentId).removeClass('addClassWhite addClassTomato');
		    	$('label.'+elmentId).addClass('addClassColor');
			   $('input.'+elmentId).val('1');
		   }else{
			   $('label.'+elmentId).removeClass('addClassColor addClassTomato');
		    	$('label.'+elmentId).addClass('addClassWhite');
			   $('input.'+elmentId).val('');
		   }
	   }
   });*/
   
   
   $(".dropdown-btn").on("click", function(e){ 
       clicks++;  //count clicks 
       clickedID = $(this).attr('id') ; 
       btnTemplateID = clickedID.split("_")[1] ; //current clicked counter
       if(clicks === 1){ 
           timer = setTimeout(function(){    
        	   $("#"+clickedID).removeClass("addClassTomato").removeClass("addClassWhite").removeClass('addClassColor') ;
			   currentDropdownBtnVal = $("#dropdown-btn_"+btnTemplateID).val() ; 
        	   if( currentDropdownBtnVal  == 0 ){
          	   		//$('#'+CurrentId).css({'background-color':'palegreen'});
          	   		$("#"+clickedID).addClass("addClassColor");
          	   		$("#dropdown-btn_"+btnTemplateID).val('1');
	           }else{
	        	   $("#"+clickedID).addClass('addClassWhite');
	           		$("#dropdown-btn_"+btnTemplateID).val('0');
	           }   
               clicks = 0; //after action performed, reset counter 
             
           }, DELAY); 
       }else if( $('#'+clickedID).hasClass('redAllow') ){  
    	   clearTimeout(timer);  
    	   $("#dropdown-btn_"+btnTemplateID).val('2');
    	   $("#"+clickedID).removeClass("addClassColor").removeClass("addClassWhite") ;
    	   $("#"+clickedID).addClass("addClassTomato"); 
           clicks = 0;             //after action performed, reset counter 
           e.preventDefault();
       }else{
    	   clicks = 0;
       }
   }).on("dblclick", function(e){ 
	   clearTimeout(timer);    //prevent single-click action 
       e.preventDefault();  //cancel system double-click event
   }); 


	//hide dropdown box on document link 
   $('html').click(function() {
		//Hide the menus if visible
	   $(".dropdown").hide();
	});

	$(".dropdown").click(function(event){
		event.stopPropagation(); //stop html click hide
	});

	
});
/* addClassWhite addClassTomato addClassColor');*/
var rowTdArray = <?php echo  json_encode($rowTdArray);?>;
var rowTdTempArray = <?php echo  json_encode($rowTdTempArray);?>;
function addButton(templateId, tableNumber){
	if(parseInt(rowTdArray[templateId])%4 == 0 ){
		$('#'+templateId+'TemplateTable tr:last').before($('<tr>').append($('<td class="radio_check newAddedLabel">')
					.attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd")
				.append($('<input>').attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecificValue').attr('value', '1').attr('type', 'hidden')
						.attr('name', 'data[subCategory_examination]['+templateId+'][patient_specific_template]['+$('input#other_'+templateId).val()+']'))
	 		   .append($('<label>').attr('id', tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecific')
	 		 		   .addClass('changeColor addClassColor').text($('#other_'+templateId).val())
	 		 		   .append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/icons/inactive.jpg").addClass('removeTd')
	 		 		 		   .attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd").css('float', 'right').attr('abbr',templateId)))));
	}else{
		$('#'+templateId+'ForTr').prev().append($('<td class="radio_check newAddedLabel">').attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd")
			.append($('<input>').attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecificValue').attr('value', '1').attr('type', 'hidden')
					.attr('name', 'data[subCategory_examination]['+templateId+'][patient_specific_template]['+$('input#other_'+templateId).val()+']'))
 		   .append($('<label>').attr('id', tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecific')
 		 		   .addClass('changeColor addClassColor').text($('#other_'+templateId).val())
 		 		 		.append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/icons/inactive.jpg")/*.attr('onclick','removeTd()')*/.addClass('removeTd')
		 		 		   .attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd").css('float', 'right').attr('abbr',templateId))));
	}
	rowTdArray[templateId]++;
	rowTdTempArray[templateId]++;
	$('#other_'+templateId).val('');
	$('.NegativeExceptHPI'+tableNumber).removeClass('addClassColor');
}
$('.changeColorBlocked').on('click',function(){/** color change disabled for other butons */
	var thisId =$(this).attr('id');
	if($('#'+thisId+'Value').val() == '0'){
		$('#'+thisId+'Value').val('1')
		$(this).removeClass('addClassWhite addClassTomato');
		$(this).addClass('addClassColor');
	}else if($('#'+thisId+'Value').val() == '1' || $('#'+thisId+'Value').val() == '2'){
		$('#'+thisId+'Value').val('0')
		$(this).removeClass('addClassColor addClassTomato');
		$(this).addClass('addClassWhite');
	}
});
$('.changeColorBlocked').on('dblclick',function(){/** Red button not required for HPI (jst change class to dClick for red button ) */
	if($(this).hasClass('restrictRed'))return false;
	var thisId =$(this).attr('id');
	if($('#'+thisId+'Value').val() != '2'){
		$('#'+thisId+'Value').val('2');
		$(this).removeClass('addClassWhite addClassColor');
		$(this).addClass('addClassTomato');
	}else{
		$('#'+thisId+'Value').val('0');
		$(this).removeClass('addClassColor addClassTomato');
		$(this).addClass('addClassWhite');
	}
});

$(document).on('click','.removeTd',function() {
	var parentId= $(this)/*.closest(' td ')*/.attr('id');
	var templateIdTd = $(this).attr('abbr');
	$('td#'+parentId).remove();
	if(parseInt(rowTdArray[templateIdTd])%4 != 0 )
	rowTdArray[templateIdTd] = parseInt(rowTdArray[templateIdTd])-1;
});

</script>
