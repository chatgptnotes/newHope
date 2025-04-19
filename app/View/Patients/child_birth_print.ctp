<style>
	body{margin:0px; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;}
	.boxBorder{border:1px solid #000000;}
	.boxBorderBot{border-bottom:1px solid #999999;}
	.boxBorderRight{border-right:1px solid #999999;}
	.tdBorderRtBt{border-right:1px solid #999999; border-bottom:1px solid #999999;}
	.tdBorderBt{border-bottom:1px solid #999999;}
	.tdBorderTp{border-top:1px solid #999999;}
	.tdBorderRt{border-right:1px solid #999999;}
	.tdBorderTpBt{border-bottom:1px solid #999999; border-top:1px solid #999999;}
	.tdBorderTpRt{border-top:1px solid #999999; border-right:1px solid #999999;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	.second-header-left{
		  border-left:1px solid #000000;border-right:1px solid #000000; border-top:1px solid #000000; padding:5px; line-height:17px;
	}
	.second-header-right{
		  border-right:1px solid #000000; border-top:1px solid #000000; padding:5px; line-height:17px;
	}
	.second-inner-left{
		border :1px solid #000000;border-left:1px solid #000000;padding:5px;
	}
	.second-inner-right{
		border-top:1px solid #000000;border-bottom:1px solid #000000;border-right:1px solid #000000;padding:5px;
	}
	
</style>
<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td width="100%" align="center" valign="top" style="font-weight:bold; padding-bottom:10px;">BIRTH CERTIFICATE</td>
    
  </tr> 
  
  <tr>
    <td width="100%" height="25" align="left" valign="top" class="boxBorder">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="438" valign="top" style="border-right:1px #000000; border-bottom:1px solid #000000; padding:5px;">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="284" style="text-align:center;"><strong>BIRTH REPORT</strong></td>
              </tr>
              <tr>
                <td height="15" colspan="2" align="center" valign="top">Legal Information</td>
              </tr>
              <tr>
                <td height="20" colspan="2" style="padding-left:10px;">This part to be added to the Birth Register</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td align="left" valign="top" style="border-right:1px #000000; border-bottom:1px solid #000000; padding:5px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="19" colspan="2" align="center" valign="top">To be filled by the informant</td>
              </tr>
              <tr>
                <td width="20" align="left" valign="top">1.</td>
                <td width="385" align="left" valign="top" style="padding-bottom:10px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="76">Date of Birth :</td>
                        <td width="309" style="border-bottom:1px dotted #000000;"><?php echo $data['dob'];?></td>
                      </tr>
                      <tr>
                        <td height="17" colspan="2" valign="bottom">(Enter the exact day, month and year the child was born e.g. 1-1-2002)</td>
                      </tr>
                     </table ></td>
              </tr>
              <tr>
                <td align="left" valign="top">2.</td>
                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="76">Sex :</td>
                      <td width="309" style="border-bottom:1px dotted #000000;"><?php echo ($data['sex']=='son')?ucfirst('Male'):'Female' ;?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom">(Enter "male" or "female", do not use abbreviation)</td>
                    </tr>
                </table>                </td>
              </tr>
              <tr>
                <td align="left" valign="top">3.</td>
                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="76">Name of the child, if any :</td>
                      <td width="309" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['name']);?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom">(if not named, leave blank)</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">4.</td>
                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="76">Name of the father :</td>
                      <td width="309" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['father_name']);?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom">(full name as usually written)</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">5.</td>
                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="76">Name of the mother :</td>
                      <td width="309" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['mother_name']);?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom">(full name as usually written)</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">6.</td>
                <td align="left" valign="top" style="padding-bottom:10px;">Place of birth:(Tick the appropriate entry 1 or 2 below and given the name of the Hospital / Institution or the address of the house where the birth took place)</td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="5" cellpadding="0">
                    <tr>
                      <td width="76">1. Hospital/Institution Name :</td>
                      <td width="309" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['hospital_name']);?></td>
                    </tr> 
                    <tr>
                      <td>2. House Address :</td>
                      <td  style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['house_address']);?></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">7.</td>
                <td align="left" valign="top" style="padding-bottom:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="76">Informant's name :</td>
                      <td width="309" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['informant_name']);?></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="76">Address :</td>
                    <td width="309" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['informant_address']);?></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="padding-top:2px;">(After completing all columns 1 to 20, informant will put date and signature here.)</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
              	<td align="left" valign="top">&nbsp;</td>
                <td colspan="2" align="left" valign="top" style="padding-top:12px; padding-bottom:5px;">
          			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="76" style="padding-left:5px;">Date:</td>
                        <td width="336" align="right">Signature or left thumb mark of the informant</td>
                      </tr>
                    </table>                 </td>
              </tr>
            </table>            </td>
             
          </tr>
          <tr>
            <td valign="top" style="border-right:1px #000000; padding:5px 10px;">
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td  colspan="4" align="center" valign="top">To be filled by the Registrar</td>
              </tr>
              <tr>
                <td width="15%">Registration No. :</td>
                <td width="35%" style="border-bottom:1px dotted #000000;">&nbsp;</td>
                <td width="15%">Registration Date :</td>
                <td width="35%" style="border-bottom:1px dotted #000000;">&nbsp;</td>
              </tr>
              <tr>
                <td   align="left" valign="bottom">Registration Unit :</td>
                <td colspan="3" align="left" valign="bottom" style="border-bottom:1px dotted #000000;">&nbsp;</td>
              </tr>
              <tr> 
                        <td  height="20">Town / Village : </td>
                        <td   style="border-bottom:1px dotted #000000;">&nbsp;</td>
                        <td  >District :</td>
                        <td   style="border-bottom:1px dotted #000000;">&nbsp;</td>
                      
              </tr>
              <tr> 
                    <td  >Remarks : (if any) :</td>
                    <td colspan="3" style="border-bottom:1px dotted #000000;">&nbsp;</td>                    
                  
              </tr>
              <tr>
              	<td>&nbsp;</td>
              </tr>
              <tr>
                <td height="35" colspan="4" align="right" valign="bottom">Name and Signature of the Registrar</td>
              </tr>
            </table></td> 
  	</tr>
	</table>
	</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<!-- BOF second page -->
	
	<tr class='page-break'>
		<td colspan="2" >
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="336" valign="top" class="second-header-left">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="89" style="font-size:11px; padding-left:5px;">(See Rule - 12)</td>
                    <td width="110" align="center"><strong>BIRTH REPORT</strong></td>
                    <td width="89" align="right" style="padding-right:5px;">Birth Register</td>
                  </tr>
                  <tr>
                    <td height="18" colspan="3" align="center"><strong>Statistical Information</strong></td>
              	  </tr>
                  <tr>
                    <td colspan="3" align="center">This part to be detached and sent for statistical processing</td>
                  </tr>
                </table>
			</td>
            <td width="50%" valign="top"  class="second-header-right">If the case of multiple births, in a separate from for each child and writetwin birth or triple birth etc. as the case may be in the remarks column in the box below left.</td>
	</tr>
	<tr>
			<td align="left" valign="top"  class="second-inner-left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="19" colspan="2" align="center" valign="top">To be filled by the informant</td>
              </tr>
              <tr>
                <td width="24" align="left" valign="top">8.</td>
                <td width="301" align="left" valign="top" style="padding-bottom:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="17" valign="top">Town or Village or Residence of the mother :</td>
                    </tr>
                    <tr>
                      <td height="17" valign="bottom">(Place where the mother usually lives. This can be different from the place where the delivery occurred. The house address is not required to be entered)</td>
                    </tr>
                </table
                  ></td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" style="padding-bottom:10px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top" style="padding-bottom:5px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20" valign="top">a)</td>
                        <td width="136">Name of Town / Village :</td>
                        <td width="145" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['city']);?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" style="padding-bottom:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="20" valign="top">b)</td>
                          <td width="136">Is it town or village :</td>
                          <td width="145"><?php echo ucfirst($data['is_town']);?></td>
                          </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" style="padding-bottom:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="20" valign="top">c)</td>
                          <td width="136">Name of District :</td>
                          <td width="145" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['district']);?></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" style="padding-bottom:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="20" valign="top">d)</td>
                          <td width="136">Name of State :</td>
                          <td width="145" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['state']);?></td>
                        </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
               <tr>
                    <td align="left" valign="top">10.</td>
	                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                    <tr>
	                      <td width="153">Religion of the family :</td>
	                      <td width="141" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['religion']);?></td>
	                    </tr> 
                		</table>
                	</td>
	           </tr>  
              </tr>
              <tr>
                <td align="left" valign="top">10.</td>
                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="153">Father's level of education :</td>
                      <td width="141" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['father_edu']);?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom" style="padding-top:2px;">(Enter the completed level of education e.g. if studied upto class VII but passed only class VI, write class VI)</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">11.</td>
                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="153">Mother's level of education :</td>
                      <td width="143" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['mother_edu']);?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom" style="padding-top:2px;">(Enter the completed level of education e.g. if studied upto class VII but passed only class VI, write class VI)</td>
                    </tr>
                </table></td>
              </tr>

              <tr>
                <td align="left" valign="top">12.</td>
                <td align="left" valign="top" style="padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="153">Father's occupation :</td>
                      <td width="141" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['father_occu']);?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom" style="padding-top:2px;">(if no occupation write 'Nil')</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">13.</td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="153">Mother's occupation :</td>
                      <td width="141" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['mother_occu']);?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom" style="padding-top:2px;">(if no occupation write 'Nil')</td>
                    </tr>
                </table></td>
              </tr>
              
            </table></td>
            <td align="left" valign="top"  class="second-inner-right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="19" colspan="2" align="center" valign="top">To be filled by the informant</td>
              </tr>
              <tr>
                <td width="25" align="left" valign="top">14.</td>
                <td width="289" align="left" valign="top" style="padding-bottom:7px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" valign="top" style="padding-bottom:1px;">Age of the mother (in completed years)</td>
                  </tr>
                  <tr>
                    <td width="137">at the time of marriage :</td>
                    <td width="158" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['mother_age_when_marry']);?></td>
                  </tr>
                  <tr>
                    <td height="17" colspan="2" valign="bottom" style="padding-top:2px;">(if married more than once, age at first marriage may be entered)</td>
                  </tr>
                </table></td>
              </tr>

              <tr>
                <td align="left" valign="top">15.</td>
                <td width="289" align="left" valign="top" style="padding-bottom:7px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="2" valign="top" style="padding-bottom:1px;">Age of the mother (in completed years)</td>
                    </tr>
                    <tr>
                      <td width="132">at the time of this birth :</td>
                      <td width="157" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['mother_age_at_this_birth']);?></td>
                    </tr>

                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">16.</td>
                <td width="289" align="left" valign="top" style="padding-bottom:7px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="2" valign="top" style="padding-bottom:1px;">Number of children born alive to the</td>
                    </tr>
                    <tr>
                      <td width="191">mother so far including this child :</td>
                      <td width="98" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['no_of_child']);?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom" style="padding-top:2px;">(Number of children born alive to include also those from earlier marriage (s), if any)</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">17.</td>
                <td align="left" valign="top" style="padding-bottom:7px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="158">Type of attention at delivery :</td>
                      <td width="143" style="border-bottom:1px dotted #000000;"><?php  $attentionArr = array('Institutional - Government',
					'Institutional - Private or Non-Government',
					'Doctor, Nurse or Trained midwife',
					'Traditional Birth Attendant',
					'Relative or others'
					);
                      echo ucfirst($attentionArr[$data['type_of_attention']]);?></td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom" style="padding-top:2px; padding-bottom:2px;">(Tick the appropriate entry below)</td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom" style="padding-top:2px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="21" valign="top">1.</td>
                          <td height="17" align="left" valign="top">Institutional - Government</td>
                        </tr>
                        <tr>
                          <td valign="top">2.</td>
                          <td height="17" align="left" valign="top">Institutional - Private or Non-Government</td>
                        </tr>
                        <tr>
                          <td valign="top">3. </td>
                          <td height="17" align="left" valign="top">Doctor, Nurse or Trained midwife</td>
                        </tr>
                        <tr>
                          <td valign="top">4.</td>
                          <td height="17" align="left" valign="top">Traditional Birth Attendant</td>
                        </tr>
                        <tr>
                          <td valign="top">5.</td>
                          <td align="left" valign="top">Relative or others</td>
                        </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">18.</td>
                <td align="left" valign="top" style="padding-bottom:7x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="111">                      Method of Delivery  :</td>
                        <td width="178" style="border-bottom:1px dotted #000000;">
                      	<?php 
                      			$deliveryMethod = array('Natural','Caesarean','Forceps / Vaccum');
                      			 echo ucfirst($deliveryMethod[$data['method_of_delivery']]);
						?>
						</td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom" style="padding-top:2px; padding-bottom:2px;">(Tick the appropriate entry below)</td>
                    </tr>
                    <tr>
                      <td height="17" colspan="2" valign="bottom" style="padding-top:2px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="21" valign="top">1.</td>
                            <td height="20" align="left" valign="top">Natural &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.&nbsp;&nbsp; Caesarean</td>
                          </tr>

                          <tr>
                            <td valign="top">3. </td>
                            <td height="20" align="left" valign="top">Forceps / Vaccum</td>
                          </tr>

                      </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">19.</td>
                <td align="left" valign="top" style="padding-bottom:5px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="194">Birth Weight (in kgs.) (if available) :</td>
                      <td width="95" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['birth_weight']);?></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">20.</td>
                <td align="left" valign="top" style="padding-bottom:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="194">Duration of pregnancy (in weeks) :</td>
                    <td width="95" style="border-bottom:1px dotted #000000;"><?php echo ucfirst($data['pregnancy_duration']);?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="right" valign="top" style="font-size:11px;">(Columns to be filled are over. Now put signature at left)</td>
              </tr>
            </table></td>
