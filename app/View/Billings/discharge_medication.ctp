<?php 
 
	 echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
     	 			'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
	 echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css'));
	 echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css','internal_style.css'));  
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4','jquery.ui.widget.js'));  
	 echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js','ui.datetimepicker.3.js'));
  	 echo $this->Html->css('jquery.autocomplete.css'); 
  	 
  	 
?>
 <body onload="javascript:submit_form();">   
<div class="inner_title">
 <h3>
 <?php echo __('Discharge Medication'); ?>
 </h3>
</div>
	<?php 
			echo $this->Form->create('User', array('type' => 'post','url' => 'https://secure.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
		 	
		  

	
	<!-- BOF new HTML -->	 
	 	 	 
			 <table class="table_format"  id="schedule_form">
			 <tr>
				<td align="center"><div
						style="text-align: center; margin: 15px 0px 0px 5px; display: none;"
						class="loader">
						<?php echo $this->Html->image('indicator.gif'); ?>
					</div></td>
			</tr>
			 <tr>
				<td colspan="8" style="display: none"><textarea id="RxInput"
						name="RxInput" rows="33" cols="79">
						<?php echo $patient_xml?>
					</textarea></td>
			</tr>
			<tr><td><iframe name="aframe" id="aframe" frameborder="0" onload="load();"></iframe></td></tr>
			   
			  </table>	  
		 
		
	<!-- EOF new HTML -->
<?php echo $this->Form->end(); ?>

<script>
			function load() 
		    {
		         document.getElementById("aframe").style.height = "780px";
		         document.getElementById("aframe").style.width = "980px";
		         jQuery(".loader").hide();
	        }
			function submit_form()
			{
				
				jQuery(".loader").show();
			  document.getElementById("aframe").style.height = "0px";
			  document.getElementById("aframe").style.width = "0px";
			  document.getElementById('UserDischargeMedicationForm').submit();
			}


</script>