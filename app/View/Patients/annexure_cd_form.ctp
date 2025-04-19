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
.TextRight{text-align: right;}
</style> 

<style>
            .header{text-align: center;margin-top:10px;text-decoration: underline;}
            .para{text-align: center;}
            .name{margin-left: 30px;}
            .paragraph{margin-left: 30px;word-spacing: 50px;}   
            #cols{margin-left: 20px; }
        </style>

<div class="Row inner_title" style="float: left; width: 100%; clear:both">
        <div style="font-size: 20px; font-family: verdana; color: darkolivegreen;" >             
            <?php echo "Annexure C & D" ;?>
        </div>
    <span>
    <?php echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px')); ?>
    <?php if($stayData['AnnexureCDDetail']['id'] !='') { 
        echo $this->Html->link(__('Print Preview'),'#',
             array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'annexure_cd_form',$patient['Patient']['id'],'print'))."', '_blank',
                   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
    
    }?>
    </span>
</div>


<p class="ht5"></p> 


<?php
echo $this->Form->create('AnnexureCDDetail',array('type' => 'file','id'=>'ClaimSubmitForm','inputDefaults' => array(
        'label' => false,
        'div' => false,
        'error' => false,
        'legend'=>false,
        'fieldset'=>false
)
));
echo $this->Form->hidden('id',array('id'=>'recId','value'=>$stayData['AnnexureCDDetail']['id'],'autocomplete'=>"off"));
echo $this->Form->hidden('patient_id',array('id'=>'patientId','value'=>$patient['Patient']['id'],'autocomplete'=>"off"));


$admission_date = $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),false);
$discharge_date= $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),false);

$annexCdata = unserialize($stayData['AnnexureCDDetail']['annexure_c_detail']);
$annexDdata = unserialize($stayData['AnnexureCDDetail']['annexure_d_detail']);

$duration = $admission_date."-".$discharge_date ;
?>


<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
    <tr>
        <td style="text-align: center;"><h3><u>CERTIFICATE FORM 'C'</u></h3></td>
    </tr>

    <tr>
        <td style="text-align: center;"><h4>Certificate of expenses for emergency medical treatment of a Government Servant in Private Hospital<br>(To be issued by attending private practitioners)</h4></td>
    </tr>
    <tr>
        <td>   

            <p style="line-height: 2"> 
                This is to certify that, Shri/Smt 
                <?php echo $this->Form->input('AnnexureC.patient_name',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['lookup_name']));; ?> 
                address 
                <?php echo $this->Form->input('AnnexureC.address',array('type'=>'text','label'=>false,'div'=>false,'value'=>strip_tags($formatted_address))); ?> 

                employed in the

                <?php echo $this->Form->input('AnnexureC.designation',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['designation'])); ?>

                <?php echo $this->Form->input('AnnexureC.name_police_station',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['name_police_station'])); ?>

                was treated by the 
                <?php echo $this->Form->input('AnnexureC.trated_by',array('type'=>'text','label'=>false,'div'=>false,'value'=>$annexCdata['trated_by'])); ?> 

                at 

               <?php echo $this->Form->input('AnnexureC.hospital_name',array('type'=>'text','label'=>false,'div'=>false,'value'=>$this->Session->read('facility'))); ?>

                w.e.f 

                <?php echo $this->Form->input('AnnexureC.admission_date',array('type'=>'text','label'=>false,'div'=>false,'class'=>'admission_date','value'=>$admission_date)); ?>
                to

                <?php echo $this->Form->input('AnnexureC.discharge_date',array('type'=>'text','label'=>false,'div'=>false,'class'=>'discharge_date','value'=>$discharge_date)); ?>


                as emergency patient for the complaints of Vital Sign observed 

                <?php echo $this->Form->input('AnnexureC.vital_sign',array('type'=>'text','label'=>false,'div'=>false,'value'=>$annexCdata['vital_sign'])); ?> 

                Necessary emergency investigation

                <?php echo $this->Form->input('AnnexureC.investigation',array('type'=>'text','label'=>false,'div'=>false,'value'=>$annexCdata['investigation'])); ?> 

                with results

                <?php echo $this->Form->input('AnnexureC.result',array('type'=>'text','label'=>false,'div'=>false,'value'=>$annexCdata['result'])); ?> 

                The Diagnosis was 

                <?php echo $this->Form->input('AnnexureC.diagnosis',array('type'=>'text','label'=>false,'div'=>false,'value'=>$annexCdata['diagnosis'])); ?> 
            </p>

           <p>Total expenditure (Annexure D) incurred for the treatment was Rs.<?php echo $this->Form->input('AnnexureC.total_expenditure',array('type'=>'text','label'=>false,'div'=>false,'value'=>$annexCdata['total_expenditure'])); ?> and details of which are given in form ‘D’</p>

           <p>Certified that after the emergency treatment the patient was advised to attend authorized Medical (Authority) attend for treatment.</p>


            </td>
    </tr>

