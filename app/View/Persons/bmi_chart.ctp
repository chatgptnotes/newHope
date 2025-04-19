<style>
body {
	background-color: #1B1B1B;
}
element.style {
    background-color: none;
    }
</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
	<h3>
		<font style="color:#fff"><?php echo __('BMI Chart', true)." For - ".$diagnosis[0]['Patient']['lookup_name'];?></font>
	</h3>
</div>
<center>
	<div class="clr ht5" id="multiaxischartdiv4"></div>
</center>
<div>
	<?php 
	//debug($diagnosis);
	$strXML = '<chart caption="BMI chart"  xaxisname="Noted On" lineColor ="#000000"  numDivLines="30" rotateLabels="1"  BgColor="#1B1B1B" borderColor="1B1B1B" borderAlpha="100"  bgAlpha="100" toolTipBgColor="1B1B1B" baseFontColor="#fff" numVDivLines="30" adjustDiv="0" yaxisname="BMI value"  showValues="0" decimalPrecision="0" labelDisplay="WRAP" numberSuffix="" yAxisMaxValue="55" showAlternateVGridColor="1" divLineColor="#515D6A" vDivLineColor="#515D6A" yAxisValuesStep="2"  anchorRadius="4"   >';
	$strCategories = '<categories>';
	$strData='<dataset color="AFD8F8">';
	foreach ($diagnosis as $data) 
		{
			//echo $data['Diagnosis']['create_time'];
			$date=$this->DateFormat->formatDate2Local($data['Diagnosis']['create_time'],Configure::read('date_format'),false);
			//echo $date;
			$strCategories.='<category name="' . $date. '" />';
			$strData .= '<set label="'. $date.'" value="' . $data['Diagnosis']['bmi'] . '" />';
		}
		$strCategories .= '</categories>';
		$strData .= '</dataset>';
		$strData.='<trendlines>';
		$strData.='<line startValue="0" endValue="14.9" isTrendZone="1" placeValuesInside="1" alpha="30" color="#0AB6DE"  displayValue=" Very severely underweight" showOnTop="0" valueOnRight="1"/>';
		$strData.='<line startValue="14.9" endValue="16" isTrendZone="1" alpha="50" color="#4485F6" displayValue="Severely underweight" showOnTop="0" valueOnRight="1"/>';
		$strData.='<line startValue="16" endValue="18.5" isTrendZone="1" alpha="80" color="#7575FF" displayValue="underweight" showOnTop="0" valueOnRight="1"/>';
		$strData.='<line startValue="18.5" endValue="19.9" isTrendZone="1" alpha="75" color="#9DD49B" displayValue=" lean" showOnTop="0" valueOnRight="1"/>';
		$strData.='<line startValue="19.9" endValue="25" isTrendZone="1" alpha="45" color="#0EE913" displayValue="normal" showOnTop="0" valueOnRight="1"/>';
		$strData.='<line startValue="25" endValue="30" isTrendZone="1" alpha="55" color="#F9CB13" displayValue=" overweight" showOnTop="0" valueOnRight="1"/>';
		$strData.='<line startValue="30" endValue="35" isTrendZone="1" alpha="20" color="#F9CB13" displayValue="obese(Class I)" showOnTop="0" valueOnRight="1"/>';
		$strData.='<line startValue="35" endValue="40" isTrendZone="1" alpha="40" color="#FF5A0E" displayValue="morbidly obese(Class II)" showOnTop="0" valueOnRight="1"/>';
		$strData.='<line startValue="40" endValue="55" isTrendZone="1" alpha="60" placeValuesInside="1" color="#FF5A0E" displayValue="extremely obese(Class III)" showOnTop="0" valueOnRight="1"/>';
		$strData.='</trendlines>';
		$strXML .= $strCategories . $strData . '</chart>';
	?>
	<script>
   var datastring='<?php echo $strXML; ?>'</script>
	<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/Line.swf", "multiaxisChartId4", "700px", "85%", "0", "0", "datastring", "multiaxischartdiv4"); ?>
</div>