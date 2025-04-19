

<table width="100%">
	<tr>
	<?php if(!empty($data)){ ?>
		<td style="color:#31859c;"><b><?php echo __('Allergies :')?></b></td> 
	

	
			<?php foreach($data as $key=>$newData){?>
			<td> 
					<?php if($key<count($data)-1){
							echo $newData['NewCropAllergies']['name'].',  ';
						 }else{
							echo $newData['NewCropAllergies']['name'].'.';
						 }?>
					
		 	</td>
	      <?php  }?>
	      	<?php }?>
	      <td>
	      <?php if($year >=0 && $year<3)
		{ ?>
		<span><?php 
			if(strToLower($patient['Person']['sex'])=='female'){
				echo $this->Html->link(__('Length for Age'),'#',array('id'=>'lengthForAgeFemale','escape' => false,'class'=>'blueBtn'));
			}else{
				echo $this->Html->link(__('Length for Age Chart'),'#',array('id'=>'lengthForAgeMale','escape' => false,'class'=>'blueBtn'));
	   		}
	   		?> </span> <span><?php
	   		if(strToLower($patient['Person']['sex'])=='female'){
	   			echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiInfantsWeightForAge','escape' => false,'class'=>'blueBtn'));
	   		}else {
				echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiInfantsWeightForageMale','escape' => false,'class'=>'blueBtn'));
   			}
   			?> </span> <span><?php
   			if(strToLower($patient['Person']['sex'])=='female'){
   				echo $this->Html->link(__('Weight for Length'),'#',array('id'=>'bmiInfantsWeightForLengthFemale','escape' => false,'class'=>'blueBtn'));
   			} else {
				echo $this->Html->link(__('Weight for Length'),'#',array('id'=>'bmiInfantsWeightForLengthMale','escape' => false,'class'=>'blueBtn'));
   			}?> </span>
		<?php	}
			else if($year >=2 && $year<=20){?>
				<span><?php	if(strToLower($patient['Patient']['sex'])=='female')
					{
						echo $this->Html->link(__('BMI Chart'),'#',array('id'=>'bmiChartFemale','escape' => false,'class'=>'blueBtn'));
					}else{
						echo $this->Html->link(__('BMI Chart'),'#',array('id'=>'bmiChartMale','escape' => false,'class'=>'blueBtn'));
					}?></span>
					<span><?php if(strToLower($patient['Patient']['sex'])=='female')
					{
						echo $this->Html->link(__('Stature for Age'),'#',array('id'=>'bmiStatureforageFemale','escape' => false,'class'=>'blueBtn'));
					}
					else{
						echo $this->Html->link(__('Stature for Age'),'#',array('id'=>'bmiStatureforageMale','escape' => false,'class'=>'blueBtn'));
					}?></span>
					<span><?php if(strToLower($patient['Patient']['sex'])=='female')
					{
						echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiWeightforageFemale','escape' => false,'class'=>'blueBtn'));
					}else {
						echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiWeightforageMale','escape' => false,'class'=>'blueBtn'));
					}?>	</span>
						
				<?php }?>
	      </td>
	      

	</tr>
	
</table>


<script>
$('#bmiChartFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_chart_female',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiChartMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_chart_male',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiStatureforageFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_statureforage_female',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiStatureforageMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_statureforage_male',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiWeightforageFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_weightforage_female',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiWeightforageMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_weightforage_female',$patient['Patient']['person_id'])); ?>",
	});
});
$('#lengthForAgeFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Person", "action" => "bmi_infants_lenghtforage_female",$patient['Patient']['person_id'])); ?>",
	});
});	 
$('#lengthForAgeMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_lengthforage_male",$patient['Patient']['person_id'])); ?>",
	});
});	 
$('#bmiInfantsWeightForAge').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_weightforage",$patient['Patient']['person_id'])); ?>",
	});
});	
$('#bmiInfantsWeightForageMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_weightforage_male",$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiInfantsWeightForLengthFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_weightforlength_female",$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiInfantsWeightForLengthMale').click(function(){
	$.fancybox({
	
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_weightforlength_male",$patient['Patient']['person_id'])); ?>",
	});
});
</script>