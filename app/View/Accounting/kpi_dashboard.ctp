<style>
#multiaxischartdiv1, #multiaxischartdiv2, #multiaxischartdiv3, #pieChartIdDiv4, #pieChartIdDiv5
{
background-color:#1B1B1B;
}
</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>

	<div class="inner_title"><h3><font style="color:#fff"><?php echo __('KPI Dashboard', true);?> </font></h3>
	<!-- chart -->
	</div>
<table cellpadding="0" cellspacing="0" align="center">
	<tr>
	<td style="margin-top:-1" >
			<div id="ChartId3">
				<?php

				$strXML = '<chart caption="Monthly Patient Visits" subCaption=" For Year - '.$reportYear.' " connectNullData="1"  xaxisname="Months" yAxisName="Patients" legendBgColor="1B1B1B" canvasBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff" toolTipBgColor="1B1B1B" showBorder="0" borderColor="1B1B1B" bgAlpha="100"   showValues="0" decimalPrecision="1" labelDisplay="WRAP"  anchorRadius="4" showAlternateHGridColor="0" divLineColor="#AFD8F8" divLineThickness="1" divLineIsDashed="1" divLineAlpha="70" >';
				$strXML .= '<categories>';
				foreach($yaxis as $month)
				{
					$strXML .='<category name="'.$month.'"/>';
				}
				$strXML .='</categories>';
				$strXML.='<dataset seriesName="Established Patients" color="#7FD73B">';

				foreach($exist as $key=>$data)
				{

					foreach($yaxis as $key=> $value)
					{
						$split=explode("-",$key);
						if(array_key_exists($split[0],$data))
						{

							$strXML.='<set value="'.$data[$split[0]].'"/>';
						}
						else
						{
							$strXML.='<set value=" "/>';
						}
					}

				}
				$strXML.='</dataset>';
				$strXML.='<dataset seriesName="New Patient" color="#E1CD33">';
				foreach($new as $key=>$data)
				{

					foreach($yaxis as $key=> $value)
					{
						$split=explode("-",$key);
						if(array_key_exists($split[0],$data))
						{

							$strXML.='<set value="'.$data[$split[0]].'"/>';
						}
						else
						{
							$strXML.='<set value=" "/>';
						}
					}

				}
				$strXML.='</dataset>';
				$strXML .= '</chart>';
					
				?>
				<script> 
		 var datastring = '<?php echo $strXML; ?>';
	  </script>
				<div id="multiaxischartdiv3" ></div>
				<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/MSLine.swf", "multiaxisChartId3", "40%", "300", "0", "0", "datastring", "multiaxischartdiv3"); ?>
			</div>
		</td>
		<td> 
			<div id="chartID1">
			<?php 
					$strRevenue='<chart caption="Revenue Collected" subCaption="'.date("F").'" lowerLimit="0" upperLimit="50000" tickValueStep="1" showLimits="1" formatNumberScale="1" majorTMNumber="12" minorTMNumber="5" autoAlignTickValues="1"  placeValuesInside="1" showBorder="0"  majorTMAlpha="100" majorTMHeight="10" tickValueDistance="10" gaugeOuterRadius="140" gaugeInnerRadius="85%" showValue="1" gaugeStartAngle="225" gaugeEndAngle="-45" manageResize="1" bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#FFF" toolTipBgColor="#1B1B1B">';
$strRevenue.='<colorRange>';
$strRevenue.='<color minValue="0" maxValue="25000" code="FF654F"/>';
$strRevenue.='<color minValue="25100" maxValue="35500" code="F6BD0F"/>';
$strRevenue.='<color minValue="35600" maxValue="50000" code="8BBA00"/>';
$strRevenue.='</colorRange>';
$strRevenue.='<dials>';
$strRevenue.='<dial value="'.$mDial.'"/>';
$strRevenue.='</dials>';
$strRevenue.='</chart>';
                 
        ?>
					<script>
  var datastring = '<?php echo $strRevenue; ?>';
 </script>
			</div>
			<div id="multiaxischartdiv1"></div>
			<?php echo $this->JsFusionChart->showFusionChart("fusionwx_charts/AngularGauge.swf", "multiaxisChartId1", "22%", "300", "0", "0", "datastring", "multiaxischartdiv1"); ?>
		</td>
		<td>
			<div id="chartID2">
			<?php 
					$strRevenueYear='<chart caption="Revenue Collected" subCaption="'.date("Y").'"  lowerLimit="0" upperLimit="6000000" tickValueStep="1" showLimits="1" formatNumberScale="1" majorTMNumber="12" minorTMNumber="5" autoAlignTickValues="1"  placeValuesInside="1" showBorder="0"  majorTMAlpha="100" majorTMHeight="10" tickValueDistance="10" gaugeOuterRadius="140" gaugeInnerRadius="85%" showValue="1" gaugeStartAngle="225" gaugeEndAngle="-45" manageResize="1" bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#FFF" toolTipBgColor="#1B1B1B">';
