<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile & Call Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .profile-container {
            max-width: 100%;
            background-color: #fff;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h3 {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-section {
            margin-bottom: 30px;
        }

        .profile-section h2 {
            margin-bottom: 10px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 5px;
        }

        .profile-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .profile-info label {
            font-weight: bold;
        }

        .profile-info span {
            width: 48%;
            text-align: left;
        }

        /* Full-width section for file uploads */
        .file-upload {
            margin-bottom: 20px;
        }

        .file-upload label {
            font-weight: bold;
        }

        .file-upload img {
            display: block;
            margin-top: 10px;
            max-width: 200px;
            border: 1px solid #ddd;
        }

        .profile-picture img {
            max-width: 150px;
            border-radius: 50%;
            border: 2px solid #ddd;
            margin-bottom: 20px;
        }

        .profile-picture {
            text-align: center;
            margin-bottom: 30px;
        }

        .table-container {
            margin-top: 50px;
            max-width: 100%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        td {
            text-align: left;
        }

        @media (max-width: 768px) {
            .profile-info {
                flex-direction: column;
            }

            .profile-info label, .profile-info span {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="profile-container">
    <h2>Driver Profile</h2>
    
    <p><strong>First Name:</strong> <?= h($ambulanceData['Ambulance']['first_name']) ?></p>
    <p><strong>Last Name:</strong> <?= h($ambulanceData['Ambulance']['last_name']) ?></p>
    <p><strong>Ambulance Type:</strong> <?= h($ambulanceData['Ambulance']['ambulance_type']) ?></p>
    <p><strong>Ambulance Model:</strong> <?= h($ambulanceData['Ambulance']['ambulance_model']) ?></p>
    <p><strong>Number Plate:</strong> <?= h($ambulanceData['Ambulance']['number_plate']) ?></p>
    <p><strong>Ambulance Color:</strong> <?= h($ambulanceData['Ambulance']['ambulance_color']) ?></p>
    <p><strong>Mobile Number:</strong> <?= h($ambulanceData['Ambulance']['mobile_number']) ?></p>
    <p><strong>Email:</strong> <?= h($ambulanceData['Ambulance']['email']) ?></p>

    <h3>Uploaded Documents</h3>
    <p><strong>Driver Photo:</strong> <img src="<?= $this->Html->image($ambulanceData['Ambulance']['photo']) ?>" alt="Driver Photo" /></p>
    <p><strong>Ambulance Photo:</strong> <img src="<?= $this->Html->image($ambulanceData['Ambulance']['ambulance_photo']) ?>" alt="Ambulance Photo" /></p>
    <p><strong>Aadhaar Front:</strong> <img src="<?= $this->Html->image($ambulanceData['Ambulance']['aadhaar_front']) ?>" alt="Aadhaar Front" /></p>
    <p><strong>Aadhaar Back:</strong> <img src="<?= $this->Html->image($ambulanceData['Ambulance']['aadhaar_back']) ?>" alt="Aadhaar Back" /></p>
    <p><strong>License:</strong> <img src="<?= $this->Html->image($ambulanceData['Ambulance']['license']) ?>" alt="Driver's License" /></p>
    <p><strong>Vehicle RC:</strong> <img src="<?= $this->Html->image($ambulanceData['Ambulance']['vehicle_rc']) ?>" alt="Vehicle RC" /></p>
</div>

<div class="table-container">
    <h3 class="text-center">Submitted Call Information</h3>
    <table class="table table-bordered table-striped" id="dataTable">
        <thead>
            <tr>
                <th>Caller ID</th>
                <th>Patient Name</th>
                <th>Call Duration</th>
                <th>Patient Mobile</th>
                <th>Call Assigned To</th>
                <th>Call Timestamp</th>
                <th>Disposition</th>
                <th>Sub-Dispositions</th>
                <th>Outcome</th>
                <th>Follow-Up Date</th>
                <th>Follow-Up Action</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php foreach ($dispositions as $disposition): ?>
            <tr>
                <td><?= h($disposition['Disposition']['ambulance_id']) ?></td>
                <td><?= h($ambulance['Ambulance']['first_name']) . ' ' . h($ambulance['Ambulance']['last_name']) ?></td>
                <td>Automatically Calculated</td> <!-- Example Placeholder -->
                <td><?= h($ambulance['Ambulance']['mobile_number']) ?></td>
                <td><?= h($disposition['Disposition']['call_assigned_to']) ?></td>
                <td><?= h($disposition['Disposition']['call_timestamp']) ?></td>
                <td><?= h($disposition['Disposition']['disposition']) ?></td>
                <td><?= h($disposition['Disposition']['sub_disposition']) ?></td>
                <td><?= h($disposition['Disposition']['outcome']) ?></td>
                <td><?= h($disposition['Disposition']['follow_up_date']) ?></td>
                <td><?= h($disposition['Disposition']['follow_up_action']) ?></td>
                <td><?= h($disposition['Disposition']['remark']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


</body>
</html>
