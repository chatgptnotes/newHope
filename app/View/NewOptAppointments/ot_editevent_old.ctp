<link
	href="<?php echo $this->Html->url('/wdcss/calendar.css'); ?>"
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
	src="<?php echo $this->Html->url('/wdsrc/Plugins/wdCalendar_lang_US.js'); ?>"
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
<?php
echo $this->Html->script('ckeditor/ckeditor');
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<script type="text/javascript">

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
            var DATA_FEED_URL = "<?php echo $this->Html->url('/OptAppointments/datafeed/'); ?>";
            var arrT = [];
            var tt = "{0}:{1}";
            for (var i = 0; i <= 23; i++) {
                for(var min = 0; min <= 55 ; min+=5){
                	arrT.push({ text: StrFormat(tt, [i >= 10 ? i : "0" + i, min >= 10 ? min : "0" + min]) }); 
                }
               // arrT.push({ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "00"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "15"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "30"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "45"]) });
            }
            arrT.push({"text":"24:00"});
            
            $("#timezone").val(new Date().getTimezoneOffset()/60 * -1);
            $("#stparttime").dropdown({
                dropheight: 200,
                dropwidth:80,
                selectedchange: function() { },
                items: arrT
            });
            $("#etparttime").dropdown({
                dropheight: 200,
                dropwidth:80,
                selectedchange: function() { },
                items: arrT
            });
            var check = $("#IsAllDayEvent").click(function(e) {
                if (this.checked) {
                    $("#stparttime").val("00:00").hide();
                    $("#etparttime").val("00:00").hide();
                }
                else {
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
            }
            $("#Savebtn").click(function() { $("#fmEdit").submit(); });
            $("#Closebtn").click(function() { CloseModelWindow(); });
            $("#Deletebtn").click(function() {
                 if (confirm("Are you sure to remove this event")) {
                    var param = [{ "name": "calendarId", value: 8}];
                    $.post(DATA_FEED_URL + "?method=remove",
                        param,
                        function(data){
                              if (data.IsSuccess) {
                                    alert(data.Msg);
                                    CloseModelWindow(null,true);
                                }
                                else {
                                    alert("Error occurs.\r\n" + data.Msg);
                                }
                        }
                    ,"json");
                }
            });

           $("#stpartdate,#etpartdate, #ot_in_date, #incision_date, #skin_closure_date, #out_date").datepicker({ picker: "<button class='calpick'></button>"});


            var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            $("#calendarcolor").colorselect({ title: "Color", index: cv, hiddenid: "colorvalue" });
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() {
                	$('#busy-indicator').show(); 
                    return true;
                },
                dataType: "json",
                success: function(data) {
                	$('#busy-indicator').hide(); 
                    alert(data.Msg);
                    	 if (data.IsSuccess) {
                        	if(parent.jQuery().fancybox) {
                        		parent.formChildFormSubmitted = $('#procedurecomplete').val();// parent variable @OR dashboard
                        		parent.jQuery.fancybox.close();
                           	}else
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
            $.validator.addMethod("numbers", function(value, element) {
                return this.optional(element) || /^[0-9]+$/.test(value);
            }, "Only numbers allowed");
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
        });
    </script>
<style type="text/css">
.calpick {
	width: 16px;
	height: 16px;
	border: none;
	cursor: pointer;
	background:
		url("<?php echo $this->Html->url('/wdcss/sample-css/cal.gif'); ?>")
		no-repeat center 2px;
	/*   margin-left:-22px; */
	padding: 11px 0 0;
}

#busy-indicator {
	display: none;
	left: 50%;
	position: fixed;
	top: 50%;
	z-index: 2000;
}

a.imgbtn span{
    font-size: 17px !important;
    padding: 2px 1px 5px 25px !important;
}
</style>
</head>
<body>
	<div>

		<div style="clear: both"></div>
		<div class="infocontainer">
			<form
				action="<?php echo $this->Html->url('/opt_appointments/datafeed/'); ?>?method=adddetails<?php echo isset($getOptDetails['OptAppointment']['id'])?"&id=".$getOptDetails['OptAppointment']['id']:""; ?>"
				class="fform" id="fmEdit" method="post">
				<?php
				echo $this->Form->input(null,array('type' => 'hidden', 'name' => 'admissionid', 'id'=> 'admissionid', 'label' => false, 'value'=> $getPatientDetaiils['Patient']['admission_id']));
				echo $this->Form->input(null,array('type' => 'hidden', 'name' => 'patientid', 'id'=> 'patientid', 'label' => false, 'value'=> $getOptDetails['OptAppointment']['patient_id']));
				?>
				<div align="center" id="busy-indicator" style="display: none;">
					<?php echo $this->Html->image('indicator.gif'); ?>
				</div>
					<?php if($this->Session->read('website.instance') != 'kanpur' && $this->Session->read('website.instance') != 'vadodara' ){?>
				<label> <span>Subject<font color="red"> *</font>:
				</span>
					<div id="calendarcolor"></div> <input MaxLength="100"
					class="required safe" id="Subject" name="subject"
					style="width: 40%;" type="text"
					value="<?php echo isset($getOptDetails['OptAppointment']['subject'])?$getOptDetails['OptAppointment']['subject']:"" ?>" />
					<input id="colorvalue" name="colorvalue" type="hidden"
					value="<?php echo isset($getOptDetails['OptAppointment']['color'])?$getOptDetails['OptAppointment']['color']:"" ?>" />
				</label> 
				<?php }?>
				<label> <span> <?php echo __('Patient Name');?><font
						color="red"> *</font>:
				</span>
					<div id="calendarPatientName"></div> <input MaxLength="100"
					class="required safe" id="calendarPatientNameText"
					name="patient_name_text" style="width: 456px;" type="text"
					value="<?php echo isset($getOptDetails['Patient']['lookup_name'])?$getOptDetails['Patient']['lookup_name']:"" ?>" />
					<input id="calendarPatientNameValue" name="patient_name_value"
					type="hidden"
					value="<?php echo isset($getOptDetails['Patient']['id'])?$getOptDetails['Patient']['id']:"" ?>" />
				</label> <label> <span>Date & Time<font color="red"> *</font>:
				</span>
					<div>
						<?php 
						$sdate = $stime = $edate = $etime = "";
						if(isset($startDate)){
				 	if (isset($getOptDetails['OptAppointment']['id'])) {
				 		 $sdate = date("n/j/Y", strtotime($sarr1[0]));
				 		 $stime = $sarr1[1];

					} else {

					$dateTime = explode("_",$startDate);
					$sdate = $dateTime[0];
					//$stime = $dateTime[1];
					}
				}
				if(isset($endDate)){
					if (isset($getOptDetails['OptAppointment']['id'])) {
						$edate = date("d/m/Y", strtotime($earr1[0]));
						$etime = $earr1[1];

					} else {

						$dateTime = explode("_",$endDate);
						$edate = $dateTime[0];
						//$stime = $dateTime[1];
					}
				}

				if(isset($getOptDetails['OptAppointment']['ot_in_date'])) {
					$getOtInDate = date("Y-m-d H:i", strtotime($getOptDetails['OptAppointment']['ot_in_date']));
					$otDateTime = explode(" ", $getOtInDate);
				}
				if(isset($getOptDetails['OptAppointment']['incision_date'])) {
					$getIncisionDate = date("Y-m-d H:i", strtotime($getOptDetails['OptAppointment']['incision_date']));
					$incisionDateTime = explode(" ", $getIncisionDate);
				}
				if(isset($getOptDetails['OptAppointment']['skin_closure_date'])) {
					$getSkinClosureDate = date("Y-m-d H:i", strtotime($getOptDetails['OptAppointment']['skin_closure_date']));
					$skinClosureDateTime = explode(" ", $getSkinClosureDate);
				}
				if(isset($getOptDetails['OptAppointment']['out_date'])) {
					$getOutDate = date("Y-m-d H:i", strtotime($getOptDetails['OptAppointment']['out_date']));
					$outDateTime = explode(" ", $getOutDate);
				}
			 ?>
						<input MaxLength="10" class="required date" id="stpartdate"
							name="stpartdate" style="padding-left: 2px; width: 11%;"
							type="text" value="<?php echo $sdate; ?>" readonly /> <input
							MaxLength="5" class="required time" id="stparttime"
							name="stparttime" autocomplete="off" style="width: 60px;" type="text"
							value="<?php echo $stime; ?>" /><span style="font-size: 12px;">To<font
							color="red"> *</font>:
						</span> <input MaxLength="10" class="required date"
							id="etpartdate" name="etpartdate"
							style="padding-left: 2px; width: 11%;" type="text"
							value="<?php echo isset($getOptDetails['OptAppointment']['id'])?$earr1[0]:""; ?>"
							readonly /> <input MaxLength="50" class="required time"
							id="etparttime" autocomplete="off" name="etparttime" style="width: 60px;"
							type="text"
							value="<?php echo isset($getOptDetails['OptAppointment']['id'])?$earr1[1]:""; ?>" />
						<label class="checkp"> <input id="IsAllDayEvent"
							name="is_all_day_event" type="checkbox" value="1"
							<?php if(isset($getOptDetails['OptAppointment']['id'])&&$getOptDetails['OptAppointment']['is_all_day_event']!=0) {echo "checked";} ?> />
							All Day Event
						</label>
					</div>
				</label>
				
	<div class="twoCol">
          <label>
            <span>
             <?php echo __('OT Room')?><font color="red"> *</font>:
            </span>
            <?php echo $this->Form->input(null,array('name' => 'opt_id', 'id'=> 'opt_id', 'empty'=>__('Select OT'), 'options'=> $opts, 'label' => false, 'default' => $getOptDetails['OptAppointment']['opt_id'], 'style'=>'width:190px;', 'class'=> 'required safe'));?>
	    </label>
	    </div>

	    <div class="twoCol">
            <div id="changeOptTableList" style="<?php if($getOptDetails['OptAppointment']['opt_table_id']) echo 'display:block;'; else echo 'display:none;'; ?>">
            <?php if($getOptDetails['OptAppointment']['opt_table_id']) { ?>
             <label>
            <span>
             <?php echo __('OT Table')?><font color="red"> *</font>:</span>
               <?php echo $this->Form->input(null,array('name' => 'opt_table_id', 'id'=> 'opt_table_id', 'empty'=>__('Select OT Table'), 'options'=> $optTables, 'label' => false, 'default' => $getOptDetails['OptAppointment']['opt_table_id'], 'style'=>'width:190px;', 'class'=> 'required safe'));?>
            </label>
            <?php } ?>
            </div>
	   </div>
	   
				<div class="clr"></div>
				
				<!-- <div class="twoCol">
					<label> <span> <?php echo __('Category'); ?> <font color="red">*</font>:
					</span> <?php 
           				 echo $this->Form->input(null,array('name' => 'surgery_category_id', 'id'=> 'surgery_category_id', 'empty'=>__('Select Category'),'options'=> $surgery_categories, 'label' => false, 'default'=> $getOptDetails['OptAppointment']['surgery_category_id'], 'style'=>'width:190px;', 'class'=> 'required safe'));	?>
					</label>
				</div> -->
				
				<div class="twoCol">
					<label> <span> <?php echo __('Surgery Auto'); ?> <font color="red">*</font>:
					</span> <?php 
           				 echo $this->Form->input(null,array('name' => 'surgery_auto', 'id'=> 'surgery_auto', 'type'=>'text', 'label' => false, 'style'=>'width:190px;', 'class'=> 'required safe'));
           				 echo $this->Form->hidden('',array('id'=>'surgeryId','name'=>'surgery_id'));	?>
					</label>
				</div> 
				
				<div id="changeSurgerySubcategoryList" class="twoCol" style="<?php if($getOptDetails['OptAppointment']['surgery_subcategory_id'] && false) echo 'display:block;'; else echo 'display:none;'; ?>">
					<?php if($getOptDetails['OptAppointment']['surgery_subcategory_id']) { ?>
					<label> <span><?php echo __('Surgery Subcategory')?>:</span> <?php echo $this->Form->input(null,array('name' => 'surgery_subcategory_id', 'id'=> 'surgery_subcategory_id', 'empty'=>__('Select Surgery Subcategory'), 'options'=> $surgery_subcategories, 'label' => false, 'default' => $getOptDetails['OptAppointment']['surgery_subcategory_id'], 'style'=>'width:190px;'));?>
					</label>
					<?php } ?>
				</div>
				<div id="changeSurgeryList" class="twoCol">
					<?php
           			if($getOptDetails['OptAppointment']['surgery_id']) { ?>
					<label> <span> <?php echo __('Surgery')?><font color="red"> *</font>:
					</span> <?php echo $this->Form->input(null,array('name' => 'surgery_id', 'id'=> 'surgery_id', 'empty'=>__('Select Surgery'), 'options'=> $surgeries, 'label' => false, 'default' => $getOptDetails['OptAppointment']['surgery_id'],'style'=>'width:190px;', 'class'=> 'required safe'));?>
					</label>
					<?php } else { ?>
					<label> <span> <?php echo __('Surgery')?><font color="red"> *</font>:
					</span> <select name="surgery_id" id="surgery_id"
						class="required safe" style="width: 190px;">
							<option value="">
								<?php echo __('Select Surgery'); ?>
							</option>
					</select>
					</label>

					<?php }?>
				</div>
				<?php if($this->Session->read('website.instance') == 'vadodara'){
				if(!empty($getOptDetails['OptAppointment']['dummy_surgery_name'])){?>
					<div id="dummy_surgery">
					<label> <span> <?php echo __('Dummy Surgery')?><font color="red"> *</font>:
					</span> <?php echo $this->Form->input(null,array('name' => 'dummy_surgery_name', 'type'=>'text','id'=> 'dummy_id',
							 'label' => false,'style'=>'width:190px;', 'class'=> 'safe','value'=>$getOptDetails['OptAppointment']['dummy_surgery_name']));?>
					</label>
					</div>
					<?php }else{?>
					<div id="dummy_surgery" style="display:none">
					<label> <span> <?php echo __('Dummy Surgery')?><font color="red"> *</font>:
					</span> <?php echo $this->Form->input(null,array('name' => 'dummy_surgery_name', 'type'=>'text','id'=> 'dummy_id',
							 'label' => false,'style'=>'width:190px;', 'class'=> 'safe','value'=>$getOptDetails['OptAppointment']['dummy_surgery_name']));?>
					</label>
					</div>
					<?php }?>
					
				<?php }?>
				<?php if($this->Session->read('website.instance') == 'kanpur'){
					echo $this->Form->hidden(null,array('name'=>'editOnly','id'=>'editOnly','value'=>0));
				?>
				<div class="clr"></div>
				<div id="updateOTRule">
					<span>
                  <?php  $role=$this->Session->read('role');
                  $type = ( $role != Configure::read('adminLabel') )  ? 'hidden' : 'text'; ?>
                     
						<div>
							<?php echo __('Surgeon Charge'); ?>
							<font color="red"> *</font><br />
							<div style="height: 4%;">
							<?php  echo $this->Form->input(null,array('name' => 'doctor_id', 'id'=> 'doctor_id', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist,
								'label' => false,'style'=>'width:190px;','div'=>false, 'class'=> 'required safe surgeon','default'=>$getOptDetails['OptAppointment']['doctor_id']));
							?></div>
							<?php
								 echo $this->Form->input(null,array('name' => 'surgeon_amt','type'=>$type,'id'=> 'surgeonCharge','label' => false, 'div' => false, 
									'class' => ' digits safe','value'=>$getOptDetails['OptAppointment']['surgeon_amt'],"style"=>"width:190px",'readOnly'=>true));
                            ?>
						</div>
						<div style="float: left; width: 22%;">
							<?php echo __('Asst. Surgeon I'); ?><br />
							<div style="height: 4%;">
							<?php echo $this->Form->input(null,array('name' =>'asst_surgeon_one','id'=> 'asstDoctorIdOne','empty'=>__('Select Surgeon'),'options'=> $doctorlist,
								'label' => false, 'style'=>'width:190px;','div'=>false,'class'=> ' safe surgeon','default'=>$getOptDetails['OptAppointment']['asst_surgeon_one']));
							?></div>
							<?php 
							       echo $this->Form->input(null,array('name' =>'asst_surgeon_one_charge','type'=>$type,'id'=> 'asstSurgeonOneCharge','label' => false,'div' => false,
								   'value'=>$getOptDetails['OptAppointment']['asst_surgeon_one_charge'], 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
                              ?>
						</div>
						<div>
							<?php echo __('Asst. Surgeon II'); ?><br />
							<div style="height: 4%;">
							<?php echo $this->Form->input(null,array('name' => 'asst_surgeon_two', 'id'=> 'asstDoctorIdTwo', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist,
							'label' => false, 'style'=>'width:190px;','div'=>false, 'class'=> ' safe surgeon','default'=>$getOptDetails['OptAppointment']['asst_surgeon_two']));?>
							</div>
							<?php 
							       echo $this->Form->input(null,array('name' => 'asst_surgeon_two_charge','type'=>$type ,'id'=> 'asstSurgeonTwoCharge','label' => false, 
										'div' => false,'value'=>$getOptDetails['OptAppointment']['asst_surgeon_two_charge'],'class' => ' digits safe',
										"style"=>"width:190px",'readOnly'=>true));
                           ?>
						</div>
						<div style="float: left;  width: 22%;">
							<?php echo __('Anaesthesist'); ?><br />
							<div style="height: 4%;">
							<?php   echo $this->Form->input(null,array('name'=>'department_id','id'=>'department_id','empty'=>__('Select Anaesthetist'),'options'=> $departmentlist,
									'label' => false,'style'=>'width:190px;','div'=>false, 'class'=> ' safe','default'=>$getOptDetails['OptAppointment']['department_id']));?>
							</div>
							<?php $displayDD = ($type == 'hidden') ? 'none' : 'block';
								echo $this->Form->input(null, array('type'=>'hidden','name' => 'anaesthesia_service_group_id','id' => 'anaesthesia_service_group_id',
								'value'=>isset($getOptDetails['OptAppointment']['anaesthesia_service_group_id'])?$getOptDetails['OptAppointment']['anaesthesia_service_group_id']:$anesthesiaCategoryId['ServiceCategory']['id'],
              			 				'label'=> false, 'div' => false, 'error' => false));
									echo $this->Form->input(null,array('name' => 'anaesthesia_tariff_list_id', 'id'=> 'anaesthesia_tariff_list_id',
										 'empty'=>__('Select Service'), 'options'=> $services, 'label' => false,
										 'default' => $getOptDetails['OptAppointment']['anaesthesia_tariff_list_id'], 'style'=>'width:190px;'/*display:'.$displayDD*/));?>
						<?php 
							         echo $this->Form->input(null,array('name' => 'anaesthesia_cost','type'=>'hidden', 'id'=> 'anaesthesistCharge','label' => false,
									'value'=>$getOptDetails['OptAppointment']['anaesthesia_cost'],'div' => false, 'class' => ' digits safe',"style"=>"width:190px"));
                           ?>
						</div>
						<div>
							<?php echo __('Cardiologist'); ?><br />
							<div style="height: 4%;">
							<?php echo $this->Form->input(null,array('name' =>'cardiologist_id','id'=>'cardiologist_id','empty'=>__('Select Cardiologist'),'options'=> $cardiologist,
									'label' => false,'style'=>'width:190px;','div' => false, 'class'=> ' safe','default'=>$getOptDetails['OptAppointment']['cardiologist_id']));?>
									</div>
							<?php 
							     echo $this->Form->input(null,array('name' => 'cardiologist_charge','type'=>$type ,'id'=> 'cardiologistCharge','label' => false, 'div' => false,
									'value'=>$getOptDetails['OptAppointment']['cardiologist_charge'], 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
                            ?>
						</div>
						<?php $show = ($type == 'hidden') ? 'none' : 'block'  ?>
						<div style="float: left; width: 22%; display: <?php echo $show;?>">
							<?php echo __('OT Assistant'); ?><br />
							<?php 
								echo $this->Form->input(null,array('name' => 'ot_asst_charge','type'=>$type ,'id'=> 'otAsstCharge','value'=>$getOptDetails['OptAppointment']['ot_asst_charge'],
 									'label' => false, 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
                         	?>
						</div>
						<div style="float: left; display: <?php echo $show;?>">
							<?php echo __('OT Charges'); ?><br />
							<?php 
								echo $this->Form->input(null,array('name' => 'ot_charges','type'=>$type,'id'=> 'ot_charges','value'=>$getOptDetails['OptAppointment']['ot_charges'],
 									'label' => false, 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
                           ?>
						</div>
					</span>
					
					<div class="clr" style="height: 2%;"></div>
				<?php 
				
				$selectedServices = unserialize($getOptDetails['OptAppointment']['ot_service']);
				
				
				$toggle = 1;
                                $chargeType = ( $this->Session->read('hospitaltype') == 'NABH' ) ? 'nabh_charges' : 'non_nabh_charges';
                          
				foreach(Configure::read('otExtraServices') as $key =>$service){

					$checked = (array_key_exists($key, $selectedServices)) ? true : false;
					$width = ($toggle % 2 == 0) ? '50%' : '30%';
					?>
				<div class="twoCol" style="height: 20px; width: <?php echo $width?>;">
					<span>  <?php 
					$checkboxValue=$selectedServices[$key];
					if($checkboxValue==0)
						$checkboxfinalValue=$selectedServices[$service];
					else
						$checkboxfinalValue=$charges[$service."_discount"];
						
					echo $this->Form->checkbox(null,array('name'=>"ot_service[".$key."]",'id' =>$service,
							 'label'=> false,'value'=>$checkboxfinalValue,'checked'=>$checked,'hiddenField'=>false));
					?> </span><span style="font-size: 14px"> <?php echo __($key); ?></span>
				</div><?php $toggle++;?>
				<?php }?>
				
				</div>
								
				<?php } ?>
				<?php if($this->Session->read('website.instance') != 'kanpur'){?>
				<div class="clr"></div>
				<div class="twoCol" style="width: 250px;">
					<label> <span> <?php echo __('Surgeon'); ?><font color="red"> *</font>:
					</span> <?php echo $this->Form->input(null,array('name' => 'doctor_id', 'id'=> 'doctor_id', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist, 'label' => false,'default'=> $getOptDetails['OptAppointment']['doctor_id'], 'style'=>'width:190px;', 'class'=> 'required safe'));
					?>
					</label>
				</div>
				<div class="twoCol">
					<label> <span> <?php echo __('Cost To Hospital'); ?> <font
							color="red">*</font>:
					</span>
					</label>
					<?php if($this->Session->read('website.instance') == 'vadodara' ){
						$class='optional';
					}else{
						$class='required';
					}?>
					<?php  echo $this->Form->input(null, array('name' => 'cost_to_hospital','label'=> false, 'div' => false, 'error' => false, 'value'=>$getOptDetails['OptAppointment']['cost_to_hospital'],'class'=> "$class numbers")); ?>
				</div>
				<?php }?>
				<div class="twoCol" id="showSurgenServiceGroup" style="display:none;<?php //if($getOptDetails['OptAppointment']['surgen_service_group_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
					<label> <span> <?php echo __('Service Group'); ?> <font color="red">*</font>:
					</span> <?php
					echo $this->Form->input(null, array('name' => 'surgen_service_group_id', 'options' => $anaesServiceGroup, 'empty' => 'Select Service Group', 'id' => 'surgen_service_group_id','default' => $getOptDetails['OptAppointment']['surgen_service_group_id'], 'label'=> false, 'div' => false, 'error' => false));
					?>
					</label>
				</div>
				<div id="autoservice" class="twoCol" style="width:250px;display:none<?php //if($getOptDetails['OptAppointment']['surgen_service_group_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
					<label> <span>&nbsp;</span> <?php echo $this->Form->input(null,array('name' => 'autoservice', 'id'=> 'autoservicesearch',  "value"=>"Search Service",'label' => false, 'style'=>'width:190px;'));?>
					</label>
				</div>
				<div id="showSurgenService" class="twoCol" style=" display:none;<?php //if($getOptDetails['OptAppointment']['surgen_service_group_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
					<label> <span><?php echo __('Service')?><font color="red">*</font>:</span>
						<?php //echo $this->Form->input(null,array('name' => 'surgen_tariff_list_id', 'id'=> 'surgen_tariff_list_id', 'empty'=>__('Select Service'), 'options'=> $surgeon_services, 'label' => false, 'default' => $getOptDetails['OptAppointment']['tariff_list_id'], 'style'=>'width:190px;'));?>
					</label>
				</div>
				<?php if($this->Session->read('website.instance') != 'kanpur'){?>
				<div class="clr"></div>
				<?php /* ?>
					<div class="twoCol">
					<label> <span> <?php echo __('Cardiologist'); ?>:
					</span> <?php echo $this->Form->input(null,array('name' => 'card_id', 'id'=> 'cardiologist_id', 'empty'=>__('Select Cardiologist'),
            		'options'=> $cardiologist, 'label' => false,'default'=> $getOptDetails['OptAppointment']['department_id'], 'style'=>'width:190px;', 'class'=> 'safe'));?>
					</label>
					</div>
					<div class="clr"></div>
				<?php */?>
				<div class="twoCol">
					<label> <span> <?php echo __('Anaesthetist'); ?>:
					</span> <?php echo $this->Form->input(null,array('name' => 'department_id', 'id'=> 'department_id', 'empty'=>__('Select Anaesthetist'),'options'=> $departmentlist, 'label' => false,'default'=> $getOptDetails['OptAppointment']['department_id'], 'style'=>'width:190px;', 'class'=> 'safe'));?>
					</label>
				</div>


				<!-- <div class="twoCol" id="showAnaesthesiaServiceGroup" style="<?php if($getOptDetails['OptAppointment']['department_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
          <label>
            <span>
              <?php echo __('Service Group'); ?> <font color="red">*</font>:
            </span>
            <?php
              echo $this->Form->input(null, array('name' => 'anaesthesia_service_group_id', 'options' => $anaesServiceGroup,
			 'empty' => 'Select Service Group', 'id' => 'anaesthesia_service_group_id','value'=>isset($getOptDetails['OptAppointment']['anaesthesia_service_group_id'])?$getOptDetails['OptAppointment']['anaesthesia_service_group_id']:$anesthesiaCategoryId['ServiceCategory']['id'],
			'default' => $getOptDetails['OptAppointment']['anaesthesia_service_group_id'],'readonly'=>'readonly', 'label'=> false, 'div' => false, 'error' => false));
			
			//'onchange'=> $this->Js->request(array('action' => 'getAnaesthesiaServices'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			  //  'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#showAnaesthesiaService', 'data' => '{anaesthesia_service_group_id:$("#anaesthesia_service_group_id").val()}', 'dataExpression' => true)))); ?>
			     
           </label>
	</div>
	 <div class="twoCol" id="autoserviceAnaesthesia" style="width:250px;<?php //if($getOptDetails['OptAppointment']['department_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
          <label>
            <span>
              <?php echo __('Anaesthesia'); ?>:
            </span>
            <?php // echo $this->Form->input(null,array('name' => 'anaesthesia', 'id'=> 'anaesthesia', 'label' => false, "value"=>"Search Service" ,'style'=>'width:190px;'));?>
         <?php //echo $this->Form->hidden(null, array('type'=>'text','id'=>'anaesthesia','name' => 'anaesthesia')); ?>
          </label>
	</div>-->

				<div id="showAnaesthesiaService" class="twoCol" style="<?php if($getOptDetails['OptAppointment']['department_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
					<label> <span><?php 
					echo __('Service')?>:</span> <?php
					echo $this->Form->input(null, array('type'=>'hidden','name' => 'anaesthesia_service_group_id','id' => 'anaesthesia_service_group_id','value'=>isset($getOptDetails['OptAppointment']['anaesthesia_service_group_id'])?$getOptDetails['OptAppointment']['anaesthesia_service_group_id']:$anesthesiaCategoryId['ServiceCategory']['id'],
              			 'label'=> false, 'div' => false, 'error' => false));

			  echo $this->Form->input(null,array('name' => 'anaesthesia_tariff_list_id', 'id'=> 'anaesthesia_tariff_list_id', 'empty'=>__('Select Service'), 'options'=> $services, 'label' => false, 'default' => $getOptDetails['OptAppointment']['anaesthesia_tariff_list_id'], 'style'=>'width:190px;'));?>
					</label>
				</div>
				<div class="clr"></div>
				<div class="twoCol">
					<lable> <span> <?php echo __('Preference Card'); ?>
					</span> <?php 
					echo $this->Form->input(null,array('empty'=>'Please select','name'=>'preferencecard_id','options'=>$prefCard,'id' => 'card_title', 'label'=> false,'style'=> 'width:190px','value'=>$getOptDetails['OptAppointment']['preferencecard_id']));
					?> </lable>
				</div>
				<div class="clr"></div>
				<div class="twoCol">
					<label> <span> <?php echo __('Major/Minor'); ?>:
					</span> <?php echo $this->Form->input(null,array('name' => 'operation_type', 'id'=> 'operation_type', 'label' => false, 'div' => false, 'options' => array('major'=> 'Major', 'minor'=> 'Minor'), 'default'=> $getOptDetails['OptAppointment']['operation_type']));?>
					</label>
				</div>
				<?php }?>
				<div class="clr"></div>
				<label class="notForKanpur"> <span> <?php echo __('Procedure Complete'); ?>:
				<?php  if($this->params->query['procedurecomplete']) $selectedOption = $this->params->query['procedurecomplete'];
				?>
				</span> <?php 
				if($this->Session->read('website.instance')=='vadodara'){
				//For vadodara the there should not be yes option -- Pooja
						$proOptions=array('0'=>'No');
				}else{
					$proOptions=array('0' => 'No', '1' => 'Yes');
				}
				echo $this->Form->input(null,array('name' => 'procedurecomplete', 'id'=> 'procedurecomplete', 'options'=>$proOptions ,
						'label' => false, 'default' => $getOptDetails['OptAppointment']['procedure_complete'],'value'=>$selectedOption,'class'=>'editable'));
				?>
				</label>
				<?php if($getOptDetails['OptAppointment']['procedure_complete'] == 1){
					$displayTimeBlock = 'block';
						$addClass = 'required safe';
					}else{
						$displayTimeBlock = 'none';
						$addClass = '';
					}?>
				<div id="allottime" style="display:<?php echo $displayTimeBlock; ?>">
					<?php
					for ($i = 0; $i <= 23; $i++) {
						for($min = 0; $min <= 55 ; $min+=5){
							$hour = $i >= 10 ? $i : "0" . $i;
							$minute = $min >= 10 ? $min : "0" . $min;
							$time = $hour.":".$minute;
							$timeOptions[$time] = $time;
						}
					}
					?>

					<div style="width: 270px; float: left;">
						<span style="display: block; font-size: 13px; font-family: arial;">
							<?php echo __('OT In Time'); ?>:
						</span>
						<?php echo $this->Form->input(null, array( 'name' => 'ot_in_date', 'id' => 'ot_in_date', 'label'=> false, 'div' => false,'error' => false,
								 'class'=>$addClass.' allottime editable','value' => isset($otDateTime[0]) ? date('m/d/Y', strtotime($otDateTime[0])) : '')); ?>
						<?php echo $this->Form->input(null, array( 'name' => 'otintime', 'id' => 'otintime', 'label'=> false, 'div' => false,'error' => false,
								'class'=>$addClass.' allottime editable', 'options'=> $timeOptions, 'default' => isset($otDateTime[1])?$otDateTime[1]:'')); ?>
					</div>
					<?php if($this->Session->read('website.instance') != 'kanpur'){?>
					<div style="width: 270px; float: left;">
						<span style="display: block; font-size: 13px; font-family: arial;">
							<?php echo __('Incision Time'); ?>:
						</span>
						<?php echo $this->Form->input(null, array( 'name' => 'incision_date', 'id' => 'incision_date', 'label'=> false, 'div' => false,'error' => false,
								 'value' => isset($incisionDateTime[0])?date('m/d/Y', strtotime($incisionDateTime[0])):'','class'=>'editable')); ?>
						<?php echo $this->Form->input(null, array('name' => 'incisiontime', 'id' => 'incisiontime', 'label'=> false,'div' => false,'error' => false,
								 'options'=> $timeOptions, 'default' => isset($incisionDateTime[1])?$incisionDateTime[1]:'','class'=>'editable')); ?>
					</div>
					<div class="clr"></div>
					<div style="width: 270px; float: left;">
						<span style="display: block; font-size: 13px; font-family: arial;">
							<?php echo __('Skin Closure'); ?>:
						</span>
						<?php echo $this->Form->input(null, array( 'name' => 'skin_closure_date', 'id' => 'skin_closure_date', 'label'=> false, 'div' => false,
								'error' => false, 'value' => isset($skinClosureDateTime[0])?date('m/d/Y', strtotime($skinClosureDateTime[0])):'','class'=>'editable')); ?>
						<?php echo $this->Form->input(null, array('name' => 'skinclosure', 'id' => 'skinclosure', 'label'=> false,'div' => false,'error' => false,
								 'options'=> $timeOptions, 'default' => isset($skinClosureDateTime[1])?$skinClosureDateTime[1]:'','class'=>'editable')); ?>
					</div>
					<?php }?>
					<div style="width: 270px; float: left;">
						<span style="display: block; font-size: 13px; font-family: arial;">
							<?php echo __('Out Time'); ?>:
						</span>
						<?php echo $this->Form->input(null, array( 'name' => 'out_date', 'id' => 'out_date', 'label'=> false, 'div' => false,'error' => false,
								'class'=>$addClass.' allottime editable', 'value' => isset($outDateTime[0])?date('m/d/Y', strtotime($outDateTime[0])):'')); ?>
						<?php echo $this->Form->input(null, array('name' => 'outtime', 'id' => 'outtime', 'label'=> false,'div' => false,'error' => false,
								'class'=>$addClass.' allottime editable', 'options'=> $timeOptions, 'default' => isset($outDateTime[1])?$outDateTime[1]:'')); ?>
					</div>
				</div>

				<div class="clr"></div>
				<label> <span>Note: </span> <textarea cols="20" id="Description" name="note" rows="2" style="width: 95%; height: 70px"><?php echo isset($getOptDetails['OptAppointment']['id'])?$getOptDetails['OptAppointment']['description']:""; ?></textarea>
				</label>
				<?php echo $this->Form->input(null,array('name'=>'surgen_tariff_list_id','id'=> 'surgon_tariff_list_id','value'=>$getOptDetails['OptAppointment']['tariff_list_id'],'label' => false,'type'=>'hidden','div'=>false, 'style'=>'width:190px;'));?>

				<input id="timezone" name="timezone" type="hidden" value="" />
			</form>
		</div>
		<div class="toolBotton">
			<a id="Savebtn" class="imgbtn" href="javascript:void(0);"> <span
				class="Save" title="Save the calendar">Save </span>
			</a>
			<?php //if(isset($getOptDetails['OptAppointment']['id'])){ ?>
			<!--  <a id="Deletebtn" class="imgbtn" href="javascript:void(0);">
          <span class="Delete" title="Cancel the calendar" style="font-size:12px;">Delete
          </span>
        </a>-->
			<?php //} ?>
			<a id="Closebtn" class="imgbtn" href="javascript:void(0);"> <span
				class="Close" title="Close the window">Close </span>
			</a>

		</div>
	</div>


	<script>
	var websiteInstance = '<?php echo $this->Session->read('website.instance');?>';
$(document).ready(function(){
	
	if(websiteInstance == 'vadodara'){
		$("#calendarPatientNameText").autocomplete("<?php echo $this->Html->url(array("controller" => "Patients", "action" => "OTAutoComplete","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'calendarPatientNameText,calendarPatientNameValue',
			onItemSelect:function (data1) { 
				
			}
		});
	}else{
		$("#calendarPatientNameText").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocompleteForPatientNameAndDob",0,'Patient.admission_type=IPD&Patient.is_discharge=0','Patient.admission_id',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'calendarPatientNameText,calendarPatientNameValue',
			onItemSelect:function (data1) { 
				if(websiteInstance == 'kanpur'){
					var chargeType = "<?php echo $chargeType;?>";
					$.ajax({
				          url: "<?php echo $this->Html->url(array("action" => "getOtServiceCharges", "admin" => false)); ?>",
				          type: "GET",
				          dataType:"json",
				          data: "patientId="+$('#calendarPatientNameValue').val(),
				          success:   function (data) {
				        	  //var data = $.parseJSON(data); 
				            $.each( data, function( key, value ) {
					            $('input[name="ot_service['+value.TariffList.name+']"]').val($.trim(value.TariffAmount[chargeType]));
				            	console.log(value.TariffList.name);
				            	console.log(value.TariffAmount[chargeType]);
							});
				           }
				      });
				}
			}
		});
	}
	
	$("#surgery_auto").autocomplete("<?php echo $this->Html->url(array("controller" => "OptAppointments", "action" => "getSurgeryAutocomplete","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'surgery_auto,surgeryId',
		onItemSelect:function () { 
			console.log(data);
		}
	});

          $("#opt_id").change(function() {
          $('#busy-indicator').show();
          var data = 'opt_id=' + $('#opt_id').val() ;
          // for surgery category name field //
          $.ajax({url: "<?php echo $this->Html->url(array("action" => "getOptTableList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) {  $('#changeOptTableList').show(); $('#changeOptTableList').html(html);  $('#busy-indicator').hide();  } });

         });

         // show service group and service if anaesthetist select //
      /*  var departmentVal = $('#department_id').val(); alert(departmentVal);
         if(departmentVal) {
           $('#anaesthesia_service_group_id').attr("class", "required safe");
           $('#anaesthesia_tariff_list_id').attr("class", "required safe");
         } else {
           $('#anaesthesia_service_group_id').removeAttr("class", "required safe");
           $('#anaesthesia_tariff_list_id').removeAttr("class", "required safe");
         }
        $('#department_id').change(function(){
            departmentVal = $('#department_id').val();
                  if(departmentVal != "") {
                     $('#showAnaesthesiaServiceGroup').show();
                     $('#showAnaesthesiaService').show();
                     $('#anaesthesia_service_group_id').attr("class", "required safe");
                     $('#anaesthesia_tariff_list_id').attr("class", "required safe");
                  } else {
                     $('#showAnaesthesiaServiceGroup').hide();
                     $('#showAnaesthesiaService').hide();
                     $('#anaesthesia_service_group_id').removeAttr("class", "required safe");
                     $('#anaesthesia_tariff_list_id').removeAttr("class", "required safe");
                  }
          });*/
          if(websiteInstance == 'kanpur'){
        	  
          	if($('select[name=procedurecomplete]').val() == 1) {
                  $('#allottime').show('slow');
                  $('.allottime').addClass('required safe');
               } else {
                  $('#allottime').hide('slow');
                  $('.allottime').removeClass('required').removeClass('safe');
               }
          	if(parent.jQuery().fancybox) {
        		//  $("input").not(".editable").prop("readonly",true);
        		//  $("#fmEdit input:not(.editable)").prop("readonly",true);
        		  $( "#fmEdit input:not(.editable)" ).attr("readonly", "readonly");
        		  $( "#fmEdit select:not(.editable)" ).attr("disabled", "disabled");
        		  $('#editOnly').val(1);
        	}else{
            	$('.notForKanpur , .allottime, #allottime').hide();
        	}
  	        // drop down timepicker for OT in time //
  	        $('select[name=procedurecomplete]').change(function(){
  	                  if($('select[name=procedurecomplete]').val() == 1) {
  	                     $('#allottime').fadeIn('slow');
  	                     $('.allottime').addClass('required safe');
  	                  } else {
  	                	  $('#allottime').hide('slow');
  	                      $('.allottime').removeClass('required').removeClass('safe');
  	                  }
  	        });
          }
    	// for automatic patient search//
     /*   $("#admissionid").autocomplete("<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "autoSearchAdmissionId", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
                                onSelected: function(value) { alert(value);}
                        // on select change the patient name value automatically //
			}).result(function(event, optiondata, formatted) {
                          var paid = $('#admissionid').val();
                          var data = 'paid=' + paid ;
                          // for patient name field //
                         $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetPatientName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#patientname').val(html); $('#busy-indicator1').hide();} });
                         // for diagnosis field //
                         $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetDiagnosisName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#diagnosis').val(html); $('#busy-indicator1').hide();} });

                        });*/
        // for automatic patient search//
       /* $("#patientname").autocomplete("<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "autoSearchPatientName", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
                        // on select change the admission value automatically //
			}).result(function(event, data, formatted) {
                          var patientname = $('#patientname').val();
                          var patient_admissionid = patientname.substring(patientname.indexOf("(")-1, patientname.indexOf(")")+1);
                          $('#patientname').val(patientname.replace(patient_admissionid,''));
                          $('#admissionid').val(patient_admissionid.replace(/[\(\)\s]/g,''));
                          var paid = $('#admissionid').val();
                          var data = 'paid=' + paid ;
                          // for diagnosis field //
                          $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetDiagnosisName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#diagnosis').val(html); $('#busy-indicator1').hide();} });
                        });*/

         $("#surgery_category_id").change(function() {
			var category=$('#surgery_category_id option:selected').text();
			<?php if($this->Session->read('website.instance')=='vadodara'){?>
				 //if(category.contains("Dummy")){
				 if(category.indexOf("Dummy") > -1){
						$('#dummy_surgery').show();
	             }else{
	            	 $('#dummy_surgery').hide();
	             }
            <?php }?>
          $('#busy-indicator').show();
          //$('#changeSurgerySubcategoryList').hide();
          var surgery_category = $('#surgery_category_id').val();
          var data = 'surgery_category=' + surgery_category ;
          // for surgery category name field //
         /* $.ajax({
              url: "<?php echo $this->Html->url(array("action" => "getSurgerySubCategoryList", "admin" => false)); ?>",
              type: "GET",
              data: data,
              success:   function (html) {
                  if(html == "norecord"){
                       $('#changeSurgerySubCategoryList').hide();
                  } else {
                      $('#changeSurgerySubcategoryList').show();
                      $('#changeSurgerySubcategoryList').html(html);
                  }
                  $('#busy-indicator').hide();
               }
          });*/
          $.ajax({
              url: "<?php echo $this->Html->url(array("action" => "getSurgeryList", "admin" => false)); ?>",
              type: "GET",
              data: data,
              success:   function (html) {
              	$('#changeSurgeryList').show();
             	$('#changeSurgeryList').html(html);
             	if ( $("#surgery_id option[value='Dummy']").length != 0 ){
             	 $("#surgery_id option:selected").attr("Dummy", "selected");
             	}
             	$('#busy-indicator').hide(); 
              } 
          });
         });

         // remove error pop up //
         $(".infocontainer").click(function () {
           $("div:.cusErrorPanel").css({'display' : 'none'});
         });

 		


});


$('#doctor_id').change(function(){
            var surgenVal = $('#doctor_id').val();
                  /*if(surgenVal != "") {
                     $('#showSurgenServiceGroup').show();
                      $('#autoservice').show();
                     $('#showSurgenService').show();autoservice
                     $('#surgen_service_group_id').attr("class", "required safe");
                     $('#surgen_tariff_list_id').attr("class", "required safe");
                  } else {
                     $('#showSurgenServiceGroup').hide();
                      $('#autoservice').hide();
                     $('#showSurgenService').hide();
                     $('#surgen_service_group_id').removeAttr("class", "required safe");
                     $('#surgen_tariff_list_id').removeAttr("class", "required safe");
                  }*/
        });
 /*$(".surgeon").live('change',function() {
	 
	var surgeonOption = $('#doctor_id').val();
	var asstOneOption = $('#asstDoctorIdOne option:selected').text();
	var asstTwoOption = $('#asstDoctorIdTwo option:selected').text();alert(asstTwoOption);
	$("#doctor_id option[value*='"+asstOneOption+"/"+asstTwoOption+"']").prop('disabled',true);
	///$("#asstDoctorIdOne option[value*='"+surgeonOption+"/"+asstTwoOption+"']").prop('disabled',true);
//	$("#asstDoctorIdTwo option[value*='"+surgeonOption+"/"+asstOneOption+"']").prop('disabled',true);
	//$(".surgeon option[value=" + doc + "]").attr("disabled", "disabled");	
	//$('#doctor_id option:contains({"'+asstTwoOption+'" , "'+asstOneOption+'" })').attr("disabled","disabled");
});*/


$('#surgen_service_group_id').change(function(){
$('#autoservicesearch').val("Search Service");
$("#busy-indicator").fadeIn();
    $.ajax({async:true, beforeSend:function (XMLHttpRequest) {
 },
     complete:function (XMLHttpRequest, textStatus) { $("#busy-indicator").remove();$("#busy-indicator").fadeOut();},
      data:{anaesthesia_service_group_id:$("#surgen_service_group_id").val(),surgeon:"true"},
      dataType:"html",
      success:function (data, textStatus) {$("#showSurgenService").html(data);},
       url:"<?php echo $this->Html->url(array("action"=>'getAnaesthesiaServices'));?>"

        });
     });


$('#department_id').change(function(){
    var anesVal = $('#department_id').val();
          if(anesVal != "") {
             $('#showAnaesthesiaServiceGroup').show();
             $('#autoserviceAnaesthesia').show();
             $('#showAnaesthesiaService').show();
             $('#anaesthesia_service_group_id').attr("class", "required safe");
             $('#anaesthesia_tariff_list_id').attr("class", "required safe");
          } else {
             $('#showAnaesthesiaServiceGroup').hide();
             $('#autoserviceAnaesthesia').hide();
             $('#showAnaesthesiaService').hide();
             $('#anaesthesia_service_group_id').removeAttr("class", "required safe");
             $('#anaesthesia_tariff_list_id').removeAttr("class", "required safe");
          }
});
$('#anaesthesia_service_group_id').change(function(){
$('#anaesthesia').val("Search Service");
$("#busy-indicator").fadeIn();
$.ajax({async:true, beforeSend:function (XMLHttpRequest) {
},
complete:function (XMLHttpRequest, textStatus) { $("#busy-indicator").remove();$("#busy-indicator").fadeOut();},
data:{anaesthesia_service_group_id:$("#anaesthesia_service_group_id").val()},
dataType:"html",
success:function (data, textStatus) {$("#showAnaesthesiaService").html(data);},
url:"<?php echo $this->Html->url(array("action"=>'getAnaesthesiaServices'));?>"

});
});

/*
$('#anaesthesia_service_group_id').change(function(){
//$("#busy-indicator3").fadeIn();
    $.ajax({async:true, beforeSend:function (XMLHttpRequest) {
 },
     complete:function (XMLHttpRequest, textStatus) {$("#busy-indicator").remove();$("#busy-indicator3").fadeOut();},
      data:{anaesthesia_service_group_id:$("#anaesthesia_service_group_id").val()},
      dataType:"html",
      success:function (data, textStatus) {$("#showAnaesthesiaService").html(data);},
       url:"<?php echo $this->Html->url(array("action"=>'getAnaesthesiaServices'));?>"

        });
     });*/

$('#autoservicesearch').focus( function(){
     if(  $(this).val() =="Search Service"){
        $(this).val("");
    }
    if($('#surgen_service_group_id').val() ==""){
        alert("Please select Surgeon Service Group");
        return false;
    }
	$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList",
		 				                    "name",'null','null','service_category_id', "admin" => false,"plugin"=>false)); ?>/service_category_id="+$('#surgen_service_group_id').val(), {
                                            	matchSubset:1,
                            				matchContains:1,
                            				autoFill:true,
		 							    	onItemSelect:function (data) {
		 									var itemID = data.extra[0];
		 									$("#surgen_tariff_list_id").val(itemID);
		 								}
		 							}).result(function(event, data, formatted) {
	                                   $("#surgen_tariff_list_id").val(data[1]);
	                                   
                        });

});
$('#autoservicesearch').blur( function(){
    if($(this).val() == ""){
        $(this).val("Search Service");
    }
});

