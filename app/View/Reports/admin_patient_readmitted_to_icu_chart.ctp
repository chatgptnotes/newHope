<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('Total Number of Patient Readmitted to ICU within 48 hrs', true).' - '.$reportYear;  ?></h3>

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
        
        $patientReadmittedIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterPatientReadmittedDateArray)) {
                           $arrData[$patientReadmittedIndex][2] = $filterPatientReadmittedCountArray[$key];
          } else {
                           $arrData[$patientReadmittedIndex][2] = 0;
          }
          $patientReadmittedIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="Total Number of Patient Readmitted to ICU within 48 hrs" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xaxisname="Month" yaxisname="Patient Readmitted Count" showValues="0" decimalPrecision="0"  yAxisMaxValue="5" >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataMonthlyReadmitted = '<dataset  color="AFD8F8">';
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] .'" />';
        //Add <set value='...' /> to both the datasets
        $strDataMonthlyReadmitted .= '<set value="' . $arSubData[2] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataMonthlyReadmitted .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataMonthlyReadmitted . '</chart>';
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "monthly_readmittedpatient", 900, 500);
	?>
		   <script> var datastring = '<?php echo $strXML; ?>';</script>
						   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "monthly_readmittedpatient", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
						   </div>          
<div class="btns" style="padding-right: 105px;"><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'patient_readmitted_to_icu', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></div> 