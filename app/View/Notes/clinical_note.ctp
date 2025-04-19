<?php
     echo $this->Html->script(array('jquery.fancybox.js','jquery.tooltipster.min.js','inline_msg','topheaderfreeze','jquery.blockUI'));
	 echo $this->Html->css(array('jquery.fancybox','tooltipster.css')); ?>
<?php $website = $this->Session->read('website.instance');?>
<style type="text/css">
    .Title
    {
        display: table-caption;
        text-align: center;
        font-weight: bold;
        font-size: larger;
    }
    .Heading
    {
        display: table-row;
        font-weight: bold;
        text-align: center;
    }
    .Row
    {
        display: table-row;
    }

.Cell{
	float:left;
    padding: 10px;
   }
.selected{
	background-color : #ffe339;
}
.rightTopBg {
    padding: 0 20px!important;
   
}
 .Menu img{
 	width : 50px;
 	height :50px;
 	color:white !important;
 	/* margin-left:5px; */ 
 } 
/*EOD css adde by pankaj*/
 /*css added for patient details box adde by pankaj*/
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
 #patientSearch{
 	display: none;
    position: absolute;
    right: 0;
    left:992px;
    top: 34px;
    z-index: 29;
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #000000;
    border-radius: 3px;
    box-shadow: 0 0 3px 2px #000;
    margin-top: -1px;
    padding: 6px;
    width: 250px;
    font-size:13px;
    list-style-type: none;
    
}
 
/*doctor templates*/
.row_format a{
	font-size:11px !important ;
}
/*EOF doctor templates*/
 
 .row_format th{
 	background: #d2ebf2 none repeat scroll 0 0 !important;
    border-bottom: 1px solid #3e474a;
    color: #31859c !important;
    font-size: 12px;
    padding: 3px;
    text-align: left;
 }
 .row_format td{
 	padding: 1px;
 }
 
