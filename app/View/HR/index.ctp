<style>
    .block{ 
        outline: 1px solid;
        -moz-outline-radius:10px;
        -webkit-outline-radius:10px;
        outline-radius:10px;
        padding: 5px;
    } 
    .monthTd:hover{
        background-color: white !important;
        color: black !important;
        cursor: pointer;
    } 
    .row_title td.setActive {
        background-color: white !important;
        color: black !important; 
    }
    label{
        float:none;
        margin-right: 0px;
        padding-top: opx;
        width: none;
    } 
</style>
 <?php  echo $this->Html->script(array('jquery.blockUI')); ?>
<div class="inner_title">
    <?php echo $this->element('navigation_menu',array('pageAction'=>'HR')); ?>
<h3>&nbsp; <?php echo __('HR Masters', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<!--<ul class="interIcons">
<li><?php echo $this->Html->link($this->Html->image('/img/icons/category.jpg', array('alt' => 'Level & Grades')),array("controller" => "HR", "action" => "levelGradeMaster", "admin" => false, 'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Level & Grades',true); ?></li>
			
<li><?php echo $this->Html->link($this->Html->image('/img/icons/sub-category.jpg', array('alt' => 'Cadre')),array("controller" => "HR", "action" => "cadreMaster", "admin" => false, 'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Cadre',true); ?></li>		
							
</ul>	-->
<!--
<table width="100%" align="left" cellpadding="5">
    <tr>
        <td width="25%">
            <table width="100%" class="block">
                <tr>
                    <td style="text-align:left" valign="top">
                         <?php echo __('Logined User'); ?> 
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center" valign="top">
                        <h1 class="numValue" id="loginedCount">0</h1>
                    </td>
                </tr>
            </table>
        </td>
        <td width="25%">
            <table width="100%" class="block">
                <tr>
                    <td style="text-align:left" valign="top">
                        <?php echo __('User on leave'); ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center" valign="top">
                        <h1 class="numValue" id="leaveCount">0</h1>
                    </td>
                </tr>
            </table>
        </td>
        <td width="25%">
            <table width="100%" class="block">
                <tr>
                    <td style="text-align:left" valign="top">
                        <?php echo __('Event of Month'); ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center" valign="top">
                        <h1 class="numValue" id="eventCount">0</h1>
                    </td>
                </tr>
            </table>
        </td>
        <td width="25%">
            <table width="100%" class="block">
                <tr>
                    <td style="text-align:left" valign="top">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center" valign="top">
                        <h1 class="numValue" id="loginedUser">&nbsp;</h1>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>-->

<?php $monthArray = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
            '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>

<table class="table_format">
    <tr class="row_title" height="40px">
    <?php foreach ($monthArray as $key => $val){ $class=''; if($key == date("m")){ $class="setActive"; } ?>
        <td width="8%" class="monthTd <?php echo $class; ?>" id="monthTd_<?php echo $key; ?>" title="Click to view the details of <?php echo $val; ?>"><?php echo $val; ?></td>
    <?php } ?>
    </tr>
</table> 

<div id="payRollDetail"></div>

<script>
$(document).ready(function(){
        /*$.ajax({       
            url: "<?php echo $this->Html->url(array("controller" => "HR", "action" => "getTodaysDetail", "admin" => false)); ?>", 
            success: function(data){   
                var obj = $.parseJSON(data); 
                startCounting('loginedCount',obj.loginedCount);
                startCounting('leaveCount',obj.leaveCount);
                startCounting('eventCount',obj.eventCount); 
                getAjaxPayrollDetail('<?php echo date("Y-m-d"); ?>');
            } 
        }); */
        getAjaxPayrollDetail('<?php echo date("Y-m-d"); ?>');
 });
    
    function startCounting(id,value){
        var iState = 0;
        var time = setInterval(function(){
            if (iState == value){
                clearInterval(time);
             }
             $("#"+id).text(iState.toString());
             iState++; 
        },50); 
    }
    
    $(document).on('click','.monthTd',function(){
        var monthCount = $(this).attr('id').split("_")[1];  
        $(".monthTd").removeClass('setActive'); 
        $("#monthTd_"+monthCount).addClass('setActive');
        var thisDate = '<?php echo date("Y-"); ?>'+monthCount+'<?php echo date("-d"); ?>';
        getAjaxPayrollDetail(thisDate);
    });
    
    function getAjaxPayrollDetail(thisDate){
        $.ajax({       
            url: "<?php echo $this->Html->url(array("controller" => "HR", "action" => "getAjaxPayrollDetail", "admin" => false)); ?>"+'/'+thisDate, 
            beforeSend:function(){
                loading();
            },
            success: function(data){   
                $("#payRollDetail").html(data);
                onCompleteRequest();
            } 
        }); 
    }
    
    function loading(){
        $('#payRollDetail').block({
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
    }

    function onCompleteRequest(){
        $('#payRollDetail').unblock();
    } 
    
    $(document).on('click',"#processPayroll",function(event){
        event.preventDefault();
        var formData = $('#payRollForm').serialize(); 
        var myDate = $(this).attr('month');
        $(this).hide();
        $.ajax({       
            type: 'POST',
            url: "<?php echo $this->Html->url(array("controller" => "HR", "action" => "ajaxGenearatePayRoll", "admin" => false)); ?>"+'/'+myDate,
            data: formData,
            beforeSend:function(){
                parent.loading();
            },
            success: function(data){    
                if(data.trim() === "true"){  
                    setFlash('Payroll created successfully','message'); 
                    getAjaxPayrollDetail(myDate);
                }else{
                    setFlash('Payroll could not process','error'); 
                }
                onCompleteRequest();
            } 
        }); 
    });
    
    
    $(document).on('click',".deletePayroll",function(event){
        var con = confirm("Are you sure to delete payroll?");
        if(con == false){
            return false;
        }
        event.preventDefault();
        var payrollId = $(this).attr('payroll_id'); 
        var myDate = $(this).attr('month');
        $(this).hide(); 
        
        $.ajax({       
            type: 'POST',
            url: "<?php echo $this->Html->url(array("controller" => "HR", "action" => "ajaxDeletePayRoll", "admin" => false)); ?>"+'/'+payrollId, 
            beforeSend:function(){
                parent.loading();
            },
            success: function(data){    
                if(data.trim() === "true"){ 
                    getAjaxPayrollDetail(myDate); 
                    setFlash('Payroll deleted successfully','message'); 
                }else{
                    setFlash('Payroll could not delete','error'); 
                }
                onCompleteRequest();
            } 
        }); 
    });
    
    
    $(document).on('click',"#unProcessPAyroll",function(){ 
        setFlash('Future payroll could not be create ! ','error'); 
    }); 
    
    function setFlash(text,success){
        var field = '<div id="flashMessage" class="'+success+'">'+text+'</div>'; 
        $("#flashMessage").remove();
        $(".rightTopBg").prepend(field); 
        setIntervalForSessionMsgHide();
    }
      
    function setIntervalForSessionMsgHide(){  
        window.setTimeout("hideSessionMsg()", (5000));
    }

    function hideSessionMsg(){  
        $("#flashMessage").fadeOut("slow");
        clearInterval(timer);
    } 
    
    $("#flashMsgClose").click(function(){
        hideSessionMsg(); 
    });
</script>