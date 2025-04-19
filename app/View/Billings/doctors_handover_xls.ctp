<?php
header("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;  filename=\"advance_bill_" . $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'), Configure::read('date_format'), true)
    . ".xls");
header("Content-Description: Generated Report");
ob_clean();
flush();
?>
<STYLE type='text/css'>
    .tableTd {
        border-width: 0.5pt;
        border: solid;
    }

    .tableTdContent {
        border-width: 0.5pt;
        border: solid;
    }

    #titles {
        font-weight: bolder;
    }
</STYLE>

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
        $patientWardCharges[$patient] + $total_amount_consultant[$patient];
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
<table border='1' class='table_format' cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>
    <tr class="row_title">
        <td colspan="7" align="center">
            <h2>DOCTOR'S HANDOVER REPORT - <?php echo date('d/m/Y'); ?></h2>
        </td>
    </tr>
    <tr class='row_title'>
        <th width="87px;" align="center" valign="top"
            style="text-align: center;">PATIENT DETAILS</th>
        <th width="80px;" align="center" valign="top"
            style="text-align: center;">DIAGNOSIS</th>
        <th width="70px;" align="center" valign="top"
            style="text-align: center;">PLANNED SURGERY OR PROCEDURE AND COST OF
            SURGERY</th>
              <th width="80px;" align="center" valign="top"
            style="text-align: center;">REMARKS</th>
        <th width="80px;" align="center" valign="top"
            style="text-align: center;">DOCTOR NAME</th>
        
        <th width="87px;" align="center" valign="top"
            style="text-align: center;">DATE & TIME</th>
        <th width="87px;" align="center" valign="top"
            style="text-align: center;">SIGNATURE</th>
    </tr>


    <?php
    $i = 0;
    $patientCnt = 0;
    foreach ($results as $result) {
        $tariffCount[$result['TariffStandard']['name']] = $tariffCount[$result['TariffStandard']['name']] + 1;
    ?>
        <TR>
            <?php $col = '';
            if (empty($result['Patient']['id'])) {
                $col = "colspan='15'";
            } else {
                $col = 'align="center"';
            } ?>

            <?php if ($result['Patient']['id']) {
                $patientCnt++; ?>
                <td align="left">
                    <?php echo $result['Patient']['lookup_name'] . "<br>";
                    echo $result['Patient']['admission_id'] . "<br>";
                    echo $result['Person']['district'] . "<br>";
                    echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'], Configure::read('date_format')) . "<br>";
                    echo $result['TariffStandard']['name']; ?>
                </td>

                <td>
                    <?php echo $result['Diagnosis']['final_diagnosis']; ?>
                </td>
                <td>
                    <?php
                    foreach ($surgeriesData as $surgery) {
                        if ($result['Patient']['id'] == $surgery['OptAppointment']['patient_id']) {
                            echo $surgery['Surgery']['name'] . "<br>";    //display only the surgery details of patients
                            $surgeryCost = $surgery['OptAppointment']['surgery_cost'] + $surgery['OptAppointment']['anaesthesia_cost'] + $surgery['OptAppointment']['ot_charges'];
                            echo $this->Number->currency(ceil($surgeryCost)) . '<br>';
                        }
                    }
                    echo $result['Patient']['surgery_text'] . "<br>";
                    ?>
                </td>
                  <td align="center" valign="middle">
                    <?php
                    echo $result['Patient']['remark'];
                    ?>
                </td>
                <td align="center" valign="middle">
                    <?php
                   
                    echo $result['User']['first_name'] . ' ' . $result['User']['last_name'];
                    ?>
                </td>
              
                <td align="center" valign="middle">
                    
                </td>
                <td align="center" valign="middle">
                  
                </td>

        </TR>
<?php          }
        } ?>

</table>
<table align="right" width="500px" border='1' class='table_format'>
    <tr class='row_title'>
        <td colspan="2">
            <?php echo "<b>Total Patients = </b>"; ?>
            <?php echo "<b>" . $patientCnt . "<b>" ?></td>
    </tr>
    <?php foreach ($tariffCount as $key => $tariff) { ?>
        <?php if (!empty($key)) { ?>
            <tr class='row_title'>
                <td align="right"><?php echo "<b>" . $key . "<b>" ?></td>
                <td><?php echo "<b>" . $tariff . "<b>" ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
</table>