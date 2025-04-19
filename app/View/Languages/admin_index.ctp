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
<h3><img src="images/appointment_icon.png" /> &nbsp; <?php echo __('Languages', true); ?></h3>
<span><input name="" type="text" class="textBoxFade"  value="Search" onfocus="javascript:if(this.value=='Search'){this.value=''; this.className='textBox';}" onblur="javascript:if(this.value==''){this.value='Search'; this.className='textBoxFade'};"/> <a href="#"><img src="images/search_icon.png" style="vertical-align:middle;" /></a></span>
</div>

	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
	 <tr>
  		<td colspan="8" align="right"><?php echo $this->Html->link(__('New Language'), array('action' => 'add')); ?></td>
 	 </tr>
	<tr>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('id');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('name');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('created_by');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('modified_by');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('created_on');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('modified_on');?></strong></td>
			<td class="table_cell"><strong><?php echo __('Actions');?></strong></td>
	</tr>
	<?php
	  $toggle =0;
      if(count($languages) > 0) {
       foreach($languages as $language): 
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
	   ?>
	
		<td class="row_format"><?php echo h($language['Language']['id']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($language['Language']['name']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($language['Language']['created_by']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($language['Language']['modified_by']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($language['Language']['created_on']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($language['Language']['modified_on']); ?>&nbsp;</td>
		
					<td ><?php 
   echo $this->Html->link($this->Form->button(__('View', true), array('type' => 'button','class' => 'blueBtn')), array('action' => 'view', $language['Language']['id']), array('escape' => false));
   ?>
   &nbsp;&nbsp;|&nbsp;&nbsp;<?php 
   echo $this->Html->link($this->Form->button(__('Edit', true), array('type' => 'button','class' => 'blueBtn')),  array('action' => 'edit', $language['Language']['id']), array('escape' => false));
   ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php 
  echo $this->Form->button(__('Delete', true), array('type' => 'button','class' => 'blueBtn' ,'onclick' => "deleteJavaScriptCode(this);",'url' =>$this->Html->url(array('action' => 'delete', $language['Language']['id']))));
   
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