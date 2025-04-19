<?php echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array('slides.min.jquery.js?ver=1.1.9',
									'jquery.isotope.min.js?ver=1.5.03', 'ibox.js','jquery.fancybox-1.3.4')); ?>
<div class="inner_title">
	<h3><?php echo __('Edit Currency', true); ?></h3>
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
 
<?php echo $this->Form->create('',array('controller'=>'Currency','action'=>'edit','id'=>'Currencyfrm','admin'=>false,'superadmin'=>false));?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
		<td colspan="2" align="center">
		<br>
		</td>
	</tr>   
	<tr>
		<td class="form_lables">
		<?php echo __('Name'); ?><font color="red">*</font>
		</td>
		<td>
	        <?php
	        	echo $this->Form->hidden('id'); 
	        	echo $this->Form->input('name', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd',
	        	 'id' => 'Currencyname', 'label'=> false, 'div' => false, 'error' => false)  );
	        ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Country Code'); ?><font color="red">*</font>
		</td>
		<td>
	        <?php  
	        	echo $this->Form->input('country_code', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false)  );
	        ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Currency'); ?>
		</td>
		<td>
	        <?php 	echo $this->Form->input('currency', array('class'=>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false)  );
	        ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Currency Code'); ?><font color="red">*</font>
		</td>
		<td>
	        <?php  echo $this->Form->input('currency_code', array('class' => 'textBoxExpnd',
	        	   'label'=> false, 'div' => false, 'error' => false)  );
	        ?>
		</td>
	</tr>	
	<tr>
		<td class="form_lables">
		<?php echo __('Currency Symbol'); ?>
		</td>
		<td> 
	        <?php  echo $this->Form->input('currency_symbol', array('class' => 'textBoxExpnd',
	        	   'label'=> false, 'div' => false, 'error' => false,'id'=>'currency_symbol')  );
	        	   echo "<br/><br/>";
	        ?>
	        <a class="tdLabel2" style="text-decoration:underline;" href="#" id="view-currency-format">
	        	Click to view HTML code for currency symbol
	        </a>   
		</td>
	</tr> 
	<tr>
		<td colspan="2" align="right">
		<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));?>
			&nbsp;&nbsp;
		<?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn',
	        	   'label'=> false, 'div' => false, 'error' => false));?>

		</td>
	</tr>
	</table>
<?php echo $this->Form->end(); ?>

<script>
	$(document).ready(function(){
		// binds form submission and fields to the validation engine
		$("#Currencyfrm").validationEngine();
		$("#view-currency-format").click(function(){
			$.fancybox({
	            'width'    : '90%',
			    'height'   : '90%',
			    'autoScale': true,
			    'transitionIn': 'fade',
			    'transitionOut': 'fade',
			    'type': 'iframe',
			    'href': "<?php echo $this->Html->url(array("action" => "currency_format",'admin'=>false,'superadmin'=>false)); ?>" 
		    });
		});
	}); 
</script>
 