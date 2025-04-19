<?php 
//echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
//echo $this->Html->script(array('jquery.fancybox-1.3.4'));

?>

<style>
.patientTd{
background-color:#9a9898;

}
.medical_records_menu
{
	list-style-type:none;
	margin:1;
	padding:1;
	overflow:hidden;
	
}
.medical_records_menu li
{
	float:left;
	width:18%;
}
.medical_records_menu a:link
{
	display:block;
	font-weight:bold;
	font face:"Arial Rounded MT Bold"
	color:#FFFFFF;
	background-color:#9a9898;
	text-align:center;
	padding:4px;
	text-decoration:none;
	text-transform:uppercase;
	background-color:#454545;
}
.medical_records_menu a:hover,a:active
{
	background-color:#9a9898;
}
</style>
<div class="inner_title">
	<h3><img src="images/appointment_icon.png" /> &nbsp; <?php echo __('Medical Records', true); ?></h3>
	<span></span>
</div>
<div style="width:100% ">
<ul class="interIcons">
<!-- Bof icons added by vikas -->
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/medication.png'),'#',array('onclick'=>"getMedications()",'class'=>"",'escape' => false,'label'=>'Medication' ));?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/diagnosis.png'),'#',array('onclick'=>"getProblems()",'class'=>"",'escape' => false,'label'=>'Diagnosis' ));?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/lab_result.png'),'#',array('onclick'=>"getLabResults()",'class'=>"",'escape' => false,'label'=>'Lab result' ));?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/Immunization.png'),'#',array('onclick'=>"getImmunizations()",'class'=>"",'escape' => false,'label'=>'Immunization' ));?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/allergy.png'),'#',array('onclick'=>"getAllergies()",'class'=>"",'escape' => false,'label'=>'Allergy' ));?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/quick-note.png'),'#',array('onclick'=>"getNotes()",'class'=>"",'escape' => false,'label'=>'Clinical Notes' ));?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/diagnosis.png'),'#',array('onclick'=>"getBloodGlucose()",'class'=>"",'escape' => false,'label'=>'Blood Glucose Log' ));?></li>


</ul>

</div>
<table width="90%" align="left" style="margin-left:20px;">
 
  <tr>
    <td colspan="5" id="updateContent"></td>
  </tr>
</table>
<div id="loading-indicator" style="display:none;padding-bottom:15px;"><?php echo $this->Html->image('/img/icons/loading-indicator.gif',array('alt'=>'Loading','title'=>'Loading'))?></div>
<div id="showAppointmentIndicator" style="float:right;margin-top:15px;"></div>
<script>
var getMedicationsURL = "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "patient_blood_glucoselog","admin" => false)); ?>";
var getProblemsURL = "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "patient_diagnosis","admin" => false)); ?>";
var getImmunizationsURL = "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "patient_immunization","admin" => false)); ?>";
var getAllergiesURL = "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "patient_allergies","admin" => false)); ?>";
var getLabResultsURL = "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "patient_labresults","admin" => false)); ?>";
var getNoteResultsURL = "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "patient_note","admin" => false)); ?>";
var getBloodGlucoseURL = "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "patient_blood_glucoselog","admin" => false)); ?>";
$(document).ready(function () {

	getLabResults();
	
	
    
});



