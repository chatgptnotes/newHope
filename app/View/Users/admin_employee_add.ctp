
<style type="text/css">

body {
	margin-top: 0px;
	font-family: inherit;
	line-height: 1.6;
	
}

.container {
	width: 1200px;
	margin: 0 auto;
}

.ui-widget-content {
	//background: none;
	border: 0px solid #AAAAAA;
}

label {
	width: 126px;
	padding: 0px;
}

.checkbox {
	float: left;
	width: 100%
}

.checkbox label {
	float: none;
}

.dat img {
	float: inherit;
}

.pad_bg{ background:#f5f5f5 repeat-x; border:1px solid #000;}

a {
    color: #FFFFFF ;
    font-size: 13px;
    text-decoration: none;
}
select.textBoxExpnd {
    width: 67.7% !important;
}
table{
	color : #000;
}
.tab-content{
	display:none;
	
}
</style>
<script>
$(function() {
   $( "#tabs" ).tabs();
  
// binds form submission and fields to the validation engine
jQuery("#userfrm").validationEngine();

$("#userfrm").click(function(){ 
	var returnVar = true;
    $('.cadre_to_date, .cadre_from_date ').validationEngine('hide');
    var fromdate = new Date($( '.cadre_from_date' ).val());  // alert(fromdate)
    var todate = new Date($( '.cadre_to_date' ).val()); //alert("todate")
    if(fromdate.getTime() > todate.getTime()) {
        $('.cadre_from_date,.cadre_to_date ').validationEngine('showPrompt', 'To date should be greater than from date');
        // alert('ss');return false;
    }

 
    $('#starts_on, #ends_on').validationEngine('hide');
    var fromdate = new Date($('#starts_on').val());
    var todate = new Date($('#ends_on').val());
    if(fromdate.getTime() > todate.getTime()) {
        $('#starts_on,#ends_on').validationEngine('showPrompt', 'start date should be greater than end date');
        returnVar = false;
    }
    
    if($('#password').val() != '' && $('#confPassword').val() == ''){
        $('#confPassword').validationEngine('showPrompt', 'Please confirm password');
        returnVar = false;
    }else{
        $('#confPassword').validationEngine('hide');
    }
    if($("#password").val() != $("#confPassword").val()){
	$('#confPassword').validationEngine('showPrompt', 'Incorrect password');
        returnVar = false;
    }
    return returnVar
});


$(".tab-link").click(function(e){
	$('li').removeClass('ui-state-active');
	$(this).addClass('ui-state-active');
	var id = $(this).attr('aria-labelledby').split('-');
	$(".tab-content").hide();
	$("#tabs-"+id[2]).show();
	e.preventDefault();
});
});

</script>

<div class="inner_title">
<h3>
	<?php echo __('Add User', true); ?>
</h3>

</div>
<?php //debug($userData['User']);
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>
<?php $action = ($this->data['User']['id']) ? 'edit' : 'add' ;?>
<?php  echo $this->Form->create('User',array('type' => 'file','autocomplete'=>"off",'name'=>'userfrm','id'=>'userfrm',
		'url'=>array('controller'=>'users','action'=>$action,'admin'=>TRUE ,'?'=>array('newUser'=>'ls')),
		'inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); 
		echo $this->Form->hidden('HrDetail.id',array('value'=>$this->data['HrDetail']['id']));
		echo $this->Form->hidden('User.id',array('value'=>$this->data['User']['id']));
		echo $this->Form->hidden('User.newUser',array('value'=>'ls')); ?>
<div id="tabs" class="container" style="padding-top: 10px;">
	<ul class="tabs">
		<li class="tab-link bg_color" data-tab="tab-1"><a href="#tabs-1"><?php echo __('Employee Details');?>
		</a>
		</li>
		<li class="tab-link bg_color" data-tab="tab-2"><a href="#tabs-2"><?php echo __('Qualification & Documents');?>
		</a>
		</li>
		<li class="tab-link bg_color" data-tab="tab-3"><a href="#tabs-3"><?php echo __('Bank Details & Assets');?>
		</a>
		</li>
		<li class="tab-link bg_color" data-tab="tab-4"><a href="#tabs-4"><?php echo __('Employee History');?>
		</a>
		</li>
		<li class="tab-link bg_color" data-tab="tab-5"><a href="#tabs-5"><?php echo __('Employee Exit Related');?>
		</a>
		</li>
		<li class="tab-link bg_color" data-tab="tab-6"><a href="#tabs-6"><?php echo __('Details Of Family Members');?>
		</a>
		</li>
	    <li class="tab-link bg_color" data-tab="tab-7"><a href="#tabs-7"><?php echo __('Pay Details');?>
		</a>
		</li>
	</ul>

	<div id="tabs-1" style="padding-top: 5px;" class="tab-content ">
		<?php echo $this->element('employee_detail');?>
	</div>
	<div id="tabs-2" style="padding-top: 5px;" class="tab-content">
		<?php echo $this->element('hr_qualification');?>
	</div> 
	<div id="tabs-3" style="padding-top: 5px;" class="tab-content">
		<?php echo $this->element('BankDetails_assest');?>
	</div>
	<div id="tabs-4" style="padding-top: 5px;" class="tab-content">
		<?php echo $this->element('employee_history');?>
	</div>
	<div id="tabs-5" style="padding-top: 5px;" class="tab-content">
		<?php echo $this->element('emp_exit_related');?>
	</div>
	<div id="tabs-6" style="padding-top: 5px;" class="tab-content">
		<?php echo $this->element('family_member');?>
	</div>
	<div id="tabs-7" style="padding-top: 5px;" class="tab-content">
		<?php echo $this->element('pay_detail');?>
	</div>
</div>	
