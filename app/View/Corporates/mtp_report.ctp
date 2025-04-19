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
    <td width="100%" align="center" valign="top" class="heading"><strong><?php 
    if($mode=='direct') echo 'MEDICAL TERMINATION OF PREGNANCY ACT';
    else echo 'MEDICAL TERMINATION OF PREGNANCY ACT';
    ?></strong></td>
  </tr>
</table>
 <?php echo $this->Form->create();
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" >
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
        <table width="800" border="0" cellspacing="0" cellpadding="5" id="ExtraRow">
  <tr>
    <td width="370" align="left" valign="top" style="font-size: 14px; ">Name Of Hospital :</td>
   
    <td valign="top"></td>
  </tr>
 
  <tr>
    <td align="left" valign="top" style="font-size: 14px; ">Postal Address with Phone No :</td>
    
    <td valign="top"></td>
  </tr>
 
  <tr>
    <td align="left" valign="top" style="font-size: 14px; ">Registration No :</td>
    
    <td valign="top" style="font-size: 14px; ">For the month of :</td>
    
  </tr>
 
</table>
    </td>
  </tr>
 
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tdBorderTpBt">
          <thead>
             <tr>
            <td align="center" class="tdBorderRtBt" rowspan="2">.</td>
            <td width="80" align="center" class="tdBorderRtBt" style="font-size: 14px; " colspan="2">During Month</td>
            <td width="65" align="center" class="tdBorderRtBt" colspan="2" style="font-size: 14px; ">Progressive</td>            
           </tr>
            
            <tr>
           
            <td width="80" align="center" class="tdBorderRtBt" style="font-size: 14px; ">Married Women</td>
            <td width="65" align="center" class="tdBorderRtBt" style="font-size: 14px; ">Unmarried Women</td>
            <td width="65" align="center" class="tdBorderRtBt" style="font-size: 14px; ">Married Women</td>            
            <td width="100" align="center" class="tdBorderRtBt" style="font-size: 14px; ">Unmarried Women</td>
          </tr>
          
          <tr >
            <td class="tdBorderRtBt" style="font-size: 14px; " height="20px">Total No. of MTP Done</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;"><strong>By duration of Pregnancy</strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">a) Upto 12 weeks</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">b) Between 12 to 20 weeks</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">c) Not available</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
             <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;">MVA</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
             <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;">RU 486</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
             <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;">MA</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
             <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;">Others</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
             <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;text-align: center;"><strong>Total - </strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;"><strong>By age group</strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">a) Less than 15</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">b) 15 - 19</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">c) 20 - 24</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">d) 25 - 29</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">e) 30 - 34</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">f) 35 - 39</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">g) 40 - 44</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">h) 45 & above</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">Not Reported</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;text-align: center;"><strong>Total - </strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;"><strong>By Religion</strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">a) Hindu</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">b) Muslim</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">c) Christian</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">d) Sikh</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">e) Other</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">f) Not available</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
             <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;text-align: center;"><strong>Total - </strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
             <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;"><strong>Reasons for Termination</strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">a) Danger to Life of Preg. Mother</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">b) Grave injury to Physical health of Preg. Mother</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">c) Grave injury to Mental health of Preg. Mother</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">d) Pregnancy caused bu rape</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">e) Substantial risk that the chid born would suffer from Physical or Mental handicapped</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">f) Failure of contraceptives</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">g) Not available</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
             <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;text-align: center;"><strong>Total - </strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;"><strong>Termination with</strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">a) Sterilisation</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">b) IUD Insertions</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">c) Break up not available</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;text-align: center;"><strong>Total - </strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <td class="tdBorderRtBt" style="font-size: 14px;">No. of Deaths reported</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;">No. of Deaths due to termination</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">a) No. of Married women</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">b) No. of Unmarried women</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;padding-left: 30px">c) Break up not available</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
            <td class="tdBorderRtBt" style="font-size: 14px;text-align: center;"><strong>TOTAL   </strong></td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            
          </thead>
          
          
        </table>
    </td>
  </tr>
  
  <tr>
    <td width="100%" align="left" valign="top" class="tdBorderTp">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
         
        </table>
    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="columnPad">
    	<table width="" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td height="18" align="left" valign="top" style="font-size: 14px;">Name of Surgeon</td>
              	<td width="15" align="center" valign="top">:</td>
               	</tr>
        	<tr>
        	  <td height="20" align="left" valign="top" style="font-size: 14px;">Name of Anaesthetist</td>
        	  <td align="center" valign="top">:</td>
        	   </tr>
        	
   	  </table>
    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="55%" class="columnPad ">&nbsp;
            </td>
            <td width="45%" align="right" valign="bottom" class="columnPad ">
            	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td height="20" align="right" valign="top" style="font-size: 14px;"><strong>Signature with Rubber Stamp</strong></td>
                	</tr>
                </table>
            </td>
          </tr>
          <tr>
          <td>
          <table>
          <tr>
          <td width="100%" style="font-size: 14px;"><strong>Note : In case of Death if reported please submit details of person, age , address with remarks so on.</strong></td>
          </td></tr>
          </table>
          </tr>
        </table>
    </td>
  </tr>
  
</table>

 <?php echo $this->Form->end(); ?>       
         	  
