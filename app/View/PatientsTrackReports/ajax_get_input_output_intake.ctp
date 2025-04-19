    <?php 
     //  echo $this->Html->script(array('/fusionx_data/String/js/StCol3DSingleLine1')); 
     if(count($allSubCategories) > 0) {
     $strXML = '<chart showValues="0" caption="Input/Output Intake"  xAxisName="Days" yAxisName="Intake" plotSpacePercent="" formatNumberScale="0" showLegend="1" legendPosition="RIGHT" legendBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff"  canvasbgColor="1B1B1B" showAlternateHGridColor="0" toolTipBgColor="1B1B1B" plotGradientColor="">';
	 $strCategories = '<categories>';
	 $strCategories .= '<category label="Day 1"/>';
	 $strCategories .= '<category label="Day 2"/>';
	 $strCategories .= '<category label="Day 3"/>';
	 $strCategories .= '</categories>';
	    
        foreach($allSubCategories as $allSubCategoriesVal) {
             // for continuous infusion color code //
        	 if($allSubCategoriesVal['ReviewSubCategory']['id'] == "5") {
        	 	$color= 'color="#6A83D2"';
        	 }
        	 // for medication color code //
	         if($allSubCategoriesVal['ReviewSubCategory']['id'] == "6") {
	        	 	$color= 'color="#8CE283"';
	         }
	         // for Oral Intake color code //
	         if($allSubCategoriesVal['ReviewSubCategory']['id'] == "10") {
	        	 	$color= 'color="#DB6EA0"';
	         }
	         // for GI intake color code //
	         if($allSubCategoriesVal['ReviewSubCategory']['id'] == "12") {
	        	 	$color= 'color="#C1DB71"';
	         }
	         // for Tube Feeding color code //
	         if($allSubCategoriesVal['ReviewSubCategory']['id'] == "13") {
	        	 	$color= 'color="#A07D5C"';
	         }
	         // for urine color code //
	         if($allSubCategoriesVal['ReviewSubCategory']['id'] == "7") {
	        	 	$color= 'color="#E5DD7C"';
	         }
	         // for GI output color code //
	         if($allSubCategoriesVal['ReviewSubCategory']['id'] == "16") {
	        	 	$color= 'color="#6A789B"';
	         }
             $strDataset .=	'<dataset seriesName="'.$allSubCategoriesVal['ReviewSubCategory']['name'].'" '.$color.' >';
             if(strtolower($allSubCategoriesVal['ReviewSubCategory']['parameter']) == "intake") {
             $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d')].'" />';	
           	 $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day'))].'" />';	
           	 $strDataset .=	'<set value="'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime(date('Y-m-d'). ' - 2 day'))].'" />';
             }
             if(strtolower($allSubCategoriesVal['ReviewSubCategory']['parameter']) == "output") {
             $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d')].'" />';	
           	 $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day'))].'" />';	
           	 $strDataset .=	'<set value="-'.$allIntakeOutputStack[$allSubCategoriesVal['ReviewSubCategory']['id']][date('Y-m-d', strtotime(date('Y-m-d'). ' - 2 day'))].'" />';
             }	
           	 $strDataset .= '</dataset>';
        }
        
           	 	
        
        $strDataset .= '<dataset seriesName="Mean Line" renderAs="Line" >';
        $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['intake'][date('Y-m-d')]-$getStackMeanIntakeOutput['output'][date('Y-m-d')]).'" />';	
        $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['intake'][date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day'))]-$getStackMeanIntakeOutput['output'][date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day'))]).'" />';	
        $strDataset .=	'<set value="'.($getStackMeanIntakeOutput['intake'][date('Y-m-d', strtotime(date('Y-m-d'). ' - 2 day'))]-$getStackMeanIntakeOutput['output'][date('Y-m-d', strtotime(date('Y-m-d'). ' - 2 day'))]).'" />';
        $strDataset .= '</dataset>';
        
        $strXML .= $strCategories . $strDataset . "</chart>";
                             
 ?>
 <script>
  var dataString = '<?php echo $strXML; ?>';
 </script>
<div id="inputoutputchartdiv" align="center">Chart will load here</div>
	<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/StackedColumn2DLine.swf", "inputoutputChartId", "200%", "300", "0", "0", 'dataString', 'inputoutputchartdiv'); ?>
<?php 
} else {
   echo __('No Data Found.');
}
?>