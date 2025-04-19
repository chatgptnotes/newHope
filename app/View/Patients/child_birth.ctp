<?php
     echo $this->Html->script(array('jquery.autocomplete'));    
	 echo $this->Html->css('jquery.autocomplete.css');   
?> 
 <div class="inner_title">
	<h3>&nbsp; <?php echo __('Child Birth', true); ?></h3>
	<span><?php  echo $this->Html->link('Back',array('action'=>'child_birth_list',$patient_id),array('escape'=>false,'class'=>'blueBtn')); ?></span>
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


		echo $this->Form->create('ChildBirth',array('type' => 'post',
												    'id'=>'childBirthFrm',
													'url'=>array("controller" => "patients", "action" => "child_birth",$patient_id),
												    'inputDefaults' => array(
																			'label' => false,
																			'div' => false,
																		))); 
         echo $this->Form->input('ChildBirth.patient_id', array('type' => 'hidden','value'=>$patient_id)); 
         echo $this->Form->input('ChildBirth.id', array('type' => 'hidden'));
    ?>
    <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="92%"  align="left" >
    	 <tr>
			<td  width="29%" class="form_lables tdLabel" ><?php echo __('Sex'); ?><font color="red">*</font></td>
			<td width="31%">
				<?php	echo $this->Form->input('sex',array('options'=>array('Son'=>'Male','Daughter'=>'Female'),'empty'=>__('Please Select'),
						'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'sex','type'=>'select')); ?> 
			</td><td></td>
	     </tr>
    	 <tr>
			<td width="20%" class="form_lables tdLabel"> <?php echo __('Name'); ?><font color="red">*</font></td>
			<td width="20%"> <?php echo $this->Form->input('name',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'name','type'=>'text'));?> </td>
	     </tr>
	     <tr>
		      <td width="20%" class="form_lables tdLabel"> <?php echo __('Birth Date & Time',true); ?><font color="red">*</font></td>
		      <td>
				 <?php 
			            if(isset($this->data['ChildBirth']['dob'])) {
				    			echo $this->Form->input('ChildBirth.dob', array('type' => 'text', 'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd', 'readonly'=>'readonly', 'id' => 'dob',
				    			 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'value' => $this->data['ChildBirth']['dob']));
			            } else {
			            		echo $this->Form->input('ChildBirth.dob', array('type' => 'text', 'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd', 'readonly'=>'readonly',
			            		'id' => 'dob', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
			            }
				 ?>
				 <br> <br>(Enter the exact day, month and year the child was born.)
		      </td>
		      
	     </tr> 
	     <tr>
	        <td width="20%" class="form_lables tdLabel" >
			<?php echo __('Mother Name'); ?><font color="red">*</font>
			</td>
			<td width="20%"><?php echo $this->Form->input('mother_name',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'mother_name','type'=>'text', 'readonly' => 'readonly'));   ?></td>
		 </tr>
		 <tr>
		     <td width="20%" class="form_lables tdLabel"><?php echo __('Father Name'); ?><font color="red">*</font></td>
			 <td width="20%"><?php	echo $this->Form->input('father_name',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','type'=>'text'));   ?>
			 <br> <br>(full name as usually written)</td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel" ><?php echo __('Informant\'s Name' ); ?></td>
			<td width="20%"><?php	echo $this->Form->input('informant_name',array('type'=>'text','class'=>'textBoxExpnd'));?>
			<br>  <br>(full name as usually written)</td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Place of birth' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('place_of_birth',array('options'=>array('Hospital'=>'Hospital','House'=>'House'),'type'=>'radio','legend'=>false,'id'=>'place_of_birth','class'=>'place_of_birth'));  ?>  
			<br />(Tick the appropriate entry 1 or 2 below and given the name of the Hospital / Institution or the address of the house where the birth took place)
			</td>
		</tr>
		<tr style="display:none;" id="hospital_add">
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('	Hospital/Institution Name' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('hospital_name',array('type'=>'text','class'=>'textBoxExpnd'));  ?> </td>
		</tr>
		<tr style="display:none;" id="house_add">
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('House Address' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('house_address',array('type'=>'text','class'=>'textBoxExpnd'));  ?> </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Informant\'s Address' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('informant_address',array('type'=>'text','class'=>'textBoxExpnd'));  ?> </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Town' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('city',array('type'=>'text','id'=>'city','class'=>'textBoxExpnd'));  ?>
			<br />(Place where the mother usually lives. This can be different from the place where the delivery occurred. The house address is not required to be entered)  </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Is it town or village' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('is_town',array('options'=>array('Town'=>'Town','Village'=>'Village'),'type'=>'radio','legend'=>false));  ?><br />
			(Tick the appropriate enter above)  </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('District' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('district',array('type'=>'text','id'=>'district','class'=>'textBoxExpnd')); ?>  </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('State' ); ?> </td>
			<td><?php	 echo $this->Form->input('state',array('type'=>'text','id'=>'state','class'=>'textBoxExpnd'));   ?> </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Religion of the family' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('religion',array('type'=>'text','class'=>'textBoxExpnd'));  ?><br />
			(write name of the religion)  </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Father\'s level of education' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('father_edu',array('type'=>'text','class'=>'textBoxExpnd')); ?>
			<br />(Enter the completed level of education e.g. if studied upto class VII but passed only class VI, write class VI) </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Mother\'s level of education' ); ?> </td>
			<td width="20%"><?php echo $this->Form->input('mother_edu',array('type'=>'text','class'=>'textBoxExpnd'));  ?><br />
			(Enter the completed level of education e.g. if studied upto class VII but passed only class VI, write class VI)</td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Father\'s occupation' ); ?> </td>
			<td width="20%"><?php echo $this->Form->input('father_occu',array('type'=>'text','class'=>'textBoxExpnd'));     ?> 
			<br> <br>(if no occupation write 'Nil')  </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Mother\'s occupation' ); ?> </td>
			<td width="20%"><?php echo $this->Form->input('mother_occu',array('type'=>'text','class'=>'textBoxExpnd'));   ?>
			<br> <br>(if no occupation write 'Nil') </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Age of the mother(in completed years) at the time of marriage' ); ?> </td>
			<td width="20%"><?php echo $this->Form->input('mother_age_when_marry',array('type'=>'text','class'=>'textBoxExpnd'));  ?>
			<br> <br>(if married more than once, age at first marriage may be entered) </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> 	<?php echo __('Age of the mother (in completed years) at the time of this birth' ); ?> 	</td>
			<td width="20%"><?php echo $this->Form->input('mother_age_at_this_birth',array('type'=>'text','class'=>'textBoxExpnd')); ?> </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> 	<?php echo __('Number of children born alive to the mother so far including this child' ); ?> 	</td>
			<td width="20%"><?php	 echo $this->Form->input('no_of_child',array('type'=>'text','class'=>'textBoxExpnd'));  ?> 
			<br />(Number of children born alive to include also those from earlier marriage (s), if any)</td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> 	<?php echo __('Type of attention at delivery' ); ?> 	</td>
			<td width="20%"><?php	 
					$attentionArr = array('Institutional - Government',
					'Institutional - Private or Non-Government',
					'Doctor, Nurse or Trained midwife',
					'Traditional Birth Attendant',
					'Relative or others'
					);
					echo $this->Form->input('type_of_attention',array('type'=>'select','options'=>$attentionArr,'empty'=>__('Please Select'),'class'=>'textBoxExpnd'));  ?>
			 <br />(Select the appropriate entry above)</td> 
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Method of Delivery' ); ?> 	</td>
			<td width="20%"><?php	 
					$deliveryMethod = array('Natural',
					'Caesarean',
					'Forceps / Vaccum' 
					);
					echo $this->Form->input('method_of_delivery',array('type'=>'select','options'=>$deliveryMethod,'empty'=>__('Please Select'),'class'=>'textBoxExpnd'));  ?> 
					<br />(Select the appropriate entry above)</td> 
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Birth Weight (in kgs.)(if available)' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('birth_weight',array('type'=>'text','class'=>'textBoxExpnd'));  ?> </td>
		</tr>
		<tr>
	        <td width="20%" class="form_lables tdLabel"> <?php echo __('Duration of Pregnancy(in weeks)' ); ?> </td>
			<td width="20%"><?php	 echo $this->Form->input('pregnancy_duration',array('type'=>'text','class'=>'textBoxExpnd'));  ?> </td>
		</tr>  
        <tr>
			<td colspan="2" align="center">
	        &nbsp;
		</td>
		</tr>
		<tr>
		<td colspan="2" align="right">
	         
	         <input class="grayBtn" type="button" value="Cancel" 
                           	onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "child_birth_list",$patient_id));?>'">
                           	<input type="Submit" value="Submit" class="blueBtn">
		</td>
		</tr>
	</table> 
	<?php echo $this->Form->end();?>
 <script>
	jQuery(document).ready(function(){
			jQuery("#childBirthFrm").validationEngine();
		
		    $('#city').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				 selectFirst: true
			});
			$('#district').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","District","name",'null',"no","no","admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				 selectFirst: true
			});
                     $('#state').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","State","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				 selectFirst: true
			});
			// binds form submission and fields to the validation engine
			jQuery("#dischargefrm").validationEngine();
		        $( "#dob" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
		            maxDate: new Date(),
				});

			$('#sex').change(function(){
				var sex= $("#name").val();
				var org = sex.split("'s ");
				$('#name').val(org[0]+"'s "+$(this).val());
			});

			$('#PlaceOfBirthHouse,#PlaceOfBirthHospital').click(function(){
				 
				if($(this).val()=='Hospital'){
					$('#house_add').hide('fast');
					$('#hospital_add').show('slow');
				}else{
					$('#hospital_add').hide('hide');
					$('#house_add').show('slow');
				}
			});
			 
			if($('#PlaceOfBirthHospital').attr('checked') == true){ 
					$('#hospital_add').show('slow');
			}else if($('#PlaceOfBirthHouse').attr('checked') == true){
					$('#house_add').show('slow');
			}
	});
	
</script>
    
 
   
