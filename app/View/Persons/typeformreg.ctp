<head>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Load jQuery UI -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<?php 
//	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->script(array('jquery.fancybox','jquery.autocomplete'));
	echo $this->Html->css(array('jquery.autocomplete.css','jquery.fancybox.css'));  
	$referral = $this->request->referer(); 
	echo $this->Form->hidden('formReferral',array('value'=>'','id'=>'formReferral'));
    $docId=explode(',', $this->params->query['docId']);
?>

    <style>
/* Base Reset */
* {
    margin: 1px;
    padding: 7px;
    box-sizing: border-box;
   
}
::-webkit-scrollbar {
    display: none; /* Hides scrollbar in Webkit browsers */
}
body {
    font-family: 'Arial', sans-serif;
    background: #FFF;
    color: #000;
    display: flex; /* Center layout */
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    overflow-x: hidden; /* Prevent horizontal scroll */
    flex-direction: column; /* Allow vertical stacking */
}
h1 {
    font-size: 2rem; /* Adjust font size */
    color: #00bcd4; /* Custom heading color */
    text-align: center;
    margin: 0;
    padding: 20px;
    position: sticky;
    top: 0;
    z-index: 10;
    width: 100%;
    background: #fff; /* Optional: Add background color for better visibility */
}
form {
    width: 100%;
    max-width: 1000px; /* Limit the width */
    text-align: center; /* Center content inside the form */
    overflow: hidden;
    padding: 40px;
    display: flex;
    flex-direction: column;
    gap: 20px;
   
}
.upform {
    width: 90%;
    position: fixed;
    max-width: 1000px;
    padding: 40px 20px; /* Adjust padding */
    margin: 20px auto; 
    display: flex;
    flex-direction: column;
    align-items: center; /* Center elements inside vertically */
    justify-content: center; /* Center elements inside horizontally */
    /* background: #fff; Optional: Background color */
    /* box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); Optional: Add a shadow */
    /* border-radius: 8px; Optional: Rounded corners */
    text-align: center;
}

html {
    scroll-behavior: smooth;
}

/* General input block styling */
.input-block {
    /* General Block Styling */
    width: 100%;
    max-width: 750px; /* Wider input block */
    margin-bottom: 20px; /* Reduced bottom margin */
    font-family: Arial, sans-serif;
    font-size: 16px; /* Larger text */
    position: relative;
    opacity: 1;
    transform: translateY(20px);
    transition: opacity 0.6s ease-in-out, transform 0.6s ease-in-out;
}
.input-block.slide-in {
    animation: slideIn 0.6s ease-out forwards;
}
/* Active class styling for visible and animated blocks */
.input-block.active {
    opacity: 1; /* Show the block */
    transform: translateY(0); /* Bring it to its normal position */
}

/* Class for completed block (done state) */
.input-block.done {
    opacity: 1; /* Mark the block as done */
    transform: translateY(0); /* Keep the block in place */
}

/* Slide-in effect for new sections */
.input-block.slide-in {
    animation: slideIn 0.6s ease-in-out;
}

@keyframes slideIn {
    from {
        transform: translateY(20px);
        opacity: 1;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}



/* Navigation Buttons Container */
.nav-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 38px;
    position: absolute;
    left: 0;
    right: 0;
}

/* Back and Forward Buttons - Left aligned */
.nav-buttons-left {
    display: flex;
    gap: 10px; /* Adds spacing between the buttons */
    justify-content: flex-start;
    align-items: center;
}

