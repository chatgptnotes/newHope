<div class="inner_title">
	<h3>
		<?php echo __($title_for_layout, true); ?>
	</h3>
	<span> <?php

	echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('Note Date', true); ?>
		</strong>
		</td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
		       foreach($data as $noteAry):
		       $cnt++;
		       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($noteAry['Note']['create_time'],Configure::read('date_format'),true);?>
		</td>
		<td><?php echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),'alt'=> __('View', true))),
				 array('controller'=>'Notes','action' => 'clinicalNote',$noteAry['Note']['patient_id'],$noteAry['Appointment']['id'], $noteAry['Note']['id']), array('escape' => false ));
		?>
		</td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="8" align="center" class="table_format"><?php 
		$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
		echo $this->Paginator->counter(array('class' => 'paginator_links'));
		echo $this->Paginator->prev(__('« Previous', true), array(/*'update'=>'#doctemp_content',*/
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

			<?php 
			echo $this->Paginator->numbers(); ?> <?php echo $this->Paginator->next(__('Next »', true), array(/*'update'=>'#doctemp_content',*/
							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

			<span class="paginator_links"> </span>
		</TD>
	</tr>
	<?php
 			} else {
		  	?>
	<tr>
		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php }
	echo $this->Js->writeBuffer(); 	//please do not remove
	?>
</table>
