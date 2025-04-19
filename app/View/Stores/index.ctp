<style>
.row_action img{float:inherit;}</style>
<?php 
    echo $this->Html->script(array('jquery.blockUI'));
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
	echo $this->Html->script(array('jquery.fancybox-1.3.4'));

	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
 
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
<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
	<h3>
		&nbsp;
		<?php echo __('Product Lists', true); ?>
	</h3>
	<span style="margin-top: -25px;"> </span>

	<div align="right">
	<span>
		<?php 
		if(strtolower($this->Session->read('website.instance'))== "vadodara"){
			echo $this->Html->link(__('APAM List'),array('controller'=>'Pharmacy','action'=>'apam_item_list','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
		} 
		echo $this->Html->link(__('Add Item'),array('action'=>'addProduct'), array('escape' => false,'class'=>'blueBtn'));
		echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'department_store'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	</div>
</div>

<?php echo $this->Form->create('',array('url' => array('action' => 'index'),'id'=>'content-form','type'=>'GET'));?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
 			<tr class="row_title">
				<td width="100px" ><label>Item Name :</label></td>
				<td><?php
				
				      echo $this->Form->input( "name", array('type'=>'text','id' => 'name', 'name'=>'name','label'=> false, 'value'=>$this->params->data['name'] ,'div' => false, 'error' => false,'autocomplete'=>false));
				?>
				</td>

				<td style="width: 106px;"><label>Manufacturer :</label></td>
				<td><?php
					echo  $this->Form->input("manufacturer", array('type'=>'text','id' => 'manufacturer','name'=>'manufacturer', 'value'=>$this->params->data['manufacturer'],'label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
				
				<td style="width: 106px;"><label>Service Provider :</label></td>
				<td><?php
					echo  $this->Form->input("supplier_name", array('type'=>'text','id' => 'supplier_name','name'=>'supplier_name', 'value'=>$this->params->data['supplier_name'],'label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
	
				<td align="right" colspan="2"><?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));
				?>
				</td>
				<td>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Store','action'=>'index'),array('escape'=>false, 'title' => 'refresh'));?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php echo $this->Form->end();?>


<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">

	<tr class="row_title">
		<td class="table_cell"><strong><?php echo  __('Sr.no') ;  ?>
		</td>
		<td class="table_cell"><strong><?php echo  __('Item Name') ;  ?>
		</td>
		
		<td class="table_cell"><strong><?php echo  __('Pack') ;  ?>
		</td>
		
		<td class="table_cell"><strong><?php echo  __('Stock');?>
		</td>
		
		<td class="table_cell"><strong><?php echo  __('Stock in (MSU)');?>
		</td>
		
		<td class="table_cell"><strong><?php echo  __('Manufacturer');?>
		</td>

		<td class="table_cell"><strong><?php echo  __('Service Provider', true); ?>
		</td>		
		
		<td class="table_cell"><strong><?php echo  __('Action', true); ?>
		</td>
	</tr>
	<?php 
	$srno=$this->params->paging['Product']['limit']*($this->params->paging['Product']['page']-1);
	$count = 0;
	foreach($results as $result)
	{	$srno++;
		$count++;  ?>
	<tr <?php if($count%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format">
				<?php echo $srno;?>
		</td>
		<td class="row_format">
			<?php echo ucfirst($result['Product']['name']);?>
		</td>
		
		<td class="row_format"> 
			<?php echo $pack = (!empty($result['Product']['pack'])) ? $result['Product']['pack']:1;?>
		</td>
		
		<td class="row_format">
			<?php echo !empty($result['Product']['quantity'])?$result['Product']['quantity']:0;?>
		</td>
				
		<td class="row_format">
			<?php echo $result['Product']['quantity'] * $pack + $result['Product']['loose_stock'];?>
		</td>
		
		<td class="row_format">
			<?php echo $result['ManufacturerCompany']['name'];?>
		</td>
		
		<td class="row_format">
			<?php echo $result['Product']['supplier_name'];?>
		</td>
		
		<td class="row_action"><?php
		//echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Item', true),'title' => __('View Item', true))),array('action'=>'viewProduct',$result['Product']['id']), array('escape' => false));
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Item', true), 'patientId'=>$result['Product']['id'],'id'=>'viewProduct','class'=>'viewProduct' ,'title' => __('View Item', true))),'javascript:void(0);', array('escape' => false));
		?> <?php 
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Item', true),'title' => __('Edit Item', true))),array('action'=>'editProduct',$result['Product']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Item', true),'title' => __('Delete Item', true))),array('action'=>'delete',$result['Product']['id']), array('escape' => false),__('Are you sure?', true));

		?>
		</td>
	</tr>
	<?php }?>
	
</table>

<table width="100%">
	<tr>
		<td colspan="4" align="center">
			<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				  $this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
			?>
			<?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     		<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
    		<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
     		<span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
		</td>
	</tr>
</table>

<script>
	$("#search").click(function(){
			window.location.href = "<?php echo $this->Html->url(array('action'=>'item_list')); ?>";
		});

$('#name').live('focus',function() {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Product","name", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,
 
			});

	});


$('#manufacturer').live('focus',function() {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","ManufacturerCompany","name", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,

				autoFill:true
			});

	});


$('#supplier_name').live('focus',function() {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","InventorySupplier","name", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,

				autoFill:true
			});

	});

$('#item_code').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","item_code", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,
				autoFill:true
			}
		);

	}
		);
	$("#list").click(function(){
			window.location.href = "<?php echo $this->Html->url(array('action'=>'item_list','list')); ?>";
		});

	$(".viewProduct").click(function(){ 
		var patientId = $(this).attr('patientId');
		 $.fancybox({ 
			 	'width' : '80%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':true,
				'showCloseButton':true,
				'onClosed':function(){
				},
				'href' : "<?php echo $this->Html->url(array("controller" =>"Store","action" =>"viewProduct","admin"=>false)); ?>"+'/'+patientId,
		 });
		 $(document).scrollTop(0);
	 });
</script>
