<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Time Taken For Admission', true).' - '.$reportYear; ?></h3>
</div>
<div class="clr ht5"></div>
 <div>
    <?php
	$graph= new FusionCharts(); 

		
	//Initialize <graph> element
	$strXML = "<graph caption='Time Taken For Admission' xaxisname='Months' yaxisname='Minutes' showValues='0'  showValues='0' decimalPrecision='0' yAxisMaxValue='100'>";
   
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = "<categories>";
	$strDataThrombo = "<dataset seriesName='Avg time' color='FF66CC'>";
	//Initiate <dataset> elements
	  
	 $month =array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	 $fullMonth =array('January','February','March','April','May','June','July','August','September','October','November','December');
	 if(count($reports) > 0) {
		   $i = 1;
		   $in = 1  ;
		   $finalremTime =array();
		   
      	   foreach($reports as $pdfData){	
				$excelDataChanged= $pdfData['Patient'];	
				$finalWaitingTime ='';
 				if(!empty($excelDataChanged['create_time']) && !empty($excelDataChanged['form_received_on'])){
			 		
 					$datetime1 = new DateTime($excelDataChanged['create_time']);
					$datetime2 = new DateTime($excelDataChanged['form_received_on']);
					$interval = $datetime1->diff($datetime2);
					//EOF cal
					
					$timeDay 	= $interval->days;
					$timeDaySec = $timeDay*3600*24;
					$timeHr 	= $interval->h;
					$timeHrSec 	= $timeHr*3600;
					$timeMin 	= $interval->i;
					$timeMinSec = $timeMin*60;
					$timeSecSec	= $interval->s ;
					$timeSec 	= $interval->s;	
								
				 	$finalremTime[$datetime1->format('M')][] =  (int)((int)$timeDaySec+(int)$timeHrSec+(int)$timeMinSec+(int)$timeSec)/60;
					 
			}
      	}
	 }
			 
	 foreach($month as $monIndex =>$mon){ 
			//calculating avg
			$arraySum ='';
			if(isset($finalremTime[$mon])){
				$arraySum = array_sum($finalremTime[$mon])/count($finalremTime[$mon]) ;
			} 
			$arrData[$monIndex][1] = $mon;
 			$arrData[$monIndex][2] = ($arraySum > 0)?round($arraySum):''; 			 
 			
 	 }	 
 
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
		 
        //Append <category name='...' /> to strCategories
        $strCategories .= "<category name='" . $arSubData[1] . "' />";
        //Add <set value='...' /> to both the datasets        
        $strDataThrombo .= "<set value='" . $arSubData[2] . "' />"; 
        
	}
	//Close <dataset> elements
      
        $strDataThrombo .= "</dataset>";
	
	//Close <categories> element
	$strCategories .= "</categories>";
	
	
	
	//Assemble the entire XML now
	$strXML .= $strCategories  . $strDataThrombo . "</graph>";
	
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
        
   ?>
  </div>          
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'ipd_opd', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>