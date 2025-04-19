<?php 
echo $this->Html->script(array('default','animsition.js','animsition.min.js'));
echo $this->Html->css(array('animsition.css','animsition.min.css'));
?>
<style>
.inner_title{
width:99%;
}


</style>

<div class="inner_title">
	<h3>
		<div>
			<?php echo __('Patient Queue List.'); ?>
		</div>
	</h3>
	<span style="align: right; padding: 7px 30px 0 0;"> 
	<?php echo $this->Html->link('Back',array('controller'=>'Appointments','action'=>'appointments_management'),array('class'=>'blueBtn'));?>
	</span>
</div>

<!--  Chamber One -->
<div>
	<?php if(isset($chamberList)){?>
	<?php foreach($chamberList as $key => $chambers){?>
	<div style="background-color: #DDDDDD;  float:left; width:25%; font-weight: bold;text-align: center;">
		<table border="0" cellpadding="0" cellspacing="2" width="100%">
			<tr >
				<tr><?php echo $this->Form->input('',array('empty'=>'Select Doctor','options'=>$listDoctor,'div'=>false,'label'=>false,
						'id'=>"listChamber-".$chambers[Chamber][id],'style'=>"width:35%",'class'=>'chamberRow'));?>
						<?php echo "&nbsp";?>
				</tr>
				<tr style="width:5%"><?php echo __($chambers['Chamber']['name']);?></tr>
				
			</tr>
			<tr><td>&nbsp;</td></tr>
		</table>
		<div id="c-<?php echo $chambers[Chamber][id]?>"
			style="background-color: #DDDDDD;" class='dataDiv'>
			<table cellspacing="2" cellpadding="0" border="0" width="100%"
				style="text-align: center;">
				<tr bgcolor="#D2EBF2">
					<td height="50" colspan="4">Please Select Physician.</td>
				</tr>
			</table>
		</div>
	</div>
	<?php }?>
	<?php }?>

</div>

<script>
var blankData = $('.dataDiv').html();
$('.chamberRow').change(function(){
	var chamberNumber = $(this).attr('id').split("-")[1];
	var doctorId = $(this).val();
	if(doctorId != ''){
		
		chamberOneCall(doctorId,chamberNumber);
		
	}else{
		$('#c-'+chamberNumber).html(blankData);
		clearTimeout(timeoutReference);
	}
	
});
// chamber one
var timeoutReference = '';
var test = 0;
var ajObj = new Array();
function chamberOneCall(doctorId,chamberNumber){
	
	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "chamberPatient")); ?>";
	$('.chamberRow').each(function(){
		var chamberNumber = $(this).attr('id').split("-")[1];
		var doctorId = $(this).val();
		
		if(doctorId != ''){
			if(-1 == jQuery.inArray(chamberNumber, ajObj )){
			ajObj.push(chamberNumber);
			var obj = $.ajax({
			   	type: 'POST',
			   	url: ajaxUrl+'/'+doctorId+'/'+chamberNumber,
			   	dataType: 'html',
			  	success: function(data){
			   		ajObj.remove(chamberNumber);
			   		$('#c-'+chamberNumber).html(data);
			   	},
			        	
			  }).done(function(data){
				  setTimeout( function(){
				  chamberOneCall(doctorId,chamberNumber);
				}, 100);
			});
			}
		}
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
	  	success: function(data){
	   		$('#busy-indicator').hide('fast');
	   		$('#c1').html(data);
	   	},
	        	
	  }).done(function(data){
		setTimeout(function(){
			chamberTwoCall(docId);
		}, 300000000);
    	
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
	  	success: function(data){
	   		$('#busy-indicator').hide('fast');
	   		$('#c2').html(data);
	   			},
	        	
	  }).done(function(data){
		setTimeout(function(){
			chamberThreeCall(docId);
		}, 300000000);
    	
	});
}


</script>
