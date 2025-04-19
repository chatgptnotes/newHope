<style>

.message{
    
    font-size: 15px;
}
.table_format {
    padding: 3px !important;
    width: 60%;
}
.rowClass td{
     background: none repeat scroll 0 0 #ffcccc!important;
}

#patient-info-box{
    display: none;
    position: absolute;
    right: 0;
    left:992px;
    top: 34px;
    z-index: 29;
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #000000;
    border-radius: 3px;
    box-shadow: 0 0 3px 2px #000;
    margin-top: -1px;
    padding: 6px;
    width: 400px;
    font-size:13px;
    list-style-type: none;
    
}
 .row_format th{
     background: #d2ebf2 none repeat scroll 0 0 !important;
    border-bottom: 1px solid #3e474a;
    color: #31859c !important;
    font-size: 12px;
    padding: 3px;
    text-align: center;
 }
 .row_format td{
    padding: 1px;
 }
  
.row_format tr:nth-child(even) {background: #CCC}
.row_format tr:nth-child(odd) {background: #e7e7e7} 
</style> 

<div class="Row inner_title" style="float: left; width: 100%; clear:both">
        <div style="font-size: 20px; font-family: verdana; color: darkolivegreen;" >             
            <?php echo "Annexure B" ;?>
        </div>
    <span>
    <?php echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px')); ?>
    <?php if($stayData['AnnexureBDetail']['id'] !='') { 
        echo $this->Html->link(__('Print Preview'),'#',
             array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'annexure_b',$patient['Patient']['id'],'print'))."', '_blank',
                   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
    
    }?>
    </span>
</div>


<p class="ht5"></p> 


<?php
echo $this->Form->create('AnnexureBDetail',array('type' => 'file','id'=>'ClaimSubmitForm','inputDefaults' => array(
        'label' => false,
        'div' => false,
        'error' => false,
        'legend'=>false,
        'fieldset'=>false
)
));
echo $this->Form->hidden('id',array('id'=>'recId','value'=>$stayData['AnnexureBDetail']['id'],'autocomplete'=>"off"));
echo $this->Form->hidden('patient_id',array('id'=>'patientId','value'=>$patient['Patient']['id'],'autocomplete'=>"off"));


$admission_date = $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),false);
$discharge_date= $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),false);

$unserData = unserialize($stayData['AnnexureBDetail']['annexure_detail']);
$duration = $admission_date."-".$discharge_date ;



$treatingPhysician = $patient['User']['first_name']." ".$patient['User']['last_name'] ; 
$hospitalname = $this->Session->read('facility').", Nagpur";


$combineTreatingAndStay = $treatingPhysician." / ".$hospitalname ;
?>

<!DOCTYPE html>
<html>
<head>
  
<style>
    .header{text-align: center}
</style>


</head>
<body>
 
 <div class="conatainer-fluid">
