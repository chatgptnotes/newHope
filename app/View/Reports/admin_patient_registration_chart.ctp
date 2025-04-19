<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Total Number Of MRN', true); ?></h3>
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
        
        $patientRegIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterPatientRegDateArray)) {
                           $arrData[$patientRegIndex][2] = $filterPatientRegCountArray[$key];
          } else {
                           $arrData[$patientRegIndex][2] = 0;
          }
          $patientRegIndex++;
        }
	
        //Initialize <graph> element
	$strXML = "<graph caption='Patient Registration Report' xaxisname='Months' yaxisname='Patient Registration Count'  showValues='0' decimalPrecision='0' yAxisMaxValue='5' >";
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = "<categories>";
	//Initiate <dataset> elements
	$strDataPatientReg = "<dataset  color='AFD8F8'>";
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= "<category name='" . $arSubData[1] . "' />";
        //Add <set value='...' /> to both the datasets
        $strDataPatientReg .= "<set value='" . $arSubData[2] . "' />";
 	}
	
	//Close <categories> element
	$strCategories .= "</categories>";
	//Close <dataset> elements
        $strDataPatientReg .= "</dataset>";
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataPatientReg . "</graph>";
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
	
        
   ?>
  </div>          
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'patient_registration_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>