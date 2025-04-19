<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#000000;}
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

<div style="float:right" id="printButton">
					<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
				  </div>&nbsp;<div>
				  </div>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="100%" align="left" valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="100%" align="right">&nbsp;</td>
        </tr>
        </table>        </td>
      </tr>
      <tr>
    	<td width="100%" height="25" align="center" valign="top" style="font-size:13px;"><strong style="line-height:20px; font-size:21px; display:block; padding-bottom:15px;">
        	INTERPRETER'S STATEMENT</strong>        </td>
      </tr>
  
  
  <tr>
    <td width="100%" height="30" align="left" valign="top">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td width="100%" height="25" align="left" valign="top">I have accurately and completely reviewed the foregoing document with the(patient or patient's legal </td>
      </tr>
      <tr>
        <td width="100%" height="25" align="left" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        		<tr>
                	<td width="110">representative)</td>
                    <td style="border-bottom:1px solid #000000;"><?php echo $patientISDetails['InterpreterStatement']['patient_primary_lang']; ?></td>
                    <td width="165" align="right">in the patient's or legal</td>
                </tr>    
            </table>        </td>
      </tr>
      <tr>
        <td width="100%" height="25" align="left" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        		<tr>
               	  <td width="245">representative's primary language</td>
                    <td style="border-bottom:1px solid #000000;"><?php echo $patientISDetails['InterpreterStatement']['patient_identify_lang']; ?></td>
                    <td width="145" align="right">(indentify language). </td>
                </tr>    
            </table>        </td>
      </tr>
      <tr>
        <td style="padding:0 0 25px 0;">He/She understood all of the terms and conditions and acknowledged his/her agreement by signing the document in my presence.</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="40">Date & Time:</td>
            <td width="190" style="border-bottom:1px solid #000000;"><?php echo $this->DateFormat->formatDate2Local($patientISDetails['InterpreterStatement']['date_time'],Configure::read('date_format'), true); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td style="padding-top:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="71">Signature:</td>
            <td width="280" style="border-bottom:1px solid #000000;">&nbsp;</td>
            <td width="20">&nbsp;</td>
            <td width="50">Name:</td>
            <td width="" style="border-bottom:1px solid #000000;"><?php echo $patientISDetails['InterpreterStatement']['patient_name']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="center" valign="top" style="font-size:14px;">(interpreter)</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="font-size:14px; padding-bottom:10px;" align="center">(print name)</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="71">Signature:</td>
            <td width="280" style="border-bottom:1px solid #000000;">&nbsp;</td>
            <td width="20">&nbsp;</td>
            <td width="77">RN Name:</td>
            <td width="252" style="border-bottom:1px solid #000000;"><?php echo $patientISDetails['InterpreterStatement']['patient_rn_name']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td style="font-size:14px;" align="center">(If Language Line used)</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="font-size:14px;" align="center">(print name)</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td style="font-size:13px;" align="center">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="font-size:13px;" align="center">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td style="border-bottom:2px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td height="40">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" style="font-size:13px;"><strong style="line-height:20px; font-size:21px; display:block; padding-bottom:15px;">PHYSICIAN CERTIFICATION</strong></td>
      </tr>

      <tr>
        <td>I, the undersigned physician, hereby certify that I have discussed the procedure described in the consent for with this patient (or the patient's legal representative), including:</td>
      </tr>
      <tr>
        <td><ul style="margin-left:-22px;">
            <li>The nature of the operation or procedure, including the surgical site and laterality if applicable</li>
          <li>The risks and benefits or effects of the procedure</li>
          <li>Any adverse reactions that may reasonably be expected to occur</li>
          <li>Any alternative efficacious methods of treatment which may be medically viable and their associated benefits or effects, and their possible risks and complications</li>
          <li>The potential problems that may occur during recuperation</li>
          <li>The likelihood of achieving treatment goals</li>
          <li>Any research or economic interest I may have regarding this treatment</li>
          <li>Any limitations on the confidentiality of information learned from or about the patient</li>
        </ul></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="40">Date & Time:</td>
            <td width="190" style="border-bottom:1px solid #000000;"><?php echo $this->DateFormat->formatDate2Local($patientISDetails['InterpreterStatement']['physician_date_time'],Configure::read('date_format'), true); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="71">Signature:</td>
            <td width="280" style="border-bottom:1px solid #000000;">&nbsp;</td>
            <td width="20">&nbsp;</td>
            <td width="50">Name:</td>
            <td width="279" style="border-bottom:1px solid #000000;"><?php echo $patientISDetails['InterpreterStatement']['physician_name']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td style="font-size:14px;" align="center">(Physician)</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="font-size:14px;" align="center">(print name)</td>
          </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
</table>

