  <?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));      
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js',
									'jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.fancybox-1.3.4','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js'));?>
 
   <br>
   <table border="0" class="table_format_body" cellpadding="0"
				cellspacing="0" width="100%" id="content">
       
                <tr class="row_title">
    <td class="table_cell"><strong><?php echo __(' Name', true); ?></th>    
    <td class="table_cell"><strong><?php echo __('Loinc Code', true); ?></th>
      </tr>
  <?php 
   $toggle =0;
      if(count($data) > 0) {
       foreach($data as $orderresult): 
    
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
   <td class="row_format"><?php //echo$this->Html->link($orderresult['OrdersetMaster']['COMPONENT'],array('controller'=>'Patients','action'=>'orders',$patient_id),array('esacape'=>false)); ?>
   <?php  echo $this->Html->link(__($orderresult['OrdersetMaster']['name']),'#',
   		array('onclick'=>'ordersentences("'.$patient_id.'","'.$orderresult['OrdersetMaster']['name'].'","'.$orderresult['OrdersetMaster']['id'].'")','class'=>'','div'=>false,'label'=>false));
			 ?>
			</td>
   <td class="row_format"><?php echo $orderresult['OrdersetMaster']['id']; ?> </td>
   </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="2" align="center">
    <?php
    $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
));
 ?>
    <!-- Shows the page numbers -->
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php echo $this->Paginator->counter(); echo $this->Js->writeBuffer();?></span>
    </TD>
   </tr>
   <tr>
   <td align="right" style="padding-right:10px;padding-top:50px"><input class="blueBtn" type="button" value="Done" id="submit1">
   </tr>
  <?php
  
      } else {
  ?>
  <tr>
   <TD colspan="2" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
      
        
  ?>
</table>

<script>
function ordersentences(patient_id,name,master_id) { 
	parent.$.fancybox.close();

	window.top.location.href = '<?php echo $this->Html->url("/patients/multipleorderindex"); ?>'+"/"+patient_id+"/"+master_id;

}

			</script>