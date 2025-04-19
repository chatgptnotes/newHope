<?php
echo $this->Html->css(array('/patient_track_css/style'));
echo $this->Html->script(array('/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>

<style>
#sortable1,#sortable2 {
	list-style-type: none;
	margin: 0;
	padding: 0;
	float: left;
	margin-right: 10px;
}

#sortable1 li,#sortable2 li {
	margin: 0 5px 5px 5px;
	padding: 5px;
	font-size: 1.2em;
	width: 120px;
}

.sortable1.list,.sortable2.list {
	clear: both;
}

.expand a {
	margin-left: 20px;
}

.inner_right1 {
	background: none !important;
}

.inner_right1 span {
	background: none !important;
}

.inner_right1 svg {
	background: none !important;
}

.inner_right1 rect {
	background: none !important;
}

.red-background-529 rect {
	background: #000 !important;
}

.right_inner2 {
	background: none !important;
}

.right_inner2 span {
	background: none !important;
}

.right_inner2 svg {
	background: none !important;
}
.left_div {
    float: left;
    width: 49%;
    padding: 0 0 0 5px !important;
}

.right_inner3 li {
    list-style: none outside none !important;
}
</style>
<script type="text/javascript">
                        //FC_ChartUpdated method is called when user has changed pointer value.
                        function FC_ChartUpdated(DOMId){
                                //Check if DOMId is that of the chart we want
                                if (DOMId=="scaleChartId"){
                                        //Get reference to the chart
										var chartRef = FusionCharts(DOMId);
                                        //Get the current value
                                        var pointerValue = chartRef.getData(1); 
                                        //You can also use getDataForId method as commented below, to get the pointer value.
                                        //var pointerValue = chartRef.getDataForId("CS"); 
                                        //Update display
                                        //var divToUpdate = document.getElementById("contentDiv");
                                        //divToUpdate.innerHTML = "<span class='text'>Your satisfaction index: <B>" + pointerValue.toFixed(2) + "%</B></span>";
                                        var data = 'scaleVal=' + pointerValue.toFixed(2); 
                                        FusionCharts("inputoutputChartId").dispose();
                                        FusionCharts("multiaxisChartId1").dispose();
                                        FusionCharts("multiaxisChartId2").dispose();
                                        //FusionCharts("multiaxisChartId3").dispose();
                                        FusionCharts("multiaxisChartId4").dispose();
                                        
                                        $.ajax({url: "<?php echo $this->Html->url(array("action" => "ajaxGetInputOutputIntake", "admin" => false, $patient['Patient']['id'])); ?>",type: "GET",data: data,beforeSend: function () {  $('#busy-indicator').show(); }, success: function (html) {  $('#ajaxInputPutputChartId').html(html); $('#busy-indicator').hide(); }});
                                        $.ajax({url: "<?php echo $this->Html->url(array("action" => "ajaxGetOtherIntake", "admin" => false, $patient['Patient']['id'])); ?>",type: "GET",data: data,beforeSend: function () {  $('#busy-indicator').show(); }, success: function (html) {  $('#ajaxOtherIntakeChartId').html(html); $('#busy-indicator').hide(); }});
                                        $.ajax({url: "<?php echo $this->Html->url(array("action" => "ajaxGetLabsStatus", "admin" => false, $patient['Patient']['id'])); ?>",type: "GET",data: data,beforeSend: function () {  $('#busy-indicator').show(); }, success: function (html) {  $('#ajaxGetLabsReportId').html(html); $('#busy-indicator').hide(); }});
                                        $.ajax({url: "<?php echo $this->Html->url(array("action" => "ajaxGetRespiratoryStatus", "admin" => false, $patient['Patient']['id'])); ?>",type: "GET",data: data,beforeSend: function () {  $('#busy-indicator').show(); }, success: function (html) {  $('#ajaxGetRespiratoryReportId').html(html); $('#busy-indicator').hide(); }});

                                }
                        } 
</script>
<?php
echo $this->Html->script(array( 'jquery.mCustomScrollbar.concat.min.js'));
echo $this->Html->css(array('jquery.mCustomScrollbar.css'));
?>
<script>
		(function($){
			$(window).load(function(){
				$(".content").mCustomScrollbar({
					autoHideScrollbar:false,
					theme:"dark-thin"
				});
								});
		})(jQuery);
	</script>

<div class="inner_title">
	<h3>
		<?php echo __('Critical Care Review - ', true);  
		if(!empty($chartDate)){

	echo date('F d Y',strtotime($chartDate));}
		else{echo date('F d Y');}?>
	</h3>
	
	<span style="margin: -25px 0px"> <?php  
	echo $this->Form->create('PatientsTrackReport',array('id'=>'backDateView'));
	echo $this->Form->input('date',array('id'=>'back-date','type'=>'text', 'readonly'=>'readonly', 'class'=> 'textBoxExpnd','div'=>false));
	echo $this->Form->end();
	if(!empty($chartDate)){//for selected date
		$categoryStartDate = $chartDate." 00:00:00";
		$categoryLastDate =  $chartDate." 23:00:00";
	}else{
		if(date("H")>=11)
		{
			$categoryStartDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - 11 hours'));
			$categoryLastDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
	
		}
		else{
			$categoryStartDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). '- 1 day + 13 hours'));
			$categoryLastDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
		}
	}
	
	?>
	</span>
</div>
<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>
<div align="center" id="busy-indicator" style="display: none;">
	<?php echo $this->Html->image('indicator.gif'); 
	?>
</div>

<div class="clr ht5"></div>

<div class="main_div">
	<div class="left_div">
		<!--  <div class="left_inner_leftdiv1">
<ul>
	<li class="LabTherapyHead">Vitals, CV, Neuro, Infusion(12 Hr)</li>
	<li>
	<div>
	<div id="scalechartdiv" align="center">Chart will load here</div>
	<?php //echo $this->JsFusionChart->showFusionChart("fusionwx_charts/HLinearGauge.swf", "scaleChartId", "100%", "70", "0", "0", 'dataString', 'scalechartdiv'); ?>
	<div id="contentDiv"></div>
	</div>
	</li>
