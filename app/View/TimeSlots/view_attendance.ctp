 <?php /*echo $this->Html->script(array(
    "jplot/jquery.jqplot.min.js",
    "jplot/jqplot.barRenderer.min.js",  
    "jplot/example.js",  
    "jplot/morris.min.js",
    "jplot/jquery.knob.js",
    "jplot/raphael-min.js",
    "jplot/jqplot.pieRenderer.min.js",
    "jplot/jqplot.categoryAxisRenderer.min.js" ,
    "jplot/jqplot.pointLabels.min.js"
));*/ ?>
 <?php //echo $this->Html->css(array("jquery.jqplot.min.css","morris.css")); ?>
     <?php  echo $this->Html->script(array('jquery.blockUI')); 
        echo $this->Html->script(array('jquery.fancybox'));
	echo $this->Html->css(array('jquery.fancybox'));  ?>  

<style>
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
<div class="inner_title">  
    <?php echo $this->element('navigation_menu',array('pageAction'=>'HR'));?>
    <h3>User Attendance</h3> 
</div> 
<div class="clr ht5"></div>     
<?php $monthArray = array('01'=>'Dec-Jan','02'=>'Jan-Feb','03'=>'Feb-Mar','04'=>'Mar-Apr','05'=>'Apr-May','06'=>'May-Jun',
            '07'=>'Jun-Jul','08'=>'Jul-Aug','09'=>'Aug-Sep','10'=>'Sep-Oct','11'=>'Oct-Nov','12'=>'Nov-Dec'); ?>
    <?php for($i=date('Y')-2;$i<=date('Y');$i++){?>
        <?php $yearArray[$i] = $i; ?>
    <?php }?>
<?php echo $this->Form->create('',array('type'=>'get')); ?>
<table class="table_format" align="center" cellspacing="0" cellpadding="0">
    <tr class="row_title">
        <td class="alignRight"><?php echo __('Year :'); ?> </td>
        <td class="alignLeft"><?php echo $this->Form->input('',array('type'=>'select','id'=>'year','options'=>$yearArray,'div'=>false,'label'=>false,'name'=>'year','value'=>$this->request->query['year']?$this->request->query['year']:date('Y'))); ?> </td>
        <td class="alignRight"><?php echo __('User : '); ?></td>
        <td class="alignLeft"><?php echo $this->Form->input('',array('type'=>'text','id'=>'user_name','class'=>'textBoxExpnd','div'=>false,'label'=>false,'name'=>'user_name','value'=>$this->request->query['user_name']));
        echo $this->Form->hidden('',array('id'=>'user_id','name'=>'user_id','value'=>$userId = $this->request->query['user_id']));?> </td>
        <td class="alignLeft"><?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','div'=>false,'label'=>false,'value'=>$this->request->query['user_id'])); ?>  </td>
        <td class="alignLeft"><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'viewAttendance'),array('escape'=>false, 'title' => 'refresh','class'=>'loading'));?></td>
    </tr>
</table> 
<?php echo $this->Form->end(); ?>

<?php if(!empty($this->request->query['user_id'])) { ?> 
<!--<div id="hero-graph" style="margin-bottom: 30px; margin-top: 30px; height: 230px;"></div>--> 
<table class="table_format">
    <tr class="row_title" height="40px">
    <?php foreach ($monthArray as $key => $val){ $class=''; if($key == date("m")){ $class="setActive"; } ?>
        <td width="8%" class="monthTd <?php echo $class; ?>" id="monthTd_<?php echo $key; ?>" title="Click to view the details of <?php echo $val; ?>"><?php echo $val; ?></td>
    <?php } ?>
    </tr>
</table> 
<div class="clr ht5"></div>
<div id="userContainer"></div>
<?php } ?>

<script class="code" type="text/javascript"> 
    var userId = "<?php echo $userId; ?>";
    var curDate = '';
    $(document).ready(function(){
        $("#user_name").autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "Users", "action" => "getUserList",'admin' => false,"plugin"=>false)); ?>",
            minLength: 1, 
            select: function( event, ui ) { 
                $("#user_id").val(ui.item.id);
            },
                messages: {
                noResults: '',
                results: function() {}
             }	
        });  
 
        /*if(userId!='' && userId!=undefined){ 
            var attData = $.parseJSON('<?php echo json_encode($totalAttendance); ?>');  
            var taxData = new Array();
            var monthCount = [01,02,03,04,05,06,07,08,09,10,11,12];
            $.each(monthCount,function(key,value){  
                taxData.push({"Month":'<?php echo date("Y"); ?>-'+value, 'Attendance':attData[value]});
            });

            Morris.Line({
                element: 'hero-graph',
                data: taxData,
                xkey: 'Month',
                xLabels: "month",
                ykeys: ['Attendance'],
                labels: ['Attendance']
            }); 
        }*/
    }); 
    
    if(userId!='' && userId!=undefined){  
        var dateSearch = $("#year").val()+""+'<?php echo date("-m-d"); ?>'; 
        getAllDetails(userId,dateSearch);
    }
    
    function getAllDetails(userId,dateSearch){
        $.ajax({
           url: "<?php echo $this->Html->url(array("controller" => "TimeSlots", "action" => "ajaxAttendanceDetail", "admin" => false)); ?>"+'/'+userId+'/'+dateSearch, 
            beforeSend:function(){
                loading();
            },
            success: function(data){     
                $("#userContainer").html(data);
                onCompleteRequest();
                curDate = dateSearch;
            } 
        });
    }
    
    $(document).on('click','.monthTd',function(){
        var monthCount = $(this).attr('id').split("_")[1];  
        var dateSearch = $("#year").val()+"-"+monthCount+'<?php echo date("-d"); ?>';  
        $(".monthTd").removeClass('setActive'); 
        $("#monthTd_"+monthCount).addClass('setActive');
        getAllDetails(userId,dateSearch); 
    });
    
    function loading(){
    $('#userContainer').block({
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
    $('#userContainer').unblock();
} 
  </script>