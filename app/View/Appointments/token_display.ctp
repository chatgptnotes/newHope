<style>
.token_section{text-align: center; width: 1000px; margin: 0px auto;}
.token_section h1{ font-size:150px;}
.inner_title {
   
    display: block;
    font-size: 20px;
    margin-top: 27px;
    padding: 10px;
    width: 98%;
}
</style>


<div class="inner_title"><span><?php  
		echo $this->Html->link(__('Back'),
			 array("action"=>"appointments_management"),array('escape'=>false,'class'=>'blueBtn')); 
		?></span>
		</div>




<div class="token_section">
<?php 
echo '<h1>Token No</h1><h1 class="display">'.$appToken['Appointment']['app_token'].'</h1><h1 class="displayRoom">'.$appToken['Chamber']['name'].'</h1>';
echo $this->Form->input('app_token',array('type'=>'hidden','id'=>'appToken_'.$appToken['Appointment']['id'],'class'=>'tokenClass','value'=>$appToken['Appointment']['app_token']));


?>
</div>






<script>
$(document).ready(function(){
	refresh_list();
function refresh_list(){
		
		//for refreshing on count change
		//var countData= $('#patient-count').val();
		setInterval(function(){
			//Condition for not to refresh on search and future appointment 
			tokenData = parseInt($('.tokenClass').val());
			var tokenID =$('.tokenClass').attr('id');
					tokenSplit=tokenID.split('_');
					apptId=tokenSplit[1];					
			// url=$('#patient-count').attr('url);
			$.ajax({
			   type : "POST",
		       url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "app_token", "admin" => false)); ?>"+"/"+apptId,
		       context: document.body,
		       success: function( data ){
		           // do something with the data 
		           data1 = $.parseJSON(data);
		           if(data1.Appointment.app_token != tokenData){ 
		        	   $('.tokenClass').val(data1.Appointment.app_token);
		        	   $('.display').html(data1.Appointment.app_token);
		        	   $('.displayRoom').html(data1.Chamber.name);
		        	   $('.tokenClass').attr('id','appToken_'+data1.Appointment.id);
				   }else{
					   //if exam room is changed
					   $('.tokenClass').val(data1.Appointment.app_token);
		        	   $('.display').html(data1.Appointment.app_token);
		        	   $('.displayRoom').html(data1.Chamber.name);
		        	   $('.tokenClass').attr('id','appToken_'+data1.Appointment.id);
				   }
		          // recursive(); // recurse
		       },
		       error: function(){
		          // recursive(); 
		       }
		   });
			   },20000);
		}
});
</script>