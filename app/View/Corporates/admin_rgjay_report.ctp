<?php
//echo $this->Html->css(array(/* 'jquery.autocomplete.css', */'colResizable.css'));
//echo $this->Html->script(array(/* 'jquery.autocomplete.js', */'colResizable-1.4.min.js'));
echo $this->Html->script(array('jquery.fancybox.js'));
echo $this->Html->css(array('jquery.fancybox'));
?>
<style>
    .tableFoot {
        font-size: 11px;
        color: #b0b9ba;
    }

    .tabularForm td td {
        padding: 0;
    }
    .highlight td { background-color: red; }
    .top-header {
        background: #3e474a;
        height: 75px;
        left: 0;
        right: 0;
        top: 0px;
        margin-top: 10px;
        position: relative;
    }

    tr .selectedRowColor  td{
        background: #C1BA7C;
    }
    .inner_title span {
        margin: -33px 0 0 !important;
    }

    .inner_menu {
        padding: 10px 0px;
    }
    table td{ font-size:13px;}


    element.style {
        min-height: 77px;
    }

    textarea {
        width: 85px;
    }

    tr .selectedRowColor  td{
        background: #C1BA7C;
    }

    .tdLabel2 img{ float:none !important;}

    tr .even td{
        background: #F2F2F4;
    }
    tr .odd td{
        background: #E2E5E6;
    }

    tr .red td{
        background: #ff96a5;
    }

    tr .gray td{
        background: #D4D3D3;
    }
/*    .a,.b,.c,.d,.e,.f,.g,.h {
        display: none;
    }*/
    label{
        width: auto !important;
    }
    
.dropdown dd, .dropdown dt {
    margin:0px;
    padding:0px;
}
.dropdown ul {
    margin: -1px 0 0 0;
}
.dropdown dd {
    position:relative;  
}
.dropdown a, 
.dropdown a:visited {
    color:#fff;
    text-decoration:none;
    outline:none;
    font-size: 12px;
}
.dropdown dt a {
    background-color:#cce5f4;
    display:block;
    padding: 10px 20px 0px 10px;  
    overflow: hidden;
    border:0;
    width:272px;
}
.dropdown dt a span, .multiSel span {
    cursor:pointer;
    display:inline-block;
    padding: 0 3px 2px 0;
}
.dropdown dd ul {
    background-color: #cce5f4;
    border:0;
    color:#fff;
    display:none;
    left:0px;
    padding: 2px 15px 2px 5px;
    position:absolute;
    top:2px;
    width:280px;
    list-style:none;
    height: 100px;
    overflow: auto;
} 
.dropdown dd ul li a {
    padding:5px;
    display:block;
}
.dropdown dd ul li a:hover {
    background-color:#fff;
}
button {
  background-color: #6BBE92;
  width: 302px;
  border: 0;
  padding: 10px 0;
  margin: 5px 0;
  text-align: center;
  color: #fff;
  font-weight: bold;
}
</style>
<?php
// claim status to select options
$status_update = array(
    //'Account Reverified'=>'Account Reverified',
    //'Account Verified'=>'Account Verified',
    //'Accounts Verified(Repudiated)'=>'Accounts Verified(Repudiated)',
    //'Bank Received Request From Claims Dept'=>'Bank Received Request From Claims Dept',
    //'CCM Approved(Repudiated)'=>'CCM Approved(Repudiated)',
    //'CCM Pending Updated(Repudiated)'=>'CCM Pending Updated(Repudiated)',
    //'CCM Pending(Repudiated)'=>'CCM Pending(Repudiated)',
    //'CCM Rejected(Repudiated)'=>'CCM Rejected(Repudiated)',
    //'CEO Pending Updated For Termination'=>'CEO Pending Updated For Termination',
    'CMO Approved(Repudiated)' => 'CMO Approved(Repudiated)',
    'CMO Pending Updated(Repudiated)' => 'CMO Pending Updated(Repudiated)', //4
    'CMO Pending(Repudiated)' => 'CMO Pending(Repudiated)', //4
    'CMO Rejected(Repudiated)' => 'CMO Rejected(Repudiated)', //4
    //'CMO Verified'=>'CMO Verified',
    'Cancelled By Society' => 'Cancelled By Society', //4
    'Cancelled By TPA' => 'Cancelled By TPA', //4
    'Claim Doctor Approved' => 'Claim Doctor Approved',
    'Claim Doctor Pending' => 'Claim Doctor Pending', //4
    'Claim Doctor Pending Updated' => 'Claim Doctor Pending Updated',
    'Claim Doctor Rejected' => 'Claim Doctor Rejected', //4
    //'Claim Inprocess'=>'Claim Inprocess',
    //'Claim Paid'=>'Claim Paid',
    //'Claim Paid(Repudiated)'=>'Claim Paid(Repudiated)',
    //'Claim Rejected by Bank'=>'Claim Rejected by Bank',
    //'Claim Rejected by Bank(Repudiated)'=>'Claim Rejected by Bank(Repudiated)',
    'Claim Rejected by CMO' => 'Claim Rejected by CMO', //4
    //'Claim Sent For Payment'=>'Claim Sent For Payment',
    //'Claim Sent for Payment(Repudiated)'=>'Claim Sent for Payment(Repudiated)',
    //'Claim Sent to CMO'=>'Claim Sent to CMO',
    //'Claim Submitted'=>'Claim Submitted',
    //'Claims Closed(Not Updated)'=>'Claims Closed(Not Updated)',
    'Discharge Update' => 'Discharge Update', //3
    //'Enhancement Approved By GM Medical'=>'Enhancement Approved By GM Medical',
    //'Enhancement Approved By Technical Committee'=>'Enhancement Approved By Technical Committee',
    //'Enhancement To Be Requested'=>'Enhancement To Be Requested',
    //'GM Medical Pending For Enhancement'=>'GM Medical Pending For Enhancement',
    //'GM Medical Pending Updated For Enhancement'=>'GM Medical Pending Updated For Enhancement',
    'In Patient Case Registered' => 'In Patient Case Registered', //s1
    'In Process' => 'In Process preauth', //s1
    //'Medical Management'=>'Medical Management',
    //'NWH Enhancement Request'=>'NWH Enhancement Request',
    //'Nwh Cancel Requested'=>'Nwh Cancel Requested',
    'Preauth Updated' => 'Preauth Updated', //s1
    'Preauth Updated Cancelled' => 'Preauth Updated Cancelled', //s1
    'Preauth Approved' => 'Preauth Approved', //s1
    //'Repudiated Claim Appeal Initiated'=>'Repudiated Claim Appeal Initiated',
    'Repudiated Claim Appeal Initiated by CCM' => 'Repudiated Claim Appeal Initiated by CCM',
    'Sent For Preauthorization' => 'Sent For Preauthorization', //s1
    'Society Approved' => 'Society Approved', //s2
    'Society Cancelled' => 'Society Cancelled',
    'Society Pending' => 'Society Pending', //s4
    //'Society Pending For Cancellation'=>'Society Pending For Cancellation',
    //'Society Pending For Termination'=>'Society Pending For Termination',
    //'Society Pending Updated'=>'Society Pending Updated',
    //'Society Pending Updated For Cancellation'=>'Society Pending Updated For Cancellation',
    //'Society Pending Updated For Termination'=>'Society Pending Updated For Termination',
    'Society Rejected' => 'Society Rejected', //s4
    'Surgery Update' => 'Surgery Update', //s2
    'TPA Approved' => 'TPA Approved', //s2
    //'TPA Cancelled'=>'TPA Cancelled',
    'TPA Pending' => 'TPA Pending', //s1
    //'TPA Pending For Cancellation'=>'TPA Pending For Cancellation',
    //'TPA Pending For Termination'=>'TPA Pending For Termination',
    //'TPA Pending Updated'=>'TPA Pending Updated',
    //'TPA Pending Updated For Cancellation'=>'TPA Pending Updated For Cancellation',
    //'TPA Pending Updated For Termination'=>'TPA Pending Updated For Termination',
    //'Technical Committee Pending For Enhancement'=>'Technical Committee Pending For Enhancement',
    //'Technical Committee Pending Updated For Enhancement'=>'Technical Committee Pending Updated For Enhancement',
    'Technical Committee Rejected For Enhancement' => 'Technical Committee Rejected For Enhancement', //s1
    'Terminated By Society' => 'Terminated By Society', //1
    'Terminated By TPA' => 'Terminated By TPA', //s1
    'Treatment Schedule' => 'Treatment Schedule'//s2
);
?>

