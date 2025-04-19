<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Surgical Site Infections Rate', true).' - '.$reportYear; ?></h3>
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
        
        $ssiIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterSsiDateArray) && @in_array($key, $filterSpDateArray)) {
                           $ssiRateVal = ($filterSsiCountArray[$key]/$filterSpCountArray[$key])*100;
                           $arrData[$ssiIndex][2] = $ssiRateVal;
          } else {
                           $arrData[$ssiIndex][2] = 0;
          }
          $ssiIndex++;
        }
	
        //Initialize <graph> element
	$strXML = '<chart caption="Surgical Site Infections Rate" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xAxisName="Months" yAxisName="SSI rate" numberSuffix="%" showValues="0"  decimalPrecision="0" yAxisMaxValue="5">';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataSsi = '<dataset  color="AFD8F8">';
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataSsi .= '<set value="' . $arSubData[2] . '" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataSsi .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataSsi . '</chart>';
	
   //Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 900, 500);
        
   ?>
   <center>
                            <div id="chartContainer">FusionCharts will load here</div>
                           <script type="text/javascript"><!--
                                FusionCharts.setCurrentRenderer('JavaScript');
                                var myChart = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "surgicalsiteinfectionschart", "900", "500", "0", "1");
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
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'surgical_site_infections', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>