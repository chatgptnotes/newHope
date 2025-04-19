<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Referal Hub </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!--<link href="../assets/img/favicon.png" rel="icon">-->
  <!--<link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">-->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="./../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
</head>

<body>
  <main id="main" class="main" style="margin-left: 0px !important;margin-top: 0px !important;">

    <div class="pagetitle">
      <h1>Referal Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Referal</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">
          <?php if (!empty($referralData)): ?>
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                <h2><?= h($referralData['Consultant']['first_name']); ?> <?= h($referralData['Consultant']['last_name']); ?></h2>
                <h3> <?= h($referralData['Consultant']['mobile']); ?> <?= h($referralData['Consultant']['education']); ?></h3>
                <h3>Referal Doctor </h3>
                <div class="social-links mt-2">
                  <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                  <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                  <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                  <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>

          <?php else: ?>
            <p>No referral data found.</p>
          <?php endif; ?>
        </div>
        <div class="col-xl-8">
          <?php if (!empty($referralData)): ?>
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
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Refer Patient List</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Disposition and Sub-Disposition</button>
                  </li>
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#referal-persons">Lead Collection</button>
                  </li>

                </ul>
                <div class="tab-content pt-2">

                  <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <h5 class="card-title">About</h5>
                    <p class="small fst-italic"><?= h($referralData['Consultant']['about_us']); ?></p>

                    <h5 class="card-title">Profile Details</h5>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Full Name</div>
                      <div class="col-lg-9 col-md-8"><?= h($referralData['Consultant']['first_name']); ?> <?= h($referralData['Consultant']['last_name']); ?></div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Date Of Birth </div>
                      <div class="col-lg-9 col-md-8"><?= h($referralData['Consultant']['dob']); ?></div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Company Name</div>
                      <div class="col-lg-9 col-md-8"><?= h($referralData['Consultant']['company_name']); ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Marketing Employee </div>
                      <div class="col-lg-9 col-md-8"><?= h($referralData['Consultant']['market_team']); ?></div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Marketing Employee Number </div>
                      <div class="col-lg-9 col-md-8"><?= h($referralData['Consultant']['mobile']); ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Designation</div>
                      <div class="col-lg-9 col-md-8"><?= h($referralData['Consultant']['education']); ?> Doctor</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Country</div>
                      <div class="col-lg-9 col-md-8">INDIA</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Address</div>
                      <div class="col-lg-9 col-md-8"><?= h($referralData['Consultant']['address1']); ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Phone</div>
                      <div class="col-lg-9 col-md-8"><?= h($referralData['Consultant']['mobile']); ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8"><?= h($referralData['Consultant']['email']); ?></div>
                    </div>

                  </div>

                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                    <!-- Profile Edit Form -->
                    <form method="post" action="">
                      <!--<?php echo $this->Form->create('Consultant', ['url' => ['action' => 'referral_hub', '?' => ['referal_id' => $referralData['Consultant']['id']]]]); ?>-->

                      <input type="hidden" name="Consultant[id]" value="<?= h($referralData['Consultant']['id']); ?>">

                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="Consultant[first_name]" type="text" class="form-control" id="fullName"
                            value="<?= h($referralData['Consultant']['first_name']); ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="Consultant[last_name]" type="text" class="form-control" id="lastname"
                            value="<?= h($referralData['Consultant']['last_name']); ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                        <div class="col-md-8 col-lg-9">
                          <textarea name="Consultant[about_us]" class="form-control" id="about" style="height: 100px"><?= h($referralData['Consultant']['about_us']); ?></textarea>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="Consultant[company]" type="text" class="form-control" id="company"
                            value="<?= h($referralData['Consultant']['company_name']); ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Designation</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="Consultant[referral_type]" type="text" class="form-control" id="Job"
                            value="<?= h($referralData['Consultant']['referral_type']); ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="Consultant[country_id]" type="text" class="form-control" id="Country"
                            value="<?= h($referralData['Consultant']['country_id']); ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="Consultant[address1]" type="text" class="form-control" id="Address"
                            value="<?= h($referralData['Consultant']['address1']); ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="Consultant[mobile]" type="text" class="form-control" id="Phone"
                            value="<?= h($referralData['Consultant']['mobile']); ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="Consultant[email]" type="email" class="form-control" id="Email"
                            value="<?= h($referralData['Consultant']['email']); ?>">
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form>

                    <!-- End Profile Edit Form -->

                  </div>

                  <div class="tab-pane fade pt-3" id="profile-settings">
                    <h3>Referred Patients</h3>

                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Patient Name</th>
                          <th>Patient UID</th>
                          <th>Admission Date</th>
                          <th>Admission Type</th>
                          <th>City</th>
                          <th>Mobile</th>
                          <th>Paid Amount</th>
                          <!--<th>Details</th>-->
                          <!--<th>Remark</th>-->
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($referal_patient)): ?>
                          <?php foreach ($referal_patient as $key => $patient): ?>
                            <tr>
                              <td><?= $key + 1; ?></td>
                              <td><?= h($patient['Person']['first_name']); ?> <?= h($patient['Person']['last_name']); ?></td>
                              <td><?= h($patient['Person']['patient_uid']); ?></td>
                              <td><?= h($patient['Person']['create_time']); ?></td>
                              <td><?= h($patient['Person']['admission_type']); ?></td>
                              <td><?= h($patient['Person']['city']); ?></td>
                              <td><?= h($patient['Person']['mobile']); ?></td>
                              <!--<td><?= h($patient['Person']['no_number']); ?> Rs.</td>-->
                              <!--<td><?= h($patient['Person']['status']); ?></td>-->
                              <td> </td>
                              <!--<td>-->
                              <!--<a href="<?= $this->Html->url(['controller' => 'Persons', 'action' => 'view', $patient['Person']['id']]); ?>/" class="btn btn-info btn-sm">Patient Hub</a>-->
                              <!--<a href="<?= $this->Html->url(['controller' => 'Persons', 'action' => 'edit', $patient['Person']['id']]); ?>" class="btn btn-warning btn-sm">Edit</a>-->
                              <!--<a href="<?= $this->Html->url(['controller' => 'Persons', 'action' => 'delete', $patient['Person']['id']]); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>-->
                              <!--</td>-->
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="8" class="text-center">No referral patients found.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>


                  <div class="tab-pane fade pt-3" id="profile-change-password">
                    <h3>Disposition and Sub-Disposition</h3>

                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Telecaller Name</th>
                          <th>Disposition</th>
                          <th>Sub-Disposition</th>
                          <th>Remarks</th>
                          <!--<th>Actions</th>-->
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($desposition_data)): ?>
                          <?php foreach ($desposition_data as $key => $data): ?>
                            <tr>
                              <td><?= $key + 1; ?></td>
                              <td><?= h($data['ReferralConsultant']['telecaller_name']); ?></td>
                              <td><?= h($data['ReferralConsultant']['disposition']); ?></td>
                              <td><?= h($data['ReferralConsultant']['sub_disposition']); ?></td>
                              <td><?= h($data['ReferralConsultant']['remarks']); ?></td>
                              <!--<td>-->
                              <!--    <a href="<?= $this->Html->url(['controller' => 'ReferralConsultants', 'action' => 'view', $data['ReferralConsultant']['id']]); ?>" class="btn btn-info btn-sm">View</a>-->
                              <!--    <a href="<?= $this->Html->url(['controller' => 'ReferralConsultants', 'action' => 'edit', $data['ReferralConsultant']['id']]); ?>" class="btn btn-warning btn-sm">Edit</a>-->
                              <!--    <a href="<?= $this->Html->url(['controller' => 'ReferralConsultants', 'action' => 'delete', $data['ReferralConsultant']['id']]); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>-->
                              <!--</td>-->
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="6" class="text-center">No data found.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>

                  </div>

                  <div class="tab-pane fade pt-3" id="referal-persons">
                    <h3>Lead Collection</h3>

                    <!-- Display Flash Messages -->
                    <?php echo $this->Session->flash(); ?>

                    <!-- View Format Button -->
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#formatModal">
                      View File Format
                    </button>

                    <!-- File Upload Form -->
                    <div class="d-flex align-items-center mt-3">
                      <?php
                    echo $this->Form->create('Consultant', array(
    'type' => 'file',
    'action' => 'uploadLeads'
));
echo $this->Form->file('excel_file', ['label' => 'Upload Excel File']);
echo $this->Form->button('Upload Leads', array('type' => 'submit', 'class' => 'btn btn-primary'));
echo $this->Form->end();
?>
                    </div>

                    <!-- Modal for File Format -->
                    <div class="modal fade" id="formatModal" tabindex="-1" aria-labelledby="formatModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="formatModalLabel">File Format</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>Please ensure your file follows the below format:</p>
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>name</th>
                                  <th>mobile</th>
                                  <th>created_time</th>
                                  <th>agent_id</th>
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
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>


                    <!-- In your 'referral_template.ctp' file -->
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="select_all"></th>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Mobile</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($referralData_customer)): ?>
                          <?php foreach ($referralData_customer as $referral): ?>
                            <tr>
                              <td>
                                <input type="checkbox" class="phone-checkbox" value="<?php echo $referral['Referal']['mobile']; ?>" data-name="<?php echo $referral['Referal']['name']; ?>">
                              </td>
                              <td><?php echo $referral['Referal']['id']; ?></td>
                              <td><?php echo $referral['Referal']['name']; ?></td>
                              <td><?php echo $referral['Referal']['mobile']; ?></td>
                              <td><?php echo $referral['Referal']['status']; ?></td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="5">No data available.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>

                    <!-- Buttons to send messages -->
                    <button id="send-festival-btn" class="btn btn-primary">Send Festival Message</button>
                    <button id="send-festival-video" class="btn btn-secondary">Send Festival Video</button>
                    <div id="response" style="margin-top: 10px; color: green;"></div>

                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        // Select all functionality
                        document.getElementById('select_all').addEventListener('click', function() {
                          const checkboxes = document.querySelectorAll('.phone-checkbox');
                          checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                        });

                        // Generic function to send messages
                        const sendMessages = async (selectedRows, templateName) => {
                          if (selectedRows.length === 0) {
                            alert('Please select at least one row.');
                            return;
                          }

                          const apiUrl = "https://public.doubletick.io/whatsapp/message/template";
                          const apiKey = "key_8sc9MP6JpQ";
                          const payloads = [];

                          selectedRows.forEach(checkbox => {
                            const phone = checkbox.value;
                            const name = checkbox.getAttribute('data-name');

                            payloads.push({
                              to: "+91" + phone,
                              content: {
                                templateName: templateName,
                                language: "en",
                                templateData: {
                                  body: {
                                    placeholders: [name]
                                  }
                                }
                              }
                            });
                          });

                          try {
                            const response = await fetch(apiUrl, {
                              method: "POST",
                              headers: {
                                "accept": "application/json",
                                "content-type": "application/json",
                                "Authorization": apiKey
                              },
                              body: JSON.stringify({
                                messages: payloads
                              })
                            });

                            const result = await response.json();

                            if (response.ok) {
                              alert(`Messages sent successfully to ${selectedRows.length} customers.`);
                            } else {
                              alert(`Error sending messages: ${result.message || "Something went wrong."}`);
                            }
                          } catch (error) {
                            console.error('Error:', error);
                            alert('Error sending messages. Check the console for details.');
                          }
                        };

                        // Festival message button
                        document.getElementById('send-festival-btn').addEventListener('click', () => {
                          const selectedRows = Array.from(document.querySelectorAll('.phone-checkbox:checked'));
                          sendMessages(selectedRows, "holi_i");
                        });

                        // Festival video button
                        document.getElementById('send-festival-video').addEventListener('click', () => {
                          const selectedRows = Array.from(document.querySelectorAll('.phone-checkbox:checked'));
                          sendMessages(selectedRows, "holi_v");
                        });
                      });
                    </script>

                  </div>

                </div><!-- End Bordered Tabs -->

              </div>
            </div>

        </div>
      </div>
    </section>
  <?php else: ?>
    <p>No referral data found.</p>
  <?php endif; ?>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      <!--&copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved-->
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>