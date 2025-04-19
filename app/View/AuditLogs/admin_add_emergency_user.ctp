<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#userfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Add Emergency User', true); ?></h3>

</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
 <tr>
  <td colspan="2" align="left" class="error">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php }
//$this->Form->create('userfrm');
?> 
<form name="userfrm" id="userfrm" action="<?php echo $this->Html->url(array("action" => "add_emergency_user")); ?>" method="post" >
 <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
		 <tr>
			<td class="form_lables" align="right">
			<?php echo __('Username',true); ?><font color="red">*</font>
			</td>
			<td>
		        <?php 
		        echo $this->Form->input('User.id', array('label' => false,'legend' => false ,'options' => $users, 'empty' => 'Select User', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'username'));
		        ?>
			</td>
			</tr>
			 <tr>
		<td class="form_lables" align="right">
		<?php echo __('Expiry Date',true); ?><font color="red">*</font>
		</td>
		<td>
	        <?php 
	          echo $this->Form->input('User.expiary_date', array('class' => 'validate[required,custom[mandatory-date]]', 'type'=>'text', 'id' => 'expiary_date', 'label'=> false, 'div' => false, 'error' => false));
	        ?>
		</td>
		</tr>
		    <tr>
	         <td class="form_lables" align="right">
	          <?php echo __('Is Emergency Access',true); ?>
	         </td>
	         <td>
              <?php 
                 echo $this->Form->input('User.is_emergency', array('options' => array('1' => 'Yes', '0' => 'No'), 'id' => 'is_emergency', 'label'=> false, 'div' => false, 'error' => false));
              ?>
             </td>
	        </tr> 
        <tr>
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'emergency_access'), array('escape' => false,'class'=>'grayBtn')); ?>
			<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
<script>
jQuery(document).ready(function(){ 
			jQuery("#roletype").change(function(){
						selectedRole = jQuery("#roletype option:selected").text() ;
						if(selectedRole.toLowerCase() == "treating consultant" ) {
						        jQuery("#surgeonshow").show();
                                jQuery("#departmentslist").show();
                                jQuery("#is_registrar").val("0");
                        } else if(jQuery("#roletype option:selected").text() == "Registrar" || jQuery("#roletype option:selected").text() == "registrar") {
                                jQuery("#departmentslist").show();
                                jQuery("#is_registrar").val("1");
                        } else {
                                jQuery("#surgeonshow").hide();
                                jQuery("#departmentslist").hide();
                        }
					});
                       var roletype = $('#roletype').val(); 
                       if(roletype && (selectedRole.toLowerCase() == "treating consultant"   || jQuery("#roletype option:selected").text() == "Registrar" || jQuery("#roletype option:selected").text() == "registrar")) {
                        var data = 'roletype=' + roletype ; 
                        $.ajax({url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "getDepartment", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#departmentslist').show();$('#showDepartmentList').html(html); } });
                       }
                       <?php 
                         if(!empty($this->request->data['DoctorProfile']['department_id'])) {
                       ?>
                        var data = 'roletype=' + <?php echo $this->request->data['User']['role_id']; ?> ; 
                        $.ajax({url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "getDepartment", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#departmentslist').show();$('#showDepartmentList').html(html); $('#departmentid').val(<?php echo $this->request->data['DoctorProfile']['department_id']; ?>)} });
                        jQuery("#registrar").show();
                       <?php 
                         } 
                       ?>
                        
                       <?php 
                         if($this->request->data['User']['state_id']) {
                       ?>
                        var data = 'reference_id=' + <?php echo $this->request->data['User']['country_id']; ?> ; 
                        $.ajax({url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "get_state_city",'reference'=>'State', "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#changeStates').html(html); $('#customstate').val(<?php echo $this->request->data['User']['state_id']; ?>)} });
                       <?php 
                         }
                       ?>
                       <?php 
                         if($this->request->data['User']['city_id']) {
                       ?>
                        var data = 'reference_id=' + <?php echo $this->request->data['User']['state_id']; ?> ; 
                        $.ajax({url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "get_state_city",'reference'=>'City', "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#changeCities').html(html); $('#customcity').val(<?php echo $this->request->data['User']['city_id']; ?>)} });
                       <?php 
                         }
                       ?>
                      
                        $(function() {
                        	//var dateminmax = new Date(new Date().getFullYear()-100, 0, 0)+':'+new Date(new Date().getFullYear()-20, 0, 0);
                        	 	var firstYr = new Date().getFullYear()-100;
                    			var lastYr = new Date().getFullYear()-1;
                    	  		
			                $( "#customdateofbirth" ).datepicker({
									showOn: "button",
									buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly: true,
									changeMonth: true,
									changeYear: true,
									changeTime:true,
									showTime: true,  		
									yearRange: firstYr+':'+lastYr,			 
									dateFormat:'dd/mm/yy/hh:mm',
                                    defaultDate: new Date(firstYr)      
							});	

			                $("#expiary_date")
							.datepicker(
									{
										showOn : "button",
										buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
										buttonImageOnly : true,
										changeMonth : true,
										changeYear : true,
										yearRange : '2013',
										dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
										onSelect : function() {
											$(this).focus();
										},
										minDate : new Date(),
									 });	

							$('#roletype').change(function(){
								$.ajax({
									  url: "<?php echo $this->Html->url(array("controller" => 'locations', "action" => "getNonAdminLocations", "admin" => false)); ?>"+"/"+$(this).val(),
									  context: document.body,	
									  beforeSend:function(){
									    // this is where we append a loading image
									    $('#busy-indicator').show('fast');
										}, 	  		  
									  success: function(data){
										$('#busy-indicator').hide('slow');
										$("#location_id option").remove();
										$('#locationArea').show(); 
									  	if(data !=''){
									  		data= $.parseJSON(data);
									  		$("#location_id").append( "<option value=''>Please Select</option>" ); 
										  	$.each(data, function(val, text) {
											    $("#location_id").append( "<option value='"+val+"'>"+text+"</option>" );
											});
										  	 
									  	}else if($(this).val()==2){  
										  	alert("There is no location available without admin users !!");
										  	 
									  	}else{
										  	$('#locationArea').hide();
										}		
									  }
									});
							});
		        });

                       
                       
   });
</script>

