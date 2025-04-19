<?php
echo $this->Html->script(array('jquery.blockUI'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
$referral = $this->request->referer();
echo $this->Form->hidden('formReferral', array('value' => '', 'id' => 'formReferral'));
?>
<style>
    .blue-row{
        /*        background-color:#D9D9D9;
        background-color:#a6a97f;*/
         background-color:#d8ffd9;
    }
    .row_gray{
       background-color:#c7c0b6 !important;
    }
    .alert-row{
        background-color:red;
    }
    .ho:hover{
        background-color:#C1BA7C;
    }
</style>

<style> 
    .table_format{
        padding : 0px !important;
    } 
</style>
<?php
$flashMsg = $this->Session->flash('still');
if (!empty($flashMsg)) {
    ?>
    <div>
    <?php echo $flashMsg; ?>
    </div> 
    <?php } ?>
<div class="inner_title" >
        <?php echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy')); ?>
    <h3>Sales Bill</h3>
    <span><?php
        if ($requisitionType == "editDirectView") {
            echo $this->Html->link(__('Back'), array('controller' => 'Pharmacy', 'action' => 'get_other_pharmacy_details', 'sales', 'inventory' => true), array('escape' => false, 'class' => 'blueBtn'));
        } else {
            echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false, 'class' => 'blueBtn'));
        }

        echo $this->Html->link(__('Add Product'), 'javascript:void(0)', array('escape' => false, 'class' => 'blueBtn', 'id' => 'addProduct'));
        ?> </span>
</div> 
<style>
    .formErrorContent {
        width: 43px !important;
    }
    .inner_title{
        padding-bottom: 0px;
    }
    .table_format {
        /* padding: 10px;*/
    }
    .tdLabel2s{
        width: 125px;
    }
</style>


<?php
if (($requisitionType == "edit") || ($requisitionType == "editDirectView")) {
    $disabled = "disabled";
    $readonly = "readonly";
} else {
    $disabled = "";
    $readonly = "";
}
?>
<?php
if ($websiteConfig['instance'] == 'vadodara') {
    $readonlForVado = "readonly";
} else {
    $readonlForVado = "";
}
?>
<?php
echo $this->Html->script('pharmacy_sales');
$patient_name = "";
$patient_admission_id = "";
$patient_id = "";
$patientId = "";
if (isset($patient)) {
    $patient_name = $patient['Patient']['lookup_name'];
    $patientId = $patient['Patient']['patient_id'];
    $patientNameId = $patient_name . "-" . $patientId;
    $patient_admission_id = $patient['Patient']['admission_id'];
    $patient_id = $patient['Patient']['id'];
    $patient_doctor_name = $patient['User']['full_name'];
    $admissionType = $patient['Patient']['admission_type'];
    $tariff = $patient['TariffStandard']['name'];
    if (!empty($doctorData)) {
        $patient_doctor_id = $doctorData['id'];
        $patient_doctor_name = $doctorData['doctor_name'];
    }
}
//debug($patient);
?>

<div class="clr ht5"></div>
<?php echo $this->Form->create('InventoryPurchaseDetail', array('onkeypress' => "return event.keyCode != 13;", 'id' => 'salesBill')); ?>

<!-- Patient Name and doctor search table Ends at Line No: 167 -->

        <?php /* Code for direct sles Edit */ ?>
        <?php if ($this->params['pass'][1] == 'editDirectView') { ?>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="45" class="tdLabel2">Date</td>
            <?php if (!empty($pharmacySales['PharmacySalesBill']['modified_time'])) { ?>
                <td width="140" class="tdLabel2"><input name="sale_date" type="text"
                                                        class="textBoxExpnd" id="sale_date" 
                                                        value="<?php echo $this->DateFormat->formatDate2Local($pharmacySales['PharmacySalesBill']['create_time'], Configure::read('date_format'), false); ?>" />
                </td>
                <?php } else { ?>
                <td width="140" class="tdLabel2"><input name="sale_date" type="text"
                                                        class="textBoxExpnd" id="sale_date" 
                                                        value="<?php echo $this->DateFormat->formatDate2Local($pharmacySales['PharmacySalesBill']['create_time'], Configure::read('date_format'), false); ?>" /></td>
    <?php } ?>
            <td width="45" class="tdLabel2">Patient Name<font color="red">*</font> </td>
            <td width="140" class="tdLabel2"><input name="party_name" type="text" class="textBoxExpnd validate[required]" id="party_name"  autocomplete="off"
                                                    value="<?php echo $pharmacySales['PharmacySalesBill']['customer_name']; ?>" />
                <a href="#" id="ss"><?php echo $this->Html->image('/img/icons/1361479921_credit-card.png', array('alt' => 'View Credit', "title" => "View Credit")); ?> </a></td>

    <?php 
    if (isset($patient)) { 
        echo "<input type='hidden' name='redirect_to_billing' value='1'>";
    }
    ?>
            <td width="45" class="tdLabel2">Doctor Name</td>
            <td width="120" class="tdLabel2"><input name="doctor_name" type="text"
                                                    class="textBoxExpnd" id="doctor_name"  value="<?php echo $pharmacySales['PharmacySalesBill']['p_doctname']; ?>" /><input
                                                    name="PharmacySalesBill[doctor_id]" id="doctor_id" value=""
                                                    type="hidden" /></td>
        </tr>
    </table>
            <?php /* End of DirectSale Edit */ ?>
        <?php } else { ?>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" >
        <tr>

    <?php if ((!empty($requisitionType) && $requisitionType == "edit")) { ?>

                <td width="45" class="tdLabel2">Date</td>
                <?php if (!empty($pharmacySales['PharmacySalesBill']['modified_time'])) { ?>
                    <td width="140" class="tdLabel2"><input name="sale_date" type="text"
                                                            class="textBoxExpnd" id="sale_date" 
                                                            value="<?php echo $this->DateFormat->formatDate2Local($pharmacySales['PharmacySalesBill']['create_time'], Configure::read('date_format'), false); ?>" />
                    </td>
                    <?php } else { ?>
                    <td width="140" class="tdLabel2"><input name="sale_date" type="text"
                                                            class="textBoxExpnd" id="sale_date" 
                                                            value="<?php echo $this->DateFormat->formatDate2Local($pharmacySales['PharmacySalesBill']['create_time'], Configure::read('date_format'), false); ?>" /></td>
        <?php }
    }
    ?> 

    <?php if ((!empty($requisitionType) && $requisitionType == "copy")) {  ?>

                <td width="45" class="tdLabel2">Date</td>
               
                    <td width="140" class="tdLabel2">
                        <input name="sale_date" type="text" class="textBoxExpnd validate[required]" id="copy_date"  value="" /></td>
        <?php 
    }
    ?> 

            <td style="text-align:right" class="tdLabel2">Patient Name / ID<font color="red">*</font> : &nbsp;</td>

            <td width="" class="tdLabel2"><input name="party_name" type="text"class="textBoxExpnd validate[required]" id="party_name"  tabindex="1"
                                                 value="<?php echo $patientNameId; ?>" <?php echo $disabled; ?>/>

                <input	name="PharmacySalesBill[patient_id]" id="person_id" class="textBoxExpnd validate[required]"
                       value="<?php echo $patient_id; ?>" type="hidden" />
                <input name="party_code" type="hidden"
                       class="textBoxExpnd" id="party_code" value="<?php echo $patient_admission_id; ?>" />	
                <input	name="PharmacySalesBill[admission_type]" id="admission_type" class="textBoxExpnd validate[required]" type="hidden" value = <?php !empty($patient['Patient']['admission_type'])?$patient['Patient']['admission_type']:'' ?>/>
                <?php echo $this->Form->hidden('', array('id' => 'tariff_id', 'name' => "data[PharmacySalesBill][tariff]", 'value' =>!empty($patient['TariffStandard']['id'])?$patient['TariffStandard']['id']:'')); ?>
            <?php echo $this->Form->hidden('', array('id' => 'roomType', 'name' => "data[PharmacySalesBill][room_type]", 'value' => '')); ?>
                <a href="#" id="ss"><?php echo $this->Html->image('/img/icons/1361479921_credit-card.png', array('alt' => 'View Credit', "title" => "View Credit")); ?>
                </a></td>

            <td width=""><?php echo $this->Form->input('all_encounter', array('type' => 'checkbox', 'label' => false, 'div' => false, 'id' => 'all_encounter', 'title' => 'Show all encounter of patient'));
        echo $this->Form->hidden('isChecked', array('id' => 'is_checked', 'value' => '0'));
        ?>All Encounter</td>
            <td id="tariff" width="140"><?php $tariff = !empty($tariff)?" (".$tariff.") ":''; echo $admissionType.$tariff;  ?></td>
    <?php
    if (isset($patient)) {
        echo "<input type='hidden' name='redirect_to_billing' value='1'>";
    }
    ?>
            <td style="text-align:right" class="tdLabel2">Doctor Name : &nbsp;</td>
            <td width="" class="tdLabel2">
                <input name="doctor_name" type="text" tabindex="2" class="textBoxExpnd" id="doctor_name"  value="<?php echo ($patient_doctor_name) ? $patient_doctor_name : $pharmacySales['DoctorProfile']['doctor_name']; ?>" <?php echo $disabled; ?>/>
                <input name="PharmacySalesBill[doctor_id]" id="doctor_id" value="<?php echo $pharmacySales['DoctorProfile']['user_id'] ?>" type="hidden" /></td>
        </tr>
    </table>
<?php } ?>

<!-- END of Patient & Doctor Search table  starts at line No :84-->

<!-- Sale Bill Starts from Here Ends at -->
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="table_format" id="item-row">
    <tr><td colspan="3"><font color="#ff343"><i>(MSU = Minimum Saleable Unit)</i></font></td></tr>
    <tr class="row_title" style="border:1pt solid black;" >
        <td width="50" align="center" class="table_cell" valign="top" style="text-align: center;">Item Code</td>
        <td width="250" align="center" valign="top" class="table_cell" 	style="text-align: center;">Item Name<font color="red">*</font>	</td>
        <td width="120" valign="top" class="table_cell" style="text-align: center;">Quantity<font color="red">*</font> (MSU)</td>
        <td width="20" valign="top" style="text-align: center;" class="table_cell">Pack</td>
        <td width="20" valign="top" style="text-align: center;" class="table_cell">Administration Time</td>
        <td width="100" align="center" valign="top" style="text-align: center;" class="table_cell">Batch No.<font color="red">*</font>	</td>
        <td width="50" align="center" valign="top" style="text-align: center;" class="table_cell">Stock</td>
        <td width="100" align="center" valign="top" style="text-align: center;" class="table_cell">Expiry Date<font color="red">*</font></td>
        <td width="50" valign="top" style="text-align: center;" class="table_cell">MRP<font color="red">*</font></td>
        <td width="50" valign="top" style="text-align: center;" class="table_cell">Price<font color="red">*</font></td> 
        <td width="60" valign="top" style="text-align: center;" class="table_cell">Amount<font	color="red">*</font></td>
        <td width="10" style="text-align: center;" class="table_cell">#</td>
    </tr>
<?php $cnt = 1;
$grossAmount = 0;
$totalItemDiscount = 0; ?>

    <!--  Code starts For Simple Item sales BIll - Ends At 328--> 

