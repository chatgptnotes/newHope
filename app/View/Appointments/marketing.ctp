<h2>Marketing Data Entry</h2>
<!-- page create by dinesh tawade senior developer  -->
<!-- page create on 20/12/2019 -->
<style>
    .responsive-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .responsive-table th, .responsive-table td {
        border: 1px solid #141010;
        padding: 12px;
    }
    .responsive-table th {
        background-color: #80979b;
        / text-align: left; /
    }
    .responsive-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .responsive-table tr:hover {
        background-color: #ddd;
    }
    .form-container {
        margin-top: 20px;
    }
    .form-container input[type="text"], .form-container input[type="date"], .form-container select {
        width: 100%;
        padding: 8px;
        margin: 4px 0;
        box-sizing: border-box;
    }
    .form-container button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
    }
    .form-container button:hover {
        background-color: #45a049;
    }
</style>

<table class="responsive-table">
    <thead>
        <tr>
            <th>COMPANY NAME</th>
            <th>HR NAME</th>
            <th>PHONE NUMBER</th>
            <th>EMAIL ID</th>
            <th>EMPLOYEE SIZE</th>
            <th>REMARK</th>
            <th>TIED HOSPITAL</th>
            <th>DISPOSITION</th>
            <th>SUB-DISPOSITION</th>
            <th>FINAL STATUS</th>
            <th>DATE OF EVENT </th>
            <th>MARKETING TEAM</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comp as $data): ?>
        <tr>
            <td><?= h($data['CompDetails']['company_name']); ?></td>
            <td><?= h($data['CompDetails']['hr_name']); ?></td>
            <td><?= h($data['CompDetails']['number']); ?></td>
            <td><?= h($data['CompDetails']['email_id']); ?></td>
            <td><?= h($data['CompDetails']['employee_size']); ?></td>
            <td><?= h($data['CompDetails']['remark']); ?></td>
            <td><?= h($data['CompDetails']['tied_hospital']); ?></td>
            <td><?= h($data['CompDetails']['disposition']); ?></td>
            <td><?= h($data['CompDetails']['sub_disposition']); ?></td>
            <td><?= h($data['CompDetails']['final_status']); ?></td>
            <td><?= h($data['CompDetails']['date_of_event']); ?></td>
            <td><?= h($data['CompDetails']['marketing_team']); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <form action="<?php echo $this->Html->url(array('controller' => 'Appointments', 'action' => 'marketing')); ?>" method="post">
                <td><input type="text" name="company_name" placeholder="Company Name"></td>
                <td><input type="text" name="hr_name" placeholder="HR Name"></td>
                <td><input type="tel" name="number" placeholder="Phone Number" pattern="[0-9]{10}"></td>

                <td><input type="email" name="email_id" placeholder="Email ID"></td>
                <td><input type="number" name="employee_size" placeholder="Employee Size"></td>
                <td><input type="text" name="remark" placeholder="Remark"></td>
                <td><input type="text" name="tied_hospital" placeholder="Tied Hospital"></td>
                <td>
                    <select name="disposition">
                        <option value="">Select Disposition</option>
                        <option value="Physical Meeting done">Physical Meeting done</option>
                        <option value="called , picked">called , picked</option>
                        <option value="called but did not pick">called but did not pick</option>
                        <option value="whatsapp message sent">whatsapp message sent</option>
                        <option value="zoom meet">zoom meet</option>
                        <option value="Email sent">Email sent</option>
                    </select>
                </td>
                <td>
                    <select name="sub_disposition">
                        <option value="">Select Sub Disposition</option>
                        <option value="call and followup regarding proposal submitted">call and followup regarding proposal submitted</option>
                        <option value="Generate QR code for staff">Generate QR code for staff</option>
                        <option value="Proposal to be given">Proposal to be given</option>
                        <option value="Proposal given">Proposal given</option>
                        <option value="Poster frame to be given">Poster frame to be given</option>
                        <option value="Poster frame given">Poster frame given</option>
                    </select>
                </td>
                <td><input type="text" name="final_status" placeholder="Final Status"></td>
                <td><input type="date" name="date_of_event"></td>
                <td>
                    <select name="marketing_team">
                        <?php foreach ($marketTeam as $data): ?>
                            <option value="<?= h($data['MarketingTeam']['name']); ?>">
                                <?= h($data['MarketingTeam']['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><button type="submit">Save</button></td>
            </form>
        </tr>
    </tbody>
</table>
