<table width="100%" cellpadding="0" cellspacing="0" border="0" class="tbl" style="border:1px solid #3e474a;">
                   		<!-- <tr>
                              	<th colspan="2">Patient Information</th>
                              </tr> -->
                   		<tr>
	                        <td width="50%" valign="top">
	                            <table width="100%" border="0" cellspacing="0" cellpadding="5" >
	                              <tr>
	                                <td width="50%" height="25" valign="top">Name :</td>
	                                <td align="left" valign="top"><?php echo $complete_name  = $patient[0]['lookup_name'] ; ?></td>
	                              </tr>
	                             <!--  <tr>
	                                <td valign="top" >Address :</td>
	                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $address ; ?></td>
	                              </tr> -->
	                              <tr>
	                                <td valign="top" ><?php echo __('Primary Care Provider :')?></td>
	                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($treating_consultant[0]['fullname']) ;?></td>
	                              </tr>
	                              <tr>
	                                <td valign="top"  >Sex / Age :</td>
	                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($sex);?> / <?php echo ucfirst($age)?></td>
	                              </tr>
	                               <tr>
	                                <td valign="top"  >Bill No. :</td>
	                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $billNumber['Billing']['bill_number']; ?></td>
	                              </tr>
	                            </table> 
	                        </td>
                           
                            <td width="50%" valign="top">
	                            <table width="100%" border="0" cellspacing="0" cellpadding="5" >
	                              <tr>
	                                <td height="25" valign="top"  id="boxSpace3" align="right">Registration ID :</td>
	                                <td align="left" valign="top"><?php echo $patient['Patient']['admission_id'] ;?></td>
	                              </tr>
	                              <tr>
	                                <td valign="top"  id="boxSpace3" align="right">Patient ID :</td>
	                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $patient['Patient']['patient_id'] ;?></td>
	                              </tr>
	                             <tr>
					           		 <td valign="top"  id="boxSpace3" align="right">Tariff :</td>
					          		 <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $patient['TariffStandard']['name'];?></td>
					        	</tr>
	                            </table>
	                         </td>
                          
                        </tr>
                   </table>