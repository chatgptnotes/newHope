<script	src="http://code.jquery.com/ui/1.8.16/jquery-ui.js"></script>
<div id="accordian" class="accordian">
<ul>
	<li>
	<h3 class="expand">Vitals Sign(24/12/2013)</h3>
	<div class="inner_leftinner collapse ui-accordion">
	<div class="inner_first1"></div>
	<div class="inner_right1">
	<div><?php echo $this->Html->script(array('/fusionpx_data/js/VitalSignMALine2')); ?>
	<!-- chart -->
	<div id="multiaxischartdiv1" align="center">FusionCharts</div>
	<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId1", "145%", "250", "0", "0", "dataString", "multiaxischartdiv1"); ?>
	</div>
	</div>

	</div>
	</li>
	<li>
	<h3 class="expand">Hemodynamics(24/12/2013)</h3>
	<div class="inner_leftinner collapse">
	<div class="inner_first1"></div>
	<div class="inner_right1">
	<div><?php echo $this->Html->script(array('/fusionpx_data/js/HemodynamicsMALine2')); ?>
	<!-- chart -->
	<div id="multiaxischartdiv2" align="center">FusionCharts</div>
	<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId2", "145%", "250", "0", "0", "dataString", "multiaxischartdiv2"); ?>
	</div>
	</div>

	</div>
	</li>
	<li>
	<h3 class="expand">Vasoactive Infusion(24/12/2013)</h3>
	<div class="inner_leftinner collapse">
	<div class="inner_first1"></div>
	<div class="inner_right1">
	<div><?php echo $this->Html->script(array('/fusionpx_data/js/VasoactiveMALine2')); ?>
	<!-- chart -->
	<div id="multiaxischartdiv4" align="center">FusionCharts</div>
	<?php echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId4", "145%", "250", "0", "0", "dataString", "multiaxischartdiv4"); ?>
	</div>
	</div>
	</div>
	</li>
    <!-- <li>
	<h3 class="expand">Blood Pressure(24/12/2013)</h3>
	<div class="inner_leftinner collapse">
	<div class=""></div>
	<div class="inner_right1">
	<div><?php //echo $this->Html->script(array('/fusionpx_data/js/MALine2')); ?>
	<div id="multiaxischartdiv3" align="center">FusionCharts</div>
	<?php //echo $this->JsFusionChart->showFusionChart("fusionpx_charts/MultiAxisLine.swf", "multiaxisChartId3", "145%", "250", "0", "0", "dataString", "multiaxischartdiv3"); ?>
	</div>
	</div>
	</div>
	</li> -->
</ul>
</div>
</div>
<script>
	
 $(function() {
	    $(".accordian h3.expand").toggler();
	    $(".accordian div.expand").expandAll();
	    $(".accordian div.other").expandAll({
	      expTxt : "[Show]", 
	      cllpsTxt : "[Hide]",
	      ref : "ul.collapse",
	      showMethod : "show",
	      hideMethod : "hide"
	    });
	    $(".accordian div.post").expandAll({
	      expTxt : "[Read this entry]", 
	      cllpsTxt : "[Hide this entry]",
	      ref : "div.collapse", 
	      localLinks: "p.top a"    
	    });    
	});
 
 $( document ).ready(function() {
	 $(".collapse").css('display','block');

		    
		});
 
 $( "#accordianLab, #accordianTherapy" ).sortable({
	    connectWith: ".connectedSortable",
	    stop: function(event, ui) {
	        $('.connectedSortable').each(function() {
	            result = "";
	            //alert($(this).sortable("toArray"));
	            $(this).find("li").each(function(){
	                result += $(this).text() + ",";
	            });
	            $("."+$(this).attr("id")+".list").html(result);
	        });
	    }
	});
</script>