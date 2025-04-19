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
    <td class="row_format" width="20%"><?php echo $this->DateFormat->formatDate2LocalForReport($personval['Person']['dob'],Configure::read('date_format')); ?></td>
     <td class="row_format"><?php echo $this->General->getCurrentAge($personval['Person']['dob']);
     //$personval['Person']['age']; ?> </td>
       <td class="row_format"><?php echo ucFirst($personval['Person']['sex']); ?> </td>
   </tr>
  <?php endforeach;  
  $queryStr = $this->General->removePaginatorSortArg($this->data) ; //for sort column
  $this->Paginator->options(array('url' =>array("?"=>$queryStr['Person'])));?>
   <tr style="text-align: center;">
			<td colspan="20">
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#Communications',    												
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    		 	'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
		    		 	<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span>
				<?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#Communications',    												
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    		 	'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				
			</td>
		</tr>
   
   <?php echo	$this->Paginator->options(array(
		    'update' => '#Communications',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));

		echo $this->Js->writeBuffer();
		?>
  <?php } else {?>
  <tr>
   <TD colspan="2" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php }  
  ?>
</table>