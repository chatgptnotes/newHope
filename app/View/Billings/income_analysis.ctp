<?php 
echo $this->Html->script(array('/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
	<h3>
		<?php echo __('Billing Summary');?>
	</h3>
</div>

<script>
var xmlString = '<?php echo $xmlValues; ?>';
</script>

<div id="multiaxischartdiv1" align="center" style="padding-top:50px;">
	<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/StackedColumn2DLine.swf", "multiaxisChartId1", "80%", "400", "0", "0", "xmlString", "multiaxischartdiv1"); ?>
</div>        

