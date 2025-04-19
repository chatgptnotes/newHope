<style>
body {
	background-color: #DDDDDD;
}
</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
	<h3>
		<font style="color: #000"> <?php  echo __('Growth Chart', true)." for - ".ucwords($patient_name); ?>
		</font>
	</h3>
	<?php
	//debug($diagnosis);
	$strXML ='<chart caption="Weight for Length Chart for Females" subCaption="0 to 36 Months" labelStep="30" anchorBgColor="#000" canvasBgColor="#DDDDDD" numVDivLines="60" bgAlpha="100" adjustDiv="1"   connectNullData="1"  yAxisMinValue="0" yAxisValuesStep="" numDivLines="35" drawAnchors="0" toolTipBgColor="DDDDDD" xAxisName="Length(Cm)" yAxisName="Weight (Kg)" bgColor="#DDDDDD" showBorder="0"   use3DLighting="0" chartRightMargin="40"  showLegend="0" showValues="0" divLineColor="#F90792" yAxisMaxValue="25"  alternateHGridAlpha="20" showAlternateHGridColor="0" showAlternateVGridColor="0"  decimalPrecision="5" baseFontColor="#000" animation="0">';
	$strCategories='<categories>';
	
	$j=45;$count=10;
	for($i=450;$i<=1050;$i++)
	{
		if($count==10)
		{
			$strCategories.='<category label="'.$j.'" value="'.$i.'"/>';
			$j++;
			$count=0;
		}
		else {//print $count;
			$strCategories.='<category   value="'.$i.'"/>';

		}

		$count++;//exit;

	}

	//$strData .= '<set label="'. $data[Diagnosis][create_time].'"     value="' . $data[Diagnosis][bmi] . '" />';

	$strCategories.='</categories>';
	//debug($strCategories);
	$strData1='<dataset color="#F90792">';
	//debug($percentile3Array);

	for($i=450;$i<=1050;$i++)
	{

		if (array_key_exists($i,$percentile3Array))
		{
			// print($i);
			$strData1.='<set  value="'.$percentile3Array[$i].'"/>';

		}
		else
		{
			$strData1.='<set  value=""/>';
		}
	}
	//print($i); echo '<br />';


	$strData1.='</dataset>'; 
	$strData2='<dataset color="#F90792" lineThickness="1">';
	for($i=450;$i<=1050;$i++)
	{

		if (array_key_exists($i,$percentile5Array))
		{
			// print($i);
			$strData2.='<set  value="'.$percentile5Array[$i].'"/>';

		}
		else
		{
			$strData2.='<set  value=""/>';
		}
	}
	$strData2.='</dataset>';
	$strData3='<dataset color="#F90792" lineThickness="1">';
	for($i=450;$i<=1050;$i++)
	{

		if (array_key_exists($i,$percentile10Array))
		{
			// print($i);
			$strData3.='<set  value="'.$percentile10Array[$i].'"/>';

		}
		else
		{
			$strData3.='<set  value=""/>';
		}
	}
	$strData3.='</dataset>';
	$strData4='<dataset color="#F90792">';
	for($i=450;$i<=1050;$i++)
	{

		if (array_key_exists($i,$percentile25Array))
		{
			// print($i);
			$strData4.='<set  value="'.$percentile25Array[$i].'"/>';

		}
		else
		{
			$strData4.='<set  value=""/>';
		}
	}
	$strData4.='</dataset>';
	$strData5='<dataset color="#F90792" lineThickness="1">';
	for($i=450;$i<=1050;$i++)
	{

		if (array_key_exists($i,$percentile50Array))
		{
			// print($i);
			$strData5.='<set  value="'.$percentile50Array[$i].'"/>';

		}
		else
		{
			$strData5.='<set  value=""/>';
		}
	}
	$strData5.='</dataset>';
	$strData6='<dataset color="#F90792">';
	for($i=450;$i<=1050;$i++)
	{

		if (array_key_exists($i,$percentile75Array))
		{
			// print($i);
			
				$strData6.='<set  value="'.$percentile75Array[$i].'" displayValue="75 Percentile"/>';
			
		}
		else
		{
			$strData6.='<set  value=""/>';
		}
	}
	$strData6.='</dataset>';
	/* $strData7='<dataset color="#99004D" lineThickness="1">';
	for($i=730;$i<=7300;$i++)
	{

		if (array_key_exists($i,$percentile85Array))
		{
			// print($i);
			$strData7.='<set  value="'.$percentile85Array[$i].'"/>';

		}
		else
		{
			$strData7.='<set  value=""/>';
		}
	}
	$strData7.='</dataset>'; */
	$strData8='<dataset color="#F90792">';
	for($i=450;$i<=1050;$i++)
	{

		if (array_key_exists($i,$percentile90Array))
		{
			// print($i);
			$strData8.='<set  value="'.$percentile90Array[$i].'"/>';

		}
		else
		{
			$strData8.='<set  value=""/>';
		}
	}
	$strData8.='</dataset>';
	$strData9='<dataset color="#F90792">';
	for($i=450;$i<=1050;$i++)
	{

		if (array_key_exists($i,$percentile95Array))
		{
			// print($i);
			$strData9.='<set  value="'.$percentile95Array[$i].'"/>';

		}
		else
		{
			$strData9.='<set  value=""/>';
		}
	}
	$strData9.='</dataset>';
	$strData10='<dataset color="#F90792">';
	for($i=450;$i<=1050;$i++)
	{

		if (array_key_exists($i,$percentile97Array))
		{
			// print($i);
			$strData10.='<set  value="'.$percentile97Array[$i].'"/>';

		}
		else
		{
			$strData10.='<set  value=""/>';
		}
	}
	$strData10.='</dataset>';
	$strPlot='<dataset color="#83898C" drawAnchors="1" anchorRadius="4">';
	//$datearray=array('730'=>'15.09033','1110'=>'15.26016','1475'=>'16.4397','1840'=>'14.1378','2205'=>'17.01418','2570'=>'18.02183','2935'=>'13.79575','3665'=>'14.6426','4030'=>'17.20089','4547'=>'20.0017');
	//debug($bmi_array);
	$max=max(array_keys($bmi_array));
	
for($i=450;$i<=$max;$i++)
	{
	if(array_key_exists($i,$bmi_array))
		{
			foreach($bmi_array as $key=>$value)
			{
				foreach($value as $bmi)
				{
					$strPlot.='<set toolText="height:'.$height[$i].' cm {br}Weight:'.$bmi.' Kg{br} AGE:'.$year[$i].".".$month[$i].' Years {br}Noted On:'.date('m/d/Y',strtotime($date[$i])).'" value="'.$bmi.'"/>';
				}
			}
		}
		else
		{
		$strPlot.='<set value=""/>';
		}
	}
	$strPlot.='</dataset>';

	//debug($bmi_array);
	$strXML.=$strCategories.$strData1.$strData2.$strData3.$strData4.$strData5.$strData6.$strData8.$strData9.$strData10.$strPlot. '</chart>';
	//debug($strXML);
	?>
	<script>
  var datastring = '<?php echo $strXML; ?>';
  </script>


	<center>
		<div id="chartContainer">FusionCharts will load here</div>
		<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MSSpline.swf", "multiaxisChartId4", "600px", "750px", "0", "0", "datastring", "chartContainer"); ?>
	</center>
</div>
