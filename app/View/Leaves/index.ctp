 <?php /*echo $this->Html->script(array(
    "jplot/jquery.jqplot.min.js",
    "jplot/jqplot.barRenderer.min.js",  
    "jplot/jqplot.categoryAxisRenderer.min.js" ,
    "jplot/jqplot.pointLabels.min.js"
)); */?>
 <?php echo $this->Html->css(array("jquery.jqplot.min.css")); ?>

<div class="inner_title">
    <?php echo $this->element('navigation_menu',array('pageAction'=>'HR')); ?>
    <h3><?php echo "Leave Management" ?></h3>
    <span>
        <?php echo $this->Html->link(__('Leave Configuration'),array('action'=>'leaveConfigure'),array('class'=>'blueBtn','div'=>false,'label'=>false,'escape'=>false,'alt'=>'Leave Configuration','title'=>'Leave Configuration')); ?>
    </span>
</div>
<!--<div style="width:100%">
    <div id="monthlyLeaveTaken" style="margin-top:20px; margin-bottom:20px; float:left; margin-left:20px; width:46%; height:300px;"></div>
    <div id="todayLeaveTaken" style="margin-top:20px; margin-bottom:20px; float:right; margin-left:20px; width:46%; height:300px;"></div>
</div> -->
<table class="table_format" width="100%">
    <caption><?php echo __('Leave Details'); ?></caption>
    <thead>
        <tr class="row_title">
            <td><?php echo __('Sr.No'); ?></td>
            <td><?php echo __('Name'); ?></td>
            <td><?php echo __('Designation'); ?></td>
            <td><?php echo __('Location'); ?></td>
            <td><?php echo __('Leave Type'); ?></td>
            <td><?php echo __('Date'); ?></td>
            <td><?php echo __('Status'); ?></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($leaveData as $key => $val){ ?>
            <tr>
                <td><?php echo ++$key; ?></td>
                <td><?php echo $val[0]['full_name']; ?></td> 
                <td><?php echo $val['Role']['name']; ?></td> 
                <td><?php echo $val['Location']['name']; ?></td> 
                <td><?php echo $val['LeaveApproval']['leave_type']; ?></td> 
                <td><?php echo $this->DateFormat->formatDate2Local($val['LeaveApproval']['leave_from'],Configure::read('date_format'),false); ?></td> 
                <td><?php if($val['LeaveApproval']['is_approved'] == "1") { 
                    echo "Approved"; 
                } else if($val['LeaveApproval']['is_approved'] == "2"){
                    echo "Cancelled"; 
                }else{
                    echo "Pending"; 
                } ?></td>  
            </tr>
        <?php } ?>
    </tbody>
</table> 

<script>
$(document).ready(function(){
    /*$.ajax({       
        url: "<?php echo $this->Html->url(array("controller" => "Leaves", "action" => "getAllPaidLeaves", "admin" => false)); ?>", 
        success: function(data){   
            var obj = $.parseJSON(data); 
            var leaveType = new Array;
            var monthValues = new Array;
            var todayValues = new Array;
            $.each(obj.monthCount,function(key,value){
                leaveType.push(key);
                monthValues.push(value); 
            }); 
            $.each(obj.todayCount,function(key,value){ 
                todayValues.push(value); 
            }); 
            plot1 = $.jqplot('monthlyLeaveTaken', [monthValues], {
                seriesDefaults:{
                    renderer:$.jqplot.BarRenderer,
                    pointLabels: { show: true }
                },
                title: 'Leave Taken By Type (All Employee)',
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: leaveType
                    }
                },
                highlighter: { show: false }
            });
            
            plot2 = $.jqplot('todayLeaveTaken', [todayValues], {
                seriesDefaults:{
                    renderer:$.jqplot.BarRenderer,
                    pointLabels: { show: true }
                },
                title: 'Today Leave Taken',
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: leaveType
                    }
                },
                highlighter: { show: false }
            });
        } 
    });  */
 });
 </script>