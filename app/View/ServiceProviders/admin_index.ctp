<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
<h3><?php echo __('Service Providers', true); ?></h3>
<span>
<?php echo $this->Html->link(__('Add Service Provider', true),array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <!-- <tr>
  <td colspan="8" align="right">
	  <?php 
	   		echo $this->Html->link(__('Add Service Provider', true),array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
	  ?>
  </td>
  </tr> -->
  <tr class="row_title"><!--
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
   --><td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('category', __('Category', true)); ?></strong></td>
   <td class="table_cell"align="left"><strong><?php echo $this->Paginator->sort('location', __('Address', true)); ?></strong></td>
   <td class="row_action" align="left"><strong><?php echo $this->Paginator->sort('is_active', __('Active', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
  	  $page = (isset($this->params->named['page']))?$this->params->named['page']:1 ;
  	  $srNo = ($this->params->paging[$this->Paginator->defaultModel()]['limit']) * ($page-1); 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $data):
       $cnt++;
       $srNo++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>><!--
   <td class="row_format"><?php echo $srNo; ?></td>
   --><td class="row_format" align="left"><?php echo ucfirst($data['ServiceProvider']['name']); ?> </td>
   <td class="row_format" align="left"><?php 
   
   		$options = Configure::read('service_provider_category');
   		echo ucfirst($options[$data['ServiceProvider']['category']]); 
   		
   		?> </td>
   <td class="row_format" align="left"><?php echo ucwords($data['ServiceProvider']['location']); ?> </td>
   <td class="row_action" align="left">
    <?php if($data['ServiceProvider']['status'] == 1) {
           echo __('Yes', true); 
	           $imgSrc = 'active.png';
	           $activeTitle = 'Active';
	           $status = 0;
          } else { 
           echo __('No', true);
	           $imgSrc = 'inactive.jpg';
	           $activeTitle = 'InActive';
	           $status = 1;
          }
    ?> 
   </td>
   <td class="row_action" align="left">
   <?php 
	//echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $data['ServiceProvider']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
	echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'add', $data['ServiceProvider']['id']), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
	echo $this->Html->link($this->Html->image('icons/'.$imgSrc), array('action' => 'change_status', $data['ServiceProvider']['id'],$status), array('admin'=>true,'escape' => false,'title' => $activeTitle, 'alt'=>$activeTitle));
   ?>
  
   </tr>
   
   <?php endforeach; } ?>
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
</table>