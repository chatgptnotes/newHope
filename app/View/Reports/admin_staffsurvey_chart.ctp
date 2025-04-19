<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Staff Survey Report', true)." - ".$reportYear; ?></h3>
</div>
<div class="clr ht5"></div>
 <div>
    <?php
	//$graph= new FusionCharts();
        $monthIndex = 0;
        foreach($yaxisArray as $yaxisArrayVal) {
              $arrData[$monthIndex][1]  = $yaxisArrayVal;
              $monthIndex++;
        }
        
        $yesCountIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterYesAnsDateArray)) {
                           $arrData[$yesCountIndex][2] = $filterYesAnsCountArray[$key];
          } else {
                           $arrData[$yesCountIndex][2] = 0;
          }
          $yesCountIndex++;
        }

        $noCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterNoAnsDateArray)) {
                           $arrData[$noCountIndex][3] = $filterNoAnsCountArray[$key];
          } else {
                           $arrData[$noCountIndex][3] = 0;
          }
          $noCountIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="Staff Survey Report" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xAxisName="Months" yAxisName="Count"  decimalPrecision="0" yAxisMaxValue="5">';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataYesCount = '<dataset seriesName="Yes Count" color="AFD8F8">';
	$strDataNoCount = '<dataset seriesName="No Count" color="F6BD0F">';
	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataYesCount .= '<set value="' . $arSubData[2] . '" />';
        $strDataNoCount .= '<set value="' . $arSubData[3] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataYesCount .= '</dataset>';
        $strDataNoCount .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataYesCount . $strDataNoCount . '</chart>';
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
	
        
   ?>
    <center>
                            <div id="chartContainer">FusionCharts will load here</div>
                           <script type="text/javascript"><!--
                                FusionCharts.setCurrentRenderer('JavaScript');
                                var myChart = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "staffsurveychart", "900", "500", "0", "1");
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
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'staffsurvey_reports', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>