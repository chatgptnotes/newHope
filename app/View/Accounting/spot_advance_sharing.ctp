<section style="margin:10px;">
    <?php echo $this->Form->create('Accounting', array('id'=>'spotAdvanceSharing','inputDefaults'=>array('label'=>false,'div'=>false,'error'=>false,'legend'=>false,'O')));?>
    <table width="100%" cellpadding="1" cellspacing="1" border="0">
        <tr>
            <td width="100%" valign="top">
                <table width="100%" cellpadding="1" cellspacing="1" border="0">
                    <tr>
                        <td width="20%">
                            <?php
                            	echo $this->Form->hidden('', array('name'=>"data[VoucherPayment][remaining_sharing_amount]",'type'=>'text','id'=>'currentSharingAmount'));
	                            echo $this->Form->hidden('', array('name'=>"data[VoucherPayment][id]",'type'=>'text','value'=>$this->data['VoucherPayment']['id']));
	                            echo $this->Form->hidden('', array('name'=>"data[VoucherPayment][user_id]",'type'=>'text','value'=>$this->data['VoucherPayment']['user_id']));
	                            echo $this->Form->hidden('', array('name'=>"data[VoucherPayment][account_id]",'type'=>'text','value'=>$this->data['VoucherPayment']['account_id']));
	                            echo __('Payment No. :');
	                            echo $dataDetail['VoucherPayment']['id'];
                            ?>
                        </td>
                        <td width="20%">
                            <?php echo __('Day :');
                            echo date('l', strtotime($date = date('Y-m-d'))); ?>
                        </td>
                        <?php if(empty($this->data['VoucherPayment']['remaining_sharing_amount'])){?>
                        <td width="20%">
                        <span id = "remainingAmount"></span>
                            <?php echo $this->Form->hidden('',array('name'=>"data[VoucherPayment][totalSharingAmount]",'id'=>'remainingSharingAmount','value'=>$this->data['VoucherPayment']['paid_amount']));?>
                        </td>
                       <?php }else{ ?>
                        <td width="20%">
                         <span id = "remainingAmount"></span>
                            <?php echo $this->Form->hidden('',array('name'=>"data[VoucherPayment][totalSharingAmount]",'id'=>'remainingSharingAmount','value'=>$this->data['VoucherPayment']['remaining_sharing_amount']));?>
                        </td>
                       <?php }?>
                        <td width="5%">
                            <?php echo __('Date :'); ?>
                        </td>
                        <td width="15%">
                            <?php
                            $date = $this->data['VoucherPayment']['date'];
                            echo $this->Form->input('', array('name'=>"data[VoucherPayment][date]",'label'=>false,'type'=>'text','value'=>$date,'id'=>'date',
                                'readonly'=>'readonly','class'=>'textBoxExpnd'));
                            ?>
                         </td>
                    </tr>
                </table>

                <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="account_form">
                    <tr>
                        <th width="60%" align="center" valign="top" style="text-align: left; padding: 5px 0 0 50px;"><strong><?php echo __('Particulars') ?></strong></th>
                        <th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Debit'); ?></strong></th>
                        <th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Credit'); ?></strong></th>
                    </tr>
                  
                    <!-- Credit fields -->
                    <tr id="cRow1">
                        <td colspan="3">
                            <table width="100%" cellspacing="1" cellpadding="0" border="0" class="tabularForm">
                                <tr>
                                    <td style="width:60%;"><?php echo __('Cr :') ?><font color="red">*</font>
                                        <?php echo $this->data['AccountAlias']['name']; ?>
                                    </td>
                                    <td style="text-align: right; width:20%;">
                                        <?php echo " "; ?>
                                    </td>
                                    <td style="text-align: center; width:20%;">
										<?php
										$paidAmount = $this->data['VoucherPayment']['paid_amount'];
										echo "<span id='credit_amount'>" . $paidAmount . "<span>";
										?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Credit fields -->
                      <!-- Debit fields -->
                    <tr>
                        <td colspan="3">
                            <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                                <tr>
                                    <td class="searchdiv" style="width:60%;"><?php echo __('Dr :') ?><font color="red">*</font>
                                        <?php echo $this->data['Account']['name']; ?>
                                    </td>
                                    <td style="text-align: center; width:20%;">
                                        <?php echo $totalSusAmount = $this->data['VoucherPayment']['paid_amount']; ?>
                                    </td>
                                    <td style="text-align: right; width:20%;">
                                        <?php echo " "; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Debit fields -->
                </table>

                <table width="100%" class="tabularForm" cellpadding="0" cellspacing="1" border="0">
                    <thead>
                        <tr>
                            <th><?php echo __("Patient Name"); ?></th>
                            <th><?php echo __("S Payable Amount"); ?></th>
                            <th><?php echo __("B Payable Amount"); ?></th>
                            <th><?php echo __("Balance Amount"); ?></th>
                            <th><?php echo __("Type"); ?></th>
                            <th><?php echo __("Amount Adjusted"); ?></th>
                            <th><?php echo __("#"); ?></th>
                        </tr>   
                    </thead>
                    <tbody id="patientTable">
                        <tr id="row_1">
                            <td>
                            	<?php echo $this->Form->input('', array('class'=>'textBoxExpnd patient_name validate[required,custom[mandatory-enter]]',
                            			'value'=>'','id'=>'patientName_1','type'=>'text','placeholder'=>'Patient Name','name'=>"data[Corporate][1][patient_name]"));
                            		echo $this->Form->hidden('', array('name'=>"data[Corporate][1][patient_id]",'type'=>'text','id'=>'patientId_1')); ?>
                            </td>
                            <td>
                            	<span id="sPayable_1"></span>
                            </td>
                            <td>
                            	<span id="bPayable_1"></span>
                            </td>
                            <td>
                            	<span id="balanceAmount_1"></span>
                            </td>
                            <td>
                            	<?php echo $this->Form->input('', array('id'=>'spotType_1','class'=>'spotType','type'=>'radio','label'=>false,'legend'=>false,
                            			'name'=>"data[Corporate][1][spot_type]",'value'=>'B','options'=>array('S'=>'S Amount','B'=>'B Amount')));?>
                            </td>
                            <td>
                            	<?php echo $this->Form->input('', array('class'=>'validate[required,custom[mandatory-enter]] cost sharingAmount','id'=>'sharingAmount_1','type'=>'text','placeholder'=>'Amount Adjusted',
                            			'value'=>'','name'=>"data[Corporate][1][sharing_amount]",'autocomplete' => 'off')); ?>
                            </td>
                            <td>
	                            <?php
	                                echo $this->Html->link($this->Html->image("icons/cross.png", array("alt" => "Remove Row", "title" => "Remove Item")),
										'javascript:void(0);', array('escape' => false, 'onClick' => 'removeRow(1);'));
								?>
							</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan="2"><?php echo $this->Html->link(__('Add More'), 'javascript:void(0)', array('class' => "blueBtn Add_more")); ?></td>
                            <td colspan="6">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                 <table width="100%" class="tabularForm" cellpadding="0" cellspacing="1" border="0">
                    <tr>
                        <td colspan="3" align="center" style="padding: 20px 0 20px 0">
							<?php echo $this->Form->submit('Save', array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;',
									'id'=>'save','div'=>false,'name'=>'print'));?>
                        </td>
                    </tr>
                </table> 
            </td>
        </tr>
    </table>
