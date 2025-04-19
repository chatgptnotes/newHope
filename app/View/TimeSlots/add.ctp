<?php
     echo $this->Html->script(array('jquery.autocomplete'));
	 echo $this->Html->css('jquery.autocomplete.css');
?>
<style>
select.textBoxExpnd ,.textBoxExpnd{
width:50%;

}
</style>
 <div class="inner_title">
	<h3>&nbsp; <?php echo __('Time Slot', true); ?></h3>
	<span><?php  echo $this->Html->link('Back',array('action'=>'index'),array('escape'=>false,'class'=>'blueBtn')); ?></span>
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
<?php }


		echo $this->Form->create('TimeSlot',array('type' => 'post',
												    'id'=>'timeSlotFrm',
													'url'=>array( "action" => "add"),
												    'inputDefaults' => array(
																			'label' => false,
																			'div' => false,
																		)));

         echo $this->Form->input('TimeSlot.id', array('type' => 'hidden'));
    ?>
    <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="left" >
	    	<tr>
				<td  class="form_lables" align="right" valign="top"><?php echo __('Role'); ?><font color="red">*</font></td>
				<td >
					<?php	echo $this->Form->input('role_id',array('options'=>$roles,'empty'=>__('Please Select'),
							'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'role_id','type'=>'select','autocomplete'=>'off')); ?>
				</td>
		    </tr>
		    <tr>
				<td class="form_lables" align="right" valign="top"><?php echo __('Name'); ?><font color="red">*</font></td>
				<td>
					<?php	echo $this->Form->input('user_id',array('empty'=>__('Please Select'),
							'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'user_id','type'=>'select')); ?>
				</td>
		    </tr>
		    <tr>
				<td class="form_lables" align="right" valign="top"><?php echo __('Duty Starting Date'); ?><font color="red">*</font></td>
				<td>
					<?php
					if(!empty($this->data['TimeSlot']['date_from']))
						$dateFrom = $this->DateFormat->formatDate2Local($this->data["TimeSlot"]['date_from'],Configure::read('date_format'));
					else
						$dateFrom = '';
					echo $this->Form->input('date_from',array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd',
					'id'=>'date_from','type'=>'text','value'=>'' ,'autocomplete'=>'off')); ?>
				</td>
		    </tr>

		    <tr>
		    	<td class="form_lables" align="right" valign="top"><?php echo __('Duty Starting Time Slot'); ?><font color="red">*</font></td>
		    	<td><?php echo $this->Form->input('time_slot', array('empty'=>__('Please Select'),'options'=>$shifts,
		    			'id' => 'time_slot','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off'));
		    		?>
		    	</td>
		    </tr>
		    <tr>
		    	<td class="form_lables" align="right" valign="top"><?php echo __('Room'); ?><font color="red">*</font></td>
		    	<td><?php
		    			echo $this->Form->input('ward_id', array('empty'=>__('Please Select'),'options'=>$wards,
		    			'id' => 'ward_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off'));
		    		?>
		    	</td>
		    </tr>
			   <tr>
		    	<td class="form_lables" align="right" valign="top"><?php echo __('Is Recurring'); ?></td>
		    	<td>
					 <input type="checkbox" name="TimeSlot[is_recurring]" value="1" id="is_recurring"><font color="red">(By selecting this the shift will change after a fixed period of time)</font></td>

		    </tr>
		   <!--  <tr id="No_of_days">
		        <td class="form_lables" align="right" valign="top"><?php echo __('No of Days for which duty'.'<br>'.' is to be done continuously'); ?></td>
		    	<td><?php echo $this->Form->input('days',array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd',
					'id'=>'','type'=>'text','value'=>'' ,'style'=>'width:10%')); ?></td>
		    
		    </tr> -->
		    
		    <tr><td colspan="2" class="form_lables" align="center" valign="top"></td></tr>
		    
		     <tr id="weekdaysrow">
		    	<td class="form_lables" align="right" valign="top"><?php echo __('Repeat Week Days'); ?><font color="red">*</font></td>
		    	<td>
					<table>
					    <tr><td colspan="2" class="form_lables" align="center" valign="top"><font color="red">(The employee will be available only on these week days every week)</font></td></tr>
		                <tr><td><input type="checkbox" name="data[TimeSlot][sunday]" value="1" disabled="disabled" id="sunday"  >SUNDAY</td></tr>
						<tr> <td><input type="checkbox" name="data[TimeSlot][monday]" value="1" disabled="disabled" id="monday" >MONDAY</td></tr>
						<tr><td><input type="checkbox" name="data[TimeSlot][tuesday]" value="1" disabled="disabled" id="tuesday"  >TUESDAY</td></tr>
						<tr><td><input type="checkbox" name="data[TimeSlot][wednesday]" value="1" disabled="disabled" id="wednesday"  >WEDNESDAY</td></tr>
						<tr><td><input type="checkbox" name="data[TimeSlot][thursday]" value="1" disabled="disabled" id="thursday"  >THURSDAY</td></tr>
						<tr><td><input type="checkbox" name="data[TimeSlot][friday]" value="1" disabled="disabled" id="friday"  >FRIDAY</td></tr>
						<tr><td><input type="checkbox" name="data[TimeSlot][saturday]" value="1" disabled="disabled" id="saturday">SATURDAY</td></tr>

					</table>
		    	</td>
		    </tr>

		     <tr id="patientArea" style="dispaly:none;">
		    	<td>&nbsp;</td>
		    </tr>
		    <tr style="display:none;">
		    	<td colspan="2">&nbsp;</td>
		    </tr>
	        <tr>
				<td colspan="2" align="center">
		        &nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" align="center">
		         
		         <input class="grayBtn" type="button" value="Cancel"
	                           	onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "index"));?>'">
			<input type="Submit" value="Submit" class="blueBtn">
			</td>
			</tr>
	</table>
	<?php echo $this->Form->end();?>
 <script>
	jQuery(document).ready(function(){
			$("#timeSlotFrm").validationEngine();
		//	$("#No_of_days").hide();
	        $( "#date_from" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect: function ()
			    {
					 var days= ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"];
			    	 for(var i =0; i<days.length; i++){
				    	  
						  $("#"+days[i]).attr("disabled","");
						  $("#"+days[i]).attr("checked",false);
					 }
					/* var date = this.value.split("/");
					 
					 var objDate = new Date(date[2]+","+date[0]+","+date[1]);
					 alert(objDate);
					 alert(days[objDate.getDay()]);
					 $("#"+days[objDate.getDay()]).removeAttr("disabled");
					 $("#"+days[objDate.getDay()]).attr("checked",true);

                     for(var i = parseInt(objDate.getDay())+1;i<=days.length-1;i++)
                        {
                                 $("#"+days[i]).removeAttr("disabled");
					             $("#"+days[i]).attr("checked",true);

                        }*/
			    }
			});

	        $('#role_id').change(function (){
	    		$.ajax({
	    				  url: "<?php echo $this->Html->url(array("controller" => 'users', "action" => "getUsersByRole", "admin" => false)); ?>"+"/"+$(this).val(),
	    				  context: document.body,
	    				  beforeSend:function(){
	    				    // this is where we append a loading image
	    				    $('#busy-indicator').show('fast');
	    				  },
	    				  success: function(data){
	    						$('#busy-indicator').hide('slow');
	    						if(data != ''){
	    							$('#user_id').empty();
	    						  	userData= $.parseJSON(data);
	    						  	$('#user_id').append( "<option value=''>Please Select</option>" );
	    						  	$.each(userData, function(val, text) {
									    $('#user_id').append( "<option value='"+val+"'>"+text+"</option>" );
									})
	    						}
	    				  }
	    		});
	    	});


	    	//calling patient list on edit action
	    	<?php if(!empty($this->data['TimeSlot']['room_id'])) { ?>
	    		get_patient(<?php echo $this->data['TimeSlot']['id']?>) ;
	    	<?php }?>


	});
	$("#is_recurring").live("change",function(){
		if(this.checked == true){
			$("#weekdaysrow").hide();
			//$("#No_of_days").show();
		}else{
			$("#weekdaysrow").show();
			//$("#No_of_days").hide();
		}

	})
</script>



