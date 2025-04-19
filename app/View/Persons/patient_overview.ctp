<?php
// debug($allPatients_call_history);exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            /*text-align: center;*/
            overflow-x: auto;
            white-space: nowrap
        }

        h2 {
            color: #333;
        }

        .tab {
            display: flex;
            justify-content: center;
            background: #007bff;
            border-radius: 8px;
            padding: 10px;
        }

        .tab button {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 12px 20px;
            margin: 5px;
            font-size: 17px;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }

        .tab button:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .tab button.active {
            background-color: #0056b3;
        }

        .tabcontent {
            display: none;
            padding: 20px;
            margin-top: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .filter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .filter-container input,
        .filter-container button {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-container button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .filter-container button:hover {
            background-color: #0056b3;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            font-size:13px;
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #007bff;
            color: white;
        }

        .for_width {
            font-size: 13px;
            max-width: 200px;
            /* Set your preferred width */
            overflow: scroll;
            white-space: nowrap;
            text-overflow: ellipsis;
            position: relative;
        }
        
            .for_width::-webkit-scrollbar {
                display: none; 
            }
        /* max-width: 150px;
overflow: scroll; */

        /* Enable Scroll Inside Cell */
        .for_width .scrollable-content {
            max-height: 50px;
            /* Limit height */
            max-width: 150px;
            /* Match with column width */
            /*overflow-y: auto;*/
            /* Enable vertical scrolling */
            /*overflow-x: hidden;*/
            /* Hide horizontal overflow */
            white-space: normal;
            /* Allow multi-line text */
            padding: 5px;
            /*border: 1px solid #ddd;*/
            /*background: #f9f9f9;*/
        }

        .floating-box {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 8px;
            z-index: 1000;
            min-width: 300px;
            text-align: center;
        }

        .floating-content {
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }

        .view-btn {
            display: inline-block;
            background-color: green;
            /* Blue color like primary button */
            color: white;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background 0.3s, transform 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border: none;
            text-transform: uppercase;
            margin-left: auto;
            margin-right: auto;
        }

        .view-btn:hover {
            background-color: #0056b3;
            /* Darker shade on hover */
            transform: scale(1.05);
        }

        .view-btn:active {
            background-color: #003f80;
            /* Even darker shade when clicked */
            transform: scale(0.98);
        }
    </style>
</head>

<body>
    <div style="display: flex; ">
        <a href="/"><img src="/theme/Black/img/icons/ghar.png" alt="Home Screen" title="Home Screen" style="height: 44px;margin-left: 15px; margin-top: 10px;"></a>
        <h2 style="margin-left: 4%;">Patient Overview Station</h2>
        <!--<p>Click on a tab to learn more about the city:</p> -->
    </div>
    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'London')">Call Today </button>
        <button class="tablinks" onclick="openCity(event, 'Paris')">All Patient </button>
        <button class="tablinks" onclick="openCity(event, 'Tokyo')">Last Call History </button>
    </div>

    <!-- Filter Section -->
    <div class="filter-container">
        <label for="minDate">From:</label>
        <input type="date" id="minDate">
        <label for="maxDate">To:</label>
        <input type="date" id="maxDate">
        <button onclick="clearFilters()">Clear</button>
    </div>

    <div id="London" class="tabcontent">
        <h3>Today Call Information</h3>
        <!--<p>London is the capital of England.</p> -->

        <div class="table-container">
            <table id="londonTable" class="display">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th style="display:none;">Patient ID</th>
                        <th style="display:none;">Person ID</th>
                        <th>Call</th>
                        <th>Visit Date</th>
                        <th>Patient Name</th>
                        <th>View</th>
                        <th>Phone</th>
                        <th>Relationship Man</th>
                        <th>Diagnosis/Surgery</th>
                        <th>Admission Type</th>
                        <th>Department</th>
                        <th>Hospital Name</th>
                        <th>Budget Amount</th>
                        <th>Follow Up On</th>
                        <th>Called On</th>
                        <th>Disposition</th>
                        <th>Sub-Disposition</th>
                        <th>Remark</th>
                        <th>Telecaller</th>
                        <th>Update Disposition</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $srNo = 1; ?>
                    <?php foreach ($patient_overview as $patient): ?>
                        <tr>
                            <form action="save_dispositiondata" method="post" enctype="multipart/form-data">
                                <!-- Serial Number -->
                                <td><?php echo $srNo++; ?></td>

                                <!-- Hidden Patient ID -->
                                <td style="display:none;">
                                    <input type="hidden" name="patient_id" value="<?php echo h($patient['Patient']['id']); ?>">
                                    <?php echo h($patient['Patient']['id']); ?>
                                </td>

                                <!-- Hidden Person ID -->
                                <td style="display:none;">
                                    <input type="hidden" name="person_id" value="<?php echo h($patient['Person']['id']); ?>">
                                    <?php echo h($patient['Person']['id']); ?>
                                </td>

                                <!-- Call -->
                                <td>
                                    <input type="hidden" name="mobile" value="<?php echo h($patient['Person']['mobile']); ?>">
                                    <i style="font-size:24px" class="fa">
                                        <a href="tel:<?php echo h($patient['Person']['mobile']); ?>">&#xf095;</a>
                                    </i>
                                </td>

                                <!-- Visit Date -->
                                <td><span><?php echo date('d-m-Y', strtotime($patient['Patient']['create_time'])); ?></span></td>


                                <!-- Patient Name -->
                                <td>
                                    <input type="hidden" name="patient_name" value="<?php echo h($patient['Person']['first_name'] . ' ' . $patient['Person']['last_name']); ?>">
                                    <a href="<?php echo $this->Html->url(array('controller' => 'Patients', 'action' => 'new_patient_hub', h($patient['Patient']['id']), h($patient['Person']['id']))); ?>">
                                        <?php echo h($patient['Person']['first_name'] . ' ' . $patient['Person']['last_name']); ?>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="btn btn-success view-btn"
                                        data-patient-id="<?php echo h($patient['Patient']['id']); ?>"
                                        data-name="<?php echo h($patient['Person']['first_name'] . ' ' . $patient['Person']['last_name']); ?>"
                                        data-hospital-name="<?php echo h($patient['Patient']['hospital_name']); ?>"> <!-- Sending hospital name -->
                                        View
                                    </span>
                                </td>
                                <!-- Phone -->
                                <td><?php echo h($patient['Person']['mobile']); ?></td>
                                <td class="for_width"><?php echo h($patient['Person']['relationship_manager']); ?></td>

                                <!-- Diagnosis/Surgery -->
                                <td class="for_width scrollable-content">
                                    <div class="scrollable-content">
                                        <input type="hidden" name="data[diagnosis]" value="<?php echo h($patient['DischargeSummary']['final_diagnosis']); ?>">
                                        <?php echo h($patient['DischargeSummary']['final_diagnosis']); ?>
                                    </div>
                                </td>

                                <!-- Admission Type -->
                                <td class="for_width">
                                    <input type="hidden" name="data[admission_type]" value="<?php echo h($patient['Patient']['admission_type']); ?>">
                                    <?php echo h($patient['Patient']['admission_type']); ?>
                                </td>

                                <!-- Department -->
                                <td class="for_width">
                                    <input type="hidden" name="data[department]" value="<?php echo h($patient['Department']['name']); ?>">
                                    <?php echo h($patient['Department']['name']); ?>
                                </td>

                                <!-- Hospital Name -->
                                <td class="for_width">
                                    <input type="hidden" name="data[database]" value="<?php echo h($patient['Patient']['database']); ?>">
                                    <?php

                                    $hospitalMapping = [
                                        'db_HopeHospital' => 'Hope Hospital',
                                        'db_Ayushman' => 'Ayushman Hospital'
                                    ];
                                    $dbName = h($patient['Patient']['hospital_name']);
                                    $hospitalName = isset($hospitalMapping[$dbName]) ? $hospitalMapping[$dbName] : $dbName;
                                    echo $hospitalName;
                                    ?>
                                </td>

                                <!-- Budget Amount -->
                                <td class="for_width">
                                    <div class="previous-data">
                                        <p class="badge badge-info"><?php echo !empty($patient['Disposition']['budget_amount']) ? h($patient['Disposition']['budget_amount'])  : 'No previous data available';  ?></p>
                                    </div>
                                    <select class="form-control" name="budget_amount">
                                        <option value="">Select Budget Amount</option>
                                        <?php foreach (range(50000, 200000, 10000) as $amount): ?>
                                            <option value="₹<?php echo $amount; ?>">₹<?php echo number_format($amount); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <!-- Queue Date -->
                                <td class="for_width">
                                    <div class="previous-data">
                                        <p class="badge badge-info"><?php echo !empty($patient['Disposition']['queue_date']) ? h($patient['Disposition']['queue_date'])  : 'No previous data available';  ?></p>

                                    </div>
                                    <input type="date" class="form-control" name="data[queue_date]">
                                </td>

                                <!-- Follow-up Date -->
                                <td class="for_width">
                                    <div class="previous-data">
                                        <p class="badge badge-info"><?php echo !empty($patient['Disposition']['review_date']) ? h($patient['Disposition']['review_date'])  : 'No previous data available';  ?></p>
                                    </div>
        <input type="date" class="form-control" name="data[follow_up_date]" value="<?php echo date('Y-m-d'); ?>" disabled>
                                </td>

                                <!-- Disposition -->
                                <td class="for_width">
                                    <div class="previous-data">
                                        <p class="badge badge-info">
                                            <?php echo !empty($patient['DispositionList']['disposition_name'])
                                                ? h($patient['DispositionList']['disposition_name'])
                                                : 'No previous data available'; ?>
                                        </p>
                                    </div>
                                    <select id="disposition_<?php echo h($patient['Patient']['id']); ?>"
                                        class="form-control disposition-dropdown"
                                        name="disposition"
                                        data-patient-id="<?php echo h($patient['Patient']['id']); ?>" required>
                                        <option value="">Select Disposition</option>
                                        <?php foreach ($dispositions as $disposition): ?>
                                            <option value="<?php echo h($disposition['DispositionList']['id']); ?>">
                                                <?php echo h($disposition['DispositionList']['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <!-- Sub-Disposition -->
                                <td class="for_width">
                                    <div class="previous-data">
                                        <p class="badge badge-info">
                                            <?php echo !empty($patient['SubDispositionList']['sub_disposition_name'])
                                                ? h($patient['SubDispositionList']['sub_disposition_name'])
                                                : 'No previous data available'; ?>
                                        </p>
                                    </div>
                                   <select id="sub_disposition_<?php echo h($patient['Patient']['id']); ?>"
        class="form-control sub-disposition-dropdown"
        name="sub_disposition" required>
    <option value="">Select Sub-Disposition</option>
    
    <!-- Disposition 1 -->
    <option value="1">Mobile Number Not Reachable</option>
    <option value="2">Out of Network</option>
    <option value="3">Invalid Number</option>
    <option value="4">Number Does Not Exist</option>
    <option value="5">Not in Service</option>
    <option value="6">Switched Off</option>
    <option value="7">Ringing, No Answer</option>

    <!-- Disposition 2 -->
    <option value="8">Medicine Ineffective, Suggested Hospital Change</option>
    <option value="9">Unsatisfactory Treatment</option>
    <option value="10">No Longer Visiting the Hospital</option>
    <option value="11">Seeking Treatment at Another Facility</option>
    <option value="12">Poor Staff Behavior</option>
    <option value="13">Doctor Not Treating Properly</option>
    <option value="14">Hospital Services Poor</option>
    <option value="15">Hygiene and Cleanliness Issues in Hospital</option>
    <option value="16">Lack of Proper Communication from Staff</option>

    <!-- Disposition 3 -->
    <option value="17">Treatment Effective, Patient Feeling Better</option>
    <option value="18">Doctors and Staff Behavior Was Good</option>
    <option value="19">Quick and Efficient Services</option>
    <option value="20">Clean and Well-Maintained Facilities</option>
    <option value="21">Hospital Recommended to Others</option>
    <option value="22">Good Communication and Patient Support</option>
    <option value="23">Patient Satisfied with Overall Experience</option>

    <!-- Disposition 4 -->
    <option value="24">Do Not Call Again</option>
    <option value="25">Not Interested in Discussion</option>
    <option value="26">Visiting Another Hospital</option>
    <option value="27">Prefer Not to Share Information</option>

    <!-- Disposition 5 -->
    <option value="28">Currently Busy</option>
    <option value="29">Driving, Request to Call Later</option>
    <option value="30">Request to Call Back Later</option>
    <option value="31">Will Notify Later</option>
    <option value="32">Request to Call After a Specific Time</option>

    <!-- Disposition 6 -->
    <option value="33">Follow-Up After 1 Week</option>
    <option value="34">Follow-Up After 2 Days</option>
    <option value="35">Follow-Up After 2 Weeks</option>
    <option value="36">Follow-Up After 2 Months</option>
    <option value="37">Patient Confirmed Reaching Hospital</option>
    <option value="38">Follow-Up for Feedback Post-Treatment</option>

    <!-- Disposition 7 -->
    <option value="39">Patient Has Passed Away</option>
    <option value="40">Death Confirmed at Hospital</option>

    <!-- Disposition 8 -->
    <option value="41">QR Code Successfully Generated</option>
    <option value="42">Interested in QR Code Generation</option>
    <option value="43">Not Interested in QR Code Generation</option>

    <!-- Disposition 9 -->
    <option value="44">Receiving Treatment as Private Patient</option>
    <option value="45">Requested No Schemes</option>
    <option value="46">Treatment at Full Cost</option>

    <!-- Disposition 10 -->
    <option value="47">Ayushman Bharat Card Holder</option>
    <option value="48">ESIC Treatment</option>
    <option value="49">MJPJAY (Mahatma Jyotiba Phule Jan Arogya Yojana) Treatment</option>
    <option value="50">PMJAY (Pradhan Mantri Jan Arogya Yojana) Treatment</option>
    <option value="51">Beneficiary of Other State or Central Government Health Scheme</option>
    <option value="52">Requested Information About Scheme Coverage</option>

    <!-- Disposition 11 -->
    <option value="53">Language Barrier, Unable to Communicate</option>
    <option value="54">Contact Details Updated</option>
    <option value="55">Request for Additional Information</option>

    <!-- Disposition 12 -->
    <option value="56">Incorrect Number</option>
</select>

                                </td>

                                <!-- Telecaller -->
                                <td class="for_width">
                                    <div class="previous-data">
                                        <p class="badge badge-info"><?php echo !empty($patient['Disposition']['remark']) ? h($patient['Disposition']['remark'])  : 'No previous data available';  ?></p>
                                    </div>
                                    <input type="text" name="data[remark]" value="<?php echo h($patient['Disposition']['remark']); ?>">
                                </td>
                                <td class="for_width">
                                    <div class="previous-data">
                                        <p class="badge badge-info"><?php echo !empty($patient['Disposition']['call_assigned_to']) ? h($patient['Disposition']['call_assigned_to'])  : 'No previous data available';  ?></p>
                                    </div>
                                    <select class="form-control" name="call_assigned_to" required>
                                        <option value="">Select Telecaller</option>
                                        <option>Ruchi</option>
                                        <option>Neeraj</option>
                                        <option>Dolly</option>
                                        <option>Arya</option>
                                    </select>
                                </td>
                                <!-- Save Button -->
                                <td>
                                    <button type="submit" class="btn btn-primary" style="margin-left: 38%;">Save</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="Paris" class="tabcontent">
        <h3>All Patient</h3>
        <div class="table-container">
            <table id="parisTable" class="display">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th> <!-- Master Checkbox -->
                        <th>Sr No.</th>
                        <th>Name</th>
                        <th>Patient ID</th>
                        <th>Mobile</th>
                        <th>Hospital Name</th>
                        <th>Visited date</th>
                        <th>Discharge date</th>
                        <th>Relationship Manager</th>
                        <th>View Disposition</th>
                        <th>Called On</th>
                        <th>Update Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $srNo = 1; ?>
                    <?php foreach ($patient_overview_getpatient as $patient): ?>
                        <?php
                        $patientID = h($patient['Patient']['id']);
                        $fullName = h($patient['Person']['first_name'] . ' ' . $patient['Person']['last_name']);
                        $mobile = h($patient['Person']['mobile']);
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="rowCheckbox"
                                    data-patient-id="<?php echo $patientID; ?>"
                                    data-name="<?php echo $fullName; ?>"
                                    data-mobile="<?php echo $mobile; ?>">
                            </td>
                            <td><?php echo $srNo++; ?></td>
                            <td><?php echo $fullName; ?></td>
                            <td><?php echo $patientID; ?></td>
                            <td><?php echo $mobile; ?></td>
                            <td>
                                <?php
                                $hospitalMapping = [
                                    'db_HopeHospital' => 'Hope Hospital',
                                    'db_Ayushman' => 'Ayushman Hospital'
                                ];
                                $dbName = h($patient['Patient']['hospital_name']);
                                $hospitalName = isset($hospitalMapping[$dbName]) ? $hospitalMapping[$dbName] : $dbName;
                                echo $hospitalName;
                                ?>
                            </td>
                            <td><?php echo h($patient['Patient']['create_time']); ?></td>
                            <td><?php echo h($patient['FinalBilling']['create_time']); ?></td>
                            <td><?php echo h($patient['Person']['relationship_manager']); ?></td>
                            <td class="text-center">
                                <span class="btn btn-success view-btn"
                                    data-patient-id="<?php echo $patientID; ?>"
                                    data-name="<?php echo $fullName; ?>"
                                    data-hospital-name="<?php echo h($patient['Patient']['hospital_name']); ?>">
                                    View
                                </span>
                            </td>
                            <td><?php echo h($patient['Disposition']['create_time']); ?></td>
                            <td>
                                <div class="input-group">
                                    <span><?php echo h($patient['FinalBilling']['reason_of_discharge']); ?></span>
                                    <select class="form-control reason_of_discharge" data-patient-id="<?php echo $patientID; ?>"
                                        data-hospital-name="<?php echo h($patient['Patient']['hospital_name']); ?>">
                                        <option value="">Select Reason</option>
                                        <option value="Recovered">Recovered</option>
                                        <option value="Transferred">Transferred</option>
                                        <option value="Left Against Medical Advice (LAMA)">Left Against Medical Advice (LAMA)</option>
                                        <option value="DAMA">DAMA</option>
                                        <option value="Death">Death</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success btn-sm update-discharge" data-patient-id="<?php echo $patientID; ?>">
                                            <i class="fas fa-check"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Buttons for Actions -->
            <button id="sendWhatsAppMessage" class="btn btn-success">Send WhatsApp Message</button>
            <!-- Button for getting selected rows -->
            <button id="getSelectedPatients" class="btn btn-primary">Get Selected Patients</button>

        </div>
    </div>


    <!-- Floating Div for Real-time Data -->
    <div id="floatingDiv" class="floating-box">
        <div class="floating-content">
            <span class="close-btn">&times;</span>
            <h4>Patient Details</h4>
            <p><strong>Name:</strong> <span id="patientName"></span></p>
            <!-- Disposition Table -->
            <h5>Disposition History</h5>
            <table border="1" id="dispositionTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Budget</th>
                        <th>Disposition</th>
                        <th>Sub-Disposition</th>
                        <!--<th>Outcome</th>-->
                        <th>Follow Up Date</th>
                        <th>Remark</th>

                        <th>Call Assigment</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded dynamically -->
                </tbody>
            </table>
        </div>
    </div>
   <div id="Tokyo" class="tabcontent">
    <h3>Last Call History</h3>

    <!-- Date Filter Form -->
    <form method="post" action="<?= $this->webroot . 'persons/patient_overview'; ?>"> <!-- Make sure the action is patient_overview -->
    <label for="selected_date">Select Date:</label>
    <input type="date" name="selected_date" value="<?= !empty($selected_date) ? $selected_date : date('Y-m-d'); ?>" />
    <button type="submit">Filter</button>
</form>

    <div class="table-container">
        <table id="tokyoTable" class="display">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient Name</th>
                    <th>Disposition</th>
                    <th>Sub-Disposition</th>
                    <th>Follow-up Date</th>
                    <th>Remark</th>
                    <th>Call Assigned To</th>
                    <!--<th>Budget Amount</th>-->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($allPatients_call_history)): ?>
                    <?php foreach ($allPatients_call_history as $row): ?>
                        <tr>
                            <td><?= !empty($row['Disposition']['created_at']) ? date('Y-m-d H:i:s', strtotime($row['Disposition']['created_at'])) : 'N/A' ?></td>
                            <td><?= !empty($row['Disposition']['patien_name']) ? h($row['Disposition']['patien_name']) : 'N/A' ?></td>
                            <td><?= !empty($row['Disposition']['disposition']) ? h($row['DispositionList']['disposition_name']) : 'N/A' ?></td>
                            <td><?= !empty($row['Disposition']['sub_disposition']) ? h($row['SubDispositionList']['sub_disposition_name']) : 'N/A' ?></td>
                            <td><?= !empty($row['Disposition']['follow_up_date']) ? date('Y-m-d', strtotime($row['Disposition']['queue_date'])) : 'N/A' ?></td>
                            <td><?= !empty($row['Disposition']['remark']) ? h($row['Disposition']['remark']) : 'N/A' ?></td>
                            <td><?= !empty($row['Disposition']['call_assigned_to']) ? h($row['Disposition']['call_assigned_to']) : 'N/A' ?></td>
                          
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


    <script>
        function clearFilters() {
            $('#minDate, #maxDate').val('');
            londonTable.draw();
            parisTable.draw();
            tokyoTable.draw();
        }
        $(document).ready(function() {
            // Initialize all DataTables
            var londonTable = $('#londonTable').DataTable();
            var parisTable = $('#parisTable').DataTable();
            var tokyoTable = $('#tokyoTable').DataTable();

            // Function to handle View Button Click (Event Delegation for Dynamic Elements)
            $(document).on("click", ".view-btn", function() {
                var patientId = $(this).data("patient-id");
                var patientName = $(this).data("name");
                var hospitalName = $(this).data("hospital-name");

                // Update Patient Info
                $("#patientName").text(patientName);
                $("#patientId").text(patientId);

                // Fetch Disposition Data with AJAX
                $.ajax({
                    url: "fetchDispositionData",
                    type: "POST",
                    data: {
                        patient_id: patientId,
                        hospital_name: hospitalName
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            var tableBody = $("#dispositionTable tbody");
                            tableBody.empty(); // Clear old data

                            $.each(response.data, function(index, disposition) {
                                tableBody.append(
                                    `<tr>
                                <td>${disposition.date || 'N/A'}</td>
                                <td>${disposition.patient_name || 'N/A'}</td>
                                 <td>${disposition.budget_amount || 'N/A'}</td>
                                <td>${disposition.disposition_name || 'N/A'}</td>  <!-- ✅ Fixed -->
                                <td>${disposition.sub_disposition_name || 'N/A'}</td>  <!-- ✅ Fixed -->
                
                                <td>${disposition.queue_date || 'N/A'}</td>
                                <td>${disposition.remark || 'N/A'}</td>
                                <td>${disposition.call_assigned_to || 'N/A'}</td>
                            </tr>`
                                );
                            });

                            $("#floatingDiv").fadeIn(); // Show Floating Div
                        } else {
                            alert("No disposition data found.");
                        }
                    },
                    error: function(xhr) {
                        console.error("AJAX Error:", xhr.responseText);
                        alert("Error fetching data.");
                    }
                });
            });

            // Close Floating Div
            $(document).on("click", ".close-btn", function() {
                $("#floatingDiv").fadeOut();
            });

            // Hide floating div when clicked outside
            $(document).click(function(event) {
                if (!$(event.target).closest(".floating-box, .view-btn").length) {
                    $("#floatingDiv").fadeOut();
                }
            });

            // Custom Date Filtering Function for All Tables
            $.fn.dataTable.ext.search.push(function(settings, data) {
                var minDate = $('#minDate').val();
                var maxDate = $('#maxDate').val();
                var dateStr = data[3]; // Adjust index as per date column

                if (!dateStr) return false; // Skip rows without date

                var date = new Date(dateStr);
                var min = minDate ? new Date(minDate) : null;
                var max = maxDate ? new Date(maxDate) : null;

                return (min === null || date >= min) && (max === null || date <= max);
            });

            // Apply date filter on change
            $('#minDate, #maxDate').on('change', function() {
                londonTable.draw();
                parisTable.draw();
                tokyoTable.draw();
            });


            $(document).on("change", ".disposition-dropdown", function() {
                var dispositionId = $(this).val();
                var patientId = $(this).data("patient-id");
                var subDispositionDropdown = $("#sub_disposition_" + patientId);

                subDispositionDropdown.html('<option value="">Select Sub-Disposition</option>');

                fetch('<?php echo $this->Html->url(array("controller" => "Persons", "action" => "getSubDispositions")); ?>/' + dispositionId)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subDisposition => {
                            subDispositionDropdown.append(new Option(subDisposition.name, subDisposition.id));
                        });
                    })
                    .catch(error => console.error("Error fetching sub-dispositions:", error));
            });

            // Update Discharge Reason
            $(document).on("click", ".update-discharge", function() {
                var patientId = $(this).data("patient-id");
                var reason = $(this).closest("td").find(".reason_of_discharge").val();
                var hospitalName = $(this).closest("td").find(".reason_of_discharge").data("hospital-name");

                if (!reason) {
                    alert("Please select a reason before updating.");
                    return;
                }

                $.ajax({
                    url: "updateReasonOfDischarge",
                    type: "POST",
                    data: {
                        patient_id: patientId,
                        hospital_name: hospitalName,
                        reason_of_discharge: reason
                    },
                    dataType: "json",
                    success: function(response) {
                        if (typeof response === "string") {
                            response = JSON.parse(response); // Convert JSON string to object
                        }

                        if (response.status === "success") {
                            alert("Discharge reason updated successfully!");
                        } else {
                            console.error("Failed Response:", response);
                            alert("Failed to update discharge reason. Server Response: " + (response.message || "Unknown error"));
                        }
                    },
                    error: function(xhr) {
                        console.error("AJAX Error:", xhr.responseText);
                        alert("Error updating reason. Please try again.");
                    }
                });
            });

            // Auto-click first tab on load
            document.querySelector(".tab button").click();
        });

        // Tab switching function
        function openCity(evt, cityName) {
            $(".tabcontent").hide();
            $(".tablinks").removeClass("active");

            $("#" + cityName).show();
            evt.currentTarget.classList.add("active");
        }
    </script>

    <script>
 document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("sendWhatsAppMessage").addEventListener("click", async function () {
        let selectedPhones = [];
        
        // Loop through checkboxes to get selected phone numbers
        document.querySelectorAll(".rowCheckbox:checked").forEach(function (checkbox) {
            let mobile = checkbox.getAttribute("data-mobile").trim();
            if (mobile) {
                selectedPhones.push(mobile);
            }
        });

        if (selectedPhones.length === 0) {
            alert('Please select at least one phone number.');
            return;
        }

        const apiUrl = "https://public.doubletick.io/whatsapp/message/template";
        const apiKey = "key_8sc9MP6JpQ";  // Your API Key

        // Loop through each selected phone number and send the message
        for (const phone of selectedPhones) {
            const payload = {
                messages: [
                    {
                        to: "+91" + phone,  // Prepending country code
                        content: {
                            templateName: "pi_holi",  // Your fixed template name
                            language: "en"  // Language of the template
                        }
                    }
                ]
            };

            try {
                const response = await fetch(apiUrl, {
                    method: "POST",
                    headers: {
                        "accept": "application/json",
                        "content-type": "application/json",
                        "Authorization": apiKey  // Authorization with the API key
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (response.ok) {
                    document.getElementById('response').textContent = `Message sent successfully to ${phone}`;
                } else {
                    document.getElementById('response').textContent = `Error sending to ${phone}: ${result.message || "Something went wrong."}`;
                }
            } catch (error) {
                console.error(error);
                document.getElementById('response').textContent = "Error sending message. Check the console for more details.";
            }
        }
    });
});



   </script>
</body>

</html>