</table>

<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
    <tr>
        <td>Place </td>
        <td> <?php echo $this->Form->input('AnnexureC.place',array('type'=>'text','label'=>false,'div'=>false,'value'=>$annexCdata['place'])); ?></td>
    </tr>
    <tr>
        <td>Date </td>
        <td> <?php echo $this->Form->input('AnnexureC.date',array('type'=>'text','label'=>false,'div'=>false,'class'=>'admit_date','value'=>$annexCdata['date'])); ?></td>
    </tr>
</table>
 <hr>


<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
   <tr>
        <td style="text-align: center;"><h3><u>CERTIFICATE FORM 'D'</u></h3></td>
    </tr>

    <tr>
        <td style="text-align: center;"><h4>Certificate with details of expenses for emergency medical treatment to government employee in a private hospital <br>
        (To be filled in by the doctor and to be attached to certificate ‘C’)</h4></td>
    </tr>
</table>

<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
    <tr>
        <td>
           Name of Patient :- 
        </td>
        <td>
            <?php echo $this->Form->input('AnnexureD.lookup_name',array('type'=>'text','label'=>false,'div'=>false,'value'=>$patient['Patient']['lookup_name']));; ?>
        </td>
    </tr>
    <tr>
        <td>
           Date of Admission :- 
        </td>
        <td>
            <?php echo $this->Form->input('AnnexureD.date_of_admission',array('type'=>'text','label'=>false,'class'=>'admission_date','div'=>false,'value'=>$admission_date));; ?>
        </td>
    </tr>
    <tr>
        <td>
           Date of Discharge  :- 
        </td>
        <td>
            <?php echo $this->Form->input('AnnexureD.date_of_discharge',array('type'=>'text','label'=>false,'class'=>'discharge_date','div'=>false,'value'=>$discharge_date));; ?>
        </td>
    </tr>
    <tr>
        <td>
           Hospital Registration No :- 
        </td>
        <td>
            <?php echo $this->Form->input('AnnexureD.hospital_reg_no',array('type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['hospital_reg_no']));; ?>
        </td>
    </tr>
</table>

<table class="" border="1" cellpadding="3" cellspacing="1" width="60%" align="center">
    <tr>
        <td><strong>A.</strong></td>
        <td><strong>SERVICES</strong></td>
        <td><strong>RATE</strong></td>
        <td><strong>QTY</strong></td>
        <td><strong>AMOUNT</strong></td>
    </tr>
    <tr>
            <td>1)</td>
            <td>Consultancy Charges</td>
            <!-- <td><?php echo $this->Form->input('AnnexureD.consultancy_rate',array('id'=>'rate_1','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['consultancy_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.consultancy_qty',array('id'=>'qty_1','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['consultancy_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.consultancy_charges',array('id'=>'amount_1','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['consultancy_charges']));; ?></td> -->
            <td></td>
             <td></td>
              <td></td>
    </tr>
    <?php foreach ($customArray as $key => $value) { 

                $totalPackageCost = $key * $value['PatientCovidPackage']['package_days'] ; 
            ?>

         <tr>
            <td></td>
            <td></td>
            <td><?php echo $this->Form->input('AnnexureD.package_rate_'.$key,array('id'=>'rate_'.$key,'class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$key));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.package_qty_'.$key,array('id'=>'qty_'.$key,'class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$value['PatientCovidPackage']['package_days']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.package_amount_'.$key,array('id'=>'amount_'.$key,'class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$totalPackageCost));; ?></td>
         </tr>
             
         <?php } ?>
     <tr>
            <td>2)</td>
            <td>Indoor Charges from 
                <?php echo $this->Form->input('AnnexureD.indoor_from',array('type'=>'text','label'=>false,'div'=>false,'value'=>$admission_date));; ?> to 
                <?php echo $this->Form->input('AnnexureD.indoor_to',array('type'=>'text','label'=>false,'div'=>false,'value'=>$discharge_date));; ?></td>

            <td><?php echo $this->Form->input('AnnexureD.indoor_rate',array('id'=>'rate_2','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['indoor_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.indoor_qty',array('id'=>'qty_2','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['indoor_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.indoor_charges',array('id'=>'amount_2','class'=>'amount TextRight','type'=>'text ','label'=>false,'div'=>false,'value'=>$annexDdata['indoor_charges']));; ?></td>
     </tr>

    

        <tr>
            <td>3)</td>
            <td>Operation Charges </td>
            <td><?php echo $this->Form->input('AnnexureD.operation_rate',array('id'=>'rate_3','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['operation_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.operation_qty',array('id'=>'qty_3','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['operation_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.operation_charges',array('id'=>'amount_3','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['operation_charges']));; ?></td>
        </tr>

  
        <tr>
            <td>4)</td>
            <td>Operation Theatre Charges </td>
             <td><?php echo $this->Form->input('AnnexureD.operation_theater_rate',array('id'=>'rate_4','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['operation_theater_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.operation_theater_qty',array('id'=>'qty_4','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['operation_theater_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.operation_theater_charges',array('id'=>'amount_4','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['operation_theater_charges']));; ?></td>
        </tr>
  
  
        <tr>
            <td>5)</td>
            <td>Anesthesia Charges </td>
            <td><?php echo $this->Form->input('AnnexureD.anaesthesia_rate',array('id'=>'rate_5','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['anaesthesia_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.anaesthesia_qty',array('id'=>'qty_5','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['anaesthesia_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.anaesthesia_charges',array('id'=>'amount_5','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['anaesthesia_charges']));; ?></td>
        </tr>

         
        <tr>
            <td>6)</td>
            <td>Visit  </td>
            <td></td>
        </tr>


        <tr>       
            <td></td>
            <td>a) Routine No  </td>
            <td><?php echo $this->Form->input('AnnexureD.routine_rate',array('id'=>'rate_6','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['routine_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.routine_qty',array('id'=>'qty_6','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['routine_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.routine_charge',array('id'=>'amount_6','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['routine_charge']));; ?></td>
        </tr>

        <tr>
               <td></td>
            <td>b) Special </td>
            <td><?php echo $this->Form->input('AnnexureD.special_rate',array('id'=>'rate_7','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['special_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.special_qty',array('id'=>'qty_7','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['special_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.special_charge',array('id'=>'amount_7','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['special_charge']));; ?></td>
        </tr>


        <tr>
            <td>7)</td>
            <td>Bedside Procedures </td>
            <td><?php echo $this->Form->input('AnnexureD.bedside_rate',array('id'=>'rate_8','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['bedside_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.bedside_qty',array('id'=>'qty_8','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['bedside_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.bedside_procedure',array('id'=>'amount_8','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['bedside_procedure']));; ?></td>
        </tr>


         
        <tr>
            <td>8)</td>
            <td>Registration Charges   </td>
            <td><?php echo $this->Form->input('AnnexureD.registration_rate',array('id'=>'rate_9','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['registration_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.registration_qty',array('id'=>'qty_9','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['registration_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.registration_charges',array('id'=>'amount_9','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['registration_charges']));; ?></td>
        </tr>

    
        
        <tr>
            <td>9)</td>
            <td> Investigations</td>
            <td></td>
        </tr>


        <tr>
           <td></td>
            <td>a) Pathology test  </td>
            <td><?php echo $this->Form->input('AnnexureD.pathology_rate',array('id'=>'rate_10','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['pathology_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.pathology_qty',array('id'=>'qty_10','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['pathology_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.pathology_charges',array('id'=>'amount_10','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$labDataArray[0][0]['totalAmount']));; ?></td>
        </tr>

         <tr>
           <td></td>
            <td>b) X ray Radiography </td>
            <td><?php echo $this->Form->input('AnnexureD.radiology_rate',array('id'=>'rate_11','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['radiology_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.radiology_qty',array('id'=>'qty_11','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['radiology_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.radiology_charges',array('id'=>'amount_11','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$radDataArray[0][0]['totalAmount']));; ?></td>
         </tr>

         <tr>
            <td></td>
            <td>c) ECG  </td>
            <td><?php echo $this->Form->input('AnnexureD.ecg_rate',array('id'=>'rate_12','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['ecg_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.ecg_qty',array('id'=>'qty_12','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['ecg_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.ecg_charges',array('id'=>'amount_12','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['ecg_charges']));; ?></td>
         </tr>

         <tr>
            <td></td>
            <td>d) Others</td>
            <td><?php echo $this->Form->input('AnnexureD.other_rate',array('id'=>'rate_13','class'=>'rate','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['other_rate']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.other_qty',array('id'=>'qty_13','class'=>'qty','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['other_qty']));; ?></td>
            <td><?php echo $this->Form->input('AnnexureD.other_charges',array('id'=>'amount_13','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['other_charges']));; ?></td>
         </tr>

         

         <tr>
            <td><strong>B.</strong></td>
            <td colspan="3"><strong>MEDICINE</strong></td>
            <td><strong>AMOUNT</strong></td>
        </tr>

        <tr>
            <td><strong>Sr. No</strong></td>
            <td colspan="3"><strong>Name of the Medicines</strong></td>
            <td><strong>Cost of Medicine</strong></td>
        </tr>

        <tr>
            <td>A</td>
            <td colspan="3">Pharmacy</td>
            <td><?php echo $this->Form->input('AnnexureD.pharmacy_charges',array('id'=>'amount_14','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>round($pharmacySaleData[0][0]['pharmacyTotal'])));; ?></td>
        </tr>

        <tr>
            <td>B</td>
            <td colspan="3">Consumables</td>
             <td><?php echo $this->Form->input('AnnexureD.consumables_charges',array('id'=>'amount_15','class'=>'amount TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['consumables_charges']));; ?></td>
        </tr>
     
        <tr>
            <td colspan="4"><strong>GRAND TOTAL (A + B)</strong></td>
            <td><?php echo $this->Form->input('AnnexureD.grand_total',array('id'=>'grand_total','class'=>'TextRight','type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['grand_total']));; ?></td>
        </tr>


</table>


<table class="" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
    <tr>
        <td>Place </td>
        <td> <?php echo $this->Form->input('AnnexureD.place',array('type'=>'text','label'=>false,'div'=>false,'value'=>$annexDdata['place'])); ?></td>
    </tr>
    <tr>
        <td>Date </td>
        <td> <?php echo $this->Form->input('AnnexureD.date',array('type'=>'text','label'=>false,'div'=>false,'class'=>'admit_date','value'=>$annexDdata['date'])); ?></td>
    </tr>
</table>

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
    
    $(".admission_date").datepicker({
      // showOn: "both",
      // buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
       // buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
       dateFormat:'<?php echo $this->General->GeneralDate();?>'
        
    });

    $(".discharge_date").datepicker({
      //  showOn: "both",
       // buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
      //  buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate();?>'
        
    });

    $(".admit_date").datepicker({
       // showOn: "both",
       // buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
       // buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate();?>'
        
    });


    $(document).on('keyup','.rate,.qty',function(){
        var id = $(this).attr('id').split('_')[1];
        var rate = ($('#rate_'+id).val()) ? $('#rate_'+id).val() : 0 ;
        var days = ($('#qty_'+id).val()) ? $('#qty_'+id).val() : 0 ;

        var total = rate *  days ;

        $('#amount_'+id).val(total);
        tot = 0;
        $( ".amount" ).each(function( index ) {  
            var amnt = (parseFloat($(this).val())) ? parseFloat($(this).val()) : 0 ;
            tot += amnt ; 
        });
      
        if(!isNaN(tot)){
            $("#grand_total").val(tot);
        }else{
            $("#grand_total").val('');
        }
        
    });


    tot = 0;
    $( ".amount" ).each(function( index ) {  
            var amnt = (parseFloat($(this).val())) ? parseFloat($(this).val()) : 0 ;
            tot += amnt ; 
        });
    console.log(tot);   
    if(!isNaN(tot)){
        $("#grand_total").val(tot);
    }else{
        $("#grand_total").val('');
    }



    

});


</script>