/*$(document).ready(function(){
$("#anaesthesia_id").autocomplete("<?php //echo $this->Html->url(array("controller" => "app", "action" => "autocomplete",
	//	"TariffList",'id','name','anaesthesia_id='.Configure::read('anaesthesiaId'),'service_category_id',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
	valueSelected:true,
	    showNoId:true,
	selectFirst: true,
	loadId : 'anaesthesia_id,anaesthesia'
	});
});*/


$('#anaesthesia').focus( function(){ 
    if(  $(this).val() =="Search Service"){
       $(this).val("");
   }
   if($('#anaesthesia_service_group_id').val() ==""){
       alert("Please select anaesthesia Service Group");
       return false;
   }
	$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList",
		 				                    "name",'null','null','service_category_id', "admin" => false,"plugin"=>false)); ?>/service_category_id="+$('#anaesthesia_service_group_id').val(), {
                                           	matchSubset:1,
                           				matchContains:1,
                           				autoFill:true,
		 							    	onItemSelect:function (data) {
		 									var itemID = data.extra[0];
		 									$("#anaesthesia_tariff_list_id").val(itemID);
		 								}
		 							}).result(function(event, data, formatted) {
	                                   $("#anaesthesia_tariff_list_id").val(data[1]);
                       });

});
$('#anaesthesia').blur( function(){
   if($(this).val() == ""){
       $(this).val("Search Service");
   }
});

