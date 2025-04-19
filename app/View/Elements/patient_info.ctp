<table width="100%" cellpadding="0" cellspacing="0" border="0" class="tabularForm" style="border:1px solid #3e474a;">yutyu
                   		<tr>
                              	<th colspan="4">PATIENT'S INFORMATION</th>
                              </tr>
                   		<tr>
                        	<td width="330" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="5" >
                              <tr>
                                <td width="38%" height="25" valign="top" class="tdLabel2">Name </td>
                                <td align="left" valign="top">
                                	<?php
                                		echo $complete_name  = ucfirst($patient['Initial']['name'])." ".ucfirst($patient['Patient']['lookup_name']) ; 
                                	?>
								</td>
                              </tr>
                              <tr>
                                <td valign="top" class="tdLabel2">Address </td>
                                <td align="left" valign="top" style="padding-bottom:10px;">
                                	<?php
                                		echo $address ; 
                                	?>
                                </td>
                              </tr>
                              <tr>
                                <td valign="top" class="tdLabel1" id="boxSpace2">Treating Physician</td>
                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($treating_consultant[0]['fullname']) ;?></td>
                              </tr>
                            </table>                            </td>
                            <td width="30" valign="top">&nbsp;</td>
                            <td width="350" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="5" >
                              <tr>
                                <td width="110" height="25" valign="top" class="tdLabel1" id="boxSpace3"><?php echo __("MRN");?> </td>
                                <td align="left" valign="top"><?php echo $patient['Patient']['admission_id'] ;?></td>
                              </tr>
                              <tr>
                                <td valign="top" class="tdLabel1" id="boxSpace3">Patient ID</td>
                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $patient['Patient']['patient_id'] ;?>
                                </td>
                              </tr>
                              <tr>
                                <td valign="top" class="tdLabel1" id="boxSpace4">Sex</td>
                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($sex);?></td>
                              </tr>
                              <tr>
                                <td valign="top" class="tdLabel1" id="boxSpace5">Age</td>
                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($age);?></td>
                              </tr>
                            </table>                            </td>
                            <td width="" valign="top" align="right"><?php if(file_exists(WWW_ROOT."uploads/qrcodes/".$patient['Patient']['admission_id'].".png")){ ?>
			    				 
			    						<?php echo $this->Html->image("/uploads/qrcodes/".$patient['Patient']['admission_id'].".png", array('height'=>100,'weight'=>100,'alt' => $complete_name,'title'=>$complete_name)); ?>
			    					 
			 					<?php  } ?></td>
                        </tr>
                   </table>