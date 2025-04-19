<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>

	<div class="inner_title"><h3><font style="color:#fff"><?php echo __('Comparative Analytics', true);?> </font></h3></div>
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
	<tr>
	<td width=50% style="border-right: dotted 1px #fff">
	<div id="chart1" style="background-color: #1B1B1B">Most Common Unexpected Denials</div>
	</td>
	<td width=50%><div id="chart3" style="background-color: #1B1B1B" >Payment Velocity</div></td>
	</tr>
	<tr><td style="border-right: dotted 1px #fff">
	<div id="chart2" style=" border-top: dotted 1px #fff ;">Payer adjudication summary</div></td>
	
	<td valign="top">
	<div id="chart4" style=" border-top: dotted 1px #fff ;" >Top 5 Most Unexpected Denied Procedures</div></td>
	</tr></table>
	
	<?php 
	//For chart1 unexpected denials
	$strChart1='<chart caption="Most Common Unexpected Denials" legendCaption="Reason Code" chartleftMargin="50" chartbottomMargin="100" showlegend="1" showvalues="1"  enablesmartlabels="0" showlabels="0" pieRadius="120" startingAngle="130" showpercentvalues="1" bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#fff" legendBgColor="#1B1B1B" toolTipBgColor="#1B1B1B" legendBgAlpha="100" showBorder="0" minimiseWrappingInLegend ="1" legendPosition="RIGHT">';
	foreach($denials as $denials)
	{
		$strChart1.='<set value="'.$denials[0]['denialCount'].'" label="'.$denials['Encounter']['claim_status_code'].'"/>';
	}
	$strChart1.='</chart>';
	//For chart2 Payer adjudication
	$strChart2='<chart caption="Payer Adjudication Summary" legendCaption="Service Line Status" chartleftMargin="30" chartbottomMargin="100" showlegend="1" showvalues="1"  enablesmartlabels="0" showlabels="0" pieRadius="120" startingAngle="130" showpercentvalues="1" bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#fff" legendBgColor="#1B1B1B" toolTipBgColor="#1B1B1B" legendBgAlpha="100" showBorder="0" minimiseWrappingInLegend ="1" legendPosition="RIGHT" showLegendBorder="0">';
	$strChart2.='<set value="'.$paid[0][0]['paid'].'"  label="Paid"/>';
	$strChart2.='<set value="'.$payer[1][0]['expected'].'"  label="Unexpected"/>';
	$strChart2.='<set value="'.$payer[0][0]['expected'].'"  label="Expected"/>';
	$strChart2.='</chart>';
	//For chart3 Payment Velocity
	$strChart3='<chart caption="Payment Velocity" legendCaption="DOS to check date" chartleftMargin="30" chartbottomMargin="100" showlegend="1" showvalues="1"  enablesmartlabels="0" showlabels="0" pieRadius="120" startingAngle="130" showpercentvalues="1" bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#fff" legendBgColor="#1B1B1B" toolTipBgColor="#1B1B1B" legendBgAlpha="100" showBorder="0" minimiseWrappingInLegend ="1" legendPosition="RIGHT" showLegendBorder="0">';
	foreach($velocity as $key=>$value)
	{
		if($key==0)
		{
			// for dispalying the label on legend..
			$dataKey=$key.'-'.($key+30);
		}
		else {
			$dataKey=$key.'-'.($key+29);
		}
		$strChart3.='<set value="'.$value.'" label="'.$dataKey.'"/>';
	}
	$strChart3.='</chart>';
	?>
	<script>
			var dataString1='<?php echo $strChart1;?>';
			var dataString2='<?php echo $strChart2?>';
			var dataString3='<?php echo $strChart3;?>';
			
	</script>
	<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/Pie3D.swf", "pieChart1", "85%", "400", "0", "0", "dataString1", "chart1");
		  echo $this->JsFusionChart->showFusionChart("fusionx_charts/Pie3D.swf", "pieChart2", "85%", "400", "0", "0", "dataString2", "chart2");
		  echo $this->JsFusionChart->showFusionChart("fusionx_charts/Pie3D.swf", "pieChart3", "85%", "400", "0", "0", "dataString3", "chart3"); ?>