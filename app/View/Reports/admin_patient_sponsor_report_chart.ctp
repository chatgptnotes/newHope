<?php 
     App::import('Vendor', 'fusionx_charts'); 
     echo $this->Html->script(array('/fusionx_charts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Patient Empanelment Report', true).' - '.$reportYear; ?></h3>
</div>
<div class="clr ht5"></div>
 <div>
    <?php
	//$graph= new FusionCharts();
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

	 
	   //Initialize <graph> element
	if($payment_category == 'cash'){
		$payment_category = 'SELF PAY';
		//$title = "TOTAL ENPANELMENT(Type:'".$payment_category.")";
	} else {
		$payment_category = 'CARD';
	}
	$strXML = '<chart caption="TOTAL EMPANELMENT CHART" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xAxisName="Months" yAxisName="Count"  decimalPrecision="2" yAxisMaxValue="5">';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataHAI = '<dataset  color="AFD8F8">';
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataHAI .= '<set value="' . $arSubData[2] . '" />';
     }
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
    $strDataHAI .= '</dataset>';
    //Assemble the entire XML now
	$strXML .= $strCategories . $strDataHAI . '</chart>';
	
 
  
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
        
   ?>
   <center>
                            <div id="chartContainer">FusionCharts will load here</div>
                           <script type="text/javascript"><!--
                                FusionCharts.setCurrentRenderer('JavaScript');
                                var myChart = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "patientsponsorchart", "900", "500", "0", "1");
                                var datastring = '<?php echo $strXML; ?>';
                                myChart.setXMLData(datastring);
                                myChart.render( "chartContainer" );
								
								myChart.addEventListener( "nodatatodisplay", function() { 
									if ( window.windowIsReady ){
										notifyLocalAJAXSecurityRestriction(); 
									}else
									{
										$(document).ready (function(){
											notifyLocalAJAXSecurityRestriction();
										});
									}
									
								});
								
                                // -->
                            </script>
                        </center> 
  </div>          
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'patient_sponsor_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>