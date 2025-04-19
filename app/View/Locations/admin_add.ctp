<?php  
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->script('fckeditor'); ?>

<div class="inner_title">
	<h3>
		<?php echo __('Add Facility', true); ?>
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
<?php } ?>

<?php echo $this->Form->create('Location',array("action" => "add", "admin" => true,'type' => 'file','id'=>'locationfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); ?>
<table
	border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="50%" align="left" colspan="2">
	<tr>
		<td class="form_lables"><?php echo __('Company name'); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.company_id', array('empty'=>'Please Select','options' => $company, 'id' => 'company_name', 'label'=> false, 'div' => false, 'error' => false,
          														  'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',));
        ?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Facility Name',true); ?><font
			color="red">*</font>
		</td>
		<td><?php
		echo $this->Form->hidden('Location.facility_id', array('type'=>'text','class' => 'validate[required,custom[facilityname]] textBoxExpnd',  'value'=>$this->Session->read('facilityid'), 'id' => 'facilityname', 'label'=> false, 'div' => false, 'error' => false));
		echo $this->Form->input('Location.name', array('type'=>'text','class' => 'validate[required,custom[customname]] textBoxExpnd', 'id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Hospital Mode',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		$defaultMode = Configure::read('hospital_default_mode');
		$options=Configure::read('hospital_mode');
		$attributes=array('class' => 'validate[required,custom[mandatory-select]]','legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false,'value'=>$defaultMode);
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
		echo $this->Form->textarea('Location.address2', array('cols' => '8', 'rows' => '3', 'id' => 'customaddress2', 'class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Zipcode',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.zipcode', array('class' => 'validate[required,custom[customzipcode]]textBoxExpnd', 'id' => 'customzipcode', 'style'=>'width:361px', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Country',true); ?></td>
		<td><?php 
		echo $this->Form->input('Location.country_id', array('options' => $countries,'empty' => 'Select Country','id' => 'customcountry', 'class' => ' textBoxExpnd',
			'label'=> false, 'div' => false, 'error' => false,
			'onchange'=> $this->Js->request(array('controller'=>'locations','action' => 'get_state_city','reference'=>'State',
			'admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false)))); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('State',true); ?></td>
		<td id="changeStates"  width='1230px'><?php 
		echo $this->Form->input('Location.state_id', array(/*'options'=>$tempState,'selected'=>'19' ,*/'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select State','class' => ' textBoxExpnd '));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('City',true); ?>
		<td><?php 
		echo $this->Form->input('Location.city_id', array('type'=>'text','id' => 'city','label'=> false,'class' =>'validate[required,custom[customcity]] textBoxExpnd'));
		//echo $this->Form->input('Location.city_id', array('type'=>'text','id' => 'cityId','label'=> false,'class' =>'textBoxExpnd')); ?>
		</td>
	</tr>
	
	<tr>
		<?php $checked = ($this->request->data['Location']['entity_type'] == '2') ? true : false; ?>
		<td class="form_lables"><?php echo __('Email',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.email', array('class' => 'validate[required,custom[customemail]] textBoxExpnd', 'id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Entity Type',true); ?><font
			color="red">*</font>
		</td>
		<td><?php
		//$attributes  = array('legend' => false, 'label' => array('class' => 'radioBtn'));
		//echo $this->Form->radio('gender', $options, $attributes);
		// debug($entity_type);exit;
		$selected = "2";
		$options=array('1'=>'Person','2'=>'Non Person');
		$attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false,'value'=>$selected);
		// echo $this->Form->label('gender','Gender');
		echo $this->Form->radio('Location.entity_type',$options,$attributes);
		//echo $this->Form->input('Location.checkout_time_option',array('type'=>'radio','options'=>array('24 Hours','Fixed'),'legend'=>false,'label'=>false,'class'=>'checkoutOptions','value'=>$selected));
		// echo $this->Form->input('Location.entity_type', array('class' => '', 'type'=>'radio','options'=>array('1'=>'Person','2'=>'Non Person'), 'id' => 'entity_type', 'legend'=>false, 'label'=> false, 'div' => false, 'error' => false,'value'=>$selected));
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
		echo $this->Form->input('Location.phone2', array('id' => 'customphone2','class'=>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Mobile',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.mobile', array('class' => 'validate[required,custom[custommobile]] textBoxExpnd', 'id' => 'custommobile', 'label'=> false, 'div' => false, 'error' => false));
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
		$selected = "0";
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
	        	 
	        	echo "&nbsp;&nbsp;&nbsp;".$this->Form->input('Location.checkout_time', array('options' => array($hoursArr),'empty'=>'Please Select',
	            	 										 'id' => 'checkout_time', 'label'=> false, 'div' => false, 'style'=>'width:239px','error' => false,
	            	 										 'class' => '','disabled'=>'disabled'));
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
		echo $this->Form->input('Location.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active','class'=>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Currency',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.currency_id', array('options' => $currency,'empty'=>__('Please Select'), 'id' => 'customis_active','class'=>'textBoxExpnd','label'=> false,
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
		echo $this->Form->input('Location.hospital_service_tax_no', array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'hospital_service_tax_no', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Hospital PAN No.',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('Location.hospital_pan_no', array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'hospital_pan_no', 'label'=> false, 'div' => false, 'error' => false));
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
		echo $this->Form->textarea('Location.footer_text_discharge', array('cols' => '10', 'rows' => '4', 'id' => 'customfooterdischarge','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<!--  Billing Footer Changes Ends -->
	<tr>
		<td class="form_lables" width="30%"><?php echo __('Header Image'); ?>
		</td>
		<td><?php echo $this->Form->input('Location.header_image', array('type'=>'file','id' => 'hospital_logo','class'=>'textBoxExpnd', 'label'=> false,
				'div' => false, 'error' => false));

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
		echo $this->Fck->fckeditor(array('Location','footer'), $this->Html->base,'','100%','400');

		?>
		</td>
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
		echo  $this->Form->input('Location.submitter_id', array('id' => 'submitter_id','label'=> false, 'class'=>'textBoxExpnd','type'=>'text', 'div' => false, 'error' => false));
		?>
		</td>
		</tr>

		<tr>
		<td class="form_lables" width="9%"><?php echo __('Location #'); ?>
		</td>
		<td width="14%"><?php
		echo  $this->Form->input('Location.location_no', array('id' => 'location_no','label'=> false, 'type'=>'text', 'class'=>'textBoxExpnd','type'=>'text', 'div' => false, 'error' => false));
		?>
		</td>
		</tr>
		<tr>
		<td class="form_lables" width="9%"><?php echo __('Provider Commercial #'); ?>
		</td>
		<td width="14%"><?php
		echo  $this->Form->input('Location.provider_commercial', array('id' => 'provider_commercial','label'=> false, 'class'=>'textBoxExpnd','type'=>'text', 'div' => false, 'error' => false));
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
<?php */?>

<?php echo $this->Form->end();?>
<script>
		var selectedCountry = '';
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
		
        $("#city").autocomplete(url+"/state_id=" +$('#customstate').val(), {
    		width: 250,
    		selectFirst: true, 
    	});
    					
        $("#customstate").live("change",function(){ 

        	// alert($('#customstate').val());
    		 $("#city").unautocomplete().autocomplete(url+"/state_id=" +$('#customstate').val(), {
    			width: 250,
    			selectFirst: true, 
    		});
    	 });
	});
	 
/*var editor = CKEDITOR.replace( 'LocationFooter',
		{
	filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',			 
	filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	filebrowserWindowWidth : '1000',
	filebrowserWindowHeight : '700'
					
});
CKFinder.setupCKEditor( editor, '/ckfinder/' );*/

</script>
