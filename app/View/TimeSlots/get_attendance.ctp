<div class="clr ht5"></div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
    <tbody> 		    			 				    
        <tr class="row_title">
			<?php $lastMonth = date("Y-m-d",strtotime($todayDate." -1 month"));
				$lastMonthText = date("F",strtotime($todayDate." -1 month")); ?>
            <td align="left">
			<?php echo $this->Html->link(__("<< ".$lastMonthText),'javascript:getAttendance("'.$lastMonth.'");' ,array('escape'=>false,'class'=>'loading'));?></td> 

            <td><?php echo date("l dS, F Y",strtotime($todayDate));//echo date("F",strtotime($todayDate)); ?></td>

            <td>
    		<?php echo $this->Form->input('role_id',array('type'=>'select','empty'=>'All','options'=>$roles,'div'=>false,'label'=>false,'class'=>'searchRoles textBoxExpnd','id'=>'searchRoles','value'=>$role_id,'class'=>'changeRole')); ?>
            </td> 
            <td>
    		<?php echo $this->Form->input('search_users',array('placeholder'=>"Type name to Search",'div'=>false,'label'=>false,'class'=>'search_box textBoxExpnd','id'=>'searchTerm')); ?>
            </td>   
            <td>
                <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),'javascript:getAttendance("'.date("Y-m-d").'");',array('escape'=>false, 'title' => 'refresh','class'=>'loading'));?>
            </td>
            <?php $NextMonth = date("Y-m-d",strtotime($todayDate." +1 month"));
                    $NextMonthText = date("F",strtotime($todayDate." +1 month")); ?>
            <td align="right"><?php echo $this->Html->link(__($NextMonthText." >>"),'javascript:getAttendance("'.$NextMonth.'");',array('escape'=>false,'class'=>'loading'));?></td>
        </tr>
    </tbody>
</table>
<?php $noOfDaysinThisMonth = date("t",strtotime($todayDate)); 	//last date of this month  
	  $weekDays = array("<font color=\"red\">S</font>","M","T","W","T","F","S"); ?>
<table width="100%" class="attendanceTable" cellpadding="0" cellspacing="0" border="0" id="dataTables">
    <tr>
        <th style="background-color:#4285F4;"></th>
		<?php foreach(range(1,$noOfDaysinThisMonth) as $day => $date) { ?>
        <th class="tab" style="background-color:#4285F4; min-width:15px; max-width:15px;">
            <font color=#fff><?php echo $date; ?></font>	<!-- Print all dates from 1 to 28 or 30 or 31 -->
        </th>
					<?php } ?>
    </tr>
    <tr>
        <th class="alignLeft" style="background-color:#D0DCE0"><?php echo __('User'); ?></th>
		<?php foreach(range(1,$noOfDaysinThisMonth) as $day => $date) { ?>
        <th class="tab" style="background-color:#D0DCE0"><?php echo $weekDays[date('w', strtotime(date("Y-m-$date",strtotime($todayDate))))]; ?></th>
		<?php } ?>
    </tr> 
    <tbody id="dataTable" oncontextmenu="return false">
	<?php if(!empty($users)){
		foreach ($users as $key => $value) {  $userId = $value['User']['id'];  ?>
        <tr class="rowHover"><td class="column" ><?php echo $userName = $value[0]['full_name']; ?></td>
				<?php foreach(range(1,$noOfDaysinThisMonth) as $day => $date) { 
					$date = str_pad($date,2,'0',STR_PAD_LEFT);
					$class = "column users ";
					$title = $userName;
					if(date("Y-m-$date",strtotime($todayDate)) > date("Y-m-d")){
						$class = "not_active ";
						$title = "Could not be able to add on future date";
					}
					$dispText = "";
					if($attData[$key][$date] == "1"){
						$class .= "present ";
						$dispText = "P";
					}else if($attData[$key][$date] == "2"){
						$class .= "absent ";
						$dispText = "A";
					}else{
						$class .= '';
					} 
                                        
                                        if(!empty($rosterData[$userId][date("Y-m-$date",strtotime($todayDate))]['shift'])) {   
                                            $appliedShift = $rosterData[$userId][date("Y-m-$date",strtotime($todayDate))]['shift'];	//shift from duty_roster table
                                        }else {   
                                            $appliedShift = $value['PlacementHistory']['shifts'];	//by defualt shift from users table
                                        } 
				?>
            <td 
                class="tab <?php echo $class; ?>"  
                shift="<?php echo $appliedShift; ?>"
                user_name="<?php echo $userName; ?>"
                intime="<?php echo $inTime = $rosterData[$userId][date("Y-m-$date",strtotime($todayDate))]['intime']; ?>"
                outime="<?php echo $outTime = $rosterData[$userId][date("Y-m-$date",strtotime($todayDate))]['outime']; ?>"
                                    <?php if(!empty($inTime)){
                                        $title .= "\nIn time : $inTime";
                                    }
                                    if(!empty($outTime)){
                                        $title .= "\nOut time : $outTime";
                                    } ?>
                title="<?php echo $title; ?>"
                user_id="<?php echo $userId; ?>" 
				role_id="<?php echo $value['User']['role_id']; ?>" 
                day="<?php echo date("Y-m-$date",strtotime($todayDate));; ?>" 
                date='<?php echo date("$date/m/Y",strtotime($todayDate)); ?>'
                id="user_<?php echo $userId."_".$date; ?>"
                remark="<?php echo $rosterData[$userId][date("Y-m-$date",strtotime($todayDate))]['remark']; ?>"
                                    <?php if (strpos($class, 'not_active ') === false) { ?>
                oncontextmenu="ShowMenu('contextMenu',event)"
                                    <?php }?>
                >

                                    <?php if($rosterData[$userId][date("Y-m-$date")]['day_off'] > '0'){
                                            $displayText = $rosterData[$userId][date("Y-m-$date")]['day_off'];
                                        }else{
                                            $displayText = $shiftAlias[trim($shifts[$appliedShift])];//substr($appliedShift,0,1); 
                                        }
                                    
                                      if (strpos($class, 'not_active ') === false) {  
                                        echo $displayText;
                                      } ?>
            </td>
			<?php } //end of date range foreach?>
        </tr> 
	<?php } //end of foreach
		} else { ?>
        <tr><th><?php echo "No Record found!"; ?></th></tr>
	<?php } //end of if else ?>
    </tbody>