<?php
$team = array('A' => 'A', 'B' => 'B', 'C' => 'C');
?>
<?php //echo $this->element('reports_menu'); ?>
<div class="inner_title">
    <h3>&nbsp; RGJAY Report</h3>
</div>

<div class="inner_menu">
<?php echo $this->Form->create('Corporates', array('type' => 'get')); ?>
    <table cellpadding="0" class="" cellspacing="0" border="0" align="left" width="100%">
        <tr>
            <td valign="top"><?php echo "Search by Team: " . $this->Form->input('assigned_to', array('type' => 'select', 'label' => false, 'class' => 'filterz', 'div' => false, 'id' => 'teamz', 'options' => $team, 'selected' => $this->params->query['assigned_to'], 'multiple' => "multiple", 'size' => 3)); ?>
                &nbsp; <?php echo "Search by status : " . $this->Form->input('claim_status', array('type' => 'select', 'label' => false, 'class' => 'filterz', 'div' => false, 'id' => 'statusz', 'selected' => $this->params->query['claim_status'], 'options' => $status_update, 'empty' => '--Select--', 'multiple' => true, 'size' => 3)); ?>
            </td>

            <td><?php
                echo __("Patient Name : ") . "&nbsp;" . $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label' => false, 'div' => false,
                    'value' => !empty($this->params->query['lookup_name']) ? $this->params->query['lookup_name'] : '', 'error' => false, 'autocomplete' => false, 'class' => 'name'));
                echo $this->Form->hidden('patient_id', array('value' => !empty($this->params->query['patient_id']) ? $this->params->query['patient_id'] : '', 'id' => 'patient_id'));
?> <span id="look_up_name" class="LookUpName"> <?php
                echo $this->Form->submit(__('Search'), array('class' => 'blueBtn', 'div' => false, 'label' => false));
?>
                </span>
            </td>
            <td>
                <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png', array('style' => 'height:20px;width:18px;')), array('controller' => 'Corporates', 'action' => 'rgjay_report', 'admin' => true), array('id' => 'refresh', 'class' => 'refresh', 'escape' => false, 'title' => 'Refresh'));
                ?>
            </td>
            <td><span style="float:right;"><?php
                //echo $this->Form->create('Corporates',array('action'=>'admin_rgjayreport_xls', 'admin' => true,'type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;'));
                echo $this->Html->link('Back', array('controller' => 'Reports', 'action' => 'admin_all_report'), array('escape' => true, 'class' => 'blueBtn', 'style' => 'float:center;'));
                echo $this->Form->submit(__('Generate Excel Report'), array('class' => 'blueBtn', 'div' => false, 'label' => false));
                ?></span>
            </td>
        </tr>
    </table>
<?php echo $this->Form->end(); ?> 
</div>


<!--<dl class="dropdown" style="float: right">  
    <dt>
        <a href="javascript:void(0);">
          <span class="hida">Select Column to show/hide</span>    
          <p class="multiSel"></p>  
        </a>
    </dt>
    <dd>
        <div class="mutliSelect">
            <ul>
                <li><label><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'div'=>false,'onClick'=>"checkIsCheck(this,'h')",'label'=>false,'id'=>'h')); echo __("Procedure Name"); ?></label></li>
                <li><label><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'div'=>false,'onClick'=>"checkIsCheck(this,'a')",'label'=>false,'id'=>'a')); echo __("Preauth Send Preauth Approve"); ?></label></li>
                <li><label><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'div'=>false,'onClick'=>"checkIsCheck(this,'b')",'label'=>false,'id'=>'b')); echo __("Surgery Pending Surgery Done");  ?></label></li>
                <li><label><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'div'=>false,'onClick'=>"checkIsCheck(this,'c')",'label'=>false,'id'=>'c')); echo __("Surgery Notes Update");  ?></label></li>
                <li><label><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'div'=>false,'onClick'=>"checkIsCheck(this,'d')",'label'=>false,'id'=>'d')); echo __("Discharge Date Update Date");  ?></label></li>
                <li><label><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'div'=>false,'onClick'=>"checkIsCheck(this,'e')",'label'=>false,'id'=>'e')); echo __("Bill Date Days Uploading Date");  ?></label></li>
                <li><label><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'div'=>false,'onClick'=>"checkIsCheck(this,'f')",'label'=>false,'id'=>'f')); echo __("Claim Date Pending Days");  ?></label></li>
                <li><label><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'div'=>false,'onClick'=>"checkIsCheck(this,'g')",'label'=>false,'id'=>'g')); echo __("CMO Date Pending Days");  ?></label></li>
            </ul>
        </div>
    </dd> 
