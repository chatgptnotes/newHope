<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generation - Emergency Seva</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }

        .qr-code-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 columns */
            gap: 20px; /* Space between QR codes */
            padding: 20px;
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .qr-code {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            width: 100%;
            justify-content: center;
        }

        .qr-code .name {
            z-index: 2;
            font-weight: 700;
            font-size: 12px;
            color: #fff;
            position: absolute;
            top: 90%;
            text-align: center;
            margin-right:20px;
            top: 41%;
            font-size: 10px;
            transform: translateX(-50%) rotate(-90deg);
        }

        .qr-code .name .kin-number {
            font-size: 8px;
        }

        .qr-img {
            border-radius: 5px;
            position: relative;
            z-index: 3;
            width: 85px;
            height: 85px;
            margin-bottom: 10px;
            top: -32px;
            left: 24px;
        }

        .logo-img {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%) rotate(-90deg);
            width: 375px;
            z-index: 1;
        }

        @media print {
            .qr-code-section {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="qr-code-section" id="qrSection">
        <?php for ($i = 1; $i <= 9; $i++) : ?>
            <div class="qr-code">
                <div class="name">
                    <?php echo h($first_name); ?>&nbsp;<?php echo h($last_name); ?>
                    <div class="kin-number"><?php echo h($next_of_kin_number); ?></div>
                </div>
                <img src="<?php echo $user_qr_image; ?>" class="qr-img" alt="QR Code">
                <img src="/img/qr2.png" class="logo-img" alt="Logo">
            </div>
        <?php endfor; ?>
    </div>

    <script>
        function downloadQrSection() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');

            html2canvas(document.getElementById('qrSection'), {
                scale: 2,
                backgroundColor: '#fff',
            }).then(function(canvas) {
                const imgData = canvas.toDataURL('image/png');
                doc.addImage(imgData, 'PNG', 10, 10, 190, 277); 

                var firstName = '<?php echo h($first_name); ?>';
                var lastName = '<?php echo h($last_name); ?>';
                var filename = firstName + " " + lastName + " Emergency QR code.pdf";

                doc.save(filename);
            });
        }

        window.onload = function() {
            downloadQrSection();
        };
    </script>

</body>
</html>
