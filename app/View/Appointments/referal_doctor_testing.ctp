<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Doctors</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <style>
         div.dataTables_wrapper div.dataTables_filter {
    text-align: center;
}
     </style>

</head>
<body>
<div class="container-fluid ">
    <h1 class="text-center mb-4">Referral Doctors(Agent) and Ambulance List</h1>

    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="filter-sponsor">Filter by Sponsor:</label>
            <select id="filter-sponsor" class="form-control">
                <option value="">Select Sponsor</option>
                <?php foreach ($sponsor as $key => $value): ?>
                    <option value="<?= h($value); ?>"><?= h($value); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="filter-marketing-team">Filter by Marketing Team:</label>
            <select id="filter-marketing-team" class="form-control">
                <option value="">Select Marketing Team</option>
                <?php foreach ($marketing_teams as $key => $value): ?>
                    <option value="<?= h($value); ?>"><?= h($value); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- DataTable -->
<!-- Add a master checkbox in the header -->
<table id="referral-doctor-table" class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>
                <input type="checkbox" id="select-all-checkbox">
                Select
            </th>
            <th>ID</th>
            <th>Call</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Area</th>
            <th>Marketing Team</th>
            <th>Disposition</th>
            <th>Sub-Disposition</th>
            <th>Remarks</th>
            <th>Telecaller Name</th>
            <th>Save</th>
            <th>Generate QR</th>
            <th>Download General QR</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($data as $consultant): ?>
            <tr>
                <form method="POST" action="saveReferralData">
                    <td>
                        <input type="checkbox" class="phone-checkbox" value="<?= h($consultant['Consultant']['mobile']); ?>">
                    </td>
                    <td><?= h($consultant['Consultant']['id']); ?></td>
                    <td class="click-to-call" data-mobile="<?php echo h($consultant['Consultant']['mobile']); ?>">
                        <i style="font-size:24px" class="fa"><a href="">&#xf095;</a></i>
                    </td>
                    <td>
                        <input type="hidden" name="consultant_id"  value="<?= h($consultant['Consultant']['id']); ?>"/>
                        <a href="<?= $this->Html->url(['controller' => 'Consultants', 'action' => 'referral_hub', '?' => ['referal_id' => $consultant['Consultant']['id']]], true); ?>" target="_blank">
                            <?= h($consultant['Consultant']['first_name']); ?> <?= h($consultant['Consultant']['last_name']); ?>
                        </a>
                    </td>
                    <td><?= h($consultant['Consultant']['mobile']); ?></td>
                    <td><?= h($consultant['City']['name']); ?></td>
                    <td><?= h($consultant['Consultant']['market_team']); ?></td>
                    <input type="hidden" name="referal_id"  value="<?= h($consultant['Consultant']['id']); ?>"/>
                    <td>
                        <select class="form-control disposition-dropdown" name="disposition[<?= $consultant['Consultant']['id']; ?>]" onchange="updateSubDisposition(this, <?= $consultant['Consultant']['id']; ?>)">
                            <option value="">Select Disposition</option>
                            <option value="Patient Sent">Patient Sent</option>
                            <option value="No Response">No Response</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Follow Up Needed">Follow Up Needed</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control sub-disposition-dropdown" id="sub-disposition-<?= $consultant['Consultant']['id']; ?>" name="sub_disposition[<?= $consultant['Consultant']['id']; ?>]">
                            <option value="">Select Sub-Disposition</option>
                        </select>
                    </td>
                    <td>
                        <textarea class="form-control remarks-field" name="remarks[<?= $consultant['Consultant']['id']; ?>]" placeholder="Enter remarks here"></textarea>
                    </td>
                    <td>
                        <select class="form-control" name="telecaller_name[<?= $consultant['Consultant']['id']; ?>]">
                            <option value="">Select Telecaller</option>
                            <option value="Aarya Chikankar">Aarya Chikankar</option>
                            <option value="Dolly">Dolly</option>
                            <option value="Neeraj">Neeraj</option>
                        </select>
                    </td>
                    <td>
                        <button type="submit" class="badge badge-info">Submit</button>
                    </td>
                </form>
                <td>
                    <a href="https://hopesoftwares.com/persons/quickReg?id=<?php echo h($consultant['Consultant']['id']); ?>" class="badge badge-success text-white" style="border: solid 2px black;padding: px;margin: 2px;">
                        Register
                    </a>
                </td>
                <td>
                    <button class="badge badge-info" onclick="prepareAndDownloadQRCode('<?php echo $consultant['Consultant']['mobile']; ?>', '<?php echo $consultant['Consultant']['id']; ?>')">Download QR</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
