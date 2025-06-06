    <link href="<?php echo $this->Html->url('/wdcss/dailog.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->Html->url('/wdcss/calendar.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/dp.css'); ?>" rel="stylesheet" type="text/css" />   
    <link href="<?php echo $this->Html->url('/wdcss/alert.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/main.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/colorselect.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/Error.css'); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo $this->Html->url('/wdcss/dropdown.css'); ?>" rel="stylesheet" type="text/css" /> 
    
    

    <script src="<?php echo $this->Html->url('/wdsrc/jquery.js'); ?>" type="text/javascript"></script>  
    
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/Common.js'); ?>" type="text/javascript"></script>    
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/datepicker_lang_US.js'); ?>" type="text/javascript"></script>     
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.datepicker.js'); ?>" type="text/javascript"></script>

    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.alert.js'); ?>" type="text/javascript"></script>    
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.ifrmdailog.js'); ?>" defer="defer" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.form.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/wdCalendar_lang_US_StaffPlan.js'); ?>" type="text/javascript"></script>    
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.calendar.js'); ?>" type="text/javascript"></script> 
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.dropdown.js'); ?>" type="text/javascript"></script> 
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.colorselect.js'); ?>" type="text/javascript"></script> 
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.validate.js'); ?>" type="text/javascript"></script>  
    
    <script type="text/javascript">
        $(document).ready(function() {    
		   $('#getExcelReport').click(function() {
			 var filterDate = $('#txtdatetimeshow').text();
			 window.location.href  = "<?php echo $this->Html->url('/staff_plans/staff_plan_xls/'); ?>"+filterDate;
			 
		   });
           var view="week";          
           
            //var DATA_FEED_URL = "php/datafeed.php";
           var DATA_FEED_URL = "<?php echo $this->Html->url('/staff_plans/datafeed/'); ?>";
            var op = {
                view: view,
                theme:3,
                showday: new Date(),
                EditCmdhandler:Edit,
                DeleteCmdhandler:Delete,
                ViewCmdhandler:View,    
                onWeekOrMonthToDay:wtd,
                onBeforeRequestData: cal_beforerequest,
                onAfterRequestData: cal_afterrequest,
                onRequestDataError: cal_onerror, 
                autoload:true,
                url: DATA_FEED_URL + "?method=list",  
                quickAddUrl: DATA_FEED_URL + "?method=add", 
                quickUpdateUrl: DATA_FEED_URL + "?method=update",
                quickDeleteUrl: DATA_FEED_URL + "?method=remove"       
                
                
            };
            var $dv = $("#calhead");
            var _MH = document.documentElement.clientHeight;
            var dvH = $dv.height() + 2;
            op.height = _MH - dvH;
            op.eventItems =[];

            var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            $("#caltoolbar").noSelect();
            
            $("#hdtxtshow").datepicker({ picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
            onReturn:function(r){                          
                            var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                            if (p && p.datestrshow) {
                                $("#txtdatetimeshow").text(p.datestrshow);
                            }
                     } 
            });
            function cal_beforerequest(type)
            {
                var t="Loading data...";
                switch(type)
                {
                    case 1:
                        t="Loading data...";
                        break;
                    case 2:                      
                    case 3:  
                    case 4:    
                        t="The request is being processed ...";                                   
                        break;
                }
                
                $("#errorpannel").hide();
                $("#loadingpannel").html(t).show(); 
                   
            }
            function cal_afterrequest(type)
            {
                switch(type)
                {
                    case 1:
                        $("#loadingpannel").hide();
                        break;
                    case 2:
                        
                    case 3:
                        
                    case 4:
                        window.location = "<?php echo $this->Html->url(array("controller" => "StaffPlans", "action" => "staffplan"));?>";
                        //$("#loadingpannel").html("Success!");
                        //window.setTimeout(function(){ $("#loadingpannel").hide();},2000);
                    break; 
                }              
               
            }
            function cal_onerror(type,data)
            { 
                $("#errorpannel").show();
            }
            function Edit(data)
            {
               var eurl="<?php echo $this->Html->url('/staff_plans/staffplan_edit/'); ?>?id={0}&start={2}&end={3}&isallday={4}&title={1}";   
                if(data)
                {
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 550, height: 380, caption:"Manage  The Staff Plan",onclose:function(){
                       $("#gridcontainer").reload();
                    }});
                }
            }    
            function View(data)
            {
                var str = "";
                $.each(data, function(i, item){
                    str += "[" + i + "]: " + item + "\n";
                });
                //alert(str);               
            }    
            function Delete(data,callback)
            {           
                
                $.alerts.okButton="Ok";  
                $.alerts.cancelButton="Cancel";  
                hiConfirm("Are You Sure to Delete this Plan", 'Confirm',function(r){ r && callback(0);});           
            }
            function wtd(p)
            {
               if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $("#showdaybtn").addClass("fcurrent");
            }
            //to show day view
            $("#showdaybtn").click(function(e) {
                //document.location.href="#day";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("day").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            //to show week view
            $("#showweekbtn").click(function(e) {
                //document.location.href="#week";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("week").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //to show month view
            $("#showmonthbtn").click(function(e) {
                //document.location.href="#month";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("month").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            
            $("#showreflashbtn").click(function(e){
                $("#gridcontainer").reload();
            });
            
            //Add a new event
            $("#faddbtn").click(function(e) {
                var url ="<?php echo $this->Html->url('/staff_plans/staffplan_edit/'); ?>";
                OpenModelWindow(url,{ width: 500, height: 400, caption: "Create New Plan"});
            });
            //go to today
            $("#showtodaybtn").click(function(e) {
                var p = $("#gridcontainer").gotoDate().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }


            });
            //previous date range
            $("#sfprevbtn").click(function(e) {
                var p = $("#gridcontainer").previousRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                $("#gridcontainer").reload();
            });
            //next date range
            $("#sfnextbtn").click(function(e) {
                var p = $("#gridcontainer").nextRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                $("#gridcontainer").reload();
            });
            
        });
    </script>    
    <div>
     
      <div id="calhead" style="padding-left:1px;padding-right:1px;">         
            <div class="cHead"><div class="ftitle"><?php echo __('Staff Plan'); ?>
			<!--  <span style="float:right;cursor:pointer;" id="getExcelReport">Get Report</span>-->
			</div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading data...</div>
             <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>
            </div>          
            
            <div id="caltoolbar" class="ctoolbar">
              <div id="faddbtn" class="fbutton">
                <div><span title='Click to Create New Event' class="addcal">
                 <?php echo __('New Staff Plan'); ?>                
                </span></div>
            </div>
            <div class="btnseparator"></div>
             <div id="showtodaybtn" class="fbutton">
                <div><span title='Click to back to today ' class="showtoday">
                Today</span></div>
            </div>
              <div class="btnseparator"></div>

            <div id="showdaybtn" class="fbutton">
                <div><span title='Day' class="showdayview">Day</span></div>
            </div>
              <div  id="showweekbtn" class="fbutton fcurrent">
                <div><span title='Week' class="showweekview">Week</span></div>
            </div>
              <div  id="showmonthbtn" class="fbutton">
                <div><span title='Month' class="showmonthview">Month</span></div>

            </div>
            <div class="btnseparator"></div>
              <div  id="showreflashbtn" class="fbutton">
                <div><span title='Refresh view' class="showdayflash">Refresh</span></div>
                </div>
             <div class="btnseparator"></div>
            <div id="sfprevbtn" title="Prev"  class="fbutton">
              <span class="fprev"></span>

            </div>
            <div id="sfnextbtn" title="Next" class="fbutton">
                <span class="fnext"></span>
            </div>
            <div class="fshowdatep fbutton">
                    <div>
                        <input type="hidden" name="txtshow" id="hdtxtshow" />
                        <span id="txtdatetimeshow"><?php echo $daysCurrentMondays. ' - '.$daysCurrentSundays ?></span>

                    </div>
					
            </div>
            
            <div class="clear"></div>
            </div>
      </div>
      <div style="padding:1px;">

        <div class="t1 chromeColor">
            &nbsp;</div>
        <div class="t2 chromeColor">
            &nbsp;</div>
        <div id="dvCalMain" class="calmain printborder">
            <div id="gridcontainer" style="overflow-y: visible;">
            </div>
        </div>
        <div class="t2 chromeColor">

            &nbsp;</div>
        <div class="t1 chromeColor">
            &nbsp;
        </div>   
        </div>
     
  </div>
    