<?php echo $this->Form->end(); ?>

</section>
<script>
    $(document).ready(function(){
        var remainingAmount = "<?php echo $this->data['VoucherPayment']['remaining_sharing_amount'];?>";
        if(remainingAmount == ''){
        	 var remainingAmount = "<?php echo $this->data['VoucherPayment']['paid_amount'];?>";
        }
        $("#remainingAmount").text('Remaining Amount :'+remainingAmount); 
       
        $("#save").click(function(){
            var validateForm = jQuery("#spotAdvanceSharing").validationEngine('validate');
            if(validateForm == true){
               window.parent.childSubmitted = true;
                parent.$.fancybox.close();
                $("#save").hide();
            }else{
                return false;
            }
        });
    });	
    $("#date").datepicker({
        showOn : "both",
        buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly : true,
        changeMonth : true,
        changeYear : true,
        yearRange: '-100:' + new Date().getFullYear(),
        maxDate : new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS'); ?>',
        onSelect : function() {
            $(this).focus();
        }
    });

    var counter = 1;
    $(".Add_more").click(function(){
        counter++;
        var field = '';
        field += '<tr id="row_'+counter+'">';
        field +=    '<td><input type="text" name="data[Corporate]['+counter+'][patient_name]" class="textBoxExpnd patient_name validate[required,custom[mandatory-enter]]" id="patientName_'+counter+'" placeholder="Patient Name"/> <input type="hidden" id="patientId_'+counter+'" name="data[Corporate]['+counter+'][patient_id]" /></td>';
        field +=    '<td><span id="sPayable_'+counter+'"></span></td>';
        field +=    '<td><span id="bPayable_'+counter+'"></span></td>';
        field +=    '<td><span id="balanceAmount_'+counter+'"></span></td>';
        field +=    '<td><input type="radio" name="data[Corporate]['+counter+'][spot_type]" value="S" id="spotType_'+counter+'" class="spotType">S Amount<input type="radio" name="data[Corporate]['+counter+'][spot_type]" value="B" checked=checked>B Amount</td>';
        field +=    '<td><input type="text" name="data[Corporate]['+counter+'][sharing_amount]" class="validate[required,custom[mandatory-enter]] cost sharingAmount" placeholder="Amount Adjusted" id="sharingAmount_'+counter+'"/></td>';
        field +=    '<td><a href="javascript:void(0);" onClick="removeRow('+counter+')"><?php echo $this->Html->image("icons/cross.png", array("alt" => "Remove Row", "title" => "Remove Item")); ?></a></td>';
        field += '</tr>';
    
        $("#patientTable").append(field);
    });

    function removeRow(id){
        var count = 0;
        $('.patient_name').each(function(){
            count++;
        });
        if(count == 1){
            alert('Single row could not delete.');
            return false;
        }
        $("#row_"+id).remove();
    }

    var consultantId = "<?php echo $consultantId; ?>"; 

    $(document).on('focus','.patient_name',function(){
        var id = $(this).attr('id').split("_")[1];
        $(this).autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "patientSearch", "admin" => false, "plugin" => false)); ?>"+"/"+consultantId,
            minLength: 1, 
            select: function(event, ui) {
                $("#patientId_"+id).val(ui.item.id);
                $("#sPayable_"+id).text(ui.item.s_payable!='null'?ui.item.s_payable:'0');
                $("#bPayable_"+id).text(ui.item.b_payable!='null'?ui.item.b_payable:'0');
                $("#balanceAmount_"+id).text(ui.item.balance_amount!='null'?ui.item.balance_amount:'');
            },
            messages: {
                noResults: '',
                results: function() {}
            }	
        }); 
    });
    $(document).on('keyup','.sharingAmount',function(){
    	var id = $(this).attr('id').split("_")[1];
    	var sharingAmount = parseFloat($("#sharingAmount_"+id).val()!=''?$("#sharingAmount_"+id).val():'0');
    	
    	 var wholeAmount = 0;
         $('.sharingAmount').each(function(){
             var id = $(this).attr('id').split("_")[1];
             wholeAmount = wholeAmount + parseFloat($("#sharingAmount_"+id).val()!=''?$("#sharingAmount_"+id).val():'0');
             if(parseFloat($("#sharingAmount_"+id).val()) > parseFloat($("#balanceAmount_"+id).text())){
            	 alert("Amount should be smaller or equal to Balance Amount");
            	 $("#sharingAmount_"+id).val('');
             }
         });
         
        if($("#patientName_"+id).val() == ''){
        	alert("Please Select Patient");
        	$("#sharingAmount_"+id).val('');
        }
         if(wholeAmount > parseFloat($("#remainingSharingAmount").val())){
             alert("Amount should be smaller or equal to Remaining Amount");
             $(this).val('');
             $(this).focus();
             getTotal();
             return false;
         }
         getTotal();
    });
    function getTotal(){
        var total = 0;
        $('.patient_name').each(function(){
            var id = $(this).attr('id').split("_")[1];
            var sharingAmount = parseFloat($("#sharingAmount_"+id).val()?$("#sharingAmount_"+id).val():'0');
            total = total + sharingAmount;
        });
        var totalAmount = parseFloat($("#remainingSharingAmount").val())-total; 
        $("#remainingAmount").text('Remaining Amount :'+totalAmount);
        $("#currentSharingAmount").val(totalAmount);
        return totalAmount;
    }
</script>