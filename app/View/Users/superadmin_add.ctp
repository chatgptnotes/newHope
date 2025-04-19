
<?php
// echo 'ashwin';exit;
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Add User', true); ?></h3>

</div>
<?php 
     echo $this->Html->script('jquery.validationEngine');
     echo $this->Html->script('/js/languages/jquery.validationEngine-en');  
?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#userfrm").validationEngine();
	});
	
</script>

<?php 
 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
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
<?php } ?>
<form name="userfrm" id="userfrm" action="<?php echo $this->Html->url(array("controller" => "users", "action" => "add", "superadmin" => true)); ?>" method="post" onSubmit="return Validate(this);" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
		<td class="form_lables">
		<?php echo __('Username',true); ?><font color="red">*</font>
		</td>
		<td>
	        <?php 
	          echo $this->Form->input('User.username', array('class' => 'validate[required,ajax[ajaxUserCall],custom[name]]','id' => 'username', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
	        ?>
		</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Company',true); ?><font color="red">*</font>
	</td>
	<td>
	
 <select id="customfacilities" class="validate[required,custom[customfacilities]]" name="data[User][facility_id]">
<option value="">Please Select</option>
	<?php
		foreach($facilities as $key=>$value){
			echo "<option value='".$value['Facility']['id']."'>".$value['Facility']['name']."</option>";
		}
	?>
</select>
      
	</td>
	</tr>
		<tr>
	<td class="form_lables">
	<?php echo __('Role',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('User.role_id', array('class' => 'validate[required,custom[customroles]]','options' => $roles, 'id' => 'customroles', 'label'=> false, 'div' => false, 'error' => false, 'empty' => __('Please select')));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Email',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.email', array('class' => 'validate[required,custom[customemail]]', 'id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        
        <tr>
	<td class="form_lables">
	<?php echo __('Initial',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('User.initial_id', array('class' => 'validate[required,custom[custominitial]]', 'options' => $initials, 'id' => 'custominitial', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('First Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.first_name', array('class' => 'validate[required,custom[customfirstname]]', 'id' => 'customfirstname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Middle Name',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.middle_name', array('id' => 'custommiddlename', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Last Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.last_name', array('class' => 'validate[required,custom[customlastname]]', 'id' => 'customlastname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('User Alias',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.alias', array('class' => 'validate[required,custom[customalias]]', 'id' => 'customlastalias', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
        <?php echo __('Address1',true); ?>
	<font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('User.address1', array('class' => 'validate[required,custom[customaddress1]]', 'cols' => '35', 'rows' => '10', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
       <tr>
	<td class="form_lables">
	<?php echo __('Address2',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('User.address2', array('cols' => '35', 'rows' => '10', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Zipcode',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.zipcode', array('class' => 'validate[required,custom[customzipcode]]', 'id' => 'customzipcode', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr> 
        <tr>
	<td class="form_lables">
	<?php echo __('Country',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
		echo $this->Form->input('User.country_id', array('options' => $countries, 'id' => 'customcountry', 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
			'label'=> false, 'div' => false, 'error' => false,
			'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'State',
			'admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false)))); ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('State',true); ?><font color="red">*</font>
	</td>
	<td id="changeStates">
        <?php 
		echo $this->Form->input('User.state_id', array('options'=>$tempState, 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select State','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
		'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'City',
			'admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))
		));
		?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('City',true); ?><font color="red">*</font>
	</td>
	<td id="changeCities">
       <?php echo $this->Form->input('User.city_id', array('options'=>[], 'empty'=>'Select City','id' => 'city','label'=> false,
				'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd'
				)); ?>
	</td>
	</tr> 
        <tr>
	<td class="form_lables">
	<?php echo __('Phone1',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.phone1', array('class' => 'validate[required,custom[customphone1]]', 'id' => 'customphone1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
    <tr>
	<td class="form_lables">
	<?php echo __('Phone2',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.phone2', array('id' => 'customphone2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr> 
        <tr>
	<td class="form_lables">
	<?php echo __('Mobile',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.mobile', array('class' => 'validate[required,custom[custommobile]]', 'id' => 'custommobile', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
    <tr>
	<td class="form_lables">
	<?php echo __('Fax',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.fax', array('class' => 'validate[required,custom[customfax]]', 'id' => 'customfax', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	<tr> 
	<td class="form_lables">
	<?php echo __('Active',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('User.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
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
        <?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn')); ?>
	<input type="submit" value="Submit" class="blueBtn">
		
	</td>
	</tr>
	</table>
</form>
<script>
jQuery(document).ready(function(){
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


      url  = "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",
		'null','no','null',"admin" => false,"plugin"=>false)); ?> " ;
		
      $("#city1").autocomplete(url+"/state_id=" +$('#customstate').val(), {
  		width: 250,
  		selectFirst: true, 
  		});
  					
    $("#customstate2").live("change",function(){
			// alert($('#customstate').val());
		$("#city").unautocomplete().autocomplete(url+"/state_id=" +$('#customstate').val(), {
			width: 250,
			selectFirst: false, 
		});
  	});
});
</script>