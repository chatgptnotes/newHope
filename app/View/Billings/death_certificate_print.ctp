<style>
    .certificate-container {
        width: 80%;
        margin: 0 auto;
        border: 2px solid #000;
        padding: 30px;
        font-family: Arial, sans-serif;
    }

    .heading {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .certificate-body {
        font-size: 16px;
        line-height: 1.6;
		margin-top: 68px;
    }

    .certificate-body strong {
        font-weight: bold;
    }

    .header-table {
        width: 100%;
		margin-top: 68px;
        margin-bottom: 40px;
        border-collapse: collapse;
    }

    .header-table td {
        padding: 8px;
    }

    .received-by {
        text-align: left;
        font-size: 14px;
        width: 58%;
    }

    .doctor-info {
        text-align: left;
        font-size: 14px;
        width: 18%;
    }

    .underline {
        display: inline-block;
        border-bottom: 1px solid black;
        width: 150px;
        margin-left: 10px;
    }

    .contact-info {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin-top: 50px;
        border-top: 2px solid black;
        padding-top: 15px;
    }

    .urgent-care {
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }

    /* Print button */
    /* #printButton {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #0275d8;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
    }

    #printButton:hover {
        background-color: #025aa5;
    } */

</style>

<div class="certificate-container">
    <div style="float:right;" id="printButton">
        <?php echo $this->Html->link('Print', '#', array('onclick' => 'window.print();', 'class' => 'blueBtn', 'escape' => false)); ?>
    </div>

    <!-- Certificate Heading -->
    <div class="heading">
        DEATH CERTIFICATE
    </div>

    <p class="ht5"></p>
    <?php echo $this->element('print_patient_header'); ?>

    <!-- Certificate Body -->
    <div class="certificate-body" margin-top=" 68px !important;">
        <p>This is to certify that <strong><?php echo $patient[0]['lookup_name']; ?></strong>, aged about <strong><?php echo ($patient['Patient']['age'] > 0) ? $patient['Patient']['age'] : 1; ?> Yrs.</strong>, residing at <?php echo str_replace('<br/>', " ", $address); ?>.</p>

        <p><strong>Expired on :</strong> <?php 
            if ($this->data['DeathCertificate']['expired_on']) {
                $expired_on = $this->DateFormat->formatDate2Local($this->data['DeathCertificate']['expired_on'], Configure::read('date_format'), true);
            } else if (!empty($patient['FinalBilling']['discharge_date'])) {
                $expired_on = $this->DateFormat->formatDate2Local($patient['FinalBilling']['discharge_date'], Configure::read('date_format'), true);
            }
            echo $expired_on;
        ?></p>

        <p><strong>Cause of Death:</strong> <?php echo nl2br($this->data['DeathCertificate']['cause_of_death']); ?></p>
    </div>

    <!-- Header Table -->
    <table class="header-table" margin-top="65px">

        <tr>
            <td><strong>Date:</strong>
                <?php 
                    if ($this->data['DeathCertificate']['date_of_issue']) {
                        $dateOfIssue = $this->DateFormat->formatDate2Local($this->data['DeathCertificate']['date_of_issue'], Configure::read('date_format'), true);
                    } else {
                        $dateOfIssue = '';
                    }
                    echo $dateOfIssue;
                ?>
            </td>

            <td class="received-by">
                <p><strong>Received by</strong></p>
                <p>Date Received: <span class="underline"></span></p>
                <p>Sign: <span class="underline"></span></p>
                <p>Name of Relative: <span class="underline"></span></p>
                <p>Relationship with Patient: <span class="underline"></span></p>
            </td>

            <td class="doctor-info">
                <p><strong>Dr. B.K. Murali</strong></p>
                <p>MS (Orth.)</p>
                <p>Director</p>
                <p>Orthopaedic Surgeon</p>
            </td>
        </tr>
    </table>

    <!-- Contact Information Section -->
    <div class="contact-info">
        <p class="title">==== CONTACT INFORMATION FOR URGENT QUERIES ====</p>

        <p class="urgent-care">
            ⚠ URGENT CARE/EMERGENCY CARE IS AVAILABLE 24 X 7.<br>
            📞 PLEASE CONTACT: <span>7030974619, 9373111709</span>
        </p>
    </div>
</div>
