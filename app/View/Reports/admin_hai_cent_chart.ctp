<?php 
     App::import('Vendor', 'fusionx_charts'); 
     echo $this->Html->script(array('/fusionx_charts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Hospital Associated Infections Rate', true)." - ".$reportYear; ?></h3>

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
        
        $haiRateIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
                if(empty($filterSsiCountArray[$key])) $filterSsiCountArray[$key] = 0;
                if(empty($filterVapCountArray[$key])) $filterVapCountArray[$key] = 0;
                if(empty($filterUtiCountArray[$key])) $filterUtiCountArray[$key] = 0;
                if(empty($filterBsiCountArray[$key])) $filterBsiCountArray[$key] = 0;
                if(empty($filterThromboCountArray[$key])) $filterThromboCountArray[$key] = 0;
                if(empty($filterOtherCountArray[$key])) $filterOtherCountArray[$key] = 0;                 
                $totalCount = $filterSsiCountArray[$key] + $filterVapCountArray[$key] + $filterUtiCountArray[$key] + $filterBsiCountArray[$key] + $filterThromboCountArray[$key]+$filterOtherCountArray[$key];
                if($filterdischargeDeathCountArray[$key] > 0 && $totalCount > 0) {
                      $totalHaiRate =  ($totalCount/$filterdischargeDeathCountArray[$key])*100; 
                      $arrData[$haiRateIndex][2] = $totalHaiRate;
                } else {
                      $arrData[$haiRateIndex][2] = 0;
                }
          
          $haiRateIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="Hospital Associated Infections Rate" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xAxisName="Months" yAxisName="HAI rate"  showValues="0" decimalPrecision="2" numberSuffix="%"  >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataHai = '<dataset  color="BFD8F8">';
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataHai .= '<set label="' . $arSubData[1] . '" value="' . $arSubData[2] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataHai .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataHai . '</chart>';
	//echo $strXML;exit;
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo renderChart($this->Html->url("/fusionx_charts/Column3D.swf"), "", $strXML, "myNext", 900, 500,false, true);
	
        
   ?>
   <center>
                            <div id="chartContainer">FusionCharts will load here</div>
                           <script type="text/javascript"><!--
                                FusionCharts.setCurrentRenderer('JavaScript');
                                var myChart = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "haicentchart", "900", "500", "0", "1");
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
                       
	
        
 
   <center>
                            <div id="chartContainer"></div>
                           <script type="text/javascript"><!--
                                FusionCharts.setCurrentRenderer('JavaScript');
                                var myChart = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "haicentchart", "900", "500", "0", "1");
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
  <div class="btns" style="padding-right: 105px;"><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'hai_cent', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?></div>      
   