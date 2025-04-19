<?php 	  
	
	 echo $this->Html->css(array('internal_style.css'));  
	  
	
  	 
  	 
?>
 <body onload="javascript:submit_form();">   
<div class="inner_title">
 <h3>
 <?php echo __('Current Medication');?>
 
 
<?php if(!empty($noteId))
	echo $this->Html->link(__('Back', true),array('controller' => 'notes', 'action' =>'soapNote',$id,$noteId), array('style'=>"margin-left:1200px",'escape' => false,'class'=>'blueBtn'));
else 
	echo $this->Html->link(__('Back', true),array('controller' => 'notes', 'action' =>'soapNote',$id), array('style'=>"margin-left:1200px",'escape' => false,'class'=>'blueBtn'));
 ?>
 
 </h3>
</div>
	<?php 
			echo $this->Form->create('Patient', array('id'=>'UserRxForm','type' => 'post','url' => Configure::read('hitUrl'),'target'=>'aframe'));?>
		 	
		  

	
	<!-- BOF new HTML -->	 
	 	 	 
			 <table width="100%" align="center">
			 <tr>
				<td align="center"><div
						style="text-align: center; margin: 15px 0px 0px 5px; display: none;"
						class="loader">
						<?php echo $this->Html->image('indicator.gif'); ?>
					</div></td>
			</tr>
			 <tr>
				<td colspan="8" style="display: none"><textarea id="RxInput"
						name="RxInput" rows="33" cols="79" align="center">
						<?php echo $patient_xml?>
					</textarea></td>
			</tr>
			<tr><td align="center"><iframe name="aframe" id="aframe" frameborder="0" onload="load();"></iframe></td></tr>
			   
			  </table>	  
		 
		
	<!-- EOF new HTML -->
<?php echo $this->Form->end(); ?>

<script>
			function load() 
		    {
		         document.getElementById("aframe").style.height = "900px";
		         document.getElementById("aframe").style.width = "1200px";
		         jQuery(".loader").hide();
	        }
			function submit_form()
			{
				
				jQuery(".loader").show();
			  document.getElementById("aframe").style.height = "0px";
			  document.getElementById("aframe").style.width = "0px";
			  document.getElementById('UserRxForm').submit();
			}


</script>