document.getElementById('select-all-checkbox').addEventListener('change', function () {
    const isChecked = this.checked; 
    const checkboxes = document.querySelectorAll('.phone-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = isChecked;
    });
});
</script>


<button id="send-whatsapp-btn" class="btn btn-success">Send WhatsApp Message</button>
<button id="send-festival-btn" class="btn btn-success">Send Festival Message</button>
<button id="send-festival-video" class="btn btn-success">Send Festival Video</button>
<div id="previewModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index:1000; background:#fff; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.5);">
    <h4>Preview Message</h4>
    <textarea id="messagePreview" rows="10" cols="50" style="width:100%;"></textarea>
    <br />
    <input type="text" id="variableHIV" placeholder="HIV (e.g., HIV)" value="HIV">
    <input type="text" id="variableECG" placeholder="ECG (e.g., ECG)" value="ECG">
    <input type="text" id="variableAngioplasty" placeholder="Angioplasty (e.g., Angioplasty)" value="Angioplasty">
    <br /><br />
    <button id="confirmSend" class="btn btn-primary">Confirm and Send</button>
    <button id="cancelPreview" class="btn btn-secondary">Cancel</button>
</div>

<script>
// document.getElementById('send-whatsapp-btn').addEventListener('click', async () => {
//     const selectedRows = Array.from(document.querySelectorAll('.phone-checkbox:checked'));
//     if (selectedRows.length === 0) {
//         alert('Please select at least one row.');
//         return;
//     }
//     document.getElementById('previewModal').style.display = 'block';
    
//     const updatePreview = () => {
//         const variableHIV = document.getElementById('variableHIV').value;
//         const variableECG = document.getElementById('variableECG').value;
//         const variableAngioplasty = document.getElementById('variableAngioplasty').value;

//         const messageTemplate = `
//         माननीय Dr {name},
        
//         नमस्कार! आशा करता हूं कि आप स्वस्थ और खुशहाल होंगे।
        
//         सर, आपके {area} क्षेत्र से जो ${variableHIV} रोग के मरीज हमारे पास आए, उनके लिए हमने ${variableECG} और अन्य जरूरी सुविधाएं उपलब्ध कराई हैं।
//         उनकी बेहतर सेहत के लिए हम ${variableAngioplasty} जैसी जटिल शल्य चिकित्सा भी कर रहे हैं।
        
//         हम चाहते हैं कि आपके क्षेत्र के मरीजों को सबसे अच्छी चिकित्सा सेवाएं मिलें। अगर आपके पास कोई सुझाव हो, जिससे हम अपनी सेवाओं को और बेहतर बना सकें, तो कृपया हमें जरूर बताएं।
        
//         आपके विचार हमारे लिए बहुत अहम हैं।
        
//         धन्यवाद,
//         {employeeName}
        
//         -Hope Group of Hospitals`;

//         // Replace placeholders in the template
//         const previewTextarea = document.getElementById('messagePreview');
//         previewTextarea.value = messageTemplate.replace('{name}', 'Ashwin Dahikar').replace('{area}', 'Nagpur').replace('{employeeName}', 'Priyanka');
//     };

//     document.getElementById('variableHIV').addEventListener('input', updatePreview);
//     document.getElementById('variableECG').addEventListener('input', updatePreview);
//     document.getElementById('variableAngioplasty').addEventListener('input', updatePreview);

//     // Initial call to update preview
//     updatePreview();

//     document.getElementById('confirmSend').addEventListener('click', () => {
//         selectedRows.forEach(async (checkbox) => {
//             const row = checkbox.closest('tr');
//             const phone = checkbox.value;
//             const name = row.querySelector('td:nth-child(5)').textContent.trim();
//             const area = row.querySelector('td:nth-child(7)').textContent.trim();
//             // const employeeName = row.querySelector('td:nth-child(9)').textContent.trim();
//             const employeeName = 'Hope Hospital';
//         //      console.log('Selected Row Data:');
//         // console.log('Phone:', phone);
//         // console.log('Name:', name);
//         // console.log('Area:', area);
//         // console.log('Employee Name:', employeeName);

//             const apiUrl = "https://public.doubletick.io/whatsapp/message/template";
//             const apiKey = "key_8sc9MP6JpQ";