/* Save & Next Button - Right aligned */
.nav-buttons-right {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

/* Back and Forward Buttons styling */
.btn-arrow {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 5px 10px;
    font-size: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-arrow:hover {
    background-color: #0056b3;
}

/* Save & Next Button styling */
.btn-save-next {
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 5px 10px;
    font-size:20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-save-next:hover {
    background-color: #218838;
}
.blueBtn{
    border-radius: 8px !important;
    min-width: 100px !important;
    font-size: 15px !important;
    color: #fff !important; 
    background-color: #007bff;
}



.picture-choice {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    .picture-choice input[type="checkbox"] {
      display: none;
    }
    .picture-choice label {
      cursor: pointer;
      border: 2px solid #0dcaf0 !important;
      border-radius: 5px;
      overflow: hidden;
      transition: border-color 300ms ease;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .picture-choice input[type="checkbox"]:checked + label {
      border-color: #8fb8c2;
      background-color: #0d8ec6;
    }
    .picture-choice label:hover {
      display: flex;
      box-shadow: 0px 0px 2px inset rgba(0, 0, 1, 50);
      border-color: #0dcaf0; 
    }
    .picture-choice img {
      display: block;
      width: 80px;
      height: 70px;
    }
    .picture-choice span {
      display: block;
      text-align: center;
      padding: 10px 0;
      color: #000;
    }
    input[type="radio"].toggle {
      display: none;
    }
    input[type="radio"].toggle + label {
      cursor: pointer;
      min-width: 80px;
    }
    input[type="radio"].toggle + label:hover {
      background: none;
      color: #000;
    }
    input[type="radio"].toggle + label:after {
      content: "";
      height: 100%;
      position: absolute;
      top: 0;
      transition: left 100ms cubic-bezier(0.77, 0, 0.175, 1);
      width: 100%;
      z-index: -1;
    }
    input[type="radio"].toggle.toggle-left + label:after {
      left: 100%;
    }
    input[type="radio"].toggle.toggle-right + label {
      margin-left: 10px;
    }
    input[type="radio"].toggle.toggle-right + label:after {
      left: -100%;
    }
    input[type="radio"].toggle:checked + label {
      background:#0d8ec6;
      cursor: default;
      color: #fff;
    }
    input[type="radio"].toggle:checked + label:after {
      left: 0;
    }

    

.formLabel {
    font-size: 1.8em;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
    padding-left: 1px !important;
    padding-right: 0px !important;
    padding-top: 5px !important;
    text-align: left;
}




.formInput {
    display: flex;
    flex-wrap: wrap;
    gap: 34px; /* Spacing between buttons */
}

/* Radio Button Wrapper */
.radio-button-wrapper {
    display: inline-block;
}

/* Hide Original Radio Button */
input.toggle {
    display: none;
}
.input-control input[type="text"] {
    width: 100%; /* Full width of the form */
    padding: 15px; /* Larger padding for better touch target */
    font-size: 18px;
}
/* Label Button Styling */
label.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 7px 20px;
    border-radius: 11px; /* Rounded Corners */
    border: 2px solid transparent;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color: #17a2b8; /* Default Blue Background */
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
}

label.btn span {
    font-weight: bold;
    margin-right: 8px;
    background: white;
    color: #17a2b8;
    padding: 5px 10px;
    border-radius:20%; /* Circle for the Letter */
}

/* Checked State for Buttons */
input.toggle:checked + label.btn {
    background-color: #0056b3; /* Darker Blue for Selected */
    color: white;
    border-color: #0056b3;
}

input.toggle:checked + label.btn span {
    background-color: white;
    color: #0056b3;
}




/* Input Row Styling */
.input-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: space-between;
}

/* Input Wrapper */
.input-wrapper {
    flex: 1;
    min-width: 80px;
}

/* Dropdown Styling */
.custom-dropdown {
    width: 100%;
    padding: 12px 54px;
    border-radius: 8px;
    border: 2px solid #ccc;
    font-size: 16px;
    color: #333;
    background-color: #fff;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 140"><polygon points="0,0 140,0 70,80" fill="%23333"/></svg>');
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 12px;
    cursor: pointer;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.custom-dropdown:hover,
.custom-dropdown:focus {
    border-color: #17a2b8;
    box-shadow: 0 4px 10px rgba(23, 162, 184, 0.2);
}

/* Textbox Styling */
.custom-textbox {
    width: 100%;
    padding: 12px 54px;
    border-radius: 8px; /* Rounded corners */
    border: 2px solid #ccc;
    font-size: 16px;
    color: #333;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s, box-shadow 0.3s;
}

.custom-textbox::placeholder {
    color: #aaa;
    font-style: italic;
}

.custom-textbox:focus,
.custom-textbox:hover {
    border-color: #17a2b8; /* Light blue border */
    box-shadow: 0 4px 10px rgba(23, 162, 184, 0.2); /* Subtle shadow on focus */
    outline: none;
}
/* Pin Code Wrapper */
.code-wrapper {
    position: relative;
    width: 100%;
}
.custom-input, button {
    border-radius: 4px; /* Reduce rounded corners */
}

/* Custom Pin Input Styling */
.custom-input {
    width: 100%;
    padding: 12px 54px;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    color: #333;
    background-color: #fff;
    /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
    transition: border-color 0.3s, box-shadow 0.3s;
}

.custom-input::placeholder {
    color: #aaa;
    font-style: italic;
}

.custom-input:focus,
.custom-input:hover {
    border-color: #17a2b8; /* Light blue border on hover/focus */
    box-shadow: 0 4px 10px rgba(23, 162, 184, 0.2); /* Subtle shadow effect */
    /* outline: none; */
}


.flatpickr-calendar {
    font-family: 'Arial', sans-serif;
    background-color: #ffffff;
    border: 1px solid #cccccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 6px;
    width: 260px; /* Slightly wider for better alignment */
    padding: 10px;
    z-index: 9999;
}

.flatpickr-months {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 5px;
}

.flatpickr-month {
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
    /* color: #333333; */
}

.flatpickr-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    font-size: 0.85rem;
    color: #666666;
    margin-bottom: 5px;
}

.flatpickr-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px; /* Add spacing between the days */
}

.flatpickr-day {
    font-size: 0.85rem;
    text-align: center;
    line-height: 0px !important;
    width: 20px; /* Adjusted for uniformity */
    height: 20px !important; /* Adjusted for uniformity */
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
    cursor: pointer;
    color: #333333;
}

.flatpickr-day:hover {
    background-color: #007bff;
    color: white;
}

.flatpickr-day.today {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.flatpickr-day.selected {
    background-color: #28a745;
    color: white;
    font-weight: bold;
}

.flatpickr-day.disabled {
    /* color: #cccccc; */
    cursor: not-allowed;
}

.flatpickr-arrow {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    color: #007bff;
    transition: color 0.2s;
   
}

.flatpickr-arrow:hover {
    color: #0056b3;
}

.flatpickr-calendar.open,
.flatpickr-calendar.inline {
    opacity: 1;
    max-height: 300px !important;
    width: auto;
    visibility: visible;
}

/* Prevent date overflow */
.flatpickr-days .flatpickr-day {
    /* overflow: hidden; */
    white-space: nowrap;
}

/* Fix overlapping months */
.flatpickr-months .flatpickr-month {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding: 0px 0 0 .5ch;
    height: 64px !important;
}

.textarea {
    width: 200px !important; 
    height: 100px !important;
    box-sizing: border-box; 
    resize: vertical; 
    padding: 23px; 
    font-size: 16px; 
}
.numInputWrapper  span.arrowUp {
  
    display: none;

}
.numInputWrapper  span.arrowDown {
    display: none;
}

@media (max-width: 768px) {
    body {
        padding: 10px;
    }

    .upform {
        width: 100%;
        padding: 20px 10px;
        margin-top: 10px;
    }

    h1 {
        font-size: 1.5rem; /* Make the heading smaller on mobile */
    }

    .input-block {
        font-size: 14px; /* Smaller text on mobile */
    }

    .input-control input[type="text"] {
        padding: 12px;
        font-size: 16px; /* Smaller input size */
    }

    .nav-buttons {
        flex-direction: column; /* Stack navigation buttons */
        gap: 10px;
    }

    .nav-buttons .btn-arrow,
    .btn-save-next {
        width: 100%; /* Buttons will take full width on mobile */
        font-size: 18px;
        padding: 10px 0; /* Larger buttons */
    }
}

.upform .upform-main .input-block {
      padding: 30px 0;
      opacity: 1;
      cursor: default;
    }
    .upform .upform-main .input-block .label {
      display: block;
      font-size: 1.8em;
      line-height: 30px;
    }
    .upform .upform-main .input-block .description {
      display: block;
      font-size: 1em;
      line-height: 30px;
      color: dimgray;
    }

    .upform .upform-main .input-block .input-control {
      margin: 20px 0;
    }
    .upform .upform-main .input-block .input-control input[type=text] {
      border: none;
      border-bottom: 2px solid #CCC;
      width: 100%;
      font-size: 35px;
      padding-bottom: 10px;
    }
    .upform .upform-main .input-block.active {
      opacity: 1;
    }
/* typeform css end poonam */
</style>

</head>


<?php 
	$flashMsg = $this->Session->flash('still') ;
	if(!empty($flashMsg)){ ?>
	<div>
		<?php echo $flashMsg ;?>
	</div> 
<?php } ?>
<?php 
		$attribute = '';
		
		if($online == false){
			$attribute = "empty=>Please Select";
		}
	 ?>
     
<div class="upform">
    <div class="inner_title">
        <h1 style="text-align: center; color: #0dcaf0;font-size: 42px;">
            <?php echo __('New Quick Registration', true); ?>
        </h1>
    </div>
    <div class="clr">&nbsp;</div>
    <div class="upform-main">
    <div class="formContainer" style="max-width: 600px; margin: 0 auto;">
        <?php echo $this->Form->create('', array('type' => 'file', 'action' => 'typeformreg', 'id' => 'PersonSearchForm')); ?>

        <?php echo $this->Form->hidden('Patient.tariff_standard_id', array('id' => 'tariff_standard_id', 'value' => $privateID)); ?>

        <?php echo $this->Form->input('Person.is_staff_register', array(
            'label' => false,
            'type' => 'checkbox',
            'class' => 'isStaff',
            'id' => 'isStaff',
            'style' => 'display:none;'
        )); ?>

       <div class="input-block formRow" id="language-selection-block"data-skip-validation="true">
            <div class="formLabel">Select Language:</div>
            <div class="formInput">
                <div id="google_translate_trigger" style="cursor: pointer;"></div>
                <div id="google_translate_element"></div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- Hidden Field for Agent ID -->
        <?php 
            echo $this->Form->input('Person.agent_id', array(
                'type' => 'hidden',
                'label' => false,
                'id' => 'agent_id'
            ));
        ?>
        <!-- Input Blocks -->
        <div class="input-block formRow required-field" id="generated-by-block">
            <div class="formLabel">Generated By:</div>
            <div class="formInput">
                <?php 
                    $options = array(
                        'telecaller' => 'Telecaller',
                        'admin' => 'Admin',
                        'frontdesk' => 'Frontdesk',
                        'self' => 'Self'
                    );

                    $index = 'A'; // Start from "A" for the label span
                    foreach ($options as $value => $label) {
                        echo '<div class="radio-button-wrapper">';
                        echo '<input id="generated_by_' . $value . '" class="toggle validate[required,custom[mandatory-select]]" name="Person.qr_created_by" value="' . $value . '" type="radio">';
                        echo '<label for="generated_by_' . $value . '" class="btn"><span>' . $index . '</span> ' . $label . '</label>';
                        echo '</div>';
                        $index++; // Increment the label span character
                    }
                ?>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>


        <div class="input-block formRow required-field" id="company-name-block">
            <div class="formLabel">Company/Organization Name:</div>
            <div class="formInput">
                <?php 
                    echo $this->Form->input('Person.company_name', array(
                        'class' => 'custom-dropdown validate[required]',
                        'type' => 'select',
                        'label' => false,
                        'id' => 'company_name',
                        'options' => array(
                            '' => '-- Select --',
                            'For me' => 'My Self',
                            'Hope Hospital Staff' => 'Hope Hospital Staff',
                            'Ayushman Hospital Staff' => 'Ayushman Hospital Staff',
                            'WCL Open Cast Mine Gondegaon' => 'WCL Open Cast Mine Gondegaon',
                            'WCL Eagle Infra India LTD' => 'WCL Eagle Infra India LTD',
                            'Solar Industry' => 'Solar Industry'
                        ),
                        'autocomplete' => "off"
                    ));
                ?>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>
        <!-- JavaScript -->
        <script>
                $(document).ready(function() {
                // Function to get the query parameter by name
                function getQueryParam(param) {
                    var urlParams = new URLSearchParams(window.location.search);
                    return urlParams.get(param);
                }

                // Extract the 'id' from the URL and set it in the input field
                var agentId = getQueryParam('id');
                if (agentId) {
                    // If 'id' exists in the URL, set it as the value of the input field
                    $('#agent_id').val(agentId);
                }
            });
        </script>
        <!-- First Name Block -->
        <div id="notStaff" class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __("First Name"); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="input-row">
                    <!-- Initials Dropdown -->
                    <div class="input-wrapper">
                        <?php echo $this->Form->input('Person.initial_id', array(
                            'empty' => __('Select'),
                            'options' => $initials,
                            'class' => 'custom-dropdown validate[required,custom[mandatory-select]]',
                            'label' => false,
                            'id' => 'initials',
                            'style' => 'width:100%;'
                        )); ?>
                    </div>
                    <!-- First Name Input -->
                    <div class="input-wrapper">
                        <?php echo $this->Form->input('Person.first_name', array(
                            'style' => 'width:100%;',
                            'class' => 'custom-textbox validate[required,custom[name],custom[onlyLetterSp]]',
                            'label' => false,
                            'id' => 'first_name',
                            'autocomplete' => 'off',
                            'placeholder' => 'Enter First Name' // Added placeholder for better UX
                        )); ?>
                    </div>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back Button -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>
        <!-- Middle Name Block -->
        <div class="input-block formRow required-field" id="middle-name-block">
            <!-- Middle Name Label -->
            <div class="formLabel">
                <?php echo __('Middle Name'); ?>
            </div>
            <!-- Middle Name Input -->
            <div class="formInput">
                <?php 
                    echo $this->Form->input('Person.middle_name', array(
                        'label' => false,
                        'class' => 'custom-textbox',
                        'id' => 'middle_name',
                        'size' => '40',
                        'autocomplete' => 'off',
                        'placeholder' => 'Enter Middle Name' // Added placeholder
                    )); 
                ?>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- Last Name Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Last Name'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <?php echo $this->Form->input('Person.last_name', array(
                    'label' => false,
                    'style' => 'text-transform:capitalize;',
                    'class' => 'custom-textbox validate[required,custom[onlyLetterSp],custom[mandatory-enter]]',
                    'id' => 'last_name',
                    'autocomplete' => 'off',
                    'placeholder' => 'Enter Last Name' // Added placeholder
                )); ?>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>


                <!-- Age Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Age'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="age-row">
                    <!-- Age in Years -->
                    <div class="input-wrapper">
                        <?php echo $this->Form->input('Person.age_year', array(
                            'div' => false,
                            'type' => 'text',
                            'class' => 'custom-age-input validate[required,custom[mandatory-enter],custom[onlyNumber]]',
                            'maxLength' => '3',
                            'placeholder' => 'Years',
                            'id' => 'age',
                            'label' => false
                        )); ?>
                    </div>
                    <!-- Age in Months -->
                    <div class="input-wrapper">
                        <?php echo $this->Form->input('Person.age_month', array(
                            'div' => false,
                            'type' => 'text',
                            'class' => 'custom-age-input validate[required,custom[mandatory-enter],custom[onlyNumber]]',
                            'maxLength' => '2',
                            'placeholder' => 'Months',
                            'id' => 'ageMonth',
                            'label' => false
                        )); ?>
                    </div>
                    <!-- Age in Days -->
                    <div class="input-wrapper">
                        <?php echo $this->Form->input('Person.age_day', array(
                            'div' => false,
                            'type' => 'text',
                            'class' => 'custom-age-input validate[required,custom[mandatory-enter],custom[onlyNumber]]',
                            'maxLength' => '2',
                            'placeholder' => 'Days',
                            'id' => 'ageDay',
                            'label' => false
                        )); ?>
                    </div>
                </div>
                <div class="dob-wrapper">
                    <div style="display: flex; align-items: center;">
                        <?php echo $this->Form->input('Person.dob', array(
                            'div' => false,
                            'type' => 'text',
                            'class' => 'custom-dob-input validate[required,custom[mandatory-date]]',
                            'readonly' => 'readonly', // Keep functionality intact
                            'placeholder' => 'Date of Birth',
                            'id' => 'dob',
                            'label' => false
                        )); ?>
                        <img
                            id="calendar-icon"
                            src="../img/quickreg/calender.png"
                            alt="Calendar Picker"
                            style="width: 50px; height: 50px; margin-left: 8px; cursor: pointer;"
                        />
                    </div>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- Gender Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Gender'); ?><font color="red">*</font>
            </div>
            <div class="formInput picture-choice">
                <!-- Male Option -->
                <input id="sex-male" name="data[Person][sex]" value="Male" type="radio"
                    <?php echo (isset($this->request->data['Person']['sex']) && $this->request->data['Person']['sex'] === 'Male') ? 'checked' : ''; ?>>
                <label for="sex-male" class="btn-1">
                    <img src="../img/quickreg/male.png" alt="Male Icon" width="50">
                    <span>Male</span>
                </label>
        
                <!-- Female Option -->
                <input id="sex-female" name="data[Person][sex]" value="Female" type="radio"
                    <?php echo (isset($this->request->data['Person']['sex']) && $this->request->data['Person']['sex'] === 'Female') ? 'checked' : ''; ?>>
                <label for="sex-female" class="btn-1">
                    <img src="../img/quickreg/female.png" alt="Female Icon" width="50">
                    <span>Female</span>
                </label>
        
                <!-- Other Option -->
                <input id="sex-other" name="data[Person][sex]" value="Other" type="radio"
                    <?php echo (isset($this->request->data['Person']['sex']) && $this->request->data['Person']['sex'] === 'Other') ? 'checked' : ''; ?>>
                <label for="sex-other" class="btn-1">
                    <img src="../img/quickreg/gender-neutral.png" alt="Other Icon" width="50">
                    <span>Other</span>
                </label>
        
                <!-- Prefer Not to Say Option -->
                <input id="sex-prefer-not" name="data[Person][sex]" value="Prefer not to say" type="radio"
                    <?php echo (isset($this->request->data['Person']['sex']) && $this->request->data['Person']['sex'] === 'Prefer not to say') ? 'checked' : ''; ?>>
                <label for="sex-prefer-not" class="btn-1">
                    <img src="../img/quickreg/block.png" alt="Prefer Not to Say Icon" width="50">
                    <span>Prefer not to say</span>
                </label>
            </div>
        
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>


        <!-- Pin Code Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Pin Code'); ?><font color="red">* </font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.pin_code', array(
                        'class' => 'custom-input validate[optional,custom[onlyNumber,minSize[6]]]',
                        'label' => false,
                        'id' => 'pinCode',
                        'maxlength' => '6',
                        'placeholder' => 'Enter Pin Code',
                        'autocomplete' => 'off'
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>


        <!-- State Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('State'); ?>
            </div>
            <div class="formInput" id="customstate1">
                <!-- Visible Input for State Name -->
                <?php echo $this->Form->input('stateName', array(
                    'class' => 'custom-input validate[required,custom[mandatory-enter]]',
                    'id' => 'stateName',
                    'label' => false,
                    'placeholder' => 'Enter State' // Added placeholder
                )); ?>
        
                <!-- Hidden Input for State ID -->
                <?php echo $this->Form->hidden('Person.state', array('id' => 'stateId')); ?>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- City/Town Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('City/Town'); ?>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <!-- Input for City/Town -->
                    <?php echo $this->Form->input('Person.city', array(
                        'class' => 'custom-input validate[required,custom[mandatory-enter]]',
                        'id' => 'city',
                        'label' => false,
                        'placeholder' => 'Enter City/Town' // Added placeholder
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- Mobile Number Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Mobile Number'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.mobile', array(
                        'label' => false,
                        'type' => 'text',
                        'class' => 'custom-input validate[required,custom[phone,minSize[10],onlyNumber]]',
                        'maxlength' => '10',
                        'id' => 'phone_number',
                        'placeholder' => 'Enter Mobile Number',
                        'autocomplete' => 'off'
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>


        <!-- Blood Group Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Blood Group'); ?>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php 
                        $blood_group = array(
                            "A+" => "A+",
                            "A-" => "A-",
                            "B+" => "B+",
                            "B-" => "B-",
                            "AB+" => "AB+",
                            "AB-" => "AB-",
                            "O+" => "O+",
                            "O-" => "O-"
                        );
                        echo $this->Form->input('Person.blood_group', array(
                            'empty' => __('Please Select'),
                            'options' => $blood_group,
                            'class' => 'custom-input',
                            'id' => 'blood_group',
                            'label' => false
                        ));
                    ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>



        <!-- Emergency Contact Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Emergency Contact Name'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.next_of_kin_name', array(
                        'class' => 'custom-input validate[required,custom[name],custom[onlyLetterSp]]',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'next_of_kin_name',
                        'placeholder' => 'Enter Emergency Contact Name',
                        'autocomplete' => "off"
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>
        
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Emergency Contact Mobile'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.next_of_kin_mobile', array(
                        'label' => false,
                        'type' => 'text',
                        'class' => 'custom-input validate[required,custom[phone],minSize[10],onlyNumber]',
                        'maxlength' => '10',
                        'id' => 'next_of_kin_mobile',
                        'placeholder' => 'Enter Emergency Contact Mobile',
                        'autocomplete' => "off"
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- Second Emergency Contact Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Second Emergency Contact Name'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.second_next_of_kin_name', array(
                        'class' => 'custom-input validate[required,custom[name],custom[onlyLetterSp]]',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'second_next_of_kin_name',
                        'placeholder' => 'Enter Second Emergency Contact Name',
                        'autocomplete' => "off"
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Second Emergency Contact Mobile'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.second_next_of_kin_mobile', array(
                        'label' => false,
                        'type' => 'text',
                        'class' => 'custom-input validate[required,custom[phone],minSize[10],onlyNumber]',
                        'maxlength' => '10',
                        'id' => 'second_next_of_kin_mobile',
                        'placeholder' => 'Enter Second Emergency Contact Mobile',
                        'autocomplete' => "off"
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <!--<button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>-->
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- Address Line 1 Block -->
        <div class="input-block formRow required-field" id="address-line-1-block">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Address'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.plot_no', array(
                        'class' => 'custom-input validate[required,custom[customaddress1]]',
                        'label' => false,
                        'id' => 'plot_no',
                        'placeholder' => 'Enter Address Line',
                        'autocomplete' => 'off'
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">Fill Up More Information</button>
                </div>
            </div>
        </div>

        <!--<div class="input-block formRow" id="address-line-2-block">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Address Line 2'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <?php echo $this->Form->input('Person.landmark', array(
                    'class' => 'validate[required,custom[customaddress1]] textBoxExpnd',
                    'label' => false,
                    'id' => 'landmark',
                    'autocomplete' => 'off'
                )); ?>
            </div>
            
        </div>-->
        <?php if($this->Session->read("website.instance") == "vadodara") { ?>
            <!-- Address Block -->
            <div class="input-block formRow required-field">
                <div class="formLabel" id="boxSpace">
                    <?php echo __('Address'); ?><font color="red">*</font>
                </div>
                <div class="formInput">
                    <div class="code-wrapper">
                        <?php echo $this->Form->input('Person.plot_no', array(
                            'class' => 'custom-textbox validate[required,custom[customaddress1]]',
                            'label' => false,
                            'id' => 'plot_no',
                            'autocomplete' => 'off',
                            'type' => 'textarea',
                            'cols' => '2',
                            'rows' => '2',
                            'placeholder' => 'Enter Address'
                        )); ?>
                    </div>
                </div>
                <div class="nav-buttons">
                    <div class="nav-buttons-left">
                        <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                        <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                    </div>
                    <div class="nav-buttons-right">
                        <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                    </div>
                </div>
            </div>

            <!-- Zip Block -->
            <div class="input-block formRow required-field">
                <div class="formLabel" id="boxSpace">
                    <?php echo __('Zip'); ?><font color="red">*</font>
                </div>
                <div class="formInput">
                    <div class="code-wrapper">
                        <?php echo $this->Form->input('Person.pin_code', array(
                            'class' => 'custom-input validate[optional,custom[onlyNumber,minSize[6]]]',
                            'label' => false,
                            'id' => 'pinCode',
                            'maxlength' => '6',
                            'autocomplete' => 'off',
                            'placeholder' => 'Enter Zip Code'
                        )); ?>
                    </div>
                </div>
                <div class="nav-buttons">
                    <div class="nav-buttons-left">
                        <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                        <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                    </div>
                    <div class="nav-buttons-right">
                        <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                    </div>
                </div>
            </div>
            <?php } else { ?>

            <!-- Type of Enrollment Block -->
            <div class="input-block formRow required-field">
                <div class="formLabel">
                    <?php echo __('Type of Enrollment'); ?><font color="red">*</font>
                </div>
                <div class="formInput">
                    <div class="code-wrapper">
                        <?php if ($online == false) { ?>
                            <?php echo $this->Form->input('Patient.treatment_type', array(
                                'empty' => __('Please Select'),
                                'options' => $opdoptions,
                                'label' => false,
                                'class' => "custom-input validate[required,custom[mandatory-select]]",
                                'id' => 'opd_id'
                            )); ?>
                        <?php } else { ?>
                            <?php echo $this->Form->input('Patient.treatment_type', array(
                                'options' => $opdoptions,
                                'label' => false,
                                'class' => "custom-input validate[required,custom[mandatory-select]]",
                                'id' => 'opd_id'
                            )); ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="nav-buttons">
                    <!-- Back and Forward Buttons -->
                    <div class="nav-buttons-left">
                        <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                        <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                    </div>
                    <!-- Save & Next Button -->
                    <div class="nav-buttons-right">
                        <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                    </div>
                </div>   
            </div>
        <?php } ?>


        <?php if($this->Session->read('website.instance') != 'vadodara') { ?>
            <!-- Primary Care Physician Block -->
            <div class="input-block formRow required-field">
                <div class="formLabel" id="boxSpace">
                    <?php echo __('Primary Care Physician'); ?><font color="red">* </font>
                </div>
                <div class="formInput">
                    <div class="code-wrapper">
                        <?php if($online == false) { ?>
                            <?php echo $this->Form->input('Patient.doctor_id', array(
                                'empty' => __('Please Select'),
                                'options' => $doctorlist,
                                'selected' => $selected,
                                'label' => false,
                                'class' => "custom-input validate[required,custom[mandatory-select]]",
                                'id' => 'doctor_id',
                                'value' => Configure::read('default_doctor_selected'),
                                'placeholder' => 'Select Primary Care Physician'
                            )); ?>
                        <?php } else { ?>
                            <?php echo $this->Form->input('Patient.doctor_id', array(
                                'options' => $doctorlist,
                                'selected' => $selected,
                                'label' => false,
                                'class' => "custom-input validate[required,custom[mandatory-select]]",
                                'id' => 'doctor_id',
                                'value' => Configure::read('default_doctor_selected'),
                                'placeholder' => 'Select Primary Care Physician'
                            )); ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="nav-buttons">
                    <!-- Back and Forward Buttons -->
                    <div class="nav-buttons-left">
                        <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                        <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                    </div>
                    <!-- Save & Next Button -->
                    <div class="nav-buttons-right">
                        <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                    </div>
                </div>
            </div>

            <!-- Special Medical Requirements Block -->
            <div class="input-block formRow required-field">
                <div class="formLabel" id="boxSpace">
                    <?php echo __('Special Medical Requirements'); ?>
                </div>
                <div class="formInput">
                    <div class="code-wrapper">
                        <?php if ($online == false) { ?>
                            <?php echo $this->Form->input('Patient.department_id', array(
                                'empty' => __('Please Select'),
                                'options' => $departments,
                                'id' => 'department_id',
                                'label' => false,
                                'class' => 'custom-input department_id',
                                'disabled' => 'disabled',
                                'value' => '',
                                'placeholder' => 'Select Department'
                            )); ?>
                            <?php echo $this->Form->hidden('', array(
                                'name' => "data[Patient][department_id]",
                                'id' => 'department_id1'
                            )); ?>
                        <?php } else { ?>
                            <?php echo $this->Form->input('Patient.department_id', array(
                                'empty' => __('Please Select'),
                                'options' => $departments,
                                'id' => 'department_id',
                                'label' => false,
                                'class' => 'custom-input department_id',
                                'value' => '12', // Default value can be adjusted
                                'placeholder' => 'Select Department'
                            )); ?>
                            <?php echo $this->Form->hidden('', array(
                                'name' => "data[Patient][department_id]",
                                'id' => 'department_id1',
                                'value' => '12' // Default value for hidden input
                            )); ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="nav-buttons">
                    <!-- Back and Forward Buttons -->
                    <div class="nav-buttons-left">
                        <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                        <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                    </div>
                    <!-- Save & Next Button -->
                    <div class="nav-buttons-right">
                        <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                    </div>
                </div>
            </div>
        <?php } ?>


                <!-- Visit Type and Preferred Service Type Block -->
                <!-- Visit Type Block -->
        <div class="input-block formRow ">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Visit Type'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php if ($online == false) { ?>
                        <?php echo $this->Form->input('Patient.treatment_type', array(
                            'empty' => __('Please Select'),
                            'options' => $opdoptions,
                            'label' => false,
                            'class' => 'custom-input validate[required,custom[mandatory-select]]',
                            'id' => 'opd_id',
                            'placeholder' => 'Select Visit Type'
                        )); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('Patient.treatment_type', array(
                            'options' => $opdoptions,
                            'label' => false,
                            'class' => 'custom-input validate[required,custom[mandatory-select]]',
                            'id' => 'opd_id',
                            'placeholder' => 'Select Visit Type'
                        )); ?>
                    <?php } ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- Preferred Service Type Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Preferred Service Type'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php if ($online == false) { ?>
                        <?php echo $this->Form->input('Patient.tariff_standard_id', array(
                            'empty' => __('Please Select'),
                            'options' => $tariff,
                            'label' => false,
                            'class' => 'custom-input validate[required,custom[mandatory-select]]',
                            'id' => 'tariff',
                            'placeholder' => 'Select Preferred Service Type'
                        )); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('Patient.tariff_standard_id', array(
                            'options' => $tariff,
                            'label' => false,
                            'class' => 'custom-input validate[required,custom[mandatory-select]]',
                            'id' => 'tariff',
                            'placeholder' => 'Select Preferred Service Type'
                        )); ?>
                    <?php } ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>


        <div class="input-block formRow required-field">
            <div class="formLabel"><?php echo __('Chronic Conditions'); ?></div>
            <div class="formInput">
                <?php
                $options = [
                    'Diabetes' => 'Diabetes',
                    'Hypertension' => 'Hypertension',
                    'Asthma' => 'Asthma',
                    'Epilepsy' => 'Epilepsy',
                    'None' => 'None',
                    'Other' => 'Other' // Ensure value matches the JavaScript condition
                ];

                $index = 'A';
                foreach ($options as $value => $label) {
                    echo '<div class="radio-button-wrapper">';
                    echo '<input id="chronic_condition_' . $value . '" class="toggle validate[required]" name="Person[chronic_condition]" value="' . $value . '" type="radio" onclick="toggleOtherInput(\'' . $value . '\', \'otherConditionDiv\', \'other_chronic_condition\')">'; // Attach toggle function
                    echo '<label for="chronic_condition_' . $value . '" class="btn"><span>' . $index . '</span> ' . $label . '</label>';
                    echo '</div>';
                    $index++;
                }
                ?>
                <!-- Textbox for "Other" option -->
                <div id="otherConditionDiv" style="display: none; margin-top: 10px;">
                    <?php echo $this->Form->input('Person.other_chronic_condition', [
                        'class' => 'custom-input',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'other_chronic_condition',
                        'placeholder' => 'Specify Other Condition',
                        'autocomplete' => 'off',
                    ]); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650;</button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <script>
            function toggleOtherInput(value) {
                console.log("Selected Value:", value); // Debug log for selected value
                const otherInputDiv = document.getElementById('otherConditionDiv');
                const otherInputField = document.getElementById('other_chronic_condition');

                if (value === 'Other') { // Ensure the value matches "Other"
                    console.log("Other selected - showing input box."); // Debugging log for "Other"
                    otherInputDiv.style.display = 'block'; // Show the textbox
                    otherInputField.focus(); // Focus on the textbox
                } else {
                    console.log("Hiding input box."); // Debugging log for hiding
                    otherInputDiv.style.display = 'none'; // Hide the textbox
                    otherInputField.value = ''; // Clear the textbox value
                }
            }
        </script>



        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Allergy'); ?>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input(
                        'Person.allergy',
                        [
                            'class' => 'custom-input',
                            'type' => 'text',
                            'label' => false,
                            'id' => 'allergy',
                            'placeholder' => 'Enter Allergy Details',
                            'autocomplete' => 'off',
                        ]
                    ); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>
        <!-- E-mail Address Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('E-mail Address'); ?>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.email', array(
                        'class' => 'custom-input validate["",custom[email]]',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'person_email_address',
                        'placeholder' => 'Enter E-mail Address',
                        'autocomplete' => "off",
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- Current Medication Block -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Current Medication'); ?>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.current_medication', array(
                        'class' => 'custom-input',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'current_medication',
                        'placeholder' => 'Enter Current Medication',
                        'autocomplete' => "off",
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

            <!--known medical condition and consent to share medical information-->
         <div class="input-block formRow required-field">
                <div class="formLabel"><?php echo __('Known Medical Conditions'); ?></div>
                <div class="formInput">
                    <?php
                    $options = [
                        'Heart Disease' => 'Heart Disease',
                        'Kidney Issues' => 'Kidney Issues',
                        'Previous Surgeries' => 'Previous Surgeries',
                        'None' => 'None',
                        'Other' => 'Other (Specify)'
                    ];

                    $index = 'A'; // Start label index
                    foreach ($options as $value => $label) {
                        echo '<div class="radio-button-wrapper">';
                        echo '<input id="known_condition_' . str_replace(' ', '_', $value) . '" class="toggle validate[required]" name="Person[known_medical_conditions]" value="' . $value . '" type="radio" onclick="toggleKnownCondition(\'' . $value . '\')">';
                        echo '<label for="known_condition_' . str_replace(' ', '_', $value) . '" class="btn"><span>' . $index . '</span> ' . $label . '</label>';
                        echo '</div>';
                        $index++; // Increment label index
                    }
                    ?>
                    <div id="knownConditionOtherDiv" style="display: none; margin-top: 10px;">
                        <?php echo $this->Form->input('Person.other_known_medical_conditions', [
                            'class' => 'custom-input',
                            'type' => 'text',
                            'label' => false,
                            'id' => 'other_known_medical_conditions',
                            'placeholder' => 'Please specify',
                            'autocomplete' => 'off',
                        ]); ?>
                    </div>
                </div>
                <div class="nav-buttons">
                    <div class="nav-buttons-left">
                        <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650;</button>
                        <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                    </div>
                    <div class="nav-buttons-right">
                        <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                    </div>
                </div>
            </div>


            <script>
                function toggleKnownCondition(selectedValue) {
                    console.log("Selected Value for Known Medical Conditions:", selectedValue); // Debugging
                    const knownConditionDiv = document.getElementById('knownConditionOtherDiv');
                    const knownConditionInput = document.getElementById('other_known_medical_conditions');

                    if (selectedValue === 'Other' || selectedValue === 'Other (Specify)') {
                        knownConditionDiv.style.display = 'block'; // Show the "Other" input field
                        knownConditionInput.focus(); // Focus on the input field
                    } else {
                        knownConditionDiv.style.display = 'none'; // Hide the "Other" input field
                        knownConditionInput.value = ''; // Clear the input field
                    }
                }

            </script>

        <!-- Consent to Share Medical Information -->
        <div class="input-block formRow">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Consent to Share Medical Information:'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.share_info', array(
                        'class' => 'custom-input validate[required,custom[mandatory-select]]',
                        'type' => 'select',
                        'label' => false,
                        'id' => 'share_info',
                        'options' => array(
                            '' => '-- Select --',
                            'Yes' => 'Yes',
                            'No' => 'No'
                        ),
                        'autocomplete' => "off",
                        'placeholder' => 'Select Option'
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>


        <!-- Insurance -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Insurance Information'); ?>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.insurence_information', array(
                        'class' => 'custom-input validate[""]',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'insurance_information',
                        'placeholder' => 'Enter Insurance Information',
                        'autocomplete' => "off"
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

            <!-- Preferred Hospital -->
            <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Preferred Hospital'); ?>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.preferred_hospital', array(
                        'class' => 'custom-input validate[""]',
                        'type' => 'select',
                        'label' => false,
                        'id' => 'preferred_hospital',
                        'options' => array(
                            '' => '-- Select --',
                            'Hope Hospital' => 'Hope Hospital',
                            'Ayushman Nagpur Hospital' => 'Ayushman Nagpur Hospital',
                            'Local Hospital' => 'Local Hospital',
                            'Any Available' => 'Any Available'
                        ),
                        'autocomplete' => "off",
                        'onchange' => "toggleTextbox(this.value)"
                    )); ?>
                </div>
                <div class="code-wrapper" id="hospital_textbox" style="display:none; margin-top: 10px;">
                    <?php echo $this->Form->input('Person.other_hospital', array(
                        'class' => 'custom-input validate[""]',
                        'type' => 'text',
                        'label' => false,
                        'placeholder' => 'Specify hospital',
                        'id' => 'other_hospital',
                        'autocomplete' => "off"
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <script>
            function toggleTextbox(value) {
                const textboxDiv = document.getElementById('hospital_textbox');
                if (value === 'Any Available') {
                    textboxDiv.style.display = 'block';
                } else {
                    textboxDiv.style.display = 'none';
                }
            }
        </script>
            <!--Organ donare -->
                <!-- Do Not Resuscitate (DNR) Order -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Do Not Resuscitate (DNR) Order'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.dnr', array(
                        'class' => 'custom-input validate[required]',
                        'type' => 'select',
                        'label' => false,
                        'id' => 'dnr',
                        'options' => array(
                            '' => '-- Select --',
                            'Yes' => 'Yes',
                            'No' => 'No',
                            'Undecided' => 'Undecided'
                        ),
                        'autocomplete' => "off"
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <!-- Organ Donor Status -->
        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Organ Donor Status'); ?><font color="red">*</font>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.organ_donor', array(
                        'class' => 'custom-input validate[required]',
                        'type' => 'select',
                        'label' => false,
                        'id' => 'organ_donor',
                        'options' => array(
                            '' => '-- Select --',
                            'Yes' => 'Yes',
                            'No' => 'No',
                            'Prefer not to disclose' => 'Prefer not to disclose'
                        ),
                        'autocomplete' => "off"
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>


        <div class="input-block formRow required-field">
            <div class="formLabel"><?php echo __('Language Preference:'); ?></div>
            <div class="formInput">
                <?php
                $options = [
                    'English' => 'English',
                    'Hindi' => 'Hindi',
                    'Marathi' => 'Marathi',
                    'Other' => 'Other (Specify)'
                ];
        
                $index = 'A';
                foreach ($options as $value => $label) {
                    echo '<div class="radio-button-wrapper">';
                    echo '<input id="language_preference_' . $value . '" class="toggle validate[required]" name="Person[language_preference]" value="' . $value . '" type="radio" onclick="toggleOtherInput(\'' . $value . '\', \'otherLanguageDiv\', \'other_language\')">';
                    echo '<label for="language_preference_' . $value . '" class="btn"><span>' . $index . '</span> ' . $label . '</label>';
                    echo '</div>';
                    $index++;
                }
                ?>
                <div id="otherLanguageDiv" style="display: none; margin-top: 10px;">
                    <?php echo $this->Form->input('Person.other_language', [
                        'class' => 'custom-input',
                        'type' => 'text',
                        'label' => false,
                        'id' => 'other_language',
                        'placeholder' => 'Specify language',
                        'autocomplete' => 'off',
                    ]); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>



        <script>
            // JavaScript function to toggle the textbox
            function toggleLanguageTextbox(dropdown) {
                const textboxDiv = document.getElementById('other_language');
                if (dropdown.value === 'Other (Specify)') {
                    textboxDiv.style.display = 'block'; // Show the text box
                    textboxDiv.focus(); // Automatically focus on the text box
                } else {
                    textboxDiv.style.display = 'none'; // Hide the text box
                    textboxDiv.value = ''; // Clear the value in the textbox if hidden
                }
            }
        </script>


        <div class="input-block formRow required-field">
            <div class="formLabel" id="boxSpace">
                <?php echo __('Digital Signature for Consent and Terms Agreement:'); ?>
            </div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php echo $this->Form->input('Person.digital_signature', array(
                        'label' => false,
                        'type' => 'text',
                        'class' => 'custom-input validate[required]',
                        'id' => 'digital_signature',
                        'placeholder' => 'Enter Digital Signature',
                        'autocomplete' => "off"
                    )); ?>
                </div>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>


        <!--End BY online patients-->
            
            <!-- Patient Does Not Have Mobile Number -->
        <!--<div class="input-block formRow toggle-row">

            
            <div class="formLabel">
                <?php echo __('Patient does not have a mobile number'); ?>
            </div>
            <div class="formInput">
                <?php echo $this->Form->input('Person.no_number', array(
                    'label' => false,
                    'type' => 'checkbox',
                    'class' => 'no_number',
                    'id' => 'no_number'
                )); ?>
            </div>
        </div>-->

        <!-- Weight (Only for Kanpur Instance) -->
        <?php 
        $website = $this->Session->read("website.instance");
        if ($website == "kanpur") { ?>
           <!-- <div class="formLabel">
                <?php echo __('Weight'); ?>
            </div>
            <div class="formInput">
                <?php 
                echo $this->Form->input('Patient.patient_weight', array(
                    'label' => false,
                    'type' => 'text',
                    'class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd',
                    'style' => 'width:60px',
                    'maxlength' => '3',
                    'autocomplete' => "off",
                    'placeholder' => 'Enter weight'
                )); 
                echo "&nbsp;Kg";
                ?>
            </div>-->
        <?php } ?>

        
    

        <?php if ($this->Session->read("website.instance") == 'lifespring') { ?>
            <!-- Pregnancy Details -->
            <!--<div class="input-block formRow toggle-row" id="pregnancy-details">
                <div class="formLabel"><?php echo __('Is Pregnant'); ?></div>
                <div class="formInput">
                    <?php echo $this->Form->checkbox('is_pregnent', array(
                        'legend' => false,
                        'label' => false,
                        'class' => 'is_pregnent',
                        'id' => 'is_pregnent',
                        'style' => 'float:left;'
                    )); ?>
                    <span class="hideRow" style="display:none;">
                        <?php echo $this->Form->input('Person.pregnant_week', array(
                            'type' => 'text',
                            'legend' => false,
                            'label' => false,
                            'div' => false,
                            'class' => 'pregnant_week validate[optional,custom[onlyNumber]]',
                            'style' => 'width:150px',
                            'autocomplete' => 'off',
                            'id' => 'pregnant_week'
                        )); ?> Weeks
                    </span>
                </div>
                <div class="formLabel hideRow" style="display: none; width:40px;"><?php echo __('EDD'); ?></div>
                <div class="formInput hideRow" style="display: none;">
                    <?php echo $this->Form->input('Person.expected_date_del', array(
                        'type' => 'text',
                        'class' => 'textBoxExpnd edd',
                        'label' => false,
                        'autocomplete' => 'off',
                        'id' => 'edd'
                    )); ?>
                </div>
            </div>-->

            <!-- Coupon Name -->
            <!--<div class="formRow" id="coupon-details">
                <div class="formLabel"><?php echo __('Coupon Name.'); ?></div>
                <div class="formInput">
                    <?php echo $this->Form->input('Patient.coupon_name', array(
                        'class' => 'coupon_name',
                        'value' => $this->params->query['coupon_name'],
                        'label' => false,
                        'id' => 'coupon_name'
                    )); ?>
                    <span id="validcoupon" style="display:none; color:green;"><?php echo 'Valid Coupon'; ?></span>
                </div>
            </div>-->
        <?php } ?>

        <div class="input-block formRow required-field" id="registration-details">
            <div class="formLabel"><?php echo __('Registration Date:'); ?></div>
            <div class="formInput">
                <div class="code-wrapper">
                    <?php 
                    $dateValue = Configure::read('allowTimelyQuickReg') 
                        ? $this->DateFormat->formatDate2LocalForReport(date('Y-m-d'), Configure::read('date_format'), true)
                        : $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'), Configure::read('date_format'), true);

                    echo $this->Form->input('Patient.form_received_on', array(
                        'type' => 'text',
                        'class' => 'custom-input validate[required]',
                        'readonly' => 'readonly',
                        'id' => 'date',
                        'label' => false,
                        'value' => $dateValue,
                        'placeholder' => 'Select Registration Date',
                    )); ?>
                </div>
            </div>

            <?php if (Configure::read('allowTimelyQuickReg')) { ?>
                <div class="formLabel"><?php echo __('Appointment Time:'); ?><font color="red">*</font></div>
                <div class="formInput">
                    <div class="code-wrapper">
                        <?php echo $this->Form->input('Person.start_time', array(
                            'label' => false,
                            'class' => 'custom-input validate[required,custom[mandatory-enter]]',
                            'readonly' => true,
                            'id' => 'timepicker_start',
                            'value' => date('H:i:00', (round(time() / (15 * 60)) * (15 * 60))),
                            'placeholder' => 'Select Appointment Time',
                        )); ?>
                    </div>
                </div>
            <?php } ?>

            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>
        
        <!--  <tr><?php echo __('Patient/Gaurdian has approved the following :');?>
        <?php echo __('Send mobile text notification');?></td>
            <td width="30%"><?php echo $this->Form->input('Person.mobile_permission', array('label'=>false,'type'=>'checkbox','class' => '','id' => 'mobile_permission'));?></td>
        
        <?php echo __('Send voice text notification');?></td>
            <td width="30%"><?php echo $this->Form->input('Person.voice_permission', array('label'=>false,'type'=>'checkbox','class' => '','id' => 'voice_permission'));?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        -->
    
        <div class="input-block formRow required-field" id="upload-id-proof">
            <div class="formLabel"><?php echo __("Upload ID Proof:"); ?></div>
            <div class="formInput">
                <!-- Dropdown for ID Proof Types -->
                <div class="code-wrapper">
                    <?php 
                        echo $this->Form->input('Person.id_proof_type', array(
                            'type' => 'select',
                            'id' => 'id_proof_type',
                            'class' => 'custom-input',
                            'options' => array(
                                '' => '-- Select ID Proof --',
                                'Aadhaar Card' => 'Aadhaar Card',
                                'PAN Card' => 'PAN Card',
                                'Voter ID' => 'Voter ID',
                                'Passport' => 'Passport',
                                'Driving License' => 'Driving License'
                            ),
                            'label' => false,
                            'div' => false,
                            'error' => false,
                            'onchange' => "toggleFileUpload(this.value)",
                        ));
                    ?>
                </div>

                <!-- File Upload for ID Proof -->
                <div id="upload_section" style="display:none; margin-top:15px;">
                    <div class="upload-wrapper">
                        <?php 
                            echo $this->Form->input('Person.upload_image', array(
                                'type' => 'file',
                                'id' => 'patient_photo',
                                'class' => 'custom-file-input',
                                'label' => false,
                                'div' => false,
                                'error' => false
                            ));
                            echo $this->Form->hidden('Person.web_cam', array('id' => 'web_cam'));
                        ?>
                        <div class="webcam-icon">
                            <?php echo $this->Html->image('/img/icons/webcam.png', array(
                                'id' => 'camera',
                                'title' => 'Capture photo from webcam',
                                'class' => 'webcam-img'
                            )); ?>
                        </div>
                    </div>
                    <canvas width="320" height="240" id="parent_canvas" style="display:none;"></canvas>
                </div>
            </div>

            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
                <!-- Save & Next Button -->
                <div class="nav-buttons-right">
                    <button type="button" class="btn-save-next" onclick="saveAndNext(this)">Save & Next</button>
                </div>
            </div>
        </div>

        <script>
            function toggleFileUpload(value) {
                const uploadSection = document.getElementById('upload_section');
                if (value && value !== '') {
                    uploadSection.style.display = 'block'; // Show the upload section if an ID proof is selected
                } else {
                    uploadSection.style.display = 'none'; // Hide the upload section if no ID proof is selected
                }
            }
        </script>
        <?php if ($this->Session->read("website.instance") == "vadodara") { ?>
            <!-- Multi Appointments Section -->
            <div class="input-block formRow">
                <div class="formInput">
                    <?php 
                        $countApp = 0;
                        echo multiApp($this->Form, $doctorlist, $departments, $opdoptions);
                    ?>
                </div>
            </div>

            <!-- Total Amount Section -->
            <div class="input-block formRow">
                <div class="formInput" style="text-align: right;">
                    <b>Total: <span id="total" class="total-amount">0</span></b>
                    <?php echo $this->Form->hidden('Patient.total', array('id' => 'totAmt')); ?>
                </div>
            </div>

            <?php if ($this->Session->read('website.instance') == 'vadodara') { ?>
                <!-- Visit Charge Section -->
                <div class="input-block formRow visit-charge-section">
                    <div class="formLabel"></div>
                    <div class="formInput">
                        <?php echo $this->Form->input('Person.visit_charge', array(
                            'type' => 'hidden',
                            'id' => 'visit_input',
                            'div' => false,
                            'label' => false
                        )); ?>
                        <span class="visit-charge-amount" id="visit_charge"></span>
                        <br>
                        <div class="pay-amount">
                            <label for="pay_charge">Pay Amount From Here:</label>
                            <?php echo $this->Form->input('Person.pay_amt', array(
                                'type' => 'checkbox',
                                'id' => 'pay_charge',
                                'div' => false,
                                'label' => false
                            )); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- SOAP Area Section -->
            <div class="input-block formRow soapArea" style="display: none;">
                <div class="formLabel"><?php echo __('Treatment Advice :'); ?></div>
                <div class="formInput"></div>
            </div>

            <!-- Add Appointments Button -->
            <div class="input-block formRow add-appointment">
                <div class="formInput" style="text-align: right;">
                    <button class="btn btn-add-appointment" id="addAppButton" onclick="addFields()">Add Appointments</button>
                </div>
            </div>
        <?php } ?>



            <div class="formRow">
            <?php $role = $this->Session->read('role'); ?>
            <?php if (($role == Configure::read('doctorLabel') || $role == Configure::read('nurseLabel'))) { ?>
                <div class="formLabel">
                    <?php echo __('Create Soap note'); ?>:
                </div>
                <div class="formInput">
                    <?php echo $this->Form->input('setSoap', array(
                        'name' => 'setSoap',
                        'type' => 'checkbox',
                        'id' => 'setSoap',
                        'label' => false,
                        'onclick' => 'toggleSoapArea()' // Add the toggle function on click
                    )); ?>
                </div>
            <?php } ?>
        </div>

        <div class="input-block formRow soapArea" style="display: block;">
            <div class="formLabel">
                <?php echo __('Advice :'); ?>
            </div>
            <div class="formInput">
                <?php echo $this->Form->input('Patient.advice', array(
                    'type' => 'textarea',
                    'rows' => '3',
                    'cols' => '5',
                    'id' => 'advice',
                    'label' => false,
                    'style' => 'width: 250px !important;'
                    
                )); ?>
            </div>
            <div class="nav-buttons">
                <!-- Back and Forward Buttons -->
                <div class="nav-buttons-left">
                    <button type="button" class="btn-arrow back-btn" onclick="navigateUp(this)">&#9650; </button>
                    <button type="button" class="btn-arrow forward-btn" onclick="navigateDown(this)">&#9660;</button>
                </div>
            </div>
        </div>

        


        <div class="soapArea" style="display: none;">
            <div class="formRow">
                <div id="successMsg" style="display: none; color: #78D73E; text-align: center;"></div>
            </div>

            <div class="formRow">
                <div class="formInput">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm" id="DrugGroup" style="padding: 0px !important">
                        <thead>
                            <tr>
                                <th style="width: 8%;">Drug Name</th>
                                <th style="width: 5%;">Dose</th>
                                <th style="width: 5%;">Form</th>
                                <th style="width: 5%;">Route</th>
                                <th style="width: 5%;">Frequency</th>
                                <th style="width: 3%;">Days</th>
                                <th style="width: 3%;">Qty</th>
                                <th style="width: 5%;">Refills</th>
                                <th style="width: 5%;">PRN</th>
                                <th style="width: 5%;">DAW</th>
                                <th style="width: 20%;">First Dose Date/Time</th>
                                <th style="width: 20%;">Stop Date/Time</th>
                                <th style="width: 8%;">Special Instruction</th>
                                <th style="width: 5%;">Is Active</th>
                            </tr>
                        </thead>
                        <tbody id="DrugGroupBody">
                            <tr id="DrugGroup0">
                                <td>
                                    <?php echo $this->Form->input('', [
                                        'label' => false,
                                        'type' => 'text',
                                        'class' => 'drugText',
                                        'id' => "drugText_0",
                                        'name' => 'drugText[]',
                                        'autocomplete' => 'off',
                                        'style' => 'width:100px'
                                    ]); ?>
                                    <?php echo $this->Form->hidden("", ['id' => "drug_0", 'name' => 'drug_id[]']); ?>
                                </td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'options' => $dose, 'class' => '', 'id' => "dose_type0", 'name' => 'dose_type[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'options' => $strenght, 'class' => '', 'id' => "strength0", 'name' => 'strength[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'options' => $route, 'class' => '', 'id' => "route_administration0", 'name' => 'route_administration[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'options' => Configure::read('frequency'), 'class' => '', 'id' => "frequency0", 'name' => 'frequency[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'type' => 'text', 'class' => '', 'id' => "day0", 'name' => 'day[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'type' => 'text', 'class' => '', 'id' => "quantity0", 'name' => 'quantity[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'options' => Configure::read('refills'), 'class' => '', 'id' => "refills0", 'name' => 'refills[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'options' => ['' => 'Select', '0' => 'No', '1' => 'Yes'], 'class' => '', 'id' => "prn0", 'name' => 'prn[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'options' => ['' => 'Select', '0' => 'No', '1' => 'Yes'], 'class' => '', 'id' => "daw0", 'name' => 'daw[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'type' => 'text', 'class' => 'my_start_date1 textBoxExpnd', 'id' => "start_date0", 'name' => 'start_date[]']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'type' => 'text', 'class' => 'my_end_date1 textBoxExpnd', 'id' => "end_date0", 'name' => 'end_date[]']); ?></td>
                                <td><?php echo $this->Form->textarea('', ['label' => false, 'class' => '', 'id' => "special_instruction0", 'name' => 'special_instruction[]', 'style' => 'width:150px']); ?></td>
                                <td><?php echo $this->Form->input('', ['label' => false, 'options' => ['' => 'Select', '0' => 'No', '1' => 'Yes'], 'class' => '', 'id' => "isactive0", 'name' => 'isactive[]']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="formRow">
                <div class="formInput" style="text-align: right;">
                    <button type="button" id="addButton">Add</button>
                    <button type="button" id="removeButton">Remove</button>
                </div>
            </div>
        </div>

    <script>
        $(document).ready(function() {
            $('.toggle-row').hide();

            $('#fill-up-more-btn').click(function() {
                $('.toggle-row').toggle(); 
            });
        });
    </script>


        <table width="100%">
            <tr>
                <td class="row_title" align="">
                    <div id="final-buttons" style="display: none; text-align: right;  margin-top: 50px;"> <!-- Initially hidden -->
                        <?php
                        echo $this->Form->hidden('Person.printSheet', array('value' => '1', 'id' => 'printSheet'));
                        echo $this->Form->hidden('Person.admission_type', array('id' => 'admission_type', 'value' => 'OPD'));
                        echo $this->Form->submit(__('Submit'), array(
                            'style' => 'margin: 0 10px 0 0; ',
                            'class' => 'blueBtn',
                            'div' => false,
                            'label' => false,
                            'id' => 'submit',
                            
                        ));

                        if ($isFingerPrintEnable == '1') {
                            echo $this->Form->submit(__('Capture Fingerprint'), array(
                                'style' => 'margin: 0 10px 0 0;',
                                'class' => 'blueBtn',
                                'div' => false,
                                'label' => false,
                                'id' => 'capturefingerprint',
                            ));
                        }
                        ?>
                    </div>
                </td>
                <!--<td colspan="2">
                    <?php
                    echo $this->Form->button(__('Fill Up More Information'), array(
                        'type' => 'button',
                        'id' => 'fill-up-more-btn',
                        'class' => 'blueBtn',
                        'style' => 'margin: 0 10px 0 0;',
                        'div' => false,
                        'label' => false
                    ));
                    ?>
                </td>-->
            </tr>
        </table>

        <?php echo $this->Form->end(); ?>
    </div>
    </div>
</div>






<?php //$this->Form
		$count=0;
	function multiApp($formData,$doctorlist,$departments,$opdoptions){
		
		$multiAppHtml='<table id=multiAppTable>';
		$multiAppHtml.='<tr>';					
		$multiAppHtml.='<td><b>Treating Consultant</b></td>';
		$multiAppHtml.='<td><b>Speciality</b></td>';
		$multiAppHtml.='<td><b>Visit Type</b></td>';
		$multiAppHtml.='<td><b>Visit Charges</b></td>';
		$multiAppHtml.='</tr>';
		$multiAppHtml.='<tr id=multiRow_0>';
		$multiAppHtml.='<td>';
		$multiAppHtml.=$formData->input('Patient.doctor_id', array('empty'=>__('Please Select'),'options'=>$doctorlist,'label'=>false,
 							'class' => "textBoxExpnd validate[required,custom[mandatory-select]] ",'id' => 'doctor_id',
							'value'=>Configure::read('default_doctor_selected') ));
  		$multiAppHtml.='</td>';
  		$multiAppHtml.='<td>';
  		$multiAppHtml.=$formData->input('Patient.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'id'=>'department_id','label'=>false,'class' => 'textBoxExpnd department_id', 'disabled'=>'disabled','value'=>''));
		$multiAppHtml.=$formData->hidden('',array('name'=>"data[Patient][department_id]",'id'=>'department_id1'));
  		$multiAppHtml.='</td>';
  		$multiAppHtml.='<td>';
  		$multiAppHtml.=$formData->input('Patient.treatment_type', array('empty'=>__('Please Select'),'options'=>$opdoptions,'label'=>false,
 								'class' => "textBoxExpnd validate[required,custom[mandatory-select]] visitApp",'id' => 'opd_id' ));
  		$multiAppHtml.='</td>';
  		$multiAppHtml.='<td><font size="3px" color="#F48F5B" style="font-weight: bold;">';
		$multiAppHtml.=$formData->input('Person.visit_charge',array('type'=>'hidden','id'=>'visit_input','div'=>false,'label'=>false));
		$multiAppHtml.='<span id="visit_charge"></span></font></td>';
		$multiAppHtml.='</tr>';
		$multiAppHtml.='<tr>';
		$multiAppHtml.='</tr>';
		$multiAppHtml.='</table>';
		return $multiAppHtml;

	}
?>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,hi,mr',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false,
            gaTrack: false,
            googleLogo: false
        }, 'google_translate_element');
    }

    // Trigger translation element when clicking the td
    document.getElementById('google_translate_element').addEventListener('click', function() {
        var translateDiv = document.getElementById('google_translate_element');
        
        // If Google Translate is not initialized yet, do it here
        if (!google.translate || !google.translate.TranslateElement) {
            googleTranslateElementInit();
        }

        // Open/close the language selector when clicking the td
        var langSelect = document.querySelector('.goog-te-combo');
        if (langSelect) {
            langSelect.focus(); // Focus the language dropdown if already created
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Initialize the Google Translate Element after the page is loaded
        if (google && google.translate && google.translate.TranslateElement) {
            googleTranslateElementInit();
        }
    });
</script>

<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!--poonam-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Initialize Flatpickr for Date of Birth with custom year dropdown
    const dobPicker = flatpickr("#dob", {
        dateFormat: "Y-m-d", // Format for date
        maxDate: "today", // Disable future dates
        altInput: true, // Show a human-readable input
        altFormat: "F j, Y", // Format for display
        defaultDate: "today", // Default to today's date
        allowInput: true, // Allow manual typing
        onReady: function (selectedDates, dateStr, instance) {
            // Add custom year dropdown
            const yearDropdown = document.createElement("select");
            yearDropdown.className = "flatpickr-year-dropdown";

            const minYear = 1900;
            const maxYear = new Date().getFullYear();
            for (let year = maxYear; year >= minYear; year--) {
                const option = document.createElement("option");
                option.value = year;
                option.textContent = year;
                yearDropdown.appendChild(option);
            }

            yearDropdown.value = instance.currentYear;
            yearDropdown.addEventListener("change", function () {
                instance.currentYear = parseInt(this.value);
                instance.redraw();
            });

            const yearElement = instance.calendarContainer.querySelector(".flatpickr-current-month .cur-year");
            yearElement.style.display = "none";
            yearElement.parentNode.appendChild(yearDropdown);
        },
        onChange: function (selectedDates, dateStr, instance) {
            if (dateStr) calculateAge(dateStr);
        }
    });

    document.getElementById("calendar-icon").addEventListener("click", function () {
        dobPicker.open();
    });

    function calculateAge(dob) {
        const dobDate = new Date(dob);
        const today = new Date();

        let ageYears = today.getFullYear() - dobDate.getFullYear();
        let ageMonths = today.getMonth() - dobDate.getMonth();
        let ageDays = today.getDate() - dobDate.getDate();

        if (ageDays < 0) {
            ageMonths--;
            ageDays += new Date(today.getFullYear(), today.getMonth(), 0).getDate();
        }

        if (ageMonths < 0) {
            ageYears--;
            ageMonths += 12;
        }

        document.getElementById("age").value = ageYears;
        document.getElementById("ageMonth").value = ageMonths;
        document.getElementById("ageDay").value = ageDays;
    }

    document.querySelectorAll("#age, #ageMonth, #ageDay").forEach(input => {
        input.addEventListener("input", function () {
            const years = parseInt(document.getElementById("age").value) || 0;
            const months = parseInt(document.getElementById("ageMonth").value) || 0;
            const days = parseInt(document.getElementById("ageDay").value) || 0;

            const today = new Date();
            const dob = new Date(today.getFullYear() - years, today.getMonth() - months, today.getDate() - days);

            const formattedDob = dob.toISOString().split("T")[0];
            document.getElementById("dob").value = formattedDob;
        });
    });

    // Autocomplete for State
    $("#stateName").autocomplete({
        source: "<?php echo $this->Html->url(['controller' => 'app', 'action' => 'testcomplete', 'State', 'id', 'name']); ?>",
        select: function (event, ui) {
            $("#stateId").val(ui.item.id);
        }
    });

    // Autocomplete for City based on State
    $(document).on("focus", "#city", function () {
        const stateId = $("#stateId").val();
        $(this).autocomplete({
            source: "<?php echo $this->Html->url(['controller' => 'app', 'action' => 'testcomplete', 'City', 'id', 'name']); ?>" + "/state_id=" + stateId,
            select: function (event, ui) {
                $("#city").val(ui.item.label);
            }
        });
    });

    // Pin Code Blur Event
    $("#pinCode").blur(function () {
        const pinCode = $(this).val();
        if (pinCode.length === 6) {
            $.ajax({
                url: "<?php echo $this->Html->url(['controller' => 'Persons', 'action' => 'getStateCity']); ?>/" + pinCode,
                method: "GET",
                success: function (data) {
                    const parsedData = JSON.parse(data);
                    if (parsedData.zip) {
                        $("#stateId").val(parsedData.zip.State.id);
                        $("#stateName").val(parsedData.zip.State.name);
                        $("#city").val(parsedData.zip.PinCode.city_name);
                    } else {
                        alert("Invalid Pin Code. Please enter a valid one.");
                        clearStateCityFields();
                    }
                },
                error: function () {
                    alert("Error fetching state and city. Please try again.");
                    clearStateCityFields();
                }
            });
        } else {
            clearStateCityFields();
        }
    });

    function clearStateCityFields() {
        $("#stateId").val("");
        $("#stateName").val("");
        $("#city").val("");
    }
});
</script>

<!--end-->


<script>
//script to include datepicker
var website = '<?php echo $this->Session->read('website.instance')?>';	
var validateCoupon = true ;		
if(website=='lifespring'){ 	
	$("#p_first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocompleteForPatientNameAndDob",1,"Person.sex=female&Person.initial_id NOT =7","admin" => false,"plugin"=>false)); ?>",{
		width: 80,
		selectFirst: true,
		valueSelected:true,
		loadId : 'p_first_name,motherPersonId',
		onItemSelect:function (data1) { 
			$('#first_name').css('textTransform', 'unset');
			name = $('#p_first_name').val();
			splitedval = name.split(" ");  
			splitedvalfname =  splitedval[0]; 
			splitedvallname =  splitedval[1]; 
			$('#first_name').val("Baby of "+" "+splitedvalfname);
			$('#last_name').val(splitedvallname);
			$.ajax({
				type:'POST',
	   			url : "<?php echo $this->Html->url(array("controller" => 'persons', "action" => "getMotherData", "admin" => false));?>"+"/"+$('#motherPersonId').val(),
	   			 context: document.body,   
	   			success: function(data){
	   			 var data = jQuery.parseJSON(data); 
	   			$("#plot_no").val($.trim(data.Person.plot_no));
	   			$("#pinCode").val($.trim(data.Person.pin_code));
	   			$("#city").val($.trim(data.Person.city));
	   			$("#state").val($.trim(data.Person.state));
	   			$("#stateName").val($.trim(data.Person.state));
	   			$("#phone_number").val($.trim(data.Person.mobile));
	   			$("#patientFile").val($.trim(data.Person.landmark));
	   			$("#taluka").val($.trim(data.Person.taluka));
	   			$("#middle_name").val($.trim(data.Person.middle_name));
	   			$("#district").val($.trim(data.Person.district));
	   			$("#landmark").val($.trim(data.Person.landmark));
	   			$("#person_email_address").val($.trim(data.Person.email));
		   		}
			});
		}
	});				
	$('#coupon_name').keyup(function(){
		if($('#coupon_name').val() == ''){
			$("#coupon_name").validationEngine("hideAll");
			$('#validcoupon').hide();
			validateCoupon = true  ;
		}else{
			$('#validcoupon').hide();
			$('#coupon_name').validationEngine('showPrompt', 'Invalid Coupon', 'text', 'topRight', true);
			validateCoupon = false ;
		}
	});
	
		$("#coupon_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Coupon","batch_name",'null',"null",'null',"parent_id NOT='0'","admin" => false,"plugin"=>false)); ?>", {
			width: 80,
			selectFirst: true,
			onItemSelect:function (data) { 
				 name = $('#coupon_name').val();
				$.ajax({
					type:'POST',
		   			url : "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "couponValidate","admin" => false));?>"+"/"+name,
		   			 context: document.body,   
		   			success: function(data){ 
		   				
		   				if($.trim(data) != 'Coupon Available' ){
		   					$('#validcoupon').hide();
							$('#coupon_name').validationEngine('showPrompt', data, 'text', 'topRight', true);
							validateCoupon = false;
		   				}else{
		   					$('#validcoupon').show();
		   					$("#coupon_name").validationEngine("hideAll");
		   					validateCoupon = true;
			   				}
			   		}
				}); 
			}
		});						
}

$(".edd").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	minDate: new Date(),
	dateFormat: '<?php echo $this->General->GeneralDate();?>',		
});	
$('#is_pregnent').click(function(){			
	if($("#is_pregnent").is(':checked')){	
		$('.hideRow').show();
	}else{
		$('.hideRow').hide();
		$('#pregnant_week , #edd').val("");	
	}
});	

jQuery(document).ready(function() {	
	<?php if($this->Session->read('website.instance')=='vadodara'){ ?>
		$('#opd_id').attr('disabled',true);
		$('#pay_charge').attr('checked',true);
		$('#opd_id').change(function(){//to maintain treatment type  --yashwant
			$('#PersonSearchForm').append($('<input>').attr({'type':'hidden','name':'data[Patient][treatment_type]','value' : $(this).val()}));
		});
	<?php } ?>
	 
	var print="<?php echo isset($this->params->query['print'])?$this->params->query['print']:'' ?>";
	var OpdSheet="<?php echo isset($this->params->query['patientId'])?$this->params->query['patientId']:'' ?>";
	var referral = "<?php echo $referral ; ?>" ;
	  
	if(print && referral != '/' && $("#formReferral").val()=='' && OpdSheet){
		$("#formReferral").val('yes') ;
		var url="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'printAdvanceReceipt',$this->params->query['print'])); ?>";
	    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=100,top=100"); // will open new tab on document ready

	    var docID =<?php echo json_encode($docId);?>;
	       $.each(docID, function(index, value) { 
	    	   var url="<?php echo $this->Html->url(array('controller'=>'patients','action'=>'opd_print_sheet',$this->params->query['patientId'])); ?>"+"/"+value;
	   	       window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=400,top=400");
	       
	       });
	}else if(OpdSheet &&  referral != '/' && $("#formReferral").val()==''){
		var docID =<?php echo json_encode($docId);?>;
	       $.each(docID, function(index, value) { 
		       var url="<?php echo $this->Html->url(array('controller'=>'patients','action'=>'opd_print_sheet',$this->params->query['patientId'])); ?>"+"/"+value;
		        window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200");
	       });
		}	 
	
	

if('<?php echo Configure::read('allowTimelyQuickReg')?>' == '1'){
	$('#timepicker_start').timepicker({
	    showLeadingZero: true,
	   minTime: {
	        hour: '<?php echo date('H'); ?>', minute: '<?php echo date('i')+1; ?>'//adding one to minutes to avoid current time appointment
	    },
	    maxTime: {
	    	hour: 23, minute: 0
	    },
	    showMinutes : true,
        minutes: {
            starts: 0,                  // first displayed minute
            ends: 45,                   // last displayed minute
            interval: 15 ,               // interval of displayed minutes
            manual: []                  // optional extra manual entries for minutes
        }
	});
}
	//for tariffstandard id-private
	  var pid='<?php echo $privateID;?>';
	  $('#tariff').val(pid);

var systemDateFormat = '<?php echo $this->Session->read('dateformat'); ?>';
if(systemDateFormat[0] == 'd') var formatSyntax = 'd/m/Y';
else if(systemDateFormat[0] == 'm') var formatSyntax = 'm/d/Y';
else if(systemDateFormat[0] == 'y') var formatSyntax = 'Y/m/d';
else var formatSyntax = 'd/m/y';
$('#ageMonth, #age,#ageDay').val('0');
var today = new Date();
$('#dob').val(today.format(formatSyntax));
	
	

$(document).on('click', 'setSoap', function () {
	$( "#start_date0" ).trigger( "focus" );
});

	$('#setSoap').click(function(){
		
		if($(this).is(":checked") === true)
			$('.soapArea').show();
		else
			$('.soapArea').hide();	
	});
	/*	var source = '<?php echo $isquickregsave ?>';*/
	/* if(source == '1'){
		var patientId = "<?php echo $patientId; ?>";
	/*	var doctorId = "<?php echo $doctorId; ?>";
	/*	alert('Patient Registered Successfully');
		var URL = "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "doctor_event")); ?>"+"/patientid:"+patientId+"/doctorid:"++"/listflag:appt";
		parent.window.location.href = URL;
		//parent.$.fancybox.close();
	}*/
    console.log("Initializing datepicker...");
	$("#dob").datepicker({
		showOn : "both",
		buttonImage : "../img/js_calendar/calendar.gif",
		buttonImageOnly : true,
		buttonText: "Calendar",
		changeMonth : true,
		changeYear : true,
		yearRange: "-100:+0",
		maxDate : new Date(),
		dateFormat:"yy-mm-dd",
		onSelect : function() {
			$("#dob").validationEngine("hide");   
			//calculateAge();getYearMonth();getYearMonthDay();CalculateDiff1();
			$.ajax({
				url :  "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'getAgeFromDob')); ?>",
				method : "GET",
				data : "dob="+$('#dob').val(),
				beforeSend : function(){
					//$('#busy-indicator').show();
				},
				success : function(data){
					var age = jQuery.parseJSON(data);
					$('#age').val(age[0])
					setAge();//.trigger('change');
					$('#ageMonth').val(age[1]);
					$('#ageDay').val(age[2]);
					//$('#busy-indicator').hide();
				}
			});
		}
	});

	$('#ageMonth, #age,#ageDay').keyup(function (){
		$("#ageMonth, #age,#ageDay").validationEngine('hideAll');
		if(parseInt($('#ageMonth').val()) >= 12){
			$('#ageMonth').validationEngine('showPrompt', 'Month should be less than 12.', 'text', 'topRight', true);
			return false;
		}
      if(parseInt($('#ageDay').val()) > 31){
			$('#ageDay').validationEngine('showPrompt', 'Day should be less than 31.', 'text', 'topRight', true);
			return false;
		}
      if(isNaN($(this).val()) || $(this).val() == ''){
			$(this).validationEngine('showPrompt', 'Number Only', 'text', 'topRight', true);
			return false;
		}
		var ajaxUrl = "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'getDobFromAge')); ?>";
		var data = "years="+$('#age').val()+"&months="+$('#ageMonth').val()+"&days="+$('#ageDay').val();
		$.ajax({
			url : ajaxUrl,
			method : "GET",
			data : data,
			beforeSend : function(){
				//$('#busy-indicator').show();
			},
			success : function(data){
				$('#dob').val($.trim(data));
				if($('#initials').val() == '')
					setAge()
				//$('#age').trigger('change');
				//$('#busy-indicator').hide();
			}
		});
	});
	$( ".date" ).datepicker({
		showOn: "both",
		buttonImage: "../img/js_calendar/calendar.gif",
		buttonImageOnly: true,
		buttonText: "Calendar",
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		maxDate: new Date(),
		maxTime : true,
        showTime: true,  		
		yearRange: '1950',			 
		dateFormat:"yy-mm-dd",
		onSelect : function() {
			$(".date").validationEngine("hide");   
		}
	});
	 jQuery("#PersonSearchForm").validationEngine({
           // validateNonVisibleFields: true,
            updatePromptsPosition:true,
        });
	
	$('#submit').click(function() { 
		var validatePerson = jQuery("#PersonSearchForm").validationEngine('validate');
		<?php if($this->Session->read('website.instance')=='vadodara'){ ?>				
		billAmount=parseInt($('#total').text());
		//if the bill amount is zero avoid form from submitting for vadodara instance- Pooja
		if(isNaN(billAmount)|| billAmount==0){
			alert("Please Select Visit Type With Charges.");
			validatePerson = false;

		}
		<?php } ?>
		if($('#tariff_standard_id').val() == '')
			$("#tariff_standard_txt").val('');	 

		if(parseInt($('#ageMonth').val()) >= 12){
			$('#ageMonth').validationEngine('showPrompt', 'Month should be less than 12.', 'text', 'topRight', true);
			validatePerson = false;
		}
		if(parseInt($('#ageDay').val()) > 31){
			$('#ageDay').validationEngine('showPrompt', 'Day should be less than 31.', 'text', 'topRight', true);
			validatePerson = false;
		}
	
			if(validatePerson)
				$(this).css('display', 'none');
			if(!validateCoupon)
				$('#coupon_name').val('');
			 var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][printSheet]").val("1");
		 //    $('#opd_id').attr('disabled',true);// comented because treatment type is not getting saved --yashwant 
	});
	
	$('#capturefingerprint').click(function() { 
		if($('#tariff_standard_id').val() == '')
			$("#tariff_standard_txt").val('');	 

		var validatePerson = jQuery("#PersonSearchForm").validationEngine('validate');
		if (validatePerson)
		{
			$(this).css('display', 'none');
			 var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][capturefingerprint]").val("1");
             $('#PersonSearchForm').append($(input));
		}
	});
		
	jQuery("#templatecategoryfrm").validationEngine();
	$("#Person_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","Patient_uid","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});

//department doctors by pankaj w 
	$('#department_id').change(function(){
		var val='';
		$.ajax({
	      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorByDepartmentWise", "admin" => false)); ?>"+"/"+$(this).val(),
	      context: document.body,          
	      success: function(data){ 	    	   
			 	if(data !== undefined && data !== null){
					    $("#doctor_id option").remove();
					    $('#doctor_id').append( "<option value='"+val+"'>Please Select</option>" );
						data1 = $.parseJSON(data);					
						$.each(data1, function(val, text) {
							if(val !='')
						    $('#doctor_id').append( "<option value='"+val+"'>"+text+"</option>" );
						});
				  
			  		}else{				  	
			  			$("#doctor_id option").remove();
			  			$('#doctor_id').append( "<option value='"+val+"'>Please Select</option>" );
			  		}
			  }
	      
	    });
	   });


	   /** for by default selected doctor's department-Atul**/
	   var docDefaultId='<?php echo Configure::read('default_doctor_selected')?>';
	   if(docDefaultId!=''){
	     $.ajax({
	      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+docDefaultId,
	      context: document.body,          
	      success: function(data){ 
	    	  $('#department_id').val(parseInt(data)); 
	       $('#department_id1').val(parseInt(data)); 
	       if(docDefaultId!='0')
	       $('#opd_id').attr('disabled',false);
	      }
	    });
	   }
});

$(document).on('change','#doctor_id, .doctorApp', function(){
	var selectedDoc=$(this).attr('id').split('_')[2];
	var selectedVal='';
	if(!isNaN(selectedDoc)){
		selectedVal=$('#opd_id_'+selectedDoc+' option:selected').val();
	}else{
		selectedVal=$('#opd_id option:selected').val();
	}
	if(selectedVal && !isNaN(selectedDoc)){
		resetTariff(selectedDoc);
	}else if(selectedVal){
		resetTariff(0);
	}
	if($(this).val()){
	    $.ajax({
	      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+$(this).val(),
	      context: document.body,          
	      success: function(data){
	    	  if(!isNaN(selectedDoc)){ 
		       $('#department_id_'+selectedDoc).val(parseInt(data)); 
		       $('#department_id-'+selectedDoc).val(parseInt(data)); 
		       $('#opd_id_'+selectedDoc).attr('disabled',false);
	    	  }else{
	    		  $('#department_id').val(parseInt(data)); 
			      $('#department_id1').val(parseInt(data)); 
			      $('#opd_id').attr('disabled',false);
		      }
	      }
	    });
	}else{
		if(!isNaN(selectedDoc)){		      			
			$('#department_id_'+selectedDoc).val(''); 
		    $('#department_id-'+selectedDoc).val(''); 
			$('#opd_id_'+selectedDoc).val('');
			$('#visitCharge_'+selectedDoc).text('');
			$('#visit_charge_'+selectedDoc).hide();
			$('#opd_id_'+selectedDoc).attr('disabled',true);
		}else{
			$('#department_id').val(''); 
		    $('#department_id1').val(''); 
			$('#opd_id').val('');
			$('#visit_charge').text('');
			$('#visit_charge').hide();
			$('#opd_id').attr('disabled',true);
		}
	}
   });

$('#initials').change(function(){
	$(".shows").hide();
	$("#row").show();
	//$('#first_name,#last_name').val('');
	var getInitial=$("#initials option:selected").val();
	if(getInitial=='2' || getInitial=='3' || getInitial=='6'){
		$("#sex").val('Female');
	}else if(getInitial=='1' || getInitial=='5') {
		$("#sex").val('Male');
	}else if(getInitial=='7') {
	$(".shows").show();
	$("#sex").val('');
	$("#row").hide();
	}else{
		$("#sex").val('');
	}
});

$('#sex').change(function(){
	var getSex=$("#sex option:selected").val();
	var ageValue=$('#age').val();
	var getInitial=$("#initials option:selected").val();	
	if(getSex=='Female'){
		if(ageValue=='' && getInitial=='7'){
			$("#initials").val('7');
		}else if(ageValue!='' && ageValue<=3){			
			$("#initials").val('7');
		}else if(ageValue!='' && (ageValue>3 && ageValue<=10)){			
			$("#initials").val('6');
		}else if(ageValue=='' || ageValue>=10) {			
			$("#initials").val('2');
		}
	}else if(getSex=='Male') {
		if(getInitial=='7'){
			$("#initials").val('7');
		}else if(ageValue!='' && ageValue<=3){			
			$("#initials").val('7');
		}else if(ageValue!='' && (ageValue>3 && ageValue<=10)){			
			$("#initials").val('5');
		}else if(ageValue=='' || ageValue>=10) {			
			$("#initials").val('1');
		}		
	}else{
		$("#initials").val('1');
	}
});
$('.no_number').on('change',function(){
	if($('#no_number').prop('checked')){
		//$('#phone_number').removeClass('validate[required]');
		jQuery('#phone_number').validationEngine('hide');
	}else{
		$('#phone_number').addClass('validate[required]');
	}
});

$('.no_email').on('change',function(){
	if($('#no_email').prop('checked')){
		//$('#person_email_address').removeClass('validate[required,custom[mandatory-enter]]');
		jQuery('#person_email_address').validationEngine('hide');
	}else{
		$('#person_email_address').addClass('validate[required,custom[mandatory-enter]]');
	}
});

$( document ).ready(function (){
	
	var counter = <?php echo $count?>;
	 $("#addButton").click(
				function() {
					$("#quickPatientRagistrationForm").validationEngine('detach'); 
					var newCostDiv = $(document.createElement('tr'))
					     .attr("id", 'DrugGroup' + counter);

					//var start= '<select style="width:80px;" id="start_date'+counter+'" class="" name="start_date[]"><input type="tex">';
					var str_option_value='<?php echo $str;?>';
					var route_option_value='<?php echo $str_route;?>';
					var dose_option_value='<?php echo $str_dose;?>';
					var dose_option ='<select style="width:80px;" id="dose_type'+counter+'" class="" name="dose_type[]"><option value="">Select</option>'+dose_option_value;
					var strength_option = '<select style="width:80px;" id="strength'+counter+'" class="" name="strength[]"><option value="">Select</option>'+str_option_value;
					var route_option = '<select style="width:80px;" id="route_administration'+counter+'" class="" name="route_administration[]"><option value="">Select</option>'+route_option_value;
					var frequency_option = '<select style="width:80px;" id="frequency'+counter+'" class="frequency" name="frequency[]"><option value="">Select</option><option value="as directed">as directed</option><option value="Daily">Daily</option><option value="BID">BID</option><option value="TID">TID</option><option value="QID">QID</option><option value="Q1h WA">Q1h WA</option><option value="Q2h WA">Q2h Wa</option><option value="Q4h">Q4h</option><option value="Q2h">Q2h</option><option value="Q3h">Q3h</option><option value="Q4-6h">Q4-6h</option><option value="Q6h">Q6h</option><option value="Q8h">Q8h</option><option value="Q12h">Q12h</option><option value="Q48h">Q48h</option><option value="Q72h">Q72h</option><option value="Nightly">Nightly</option><option value="QHS">QHS</option><option value="in A.M.">in A.M.</option><option value="Every Other Day">Every Other Day</option><option value="2 Times Weekly">2 Times Weekly</option><option value="3 Times Weekly">3 Times Weekly</option><option value="Q1wk">Q1wk</option><option value="Q2wks">Q2wks</option><option value="Q3wks">Q3wks</option><option value="Once a Month">Once a Month</option><option value="Add\'l Sig">Add\'l Sig</option></select>';
					var refills_option = '<select style="width:80px;" id="refills'+counter+'" class="" name="refills[]"><option value="">Select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
					var prn_option = '<select style="width:80px;" id="prn'+counter+'" class="" name="prn[]"><option value="">Select</option><option value="0">No</option><option value="1">Yes</option></select>';
					var daw_option = '<select style="width:80px;" id="daw'+counter+'" class="" name="daw[]"><option value="">Select</option><option value="0">No</option><option value="1">Yes</option></select>';
					var active_option = '<select style="width:80px;" id="isactive'+counter+'" class="" name="isactive[]"><option value="">Select</option><option value="0">No</option><option value="1">Yes</option></select>';
					//var route_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
					var options = '<option value=""></option>';
					for (var i = 1; i < 25; i++) {
						if (i < 13) {
							str = i + 'am';
						} else {
							str = (i - 12) + 'pm';
						}
						options += '<option value="'+i+'"'+'>'
								+ str + '</option>';
					}

					timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timer = timerHtml1 + timerHtml2
							+ timerHtml3 + timerHtml4
							+ '</tr></table></td>';
					<?php //echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date','name'=> 'start_date[]', 'id' =>"start_date".$i ,'counter'=>$i )); ?>
					var newHTml = '<td valign="top"><input  type="text" style="width:100px" value="" id="drugText_' + counter + '"  class=" drugText validate[optional,custom[onlyLetterNumber]]" name="drugText[]" autocomplete="off" counter='+counter+'>'+
							'<input  type="hidden"  id="drug_' + counter + '"  name="drug_id[]" ></td><td valign="top">'
							+ dose_option
							+ '</td><td valign="top">'
							+ strength_option
							+ '</td><td valign="top">'
							+ route_option
							+ '</td><td valign="top">'
							+ frequency_option
							+ '</td>'
							+ '<td valign="top"><input size="2" type="text" value="" id="day'+counter+'" class="" name="day[]"></td>'
							+ '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'" class="" name="quantity[]"></td>'
							+ '<td valign="top">'
							+ refills_option
							+ '</td>'
							+ '<td valign="top" align="center">'
							+ prn_option
							+ '</td>'
							+ '<td valign="top" align="center">'
							+ daw_option
							+ '</td>'
							+ '<td valign="top" align="center"><input type="text" style="width:130px" value="" id="start_date' + counter + '"  class="my_start_date1 textBoxExpnd" name="start_date[]"  size="15" counter='+counter+'></td>'
							+ '<td valign="top" align="center"><input type="text" style="width:130px" value="" id="end_date' + counter + '"  class="my_end_date1 textBoxExpnd" name="end_date[]"  size="15" counter='+counter+'></td>'
							+ '<td valign="top" align="center"><textarea id="special_instruction' + counter + '"  name="special_instruction[]" "style"="width:150px"  size="16" counter='+counter+'></textarea></td>'
							+ '<td valign="top" align="center">'
							+ active_option
							+ '</td>'
							;
																						
					newCostDiv.append(newHTml);		 
					newCostDiv.appendTo("#DrugGroup");		
					$("#diagnosisfrm").validationEngine('attach'); 			 			 
					counter++;
					if(counter > 0) $('#removeButton').show('slow');

					$(".my_start_date1").live("focus",function() {

						$(this).datepicker({
									changeMonth : true,
									changeYear : true,
									yearRange : '1950',
									minDate : new Date(explode[0], explode[1] - 1,
											explode[2]),
											dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
									showOn : 'both',
									buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonText: "Calendar",
									buttonImageOnly : true,
									onSelect : function() {
										$(this).focus();
									}
								});
			});
			var explode = admissionDate.split('-');
			$(".my_end_date1").live("focus",function() {
				
						$(this).datepicker({
									changeMonth : true,
									changeYear : true,
									yearRange : '1950',
									minDate : new Date(explode[0], explode[1] - 1,
											explode[2]),
											dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
									showOn : 'both',
									buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
												buttonImageOnly : true,
												buttonText: "Calendar",
												onSelect : function() {
													$(this).focus();
												}
											});
						});

					//For live click
					
		$('.drugText').on('focus',function() {
			var currentId=	$(this).attr('id').split("_"); // Important
			var attrId = this.id;
			var counter = $(this).attr(
					"counter");
			if ($(this).val() == "") {
				$("#Pack" + counter).val("");
			}
			$(this).autocomplete( "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','Status=A',"admin" => false,"plugin"=>false)); ?>",
							{
								
								width : 250,
								selectFirst : true,
								valueSelected:true,
								minLength: 3,
								delay: 1000,
								isOrderSet:true,
								showNoId:true,
								loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'dose_type')
								+','+$(this).attr('id').replace("drugText_",'strength')
									+','+$(this).attr('id').replace("drugText_",'route_administration'),
									
								onItemSelect:function(event, ui) {
									//lastSelectedOrderSetItem
									var compositStringArray = lastSelectedOrderSetItem.split("    ");
									if((compositStringArray[1] !== undefined) && (compositStringArray[1] != '')){
										var pharmacyIdArray = compositStringArray[1].split("|");
										var doseId = attrId.replace("drugText_",'dose_type');
										var routeId = attrId.replace("drugText_",'route_administration');
										var strengthId = attrId.replace("drugText_",'strength');
										$("#drug_"+currentId[1]).val(pharmacyIdArray[0]);
										
										$("#"+strengthId).val(pharmacyIdArray[2]);
										if($("#"+strengthId).val() == ''){
											$("#"+strengthId).append( new Option(pharmacyIdArray[2],pharmacyIdArray[2]) );
											if(pharmacyIdArray[2]!='')
											$("#"+strengthId).val(pharmacyIdArray[2]);
												else
													$("#"+strengthId).val("Select");
											$.ajax({

												  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration", "admin" => false)); ?>",
												  context: document.body,	
												  beforeSend:function(){
												    // this is where we append a loading image
												    $('#busy-indicator').show('fast');
													}, 	
													type: "POST",  
												  	data:{putArea:pharmacyIdArray[2],searchArea:'strength'},		  
												  	success: function(data){
															$('#busy-indicator').hide('slow');
												  			
												  	}				  			
												});
										}
										$("#"+routeId).val(pharmacyIdArray[3]);
										if($("#"+routeId).val() == ''){
											$("#"+routeId).append( new Option(pharmacyIdArray[3],pharmacyIdArray[3]) );
											if(pharmacyIdArray[3]!='')
											$("#"+routeId).val(pharmacyIdArray[3]);
												else
													$("#"+routeId).val('Select');
											$.ajax({

												  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration1", "admin" => false)); ?>",
												  context: document.body,	
												  beforeSend:function(){
												    // this is where we append a loading image
												    $('#busy-indicator').show('fast');
													}, 	
													type: "POST",  
												  	data:{putArea:pharmacyIdArray[3],searchArea:'route'},		  
												  	success: function(data){
															$('#busy-indicator').hide('slow');
												  			
												  	}				  			
												});
										}
										$("#"+doseId).val(pharmacyIdArray[1]);
										if($("#"+doseId).val() == ''){
											$("#"+doseId).append( new Option(pharmacyIdArray[1],pharmacyIdArray[1]) );
											
											if(pharmacyIdArray[1]!='')
												$("#"+doseId).val(pharmacyIdArray[1]);
											else
												$("#"+doseId).val('Select');
								
											$.ajax({

												  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration2", "admin" => false)); ?>",
												  context: document.body,	
												  beforeSend:function(){
												    // this is where we append a loading image
												    $('#busy-indicator').show('fast');
													}, 	
													type: "POST",  
												  	data:{putArea:pharmacyIdArray[1],searchArea:'dose'},		  
												  	success: function(data){
															$('#busy-indicator').hide('slow');
												  			
												  	}				  			
												});
										}
										
										
									}
								}
								
							});
			
		});  //EOF autocomplete


					//var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
					//var explode = admissionDate.split('-');
					$(".my_end_date1").on("click",function() {
						
								$(this).datepicker({
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',
											/*minDate : new Date(explode[0], explode[1] - 1,
													explode[2]),*/
											dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
											showOn : 'button',
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
														buttonImageOnly : true,
														onSelect : function() {
															$(this).focus();
														}
													});
								});
					
			     });

	 $("#removeButton").click(function () {
			counter--;	
	 	$("#DrugGroup" + counter).remove();
	 		if(counter == 0) $('#removeButton').hide('slow');
	  });

	 $('.drugText').on('focus',function() {
					var currentId=	$(this).attr('id').split("_"); // Important
					var attrId = this.id;
					var counter = $(this).attr("counter");
					if ($(this).val() == "") {
						$("#Pack" + counter).val("");
					}
					$(this).autocomplete( "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','Status=A',"admin" => false,"plugin"=>false)); ?>",
									{
										
							width : 250,
							selectFirst : true,
							valueSelected:true,
							minLength: 3,
							delay: 1000,
							isOrderSet:true,
							showNoId:true,
							loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'dose_type')
							+','+$(this).attr('id').replace("drugText_",'strength')
								+','+$(this).attr('id').replace("drugText_",'route_administration'),
								
							onItemSelect:function(event, ui) {
								//lastSelectedOrderSetItem
								var compositStringArray = lastSelectedOrderSetItem.split("    ");
								if((compositStringArray[1] !== undefined) && (compositStringArray[1] != '')){
									var pharmacyIdArray = compositStringArray[1].split("|");
									var doseId = attrId.replace("drugText_",'dose_type');
									var routeId = attrId.replace("drugText_",'route_administration');
									var strengthId = attrId.replace("drugText_",'strength');
									$("#drug_"+currentId[1]).val(pharmacyIdArray[0]);
									
									$("#"+strengthId).val(pharmacyIdArray[2]);
									if($("#"+strengthId).val() == ''){
										$("#"+strengthId).append( new Option(pharmacyIdArray[2],pharmacyIdArray[2]) );
										if(pharmacyIdArray[2]!='')
										$("#"+strengthId).val(pharmacyIdArray[2]);
											else
												$("#"+strengthId).val("Select");
										$.ajax({

											  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration", "admin" => false)); ?>",
											  context: document.body,	
											  beforeSend:function(){
											    // this is where we append a loading image
											    $('#busy-indicator').show('fast');
												}, 	
												type: "POST",  
											  	data:{putArea:pharmacyIdArray[2],searchArea:'strength'},		  
											  	success: function(data){
														$('#busy-indicator').hide('slow');
											  			
											  	}				  			
											});
									}
									$("#"+routeId).val(pharmacyIdArray[3]);
									if($("#"+routeId).val() == ''){
										$("#"+routeId).append( new Option(pharmacyIdArray[3],pharmacyIdArray[3]) );
										if(pharmacyIdArray[3]!='')
										$("#"+routeId).val(pharmacyIdArray[3]);
											else
												$("#"+routeId).val('Select');
										$.ajax({

											  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration1", "admin" => false)); ?>",
											  context: document.body,	
											  beforeSend:function(){
											    // this is where we append a loading image
											    $('#busy-indicator').show('fast');
												}, 	
												type: "POST",  
											  	data:{putArea:pharmacyIdArray[3],searchArea:'route'},		  
											  	success: function(data){
														$('#busy-indicator').hide('slow');
											  			
											  	}				  			
											});
									}
									$("#"+doseId).val(pharmacyIdArray[1]);
									if($("#"+doseId).val() == ''){
										$("#"+doseId).append( new Option(pharmacyIdArray[1],pharmacyIdArray[1]) );
										
										if(pharmacyIdArray[1]!='')
											$("#"+doseId).val(pharmacyIdArray[1]);
										else
											$("#"+doseId).val('Select');
							
										$.ajax({

											  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration2", "admin" => false)); ?>",
											  context: document.body,	
											  beforeSend:function(){
											    // this is where we append a loading image
											    $('#busy-indicator').show('fast');
												}, 	
												type: "POST",  
											  	data:{putArea:pharmacyIdArray[1],searchArea:'dose'},		  
											  	success: function(data){
														$('#busy-indicator').hide('slow');
											  			
											  	}				  			
											});
									}
								}
							}
							
						});

				});

	// var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
		//var explode = admissionDate.split('-');
		$(".my_start_date1").on("click",function() {

					$(this).datepicker({
								changeMonth : true,
								changeYear : true,
								yearRange : '1950',
								/*minDate : new Date(explode[0], explode[1] - 1,
										explode[2]),*/
								dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
								showOn : 'button',
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
								buttonImageOnly : true,
								onSelect : function() {
									$(this).focus();
								}
							});
		});

		//var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
		//var explode = admissionDate.split('-');
		$(".my_end_date1").on("click",function() {
			
					$(this).datepicker({
								changeMonth : true,
								changeYear : true,
								yearRange : '1950',
								/*minDate : new Date(explode[0], explode[1] - 1,
										explode[2]),*/
								dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
								showOn : 'button',
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											onSelect : function() {
												$(this).focus();
											}
										});
					});
		$("#tariff_standard_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","TariffStandard",'id',"name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'tariff_standard_txt,tariff_standard_id',
		
		});
		$('#tariff_standard_txt').keydown(function(){
			$("#tariff_standard_id").val('');	 
		}); 

		 $("#treatment_type_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete", "TariffList","id","name","check_status=1","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'treatment_type_txt,treatment_type'
		}); 
}); 

// for aadhar card we use id ssn 
$("#ssn1").focusout(function(){ 
	res=$("#ssn1").val();
	count=($("#ssn1").val()).length;
	str1=res.substring(0, 4);
	str2=res.substring(4, 8);
	str3=res.substring(8, 12);
	if(count=='12'){
		$("#ssn1").val(str1+'-'+str2+'-'+str3);
	}
	if(count=='0'){
		$('#ssn1').val("");
	}
});

//---------------------------------BOF Atul, for 1st letter uppercase-----------------------------

$('#first_name,#last_name').css('textTransform', 'capitalize'); 

		$('#stateName').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","State","id","name",'null')); ?>", {
			   width: 250,
				selectFirst: true,
				valueSelected:true,
				showNoId:true,
			loadId : 'state,stateId',
		});
		$(document).on('focus','#city', function() {
		//$('#city').live('focus',function() { 
		 var getStateId=$('#stateId').val();
		 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","City","id","name")); ?>"+'/'+'state_id='+getStateId,{
				width: 250,
				selectFirst: true,
				valueSelected:true,
	    		showNoId:true,
	    		loadId : 'city,cityId',
			});
		});
		// $( document ).ready(function() {
		//	 var zipData = $(this).val();
			 
			// });
		$("#pinCode").blur(function(){
			
		var zipData = $(this).val(); //alert(zipData);
		var zipCount =	( $(this).val().length); //alert(zipCount);
		if(zipCount == 6){
			
			$.ajax({
	        	url: "<?php echo $this->Html->url(array("controller" => 'Persons', "action" => "getStateCity")); ?>"+"/"+zipData,
	        	context: document.body,
	        	
				success: function(data){
					if(data !== undefined && data !== null){
						data1 = jQuery.parseJSON(data);
						//console.log(data1.zip);
						
						if(data1.zip['State']['id']){
							$('#stateId').val(data1.zip['State']['id']);
							$('#stateName').val(data1.zip['State']['name']);
							$('#city').val(data1.zip['PinCode']['city_name']);
						}
					 }	
				} 
	        });
		} else{
			$('#stateId').val("");
			$('#stateName').val("");
			$('#city').val("");
			}
				
		});

		$(document).ready(function(){
			//BOF web cam script
			 $('#camera').click(function(){
				$.fancybox(
					    {
					    	'autoDimensions':false,
					    	'width'    : '85%',
						    'height'   : '90%',
						    'autoScale': true,
						    'transitionIn': 'fade',
						    'transitionOut': 'fade',						    
						    'type': 'iframe',
						    'href': '<?php echo $this->Html->url(array( "action" => "webcam")); ?>'
				});
			});			
		   //EOF web cam script
		});
		$(document).on('change','#opd_id ,.visitApp',function(){
			var selectedDoc=$(this).attr('id').split('_')[2];
			var selectedVal='';var visitType='';var doctor_id='';			
			if(!isNaN(selectedDoc)){
				selectedVal=$('#opd_id_'+selectedDoc+' option:selected').val();
			}else{
				selectedVal=$('#opd_id option:selected').val();
			}
			if(!isNaN(selectedDoc)){
				$('#visit_charge_'+selectedDoc).text('');
				$('#visit_input_'+selectedDoc).val('');
				$('#visit_charge_'+selectedDoc).hide();
				$('#visit_input_'+selectedDoc).hide();				
				calTotal();
			}else{
				$('#visit_charge').text('');
				$('#visit_input').val('');
				$('#visit_charge').hide();
				$('#visit_input').hide();	
				calTotal();			
			}
			if(!isNaN(selectedDoc)){
				visitType=$('#opd_id_'+selectedDoc).val();
				doctor_id=$('#doctor_id_'+selectedDoc).val();
			}else{
				visitType=$('#opd_id').val();
				doctor_id=$('#doctor_id').val();
			}
			var tarifId=$('#tariff').val();
			var privateTarif="<?php echo $privateID?>";
			if(tarifId!=privateTarif)
				$('#pay_charge').attr('checked',false);
			<?php if($this->Session->read('website.instance')=='vadodara' ){?>
			$('#submit').hide();
			if(selectedVal){
			$.ajax({
	        	url: "<?php echo $this->Html->url(array("controller" => 'Persons', "action" => "getTariffAmount")); ?>"+"/"+visitType+"/"+doctor_id+"/"+tarifId,
	        	context: document.body,	        	
				success: function(data){
					if(data !== undefined && data !== null){
						data1 = jQuery.parseJSON(data);
						if(data1.charges!=false){
							if( typeof(data1.charges.TariffCharge)!='undefined' && data1.charges!=false ){
								if(typeof(data1.charges['TariffCharge']['id'])!='undefined'){
									if(data1.charges['TariffCharge']['nabh_charges']){
										if(!isNaN(selectedDoc)){
											$('#visit_charge_'+selectedDoc).show();
											$('#visit_input_'+selectedDoc).show();
											$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffCharge']['nabh_charges']);
											$('#visit_input_'+selectedDoc).val(data1.charges['TariffCharge']['nabh_charges']);
											calTotal();
										}else{
											$('#visit_charge').show();
											$('#visit_input').show();
											$('#visit_charge').text($('#opd_id option:selected').text()+' :'+data1.charges['TariffCharge']['nabh_charges']);
											$('#visit_input').val(data1.charges['TariffCharge']['nabh_charges']);
											calTotal();

										}
										
									}else if(data1.charges['TariffCharge']['non_nabh_charges']){
										if(!isNaN(selectedDoc)){
											$('#visit_charge_'+selectedDoc).show();
											$('#visit_input_'+selectedDoc).show();
											$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffCharge']['non_nabh_charges']);
											$('#visit_input_'+selectedDoc).val(data1.charges['TariffCharge']['non_nabh_charges']);
											calTotal();
										}else{
											$('#visit_charge').show();
											$('#visit_input').show();
											$('#visit_charge').text($('#opd_id option:selected').text()+' :'+data1.charges['TariffCharge']['non_nabh_charges']);
										    $('#visit_input').val(data1.charges['TariffCharge']['non_nabh_charges']);
										    calTotal();
										}
									}
									$('#location_id').val(data1.charges['User']['location_id']);
								}						
							}else if( typeof(data1.charges.TariffAmount)!='undefined' && data1.charges!=false ){
									if(data1.charges['TariffAmount']['id']){
									if(data1.charges['TariffAmount']['nabh_charges']){
										if(!isNaN(selectedDoc)){
											$('#visit_charge_'+selectedDoc).show();
											$('#visit_input_'+selectedDoc).show();
											$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffAmount']['nabh_charges']);
											$('#visit_input_'+selectedDoc).val(data1.charges['TariffAmount']['nabh_charges']);
											calTotal();
										}else{
											$('#visit_charge').show();
											$('#visit_input').show();
											$('#visit_charge').text($('#opd_id option:selected').text()+' :'+data1.charges['TariffAmount']['nabh_charges']);
											$('#visit_input').val(data1.charges['TariffAmount']['nabh_charges']);
											calTotal();

										}
									}else if(data1.charges['TariffAmount']['non_nabh_charges']){
										if(!isNaN(selectedDoc)){
											$('#visit_charge_'+selectedDoc).show();
											$('#visit_input_'+selectedDoc).show();
											$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffAmount']['non_nabh_charges']);
											$('#visit_input_'+selectedDoc).val(data1.charges['TariffAmount']['non_nabh_charges']);
											calTotal();
										}else{
											$('#visit_charge').show();
											$('#visit_input').show();
											$('#visit_charge').text($('#opd_id option:selected').text()+' :'+data1.charges['TariffAmount']['non_nabh_charges']);
										    $('#visit_input').val(data1.charges['TariffAmount']['non_nabh_charges']);
										    calTotal();
										}
									}
								}
							}
						}else{
							$('#visit_charge').hide();
							$('#visit_input').hide();
							$('#visit_charge').text('');
						    $('#visit_input').val('');
						    $(this).val('');
							alert('Charges for selcted service is not mapped for Selected Doctor. Please Select other service or map charges');
							$('#pay_charge').attr('checked',false);
						 }
						
					 }
					$('#submit').show();
				} 
	        });
			}
	        <?php }?>
			
		});		
		function setAge(){	
			var ageValue=$('#age').val();
			var getSex=$("#sex").val();	
			if(ageValue <=3){
	        	if(getSex=='Male'){
					$("#initials").val('7');
				}else if(getSex=='Female'){
					$("#initials").val('7');
				}else{
					$("#initials").val('7');
	            }
	        }else if(ageValue<=10){
				if(getSex=='Male'){
					$("#initials").val('5');
				}else if(getSex=='Female'){
					$("#initials").val('6');
				}else{
					$("#initials").val('5');
				}
			}else{
				if(getSex=='Male'){
					$("#initials").val('1');
				}else if(getSex=='Female'){
					$("#initials").val('2');
				}else{
					$("#initials").val('');
				}
				
			}	
		}

		$('#tariff').change(function(){
			var tarifId=$('#tariff').val();
			var privateTarif="<?php echo $privateID?>";
			if(tarifId!=privateTarif){
				$('#pay_charge').attr('checked',false);
			}else{
				$('#pay_charge').prop('checked',true);
			}
				resetAllTariff();				
		});

		//For resetting the charges on change of doctor or tariff - Vadodara
		function resetTariff(args){
			if(args=='0'){
				$('#opd_id').val('');
				$('#visit_charge').hide();
				$('#visit_input').hide();
				$('#visit_charge').text('');
			    $('#visit_input').val('');
			    calTotal();
			}else{
				$('#opd_id_'+args).val('');
				$('#visit_charge_'+args).hide();
				$('#visit_input_'+args).hide();
				$('#visit_charge_'+args).text('');
			    $('#visit_input_'+args).val('');
			    calTotal();
			}

		}


		//For resetting All the charges on change of doctor or tariff - Vadodara
		function resetAllTariff(){
			for(var i=0;i<=counterApp;i++){
				if(i=='0'){
					$('#opd_id').val('');
					$('#visit_charge').hide();
					$('#visit_input').hide();
					$('#visit_charge').text('');
				    $('#visit_input').val('');
				    calTotal();
				}else{
					$('#opd_id_'+i).val('');
					$('#visit_charge_'+i).hide();
					$('#visit_input_'+i).hide();
					$('#visit_charge_'+i).text('');
				    $('#visit_input_'+i).val('');
				    calTotal();
				}

			}

		}
		

		var counterApp='<?php echo $countApp+1;?>';
		function addFields(){
			var appendOption= "<option value=''>Please Select</option>";
			$("#multiAppTable")
			.append($('<tr>').attr({'id':'multiRow_'+counterApp})
				.append($('<td>').append($('<select>').attr({'id':'doctor_id_'+counterApp,'class':'textBoxExpnd validate[required,custom[mandatory-select]] doctorApp','type':'select','name':'Appointment[doctor_id][]'}).append(appendOption)))
				.append($('<td>').append($('<select>').attr({'id':'department_id_'+counterApp,'disabled':'disabled','class':'textBoxExpnd department_id','type':'select','name':'Appointment[department_id][]'}).append(appendOption)))
				.append($('<input>').attr({'type':'hidden','id':'department_id-'+counterApp,'class':'textBoxExpnd validate[required,custom[mandatory-enter]]','name':'Appointment[department_id][]'}))
	    		.append($('<td>').append($('<select>').attr({'id':'opd_id_'+counterApp,'disabled':'disabled','class':'textBoxExpnd validate[required,custom[mandatory-select]] visitApp','type':'select','name':'Appointment[treatment_type][]'}).append(appendOption)))
				//.append($('<input>').attr({'type':'hidden','id':'opd_val_'+counterApp,'name':'Appointment[treatment_type][]'}))
				.append($('<td>').append($('<font>').attr({'size':"3px" , 'color':"#F48F5B" , 'style':"font-weight: bold;"}).append($('<span>').attr({'id':'visit_charge_'+counterApp})).append($('<input>').attr({'type':'hidden','id':'visit_input_'+counterApp,'name':'Appointment[visit_charge][]'}))))
				.append($('</span></font></td>'))
				.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
						.attr({'class':'removeButton','id':'removeButton_'+counterApp,'title':'Remove current row'}).css('float','right')))
				.append($('</tr>'))
				);
			
			var doctorList = <?php echo json_encode($doctorlist);?>;
			$.each(doctorList, function(val, text) {
			    $('#doctor_id_'+counterApp).append( "<option value='"+val+"'>"+text+"</option>" );
			});

			var departmentList=<?php echo json_encode($departments);?>;
			$.each(departmentList, function(val, text) {
			    $('#department_id_'+counterApp).append( "<option value='"+val+"'>"+text+"</option>" );
			});

			var visitList=<?php echo json_encode($opdoptions);?>;
			$.each(visitList, function(val, text) {
			    $('#opd_id_'+counterApp).append( "<option value='"+val+"'>"+text+"</option>" );
			});  
			counterApp++;
		}

		$(document).on('click','.removeButton', function() {
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("#multiRow_"+ID).remove();	
			counterApp--;
			calTotal();
		});

		$('#no_email').click(function(){
		    if($( "#no_email" ).is(':checked') == true) {
		       $('#person_email_address').attr('disabled', 'disabled');
		       $( "#person_email_address" ).val("");
		    }else{ 
			   $('#person_email_address').removeAttr('disabled', 'disabled');        
		    }   
		});
		$('#no_number').click(function(){
		   if($( "#no_number" ).is(':checked') == true) {
		       $('#phone_number').attr('disabled', 'disabled');
		       $( "#phone_number" ).val("");
		    }else{ 
			   $('#phone_number').removeAttr('disabled', 'disabled');        
		    }   
		}); 

		function calTotal(){
			var total=0;
				for(var i=0;i<=counterApp;i++){
					if(i=='0'){
						vamt=parseInt($('#visit_input').val());
						if(isNaN(vamt))
							vamt=0;
						total=parseInt(total)+parseInt(vamt);
					}else{
						camt=parseInt($('#visit_input_'+i).val());
						if(isNaN(camt))
							camt=0;
						total=parseInt(total)+parseInt(camt);
					}
				}

				$('#total').text(total);
				$('#totAmt').val(total);
			}

     $('#isStaff').click(function(){			
        if($("#isStaff").is(':checked')){	
            $("#notStaff").hide();
            $("#staff").show();
            $("#staffName").focus();
            $("#initials").val('');
            $("#first_name").val('');
            $("#last_name").val('');
        }else{
            $("#notStaff").show();
            $("#staff").hide();
            $("#staffName").val('');
        }
    });

  
	$('#staffName').autocomplete("<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "staffAutocomplete","admin" => false,"plugin"=>false)); ?>", {
			   width: 250,
				selectFirst: true,
				valueSelected:true,
				showNoId:true,
			    loadId : 'staffName',
		})
