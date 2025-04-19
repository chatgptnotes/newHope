<div class="inner_left" id="list_content">
	<div class="inner_title">
		<div style="float: left">
			<h3>
				<?php echo __('Extra Notes'); ?>
			</h3>
		</div>
		<div style="text-align: right;">
			<?php  
			echo $this->Html->link(__('Add Note'), array('controller'=>'patients','action' => 'extraNotes', $patientId),
				 array('onclick'=>"return confirm('Do you wish to add new note?');",'escape' => false,'class'=>'blueBtn'));
			?>
		</div>
	</div>
	<?php echo $this->element('patient_information');?>
	<div class="patient_info"></div>
	<div class="patient_info" id="addNote">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr class="row_title">
							<td class="table_cell"><strong> <?php echo __('Created Time', true); ?>
							</strong>
							</td>
							<td class="table_cell"><strong> <?php echo __('Action', true); ?>
							</strong>
							</td>
						</tr>
						<?php 
						if(!empty($noteList)) {
							$toggle =0;
							$i=0 ;
							foreach($noteList as $data){
								if($toggle == 0) {
							       	echo "<tr class='row_gray'>";
							       	$toggle = 1;
						       }else{
							       	echo "<tr>";
							       	$toggle = 0;
						       }
						       ?>
						<td class="row_format"><?php 
							echo $this->DateFormat->formatDate2Local($data['Note']['note_date'],Configure::read('date_format'),true);?>
						</td>
						<td><?php  if($data[Note][sign_note]== '1'){ 
							$dispSign = 'block';$dispUnSign = 'none';
						}else{ $dispSign = 'none';$dispUnSign = 'block';
						}?> <span class="signTrue<?php echo $data['Note']['id'];?>" style="display: <?php echo $dispSign;?>">
								<?php 	echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title' => 'View Note', 'alt'=> 'Note View')), array('action' => 'viewExtraNotes',
										$patientId,$data['Note']['id']), array('escape'=>false));
								?> <a
								href="javascript:sign('<?php echo $patientId;  ?>','<?php echo '0'; ?>','<?php echo $data['Note']['id']; ?>') "
								onclick="return confirm('Do you want to unsign note?');"
								style="color: #000; text-decoration: none;"><?php echo $this->Html->image('icons/sign-icon.png', array('title' => 'UnSign Note', 'alt'=> 'UnSign Note')); ?>
							</a>
							</span> <?php  ?> <span class="signFalse<?php echo $data['Note']['id'];?>" style="display: <?php echo $dispUnSign;?>">
								<?php 	echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => 'Edit Note', 'alt'=> 'View')),
										array('action' => 'extraNotes',$patientId,$data['Note']['id']),
										array('escape'=>false));
							  ?> <?php $role = $this->Session->read('role');
							  ?> <a
								href="javascript:sign('<?php echo $patientId;  ?>','<?php echo '1'; ?>','<?php echo $data['Note']['id']; ?>') "
								onclick="return confirm('Notes once get signed will not be edited further..');"
								style="color: #000; text-decoration: none;"> <?php echo $this->Html->image('icons/unlock.png', array('title' => 'Sign Note', 'alt'=> 'Sign Note')); ?>
							</a>

						</span>
						</td>
						</tr>

						<?php		$i++ ;  
							}    ?>
						<tr>
							<TD colspan="8" align="center">
								<!-- Shows the page numbers --> <!-- Shows the next and previous links -->
								<?php  echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#list_content',    												
										'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    											'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
								<?php  echo $this->Paginator->next(__('Next »', true), array('update'=>'#list_content',    												
										'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    											'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
								<!-- prints X of Y, where X is current page and Y is number of pages -->
								<span class="paginator_links"> <?php  echo $this->Paginator->counter(array('class' => 'paginator_links'));?>
							</span>
							</TD>
						</tr>
						<?php echo $this->Js->writeBuffer();
						      } else {
						  ?>
						<tr>
							<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.
							</TD>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
<script>
function sign(patientId, signNote, noteId) {
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "signNote")); ?>"
			+ '/' +  signNote + '/' + noteId;
	$.ajax({
		type: 'POST',
		url: ajaxUrl,
		dataType: 'html',
 		success: function(data){
     		if(signNote == 1){
     			$('.signFalse'+noteId).hide();
     			$('.signTrue'+noteId).show();
     		}else{
     			$('.signTrue'+noteId).hide();
     			$('.signFalse'+noteId).show();
     		}
     	}
	});
			
}
</script>
