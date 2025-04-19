

<?php
	$patient      = $getBasicData;
	$summary      = $notesRec;
	$otList     = $otList;
	$name         = isset($patient['Patient']['lookup_name']) ? $patient['Patient']['lookup_name'] : '';
	$sex          = isset($patient['Patient']['sex']) ? $patient['Patient']['sex'] : '';
	$age          = isset($patient['Patient']['age']) ? $patient['Patient']['age'] : '';
	$admission_id = isset($patient['Patient']['admission_id']) ? $patient['Patient']['admission_id'] : '';
	$admission_type = isset($patient['Patient']['admission_type']) ? $patient['Patient']['admission_type'] : '';
	$patient_uid  = isset($patient['Person']['patient_uid']) ? $patient['Person']['patient_uid'] : '';
	$dob          = isset($patient['Person']['dob']) ? $this->DateFormat->formatDate2Local($patient['Person']['dob'],Configure::read('date_format')) : '';

	$surgeries = array();
	foreach ($otList as $key => $value) {
		$date = $this->DateFormat->formatDate2Local($value['OptAppointment']['schedule_date'],Configure::read('date_format'));
		$procedure = $value['Surgery']['name'] ;debug($is_discharge);
		$surgeon = $surgonList[$value['OptAppointment']['doctor_id']] ;
		$anaesthetist = $anaList[$value['OptAppointment']['department_id']] ;
		$desc = $value['OptAppointment']['description'] ;
		$surgeries[] = " Date : ".$date." Procedure : ".trim($value['Surgery']['name'])." Surgeon : ".$surgeon." Anaesthetist : ".$anaesthetist." Description : ".$desc;
	}
	$surgeries = implode(",", $surgeries) ;

	$treatmentOnDischarge = array();
	
	foreach ($summary['PharmacyItem'] as $key => $value) {
		$treatmentOnDischarge[$key] = $value." Pack-".$summary['pack'][$key]." Route-".$summary['route'][$key]." Frequency-".$summary['frequency'][$key]." Days-".$summary['dose'][$key] ;
	}

	$treatmentOnDischarge = implode(", ", $treatmentOnDischarge) ;


?>
<table>
	<tr>
		<td><textarea class="gptInput" id="gptInput_<?php echo $templateType ?>" name="gpt_input" placeholder="Choose from above or type here.." style=" height: 100px;min-width: 499px;"></textarea>
		</td>
	</tr>
	<tr>
                <?php
// $getBasicData se $is_discharge aur $ready_to_fetch ki values nikal rahe hain
$is_discharge = isset($getBasicData['Patient']['is_discharge']) ? $getBasicData['Patient']['is_discharge'] : 0;
$ready_to_fetch = isset($getBasicData['Person']['ready_to_fetch']) ? $getBasicData['Person']['ready_to_fetch'] : 0;

// debug($is_discharge);
// debug($admission_type);
// debug($ready_to_fetch);
?>


<td>
    <!-- ChatGPT button -->
    <button 
        type="button" 
        data-template="<?php echo $templateType ?>" 
        onclick="submitToChatGPT('<?php echo $templateType ?>')" 
        class="blueBtn btn btn-default get_gpt_reply">
        Message chat GPT as
    </button>

    <!-- Fetch Data button -->
    <button 
        type="button" 
        onclick="<?php 
            if ($admission_type == 'IPD') {
                echo ($is_discharge == 1) ? 
                    "fetchIpdData('$templateType')" : 
                    "alert('Please discharge the patient first.')";
            } else if ($admission_type == 'OPD') {
                echo ($ready_to_fetch == 1) ? 
                    "fetchOpdData('$templateType')" : 
                    "alert('Patient is not ready for fetch , Please Insert The Details Into The Patient Hub .')";
            }
        ?>" 
        class="blueBtn btn btn-default" 
        <?php 
            if ($admission_type == 'IPD' && $is_discharge == 0) {
                // echo 'disabled';
            } else if ($admission_type == 'OPD' && $ready_to_fetch == 0) {
                // echo 'disabled';
            }
        ?>>
        Fetch Data
    </button>
</td>

	</tr>
