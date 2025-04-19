<?php
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>

<div id="getPackage" style="cursor:hand;pointer:hand">Get Package</div>

<script>
var getPackageUrl = "<?php echo $this->Html->url(array("controller" => 'Tests', "action" => "getPackage",$patientId,"admin" => false)); ?>" ;
$( "#getPackage").click(function() {
	
	$.fancybox({

		'width' : '80%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : getPackageUrl
});
});
	

</script>