//             const payload = {
//                 messages: [
//                     {
//                         to: "+91" + phone,  // Ensure the phone number is correct
//                         content: {
//                             templateName: "patient_info",  // Validate the template name
//                             language: "en",
//                             templateData: {
//                                 body: {
//                                     placeholders: [
//                                         "Dr",
//                                         name,
//                                         area,
//                                         document.getElementById('variableHIV').value,
//                                         document.getElementById('variableECG').value,
//                                         document.getElementById('variableAngioplasty').value,
//                                         employeeName
//                                     ]
//                                 }
//                             }
//                         }
//                     }
//                 ]
//             };

//             // Log the payload for debugging
//             console.log('Sending payload:', payload);

//             try {
//                 const response = await fetch(apiUrl, {
//                     method: "POST",
//                     headers: {
//                         "accept": "application/json",
//                         "content-type": "application/json",
//                         "Authorization": apiKey
//                     },
//                     body: JSON.stringify(payload)
//                 });

//                 const result = await response.json();
//                 console.log('API Response:', result);  // Log the response for debugging

//                 if (response.ok) {
//                     alert(`Message sent successfully to ${phone}`);
//                 } else {
//                     alert(`Error sending to ${phone}: ${result.message || "Something went wrong."}`);
//                 }
//             } catch (error) {
//                 console.error('Error:', error);
//                 alert('Error sending message. Check the console for details.');
//             }
//         });

//         // Close the modal
//         document.getElementById('previewModal').style.display = 'none';
//     });

//     document.getElementById('cancelPreview').addEventListener('click', () => {
//         // Close the modal
//         document.getElementById('previewModal').style.display = 'none';
//     });
// });
</script>
<script>
// Code for sending the first message using the first button

