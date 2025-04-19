<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 800px; /* Increased max-width for better desktop view */
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
            flex: 1; /* Ensure form-group takes equal space */
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        label {
            font-weight: bold;
            font-size: 16px;
            color: #444;
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #fafafa;
            margin-bottom: 10px;
        }
        input[type="date"] {
            padding: 10px;
        }
        button {
            width: 100%;
            padding: 14px;
            background-color: #d15252;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #b13d3d;
        }
        @media screen and (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
            button {
                padding: 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>First Aid Training Form</h2>
    <?php echo $this->Form->create('FirstAidCertificate', array('url' => array('controller' => 'persons', 'action' => 'certificate_form'), 'method' => 'post')); ?>

    <div class="form-row">
        <div class="form-group">
            <?php echo $this->Form->input('candidateName', array('label' => 'Candidate Name:', 'placeholder'=>'Full Name','required' => true, 'style' => 'text-transform: capitalize;')); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('relation', array(
                'label' => 'Relation:',
                'type' => 'select',
                'options' => array('Son' => 'Son', 'Daughter' => 'Daughter', 'Wife' => 'Wife'),
                'empty' => 'Select Relation',
                'required' => true
            )); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $this->Form->input('guardianName', array('label' => 'Guardian Name:','placeholder'=>'Guardian Full Name', 'required' => true, 'style' => 'text-transform: capitalize;')); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('center', array(
                'label' => 'Training Center Place:',
                'type' => 'select',
                'options' => array(
                    'Nagpur' => 'Nagpur',
                    'Gadchiroli' => 'Gadchiroli',
                    'Shivni' => 'Shivni',
                    'Jabalpur' => 'Jabalpur',
                    'Gondia' => 'Gondia',
                    'Baitul' => 'Baitul'
                ),
                'empty' => 'Select Training Center',
                'required' => true
            )); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $this->Form->input('examDate', array('label' => 'Date of Examination:', 'type' => 'date', 'required' => true, 'style' => 'display: inline-block; width: auto;')); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('mobile', array(
                'label' => 'Mobile No.', 
                'type' => 'text', 
                'required' => true, 
                'maxlength' => 10, 
                'pattern' => '[0-9]{10}', 
                'title' => 'Please enter exactly 10 digits'
            )); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $this->Form->input('place', array('label' => 'Place:', 'placeholder'=>'Compony / Institute Name','required' => true,  'style' => 'text-transform: capitalize;')); ?>
        </div>
    </div>

    <button type="submit">Generate Certificate</button>

    <?php echo $this->Form->end(); ?>
</div>

</body>
</html>
