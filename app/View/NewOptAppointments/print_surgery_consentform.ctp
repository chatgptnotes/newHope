<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000000;}
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
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
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
        	INFORMED CONSENT TO SURGERY OR SPECIAL PROCEDURE</strong>        </td>
      </tr>
  
  
  <tr>
    <td width="100%" height="30" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="30" align="left" valign="top">1. </td>
        <td width="" align="left" valign="top" style="padding-bottom:20px;">This form is called an &quot;Informed Consent Form&quot;. It is your doctor's obligation to provide you with the information you need in order to decide whether to consent to the surgery or special procedure that your doctors have recommended. <em><strong>The purpose of this form is to verify that you have recieved this information and have given your consent to the surgery or special procedure recommended to you</strong></em>. You should read this form carefully and ask questions or your doctors so that you understand the operation or procedure before  you decide whether or not to give your consent. If you have questions, you are encouraged and expected to ask them before you sign this form. Your doctors are not employees or agents of the hospital.They are independent practitioners.</td>
      </tr>
      <tr>
        <td width="30" align="left" valign="top">2. </td>
        <td width="" height="30" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td valign="top">Your Doctors have recommended the following operation or procedure:</td>
            </tr>
            <tr>
              <td style="border-bottom:1px solid #000000;"><?php echo nl2br($patientConsentDetails['ConsentForm']['doctor_recommendation']); ?></td>
            </tr>
            <tr>
              <td style="padding:10px 0 20px 0;">Upon your authorization and consent, this operation or pocedure, together with any different or further procedures, which in the opinion of the doctor(s) performing the procedure, may be indicated due to any emergency, will be performed on you.The operation and procedures will be performed by the doctor(s) named below ( or in the event substitute doctor), together with associates and assistants, including anesthesiologists , pathologists and radiologists from the medical staff of Hope Hospital to whom the doctor(s) performing the procedure may assign designated responsibilities.The hospital maintains personnel and facilities to assist your doctors in their performance of various surgical operations and other special diagnostic or therapeutic procedures. However,the persons in attendance for the purpose of performing specialized medical services such as anesthisa, radiology, or pathology are not employees or agents of the hospital or of doctor(s) performing the procedure.They are independent medical practitioners.</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="30" align="left" valign="top">3. </td>
        <td width="" height="20" align="left" valign="top" style="padding-bottom:20px;">All operations and procedures carry the risk of unsuccessfull results, complications, injury or even death, from both known and unforeseen causes, and no warranty or guarantee is made as to result or cure. You have the right to be informed of:
          <ul style="margin-left:-22px;">
              <li>The nature of the operation or procedure , including other care, treatment or medications.</li>
            <li>Potential benfits, risks or side effects of the operation or procedure, including potential problems that might occur during recuperation.</li>
            <li>The likelihood of achieving treatment goals.</li>
            <li>Reasonable alternatives and the relevant risks, benefits and side effects related to such alternatives, including the possible results of not recieving care or treatment.</li>
            <li>Any independent medical research or significant interests your doctor may have related to the performance of the proposed operation or procedure.</li>
          </ul>
          Except in cases of emergency, operations or procedures are not performed until you have had the opportunity to recieve this information and have given your consent. You have the right to give or refuse consent to any proposed operation or procedure at any time prior to its performance. </td>
      </tr>
      <tr>
        <td align="left" valign="top">4.</td>
        <td height="20" align="left" valign="top" style="padding-bottom:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="25" valign="top">By your signature below, you authorize the pathologist to use his or her discretion in disposition or use of any member, organ or tissue removed from your person during the operation or procedure set forth above, subject to the following conditions (if any):</td>
            </tr>
            <tr>
              <td style="border-bottom:1px solid #000000;"><?php echo nl2br($patientConsentDetails['ConsentForm']['conditions']); ?></td>
            </tr>
            </table></td>
      </tr>
      <tr>
        <td align="left" valign="top">5.</td>
        <td height="20" align="left" valign="top" style="padding-bottom:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="330" valign="top">The practitioner who will perform your procedure is:</td>
              <td style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['Initial']['name']." ".$patientConsentDetails['DoctorProfile']['doctor_name']; ?></td>
            </tr>
            <tr>
              <td colspan="2" style="padding-top:5px;">You have the right to be informed of each practitioner who will perform &quot; significant surgical tasks&quot; such as opening  and closing, harvesting grafts, dissecting tissue, removing tissue, implanting devices, and altering tissues. You may discuss this with your physician.</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top">6.</td>
        <td height="20" align="left" valign="top" style="padding-bottom:20px;">If your doctor determines that there is a reasonable possibility that you may need a blood transfusion as a result of the surgery or procedure to which you are consenting, your doctor will inform you of this and will provide you with information concerning the benefits and risks of the various options for blood transfusion, including predonation by yourself or others. You also have the right to have adequate time before your procedure to arrange for predonation , but you can waive this right if you do not wish to wait.<br />
            <br />
          Transfusion of blood or blood products involves certain risks, including the transmission of disease such as hepatitis or Human Immunodeficiency Virus (HIV), and you have a right to consent or refuse to consent to any transfusion.You should discuss any questions that you may have about transfusions with your doctor.</td>
      </tr>
      <tr>
        <td align="left" valign="top">7.</td>
        <td height="20" align="left" valign="top" style="padding-bottom:20px;">Your signature on this form indicates that:
          1) You have read and understand the information provided in this form; 
          2) Your doctor has adequately explained to you the operation or procedure set forth above, along with the risks, benefits, and other information described above in this form; 
          3) You have had a chance to ask your doctors questions; 
          4) You have recieved all of the information you desire concerning the operation or procedure; 
          5) You authorize and consent to the performance of the operation or procedure.</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="100%" height="30" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" height="30" align="left" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="40">Date:</td>
              <td width="190" style="border-bottom:1px solid #000000;"><?php echo $this->DateFormat->formatDate2Local($patientConsentDetails['ConsentForm']['date_time'],Configure::read('date_format'), true); ?></td>
              
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
            <td width="448" style="border-bottom:1px solid #000000;">&nbsp;</td>
            <td width="281">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
      	<td style="font-size:13px; padding-left:170px; padding-bottom:10px;">(Patient / Parent / Conservator / Guardian)</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">If signed by someone other than patient, indicate name relationship</td>
      </tr>
      <tr>
        <td style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['ConsentForm']['patient_relative']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="60">Witness:</td>
              <td width="600" style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['ConsentForm']['witness']; ?></td>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
</table>

