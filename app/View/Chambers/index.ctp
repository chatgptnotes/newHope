<link href="<?php echo $this->Html->url('/wdcss/dailog.css'); ?>"
	rel="stylesheet" type="text/css" />
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
	href="<?php echo $this->Html->url('/wdcss/main.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/colorselect.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/Error.css'); ?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo $this->Html->url('/wdcss/dropdown.css'); ?>"
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
	src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.form.js'); ?>"
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
<?php 
echo $this->Html->script('scrollPaging.js');
?>
<script type="text/javascript">

    
    
        $(document).ready(function() {     
           var view="week";          
           
            //var DATA_FEED_URL = "php/datafeed.php";
           var DATA_FEED_URL = "<?php echo $this->Html->url('/Chambers/datafeed/'); ?>";
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
                enableDrag:false,
                calenderStart: <?php echo Configure::read('calendar_start_time')?>,
                calenderEnd: <?php echo Configure::read('calendar_end_time')?>,
                url: DATA_FEED_URL + "?method=list<?php echo "&doctor_id=".$this->params->query['doctor_id'].'&chamber_id='.$this->params->query['chamber_id'];?>",  
                quickAddUrl: DATA_FEED_URL + "?method=add<?php echo "&doctor_id=".$this->params->query['doctor_id'].'&chamber_id='.$this->params->query['chamber_id'];?>", 
                quickUpdateUrl: DATA_FEED_URL + "?method=update<?php echo "&doctor_id=".$this->params->query['doctor_id'].'&chamber_id='.$this->params->query['chamber_id'];?>",
                quickDeleteUrl: DATA_FEED_URL + "?method=remove<?php echo "&doctor_id=".$this->params->query['doctor_id'].'&chamber_id='.$this->params->query['chamber_id'];?>",
                dateformat:"ddMMyyyy"  
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
                        window.location = "<?php echo $this->Html->url(array("controller" => "Chambers", "action" => "index",'?doctor_id='.$this->params->query['doctor_id'].'&chamber_id='.$this->params->query['chamber_id']));?>";
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
               var eurl="<?php echo $this->Html->url('/Chambers/edit_chamber/'.'?doctor_id='.$this->params->query['doctor_id'].'&chamber_id='.$this->params->query['chamber_id']); ?>&id={0}&start={2}&end={3}&isallday={4}&title={1}";   
                if(data)
                {
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 600, height: 335, caption:"Manage Doctor Blocked Time",onclose:function(){
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
                alert(str);             
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
               
                var url ="<?php echo $this->Html->url('/chambers/edit_chamber/'); ?>";
                OpenModelWindow(url,{ width: 600, height: 464, caption: "Manage Doctor Chamber"});
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

            $("#doctor_id,#chamber_id").change(function(){
    			//if($(this).val() != ''){
    				$('#Chamberfrm').submit();
    			//}
    		}); 
        });

        
    </script>
<style>
input,select {
	padding: 0px;
	border: 1px solid #575C5D;
	color: #E7EEEF;
	font-size: 13px;
	outline: medium none;
	resize: none;
}

.selectProvider {
	border-radius: 25px;
	height: 22px;
	text-align: center;
	width: 54% !important;
}
</style>
<div>
	<!--<div class="inner_title">
			<?php 
				if($doctor_name){
			?><h3>Doctor  : <?php  echo ucwords($doctor_name); ?></h3>
			<?php }
				if($chamber_name){
			?>
			<h3>Chamber : <?php echo ucfirst($chamber_name); ?></h3>
			<?php } ?>
			<span><?php echo $this->Html->link(__('Back'),array('action'=>'chamber_scheduling'),array('escape'=>false,'class'=>'blueBtn'));?></span>
		</div>
		
      -->
	<?php echo $this->Form->create('Chamber',array('controller'=>'Chamber','action'=>'index','type'=>'get','id'=>'Chamberfrm','admin'=>true));?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" align="center">
		<tr>
			<td class="" style="text-align: end;"><?php echo __('Select Doctor'); ?>
			</td>
			<td><?php  
			echo $this->Form->input('Chamber.doctor_id', array('empty'=>__('Please select'),'class' => 'validate[required,custom[mandatory-select]] selectProvider' ,
			        	'label'=> false, 'div' => false, 'error' => false,'id'=>'doctor_id' ,'value'=>$this->params->query['doctor_id'])  );
			        ?>
			</td>
			<td width="70%">&nbsp;</td>
			<!-- <td class=" " width="50%">
					<?php //echo __('Select Chamber'); ?> 
				 
			        <?php 
			        	//echo $this->Form->input('Chamber.chamber_id', array('empty'=>__('Please select'),'class' => 'validate[required,custom[mandatory-select]]',
			        	// 'label'=> false, 'div' => false, 'error' => false,'id'=>'chamber_id','style'=>'width:50%;','value'=>$this->params->query['chamber_id'])  );
			        ?>
				</td> -->
		</tr>
		<!--<tr>
			<td colspan="2" align="center">
			<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));?>
			&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
			</td>
			</tr>
			-->
	</table>
	<?php echo $this->Form->end();?>
	<div id="calhead" style="padding-left: 1px; padding-right: 1px;">
		<div class="cHead">
			<div class="ftitle">
				<?php echo __('Exam Room Blocked Time'); ?>
			</div>
			<div id="loadingpannel" class="ptogtitle loadicon"
				style="display: none;">Loading data...</div>
			<div id="errorpannel" class="ptogtitle loaderror"
				style="display: none;">Sorry, could not load your data, please try
				again later</div>
		</div>

		<div id="caltoolbar" class="ctoolbar">
			<div id="faddbtn" class="fbutton">
				<div>
					<span title='Click to Create New Event' class="addcal"> <?php echo __('New Scheduling'); ?>
					</span>
				</div>
			</div>
			<div class="btnseparator"></div>
			<div id="showtodaybtn" class="fbutton">
				<div>
					<span title='Click to back to today ' class="showtoday"> Today</span>
				</div>
			</div>
			<div class="btnseparator"></div>

			<div id="showdaybtn" class="fbutton">
				<div>
					<span title='Day' class="showdayview">Day</span>
				</div>
			</div>
			<div id="showweekbtn" class="fbutton fcurrent">
				<div>
					<span title='Week' class="showweekview">Week</span>
				</div>
			</div>
			<div id="showmonthbtn" class="fbutton">
				<div>
					<span title='Month' class="showmonthview">Month</span>
				</div>

			</div>
			<div class="btnseparator"></div>
			<div id="showreflashbtn" class="fbutton">
				<div>
					<span title='Refresh view' class="showdayflash">Refresh</span>
				</div>
			</div>
			<div class="btnseparator"></div>
			<div id="sfprevbtn" title="Prev" class="fbutton">
				<span class="fprev"></span>

			</div>
			<div id="sfnextbtn" title="Next" class="fbutton">
				<span class="fnext"></span>
			</div>
			<div class="fshowdatep fbutton">
				<div>
					<input type="hidden" name="txtshow" id="hdtxtshow" /> <span
						id="txtdatetimeshow">Loading</span>

				</div>
			</div>

			<div class="clear"></div>
		</div>
	</div>
	<div style="padding: 1px;">

		<div class="t1 chromeColor">&nbsp;</div>
		<div class="t2 chromeColor">&nbsp;</div>
		<div id="dvCalMain" class="calmain printborder">
			<div id="gridcontainer" style="overflow-y: visible;"></div>
		</div>
		<div class="t2 chromeColor">&nbsp;</div>
		<div class="t1 chromeColor">&nbsp;</div>
	</div>

</div>
