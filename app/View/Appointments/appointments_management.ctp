<?php  echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));   ?>
<style>
<!--
input[type="radio"]:checked+label {
	background-color: #e0e0e0;
	background-image: none;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15) inset, 0 1px 2px
		rgba(0, 0, 0, 0.05);
	outline: 0 none;
}

input[type="radio"]+label {
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	background-color: #f5f5f5;
	background-image: linear-gradient(to bottom, #fff, #e6e6e6);
	background-repeat: repeat-x;
	border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #b3b3b3;
	border-image: none;
	border-style: solid;
	border-width: 1px;
	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px
		rgba(0, 0, 0, 0.05);
	color: #333;
	cursor: pointer;
	display: inline-block;
	font-size: 14px;
	line-height: 20px;
	margin: 8px -3px 0;
	padding: 4px 12px;
	text-align: center;
	text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
	vertical-align: middle;
}

label {
	color: #000 !important;
	float: none !important;
	font-size: 13px;
	margin-right: 10px;
	padding-top: 7px;
	text-align: right;
	width: 97px;
}

input[type="radio"] {
	display: none;
}

.infoDiv {
	color: #000 !important;
}
-->
</style>
<?php
echo $this->Html->css('patient_hub css.css') ;
echo $this->Html->script ( array (
		'inline_msg',
		'jquery.blockUI'
) );

$flashMsg = $this->Session->flash ( 'still' );
if (! empty ( $flashMsg )) {
	?>
<div>
	<?php echo $flashMsg ;?>
</div>
<?php } ?>
<?php
// BOF print OPD patient sheet

if (isset ( $this->params->query ['patientId'] )) {

	echo "<script>var win = window.open('" . $this->Html->url ( array (
			'controller' => 'patients',
			'action' => 'opd_patient_detail_print',
			$this->params->query ['patientId']
	) ) . "', '_blank',
				'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  </script>";
	?>
<script>
	if (!win)
		alert("Please enabled popups to continue.");
	else {
		win.onload = function() {
			setTimeout(function() {
				if (win.screenX === 0) {
					alert("Please enabled popups to continue.");
				} else {
					// close the test window if popups are allowed.
					//window.location='<?php echo $this->Html->url(array('action'=>'patient_information',$patient['Patient']['id']));?>' ;  
				}
			}, 0);
		};
	}
</script>
<script>
$(window).scroll(function() {
    $('#closeimg').css('top', $(this).scrollTop() + "px");
});
</script>
<script>
			$('#selectedDate').click(function(){
				$('#patient-filter').val('');
				$('#patient_id').val('');
				$('#list_tab').hide();
				$('#future-filter').removeClass('active');
				$('#closed-filter').removeClass('active');
				$('#todays-filter').removeClass('active');
				$('#myPatient-filter').removeClass('active');
				$('#viewAll-filter').removeClass('active');
				$('#physician_tab').removeClass('active');
		 });
</script>
<?php }?>

<?php if($this->params->query['type']=='slidesix'){?>
<body class="animsition">
	<div class="inner_title1" style="margin-top: 2%">
		<h3>OPD Dashboard</h3>
	</div>
	<?php }?>
	<?php if($this->params->query['type']!='slidesix'){?>
	<div class="inner_title">
		<?php  }?>
		<?php
		$role = $this->Session->read ( 'role' );

		?>
		<?php  	echo $this->Form->create('Appointment',array('action'=>'appointments_dashboard','default'=>false,'id'=>'content-form')); ?>
		<table width="100%">
			<tr>
				<?php if($this->params->query['type']!='slidesix'){?>
				<td class="tdLabel" width="10%" ><label><?php

				echo $this->Form->input ( 'Discharged', array (
				'type' => 'checkbox',
				'class' => 'isDischarge',
				'id' => "isDischarge",
				'autocomplete' => 'off',
				'label' => false,
				'div' => false
		) );
		echo "Show Closed Visit";
		?>
				</label></td>
				<td  width="10%" ><?php echo $this->Form->input ( 'date_from', array (
						'type' => 'text',
						'class' => 'date_from textBoxExpnd',
						'id' => "dateFrom",
						'label' => false,
						'div' => false,
						'placeholder' => 'Date'
				) );
				
				$this->Js->get ( '#dateFrom' );
				$this->Js->event ( 'blur', $this->Js->request ( array (
						'action' => 'appointments_dashboard'
				), array (
						'method' => 'GET',
						'dataExpression' => true,
						'data' => $this->Js->serializeForm ( array (
								'isForm' => false,
								'inline' => true
						) ),
						'async' => true,
						'update' => '#content-list',
						'before' => 'loading();',
						'complete' => 'onCompleteRequest();'
				) ) );?>
				</td>

				<td class="tdLabel" width="5%">
					<!--<label>Patient Name:</label>--> <?php

					echo $this->Form->input ( 'patient_name', array (
				'type' => 'text',
				'class' => 'patient-filter',
				'id' => "patient-filter",
				'autofocus' => 'autofocus',
				'autocomplete' => 'off',
				'label' => false,
				'div' => false,
				'placeholder' => 'Patient Name'
		) );
		echo $this->Form->hidden ( 'patient_id', array (
				'id' => 'patient_id'
		) );
		?> <script>
			$('#patient-filter').click(function(){
				$('#dateFrom').val('');
				$('#dateTo').val('');
				$('#list_tab').hide();
				$('#future-filter').removeClass('active');
				$('#closed-filter').removeClass('active');
				$('#todays-filter').removeClass('active');
				$('#myPatient-filter').removeClass('active');
				$('#viewAll-filter').removeClass('active');
				$('#physician_tab').removeClass('active');
				});</script> <?php
				$this->Js->get ( '#patient_id' );
				$this->Js->event ( 'change', $this->Js->request ( array (
				'action' => 'appointments_dashboard'
		), array (
				'method' => 'POST',
				'dataExpression' => true,
				'data' => $this->Js->serializeForm ( array (
						'isForm' => false,
						'inline' => true
				) ),
				'async' => true,
				'update' => '#content-list',
				'before' => 'loading();',
				'complete' => 'onCompleteRequest();'
		) ) );

		?>
				</td>
				<?php }?>


				</td>

				<div style="padding-left: 5px; margin: 10px 0px 0px; float: left;"
					class="tdLabel">
					<?php
					// echo $this->Html->link('Today\'s Appts','#future',array('class'=>'todays-filter','id'=>"todays-filter", 'label'=>false,'div'=>false));
					?>

					<?php

					$this->Js->get ( '#todays-filter' );
					$this->Js->event ( 'click', $this->Js->request ( array (
					'action' => 'appointments_dashboard'
			), array (
					'method' => 'POST',
					'dataExpression' => true,
					'data' => $this->Js->serializeForm ( array (
							'isForm' => false,
							'inline' => true
					) ),
					'async' => true,
					'update' => '#content-list',
					'before' => 'loading();',
					'complete' => 'onCompleteRequest();'
			) ) );
			?>
				</div>
				</td>
				<td>
					<?php if($this->Session->read('userid') == '133'){ ?>
					<span>
						<?php echo $this->Html->link(__('OPD Corporate Report'), array('controller'=>'Reports','action' => 'opd_corporate_report','admin'=>false), array('escape' => false,'class'=>'blueBtn'));?>
					</span>
				<?php  } ?>
				</td>
				</tr>
				<tr>
				<td colspan="4" style="padding-bottom: 10px"><?php if($this->params->query['type']!='slidesix'){		?>
					<div style="padding-left: 16px">
						<input id="radio1" name="type" value="OPD" checked type="radio"
							class='typeSelected'> <label for="radio1"><font color="#3185AC">OPD</font>
						</label> <input id="radio2" name="type" value="Lab" type="radio"
							class='typeSelected'> <label for="radio2"><font color="#3185AC">Laboratory</font>
						</label> <input id="radio3" name="type" value="Rad" type="radio"
							class='typeSelected'> <label for="radio3"><font color="#3185AC">Radiology</font>
						</label>
						</label> <input id="radio4" name="type" value="UniqueQR" type="radio"
							class='typeSelected'> <label for="radio4"><font color="#3185AC">UniqueQR List</font>
						</label>
						
						
						
						
                	   <!--  <input id="radioUniqueQR" name="type" value="UniqueQR" type="radio" class="typeSelected">-->
                    <!--<label for="radioUniqueQR">UniqueQR List</label>-->

					</div> <?php }?>
				</td>
				<td><span id="totCount" style=" margin: -10px 0;"></span></td>
			</tr>
		</table>
		<?php if($this->params->query['type']!='slidesix'){?>
	</div>
	<?php }?>

	<div class="clr ht5"></div>
	<!--  <div id="talltabs-blue">
		<ul>
			<li id="button_tab" style="float:left;">
			<?php
			echo $this->Form->input ( 'doctor_id', array (
					'id' => 'doctor_id',
					'type' => 'hidden' 
			) );
			echo $this->Html->link ( 'All', 'javascript:void(0)', array (
					'class' => 'active doctor_tab',
					'id' => '' 
			) );
			?>
			</li>
			<?php foreach($doctors as $key=>$doctor){?>
				<li id="<?php echo $key;?>" style="float:left;"  >
				<?php
				
$selectedAction = $this->params->action;
				$$selectedAction = 'active';
				echo $this->Html->link ( $doctor, 'javascript:void(0)', array (
						'class' => "doctor_tab",
						'id' => $key 
				) );
				?>  
				</li>
				<?php }?>
			</ul>
</div>-->
	<?php

	if (strtolower ( $role ) == strtolower ( Configure::read ( 'adminLabel' ) )) {
	$this->Js->get ( '#all-doctors' );
	$this->Js->event ( 'change', $this->Js->request ( array (
			'action' => 'appointments_dashboard'
	), array (
			'method' => 'POST',
			'dataExpression' => true,
			'data' => $this->Js->serializeForm ( array (
					'isForm' => false,
					'inline' => true
			) ),
			'async' => true,
			'update' => '#content-list',
			'before' => 'loading();',
			'complete' => 'onCompleteRequest();'
	) ) );
}
?>


	<?php

	echo $this->Form->end ();
	echo $this->Js->writeBuffer ();

	?>
	<div id="content-list"></div>
	<style>
#msg {
	display: none;
	position: absolute;
	z-index: 200;
	padding-left: 7px;
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
	width: 150px;
	font-weight: bold;
}
</style>
	<script>	 
