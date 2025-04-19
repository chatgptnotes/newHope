<style>
.row_action img{
float:inherit;
}
</style>
<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
<h3><?php echo __('Currency List'); ?></h3>			
 <span>
 	<?php
 		echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), 
 		array('escape' => false,'class'=>'blueBtn'));
 	?> 	
 </span>
</div> 
<table border="0">
	<tr id="tariff-opt-area">
		<?php       echo $this->Form->create('',array('url'=>array('action'=>'index'), 'id'=>'labfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));
		?>
		<td align="left" ><?php echo $this->Form->input('', array('name'=>'name','type'=>'text','id' => 'currency_name','style'=>'width:150px;','autocomplete'=>'off')); ?></td>
		<td align="left"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index'),array('escape'=>false, 'title' => 'refresh'));?></td>
		<?php echo $this->Form->end();?>
	</tr>
</table>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr>
  <td colspan="8" align="right">
  
  </tr>
  <tr class="row_title"> 
	   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Currency.name', __('Currency Name')); ?></strong></td>
	   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Currency.country_code', __('Country code')); ?></strong></td>
	   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Currency.currency', __('Currency')); ?></strong></td>
	   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Currency.currency_code', __('Currency Code')); ?></strong></td>
	   <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
  	 $cnt =0;
       if(count($list) > 0) {
       foreach($list as $currency): 
         $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
	   <td class="row_format" align="left""><?php echo ucfirst($currency['Currency']['name']); ?> </td>
	   <td class="row_format" align="left"><?php echo ucfirst($currency['Currency']['country_code']); ?> </td>
	   <td class="row_format" align="left"><?php echo ucfirst($currency['Currency']['currency']); ?> </td>
	   <td class="row_format"align="left"><?php echo ucfirst($currency['Currency']['currency_code']); ?> </td>
	   <td class="row_action" align="left">
		   <?php 
		   		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $currency['Currency']['id']), 
		   			 array('escape' => false,'title' => 'View', 'alt'=>'View'));
		    	echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $currency['Currency']['id']), 
		    		 array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
		   ?>
	  </td>
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
 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
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

<script>
	$(function() {
		$("#currency_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Currency","name",'no','no','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
	});
</script>