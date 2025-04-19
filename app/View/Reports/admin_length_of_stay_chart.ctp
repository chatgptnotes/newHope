<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('Average Length of Stay', true).' - '.$reportYear; ?></h3>
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
        
        $losIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterIpdDateArray) && @in_array($key, $filterdischargeDeathDateArray)) {
                           $losRateVal = $filterIpdCountArray[$key]/$filterdischargeDeathCountArray[$key];
                           $arrData[$losIndex][2] =  $this->Number->precision($losRateVal,2);
          } else {
                           $arrData[$losIndex][2] = 0;
          }
          $losIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="Average Length of Stay" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xaxisname="Months" yaxisname="ALOS rate" showValues="0" decimalPrecision="1" numberSuffix="%" yAxisMaxValue="5" >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataLOS = '<dataset  color="AFD8F8">';
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataLOS .= '<set value="' . $arSubData[2] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataLOS .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataLOS . '</chart>';
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
	?>
				<script> var datastring = '<?php echo $strXML; ?>';</script>
				   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "myNext", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
		
	  </div>           
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'length_of_stay', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>