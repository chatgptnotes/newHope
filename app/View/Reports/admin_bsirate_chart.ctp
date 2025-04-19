<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('BSI Rate', true)." - ".$reportYear; ?></h3>
<span><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'bsirate', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></span>
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
        
        $bsiIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterBsiDateArray) && @in_array($key, $filterBsiTotalDateArray)) {
                           $bsiRateVal = ($filterBsiCountArray[$key]/$filterBsiTotalCountArray[$key])*100;
                           $arrData[$bsiIndex][2] =  $this->Number->precision($bsiRateVal,2);
          } else {
                           $arrData[$bsiIndex][2] = 0;
          }
          $bsiIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="BSI Rate" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xaxisname="Months" yaxisname="BSI rate"  showValues="0" decimalPrecision="1" numberSuffix="%" yAxisMaxValue="5" >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataBSI = '<dataset  color="AFD8F8">';
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataBSI .= '<set value="' . $arSubData[2] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataBSI .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataBSI . '</chart>';
	
   ?>
		<script> var datastring = '<?php echo $strXML; ?>';</script>
	<?php
	echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "bsiRate", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
	 
   
  </div>          
   