<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Hospital Associated Infections Cases', true)." - ".$reportYear; ?></h3>

</div>
<div class="clr ht5"></div>
 <div>
    <?php
	$graph= new FusionCharts();
        $monthIndex = 0;
        foreach($yaxisArray as $yaxisArrayVal) {
              $arrData[$monthIndex][1]  = $yaxisArrayVal;
              $monthIndex++;
        }
        
		if($reportType == 2) {
		  // Rate chart graph
          $ssiIndex = 0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterSsiDateArray) && @in_array($key, $filterSpDateArray)) {
                           $ssiRate = ($filterSsiCountArray[$key]/$filterSpCountArray[$key])*100;
                           $arrData[$ssiIndex][2] = $ssiRate;
          } else {
                           $arrData[$ssiIndex][2] = 0;
          }
          $ssiIndex++;
        }
	 
        $vapIndex = 0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterVapDateArray) && @in_array($key, $filterMvDateArray)) {
                           $vapRate = ($filterVapCountArray[$key]/$filterMvCountArray[$key])*100;
                           $arrData[$vapIndex][3] = $vapRate;
          } else {
                           $arrData[$vapIndex][3] = 0;
          }
          $vapIndex++;
        }

        $utiIndex = 0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterUtiDateArray) && @in_array($key, $filterUcDateArray)) {
                           $utiRate = ($filterUtiCountArray[$key]/$filterUcCountArray[$key])*100;
                           $arrData[$utiIndex][4] = $utiRate;
          } else {
                           $arrData[$utiIndex][4] = 0;
          }
          $utiIndex++;
        }

        $bsiIndex = 0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterBsiDateArray) && @in_array($key, $filterClDateArray)) {
                           $bsiRate = ($filterBsiCountArray[$key]/$filterClCountArray[$key])*100;
                           $arrData[$bsiIndex][5] = $bsiRate;
          } else {
                           $arrData[$bsiIndex][5] = 0;
          }
          $bsiIndex++;
        }

        $thromboIndex = 0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterThromboDateArray) && @in_array($key, $filterPlDateArray)) {
                           $thromboRate = ($filterThromboCountArray[$key]/$filterPlCountArray[$key])*100;
                           $arrData[$thromboIndex][6] = $thromboRate;
          } else {
                           $arrData[$thromboIndex][6] = 0;
          }
         $thromboIndex++;
        }
		  
	//Initialize <graph> element
	$strXML = '<chart caption="RATE" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xAxisName="Months" yAxisName="Percentage"  decimalPrecision="0" yAxisMaxValue="5">';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	
	//Initiate <dataset> elements
	$strDataSSI = '<dataset seriesName="SSI" color="AFD8F8">';
	$strDataVAP = '<dataset seriesName="VAP" color="F6BD0F">';
        $strDataUTI = '<dataset seriesName="UTI" color="CCCC00">';
        $strDataBSI = '<dataset seriesName="BSI" color="FF9933">';
        $strDataThrombo = '<dataset seriesName="Thrombo" color="FF66CC">';
	
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataSSI .= '<set value="' . $arSubData[2] . '" />';
        $strDataVAP .= '<set value="' . $arSubData[3] . '" />';
        $strDataUTI .= '<set value="' . $arSubData[4] . '" />';
        $strDataBSI .= '<set value="' . $arSubData[5] . '" />';
        $strDataThrombo .= '<set value="' . $arSubData[6] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	
	//Close <dataset> elements
        $strDataSSI .= '</dataset>';
        $strDataVAP .= '</dataset>';
        $strDataUTI .= '</dataset>';
        $strDataBSI .= '</dataset>';
        $strDataThrombo .= '</dataset>';

	
	//Assemble the entire XML now
	$strXML .= $strCategories . $strDataSSI . $strDataVAP . $strDataUTI . $strDataBSI . $strDataThrombo . '</chart>';
	
   } else {
    
     // total HAI chart graph
	   $haiIndex = 0;
	   foreach($yaxisArray as $key => $yaxisArrayVal) {
		  
	      if(empty($filterSsiCountArray[$key])) $filterSsiCountArray[$key] = 0;
              if(empty($filterVapCountArray[$key])) $filterVapCountArray[$key] = 0;
              if(empty($filterUtiCountArray[$key])) $filterUtiCountArray[$key] = 0;
              if(empty($filterBsiCountArray[$key])) $filterBsiCountArray[$key] = 0;
              if(empty($filterThromboCountArray[$key])) $filterThromboCountArray[$key] = 0;
              if(empty($filterOtherCountArray[$key])) $filterOtherCountArray[$key] = 0;
              $totalCount = $filterSsiCountArray[$key] + $filterVapCountArray[$key] + $filterUtiCountArray[$key] + $filterBsiCountArray[$key] + $filterThromboCountArray[$key]+$filterOtherCountArray[$key];
			   
          if($totalCount > 0) {
                 $arrData[$haiIndex][2] = $totalCount;
          } else { 
		    $arrData[$haiIndex][2] = 0;
		  }
          $totalCount = 0;
		  $haiIndex++;
		   
	   }
	 
	   //Initialize <graph> element
	$strXML = '<chart caption="TOTAL HAI" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xAxisName="Months" yAxisName="Count"  decimalPrecision="0" yAxisMaxValue="5">';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataHAI = '<dataset  color="AFD8F8">';
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataHAI .= '<set value="' . $arSubData[2] . '" />';
     }
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
    $strDataHAI .= '</dataset>';
    //Assemble the entire XML now
	$strXML .= $strCategories . $strDataHAI . '</chart>';
	
   }
  
	 //Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
        
   ?>
   <center>
                            <div id="chartContainer">FusionCharts will load here</div>
                           <script type="text/javascript"><!--
                                FusionCharts.setCurrentRenderer('JavaScript');
                                var myChart = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "surgicalsiteinfectionschart", "900", "500", "0", "1");
                                var datastring = '<?php echo $strXML; ?>';
                                myChart.setXMLData(datastring);
                                myChart.render( "chartContainer" );
								
								myChart.addEventListener( "nodatatodisplay", function() { 
									if ( window.windowIsReady ){
										notifyLocalAJAXSecurityRestriction(); 
									}else
									{
										$(document).ready (function(){
											notifyLocalAJAXSecurityRestriction();
										});
									}
									
								});
								
                                // -->
                            </script>
                        </center> 
  </div>                  
  </div>          
 <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'hospital_acquire_infections_reports', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>