document.getElementById('send-whatsapp-btn').addEventListener('click', async () => {
    const selectedRows = Array.from(document.querySelectorAll('.phone-checkbox:checked'));
    if (selectedRows.length === 0) {
        alert('Please select at least one row.');
        return;
    }
    document.getElementById('previewModal').style.display = 'block';

    const updatePreview = () => {
        const variableHIV = document.getElementById('variableHIV').value;
        const variableECG = document.getElementById('variableECG').value;
        const variableAngioplasty = document.getElementById('variableAngioplasty').value;

        const messageTemplate = `
        माननीय Dr {name},
        
        नमस्कार! आशा करता हूं कि आप स्वस्थ और खुशहाल होंगे।
        
        सर, आपके {area} क्षेत्र से जो ${variableHIV} रोग के मरीज हमारे पास आए, उनके लिए हमने ${variableECG} और अन्य जरूरी सुविधाएं उपलब्ध कराई हैं।
        उनकी बेहतर सेहत के लिए हम ${variableAngioplasty} जैसी जटिल शल्य चिकित्सा भी कर रहे हैं।
        
        हम चाहते हैं कि आपके क्षेत्र के मरीजों को सबसे अच्छी चिकित्सा सेवाएं मिलें। अगर आपके पास कोई सुझाव हो, जिससे हम अपनी सेवाओं को और बेहतर बना सकें, तो कृपया हमें जरूर बताएं।
        
        आपके विचार हमारे लिए बहुत अहम हैं।
        
        धन्यवाद,
        {employeeName}
        
        -Hope Group of Hospitals`;

        // Replace placeholders in the template
        const previewTextarea = document.getElementById('messagePreview');
        previewTextarea.value = messageTemplate.replace('{name}', 'Ashwin Dahikar').replace('{area}', 'Nagpur').replace('{employeeName}', 'Priyanka');
    };

    document.getElementById('variableHIV').addEventListener('input', updatePreview);
    document.getElementById('variableECG').addEventListener('input', updatePreview);
    document.getElementById('variableAngioplasty').addEventListener('input', updatePreview);

    // Initial call to update preview
    updatePreview();

    document.getElementById('confirmSend').addEventListener('click', () => {
        selectedRows.forEach(async (checkbox) => {
            const row = checkbox.closest('tr');
            const phone = checkbox.value;
            const name = row.querySelector('td:nth-child(5)').textContent.trim();
            const area = row.querySelector('td:nth-child(7)').textContent.trim();
            const employeeName = 'Hope Hospital';

            const apiUrl = "https://public.doubletick.io/whatsapp/message/template";
            const apiKey = "key_8sc9MP6JpQ";

            const payload = {
                messages: [
                    {
                        to: "+91" + phone,
                        content: {
                            templateName: "patient_info",  // Validate the template name
                            language: "en",
                            templateData: {
                                body: {
                                    placeholders: [
                                        "Dr",
                                        name,
                                        area,
                                        document.getElementById('variableHIV').value,
                                        document.getElementById('variableECG').value,
                                        document.getElementById('variableAngioplasty').value,
                                        employeeName
                                    ]
                                }
                            }
                        }
                    }
                ]
            };

            // Log the payload for debugging
            console.log('Sending payload:', payload);

            try {
                const response = await fetch(apiUrl, {
                    method: "POST",
                    headers: {
                        "accept": "application/json",
                        "content-type": "application/json",
                        "Authorization": apiKey
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();
                console.log('API Response:', result);  // Log the response for debugging

                if (response.ok) {
                    alert(`Message sent successfully to ${phone}`);
                } else {
                    alert(`Error sending to ${phone}: ${result.message || "Something went wrong."}`);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error sending message. Check the console for details.');
            }
        });

        // Close the modal
        document.getElementById('previewModal').style.display = 'none';
    });

    document.getElementById('cancelPreview').addEventListener('click', () => {
        // Close the modal
        document.getElementById('previewModal').style.display = 'none';
    });
});

// Code for sending the second message using the second button without modal

document.getElementById('send-festival-btn').addEventListener('click', async () => {
    const selectedRows = Array.from(document.querySelectorAll('.phone-checkbox:checked'));
    if (selectedRows.length === 0) {
        alert('Please select at least one row.');
        return;
    }

    selectedRows.forEach(async (checkbox) => {
        const row = checkbox.closest('tr');
        const phone = checkbox.value;
        const name = row.querySelector('td:nth-child(5)').textContent.trim();
        const employeeName = 'Hope Hospital';

        const apiUrl = "https://public.doubletick.io/whatsapp/message/template";
        const apiKey = "key_8sc9MP6JpQ";

        const payload = {
            messages: [
                {
                    to: "+91" + phone,
                    content: {
                        templateName: "makar_sankranti",
                        language: "en",
                        templateData: {
                            body: {
                                placeholders: [
                                    name
                                ]
                            }
                        }
                    }
                }
            ]
        };

        // Log the payload for debugging
        console.log('Sending festival payload:', payload);

        try {
            const response = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "accept": "application/json",
                    "content-type": "application/json",
                    "Authorization": apiKey
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            console.log('Festival API Response:', result); // Log the response for debugging

            if (response.ok) {
                alert(`Festival message sent successfully to ${phone}`);
            } else {
                alert(`Error sending to ${phone}: ${result.message || "Something went wrong."}`);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error sending festival message. Check the console for details.');
        }
    });
});

document.getElementById('send-festival-video').addEventListener('click', async () => {
    const selectedRows = Array.from(document.querySelectorAll('.phone-checkbox:checked'));
    if (selectedRows.length === 0) {
        alert('Please select at least one row.');
        return;
    }

    selectedRows.forEach(async (checkbox) => {
        const row = checkbox.closest('tr');
        const phone = checkbox.value;
        const name = row.querySelector('td:nth-child(5)').textContent.trim();
        const employeeName = 'Hope Hospital';

        const apiUrl = "https://public.doubletick.io/whatsapp/message/template";
        const apiKey = "key_8sc9MP6JpQ";

        const payload = {
            messages: [
                {
                    to: "+91" + phone,
                    content: {
                        templateName: "makar_sankranti_vid",
                        language: "en",
                        templateData: {
                            body: {
                                placeholders: [
                                    name
                                ]
                            }
                        }
                    }
                }
            ]
        };

        // Log the payload for debugging
        console.log('Sending festival payload:', payload);

        try {
            const response = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "accept": "application/json",
                    "content-type": "application/json",
                    "Authorization": apiKey
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            console.log('Festival API Response:', result); // Log the response for debugging

            if (response.ok) {
                alert(`Festival message sent successfully to ${phone}`);
            } else {
                alert(`Error sending to ${phone}: ${result.message || "Something went wrong."}`);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error sending festival message. Check the console for details.');
        }
    });
});
</script>

<script>
        const dispositionMapping = {
            "Patient Sent": ["Patient Arrived", "Patient Delayed", "Cancelled"],
            "No Response": ["Call Again", "Left Message", "No Answer"],
            "Not Interested": ["Already Consulting", "Not Required", "Other"],
            "Follow Up Needed": ["Call Scheduled", "Waiting for Confirmation", "Need More Info"]
        };
        function updateSubDisposition(dispositionDropdown, consultantId) {
            const selectedDisposition = dispositionDropdown.value;
            const subDispositionDropdown = document.getElementById(`sub-disposition-${consultantId}`);
            subDispositionDropdown.innerHTML = '<option value="">Select Sub-Disposition</option>';
            if (selectedDisposition && dispositionMapping[selectedDisposition]) {
                dispositionMapping[selectedDisposition].forEach(subDisposition => {
                    const option = document.createElement('option');
                    option.value = subDisposition;
                    option.textContent = subDisposition;
                    subDispositionDropdown.appendChild(option);
                });
            }
        }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
function prepareAndDownloadQRCode(mobile, id) {
    const last10Digits = mobile ? mobile.slice(-10) : '';
    const qrCodeUrl = `https://admin.emergencyseva.in/public/emergency-sewa?phone=${id}`;
    const overlayImageUrl = 'https://hopesoftwares.com/img/qr4.jpg';
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const overlayImage = new Image();
    overlayImage.crossOrigin = 'anonymous';
    overlayImage.src = overlayImageUrl;
    overlayImage.onload = () => {
        canvas.width = overlayImage.width;
        canvas.height = overlayImage.height;
        ctx.drawImage(overlayImage, 0, 0);
        ctx.font = 'bold 30px Arial';  
        ctx.fillStyle = 'white';
        ctx.textAlign = 'center'; 
        const textX = canvas.width / 2; 
        const textY = (canvas.height - 170) / 3 + 45; 
        ctx.fillText("Emergency Government No.", textX, textY);
        const phoneTextY = textY + 40;  
        ctx.fillText("112", textX, phoneTextY); 
        const qrCodeWidth = 280; 
        const qrCodeHeight = 280;
        const qrX = (canvas.width - qrCodeWidth) / 2; 
        const qrY = (canvas.height - qrCodeHeight) / 2 + 80;
        const qrCanvas = document.createElement('div');
        new QRCode(qrCanvas, {
            text: qrCodeUrl,
            width: qrCodeWidth,
            height: qrCodeHeight,
            correctLevel: QRCode.CorrectLevel.H,
        });
        setTimeout(() => {
            const qrCodeImage = qrCanvas.querySelector('img');
            const qrImage = new Image();
            qrImage.src = qrCodeImage.src;
            qrImage.onload = () => {
                ctx.drawImage(qrImage, qrX, qrY, qrCodeWidth, qrCodeHeight);
                const qrTextY = qrY + qrCodeHeight + 40; 
                ctx.font = 'bold 25px Arial'; 
                ctx.fillStyle = 'white';
                ctx.fillText(`#${id}`, canvas.width / 2, qrTextY);
                const qrImageUrl = canvas.toDataURL();
                const link = document.createElement('a');
                link.download = `QRCode_${id}${last10Digits ? `_${last10Digits}` : ''}.png`; // File name
                link.href = qrImageUrl;
                link.click(); 
            };
            qrImage.onerror = () => {
                alert("Failed to load QR code image.");
            };
        }, 500);
    };

    overlayImage.onerror = () => {
        alert("Failed to load overlay image.");
    };
}
</script>
    <div class="text-center mt-3">
        <a href="<?= $this->Html->url(['action' => 'referal_doctor', 'print']); ?>" target="_blank" class="btn btn-primary text-white">Print</a>
        <a href="<?= $this->Html->url(['action' => 'referal_doctor', 'excel']); ?>" class="btn btn-success text-white">Download Excel</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.click-to-call').on('click', function() {
        var mobileNumber = $(this).data('mobile');
        $.ajax({
            url: '/call-api', // PHP endpoint for API
            method: 'POST',
            data: { mobile: mobileNumber },
            success: function(response) {
                alert('Call initiated successfully: ' + response);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });
});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#referral-doctor-table').DataTable({
            "lengthMenu": [20,40,50], // Set page length options
            "paging": true,
            "searching": true,
            "ordering": true
        });

        $('#filter-sponsor').on('change', function () {
            var value = $(this).val();
            table.column(5).search(value).draw();
        });
        $('#filter-marketing-team').on('change', function () {
            var value = $(this).val();
            table.column(4).search(value).draw();
        });
    });
</script>
</body>
</html>
