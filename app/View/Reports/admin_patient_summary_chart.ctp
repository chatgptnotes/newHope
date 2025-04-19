<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('Patient Summary With Cash/Card Type', true).' - '.$reportYear; ?></h3>

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
        
        $patientIPDCashIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterYearIPDCashDateArray)) {
                           $arrData[$patientIPDCashIndex][2] = $filterYearIPDCashCountArray[$key];
          } else {
                           $arrData[$patientIPDCashIndex][2] = 0;
          }
          $patientIPDCashIndex++;
        }
        $patientIPDCardIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterYearIPDCardDateArray)) {
                           $arrData[$patientIPDCardIndex][3] = $filterYearIPDCardCountArray[$key];
          } else {
                           $arrData[$patientIPDCardIndex][3] = 0;
          }
          $patientIPDCardIndex++;
        }
        $patientOPDCashIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterYearOPDCashDateArray)) {
                           $arrData[$patientOPDCashIndex][4] = $filterYearOPDCashCountArray[$key];
          } else {
                           $arrData[$patientOPDCashIndex][4] = 0;
          }
          $patientOPDCashIndex++;
        }
        $patientOPDCardIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterYearOPDCardDateArray)) {
                           $arrData[$patientOPDCardIndex][5] = $filterYearOPDCardCountArray[$key];
          } else {
                           $arrData[$patientOPDCardIndex][5] = 0;
          }
          $patientOPDCardIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="Patient Summary With Cash/Card Type" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xaxisname="Month" yaxisname="IPD/OPD Patient With Cash/Card Type" showValues="0" decimalPrecision="0"  yAxisMaxValue="5" >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataIPDCash = '<dataset seriesName="IPD Cash" color="AFD8F8">';
	$strDataIPDCard = '<dataset seriesName="IPD Card" color="F6BD0F">';
        $strDataOPDCash = '<dataset seriesName="OPD Cash" color="CCCC00">';
        $strDataOPDCard = '<dataset seriesName="OPD Card" color="FF9933">';
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        $strDataIPDCash .= '<set value="' . $arSubData[2] . '" />';
        $strDataIPDCard .= '<set value="' . $arSubData[3] . '" />';
        $strDataOPDCash .= '<set value="' . $arSubData[4] . '" />';
        $strDataOPDCard .= '<set value="' . $arSubData[5] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataIPDCash .= '</dataset>';
        $strDataIPDCard .= '</dataset>';
        $strDataOPDCash .= '</dataset>';
        $strDataOPDCard .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataIPDCash . $strDataIPDCard . $strDataOPDCash . $strDataOPDCard . '</chart>';
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "patientsummary", 900, 500);
	
	?>
			 <script> var datastring = '<?php echo $strXML; ?>';</script>
				   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "patientsummary", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
				   </div>      
 <div class="btns" style="padding-right: 105px;"><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'patient_summary', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></div> 