.row_format tr:nth-child(even) {background: #CCC}
.row_format tr:nth-child(odd) {background: #e7e7e7}

</style>
<!-- Tabs css  -->

<!-- Patient header -->
 <!-- Header Menu-->
<div>
	<div class="Row inner_title" style="float: right; width: 100%;">
	<?php if(!empty($getBasicData)){?>
		<div style="font-size: 30px; font-family: verdana; color: darkolivegreen;float: left;padding-top: 26px" >			 
			<?php echo $getBasicData['Patient']['lookup_name']." - ".$getBasicData['Patient']['patient_id'] ;?>
			<?php echo '&nbsp;'.$this->Html->image('icons/user_info.png',array('id'=>'userInfo', 'style'=>'float:none; height: 30px; margin-bottom: 5px; width: 30px;')); ?>
			<!-- <span style="padding-right:10px;float:right;padding-top: 10px" id="adminSearch">
				<?php //echo $this->Form->input('addmission_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'addmissionId', 'class'=>''));
				//echo $this->Form->hidden('patient_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'patientId', 'class'=>''));?> 
			</span>  -->
			<ul style="display: none;" id="patient-info-box">
				<li style="float: right"><?php  
						if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$this->Session->read('person_photo')) && ($this->Session->check('person_photo'))){
							echo $this->Html->image("/uploads/patient_images/thumbnail/".$this->Session->read('person_photo'), array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>$title));
						}else{
							echo $this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>$title));
						}				
					?>
				</li>
				<li>Name : <?php echo $getBasicData['Patient']['lookup_name'];?></li>
				<li>Gender/Age : <?php echo ucfirst($getBasicData['Patient']['sex']).'/'.$getCurrentAge ;?></li>  
				<li>MRN : <?php echo $getBasicData['Patient']['admission_id'] ;?></li>
				<li>PatientId : <?php echo $getBasicData['Patient']['patient_id'] ;?></li>
				<li>Admission Date : <?php echo $this->DateFormat->formatDate2Local($getBasicData['Patient']['form_received_on'],Configure::read('date_format'),true);?></li>
				<li>Tariff : <?php echo $getBasicData['TariffStandard']['name'];?></li>
				<?php 
				 if($patient['Patient']['admission_type']=='IPD') {?>
					<li>Ward/Bed : <?php echo $wardInfo['Ward']['name']."/".$wardInfo['Room']['bed_prefix']." ".$wardInfo['Bed']['bedno'];?></li>
				<?php }?>
			</ul>
		</div>
		<?php }?>
		<div id="alertMsges" style="float:left;padding-top: 26px;padding-left:10%"></div>
		<div style="padding-right:10px;float:right;padding-top: 26px" id="adminSearch">
			<?php echo $this->Form->input('addmission_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'addmissionId', 'class'=>'','placeHolder'=>'Search Patient'));
				  echo $this->Form->hidden('patient_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'patientId', 'class'=>''));
				  echo $this->Form->hidden('appointment_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'appId', 'class'=>''));
				  echo $this->Form->hidden('note_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'noteId', 'class'=>''));
			?>
			<?php echo '&nbsp;'.$this->Html->image('icons/patient.png',array('id'=>'patientIcon', 'style'=>'float:none; height: 30px; margin-bottom: 5px; width: 30px;','title'=>'Scheduled Patient')); ?>
		</div>
		
	</div>
		<table class="row_format" id="patientSearch" style="display: none;">
			<?php 
			if(!empty($currentDayAppointment)){
			foreach ($currentDayAppointment as $key =>$val){ ?>
				<tr>
					<td><?php echo $this->Html->link($val['Patient']['lookup_name']."-".$val['Patient']['patient_id'],"javascript:void(0)",array('class'=>'docSigned doc_clicked','id'=>'docSigned_'.$val['Appointment']['id'].'_'.$val['Patient']['id'].'_'.$val['Note']['id'],'escape'=>false ,'title'=>'Scheduled Patients')) ; 
					    ?></td>
				</tr>
				<?php } 
				}else{?>
					<tr><td><font color="red"><?php echo __("No Appointment Scheduled");?></font></td></tr>
				<?php }?>
		</table>
</div>
<div class="Table" style="float: left; width: 7%; background: white; min-height: 30px !important; margin: 10px 10px 10px 8px;">
	<div class="" style="float: left; width: 100%">
		<div class="Cell" id="cell_ChiefComplaint">
			<?php echo $this->Html->image('icons/soap_chief_complaint.png',array( "class"=>"Menu tooltip",'title'=>'Chief Complaint','id'=>'ChiefComplaint','escape'=>false,'style'=>'width="50px" height="50px"'))  ;?>
		</div>
		<div class="Cell" id="cell_AllServices">
			<?php echo $this->Html->image('icons/soap_mri.png',
	     		array(  "class"=>"Menu tooltip",'title'=>'Add Services','id'=>'AllServices','escape'=>false,'style'=>'width="50px" height="50px"')) ?>
		</div>
		<div class="Cell" id="cell_Prescriptions">
			<?php echo $this->Html->image('icons/soap_prescription.png',array( "class"=>"Menu tooltip",'title'=>'Prescription','id'=>'Prescriptions','escape'=>false,'style'=>'width="50px" height="50px"'))  ;?>
		</div>
		<div class="Cell" id="cell_vitals">
			<?php echo $this->Html->image('icons/soap_provisional_diagnosis.png',array( "class"=>"Menu tooltip",'title'=>'Vitals','id'=>'vitals','escape'=>false,'style'=>'width="50px" height="50px"'))  ;?>
		</div>
		<div class="Cell" id="cell_ClinicalHistory">
			<?php echo $this->Html->image('icons/soap_clinical_history.png',array( "class"=>"Menu tooltip",'title'=>'Clinical History','id'=>'ClinicalHistory','escape'=>false,'style'=>'width="50px" height="50px"')) ;?>

		</div>
		<div class="Cell" id="cell_PreviousNotes">
			<?php echo$this->Html->image('icons/note-edit-icon.png',array( "class"=>"Menu tooltip",'title'=>'Previous Notes','id'=>'PreviousNotes','escape'=>false,'style'=>'width="50px" height="50px"')) ;?>
		</div>

	<!--<div class="Cell">        
	     <?php echo $this->Html->link($this->Html->image('icons/soap_laboratory.png'),"javascript:void(0)",
	     		array("class"=>"Menu tooltip",'title'=>'Laboratory','escape'=>false,'id'=>'Pathology')) ; ?>
     		 <p>Laboratory</p> 
     </div>
     <div class="Cell"  > 
     <?php echo $this->Html->link($this->Html->image('icons/soap_radiology.png'),
     		"javascript:void(0)",array( "class"=>"Menu tooltip",'title'=>'Radiology','id'=>'Radiology','escape'=>false)) ;?>
     		  <p>Radiology</p> 
     </div> -->
		<!-- <div class="Cell" >
     <?php echo $this->Html->image('icons/soap_allergy.png',array( "class"=>"Menu tooltip",'title'=>'Allergy','id'=>'Allergy','escape'=>false)); ?>
     </div> -->
		<!--  <div class="Cell" style="width: 74px">
     <?php echo $this->Html->link($this->Html->image('icons/soap_provisional_diagnosis.png')
     		,"javascript:void(0)",array(  "class"=>"Menu tooltip",'title'=>'Prov. Diagnosis','id'=>'ProvDiagnosis','escape'=>false));?>
     </div> -->

	</div>
</div>
<!-- Header Menu Eod-->
<div>
	<div style="float:right; width:91%">
		<!-- container-->
		        <div class="Cell" id="loadArea" style="width:100%">&nbsp;

					<table width="20%" id="patientList" style="display: none;float: right" class="row_format">
						<?php 
						if(!empty($currentDayAppointment)){
							foreach ($currentDayAppointment as $key =>$val){?>
								<tr>
									<td><?php echo $this->Html->link($val['Patient']['lookup_name']."-".$val['Patient']['patient_id'],"javascript:void(0)",array('class'=>'docSigned doc_clicked','id'=>'docSigned_'.$val['Appointment']['id'].'_'.$val['Patient']['id'].'_'.$val['Note']['id'],'escape'=>false ,'title'=>'Scheduled Patient')) ; 
									?>
									</td>
								</tr>
								<?php } 
							}?>
					</table>
		   </div>
		<!-- container Eod-->
	</div>	
</div>
<!-- EOD -->
<script type="text/javascript"> 

$(document).ready(function () {
	var patientId="<?php echo $this->params->pass[0];?>";
	if(patientId==''){
		$("#patientList").show();
	}
	
	$('.tooltip').tooltipster({
 		interactive:true,
 		position:"right", 
 	});

 	var isSaveHistory="<?php echo $this->params->query['isSaveHistory'];?>";
 	if(isSaveHistory=='yes'){
 		ajaxLoadHistoryData();
 	 	}

 	
});

jQuery(document).ready(function() {

    jQuery('.Menu').on('click', function(e)  {
		  e.preventDefault();

		$('.Cell').removeClass('selected');
		
		var patientId="<?php echo $this->params->pass[0];?>";
		if(patientId==''){
			$('#addmissionId').focus();
				alert("Please Select Patient Name");
			return false;
		}else{
    	    var currentAttrValue=$(this).attr('id');
    	
    		if(currentAttrValue=="AllServices"){
    			$("#cell_AllServices").addClass('selected');
	        	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "notes", "action" => "ajax_add_all_services",$patientId,$noteId,$appointmentId)); ?>";
	        }
	        else if(currentAttrValue=="ChiefComplaint"){
	        	 $("#cell_ChiefComplaint").addClass('selected');
	        	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "notes", "action" => "loadCc",$patientId,$noteId,$appointmentId)); ?>";
	        }
	        else if(currentAttrValue=="Prescriptions"){
	        	 $("#cell_Prescriptions").addClass('selected');
	        	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addMedication")); ?>"
	    		+'/'+ '<?php echo $patientId?>'+'/'+null+'/'+null+'/'+null+'/'+'<?php echo $noteId?>'+'/'+'?ajaxFlag=Yes' ;
	        }
	         else if(currentAttrValue=="vitals"){
	        	$("#cell_vitals").addClass('selected');
	        	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "ajax_vital",$patientId,$noteId,$appointmentId)); ?>";
	        }
                else if(currentAttrValue=="ClinicalHistory"){
	        	$("#cell_ClinicalHistory").addClass('selected'); 
	        	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "significantHistory",$patientId,$getBasicData[Patient][person_id],$appointmentId,$noteId)); ?>";
	        }
	        else if(currentAttrValue=="PreviousNotes"){
	        	$("#cell_PreviousNotes").addClass('selected');
	        	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "previousSoapNotes",$patientId,$noteId,$appointmentId)); ?>";
	        }
	        else{
		        return false;
	        }
	        $.ajax({
	         	beforeSend : function() {
	         		loading('loadArea','id');
	         	},
	         	type: 'POST',
	         	url: ajaxUrl,
	         	dataType: 'html',
	         	success: function(data){
	         		onCompleteRequest('loadArea','id');
	         		$('#loadArea').html('');
	         		$('#loadArea').html(data);
	      	       }
	      	  });	
	     }
    });
 
});


