<?php echo $this->Html->css(array('tooltipster.css', 'jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.tooltipster.min.js', 'jquery.fancybox-1.3.4', 'inline_msg')); ?>
<!-- Add SheetJS Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<style>
.top-icons {
    /*display:none;*/
}
    .tableFoot {
        font-size: 11px;
        color: #b0b9ba;
    }

    .tabularForm td td {
        padding: 0;
    }

    .top-header {
        background: #3e474a;
        height: 60px;
        left: 0;
        right: 0;
        top: 0px;
        margin-top: 10px;
        position: relative;
    }

    textarea {

        width: 80px;
    }

    .ui-datepicker-trigger {
        float: unset;
    }
</style>

<!--<?php  ?>-->
<div class="inner_title">
    <br>
    <h3 style="float: left;">Doctors Handover Report - <?php echo date('d/m/Y'); ?></h3>

    <div style="float:right;">
        <?php echo $this->Form->create(null, array('type' => 'GET', 'inputDefault' => array('div' => false))); ?>
        <table width="" cellpadding="0" cellspacing="5" border="0" class="tdLabel2" style="color:#b9c8ca;">
            <tr>
                 <td>
			<span>
				<?php
				//echo $this->Form->create('Reports',array('action'=>'advance_bill_xls','type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;')); 
				//echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));
				echo $this->Form->input('generate_excel',array('class'=>'blueBtn','type'=>'submit','div'=>false,'label'=>false,'name'=>'format','value'=>'Generate Excel Report'));
				// /echo $this->Html->link(__('Generate Excel Report'),array('action'=>'advanced_billing','null','excel'),array('class'=>'blueBtn','div'=>false,'label'=>false))
				//echo $this->Form->end();
				?> 
			</span>
		</td>
               
            </tr>
        </table>
    </div>
    <div class="clr"></div>
    <table>
        <tr>
            <td>Search by Patient </td>
            <td>
                <?php echo $this->Form->input('lookup_name', array('div' => false, 'label' => false, 'type' => 'text', 'id' => 'lookup_name', 'value' => $this->params->query['lookup_name']));
                echo $this->Form->hidden('patient_id', array('div' => false, 'label' => false, 'id' => 'patient_id', 'value' => $this->params->query['patient_id'])); ?>
            </td>

            <td>
                <label>
                    <?php
                    echo $this->Form->checkbox('dialysis', array(
                        'value' => '659',
                        'hiddenField' => true,
                        'checked' => !empty($this->request->query['dialysis']) && $this->request->query['dialysis'] == '659',
                        'id' => 'onlyDialysis' // Unique ID for JavaScript targeting
                    ));
                    ?>
                    Only Dialysis
                </label>
            </td>
            <td>
                <label>
                    <?php
                    echo $this->Form->checkbox('remove_dialysis', array(
                        'value' => '659',
                        'hiddenField' => true,
                        'checked' => !empty($this->request->query['remove_dialysis']) && $this->request->query['remove_dialysis'] == '659',
                        'id' => 'removeDialysis' // Unique ID for JavaScript targeting
                    ));
                    ?>
                    Remove Dialysis
                </label>
            </td>

            <script>
                // JavaScript to handle mutual exclusivity
                document.getElementById('onlyDialysis').addEventListener('change', function() {
                    if (this.checked) {
                        document.getElementById('removeDialysis').checked = false;
                    }
                });

                document.getElementById('removeDialysis').addEventListener('change', function() {
                    if (this.checked) {
                        document.getElementById('onlyDialysis').checked = false;
                    }
                });
            </script>

            <td>
                <?php echo $this->Form->submit(__('Search'), array('class' => 'blueBtn')); ?>
            </td>

            <td>
                <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('controller' => 'Billings', 'action' => 'advanced_billing'), array('escape' => false, 'title' => 'refresh'));
                ?>
            </td>

        </tr>
    </table>
    <?php echo $this->Form->end(); ?>
    <div class="clr"></div>

    <?php
    //Calcualtions of lab charges and lab paid charges
    foreach ($lab as $getLabData) {
        $total_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']] = $total_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']] + $getLabData['LaboratoryTestOrder']['amount'];
        $total_paid_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']] = $total_paid_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']] + $getLabData['LaboratoryTestOrder']['paid_amount'];
        //$total_amount_lab=$total_amount_lab+$getLabData['TariffAmount'][$nursingServiceCostType];
    }

    //Calcualtions of rad charges and rad paid charges
    foreach ($rad as $getRadData) {
        $total_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']] = $total_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']] + $getRadData['RadiologyTestOrder']['amount'];
        $total_paid_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']] = $total_paid_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']] + $getRadData['RadiologyTestOrder']['paid_amount'];
    }

    //surgery charge
    foreach ($surgeriesData as $key => $surgery) {
        $totalSurgeryAmount[$surgery['OptAppointment']['patient_id']] = $totalSurgeryAmount[$surgery['OptAppointment']['patient_id']] + $surgery['OptAppointment']['surgery_cost'] + $surgery['OptAppointment']['anaesthesia_cost'] + $surgery['OptAppointment']['ot_charges'];
    }
    //service charge including doctor and nursing charges

    $hospitalType = $this->Session->read('hospitaltype');
    if ($hospitalType == 'NABH') {
        $nursingServiceCostType = 'nabh_charges';
    } else {
        $nursingServiceCostType = 'non_nabh_charges';
    }


    foreach ($servicesData as $serviceKey => $serviceValue) {
        foreach ($serviceValue as $amount) {
            $service_tot[$serviceKey] = $service_tot[$serviceKey] + ($amount['cost']);
        }
    }

    //Pharmacy Charges "$pharmacy_charges array is addded for pharmacy charges"--Pooja

    //consultant  charge
    foreach ($getconsultantData as $getconsultantData) {
        $total_amount_consultant[$getconsultantData['ConsultantBilling']['patient_id']] = $total_amount_consultant[$getconsultantData['ConsultantBilling']['patient_id']] + $getconsultantData['ConsultantBilling']['amount'];
    }
    foreach ($patientID as $patient) {
        $totalBillAmount[$patient] = $total_amount_lab[$patient] + $total_amount_rad[$patient] +
            $totalSurgeryAmount[$patient] + $service_tot[$patient] +
            $getconsultantData[$patient] + $doctorCharges[$patient] + $nursingCharges[$patient] +
            $patientWardCharges[$patient] + $total_amount_consultant[$patient] + $covidPackageBill[$patient]['total_package_bill'] + $covidPackageBill[$patient]['total_ppe_bill'] + $covidPackageBill[$patient]['total_visit_bill'];
        if (strtolower($pharmacy_service_type) == 'yes')
            $totalBillAmount[$patient] = $totalBillAmount[$patient] + $pharmacy_charges[$patient]['0']['total'];
    }


    foreach ($advancePayment as $servicePaidDataKey => $servicePaidDataValue) {
        $singleAdvancePaid[$servicePaidDataValue['Billing']['patient_id']] = $singleAdvancePaid[$servicePaidDataValue['Billing']['patient_id']] + $servicePaidDataValue['Billing']['amount'];
    }
    foreach ($patientID as $patient) {
        $totalPaid[$patient] = $finaltotalPaid[$patient];
    }
    foreach ($patientID as $patient) {
        $totalBal[$patient] = $totalBillAmount[$patient] - $totalPaid[$patient] - $totalDiscount[$patient];
    }

    foreach ($advancePayment as $pay) {
        if (!empty($pay['Billing']['amount'])) {
            $last_amount[$pay['Billing']['patient_id']] = $pay['Billing']['amount'];
            $last_date[$pay['Billing']['patient_id']] = $pay['Billing']['date'];
        }
    }
    $i = 0;
    ?>