</script>



<!--poonam-->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const blocks = document.querySelectorAll(".input-block");
    const finalButtons = document.getElementById("final-buttons");
    let currentIndex = 0;

    // Function to update visibility of blocks and buttons
    function updateBlocks() {
        blocks.forEach((block, index) => {
            block.style.display = index === currentIndex ? "block" : "none";
        });

        // Show final buttons only for specific indices
        if (currentIndex === 17 || currentIndex === 37) {
            finalButtons.style.display = "block";
        } else {
            finalButtons.style.display = "none";
        }
    }

    // Navigate forward without validation
    window.navigateDown = function () {
        if (currentIndex < blocks.length - 1) {
            currentIndex++;
            updateBlocks();
        }
    };

    // Navigate backward
    window.navigateUp = function () {
        if (currentIndex > 0) {
            currentIndex--;
            updateBlocks();
        }
    };

    // Save and navigate to the next block
    window.saveAndNext = function () {
        const currentBlock = blocks[currentIndex];

        // Skip validation if the block has the "data-skip-validation" attribute
        if (currentBlock.hasAttribute("data-skip-validation")) {
            console.log("Skipping validation for block:", currentBlock.id || currentIndex);
            navigateDown();
            return;
        }

        // Regular validation for other blocks
        const allFieldsFilled = [...currentBlock.querySelectorAll("input, select")].some(field => {
            if (field.type === "radio") {
                const radios = currentBlock.querySelectorAll(`input[name="${field.name}"]`);
                return [...radios].some(radio => radio.checked);
            } else {
                return field.value.trim() !== "";
            }
        });

        if (!allFieldsFilled) {
            alert("Please select an option before proceeding.");
            return;
        }

        navigateDown();
    };

    // Auto-navigation for radio buttons
    document.querySelectorAll(".input-block").forEach(container => {
        container.addEventListener("change", function (e) {
            if (e.target.type === "radio") {
                window.navigateDown();
            }
        });
    });

    // Auto-navigation for input fields (on Enter key)
    document.querySelectorAll("input").forEach(input => {
        input.addEventListener("keypress", function (e) {
            if (e.key === "Enter" && e.target.value.trim() !== "") {
                window.navigateDown();
            }
        });
    });

    // Initialize by showing the first block
    updateBlocks();
});



