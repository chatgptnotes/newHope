
			
			<h3 style="border-bottom: solid 4px #20B2AA">Ward Details</h3>
			<!--  <h4><u>Ward Transaction Details</u></h4>-->
			<?php if($wardDetails){?>
			<div class="visitDetails">
				<table class="infoDiv" cellpadding="0" cellspacing="0">
					<tr>
						<td><b>Ward Name<b></td>
						<td><b>In Date/time</b></td>
						<td><b>Out Date/Time</b></td>
						<td><b>Total Days</b></td>
					</tr>
					<?php foreach($wardDetails as $ward=>$details){//debug($details);exit;
					$wardName=key($details);
					$inTime=$details[$wardName]['0']['WardPatient']['in_date'];
					$outTime=$details[$wardName]['0']['WardPatient']['out_date'];
					$date1=new DateTime($inTime);
					$date2=new DateTime($outTime);
					$diffdate=$date1->diff($date2);
					$lastKey=$diffdate->d;
					?>
					<tr>
						<td><?php echo $wardName?></td>
						<td><?php echo $this->DateFormat->formatDate2Local($inTime,Configure::read('date_format'),true);?>
						</td>
						<td><?php echo $this->DateFormat->formatDate2Local($outTime,Configure::read('date_format'),true);?>
						</td>
						<td><?php echo $lastKey;?></td>
					</tr>

					<?php 
					 }?>
				</table>
			</div>
			<?php }?>
			<div style="padding-left: 10px; float: left">
				<?php  //Condition for non discharge patient if bed is is resent show allot bed else show transfer bed
					 if(empty($this->params->query['is_discharge'])){
					if(!empty($this->params->query['bed_id'])){
						echo $this->Html->link('Transfer Bed','javascript:void(0)',array('allot'=>'transfer','escape'=>false,'class'=>'blueBtn transfer'));
					}else{
						echo $this->Html->link('Allot Bed','javascript:void(0)',array('allot'=>'allot','escape'=>false,'class'=>'blueBtn transfer'));?>
				<?php } 
				}?>
			</div>
		</div>	
<script>
$(document).ready(function(){
	$('.tag').text(parent.dischargeMsg);
	$('.tag').addClass(parent.tagClass);
	$('#name').text(parent.name);
	$('#age').text(parent.age);
	$('#care').text(parent.care_provider);
	$('#address').text(parent.address);
	$('#blood_group').text(parent.blood_group);
	$('#uid').text(parent.uid);
	$('#adm_type').text(parent.adm_type);
	$('#mobile').text(parent.mobile);
	$('#tariff').text(parent.tariffStandard);
	$('#date').text(parent.adm_date);
});
$(document).on('click','.transfer',function(){
   var allot = $(this).attr('allot') ;
	$.fancybox({
        'width'    : '90%',
	    'height'   : '90%',
	    'autoScale': true,
	    'transitionIn': 'fade',
	    'transitionOut': 'fade',
	    'type': 'iframe',
	    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_transfer",$patient_id)); ?>/"+allot,
	    'onClosed':function(){
	    	var discharge="<?php echo $this->params->query['is_discharge']?>";
			var bed_id="<?php echo $this->params->query['bed_id']?>";
			$.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Wards", "action" => "patientWardTransaction",$this->params['pass']['0'], "admin" => false)); ?>?is_discharge="+discharge+'&bed_id='+bed_id,
				  context: document.body,	
				  beforeSend:function(){
					  $('#busy-indicator').show();
				  }, 	  		  
				  success: function(data){	
					  $('#busy-indicator').hide('fast');				  
					  $('#content').html(data);
				   }
			});	
	    }
    });
});
</script>