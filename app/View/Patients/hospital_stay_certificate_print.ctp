<style>
    @media print {

    #printButton {
        display: none;
    }

    table {
        page-break-inside: auto;
      }
      tr {
        page-break-inside: avoid;
        page-break-after: auto;
      }
      thead {
        display: table-header-group;
      }
      tfoot {
        display: table-footer-group;
      }
}

</style>

<div style="float:right;" id="printButton">
    <?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
  
     <?php



$admission_date = $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
$discharge_date= $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),true);

$unserData = unserialize($stayData['HospitalStayCertificate']['stay_info']);

?>

<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center">
    <tr>
        <td style="text-align: center;"><h3><u>रूग्णालयातील वास्तव्याचा दाखला</u></h3></td>
    </tr>
    <tr>
        <td><p>याद्वारे असे प्रमाणित करण्यात येते की

            <?php echo $unserData['sponsor_company']; ?>  येथे  

            <?php echo $unserData['patient_name']; ?> या पदावर नोकरीत असलेल्या व 

            <?php echo strip_tags($formatted_address); ?> या पत्त्यावर राहणाऱ्या श्री / श्रीमती / कुमारी 

            <?php echo $patient['Patient']['name_of_ip']; ?> यांची / यांचा / पत्नी / पती / मुलगा / मुलगी / वडील / आई / सासु / सासरे श्री /श्रीमती 

            <?php echo $patient['Patient']['lookup_name']; ?> यांच्यावर/ हिच्यावर दि.

            <?php echo $admission_date ; ?>  पासुन 

            <?php echo $discharge_date ; ?> 

            पर्यंत या रूग्णालयात औषधोपचार घेतला आहे </p></td>
    </tr>