<?php if (empty($pharmacyData)) { ?>
        <input type="hidden" value="1" id="no_of_fields" />
        <tr id="row1" class="row_gray ho" >
            <td align="center" valign="middle">
                <input name="item_code[]" type="text" class="textBoxExpnd item_code" id="item_code-1" value="" style="width: 100%;" fieldNo="1" onkeyup="checkIsItemRemoved(this)" autocomplete="off"/>
                <input name="data[item_id][]" id="item_id1" class="itemId" type="hidden"  value="" fieldNo="1"/>
            </td>
            <td align="center" valign="middle" style="padding:0px;">
                <table width="100%">
                    <tr>
                        <td style="padding:0px;">
                            <input name="item_name[]" type="text" class="textBoxExpnd validate[required] item_name" id="item_name-1" value="" fieldNo="1" tabindex="3"
                                   onkeyup="checkIsItemRemoved(this)" autocomplete="off" style="width:95%;" />
                        </td>
                        <td style="padding:0px;">
                            <a href="javascript:void(0);" id="Generic" onclick="showGeneric('1');" style="padding: 0px;">
                                <?php 
                                    echo $this->Html->image('icons/generic.png', array('title' => 'Generic', 'alt' => 'Generic', 'class' => 'showGeneric', 'fieldNo' => "1"));
                                ?>
                            </a>
                                <?php
                                echo $this->Form->hidden('PharmacySalesBill.generic', array('id' => 'genericName1', 'name' => "generic[]", 'fieldNo' => '1', 'value' => '', 'class' => 'genericName'));
                                ?>
                        </td>
                    </tr>
                </table>
            </td>

            <td valign="middle" style="text-align: center;" valign="center">
                <input name="qty[]" type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" id="qty_1" value="" 
                                   style="" fieldNo="1" /> 
                <input name="itemType[]" type="hidden" autocomplete="off" id="itemType_1" value="Tab" 
                                   style="" fieldNo="1" />

                <!-- <table>
                    <tr>
                        <td>
                            <input name="qty[]" type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" id="qty_1" value="" 
                                   style="" fieldNo="1" /> 
                        </td>
                        <td>
                                <?php
                                /*echo $this->Form->input('PharmacySalesBill.item_type', array('style' => 'width:55px;', 'name' => "itemType[]", 'class' => 'itemType',
                                    'div' => false, 'fieldNo' => "1", 'label' => false, 'autocomplete' => 'off', 'id' => 'itemType_' . $cnt,
                                    'options' => array('Tab' => 'MSU')));*/
                                ?>  
                        </td>
                    </tr>
                </table> -->
            </td> 

            <td valign="middle" style="text-align: center;">
            <span class="showPack" id="showPack_1"></span>
                <input name="pack[]" type="hidden"  id="pack1"  value="" style="width:50px"  autocomplete="off" readonly="true" />
                        <!--<td width="50px"><?php echo $this->Form->input('', array('type' => 'text', 'id' => 'doseForm1', 'autocomplete' => 'off', "fieldNo" => "1", 'label' => false, 'style' => 'width:50px', 'value' => "", 'name' => "doseForm[]")); ?></td>-->
            </td>
            <td valign="middle" style="text-align: center;">
				<?php echo $this->Form->input('', array('type' => 'select','empty'=>'Please Select','options'=>Configure::read('administration_time'), 'id' => 'administrationTime1','class'=>'textBoxExpnd', 'autocomplete' => 'off', "fieldNo" => "1", 'label' => false, 'style' => 'width:100%;', 'value' => "", 'name' => "data[administration_time][]")); ?>
			</td>

            <td valign="middle" style="text-align: center;">
    <?php echo $this->Form->input('', array('type' => 'select', 'options' => '', 'class' => 'textBoxExpnd validate[required] batch_number', 'id' => 'batch_number1', 'autocomplete' => "off", "fieldNo" => "1", 'label' => false, 'name' => "data[pharmacyItemId][]", 'style' => 'width:100%;')); ?>

            </td>

            <td valign="middle" style="text-align: center;">
            <!--<input name="stok[]" type="hidden"  value="" fieldNo="1" />-->
            <span class="showStock" id="showStock_1"></span>
            <input type="hidden" id="stockWithLoose_1" name="stockWithLoose[]" fieldNo="1" class="textBoxExpnd" value="0" readonly="true" />
                            <input type="hidden" id="stockQty1" name="stok[]" fieldNo="1" class="textBoxExpnd" value="0" readonly="true" />
                            <input type="hidden" id="looseStockQty1" class="textBoxExpnd" value="0" readonly="true" /> 
            </td>

            <td valign="middle" style="text-align: center;"><input
                    name="expiry_date[]" type="text"
                    class="validate[future[now]] textBoxExpnd expiry_date" <?php echo $disabled; ?>
                    id="expiry_date1"  value="" style="width: 70%;"
                    autocomplete="off" /></td>

            <td valign="middle" style="text-align: right;">
            <span class="showMrp" id="showMrp_1"></span>
            <input name="mrp[]"
                                                                   type="hidden" class="textBoxExpnd validate[required,number] mrp" id="mrp1"
                                                                   fieldNo="1" value="" style="width: 100%;" autocomplete="off" readonly="true"/></td> 

            <td valign="middle" style="text-align: right;">
            <span class="showRate" id="showRate_1"></span>
            <input name="rate[]"
                                                                   type="hidden" class="textBoxExpnd validate[required,number] rate" fieldNo="1" id="rate1"
                                                                   value="" style="width: 100%;" autocomplete="off" readonly="true"/></td>

            <td valign="middle" style="text-align: right;">
            <span class="showValue" id="showValue_1"></span>
            <input name="value[]"
                                                                   type="hidden" class="textBoxExpnd validate[required,number] value" readonly="readonly"
                                                                   id="value1"  value="" style="width: 100%;" autocomplete="off" /></td>
            <td valign="middle" style="text-align: center;">
                <a href="javascript:void(0);" id="delete row" onclick="deletRow('1');"> 
        <?php echo $this->Html->image("icons/cross.png", array("alt" => "Remove Row", "title" => "Remove Item",'style'=>'float:none !important')); ?> 
                </a>
            </td>
        </tr>
        <?php $cnt++; ?>
        <!--   END of Simple Item Sales BIll starts from 169 --> 

        <!--  Code For Different Arguments- medication, ot, nurse, edit, editDirectView - Ends at 665 -->

<?php } else if (!empty($pharmacyData)) { ?>
    <?php
    $cnt = 1; 
    $totalAmForEachMed = 0;
    $totalForPres = 0;
    foreach ($pharmacyData as $prescriptions) { 
        if ($cnt % 2 != 0) {
            $clas = "row_gray";
        } else {
            $clas = "blue-row";
        }
        ?>
            <tr id="<?php echo 'row' . $cnt ?>" class="ho <?php echo $clas; ?>">
            <input name="data[new_crop_itemId][]" class="itemId"  type="hidden" value="<?php echo $prescriptions['PharmacyItem']['id']; ?>"/>
            <!-- Item Code -->
            <td align="center" valign="middle">
                <input name="item_code[]"  type="text" class="textBoxExpnd item_code" autocomplete="off" id="item_code-<?php echo $cnt ?>"  
                       value="<?php echo $prescriptions['PharmacyItem']['item_code']; ?>" style="width: 100%;" fieldNo="<?php echo $cnt; ?>" 
                       onkeyup="return checkIsItemRemoved(this);" readonly="true" /> 

                <input name="data[item_id][]" class="itemId" id="item_id<?php echo $cnt ?>" fieldNo="<?php echo $cnt ?>" type="hidden" 
                       value="<?php echo $prescriptions['PharmacyItem']['id']; ?>"/>
            </td>

            <!-- Item Name With Generic Search -->
            <td align="center" valign="middle" style="padding:0px;">
                <table width="100%">
                    <tr>
                        <td style="padding:0px;">
                            <input name="item_name[]" type="text" class="textBoxExpnd validate[required] item_name" id="item_name-<?php echo $cnt ?>" value="<?php echo $prescriptions['PharmacyItem']['name']; ?>" style="width: 90%;" fieldNo="<?php echo $cnt; ?>"
                                   onkeyup="checkIsItemRemoved(this)" autocomplete="off" style="width:95%;" <?php echo $disabled; ?>/>
                        </td>
                        <td style="padding:0px;">
        <?php if ($this->params['pass'][1] != 'editDirectView') { ?>
                                <a href="javascript:void(0);" id="Generic" onclick="showGeneric('<?php echo $cnt; ?>');" style="padding: 0px;">
                                <?php echo $this->Html->image('icons/generic.png', array('title' => 'Generic', 'alt' => 'Generic', 'class' => 'showGeneric', 'fieldNo' => $cnt)); ?>
                                </a>
        <?php } ?>
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Quantity -->
            <td valign="middle" style="text-align: center;">

               <!--  <table><tr><td style="padding:0"> -->
                                   <?php /*                                    * * Quantity For OT ** */ ?>
                                   <?php if ($requisitionType == 'ot') { ?>
                                <input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" disabled="<?php echo $disabled; ?>"
                                       id="qty_<?php echo $cnt ?>" twidowsex="10" style="" fieldNo="<?php echo $cnt; ?>" value="<?php echo $drugQty[$cnt - 1]; ?>" itemid ="<?php echo $prescriptions['PharmacyItem']['id']; ?>"/>
                                       <?php
                                       //calcualte Ot TotalAmount 
                                       if (!empty($prescriptions['PharmacyItemRate']['sale_price'])) {
                                           $totalAmount = $prescriptions['PharmacyItemRate']['sale_price'] * $drugQty[$cnt - 1];
                                           $totalAmt = number_format($totalAmount, 2) . "";
                                       } else if (!empty($prescriptions['PharmacyItemRate']['mrp'])) {
                                           $totalAmount = $prescriptions['PharmacyItemRate']['mrp'] * $drugQty[$cnt - 1];
                                           $totalAmt = number_format($totalAmount, 2) . "";
                                       }
                                       $totalAmForEachMed += $totalAmt;
                                       /*                                        * * END OF OT Quantity ** */

                                       /*                                        * * calculations For Sales bill Edit & DirectSale Bill Edit ** */
                                   } else if (!empty($requisitionType) && $requisitionType == 'edit' || !empty($requisitionType) && $requisitionType == 'editDirectView' || !empty($requisitionType) && $requisitionType == 'copy') {
                                       // Calculate Total Amount for edit
                                       $pharmaSaleQty = $pharmaItemQty[$prescriptions['PharmacyItem']['id']];
                                       $pharmaSalePriceDisplay = $pharmaSalePrice[$prescriptions['PharmacyItem']['id']];
                                       $pharmaSaleMrpDisplay = $pharmaMrp[$prescriptions['PharmacyItem']['id']];
                                       $pharmaType = $pharmaItemType[$prescriptions['PharmacyItem']['id']];
                                       $pharmaBatches = $pharmBatch[$prescriptions['PharmacyItem']['id']];
                                       $pharmaDiscount = $itemWiseDiscount[$prescriptions['PharmacyItem']['id']];
                                       $pPack = $pharmaPack[$prescriptions['PharmacyItem']['id']];
                                       $discountCal = ($pharmaSaleQty * $pharmaDiscount / 100) * $pharmaSalePriceDisplay;
                                       $admTime = $pharmaAdmTime[$prescriptions['PharmacyItem']['id']];

                                       // Calculation of total amount Pack Wise for other Instances
                                       if (!empty($pharmaSalePriceDisplay)) {
                                           $totalAmount = $pharmaSalePriceDisplay * $pharmaSaleQty;
                                           $totalAmt = number_format($totalAmount, 2) . "";
                                       } else if (!empty($pharmaSaleMrpDisplay)) {
                                           $totalAmount = $pharmaSaleMrpDisplay * $pharmaSaleQty;
                                           $totalAmt = number_format($totalAmount, 2) . "";
                                       }

                                       $totalAmForEachMed += $totalAmt;
                                       ?>
                                <!-- Edit and DirectsaleEdit Quantity -->
                                <input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" <?php echo $disabled; ?>
                                       id="qty_<?php echo $cnt ?>" twidowsex="11"  style="" fieldNo="<?php echo $cnt; ?>" value="<?php echo $pharmaItemQty[$prescriptions['PharmacyItem']['id']]; ?>"/>
                                       <?php
                                       $rowTotal = $pharmaItemQty[$prescriptions['PharmacyItem']['id']] * $prescriptions['PharmacyItemRate']['sale_price'];

                                       /*                                        * * End Of code salesBill Edit and DirectSaleBill Edit ** */

                                       /*                                        * * Amount Calculation for Nurse Prescription ** */
                                   } else if (!empty($requisitionType) && $requisitionType == 'nurse') {
                                       /* It will Display Remaining Quantity of nurse after partial Salebill */
                                       if ($prescriptions['NewCropPrescription']['recieved_quantity'] != " " && $prescriptions['NewCropPrescription']['recieved_quantity'] != 0) {
                                           $quantity = $prescriptions['NewCropPrescription']['quantity'] - $prescriptions['NewCropPrescription']['recieved_quantity'];
                                       } else {
                                           $quantity = $prescriptions['NewCropPrescription']['quantity'];
                                       }

                                       $pack = $prescriptions['PharmacyItem']['pack'];
                                       $packInt = (int) preg_replace('/\D/', '', $pack);


                                       // Tablet Wise Calculation for Other Instance
                                       if (!empty($prescriptions['PharmacyItemRate'][0]['sale_price'])) {
                                           $totalAmount = ($prescriptions['PharmacyItemRate'][0]['sale_price'] / $packInt) * $quantity;
                                           $totalAmt = number_format($totalAmount, 2) . "";
                                       } else if (!empty($prescriptions['PharmacyItemRate'][0]['mrp'])) {
                                           $totalAmt = ($prescriptions['PharmacyItemRate'][0]['mrp'] / $packInt) * $quantity;
                                           $totalAmt = number_format($totalAmount, 2) . "";
                                       }

                                       $totalAmForEachMed += $totalAmount;
                                       ?>
                                <!-- Quantity for NursePrescription  -->
                                <input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" <?php echo $disabled; ?>
                                       id="qty_<?php echo $cnt ?>" twidowsex="11"  style="" fieldNo="<?php echo $cnt; ?>" value="<?php echo $quantity; ?>" 
                                       itemid ="<?php echo $prescriptions['PharmacyItem']['id']; ?>" orderedQty ="<?php echo $prescriptions['NewCropPrescription']['quantity']; ?>" 
                                       recvQty ="<?php echo $prescriptions['NewCropPrescription']['recieved_quantity'] ?>"/>


                                <?php /*                                 * * END of NursePrescription Calculation of amount ** */ ?>	
                            <?php
                            } else {

                                /*                                 * * Amount Calculation For Medication ** */
                                $pack = $prescriptions['PharmacyItem']['pack'];
                                $packInt = (int) preg_replace('/\D/', '', $pack);

                                // Tablet Wise Calculation for Other Instance
                                if (!empty($prescriptions['PharmacyItemRate'][0]['sale_price'])) {
                                    $totalAmount = ($prescriptions['PharmacyItemRate'][0]['sale_price'] / $packInt) * $prescriptions['NewCropPrescription']['quantity'];
                                    $totalAmt = number_format($totalAmount, 2) . "";
                                } else if (!empty($prescriptions['PharmacyItemRate'][0]['mrp'])) {
                                    $totalAmount = ($prescriptions['PharmacyItemRate'][0]['mrp'] / $packInt) * $prescriptions['NewCropPrescription']['quantity'];
                                    $totalAmt = number_format($totalAmount, 2) . "";
                                }

                                $totalAmForEachMed += $totalAmount;
                                ?>
                                <!-- Quantity for Medication -->
                                <input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" <?php echo $disabled; ?>
                                       id="qty_<?php echo $cnt ?>" twidowsex="11"  style="" fieldNo="<?php echo $cnt; ?>" value="<?php echo $prescriptions['NewCropPrescription']['quantity']; ?>"/>

        <?php } ?> 
                        <!-- </td>
        <?php /*         * * End of All Calculations And Quantity ** */ ?>	
 	
                        <td>	 -->
        <?php 
       echo $this->Form->hidden('itemType', array('style' => 'width:60px;', 'class' => 'itemType', 'name' => "itemType[]",
            'div' => false, 'fieldNo' => $cnt, 'label' => false, 'autocomplete' => 'off', 'id' => 'itemType_' . $cnt, 'value' => 'Tab' /*$pharmaItemType[$prescriptions['PharmacyItem']['id']]*/,
            //'options' => array('Tab' => 'MSU')
            )); 
        ?>
                                 <!-- <input type="hidden" id="stockQty<?php echo $cnt ?>" value="<?php echo $prescriptions['PharmacyItem']['stock'] ?>" /> -->
                        <!-- </td>
                    </tr>
                </table> -->
            </td>
            <!-- End of Quantity & Item Type Table -->	
            <!-- Pack -->
            <td align="center" valign="middle">
            <span id="showPack_<?php echo $cnt ?>" class="showPack"><?php echo $prescriptions['PharmacyItem']['pack']; ?></span>
            <input name="pack[]" type="hidden" autocomplete="off" fieldNo="<?php echo $cnt; ?>" <?php echo $disabled; ?> class="textBoxExpnd " id="pack<?php echo $cnt ?>"  value="<?php echo $prescriptions['PharmacyItem']['pack']; ?>" style="width: 100%;" readonly="true" /></td>

            <td valign="middle" style="text-align: center;">
                <?php echo $this->Form->input('', array('type' => 'select','empty'=>'Please Select','options'=>Configure::read('administration_time'), 'id' => 'administrationTime'.$cnt,'class'=>'textBoxExpnd', 'autocomplete' => 'off', "fieldNo" => $cnt, 'label' => false, 'style' => 'width:100%;', 'value' => $admTime, 'name' => "data[administration_time][]")); ?>
            </td>

            <!-- Batch -->
            <td valign="middle" style="text-align: center;">
                        <?php
                        $batches = "";
                        foreach ($prescriptions['PharmacyItemRate'] as $val) {
                            $batches[$val['id']] = $val['batch_number'];
                        }
                        $myKey = array_search($pharmaBatches, $batches);

                        echo $this->Form->input('batch_number', array('type' => 'select', 'options' => $batches, 'div' => false, 'class' => 'textBoxExpnd validate[required] batch_number',
                            'id' => 'batch_number' . $cnt, 'value' => $myKey, $disabled, 'style' => "width: 100%", 'autocomplete' => "off", "fieldNo" => $cnt, 'label' => false, 'name' => "data[pharmacyItemId][]"));
                        ?>

            </td>

            <?php if ($requisitionType == 'nurse') { ?>
            <!-- STOCK  -->	
            <td valign="middle" style="text-align: center;">
                <!-- <table width="100%">
                    <tr> --> 
                    <?php
                        $stockQty = (int) $prescriptions['PharmacyItemRate'][0]['stock'] /** (int) $prescriptions['PharmacyItem']['pack']*/;
                        $stockLoose = $stockQty + (int) $prescriptions['PharmacyItemRate'][0]['loose_stock'];
                        ?>
                        <!-- <td style="padding:0"> -->
                        <span id="showStock_<?php echo $cnt; ?>" class="showStock"><?php echo $stockQty; ?></span>
                        <input type="hidden" readonly="true" id="stockWithLoose_<?php echo $cnt; ?>" name="stockWithLoose[]" fieldNo="<?php echo $cnt; ?>" class="textBoxExpnd" value="<?php echo $stockQty; ?>" />
                            <input type="hidden" id="stockQty<?php echo $cnt; ?>" name="stok[]" fieldNo="<?php echo $cnt; ?>" class="textBoxExpnd" value="<?php echo $stockQty; ?>" readonly="true" />
                            <input type="hidden" id="looseStockQty<?php echo $cnt; ?>" class="textBoxExpnd" value="<?php echo '0'; ?>" readonly="true" /></td>
                    <!-- </tr>
                </table>
            </td> -->
            <?php } else { ?>
            <td valign="middle" style="text-align: center;">
               <!--  <table width="100%">
                    <tr> -->
                    <?php
                        $stockQty = (int) $prescriptions['PharmacyItemRate'][0]['stock'] * (int) $prescriptions['PharmacyItem']['pack'];
                        $stockLoose = $stockQty + (int) $prescriptions['PharmacyItemRate'][0]['loose_stock'];
                        ?>
                        <!-- <td style="padding:0"> -->

                        <span id="showStock_<?php echo $cnt; ?>" class="showStock"><?php echo $stockLoose; ?></span>
                        <input type="hidden" readonly="true" id="stockWithLoose_<?php echo $cnt; ?>" name="stockWithLoose[]" fieldNo="<?php echo $cnt; ?>" class="textBoxExpnd" value="<?php echo $stockLoose; ?>" />
                            <input type="hidden" id="stockQty<?php echo $cnt; ?>" name="stok[]" fieldNo="<?php echo $cnt; ?>" class="textBoxExpnd" value="<?php echo $prescriptions['PharmacyItemRate'][0]['stock']; ?>" readonly="true" />
                            <input type="hidden" id="looseStockQty<?php echo $cnt; ?>" class="textBoxExpnd" value="<?php echo $prescriptions['PharmacyItemRate'][0]['loose_stock']; ?>" readonly="true" /></td>
                    <!-- </tr>
                </table>
            </td> -->
            <?php } ?>

            <td valign="middle" style="text-align: center;">
                <input name="expiry_date[]" type="text" class="validate[future[NOW]] textBoxExpnd expiry_date" id="expiry_date<?php echo $cnt; ?>" 
                       style="width: 70%;" <?php echo $disabled; ?> autocomplete="off"  
                       value="<?php echo $this->DateFormat->formatDate2Local($prescriptions['PharmacyItemRate'][0]['expiry_date'], Configure::read('date_format')); ?>" fieldNo="<?php echo $cnt; ?>"/>
            </td> 

            <!-- MRP & Sale Price for SalesBill Edit & DirectSale Edit-->
        <?php if ((!empty($requisitionType) && $requisitionType == "edit") || (!empty($requisitionType) && $requisitionType == "editDirectView")) { ?>
                <td valign="middle" style="text-align: right;">
                <span id="showMrp_<?php echo $cnt; ?>" class="showMrp"><?php echo $pharmaSaleMrpDisplay; ?></span>
                <input name="mrp[]" autocomplete="off"
                                                                       type="hidden" class="textBoxExpnd validate[required,number] mrp"  fieldNo="<?php echo $cnt; ?>" id="mrp<?php echo $cnt ?>"
                                                                       value="<?php echo $mrp = $pharmaSaleMrpDisplay; ?>" style="width: 100%;" readonly="true"/></td>

                <!-- Sale Price -->	
                <td valign="middle" style="text-align: right;">
                    <input name="rate[]" autocomplete="off" type="text" class="textBoxExpnd validate[required,number] rate" fieldNo="<?php echo $cnt; ?>" id="rate<?php echo $cnt ?>"
                           value="<?php echo $sale_price = $pharmaSalePriceDisplay; ?>" style="width: 100%;" readonly="true"/></td> 

                <!-- END for SalesBill Edit & DirectSale Edit -->
        <?php } else { ?>
                <!-- For Other requisitions - ot, mediction, nurse -->
                <!-- MRP -->
                <td valign="middle" style="text-align: right;">
                <span id="showMrp_<?php echo $cnt; ?>" class="showMrp"><?php echo $prescriptions['PharmacyItemRate'][0]['mrp']; ?></span>
                    <input name="mrp[]" autocomplete="off" type="hidden" class="textBoxExpnd validate[required,number] mrp"  fieldNo="<?php echo $cnt; ?>" id="mrp<?php echo $cnt ?>"
                           value="<?php echo $mrp = $prescriptions['PharmacyItemRate'][0]['mrp']; ?>" style="width: 100%;" readonly="true"/>
                </td>

                <!-- vat for Kanpur -->	  
                    <?php if ($websiteConfig['instance'] == 'kanpur') { ?> 
                    <td valign="middle" style="text-align: center;"><input name="vat_class_name[]" readonly="readonly" type="text" class="textBoxExpnd" id="vat_class_name<?php echo $cnt ?>"
                                                                           value="<?php echo $prescriptions['PharmacyItemRate'][0]['vat_class_name']; ?>" style="width: 90%;" /><input name="vat[]" type="hidden" class="textBoxExpnd" id="vat<?php echo $cnt ?>" 
                                                                           fieldNo="<?php echo $cnt; ?>" value="<?php echo $prescriptions['PharmacyItemRate'][0]['vat_sat_sum']; ?>" style="width: 90%;" readonly="true" />
                    </td>
                    <?php } ?>	

                <!-- SalePrice for Others requisituions -->
                <td valign="middle" style="text-align: right;">
                <span id="showRate_<?php echo $cnt; ?>" class="showRate"><?php echo $prescriptions['PharmacyItemRate'][0]['sale_price']; ?></span>
                <input name="rate[]" autocomplete="off" 
                                                                       type="hidden" class="textBoxExpnd validate[required,number] rate" fieldNo="<?php echo $cnt; ?>"  id="rate<?php echo $cnt ?>"
                                                                       value="<?php echo $sale_price = $prescriptions['PharmacyItemRate'][0]['sale_price']; ?>" style="width: 100%;" readonly="true"/></td> 

        <?php } ?>


            <td valign="middle" style="text-align: right;">
                <!-- For Other Requisition Tablet wise caculation -->
        <?php
        if ($pharmaItemType[$prescriptions['PharmacyItem']['id']] == "Tab") {
            $totalAmount = ($pharmaSalePriceDisplay / $pharmaPack[$prescriptions['PharmacyItem']['id']]) * $pharmaSaleQty;
            $totalAmt = number_format($totalAmount, 2) . "";
        }
        ?>		
                <!-- Toatal Amount Field -->
                <span id="showValue_<?php echo $cnt; ?>" class="showValue"><?php echo round($totalAmount, 2); ?></span>
                <input name="value[]" readonly="readonly" type="hidden" class="textBoxExpnd validate[required,number] value" autocomplete="off"
                       id="value<?php echo $cnt ?>" fieldNo="<?php echo $cnt; ?>" value="<?php echo round($totalAmount, 2); ?>" style="width: 100%;" readonly="true"/>

            </td>  

            <!-- Delete Row -->
            <td valign="middle" style="text-align: center;">
                <a   href="javascript:void(0);"   onclick="deletRow('<?php echo $cnt ?>','<?php echo $prescriptions['PharmacyItem']['id']; ?>');" >
        <?php echo $this->Html->image("icons/cross.png", array("alt" => "Remove Row", "title" => "Remove Item",'style'=>'float:none !important' ,'itemid' => $prescriptions['PharmacyItem']['id'])); ?>  </a>

            </td>
        </tr>

        <?php $cnt++;
    }
    ?>
    <input type="hidden" value="<?php echo $cnt - 1; ?>" id="no_of_fields" />
<?php } // END of loop ?>
<!-- deletedId Used to stroe deleted id on submit - For nurse Prescription  -->
<input name="deleted_id"  id="deletedId" class="deleteId" type="hidden"  value="" fieldNo="1" autocomplete="off" />
<!-- Dont place it n Nurse Condition -->
</table>
<!-- END of Other Requisition - Medication, ot, nurse, edit editDirectView - Starts At 332 -->

