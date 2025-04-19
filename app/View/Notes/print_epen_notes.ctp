<style>
/* Main table styling */
table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    margin-top: 15px;
}

/* Table header styling */
th {
    text-align: right;
    padding: 10px;
    font-size: 14px;
}

/* General table cell styling */
td {
    padding: 8px;
    vertical-align: middle;
    border: 1px solid #000;
}

/* Left column labels */
td.label {
    font-weight: bold;
    text-align: left;
    width: 25%;
}

/* Right column labels */
td.right-label {
    font-weight: bold;
    text-align: left;
    width: 25%;
}

/* Left and right values */
td.value {
    text-align: left;
    width: 25%;
}

/* Ensures the date aligns to the right */
.date-header {
    text-align: right;
    font-size: 14px;
    font-weight: bold;
    padding: 10px;
}

/* Optional: Add spacing below the table */
.table-container {
    margin-bottom: 15px;
}


/* Apply to the unordered list (ul) under #printSection */
        #printSection ul {
            list-style-type: disc; /* Ensure bullet points are shown */
            padding-left: 20px; /* Proper indentation */
        }

        /* Apply to list items (li) under #printSection */
        #printSection li {
            font-weight: normal !important; /* Force normal text */
            font-style: normal; /* Remove any italic styles */
        }

        /* Apply to h3 elements */
        .h3 {
            margin-bottom: 12px;
        }
        
      .epen-content {
    font-family: Arial, sans-serif !important;
    font-size: 14px !important;
    text-align: justify !important;
    line-height: 1.8 !important; /* Increase line spacing */
    padding: 10px !important; /* Add padding */
    background-color: #f9f9f9 !important; /* Light grey background */
    border-radius: 5px !important; /* Rounded corners */
    border: 1px solid #ddd !important; /* Light border */
    white-space: pre-wrap !important; /* Preserve line breaks */
}





</style>

<link rel="stylesheet" href="style.css">



<h3 style="    text-align: center;font-size:24px;">OPD   SUMMARY</h3>


<div style="float:right;" id="printButton">
    <?php echo $this->Html->link('Print', '#', array('onclick' => 'window.print();', 'class' => 'blueBtn', 'escape' => false)); ?>
</div>
<table border="1" cellspacing="0" cellpadding="5" style="width:100%; border-collapse: collapse;margin-bottom: 12px;">
   
      <div style="text-align:right;margin-bottom: 12px;">
            Date: <?php echo date('d/m/Y'); ?>
</div>
        
    
    
    <tr>
        <!-- Left Column -->
        <td style="width:25%; font-weight:bold; text-align:left;">Name</td>
        <td style="width:25%; text-align:left;"><?php echo h($patient['Patient']['lookup_name']); ?></td>
        
        <!-- Right Column -->
        <td style="width:25%; font-weight:bold; text-align:left;">Patient ID</td>
        <td style="width:25%; text-align:left;"> <?php echo h($patient['Patient']['patient_id']); ?></td>
    </tr>

    <tr>
        <td style="font-weight:bold;">Primary Care Provider</td>
        <td style="text-align:left;"> <?php echo h(ucfirst($treating_consultant[0]['fullname'])); ?></td>
        
        <td style="font-weight:bold;">Registration ID</td>
        <td style="text-align:left;"><?php echo h($patient['Patient']['admission_id']); ?></td>
    </tr>

    <tr>
        <td style="font-weight:bold;">Sex / Age</td>
        <td style="text-align:left;"> <?php echo h(ucfirst($sex)); ?> / <?php echo h($age); ?> Years</td>
        
        <td style="font-weight:bold;">Patient No</td>
        <td style="text-align:left;"> <?php echo h($patientDetailsForView['Person']['mobile']); ?></td>
    </tr>

    <tr>
        <td style="font-weight:bold;">Tariff</td>
        <td style="text-align:left;"> <?php echo h($patientDetailsForView['TariffStandard']['name']); ?></td>
        
        <td style="font-weight:bold;">Address</td>
        <td style="text-align:left;"><?php echo h($patientDetailsForView['Person']['plot_no'] . " " . $patientDetailsForView['Person']['landmark'] . " " . $patientDetailsForView['Person']['city']); ?></td>
    </tr>
    
  
