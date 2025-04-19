<style>
.formError .formErrorContent{
width:60px;
}
.disabled{
	background:-moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
}
</style>
<?php
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php }

 ?>
 <?php
					$slip_detail  = unserialize($StoreRequisition['StoreRequisition']['slip_detail']);

				   ?>
    <input type="hidden" value="<?php echo count($slip_detail['item_name']);?>" id="no_of_fields"/>
                  	<div class="inner_title">
                      <h3>Store Requisition Slip - Approve</h3>
                  	</div>
                   <p class="ht5"></p>

                   <!-- billing activity form start here -->
				  	 <?php echo $this->Form->create(null,array('url' => array('controller' => 'InventoryCategories', 'action' => 'store_requisition',$StoreRequisition['StoreRequisition']['id'])));?>

                   <div class="clr ht5"></div>
                   <div class="clr ht5"></div>
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      <tr>
                      		<th colspan="5">STORE REQUISITION &amp; ISSUE SLIP</th>
                      </tr>
                       <tr>
                        <td>Requisition For:</td>
					   	<td><?php
                            echo $requisition_for;
							?>
                            (<?php
                            echo ucfirst($StoreRequisition['StoreRequisition']['requisition_for']);
							?>)
                            </td>

				 </td>
                       </tr>
				    </table>
					<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" id="tabularForm">
                      <tr>
                      		<td width="200">Item Name<font color="red">*</font></td>
                            <td width="130" align="center">Requisition Quantity<font color="red">*</font></td>
                            <td width="110" align="center">Issue Quantity</td>
                        	<td>Remark</td>
                            <td width="50" align="center">Remove</td>
                     </tr>
					 <?php
						$i=0;
						foreach($slip_detail['item_name'] as $key=>$value){
						$i++;
					 ?>
                      <tr id="row<?php echo $i;?>">
                        <td><input name="StoreRequisition[slip_detail][item_name][]" type="text" class="textBoxExpnd validate[required] disabled" id="item_name<?php echo $i;?>" style="width:180px;" value="<?php echo $value;?>" readonly="true"/></td>
                        <td><input name="StoreRequisition[slip_detail][qty][]" type="text" class="textBoxExpnd validate[required,custom[number]] disabled" id="qty<?php echo $i;?>" style="width:110px;" value="<?php echo $slip_detail['qty'][$key];?>" readonly="true"/></td>
                        <td><input name="StoreRequisition[slip_detail][issued_qty][]" type="text" class="textBoxExpnd validate[custom[number]] disabled" id="issued_qty<?php echo $i;?>" style="width:180px;" value="<?php  if(isset($slip_detail['issued_qty'][$key])){echo $slip_detail['issued_qty'][$key];}?>" readonly="true"/></td>
                        <td><input name="StoreRequisition[slip_detail][remark][]" type="text" class="textBoxExpnd" id="remark<?php echo $i;?>" style="width:95%; min-width:200px;" value="<?php echo $slip_detail['remark'][$key];?>"/></td>

						<td align="center"><a href="#this" onclick="deleteRow(<?php echo $i;?>)"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>

                      </tr>
					   <?php
						}
					 ?>
                   </table>

                    <!-- billing activity form end here -->
                    <div class="btns">


                    </div>
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
                                    <td><input name="StoreRequisition[requisition_by]" type="text" class="textBoxExpnd disabled" id="requisition_by" style="width:180px;" value="<?php echo $StoreRequisition['StoreRequisition']['requisition_by'];?>" disabled="disabled"/></td>
                                  </tr>
                                  <tr>
                                    <td height="25">Date</td>
                                    <td><table width="165" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="140"><input name="StoreRequisition[requisition_date]" type="text" class="textBoxExpnd datetime disabled" id="requisition_date" style="width:120px;" value="<?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['requisition_date'],Configure::read('date_format'),true);?>" disabled="disabled"/></td>

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
                                <td><input name="StoreRequisition[issue_by]" type="text" class="textBoxExpnd disabled" id="issue_by" style="width:180px;" value="<?php echo $StoreRequisition['StoreRequisition']['issue_by'];?>" disabled="disabled"/></td>
                              </tr>
                              <tr>
                                <td height="25">Date</td>
                                <td><table width="165" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="140"><input name="StoreRequisition[issue_date]" type="text" class="textBoxExpnd datetime disabled" id="issue_date" style="width:120px;" value="<?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['issue_date'],Configure::read('date_format'),true);?>" disabled="disabled"/></td>
                                     </tr>
                                </table></td>
                              </tr>

                            </table></td>
                          <td width="30">&nbsp;</td>
                            <td width="250" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td height="22" colspan="2" valign="top">Entered By:</td>
                              </tr>
                              <tr>
                                <td width="60" height="25">Name</td>
                                <td><input name="StoreRequisition[entered_by]" type="text" class="textBoxExpnd disabled" id="entered_by" style="width:180px;" value="<?php echo $StoreRequisition['StoreRequisition']['entered_by'];?>" disabled="disabled"/></td>
                              </tr>
                              <tr>
                                <td height="25">Date</td>
                                <td><table width="165" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="140"><input name="StoreRequisition[entered_date]" type="text" class="textBoxExpnd datetime disabled" id="entered_date" style="width:120px;" value="<?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['entered_date'],Configure::read('date_format'),true);?>" disabled="disabled"/></td>
                                     </tr>
                                </table></td>
                              </tr>

                            </table></td>
                    	</tr>
                    </table>
                    <div class="clr">&nbsp;</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tdLabel2">
                      <tr>
                        <td width="300" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                          <tr>
                            <td width="170" height="25">Reviewed</td>
                            <td><input name="StoreRequisition[reviewed_by]" type="text" class="textBoxExpnd disabled" id="reviewed_by" style="width:200px;" value="<?php echo $StoreRequisition['StoreRequisition']['reviewed_by'];?>" disabled="disabled"/></td>
                          </tr>
                          <tr>
                            <td height="25" style="min-width:170px;">Management Representative</td>
                            <td><input name="StoreRequisition[management_representative]" type="text" class="textBoxExpnd disabled" id="management_representative" style="width:200px;" value="<?php echo $StoreRequisition['StoreRequisition']['management_representative'];?>"  disabled="disabled"/></td>
                          </tr>

                        </table></td>
                        <td width="30">&nbsp;</td>
                        <td width="300" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="100" height="25">Approved By<font color="red">*</font></td>
                            <td><input name="StoreRequisition[approved_by]" type="text" class="textBoxExpnd validate[required]" id="approved_by" style="width:200px;" value="<?php echo $StoreRequisition['StoreRequisition']['approved_by'];?>"/>
							<input type="hidden" name="status" value="Approved">
							</td>
                          </tr>
                          <tr>
                            <td height="25">Proprietor</td>
                            <td><input name="StoreRequisition[proprietor]" type="text" class="textBoxExpnd" id="proprietor" style="width:200px;" value="<?php echo $StoreRequisition['StoreRequisition']['proprietor'];?>"/></td>
                          </tr>

                        </table></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>

                   <div class="btns">
                           <input name="submit" type="submit" value="Submit" class="blueBtn"/>
						    <?php  echo $this->Html->link(__('Back'), array('action' => 'store_requisition_list'), array('escape' => false,'class'=>"blueBtn"));?>
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
<?php echo $this->Form->end();?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#StoreRequisitionStoreRequisitionForm").validationEngine();
	});
