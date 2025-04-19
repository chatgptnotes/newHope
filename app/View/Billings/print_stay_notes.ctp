<style>
  body {
    margin: 50px 0 0 0 !important;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 16px;
    color: #000000;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

td {
    padding: 6px 10px;
    vertical-align: top; /* Ensures proper alignment */
   
}

.label {
    font-weight: bold;
    text-align: left;
    width: 35%;
    white-space: nowrap;
}

.value {
    text-align: left;
    width: 65%;
}

.header {
    font-size: 22px;
    font-weight: bold;
    text-align: center;
    padding: 8px 0;
    border-bottom: 2px solid black; /* Added border line at the top */
}

/* Container to align both tables */
.table-container {
    display: flex;
    align-items: flex-start; /* Ensures both tables align at the top */
    justify-content: space-between;
    gap: 30px;
    width: 100%;
}

/* Left Section */
.table-left, .table-right {
    width: 50%;
}

/* Bottom Border Line */
.bottom-border {
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    border-top: 2px solid black;
    padding-top: 10px;
}

</style>

<!-- Print Button -->
<div style="float:right;" id="printButton">
    <?php echo $this->Html->link('Print', '#', array('onclick'=>'window.print();', 'class'=>'blueBtn', 'escape'=>false)); ?>
</div>

<!-- Header with Top Border -->
<table>
    <tr>
        <td colspan="2" class="header">Discharge Summary</td>
    </tr>
</table>

<!-- Container for Left and Right Tables -->
<div class="table-container">

    <!-- Left Section -->
    <div class="table-left">
        <table>
            <tr>
                <td class="label">Name</td>
                <td class="value">: <?php echo $patient['Patient']['lookup_name']; ?></td>
            </tr>
            <tr>
                <td class="label">Primary Care Provider</td>
                <td class="value">: <?php echo ucfirst($treating_consultant[0]['fullname']); ?></td>
            </tr>
            <tr>
                <td class="label">Sex / Age</td>
                <td class="value">: <?php echo ucfirst($sex); ?> / <?php echo ucfirst($age); ?></td>
            </tr>
            <tr>
                <td class="label">Tariff</td>
                <td class="value">: <?php echo $patientDetailsForView['TariffStandard']['name']; ?></td>
            </tr>
            <tr>
                <td class="label">Admission Date</td>
                <td class="value">: <?php echo $this->DateFormat->formatDate2Local($patientDetailsForView['Patient']['form_received_on'], Configure::read('date_format'), false); ?></td>
            </tr>
            <tr>
                <td class="label">Discharge Reason</td>
                <td class="value">: <?php echo $stayNotes['DischargeSummary']['reason_of_discharge']; ?></td>
            </tr>
        </table>
    </div>

    <!-- Right Section -->
    <div class="table-right">
        <table>
            <tr>
                <td class="label">Patient ID</td>
                <td class="value">: <?php echo $patient['Patient']['patient_id']; ?></td>
            </tr>
            <tr>
                <td class="label">Registration ID</td>
                <td class="value">: <?php echo $patient['Patient']['admission_id']; ?></td>
            </tr>
            <tr>
                <td class="label">Mobile No</td>
                <td class="value">: <?php echo $patientDetailsForView['Person']['mobile']; ?></td>
            </tr>
            <tr>
                <td class="label">Address</td>
                <td class="value">: <?php echo $patientDetailsForView['Person']['plot_no'] . " " . $patientDetailsForView['Person']['landmark'] . " " . $patientDetailsForView['Person']['city']; ?></td>
            </tr>
            <tr>
                <td class="label">Discharge Date</td>
                <td class="value">: 
                    <?php 
                        $dischargeDate = ($patientDetailsForView['Patient']['discharge_date']) ? $patientDetailsForView['Patient']['discharge_date'] : date('Y-m-d H:i:s');
                        echo $this->DateFormat->formatDate2Local($dischargeDate, Configure::read('date_format'), false);
                    ?>
                </td>
            </tr>
        </table>
    </div>

</div>

<!-- Bottom Border Line -->
<table>
    <tr>
        <td class="bottom-border">Present Condition</td>
    </tr>
   
    <tr>
    <td>
    <?php 
        $presentCondition = !empty($stayNotes['DischargeSummary']['present_condition']) ? 
            $stayNotes['DischargeSummary']['present_condition'] : 'N/A';

        // If the content contains a table, add a wrapper div to apply styles
        if (strpos($presentCondition, '<table') !== false) {
            echo '<div class="inner-table">' . $presentCondition . '</div>';
        } else {
            echo $presentCondition;
        }
    ?>
</td>

   </tr>

    
</table>

<!-- ADVICE Section -->
<?php if (!empty($stayNotes['DischargeSummary']['advice'])) { ?>
    <table>
        <tr>
            <td class="title" style="text-transform: uppercase; font-style: italic; font-weight: bold; padding: 5px 0 10px 7px;">ADVICE</td>
        </tr>
        <tr>
            <td style="padding-bottom:10px; border-bottom:3px solid #ccc; font-style:italic; padding-left:7px;">
                <?php echo nl2br($stayNotes['DischargeSummary']['advice']); ?>
            </td>
        </tr>
    </table>
<?php } ?>

<!-- INVESTIGATIONS Section -->
<?php if (!empty($stayNotes['DischargeSummary']['investigation'])) { ?>
    <table>
        <tr>
            <td class="title" style="padding-top:10px; font-weight: bold;">INVESTIGATIONS</td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid #ccc; padding-bottom:10px;">
                <?php echo nl2br($stayNotes['DischargeSummary']['investigation']); ?>
            </td>
        </tr>
    </table>
<?php } ?>



<table style="border-collapse: collapse; width: 100%; border: 1px solid black;">
    <!-- Review On Date -->
    <?php if (!empty($stayNotes['DischargeSummary']['review_on'])) { ?>
    <tr>
        <td style="border: 1px solid black; padding: 5px; font-weight: bold;">Review on</td>
        <td style="border: 1px solid black; padding: 5px; text-align: center;">:</td>
        <td style="border: 1px solid black; padding: 5px;">
            <?php
                // Format the review date to display only the date (without time)
                echo date('d/m/Y', strtotime($stayNotes['DischargeSummary']['review_on']));
            ?>
        </td>
    </tr>
<?php } ?>


    <!-- Resident On Discharge -->
    <tr>
        <td style="border: 1px solid black; padding: 5px; font-weight: bold;">Resident On Discharge</td>
        <td style="border: 1px solid black; padding: 5px; text-align: center;">:</td>
        <td style="border: 1px solid black; padding: 5px;">
            <?php echo !empty($residentDoctorName) ? $residentDoctorName : 'N/A'; ?>
        </td>
    </tr>
</table>



<table style="width: 100%;">
    <tr>
        <td class="value" style="text-align: right; font-weight: bold;">
            <?php echo '<b>Dr. ' . ucfirst($treating_consultant[0]['fullname']) . '</b>'; ?>
        </td>
    </tr>
</table>

<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td style="text-align: center; font-size: 18px; font-weight: bold; padding: 10px; border-top: 2px solid black;">
            <b>Note:</b> URGENT CARE/ EMERGENCY CARE IS AVAILABLE 24 X 7. PLEASE CONTACT: 7030974619, 9373111709.
        </td>
    </tr>
</table>

