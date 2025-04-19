<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
 <?php echo __("Hospital Management System Consent Form"); ?>
</title>
			<?php echo $this->Html->css(array('internal_style.css')); ?>
<style>
.print_form{
	background:none;
	font-color:black;
	color:#000000;
}
.formFull td{
	color:#000000;
}
</style>
</head>
<body onload="javascript:window.print();" class="print_form">

   <div class="inner_title">
	<h3 style="color:black;text-align:center;">&nbsp; <?php echo __('Consent Form', true); ?></h3>
	</div>
	<p class="ht5"></p>
<!-- two column table start here -->
                   <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td width="49%" valign="top" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                              <tbody><tr>
                              	<th colspan="2"><?php echo __('Patient Information'); ?></th>
                              </tr>
                              <tr>
                                <td width="140" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Name'); ?>:</td>
                                <td align="left">
								<?php echo $consentData['Consent']['patient_name']; ?>
								</td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Sex'); ?>:</td>
                                <td align="left">
                                <?php echo $consentData['Consent']['patient_sex']; ?>
                                </td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age'); ?>: </td>
                                <td align="left">
<?php echo $consentData['Consent']['patient_age']; ?>
</td>
                              </tr>
                              
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __("MRN");?>:</td>
                                <td align="left">
<?php echo $consentData['Consent']['patient_id']; ?>
</td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Diagnosis'); ?>:</td>
                                <td align="left">
<?php echo $consentData['Consent']['patient_diagnosis']; ?>
</td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Operation Title'); ?>:</td>
                                <td align="left">
<?php echo $consentData['Consent']['patient_operation_title']; ?>
</td>
                              </tr>
                            </tbody></table>
                        </td>
                        <td width="" valign="top" align="left">&nbsp;</td>
                        <td width="49%" valign="top" align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2">Relative's Information</th>
                          </tr>
                          <tr>
                            <td width="160" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Name'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['relative_name']; ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Sex'); ?>:</td>
                            <td align="left">
                            <?php echo $consentData['Consent']['relative_sex']; ?>                      
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['relative_age']; ?>
</td>
                          </tr>
                          

                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address1'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['relative_address1']; ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address2'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['relative_address2']; ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Relation with the Patient');?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['relation_with_patient']; ?>
</td>
                          </tr>
                        </tbody></table></td>
                      </tr>
                      <tr>
                        <td valign="top" align="left">&nbsp;</td>
                        <td valign="top" align="left">&nbsp;</td>
                        <td valign="top" align="left">&nbsp;</td>
                      </tr>
                    </tbody></table>
					<!-- two column table end here -->
                    
                    <!--single column table start here -->
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border: 0pt none;padding-left:5px;" class="formFull">
                    	<tbody><tr>
                        	<td colspan="2">
                    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
                                	<tbody><tr>
                                   	  	<td width="140">I the undersigned</td>
                                        <td>
<?php echo $consentData['Consent']['consent_owner']; ?>
</td>
                                    </tr>
                                    <tr>
                                    	<td style="padding-bottom: 7px;" colspan="2">GIVE CONSENT FOR 
                                   	    
