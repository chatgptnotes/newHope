    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo __('Staff Plan'); ?></title>
	<link href="<?php echo $this->Html->url('/wdcss/calendar.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/dp.css'); ?>" rel="stylesheet" type="text/css" />   
    <link href="<?php echo $this->Html->url('/wdcss/alert.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/colorselect.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/Error.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/main.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->Html->url('/wdcss/dropdown.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/dailog.css'); ?>" rel="stylesheet" type="text/css" />
    
    
    <script src="<?php echo $this->Html->url('/wdsrc/jquery.js'); ?>" type="text/javascript"></script>  
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/Common.js'); ?>" type="text/javascript"></script>    
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/datepicker_lang_US.js'); ?>" type="text/javascript"></script>     
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.datepicker.js'); ?>" type="text/javascript"></script>

    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.alert.js'); ?>" type="text/javascript"></script>    
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.ifrmdailog.js'); ?>" defer="defer" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/wdCalendar_lang_US.js'); ?>" type="text/javascript"></script>    
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.calendar.js'); ?>" type="text/javascript"></script> 
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.dropdown.js'); ?>" type="text/javascript"></script> 
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.colorselect.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.validate.js'); ?>" type="text/javascript"></script>   
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.form.js'); ?>" type="text/javascript"></script>
    
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
            //debugger;
            var DATA_FEED_URL = "<?php echo $this->Html->url('/staff_plans/datafeed/'); ?>";
            var arrT = [];
            var tt = "{0}:{1}";
            for (var i = 0; i < 24; i++) {
                arrT.push({ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "00"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "15"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "30"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "45"]) });
            }
            $("#timezone").val(new Date().getTimezoneOffset()/60 * -1);
            $("#stparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
                selectedchange: function() { },
                items: arrT
            });
            $("#etparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
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
            
           $("#stpartdate,#etpartdate").datepicker({ picker: "<button class='calpick'></button>"});    
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
        });
    </script>      
    <style type="text/css">     
    .calpick     {        
        width:16px;   
        height:16px;     
        border:none;        
        cursor:pointer;        
        background:url("<?php echo $this->Html->url('/wdcss/sample-css/cal.gif'); ?>") no-repeat center 2px;        
        margin-left:-22px;    
    }      
    </style>
  </head>
  <body>    
    <div>      
                        
      <div style="clear: both">         
      </div>        
      <div class="infocontainer">            
        <form action="<?php echo $this->Html->url('/staff_plans/datafeed/'); ?>?method=adddetails<?php echo isset($getStaffPlan['StaffPlan']['id'])?"&id=".$getStaffPlan['StaffPlan']['id']:""; ?>" class="fform" id="fmEdit" method="post">    
        <div align="center" id="busy-indicator1" style="display: none;">	
<?php echo $this->Html->image('indicator.gif'); ?>
</div>             
          <label>                    
            <span>  
              Subject<font color="red">*</font>:              
            </span>                    
            <div id="calendarcolor">
            </div>
            <input MaxLength="200" class="required safe" id="Subject" name="subject" style="width:85%;" type="text" value="<?php echo isset($getStaffPlan['StaffPlan']['subject'])?$getStaffPlan['StaffPlan']['subject']:"" ?>" />                     
            <input id="colorvalue" name="colorvalue" type="hidden" value="<?php echo isset($getStaffPlan['StaffPlan']['color'])?$getStaffPlan['StaffPlan']['color']:"" ?>" />                
          </label>                 
          <label>                    
            <span>Date & Time <font color="red">*</font>:
            </span>                    
            <div>  
            <?php 
                $sdate ="";
				$stime = "";
			 	if(isset($startDate)){
				 	if (isset($getStaffPlan['StaffPlan']['id'])) {
				 		 $sdate = date("n/j/Y", strtotime($sarr1[0]));
				 		 $stime = $sarr1[1];
					} else {
					$dateTime = explode("_",$startDate); 
					$sdate = $dateTime[0];
					$stime = $dateTime[1];
					}
				}
			?>                   
              <input MaxLength="10" class="required date" id="stpartdate" name="stpartdate" style="padding-left:2px;width:100px;" type="text" value="<?php echo $sdate; ?>" />                       
              <input MaxLength="5" class="required time" id="stparttime" name="stparttime" style="width:60px;" type="text" value="<?php echo $stime; ?>" /><span style="font-size:12px;">To</span>                      
              <input MaxLength="10" class="required date" id="etpartdate" name="etpartdate" style="padding-left:2px;width:90px;" type="text" value="<?php echo isset($getStaffPlan['StaffPlan']['id'])?$earr1[0]:""; ?>" />                       
              <input MaxLength="50" class="required time" id="etparttime" name="etparttime" style="width:60px;" type="text" value="<?php echo isset($getStaffPlan['StaffPlan']['id'])?$earr1[1]:""; ?>" />                                            
              <label class="checkp"> 
                <input id="IsAllDayEvent" name="is_all_day_event" type="checkbox" value="1" <?php if(isset($getStaffPlan['StaffPlan']['id'])&&$getStaffPlan['StaffPlan']['is_all_day_event']!=0) {echo "checked";} ?>/>          All Day Event                      
              </label>                    
            </div>                
          </label> 
       	 <div class="clr"></div>
         <div style="padding-top:10px"> 
          <label class="leftLabel">  
                 <span>   
             <?php echo __('User List')?><font color="red">*</font>:
            </span>  
            <?php echo $this->Form->input(null,array('name' => 'user_id', 'id'=> 'user_id', 'empty'=>__('Select User'), 'options'=> $getUserList, 'label' => false, 'default' => $getStaffPlan['StaffPlan']['user_id'], 'class' => 'required safe', 'style' => 'width:450px;'));?>
	    </label>
	   </div>
	   <div class="clr"></div>
           <label>
            <span>                        Details:
            </span>                    
<textarea cols="20" id="Description" name="purpose" rows="2" style="width:95%; height:110px">
<?php echo isset($getStaffPlan['StaffPlan']['id'])?$getStaffPlan['StaffPlan']['purpose']:""; ?>
</textarea>                
          </label>              
          <input id="timezone" name="timezone" type="hidden" value="" />           
        </form>         
      </div>  
     <div class="toolBotton">           
        <a id="Savebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Save"  title="Save the calendar">Save
          </span>          
        </a>                           
        <?php if(isset($getOtDetails['StaffPlan']['id'])){ ?>
        <a id="Deletebtn" class="imgbtn" href="javascript:void(0);">                    
          <span class="Delete" title="Cancel the calendar">Delete
          </span>                
        </a>             
        <?php } ?>            
        <a id="Closebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Close" title="Close the window" >Close
          </span></a>            
        </a>        
      </div>       
    </div>
    <link href="<?php echo $this->Html->url('/css/jquery.autocomplete.css'); ?>" rel="stylesheet" type="text/css" /> 
    <script src="<?php echo $this->Html->url('/js/jquery.autocomplete.js'); ?>" type="text/javascript"></script> 
    
    
 <script>
$(document).ready(function(){
   
         // remove error pop up //
         $(".infocontainer").click(function () {
           $("div:.cusErrorPanel").css({'display' : 'none'});
         });

         
		
});
  </script>
   </body>
</html>