</ul>
</div>-->
		<div class="left_inner_leftdiv2 content" id="ajaxOtherIntakeChartId">
			<div id="accordian" class="accordian">
				<ul>
					<li>
						<h3 class="expand">
							Vital Signs
							<?php //echo date('m/d/Y'); ?>
							
						</h3>
						<div class="inner_leftinner collapse ui-accordion">
							<div class="inner_first1"></div>
							<div class="inner_right1">
								<div>
									<?php //echo $this->Html->script(array('/fusionpx_data/js/VitalSignMALine2')); ?>
									<?php 
									//used in date calender
									echo $this->Form->hidden('form_received_on',array('id'=>'form_received_on','value'=>$this->General->minDate($patient['Patient']['form_received_on'])));


									$strVitalSignXML = '<chart caption="Vital Signs" xAxisName="Time" showValues="0" labelStep="60" divLineAlpha="100" numVDivLines="4" vDivLineAlpha="0" showAlternateVGridColor="1" alternateVGridAlpha="7"  legendBgColor="1B1B1B" canvasBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff" toolTipBgColor="1B1B1B" connectNullData="1">';
									$strVitalSignXML .= '<categories>';

									//$categoryStartDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - 11 hours'));
									
									$vitalDate = $categoryStartDate; //for vitals
									while($categoryLastDate >= $vitalDate) {
										for($i=0; $i <= 59 ; $i++){
											if($i<= 9) {
												$i = '0'.$i;
											}
											$strVitalSignXML .= '<category label="'.date("H", strtotime($vitalDate)).".".$i.'"/>';
										}
										$vitalDate = date('Y-m-d H:i:s', strtotime($vitalDate. ' + 1 hours'));
										
									}
									$strVitalSignXML .= '<category label="'.date("H", strtotime($categoryLastDate. ' + 1 hours')).".00".'"/>';
									$strVitalSignXML .= '</categories>';
									$strVitalSignXML .='<axis  title="HR,Oxygen,RR" Pos="left" tickWidth="10" divlineisdashed="1" >';

									$strVitalSignXML .='<dataset seriesName="HR" lineThickness="3" color="CC0000">';
									// display either one heart rate //
									$heartRateCnt1=0;
									$heartRateCnt2=0;
									//debug($getVSHeartRateMonit);
									if(count($getVSHeartRateMonit) > 0) {
										$heartRateCnt1++;
										$heartdate=$categoryStartDate;
										while($categoryLastDate >= $heartdate) {
											for($i=0; $i <= 59 ; $i++){
												if($i<= 9) {
													$i = '0'.$i;
												}
												$checkKey = date("H", strtotime($heartdate)).".".$i;
												//debug($checkKey);
												if(array_key_exists($checkKey, $getVSHeartRateMonit)) {
													
													$strVitalSignXML .=  '<set label="'.$checkKey.'" value="'.$getVSHeartRateMonit[$checkKey].'" />';
												} else {
													$strVitalSignXML .=  '<set value="" />';
												}
											}
											$heartdate = date('Y-m-d H:i:s', strtotime($heartdate. ' + 1 hours'));
										}
										// for last time //
										if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSHeartRateMonit)) {
											$strVitalSignXML .=  '<set value="'.$getVSHeartRateMonit[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
										} else {
											$strVitalSignXML .=  '<set value="" />';
										}
									}


									if($heartRateCnt1 == 0) {
										$heartdate=$categoryStartDate;
										while($categoryLastDate >= $heartdate) {
											for($i=0; $i <= 59 ; $i++){
												if($i<= 9) {
													$i = '0'.$i;
												}
												$checkKey = date("H", strtotime($heartdate)).".".$i;
												if(array_key_exists($checkKey, $getVSApicalHeartRate)) {
													$strVitalSignXML .=  '<set value="'.$getVSApicalHeartRate[$checkKey].'" />';
												} else {
													$strVitalSignXML .=  '<set value="" />';
												}
											}
											$heartdate = date('Y-m-d H:i:s', strtotime($heartdate. ' + 1 hours'));
										}
										// for last time //
										if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSApicalHeartRate)) {
											$strVitalSignXML .=  '<set value="'.$getVSApicalHeartRate[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
										} else {
											$strVitalSignXML .=  '<set value="" />';
										}
									}
									$strVitalSignXML .='</dataset>';

									$strVitalSignXML .='<dataset seriesName="Oxygen">';
									$oxygenDate=$categoryStartDate;
									//$categoryStartDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - 11 hours'));
									//$categoryLastDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
									while($categoryLastDate >= $oxygenDate) {
	 	  for($i=0; $i <= 59 ; $i++){
	 	  	if($i<= 9) {
	 	  		$i = '0'.$i;
	 	  	}
	 	   $checkKey = date("H", strtotime($oxygenDate)).".".$i;
	 	   if(array_key_exists($checkKey, $getVSSpO2)) {
	 	   	 $strVitalSignXML .=  '<set value="'.$getVSSpO2[$checkKey].'" />';
	 	   } else {
	 	   	$strVitalSignXML .=  '<set value="" />';
	 	   }
	 	  }
	 	  $oxygenDate = date('Y-m-d H:i:s', strtotime($oxygenDate. ' + 1 hours'));
	     }
	     // for last time //
	     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSSpO2)) {
	    	$strVitalSignXML .=  '<set value="'.$getVSSpO2[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
	    } else {
	    	$strVitalSignXML .=  '<set value="" />';
	    }

	    $strVitalSignXML .='</dataset>';
	    $strVitalSignXML .='<dataset seriesName="RR" lineThickness="3" color="0372AB">';
	    $rrDate=$categoryStartDate;
	    //$categoryStartDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - 11 hours'));
	    //$categoryLastDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
	    while($categoryLastDate >= $rrDate) {
	 	  for($i=0; $i <= 59 ; $i++){
	 	  	if($i<= 9) {
	 	  		$i = '0'.$i;
	 	  	}
	 	   $checkKey = date("H", strtotime($rrDate)).".".$i;
	 	   if(array_key_exists($checkKey, $getVSRespiratoryRate)) {
	 	   	 $strVitalSignXML .=  '<set value="'.$getVSRespiratoryRate[$checkKey].'" />';
	 	   } else {
	 	   	$strVitalSignXML .=  '<set value="" />';
	 	   }
	 	  }
	 	  $rrDate = date('Y-m-d H:i:s', strtotime($rrDate. ' + 1 hours'));
	     }
	     // for last time //
	     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSRespiratoryRate)) {
	    	$strVitalSignXML .=  '<set value="'.$getVSRespiratoryRate[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
	    } else {
	    	$strVitalSignXML .=  '<set value="" />';
	    }
	    $strVitalSignXML .='</dataset>';


	    $strVitalSignXML .='</axis>';

	    $strVitalSignXML .='<axis title="Temp" titlepos="RIGHT" axisOnLeft="0" numDivLines="5" tickWidth="10" divlineisdashed="1" minValue="35" maxValue="40">';
	    $strVitalSignXML .='<dataset seriesName="Temp">';
	   
	    // display either one temperature //
	    $temp1=0;
	    $temp2=0;
	    if(count($getVSTemperatureOral) > 0){
      	$temp1++;
      	//$categoryStartDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - 11 hours'));
      	//$categoryLastDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
      	$tempDate=$categoryStartDate;
      	while($categoryLastDate >= $tempDate) {
	 	  for($i=0; $i <= 59 ; $i++){
	 	  	if($i<= 9) {
	 	  		$i = '0'.$i;
	 	  	}
	 	   $checkKey = date("H", strtotime($tempDate)).".".$i;
	 	   if(array_key_exists($checkKey, $getVSTemperatureOral)) {
	 	   	 $strVitalSignXML .=  '<set value="'.$getVSTemperatureOral[$checkKey].'" />';
	 	   } else {
	 	   	$strVitalSignXML .=  '<set value="" />';
	 	   }
	 	  }
	 	  $tempDate = date('Y-m-d H:i:s', strtotime($tempDate. ' + 1 hours'));
	     }
	     // for last time //
	     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSTemperatureOral)) {
	    	$strVitalSignXML .=  '<set value="'.$getVSTemperatureOral[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
	    } else {
	    	$strVitalSignXML .=  '<set value="" />';
	    }
      }

      if($temp1 == 0 && count($getVSTemperatureAuxillary)>0) {
	  	  $temp2++;
	  	  $tempDate=$categoryStartDate;
	  	  while($categoryLastDate >= $tempDate) {
	 	  for($i=0; $i <= 59 ; $i++){
	 	  	if($i<= 9) {
	 	  		$i = '0'.$i;
	 	  	}
	 	   $checkKey = date("H", strtotime($tempDate)).".".$i;
	 	   if(array_key_exists($checkKey, $getVSTemperatureAuxillary)) {
	 	   	 $strVitalSignXML .=  '<set value="'.$getVSTemperatureAuxillary[$checkKey].'" />';
	 	   } else {
	 	   	$strVitalSignXML .=  '<set value="" />';
	 	   }
	 	  }
	 	  $tempDate = date('Y-m-d H:i:s', strtotime($tempDate. ' + 1 hours'));
	     }
	     // for last time //
	     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSTemperatureAuxillary)) {
	    	$strVitalSignXML .=  '<set value="'.$getVSTemperatureAuxillary[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
	    } else {
	    	$strVitalSignXML .=  '<set value="" />';
	    }
	  }
	  if($temp1 == 0 && $temp2 == 0 && count($getVSTemperatureRectal)>0) {
	    $tempDate=$categoryStartDate;
	    while($categoryLastDate >= $tempDate) {
	 	  for($i=0; $i <= 59 ; $i++){
	 	  	if($i<= 9) {
	 	  		$i = '0'.$i;
	 	  	}
	 	   $checkKey = date("H", strtotime($tempDate)).".".$i;
	 	   if(array_key_exists($checkKey, $getVSTemperatureRectal)) {
	 	   	 $strVitalSignXML .=  '<set value="'.$getVSTemperatureRectal[$checkKey].'" />';
	 	   } else {
	 	   	$strVitalSignXML .=  '<set value="" />';
	 	   }
	 	  }
	 	  $tempDate = date('Y-m-d H:i:s', strtotime($tempDate. ' + 1 hours'));
	     }
	     // for last time //
	     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSTemperatureRectal)) {
	    	$strVitalSignXML .=  '<set value="'.$getVSTemperatureRectal[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
	    } else {
	    	$strVitalSignXML .=  '<set value="" />';
	    }
	  }
	  $strVitalSignXML .='</dataset>';
	  $strVitalSignXML .='</axis>';

	  $strVitalSignXML .= '</chart>';
	  ?>
									<script>
  var dataString = '<?php echo $strVitalSignXML; ?>';
 </script>
									<!-- chart -->
									<div id="multiaxischartdiv1" align="center">FusionCharts</div>
									<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId1", "145%", "250", "0", "0", "dataString", "multiaxischartdiv1"); ?>
								</div>
							</div>

						</div>
					</li>
					<li>
						<h3 class="expand">
							Hemodynamics
						</h3>
						<div class="inner_leftinner collapse">
							<div class="inner_first1"></div>
							<div class="inner_right1">
								<div>
									<?php //echo $this->Html->script(array('/fusionpx_data/js/HemodynamicsMALine2')); ?>
									<?php 

									$strHemodynamicXML = '<chart caption="Hemodynamics" xAxisName="Time" showValues="0" labelStep="60" connectNullData="1" divLineAlpha="100" numVDivLines="4" vDivLineAlpha="0" showAlternateVGridColor="1" alternateVGridAlpha="7"  legendBgColor="1B1B1B" canvasBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff" toolTipBgColor="1B1B1B">';
									$strHemodynamicXML .= '<categories>';
									$hemoDate=$categoryStartDate;
									while($categoryLastDate >= $hemoDate) {
	 	  for($i=0; $i <= 59 ; $i++){
	 	  	if($i<= 9) {
	 	  		$i = '0'.$i;
	 	  	}
	 	   $strHemodynamicXML .= '<category label="'.date("H", strtotime($hemoDate)).".".$i.'"/>';
	      }
	      $hemoDate = date('Y-m-d H:i:s', strtotime($hemoDate. ' + 1 hours'));
	 }

	 $strHemodynamicXML .= '<category label="'.date("H", strtotime($categoryLastDate. ' + 1 hours')).".00".'"/>';
	 $strHemodynamicXML .= '</categories>';

	 $strHemodynamicXML .='<axis  title="CVP,ICP" Pos="left" tickWidth="10" divlineisdashed="1" >';

	 $strHemodynamicXML .='<dataset seriesName="CVP" color="#AFD8F8">';
	 $CVPDate=$categoryStartDate;
	 
	 while($categoryLastDate >= $CVPDate) {
	 	for($i=0; $i <= 59 ; $i++){
	 		if($i<= 9) {
	 			$i = '0'.$i;
	 		}
	 		$checkKey = date("H", strtotime($CVPDate)).".".$i;
	 		if(array_key_exists($checkKey, $getVSCentralVenous)) {
	 			$strHemodynamicXML .=  '<set value="'.$getVSCentralVenous[$checkKey].'" />';
	 		} else {
	 			$strHemodynamicXML .=  '<set value="" />';
	 		}
	 	}
	 	$CVPDate = date('Y-m-d H:i:s', strtotime($CVPDate. ' + 1 hours'));
	 }
	 // for last time //