function getMedications(){
	 
	$("#medications").addClass('patientTd');
	$("#diagnosis").removeClass('patientTd');
	$("#immunizations").removeClass('patientTd');
	$("#lab_result").removeClass('patientTd');
	$("#allergies").removeClass('patientTd');
	$("#notes").removeClass('patientTd');
	$("#blood_glucoselog").removeClass('patientTd');
	
	$.ajax({
	     type: 'POST',
	     url: getMedicationsURL,
	     //data: formData,
	     dataType: 'html',
	     async: true,
	     success: function(data){
	    	//alert(data);
    	    	$("#updateContent").html(data);
    	    	return false ;
	     },
			error: function(message){
	         ///alert(message);
	         return false ;
	        },
	        beforeSend:function(){
	        	$("#showAppointmentIndicator").html("<table><tr><td>Loading Medications Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	        },
	        complete:function(){
	        	$("#showAppointmentIndicator").html("");
    	    }        
	  });
 }

function getProblems(){
	$("#medications").removeClass('patientTd');
	$("#diagnosis").addClass('patientTd');
	$("#immunizations").removeClass('patientTd');
	$("#lab_result").removeClass('patientTd');
	$("#allergies").removeClass('patientTd');
	$("#notes").removeClass('patientTd');
	$("#blood_glucoselog").removeClass('patientTd');
	$.ajax({
	     type: 'POST',
	     url: getProblemsURL,
	     //data: formData,
	     dataType: 'html',
	     async: true,
	     success: function(data){
	    	//alert(data);
    	    	$("#updateContent").html(data);
    	    	return false ;
	     },
			error: function(message){
	         //alert(message);
	         return false ;
	        },
	        beforeSend:function(){
	        	$("#showAppointmentIndicator").html("<table><tr><td>Loading Medications Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	        },
	        complete:function(){
	        	$("#showAppointmentIndicator").html("");
    	    }        
	  });
 }

function getImmunizations(){
	$("#medications").removeClass('patientTd');
	$("#diagnosis").removeClass('patientTd');
	$("#immunizations").addClass('patientTd');
	$("#lab_result").removeClass('patientTd');
	$("#allergies").removeClass('patientTd');
	$("#notes").removeClass('patientTd');
	$("#blood_glucoselog").removeClass('patientTd');
	$.ajax({
	     type: 'POST',
	     url: getImmunizationsURL,
	     //data: formData,
	     dataType: 'html',
	     async: true,
	     success: function(data){
	    	//alert(data);
    	    	$("#updateContent").html(data);
    	    	return false ;
	     },
			error: function(message){
	         //alert(message);
	         return false ;
	        },
	        beforeSend:function(){
	        	$("#showAppointmentIndicator").html("<table><tr><td>Loading Medications Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	        },
	        complete:function(){
	        	$("#showAppointmentIndicator").html("");
    	    }        
	  });
 }

function getAllergies(){
	$("#medications").removeClass('patientTd');
	$("#diagnosis").removeClass('patientTd');
	$("#immunizations").removeClass('patientTd');
	$("#lab_result").removeClass('patientTd');
	$("#allergies").addClass('patientTd');
	$("#notes").removeClass('patientTd');
	$("#blood_glucoselog").removeClass('patientTd');
	$.ajax({
	     type: 'POST',
	     url: getAllergiesURL,
	     //data: formData,
	     dataType: 'html',
	     async: true,
	     success: function(data){
	    	//alert(data);
    	    	$("#updateContent").html(data);
    	    	return false ;
	     },
			error: function(message){
	         //alert(message);
	         return false ;
	        },
	        beforeSend:function(){
	        	$("#showAppointmentIndicator").html("<table><tr><td>Loading Medications Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	        },
	        complete:function(){
	        	$("#showAppointmentIndicator").html("");
    	    }        
	  });
 }

function getLabResults(){
	$("#medications").removeClass('patientTd');
	$("#diagnosis").removeClass('patientTd');
	$("#immunizations").removeClass('patientTd');
	$("#lab_result").addClass('patientTd');
	$("#allergies").removeClass('patientTd');
	$("#notes").removeClass('patientTd');
	$("#blood_glucoselog").removeClass('patientTd');
	$.ajax({
	     type: 'POST',
	     url: getLabResultsURL,
	     //data: formData,
	     dataType: 'html',
	     async: true,
	     success: function(data){
	    	//alert(data);
    	    	$("#updateContent").html(data);
    	    	return false ;
	     },
			error: function(message){
	         //alert(message);
	         return false ;
	        },
	        beforeSend:function(){
	        	$("#showAppointmentIndicator").html("<table><tr><td>Loading Medications Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	        },
	        complete:function(){
	        	$("#showAppointmentIndicator").html("");
    	    }        
	  });
 }
function getNotes(){
	$("#medications").removeClass('patientTd');
	$("#diagnosis").removeClass('patientTd');
	$("#immunizations").removeClass('patientTd');
	$("#lab_result").removeClass('patientTd');
	$("#allergies").removeClass('patientTd');
	$("#notes").addClass('patientTd');
	$("#blood_glucoselog").removeClass('patientTd');
	$.ajax({
	     type: 'POST',
	     url: getNoteResultsURL,
	     //data: formData,
	     dataType: 'html',
	     async: true,
	     success: function(data){
	    	//alert(data);
    	    	$("#updateContent").html(data);
    	    	return false ;
	     },
			error: function(message){
	         //alert(message);
	         return false ;
	        },
	        beforeSend:function(){
	        	$("#showAppointmentIndicator").html("<table><tr><td>Loading Medications Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	        },
	        complete:function(){
	        	$("#showAppointmentIndicator").html("");
    	    }        
	  });
 }

function getBloodGlucose(){
	$("#medications").removeClass('patientTd');
	$("#diagnosis").removeClass('patientTd');
	$("#immunizations").removeClass('patientTd');
	$("#lab_result").removeClass('patientTd');
	$("#allergies").removeClass('patientTd');
	$("#notes").removeClass('patientTd');
	$("#blood_glucoselog").addClass('patientTd');
	$.ajax({
	     type: 'POST',
	     url: getBloodGlucoseURL,
	     //data: formData,
	     dataType: 'html',
	     async: true,
	     success: function(data){
	    	//alert(data);
    	    	$("#updateContent").html(data);
    	    	return false ;
	     },
			error: function(message){
	         //alert(message);
	         return false ;
	        },
	        beforeSend:function(){
	        	$("#showAppointmentIndicator").html("<table><tr><td>Loading Medications Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	        },
	        complete:function(){
	        	$("#showAppointmentIndicator").html("");
    	    }        
	  });
 }
</script>