<div class="clr ht5"></div>
     <?php if (empty($requisitionType) || $requisitionType == 'copy' ) { ?>
    <div align="left">
        <input name="" type="button" value="Add More" class="blueBtn Add_more"onclick="addFields()" />
        <!--<input name="" type="button" value="Remove" id="remove-btn" class="blueBtn" onclick="removeRow()" style="display: none" />
        --></div>
    <?php
} else if (!empty($requisitionType)) {
    
}
?>

<div class="clr ht5"></div>


<table cellpadding="0" cellspacing="0" border="0" width="50%">
    <tr>  	
        <td>Total Amount :</td>
        <td><?php echo $this->Session->read('Currency.currency_symbol'); ?>&nbsp;
            <span id="total_amount">
            <?php echo number_format(round(!empty($editSales['PharmacySalesBill']['total']) ? $editSales['PharmacySalesBill']['total'] : $totalAmForEachMed, 2)); ?>
            </span>
            <input name="PharmacySalesBill[total]" id="total_amount_field" autocomplete='off'  value="<?php echo round(!empty($editSales['PharmacySalesBill']['total']) ? $editSales['PharmacySalesBill']['total'] : $totalAmForEachMed, 2); ?>" type="hidden" /> 
        </td>
    </tr> 
    <tr>
        <td>Net Amount :</td>
        <td><?php echo $this->Session->read('Currency.currency_symbol'); ?>&nbsp;
            <span id="net_amount"><?php echo number_format(round(!empty($editSales['PharmacySalesBill']['total']) ? $editSales['PharmacySalesBill']['total'] - $totalItemDiscount : $totalAmForEachMed - $totalItemDiscount, 2)); ?></span> 
        </td>		
    </tr> 
    <tr>
        <td><?php echo __("Payment Mode"); ?><font color="red" >*</font>
        </td>

        <td> <?php
        echo $this->Form->input('PharmacySalesBill.payment_mode', array('class' => 'validate[required]', 'style' => 'width:141px;', 'type' => 'select',
            'div' => false, 'label' => false, /* 'empty'=>__('Please select'), */'autocomplete' => 'off',
            'options' => $mode_of_payment, $disabled,
            'value' => !empty($editSales['PharmacySalesBill']['payment_mode']) ? $editSales['PharmacySalesBill']['payment_mode'] : "Credit", 'id' => 'payment_mode'));
            ?> 
        </td> 
    </tr> 
    <tr>
        <!--
<?php
if (!empty($editSales['PharmacySalesBill']['credit_period'])) {
    $style = "";
} else {
    $style = "display:none";
}
?>
                <tr id="creditDaysInfo" style="<?php echo $style; ?>">
                        <td height="35" class="tdLabel2"> 
                                Credit Period<font color="red">*</font><br /> (in days)</td>
                    <td>
<?php echo $this->Form->input('PharmacySalesBill.credit_period', array('type' => 'text', 'legend' => false, 'label' => false, 'id' => 'credit_period', "autocomplete" => 'off',
    'class' => 'validate[required]', 'value' => !empty($editSales['PharmacySalesBill']['credit_period']) ? $editSales['PharmacySalesBill']['credit_period'] : ''));
?>
                    </td>
                    <td class="tdLabel2"> &nbsp;</td>
             <td class="tdLabel2">	 <span>Guarantor :</span>
<?php
echo $this->Form->input('PharmacySalesBill.guarantor_id', array('empty' => 'Please select', 'id' => 'guarantor_id', "autocomplete" => 'off',
    'options' => $userName, 'value' => !empty($editSales['PharmacySalesBill']['guarantor_id']) ? $editSales['PharmacySalesBill']['guarantor_id'] : '', 'label' => false, 'style' => 'width:200px'));
