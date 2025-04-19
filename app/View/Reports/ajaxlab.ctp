   <br>
   <table border="0" class="table_format_body" cellpadding="0"
				cellspacing="0" width="100%" id="content">
      <tr class="row_title">
  <td class="table_cell"><strong><?php echo __('First Name', true); ?></td>    
    <td class="table_cell"><strong><?php echo __('Last Name', true); ?></td>
      <td class="table_cell"><strong><?php echo __('Date of birth', true); ?></td>  
     <td class="table_cell"><strong><?php echo __('Age', true); ?></td>    
    <td class="table_cell"><strong><?php echo __('Gender', true); ?></td>   
      </tr>
  <?php 
   $toggle =0;
      if(count($data) > 0) {
       foreach($data as $personval): 
    
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
  
 <td class="row_format"><?php echo$this->Html->link($personval['Person']['first_name'],array('controller'=>'PatientsTrackReports','action'=>'sbar',$personval['Patient']['id']),array('esacape'=>false)); ?> </td>
    <td class="row_format"><?php echo $personval['Person']['last_name']; ?> </td>
      <td class="row_format" width="20%"><?php echo $this->DateFormat->formatDate2Local($personval['Person']['dob'],Configure::read('date_format')); ?></td>
    <td class="row_format"><?php $personval['Person']['age']; ?> </td>
  <td class="row_format"><?php echo ucFirst($personval['Person']['sex']); ?> </td>
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
)); ?>
    <!-- Shows the page numbers -->
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php echo $this->Paginator->counter(); echo $this->Js->writeBuffer();?></span>
    </TD>
   </tr>
  <?php  } else {?>
  <tr>
   <TD colspan="2" align="center"><?php echo __('No record found.', true); ?></TD>
  </tr>
  <?php }  ?>
</table>