<?php 
if($consentData['Consent']['consent_for1'] == 1){
echo $this->Form->checkbox('consent_for1', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('consent_for1');
}
 	?>
                                   	    MY OWN / 
<?php 
if($consentData['Consent']['consent_for2'] == 1){
echo $this->Form->checkbox('consent_for2', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('consent_for2');
}
 	?>
 
                                   	    AFOREMENTIONED PATIENT'S abovementioned operation and / or medication / investigation / anaesthesia / therapy / procedure etc.</td>
                                    </tr>
                                </tbody></table>                            </td>
                        </tr>
                        <tr>
                       	  <td width="30" valign="top" align="left">1.</td>
                            <td style="padding-bottom: 7px;">The necessity of this medication / investigation / anaesthesia / operation / therapy / procuder, the ill effect if this is not performed, hazards and complications in the therapeutic modalities other than operation, have been explained to me by Dr. 

<?php echo $consentData['Consent']['investigating_dr']; ?>
</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">2. </td>
                          <td style="padding-bottom: 7px;">I have expalined clearly that any medication / investigation / operation / therapy is not totally safe and that such procedure or anaesthesia can be a risk to life of an otherwise healthy person also.</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">3.</td>
                          <td style="padding-bottom: 7px;">Doctors have expalined to me that excessive bleeding, infection, cardiac arrest, pulmonary embolism and complications like this can aries suddenly and unexpectedly while undergoing medication / investigation / operation therapy / procedure or anaesthesia.</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">4.</td>
                          <td style="padding-bottom: 7px;">I give consent for any change in the anaesthesia or operative procedure as well as fo removal of any organ as deemed necessary by the Doctors at the time of medication / investigation / operation / therapy/ procedure.</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">5. </td>
                          <td style="padding-bottom: 7px;">I have been made aware that after the above operation / medication / investigation / therapy / procedure and anaesthesia, instead of desired benefit, some complications may arise e.g.
     <?php echo $consentData['Consent']['complications_arise']; ?> 
                          <br>
                          and I believe that to avoid such complications, if any, appropriate care shall be taken by<br>
                          <div class="ht5"></div>
                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                              <tbody><tr>
                                <td width="120">Dr. (Treating Doctor):</td>
                                <td width="200">
<?php echo $doctors[$consentData['Consent']['surgeon_name']]; ?>
</td>
   
<td width="50">Sign.</td>
<td width="80">________________</td>
   <td>&nbsp;</td>   
              
                                      </tr>
                              <tr>
                                <td>Dr. (Anaesthetist):</td>
                                <td>
<?php echo $doctors[$consentData['Consent']['anaesthetic_name']]; ?>
</td>
<td width="50">Sign.</td>
<td width="80">________________</td>
   <td>&nbsp;</td>   
                              </tr>
                            </tbody></table>
							<div class="ht5"></div>
                            or any other doctors suggested by them.                         </td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">6.</td>
                          <td style="padding-bottom: 7px;">On receipt of bill as and when and at the time of discharge, expenses of this hospital will be paid by me.</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">7.</td>
                          <td style="padding-bottom: 7px;">I am aware of the facilities available and facilities not available in this hospital and still willing for being admitted and treated, in this Hospital.</td>
                        </tr>
                        <tr>
                          <td align="center" style="padding-bottom: 7px; line-height: 23px;" colspan="2">
                          <strong>
 <?php 
 if($consentData['Consent']['terms_conditions_1'] == 1){
 	echo $this->Form->checkbox('terms_conditions_1',array('checked'=>'checked', 'disabled' => 'disabled'));
 }else{
 	echo $this->Form->checkbox('terms_conditions_1');
 }
  	?>
                          I have read the above writing / 
<?php 
 	
 if($consentData['Consent']['terms_conditions_2'] == 1){
 	echo $this->Form->checkbox('terms_conditions_2',array('checked'=>'checked', 'disabled' => 'disabled'));
 }else{
 	echo $this->Form->checkbox('terms_conditions_2');
 }

?>
                          The above writing has been read out to me.<br> I have understood the aforesaid and I am giving my consent willingly.</strong>                          </td>
                        </tr>
                        <tr>
                          <td align="center" colspan="2">&nbsp;</td>
                        </tr>
                    </tbody></table>
                    <!--single column table end here -->
                    
                    <!--three column table start here -->
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2"><?php echo __('Witness'); ?></th>
                          </tr>
                          <tr>
                            <td width="90" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Sign.'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['witness1_sign']; ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Name'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['witness1_name']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address1'); ?>: </td>
                            <td align="left">
<?php echo $consentData['Consent']['witness1_address1']; ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address2'); ?>: </td>
                            <td align="left">
<?php echo $consentData['Consent']['witness1_address2']; ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age'); ?>: </td>
                            <td align="left">
<?php echo $consentData['Consent']['witness1_age']; ?>
</td>
                          </tr>
                         
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Date'); ?>: </td>
                            <td align="left">
<?php //echo $consentData['Consent']['witness1_date']; ?>

</td>
                          </tr>
                        </tbody></table></td>
                        <td width="30">&nbsp;</td>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2"><?php echo __('Witness'); ?></th>
                          </tr>
                          <tr>
                            <td width="90" valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Sign.'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['witness2_sign']; ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Name'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['witness2_name']; ?>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Address1'); ?>: </td>
                            <td align="left">
<?php echo $consentData['Consent']['witness2_address1']; ?> 
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Address2'); ?>:</td>
                            <td align="left">
                            <?php echo $consentData['Consent']['witness2_address2']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Age'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['witness2_age']; ?>
</td>
                          </tr>
                          
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Date'); ?>:</td>
                            <td align="left">
<?php //echo $consentData['Consent']['witness2_date']; ?>
</td>
                          </tr>
                        </tbody></table></td>
                        <td width="30">&nbsp;</td>
                        <td valign="top" align="left">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2"><?php echo __('Patient / Relative'); ?></th>
                          </tr>
                          <tr>
                            <td valign="top" align="left" style="text-align: left; padding-left: 10px; padding-top: 5px; height: 175px;" class="tdLabel" colspan="2">
                            	Sign. and / or L.H.T.I
                                
                            </td>
                          </tr>

                          <tr>
                            <td width="90" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Date'); ?>:</td>
                            <td align="left">
<?php //echo $consentData['Consent']['relative_date']; ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Title'); ?>:</td>
                            <td align="left">
<?php echo $consentData['Consent']['relative_title']; ?>
</td>
                          </tr>
                        </tbody></table></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody></table>

 </body>
</html>

                   