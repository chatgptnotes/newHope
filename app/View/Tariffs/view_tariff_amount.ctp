<style>
.row_action img {
	float: inherit;
}
</style>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
				foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
			</div>
		</td>
	</tr>
</table>
<?php } ?>
<div class="inner_title">
	<h3>
		<?php echo __($title_for_layout, true); ?>
	</h3>

	<div style="float: right; margin: -18px 0 0;">
		<?php 
		if(!$this->params->query['fromPackage'])//gaurav
			echo $this->Html->link(__('Back'),array('controller' => 'tariffs', 'action' => 'index'),array('escape' => false,'class'=>'blueBtn','title'=>'Back')) ;
		else
			echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master'),'admin'=>true), array('escape' => false,'class'=>'blueBtn'));
		?>
	</div>
	<span><?php //echo $this->Html->link(__('Back'), array('controller' => 'tariffs', 'action' => 'viewStandard'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('',array('url'=>array('action'=>'viewTariffAmount','?'=>$this->params->query)));?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center" style="padding-left: 19px; padding-right: 20px;">
	<tbody>
		<tr class="row_title">
			<td></td>
			<td width="10%" class="tdLabel" style="padding-left: 40px;"><label><?php echo __('Payer Name') ?>
					:</label></td>
			<td width="13%"><?php  echo $this->Form->input('name', array('type'=>'text','id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->submit(__('Search'),array('label'=> false, 'name'=>'button','div' => false, 'error' => false,'class'=>'blueBtn','title'=>'Search'));?>
			</td>
			<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'viewTariffAmount','?'=>$this->params->query),array('escape'=>false, 'title' => 'refresh','style'=>'padding:0px 385px ;'));?>
			</td>
		</tr>
	</tbody>
</table>

</div>

<table class="table_format" border="0" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<tr>
		<td colspan="8" align="right">
	
	</tr>
	</td>

	</tr>
	<tr class="row_title">
		<!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
   -->
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?>
		</strong></td>
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
		<td class="row_format" align="left"><?php echo ucfirst($tariff['TariffStandard']['name']); ?>
		</td>
		<td class="row_action" align="left"><?php
		if($this->params->query['fromPackage']){//gaurav
			echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')), array('controller'=>'Estimates','action' => 'packageMaster', $tariff['TariffStandard']['id']), array('escape' => false));
		}else{
			echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')), array('action' => 'tariffListOptions', $tariff['TariffStandard']['id']), array('escape' => false));
			echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteStandard', $tariff['TariffStandard']['id']), array('escape' => false),__('Are you sure?', true));
		}

	?></td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
		</span>
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
<!--  <script type="text/javascript">
$(document).ready(function(){	
	$('#name').focus();
	$("#name").autocomplete("<?php //echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","viewTariffAmount","name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});
});-->
<script type="text/javascript">


$('#name').autocomplete({	
	   
	 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","TariffStandard","name","null","no","null",
                							"admin" => false,"plugin"=>false)); ?>",
   minLength: 1,
	select: function( event, ui ) { 
		var name_id = ui.item.id;
		//alert( name_id);
		//send ajax request to fetch patient admission id
		/*$.ajax({
		      url: "<?php// echo $this->Html->url(array("controller" => 'tafiff', "action" => "viewTariffAmount", "admin" => false)); ?>"+"/"+name_id,
		      context: document.body,          
		      success: function(data){ 
		     
		      }
		    });*/
	
		}, 
		 messages: {
                   noResults: '',
                   results: function() {}
                   }
	
      
});
</script>
