<?php
// echo $this->element('patient_information');?> 
	<link href="<?php echo $this->Html->url('/wdcss/dailog.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->Html->url('/wdcss/calendar.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->Html->url('/wdcss/dp.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->Html->url('/wdcss/alert.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->Html->url('/wdcss/main.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->Html->url('/wdcss/colorselect.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->Html->url('/wdcss/Error.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->Html->url('/wdcss/dropdown.css'); ?>" rel="stylesheet" type="text/css" />
 
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/Common.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/datepicker_lang_US.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/wdCalendar_lang_US.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.datepicker.js'); ?>" type="text/javascript"></script>

    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.alert.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.ifrmdailog.js'); ?>" defer="defer" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.form.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.calendar.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.dropdown.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.colorselect.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.validate.js'); ?>" type="text/javascript"></script>

    <script type="text/javascript">
    	//var jQuery = jQuery.noConflict();
    	
        jQuery(document).ready(function() {
            

           var view="week";

           var DATA_FEED_URL = "<?php echo $this->Html->url('/NewOptAppointments/datafeed/'); ?>"; 
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
                url: DATA_FEED_URL + "?method=list&patient_id=<?php echo $patient_id; ?>",
                quickAddUrl: DATA_FEED_URL + "?method=add",
                quickUpdateUrl: DATA_FEED_URL + "?method=update",
                quickDeleteUrl: DATA_FEED_URL + "?method=remove"


            };
            var $dv = jQuery("#calhead");
            var _MH = document.documentElement.clientHeight;
            var dvH = $dv.height() + 2;
            op.height = _MH - dvH;
            op.eventItems =[];

            var p = jQuery("#gridcontainer").bcalendar(op).BcalGetOp(); 
            
            if (p && p.datestrshow) {
                jQuery("#txtdatetimeshow").text(p.datestrshow);
            }
            jQuery("#caltoolbar").noSelect();

            jQuery("#hdtxtshow").datepicker({ picker: "#txtdatetimeshow", showtarget: jQuery("#txtdatetimeshow"),
            onReturn:function(r){
                            var p = jQuery("#gridcontainer").gotoDate(r).BcalGetOp();
                            if (p && p.datestrshow) {
                                jQuery("#txtdatetimeshow").text(p.datestrshow);
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
                jQuery("#errorpannel").hide();
                jQuery("#loadingpannel").html(t).show();
            }
            function cal_afterrequest(type)
            {
                switch(type)
                {
                    case 1:
                        jQuery("#loadingpannel").hide();
                        break;
                    case 2:
                    case 3:
                    case 4:
                        window.location = "<?php echo $this->Html->url(array("controller" => "new_opt_appointments", "action" => "otevent", $patient_id));?>";
                        //jQuery("#loadingpannel").html("Success!");
                        //window.setTimeout(function(){ jQuery("#loadingpannel").hide();},2000);
                    break;
                }
				 
                if (p && p.datestrshow) {
                    jQuery("#txtdatetimeshow").text(p.datestrshow);
                }

            }
            function cal_onerror(type,data)
            {
                jQuery("#errorpannel").show();
            }
            function Edit(data){                         
               var eurl="<?php echo $this->Html->url('/new_opt_appointments/ot_editevent/'); ?>?id={0}&start={2}&end={3}&isallday={4}&title={1}&patient_id={10}";

                if(data)
                {
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 1550, height: 620, caption:"Schedule  OR Appointment",onclose:function(){
                       jQuery("#gridcontainer").reload();
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
                hiConfirm("Are You Sure to Delete this Appointment", 'Confirm',function(r){ r && callback(0);});
            }
            function wtd(p)
            {
               if (p && p.datestrshow) {
                    jQuery("#txtdatetimeshow").text(p.datestrshow);
                }
                jQuery("#caltoolbar div.fcurrent").each(function() {
                    jQuery(this).removeClass("fcurrent");
                })
                jQuery("#showdaybtn").addClass("fcurrent");
            }
            //to show day view
            jQuery("#showdaybtn").click(function(e) {
                //document.location.href="#day";
                jQuery("#caltoolbar div.fcurrent").each(function() {
                    jQuery(this).removeClass("fcurrent");
                })
                jQuery(this).addClass("fcurrent");
                var p = jQuery("#gridcontainer").swtichView("day").BcalGetOp();
                if (p && p.datestrshow) {
                    jQuery("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            //to show week view
            jQuery("#showweekbtn").click(function(e) {
                //document.location.href="#week";
                jQuery("#caltoolbar div.fcurrent").each(function() {
                    jQuery(this).removeClass("fcurrent");
                })
                jQuery(this).addClass("fcurrent");
                var p = jQuery("#gridcontainer").swtichView("week").BcalGetOp();
                if (p && p.datestrshow) {
                    jQuery("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //to show month view
            jQuery("#showmonthbtn").click(function(e) {
                //document.location.href="#month";
                
                jQuery("#caltoolbar div.fcurrent").each(function() {
                    jQuery(this).removeClass("fcurrent");
                })
                jQuery(this).addClass("fcurrent");
                var p = jQuery("#gridcontainer").swtichView("month").BcalGetOp();
                if (p && p.datestrshow) {
                    jQuery("#txtdatetimeshow").text(p.datestrshow);
                }
            });

            jQuery("#showreflashbtn").click(function(e){
                jQuery("#gridcontainer").reload();
            });

            //Add a new event
            jQuery("#faddbtn").click(function(e) {
                var url ="<?php echo $this->Html->url('/new_opt_appointments/ot_editevent/?patient_id='.$patient_id); ?>";
                OpenModelWindow(url,{ width: 600, height: 570, caption: "Schedule New Appointment"});
            });
            //go to today
            jQuery("#showtodaybtn").click(function(e) {
                var p = jQuery("#gridcontainer").gotoDate().BcalGetOp();
                if (p && p.datestrshow) {
                    jQuery("#txtdatetimeshow").text(p.datestrshow);
                }


            });
            //previous date range
            jQuery("#sfprevbtn").click(function(e) {
                var p = jQuery("#gridcontainer").previousRange().BcalGetOp();
                if (p && p.datestrshow) {
                    jQuery("#txtdatetimeshow").text(p.datestrshow);
                }
                jQuery("#gridcontainer").reload();
            });
            //next date range
            jQuery("#sfnextbtn").click(function(e) {
                var p = jQuery("#gridcontainer").nextRange().BcalGetOp();
                if (p && p.datestrshow) {
                    jQuery("#txtdatetimeshow").text(p.datestrshow);
                }
                jQuery("#gridcontainer").reload();
            });
        });
    </script>
<div class="inner_title">
	<?php
			$complete_name  = $patient[0]['lookup_name'] ;
			//echo __('Set Appoinment For-')." ".$complete_name;
	?>
	<h3>  &nbsp; <?php echo __('OT Appoinments')?></h3>
	<span> <?php echo $this->Html->link(__('Back'),array('controller'=>'OptAppointments','action' => 'dashboard_index'), array('escape' => false,'class'=>'blueBtn')); ?></span>
</div>
<div class="patient_info">
 
</div>
<div class="clr"></div>
    <div>
      <div id="calhead" style="padding-left:1px;padding-right:1px;">
            <div class="cHead"><div class="ftitle"><?php echo __('OR Appointment'); ?></div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading data...</div>
             <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>
            </div>

            <div id="caltoolbar" class="ctoolbar">
              <!-- <div id="faddbtn" class="fbutton">
                <div><span title='Click to Create New Event' class="addcal">
                 <?php echo __('Schedule OR Appointment'); ?>
                </span></div>
            </div> -->
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
                        <span id="txtdatetimeshow">Loading</span>

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


