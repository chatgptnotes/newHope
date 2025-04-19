<style>
#msg {
	left: 650px;
	width: 253px;
}

.pointCur {
	cursor: pointer;
}

.diagList:hover {
	background-color: yellow;
}

.selectedTr {
	background-color: #8FBC8F !important;
}

label {
	float: none !important;
	margin: none !important;
	padding: none !important;
	width: none !important;
}

.row_format th {
	background: #8b8b8b none repeat scroll 0 0 !important;
	color: #FFFFFF !important;
}
</style>
<?php echo $this->Form->create('NoteDiagnosis', array('id' => 'saveProDiagnosis')); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0"
       style="padding-top: 12px; padding-bottom: 10px;">
    <tr>
        <td width="11%"><strong>Select Diagnosis:</strong></td>
        <td width="23%"><?php
echo $this->Form->input('diagnoses_name', array('class' => 'textBoxExpnd allo validate[required,custom[mandatory-enter]]', 'escape' => false, 'multiple' => false,
    'label' => false, 'div' => false, 'id' => 'diagnosis_name', 'autocomplete' => false, 'placeHolder' => 'Diagnosis Search'));
echo $this->Form->hidden('diagnosis_id', array('id' => 'code_problem1'));
echo $this->Form->hidden('patient_id', array('value' => $patientId));
echo $this->Form->hidden('note_id', array('value' => $noteId));
echo $this->Form->hidden('code_system', array('value' => '1'));
?>
            <span><?php echo $this->Html->image('icons/add_diagnosis.png', array('id' => 'diagAdd', 'escape' => false, 'title' => 'Add New Diagnosis', 'style' => 'padding-left:1%;padding-top:1%')); ?>
            </span>
        </td>
        <td id="displayAddDiag" style="display:none;width: 18%"><?php echo $this->Form->input('Diagnosis.diag_name', array('class' => 'textBoxExpnd', 'escape' => false,
    'label' => false, 'div' => false, 'id' => 'add_diagnosis', 'autocomplete' => false, 'placeHolder' => 'Add Diagnosis', 'style' => 'width:225px;'));
?>
        </td>
        <td id="displaySaveBtn" style="display: none ;width: 4%"><?php echo $this->Html->link('Save', 'javascript:void(0)', array('onclick' => "saveDiagnosisToMaster()", 'class' => 'blueBtn', 'style' => 'margin-left: 1%')); ?></td>
        <td id="displayCancelBtn" style="display: none">
            <input id="cancel" value="Cancel" class="blueBtn" type="Button">
        </td>
        <td  id="showAlert" style="float: left">
        </td>
    </tr>
</table>
<?php echo $this->Form->end(); ?>
<?php echo $this->Form->create('', array('id' => 'ccForm'));?>
<table width="100%">
     <?php if ($getAdmissionType['Patient']['admission_type'] == 'IPD') { ?>
        <tr>
        	<td style="float: left"><?php echo __("Select Date: "); ?></td>
            <td style="float: left">
			    <?php $date = date('d/m/Y H:i:s');
			    echo $this->Form->input('DiagnosisDetail.complaint_date', array('class' => "textBoxExpnd", 'style' => '', 'id' => 'complaintDate', 'type' => 'text', 'label' => false, 'div' => false, 'value' => $date));
			    ?>
                <input type="hidden" name="admission_type" value='<?php echo $getAdmissionType['Patient']['admission_type']; ?>' />
            </td>
            <td></td>
        </tr>
<?php } ?>

<style>
 
.arrow-left {
	width: 0; 
	height: 0; 
	border-top: 21px solid transparent;
	border-bottom: 21px solid transparent;
	border-left: 38px solid #8fbc8f;
    float:right;
   /*  margin-top:-20px; */
    margin-right:-40px;
}
 
