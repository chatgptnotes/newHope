<?php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Covid_Package_Excel_".$patient['Patient']['lookup_name'].".xls" );
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>

  <style>
    

 
    .boxBorder{border:1px solid #3E474A;}
    .boxBorderBot{border-bottom:1px solid #3E474A;}
    .boxBorderRight{border-right:1px solid #3E474A;}
    .tdBorderRtBt{border-right:1px solid #3E474A; border-bottom:1px solid #3E474A;}
    .tdBorderBt{border-bottom:1px solid #3E474A;}
    .tdBorderTp{border-top:1px solid #3E474A;}
    .tdBorderRt{border-right:1px solid #3E474A;}
    .tdBorderTpBt{border-bottom:1px solid #3E474A; border-top:1px solid #3E474A;}
    .tdBorderTpRt{border-top:1px solid #3E474A; border-right:1px solid #3E474A;}
    .columnPad{padding:5px;}
    .columnLeftPad{padding-left:5px;}
    .tbl{background:#CCCCCC;}
    .tbl td{background:#FFFFFF;}
    .totalPrice{font-size:14px;}
    .adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}

  
  </style>

<body class="print_form" >


 <?php #debug($diagnosisData); ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="fullTbl" class="boxBorder headerInfo">
  <thead>
    <tr>
      <td>  
          <table style="" width="100%" border="0" cellspacing="0" cellpadding="5" align="center" >
            
              <?php if($getClaimId[0]['PatientCovidPackage']['claim_id']){ ?>
              <tr>
                  <td width="100%" align="center" valign="top" class="heading" id="tblHead">
                     <strong> MPKAY CLAIM ID :- <?php echo $getClaimId[0]['PatientCovidPackage']['claim_id']; ?></strong>
                  </td>
                </tr>
              <?php } ?>   
            <tr>
              <td  width="100%" align="center" valign="top" class="heading" id="tblHead"><strong><?php echo 'COVID-19: PATIENT BILL';?></strong></td>
            </tr>
            <tr>
              <td  width="100%" align="right" valign="top" class="heading" id="tblHead"><strong><?php echo '<b>DATE : '.date('d-m-Y').'</b>';?></strong></td>
            </tr>
            <tr>
              <td width="100%" align="center" valign="top" class="heading" id="tblHead">
            
                <table border="0" cellspacing="0" cellpadding="5" class="">
                  <tr>
                    <td width="48%" valign="top" align="left">BILL NO </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo $billNumber;?></td>
                  </tr>
                  <tr>
                    <td width="48%" valign="top" align="left">REGISTRATION NO </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo $patient['Patient']['admission_id'];?></td>
                  </tr>
                   <tr>
                    <td width="48%" valign="top" align="left">NAME OF PATIENT </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo $patient['Patient']['lookup_name'];?></td>
                  </tr>
                   <tr>
                    <td width="48%" valign="top" align="left">AGE </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo $age;?></td>
                  </tr>
                   <tr>
                    <td width="48%" valign="top" align="left">SEX </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo ucfirst($patient['Person']['sex']);?></td>
                  </tr>
                  <?php if(!empty($patient['Patient']['name_of_ip'])) { ?>
                   <tr>
                    <td width="48%" valign="top" align="left">NAME OF EMPLOYEE </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo $patient['Patient']['name_of_ip'];?></td>
                  </tr>
                  <?php } ?>
                  <?php if(!empty($patient['Patient']['designation'])) { ?>
                   <tr>
                    <td width="48%" valign="top" align="left">DESIGNATION </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo $patient['Patient']['designation'];?></td>
                  </tr>
                  <?php } ?>
                  <?php if(!empty($patient['Patient']['relation']) && !empty($patient['Patient']['name_of_ip'])) { ?>
                   <tr>
                    <td width="48%" valign="top" align="left">RELATION WITH MAIN MEMBER </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo ucfirst($patient['Patient']['relation']);?></td>
                  </tr>
                  <?php } ?>
                  <?php if(!empty($patient['Patient']['mobile_phone'])) { ?>
                   <tr>
                    <td width="48%" valign="top" align="left">CONTACT NO. </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo $patient['Patient']['mobile_phone'];?></td>
                  </tr>
                  <?php } ?>
                  <?php if(!empty($patient['Patient']['non_executive_emp_id_no'])) { ?>
                   <tr>
                    <td width="48%" valign="top" align="left">EMPLOYEE CODE </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo $patient['Patient']['non_executive_emp_id_no'];?></td>
                  </tr>
                  <?php } ?>
                  <?php if(!empty($patient['Patient']['sponsor_company'])) { ?>
                   <tr>
                    <td width="48%" valign="top" align="left">UNIT NAME </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo $patient['Patient']['sponsor_company'];?></td>
                  </tr>
                  <?php } ?>
                 
                   <tr>
                    <td width="48%" valign="top" align="left">DATE OF ADMISSION  </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo date('d-m-Y',strtotime($patient['Patient']['form_received_on']));?></td>
                  </tr>
                    <?php if(!empty($patient['Patient']['discharge_date'])) { ?>
                   <tr>
                    <td width="48%" valign="top" align="left">DATE OF DISCHARGE  </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><?php echo date('d-m-Y',strtotime($patient['Patient']['discharge_date']));?></td>
                  </tr>
                  <?php } ?>
                   <tr>
                    <td width="48%" valign="top" align="left">DIAGNOSIS </td>
                    <td width="4%"  valign="top" align="center">:</td>
                    <td width="48%" valign="top" align="left"><strong><?php echo $diagnosisData['Diagnosis']['final_diagnosis'];?></strong></td>
                  </tr>
                  
                  
                  </table>
          
            </td>
        </tr>
      </table>
  </td>
</tr>
</thead>
  <tbody>
   
  <tr><td>  
  <table width="100%">
  
  <tr>
    <td width="100%" align="left" valign="top">
       <table width="100%" border="0" cellspacing="0" cellpadding="5" class="tdBorderTpBt">
          <tr>
              <td width="2%"  align="center" class="tdBorderRtBt"><strong>SR.NO</strong></td>      
              <td width="40%" align="center" class="tdBorderRtBt"><strong>ITEM</strong></td>
              <td width="20%" align="center" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
              <td width="14%" align="center" class="tdBorderRtBt"><strong>MPKAY NABH RATE / MAHARASHTRA GOVT. ANNEXURE-C SCHEDULE OF RATES FOR COVID PATIENTS. </strong></td>
              <td width="14%" align="center" class="tdBorderRtBt"><strong>QTY.</strong></td>
              <td width="14%" align="center" class="tdBorderRtBt"><strong>AMOUNT</strong></td>
          </tr>
          
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"></td>
            <td class="tdBorderRtBt"><strong>Conservative Treatment</strong> <br><?php echo "(".date('d/m/Y',strtotime($firstDate))." To ".date('d/m/Y',strtotime($lastDate)).")" ?></td>
             <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center" valign="top"></td>      
            <td class="tdBorderRtBt" align="center" valign="top"></td>
          </tr>
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"><strong> i.</strong></td>
            <td class="tdBorderRtBt"><strong>Consultation for Inpatients</strong></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center" valign="top"></td>      
            <td class="tdBorderRtBt" align="center" valign="top"></td>
          </tr>
        
          <?php foreach ($customArray as $key => $value) { ?>

          <?php if($key == '4000'){ ?>
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"></td>
            <td class="tdBorderRtBt">Charges for Routine Ward + Isolation.( This includes - Monitoring and basic Investigations, Drugs, Consultations, Bed charges, nursing charges, meals procedures like ryles tube insertion, urinary tract Catherization)</td>
            <td class="tdBorderRtBt" align="left"><?php echo date('d/m/Y',strtotime($value['PatientCovidPackage']['package_start_date']))." To ".date('d/m/Y',strtotime($value['PatientCovidPackage']['package_end_date'])); ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $packageCost = $key ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $packageDays = $value['PatientCovidPackage']['package_days'] ; ?></td>      
            <td class="tdBorderRtBt" align="center"><strong><?php $packageTotal1 = $packageCost * $packageDays ; 
                                                         echo number_format($packageTotal1,2);
         ; ?></strong></td>
          </tr>
           <?php } ?>

           <?php if($key == '7500'){ ?>
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"></td>
            <td class="tdBorderRtBt">Charges for room/accomodation with critical care services +O2 + Isolation. ( This includes - Monitoring and basic Investigations, basic Drugs, Consultations, Bed charges, nursing charges, meals procedures like ryles tube insertion, urinary tract Catherization)</td>
             <td class="tdBorderRtBt" align="left"><?php echo date('d/m/Y',strtotime($value['PatientCovidPackage']['package_start_date']))." To ".date('d/m/Y',strtotime($value['PatientCovidPackage']['package_end_date'])); ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $packageCost = $key ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $packageDays = $value['PatientCovidPackage']['package_days'] ; ?></td>      
            <td class="tdBorderRtBt" align="center"><strong><?php $packageTotal2 = $packageCost * $packageDays ; 
                                                          echo number_format($packageTotal2,2);

            ?></strong></td>
          </tr>
           <?php } ?>

           <?php if($key == '9000'){ ?>
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"></td>
            <td class="tdBorderRtBt">Charges for room/accomodation with critical care services  with ventilator + isolation( This includes - Monitoring and basic Investigations,basic Drugs, Consultations, Bed charges, nursing charges, meals procedures like ryles tube insertion, urinary tract Catherization)</td>
             <td class="tdBorderRtBt" align="left"><?php echo date('d/m/Y',strtotime($value['PatientCovidPackage']['package_start_date']))." To ".date('d/m/Y',strtotime($value['PatientCovidPackage']['package_end_date'])); ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $packageCost = $key ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $packageDays = $value['PatientCovidPackage']['package_days'] ; ?></td>      
            <td class="tdBorderRtBt" align="center"><strong><?php $packageTotal3 = $packageCost * $packageDays ; 
                                                          echo number_format($packageTotal3,2);

            ?></strong></td>
          </tr>
           <?php } ?>

        <?php } ?>

         <tr>
            <td class="tdBorderRtBt" align="center" valign="top"><strong> ii)</strong></td>
            <td class="tdBorderRtBt"><strong>PPE</strong></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"><?php echo $ppeRate = $value['PatientCovidPackage']['ppe_unit_cost'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $ppeQty = $ppeCount ; ?></td>      
            <td class="tdBorderRtBt" align="center"><strong><?php  $ppeTotal = $ppeRate * $ppeQty ; 
                                                                    echo number_format($ppeTotal,2);
            ?></strong></td>
          </tr>

          <?php 
           $i= 1 ;
           $visitTotal = 0 ;
          foreach ($customArray as $key => $value) {?>

        
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"> <strong><?php if($i == 1){ echo "iii)" ; } ?></strong></td>
            <td class="tdBorderRtBt"><strong>Super Specialist Visit charges</strong></td>
            <td class="tdBorderRtBt" align="left"><?php echo "Dr.".$value['User']['first_name']." ".$value['User']['last_name']; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $visitCharge = $value['PatientCovidPackage']['doctor_visiting_charge'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $visitDays = $value['PatientCovidPackage']['no_of_visit'] ; ?></td>      
            <td class="tdBorderRtBt" align="center"><strong><?php $visitTotal = $visitCharge * $visitDays ; 
                                                         echo number_format($visitTotal,2);
                                                         $totalVisitCharge += $visitTotal;
         ; ?></strong></td>
          </tr>
        <?php $i++; } ?>

         <?php 
           /*$i= 1 ;
           $labTotal = 0;
          foreach ($labDataArray as $key => $value) {*/ ?>

        
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"> <strong><?php echo "iv)" ?></strong></td>
            <td class="tdBorderRtBt"><strong>Blood Investigation testing to be done as per actual cost as per direction 10. </strong></td>
            <td class="tdBorderRtBt" align="left"><?php //echo $key ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $labRate = $value['amount'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $labCount = $value['lab_count'] ; ?></td>      
            <td class="tdBorderRtBt" align="center"><strong><?php $labTotal = $labDataArray[0][0]['totalAmount'] ; 
                                                         echo number_format($labTotal,2);
                                                          $totalLabCharge = $labTotal;
         ; ?></strong></td>
          </tr>
        <?php //$i++; } ?>

        

          <tr>
            <td class="tdBorderRtBt" align="center" valign="top"><strong> v)</strong></td>
            <td class="tdBorderRtBt"><strong>High end drugs like immunoglobulins, Meropenem, Parentral Nutrition, Tocilizumab. etc - to be charged at MRP as per direction 10.</strong></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"></td>      
            <td class="tdBorderRtBt" align="center"><strong><?php  $pharmaTotal = $pharmacySaleData[0][0]['pharmacyTotal'] ; 
                                                                          echo number_format($pharmaTotal,2);
            ?></strong></td>
          </tr>

         <?php 
          /* $i= 1 ;
           $radTotal= 0;
          foreach ($radDataArray as $key => $value) {*/ ?>

        
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"> <strong><?php echo "vi)" ; ?></strong></td>
            <td class="tdBorderRtBt"><strong>High end investigations like CT Scan, MRI, PET scan - to be charges at rack rates of hospital as on 31st 2019. </strong></td>
            <td class="tdBorderRtBt" align="left"><?php //echo $key ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $radRate = $value['amount'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $radCount = $value['rad_count'] ; ?></td>      
            <td class="tdBorderRtBt" align="center"><strong><?php $radTotal = $radDataArray[0][0]['totalAmount'] ; ; 
                                                         echo number_format($radTotal,2);
                                                          $totalRadCharge = $radTotal;
         ; ?></strong></td>
          </tr>
        <?php //$i++; } ?>

           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"> <strong><?php echo "vii)" ; ?></strong></td>
            <td class="tdBorderRtBt"><strong>Interventional Procedures like, but not limited to Central Line Insertion, Chemoport Insertion, bronchoscopic procedures, biopsies, ascitic/pleural tapping, etc. which may be charges at the rack rate as on 31st Dec 2019.. </strong></td>
            <td class="tdBorderRtBt" align="left"><?php //echo $key ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $radRate = $value['amount'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $radCount = $value['rad_count'] ; ?></td>      
            <td class="tdBorderRtBt" align="center"><strong><?php $clinicalCharge = $clinicalServices[0][0]['totalAmount'] ; ; 
                                                         echo number_format($clinicalCharge,2);
                                                          $totalclinicalCharge = $clinicalCharge;
         ; ?></strong></td>
          </tr>

          <?php $totalBillAmount = $packageTotal1 + $packageTotal2 + $packageTotal3 + $ppeTotal + $totalVisitCharge + $totalLabCharge + $pharmaTotal + $totalRadCharge + $totalclinicalCharge ;  ?>
          <tr>
            <td class="tdBorderRt" align="center">&nbsp;</td>
            <td class="tdBorderRt" align="center">&nbsp;</td>
            <td class="tdBorderRt" align="center">&nbsp;</td>
            <td class="tdBorderRt" align="center">&nbsp;</td>      
            <td class="tdBorderRt" align="center">&nbsp;</td>
            <td class="tdBorderRt" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="tdBorderTpRt">&nbsp;</td>
            <td align="center" class="tdBorderTpRt" colspan="4"><strong>TOTAL BILL AMOUNT</strong></td>
            
            <td align="right" class="tdBorderRtBt totalPrice tdBorderRtBt"><strong><span class="WebRupee"></span><?php echo $this->Number->currency(round($totalBillAmount)); ?></strong></td>
          </tr>

          <tr>
            <td align="right" class="tdBorderTpRt">&nbsp;</td>
            <td align="center" class="tdBorderTpRt" colspan="4"><strong>PAID AMOUNT</strong></td>
            
            <td align="right" class="tdBorderTp totalPrice tdBorderRt"><strong><span class="WebRupee"></span><?php echo $this->Number->currency(round($advanceAmount)); ?></strong></td>
          </tr>
          <tr>
            <td align="right" class="tdBorderTpRt">&nbsp;</td>
            <td align="center" class="tdBorderTpRt" colspan="4"><strong>BALANCE AMOUNT</strong></td>
            
            <td align="right" class="tdBorderTp totalPrice tdBorderRt"><strong><span class="WebRupee"></span><?php echo $this->Number->currency(round($totalBillAmount - $advanceAmount)); ?></strong></td>
          </tr>
        </table>
    </td>
  </tr>
  </table>
  </td></tr>
  <tr>
      <td width="100%" align="left" valign="top">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              
              <td width="45%" align="right" valign="bottom" class="columnPad tdBorderTp tdBorderRt">
                <strong><?php echo $this->Session->read('billing_footer_name');?></strong><br /><br /><br />
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="25%">Bill Manager</td>
                        <td width="25%">Cashier</td>
                        <td width="25%">Med.Supdt. </td>
                        <td width="25%" align="right">Authorised Signatory</td>
                    </tr>
                  </table>
              </td>
            </tr>
          </table>
      </td>
    </tr> 
  </tbody>
 
  
</table>

 
 

</body>

