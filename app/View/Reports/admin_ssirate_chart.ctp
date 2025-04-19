<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('SSI Rate', true).' - '.$reportYear; ?></h3>

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
        
        $ssiIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterSsiDateArray) && @in_array($key, $filterSurgicalPerformDateArray)) {
                           $ssiRateVal = ($filterSsiCountArray[$key]/$filterSurgicalPerformCountArray[$key])*100;
                           $arrData[$ssiIndex][2] =  $this->Number->precision($ssiRateVal,2);
          } else {
                           $arrData[$ssiIndex][2] = 0;
          }
          $ssiIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="SSI Rate" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xAxisName="Months" yAxisName="SSI rate"  showValues="0" decimalPrecision="1" numberSuffix="%" yAxisMaxValue="5" >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataSSI = '<dataset  color="AFD8F8">';
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataSSI .= '<set label="' . $arSubData[1] . '" value="' . $arSubData[2] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataSSI .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataSSI . '</chart>';
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "ssiRate", 900, 500);
	
        
   ?>
   <center>
                            <div id="chartContainer">FusionCharts will load here</div>
                           <script type="text/javascript">
                                FusionCharts.setCurrentRenderer('JavaScript');
                                var myChart = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "ssiratechart", "900", "500", "0", "1");
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
   <div class="btns" style="padding-right: 105px;"><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'ssirate', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></div>          
 