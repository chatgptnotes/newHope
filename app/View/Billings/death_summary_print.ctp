<style>
    /* General styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Print styles */
    @media print {
        #printButton {
            display: none; /* Hide print button */
        }

        .print-container {
            width: 21cm; /* A4 width */
            margin: 0 auto;
            padding: 40px;
            page-break-before: always;
        }
    }

    /* Layout styling */
    .print-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px;
        border: 1px solid #000;
        background: #fff;
    }

    /* Title section */
    .summary-title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid black;
        padding-bottom: 10px;
    }

    /* Summary Content */
    .summary-content {
        font-size: 16px;
        line-height: 1.6;
        margin: 20px 0;
        text-align: justify;
    }

    /* Table layout for Date, Received By, Doctor Info */
    .header-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 40px;
    }

    .header-table td {
        vertical-align: top;
        padding: 5px;
    }

    /* Left-aligned Date */
    .date {
        font-size: 12px;
        font-weight: bold;
        text-align: left;
        width: 15%;
        white-space: nowrap;
        
    }
    .date strong{
        font-weight: bold;
        font-size: 15px;
    }
    /* Center-aligned "Received by" with proper formatting */
    .received-by {
        text-align: left;
        font-size: 12px;
        width: 40%;
        vertical-align: top;
    }
    .received-by strong{
        font-weight: bold;
        font-size: 15px;
    }

    /* Right-aligned Doctor's Details */
    .doctor-info {
        text-align: left;
        font-size: 12px;
        width: 14%;
    }
    .doctor-info strong{
        font-weight: bold;
        font-size: 15px;
    }

    /* Signature Section */
    .received-by p {
        margin: 10px 0;
        text-align: left;
    }

    /* Underline fields for handwritten input */
    .underline {
        display: inline-block;
        border-bottom: 1px solid black;
        width: 150px; /* Adjust width as needed */
        margin-left: 10px;
    }

    /* Contact Information Section */
    .contact-info {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin-top: 50px;
        border-top: 2px solid black;
        padding-top: 15px;
    }

    .urgent-care {
        color: red;
        font-weight: bold;
    }

    /* Print button */
    #printButton {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #0275d8;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
    }

    #printButton:hover {
        background-color: #025aa5;
    }

</style>

<!-- Print Container -->
<div class="print-container">
    
    <!-- Title -->
    <h3 class="summary-title">Death Summary</h3>

    <!-- Summary Content -->
    <div class="summary-content">
        <?php
            if (!empty($deathSummary['DeathSummary']['summary'])) {
                echo nl2br($deathSummary['DeathSummary']['summary']);  // Display the summary with line breaks
            } else {
                echo "No Death Summary Available.";  // Message if no summary is found
            }
        ?>
    </div>

    <!-- Header Table for 3-column Layout (Date, Received By, Doctor) -->
    <table class="header-table">
        <tr>
            <td class="date"><p><strong>Date :</strong> <?php echo date("d-m-Y"); ?></p></td>
            <td class="received-by">
                <p><strong>Received by</strong></p>
                <p>Date Received :<span class="underline"></span></p>
                <p>Sign :<span class="underline"></span></p>
                <p>Name of Relative :<span class="underline"></span></p>
                <p>Relationship with Patient :<span class="underline"></span></p>
            </td>
            <td class="doctor-info">
                <p><strong>Dr. B.K. Murali</strong></p>
                <p>MS (Orth.)</p>
                <p>Director</p>
                <p>Orthopaedic Surgeon</p>
            </td>
        </tr>
    </table>

    <!-- Contact Information Section -->
    <div class="contact-info">
        <p class="title">==== CONTACT INFORMATION FOR URGENT QUERIES ====</p>

        <p class="urgent-care">
            ⚠ URGENT CARE/EMERGENCY CARE IS AVAILABLE 24 X 7.<br>
            📞 PLEASE CONTACT: <span>7030974619, 9373111709</span>
        </p>
    </div>

</div>

<!-- Print Button -->
<button id="printButton" onclick="window.print();">Print Summary</button>

<script>
    $(document).ready(function() {
        // Optional: Automatically trigger printing when the page loads
        // window.print(); // Uncomment to trigger print immediately
    });
</script>
