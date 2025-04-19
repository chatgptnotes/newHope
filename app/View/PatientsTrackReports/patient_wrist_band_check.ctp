<style>
.position {
	margin-top: 240px;
	/* 	margin-left: 318px; */
	text-align: center;
}

.positionBtn {
	margin-left: 820px;
	margin-top: -35px;
}

.ready {
	margin-left: 20px;
	margin-top: 300px;
}

.scanBox {
	margin-left: 20px;
	margin-top: 130px;
}

.pagetxt {
	margin-left: 412px;
	margin-top: -15px;
}
/*  */
</style>
<body class="pagediv">
	<?php 
	echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js','slides.min.jquery.js'));
	echo $this->Html->css(array('internal_style.css'));
	?>
	<script>

var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
</script>
	<div class="patient_info">
		<?php echo $this->element('patient_information');?>
	</div>
	<div class="clr"></div>
	<div class='position'>
		<?php echo __("Please scan the patient wristband.");?>

	</div>
	<div class='scanBox'>
		<span style="opacity: 0;"><?php echo $this->Form->input('scan',array('div'=>false,'label'=>false,'id'=>'scanId')); ?>
		</span>
	</div>
	<div class='scanBox'>
		<table width="100%">
			<tr>
				<td width="35%"style="font-size: medium;"><strong><?php echo __("Ready to scan"); ?></strong></td>
				<td width="20%" align="center" style="font-size: smaller;"><strong><?php echo __("1 of 2"); ?></strong></td>
				<td width="40%" align="right"><?php echo $this->Form->button('Next',array('id'=>'patientScan','class'=>'Bluebtn')); ?>
				</td>
			</tr>
		</table>
	</div>
	<!-- <div class='ready'>
		<?php echo __("Ready to scan"); ?>
	</div>
	<div class='pagetxt'>
		<?php echo __("1 of 2"); ?>
	</div>
	<div class='positionBtn'>
		<?php echo $this->Form->button('Next',array('id'=>'patientScan','class'=>'Bluebtn')); ?>
	</div> -->
</body>

<script>
$(document).ready(function(){
	$('#patientSearchDiv').remove();
	$('#scanId').focus();
	$(document).click(function(){
		$('#scanId').focus();
		});	

	$("#patientScan").click(function(){
		if($('#scanId').val() == ''){
			var didConfirm = confirm("Patient has not been verified by a scan."+'\n'+"Do you want to continue?");
			if (didConfirm == false) return false;
		}
		if($('#scanId').val() != '' || didConfirm == true) { 
				$.ajax({
					data: 'id='+$('#scanId').val(),
   		  			type: 'POST',
					url: "<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "patientWristBandCheck",$patient_id, "admin" => false)); ?>",
		     		dataType: 'text',
		     		success: function(data){ 
			      		if(data == true || $.trim(data) == 'Not scanned'){ 
				      		window.location.href = '<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "prescribedMedicationList",$patient_id, "admin" => false));?>';
			     		}else if(data == false){
			    	 		$('#scanId').val('');
							alert('wrong patient selected');
							$('#scanId').val('');
							 return false;
				    	}
			      		
		      		}
				});
			  }
	});
});
</script>
