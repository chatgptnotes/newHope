<style>
.disableLink {
    pointer-events:none;
}</style>
<?php if($datapost[0]['Note']['note_date']!='') {?>
<table width="100%" align="left" style="padding-left:10px; background:#343D40;border:1px solid #4C5E64">
<tr><td><strong><?php echo('Events') ?></strong></td></tr>
<?php 


foreach($datapost as $datap){?>

<tr><td><?php  $noteDate=$this->DateFormat->formatDate2Local($datap['Note']['note_date'],Configure::read('date_format'),true);
$disable = ($datap['Note']['sign_note'] == '1')? 'disableLink' : '';
echo $this->Html->link($noteDate, array('controller'=>'Patients','action' => 'notesadd',$notePatientId,$datap['Note']['id']),
									array('class' => $disable)
											//	array('update' => '#list_content','method'=>'post','escape'=>false,
											//		'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
											//		'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)))
		);
 ?></td>
<?php if($datap['Note']['sign_note'] == '1') {?>
	<td><?php echo $this->Html->image('icons/sign-icon.png', array('title' => 'Sign Note', 'alt'=> 'Sign Note')); ?></td>
	<?php }}?>
</tr>
</table><?php }?>