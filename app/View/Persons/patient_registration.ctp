<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f9ff;
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #fff;
            font-weight: bold;
        }
        label {
            color: #004085;
            font-weight: bold;
        }
        .form-control {
            color: white;
            border-radius: 1.375rem;
            border: 1px solid #010a13;
            background-color: #282f5f;
        }
        .form-control:focus {
            border-color: #004085;
            box-shadow: 0 0 5px rgba(0, 64, 133, 0.5);
        }
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        table {
            width: 100%;
        }
        tr td {
            padding: 10px;
        }
        .additional-fields {
            display: none;
        }
        ::placeholder {
            color: white !important;
            opacity: 1;
        } 
        input::placeholder,
        textarea::placeholder,
        select::placeholder {
            color: white !important;
        }

        .btn-row {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .custom-btn {
            border-radius: 29px;
            font-size: 16px; /* Reduced font size */
            padding: 8px 20px; /* Reduced padding */
            width: auto; /* Reduced button width */
            box-sizing: border-box;
            background-color: #1f3042; /* Same blue color for both buttons */
            border: none;
            color: white;
        }

        .custom-btn:hover {
            background-color: #57278e; /* Slightly darker blue on hover */
        }

        /* Make buttons responsive */
        @media (max-width: 767px) {
            .btn-row {
                flex-direction: column;
                gap: 15px;
            }
            .custom-btn {
                width: auto;
            }
        }

        /* For mobile view adjustments */
        @media (max-width: 767px) {
            .col-12 {
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%;
                margin-top: 10px;
            }
            .form-group {
                width: 100%;
                margin-bottom: 15px;
            }
            .table td {
                display: block;
                width: 100%;
                padding: 10px 0;
            }
            .table td label {
                margin-bottom: 5px;
            }
            .custom-btn {
                border-radius: 29px;
                font-size: 16px; /* Reduced font size */
                padding: 8px 20px; /* Reduced padding */
                width: auto; /* Reduced button width */
                box-sizing: border-box;
                background-color: #1f3042; /* Same blue color for both buttons */
                border: none;
                color: white;
            }
        }
    </style>
</head>
<body>
    
    <div class="container my-5" style=" background-color: #5198bf;">
        <div id="header">
        <h2 class="text-center">Patient Registration Form</h2>
    </div>
        <!--<form>--><form action="/persons/patient_registration" id="PersonSearchForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="form-group row">
                <div class="col-12 col-md-6">
                    <label for="firstName">First Name*</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" >
                </div>
                <div class="col-12 col-md-6">
                    <label for="lastName">Last Name*</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 col-md-6">
                    <label for="middleName">Middle Name</label>
                    <input type="text" class="form-control" name="data[Person][middle_name]" id="middleName" placeholder="Middle Name">
                </div>
                <div class="col-12 col-md-6">
                    <label for="age">Age*</label>
                    <input type="number" class="form-control" name="data[Person][age]" id="age" placeholder="Age" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 col-md-6">
                    <label for="dob">Date of Birth (DOB)</label>
                    <input type="date" class="form-control"name="data[Person][dob]" id="dob">
                </div>
                <div class="col-12 col-md-6">
                    <label for="gender">Gender*</label>
                    <select class="form-control"name="data[Person][sex]" id="gender" >
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 col-md-6">
                    <label for="pinCode">Pin Code*</label>
                    <input type="text" class="form-control" name="data[Person][pin_code]" id="pinCode" placeholder="Pin Code" >
                </div>
                <div class="col-12 col-md-6">
                    <label for="state">State</label>
                    <input type="text" class="form-control" name="data[Person][state]" id="state" placeholder="State">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 col-md-6">
                    <label for="city">City/Town</label>
                    <input type="text" class="form-control" id="city" name="data[Person][city]" placeholder="City/Town">
                </div>
                <div class="col-12 col-md-6">
                    <label for="mobile">Mobile Number*</label>
                    <input type="text" class="form-control" id="mobile" name="data[Person][mobile]" placeholder="Mobile Number" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 col-md-6">
                    <label for="bloodGroup">Blood Group</label>
                    <select class="form-control"  name="data[Person][blood_group]" id="bloodGroup">
                        <option value="">Please Select</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
            </div>

           

            <div class="additional-fields">
                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label for="physician">Primary Care Physician*</label>
                        <select class="form-control" id="physician" >
                            <option value="">Select</option>
                            <option  name="data[Person][physician]" value="bkMurali">B K Murali, MS (Orth.)</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="medicalRequirements">Special Medical Requirements</label>
                        <textarea class="form-control"  name="data[Person][medicalRequirements]" id="medicalRequirements" rows="2" placeholder="Enter special requirements"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label for="emergencyContactName">Emergency Contact Name*</label>
                        <input type="text" class="form-control" name="data[Person][emergencyContactName]" id="emergencyContactName" placeholder="Emergency Contact Name" >
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="emergencyContactMobile">Emergency Contact Mobile*</label>
                        <input type="text" class="form-control" name="data[Person][emergencyContactMobile]"  id="emergencyContactMobile" placeholder="Emergency Contact Mobile" >
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label for="secondEmergencyContactName">Second Emergency Contact Name*</label>
                        <input type="text" class="form-control" name="data[Person][secondEmergencyContactName]" id="secondEmergencyContactName" placeholder="Second Emergency Contact Name" >
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="secondEmergencyContactMobile">Second Emergency Contact Mobile*</label>
                        <input type="text" class="form-control" name="data[Person][secondEmergencyContactMobile]" id="secondEmergencyContactMobile" placeholder="Second Emergency Contact Mobile" >
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label for="addressLine1">Address Line 1</label>
                        <input type="text" class="form-control" name="data[Person][addressLine1]" id="addressLine1" placeholder="Address Line 1">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="addressLine2">Address Line 2</label>
                        <input type="text" class="form-control" name="data[Person][addressLine2]" id="addressLine2" placeholder="Address Line 2">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label for="visitType">Visit Type*</label>
                        <select class="form-control" id="visitType" >
                            <option value="">Select</option>
                            <option name="data[Person][consultationCharges]" value="consultationCharges">Consultation Charges</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="serviceType">Preferred Service Type*</label>
                        <select class="form-control" id="serviceType" >
                            <option name="data[Person][private]" value="private">Private</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label for="chronicConditions">Chronic Conditions</label>
                        <input type="text" class="form-control" name="data[Person][chronicConditions]" id="chronicConditions" placeholder="Enter Chronic Conditions">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="allergy">Allergy</label>
                        <input type="text" class="form-control" name="data[Person][allergy]" id="allergy" placeholder="Allergy">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label for="email">E-mail Address</label>
                        <input type="email" class="form-control" name="data[Person][email]" id="email" placeholder="Email Address">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="currentMedication">Current Medication</label>
                        <input type="text" class="form-control" name="data[Person][currentMedication]" id="currentMedication" placeholder="Current Medication">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label for="registrationDate">Registration Date</label>
                        <input type="datetime-local" name="data[Person][registrationDate]" class="form-control" id="registrationDate">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="uploadIdProof">Upload ID Proof</label>
                        <select class="form-control" name="data[Person][uploadIdProof]" id="uploadIdProof">
                            <option value="">-- Select ID Proof --</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <div class="btn-row">
                    <button type="button" id="showMoreBtn" class="btn btn-outline-primary custom-btn" style="width:170px; ">View More Details</button>
                    <button type="submit" class="btn btn-primary custom-btn" style="width: 90px;">Submit</button>
                </div>
            </div>
            
            
        </form>
    </div>

    <script>
        document.getElementById('showMoreBtn').addEventListener('click', function () {
            document.querySelector('.additional-fields').style.display = 'block';
            this.style.display = 'none';
        });
    </script>
</body>
</html>
