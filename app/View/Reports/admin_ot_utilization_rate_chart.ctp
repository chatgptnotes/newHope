<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('Ot Utilization Report', true).' - '.$reportYear; ?></h3>
</div>
<div class="clr ht5"></div>
<center>
<div id="chartContainer">FusionCharts will load here</div>
</center> 
 <div>
 <?php
	//$graph= new FusionCharts();
	//pr($countRecord);exit;
        $monthIndex = 0;
        foreach($yaxisArray as $yaxisArrayVal) {
              $arrData[$monthIndex][1]  = $yaxisArrayVal;
              $monthIndex++;
        }
        
        $otUtiIndex=0;
     foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterTotalTimeDateArray)) { 
		                    if($filterTotalTimeTakenArray[$key] > $filterTotalTimeArray[$key]) {
                               $totalDelays = ($filterTotalTimeTakenArray[$key]-$filterTotalTimeArray[$key]);
							   $spentTime = ($filterTotalTimeArray[$key] - $totalDelays);
							} else {
		                       $spentTime =  $filterTotalTimeArray[$key];
							}
							$otutirate = ($spentTime/$filterTotalTimeArray[$key])*100;
							$arrData[$otUtiIndex][2] =  $this->Number->precision($otutirate,2);
							
		  } else { 
							 $arrData[$otUtiIndex][2] = 0;
		  }

          $otUtiIndex++;
        }

	 
	   //Initialize <graph> element
	   	$strXML = '<chart caption="OT Utilisation Rate" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xAxisName="Percentage" yAxisName="OT Utilisation rate"  decimalPrecision="1" yAxisMaxValue="5" >';
//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataOtUti ='<dataset  color="AFD8F8">';
	//Iterate through the data  
	
	foreach ($arrData as $arSubData) {
		//debug($arSubData);
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
       
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	foreach ($arrData as $arSubData) {
	$strDataOtUti .= '<set value="' . $arSubData[2] . '" />';
	}
	//Close <dataset> elements
        $strDataOtUti .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataOtUti .'</chart>';
	 ?>
	 <script> var datastring = '<?php echo $strXML; ?>';</script>
	 <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "otutilizationratechart", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
	 </div>
	 <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'ot_utilization_rate', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>