</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0">
    <tr>
        <td>

        </td>
    </tr>
</table>
<!--<button id="downloadExcel">Download as Excel</button>-->
<table width="100%" cellpadding="0" cellspacing="1" id="myTable" border="0" class="tabularForm">
    <tr>
        <thead>

            <th width="87px;" valign="top" align="center" style="text-align:center;">PATIENT DETAILS</th>

            <th width="91px;" valign="top" align="center" style="text-align:center;">DIAGNOSIS</th>
            <th width="77px;" valign="top" align="center" style="text-align:center;">Plannned Surgery or Procedure And Cost of Surgery</th>

            <th width="92px;" valign="top" align="center" style="text-align:center;">REMARKS</th>


        </thead>
    </tr>
    <?php
    $i = 0;
    foreach ($results as $result) {
    ?>

        <TR style="border-bottom: 1px solid #ddd; font-family: Arial, sans-serif;">
            <?php if (!empty($result['Patient']['id'])) { ?>
                <td width="95" align="justify" style="padding: 10px; vertical-align: top;">
                    <strong><?php echo $result['Patient']['lookup_name']; ?></strong><br>
                    <span style="color: #555;"><?php echo $result['Patient']['admission_id']; ?></span><br>
                    <span style="color: #777;"><?php echo $result['Person']['district']; ?></span><br>
                    <span style="color: #007bff; font-weight: bold;"><?php echo $result['Person']['mobile']; ?></span><br>
                    <span style="font-size: 12px; color: #888;">
                        <?php echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'], Configure::read('date_format')); ?>
                    </span><br>
                    <span style="font-size: 13px; font-weight: bold;"><?php echo $result['TariffStandard']['name']; ?></span><br>

                    <?php if ($result['Person']['vip_chk'] == '1') {
                        echo $this->Html->image("vip.png", array("alt" => "VIP", "title" => "VIP", "style" => "margin-top:5px; width:20px; height:20px;"));
                    } ?>
                </td>

                <td width="101" align="justify" style="padding: 10px; vertical-align: top;">
                    <?php

                    $finalDiagnosis = isset($result['Diagnosis']['final_diagnosis']) ? trim($result['Diagnosis']['final_diagnosis']) : '';
                    $diagnosisTxt = isset($result['Patient']['diagnosis_txt']) ? trim($result['Patient']['diagnosis_txt']) : '';
                    $finalValue = $finalDiagnosis;
                    if (!empty($diagnosisTxt)) {
                        $finalValue .= "\n\n" . $diagnosisTxt;
                    }
                    echo $this->Form->input('final_diagnosis', array(
                        'id' => 'final_' . $result['Patient']['id'] . '_' . $result['Diagnosis']['id'],
                        'type' => 'textarea',
                        'label' => false,
                        'rows' => '4',
                        'cols' => '30',
                        'class' => 'diagnosis_save',
                        'style' => 'width:100%; border:1px solid #ccc; padding:5px; border-radius:4px; min-height: 70px !important;',
                        'value' => $finalValue
                    ));
                    ?>
                    <div style="margin-top: 5px;">
                        <?php echo $this->Form->input('', array(
                            'type' => 'checkbox',
                            'id' => 'icd_' . $result['Patient']['id'],
                            'class' => 'icd',
                            'label' => false,
                            'div' => false,
                            'error' => false,
                            'hiddenFields' => false
                        )) . " <strong>ICD10</strong>"; ?>
                    </div>

                    <span id="showTxtBox_<?php echo $result['Patient']['id']; ?>" style="display: none;">
                        <?php echo $this->Form->input('icdName', array(
                            'div' => false,
                            'label' => false,
                            'type' => 'text',
                            'id' => 'icdName_' . $result['Patient']['id'] . '_' . $result['Diagnosis']['id'],
                            'class' => 'icdName',
                            'style' => 'width:100%; padding:5px; border:1px solid #ccc; border-radius:4px;'
                        ));
                        echo $this->Form->hidden('ICD_code', array(
                            'div' => false,
                            'label' => false,
                            'id' => 'ICD_code_' . $result['Patient']['id']
                        )); ?>
                    </span>
                </td>
                <td width="122" align="justify" style="padding: 10px; vertical-align: top;">
                <?php
                    echo $this->Form->input('surgery_text', array(
                        'id' => 'surgery_text' . $result['Patient']['id'],
                        'type' => 'textarea',
                        'label' => false,
                        'rows' => '4',
                        'cols' => '30',
                        'class' => 'surgery_text',
                        'style' => 'width:100%; border:1px solid #ccc; padding:5px; border-radius:4px; min-height: 70px !important;',
                        'value' => isset($result['Patient']['surgery_text']) ? $result['Patient']['surgery_text'] : '' 
                    ));
                    ?>

                        

                    <?php
                    $surgeriesCost = 0;
                    foreach ($surgeriesData as $surgery) {
                        if ($result['Patient']['id'] == $surgery['OptAppointment']['patient_id']) {
                            echo "<strong style='color:#28a745;'>" . $surgery['Surgery']['name'] . "</strong><br>";
                            $surgeryCost = $surgery['OptAppointment']['surgery_cost'] +
                                $surgery['OptAppointment']['anaesthesia_cost'] +
                                $surgery['OptAppointment']['ot_charges'];
                            echo "<span style='color:#dc3545; font-weight:bold;'>" . $this->Number->currency(ceil($surgeryCost)) . "</span><br>";
                            $surgeriesCost = 0;
                        }
                    }
                    ?>
                </td>

                <td width="99" align="justify" style="padding: 10px; vertical-align: top;">
                    <?php
                    $remark = isset($result['Patient']['remark']) ? trim($result['Patient']['remark']) : '';
                    $unwantedTexts = ['Package amount Rs.', '/-', '<br>', "\r", "\n"];
                    $remark = str_replace($unwantedTexts, '', $remark);
                    $remarkDisable = ($result['Patient']['tariff_standard_id'] == $rgjayID || $result['Patient']['tariff_standard_id'] == $rgjayOnToday) ? 'disabled' : '';
                    echo $this->Form->input('remark', [
                        'disabled' => $remarkDisable,
                        'id' => 'remark_' . $result['Patient']['id'],
                        'type' => 'textarea',
                        'label' => false,
                        'rows' => '2',
                        'cols' => '30',
                        'class' => 'add_remark',
                        'style' => 'width:100%; border:1px solid #ccc; padding:5px; border-radius:4px; min-height: 70px !important',
                        'value' => $remark
                    ]);
                    ?>
                </td>



        </TR>

    <?php } ?>
    <?php unset($pay_amount); ?>
<?php } ?>


