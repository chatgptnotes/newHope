<div class="inner_title">  
    <h3>Add Attendance</h3>
    <span><?php echo $this->Html->Link(__('Back'),array("controller"=>'HR',"action"=>"index"),array('class'=>'blueBtn','alt'=>'Back','title'=>'Back','escape'=>false)); ?></span>
</div> 
<?php echo $this->Html->script(array('jquery.blockUI')); ?>
<style> 
.attendanceTable th, .attendanceTable td {
    background: none repeat scroll 0 0 #E5E5E5;
    /*background-image: linear-gradient(to bottom, #FFFFFF, #F2F2F2);*/
    border: 1px solid #FFFFFF;
    padding:5px;
    border-radius: 2px 2px 2px 2px;  
}
.inner_title{
	padding-bottom: 0px;
}
.table_format {
	padding: 0px !important; 
} 
.not_active{
	background-color:#D0DCE0 !important;
	cursor: auto;
}
a{
	text-decoration: none !important;
}  
.tab{
	text-align: center;
	font-weight: bold;
}
tr.dateHead td{

}
tr.rowHover:hover td{
    background-color:#9999CC; 
    color: white;
    font-weight: bold;
}
.column{
	font-weight: bold;
}
.rowHover td.column:hover, td.setSelected{
    background-color:#003D4C !important;
    cursor: pointer;
    color:white;
}
.not_active{
	background-color:#D0DCE0;
	cursor: auto;
}
.present{
	background-color:green !important;	
	color: white !important;
	font-weight: bold;
}
.absent{
	background-color:#E00000 !important;	
	color: white !important;
	font-weight: bold;
}

label {
    color: #fff !important;
    float: none; 
    margin-right: none;
    padding-top: none;
    text-align: none;
    width: none;
}
</style>
<div id="attendanceMaster">
    
</div>

<script>
    var selectedDate = ''; 
    var result = '';
    var role_id = '';
    $(document).ready(function(){ 
        getAttendance();
    });
    
    function getAttendance(curdate, role, params){
        if(curdate == '' || curdate == undefined){
           curdate ='<?php echo date("Y-m-d"); ?>';
        } 
        if(role == undefined){
           role ='';
           if(role_id !=''){
               role = role_id;
           }
        } 
        selectedDate = curdate; 
        $.ajax({
            url: '<?php echo $this->Html->url(array("action"=>"getAttendance")); ?>'+"/"+selectedDate+'/'+role+"?"+params,
            beforeSend:function(){
                $('#busy-indicator').show('fast'); 
              },				  		  
            success: function(data){  
                $('#busy-indicator').hide('slow');
                $('#attendanceMaster').html(data); 
                if(params!='' && params!=undefined){
                    setFlash("Attendance updated successfully !","message");
                }
            } 
        });
    }
    
    $(document).on('change','#searchRoles',function(){
        role_id = $(this).val();
        getAttendance(selectedDate,role_id,result);
    });
    
    /*$(".user").on('click',function(){
	//console.log($(this).attr('user_id')+"__"+$(this).attr('day'));
	var thisText = $(this).text();
	var setAttendance = ""; 
	if(thisText=="" || thisText=="A"){ 
		setAttendance = "P";
		$(this).addClass('present');
		$(this).removeClass('absent');
	}else{
		setAttendance = "A";
		$(this).addClass('absent');
		$(this).removeClass('present');	
	}
	$(this).text(setAttendance);
	var checkedVal = $("input[type='radio'][name='in_or_out']:checked").val();  

	//save attendance ajax 
	if(setAttendance!=''){
		var thisDate = "<?php echo date('Y-m',strtotime($todayDate));?>"+"-"+$(this).attr('day'); 
		$.ajax({
			url: '<?php echo $this->Html->url(array("action"=>"setAttendance"))?>'+"/"+checkedVal+"/"+$(this).attr('user_id')+"/"+thisDate+"/"+setAttendance,
		}); 
	}
    }); */ 
 

