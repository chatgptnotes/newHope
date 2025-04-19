<style>
body{
background-color:#DDDDDD;
}
</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', '/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
	<h3><font style="color:#000">
		<?php echo __('Blood Pressure Chart', true)." For - ".$patient; ?>
	</font></h3>
</div>
<?php  if($temp_datas) {?>
<div id="multiaxischartdiv4" align="center">FusionCharts</div>

<div>
	<?php
	//Initialize <graph> element
	$strXML ='<chart caption="Blood Pressure" legendBgColor="DDDDDD" canvasBgColor="DDDDDD" bgColor="DDDDDD" baseFontColor="000000" toolTipBgColor="DDDDDD" showBorder="0" borderColor="1B1B1B" bgAlpha="100" xaxisname="Noted On" rotateLabels="1" showValues="0" decimalPrecision="0"    anchorRadius="4"  yAxisMaxValue="5"  labelDisplay="WRAP" >';

	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataSSI ='<axis  title="Systolic (mm/hg.)" Pos="left" tickWidth="10" divlineisdashed="1" color="4285F4"  >';
	$strDataSSI .= '<dataset seriesName="Systolic (mm/hg.)" lineThickness="3" anchorBgColor="#4285F4">';
	$strDataSSI2 ='<axis  title="Diastolic (mm/hg.)" Pos="right" axisOnLeft="0" tickWidth="10" divlineisdashed="1" >';
	$strDataSSI2 .= '<dataset seriesName="Diastolic (mm/hg.)" lineThickness="3" anchorBgColor="#F6BD0F" >';
	//Iterate through the data

	foreach ($temp_datas as $key=>$arSubData)
	{
		$date1=date('m/d/Y H:i',strtotime($this->DateFormat->formatDate2Local($key,Configure::read('date_format'),true)));
		$strCategories .= '<category label="' . $date1.' " />';
		//Add <set value='...' /> to both the datasets

		$strDataSSI .= '<set toolText="Systolic '.$arSubData['systolic'].' mmHg {br}'.$date1.'" value="' . $arSubData['systolic'] . '" />';
	}

	foreach ($temp_datas as $key=>$arSubData)
	{
		$date1=$this->DateFormat->formatDate2Local($key,Configure::read('date_format'),true);
		$strDataSSI2 .= '<set toolText="Diastolic '.$arSubData['diastolic'].' mmHg {br}'.$date1.'" value="' . $arSubData['diastolic'] . '" />';
	}
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
	$strDataSSI .= '</dataset>';
	$strDataSSI.='</axis>';
	$strDataSSI2 .= '</dataset>';
	$strDataSSI2.='</axis>';

	//Assemble the entire XML now
	$strXML .= $strCategories . $strDataSSI . $strDataSSI2 . '</chart>';
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSLine.swf"), "", $strXML, "ssiRate", 900, 500);

	?>
	<script>
   var datastring = '<?php echo $strXML; ?>';
</script>

	<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId4", "98%", "90%", "0", "0", "datastring", "multiaxischartdiv4"); ?>
</div>
<?php } 
else {?>
<div align="center"><font style="color:#fff"><?php echo "No Records Found";?></font></div>
<?php }?>