</dl>-->


<div class="clr">&nbsp;</div>
<div id="container">
    <div class="clr ht5"></div>
    <div class="inner_title"></div>
    <table width="" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="item-row" style="top:0px; overflow: scroll;">
        <thead>
            <tr>
                <th width="1%" valign="top" align="center"
                    style="text-align: center;">No.</th> 
                <th width="8%" valign="top" align="center"
                    style="text-align: center;">Patient name <br> Case No. <br>
                    Hospital No. <br> Assigned To</th>
                <th width="" valign="top" align="center"
                    style="text-align: center;" class="h">Procedure Name</th>
                <th width="" valign="top" align="center"
                    style="text-align: center; ">Adm.Date <br> Pack.Dt</th>
                <th width="" valign="top" align="center"
                    style="text-align: center;">comp letion days</th>
                <th width="" valign="top" align="center"
                    style="text-align: center;">Extension</th>
                <th width="" valign="top" align="center" style="text-align: center;">Package Amount</th> 
                <th width="" valign="top" align="center"
                    style="text-align: center;">Claim Status</th>
                <th width="5%" valign="top" align="center"style="text-align: center;">Remark</th>
<!--			<th width="65" valign="top" align="center"
                        style="text-align: center; min-width: 65px;">Enrollment Date</th>-->
                <th width="" valign="top" align="center" style="text-align: center;" class="a">Preauth Send<br> Preauth Approved</th>
                <th width="" valign="top" align="center" style="text-align: center;" class="b">Surgery Pending<br>Surgery Done</th>
                <th width="" valign="top" align="center" style="text-align: center;" class="c">Surgery Notes Updated</th>
<!--			<th width="65" valign="top" align="center"
                    style="text-align: center; min-width: 65px;">Post of Notes</th>-->
                <th width="" valign="top" align="center" style="text-align: center;" class="d">Discharge Date <br> Update  Date</th>
                <th width="" valign="top" align="center"  style="text-align: center;" class="e">Bill Date <br>Days <br>  Uploading Date</th>
                <th width="" valign="top" align="center" style="text-align: center;" class="f">Claim Date <br>Pending
                    Days</th>
                <th width="" valign="top" align="center" style="text-align: center;" class="g">CMO Date <br> Pending Days</th>
                <th width="1%" valign="center" align="center"style="text-align: center;"><?php echo $this->Html->image('icons/delete-icon.png'); ?>
                </th>
            </tr>
        </thead> 