</script>

<script>
    // Event Listeners for Back and Forward Buttons
$('.btn-arrow').click(function () {
    const currentBlock = $(this).closest('.input-block');
    const isForward = $(this).hasClass('forward-btn');
    const targetBlock = isForward ? currentBlock.next('.input-block') : currentBlock.prev('.input-block');

    if (isForward) {
        currentBlock.removeClass('active').addClass('done');
        if (targetBlock.length) {
            targetBlock.addClass('active slide-in');
            rescroll(targetBlock);
        }
    } else {
        currentBlock.removeClass('active');
        if (targetBlock.length) {
            targetBlock.removeClass('done').addClass('active');
            rescroll(targetBlock);
        }
    }
});

// Save & Next Button Interaction
$('.btn-save-next').click(function () {
    const currentBlock = $(this).closest('.input-block');
    const nextBlock = currentBlock.next('.input-block');

    currentBlock.removeClass('active').addClass('done');
    if (nextBlock.length) {
        nextBlock.addClass('active slide-in');
        rescroll(nextBlock);
    }
});

// Scroll Detection and Active Block Management
$(window).on('scroll', function () {
    $('.input-block').each(function () {
        const blockTop = $(this).offset().top;
        const scrollPos = $(window).scrollTop();

        if (scrollPos >= blockTop - $(window).height() / 2 && scrollPos < blockTop + $(this).outerHeight()) {
            $(this).addClass('active').removeClass('slide-in');
        } else {
            $(this).removeClass('active');
        }
    });
});

// Radio Button Auto-navigation
document.querySelectorAll('.input-block').forEach(container => {
    container.addEventListener('change', function (e) {
        if (e.target.type === 'radio') {
            const nextBlock = $(this).next('.input-block');
            if (nextBlock.length) {
                moveNext(nextBlock);
            }
        }
    });
});

// Smooth Scroll Function
function rescroll(element) {
    $('html, body').animate({
        scrollTop: element.offset().top
    }, 600);
}

// Move to Next Block
function moveNext(element) {
    element.addClass('active slide-in');
    rescroll(element);
}

</script>

<script> 
    function toggleOtherInput(selectedValue, targetDivId, inputFieldId) {
    console.log("Selected Value:", selectedValue); // Debugging ke liye
    const targetDiv = document.getElementById(targetDivId);
    const inputField = document.getElementById(inputFieldId);

    if (selectedValue === 'Other' || selectedValue === 'Other (Specify)') {
        targetDiv.style.display = 'block'; // Textbox dikhaye
        inputField.focus(); // Focus kare textbox par
    } else {
        targetDiv.style.display = 'none'; // Textbox chhupaye
        inputField.value = ''; // Clear kare value
    }
}


</script>



























