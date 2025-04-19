<?php 
	echo $this->Html->script(array('jquery.fancybox'));
	echo $this->Html->css(array('jquery.fancybox'));
?>
<style>.row_action img{float:inherit;}
.fancybox-inner{
		min-height: 350px !important;
}
</style>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Bed Allocation', true); ?></h3> 
<span>
	<?php 
		echo $this->Html->link('Back',array('action'=>'ward_occupancy','admin'=>false),array('escape'=>false,'class'=>"blueBtn"));
	?>
</span>
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
 <table cellpadding="0" cellspacing="0" width="32%" style="text-align:center;padding: 1% 0 0 2%;">
	<tr>
		<?php   echo $this->Form->create('',array('url'=>array('action'=>'bed_allocation'),'type'=>'get','id'=>'bedAllocation','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));
		?>
		<td align="left"><?php echo __('Patient Name/Patient ID') ?> :</td>		
			<td align="left">											 
		    	<?php echo $this->Form->input('', array('name'=>'patient_name','id' => 'patient_name', 'label'=> false,'autofocus'=>'autofocus' ,'div' => false,'type'=> 'text', 'error' => false,'autocomplete'=>false,'value'=>''));?> 
		  	</td>
		<td align="left"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
		<td align="left"><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'bed_allocation'),array('escape'=>false));?></td>
		<?php echo $this->Form->end();?>
	</tr>
</table>

<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
   
  </tr>
  <tr class="row_title"> 
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Patient.lookup_name', __('Patient Name', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo 'Patient ID'; ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo 'Visit ID'; ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Ward.name', 'Ward'); ?></strong></td>  
   <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  
  	
  	  $toggle =0;
      if(count($patientData) > 0) {
       foreach($patientData as $patientKey => $patientVal){ 
        if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
  
    <td class="row_format" align="left"><?php echo ucwords(strtolower($patientVal['Patient']['lookup_name'])) ; ?> </td>
    <td class="row_format" align="left"><?php echo $patientVal['Patient']['patient_id']; ?> </td>
    <td class="row_format" align="left"><?php echo $patientVal['Patient']['admission_id']; ?> </td>
    <td class="row_format" align="left"><?php echo $patientVal['Ward']['name']; ?> </td> 
  
  	<td class="row_action" align="left">
		   <?php 
			   echo $this->Html->link('Allot Bed',"#", array('escape' => false,'id'=>'transfer','class'=>'transfer','patient_id'=>$patientVal['Patient']['id'],'allot'=>'allot'));
	  	   ?>
	</td>
  </tr>
  <?php  }  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
  <?php
  
      } else {
  ?>
  <tr>
   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
  
 </table>
 
 
<script>
	$(document).ready(function(){
		 $('.transfer').click(function(){
			    var patient_id = $(this).attr('patient_id') ; 
			    var allot = $(this).attr('allot') ;
				$.fancybox({
		            'width'    : '90%',
				    'height'   : '90%',
				    'autoScale': true,
				    'transitionIn': 'fade',
				    'transitionOut': 'fade',
				    'type': 'iframe',
				    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_transfer")); ?>"+'/'+patient_id+'/'+allot
			    });
				
		  });
		
		$('#patient_name').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'IPD','room_id IS NULL& bed_id IS NULL',"admin" => false,"plugin"=>false)); ?>",
					select: function(event,ui){			
				},
				 messages: {
			         noResults: '',
			         results: function() {},
			   },
			});
	});
</script>
 
 

