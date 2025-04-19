<?php 
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
$getUnserializeData=unserialize($optAppointmentData['OptAppointment']['sterile_processing_checklist']);

?>
<div class="inner_title">
<h3><?php echo __('Sterile Processing Checklist', true); ?></h3>
<span>
	<?php echo $this->Html->link(__('Back'), array('controller'=>'opt_appointments','action' => 'dashboard_index'), array('escape' => false,'class'=>'blueBtn'));?>
	 </span>
</div>
<?php echo $this->Form->create(null,array('url' => array('action'=>'saveSterileProcessingChecklist'),'type'=>'post', 'id'=> 'pcmhreportfrm'));
echo $this->Form->hidden(null,array('name'=>'data[OptAppointments][id]','id'=>'id','value'=>$optAppointmentData['OptAppointment']['id']));
?>	
 <table border="0"   cellpadding="0" cellspacing="0" width="100%" align="left">          
	        <tr>				 
			 <td align="right" width="3%" ><strong><?php echo __('Date') ?>:</strong></td>										
			 <td class="row_format" width="0%">											 
		    <?php //$getUnserializeData['strile_date']=$this->DateFormat->formatDate2Local($getUnserializeData['strile_date'],Configure::read('date_format')); 
		      echo $this->Form->input('strile_date', array('class' => 'textBoxExpnd ', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false,'value'=>$getUnserializeData['strile_date']));
            ?>
		  	</td>
		  	 <td align="right" width="0%"><strong><?php echo __('Audit Conducted by:') ?>:</strong></td>										
			 <td class="row_format" width="77%">											 
		    <?php 
		      echo $this->Form->input('audit_conducted_by', array('value'=>$getUnserializeData['audit_conducted_by'],'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
            ?>
		  	</td>
		    </tr>
		   
</table>
 
   <div class="inner_title">
<h3><?php echo __('Sterilization Standards Audit Checklist', true); ?></h3>
</div>
  
    
 
    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th style="text-align:center;"><?php echo __('Facility design', true); ?></th>
           <th style="text-align:center; width:8%"> <?php echo __('Yes/No', true); ?></th>      
          </tr>
	     
		 
		  <tr>
		    <td>1. Are functional work areas physically separated by walls or partitions? </td>
		    <td align="center"><?php echo $this->Form->radio('radio_1_1',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>2. Are doors and pass-through windows kept closed when not in use?</td>
			<td align="center"><?php echo $this->Form->radio('radio_1_2',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_2'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td>3. Are floors level and constructed of materials that will withstand daily or more frequent cleaning?</td>
			<td align="center"><?php echo $this->Form->radio('radio_1_3',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_3'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
			<tr>
			    <td>4. Are ceilings and wall surfaces constructed of nonshedding materials to limit condensation and dust accumulation?</td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_4',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_4'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			    <td>5. Are temperature and humidity levels monitored and recorded daily?</td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_5',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_5'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			    <td>6. Are the temperature and humidity levels within the acceptable ranges?<br/>
			    <b>T = 68-73 F Clean areas 60-65 F decontamination H= 30-60% in work areas Not over 70% in sterile storage areas</b></td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_6',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_6'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			    <td>7. Are appropriate devices used to maintain temperature and humidity levels?</td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_7',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_7'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			    <td>8. Are areas cleaned daily and kept free of shipping boxes?</td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_8',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_8'],'legend'=>false,'label'=>false));?></td>
			</tr>
		  
		  <tr>
			    <td><div style="padding-left:20px;"><li> separate cleaning equipment for decontamination</li></div></td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_9',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_9'],'legend'=>false,'label'=>false));?></td>
			</tr>
			<tr>
			    <td>9. Are processing areas kept free of food or drink?</td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_10',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_10'],'legend'=>false,'label'=>false));?></td>
			</tr>
			<tr>
			    <td>10. Eyewash stations located within 10 seconds travel time?</td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_11',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_11'],'legend'=>false,'label'=>false));?></td>
			</tr>
			<tr>
			    <td>11. Equipment maintenance records maintained?</td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_12',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_12'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			    <td>12. Functional workflow pattern - Dirty to clean?</td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_13',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_13'],'legend'=>false,'label'=>false));?></td>
			</tr>
			<tr>
			    <td>13. Ventilation - Soiled area, negative - 10 air exchanges per hour? <br/>
					Clean/sterile area, positive - 10 air exchanges per hour</td>
			 	<td align="center"><?php echo $this->Form->radio('radio_1_14',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_1_14'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			 <th style="text-align:center;"><?php echo __('Decontamination', true); ?></th>
           <th style="text-align:center; width:8%"> <?php echo __('Yes/No', true); ?></th>
           </tr>
		  
		 
		  <tr>
		    <td>1. Appropriate decontam PPE available? Hands washed after removing PPE?</td>
		  <td align="center"><?php echo $this->Form->radio('radio_2_1',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>Hands washed after removing PPE?</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_2',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_2'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td>2. Manufacturers recommendations available and followed</td>
		  <td align="center"><?php echo $this->Form->radio('radio_2_3',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_3'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		 
		  <tr>
		    <td><div style="padding-left:20px;"><li>Equipment</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_4',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_4'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:20px;"><li>Instruments</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_5',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_5'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:20px;"><li>Cleaning solutions</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_6',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_6'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
		    <td>3. Appropriate cleaning and decontamination solutions? </td>
		  <td align="center"><?php echo $this->Form->radio('radio_2_7',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_7'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		 
		 <tr>
		    <td><div style="padding-left:20px;"><li>Dilution - measuring cups and lines in the sink for accurate measuring</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_8',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_8'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:20px;"><li>Expiration dates</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_9',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_9'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>Solution containers labeled</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_10',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_10'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
		    <td>4. Appropriate cleaning processes used? </td>
		  <td align="center"><?php echo $this->Form->radio('radio_2_11',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_11'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		 
		 <tr>
		    <td><div style="padding-left:20px;"><li>Sharps and delicates separate</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_12',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_12'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
		    <td><div style="padding-left:20px;"><li>No use of saline on instruments</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_13',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_13'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
		    <td><div style="padding-left:20px;"><li>Cleaning happens as soon as possible</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_14',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_14'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
		    <td><div style="padding-left:20px;"><li>Instruments kept moist until cleaned</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_15',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_15'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
		    <td><div style="padding-left:20px;"><li>Not cleaned in hand sinks or scrub sinks</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_16',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_16'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		  <tr>
		    <td><div style="padding-left:20px;"><li>Brushing occurs under water</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_17',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_17'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>Brushes are disposable or decontaminated daily</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_2_18',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_2_18'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 
		  <tr>
           <th style="text-align:center;"><?php echo __('Personnel training', true); ?></th>
           <th style="text-align:center; width:8%"> <?php echo __('Yes/No', true); ?></th>      
          </tr>
		 
		 <tr>
		    <td>1. Are processing areas restricted to authorized personnel only? </td>
		  <td align="center"><?php echo $this->Form->radio('radio_3_1',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_3_1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>2. Are hand washing facilities conveniently located? </td>
		  <td align="center"><?php echo $this->Form->radio('radio_3_2',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_3_2'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>3. Are personnel using and removing personnel protective equipment properly? </td>
		  <td align="center"><?php echo $this->Form->radio('radio_3_3',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_3_3'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>4. Are personnel consistently adhering to dress code: </td>
		  <td align="center"><?php echo $this->Form->radio('radio_3_4',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_3_4'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		   <tr>
		    <td><div style="padding-left:20px;"><li>all jewelry is removed?</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_3_5',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_3_5'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>hair covers are worn consistently and no hair is visible?</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_3_6',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_3_6'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>facility scrub attire is donned upon arrival at the facility and is not worn out of the facility?</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_3_7',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_3_7'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 		  
		  <tr>
		    <td>5. Are personnel provided with necessary education regarding sterilization policies and procedures?</td>
		  <td align="center"><?php echo $this->Form->radio('radio_3_8',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_3_8'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>6. Is this education documented? </td>
		  <td align="center"><?php echo $this->Form->radio('radio_3_9',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_3_9'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		 
		  
		  
		   <tr>
           <th style="text-align:center;"><?php echo __('Packaging', true); ?></th>
           <th style="text-align:center; width:8%"> <?php echo __('Yes/No', true); ?></th>      
          </tr>
          
          <tr>
		    <td>1. Labeling on indicator tape, patient record cards or plastic side of peel packs? </td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_1',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>2. Instrument set weights not over 25 pounds? </td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_2',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_2'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>3. Peel packs - double peel packs are not folded, proper size used?</td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_3',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_3'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>4. Internal and external chemical indicators (CI) used for all packages?  </td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_4',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_4'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		   <tr>
		    <td><div style="padding-left:20px;"><li>Geometric center of wrapped packages</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_4_5',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_5'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>Two opposite corners in rigid containers</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_4_6',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_6'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> On all levels</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_4_7',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_7'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  
           <tr>
		    <td>5. Instruments in good condition</td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_8',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_8'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td>6. Instrument refurbishing plan </td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_9',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_9'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td>7. Instrument tape (if used) is in good condition</td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_10',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_10'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td>8. Tip protectors validated for use?
			</td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_11',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_11'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td>9. Any single use devices reprocessed (need to be FDA cleared)</td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_12',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_12'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td>10. Instrument tracking system available?</td>
		  <td align="center"><?php echo $this->Form->radio('radio_4_13',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_4_13'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  
          
           <tr>
           <th style="text-align:center;"><?php echo __('Sterilization', true); ?></th>
           <th style="text-align:center; width:8%"> <?php echo __('Yes/No', true); ?></th>      
          </tr>
          
          <tr>
		    <td>1. Loading and unloading practices</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_1',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		   <tr>
		    <td><div style="padding-left:20px;"><li> Peel packs lighter items on top shelf</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_2',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_2'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  
		   <tr>
		    <td><div style="padding-left:20px;"><li> Peel packs and linen packs are on edge (not horizontal)</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_3',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_3'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> No stacking of pans (without manufacturers recommendations)</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_4',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_4'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		  <tr>
		    <td>2. Documentation of each load</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_5',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_5'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		   <tr>
		    <td><div style="padding-left:20px;"><li> Sterilizer identification</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_6',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_6'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Type of sterilizer and cycle used</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_7',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_7'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>Lot control number</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_8',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_8'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Load contents</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_9',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_9'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Critical parameters for specific sterilization method</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_10',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_10'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Operators name, and</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_11',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_11'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Results of the sterilization process monitors (physical, CI, BI)</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_12',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_12'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  
		  <tr>
		    <td>3. Sterilization monitors</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_13',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_13'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		   <tr>
		    <td><div style="padding-left:20px;"><li> BI - run daily in steam and peracetic acid</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_14',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_14'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> BI- run in every load for ethylene oxide, gas plasma or ozone</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_15',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_15'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> The same lot number is used for the contorl and the processed BI</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_16',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_16'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		  
		  
		  <tr>
		    <td>4. Sterilization records storage follows the facilities record retention policy</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_17',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_17'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>5. Manufacturer recommendations readily available and followed</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_18',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_18'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>6. Extended cycles run per manufacturers recommendations</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_19',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_19'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>7. Implants</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_20',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_20'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> monitored with BI and a Class 5 CI</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_21',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_21'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:20px;"><li> Not released until results of BI available</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_22',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_22'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  
		  <tr>
		    <td>8. Management of loaner instrumentation in place</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_23',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_23'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>9. All sterilized items are traceable to the patient</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_24',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_24'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>10. recall process in place and reported to Infection Prevention</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_25',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_25'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>11. Flash sterilization practices</td>
		  <td align="center"><?php echo $this->Form->radio('radio_5_26',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_26'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		 <tr>
		    <td><div style="padding-left:20px;"><li>items are appropriately cleaned</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_27',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_27'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:20px;"><li> Use of closed flash containers</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_28',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_28'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:20px;"><li> All parameters documented</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_29',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_29'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:20px;"><li> Aseptic transportation to point of use</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_30',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_30'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:20px;"><li> Implants</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_31',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_31'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:40px;"><li> BI & CI run with all implants</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_32',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_32'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 <tr>
		    <td><div style="padding-left:40px;"><li> Not released until results of BI available</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_33',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_33'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Traceable to patient</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_34',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_34'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Not used as substitute for sufficient instrument inventory</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_5_35',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_5_35'],'legend'=>false,'label'=>false));?></td>
		 </tr>
	
          
           <tr>
           <th style="text-align:center;"><?php echo __('Sterile storage', true); ?></th>
           <th style="text-align:center; width:8%"> <?php echo __('Yes/No', true); ?></th>      
          </tr>
            <tr>
		    <td>1. Storage conditions</td>
		  <td align="center"><?php echo $this->Form->radio('radio_6_1',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td><div style="padding-left:20px;"><li> Cleanable surfaces</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_6_2',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_2'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Bottom shelves are solid</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_6_3',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_3'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  
		    <tr>
		    <td>2. All items are</td>
		  <td align="center"><?php echo $this->Form->radio('radio_6_4',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_4'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td><div style="padding-left:20px;"><li> 18" below the ceiling (or level of sprinkler head)</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_6_5',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_5'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> 8 - 10" above the floor</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_6_6',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_6'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> 2" from outside walls</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_6_7',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_7'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		  
		    <tr>
		    <td>3. Sterile Items separate from clean items</td>
		  <td align="center"><?php echo $this->Form->radio('radio_6_8',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_8'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		    <tr>
		    <td>4. Heavy wrapped trays are not stacked</td>
		  <td align="center"><?php echo $this->Form->radio('radio_6_9',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_9'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		    <tr>
		    <td>5. Shelf life/event related - stock rotation</td>
		  <td align="center"><?php echo $this->Form->radio('radio_6_10',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_10'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		    <tr>
		    <td>6. Controlled area (appropriately attired persons only</td>
		  <td align="center"><?php echo $this->Form->radio('radio_6_11',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_11'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		    <tr>
		    <td>7. Handwashing facilities readily available</td>
		  <td align="center"><?php echo $this->Form->radio('radio_6_12',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_12'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		    <tr>
		    <td>8. No web-edged or corrugated cardboard boxes</td>
		  <td align="center"><?php echo $this->Form->radio('radio_6_13',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_6_13'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
           <tr>
           <th style="text-align:center;"><?php echo __('Policies and Procedures', true); ?></th>
           <th style="text-align:center; width:8%"> <?php echo __('Yes/No', true); ?></th>      
          </tr>
		  
		   <tr>
		    <td>1. Current according to best practices</td>
		  <td align="center"><?php echo $this->Form->radio('radio_7_1',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		   <tr>
		    <td><div style="padding-left:20px;"><li>Dress code</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_2',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_2'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> care and handling of instruments</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_3',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_3'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Packaging systems - selection and use</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_4',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_4'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>Sterilization recall</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_5',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_5'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Sterilizer identification</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_6',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_6'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Sterile storage</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_7',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_7'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Chemical disinfectant (including high-level disinfecting)</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_8',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_8'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>Shelf life (event related)</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_9',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_9'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> PM for equipment</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_10',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_10'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Steam shutdown</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_11',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_11'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Sterilization - steam and low temp</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_12',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_12'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Endoscopes - cleaning and processing</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_13',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_13'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li>Environmental cleaning</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_14',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_14'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Creutzfeld - Jakob disease (CJD)</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_15',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_15'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td><div style="padding-left:20px;"><li> Single use devices</li></div></td>
		 	<td align="center"><?php echo $this->Form->radio('radio_7_16',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_16'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		  <tr>
		    <td>2. Available to staff</td>
		  <td align="center"><?php echo $this->Form->radio('radio_7_17',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_17'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td>3. Followed and monitored</td>
		  <td align="center"><?php echo $this->Form->radio('radio_7_18',array('Yes'=>'Yes','No'=>'No'),array('value'=>$getUnserializeData['radio_7_18'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td colspan="2">
		    <table width="100%" cellpadding="0" cellspacing="1" border="0">
		    <tr>
		    <td>
		    <strong>Comments: </strong></td>
		  <td align="center"><?php echo $this->Form->textarea('comment',array('value'=>$getUnserializeData['comment'],'style'=>'width:932px','rows'=>'2','legend'=>false,'label'=>false));?></td>
		  </tr>
		  </table>
		  </td>
		  </tr>
		 
		  		
			
	</table>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
		<tr>
		<td align="right"><?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?></td>
		</tr>
	</table>
<br />
<?php echo $this->Form->end();?>
 <script>
	$(function() {
		$("#startdate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'mm/dd/yy',			
		});	

	});
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#automatedmeasurecalfrm").validationEngine();
		
 });
 
</script>