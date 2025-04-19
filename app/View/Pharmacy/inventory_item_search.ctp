
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

<?php
 	echo $this->Html->script('jquery.autocomplete_pharmacy');
 	echo $this->Html->css('jquery.autocomplete.css');

?>

<?php 
  if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php
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
	<h3> &nbsp; 
		<?php echo __('Pharmacy Management - Item List', true); ?>
		
	</h3>
	<span style="margin-top:-25px;">

	</span>
<div align="right">
<span>
 <?php
 //  echo $this->Html->link(__('Add Item'), array('action' => 'add_item'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  <?php
   echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </span>
</div>
</div>
    <form accept-charset="utf-8" method="get" id="inventory_search"  search="Search" action="<?php echo $this->Html->url(array('action' => 'search','PharmacyItem'));?>">

<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
	<tbody>

		<tr class="row_title">

			<td width="100" style="padding-left: 38px;"><label>Item Name :</label></td>

			<td >
		    	<?php
		    		 echo $this->Form->input( "name", array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>
		  	<td width="100" style="padding-left: 150px;"><label>Generic Name</label></td>
				<td>
					<?php
 				      echo $this->Form->input( "generic_name", array('id' => 'generic_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
 				?>
 				</td>

			<td  style="width:106px;"><label>Item Code :</label></td>
			<td>
		    	<?php
		    		 echo    $this->Form->input("item_code", array('type'=>'text','id' => 'item_code', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>
		  	
		  	<?php if($this->Session->read('website.instance')=="vadodara"){?>
				<td style="width: 106px;"><label>Location:</label></td>
				<td><?php
					echo  $this->Form->input("location_id", array('empty'=>'Please Select','id' => 'location_id','name'=>'location_id', 'options'=>$location,'label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
	           <?php }?>
		  	

			<td align="right" colspan="2">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));
				?>
			</td>
			<td>
 				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Pharmacy','action'=>'item_list','list','inventory'=>true),array('escape'=>false, 'title' => 'refresh'));?>
 			</td>	

		 </tr>

	</tbody>
</table>
</form>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">

  <tr class="row_title">

   <td class="table_cell"><strong><?php echo  __('Item Name', true) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Item Code', true); //echo $this->Paginator->sort('is_active', __('Pack', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Pack', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Max Order Limit', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Reorder', true); ?></strong></td>
    <!--  <td class="table_cell"><strong><?php echo __('Batch', true); ?></td>-->
   <td class="table_cell"><strong><?php echo __('Stock', true); ?></strong></td>
    <td class="table_cell"><strong><?php echo __('Loose stock', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Stock (MSU)', true); ?></strong></td>
	<?php if($this->Session->read('website.instance')=="vadodara"){?>
	<td class="table_cell"><strong><?php echo __('Location', true); ?> </strong><?php }?></td>
<td class="table_cell" style="text-align: left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $pharmacitem):
       $cnt++; 
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

    <td class="row_format"><?php echo $pharmacitem['PharmacyItem']['name']; ?> </td>
  <td class="row_format"><?php echo $pharmacitem['PharmacyItem']['item_code']; ?> </td>
  <td class="row_format"><?php echo $pack = $pharmacitem['PharmacyItem']['pack']; ?> </td>
  <td class="row_format"><?php echo $pharmacitem['PharmacyItem']['maximum']; ?> </td>
  <td class="row_format"><?php echo $pharmacitem['PharmacyItem']['reorder_level']; ?> </td>
  <!-- <td class="row_format"><?php echo $pharmacitem['PharmacyItemRate']['batch_number']; ?> </td>-->

  <td class="row_format"><?php $msu = ($pharmacitem[0]['stock'] * $pack) + $pharmacitem[0]['loose_stock'];
  				echo floor($msu/$pack); ?> </td>
  <td class="row_format"><?php echo floor($msu%$pack); ?> </td>
  <td class="row_format"><?php echo $msu; ?> </td>
  <?php if($this->Session->read('website.instance')=="vadodara"){?>
		<td class="row_format"><?php  echo $pharmacitem['Location']['name']; ?>
		</td>
		<?php }?>
   <td>
   <?php
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Insurance Type', true),'title' => __('View Product', true))), array('action' => 'view_item',  $pharmacitem['PharmacyItem']['id']), array('escape' => false));
   ?>
    <?php
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Insurance Type', true),'title' => __('Edit Product', true))),array('action' => 'edit_item', $pharmacitem['PharmacyItem']['id']), array('escape' => false));
   ?>
    <?php
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Insurance Type', true),'title' => __('Delete Product', true))), array('action' => 'item_delete', $pharmacitem['PharmacyItem']['id']), array('escape' => false),__('Are you sure?', true));

   ?>
   </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="10" align="center">
    <?php
     if($pharmacitem){
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array('PharmacyItem',"?"=>$queryStr)));}
			
    ?>
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
   <TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>


 </table>

 <script>
 $('#generic_name').live('focus',function()  {
		$(this).autocomplete(
				"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","generic","null","null","location_id", "admin" => false,"plugin"=>false)); ?>",
				{
					matchSubset:1,
					matchContains:1, 
				}
			);

		}
			);
$('#name').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","name","null","null","location_id", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,

				autoFill:true
			}
		);

	}
		);
$('#item_code').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","item_code","name","null","null","location_id", "admin" => false,"plugin"=>false)); ?>",
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
</script>