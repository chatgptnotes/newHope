<style>
body{
background-color:#DDDDDD;
}
</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>

<div class="inner_title">

	<h3><font style="color:#000">		<?php //debug($patient);
		echo __('Temperature Chart', true)." For - ".$patient;?>
	</font></h3>
</div>
<?php if($temp_datas) 
{?>
<center>
	<div class="clr ht5" id="multiaxischartdiv4"></div>
</center>
<div>

	<?php
	//Initialize <graph> element
	$strXML = '<chart caption="Temperature" legendBgColor="#DDDDDD" anchorBgColor="#000"  anchorRadius="4" canvasBgColor="#FFFFFF" bgColor="##FFFFFF" baseFontColor="#000000" toolTipBgColor="#DDDDDD" showBorder="0" borderColor="1B1B1B" bgAlpha="100" alternateHGridColor="#DDDDD" divLineColor="#4285F4" divLineAlpha="80"  divLineIsDashed="1" divLineThickness="1" xaxisname="Noted On" rotateLabels="1"  lineColor ="#4285F4"    adjustDiv="0" yaxisname="Temperature (DegC)"  showValues="0" decimalPrecision="0" labelDisplay="WRAP"  yAxisMaxValue="5"  >';

	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataSSI = '<dataset  color="#AFD8F8">';
	//Iterate through the data

	foreach ($temp_datas as $key=>$temp) {
		//Append <category name='...' /> to strCategories
		$date=date('m/d/Y H:i',strtotime($this->DateFormat->formatDate2LocalForReport($key,Configure::read('date_format'),true)));
		$strCategories .= '<category name="' . $date. '" />';
		//Add <set value='...' /> to both the datasets
		
		$strDataSSI .= '<set toolText="'.$temp.' DegC {br}'.$date.'" label="' . $date.' " value="' . $temp . '" />';
	}//echo"<pre>";print_r($arSubData);exit;

	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
	$strDataSSI .= '</dataset>';
	//Assemble the entire XML now
	$strXML .= $strCategories . $strDataSSI . '</chart>';
	?>
	<script>
   var datastring='<?php echo $strXML; ?>'</script>
	<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/Line.swf", "multiaxisChartId4", "98%", "90%", "0", "0", "datastring", "multiaxischartdiv4");?>
</div>
<?php 
}
else {?>
<div align="center"><?php echo "No Records Found";?></div>
<?php }?>