if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSCentralVenous)) {
			$strHemodynamicXML .=  '<set value="'.$getVSCentralVenous[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
     } else {
     	$strHemodynamicXML .=  '<set value="" />';
     }
	  
	 $strHemodynamicXML .='</dataset>';
	 $strHemodynamicXML .='<dataset seriesName="ICP" color="#F6BD0F" >';
	 $ICPDate=$categoryStartDate;
	 	 while($categoryLastDate >= $ICPDate) {
	 	  for($i=0; $i <= 59 ; $i++){
	 	  	if($i<= 9) {
	 	  		$i = '0'.$i;
	 	  	}
	 	   $checkKey = date("H", strtotime($ICPDate)).".".$i;
	 	   if(array_key_exists($checkKey, $getVSIntracranialPressure)) {
	 	   	 $strHemodynamicXML .=  '<set value="'.$getVSIntracranialPressure[$checkKey].'" />';
	 	   } else {
	 	   	$strHemodynamicXML .=  '<set value="" />';
	 	   }
	 	  }
	 	  $ICPDate = date('Y-m-d H:i:s', strtotime($ICPDate. ' + 1 hours'));
	     }
	     // for last time //
if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSIntracranialPressure)) {
     	$strHemodynamicXML .=  '<set value="'.$getVSIntracranialPressure[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
     } else {
     	$strHemodynamicXML .=  '<set value="" />';
     }
	    $strHemodynamicXML .='</dataset>';
	    $strHemodynamicXML .='</axis>';

	    $strHemodynamicXML .='<axis title="CPP" titlepos="RIGHT" axisOnLeft="0" numDivLines="5" tickWidth="10" divlineisdashed="1" >';
	    $strHemodynamicXML .='<dataset seriesName="CPP" lineThickness="3" color="CC0000">';
	    $CPPDate=$categoryStartDate;
	   	    while($categoryLastDate >= $CPPDate) {
     	for($i=0; $i <= 59 ; $i++){
     		if($i<= 9) {
     			$i = '0'.$i;
     		}
     		$checkKey = date("H", strtotime($CPPDate)).".".$i;
     		if(array_key_exists($checkKey, $getVSCerebralPerfusion)) {
     			$strHemodynamicXML .=  '<set value="'.$getVSCerebralPerfusion[$checkKey].'" />';
     		} else {
     			$strHemodynamicXML .=  '<set value="" />';
     		}
     	}
     	$CPPDate = date('Y-m-d H:i:s', strtotime($CPPDate. ' + 1 hours'));
     }
     // for last time //
     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVSCerebralPerfusion)) {
     	$strHemodynamicXML .=  '<set value="'.$getVSCerebralPerfusion[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
     } else {
     	$strHemodynamicXML .=  '<set value="" />';
     }
     $strHemodynamicXML .='</dataset>';


     $strHemodynamicXML .='</axis>';
     $strHemodynamicXML .= '</chart>';
     ?>
									<script>
  var dataString = '<?php echo $strHemodynamicXML; ?>';
 </script>
									<!-- chart -->
									<div id="multiaxischartdiv2" align="center">FusionCharts</div>
									<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId2", "145%", "250", "0", "0", "dataString", "multiaxischartdiv2"); ?>
								</div>
							</div>

						</div>
					</li>
					<li>
						<h3 class="expand">
							Vasoactive Infusion
						</h3>
						<div class="inner_leftinner collapse">
							<div class="inner_first1"></div>
							<div class="inner_right1">
								<div>
									<?php //echo $this->Html->script(array('/fusionpx_data/js/VasoactiveMALine2')); ?>
									<!-- chart -->
									<?php 
									$strVasoactiveXML = '<chart caption="Vasoactive Infusion" xAxisName="Time" showValues="0" divLineAlpha="100" numVDivLines="4" vDivLineAlpha="0" showAlternateVGridColor="1" alternateVGridAlpha="7"  legendBgColor="1B1B1B" canvasBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff" toolTipBgColor="1B1B1B" connectNullData="1" labelStep="60">';
									$strVasoactiveXML .= '<categories>';
									$vasoDate=$categoryStartDate;
									while($categoryLastDate >= $vasoDate) {
	 	  for($i=0; $i <= 59 ; $i++){
	 	  	if($i<= 9) {
	 	  		$i = '0'.$i;
	 	  	}
	 	   $strVasoactiveXML .= '<category label="'.date("H", strtotime($vasoDate)).".".$i.'"/>';
	      }
	      $vasoDate = date('Y-m-d H:i:s', strtotime($vasoDate. ' + 1 hours'));
	 }
	 
	 $strVasoactiveXML .= '<category label="'.date("H", strtotime($categoryLastDate. ' + 1 hours')).".00".'"/>';
	 $strVasoactiveXML .= '</categories>';
	 $strVasoactiveXML .='<axis  title="NORepinephrine (mcg)" Pos="left" tickWidth="10" divlineisdashed="1" >';

	 $strVasoactiveXML .='<dataset seriesName="NORepinephrine" lineThickness="3" color="CC0000">';
	 $norDate=$categoryStartDate;
	  while($categoryLastDate >= $norDate) {
	  	for($i=0; $i <= 59 ; $i++){
	  		if($i<= 9) {
	  			$i = '0'.$i;
	  		}
	  		$checkKey = date("H", strtotime($norDate)).".".$i;
	  		if(array_key_exists($checkKey, $getVANORepinephrine)) {
	  			$strVasoactiveXML .=  '<set value="'.$getVANORepinephrine[$checkKey].'" />';
	  		} else {
	  			$strVasoactiveXML .=  '<set value="" />';
	  		}
	  	}
	  	$norDate = date('Y-m-d H:i:s', strtotime($norDate. ' + 1 hours'));
	  }
	  // for last time //
	  if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVANORepinephrine)) {
	  	$strVasoactiveXML .=  '<set value="'.$getVANORepinephrine[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
	  } else {
	  	$strVasoactiveXML .=  '<set value="" />';
	  }
	  $strVasoactiveXML .='</dataset>';
	  $strVasoactiveXML .='</axis>';

	  $strVasoactiveXML .='<axis title="DOPamine (mcg)" titlepos="RIGHT" axisOnLeft="0" numDivLines="5" tickWidth="10" divlineisdashed="1" connectNullData="1" >';
	  $strVasoactiveXML .='<dataset seriesName="DOPamine">';
	  $dopDate=$categoryStartDate;
	  
	    while($categoryLastDate >= $dopDate) {
	  	for($i=0; $i <= 59 ; $i++){
	  		if($i<= 9) {
	  			$i = '0'.$i;
	  		}
	  		$checkKey = date("H", strtotime($dopDate)).".".$i;
	  		if(array_key_exists($checkKey, $getVADOPamine)) {
	  			$strVasoactiveXML .=  '<set value="'.$getVADOPamine[$checkKey].'" />';
	  		} else {
	  			$strVasoactiveXML .=  '<set value="" />';
	  		}
	  	}
	  	$dopDate = date('Y-m-d H:i:s', strtotime($dopDate. ' + 1 hours'));
	  }
	  // for last time //
	  if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVADOPamine)) {
	  	$strVasoactiveXML .=  '<set value="'.$getVADOPamine[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
	  } else {
	  	$strVasoactiveXML .=  '<set value="" />';
	  }
	  $strVasoactiveXML .='</dataset>';
	  $strVasoactiveXML .='</axis>';
	  $strVasoactiveXML .= '</chart>';
	  ?>
									<script>
  var dataString = '<?php echo $strVasoactiveXML; ?>';
 </script>
									<div id="multiaxischartdiv4" align="center">FusionCharts</div>
									<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId4", "145%", "250", "0", "0", "dataString", "multiaxischartdiv4"); ?>
								</div>
							</div>
						</div>
					</li>
					<li>
						<h3 class="expand">
							Antirhythmic & Vasopressin
						</h3>
						<div class="inner_leftinner collapse">
							<div class="inner_first1"></div>
							<div class="inner_right1">
								<div>
									<?php //echo $this->Html->script(array('/fusionpx_data/js/HemodynamicsMALine2'));?>
									<?php
									$strVasopresinXML = '<chart caption="Antiarythmic & Vasopressin chart" xAxisName="Time" showValues="0" divLineAlpha="100" labelStep="60" numVDivLines="4" vDivLineAlpha="0" showAlternateVGridColor="1" alternateVGridAlpha="7"  legendBgColor="1B1B1B" canvasBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff" toolTipBgColor="1B1B1B" connectNullData="1">';
									$strVasopresinXML .= '<categories>';
									$vasopreDate=$categoryStartDate;
									while($categoryLastDate >= $vasopreDate) {
	 	  for($i=0; $i <= 59 ; $i++){
	 	  	if($i<= 9) {
	 	  		$i = '0'.$i;
	 	  	}
	 	   $strVasopresinXML .= '<category label="'.date("H", strtotime($vasopreDate)).".".$i.'"/>';
	      }
	      $vasopreDate = date('Y-m-d H:i:s', strtotime($vasopreDate. ' + 1 hours'));
	 }
	 $strVasopresinXML .= '<category label="'.date("H", strtotime($categoryLastDate. ' + 1 hours')).".00".'"/>';
	 $strVasopresinXML .= '</categories>';
	 $strVasopresinXML .='<axis  title="vasopressin(units/min)" Pos="left" tickWidth="10" divlineisdashed="1" >';
	 $strVasopresinXML .='<dataset seriesName="vasopressin" lineThickness="3" color="CC0000">';
	 $pressDate=$categoryStartDate;
	  while($categoryLastDate >= $pressDate) {
      	for($i=0; $i <= 59 ; $i++){
      		if($i<= 9) {
      			$i = '0'.$i;
      		}
      		$checkKey = date("H", strtotime($pressDate)).".".$i;
      		if(array_key_exists($checkKey, $getVPVasopressin)) {
      			$strVasopresinXML .=  '<set value="'.$getVPVasopressin[$checkKey].'" />';
      		} else {
      			$strVasopresinXML .=  '<set value="" />';
      		}
      	}
      	$pressDate = date('Y-m-d H:i:s', strtotime($pressDate. ' + 1 hours'));
      }
      // for last time //
      if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVPVasopressin)) {
      	$strVasopresinXML .=  '<set value="'.$getVPVasopressin[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
      } else {
      	$strVasopresinXML .=  '<set value="" />';
      }
      $strVasopresinXML .='</dataset>';
      $strVasopresinXML .='</axis>';
      //Esmolol axis
      if(!empty($getVPEsmolol))
      {
      	$strVasopresinXML .='<axis title="Esmolol(mcg/kg/min)" titlepos="RIGHT" axisOnLeft="0" numDivLines="5" tickWidth="10" divlineisdashed="1" >';
      	$strVasopresinXML .='<dataset seriesName="Esmolol">';
      	$esmDate=$categoryStartDate;
      	while($categoryLastDate >= $esmDate) {
     	for($i=0; $i <= 59 ; $i++){
     		if($i<= 9) {
     			$i = '0'.$i;
     		}
     		$checkKey = date("H", strtotime($esmDate)).".".$i;
     		if(array_key_exists($checkKey, $getVPEsmolol)) {
     			$strVasopresinXML .=  '<set value="'.$getVPEsmolol[$checkKey].'" />';
     		} else {
     			$strVasopresinXML .=  '<set value="" />';
     		}
     	}
     	$esmDate = date('Y-m-d H:i:s', strtotime($esmDate. ' + 1 hours'));
     }
     // for last time //
     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVPEsmolol)) {
     	$strVasopresinXML .=  '<set value="'.$getVPEsmolol[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
     } else {
     	$strVasopresinXML .=  '<set value="" />';
     }
     $strVasopresinXML .='</dataset>';
     $strVasopresinXML .='</axis>';
      }
      //Lidocaine axis
      if(!empty($getVPLidocaine))
      {
      	$strVasopresinXML .='<axis title="Lidocaine(mcg/kg/min)" titlepos="RIGHT" axisOnLeft="0" numDivLines="5" tickWidth="10" divlineisdashed="1" >';
      	$strVasopresinXML .='<dataset seriesName="Lidocaine">';
      	$lidoDate=$categoryStartDate;
      	while($categoryLastDate >= $categoryStartDate) {
     	for($i=0; $i <= 59 ; $i++){
     		if($i<= 9) {
     			$i = '0'.$i;
     		}
     		$checkKey = date("H", strtotime($lidoDate)).".".$i;
     		if(array_key_exists($checkKey, $getVPLidocaine)) {
     			$strVasopresinXML .=  '<set value="'.$getVPLidocaine[$checkKey].'" />';
     		} else {
     			$strVasopresinXML .=  '<set value="" />';
     		}
     	}
     	$lidoDate = date('Y-m-d H:i:s', strtotime($lidoDate. ' + 1 hours'));
     }
     // for last time //
     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVPLidocaine)) {
     	$strVasopresinXML .=  '<set value="'.$getVPLidocaine[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
     } else {
     	$strVasopresinXML .=  '<set value="" />';
     }
     $strVasopresinXML .='</dataset>';
     $strVasopresinXML .='</axis>';
      }
      //Propranolol axis
      if(!empty($getVPPropranolol))
      {
      	$strVasopresinXML .='<axis title="Propranolol(mcg/kg/min)" titlepos="RIGHT" axisOnLeft="0" numDivLines="5" tickWidth="10" divlineisdashed="1" >';
      	$strVasopresinXML .='<dataset seriesName="Propranolol">';
      	$proDate=$categoryStartDate;
      	while($categoryLastDate >= $proDate) {
     	for($i=0; $i <= 59 ; $i++){
     		if($i<= 9) {
     			$i = '0'.$i;
     		}
     		$checkKey = date("H", strtotime($proDate)).".".$i;
     		if(array_key_exists($checkKey, $getVPPropranolol)) {
     			$strVasopresinXML .=  '<set value="'.$getVPPropranolol[$checkKey].'" />';
     		} else {
     			$strVasopresinXML .=  '<set value="" />';
     		}
     	}
     	$proDate = date('Y-m-d H:i:s', strtotime($proDate. ' + 1 hours'));
     }
     // for last time //
     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVPPropranolol)) {
     	$strVasopresinXML .=  '<set value="'.$getVPPropranolol[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
     } else {
     	$strVasopresinXML .=  '<set value="" />';
     }
     $strVasopresinXML .='</dataset>';
     $strVasopresinXML .='</axis>';
      }
      //Amiodarone axis
      if(!empty($getVPAmiodarone))
      {
      	$strVasopresinXML .='<axis title="Amiodarone(mcg/kg/min)" titlepos="RIGHT" axisOnLeft="0" numDivLines="5" tickWidth="10" divlineisdashed="1" >';
      	$strVasopresinXML .='<dataset seriesName="Amiodarone">';
      	$amioDate=$categoryStartDate;
      	while($categoryLastDate >= $amioDate) {
     	for($i=0; $i <= 59 ; $i++){
     		if($i<= 9) {
     			$i = '0'.$i;
     		}
     		$checkKey = date("H", strtotime($amioDate)).".".$i;
     		if(array_key_exists($checkKey, $getVPAmiodarone)) {
     			$strVasopresinXML .=  '<set value="'.$getVPAmiodarone[$checkKey].'" />';
     		} else {
     			$strVasopresinXML .=  '<set value="" />';
     		}
     	}
     	$amioDate = date('Y-m-d H:i:s', strtotime($amioDate. ' + 1 hours'));
     }
     // for last time //
     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVPAmiodarone)) {
     	$strVasopresinXML .=  '<set value="'.$getVPAmiodarone[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
     } else {
     	$strVasopresinXML .=  '<set value="" />';
     }
     $strVasopresinXML .='</dataset>';
     $strVasopresinXML .='</axis>';
      }
      //Procainamide axis
      if(!empty($getVPProcainamide))
      {
      	$strVasopresinXML .='<axis title="Procainamide(mcg/kg/min)" titlepos="RIGHT" axisOnLeft="0" numDivLines="5" tickWidth="10" divlineisdashed="1" >';
      	$strVasopresinXML .='<dataset seriesName="Procainamide">';
      	$procDate=$categoryStartDate;
      	
      	while($categoryLastDate >= $procDate) {
     	for($i=0; $i <= 59 ; $i++){
     		if($i<= 9) {
     			$i = '0'.$i;
     		}
     		$checkKey = date("H", strtotime($procDate)).".".$i;
     		if(array_key_exists($checkKey, $getVPProcainamide)) {
     			$strVasopresinXML .=  '<set value="'.$getVPProcainamide[$checkKey].'" />';
     		} else {
     			$strVasopresinXML .=  '<set value="" />';
     		}
     	}
     	$procDate = date('Y-m-d H:i:s', strtotime($procDate. ' + 1 hours'));
     }
     // for last time //
     if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getVPProcainamide)) {
     	$strVasopresinXML .=  '<set value="'.$getVPProcainamide[date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" />';
     } else {
     	$strVasopresinXML .=  '<set value="" />';
     }
     $strVasopresinXML .='</dataset>';
     $strVasopresinXML .='</axis>';
      }
      $strVasopresinXML .= '</chart>';
      ?>
									<script>
  var dataString = '<?php echo $strVasopresinXML; ?>';
 </script>
									<!-- chart -->
									<div id="multiaxischartdiv6" align="center">FusionCharts</div>
									<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId6", "145%", "250", "0", "0", "dataString", "multiaxischartdiv6"); ?>
								</div>
							</div>

						</div>
					</li>
					<li>
						<h3 class="expand">
							Blood Pressure
						</h3>
						<div class="inner_leftinner collapse">
							<div class=""></div>
							<div class="inner_right1">
								<div>
									<?php //echo $this->Html->script(array('/fusionpx_data/js/bloodPressure')); ?>
									<?php 
									$strBloodPressureXML = '<chart  caption="Blood Pressure Chart" numberPrefix=""  bgColor="1B1B1B" baseFontColor="ffffff" labelStep="60" rotateLabels="1" legendBgColor="1B1B1B" primaryAxisOnLeft="0"   PYAxisName="Blood Pressure (mmHg)" bearBorderColor="#AFD8F8" bullBorderColor="#AFD8F8"  showVolumeChart="0"  borderColor="#545454" canvasBorderColor="#545454" canvasBorderThickness="2"    showAlternateHGridColor="0" plotLineThickness="1" showTooltipforWrappedLabels="1"  toolTipBgColor="1B1B1B" canvasbgColor="1B1B1B" numVDivLines="4" vDivLineAlpha="0" showAlternateVGridColor="1" alternateVGridColor="ffffff" alternateVGridAlpha="7" divLineColor="#AFD8F8" divLineAlpha="90" yAxisMaxValue="150">';
									$strBloodPressureXML .= '<categories>';
									if(!empty($chartDate))
									{
										//$bpDate=$categoryStartDate;
										$BpDate=$categoryStartDate;
												$k=1;
												while($categoryLastDate >= $BpDate) {
													for($i=0; $i <= 59 ; $i++){
														if($i<= 9) {
															$i = '0'.$i;
															$j=$k.".".$i;
														}
														$j=$k.".".$i;
														$strBloodPressureXML .= '<category label="'.date("H", strtotime($BpDate)).".".$i.'" x="'.$j.'"/>';
														$bpArray[$j]=date("H", strtotime($BpDate)).".".$i;
													}
													$BpDate = date('Y-m-d H:i:s', strtotime($BpDate. ' + 1 hours'));
													$k++;
												}
												$strBloodPressureXML .= '<category label="'.date("H", strtotime($categoryLastDate. ' + 1 hours')).".00".'" x="25.00"/>';
												$bpArray['25.00']=date("H", strtotime($categoryLastDate. ' + 1 hours')).".00";
										
									}
									else {
												$BpDate=$categoryStartDate;
												$k=1;
												while($categoryLastDate >= $BpDate) {
													for($i=0; $i <= 59 ; $i++){
														if($i<= 9) {
															$i = '0'.$i;
															$j=$k.".".$i;
														}
														$j=$k.".".$i;
														$strBloodPressureXML .= '<category label="'.date("H", strtotime($BpDate)).".".$i.'" x="'.$j.'"/>';
														$bpArray[$j]=date("H", strtotime($BpDate)).".".$i;
													}
													$BpDate = date('Y-m-d H:i:s', strtotime($BpDate. ' + 1 hours'));
													$k++;
												}
												$strBloodPressureXML .= '<category label="'.date("H", strtotime($categoryLastDate. ' + 1 hours')).".00".'" x="13.00"/>';
												$bpArray['13.00']=date("H", strtotime($categoryLastDate. ' + 1 hours')).".00";
												
												
									}
									
									$strBloodPressureXML .= '</categories>';
									$strBloodPressureXML.='<dataset>';
									if(!empty($getBPCuff))
									{
										 $i=1; $k=0;
										foreach($bpArray as $key=>$value)
										{ 
										if(array_key_exists($value,$getBPCuff['sbpCuff']))
												{	
											$Bp=explode("/",$getBPCuff['sbpCuff'][$value]);
											$strBloodPressureXML.='<set toolText="SBP='.$Bp[0].' DBP='.$Bp[1].' Mean='.$getBPCuff['meanCuff'][$value].'" open="'.$getBPCuff['meanCuff'][$value].'" high="'.$Bp[0].'" low="'.$Bp[1].'" close="'.$getBPCuff['meanCuff'][$value].'" x="'.$key.'"/>';
											
											}
											$k=$key;
										}
										// for last time //
										if(array_key_exists(date("H", strtotime($categoryLastDate. ' + 1 hours')).".00", $getBPCuff['sbpCuff'])) {
											$Bp=explode("/",$getBPCuff['sbpCuff'][date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"]);
											$strBloodPressureXML.='<set toolText="SBP='.$Bp[0].' DBP='.$Bp[1].' Mean='.$getBPCuff['meanCuff'][date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" open="'.$getBPCuff['meanCuff'][date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" high="'.$Bp[0].'" low="'.$Bp[1].'" close="'.$getBPCuff['meanCuff'][date("H", strtotime($categoryLastDate. ' + 1 hours')).".00"].'" x="'.$k.'"/>';
										}  

									} 
									
									$strBloodPressureXML.='</dataset>';
									$strBloodPressureXML.='</chart>'

		?>
									<script>
  var dataString = '<?php echo $strBloodPressureXML; ?>'; 
  
 </script>
									<div id="multiaxischartdiv3" align="center">FusionCharts</div>
									<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/CandleStick.swf", "multiaxisChartId3", "145%", "250", "0", "0", "dataString", "multiaxischartdiv3"); ?>
								</div>
							</div>
						</div>
					</li>

				</ul>
			</div>
		</div>
	</div>

	<div class="right_div">
		<div class="LabTherapyHead">
			<?php echo __('I/O (7 day)');?>
		</div>
		<div class="right_inner2">
			<div class="inner_right_inner1">
				<!-- start of intake chart -->
				<div id="ajaxInputPutputChartId">
					<?php 
					
					if(count($allSubCategories) > 0) {
  
     $strXML = '<chart connectNullData="1" showValues="0" caption="Intake/Output" syncAxisLimits="1" setAdaptiveSYMin="1" adjustDiv="1"  xAxisName="Days" yAxisName="Output/Intake" plotSpacePercent="10" formatNumberScale="0" showLegend="1" legendPosition="RIGHT" legendBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff"  canvasbgColor="1B1B1B" showAlternateHGridColor="0" toolTipBgColor="1B1B1B" plotGradientColor="" >';
     $strCategories = '<categories>';
     if(!empty($chartDate))
     {
     	$inOut=$categoryStartDate;
     }
     else{
		$inOut=$categoryLastDate;
		}
     $strCategories .= '<category label="'.date('d M', strtotime($inOut. ' - 6 day')).'"/>';
     $strCategories .= '<category label="'.date('d M', strtotime($inOut. ' - 5 day')).'"/>';
     $strCategories .= '<category label="'.date('d M', strtotime($inOut. ' - 4 day')).'"/>';
     $strCategories .= '<category label="'.date('d M', strtotime($inOut. ' - 3 day')).'"/>';
     $strCategories .= '<category label="'.date('d M', strtotime($inOut. ' - 2 day')).'"/>';
     $strCategories .= '<category label="'.date('d M', strtotime($inOut. ' - 1 day')).'"/>';
     $strCategories .= '<category label="'.date('d M',strtotime($inOut)).'"/>';
     $strCategories .= '</categories>';
		//debug($allSubCategories);
     foreach($allSubCategories as $allSubCategoriesVal) {
        	 // for continuous infusion color code //
        	 if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('continuous_infusion')) {
        	 	$color= 'color="#F34C55"';
        	 }
        	 // for medication color code //
        	 if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('medications')) {
	        	 	$color= 'color="#8CE283"';
	         }
	         // for Oral Intake color code //
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('oral')) {
	        	 	$color= 'color="#FB649C"';
	         }
	         // for GI intake color code //
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('enteral')) {
	        	 	$color= 'color="#DABBFA"';
	         }
	         // for Tube Feeding color code //
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('gastric')) {
	        	 	$color= 'color="#D9DEFC"';
	         }
	         // for urine color code //
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('urine_output')) {
	        	 	$color= 'color="#F8FA99"';
	         }
	         // for GI output color code //
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('gastric_tube_output')) {
	        	 	$color= 'color="#FCE1D9"';
	         }
	         // for chest tube color code //
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('chest_tube_outputs')) {
	        	 	$color= 'color="#BC997D"';
	         }
	         // for drain color code //
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('drain_n_chest_tubes')) {
	        	 	$color= 'color="#EACE5F"';
	         }
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('Parenteral')) {
	         	$color= 'color="#BBFAF7"';
	         }
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('Other_Intake_Sources')) {
	         	$color= 'color="#CDD53A"';
	         }
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('Emesis_Output')) {
	         	$color= 'color="#FAE3BB"';
	         }
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('Stool_Output')) {
	         	$color= 'color="#A0F5A7"';
	         }
	         if(trim($allSubCategoriesVal['ReviewSubCategory']['name']) == Configure::read('Transfusions')) {
	         	$color= 'color="#F34C55"';
	         }
	         
	         //debug($allIntakeOutputStack);
	         $strDataset .=	'<dataset seriesName="'.$allSubCategoriesVal['ReviewSubCategory']['name'].'" '.$color.'>';
	         if(strtolower($allSubCategoriesVal['ReviewSubCategory']['parameter']) == "intake") {
			//$inputDate=$categoryStartDate;
			
              $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 6 day'))].'" />';
              $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 5 day'))].'" />';
              $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 4 day'))].'" />';
              $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 3 day'))].'" />';
              $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 2 day'))].'" />';
           	  $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 1 day'))].'" />';
              $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut))].'" />';
               }
             if(strtolower($allSubCategoriesVal['ReviewSubCategory']['parameter']) == "output") {
			//$outputDate=$categoryStartDate;
              $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 6 day'))].'" />';
              $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 5 day'))].'" />';
              $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 4 day'))].'" />';
              $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 3 day'))].'" />';
              $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 2 day'))].'" />';
           	  $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut. ' - 1 day'))].'" />';
              $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime($inOut))].'" />';
                }
           	 $strDataset .= '</dataset>';
        }
			//debug($getStackMeanIntakeOutput);
        $strDataset .= '<dataset seriesName="Mean Line" renderAs="Line" color="#949494" >';
        if(!empty($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 6 day'))]) || !empty($getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 6 day'))])) {
         $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 6 day'))]-$getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 6 day'))]).'" />';
        } else {
         $strDataset .=	'<set value="" />';
        }
        if(!empty($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 5 day'))]) || !empty($getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 5 day'))])) {
         $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 5 day'))]-$getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 5 day'))]).'" />';
        } else {
         $strDataset .=	'<set value="" />';
        }
        if(!empty($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 4 day'))]) || !empty($getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 4 day'))])) {
         $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 4 day'))]-$getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 4 day'))]).'" />';
        } else {
         $strDataset .=	'<set value="" />';
        }
        if(!empty($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 3 day'))]) || !empty($getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 3 day'))])) {
         $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 3 day'))]-$getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 3 day'))]).'" />';
        } else {
         $strDataset .=	'<set value="" />';
        }
        if(!empty($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 2 day'))]) || !empty($getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 2 day'))])) {
         $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 2 day'))]-$getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 2 day'))]).'" />';
        } else {
         $strDataset .=	'<set value="" />';
        }
        if(!empty($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 1 day'))]) || !empty($getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 1 day'))])) {
         $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut. ' - 1 day'))]-$getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut. ' - 1 day'))]).'" />';
        } else {
         $strDataset .=	'<set value="" />';
        }
        if(!empty($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut))]) || !empty($getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut))])) {
         $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['Intake'][date('Y-m-d', strtotime($inOut))]-$getStackMeanIntakeOutput['Output'][date('Y-m-d', strtotime($inOut))]).'" />';
        } else {
         $strDataset .=	'<set value="" />';
        }


        $strDataset .= '</dataset>';

        $strXML .= $strCategories . $strDataset . "</chart>";
                 
        ?>
					<script>
  var dataString = '<?php echo $strXML; ?>';
 </script>
					<div id="inputoutputchartdiv" align="center">Chart will load here</div>
					<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/StackedColumn2DLine.swf", "inputoutputChartId", "200%", "300", "0", "0", 'dataString', 'inputoutputchartdiv'); ?>

					<?php 
} else {
   echo __('No Data Found.');
}
?>
				</div>
			</div>

		</div>
		<div class="right_inner3">
			<div class="inner_right_inner31 accordian content"
				id="ajaxGetLabsReportId">

				<div class="LabTherapyHead" style="padding-left: 20px;">
					<?php echo __('Labs'); ?>
				</div>
				<ul id="accordianLab" class="connectedSortable">
					<li id="none" class="">&nbsp;</li>

					<?php
					$cntLabStatus=0;
					//debug($getLabsGroupListVal);
					if(count($getLabsGroupList) > 0) {
	 	foreach($getLabsGroupList as $getLabsGroupListVal) {

	?>
					<li id="labs" class="" style="list-style: none">
						<h3 class="expand">
							<?php echo $getLabsGroupListVal['TestGroup']['name']; ?>
						</h3>
						<div class="inner_leftinner collapse ui-accordion">
							<div class="inner_first1"></div>
							<div>
								<table width="100%" class="table_format" cellpadding="0" cellspacing="0">
									<tr <?php echo "class='row_title'";?>>
										<td><?php echo __('Lab Name'); ?></td>
										<td><?php echo __('Latest'); ?></td>
										<td><?php echo __('Previous'); ?></td>
									</tr>
									<?php  //debug($getPastValueWithLaboratory);exit;
									foreach($getLabsStatusList as $getLabsStatusListVal) {
	  
	       //if($getLabsGroupListVal['TestGroup']['id'] == $getLabsStatusListVal['Laboratory']['test_group_id']) {
	       	 $cntLabStatus++;
	       	 ?>

									<tr <?php if($cntLabStatus%2 == 0) echo "class='row_gray'";?>>
										<td <?php   echo "class='table_cell'"; ?>><?php echo $getLabsStatusListVal['LaboratoryParameter']['name']; 
											       /*	 if(!empty($getLabsStatusListVal['LaboratoryHl7Result']['observation_alt_text'])){
															echo $getLabsStatusListVal['LaboratoryHl7Result']['observation_alt_text'];
														}else{
															echo $getLabsStatusListVal['LaboratoryResult']['od_universal_service_text'];
														}*/?>
														
										</td>
										<td <?php   echo "class='table_cell'"; ?>><?php echo $getPastValueWithLaboratory[$getLabsStatusListVal['Laboratory']['test_group_id']][$getLabsStatusListVal['LaboratoryParameter']['id']][0]; ?>
										</td>
										<td <?php   echo "class='table_cell'"; ?>><?php echo $getPastValueWithLaboratory[$getLabsStatusListVal['Laboratory']['test_group_id']][$getLabsStatusListVal['LaboratoryParameter']['id']][1]; ?>
										</td>
									</tr>
									<?php //}  ?>
									<?php }?>
								</table>
							</div>
						</div>

					</li>
					<?php } 
	} else {
?>
					<li>
						<div class="inner_leftinner collapse ui-accordion">
							<div class="inner_first1"></div>
							<div>
								<table width="100%" class="table_format" cellpadding="0"
									cellspacing="0">
									<tr>
										<td align="center"><?php echo __('No Record Found'); ?>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</li>
					<?php } ?>

				</ul>
			</div>

			<div class="inner_right_inner31 accordian  content"
				id="ajaxGetRespiratoryReportId">
				<div class="LabTherapyHead" style="padding-left: 20px;">
					<?php echo __('Respiratory Therapy'); ?>
				</div>
				<ul id="accordianTherapy" class="connectedSortable">

					<li id="none1" class="">&nbsp;</li>
					<?php 

					$explodeFirstRespTime = str_split($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'], 2);
					if(!empty($explodeFirstRespTime[1])) {
	  	$firstRespTime = $explodeFirstRespTime[0].":".$explodeFirstRespTime[1];
	  } else {
	  	$firstRespTime = $explodeFirstRespTime[0].":00";
	  }
	  $explodeSecondRespTime = str_split($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'], 2);
	  if(!empty($explodeSecondRespTime[1])) {
	  	$secondRespTime = $explodeSecondRespTime[0].":".$explodeSecondRespTime[1];
	  } else {
	  	$secondRespTime = $explodeSecondRespTime[0].":00";
	  }
	  $respiratoryCnt = 0;
	  $ventilatoryCnt = 0;
	  if(count($getRespiratory) > 0 || count($getOxygenTherapy) > 0 ||count($getSpO2) > 0) {
      	$respiratoryCnt++;
      	?>
					<li id="respiratory" class="">
						<h3 class="expand">
							<?php echo __('Respiratory'); ?>
						</h3>
						<div class="inner_leftinner collapse ui-accordion">
							<div class="inner_first1"></div>
							<div>
								<table width="100%" class="table_format" cellpadding="0"
									cellspacing="0">
									<tr <?php echo "class='row_title'";?>>
										<td></td>
										<td><?php echo $firstRespTime; ?></td>
										<td><?php echo $secondRespTime; ?></td>
									</tr>
									<tr>
										<td class="table_cell"><?php echo __('RR'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getRespiratory[0]['ReviewPatientDetail']['hourSlot']) echo $getRespiratory[0]['ReviewPatientDetail']['values']." ".$getRespiratory[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
	         if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getRespiratory[1]['ReviewPatientDetail']['hourSlot']) echo $getRespiratory[1]['ReviewPatientDetail']['values']." ".$getRespiratory[1]['ReviewSubCategoriesOption']['unit'];
	         if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getRespiratory[1]['ReviewPatientDetail']['hourSlot']) echo $getRespiratory[1]['ReviewPatientDetail']['values']." ".$getRespiratory[1]['ReviewSubCategoriesOption']['unit'];
	         ?>
										</td>
									</tr>
									<tr class="row_gray">
										<td class="table_cell"><?php  echo __('O2 Delivery'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getOxygenTherapy[0]['ReviewPatientDetail']['hourSlot']) echo $getOxygenTherapy[0]['ReviewPatientDetail']['values']." ".$getOxygenTherapy[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
	         if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getOxygenTherapy[1]['ReviewPatientDetail']['hourSlot']) echo $getOxygenTherapy[1]['ReviewPatientDetail']['values']." ".$getOxygenTherapy[1]['ReviewSubCategoriesOption']['unit'];
	         if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getOxygenTherapy[1]['ReviewPatientDetail']['hourSlot']) echo $getOxygenTherapy[1]['ReviewPatientDetail']['values']." ".$getOxygenTherapy[1]['ReviewSubCategoriesOption']['unit'];
	         ?>
										</td>
									</tr>
									<tr>
										<td class="table_cell"><?php echo __('O2%'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getSpO2[0]['ReviewPatientDetail']['hourSlot']) echo $getSpO2[0]['ReviewPatientDetail']['values']." ".$getSpO2[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
	         if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getSpO2[1]['ReviewPatientDetail']['hourSlot']) echo $getSpO2[1]['ReviewPatientDetail']['values']." ".$getSpO2[1]['ReviewSubCategoriesOption']['unit'];
	         if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getSpO2[1]['ReviewPatientDetail']['hourSlot']) echo $getSpO2[1]['ReviewPatientDetail']['values']." ".$getSpO2[1]['ReviewSubCategoriesOption']['unit'];
	         ?>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</li>
					<?php } ?>
					<?php 
					if(count($getMode) > 0 || count($getTVSet) > 0 ||count($getTVInhaled) > 0 ||count($getTVExhaled) > 0 ||count($getRate) > 0 ||count($getMAwP) > 0 ||count($getPIP) > 0 ||count($getPEEP) > 0 ||count($getPS) > 0) {
	   $ventilatoryCnt++;
	   ?>
					<li id="ventilator">
						<h3 class="expand">
							<?php echo __('Ventilator'); ?>
						</h3>
						<div class="inner_leftinner collapse ui-accordion">
							<div class="inner_first1"></div>
							<div>
								<table width="100%" class="table_format" cellpadding="0"
									cellspacing="0">
									<tr <?php echo "class='row_title'";?>>
										<td></td>
										<td><?php echo $firstRespTime; ?></td>
										<td><?php echo $secondRespTime; ?></td>
									</tr>
									<tr>
										<td class="table_cell"><?php echo __('Mode'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getMode[0]['ReviewPatientDetail']['hourSlot']) echo $getMode[0]['ReviewPatientDetail']['values']." ".$getMode[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
										if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getMode[1]['ReviewPatientDetail']['hourSlot']) echo $getMode[1]['ReviewPatientDetail']['values']." ".$getMode[1]['ReviewSubCategoriesOption']['unit'];
										if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getMode[1]['ReviewPatientDetail']['hourSlot']) echo $getMode[1]['ReviewPatientDetail']['values']." ".$getMode[1]['ReviewSubCategoriesOption']['unit'];
										?>
										</td>
									</tr>
									<tr class="row_gray">
										<td class="table_cell"><?php echo __('TV Set'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getTVSet[0]['ReviewPatientDetail']['hourSlot']) echo $getTVSet[0]['ReviewPatientDetail']['values']." ".$getTVSet[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
										if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getTVSet[1]['ReviewPatientDetail']['hourSlot']) echo $getTVSet[1]['ReviewPatientDetail']['values']." ".$getTVSet[1]['ReviewSubCategoriesOption']['unit'];
										if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getTVSet[1]['ReviewPatientDetail']['hourSlot']) echo $getTVSet[1]['ReviewPatientDetail']['values']." ".$getTVSet[1]['ReviewSubCategoriesOption']['unit'];
										?>
										</td>
									</tr>
									<tr>
										<td class="table_cell"><?php echo __('TV inhaled'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getTVInhaled[0]['ReviewPatientDetail']['hourSlot']) echo $getTVInhaled[0]['ReviewPatientDetail']['values']." ".$getTVInhaled[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
										if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getTVInhaled[1]['ReviewPatientDetail']['hourSlot']) echo $getTVInhaled[1]['ReviewPatientDetail']['values']." ".$getTVInhaled[1]['ReviewSubCategoriesOption']['unit'];
										if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getTVInhaled[1]['ReviewPatientDetail']['hourSlot']) echo $getTVInhaled[1]['ReviewPatientDetail']['values']." ".$getTVInhaled[1]['ReviewSubCategoriesOption']['unit'];
										?>
										</td>
									</tr>
									<tr class="row_gray">
										<td class="table_cell"><?php echo __('TV Exhaled'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getTVExhaled[0]['ReviewPatientDetail']['hourSlot']) echo $getTVExhaled[0]['ReviewPatientDetail']['values']." ".$getTVExhaled[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
										if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getTVExhaled[1]['ReviewPatientDetail']['hourSlot']) echo $getTVExhaled[1]['ReviewPatientDetail']['values']." ".$getTVExhaled[1]['ReviewSubCategoriesOption']['unit'];
										if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getTVExhaled[1]['ReviewPatientDetail']['hourSlot']) echo $getTVExhaled[1]['ReviewPatientDetail']['values']." ".$getTVExhaled[1]['ReviewSubCategoriesOption']['unit'];
										?>
										</td>
									</tr>
									<tr>
										<td class="table_cell"><?php echo __('Rate'); ?></td>
										<td class="table_cell"><?php  if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getRate[0]['ReviewPatientDetail']['hourSlot']) echo $getRate[0]['ReviewPatientDetail']['values']." ".$getRate[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
										if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getRate[1]['ReviewPatientDetail']['hourSlot']) echo $getRate[1]['ReviewPatientDetail']['values']." ".$getRate[1]['ReviewSubCategoriesOption']['unit'];
										 if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getRate[1]['ReviewPatientDetail']['hourSlot']) echo $getRate[1]['ReviewPatientDetail']['values']." ".$getRate[1]['ReviewSubCategoriesOption']['unit'];
										?>
										</td>
									</tr>
									<tr class="row_gray">
										<td class="table_cell"><?php echo __('MAwP'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getMAwP[0]['ReviewPatientDetail']['hourSlot']) echo $getMAwP[0]['ReviewPatientDetail']['values']." ".$getMAwP[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
										if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getMAwP[1]['ReviewPatientDetail']['hourSlot']) echo $getMAwP[1]['ReviewPatientDetail']['values']." ".$getMAwP[1]['ReviewSubCategoriesOption']['unit'];
										if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getMAwP[1]['ReviewPatientDetail']['hourSlot']) echo $getMAwP[1]['ReviewPatientDetail']['values']." ".$getMAwP[1]['ReviewSubCategoriesOption']['unit'];
										?>
										</td>
									</tr>
									<tr>
										<td class="table_cell"><?php echo __('PIP'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getPIP[0]['ReviewPatientDetail']['hourSlot']) echo $getPIP[0]['ReviewPatientDetail']['values']." ".$getPIP[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
										if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getPIP[1]['ReviewPatientDetail']['hourSlot']) echo $getPIP[1]['ReviewPatientDetail']['values']." ".$getPIP[1]['ReviewSubCategoriesOption']['unit'];
										if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getPIP[1]['ReviewPatientDetail']['hourSlot']) echo $getPIP[1]['ReviewPatientDetail']['values']." ".$getPIP[1]['ReviewSubCategoriesOption']['unit'];
										?>
										</td>
									</tr>
									<tr class="row_gray">
										<td class="table_cell"><?php echo __('PEEP'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getPEEP[0]['ReviewPatientDetail']['hourSlot']) echo $getPEEP[0]['ReviewPatientDetail']['values']." ".$getPEEP[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
										if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getPEEP[1]['ReviewPatientDetail']['hourSlot']) echo $getPEEP[1]['ReviewPatientDetail']['values']." ".$getPEEP[1]['ReviewSubCategoriesOption']['unit'];
										if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getPEEP[1]['ReviewPatientDetail']['hourSlot']) echo $getPEEP[1]['ReviewPatientDetail']['values']." ".$getPEEP[1]['ReviewSubCategoriesOption']['unit'];
										?>
										</td>
									</tr>
									<tr>
										<td class="table_cell"><?php echo __('PS'); ?></td>
										<td class="table_cell"><?php if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getPS[0]['ReviewPatientDetail']['hourSlot']) echo $getPS[0]['ReviewPatientDetail']['values']." ".$getPS[0]['ReviewSubCategoriesOption']['unit'];?>
										</td>
										<td class="table_cell"><?php 
										if($latestRespiratoryTime[0]['ReviewPatientDetail']['hourSlot'] == $getPS[1]['ReviewPatientDetail']['hourSlot']) echo $getPS[1]['ReviewPatientDetail']['values']." ".$getPS[1]['ReviewSubCategoriesOption']['unit'];
										if($latestRespiratoryTime[1]['ReviewPatientDetail']['hourSlot'] == $getPS[1]['ReviewPatientDetail']['hourSlot']) echo $getPS[1]['ReviewPatientDetail']['values']." ".$getPS[1]['ReviewSubCategoriesOption']['unit'];
										?>
										</td>
									</tr>
								</table>
							</div>

						</div>
					</li>
					<?php }?>
					<?php if($respiratoryCnt == 0 && $ventilatoryCnt == 0) {	?>
					<li>
						<div class="inner_leftinner collapse ui-accordion">
							<div class="inner_first1"></div>
							<div>
								<table width="100%" class="table_format" cellpadding="0"
									cellspacing="0">
									<tr>
										<td align="center"><?php echo __('No Record Found'); ?>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</li>
					<?php } ?>

				</ul>
			</div>
		</div>
	</div>
