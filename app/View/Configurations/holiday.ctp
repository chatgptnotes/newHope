<style>
    .pname,.name {
        width: 150px !important;
    }
    .tabularForm {
        background-color:orange;
        color: #000;
        font-size: 13px;
        padding: 3px 8px;
    }
    .tabularForm th {
        background: orange none repeat scroll 0 0 !important;
        border-bottom: 1px solid #3e474a;
        color: #31859c !important;
        font-size: 12px;
        padding: 5px 8px;
        text-align: left;
    }
    .t{
        width: 45%;

    }
    <?php $holidayType = array('PH' => 'Public Holiday', 'OH' => 'Other Holiday'); ?>
</style> 
<div class="inner_title">
    <?php echo $this->element('navigation_menu', array('pageAction' => 'HR')); ?>
    <h3><?php echo __('Holiday Master'); ?></h3>
</div> 

<div style="float: right;" >
    <?php echo $this->Html->link(__('Back'), array('controller' => 'Misc', 'action' => 'index'), array('escape' => false, 'class' => 'blueBtn')); ?>
</div>

<div class="clr ht5"></div>
<?php echo $this->Form->create('holiday', array('id' => 'holiday')); ?> 
<table class="table_format" cellspacing="0">
    <tr class="row_title"> 
        <?php for ($i = 2014; $i <= date('Y') + 5; $i++) { ?>
            <?php $yearArray[$i] = $i; ?>
        <?php } ?>   
        <td style="text-align:right" class="alignRight" width="15%">Select Year: <?php echo $this->Form->input('', array('type' => 'select', 'div'=>false, 'label' => false, 'name' => 'year', 'id' => 'selectedYear', 'options' => $yearArray, 'value' => $holiYear)); ?></td>
        <td style="text-align:right" class="alignLeft">Select Type: <?php echo $this->Form->input('', array('type' => 'select', 'div'=>false, 'label' => false, 'name' => 'holiday_type', 'id' => 'holidayType', 'options' => $holidayType, 'value' => $this->params['pass']['1'])); ?></td>
    </tr>
    <tr>
        <td colspan="2"> 
            <table style="width:none !important" class="table_formats" align="left">
                <tr class="row_title">
                    <td>Date Of Holiday</td>
                    <td>Name of Holiday</td>
                    <!--<td>Type of Holiday</td>-->
                    <td>Action</td> 
                </tr> 
                <tbody id="selPatient" >
                    <?php
                    if (!empty($holidayData)) {
                        foreach ($holidayData as $mKey => $monthVal) {
                            foreach ($monthVal as $dKey => $dayVal) {
                                foreach ($dayVal as $hKey => $holiday) {
                                    ?>
                                    <tr class="table_row" id="row_<?php echo ++$cnt; ?>">
                                        <td><?php
                                            echo $this->Form->input('', array('name' => "data[Holiday][$cnt][holiday_date]", 'type' => 'text',
                                                'id' => "holiday_date_$cnt", 'label' => false, 'div' => false, 'style' => 'float:left', 'readonly' => 'readonly',
                                                'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  holiday_date',
                                                'value' => $dKey . "/" . $mKey . '/' . $holiYear));
                                            ?>
                                        </td>
                                        <td><?php
                                            echo $this->Form->input('', array('type' => 'text', 'label' => false, 'name' => "data[Holiday][$cnt][holiday_name]", 'class' => 'textBoxExpnd pname validate[required,custom[mandatory-enter]]',
                                                'placeholder' => "Enter Name", 'limit' => $admittotal, 'autoComplete' => 'off', 'value' => trim($holiday),
                                                'id' => "holiday_name_$cnt", 'div' => false));
                                            ?>
                                        </td>
<!--                                        <td><?php echo $this->Form->input('', array('type' => 'select', 'label' => false, 'name' => "data[Holiday][$cnt][holiday_type]", 'class' => 'textBoxExpnd holiday_type validate[required,custom[mandatory-select]]',
                                                'autoComplete' => 'off', 'options' => $holidayType, 'id' => "holiday_type_$cnt", 'div' => false));
                                            ?>
                                        </td>-->
                                        <td>
                                            <?php echo $this->Html->image('icons/cross.png', array('id' => "removePatient_$cnt", 'class' => 'removePatients', 'title' => 'Remove Current Row', 'style' => 'float:left')) ?>
                                        </td> 
                                        <?php
                                        }
                                    }
                                }
                            } else {
                                $cnt = 1;
                                ?>
                        <tr id="row_1" class="prevRow table_row"  > 
                            <td><?php
                            echo $this->Form->input('', array('name' => "data[Holiday][1][holiday_date]", 'type' => 'text',
                                'id' => "holiday_date_1", 'label' => false, 'div' => false, 'style' => 'float:left', 'readonly' => 'readonly',
                                'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  holiday_date',
                                'value' => ''));
                            ?>
                            </td>
                            <td><?php
                            echo $this->Form->input('', array('type' => 'text', 'label' => false, 'name' => "data[Holiday][1][holiday_name]", 'class' => 'textBoxExpnd pname validate[required,custom[mandatory-enter]]',
                                'placeholder' => "Enter Name", 'limit' => $admittotal, 'autoComplete' => 'off',
                                'id' => "holiday_name_1", 'div' => false));
                            ?>
                            </td>
<!--                            <td><?php echo $this->Form->input('', array('type' => 'select', 'label' => false, 'name' => "data[Holiday][1][holiday_type]", 'class' => 'textBoxExpnd holiday_type validate[required,custom[mandatory-select]]',
                                'autoComplete' => 'off', 'options' => $holidayType, 'id' => "holiday_type_1", 'div' => false));
                            ?>
                            </td>-->
                            <td>
    <?php echo $this->Html->image('icons/cross.png', array('id' => "removePatient_$cnt", 'class' => 'removePatients', 'title' => 'Remove Current Row', 'style' => 'float:left')) ?>
                            </td> 
                        </tr>  
<?php } ?>
                </tbody>
                <tr>
                    <td colspan="4">
                        <span>
                            <input name="" type="button" value="Add More Holiday" class="blueBtn addMorePatients" style="float:left"/>  