?>
                     </td> 
           </tr> 
        -->
    <tr id="paymentInfoCreditCard" style="display:none">
        <td height="35" colspan="2" class="tdLabel2"> 
            <table width="100%" > 
                <tr>
                    <td>Bank Name</td>
                    <td><?php echo $this->Form->input('PharmacySalesBill.bank_name', array('type' => 'text', 'legend' => false, 'label' => false, 'id' => 'BN_paymentInfoCreditCard', "autocomplete" => 'off')); ?></td>
                </tr>
                <tr>
                    <td>Account No.</td>
                    <td><?php echo $this->Form->input('PharmacySalesBill.account_number', array('type' => 'text', 'legend' => false, 'label' => false, 'id' => 'AN_paymentInfoCreditCard', "autocomplete" => 'off')); ?></td>
                </tr>
                <tr>
                    <td>Cheque/Credit Card No.</td>
                    <td><?php echo $this->Form->input('PharmacySalesBill.credit_card_no', array('type' => 'text', 'legend' => false, 'label' => false, 'id' => 'card_check_number', "autocomplete" => 'off')); ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr id="neft-area" style="display:none;">
        <td height="35" colspan="2" class="tdLabel2"> 
            <table width="100%"> 
                <tr>
                    <td width="47%">Bank Name</td>
                    <td><?php echo $this->Form->input('PharmacySalesBill.bank_name', array('type' => 'text', 'legend' => false, 'label' => false, 'id' => 'BN_neftArea', "autocomplete" => 'off')); ?></td>
                </tr>
                <tr>
                    <td>Account No.</td>
                    <td><?php echo $this->Form->input('PharmacySalesBill.account_number', array('type' => 'text', 'legend' => false, 'label' => false, 'id' => 'AN_neftArea', "autocomplete" => 'off')); ?></td>
                </tr> 
                <tr>
                    <td>NEFT No.</td>
                    <td><?php echo $this->Form->input('PharmacySalesBill.neft_number', array('type' => 'text', 'legend' => false, 'label' => false, 'id' => 'neft_number', "autocomplete" => 'off')); ?></td>
                </tr>
                <tr>
                    <td>NEFT Date</td>
                    <td><?php echo $this->Form->input('PharmacySalesBill.neft_date', array('type' => 'text', 'legend' => false, 'label' => false, 'id' => 'neft_date', 'style' => 'width:150px;', "autocomplete" => 'off')); ?></td>
                </tr>
            </table>
        </td>
    </tr> 
    <tr> 	
        <td class="tdLabel2"></td>
        <td class="tdLabel2"></td>
        <td class="tdLabel2"></td>
        <td class="tdLabel2"></td>
        <td class="tdLabel2"></td>
    </tr>
    <tr>
        <td class="tdLabel2"></td>
        <td class="tdLabel2"></td>
        <td class="tdLabel2"></td>
        <td class="tdLabel2"></td>
        <td class="tdLabel2"></td>	


    </tr>
</table>
<div class="btns">
<?php if ($requisitionType == 'nurse') { ?>
        <input type='hidden' name='PharmacySalesBill[by_nurse]' value='1'>

    <?php echo $this->Form->submit(__('Submit'), array('class' => 'blueBtn', 'id' => 'submitButton', 'div' => false, 'label' => false)); ?>

<?php
} else if ($requisitionType == "editDirectView" || $requisitionType == "edit") {
    echo $this->Form->submit(__('Submit'), array('class' => 'blueBtn', 'div' => false, 'label' => false));
} else {
    ?>
        <input name="submit" type="submit" value="Submit" class="blueBtn"  id="submitButton"  /> 
<?php } ?>
<?php //echo $this->Html->link('submit','javascript:void(0)',array('onclick'=>'printSp("'.$patientId.'")', 'id'=>'submitButton','class'=>'blueBtn'));  ?>


    <br><br><br>

<?php if ($requisitionType != "nurse" && $requisitionType != "edit") { ?>
    <?php //echo $this->Html->link(__('Show patients'),'javascript:void(0)',array('name'=>"Show patients",'class'=>'blueBtn', 'id'=>'show_patients','escape'=>false));
    echo $this->Html->link(__('Hide patients'), 'javascript:void(0)', array('name' => "Hide patients", 'class' => 'blueBtn', 'id' => 'hide_patients', 'style' => "display:none", 'escape' => false));
    ?>
<?php } ?>

</div>
<?php //debug($this->Form); ?>
<?php echo $this->Form->end(); ?>
<div id="iframeDisplay" style="width: 100%; margin-top: 100px; height: auto ;display: none"></div>

<?php
/*  $referral = $this->request->referer();			
  if(isset($this->params->query['print']) && !empty($_GET['id'])  && ($referral != '/' )){
  echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'Pharmacy','action'=>'inventory_print_view','PharmacySalesBill',$_GET['id'],'?'=>"flag=header"))."', '_blank',
  'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;

  } */
