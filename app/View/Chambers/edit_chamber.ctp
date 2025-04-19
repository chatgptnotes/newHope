<link href="<?php echo $this->Html->url('/wdcss/calendar.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/dp.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/alert.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/colorselect.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/Error.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/main.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/dropdown.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/dailog.css'); ?>"
	rel="stylesheet" type="text/css" />
<?php  echo $this->Html->css('internal_style'); ?>
<script
	src="<?php echo $this->Html->url('/wdsrc/jquery.js'); ?>"
	type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/Common.js'); ?>"
	type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/datepicker_lang_US.js'); ?>"
	type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.datepicker.js'); ?>"
	type="text/javascript"></script>

<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.alert.js'); ?>"
	type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.ifrmdailog.js'); ?>"
	defer="defer" type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/wdCalendar_lang_US.js'); ?>"
	type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.calendar.js'); ?>"
	type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.dropdown.js'); ?>"
	type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.colorselect.js'); ?>"
	type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.validate.js'); ?>"
	type="text/javascript"></script>
<script
	src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.form.js'); ?>"
	type="text/javascript"></script>

<script type="text/javascript"><!--
        if (!DateAdd || typeof (DateDiff) != "function") {
            var DateAdd = function(interval, number, idate) {
                number = parseInt(number);
                var date;
                if (typeof (idate) == "string") {
                    date = idate.split(/\D/);
                    eval("var date = new Date(" + date.join(",") + ")");
                }
                if (typeof (idate) == "object") {
                    date = new Date(idate.toString());
                }
                switch (interval) {
                    case "y": date.setFullYear(date.getFullYear() + number); break;
                    case "m": date.setMonth(date.getMonth() + number); break;
                    case "d": date.setDate(date.getDate() + number); break;
                    case "w": date.setDate(date.getDate() + 7 * number); break;
                    case "h": date.setHours(date.getHours() + number); break;
                    case "n": date.setMinutes(date.getMinutes() + number); break;
                    case "s": date.setSeconds(date.getSeconds() + number); break;
                    case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
                }
                return date;
            }
        }
        function getHM(date)
        {
             var hour =date.getHours();
             var minute= date.getMinutes();
             var ret= (hour>9?hour:"0"+hour)+":"+(minute>9?minute:"0"+minute) ;
             return ret;
        }
        $(document).ready(function() {
            //debugger;
            
            var DATA_FEED_URL = "<?php echo $this->Html->url('/Chambers/datafeed/'); ?>";
            var arrSTRT = [];
            var arrENDT = [];
            var tt = "{0}:{1}";
            var timeError = false ;
            for (var i = parseInt(<?php echo Configure::read('calendar_start_time') ?>); i < parseInt(<?php echo  Configure::read('calendar_end_time')?>); i++) {
                arrSTRT.push({ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "00"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "15"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "30"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "45"]) });
                arrENDT.push({ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "15"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "30"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "45"]) }, { text: StrFormat(tt, [i >= 9 ? (i+1) : "0" + (i+1), "00"]) });
            }
             
            $("#timezone").val(new Date().getTimezoneOffset()/60 * -1);
            $("#stparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
                selectedchange: function(e){},
                items: arrSTRT
            });
            $("#etparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
                selectedchange: function(e) { timeCheck(e); },   
                items: arrENDT
            });

            function timeCheck(e){
            	  startTm =  $("#stparttime").val() ; 
            	
            	  endTm =  e.text ; 
            	 
            	if(startTm > endTm){;
                	 alert("Start time is greater than end time!!"); 
                	 $('#etparttime').val('');
                	 timeError = false ;
            	}else{
            		timeError = true ;
            	}
            }
                
            var check = $("#IsAllDayEvent").click(function(e) {
                if (this.checked) {
                    $("#stparttime").val("00:00");
                    $("#etparttime").val("00:00");
                    $("#timeDropdowns").fadeOut('slow');
                    timeError = true ;
                }
                else {
                	$("#timeDropdowns").fadeIn('slow');
                    var d = new Date();
                    var p = 60 - d.getMinutes();
                    if (p > 30) p = p - 30;
                    d = DateAdd("n", p, d);
                    $("#stparttime").val(getHM(d)).show();
                    $("#etparttime").val(getHM(DateAdd("h", 1, d))).show();
                }
            });
            if (check[0].checked) {
                $("#stparttime").val("00:00").hide();
                $("#etparttime").val("00:00").hide();
                $("#timeDropdowns").fadeOut('slow');
                timeError = true ;
            }else{
                //check for update case 
            	var startTm =  $("#stparttime").val() ; 
            	var endTm =  $('#etparttime').val() ; 
            	if(startTm > endTm){
                	 timeError = false ;
            	}else{
            		timeError = true ;
            	}
            }
            $("#Savebtn").click(function () {   
                //fmEdit
               		if(timeError == false){
                    		var errorString = "Please Check :\n1. Start time is greater than end time!!\n";
                		}else{
							var errorString = "Please Check :\n1)";
                    	}
                    	var weekdaysError = true ; 
                		//check weekdays if recurring check only
                		if($("#is_recurring").attr('checked')==true){
	                    	$("input:checkbox").each(function()
	        				{ 
	        				    if($(this).attr('name')=='weekdays[]' && $(this).attr('checked')==true){
	        				    	weekdaysError =false ;
	            				}
	        				});
                		}else{
                			 weekdaysError = false ; 
                		}
        				if(weekdaysError == true){
							if(errorString =='')
								errorString = " None of the weekday selected!!" ;
							else
								errorString += "2. None of the weekday selected!!" ;
            			} 
                    	//EOF weekdays check 
                    	 
                    	if(timeError == true && weekdaysError == false ){ $("#fmEdit").submit(); return false;  }
                    	else { 
                        	alert(errorString);
	                    	$('#etparttime').val('');
	                    	$('#etparttime').focus();
	                    	return false ;
                    	}  
            });
                	
            $("#Closebtn").click(function() { CloseModelWindow(); });
            $("#Deletebtn").click(function() {
                 if (confirm("Are you sure to remove this event")) {  
                    var param = [{ "name": "calendarId", value: 8}];                
                    $.post(DATA_FEED_URL + "?method=remove",
                        param,
                        function(data){
                              if (data.IsSuccess) {
                                    alert(data.Msg); 
                                    //parent.location.reload(); // reload page to reflect chages after submission 
                                    CloseModelWindow(null,true);
                                                               
                                }
                                else {
                                    alert("Error occurs.\r\n" + data.Msg);
                                }
                        }
                    ,"json");
                }
            });
            
            var actualDate = new Date();
            var newDate = new Date(actualDate.getFullYear(), actualDate.getMonth(), actualDate.getDate()-1);
           $("#stpartdate").datepicker({
                picker: "<button class='calpick'></button>",
                fulldayvalue : "dd/mm/yy",
                minDate: newDate,
                onReturn:function(selDate){
                	var EDate = new Date(selDate.getFullYear(), selDate.getMonth(), selDate.getDate());
                	$('#oldPartDate').hide();
                	if( (new Date($("#etpartdate").val()).getTime() > new Date($("#stpartdate").val()).getTime())){
                    	$("#etpartdate").val('');
                    }
                	//alert(new Date($("#etpartdate").val()).getTime()+' > '+new Date($("#stpartdate").val()).getTime());
                	$("#etpartdate").datepicker({
                        picker: "<button class='calpick' id='oldPartDate'></button>",
                        fulldayvalue : "dd/mm/yy",
                        minDate: EDate,
                    });
                }
            }); 
           $("#etpartdate").datepicker({
               picker: "<button class='calpick' id='oldPartDate'></button>",
               fulldayvalue : "dd/mm/yy",
               minDate: new Date('<?php echo date("n/j/Y", strtotime($sarr1[0])) ?>'),
           });
           
           var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            $("#calendarcolor").colorselect({ title: "Color", index: cv, hiddenid: "colorvalue" });
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() { 
                    return true;
                },
                
                dataType: "json",
                success: function(data) {
                    alert(data.Msg);
                    if (data.IsSuccess) {
                    	//parent.location.reload(); // reload page to reflect chages after submission
                        CloseModelWindow(null,true);   
                    }
                }
            };
            $.validator.addMethod("date", function(value, element) {                             
                var arrs = value.split(i18n.datepicker.dateformat.separator);
                var year = arrs[i18n.datepicker.dateformat.year_index];
                var month = arrs[i18n.datepicker.dateformat.month_index];
                var day = arrs[i18n.datepicker.dateformat.day_index];
                var standvalue = [year,month,day].join("-");
                return this.optional(element) || /^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3-9]|1[0-2])[\/\-\.](?:29|30))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3,5,7,8]|1[02])[\/\-\.]31)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:16|[2468][048]|[3579][26])00[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1-9]|1[0-2])[\/\-\.](?:0?[1-9]|1\d|2[0-8]))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?:\d{1,3})?)?$/.test(standvalue);
            }, "Invalid date format");
            
            $.validator.addMethod("time", function(value, element) {
                return this.optional(element) || /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(value);
            }, "Invalid time format");
            
            $.validator.addMethod("safe", function(value, element) {
                return this.optional(element) || /^[^$\<\>]+$/.test(value);
            }, "$<> not allowed"); 
            
            $("#fmEdit").validate({
                submitHandler: function(form) { $("#fmEdit").ajaxSubmit(options); },
                errorElement: "div",
                errorClass: "cusErrorPanel",
                errorPlacement: function(error, element) {
                    showerror(error, element);
                }
            });
            function showerror(error, target) {
                var pos = target.position();
                var height = target.height();
                var newpos = { left: pos.left, top: pos.top + height + 2 }
                var form = $("#fmEdit");             
                error.appendTo(form).css(newpos);
            }

 			function disableWeekdays(obj){
 				 
            }  

            $('#is_recurring').click(function(){
            	disableWeekdays();
                });
        
            disableWeekdays();
        });
      
    --></script>
