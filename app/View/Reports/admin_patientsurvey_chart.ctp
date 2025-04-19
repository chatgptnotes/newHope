<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('IPD Patient Survey Report', true)." - ".$reportYear; ?></h3>
<span><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'patientsurvey_reports', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></span>
</div>
<div class="clr ht5"></div><center>
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
        
        $strongAgreeCountIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterStAgreeDateArray)) {
                           $arrData[$strongAgreeCountIndex][2] = $filterStAgreeAnsCountArray[$key];
          } else {
                           $arrData[$strongAgreeCountIndex][2] = 0;
          }
          $strongAgreeCountIndex++;
        }

        $agreeCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterAgreeDateArray)) {
                           $arrData[$agreeCountIndex][3] = $filterAgreeAnsCountArray[$key];
          } else {
                           $arrData[$agreeCountIndex][3] = 0;
          }
          $agreeCountIndex++;
        }
	
        $nandCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterNandDateArray)) {
                           $arrData[$nandCountIndex][4] = $filterNandAnsCountArray[$key];
          } else {
                           $arrData[$nandCountIndex][4] = 0;
          }
          $nandCountIndex++;
        }

        $disagreeCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterDisgreeDateArray)) {
                           $arrData[$disagreeCountIndex][5] = $filterDisgreeAnsCountArray[$key];
          } else {
                           $arrData[$disagreeCountIndex][5] = 0;
          }
          $disagreeCountIndex++;
        }

        $stddisagreeCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterStdDateArray)) {
                           $arrData[$stddisagreeCountIndex][6] = $filterStdAnsCountArray[$key];
          } else {
                           $arrData[$stddisagreeCountIndex][6] = 0;
          }
          $stddisagreeCountIndex++;
        }

        $naCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterNaDateArray)) {
                           $arrData[$naCountIndex][7] = $filterNaAnsCountArray[$key];
          } else {
                           $arrData[$naCountIndex][7] = 0;
          }
          $naCountIndex++;
        }
        //Initialize <graph> element
	$strXML = '<chart caption="IPD Patient Survey Report" xaxisname="Months" yaxisname="Count"  showValues="0" decimalPrecision="0"  yAxisMaxValue="5" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100">';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataStrongAgreeCount = '<dataset seriesName="Strong Agree Count" color="AFD8F8">';
	$strDataAgreeCount = '<dataset seriesName="Agree Count" color="F6BD0F">';
        $strDataNandCount = '<dataset seriesName="Neither Agree Nor Disagree Count" color="CCCC00">';
        $strDataDisagreeCount = '<dataset seriesName="Disagree Count" color="FF9933">';
        $strDataStdCount = '<dataset seriesName="Strongly Disagree Count" color="FF66CC">';
        $strDataNaCount = '<dataset seriesName="Not Applicable Count" color="669900">';
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataStrongAgreeCount .= '<set value="' . $arSubData[2] . '" />';
        $strDataAgreeCount .= '<set value="' . $arSubData[3] . '" />';
        $strDataNandCount .= '<set value="' . $arSubData[4] . '" />';
        $strDataDisagreeCount .= '<set value="' . $arSubData[5] . '" />';
        $strDataStdCount .= '<set value="' . $arSubData[6] . '" />';
        $strDataNaCount .= '<set value="' . $arSubData[7] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataStrongAgreeCount .= '</dataset>';
        $strDataAgreeCount .= '</dataset>';
        $strDataNandCount .= '</dataset>';
        $strDataDisagreeCount .= '</dataset>';
        $strDataStdCount .= '</dataset>';
        $strDataNaCount .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataStrongAgreeCount . $strDataAgreeCount . $strDataNandCount . $strDataDisagreeCount . $strDataStdCount . $strDataNaCount .'</chart>';
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
	
        
   ?>
 <script> var datastring = '<?php echo $strXML; ?>';</script>
						   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "patientsurvey", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
						   </div>          
   