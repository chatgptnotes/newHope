<?php
     echo $this->Html->script(array('jquery.autocomplete'));    
	 echo $this->Html->css('jquery.autocomplete.css');   
?>
<style>
select.textBoxExpnd ,.textBoxExpnd{
width:50%;
}
.shift-cell{
	cursor:pointer;
	

}
</style> 
 <div class="inner_title" style="font-size: unset;">
 <?php echo $this->element('duty_roster_menu');?>
	<h3>&nbsp; <?php echo __('Duty Roster', true); ?></h3>
		<span><?php      
		//echo $this->Html->link(__('Duty Assignment'), array("action"=>"add"), array('escape' => false,'class'=>'blueBtn','id'=>"manageStaffTime", 'style'=>"margin:-58px"));
		//echo $this->Html->link(__('Shift Master'), array("action"=>"add_shifts"), array('escape' => false,'class'=>'blueBtn','id'=>"", 'style'=>"margin:70px"));
		?>
	<?php  echo $this->Html->link('Back',array("controller"=>"users","action"=>"common"),array('escape'=>false,'class'=>'blueBtn')); ?></span>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
	 
	 
   ?></div>
  </td>
 </tr>
</table>
<?php
	}
?>

  <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="left" >
	    	<tr>
			 
				<td align="center" >
					<?php	echo $this->Form->input('ward_id',array('options'=>$wards,'empty'=>__('Please Select'),'label'=>'Room',
							'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'ward_id','type'=>'select','autocomplete'=>'off')); ?> 
				</td>
		    </tr>  
		    <tr>
			 
				<td align="center" >
					<?php	echo $this->Form->input('role_id',array('empty'=>__('Please Select'),'options'=>$roles,
							'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'role_id','type'=>'select','autocomplete'=>'off')); ?> 
				</td>
		    </tr>
			
	</table>		

		 <div align="left" id="dateFrom" 'style'="display:none">
			 
			 
		</div>
		
		<div class="clr ht5"></div>
		
	  <div id="staffTimeChart" style="display:none">
	 </div>	
<script>

    var x;
 var y;
 $(document).mousemove(function(e) {
    x = e.pageX;
     y = e.pageY;
});
	 $('#role_id').change(function (){  
				getStaffTimeChart(this,"Role");
	    	}); 
	  $('#ward_id').change(function (){  
				getStaffTimeChart(this,"Ward");
	    	}); 
					
			
function getStaffTimeChart(obj,module ,date){ 
			 var role = "";
			 var ward = "";
			 if(!date){
			 	date = null;
			 }
			 $('#staffTimeChart').hide("fast");
			 $('#staffTimeChart').html(""); 
			 if($(obj).val() == ""){
				alert("Select "+module);
				return false;
			 }
			 if(module == "Role" && $('#ward_id').val() == ""){
			 	 
					return false;
			 }
			  if(module == "Ward" && $('#role_id').val() == ""){
			 	 
				return false;
			 }
			  if(module == "Role" ){
			 	 role = $(obj).val();
			  	 ward = $('#ward_id').val();
			 }
			  if(module == "Ward"){
			 	 role = $('#role_id').val();
			  	 ward = $(obj).val();
				
			 }
			$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'time_slots', "action" => "get_staff_time_chart", "admin" => false)); ?>"+"/"+role+"/"+ward+"/"+date,
			  context: document.body,
			  
			  beforeSend:function(){
				// this is where we append a loading image
				$('#busy-indicator').show('fast');
			  }, 				  		  
			  success: function(data){
						$('#busy-indicator').hide('slow'); 
						$('#staffTimeChart').append(data); 
						$('#staffTimeChart').show("slow");
						$('#manageStaffTime').show("slow");
						addDateField();
			  }  
			});
}
function addDateField(){
		$("#dateFrom").html("");
		if($("#date_from"))
		 $("#date_from").remove();
		var datefield = 'Show Time slot on date: <input type="text" class="textBoxExpnd" id="date_from" style="width:10%">';
 
		$("#dateFrom").append(datefield);
		 $( "#date_from" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					dateFormat:'<?php echo $this->General->GeneralDate();?>', 
					onSelect: function (e)
					{		 $( "#date_from" ).val(e);
						 var date = e.split("/");
 						getStaffTimeChart($('#role_id'),"Role" ,date[2]+"-"+date[0]+"-"+date[1]);
					}
				});			
}	

/*$(".shift-cell").live("click",function() {
		 
		var date = $(this).attr("date");
		var userid = $(this).attr("userId");
		var role = $("#role_id").val();
		var ward = $("#ward_id").val();
		var name = $(this).attr("name");
		var remove = "0";
		var stmt = "make";
		if($(this).attr("remove")){
			remove="1";
			stmt = "remove";
			}
		if(confirm("Do you want to "+stmt+" "+date+" off for "+name)){
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'time_slots', "action" => "set_day_off", "admin" => false)); ?>",
				  context: document.body,
				  type:'post',	
				  data: { date: date, userid: userid,role: role,ward: ward,remove: remove} ,
				  success: function(data){
				  	if(data.trim() == "true")
						 getStaffTimeChart($('#role_id'),"Role" ,date);
					else
						alert("Something went wrong, Please try again later.") 
				  }  
				});
	 }
 
});
$(".shift-cell").live("mouseover",function() {
  $("#screenMessage").remove();
			$(this).append('<div id="screenMessage">Click to set the day off.</div>');			 
			$("#screenMessage").css("position", "absolute");	  
			$("#screenMessage").css("top", y);
			$("#screenMessage").css("left", x);
			$("#screenMessage").css("background-color", "#000");
			$("#screenMessage").css("height", "31px");
			$("#screenMessage").css("margin", "10px");
			$("#screenMessage").css("border", "1px solid #4C5E64");
			$("#screenMessage").css("color", "#fff");
			 
});

$(".shift-cell").live("mouseout",function() {
		   
			 $("#screenMessage").remove();
			 
    	});*/
</script>