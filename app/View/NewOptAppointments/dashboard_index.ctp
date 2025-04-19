<?php  echo $this->Html->script(array('inline_msg','jquery.blockUI')); ?>
<?php
     echo $this->Html->script(array('jquery.fancybox-1.3.4','animsition.js','animsition.min.js'));
	 echo $this->Html->css(array('jquery.fancybox-1.3.4.css','animsition.css','animsition.min.css'));
	 echo $this->Html->css(array('media_style.css'));?>
<style>

/*#msg {color: #666666;display:none; position:absolute; z-index:200; background:url(../../img/msg_arrow.gif) left center no-repeat; padding-left:7px}
#msgcontent {display:block; background:#f3e6e6; border:2px solid #924949; border-left:none; padding:5px; min-width:150px; max-width:250px}*/
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
	width: 39px;
	font-weight: bold;
}

.table_format {
    padding: 4px !important;
}
.textAlign {
	text-align: left;
	font-size: 12px;
	padding-right: 0px;
	padding-left: 0px;
}
.under a{text-decoration:underline;padding:2px 0px;}
.inner_title1 h3{
	background: rgba(0, 0, 0, 0) url("../img/color_strip_header.png") repeat-x scroll right bottom;
	color: #31859c;
    font-size: 40px;
    margin: 0px;
    padding-top: 5px;
}
</style>
 <?php if($this->params->query['type']=='dashboard'){
 	$inner_title = 'inner_title1';
 }else{
	$inner_title = 'inner_title';
}?>
<div class="<?php echo $inner_title;?>" >
	<h3>
		&nbsp;
		<?php echo __('OR Dashboard', true); ?>
	</h3>
	<span><?php echo $this->Html->link('Operation Notes',array('controller'=>'OptAppointments','action'=>'operative_notes'),array('escape'=>false,'class'=>'blueBtn'));
	
	echo $this->Html->link('Anaethesia Notes',array('controller'=>'Anesthesias','action'=>'anae'),array('escape'=>false,'class'=>'blueBtn'));?></span>
	<?php /* ?>
	<span style="float: right; margin: -24px 0; padding: 0"> <?php echo $this->Html->link(__('Search'), array('controller' => 'OptAppointments', 'action' => 'search'), array('escape' => false,'class'=>'blueBtn'));
	?>  <?php echo $this->Html->link(__('Preference Card'), array('controller' => 'Preferences', 'action' => 'user_preferencecard','null','OR'), array('escape' => false,'class'=>'blueBtn'));
		?> <?php
	//	echo $this->Html->link(__('Search OR Appointment'), array('controller' => 'OptAppointments', 'action' => 'search_otevent'), array('escape' => false,'class'=>'blueBtn'));
		?> <?php
		echo $this->Html->link(__('OR Item Requisition'), array('controller' => 'opts', 'action' => 'ot_replace_list'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	<?php */ ?>
</div>
<?php 
$role = $this->Session->read('role');

?>
 <?php if($this->params->query['type']=='dashboard'){?>
<body class="animsition">

<?php }?>

<div class="dashboardDiv">
<?php echo $this->Form->create('OptAppointment',array('url'=>array('controller'=>'NewOptAppointments','action'=>'dashboard','excel','admin'=>false),'id'=>'app-form')); 
		//echo $this->Form->create('OptAppointment','URL'=>array('controller'=>'NewOptAppointments','action'=>'dashboard','id'=>'app-form')); ?>
