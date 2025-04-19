<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambulance Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            margin: 0 auto;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-group div {
            width: 48%;
        }

        .form-group label {
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input[type="file"] {
            padding: 0;
        }

        .form-group .required {
            color: red;
            margin-left: 5px;
        }

        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Ensure responsiveness on smaller screens */
        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
            }

            .form-group div {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Ambulance Registration Form</h2>
        
        <form action="ambu_form" method="POST" enctype="multipart/form-data">
            <!-- First Name and Last Name in one row -->
            <div class="form-group">
                <div>
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name">
                </div>
                <div>
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name">
                </div>
            </div>

            <!-- Ambulance Type and Model in one row -->
            <div class="form-group">
                <div>
                    <label for="ambulance_type">Select Ambulance Type</label>
                    <select id="ambulance_type" name="ambulance_type">
                        <option value="">--Select--</option>
                        <option value="BLS">Basic Life Support (BLS) Ambulance</option>
                        <option value="ALS">Advanced Life Support (ALS) Ambulance</option>
                    </select>
                </div>
                <div>
                    <label for="ambulance_model">Ambulance Model</label>
                    <input type="text" id="ambulance_model" name="ambulance_model">
                </div>
            </div>

            <!-- Number Plate and Ambulance Color in one row -->
            <div class="form-group">
                <div>
                    <label for="number_plate">Number Plate</label>
                    <input type="text" id="number_plate" name="number_plate">
                </div>
                <div>
                    <label for="ambulance_color">Ambulance Color</label>
                    <input type="text" id="ambulance_color" name="ambulance_color">
                </div>
            </div>

            <!-- Mobile Number and Email in one row -->
            <div class="form-group">
                <div>
                    <label for="mobile_number">Mobile Number</label>
                    <input type="tel" id="mobile_number" name="mobile_number">
                </div>
                <div>
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email">
                </div>
            </div>
            <div class="form-group">
            <div>
                <label for="admin_name">Administrator Name</label>
                <input type="text" id="admin_name" name="admin_name">
            </div>
            <div>
                <label for="admin_phone">Administrator Phone</label>
                <input type="tel" id="admin_phone" name="admin_phone">
            </div>
        </div>


        <div class="form-group">
            <div>
                <label for="admin_email">Administrator Email</label>
                <input type="email" id="admin_email" name="admin_email">
            </div>
            <div>
                <label for="vehicle_details">Vehicle Details</label>
                <textarea id="vehicle_details" name="vehicle_details" rows="3" placeholder="Enter vehicle details (e.g., MH12XX1001, ICU Ambulance, etc.)"></textarea>
            </div>
        </div>

            <!-- File Uploads in rows -->
            <div class="form-group">
                <div style="width: 48%;">
                    <label for="photo">Upload a photo of yourself</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                    <small>Upload 1 supported file: image. Max 1 MB.</small>
                </div>

                <div style="width: 48%;">
                    <label for="ambulance_photo">Upload a photo of your ambulance</label>
                    <input type="file" id="ambulance_photo" name="ambulance_photo" accept="image/*">
                    <small>Upload 1 supported file: image. Max 1 MB.</small>
                </div>
            </div>

            <div class="form-group">
                <div style="width: 48%;">
                    <label for="aadhaar_front">Upload your Aadhaar Card (Front)</label>
                    <input type="file" id="aadhaar_front" name="aadhaar_front" accept="image/*">
                    <small>Upload 1 supported file. Max 10 MB.</small>
                </div>

                <div style="width: 48%;">
                    <label for="aadhaar_back">Upload your Aadhaar Card (Back)</label>
                    <input type="file" id="aadhaar_back" name="aadhaar_back" accept="image/*">
                    <small>Upload 1 supported file. Max 10 MB.</small>
                </div>
            </div>

            <div class="form-group">
                <div style="width: 48%;">
                    <label for="license">Upload your Driver’s License</label>
                    <input type="file" id="license" name="license" accept="image/*">
                    <small>Upload 1 supported file. Max 1 MB.</small>
                </div>

                <div style="width: 48%;">
                    <label for="vehicle_rc">Upload your Vehicle's Registration Certificate (RC)</label>
                    <input type="file" id="vehicle_rc" name="vehicle_rc" accept="image/*">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>

</body>
</html>
