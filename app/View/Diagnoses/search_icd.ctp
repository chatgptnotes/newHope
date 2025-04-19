<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
<h3><?php echo __('ICD Management', true); ?></h3>
<span>
<?php
 	echo $this->Html->link(__('Laboratory Sub Speciality', true),array('action' => 'view_groups'), array('admin'=>true,'escape' => false,'class'=>'blueBtn'));
 		echo $this->Html->link(__('Add Diagnoses', true),array('controller' => 'diagnoses','action' => 'icd_add'), array('escape' => false,'class'=>'blueBtn'));
 		echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
  <table border="0">
	<tr id="tariff-opt-area">
		<?php       echo $this->Form->create('',array('url'=>array('action'=>'search_icd', 'admin' => false), 'id'=>'labfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));
		?>
		<td align="left" ><?php echo $this->Form->input('', array('name'=>'sctName','type'=>'text','id' => 'sct_Name','style'=>'width:150px;','autocomplete'=>'off')); ?></td>
		<td align="left"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'search_icd', 'admin' => false),array('escape'=>false, 'title' => 'refresh'));?></td>
		<?php echo $this->Form->end();?>
	</tr>
	
</table>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="8" align="right">
  <?php 
   
   ?>
   <?php 
   
   ?>
  </td>
  </tr>
  <tr class="row_title">
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('is_active', __('Active', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  
  
  <?php	
  	 //debug($testData);
  	  $page = (isset($this->params->named['page']))?$this->params->named['page']:1 ;
    $srNo = ($this->params->paging[$this->Paginator->defaultModel()]['limit']) * ($page-1); 	
      $cnt =0;
      if(count($testData) > 0) {
       foreach($testData as $data):
       $cnt++;
       $srNo++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"><?php echo $srNo; ?></td>
   <td class="row_format"><?php echo $data['SnomedMappingMaster']['sctName']; ?> </td>
   <td class="row_format">
    <?php if($data['SnomedMappingMaster']['is_active'] == 1) {
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
   <td>
	   <?php 
	  
			echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'icd_edit', $data['SnomedMappingMaster']['id']), 
				array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
			echo $this->Html->link($this->Html->image('icons/'.$imgSrc), array('action' => 'icd_change_status', $data['SnomedMappingMaster']['id'],$status), 
				array('escape' => false,'title' => $activeTitle, 'alt'=>$activeTitle));
			/*echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $data['Laboratory']['id']), 
				array('escape' => false,'title' => 'View', 'alt'=>'View'));*/
			echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'icd_delete', $data['SnomedMappingMaster']['id']), 
				 array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
	   ?>
  	</td>
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
<script>
$("#sct_Name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","SnomedMappingMaster","sctName",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	
	
});


	   
</script>