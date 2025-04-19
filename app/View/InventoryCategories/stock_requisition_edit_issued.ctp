<div class="inner_title">
                      <h3>Stock Requisition Slip - View</h3>
                      <span><?php  echo $this->Html->link(__('Back'), array('action' => 'stock_requisition_list'), array('escape' => false,'class'=>"blueBtn"));?></span>
 </div>
 <?php
					$slip_detail  = $storeDetails;
				   ?>

                   <p class="ht5"></p>

           <!-- billing activity form start here -->

                   <div class="clr ht5"></div>
                   <div class="clr ht5"></div>
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      <tr>
                      		<th colspan="5">STOCK REQUISITION &amp; ISSUE SLIP</th>
                      </tr>
                       <tr>
                       <td width="10%" class="tdLabel" colspan=""><?php echo __('Requisition From:'); ?>
		</td>


		<td width="150" colspan=""><?php  echo ucfirst($requsition_by_location['Location']['name']);?> 
		</td>
		<td width="10%" class="tdLabel" colspan=""><?php echo __('Requisition To:'); ?>
		</td>
		<td width="180" class="tdLabel"><?php  echo ucfirst($requsition_for_location['Location']['name']); ?>
		</td>                    
                       </tr>
				    </table>
					<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" id="tabularForm">
                      <tr>
                      		<td width="200">Item Name</td>
                            <td width="130" align="center">Requisition Quantity</td>
                            <td width="110" align="center">Issue Quantity</td>
                        	<td>Remark</td>                       	

                     </tr>
					 <?php
						$i=0;
						foreach($slip_detail as $key=>$value){
						$i++;
					 ?>
                      <tr id="row<?php echo $i;?>">
                        <td> <?php echo $value['PharmacyItem']['name'];?> </td>
                        <td> <?php echo $value['StoreRequisitionParticular']['requested_qty'];?> </td>
                        <td>  <?php if(isset($value['StoreRequisitionParticular']['issued_qty'])){echo $value['StoreRequisitionParticular']['issued_qty'];}?> </td>
                        <td> <?php echo $value['StoreRequisitionParticular']['remark'];?> </td>
                      <?php
					   if($i>1){
					   ?>

						<?php
						}else{
						?>

						<?php
						}
						?>
                      </tr>
					   <?php
						}
					 ?>
                   </table>


                    <div class="clr"></div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="border:1px solid #3E474A; padding:10px;">
                    	<tr>
                       	  <td width="250" align="left" valign="top">
                           	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td height="22" colspan="2" valign="top">Requisition By:</td>
                                  </tr>
                                  <tr>
                                    <td width="60" height="25">Name</td>
                                    <td> <?php echo $req_by_name;//ucfirst($requsition_by_location['Location']['name']);?> </td>
                                  </tr>
                                  <tr>
                                    <td height="25">Date</td>
                                    <td><table width="165" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="140"> <?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['requisition_date'],Configure::read('date_format'),true);?> </td>

                                      </tr>
                                    </table></td>
                                  </tr>
                            </table>

                          </td>
                          <td width="30">&nbsp;</td>
                            <td width="250" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td height="22" colspan="2" valign="top">Issue By:</td>
                              </tr>
                              <tr>
                                <td width="60" height="25">Name</td>
                                <td> <?php echo $issue_by_name;//ucfirst($requsition_for_location['Location']['name']);?> </td>
                              </tr>
                              <tr>
                                <td height="25">Date</td>
                                <td><table width="165" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="140"> <?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['issue_date'],Configure::read('date_format'),true);?> </td>
                                     </tr>
                                </table></td>
                              </tr>

                            </table></td>
                          <td width="30">&nbsp;</td>
                          <!--   <td width="250" align="left" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td height="22" colspan="2" valign="top">Entered By:</td>
                              </tr>
                              <tr>
                                <td width="60" height="25">Name</td>
                                <td> <?php echo $entered_by_name;?> </td>
                              </tr>
                              <tr>
                                <td height="25">Date</td>
                                <td><table width="165" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="140"> <?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['entered_date'],Configure::read('date_format'),true);?> </td>
                                     </tr>
                                </table></td> -->
                              </tr>

                            </table></td>
                    	</tr>
                    </table>
                    <div class="clr">&nbsp;</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tdLabel2">
                    <!--   <tr>
                        <td width="300" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                          <tr>
                            <td width="170" height="25">Reviewed</td>
                            <td> <?php echo $StoreRequisition['StoreRequisition']['reviewed_by'];?> </td>
                          </tr>
                          <tr>
                            <td height="25" style="min-width:170px;">Management Representative</td>
                            <td> <?php echo $StoreRequisition['StoreRequisition']['management_representative'];?> </td>
                          </tr>

                        </table></td>
                        <td width="30">&nbsp;</td>
                        <td width="300" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="100" height="25">Approved By</td>
                            <td> <?php echo $StoreRequisition['StoreRequisition']['approved_by'];?> </td>
                          </tr>
                          <tr>
                            <td height="25">Proprietor</td>
                            <td> <?php echo $StoreRequisition['StoreRequisition']['proprietor'];?>  </td>
                          </tr>

                        </table></td>
                      </tr>
                       -->
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
					   <div class="btns">

						    
                     </div>

                    <!-- Right Part Template ends here -->
                    </td>
                </table>
            <!-- Left Part Template Ends here -->

          </div>
        </td>
        <td width="5%">&nbsp;</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
        <td class="footStrp">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>