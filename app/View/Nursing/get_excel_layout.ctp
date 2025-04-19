
<style> 
/*Excel layout*/
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

//for Ymd format
$dateStringYmd = date('Ymd',strtotime($dateString));

$customHourDiff = ($customTimeSlotResult[$dateString])?round($customTimeSlotResult[$dateString]/60):1;  

if($dateString == date('Y-m-d')){ ?>
<div id="loginBox">
	<ul>
		<li id="0" class="change-time-slot">
			<?php 
				$tickTick = $this->Html->image('../img/icons/icon_tick.gif', array('alt' => 'Save','title' => 'Save'));
				if($customTimeSlotResult[$dateString]===0) echo $tickTick ;
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

<table cellspacing="0" cellpadding="0" border="0" class=" row20px excel-format">
	<?php 
	$timeBar = "<tr>" ;
	$timeBar .= "<td class='gray-container row21px'>&nbsp;</td>";
	//$timeBar .= "<td class='gray-container doubleClick' id='".date("H").":00-".date("H")."'>".date("H").":00-".date("H")."-59</td>";
	 
	foreach ($reviewData as $dataKey =>$dataValue){

		if($dataValue['ReviewPatientDetail']['is_deleted']==1) $values ='In Error' ;
		else $values =  $dataValue['ReviewPatientDetail']['values']  ;
		
		$dateArray[$dataValue['ReviewPatientDetail']['date']]
		[$dataValue['ReviewPatientDetail']['hourSlot']][$dataValue['ReviewPatientDetail']['review_sub_categories_id']]
			[$dataValue['ReviewPatientDetail']['review_sub_categories_options_id']]  = 
						array('value'=>$values,
								'id'=>$dataValue['ReviewPatientDetail']['id'],
								'flag'=>$dataValue['ReviewPatientDetail']['flag'],
								'flag_date'=>$dataValue['ReviewPatientDetail']['flag_date'],
								'is_edited'=>$dataValue['ReviewPatientDetail']['is_edited'],
								'edited_on'=>$dataValue['ReviewPatientDetail']['edited_on'], );

		 
	}
	 
	/*
	 The easiest example for this class is:
	*/
	 
	
	if($dateString == date('Y-m-d')){
		$currentHr = date("H")  ;
		$ymd = date('Ymd');
		$Hi = date("Hi");
		$HiColon = date("H:i") ;
	}else{
		$currentHr = 23  ;
		$ymd = date('Ymd',strtotime($dateString));
		$Hi = date("Hi") ;
		$HiColon = date("H:i") ;
	}
	
	
	$shiftCount = 1 ;
	  
	$colspan = 0;
	$otherColspan = 0;  
	for($h=$currentHr;$h >=0;$h -= $customHourDiff){ 
		//nursing working hours 0700-1500,1500-2300,2300-0700  
		$checkClass = $ymd."_".$h;
		$endHour = $h+($customHourDiff-1) ; 
		$timeBar .= "<td class='gray-container doubleClick ' id='".$ymd."_".$h."'><div class='time-area'>";
		if($h==0)
			$timeBar .= "00:00- 00:59" ;
		else
			$timeBar .= $h.":00- ".$endHour.":59" ;
		
		$timeBar .='<input id="check_'.$ymd."_".$h.'" type="checkbox"
				class="'.$checkClass.' dataCheck sub-cat-option" style="display: none;">';
		
		$timeBar .= "</div></td>" ;
		$colspan++ ;
	}
 
	//Total of the day 
	
	/* for($j=23;$j >6;$j -= $customHourDiff ){
		$timeBar .= "<td class='gray-container doubleClick ' id='".date('Ymd',strtotime("+1 day"))."_".$j."'><div class='time-area'>";
		$timeBar .= $j.":00- ".$j.":59" ;
		$timeBar .= "</div></td>" ;
		$otherColspan++ ;	
	} 

	for($k=23;$k >6;$k -= $customHourDiff){
		$timeBar .= "<td class='gray-container doubleClick ' id='".date('Ymd',strtotime("-1 day"))."_".$k."'><div class='time-area'>";
		$timeBar .= $k.":00- ".$k.":59" ;
		$timeBar .= "</div></td>" ;

	} */
 
	?>
	<tr >
		<td>
			 <table cellpadding="0" cellspacing="0">
									<tr class="test">
										<?php  
										$cols= date('H')+1 ;
										$prevDateMDY = date('m/d/Y',strtotime("-1 day")) ;
										$prevDateYMD = date('Y-m-d',strtotime("-1 day")) ;

										$nextDateMDY = date('m/d/Y',strtotime("+1 day")) ;
										$nextDateYMD = date('Y-m-d',strtotime("+1 day")) ;
										?>
										<td class="gray-container"
											style="width: 110px; border-left: none; border-top: none; border-bottom: none; font-size: 10px;">
											<table>
												<tr>
													<td>
														<div style="width:196px;">
															<span id="custom" style="padding-right: 5px; cursor: pointer; cursor: hand;" >Customize</span>
														<!-- <span
																style="padding-right: 5px; cursor: pointer; cursor: hand;"
																onclick="collapseExpandAll()">Expand</span> <span
																style="cursor: pointer; cursor: hand;"
																onclick="collapseExpandAll(true)">Collapse</span>  -->	
																
																<span id="treecontrol">
																	<a title="Collapse the entire tree below" href="#nav" id="collapse-all" class="tree-view-collapse"> Collapse All</a>
																	<a title="Expand the entire tree below" href="#nav" id="expand-all" class="tree-view-collapse"  > Expand All</a>
																</span>
														</div>
													</td>
												</tr>
												<tr>
													<td class="two_img">
													<span >
															<?php echo $this->Html->image('icons/refresh-icon.png',array('id'=>'refresh-data','alt'=>'Refresh data'));?>
														</span>
														<span><input type="hidden" id="xcel-back-date" /></span>
														<span id="icon-div">
														<?php echo $this->Html->image('../img/icons/icon_tick.gif', array('alt' => 'Save','title' => 'Save','class'=>'save-data'))?>
														</span>
													</td>
												</tr>
											</table>											 
										</td>
										 
										<td class="gray-container"  id="time-slot" colspan=<?php echo $colspan ;?>> 
										<a href="#" ><span><?php echo date('m/d/Y',strtotime($dateString));?></span></a>
											
										</td>
								 	
										<!-- <td class="gray-container" colspan=<?php //echo $otherColspan; ?> >
											<a href="#"  ><span><?php //echo date('m/d/Y',strtotime("+1 day"));?></span></a>
										</td>
										<td class="gray-container" colspan=<?php //echo $otherColspan; ?> >
												 <a href="#"  ><span>	<?php //echo date('m/d/Y',strtotime("-1 day"));?></span></a>
										</td>  -->
									</tr>
									
									<?php echo $timeBar; ?>
								</table> 
			</td>
	</tr>
	<?php 
	//timebar html
	
	 
	$count = count($subCatOptions);
	echo $this->Form->hidden('timeslot',array('id'=>'timeslot')) ;	
	echo $this->Form->hidden('subCategory',array('id'=>'subCategory','value'=>$subCategoryID))  ;
	echo $this->Form->hidden('layout',array('id'=>'layout','value'=>'excel'))  ;
	echo $this->Form->hidden('current-url',array('id'=>'current-url','value'=>$this->here))  ;	
	if($dateString != date('Y-m-d')){ 
		echo $this->Form->hidden('backcharting',array('id'=>'backcharting','value'=>'yes'))  ;
	}else{

	}  
	?>
	<tr>
		<td><div class=" " id="innerExcelArea">
				<ul id="io-browser" class="filetree treeview-famfamfam treesubmenu">
					<?php 
						$intake = 0 ; //for intake total header to display once in loop
						$output = 0 ; //same for output total 
						 
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
										<td style="border-style: none; width: 188px;" title="<?php echo $optionValue['ReviewSubCategory']['name'] ;?>"><span
											class="folder1" style="display: inline; color: white;"><?php echo $this->General->truncate($optionValue['ReviewSubCategory']['name'],IVSTRLEN); ?>
										</span></td>   
										<?php   
											for($h=$currentHr;$h >=0;$h -= $customHourDiff){
												//nursing working hours 0700-1500,1500-2300,2300-0700
												 
												$checkClassSub = $ymd."_".$h."_".$optionValue['ReviewSubCategory']['id'];
												$endHourSub = $h+($customHourDiff-1) ;
												$timeBarSub = "<td class='container doubleClickOnChild ' id='".$ymd."_".$h."'>";
												$checkClassId= "check_".$ymd."_".$h;
												$timeBarSub .='<input  type="checkbox" id="'.$checkClassId.'"
															class= "'.$checkClassId.' '.$checkClassSub.' dataCheck  sub-cat-option" style="display: none;">';
											
												$timeBarSub .= "</td>" ;
												$colspan++ ;
												echo $timeBarSub ;
											}
											
										?>
										 
									</tr>
								</table>
								<ul>
									<?php 
									$r =0;
									foreach ($optionValue['ReviewSubCategoriesOption'] as $subOptionKey =>$subOptionValue){
										$optionName  = strtolower(clean($subOptionValue['name'])."_".$subOptionValue['id']) ; 
										$isOptCustomized = $customiztionData[$optionName] ;
										if($isOptCustomized != '' && (int)$isOptCustomized === 0){ //customization for patient
											continue ;
										} 
										
										//add total row for pain assessment and other options
										if(!empty($subOptionValue['trigger_on'])){
											$currentDayCond='';$tomarrowSubCatOptCond='';$yesterSubCatOptCond='';
											
											//check if conditional entry is already selected
											for($h=$currentHr;$h >=0;$h -= $customHourDiff ){												 
												if(empty($currentDayCond[$subOptionValue['trigger_on']]))
													$currentDayCond[$subOptionValue['trigger_on']]= $dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['value'] ;													
											}
											/* for($j=23;$j >6;$j -= $customHourDiff){
												if(empty($tomarrowSubCatOptCond[$subOptionValue['trigger_on']]))
													$tomarrowSubCatOptCond[$subOptionValue['trigger_on']]= $dateArray[date('Y-m-d',strtotime("+1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$r]['value'] ;												 
											}
											for($j=23; $j >6; $j -= $customHourDiff){
												if(empty($yesterSubCatOptCond[$subOptionValue['trigger_on']]))
													$yesterSubCatOptCond[$subOptionValue['trigger_on']]= $dateArray[date('Y-m-d',strtotime("+1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$r]['value'] ;												 
											} */ 
											
											//EOF check
											//draw row at the end of pain assessment.
											if(empty($currentDayCond[$subOptionValue['trigger_on']]) && empty($tomarrowSubCatOptCond[$subOptionValue['trigger_on']]) && empty($yesterSubCatOptCond[$subOptionValue['trigger_on']])&& $subOptionValue['score_total']!='total'){
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
												<td  style="width: 170px;" title="<?php echo $subOptionValue['name'] ?>">
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
												<?php  $className = "to-save" ;    $className = "" ; 
												 for($h=$currentHr;$h >=0;$h -= $customHourDiff ){

													 

													$className = $ymd."_".$h;
													$classNameSub = $ymd."_".$h."_".$optionValue['ReviewSubCategory']['id'];
													
													$checkClassSub = $ymd."_".$h."_".$optionValue['ReviewSubCategory']['id'];
													$timeBar = '' ;
													 
													$currentDay =   $dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['value'] ;  
													if($dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['flag']==1){ //display  flag
														$flagHtml =  $this->Html->image('icons/flag.png',array('class'=>'flag','title'=>$dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['flag_date']));
													}else{
														$flagHtml = '' ;
													}
													
													if($dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['is_edited']==1){ //display triangle
														$triagleHtml =  $this->Html->image('icons/triangle.png',array('style'=>'float:right;','title'=>$dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['edited_on']));
													}else{
														$triagleHtml = '' ;
													}
													
													if(!empty($currentDay)) {
														$marClass = '' ;
														$rightClickClasses = 'context-menu-one box menu-1' ;
														$patientDetailID = "detail-id=".$dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['id'] ; // ID of current cell
													}else{  
														$marClass = 'cell-color' ;
														$rightClickClasses = '' ;
														$patientDetailID = "" ;
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
															
															$selVal = $dateArray[$dateString][$h][$optionValue['ReviewSubCategory']['id']][$subOptionValue['id']]['value'] ; 
															
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
																//BOF score calculation
																$scoreArray = explode('@',$subOptionValue['score']);
															 
																if(($selVal==$dropDownKey) && (!empty($subOptionValue['score'])) && !empty($subOptionValue['score_total']) && is_array($scoreArray)){ 
																	 $scoreTotal[clean($subOptionValue['score_total'])][$h][] = (int)$scoreArray[$t] ; //sequential count respective to array option
															    }
																//EOF score calculation
																$dropDownKey .= (!empty($triggerOn[$t]))?"^".$triggerOn[$t]:"" ; //adding trigger with dropdown option
																if(!empty($subOptionValue['score'])){
																	$valuesArray1[$dropDownKey] = array('name' => $valuesArrayVal, 'value' => $dropDownKey,  'score' => $scoreArray[$t]) ;
																}else{
																	$valuesArray1[$dropDownKey] = $valuesArrayVal ;
																}
																$t++ ;
															}
															//For javascript array 
															//$prepareForJS[$subOptionValue['name']] = $valuesArray1 ; //array with key of option name
															
															//EOF javascript array 
															
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
															echo $flagHtml ;
															echo $triagleHtml ;
															
															if(!empty($subOptionValue['score_total'])) {
																echo $valHtml =  $this->Form->input(null,array('name'=>$isCondClass,'value'=>$selVal,'id'=>$optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id'],
																					'class'=>" container $className $classNameSub $hasSelect ",'empty'=>"",'options'=>$valuesArray1,'label'=>false,'div'=>'container',
																					'style'=>$displayDropDown,'disabled'=>$disabled,'title'=>$selVal,'score_total'=>clean($subOptionValue['score_total'])));
															}else{
																echo $valHtml =  $this->Form->input(null,array('name'=>$isCondClass,'value'=>$selVal,'id'=>$optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id'],
																			'class'=>" container $className $classNameSub $hasSelect ",'empty'=>"",'options'=>$valuesArray1,'label'=>false,'div'=>'container',
																			'style'=>$displayDropDown,'disabled'=>$disabled,'title'=>$selVal ));
															}
														?>
															 
															<?php  
														}else{
															  
															$valHtml = $currentDay ;
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
															
															<div  <?php echo $patientDetailID." ".$bmiEleCat." ".$scoreTotalStr ;?> class=" container <?php echo $className." ".$bmiEle." ".$marClass." ".$rightClickClasses." ".$totalPlaceHolderClass." ".$classNameSub ;?>"
																id="<?php echo $optionValue['ReviewSubCategory']['id']."-name-".$subOptionValue['id']?>">&nbsp;<?php   
																	echo $flagHtml ;
																	echo $triagleHtml ;
																	//score display
																	if($subOptionValue['score_total']=='total' && $subOptionValue['name'] != Configure::read('interactive_bmi')){ 
																		echo array_sum($scoreTotal[clean($subOptionValue['name'])][$h]) ; //total for loop hour
																	}else{ //EOF score display
																  	 	echo $valHtml ; 
																    	$currentDayTotal   = $currentDay + $currentDayTotal ;
																    	$subCatOptionTotal += $currentDay  ;
																    }
																?>
															</div>
														<?php 
														}
													?> 
												</td>
												<?php  	} 
													/*  for($j=23;$j >6;$j -= $customHourDiff){
													$className =   date('Ymd',strtotime("+1 day"))."_".$j; */  ?>
												<!-- <td>
													<div  style="" class=" container <?php //echo $className ;?>"
														id="<?php // echo $optionValue['ReviewSubCategory']['id']."-name-".$r?>">
														<?php  /* echo $tomarrowSubCatOpt =  $dateArray[date('Y-m-d',strtotime("+1 day"))][$j][$optionValue['ReviewSubCategory']['id']][$r]['value'] ;
															   $tomarrowSubCatOptTotal += $tomarrowSubCatOpt; */	
														?>
													</div> 
												</td>  -->
												<?php  /* } 
												for($j=23; $j >6; $j -= $customHourDiff){ 
													$className =   date('Ymd',strtotime("-1 day"))."_".$j;  */ ?>
												<!-- <td>	
													<div  style="" class=" container <?php //echo $className ;?>"
														id="<?php //echo $optionValue['ReviewSubCategory']['id']."-name-".$r?>">
														<?php  
														 	 /* echo $yesterSubCatOpt= $dateArray[date('Y-m-d',strtotime('-1 day'))][$j][$optionValue['ReviewSubCategory']['id']][$r]['value'] ;
														 	 $yesterSubCatOptTotal += $yesterSubCatOpt; */
														?>
													</div>
												</td> -->
												<?php //} ?> 
											</tr>
										</table>
									</li>
									<?php $r++;  } ?>
								</ul> 
							</li>
						 
					<?php   } ?> 
					 </ul>
			</div> 
		</td>
	</tr>  
</table>  


<?php  

	/* Code written to populate dropdown options on double click 
	 * 
	 *  $outputstring  = '<script language="JavaScript" type="text/javascript">'."\n";
	 $outputstring .= " var option_array = ".json_encode($prepareForJS).";";
	 $outputstring .= '</script>'."\n";
	 echo $outputstring ; */
?> 
<script>

	 
	$(document).ready(function(){
		var lastid = '' ;
		$("#io-browser").treeview({
			toggle: function() {
				 //write something for debug
			},
			animated:"slow", 
			control: "#treecontrol", 
			
		});
		$('.tree-view-collapse').click(function(){
			/*$("#collapse-all").toggle();
			$("#expand-all").toggle();*/
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
 			var backcharting= $('#backcharting').val();
 			args = '';  
 			if(backcharting == 'yes'){
 				args  = "slot="+slot+"&categoryid=" + <?php echo $subCategoryID; ?> + "&backcharting=yes&date= <?php echo $dateString  ?>" ;
 			}else{
 		 		args =  "slot="+slot+"&categoryid="+<?php echo $subCategoryID; ?> ;
 		 	}
			$.ajax({
				  beforeSend: function(){
					  loading(); // loading screen
				  },
				  type:'post',
				  data:args,
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
	    		box.css('height','150px'); 
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
</script>