$('#ClinicalHistory').click(function(){
	var patientId="<?php echo $this->params->pass[0];?>";

	if(patientId==''){
		alert("Please Select Patient Name");
		$('#addmissionId').focus();
		return false;
	}else{
            /*$.fancybox({
                    'autoDimensions': false, 
                    'height': 1200,
                    'width':  1200,
                    'transitionIn' : 'fade',
                    'transitionOut' : 'fade',
                    'type' : 'iframe',
                    'hideOnOverlayClick':false,
                    'showCloseButton':true,
                    'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "significantHistory")); ?>"+'/<?php echo $patientId ?>'+'/<?php echo $getBasicData[Patient][person_id] ?>'+'/<?php echo $appointmentId ?>'+'/'+'?ajaxFlag=Yes', 
                    'onClosed':function(){
                    } 				
                }); */
            }
	});



 /*js code for patient details box added by pankaj*/
 $(document).ready(function(){
	 var timer=setInterval(
		    	function () {
	    	    	$('#patient-info-box').hide();
	    }, 10000);
	    $('#userInfo').click(function(){		     
			  var pos = 	$(this).position();		    
			  var cc = $('#patient-info-box');//top: 40px; left: 1215px;
			  cc.css('top',pos.top+30); 
			  cc.css('left',pos.left-200); 
			  cc.css('right',pos.right);
			 cc.show();  
			 clearInterval(timer);  
		});
	    $('#userInfo').mouseout(function(){ 
	    	timer=setInterval(
	    	    	function () {
	        	    	$('#patient-info-box').hide();
	        }, 10000);    	
		});		
	    $("#patient-info-box,#userInfo").click(function(t) {
	        t.stopPropagation();
	    }),$("#userInfo").click(function() {
	        $("#patient-info-box").show();
	    }), $("html").click(function() {
	    	$("#patient-info-box").hide() ;
	    }); 
	        
 });