</table>
<script>
	
	var name         = "<?php echo trim($name) ?>";
	var age          = "<?php echo trim($age) ?>";
	var sex          = "<?php echo trim($sex) ?>";
	var admission_id = "<?php echo trim($admission_id) ?>";
	var patient_uid  = "<?php echo trim($patient_uid) ?>";
	var dob          = "<?php echo trim($dob) ?>";

	var admissionType= "<?php echo $admission_type ?>";
	
	if(admissionType == 'IPD'){

		var ipdDiagnosis = <?php echo json_encode(isset($summary['DischargeSummary']['final_diagnosis']) ? $summary['DischargeSummary']['final_diagnosis'] : ''); ?>;

var ipdComplaints = <?php echo json_encode(isset($summary['DischargeSummary']['complaints']) ? preg_replace( '/\r|\n/', '', $summary['DischargeSummary']['complaints']) : ''); ?>;

var ipdExamine = <?php echo json_encode(isset($summary['DischargeSummary']['temp']) && isset($summary['DischargeSummary']['pr']) && isset($summary['DischargeSummary']['rr']) && isset($summary['DischargeSummary']['bp']) && isset($summary['DischargeSummary']['spo2']) ? 'Temperature: ' . $summary['DischargeSummary']['temp'] . '°F, Pulse Rate: ' . $summary['DischargeSummary']['pr'] . '/min, Respiration Rate: ' . $summary['DischargeSummary']['rr'] . '/min, Blood Pressure: ' . $summary['DischargeSummary']['bp'] . 'mmHg, SpO2: ' . $summary['DischargeSummary']['spo2'] . ' % in Room Air' : ''); ?>;

var ipdInvestigation = <?php echo json_encode(isset($summary['DischargeSummary']['abnormal_investigation']) ? preg_replace( '/\r|\n/', '', $summary['DischargeSummary']['abnormal_investigation']) : ''); ?>;

var ipdProcedure = <?php echo json_encode(isset($surgeries) ? $surgeries : ''); ?>;

var treatmentOnDischarge = <?php echo json_encode(isset($treatmentOnDischarge) ? $treatmentOnDischarge : ''); ?>;


		
	}else{
		var opdHpi    = "<?php echo isset($getDataFormNote['Note']['subject']) ? preg_replace( "/\r|\n/", "", $getDataFormNote['Note']['subject']) : ''; ?>";
		var opdRos    = "<?php echo isset($getDataFormNote['Note']['ros']) ? preg_replace( "/\r|\n/", "", $getDataFormNote['Note']['ros']) : '' ?>";
		var opdExamine       = "<?php echo  isset($getDataFormNote['Note']['object']) ? preg_replace( "/\r|\n/", "", $getDataFormNote['Note']['object']) : '' ?>";
		var opdDiagnosis    = "<?php echo isset($getDataFormNote['Note']['assis']) ? preg_replace( "/\r|\n/", "", $getDataFormNote['Note']['assis']) : '' ?>";
		var opdInvestigation = "<?php echo isset($getDataFormNote['Note']['plan']) ? preg_replace( "/\r|\n/", "", $getDataFormNote['Note']['plan']) : '' ?>";
	}
	

// 	function submitToChatGPT(template) {
		
// 		var input = $('#gptInput_' + template).val();
		
// 		if (input != '') {
// 			$.ajax({
// 	        	beforeSend : function() {
// 	        		$("#busy-indicator").show();
// 	        	},
// 	        	complete: function() {
// 	        		$("#busy-indicator").hide();
// 	        	},
// 	        	type: 'POST',
// 				url: "<?php echo $this->Html->url(array('controller' => 'notes', 'action' => 'chatGPT')); ?>",
// 	        	data: {'gpt_input' : input},
// 	        	success: function(response) {
	        		
	        		
// 	        		if (template == 'diagnosis') {
// 	        			var content = $('#final_diagnosis').text();
// 	        		} else if (template == 'examine') {
// 	        			var content = $('#general_examine').text();
// 	        		} else if (template == 'complaints') {
// 	        			var content = $('#complaints_desc').text();
// 	        		}else if (template == 'present-cond') {
// 	        			var content = $('#present-cond_desc').text();
// 	        		}

