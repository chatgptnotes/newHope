<style>
    .monthTd:hover{
        background-color: white !important;
        color: black !important;
        cursor: pointer;
    } 
    .row_title td.setActive {
        background-color: white !important;
        color: black !important; 
    }
    label{
        float:none;
        margin-right: 0px;
        padding-top: opx;
        width: none;
    }
    #userContainer{
        position: relative; float: left; width: 80%;
    }
    #attendedUsers{width: 20%; float: right; overflow-y: scroll; height: 110px;} 
    #payRollContainer{width : 80% ; height: 320px; overflow-y: scroll;}
</style>
<?php echo $this->Html->script(array('jquery.blockUI')); ?>
<div class="inner_title">
    <?php echo $this->element('navigation_menu', array('pageAction' => 'HR')); ?>
    <h3>&nbsp; <?php echo __('Doctor Share', true); ?></h3>
    <span><?php echo $this->Form->button('Process Doctor Payroll', array('')); ?></span>
</div>
<div class="clr ht5"></div>     
<?php $monthArray = array('01' => 'Dec-Jan', '02' => 'Jan-Feb', '03' => 'Feb-Mar', '04' => 'Mar-Apr', '05' => 'Apr-May', '06' => 'May-Jun',
    '07' => 'Jun-Jul', '08' => 'Jul-Aug', '09' => 'Aug-Sep', '10' => 'Sep-Oct', '11' => 'Oct-Nov', '12' => 'Nov-Dec');
?>
<?php for ($i = date('Y') - 2; $i <= date('Y'); $i++) { ?>
    <?php $yearArray[$i] = $i; ?>
<?php } ?>
<?php echo $this->Form->create('', array('type' => 'get')); ?>
<table class="table_format" align="center" cellspacing="0" cellpadding="0">
    <tr class="row_title">
        <td class="alignRight"><?php echo __('Year :'); ?> </td>
        <td class="alignLeft"><?php echo $this->Form->input('', array('type' => 'select', 'id' => 'year', 'options' => $yearArray, 'div' => false, 'label' => false, 'name' => 'year', 'value' => $this->request->query['year'] ? $this->request->query['year'] : date('Y'))); ?> </td>
        <td class="alignRight"><?php echo __('User : '); ?></td>
        <td class="alignLeft"><?php echo $this->Form->input('', array('type' => 'text', 'id' => 'user_name', 'class' => 'textBoxExpnd', 'div' => false, 'label' => false, 'name' => 'user_name', 'value' => $this->request->query['user_name']));
echo $this->Form->hidden('', array('id' => 'user_id', 'name' => 'user_id', 'value' => $userId = $this->request->query['user_id']));
echo $this->Form->hidden('', array('id' => 'department_id', 'name' => 'department_id', 'value' => $departmentId = $this->request->query['department_id']));
?> </td>
        <td class="alignLeft"><?php echo $this->Form->submit(__('Submit'), array('class' => 'blueBtn', 'div' => false, 'label' => false, 'value' => $this->request->query['user_id'])); ?>  </td>
        <td class="alignLeft"><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action' => 'viewAttendance'), array('escape' => false, 'title' => 'refresh', 'class' => 'loading')); ?></td>
    </tr>
</table> 
<?php echo $this->Form->end(); ?>

<?php if (!empty($this->request->query['user_id'])) { ?> 
    <!--<div id="hero-graph" style="margin-bottom: 30px; margin-top: 30px; height: 230px;"></div>--> 
    <table class="table_format">
        <tr class="row_title" height="40px">
            <?php foreach ($monthArray as $key => $val) {
                $class = '';
                if ($key == date("m")) {
                    $class = "setActive";
                } ?>
                <td width="8%" class="monthTd <?php echo $class; ?>" id="monthTd_<?php echo $key; ?>" title="Click to view the details of <?php echo $val; ?>"><?php echo $val; ?></td>
    <?php } ?>
        </tr>
    </table> 
    <div class="clr ht5"></div>
    <div id="shareContainer"></div>
    <?php } ?>
<script class="code" type="text/javascript">
    var userId = "<?php echo $userId; ?>";
    var departmentId = "<?php echo $departmentId; ?>";
    var curDate = '';
    $(document).ready(function () {
        $("#user_name").autocomplete({
            // source: "<?php //echo $this->Html->url(array("controller" => "App", "action" => "advanceMultipleAutocomplete","User","full_name","no","null","null","is_doctor=1&is_active=1&paid_through_system=1&attendance_track_system=1",'admin' => false,"plugin"=>false)); ?>",
            source: "<?php echo $this->Html->url(array('controller' => 'HR', 'action' => 'searchInHouseDoctor')); ?>",
            minLength: 1,
            select: function (event, ui) {
                $("#user_id").val(ui.item.id);
                $("#department_id").val(ui.item.department_id);
            },
            messages: {
                noResults: '',
                results: function () {
                }
            }
        });

        if (userId != '' && userId != undefined) {
            var dateSearch = $("#year").val() + "" + '<?php echo date("-m-d"); ?>';
            getAllDetails(userId, dateSearch, departmentId);
        }

        $(document).on('click', '.monthTd', function () {
            var monthCount = $(this).attr('id').split("_")[1];
            var dateSearch = $("#year").val() + "-" + monthCount + '<?php echo date("-d"); ?>';
            $(".monthTd").removeClass('setActive');
            $("#monthTd_" + monthCount).addClass('setActive');
            getAllDetails(userId, dateSearch, departmentId);
        });
    });



    function getAllDetails(userId, dateSearch, departmentId, userName) {
        $.ajax({
            url: "<?php echo $this->Html->url(array("controller" => "HR", "action" => "ajaxMonthlyShare", "admin" => false)); ?>" + '/' + userId + '/' + dateSearch + '/' + departmentId,
            beforeSend: function () {
                loading();
            },
            success: function (data) {
                if(userName)
                    $('#user_name').val(userName);
                $('#user_id').val(userId);
                $('#department_id').val(departmentId);
                $("#shareContainer").html(data);
                onCompleteRequest();
                curDate = dateSearch;
            }
        });
       /* $.ajax({
            url: "<?php echo $this->Html->url(array("controller" => "HR", "action" => "getDoctorsWithShare", "admin" => false)); ?>" + '/' + userId + '/' + dateSearch,
            beforeSend: function () {
                loading();
            },
            success: function (data) {
                $("#shareContainer").html(data);
                onCompleteRequest();
                curDate = dateSearch;
            }
        });*/
    }

    function loading() {
        $('#shareContainer').block({
            message: '',
            css: {
                padding: '5px 0px 5px 18px',
                border: 'none',
                padding: '15px',
                        backgroundColor: '#000000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                color: '#fff',
                'text-align': 'left'
            },
            overlayCSS: {backgroundColor: '#00000'}
        });
    }

    function onCompleteRequest() {
        $('#shareContainer').unblock();
    }

</script>