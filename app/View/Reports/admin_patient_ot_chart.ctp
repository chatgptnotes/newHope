<?php 
     App::import('Vendor', 'fusionx_charts'); 
     echo $this->Html->script(array('/fusionx_charts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Total Surgery Report', true); ?></h3>
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
        
        $majorCountIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterMajorDateArray)) {
                           $arrData[$majorCountIndex][2] = $filterMajorCountArray[$key];
          } else {
                           $arrData[$majorCountIndex][2] = 0;
          }
          $majorCountIndex++;
        }

        $minorCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterMinorDateArray)) {
                           $arrData[$minorCountIndex][3] = $filterMinorCountArray[$key];
          } else {
                           $arrData[$minorCountIndex][3] = 0;
          }
          $minorCountIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="Total Surgery Report" xaxisname="Months" yaxisname="OT Surgery Count"  showValues="0" decimalPrecision="0"  yAxisMaxValue="5" >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataMajorCount = '<dataset seriesName="Major Surgery Count" color="AFD8F8">';
	$strDataMinorCount = '<dataset seriesName="Minor Surgery Count" color="F6BD0F">';
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataMajorCount .= '<set value="' . $arSubData[2] . '" />';
        $strDataMinorCount .= '<set value="' . $arSubData[3] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataMajorCount .= '</dataset>';
        $strDataMinorCount .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataMajorCount . $strDataMinorCount . '</chart>';
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
	
        
   ?>
   <script >var datastring=<?php echo $strXML;?></script>
     </div>    
     <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "otchart", "900", "500", "0", "0", "datastring", "chartContainer"); ?>      
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'patient_ot_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>