// 		        	content += (content != '') ? '&#13;&#13;' : '';
// 					content += 'Name: ' + name + '\nAge: ' + age + '\nGender: ' + sex + '\nAdmission ID: ' + admission_id + '\nMRN ID: ' + patient_uid + '\n' + response;

	        		
// 	        		if (response && template == 'diagnosis') {
// 	        			$('#final_diagnosis').html(content);
// 	        		} else if (response && template == 'examine') {
// 	        			$('#general_examine').html(content);
// 	        		} else if (response && template == 'complaints') {
// 	        			$('#complaints_desc').html(content);
// 	        		}else if (template == 'present-cond') {
// 	        			$('#present-cond_desc').html(content);
// 	        		}
// 	        	},
// 	        });
// 		}
// 	}



	function submitToChatGPT(template) {
    var input = $('#gptInput_' + template).val();

    if (input !== '') {
        $.ajax({
            beforeSend: function () {
                $("#busy-indicator").show();
            },
            complete: function () {
                $("#busy-indicator").hide();
            },
            type: 'POST',
            url: "/notes/chatGPT",
            data: { 'gpt_input': input },
            success: function (response) {
                let content = '';
                let targetElement = '';

                // Identify the target element based on the template
                if (template === 'diagnosis') {
                    targetElement = '#final_diagnosis';
                } else if (template === 'examine') {
                    targetElement = '#general_examine';
                } else if (template === 'complaints') {
                    targetElement = '#complaints_desc';
                } else if (template === 'present-cond') {
                    targetElement = '#present-cond_desc';
                }

                content = $(targetElement).text();

                // Preserve existing content and append new response
                content += (content !== '') ? '\n\n' : '';
                // content += `Name: ${name}\nAge: ${age}\nGender: ${sex}\nAdmission ID: ${admission_id}\nMRN ID: ${patient_uid}\n\n`;

                // Format structured sections like "Medications" and "Operation Notes"
                let formattedResponse = formatStructuredSections(response);

                // Apply plain text formatting for unstructured content
                formattedResponse = formatPlainTextResponse(formattedResponse);

                content += formattedResponse;

                // Update the target element
                $(targetElement).html(content);
            },
        });
    }
}

/**
 * Function to detect and format structured sections like "Medications" and "Operation Notes."
 */
// function formatStructuredSections(response) {
//     let lines = response.split('\n');
//     let formattedContent = '';
//     let isStructuredSection = false;
//     let tableHTML = '';
//     let headerDetected = false;

//     lines.forEach(line => {
//         // Detect structured sections based on headers or table-like content
//         if (line.includes('|') || line.includes('**Medications:**') || line.includes('**Operation Notes:**')) {
//             if (!isStructuredSection) {
//                 isStructuredSection = true;
//                 tableHTML += '<table border="1" style="width:100%;border-collapse:collapse;text-align:left;">';
//             }

//             // Handle table rows and headers
//             if (line.includes('|')) {
//                 let columns = line.split('|').map(col => col.trim());
//                 tableHTML += '<tr>';
//                 columns.forEach(col => {
//                     // Use <th> for the first row (headers) and <td> for others
//                     if (line.includes('**') && !headerDetected) {
//                         tableHTML += `<th>${col.replace(/\*\*/g, '')}</th>`;
//                     } else {
//                         tableHTML += `<td>${col}</td>`;
//                     }
//                 });
//                 tableHTML += '</tr>';
//                 headerDetected = true; // Set header detected flag
//             }
//         } else {
//             // End table when structured section ends
//             if (isStructuredSection) {
//                 tableHTML += '</table>\n';
//                 formattedContent += tableHTML;
//                 tableHTML = '';
//                 isStructuredSection = false;
//                 headerDetected = false;
//             }

//             // Add plain text for unstructured data
//             formattedContent += line + '\n';
//         }
//     });

//     // Close any open table
//     if (isStructuredSection) {
//         tableHTML += '</table>\n';
//         formattedContent += tableHTML;
//     }