</tr>
<tr>
	<td align="left" valign="top" style="border-bottom:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000; padding:5px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="20" align="right" valign="top">To be filled by </td>
              </tr>
              <tr>
                <td style="padding-bottom:12px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="14%">Name :</td>
                        <td width="53%" style="border-bottom:1px dotted #000000;">&nbsp;</td>
                        <td width="18%">Code No :</td>
                        <td width="15%" style="border-bottom:1px dotted #000000;">&nbsp;</td>
                      </tr>
                    </table>                </td>
              </tr>

              <tr>
                <td style="padding-bottom:12px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="15%">District :</td>
                      <td width="43%" style="border-bottom:1px dotted #000000;">&nbsp;</td>
                      <td width="42%">&nbsp;</td>                      
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td style="padding-bottom:12px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="14%">Tahsil :</td>
                      <td width="44%" style="border-bottom:1px dotted #000000;">&nbsp;</td>
                      <td width="42%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="27%">Town / Village :</td>
                      <td width="29%" style="border-bottom:1px dotted #000000;">&nbsp;</td>
                      <td width="31%">Registration Unit :</td>
                      <td width="13%" style="border-bottom:1px dotted #000000;">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
            <td align="left" valign="top" style="padding:5px 10px;border-right:1px solid #000000;border-bottom:1px solid #000000;">
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td height="20" colspan="4" align="left" valign="top">the Registrar</td>
              </tr>
              <tr>
                <td width="98">Registration No. :</td>
                <td width="40" style="border-bottom:1px dotted #000000;">&nbsp;</td>
                <td width="106">Registration Date :</td>
                <td width="60" style="border-bottom:1px dotted #000000;">&nbsp;</td>
              </tr>
			  <tr>
                <td height="20" colspan="4" align="left" valign="bottom" style="padding-top:2px; padding-bottom:2px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="26%">Date of Birth :</td>
                      <td width="74%" style="border-bottom:1px dotted #000000;">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="20" colspan="4" align="left" valign="bottom" style="padding-bottom:4px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="21%">Sex :</td>
                      <td width="27%">1. &nbsp;Male</td>
                      <td width="52%">2. &nbsp;Female</td>                     
                    </tr>
                </table>                </td>
              </tr>
              <tr>
                <td height="20" colspan="4" align="left" valign="bottom">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="33%">Place of Birth :</td>
                      <td width="48%">1. &nbsp;Hospital / Institution</td>
                      <td width="19%">2. &nbsp;House</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="30" colspan="4" align="right" valign="bottom">Name and Signature of the Registrar</td>
              </tr>
            </table></td>
          </tr>  
	<!-- EOF second page --> 
			</table>
		</td> 
</table>     
