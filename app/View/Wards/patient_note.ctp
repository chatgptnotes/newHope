<script type="text/javascript" src="/js/jquery-1.5.1.min"></script>
<?php
 echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
     	 			'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
	 echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
	 echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Add Note', true); ?></h3>
</div>
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
 
    <p class="ht5"></p>
    <table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
		 <tr>
		  <td colspan="2" align="left">
		   <?php 
		     	echo $this->element('patient_information');
				
		   ?>
		  </td>
		 </tr> 
	</table>
	<?php 
		echo $this->Form->create('Note',array('url'=>array('controller'=>'wards','action'=>'patient_note',$patient_id),'id'=>'ward','inputDefaults'=>array(
												'div'=>false,'error'=>false,'style'=>'margin-left:20px;')));
	?>
	 <table border="0" cellpadding="0" cellspacing="0" width="80%"  align="center">
		 <tr>
		 		<td valign="top">
		 			Note :
		 		</td>
			 	<td valign="top">
			 		<?php 
						echo $this->Form->textarea('note',array('id'=>'note','rows'=>10,'cols'=>20,'style'=>'width:400px;'));
						
					?>
			 	</td>
			 	<td valign="top">
			 		<?php echo $this->Form->submit('Submit',array('class'=>'blueBtn'));?>
			 	</td>
			 </tr>
	</table>
	 <p class="ht5"></p>
	  <p class="ht5"></p>
	  
	<?php 
		echo $this->Form->hidden('patient_id',array('value'=>$patient_id)) ;
		echo $this->Form->hidden('id',array('value'=>$this->data['Note']['id'])) ;
		echo $this->Form->end();
	?>