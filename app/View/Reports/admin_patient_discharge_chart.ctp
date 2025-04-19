<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Total Discharge Report', true).' - '.$reportYear; ?></h3>
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
        
        $recoverCountIndex=0;
	foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterRecoverDateArray)) {
                           $arrData[$recoverCountIndex][2] = $filterRecoverCountArray[$key];
          } else {
                           $arrData[$recoverCountIndex][2] = 0;
          }
          $recoverCountIndex++;
        }

        $damaCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterDamaDateArray)) {
                           $arrData[$damaCountIndex][3] = $filterDamaCountArray[$key];
          } else {
                           $arrData[$damaCountIndex][3] = 0;
          }
          $damaCountIndex++;
        }
	
        $deathCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          if(@in_array($key, $filterDeathDateArray)) {
                           $arrData[$deathCountIndex][4] = $filterDeathCountArray[$key];
          } else {
                           $arrData[$deathCountIndex][4] = 0;
          }
          $deathCountIndex++;
        }
        //Initialize <graph> element
	$strXML = '<chart caption="Patient Discharge Report" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xaxisname="Months" yaxisname="Patient Discharge Count"  showValues="0" decimalPrecision="0"  yAxisMaxValue="5" >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataRecoverCount = '<dataset seriesName="Recover Count" color="AFD8F8">';
	$strDataDamaCount = '<dataset seriesName="DAMA Count" color="F6BD0F">';
        $strDataDeathCount = '<dataset seriesName="Death Count" color="FF66CC">';

	//Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] .'" />';
		//Add <set value='...' /> to both the datasets
        $strDataRecoverCount .= '<set value="' . $arSubData[2] . '" />';
        $strDataDamaCount .= '<set value="' . $arSubData[3] . '" />';
        $strDataDeathCount .= '<set value="' . $arSubData[4] .'" />';
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataRecoverCount .= '</dataset>';
        $strDataDamaCount .= '</dataset>';
        $strDataDeathCount .= '</dataset>';
        //Assemble the entire XML now
	$strXML .= $strCategories . $strDataRecoverCount . $strDataDamaCount . $strDataDeathCount . '</chart>';
	?>
		<script> var datastring = '<?php echo $strXML; ?>';</script>
		   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "patientDischarge", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
		   </div>          
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'patient_discharge_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>