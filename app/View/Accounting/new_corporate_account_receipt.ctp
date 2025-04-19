<section style="margin:10px;">
    <div class="inner_title">
        <h3>
            <?php echo __('Corporate Account Receipt'); ?>
        </h3>
    </div>
    <style>
        .cost{
            text-align: right;
        }
    </style>
    <?php echo $this->Form->create('accounting', array('id' => 'CorporateReceipt', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => false, 'legend' => false, 'O'))); ?>
    <table width="100%" cellpadding="1" cellspacing="1" border="0">
        <tr>
            <td width="100%" valign="top">
                <table width="100%" cellpadding="1" cellspacing="1" border="0">
                    <tr>
                        <td width="30%">
                            <?php
                            echo $this->Form->hidden('AccountReceipt.id', array('type' => 'text'));
                            echo $this->Form->hidden('VoucherEntry.id', array('type' => 'text', 'value' => $this->data['VoucherEntry']['id']));
                            echo $this->Form->hidden('VoucherLog.id', array('type' => 'text', 'value' => $this->data['VoucherLog']['id']));
                            if ($dataDetail['AccountReceipt']['id'] == null) {
                                $ar_no = $ar_no;
                            } else {
                                $ar_no = $dataDetail['AccountReceipt']['id'];
                            }
                            echo __('Receipt No. :');
                            echo $ar_no;
                            ?>
                        </td>
                        <td width="30%">
                            <?php echo __('Day :');
                            echo date('l', strtotime($date = date('Y-m-d'))); ?>
                        </td>
                        <td width="3%">
                            <?php echo __('Date :'); ?>
                        </td>
                            <?php if (!empty($id)) { ?>
                            <td width="10%">
                            <?php echo $this->Form->input('AccountReceipt.date', array('label' => false, 'type' => 'text', 'value' => $this->data['AccountReceipt']['date'],
                                'id' => 'date', 'class' => 'textBoxExpnd'));
                            ?>
                            </td>
                            <?php } else { ?>
                            <td width="10%">
                            <?php
                            $date = $this->data['AccountReceipt']['date'];//$this->DateFormat->formatDate2Local($this->data['AccountReceipt']['date'], Configure::read('date_format'), true);
                            echo $this->Form->input('AccountReceipt.date', array('label' => false, 'type' => 'text', 'value' => $date, 'id' => 'date',
                                'readonly' => 'readonly', 'class' => 'textBoxExpnd'));
                            ?>
                            </td>
<?php } ?>
                    </tr>
                </table>

                <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="account_form">
                    <tr>
                        <th width="60%" align="center" valign="top" style="text-align: left; padding: 5px 0 0 50px;"><strong><?php echo __('Particulars') ?></strong></th>
                        <th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Debit'); ?></strong></th>
                        <th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Credit'); ?></strong></th>
                    </tr>
                    <!-- Debit fields -->
                    <tr>
                        <td colspan="3">
                            <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                                <tr>
                                    <td class="searchdiv" style="width:60%;"><?php echo __('Dr :') ?><font color="red">*</font>
                                        <?php echo $this->data['AccountAlias']['name']; ?>
                                    </td>
                                    <td style="text-align: center; width:20%;">
                                        <?php echo $totalSusAmount = $this->data['AccountReceipt']['paid_amount']; 
                                            echo $this->Form->hidden('total_amount_suspense',array('id'=>'totalSusAmount','value'=>$totalSusAmount)); ?>
                                    </td>
                                    <td style="text-align: right; width:20%;">
                                        <?php echo " "; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php if (!empty($this->data['VoucherEntry']['debit_amount'])) { ?>
                        <tr>
                            <td colspan="3">
                                <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                                    <tr>
                                        <td class="searchdiv" style="width:60%;"><?php echo __('Dr :') ?><font color="red">*</font>
                                            <?php echo $this->data['AccountAliasTwo']['name']; ?>
                                        </td>
                                        <td style="text-align: center; width:20%;">
                                            <?php echo $tdsAmount = $this->data['VoucherEntry']['debit_amount'];
                                                echo $this->Form->hidden('AccountReceipt.tds_amount', array('id' => 'tds_amount', 'value' => $tdsAmount));
                                            ?>
                                        </td>
                                        <td style="text-align: right; width:20%;">
    <?php echo " "; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                                        <?php } ?>
                    <!-- Debit fields -->
                    <!-- Credit fields -->
                    <tr id="cRow1">
                        <td colspan="3">
                            <table width="100%" cellspacing="1" cellpadding="0" border="0" class="tabularForm">
                                <tr>
                                    <td style="width:60%;"><?php echo __('Cr :') ?><font color="red">*</font>
                                        <?php echo $this->data['Account']['name']; ?>
                                    </td>
                                    <td style="text-align: right; width:20%;">
                                        <?php echo " "; ?>
                                    </td>
                                    <td style="text-align: center; width:20%;">
