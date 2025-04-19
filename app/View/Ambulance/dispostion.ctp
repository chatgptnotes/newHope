<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Disposition Hub</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-header {
      background-color: #007bff;
      color: white;
    }
    .card-body {
      padding: 20px;
    }
    .form-group {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Call Information Dashboard</h2>
    
    <div class="row">
      <!-- Left Column: Call Information -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            Call Information
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>Caller ID:</label>
              <input type="text" class="form-control" value="<?php echo h($desposition_hub[0]['Person']['caller_id']); ?>" placeholder="Auto-fetched" disabled>
            </div>
            <div class="form-group">
              <label>Patient Name:</label>
              <input type="text" class="form-control" value="<?= h($ambulanceData['Ambulance']['first_name']) ?> <?php echo h($ambulanceData[0]['Ambulance']['last_name']); ?>" placeholder="Pulled from hospital records" disabled>
            </div>
            <div class="form-group">
              <label>Call Duration:</label>
              <input type="text" class="form-control" value="Automatically Calculated" placeholder="Automatically calculated" disabled>
            </div>
            <div class="form-group">
              <label>Patient Mobile:</label>
              <input type="number" class="form-control" value="<?php echo h($desposition_hub[0]['Person']['mobile']); ?>" placeholder="Patient number" disabled>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Column: For Telecaller -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">For Telecaller</div>
          <div class="card-body">
            <!--<form method="POST" action="<?php echo $this->Html->url(['action' => 'dispostion']); ?>">-->
              <input type="hidden" name="patient_id" class="form-control" value="<?php echo h($desposition_hub[0]['Person']['id']); ?>">
              <div class="form-group">
                <label>Call Assigned To:</label>
                <select class="form-control" name="call_assigned_to">
                  <option value="Shivani_Tedulwar">Shivani Dinesh Tedulwar</option>
                  <option value="Ruchi_Deshbhratar">Ruchi Ravi Deshbhratar</option>
                  <option value="Dolly_Yenkie">Dolly Onkarnath Yenkie</option>
                  <option value="Arya_Chikanakr">Arya Mahendra Chikanakr</option>
                  <option value="Neeraj_Jijotiya">Neeraj Naresh Jijotiya</option>
                  <option value="Nikita_Bandelu">Nikita Anil Bandelu</option>
                  <option value="Adam_Scott">Adam Simon Scott</option>
                </select>
              </div>
              <div class="form-group">
                <label for="call_timestamp">Call Timestamp:</label>
                <input type="datetime-local" class="form-control" name="call_timestamp" placeholder="Date and time of the call">
              </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <!-- Left Column: Disposition Section -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">Dispositions Code with Subcodes</div>
          <div class="card-body">
            <div class="form-group">
              <label for="disposition">Disposition:</label>
              <select class="form-control" name="disposition" id="disposition" onchange="updateSubDisposition()">
                <option value="">Select Disposition</option>
                <option value="inquiry">Inquiry</option>
                <option value="appointment_booking">Appointment Booking</option>
                <option value="complaint">Complaint</option>
                <option value="medical_query">Medical Query</option>
                <option value="billing_payment">Billing/Payment</option>
                <option value="feedback">Feedback</option>
                <option value="emergency">Emergency</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <label for="sub_disposition">Sub-Dispositions:</label>
              <select class="form-control" name="sub_disposition" id="sub_disposition">
                <option value="">Select Sub-Disposition</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Outcome Section -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">Outcome</div>
          <div class="card-body">
            <div class="form-group">
              <label>Outcome:</label>
              <select class="form-control" name="outcome">
                <option>Resolved</option>
                <option>Escalated</option>
                <option>Follow-Up Required</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Follow-Up Section -->
    <div class="row">
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">Follow-Up</div>
          <div class="card-body">
            <div class="form-group">
              <label for="follow_up_date">Follow-Up Date:</label>
              <input type="date" class="form-control" name="follow_up_date" id="follow_up_date">
            </div>
            <div class="form-group">
              <label for="follow_up_action">Action:</label>
              <select class="form-control" name="follow_up_action" id="follow_up_action">
                <option>Escalation</option>
                <option>Reminder for next steps</option>
                <option>Schedule next appointment</option>
              </select>
            </div>
          </div>
        </div>
      </div>
       <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">Remark</div>
          <div class="card-body">
            <div class="form-group">
              <label for="remark">Remark</label>
              <input type="text" class="form-control" name="remark" id="remark">
            </div>
            
          </div>
        </div>
      </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- JavaScript to handle Sub-Dispositions -->
<script>
  const subDispositionData = {
    "inquiry": ["Service Information", "Doctor Availability", "General Health Advice"],
    "appointment_booking": ["Booked", "Cancelled", "Rescheduled", "Inquiry about Availability"],
    "complaint": ["Service Delay", "Doctor Unavailability", "Staff Behavior", "Facility Issues"],
    "medical_query": ["Treatment Plan", "Prescription Issue", "Test Results Inquiry", "Medication Information"],
    "billing_payment": ["Billing Queries", "Insurance Coverage Inquiry", "Payment Options Inquiry", "Refund Request"],
    "feedback": ["Positive Feedback", "Suggestions for Improvement", "Service Quality"],
    "emergency": ["Emergency Help Needed", "Immediate Transport Request"],
    "other": ["Ringing Not Response", "Wrong No", "Not connected", "Not in service"]
  };

  function updateSubDisposition() {
    const disposition = document.getElementById('disposition').value;
    const subDisposition = document.getElementById('sub_disposition');
    subDisposition.innerHTML = ""; // Clear previous options

    if (disposition && subDispositionData[disposition]) {
      subDispositionData[disposition].forEach(function(sub) {
        const option = document.createElement('option');
        option.value = sub;
        option.textContent = sub;
        subDisposition.appendChild(option);
      });
    } else {
      const option = document.createElement('option');
      option.value = "";
      option.textContent = "Select Sub-Disposition";
      subDisposition.appendChild(option);
    }
  }
</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
