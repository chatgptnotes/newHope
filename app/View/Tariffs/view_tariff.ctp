<style>
.row_action img{
float:inherit;
}
</style>
<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
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
<h3><?php echo __('Services'); ?></h3>			
 
 <span>
 		<?php 
					 		echo $this->Html->link(__('Add Service'),array('action' => 'addTariff'),array('escape' => false,'class'=>'blueBtn'));
                           	echo $this->Html->link(__('Back'),'/tariffs/index',array('escape' => false,'class'=>'blueBtn')) ;
		?>		
 </span>
</div>
<div class="btns">
               	
</div>
<table>
	<tr>
		<?php   echo $this->Form->create('',array('url'=>array('action'=>'viewTariff'),'type'=>'get','id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));
		?>
		
		
		<!-- <td align="left" ><?php $code_option = array(''=>'Please select','CPT'=>'CPT','Custom Code'=>'Custom Code','HCPCS'=>'HCPCS','ICD9'=>'ICD9','ICD10PCS'=>'ICD10PCS','NDC'=>'NDC');     
	echo $this->Form->input('', array('name'=>'code_type','type'=>'select','class' => 'validate[required,custom[mandatory-select]] codeType','options' => $code_option, 'id' => 'code_type', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?></td> --> 
		<td class="" style="padding-left: 5px;"><?php echo __('Service Name') ?> :</td>	
		<td align="left" ><?php echo $this->Form->input('', array('name'=>'service_name','type'=>'text','id' => 'search_service_name','style'=>'width:150px;','autocomplete'=>'off','value'=>$this->params->query['service_name'])); ?></td>
		<td class=""><?php echo __('Service Group') ?> :</td>		
			<td class="">											 
		    	<?php echo $this->Form->input('', array('name'=>'service_group','id' => 'service_group', 'label'=> false, 'div' => false,'type'=> 'text', 'error' => false,'autocomplete'=>false,'value'=>$this->params->query['service_group']));?>
		  		<?php echo $this->Form->hidden('',array('id'=>'groupServiceId','name'=>'groupServiceId'));?>
		  
		  	</td>
		  	
		  	<td class=""><?php echo __('Service Sub Group') ?> :</td>		
			<td class="">											 
		    	<?php echo $this->Form->input('', array('name'=>'service_sub_group','id' => 'service_sub_group', 'label'=> false, 'div' => false,'type'=> 'text', 'error' => false,'autocomplete'=>false,'value'=>$this->params->query['service_sub_group']));?>
		  		<?php echo $this->Form->hidden('',array('id'=>'groupServiceSubId','name'=>'groupServiceSubId'));?>
		  	</td>
		<td align="left"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'viewTariff'),array('escape'=>false));?></td>
		<?php echo $this->Form->end();?>
	</tr>
</table>
<?php
     if($data){
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			}
			?>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr class="row_title">
  <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Sr. No.', true)); ?></strong></td>  
  <td class="table_cell"  align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
  <td class="table_cell"  align="left"><strong><?php echo $this->Paginator->sort('service_category_id', __('Service Group', true)); ?></strong></td>
  <td class="table_cell"  align="left"><strong><?php echo $this->Paginator->sort('service_sub_category_id', __('Service Sub Group', true)); ?></strong></td>
  <!--
  <td class="table_cell"  align="left"><strong><?php echo $this->Paginator->sort('cghs_nabh', __('NABH Code', true)); ?></strong></td>
  <td class="table_cell"  align="left"><strong><?php echo $this->Paginator->sort('cghs_non_nabh', __('Non NABH Code', true)); ?></strong></td>
   -->
   <td class="table_cell"  align="left"><strong><?php echo $this->Paginator->sort('cghs_code', __('CGHS Code', true)); ?></strong></td>
  <td class="table_cell"  align="left"><strong><?php echo $this->Paginator->sort('apply_in_a_day', __('Apply in a Day', true)); ?></strong></td>
   <td class="table_cell" style="width:10%"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
   
  
  	  $cnt =(!empty($this->params->named['page'])?10*($this->params->named['page']-1):0);
      if(count($data) > 0) {
      foreach($data as $tariff){
        $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
  <td class="row_format"><?php echo $cnt; ?></td>
  
   <td class="row_format"  align="left"><?php echo mb_convert_encoding($tariff['TariffList']['name'], 'HTML-ENTITIES', 'UTF-8'); ?> </td>
   <td class="row_format"  align="left"><?php echo ucwords(strtolower($tariff['ServiceCategory']['alias'])); ?> </td>   
   <td class="row_format"  align="left"><?php echo ucwords(strtolower($tariff['ServiceSubCategory']['name'])); ?> </td>
   <!-- 
   <td class="row_format"  align="left"><?php echo ucfirst($tariff['TariffList']['cghs_nabh']); ?> </td>
   <td class="row_format"  align="left"><?php echo ucfirst($tariff['TariffList']['cghs_non_nabh']); ?> </td>
    -->
    <td class="row_format"  align="left"><?php echo ucfirst($tariff['TariffList']['cghs_code']); ?> </td>
    <td class="row_format" align="left" ><?php echo ($tariff['TariffList']['apply_in_a_day']); ?> </td>
   <td class="row_action">
   <?php 
   if($tariff['TariffList']['location_id']!= 0){
	   echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')), array('action' => 'editTariff', $tariff['TariffList']['id']), array('escape' => false));
	  
	   echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteTariff', $tariff['TariffList']['id']), array('escape' => false),__('Are you sure?', true));
   } 
   ?></td>
  </tr>
  <?php } ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
   <?php
     if($tariff){
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			}
			?>
		 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
		 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
		 <!-- Shows the next and previous links --> 
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
 
<script>
	$(function() {
		$("#search_service_name").autocomplete("<?php echo $this->Html->url(array("controller" => "tariffs", "action" => "autocomplete","TariffList","name",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
		
		$("#service_group").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","ServiceCategory","id",'alias','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			loadId : 'name,groupServiceId',
			showNoId:true,
			valueSelected:true,
			
			});
			
		$("#service_sub_group").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","ServiceSubCategory","id",'name','null','null','null','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			loadId : 'name,groupServiceSubId',
			showNoId:true,
			valueSelected:true,
			});
	});
</script>  