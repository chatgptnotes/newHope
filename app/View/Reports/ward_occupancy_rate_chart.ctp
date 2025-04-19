<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('Bed Occupancy Report', true).' - '.$reportYear; ?></h3>

</div>
<div class="clr ht5"></div>
<center>
<div id="chartContainer">FusionCharts will load here</div>
</center>
 <div>
    <?php
	//$graph= new FusionCharts();
        $monthIndex = 0;
        foreach($yaxisArray as $yaxisArrayVal) {
              $arrData[$monthIndex][1]  = $yaxisArrayVal;
              $monthIndex++;
        }
        
        $bedIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
		
          if(@in_array($key, $filterIpdDateArray) && $totalBed > 0) {
                           #$bedOccupancyRateVal = ($filterIpdCountArray[$key]/$filterWardCountArray[$key])*100;
                           	$month = date("m", strtotime($key));
                         	$year = date("Y", strtotime($key));
                         	$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                if($year == date("Y")) {
                                  //$bedOccupancyRateVal= ($filterIpdCountArray[$key]/($filterWardCountArray[$key]*(date("d")-1)))*100;
                                  $bedOccupancyRateVal= ($filterIpdCountArray[$key]/($totalBed*$numberOfDays))*100;
                                  
                                } else { 
                         	      //$bedOccupancyRateVal= ($filterIpdCountArray[$key]/($filterWardCountArray[$key]*$numberOfDays))*100;
                         	      $bedOccupancyRateVal= ($filterIpdCountArray[$key]/($totalBed*$numberOfDays))*100;
                                }
                         	
                           $arrData[$bedIndex][2] = $bedOccupancyRateVal;
          } else {
                           $arrData[$bedIndex][2] = 0;
          }
          $bedIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="Bed Occupancy Report" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xaxisname="Months" yaxisname="Bed Occupancy rate"  showValues="0" decimalPrecision="2" numberSuffix="%" yAxisMaxValue="100" >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strBedOccupancy = '<dataset  color="AFD8F8">';
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strBedOccupancy .= '<set value="' . $arSubData[2] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strBedOccupancy .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strBedOccupancy . '</chart>';
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
	
        
   ?>
 <script> var datastring = '<?php echo $strXML; ?>';</script>
	   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "myNext", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
	   </div>          
 <div class="btns" style="padding-right: 105px;"><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'ward_occupancy_rate', 'admin'=>false),array('class'=>'blueBtn','div'=>false)); ?></div> 