</table>
<?php 
    for ($i = 0; $i <= 23; $i++) {
        for($min = 0; $min <= 59 ; $min+=1){
            for($sec = 0; $sec <= 59 ; $sec+=1){
                $hour[str_pad($i,2,0,STR_PAD_LEFT)] = $i >= 10 ? $i : "0" . $i;
                $minute[str_pad($min,2,0,STR_PAD_LEFT)] = $min >= 10 ? $min : "0" . $min;
                $second[str_pad($sec,2,0,STR_PAD_LEFT)] = $sec >= 10 ? $sec : "0" . $sec;
            }
        }
    } 
?>
<div style="display: none;" id="contextMenu">
    <?php echo $this->Form->create('',array('id'=>'contextForm','onsubmit'=>"return(false);")); ?>
    <table border="0" cellpadding="5" cellspacing="0" class="table_format" style="border: thin solid #808080; cursor: default;" bgcolor="White"> 
        <tr>
            <td style="text-align:right"><?php echo __('User : '); echo $this->Form->hidden('',array('id'=>'user_id','name'=>'user_id','value'=>''));  echo $this->Form->hidden('',array('id'=>'role_id','name'=>'role_id','value'=>'')); ?></td>
            <td style="font-weight: bold" id="userName"></td>
        </tr>
        <tr>
            <td style="text-align:right"><?php echo __('Date : '); echo $this->Form->hidden('',array('id'=>'user_date','name'=>'date','value'=>'')); 
            echo $this->Form->hidden('',array('id'=>'shift','name'=>'shift','value'=>'')); ?></td>
            <td style="font-weight: bold" id="userDate"></td>
        </tr>
        <tr>
            <td style="text-align:right"><?php echo __('In time : '); ?></td>
            <td><?php  
                    echo $this->Form->input('',array('name'=>'intime_hour','type'=>'select','options'=>$hour,'class'=>'in_time','label'=>false,'id'=>'intime_hour','div'=>false,'value'=>date('H'),'disabled'=>true));
                    echo $this->Form->input('',array('name'=>'intime_minute','type'=>'select','options'=>$minute,'class'=>'in_time','label'=>false,'id'=>'intime_minute','div'=>false,'value'=>date('i'),'disabled'=>true));
                    echo $this->Form->input('',array('name'=>'intime_second','type'=>'select','options'=>$second,'class'=>'in_time','label'=>false,'id'=>'intime_second','div'=>false,'value'=>date('s'),'disabled'=>true));
                    echo $this->Form->input('',array('name'=>'is_intime_check','type'=>'checkbox','id'=>'is_intime_check','div'=>false,'label'=>false,'options'=>false,
                        'hiddenField'=>false,'title'=>'Check to edit the In-time','value'=>'0',
                        'onclick'=>"if(this.checked){ $(this).val(1); }else{ $(this).val(0); }"));
                ?>
            </td>
        </tr>  
        <tr>
            <td style="text-align:right"><?php echo __('Out time : '); ?></td>
            <td><?php  
                    echo $this->Form->input('',array('name'=>'outtime_hour','type'=>'select','options'=>$hour,'class'=>'out_time','label'=>false,'id'=>'outtime_hour','div'=>false,'value'=>date('H'),'disabled'=>true));
                    echo $this->Form->input('',array('name'=>'outtime_minute','type'=>'select','options'=>$minute,'class'=>'out_time','label'=>false,'id'=>'outtime_minute','div'=>false,'value'=>date('i'),'disabled'=>true));
                    echo $this->Form->input('',array('name'=>'outtime_second','type'=>'select','options'=>$second,'class'=>'out_time','label'=>false,'id'=>'outtime_second','div'=>false,'value'=>date('s'),'disabled'=>true));
                    echo $this->Form->input('',array('name'=>'is_outtime_check','type'=>'checkbox','id'=>'is_outtime_check','div'=>false,'options'=>false,
                        'label'=>false,'hiddenField'=>false,'title'=>'Check to edit the Out-time','value'=>'1','checked'=>
                        false,
                        'onclick'=>"if(this.checked){ $(this).val(1); }else{ $(this).val(0); }"));
                ?>
            </td> 
        </tr>  
        <tr>
            <td style="text-align:right" valign="top"><?php echo __('Remark : '); ?></td> 
            <td style="text-align:left"><?php echo $this->Form->input('',array('name'=>'remark','type'=>'textarea','rows'=>'1','cols'=>'10','style'=>'height:none !important; width:90%','class'=>'tdextBoxExpnd','div'=>false,'label'=>false,'id'=>'remark')); ?></td> 
        </tr> 
        <tr>
            <td style="text-align:center" colspan="2" align="center"><?php echo $this->Form->button(__('Update'),array('div'=>false,'label'=>false,'id'=>'updateTime')); 
            echo "&nbsp;".$this->Form->button(__('close'),array('div'=>false,'label'=>false,'id'=>'close','onClick'=>"HideMenu('contextMenu')")); ?></td> 
        </tr>  
    </table>
     <?php echo $this->Form->end(); ?>
