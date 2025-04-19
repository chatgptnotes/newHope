<style>.row_action img{float:inherit;}
.inner_title{
	padding-bottom: 0px;
}
.table_format {
    padding: 10px;
}
</style>

<?php
//echo $this->Html->script('jquery.autocomplete_pharmacy');
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');

?>

<?php 
if(!empty($errors)) {
	?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>


<div class="inner_title">
<?php echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy')); ?>
	<h3>
		&nbsp;
		<?php echo __('Pharmacy Management -Item Rate', true); ?>
	</h3>
	<span> <?php 
	
	//echo $this->Html->link(__('Add Item Rate'), array('controller'=>'Pharmacy','action' => 'item_rate_master','inventory'=>true), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 10px;'));
	echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'index','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	?>

	</span>

</div>
<div class="btns">
	<?php 
	echo $this->Html->link(__('Search Supplier'), array('action' => 'search','InventorySupplier'), array('escape' => false,'class'=>'blueBtn'));
	?>
	
</div>

<?php echo $this->Form->create('',array('url' => array('action' => 'view_item_rate'),'id'=>'content-form','type'=>'GET'));?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center"
		width="80%">
		<tbody>

			<tr class="row_title">

				<td width="100" style="padding-left: 38px;"><label>Item Name :</label></td>
				<td><?php
				      echo $this->Form->input( "name", array('type'=>'text','id' => 'name', 'name'=>'name','label'=> false, 'value'=>$this->params->data['name'] ,'div' => false, 'error' => false,'autocomplete'=>false));
				?>
				</td>
				<td style="width: 106px;"><label>Item Code :</label></td>
				<td><?php
					echo  $this->Form->input("item_code", array('type'=>'text','id' => 'item_code','name'=>'item_code', 'value'=>$this->params->data['item_code'],'label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
				<?php if($this->Session->read('website.instance')=="vadodara"){?>
				<td style="width: 106px;"><label>Location:</label></td>
				<td><?php
					echo  $this->Form->input("location_id", array('empty'=>'Please Select','id' => 'location_id','name'=>'location_id', 'options'=>$location,'label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
	           <?php }?>
				<td align="right" colspan="2"><?php
				echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));
				?>
				</td>
				<td>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Pharmacy','action'=>'view_item_rate'),array('escape'=>false, 'title' => 'refresh'));?>
				</td>


			</tr>

		</tbody>
	</table>
	<?php echo $this->Form->end();?>

<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center"
	width="95%" style="text-align: center;">

	<tr class="row_title">

		<td class="table_cell"><strong><?php echo __('Item Name') ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?></td>
		<td class="table_cell"><strong><?php  echo __('Item Code') ;echo __('', true); //echo $this->Paginator->sort('is_active', __('Pack', true)); ?></td>
		<td class="table_cell"><strong><?php echo __('Pack.', true); ?></td>
		<td class="table_cell"><strong><?php echo __('Batch No.', true); ?></td>
		<td class="table_cell"><strong><?php echo __('Expiry Date', true); ?></td>
		<td class="table_cell"><strong><?php echo __('Pur.Price');?></td>
		<td class="table_cell"><strong><?php echo __('MRP', true); ?></td>
		<td class="table_cell"><strong><?php echo __('SalePrice', true); ?></td>
		<td class="table_cell"><strong><?php echo __('Stock', true); ?></td>
		<td class="table_cell"><strong><?php echo __('Loose', true); ?></td>
		<td class="table_cell"><strong><?php echo __('Tab/Unit', true); ?></td>
		<?php if($this->Session->read('website.instance')=="kanpur"){?>
		<td class="table_cell"><strong><?php echo __('Vat Of Class', true); ?></td>
		<?php } ?>
		<?php if($this->Session->read('website.instance')=="vadodara"){?>
		<td class="table_cell"><strong><?php echo __('Location', true); ?></td>
		<?php }?>
		<td class="table_cell"><strong><?php echo __('Action', true); ?></td>
	</tr>
	
	<?php 
		$i=0;
		
		if(count($itemDetails) > 0) {
		foreach($itemDetails as $details):
			$i++; 
	?>
	<tr <?php if($i%2 == 0) echo "class='row_gray'"; ?>>
		
		<td class="row_format"><?php echo $details['PharmacyItem']['name']; ?></td>
		<td class="row_format"><?php echo $details['PharmacyItem']['item_code']; ?></td>
		<td class="row_format"><?php echo $details['PharmacyItem']['pack']; ?></td>
		<td class="row_format"><?php echo $details['PharmacyItemRate']['batch_number']; ?></td>
		<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($details['PharmacyItemRate']['expiry_date'],Configure::read('date_format'),true); ?></td>
		<td class="row_format"><?php echo $details['PharmacyItemRate']['purchase_price']; ?></td>
		<td class="row_format"><?php echo $details['PharmacyItemRate']['mrp']; ?></td>
		<td class="row_format"><?php echo $details['PharmacyItemRate']['sale_price']; ?></td>
		<td class="row_format"><?php echo $details['PharmacyItemRate']['stock']; ?></td>
		<td class="row_format"><?php echo !empty($details['PharmacyItemRate']['loose_stock'])?$details['PharmacyItemRate']['loose_stock']:0; ?></td>
		<td class="row_format"><?php echo ((int)$details['PharmacyItem']['pack'] * $details['PharmacyItemRate']['stock']) + $details['PharmacyItemRate']['loose_stock']; ?></td>
		<?php if($this->Session->read('website.instance')=="kanpur"){
				if(empty($details['PharmacyItemRate']['vat_class_name'])){
			?>
			<td class="row_format"><?php echo "0"; ?></td>
		<?php }else{ ?>
		<td class="row_format"><?php echo $details['PharmacyItemRate']['vat_class_name']; ?></td>
		<?php 	}
			} ?> 
		<?php if($this->Session->read('website.instance')=="vadodara"){?>
		<td class="row_format"><?php echo $details['Location']['name']; ?></td>
		<?php }?>
		<td class="row_action">
		<?php 
			echo $this->Html->link($this->Html->image('icons/view-icon.png', 
					array('alt' => __('View Item', true),'title' => __('View Item', true))), array('controller'=>'Pharmacy','action' => 'view_rate',  $details['PharmacyItemRate']['id']), array('escape' => false));
			
			echo $this->Html->link($this->Html->image('icons/edit-icon.png', 
					array('alt' => __('Edit Item', true),'title' => __('Edit Item', true))),array('controller'=>'Pharmacy','action' => 'edit_item_rate', $details['PharmacyItemRate']['id']), array('escape' => false));
			
			echo $this->Html->link($this->Html->image('icons/delete-icon.png', 
					array('alt' => __('Delete Item', true),'title' => __('Delete Item', true))), array('controller'=>'Pharmacy','action' => 'itemRate_delete', $details['PharmacyItemRate']['id']), array('escape' => false),__('Are you sure?', true));
		?>
		</td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="10" align="center">
			<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				  $this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
			?>
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
		</span>
		</TD>
	</tr>
	<?php
         } else {
  ?>
	<tr>
		<TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
	
</table>


<script>

$('#name').live('focus',function()  {
	$(this).autocomplete(
			"<?php 
			if($this->Session->read('website.instance')=='vadodara'){
				$locationSearch = "no";
			}else{	
				$locationSearch = "";	
    		}
			echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","name","null","null",$locationSearch,"admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,

				//autoFill:true
			}
		);

	}
		);
$('#item_code').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","item_code", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,

				//autoFill:true
			}
		);

	}
		);

</script>

