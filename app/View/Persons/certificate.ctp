<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
              .sl-no {
            position: absolute;
            top: 10px;
            left: 10px;
            font-weight: bold;
        }

        .certificate-no {
            position: absolute;
            top: 10px;
            right: 10px;
            font-weight: bold;
        }
            .logo-row {
                display: flex;
                justify-content: space-between;
                margin-top: -5px;
            }
            
            .logo-left {
                height: 107px;
                margin-left: -20px;
            }
            
            .logo-right {
                height: 107px;
                margin-right: -23px;
            }
            @media (max-width: 768px) {
                .logo-row {
                flex-direction: column;
                align-items: center;
                margin-top: 10px;
                }
                    .logo-left {
                position: relative;
                margin: 5px 0;
                margin-right: 533px;
                top: 23px;
                }

                   .logo-right {
                    position: relative;
                    /* margin: 5px 0; */
                    margin: 5px 0;
                    /* width: 17%; */
                    margin-left: 500px;
                    margin-top: -95px;
                }
                .raftaar-logo {
                    height: 90px;
                    margin-top: 44px;
                    width: 150px;
                }
                
            }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            text-align: center;
        }

        .signature {
            width: 30%;
        }

        .signature-input {
            width: auto;
            border-radius: 10px;
            background-color: #f0efd7;
            padding: 10px;
            border: 3px solid #dac95f;
            box-sizing: border-box;
        }

        .signature span {
            display: block;
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
            font-size: 14px;
        }

        .transparent-img {
            mix-blend-mode: multiply;
            filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.1));
        }

        .certificate {
            width: 210mm;
            height: 304mm;
            margin: 0 auto;
            padding: 10mm;
            border: 28px solid #d6b8b8;
            /* background-image: url('https://hopesoftwares.com/theme/Black/img/certificate/enhanced_certificate.png'); */
            background-size: 130% auto;
            background-position: center 50px;
            background-repeat: no-repeat;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            box-sizing: border-box;
            background-position: -70px;
        }

        .border-container {
            width: 10%;
            height: 100vh;
            background-image: url('https://hopesoftwares.com/theme/Black/img/certificate/only_border.png');
            background-size: cover;
        }

        .address {
            width: 47%;
            position: relative;
            font-size: 14px;
            top: 60px;
            margin-left: 25%;
            font-family: "Times New Roman", Times, serif;
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .certificate-header img {
            height: 60px;
            margin: 0 20px;
        }

      .certificate-title {
            position: relative;
            color: #d15252;
            font-size: 35px;
            margin: 5px 0;
            top: 20px;
            width: 69%;
            margin-left: 18%;
            font-weight: 800;
        }

        .certificate-subtitle {
            font-size: 18px;
            margin: 5px 0;
        }

        .certificate-body {
            margin-top: 20px;
        }

        .certificate-body h2 {
            font-size: 24px;
            color: rgb(11, 11, 11);
            margin-bottom: 10px;
        }

        .certificate-body h3 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .certificate-body p {
            text-align: left;
            width: 60%;
            font-size: 16px;
            margin: 5px 0;
            font-family: "Times New Roman", Times, serif;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            }

            .place-field {
            }

            .date-field {
            }

        .certificate-table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: left;
            font-size: 16px;
        }

        .certificate-table th, .certificate-table td {
            border: 1px solid #aaa;
            padding: 10px;
        }

        .certificate-footer {
            margin-top: 30px;
            font-size: 14px;
        }

        .custom-text {
            font-size: 25px;
            font-family: 'Sofia', sans-serif;
        }

        .qr-code {
            margin: 20px auto;
        }

        .qr-code img {
            height: 100px;
        }

        .place {
            margin-top: 20px;
            font-size: 16px;
            font-style: italic;
        }

        @font-face {
            font-family: 'Rage Italic';
            src: url('rageitalic.ttf') format('truetype');
        }

        @media print {
         
            
            .certificate {
            width: 210mm;
            height: 278.6mm;
            margin: auto;
            padding: 10mm;
            border: 28px solid #d6b8b8;
            background-image: url('https://hopesoftwares.com/theme/Black/img/certificate/enhanced_certificate.png');
            background-size: 130% auto;
            background-position: center 50px;
            background-repeat: no-repeat;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            box-sizing: border-box;
            background-position: -70px;
        }
          

            .certificate-header img, .qr-code img {
                height: auto;
                max-height: 60px;
            }

            .certificate-table th, .certificate-table td {
                padding: 5px;
            }
        }

        @media (max-width: 768px) {
          
            .certificate-body p, .certificate-body h2, .certificate-body h3, .certificate-table th, .certificate-table td {
                font-size: 12px;
            }
            .address {
                width: 47%;
                position: relative;
                font-size: 18px;
                top: 73px;
                margin-left: 25%;
                font-family: "Times New Roman", Times, serif;
            }
        }

        .organized-by {
            position: relative;
            top: 6px;
            font-weight: bold;
        }

        .raftaar-logo {
            height: 95px;
            margin-top: 44px;
            width: 150px;
        }

        .chairman {
            margin-top: -142px;
            width: 58%;
        }

        .manager {
            margin-top: -142px;
        }

        .certify-text {
            font-size: 25px;
            color: #d15252;
            font-weight: 600;
        }

        .certify-relation {
            font-size: 25px;
            color: #d15252;
            font-weight: 600;
            margin-top: 11px;
        }

        .award-text {
            margin-top: 11px;
            text-align: left;
            font-size: 18px;
        }
