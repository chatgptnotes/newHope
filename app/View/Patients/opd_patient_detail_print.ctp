<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<style>

.titlle{
font-weight: bold;
font-size: large;
margin: 1%;
}
#qrcode img{
    display: block;
    margin-left: auto;
    margin-right: auto;
    float: none !important;
    width: 80px;
    height: 80px;
}
</style>

<html xmlns="http://www.w3.org/1999/xhtml" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo __('Hope', true); ?>
        </title>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
        <?php echo $this->Html->css('internal_style.css'); ?>  
        <style>
            body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
            .heading{font-weight:bold; padding-bottom:10px; font-size:19px; text-decoration:underline;}
            .headBorder{border:1px solid #ccc; padding:3px 0 15px 3px;}
            .title{font-size:14px; text-decoration:underline; font-weight:bold; padding-bottom:10px;color:#000;}
            input, textarea{border:1px solid #999999; padding:5px;}
            .tbl{background:#CCCCCC;}
            .tbl td{background:#FFFFFF;}
            .tbl .totalPrice{font-size:14px;}
            .adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
            .tabularForm td{background:none;}
            @media print {
                #printButton{display:none;}
            }
            .borderBottom{
                 border-bottom: 1px solid;
            }
             #qrcode {
            padding: 10px; /* Add 10px margin to the right */
             /* float: right; */
        }
        </style>
    </head>
    <body style="background:none;width:99%;margin:auto;">
        <?php 
        // debug($UIDpatient_details);exit;
        ?>
       

   
    
        <?php if(isset($this->params->query['invoice'])) {
            $margin = "18%";
        }else{
             $margin = "30px";
        }
?>
        <table border="0" class="" cellpadding="0" cellspacing="0" width="100%" style="margin-top:<?php echo $margin; ?>">
			<tr>
                <td colspan="3">
                    <div id="printButton" style="float: right">
					<?php
					echo $this->Html->link(__('Print', true), '#', array('escape' => false, 'class' => 'blueBtn', 'onclick' => 'window.print();'));
					?>
                    </div>
                    <div style="float: left;">
                    <?php
                   		echo $this->Html->image("/".$admission_Id, array('alt' => '','title'=>'','width'=>'190','height'=>'30','style'=>'padding-left:20px;'));
                   		?>
                   		
                   <?php echo $this->Html->image("/".$lookup_name, array('alt' => '','title'=>'','width'=>'190','height'=>'30','style'=>'padding-left:50px;')); ?>
                    </div>
					<?php if(!empty($patient['Patient']['file_number'])){?>
					<div>File Number: <?php echo $patient['Patient']['file_number'];?></div>
					<?php }?>                    
                </td>
            </tr>
        </table>
       
    <?php echo $this->element('print_patient_info') ?>
    	<table width="100%" border='0' cellpadding="5">
        <?php 
         if($admission_type == 'IPD'){
			echo $this->element('ipd_patient_detail_print');
		}else{
			echo $this->element('opd_patient_detail_print');
		} 
        ?>
        </table>
       <!-- <div id="qrcode" style="margin-top: -30%;"></div>  */-->
        <div style="position: relative; height: 200px; margin-top: ; text-align: center;">
  <!-- Background image -->
  <img src="<?php echo $this->Html->url('/img/qr2.png'); ?>" class="logo-img mt-3" alt="Logo" 
       style="width: 100%; height: 100%; object-fit: contain;  z-index: 1;    margin-left: 33%;">

  <!-- QR code container -->
  <div id="qrcode" style="position: absolute; top: 50%; left: 50%;    margin-left: 33%; transform: translate(-50%, -50%); z-index: 2;"></div>
    <!-- The QR code will be generated here -->
  </div>
</div>

<!-- CSS -->
<style>
  #qrcode img {
    width: 80px; /* Adjust QR code size */
    height: 80px;
    display: block;
    margin: 0 auto; /* Center within the QR code container */
    float: none !important;
    padding-top: 52%;
  }
</style>
        <script>
        // Yaha apne QR code aur link ka URL set karein
          const qrCodeURL = "https://admin.emergencyseva.in/public/emergency-sewa?phone=" + 
                "<?php echo urlencode(h($patientInfo[0]['Person']['mobile'])); ?>" +
                "<?php echo urlencode(h($patientInfo[0]['Person']['next_of_kin_mobile'])); ?>" +
                "<?php echo urlencode(h($patientInfo[0]['Person']['first_name'])); ?>";
        // QR code generate karna
        const qrcode = new QRCode(document.getElementById("qrcode"), {
            text: qrCodeURL,  // QR code ke andar yeh URL hoga
            width: 150,       // QR code ki width
            height: 150,      // QR code ki height
            margin: 5,
        });

        // Link set karna
        const linkElement = document.getElementById("link");
        linkElement.href = qrCodeURL;
    </script>
    </body>
</html>
