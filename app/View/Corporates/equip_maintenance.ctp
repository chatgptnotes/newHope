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
    echo 'BIOMEDICAL EQUIPMENT SERVICE REPORT';
    ?></strong></u></td>
  </tr>
</table>
 <?php echo $this->Form->create();
?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" >
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
        <table width="1000" border="0" cellspacing="0" cellpadding="5" id="ExtraRow">
  <tr>
    <td width="370" align="left" valign="top" style="font-size: 14px;">Date :</td>
   <td width="370" align="left" valign="top" style="font-size: 14px;">Department :</td>
   <td width="370" align="left" valign="top" style="font-size: 14px;">Equipment Name :</td>
   <td width="370" align="left" valign="top" style="font-size: 14px;">Serial Number :</td>
  </tr>
 
  <tr>
    <td width="370" align="left" valign="top" style="font-size: 14px;">Equipment Code :</td>
   <td width="370" align="left" valign="top" style="font-size: 14px;">Make :</td>
   <td width="370" align="left" valign="top" style="font-size: 14px;">Equipment Model :</td>
   <td width="370" align="left" valign="top" style="font-size: 14px;">Call Time :</td>
 </tr>
 
  <tr>
    <td width="370" align="left" valign="top" style="font-size: 14px;">Call Attain Time :</td>
   <td width="370" align="left" valign="top" style="font-size: 14px;">Time to Rectification :</td>
   
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
            <td align="left" valign="center" class="tdBorderRtBt" colspan="6" height="60px" style="font-size: 14px;">Fault Reported : </td>
             </tr>
             <tr >
            <td align="left" valign="center" class="tdBorderRtBt" colspan="6" height="60px" style="font-size: 14px;">Engrs Observation : </td>
             </tr>
             <tr >
            <td align="left" valign="center" class="tdBorderRtBt" colspan="6" height="60px" style="font-size: 14px;">Diagnosis : </td>
             </tr>
           <tr >
            <td align="left" valign="center" class="tdBorderRtBt" colspan="6" height="60px" style="font-size: 14px;">Work Done : </td>
             </tr>
          <tr >
            <td align="left" valign="center" class="tdBorderRtBt" colspan="4" rowspan="2" style="font-size: 14px;">Remarks : </td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Work Hours</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
           
            </tr>
            <tr>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Minutes</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
           
            </tr>
             <tr>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px; width: 25px">S.No.</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Material Used</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Quantity</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Document Reference</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px; width: 120px">Job Completed</td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px; width: 60px"><strong>&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt">1</td>
            
           <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">Job Pending</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt">2</td>
            
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">CAMC</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt">3</td>
            
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">AMC</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
             <td align="center" valign="top" class="tdBorderRtBt">4</td>
            
            <td align="right" valign="top" class="tdBorderRtBt">&nbsp;</td>
            <td align="center" class="tdBorderRtBt" style="display:">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRtBt"><strong>&nbsp;</strong></td>
            <td align="center" valign="top" class="tdBorderRtBt" style="font-size: 14px;">No Contract</td>
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
  
  <tr><td height="30px">&nbsp;</td></tr>
  
  
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="45%" align="right" valign="bottom" class="columnPad ">
            	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                	    <td height="20" align="left" valign="top"><strong>BME Sign</strong></td>
                	    <td height="20" align="right" valign="top"><strong>HOD/In-Charge Sign</strong></td>
                	</tr>
                	<tr><td height="20px">&nbsp;</td></tr>
                </table>
            </td>
          </tr>
          
        </table>
    </td>
  </tr>
  
</table>

 <?php echo $this->Form->end(); ?>       
         	  
