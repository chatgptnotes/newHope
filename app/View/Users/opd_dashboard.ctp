<?php
	echo $this->Html->script(array('inline_msg','jquery.autocomplete' ,
		'jquery.selection.js','jquery.fancybox-1.3.4' ,'jquery.tooltipster.min.js' ,'jquery.blockUI'));
	echo $this->Html->css(array('tooltipster.css','jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));  
  ?>
	  


<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td {
	padding: 0;
	padding-left: 2px;
	font-size: 11.5px;
}

.tabularForm th{
	padding :0;
}

/*#msg {color: #666666;display:none; position:absolute; z-index:200; background:url(../../img/msg_arrow.gif) left center no-repeat; padding-left:7px}
#msgcontent {display:block; background:#f3e6e6; border:2px solid #924949; border-left:none; padding:5px; min-width:150px; max-width:250px}*/


#msg{
	display:none; position:absolute; z-index:200;
	padding-left:7px;
	background-image: url("../theme/Black/img/icons/tick.png");
    background-position: 2px 40%;
    padding: 5px 0px 5px 18px;
    background-repeat: no-repeat;     
    background-color: #EBF8A4;
    color: #000000;
    background-repeat: no-repeat;
    border: 1px solid #A2D246;
    border-radius: 5px;
    box-shadow: 0 1px 1px #FFFFFF inset;
    margin: 0.5em 0 1.3em;
    background-color: #EBF8A4;
    width: 39px;
    font-weight: bold;
}
label{ padding-top:0px !important;}
.feilddiv label{padding-top:0px !important;}  
    
</style>
<div class="inner_title">
	<h3><?php 
	if(!empty($this->request->query['flag'])){
		echo __('Alert Management', true);
	}else{
	echo __('Tracking Board', true); 
	}?></h3> 
</div>

<?php 
	$role = $this->Session->read('role');
	if(strtolower($role)==strtolower(Configure::read('adminLabel')) || strtolower($role)==strtolower(Configure::read('doctorLabel'))) {
?> 
<table class="feilddiv">
	<tr>
		<td>
			<?php 
					echo $this->Form->create('User',array('action'=>'opd_dashboard_patient_list','default'=>false,'id'=>'content-form'));
					if($role == "Admin"){
					echo '<label for="all-doctors">Select Doctor :</label>' ;
					echo $this->Form->input('All Doctors',array('empty'=>'All Doctors','type'=>'select','options'=>$doctors,
											'class'=>'all-doctors','id'=>"all-doctors",
											'autocomplete'=>'off','label'=>false,'div'=>false));
					echo '</td>';
					}
					echo '<td>
					<label for="all-doctors">Patient Name :</label>' ;
					echo $this->Form->input('Patient Name',array('class'=>'patient-name','id'=>"patient-name",'label'=>false,'autocomplete'=>'off','div'=>false));
					echo '</td><td>' ;
					echo $this->Form->button('Search',array('class'=>'blueBtn','id'=>"patient-search",'autocomplete'=>'off','div'=>false));
					$this->Js->get('#all-doctors');
					//$this->Js->get('#patient-name');
					//$this->Js->event('change','$("#UserDoctorDashboardForm").submit();', array('stop' => false));
					$this->Js->event(
							'change',
							$this->Js->request(
									array('action' => 'opd_dashboard_patient_list',),
									array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
																						                    array(
																						                        'isForm' => true,
																						                        'inline' => true
																						                    )
																						                ),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
							)
					);

					echo $this->Form->end();
					echo $this->Js->writeBuffer();
			?>
		</td>
	</tr>
</table>
<?php } ?>
<!-- Table Position -->
<div id="content-list" >
</div>
<div class="clr ht5"></div>
  
<script>
			                   		
$.ajax({
	  type : "POST",
	  url: "<?php echo $this->Html->url(array("controller" => 'users', "action" => "opd_dashboard_patient_list","admin" => false)); ?>",
	  context: document.body,	   
	  beforeSend:function(){
	    // this is where we append a loading image
	   loading();
	  }, 	  		  
	  success: function(data){				 
		 // $('#busy-indicator').hide('fast');
		$('#content-list').html(data).fadeIn('slow');
		//$('#content-list').unblock();  
	  }
});


