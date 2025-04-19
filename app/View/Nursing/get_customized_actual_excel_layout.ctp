<?php  
// 	echo $this->Html->script(array('inline_msg.js'));
?>
<!-- Actual Template -->
<style> 
	.test{margin-left:10px;} 
	.total{
		width:50px
	}
	/* Login Container (default to float:right) */
	#loginContainer {
	    position:relative;
	    float:right;
	    font-size:12px;
	    margin-top:40px;
	    z-index:100;
	    width:90px;
	}
	#registerLink {
			padding-top:10px;
		}
	#registerLink a {padding-left:10px; color:#0c8dc5; 
	    font-size:14px; 
	    font-weight:bold; }
	
	/* Login Button */
	#loginButton { 
	    display:inline-block;
	    float:right;
	    background:#ffffff; 
	    border:1px solid #cacaca; 
	    border-radius:3px;
	    -moz-border-radius:3px;
	    position:relative;
	    z-index:30;
	    cursor:pointer;
	}
	
	/* Login Button Text */
	#loginButton span {
	    color:#0c8dc5; 
	    font-size:14px; 
	    font-weight:bold; 
	    text-shadow:1px 1px #fff; 
	    padding:7px 25px 9px 10px;
	    background:url(../img/loginArrow.png) no-repeat 60px 9px;
	    display:block
	}
	
	#loginButton:hover {
	    background:#ffffff;
	}
	
	 
	
	/* If the Login Button has been clicked */    
	#loginButton.active {
	    border-radius:3px 3px 0 0;
	}
	
	#loginButton.active span {
	    background-position:60px -78px;
	}
	
	/* A Line added to overlap the border */
	#loginButton.active em {
	    position:absolute;
	    width:100%;
	    height:1px;
	    background:#ffffff;
	    bottom:-1px;
	} 
	
	
