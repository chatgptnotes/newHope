<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
<style>
	.patientHub{width:70%;margin-left:20%}
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
</style>
<?php     
	$intake_detail = unserialize($PatientIvf['PatientIvf']['intake_detail']);
?>
<div class="clr ht5"></div>
<?php echo $this->element('print_patient_info');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
    <td width="100%" height="25" align="left" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
           	  <td width="800" valign="top">
                
                  <div style="height:13px;"></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                     
                      <td width="55" valign="bottom">DATE :</td>
                      <td width="170" valign="top" style="border-bottom:1px solid #000000;">&nbsp;<?php echo  $this->DateFormat->formatDate2local($PatientIvf['PatientIvf']['date'],Configure::read('date_format')); ?></td>
                    </tr>
                  </table>              </td>
              <td width="100" height="40">&nbsp;</td>
               <td width="" align="right" valign="middle" style="font-size:40px; font-weight:bold;">I.V.F.</td>
          </tr>
    </table>    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="padding-top:15px;">
	   <p class="ht5"></p> 
 
		<table cellspacing="0" cellpadding="3" width="100%" border="0" style="border-bottom:0px;" class="boxBorder">
                      <tr>
						<td width="90" align="center" class="tdBorderRtBt">TIME</td>
						<td width="39" align="center" class="tdBorderRtBt">TEMP</td>
						<td width="47" align="center" class="tdBorderRtBt">PULSE</td>
						<td width="37" align="center" class="tdBorderRtBt">RR</td>
						<td width="48" align="center" class="tdBorderRtBt">BP</td>
						<td width="49" align="center" class="tdBorderRtBt">CVP</td>
						<td width="53" align="center" class="tdBorderRtBt">SPO<sub>2</sub></td>
						<td width="211" align="center" class="tdBorderRtBt">I.V. INTAKE</td>
						<td width="59" align="center" class="tdBorderRtBt">R.T.F.</td>
						<td width="59" align="center" class="tdBorderRtBt">BGL/ INSULIN</td>
						<td width="63" align="center" class="tdBorderRtBt">R.T.A.</td>
						<td width="64" align="center" class="tdBorderRtBt">URINE OUTPUT</td>
						<td width="53" align="center" class="tdBorderRtBt">STOOL</td>
						<td width="51" align="center" class="tdBorderRtBt">VOM-ITING</td>
						<td width="54" align="center" class="tdBorderBt">ABD. GIRTH</td>
					  </tr>
					<?php
					 		 
					 foreach($intake_detail['time']  as $key => $value){					
						$datestdtoLocal = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'),true) ;
						$splitDate = explode(" ",$datestdtoLocal);
						$splitDate[1] = date("g:i a",strtotime($splitDate[1]));
					?>
					  <tr >
                      	 <td align="left" valign="top" class="tdBorderRtBt" style="padding-left:8px;">&nbsp;<?php echo $splitDate[1];?></td>
                           <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['temp'][$key];?></td>
                            <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['pulse'][$key];?></td>
                            <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['rr'][$key];?></td>
                            <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['bp'][$key];?></td>
                           <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['cvp'][$key];?></td>
                           <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['spo2'][$key];?></td>
                          <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['iv'][$key];?></td>
                            <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['rtf'][$key];?></td>
                            <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<php echo $intake_detail['bgl'][$key];?></td>
                           <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['rta'][$key];?></td>
                            <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['urineoutput'][$key];?></td>
                           <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['stool'][$key];?></td>
                          <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['vom-iting'][$key];?></td>
                       <td align="center" valign="top" class="tdBorderRtBt">&nbsp;<?php echo $intake_detail['abd-girth'][$key];?></td>
                     </tr> 
					  <?php
					  }
					  ?>
				   </table></td>
				   
				   
      </tr>
	   <tr>
        <td colspan="15" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="455" style="padding-left:12px;;border-left:1px solid:">6AM - 6 PM TOTAL INTAKE {I.V. + ORAL - R.T.F.}</td>
            <td width="120">OUTPUT :</td>
            <td width="120">STOOL :</td>
            <td width="160">DRAIN :</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
 
 
  