</table>
<input type="button" class="blueBtn sendmessage" name="Send Message" value="Send Message" id="send_message">
<script>
    $(document).ready(function() {
        $('.tooltip').tooltipster({
            interactive: true,
            position: "right",
        });
    });


    jQuery(document).ready(function() {
        $('.diagnosis_save').blur(function() {
            var patient = $(this).attr('id');

            splittedId = patient.split("_");
            patient_id = splittedId[1]
            newId = splittedId[2];
            if (newId == '')
                newId = 'null';

            var val = $(this).val();
            var icdCode = $('#ICD_code_' + patient_id).val();
            $.ajax({
                url: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getDiagnosis", "admin" => false)); ?>" + "/" + patient_id + "/" + newId,
                data: "diagnosis=" + val + "&icdCode=" + icdCode,
                beforeSend: function(data) {
                    $('#busy-indicator').show();
                },
                success: function(data) {
                    $('#busy-indicator').hide();
                }
            });
        });

        $('.add_remark').blur(function() {
            var patient = $(this).attr('id');
            splittedId = patient.split("_");
            newId = splittedId[1];
            var val = $(this).val();
            $.ajax({
                url: "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getRemark", "admin" => false)); ?>" + "/" + newId,
                data: "remark=" + val,

                beforeSend: function(data) {
                    $('#busy-indicator').show();
                },
                success: function(data) {
                    $('#busy-indicator').hide();
                }
            });
        });
        $(".dod").datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            buttonText: "Calendar",
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:' + new Date().getFullYear(),
            minDate: new Date(),
            dateFormat: '<?php echo $this->General->GeneralDate(); ?>',
            onSelect: function() {
                var patient = $(this).attr('id');
                splittedId = patient.split("_");
                newId = splittedId[1];
                var val = $(this).val();
                $.ajax({
                    url: "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "setExpectedDateOfDischarge", "admin" => false)); ?>" + "/" + newId,
                    data: "likely_discharge_date=" + val,

                    beforeSend: function(data) {
                        $('#busy-indicator').show();
                    },
                    success: function(data) {
                        $('#busy-indicator').hide();
                    }
                });
            }
        });


        $('.clickMeToaddAmount').blur(function() {
            var patient = $(this).attr('id');
            splittedId = patient.split("_");
            newId = splittedId[4];
            var val = $(this).val();
            $.ajax({
                url: "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "getTodayPayment", "admin" => false)); ?>" + "/" + newId + "/" + val,

                beforeSend: function(data) {
                    $('#busy-indicator').show();
                },

                success: function(data) {
                    $('#busy-indicator').hide();
                }
            });
        });

    });

    function getDiffAmount(patient_id) {

        $.fancybox({
            'width': '70%',
            'height': '40%',
            'autoScale': true,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'type': 'iframe',
            'href': "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "diffAmountDetail")); ?>" + '/' + patient_id,

        });
        $(document).scrollTop(0);
        return false;
    }



    $('#selectall').click(function(event) { //on click
        if (this.checked) { // check select status
            var chk1Array = [];
            var tCount = 0;
            var amtValArray = [];
            $('.checkbox1').each(function() { //loop through each checkbox
                //     this.checked = true;  //select all checkboxes with class "checkbox1"      
                /*      checkId=this.id;   
                       console.log(checkId);                 
            	   	   val =$("#"+checkId).val();
            	   	   chk1Array.push(val);  
            	   	   console.log(chk1Array);*/
                //*********BOF-For Save Amt-Mahalaxmi	   
                /*  	var valAmtId = $('.clickMeToaddAmount').attr('id') ;	
            	   	splittedId = valAmtId.split("_");
        			newId = splittedId[4];
            	    var amt=$('#amount_to_pay_today_'+newId).val();  	  
            	    amtValArray.push(amt);   */
                this.checked = true;
                checkId = this.id;
                splitedId = checkId.split('_');
                var patientIdnew = splitedId['1'];
                var amtnew = $('#amount_to_pay_today_' + patientIdnew).val();
                var patientIdnew = patientIdnew.concat("_");
                var res = patientIdnew.concat(amtnew);
                chk1Array.push(res);
            });

            $.ajax({
                url: "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "getTodayPaymentForSms", "admin" => false)); ?>",
                type: 'POST',
                data: "chk1Array=" + chk1Array,
                dataType: 'html',
                beforeSend: function(data) {
                    $('#busy-indicator').show();
                },

                success: function(data) {
                    $('#busy-indicator').hide();
                }
            });
            //*********EOF-For Save Amt-Mahalaxmi	  
        } else {
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });
        }
    });

    //If one item deselect then button CheckAll is UnCheck
    $(".checkbox1").click(function() {
        if (!$(this).is(':checked')) {
            $("#selectall").attr('checked', false);
        } else {
            var chkId = $(this).attr('id');
            splittedId = chkId.split("_");
            newId = splittedId[1];
            var val = $('#amount_to_pay_today_' + newId).val();
            $.ajax({
                url: "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "getTodayPayment", "admin" => false)); ?>" + "/" + newId + "/" + val,

                beforeSend: function(data) {
                    $('#busy-indicator').show();
                },
                success: function(data) {
                    $('#busy-indicator').hide();

                }
            });
        }
    });

    $('.sendmessage').click(function() {
        var chk1Array = [];
        var tCount = 0;
        $(".checkbox1:checked").each(function() {
            checkId = this.id;
            splitedId = checkId.split('_');
            val = $("#" + checkId).val();
            var patientId = splitedId['1'].concat("_");
            var res = patientId.concat(val);
            chk1Array.push(res);

        });
        //array of id of selected chkboxes to send message

        $.ajax({
            url: "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "sendToSmsMultiplePatient", "admin" => false)); ?>",
            type: 'POST',
            data: "chk1Array=" + chk1Array,
            dataType: 'html',
            beforeSend: function(data) {
                $('#busy-indicator').show();
            },
            success: function(data) {

                //$('#alertMsg').fadeOut(5000);  			   			
                location.reload();
                var alertId = $('#alertMsg').attr('id');
                // $('#alertMsg').show().html('SMS sent successfully.');
                inlineMsg(alertId, 'SMS sent successfully.');
                $('#busy-indicator').hide();

                $("#selectall").attr('checked', false);


            }
        });
    });

    $("#lookup_name").autocomplete({
        source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete", "no", 'is_discharge=0', "admin" => false, "plugin" => false)); ?>",
        select: function(event, ui) {
            $("#patient_id").val(ui.item.id);
        },
        messages: {
            noResults: '',
            results: function() {},
        }
    });

    $('.icdName').autocomplete({

        source: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "diagnosisAutocomplete", "admin" => false, "plugin" => false)); ?>",
        // setPlaceHolder : false,
        select: function(event, ui) {
            var strVal = $(this).attr('id');
            splittedId = strVal.split("_");
            patientId = splittedId[1];
            var upperValue = $("#final_" + splittedId[1] + "_" + splittedId[2]).val();
            $("#ICD_code_" + patientId).val(ui.item.icd10Code);
            //$("#final_"+patientId).val(ui.item.value);
            upperValue = upperValue + " " + ui.item.value;
            $("#final_" + splittedId[1] + "_" + splittedId[2]).val('');
            $("#final_" + splittedId[1] + "_" + splittedId[2]).val(upperValue);
            $("#final_" + splittedId[1] + "_" + splittedId[2]).focus();

        },
        messages: {
            noResults: '',
            results: function() {}
        }
    });

    $('.icd').click(function() {
        var icdData = $(this).attr('id');
        splittedId = icdData.split("_");
        patientId = splittedId[1];
        if ($("#icd_" + patientId).is(':checked')) {
            $("#showTxtBox_" + patientId).show();
            $("#icdName_" + patientId).focus();
        } else {
            $("#showTxtBox_" + patientId).hide();

        }
    });
