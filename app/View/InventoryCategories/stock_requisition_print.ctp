
<div style="width:100%;text-align:right;cursor:pointer;">
<input type="button" value="Print" class="blueBtn" onclick="$('.blueBtn').hide();window.print();"/>&nbsp;&nbsp;<input name="Close" type="button" value="Close" class="blueBtn" onclick="window.close();"/>

</div>
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
.style1 {border-right: 1px solid #000000; font-weight: bold; }
</style>
 <?php $slip_detail  = $storeDetails;

				   ?>

                   <p class="ht5"></p>

                   <!-- billing activity form start here -->
                   <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">


    <tr>
            <td width="100%" align="center" valign="top" class="tdBorderTp" style="padding-top:7px; padding-bottom:7px; font-size:20px; font-weight:bold; border-bottom:1px solid #000000;">STOCK REQUISITION &amp; ISSUE SLIP</td>
          </tr>
          <tr>
          <td width="100%" align="left" valign="top">
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                  <td>Requisition From: &nbsp;&nbsp;<strong><?php
                         
                            echo ucfirst($requsition_by_location['Location']['name']);
							?>
                            </strong>
                            </td>
              <td>Requisition To: &nbsp;&nbsp;<strong><?php                         
                            echo ucfirst($requsition_for_location['Location']['name']);
							?>
                            </strong>
                            </td>
              
                            </tr>
                            </table>
                            </td>
          </tr>

     <tr>
            <td width="100%" align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td width="30" align="center" class="tdBorderRtBt">Sr. No.</td>
                    <td width="195" align="center" class="tdBorderRtBt" style="padding-left:10px;">Item<br />
                    Name</td>
                    <td align="center" class="tdBorderRtBt">Requisition Quantity</td>
                    <td width="70" align="center" class="tdBorderRtBt">Issue Quantity</td> 
                   <!--  <td width="70" align="center" class="tdBorderRtBt">Used Quantity</td> 
                    <td width="70" align="center" class="tdBorderRtBt">Returned Quantity</td>  -->                
                   <!--  <td width="150" align="center" class="tdBorderRtBt">Denied Status</td> -->
                    <td width="70" align="center" class="tdBorderRtBt">Requisition Remark</td>
                    <td width="70" align="center" class="tdBorderRtBt">Issue Remark</td>
                    <!-- <td width="70" align="center" class="tdBorderRtBt">Return Remark</td> -->
                  </tr>
                  
					 <?php
						 $i=0;
						foreach($slip_detail as $key=>$value){ 
						 $i++;
					 ?>
                      <tr >
					  <td align="center" class="tdBorderRtBt"><?php echo $i;?></td>
                        <td class="tdBorderRtBt" style="padding-left:10px;">&nbsp;<?php echo $value['PharmacyItem']['name'];?></td>
                        <td class="tdBorderRtBt">&nbsp;<?php echo $value['StoreRequisitionParticular']['requested_qty'];?></td>
                        <td class="tdBorderRtBt">&nbsp;<?php 
                        if(!empty($value['StoreRequisitionParticular']['issued_qty'])){
                        	if(isset($value['StoreRequisitionParticular']['issued_qty'])){echo $value['StoreRequisitionParticular']['issued_qty'];}
                        }else{
							echo "0";
						}?></td>
                        <!--  <td class="tdBorderRtBt">&nbsp;<?php if(isset($value['StoreRequisitionParticular']['used_qty'])){echo $value['StoreRequisitionParticular']['used_qty'];}?></td>
                        <td class="tdBorderRtBt">&nbsp;<?php if(isset($value['StoreRequisitionParticular']['returned_qty'])){echo $value['StoreRequisitionParticular']['returned_qty'];}?></td>-->                        
                       <!--  <td class="tdBorderRtBt">&nbsp;<?php if($value['StoreRequisitionParticular']['is_denied']==0)
                        echo 'NO';
                        else echo 'YES';?></td> -->
                        <td class="tdBorderRtBt">&nbsp;<?php echo $value['StoreRequisitionParticular']['remark'];?></td>
                        <td class="tdBorderRtBt">&nbsp;<?php echo $value['StoreRequisitionParticular']['issue_remark'];?></td>
                     <!--    <td class="tdBorderRtBt">&nbsp;<?php echo $value['StoreRequisitionParticular']['return_remark'];?></td> -->
                      </tr>
					   <?php
						}
					 ?>
                   </table>
                               </td>
          </tr>
<tr>
            <td width="100%" align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td width="49%" class="tdBorderRtBt">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Requisition By:</td>

                            <td height="25">&nbsp;<?php echo $req_by_name;?></td>
                          </tr>
						  <tr>
                            <td height="25">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>Date &nbsp;<?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['requisition_date'],Configure::read('date_format'),true);?></td>
                          </tr> 
                        </table>                    </td>
			   <td class="tdBorderRtBt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Issue By: </td>

                        <td height="25">&nbsp;<?php echo $issue_by_name;?></td>
                      </tr>
					  <tr>
                            <td height="25">&nbsp;</td>
                          </tr>
                     <tr>
                        <td>Date &nbsp;<?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['issue_date'],Configure::read('date_format'),true);?></td>
                      </tr>
                    </table></td>
                     <!--  <td width="32%" class="tdBorderBt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>Entered By </td>

                        <td height="25">&nbsp;<?php echo $entered_by_name;?></td>
                      </tr>
					  <tr>
                            <td height="25">&nbsp;</td>
                          </tr>
                      <tr>
                        <td>(Sign)<br />
                          (Date)&nbsp;<?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['entered_date'],Configure::read('date_format'),true);?></td>
                      </tr> 
                    </table></td>-->
                  </tr>
                </table>            </td>

</tr>

 
   <!--  <tr>
            <td width="100%" align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="8">
                  <tr>
				  <td width="50" align="center" class="tdBorderRtBt">&nbsp;</td>
				    <td width="200" align="center" class="tdBorderRtBt"> Reviewed </td>
                    <td align="center" class="tdBorderRtBt"  >Management Representative</td>
					<td align="center" class="tdBorderRtBt"> Proprietor</td>
                  </tr>
                  <tr>
				  <td width="50" align="center" class="tdBorderRtBt">&nbsp;</td>
                    <td align="center" class="tdBorderRtBt">&nbsp;<?php echo $StoreRequisition['StoreRequisition']['reviewed_by'];?></td>
                    <td align="center" class="tdBorderRtBt" >&nbsp;  <?php echo $StoreRequisition['StoreRequisition']['management_representative'];?></td>
                    <td align="center" class="tdBorderRtBt">&nbsp; <?php echo $StoreRequisition['StoreRequisition']['proprietor'];?></td>
                  </tr>
                    <tr>
					<td width="50" align="center" class="tdBorderRtBt" style="border-bottom:none;">Signature</td>
                    <td align="center" class="tdBorderRtBt" style="border-bottom:none;">&nbsp; </td>
                    <td align="center" class="tdBorderRtBt" style="border-bottom:none;">&nbsp; </td>
					  <td align="center" class="tdBorderRtBt" style="border-bottom:none;">&nbsp;</td>
                  </tr>

                </table>             </td>
          </tr> -->
          </table>    </td>
  </tr>
</table>