<h2 class="header">परिशिष्ट -  ब </h2>
<h3 class="header">( परिशिष्ट — एक )</h3>
<h4 class="header">केंद्र / राज्य शासकीय कर्मचारी आणि त्यांचे कुटुंबीय यांची वैद्यकीय देखभाल आणि / किंवा उपचार त्यांच्या संबंधात करण्यात आलेल्या वैद्यकीय खर्चाच्या परताव्याची मागणी करण्याकरीता करावयाच्या अर्जाचा नमुना</h4>
</div>
<?php //debug($patient); ?>
<div class="container" >
    <div class="row">
      <table class="" border="1" cellpadding="3" cellspacing="1" width="100%" align="center">
            
            <tr>
                 <td class="container-sm-2">१.</td>
                 <td class="container-sm-6">शासकीय कर्मचाऱ्याचे नांव व पदनाम.</td>
                 <td class="container-sm-3"><?php echo $this->Form->input('Annexure.name_of_employee',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['name_of_ip'])) ?></td>
              </tr>
            

             <tr>
                 <td> २ .</td>
                 <td>कर्मचारी ज्या कार्यालयात नोकरीत आहे त्या कार्यालयाचे नांव.</td>
                 <td><?php echo $this->Form->input('Annexure.company',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['sponsor_company'])); ?> </td>
             </tr>


             <tr>
                 <td>३ .</td>
                 <td>वित्तीय नियमांमध्ये व्याख्या केल्याप्रमाणे शासकीय कर्मचाऱ्याचे वेतन व इतर वित्तलब्धी स्वतंत्रपणे दर्षविण्यात याव्यात.</td>
                 <td><?php echo $this->Form->input('Annexure.employee_income',array('type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['employee_income'])); ?> </td>
             </tr>

             <tr>
                 <td>४ .</td>
                 <td>कामाचे ठिकाण.</td>
                 <td><?php echo $this->Form->input('Annexure.name_police_station',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['name_police_station'])); ?></td>
             </tr>
         

             <tr>
                 <td>५ .</td>
                 <td>प्रत्यक्ष निवासस्थानाचा पत्ता.</td>
                 <td><?php echo $this->Form->input('Annexure.address',array('type'=>'text','label'=>false,'div'=>false,'value'=>$address)); ?></td>

            </tr>

             <tr>
                 <td> ६ .</td>
                 <td>रूग्णाचे नांव आणि कर्मचाऱ्याशी त्यांचे / तिचे नाते <br>
                    ( टिप :— मुलाच्या बाबतीत वय सुध्दा नमूद करावे).
                 </td>
                 <td><?php echo $this->Form->input('Annexure.patient_name',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['lookup_name'])); ?> <br>
                    <?php echo $this->Form->input('Annexure.relation',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['relation'])); ?>
                 </td>
               </tr>
          

             <tr>
                 <td>७ .</td>
                 <td>आजाराचे  स्वरूप् व कालावधी.</td>
                 <td><?php echo $this->Form->input('Annexure.treatment_duration',array('type'=>'text','label'=>false,'div'=>false,'value'=>$duration)); ?></td>

            </tr>

             <tr>
                 <td>८ .</td>
                 <td>मागणी केलेल्या रकमेचा तपशील , वैद्यकीय देखभाल.</td>
                 <td><?php echo $this->Form->input('Annexure.hospital_bill',array('type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['hospital_bill'])); ?></td>

            </tr>

             <tr>
                 <td></td>
                 <td>1) रोग लक्षणासाठी सल्ला देण्याची फी द्यावी
                 <td><?php echo $this->Form->input('Annexure.consultation_fees',array('type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['consultation_fees'])); ?></td>

            </tr>
            <tr>
                <td></td>
                <td>अ) ज्या वैद्यकीय अधिकाऱ्याचा सल्ला घेतला असेल त्याचे नांव, पदनाम आणि ज्या रूग्णालयाचे किंवा दवाखान्याशी  
                            तो संबंधीत असेल तर रूग्णालयाचे किंवा दवाखान्याचे नांव.</td>
                <td><?php echo $this->Form->input('Annexure.consultation_doctor',array('type'=>'text','label'=>false,'div'=>false,'value'=>$combineTreatingAndStay)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>ब) किती वेळा सल्ला घेण्यात आला ती संख्या आणि तारखा आणि प्रत्येक सल्यासाठी दिलेली फी </td>
                <td><?php echo $this->Form->input('Annexure.consultation_duration',array('type'=>'text','label'=>false,'div'=>false,'value'=>'जोडलेले आहे')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>क) रूग्णालयाच्या  वैद्यकीय अधिकाऱ्यांच्या  रोग चिकीत्सा कक्षात (कन्सल्टींग रूम) सल्ला घेण्यात आला की, रूग्णाच्या निवासस्थानी सल्ला घेण्यात आला ते नमुद करावे</td>
                <td><?php echo $this->Form->input('Annexure.consultation_at_room',array('type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['consultation_at_room'])); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>2) रोग निदान करताना करण्यात आलेल्या त्या विकृती चिकीत्सा विषयक, अणुजीव शास्त्रीय , क्ष—किरण शाश्त्रिया किंवा इतर तत्सम चाचण्यासाठी करण्यात आलेली फी, त्यामध्ये पुढील गोष्टी नमुद करावयात :—</td>
                <td><?php echo $this->Form->input('Annexure.consultation_details',array('type'=>'text','label'=>false,'div'=>false,'value'=>'जोडलेले आहे')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>अ) ज्या रूग्णालयात किंवा प्रयोगशाळेत चाचण्या घेण्यात आल्या होत्या, त्या रुग्णालयाचे किंवा प्रयोगशाळेचे नांव</td>
                <td><?php echo $this->Form->input('Annexure.consultation_hospital_name',array('type'=>'text','label'=>false,'div'=>false,'value'=>$combineTreatingAndStay)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>ब) प्राधिकृत वैद्यकीय देखभाल अधिकाऱ्याच्या सल्लाने चाचणी घेण्यात आली होती किंवा घेण्यात आली असेल तर अशा अर्थाचे प्रमणपत्र सोबत जोडावे.</td>
                <td><?php echo $this->Form->input('Annexure.consultation_tests',array('type'=>'text','label'=>false,'div'=>false,'value'=>'जोडलेले आहे')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>3) बाजारातून खरेदी केलेल्या औषधांचा खर्च (औषधांची सूची व पावत्या जोडाव्यात). विशेषज्ञाला किंवा प्राधिकृत वैद्यकीय देखभाल अधिकाऱ्याव्यमिरिक्त एखाद्या अन्य वैद्यकीय अधिकाऱ्याला देण्यात आलेली फी त्यामध्ये पुढील गोष्टी दर्षवाव्यात.</td>
                <td><?php echo $this->Form->input('Annexure.consultation_pharmacy_detail',array('type'=>'text','label'=>false,'div'=>false,'value'=>'जोडलेले आहे')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>अ) ज्याचा सल्ला घेण्यात आला असेल त्या विशेषज्ञाचे किंवा वैद्यकीय अधिकाऱ्याचे नांव व पदनाम व तो ज्या रूग्णालयाषी संलग्न असेल त्या रूग्णालयाचे नांव.</td>
                <td><?php echo $this->Form->input('Annexure.consultation_doctor_detail',array('type'=>'text','label'=>false,'div'=>false,'value'=>$combineTreatingAndStay)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>ब) किती वेळा सल्ला घेण्यात आला ती संख्या व जेव्हा सल्ला घेण्यात आला ती तारीख व प्रत्येक सल्ल्यासाठी आकारण्यात आलेली फी.</td>
                <td><?php echo $this->Form->input('Annexure.consultation_time_date',array('type'=>'text','label'=>false,'div'=>false,'value'=>'जोडलेले आहे')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>क) सल्ला रूग्णालयात किंवा विशेषक्षाच्या किंवा वैद्यकीय अधिकाऱ्याच्या रोग चिकीत्साकक्षात (कन्सल्टींग रूम) किंवा रूग्णाच्या निवासस्थानी घेण्यात आला होता किंवा कसे.</td>
                <td><?php echo $this->Form->input('Annexure.consultation_tests_details',array('type'=>'text','label'=>false,'div'=>false,'value'=>'जोडलेले आहे')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>ड) त्या प्रांताच्या मुख्य प्रशासकीय वैद्यकीय अधिकाऱ्यांचा पूर्व मान्यतेने व सल्ल्याने विशेषज्ञाचा किंवा वैद्यकीय अधिकाऱ्याचा सल्ला घेण्या आला होता किंवा कसे, तसा सल्ला घेण्यात आला असेल तर अशा  अर्थाचे प्रमाणपत्र जोडावे.</td>
                <td><?php echo $this->Form->input('Annexure.consultation_at_home',array('type'=>'text','label'=>false,'div'=>false,'value'=>'जोडलेले आहे')); ?></td>
            </tr>

             <tr>
                 <td>९ .</td>
                 <td>मागणी केलेली एकूण रक्कम.</td>
                 <td><?php echo $this->Form->input('Annexure.total_hospital_bill',array('type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['total_hospital_bill'])); ?></td>

            </tr>

             <tr>
                 <td>१०.</td>
                 <td>सहपत्रांची यादी</td>
                 <td><?php echo $this->Form->input('Annexure.other_document',array('type'=>'text','label'=>false,'div'=>false,'value'=>'जोडलेले आहे')); ?></td>

            </tr>

             <tr>
                 <td>११.</td>
                 <td>कुटुंबातील व्यक्तींची संख्या म्हणजेच 15/08/1968 रोजी आणि त्यानंतर जिवंत असलेली मुले.</td>
                 <td><?php echo $this->Form->input('Annexure.family_info',array('type'=>'text','label'=>false,'div'=>false,'value'=>$unserData['family_info'])); ?></td>

            </tr>
      
</table>

<div class="container" style="text-align: center;">
    <h4>कर्मचाऱ्याने सही करून द्यावयाचे प्रतिज्ञापत्र<br>
      मी याद्वारे जाहीर करतो / करते की, या अर्जामध्ये केलेली निवेदने माझ्या संपूर्ण माहितीप्रमाणे विश्वासाप्रमाणे खरी असुन ज्या <br>व्यक्तीवर वैद्यकीय खर्च करण्यात आला ती व्यक्ती पूर्णपणे माझ्यावर अवलंबून आहे ( लागू नसलेले खोडावे).</h4>
</div>




<div class="container" style="text-align: right;">
    <h4>शासकीय कर्मचाऱ्याची सही व दिनांक </h4>
</div>

</div>
</div>
    
</body>
</html>
<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
    <tr>
        <td><?php   
                echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false,'id'=>'saveBtn','style'=>'float:right'));?></td>
    </tr>
</table>
<?php echo $this->Form->end();?>
        

<script>
$(document).ready(function(){

    // binds form submission and fields to the validation engine
    $(document).on('click',"#saveBtn",function(){
        var validateForm = $("#ClaimSubmitForm").validationEngine('validate');

        if (validateForm == true)
        {
            $("#saveBtn").hide();
        }else{

            $("#saveBtn").show();
            return false;
        }

    });
    
    $("#admission_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
       dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
    });

    $("#discharge_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
    });

    $("#admit_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
    });


    

});


</script>