<?php if($this->params->query['type']!='dashboard'){?>
<table align="center" style="margin-top: 5px;"  class="formFull">
	<tr>
		
		<td><?php 
		if(strtolower($role)==strtolower(Configure::read('adminLabel'))) {
						echo "Select Surgeon:" ;
						echo $this->Form->input('surgeons',array('empty'=>'All Surgeons','type'=>'select','options'=>$doctorlist,'class'=>'all-surgeons','id'=>"all-surgeons",
								'autocomplete'=>'off','label'=>false,'div'=>false,'style'=>'width:150px;'));
						$this->Js->get('#all-surgeons');
						$this->Js->event(
								'change',
								$this->Js->request(
										array('action' => 'dashboard',),
										array('method'=>'GET','dataExpression'=>true,'data'=> $this->Js->serializeForm(
												array(
														'isForm' => false,
														'inline' => true
												)
										),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
								)
						);
		
					}
					echo $this->Form->input('OptAppointment.Seen',array('empty'=>'surgeons','type'=>'checkbox','class'=>'seen-filter','id'=>"seen-filter",
							'autocomplete'=>'off','label'=>false,'div'=>false));
					echo "Show Completed ";
					
		
			?></td>
		<td ><?php 
						echo $this->Form->input('future',array('empty'=>'surgeons','type'=>'checkbox','class'=>'future-filter','id'=>"future-filter",
								'autocomplete'=>'off','label'=>false,'div'=>false));
						echo "Future";
						$this->Js->get('#seen-filter,#future-filter');
						$this->Js->event(
								'change',
								$this->Js->request(
										array('action' => 'dashboard',),
										array('method'=>'GET','dataExpression'=>true,'data'=> $this->Js->serializeForm(
												array(
														'isForm' => false,
														'inline' => true
												)
										),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
								)
						);
						

				?></td>
			<td >
				<?php echo $this->Html->link("Today's OT Appoinment ","javascript:void(0)",array('escape'=>false,'onclick'=>"load_list();"));?>
			</td>
			<td>
			<?php echo $this->Form->input('patient_name',array('type'=>'text','class'=>'patient-filter','id'=>"patient-filter",
												'autocomplete'=>'off','label'=>false,'div'=>false,'placeholder'=>'Patient Name Search'));
						echo $this->Form->hidden('patient_id',array('id'=>'patient_id'));?>
			<?php 
					$this->Js->get('#patient_id'); 
					$this->Js->event('change',$this->Js->request(
									array('action' => 'dashboard'),
									array('method'=>'GET','dataExpression'=>true,'data'=> $this->Js->serializeForm(array(
																						                        'isForm' => false,
																						                        'inline' => true
																						                    )),
									'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
							)
					);
			?>
			</td>
			
			<td class="tdLabel search_icon" id="search-box">
					<!--<label>Date From:</label>-->
					<?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",
											'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From'));?>
					<!--<label>Date To:</label>-->
					<?php  echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",
							'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To'));
					//echo "Show Completed ";
			
				echo '&nbsp; &nbsp;'.$this->Html->image('icons/views_icon.png',array('id'=>'selectedDate'));?>
				<script>
				$('#selectedDate').click(function(){ 
					//$('#patient-filter').val('');
					//$('#patient_id').val('');
					//$('#future-filter').removeClass('active');
					//$('#todays-filter').removeClass('active');
					//$('#myPatient-filter').removeClass('active');
					//$('#viewAll-filter').removeClass('active');
					//$('#physician_tab').removeClass('active');
					});</script>
					<?php 
						$this->Js->get('#selectedDate'); 
						$this->Js->event('click',$this->Js->request(
										array('action' => 'dashboard',),
										array('method'=>'GET','dataExpression'=>true,'data'=> $this->Js->serializeForm(
												array(
														'isForm' => false,
														'inline' => true
												)
										),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
								)
						);?>
			</td>
			
   <td><?php echo $this->Html->link(__('Preference Card'), array('controller'=>'Preferences','action' => 'user_preferencecard','admin'=>false), array('escape' => false,'class'=>'blueBtn'));?> </td>
   <td>
   <?php echo $this->Form->button('Excel',array('type'=>'submit','name'=>'excel','class'=>'blueBtn'));
   //echo $this->Html->image('icons/excel.png',array('id'=>'excelID','escape'=>false,'title' => 'Export To Excel',"onclick"=>"SelectExcel('excel');"));
   //echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>$this->params->controller,'action'=>'dashboard','excel','?'=>$qryStr),array('escape'=>false,'title' => 'Export To Excel','style'=>"float:right !important;"));?>
			</td>
	</tr>
	
</table>
<?php }?>
<?php echo $this->Form->end();
echo $this->Js->writeBuffer();?>
</div>
<div id="content-list"></div>