@media (max-width: 768px) {
 
    .certificate-body p, .certificate-body h2, .certificate-body h3, .certificate-table th, .certificate-table td {
        font-size: 12px;
    }
    .certificate-header img, .qr-code img {
        height: 50px;
    }
    .certificate-table {
        font-size: 12px;
    }
    .signature-input {
        font-size: 12px;
        padding: 5px;
    }
    .certify-text, .certify-relation {
        font-size: 18px;
    }
    .award-text {
        font-size: 14px;
    }
    .border-container {
        display: none;
    }
}
    </style>
</head>
<body>
    <!-- Place an <img> behind the content to act as a background 
<img src="https://hopesoftwares.com/theme/Black/img/certificate/enhanced_certificate.png" 
     style="position:absolute; top:0; left:0; width:100%; height:auto; z-index:-1;" /> -->

    <div class="certificate">
        <div class="certificate-header"></div>
        
        <div style="margin-top: 20px;">
            <div class="sl-no">
                <div>Sl. No. <?php echo ucfirst(h($certificateData['FirstAidCertificate']['id'])); ?></div>
            </div>
            <div class="certificate-no">
                <div>Certificate No. <?php echo ucfirst(h($certificateData['FirstAidCertificate']['certificate_number'])); ?></div>
            </div>
            <div class="certificate-title">RaftaarHelp Emergency Seva</div>
            <div class="address">Flat no. 172 , Casa Royal , Mohan nagar, Nagpur Pin code:- 440001</div>
        </div>
        <div class="logo-row">
  <div>
    <?php echo $this->Html->image(
      'https://hopesoftwares.com/theme/Black/img/certificate/logologo_transparent.png',
      array(
        'class' => 'transparent-img logo-left',
        'alt' => 'St. John Logo'
      )
    ); ?>
  </div>
  <div>
    <?php echo $this->Html->image(
      'https://hopesoftwares.com/theme/Black/img/certificate/logologo_transparent.png',
      array(
        'class' => 'transparent-img logo-right',
        'alt' => 'St. John Logo'
      )
    ); ?>
  </div>
</div>

        
        <p><strong class="organized-by">Organized by RaftaarHelp Emergency Seva</strong></p>
        <img src="https://hopesoftwares.com/theme/Black/img/certificate/raftaar_seva_logo.png" class="raftaar-logo" alt="Ambulance Logo">

        <div class="certificate-body">
            <div style="display: flex; justify-content: space-between; margin-top: -5px;">
            <div class="chairman">
                    <p>Chairman</p>
                    <p>Dr. B.K. Murali(Orth.)</p>
                </div>
                <div class="manager">
                    <p>Manager</p>
                    <p style="width: auto;">Gaurav Agrawal</p>
                </div>
            </div>
            
            <div>
                <p style="width: auto;"></p>
                    <span class="certify-text">This Is To Certify That 
                   <?php echo ucfirst(h($certificateData['FirstAidCertificate']['candidate_name'])); ?></span>
                </p>
            </div>
            
            <div>
                <p style="width: auto;"></p>
                    <span class="certify-relation"><?php echo ucfirst(h($certificateData['FirstAidCertificate']['relation'])); ?> Of <?php echo ucfirst(h($certificateData['FirstAidCertificate']['guardian_name'])); ?></span>
                </p>
            </div>
            
            <p class="award-text">Has been awarded this certificate</p>
    
            <table class="certificate-table">
                <tr>
                    <td>Examination</td>
                    <th>Senior Professional</th>
                    <td>Center</td>
                    <th><?php echo ucfirst(h($certificateData['FirstAidCertificate']['training_center'])); ?></th>
                </tr>
                <tr>
                    <td>Subject</td>
                    <th>First Aid</th>
                    <td>Date of Training</td>
                    <th><?php echo date('d F Y', strtotime($certificateData['FirstAidCertificate']['exam_date'])); ?></th>
                </tr>
            </table>
    
            <div class="certificate-footer"></div>
                <p>This certificate will be incomplete unless the holder has affixed his/her signature (or thumb impression) below and will become invalid unless he/she is re-examined within three years of the date of examination.</p>
            </div>
    
            <div class="signature-section">
                <div class="signature">
                    <span>Signature of the Candidate</span>
                </div>
                <div class="signature">
                    <span>Surgeon Examiner</span>
                </div>
                <div class="signature">
                    <span>General Secretary</span>
                </div>
            </div>
            <div class="row">
  <div class="place-field">
    <input type="text" class="signature-input" value="Place: <?php echo ucfirst(h($certificateData['FirstAidCertificate']['place'])); ?>">
  </div>
  <div class="date-field">
    <input type="text" class="signature-input" value="Date: <?php echo ucfirst(h($certificateData['FirstAidCertificate']['exam_date'])); ?>">
  </div>
</div>
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
    
document.addEventListener("DOMContentLoaded", function() {
    window.addEventListener('load', function() {
        var certificateElement = document.querySelector('.certificate');
        html2canvas(certificateElement).then(function(canvas) {
            var imgData = canvas.toDataURL('image/png');
            var doc = new window.jspdf.jsPDF('p', 'mm', 'a4');
            var pdfWidth = doc.internal.pageSize.getWidth();
            var pdfHeight = doc.internal.pageSize.getHeight();
            doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            doc.save('certificate.pdf');
        });
    });
});
</script>
        -->
        <script>
  window.onload = function() {
    window.print();
  };
</script>

</div>

</body>
</html>