<?php 
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
  ?>
   <style>
.row_action img{
float:inherit;
}
</style>
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
<h3><?php echo __('Payer'); ?></h3>		
<span><?php echo $this->Html->link(__('Add'),array('action' => 'addStandard'),array('escape' => false,'class'=>'blueBtn','title'=>'Add'));
echo $this->Html->link(__('Back'),'/tariffs/index',array('escape' => false,'class'=>'blueBtn','title'=>'Back')) ;?></span>	
 <span><?php //echo $this->Html->link(__('Back'), array('controller' => 'tariffs', 'action' => 'viewStandard'), array('escape' => false,'class'=>'blueBtn'));?></span>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('',array('action'=>'viewStandard'));?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="padding-left:19px;padding-right:20px;" >
	<tbody>					    			 				    
		<tr class="row_title">	
		<td></td>				
			<td width="10%" class="tdLabel" style="padding-left:40px;" ><label><?php echo __('Payer Name') ?> :</label></td> 
			<td width="13%" >											 
		    <?php  echo $this->Form->input('name', array('type'=>'text','id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
		  	</td> 	 		
		  	<td >
				<?php echo $this->Form->submit(__('Search'),array('label'=> false, 'name'=>'button','div' => false, 'error' => false,'class'=>'blueBtn','title'=>'Search'));?> </td>
		    <td>	<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'viewStandard'),array('escape'=>false, 'title' => 'refresh','style'=>'padding:0px 385px ;'));?>
			</td>		 
		 </tr>							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?> 
 <div class="clr inner_title" style="text-align:right;"> </div> 
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  
  <tr class="row_title">
   <!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
   -->
   <td class="table_cell tdLabel"  align="left"><strong><?php echo $this->Paginator->sort('name', __('Payer Name', true)); ?></strong></td>
    <!-- <td class="table_cell tdLabel"  align="left"><strong><?php echo $this->Paginator->sort('name', __('Payer ID', true)); ?></strong></td> -->
   <td class="table_cell tdLabel"  align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  	  $cnt =0;
      if(count($data) > 0) {
       foreach($data as $tariff): 
        $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <!--  <td class="row_format"><?php echo $tariff['TariffStandard']['id']; ?></td>
   -->
   <td class="row_format"  align="left"><?php echo ucfirst($tariff['TariffStandard']['name']); ?> </td>
   <!-- <td class="row_format"  align="left"><?php echo ucfirst($tariff['TariffStandard']['payer_id']); ?> </td> -->
   <td class="row_action"  align="left">
   <?php
  
   echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')), array('action' => 'editStandard', $tariff['TariffStandard']['id']), array('escape' => false));
   echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteStandard', $tariff['TariffStandard']['id']), array('escape' => false),__('Are you sure?', true));
  
   ?></td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
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
  ?>
  
 </table>
<script type="text/javascript">
$(document).ready(function(){	
	$('#name').focus();
	$("#name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffStandard","name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});
	/*$("#payer_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffStandard","payer_id",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});*/
});
</script>