</div> 
<script>
    var $rows = $('#dataTable tr');
    $(document).on('keyup', '#searchTerm', function () {
        HideMenu('contextMenu');
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        $rows.show().filter(function () {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
    
    $(document).on('click',"#is_intime_check",function(){
        if($(this).is(":checked") == true){
            $(".in_time").attr('disabled',false);
            updateHourMin('#intime_hour','#intime_minute','click');
        }else{
            $(".in_time").attr('disabled',true);
        }
    });
    
    $(document).on('click',"#is_outtime_check",function(){
        if($(this).is(":checked") == true){
            $(".out_time").attr('disabled',false); 
            updateHourMin('#outtime_hour','#outtime_minute','click');
        }else{
            $(".out_time").attr('disabled',true);
        }
    });
    
    $(document).on('change',"#intime_hour",function(){  
        var thisVal = $(this).val();
        updateHourMin('#intime_hour','#intime_minute','change');
        $('#intime_hour option[value='+thisVal+']').attr('selected','selected');
    });
    
    $(document).on('change',"#outtime_hour",function(){ 
        var thisVal = $(this).val();
        updateHourMin('#outtime_hour','#outtime_minute','change');
        $('#outtime_hour option[value='+thisVal+']').attr('selected','selected');
    });
    
    function updateHourMin(idHour,idMin,event){
        var d = new Date(); 
        var isTodayDate = false;
        var curDate = (d.getFullYear()+'-'+str_pad((d.getMonth()+1))+'-'+str_pad(d.getDate())).toString(); 
        var curHour = d.getHours();
        var curMin = d.getMinutes();
        var selHour = $(idHour).val();
        
        var userDate = $("#user_date").val();
        if(userDate === curDate){
            isTodayDate = true;
        } 

        var i = 0; min = 0; sec = 0;
        var hour = new Array;
        var minute = new Array;
        var second = new Array;
        for ( i ; i <= 23; i++) {
            for(min = 0; min <= 59 ; min+=1){
                for(sec = 0; sec <= 59 ; sec+=1){
                    hour[i] = i >= 10 ? i : "0" + i;
                    minute[min] = min >= 10 ? min : "0" + min;
                    second[sec] = sec >= 10 ? sec : "0" + sec;
                }
            }
        } 

        if($(idHour+" option").remove()){
            $.each(hour,function(key,value){
                if(value > curHour && isTodayDate == true){ 
                    return false;
                }
                $(idHour).append( "<option value='"+value+"'>"+value+"</option>" );
            });
        } 
         
        if(event === "click"){
            $(idHour).val(curHour);
        }
        
        console.log(selHour+"--"+event);
        if($(idMin+" option").remove()){
            $.each(minute,function(key,value){
                if(value > curMin && isTodayDate == true && selHour == curHour){ 
                    return false;
                }
                $(idMin).append( "<option value='"+value+"'>"+value+"</option>" );
            });
        } 
        $(idMin).val(curMin);
    }  
</script>
