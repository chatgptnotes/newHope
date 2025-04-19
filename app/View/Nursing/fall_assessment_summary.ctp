<?php 
	echo $this->Html->script('jquery.fancybox-1.3.4');
	echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>
<script>
$(document).ready(function($) {
	$("a#viewDetail").fancybox({
			'width'				: '80%',
			'height'			: '100%',
			'overlayColor'		: '#C2D8FF',
			'enableEscapeButton': true,
			'autoScale'			: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'escKey'			: false,
			'type'				: 'iframe'
			
		});
});

</script>
<style>
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>

<div class="inner_title">
    <h3><?php echo __('Fall Assessment Summary'); ?></h3>
    <span>
    <?php 
			if(!empty($record)){
				echo $this->Html->link(__('Print'),'#', array('id'=>'print','escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_fall_assessment_summary',$this->params['pass'][0]))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
								
			} 
     echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'patient_information/',$this->params['pass'][0]), array('escape' => false,'class'=>'blueBtn'));?></span>
</div>
   <p class="ht5"></p>
<form name="itemfrm" id="itemfrm" action="<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "fall_assessment_summary/".$this->params['pass'][0])); ?>" method="post" >
	<?php echo $this->element('patient_information');?>   
  <p class="ht5"></p>
   <table width="99%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
		<tr>
			<th width="5%">Date</th>
			<th width="5%">Time</th>
			<th width="5%">Score</th>
			<th width="12%">Risk</th>
			<th width="10%">Intervention</th>
		</tr>
	<?php if(!empty($record)){
			$i = 1;
		foreach($record as $data){	
	?>
		<tr>
		  <td><?php echo $this->DateFormat->formatDate2Local($data['FallAssessment']['date'],Configure::read('date_format'));
					//echo $this->Form->hidden('FallAssessmentSummery_'.$i.'.date', array('type'=>'text','id'=>'date','label'=> false, 'div' => false, 'error' => false,'value'=>$data['FallAssessment']['date']));?>
		   </td>		  
			<td><?php echo $data['FallAssessment']['time'];
					//echo $this->Form->hidden('FallAssessmentSummery_'.$i.'.date', array('type'=>'text','id'=>'date','label'=> false, 'div' => false, 'error' => false,'value'=>$data['FallAssessment']['date']));?>
		   </td>
		  <td><?php echo $data['FallAssessment']['total_score'];		  
					//echo $this->Form->hidden('FallAssessmentSummery_'.$i.'.score', array('type'=>'text','id'=>'date','label'=> false, 'div' => false, 'error' => false,'value'=>$data['FallAssessment']['total_score']));?>
		  </td>                   		  
			<?php if($data['FallAssessment']['risk_level'] == 'Low Risk Level'){?>
			<td align="left">&nbsp;&nbsp;<font color="#FFFFFF" style="font-weight:bold;"><?php echo $data['FallAssessment']['risk_level'];?></font></td>
			<?php } else if($data['FallAssessment']['risk_level'] == 'Midium Risk Level') {?>
			<td align="left">&nbsp;&nbsp;<font color="#FFD63A" style="font-weight:bold;"><?php echo $data['FallAssessment']['risk_level'];?></font></td>
			<?php } else { ?>
			<td align="left">&nbsp;&nbsp;<font color="#F4252D" style="font-weight:bold;"><?php echo $data['FallAssessment']['risk_level'];?></font></td>
			<?php }    			
					//echo $this->Form->hidden('FallAssessmentSummery_'.$i.'.risk_level', array('type'=>'text','id'=>'date','label'=> false, 'div' => false, 'error' => false,'value'=>$data['FallAssessment']['risk_level'])); ?> 
		                  		  
		  <td>
			<?php 
				echo $this->Html->link($this->Html->image('icons/interventions.png',array('style'=>'height:20px;width:18px;','alt'=>'intervention','title'=>'intervention')).' Click Here', array('controller'=>'nursings','action' => 'intervention',$this->params['pass'][0],'risk_level'=>$data['FallAssessment']['risk_level'],'row_id'=>$data['FallAssessment']['id']), array('id'=>'viewDetail','escape' => false));
			?>
		  </td>
		 
		</tr>
		<?php $i++; } ?>
		<?php if($this->params['paging']['FallAssessment']['pageCount'] > 1) {?>
		<tr>
			<td colspan = "4">			
			 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			 <!-- Shows the next and previous links -->
			 <?php echo $this->Paginator->prev(__('� Previous', true), null, null, array('class' => 'paginator_links')); ?>
			 <?php echo $this->Paginator->next(__('Next �', true), null, null, array('class' => 'paginator_links')); ?>
			 <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
			</td>
	   </tr>
  <?php	} ?>
	<?php } else {?>
		<tr>
			<td colspan="8" align="center">No Record Found </td>
		</tr>
	<?php }?>
   </table>

   <div class="ht5">&nbsp;</div>
                   

</form>
	<div class="tdLabel2">
		+ Restraint order is valid only for 24 hours. Must be reviewed daily.<br />
		+ Specific ambulation orders must be given.<br />
		+ Counseling regarding diet and specific family education and training to be given.
   </div>
   <!-- Right Part Template ends here -->
   </td>
</table>
<!-- Left Part Template Ends here -->

</div>  