</style> 
<?php 
	function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	$dateString = clean($selectedDate) ;
	if($dateString == date('Y-m-d')){
?>
	<div id="loginBox">
		<ul>
			<li id="0" class="change-time-slot">
				<?php 
					$tickTick = $this->Html->image('../img/icons/icon_tick.gif', array('alt' => 'Save','title' => 'Save'));
					if($customTimeSlotResult[$dateString]==0) echo $tickTick ;
				?>
				Actual
			</li>
			<li id="15" class="change-time-slot">
				<?php  if($customTimeSlotResult[$dateString]==15) echo $tickTick ; ?>
				15 mins
			</li>
			<li id="30" class="change-time-slot">
				<?php  if($customTimeSlotResult[$dateString]==30) echo $tickTick ; ?>
				30 mins			
			</li>
			<li id="60" class="change-time-slot">
				<?php  if($customTimeSlotResult[$dateString]==60) echo $tickTick ; ?>
				1 Hour
			</li>
			<li id="120" class="change-time-slot">
				<?php  if($customTimeSlotResult[$dateString]==120) echo $tickTick ; ?>
				2 Hours
			</li>
			<li id="240" class="change-time-slot">
				<?php  if($customTimeSlotResult[$dateString]==240) echo $tickTick ; ?>
				4 Hours
			</li>
			<li id="480" class="change-time-slot">
				<?php  if($customTimeSlotResult[$dateString]==480) echo $tickTick ; ?>
				8 Hours
			</li>
		</ul>
	</div>
<?php } ?>
<table cellspacing="0" cellpadding="0" border="0" class=" row20px excel-format"   >
	<?php 	
	
	 
	foreach ($reviewData as $dataKey =>$dataValue){
		
		if(strlen($dataValue['ReviewPatientDetail']['hourSlot']) > 2){
			$convertedActualTime = $dataValue['ReviewPatientDetail']['actualTime']  ;
		}else{
			$convertedActualTime = $dataValue['ReviewPatientDetail']['hourSlot']  ;
		}
		
		if($dataValue['ReviewPatientDetail']['is_deleted']==1) $values ='In Error' ;
		else $values =  $dataValue['ReviewPatientDetail']['values']  ;
		
		$dateArray[$convertedActualTime] 
		[$dataValue['ReviewPatientDetail']['review_sub_categories_id']]
		[$dataValue['ReviewPatientDetail']['review_sub_categories_options_id']]  =   array('values'=>$values,
																							'slot'=>$dataValue['ReviewPatientDetail']['hourSlot'],'id'=>$dataValue['ReviewPatientDetail']['id'],
																							'flag'=>$dataValue['ReviewPatientDetail']['flag'],
																							'flag_date'=>$dataValue['ReviewPatientDetail']['flag_date'],
																							'is_edited'=>$dataValue['ReviewPatientDetail']['is_edited'],
																							'edited_on'=>$dataValue['ReviewPatientDetail']['edited_on'], ); 

	} 
	 
	if($dateString == date('Y-m-d')){
		$currentHr = date("H")  ;
		$ymd = date('Ymd');
		$Hi = date("Hi");
		$HiColon = date("H:i") ;
	}else{
		$currentHr = 24  ;
		$ymd = date('Ymd',strtotime($dateString));
		$Hi = date("Hi") ;
		$HiColon = date("H:i") ;
	}
	
	$shiftCount = 1 ;
	 
	$customHourDiff = ($customTimeSlotResult[$dateString])?round($customTimeSlotResult[$dateString]/60):1; 
	$colspan = 1;
	$otherColspan = 0;
	$checkClass = date('Ymd',strtotime($dateString))."_".date("Hi"); 
	$timeBar = "<tr>" ; 
	$j=0; 
	
	if(empty($dateArray) && $dateString == date('Y-m-d')){ //if there is no record enter for the current day
		$timeBar .= "<td class='gray-container row21px'>&nbsp;</td>";
		$timeBar .= "<td class='gray-container doubleClick' id='".date('Ymd_Hi')."'><div class='time-area'>".date("H:i")  ;
		$timeBar .='<input  id="check_'.date("Ymd_Hi").'" type="checkbox" class="'.$checkClass.' dataCheck sub-cat-option" style="display: none;">';
		$timeBar .= "</div></td>" ;
	}
	
	foreach ($dateArray as $dataKey =>$dataValue){ 
			if($j==0 && $dateString == date('Y-m-d')){ //display for current date only			 
				$timeBar .= "<td class='gray-container row21px'>&nbsp;</td>";
				$timeBar .= "<td class='gray-container doubleClick' id='".date('Ymd_Hi')."'><div class='time-area'>".date("H:i")  ;
				$timeBar .='<input  id="check_'.date("Ymd_Hi").'" type="checkbox" class="'.$checkClass.' dataCheck sub-cat-option" style="display: none;">';
				$timeBar .= "</div></td>" ;
				$j=1;
			}else if ($j==0){
				$timeBar .= "<td class='gray-container row21px'>&nbsp;</td>";
				$j=1;
			}
			$cleanKey = clean($dataKey);
			$checkClass = $ymd."_".$cleanKey;
			$timeBar .= "<td class='gray-container doubleClick ' id='".$ymd."_".$cleanKey."'><div class='time-area'>";
			if(strlen($dataKey) < 3){
				$convertedActualTime = $dataKey.":00"  ;
				$timeBar .= $convertedActualTime ;
			}else{
				$timeBar .= $dataKey ;
			}
			
			
			$timeBar .='<input id="check_'.$ymd."_".$cleanKey.'" type="checkbox" class="'.$checkClass.' dataCheck sub-cat-option" style="display: none;">';
			$timeBar .= "</div></td>" ;
			$colspan++ ;	 
	} 
	
	//For back dated entry 
	$timeBar .= "<td class='gray-container doubleClick back-datetime-td'  style='display:none;'><div class='time-area '>";
	$timeBar .= "<span id='back-datetime-span'></span>" ;
	$timeBar .='<input type="checkbox" id="back-date-check" class=" dataCheck sub-cat-option" style="display: none;">';
	$timeBar .= "</div></td>" ;
	?>
	<tr >
		<td>
			 <table cellpadding="0" cellspacing="0">
									<tr class="test">										 
										<td class="gray-container"
											style="width: 110px; border-left: none; border-top: none; border-bottom: none; font-size: 10px;">
											<table>
												<tr>
													<td>
														<div style="width:196px;">
															<span id="custom" style="padding-right: 5px; cursor: pointer; cursor: hand;" >Customize</span>
															<span id="treecontrol">
																	<a title="Collapse the entire tree below" href="#nav"> Collapse All</a>
																	<a title="Expand the entire tree below" href="#nav"> Expand All</a>
																</span>
														</div>
													</td>
												</tr>
												<tr>
													<td class="two_img">
														<span>
															<?php echo $this->Html->image('icons/refresh-icon.png',array('id'=>'refresh-data','alt'=>'Refresh data'));?>
														</span> 
														<span><input type="hidden" id="xcel-back-date" /></span>
														<span><input type="hidden" id="back-date" /></span> 
														<span id="icon-div">
														<?php echo $this->Html->image('icons/icon_tick.gif', array('alt' => 'Save','title' => 'Save','class'=>'save-data'))?>
														</span>
													</td>
												</tr>
											</table>											 
										</td>
										 
										<td class="gray-container"  id="time-slot" colspan=<?php echo $colspan ;?>> 
										<a href="#" ><span><?php echo  date('m/d/Y',strtotime($dateString)) ?></span></a> 
										</td>
										<!--  <td class="gray-container"  id='back-date-date-td' style="display:none;"> 
										<a href="#" ><span id='back-date-date'></span></a> 
										</td>   -->
									</tr> 
									<?php  
										 echo $timeBar ;									
									?>
								</table> 
			</td>
	</tr>
	<?php 
	//timebar html
	//echo $timeBar ;
	$count = count($subCatOptions);
	echo $this->Form->hidden('timeslot',array('id'=>'timeslot')) ;	
	echo $this->Form->hidden('subCategory',array('id'=>'subCategory','value'=>$subCategoryID))  ;
	echo $this->Form->hidden('layout',array('id'=>'layout','value'=>'actual'))  ;
	echo $this->Form->hidden('current-url',array('id'=>'current-url','value'=>$this->here))  ;
	
	 
	 
	?>
	<tr>
		<td><div class="obj">
				<ul id="io-browser" class="filetree treeview-famfamfam treesubmenu">
					<?php 
						 
						 
						foreach ($subCatOptions as $optionKey =>$optionValue){
							 $catName = clean(strtolower($optionValue['ReviewSubCategory']['name']))."_".$optionValue['ReviewSubCategory']['id'] ;
							  $isCustomized = $customiztionData[$catName] ;								 
							  if($isCustomized != '' && (int)$customiztionData[$catName] === 0){ //customization for patient
									continue ;
							  }
						?>  
							<li id="<?php echo clean($optionValue['ReviewSubCategory']['name']); ?>">
								<table class="treesubmenu">
									<tr>
										<td style="border-style: none; width: 188px;"><span
											class="folder1" style="display: inline; color: white;">
												<?php echo $optionValue['ReviewSubCategory']['name']; ?>
										</span></td>  
									</tr>
								</table>
								<ul>
									<?php 
									$r =0;
									foreach ($optionValue['ReviewSubCategoriesOption'] as $subOptionKey =>$subOptionValue){
										$optionName  = strtolower(clean($subOptionValue['name'])."_".$subOptionValue['id']) ; ;
										$isOptCustomized = $customiztionData[$optionName] ;
										if($isOptCustomized != '' && (int)$isOptCustomized === 0){ //customization for patient
												continue ;
											}											
											//add total row for pain assessment and other options
											if(!empty($subOptionValue['trigger_on'])){ 
												//check if conditional entry is already selected
												foreach ($dateArray as $dataKey =>$dataValue){
													if(empty($currentDayCond[$subOptionValue['trigger_on']]))
													$currentDayCond[$subOptionValue['trigger_on']]= $dateArray[$dataKey][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['values'] ;											  
												} 
												//EOF check
												//draw row at the end of pain assessment.
												if(empty($currentDayCond[$subOptionValue['trigger_on']]) && $subOptionValue['score_total']!='total'){ //allow total row  
													$displayLi = 'display:none';
													$displayLiClass = clean(strtolower($subOptionValue['trigger_on'])) ;
												}else{
													$displayLi = '';
													$displayLiClass = '' ;
												}
											}else{
												$displayLi = '';
												$displayLiClass = '' ;
											}
											 
											//EOF hide n seek for conditional rows
									?>
									<li class="custom-li <?php echo $displayLiClass ;?>" style="<?php echo $displayLi ; ?>"><table>
											<tr> 
												<td  style="width: 185px;" title="<?php echo $subOptionValue['name'] ?>">
													<?php
														$unit = '' ;														
														if(!empty($subOptionValue['unit']))
															$unit  = " <i style='float:right'>".$subOptionValue['unit']."</i>" ;
														if(!empty($subOptionValue['trigger'])){
															echo $this->Html->image('icons/diamond_trigger.png',array('title'=>'Trigger For Conditional Field'));
														}else if(!empty($subOptionValue['trigger_on'])){
															echo $this->Html->image('icons/diamond_small.png',array('title'=>'Conditional Field'));
														}
														echo $this->General->truncate($subOptionValue['name'],IVSTRLEN).$unit  ; ?>
												</td>
												<?php if($dateString == date('Y-m-d')){ ?>
												<td>
													<?php 
													
														if(!empty($subOptionValue['values'])){
															$valuesArrayFirst = unserialize($subOptionValue['values']) ;
															$valuesArray12 = '' ;
															$scoreArray = explode('@',$subOptionValue['score']);
															$score= 0 ;
															$triggerOn1 = '' ;
															//trigger check
															if($subOptionValue['is_conditional']==1){
																$isCondClass=clean(strtolower($subOptionValue['name']));
															}else{
																$isCondClass="";
															}
															foreach($valuesArrayFirst as $valuesArrayVal12){ 
																//for counting
																/* if(!empty($subOptionValue['score'])){
																	$valuesArray12[clean($valuesArrayVal12)] = array('name' => $valuesArrayVal12, 'value' => $dropDownKey,  'score' => $scoreArray[$score]) ;
																}else{
																	$valuesArray12[clean($valuesArrayVal12)] = $valuesArrayVal12 ;
																} */
																if(!empty($subOptionValue['trigger'])){
																	$triggerOn1 = explode("@",$subOptionValue['trigger']);
																}
																$dropDownKey = clean($valuesArrayVal12) ;
																 
																$scoreArray = explode('@',$subOptionValue['score']);
																//BOF score calculation
																 
																//EOF score calculation
																$dropDownKey .= (!empty($triggerOn1[$score]))?"^".$triggerOn1[$score]:"" ; //adding trigger with dropdown option
																//for counting
																if(!empty($subOptionValue['score'])){
																	$valuesArray12[$dropDownKey] = array('name' => $valuesArrayVal12, 'value' => $dropDownKey,  'score' => $scoreArray[$score]) ;
																}else{
																	$valuesArray12[$dropDownKey] = $valuesArrayVal12 ;
																}
																$t++ ;
																$score++; 
																
															}
															//$selVal12 = $dateArray[date('Ymd_Hi')][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']] ;
															
															if(!empty($selVal12)){
																$displayDropDown = 'display:block;';
																$hasSelect = 'hasSelect' ;
																$disabled = true ;
															}else{
																$displayDropDown = 'display:none;' ;
																$hasSelect = 'hasSelect empty-select' ;
																$disabled = false ;
															}
															$className = date('Ymd_Hi');
															/* echo $valHtml12 =  $this->Form->input('sub-cat-options',array('type'=>'select','id'=>$optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id'],
																	'class'=>"inactive container $hasSelect $className",'empty'=>"",'options'=>$valuesArray12,'label'=>false,'div'=>'container',
																	'style'=>$displayDropDown,'disabled'=>$disabled)); */
	
															if(!empty($subOptionValue['score_total'])) {
																echo $valHtml12 =  $this->Form->input(null,array('name'=>$isCondClass ,'id'=>$optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id'],
																		'class'=>" container $className $hasSelect ",'empty'=>"",'options'=>$valuesArray12,'label'=>false,'div'=>'container',
																		'style'=>$displayDropDown,'disabled'=>$disabled,'title'=>$selVal,'score_total'=>clean($subOptionValue['score_total'])));
															}else{
																echo $valHtml12 =  $this->Form->input(null,array('name'=>$isCondClass ,'id'=>$optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id'],
																		'class'=>" container $className $hasSelect ",'empty'=>"",'options'=>$valuesArray12,'label'=>false,'div'=>'container',
																		'style'=>$displayDropDown,'disabled'=>$disabled,'title'=>$selVal ));
															}
														}else{
	
															if($subOptionValue['score_total']=='total'){
																$totalPlaceHolderClass = clean($subOptionValue['name']);
															}else{
																$totalPlaceHolderClass = '' ;
															}
															$bmiEle = '' ;
															$bmiEleCat = '' ;
															
															if(strtolower(trim($subOptionValue['name']))== strtolower('Height/Length measurement')){
																$bmiEleCat = "bmi='height'";
																$bmiEle = 'bmiEle' ;
															}else if(strtolower(trim($subOptionValue['name']))== strtolower('Weight Measured')){
																$bmiEleCat = "bmi='weight'";
																$bmiEle = 'bmiEle' ;
															}
															
															if(!empty($subOptionValue['score_total'])) {
																$scoreTotalStr = "score_total='".clean($subOptionValue['score_total'])."'";
															}else{
																$scoreTotalStr = '';
															}
															
														?>
														<div   <?php echo $patientDetailID." ".$bmiEleCat." ".$scoreTotalStr ;?>  class="container <?php echo date('Ymd_Hi')." ".$bmiEle." ".$totalPlaceHolderClass ?>"
															id="<?php echo $optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id']?>">&nbsp;</div>
														<?php }  ?> 
														 
												</td>
												<?php
													} //EOF of check for current date display current time column by default	
													foreach ($dateArray as $dataKey =>$dataValue){
														if(is_array($dataValue )){
															 $cleanKey = clean($dataKey);
													$className = $ymd."_".$cleanKey;
													$timeBar = '' ;  
													if($dateArray[$dataKey][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['flag']==1){ //display  flag
														$flagHtml =  $this->Html->image('icons/flag.png',array('class'=>'flag','title'=>$dateArray[$dataKey][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['flag_date']));
													}else{
														$flagHtml = '' ;
													}
													if($dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['is_edited']==1){ //display triangle
														$triagleHtml =  $this->Html->image('icons/triangle.png',array('style'=>'float:right;','title'=>$dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['edited_on']));
													}else{
														$triagleHtml = '' ;
													}
												?>
												<td>
													
													<?php  
													$triggerOn= '' ; 
													if(!empty($subOptionValue['values'])){  															
															$valuesArray1='';
															$valuesArray = unserialize($subOptionValue['values']) ;
															if(!empty($subOptionValue['trigger'])){
																$triggerOn = explode("@",$subOptionValue['trigger']);
															}
															$selVal = $dateArray[$dataKey][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['values'] ;  
															
															//trigger check
															if($subOptionValue['is_conditional']==1){
																$isCondClass=clean(strtolower($subOptionValue['name']));
															}else{
																$isCondClass="";
															}
															$t=0; 
															foreach($valuesArray as $valuesArrayVal){
																$dropDownKey = clean($valuesArrayVal) ;
																if($selVal==$dropDownKey){ //check before Appending ^
																	$selVal .= (!empty($triggerOn[$t]))?"^".$triggerOn[$t]:"" ;
																} 
																$scoreArray = explode('@',$subOptionValue['score']);
																//BOF score calculation
																if(($selVal==$dropDownKey) && (!empty($subOptionValue['score']))){																	 
																	$scoreTotal[$subOptionValue['score_total']][$dataKey][] = (int)$scoreArray[$t] ; //sequential count respective to array option
																}
																//EOF score calculation																
																$dropDownKey .= (!empty($triggerOn[$t]))?"^".$triggerOn[$t]:"" ; //adding trigger with dropdown option
																//for counting 
																if(!empty($subOptionValue['score'])){
																	$valuesArray1[$dropDownKey] = array('name' => $valuesArrayVal, 'value' => $dropDownKey,  'score' => $scoreArray[$t]) ;
																}else{
																	$valuesArray1[$dropDownKey] = $valuesArrayVal ;
																} 
																$t++ ;
															} 
															 
															if(!empty($selVal)){
																$displayDropDown = 'display:block;';
																$hasSelect = 'hasSelect' ;
																$disabled = true ;
																$rightClickClasses = 'context-menu-one box menu-1' ;
															}else{
																$displayDropDown = 'display:none;' ;
																$hasSelect = 'hasSelect empty-select' ;
																$disabled = false ;
																$rightClickClasses = '' ;
															}
														 	 

															if(!empty($subOptionValue['score_total'])) {
																echo $valHtml =  $this->Form->input(null,array('name'=>$isCondClass,'value'=>$selVal,'id'=>$optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id'],
																		'class'=>" container $className $hasSelect ",'empty'=>"",'options'=>$valuesArray1,'label'=>false,'div'=>'container',
																		'style'=>$displayDropDown,'disabled'=>$disabled,'title'=>$selVal,'score_total'=>clean($subOptionValue['score_total'])));
															}else{
																echo $valHtml =  $this->Form->input(null,array('name'=>$isCondClass,'value'=>$selVal,'id'=>$optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id'],
																		'class'=>" container $className $hasSelect ",'empty'=>"",'options'=>$valuesArray1,'label'=>false,'div'=>'container',
																		'style'=>$displayDropDown,'disabled'=>$disabled,'title'=>$selVal ));
															}


														}else{
															$hasSelect = '' ;
															$currentDay =   $dateArray[$dataKey][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['values'] ;
															
															$valHtml = $currentDay ;
															if($subOptionValue['score_total']=='total'){
																$totalPlaceHolderClass = clean($subOptionValue['name']);
															}else{
																$totalPlaceHolderClass = '' ;
															}
															
															if($currentDay > 0) {
																$rightClickClasses = 'context-menu-one box menu-1' ;
																$marClass = '' ;
																$patientDetailID = "detail-id=".$dateArray[$dataKey][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['id'] ; // ID of current cell
															}else{
																$marClass = 'cell-color' ;
																$patientDetailID = '' ;
																$rightClickClasses = '' ;
															}
															
															$bmiEle = '' ;
															$bmiEleCat = '' ;
															
															if(strtolower(trim($subOptionValue['name']))== strtolower('Height/Length measurement')){
																$bmiEleCat = "bmi='height'";
																$bmiEle = 'bmiEle' ;
															}else if(strtolower(trim($subOptionValue['name']))== strtolower('Weight Measured')){
																$bmiEleCat = "bmi='weight'";
																$bmiEle = 'bmiEle' ;
															}
															
															if(!empty($subOptionValue['score_total'])) {
																$scoreTotalStr = "score_total='".clean($subOptionValue['score_total'])."'";
															}else{
																$scoreTotalStr = '';
															}
															
															?> 
															<div  <?php echo $patientDetailID." ".$bmiEleCat." ".$scoreTotalStr ;?>
																class="container <?php echo $className." ".$bmiEle." ".$marClass." ".$rightClickClasses." ".$totalPlaceHolderClass ;?>"
																id="<?php echo $optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id']?>">
																<?php 
																echo $flagHtml ;
																echo $triagleHtml ;
																//score display
																if($subOptionValue['score_total']=='total' && $subOptionValue['name'] != Configure::read('interactive_bmi')){ 
																   	echo array_sum($scoreTotal[$subOptionValue['name']][$dataKey]) ; //total
																}else{ //EOF score display																   
																	echo $currentDay  ;
																}
																?>
															</div> 
															<?php 
														}
														?>
												</td>
												<?php  	
														}//EOF if 
														} ?>  
														<!-- Back dated jugad -->
														<td style='display:none' class="back-date-td">																 
														<?php 
														if(!empty($subOptionValue['values'])){
															$valuesArrayFirst = unserialize($subOptionValue['values']) ;
															$valuesArray12 = array();
															foreach($valuesArrayFirst as $valuesArrayVal12){
																$valuesArray12[clean($valuesArrayVal12)] = $valuesArrayVal12 ;
															}
															$selVal12 = $dateArray[date('Ymd_Hi')][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']] ;
	
															if(!empty($selVal12)){
																$displayDropDown = 'display:block;';
																$hasSelect = 'hasSelect' ;
																$disabled = true ;
															}else{
																$displayDropDown = 'display:none;' ;
																$hasSelect = 'hasSelect empty-select' ;
																$disabled = false ;
															}
																
															if(!empty($subOptionValue['score_total'])) {
																echo $valHtml =  $this->Form->input(null,array('name'=>$isCondClass,'value'=>$selVal,'id'=>$optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id'],
																		'class'=>" container $className $hasSelect ",'empty'=>"",'options'=>$valuesArray1,'label'=>false,'div'=>'container',
																		'style'=>$displayDropDown,'disabled'=>$disabled,'title'=>$selVal,'score_total'=>clean($subOptionValue['score_total'])));
															}else{
																echo $valHtml =  $this->Form->input(null,array('name'=>$isCondClass,'value'=>$selVal,'id'=>$optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id'],
																		'class'=>" container $className $hasSelect ",'empty'=>"",'options'=>$valuesArray1,'label'=>false,'div'=>'container',
																		'style'=>$displayDropDown,'disabled'=>$disabled,'title'=>$selVal ));
															}
													}else{
													?> 
													<div style="" class="back-date-div inactive container cell-color "
														id="<?php echo $optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id']?>">&nbsp;
													</div> 
											<?php } ?>  
															</td>
														<!-- EOF back logic -->
											</tr>
										</table>
									</li>
									<?php $r++;  } // EOF $datearray ?>
								</ul> 
							</li> 
					<?php   } ?> 
					</ul>
			</div> 
		</td>
	</tr>  
</table>  
<script>
	$(document).ready(function(){
		
		$("#io-browser").treeview({
			toggle: function() { 
			},
			animated:"slow",
			control: "#treecontrol",  
		});

		$("#back-date").datepicker({
			showOn: "button",
			buttonImage: "<?php  echo $this->Html->url('/img/icons/plus_6.png'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'yymmdd_HH:II',
			minDate : new Date('<?php echo $this->General->minDate($dateString)?>'),
			maxDate : new Date(),
			setDate : new Date('<?php echo $this->General->minDate($dateString)?>'),
			onSelect:function(dateText, inst){
				//splt date time 
				splittedDate = dateText.split('_');
				concatStr = splittedDate[0]+"_"+splittedDate[1].replace(":","");
				 
				mmddyyyy  = splittedDate[0].substr(4,2)+"/"+splittedDate[0].substr(6,2)+"/"+splittedDate[0].substr(0,4)  ; 
				//Display back date column
				$(".back-datetime-td").fadeIn('slow'); 
				$(".back-datetime-td").attr('id',concatStr);
				$("#back-date-check").addClass(concatStr);
				$("#back-datetime-span").html(splittedDate[1]);
				$(".back-date-td").fadeIn('slow');
				$(".back-date-div").addClass(concatStr);
				$('#back-date-date').html(mmddyyyy);
				$('#back-date-date-td').fadeIn('slow');
			}
		}); 


		$("#xcel-back-date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'yymmdd',
			minDate : new Date($("#form_received_on").val()),
			//maxDate : new Date(),
			onSelect:function(dateText, inst){
				//splittedDate = dateText.split('_'); 	 
				yyyymmdd  = dateText.substr(0,4)+"-"+dateText.substr(4,2)+"-"+dateText.substr(6,2)  ; 
				//render selected date io chart for back date entry	 
				$.ajax({
					  beforeSend: function(){
						  loading(); // loading screen
					  },
					  type:'post',
					  data:"backcharting=yes&date="+yyyymmdd ,
				      url: "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "getExcelLayout",$patient_id,$subCategoryID, "admin" => false)); ?>",
				      context: document.body,
				      success: function(data){ 
				    	  onCompleteRequest(); //remove loading sreen
				    	  $("#excelArea").html(data).fadeIn('slow');
					  }
				});
			}
		});
			
		$(".allcheck").click(function() {
			var className = this.id.replace(/\s/gi, ""); 
			 
			if($("#" + className).is(':checked')){
				$("div").find("."+className).removeClass('inactive');
			}else{
				$("div").find("."+className).addClass('inactive');
			}
			
		});
		 
		$('#custom').click(function(){ 
			$.fancybox({ 
				'width':800,
				'height':500,
			    'autoScale': true, 
			    'href': "<?php echo $this->Html->url(array("controller" => "nursings", "action" => "category_customization",$patient_id)); ?>",
			    'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	true,
				'onStart'		:   function(){
											loading();
									},
				'onComplete'    :   function(){
										onCompleteRequest();
									},
				'type':'iframe'
				 
		    }); 
		});

		$(".change-time-slot").click(function(){
 			slot  = $(this).attr('id');			
			$.ajax({
				  beforeSend: function(){
					  loading(); // loading screen
				  },
				  type:'post',
				  data:"slot="+slot+"&categoryid="+<?php echo $subCategoryID; ?>,
			      url: "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "getExcelLayout",$patient_id,$subCategoryID,"admin" => false)); ?>",
			      context: document.body,
			      success: function(data){ 
			    	  onCompleteRequest(); //remove loading sreen
			    	  $("#excelArea").html(data).fadeIn("slow");
				  },
				  error:function(){  
						alert("Please try again") ;
						onCompleteRequest(); //remove loading sreen
				  }
			});
		});
 
	 
	});
	
	function collapseExpandAll($flag){
		
		if(!$flag){
			
			$('#io-browser').each(function(){
				$(this).find('ul').css('display', 'block');
			});
		}else{
		
			$("#io-browser").treeview({
				toggle: function() {
					alert("dfghdfh");
					//console.log("%s was toggled.", $(this).find(">span").text());
				},
				animated:"slow",
				collapsed: true,
				unique: true,
				
			});
		}
	}

	$(function() {
	    var button = $('#time-slot');
	    var box = $('#loginBox');
	    var form = $('#loginForm');
	    
	    button.removeAttr('href');
	    button.click(function(e) {
	    	//pankaj 
	    	var posX = $("#excelArea").offset().left,
            posY = $(this).offset().top; 
			relX = e.pageX - posX ;
			relY = e.pageY - posY ;
 
			box.css("top",relY+250);
			box.css("left",relX+250); 
			 
	    	//EOF pankaj
	    	if(box.css('height')=='0px'){
	    		box.css('height','250px'); 
	    	}else{
	    		box.css('height','0px'); 
	    	}
	        // box.toggle();
	    	
	        button.toggleClass('active');
	    });
	    form.mouseup(function() { 
	        return false;
	    });
	    $(this).mouseup(function(login) {
	        if(!($(login.target).parent('#time-slot').length > 0)) {
	            button.removeClass('active'); 
	            box.css('height','0px');    
	        }
	    });
	});

	$('.sub-cat-link').click(function(){
		/*var last = $chapters.parent().find('li.active').removeClass('active').index();
		var next=50 ;
		 
		$chapters.eq(next).addClass('active'); // Set Next Chapter Active
		$('#io-browser').scrollTo($chScrollPositions[next]);*/
		$(".excel-format").animate({ scrollTop: 1600 });
	});

	 
</script>