$(document).ready(function (){ 
	var type = "<?php echo $this->params->query['type']; ?>";
	if(type == "slidesix"){   
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "appointment_dashboard_slide_two","admin" => false)); ?>",
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
	}
});
	function load_list(refresh){
		//$("#content-form").reset();
		$('#content-form')[0].reset();
		//$('#content-form').find('form')[0].reset();
		
		url="<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "appointments_dashboard","admin" => false)); ?>";
		pageUrl=$('#patient-count').attr('url');

		if (typeof pageUrl !== "undefined") {
			url= pageUrl;  		
		}
		
		$.ajax({
			  type : "POST",
			  url: url,
			  context: document.body,
			  beforeSend:function(){
			    // this is where we append a loading image
			    if(refresh!='1'){	   
			   loading();
			  } 
			  },	  		  
			  success: function(data){					 
				 // $('#busy-indicator').hide('fast');
				$('#content-list').html(data).fadeIn('slow');
				//$('#content-list').unblock();
				
			  }
		});
		return false ;
	}
	<?php 
// Comment by -Pooja (No need to load the page on load for vadodara instance as it consumes time user will search the patient)
	/*
	 * if($this->Session->read('website.instance')!='vadodara'){?>
	 * load_list(); // page onload call
	 * refresh_list();
	 * <?php }
	 */
	?>
	load_list(); //auto load patient list 
	function refresh_list(){
		
		//for refreshing on count change
		//var countData= $('#patient-count').val();
		setInterval(function(){
			//Condition for not to refresh on search and future appointment 
			if($('#is_search').val()!='1'){
			countData = parseInt($('#patient-count').val());
			if(isNaN(countData))
				countData=0;
			// url=$('#patient-count').attr('url);
			$.ajax({
			   type : "POST",
		       url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "appointments_count", "admin" => false)); ?>",
		       context: document.body,
		       success: function( data ){
		           // do something with the data 
		           data = parseInt(data) ;
		           if(data != countData){ 
					   load_list(1);
				   }
		          // recursive(); // recurse
		       },
		       error: function(){
		          // recursive(); 
		       }
		   });}//end of if...
			   },20000);
		}

	   
	function loading(){
		 $('#content-list').block({ 
	        message: '<h1><img src="../theme/Black/img/icons/ajax-loader_dashboard.gif" /> Please Wait...</h1>', 
	        css: {            
	            padding: '5px 0px 5px 18px',
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#DDDDDD', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px',               
	            color: '#000',
	            'text-align':'left' 
	        },
	        overlayCSS: { backgroundColor: '#cccccc' } 
	    }); 
	}
	
	function onCompleteRequest(){
		$('#content-list').unblock(); 
	}
	 
	 
	$(document).ready(function (){ 
		
		
		$("#dateFrom").datepicker({
				showOn : "both",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					$(this).focus();
					 $('#patient-filter').val('');
					 $( "#patient_id" ).val('');
					$( "#seen-filter" ).trigger( "change" );
				}
		});
		$("#dateTo").datepicker({
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				 $('#patient-filter').val('');
				 $( "#patient_id" ).val('');
				$( "#seen-filter" ).trigger( "change" );
			}
	});
		 $("#patient-filter").keypress(function (){
			 $( "#patient_id" ).val('');
				});

			$("#patient-filter").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "testcomplete"/*,'OPD'*/,"admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){	
				$("#patient_id" ).val(ui.item.id);
				<?php if($this->Session->read('website.instance')=='vadodara'){ ?>
				var admission = ui.item.admission_type;
				var res = admission.split(" "); 
				var admission_type= res['0'];
				if(admission_type=="RAD"){
                 alert("Please Search This Patient in Radiology Patient's");
                 $("#patient-filter").val('');
                 return false;
				}
			   if(admission_type=="LAB"){
				 alert("Please Search This Patient in Laboratory Patient's");
				 $("#patient-filter").val('');
                 return false;
			    }
			    <?php }?>
				if($( "#patient_id" ).val() != ''){
					var patientName=ui.item.value;
					var name=patientName.split('-')[0];
					$('#patient-filter').val(name);
				   $( "#patient_id" ).trigger( "change" );
			     }			
		    },
		    messages: {
		         noResults: '',
		         results: function() {},
	   		},
		
		});
	

		 $(".active-menu-tabs").click(function(){  
		    	var tabClicked = $(this).attr("name");
		    	$(".child-tabs").hide();
		    	$("#"+tabClicked).fadeIn('slow');
		    	$(".active-menu-tabs").removeClass('active');
		    	$(this).addClass('active');
				

		        return false ;
			});
 
		 
		 $('.typeSelected').click(function(){
				if($(this).val()=='OPD'){
					url="<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "appointments_management","admin" => false)); ?>";
				}else if($(this).val()=='Rad'){
					url="<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "rad_management","admin" => false)); ?>";
				}else if($(this).val()=='Lab'){
					url="<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "lab_management","admin" => false)); ?>";
				}else if ($(this).val() === 'UniqueQR') { 
                    url = "<?php echo $this->Html->url(array('controller' => 'appointments', 'action' => 'uniqueqr_list', 'admin' => false)); ?>";
                }

				window.location=url;
			});

        // 		 $(document).ready(function () {
        //     $('.typeSelected').click(function () {
        //         let url = '';
        //         if ($(this).val() === 'UniqueQR') {
        //             url = "<?php echo $this->Html->url(array('controller' => 'appointments', 'action' => 'uniqueqr_list', 'admin' => false)); ?>";
        //         }
        
        //         if (url) {
        //             window.location = url; // Redirect to the URL
        //         }
        //     });
        // });

	});
 
 $(document).on('click','.setMultiApp',function(){
	currentId=this.id;
	patientID=currentId.split("_")[1];
	$.fancybox(
		    { 
					
		    	'autoDimensions':false,
		    	'width'    : '85%',
			    'height'   : '70%',
			    'autoScale': true,
			  	'transitionIn': 'fade',
			    'transitionOut': 'fade', 
			    'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200,				    
			    'type': 'iframe',
			    'helpers'   : { 
			    	   'overlay' : {closeClick: false}, 
			    	  },
			    'href' : "<?php echo $this->Html->url(array("controller" =>"Appointments","action" =>"set_multiple_appointment","admin"=>false)); ?>"+'/'+patientID,
	});
 $(document).scrollTop(0);
});
 $(document).ready(function () {
    $('#radio4').on('click', function () {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "loadPersons")); ?>',
            beforeSend: function () {
                $('#content-list').html('<p>Loading...</p>');
            },
            success: function (data) {
                $('#content-list').html(data);
            },
            error: function () {
                $('#content-list').html('<p>Failed to load data. Please try again later.</p>');
            }
        });
    });
});

	</script>