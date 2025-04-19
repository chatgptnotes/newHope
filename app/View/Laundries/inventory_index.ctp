
<style>.row_action img{float:inherit;}</style>
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
<h3>&nbsp; <?php echo __('Room Items Management', true); ?></h3>
<span><?php 
   echo $this->Html->link(__('Allot Item'),array('action' => 'add'),array('escape' => false,'class'=>'blueBtn')); 
  echo $this->Html->link(__('Laundry Manager'),array('controller'=>'laundries','action' => 'manager','inventory'=>true),array('escape' => false,'class'=>'blueBtn')); ?></span>

</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  
  </td>
  
  </tr>
  <tr class="row_title">
    <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Sr. No', __('Sr. No', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Room_id', __('Room', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('item_code', __('Item Code', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('quantity', __('Quantity', true)); ?></strong></td>
   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('min_quantity', __('Min.Qty.', true)); ?></strong></td> -->
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('created_by', __('Created By', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  	  $cnt =0;
      if(count($data) > 0) {
       foreach($data as $item): 
        $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format" align="left"><?php echo $cnt; ?></td>
   <td class="row_format" align="left">
	<?php 
	  $ward = ClassRegistry::init('Ward')->field('name',array('Ward.id'=>$item['InventoryLaundry']['ward_id']));
	  echo $ward; 
	?>
   </td>
   <td class="row_format" align="left"><?php echo $item['InventoryLaundry']['item_code']; ?></td>
   <td class="row_format" align="left"><?php echo ucfirst($item['InventoryLaundry']['name']); ?> </td>
   <td class="row_format" align="left"><?php echo ucfirst($item['InventoryLaundry']['quantity']); ?> </td>
   <!-- <td class="row_format"><?php echo ucfirst($item['InventoryLaundry']['min_quantity']); ?> </td> -->
   <td class="row_format" align="left"><?php echo ($item['User']['first_name']=='')?__('Admin'):ucfirst($item['User']['first_name'])." ".ucfirst($item['User']['last_name']); ?> </td>
   
   <td class="row_action" align="left">
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $item['InventoryLaundry']['id']), array('escape' => false));
	
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $item['InventoryLaundry']['id']), array('escape' => false));
  
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $item['InventoryLaundry']['id']), array('escape' => false),__('Are you sure?', true));
   
   ?></td>
  </tr>
  <?php endforeach;  ?>
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
<?php if($this->params['paging']['InventoryLaundry']['pageCount'] > 1) {?>
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
  <?php
		}
      } else {
  ?>
  <tr>
   <td colspan="8" align="center"><?php echo __('No record found', true); ?>.</td>
  </tr>
  <?php
      }
  ?>
  
 </table>
 <table align="right">
	<tr>
	 
	   <!--<td colspan="8" align="right">
		
		  <?php 
		   echo $this->Html->link(__('Get Report'),array('controller'=>'laundries','action' => 'laundry_report','inventory'=>true),array('escape' => false,'class'=>'blueBtn')); 
		  ?>
		</td>
		<td colspan="8" align="right">
		  <?php 
		   echo $this->Html->link(__('Laundry Manager'),array('controller'=>'laundries','action' => 'manager','inventory'=>true),array('escape' => false,'class'=>'blueBtn')); 
		  ?>
		</td>-->		
  </tr>
 </table>
 <script>
	$(function() {
		$("#from").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',			
		});	
			
	 $("#to").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',			
		});
	});	
</script>


