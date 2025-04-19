<?php if(!$this->params['isAjax']){?>
<div class="inner_title">
    <?php echo $this->element('navigation_menu',array('pageAction'=>'HR')); ?>
	<h3>
		<?php echo "Leave Configuration" ?>
	</h3>
</div>
<?php }?>
<style>
input:focus {
	border-color: none !important;
	box-shadow: none !important;
}

.searchbox {
	background: #FFF url(../img/icons/views_icon.png) no-repeat 195px 4px
		!important;
	height: 25px !important;
	width: 200px !important;
	padding-left: 15px;
	background-color: transparent !important;
	border-style: solid !important;
	border-width: 0px 0px 1px 0px !important;
	border-color: darkOrange !important;
	outline: 0 !important;
}
.textbox {
	background: #FFF !important;
	height: 20px !important;
	width: 200px;
	padding-left: 15px;
	background-color: transparent !important;
	border-style: solid !important;
	border-width: 0px 0px 1px 0px !important;
	border-color: darkOrange !important;
	outline: 0 !important;
}
.selectBox{
	background-color: transparent !important;
	border-style: solid !important;
	border-color: darkOrange !important;
	height: 20px !important;
	width: 200px !important;
	}
.orangeTable{
	width:100%;
	background:palegoldenrod  none repeat scroll 0 0 !important; 
	border: solid 1px orange;
}
.orangeTable th{
	background: darkOrange none repeat scroll 0 0 !important;
    border-bottom: 1px solid #3e474a;
    color:#A200B6 !important;
    font-size: 12px;
    padding: 5px 8px;
    text-align: center;
	height: 20px;   
}
.orangeTable tr:nth-child(2n){
	background: #FADD99 none repeat scroll 0 0 !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}
.orangeTable tr:nth-child(2n+1){
	background: #FBC642 none repeat scroll 0 0 !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}
.orangeTable td{
	text-align: left;
}
</style>

<div id="page_content">
<?php echo $this->Form->create('',array('id'=>'emp_configure'));?>
	<table>
		<tr>
			<td>Employee Name:</td>
			<td><input name="emp_name" class="searchbox" type="text" id="emp_name"><input name='emp_id' type="hidden" id="emp_id"></td>
<!--		</tr>
		 <tr>-->
			<td>Role:</td>
			<td><?php echo $this->Form->input('role_id',array('type'=>'select','id'=>'role','name'=>'role_id','class'=>'selectBox','options'=>$roles,'empty'=>'Please Select','label'=>false,'div'=>false));?></td>
<!--		</tr> 
                    <tr>
			<td>Department:</td>
			<td><?php echo $this->Form->input('department_id',array('type'=>'select','id'=>'department','class'=>'selectBox','name'=>'department_id','options'=>$departments	,'empty'=>'Please Select','label'=>false,'div'=>false));?></td>
		</tr> 
		<tr>-->
			<td align="right"><button type="submit" class="blueBtn" id="submit">View</button></td>
			<td align="right"><?php echo $this->Html->link('Reset','javascript:void(0)',array('class'=>'blueBtn','escape'=>false,'id'=>'reset'));?></td>
		</tr>
	</table>
<?php echo $this->Form->end();?>
</div>
<div id="details"></div>
<script type="text/javascript">
$(document).ready(function(){
	$('#emp_configure').validationEngine();
	$('#emp_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Users", "action" => "user_autocomplete","admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				$('#emp_id').val(ui.item.id);
				var sub_group_id = ui.item.id; 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }

	});
});

$('#submit').click(function(e){
	e.preventDefault();
	formData = $('#emp_configure').serialize();
	$.ajax({
		  type : "POST",
		  data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "Leaves", "action" => "roleLeaveDetail", "admin" => false)); ?>",
		  context: document.body,
		//  data:"mapTarget="+icd_id+"&diagnoses_name="+diagnoses_name+"&patient_id="+patient_id+"&id="+dia_id+"&patient_info="+patientInfo,
		  beforeSend:function(){
                    $('#busy-indicator').show('fast');
                  },
                  success: function(data){
                      $('#busy-indicator').hide('fast');
			  $('#details').html(data);
		  }
	});
});
$('#reset').click(function(){
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Leaves", "action" => "leaveConfigure", "admin" => false)); ?>",
		  context: document.body,
                   beforeSend:function(){
                    $('#busy-indicator').show('fast');
                  },
		  success: function(data){
                      $('#busy-indicator').hide('fast');
			  $('#page_content').html(data);
		  }
	});
});

$("#role").change(function(){
    $("#emp_name").val('');
    $("#emp_id").val('');
});

$("#emp_name").on('input',function(){
    if($(this).val()!=''){
        $("#role").val('');
    } 
});
</script>
