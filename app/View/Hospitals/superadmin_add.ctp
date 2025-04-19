<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#hospitalfrm").validationEngine();
	});
	
</script>
<style>
.textBoxExpnd1{
    background: none !important;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Add Enterprise', true); ?>
	</h3>
</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
				foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
			</div>
		</td>
	</tr>
</table>
<?php } ?>
<form name="hospitalfrm" id="hospitalfrm"
	action="<?php echo $this->Html->url(array("controller" => "hospitals", "action" => "add", "superadmin" => true)); ?>"
	method="post">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="50%" align="center">
		<tr>
			<td class="form_lables"><?php echo __('Company Name',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.name', array('class' => 'validate[required,custom[name]] textBoxExpnd1', 'id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<!-- Start of User type -->
		
		<tr>
			<td class="form_lables"><?php echo __('User Type',true); ?><font
				color="red">*</font>
			</td>
			<td><?php
			echo $this->Form->input('Facility.usertype', array(
	'div' => true,
'label' => false,
'type' => 'radio',
'legend' => false,
'options' => array('hospital'=>'Hospital', 'ambulatory'=>'Ambulatory'),
		'checked' => ($usertype == 'hospital' ? true : false),
		'value' => 'hospital')
);

        ?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Enterprise Type',true); ?><font
				color="red">*</font>
			</td>
			<td><?php
			echo $this->Form->input('Facility.facility_type', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd1','div' => true,'label' => false,'legend' => false,'empty'=>'Please Select',
		'options' => array('clinic'=>'Medical Practice (Clinic)', '8 beded'=>'Behavioural Health (8 Beded Hospital)','15-65 beded'=>'Small (15-65 beded)',
							'65-100 beded'=>'Medium (65-100 beded)','100-250 beded'=>'Large (100-250 beded)','250+ beded'=>'Super Hospital (250+ beded)')));

        ?>
			</td>
		</tr>
		<!-- End of User type -->
		<tr>
			<td class="form_lables"><?php echo __('Alias Name',true); ?>
			</td>
			<td><?php 

			echo $this->Form->input('Facility.alias', array('id' => 'customalias', 'label'=> false, 'div' => false, 'error' => false, 'class'=> 'textBoxExpnd1'));
			?></td>
		</tr>


		<tr>
			<td class="form_lables"><?php echo __('Address1',true); ?> <font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->textarea('Facility.address1', array('class' => 'validate[required,custom[customaddress1]] textBoxExpnd1', 'cols' => '5', 'rows' => '3', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Address2',true); ?>
			</td>
			<td><?php 
			echo $this->Form->textarea('Facility.address2', array('cols' => '5', 'rows' => '3', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false, 'class'=> 'textBoxExpnd1'));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Zipcode',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.zipcode', array('class' => 'validate[required,custom[onlyLetterNumber]] textBoxExpnd1', 'id' => 'customzipcode', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Country',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.country_id', array('class' => 'validate[required,custom[customcountry]] textBoxExpnd1', 'options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'State','controllertype'=>'hospitals','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('State',true); ?><font
				color="red">*</font>
			</td>
			<td id="changeStates"><?php $states = '';
			echo $this->Form->input('Facility.state_id', array('class' => 'validate[required,custom[customstate]] textBoxExpnd1', 'options' => $states, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('City',true); ?><font
				color="red">*</font>
			</td>
			<td><?php
			echo $this->Form->input('Facility.city', array('type'=>'text','class' => 'validate[required,custom[onlyLetterNumber]] textBoxExpnd1', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Zip 4',true); ?></font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.zip_four', array('class' => 'textBoxExpnd1', 'id' => 'customzip_four', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Currency',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.currency_id', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $currency,'empty'=>__('Please Select'), 'id' => 'customis_active', 'label'=> false,
          	 'div' => false, 'error' => false));
        ?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Email',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.email', array('class' => 'validate[required,custom[email]] textBoxExpnd1', 'id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Phone1',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.phone1', array('class' => 'validate[required,custom[onlyNumberSp]] textBoxExpnd1', 'id' => 'customphone1', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Phone2',true); ?>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.phone2', array('id' => 'customphone2', 'label'=> false, 'div' => false, 'error' => false, 'class'=> 'textBoxExpnd1'));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Mobile',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.mobile', array('class' => 'validate[required,custom[custommobile],custom[onlyNumberSp]] textBoxExpnd1', 'id' => 'custommobile', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Fax',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.fax', array('class' => 'validate[required,custom[customfax]] textBoxExpnd1', 'id' => 'customfax', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Contact Person',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.contactperson', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd1', 'id' => 'customcontactperson', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Maximum Locations',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.maxlocations', array('class' => 'validate[required,custom[onlyNumberSp]] textBoxExpnd1', 'id' => 'facilitymaxlocations', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('DateFormat For Application',true); ?>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.require_dateformat', array( 'options' =>array('dd/mm/yyyy'=>'dd/mm/yyyy','mm/dd/yyyy'=>'mm/dd/yyyy','yyyy/mm/dd'=>'yyyy/mm/dd'), 'id' => 'customdateFormat', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Discharge from ED/Observation Possible',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.discharge_from_ed', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => array('Yes'=>'Yes', 'No'=>'No'),'empty'=>__('Please Select'), 'id' => 'discharge_from_ed', 'label'=> false,
          	 'div' => false, 'error' => false));
        ?>
			</td>
		</tr>

		<tr>
			<td class="form_lables"><?php echo __('Active',true); ?>
			</td>
			<td><?php 
			echo $this->Form->input('Facility.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false, 'class' => 'textBoxExpnd1'));
			?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?php 
			echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));
			?> &nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
			</td>
		</tr>
	</table>
</form>
<script language="javascript">
  jQuery("#customcountry").change(function(){ 
   	jQuery("#customcity").empty().append('<option value="">Select City</option>');
  });
</script>
