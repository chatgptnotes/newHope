<?php  echo $this->Html->script('fckeditor');
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css'); ?>

<div class="inner_title">
	<h3>
		<?php echo __('Edit Facility', true); ?>
	</h3>
</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } 
 echo $this->Form->create('Location',array("action" => "edit", "admin" => true,'type' => 'file','id'=>'locationfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); ?>
<?php echo $this->Form->input('Location.id', array('type' => 'hidden')); ?>
<table
	border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="50%" align="left">

	<tr>
		<td class="form_lables"><?php echo __('Company name'); ?><font
			color="red">*</font>
		</td>
		<td><?php 

		echo $this->Form->input('Location.company_id', array('empty'=>'Please Select','options' => $company_name, 'id' => 'company_name', 'label'=> false, 'div' => false, 'error' => false,
																	'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',)); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Facility Name',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.name', array('class' => 'validate[required,custom[customname]] textBoxExpnd', 'id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Hospital Mode',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		$options=Configure::read('hospital_mode');
		$attributes=array('class' => 'validate[required,custom[mandatory-select]]','legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false,'value'=>$this->data['Location']['hospital_mode']);
		echo $this->Form->radio('Location.hospital_type',$options,$attributes);
		?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Address1',true); ?> <font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->textarea('Location.address1', array('class' => 'validate[required,custom[customaddress1]] textBoxExpnd', 'cols' => '8', 'rows' => '3', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Address2',true); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('Location.address2', array('cols' => '8', 'rows' => '3', 'id' => 'customaddress2','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Zipcode',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.zipcode', array('class' => 'validate[required,custom[customzipcode]] textBoxExpnd', 'id' => 'customzipcode', 'style'=>'width:361px', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Country',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('Location.country_id', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry',
			'label'=> false, 'class' => 'textBoxExpnd', 'div' => false, 'error' => false,
			'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'State',
			'admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));
        ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('State',true); ?>
		</td>
		<td id="changeStates"><?php 
		echo $this->Form->input('Location.state_id', array('options' => $states, 'empty' => 'Select State',
		 'class' => 'textBoxExpnd','id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('City',true); ?></td>
		<td id="changeCities"><?php 
		echo $this->Form->input('Location.city_id', array('type'=>'text', 'value'=>$this->data['City']['name'],
		'id' => 'customcity','class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Email',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.email', array('class' => 'validate[required,custom[customemail]] textBoxExpnd', 'id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>

	<tr>
		<?php $checked = ($this->request->data['Location']['entity_type'] == '2') ? true : false; ?>
		<td class="form_lables"><?php echo __('Entity Type',true); ?><font
			color="red">*</font>
		</td>
		<td><?php
		//$attributes  = array('legend' => false, 'label' => array('class' => 'radioBtn'));
		//echo $this->Form->radio('gender', $options, $attributes);
		// debug($entity_type);exit;
		//$selected = "2";
		$options=array('1'=>'Person','2'=>'Non Person');
		$attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false,'value'=>$selected);
		echo $this->Form->radio('Location.entity_type',$options,$attributes);
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Phone1',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.phone1', array('class' => 'validate[required,custom[customphone1]] textBoxExpnd', 'id' => 'customphone1', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Phone2',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('Location.phone2', array('id' => 'customphone2', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Mobile',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.mobile', array('class' => 'validate[required,custom[custommobile]]textBoxExpnd', 'id' => 'custommobile','style'=>'width:360px','label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Fax',true); ?><font color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.fax', array('class' => 'validate[required,custom[customfax]] textBoxExpnd', 'id' => 'customfax', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Contact Person',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.contactperson', array('class' => 'validate[required,custom[customcontactperson]] textBoxExpnd', 'id' => 'customcontactperson', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php  echo $this->Form->checkbox('Location.sms_feature_chk', array('class' => 'textBoxExpnd', 'id' => 'sms_feature_chk', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
		<td><?php 
		echo __('Enable SMS Feature',true);
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('From Mobile Number',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('Location.frm_mobile_no', array('type'=>'text','class' => 'textBoxExpnd', 'id' => 'frm_mobile_no', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('From Name',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('Location.frm_name', array('type'=>'text','class' => 'textBoxExpnd', 'id' => 'frm_name', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Accreditation'); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.accreditation', array('empty'=>'Please Select','options' => array('NABH'=>'NABH', 'NON-NABH'=>'NON-NABH'), 'id' => 'accreditation', 'label'=> false, 'div' => false, 'error' => false,
          														  'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',));
        ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Checkout Time'); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		if(empty($this->data['Location']['checkout_time_option'])) $selected = "0";
		else $selected = $this->data['Location']['checkout_time_option'] ;
			
		echo $this->Form->input('Location.checkout_time_option',array('type'=>'radio','options'=>array('24 Hours','Fixed'),'legend'=>false,'label'=>false,'class'=>'checkoutOptions','value'=>$selected));

		for($t=0;$t<24;$t++){
	        		if($t<12){
	        			if($t==0)
	        				$hoursArr[$t] = "00 AM";
	        			else
	        				$hoursArr[$t] = "$t AM" ;
	        		}else{
	        			if($t==12)
	        				$hoursArr[$t] = "$t PM";
	        			else
	        				$hoursArr[$t] = ($t-12)." PM" ;
	        		}
	        	}
	        	if($selected==1) $disabled =  '';
	        	else $disabled =  'disabled'  ;
	        	echo "&nbsp;&nbsp;&nbsp;".$this->Form->input('Location.checkout_time', array('options' => array($hoursArr),'empty'=>'Please Select',
	            	 										 'id' => 'checkout_time', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:239px',
	            	 										 'disabled'=>$disabled));
	        ?></td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Case Summary Link',true); ?>
		</td>
		<td><?php echo 	$this->Form->input('Location.case_summery_link', array('class'=>'textBoxExpnd','id' => 'case_summery_link', 'label'=> false, 'div' => false, 'error' => false)); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Patient File',true); ?>
		</td>
		<td><?php echo 	$this->Form->input('Location.patient_file', array('class'=>'textBoxExpnd','id' => 'patient_file', 'label'=> false, 'div' => false, 'error' => false)); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Is Active',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('Location.is_active', array('options' => array('0' => 'No','1' => 'Yes'), 'id' => 'customis_active','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false, 'selected' => $this->data['Location']['is_active']));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Currency',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.currency_id', array('options' => $currency,'empty'=>__('Please Select'), 'id' => 'customis_active', 'class'=>'textBoxExpnd', 'label'=> false,
          	 'div' => false, 'error' => false));
        ?>
		</td>
	</tr>
	<!--  Billing Footer Changes starts -->
	<tr>
		<td class="form_lables"><?php echo __('Hospital Billing Footer Name',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.billing_footer_name', array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'billing_footer_name', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Hospital Service Tax No./Tax ID Number',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.hospital_service_tax_no', array('class'=>'validate[required,custom[mandatory-enter]]textBoxExpnd','id' => 'hospital_service_tax_no','style'=>'width:360px','label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Hospital PAN No.',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.hospital_pan_no', array('class'=>'validate[required,custom[mandatory-enter]]textBoxExpnd','id' => 'hospital_pan_no','style'=>'width:360px','label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Place of Service Code',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.place_service_code', array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'place_service_code', 'options'=>Configure::read('place_service_code'), 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Hospital NPI.',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('Location.hospital_npi', array('class'=>'textBoxExpnd','id' => 'hospital_npi', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>

		<td class="form_lables"><?php echo __('Footer for Discharge Summary',true); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('Location.footer_text_discharge', array('cols' => '8', 'rows' => '4', 'id' => 'customfooterdischarge', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<!--  Billing Footer Changes Ends -->

	<tr>
		<td class="form_lables" width="30%"><?php echo __('Header Image'); ?>
		</td>
		<td><?php echo $this->Form->input('Location.header_image', array('type'=>'file','id' => 'hospital_logo', 'class'=>'textBoxExpnd', 'label'=> false,'div' => false, 'error' => false));

		if($this->data['Location']['header_image']){
					echo $this->Html->link($this->Html->image('/uploads/image/'.$this->data['Location']['header_image'],array('width'=>'100','height'=>100)),'/uploads/image/'.$this->data['Location']['header_image'],array('escape'=>false,'target'=>'__blank'));
				}
				?>
		</td>
	</tr>
	<tr>
		<td class="form_lables" width="30%"><?php echo __('Footer Text'); ?></td>
		<td><?php
		//echo $this->Form->textarea('Location.footer',array('label' => false,'cols'=>'10','rows'=>'10','div'=>false,'class'=>'ckeditor'));
		// echo $this->Fck->load('Location/footer');
		//echo $this->Fck->load('Location.footer');
		echo $this->Fck->fckeditor(array('Location','footer'), $this->Html->base,$this->data['Location']['footer'],'100%','400');
			
		?></td>
	</tr>
	<tr>
		<td colspan="2" align="right"><?php 
		echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));
		?> &nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
		</td>
	</tr>
</table>
<?php /* ?>
<table align="left" cellspacing="0" width="45%" cellpadding="0"
	style="padding-top: 25px;">
	<tr>
		<td>
			<table width="100%">
				<tr class="row_gray">
					<th align="left" valign="top">Electronic</th>

				</tr>
				<tr>
					<td class="form_lables" width="9%"><?php echo __('Submitter ID'); ?>
					</td>
					<td width="14%"><?php 
					echo $this->Form->input('Location.submitter_id', array('id' => 'submitter_id','label'=> false, 'class'=>'textBoxExpnd','type'=>'text', 'div' => false, 'error' => false));
					?>
					</td>
				</tr>
				<tr>
					<td class="form_lables" width="9%"><?php echo __('Location #'); ?>
					</td>
					<td width="14%"><?php 
					echo $this->Form->input('Location.location_no', array('id' => 'location_no','label'=> false, 'class'=>'textBoxExpnd', 'type'=>'text', 'div' => false, 'error' => false));
					?>
					</td>
				</tr>
				<tr>
					<td class="form_lables" width="9%"><?php echo __('Provider Commercial #'); ?>
					</td>
					<td width="14%"><?php 
					echo $this->Form->input('Location.provider_commercial', array('id' => 'provider_commercial','label'=> false, 'class'=>'textBoxExpnd', 'type'=>'text', 'div' => false, 'error' => false));
					?>
					</td>
				</tr>
				<tr>
					<td class="form_lables"><?php  echo __('UPIN');?></td>
					<td><?php echo $this->Form->input('Location.upin', array('type'=>'text','class'=>'textBoxExpnd', 'id' => 'upin', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
				</tr>
				<tr>
					<td class="form_lables"><?php  echo __('State License');?></td>
					<td><?php echo $this->Form->input('Location.state_license', array('type'=>'text','class'=>'textBoxExpnd','id' => 'state_license', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>
<?php */ ?>
<?php echo $this->Form->end();?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#locationfrm").validationEngine();

		//checkout timign options 
		$('.checkoutOptions').click(function(){  
			if($(this).attr('checked')==true){
					if($(this).attr('id')=='LocationCheckoutTimeOption1'){
						$('#checkout_time').attr('disabled','');
						$("#checkout_time").addClass('validate[required,custom[mandatory-select]]');
					}else{
						$("#checkout_time").removeClass('validate[required,custom[mandatory-select]]');
						$('#checkout_time').attr('disabled','disabled');
					}
						
			}
			
		});

		url  = "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",
		'null','no','null',"admin" => false,"plugin"=>false)); ?> " ;


$("#customcity").autocomplete(url+"/state_id=" +$('#customstate').val(), {
	width: 250,
	selectFirst: true, 
});
				
 $("#customstate").live("change",function(){ 
	 $("#customcity").unautocomplete().autocomplete(url+"/state_id=" +$('#customstate').val(), {
		width: 250,
		selectFirst: true, 
	});
 });
	});
	
</script>
