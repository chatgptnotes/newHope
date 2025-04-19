<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Hospital Turnover Rate', true); ?></h3>
</div>
<div class="clr ht5"></div>
 <div>
    <?php
	$graph= new FusionCharts(); 

		
	//Initialize <graph> element
	$strXML = "<graph caption='Hospital Turnover Rate' xaxisname='Months' yaxisname='Rate' showValues='0'   numberSuffix='' >";
 
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = "<categories>";
	
	//Initiate <dataset> elements
	$strDataSSI = "<dataset seriesName='TOR' color='AFD8F8'>"; 
     
 	$monthIndex = 0;
 	 
	foreach($data as $monIndex =>$mon){
		 
 			$arrData[$monIndex][1] = $monIndex;
 			$arrData[$monIndex][2] = $mon['tor'];
 	}	 
  
 
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= "<category name='" . $arSubData[1] . "' />";
        //Add <set value='...' /> to both the datasets
        $strDataSSI .= "<set value='" . $arSubData[2] . "' />";
	}
	
	//Close <categories> element
	$strCategories .= "</categories>";
	
	//Close <dataset> elements
    $strDataSSI .= "</dataset>";
     

	
	//Assemble the entire XML now
	$strXML .= $strCategories.$strDataSSI. "</graph>";
	
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
        
   ?>
  </div>          
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'tor', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>