<?php //pr($patient);exit;?>
<!-- two column table start here -->
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      <tr>
                        <td width="350" align="left" valign="top" style="padding-top:7px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                              <tr>
                                <td width="120" height="25" valign="top" class="tdLabel1"><?php echo __('Name');?> </td>
                                <td align="left" valign="top"><?php echo $patient['Patient']['lookup_name'];?></td>
                              </tr>
                              <tr>
                                <td valign="top" class="tdLabel1"><?php echo __('Address');?> </td>
                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $address;?></td>
                              </tr>
                              <tr>
                                <td valign="middle" class="tdLabel1" id="boxSpace2"><?php echo __('Patient Category');?></td>
                                <td align="left" valign="top">
                                	<!-- <select class="textBoxExpnd">
                                        <option>Private</option>
                                        <option>WCL</option>
                                        <option>MPKAY</option>
                                        <option>RBI</option>
                                        <option>BSNL</option>
                                        <option>BHEL</option>
                                        <option>MOIL</option>
                                    </select>
                                     -->
                                     <?php echo $corporateEmp;?>
                                                                     </td>
                              </tr>
                        	</table>                        </td>
                        	<td width="" align="left" valign="top" style="padding-top:7px;">
                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                    	<td width="">
                                        	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                              <tr>
                                                <td width="140" height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __('Patient ID');?></td>
                                                <td align="left" valign="top"><?php echo $patient['Patient']['patient_id'];?></td>
                                              </tr>
                                              <tr>
                                                <td width="140" height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __('MRN');?></td>
                                                <td align="left" valign="top"><?php echo $patient['Patient']['admission_id'];?></td>
                                              </tr>
                                              <tr>
                                                <td height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __('Sex');?></td>
                                                <td align="left" valign="top"><?php echo ucfirst($patient['Patient']['sex']);?></td>
                                              </tr>
                                              <tr>
                                                <td height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __('Age');?>  </td>
                                                <td align="left" valign="top"><?php echo $patient['Patient']['age'];?></td>
                                              </tr>
                                            </table>                                        </td>
                                        <td width="150" align="right">
                                        <img src="images/qr-code.gif" width="110" height="110" />
                                        <?php if(file_exists(WWW_ROOT."uploads/qrcodes/".$patient['Patient']['admission_id'].".png")){ ?>

			    						<?php echo $this->Html->image("/uploads/qrcodes/".$patient['Patient']['admission_id'].".png",array('width'=>'110','height'=>'110')); ?>
			    					
			 					<?php  } ?>
                                        </td>
                                  </tr>
                                </table>                            </td>
                      </tr>
                    </table>
					<!-- two column table end here -->