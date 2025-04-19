 <div id="doctemp_content">
<?php
  if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		<tr>
	  		<td colspan="2" align="left" class="error">
		   		<?php 
		     		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		   		?>
	  		</td>
	 </tr>
	</table>
<?php } ?>		 
	<div id="docTemplate">
		<div class="inner_title">
			<h3><?php echo __('Radiology Sub Specialty', true); ?></h3>
			<span>
<?php
 	echo $this->Html->link(__('Add Sub Specialty', true),array( 'action' => 'add_group'), array('escape' => false,'class'=>'blueBtn'));
 	echo $this->Html->link(__('Back', true),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
		</div>
	 
	 
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">		 
		   <tr class="row_title">
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('TestGroup.name', __('Group Name', true)); ?></strong></td>
		   <td class="table_cell" align="right"><strong><?php echo __('Action', true); ?></strong></td>
		  </tr>
		  <?php 
		      $cnt =0;
		      if(count($data) > 0) {
		       foreach($data as $testGroup):
		       $cnt++;
		  ?>
		   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		 <!--   <td class="row_format"><?php echo $testGroup['TestGroup']['id']; ?> </td>
		   -->
		    <td class="row_format"><?php echo  ucfirst($testGroup['TestGroup']['name']); ?> </td>
		  
		   <td align="right">
		   <?php
		   			 
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('action' => 'admin_add_group', $testGroup['TestGroup']['id']), array('escape' => false ));					
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'admin_delete_group', $testGroup['TestGroup']['id']), array('escape' => false ),"Are you sure you wish to delete ".$testGroup['TestGroup']['name']." group?");					
		   					 							
		   ?>
		  </tr>
		  <?php endforeach;  ?>
		   <tr>
		       <TD colspan="8" align="center" class="table_format" >		    
							 
							 <?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#doctemp_content',    												
		    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
							 <?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#doctemp_content',    												
		    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
							 
							 <span class="paginator_links">
							 	<?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
							 </span>
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
		      
		      echo $this->Js->writeBuffer(); 	//please do not remove 
			 
		  ?>
		  
		 </table>
	 </div>
</div>


				