</table>
<table class="" border="1" cellpadding="3" cellspacing="1" width="100%" align="center">

    <tr>
        <td>अ.क्र</td>
        <td>वॉर्ड</td>
        <td>दर</td>
        <td>दिवस</td>
        <td>एकूण रूपये</td>
    </tr>

    <?php 
            $generalRate = ($unserData['general_rate'] ) ? $unserData['general_rate'] : $customArray['4000']['rate']  ;
            $generalQty =  ($unserData['general_days'] ) ? $unserData['general_days'] : $customArray['4000']['qty']   ;
            $generalTot = $generalRate * $generalQty ;
            $generalTotal =  ($unserData['general_total'] ) ? $unserData['general_total'] : $generalTot  ;

            $icuRate = ($unserData['icu_room_rate'] ) ? $unserData['icu_room_rate'] : $customArray['7500']['rate']  ;
            $icuQty =  ($unserData['icu_room_days'] ) ? $unserData['icu_room_days'] : $customArray['7500']['qty']   ;
            $icuTot = $icuRate * $icuQty ;
            $icuTotal =  ($unserData['icu_room_total'] ) ? $unserData['icu_room_total'] : $icuTot  ;


            $icuWithVentiRate = ($unserData['icu_room_venti_rate'] ) ? $unserData['icu_room_venti_rate'] : $customArray['9000']['rate']  ;
            $icuWithVentiQty =  ($unserData['icu_room_venti_days'] ) ? $unserData['icu_room_venti_days'] : $customArray['9000']['qty']   ;
            $icuWithVentiTot = $icuWithVentiRate * $icuWithVentiQty ;
            $icuWithVentiTotal =  ($unserData['icu_room_venti_total'] ) ? $unserData['icu_room_venti_total'] : $icuWithVentiTot  ;

    ?>
    <tr>
        <td>१</td>
        <td>जनरल वॅार्ड</td>
        <td><?php echo $generalRate; ?></td>
        <td><?php echo $generalQty; ?></td>
        <td><?php echo $generalTotal; ?></td>
    </tr>

    <tr>
        <td>२</td>
        <td>जनरल वॅार्डच्या बाजुला बाथरूम नसलेला कक्ष</td>
        <td><?php echo $unserData['general_without_bathroom_rate'] ; ?></td>
        <td><?php echo $unserData['general_without_bathroom_days'] ; ?></td>
        <td><?php echo $unserData['general_without_bathroom_total'] ; ?></td>
    </tr>

    <tr>
        <td>३</td>
        <td>बाथरूमसह स्वतंत्र कक्ष</td>
        <td><?php echo $unserData['private_with_bathroom_rate'] ; ?></td>
        <td><?php echo $unserData['private_with_bathroom_days'] ; ?></td>
        <td><?php echo $unserData['private_with_bathroom_total'] ; ?></td>
    </tr>

    <tr>
        <td>४</td>
        <td>बाथरूमसह डबल बेडचा कक्ष</td>
        <td><?php echo $unserData['double_bed_with_bathroom_rate']; ?></td>
        <td><?php echo $unserData['double_bed_with_bathroom_days']; ?></td>
        <td><?php echo $unserData['double_bed_with_bathroom_total']; ?></td>
    </tr>

    <tr>
        <td>५</td>
        <td>बाथरूमसह वातानुकूलीत कक्ष</td>
        <td><?php echo $unserData['air_conditionar_with_bathroom_rate']; ?></td>
        <td><?php echo $unserData['air_conditionar_with_bathroom_days']; ?></td>
        <td><?php echo $unserData['air_conditionar_with_bathroom_total']; ?></td>
    </tr>
    
    <?php if(!empty($icuRate)){ ?>
    <tr>
        <td>६</td>
        <td>अतिदक्षता कक्ष</td>
        <td><?php echo $icuRate; ?></td>
        <td><?php echo $icuQty; ?></td>
        <td><?php echo $icuTotal; ?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($icuWithVentiRate)){ ?>
    <tr>
        <td>७</td>
        <td>अतिदक्षता कक्ष (आय.सी.यु)</td>
        <td><?php echo $icuWithVentiRate; ?></td>
        <td><?php echo $icuWithVentiQty; ?></td>
        <td><?php echo $icuWithVentiTotal; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="4" style="text-align: center;">Total</td>
        <td><?php 
        echo $unserData['total_amount'] ; ?></td>
    </tr>
</table>
<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center" style="padding-top: 40px;">
  <tr>
        <td colspan="5" style="float: right;"><strong> वैद्यकीय अधिकाऱ्याची स्वाक्षरी <br> व रुग्णालयाचा शिक्का</strong> </td>
    </tr>
</table>


<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center">
    <tr>
        <td>----------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
    </tr>
</table>

<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center">
    <tr>
        <td style="text-align: center;"><h3><u>अति आवश्यक  प्रमाणपत्र</u></h3></td>
    </tr>
    <tr>
        <td><p>श्री / श्रीमती / कुमारी 

            <?php echo $patient['Patient']['lookup_name']; ?> यांना 

            <?php echo $this->Session->read('facility'); ?> या रूग्णालयात 

            <?php echo $admission_date; ?> रोजी तपास असता, त्यांचावर तातडीने 

            <?php echo $unserData['diagnosis']; ?> 

            या कारणासाठी उपचार करण्यासाठी रूग्णालयात दाखल करणे आवश्यक  होते.</p>

            <p>
                प्रमााणित करण्यात येते की, 
                <?php echo $patient['Patient']['lookup_name'];; ?>

                यांना रूग्णलयात अति तात्काळ रित्या दाखल केले असता शश्त्रक्रियेकरिता  / उपचाराकरिता आवश्यक  असलेली साधने/ उपकरण/ साहित्य ही त्यांचेकरिता आवश्यक  होती ( उदा :— डिस्पोसेल सिरींज, व आयव्ही ) व ती त्यांनाच वापरली असून त्याचा पुन्हा उपयोग होत नाही अथवा केला जात नाही. तसेच, त्यांना दिलेल्या औषधांमध्ये मादक पदार्थ, अल्कोहोल, प्रथिने अन्नघटक (शक्तिवर्धक) या औषधांचा समावेश  करण्यात आलेला नाही 
            </p>
        </td>
    </tr>

</table>

<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center" style="padding-top: 40px;">
  <tr>
        <td colspan="5" style="float: right;"><strong> वैद्यकीय अधिकाऱ्याची स्वाक्षरी <br> व रुग्णालयाचा शिक्का</strong> </td>
    </tr>
</table>

                    