</script>


<!-- JavaScript -->
<script>
    function filterData() {
        // Get the selected filter value
        var filter = document.getElementById("filter").value.toLowerCase();

        // Get all rows from the table body
        var rows = document.querySelectorAll("#dataTable tbody tr");

        // Loop through all rows and filter data
        rows.forEach(function(row) {
            // Get the content of the specific column
            var bedDetails = row.cells[0].textContent.toLowerCase();

            // Check if the row matches the filter
            if (filter === "all" || bedDetails.includes(filter)) {
                row.style.display = ""; // Show row
            } else {
                row.style.display = "none"; // Hide row
            }
        });
    }
</script>
<script>
   
</script>
<script>
$(document).ready(function () {
    $('.surgery_text').blur(function () {
        var patient = $(this).attr('id');
        var newId = patient.replace("surgery_text", "").split("_")[0];
        var val = $(this).val();
        $.ajax({
            url: "<?php echo $this->Html->url(array('controller' => 'patients', 'action' => 'surgery_text', 'admin' => false)); ?>" + "/" + newId,
            type: "POST",
            data: { surgery_text: val },
            dataType: "json",
            beforeSend: function () {
                $('#busy-indicator').show();
            },
            success: function () {
                $('#busy-indicator').hide();
            },
            error: function () {
                $('#busy-indicator').hide();
            }
        });
    });
});
</script>
<!--<button id="downloadExcel" class="blueBtn">Download as Excel</button>-->
<script>
    document.getElementById('downloadExcel').addEventListener('click', function() {
        var table = document.getElementById('myTable');
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Sheet1"
        });
        XLSX.writeFile(wb, "Doctor's_Handover_Report.xlsx");
    });
</script>