$('#surgery_id').live('change',function(){
	var id =$(this).val();
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("action" => "getSurgeryTariff", "admin" => false)); ?>",
		  context: document.body,
		  beforeSend:function(data){
				$('#busy-indicator').show();
				},
		  data:'id='+id,		  	  		  
		  success: function(data){ 
			  $('#surgon_tariff_list_id').val($.trim(data));
			  $('#busy-indicator').hide();
			}
		  
	});
	if(websiteInstance == 'kanpur'){
		 $.ajax({
	          url: "<?php echo $this->Html->url(array("action" => "getOtRuleList", "admin" => false)); ?>",
	          type: "GET",
	          data: "surgery_id="+id+"&patientId="+$('#calendarPatientNameValue').val(),
	          beforeSend:function(data){
					$('#busy-indicator').show();
					},
	          success:   function (html) {
	             $('#updateOTRule').html(html);
	             $('#busy-indicator').hide();
	           }
	      });
    }
    
});
$(function (){
	if(websiteInstance == 'kanpur' && $('#doctor_id').val() == ''){
		 $.ajax({
	          url: "<?php echo $this->Html->url(array("action" => "getOtRuleList", "admin" => false)); ?>",
	          type: "GET",
	          data: "surgery_id="+$('#surgery_id').val()+"&tariff_standard_id=<?php echo $getPatientDetaiils['Patient']['tariff_standard_id'];?>",
	          beforeSend:function(data){
					$('#busy-indicator').show();
					},
	          success:   function (html) {
	             $('#updateOTRule').html(html);
	             $('#busy-indicator').hide();
	           }
	      });
   }
});

  </script>