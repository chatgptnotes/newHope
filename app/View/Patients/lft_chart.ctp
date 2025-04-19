<?php
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<?php //echo"<pre>";print_r($labResults);exit;?>
<h3><?php echo __('L.F.T Chart', true)." For - ".$patients[0]['Patient']['lookup_name'];?></h3>
</div>
<div class="clr ht5"></div>
 <div>
    <?php
    
	$graph= new FusionCharts();$check = 0;$lastIndex='';$continueIndex = -1;
	for($b=0;$b<count($labResults);$b++){
	for($c=0;$c<count($labResults[$b]['LaboratoryHl7Result']);$c++){
		if(empty($lastIndex)){
			$lastIndex = $b;
		}
		$continueIndex++;

			$a[]=$labResults[$b][LaboratoryHl7Result][$c][observations];
			$arrData[$lastIndex][$continueIndex][observations] = $labResults[$b][LaboratoryHl7Result][$c][observations];
        $arrData[$lastIndex][$continueIndex][result] = $labResults[$b][LaboratoryHl7Result][$c][result];


$arrData[$lastIndex][$continueIndex][create_time] = $labResults[$b][LaboratoryHl7Result][$c][create_time];

if($check == 0){
	$lastIndex = $b;
	$check = 1;
}
}
	}
	//echo"<pre>";print_r($arrData);exit;
        //Initialize <graph> element
	$strXML = "<graph caption='L.F.T Chart' xaxisname='Noted On' yaxisname='L.F.T Count' showValues='0' decimalPrecision='1' numberSuffix=' /Min.' yAxisMaxValue='5' >";
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = "<categories>";
	$strCategories2 = "<categories>";
	//Initiate <dataset> elements
	$strDataSSI = "<dataset seriesName = 'Total Bilirubin' color='AFD8F8'>";
	
	$strDataSSI2 = "<dataset seriesName = 'Direct Bilirubin' color='FEF607'>";
	
	$strDataSSI3 = "<dataset seriesName = 'INR' color='E52929'>";
	
	$strDataSSI4 = "<dataset seriesName = 'Alkaline Phosphatase' color='0000CC'>";
	
	$strDataSSI5 = "<dataset seriesName = 'Albumin' color='00FF00'>";
	
	$strDataSSI6 = "<dataset seriesName = 'Asparate Transaminase' color='FF5050'>";
	
	$strDataSSI7 = "<dataset seriesName = 'Cognetial Bilirubin Disorder' color='536A62'>";
	
	$strDataSSI8 = "<dataset seriesName = 'High Bilirubin Neonates' color='66FFCC'>";
	
	$strDataSSI9 = "<dataset seriesName = 'Gamma Glutamyl' color='663300'>";
	//Iterate through the data  
	
foreach ($arrData as $arSubData) {
		foreach($arSubData as $subData){
			if($subData['observations'] == '1975-2'){
				//echo"<pre>";print_r($subData);exit;
		        //Append <category name='...' /> to strCategories
		        $strCategories .= "<category name='" . $subData[create_time]. " ' />";
		        //Add <set value='...' /> to both the datasets
		        $strDataSSI .= "<set value='" . $subData[result] . "' />";
			}
			else if($subData['observations'] == '1968-7'){
				//echo"<pre>";print_r($subData);exit;
				//Append <category name='...' /> to strCategories
				//$strCategories2 .= "<category name='" . $subData[create_time]. " ' />";
				//Add <set value='...' /> to both the datasets
				$strDataSSI2 .= "<set value='" . $subData[result] . "' />";
			}
			else if($subData['observations'] == '6301-6'){
				//echo"<pre>";print_r($subData);exit;
				//Append <category name='...' /> to strCategories
				//$strCategories2 .= "<category name='" . $subData[create_time]. " ' />";
				//Add <set value='...' /> to both the datasets
				$strDataSSI3 .= "<set value='" . $subData[result] . "' />";
			}
			else if($subData['observations'] == '1783-0'){
				//echo"<pre>";print_r($subData);exit;
				//Append <category name='...' /> to strCategories
				//$strCategories2 .= "<category name='" . $subData[create_time]. " ' />";
				//Add <set value='...' /> to both the datasets
				$strDataSSI4 .= "<set value='" . $subData[result] . "' />";
			}
			else if($subData['observations'] == '14956-7'){
				//echo"<pre>";print_r($subData);exit;
				//Append <category name='...' /> to strCategories
				//$strCategories2 .= "<category name='" . $subData[create_time]. " ' />";
				//Add <set value='...' /> to both the datasets
				$strDataSSI5 .= "<set value='" . $subData[result] . "' />";
			}
			else if($subData['observations'] == '14414-7'){
				//echo"<pre>";print_r($subData);exit;
				//Append <category name='...' /> to strCategories
				//$strCategories2 .= "<category name='" . $subData[create_time]. " ' />";
				//Add <set value='...' /> to both the datasets
				$strDataSSI6 .= "<set value='" . $subData[result] . "' />";
			}
			else if($subData['observations'] == '14629-0'){
				//echo"<pre>";print_r($subData);exit;
				//Append <category name='...' /> to strCategories
				//$strCategories2 .= "<category name='" . $subData[create_time]. " ' />";
				//Add <set value='...' /> to both the datasets
				$strDataSSI7 .= "<set value='" . $subData[result] . "' />";
			}
			else if($subData['observations'] == '24357-6'){
				//echo"<pre>";print_r($subData);exit;
				//Append <category name='...' /> to strCategories
				//$strCategories2 .= "<category name='" . $subData[create_time]. " ' />";
				//Add <set value='...' /> to both the datasets
				$strDataSSI8 .= "<set value='" . $subData[result] . "' />";
			}
			
			else if($subData['observations'] == '17858-2'){
				//echo"<pre>";print_r($subData);exit;
				//Append <category name='...' /> to strCategories
				//$strCategories2 .= "<category name='" . $subData[create_time]. " ' />";
				//Add <set value='...' /> to both the datasets
				$strDataSSI9 .= "<set value='" . $subData[result] . "' />";
			}
		}
 	}
 	//echo"<pre>";print_r($subData);exit;
	//Close <categories> element
	$strCategories .= "</categories>";
	$strCategories2 .= "</categories>";
	//Close <dataset> elements
        $strDataSSI .= "</dataset>";
        
        $strDataSSI2 .= "</dataset>";
        
        $strDataSSI3 .= "</dataset>";
        
        $strDataSSI4 .= "</dataset>";
        
        $strDataSSI5 .= "</dataset>";
        
        $strDataSSI6 .= "</dataset>";
        
        $strDataSSI7 .= "</dataset>";
        
        $strDataSSI8 .= "</dataset>";
        
        $strDataSSI9 .= "</dataset>";
        //Assemble the entire XML now
	$strXML .= $strCategories . $strCategories2 . $strDataSSI . $strDataSSI2 . $strDataSSI3 . $strDataSSI4 . $strDataSSI5 . $strDataSSI6 . $strDataSSI7 . $strDataSSI8 . $strDataSSI9 . "</graph>";
	//echo $strDataSSI2;exit;
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSLine.swf"), "", $strXML, "ssiRate", 900, 500);
        
   ?>
  </div>