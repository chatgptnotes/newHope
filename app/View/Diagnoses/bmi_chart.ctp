<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">

<h3><?php echo __('Growth Chart', true)." - ".$weight; ?></h3>
</div>
<div class="clr ht5"></div>
 <div>
    <?php
    $graph= new FusionCharts();
        
        
        if($height == 0) {
        
        //print_r($arrData);exit;  
    //Initialize <graph> element
    $strXML = "<graph caption='BMI' xaxisname='Weight' yaxisname='Height' showValues='0' decimalPrecision='0' numberSuffix='Inc.' yAxisMaxValue='100' >";
    
    //Initialize <categories> element - necessary to generate a multi-series chart
    
    
    $strCategories = "<categories>";
    //Initiate <dataset> elements
    $strDataUTI = "<dataset  color='AFD8F8'>";
    //Iterate through the data  
     
    
        //Append <category name='...' /> to strCategories
        $strCategories .= "<category name='" . $diagnosis[0][Diagnosis][weight] . "Lbs' />";
        //Add <set value='...' /> to both the datasets
        $strDataUTI .= "<set value='" . $diagnosis[0][Diagnosis][height] . "' />";
     
    
    //Close <categories> element
    $strCategories .= "</categories>";
    //Close <dataset> elements
        $strDataUTI .= "</dataset>";
        //Assemble the entire XML now
    $strXML .= $strCategories . $strDataUTI . "</graph>";
    
   
    //Create the chart - Column 3D Chart with data from strXML variable using dataXML method
    echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "utiRate", 900, 500);
    
    
    
    
   } else {
    
     // total HAI chart graph
       $haiIndex = 0;
       foreach($yaxisArray as $key => $yaxisArrayVal) {
          
          if(empty($filterSsiCountArray[$key])) $filterSsiCountArray[$key] = 0;
              
              $totalCount = $filterSsiCountArray[$key] + $filterVapCountArray[$key] + $filterUtiCountArray[$key] + $filterBsiCountArray[$key] + $filterThromboCountArray[$key]+$filterOtherCountArray[$key];
               
          if($totalCount > 0) {
                 $arrData[$haiIndex][2] = $totalCount;
          } else { 
            $arrData[$haiIndex][2] = 0;
          }
          $totalCount = 0;
          $haiIndex++;
           
       }
     
       //Initialize <graph> element
    $strXML = "<graph caption='BMI'>";
    
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
    
   }
  
    //Create the chart - Column 3D Chart with data from strXML variable using dataXML method
    
        
   ?>
  </div>