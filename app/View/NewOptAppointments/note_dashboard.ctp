<?php
echo $this->Html->css(array('internal_style','jquery.autocomplete'));
echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','jquery.autocomplete.js','jquery.fancybox-1.3.4.js') );
echo $this->Html->css(array('jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));
?>
<div class="clr"></div>

            <table width="100%" style="padding-top: 10px;">
            <tr><td>Note:</td>
            <td><?php   echo $this->Form->create('OptAppointment',array('type' => 'file','id'=>'notefrm','inputDefaults' => array('label' => false,'div' => false,'error' => false	))); ?>
<?php echo $this->Form->input('OptAppointment.description', array('type'=>'textarea','id' => 'description', 'label'=> false,'div' => false, 'error' => false,'rows'=>'5', 'cols'=>'15','style'=>'width:98%;','value'=>$note_data['OptAppointment']['description'])); ?>
<?php echo $this->Form->hidden('id', array('type'=>'text','id' => 'id', 'label'=> false,'div' => false, 'error' => false,'value'=>$id)); ?></td></tr>
           
           

          
 <tr><td></td><td align="right"> <input class="blueBtn" type="submit" value="Submit" id="submit"  ></td></tr>	
 </table>   
  <?php echo $this->Form->end(); ?>
  <script>
  jQuery(document)
	.ready(
			function() {
	  $('#notefrm').submit(function() {
		  alert('The Ot Appointment has been updated.');
		  parent.$.fancybox.close();
		  parent.location.reload(true); 
		  });
  

  });
 
  
 	


  
  
	
  </script>
  