function ajaxLoadMedication(){
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addMedication")); ?>"
	+'/'+ '<?php echo $patientId?>'+'/'+null+'/'+null+'/'+null+'/'+'<?php echo $noteId?>'+'/'+'?ajaxFlag=Yes' ;	
	$.ajax({
    	beforeSend : function() {
    		$('#busy-indicator').show('fast');
    	},
    	type: 'POST',
    	url: ajaxUrl,
    	dataType: 'html',
    	success: function(data){
     		$('#busy-indicator').hide('fast');
     		$('#loadArea').html('');
     		$('#loadArea').html(data);
    },
	});
}

// reload all service list
function ajaxAllServiceList(){
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "ajax_add_all_services",$patientId,$noteId,$appointmentId)); ?>";
	$.ajax({
		beforeSend : function() {
			$('#busy-indicator').show('fast');
		},
		type: 'POST',
		url: ajaxUrl,
		dataType: 'html',
		success: function(data){
			
	 		$('#busy-indicator').hide('fast');
	 		$('#loadArea').html('');
	 		$('#loadArea').html(data);
	},
	});
}

/*code for current day patient listing box & patient Search added by Atul*/
$(document).ready(function(){
	 var timer=setInterval(
		    	function () {
	    	    	$('#patientSearch').hide();
	    }, 1000000000);
	    $('#patientIcon').click(function(){		     
			  var pos = 	$(this).position();		    
			  var cc = $('#patientSearch');//top: 40px; left: 1215px;
			  cc.css('top',pos.top+45); 
			  cc.css('left',pos.left-224); 
			  cc.css('right',pos.right);
			  cc.show();  
			  clearInterval(timer);  
		});
	    $('#patientIcon').mouseout(function(){ 
	    	timer=setInterval(
	    	    	function () {
	        	    	$('#patientSearch').hide();
	        }, 10000);    	
		});		
	    $("#patientSearch,#patientIcon").click(function(t) {
	        t.stopPropagation();
	    }),$("#patientIcon").click(function() {
	        $("#patientSearch").show();
	    }), $("html").click(function() {
	    	$("#patientSearch").hide() ;
	    }); 
	        
});

