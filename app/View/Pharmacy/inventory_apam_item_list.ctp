<style>
.row_action img{float:inherit;}
.table_format {
    padding: 7px;
}
.title{
	color: #31859c;
    font-size: 15px;
    margin: 0;
    padding: 0;
}

</style>
<?php echo $this->Html->script(array('jquery.blockUI'));
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.fancybox','jquery.autocomplete.css'));
	echo $this->Html->script(array('jquery.fancybox-1.3.4', 'jquery.autocomplete_pharmacy'));
 
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



<div  class="inner_title">
 
 	<h3>
 		<?php echo __('APAM Item-List'); ?>
 	</h3>
 	 <div align="right">
 	 <span>
 	 	<?php
			echo $this->Html->link(__('Central Store'), array('controller'=>'Store',"action" => "index", "inventory" => false,'plugin' => false), array('escape' => false,'class'=>'blueBtn'));
			echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	</div>
</div>

 
 <form accept-charset="utf-8" method="get" id="inventory_search" style="padding-top: 0px;"
	search="Search" action="<?php echo $this->Html->url(array('action' => 'apam_item_list','inventory'=>true));?>">

	<table border="0" align="center" class="table_format" cellpadding="0" cellspacing="0"
		width="80%">
		<tbody>

		<tr></tr>
 			<tr class="row_title"> 

				<td width="100" style="padding-left: 150px;"><label>Item Name :</label></td>
				<td>
<?php
 				      echo $this->Form->input( "name", array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
 				?>
 				</td> 

				<td style="width: 90px;"><label>Item Code :</label></td>
				<td><?php
 				echo    $this->Form->input("item_code", array('type'=>'text','id' => 'item_code', 'label'=> false, 'div' => false, 'error' => false));
 				?>
 				</td> 
 			    
				<td align="right" colspan="2"><?php
 				echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));
 				?>
 				</td>
 				
			</tr> 
		</tbody>
	</table>
</form>


<?php

if(!isset($list)){
?>
 
<?php $website= $this->Session->read('website.instance');?>
<table border="0" align="center" class="table_format" cellpadding="0" cellspacing="0"
	width="95%" style="text-align: center;">

	<tr class="row_title">

		<td class="table_cell"><strong><?php echo  $this->Paginator->sort('PharmacyItem.name', __('Item Name')) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?></strong>
		</td>
		<td class="table_cell"><strong><?php  echo  $this->Paginator->sort('PharmacyItem.item_code', __('Item Code')) ;echo __('', true); //echo $this->Paginator->sort('is_active', __('Pack', true)); ?></strong>
		</td>
		<td class="table_cell"><strong><?php echo __('Pack', true); ?></strong>
		</td>
		<td class="table_cell"><strong><?php echo  $this->Paginator->sort('PharmacyItem.stock', __('Stock'));?></strong>
		</td>
		<td class="table_cell"><strong><?php echo __('Stock (MSU)');?></strong>
		</td> 
		</td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?></strong>
		</td>
	</tr>
	<?php
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $pharmacitem):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

		<td class="row_format"><?php echo $pharmacitem['PharmacyItem']['name']; ?>
		</td>
		<td class="row_format"><?php echo $pharmacitem['PharmacyItem']['item_code']; ?>
		</td>

		<td class="row_format"><?php echo $pack = $pharmacitem['PharmacyItem']['pack']; ?>
		</td>
		<td class="row_format"><?php echo $pharmacitem['PharmacyItem']['stock']; ?>
		</td>
		<td class="row_format"><?php echo (int)$pack * $pharmacitem['PharmacyItem']['stock'] + $pharmacitem['PharmacyItem']['loose_stock']; ?>
		</td>
		<td class="row_action"><?php
			$pharId = $pharmacitem['PharmacyItem']['id'];
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Item', true),'title' => __('View Item', true),'onclick'=>"showItem($pharId)")), 'javascript:void(0);', array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Item', true),'title' => __('Edit Item', true))),array('action' => 'edit_item', $pharmacitem['PharmacyItem']['id'], "apam"), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Item', true),'title' => __('Delete Item', true))), array('action' => 'item_delete', $pharmacitem['PharmacyItem']['id'], "apam"), array('escape' => false),__('Are you sure?', true));

		?>
		</td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="10" align="center">
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
	$("#search").click(function(){
			window.location.href = "<?php echo $this->Html->url(array('action'=>'item_list')); ?>";
		});
</script>
<?php
    } 
    ?>
 

<script>
$('#name').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","name","null","null","no","location_id=$locationid", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1, 
			}
		);

	}
		);
$('#item_code').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","item_code","null","null","null", "admin" => false,"plugin"=>false)); ?>",
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

	function showItem(itemId){
  		$.fancybox(
			    {
			    	'autoDimensions':false,
			    	'width'    : '85%',
				    'height'   : '90%',
				    'autoScale': true,
				    'transitionIn': 'fade',
				    'transitionOut': 'fade',						    
				    'type': 'iframe',
				    'href': '<?php echo $this->Html->url(array( "action" => "view_item",'inventory'=>true)); ?>'+"/"+itemId+"/fromFancy",
			});
  	}
</script> 