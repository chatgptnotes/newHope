<?php  echo $this->Html->script(array('jquery.blockUI')); ?>
<script>
    var validate = false;
        jQuery(document).ready(function(){ 
    }); 
</script>  
<div class="inner_title">  
    <?php //echo $this->element('duty_roster_menu');?>
    <h3>Shift Master</h3> 
</div> 
<div class="clr ht5"></div>
<div style="float:left; clear: both">
    <?php echo $this->Html->Link(__('Add New Shift'),'javascript:void(0)',array('escape'=>false,'class'=>'blueBtn add_new_shift','onClick'=>"")); ?>
</div>
<div class="clr ht5"></div>

<?php for ($i = 0; $i <= 23; $i++) {
        for($min = 0; $min <= 59 ; $min+=30){
            $hour = $i >= 10 ? $i : "0" . $i;
            $minute = $min >= 10 ? $min : "0" . $min;
            $time = $hour.":".$minute;
            $timeSlot[$time] = $time;
        }
}?>

<table width="100%" class="formFull" width="100%" cellspacing="0" cellpadding="0">
    <thead>
        <tr class="row_title">
            <th width="5%" style="text-align:center"><?php echo __('Sr.No'); ?></th>
            <th width="20%" style="text-align:center"><?php echo __('Shift Name'); ?></th>
            <th width="20%" style="text-align:center" title="Alias is used to indicate the shift"><?php echo __('Shift Alias'); ?></th>
            <th width="20%" style="text-align:center"><?php echo __('Shift Count'); ?></th>
            <th width="20%" style="text-align:center"><?php echo __('Shift From'); ?></th>
            <th width="20%" style="text-align:center"><?php echo __('Shift To'); ?></th>
            <th width="10%" style="text-align:center"><?php echo __('Is Active'); ?></th>
            <th width="15%" style="text-align:center"><?php echo __('Action'); ?></th>
        </tr>
    </thead>
    <tbody id="tableData">
        <?php if(!empty($results)){ $cnt = 1;?>
        <?php foreach($results as $key => $result): ?>
            <tr id="row_<?php echo $key; ?>" class="<?php if($cnt%2==0) echo $cls = 'row_gray'; else echo $cls = ''; ?>"  height="40px;">
                <td align="center"><?php echo $ct = $cnt++; ?></td>
                <td align="center" class="campaign-signup with-tooltip shiftName" field_no="<?php echo $key; ?>"><?php echo $result['Shift']['name']; ?></td>
                <td align="center" title="Alias is used to indicate the shift" class="shiftAlias" field_no="<?php echo $key; ?>"><?php echo $result['Shift']['alias']; ?></td>
                <td align="center" field_no="<?php echo $key; ?>"><?php echo $result['Shift']['shift_count']; ?></td>
                <td align="center"><?php echo $result['Shift']['from_time']; ?></td>
                <td align="center"><?php echo $result['Shift']['to_time']; ?></td>
                <td align="center"><?php echo $result['Shift']['is_active']=='1'?"YES":"NO"; ?></td>
                <td align="center"><?php echo $this->Html->image('edit-icon.png',array('style'=>'float:none;','div'=>false,'label'=>false,'alt'=>'Edit','title'=>'Edit','class'=>'editShift','field_no'=>$key,'id'=>'edit_'.$key));?></td>
            </tr>
            
            <tr id="hiddenRow_<?php echo $key; ?>" class="hiddenRows <?php echo $cls; ?>" style="display:none;"  height="40px;">
                <td align="center"><?php echo $ct; echo $this->Form->hidden('',array('value'=>$result['Shift']['id'],'id'=>'shiftId_'.$key,'name'=>'shift_id')); ?></td>
                <td align="center"><?php echo $this->Form->input('',array('name'=>'name','div'=>false,'label'=>false,'type'=>'text','value'=>$result['Shift']['name'],'id'=>'shiftName_'.$key,'class'=>'textBoxExpnd shift_name')); ?></td>
                <td align="center"><?php echo $this->Form->input('',array('name'=>'alias','div'=>false,'label'=>false,'type'=>'text','value'=>$result['Shift']['alias'],'id'=>'shiftAlias_'.$key,'class'=>'textBoxExpnd shift_alias')); ?></td>
                <td align="center"><?php echo $this->Form->input('',array('name'=>'shift_count','div'=>false,'label'=>false,'type'=>'number','value'=>$result['Shift']['shift_count'],'id'=>'shiftCount_'.$key,'class'=>'textBoxExpnd shift_count')); ?></td>
                <td align="center"><?php echo $this->Form->input('',array('name'=>'from_time','div'=>false,'label'=>false,'type'=>'select','value'=>$result['Shift']['from_time'],'id'=>'fromTime_'.$key,'options'=>$timeSlot,'empty'=>'Select','class'=>'textBoxExpnd')); ?></td>
                <td align="center"><?php echo $this->Form->input('',array('name'=>'to_time','div'=>false,'label'=>false,'type'=>'select','value'=>$result['Shift']['to_time'],'id'=>'toTime_'.$key,'options'=>$timeSlot,'empty'=>'Select','class'=>'textBoxExpnd')); ?></td>
                <td align="center"><?php echo $this->Form->input('',array('name'=>'is_active','div'=>false,'class'=>'textBoxExpnd','label'=>false,'type'=>'checkbox','hiddenField'=>false,'value'=>$result['Shift']['is_active'],'id'=>'isActive_'.$key,'checked'=>$result['Shift']['is_active']==1?"checked":"",'onclick'=>"if(this.checked){ $(this).val(1); }else{ $(this).val(0); }")); ?></td>
                <td align="center" style="padding:0px;">
                    <table style="padding:0px;">
                        <tr>
                            <td><?php echo $this->Html->image('icons/saveSmall.png',array('div'=>false,'label'=>false,'alt'=>'Update','title'=>'Update','class'=>'saveShift','id'=>'saveShift_'.$key));?></td>
                            <td><?php echo $this->Html->image('icons/delete.png',array('div'=>false,'label'=>false,'alt'=>'Cancel','title'=>'Cancel','id'=>'reset_'.$key,'class'=>'subReset'));?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php } else { ?>
            <tr id="no_record">
                <td colspan="6" align="center"><strong><?php echo __("No Record found!"); ?></strong></td>
            </tr>
        <?php } //end of if else?> 
    </tbody>