function loading(){
    $('#dataTable').block({
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
    $('#dataTable').unblock();
} 

$(document).on('click',".loading",function(){
    loading();
});

$(document).on('change',".changeRole",function(){
    loading();
});

var prevID = '';
function ShowMenu(control, e) {  
    
    var id = e.target.id; 
    
    $("#"+id).addClass('setSelected');
    if(prevID!=''){
        $("#"+prevID).removeClass('setSelected');
    }
    prevID = id;
    $("#user_id").val($("#"+id).attr('user_id'));
    $("#role_id").val($("#"+id).attr('role_id'));
    $("#userName").text($("#"+id).attr('user_name'));
    $("#shift").val($("#"+id).attr('shift'));
    $("#user_date").val($("#"+id).attr('day'));
    $("#userDate").text($("#"+id).attr('date'));
    $("#remark").val($("#"+id).attr('remark'));
    
    var inTimeData = $("#"+id).attr('intime')!=''?$("#"+id).attr('intime'):'<?php echo date("H:i:s"); ?>';
    var inTime = inTimeData.split(":"); 
    if(inTime!=''){
        $("#intime_hour").val(inTime[0]);
        $("#intime_minute").val(inTime[1]);
        $("#intime_second").val(inTime[2]);
    }
    $("#intime_hour, #intime_minute, #intime_second").attr('disabled',true); 
    $("#is_intime_check").attr('checked',false);
    
    var outTimeData = $("#"+id).attr('outime')!=''?$("#"+id).attr('outime'):'<?php echo date("H:i:s"); ?>';
    var outTime = outTimeData.split(":");
    if(outTime!=''){
        $("#outtime_hour").val(outTime[0]);
        $("#outtime_minute").val(outTime[1]);
        $("#outtime_second").val(outTime[2]); 
    }
    $("#outtime_hour, #outtime_minute, #outtime_second").attr('disabled',true);  
    $("#is_outtime_check").attr('checked',false);
    
    var xPos = e.clientX + window.pageXOffset;
    var yPos = e.clientY + window.pageYOffset;
    
    var posx =  xPos+'px'   //Left Position of Mouse Pointer
    var posy =  yPos+ 'px'; //Top Position of Mouse Pointer
     
    var tableDisctanceX = $(".table_format").offset().left;  
    
    var parentTableWidth = $( ".table_format:first" );
    var tableWidth = (parentTableWidth.innerWidth() + tableDisctanceX); 
    
    var contextWidth = $( "#contextMenu:first" );
    var contWidth = contextWidth.innerWidth(); 
    
    if((xPos + contWidth)  > tableWidth){
        posx = (xPos - contWidth)+'px';
    }
    
    document.getElementById(control).style.position = 'absolute';
    document.getElementById(control).style.display = 'inline';
    document.getElementById(control).style.left = posx;
    document.getElementById(control).style.top = posy; 
}

function HideMenu(control) {
    $('#'+control).hide();
    $("#"+prevID).removeClass('setSelected');
}

$(document).on('click','#updateTime',function(){ 
    var result = '';
    //var selectedArray = {};
    var div = document.getElementById('contextMenu'); 
    $(div).find('input, select').each(function() {
        result += $(this).attr('name')+"="+$(this).val()+"&";
        //selectedArray[$(this).attr('name')] = $(this).val();
    }); 
    //console.log(result);
    //console.log(selectedArray); 
    var result = $("#contextForm").serialize(); 
    
    if( $("#remark").val()==''){
        setFlash('Please enter remark ! ','error'); 
    }
    
    if(($("#is_intime_check").is(":checked")== false && $("#is_outtime_check").is(":checked")== false && $("#remark").val()=='') || $("#remark").val()==''){
        return false;
    }
    
    /*if((($("#is_intime_check").is(":checked")== false || $("#is_outtime_check").is(":checked")== false) && $("#remark").val()!='')){
        setFlash('Please check InTime or OutTime to save remarks ! ','error'); 
        return false;
    }*/
    
    var role_id = $("#searchRoles").val();
    
    getAttendance(selectedDate,role_id,result);
    /*$.ajax({
        url: '<?php echo $this->Html->url(array("action"=>"updateInOutTime")); ?>'+"?"+result,
        beforeSend:function(){
            $('#busy-indicator').show('fast');
          },				  		  
        success: function(data){ 
            if(data === "false"){
                alert("Something went wrong, please try again");
            }
            $('#busy-indicator').hide('slow'); 
            HideMenu('contextMenu');
            getAttendance(selectedDate);
        } 
    });*/
});
 

function str_pad(value){
    if(value.length>2){
        return value;
    }
    return ("0"+value);
}

    $(document).on('click',"#unProcessPAyroll",function(){ 
        setFlash('Future payroll could not be create!','error'); 
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
 