<?php
$tdsAddAmount = $this->data['AccountReceipt']['paid_amount'] + $this->data['VoucherEntry']['debit_amount'];
echo $this->Form->hidden('', array('name' => "data[AccountReceipt][total_suspense_amount]", 'id' => 'suspenseAmont', 'value' => $tdsAddAmount));
echo "<span id='credit_amount'>" . $tdsAddAmount . "<span>";
?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Credit fields -->
                </table>

                <table width="100%" class="tabularForm" cellpadding="0" cellspacing="1" border="0">
                    <thead>
                        <tr>
                            <th width="3%"><?php echo __("Settled"); ?></th>
                            <th><?php echo __("Patient Name"); ?></th>
                            <th><?php echo __("Invoice Amount"); ?></th>
                            <th><?php echo __("Advanced Recived"); ?></th>
                            <th><?php echo __("Amount Received"); ?></th>
                            <th><?php echo __("TDS"); ?></th>
                            <th><?php echo __("Other Deduction"); ?></th>
                            <th><?php echo __("#"); ?></th>
                        </tr>   
                    </thead>
                    <tbody id="patientTable">
                        <tr id="row_1">
                            <td><?php echo $this->Form->input('', array('class' => 'textBoxExpnd isSettled', 'hiddenField' => false, 'type' => 'checkbox', 'title' => 'Check to settled', 'value' => '', 'name' => "data[Corporate][1][is_setteled]", 'id' => 'isSettled_1'));
                                echo $this->Form->hidden('', array('id' => 'patientId_1', 'class' => 'patientId', 'value' => '', 'name' => "data[Corporate][1][patient_id]"));
?></td>
                            <td><?php echo $this->Form->input('', array('class' => 'textBoxExpnd patient_name validate[required,custom[mandatory-enter]]', 'value' => '', 'id' => 'patientName_1', 'type' => 'text', 'placeholder' => 'Patient Name', 'name' => "data[Corporate][1][patient_name]")); ?></td>
                            <td class="invoiceAmount" id="invoiceAmount_1"></td>
                            <td class="advReceived" id="advReceived_1"></td> 
                            <td><?php echo $this->Form->input('', array('class' => 'textBoxExpnd amountReceived', 'id' => 'amountReceived_1', 'type' => 'text', 'placeholder' => 'Amount Received', 'value' => '', 'name' => "data[Corporate][1][amount]", 'autocomplete' => 'off')); ?></td>
                            <td><?php echo $this->Form->input('', array('class' => 'textBoxExpnd tdsAmount', 'id' => 'tdsAmount_1', 'type' => 'text', 'placeholder' => 'TDS', 'value' => '', 'name' => "data[Corporate][1][tds]", 'autocomplete' => 'off')); ?></td>
                            <td><?php echo $this->Form->input('', array('class' => 'textBoxExpnd otherDeduction', 'id' => 'otherDeduction_1', 'type' => 'text', 'value' => '', 'placeholder' => 'Other Deduction', 'name' => "data[Corporate][1][other_deduction]", 'autocomplete' => 'off')); ?></td>
                            <td><?php
                                echo $this->Form->hidden(null, array('name' => "data[Corporate][1][final_billing_id]", 'id' => 'FinalBillingId_1'));
                                echo $this->Form->hidden(null, array('name' => "data[Corporate][1][total_amount]", 'id' => 'totalAmount_1'));
                                echo $this->Html->link($this->Html->image("icons/cross.png", array("alt" => "Remove Row", "title" => "Remove Item")), 'javascript:void(0);', array('escape' => false, 'onClick' => 'removeRow(1);'));
