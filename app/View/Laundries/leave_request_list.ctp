<?php   echo $this->Html->script(array('jquery.blockUI'));
        echo $this->Html->script(array('jquery.fancybox'));
	echo $this->Html->css(array('jquery.fancybox'));  ?> 
<script>
    var validate = false;
        jQuery(document).ready(function(){ 
    }); 
</script>  
<style>
    label{
        float:none;
        margin-right: 0px;
        padding-top: opx;
        width: none;
    }
</style>
<div class="inner_title">  
    <?php echo $this->element('navigation_menu',array('pageAction'=>'HR'));//echo $this->element('duty_roster_menu');?>
    <h3>Approve Leave Request</h3> 
</div> 
<div class="clr ht5"></div>   

<table class="table_format" cellspacing="1">
    <thead>
        <tr class="row_title">
            <td style="text-align:center"><?php echo __('Sr.No'); ?></td>
            <td><?php echo __('User Name'); ?></td>
            <td style="text-align:center"><?php echo __('Location'); ?></td>
            <td style="text-align:center"><?php echo __('Leave Type'); ?></td>
            <!--<td style="text-align:center"><?php echo __('Leave Date'); ?></td>-->
            <td style="text-align:center"><?php echo __('No of Days'); ?></td>
            <td style="text-align:center"><?php echo __('Status'); ?></td>
            <td><?php echo __('Action'); ?></td>
        </tr>
    </thead>
    <tbody> 
        <?php if(!empty($requestData)) {  
            foreach($requestData as $key => $val){ ?>
        <tr class="<?php if($key%2!=0) echo 'row_gray'; ?>">
            <td style="text-align:center"><?php echo ++$key; ?></td>
            <td><?php echo $val[0]['full_name']; ?></td>
            <td style="text-align:center"><?php echo $val['Location']['name']; ?></td>
            <td style="text-align:center"><?php echo $leaveTypes[$val['LeaveApproval']['leave_type']]; ?></td>
            <!--<td style="text-align:center"><?php echo $this->DateFormat->formatDate2Local($val['LeaveApproval']['leave_from'],Configure::read('date_format'),false); echo !empty($val['LeaveApproval']['leave_to'])? " - ".$this->DateFormat->formatDate2Local($val['LeaveApproval']['leave_to'],Configure::read('date_format'),false) : ''; ?></td>-->
            <td style="text-align:center"><?php echo $val[0]['batch_count'];//echo empty($val['LeaveApproval']['leave_to']) ? '1' : $this->DateFormat->getNoOfDays($val['LeaveApproval']['leave_to'],$val['LeaveApproval']['leave_from']); ?></td>
            <td style="text-align:center"><?php 
                if($val[0]['tot'] == $val[0]['batch_count']){
                    $status = "Approved";
                }else if($val[0]['tot'] != '0' && $val[0]['tot'] == 2*($val[0]['batch_count'])){
                    $status = 'Cancelled';
                }else if($val[0]['tot'] == 0){
                    $status = "Pending";
                }else{
                    $status = "Partial";
                }
                echo $status;
            //$status = $val['LeaveApproval']['is_approved']; echo Configure::read('leaveApprovalStatus')[$status]; ?></td>
            <td><?php 
                echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title' => __('View', true), 'alt' => __('View', true))), array('action' => 'viewLeaveRequest', $val['LeaveApproval']['batch_identifier']), array('escape' => false,'id'=>'viewRequest','batch'=>$val['LeaveApproval']['batch_identifier']));  
                if($status =='0' ){
                    echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true), 'alt' => __('Edit', true))), array('action' => 'requestLeaveApproval', $val['LeaveApproval']['batch_identifier']), array('escape' => false));  
                /*}
                if($status != '1'){*/
                    echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title' => __('Delete', true), 'alt' => __('Delete', true))), array('action' => 'deleteLeaveRequest', $val['LeaveApproval']['batch_identifier'], $this->params['action']), array('escape' => false),__('Are you sure?', true));   
                }
            ?>
        </td> 
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td colspan="7" align="center"><strong>No Record Found!</strong></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $("#from_date, #to_date").datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1990', 	 
            dateFormat:'dd/mm/yy' 
        });   
    });  
    
    $("#user_name").autocomplete({
        source: "<?php echo $this->Html->url(array("controller" => "Users", "action" => "getUserList",'admin' => false,"plugin"=>false)); ?>",
        minLength: 1, 
        select: function( event, ui ) { 
            $("#user_id").val(ui.item.id);
        },
            messages: {
            noResults: '',
            results: function() {}
         }	
    }); 
    
    $(".blueBtn").click(function(){
        var valid = $("#leave_approval_form").validationEngine('validate'); 
        if(valid == false){
            return false; 
        } 
    });
    
    $(document).on('click',"#viewRequest",function(event){  
        event.preventDefault();
        $.fancybox({ 
            'width' : '80%',
            'height' : '100%',
            'autoScale' : true,
            'transitionIn' : 'fade',
            'transitionOut' : 'fade',
            'type' : 'iframe',
            'hideOnOverlayClick':false,
            'showCloseButton':true,
            'onClosed':function(){
                console.log("GF");
                window.location.reload();
            },
            'href' : "<?php echo $this->Html->url(array("action" =>"viewLeaveRequest","admin"=>false)); ?>"+'/'+$(this).attr('batch'),
	 });
    });
</script>