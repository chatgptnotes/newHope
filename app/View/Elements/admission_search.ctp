<style>
#patient-info-box{
 	display: none;
    position: absolute;
    right: 0;
    top: 34px;
    z-index: 29;
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #000000;
    border-radius: 3px;
    box-shadow: 0 0 3px 2px #000;
    margin-top: -1px;
    padding: 6px;
    width: 338px;
    font-size:13px;
    list-style-type: none;
    
}
.ui-menu {
    display: block;
    list-style: outside none none;
    margin: 0;
    max-height: 300px;
    outline: medium none;
    overflow: scroll;
    padding: 2px;
}
</style>
<?php //debug($doctorName);//treating_consultant?>
<span style="padding-right:10px;float:right;padding-top: 10px" id="adminSearch">
	<?php echo $this->Form->input('addmission_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'addmissionId', 'class'=>''));
	echo $this->Form->hidden('patient_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'patientId', 'class'=>''));?>
	<?php echo '&nbsp;'.$this->Html->image('icons/user_info.png',array('id'=>'userInfo', 'style'=>'float:right;')); ?> 	 
</span>

<ul style="display: none;" id="patient-info-box">
	<li>Name : <?php echo $patient['Patient']['lookup_name'];?></li>
	<li>Gender/Age : <?php echo ucfirst($sex).'/'.$age ;?></li>
	<?php /*if($doctorName){ // --comented for optimization?>
	<li>Treating Physician : <?php echo ucfirst($doctorName[0]['fullname']) ;?></li>
	<?php }else{*/?>
	<li>Treating Physician : <?php echo ucfirst($patient['User']['first_name'].' '.$patient['User']['last_name']) ;?></li>
	<?php //}?>
	
	<li>MRN : <?php echo $patient['Patient']['admission_id'] ;?></li>
	<li>PatientId : <?php echo $patient['Patient']['patient_id'] ;?></li>
	<li>Admission Date : <?php echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></li>
	<li>Tariff : <?php echo $patient['TariffStandard']['name'];?></li>
	<?php
	 if($patient['Patient']['admission_type']=='IPD') {?>
		<li>Ward/Bed : <?php echo $wardInfo['Ward']['name']."/".$wardInfo['Room']['bed_prefix']." ".$wardInfo['Bed']['bedno'];?></li>
	<?php }?>
</ul>
		
		
<?php if($this->params['action']=='full_payment')
	echo '<br><br>';?>
<script>
$(document).ready(function() {
	
	var timer=setInterval(
	    	function () {
    	    	$('#patient-info-box').hide();
    }, 10000);

    $('#userInfo').mouseover(function(){  
    	 // var currentID = $(this).attr('id');
		  var pos = 	$(this).position();		    
		  var cc = $('#patient-info-box');//top: 40px; left: 1215px;
		  cc.css('top',pos.top+30); 
		  cc.css('left',pos.left-200); 
		  cc.css('right',pos.right);
		 // cc.css('left','1215px'); 
		 cc.show();  
		 clearInterval(timer);  
    	//$('.menu').toggle("slide");
	});
    $('#userInfo').mouseout(function(){ 
    	timer=setInterval(
    	    	function () {
        	    	$('#patient-info-box').hide();
        }, 10000); ;    	
	});

    $("#addmissionId").autocomplete({
    		//discharge condition removed --pooja (is_disharge=0)
    	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no",'is_discharge=0',"admin" => false,"plugin"=>false)); ?>", 
    		select: function(event,ui){
    			$( "#patientId" ).val(ui.item.id);
    			if($( "#addmissionId" ).val() != '')
		    		var url="<?php echo $this->Html->url(array('controller'=>$this->params['controller'],'action'=>$this->params['action']));?>";
		    		window.location.href=url+'/'+$( "#patientId" ).val();
		    		//$( "#addmissionId" ).trigger( "change" );
    	},
    	 messages: {
             noResults: '',
             results: function() {},
      }
    });
});



/* $("#addmissionId").change(function(){	
	var admissionId = $(this).val();
	alert(admissionId);
	var url="<?php //echo $this->Html->url(array('controller'=>'Billings','action'=>'multiplePaymentModeIpd'));?>";
	window.location.href=url+'/'+admissionId;
	
});*/


</script>