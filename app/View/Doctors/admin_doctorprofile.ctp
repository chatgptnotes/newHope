<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?> <style>.pract{border-style:1px solid, color:#fff;}</style>
<script>
var imageUrl= "<?php echo $this->Html->url("/img/color.png"); ?>";
</script>
<?php
echo $this->Html->script(array('izzyColor'));
?>
<div class="inner_title">
<div id="flashMessage"></div>
<h3><?php echo __('Edit Doctor', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#doctorfrm").validationEngine();
	});
	
</script>

<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php } ?>
<form name="doctorfrm" id="doctorfrm" action="<?php echo $this->Html->url(array("controller" => "doctors", "action" => "doctorprofile", "admin" => true)); ?>" method="post" >
        <?php 
             echo $this->Form->input('Doctor.id', array('type' => 'hidden')); 
             echo $this->Form->input('DoctorProfile.id', array('type' => 'hidden')); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="56%"  align="center">
        <tr>
	<td width="37%" class="form_lables tdLabel">
        <?php echo __('First Name',true); ?><font color="red">*</font>
	</td>
	<td width="50%">
        <?php 
        echo $this->Form->input('DoctorProfile.first_name', array('class' => 'validate[required,custom[customfirstname]] textBoxExpnd', 'id' => 'firstname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables tdLabel">
        <?php echo __('Middle Name',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.middle_name', array('id' => 'middlename', 'class'=>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables tdLabel">
        <?php echo __('Last Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.last_name', array('class' => 'validate[required,custom[customlastname]] textBoxExpnd', 'id' => 'lastname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
        </tr>
       <tr>
	<td class="form_lables tdLabel">
        <?php 
        echo __('Address1',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('DoctorProfile.address1', array('cols' => '35', 'rows' => '10', 'class'=>'textBoxExpnd', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false, 'value'=> $userData['User']['address1']));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Address2',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('DoctorProfile.address2', array('cols' => '35', 'rows' => '10', 'class'=>'textBoxExpnd', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false, 'value'=> $userData['User']['address2']));
        ?>
        </td>
	</tr>
	
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('Country',true); ?>
	</td>
	<td>
       <?php 
	      echo $this->Form->input('DoctorProfile.country_id', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'default'=> $userData['User']['country_id'],  'class'=>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'app','action' => 'get_state_city','controllertype'=>'doctors','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));
       ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('State',true); ?>
	</td>
	<td id="changeStates">
        <?php 
		 
          echo $this->Form->input('DoctorProfile.state_id', array('options' => $states, 'empty' => 'Select State', 'id' => 'customstate', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false, 'default'=> $userData['User']['state_id'],'onchange'=> $this->Js->request(array('controller'=>'app','action' => 'get_state_city','reference'=>'City','controllertype'=>'doctors','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('City',true); ?>
	</td>
	<td id="changeCities">
	<?php  echo $this->Form->input('DoctorProfile.city_id', array('type'=>'text','id' => 'customcity',  'class'=>'textBoxExpnd','value'=> $userData['City']['name'],'label'=> false)); ?>
    <?php 
	   //echo $this->Form->input('DoctorProfile.city_id', array( 'id' => 'customcity', 'label'=> false,'value'=>$this->data['City']['name'], 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Zipcode',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.zipcode', array('id' => 'customzipcode', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false, 'value'=> $userData['User']['zipcode']));
        ?>
	</td>
	</tr>
	
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('NPI No',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.npi', array( 'class' => 'textBoxExpnd','id' => 'npi', 'type'=>'text', 'label'=> false, 'div' => false, 'error' => false, 'value'=> $userData['User']['npi']));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('DEA #',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.dea', array( 'class' => 'textBoxExpnd','id' => 'dea', 'type'=>'text', 'label'=> false, 'div' => false, 'error' => false, 'value'=> $userData['User']['dea']));
        ?>
	</td>
	</tr>
	
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('UPIN #',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.upin', array( 'class' => 'textBoxExpnd','id' => 'upin', 'type'=>'text', 'label'=> false, 'div' => false, 'error' => false,'value'=> $userData['User']['upin']));
        ?>
	</td>
	</tr>
	
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('State ID',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.state', array( 'class' => 'textBoxExpnd','id' => 'state', 'type'=>'text', 'label'=> false, 'div' => false, 'error' => false,'value'=> $userData['User']['state']));
        ?>
	</td>
	</tr>
	
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('CAQH Provider ID',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.caqh_provider_id', array( 'class' => 'textBoxExpnd','id' => 'customcaqhproviderid', 'type'=>'text', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false, 'value'=> $userData['User']['caqhproviderid']));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('Provider credentialing and enrollment applications status',true); ?>
	</td>
	<td><?php 
		echo $this->Form->input('DoctorProfile.enrollment_status', array('class' => 'textBoxExpnd','options'=>Configure::read('enrollment_status'),'id' => 'enrollment_status', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('Licensure Type',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.licensure_type', array('id' => 'customlicensuretype','options'=>$licenture,'empty' => 'Please Select Type', 'class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false, 'value'=> $userData['User']['licensuretype']));
        
        ?> 
        <?php 
	      //echo $this->Form->input('DoctorProfile.country_id', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'default'=> $userData['User']['country_id'],  'class'=>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'app','action' => 'get_state_city','controllertype'=>'doctors','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));
       ?>
	</td>
	</tr>
	
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('Licensure No',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.licensure_no', array('id' => 'customlicensureno', 'class' => 'textBoxExpnd','type'=>'text', 'label'=> false, 'div' => false, 'error' => false, 'value'=> $userData['User']['licensureno']));
        ?>
	</td>
	</tr>
	
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('Expiration Date',true); ?>
	</td>
	 <td>
        <?php 
         if($this->data['Doctor']['expiration_date'] == "0000-00-00") {
            $expiration_dateVal = "";
         } else {
            $expiration_dateVal = $this->DateFormat->formatDate2Local($this->data['Doctor']['expiration_date'],Configure::read('date_format'),false);
         }
         echo $this->Form->input('Doctor.expiration_date', array('id' => 'expiration_date', 'readonly'=>'readonly', 'label'=> false, 'div' => false, 'error' => false, 'type' => 'text', "style" =>"float:left;", 'value'=> $expiration_dateVal));
        ?>
	</td>
	</tr>
	
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('Email',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.email', array('id' => 'customemail', 'label'=> false, 'class'=>'textBoxExpnd', 'div' => false, 'error' => false, 'value'=> $userData['User']['email']));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Phone1',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.phone1', array('id' => 'customphone1', 'label'=> false, 'div' => false, 'class'=>'textBoxExpnd', 'error' => false, 'value'=> $userData['User']['phone1']));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Phone2',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.phone2', array('id' => 'customphone2', 'label'=> false, 'div' => false, 'class'=>'textBoxExpnd', 'error' => false, 'value'=> $userData['User']['phone2']));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Mobile',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.mobile', array('id' => 'custommobile', 'label'=> false, 'class'=>'textBoxExpnd', 'div' => false, 'error' => false, 'value'=> $userData['User']['mobile']));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Fax',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.fax', array('id' => 'customfax', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false, 'value'=> $userData['User']['fax']));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables tdLabel">
	<?php echo __('Specialty ',true); ?> 
	</td>
	<td>
        <?php 
          echo $this->Form->input('DoctorProfile.department_id', array('class' => 'textBoxExpnd', 'options' => $departments,'empty' => 'Select Specialty ', 'id' => 'customdepartment', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        
        <tr>
	<td class="form_lables tdLabel">
        <?php echo __('Education',true);?><font color="red">*</font>
	</td>
	<td>
        <?php 
       // echo $this->Form->input('DoctorProfile.education', array('class' => 'validate[required,custom[customeducation]] textBoxExpnd', 'id' => 'customeducation', 'label'=> false, 'div' => false, 'error' => false, 'value' => $this->request->data['DoctorProfile']['education']));
        echo $this->Form->textarea('DoctorProfile.education', array('cols' => '35', 'rows' => '10', 'id' => 'customeducation', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false,'value' => $this->request->data['DoctorProfile']['education']));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Has Specialty',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('DoctorProfile.haspecility', array('options' => array('No', 'Yes'), 'id' => 'customhaspecility', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr id="specility_keyword">
	<td class="form_lables tdLabel">
	<?php echo __('Description of specialty and training',true); ?><font color="red">*</font>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('DoctorProfile.specility_keyword', array('class' => 'validate[required,custom[customspecility_keyword]] textBoxExpnd','cols' => '35', 'rows' => '10', 'id' => 'customspecility_keyword', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Experience',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.experience', array('id' => 'customexperience','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Profile Description',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('DoctorProfile.profile_description', array('cols' => '35', 'rows' => '10', 'id' => 'customprofile_description', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Date of Birth',true); ?>
	</td>
	<td>
        <?php 
         if($this->data['DoctorProfile']['dateofbirth'] == "0000-00-00") {
            $datebirthVal = "";
         } else {
            $datebirthVal = $this->DateFormat->formatDate2Local($this->data['DoctorProfile']['dateofbirth'],Configure::read('date_format'),true);
         }
         echo $this->Form->input('DoctorProfile.dateofbirth', array('id' => 'customdateofbirth', 'readonly'=>'readonly', 'label'=> false, 'div' => false, 'error' => false, 'type' => 'text', "style" =>"float:left;", 'value'=> $datebirthVal));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables tdLabel">
	<?php echo __('Present Event Color Code',true); ?>
	</td>
	<td>
        <?php 
         echo $this->Form->input('DoctorProfile.present_event_color', array('class' => 'izzyColor', 'class'=>'textBoxExpnd', 'id' => 'presentcolorcode', 'label'=> false, 'div' => false, 'error' => false, 'type' => 'text'));
        ?>
	</td>
        </tr>
        <tr>
		<td class="form_lables tdLabel">
			<?php echo __('Token Character',true); ?>
		</td>
		<td>
	        <?php 
	         echo $this->Form->input('DoctorProfile.token_alphabet', array('options'=>$alphabet,'class' => ' textBoxExpnd', 'id' => 'token_alphabet', 'style'=>'width:307px','label'=> false, 'div' => false, 'error' => false, 'type' => 'select'));
	        ?>
		</td>
    </tr>
    <tr id="surgeonshow" >
			   <td class="form_lables tdLabel"> 
		               <?php echo __('Surgeon',true); ?>
		          </td>
		          <td id="showDepartmentList">
		           <?php 
		            echo $this->Form->input('DoctorProfile.is_surgeon', array('type' => 'radio','label' => false, 'class'=>'','legend' => false ,'options' => array('0'=>'No', '1' => 'Yes')));
		           ?>
		          </td>
		        </tr>
		        <tr>
		             <td class="form_lables tdLabel"> <h4> <?php echo __('Scope Of Practice',true); ?></td></h4>
		        </tr>
		          <tr  >
		          <td class="form_lables tdLabel"> 
		               <?php echo __('Height/Weight',true); ?>
		          </td>
		       <td>
		        <?php 
				echo $this->Form->checkbox('DoctorProfile.height_weight'); ?>
     
			</td></tr>
	 		<tr>
		          <td class="form_lables tdLabel"> 
		               <?php echo __('B.P.',true); ?>
		          </td>
		       <td>
       <?php echo $this->Form->checkbox('DoctorProfile.bp');
        ?>
	</td></tr>

    <!--<tr>
     <td class="form_lables" align="right">
        <?php echo __('Is Registrar',true); ?>
          </td>
          <td>
            <?php 
            //echo $this->Form->input('DoctorProfile.is_registrar', array('options' => array('No', 'Yes'), 'id' => 'is_registrar', 'label'=> false, 'div' => false, 'error' => false));
            ?>
          </td>
        </tr>-->
        <!--<tr>
	<td class="form_lables" align="right">
	<?php //echo __('Past Event Color Code',true); ?>
	</td>
	<td>
        <?php 
         //echo $this->Form->input('DoctorProfile.past_event_color', array('class' => 'izzyColor', 'id' => 'pastcolorcode', 'label'=> false, 'div' => false, 'error' => false, 'type' => //'text'));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables" align="right">
	<?php //echo __('Future Event Color Code',true); ?>
	</td>
	<td>
        <?php 
         //echo $this->Form->input('DoctorProfile.future_event_color', array('class' => 'izzyColor', 'id' => 'futurecolorcode', 'label'=> false, 'div' => false, 'error' => false, 'type' => //'text'));
        ?>
	</td>
        </tr> -->
	<tr>
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
    
        <?php 
   	echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 0 0 29px;'));
        ?>&nbsp;&nbsp;
	 <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
<script>
$(document).ready(function(){
		//script to include datepicker
                $(function() {
                    	var firstYr = new Date().getFullYear()-100;
                    	var lastYr = new Date().getFullYear()-20;
                    	
                        //var dateminmax = new Date(new Date().getFullYear()-100, 0, 0)+':'+new Date(new Date().getFullYear()-20, 0, 0);
                        $( "#customdateofbirth" ).datepicker({
								showOn: "button",
								buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
								buttonText:'Date of Birth',
								buttonImageOnly: true,
								changeMonth: true,
								changeYear: true, 
								dateFormat:'<?php echo $this->General->GeneralDate();?>',
					                        yearRange: firstYr+':'+lastYr,
                                                                defaultDate: new Date(firstYr)
								//minDate: new Date(new Date().getFullYear()-100, 0, 0),
                       // maxDate: new Date(new Date().getFullYear()-20, 0, 0)
		});		
		});

		url  = "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",
		'null','no','null',"admin" => false,"plugin"=>false)); ?> " ;
		
        $("#customcity").autocomplete(url+"/state_id=" +$('#customstate').val(), {
    		width: 250,
    		selectFirst: true, 
    	});
    					
        $("#customstate").live("change",function(){ 
 
        	 //alert($('#customstate').val());
    		 $("#customcity").unautocomplete().autocomplete(url+"/state_id=" +$('#customstate').val(), {
    			width: 250,
    			selectFirst: true, 
    		});
    	 });
            }); 
        		
            $("#expiration_date").datepicker({	
        		changeMonth : true,
        		changeYear : true, 
        		//timeFormat:(HH:II:SS),
        		yearRange: '1950',
        		dateFormat : '<?php echo $this->General->GeneralDate();?>',
        		showOn : 'button',
        		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        		buttonImageOnly : true,
        		onSelect : function() {
        			$(this).focus();
        		}
        	});
    	
</script>