?>
<script>
    var validate = false;
    var privateId = parseInt("<?php echo $privateId; ?>");
    var curTotal = "";
    var roomType = '';
    $(document).ready(function(){ 
	 
        var print="<?php echo isset($this->params->query['print']) ? $this->params->query['print'] : '' ?>";
        var referral = "<?php echo $referral; ?>" ;
	 
        if(print && referral != '/' && $("#formReferral").val()=='' ){
            $("#formReferral").val('yes') ;
            var url="<?php echo $this->Html->url(array('controller' => 'Pharmacy', 'action' => 'inventory_print_view', 'PharmacySalesBill', $_GET['id'], '?' => "flag=header")); ?>";
            window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready

        }		
        if ($("#isDiscount").attr('checked')) {
            $("#showDiscount").show();
        }
        if($("#payment_mode").val() == 'Credit Card' || $("#payment_mode").val() == 'Cheque'){
		 
            $("#paymentInfoCreditCard").show();
            $("#creditDaysInfo").hide();
            $('#neft-area').hide();
            $('#balance_card').hide()
            $("#card_pay").attr("checked",false);
            //$("#card_pay").attr("disabled",true);
            $("#patientCard").hide();	
            $('#patientCardDetails').hide();
        } 
        else if($('#payment_mode').val() =='NEFT') {
            $('#neft-area').show();
            $("#creditDaysInfo").hide();
            $("#paymentInfoCreditCard").hide();
        }
        else if($('payment_mode').val() == 'Credit'){
            $('#neft-area').hide();
            $("#creditDaysInfo").show();
            $("#paymentInfoCreditCard").hide();
            $("#card_pay").attr("checked",false);
            //$("#card_pay").attr("disabled",true);
            $("#patientCard").hide();
            $('#balance_card').hide()	
            $('#patientCardDetails').hide();
        }
 
        //EOF payment laod
        $('#payment_mode').change(function(){
            $("#showDiscountDetails").hide();
            if($("#payment_mode").val() == 'Credit Card' || $("#payment_mode").val() == 'Cheque'){
                $("#paymentInfoCreditCard").show();
                $("#creditDaysInfo").hide();
                $("#neft-area").hide();
                $("#card_pay").attr("checked",false);
                //$("#card_pay").attr("disabled",true);
                $("#patientCard").hide();	
                $('#balance_card').hide()
                $('#patientCardDetails').hide();
            } 
            else if($("#payment_mode").val() == 'Cash' && webInstance != "vadodara"){
                $("#showDiscountDetails").show();
                $("#paymentInfoCreditCard").hide();
                $("#creditDaysInfo").hide();
                $("#neft-area").hide();
            }
            else if($("#payment_mode").val() == 'NEFT'){
                $("#paymentInfoCreditCard").hide();
                $("#creditDaysInfo").hide();
                $("#neft-area").show();
            }
            else if($("#payment_mode").val() == 'Credit'  && webInstance != "vadodara"){
                $("#showDiscountDetails").show();
                $("#isDiscount").attr('checked', false);
                $("#inputDiscount").val('');
                $("#discount").val('');
                $("#showDiscount").hide();
                $("#card_pay").attr("checked",false);
                //$("#card_pay").attr("disabled",true);
                $("#patientCard").hide();	
                $('#balance_card').hide()
                $('#patientCardDetails').hide();
                calculateDiscount();
                $("#paymentInfoCreditCard").hide();
                $("#creditDaysInfo").show();
                $("#neft-area").hide();
            }else{
                $("#creditDaysInfo").hide();
                $("#paymentInfoCreditCard").hide();
                $('#neft-area').hide();
            }
        });

        $("#BN_paymentInfoCreditCard").on('keyup change blur',function(){
            $("#BN_neftArea").val($(this).val());
        });

        $("#AN_paymentInfoCreditCard").on('keyup change blur',function(){
            $("#AN_neftArea").val($(this).val());
        });
	
        $("#card_check_number").on('keyup change blur',function(){
            $("#card_neftArea").val($(this).val());
        });
        // End of code
	
        /**
         * function to fetch prescribed mediaction
         */
        function getPatientPrescriptionDetails1(patientId){
            var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "getPrescribedDetail", "inventory" => false, "plugin" => false)); ?>"+"/"+patientId;
            $.ajax({
                type: "GET",
                url: ajaxUrl,
                success : function(data){
                    var obj = jQuery.parseJSON( data );
                }
            })
        }
        if("<?php echo $this->params['pass'][1]; ?>" == 'editDirectView' || "<?php echo $this->params['pass'][1]; ?>" == 'copy'){
            $( ".expiry_date" ).datepicker({
                showOn: "both",
                buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                buttonImageOnly: true,
                changeMonth: true,
                changeYear: true,
                yearRange: '1950',			 
                dateFormat:'<?php echo $this->General->GeneralDate(""); ?>',
		    
            });
        }


        $(document).ready(function() {
            //by Swapnil G.Sharma
            $(document).on('keyup',".quantity",function() {
                if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
                checkStockLimit(this);
                getTotal(this);
            });

            $(document).on('keyup',".mrp",function() {
                if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
                checkStockLimit(this);
                getTotal(this);
            });

            $(document).on('keyup',".rate",function() {
                if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,'');  }
                checkStockLimit(this);
                getTotal(this);
            });

            $(document).on('keyup',"#tax",function() { 
                if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,'');  }
            });

            $(document).on('keyup',"#vat",function() {
                if (/[^0-9\.]/g.test(this.value)){  this.value = this.value.replace(/[^0-9\.]/g,'');  }
                checkStockLimit(this);
                getTotal(this);
            });

            $(document).on('keyup',".itemWiseDiscountAmount",function() {
                if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
                getTotalFromDiscount(this);
            });
  
            $(document).on('change',".itemType",function(){
                checkStockLimit(this);
                getTotal(this);
            });

            $(document).on('keyup',".quantity",function() {
                var ID = $(this).attr('itemID'); 
                var qty = $(this).val(); 
                if($("#changedQty").val() != '' ){
                    $("#changedQty").val($("#changedQty").val()+","+ID+"."+qty) ;
                }else{
                    $("#changedQty").val(ID+"."+qty); 
                }
            });
            isInStock=new Array();  			// variable for check the item is in stock or not.
            itemAutoComplete("item_name-1");	//for initial autocomplete

            $("#party_name").focus(function(){
                $(this).autocomplete({
                    source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail", "lookup_name", "saleBill", "inventory" => true, "plugin" => false)); ?>"+"/"+$("#is_checked").val(),
                    minLength: 1, 
                    select: function( event, ui ) { 
                        var party_code = ui.item.party_code;
                        var patient_id = ui.item.id;
                        var admission_type = ui.item.admission_type;
                        var tariff_id = ui.item.tariff_id;
                        var tariff_name = ui.item.tariff_name;
                        roomType = ui.item.room_type;
                        $("#party_code").val(party_code);
                        $("#party_code").val(party_code);
                        $("#person_id").val(patient_id);
                        $("#admission_type").val(admission_type);
                        $("#tariff_id").val(tariff_id);
                        $("#roomType").val(roomType);
                        $("#tariff").html("("+tariff_name+")"+" - "+admission_type);
                        getDoctorName(patient_id);//call for doctor name
                        checkMode();
                    },
                    messages: {
                        noResults: '',
                        results: function() {}
                    }	
                }); 
            });
        });
        function checkMode(){    
            var admissionType = $("#admission_type").val();
            var tariffId = parseInt($("#tariff_id").val());  

            if(webInstance =="vadodara"){		 
                if(admissionType != "IPD" && tariffId != privateId){
                    //if non ipd and corporate
                    var mode = $.parseJSON('<?php echo json_encode($mode_of_payment); ?>');
                    $("#payment_mode option").remove();
                    $.each(mode, function(id,value){
                        $("#payment_mode").append( "<option value='"+id+"'>"+value+"</option>" ); 
                    }); 
                    $("#showDiscountDetails").hide();
                    $("#isDiscount").attr('checked', false);
                    $("#inputDiscount").val('');
                    $("#discount").val('');
                    $("#showDiscount").hide();
                }else if(admissionType != "IPD" && tariffId == privateId){
                    //non ipd and private
                    $('#payment_mode option[value=Cash]').attr('selected','selected');
                }else{
                    //if ipd patient
                    var mode = $.parseJSON('<?php echo json_encode($mode_of_payment); ?>');
                    $("#payment_mode option").remove();
                    $.each(mode, function(id,value){
                        $("#payment_mode").append( "<option value='"+id+"'>"+value+"</option>" ); 
                    }); 
                    $("#showDiscountDetails").hide();
                    $("#isDiscount").attr('checked', false);
                    $("#inputDiscount").val('');
                    $("#discount").val('');
                    $("#showDiscount").hide();
                }
            }
        }
	
        /*
        function checkMode(){
                var mode = $.parseJSON('<?php echo json_encode($mode_of_payment); ?>');
                var admissionType = $("#admission_type").val();
                var tariffId = parseInt($("#tariff_id").val());
                if(tariffId == privateId){	  //private patient 
                        if(admissionType == "OPD" && webInstance =="vadodara"){		//if OPD remove Cash
                                $('#payment_mode option[value=Cash]').attr('selected','selected');
                                $('#payment_mode option').each(function() {
                                    if ($(this).val() == 'Credit' ) {
                                        $(this).remove();
                                    }
                                });
                        }else if(admissionType == "IPD" && webInstance =="vadodara"){		//if IPD both
                                $('#payment_mode option[value=Credit]').attr('selected','selected');
                                $("#payment_mode option").remove();
                                $.each(mode, function(id,value){
                                        $("#payment_mode").append( "<option value='"+id+"'>"+value+"</option>" ); 
                                });
                        }
                }else{ 
                        if(admissionType == "OPD" && webInstance =="vadodara"){		//if OPD remove Cash
                                $('#payment_mode option[value=Credit]').attr('selected','selected');
                        }else if(admissionType == "IPD" && webInstance =="vadodara"){		//if IPD both
                                $('#payment_mode option[value=Cash]').attr('selected','selected');
                        }
                }	
        }
         */
	
        // Credit card 
        $(".item_code").on('focus',function()
        {
            var t = $(this);
            $(this).autocomplete({
                source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "autocomplete_item", "item_code", "inventory" => true, "plugin" => false)); ?>",
                select:function( event, ui ) {
                    //console.log(ui.item);
                    selectedId = t.attr('id');
                    loadDataFromRate(ui.item.id,selectedId);
                },
                messages: {
                    noResults: '',
                    results: function() {}
                }	
            });
        });

        $("#doctor_name").on('focus',function()
        {
            var t = $(this);
            $(this).autocomplete({
                source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceTwoFieldsAutocomplete", "DoctorProfile", 'user_id', "doctor_name", 'is_active=1', 'null', "admin" => false, "plugin" => false)); ?>",
                select:function( event, ui ) {
                    $("#doctor_id").val(ui.item.id);
                },
                messages: {
                    noResults: '',
                    results: function() {}
                }
            });
        });

        $("#party_code").on('focus',function()
        {
            var t = $(this);
            $("#ss").hide();
            $(this).autocomplete(
            "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail", "admission_id", "inventory" => true, "plugin" => false)); ?>",
            {
                matchSubset:1,
                matchContains:1,
                cacheLength:10,
                onItemSelect:function (li) {
                    if( li == null ) return alert("No match!");
                    var person_id = li.extra[0];
                    $("#person_id").val(person_id);
                    party_name = li.extra[1] ;
                    $("#party_name").val(party_name.split("-")[0]);
                    var link = '<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_credit_detail", "plugin" => false)); ?>/'+person_id;
                    $("#ss").attr("href",link);
                    $("#ss").show();
                    //$("#credit-link-container").append(link);
                    //function to fetch dr name from selected patient name 
                    getDoctorName(person_id);
                },
                autoFill:false
            });
        });

	
        //function to set doctor name from patient selection 
        function getDoctorName(patient_id){
            if(patient_id=='') return false ;
            $.ajax({
                type: "GET",
                url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_fetch_patient_doctor_name", "inventory" => true, "plugin" => false)); ?>",
                data: "patient="+patient_id,
                success: function(data){
                    if(data != ''){
                        var item = $.parseJSON(data);
                        $("#doctor_id").val(item.id);
                        $("#doctor_name").val(item.name);
                        $("#item_name-1").focus();
                    }
                }
            });
        }

        function openCreditDetail(person_id){
            window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_credit_detail", "plugin" => false)); ?>/'+person_id,'','width=500,height=150,location=0,scrollbars=no');
        }
    });

    //function for all autocomplete
    function itemAutoComplete(id){ 
		
        $(".item_name").autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "autocomplete_item", 'name', "inventory" => true, "plugin" => false)); ?>",
            minLength: 1,
            select: function( event, ui ) { 
                var selectedId = ($(this).attr('id'));
                loadDataFromRate(ui.item.id,selectedId);
				
            },
            messages: {
                noResults: '',
                results: function() {}
            }		
        });
    }

    $(document).on('change',".batch_number",function()
    {
        var isnurse = "<?php echo $requisitionType; ?>";
        var t = $(this);
        var fieldno = t.attr('fieldno') ;
        loading(fieldno);
        $.ajax({
            type: "GET",
            url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_fetch_batch_for_item", "inventory" => true, "plugin" => false)); ?>",
            data: "itemRate="+$(this).val(),
            success: function(data){
                var ItemDetail = jQuery.parseJSON(data);
                var stock = parseInt(ItemDetail.PharmacyItemRate.stock);
                var looseStock = parseInt(ItemDetail.PharmacyItemRate.loose_stock);
                var pack = parseInt(ItemDetail.PharmacyItem.pack);
                var myStock = (stock * pack) + looseStock;
                $("#qty_"+fieldno).val('');
               // if(isnurse != 'nurse'){  
                    $("#stockWithLoose_"+fieldno).val(myStock);
                    $("#stockQty"+fieldno).val(ItemDetail.PharmacyItemRate.stock);
                    $("#showStock_"+fieldno).html(myStock);
                    $("#looseStockQty"+fieldno).val(ItemDetail.PharmacyItemRate.loose_stock);
                //}
                
                $("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
                $("#showMrp_"+fieldno).html(parseFloat(ItemDetail.PharmacyItemRate.mrp).toFixed(2));
                $("#vat_class_name"+fieldno).val(ItemDetail.PharmacyItemRate.vat_class_name);
                $("#vat"+fieldno).val(ItemDetail.PharmacyItemRate.vat_sat_sum);
                $("#rate"+fieldno).val(ItemDetail.PharmacyItemRate.sale_price);
                $("#showRate_"+fieldno).html(parseFloat(ItemDetail.PharmacyItemRate.sale_price).toFixed(2));
                $("#expiry_date"+fieldno).val(ItemDetail.PharmacyItemRate.expiry_date);
                var itemrateid=$('#batch_number'+fieldno).val();
                var itemID=$('#item_id'+fieldno).val();
                var editUrl  = "<?php echo $this->Html->url(array('controller' => 'pharmacy', 'action' => 'edit_item_rate', 'inventory' => false)) ?>";
                $("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
                getTotal(t);
                onCompleteRequest(fieldno);
            }
        });
        //getTotal(this);
    });

    /*$( "#expiry_date1" ).datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',			 
        dateFormat:'<?php echo $this->General->GeneralDate(""); ?>',
    
});*/

    $( "#sale_date" ).datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',			 
        dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS"); ?>',
    });

      $( "#copy_date" ).datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',           
        dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS"); ?>',
        minDate: new Date(),
    });

    $(".Add_more").click(function()
    {
        $( ".expiry_date" ).datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1950',			 
            dateFormat:'<?php echo $this->General->GeneralDate(""); ?>',
	    
        });
    });

    $(".item_name").focus(function(){
        if($("#person_id").val()=="")
        { 
            alert("Please Select Patient First.");
            $("#party_name").focus();
        }
    });

    function addFields(){ 
        if($("#person_id").val()=="")
        { 
            alert("Please Select Patient First.");
            $("#party_name").focus();
            return false;
        }
        var number_of_field = parseInt($("#no_of_fields").val())+1;
        var clas = "";
        if(number_of_field %2 != 0){
            clas = "row_gray";
        }else{
            clas = "blue-row";
        }
			
        $(".formError").remove();
        var field = '';
        field += '<tr id="row'+number_of_field+'" class="ho '+clas+'">';
        field += '<td align="center" valign="middle"><input name="item_code[]" id="item_code-'+number_of_field+'" type="text" autocomplete="off" class="textBoxExpnd  item_code" value="" style="width:100%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input class="itemId" name="data[item_id][]" id="item_id'+number_of_field+'" type="hidden" value="" fieldNo="'+number_of_field+'"/></td>';
        field += '<td align="center" valign="middle" style="padding:0px;"> <table width="100%"> <tr> <td style="padding:0px;"> <input name="item_name[]" autocomplete="off" id="item_name-'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_name"  value="" style="width:95%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/></td><td style="padding:0px;"> <input type="hidden" name="genericName" id="genericName'+number_of_field+'" class="genericName" value="" fieldNo="'+number_of_field+'"/> <a href="javascript:void(0);" style="padding: 0px;" id="Generic" onclick="showGeneric('+number_of_field+');"><?php echo $this->Html->image('icons/generic.png', array('title' => 'Generic', 'alt' => 'Generic', 'class' => 'showGeneric')); ?></a></td></tr></table></td>';
        field += '<td style="text-align:center;"> <input name="qty[]" readonly="readonly" type="text" autocomplete="off" class="textBoxExpnd quantity validate[required,number]"  value="" id="qty_'+number_of_field+'" style="" fieldNo="'+number_of_field+'"/> <input type="hidden" value="0" id="stockQtys'+number_of_field+'"><input type="hidden" id="itemType_'+number_of_field+'" fieldno="'+number_of_field+'" value="Tab" name="itemType[]" /> </td>';
        //field += '<td align="center" valign="middle"><input name="manufacturer[]" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"   value=""  style="width:100%;" autocomplete="off" readonly="true"/></td>';
        field += '<td align="center" valign="middle"><span class="showPack" id="showPack_'+number_of_field+'"></span><input name="pack[]" id="pack'+number_of_field+'" type="hidden" value="" style="width:50px" readonly="true" autocomplete="off"/></td>';
	   	
	   	field += '<td align="center" valign="middle"><select name="data[administration_time][]" id="administrationTime'+number_of_field+'" class="textBoxExpnd " value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"><option value="">Please Select</option></select></td>';

        field += '<td align="center" valign="middle"><select name="data[pharmacyItemId][]" id="batch_number'+number_of_field+'" class="textBoxExpnd validate[required] batch_number" value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"></select></td>';
        field += '<td valign="middle" style="text-align: center;"><span class="showStock" id="showStock_'+number_of_field+'"></span><input name="stockWithLoose[]" id="stockWithLoose_'+number_of_field+'" class="textBoxExpnd" type="hidden"  value="0" fieldNo="'+number_of_field+'" readonly="true"/> <input type="hidden" class="textBoxExpnd" id="stockQty'+number_of_field+'" value="0" autocomplete="off" readonly="true" /><input type="hidden" id="looseStockQty'+number_of_field+'" class="textBoxExpnd" value="0" readonly="true" /></td>';
       
        field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[future[NOW]] expiry_date" value=""  style="width:70%;" autocomplete="off"/></td>';

        field += '<td valign="middle" style="text-align:right;"><span class="showMrp" id="showMrp_'+number_of_field+'"></span><input name="mrp[]" type="hidden" class="textBoxExpnd mrp validate[required,number]"  fieldNo="'+number_of_field+'" value="" id="mrp'+number_of_field+'" style="width:100%;" autocomplete="off" readonly="true"/></td>';
	    
        field += '<td valign="middle" style="text-align:right;"><span class="showRate" id="showRate_'+number_of_field+'"></span><input name="rate[]" fieldNo="'+number_of_field+'" type="hidden" class="textBoxExpnd validate[required,number] rate" value="" id="rate'+number_of_field+'" style="width:100%;" autocomplete="off" readonly="true"/></td>';
  
        field += ' <td valign="middle" style="text-align:right;"><span class="showValue" id="showValue_'+number_of_field+'"></span><input name="value[]" readonly="readonly" type="hidden" class="textBoxExpnd  validate[required,number] value" id="value'+number_of_field+'" value=""  style="width:100%;" autocomplete="off"/></td> ';

        field += '<td valign="middle" style="text-align:right;"> <a href="javascript:void(0);" id="delete row" onclick="deletRow('+number_of_field+');"> <?php echo $this->Html->image("icons/cross.png", array("alt" => "Remove Row","style"=>"float:none !important" ,"title" => "Remove Item")); ?></a></td>';
        field += '</tr>';
        $("#no_of_fields").val(number_of_field);
        $("#item-row").append(field);
        if (parseInt($("#no_of_fields").val()) == 1){
            $("#remove-btn").css("display","none");
        }else{
            $("#remove-btn").css("display","inline");
        }
		
		var admisnitrationTList = <?php echo json_encode(Configure::read('administration_time'));?>;
   		$.each(admisnitrationTList, function (key, value) {
   			$('#administrationTime'+number_of_field).append( new Option(value, key) );
		});

        //bind autocomplete
        itemAutoComplete("item_name-"+number_of_field);
        $("#item_name-"+number_of_field).focus();
    }

    /* get the detail of prescription of patient - It is not in use*/
    function getPatientPrescription1(uid,id,model){
        //alert(' uid='+uid+', id='+id+', model='+model);
        isInStock=new Array();
        var q="uid="+uid;
        var number_of_field = 1;

        return true ;  //by pankaj 
        if(id)
            q+="&id="+id+"&model="+model;
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "get_prescribed_detail", "inventory" => false, "plugin" => false)); ?>",
            data: q, 
            // debug(q);
        }).done(function( msg ) {
            var prescription = jQuery.parseJSON(msg);
            var modelName="";
            var refrredBy="";
            if(prescription[1].NewCropPrescription){
                modelName=prescription[1].NewCropPrescription;
                refrredBy = prescription[1].Doctor;
            }else{
                modelName=prescription[1].DiagnosisDrug;
                refrredBy = prescription[1].Doctor;
            }
            $("#party_code").val(prescription[0].Patient.admission_id);
            $("#party_name").val(prescription[0].Patient.lookup_name);
            $("#person_id").val(prescription[0].Patient.id);
            if(prescription[1] == false || modelName.length==0){
                $("#item-row").find("tr:gt(0)").remove();

                var field = '';
                field += '<tr id="row'+number_of_field+'">';
                field += '<td align="center" valign="middle"><input name="item_code[]" id="item_code-'+number_of_field+'" type="text" class="textBoxExpnd" autocomplete="off" value="" style="width:80%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="data[item_id][]" id="item_id'+number_of_field+'" type="hidden" fieldNo="'+number_of_field+'" value="" class="itemId"/></td>';

                field += '<td align="center" valign="middle"><input name="item_name[]" id="item_name-'+number_of_field+'" type="text" class="textBoxExpnd item_name"   autocomplete="off" value="" style="width:80%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/></td>';
                field += '<td align="center" valign="middle"><input name="manufacturer[]" readonly="true" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"  value=""  style="width:80%;" autocomplete="off"/></td>';
                field += '<td align="center" valign="middle"><input name="pack[]" id="pack'+number_of_field+'" type="text" class="textBoxExpnd " value=""  style="width:80%;" readonly="true" autocomplete="off"/></td>';

                field += '<td align="center" valign="middle"><input name="data[pharmacyItemId][]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required] batch_number" value=""  style="width:80%;" autocomplete="off" fieldNo="'+number_of_field+'"/></td>';
           		
                field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[future[NOW]] expiry_date" value=""  style="width:70%;" autocomplete="off"/></td>';

                field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd mrp" fieldNo="'+number_of_field+'" value="" id="mrp'+number_of_field+'" style="width:80%;" readonly="true" autocomplete="off"/></td>';
		   		

                field += ' <td valign="middle" style="text-align:center;"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required,number]" autocomplete="off" value="" id="qty_'+number_of_field+'" style="width:90%;" fieldNo="'+number_of_field+'"/><input type="hidden" value="0" id="stockQty'+number_of_field+'" ></td>';
                field += '<td valign="middle" style="text-align:center;"><input name="rate[]" type="text" class="textBoxExpnd rate " fieldNo="'+number_of_field+'" value="" id="rate'+number_of_field+'" style="width:80%;"  autocomplete="off" readonly="true" /></td>';

                field += ' <td valign="middle" style="text-align:center;"><input name="value[]" readonly="readonly" type="text" class="textBoxExpnd  validate[required,number] value" id="value'+number_of_field+'" value=""  autocomplete="off" style="width:80%;"/></td> </tr>    ';

                $("#item-row").append(field);
            }else{

                $("#item-row").find("tr:gt(0)").remove();
                $("#doctor_name").val(refrredBy.first_name+" "+refrredBy.last_name);
                $("#doctor_id").val(refrredBy.id);
                var totalAmount = 0;
                $.each(modelName, function() { 
                    var field = '';
                    itemDetail = getItemDetail(this.drug_id);

                    if(itemDetail){
                        field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
                        if(itemDetail.PharmacyItem.item_code!=null){
                            field += '<td align="center" valign="middle"><input name="item_code[]" readonly id="item_code-'+number_of_field+'" type="text" class="textBoxExpnd" value="'+itemDetail.PharmacyItem.item_code+'" autocomplete="off" style="width:80%;" fieldNo="'+number_of_field+'"/><input name="data[item_id][]" id="item_id'+number_of_field+'" type="hidden" value="'+itemDetail.PharmacyItem.id+'" fieldNo="'+number_of_field+'" class="itemId"/></td>';

                        }else{
                            field += '<td align="center" valign="middle"><input name="item_code[]" autocomplete="off" readonly id="item_code-'+number_of_field+'" type="text" class="textBoxExpnd"  value="" style="width:80%;" fieldNo="'+number_of_field+'"/><input name="data[item_id][]" class="itemId" id="item_id'+number_of_field+'" type="hidden" value="'+itemDetail.PharmacyItem.id+'" fieldNo="'+number_of_field+'"/></td>';
                        }
                        field += '<td align="center" valign="middle"><input name="item_name[]" autocomplete="off" readonly id="item_name-'+number_of_field+'" type="text" class="textBoxExpnd item_name"  value="'+itemDetail.PharmacyItem.name+'" style="width:80%;" fieldNo="'+number_of_field+'" readonly="true"/></td>';
                        itemDetail.PharmacyItem.manufacturer = (itemDetail.PharmacyItem.manufacturer === undefined || itemDetail.PharmacyItem.manufacturer === null) ? '' : itemDetail.PharmacyItem.manufacturer;
                        field += '<td align="center" valign="middle"><input name="manufacturer[]" readonly id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"  value="'+itemDetail.PharmacyItem.manufacturer+'" style="width:80%;" autocomplete="off" readonly="true"/></td>';
                        field += '<td align="center" valign="middle"><input name="pack[]" readonly autocomplete="off" id="pack'+number_of_field+'" type="text" class="textBoxExpnd "  value="'+itemDetail.PharmacyItem.pack+'"  style="width:80%;" readonly="true"/></td>';
                        itemDetail.PharmacyItemRate.batch_number = (itemDetail.PharmacyItemRate.batch_number === undefined || itemDetail.PharmacyItemRate.batch_number === null) ? '' : itemDetail.PharmacyItemRate.batch_number;
                        field += '<td align="center" valign="middle"><input name="batch_no[]"  id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required] batch_number" value="'+itemDetail.PharmacyItemRate.batch_number+'"  style="width:80%;" autocomplete="off" fieldNo="'+number_of_field+'"/></td>';
                        itemDetail.PharmacyItemRate.expiry_date = (itemDetail.PharmacyItemRate.expiry_date === undefined || itemDetail.PharmacyItemRate.expiry_date === null) ? '' : itemDetail.PharmacyItemRate.expiry_date;
                        field += '<td align="center" valign="middle"><input name="expiry_date[]" readonly id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[future[NOW]] expiry_date" value="'+itemDetail.PharmacyItemRate.expiry_date+'"  style="width:70%;" autocomplete="off" readonly="true" /></td>';
                        if(itemDetail.PharmacyItemRate.mrp!=null){
                            field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" readonly type="text" class="textBoxExpnd mrp" fieldNo="'+number_of_field+'" value="'+itemDetail.PharmacyItemRate.mrp+'" id="mrp'+number_of_field+'" style="width:80%;" readonly="true" autocomplete="off"/></td>';
                        }else{
                            field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd validate[required,number] mrp" fieldNo="'+number_of_field+'" value="" id="mrp'+number_of_field+'" style="width:80%;background-color:#254117;" onblur="" autocomplete="off" readonly="true"/></td>';
                            field += '<input type="hidden" name="notInItemRate[mrp]['+number_of_field+']" value="'+itemDetail.PharmacyItem.id+'" id="notInItemRateMrp'+number_of_field+'" readonly="true">';
                        }


                        itemDetail.PharmacyItem.row = number_of_field;
                        if(itemDetail.PharmacyItem.stock <= 0 || itemDetail.PharmacyItem.stock==null){
                            field += ' <td valign="middle" style="text-align:center;" width="100"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required,number]" value="'+this.quantity+'" id="qty_'+number_of_field+'" style="width:50%;" autocomplete="off" fieldNo="'+number_of_field+'"/><input type="hidden" value="0" id="stockQty'+number_of_field+'">';
                            field += '&nbsp;<a href="#" ><img title="Quantity for '+itemDetail.PharmacyItem.name+' not in stock." alt="" src="../../img/icons/inactive.jpg" style="cursor:help;"></a>';
                            isInStock.push(itemDetail.PharmacyItem);

                            $("#qty_"+number_of_field).val("0");
                        }
                        else if(parseInt(this.quantity) > itemDetail.PharmacyItem.stock){
                            field += ' <td valign="middle" style="text-align:center;" width="100"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required,number]" value="'+this.quantity+'" id="qty_'+number_of_field+'" style="width:50%;" autocomplete="off" fieldNo="'+number_of_field+'"/><input type="hidden" value="'+itemDetail.PharmacyItem.stock+'" id="stockQty'+number_of_field+'">';
                            field += '&nbsp;<a href="#" ><img title="'+itemDetail.PharmacyItem.stock+' unit in stock, Quantity must be less than '+itemDetail.PharmacyItem.stock+'" alt="" src="../../img/icons/inactive.jpg" style="cursor:help;"></a>';
                            isInStock.push(itemDetail.PharmacyItem);

                            $("#qty_"+number_of_field).val("0");
                        }
                        else{
                            field += ' <td valign="middle" style="text-align:center;" width="100"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required,number]" value="'+this.quantity+'" id="qty_+'+number_of_field+'" autocomplete="off" style="width:50%;" fieldNo="'+number_of_field+'"/><input type="hidden" value="'+itemDetail.PharmacyItem.stock+'" id="stockQty'+number_of_field+'">';
                            field += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

                        }
                        field += ' </td>';

                        if(itemDetail.PharmacyItemRate.sale_price!=null){
                            field += '<td valign="middle" style="text-align:center;"><input name="rate[]" fieldNo="'+number_of_field+'" type="text" class="textBoxExpnd rate" value="'+itemDetail.PharmacyItemRate.sale_price+'" id="rate'+number_of_field+'" autocomplete="off" style="width:80%;" readonly="true" /></td>';
                        }else{
                            field += '<td valign="middle" style="text-align:center;"><input name="rate[]" fieldNo="'+number_of_field+'" type="text" class="textBoxExpnd rate validate[required,number]"  value="" id="rate'+number_of_field+'" autocomplete="off" style="width:80%;background-color:#254117;" onblur=""  /></td>';
                            field += '<input type="hidden" name="notInItemRate[rate]['+number_of_field+']" value="'+itemDetail.PharmacyItem.id+'" id="notInItemRateRate'+number_of_field+'">';
                        }
                        var amount = '';
                        amount = (this.quantity != '' && itemDetail.PharmacyItemRate.mrp != '') ? (parseInt(this.quantity) * parseInt(itemDetail.PharmacyItemRate.mrp)) : '';
                        field += ' <td valign="middle" style="text-align:center;"><input name="value[]" readonly="readonly" type="text" class="textBoxExpnd  validate[required,number] value" id="value'+number_of_field+'" value="'+amount+'"  style="width:80%;" autocomplete="off"/></td>  ';

                        field +='<td valign="middle" style="text-align:center;"> <a href="javascript:void(0);" id="delete row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image("icons/cross.png", array("alt" => "Remove Row","style"=>"float:none !important" ,"title" => "Remove Item")); ?></a></td>';

                        field +='  </tr>    ';
                        amount = (amount == '') ? 0 : amount; 
                        totalAmount = totalAmount + amount;
                        $('#total_amount_field').val(totalAmount);
                        $('#total_amount').html(totalAmount);
                        $('#net_amount').html(totalAmount);
                        if (number_of_field>1){
                            $("#remove-btn").css("display","inline");
                        }
                        $("#no_of_fields").val(number_of_field);
                        number_of_field = number_of_field+1;
                        $("#item-row").append(field);
                    }
                });
            }
        });
    }

    function checkstock(field, rules, i, options){
        var fieldno = field.attr('fieldNo') ; 
        var stock = parseInt($("#stockQty"+fieldno).val());
        if(stock < field.val()){
            //return 'Insufficient quantity in stock';
        }
    }
    /* get the Item details*/
    function getItemDetail(itemId){
        var res = '';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "view_item", "inventory" => true, "plugin" => false)); ?>",
            async:false,
            data: "item_id="+itemId
        }).done(function( msg ) {
            res =  jQuery.parseJSON(msg);
        });
        return res;
    }

    $(document).on('keypress','.quantity',function(e) {
        var fieldNo = $(this).attr('fieldNo') ;
        if (e.keyCode==40) {	//key down
            var nextRow = parseInt(fieldNo)+1;
            $("#qty_"+nextRow).focus();
        } 
        if (e.keyCode==38) {	//up key
            var prevRow = parseInt(fieldNo)-1;
            $("#qty_"+prevRow).focus();
        } 
        if(e.keyCode==13 && "<?php echo $this->params['pass'][1]; ?>" == ''){		//key enter
            if($("#item_id"+fieldNo).val()!=0 || $("#item_id"+fieldNo).val()!=''){
                addFields();
            }
    
            $(".expiry_date").datepicker({
                showOn: "both",
                buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                buttonImageOnly: true,
                changeMonth: true,
                changeYear: true,
                yearRange: '1950',			 
                dateFormat:'<?php echo $this->General->GeneralDate(""); ?>'
            });
        } 
    });
	
    /* load the data from supplier master */
    function loadDataFromRate(itemID,selectedId){ 
        var currentField = selectedId.split("-"); 
        var fieldno = currentField[1];
        loading(fieldno);
        $("#expiry_date"+fieldno).val("");
        $("#stockQty"+fieldno).val("");
        $("#looseStockQty"+fieldno).val("");
        $("#mrp"+fieldno).val("");
        $("#vat_class_name"+fieldno).val("");
        $("#vat"+fieldno).val(""); 
        $("#rate"+fieldno).val("");
        $("#value"+fieldno).val("");
        $("#pack"+fieldno).val("");
        $("#qty_"+fieldno).val("");
        var tariff = $("#tariff_id").val();
        var room = $("#roomType").val(); 

        /*******************************/
 	
        var batchesArray = new Array();
        var batchesIDArray = new Array();
	
        $(".itemId").each(function(){
            if(itemID === $(this).val()){
                var fieldCount = $(this).attr('fieldNo'); 	//current fieldno of loop
                var batchNO = $("#batch_number"+fieldCount+" option:selected").text(); 
                var batchID = $("#batch_number"+fieldCount).val();
                batchesArray.push(batchNO);
                batchesIDArray.push(batchID);
            }
        });
 
        /********************************/
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item", 'item_id', 'true', "inventory" => true, "plugin" => false)); ?>",
            data: "item_id="+itemID+"&tariff="+tariff+"&roomType="+room+"&batch_number="+batchesArray
        }).done(function( msg ) {
            var item = jQuery.parseJSON(msg);  
            var pack = parseInt(item.PharmacyItem.pack);
            $("#item_name-"+fieldno).val(item.PharmacyItem.name);
            $("#item_id"+fieldno).val(item.PharmacyItem.id);
            $("#itemWiseDiscount"+fieldno).val(item.PharmacyItem.discount);
 
            if( item.PharmacyItem.discount != null ||  item.PharmacyItem.discount > 0 ){
                showDisc = "&nbsp;("+item.PharmacyItem.discount+"%)";
            }else{
                showDisc = '';
            }
			
            $("#displayDiscPer"+fieldno).html(showDisc);
            $("#item_code-"+fieldno).val(item.PharmacyItem.item_code);
            $("#pack"+fieldno).val(item.PharmacyItem.pack);
            $("#showPack_"+fieldno).html(item.PharmacyItem.pack);
            
            $("#doseForm"+fieldno).val(item.PharmacyItem.doseForm);
            $("#genericName"+fieldno).val(item.PharmacyItem.generic);
            batches= item.PharmacyItemRate; 

            var batches = item.batches;
            $("#batch_number"+fieldno+" option").remove(); 
            if(batches!='' && batches!=null){ 
                var totalBatches = 0;
                $.each(batches, function(index, value) { 
                    $("#batch_number"+fieldno).append( "<option value='"+index+"'>"+value+"</option>" );
                    totalBatches++;
                }) ;

                var totalRemovedBatches = 0;
                $.each(batchesIDArray, function(key, batchId) { 
                    $("#batch_number"+fieldno+" option[value='"+batchId+"']").remove(); 
                    totalRemovedBatches++;
                }); 

                if(totalBatches != totalRemovedBatches){
                    var stock = parseInt(item.PharmacyItemRate.stock!="" ? item.PharmacyItemRate.stock : 0);
                    var looseStock = parseInt(item.PharmacyItemRate.loose_stock!="" ? item.PharmacyItemRate.loose_stock:0);
                    var myStock = (stock * pack) + looseStock;
                    if(myStock > 0){
                        $("#expiry_date"+fieldno).val(item.PharmacyItemRate.expiry_date);
                        $("#stockWithLoose_"+fieldno).val(myStock);	
                        $("#showStock_"+fieldno).html(myStock); 
                        $("#stockQty"+fieldno).val(item.PharmacyItemRate.stock);
                        $("#looseStockQty"+fieldno).val(item.PharmacyItemRate.loose_stock);
                        $("#mrp"+fieldno).val(item.PharmacyItemRate.mrp);
                        $("#showMrp_"+fieldno).html(parseFloat(item.PharmacyItemRate.mrp).toFixed(2));
                        $("#vat_class_name"+fieldno).val(item.PharmacyItemRate.vat_class_name);
                        $("#vat"+fieldno).val(item.PharmacyItemRate.vat_sat_sum); 
                        $("#rate"+fieldno).val(item.PharmacyItemRate.sale_price);
                        $("#showRate_"+fieldno).html(parseFloat(item.PharmacyItemRate.sale_price).toFixed(2));
                    }else{
                        alert("Sorry, no stock available in this batch..!!");
                    }
                }else{
                    alert("Sorry, no stock available in another batche for this product..!!");
                }
            }else{
                alert("Sorry, no stock available in any batches..!!");
            }
			
            /*var batchNo = new Array();
			
                        $('.itemId').each(function(){
                                var curField = $(this).attr('fieldNo');
                                var itemId = $(this).val();
                                if($("#batch_number"+curField).val() != '' && itemID == itemId && curField != fieldno ){ //second cond added to prevent time med selection  row cond
                                        batchNo.push($("#batch_number"+curField).val());
                                } 
                        });	
				
                        $("#batch_number"+fieldno+" option").remove();
                        if(batches!=''){
                                $.each(batches, function(index, value) { 
                                        if(batchNo != ''){
                                                $.each(batchNo,function(id,collctedBatchID){ 
                                                        if(value.id != collctedBatchID){
                                                        $("#batch_number"+fieldno).append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
                                                        }
                                                }) ;
                                        }else{	
                                                $("#batch_number"+fieldno).append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
                                        }
				    
                                        if(index==0){
                                                var stock = parseInt(value.stock!="" ? value.stock : 0);
                                                var looseStock = parseInt(value.loose_stock!="" ? value.loose_stock:0);
                                                var myStock = (stock * pack) + looseStock;
                                                $("#expiry_date"+fieldno).val(value.expiry_date);
                                                $("#stockWithLoose_"+fieldno).val(myStock);	
                                                $("#stockQty"+fieldno).val(value.stock);
                                                $("#looseStockQty"+fieldno).val(value.loose_stock);
                                                $("#mrp"+fieldno).val(value.mrp);
                                                $("#vat_class_name"+fieldno).val(value.vat_class_name);
                                                $("#vat"+fieldno).val(value.vat_sat_sum); 
                                                $("#rate"+fieldno).val(value.sale_price);
                            }					
                                });
                        }
             */
            var itemrateid=$("#batch_number"+fieldno).val();
            var editUrl  = "<?php echo $this->Html->url(array('controller' => 'pharmacy', 'action' => 'edit_item_rate', 'inventory' => false)) ?>";
            $("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
            $("#qty_"+fieldno).attr('readonly',false);
            $("#qty_"+fieldno).focus();
            onCompleteRequest(fieldno);
        });
        selectedId='';
    }

    $(document).on('keyup',"#totalItemWiseDiscount",function(){
        var disc = parseFloat($("#totalItemWiseDiscount").val()!=''?$("#totalItemWiseDiscount").val():0);
        var total = parseFloat($("#total_amount_field").val());
        if(disc > total){
            alert("discount amount should not be greater than total amount");
            $("#totalItemWiseDiscount").val('');
            $("#totalItemWiseDiscount").focus();
            disc = 0;
        }
        var netAmount = total - disc; 
        $("#net_amount").html(netAmount.toFixed());
    });

    $(document).on('input',"#totalItemWiseDiscount",function(){
        if (/[^0-9\.]/g.test(this.value)){  this.value = this.value.replace(/[^0-9\.]/g,'');  }
        if(this.value.split('.').length>2) 
            this.value =this.value.replace(/\.+$/,"");
    });

    $("#ss").hide();
    $("#ss").fancybox({
        'width'				: '75%',
        'height'			: '75%',
        'autoScale'			: false,
        'transitionIn'		: 'none',
        'transitionOut'		: 'none',
        'type'				: 'iframe'
    });
 
    function deletRow(id,itemid){ 
 
        if($("#deletedId").val() != '' ){ 
            $("#deletedId").val($("#deletedId").val()+"_"+itemid) ;
        }else{
            $("#deletedId").val(itemid) ; 
        }
	   
        $("#row"+id).remove(); 
        $(".formError").remove();
        var number_of_field = parseInt($("#no_of_fields").val()); 
        var table = $('#item-row');
        summands = table.find('tr');
        var sr_no = 1;
        summands.each(function ()
        {
            var cell = $(this).find('.sr_number');
            cell.each(function ()
            {
                $(this).html(sr_no);
                sr_no = sr_no+1;
            });
        });
		
        $('.item_name'+number_of_field+"formError").hide();
        $('.item_code'+id+"formError").remove();
        $('.item_name'+id+"formError").remove();
        $('.batch_number'+id+"formError").remove();
        $('.expiry_date'+id+"formError").remove();
        $('.qty_'+id+"formError").remove();
        $('.value'+id+"formError").remove();

        $('.rate'+id+"formError").remove();
        $('.mrp'+id+"formError").remove();
        if (parseInt($("#no_of_fields").val()) == 1){ 
            $("#remove-btn").css("display","none");
        }
        $("#submitButton").removeAttr('disabled');
		
        var $form = $('#salesBill'),  
        $summands = $form.find('.value');
        var sum = 0;
        $summands.each(function ()
        {
            var value = Number($(this).val());
            if (!isNaN(value)) sum += value;
        });

        var totalItemDiscount = 0;
        $('.itemWiseDiscountAmount').each(function() { 
            if(this.value!== undefined  && this.value != ''  ){
                totalItemDiscount += parseFloat(this.value);	       
            } 			        				        
        });
        $("#totalItemWiseDiscount").val(totalItemDiscount.toFixed(2));

        var netTotal = parseFloat(sum - totalItemDiscount);
		     	
        $("#total_amount_field").val((sum.toFixed(2)));
        $("#total_amount").html((sum.toFixed(2)));
        $('#net_amount').html(netTotal.toFixed(2)); 
        //calculateDiscount();
		
    }
	

    function getTotal(id){
        if($(id)!=""){
            var fieldno = $(id).attr('fieldNo') ;
            var qty = parseInt($("#qty_"+fieldno).val()!=""?$("#qty_"+fieldno).val():0);
            var price = ($("#rate"+fieldno).val()!="")?$("#rate"+fieldno).val():0.00;
            var itemDiscount = ($("#itemWiseDiscount"+fieldno).val()!="")?$("#itemWiseDiscount"+fieldno).val():0.00;
            var qtyType = $("#itemType_"+fieldno).val();
            var packNan = isNaN($('#pack'+fieldno).val()); 
            var pack = parseInt($('#pack'+fieldno).val().match(/\d+/)); // 123456  from 123456ML

            var vat = ($('#vat'+fieldno).val()!="")?$('#vat'+fieldno).val():0;
           
            if(price<=0){
                price = parseFloat(($("#mrp"+fieldno).val()!="")?$("#mrp"+fieldno).val():0.00);
            }
			
            if(qtyType == 'Tab'){
                var calAmnt = (price/pack)*qty; 	//calculate amnt per tablet
                var sub_total = (calAmnt * 100) / 100; 
            }else{
                var sub_total = (price*qty);
            }

            var itemDiscountAmount = (sub_total * itemDiscount)/100; 
            if(!isNaN(itemDiscountAmount)){
                $("#itemWiseDiscountAmount"+fieldno).val(itemDiscountAmount.toFixed(2));
            }
            var totalWithTax = sub_total;
            if(price != 0 || price !=''){
                $("#value"+fieldno).val(totalWithTax.toFixed(2));
                $("#showValue_"+fieldno).html(totalWithTax.toFixed(2)); 
            }
            var sum = 0;
            count = 1;
            $('.value').each(function() { 
                if(this.value!== undefined  && this.value != ''  ){
                    sum += parseFloat(this.value);	       
                }
                count++;			        				        
            });

            var totalItemDiscount = 0;
            $('.itemWiseDiscountAmount').each(function() { 
                if(this.value!== undefined  && this.value != ''  ){
                    totalItemDiscount += parseFloat(this.value);	       
                } 			        				        
            });

            if(!isNaN(totalItemDiscount)){
                $("#totalItemWiseDiscount").val(totalItemDiscount.toFixed(2)); 
            }	
            $("#total_amount_field").val((Math.round(sum)));
            $("#total_amount").html(Math.round(sum)); 
            var netAmount = sum - totalItemDiscount; 
            $('#net_amount').html(Math.round(netAmount));
            curTotal = sum;
            //calculateDiscount();
            $('#cardRow').show();
            return false;
        }
    } 

    function getTotalFromDiscount(id){

        if($(id)!=""){
            var fieldno = $(id).attr('fieldNo') ;
            var qty = parseInt($("#qty_"+fieldno).val()!=""?$("#qty_"+fieldno).val():0);
            var itemPerDiscount = ($("#itemWiseDiscount"+fieldno).val()!="")?$("#itemWiseDiscount"+fieldno).val():0.00;
            var itemDiscount = ($("#itemWiseDiscountAmount"+fieldno).val()!="")?$("#itemWiseDiscountAmount"+fieldno).val():0.00;
            var itemAmount = ($("#value"+fieldno).val()!="")?$("#value"+fieldno).val():0.00;
            var price = ($("#rate"+fieldno).val()!="")?$("#rate"+fieldno).val():0.00;
			
            var sub_total = (price*qty);
            var holdItemDiscountAmount = (sub_total * itemPerDiscount)/100; 
			
            if(itemDiscount > itemAmount){
                //if greater replace discount with previous discount
                alert("Entered discount is greater than amount");
                $("#itemWiseDiscountAmount"+fieldno).val(holdItemDiscountAmount.toFixed(2));
            }
			
            if(!isNaN(itemDiscount)){
                itemDiscountAmount = qty * itemDiscount;
            }
			
            var totalAmount = $("#total_amount_field").val();

            var totalItemDiscount = 0;
            $('.itemWiseDiscountAmount').each(function() { 
                if(this.value!== undefined  && this.value != ''  ){
                    totalItemDiscount += parseFloat(this.value);	       
                } 			        				        
            });

            var netAmount = totalAmount - totalItemDiscount; 
            $("#totalItemWiseDiscount").val(totalItemDiscount.toFixed(2));
            $('#net_amount').html(Math.round(netAmount));
			 
        }
    }
  	
    function checkStockLimit(id){	//by swapnil to check the enter qty with existing stock
        if($(id)!=""){
            var fieldno = $(id).attr('fieldNo') ;
            var qty = parseInt($("#qty_"+fieldno).val());
            var qtyType = $("#itemType_"+fieldno).val();
            var pack = parseInt($('#pack'+fieldno).val().match(/\d+/));
  	        
            var stockQty = parseInt($("#stockQty"+fieldno).val());
            var looseStock = parseInt($("#looseStockQty"+fieldno).val()!=''?$("#looseStockQty"+fieldno).val():0);

            var totalTab = (pack * stockQty) + looseStock;
            var TotalQty = Math.floor(totalTab/pack);
  	    	
            if(qtyType == "Tab"){
                TotalQty = totalTab;
            }
            var webInstance = "<?php echo $websiteConfig['instance']; ?>";
            if(webInstance != "kanpur"){
                if(qty > TotalQty){
                    alert("Quantity Is Greater Than Stock");
                    $("#qty_"+fieldno).val('');
                    $("#qty_"+fieldno).focus();
                    return false;
                }
            }
            return true;
        }
    }
		
    $('#hide_patients').click(function(){	  
        $('#show_patients').show();
        $('#iframeDisplay').hide();
        $('#hide_patients').hide();
    });

    $("#addProduct").click(function(){
        $.fancybox({
            'width' : '80%',
            'height' : '150%',
            'autoScale' : true,
            'transitionIn' :'fade',
            'transitionOut' : 'fade',
            'type' : 'iframe',
            'href' : "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "add_new_product", "inventory" => false, 'admin' => false, '?' => array('flag' => 1))); ?>"

        });
        $(window).scrollTop(100);  
        return false ;
    });


    $("#tax").on("keyup",function(){
        var tax = parseFloat($("#tax").val()); 
        if(isNaN(tax)){ 
            tax = 0; 
        } 
        var netAmount = parseFloat(((curTotal * tax) / 100 ) + curTotal); 
        $("#net_amount").html(netAmount.toFixed(2)); 
    });

    $("#isDiscount").change(function(){
        if($(this).is(":checked",true)){
            $("#showDiscount").show();
        }else{ 
            $("#showDiscount").hide();
            $("#inputDiscount").val('');
            $("#discount").val('');
            $("#net_amount").html($("#total_amount_field").val());
            if($("#card_pay").is(":checked")){
                var chkpay= $('#net_amount').text();
                var cardPay=$('#cardBal').text();
                var otherPay=0;
                if(parseInt(chkpay)<parseInt(cardPay)){
                    otherPay=0;
                    $('#patient_card').val(chkpay);
                }else{					
                    otherPay=chkpay-cardPay;
                    $('#patient_card').val(cardPay);
                }		
                $('#otherPay').text(otherPay);
            }
        }
    });
    var webInstance = "<?php echo $websiteConfig['instance']; ?>";
    function calculateDiscount(){
        var disc = '';
        var totalAmount = parseFloat($("#total_amount_field").val()); 
        $(".discountType").each(function () {  
            if ($(this).prop('checked')) {
                var type = this.value; 
                discount_value = parseFloat($("#inputDiscount").val()!= '' ? $("#inputDiscount").val() : 0); 
                if(type == "Amount"){   
                    if(discount_value <= totalAmount){
                        disc = discount_value;
                    }else{
                        alert("Discount Should be Less Than TotalAmount");
                        $("#inputDiscount").val('');
                        $("#inputDiscount").focus();
                        //calculateDiscount();
                    }
                }else if(type == "Percentage") {
                    var discount_value = ($("#inputDiscount").val()!= '') ? parseFloat($("#inputDiscount").val()) : 0;
                    if(discount_value < 101){
                        disc = parseFloat(((totalAmount*discount_value)/100));
                    }else{
                        alert("Percentage should be less than or equal to 100");
                        $("#inputDiscount").val('');
                        $("#inputDiscount").focus();
                        //calculateDiscount();
                    }
                }
                $("#discount").val(disc.toFixed(2));
            }
        });
 
        var tax = ($('#tax').val()!="")?$('#tax').val():0;
        var totalTax = 0;
        //if(webInstance != "kanpur" && webInstance != "vadodara"){
        /*if(webInstance == "hope"){
                if(tax!='' || tax!=0){ 
                     totalTax = parseFloat((totalAmount*tax)/100 + totalAmount);  
        }else{
                 totalTax = parseFloat((totalAmount));
        }
    }*/
        /*var netAmnt = $("#net_amount").html();
    if(totalTax!='' || totalTax!=0){
        var netAmount = totalTax - disc;
    }else{
        var netAmount = netAmnt - disc;
    }*/
        var netAmount = totalAmount - disc;
  	
        $("#discount").val(disc.toFixed(2)); 
        $("#net_amount").html(netAmount.toFixed(2));
        if($("#card_pay").is(":checked")){
            var chkpay= $('#net_amount').text();
            var cardPay=$('#cardBal').text();
            var otherPay=0;
            if(parseInt(chkpay)<parseInt(cardPay)){
                otherPay=0;
                $('#patient_card').val(chkpay);
            }else{					
                otherPay=chkpay-cardPay;
                $('#patient_card').val(cardPay);
            }		
            $('#otherPay').text(otherPay);
        }
    }

    $("#inputDiscount").keyup(function(){
        if (/[^0-9\.]/g.test(this.value)){ this.value = this.value.replace(/[^0-9\.]/g,''); }
        calculateDiscount();
    });

    $(".discountType").change(function(){ 
        calculateDiscount();
    });

    $('#show_patients').click(function(){ 

<?php if ($patient_id) { ?>
                       var flag = 1;
                       url="<?php echo $this->Html->url(array("controller" => "patients", "action" => "get_patient_prescription_details", $patient_id, '?' => array('flag' => 1), "inventory" => false, "plugin" => false)); ?>";
<?php } else { ?>
                      url="<?php echo $this->Html->url(array("controller" => "patients", "action" => "get_patient_prescription", "inventory" => false, "plugin" => false)); ?>";
<?php } ?>



                  $.fancybox({
                      'width'    : '100%',
                      'height'   : '100%',
                      'autoScale': true,
                      'transitionIn': 'fade',
                      'transitionOut': 'fade',
                      'type': 'iframe',
                      'href': url 
                  });


                  return false ;

                  $('#iframeDisplay').show();
                  $('#show_patients').hide();
                  $('#hide_patients').show();
<?php if ($patient_id) { ?>
                      url="<?php echo $this->Html->url(array("controller" => "patients", "action" => "get_patient_prescription_details", $patient_id, "inventory" => false, "plugin" => false)); ?>";
<?php } else { ?>
                      url="<?php echo $this->Html->url(array("controller" => "patients", "action" => "get_patient_prescription", "inventory" => false, "plugin" => false)); ?>";
<?php } ?>

                  $.ajax({
                      type : "POST",
                      url: url,
                      context: document.body,
                      beforeSend:function(){
                          loading('iframeDisplay','id');
                      } 
                      ,	  		  
                      success: function(data){					 
                          $('#iframeDisplay').html(data);	
                          $('#iframeDisplay').show();			
                      }
                  });
              });

              $(document).ready(function(){
                  //script for open generic search by Swapnil G.Sharma
                  $(".showGeneric").click(function(){
                      var fieldNo = $(this).attr("fieldNo");
                  });		
              });

              function showGeneric(fieldNo){
                  var genericName = $("#genericName"+fieldNo).val();
                  $.fancybox(
                  {
                      'autoDimensions':false,
                      'width'    : '85%',
                      'height'   : '90%',
                      'autoScale': true,
                      'transitionIn': 'fade',
                      'transitionOut': 'fade',						    
                      'type': 'iframe',
                      'href': '<?php echo $this->Html->url(array("action" => "generic_search", 'inventory' => true)); ?>'+"/"+fieldNo+"/"+genericName,
                  });
              }
  	
              function setInformation(productId,fieldNo){		//this function will be called from fancy page of inventory_generic_search
                  var selectedId = "item_name-"+fieldNo;
                  loadDataFromRate(productId,selectedId);
              }

              $("#submitButton").click(function(){
                  var flag = false;
                  /*$('.itemId').each(function(){
                        var curField = $(this).attr('fieldNo');
                        var itemId = $(this).val();
                        var batchNo = $("#batch_number"+curField).val();
                        $("#row"+curField).removeClass("alert-row");
                        $('.itemId').each(function(){
                                var tempField = $(this).attr('fieldNo');
                                var tempId = $(this).val();
                                var tempBatch = $("#batch_number"+tempField).val();
                                if( itemId == tempId && batchNo == tempBatch && curField != tempField){		//same item having same batch but different row
                                        alert("you've selected same product with same batch");
                                        $("#row"+tempField).addClass("alert-row");
                                        flag = true;
                                        return false;
                                }
                        });
                        if(flag == true){
                                return false;
                        }
                });		*/

                  if(flag == false){
                      var count = 0;
                      $('.quantity').each(function(){
                          if(this.value!== undefined  && this.value != ''  ){
                              var fieldno = $(this).attr('fieldNo');
                              var qty = parseInt($("#qty_"+fieldno).val());
                              var qtyType = $("#itemType_"+fieldno).val();
                              var pack = parseInt($("#pack"+fieldno).val().match(/\d+/));
	
                              var stockQty = parseInt($("#stockQty"+fieldno).val());
                              var looseStock = parseInt($("#looseStockQty"+fieldno).val()!=''?$("#looseStockQty"+fieldno).val():0);
	
                              var totalTab = (pack * stockQty) + looseStock;
                              var TotalQty = Math.floor(totalTab/pack);
			    	
                              if(qtyType == "Tab"){
                                  TotalQty = totalTab;
                              }
                              var webInstance = "<?php echo $websiteConfig['instance']; ?>";
                              if(webInstance != "kanpur"){
                                  if(qty > TotalQty){
                                      alert("Quantity Is Greater Than Stock");
                                      $("#qty_"+fieldno).val('');
                                      $("#qty_"+fieldno).focus();
                                      return false;
                                  }
                              }
			        	
                          }			        				        
                      });
	
                      var valid=jQuery("#salesBill").validationEngine('validate');
                      if(valid){
                          $("#submitButton").hide();
                          $('#busy-indicator').show();
                      }else{
                          return false;
                      }
                  }
	 
		
              });

              $('#card_pay').click(function(){
                  var amtInCard="<?php echo $patientCardAmt['Account']['card_balance']; ?>";
                  var chkpay= parseInt($('#net_amount').text());
                  var patientID=$("#person_id").val();
                  if($("#card_pay").is(":checked")){
                      $('#payment_mode').val('Cash');
                      $('#payment_mode').trigger('change');
			 		 
                      if(!parseFloat($('#net_amount').text()) || parseFloat($('#net_amount').text())<='0'){
                          alert('Please Add Some Items');
                          $("#card_pay").attr("checked",false);
                          $("#patientCard").hide();	
                          $('#balance_card').hide()
                          $('#patientCardDetails').hide();
                          return false;
                      }else if(parseInt(amtInCard)=='0' || isNaN(amtInCard)){				
                          alert("Insufficient Funds in Patient Card"); 
                          $("#card_pay").attr("checked",false);
                          $("#patientCard").hide();
                          $('#patientCardDetails').hide();
                      }else {			 	
                          $.ajax({
                              url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getCardBalance",
    "admin" => false));
?>"+'/'+patientID,
                                               context: document.body,				  		  
                                               success: function(data){
                                                   data= $.parseJSON(data);
                                                   if(data.Account.id=='0' || isNaN(data.Account.id)){
                                                       if(data.Account.card_balance=='0' || isNaN(data.Account.card_balance)){				
                                                           alert("Insufficient Funds in Patient Card"); 
                                                           $("#card_pay").attr("checked",false);
                                                           $("#patientCard").hide();
                                                           $('#patientCardDetails').hide();
                                                       }
                                                   }
                                                   else{
                                                       if(data.Account.card_balance=='0' || isNaN(data.Account.card_balance)){				
                                                           alert("Insufficient Funds in Patient Card");
                                                           checkMode();
                                                           $("#card_pay").attr("checked",false);
                                                           $("#patientCard").hide();
                                                           $('#patientCardDetails').hide();
                                                           return false;
                                                       }
                                                       $('#balance_card').show();
                                                       $('#cardBal').text(data.Account.card_balance);
                                                       $('#patient_card').val(data.Account.card_balance);
                                                       amtInCard=data.Account.card_balance;
                                                       var cardPay=amtInCard;
                                                       var otherPay=0;
                                                       if(parseInt(chkpay)<parseInt(cardPay)){
                                                           otherPay=0;
                                                           $('#patient_card').val(chkpay);
                                                       }else{					
                                                           otherPay=chkpay-cardPay;
                                                           $('#patient_card').val(cardPay);
                                                       }		
                                                       $('#otherPay').text(otherPay);				
                                                       $("#patientCard").show();
                                                       $('#patientCardDetails').show();
                                                   } 
			  	
                                               }
                                           });
			 
                                       }	 			 
                                   }else{
                                       $("#patientCard").hide();
                                       $('#balance_card').hide();
                                       $('#patientCardDetails').hide();
                                   }
                               });

                               $('#patient_card').keyup(function(){
                                   var amtInCard= $('#cardBal').text();
                                   var changeAmt=$(this).val();
                                   var otherPay=$('#otherPay').text();
                                   if(parseInt(changeAmt)>parseInt(amtInCard)){
                                       alert("Insufficient Funds in Patient Card"); 
                                       $("#card_pay").attr("checked",false);
                                       $('#patient_card').val('');
                                       $("#patientCard").hide();
                                       $("#patientCardDetails").hide();
                                   }else{
                                       var chkpay= $('#net_amount').text();
                                       if(parseInt(changeAmt)>parseInt(chkpay)){
                                           alert("Amount Paid is greater");
                                           $("#card_pay").attr("checked",false);
                                           $('#patient_card').val('');
                                           $("#patientCard").hide();
                                           $("#patientCardDetails").hide();
                                           return false;
                                       }
                                       var otherPay=chkpay-changeAmt;
                                       if(parseInt(otherPay)<=0)
                                           otherPay=0;	
                                       $('#otherPay').text(otherPay); 
                                   }
                               });

                               function loading(id){
                                   $('#item-row').block({
                                       message: '',
                                       css: {
                                           padding: '5px 0px 5px 18px',
                                           border: 'none',
                                           padding: '15px',
                                           backgroundColor: '#000000',
                                           '-webkit-border-radius': '10px',
                                           '-moz-border-radius': '10px',
                                           color: '#fff',
                                           'text-align':'left'
                                       },
                                       overlayCSS: { backgroundColor: '#cccccc' }
                                   });
                               }
	
                               function onCompleteRequest(id){
                                   $('#item-row').unblock();
                               } 

                               /* For Nurse Prescription - Partail SalesBill */
                               $requisition = "<?php echo $requisitionType; ?>"
                               if($requisition == "nurse"){ 
                                   $(".quantity").keyup(function(){ 
                                       var Id = $(this).attr('id'); 
                                       var ID = Id.split('_');
                                       var orderQty = $(this).attr('orderedqty'); 				// Quantity Prescribed by nurse
                                       var recievedQty = $(this).attr('recvqty');				// Quantity recived in partial sales Bill
                                       qty = $(this).val(); 									// current value in Quantity field 	
			
                                       if(recievedQty != " " && recievedQty!=0){
                                           var quantity = parseInt(orderQty) - parseInt(recievedQty);				// Remaining Quantity to be sold while next partial sales bill
                                           if(parseInt(qty) > parseInt(quantity)){
                                               alert("Your ordered Quantity is "+orderQty);
                                               $("#qty_"+ID[1]).val(quantity);
                                           }
                                       }else{
                                           if(parseInt(qty) > parseInt(orderQty)){								// If Not partial case quantity should equal to order quantity
                                               alert("You can not Order More than "+orderQty);
                                               $("#qty_"+ID[1]).val(orderQty);
                                           }
                                           var quantity = orderQty;
                                       }
                                   });	
                               }

                               /* END OF Patial SaleBill */
                               $(document).on('input',".patient_card",function() { 
                                   if (/[^0-9]/g.test(this.value))
                                   {
                                       this.value = this.value.replace(/[^0-9]/g,'');
                                   }
                               });

                               $("#all_encounter").click(function(){
                                   if($(this).is(":checked")){
                                       $("#is_checked").val(1);
                                   }else{
                                       $("#is_checked").val(0);
                                   }
                               });
</script>