</style>
    <tr>     
        <td width="100%" align="left" valign="top" >
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
                <tr>
                    <td width="30%" align="right" valign="top"  style="padding-left: 1%" id="diagnosis_list">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="row_format" id="diagTable"> 
                                <tr>
                                    <th><?php echo __("Diagnosis Name"); ?>
                                    </th>
                                    <th><?php echo __("#"); ?>
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                                 <?php if (!empty($diagnosisList)) {  
	                                 	//$i=1 ;  
	                                 	foreach ($diagnosisList as $diagList) { ?>
                                <tr class="diagList " id="diagID_<?php echo $diagList['NoteDiagnosis']['diagnosis_id']; ?>" note_diag_name="<?php echo $diagList['NoteDiagnosis']['diagnoses_name']; ?>" template_id="<?php echo $diagList['DoctorTemplate']['id']; ?>">
                                        <td class="pointCur">   <?php echo $diagList['NoteDiagnosis']['diagnoses_name']; ?></td>
                                        <td><?php echo $this->Html->image('/img/icons/delete-icon.png', array('class' => 'deleteDiagnosis', 'id' => $diagList['NoteDiagnosis']['id'], 'alt' => 'Remove'));?>
                                        </td>
	                                    <?php// if($i==1) {?>
                                   		<!-- <td class="arrow-left" id="displayImg_<?php echo $diagList['NoteDiagnosis']['diagnosis_id']; ?>">&nbsp;</td> -->
                                   		 <?php // }else{ ?>
	                                    <td class="arrowImg" id="displayImg_<?php echo $diagList['NoteDiagnosis']['diagnosis_id']; ?>">&nbsp;</td>
                                </tr>
	                                   <?php //}$i++; 
									}
                                    } else { ?>
                                <tr  class="diagList"  id="diagID_<?php echo "NO"; // 0 assign for if diagnosis not present ?>">
                                    <td colspan="3" align="center"><b>No Record Found!</b></td></tr>
                              <?php } ?>
                        </table>
                    </td>	
                    <td width="4%"></td>
                    <td width="30%" align="left" valign="top">
                        <div align="center" id = 'temp-busy-indicator' style="display:none;">	
                            &nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
                        </div>	
                        <div id="templateArea-complaints">
                            <?php
                            //echo $this->requestAction('doctor_templates/add/complaints');
                            ?>					 
                        </div>	    	    		 
                    </td>
                    <td width="2%"></td> 
                    <td align="left" valign="top" style="padding: 0px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="chiefComplaints">	              	 
                            <tr> 	
                                <td valign="top" align="left" colspan="2">
                                    <?php
                                    if ($getAdmissionType['Patient']['admission_type'] == 'IPD') {
                                        $complaints = "";
                                    } else {
                                        $complaints = $putCCData['Diagnosis']['complaints'];
                                    }
                                    echo $this->Form->textarea('Diagnosis.complaints', array('placeholder' => 'Chief Complaints', 'id' => 'complaints_desc', 'value' => $complaints, 'rows' => '20', 'style' => 'width: 450px; height: 350px;'));
                                    echo $this->Js->writeBuffer();
                                    ?>
                                    <input type="hidden" name="patientId" value='<?php echo $patientId ?>' />
                                    <input type="hidden" name="noteId" value='<?php echo $noteId ?>' />
                                    <input type="hidden" name="appointmentId" value='<?php echo $appointmentId ?>' />
                                    <input type="hidden" name="diagnosisDetailId"  id= "diagnosisDetailId" />
                                </td>	 
                            </tr>
                            <tr> 	
                                <td id="addTemplate" width="25%"> 
                                    <?php echo $this->Form->input('', array('type' => 'checkbox', 'id' => 'templateSave', 'name' => 'is_template', 'label' => "Add Template", 'div' => false, 'error' => false, 'hiddenFields' => false)); ?>
                                </td> 
                                <td width="75%">
                                    <div id="displayTempBox" style="display: none;">
                                        <?php
                                        echo $this->Form->textarea('', array('style' => "width: 91%; height: 17px;", 'class' => 'templateName', 'autocomplete' => 'off', 'id' => 'tempName', 'name' => 'templateName', 'label' => false, 'div' => false));
                                        echo $this->Form->hidden('', array('name' => "complaintType", 'id' => 'complaintType'));
                                        echo $this->Form->hidden('Diagnosis.diagnosis_id', array('id' => 'diagnosisIDD'));
                                        echo $this->Form->hidden('Diagnosis.diagnoses_name', array('id' => 'diagnosisNamee'));
                                        ?> 
                                    </div>
                                </td>
                            </tr> 
                            <tr> 
                                <td colspan="2">
                           			 <?php echo $this->Html->link('Save', 'javascript:void(0)', array('onclick' => "updateCC('complaints')", 'class' => 'blueBtn','style'=>'display: none;','id'=>'saveComplaint')); ?>
                           			 <?php echo $this->Html->link('Save', 'javascript:void(0)', array('onclick' => "saveTemplateText('complaints')", 'class' => 'blueBtn','style'=>'display: none;','id'=>'saveTemplate')); ?>
                                 	<input id="saveAndAddServices" value="Save & Add Services" class="blueBtn" type="Button">
                                </td>
                            </tr>
                        </table> 
                    </td> 
                    
                    <?php if ($getAdmissionType['Patient']['admission_type'] == 'IPD') { ?>
                    <td width="2%"></td>
                    <td style="max-width:7%" valign="top" align="left"><?php if (!empty($ipdCCData)) { ?>
                            <div style="max-width: 1200px; float: left;">
                                <div style="background-color: #d2ebf2;">
                                    <strong>Previous Notes:</strong>
                                </div>
                                <div>
                                	<?php foreach ($ipdCCData as $key => $value) { ?>
                                <div><?php
	                                $dates = $this->DateFormat->formatDate2Local($value['DiagnosisDetail']['complaint_date'], Configure::read('date_format'), false);
	                                echo $this->Html->link($dates, 'javascript:void(0)', array('class' => 'prevIpdNote', 'style' => 'text-decoration:underline;padding:2px 0px;', 'patient_id' => $value['DiagnosisDetail']['patient_id'], 'id' => $value['DiagnosisDetail']['id']));
                                	?>
                               </div>
                       			 <?php } ?>
                                </div>
                            </div> <?php } ?> 
                        </td>
                    <?php } ?>  
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php echo $this->Form->end(); ?>
<script>
    $(document).ready(function(){
    	$("#saveComplaint").show();
    	$("#saveTemplate").hide();
        $('#diagnosis_name').focus();
        $('#diagnosis_name').autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "googlecompleteproblem", "SnomedMappingMaster", "id", 'icd9name', 'null', 'icd9name', "admin" => false, "plugin" => false)); ?>",
            setPlaceHolder : false,
            select:function(event,ui){
                if(ui.item != undefined){
                    var loopbreak  = false ;
                    $('.diagList').each(function() { //check for duplicate diagnosis 
                        if(ui.item.id == $(this).attr('id').split("_")[1]){
                            $('#diagnosis_name').val('');
                            $('#code_problem1').val('');
                            alert('Selected Diagnosis already added!!'); 
                            $('#diagnosis_name').val(''); 
                            loopbreak = true  ; 
                            return false ;
                        } 
                    }); 
                    $('#code_problem1').val(ui.item.id);
                    $('#diagnosis_name').val(ui.item.value);
                    ui.item.value = ''; //reset value to empty
				  
                    if(loopbreak == false)  saveDiagnosis(); //savediagnosis
                }
            }, 
            messages: {
                noResults: '',
                results: function() {}
            }
        });
	 // for IPD chieif complaint 
        $( "#complaintDate" ).datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1950',			 
            dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS'); ?>'
        });

        //function to auto select first diagnosis 
        function selectFirstDiagnosis(show){
            if(show=='first'){        	
        		templateId= $('.diagList').first().addClass('selectedTr').attr('template_id');
        		diagName=   $('.diagList').first().attr('note_diag_name');
        		diagId=   $('.diagList').first().attr('id').split("_")[1];
        		$("#tempName").val(diagName);
                $("#diagnosisIDD").val(diagId);
                $("#diagnosisNamee").val(diagName); 
                $("#displayImg_"+diagId).addClass('arrow-left');
            }
            else
            {
            	templateId= $('.diagList').last().addClass('selectedTr').attr('template_id');  
            	diagName=   $('.diagList').first().attr('note_diag_name');
        		diagId=   $('.diagList').first().attr('id').split("_")[1];
        		$("#tempName").val(diagName);
                $("#diagnosisIDD").val(diagId);
                $("#diagnosisNamee").val(diagName);
                $("#displayImg_"+diagId).addClass('arrow-left'); 
            } 
        	setTrigger(templateId);
        } 
        selectFirstDiagnosis('first');
    });
    //--------------------------------------Update Complaints --------------------------------------------//
    function updateCC(fields){
        var chiefComplaint= $("#complaints_desc").val();
        if(chiefComplaint == "" ){
            alert("Please Enter Chief Complaints");
        }else{
            var formData = $('#ccForm').serialize(); 
            var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "loadCc", $patientId, $noteId, $appointmentId, "admin" => false)); ?>";
            $.ajax({
                beforeSend : function() {
                    loading('chiefComplaints','id');
                },
                type: 'POST',
                url: ajaxUrl+'/?type='+fields,
                data:formData,
                dataType: 'html',
                success: function(data){
                    onCompleteRequest('chiefComplaints','id');
                    inlineMsg('alertMsges','Chief Complaint Saved Successfully.',5);
                    //ajaxLoadDiagnosisList();
			
                }
            });
        }
    }

    // 
    // reload page after save 
    function ajaxLoadDiagnosisList(){
        var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "loadCc", $patientId, $noteId, $appointmentId)); ?>";
        $.ajax({
            beforeSend : function() {
                $('#busy-indicator').show('fast');
            },
            type: 'POST',
            url: ajaxUrl,
            dataType: 'html',
            success: function(data){
                $('#loadMenu').hide();
                $('#busy-indicator').hide('fast');
                $('#loadArea').html('');
                $('#loadArea').html(data);
            }
        });
    }
    // delete diagnosis 
    $('.deleteDiagnosis').click(function(){
        var currentid=$(this).attr('id');
        var noteId='<?php echo $noteId ?>';
        var patientId='<?php echo $patientId ?>';
        if(confirm('Are you sure?')){
            var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "deleteDiagnosis", "admin" => false)); ?>";
            $.ajax({
                beforeSend : function() {
                    $('#busy-indicator').show('fast');
                },
                type: 'POST',
                url: ajaxUrl+'/'+currentid+'/'+patientId+'/'+noteId,
                dataType: 'html',
                success: function(data){
                    $('#busy-indicator').hide('fast');
                   // ajaxLoadDiagnosisList();
                    $("#diagnosis_list").html(data);
                }
            });
        }else{
            return false;
        }
        $('.diagList').unbind('click'); // this unbind for to restrict trigger call bcz we call trigger on whole <tr> 
    });

    // show previous IPD daily notes 
    $(".prevIpdNote").click(function(){
        id=$(this).attr('id');
        patientId=$(this).attr('patient_id');

        var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "previousIpdNotes")); ?>";
        $.ajax({
            beforeSend : function() {
                $('#busy-indicator').show('fast');
            },
            type: 'POST',
            url: ajaxUrl+'/'+id+'/'+patientId,
            dataType: 'html',
            success: function(data){
                data= $.parseJSON(data);
                $("#diagnosisDetailId").val(data.id);
                $("#complaints_desc").val(data.complaints);
                $('#busy-indicator').hide('fast');
            }
        });
				 
    });
    // save diagnosis and chief complaints and redirect to add services page 
    $('#saveAndAddServices').click(function(){
        var chiefComplaint= $("#complaints_desc").val();
        if(chiefComplaint == ""){
            alert("Please Input Some Data");
        }else{
            updateCC('complaints');
            ajaxAllServiceList();
        }
    });

    $('#templateSave').click(function(){	
        if($("#templateSave").is(':checked')){	
            $("#displayTempBox").show();
            $("#complaintType").val('complaints');
            $("#saveTemplate").show();
            $("#saveComplaint").hide();
        }else{
            $("#displayTempBox").hide();
            $("#complaintType").val('');
            $("#saveTemplate").hide();
            $("#saveComplaint").show();
        }
    });

    $("#diagAdd").click(function(){
        $("#displayAddDiag").show();
        $("#displaySaveBtn").show();
        $("#displayCancelBtn").show();
    });

    $("#cancel").click(function(){
        $("#displayAddDiag").hide();
        $("#displaySaveBtn").hide();
        $("#displayCancelBtn").hide();
	 
    });
 
    // function for to create new diagnosis if diagnosis not present in master 
    function saveDiagnosisToMaster(){
        var diagnoName= $("#add_diagnosis").val();
        if(diagnoName){
            var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "saveDiagnosisToMaster", "admin" => false)); ?>";
            $.ajax({
                beforeSend : function() {
                    loading('diagnosis_list','id');
                },
                type: 'POST',
                url: ajaxUrl+'/'+diagnoName,
                dataType: 'html',
                success: function(data){
                    data= $.parseJSON(data);
                    $("#diagnosis_name").val(data.SnomedMappingMaster.icd9name);
                    $("#code_problem1").val(data.SnomedMappingMaster.id);
                    $("#displayAddDiag").hide();
                    $("#displaySaveBtn").hide();
                    $("#displayCancelBtn").hide();
                    saveDiagnosis();
                    onCompleteRequest('diagnosis_list','id');
                    $("#diagnosis_name").val('');
                    $("#code_problem1").val('');
                }
            });
        }else{
            alert("Please Enter Diagnosis Name");
            return false;
        }
    }
    // function to save diagnosis for patient on select of diagnosis 
    function saveDiagnosis(){ 
        var formData = $('#saveProDiagnosis').serialize();
        var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "ajax_add_diagnosis", $patientId, $noteId, $appointmentId, "admin" => false)); ?>";
        $.ajax({
            beforeSend : function() {
                loading('diagnosis_list','id'); 
            },
            type: 'POST',
            url: ajaxUrl,
            data:formData,
            dataType: 'html',
            success: function(data){ 
                onCompleteRequest('diagnosis_list','id');
                inlineMsg('alertMsges','Diagnosis Saved Successfully.',5);
                $("#diagnosis_list").html(data); 
                $('.diagList').each(function() {  
                    tempId=$(this).attr('template_id'); 	
                    diagId=$(this).attr('id').split("_")[1]; 	
                    diagName=$(this).attr('note_diag_name'); 
                });
                $("#tempName").val(diagName);
                $("#diagnosisIDD").val(diagId);
                $("#diagnosisNamee").val(diagName); 
                $("#diagID_"+diagId).addClass('selectedTr'); // change color of tr 
               // $(".arrowImage").hide();   
                $("#displayImg_"+diagId).addClass('arrow-left');
                setTrigger(tempId);// load diagnosis related templates 
            }
        });
    }

    $('.diagList').on('click',function(e){   
        $(".diagList").removeClass('selectedTr');
        $(".arrowImg").removeClass('arrow-left');
        var diagId=$(this).attr('id').split("_")[1]; 	
        var diagName=$(this).attr('note_diag_name'); 	
        var tempId = $(this).attr('template_id'); 
	 
        $("#tempName").val(diagName); // assign diagnosis name as template name 
        $("#diagnosisIDD").val(diagId);
        $("#diagnosisNamee").val(diagName); 
        
        $("#diagID_"+diagId).addClass('selectedTr');
      //  $(".arrowImage").hide();
       $("#displayImg_"+diagId).addClass('arrow-left');
        setTrigger(tempId);   // load diagnosis related templates text 
        //$("#soap_"+tempId).trigger('click'); 
    });

    function setTrigger(tempId){   
        var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "doctor_templates", "action" => "add_template_text", "admin" => false)); ?>";
        $.ajax({
            beforeSend : function() {
                loading('templateArea-complaints','id'); 
            },
            type: 'POST',
            //async:false, 
            url: ajaxUrl+'/'+tempId,
            dataType: 'html',
            success: function(data){
                if(data!=''){
                    $("#templateArea-complaints").html(data); 
                }
                onCompleteRequest('templateArea-complaints','id'); 
            }
        }); 
    } 
    
    $(document).keyup(function(e) { 
        if (e.keyCode == 27) { // escape key to reset the loading
          parent.onCompleteRequest('loadArea','id');
       }
   }); 

   function saveTemplateText(complaints){
    	var chiefComplaint= $("#complaints_desc").val();
        if(chiefComplaint == "" ){
            alert("Please Enter Chief Complaints");
        }else{
            var formData = $('#ccForm').serialize(); 
            var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "saveTemplateText", $patientId, $noteId, $appointmentId, "admin" => false)); ?>";
            $.ajax({
                beforeSend : function() {
                    loading('chiefComplaints','id');
                },
                type: 'POST',
                url: ajaxUrl+'/?type='+complaints,
                data:formData,
                dataType: 'html',
                success: function(data){
                	obj= $.parseJSON(data);
                	if(obj!=''){
					 tempId=obj.template_id;
					 setTrigger(tempId);   // load templates text 
                    }
                    onCompleteRequest('chiefComplaints','id');
                    inlineMsg('alertMsges','Chief Complaint Saved Successfully.',5);
			
                }
            });
        }
       }
</script>