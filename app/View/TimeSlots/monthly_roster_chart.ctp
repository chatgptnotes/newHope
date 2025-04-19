<?php 
echo $this->Html->script('jquery.tooltipster.min.js');
echo $this->Html->css('tooltipster.css');
?>
<style>
.detailItem:hover {
	background-color: #d2ebf2;
	border: 0px outset #222222;
	font-weight: bold;
	cursor: default;
}

.firstColumn {
	text-align: center;
	background: #31859c !important;
	color: #d2ebf2 !important;
}

@-webkit-keyframes invalid {
  from { background-color: red; }
  to { background-color: inherit; }
}
@-moz-keyframes invalid {
  from { background-color: red; }
  to { background-color: inherit; }
}
@-o-keyframes invalid {
  from { background-color: red; }
  to { background-color: inherit; }
}
@keyframes invalid {
  from { background-color: red; }
  to { background-color: inherit; }
}
.invalid {
  -webkit-animation: invalid 1s infinite; /* Safari 4+ */
  -moz-animation:    invalid 1s infinite; /* Fx 5+ */
  -o-animation:      invalid 1s infinite; /* Opera 12+ */
  animation:         invalid 1s infinite; /* IE 10+ */
} 
</style>
<div class="inner_title">
	<?php echo $this->element('duty_roster_menu');?>
	<h3>Monthly Roster Chart</h3>
</div>
<div>
 <?php echo $this->Form->create('',array('type'=>"GET",'id'=>'searchMonthlyRosterForm')); ?>
 <table align="left" style="margin-top: 10px" width="" align="left">
                   <?php $monthArray = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun',
                                    '07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'); ?>
                        <?php for($i=2014;$i<=date('Y')+5;$i++){?>
                     <?php $yearArray[$i] = $i; ?>
                        <?php }?>
                    <tr>
                        <td align="right" width=""><?php echo "Search By Name: ";?></td>
                        <td align="left" width=""><?php echo $this->Form->input('',array('name'=>'search','id'=>'searchTerm','placeholder'=>'Search by name',
                            'class'=>'textBoxExpnd ','label'=>false,'div'=>false,'type'=>'text','style'=>'width:200px;')); ?></td>
                        <td align="right" width=""><?php echo "Roles: ";?></td>
                        <td align="left" width=""><?php echo $this->Form->input('month',array('name'=>'role_id','empty'=>'All','options'=>$roles,'id'=>'roles',
                                                        'class'=>'textBoxExpnd ','label'=>false)); ?></td>
                        <td align="center"><?php echo "Month";?></td>
                        <td align="center" width=""><?php echo $this->Form->input('month',array('name'=>'month','empty'=>'Please Select','options'=>$monthArray,'id'=>'month',
                                                        'class'=>'textBoxExpnd ','label'=>false,'default'=>date('m'))); ?></td>
                        <td align="center"><?php echo "Year"; ?></td>
                        <td align="center"><?php echo $this->Form->input('Year',array('empty'=>'Please Select','options'=>$yearArray,'id'=>'year',
                                                        'class'=>'textBoxExpnd ','label'=>false,'default'=>date('Y')));?></td>
                        <td align="right" colspan="4"><?php echo $this->Form->input('Search',array('type'=>'button','class'=>'blueBtn','label'=>false,'div'=>false,'id'=>'search','onClick'=>'return false;')); ?></td>
                        <td align="right"><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),'javascript:void(0);',array('escape'=>false, 'title' => 'refresh','class'=>'loading','onclick'=>"$('#search').trigger('click');")); ?>
                       </td>
                    </tr>
                 </table>
                <?php echo $this->Form->end();?>
            </div>

<div id="mainChart"><!-- Main charting div --></div>

<script type="text/javascript">
$(document).ready(function (){
    $('#search').click(function (){
    	
        var validateRoster = jQuery("#searchMonthlyRosterForm").validationEngine('validate');
    	if(validateRoster == false){
            return validateRoster;
    	} 
    	$.ajax({
    		method : 'GET',
    		url: "<?php echo $this->Html->url(array("controller" => 'TimeSlots', "action" => "newMonthlyRosterChartView", "admin" => false)); ?>",
    		data : $('#searchMonthlyRosterForm').serialize(),
    		context: document.body,
    		beforeSend:function(){
    			$('#busy-indicator').show('fast');
    		  }, 				  		  
    		success: function(data){
    			$('#mainChart').html(data);
    			$('#busy-indicator').hide('slow'); 
    		}  
    	});
    	
    });
});
                        
var currentElementId = '';

function ShowMenu(control, e, elementId, user_id, date, user_role_id) {
    currentElementId = elementId; 
    currentUserId = user_id;
    currentDate = date; 
    currentUserRole = user_role_id; 

    if( $('#'+elementId).css('background-color') == 'rgb(255, 0, 0)' ){
        $('#dutyONCash').css('background-color','green');
        $('#dutyONCash').attr('value','removeDutyONCash');
    }else{
            $('#dutyONCash').css('background-color','red');
            $('#dutyONCash').attr('value','dutyONCash');
    }
    var posx = e.clientX +window.pageXOffset +'px'; //Left Position of Mouse Pointer
    var posy = e.clientY + window.pageYOffset + 'px'; //Top Position of Mouse Pointer

    document.getElementById(control).style.position = 'absolute';
    document.getElementById(control).style.display = 'inline';
    document.getElementById(control).style.left = posx;
    document.getElementById(control).style.top = posy;           
}

function HideMenu(control) {
	$('#'+control).hide();
}

$(document).ready(function (){ //echo 'Year='+(date('Y'))
	$(document).click(function(){
            HideMenu('contextMenu');
	});
	var month = $('#month').val();
	var year = $('#year').val();
        var roles = $('#roles').val(); 
	$.ajax({
		url: "<?php echo $this->Html->url(array("controller" => 'TimeSlots', "action" => "newMonthlyRosterChartView", "admin" => false)); ?>",
		method : 'GET', 
		data : 'month='+month+'&Year='+year+'&role_id='+roles,
		context: document.body,
		beforeSend:function(){
			$('#busy-indicator').show('fast');
		  }, 				  		  
		success: function(data){
			$('#mainChart').html(data);
			$('#busy-indicator').hide('slow'); 
		}  
	});
});

 
$(document).on('keyup','#searchTerm',function() {
    var $rows = $('#dataTable tr');
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase(); 
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>
