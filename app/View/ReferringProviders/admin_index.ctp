
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
<div class="inner_title">
<h3><img src="images/appointment_icon.png" /> &nbsp; <?php echo __('Referring Provider', true); ?></h3>
<span><input name="" type="text" class="textBoxFade"  value="Search" onfocus="javascript:if(this.value=='Search'){this.value=''; this.className='textBox';}" onblur="javascript:if(this.value==''){this.value='Search'; this.className='textBoxFade'};"/> <a href="#"><img src="images/search_icon.png" style="vertical-align:middle;" /></a></span>
</div>

	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
	 <tr>
  		<td colspan="8" align="right"><?php echo $this->Html->link(__('New Referring Provider'), array('action' => 'add')); ?></td>
 	 </tr>
	<tr>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('id');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('ref_provider_name');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('is_active');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('is_deleted');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('created_by');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('modified_by');?></strong></td>
		
			<td class="table_cell"><strong><?php echo __('Actions');?></strong></td>
	</tr>
	<?php
	  $toggle =0;
      if(count($referringProviders) > 0) {
       foreach($referringProviders as $referringProvider): 
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
	   ?>
		<td class="row_format"><?php echo h($referringProvider['ReferringProvider']['id']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($referringProvider['ReferringProvider']['ref_provider_name']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($referringProvider['ReferringProvider']['is_active']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($referringProvider['ReferringProvider']['is_deleted']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($referringProvider['ReferringProvider']['created_by']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($referringProvider['ReferringProvider']['modified_by']); ?>&nbsp;</td>
		
		
	<td ><?php 
   echo $this->Html->link($this->Form->button(__('View', true), array('type' => 'button','class' => 'blueBtn')), array('action' => 'view', $referringProvider['ReferringProvider']['id']), array('escape' => false));
   ?>
   &nbsp;&nbsp;|&nbsp;&nbsp;<?php 
   echo $this->Html->link($this->Form->button(__('Edit', true), array('type' => 'button','class' => 'blueBtn')),  array('action' => 'edit', $referringProvider['ReferringProvider']['id']), array('escape' => false));
   ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php 
    echo $this->Form->button(__('Delete', true), array('type' => 'button','class' => 'blueBtn' ,'onclick' => "deleteJavaScriptCode(this);",'url' =>$this->Html->url(array('action' => 'delete', $referringProvider['ReferringProvider']['id']))));
   
   ?></td>
	</tr>
<?php endforeach; ?>
	</table>
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
	
</div>