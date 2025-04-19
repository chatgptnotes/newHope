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
.itemChkBox1 {float:right; margin-left:25px; margin-right:10px;}
</style>
</head>

<body onload="window.print();window.close();">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="100%" align="left" valign="top" style="border-bottom:1px solid #000000;">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td valign="bottom" style="padding-right:10px;">&nbsp;</td>
                <td align="right" width="200"><?php echo $this->Html->image('/img/hope-logo-sm.gif', array('alt' => '')); ?></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td width="100%" height="20" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" height="25" align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" style="min-width:800px;">
      <tr>
        <th colspan="2" align="left" class="subhead" style="padding-bottom:15px;"><?php echo __('INJECTABLE'); ?></th>
        <th colspan="2" align="left" class="subhead" style="padding-bottom:15px;"><?php echo __('SUTURE'); ?></th>
      </tr>
      <tr>
        <td width="35" height="22" align="left">1.</td>
        <td width="350"><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_atropine'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Atropine / Inj. Adranaline</td>
        <td width="35" rowspan="2" align="left" valign="top">1.</td>
        <td width="350" rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" <?php if($patientSutDetails['MedicalRepSuture']['vicryl_cutting'] == 1) echo "checked"; ?> disabled /> </div>
          Vicryl on cutting on Round Body <br />
          1.0, 1, 2.0, 3.0, 4.0, 5.0</td>
      </tr>
      <tr>
        <td height="22" align="left">2.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_avil'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Avil / Inj Atraccurum</td>
      </tr>
      <tr>
        <td height="22" align="left">3.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_rantac'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Rantac / Inj Zofer</td>
        <td rowspan="2" align="left" valign="top">2.</td>
        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" <?php if($patientSutDetails['MedicalRepSuture']['monocryl'] == 1) echo "checked"; ?> disabled /> </div>
          Monocryl<br />
          1.0, 1, 2.0, 3.0, 4.0, 5.0, 6.0</td>
      </tr>
      <tr>
        <td height="22" align="left">4.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_butrum'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Butrum / Inj Buscopan</td>
      </tr>
      <tr>
        <td height="22" align="left">5.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_cardirone'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Cardirone / Inj Cal Gluconate</td>
        <td rowspan="2" align="left" valign="top">3.</td>
        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" <?php if($patientSutDetails['MedicalRepSuture']['ethilon_cutting'] == 1) echo "checked"; ?> disabled /> </div>
          Ethilon on cutting on Round Body<br />
          1.0, 1, 2.0, 3.0, 4.0, 5.0, 6.0, 8.0</td>
      </tr>
      <tr>
        <td height="22" align="left">6.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_dexona'] == 1) echo "checked"; ?> disabled /> </div>Inj Dexona / Inj Derphyllin</td>
      </tr>
      <tr>
        <td height="22" align="left">7.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_drotin'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Drotin / Inj Dobutanine</td>
        <td rowspan="2" align="left" valign="top">4.</td>
        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" <?php if($patientSutDetails['MedicalRepSuture']['marsilk_cutting'] == 1) echo "checked"; ?> disabled /> </div>
          Marsilk on cutting on Round Body<br />
          1.0, 1, 2.0, 3.0, 4.0, 5.0</td>
      </tr>
      <tr>
        <td height="22" align="left">8.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_dopamin'] == 1) echo "checked"; ?> disabled /> </div>Inj Dopamin / Inj Digoxin</td>
      </tr>
      <tr>
        <td height="22" align="left">9.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_dilatin'] == 1) echo "checked"; ?> disabled /></div>
          Inj Dilatin / Inj Diazepam</td>
        <td rowspan="2" align="left" valign="top">5.</td>
        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" <?php if($patientSutDetails['MedicalRepSuture']['cut_gat'] == 1) echo "checked"; ?> disabled /> </div>
          Cut-Gat (Cromic) on Cutting, Round Body<br />
          1.0, 1, 2.0, 3.0, 4.0, 5.0, 6.0</td>
      </tr>
      <tr>
        <td height="22" align="left">10.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_effcorline'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Effcorline / Inj Epidocine</td>
      </tr>
      <tr>
        <td height="22" align="left">11.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_fulsed'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Fulsed / Inj Febrinil</td>
        <td rowspan="2" align="left" valign="top">6.</td>
        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" <?php if($patientSutDetails['MedicalRepSuture']['proline_cutting'] == 1) echo "checked"; ?> disabled /> </div>
          Proline on cutting on Round Body<br />
          1.0, 1, 3.0, 4.0, 5.0, 6.0, 8.0</td>
      </tr>
      <tr>
        <td height="22" align="left">12.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_gentamyclin'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Gentamycin / Inj Glycoparolate</td>
      </tr>
      <tr>
        <td height="22" align="left">13.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_ketamol'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Ketamol / Inj Ketamine / Inj Kesol</td>
        <td colspan="2" align="left" class="subhead" style="padding-bottom:5px;"><strong>ANTIBIOTICS</strong></td>
      </tr>
      <tr>
        <td height="22" align="left">14.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_mgso4'] == 1) echo "checked"; ?> disabled /> </div>
          Inj MgSo4 / Inj Methelin Blue</td>
        <td align="left">1.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_ampilox'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Ampilox 250 mg/500 mg</td>
      </tr>
      <tr>
        <td height="22" align="left">15.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_lasix'] == 1) echo "checked"; ?> disabled /></div>
          Inj Lasix / Inj Lorazepam</td>
        <td align="left">2.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_taxim'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Taxim 250 mg / 500 mg</td>
      </tr>
      <tr>
        <td height="22" align="left">16.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_nootropil'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Nootropil / Inj Neostgmine</td>
        <td align="left">3.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_supacef'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Supacef 250 mg / 2.5 g</td>
      </tr>
      <tr>
        <td height="22" align="left">17.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_ntg'] == 1) echo "checked"; ?> disabled /> </div>
          Inj N.T.G. / Inj Noradraline</td>
        <td align="left">4.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_augmentine'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Augmentine 1.2 gm</td>
      </tr>
      <tr>
        <td height="22" align="left">18.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_sylate'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Sylate / Inj Contramol</td>
        <td align="left">5.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_zobactum'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Zobactum 4.5 g / 2.25 g</td>
      </tr>
      <tr>
        <td height="22" align="left">19.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_prostodine'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Prostodine / Inj Pitocine</td>
        <td align="left">6.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_amikacin'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Amikacin 500 gm</td>
      </tr>
      <tr>
        <td height="22" align="left">20.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_phenorberb'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Phenorberb / Inj Fortwin</td>
        <td align="left">7.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_monocef'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Monocef 500 mg / 1 gm</td>
      </tr>
      <tr>
        <td height="22" align="left">21.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_pavlon'] == 1) echo "checked"; ?> disabled />  </div>
          Inj Pavlon / Inj Phenargen</td>
        <td align="left">8.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_keftagard'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Keftagard 1 gm / 1.5 gm</td>
      </tr>
      <tr>
        <td height="22" align="left">22.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_sodabicarb'] == 1) echo "checked"; ?> disabled />  </div>
          Inj Sodabicarb / Inj Vit K</td>
        <td align="left">9.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_meropenem'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Meropenem 1 g</td>
      </tr>
      <tr>
        <td height="22" align="left">23.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_voveran'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Voveran / Inj Tramadol</td>
        <td align="left">10.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_novapime'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Novapime 1 g / 500 mg</td>
      </tr>
      <tr>
        <td height="22" align="left">24.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_vaccuronium'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Vaccuronium 4 mg / 10 mg</td>
        <td align="left">11.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_vancomy'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Vancomy cine 1 gm / 500 mg</td>
      </tr>
      <tr>
        <td height="22" align="left">25.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_wycort'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Wycort / Inj Xylocaine 4%</td>
        <td align="left">12.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_pantodec'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Pantodec</td>
      </tr>
      <tr>
        <td height="22" align="left">26.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_thayopetone'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Thayopetone / Inj Scoline</td>
        <td align="left">13.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_lactagard'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Lactagard 1 g / 2 g</td>
      </tr>
      <tr>
        <td height="22" align="left">27.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_heparine'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Heparine / Inj Sylocard 2%</td>
        <td align="left">14.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_klox'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Klox 500 mg</td>
      </tr>
      <tr>
        <td height="22" align="left">28.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_xylocaine'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Xylocaine with Adrananline</td>
        <td align="left">15.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['novamox500'] == 1) echo "checked"; ?> disabled /> </div>
          Novamox 500 mg / 1.5</td>
      </tr>
      <tr>
        <td height="22" align="left">29.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_buprigestic'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Buprigesic / Inj Bricanyl / Inj Epidosin</td>
        <td align="left">16.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_sulbacin'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Sulbacin 750 mg / 1.5</td>
      </tr>
      <tr>
        <td height="22" align="left">30.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_pcm'] == 1) echo "checked"; ?> disabled /> </div>
          Inj P.C.M. / Inj Perinorm</td>
        <td align="left">17.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_reflin'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Reflin 500 mg / 1g</td>
      </tr>
      <tr>
        <td height="22" align="left">31.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_betaloc'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Betaloc / Inj Myoparolate</td>
        <td align="left">18.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_magnamycin'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Magnamycin 1 g / 2 g</td>
      </tr>
      <tr>
        <td height="22" align="left">32.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_sensorcaine'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Sensorcaine Heavy 5% / Mephentine</td>
        <td align="left">19.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_dalacin'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Dalacin</td>
      </tr>
      <tr>
        <td height="22" align="left">33.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_serenace'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Serenace / Inj Fentanyl</td>
        <td align="left">20.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientAntiDetails['MedicalRepAntibiotic']['inj_tobraneg'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Tobraneg</td>
      </tr>
      <tr>
        <td height="22" align="left">34.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_aminophyline'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Aminophyline / Inj Fentanyl</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="22" align="left">35.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_ketanov'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Ketanov / Inj Sensorcaine 0.5% Vial</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="22" align="left">36.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_botroclot'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Botroclot / Halothine</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="22" align="left">37.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_xylocaine2'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Xylocaine 2% / Inj Fosphen</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="22" align="left">38.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_solumedrol'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Solumedrol / Depomedrol</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="22" align="left">39.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_succimed'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Succimed / Inj Lox Heavy 5%</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="22" align="left">40.</td>
        <td><div class="itemChkBox"><input type="checkbox" <?php if($patientInjectDetails['MedicalRepInjectable']['inj_propofol'] == 1) echo "checked"; ?> disabled /> </div>
          Inj Propofol 10 ml, 20 ml, 50 ml</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  
</table>
</body>
</html>
