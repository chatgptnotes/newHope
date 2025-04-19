<?php
	echo $this->Html->script(array(/*'inline_msg','jquery.selection.js',*/'jquery.fancybox-1.3.4' ,'jquery.tooltipster.min.js','jquery.blockUI','jquery.contextMenu'));
	echo $this->Html->css(array('tooltipster.css','jquery.fancybox-1.3.4.css','jquery.contextMenu'));  
	//echo $this->Html->script('ckeditor/ckeditor');
  ?>
	  


<style>
.blueBtn0 {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: rgba(0, 0, 0, 0) linear-gradient(#B8FF94, #B8FF94) repeat scroll 0 0 !important;
    border-color: #1a5bb7 #1a5bb7 #589cb6;
    border-image: none;
    border-radius: 5px;
    border-style: solid;
    border-width: 1px;
    color: #000 !important;
    font-weight: normal;
    height: none !important;
    padding: 4px 10px;
    position: relative;
}
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
.common{height:20px; line-height:25px;padding: 0 !important;}

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
    width: 40px;
    font-weight: bold;
}
    
#search-box {
    border: 1px solid #DDEBF9 !important;
    padding-bottom:5px !important;
	padding-right:0px !important;
	/*width: 332px;*/
	float:left;
	margin-top:11px;
}   
.context-menu-three {
    float: left;
    margin:10px 0 0 0;
 }
 
.red {
	background: #D40001 !important;
	color: #fff !important;
	font-weight: bold;
	padding: 0;
}

.context-menu-item label{
padding: 0px;
text-align:left;
}

.context-menu-item.icon {
    background-position: 4px 2px;
    background-repeat: no-repeat;
    min-height: 35px;
}

</style>
<div class="inner_title">
	<h3> &nbsp; <?php echo __('External Radiologist Dashboard', true); ?></h3> 
</div>
<?php echo $this->Form->create('User',array('action'=>'patientDocDashboard','default'=>false,'id'=>'content-form'));?>
<table>
	<tr>
		<td>
			<?php   echo $this->Form->input('Patient Name',array('class'=>'patient-name','id'=>"patient-name",'label'=>false,
							'autofocus'=>'autofocus','autocomplete'=>'off','div'=>false));
					echo '</td><td>' ;
					echo $this->Form->button('Search',array('class'=>'blueBtn','id'=>"patient-search",
							'autocomplete'=>'off','div'=>false,'style'=> 'float:left;margin:0 10px 0 0;'));
					$this->Js->get('#all-doctors');
					$this->Js->event(
							'change',
							$this->Js->request(
									array('action' => 'patientDocDashboard',),
									array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
																						                    array(
																						                        'isForm' => true,
																						                        'inline' => true
																						                    )
																						                ),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
							)
					);
                   
					
					
			?>
		</td>
			<td class="tdLabel search_icon" id="search-box">
					<!--<label>Date From:</label>-->
					<?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",
											'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From'));?>
					<!--<label>Date To:</label>-->
					<?php echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",
							'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To'));
					//echo "Show Completed ";
			
			?>
			
			<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'radiologistDashboard'),array('escape'=>false, 'title' => 'refresh','style'=>'float:right'));
			echo '&nbsp; &nbsp;'.$this->Html->image('icons/views_icon.png',array('id'=>'selectedDate', 'style'=>'float:right','class'=>'selectedDate'));?>
			</td>
			<td> <?php echo $this->Html->link("Today's Requisition",'javascript:void(0)',array('class'=>'selectedDate blueBtn0','label'=> false, 'div' => false,'id'=>'todaysdate'));
			
			//echo $this->Html->link('PACS',array('controller'=>'Radiologies','action'=>'pacs'),array('class'=>'blueBtn','escape'=>false,'title'=>'Pacs','style'=>'text-align:right;margin-left:680px;'));?></td>
			
	
	</tr>
	
</table>
<?php echo $this->Form->end(); 
//} ?>
<!-- Table Position -->
<div id="content-list" >
</div>
<div class="clr ht5"></div>
  
<script>
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => 'PatientDocuments', "action" => "patientDocDashboard","admin" => false)); ?>",
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
			  url: "<?php echo $this->Html->url(array("controller" => 'PatientDocuments', "action" => "patientDocDashboard","admin" => false)); ?>",
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


	$("#seen-filter").click(function(){
		 var formData = $('#content-form').serialize();
		$.ajax({
			  type : "GET",
			  data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => 'PatientDocuments', "action" => "patientDocDashboard","admin" => false)); ?>",
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


	$(".selectedDate").click(function(){		
		var ids=$(this).attr('id');		
		if(ids=='todaysdate'){	
			var tran_date_from = '<?php echo $this->DateFormat->formatDate2Local(date("Y-m-d"),Configure::read('date_format'), false);?>';					
			var tran_date_to = '<?php echo $this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false);?>';
			$('#dateFrom').val(tran_date_from);
			$('#dateTo').val(tran_date_to);

		}
		
		var formData = $('#content-form').serialize();
		$.ajax({
			  type : "GET",
			  data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => 'PatientDocuments', "action" => "patientDocDashboard","admin" => false)); ?>",
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
			  url: "<?php echo $this->Html->url(array("controller" => 'PatientDocuments', "action" => "dashboard_update","level","admin" => false)); ?>"+"/"+patientId,
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

		//no need to update manually, it should be updated automatically
		return;
				 
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => 'PatientDocuments', "action" => "dashboard_update","status","admin" => false)); ?>"+"/"+patientId,
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
			  url: "<?php echo $this->Html->url(array("controller" => 'PatientDocuments', "action" => "dashboard_update","nurse","admin" => false)); ?>"+"/"+patientId,
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
			  url: "<?php echo $this->Html->url(array("controller" => 'PatientDocuments', "action" => "dashboard_update","doctor","admin" => false)); ?>"+"/"+patientId,
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
	/*$("#patient-name").autocomplete("<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'IPD',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});*/
	$('#patient-name').autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'no',"admin" => false,"plugin"=>false)); ?>",
				select: function(event,ui){			
				},
				 messages: {
		         noResults: '',
		         results: function() {},
		   		},
			});
