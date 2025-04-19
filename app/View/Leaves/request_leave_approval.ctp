<?php  echo $this->Html->script(array('jquery.blockUI')); 
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
    <?php echo $this->element('navigation_menu',array('pageAction'=>'HR'));?>
    <h3>Request Leave Approval</h3> 
</div> 
<div class="clr ht5"></div>  
<?php echo $this->Form->create('LeaveApproval',array('id'=>'leave_approval_form')); ?>
<table width="100%" class="table_format" width="100%" cellspacing="0" cellpadding="0"> 
    <?php if(!empty($requestData[0]['LeaveApproval']['id'])){
        $userName = $requestData[0][0]['full_name'];
        $userId = $requestData[0]['User']['id'];
    } else {
        $userName = $loginUserData['User']['full_name'];
        $userId = $loginUserData['User']['id'];
    }
?>
    <caption><h3><?php echo __('Add Leave Request'); ?></h3></caption>
    <tr>
        <td class="alignRight" width="25%"><?php echo __('User Name : '); ?></td>
        <td class="alignLeft"><?php echo $this->Form->input('',array('type'=>'text','name'=>'user_name','value'=>$userName,'readonly'=>'readonly',
            'div'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','id'=>'user_name','style'=>'width:200px;'));
        echo $this->Form->hidden('',array('name'=>'user_id','id'=>'user_id','value'=>$userId)); ?></td>
    </tr>
    <tr>
        <td class="alignRight"><?php echo __('Leave Type : '); ?></td>
        <td class="alignLeft"><?php echo $this->Form->input('',array('type'=>'select','name'=>'leave_type','value'=>$requestData[0]['LeaveApproval']['leave_type'],'options'=>$leaveTypes,'empty'=>'Please Select',
            'div'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','id'=>'leave_type','style'=>'width:200px;'));
         ?></td>
    </tr>
    <?php if(count($requestData)>1) { 
        $display = '';
        $checked = 'checked';
        $lastData = end($requestData);
        $leave_to = $lastData['LeaveApproval']['leave_from']; 
    }else{
        $display = 'none';
        $checked = '';
    } ?>
    <tr>
        <td class="alignRight" valign="top"><?php echo __('Date from : '); ?></td>
        <td class="alignLeft">
            <span id="dateFromTd">
                <?php if(!empty($requestData[0]['LeaveApproval']['id'])){ ?>
                    <?php //foreach($requestData as $key => $val) { ?>
                    <span id="dateID_<?php echo $cnt = ++$key; ?>" class="dateSpan">
                    <?php 
                        echo $this->Form->input('',array('type'=>'text','id'=>'fromDate_'.$cnt,'value'=>$this->DateFormat->formatDate2Local($requestData[0]['LeaveApproval']['leave_from'],Configure::read('date_format'),false),
                        'name'=>"data[leave_from]",'div'=>false,'label'=>false,'readonly'=>"readonly" ,'class'=>'textBoxExpnd validate[required,custom[mandatory-date]] datePick'));  
                       // echo $this->Html->image('icons/delete.png',array('div'=>false,'label'=>false,'escape'=>'false','class'=>'removeDate','id'=>'remove_'.$cnt,'style'=>'padding-right:10px'));?>
                    </span>
                    <?php// } ?>
                <?php } else { $cnt = 1; ?>
                <span id="dateID_1" class="dateSpan">
            <?php 
                echo $this->Form->input('',array('type'=>'text','id'=>'fromDate_'.$cnt,'value'=>'',//'value'=>$this->DateFormat->formatDate2Local($requestData['LeaveApproval']['leave_from'],Configure::read('date_format'),false),
                'name'=>"data[leave_from]",'div'=>false,'label'=>false,'readonly'=>"readonly" ,'class'=>'textBoxExpnd validate[required,custom[mandatory-date]] datePick'));  
                //echo $this->Html->image('icons/delete.png',array('div'=>false,'label'=>false,'escape'=>'false','class'=>'removeDate','id'=>'remove_'.$cnt,'style'=>'padding-right:10px'));?>
                </span>
                <?php } ?>
            </span>
            <span>
                <?php //echo $this->Html->image('icons/plus_6.png',array('div'=>false,'label'=>false,'escape'=>false,'onclick'=>"addMore()",'style'=>'padding:5px;')); ?>
            </span>
        <?php echo $this->Form->input('',array('name'=>'is_multiple_day','type'=>'checkbox','checked'=>$checked,'id'=>'moreThanOneDay','label'=>'(<i>More than one day</i>)','div'=>false,
            'onclick'=>"($(this).is(':checked') == true) ? $('#to_date_tr').show() : $('#to_date_tr').hide();" )); ?>
        </td>
    </tr> 
   <tr id="to_date_tr" style="display:<?php echo $display; ?>;">
        <td class="alignRight"><?php echo __('Date To : '); ?></td>
        <td align="left"><?php echo $this->Form->input('',array('type'=>'text','id'=>'to_date','value'=>$this->DateFormat->formatDate2Local($leave_to,Configure::read('date_format'),false),
            'name'=>'leave_to','div'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-date]]')); ?></td>
    </tr>
    <tr>
        <td class="alignRight"><?php echo __('Subject : '); ?></td>
        <td class="alignLeft"><?php echo $this->Form->input('',array('type'=>'text','name'=>'subject','value'=>$requestData[0]['LeaveApproval']['subject'],
            'div'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]')); ?></td>
    </tr>
    <tr>
        <td class="alignRight" valign="top"><?php echo __('Message : '); ?></td> 
        <td class="alignLeft"><?php echo $this->Form->input('',array('type'=>'textarea','name'=>'message','value'=>$requestData[0]['LeaveApproval']['message'],
            'div'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','id'=>'leave_message')); ?></td>
    </tr>  
    <tr>
        <td colspan="2" align="center">
            <?php echo $this->Form->submit(__('Submit'),array('div'=>false,'label'=>false,'class'=>'blueBtn submitButton')); ?>
            <?php echo $this->Html->link(__('Cancel'),array('action'=>'requestLeaveApproval'),array('div'=>false,'label'=>false,'class'=>'grayBtn')); ?>
        </td>
    </tr>  
</table> 
<?php echo $this->Form->end(); ?>
 

<div class="inner_title clr ht5"></div>  
<table width="100%" class="table_format" cellspacing="1">
    <caption><h3>Previous Request</h3> </caption>
    <thead>
        <tr class="row_title">
            <td><?php echo __('Sr.No'); ?></td> 
            <td><?php echo __('Location'); ?></td>
            <td><?php echo __('Leave Type'); ?></td>
            <!--<td style="text-align:center"><?php echo __('Leave Date'); ?></td>-->
            <td><?php echo __('No of Days'); ?></td>
            <td><?php echo __('Created Date'); ?></td>
            <td><?php echo __('Status'); ?></td>
            <td><?php echo __('Action'); ?></td> 
        </tr>
    </thead>
    <tbody> 
        <?php if(!empty($requisitionList)) { 
            foreach($requisitionList as $key => $val){ ?>
        <tr class="<?php if($key%2!=0) echo 'row_gray'; ?>">
            <td style="text-align:center"><?php echo ++$key; ?></td> 
            <td style="text-align:center"><?php echo $val['Location']['name']; ?></td> 
            <td style="text-align:center"><?php echo $leaveTypes[$val['LeaveApproval']['leave_type']]; ?></td> 
            <!--<td style="text-align:center"><?php echo $this->DateFormat->formatDate2Local($val['LeaveApproval']['leave_from'],Configure::read('date_format'),false); echo !empty($val['LeaveApproval']['leave_to'])? " - ".$this->DateFormat->formatDate2Local($val['LeaveApproval']['leave_to'],Configure::read('date_format'),false) : ''; ?></td>-->
            <!--<td style="text-align:center"><?php echo empty($val['LeaveApproval']['leave_to']) ? '1' : $this->DateFormat->getNoOfDays($val['LeaveApproval']['leave_to'],$val['LeaveApproval']['leave_from']); ?></td>-->
            <td style="text-align:center"><?php echo $val[0]['batch_count']; ?></td>
            <td style="text-align:center"><?php echo $this->DateFormat->formatDate2Local($val['LeaveApproval']['create_time'],Configure::read('date_format'),false);  ?></td>
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
            <td style="text-align:center"><?php 
                //echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title' => __('View', true), 'alt' => __('View', true),'style'=>'float:none;')), array('action' => 'viewLeaveRequest', $val['LeaveApproval']['batch_identifier']), array('escape' => false,'id'=>'viewRequest','batch'=>$val['LeaveApproval']['batch_identifier']));  
                //echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title' => __('View', true), 'alt' => __('View', true))), array('action' => 'viewLeaveRequest', $val['LeaveApproval']['batch_identifier']), array('escape' => false));  
                if($status == "Pending"){ 
                    echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true), 'alt' => __('Edit', true),'style'=>'float:none;')), array('action' => 'requestLeaveApproval', $val['LeaveApproval']['batch_identifier']), array('escape' => false));  
                    echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title' => __('Delete', true), 'alt' => __('Delete', true),'style'=>'float:none;')), array('action' => 'deleteLeaveRequest', $val['LeaveApproval']['batch_identifier'], $this->params['action']), array('escape' => false),__('Are you sure?', true));   
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
<div class="clr ht5"></div>  
<script>
    $(document).ready(function(){
        $(".datePick, #from_date, #to_date").datepicker({
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
    
    $(".submitButton").click(function(){
        var valid = $("#leave_approval_form").validationEngine('validate'); 
        if(valid == false){
            return false; 
        } 
        if( $("#fromDate_1").val() == '' || $("#fromDate_1").val() == undefined){
            alert("Please select Leave date");
            return false;
        } 
        $(this).hide();
    });
    
    var count = '<?php echo $cnt; ?>';
    function addMore(){
        count++;
        var field = '<span id="dateID_'+count+'" class="dateSpan">';
            field += '<input type="text" name="data[leave_from]['+count+']" id="fromDate_'+count+'" readonly="readonly" class="datePick textBoxExpnd validate[required,custom[mandatory-select]]"/>';
            field += '<a href="javascript:void(0);" id="remove_'+count+'" class="removeDate">';
            field += '<?php echo $this->Html->image('icons/delete.png',array('div'=>false,'label'=>false,'escape'=>'false','style'=>'padding-right:10px')); ?>';
            field += '</a>'; 
            field += '</span>';
        $("#dateFromTd").append(field);
        
        $(".datePick").datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1990', 	 
            dateFormat:'dd/mm/yy' 
        }); 
    }
    
    $(document).on('click','.removeDate',function(){
        var id = $(this).attr('id').split("_")[1];
        var totalSpan = 0;
        $(".dateSpan").each(function(){
            totalSpan++;
        });
        if(totalSpan == '1'){
            alert('Single record could not delete');
            return false;
        }
        $("#dateID_"+id).remove(); 
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