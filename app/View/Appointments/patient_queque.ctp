<div class="inner_title"><h3>
			<div><?php echo __('Patient Queue List.'); ?> </div>			
</h3>
<span style="align:right;padding: 7px 30px 0 0;">
<?php echo $this->Html->link('Back',array('controller'=>'Appointments','action'=>'appointments_management'),array('class'=>'blueBtn'))?>
</span>
</div>
<!--  Chamber One -->
<div>
<div style="float:left; width:33%;background-color:#DDDDDD;">
<table border="0" cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">
	<tr>
		<th colspan="2">Chamber First</th>
	</tr>
	<tr>
		<td>Doctor Name</td>
		<td align="left"><?php echo $this->Form->input('',array('empty'=>'Please Select','options'=>$listDoctor,'id'=>'listChamberone'));?></td>
	</tr>
</table>
<div id="c1" style="background-color:#DDDDDD;">
</div>


</div>
<!--  Chamber Two -->
<div style="float:left; width:33%;background-color:#DDDDDD;">
<table border="0"    cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">
	<tr>
		<th colspan="2">Chamber Second</th>
	</tr>
	<tr>
		<td>Doctor Name</td>
		<td align="left"><?php echo $this->Form->input('',array('empty'=>'Please Select','options'=>$listDoctor,'id'=>'listChambertwo'));?></td>
	</tr>
</table>
<div id="c2" style="background-color:#DDDDDD;">
</div>
</div>
<!--  Chamber Three -->
<div style="float:left; width:33%;background-color:#DDDDDD;">
<table border="0"    cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">
	<tr>
		<th colspan="2">Chamber Third</th>
	</tr>
	<tr>
		<td>Doctor Name</td>
	<td align="left"><?php echo $this->Form->input('',array('empty'=>'Please Select','options'=>$listDoctor,'id'=>'listChamberthree'));?></td>
	</tr>
</table>
<div id="c3"  style="background-color:#DDDDDD;">
</div>
</div>
</div>

<script>
jQuery(document).ready(function() {
	$('#listChamberone').val(' ');
	$('#listChambertwo').val(' ');
	$('#listChamberthree').val(' ');
});

$('#listChamberone').change(function(){
	var docId=$('#listChamberone').val();
	if(docId!=''){
		chamberOneCall(docId);
	}else{
		$('#c1').html(' ');
	}
	
});
// chamber one
function chamberOneCall(docId){
	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "chamberOne")); ?>";
	$.ajax({
	   	beforeSend : function() {
	   		$('#busy-indicator').show('fast');
	   	},
	   	type: 'POST',
	   	url: ajaxUrl+'/'+docId,
	   	dataType: 'html',
	  	//data: 'toSave='+$('#messageLabRad').val(),
	   	success: function(data){
	   		$('#busy-indicator').hide('fast');
	   		$('#c1').html(data);
	   		//$('#c2').html(data);
	   		//$('#c3').html(data);
	        	},
	        	
	  })
	.done(function(data){
		setTimeout(function(){
			chamberOneCall(docId);
		}, 3000);
    	
	});
}
// chamber two
function chamberTwoCall(docId){
	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "chamberTwo")); ?>";
	$.ajax({
	   	beforeSend : function() {
	   		$('#busy-indicator').show('fast');
	   	},
	   	type: 'POST',
	   	url: ajaxUrl+'/'+docId,
	   	dataType: 'html',
	  	//data: 'toSave='+$('#messageLabRad').val(),
	   	success: function(data){
	   		$('#busy-indicator').hide('fast');
	   		$('#c2').html(data);
	   		//$('#c2').html(data);
	   		//$('#c3').html(data);
	        	},
	        	
	  })
	.done(function(data){
		setTimeout(function(){
			chamberTwoCall(docId);
		}, 3000);
    	
	});
}
//chamber two
function chamberThreeCall(docId){
	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "chamberThree")); ?>";
	$.ajax({
	   	beforeSend : function() {
	   		$('#busy-indicator').show('fast');
	   	},
	   	type: 'POST',
	   	url: ajaxUrl+'/'+docId,
	   	dataType: 'html',
	  	//data: 'toSave='+$('#messageLabRad').val(),
	   	success: function(data){
	   		$('#busy-indicator').hide('fast');
	   		$('#c3').html(data);
	   		//$('#c2').html(data);
	   		//$('#c3').html(data);
	        	},
	        	
	  })
	.done(function(data){
		setTimeout(function(){
			chamberThreeCall(docId);
		}, 3000);
    	
	});
}
$('#listChambertwo').change(function(){
	var docId=$('#listChambertwo').val();
	if(docId!=''){
		chamberTwoCall(docId);
	}
	
});
$('#listChamberthree').change(function(){
	var docId=$('#listChamberthree').val();
	if(docId!=''){
		chamberThreeCall(docId);
	}
	
});

</script> 