//     return formattedContent;
// }


function formatStructuredSections(response) {
    let lines = response.split('\n');
    let formattedContent = '';
    let isStructuredSection = false;
    let tableHTML = '';
    let headerDetected = false;

    lines.forEach(line => {
        // Detect structured sections based on headers or table-like content
        if (line.includes('|') || line.includes('**Medications:**') || line.includes('**Operation Notes:**')) {
            if (!isStructuredSection) {
                isStructuredSection = true;
                tableHTML += '<table border="1" style="width:100%;border-collapse:collapse;text-align:left;">';
            }

            // Handle table rows and headers
            if (line.includes('|')) {
                let columns = line.split('|').map(col => col.trim()).filter(col => col !== ""); // CHANGE 1: Remove extra empty columns

                // Skip rows that contain only dashes ("------") in all columns
                if (columns.every(col => /^-+$/.test(col))) return; // CHANGE 2: Remove separator rows

                tableHTML += '<tr>';
                columns.forEach(col => {
                    // Use <th> for the first row (headers) and <td> for others
                    if (line.includes('**') && !headerDetected) {
                        tableHTML += `<th>${col.replace(/\*\*/g, '')}</th>`;
                    } else {
                        tableHTML += `<td>${col}</td>`;
                    }
                });
                tableHTML += '</tr>';
                headerDetected = true; // Set header detected flag
            }
        } else {
            // End table when structured section ends
            if (isStructuredSection) {
                tableHTML += '</table>\n';
                formattedContent += tableHTML;
                tableHTML = '';
                isStructuredSection = false;
                headerDetected = false;
            }

            // Add plain text for unstructured data
            formattedContent += line + '\n';
        }
    });

    // Close any open table
    if (isStructuredSection) {
        tableHTML += '</table>\n';
        formattedContent += tableHTML;
    }

    return formattedContent;
}



function formatPlainTextResponse(response) {
    let lines = response.split('\n'); // Split response into lines
    let formattedContent = '';

    lines.forEach(line => {
        // Remove '**' stars and trim whitespace
        line = line.replace(/\*\*/g, '').trim();

        // Skip lines with placeholder or irrelevant data
        if (
            line.toUpperCase().includes('DISCHARGE SUMMARY') || // Remove "DISCHARGE SUMMARY"
            line.includes('DD/MM/YYYY') || // Placeholder date format
            line.toLowerCase().includes('to be included') || // Lines with "to be included"
            line.startsWith('_') || // Lines starting with underscores
            line === '' // Empty lines
        ) {
            return; // Skip this line
        }

        // Bold specific phrases
        if (line.includes('Diagnosis') || line.includes('Presenting Complaints') ) {
            formattedContent += `<strong>${line}</strong>\n`; // Bold these specific lines
        } else if (line.endsWith(':')) {
            // Bold headings with larger font size for lines ending with ':'
            formattedContent += `<h3 style="font-weight:bold; margin-bottom: 2px; font-size: 1.2em;">${line}</h3>\n`;
        } else {
            // Add plain text lines as is (with minimal spacing below)
            formattedContent += `<p style="margin-top: 0; margin-bottom: 1px;">${line}</p>\n`;
        }
    });

    return formattedContent;
}



	function fetchIpdData(template) {

		var param = 'Diagnosis: ' + ipdDiagnosis + ', ';
			param += 'Presenting Complaints: ' + ipdComplaints + ',';
			param += 'Examination: ' + ipdExamine + ',';
			param += 'Investigations: ' + ipdInvestigation;
			param += 'Procedure: ' + ipdProcedure + ',';
			param += 'Treatment On Discharge: ' + treatmentOnDischarge + ',';
			
		$('#gptInput_' + template).val(param);
	}

	function fetchOpdData(template) {
		var param = 'Diagnosis: ' + opdDiagnosis + ', ';
			param += 'ROS: ' + opdRos + ',';
			param += 'Presenting Complaints: ' + opdHpi + ',';
			param += 'Examination: ' + opdExamine + ',';
			param += 'Investigations: ' + opdInvestigation;
		$('#gptInput_' + template).val(param);
	}

</script>