jQuery(document).ready(function(){

	$("#patient-search").click(function(){
		 var formData = $('#content-form').serialize();
		$.ajax({
			  type : "POST",
			  data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => 'users', "action" => "opd_dashboard_patient_list","admin" => false)); ?>",
			  context: document.body,	   
			  beforeSend:function(){
			    // this is where we append a loading image
			   loading();
			  },
			  onComplete:function(){
				  onCompleteRequest();
			  }, 	  		  
			  success: function(data){						 
				 // $('#busy-indicator').hide('fast');
				$('#content-list').html(data).fadeIn('slow');
				//$('#content-list').unblock();  
			  }
		});
				
		});


	$(document).on('change',".lvl",function(){
		 
		currentId = $(this).attr('id') ;
		splittedVar = currentId.split("_");		 
		patientId = splittedVar[1]; 
		value = $(this).val(); 
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => 'users', "action" => "dashboard_update","level","admin" => false)); ?>"+"/"+patientId,
			  context: document.body,	
			  data : "value="+value,
			  beforeSend:function(){
			    // this is where we append a loading image
			   // $('#busy-indicator').show('fast');
			  }, 	  		  
			  success: function(data){					 
				 // $('#busy-indicator').hide('fast');
				 
				  inlineMsg(currentId,'Done');
			  }
			});		 
	});

	 
	$(document).on('change',".sts",function(){
		currentId = $(this).attr('id') ;
		splittedVar = currentId.split("_");		 
		patientId = splittedVar[1]; 
		value = $(this).val();		 
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => 'users', "action" => "dashboard_update","status","admin" => false)); ?>"+"/"+patientId,
			  context: document.body,	
			  data : "value="+value,
			  beforeSend:function(){
			    // this is where we append a loading image
			    //$('#busy-indicator').show('fast');
			  }, 	  		  
			  success: function(data){					  
				  //$('#busy-indicator').hide('fast');
				  inlineMsg(currentId,'Done');
			  }
		});		 
	});

	 
	$(document).on('change',".nurse",function(){
		currentId = $(this).attr('id') ;
		splittedVar = currentId.split("_");		 
		patientId = splittedVar[1]; 
		value = $(this).val();		 
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => 'users', "action" => "dashboard_update","nurse","admin" => false)); ?>"+"/"+patientId,
			  context: document.body,	
			  data : "value="+value,
			  beforeSend:function(){
			    // this is where we append a loading image
			    //$('#busy-indicator').show('fast');
			  }, 	  		  
			  success: function(data){					  
				  //$('#busy-indicator').hide('fast');
				  inlineMsg(currentId,'Done');
			  }
		});		 
	});

 
	$(document).on('change',".doctor",function(){
		currentId = $(this).attr('id') ;
		splittedVar = currentId.split("_");		 
		patientId = splittedVar[1]; 
		value = $(this).val();		 
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => 'users', "action" => "dashboard_update","doctor","admin" => false)); ?>"+"/"+patientId,
			  context: document.body,	
			  data : "value="+value,
			  beforeSend:function(){
			    // this is where we append a loading image
			    //$('#busy-indicator').show('fast');
			  }, 	  		  
			  success: function(data){					  
				  //$('#busy-indicator').hide('fast');
				  inlineMsg(currentId,'Done');
			  }
		});		 
	});
	
	$('.transfer').click(function(){
	    var patient_id = $(this).attr('id') ;
		 
		$.fancybox({
            'width'    : '80%',
		    'height'   : '80%',
		    'autoScale': true,
		    'transitionIn': 'fade',
		    'transitionOut': 'fade',
		    'type': 'iframe',
		    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_transfer")); ?>"+'/'+patient_id 
	    });
		
  });

  $('.add-note').click(function(){
	  var patient = $(this).attr('id') ;
	  var patient_id = patient.split("-");
	  
		$.fancybox({
            'width'    : '80%',
		    'height'   : '80%',
		    'autoScale': true,
		    'transitionIn': 'fade',
		    'transitionOut': 'fade',
		    'type': 'iframe',
		    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_note")); ?>"+'/'+patient_id[1] 
	    });
  });
});
 

/*$('#all-doctors').ajaxStart(function() {
    loading();
}).ajaxComplete(function() {
	$('#content-list').unblock(); 
});*/

function loading(){
	 $('#content-list').block({ 
         message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Initializing...</h1>', 
         css: {            
             padding: '5px 0px 5px 18px',
             border: 'none', 
             padding: '15px', 
             backgroundColor: '#000000', 
             '-webkit-border-radius': '10px', 
             '-moz-border-radius': '10px',               
             color: '#fff',
             'text-align':'left' 
         },
         overlayCSS: { backgroundColor: '#cccccc' } 
     }); 
}

function onCompleteRequest(){
 	$('#content-list').unblock(); 
}

$(document).ready(function(){
	 
	$("#patient-name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null',0,'null','is_discharge=0'/*&admission_type=OPD'.$serachStr*/,"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});
});
</script>
