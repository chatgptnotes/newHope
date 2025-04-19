<style> body{ background-color:#DDDDDD;}</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
     <div class="inner_title">
			 <h3><font style="color: #000"> <?php echo __('Growth Chart', true)." for - ".ucwords($diagnosis[0][Patient][lookup_name]); ?></font></h3>
<?php
//debug($diagnosis);
$strXML ='<chart caption="BMI Growth Chart for infants (Girls)" subCaption="0 to 36 Months" canvasBgColor="#DDDDDD" numVDivLines="35" bgAlpha="100" labelStep="90"   connectNullData="1"  yAxisMinValue="40" yAxisValuesStep="" numDivLines="25" drawAnchors="0" xAxisName="AGE(Years)" yAxisName="BMI Value (Kg/m2)" bgColor="#DDDDDD" showBorder="0"   use3DLighting="0" chartRightMargin="40"  showLegend="0" showValues="0" divLineColor="#F90792"   alternateHGridAlpha="20" showAlternateHGridColor="0" showAlternateVGridColor="0"  decimalPrecision="5" baseFontColor="#000" animation="0">';
$strCategories='<categories>';

//$strCategories.='<category label="Birth" value="0"/>';
$j=1;$count=0;$k=0;
for($i=0;$i<=1080;$i++)
{   
	if($k==0)
	{
		$strCategories.='<category label="Birth" value="'.$i.'"/>';
		$k=1;
	}
	else 
	{
	if($count==30)
	{
		$strCategories.='<category label="'.$j.'" value="'.$i.'"/>';
	$j++;
	$count=0;
	//print($i);
	
	}
	else 
	{//print $count;
	$strCategories.='<category   value="'.$i.'"/>';
	
	}
	}
	
	$count++;//exit;
	
}

	//$strData .= '<set label="'. $data[Diagnosis][create_time].'"     value="' . $data[Diagnosis][bmi] . '" />';

$strCategories.='</categories>';
//debug($strCategories);
$strData1='<dataset color="#F90792">';
//debug($percentile3Array);
 
 for($i=0;$i<=1080;$i++)
{
	
		if (array_key_exists($i,$percentile3Array))
		{
		// print($i);
			$strData1.='<set toolText="'.$i.'" value="'.$percentile3Array[$i].'"/>';
			
		}
		else 
		{
			$strData1.='<set toolText="'.$i.'" value=""/>';
		}
	}
	//print($i); echo '<br />';
	
 
$strData1.='</dataset>';
$strData2='<dataset color="#F90792" lineThickness="1">';
for($i=0;$i<=1080;$i++)
{

	if (array_key_exists($i,$percentile5Array))
	{
		// print($i);
		$strData2.='<set toolText="'.$i.'" value="'.$percentile5Array[$i].'"/>';
			
	}
	else
	{
		$strData2.='<set toolText="'.$i.'" value=""/>';
	}
}
$strData2.='</dataset>';
$strData3='<dataset color="#F90792" lineThickness="1">';
for($i=0;$i<=1080;$i++)
{

	if (array_key_exists($i,$percentile10Array))
	{
		// print($i);
		$strData3.='<set toolText="'.$i.'" value="'.$percentile10Array[$i].'"/>';
			
	}
	else
	{
		$strData3.='<set toolText="'.$i.'" value=""/>';
	}
}
$strData3.='</dataset>';
$strData4='<dataset color="#F90792">';
for($i=0;$i<=1080;$i++)
{

	if (array_key_exists($i,$percentile25Array))
	{
		// print($i);
		$strData4.='<set toolText="'.$i.'" value="'.$percentile25Array[$i].'"/>';
			
	}
	else
	{
		$strData4.='<set toolText="'.$i.'" value=""/>';
	}
}
$strData4.='</dataset>';
$strData5='<dataset color="#F90792" lineThickness="1">';
for($i=0;$i<=1080;$i++)
{

	if (array_key_exists($i,$percentile50Array))
	{
		// print($i);
		$strData5.='<set toolText="'.$i.'" value="'.$percentile50Array[$i].'"/>';
			
	}
	else
	{
		$strData5.='<set toolText="'.$i.'" value=""/>';
	}
}
$strData5.='</dataset>';
$strData6='<dataset color="#F90792">';
for($i=0;$i<=1080;$i++)
{

	if (array_key_exists($i,$percentile75Array))
	{
		// print($i);
		if($i==7315)
		{
		$strData6.='<set toolText="'.$i.'" value="'.$percentile75Array[$i].'" displayValue="75 Percentile"/>';
		}
		else {
			$strData6.='<set toolText="'.$i.'" value="'.$percentile75Array[$i].'"/>';
		}
			
	}
	else
	{
		$strData6.='<set toolText="'.$i.'" value=""/>';
	}
}
$strData6.='</dataset>';
/* $strData7='<dataset color="#99004D" lineThickness="1">';
for($i=0;$i<=1095;$i++)
{

	if (array_key_exists($i,$percentile85Array))
	{
		// print($i);
		$strData7.='<set toolText="'.$i.'" value="'.$percentile85Array[$i].'"/>';
			
	}
	else
	{
		$strData7.='<set toolText="'.$i.'" value=""/>';
	}
}
$strData7.='</dataset>'; */
$strData8='<dataset color="#F90792" lineThickness="1">';
for($i=0;$i<=1080;$i++)
{

	if (array_key_exists($i,$percentile90Array))
	{
		// print($i);
		$strData8.='<set toolText="'.$i.'" value="'.$percentile90Array[$i].'"/>';
			
	}
	else
	{
		$strData8.='<set toolText="'.$i.'" value=""/>';
	}
}
$strData8.='</dataset>';
$strData9='<dataset color="#F90792" lineThickness="1">';
for($i=0;$i<=1080;$i++)
{

	if (array_key_exists($i,$percentile95Array))
	{
		// print($i);
		$strData9.='<set toolText="'.$i.'" value="'.$percentile95Array[$i].'"/>';
			
	}
	else
	{
		$strData9.='<set toolText="'.$i.'" value=""/>';
	}
}
$strData9.='</dataset>';
$strData10='<dataset color="#F90792">';
for($i=0;$i<=1080;$i++)
{

	if (array_key_exists($i,$percentile97Array))
	{
		// print($i);
		$strData10.='<set toolText="'.$i.'" value="'.$percentile97Array[$i].'"/>';
			
	}
	else
	{
		$strData10.='<set toolText="'.$i.'" value=""/>';
	}
}
$strData10.='</dataset>';
$strPlot='<dataset color="#83898C" drawAnchors="1" anchorRadius="4">';
//$datearray=array('730'=>'15.09033','1110'=>'15.26016','1475'=>'16.4397','1840'=>'14.1378','2205'=>'17.01418','2570'=>'18.02183','2935'=>'13.79575','3665'=>'14.6426','4030'=>'17.20089','4547'=>'20.0017');
$max=max(array_keys($bmi_array));
for($i=0;$i<=$max;$i++)
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
