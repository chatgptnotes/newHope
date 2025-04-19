<?php 
     App::import('Vendor', 'fusionx_charts'); 
     echo $this->Html->script(array('/fusionx_charts/fusioncharts'));
?>

<div class="inner_title">
<h3><?php echo __('Readmission Rate Report', true).' - '.$reportYear; ?></h3>
</div>
<center><div id="chartContainer">FusionCharts will load here</div></center>
<div class="clr ht5"></div>
 <div>
<?php  
//debug($yaxisArray);
$i=1;
foreach($rate as $key=>$value)
{
	foreach($value as $key=>$mon)
	{
		//pr($mon);
		$admit[$i]=count($mon['admit']);
		$readmit[$i]=count($mon['Readmit']);
		$i++;
	}
		
	
}
$j=1;
foreach($admit as $admitRate)
{
	$reRate[$j]=($readmit[$j]/$admitRate)*100;
	$j++;
}
//pr($reRate);
$strXML ='<chart caption="Readmission Rate Chart" legendBgColor="1B1B1B"  bgColor="#4C5E64" baseFontColor="ffffff" divLineIsDashed="1" divLineColor="AFD8F8" numberSuffix="%" toolTipBgColor="1B1B1B" showBorder="1" canvasBgColor="1B1B1B" canvasBaseColor="1B1B1B" use3DLighting="0" bgAlpha="100" xAxisName="Months" yAxisName="Readmission Rate"  decimalPrecision="2" yAxisMaxValue="5">';
	$strCategories='<categories>';
	foreach($yaxisArray as $category)
	{
			$strCategories.='<category name="'.$category.'"/>';
	}
	$strCategories.='</categories>';
	$strData='<dataset color="AFD8F8">';
	//debug($var);
	for($i=1;$i<=12;$i++)
	{	
		if($reRate[$i]!="")
		{
			//debug($var);
		$strData.='<set value="'.$reRate[$i].'"/>';
		}
		else 
		{
			$strData.='<set value="0"/>';
		}
	}
	$strData.='</dataset>';
	$strXML.=$strCategories.$strData.'</chart>';?>
	<script>var datastring= '<?php echo $strXML;?>';</script>
</div>
<?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "readmission", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
<div class="clr ht5"></div>
 <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'readmission', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>
