<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('ICU Utilisation Rate', true)." - ".$reportYear; ?></h3>
</div>
<div class="clr ht5"></div>
 <div>
    <?php
	$graph= new FusionCharts();
        $monthIndex = 0;
        foreach($yaxisArray as $yaxisArrayVal) {
              $arrData[$monthIndex][1]  = $yaxisArrayVal;
              $monthIndex++;
        }
        
        $icuUtiIndex=0;
		

	foreach($yaxisArray as $key => $yaxisArrayVal) {
		   // check total bed count if update in past //
		  if(array_key_exists($key, $getLastListBedMonthCount)) {
			 if($getLastListBedMonthCount[$key] != "") 
				 $allBedCountWithpast = $getLastListBedMonthCount[$key];
			 else 
				 $allBedCountWithpast = $totalBedCount;
		  }
		  $dateExp = explode("-", date("Y-m", strtotime($key))); 
	      $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $dateExp[1], $dateExp[0]); 
          if($allBedCountWithpast > 0) { $icuHours = ($allBedCountWithpast*24*$daysInMonth*60); } else { $icuHours = 0; }
		  if(@in_array($key, $filterIpdDateArray)) {  
                             $icuUtiRate =  ($filterIpdCountArray[$key]/$icuHours)*100;
							 $arrData[$icuUtiIndex][2] =  $this->Number->precision($icuUtiRate,2);
		  } else { 
							 $arrData[$icuUtiIndex][2] = 0;
		  }
          
          $icuUtiIndex++;
        }
	
        //Initialize <graph> element
	$strXML = "<graph caption='ICU Utilisation Rate' xaxisname='Months' yaxisname='ICU Utilisation rate'  yaxisname='Percentage' showValues='0' decimalPrecision='1' numberSuffix='%' yAxisMaxValue='5' >";
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = "<categories>";
	//Initiate <dataset> elements
	$strDataIcuUti = "<dataset  color='AFD8F8'>";
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= "<category name='" . $arSubData[1] . "' />";
        //Add <set value='...' /> to both the datasets
        $strDataIcuUti .= "<set value='" . $arSubData[2] . "' />";
 	}
	
	//Close <categories> element
	$strCategories .= "</categories>";
	//Close <dataset> elements
        $strDataIcuUti .= "</dataset>";
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataIcuUti . "</graph>";
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "icuUtiRate", 900, 500);
	
        
   ?>
  </div>          
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'icu_utilization_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>