$( ".datetime" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate("HH:mm");?>',
			minDate: new Date(),
		});

(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"Required.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                },
				 "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Invalid format"
                }
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

function addFields(){
		   var number_of_field = parseInt($("#no_of_fields").val())+1;
           var field = '';
		   field += '<tr id="row'+number_of_field+'"> ';
		   field += ' <td><input name="StoreRequisition[slip_detail][item_name][]" type="text" class="textBoxExpnd validate[required] disabled" id="item_name'+number_of_field+'" style="width:180px;" disabled="disabled"/> </td>';
		    field += ' <td><input name="StoreRequisition[slip_detail][qty][]" type="text" class="textBoxExpnd validate[required,custom[number]] disabled" id="qty'+number_of_field+'" style="width:180px;" disabled="disabled"/> </td>';
		   field += '<td><input name="StoreRequisition[slip_detail][issued_qty][]" type="text" class="textBoxExpnd validate[custom[number]] disabled" id="issued_qty'+number_of_field+'" style="width:90px;" disabled="disabled"/></td>';
		   field += ' <td><input name="StoreRequisition[slip_detail][remark][]" type="text" class="textBoxExpnd " id="remark'+number_of_field+'" style="width:95%; min-width:200px;"/> </td>';
		   field += ' <td align="center"><a href="#this" onclick="deleteRow('+number_of_field+')"><img border="0" alt="" src="<?php echo $this->Html->url('/img/cross-icon.png'); ?>"></a></td>';
		   field +='  </tr>    ';

      	$("#no_of_fields").val(number_of_field);
		$("#tabularForm").append(field);
		if (parseInt($("#no_of_fields").val()) == 1){
						$("#remove-btn").css("display","none");
					}else{
		$("#remove-btn").css("display","inline");
		}
}
function deleteRow(rowId){
var number_of_field = parseInt($("#no_of_fields").val());
if(number_of_field > 1){
		$("#row"+rowId).remove();
		$('.qty'+rowId+"formError").remove();
		$('.issued_qty'+rowId+"formError").remove();
		$('.remark'+rowId+"formError").remove();
		$('.item_name'+rowId+"formError").remove();
		$("#no_of_fields").val(number_of_field-1);
	}

}
function removeRow(){
 	var number_of_field = parseInt($("#no_of_fields").val());
	$('.qty'+number_of_field+"formError").remove();
	$('.issued_qty'+number_of_field+"formError").remove();
	$('.remark'+number_of_field+"formError").remove();
	$('.item_name'+number_of_field+"formError").remove();
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();

		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}
}
</script>
