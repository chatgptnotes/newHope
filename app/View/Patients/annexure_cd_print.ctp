<style>
    

@media print {
        #printButton{display:none;}
         .printbreak {
            page-break-after:  always;
        }

        div.page
      {
        page-break-after: always;
        page-break-inside: avoid;
      }
    }

    .printbreak {
        page-break-after:  always;
    }

    @page {
    size: auto;
    /*width: 94%;*/
    margin-left: auto;
    margin-right: auto;
    margin-top: 17%;
    /* content: "Page " counter(page) " of " counter(pages); */
    
}
.TextRight{text-align: right;}
.TextCenter{text-align: center;}

</style>

<div style="float:right;" id="printButton">
    <?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
  
<?php

$admission_date = $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),false);
$discharge_date= $this->DateFormat->formatDate2Local($patient['Patient']['discharge_date'],Configure::read('date_format'),false);

$annexCdata = unserialize($stayData['AnnexureCDDetail']['annexure_c_detail']);
$annexDdata = unserialize($stayData['AnnexureCDDetail']['annexure_d_detail']);

$duration = $admission_date."-".$discharge_date ;

?>

<div class="page">
<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center">
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
                <?php echo $patient['Patient']['lookup_name']; ?> 
                address 
                <?php echo strip_tags($formatted_address); ?> 

                employed in the

                <?php echo $patient['Patient']['designation']; ?>

                <?php echo $patient['Patient']['name_police_station']; ?>

                was treated by the 
                <?php echo $annexCdata['trated_by']; ?> 

                at 

               <?php echo $this->Session->read('facility'); ?>

                w.e.f 

                <?php echo $admission_date; ?>
                to

                <?php echo $discharge_date; ?>


                as emergency patient for the complaints of Vital Sign observed 

                <?php echo $annexCdata['vital_sign']; ?> 

                Necessary emergency investigation

                <?php echo $annexCdata['investigation']; ?> 

                with results

                <?php echo $annexCdata['result']; ?> 

                The Diagnosis was 

                <?php echo $annexCdata['diagnosis']; ?> 
            </p>

           <p>Total expenditure (Annexure D) incurred for the treatment was Rs.<?php echo $annexCdata['total_expenditure'] ; ?> and details of which are given in form ‘D’</p>

           <p>Certified that after the emergency treatment the patient was advised to attend authorized Medical (Authority) attend for treatment.</p>


            </td>
    </tr>

</table>

<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center" style="padding-top: 60px;">
    <tr>
        <td>Place :  <?php echo $annexCdata['place'] ; ?> </td>
        <td style="float: right;">Signature of Medical Officer</td>
    </tr>
    <tr>
        <td>Date : <?php echo $annexCdata['date'] ; ?> </td>
        <td style="float: right;"> ( Hospital Stamp) </td>
    </tr>
</table>
</div>

<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center">
   <tr>
        <td style="text-align: center;"><h3><u>CERTIFICATE FORM 'D'</u></h3></td>
    </tr>

    <tr>
        <td style="text-align: center;"><h4>Certificate with details of expenses for emergency medical treatment to government employee in a private hospital <br>
        (To be filled in by the doctor and to be attached to certificate ‘C’)</h4></td>
    </tr>
</table>

<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center">
    <tr>
        <td>
           Name of Patient :- 
        </td>
        <td>
            <?php echo $patient['Patient']['lookup_name'];; ?>
        </td>
    </tr>
    <tr>
        <td>
           Date of Admission :- 
        </td>
        <td>
            <?php echo $admission_date;; ?>
        </td>
    </tr>
    <tr>
        <td>
           Date of Discharge  :- 
        </td>
        <td>
            <?php echo $discharge_date;; ?>
        </td>
    </tr>
    <tr>
        <td>
           Hospital Registration No :- 
        </td>
        <td>
            <?php echo $annexDdata['hospital_reg_no'];; ?>
        </td>
    </tr>
</table>

