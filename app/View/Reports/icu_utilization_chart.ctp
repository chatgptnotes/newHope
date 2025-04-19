<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('ICU Utilization Rate', true).' - '.$reportYear; ?></h3>
</div>
<div class="clr ht5"></div>
 <div>
    <?php
	$graph= new FusionCharts();
	//pr($countRecord);exit;
        $monthIndex = 0;
        foreach($yaxisArray as $yaxisArrayVal) {
              $arrData[$monthIndex][1]  = $yaxisArrayVal;
              $monthIndex++;
        }
        
		    
     // total HAI chart graph
	   $recordIndex = 0;
	 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterRecordDateArray) && @in_array($key, $filterRecordDateArray)) {
			  $arrData[$recordIndex][2] = $filterRecordCountArray[$key];
          } else {
             $arrData[$recordIndex][2] = 0;
          }
          $recordIndex++;
		  
        }

	//pr($arrData);exit;
	   //Initialize <graph> element

	$strXML = "<graph caption='ICU Utilization Rate' xaxisname='Months' yaxisname='Rate'  decimalPrecision='0' yAxisMaxValue='100'>";
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = "<categories>";
	//Initiate <dataset> elements
	$strDataHAI = "<dataset  color='AFD8F8'>";
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= "<category name='" . $arSubData[1] . "' />";
        //Add <set value='...' /> to both the datasets
        $strDataHAI .= "<set value='" . $arSubData[2] . "' />";
     }
	
	//Close <categories> element
	$strCategories .= "</categories>";
	//Close <dataset> elements
    $strDataHAI .= "</dataset>";
    //Assemble the entire XML now
	$strXML .= $strCategories . $strDataHAI . "</graph>";
	
 
  
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
        
   ?>
  </div>          
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'icu_utilization_rate', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>