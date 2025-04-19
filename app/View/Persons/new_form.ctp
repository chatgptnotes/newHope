<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Registration Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
  /* Hide the header if loaded externally */
  .header_internal {
    display: none !important;
  }

  body {
    background-color: #f4f6f9;
    margin: 0;
    padding: 0;
    font-size: 1rem;
  }
  .container {
    width: 100%;
    max-width: 100%;
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
  }
  h2 {
    color: #343a40;
    font-weight: bold;
    text-align: center;
    font-size: 1.5rem;
  }
  .card-header {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
  }
  .form-group label {
    font-weight: 600;
  }
  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }
  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }
  .form-control {
    border-radius: 0.25rem;
    font-size: 1rem;
  }
  
  /* Mobile View Adjustments */
  @media (max-width: 768px) {
    .container {
      padding: 20px;
    }
    .form-control {
      font-size: 1rem;
    }
  }
</style>

</head>
<body>

<div class="container mt-5">
  <h2 class="text-center mb-4">Patient Registration Form</h2>
  <!--<form>-->
      
      <?php echo $this->Form->create('',array('type' => 'file','action'=>'quickReg','id'=>'PersonSearchForm'));?>
<!-- set static value for self pay option of tariffStandard (Payer) -->
<?php  echo $this->Form->hidden('Patient.tariff_standard_id', array('id'=>'tariff_standard_id','value'=>$privateID));
//echo $this->Form->hidden('Patient.location_id', array('id'=>'location_id','value'=>$this->Session->read('locationid')));?>
    <!-- Patient Personal Information -->
    <div class="card mb-4">
      <div class="card-header">Personal Information</div>
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" placeholder="Enter first name" required>
            	<td><?php echo $this->Form->input('Person.first_name', array('label'=>false,'class' => ' textBoxExpnd','id' => 'firstName','size'=>'40','autocomplete'=>'off')); ?>
		</td>
          </div>
          <div class="form-group col-md-6">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" placeholder="Enter last name" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="dob">Date of Birth</label>
            <input type="date" class="form-control" id="dob" required onchange="calculateAge()">
          </div>
          <div class="form-group col-md-4">
            <label for="age">Age</label>
            <input type="text" class="form-control" id="age" placeholder="Calculated automatically" readonly>
          </div>
          <div class="form-group col-md-4">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" required>
              <option selected disabled>Select gender</option>
              <option>Male</option>
              <option>Female</option>
              <option>Other</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Information -->
    <div class="card mb-4">
      <div class="card-header">Contact Information</div>
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="phone">Phone Number</label>
            <input type="tel" class="form-control" id="phone" placeholder="Enter phone number" required>
          </div>
          <div class="form-group col-md-6">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email address">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="zip">ZIP Code</label>
            <input type="text" class="form-control" id="zip" placeholder="Enter ZIP code" onblur="fetchLocation()">
          </div>
          <div class="form-group col-md-6">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" readonly placeholder="Auto-fetched">
          </div>
        </div>
        <div class="form-group">
          <label for="state">State</label>
          <input type="text" class="form-control" id="state" readonly placeholder="Auto-fetched">
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" class="form-control" id="address" placeholder="Enter full address" required>
        </div>
      </div>
    </div>

    <!-- Additional Information -->
    <div class="card mb-4">
      <div class="card-header">Additional Information</div>
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="nextOfKin">Next of Kin Name</label>
            <input type="text" class="form-control" id="nextOfKin" placeholder="Enter next of kin's name">
          </div>
          <div class="form-group col-md-6">
            <label for="nextOfKinMobile">Next of Kin Mobile</label>
            <input type="tel" class="form-control" id="nextOfKinMobile" placeholder="Enter next of kin's mobile number">
          </div>
        </div>
        <div class="form-group">
          <label for="visitType">Visit Type</label>
          <select class="form-control" id="visitType" required>
            <option selected disabled>Select visit type</option>
            <option>Initial Consultation</option>
            <option>Follow-up</option>
            <option>Emergency</option>
          </select>
        </div>
        <div class="form-group">
          <label for="chronicConditions">Chronic Conditions</label>
          <input type="text" class="form-control" id="chronicConditions" placeholder="List chronic conditions">
        </div>
        <div class="form-group">
          <label for="currentMedication">Current Medication</label>
          <input type="text" class="form-control" id="currentMedication" placeholder="List current medications">
        </div>
        <div class="form-group">
          <label>Language Preference</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="languageHindi" value="Hindi">
            <label class="form-check-label" for="languageHindi">Hindi</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="languageEnglish" value="English">
            <label class="form-check-label" for="languageEnglish">English</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="languageMarathi" value="Marathi">
            <label class="form-check-label" for="languageMarathi">Marathi</label>
          </div>
        </div>
        <div class="form-group">
          <label for="preferredHospital">Preferred Hospital</label>
          <input type="text" class="form-control" id="preferredHospital" placeholder="Enter preferred hospital">
        </div>
        <div class="form-group">
          <label for="consent">Consent to Share Medical Information</label>
          <input type="checkbox" id="consent">
        </div>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-lg">Register Patient</button>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  // Calculate age based on DOB
  function calculateAge() {
    const dob = document.getElementById("dob").value;
    if (dob) {
      const birthDate = new Date(dob);
      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      document.getElementById("age").value = age;
    }
  }

  // Fetch city and state based on ZIP code (Zippopotam.us API)
  function fetchLocation() {
    const zip = document.getElementById("zip").value;
    if (zip) {
      fetch(`https://api.zippopotam.us/in/${zip}`)
        .then(response => {
          if (!response.ok) throw new Error("Invalid ZIP code");
          return response.json();
        })
        .then(data => {
          const place = data.places[0];
          document.getElementById("city").value = place["place name"];
          document.getElementById("state").value = place["state"];
        })
        .catch(error => {
          console.error(error);
          document.getElementById("city").value = "";
          document.getElementById("state").value = "";
          alert("Could not fetch city and state. Please enter a valid ZIP code.");
        });
    }
  }
</script>

</body>
</html>