</div>
<div class="accordianLab list"></div>
<div class="accordianTherapy list"></div>
<script>
	
 $(function() {
	    $(".accordian h3.expand").toggler();
	    $(".accordian div.expand").expandAll();
	    $(".accordian div.other").expandAll({
	      expTxt : "[Show]", 
	      cllpsTxt : "[Hide]",
	      ref : "ul.collapse",
	      showMethod : "show",
	      hideMethod : "hide"
	    });
	    $(".accordian div.post").expandAll({
	      expTxt : "[Read this entry]", 
	      cllpsTxt : "[Hide this entry]",
	      ref : "div.collapse", 
	      localLinks: "p.top a"    
	    });  

	    $("#back-date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			minDate : new Date($("#form_received_on").val()),
			//maxDate : new Date(),
			onSelect:function(dateText, inst){
			 
				//yyyymmdd  = dateText.substr(0,4)+"-"+dateText.substr(4,2)+"-"+dateText.substr(6,2)  ; 
				 	
				//redirectUrl= "<?php //echo $this->Html->url(array( "action" => "index",$patient_id, "admin" => false)); ?>"+"/"+dateText ;

				//window.location = redirectUrl ;
				$("#backDateView").submit();
			}
		});  
	});
 
 $( document ).ready(function() {
	 $(".collapse").css('display','block');

		    
		});
 
 $( "#accordianLab, #accordianTherapy" ).sortable({
	    connectWith: ".connectedSortable",
	    stop: function(event, ui) {
	        $('.connectedSortable').each(function() {
	            result = "";
	            //alert($(this).sortable("toArray"));
	            $(this).find("li").each(function(){
	                result += $(this).text() + ",";
	            });
	            $("."+$(this).attr("id")+".list").html(result);
	        });
	    }
	});
</script>
