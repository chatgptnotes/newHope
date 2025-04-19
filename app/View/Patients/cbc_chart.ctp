<style>
body{
background-color :#1B1B1B;
}</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div>
	<h3><font style="color:#fff">
		<?php
		echo __('CBC Rate Chart', true)." For - ".$patient[0]['Patient']['lookup_name'];?>
	</font></h3>
	<!-- chart -->
	<?php if($labResults)	
	{ ?>
	<div id="multiaxischartdiv4" align="center">FusionCharts</div>
	<?php
	
	$max=strtotime(substr($labDate[0][0]['max'],0,10));
	$min=strtotime(substr($labDate[0][0]['min'],0,10));
	$strXML ='<chart caption="CBC Rate Chart" legendBgColor="1B1B1B" canvasBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff" toolTipBgColor="1B1B1B" showBorder="0" borderColor="1B1B1B" bgAlpha="100" divLineColor="#AFD8F8"  xaxisname="Time" rotateLabels="1" showValues="0" decimalPrecision="1" labelDisplay="WRAP" anchorRadius="4" adjustDiv="1" >';
	$strCategory='<categories>';
	$strHgb='<axis  title="Haemoglobin Count, Erythrocyte Count (gm/dL)" Pos="left" tickWidth="10" divlineisdashed="1">';
	$strHgb.='<dataset seriesName="Haemoglobin Count (gm/dL)" lineThickness="3" >';
	$strErt='<dataset seriesName="Erythrocyte Count (gm/dL)" lineThickness="3" color="#022B9E" >';//dark blue color
	$strHmc='<axis  title="Hematocrit Count (%)" titlepos="right" axisOnLeft="0" tickWidth="10" divlineisdashed="1" >';
	$strHmc.='<dataset seriesName="Hematocrit Count (%)" lineThickness="3">';
	$strLkc= '<axis  title="Leukocytes Count ({cells}/uL)" titlepos="right" axisOnLeft="0" tickWidth="10" divlineisdashed="1" >';
	$strLkc.='<dataset seriesName="Leukocytes Count ({cells}/uL)" lineThickness="3" >';
	$strPlt='<axis  title="Platelets Count ({cells}/uL)" Pos="left" tickWidth="10" divlineisdashed="1">';
	$strPlt.='<dataset seriesName="Platelets Count ({cells}/uL)" lineThickness="3" >';
	if(!empty($labOPD))
	{
		foreach($labOPD as $opd)
		{
			$date=$this->DateFormat->formatDate2Local(substr($opd['LaboratoryHl7Result']['date_time_of_observation'],0 ,10),Configure::read('date_format'),false);
			$strCategory.='<category label="' . $date.'"/>';
		}
	}
	else 
	{
	$incre=0;
	for($i=$min;$i<=$max;$i+= $incre)
	{
		$var=date("Y-m-d",$i);
		$date=$this->DateFormat->formatDate2Local($var,Configure::read('date_format'),false);
		$strCategory.='<category label="' . $date.'"/>';
		$incre = (3600*24);
	
	}
	}

	$strCategory .= '</categories>';
	
	foreach($labResults as $labRes)
	{
		if($labRes[LaboratoryHl7Result][observations]=='718-7')
		{	
				$dateHB = $this->DateFormat->formatDate2Local(substr($labRes['LaboratoryHl7Result']['date_time_of_observation'],0 ,10),Configure::read('date_format'),false);
				$strHgb .= '<set toolText="HB Count= '.$labRes[LaboratoryHl7Result][result].'gm/dL {br} '.$dateHB.'" value="' . $labRes[LaboratoryHl7Result][result] . '" />';
				
		}
		elseif($labRes[LaboratoryHl7Result][observations]=='20570-8')
		{
		 		$dateHM=$this->DateFormat->formatDate2Local(substr($labRes['LaboratoryHl7Result']['date_time_of_observation'],0 ,10),Configure::read('date_format'),false);
				$strHmc .= '<set toolText="HM Count= '.$labRes[LaboratoryHl7Result][result].'% {br} '.$dateHM.'" value="' . $labRes[LaboratoryHl7Result][result] . '" />';
				
		}
		elseif($labRes[LaboratoryHl7Result][observations]=='26464-8')
		{
				$dateLc=$this->DateFormat->formatDate2Local(substr($labRes['LaboratoryHl7Result']['date_time_of_observation'],0 ,10),Configure::read('date_format'),false);
				$strLkc .= '<set toolText="Leukocytes Count= '.$labRes[LaboratoryHl7Result][result].'{cells/uL} {br} '.$dateLc.'" value="' . $labRes[LaboratoryHl7Result][result] . '" />';
				
		}
		elseif($labRes[LaboratoryHl7Result][observations]=='26515-7')
		{
				$datePt=$this->DateFormat->formatDate2Local(substr($labRes['LaboratoryHl7Result']['date_time_of_observation'],0 ,10),Configure::read('date_format'),false);
				$strPlt .= '<set toolText="Platelets Count= '.$labRes[LaboratoryHl7Result][result].'{cells/uL} {br} '.$datePt.'" value="' . $labRes[LaboratoryHl7Result][result] . '" />';
		}
		elseif($labRes[LaboratoryHl7Result][observations]=='26453-1')
		{
			$dateEr=$this->DateFormat->formatDate2Local(substr($labRes['LaboratoryHl7Result']['date_time_of_observation'],0 ,10),Configure::read('date_format'),false);
			$strErt .= '<set toolText="Erythocyte Count= '.$labRes[LaboratoryHl7Result][result].'gm/dL {br} '.$dateEr.'" value="' . $labRes[LaboratoryHl7Result][result] . '" />';
		}

	}

	$strErt.='</dataset>';
	$strHgb .= '</dataset>';
	$strHgb .= $strErt. '</axis>';
	$strHmc .= '</dataset>';
	$strHmc .= '</axis>';
	$strLkc .= '</dataset>';
	$strLkc .= '</axis>';
	$strPlt .= '</dataset>';
	$strPlt .= '</axis>';
	$strXML .= $strCategory.$strHgb.$strHmc.$strLkc.$strPlt;
	$strXML .= '</chart>';
  	?>
	<script>var datastring = '<?php echo $strXML; ?>';</script>
	<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId4", "98%", "90%", "0", "0", "datastring", "multiaxischartdiv4"); ?>
</div>
<?php }
else {
?>

<div align="center">
	<font style="color:#fff"><?php echo "No Records Found"; ?></font>
</div>
<?php } ?>

