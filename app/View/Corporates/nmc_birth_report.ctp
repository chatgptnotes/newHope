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
	.tdBorderBtDot{border-bottom:1px dotted #3E474A;}
	.tdBorderTp{border-top:1px solid #3E474A;}
	.tdBorderRt{border-right:1px solid #3E474A;}
	.tdBorderRtDash{border-right:1px dashed #3E474A ;}
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
    <td width="100%" align="center" valign="top" class="heading" style="font-size: 18px;"><strong><?php 
    echo 'NAGPUR MUNICIPAL CORPORATION NAGPUR';
    ?></strong></td>
  </tr>
  <TR>
     <TD width="100%" align="center" valign="top" class="heading" style="font-size: 16px;"><strong>FORM NO. 7</strong></TD>
  </TR>
</table>
 <?php echo $this->Form->create();
?>
<table width="1145" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" >
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
        <table width="1145" border="0" cellspacing="0" cellpadding="5" id="ExtraRow">
  <tr>
    <td width="35%" class="tdBorderRtDash">
      <table>
        <tr>
          <td style="font-size: 14px;" ><strong>FORM NO. 1 &nbsp;&nbsp;&nbsp; BIRTH REPORT</strong></td></tr>
        <tr>
          <td style="font-size: 12px;" style="text-align:center" align="left">Legal Information</td></tr>
        <tr>  
          <td style="font-size: 12px;">This part to be added to the Birth Register</td></tr>
      </table>
    </td>
    <td  width="26%" class="tdBorderRt">
       <table>
        <tr>
          <td style="font-size: 14px;" >(See Rule-12)&nbsp;&nbsp;&nbsp; <strong>BIRTH REPORT</strong>&nbsp;&nbsp;<strong>Birth Register</strong></td></tr>
        <tr>
          <td style="font-size: 12px;">Statistical Information</td></tr>
        <tr>  
          <td style="font-size: 12px;">This part to be detached and sent for statistical processing</td></tr>
      </table>
    </td>
    <td width="25%">
        <table>
         <tr>
           <td style="font-size: 12px;">If the case of multiple births,in a separate from ---- child and writetwin birth or Triple birth etc. as the --
           may be in the remarks column in the box below ----</td>
         </tr>
        </table>
    </td>
  </tr>

 
	</table>
    </td>
  </tr>
 
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
        <table width="1145" border="0" cellspacing="0" cellpadding="5" id="ExtraRow">
  <tr>
    <td width="35%" class="tdBorderRtDash">
      <table>
        <tr>
          <td style="font-size: 12px;" >To be filled by the informant</td></tr>
        <tr>
          <td style="font-size: 12px;">1. Date of Birth :</td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(Enter the exact day,month and year the child was born e.g. 1-1-2002)</td></tr>
        <tr>  
          <td style="font-size: 12px;">2. Sex :</td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(Enter the "male" or "female",do not use abbreviation)</td></tr>
        <tr>  
          <td style="font-size: 12px;">3. Name of the child, if any :</td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(if not named, leave blank)</td></tr>
        <tr>  
          <td style="font-size: 12px;">4. Name of the father :</td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(full name as usually written)</td></tr>
        <tr>  
          <td style="font-size: 12px;">5. Name of the mother :</td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(full name as usually written)</td></tr>
        <tr>  
          <td style="font-size: 12px;">6. Place of birth : (Tick the appropriate entry 1 or 2 below and given th ename of the Hospital/Institution or the address of th ehouse where th ebirth took place)</td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">&nbsp;&nbsp;&nbsp;&nbsp;1. Hospital/Name :</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Institution</td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">&nbsp;&nbsp;&nbsp;&nbsp;2. House Address :</td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">7. Informant's name : </td></tr>
        <tr>  
          <td style="font-size: 12px;"> &nbsp;&nbsp;&nbsp;    Address : </td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 20px">&nbsp;&nbsp;&nbsp;(After completing all columns 1 to 20, informant will put date and signature here)</td></tr>
        <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">Date : </pre>Signature or left thumb mark of the informant</td>
        </tr>
      </table>
    </td>
    <td  width="26%" class="tdBorderRt">
       <table>
        <tr>
          <td style="font-size: 12px;" >To be filled by the informant</td></td></tr>
        <tr>
          <td style="font-size: 12px;">8. Town or Village or Residence of the mother :</td></tr>
       <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(Place where the mother ususally lives.this can be different from the place where the delivery occured.</br>The house address is not required to be entered.)</td></tr>
       <tr>
          <td style="font-size: 12px;">a) Name of Town/Village :</td></tr>
       <tr>
          <td style="font-size: 12px;">b) Is it a town or village :(Tick the appropriate entry below)</br>&nbsp;&nbsp;&nbsp;1. Town&nbsp;&nbsp;&nbsp;2. Village</td></tr>
       <tr>
          <td style="font-size: 12px;">a) Name of District :</td></tr>
       <tr>
          <td style="font-size: 12px;padding-bottom: 10px">a) Name of State :</td></tr>
       <tr>
          <td style="font-size: 12px;padding-bottom: 10px">9. Religion of the family :(Tick the appropriate entry below)</br>&nbsp;&nbsp;&nbsp;1. Hindu&nbsp;&nbsp;&nbsp;2. Muslim&nbsp;&nbsp;&nbsp;3. Christian</br>
              &nbsp;&nbsp;&nbsp;4. Any other religion : </br>&nbsp;&nbsp;&nbsp;(write name of the religion) :</td></tr>
       <tr>
          <td style="font-size: 12px;">10. Father's level of education :</td></tr>
       <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(Enter the completed level of education e.g.if studied upto class VII but passed only class VI, write class VI)</td></tr>
       <tr>
          <td style="font-size: 12px;">11. Mother's level of education :</td></tr>
       <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(Enter the completed level of education e.g.if studied upto class VII but passed only class VI, write class VI)</td></tr>
       <tr>
          <td style="font-size: 12px;">12. Father's occupation :</td></tr>
       <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(if no occupation write 'Nil')</td></tr>
       <tr>
          <td style="font-size: 12px;">13. Mother's level of education :</td></tr>
       <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(if no occupation write 'Nil')</td></tr>
      </table>
    </td>
    <td width="25%">
        <table>
         <tr>
           <td style="font-size: 12px;" >To be filled by the informant</td></td></tr>
         <tr>
          <td style="font-size: 12px;">14. Age of the mother (in completed years) at the time of &nbsp;&nbsp;&nbsp;marriage :</td></tr>
         <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(If married more than once, age at first marriage may be entered)</td></tr>
         <tr>
          <td style="font-size: 12px;padding-bottom: 10px">15. Age of the mother (in completed years) at the time of &nbsp;&nbsp;&nbsp;this birth :</td></tr>
         <tr>
          <td style="font-size: 12px;">16. Number of children born alive to the mother so far including this child : :</td></tr>
         <tr>  
          <td style="font-size: 12px;padding-bottom: 10px">(Number of children born alive to include also from earlier marriage(s),if any)</td></tr>
         <tr>
          <td style="font-size: 12px;padding-bottom: 10px">17. Type of attention at delivery :</br>&nbsp;&nbsp;&nbsp;(Tick the appropriate entry below)</br>&nbsp;&nbsp;&nbsp;
             1. Institutional - Government</br>&nbsp;&nbsp;&nbsp;
             2. Institutional - Private or Non-Government</br>&nbsp;&nbsp;&nbsp;
             3. Doctor,Nurse or Trained midwife</br>&nbsp;&nbsp;&nbsp;
             4. Traditional Birth Attendant</br>&nbsp;&nbsp;&nbsp;
             5. Relative or others</td></tr>
         <tr>
          <td style="font-size: 12px;">18. Method of delivery :</br>&nbsp;&nbsp;&nbsp;(Tick the appropriate entry below)</br>&nbsp;&nbsp;&nbsp;
             1. Natural&nbsp;&nbsp;&nbsp;
             2. Caesarean</br>&nbsp;&nbsp;&nbsp;
             3. Forceps/Vaccum</br>&nbsp;&nbsp;&nbsp;
            </td></tr>
         <tr>
          <td style="font-size: 12px;">19. Birth Weight (in kgs.)(if available) :</td></tr>
         <tr>
          <td style="font-size: 12px;padding-bottom: 10px">20. Duration of pregnancy(in weeks) :</td></tr>
         <tr>
          <td style="font-size: 12px;padding-bottom: 10px">(Columns to be filled are over. Now put signature)</td></tr>
        </table>
    </td>
  </tr>

  
 
	</table>
    </td>
  </tr>
  
  <tr>
    <td width="100%" align="left" valign="top" class="">
        <table width="1145" border="0" cellspacing="0" cellpadding="5" id="ExtraRow">
  <tr>
    <td width="35%" class="tdBorderRtDash">
      <table>
        <tr>
          <td style="font-size: 12px;" align="center" style="text-align: right; padding-left:100px">To be filled by the Registrar</td></tr>
       
      </table>
    </td>
    <td  width="26%" class="tdBorderRt">
       <table>
        <tr>
          <td style="font-size: 12px;" >To be filled by the Registrar</td></tr>
      </table>
    </td>
    <td width="25%">
        <table>
         <tr>
           <td style="font-size: 12px;">To be filled by the Registrar</td>
         </tr>
        </table>
    </td>
  </tr>

 
	</table>
    </td>
  </tr>
  
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
        <table width="1145" border="0" cellspacing="0" cellpadding="5" id="ExtraRow">
  <tr>
    <td width="35%" class="tdBorderRtDash">
      <table>
        
        <tr>
          <td style="font-size: 12px;" >Registration No. :..................................................Registration Date :..............................</td></tr>
        <tr>
          <td style="font-size: 12px;">Registration Unit :.................................................................................................................</td></tr>
        <tr>
          <td style="font-size: 12px;" >Town/Village :..................................................District :.........................................................</td></tr> 
        <tr>
          <td style="font-size: 12px;">Remarks :(if any) :.................................................................................................................</td></tr>
         <tr>
          <td style="font-size: 12px;">&nbsp;</td></tr>
        <tr>
          <td style="font-size: 12px;">Name and Signature of the Registrar</td></tr>
      </table>
      
    </td>
    <td  width="26%" class="tdBorderRt">
       <table>
        <tr>
          <td style="font-size: 12px;" >Name :..............................</td></tr>
        <tr>
          <td style="font-size: 12px;">Code No. :.............................</td></tr>
        <tr>  
          <td style="font-size: 12px;">District :.................................</td></tr>
        <tr>  
          <td style="font-size: 12px;">Tahsil :.................................</td></tr>
        <tr>  
          <td style="font-size: 12px;">Town/Village :.................................</td></tr>
        <tr>  
          <td style="font-size: 12px;">Registration Unit :.................................</td></tr>
      </table>
    </td>
    <td width="25%">
        <table>
         <tr>
          <td style="font-size: 12px;" >Registration No. :........................Registration Date................</td></tr>
        <tr>
          <td style="font-size: 12px;">Date of Birth :.............................</td></tr>
        <tr>  
          <td style="font-size: 12px;">Sex : &nbsp;&nbsp;&nbsp;  1. Male &nbsp;&nbsp;&nbsp;    2. Female</td></tr>
        <tr>  
          <td style="font-size: 12px;">Place of Birth :  1. Hospital/Institution &nbsp;&nbsp;&nbsp;  2. House</td></tr>
         <tr>
          <td style="font-size: 12px;">&nbsp;</td></tr>
        <tr>  
          <td style="font-size: 12px;">Name and Signature of the Registrar</td></tr>
       
        </table>
    </td>
  </tr>

 
	</table>
    </td>
  </tr>
 
  
</table>

 <?php echo $this->Form->end(); ?>       
         	  