?></td>
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
                        <td valign="middle"  style="width:60%;"><?php echo __('Narration :') ?> 
<?php echo $this->Form->input('AccountReceipt.narration', array('class' => 'inputBox', 'id' => 'narration', 'type' => 'textarea')); ?>
                        </td>
                        <td style="width:20%; padding-left: 40px;" id="debit_total"><?php echo __("Debit Total:"); ?><?php echo $tdsAddAmount; ?></td>
                        <td style="width:20%; padding-left: 40px;" id="credit_total"><?php echo __("Credit Total:"); ?><?php echo $tdsAddAmount; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center" style="padding: 20px 0 20px 0">
<?php echo $this->Form->submit('Save', array('class' => 'blueBtn', 'title' => 'Save', 'style' => 'text-align:right;', 'id' => 'save', 'div' => false, 'name' => 'print')); ?>
<?php echo $this->Html->link(__('Cancel'), array('controller' => 'Accounting', 'action' => 'account_receipt'), array('title' => 'Cancel', 'class' => 'blueBtn')); ?>
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
        $("#save").click(function(){
            var validateForm = jQuery("#CorporateReceipt").validationEngine('validate');
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
        field +=    '<td><input type="checkbox" name="data[Corporate]['+counter+'][is_setteled]" class="textBoxExpnd isSettled" id="isSettled_'+counter+'" value=""/></td>';
        field +=    '<td><input type="text" name="data[Corporate]['+counter+'][patient_name]" class="textBoxExpnd patient_name validate[required,custom[mandatory-enter]]" id="patientName_'+counter+'" placeholder="Patient Name"/> <input type="hidden" id="patientId_'+counter+'" name="data[Corporate]['+counter+'][patient_id]" /></td>';
        field +=    '<td class="invoiceAmount" id="invoiceAmount_'+counter+'"></td>';
        field +=    '<td class="advReceived" id="advReceived_'+counter+'"></td>';
        field +=    '<td><input type="text" name="data[Corporate]['+counter+'][amount]" class="textBoxExpnd amountReceived" id="amountReceived_'+counter+'" placeholder="Amount Received"/></td>';
        field +=    '<td><input type="text" name="data[Corporate]['+counter+'][tds]" class="textBoxExpnd tdsAmount" placeholder="TDS" id="tdsAmount_'+counter+'"/></td>';
        field +=    '<td><input type="text" id="otherDeduction_'+counter+'" name="data[Corporate]['+counter+'][other_deduction]" class="textBoxExpnd otherDeduction" placeholder="other Deduction"/></td>';
        field +=    '<td><input type="hidden" id="FinalBillingId_'+counter+'" name="data[Corporate]['+counter+'][final_billing_id]" /><input type="hidden" id="totalAmount_'+counter+'" name="data[Corporate]['+counter+'][total_amount]" /><a href="javascript:void(0);" onClick="removeRow('+counter+')"><?php echo $this->Html->image("icons/cross.png", array("alt" => "Remove Row", "title" => "Remove Item")); ?></a></td>';
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
        getTotal();
    }

    var tariff_standard_id = "<?php echo $this->params['pass']['1']; ?>"; 

    $(document).on('focus','.patient_name',function(){
        var id = $(this).attr('id').split("_")[1];
        $(this).autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "corporates", "action" => "patientSearch", "admin" => false, "plugin" => false)); ?>"+"/"+tariff_standard_id,
            minLength: 1, 
            select: function(event, ui) { 
                var advanceAmount = parseFloat(ui.item.advance_received!='null'?ui.item.advance_received:'0');
                var totalPaid = parseFloat((advanceAmount + parseFloat(ui.item.tds) ) + parseFloat(ui.item.discount));
                $("#patientId_"+id).val(ui.item.id);
                $("#invoiceAmount_"+id).text(ui.item.hospital_invoice!='null'?ui.item.hospital_invoice:'0');
                $("#advReceived_"+id).text(totalPaid);
                $("#tds_"+id).val(ui.item.tds!='null'?ui.item.tds:'');
                $("#isSettled_"+id).val(ui.item.id!='null'?ui.item.id:'');
                $("#FinalBillingId_"+id).val(ui.item.final_billing_id!='null'?ui.item.final_billing_id:'');
                $("#totalAmount_"+id).val(ui.item.hospital_invoice!='null'?ui.item.hospital_invoice:'');
            },
            messages: {
                noResults: '',
                results: function() {}
            }	
        }); 
    });

    function getTotal(){
        var total = 0;
        $('.patient_name').each(function(){
            var id = $(this).attr('id').split("_")[1];
            var amountReceived = parseFloat($("#amountReceived_"+id).val()?$("#amountReceived_"+id).val():'0');
            var tdsAmount = parseFloat($("#tdsAmount_"+id).val()?$("#tdsAmount_"+id).val():'0');
            var otherDeduction = parseFloat($("#otherDeduction_"+id).val()?$("#otherDeduction_"+id).val():'0');
            var sum = (amountReceived + tdsAmount)/* + otherDeduction*/;
            total = total + sum;
        });
        var totalAmount = parseFloat($("#suspenseAmont").val())-total; 
        $("#credit_amount").text(totalAmount); 
        return totalAmount;
    }

    $(document).on('keyup','.amountReceived, .tdsAmount, .otherDeduction',function(){
        getTotal();
        if(getTotal()<0){
            alert("Amount could not exceeds suspense amount");
            $(this).val('');
            $(this).focus();
            getTotal();
        }
    });

    $(document).on('keyup','.amountReceived',function(){
        var id = $(this).attr('id').split("_")[1];
        var tdsAmount = parseFloat($("#tdsAmount_"+id).val()!=''?$("#tdsAmount_"+id).val():'0'); 
        var amountReceived = parseFloat($("#amountReceived_"+id).val()!=''?$("#amountReceived_"+id).val():'0');
        var advReceived =  parseFloat($("#advReceived_"+id).text()!=''?$("#advReceived_"+id).text():'0');
        var invoiceAmount = parseFloat($("#invoiceAmount_"+id).text()!=''?$("#invoiceAmount_"+id).text():'0');
    
        var wholeSuspenceAmount = 0;
        $('.amountReceived').each(function(){
            var tdsId = $(this).attr('id').split("_")[1];
            wholeSuspenceAmount = wholeSuspenceAmount + parseFloat($("#amountReceived_"+tdsId).val()!=''?$("#amountReceived_"+tdsId).val():'0');
        });
        
        if(wholeSuspenceAmount > parseFloat($("#totalSusAmount").val())){
            alert("Amount should be smaller or equal to Suspense Amount");
            $(this).val('');
            $(this).focus();
            getTotal();
            return false;
        }
        
        var tdsAdvOtherSum = advReceived + tdsAmount;
        var collectMoney = invoiceAmount - tdsAdvOtherSum;
    
        if(amountReceived > collectMoney){
            alert("you could not able to collect amount more than Rs."+collectMoney); 
            $("#otherDeduction_"+id).val('');
            $(this).val('');
            $(this).focus();
            getTotal();
            return false;
        }
        if($("#isSettled_"+id).is(':checked') == true){
            $("#otherDeduction_"+id).val(collectMoney - amountReceived);
        }else{
            $("#otherDeduction_"+id).val('');
        }
        getTotal();
    });

    $(document).on('keyup','.tdsAmount',function(){ 
        var id = $(this).attr('id').split("_")[1];
        var tdsAmount = parseFloat($("#tdsAmount_"+id).val()!=''?$("#tdsAmount_"+id).val():'0'); 
        var amountReceived = parseFloat($("#amountReceived_"+id).val()!=''?$("#amountReceived_"+id).val():'0');
        var advReceived =  parseFloat($("#advReceived_"+id).text()!=''?$("#advReceived_"+id).text():'0');
        var invoiceAmount = parseFloat($("#invoiceAmount_"+id).text()!=''?$("#invoiceAmount_"+id).text():'0');
        var otherDeduction = parseFloat($("#otherDeduction_"+id).val()!=''?$("#otherDeduction_"+id).val():'0');

        var tdsAdvOtherSum = advReceived + tdsAmount;
        var collectMoney = invoiceAmount - tdsAdvOtherSum; 
    
        var wholeTdsAmount = 0;
        $('.tdsAmount').each(function(){
            var tdsId = $(this).attr('id').split("_")[1];
            wholeTdsAmount = wholeTdsAmount + parseFloat($("#tdsAmount_"+tdsId).val()!=''?$("#tdsAmount_"+tdsId).val():'0');
        });
        if(wholeTdsAmount > parseFloat($("#tds_amount").val())){
            alert("TDS should be smaller or equal to Susapense TDS");
            $(this).val('');
            $(this).focus();
            getTotal();
            return false;
        }
    
        if((collectMoney - amountReceived)>0 && $("#isSettled_"+id).is(':checked') == true){
            $("#otherDeduction_"+id).val(collectMoney - amountReceived);
        }else{
            var remainAmount = (tdsAmount - otherDeduction);
            if($("#isSettled_"+id).is(':checked') == true){
                $("#otherDeduction_"+id).val(0);
                $("#amountReceived_"+id).val((amountReceived)-remainAmount);
            } 
        }
     
        if($("#isSettled_"+id).is(':checked') == false){
            var tdsAdvOtherSum = advReceived + (amountReceived + otherDeduction);
            var collectMoney = invoiceAmount - tdsAdvOtherSum; 
            if(tdsAmount > collectMoney){
                alert("Could not able to collect tds amount more than Rs."+collectMoney); 
                //$("#otherDeduction_"+id).val('');
                $(this).val('');
                $(this).focus();
                getTotal();
                return false;
            }
        }
        getTotal();
    });
 
    $(document).on('click','.isSettled',function(){  
        var id = $(this).attr('id').split("_")[1];
        var tdsAmount = parseFloat($("#tdsAmount_"+id).val()!=''?$("#tdsAmount_"+id).val():'0'); 
        var amountReceived = parseFloat($("#amountReceived_"+id).val()!=''?$("#amountReceived_"+id).val():'0');
        var advReceived =  parseFloat($("#advReceived_"+id).text()!=''?$("#advReceived_"+id).text():'0');
        var invoiceAmount = parseFloat($("#invoiceAmount_"+id).text()!=''?$("#invoiceAmount_"+id).text():'0');

        var tdsAdvOtherSum = advReceived + tdsAmount;
        var collectMoney = invoiceAmount - tdsAdvOtherSum; 
        if($("#isSettled_"+id).is(':checked') == true){
            if(amountReceived > collectMoney){
                alert("you could not able to collect amount more than Rs."+collectMoney); 
                $("#otherDeduction_"+id).val('');
                $(this).val('');
                $(this).focus();
                getTotal();
                return false;
            }
            $("#otherDeduction_"+id).val(collectMoney - amountReceived);
        }else{
            $("#otherDeduction_"+id).val('');
        }
        getTotal();  
    }); 
    
    $(document).on('keyup','.otherDeduction',function(){  
        var id = $(this).attr('id').split("_")[1];
        var tdsAmount = parseFloat($("#tdsAmount_"+id).val()!=''?$("#tdsAmount_"+id).val():'0'); 
        var amountReceived = parseFloat($("#amountReceived_"+id).val()!=''?$("#amountReceived_"+id).val():'0');
        var advReceived =  parseFloat($("#advReceived_"+id).text()!=''?$("#advReceived_"+id).text():'0');
        var invoiceAmount = parseFloat($("#invoiceAmount_"+id).text()!=''?$("#invoiceAmount_"+id).text():'0');
        var otherDeduction = parseFloat($("#otherDeduction_"+id).val()!=''?$("#otherDeduction_"+id).val():'0');
            
        var tdsAdvOtherSum = (advReceived + tdsAmount) + amountReceived;
        var collectMoney = invoiceAmount - tdsAdvOtherSum;  
        if($("#isSettled_"+id).is(':checked') == false){
            if(otherDeduction > collectMoney){
                alert("you could not able to enter amount more than Rs."+collectMoney); 
                $("#otherDeduction_"+id).val('');
                $(this).val('');
                $(this).focus();
                getTotal();
                return false;
            }
        }
        getTotal();
    });
</script>