<?php echo $this->Form->submit('Submit', array('id' => 'submit', 'class' => 'blueBtn','id'=>'submitBtn' ,'style' => 'float:right')); ?>
                        </span>
                    </td>
                </tr>
            </table>  
        </td>
    </tr> 
</table>
<?php echo $this->Form->end(); ?>
<?php echo $this->Form->hidden('', array('id' => 'no_of_fields', 'value' => $cnt)) ?>
<script>

    var holiYear = '<?php echo $holiYear; ?>';

    $(document).on('change', '#selectedYear, #holidayType', function () {
        holiYear = $("#selectedYear").val();
        var holiType = $("#holidayType").val();
        window.location.href = ("<?php echo $this->Html->url(array('action' => 'holiday')); ?>" + '/' + holiYear + '/'+ holiType);
    });

    $(document).ready(function () { 
        counter = "<?php echo $i; ?>";
        dcount = $('#loopCount').val();
        selectedYear = $("#selectedYear").val();

        $(".holiday_date").datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: holiYear + ':' + holiYear,
            dateFormat: 'dd/mm/yy'
        });
    });

    $(document).on('click', '.removePatients', function () {
        var id = $(this).attr('id');
        var newId = id.split("_");
        var count = 0;
        $(".table_row").each(function(){
            count++;
        });
        if(count == '1'){
            alert("Could not delete single record!");
            return false;
        }
        $("#row_" + newId[1]).remove();
    });

    var holidayType = $.parseJSON('<?php echo json_encode($holidayType); ?>');
    $(document).on('click', '.addMorePatients', function () {
        var counter = parseInt($("#no_of_fields").val()) + 1;
        var field = '';
        field += '<tr id="row_' + counter + '" class="table_row">';
        field += '<td><input id="holiday_date_' + counter + '" class="validate[required,custom[mandatory-date]] textBoxExpnd holiday_date" type="text" readonly="readonly" name="data[Holiday][' + counter + '][holiday_date]"></td>'
        field += '<td><input type="text" id="holiday_name' + counter + '" autocomplete="off" placeholder="Enter Name" class="textBoxExpnd pname validate[required,custom[mandatory-enter]]" name="data[Holiday][' + counter + '][holiday_name]"></td>';
        //field += '<td><select id="holiday_type_' + counter + '" name="data[Holiday][' + counter + '][holiday_type]" class="validate[required,custom[mandatory-select]] textBoxExpnd holiday_type"></select></td>';
        field += '<td><a href="javascript:void(0);" id="removePatient_' + counter + '" class="removePatients" alt="Remove" style="float:left" title="Remove Current Row"><?php echo $this->Html->image('icons/cross.png', array('title' => 'Remove Current Row', 'style' => 'float:left')) ?></a></td>';
        field += "</tr>"; 
        
        $("#selPatient").append(field);
        
        $("#holiday_type_"+counter+" option").remove(); 
        $.each(holidayType, function(id,value){
                $("#holiday_type_"+counter).append( "<option value='"+id+"'>"+value+"</option>" ); 
        });
        
        $("#no_of_fields").val(counter);

        $(".holiday_date").datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: holiYear + ':' + holiYear,
            dateFormat: 'dd/mm/yy'
        });
    });

    $("#submitBtn").click(function(){ 
        var valid=jQuery("#holiday").validationEngine('validate');
        if(valid == true){
            $(this).hide();
        }else{
            return false;
        }
    });
</script>