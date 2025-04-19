<style>
.table_format label{width:135px;text-align:left;}</style><div class="inner_title">
 <h3><?php echo __('Preference Card'); ?></h3>
<span> <?php echo $this->Html->link("Back",array('action'=>'rad_preferencecard',$patient_id),array('escape'=>false,'class'=>'blueBtn')); ?></span>
</div>

<?php echo $this->element('patient_information');  ?>
<p class="ht5"></p>  

	<!-- BOF new HTML -->	 
	 	 	 
			 <table class="table_format"  id="schedule_form">	
			 <tr >
			    <td><label><?php echo __('Preference Card Title');?>:</label></td>
			    <td>
			    	 
			    	<?php  
			    		echo $getData['PreferencecardRad']['card_title'];
			    	?>
			     	
			    </td>
			   </tr>			    			    
			   <tr>
			    <td><label><?php echo __('Procedure Name');?>:</label></td>
			    <td>
			    	 
			    	<?php  
			    		echo $getData['Surgery']['name'];
			    	?>
			     	
			    </td>
			   </tr>				   
			   <tr>
			    <td><label><?php echo __('Primary Care Provider');?>:</label></td>
			    <td>
			    	<?php
			    		echo $getData['User']['first_name'].' '.$getData['User']['last_name'];
			    	?>
			     	
			    </td>
			   </tr>
			    <tr>
			    <td><label><?php echo __('Equipment Name');?>:</label></td>
			    <td>
			    	<?php
			    	echo $getData['PreferencecardRad']['equipment_name'];
			    	?>
			     	
			    </td>
			   </tr>
                           <tr>
			    <td><label><?php echo __('Medication');?>:</label></td>
			    <td>
			    	<?php
			            echo $getData['PreferencecardRad']['medications'];
			    	?>
			     	
			    </td>
			   </tr>
			    <tr>
			    <td><label><?php echo __('Dressing');?>:</label></td>
			    <td>
			    	<?php
			            echo $getData['PreferencecardRad']['dressing'];
			    	?>
			     	
			    </td>
			   </tr>
			   
			    <tr>
			    <td><label><?php echo __('Prep and Position');?>:</label></td>
			    <td>
			    	<?php
			            echo $getData['PreferencecardRad']['position'];
			    	?>
			     	
			    </td>
			   </tr>
			   <tr>
			    <td><label><?php echo __('Notes');?>:</label></td>
			    <td>
			    	<?php
			            echo $getData['PreferencecardRad']['position'];
			    	?>
			     	
			    </td>
			   </tr>
			  </table>	