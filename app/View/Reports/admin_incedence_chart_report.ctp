<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('Incident Report', true)." - ".$year; ?></h3>
</div>
<div class="clr ht5"></div>
<center>
<div id="chartContainer">FusionCharts will load here</div>
</center>
 <div>
    <?php
	//Initialize <graph> element
	$strXML = '<chart caption="Incident Report" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xaxisname="Months" yaxisname="Count" showValues="0"  yAxisMaxValue="10" >';
 
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	
	//Initiate <dataset> elements
	$strDataSSI = '<dataset seriesName="Medication Errors" color="AFD8F8">';
	$colorArr = array('F6BD0F','F6BD0F','CCCC00','FF9933','FF66CC','CCCCCC','FFF444','FFDDCC');
	$i=0;
	foreach($incidentType as $typeName){
		$newName = strtolower(str_replace(' ','_',$typeName['IncidentType']['name']));
		//$$newName = strtolower(str_replace(' ','_',$typeName['IncidentType']['name'])) ; 
		$$newName = '<dataset seriesName="'.$typeName['IncidentType']['name'].'" color="'.$colorArr[$i].'">';
		$i++;
	}    
	    
	/*$strDataVAP = "<dataset seriesName='Transfusion Errors' color='F6BD0F'>";
    $strDataUTI = "<dataset seriesName='Patient Fall' color='CCCC00'>";
    $strDataBSI = "<dataset seriesName='Bed Sores' color='FF9933'>";
    $strDataThrombo = "<dataset seriesName='Needle Stick injury' color='FF66CC'>";*/
      
    
	 $medication_error_count = 0 ; 
	 $mon =date('M',strtotime($pdfData['Incident']['incident_date'])) ;
	 $month =array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	 $fullMonth =array('January','February','March','April','May','June','July','August','September','October','November','December');
	 $j=0 ;
	 foreach($fullMonth as $fm)
	 {
	 	$strCategories .= '<category name="' . $fm . '" />';
	 }
	   
 	 foreach($month as $mon){ 
		$fullMon =  $fullMonth[$j] ;
		$arrData[$j][1] = $fullMon;  
 		$arrData[$j][2] = ($discharge[$fullMon]>0)?round($record[$fullMon]['medication_error']/$discharge[$fullMon],2):0;
 		$inCount  = 3 ; 
 		foreach($incidentType as $typeName){
			$arrData[$j][$inCount] = ($discharge[$fullMon]>0)?round($record[$fullMon][$typeName['IncidentType']['name']]/$discharge[$fullMon],2):0;
			$inCount++;
		} 
	   	$j++; 
 	 }  	
			 
			 
	 
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
		//debug($arSubData);
        //Append <category name='...' /> to strCategories
        //$strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataSSI .= '<set value="' . $arSubData[2] . '" />';
        $innerCount  =3 ;
        foreach($incidentType as $typeName){
			$newName = strtolower(str_replace(' ','_',$typeName['IncidentType']['name']));
			$$newName .= '<set value="' . $arSubData[$innerCount] . '" />';
			$innerCount++;
		}   
         
        
	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	
	//Close <dataset> elements
        $strDataSSI .= '</dataset>';
        
        foreach($incidentType as $typeName){
			$newName = strtolower(str_replace(' ','_',$typeName['IncidentType']['name']));
			$$newName .= '</dataset>';
			 
		}   

	
	//Assemble the entire XML now
	$strXML .= $strCategories . $strDataSSI ;
	foreach($incidentType as $typeName){
			$newName = strtolower(str_replace(' ','_',$typeName['IncidentType']['name']));
			$strXML .= $$newName;
			 
	} 
	$strXML .=  '</chart>';
	?>
			<script> var datastring = '<?php echo $strXML; ?>';</script>
			   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "myNext", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
	
  </div> 
  <div class="btns" style="padding-right: 105px;"><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'incedence_report', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></div>         
   