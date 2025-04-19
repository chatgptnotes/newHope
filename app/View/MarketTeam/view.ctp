<?php
//  debug($data);exit;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Referral Hub</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        /* Modal container */
        .modal {
            display: none;
            /* Initially hidden */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            /* Black with opacity */
        }

        /* Modal content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* Centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Width of the modal */
            max-width: 500px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Success, error, info styles for the modal text */
        .success {
            color: #155724;
            background-color: #d4edda;
        }

        .error {
            color: #721c24;
            background-color: #f8d7da;
        }

        .info {
            color: #0c5460;
            background-color: #d1ecf1;
        }

        #sendWhatsAppMessage {
            margin-top: 20px;
        }
    </style>

</head>

<body>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $this->Html->url(['action' => 'index']); ?>">Home</a></li>
                    <li class="breadcrumb-item">Marketing Team</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                            <h2><?php echo $team['MarketingTeam']['name']; ?></h2>
                            <h3><?php echo $team['MarketingTeam']['name']; ?></h3>
                            <div class="social-links mt-2">
                                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Our Leads</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Activity Tracker</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">About</h5>
                                    <p class="small fst-italic"><?php echo $team['MarketingTeam']['about']; ?>.</p>

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Full Name</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $team['MarketingTeam']['name']; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Marketing Area</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $team['MarketingTeam']['marketing_area']; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Job Profile</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $team['MarketingTeam']['designation']; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $team['MarketingTeam']['address']; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $team['MarketingTeam']['mobile']; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $team['MarketingTeam']['email']; ?></div>
                                    </div>
                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <form>
                                        <!-- Profile Edit Form -->
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="../assets/img/profile-img.jpg" alt="Profile">
                                                <div class="pt-2">
                                                    <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo $team['MarketingTeam']['name']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="about" class="form-control" id="about" style="height: 100px"><?php echo $team['MarketingTeam']['about']; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Marketing Area</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="company" type="text" class="form-control" id="company" value="<?php echo $team['MarketingTeam']['marketing_area']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="job" type="text" class="form-control" id="Job" value="<?php echo $team['MarketingTeam']['designation']; ?>">
                                            </div>
                                        </div>



                                        <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="address" type="text" class="form-control" id="Address" value="<?php echo $team['MarketingTeam']['address']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="phone" type="text" class="form-control" id="Phone" value="<?php echo $team['MarketingTeam']['mobile']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email" value="<?php echo $team['MarketingTeam']['email']; ?>">
                                            </div>
                                        </div>
                                        <!-- Additional fields for Profile Edit -->
                                        <!-- You can continue with similar fields for address, phone, email, etc. -->
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade pt-3" id="profile-settings">
                                    <!-- DataTable Section -->
                                    <div class="card shadow-lg">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Leads List</h4>

                                            <!-- Excel Upload Section -->
                                            <!-- Excel Upload Section -->
                                            <div class="mb-4">
                                                <?php
                                                echo $this->Form->create('Consultant', array(
                                                    'type' => 'file',
                                                    'action' => 'leads_upload'
                                                ));
                                                echo $this->Form->file('excel_file', ['label' => 'Upload Excel File', 'required' => true]);  // 'required' added
                                                echo $this->Form->button('Upload Leads', array('type' => 'submit', 'class' => 'btn btn-primary'));
                                                echo $this->Form->end();
                                                ?>
                                                <button type="button" class="btn btn-info" id="viewFileFormatBtn">
                                                    View File Format
                                                </button>

                                                <!-- Section to display the file format instructions -->
                                                <div id="fileFormatInstructions" style="display: none;">
                                                    <p>Please ensure your file follows the below format:</p>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>name</th>
                                                                <th>mobile</th>
                                                                <th>created_time</th>
                                                                <th>marketing_agent_id</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>test test</td>
                                                                <td>1234567890</td>
                                                                <td>1899-11-30 00:00:00</td>
                                                                <td>810</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <p><strong>Supported Formats:</strong> .csv, .xls</p>
                                                </div>
                                            </div>
                                            <table id="leadsTable" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Select</th>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Agent Name</th>
                                                        <th>Phone</th>
                                                        <th>Remark</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($leads)): ?>
                                                        <?php foreach ($leads as $index => $lead): ?>
                                                            <tr>
                                                                <!-- Add checkbox for each row -->
                                                                <td><input type="checkbox" class="rowCheckbox" data-mobile="<?php echo h($lead['Referal']['mobile']); ?>"></td>
                                                                <td><?php echo $index + 1; ?></td>
                                                                <td><?php echo h($lead['Referal']['name']); ?></td>
                                                                <td><?php echo h($lead['Consultant']['first_name']); ?></td>
                                                                <td><?php echo h($lead['Referal']['mobile']); ?></td>
                                                                <td><?php echo h($lead['Referal']['remark']); ?></td>
                                                                <td><?php echo h($lead['Referal']['status']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="7">No leads available.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <p>create a activities in this area</p>
                                </div>
                                <button id="sendWhatsAppMessage" class="btn btn-primary">Send WhatsApp Message</button>
                                <div id="responseModal" class="modal">
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <p id="response"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.3.3/dist/echarts.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@3.1.0/dist/umd/simple-datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5.10.0/tinymce.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#leadsTable').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search functionality
                "ordering": true, // Enable column sorting
                "pageLength": 10, // Number of rows per page
                "lengthMenu": [10, 15, 20] // Options for rows per page
            });
        });
    </script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Get the modal and the close button
            var modal = document.getElementById("responseModal");
            var span = document.getElementsByClassName("close")[0];

            // Button to send WhatsApp messages
            document.getElementById("sendWhatsAppMessage").addEventListener("click", async function() {
                let selectedPhones = [];

                // Loop through checkboxes to get selected phone numbers
                document.querySelectorAll(".rowCheckbox:checked").forEach(function(checkbox) {
                    let mobile = checkbox.getAttribute("data-mobile").trim();
                    if (mobile) {
                        selectedPhones.push(mobile);
                    }
                });

                if (selectedPhones.length === 0) {
                    displayModal('Please select at least one phone number.', 'info');
                    return;
                }

                const apiUrl = "https://public.doubletick.io/whatsapp/message/template";
                const apiKey = "key_8sc9MP6JpQ"; // Your API Key

                // Loop through each selected phone number and send the message
                for (const phone of selectedPhones) {
                    const payload = {
                        messages: [{
                            to: "+91" + phone, // Prepending country code
                            content: {
                                templateName: "pi_holi", // Your fixed template name
                                language: "en" // Language of the template
                            }
                        }]
                    };

                    try {
                        const response = await fetch(apiUrl, {
                            method: "POST",
                            headers: {
                                "accept": "application/json",
                                "content-type": "application/json",
                                "Authorization": apiKey // Authorization with the API key
                            },
                            body: JSON.stringify(payload)
                        });

                        const result = await response.json();

                        if (response.ok) {
                            displayModal(`Message sent successfully to ${phone}`, 'success');
                        } else {
                            displayModal(`Error sending to ${phone}: ${result.message || "Something went wrong."}`, 'error');
                        }
                    } catch (error) {
                        console.error(error);
                        displayModal("Error sending message. Check the console for more details.", 'error');
                    }
                }
            });

            // Function to display the modal with the message
            function displayModal(message, type) {
                const responseBox = document.getElementById('response');
                responseBox.textContent = message;

                // Clear previous classes and add the appropriate class
                responseBox.classList.remove('success', 'error', 'info');
                responseBox.classList.add(type);

                // Display the modal
                modal.style.display = "block";

                // Close the modal when the user clicks on the close button (X)
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // Close the modal if the user clicks outside the modal content
                window.onclick = function(event) {
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                }

                // Optional: Automatically close the modal after 5 seconds
                setTimeout(function() {
                    modal.style.display = "none";
                }, 5000);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#uploadBtn').click(function() {
                var formData = new FormData();
                var file = $('#excelUpload')[0].files[0];

                if (!file) {
                    alert("Please select a CSV file.");
                    return;
                }

                formData.append('file', file);

                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller' => 'MarketTeam', 'action' => 'upload_csv')); ?>", // Correct URL generation
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            alert('CSV data uploaded and saved successfully.');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error uploading CSV file.');
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        document.getElementById("viewFileFormatBtn").addEventListener("click", function() {
            // Toggle the visibility of the instructions section
            var instructions = document.getElementById("fileFormatInstructions");
            if (instructions.style.display === "none") {
                instructions.style.display = "block";
            } else {
                instructions.style.display = "none";
            }
        });
    </script>

</body>


</html>