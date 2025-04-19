<style>
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
	.textboxExpnd{
	    background: none repeat scroll 0 0 #121212;
	    border: 1px solid #212627;
	    color: #E7EEEF;
	    font-size: 13px;
	    outline: medium none;
	    padding: 5px 0;
    	width: 100%;
	}
.style1 {border-right: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; }
.style2 {border-bottom: 1px solid #000000; font-weight: bold; }
</style>
 
   <?php 
   if($this->params->query['allow']=='print'){
   		?>
   		<script>window.print();</script>
   		<?php 
   }
   
                  	echo $this->Form->create('BloodOrder',array('url'=>array('controller'=>'blood_banks','action'=>'blood_requisition_print'),'type' => 'post','id'=>'bloodfrm',
                  						'inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)
						));
                  ?>
                  <div style="float:right" id="printButton">
					<?php echo $this->Form->submit('Save & Print',array('class'=>'blueBtn','escape'=>false));?>
				  </div>&nbsp;<div>
				  </div>
     <table width="800" border="0" cellspacing="0" cellpadding="5" align="center">
      <tr>
    	<td align="center" style="font-size:26px; font-weight:bold; letter-spacing:-1px; padding-bottom:10px;">REQUISITION FOR BLOOD &amp; BLOOD COMPONENTS</td>
      </tr> 
  <tr>
    <td width="100%" height="25" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" valign="middle" class="boxBorder" style="padding:5px;">
            	Type of Request : <?php echo $this->data['BloodOrder']['type_of_request']; ?>
            </td>
            <td width="2%">&nbsp;</td>
            <td width="32%" valign="middle" class="boxBorder">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="63%" style="border-right:1px solid #000000; padding:5px;">Blood Group (If Known)</td>
                    <td width="37%" style="padding-left:40px;"><?php echo ucfirst($blood_group) ;?></td>
                  </tr>
                </table>
            </td> <td width="2%">&nbsp;</td>
            <td width="31%" valign="middle" class="boxBorder">
	            <table width="100%" border="0" cellspacing="0" cellpadding="0">
	              <tr>
	                <td width="35%" style="border-right:1px solid #000000; padding:5px;">Date & Time</td>
	                <td width="65%" style=" padding:2px 5px;"><?php 
	                	echo $this->DateFormat->formatDate2Local($this->data['BloodOrder']['order_date'],Configure::read('date_format'),true) ;
	                ?></td>
	              </tr> 
	            </table>
	         </td>
          </tr>
        </table>     </td>
  </tr>
  <tr>
    <td width="100%" height="30" align="left" valign="top" style="padding-top:3px;">Urgent / Rush requirements must be justified by the clinical situtation.<br />
      In emergency situation, a prior phone call is essential to understand the gravity of situation &amp; to expedite the blood supply.</td>
  </tr>
  <tr>
    <td width="100%" height="25" align="left" valign="bottom" style="padding-top:10px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="23%" valign="bottom">Name of Patient (in Capital) :</td>
            <td width="77%" style="">
                <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
                  <tr>
                    <td   style="text-transform:uppercase"><?php 
                                		echo  $patient[0]['lookup_name'] ;
                                	?></td>
                  </tr>
                </table>            </td>
          </tr>
        </table>     </td>
  </tr>
  <tr>
    <td width="100%" height="25" align="left" valign="top" style="padding-top:10px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="64" valign="bottom">Address :</td>
        <td width="514" style=""><?php echo str_replace("<br/>",' ',$address) ;?></td>
        <td width="16">&nbsp;</td>
        <td width="37">Age :</td>
        <td width="57" style=""><?php echo ucfirst($patient['Patient']['age']); ?></td>
        <td width="16">&nbsp;</td>
        <td width="35">Sex :</td>
        <td width="61" style=""><?php echo ucfirst($patient['Patient']['sex']); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" align="left" valign="top" style="padding-top:6px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="122" valign="bottom"><?php echo __("Room / Bed No");?>:</td>
          <td width="231" style=""><?php echo $ward_details['Ward']['name']." / ".$bed_details['Bed']['bedno']?></td>
          <td width="17">&nbsp;</td>
          <td width="214"><?php echo __("Patient MRN");?>:</td>         
          <td width="216" style=""><?php echo $patient['Patient']['admission_id'];?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td width="100%" height="30" align="left" valign="middle" style="font-size:12px;"><strong>(KINDLY IDENTIFY THE PATIENT PROPERLY. TAKE BLOOD SAMPLE &amp; LABEL PROPERLY.)</strong></td>
  </tr>
  <tr>
    <td width="100%" height="20" align="left" valign="middle" style="font-size:12px;"><strong>(MOST OF THE SERIOUS HAZARDS OF TRANSFUSION (SHOT) OR FATAL REACTIONS ARE DUE TO SAMPLING/ LABELLING ERRORS)</strong></td>
  </tr>
  <tr>
    <td height="25" align="left" valign="top" style="padding-top:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <?php if(!empty($this->data['BloodOrder']['diagnosis'])) {?>
          <td width="73" valign="top">Diagnosis :</td>
          <td width="283" style="" valign="top"><?php echo nl2br($this->data['BloodOrder']['diagnosis'] );?></td>
          <td width="15">&nbsp;</td>
          <?php }if(!empty($this->data['BloodOrder']['trans_indication'])){ ?>
          <td width="75" valign="top">Transfusion Indication :</td>
          <td width="164" style="" valign="top"><?php echo nl2br($this->data['BloodOrder']['trans_indication']); ?></td>
          <td width="9">&nbsp;</td>
          <?php }if(!empty($this->data['BloodOrder']['hb'])){?>
          <td width="38" valign="top">HB% :</td>
          <td width="67" style="" valign="top"><?php echo nl2br($this->data['BloodOrder']['hb']); ?></td>
          <?php }?>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" align="left" valign="top" style="padding-top:6px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        	<?php if(!empty($this->data['BloodOrder']['previous_transfusion_history'])){ ?>
	          <td width="211" valign="bottom">History of Previous Transfusion :</td>
	          <td width="142" style=""><?php echo nl2br($this->data['BloodOrder']['previous_transfusion_history']); ?></td>
	          <td width="17">&nbsp;</td>
          <?php } if(!empty($this->data['BloodOrder']['adverse_reaction'])) {?>
          <td width="214">Any adverse reaction reported? :</td>
          <td width="216" style=""><?php echo nl2br($this->data['BloodOrder']['adverse_reaction']); ?></td>
          <?php } ?>
        </tr>
    </table></td>
  </tr>
  <?php if(!empty($this->data['BloodOrder']['history_children_hdn'])) { ?>
  <tr>
    <td height="25" align="left" valign="top" style="padding-top:5px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="58%" valign="bottom">History of Pregnantes / Abortion / Previous Children HDN (if Applicable) :</td>
          <td width="42%" style=""><?php echo nl2br($this->data['BloodOrder']['history_children_hdn']); ?></td>
        </tr>
    </table></td>
  </tr>
  <?php } ?>
  <tr>
  	 <td height="25" align="left" valign="top" style="padding-top:5px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="35" valign="top" >Blood Bank :</td>
          <td width="250" ><?php 
          		if($this->params->query['allow']=='print'){
                 	  echo ucfirst($serviceProviders[$this->data['BloodOrder']['blood_bank_id']]);
                }else{  
		          	  echo $this->Form->hidden('id');
		          	  echo $this->Form->hidden('patient_id',array('value'=>$this->data['BloodOrder']['patient_id'])); 
		              echo $this->Form->input('blood_bank_id',
		              array('type'=>'select','options'=>$serviceProviders,'empty'=>__('Please Select'),'class'=>'textboxExpnd','style'=>'width:250px;'));
                }
        ?></td>
        </tr>
    </table></td> 
  </tr>
  <?php  $count =  count($this->data['BloodOrderOption']); 
  		if($count > 0 ) {
  ?>
  <tr>
    <td width="100%" align="left" valign="top">
	    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="boxBorder">
	      <tr>
	        <td width="50%" class="tdBorderRtBt" align="center"><strong>REQUIREMENT</strong></td>
	        <td width="18%" align="center" class="style1">UNITS</td>
	        <td width="32%" align="center" class="style2">ON DATE</td>
	      </tr>
	     	<?php  for($op=0;$op<$count;$op++){  ?>
	                <tr id="TestGroup<?php echo $op;?>">
                        <td class="tdBorderRtBt"><?php
                        	if($this->params->query['allow']=='print'){
                 				echo $this->data['BloodOrderOption'][$op]['tariff_list_alias_name'];
                 			}else{  
                 				
	                        	echo $this->Form->hidden('',array('name'=>"data[BloodOrderOption][$op][id]",'value'=>$this->data['BloodOrderOption'][$op]['id']));
	                        	
	                        	if(!empty($this->data['BloodOrderOption'][$op]['tariff_list_alias_name'])){
	                        		$aliasValue = $this->data['BloodOrderOption'][$op]['tariff_list_alias_name'] ; 
	                        	}else{
	                        		$aliasValue = $tariffListGroup[$this->data['BloodOrderOption'][$op]['tariff_list_id']] ;
	                        	} 
	                        	
	                        	echo $this->Form->input('',array( 
		                        	'value'=>$aliasValue,
		                        	'type'=>'text' ,'id'=>'tariff_list_id-'.$op,'class'=>'textboxExpnd',
		                        	'name'=>"data[BloodOrderOption][$op][tariff_list_alias_name]"));
                 				} 
                 			?></td>
	                            <td class="style1"><?php echo $this->data['BloodOrderOption'][$op]['units']?></td>
	                           <td class="style2"><?php 
	                           	echo $this->DateFormat->formatDate2Local($this->data['BloodOrderOption'][$op]['blood_transfusion_date'],Configure::read('date_format'),true) ;
	                           	 ?>
	                           </td>	   
                     </tr>    
                 <?php } ?>
	    </table>
	  </td>
  </tr>
  <?php } ?>
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="48%" valign="bottom">Name of Phlebotomist who has taken patient's blood sample</td>
        <td width="52%" style=""><?php echo $this->data['BloodOrder']['phlebotomist'] ;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-top:5px;">Please Send <strong><u>PROPERLY LABELED</u></strong> Patient's Blood in EDTA (1ml) &amp; Plain Bulb (5ml). In case of neonate, please send mother's blood sample also. I have read the instractions / rules overleaf &amp; will abide by it.</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="250" align="left" valign="top" style="padding-bottom:7px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
              		<td colspan="2" valign="top"><strong>Hospital Name</strong></td>
              </tr>
              <tr>
              		<td height="22" colspan="2" valign="bottom"  style=""><?php echo ucfirst($this->data['BloodOrder']['hospital']) ;?></td>
              </tr>
              <tr>
                <td width="20%" valign="bottom" style="padding-top:7px;">Ph. No.</td>
                <td width="80%" style="vertical-align:bottom;"><?php echo $this->data['BloodOrder']['hospital_phone'] ;?></td>
              </tr>
            </table></td>
            <td width="30" align="left" valign="top">&nbsp;</td>
            <td width="244" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" valign="top"><strong>Consultant's Sign :</strong></td>
              </tr>
              <tr>
              	<td height="22" valign="bottom">Name</td>
                <td valign="bottom"  style=""><?php echo $this->data['BloodOrder']['treating_consultant'] ;?></td>
              </tr>
              <tr>
                <td width="23%" valign="bottom" style="padding-top:7px;">Cell No.</td>
                <td width="77%" style="vertical-align:bottom;"><?php echo $this->data['BloodOrder']['treating_consultant_phone'] ;?></td>
              </tr>
            </table></td>
            <td width="30" align="left" valign="top">&nbsp;</td>
            <td width="246" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" valign="top"><strong>RMO Sign :</strong></td>
              </tr>
              <tr>
                <td height="22" valign="bottom">Name</td>
                <td valign="bottom"  style=""><?php echo ucwords($registrar[$this->data['BloodOrder']['registrar']])?></td>
              </tr>
              <tr>
                <td width="23%" valign="bottom" style="padding-top:7px;">Cell No.</td>
                <td width="77%" style="vertical-align:bottom;"><?php echo $this->data['BloodOrder']['registrar_phone'] ;?></td>
              </tr>
            </table></td>
          </tr>
        </table>    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td align="left" valign="top" style="border-top:2px dashed #000000; padding-top:5px; padding-bottom:5px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="250"><strong>FOR BLOOD BANK USE ONLY</strong></td>
            <td width="18" class="boxBorder">&nbsp;</td>
            <td width="118" style="padding-left:4px;">New Patient</td>
            <td width="18" class="boxBorder">&nbsp;</td>
            <td width="114" style="padding-left:4px;">Old Patient</td>
            <td width="58">BBR No.</td>
            <td width="142" style="">&nbsp;</td>
            <td width="82">&nbsp;</td>
          </tr>
        </table>      </td>
  </tr>
  <tr>
    <td height="25" align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="142" valign="bottom">Sample Received on :</td>
          <td width="135" style="">&nbsp;</td>
          <td width="10">&nbsp;</td>
          <td width="24">At :</td>
          <td width="102" style="">&nbsp;</td>
          <td width="36">&nbsp;</td>
          <td width="149">Patient's Blood Group :</td>
          <td width="87" style="">&nbsp;</td>
          <td width="20">&nbsp;</td>
          <td width="24">Rh</td>
          <td width="71" style="">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="92" valign="bottom">Received By :</td>
          <td width="321" style="">&nbsp;</td>
          <td width="36">&nbsp;</td>
          <td width="122">Technician Name :</td>
          <td width="229" style="">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="boxBorder" style="border-bottom:0px;">
      <tr>
        <td width="6%" align="center" class="tdBorderRtBt" style="font-size:12px;">Sr. No.</td>
        <td width="10%" align="center" class="tdBorderRtBt" style="font-size:12px;">Unit No.</td>
        <td width="11%" align="center" class="tdBorderRtBt" style="font-size:12px;">WB/Comp</td>
        <td width="10%" align="center" class="tdBorderRtBt" style="font-size:12px;">Group</td>
        <td width="10%" align="center" class="tdBorderRtBt" style="font-size:12px;">X Match</td>
        <td width="9%" align="center" class="tdBorderRtBt" style="font-size:12px;">Time</td>
        <td width="9%" align="center" class="tdBorderRtBt" style="font-size:12px;">Tech</td>
       
        <td width="8%" align="center" class="tdBorderRtBt" style="font-size:12px;">Issue No</td>
        <td width="9%" align="center" class="tdBorderRtBt" style="font-size:12px;">Date</td>
        <td width="9%" align="center" class="tdBorderRtBt" style="font-size:12px;">Time</td>
        <td width="8%" align="center" class="tdBorderBt" style="font-size:12px;">Tech</td>
      </tr>
      <tr>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">1</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderBt" style="font-size:12px;">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">2</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
    
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderBt" style="font-size:12px;">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">3</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
   
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderBt" style="font-size:12px;">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">4</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderBt" style="font-size:12px;">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">5</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderRtBt" style="font-size:12px;">&nbsp;</td>
        <td align="center" class="tdBorderBt" style="font-size:12px;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table>
<?php echo $this->Form->end();?>