/*	$("#patient-name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'IPD',"admin" => false,"plugin"=>false)); ?>",
		select: function(event,ui){	
			//$( "#patientId" ).val(ui.item.id);			
	},
	 messages: {
         noResults: '',
         results: function() {},
   },
	
	});*/
});



$("#dateFrom").datepicker
({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#dateTo").datepicker
 ({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});


	$(document).on('click',".doctor_tab",function(){
		currentId = $(this).attr('id') ;
		var obj = $(this) ;
		$("#doctor_id").val(currentId);
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "PatientDocuments", "action" => "patientDocDashboard", "admin" => false)); ?>",
			  context: document.body,
			  data:$("form").serialize(),
			  beforeSend:function(){
				  loading();
			  }, 	  		  
			  success: function(data){ 
				  onCompleteRequest();
				  $('#content-list').html(data).fadeIn('slow');
				  $(".doctor_tab").removeClass("active");
				  obj.addClass("active");
				 // obj.attr('src','../theme/Black/img/icons/green.png').attr('title','Medication Administered').removeClass('med');
			  }
			  
		});
	});
	
//Context Menu for My Physician Checkboxes
$(function(){
	$.contextMenu({
        selector: '.context-menu-three', 
        callback: function(key, options) {
        	if(key=='submit'){
		        var checked = $( "input[type='checkbox']" ).serialize().split("&");
		       
		        var docID = '';
		        //var docID = checked.join();
		        length = checked.length;
		        $.each(checked, function( index, value ) {
			       value=value.split("=");
			        if(index===(length-1)){
			            docID +=value[1];
			        }else{					        
			        	docID += value[1]+'_';
				        }
			        
		      	});	
		        
		      	if(docID=== "undefined"){
		      		docID='';
		      	}
			      	
		      $.ajax({
	  			  type : "GET",
	  			  url: "<?php echo $this->Html->url(array("controller" => "PatientDocuments", "action" => "patientDocDashboard", "admin" => false)); ?>",
	  			  context: document.body,
	  			  data:"doctorsId="+docID,
	  			  beforeSend:function(){
	  				$('#patient-filter').val('');
					$('#patient_id').val('');
					$('#dateFrom').val('');
					$('#dateTo').val('');						
	  				  loading();
	  			  }, 	  		  
	  			  success: function(data){ 
	  				$('#todays-filter').removeClass('active');
					$('#future-filter').removeClass('active');
					$('#myPatient-filter').removeClass('active');
					$('#viewAll-filter').removeClass('active');
					$('#physician_tab').addClass('active');
					$('#closed-filter').removeClass('active');
					$('#list_tab').hide();
	  				  onCompleteRequest();
	  				  $('#content-list').html(data).fadeIn('slow');
	  			  }
	  			  
	  		});
	        	 return true;
		        
	        }
      },
       items: {
    	   "select_all":{name:"Select All", type:"checkbox",icon: "select", value:"0"},
    	   "sep2":"<br>",   
          <?php foreach($doctors as $key=>$doctor){?>
	       <?php echo $key;?> : {name: "<?php echo $doctor ;?>",
		       					type: 'checkbox',
		       					icon: "<?php echo $key?>",
			       				value:"<?php echo $key?>"},
            <?php  }?>
            "sep":"----------",
            "submit":{name:"<b>Submit</b>"},
       },
        events: {
            show: function(opt) {
                // this is the trigger element
                var $this = this;
                // import states from data store 
                $.contextMenu.setInputValues(opt, $this.data());
               // this basically fills the input commands from an object
                // like {name: "foo", yesno: true, radio: "3", …}
              //  console.log(opt.$menu);
                /*opt.$menu.find('.context-menu-item').attr('title', function() { 
	                console.log(this);
	                return $(this).text(); 
                  });*/
                 
                <?php foreach($doctors as $key=>$doctor){?>
 		       			var id= <?php echo $key?>; 
 		       		 $('.icon-'+id).find('span').attr('id','doctorMenu_'+id);
 		       			//selectedDoctors.pop(id);
 		       			//$('#doctorMenu_'+id).css('color','black');
 	            <?php  }?>
 	           $('.icon-select').find('span').attr('id','checkAll');
 	          $('.icon-select').find('span').css('color','red'); 
 	        }, 
            hide: function(opt) {
                // this is the trigger element
                var $this = this;
                // export states to data store
                 $.contextMenu.getInputValues(opt, $this.data());
                 
              	// window.console && console.log(opt, $this.data());
                // this basically dumps the input commands' values to an object
                // like {name: "foo", yesno: true, radio: "3", …}
            }
        }
    });
	$('.context-menu-three').on('click', function(e){
        console.log('clicked', this);
    });
});

$(document).on( 'click','.icon-select',function(){  
	
	  isChecked = $('.icon-select label input').prop('checked') ; ///check if select all is clicked or not
	  $('.context-menu-item label input').each(function (val,obj) { 
		  if(isChecked)		   
	       	  $(obj).prop('checked',true);
		  else
			  $(obj).prop('checked',false); 
	  }); 
});

$( document ).ready(function () {
	$('.tooltip').tooltipster({
 		interactive:true,
 		position:"right", 
 	});
 	});

</script>
