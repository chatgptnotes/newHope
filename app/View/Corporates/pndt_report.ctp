<?php 
#pr($finalBillingData);exit;
#echo $totalWardCharges;exit;
?>
<?php //debug($patient['Patient']['tariff_standard_id']);?>
<style>
	body{padding:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000;}
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
<table width="800" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;" align="center">
<tr>
     <td>&nbsp;</td>
</tr>

<tr><td align="right">
<?php 
echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
		  	
   ?>
</td>
</tr>
<tr>
    <td width="100%" align="center" valign="top" class="heading" style="font-size: 16px;"><u><strong><?php 
    echo 'PRECONCEPTION AND PRENATAL DIAGNOSTIC TECHNIQUES'.'<br>'.'(PROHIBITION OF SEX SELECTION) ACT 1994';
    ?></strong></u></td>
  </tr>
  <tr>
      <td style="font-size: 16px; height: 30px; padding-bottom: 0px " align="center"><strong>Monthly Reporting format for Genetic Counseling Center/Laboratory/Clinic/Combined</strong></td>
  </tr>
</table>
 <?php echo $this->Form->create();
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" >
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
        <table width="800" border="0" cellspacing="0" cellpadding="5" id="ExtraRow">
  <tr>
    <td width="10%" align="left" valign="top" style="font-size: 14px;">Month :</td>
    <td width="20%" class="tdBorderBt"></td>
    <td width="10%" align="left" valign="top" style="font-size: 14px;">Year :</td>
    <td class="tdBorderBt"></td>
  </tr>
 
  <tr>
    <td width="50%" align="left" valign="top" style="font-size: 14px;">Name of the Genetic Counseling Center/Laboratory/Clinic : </td>
    <td class="tdBorderBt"></td>
  </tr>
  <tr>
    <td></td>
  </tr>
 
  <tr>
    <td width="20%" align="left" valign="top" style="font-size: 14px;">Registration No. :</td>
   
   
 </tr>
 <td width="30%" align="left" valign="top" style="font-size: 14px;">Time to Rectification :</td>
 <tr>
 
 </tr>
 
 <tr>
 <td></td>
 </tr>

 
	</table>
    </td>
  </tr>
 
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="5" class="tdBorderTpBt">
          <thead>
          <tr >
            <td align="center" valign="center" class="tdBorderBt" style="font-size: 14px; width: 25px">1.</td>
            <td align="left" valign="center" class="tdBorderBt" height="60px" style="font-size: 14px;">Total No. of Patients : <table class="boxBorder" valign="center" align="right" cellspacing="0" cellpadding="0"><tr><td width="145px" height="25px" >&nbsp;</td></tr></table></td>
            <td align="left" valign="center" class="tdBorderRtBt" width="88px" height="60px" style="font-size: 14px;">&nbsp</td>
           
            <td align="left" valign="center" class="tdBorderBt" colspan="3" height="60px" width="50px" style="font-size: 14px;">
                      <table class="boxBorder" cellspacing="0" cellpadding="0" width="80%"> 
                               <tr >
                                  <td class="tdBorderRtBt" style="font-size: 14px;text-align: center" width="130px" >From Maharashtra</td>
                                  <td class="tdBorderBt" width="110px">&nbsp;</td> </tr>
                               <tr class="boxBorder">
                                   <td class="tdBorderRt" style="font-size: 14px;text-align: center">From Other States</td>
                                   <td>&nbsp;</td></tr> 
                     </table>
            </td>
            
             </tr>
             <tr >
              <td align="center" valign="center" class="tdBorderBt" style="font-size: 14px; width: 25px">2.</td>
            <td align="left" valign="center" class="tdBorderBt" colspan="5" height="60px" style="font-size: 14px;">Issuewise Break up of the patients :
                      <table class="boxBorder" cellspacing="0" cellpadding="0" width="60%" padding-top="10px"> 
                               <tr >
                                  <td class="tdBorderRtBt" style="font-size: 14px;text-align: left;padding-left: 5px" width="130px" >0 Issue</td>
                                  <td class="tdBorderRtBt" width="80px">&nbsp;</td> 
                                  <td class="tdBorderRtBt" style="font-size: 14px;text-align: left;padding-left: 5px" width="130px">2 or 2 + Males</td>
                                  <td class="tdBorderBt" width="80px">&nbsp;</td>
                               </tr>
                               <tr>
                                   <td class="tdBorderRtBt" style="font-size: 14px;text-align: left;padding-left: 5px" width="130px">Only 1 Male</td>
                                   <td class="tdBorderRtBt">&nbsp;</td>
                                   <td class="tdBorderRtBt" style="font-size: 14px;text-align: left;padding-left: 5px">2 or 2 + Females</td>
                                   <td class="tdBorderBt">&nbsp;</td>
                               </tr> 
                               <tr >
                                  <td class="tdBorderRt" style="font-size: 14px;text-align: left;padding-left: 5px" width="130px" >Only 1 Female</td>
                                  <td class="tdBorderRt">&nbsp;</td> 
                                  <td class="tdBorderRt" style="font-size: 14px;text-align: left;padding-left: 5px">Others</td>
                                  <td >&nbsp;</td>
                               </tr>
                     </table>
            
            </td>
             </tr>
             <tr >
             <td align="center" valign="center" class="tdBorderBt" style="font-size: 14px; width: 25px">3.</td>
            <td align="left" valign="center" class="tdBorderBt" colspan="5" height="60px" style="font-size: 14px;">Age-wise Break up of the patients : 
            <table class="boxBorder" cellspacing="0" cellpadding="0" width="60%" padding-top="10px"> 
                              
                               <tr>
                                   <td class="tdBorderRtBt" style="font-size: 14px;text-align: left;padding-left: 5px" width="135px">Less than 18 years</td>
                                   <td class="tdBorderRtBt" width="80px">&nbsp;</td>
                                   <td class="tdBorderRtBt" style="font-size: 14px;text-align: left;padding-left: 5px" width="135px" >30-35 Years</td>
                                   <td class="tdBorderBt">&nbsp;</td>
                               </tr> 
                               <tr >
                                  <td class="tdBorderRt" style="font-size: 14px;text-align: left;padding-left: 5px" >18-30 Years</td>
                                  <td class="tdBorderRt">&nbsp;</td> 
                                  <td class="tdBorderRt" style="font-size: 14px;text-align: left;padding-left: 5px">Above 30 Years</td>
                                  <td >&nbsp;</td>
                               </tr>
                     </table>
            
            </td>
             </tr>
          <tr><td></td></tr>
          <tr >
            <td align="center" valign="center" class="tdBorderBt" style="font-size: 14px; width: 25px">4.</td>
            <td align="left" valign="center" class="tdBorderBt" colspan="5" style="font-size: 14px;">Indicators of Prenatal Diagnosis : </td>
            
            </tr>
            
             <tr>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px; width: 25px">S.No.</td>
            <td align="center" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;">Type of Indication</td>
            
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">During the Month</td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px; width: 120px">Progressive</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">A</td>
            
           <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;"><strong>PREVIOUS CHILD WITH</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
             </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">I</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;">Chromosomal disorder</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">II</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;">Metabolic Disorder</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">III</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;">Congenital anomaly</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">IV</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;">Mental retardation</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">V</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;">Haemoglobinopathy</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">VI</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;" >Sex linked Disorder</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">VII</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;">Malformation (Specify)</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">VIII</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;">Hereditary hemolytic anaemia</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">IX</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;">Any other</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">B</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;"><strong>ADVANCED MATERNAL AGE</strong></td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">C</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;"><strong>GENETIC DISEASE IN FATHER/MOTHER/SIBLING</strong></td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">D</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;text-align: left;"><strong>OTHER</strong></td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top"  style="font-size: 14px;" colspan="2" class="tdBorderBt">&nbsp;</td>
            </tr>
       
       <tr><td></td></tr>
        <tr >
            <td align="center" valign="center" class="tdBorderBt" style="font-size: 14px; width: 25px">5.</td>
            <td align="left" valign="center" class="tdBorderBt" colspan="5" style="font-size: 14px;">Procedures Advise/Carried out : </td>
            
            </tr>
            
             <tr>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px; width: 25px" rowspan="2">S.No.</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;" rowspan="2">Type of Indication</td>
             <td align="center" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;">During the Month</td>
               <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px; width: 120px">Progressive</td>
            </tr>
            <tr>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;" >Advised</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Carried out</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;" width="85px">Advised</td>
            <td align="center" valign="top" class="tdBorderBt"  style="font-size: 14px; width: 120px">Carried out</td>
            </tr>
           
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">I</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">Ultrasound</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">II</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">Aminocentesis</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">III</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">Chorinic Villi Biopsy</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">IV</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">Foetoscopy</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">V</td>
            
            <td align="right" valign="top" class="tdBorderRtBt"  style="font-size: 14px;text-align: left;">Foetal skin or organ biopsy</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">VI</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;" >Cordocentesis</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">VII</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">Other</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            
            </tr>
            <tr><td></td></tr>
             <tr >
            <td align="center" valign="center" class="tdBorderBt" style="font-size: 14px; width: 25px">6.</td>
            <td align="left" valign="center" class="tdBorderBt" colspan="5" style="font-size: 14px;">Laboratory tests Advise/Carried out : </td>
            
            </tr>
            
             <tr>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px; width: 25px" rowspan="2">S.No.</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;" rowspan="2">Type of Indication</td>
             <td align="center" valign="top" class="tdBorderRtBt" colspan="2" style="font-size: 14px;">During the Month</td>
               <td align="center" valign="top" class="tdBorderBt" colspan="2" style="font-size: 14px; width: 120px">Progressive</td>
            </tr>
            <tr>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;" >Advised</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Carried out</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;" width="85px">Advised</td>
            <td align="center" valign="top" class="tdBorderBt"  style="font-size: 14px; width: 120px">Carried out</td>
            </tr>
           
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">I</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">Chromosomal studies</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">II</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">Bio-chemical studies</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">III</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">Molecular studies</td>
           <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
           <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">&nbsp;</td>
            </tr>
           <tr><td></td></tr>
             <tr >
            <td align="center" valign="center"  style="font-size: 14px; width: 25px">7.</td>
            <td align="left" valign="center" colspan="5" style="font-size: 14px;">Results of Prenatal Diagnosis : </td>
            
            </tr>
            
            <tr>
             <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;" height="45px">&nbsp;</td>
            
            <td align="right" valign="top" class="tdBorderBt" style="font-size: 14px;text-align: left;">Normal 
              <table class="boxBorder" valign="center" align="right" cellspacing="0" cellpadding="0"><tr><td width="236px">&nbsp;</td></tr></table></td>
            <td align="right" valign="top" class="tdBorderBt" style="font-size: 14px;text-align: right;">Abnormal</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">
              <table class="boxBorder" valign="center" align="right" cellspacing="0" cellpadding="0"><tr><td width="108px">&nbsp;</td></tr></table>
            </td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;text-align: right;">Total</td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;">
               <table class="boxBorder" valign="center" align="right" cellspacing="0" cellpadding="0"><tr><td width="108px">&nbsp;</td></tr></table>
            </td>
            </tr>
            
            <tr >
            <td align="center" valign="center" style="font-size: 14px; width: 25px">8.</td>
            <td align="left" valign="center" colspan="5" style="font-size: 14px;">Duration of Pregnancy : </td>
            
            </tr>
            
            <tr>
            <td width="100px" colspan="2"></td>
             <td align="center" valign="top"  style="font-size: 14px;text-align: center;" height="45px" colspan="5">
               <table>
               <tr><td align="center" valign="top"  style="font-size: 14px;text-align: center;"  >1. Less than 12 weeks</td></tr>
               <tr><td align="center" valign="top"  style="font-size: 14px;text-align: left;" >2. 12 - 24 weeks</td></tr>
               <tr><td align="center" valign="top"  style="font-size: 14px;text-align: center;" >3. More than 24 weeks</td></tr>
               </table>
              </td>
            </tr>
            
            <tr >
            <td align="center" valign="center" class="" style="font-size: 14px; width: 25px">8.</td>
            <td align="left" valign="center" class="" colspan="5" style="font-size: 14px;">MTP : </td>
            </tr>
            <tr>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px; width: 25px" ></td>
            <td align="center" valign="top" class="tdBorderBt" style="font-size: 14px;text-align: left;" >&nbsp;</td>
             <td align="center" valign="top" class="tdBorderBt"  style="font-size: 14px;">&nbsp;</td>
             <td align="center" valign="top" class="tdBorderBt"  style="font-size: 14px;">&nbsp;</td>
             <td align="center" valign="top" class="tdBorderBt"  style="font-size: 14px;">&nbsp;</td>
               <td align="center" valign="top" class="tdBorderBt"  style="font-size: 14px; width: 120px"></td>
            </tr>
            <tr>
            <td align="center" valign="top" class="tdBorderRt" style="font-size: 14px;" >&nbsp;</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Adviced/Done</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;" width="105px">Before 12 weeks</td>
            <td align="center" valign="top" class="tdBorderRtBt"  style="font-size: 14px; width: 120px">After 12 weeks</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Total</td>
            <td align="center" valign="top" class=""  style="font-size: 14px;">&nbsp;</td>
            </tr>
           
            <tr>
             <td align="center" valign="top" class="tdBorderRt" style="font-size: 14px;">&nbsp;</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">1. No. advised</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="" style="font-size: 14px;">&nbsp;</td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRt" style="font-size: 14px;">&nbsp;</td>
            
            <td align="right" valign="top" class="tdBorderRtBt" style="font-size: 14px;text-align: left;">2. No. of MTPs done</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">&nbsp;</td>
            <td align="center" valign="top" class="" style="font-size: 14px;">&nbsp;</td>
            </tr>
             <tr><td height="25px" colspan="6"></td></tr>
          </thead>
          
          
        </table>
    </td>
  </tr>
 
 <tr><td height="25px">&nbsp;</td></tr>
  
  
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="45%" align="right" valign="bottom" class="columnPad ">
            	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                	    <td height="35" align="left" valign="top"><strong>Signature</strong></td>
                	</tr>
                	<tr><td height="25px" ><strong>Name of the Genetic counseling Center/Clinic/Lab. Incharge :</strong></td>
                	  <td class="tdBorderBt" width="320px">&nbsp;</td>
                	</tr>
                	<tr><td height="25px"><strong>Address :</strong></td></tr>
                    <tr><td height="25px"><strong>Phone Number :</strong></td></tr>
                    <tr><td height="25px"><strong>e-mail address :</strong></td></tr>
                
                
                </table>
            </td>
          </tr>
          
        </table>
    </td>
  </tr>
  
</table>

 <?php echo $this->Form->end(); ?>       
         	  