$strRevenueYear.='<colorRange>';
$strRevenueYear.='<color minValue="0" maxValue="3000000" code="FF654F"/>';
$strRevenueYear.='<color minValue="3510000" maxValue="4550000" code="F6BD0F"/>';
$strRevenueYear.='<color minValue="4560000" maxValue="6000000" code="8BBA00"/>';
$strRevenueYear.='</colorRange>';
$strRevenueYear.='<dials>';
$strRevenueYear.='<dial value="'.$yDial.'"/>';
$strRevenueYear.='</dials>';
$strRevenueYear.='</chart>';
                 
        ?>
					<script>
  var datastring = '<?php echo $strRevenueYear; ?>';
 </script>
			</div>
			<div id="multiaxischartdiv2" ></div>
			<?php echo $this->JsFusionChart->showFusionChart("fusionwx_charts/AngularGauge.swf", "multiaxisChartId2", "20%", "300", "0", "0", "datastring", "multiaxischartdiv2"); ?>
		</td>
	</tr>
	<tr><td colspan="3" width="100%">&nbsp; </td> </tr>
	<tr><td colspan="3" width="100%">&nbsp; </td> </tr>
	<tr>
			<td>
			<div id="ChartId4" align="center">
			<?php 
$strDiagnosis='<chart showvalues="1" caption="Most Common Diagnosis" captionPadding="20"  showlegend="1" enablesmartlabels="1" showlabels="0" showpercentvalues="0" bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#fff" legendBgColor="#1B1B1B" toolTipBgColor="#1B1B1B" legendBgAlpha="100" showBorder="0" minimiseWrappingInLegend ="1" legendPosition="RIGHT">';
/*foreach($commonDiagnosis as $common)
{
   $strDiagnosis.='<set value="'.$common[0]['recordcount'].'" label="'.$common['NoteDiagnosis']['diagnoses_name'].'"/>';
}
$strDiagnosis.='<set value="'.$other.'" label="Others"/>';*/
//hardcoded for demo purpose only--Pooja
$strDiagnosis.='<set value="20" label="Type 2 Diabetes Mellitus Without Complications"/>';
$strDiagnosis.='<set value="15" label="Alzheimers Disease"/>';
$strDiagnosis.='<set value="25" label="Essential (Primary) Hypertension"/>';
$strDiagnosis.='<set value="29" label="Old Myocardial Infarction"/>';
$strDiagnosis.='<set value="40" label="Cardiac Arrest"/>';
$strDiagnosis.='</chart>';?>
<script> 
		 var datastring = '<?php echo $strDiagnosis; ?>';
	  </script>
	  <div id="piechartdiv4"></div>
	  <?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/Pie2D.swf", "pieChartId1", "65%", "300", "0", "0", "datastring", "piechartdiv4"); ?>
			</div>
			</td>
			
			<td>
			<div id="ChartId5">
			<?php 
$strSurgery='<chart showvalues="1" caption="Most Common Frequent Procedures"  captionPadding="20" showlegend="1" enablesmartlabels="1" showlabels="0" showpercentvalues="0" bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#fff" legendBgColor="#1B1B1B" toolTipBgColor="#1B1B1B" legendBgAlpha="100" showBorder="0" minimiseWrappingInLegend ="1" legendPosition="RIGHT" legendScrollBarColor ="#000" legendScrollBgColor="#000" >';
foreach($SurgeryCount as $common)
{
	$strSurgery.='<set value="'.$common[0]['recordcount'].'" label="'.$common['TariffList']['short_name'].'"/>';
}
$strSurgery.='</chart>';?>
<script> 
		 var datastring = '<?php echo $strSurgery; ?>';
	  </script>
	  <div  id="piechartdiv5"></div>
	  <?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/Pie2D.swf", "pieChartId2", "140%", "300", "0", "0", "datastring", "piechartdiv5"); ?>
			</div>
			</td>
			</tr>
</table>
	