</table>




<tr>
  <td style="line-height:1.5;" class="epen-content">
    <?php 
        // Decode HTML entities to get the actual content
        $content = htmlspecialchars_decode($printEpenData['Note']['epen_data']);

        // Define section titles and override inline keywords
        $sectionTitles = [
            'review of systems' => 'Review of Systems',
            'complaints' => 'Presenting Complaints', // Handle complaints
            'examination' => 'Examination',
            'investigations' => 'Investigations',
            'diagnosis and action plan' => 'Diagnosis and Action Plan',
            'note' => 'Note'
        ];

        // Handle inline keywords like complaints
        $inlineKeywordMap = [
            'examination' => 'Examination',
            'investigations' => 'Investigations'
        ];

        // Create a pattern for both official and inline sections
        $allKeys = array_merge(array_keys($sectionTitles), array_keys($inlineKeywordMap));
        $pattern = '/(' . implode('|', array_map('preg_quote', $allKeys)) . ')/i';

        // Split content into sections based on the pattern
        $sections = preg_split($pattern, $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        $formattedContent = '';
        $currentSection = '';
        $sectionContents = [];
        $presentingComplaintsAdded = false;  // Flag to track if Presenting Complaints has been added

       foreach ($sections as $section) {
    $section = trim($section); // Clean section content
    $lower = strtolower($section); // Make case-insensitive

    // Check if it's "Presenting Complaints" and add the title only once
    if ($lower == 'complaints' && !$presentingComplaintsAdded) {
        // Add the heading for Presenting Complaints only once
        $formattedContent .= "<strong>Presenting Complaints</strong><ul>";
        $presentingComplaintsAdded = true;  // Set flag to true after adding
    }

    // Handle official section titles
    if (isset($sectionTitles[$lower])) {
        $currentSection = $sectionTitles[$lower];
        if (!isset($sectionContents[$currentSection])) {
            $sectionContents[$currentSection] = [];
        }
    } elseif (isset($inlineKeywordMap[$lower])) {
        // Handle inline keywords (like "complaints")
        $mappedHeading = $inlineKeywordMap[$lower];
        $currentSection = $mappedHeading;
        if (!isset($sectionContents[$currentSection])) {
            $sectionContents[$currentSection] = [];
        }
    } else {
        // Process content under the current section
        if (!empty($currentSection)) {
            // Clean content and split into sentences
            $cleanContent = preg_replace('/\s+/', ' ', strip_tags($section));
            $sentences = preg_split('/(\. |\n|\r)/', $cleanContent);
            foreach ($sentences as $sentence) {
                $trimmed = trim($sentence);
                if (!empty($trimmed)) {
                    $sectionContents[$currentSection][] = $trimmed;
                }
            }
        } else {
            // Handle raw content if no section was found
            $formattedContent .= $section;
        }
    }
}

// Ensure the "Presenting Complaints" section closes properly
if ($presentingComplaintsAdded) {
    $formattedContent .= "</ul>";  // Close the Presenting Complaints list
}


        // Render the sections with headings
        foreach ($sectionContents as $title => $points) {
            // Display each section with its title and content as bullet points
            $formattedContent .= "<strong>$title</strong><ul>";
            foreach ($points as $point) {
                $formattedContent .= "<li>" . htmlspecialchars($point, ENT_QUOTES, 'UTF-8') . "</li>";
            }
            $formattedContent .= "</ul>";
        }

        // Close the Presenting Complaints list
        if ($presentingComplaintsAdded) {
            $formattedContent .= "</ul>";  // Close the presenting complaints list
        }

        // Output the formatted content
        echo $formattedContent;
    ?>
  </td>
</tr>



<style>


    
</style>