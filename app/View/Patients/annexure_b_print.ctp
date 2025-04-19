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

$admission_date = $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),false);
$discharge_date= $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),false);

$unserData = unserialize($stayData['AnnexureBDetail']['annexure_detail']);
$duration = $admission_date."-".$discharge_date ;
?>


<div class="conatainer-fluid" style="text-align: center;">
<h2 class="header">परिशिष्ट -  ब  <br>( परिशिष्ट — एक )</h2>

<h4 class="header">केंद्र / राज्य शासकीय कर्मचारी आणि त्यांचे कुटुंबीय यांची वैद्यकीय देखभाल आणि / किंवा उपचार त्यांच्या संबंधात करण्यात आलेल्या वैद्यकीय खर्चाच्या परताव्याची मागणी करण्याकरीता करावयाच्या अर्जाचा नमुना</h4>
</div>
<?php //debug($unserData); ?>
<div class="container" >
    <div class="row">
      <table class="" border="1" cellpadding="3" cellspacing="1" width="100%" align="center">
            
            <tr>
                 <td class="container-sm-2">१.</td>
                 <td class="container-sm-6">शासकीय कर्मचाऱ्याचे नांव व पदनाम.</td>
                 <td class="container-sm-3"><?php echo $patient['Patient']['name_of_ip']; ?></td>
              </tr>
            

             <tr>
                 <td> २ .</td>
                 <td>कर्मचारी ज्या कार्यालयात नोकरीत आहे त्या कार्यालयाचे नांव.</td>
                 <td><?php echo $patient['Patient']['sponsor_company']; ?> </td>
             </tr>


             <tr>
                 <td>३ .</td>
                 <td>वित्तीय नियमांमध्ये व्याख्या केल्याप्रमाणे शासकीय कर्मचाऱ्याचे वेतन व इतर वित्तलब्धी स्वतंत्रपणे दर्षविण्यात याव्यात.</td>
                 <td><?php echo $unserData['employee_income']; ?> </td>
             </tr>

             <tr>
                 <td>४ .</td>
                 <td>कामाचे ठिकाण.</td>
                 <td><?php echo $patient['Patient']['name_police_station']; ?></td>
             </tr>
         

             <tr>
                 <td>५ .</td>
                 <td>प्रत्यक्ष निवासस्थानाचा पत्ता.</td>
                 <td><?php echo $address ; ?></td>

            </tr>

             <tr>
                 <td> ६ .</td>
                 <td>रूग्णाचे नांव आणि कर्मचाऱ्याशी त्यांचे / तिचे नाते <br>
                    ( टिप :— मुलाच्या बाबतीत वय सुध्दा नमूद करावे).
                 </td>
                 <td><?php echo $patient['Patient']['lookup_name'] ." ( ".$patient['Patient']['relation'] ." ) " ?> 
                    
                 </td>
               </tr>
          

             <tr>
                 <td>७ .</td>
                 <td>आजाराचे  स्वरूप् व कालावधी.</td>
                 <td><?php echo $duration ; ?></td>

            </tr>

             <tr>
                 <td>८ .</td>
                 <td>मागणी केलेल्या रकमेचा तपशील , वैद्यकीय देखभाल.</td>
                 <td><?php echo $unserData['hospital_bill'] ; ?></td>

            </tr>

             <tr>
                 <td></td>
                 <td>1) रोग लक्षणासाठी सल्ला देण्याची फी द्यावी
                 <td><?php echo $unserData['consultation_fees'] ; ?></td>

            </tr>
            <tr>
                <td></td>
                <td>अ) ज्या वैद्यकीय अधिकाऱ्याचा सल्ला घेतला असेल त्याचे नांव, पदनाम आणि ज्या रूग्णालयाचे किंवा दवाखान्याशी  
                            तो संबंधीत असेल तर रूग्णालयाचे किंवा दवाखान्याचे नांव.</td>
                <td><?php echo $unserData['consultation_doctor'] ; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>ब) किती वेळा सल्ला घेण्यात आला ती संख्या आणि तारखा आणि प्रत्येक सल्यासाठी दिलेली फी </td>
                <td><?php echo $unserData['consultation_duration']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>क) रूग्णालयाच्या  वैद्यकीय अधिकाऱ्यांचा रोग चिकीत्सा कक्षात (कन्सल्टींग रूम) सल्ला घेण्यात आला की, रूग्णाच्या निवासस्थानी सल्ला घेण्यात आला ते नमुद करावे</td>
                <td><?php echo $unserData['consultation_at_room'] ; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>2) रोग निदान करताना करण्यात आलेल्या त्या विकृती चिकीत्सा विषयक, अणुजीव शास्त्रीय , क्ष—किरण शाश्त्रिया किंवा इतर तत्सम चाचण्यासाठी करण्यात आलेली फी, त्यामध्ये पुढील गोष्टी नमुद करावयात  :—</td>
                <td><?php echo $unserData['consultation_details'] ; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>अ) ज्या रूग्णालयात किंवा प्रयोगशाळेत चाचण्या घेण्यात आल्या होत्या, त्या रुग्णालयाचे किंवा प्रयोगशाळेचे नांव</td>
                <td><?php echo $unserData['consultation_hospital_name'] ; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>ब) प्राधिकृत वैद्यकीय देखभाल अधिकाऱ्यांच्या  सल्लाने चाचणी घेण्यात आली होती किंवा घेण्यात आली असेल तर अशा अर्थाचे प्रमणपत्र सोबत जोडावे.</td>
                <td><?php echo $unserData['consultation_tests'] ; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>3) बाजारातून खरेदी केलेल्या औषधांचा खर्च (औषधांची सूची व पावत्या जोडाव्यात). विशेषज्ञाला किंवा प्राधिकृत वैद्यकीय देखभाल अधिकाऱ्याव्यमिरिक्त एखाद्या अन्य वैद्यकीय अधिकाऱ्याला देण्यात आलेली फी त्यामध्ये पुढील गोष्टी दर्षवाव्यात.</td>
                <td><?php echo $unserData['consultation_pharmacy_detail'] ; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>अ) ज्याचा सल्ला घेण्यात आला असेल त्या विशेषज्ञाचे किंवा वैद्यकीय अधिकाऱ्याचे नांव व पदनाम व तो ज्या रूग्णालयाषी संलग्न असेल त्या रूग्णालयाचे नांव.</td>
                <td><?php echo $unserData['consultation_doctor_detail']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>ब) किती वेळा सल्ला घेण्यात आला ती संख्या व जेव्हा सल्ला घेण्यात आला ती तारीख व प्रत्येक सल्ल्यासाठी आकारण्यात आलेली फी.</td>
                <td><?php echo $unserData['consultation_time_date'] ; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>क) सल्ला रूग्णालयात किंवा विशेषक्षाच्या किंवा वैद्यकीय अधिकाऱ्याच्या रोग चिकीत्साकक्षात (कन्सल्टींग रूम) किंवा रूग्णाच्या निवासस्थानी घेण्यात आला होता किंवा कसे.</td>
                <td><?php echo $unserData['consultation_tests_details'] ; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>ड) ड) त्या प्रांताच्या मुख्य प्रशासकीय वैद्यकीय अधिकाऱ्यांचा पूर्व मान्यतेने व सल्ल्याने विशेषज्ञाचा किंवा वैद्यकीय अधिकाऱ्याचा सल्ला घेण्या आला होता किंवा कसे, तसा सल्ला घेण्यात आला असेल तर अशा  अर्थाचे प्रमाणपत्र जोडावे.</td>
                <td><?php echo $unserData['consultation_at_home'] ; ?></td>
            </tr>

             <tr>
                 <td>९ .</td>
                 <td>मागणी केलेली एकूण रक्कम.</td>
                 <td><?php echo $unserData['total_hospital_bill'] ; ?></td>

            </tr>

             <tr>
                 <td>१०.</td>
                 <td>सहपत्रांची यादी</td>
                 <td><?php echo $unserData['other_document'] ; ?></td>

            </tr>

             <tr>
                 <td>११.</td>
                 <td>कुटुंबातील व्यक्तींची संख्या म्हणजेच 15/08/1968 रोजी आणि त्यानंतर जिवंत असलेली मुले.</td>
                 <td><?php echo $unserData['family_info']; ?></td>

            </tr>
      
</table>

<div class="container" style="text-align: center;">
    <h4>कर्मचाऱ्याने सही करून द्यावयाचे प्रतिज्ञापत्र<br>
      मी याद्वारे जाहीर करतो / करते की, या अर्जामध्ये केलेली निवेदने माझ्या संपूर्ण माहितीप्रमाणे विश्वासाप्रमाणे खरी असुन ज्या <br>व्यक्तीवर वैद्यकीय खर्च करण्यात आला ती व्यक्ती पूर्णपणे माझ्यावर अवलंबून आहे ( लागू नसलेले खोडावे).</h4>
</div>




<div class="container" style="text-align: right;padding-top: 20px;" >
    <h4>शासकीय कर्मचाऱ्याची सही व दिनांक </h4>
</div>

</div>
</div>
    
</body>

			        