<script>
var type = "<?php echo $this->params->query['type']; ?>";
if(type=='dashboard'){
	function load_list(){
		//$("#content-form").reset();
		$('#app-form')[0].reset();
		//$('#content-form').find('form')[0].reset();               		
		$.ajax({
		  type : "GET",
		  url: "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "dashboard_index_page_four","admin" => false)); ?>",
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
		return false ;
	}
}else{
	function load_list(){
		//$("#content-form").reset();
		$('#app-form')[0].reset();
		//$('#content-form').find('form')[0].reset();               		
		$.ajax({
		  type : "GET",
		  url: "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "dashboard","admin" => false)); ?>",
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
		return false ;
	}
}
load_list(); // page onload call 
function loading(){
	 $('#content-list').block({ 
        message: '<h1><img src="../theme/Black/img/icons/ajax-loader_dashboard.gif" /> Initializing...</h1>', 
        css: {            
            padding: '5px 0px 5px 18px',
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#fffff', 
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


jQuery(document).ready(function(){ 
	
	
 
});
 
$("#dateFrom").datepicker({
	showOn : "button",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	onSelect : function() {
		$(this).focus();
		 //$('#patient-filter').val('');
		// $( "#patient_id" ).val('');
		//$( "#seen-filter" ).trigger( "change" );
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
	// $('#patient-filter').val('');
	// $( "#patient_id" ).val('');
	//$( "#seen-filter" ).trigger( "change" );
}
});
	
$("#patient-filter").keypress(function (){
	 $( "#patient_id" ).val('');
});
/* $("#patient-filter").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Patient",'id',"lookup_name",'is_discharge=0','person_id',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'patient-filter,patient_id',
	onItemSelect:function () {
		if($( "#patient_id" ).val() != '');
		$( "#patient_id" ).trigger( "change" );
	}
});*/

$( "#patient-filter" ).autocomplete({
	 source: "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "opt_autocomplete","admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 select: function( event, ui ) { 
		$('#patient_id').val(ui.item.id);
		if(ui.item.id != '');
		$( "#patient_id" ).trigger("change");
	 },
	 messages: {
	        noResults: '',
	        results: function() {},
	 }
});

$(document).on('change',".status",function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	id = splittedVar[1]; 	//appointment ID 
	currentValue = $(this).val();	
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => 'NewOptAppointments', "action" => "update_appointment_status","admin" => false)); ?>/"+id+"/"+currentValue,
		  context: document.body,	   
		  beforeSend:function(){
		    // this is where we append a loading image
		   //loading();	
		   inlineMsg(currentId,'Updating Status..',false);			   
		  }, 	  		  
		  success: function(data){
			  load_list();
		  }
		  
	});
});
//BOF Mahalaxmi-Only For Export Report
function SelectExcel(excel){	
			if(excel=='excel'){
			//var formData = $('#app-form').serialize();
			//console.log(formData);
			
			//console.log(getStr);
			//var currentURL = window.location.href;	
		
				//$("#app-form").attr("action", "/dashboard/"+ excel);
				$( "form").submit();	
				
				 $('#app-form').attr('action', "/dashboard").submit();
				// var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "dashboard","admin" => false)); ?>"+"/"+excel;
				// window.location.href =ajaxUrl;	
				// window.reload();
				//e.preventDefault();
				 // var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "dashboard","admin" => false)); ?>"+"/"+excel+"/"+formData;
				 //window.location.href =ajaxUrl;	
				 //$( "#app-form" ).submit();
			}
}

$(document).ready(function(){
	var type = "<?php echo $this->params->query['type']; ?>";
	if(type == "dashboard"){
		$(".animsition").animsition({
		    inClass: 'fade-in-down-lg',
		    outClass: 'fade-out-down-lg',
		    inDuration: 1500,
		    outDuration: 800,
		    linkElement: '.animsition-link',
		    // e.g. linkElement: 'a:not([target="_blank"]):not([href^=#])'
		    loading: true,
		    loadingParentElement: 'body', //animsition wrapper element
		    loadingClass: 'animsition-loading',
		    loadingInner: '', // e.g '<img src="loading.svg" />'
		    timeout: false,
		    timeoutCountdown: 5000,
		    onLoadEvent: true,
		    browser: [ 'animation-duration', '-webkit-animation-duration'],
		    // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
		    // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
		    overlay : false,
		    overlayClass : 'animsition-overlay-slide',
		    overlayParentElement : 'body',
		    transition: function(url){ window.location.href = "<?php echo $this->Html->url(array('controller'=>'NewOptAppointments','action'=>'dashboard_index_page_four')); ?>"; }
		});
		 setTimeout(function () {    
		    //window.location.href = "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "patientWaitingList", '?'=>array('type'=>'dashboard'))); ?>"; 
		},8000);
	}
});

//EOF Mahalaxmi-Only For Export Report
</script>
