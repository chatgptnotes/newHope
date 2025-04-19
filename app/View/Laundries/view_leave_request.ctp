<?php  //echo $this->Html->script(array('jquery.blockUI')); ?>
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
    <?php //echo $this->element('duty_roster_menu');?>
    <h3>Request Leave Approval</h3> 
</div> 
<div class="clr ht5"></div>   
<?php echo $this->Form->create(''); ?>
<table width="100%" class="formFull" cellspacing="0" cellpadding="0" style="padding:20px;"> 
    <tr>
        <td align="left" width="15%"><b><?php echo __('User Name : '); ?></b></td>
        <td align="left"><?php echo $requestData[0][0]['full_name']; ?></td>
    </tr> 
    
    <tr>
        <td align="left"><b><?php echo __('Leave Type : '); ?></b></td>
        <td align="left"><?php echo $leaveTypes[$requestData[0]['LeaveApproval']['leave_type']]; ?></td>
    </tr> 
     
    <?php if(isset($requestData['LeaveApproval']['leave_to']) && !empty($requestData['LeaveApproval']['leave_to'])) { ?>
        <tr id="to_date_tr" style="display:<?php echo $display; ?>;">
            <td align="left"><b><?php echo __('Date To : '); ?></b></td>
            <td align="left"><?php echo $this->DateFormat->formatDate2Local($requestData['LeaveApproval']['leave_to'],Configure::read('date_format'),false); ?></td>
        </tr>
    <?php } ?> 
    <tr>
        <td align="left"><b><?php echo __('Subject : '); ?></b></td>
        <td align="left"><?php echo $requestData[0]['LeaveApproval']['subject'] ; ?></td>
    </tr>
    <tr>
        <td align="left" valign="top"><b><?php echo __('Message : '); ?></b></td> 
        <td align="left"><?php echo nl2br($requestData[0]['LeaveApproval']['message'])  ; ?></td>
    </tr>  
    <tr>
        <td align="left"><b><?php echo __('Leave Date : '); ?></b></td>
        <td align="left"><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>'check All','div'=>false,'id'=>'masterCheck')); ?>
        </td> 
    </tr> 
    <?php foreach($requestData as $key => $val){ $leaveApprovalId = $val['LeaveApproval']['id']; 
    $checked=''; 
    if($val['LeaveApproval']['is_approved'] == '1'){
        $checked = 'checked';
    }
?>
    <tr>
        <td></td>
        <td><?php echo $this->Form->input('',array('name'=>"data[leave_approval_id][$leaveApprovalId]",'type'=>'checkbox',
            'class'=>'subCheck','checked'=>$checked,'id'=>'subCheck_'.$key,'div'=>false,'label'=>$this->DateFormat->formatDate2Local($val['LeaveApproval']['leave_from'],Configure::read('date_format'),false)." (<i>".date("l",  strtotime($val['LeaveApproval']['leave_from']))."</i>)")); ?></td>
    </tr>
    <?php } ?>
</table> 
<table>
    <tr>
        <td colspan="2" align="center">
            <?php echo $this->Form->submit(__('Approve Request'),/*array('action'=>'approveRequest',$requestData['LeaveApproval']['id'],'1'),*/
                    array('div'=>false,'label'=>false,'class'=>'blueBtn approveRequest')); ?>
            <?php echo $this->Form->submit(__('Cancel Request'),/*array('action'=>'approveRequest',$requestData['LeaveApproval']['id'],'2'),*/
                    array('div'=>false,'label'=>false,'class'=>'grayBtn cancelRequest','name'=>'cancel')); ?>
            <?php //echo $this->Html->link(__('Back'),array('action'=>'leaveRequestList'),array('type'=>'reset','div'=>false,'label'=>false,'class'=>'blueBtn')); ?>
        </td>
    </tr>  
</table>
<?php echo $this->Form->end(); ?>

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
    
    $("#masterCheck").click(function(){
        if($(this).is(":checked") == true){
            $(".subCheck").each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $(".subCheck").each(function(){
                $(this).prop('checked',false);
            });
        }
    });
    
    $(".cancelRequest").click(function(){
        var result = confirm("Are you sure to cancel the approval?");
        if(result == false){ 
            return false; 
        }  
        $('#busy-indicator').show();
    });
    
    $(".approveRequest").click(function(){
        var count = 0;
        $(".subCheck").each(function(){
            if($(this).is(':checked') == true){
                count++;
            }
        });
        if(count == 0){
            alert("Please select atleast one date to approve the request");
            return false;
        }
        $('#busy-indicator').show();
    });
</script>