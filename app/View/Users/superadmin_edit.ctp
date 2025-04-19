<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<style>

.textBoxExpnd{
border:1px solid #214A27;
background:#121212;  
font-size:13px;
/*padding:5px 7px;*/
width:87%;
outline:none;
resize:none;
color:#e7eeef;
height:25px; 
	line-height:25px;
}</style>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#userfrm").validationEngine();
	});
$(document).ready(function(){
	$('#confPassword').attr('readonly', true);
	
	$("#incorrect").hide();
	$("#correct").hide();
});
 // Function to check that passwords are matching or not
	function getChecked(confirm){
		var password = $("#password").val();
		
	  if(confirm != ''){
		if(password != confirm){
			$("#incorrect").show();
			$("#correct").hide();
		} else {
			$("#incorrect").hide();
			$("#correct").show();
		}
	  } else {		
		$("#incorrect").hide();
		$("#correct").hide();
	  }
	}

// Function get Empty
	function makeEmpty(password){
		$('#confPassword').attr('readonly', false);
		$('#confPassword').val('');
		$("#incorrect").hide();
		$("#correct").hide();
	}	
</script>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Edit User', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
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
<form name="userfrm" id="userfrm" action="<?php echo $this->Html->url(array("controller" => "users", "action" => "edit",$facility['Facility']['id'], $user['User']['username'],"superadmin" => true)); ?>" method="post" onSubmit="return Validate(this);" >
        <?php echo $this->Form->input('User.id', array('type' => 'hidden')); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
        <tr>
		<td class="form_lables">
		<?php echo __('Username',true); ?><font color="red">*</font>
		</td>
		<td>
	        <?php 
	           echo $user['User']['username'];
	        ?>
		</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Role',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
         echo $user['Role']['name'];
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Company',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
         echo $facility['Facility']['name'];
        ?>
	</td>
	</tr>
	<tr>
		<td class="form_lables" >
		<?php echo __('New Password',true); ?>
		</td>
		<td>
	        <?php 
	          echo $this->Form->input('User.password', array('id' => 'password', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off','value'=>'','onkeyup'=>'makeEmpty(this.value)'));
	        ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables" >
		<?php echo __('Confirm Password',true); ?>
		</td>
		<td>
	        <?php 
	          echo $this->Form->input('User.conf_password', array('type'=>'password','id' => 'confPassword', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off','onkeyup'=>'getChecked(this.value)'));
			  echo $this->Html->image('icons/cross.png',array('id'=>'incorrect','style'=>'display:none;'));
			  echo $this->Html->image('icons/tick.png',array('id'=>'correct','style'=>'display:none;'));
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
        echo $this->Form->input('User.middle_name', array('class' => '', 'id' => 'custommiddlename', 'label'=> false, 'div' => false, 'error' => false));
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
        echo $this->Form->input('User.alias', array('class' => 'validate[required,custom[customlastname]]', 'id' => 'customlastalias', 'label'=> false, 'div' => false, 'error' => false));
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
		echo $this->Form->input('User.country_id', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry',
			'label'=> false, 'class' => 'textBoxExpnd', 'div' => false, 'error' => false,
			'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'State',
			'admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('State',true); ?><font color="red">*</font>
	</td>
	<td id="changeStates">
        <?php 
		echo $this->Form->input('User.state_id', array('options' => $states, 'empty' => 'Select State',
		 'class' => 'textBoxExpnd','id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
		?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('City',true); ?><font color="red">*</font>
	</td>
	
	<td id="changeCities">
       <?php echo $this->Form->input('User.city_id', array('options'=>$cities, 'empty'=>'Select City','id' => 'city','label'=> false,
				'class' => 'textBoxExpnd','div' => false, 'error' => false
				)); ?>
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
	</tr> 
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
$(document).ready(function(){

	
	url  = "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",
			'null','no','null',"admin" => false,"plugin"=>false)); ?> " ;

	$("#customcity1").autocomplete(url+"/state_id=" +$('#customstate').val(), {
		width: 250,
		selectFirst: true, 
	});
					
	 $("#customstate1").live("change",function(){ 
		 $("#customcity").unautocomplete().autocomplete(url+"/state_id=" +$('#customstate').val(), {
			width: 250,
			selectFirst: true, 
		});
	 });
});

</script>