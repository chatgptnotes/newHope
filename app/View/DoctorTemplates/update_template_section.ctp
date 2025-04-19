<?php //debug($data);?>
<div class="tabs"><!-- Navigation header -->

	<ul class="tab-links">
		<?php 
			$mainGroup = Configure::read('lab_histo_template_sub_groups');
			$subGroup = Configure::read('histopathology_data_drm');
			$mainSubGroupMapping = Configure::read('lab_histo_template_sub_groups_mapping');
			$mainSubGroup = $mainSubGroupMapping[$groupId];
			$count = 1;
			foreach($mainSubGroup as $key=>$value){
				$valueKeyRes = $value; 
				$value = $subGroup[$value];
			if ($count == 1) {
				$class = "active";
			} else {
				$class = "";
			}
			$count++;
				?>
			<li class="<?php echo $class; ?> tabingClassByTabLI" id="<?php echo $valueKeyRes?>">
				<a class="tabingClassByTab" href="#tab<?php echo $valueKeyRes;?>" count="<?php echo $count?>"> 
						<?php echo $value;?>
				</a>
			</li>	  
		<?php }?>
	</ul>

 

<!-- Navigation header End -->
 <?php 
 
 ?>
 <div class="tab-content">
		<?php
	 	$count = 1;
	 	$i=0;
	 	
		foreach($mainSubGroup as $key=>$value){
			$valueKeyRes = $value;
			$value = $subGroup[$value];
			$resKey = array_search($valueKeyRes, $result);
			$text = $data['DoctorTemplateText'][$resKey]['template_text'];
			$id = $data['DoctorTemplateText'][$resKey]['id'];
			if ($count == 1) {
				$class = "active";
				echo $this->Form->hidden ('hiddenValueForFirst', array('id'=>'hiddenValueForFirst','value'=>$valueKeyRes,'label'=>false,'div'=>false));
			} else {
				$class = "";
			}
			$count++;
		?>
		 <div id="tab<?php echo $valueKeyRes;?>" class="openInput tab <?php echo $class; ?>">
		 
		<?php
		echo $this->Form->hidden('id',array('type'=>'text','label'=>false,
				'name'=>"data[DoctorTemplateText][$i][id]",
				'value'=> $id,
		));

		echo $this->Form->hidden('section_id',array('type'=>'text','label'=>false,
							'name'=>"data[DoctorTemplateText][$i][section_id]",
							'value'=> $valueKeyRes,
							 ));
		
		echo $this->Form->input ('template_text', array ('type'=>'textarea','label'=>false,
							'name' => "data[DoctorTemplateText][$i][template_text]",
							'class' => 'loadedSection',
							'value'=>$text,
		                    'id'=>'ckEditor_histo_'.$valueKeyRes
							) ); 
		
		?>
		</div>
		 <?php $count = $count+1; $i++; } ?>
		</div>
		

 </div>
