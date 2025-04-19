<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f5f5f5;
    }

    .form-container {
        width: 90%;
        max-width: 600px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .section {
        margin-bottom: 20px;
    }

    h2 {
        color: #007bff;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
        color: #333;
    }

    input[type="text"], select, .textBoxExpnd {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="checkbox"] {
        margin-right: 5px;
    }

    button {
        padding: 10px 20px;
        margin-right: 10px;
        background-color: #007bff;
        border: none;
        color: #fff;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    button[type="submit"] {
        background-color: #28a745;
    }

    button[type="submit"]:hover {
        background-color: #218838;
    }

    #verificationMessage {
        margin-top: 10px;
        color: green;
    }

    @media (max-width: 768px) {
        .form-container {
            width: 100%;
            padding: 10px;
        }

        button {
            width: 100%;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 1.5em;
            text-align: center;
        }

        input[type="text"], select, .textBoxExpnd {
            width: 100%;
        }

        label {
            font-size: 1em;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }
    }

    @media (max-width: 480px) {
        .form-container {
            width: 100%;
            padding: 5px;
        }

        button {
            width: 100%;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 1.2em;
            text-align: center;
        }

        input[type="text"], select, .textBoxExpnd {
            width: 100%;
            padding: 8px;
        }

        label {
            font-size: 0.9em;
        }

        input[type="checkbox"] {
            margin-right: 3px;
        }
    }

    @media (max-width: 320px) {
        .form-container {
            width: 100%;
            padding: 2px;
        }

        button {
            width: 100%;
            margin-bottom: 2px;
        }

        h2 {
            font-size: 1em;
            text-align: center;
        }

        input[type="text"], select, .textBoxExpnd {
            width: 100%;
            padding: 5px;
        }

        label {
            font-size: 0.8em;
        }

        input[type="checkbox"] {
            margin-right: 2px;
        }
    }
    </style>

