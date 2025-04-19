<script type="text/javascript" src="/js/jquery-1.5.1.min"></script>
<?php
  echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3'));
  echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
  echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
  echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); 
?>
 <div class="inner_title">
	<h3>&nbsp; <?php echo __('Discharge By Consultant', true); ?></h3>
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
<?php } ?> 
<form name="dischargefrm" id="dischargefrm" action="<?php echo $this->Html->url(array("controller" => "patients", "action" => "dischargeby_consultant")); ?>" method="post" >
    <?php 
         echo $this->Form->input('DischargebyConsultant.patient_id', array('type' => 'hidden')); 
         echo $this->Form->input('DischargebyConsultant.id', array('type' => 'hidden'));
    ?>
    <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
     <tr>
      <td class="form_lables" align="right">
	<?php echo __('Discharge Date & Time',true); ?><font color="red">*</font>
      </td>
       <td>
	 <?php 
            if($this->data['DischargebyConsultant']['discharge_date']) {
	    			echo $this->Form->input('DischargebyConsultant.discharge_date', array('type' => 'text', 'class' => 'validate[required,custom[mandatory-date]]', 'id' => 'dischargedate', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'value' => $this->DateFormat->formatDate2Local($this->data['DischargebyConsultant']['discharge_date'],Configure::read('date_format'))));
            } else {
            		echo $this->Form->input('DischargebyConsultant.discharge_date', array('type' => 'text', 'class' => 'validate[required,custom[mandatory-date]]', 'id' => 'dischargedate', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
            }
	 ?>
        </td>
       </tr>
       <tr>
	<td class="form_lables" align="right">
	<?php echo __('Description',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('DischargebyConsultant.description', array('cols' => '35', 'rows' => '10', 'id' => 'description', 'label'=> false, 'div' => false, 'error' => false));
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
         <input type="Submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
 <script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#dischargefrm").validationEngine();
        $( "#dischargedate" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
                        maxDate: new Date(),
		});
	});
	
</script>
    
 
   
