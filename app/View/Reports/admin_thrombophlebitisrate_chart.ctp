<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Thrombophlebitis Rate', true)." - ".$reportYear;  ?></h3>
<span><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'thrombophlebitisrate', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></span>
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
        
        $thromboIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterThromboDateArray) && @in_array($key, $filterThromboTotalDateArray)) {
                           $thromboRateVal = ($filterThromboCountArray[$key]/$filterThromboTotalCountArray[$key])*100;
                           $arrData[$thromboIndex][2] =  $this->Number->precision($thromboRateVal,2);
          } else {
                           $arrData[$thromboIndex][2] = 0;
          }
          $thromboIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="Thrombophlebitis Rate" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xaxisname="Months" yaxisname="Thrombophlebitis rate" showValues="0" decimalPrecision="1" numberSuffix="%" yAxisMaxValue="5" >';
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataThrombo = '<dataset  color="AFD8F8">';
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataThrombo .= '<set value="' . $arSubData[2] .'" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataThrombo .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataThrombo . '</chart>';?>
	<script> var datastring = '<?php echo $strXML; ?>';</script>
	   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "thromboRate", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
	   </div> 
     </div>          
   