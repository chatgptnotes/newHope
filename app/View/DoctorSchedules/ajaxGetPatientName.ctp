<?php echo __('Patient Name'); ?>:
 <?php echo $this->Form->input(null,array('name' => 'patientname', 'id'=> 'patientname', 'label' => false, 'value'=> $getPatientName['Patient']['lookup_name']));?>
<script>
$(document).ready(function(){
// for automatic patient search//
        $("#patientname").autocomplete("<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "autoSearchPatientName", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
        $("#patientname").focusout(function(){ 
           var patientname = $('#patientname').val();
           var patient_admissionid = patientname.substring(patientname.indexOf("(")-1, patientname.indexOf(")")+1);
            $('#patientname').val(patientname.replace(patient_admissionid,''));
            $('#admissionid').val(patient_admissionid.replace(/[\(\)\s]/g,''));
        });
	
        $("#admissionid, #patientname").focusout(function(){ 
          $('#busy-indicator').show();
          var paid = $('#admissionid').val();
          var data = 'paid=' + paid ; 
          // for patient name field //
          $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetPatientName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#showpatientname').show();$('#busy-indicator').hide();$('#showpatientname').html(html); } });
          // for diagnosis field //
          $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetDiagnosisName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#showdiagnosisname').show();$('#busy-indicator').hide();$('#diagnosis').val(html); } });

         }); 
});
  </script>