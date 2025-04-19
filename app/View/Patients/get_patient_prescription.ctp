<?php
 	 echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js', 'jquery.ui.core.js', 'ui.datetimepicker.3.js','permission.js')); 

  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
  ?>
<?php echo $this->Form->create('',array('action'=>'get_patient_prescription','type'=>'get'));?>

<style>
	.inner_title{
	padding-bottom: 0px;
}

</style>

<div class="inner_title" >
	<?php echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy')); ?>
	<h3>Patients List</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'index','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>

<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >
	<tbody>

		<tr class="row_title">

			<td class="row_format"><label><?php echo __('Patient Name') ?> :</label></td>

			<td class="row_format">
		    	<?php
		    		 echo $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>


			<td class="row_format"><label><?php echo __('MRN') ?> :</label></td>
			<td class="row_format">
		    	<?php
		    		 echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>



			<td class="row_format" >
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));
				?>
			</td>

		 </tr>

	</tbody>
</table>
<!--<div style="padding: 10px;">
<?php if($website_service_type['Configuration']['location_id'] == 22 && $website_service_type['Configuration']['location_id'] == 26){ ?>
<?php echo $this->Form->input('', array('type' => 'radio','class'=>'opPatient','id' => 'opPatient','name' => 'opPatient','style'=>'padding:10px;','options' => array('OPD'=>"OPD",'IPD'=>"IPD"),'legend' => false,'label'=> false)); ?>
<?php } ?>
</div>-->


 <?php echo $this->Form->end();?>
<?php
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
<div style="margin:5px">

<table border="0" class="table_format" align="center" cellpadding="0" cellspacing="0" width="95%">
 <tr class="row_title">

   <td class="table_cell"><strong><?php echo  __('MRN', true) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?></th>
   <td class="table_cell"><strong><?php echo __('Patient Name', true); //echo $this->Paginator->sort('is_active', __('Pack', true)); ?></th>

    <td class="table_cell"><strong><?php echo __('Total Amout Due', true);?></td>
	   <td class="table_cell"><strong><?php echo __('Details', true);?></td>
  </tr>
	<?php
	
      $cnt =0;
      if(count($datapost) > 0) {

       foreach($datapost as $note):
		
       $cnt++;
  ?>
  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

    <td class="row_format"><?php echo $note['Patient']['admission_id']; ?> </td>
  <td class="row_format"><?php echo $note['PatientInitial']['name'].''.$note['Patient']['lookup_name']; ?> </td>
	   <td class="row_format"><?php echo $this->Number->currency(ceil($total[$note['Patient']['id']]['id'])); ?> </td>
    <td class="row_format"><?php //debug($note['Patient']['id']);
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Detail', true),'title' => __('View Detail', true))), array('action' => 'get_patient_prescription_details',  $note['Patient']['id'],$note['Note']['id']), array('escape' => false));
  ?> </td>
  </tr>

  <?php

    endforeach;

  ?>

   <tr>
    <TD colspan="10" align="center">
     <!-- Shows the page numbers -->
     <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     <!-- Shows the next and previous links -->
     <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
     <?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
     <!-- prints X of Y, where X is current page and Y is number of pages -->
     <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
  <?php
         } else {
  ?>
  <tr>
   <TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>


 </table>
</div>

     <script>
  $(document).ready(function(){

			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});

			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
	 	});
	 	
$(".opPatient").change(function(){ 
	var type = '';
		if($(this).is(":checked")){
			type = $(this).val();
		}
		
		window.location.href = "<?php echo $this->Html->url(array('action'=>'get_patient_prescription')); ?>"+"/"+type;
	});
  </script>