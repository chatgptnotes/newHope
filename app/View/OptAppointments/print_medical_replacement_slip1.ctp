<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Anesthesia Consent Form</title>
<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000000;}	
	.heading{padding:3px 7px; font-size:19px; color:#FFFFFF; background-color:#000000;}
	.itemChkBox {float:right; margin-left:25px; margin-right:20px; border:1px solid #666666; width:25px;}
	.subhead{font-size:19px; text-decoration:underline;}
	.tdBorderTp{border-top:1px solid #999999;}
</style>
</head>

<body onload="window.print();window.close();">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="100%" align="left" valign="top" style="border-bottom:1px solid #000000;">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td width="200"><?php echo $this->Html->image('/img/hope-logo-sm.gif', array('alt' => '')); ?></td>
              	<td align="right" valign="bottom" style="padding-right:10px;">
                	<table width="" cellpadding="0" cellspacing="0" border="0">
                		<tr>
                        	<td class="heading"><?php echo __('MEDICAL REPLACEMENT SLIP'); ?></td>
                        </tr>    
                    </table>
                </td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td width="100%" height="20" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" height="25" align="left" valign="top">
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" style="min-width:800px;">
      <tr>
        <th colspan="4" align="left" class="subhead" style="padding-bottom:15px;"><?php echo __('SURGICAL ITEMS'); ?></th>
      </tr>
      <tr>
        <td width="35" height="22" align="left">1.</td>
        <td width="350">
            <div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['bt_set'] == 1) echo "checked"; ?> disabled /> </div>
          IV Set / B.T. Set / Paediatricist</td>
        <td width="35" align="left">35.</td>
        <td width="350"><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['tbact'] == 1) echo "checked"; ?> disabled /> </div>
          T-Bact / Neosparine (Ointment)</td>
      </tr>
      <tr>
        <td height="22" align="left">2.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['turp_set'] == 1) echo "checked"; ?> disabled /> </div>
          T.U.R.P. Set / H2O2</td>
        <td align="left">36.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['vasofix'] == 1) echo "checked"; ?> disabled /> </div>
          Vasofix / Scalp ven / Microset</td>
      </tr>
      <tr>
        <td height="22" align="left">3.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['disposal_syringe'] == 1) echo "checked"; ?> disabled /> </div>
          Disposable Syringe 50, 20, 10, 05, 02 ml</td>
        <td align="left">37.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['spinal_needle'] == 1) echo "checked"; ?> disabled /> </div>
          Spinal Needle No. 18, 20, 22, 23, 25</td>
      </tr>
      <tr>
        <td height="22" align="left">4.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['disposal_needle'] == 1) echo "checked"; ?> disabled /> </div>
          Disposable Needle No.</td>
        <td align="left">38.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['sofratulle'] == 1) echo "checked"; ?> disabled /> </div>
          Sofratulle / Framycetin Tulle</td>
      </tr>
      <tr>
        <td height="22" align="left">5.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['loprep'] == 1) echo "checked"; ?> disabled /> </div>
          Ioprep 100 ml / 500 ml</td>
        <td align="left">39.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['cotton_bundle'] == 1) echo "checked"; ?> disabled /> </div>
          Cotton Bundle / Gouze Bundle</td>
      </tr>
      <tr>
        <td height="22" align="left">6.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['betadine100'] == 1) echo "checked"; ?> disabled /> </div>
          Betadine 100 ml / 500 ml</td>
        <td align="left">40.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['xylocaine_jelly'] == 1) echo "checked"; ?> disabled /> </div>
          Xylocaine Jelly / Lignox Jelly</td>
      </tr>
      <tr>
        <td height="22" align="left">7.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['savlon'] == 1) echo "checked"; ?> disabled /> </div>
          Savlon / Sterillium 100 ml / 500 ml</td>
        <td align="left">41.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['strille_water'] == 1) echo "checked"; ?> disabled /> </div>
          Strille Water / IV Glycine</td>
      </tr>
      <tr>
        <td height="22" align="left">8.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['ciplox_eye'] == 1) echo "checked"; ?> disabled /> </div>
          Ciplox Eye Ointment</td>
        <td align="left">42.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['cap_mask'] == 1) echo "checked"; ?> disabled /> </div>
          Cap + Mask / Oxum 100 ml</td>
      </tr>
      <tr>
        <td height="22" align="left">9.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['dynaplast'] == 1) echo "checked"; ?> disabled /> </div>
          Dynaplast / G. Plast 4&quot;, 6&quot;</td>
        <td align="left">43.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['carm_cover'] == 1) echo "checked"; ?> disabled /> </div>
          C Arm Cover / Airway No. 2, 3, 4</td>
      </tr>
      <tr>
        <td height="22" align="left">10.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['micropare'] == 1) echo "checked"; ?> disabled /> </div>
          Micropare 1&quot;, 4&quot;</td>
        <td align="left">44.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['skin_stappler'] == 1) echo "checked"; ?> disabled /> </div>
          Skin Stappler / Skin Grafting Blade</td>
      </tr>
      <tr>
        <td height="22" align="left">11.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['chest_leads'] == 1) echo "checked"; ?> disabled /> </div>
          Chest Leads / HIV Kit</td>
        <td align="left">45.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['colostomy_drain'] == 1) echo "checked"; ?> disabled /> </div>
          Colostomy Drain Kit</td>
      </tr>
      <tr>
        <td height="22" align="left">12.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['roll_bandage'] == 1) echo "checked"; ?> disabled /> </div>
          Roll Bandage (Big Size)</td>
        <td align="left">46.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['gloves_box'] == 1) echo "checked"; ?> disabled /> </div>
          Gloves Box / Gypsona 6&quot;, 4&quot;</td>
      </tr>
      <tr>
        <td height="22" align="left">13.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['softroll'] == 1) echo "checked"; ?> disabled /> </div>
          SoftRoll 4&quot;, 6&quot; / Dyncrepe 4&quot;, 6&quot;</td>
        <td align="left">47.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['beta_scrub'] == 1) echo "checked"; ?> disabled /> </div>
          Beta Scrub / Bacillaxid</td>
      </tr>
      <tr>
        <td height="22" align="left">14.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['venoline'] == 1) echo "checked"; ?> disabled /> </div>
          ven-o-line / Three way</td>
        <td align="left">48.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['jonac_suppsitories'] == 1) echo "checked"; ?> disabled /> </div>
          Jonac Suppsitories</td>
      </tr>
      <tr>
        <td height="22" align="left">15.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['surgical_blade'] == 1) echo "checked"; ?> disabled /> </div>
          Surgical Blade No. 22, 10, 15, 11</td>
        <td align="left">49.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_rl_ml'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. RL 500 ml</td>
      </tr>
      <tr>
        <td height="22" align="left">16.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['electoclyss_enema'] == 1) echo "checked"; ?> disabled /> </div>
          Electoclyss Enema / Neotonic Enea</td>
        <td align="left">50.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_dns_ml'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. DNS 500 ml</td>
      </tr>
      <tr>
        <td height="22" align="left">17.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['vaccu_suction'] == 1) echo "checked"; ?> disabled /> </div>
          Vaccu Suction Set</td>
        <td align="left">51.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_dextrose_fivecent'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. Dextrose 5%</td>
      </tr>
      <tr>
        <td height="22" align="left">18.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['jet_foam'] == 1) echo "checked"; ?> disabled /> </div>
          Jet Foam / Bon Vax</td>
        <td align="left">52.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_dextrose_tencent'] == 1) echo "checked"; ?> disabled /></div>
          I.V. Dextrose 10%<br /></td>
      </tr>
      <tr>
        <td height="22" align="left">19.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['surgical_gloves'] == 1) echo "checked"; ?> disabled /> </div>
          Surgical Gloves No. 6, 61/2, 7, 77 &frac12;, 8</td>
        <td align="left">53.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_isolytee'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. Isolyte E</td>
      </tr>
      <tr>
        <td height="22" align="left">20.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['disposable_sponges'] == 1) echo "checked"; ?> disabled /> </div>
          Disposable Sponges (Soft Touch)</td>
        <td align="left">54.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_isolytep'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. Isolyte P</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">21.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['romo_vac'] == 1) echo "checked"; ?> disabled /> </div>
          Romo Vac Suction Drain<br />
          No. 10, 12, 14, 16, 8</td>
        <td align="left" valign="top">55.</td>
        <td valign="top"><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_isolytem'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. Isolyte M</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">22.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['uro_bag'] == 1) echo "checked"; ?> disabled /> </div>
          Uro Bag / Gamjee Roll</td>
        <td align="left">56.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_metrogyl'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. Metrogyl / I.V. Mannitol</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">23.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['sanctin_cath'] == 1) echo "checked"; ?> disabled /> </div>
          Sanctin Cath / Nel Cath</td>
        <td align="left">57.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_dextrose25'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. Dextrose 25%</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">24.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['ryles_tube'] == 1) echo "checked"; ?> disabled /> </div>
          Ryles Tube No. 12, 14, 16, 18</td>
        <td align="left">58.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_ns1000'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. NS 1000 ml</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">25.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['feeding_tube'] == 1) echo "checked"; ?> disabled /> </div>
          Feeding Tube No. 6, 7, 8, 10</td>
        <td align="left">59.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_ns500'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. NS 500 ml</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">26.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['folys_cath'] == 1) echo "checked"; ?> disabled /> </div>
          Foly's Cath No. 12, 14, 16, 18</td>
        <td align="left">60.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_cifran'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. Cifran</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">27.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['way_folys_cath'] == 1) echo "checked"; ?> disabled /> </div>
          3 Way Foly's Cath No. 16, 18, 20, 22</td>
        <td align="left">61.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['iv_hestar'] == 1) echo "checked"; ?> disabled /> </div>
          I.V. Hestar 6%, 3%</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">28.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['adk_no'] == 1) echo "checked"; ?> disabled /> </div>
          A.D.K. No. 20, 22, 24, 26, 28, 30, 32</td>
        <td align="left">62.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['otrovin'] == 1) echo "checked"; ?> disabled /></div>
          Otrovin (Nasal Drop)</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">29.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['plan_sheet'] == 1) echo "checked"; ?> disabled /> </div>
          Plan Sheet No. 301</td>
        <td align="left">63.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['betadine'] == 1) echo "checked"; ?> disabled /> </div>
          Betadine (Ointment)</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">30.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['et_tubeno'] == 1) echo "checked"; ?> disabled /> </div>
          E.T. Tube No.</td>
        <td align="left">64.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['soframycin'] == 1) echo "checked"; ?> disabled /> </div>
          Soframycin (Ointement)</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">31.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['epidural_cath'] == 1) echo "checked"; ?> disabled /> </div>
          Epidural Cath / Epidural Set No.</td>
        <td align="left">65.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['tab_depin'] == 1) echo "checked"; ?> disabled /> </div>
          Tab Depin</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">32.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['surgical_febrilar'] == 1) echo "checked"; ?> disabled /></div>
          Surgical / Febrilar</td>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">33.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['opsite_drage'] == 1) echo "checked"; ?> disabled /> </div>
          Opsite Drage No. 30 x 28 cms</td>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="22" align="left" valign="top">34.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientMRIDetails['MedicalRepSurgicalItem']['silverex_jar'] == 1) echo "checked"; ?> disabled /> </div>
          Silverex Jar / Cutasept 100 ml / 500 ml</td>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top" class="tdBorderTp" style="font-size:11px; letter-spacing:-0.4px; padding-top:5px; padding-bottom:10px;">
    	51, Second Right Lane from Lakmat Square, Near Jaipuria Banglow, Dhantoli Nagpur - 440 012 Tel. : 0712 - 2420951, 2420869, 6627900, Fax : 0712 - 2432551<br /> 
   	  E-mail : info@hopehospitals.in Visit us : www.hopehospitals.in    </td>
  </tr>
</table>
</body>
</html>