<?php
$curnt_date = date("Y-m-d"); //for current date
$i = 0;
foreach ($results as $key => $result) {
    $patient_id = $result['Patient']['id'];
    //holds the id of patient
    $bill_id = $result['FinalBilling']['id']; //holds the bill id of patient
    $i++;

    if ($i % 2 == 0) {
        $clss = "even";
    } else {
        $clss = "odd";
    }

    $redStatus = array('Society Pending', 'Sent For Preauthorization', 'Preauth Updated');
    if (in_array($result['Patient']['claim_status'], $redStatus)) {
        $clss = "red";
    }

    $grayStatus = array('Sent For Preauthorization', 'Society Pending');
    if (in_array($result['Patient']['claim_status'], $grayStatus)) {
        $clss = "gray";
    }
    ?> 
            <tr id="row_<?php echo $patient_id; ?>" class="data <?php echo $clss; ?> rowselected">
                <td width="" align="center"
                    style="text-align: center;"><?php echo $i; ?>
                </td>
                
                <td width="" align="center" style="text-align: center;">
                    <table cellpadding="0" cellspacing="0" border="0" class="tabularForm">
                        <tr>
                            <td colspan="2">
    <?php echo $result['Patient']['lookup_name']; ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?php
    echo $this->Form->input('case_no', array('placeholder' => 'case no', 'id' => 'case_' . $result['Patient']['id'], 'type' => 'text', 'label' => false, 'div' => false, 'style' => "width: 70%;", 'class' => 'add_case', 'value' => $result['Patient']['case_no']));
    ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?php
    echo $this->Form->input('hospital_no', array('placeholder' => 'Hosp. no', 'id' => 'hospital_' . $result['Patient']['id'], 'type' => 'text', 'label' => false, 'div' => false, 'style' => "width: 70%;", 'class' => 'add_hospital', 'value' => $result['Patient']['hospital_no']));
    ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"><?php
    echo $this->Form->input('status_update', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'assigned', 'id' => $result['Patient']['id'], 'options' => array('empty' => '---', $team), 'selected' => $result['Patient']['assigned_to']));
    ?>
                            </td>
                        </tr>
                    </table>
                </td>

                <td width="" align="center" class="h"
                    style="text-align: center;"><?php
    foreach ($surgeriesData as $surgery) {
        if ($result['Patient']['id'] == $surgery['OptAppointment']['patient_id']) {
            echo $surgery['Surgery']['name']; //display only the surgery of rgjay patients
        }
    }
    ?>
                </td>

                <td width="" align="center"
                    style="text-align: center;">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><?php echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'], Configure::read('date_format'));   //date of admission  ?>
                            </td>
                        </tr>
                        <tr>
                            <td>-----</td>
                        </tr>
                        <tr>
                            <td><?php
                    $comp_date = add_dates($result['Patient']['form_received_on'], 7); //package completion date after 7 days of admission
                    echo $this->DateFormat->formatDate2Local($comp_date, Configure::read('date_format'));
                    ?>
                            </td>
                        </tr>
                    </table>
                </td>

                <td width="" align="center"
                    style="text-align: center;"><?php
                    //if the patient is discharged or approved then display green button otherwise display the no of completion days after package
                    if (isset($result['Patient']['discharge_date']) || $result['Patient']['extension_status'] == 1) {
                        echo $this->Html->image('icons/bullet-green.png', array('title' => "approved"));
                    } else {
                        ?> <span id="completion_<?php echo $result['Patient']['id']; ?>">
                            <?php echo "<font style=\"color:red; font-size:18px;\">" . diff_bet_dates($comp_date, $curnt_date) . "</font>"; // difference betn the completed package date and current date?>
                        </span> <?php }
                        ?>
                </td>

                <td width="" align="center"
                    style="text-align: center;"><?php
                    if (!isset($result['Patient']['discharge_date'])) {
                        echo $this->Form->input('status', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'checkMe', 'id' => $result['Patient']['id'], 'options' => array('empty' => '--Select--', '1' => 'Approved', '0' => 'Discharged'), 'selected' => $result['Patient']['extension_status']));
                    } else {
                        echo "Discharged";
                    }
                    ?>
                </td>

                <td width="" align="center" style="text-align: center;"> <?php
                
                     echo $this->Form->hidden('patientId',array('id'=>'patient_'.$bill_id,'value'=>$patient_id,'class'=>'patient_id'));
                    //echo $this->Number->currency(ceil($totalAmount[$patient_id]));
                    //$hospitalInvoice = $totalAmount[$patient_id];
                    $hospitalInvoice = $packageAmount[$patient_id];
                    echo $this->Form->input('cmp_amt_paid', array('id'=>'amt_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'cmp_amt_paid','value'=>$hospitalInvoice)); 		
                        
                    //$packageAmount = $packageAmount[$patient_id];
                    //echo $this->Form->input('package_amount', array('placeholder' => 'Package', 'id' => 'packageAmt_' . $bill_id, 'type' => 'text', 'label' => false,
                      //  'div' => false, 'style' => "width: 100%;", 'class' => 'add_package_amount', 'value' => $packageAmount));
                        ?> 
                </td> 
                <!-- Enrollment 
                <td width="65" align="center" style="text-align: center; min-width: 65px;">
                            <?php
                            $enrollment_date = '';
                            if (!empty($result['Patient']['enrollment_date'])) {
                                $enrollment_date = $this->DateFormat->formatDate2Local($result['Patient']['enrollment_date'], Configure::read('date_format'));
                            }
                            echo $this->Form->input("enrollment_date", array('placeholder' => 'Enrollment', 'value' => $enrollment_date, 'field' => 'enrollment_date', 'style' => "width: 65%;", 'class' => 'textBoxExpnd enrollment_date', 'patient_id' => $patient_id, 'label' => false));
                            ?> 
                </td>-->
                <!-- end of enrollment -->

                <td width="" align="center"
                    style="text-align: center;"><?php
                            //$status_update = array('cmo pending'=>'CMO Pending','doc claim pending'=>'Dr. Claim Pending','discharge update'=>'Discharge Update','surgery update'=>'Surgery Update','soc approved'=>'Society Approved');
                            echo $this->Form->input('claim_status', array('type' => 'select', 'style' => "width:150px;", 'label' => false, 'div' => false, 'class' => 'claim_status', 'id' => $result['Patient']['id'], 'options' => array('empty' => '--Select--', $status_update), 'selected' => $result['Patient']['claim_status']));
                            ?>
                </td>

                <td width="" align="center" style="text-align: center"> 
    <?php
    echo $this->Html->link($this->Html->image('icons/notes_error.png', array('patient' => $result['Patient']['id'], 'onclick' => "addRemarks($patient_id)")), 'javascript:void(0);', array('escape' => false, 'alt' => "Remark", 'title' => "Click to add or view remarks"));
    //echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'4','cols'=>'1','class'=>'add_remark','value'=>$result['Patient']['remark']));
    ?>
                </td>
                <!-- Preauth Send / Preauth Approved -->
                <td width="" align="center" class="a"
                    style="text-align: center;">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                    <?php
                    $preauth_send_date = '';
                    if (!empty($result['Patient']['preauth_send_date'])) {
                        $preauth_send_date = $this->DateFormat->formatDate2Local($result['Patient']['preauth_send_date'], Configure::read('date_format'));
                    }
                    echo $this->Form->input("preauth_send", array('placeholder' => 'preauth send', 'value' => $preauth_send_date, 'field' => 'preauth_send_date', 'style' => "width: 65%;", 'class' => 'textBoxExpnd preauth_send', 'patient_id' => $patient_id, 'label' => false));
                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">-----</td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                $preauth_approved_date = '';
                                if (!empty($result['Patient']['preauth_approved_date'])) {
                                    $preauth_approved_date = $this->DateFormat->formatDate2Local($result['Patient']['preauth_approved_date'], Configure::read('date_format'));
                                }
                                echo $this->Form->input("preauth_approved", array('placeholder' => 'preauth approved', 'value' => $preauth_approved_date, 'field' => 'preauth_approved_date', 'style' => "width: 65%;", 'class' => 'textBoxExpnd preauth_approved', 'patient_id' => $patient_id, 'label' => false));
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <!-- end of preauth send / preauth approved -->

                <!-- Surgery Pending / Surgery Done -->
                <td width="" align="center"  class="b"
                    style="text-align: center;">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
    <?php
    $surgery_pending_date = '';
    if (!empty($result['Patient']['surgery_pending_date'])) {
        $surgery_pending_date = $this->DateFormat->formatDate2Local($result['Patient']['surgery_pending_date'], Configure::read('date_format'));
    }
    echo $this->Form->input("surgery_pending", array('placeholder' => 'Surgery Pending', 'value' => $surgery_pending_date, 'field' => 'surgery_pending_date', 'style' => "width: 65%;", 'class' => 'textBoxExpnd surgery_pending', 'patient_id' => $patient_id, 'label' => false));
    ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">-----</td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                $surgery_done_date = '';
                                if (!empty($result['Patient']['surgery_done_date'])) {
                                    $surgery_done_date = $this->DateFormat->formatDate2Local($result['Patient']['surgery_done_date'], Configure::read('date_format'));
                                }
                                echo $this->Form->input("surgery_done_date", array('placeholder' => 'Surgery Done', 'value' => $surgery_done_date, 'field' => 'surgery_done_date', 'style' => "width: 65%;", 'class' => 'textBoxExpnd surgery_done', 'patient_id' => $patient_id, 'label' => false));
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <!-- end of Surgery Pending / Surgery Done -->

                <!-- Surgery Notes Update -->
                <td width="" align="center"  class="c" style="text-align: center;">
                                <?php
                                $surgery_notes_update_date = '';
                                if (!empty($result['Patient']['surgery_notes_update_date'])) {
                                    $surgery_notes_update_date = $this->DateFormat->formatDate2Local($result['Patient']['surgery_notes_update_date'], Configure::read('date_format'));
                                }
                                echo $this->Form->input("surgery_notes_update_date", array('placeholder' => 'Surgery Notes Update', 'value' => $surgery_notes_update_date, 'field' => 'surgery_notes_update_date', 'style' => "width: 65%;", 'class' => 'textBoxExpnd surgery_notes_update', 'patient_id' => $patient_id, 'label' => false));
                                ?> 
                </td>
                <!-- end of Surgery notes update -->

                <!-- Post of Notes 
                <td width="65" align="center" style="text-align: center; min-width: 65px;">
                    <?php
                    $post_of_notes_date = '';
                    if (!empty($result['Patient']['post_of_notes_date'])) {
                        $post_of_notes_date = $this->DateFormat->formatDate2Local($result['Patient']['post_of_notes_date'], Configure::read('date_format'));
                    }
                    echo $this->Form->input("post_of_notes_date", array('placeholder' => 'Post of Notes', 'value' => $post_of_notes_date, 'field' => 'post_of_notes_date', 'style' => "width: 65%;", 'class' => 'textBoxExpnd post_of_notes', 'patient_id' => $patient_id, 'label' => false));
                    ?> 
                </td>-->
                <!-- end of Post of notes -->

                <!-- discharge date -->
                <td width="" align="center"  class="d"
                    style="text-align: center;">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><?php
                    echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'], Configure::read('date_format'));
                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">-----</td>
                        </tr>
                        <tr>
                            <td><?php
                    if (isset($result['Patient']['discharge_update'])) {
                        echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_update'], Configure::read('date_format'));
                    } else {
                        echo $this->Form->input("discharge_update_$patient_id", array('style' => "width: 55%;", 'class' => 'textBoxExpnd discharge_update', 'label' => false));                //$i is used to change the name of datepicker in every loop
                    }
                    ?></td>
                        </tr>
                    </table>
                </td>
                <!-- end of discharge date -->

                <td width="" align="center" class="e"
                    style="text-align: center;">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><?php
                    if (isset($result['Patient']['discharge_update'])) {
                        $bill_open = add_dates($result['Patient']['discharge_update'], 10);
                        echo $this->DateFormat->formatDate2Local($bill_open, Configure::read('date_format'));
                    } else
                    if (isset($result['Patient']['discharge_date'])) {
                        $bill_open = add_dates($result['Patient']['discharge_date'], 10);
                        echo $this->DateFormat->formatDate2Local($bill_open, Configure::read('date_format'));
                    } else {
                        echo $bill_open = NULL;
                    }
                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if (isset($bill_open) && empty($result['FinalBilling']['bill_uploading_date'])) {
                                    echo $days_bill_opening = diff_bet_dates($bill_open, $curnt_date);
                                } else {
                                    echo $days_bill_opening = NULL;
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if (isset($result['FinalBilling']['bill_uploading_date'])) {
                                    echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'], Configure::read('date_format'));
                                } else {
                                    echo $this->Form->hidden('', array('value' => $bill_id, 'id' => 'bill_' . $patient_id));
                                    echo $this->Form->input("billUploadingDate_$patient_id", array('style' => "width: 65%;", 'class' => 'textBoxExpnd billUploadingDate', 'label' => false));
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>

                <td width="" align="center" class="f"
                    style="text-align: center;">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><?php
                            if (isset($result['FinalBilling']['dr_claim_date'])) {
                                $dr_claim_date = $result['FinalBilling']['dr_claim_date'];
                                echo $this->DateFormat->formatDate2Local($dr_claim_date, Configure::read('date_format'));
                            } else {
                                echo $this->Form->input("drClaimDate_$patient_id", array('style' => "width: 65%;", 'class' => 'textBoxExpnd drClaimDate', 'label' => false));
                            }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php
                            if (isset($dr_claim_date) && $result['FinalBilling']['dr_claim_pending_approval'] == 0) {
                                    ?> <span id="dr_claim_approval_<?php echo $bill_id; ?>">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td><?php echo "<font style=\"color:red;\">" . $dr_claim = diff_bet_dates($dr_claim_date, $curnt_date) . "</font>";
                            unset($dr_claim_date);
                            ?></td>
                                                <td align="right"><span id="<?php echo $bill_id; ?>"
                                                                        class="approveME"> <?php echo $this->Html->image('icons/red_bullet.png', array('alt' => 'Pending', 'title' => 'Click to approve'), array('escape' => false, 'div' => false)); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </span> <?php
                        } else
                        if ($result['FinalBilling']['dr_claim_pending_approval'] == 1) {
                            echo $this->Html->image('icons/bullet-green.png', array('escape' => false, 'div' => false));
                        } else {
                            echo $dr_claim = NULL;
                        }
                                ?></td>
                        </tr>
                    </table>
                </td>

                <td width="" align="center" class="g"
                    style="text-align: center;">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><?php
                            if (isset($result['FinalBilling']['CMO_claim_date'])) {
                                $CMO_claim_date = $result['FinalBilling']['CMO_claim_date'];
                                echo $this->DateFormat->formatDate2Local($CMO_claim_date, Configure::read('date_format'));
                            } else {
                                echo $this->Form->input("CMOclaimDate_$patient_id", array('style' => "width: 65%;", 'class' => 'textBoxExpnd CMOclaimDate', 'label' => false));
                            }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php
                            if (isset($CMO_claim_date) && $result['FinalBilling']['CMO_claim_pending_approval'] == 0) {
                                    ?> <span id="CMO_claim_approval_<?php echo $bill_id; ?>">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td><?php echo "<font style=\"color:red;\">" . $CMO_claim = diff_bet_dates($CMO_claim_date, $curnt_date) . "</font>";
                            unset($CMO_claim_date);
                                    ?></td>
                                                <td align="right"><span id="<?php echo $bill_id; ?>"
                                                                        class="CMOapproveME"> <?php echo $this->Html->image('icons/red_bullet.png', array('alt' => 'Pending', 'title' => 'Click to approve'), array('escape' => false, 'div' => false)); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </span> <?php
                        } else
                        if ($result['FinalBilling']['CMO_claim_pending_approval'] == 1) {
                            echo $this->Html->image('icons/bullet-green.png', array('escape' => false, 'div' => false));
                        } else {
                            echo $CMO_claim = NULL;
                        }
                                ?></td>
                        </tr>
                    </table>
                </td>  
                <td width="" align="center" style="text-align: center;"> 
                    <?php
                    /*echo $this->Html->link($this->Html->image('icons/saveSmall.png'), 'javascript:void(0);', 
                         array('escape' => false,'title' => 'Save', 'alt'=>'Save','class'=>'saveForm','id'=>'save_'.$bill_id,
                             'patient_id'=>$patient_id));*/
                    echo $this->Html->link($this->Html->image('icons/delete-icon.png'), 'javascript:void(0);', array('escape' => false, 'title' => 'Remove from report', 'alt' => 'Remove from report', 'class' => 'remove', 'id' => 'remove_' . $patient_id), __('Are you sure?', true));
                    ?>
                </td>

            </tr>
                            <?php } ?>
    </table>
    <table align="center">
        <tr>
                                            <?php $this->Paginator->options(array('url' => array("?" => $this->params->query)));
                                            ?>
            <TD colspan="8" align="center">
                <!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
                <!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
                <!-- prints X of Y, where X is current page and Y is number of pages -->
                <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
                </span>
            </TD>
        </tr>
    </table>
</div>

<!--******************************************* table closed *******************************************************-->


                            <?php

                            function diff_bet_dates($start, $end) { // difference between two dates
                                $start_ts = strtotime($start);
                                $end_ts = strtotime($end);
                                $diff = $end_ts - $start_ts;
                                if ($diff < 0) {
                                    return "-";
                                } else {
                                    return round($diff / 86400); //60 * 60 * 24	(60sec * 60min * 24hrs) = 86400
                                }
                            }

                            function add_dates($cur_date, $no_days) {  //to get the day by adding no of days from cur date
                                $date = $cur_date;
                                $date = strtotime($date);
                                $date = strtotime("+$no_days day", $date);
                                return date('Y-m-d', $date);
                            }
                            ?>




<!--*******************************************************************************************************************-->


<script>
    $(document).ready(function(){  
     
        $("#lookup_name").autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "autoSearchCorporatePatient", '25', 'IPD', "admin" => false, "plugin" => false)); ?>",
            minLength: 1,
            select: function( event, ui ) {
                $("#patient_id").val(ui.item.id);
            },
            messages: {
                noResults: '',
                results: function() {}
            }
        });  
    
         
	
        /*$("#lookup_name").autocomplete(
            "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete", "Patient", 'lookup_name', "admin" => false, "plugin" => false)); ?>", {
                width: 80,
                selectFirst: true
        }); */
	
        function checkExpiryDate(field, rules, i, options)
        {
            var today=new Date();
            var curDate = new Date(today.getFullYear(),today.getMonth(),today.getDate());
            var inputDate = field.val().split("/");
            var inputDate1 = new Date(inputDate[2],eval(inputDate[1]-1),inputDate[0]);
            if (field.val() != "") 
            {
                if (inputDate1 <= curDate) {
                    return options.allrules.expirydate.alertText;
                }
            }

        }

        $( ".discharge_update" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                //alert(date);
                var idd = $(this).attr('id');
                //alert(idd);
                splittedId=idd.split('_');
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDischargeDate", "admin" => false)); ?>",
                    data:'id='+splittedId[2]+"&date="+date,
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });


        $( ".enrollment_date" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                //alert(date);
                var idd = $(this).attr('id');
                //alert(idd);
                splittedId=idd.split('_');
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false)); ?>",
                    data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });

        $( ".preauth_send" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                //alert(date);
                var idd = $(this).attr('id');
                //alert(idd);
                splittedId=idd.split('_');
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false)); ?>",
                    data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });

        $( ".preauth_approved" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                //alert(date);
                var idd = $(this).attr('id');
                //alert(idd);
                splittedId=idd.split('_');
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false)); ?>",
                    data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });

        $( ".surgery_pending" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                //alert(date);
                var idd = $(this).attr('id');
                //alert(idd);
                splittedId=idd.split('_');
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false)); ?>",
                    data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });

        $( ".surgery_done" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                //alert(date);
                var idd = $(this).attr('id');
                //alert(idd);
                splittedId=idd.split('_');
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false)); ?>",
                    data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });


        $( ".surgery_notes_update" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                //alert(date);
                var idd = $(this).attr('id');
                //alert(idd);
                splittedId=idd.split('_');
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false)); ?>",
                    data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });

        $( ".post_of_notes" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                //alert(date);
                var idd = $(this).attr('id');
                //alert(idd);
                splittedId=idd.split('_');
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false)); ?>",
                    data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });


        $( ".billUploadingDate" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                var idd = $(this).attr('id');
                splittedId=idd.split('_');
                var bill_id = $("#bill_"+splittedId[1]).val();	 
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "billUploadDate", "admin" => false)); ?>"+"/"+bill_id,
                    data:'id='+bill_id+"&date="+date,
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });


        $( ".drClaimDate" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                var idd = $(this).attr('id');
                splittedId=idd.split('_');
                var bill_id = $("#bill_"+splittedId[1]).val();
		 
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "drClaimDate", "admin" => false)); ?>"+"/"+bill_id,
                    data:'id='+bill_id+"&date="+date,
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });


 
           

        $( ".CMOclaimDate" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            onSelect:function(date){
                var idd = $(this).attr('id');
                splittedId=idd.split('_');
                var bill_id = $("#bill_"+splittedId[1]).val();
                $.ajax({
                    type:'POST',
                    url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "CMOclaimDate", "admin" => false)); ?>"+"/"+bill_id,
                    data:'id='+bill_id+"&date="+date,
                    success: function(data)
                    {
                        //alert(data);
                    }
                });
            },
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });


        $( ".date" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",	
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+50',
            maxDate: new Date(),
            dateFormat: 'dd/mm/yy'
        });

        $('.Case').click(function()
        {
            var patient = $(this).attr('id') ;
            var val = $("#case"+patient).val();
            $.ajax({
                url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getCase", "admin" => false)); ?>"+"/"+patient+"/"+val,
                beforeSend:function(data){
                    $('#busy-indicator').show();
                },
                success: function(data){
                    $('#busy-indicator').hide();
                }
            });}
    );

        $('.add_case').blur(function()
        {
            var patient = $(this).attr('id') ;
            splittedId=patient.split('_');
            newId = splittedId[1]; 
            var val = $(this).val();
            $.ajax({
                url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getCase", "admin" => false)); ?>"+"/"+newId+"/"+val,
                beforeSend:function(data){
                    $('#busy-indicator').show();
                },
                success: function(data){
                    $('#busy-indicator').hide();
                }
            });  
        });
	
        $('.add_hospital').blur(function()
        {
            var patient = $(this).attr('id') ;
            splittedId = patient.split("_");
            newId = splittedId[1];
            var val = $(this).val();
            $.ajax({
                url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getHospital", "admin" => false)); ?>"+"/"+newId+"/"+val,
                beforeSend:function(data){
                    $('#busy-indicator').show();	
                },
                success: function(data){
                    $('#busy-indicator').hide();
                }
            });
        });
	
	
       /* $('.add_package_amount').blur(function()
        {
            var bill = $(this).attr('id'); 
            splittedId = bill.split("_");
	
            newId = splittedId[1]; //alert(newId);
            var val = $(this).val(); 
            $.ajax({
                url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getPackageAmount", "admin" => false)); ?>"+"/"+newId+"/"+val,
                beforeSend:function(data){
                    $('#busy-indicator').show();
                },
                success: function(data){
                    $('#busy-indicator').hide();
                }
            });
        });

                                                                                                                                                       
        $('.add_remark').blur(function()
        {  
            var patient = $(this).attr('id') ;//alert(patient);
            splittedId = patient.split("_");
            newId = splittedId[1];
            var val = $(this).val();
            $.ajax({
                url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getRemark", "admin" => false)); ?>"+"/"+newId+"/"+val,
                beforeSend:function(data){
                    $('#busy-indicator').show();
                },
                success: function(data){
                    $('#busy-indicator').hide();
                }
            });
        });
	
        $('.approveME').click(function()
        {
            var id = $(this).attr('id') ;
            $.ajax({
                type:'POST',
                url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getDrClaimApprove", "admin" => false)); ?>"+"/"+id,
                data:'id='+id+"&status="+1,
                success: function(data){
                    //alert(data);
                    var bullet = '<?php echo $this->Html->image("icons/bullet-green.png"); ?>';
                    $("#dr_claim_approval_"+id).html(bullet);
                }
            });
        });
		
        $('.CMOapproveME').click(function()
        {
            var id = $(this).attr('id') ;
            $.ajax({
                type:'POST',
                url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getCMOapprove", "admin" => false)); ?>"+"/"+id,
                data:'id='+id+"&status="+1,
                success: function(data){
                    //alert(data);
                    var bullet = '<?php echo $this->Html->image("icons/bullet-green.png"); ?>';
                    $("#CMO_claim_approval_"+id).html(bullet);
                }
            });
        });
	
	

        $('.checkMe').change(function()	//.checkMe is the class of select having patient's id as the id
        { 
            var id = $(this).attr('id')
            ;	
            //alert(id);	//holda the patient's id in var id
            status = $(this).val();				//holds the value of selected options
		   			
            $.ajax({
                url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getExtension", "admin" => false)); ?>"+"/"+id+"/"+status,
                success: function(data){
                    var bullet = '<?php echo $this->Html->image("icons/bullet-green.png"); ?>';
                    $("#completion_"+id).html(bullet);
                }
            });
        });
	*/		   		
			   
			   
			   
        $('.claim_status').change(function()	//.checkMe is the class of select having patient's id as the id
        {
            var id = $(this).attr('id');	
            //alert(id);						//holds the patient's id in var id
            claim_status = $(this).val();		//holds the value of selected options
            //alert(claim_status);
            $.ajax({
                url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getUpdateStatus", "admin" => false)); ?>"+"/"+id+"/"+claim_status,
                beforeSend:function(data){
                    $('#busy-indicator').show();
                    //inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
                },
	
                success: function(data){
                    $('#busy-indicator').hide();
                }
	
            });
        });
	   
			   
			   
			 		 		   
        $('.assigned').change(function()	//.checkMe is the class of select having patient's id as the id
        {
            var id = $(this).attr('id');	
            //alert(id);	//holda the patient's id in var id
            assigned = $(this).val();				//holds the value of selected options
            $.ajax({
                url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getAssigned", "admin" => false)); ?>"+"/"+id+"/"+assigned,
                beforeSend:function(data){
                    $('#busy-indicator').show();
                    //inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
                },
	
                success: function(data){
                    $('#busy-indicator').hide();
                }
	
            } );
        });
	


        $('.filter').change(function()	//.checkMe is the class of select having patient's id as the id
        {
            var team = ($('#team').val()) ? $('#team').val() : 'null' ;
            //alert(team);
            var status = ($('#status').val()) ? $('#status').val() : 'null';
            var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "rgjay_report", "admin" => true)); ?>";
            $.ajax({
                url : ajaxUrl + '?assigned_to=' + team + '&claim_status=' + status,
                beforeSend:function(data){
                    $('#busy-indicator').show();
                },
                success: function(data){
                    $("#container").html(data).fadeIn('slow');
                    $('#busy-indicator').hide();
                }
            });
        });

        /*$(function() {
                var $sidebar   = $(".top-header"),
            $window    = $(window),
            offset     = $sidebar.offset(),
            topPadding = 0;

        $window.scroll(function() {
            if ($window.scrollTop() > offset.top) {
                //$sidebar.stop().animate({
                 //   top: $window.scrollTop() - offset.top + topPadding
               // });

                $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
            } else {
                $sidebar.stop().animate({
                    top: 0
                });
            }
        });
       
    });*/
    


        $('.LookUpName').click(function()
        {
            //alert("OK");
            var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;
            //alert(lookup_name);
		
            var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "rgjay_report", "admin" => true)); ?>";
            $.ajax({
                url : ajaxUrl + '?lookup_name=' + lookup_name,
                beforeSend:function(data){
                    $('#busy-indicator').show();
                },
                success: function(data){
                    $('#busy-indicator').hide();
                    $("#container").html(data).fadeIn('slow');
			
                }
            });
        });


    });
    function hideFromList(patient_id){
        var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "hideFromReportList", "admin" => false)); ?>"+"/"+patient_id;
        $.ajax({
            url : ajaxUrl,
            beforeSend:function(data){
                $('#busy-indicator').show();
            },
            success: function(data){
                $('#busy-indicator').hide();
                $("#row_"+patient_id).hide();
            }
        });
    }
    /*
$(".data tr").click(function() {
    var id = $(this).attr('id'); 
    $("#"+id).toggleClass("highlight");
});*/
    $(".rowselected").click(function(){
        var id = $(this).attr('id').split("_")[1]; 
        $(".rowselected").each(function(key, value){
            $(this).removeClass('selectedRowColor');
        });
        $("#row_"+id).addClass('selectedRowColor');
    });

    function addRemarks(patientID){ 
        $.fancybox({
            'width' : '80%',
            'height' : '', 
            'autoScale': false,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'type': 'iframe',
            'href': "<?php echo $this->Html->url(array("action" => "getRemarkForCorporateReport", 'admin' => false)); ?>"+'/'+patientID+'/RGJAY Remark'
        });
    }


    $(".remove").click(function(){
        var patientId = $(this).attr('id').split("_")[1]; 
        $.ajax({
            url : "<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "hideFromReportList", "admin" => false)); ?>"+"/"+patientId,
            beforeSend:function(data){
                $('#busy-indicator').show(); 
            }, 
            success: function(data){
                $('#busy-indicator').hide();
                $("#row_"+patientId).remove();
            }
        });
    });	

