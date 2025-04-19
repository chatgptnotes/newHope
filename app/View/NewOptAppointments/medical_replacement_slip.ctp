<?php 
      //echo $this->Html->css(array('jquery.timepicker.css'));
      //echo $this->Html->script(array('jquery.timepicker'));
?>
<div class="inner_title">
                      <h3><?php echo __('MEDICAL REPLACEMENT SLIP'); ?></h3>
                      </div>
                         <p class="ht5"></p>  
                      <form name="medicalreplacementslipfrm" id="medicalreplacementslipfrm" action="<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "saveMedicalReplacementSlip")); ?>" method="post" > 
                      <?php
                           echo $this->Form->input('MedicalRepAntibiotic.patient_id', array('type' => 'hidden', 'value'=> '3')); 
                           echo $this->Form->input('MedicalRepInjectable.patient_id', array('type' => 'hidden', 'value'=> '3')); 
                           echo $this->Form->input('MedicalRepSurgicalItem.patient_id', array('type' => 'hidden', 'value'=> '3')); 
                           echo $this->Form->input('MedicalRepSuture.patient_id', array('type' => 'hidden', 'value'=> '3')); 
                      ?>
                      <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" style="min-width:800px;">
                   	  <tr>
                      	 <th colspan="6">SURGICAL ITEMS</th>
          			  </tr>
                      <tr>
                        <td width="35" align="center">1.</td>
                        <td width="350"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][bt_set]" value="1" /></div>IV Set / B.T. Set / Paediatricist</td>
                        <td width="35" align="center">35.</td>
                        <td width="350"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][tbact]" value="1" /></div>T-Bact / Neosparine (Ointment)</td>
                      </tr>
                      <tr>
                        <td align="center">2.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][turp_set]" value="1" /></div>T.U.R.P. Set / H2O2</td>
                        <td align="center">36.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][vasofix]" value="1" /></div>Vasofix / Scalp ven / Microset</td>
                      </tr>
                      <tr>
                        <td align="center">3.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][disposal_syringe]" value="1" /></div>Disposable Syringe 50, 20, 10, 05, 02 ml</td>
                        <td align="center">37.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][spinal_needle]" value="1" /></div>Spinal Needle No. 18, 20, 22, 23, 25</td>
                      </tr>
                      <tr>
                        <td align="center">4.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][disposal_needle]" value="1" /></div>Disposable Needle No.</td>
                        <td align="center">38.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][sofratulle]" value="1" /></div>Sofratulle / Framycetin Tulle</td>
                      </tr>
                      <tr>
                        <td align="center">5.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][loprep]" value="1" /></div>Ioprep 100 ml / 500 ml</td>
                        <td align="center">39.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][cotton_bundle]" value="1" /></div>Cotton Bundle / Gouze Bundle</td>
                      </tr>
                      <tr>
                        <td align="center">6.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][betadine100]" value="1" /></div>Betadine 100 ml / 500 ml</td>
                        <td align="center">40.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][xylocaine_jelly]" value="1" /></div>Xylocaine Jelly / Lignox Jelly</td>
                      </tr>
                      <tr>
                        <td align="center">7.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][savlon]" value="1" /></div>Savlon / Sterillium 100 ml / 500 ml</td>
                        <td align="center">41.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][strille_water]" value="1" /></div>Strille Water / IV Glycine</td>
                      </tr>
                      <tr>
                        <td align="center">8.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][ciplox_eye]" value="1" /></div>Ciplox Eye Ointment</td>
                        <td align="center">42.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][cap_mask]" value="1" /></div>Cap + Mask / Oxum 100 ml</td>
                      </tr>
                      <tr>
                        <td align="center">9.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][dynaplast]" value="1" /></div>Dynaplast / G. Plast 4&quot;, 6&quot;</td>
                        <td align="center">43.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][carm_cover]" value="1" /></div>C Arm Cover / Airway No. 2, 3, 4</td>
                      </tr>
                      <tr>
                        <td align="center">10.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][micropare]" value="1" /></div>Micropare 1&quot;, 4&quot;</td>
                        <td align="center">44.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][skin_stappler]" value="1" /></div>Skin Stappler / Skin Grafting Blade</td>
                      </tr>
                      <tr>
                        <td align="center">11.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][chest_leads]" value="1" /></div>Chest Leads / HIV Kit</td>
                        <td align="center">45.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][colostomy_drain]" value="1" /></div>Colostomy Drain Kit</td>
                      </tr>
                      <tr>
                        <td align="center">12.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][roll_bandage]" value="1" /></div>Roll Bandage (Big Size)</td>
                        <td align="center">46.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][gloves_box]" value="1" /></div>Gloves Box / Gypsona 6&quot;, 4&quot;</td>
                      </tr>
                      <tr>
                        <td align="center">13.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][softroll]" value="1" /></div>SoftRoll 4&quot;, 6&quot; / Dyncrepe 4&quot;, 6&quot;</td>
                        <td align="center">47.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][beta_scrub]" value="1" /></div>Beta Scrub / Bacillaxid</td>
                      </tr>
                      <tr>
                        <td align="center">14.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][venoline]" value="1" /></div>ven-o-line / Three way</td>
                        <td align="center">48.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][jonac_suppsitories]" value="1" /></div>Jonac Suppsitories</td>
                      </tr>
                      <tr>
                        <td align="center">15.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][surgical_blade]" value="1" /></div>Surgical Blade No. 22, 10, 15, 11</td>
                        <td align="center">49.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_rl_ml]" value="1" /></div>I.V. RL 500 ml</td>
                      </tr>
                      <tr>
                        <td align="center">16.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][electoclyss_enema]" value="1" /></div>Electoclyss Enema / Neotonic Enea</td>
                        <td align="center">50.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_dns_ml]" value="1" /></div>I.V. DNS 500 ml</td>
                      </tr>
                      <tr>
                        <td align="center">17.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][vaccu_suction]" value="1" /></div>Vaccu Suction Set</td>
                        <td align="center">51.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_dextrose_fivecent]" value="1" /></div>I.V. Dextrose 5%</td>
                      </tr>
                      <tr>
                        <td align="center">18.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][jet_foam]" value="1" /></div>Jet Foam / Bon Vax</td>
                        <td align="center">52.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_dextrose_tencent]" value="1" /></div>I.V. Dextrose 10%<br /></td>
                      </tr>
                      <tr>
                        <td align="center">19.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][surgical_gloves]" value="1" /></div>Surgical Gloves No. 6, 61/2, 7, 77 &frac12;, 8</td>
                        <td align="center">53.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_isolytee]" value="1" /></div>I.V. Isolyte E</td>
                      </tr>
                      <tr>
                        <td align="center">20.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][disposable_sponges]" value="1" /></div>Disposable Sponges (Soft Touch)</td>
                        <td align="center">54.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_isolytep]" value="1" /></div>I.V. Isolyte P</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">21.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][romo_vac]" value="1" /></div>Romo Vac Suction Drain<br />
                          No. 10, 12, 14, 16, 8</td>
                        <td align="center" valign="top">55.</td>
                        <td valign="top"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_isolytem]" value="1" /></div>I.V. Isolyte M</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">22.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][uro_bag]" value="1" /></div>Uro Bag / Gamjee Roll</td>
                        <td align="center">56.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_metrogyl]" value="1" /></div>I.V. Metrogyl / I.V. Mannitol</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">23.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][sanctin_cath]" value="1" /></div>Sanctin Cath / Nel Cath</td>
                        <td align="center">57.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_dextrose25]" value="1" /></div>I.V. Dextrose 25%</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">24.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][ryles_tube]" value="1" /></div>Ryles Tube No. 12, 14, 16, 18</td>
                        <td align="center">58.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_ns1000]" value="1" /></div>I.V. NS 1000 ml</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">25.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][feeding_tube]" value="1" /></div>Feeding Tube No. 6, 7, 8, 10</td>
                        <td align="center">59.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_ns500]" value="1" /></div>I.V. NS 500 ml</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">26.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][folys_cath]" value="1" /></div>Foly's Cath No. 12, 14, 16, 18</td>
                        <td align="center">60.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_cifran]" value="1" /></div>I.V. Cifran</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">27.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][way_folys_cath]" value="1" /></div>3 Way Foly's Cath No. 16, 18, 20, 22</td>
                        <td align="center">61.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][iv_hestar]" value="1" /></div>I.V. Hestar 6%, 3%</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">28.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][adk_no]" value="1" /></div>A.D.K. No. 20, 22, 24, 26, 28, 30, 32</td>
                        <td align="center">62.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][otrovin]" value="1" /></div>Otrovin (Nasal Drop)</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">29.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][plan_sheet]" value="1" /></div>Plan Sheet No. 301</td>
                        <td align="center">63.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][betadine]" value="1" /></div>Betadine (Ointment)</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">30.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][et_tubeno]" value="1" /></div>E.T. Tube No.</td>
                        <td align="center">64.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][soframycin]" value="1" /></div>Soframycin (Ointement)</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">31.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][epidural_cath]" value="1" /></div>Epidural Cath / Epidural Set No.</td>
                        <td align="center">65.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][tab_depin]" value="1" /></div>Tab Depin</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">32.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][surgical_febrilar]" value="1" /></div>Surgical / Febrilar</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">33.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][opsite_drage]" value="1" /></div>Opsite Drage No. 30 x 28 cms</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign="top" align="center">34.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSurgicalItem][silverex_jar]" value="1" /></div>Silverex Jar / Cutasept 100 ml / 500 ml</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    <div class="clr ht5"></div>
                    <div class="clr ht5"></div>
                	
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" style="min-width:800px;">
                   	  <tr>
                      	 <th colspan="2">INJECTABLE</th>
                         <th colspan="2">SUTURE</th>
          			  </tr>
                      <tr>
                        <td width="35" align="center">1.</td>
                        <td width="350"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_atropine]" value="1" /></div>Inj Atropine / Inj. Adranaline</td>
                        <td width="35" rowspan="2" align="center" valign="top">1.</td>
                        <td width="350" rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSuture][vicryl_cutting]" value="1" /></div>Vicryl on cutting on Round Body <br />
                        1.0, 1, 2.0, 3.0, 4.0, 5.0</td>
                      </tr>
                      <tr>
                        <td align="center">2.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_avil]" value="1" /></div>Inj Avil / Inj Atraccurum</td>
                      </tr>
                      <tr>
                        <td align="center">3.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_rantac]" value="1" /></div>Inj Rantac / Inj Zofer</td>
                        <td rowspan="2" align="center" valign="top">2.</td>
                        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSuture][monocryl]" value="1" /></div>Monocryl<br />
                        1.0, 1, 2.0, 3.0, 4.0, 5.0, 6.0</td>
                      </tr>
                      <tr>
                        <td align="center">4.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_butrum]" value="1"  /></div>Inj Butrum / Inj Buscopan</td>
                      </tr>
                      <tr>
                        <td align="center">5.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_cardirone]" value="1"  /></div>Inj Cardirone / Inj Cal Gluconate</td>
                        <td rowspan="2" align="center" valign="top">3.</td>
                        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSuture][ethilon_cutting]" value="1" /></div>Ethilon on cutting on Round Body<br />
                        1.0, 1, 2.0, 3.0, 4.0, 5.0, 6.0, 8.0</td>
                      </tr>
                      <tr>
                        <td align="center">6.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_dexona]" value="1" /></div>Inj Dexona / Inj Derphyllin</td>
                      </tr>
                      <tr>
                        <td align="center">7.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_drotin]" value="1" /></div>Inj Drotin / Inj Dobutanine</td>
                        <td rowspan="2" align="center" valign="top">4.</td>
                        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSuture][marsilk_cutting]" value="1" /></div>Marsilk on cutting on Round Body<br />
                        1.0, 1, 2.0, 3.0, 4.0, 5.0</td>
                      </tr>
                      <tr>
                        <td align="center">8.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_dopamin]" value="1" /></div>Inj Dopamin / Inj Digoxin</td>
                      </tr>
                      <tr>
                        <td align="center">9.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_dilatin]" value="1" /></div>Inj Dilatin / Inj Diazepam</td>
                        <td rowspan="2" align="center" valign="top">5.</td>
                        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSuture][cut_gat]" value="1" /></div>Cut-Gat (Cromic) on Cutting, Round Body<br />
                        1.0, 1, 2.0, 3.0, 4.0, 5.0, 6.0</td>
                      </tr>
                      <tr>
                        <td align="center">10.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_effcorline]" value="1" /></div>Inj Effcorline / Inj Epidocine</td>
                      </tr>
                      <tr>
                        <td align="center">11.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_fulsed]" value="1" /></div>Inj Fulsed / Inj Febrinil</td>
                        <td rowspan="2" align="center" valign="top">6.</td>
                        <td rowspan="2" valign="top"><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepSuture][proline_cutting]" value="1" /></div>Proline on cutting on Round Body<br />
                        1.0, 1, 3.0, 4.0, 5.0, 6.0, 8.0</td>
                      </tr>
                      <tr>
                        <td align="center">12.</td>
                        <td><div class="itemChkBox"><input type="checkbox"  name="data[MedicalRepInjectable][inj_gentamyclin]" value="1" /></div>Inj Gentamycin / Inj Glycoparolate</td>
                      </tr>
                      <tr>
                        <td align="center">13.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_ketamol]" value="1" /></div>Inj Ketamol / Inj Ketamine / Inj Kesol</td>
                        <td colspan="2" align="left" style="background-color: #394145; font-size: 12px;"><strong>ANTIBIOTICS</strong></td>
                      </tr>
                      <tr>
                        <td align="center">14.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_mgso4]" value="1" /></div>Inj MgSo4 / Inj Methelin Blue</td>
                        <td align="center">1.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_ampilox]" value="1" /></div>Inj Ampilox 250 mg/500 mg</td>
                      </tr>
                      <tr>
                        <td align="center">15.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_lasix]" value="1" /></div>Inj Lasix / Inj Lorazepam</td>
                        <td align="center">2.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_taxim]" value="1" /></div>Inj Taxim 250 mg / 500 mg</td>
                      </tr>
                      <tr>
                        <td align="center">16.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_nootropil]" value="1" /></div>Inj Nootropil / Inj Neostgmine</td>
                        <td align="center">3.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_supacef]" value="1" /></div>Inj Supacef 250 mg / 2.5 g</td>
                      </tr>
                      <tr>
                        <td align="center">17.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_ntg]" value="1" /></div>Inj N.T.G. / Inj Noradraline</td>
                        <td align="center">4.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_augmentine]" value="1" /></div>Inj Augmentine 1.2 gm</td>
                      </tr>
                      <tr>
                        <td align="center">18.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_sylate]" value="1" /></div>Inj Sylate / Inj Contramol</td>
                        <td align="center">5.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_zobactum]" value="1" /></div>Inj Zobactum 4.5 g / 2.25 g</td>
                      </tr>
                      <tr>
                        <td align="center">19.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_prostodine]" value="1" /></div>Inj Prostodine / Inj Pitocine</td>
                        <td align="center">6.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_amikacin]" value="1" /></div>Inj Amikacin 500 gm</td>
                      </tr>
                      <tr>
                        <td align="center">20.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_phenorberb]" value="1" /></div>Inj Phenorberb / Inj Fortwin</td>
                        <td align="center">7.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_monocef]" value="1" /></div>Inj Monocef 500 mg / 1 gm</td>
                      </tr>
                      <tr>
                        <td align="center">21.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_pavlon]" value="1" /></div>Inj Pavlon / Inj Phenargen</td>
                        <td align="center">8.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_keftagard]" value="1" /></div>Inj Keftagard 1 gm / 1.5 gm</td>
                      </tr>
                      <tr>
                        <td align="center">22.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_sodabicarb]" value="1" /></div>Inj Sodabicarb / Inj Vit K</td>
                        <td align="center">9.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_meropenem]" value="1" /></div>Inj Meropenem 1 g</td>
                      </tr>
                      <tr>
                        <td align="center">23.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_voveran]" value="1" /></div>Inj Voveran / Inj Tramadol</td>
                        <td align="center">10.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_novapime]" value="1" /></div>Inj Novapime 1 g / 500 mg</td>
                      </tr>
                      <tr>
                        <td align="center">24.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_vaccuronium]" value="1" /></div>Inj Vaccuronium 4 mg / 10 mg</td>
                        <td align="center">11.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_vancomy]" value="1" /></div>Inj Vancomy cine 1 gm / 500 mg</td>
                      </tr>
                      <tr>
                        <td align="center">25.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_wycort]" value="1" /></div>Inj Wycort / Inj Xylocaine 4%</td>
                        <td align="center">12.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_pantodec]" value="1" /></div>Inj Pantodec</td>
                      </tr>
                      <tr>
                        <td align="center">26.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_thayopetone]" value="1" /></div>Inj Thayopetone / Inj Scoline</td>
                        <td align="center">13.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_lactagard]" value="1" /></div>Inj Lactagard 1 g / 2 g</td>
                      </tr>
                      <tr>
                        <td align="center">27.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_heparine]" value="1" /></div>Inj Heparine / Inj Sylocard 2%</td>
                        <td align="center">14.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_klox]" value="1" /></div>Inj Klox 500 mg</td>
                      </tr>
                      <tr>
                        <td align="center">28.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_xylocaine]" value="1" /></div>Inj Xylocaine with Adrananline</td>
                        <td align="center">15.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][novamox500]" value="1" /></div>Novamox 500 mg / 1.5</td>
                      </tr>
                      <tr>
                        <td align="center">29.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_buprigestic]" value="1" /></div>Inj Buprigesic / Inj Bricanyl / Inj Epidosin</td>
                        <td align="center">16.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_sulbacin]" value="1" /></div>Inj Sulbacin 750 mg / 1.5</td>
                      </tr>
                      <tr>
                        <td align="center">30.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_pcm]" value="1" /></div>Inj P.C.M. / Inj Perinorm</td>
                        <td align="center">17.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_reflin]" value="1" /></div>Inj Reflin 500 mg / 1g</td>
                      </tr>
                      <tr>
                        <td align="center">31.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_betaloc]" value="1" /></div>Inj Betaloc / Inj Myoparolate</td>
                        <td align="center">18.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_magnamycin]" value="1" /></div>Inj Magnamycin 1 g / 2 g</td>
                      </tr>
                      <tr>
                        <td align="center">32.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_sensorcaine]" value="1" /></div>Inj Sensorcaine Heavy 5% / Mephentine</td>
                        <td align="center">19.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_dalacin]" value="1" /></div>Inj Dalacin</td>
                      </tr>
                      <tr>
                        <td align="center">33.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_serenace]" value="1" /></div>Inj Serenace / Inj Fentanyl</td>
                        <td align="center">20.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepAntibiotic][inj_tobraneg]" value="1" /></div>Inj Tobraneg</td>
                      </tr>
                      <tr>
                        <td align="center">34.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_aminophyline]" value="1" /></div>Inj Aminophyline / Inj Fentanyl</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center">35.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_ketanov]" value="1" /></div>Inj Ketanov / Inj Sensorcaine 0.5% Vial</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center">36.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_botroclot]" value="1" /></div>Inj Botroclot / Halothine</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center">37.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_xylocaine2]" value="1" /></div>Inj Xylocaine 2% / Inj Fosphen</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center">38.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_solumedrol]" value="1" /></div>Inj Solumedrol / Depomedrol</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center">39.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_succimed]" value="1" /></div>Inj Succimed / Inj Lox Heavy 5%</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center">40.</td>
                        <td><div class="itemChkBox"><input type="checkbox" name="data[MedicalRepInjectable][inj_propofol]" value="1" /></div>Inj Propofol 10 ml, 20 ml, 50 ml</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                   
				<div class="btns">
                           <input type="submit" value="Submit" class="blueBtn" tabindex="17" >
                           <input name="" type="button" value="Print" class="blueBtn" tabindex="18"/>
                           <?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn', 'tabindex' => '19')); ?>
		    </div>
                    <div class="clr ht5"></div>

         </form>
