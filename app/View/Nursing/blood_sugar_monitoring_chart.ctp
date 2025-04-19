<div style="width:100%;text-align:right;cursor:pointer;" id="printButton">
	<input type="button" value="Print" class="blueBtn" onclick="window.print();"/>&nbsp;&nbsp;
	<input name="Close" type="button" value="Close" class="blueBtn" onclick="window.close();"/> 
</div>
 <style>
 .patient_info{
	width:80%;
	margin:0 10%;
 }
 .boxBorder{border:1px solid #000000;}
	.boxBorderBot{border-bottom:1px solid #000000;}
	.boxBorderRight{border-right:1px solid #000000;}
	.tdBorderRtBt{border-right:1px solid #000000; border-bottom:1px solid #000000;}
	.tdBorderBt{border-bottom:1px solid #000000;}
	.tdBorderTp{border-top:1px solid #000000;}
	.tdBorderRt{border-right:1px solid #000000;}
	.tdBorderTpBt{border-bottom:1px solid #000000; border-top:1px solid #000000;}
	.tdBorderTpRt{border-top:1px solid #000000; border-right:1px solid #000000;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	input{cursor:pointer;}
 </style>
 
<div class="clr ht5"></div>
<?php echo $this->element('patient_header') ;?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:50px">
  <tr>
    <td width="100%" align="left" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0" >
        	<tr>
            	 
                <td align="center" colspan="4" valign="bottom" style="font-size:21px; font-weight:bold;"><span style=" border-bottom:1px solid #333333;">BLOOD SUGAR MONITORING CHART</span></td>
                
            </tr>
        </table>    </td>
  </tr>
   
    </table></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="100%" align="left" valign="top">
 
    <table width="100%" border="0" cellspacing="0" cellpadding="10" class="boxBorder" >
      <tr>
        <td width="150" align="center" class="tdBorderRtBt">Date</td>
        <td width="150" align="center" class="tdBorderRtBt">Time</td>
        <td width="150" align="center" class="tdBorderRtBt">Blood Sugar (mg/dl)</td>
        <td align="center" class="tdBorderBt">Treatment Given</td>
      </tr>
	  
	  <?php
	  if(count($patient['PatientBloodSugarMonitoring'])>0){
		foreach($patient['PatientBloodSugarMonitoring'] as $key =>$value){
		$datestdtoLocal = $this->DateFormat->formatDate2Local($value['datetime'],Configure::read('date_format'),true) ;
		$splitDate = explode(" ",$datestdtoLocal);
	  ?>
      <tr>
        <td align="center" class="tdBorderRtBt"><?php echo $splitDate[0];?></td>
		<td align="center" class="tdBorderRtBt"><?php echo $splitDate[1];?></td>
        <td align="center" class="tdBorderRtBt"><?php echo $value['blood_sugar'];?></td>
        <td align="center" class="tdBorderRtBt"><?php echo $value['treatment'];?></td>
      
      </tr>
     <?php
	   }
	   }else{ ?>
		  <tr>
            <td align="center" colspan="6">No Data Found.</td>
           </tr>
	<?php }
	?>
	 
    </table></td>
  </tr>
   
</table> 
 
 
 