$(".docSigned").click(function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");	
	apptId=splittedVar[1];
	ptId=splittedVar[2];
	noteId=splittedVar[3];
	var status='In-Progress';
	var noteIdStr;	
	
	if(noteId=='' || noteId=='undefined'){	
		noteIdStr="/"+ptId+"/"+apptId;			
	}else{
		noteIdStr="/"+ptId+"/"+apptId+"/"+noteId;
	}
	var field='status';
	var obj = $(this) ;
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "update_appointment_status", "admin" => false)); ?>"+"/"+status+"/"+field,
		  context: document.body,
		  data:"id="+apptId,	
		  beforeSend:function(){
			// $('#busy-indicator').show('fast');
		  }, 	  		  
		  success: function(data){
			  var url = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "clinicalNote", "admin" => false)); ?>"+noteIdStr;
			  $('#busy-indicator').hide('fast');
			  window.location.href = url;
			  
		  }
	});
});

$("#addmissionId").autocomplete({
    source: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "appointmentAutocomplete","no",'is_discharge=0',"admin" => false,"plugin"=>false)); ?>", 
	setPlaceHolder : false,
	select: function(event,ui){
		$("#patientId" ).val(ui.item.id);
		$("#appId" ).val(ui.item.appointment_id);
		$("#noteId" ).val(ui.item.note_id);

		apptId=ui.item.appointment_id;
		ptId=ui.item.id;
		noteId=ui.item.note_id;
		var status='In-Progress';
		var noteIdStr;	
		 
		if(noteId=='' || noteId=='undefined' || noteId == null){	
			noteIdStr="/"+ptId+"/"+apptId;			
		}else{
			noteIdStr="/"+ptId+"/"+apptId+"/"+noteId;
		}
		var field='status';
		var obj = $(this) ;
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "update_appointment_status", "admin" => false)); ?>"+"/"+status+"/"+field,
			  context: document.body,
			  data:"id="+apptId,	
			  beforeSend:function(){
				 $('#busy-indicator').show('fast');
			  }, 	  		  
			  success: function(data){				
				  var url = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "clinicalNote", "admin" => false)); ?>"+noteIdStr;
				  $('#busy-indicator').hide('fast');
				  window.location.href = url;
				  
			  }
		});
    		
},
 messages: {
     noResults: '',
     results: function() {},
}
});
// reload vital page
function ajaxVitalList(){
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "ajax_vital",$patientId,$noteId,$appointmentId)); ?>";
	$.ajax({
		beforeSend : function() {
			loading('vitalList','id');
		},
		type: 'POST',
		url: ajaxUrl,
		dataType: 'html',
		success: function(data){
			onCompleteRequest('vitalList','id');
	 		$('#loadArea').html('');
	 		$('#loadArea').html(data);
	},
	});
}
function ajaxLoadHistoryData(){
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "significantHistory",$patientId,$getBasicData['Patient']['person_id'],$appointmentId,$noteId)); ?>";
	$.ajax({
		beforeSend : function() {
			loading('loadArea','id');
		},
		type: 'POST',
		url: ajaxUrl,
		dataType: 'html',
		success: function(data){
			onCompleteRequest('loadArea','id');
	 		$('#loadArea').html('');
	 		$('#loadArea').html(data);
	},
	});
}

</script>
 <!-- Jscript for Tabs  EOD  -->