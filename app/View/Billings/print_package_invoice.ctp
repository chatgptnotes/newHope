<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset();

$website=$this->Session->read("website.instance");
if($website=='kanpur')
  $marginLeft="0px";
else
  $marginLeft="0px";
?>
<title>
</title>
  <?php echo $this->Html->css(array('internal_style.css')); ?>
  <style>
    body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#E7EEEF;}

 
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
  

  
 @page{
  size: auto;   
  margin-top: 37mm;
 }


 

  </style>
  <style>
  .print_form{
    background:none;
    font-color:black;
    color:#000000;
    /*min-height:800px;*/
  }
  .formFull td{
    color:#000000;
  }
  .tabularForm {
      background:#000;
  }
  .tabularForm td {
      background: #ffffff;
      color: #333333;
      font-size: 13px;
      padding: 5px 8px;
  }
  

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
</head>
<!-- onload="javascript:window.print();" -->
<body class="print_form" >

<!-- <div>&nbsp;</div> --> 

 
<table width="200" style="float:right">
  <tr>
    <td align="right">
    <div id="printButton"><?php 

    echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
    ?>
    
    <?php echo $this->Html->link('Generate Excel',array('controller'=>'billings',
        'action'=>'print_package_invoice',$patient['Patient']['id'],'?'=>array('type'=>'excel')),array('escape' => false,'class'=>'blueBtn'));?>  
    </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

  
 <?php if($getClaimId[0]['PatientCovidPackage']['claim_id']){ ?>
<table width="98%" border="0" cellspacing="0" cellpadding="5" class="boxBorder" align="center">
  <tr>
    <td align="center">
       <strong> CLAIM ID :- <?php echo $getClaimId[0]['PatientCovidPackage']['claim_id']; ?></strong>
    </td>
  </tr>
</table>
<?php } ?>
<table width="98%" border="0" cellspacing="0" cellpadding="5" class="boxBorder" align="center">
      <thead>
        <tr>
          <th><table width="100%" border="0" cellspacing="0" cellpadding="5" class="">
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
            
            
            </table></strong></th>
        </tr>
      </thead>
      
      <tbody>
        <table width="98%" border="0" cellspacing="0" cellpadding="5" class="boxBorder" align="center">
          <tr>
              <td width="2%"  align="center" class="tdBorderRtBt"><strong>SR.NO</strong></td>      
              <td width="40%" align="center" class="tdBorderRtBt"><strong>ITEM</strong></td>
              <td width="20%" align="center" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
              <td width="14%" align="center" class="tdBorderRtBt"><strong>MAHARASHTRA GOVT. ANNEXURE-C SCHEDULE OF RATES FOR COVID PATIENTS. </strong></td>
              <td width="14%" align="center" class="tdBorderRtBt"><strong>QTY.</strong></td>
              <td width="14%" align="center" class="tdBorderBt tdBorderRt"><strong>AMOUNT</strong></td>
          </tr>
          
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"></td>
            <td class="tdBorderRtBt"><strong>Conservative Treatment</strong> <!-- <br><?php echo "(".date('d/m/Y',strtotime($patient['Patient']['form_received_on']))." To ".date('d/m/Y',strtotime($patient['Patient']['discharge_date'])).")" ?> --></td>
             <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center" valign="top"></td>      
            <td class="tdBorderRtBt" align="right" valign="top"></td>
          </tr>
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"><strong> i.</strong></td>
            <td class="tdBorderRtBt"><strong>Package for accommodation, Isolation, oxygen, ventilator , etc</strong></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center" valign="top"></td>      
            <td class="tdBorderRtBt" align="right" valign="top"></td>
          </tr>
        
          <?php foreach ($customArray as $key => $value) { 

            if($value['PatientCovidPackage']['package_cost'] == '4000'){
              $description = "Charges for Routine Ward + Isolation.( This includes - Monitoring and basic Investigations, Drugs, Consultations, Bed charges, nursing charges, meals procedures like ryles tube insertion, urinary tract Catherization)";
            }else if($value['PatientCovidPackage']['package_cost'] == '7500'){
               $description = "Charges for room/accomodation with critical care services +O2 + Isolation. ( This includes - Monitoring and basic Investigations, basic Drugs, Consultations, Bed charges, nursing charges, meals procedures like ryles tube insertion, urinary tract Catherization)";
            }else if($value['PatientCovidPackage']['package_cost'] == '9000'){
               $description = "Charges for room/accomodation with critical care services  with ventilator + isolation( This includes - Monitoring and basic Investigations,basic Drugs, Consultations, Bed charges, nursing charges, meals procedures like ryles tube insertion, urinary tract Catherization)";
            }


            ?>

          <?php //if($key == '4000'){ ?>
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"></td>
            <td class="tdBorderRtBt"><?php echo $description; ?></td>
            <td class="tdBorderRtBt" align="left"><?php echo date('d/m/Y',strtotime($value['PatientCovidPackage']['package_start_date']))." To ".date('d/m/Y',strtotime($value['PatientCovidPackage']['package_end_date'])); ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $packageCost = $value['PatientCovidPackage']['package_cost'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $packageDays = $value['PatientCovidPackage']['package_days'] ; ?></td>      
            <td class="tdBorderRtBt" align="right"><strong><?php $packageTotal = $packageCost * $packageDays ; 
                                       echo round($packageTotal);
                                       $packageTotalCost +=$packageTotal;
         ; ?></strong></td>
          </tr>
           <?php //} ?>

           <?php /*if($key == '7500'){ ?>
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
           <?php } */ ?>

        <?php } ?>
          <?php 


          if(!empty($value['PatientCovidPackage']['ppe_unit_cost'])) { ?>
         <tr class="page-break">
            <td class="tdBorderRtBt" align="center" valign="top"><strong> ii)</strong></td>
            <td class="tdBorderRtBt"><strong>PPE</strong></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"><?php echo $ppeRate = $value['PatientCovidPackage']['ppe_unit_cost'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $ppeQty = $ppeCount ; ?></td>      
            <td class="tdBorderRtBt" align="right"><strong><?php  $ppeTotal = $ppeRate * $ppeQty ; 
                      echo round($ppeTotal);
            ?></strong></td>
          </tr>
          <?php } ?>

          <?php /*
           $i= 1 ;
           $ppTotal = 0 ;
          foreach ($customArray as $key => $value) {
            if(!empty($value['PatientCovidPackage']['ppe_unit_cost'])){
            ?>
           <tr>
             <td class="tdBorderRtBt" align="center" valign="top"><strong> <?php if($i == 1){ echo "ii)" ; } ?></strong></td>
            <td class="tdBorderRtBt"><strong>PPE</strong></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"><?php echo $ppeRate = $value['PatientCovidPackage']['ppe_unit_cost'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $ppeQty = $value['PatientCovidPackage']['ppe_count']; ?></td>         
            <td class="tdBorderRtBt" align="right"><strong><?php $ppTotal =$ppeRate * $ppeQty ;  
                                                         echo round($ppTotal);
                                                         $ppeTotal += $ppTotal;
         ; ?></strong></td>
          </tr>
        <?php $i++; } } */ ?>

          <?php 
           $i= 1 ;
           $visitTotal = 0 ;
          foreach ($customArray as $key => $value) {
            if(!empty($value['PatientCovidPackage']['doctor_visiting_charge'])){
            ?>

        
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"> <strong><?php if($i == 1){ echo "iii)" ; } ?></strong></td>
            <td class="tdBorderRtBt"><strong>Super Specialist Visit charges</strong></td>
            <td class="tdBorderRtBt" align="left"><?php echo "Dr.".$value['User']['first_name']." ".$value['User']['last_name']; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $visitCharge = $value['PatientCovidPackage']['doctor_visiting_charge'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php echo $visitDays = $value['PatientCovidPackage']['no_of_visit'] ; ?></td>      
            <td class="tdBorderRtBt" align="right"><strong><?php $visitTotal = $visitCharge * $visitDays ; 
                                                         echo round($visitTotal);
                                                         $totalVisitCharge += $visitTotal;
         ; ?></strong></td>
          </tr>
        <?php $i++; } } ?>

         <?php 
           /*$i= 1 ;
           $labTotal = 0;
          foreach ($labDataArray as $key => $value) {*/ ?>

        <?php if(!empty($labDataArray[0][0]['totalAmount'])) { ?>
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"> <strong><?php echo "iv)" ?></strong></td>
            <td class="tdBorderRtBt"><strong>Blood Investigation testing to be done as per actual cost as per direction 10. </strong></td>
            <td class="tdBorderRtBt" align="left"><?php //echo $key ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $labRate = $value['amount'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $labCount = $value['lab_count'] ; ?></td>      
            <td class="tdBorderRtBt" align="right"><strong><?php $labTotal = $labDataArray[0][0]['totalAmount'] ; 
                                       echo round($labTotal);
                                        $totalLabCharge = $labTotal;
         ; ?></strong></td>
          </tr>
        <?php  } ?>

        <?php if(!empty($pharmacySaleData[0][0]['pharmacyTotal'])) { ?>

          <tr>
            <td class="tdBorderRtBt" align="center" valign="top"><strong> v)</strong></td>
            <td class="tdBorderRtBt"><strong>High end drugs <!-- like immunoglobulins, Meropenem, Parentral Nutrition, Tocilizumab. etc - --> to be charged at MRP <!-- as per direction 10. --></strong></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"></td>
            <td class="tdBorderRtBt" align="center"></td>      
            <td class="tdBorderRtBt" align="right"><strong><?php  $pharmaTotal = $pharmacySaleData[0][0]['pharmacyTotal'] - $pharmacyReturnCharges[0]['sumTotal'] ; 
                                  echo round($pharmaTotal);
            ?></strong></td>
          </tr>
        <?php } ?>
          <?php 
          /* $i= 1 ;
           $radTotal= 0;
          foreach ($radDataArray as $key => $value) {*/ ?>

        <?php if(!empty($radDataArray[0][0]['totalAmount'])) { ?>
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"> <strong><?php echo "vi)" ; ?></strong></td>
            <td class="tdBorderRtBt"><strong>High end investigations like CT Scan, MRI, PET scan - to be charged at rack rates of hospital as on 31st 2019. </strong></td>
            <td class="tdBorderRtBt" align="left"><?php //echo $key ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $radRate = $value['amount'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $radCount = $value['rad_count'] ; ?></td>      
            <td class="tdBorderRtBt" align="right"><strong><?php $radTotal = $radDataArray[0][0]['totalAmount'] ; ; 
                                 echo round($radTotal);
                                                          $totalRadCharge = $radTotal;
         ; ?></strong></td>
          </tr>
        <?php } ?>

        <?php if(!empty($clinicalServices[0][0]['totalAmount'])) { ?>
           <tr>
            <td class="tdBorderRtBt" align="center" valign="top"> <strong><?php echo "vii)" ; ?></strong></td>
            <td class="tdBorderRtBt"><strong>Interventional Procedures like, but not limited to Central Line Insertion, Chemoport Insertion, bronchoscopic procedures, biopsies, ascitic/pleural tapping, etc. which may be charged at the rack rate as on 31st Dec 2019.. </strong></td>
            <td class="tdBorderRtBt" align="left"><?php //echo $key ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $radRate = $value['amount'] ; ?></td>
            <td class="tdBorderRtBt" align="center"><?php //echo $radCount = $value['rad_count'] ; ?></td>      
            <td class="tdBorderRtBt" align="right"><strong><?php $clinicalCharge = $clinicalServices[0][0]['totalAmount'] ; ; 
                           echo round($clinicalCharge);
                                                          $totalclinicalCharge = $clinicalCharge;
         ; ?></strong></td>
          </tr>
      <?php } ?>

          <?php $totalBillAmount = $packageTotalCost + $ppeTotal + $totalVisitCharge + $totalLabCharge + $pharmaTotal + $totalRadCharge + $totalclinicalCharge;  ?>
          <tr>
            <td class="tdBorderRt" align="center">&nbsp;</td>
            <td class="tdBorderRt" align="center">&nbsp;</td>
            <td class="tdBorderRt" align="center">&nbsp;</td>
            <td class="tdBorderRt" align="center">&nbsp;</td>      
            <td class="tdBorderRt" align="center">&nbsp;</td>
            <td class="tdBorderRt" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="tdBorderTpRt">&nbsp;</td>
            <td align="center" class="tdBorderTpRt" colspan="4"><strong>TOTAL BILL AMOUNT</strong></td>
            
            <td align="right" class="tdBorderTp totalPrice tdBorderRt"><strong><span class="WebRupee"></span><?php echo $this->Number->currency(round($totalBillAmount)); ?></strong></td>
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
      </tbody>

      <tfoot>
        <tr>
          <td>
            <table width="98%" border="0" cellspacing="0" cellpadding="5" align="center" class="boxBorder">
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
      </tfoot>
    </table>
 

 

</body>
</html>
