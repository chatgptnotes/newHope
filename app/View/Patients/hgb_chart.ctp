<style>
body{
background-color :#1B1B1B;
}

#sortable1,#sortable2 {
	list-style-type: none;
	margin: 0;
	padding: 0;
	float: left;
	margin-right: 10px;
}

#sortable1 li,#sortable2 li {
	margin: 0 5px 5px 5px;
	padding: 5px;
	font-size: 1.2em;
	width: 120px;
}

.sortable1.list,.sortable2.list {
	clear: both;
}

.expand a {
	margin-left: 20px;
}
.inner_right1{background:none!important;}
.inner_right1 span{background:none !important;}
.inner_right1 svg{background:none!important;}
.inner_right1 rect{background:none!important;}
.red-background-529 rect{background:#000!important;}

.right_inner2{background:none!important;}
.right_inner2 span{background:none !important;}
.right_inner2 svg{background:none!important;}
</style>
<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div><h3><font style="color:#fff"><?php echo __('Haemoglobin Chart', true)." For - ".$patient[0]['Patient']['lookup_name'];?></font></h3>
	<!-- chart -->
	<?php  if($labResults) {?>
	<div id="multiaxischartdiv4" align="center">FusionCharts</div>
	<?php
$strXML = '<chart caption="Haemoglobin Chart" legendBgColor="1B1B1B" canvasBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff" toolTipBgColor="1B1B1B" showBorder="0" borderColor="1B1B1B" bgAlpha="100"  xaxisname="Time" rotateLabels="1" showValues="0" decimalPrecision="1" labelDisplay="WRAP"  anchorRadius="4" >';
$strXML .= '<categories>';
foreach($labResults as $labRes)
{
	$date1=date('m/d/Y H:i',strtotime($this->DateFormat->formatDate2Local($labRes['LaboratoryHl7Result']['date_time_of_observation'],Configure::read('date_format'),true)));
	$strXML .='<category label="' .$date1. '"  />';
}
$strXML .= '</categories>';
$strXML .= '<axis  title="HB Count (gm/dL)" Pos="left" tickWidth="10" divlineisdashed="1">';
$strXML .= '<dataset seriesName="HB Count (gm/dL)" lineThickness="3" color="#AFD8F8">';
foreach($labResults as $labRes)
{
	$date=date('m/d/Y H:i',strtotime($this->DateFormat->formatDate2Local($labRes['LaboratoryHl7Result']['date_time_of_observation'],Configure::read('date_format'),true)));
	$strXML .= '<set toolText="HB Count= '.$labRes['LaboratoryHl7Result']['result'].'gm/dL {br} '.$date.'" value="' . $labRes['LaboratoryHl7Result']['result'] . '" />';
}

$strXML .= '</dataset>';
$strXML .= '</axis>';

$strXML .= '</chart>';
?>
	<script> 
		 var datastring = '<?php echo $strXML; ?>';
	  </script>

	<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId4", "98%", "90%", "0", "0", "datastring", "multiaxischartdiv4"); ?>
</div><?php }
else {?>
<div align="center"><font style="color:#fff"><?php echo "No Records Found";?></font></div>
<?php }?>



