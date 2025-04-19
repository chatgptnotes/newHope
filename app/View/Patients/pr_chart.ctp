<style>
body{
background-color:#DDDDDD;
}
</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">

	<h3><font style="color:#000">
		<?php echo __('Pulse Rate Chart', true)." For - ".$patient;?>
	</font></h3>
</div>
<?php  if($temp_datas) {?>
<center>
	<div class="clr ht5" id="multiaxischartdiv4"></div>
</center>
<div>
	<?php
	
	//Initialize <graph> element
	$strXML = '<chart caption="Pulse Rate" legendBgColor="#DDDDDD" canvasBgColor="#FFFFFF" bgColor="##FFFFFF" baseFontColor="#000000" toolTipBgColor="#DDDDDD" showBorder="0" borderColor="1B1B1B" bgAlpha="100" alternateHGridColor="#DDDDD" divLineColor="#4285F4" divLineAlpha="80"  divLineIsDashed="1" divLineThickness="1" xaxisname="Noted On" rotateLabels="1"  lineColor ="#4285F4"  anchorBgColor="#000"  anchorRadius="4"  adjustDiv="0" yaxisname="Pulse Rate (bpm)"  showValues="0" decimalPrecision="0" labelDisplay="WRAP"  yAxisMaxValue="5"  >';

	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataSSI = '<dataset  color="AFD8F8">';
	//Iterate through the data
	foreach ($temp_datas as $key=>$arSubData) {
		//echo"<pre>";print_r($arSubData[create_time]);
		//$arSubData[create_time_explode] = explode(' ',$arSubData[create_time]);
		//echo"<pre>";print_r($arSubData[create_time_explode]);exit;
		//Append <category name='...' /> to strCategories
		$date1=date('m/d/Y H:i',strtotime($this->DateFormat->formatDate2Local($key,Configure::read('date_format'),true)));
		$strCategories .= '<category name="' . $date1. '" />';
		//Add <set value='...' /> to both the datasets

		$strDataSSI .= '<set toolText="'.$arSubData.' bpm {br}'.$date1.'" label="' . $date1. '" value="' . $arSubData . '" />';
	}//echo"<pre>";print_r($arSubData);exit;

	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
	$strDataSSI .= '</dataset>';
	//Assemble the entire XML now
	$strXML .= $strCategories . $strDataSSI . '</chart>';


	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSLine.swf"), "", $strXML, "ssiRate", 900, 500);
	?>
	<script>
   var datastring='<?php echo $strXML; ?>'</script>
	<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/Line.swf", "multiaxisChartId4", "98%", "90%", "0", "0", "datastring", "multiaxischartdiv4"); ?>
</div>
<?php } 
else {?>
<div align="center"><?php echo "No Records Found";?></div>
<?php }?>