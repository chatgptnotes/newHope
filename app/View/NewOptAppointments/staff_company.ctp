<!DOCTYPE html>
<html>
<head>
    <title>Update Staff and Company</title>
      <a href="/"><img src="/theme/Black/img/icons/ghar.png" alt="Home Screen" title="Home Screen" style=" margin-left: 9px;width: 40px;"></a>
     <a href="javascript:history.back()"><style=" margin-left: 9px;width: 40px;"> Back </a>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            color: #333;
        }
        .forms-container {
            display: flex;
            gap: 20px;
        }
        .form-container {
            flex: 1;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-container input, .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            padding: 10px 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

<h1>Hospital manegment System</h1>

<div class="forms-container">
    <!-- Staff Form -->
    <div class="form-container">
        <h2>Staff Form</h2>
        <form action="staff_company" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="staff_id" >
            <label for="create_by">Created By</label>
            <input type="text" name="create_by" id="create_by"  required>
            <label for="staff_name">Staff Name</label>
            <input type="text" name="staff_name" id="staff_name"  required>
            <button type="submit">Save Staff</button>
        </form>
    </div>

    <div class="form-container">
        <h2>Company Form</h2>
        <form action="saveCompany" method="POST" enctype="multipart/form-data">
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" id="company_name"  required>
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="Address (Optional)" >
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email (Optional)" >
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" placeholder="Phone (Optional)">
            <button type="submit">Save Company</button>
        </form>
    </div>
</div>

</body>
</html>