<table class="" border="1" cellpadding="3" cellspacing="1" width="100%" align="center">
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
                <!--   <td class="TextRight"><?php echo $annexDdata['consultancy_rate'] ; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['consultancy_qty'] ; ?></td>
            <td class="TextRight"><?php echo $annexDdata['consultancy_charges'] ; ?></td> -->
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
            <td class="TextRight"><?php echo $key; ?></td>
            <td class="TextCenter"><?php echo $value['PatientCovidPackage']['package_days'];; ?></td>
            <td class="TextRight"><?php echo $totalPackageCost;; ?></td>
         </tr>
             
         <?php } ?>
     <tr>
            <td>2)</td>
            <td>Indoor Charges from 
                <?php echo $admission_date ;  ?> to 
                <?php echo $discharge_date ; ?></td>

            <td class="TextRight"><?php echo $annexDdata['indoor_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['indoor_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['indoor_charges']; ?></td>
     </tr>

    

        <tr>
            <td>3)</td>
            <td>Operation Charges </td>
            <td class="TextRight"><?php echo $annexDdata['operation_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['operation_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['operation_charges']; ?></td>
        </tr>

  
        <tr>
            <td>4)</td>
            <td>Operation Theatre Charges </td>
            <td class="TextRight"><?php echo $annexDdata['operation_theater_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['operation_theater_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['operation_theater_charges']; ?></td>
        </tr>
  
  
        <tr>
            <td>5)</td>
            <td>Anesthesia Charges </td>
            <td class="TextRight"><?php echo $annexDdata['anaesthesia_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['anaesthesia_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['anaesthesia_charges']; ?></td>
        </tr>

         
        <tr>
            <td>6)</td>
            <td>Visit  </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>


        <tr>       
            <td></td>
            <td>a) Routine No  </td>
            <td class="TextRight"><?php echo $annexDdata['routine_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['routine_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['routine_charge']; ?></td>
        </tr>

        <tr>
               <td></td>
            <td>b) Special </td>
            <td class="TextRight"><?php echo $annexDdata['special_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['special_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['special_charge']; ?></td>
        </tr>


        <tr>
            <td>7)</td>
            <td>Bedside Procedures </td>
            <td class="TextRight"><?php echo $annexDdata['bedside_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['bedside_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['bedside_procedure']; ?></td>
        </tr>


         
        <tr>
            <td>8)</td>
            <td>Registration Charges   </td>
            <td class="TextRight"><?php echo $annexDdata['registration_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['registration_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['registration_charges']; ?></td>
        </tr>

    
        
        <tr>
            <td>9)</td>
            <td> Investigations</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>


        <tr>
           <td></td>
            <td>a) Pathology test  </td>
            <td class="TextRight"><?php echo $annexDdata['pathology_rate'];; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['pathology_qty']; ?></td>
            <td class="TextRight"><?php echo $labDataArray[0][0]['totalAmount']; ?></td>
        </tr>

         <tr>
           <td></td>
            <td>b) X ray Radiography </td>
            <td class="TextRight"><?php echo $annexDdata['radiology_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['radiology_qty']; ?></td>
            <td class="TextRight"><?php echo $radDataArray[0][0]['totalAmount']; ?></td>
         </tr>

         <tr>
            <td></td>
            <td>c) ECG  </td>
            <td class="TextRight"><?php echo $annexDdata['ecg_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['ecg_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['ecg_charges']; ?></td>
         </tr>

         <tr>
            <td></td>
            <td>d) Others</td>
            <td class="TextRight"><?php echo $annexDdata['other_rate']; ?></td>
            <td class="TextCenter"><?php echo $annexDdata['other_qty']; ?></td>
            <td class="TextRight"><?php echo $annexDdata['other_charges']; ?></td>
         </tr>

         

         <tr>
            <td><strong>B.</strong></td>
            <td colspan="3"><strong>MEDICINE</strong></td>
            <td></td>
        </tr>

        <tr>
            <td><strong>Sr. No</strong></td>
            <td colspan="3"><strong>Name of the Medicines</strong></td>
            <td></td>
        </tr>

        <tr>
            <td>A</td>
            <td colspan="3">Pharmacy</td>
            <td class="TextRight"><?php echo round($pharmacySaleData[0][0]['pharmacyTotal']);; ?></td>
        </tr>

        <tr>
            <td>B</td>
            <td colspan="3">Consumables</td>
             <td class="TextRight"><?php echo $annexDdata['consumables_charges']; ?></td>
        </tr>

        <tr>
            <td colspan="4" style="text-align: center;"><strong>GRAND TOTAL (A + B)</strong></td>
            <td class="TextRight"><?php echo number_format($annexDdata['grand_total']) ;; ?></td>
        </tr>
       
</table>


<table class="" border="0" cellpadding="3" cellspacing="1" width="100%" align="center" style="padding-top: 60px;">
    <tr>
        <td>Place  : <?php echo $annexDdata['place']; ?></td>
        <td style="float: right;"> Signature of Medical Officer  </td>
    </tr>
    <tr>
        <td>Date : <?php echo $annexDdata['date']; ?></td>
        <td style="float: right;">( Hospital Stamp) </td>
    </tr>
</table>

                    