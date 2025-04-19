<!DOCTYPE html>
<html>
<head>
    <title>Manage Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .forms-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .form-container, .table-container {
            flex: 1 1 100%;
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        @media (min-width: 768px) {
            .form-container, .table-container {
                flex: 1 1 calc(50% - 20px);
            }
        }
    </style>
</head>
<body>

<h1>Manage Records</h1>

<div class="forms-container">
    <!-- Staff Form -->
    <div class="form-container">
        <h2>Staff Form</h2>
        <form action="manage_records" method="POST" onsubmit="return handleFormSubmit('edited')">
            <input type="hidden" name="action" value="staff">
            <input type="hidden" name="staff_id" id="staff_id">
            <label for="create_by">Created By</label>
            <input type="text" name="create_by" id="create_by" required>
            <label for="staff_name">Staff Name</label>
            <input type="text" name="staff_name" id="staff_name" required>
            <button type="submit" class="btn">Save Staff</button>
        </form>
    </div>

    <!-- Company Form -->
    <div class="form-container">
        <h2>Company Form</h2>
        <form action="manage_records" method="POST" onsubmit="return handleFormSubmit('edited')">
            <input type="hidden" name="action" value="company">
            <input type="hidden" name="company_id" id="company_id">
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" id="company_name" required>
            <label for="address">Address</label>
            <input type="text" name="address" id="address">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone">
            <button type="submit" class="btn">Save Company</button>
        </form>
    </div>
</div>

<!-- Staff Table -->
<div class="table-container">
    <h2>Staff List</h2>
    <table>
        <thead>
            <tr>
                <th>Created By</th>
                <th>Staff Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staffList as $staff): ?>
            <tr>
                <td><?= $staff['Staff']['create_by'] ?></td>
                <td><?= $staff['Staff']['staff_name'] ?></td>
                <td>
                    <button class="btn" onclick="editStaff(<?= $staff['Staff']['id'] ?>, '<?= $staff['Staff']['create_by'] ?>', '<?= $staff['Staff']['staff_name'] ?>')">Edit</button>
                    <form action="manage_records" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                        <input type="hidden" name="action" value="staff">
                        <input type="hidden" name="delete_id" value="<?= $staff['Staff']['id'] ?>">
                        <button type="submit" class="btn btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Company Table -->
<div class="table-container">
    <h2>Company List</h2>
    <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($companyList as $company): ?>
            <tr>
                <td><?= $company['CompanyName']['company_name'] ?></td>
                <td><?= $company['CompanyName']['address'] ?></td>
                <td><?= $company['CompanyName']['email'] ?></td>
                <td><?= $company['CompanyName']['phone'] ?></td>
                <td>
                    <button class="btn" onclick="editCompany(<?= $company['CompanyName']['id'] ?>, '<?= $company['CompanyName']['company_name'] ?>', '<?= $company['CompanyName']['address'] ?>', '<?= $company['CompanyName']['email'] ?>', '<?= $company['CompanyName']['phone'] ?>')">Edit</button>
                    <form action="manage_records" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                        <input type="hidden" name="action" value="company">
                        <input type="hidden" name="delete_id" value="<?= $company['CompanyName']['id'] ?>">
                        <button type="submit" class="btn btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }

    function handleFormSubmit(action) {
        alert(`Record ${action} successfully!`);
        return true; // Allow the form to submit
    }

    function editStaff(id, createBy, staffName) {
        document.getElementById('staff_id').value = id;
        document.getElementById('create_by').value = createBy;
        document.getElementById('staff_name').value = staffName;
    }

    function editCompany(id, companyName, address, email, phone) {
        document.getElementById('company_id').value = id;
        document.getElementById('company_name').value = companyName;
        document.getElementById('address').value = address;
        document.getElementById('email').value = email;
        document.getElementById('phone').value = phone;
    }
</script>

</body>
</html>