<style type="text/css">
input,select {
	border: 1px solid #363C3D !important color:         #E7EEEF;
	font-size: 13px;
	outline: medium none;
	padding: 0;
	resize: none;
}

.calpick {
	width: 16px;
	height: 16px;
	border: none;
	cursor: pointer;
	background:
		url("<?php echo $this->Html->url('/wdcss/sample-css/cal.gif'); ?>")
		no-repeat center 2px;
	/*margin-left:-22px;*/
	vertical-align: top;
}

.checkbox {
	clear: both;
}

label {
	align: left;
	width: 77px;
	text-align: left;
}

.infocontainer tdLabel {
	padding-left: 0px !important;
	padding-right: 0px !important;
}

input[type="checkbox"] {
	border: medium none;
	float: left;
}

.containtdiv {
	width: 30px;
}

.leftdiv {
	width: 17px;
}
</style>
<body>
	<div>
		<div style="clear: both"></div>
		<div class="infocontainer">
			<form
				action="<?php echo $this->Html->url('/chambers/datafeed/'); ?>?method=adddetails<?php echo '&doctor_id='.$this->params->query['doctor_id'].'&chamber_id='.$this->params->query['chamber_id'] ;echo isset($getStaffPlan['DoctorChamber']['id'])?"&id=".$getStaffPlan['DoctorChamber']['id']:""; ?>"
				class="fform" id="fmEdit" method="post">

				<div align="center" id="busy-indicator1" style="display: none;">
					<?php echo $this->Html->image('indicator.gif');
					?>
				</div>
				<?php 
				$sdate ="";
				$stime = "";
				$edate = "";
				$etime = "";
				if(isset($startDate)){
				 	if (isset($getStaffPlan['DoctorChamber']['id'])) {
				 		 $sdate = date("n/j/Y", strtotime($sarr1[0]));
				 		 $stime = $sarr1[1];
				 		 $edate = date("n/j/Y", strtotime($earr1[0]));
				 		 $etime = $earr1[1];
					} else {
						$dateTime = explode("_",$startDate);
						$sdate = $dateTime[0];
						$stime =  date ('H:i',strtotime($dateTime[1]));
					}
				}
				?>
				<table border="0" cellpadding="5" cellspacing="0" width="100%"
					align="center">
					<tr>
						<td colspan="2" class='tdLabel' style="padding-bottom:10px; padding-top:10px !important;">
							<div>
								<div style="float: left;">
									<?php echo __('Color'); ?>&nbsp;&nbsp;
								</div>
								<div id="calendarcolor"></div>
								<input id="colorvalue" name="colorvalue" type="hidden"
									value="<?php echo isset($getStaffPlan['DoctorChamber']['color'])?$getStaffPlan['DoctorChamber']['color']:"-1" ?>" />
							</div>
							<div style="margin-left: 90px;">
								<?php echo $this->Form->input('',array('type'=>'radio','name'=>'is_blocked',
										'options'=>array(true=>'Block Time',false=>'Same Day'),'onClick'=>'setText();',
								'label'=>false,'default'=>true,'div'=>false,'value'=>$getStaffPlan['DoctorChamber']['is_blocked'],'id'=>"isBlocked"));?>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tdLabel"><?php echo __('Recurring')?>:</td>
						<td class="" style="font-size:13px;"><div style="float:left;"><?php 
						if(isset($getStaffPlan['DoctorChamber']['id']) && $getStaffPlan['DoctorChamber']['is_recurring']== 1) {
		        			$recurringChecked=  "checked";
			        	}else $recurringChecked = '';
	
				        	echo $this->Form->input('',array('name'=>'is_recurring','id'=>'is_recurring','type'=>'checkbox',
			            		'value'=>1,'style'=>'padding:0px;margin: 3px 3px 0 0;','error'=>false,'div'=>false,'label'=>false,'checked'=>$recurringChecked));
			            	echo "For" ;
			            	$monthArray = array('1 Month','2 Months','3 Months','4 Months','5 Months','6 Months','7 Months','8 Months','9 Months','10 Months','11 Months','12 Months');
			            	echo $this->Form->input('',array('options'=>$monthArray,'name'=>'recurring_month','id'=>'recurring_month','type'=>'select',
			            		 'style'=>'width:90px;padding:0px;margin:0 0 0 10px;','error'=>false,'div'=>false,'label'=>false,'value'=>$getStaffPlan['DoctorChamber']['recurring_month']));
					?></div></td>
					</tr>
					<tr>
						<td class="tdLabel" colspan="4" style="padding-top:10px !important;">Date & Time <font color="red">*</font>:
                         <span style="margin:0 0 0 7px;"><?php echo $this->Form->input('',array('class'=>'required date validate[required,custom[mandatory-enter]]','name'=>'stpartdate','id'=>'stpartdate','type'=>'text',
								'value'=>$sdate,'style'=>'width:90px;padding:0px;','error'=>false,'div'=>false,'label'=>false));?>
						</span> <span> <?php echo $this->Form->input('',array('class'=>'required date','name'=>'etpartdate','id'=>'etpartdate','type'=>'text',
								'value'=>$edate,'style'=>'width:90px;padding:0px;','error'=>false,'div'=>false,'label'=>false));
						?>
						</span> <?php
						if(isset($getStaffPlan['DoctorChamber']['id'])&&$getStaffPlan['DoctorChamber']['is_all_day_event']!=0)
							$checked=  "checked";
							else $checked = '';?>
                            <div id="timeDropdowns"
								style="float: right; padding: 0 30px 0 0;">
								<?php 
								echo "From &nbsp;" ;
								echo $this->Form->input('',array('class'=>'required time','name'=>'stparttime','id'=>'stparttime','type'=>'text',
	            					'value'=>$stime,'style'=>'width:60px;padding:0px;','error'=>false,'div'=>false,'label'=>false));

	            				echo "&nbsp;To&nbsp;" ;
	            				echo $this->Form->input('',array('class'=>'required time','name'=>'etparttime','id'=>'etparttime','type'=>'text',
	            					'value'=>isset($getStaffPlan['DoctorChamber']['id'])?$earr1[1]:"",'style'=>'width:60px;padding:0px;','error'=>false,'div'=>false,'label'=>false));
	            				?>
							</div>
						</td>
					</tr>
					<tr>
						
						<!--<td class="tdLabel" style="float: left;"><div id="timeDropdowns"
								style="float: right; padding: 0 30px 0 0;">
								<?php 
								echo "From &nbsp;" ;
								echo $this->Form->input('',array('class'=>'required time','name'=>'stparttime','id'=>'stparttime','type'=>'text',
	            					'value'=>$stime,'style'=>'width:60px;padding:0px;','error'=>false,'div'=>false,'label'=>false));

	            				echo "To&nbsp;" ;
	            				echo $this->Form->input('',array('class'=>'required time','name'=>'etparttime','id'=>'etparttime','type'=>'text',
	            					'value'=>isset($getStaffPlan['DoctorChamber']['id'])?$earr1[1]:"",'style'=>'width:60px;padding:0px;','error'=>false,'div'=>false,'label'=>false));
	            				?>
							</div></td>-->
					</tr>
					<tr style="display:none;">
						<!-- not in use so removed -->
						<td>&nbsp;</td>
						<td class="tdLabel"><?php 
						echo $this->Form->hidden('',array('name'=>'recurring_identifier','value'=>$getStaffPlan['DoctorChamber']['recurring_identifier'])) ;
						echo $this->Form->hidden('',array('name'=>'is_all_day_event','id'=>'IsAllDayEvent','type'=>'checkbox',
	            		'value'=>0,'style'=>'width:60px;padding:0px;','error'=>false,'div'=>false,'label'=>false,'checked'=>$checked));
	            		//echo "All Day Event" ;
	            		?>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" style="font-size:13px;"><div style="width:76px;"><?php echo __('Week Days')?> :</div></td>
						<td class="" style="padding:6px 0 10px 0 !important;"><?php 
						$weekArray = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
						if(isset($getStaffPlan['DoctorChamber']['id'])&&$getStaffPlan['DoctorChamber']['is_all_day_event']!=0) {
			        			$recurringChecked=  "checked";
			        	}else { $recurringChecked = '';
}
?>
							<div style="width: 450px;">
								<?php 	
								echo $this->Form->select('',$weekArray,array('name'=>'weekdays','id'=>'weekdays' ,'class'=>'weekdays',
							'multiple' => 'checkbox','default' => unserialize($getStaffPlan['DoctorChamber']['weekdays']),'style'=>'padding:0px;','error'=>false,'div'=>false,'label'=>false,'checked'=>$recurringChecked));
		            	 ?>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" style="width: 76px; padding-bottom:10px;"><?php echo __('Doctor List')?><font
							color="red">*</font>:</td>
						<td class=""><?php 
						if(!empty($getStaffPlan['DoctorChamber']['id'])){
		            		$selectedDoc = $getStaffPlan['DoctorChamber']['doctor_id'];
		            	}else if(!empty($this->params->query['doctor_id'])){
		            		$selectedDoc = $this->params->query['doctor_id'];
		            	}else{
		            		$selectedDoc ='';
		            	}
		            	echo $this->Form->input(null,array('value'=>$selectedDoc,'name' => 'doctor_id', 'id'=> 'doctor_id', 'empty'=>__('Please select doctor'), 'options'=> $getDoctorList, 'label' => false, 'default' => $getStaffPlan['DoctorChamber']['doctor_id'], 'class' => 'required safe',));?>

						</td>
					</tr>
					<!-- <tr>
				<td class="tdLabel" style="float:left; width:90px;"> 
            	 <?php echo __('Chamber List')?><font color="red">*</font>:
            	</td >
           		<td class="tdLabel">
	            <?php 
	            	if(!empty($getStaffPlan['DoctorChamber']['id'])){
	            		$selectedChmaber = $getStaffPlan['DoctorChamber']['chamber_id'];
	            	}else if(!empty($this->params->query['chamber_id'])){
	            		$selectedChmaber = $this->params->query['chamber_id'];
	            	}else{
	            		$selectedChmaber ='';	
	            	}
	            	echo $this->Form->input(null,array('value'=>$selectedChmaber,'name' => 'chamber_id', 'id'=> 'chamber_id', 'empty'=>__('Select Chambers'),
	            	 'options'=> $getChamberList, 'label' => false, 'default' => $getStaffPlan['DoctorChamber']['chamber_id'], 'class' => 'required safe'));?>
				</td>
			</tr> -->
					<tr>
						<td class="tdLabel">Note:</td>
						<td class=""><?php 
						echo $this->Form->input(null,array('value'=>$getStaffPlan['DoctorChamber']['purpose'],'name'=>'purpose','id'=>'Description','label'=>false,'style'=>'width:33%;'))
						?> <input id="timezone" name="timezone" type="hidden" value="" />
							<!-- 
		          <input type = "submit" ></input>
				--></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<div class="toolBotton">
								<a id="Savebtn" class="imgbtn" href="javascript:void(0);"> <span
									class="Save" title="Save the calendar">Save </span>
								</a>
								<?php if(isset($getOtDetails['DoctorChamber']['id'])){ ?>
								<a id="Deletebtn" class="imgbtn" href="javascript:void(0);"> <span
									class="Delete" title="Cancel the calendar">Delete </span>
								</a>
								<?php } ?>
								<a id="Closebtn" class="imgbtn" href="javascript:void(0);"> <span
									class="Close" title="Close the window">Close </span>
								</a>
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<script>
$(document).ready(function(){
   
         // remove error pop up //
         $(".infocontainer").click(function () {
           $("div:.cusErrorPanel").css({'display' : 'none'});
         });
         $('input[name=is_blocked]').click(function(){setText();});
         setText();
		function setText(){
	         if(($.trim('<?php echo $getStaffPlan['DoctorChamber']['purpose'];?>') == '') && $('input[name=is_blocked]:checked').val() == 0){
					$('#Description').val('SAME DAY EXAM');
	         }
		}
         
});
  </script>