<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambulance Service Registration Details</title>
    <!-- Inline CSS for styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        table td {
            font-size: 12px;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* General Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 13px;
            text-align: left;
        }

        /* Table Header and Cell Styles */
        table th, table td {
            padding: 5px 5px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
            font-size: 12px;
        }

        /* Alternating Row Colors */
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Button Styles */
        .patient-hub-button, .submit-disposition-button {
            padding: 8px 16px;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }

        .patient-hub-button {
            background-color: #28a745;
        }

        .submit-disposition-button {
            background-color: #17a2b8;
        }

        .patient-hub-button:hover, .submit-disposition-button:hover {
            opacity: 0.8;
        }

        .btn {
            position: relative;
            background-color: #cd3c3c;
            text-decoration: none;
            color: white !important;
            font-size: 18px;
            border-radius: 3px;
            left: 88%;
        }
    </style>    
</head>
<body>
    <a id="btn" href="/Ambulance/ambu_form" class="btn"> Add New Information </a>

    <div class="container">
        <h1>Ambulance Service Registration Details</h1>
        <table>
            <thead>
                <tr>
                    <th>Driver Name</th>
                    <th>Last Name</th>
                    <th>Ambulance Type</th>
                    <th>Registration Number</th>
                    <th>Ambulance Model</th>
                    <th>Address</th>
                    <th>Service Phone</th>
                    <th>Email</th>
                    <th>Administrator Name</th>
                    <th>Administrator Phone</th>
                    <th>Administrator Email</th>
                    <th>Number of Vehicles</th>
                    <th>Vehicle Details</th>
                    <th>Driver profile</th>
                    <th>Disposition</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ambulanceData)): ?>
                 <?php foreach ($ambulanceData as $ambulance): ?>
                <tr>
                    <td><?= h($ambulance['Ambulance']['first_name']) ?></td>
                    <td><?= h($ambulance['Ambulance']['last_name']) ?></td>
                    <td><?= h($ambulance['Ambulance']['ambulance_type']) ?></td>
                    <td><?= h($ambulance['Ambulance']['ambulance_model']) ?></td>
                    <td><?= h($ambulance['Ambulance']['number_plate']) ?></td>
                    <td><?= h($ambulance['Ambulance']['ambulance_color']) ?></td>
                    <td><?= h($ambulance['Ambulance']['mobile_number']) ?></td>
                    <td><?= h($ambulance['Ambulance']['email']) ?></td>
                    <td><?= h($ambulance['Ambulance']['admin_name']) ?></td>
                    <td><?= h($ambulance['Ambulance']['admin_phone']) ?></td>
                    <td><?= h($ambulance['Ambulance']['admin_email']) ?></td>
                    <td><?= h($ambulance['Ambulance']['number_plate']) ?></td>
                    <td><?= h($ambulance['Ambulance']['vehicle_details']) ?></td>
                    <td> <a href="<?= $this->Html->url(['controller' => 'Ambulance', 'action' => 'driver_profile', $ambulance['Ambulance']['driver_id']]) ?>"  class="badge badge-success" style="color:red;"> Driver Profile</a> </td>
                    <td><a href="<?= $this->Html->url(['controller' => 'Ambulance', 'action' => 'dispostion', $ambulance['Ambulance']['driver_id']]) ?>" class="badge badge-success" style="color:red;"> Disposition </a></td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="15">No data found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