</table>



<script>
    var timeSlot = JSON.parse('<?php echo json_encode($timeSlot); ?>');
    var selectedEditFlag = '';
    
    $(document).on('click','.add_new_shift',function(){
        var field = '';
            field += '<tr id="hideRow_-1" class="row_gray">';
            field +=    '<td><input type="hidden" name="shift_id" id="shiftId_-1" value=""/></td>';
            field +=    '<td><input type="text" name="name" class="textBoxExpnd shift_name" id="shiftName_-1" autocomplete="off"/></td>';
            field +=    '<td><input type="text" name="alias" class="textBoxExpnd shift_alias" id="shiftAlias_-1" autocomplete="off"/></td>';
            field +=    '<td><input type="number" name="shift_count" class="textBoxExpnd shift_count" id="shiftCount_-1" autocomplete="off"/></td>';
            field +=    '<td><select type="text" name="from_time" class="textBoxExpnd from" id="fromTime_-1" autocomplete="off"><option value="">Select</option></select></td>';
            field +=    '<td><select type="text" name="to_time" class="textBoxExpnd to" id="toTime_-1" autocomplete="off"><option value="">Select</option></select></td>';
            field +=    '<td><input type="checkbox" name="is_active" class="textBoxExpnd is_active" id="isActive_-1" autocomplete="off" value="0" onclick="if(this.checked){ $(this).val(1); }else{ $(this).val(0); }"/></td>';
            field +=    '<td><table align="center"><tr><td><?php echo $this->Html->image('icons/saveSmall.png',array('div'=>false,'label'=>false,'alt'=>'save','title'=>'save','id'=>'saveShift_-1','class'=>'saveShift'));?></td><td><?php echo $this->Html->image('icons/delete.png',array('div'=>false,'label'=>false,'alt'=>'reset','title'=>'reset','id'=>'reset'));?></td></tr></table></td>';
        $("#tableData").prepend(field).slideDown('slow');
        $("#no_record").hide();
        $(".shift_name").focus(); 
        $.each(timeSlot, function(key, value) {
            $('.from').append(new Option(value , value) );
            $('.to').append(new Option(value , value) );
        });
        
        $(this).removeClass('blueBtn add_new_shift'); 
        $(this).addClass('grayBtn undo_new_shift');
        $(".subReset").trigger('click');
    });
    
    $(document).on('click','#reset',function(){  
        $(".undo_new_shift").addClass('blueBtn add_new_shift'); 
        $(".undo_new_shift").removeClass('grayBtn undo_new_shift');
        $("#hideRow_-1").remove();
    });
    
    $(document).on('click','.saveShift',function(){
        var id = $(this).attr('id').split("_")[1];
        
        var shiftId = $("#shiftId_"+id).val();
        var shiftAlias = $("#shiftAlias_"+id).val();
        var shiftCount = $("#shiftCount_"+id).val();
        var shiftName = $("#shiftName_"+id).val();
        var fromTime = $("#fromTime_"+id).val();
        var toTime = $("#toTime_"+id).val();
        var isActive = $("#isActive_"+id).val();
        
        var isShiftExist = isAliasExist = false;
        $(".shiftName").each(function(){
            if($(this).text()===shiftName && $(this).attr('field_no')!=id){
                isShiftExist = true;
            }
        });
        
        $(".shiftAlias").each(function(){
            if($(this).text()===shiftAlias && $(this).attr('field_no')!=id){
                isAliasExist = true;
            }
        });
        
        if(isShiftExist == true){
            alert("Shift is already taken, please choose another one");
            return false;
        }
        
        if(isAliasExist == true){
            alert("Shift Alias is already taken, please choose another one");
            return false;
        } 
        
        if(shiftName=='' || fromTime=='' || toTime=='' || shiftAlias=='' || shiftCount==''){ 
            alert("Please fill out all the fields!");
            return false;
        }
        result = "id="+shiftId+"&alias="+shiftAlias+"&name="+shiftName+"&from_time="+fromTime+"&to_time="+toTime+"&is_active="+isActive+"&shift_count="+shiftCount;  
        if(result !== '' && result !== undefined){
            $.ajax({
                type: "GET",
                url: "<?php echo $this->Html->url(array("controller" => "TimeSlots", "action" => "saveShift","admin"=>false,"plugin"=>false)); ?>",
                data: result,
                context: document.body,				  		  
                beforeSend:function(data){
                    $('.formFull').block({
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
                        overlayCSS: { backgroundColor: '#00000' }
                    });
                },
                success: function(data)
                {
                    if(data == "true"){
                        window.location.reload(); 
                    }else{
                        alert("something went wrong, please try again!");
                        $('.formFull').unblock();
                    }  
                } 
            });
        } 
    }); 
     
    $(document).on('click','.editShift',function(){
        $("#reset").trigger('click');
        var field_no = $(this).attr('field_no'); 
        $(".hiddenRows").each(function(){
            var id = $(this).attr('id').split("_")[1];
            $('#row_'+id).show();
            $(this).hide();
        });
        $('#hiddenRow_'+field_no).show();
        $('#row_'+field_no).hide(); 
    });
    
    $(document).on('click','.subReset',function(){ 
        $(".hiddenRows").each(function(){
            var id = $(this).attr('id').split("_")[1];
            $('#row_'+id).show();
            $(this).hide();
        }); 
    }); 
    
    
    $(document).on('input',".shift_count",function() { 
	if (/[^0-9\.]/g.test(this.value))
        {
            this.value = this.value.replace(/[^0-9\.]/g,'');
        }
    });
</script> 