<body>
    <div class="form-container">
        <form id="multiSectionForm" method="post" action="<?php echo $this->Html->url(array('controller' => 'Persons', 'action' => 'quickReg')); ?>">
            <div id="section1" class="section">
                <h2>Section 1</h2>

                <div><?php echo __('Name ');?></div>
                <div><?php echo $this->Form->input('Person.first_name', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'first_name',
                    'oninput' => "validateText(this)"
                ));?></div>

                <div><?php echo __('Middle Name');?></div>
                <div><?php echo $this->Form->input('Person.middle_name', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'middle_name',
                    'oninput' => "validateText(this)"
                ));?></div>

                <div><?php echo __('Last Name');?></div>
                <div><?php echo $this->Form->input('Person.last_name', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'last_name',
                    'oninput' => "validateText(this)"
                ));?></div>

                <script>
                    function validateText(input) {
                        const value = input.value;
                        const regex = /^[a-zA-Z\s]*$/;
                        if (!regex.test(value)) {
                            input.setCustomValidity('Please enter only letters and spaces.');
                        } else {
                            input.setCustomValidity('');
                        }
                    }
                </script>

                <div><?php echo __('Date Of Birth');?></div>
                <div>
                    <?php echo $this->Form->input('Person.dob', array(
                        'class' => 'textBoxExpnd',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'dob',
                        'placeholder' => 'YYYY-MM-DD',
                        'onchange' => "calculateAge(this)"
                    )); ?>
                </div>

                <div><?php echo __('Age');?></div>
                <div>
                    <?php echo $this->Form->input('Person.age', array(
                        'class' => 'textBoxExpnd',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'age',
                        'readonly' => true
                    )); ?>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        $('#dob').datepicker({
                            dateFormat: 'yy-mm-dd',
                            changeMonth: true,
                            changeYear: true,
                            yearRange: "-100:+0",
                            onSelect: function(dateText) {
                                calculateAge(this);
                            }
                        });
                    });

                    function calculateAge(input) {
                        const dob = new Date(input.value);
                        const today = new Date();
                        let age = today.getFullYear() - dob.getFullYear();
                        const monthDiff = today.getMonth() - dob.getMonth();
                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                            age--;
                        }
                        document.getElementById('age').value = age;
                    }
                </script>

                <div><?php echo __('Mobile Number');?></div>
                <div>
                    <?php echo $this->Form->input('Person.mobile', array(
                        'class' => 'textBoxExpnd',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'mobile',
                        'placeholder' => '+91',
                        'maxlength' => '13',
                        'oninput' => "validateMobileNumber(this)"
                    )); ?>
                </div>

                <script>
                    function validateMobileNumber(input) {
                        let value = input.value;
                        if (value.length === 0) {
                            input.value = '+91'; // Automatically add +91
                        }
                        const regex = /^\+91\d{0,10}$/;
                        if (!regex.test(value)) {
                            input.setCustomValidity('Please enter a valid mobile number starting with +91 and followed by 10 digits.');
                        } else {
                            input.setCustomValidity('');
                        }
                    }
                </script>

                <div><?php echo __('Gender');?></div>
                <div>
                    <?php echo $this->Form->input('Person.gender', array(
                        'type' => 'select',
                        'options' => array(
                            'male' => __('Male'),
                            'female' => __('Female'),
                            'other' => __('Other')
                        ),
                        'class' => 'textBoxExpnd',
                        'label' => false,
                        'id' => 'gender'
                    )); ?>
                </div>

                <button type="button" onclick="nextSection(2)">Next</button>
            </div>

            <div id="section2" class="section" style="display:none;">
                <h2>Section 2</h2>

                <div><?php echo __('Next Of Kin Name');?></div>
                <div><?php echo $this->Form->input('Person.next_of_kin', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'next_of_kin'
                )); ?></div>

                <div><?php echo __('Next Of Kin Mobile');?></div>
                <div>
                    <?php echo $this->Form->input('Person.next_of_kin_mobile', array(
                        'class' => 'textBoxExpnd',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'next_of_kin_mobile',
                        'maxlength' => '13',
                        'oninput' => "validateMobileNumber(this)"
                    )); ?>
                </div>

                <div><?php echo __('Area Pin Code');?></div>
                <div><?php echo $this->Form->input('Person.pin_code', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'pinCode',
                    'oninput' => "fetchLocationDetails(this)"
                ));?></div>

                <div><?php echo __('City/Town');?></div>
                <div><?php echo $this->Form->input('Person.city', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'city'
                ));?></div>

                <div><?php echo __('State');?></div>
                <div><?php echo $this->Form->input('Person.state', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'stateName'
                ));?></div>

                <script>
                    $("#pinCode").blur(function() {
                        var zipData = $(this).val();
                        var zipCount = $(this).val().length;
                        if (zipCount == 6) {
                            $.ajax({
                                url: "<?php echo $this->Html->url(array('controller' => 'Persons', 'action' => 'getStateCity')); ?>" + "/" + zipData,
                                context: document.body,
                                success: function(data) {
                                    if (data) {
                                        const parsedData = JSON.parse(data);
                                        if (parsedData.zip['State']['id']) {
                                            $('#stateId').val(parsedData.zip['State']['id']);
                                            $('#stateName').val(parsedData.zip['State']['name']);
                                            $('#city').val(parsedData.zip['PinCode']['city_name']);
                                        }
                                    }
                                }
                            });
                        } else {
                            $('#stateId').val("");
                            $('#stateName').val("");
                            $('#city').val("");
                        }
                    });
                </script>

                <button type="button" onclick="nextSection(3)">Next</button>
                <button type="button" onclick="previousSection(1)">Previous</button>
            </div>

            <div id="section3" class="section" style="display:none;">
                <h2>Section 3</h2>

                <div><?php echo __('Allergy');?></div>
                <div><?php echo $this->Form->input('Person.allergy', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'allergy'
                )); ?></div>

                <div><?php echo __('Chronic Condition');?></div>
                <div><?php echo $this->Form->input('Person.chronic_condition', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'chronic_condition'
                )); ?></div>

                <div><?php echo __('Blood Group');?></div>
                <div>
                    <?php echo $this->Form->input('Person.blood_group', array(
                        'type' => 'select',
                        'options' => array(
                            'A+' => 'A+',
                            'A-' => 'A-',
                            'B+' => 'B+',
                            'B-' => 'B-',
                            'AB+' => 'AB+',
                            'AB-' => 'AB-',
                            'O+' => 'O+',
                            'O-' => 'O-'
                        ),
                        'class' => 'textBoxExpnd',
                        'label' => false,
                        'id' => 'blood_group'
                    )); ?>
                </div>

                <div><?php echo __('Known Medical Conditions:');?></div>
                <div><?php echo $this->Form->input('Person.known_medical_conditions', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'known_medical_conditions'
                )); ?></div>

                <div><?php echo __('Preferred Hospital');?></div>
                <div><?php echo $this->Form->input('Person.preferred_hospital', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'preferred_hospital'
                )); ?></div>

                <button type="button" onclick="nextSection(4)">Next</button>
                <button type="button" onclick="previousSection(2)">Previous</button>
            </div>

            <div id="section4" class="section" style="display:none;">
                <h2>Section 4</h2>

                <div><?php echo __('Language Preference:');?></div>
                <div>
                    <label><input type="checkbox" name="Person[language_preference][]" value="marathi"> Marathi</label>
                    <label><input type="checkbox" name="Person[language_preference][]" value="hindi"> Hindi</label>
                    <label><input type="checkbox" name="Person[language_preference][]" value="english"> English</label>
                    <label><input type="checkbox" name="Person[language_preference][]" value="gujarati"> Gujarati</label>
                    <label><input type="checkbox" name="Person[language_preference][]" value="tamil"> Tamil</label>
                    <label><input type="checkbox" name="Person[language_preference][]" value="telugu"> Telugu</label>
                    <label><input type="checkbox" name="Person[language_preference][]" value="bengali"> Bengali</label>
                </div>

                <div><?php echo __('Type Of Enrollment:');?></div>
                <div>
                    <?php echo $this->Form->input('Person.enrollment_type', array(
                        'type' => 'select',
                        'options' => array(
                            'public' => __('Public'),
                            'private' => __('Private'),
                            'regular' => __('Regular')
                        ),
                        'class' => 'textBoxExpnd',
                        'label' => false,
                        'id' => 'enrollment_type'
                    )); ?>
                </div>

                <div><?php echo __('Registration Date');?></div>
                <div>
                    <?php echo $this->Form->input('Person.registration_date', array(
                        'class' => 'textBoxExpnd',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'registration_date',
                        'placeholder' => 'YYYY-MM-DD HH:MM',
                        'readonly' => true
                    ));?>
                    <input type="checkbox" id="autoFillDateTime" onclick="fillCurrentDateTime()">
                    <?php echo __('Fill Current Date and Time'); ?>
                </div>

                <div><?php echo __('Digital Signature for Consent and Terms Agreement:');?></div>
                <div><?php echo $this->Form->input('Person.digital_signature', array(
                    'class' => 'textBoxExpnd',
                    'type' => 'text',
                    'label' => false,
                    'id' => 'digital_signature'
                ));?></div>

                <div>
                    <?php echo $this->Form->checkbox('Person.terms_agreement', array('id' => 'terms_agreement', 'onclick' => 'showVerificationMessage()')); ?>
                    <?php echo __('I agree to the terms and conditions'); ?>
                </div>
                <div id="verificationMessage" style="display:none; color: green;">
                    <?php echo __('Terms and conditions verified.'); ?>
                </div>

                <script>
                    function showVerificationMessage() {
                        const checkbox = document.getElementById('terms_agreement');
                        const message = document.getElementById('verificationMessage');
                        if (checkbox.checked) {
                            message.style.display = 'block';
                        } else {
                            message.style.display = 'none';
                        }
                    }

                    function fillCurrentDateTime() {
                        if (document.getElementById('autoFillDateTime').checked) {
                            const now = new Date();
                            const formattedDateTime = now.toISOString().slice(0, 19).replace('T', ' ');
                            document.getElementById('registration_date').value = formattedDateTime;
                        } else {
                            document.getElementById('registration_date').value = '';
                        }
                    }
                </script>

                <button type="submit">Submit</button>
                <button type="button" onclick="previousSection(3)">Previous</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadProgress();
        });
        
        function loadProgress() {
            const data = {}; // Load saved progress if needed
            Object.keys(data).forEach(key => {
                const field = document.getElementById(key);
                if (field) field.value = data[key];
            });
        }
        
        function nextSection(sectionNumber) {
            const currentSection = document.querySelector('.section:not([style*="display: none"])');
            if (currentSection) {
                currentSection.style.display = 'none';
            }
            const nextSection = document.getElementById(`section${sectionNumber}`);
            if (nextSection) {
                nextSection.style.display = 'block';
            }
        }
        
        function previousSection(sectionNumber) {
            const currentSection = document.querySelector('.section:not([style*="display: none"])');
            if (currentSection) {
                currentSection.style.display = 'none';
            }
            const previousSection = document.getElementById(`section${sectionNumber}`);
            if (previousSection) {
                previousSection.style.display = 'block';
            }
        }
    </script>
</body>
</html>