/*
    $('.add_package_amount').focus(function(){
        var id = $(this).attr('id').split("_")[1];
        if($("#bank_"+id).val()!=''){

        }else{
            alert("please select bank first");
            $(this).val('');
            $(this).focus();
            return false;
        }
    });

    $(".saveForm").click(function(){ 
        var patientId = $(this).attr('patient_id');
        var id = $(this).attr('id').split("_")[1];
        var bank_id = $("#bank_"+id).val();
        var total_amount = $("#amt_"+id).val();
        var tds = $("#tds_"+id).val();
        var other_deduction = $("#otherDeduction_"+id).val();
        var amount_received = $("#package_"+id).val();
        var bill_no = $("#bill_"+id).val();
        var invoice_date = $("#cmp_paid_date_"+patientId).val();
        var remark = $("#remark_"+patientId).val(); 
        var isSettled = ($("#isSettled_"+id).is(':checked') == true)?'1':'0';
        var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');

        if(amount_received == ''){
            alert("please enter amount");
            return false;
        } 

        if(invoice_date == ''){
            alert("please select date");
            return false;
        } 

        $.ajax({
            type: 'POST',
            url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getAmountReceived", "admin" => false));?>"+"/"+id,
            data: 'bank_id='+bank_id+'&total_amount='+total_amount+'&advance_amount='+advAmt+'&amount='+amount_received+'&tds='+tds+'&other_deduction='+other_deduction+'&patient_id='+patientId+'&bill_no='+bill_no+'&invoice_date='+invoice_date+'&remark='+remark+'&is_setteled='+isSettled,
            beforeSend:function(data){  
                $('#busy-indicator').show();    
            },
            success: function(data){  
                var obj = jQuery.parseJSON( data );
                if(obj == 1){ 
                    window.location.reload();
                }else if(obj == 2){
                    $("#row_"+patientId).remove();
                    $('#busy-indicator').hide();
                }else{
                    alert("something went wrong, please try again..!!");
                    $('#busy-indicator').hide();
                } 
            }
        }); 
    });
    $(".IsSettled").click(function(){
        var id = $(this).attr('id').split("_")[1];
        var tdsAmt = parseInt($("#tds_"+id).val()!=''?$("#tds_"+id).val():'0'); 
        var amtRec = parseInt($("#package_"+id).val()!=''?$("#package_"+id).val():'0');
        var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
        var hospAmt = parseInt($("#amt_"+id).val()!=''?$("#amt_"+id).val():'0');

        var tdsAdvOtherSum = advAmt + tdsAmt;
        var collectMoney = hospAmt - tdsAdvOtherSum;
    
        if($("#isSettled_"+id).is(':checked') == true){
            if(amtRec > collectMoney){
                alert("you could not able to collect amount more than Rs."+collectMoney); 
                $("#otherDeduction_"+id).val('');
                $(this).val('');
                $(this).focus();
                return false;
            }
            $("#otherDeduction_"+id).val(collectMoney - amtRec);
        }else{
            $("#otherDeduction_"+id).val('');
        }
    });

    $(".add_package_amount").keyup(function(){
        var id = $(this).attr('id').split("_")[1];
        var tdsAmt = parseInt($("#tds_"+id).val()!=''?$("#tds_"+id).val():'0'); 
        var amtRec = parseInt($("#package_"+id).val()!=''?$("#package_"+id).val():'0');
        var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
        var hospAmt = parseInt($("#amt_"+id).val()!=''?$("#amt_"+id).val():'0');

        var tdsAdvOtherSum = advAmt + tdsAmt;
        var collectMoney = hospAmt - tdsAdvOtherSum;

        if(amtRec > collectMoney){
            alert("you could not able to collect amount more than Rs."+collectMoney); 
            $("#otherDeduction_"+id).val('');
            $(this).val('');
            $(this).focus();
            return false;
        }
        if($("#isSettled_"+id).is(':checked') == true){
            $("#otherDeduction_"+id).val(collectMoney - amtRec);
        }else{
            $("#otherDeduction_"+id).val('');
        }
    });
 
    $(".add_tds").keyup(function(){
        var id = $(this).attr('id').split("_")[1];
        var tdsAmt = parseInt($("#tds_"+id).val()!=''?$("#tds_"+id).val():'0'); 
        var amtRec = parseInt($("#package_"+id).val()!=''?$("#package_"+id).val():'0');
        var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
        var hospAmt = parseInt($("#amt_"+id).val()!=''?$("#amt_"+id).val():'0');
        var otherDeduction = parseInt($("#otherDeduction_"+id).val()!=''?$("#otherDeduction_"+id).val():'0');

        var tdsAdvOtherSum = advAmt + tdsAmt;
        var collectMoney = hospAmt - tdsAdvOtherSum;

        if((collectMoney - amtRec)>0 && $("#isSettled_"+id).is(':checked') == true){
            $("#otherDeduction_"+id).val(collectMoney - amtRec);
        }else{
            var remainAmount = (tdsAmt - otherDeduction);
            if($("#isSettled_"+id).is(':checked') == true){
                $("#otherDeduction_"+id).val(0);
                $("#package_"+id).val((amtRec)-remainAmount);
            } 
        }

        if($("#isSettled_"+id).is(':checked') == false){
            var tdsAdvOtherSum = advAmt + (amtRec + otherDeduction);
            var collectMoney = hospAmt - tdsAdvOtherSum; 
            if(tdsAmt > collectMoney){
                alert("Could not able to collect tds amount more than Rs."+collectMoney); 
                $("#otherDeduction_"+id).val('');
                $(this).val('');
                $(this).focus();
                return false;
            }
        } 
    });

function checkIsCheck(id,cls){
    if($(id).is(':checked') == true){
        $('.'+cls).show();
    }else{
        $('.'+cls).hide();
    }
}
  
//for dropdown to show/hide columns on reports
$(".dropdown dt a").on('click', function () {
    $(".dropdown dd ul").slideToggle('fast');
});

$(".dropdown dd ul li a").on('click', function () {
    $(".dropdown dd ul").hide();
});

$(document).bind('click', function (e) {
    var $clicked = $(e.target);
    if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});
 
$( ".cmp_paid_date").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>", 
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy'
});*/
</script>
