<div class="inner_title">
		<div style="float:left">   
			 <h3>
			 		<?php echo __('Notes'); ?> 	
			 </h3>
		 </div>
		<div style="text-align:right;">&nbsp;
		 	<?php
		 		//  if(empty($datapost['Note']['id'])) { 
		 	 	//echo $this->Js->link(__('Add Note'), array('controller'=>'patients','action' => 'notesadd', $patientid), array('escape' => false,'update'=>'#list_content','method'=>'post','class'=>'blueBtn','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    										//		'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
    												
    		//}
    		echo $this->Js->writeBuffer();
		 	 ?>
		 </div>
</div>
<div class="patient_info" id="addNote">
  <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
   
   <tr class="row_title">
   <td class="table_cell"><strong><?php echo __('S/B Consultant', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('S/B Registrar', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Note Type', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Created Time', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
  
      if(!empty($datapost)) {
      
  	  $toggle =0;
       $i=0 ;
      		foreach($datapost as $data){
       				 
			       if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }
						  ?>
				   <td class="row_format"><?php echo $data[0]['doctor_name']; ?></td>
				   <td class="row_format"><?php echo $data[0]['registrar']; ?></td>
				   <td class="row_format"><?php echo ucfirst($data['Note']['note_type']); ?> </td>
				   <td class="row_format"> <?php $splitDate = explode(' ',$data['Note']['note_date']);
											echo $this->DateFormat->formatDate2Local($data['Note']['note_date'],Configure::read('date_format'),true);?>
				   
				   <td>
				   <?php  
				        echo $this->Js->link($this->Html->image('icons/view-icon.png', array('title' => 'View Note', 'alt'=> 'Note View')), array('action' => 'notes_view', $data['Note']['id'],$patientid), array('update' => '#list_content','method'=>'post' ,'escape'=>false,'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
				    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
				      //  echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title' => 'Edit Note', 'alt'=> 'View')), array('action' => 'notesadd',$patientid,$data['Note']['id']), array('update' => '#list_content','method'=>'post','escape'=>false));
				      
				   ?>
				  </td>
  				  </tr>
			<?php		$i++ ; }     ?>
					    <tr>
					    <TD colspan="8" align="center">
					    <!-- Shows the page numbers -->
					 
					 <!-- Shows the next and previous links -->
					 <?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#list_content',    												
    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
					 <?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#list_content',    												
    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
					 <!-- prints X of Y, where X is current page and Y is number of pages -->
					 <span class="paginator_links">
					 	<?php echo $this->Paginator->counter(array('class' => 'paginator_links'));?>
					 </span>
					    </TD>
					   </tr>	
  <?php
  				 echo $this->Js->writeBuffer(); 
      } else {
  ?>
  <tr>
   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
 </table>
		</div>
		