<style>
body{
background-color:#1B1B1B;
}
#DeathBirth{
background-color:none;
}
</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('Mortality Rate ', true); ?></h3>
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
     
        //Mortality rate chart
        $total=0;
        foreach ($yaxisArray as $key=>$value)
        {
        	$total=$dataArray[$reportYear][$value]['death'][0]+$dataArray[$reportYear][$value]['recover'][0]+$dataArray[$reportYear][$value]['dama'][0];
        	$death[]=($dataArray[$reportYear][$value]['death'][0]/$total)*100;
        }
        	    
       /* // death chart graph
	   $recordIndex = 0;
	    
		foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterRecordDateArray) && @in_array($key, $filterRecordDateArray)) {                           
               $arrData[$recordIndex][2] = $filterRecordCountArray[$key];
          } else {
               $arrData[$recordIndex][2] = 0;
          }
          $recordIndex++;
		} */
      /*   // birth chart graph
	   $recordBirthIndex = 0;
	 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterBirthRecordDateArray) && @in_array($key, $filterBirthRecordDateArray)) {                           
               $arrData[$recordBirthIndex][3] = $filterBirthRecordCountArray[$key];
          } else {
               $arrData[$recordBirthIndex][3] = 0;
          }
          $recordBirthIndex++;
		  
        } */

	 
	   //Initialize <graph> element
	$strXML = '<chart caption="Mortality Rate Chart" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xaxisname="Months" yaxisname="Mortality Rate" numberSuffix="%"  decimalPrecision="0" yAxisMaxValue="5">';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataDeath = '<dataset seriesName="Mortality Rate"  color="AFD8F8">';
	//$strDataBirth = '<dataset seriesName="Birth Count" color="F6BD0F">';
	//Iterate through the data  
	foreach($yaxisArray as $yaxisArrayVal) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' .$yaxisArrayVal . '" />';
	}
        //Add <set value='...' /> to both the datasets
	$i=0;
	foreach($yaxisArray as $yaxisArrayVal) {
		if($death[$i]!="")
        $strDataDeath .= '<set value="' . $death[$i] . '" />';
		else 
			$strDataDeath.='<set value="0"/>';
		$i++;
	}
	/* foreach($yaxisArray as $yaxisArrayVal) {
        $strDataBirth .= '<set value="' . $arSubData[3] . '" />';
     } */
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
    $strDataDeath .= '</dataset>';
   // $strDataBirth .= '</dataset>';
    //Assemble the entire XML now
	$strXML .= $strCategories . $strDataDeath .  '</chart>';
	
 
  
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "DeathBirth", 900, 500);
        
   ?>
  <script> var datastring = '<?php echo $strXML; ?>';</script>
						   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "DeathBirth", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
						   </div>          
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'birth_death', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>